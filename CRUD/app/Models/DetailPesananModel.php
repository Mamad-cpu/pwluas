<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table            = 'detail_pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pesanan_id',
        'layanan_id',
        'qty',
        'subtotal_tagihan',
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [
        'pesanan_id'       => 'required|integer',
        'layanan_id'       => 'required|integer',
        'qty'              => 'required|numeric',
        'subtotal_tagihan' => 'required|numeric',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get detail items by pesanan ID
     */
    public function getDetailByPesanan($pesananId)
    {
        return $this->select('detail_pesanan.*, layanan.nama_paket as nama_paket, layanan.tarif as tarif, layanan.satuan_hitung as satuan')
            ->join('layanan', 'layanan.id = detail_pesanan.layanan_id', 'left')
            ->where('pesanan_id', $pesananId)
            ->findAll();
    }
}
