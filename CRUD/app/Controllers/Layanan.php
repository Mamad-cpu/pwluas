<?php

namespace App\Controllers;

use App\Models\LayananModel;
use Dompdf\Dompdf;

class Layanan extends BaseController
{
    protected $layananModel;

    public function __construct()
    {
        $this->layananModel = new LayananModel();
    }

    public function index()
    {
        $detailModel = new \App\Models\DetailPesananModel();
        
        $layananPopuler = $detailModel
            ->select('layanan.nama_paket, SUM(detail_pesanan.qty) as total_jumlah, COUNT(detail_pesanan.id) as total_order')
            ->join('layanan', 'layanan.id = detail_pesanan.layanan_id', 'left')
            ->groupBy('detail_pesanan.layanan_id')
            ->orderBy('total_order', 'DESC')
            ->findAll(5);

        $data = [
            'title'          => 'Daftar Layanan Laundry',
            'layanan'        => $this->layananModel->orderBy('nama_paket', 'ASC')->findAll(),
            'layananPopuler' => $layananPopuler,
        ];

        return view('layanan/index', $data);
    }

    public function pdf()
    {
        $layanan = $this->layananModel->orderBy('nama_paket', 'ASC')->findAll();

        $html = view('layanan/pdf', [
            'title'   => 'Daftar Layanan Laundry - AromaFresh',
            'layanan' => $layanan
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="daftar-layanan-aromafresh.pdf"')
            ->setBody($pdfContent);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Layanan Baru',
        ];

        return view('layanan/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_paket'     => 'required|min_length[3]|max_length[100]',
            'tarif'          => 'required|numeric|greater_than[0]',
            'satuan_hitung'  => 'required|max_length[20]',
            'durasi_jam'     => 'required|integer|greater_than_equal_to[0]',
            'status_layanan' => 'required|in_list[aktif,nonaktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/layanan/create')->withInput()->with('error', 'Gagal menambahkan layanan. Periksa kembali inputan Anda.');
        }

        $this->layananModel->insert([
            'nama_paket'     => $this->request->getPost('nama_paket'),
            'keterangan'     => $this->request->getPost('keterangan'),
            'tarif'          => $this->request->getPost('tarif'),
            'satuan_hitung'  => $this->request->getPost('satuan_hitung'),
            'durasi_jam'     => $this->request->getPost('durasi_jam'),
            'status_layanan' => $this->request->getPost('status_layanan'),
        ]);

        return redirect()->to('/layanan')->with('success', 'Layanan laundry baru berhasil disimpan!');
    }

    public function edit($id = null)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Layanan tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Layanan',
            'layanan' => $layanan,
        ];

        return view('layanan/edit', $data);
    }

    public function update($id = null)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Layanan tidak ditemukan.');
        }

        $rules = [
            'nama_paket'     => 'required|min_length[3]|max_length[100]',
            'tarif'          => 'required|numeric|greater_than[0]',
            'satuan_hitung'  => 'required|max_length[20]',
            'durasi_jam'     => 'required|integer|greater_than_equal_to[0]',
            'status_layanan' => 'required|in_list[aktif,nonaktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/layanan/edit/' . $id)->withInput()->with('error', 'Gagal memperbarui layanan. Periksa kembali inputan Anda.');
        }

        $this->layananModel->update($id, [
            'nama_paket'     => $this->request->getPost('nama_paket'),
            'keterangan'     => $this->request->getPost('keterangan'),
            'tarif'          => $this->request->getPost('tarif'),
            'satuan_hitung'  => $this->request->getPost('satuan_hitung'),
            'durasi_jam'     => $this->request->getPost('durasi_jam'),
            'status_layanan' => $this->request->getPost('status_layanan'),
        ]);

        return redirect()->to('/layanan')->with('success', 'Layanan laundry berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Layanan tidak ditemukan.');
        }

        $this->layananModel->delete($id);
        return redirect()->to('/layanan')->with('success', 'Layanan laundry berhasil dihapus!');
    }
}
