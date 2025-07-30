<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 1000);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Audit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
        $this->db2 = $this->load->database('mssql', TRUE);
        $this->load->model("Audit_M");
    }

    public function index()
    {
        $data['title'] = 'Audit';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();
        $data['audit_action'] = $this->db->get('m_audit_action')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('audit/index', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/script', $data);
    }

    public function previewData()
    {
        $data = array();

        $file_format = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (!in_array($_FILES['file']['type'], $file_format)) {
            http_response_code(400);
            echo "Format file not valid !";
            return;
        }

        $inAuditaction = $this->input->post('inAuditaction');

        if ($_FILES['file']['name']) {
            $path = $_FILES['file']['tmp_name'];
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            if (!empty($sheet)) {
                $data['res'] = "success";
                $data['sheetData'] = $sheet;
                $data['inAuditaction'] = $inAuditaction;
            }

            $this->load->view('audit/view_data', $data); // return view with table HTML
        } else {
            http_response_code(400);
            echo "No file uploaded !";
        }
    }

    public function uploadData()
    {
        $data = array();
        $id = "";

        $file_format = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (!in_array($_FILES['file']['type'], $file_format)) {
            http_response_code(400);
            echo "Format file not valid !";
            return;
        }

        $inAuditaction = $this->input->post('inAuditaction');

        if ($_FILES['file']['name']) {
            $path = $_FILES['file']['tmp_name'];
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            if (!empty($sheet)) {
                if ($inAuditaction == 1 || $inAuditaction == 2) {
                    foreach ($sheet as $i => $row) {
                        if ($i == 0 || empty(array_filter($row))) continue;
                        $id .= "'" . $row[0] . "',";
                    }
                }

                $id = rtrim($id, ",");
            }

            if ($inAuditaction == 1) {
                $table = "`hrms`.audit_bb_tb_m_kry";
                $division_id = '11330000000003';
            } else if ($inAuditaction == 2) {
                $table = "`hrms`.audit_mmp_tb_m_kry";
                $division_id = '11330000000001';
            }

            $query = "TRUNCATE " . $table;

            if (! $this->db->query($query)) {
                http_response_code(400);
                echo "Error Truncate Table " . $table . " !";
            }

            $query1 = "INSERT INTO " . $table . " 
                       SELECT * FROM hrms.tb_m_kry a WHERE a.Stat = 'Aktif' AND a.Ucode_Div = '" . $division_id . "' AND a.Kode_Kry IN (" . $id . ");";

            echo $query1;

            if (! $this->db->query($query1)) {
                http_response_code(400);
                echo "Error Insert Table " . $table . " !";
            } else {
                // http_response_code(500);
                echo "Success !";
            }
            // $this->load->view('audit/view_data', $data); // return view with table HTML
        } else {
            http_response_code(400);
            echo "No file uploaded !";
        }
    }

    public function sync()
    {
        $res = array();
        $inAuditaction = $this->input->post('inAuditaction');

        $query = "TRUNCATE hrms.tb_m_kry";

        $this->db->db_debug = false;

        if (! $this->db->query($query)) {
            $res['res'] =  $this->db->error();
            $res['res'] = $res['res']['message'];
            return $res;
        }

        if ($inAuditaction == 3) {
            $batch_size = 500;
            $offset = 0;

            do {
                $this->db2->limit($batch_size, $offset);
                $mssql_data = $this->db2->get('tb_m_Kry');
                $rows = $mssql_data->result_array();

                if (empty($rows)) {
                    break;
                }

                foreach ($rows as $row) {
                    if (! $this->db->insert('hrms.tb_m_Kry', $row)) {
                        $res['res'] =  $this->db->error();
                        $res['res'] = $res['res']['message'];
                        return $res;
                    }
                }

                $offset += $batch_size;
            } while (true);
            $res['res'] = 'success';
        }

        echo json_encode($res);
    }

    public function template()
    {
        echo "lalala";
        $param = $this->input->get('param');



        if ($param == 2) {
            echo $param;
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $fileName = 'Template Upload Data Master Employee - ' . date("Y-m-d H:i:s");

            // $style_col = [
            //     'font' => ['bold' => true], // Set font nya jadi bold
            //     'alignment' => [
            //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            //     ],
            //     'borders' => [
            //         'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            //         'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            //         'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            //         'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            //     ]
            // ];

            //     $style_row = [
            //         'alignment' => [
            //             'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            //         ],
            //         'borders' => [
            //             'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            //             'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            //             'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            //             'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            //         ]
            //     ];

            $numrow = 1;
            $sheet->setCellValue('A' . $numrow, "ID");

            // $sheet->getStyle('A' . $numrow)->applyFromArray($style_col);

            $sheet->getDefaultRowDimension()->setRowHeight(-1);
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

            $sheet->setTitle("Template Upload Data");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }
    }
}
