<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_member'    => 'Budi Santoso',
                'no_handphone'   => '081234567890',
                'alamat_lengkap' => 'Jl. Anggrek No. 12, Jakarta Barat',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_member'    => 'Siti Aminah',
                'no_handphone'   => '081987654321',
                'alamat_lengkap' => 'Jl. Melati No. 45, Jakarta Selatan',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_member'    => 'Ahmad Hidayat',
                'no_handphone'   => '085611223344',
                'alamat_lengkap' => 'Jl. Kemuning No. 8, Jakarta Timur',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_member'    => 'Dewi Lestari',
                'no_handphone'   => '087855667788',
                'alamat_lengkap' => 'Jl. Kamboja No. 19, Jakarta Utara',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('member')->insertBatch($data);
    }
}
