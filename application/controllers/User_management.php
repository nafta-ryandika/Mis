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
        $sql = "SELECT 
                *, 
                IF(dt1.status = 0, 'Deactivate', IF(dt1.status = 1, 'Active','Unknown')) AS status_name
                FROM 
                (
                    SELECT id, user_id, name, email, image, password, company_id, department_id, division_id, role_id, `status` FROM m_user WHERE 1
                )dt1
                LEFT JOIN
                (
                    SELECT id, department FROM m_department WHERE 1
                )dt2
                ON dt1.department_id = dt2.id
                LEFT JOIN 
                (
                    SELECT id, department_id, division FROM m_division WHERE 1
                )dt3
                ON dt1.division_id = dt3.id
                LEFT JOIN 
                (
                    SELECT id, `role` FROM m_role WHERE 1
                )dt4
                ON dt1.role_id = dt4.id";
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
            $inId = $this->input->post('inId');
            $inName = $this->input->post('inName');
            $inDepartment = $this->input->post('inDepartment');
            $inDivision = $this->input->post('inDivision');
            $inRole = $this->input->post('inRole');
            $inEmail = $this->input->post('inEmail');
            $inImage = $this->input->post('inImage');
            $inPassword = password_hash($this->input->post('inPassword'), PASSWORD_DEFAULT);
            $inStatus = $this->input->post('inStatus');

            $data = $this->User_management_M->save($param, $obj, $inMode, $inId, $inName, $inDepartment, $inDivision, $inRole, $inEmail, $inImage, $inPassword, $inStatus);
        } else if ($param == 'update') {
            if ($obj == 'exitPermit') {
                $inId = $this->input->post('inId');

                $data = $this->Hrd_M->save($param, $obj, $inId, "", "", "");
            }
        } else if ($param == 'new') {
            $inId = $this->input->post('inId');

            $data = $this->Hrd_M->save($param, $obj, $inId, "", "", "");
        }

        echo (json_encode($data));
    }

    public function remove()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->Hrd_M->remove($param, $obj);

        echo (json_encode($data));
    }

    public function viewInput()
    {
        $this->load->view('exit_permit/view_input');
    }

    public function getData()
    {
        $id = $this->input->post('id');
        $data['submenu'] = $this->db->get_where('m_submenu', ['id' => $id])->result_array();
        echo json_encode($data);
    }

    public function update()
    {
        $update = $this->input->get('update');
        $id = $this->input->get('id');
        $redirect = '';

        if ($update == 'menu') {
            $inMenu = $this->input->post('inMenu');

            $this->db->set('menu', $inMenu);
            $this->db->where('id', $id);
            $this->db->update('m_menu');
        } else if ($update == 'submenu') {
            $this->form_validation->set_rules('inTitle', 'Title', 'required');
            $this->form_validation->set_rules('inMenu_id', 'Menu', 'required');
            $this->form_validation->set_rules('inUrl', 'Url', 'required');
            $this->form_validation->set_rules('inIcon', 'Icon', 'required');
            $this->form_validation->set_rules('inStatus', 'Status', 'required');

            $inTitle =  $this->input->post('inTitle');
            $inMenu_id = $this->input->post('inMenu_id');
            $inUrl =  $this->input->post('inUrl');
            $inIcon =  $this->input->post('inIcon');
            $inStatus =  $this->input->post('inStatus');

            $this->db->set('title', $inTitle);
            $this->db->set('menu_id', $inMenu_id);
            $this->db->set('url', $inUrl);
            $this->db->set('icon', $inIcon);
            $this->db->set('status', $inStatus);
            $this->db->where('id', $id);
            $this->db->update('m_submenu');

            $redirect = '/submenu';
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Updated !</div>');
        redirect('menu' . $redirect);
    }

    public function delete()
    {
        $delete = $this->input->get('delete');
        $id = $this->input->get('id');
        $redirect = '';

        if ($delete == 'menu') {
            $this->db->delete('m_menu', ['id' => $id]);
        } else if ($delete == 'submenu') {
            $this->db->delete('m_submenu', ['id' => $id]);
            $redirect = '/submenu';
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Deleted !</div>');
        redirect('menu' . $redirect);
    }
}
