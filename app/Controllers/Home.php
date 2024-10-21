<?php

namespace App\Controllers;
use App\Models\AuthModel;

use App\Models\QcAirBotolModel;
use App\Models\QcAirBakuModel;
use App\Models\QcAirGalonModel;
use App\Models\QcAirCupModel;

class Home extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->AuthModel = new AuthModel();
        $this->session = \Config\Services::session();

        $this->QCAirBotolModel = new QcAirBotolModel();
        $this->QcAirGalonModel = new QcAirGalonModel();
        $this->QcAirCupModel = new QcAirCupModel();
        $this->QcAirBakuModel = new QcAirBakuModel();
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


        $usersData = $this->AuthModel
                    ->select('users.id as user_id, users.nama, users.img, role.id as role_id, role.name, role.label')
                    ->join('role', 'users.role = role.id')
                    ->find($this->session->get('id'));

        // dd($usersData);
        $data = [
            'title' => 'Dashboard',
            'user' => $usersData,
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

    public function ManageAccount()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }

        return view('dashboard/ManageAccount');
    }

    public function ExportAllExcel()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('alert', [
                'type' => 'warning',
                'message' => 'Anda harus login terlebih dahulu!',
                'title' => 'Permission Denied',
            ]);
        }
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(FCPATH . 'data/public/asset/excel/qc_air_all_template.xlsx');
        
        
        $data = $this->QCAirBotolModel->findAll();
        $sheet1 = $spreadsheet->getSheetByName("QC Air Botol");
        $row = 5;
        $number = 1;
        foreach ($data as $item) {

            $dataUser = $this->AuthModel->find($item['user_id']);
            $date = json_decode($item['date']);
            $sheet1->setCellValue("A" . $row, $number);
            $sheet1->getStyle("A" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet1->setCellValue("B" . $row, $date->label);
            $sheet1->getStyle("B" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet1->setCellValue("C" . $row, $item['shift']);
            $sheet1->getStyle("C" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet1->setCellValue("D" . $row, $dataUser['nama']);
            $sheet1->getStyle("D" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);

            $QCData = json_decode($item['data'])->data;
            $TDSColumns = ['E', 'F', 'G', 'H', 'I'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $tdsValue = $fisikokimia->tds;
                $sheet1->setCellValue($TDSColumns[$index] . $row, $tdsValue);
                $sheet1->getStyle($TDSColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($tdsValue !== null && $tdsValue !== '') {
                    if ($tdsValue >= 0 && $tdsValue <= 5) {
                        $sheet1->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($tdsValue >= 6 && $tdsValue <= 10) {
                        $sheet1->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet1->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $PHColumns = ['J', 'K', 'L', 'M', 'N'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $phValue = $fisikokimia->ph;
                $sheet1->setCellValue($PHColumns[$index] . $row, $phValue);
                $sheet1->getStyle($PHColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($phValue !== null && $phValue !== '') {
                    if ($phValue >= 5.0 && $phValue <= 7.0) {
                        $sheet1->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($phValue >= 7.1 && $phValue <= 7.5) {
                        $sheet1->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet1->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $KERUHANColumns = ['O', 'P', 'Q', 'R', 'S'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $keruhanValue = $fisikokimia->keruhan;
                $sheet1->setCellValue($KERUHANColumns[$index] . $row, $keruhanValue);
                $sheet1->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($keruhanValue !== null && $keruhanValue !== '') {
                    if ($keruhanValue <= 1.0) {
                        $sheet1->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($keruhanValue >= 1.1 && $keruhanValue <= 1.5) {
                        $sheet1->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet1->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $RASAColumns = ['T', 'U', 'V', 'W', 'X'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $rasaValue = strtolower($organoleptik->rasa);
                $sheet1->setCellValue($RASAColumns[$index] . $row, $rasaValue);
                $sheet1->getStyle($RASAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if ($rasaValue == "normal") {
                        $sheet1->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($rasaValue == "pahit") {
                        $sheet1->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet1->setCellValue($RASAColumns[$index] . $row, "-");
                        $sheet1->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                } else {
                    $sheet1->setCellValue($RASAColumns[$index] . $row, "-");
                    $sheet1->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                }
            }

            $AROMAColumns = ['Y', 'Z', 'AA', 'AB', 'AC'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $aromaValue = $organoleptik->aroma;
                $sheet1->setCellValue($AROMAColumns[$index] . $row, $rasaValue);
                $sheet1->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if ($aromaValue <= 1.0) {
                        $sheet1->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($aromaValue >= 1.1 && $aromaValue <= 1.5) {
                        $sheet1->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet1->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $WARNAColumns = ['AD', 'AE', 'AF', 'AG', 'AH'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $warnaValue = $organoleptik->warna;
                $sheet1->setCellValue($WARNAColumns[$index] . $row, $warnaValue);
                $sheet1->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($warnaValue !== null && $warnaValue !== '') {
                    if ($warnaValue <= 1.0) {
                        $sheet1->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($warnaValue >= 1.1 && $warnaValue <= 1.5) {
                        $sheet1->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet1->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ALTColumns = ['AI', 'AJ', 'AK'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                $altValue = $mikrobiologi->alt;
                $sheet1->setCellValue($ALTColumns[$index] . $row, $altValue);
                $sheet1->getStyle($ALTColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($altValue !== null && $altValue !== '') {
                    if ($altValue <= 1.0) {
                        $sheet1->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($altValue >= 1.1 && $altValue <= 1.5) {
                        $sheet1->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet1->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ECColumns = ['AL', 'AM'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                // dd($mikrobiologi->ec);
                $ecValue = $mikrobiologi->ec ?? null;
                if (isset($ECColumns[$index])) {
                    $sheet1->setCellValue($ECColumns[$index] . $row, $ecValue);
                }
                if (isset($ECColumns[$index])) {
                    $sheet1->getStyle($ECColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                }
                if ($ecValue !== null && $ecValue !== '') {
                    if ($ecValue <= 1.0) {
                        $sheet1->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($ecValue >= 1.1 && $ecValue <= 1.5) {
                        $sheet1->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet1->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $STATUSColumns = ['AN'];
            $statusValue = $item['status'];
            $sheet1->setCellValue($STATUSColumns[0] . $row, $statusValue === '1' ? 'Approval' : ($statusValue === '2' ? 'Reject' : ''));
            $sheet1->getStyle($STATUSColumns[0] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            if ($statusValue === '1') {
                $sheet1->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
            } elseif ($statusValue === '2') {
                $sheet1->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
            }

            $row++;
            $number++;
        }



        // QC Air Galon
        $data = $this->QcAirGalonModel->findAll();
        $sheet3 = $spreadsheet->getSheetByName("QC Air Galon");
        $row = 5;
        $number = 1;
        foreach ($data as $item) {

            $dataUser = $this->AuthModel->find($item['user_id']);
            $date = json_decode($item['date']);
            $sheet3->setCellValue("A" . $row, $number);
            $sheet3->getStyle("A" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet3->setCellValue("B" . $row, $date->label);
            $sheet3->getStyle("B" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet3->setCellValue("C" . $row, $item['shift']);
            $sheet3->getStyle("C" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet3->setCellValue("D" . $row, $dataUser['nama']);
            $sheet3->getStyle("D" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);

            $QCData = json_decode($item['data'])->data;
            $TDSColumns = ['E', 'F', 'G', 'H', 'I'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $tdsValue = $fisikokimia->tds;
                $sheet3->setCellValue($TDSColumns[$index] . $row, $tdsValue);
                $sheet3->getStyle($TDSColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($tdsValue !== null && $tdsValue !== '') {
                    if ($tdsValue >= 0 && $tdsValue <= 5) {
                        $sheet3->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($tdsValue >= 6 && $tdsValue <= 10) {
                        $sheet3->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet3->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $PHColumns = ['J', 'K', 'L', 'M', 'N'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $phValue = $fisikokimia->ph;
                $sheet3->setCellValue($PHColumns[$index] . $row, $phValue);
                $sheet3->getStyle($PHColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($phValue !== null && $phValue !== '') {
                    if ($phValue >= 5.0 && $phValue <= 7.0) {
                        $sheet3->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($phValue >= 7.1 && $phValue <= 7.5) {
                        $sheet3->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet3->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $KERUHANColumns = ['O', 'P', 'Q', 'R', 'S'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $keruhanValue = $fisikokimia->keruhan;
                $sheet3->setCellValue($KERUHANColumns[$index] . $row, $keruhanValue);
                $sheet3->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($keruhanValue !== null && $keruhanValue !== '') {
                    if ($keruhanValue <= 1.0) {
                        $sheet3->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($keruhanValue >= 1.1 && $keruhanValue <= 1.5) {
                        $sheet3->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet3->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $RASAColumns = ['T', 'U', 'V', 'W', 'X'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $rasaValue = strtolower($organoleptik->rasa);
                $sheet3->setCellValue($RASAColumns[$index] . $row, $rasaValue);
                $sheet3->getStyle($RASAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if ($rasaValue == "normal") {
                        $sheet3->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($rasaValue == "pahit") {
                        $sheet3->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet3->setCellValue($RASAColumns[$index] . $row, "-");
                        $sheet3->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                } else {
                    $sheet3->setCellValue($RASAColumns[$index] . $row, "-");
                    $sheet3->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                }
            }

            $AROMAColumns = ['Y', 'Z', 'AA', 'AB', 'AC'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $aromaValue = $organoleptik->aroma;
                $sheet3->setCellValue($AROMAColumns[$index] . $row, $rasaValue);
                $sheet3->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if ($aromaValue <= 1.0) {
                        $sheet3->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($aromaValue >= 1.1 && $aromaValue <= 1.5) {
                        $sheet3->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet3->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $WARNAColumns = ['AD', 'AE', 'AF', 'AG', 'AH'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $warnaValue = $organoleptik->warna;
                $sheet3->setCellValue($WARNAColumns[$index] . $row, $warnaValue);
                $sheet3->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($warnaValue !== null && $warnaValue !== '') {
                    if ($warnaValue <= 1.0) {
                        $sheet3->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($warnaValue >= 1.1 && $warnaValue <= 1.5) {
                        $sheet3->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet3->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ALTColumns = ['AI', 'AJ', 'AK'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                $altValue = $mikrobiologi->alt;
                $sheet3->setCellValue($ALTColumns[$index] . $row, $altValue);
                $sheet3->getStyle($ALTColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($altValue !== null && $altValue !== '') {
                    if ($altValue <= 1.0) {
                        $sheet3->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($altValue >= 1.1 && $altValue <= 1.5) {
                        $sheet3->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet3->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ECColumns = ['AL', 'AM'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                // dd($mikrobiologi->ec);
                $ecValue = $mikrobiologi->ec ?? null;
                if (isset($ECColumns[$index])) {
                    $sheet3->setCellValue($ECColumns[$index] . $row, $ecValue);
                }
                if (isset($ECColumns[$index])) {
                    $sheet3->getStyle($ECColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                }
                if ($ecValue !== null && $ecValue !== '') {
                    if ($ecValue <= 1.0) {
                        $sheet3->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($ecValue >= 1.1 && $ecValue <= 1.5) {
                        $sheet3->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet3->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $STATUSColumns = ['AN'];
            $statusValue = $item['status'];
            $sheet3->setCellValue($STATUSColumns[0] . $row, $statusValue === '1' ? 'Approval' : ($statusValue === '2' ? 'Reject' : ''));
            $sheet3->getStyle($STATUSColumns[0] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            if ($statusValue === '1') {
                $sheet3->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
            } elseif ($statusValue === '2') {
                $sheet3->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
            }

            $row++;
            $number++;
        }


        // QC Air Cup
        $data = $this->QcAirCupModel->findAll();
        $sheet2 = $spreadsheet->getSheetByName("QC Air Cup");
        $row = 5;
        $number = 1;
        foreach ($data as $item) {

            $dataUser = $this->AuthModel->find($item['user_id']);
            $date = json_decode($item['date']);
            $sheet2->setCellValue("A" . $row, $number);
            $sheet2->getStyle("A" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet2->setCellValue("B" . $row, $date->label);
            $sheet2->getStyle("B" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet2->setCellValue("C" . $row, $item['shift']);
            $sheet2->getStyle("C" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet2->setCellValue("D" . $row, $dataUser['nama']);
            $sheet2->getStyle("D" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);

            $QCData = json_decode($item['data'])->data;
            $TDSColumns = ['E', 'F', 'G', 'H', 'I'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $tdsValue = $fisikokimia->tds;
                $sheet2->setCellValue($TDSColumns[$index] . $row, $tdsValue);
                $sheet2->getStyle($TDSColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($tdsValue !== null && $tdsValue !== '') {
                    if ($tdsValue >= 0 && $tdsValue <= 5) {
                        $sheet2->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($tdsValue >= 6 && $tdsValue <= 10) {
                        $sheet2->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $PHColumns = ['J', 'K', 'L', 'M', 'N'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $phValue = $fisikokimia->ph;
                $sheet2->setCellValue($PHColumns[$index] . $row, $phValue);
                $sheet2->getStyle($PHColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($phValue !== null && $phValue !== '') {
                    if ($phValue >= 5.0 && $phValue <= 7.0) {
                        $sheet2->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($phValue >= 7.1 && $phValue <= 7.5) {
                        $sheet2->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $KERUHANColumns = ['O', 'P', 'Q', 'R', 'S'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $keruhanValue = $fisikokimia->keruhan;
                $sheet2->setCellValue($KERUHANColumns[$index] . $row, $keruhanValue);
                $sheet2->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($keruhanValue !== null && $keruhanValue !== '') {
                    if ($keruhanValue <= 1.0) {
                        $sheet2->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($keruhanValue >= 1.1 && $keruhanValue <= 1.5) {
                        $sheet2->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $RASAColumns = ['T', 'U', 'V', 'W', 'X'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $rasaValue = strtolower($organoleptik->rasa);
                $sheet2->setCellValue($RASAColumns[$index] . $row, $rasaValue);
                $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if ($rasaValue == "normal") {
                        $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($rasaValue == "pahit") {
                        $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->setCellValue($RASAColumns[$index] . $row, "-");
                        $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                } else {
                    $sheet2->setCellValue($RASAColumns[$index] . $row, "-");
                    $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                }
            }

            $AROMAColumns = ['Y', 'Z', 'AA', 'AB', 'AC'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $aromaValue = $organoleptik->aroma;
                $sheet2->setCellValue($AROMAColumns[$index] . $row, $rasaValue);
                $sheet2->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if ($aromaValue <= 1.0) {
                        $sheet2->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($aromaValue >= 1.1 && $aromaValue <= 1.5) {
                        $sheet2->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $WARNAColumns = ['AD', 'AE', 'AF', 'AG', 'AH'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $warnaValue = $organoleptik->warna;
                $sheet2->setCellValue($WARNAColumns[$index] . $row, $warnaValue);
                $sheet2->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($warnaValue !== null && $warnaValue !== '') {
                    if ($warnaValue <= 1.0) {
                        $sheet2->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($warnaValue >= 1.1 && $warnaValue <= 1.5) {
                        $sheet2->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ALTColumns = ['AI', 'AJ', 'AK'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                $altValue = $mikrobiologi->alt;
                $sheet2->setCellValue($ALTColumns[$index] . $row, $altValue);
                $sheet2->getStyle($ALTColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($altValue !== null && $altValue !== '') {
                    if ($altValue <= 1.0) {
                        $sheet2->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($altValue >= 1.1 && $altValue <= 1.5) {
                        $sheet2->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ECColumns = ['AL', 'AM'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                // dd($mikrobiologi->ec);
                $ecValue = $mikrobiologi->ec ?? null;
                if (isset($ECColumns[$index])) {
                    $sheet2->setCellValue($ECColumns[$index] . $row, $ecValue);
                }
                if (isset($ECColumns[$index])) {
                    $sheet2->getStyle($ECColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                }
                if ($ecValue !== null && $ecValue !== '') {
                    if ($ecValue <= 1.0) {
                        $sheet2->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($ecValue >= 1.1 && $ecValue <= 1.5) {
                        $sheet2->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $STATUSColumns = ['AN'];
            $statusValue = $item['status'];
            $sheet2->setCellValue($STATUSColumns[0] . $row, $statusValue === '1' ? 'Approval' : ($statusValue === '2' ? 'Reject' : ''));
            $sheet2->getStyle($STATUSColumns[0] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            if ($statusValue === '1') {
                $sheet2->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
            } elseif ($statusValue === '2') {
                $sheet2->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
            }

            $row++;
            $number++;
        }


        // QC Air Baku
        $data = $this->QcAirBakuModel->findAll();
        $sheet2 = $spreadsheet->getSheetByName("QC Air Baku");
        $row = 5;
        $number = 1;
        foreach ($data as $item) {

            $dataUser = $this->AuthModel->find($item['user_id']);
            $date = json_decode($item['date']);
            $sheet2->setCellValue("A" . $row, $number);
            $sheet2->getStyle("A" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet2->setCellValue("B" . $row, $date->label);
            $sheet2->getStyle("B" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet2->setCellValue("C" . $row, $item['shift']);
            $sheet2->getStyle("C" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            $sheet2->setCellValue("D" . $row, $dataUser['nama']);
            $sheet2->getStyle("D" . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);

            $QCData = json_decode($item['data'])->data;
            $TDSColumns = ['E', 'F', 'G', 'H', 'I'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $tdsValue = $fisikokimia->tds;
                $sheet2->setCellValue($TDSColumns[$index] . $row, $tdsValue);
                $sheet2->getStyle($TDSColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($tdsValue !== null && $tdsValue !== '') {
                    if ($tdsValue >= 0 && $tdsValue <= 5) {
                        $sheet2->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($tdsValue >= 6 && $tdsValue <= 10) {
                        $sheet2->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($TDSColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $PHColumns = ['J', 'K', 'L', 'M', 'N'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $phValue = $fisikokimia->ph;
                $sheet2->setCellValue($PHColumns[$index] . $row, $phValue);
                $sheet2->getStyle($PHColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($phValue !== null && $phValue !== '') {
                    if ($phValue >= 5.0 && $phValue <= 7.0) {
                        $sheet2->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($phValue >= 7.1 && $phValue <= 7.5) {
                        $sheet2->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($PHColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $KERUHANColumns = ['O', 'P', 'Q', 'R', 'S'];
            foreach ($QCData->fisikokimia as $index => $fisikokimia) {
                $keruhanValue = $fisikokimia->keruhan;
                $sheet2->setCellValue($KERUHANColumns[$index] . $row, $keruhanValue);
                $sheet2->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($keruhanValue !== null && $keruhanValue !== '') {
                    if ($keruhanValue <= 1.0) {
                        $sheet2->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($keruhanValue >= 1.1 && $keruhanValue <= 1.5) {
                        $sheet2->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($KERUHANColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $RASAColumns = ['T', 'U', 'V', 'W', 'X'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $rasaValue = strtolower($organoleptik->rasa);
                $sheet2->setCellValue($RASAColumns[$index] . $row, $rasaValue);
                $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if ($rasaValue == "normal") {
                        $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($rasaValue == "pahit") {
                        $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->setCellValue($RASAColumns[$index] . $row, "-");
                        $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                } else {
                    $sheet2->setCellValue($RASAColumns[$index] . $row, "-");
                    $sheet2->getStyle($RASAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                }
            }

            $AROMAColumns = ['Y', 'Z', 'AA', 'AB', 'AC'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $aromaValue = $organoleptik->aroma;
                $sheet2->setCellValue($AROMAColumns[$index] . $row, $rasaValue);
                $sheet2->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($rasaValue !== null && $rasaValue !== '') {
                    if ($aromaValue <= 1.0) {
                        $sheet2->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($aromaValue >= 1.1 && $aromaValue <= 1.5) {
                        $sheet2->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($AROMAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $WARNAColumns = ['AD', 'AE', 'AF', 'AG', 'AH'];
            foreach ($QCData->organoleptik as $index => $organoleptik) {
                $warnaValue = $organoleptik->warna;
                $sheet2->setCellValue($WARNAColumns[$index] . $row, $warnaValue);
                $sheet2->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($warnaValue !== null && $warnaValue !== '') {
                    if ($warnaValue <= 1.0) {
                        $sheet2->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($warnaValue >= 1.1 && $warnaValue <= 1.5) {
                        $sheet2->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($WARNAColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ALTColumns = ['AI', 'AJ', 'AK'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                $altValue = $mikrobiologi->alt;
                $sheet2->setCellValue($ALTColumns[$index] . $row, $altValue);
                $sheet2->getStyle($ALTColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                if ($altValue !== null && $altValue !== '') {
                    if ($altValue <= 1.0) {
                        $sheet2->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($altValue >= 1.1 && $altValue <= 1.5) {
                        $sheet2->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($ALTColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $ECColumns = ['AL', 'AM'];
            foreach ($QCData->mikrobiologi as $index => $mikrobiologi) {
                // dd($mikrobiologi->ec);
                $ecValue = $mikrobiologi->ec ?? null;
                if (isset($ECColumns[$index])) {
                    $sheet2->setCellValue($ECColumns[$index] . $row, $ecValue);
                }
                if (isset($ECColumns[$index])) {
                    $sheet2->getStyle($ECColumns[$index] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
                }
                if ($ecValue !== null && $ecValue !== '') {
                    if ($ecValue <= 1.0) {
                        $sheet2->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
                    } elseif ($ecValue >= 1.1 && $ecValue <= 1.5) {
                        $sheet2->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]]);
                    } else {
                        $sheet2->getStyle($ECColumns[$index] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
                    }
                }
            }

            $STATUSColumns = ['AN'];
            $statusValue = $item['status'];
            $sheet2->setCellValue($STATUSColumns[0] . $row, $statusValue === '1' ? 'Approval' : ($statusValue === '2' ? 'Reject' : ''));
            $sheet2->getStyle($STATUSColumns[0] . $row)->applyFromArray(['borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '00000000']]]]);
            if ($statusValue === '1') {
                $sheet2->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']]]);
            } elseif ($statusValue === '2') {
                $sheet2->getStyle($STATUSColumns[0] . $row)->applyFromArray(['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF0000']]]);
            }

            $row++;
            $number++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'QC Air ' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');


    }
}
