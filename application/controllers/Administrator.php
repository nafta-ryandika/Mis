<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
    }

    public function index()
    {
        $data['title'] = 'Administrator';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('administrator/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $data['role'] = $this->db->get('m_role')->result_array();

        $this->form_validation->set_rules('inRole', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('administrator/role', $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/script', $data);
        } else {
            $this->db->insert('m_role', ['role' => $this->input->post('inRole'), 'created_by' => $this->session->userdata('user_id')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Saved !</div>');
            redirect('administrator/role');
        }
    }

    public function update()
    {
        $update = $this->input->get('update');
        $id = $this->input->get('id');
        $redirect = '';

        if ($update == 'role') {
            $inRole = $this->input->post('inRole');

            $this->db->set('role', $inRole);
            $this->db->where('id', $id);
            $this->db->update('m_role');
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Updated !</div>');
        redirect('administrator/role' . $redirect);
    }

    public function delete()
    {
        $delete = $this->input->get('delete');
        $id = $this->input->get('id');
        $redirect = '';

        if ($delete == 'role') {
            $this->db->delete('m_role', ['id' => $id]);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Deleted !</div>');
        redirect('administrator/role' . $redirect);
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $data['role'] = $this->db->get_where('m_role', ['id' => $role_id])->row_array();

        $this->db->where('id != ', 1);
        $data['menu'] = $this->db->get('m_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('administrator/role_access', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/script', $data);
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menu_id');
        $role_id = $this->input->post('role_id');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('m_access', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('m_access', $data);
        } else {
            $this->db->delete('m_access', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed !</div>');
    }
}
