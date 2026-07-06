<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\MemberModel;
use App\Models\LayananModel;

class Dashboard extends BaseController
{
    /**
     * Halaman Dashboard - ringkasan semua data
     */
    public function index()
    {
        $pesananModel  = new PesananModel();
        $memberModel   = new MemberModel();
        $layananModel  = new LayananModel();

        $today     = date('Y-m-d');
        $bulanIni  = date('Y-m');

        // Statistik
        $totalMember       = $memberModel->countAllResults();
        $totalLayananAktif = $layananModel->where('status_layanan', 'aktif')->countAllResults();
        $pesananHariIni    = $pesananModel->where('tgl_terima', $today)->countAllResults();

        // Pendapatan bulan ini
        $pendapatanBulan = $pesananModel
            ->selectSum('total_tagihan')
            ->like('tgl_terima', $bulanIni, 'after')
            ->first();
        $pendapatanBulanIni = $pendapatanBulan['total_tagihan'] ?? 0;

        // 5 Transaksi terakhir
        $pesananTerakhir = $pesananModel->getPesananWithRelations();
        $pesananTerakhir = array_slice($pesananTerakhir, 0, 5);

        // Statistik status transaksi
        $statusAntrian = $pesananModel->where('status_laundry', 'antrian')->countAllResults();
        $statusProses  = $pesananModel->where('status_laundry', 'proses')->countAllResults();
        $statusSelesai = $pesananModel->where('status_laundry', 'selesai')->countAllResults();

        $data = [
            'title'              => 'Dashboard',
            'totalMember'        => $totalMember,
            'totalLayananAktif'  => $totalLayananAktif,
            'pesananHariIni'     => $pesananHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'pesananTerakhir'    => $pesananTerakhir,
            'statusAntrian'      => $statusAntrian,
            'statusProses'       => $statusProses,
            'statusSelesai'      => $statusSelesai,
        ];

        return view('dashboard/index', $data);
    }
}
