<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
}
