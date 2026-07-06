<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMember extends Migration
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
            'nama_member' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'no_handphone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'alamat_lengkap' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('member');
    }

    public function down()
    {
        $this->forge->dropTable('member');
    }
}
