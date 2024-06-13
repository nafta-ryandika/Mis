<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
        $this->load->model("Report_M");

        date_default_timezone_set('Asia/Jakarta');
    }

    public function exitPermit()
    {
        $data['title'] = 'Report Exit Permit';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('report/exit_permit/index', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/script', $data);
    }

    public function viewData()
    {
        // check status audit
        $data_audit = $this->db->get_where('m_audit_status', ['id' => 6])->row_array();
        $status_audit = $data_audit["status"];

        if ($status_audit == 1) {
            $t_exit_permit = "t_audit_exit_permit";
            $m_employee = "m_audit_employee";
        } else {
            $t_exit_permit = "t_exit_permit";
            $m_employee = "m_employee";
        }

        $inWhere = $this->input->post('inWhere');

        $sql_exit_permit = "SELECT * , 
                            dt1.id AS transaction_id,
                            (SELECT necessity FROM m_necessity WHERE id = dt1.necessity_id) AS necessity,
                            DATE_FORMAT(dt1.date_in, '%d-%m-%Y') as date_in,
                            DATE_FORMAT(dt1.date_out, '%d-%m-%Y') as date_out,
                            IF(dt1.status = 0, 'Pending', IF(dt1.status = 1, 'Complete', IF(dt1.status = 2, 'Uncomplete','Unknown'))) AS status_name
                            FROM 
                            (
                                SELECT id, employee_id, date_in, time_in, date_out, time_out, necessity_id, remark, status,created_at, log_at 
                                FROM " . $t_exit_permit . " a 
                                WHERE 1
                            )dt1
                            LEFT JOIN
                            (
                                SELECT id, card, name, company_id, department_id, division_id, position_id 
                                FROM " . $m_employee . " b 
                                WHERE 1
                            )dt2
                            ON dt1.employee_id = dt2.id
                            LEFT JOIN 
                            (
                                SELECT id, company FROM m_company c WHERE 1 
                            )dt3
                            ON dt2.company_id = dt3.id 
                            LEFT JOIN 
                            (
                                SELECT id, department FROM  m_department d WHERE 1
                            )dt4
                            ON dt2.department_id = dt4.id 
                            LEFT JOIN 
                            (
                                SELECT id, division FROM m_division e WHERE 1 
                            )dt5
                            ON dt2.division_id = dt5.id
                            LEFT JOIN 
                            (
                                SELECT id, `position` FROM m_position f WHERE 1
                            )dt6
                            ON dt2.position_id = dt6.id 
                            WHERE 1 " . $inWhere . "
                            ORDER BY created_at DESC, log_at DESC";

        $data['exit_permit'] = $this->db->query($sql_exit_permit)->result_array();

        $this->load->view('report/exit_permit/view_data', $data);
    }

    public function get()
    {
        $report = $this->input->post('report');
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->Report_M->get($report, $param, $obj);

        echo (json_encode($data));
    }

    public function report()
    {
        // check status audit
        $data_audit = $this->db->get_where('m_audit_status', ['id' => 6])->row_array();
        $status_audit = $data_audit["status"];

        if ($status_audit == 1) {
            $t_exit_permit = "t_audit_exit_permit";
            $m_employee = "m_audit_employee";
        } else {
            $t_exit_permit = "t_exit_permit";
            $m_employee = "m_employee";
        }

        $param = $this->input->get('param');
        $obj = $this->input->get('obj');
        $where = $this->input->get('where');

        if ($param == "pdf") {
            if ($obj == "exitPermit") {
                $sql_exit_permit = "SELECT * , 
                            dt1.id AS transaction_id,
                            (SELECT necessity FROM m_necessity WHERE id = dt1.necessity_id) AS necessity,
                            DATE_FORMAT(dt1.date_in, '%d-%m-%Y') as date_in,
                            DATE_FORMAT(dt1.date_out, '%d-%m-%Y') as date_out,
                            IF(dt1.status = 0, 'Pending', IF(dt1.status = 1, 'Complete', IF(dt1.status = 2, 'Uncomplete','Unknown'))) AS status_name
                            FROM 
                            (
                                SELECT id, employee_id, date_in, time_in, date_out, time_out, necessity_id, remark, status,created_at, log_at 
                                FROM " . $t_exit_permit . " a 
                                WHERE 1
                            )dt1
                            LEFT JOIN
                            (
                                SELECT id, card, name, company_id, department_id, division_id, position_id 
                                FROM " . $m_employee . " b 
                                WHERE 1
                            )dt2
                            ON dt1.employee_id = dt2.id
                            LEFT JOIN 
                            (
                                SELECT id, company FROM m_company c WHERE 1 
                            )dt3
                            ON dt2.company_id = dt3.id 
                            LEFT JOIN 
                            (
                                SELECT id, department FROM  m_department d WHERE 1
                            )dt4
                            ON dt2.department_id = dt4.id 
                            LEFT JOIN 
                            (
                                SELECT id, division FROM m_division e WHERE 1 
                            )dt5
                            ON dt2.division_id = dt5.id
                            LEFT JOIN 
                            (
                                SELECT id, `position` FROM m_position f WHERE 1
                            )dt6
                            ON dt2.position_id = dt6.id 
                            WHERE 1 " . $where . "
                            ORDER BY created_at DESC, log_at DESC";

                $data['exit_permit'] = $this->db->query($sql_exit_permit)->result_array();

                $fileName = 'Report Data Exit Permit - ' . date("Y-m-d H:i:s");
                $data['title_pdf'] = $fileName;

                $mpdf = new \Mpdf\Mpdf([
                    'orientation' => 'L',
                    'format' => 'Legal',
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

                $html = $this->load->view('report/exit_permit/pdf', $data, true);
                $mpdf->AddPage(
                    'L', // L - landscape, P - portrait 
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
        } else if ($param == "pdf2") {
            if ($obj == "exitPermit") {
                $sql_exit_permit = "SELECT * , 
                            dt1.id AS transaction_id,
                            (SELECT necessity FROM m_necessity WHERE id = dt1.necessity_id) AS necessity,
                            DATE_FORMAT(dt1.date_in, '%d-%m-%Y') as date_in,
                            DATE_FORMAT(dt1.date_out, '%d-%m-%Y') as date_out,
                            IF(dt1.status = 0, 'Pending', IF(dt1.status = 1, 'Complete', IF(dt1.status = 2, 'Uncomplete','Unknown'))) AS status_name
                            FROM 
                            (
                                SELECT id, employee_id, date_in, time_in, date_out, time_out, necessity_id, remark, status,created_at, log_at 
                                FROM " . $t_exit_permit . " a 
                                WHERE 1
                            )dt1
                            LEFT JOIN
                            (
                                SELECT id, card, name, company_id, department_id, division_id, position_id 
                                FROM " . $m_employee . " b 
                                WHERE 1
                            )dt2
                            ON dt1.employee_id = dt2.id
                            LEFT JOIN 
                            (
                                SELECT id, company FROM m_company c WHERE 1 
                            )dt3
                            ON dt2.company_id = dt3.id 
                            LEFT JOIN 
                            (
                                SELECT id, department FROM  m_department d WHERE 1
                            )dt4
                            ON dt2.department_id = dt4.id 
                            LEFT JOIN 
                            (
                                SELECT id, division FROM m_division e WHERE 1 
                            )dt5
                            ON dt2.division_id = dt5.id
                            LEFT JOIN 
                            (
                                SELECT id, `position` FROM m_position f WHERE 1
                            )dt6
                            ON dt2.position_id = dt6.id 
                            WHERE 1 " . $where . "
                            ORDER BY created_at DESC, log_at DESC";

                $data['exit_permit'] = $this->db->query($sql_exit_permit)->result_array();

                $fileName = 'Report Data Exit Permit - ' . date("Y-m-d H:i:s");
                $data['title_pdf'] = $fileName;

                $mpdf = new \Mpdf\Mpdf([
                    'orientation' => 'L',
                    'format' => 'Legal',
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

                $html = $this->load->view('report/exit_permit/pdf', $data, true);
                $mpdf->AddPage(
                    'L', // L - landscape, P - portrait 
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
            $sql_exit_permit = "SELECT * , 
                            dt1.id AS transaction_id,
                            (SELECT necessity FROM m_necessity WHERE id = dt1.necessity_id) AS necessity,
                            DATE_FORMAT(dt1.date_in, '%d-%m-%Y') as date_in,
                            DATE_FORMAT(dt1.date_out, '%d-%m-%Y') as date_out,
                            IF(dt1.status = 0, 'Pending', IF(dt1.status = 1, 'Complete', IF(dt1.status = 2, 'Uncomplete','Unknown'))) AS status_name
                            FROM 
                            (
                                SELECT id, employee_id, date_in, time_in, date_out, time_out, necessity_id, remark, status,created_at, log_at 
                                FROM " . $t_exit_permit . " a 
                                WHERE 1
                            )dt1
                            LEFT JOIN
                            (
                                SELECT id, card, name, company_id, department_id, division_id, position_id 
                                FROM " . $m_employee . " b 
                                WHERE 1
                            )dt2
                            ON dt1.employee_id = dt2.id
                            LEFT JOIN 
                            (
                                SELECT id, company FROM m_company c WHERE 1 
                            )dt3
                            ON dt2.company_id = dt3.id 
                            LEFT JOIN 
                            (
                                SELECT id, department FROM  m_department d WHERE 1
                            )dt4
                            ON dt2.department_id = dt4.id 
                            LEFT JOIN 
                            (
                                SELECT id, division FROM m_division e WHERE 1 
                            )dt5
                            ON dt2.division_id = dt5.id
                            LEFT JOIN 
                            (
                                SELECT id, `position` FROM m_position f WHERE 1
                            )dt6
                            ON dt2.position_id = dt6.id 
                            WHERE 1 " . $where . "
                            ORDER BY created_at DESC, log_at DESC";

            $data['exit_permit'] = $this->db->query($sql_exit_permit)->result_array();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $fileName = 'Report Data Exit Permit - ' . date("Y-m-d H:i:s");

            $style_col = [
                'font' => ['bold' => true], // Set font nya jadi bold
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                ]
            ];

            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                ]
            ];

            $numrow = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath("assets/img/logo_mmp_small.png");
            $drawing->setCoordinates('A' . $numrow);
            $drawing->setWorksheet($spreadsheet->getActiveSheet());

            $sheet->setCellValue('D' . $numrow, "PT MEGA MARINE PRIDE");
            $sheet->setCellValue('D' . $numrow + 1, "Ds. WONOKOYO - Kec. Beji 67154");
            $sheet->setCellValue('D' . $numrow + 2, "Pasuruan Indonesia");
            $sheet->setCellValue('D' . $numrow + 3, "Telp. (0343) 656446 / (0343) 656513");

            $sheet->getStyle('D' . $numrow . ':D' . $numrow + 3)->getFont()->setBold(true);

            $numrow = $numrow + 5;

            $sheet->setCellValue('A' . $numrow, "Report Data Exit Permit");
            $sheet->mergeCells('A' . $numrow . ':N' . $numrow);
            $sheet->getStyle('A' . $numrow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $numrow)->getAlignment()->setHorizontal('center');

            $numrow = $numrow + 2;

            $sheet->setCellValue('A' . $numrow, "No");
            $sheet->setCellValue('B' . $numrow, "ID");
            $sheet->setCellValue('C' . $numrow, "Name");
            $sheet->setCellValue('D' . $numrow, "Company");
            $sheet->setCellValue('E' . $numrow, "Department");
            $sheet->setCellValue('F' . $numrow, "Division");
            $sheet->setCellValue('G' . $numrow, "Position");
            $sheet->setCellValue('H' . $numrow, "Date OUT");
            $sheet->setCellValue('I' . $numrow, "Time OUT");
            $sheet->setCellValue('J' . $numrow, "Date IN");
            $sheet->setCellValue('K' . $numrow, "Time IN");
            $sheet->setCellValue('L' . $numrow, "Necessity");
            $sheet->setCellValue('M' . $numrow, "Remark");
            $sheet->setCellValue('N' . $numrow, "Status");

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('L' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('M' . $numrow)->applyFromArray($style_col);
            $sheet->getStyle('N' . $numrow)->applyFromArray($style_col);


            $i = 1;
            $numrow = $numrow + 1;
            foreach ($data['exit_permit'] as $data_exit_permit) {
                $sheet->setCellValue('A' . $numrow, $i);
                $sheet->setCellValue('B' . $numrow, $data_exit_permit['employee_id']);
                $sheet->setCellValue('C' . $numrow, $data_exit_permit['name']);
                $sheet->setCellValue('D' . $numrow, $data_exit_permit['company']);
                $sheet->setCellValue('E' . $numrow, $data_exit_permit['department']);
                $sheet->setCellValue('F' . $numrow, $data_exit_permit['division']);
                $sheet->setCellValue('G' . $numrow, $data_exit_permit['position']);
                $sheet->setCellValue('H' . $numrow, $data_exit_permit['date_out']);
                $sheet->setCellValue('I' . $numrow, $data_exit_permit['time_out']);
                $sheet->setCellValue('J' . $numrow, $data_exit_permit['date_in']);
                $sheet->setCellValue('K' . $numrow, $data_exit_permit['time_in']);
                $sheet->setCellValue('L' . $numrow, $data_exit_permit['necessity']);
                $sheet->setCellValue('M' . $numrow, $data_exit_permit['remark']);
                $sheet->setCellValue('N' . $numrow, $data_exit_permit['status_name']);

                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);


                $i++;
                $numrow++;
            }

            foreach (range('A', 'N') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            $sheet->getDefaultRowDimension()->setRowHeight(-1);
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

            $sheet->setTitle("Report Data Exit Permit");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }
    }
}
