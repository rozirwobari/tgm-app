<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;
use App\Models\QcAirCupModel;
use App\Models\RoleModel;

use Google\Client;
use Google\Service\Sheets;

class QcAirCup extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->AuthModel = new AuthModel();
        $this->QCModel = new QcAirCupModel();
        $this->RoleModel = new RoleModel();
        $this->SheetID = "1tai30V_sTjUhmzEWClbuFc-NxEm_-qD2B7s2hjonZRU";
        $this->serviceAccountFile = 'asset/credentials/service-account.json';
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

        $data_user = $this->AuthModel
                    ->select('users.id as user_id, users.nama, role.id as role_id, role.name, role.label')
                    ->join('role', 'users.role = role.id')
                    ->find($this->session->get('id'));

        if (empty($data_user)) {
            $this->session->destroy();
            return redirect()->to(base_url())->with('alert', [
                'type' => 'error',
                'message' => 'Session expired, please login again!',
                'title' => 'Session Expired',
            ]);
        }


        // dd($data_user);
        $data = [
            'title' => 'QC Air Cup',
            'data_user' => $data_user,
        ];
        $data['qc_air_cup'] = $this->QCModel->orderBy('id', 'DESC')->findAll();
        return view('dashboard/AirCup/index', $data);
    }

    public function input()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }


        $data_user = $this->AuthModel
                    ->select('users.id as user_id, users.nama, role.id as role_id, role.name, role.label')
                    ->join('role', 'users.role = role.id')
                    ->find($this->session->get('id'));

        if (empty($data_user)) {
            $this->session->destroy();
            return redirect()->to(base_url())->with('alert', [
                'type' => 'error',
                'message' => 'Session expired, please login again!',
                'title' => 'Session Expired',
            ]);
        }


        $data = [
            'title' => 'QC Air Cup',
        ];
        return view('dashboard/AirCup/input', $data);
    }
    

    public function QCAirCupInput()
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
            'shift' => $this->request->getVar('shift'),
        ];
        $this->QCModel->insert($data);

        return redirect()->to(base_url('dashboard/qc_air_cup'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil disimpan.',
            'title' => 'Success',
        ]);
    }
    
    public function QCAirDetail($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }


        $getData = $this->QCModel->find($id);
        $dataUser = $this->AuthModel
                ->select('users.id as user_id, users.nama, role.id as role_id, role.name, role.label')
                ->join('role', 'users.role = role.id')
                ->find($this->session->get('id'));

        if (empty($dataUser)) {
            $this->session->destroy();
            return redirect()->to(base_url())->with('alert', [
                'type' => 'error',
                'message' => 'Session expired, please login again!',
                'title' => 'Session Expired',
            ]);
        }


        $data = [
            'title' => 'Detail QC Air Cup',
            'details' => $getData,
            'data_user' => $dataUser,
            'id' => $id,
            'status' => $getData['status'],
        ];
        return view('dashboard/AirCup/detail', $data);
    }

    public function QCAirUpdate($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }

        $data_user = $this->AuthModel
                ->select('users.id as user_id, users.nama, role.id as role_id, role.name, role.label')
                ->join('role', 'users.role = role.id')
                ->find($this->session->get('id'));

        if (empty($data_user)) {
            $this->session->destroy();
            return redirect()->to(base_url())->with('alert', [
                'type' => 'error',
                'message' => 'Session expired, please login again!',
                'title' => 'Session Expired',
            ]);
        }





        $getData = $this->QCModel->find($id);
        if (!$getData) {
            return redirect()->to(base_url('/dashboard/AirCup/index'))->with('alert', [
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
            'update_date' => json_encode([
                'timestamps' => time(),
                'label' => $this->getLabelTime(),
            ]),
            'shift' => $this->request->getVar('shift'),
        ];

        $this->QCModel->update($id, $data);

        return redirect()->to(base_url('dashboard/qc_air_cup'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil diupdate.',
            'title' => 'Success',
        ]);
    }

    function QCAirReject($id)
    {
        $data = [
            'status' => '2',
        ];

        $this->QCModel->update($id, $data);

        return redirect()->to(base_url('dashboard/qc_air_cup'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil ditolak.',
            'title' => 'Data Ditolak',
        ]);
    }

    function QCAirDelete($id)
    {
        $this->QCModel->delete($id);
        return redirect()->to(base_url('dashboard/qc_air_cup'))->with('alert', [
            'type' => 'success',
            'message' => 'Data berhasil dihapus.',
            'title' => 'Data Dihapus',
        ]);
    }

    private function checkValue($range)
    {
        $credentialsPath = "asset/credentials/service-account.json";
        $client = new Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentialsPath);
        $service = new Sheets($client);

        // Membaca nilai dari range
        $response = $service->spreadsheets_values->get($this->SheetID, $range);
        $values = $response->getValues();

        if (empty($values)) {
            return true;
        } else {
            return false;
        }
    }


    private function CheckedSheet($SheetName)
    {
        $found = false;
        $client = new Client();
        $client->setAuthConfig($this->serviceAccountFile);
        $client->addScope(Sheets::SPREADSHEETS);
        $service = new Sheets($client);
        $response = $service->spreadsheets->get($this->SheetID);
        $sheets = $response->getSheets();
        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() == $SheetName) {
                $found = true;
                break;
            }
        }
        
        if ($found) {
            return true;	
        } else {
            return false;
        }
    }


    private function DuplicateSheet($sheetName)
    {
        $client = new Client();
        $client->setAuthConfig($this->serviceAccountFile);
        $client->addScope(Sheets::SPREADSHEETS);
        $service = new Sheets($client);
        $spreadsheet = $service->spreadsheets->get($this->SheetID);
        $sheets = $spreadsheet->getSheets();
        $templateSheetId = null;
        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() === 'template') {
                $templateSheetId = $sheet->getProperties()->getSheetId();
                break;
            }
        }
    
        if ($templateSheetId === null) {
            throw new Exception("Sheet 'template' tidak ditemukan.");
        }
        $duplicateRequest = new \Google\Service\Sheets\Request([
            'duplicateSheet' => [
                'sourceSheetId' => $templateSheetId,
                'insertSheetIndex' => 0,
                'newSheetName' => 'temp',
            ],
        ]);
    
        $body = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => [$duplicateRequest],
        ]);
    
        $response = $service->spreadsheets->batchUpdate($this->SheetID, $body);
        $sheetId = $response->getReplies()[0]->getDuplicateSheet()->getProperties()->getSheetId();
        $updateRequest = new \Google\Service\Sheets\Request([
            'updateSheetProperties' => [
                'properties' => [
                    'sheetId' => $sheetId,
                    'title' => $sheetName,
                ],
                'fields' => 'title',
            ],
        ]);
    
        $updateBody = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => [$updateRequest],
        ]);
    
        $service->spreadsheets->batchUpdate($this->SheetID, $updateBody);
    }

    function QCAirApprove($id)
    {
        $data = $this->QCModel->find($id);
        $dataUser = $this->AuthModel->find($data['user_id']);
        $QCData = json_decode($data['data'])->data;
        
        try {
            $sheetName = date('F Y', time());
            
            $client = new Client();
            $client->setAuthConfig($this->serviceAccountFile);
            $client->addScope(Sheets::SPREADSHEETS);
            $service = new Sheets($client);
            $range = '';
            $index = 0;

            if (!$this->CheckedSheet($sheetName)) {
                $this->DuplicateSheet($sheetName);
            }

            // Checked Range
            for ($i=5; $i <= 500; $i++) {
                $rangess = $sheetName.'!A'.$i;
                if ($this->checkValue($rangess)) {
                    $range = $rangess;
                    $index = $i;
                    break;
                }
            }


            $nomor = $index - 4;
            $tgljam = json_decode($data['date']);
            $range = $sheetName.'!A'.$index;
            $dataPetugas = [
                [$nomor, $tgljam->label, $data['shift'], $dataUser['nama']],
            ];
            $body = new \Google\Service\Sheets\ValueRange([
                'values' => $dataPetugas,
            ]);
            $params = ['valueInputOption' => 'RAW'];
            $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);


            
            $range = $sheetName.'!AN'.$index;
            $dataPetugas = [
                ["Approval"],
            ];
            $body = new \Google\Service\Sheets\ValueRange([
                'values' => $dataPetugas,
            ]);
            $params = ['valueInputOption' => 'RAW'];
            $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);

            
            $column = ['E', 'F', 'G', 'H', 'I'];
            foreach ($column as $keys => $item) {
                $dataSheet = [];
                $dataSheet[] = $QCData->fisikokimia[$keys]->tds;
                $range = $sheetName.'!'.$item.$index;
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => [$dataSheet],
                ]);
                $params = ['valueInputOption' => 'RAW'];
                $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);
            }


            $column = ['J', 'K', 'L', 'M', 'N'];
            foreach ($column as $keys => $item) {
                $dataSheet = [];
                $dataSheet[] = $QCData->fisikokimia[$keys]->ph;
                $range = $sheetName.'!'.$item.$index;
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => [$dataSheet],
                ]);
                $params = ['valueInputOption' => 'RAW'];
                $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);
            }

            $column = ['O', 'P', 'Q', 'R', 'S'];
            foreach ($column as $keys => $item) {
                $dataSheet = [];
                $dataSheet[] = $QCData->fisikokimia[$keys]->keruhan;
                $range = $sheetName.'!'.$item.$index;
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => [$dataSheet],
                ]);
                $params = ['valueInputOption' => 'RAW'];
                $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);
            }

            $column = ['T', 'U', 'V', 'W', 'X'];
            foreach ($column as $keys => $item) {
                $dataSheet = [];
                $dataSheet[] = $QCData->organoleptik[$keys]->rasa;
                $range = $sheetName.'!'.$item.$index;
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => [$dataSheet],
                ]);
                $params = ['valueInputOption' => 'RAW'];
                $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);
            }
            
            $column = ['Y', 'Z', 'AA', 'AB', 'AC'];
            foreach ($column as $keys => $item) {
                $dataSheet = [];
                $dataSheet[] = $QCData->organoleptik[$keys]->aroma;
                $range = $sheetName.'!'.$item.$index;
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => [$dataSheet],
                ]);
                $params = ['valueInputOption' => 'RAW'];
                $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);
            }

            $column = ['AD', 'AE', 'AF', 'AG', 'AH'];
            foreach ($column as $keys => $item) {
                $dataSheet = [];
                $dataSheet[] = $QCData->organoleptik[$keys]->warna;
                $range = $sheetName.'!'.$item.$index;
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => [$dataSheet],
                ]);
                $params = ['valueInputOption' => 'RAW'];
                $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);
            }

            $column = ['AI', 'AJ', 'AK'];
            foreach ($column as $keys => $item) {
                $dataSheet = [];
                $dataSheet[] = $QCData->mikrobiologi[$keys]->alt;
                $range = $sheetName.'!'.$item.$index;
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => [$dataSheet],
                ]);
                $params = ['valueInputOption' => 'RAW'];
                $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);
            }

            $column = ['AL', 'AM'];
            foreach ($column as $keys => $item) {
                $dataSheet = [];
                $dataSheet[] = $QCData->mikrobiologi[$keys]->ec;
                $range = $sheetName.'!'.$item.$index;
                $body = new \Google\Service\Sheets\ValueRange([
                    'values' => [$dataSheet],
                ]);
                $params = ['valueInputOption' => 'RAW'];
                $service->spreadsheets_values->update($this->SheetID, $range, $body, $params);
            }

            $data = [
                'status' => '1',
            ];
            $this->QCModel->update($id, $data);
            return redirect()->to(base_url('/dashboard/qc_air_cup'))->with('alert', [
                'type' => 'success',
                'message' => 'Data berhasil disetujui.',
                'title' => 'Data Disetujui',
            ]);
        } catch (Google_Service_Exception $e) {
            dd('Google API Error: ' . $e->getMessage());
        } catch (Exception $e) {
            dd('General Error: ' . $e->getMessage());
        }
    }

    function QCAirExport()
    {
        $data = $this->QCModel->findAll();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('asset/excel/qc_air_template.xlsx');
        $sheet = $spreadsheet->getActiveSheet()->setTitle("QC Air Cup");
        $row = 5;
        $number = 1;
        foreach ($data as $item) {

            $dataUser = $this->AuthModel->find($item['user_id']);
            $date = json_decode($item['date']);
            $sheet->setCellValue("A" . $row, $number);
            $sheet->getStyle("A" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet->setCellValue("B" . $row, $date->label);
            $sheet->getStyle("B" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet->setCellValue("C" . $row, $item['shift']);
            $sheet->getStyle("C" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet->setCellValue("D" . $row, $dataUser['nama']);
            $sheet->getStyle("D" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);

            $QCData = json_decode($item['data'])->data;
            $TDSColumns = ['E', 'F', 'G', 'H', 'I'];
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

            $PHColumns = ['J', 'K', 'L', 'M', 'N'];
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

            $KERUHANColumns = ['O', 'P', 'Q', 'R', 'S'];
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

            $RASAColumns = ['T', 'U', 'V', 'W', 'X'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $rasaValue = strtolower($organoleptik->rasa);
                $sheet->setCellValue($RASAColumns[$index] . $row, $rasaValue);
                $sheet->getStyle($RASAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if (strpos(strtolower($rasaValue), 'normal') === 0) {
                        $sheet->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } else {
                        $sheet->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $AROMAColumns = ['Y', 'Z', 'AA', 'AB', 'AC'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $aromaValue = $organoleptik->aroma;
                $sheet->setCellValue($AROMAColumns[$index] . $row, $rasaValue);
                $sheet->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if (strpos(strtolower($aromaValue), 'normal') === 0) {
                        $sheet->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } else {
                        $sheet->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $WARNAColumns = ['AD', 'AE', 'AF', 'AG', 'AH'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $warnaValue = $organoleptik->warna;
                $sheet->setCellValue($WARNAColumns[$index] . $row, $warnaValue);
                $sheet->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($warnaValue !== null && $warnaValue !== '') {
                    if (strpos(strtolower($warnaValue), 'normal') === 0) {
                        $sheet->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } else {
                        $sheet->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ALTColumns = ['AI', 'AJ', 'AK'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                $altValue = $mikrobiologi->alt;
                $sheet->setCellValue($ALTColumns[$index] . $row, $altValue);
                $sheet->getStyle($ALTColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($altValue !== null && $altValue !== '') {
                    if ($altValue <= 1.0) {
                        $sheet->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($altValue >= 1.1 && $altValue <= 1.5) {
                        $sheet->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ECColumns = ['AL', 'AM'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                // dd($mikrobiologi->ec);
                $ecValue = $mikrobiologi->ec ?? null;
                if (isset($ECColumns[$index])) {
                    $sheet->setCellValue($ECColumns[$index] . $row, $ecValue);
                }
                if (isset($ECColumns[$index])) {
                    $sheet->getStyle($ECColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                }
                if ($ecValue !== null && $ecValue !== '') {
                    if ($ecValue <= 1.0) {
                        $sheet->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($ecValue >= 1.1 && $ecValue <= 1.5) {
                        $sheet->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $STATUSColumns = ['AN'];
            $statusValue = $item['status'];
            $sheet->setCellValue($STATUSColumns[0] . $row, $statusValue === '1' ? 'Approval' : ($statusValue === '2' ? 'Reject' : ''));
            $sheet->getStyle($STATUSColumns[0] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            if ($statusValue === '1') {
                $sheet->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
            } elseif ($statusValue === '2') {
                $sheet->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
            }

            $row++;
            $number++;
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'qc_air_cup_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
