<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	public function index()
	{
		if ($this->session->userdata('user_id')) {
			redirect('user');
		}

		$this->form_validation->set_rules('inUser', 'User', 'trim|required');
		$this->form_validation->set_rules('inPassword', 'Password', 'trim|required');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Mis | Login';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$user = $this->input->post('inUser');
		$password = $this->input->post('inPassword');

		$user = $this->db->get_where('m_user', ['user_id' => $user])->row_array();

		if ($user) {
			if ($user['status'] == 1) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'user_id' => $user['user_id'],
						'role_id' => $user['role_id']
					];

					$this->session->set_userdata($data);

					if ($user['role_id'] == 1) {
						redirect('administrator');
					} else {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password !</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This User has not been activated !</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User is not registered !</div>');
			redirect('auth');
		}
	}

	public function registration()
	{
		if ($this->session->userdata('user_id')) {
			redirect('user');
		}

		$this->form_validation->set_rules('inUserid', 'User Id', 'required|trim|is_unique[m_user.user_id]', ['is_unique' => 'This User Id already registered !']);
		$this->form_validation->set_rules('inUser', 'User Name', 'required|trim');
		$this->form_validation->set_rules('inEmail', 'Email Address', 'required|trim|valid_email');
		$this->form_validation->set_rules('inPassword1', 'Password', 'required|trim|min_length[4]|matches[inPassword2]', ['matches' => 'Password dont match !', 'min_length' => 'Password too short']);
		$this->form_validation->set_rules('inPassword2', 'Password', 'required|trim|matches[inPassword1]');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Mis | User Registration';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration');
			$this->load->view('templates/auth_footer');
		} else {
			$data = [
				'user_id' => htmlspecialchars($this->input->post('inUserid', true)),
				'name' => htmlspecialchars($this->input->post('inUser', true)),
				'email' => htmlspecialchars($this->input->post('inEmail', true)),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('inPassword1'), PASSWORD_DEFAULT),
				'department' => '',
				'division' => '',
				'role_id' => 2,
				'status' => 1,
				'created_by' => 'administrator',
				'created_at' => date('Y-m-d h:i:s')
			];

			$this->db->insert('m_user', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success ! Your account has been created.</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out !</div>');
		redirect('auth');
	}

	public function blocked()
	{
		$this->load->view('auth/blocked');
	}
}
