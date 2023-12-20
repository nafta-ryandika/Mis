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
        } else {
            $this->db->insert('m_menu', ['menu' => $this->input->post('inMenu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Saved !</div>');
            redirect('menu');
        }
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
