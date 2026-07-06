<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSoftDeleteToLayananAndMember extends Migration
{
    public function up()
    {
        // Add deleted_at to layanan if not exists
        $fields = $this->db->getFieldNames('layanan');
        if (!in_array('deleted_at', $fields)) {
            $this->forge->addColumn('layanan', [
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'updated_at',
                ],
            ]);
        }

        // Add deleted_at to member if not exists
        $fields = $this->db->getFieldNames('member');
        if (!in_array('deleted_at', $fields)) {
            $this->forge->addColumn('member', [
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'updated_at',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('layanan', 'deleted_at');
        $this->forge->dropColumn('member', 'deleted_at');
    }
}
