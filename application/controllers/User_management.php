<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_management extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
        $this->load->model("User_management_M");
    }

    public function index()
    {
        $data['title'] = 'User';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user_management/index', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/script', $data);
    }

    public function viewData()
    {
        $inWhere = $this->input->post('inWhere');

        $sql = "SELECT 
                *, 
                dt1.id AS id,
                IF(dt1.status = 0, 'Not Active', IF(dt1.status = 1, 'Active','Unknown')) AS status_name
                FROM 
                (
                    SELECT id, user_id, name, email, image, password, company_id, department_id, division_id, role_id, `status` FROM m_user WHERE 1
                )dt1
                LEFT JOIN
                (
                    SELECT id, department FROM m_department WHERE 1
                )dt2
                ON dt1.department_id = dt2.id
                JOIN 
                (
                    SELECT id, department_id, division FROM m_division WHERE 1
                )dt3
                ON dt1.division_id = dt3.id
                LEFT JOIN 
                (
                    SELECT id, `role` FROM m_role WHERE 1
                )dt4
                ON dt1.role_id = dt4.id 
                WHERE 1 " . $inWhere;
        $data['user'] = $this->db->query($sql)->result_array();

        $this->load->view('user_management/view_data', $data);
    }

    public function check()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->User_management_M->check($param, $obj);

        echo (json_encode($data));
    }

    public function get()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->User_management_M->get($param, $obj);

        echo (json_encode($data));
    }

    public function save()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        if ($param == 'user') {
            $inMode = $this->input->post('inMode');
            $inIdx = $this->input->post('inIdx');
            $inId = $this->input->post('inId');
            $inName = $this->input->post('inName');
            $inDepartment = $this->input->post('inDepartment');
            $inDivision = $this->input->post('inDivision');
            $inRole = $this->input->post('inRole');
            $inEmail = $this->input->post('inEmail');
            $inImage = $this->input->post('inImage');
            $inPassword = password_hash($this->input->post('inPassword'), PASSWORD_DEFAULT);
            $inStatus = $this->input->post('inStatus');

            $data = $this->User_management_M->save($param, $obj, $inMode, $inIdx, $inId, $inName, $inDepartment, $inDivision, $inRole, $inEmail, $inImage, $inPassword, $inStatus);
        }

        echo (json_encode($data));
    }

    public function remove()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->User_management_M->remove($param, $obj);

        echo (json_encode($data));
    }
}
