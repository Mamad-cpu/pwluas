<?php

namespace App\Controllers;

use App\Libraries\Cart;
use App\Models\LayananModel;

class CartController extends BaseController
{
    protected $cart;
    protected $layananModel;

    public function __construct()
    {
        $this->cart = new Cart();
        $this->layananModel = new LayananModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Keranjang Belanja Layanan',
            'cartItems' => $this->cart->contents(),
            'total' => $this->cart->total(),
        ];

        return view('cart/index', $data);
    }

    public function add($id)
    {
        $layanan = $this->layananModel->find($id);

        if (!$layanan) {
            session()->setFlashdata('error', 'Layanan tidak ditemukan.');
            return redirect()->to('/layanan');
        }

        $item = [
            'id'    => $layanan['id'],
            'qty'   => 1,
            'price' => $layanan['tarif'],
            'name'  => $layanan['nama_paket'],
            'options' => [
                'satuan' => $layanan['satuan_hitung'],
                'durasi' => $layanan['durasi_jam']
            ]
        ];

        $this->cart->insert($item);

        session()->setFlashdata('success', 'Paket "' . $layanan['nama_paket'] . '" ditambahkan ke keranjang.');
        return redirect()->to('/cart');
    }

    public function update()
    {
        $items = $this->request->getPost('items');

        if (!empty($items) && is_array($items)) {
            foreach ($items as $id => $data) {
                $qty = (float)$data['qty'];
                $this->cart->update([
                    'id'  => $id,
                    'qty' => $qty
                ]);
            }
            session()->setFlashdata('success', 'Keranjang belanja berhasil diperbarui.');
        }

        return redirect()->to('/cart');
    }

    public function remove($id)
    {
        if ($this->cart->remove($id)) {
            session()->setFlashdata('success', 'Item berhasil dihapus dari keranjang.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus item.');
        }

        return redirect()->to('/cart');
    }

    public function clear()
    {
        $this->cart->destroy();
        session()->setFlashdata('success', 'Keranjang belanja telah dikosongkan.');
        return redirect()->to('/cart');
    }
}
