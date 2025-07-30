<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
    }

    public function index()
    {
        $data['title'] = 'Profile';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $this->form_validation->set_rules('inName', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('inName');
            $user_id = $this->session->userdata('user_id');

            $upload_image = $_FILES['inImage']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '2048';
                $config['upload_path']   = './assets/img/profile/';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('inImage')) {
                    $old_image = $data['user']['image'];

                    if ($old_image != 'default.png') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('user_id', $user_id);
            $this->db->update('m_user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Updated !</div>');
            redirect('user');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();

        $this->form_validation->set_rules('inCurrentpassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('inNewpassword1', 'New Password', 'required|trim|min_length[3]|matches[inNewpassword2]');
        $this->form_validation->set_rules('inNewpassword2', 'Confirm New Password', 'required|trim|min_length[3]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/change_password', $data);
            $this->load->view('templates/footer');   # code...
        } else {
            $user_id = $this->session->userdata('user_id');
            $current_password = $this->input->post('inCurrentpassword');
            $new_password = $this->input->post('inNewpassword1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong Current Password !</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as the current password !</div>');
                    redirect('user/changepassword');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('user_id', $user_id);
                    $this->db->update('m_user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Updated !</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
}
