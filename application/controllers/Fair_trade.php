<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Fair_trade extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
        $this->load->model("Fair_trade_M");
    }

    public function index() {}

    public function collection()
    {
        $data['title'] = 'Collection Data';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();
        $data['collection'] = $this->db->get('m_collection')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('fair_trade/index', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/script', $data);
    }

    public function check()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->Fair_trade_M->check($param, $obj);

        echo (json_encode($data));
    }

    public function viewData()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');
        $inWhere = $this->input->post('inWhere');

        if ($param == 1) {
            $query = "SELECT 
                        *, 
                        (SELECT Nama_Dept FROM hrms.tb_m_dept WHERE Ucode_Dept = dt2.Ucode_Dept ) AS Nama_Dept,
                        (SELECT Nama_Sec FROM hrms.tb_m_sec WHERE Ucode_Sec = dt2.Ucode_Sec ) AS Nama_Sec
                        FROM 
                        (
                            SELECT 
                                id, collection_id, `status` 
                            FROM m_employee_collection
                            WHERE
                                collection_id = '" . $param . "' AND `status` = 1
                        )dt1 
                        JOIN 
                        (
                            SELECT 
                                Kode_Kry, Nama_Kry, No_RFID, Ucode_Dept, Ucode_Sec 
                            FROM hrms.tb_m_kry 
                            WHERE 1
                        )dt2
                        ON dt1.id = dt2.Kode_Kry 
                        WHERE 1 " . $inWhere;

            $data['collection'] = $this->db->query($query)->result_array();
        }


        $this->load->view('fair_trade/view_data', $data);
    }

    public function get()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->Fair_trade_M->get($param, $obj);

        echo (json_encode($data));
    }

    public function report()
    {
        $param = $this->input->get('param');
        $obj = $this->input->get('obj');
        $where = $this->input->get('where');

        if ($param == "pdf") {
            if ($obj == 1) {
                $query = "SELECT 
                        *, 
                        (SELECT Nama_Dept FROM hrms.tb_m_dept WHERE Ucode_Dept = dt2.Ucode_Dept ) AS Nama_Dept,
                        (SELECT Nama_Sec FROM hrms.tb_m_sec WHERE Ucode_Sec = dt2.Ucode_Sec ) AS Nama_Sec
                        FROM 
                        (
                            SELECT 
                                id, collection_id, `status` 
                            FROM m_employee_collection
                            WHERE
                                collection_id = '" . $obj . "' AND `status` = 1
                        )dt1 
                        JOIN 
                        (
                            SELECT 
                                Kode_Kry, Nama_Kry, No_RFID, Ucode_Dept, Ucode_Sec 
                            FROM hrms.tb_m_kry 
                            WHERE 1
                        )dt2
                        ON dt1.id = dt2.Kode_Kry 
                        WHERE 1 " . $where;

                $data['collection'] = $this->db->query($query)->result_array();

                $fileName = 'Report Data Collection - ' . date("Y-m-d H:i:s");
                $data['title_pdf'] = $fileName;

                $mpdf = new \Mpdf\Mpdf([
                    'orientation' => 'P',
                    'format' => 'A4',
                    'margin_left' => '5',
                    'margin_right' => '5',
                    'margin_top' => '30'
                ]);

                $mpdf->SetTitle($fileName);

                $header =   "<table>
                                <tr>
                                    <td>
                                        <img src='" . base_url() . "assets/img/logo_mmp_small.jpg'> 
                                    </td>
                                    <td>
                                        <b style='font-size: 20px;'>PT MEGA MARINE PRIDE</b><br/>
                                        <b>Ds. WONOKOYO - Kec. Beji 67154</b><br/>
                                        <b>Pasuruan Indonesia</b><br/>
                                        Telp. (0343) 656446 / (0343) 656513
                                    </td>
                                </tr>
                                </table>
                                <div style='text-align:center'>
                                    <h3>Report Data Exit Permit</h3>
                                </div>";

                $mpdf->SetHTMLHeader($header);

                $footer = array(
                    'odd' => array(
                        'L' => array(
                            'content' =>  $this->session->userdata['name'] . " - " . date("Y-m-d H:i:s"),
                            'font-size' => 10
                        ),
                        'R' => array(
                            'content' => '{PAGENO} of {nbpg}',
                            'font-size' => 10
                        ),
                        'line' => 0,
                    ),
                    'even' => array()
                );

                $mpdf->setFooter($footer);

                $html = $this->load->view('fair_trade/report/pdf', $data, true);
                $mpdf->AddPage(
                    'P', // L - landscape, P - portrait 
                    '',
                    '',
                    '',
                    '',
                    5, // margin_left
                    5, // margin right
                    34, // margin top
                    10, // margin bottom
                    0, // margin header
                    1 // margin footer
                );
                // $mpdf->showImageErrors = true;
                $mpdf->WriteHTML($html);
                $mpdf->Output($fileName . ".pdf", 'I');
            }
        } else if ($param == "excel") {
            if ($obj == 1) {
                $query = "SELECT 
                        *, 
                        (SELECT Nama_Dept FROM hrms.tb_m_dept WHERE Ucode_Dept = dt2.Ucode_Dept ) AS Nama_Dept,
                        (SELECT Nama_Sec FROM hrms.tb_m_sec WHERE Ucode_Sec = dt2.Ucode_Sec ) AS Nama_Sec
                        FROM 
                        (
                            SELECT 
                                id, collection_id, `status` 
                            FROM m_employee_collection
                            WHERE
                                collection_id = '" . $obj . "' AND `status` = 1
                        )dt1 
                        JOIN 
                        (
                            SELECT 
                                Kode_Kry, Nama_Kry, No_RFID, Ucode_Dept, Ucode_Sec 
                            FROM hrms.tb_m_kry 
                            WHERE 1
                        )dt2
                        ON dt1.id = dt2.Kode_Kry 
                        WHERE 1 " . $where;

                $data['collection'] = $this->db->query($query)->result_array();

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $fileName = 'Report Data Collection - ' . date("Y-m-d H:i:s");

                $style_col = [
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                    ]
                ];

                $style_row = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                    ]
                ];

                $numrow = 1;
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setPath("assets/img/logo_mmp_small.png");
                $drawing->setCoordinates('A' . $numrow);
                $drawing->setWorksheet($spreadsheet->getActiveSheet());

                $sheet->setCellValue('C' . $numrow, "PT MEGA MARINE PRIDE");
                $sheet->setCellValue('C' . $numrow + 1, "Ds. WONOKOYO - Kec. Beji 67154");
                $sheet->setCellValue('C' . $numrow + 2, "Pasuruan Indonesia");
                $sheet->setCellValue('C' . $numrow + 3, "Telp. (0343) 656446 / (0343) 656513");

                $sheet->getStyle('C' . $numrow . ':C' . $numrow + 3)->getFont()->setBold(true);

                $numrow = $numrow + 5;
                $sheet->setCellValue('A' . $numrow, "Report Data Collection");
                $sheet->mergeCells('A' . $numrow . ':E' . $numrow);
                $sheet->getStyle('A' . $numrow)->getFont()->setBold(true);
                $sheet->getStyle('A' . $numrow)->getAlignment()->setHorizontal('center');

                $numrow = $numrow + 2;

                $sheet->setCellValue('A' . $numrow, "No");
                $sheet->setCellValue('B' . $numrow, "ID");
                $sheet->setCellValue('C' . $numrow, "Name");
                $sheet->setCellValue('D' . $numrow, "Department");
                $sheet->setCellValue('E' . $numrow, "Section");

                $sheet->getStyle('A' . $numrow)->applyFromArray($style_col);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_col);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_col);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_col);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_col);

                $i = 1;
                $numrow = $numrow + 1;
                foreach ($data['collection'] as $data_collection) {
                    $sheet->setCellValue('A' . $numrow, $i);
                    $sheet->setCellValue('B' . $numrow, $data_collection['id']);
                    $sheet->setCellValue('C' . $numrow, $data_collection['Nama_Kry']);
                    $sheet->setCellValue('D' . $numrow, $data_collection['Nama_Dept']);
                    $sheet->setCellValue('E' . $numrow, $data_collection['Nama_Sec']);

                    $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                    $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                    $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                    $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                    $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);

                    $i++;
                    $numrow++;
                }

                // echo $param . "lalala" . $obj . "yeyeye" . $where;
                // die();

                foreach (range('B', 'E') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
                $sheet->getDefaultRowDimension()->setRowHeight(-1);
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                // echo $param . "lalala" . $obj . "yeyeye" . $where;
                // die();

                $sheet->setTitle("Report Data Collection");
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $fileName . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }
        }
    }
}
