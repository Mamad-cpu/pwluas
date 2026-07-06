<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('UsersSeeder');
        $this->call('MemberSeeder');
        $this->call('LayananSeeder');
        $this->call('PengaturanSeeder');
    }
}
