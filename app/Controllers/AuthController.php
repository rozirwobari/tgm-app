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
    
    public function forgot_password()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard/'));
        } else {
            return view('auth/forgot_password');
        }
    }

    public function auth_forgot()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard/'));
        }

        $username = $this->request->getVar('username');
        $user = $this->model->where('username', $username)->first();
        if (!$user) {
            $user = $this->model->where('email', $username)->first();
        }

        if (!$user) {
            return redirect()->to(base_url('/lupa-password'))->withInput()->with('errors', collect(['username' => 'Username/Email tidak ditemukan.']));
        }

        $token = bin2hex(random_bytes(32));
        $this->model->update($user['id'], ['token_reset' => $token]);

        $email = \Config\Services::email();
        $email->setTo($user['email']);
        $email->setSubject('Reset Password');
        $email->setMessage(view('auth/reset_password_template', ['token' => $token]));
        $email->setFrom('forgot-password@rozirwobar.my.id', 'RZW Reset Password');

        if ($email->send()) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'success',
                'message' => 'Link reset password telah dikirim ke email Anda.',
                'title' => 'Berhasil',
            ]);
        } else {
            return redirect()->to(base_url('/lupa-password'))->with('alert', [
                'type' => 'error',
                'message' => 'Gagal mengirim email reset password.',
                'title' => 'Gagal',
            ]);
        }
    }

    public function reset_password($token)
    {
        $user = $this->model->where('token_reset', $token)->first();
        if (!$user) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'error',
                'message' => 'Token tidak valid.',
                'title' => 'Gagal',
            ]);
        }

        return view('auth/reset_password', ['token' => $token, 'username' => $user['username']]);
    }

    public function auth_reset()
    {
        $token = $this->request->getVar('token');
        $password = $this->request->getVar('password');

        $user = $this->model->where('token_reset', $token)->first();
        if (!$user) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'error',
                'message' => 'Token tidak valid.',
                'title' => 'Gagal',
            ]);
        }

        $this->model->update($user['id'], ['password' => $password, 'token_reset' => null]);
        return redirect()->to(base_url('/'))->withInput()->with('alert', [
            'type' => 'success',
            'message' => 'Password berhasil diubah.',
            'title' => 'Berhasil',
        ]);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }
}
