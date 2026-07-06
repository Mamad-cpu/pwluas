<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_paket' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tarif' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'satuan_hitung' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'durasi_jam' => [
                'type'       => 'INT',
                'constraint' => 11,
                'comment'    => 'Estimasi waktu dalam jam',
            ],
            'status_layanan' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default'    => 'aktif',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('layanan');
    }

    public function down()
    {
        $this->forge->dropTable('layanan');
    }
}
