<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MLogin');
		$this->load->library('form_validation');
	}

	public function action()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|alpha_numeric');
		if ($this->form_validation->run() == TRUE) {
			$username = $this->input->post('username');
			$pass = md5($this->input->post('password'));
			$data_db = $this->MLogin->cek_login(['username' => $username, 'password' => $pass]);
			// var_dump($data_db);
			// exit;
			if (!empty($data_db)) {
				$data_sesi = [
					'username' => $username,
					'role' => $data_db['role']
				];
				$this->session->set_userdata($data_sesi);
				redirect(base_url('dashboard'));
			} else {
				$this->session->set_flashdata('notif', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data dismiss='alert' aria-hidden='true'>&times;</button> <h4><i class='icon fa fa-warning'></i> Alert!</h4> Username/Passwords Salah</div>");
				redirect(base_url('login'));
			}
		} else {
			$this->session->set_flashdata('notif', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data dismiss='alert' aria-hidden='true'>&times;</button> <h4><i class='icon fa fa-warning'></i> Alert!</h4> Salah input data</div>");
			redirect(base_url('login'));
		}
	}
}
