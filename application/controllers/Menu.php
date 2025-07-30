<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $data['menu'] = $this->db->get('m_menu')->result_array();

        $this->form_validation->set_rules('inMenu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/script', $data);
        } else {
            $this->db->insert('m_menu', ['menu' => $this->input->post('inMenu'), 'created_by' => $this->session->userdata('user_id')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Saved !</div>');
            redirect('menu');
        }
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

    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $this->load->model('Menu_M', 'menu');
        $data['submenu'] = $this->menu->getSubmenu();
        $data['menu'] = $this->db->get('m_menu')->result_array();

        $this->form_validation->set_rules('inTitle', 'Title', 'required');
        $this->form_validation->set_rules('inMenu_id', 'Menu', 'required');
        $this->form_validation->set_rules('inUrl', 'Url', 'required');
        $this->form_validation->set_rules('inIcon', 'Icon', 'required');
        $this->form_validation->set_rules('inStatus', 'Status', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/script', $data);
        } else {
            $data = [
                'title' => $this->input->post('inTitle'),
                'menu_id' => $this->input->post('inMenu_id'),
                'url' => $this->input->post('inUrl'),
                'icon' => $this->input->post('inIcon'),
                'status' => $this->input->post('inStatus')
            ];

            $this->db->insert('m_submenu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Saved !</div>');
            redirect('menu/submenu');
        }
    }
}
