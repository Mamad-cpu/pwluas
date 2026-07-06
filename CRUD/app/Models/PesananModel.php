<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table            = 'pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_invoice',
        'member_id',
        'user_id',
        'tgl_terima',
        'tgl_selesai',
        'total_tagihan',
        'status_laundry',
        'catatan_khusus',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nomor_invoice'  => 'required|max_length[50]',
        'member_id'      => 'required|integer',
        'tgl_terima'     => 'required|valid_date',
        'total_tagihan'  => 'required|numeric',
        'status_laundry' => 'required|in_list[antrian,proses,selesai,diambil]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Generate unique Invoice Number
     */
    public function generateInvoice()
    {
        $builder = $this->db->table($this->table);
        $builder->selectMax('id');
        $query = $builder->get();
        $row = $query->getRow();
        $maxId = $row ? $row->id : 0;
        $nextId = $maxId + 1;
        return 'INV-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get pesanan with member and user (kasir) details
     */
    public function getPesananWithRelations($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('pesanan.*, member.nama_member as nama_member, users.nama as nama_kasir');
        $builder->join('member', 'member.id = pesanan.member_id', 'left');
        $builder->join('users', 'users.id = pesanan.user_id', 'left');
        $builder->orderBy('pesanan.created_at', 'DESC');

        if ($id !== null) {
            $builder->where('pesanan.id', $id);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }
}
