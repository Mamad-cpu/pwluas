<?php

namespace App\Controllers;

use App\Models\MemberModel;

class Member extends BaseController
{
    protected $memberModel;

    public function __construct()
    {
        $this->memberModel = new MemberModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Daftar Member Laundry',
            'members' => $this->memberModel->orderBy('nama_member', 'ASC')->findAll(),
        ];

        return view('member/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Registrasi Member Baru',
        ];

        return view('member/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_member'    => 'required|min_length[3]|max_length[100]',
            'no_handphone'   => 'required|min_length[8]|max_length[20]',
            'alamat_lengkap' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/member/create')->withInput()->with('error', 'Gagal mendaftarkan member. Periksa kembali inputan Anda.');
        }

        $this->memberModel->insert([
            'nama_member'    => $this->request->getPost('nama_member'),
            'no_handphone'   => $this->request->getPost('no_handphone'),
            'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
        ]);

        return redirect()->to('/member')->with('success', 'Registrasi member baru berhasil!');
    }

    public function edit($id = null)
    {
        $member = $this->memberModel->find($id);
        if (!$member) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Member tidak ditemukan.');
        }

        $data = [
            'title'  => 'Edit Data Member',
            'member' => $member,
        ];

        return view('member/edit', $data);
    }

    public function update($id = null)
    {
        $member = $this->memberModel->find($id);
        if (!$member) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Member tidak ditemukan.');
        }

        $rules = [
            'nama_member'    => 'required|min_length[3]|max_length[100]',
            'no_handphone'   => 'required|min_length[8]|max_length[20]',
            'alamat_lengkap' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/member/edit/' . $id)->withInput()->with('error', 'Gagal memperbarui data member. Periksa kembali inputan Anda.');
        }

        $this->memberModel->update($id, [
            'nama_member'    => $this->request->getPost('nama_member'),
            'no_handphone'   => $this->request->getPost('no_handphone'),
            'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
        ]);

        return redirect()->to('/member')->with('success', 'Data member berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $member = $this->memberModel->find($id);
        if (!$member) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Member tidak ditemukan.');
        }

        $this->memberModel->delete($id);
        return redirect()->to('/member')->with('success', 'Data member berhasil dihapus!');
    }
}
