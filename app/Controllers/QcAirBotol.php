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
        $this->QCModel = new QcAirBotol();
        $this->session = \Config\Services::session();
    }

    public function getLabelTime()
    {
        $tanggal = date('d');
        $bulan = date('F');
        $tahun = date('Y');
        $jam = date('H');
        $menit = date('i');
        $detik = date('s');
        $bulanIndonesia = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
        $labelTime = $tanggal . ' ' . $bulanIndonesia[$bulan] . ' ' . $tahun . ' | ' . $jam . ':' . $menit . ':' . $detik;
        return $labelTime;
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

        // $input = [];
        // for ($i=1; $i <= 5; $i++) { 
        //     $input[] = [
        //         'tds' => $this->request->getVar('tds_input_'.$i),
        //         'ph' => $this->request->getVar('ph_input_'.$i),
        //         'keruhan' => $this->request->getVar('keruhan_input_'.$i),
        //     ];
        // };
        // $data = [
        //     'user_id' => $this->session->get('id'),
        //     'data' => json_encode($input),
        //     'date' => [
        //         'timestamps' => time(),
        //         'label' => $this->getLabelTime(),
        //     ],
        //     'type' => "fisikokimia",
        // ];
        // $this->QCModel->insert($data);

        return redirect()->to('/dashboard/qc_air_botol/organoleptik')->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil disimpan.',
            'title' => 'Success',
        ]);
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
