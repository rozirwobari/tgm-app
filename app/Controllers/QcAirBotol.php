<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;

class QcAirBotol extends BaseController
{
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
            'title' => 'QC Air Botol',
        ];
        return view('dashboard/AirBotol/qc_air_botol', $data);
    }

    public function fisikokimia()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }

        $data = [
            'title' => 'Fisiko Kimia',
        ];
        return view('dashboard/AirBotol/fisikokimia', $data);
    }
    
    public function organoleptik()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }

        $data = [
            'title' => 'Organoleptik',
        ];
        return view('dashboard/AirBotol/organoleptik', $data);
    }

    public function mikrobiologi()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }

        $data = [
            'title' => 'Mikrobiologi',
        ];
        return view('dashboard/AirBotol/mikrobiologi', $data);
    }

    public function QCAirBotolFisikokimia()
    {
        $rules = [];
        $errors = [];
        for ($i = 1; $i <= 5; $i++) {
            $rules['tds_input_' . $i] = 'required';
            $errors['tds_input_' . $i] = [
                'required' => 'TDS input ' . $i . ' harus diisi.',
            ];
            $rules['ph_input_' . $i] = 'required';
            $errors['ph_input_' . $i] = [
                'required' => 'PH input ' . $i . ' harus diisi.',
            ];
            $rules['keruhan_input_' . $i] = 'required';
            $errors['keruhan_input_' . $i] = [
                'required' => 'Keruhan input ' . $i . ' harus diisi.',
            ];
        }

        $this->validation->setRules($rules, $errors);

        if (!$this->validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('input', $this->validation->getErrors());
        }
        return redirect()->to('/dashboard/qc_air_botol/organoleptik');
    }

    public function QCAirBotolOrganoleptik()
    {
        $rules = [];
        $errors = [];
        for ($i = 1; $i <= 5; $i++) {
            $rules['rasa_input_' . $i] = 'required';
            $errors['rasa_input_' . $i] = [
                'required' => 'Rasa input ' . $i . ' harus diisi.',
            ];
            $rules['aroma_input_' . $i] = 'required';
            $errors['aroma_input_' . $i] = [
                'required' => 'Aroma input ' . $i . ' harus diisi.',
            ];
        }

        $this->validation->setRules($rules, $errors);

        if (!$this->validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('input', $this->validation->getErrors());
        }
        return redirect()->to('/dashboard/qc_air_botol/organoleptik');
    }

    public function QCAirBotolMikrobiologi()
    {
        $rules = [];
        $errors = [];
        for ($i = 1; $i <= 5; $i++) {
            $rules['rasa_input_' . $i] = 'required';
            $errors['rasa_input_' . $i] = [
                'required' => 'Rasa input ' . $i . ' harus diisi.',
            ];
            $rules['aroma_input_' . $i] = 'required';
            $errors['aroma_input_' . $i] = [
                'required' => 'Aroma input ' . $i . ' harus diisi.',
            ];
        }

        $this->validation->setRules($rules, $errors);

        if (!$this->validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('input', $this->validation->getErrors());
        }
        return redirect()->to('/dashboard/qc_air_botol/mikrobiologi');
    }
}
