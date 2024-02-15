<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hrd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
        $this->load->model("Hrd_M");
    }

    public function index()
    {
        $data['title'] = 'Exit Permit';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $this->form_validation->set_rules('inMenu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('exit_permit/index', $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/script', $data);
        } else {
            $this->db->insert('m_menu', ['menu' => $this->input->post('inMenu'), 'created_by' => $this->session->userdata('user_id')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Saved !</div>');
            redirect('menu');
        }
    }

    public function viewData()
    {
        $sql_exit_permit = "SELECT * ,
                            (SELECT necessity FROM m_necessity WHERE id = dt1.necessity_id) AS necessity
                            FROM 
                            (
                                SELECT id, employee_id, date_in, time_in, date_out, time_out, necessity_id, remark FROM t_exit_permit a WHERE 1
                            )dt1
                            LEFT JOIN
                            (
                                SELECT id, card, name, company_id, department_id, division_id, position_id FROM m_employee b WHERE 1
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
                            ON dt2.position_id = dt6.id";
        $data['exit_permit'] = $this->db->query($sql_exit_permit)->result_array();

        $this->load->view('exit_permit/view_data', $data);
    }

    public function check()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->Hrd_M->check($param, $obj);

        echo (json_encode($data));
    }

    public function get()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->Hrd_M->get($param, $obj);

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
