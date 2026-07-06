<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_paket'     => 'Paket Wangi Standar (Cuci + Lipat)',
                'keterangan'     => 'Cuci bersih, dikeringkan, dan dilipat rapi dengan pewangi standar.',
                'tarif'          => 6000.00,
                'satuan_hitung'  => 'kg',
                'durasi_jam'     => 48,
                'status_layanan' => 'aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_paket'     => 'Paket Kilat 24 Jam (Cuci + Setrika)',
                'keterangan'     => 'Cuci bersih, disetrika rapi, dan dikemas khusus. Selesai dalam 24 jam.',
                'tarif'          => 10000.00,
                'satuan_hitung'  => 'kg',
                'durasi_jam'     => 24,
                'status_layanan' => 'aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_paket'     => 'Paket Super Express (6 Jam)',
                'keterangan'     => 'Layanan prioritas super cepat. Selesai dalam waktu maksimal 6 jam.',
                'tarif'          => 15000.00,
                'satuan_hitung'  => 'kg',
                'durasi_jam'     => 6,
                'status_layanan' => 'aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_paket'     => 'Setrika Harum (Tanpa Cuci)',
                'keterangan'     => 'Hanya disetrika rapi menggunakan pelicin dan pewangi pakaian premium.',
                'tarif'          => 4500.00,
                'satuan_hitung'  => 'kg',
                'durasi_jam'     => 24,
                'status_layanan' => 'aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_paket'     => 'Cuci Bed Cover Jumbo',
                'keterangan'     => 'Cuci bersih bed cover ukuran king/jumbo dengan deterjen anti-bakteri.',
                'tarif'          => 25000.00,
                'satuan_hitung'  => 'pcs',
                'durasi_jam'     => 48,
                'status_layanan' => 'aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_paket'     => 'Cuci Sepatu Premium',
                'keterangan'     => 'Pembersihan sepatu secara mendalam menggunakan bahan pembersih khusus sepatu.',
                'tarif'          => 30000.00,
                'satuan_hitung'  => 'pasang',
                'durasi_jam'     => 72,
                'status_layanan' => 'aktif',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('layanan')->insertBatch($data);
    }
}
