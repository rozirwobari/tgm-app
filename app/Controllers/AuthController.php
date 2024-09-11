<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use App\Models\AuthModel;

class AuthController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->model = new AuthModel();
        $this->session->start();
    }

    public function index()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard/'));
        } else {
            return view('auth/login');
        }
    }

    public function daftar()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard/'));
        } else {
            return view('auth/daftar');
        }
    }

    public function auth_login()
    {
        
        $this->validation->setRules([
            'username' => 'required|alpha_numeric',
            'password' => 'required|min_length[8]',
        ], [
            'username' => [
                'required' => 'Username harus diisi.',
                'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
            ],
            'password' => [
                'required' => 'Password harus diisi.',
                'min_length' => 'Password minimal harus 8 karakter.',
            ],
        ]);

        if (!$this->validation->run($this->request->getVar())) {
            return redirect()->to(base_url('/'))->withInput()->with('input', $this->validation->getErrors());
        }

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->model->where('username', $username)->first();

        if (!$user) {
            return redirect()->to(base_url('/'))->withInput()->with('input', [
                'username' => 'Username tidak ditemukan.'
            ]);
        }

        if ($password != $user['password']) {
            return redirect()->to(base_url('/'))->withInput()->with('input', [
                'password' => 'Password salah.'
            ]);
        }

        $this->session->set([
            'id' => $user['id'],
            'name' => $user['nama'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ], null, 31536000); // Membuat session permanen untuk 1 tahun

        return redirect()->to(base_url('dashboard/'));
    }

    public function auth_daftar()
    {
        $this->validation->setRules([
            'nama_lengkap' => 'required',
            'username' => 'required|alpha_numeric|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'email' => 'required|valid_email|is_unique[users.email]',
        ], [
            'nama_lengkap' => [
                'required' => 'Nama lengkap harus diisi.',
            ],
            'username' => [
                'required' => 'Username harus diisi.',
                'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
                'is_unique' => 'Username sudah digunakan.',
            ],
            'password' => [
                'required' => 'Password harus diisi.',
                'min_length' => 'Password minimal harus 8 karakter.',
            ],
            'email' => [
                'required' => 'Email harus diisi.',
                'valid_email' => 'Email tidak valid.',
                'is_unique' => 'Email sudah digunakan.',
            ],
        ]);

        if (!$this->validation->run($this->request->getVar())) {
            return redirect()->to(base_url('/daftar'))->withInput()->with('input', $this->validation->getErrors());
        }

        $data = [
            'nama' => $this->request->getVar('nama_lengkap'),
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            // 'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'email' => $this->request->getVar('email'),
            'foto' => 'asset/img/profile.png',
        ];

        $this->model->insert($data);

        return redirect()->to(base_url('/'))->withInput()->with('alert', [
            'type' => 'success',
            'message' => 'Pendaftaran berhasil!',
            'title' => 'Berhasil',
        ]);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }
}
