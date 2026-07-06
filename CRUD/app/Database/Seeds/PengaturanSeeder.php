<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['key' => 'nama_toko',    'value' => 'AromaFresh Laundry'],
            ['key' => 'alamat_toko',  'value' => 'Jl. Pahlawan No. 88, Jakarta Selatan 12345'],
            ['key' => 'telepon_toko', 'value' => '021-12345678'],
            ['key' => 'email_toko',   'value' => 'info@aromafresh.com'],
            ['key' => 'jam_buka',     'value' => '07:00 - 21:00'],
            ['key' => 'deskripsi',    'value' => 'Layanan laundry profesional dengan kualitas terbaik dan aroma keharuman tahan lama.'],
        ];

        $this->db->table('pengaturan')->insertBatch($data);
    }
}
