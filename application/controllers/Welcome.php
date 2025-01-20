<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MScan', 'Scan');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function logout()
	{
		$this->session->unset_userdata(['username', 'role']);
        $this->session->sess_destroy();
        redirect(base_url());
	}

	public function scan()
	{
		// 'tgl_check_in' => date('Y')
		$data['presensi'] = $this->Scan->data_presensi([]);
		// echo '<pre>';
		// echo print_r($data);
		// echo '</pre>';
		// exit();
		$this->load->view('scan', $data);
	}
}
