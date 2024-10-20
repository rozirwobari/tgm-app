<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;
use App\Models\QcAirBotolModel;

class QcAirBotol extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->AuthModel = new AuthModel();
        $this->QCModel = new QcAirBotolModel();
    }

    public function getLabelTime()
    {
        date_default_timezone_set('Asia/Jakarta');
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
        $data['qc_air_botol'] = $this->QCModel->orderBy('id', 'DESC')->findAll();
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
            $rules['tds_input_' . $i] = 'permit_empty';
            $errors['tds_input_' . $i] = [
                'required' => 'TDS input ' . $i . ' harus diisi.',
            ];
            $rules['ph_input_' . $i] = 'permit_empty';
            $errors['ph_input_' . $i] = [
                'required' => 'PH input ' . $i . ' harus diisi.',
            ];
            $rules['keruhan_input_' . $i] = 'permit_empty';
            $errors['keruhan_input_' . $i] = [
                'required' => 'Keruhan input ' . $i . ' harus diisi.',
            ];

            $rules['rasa_input_' . $i] = 'permit_empty';
            $errors['rasa_input_' . $i] = [
                'required' => 'Rasa input ' . $i . ' harus diisi.',
            ];
            $rules['aroma_input_' . $i] = 'permit_empty';
            $errors['aroma_input_' . $i] = [
                'required' => 'Aroma input ' . $i . ' harus diisi.',
            ];
            $rules['warna_input_' . $i] = 'permit_empty';
            $errors['warna_input_' . $i] = [
                'required' => 'Warna input ' . $i . ' harus diisi.',
            ];
        }

        for ($i = 1; $i <= 3; $i++) {
            $rules['alt_input_' . $i] = 'permit_empty';
            $errors['alt_input_' . $i] = [
                'required' => 'ALT input ' . $i . ' harus diisi.',
            ];
        }

        for ($i = 1; $i <= 2; $i++) {
            $rules['ec_input_' . $i] = 'permit_empty';
            $errors['ec_input_' . $i] = [
                'required' => 'EC input ' . $i . ' harus diisi.',
            ];
        }

        $this->validation->setRules($rules, $errors);

        if (!$this->validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('input', $this->validation->getErrors());
        }

        $input = [];
        for ($i=1; $i <= 5; $i++) {
            $input['data']['fisikokimia'][] = [
                'tds' => $this->request->getVar('tds_input_'.$i),
                'ph' => $this->request->getVar('ph_input_'.$i),
                'keruhan' => $this->request->getVar('keruhan_input_'.$i),
            ];

            $input['data']['organoleptik'][] = [
                'rasa' => $this->request->getVar('rasa_input_'.$i),
                'aroma' => $this->request->getVar('aroma_input_'.$i),
                'warna' => $this->request->getVar('warna_input_'.$i),
            ];
        };

        for ($i=1; $i <= 3; $i++) {
            $input['data']['mikrobiologi'][] = [
                'alt' => $this->request->getVar('alt_input_'.$i),
                'ec' => $this->request->getVar('ec_input_'.$i)
            ];
            if ($i == 3) {
                unset($input['data']['mikrobiologi'][$i - 1]['ec']);
            }
        }

        $data = [
            'user_id' => $this->session->get('id'),
            'data' => json_encode($input),
            'date' => json_encode([
                'timestamps' => time(),
                'label' => $this->getLabelTime(),
            ]),
        ];
        $this->QCModel->insert($data);

        return redirect()->to(base_url('/dashboard/qc_air_botol'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil disimpan.',
            'title' => 'Success',
        ]);
    }
    
    public function QCAirBotolDetail($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }
        $getData = $this->QCModel->find($id);
        $dataUser = $this->AuthModel->find($getData['user_id']);

        
        // dd(json_decode($getData['data'])->data->fisikokimia[1]->tds);
        $data = [
            'title' => 'Detail QC Air Botol',
            'details' => $getData,
            'data_user' => $dataUser,
            'id' => $id,
            'status' => $getData['status'],
        ];
        return view('dashboard/AirBotol/detail', $data);
    }

    public function QCAirBotolUpdate($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }
        $getData = $this->QCModel->find($id);
        if (!$getData) {
            return redirect()->to(base_url('/dashboard/qc_air_botol'))->with('alert', [
                'type' => 'danger',
                'message' => 'Data tidak ditemukan.',
                'title' => 'Error',
            ]);
        }

        $input = [];
        for ($i=1; $i <= 5; $i++) {
            $input['data']['fisikokimia'][] = [
                'tds' => $this->request->getVar('tds_input_'.$i),
                'ph' => $this->request->getVar('ph_input_'.$i),
                'keruhan' => $this->request->getVar('keruhan_input_'.$i),
            ];

            $input['data']['organoleptik'][] = [
                'rasa' => $this->request->getVar('rasa_input_'.$i),
                'aroma' => $this->request->getVar('aroma_input_'.$i),
                'warna' => $this->request->getVar('warna_input_'.$i),
            ];
        };

        for ($i=1; $i <= 3; $i++) {
            $input['data']['mikrobiologi'][] = [
                'alt' => $this->request->getVar('alt_input_'.$i),
                'ec' => $this->request->getVar('ec_input_'.$i)
            ];
            if ($i == 3) {
                unset($input['data']['mikrobiologi'][$i - 1]['ec']);
            }
        }

        $data = [
            'user_id' => $this->session->get('id'),
            'data' => json_encode($input),
            'date' => json_encode([
                'timestamps' => time(),
                'label' => $this->getLabelTime(),
            ]),
        ];

        $this->QCModel->update($id, $data);

        return redirect()->to(base_url('/dashboard/qc_air_botol'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil diupdate.',
            'title' => 'Success',
        ]);
    }

    function QCAirBotolReject($id)
    {
        $data = [
            'status' => '2',
        ];

        $this->QCModel->update($id, $data);

        return redirect()->to(base_url('/dashboard/qc_air_botol'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil ditolak.',
            'title' => 'Data Ditolak',
        ]);
    }

    function QCAirBotolDelete($id)
    {
        $this->QCModel->delete($id);
        return redirect()->to(base_url('/dashboard/qc_air_botol'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil dihapus.',
            'title' => 'Data Dihapus',
        ]);
    }

    function QCAirBotolApprove($id)
    {
        $data = [
            'status' => '1',
        ];

        $this->QCModel->update($id, $data);

        return redirect()->to(base_url('/dashboard/qc_air_botol'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil disetujui.',
            'title' => 'Data Disetujui',
        ]);
    }

    function QCAirBotolExport()
    {
        $data = $this->QCModel->findAll();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('asset/excel/qc_air_botol.xlsx');
        $sheet = $spreadsheet->getActiveSheet()->setTitle("QC Air Botol");
        $row = 5;
        $number = 1;
        foreach ($data as $item) {

            $dataUser = $this->AuthModel->find($item['user_id']);
            $date = json_decode($item['date']);
            $sheet->setCellValue("A" . $row, $number);
            $sheet->getStyle("A" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet->setCellValue("B" . $row, $date->label);
            $sheet->getStyle("B" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet->setCellValue("C" . $row, $dataUser['nama']);
            $sheet->getStyle("C" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);

            $QCData = json_decode($item['data'])->data;
            $TDSColumns = ['D', 'E', 'F', 'G', 'H'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $tdsValue = $fisikokimia->tds;
                $sheet->setCellValue($TDSColumns[$index] . $row, $tdsValue);
                $sheet->getStyle($TDSColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($tdsValue !== null && $tdsValue !== '') {
                    if ($tdsValue >= 0 && $tdsValue <= 5) {
                        $sheet->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($tdsValue >= 6 && $tdsValue <= 10) {
                        $sheet->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $PHColumns = ['I', 'J', 'K', 'L', 'M'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $phValue = $fisikokimia->ph;
                $sheet->setCellValue($PHColumns[$index] . $row, $phValue);
                $sheet->getStyle($PHColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($phValue !== null && $phValue !== '') {
                    if ($phValue >= 5.0 && $phValue <= 7.0) {
                        $sheet->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($phValue >= 7.1 && $phValue <= 7.5) {
                        $sheet->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $KERUHANColumns = ['N', 'O', 'P', 'Q', 'R'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $keruhanValue = $fisikokimia->keruhan;
                $sheet->setCellValue($KERUHANColumns[$index] . $row, $keruhanValue);
                $sheet->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($keruhanValue !== null && $keruhanValue !== '') {
                    if ($keruhanValue <= 1.0) {
                        $sheet->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($keruhanValue >= 1.1 && $keruhanValue <= 1.5) {
                        $sheet->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }
            $row++;
            $number++;
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'qc_air_botol_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
