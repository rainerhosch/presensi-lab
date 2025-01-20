<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MLogin');
		$this->load->library('form_validation');
		if ($this->session->userdata('role') == 'admin') {
		} else {
			$this->session->set_flashdata('notif', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <h4><i class='icon fa fa-warning'></i> Alert!</h4> Harus Login Terlebih Dahulu</div>");
			redirect(base_url('login'));
		}
	}

	public function index()
	{
		// echo print_r($this->session->userdata());
		// exit();
		$data['title']   = 'Dashboard';
		$data['content'] = 'dashboard';
		$this->load->view('template', $data);
	}
}
