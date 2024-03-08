<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
                                FROM t_exit_permit a 
                                WHERE 1
                            )dt1
                            LEFT JOIN
                            (
                                SELECT id, card, name, company_id, department_id, division_id, position_id 
                                FROM m_employee b 
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
                                FROM t_exit_permit a 
                                WHERE 1
                            )dt1
                            LEFT JOIN
                            (
                                SELECT id, card, name, company_id, department_id, division_id, position_id 
                                FROM m_employee b 
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

                // $pdf = $this->load->library('pdfgenerator');
                // $file_pdf = '';
                // $paper = '';
                // $orientation = "landscape";
                // $html = $this->load->view('report/exit_permit/pdf', $data, TRUE);
                // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, TRUE);

                $mpdf = new \Mpdf\Mpdf([
                    'orientation' => 'L',
                    'format' => 'Legal',
                    'margin_left' => '5',
                    'margin_right' => '5',
                    'margin_top' => '30'
                ]);

                $mpdf->SetTitle($fileName);

                $header = "<img src='" . base_url() . "assets/img/header_mmp.png'>
                            <br/>
                            <div style='text-align:center'>
                                <h3>Report Data Exit Permit</h3>
                            </div>";

                $header =   "<table>
                                <tr>
                                    <td>
                                        <img src='" . base_url() . "assets/img/logo_mmp_small.png'>
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

                $mpdf->WriteHTML($html);
                $mpdf->Output($fileName, 'I');
            }
        } else if ($param == "excel") {
            include APPPATH . "../assets/vendor/PHPExcel-1.8/Classes/PHPExcel.php";

            $excel = new PHPExcel();
        }
    }
}
