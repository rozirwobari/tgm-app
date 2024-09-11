<?php

namespace App\Controllers;
use App\Models\AuthModel;

class Home extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->AuthModel = new AuthModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }

        $data = [
            'title' => 'Dashboard',
            'user' => $this->AuthModel->find($this->session->get('id')),
        ];
        return view('dashboard/home', $data);
    }

    public function qc_air_botol()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }
        return view('dashboard/AirBotol/qc_air_botol');
    }
}
