<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;
use App\Models\RoleModel;
class Profile extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->AuthModel = new AuthModel();
        $this->RoleModel = new RoleModel();
    }

    public function index()
    {
        $id = $this->session->get('id');
        $dataUsers = $this->AuthModel->find($id);
        $dataRole = $this->RoleModel->find($dataUsers['role']);
        $users = [
            'id' => $dataUsers['id'],
            'nama' => $dataUsers['nama'],
            'email' => $dataUsers['email'],
            'img' => $dataUsers['img'],
            'role_name' => $dataRole['name'],
            'role_label' => $dataRole['label']
        ];
        $data = [
            'user' => $users
        ];
        // dd($data);
        return view('profile/edit', $data);
    }

    public function saveprofile()
    {
        $id = $this->request->getVar('id');
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $password_lama = $this->request->getVar('password_lama');
        $password_baru = $this->request->getVar('password_baru');
        $foto_profile = $this->request->getFile('foto_profile');

        
        $dataUsers = $this->AuthModel->find($id);
        $password = $dataUsers['password'];

        if ($password_lama != '' && $password_baru != '') {
            if ($dataUsers['password'] != $password_lama) {
                return redirect()->back()->withInput()->with('alert', [
                    'type' => 'error',
                    'message' => 'Password Lama Salah',
                    'title' => 'Password Lama Salah',
                ]);
            }

            $password = $password_baru;
        }

        if ($foto_profile->isValid()) {
            $namaFileBaru = $foto_profile->getRandomName();
            $foto_profile->move('asset/img/', $namaFileBaru);
            $foto_profile = 'asset/img/' . $namaFileBaru;
            if (file_exists($dataUsers['img'])) {
                unlink($dataUsers['img']);
            }
        } else {
            $foto_profile = $dataUsers['img'];
        }
    
        $dataUsers['nama'] = $nama;
        $dataUsers['email'] = $email;
        $dataUsers['password'] = $password;
        $dataUsers['img'] = $foto_profile;
        $this->AuthModel->save($dataUsers);

        return redirect()->back()->withInput()->with('alert', [
            'type' => 'success',
            'message' => 'Berhasil Mengubah Profile',
            'title' => 'Berhasil',
        ]);
    }
}
