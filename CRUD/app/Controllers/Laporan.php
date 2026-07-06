<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;

class Laporan extends BaseController
{
    public function index()
    {
        $pesananModel = new PesananModel();
        $detailModel  = new DetailPesananModel();

        $dari   = $this->request->getGet('dari') ?: date('Y-m-01');
        $sampai = $this->request->getGet('sampai') ?: date('Y-m-d');

        // Pesanan dalam periode
        $pesanan = $pesananModel
            ->select('pesanan.*, member.nama_member as nama_member')
            ->join('member', 'member.id = pesanan.member_id', 'left')
            ->where('tgl_terima >=', $dari)
            ->where('tgl_terima <=', $sampai)
            ->orderBy('tgl_terima', 'DESC')
            ->findAll();

        // Total pendapatan
        $totalPendapatan = 0;
        foreach ($pesanan as $trx) {
            $totalPendapatan += (float) $trx['total_tagihan'];
        }

        $data = [
            'title'           => 'Laporan',
            'pesanan'         => $pesanan,
            'totalPendapatan' => $totalPendapatan,
            'totalPesanan'    => count($pesanan),
            'dari'            => $dari,
            'sampai'          => $sampai,
        ];

        return view('laporan/index', $data);
    }
}
