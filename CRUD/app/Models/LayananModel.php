<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    protected $table            = 'layanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_paket',
        'keterangan',
        'tarif',
        'satuan_hitung',
        'durasi_jam',
        'status_layanan',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nama_paket'     => 'required|min_length[3]|max_length[100]',
        'tarif'          => 'required|numeric|greater_than[0]',
        'satuan_hitung'  => 'required|alpha_numeric_space|max_length[20]',
        'durasi_jam'     => 'required|integer|greater_than_equal_to[0]',
        'status_layanan' => 'required|in_list[aktif,nonaktif]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
