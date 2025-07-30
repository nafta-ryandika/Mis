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

		$this->form_validation->set_rules('inUserid', 'User', 'trim|required');
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
		$inUserid = $this->input->post('inUserid');
		$password = $this->input->post('inPassword');

		$user = $this->db->get_where('m_user', ['user_id' => $inUserid])->row_array();

		if ($user) {
			if ($user['status'] == 1) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'user_id' => $user['user_id'],
						'role_id' => $user['role_id'],
						'name' => $user['name']
					];

					$this->session->set_userdata($data);
					$role_id = $user['role_id'];

					if ($role_id == 1) {
						redirect('administrator');
					} else if ($role_id == 6) {
						redirect('vote');
					} else if ($role_id == 4) {
						redirect('hrd');
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
				'status' => 0,
				'created_by' => 'administrator',
				'created_at' => date('Y-m-d h:i:s')
			];

			$token = base64_encode(random_bytes(32));
			$user_token = [
				'user_id' => $this->input->post('inUserid', true),
				'token' => $token
			];

			$this->db->insert('m_user', $data);
			$this->db->insert('m_token', $user_token);

			$this->_sendEmail($token, 'verify');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success ! Your account has been created. Please activate</div>');
			redirect('auth');
		}
	}

	private function _sendEmail($token, $type)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'mail.megamarinepride.com',
			'smtp_user' => 'hello@megamarinepride.com',
			'smtp_pass' => 'cNaG(Wt&4nKy+&&*',
			'smtp_port' => '465',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		];

		$this->load->library('email', $config);
		$this->email->set_mailtype("html");

		$this->email->from('hello@megamarinepride.com', 'Mis Administrator');
		$this->email->to('sysdev@megamarinepride.com');

		if ($type == 'verify') {
			$this->email->subject('Account Verification');
			$this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?user_id=' . $this->input->post('inUserid') . '&token=' . urlencode($token) . '">Activate</a>');
		} else if ($type == 'forgot') {
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetPassword?user_id=' . $this->input->post('inUserid') . '&token=' . urlencode($token) . '">Reset Password</a>');
		}

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	public function verify()
	{
		$user_id = $this->input->get('user_id');
		$token = $this->input->get('token');

		$user = $this->db->get_where('m_user', ['user_id' => $user_id])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('m_token', ['token' => $token])->row_array();

			if ($user_token) {
				$this->db->set('status', 1);
				$this->db->where('user_id', $user_id);
				$this->db->update('m_user');

				$this->db->delete('m_token', ['user_id' => $user_id]);

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Account activation success</div>');
				redirect('auth');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed ! Token invalid</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed ! Wrong user</div>');
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

	public function forgotPassword()
	{
		$this->form_validation->set_rules('inUserid', 'User Id', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Mis | Forgot Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgot-password');
			$this->load->view('templates/auth_footer');
		} else {
			$user_id = $this->input->post('inUserid');

			$user = $this->db->get_where('m_user', ['user_id' => $user_id, 'status' => 1])->row_array();

			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'user_id' => $this->input->post('inUserid', true),
					'token' => $token
				];

				$this->db->insert('m_token', $user_token);
				$this->_sendEmail($token, 'forgot');

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Reset ! Please contact Administrator</div>');
				redirect('auth/forgotPassword');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User Id is not registered or activated !</div>');
				redirect('auth/forgotPassword');
			}
		}
	}

	public function resetPassword()
	{
		$user_id = $this->input->get('user_id');
		$token = $this->input->get('token');

		$user = $this->db->get_where('m_user', ['user_id' => $user_id])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('m_token', ['token' => $token])->row_array();

			if ($user_token) {
				$this->session->set_userdata('reset_user_id', $user_id);
				$this->changePassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed ! Token invalid</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password failed ! Wrong user</div>');
			redirect('auth');
		}
	}

	public function changePassword()
	{
		if (!$this->session->userdata('reset_user_id')) {
			redirect('auth');
		}

		$this->form_validation->set_rules('inPassword1', 'Password', 'required|trim|min_length[4]|matches[inPassword2]', ['matches' => 'Password dont match !', 'min_length' => 'Password too short']);
		$this->form_validation->set_rules('inPassword2', 'Password', 'required|trim|matches[inPassword1]');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Mis | Change Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/change-password');
			$this->load->view('templates/auth_footer');
		} else {
			$password = password_hash($this->input->post('inPassword1'), PASSWORD_DEFAULT);
			$user_id = $this->session->userdata('reset_user_id');

			$this->db->set('password', $password);
			$this->db->where('user_id', $user_id);
			$this->db->update('m_user');

			$this->session->unset_userdata('reset_user_id');
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed !</div>');
			redirect('auth');
		}
	}
}
