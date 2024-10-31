<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;

class Profile extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->AuthModel = new AuthModel();
    }

    public function index()
    {
        $id = $this->session->get('id');
        $data = [
            'user' => $this->AuthModel->find($id)
        ];
        dd($data);
        return view('profile/edit', $data);
    }
}
