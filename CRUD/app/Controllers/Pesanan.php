<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\MemberModel;
use App\Models\LayananModel;
use Dompdf\Dompdf;

class Pesanan extends BaseController
{
    protected $pesananModel;
    protected $detailModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->detailModel    = new DetailPesananModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status');

        $builder = $this->pesananModel
            ->select('pesanan.*, member.nama_member as nama_member, users.nama as nama_kasir')
            ->join('member', 'member.id = pesanan.member_id', 'left')
            ->join('users', 'users.id = pesanan.user_id', 'left');

        if ($status && in_array($status, ['antrian', 'proses', 'selesai', 'diambil'])) {
            $builder->where('pesanan.status_laundry', $status);
        }

        $pesanan = $builder->orderBy('pesanan.created_at', 'DESC')->findAll();

        $data = [
            'title'        => 'Data Pesanan Laundry',
            'pesanan'      => $pesanan,
            'filterStatus' => $status,
        ];

        return view('pesanan/index', $data);
    }

    public function create()
    {
        $memberModel  = new MemberModel();
        $layananModel = new LayananModel();

        $data = [
            'title'   => 'Buat Pesanan Baru',
            'members' => $memberModel->orderBy('nama_member', 'ASC')->findAll(),
            'layanan' => $layananModel->where('status_layanan', 'aktif')->orderBy('nama_paket', 'ASC')->findAll(),
        ];

        return view('pesanan/create', $data);
    }

    public function store()
    {
        $rules = [
            'member_id'  => 'required|integer',
            'tgl_terima' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/pesanan/create')->withInput()->with('error', 'Data tidak valid. Periksa kembali form.');
        }

        $items = $this->request->getPost('items');

        if (empty($items) || !is_array($items)) {
            return redirect()->to('/pesanan/create')->withInput()->with('error', 'Tambahkan minimal 1 item layanan.');
        }

        $layananModel = new LayananModel();
        $totalTagihan = 0;
        $processedItems = [];

        // Validasi dan hitung subtotal secara server-side
        foreach ($items as $item) {
            $layananId = $item['layanan_id'] ?? 0;
            $qty       = (float) ($item['qty'] ?? 0);

            if ($qty <= 0) {
                return redirect()->to('/pesanan/create')->withInput()->with('error', 'Jumlah layanan tidak valid.');
            }

            $layanan = $layananModel->find($layananId);
            if (!$layanan) {
                return redirect()->to('/pesanan/create')->withInput()->with('error', 'Jenis layanan tidak valid.');
            }

            $subtotal = $layanan['tarif'] * $qty;
            $totalTagihan += $subtotal;

            $processedItems[] = [
                'layanan_id'       => $layananId,
                'qty'              => $qty,
                'subtotal_tagihan' => $subtotal,
            ];
        }

        // Simpan transaksi
        $pesananData = [
            'nomor_invoice'  => $this->pesananModel->generateInvoice(),
            'member_id'      => $this->request->getPost('member_id'),
            'user_id'         => session()->get('user_id'),
            'tgl_terima'     => $this->request->getPost('tgl_terima'),
            'tgl_selesai'    => $this->request->getPost('tgl_selesai') ?: null,
            'total_tagihan'  => $totalTagihan,
            'status_laundry' => 'antrian',
            'catatan_khusus' => $this->request->getPost('catatan_khusus'),
        ];

        $this->pesananModel->insert($pesananData);
        $pesananId = $this->pesananModel->getInsertID();

        // Simpan detail transaksi
        foreach ($processedItems as $pItem) {
            $this->detailModel->insert([
                'pesanan_id'       => $pesananId,
                'layanan_id'       => $pItem['layanan_id'],
                'qty'              => $pItem['qty'],
                'subtotal_tagihan' => $pItem['subtotal_tagihan'],
            ]);
        }

        session()->setFlashdata('success', 'Pesanan berhasil dibuat dengan invoice: ' . $pesananData['nomor_invoice']);
        return redirect()->to('/pesanan');
    }

    public function show($id = null)
    {
        $pesanan = $this->pesananModel->getPesananWithRelations($id);

        if (!$pesanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $detail = $this->detailModel->getDetailByPesanan($id);

        $data = [
            'title'   => 'Detail Pesanan',
            'pesanan' => $pesanan,
            'detail'  => $detail,
        ];

        return view('pesanan/show', $data);
    }

    public function updateStatus($id = null)
    {
        $pesanan = $this->pesananModel->find($id);

        if (!$pesanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status_laundry');
        $validStatuses = ['antrian', 'proses', 'selesai', 'diambil'];

        if (!in_array($newStatus, $validStatuses)) {
            session()->setFlashdata('error', 'Status tidak valid.');
            return redirect()->to('/pesanan');
        }

        $updateData = ['status_laundry' => $newStatus];

        // Set tanggal selesai otomatis saat status jadi "selesai"
        if ($newStatus === 'selesai' && empty($pesanan['tgl_selesai'])) {
            $updateData['tgl_selesai'] = date('Y-m-d');
        }

        $this->pesananModel->update($id, $updateData);

        session()->setFlashdata('success', 'Status pesanan berhasil diperbarui menjadi "' . ucfirst($newStatus) . '".');
        return redirect()->to('/pesanan');
    }

    public function delete($id = null)
    {
        $pesanan = $this->pesananModel->find($id);

        if (!$pesanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $this->pesananModel->delete($id);

        session()->setFlashdata('success', 'Pesanan berhasil dihapus!');
        return redirect()->to('/pesanan');
    }

    public function pdf($id = null)
    {
        $pesanan = $this->pesananModel->getPesananWithRelations($id);

        if (!$pesanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $detail = $this->detailModel->getDetailByPesanan($id);

        $html = view('pesanan/download_pdf', [
            'pesanan' => $pesanan,
            'detail'  => $detail,
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="nota-' . $pesanan['nomor_invoice'] . '.pdf"')
            ->setBody($pdfContent);
    }
}
