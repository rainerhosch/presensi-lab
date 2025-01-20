<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurusan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MJurusan');
		$this->load->library('form_validation');
		if ($this->session->userdata('role') == 'admin') {
		} else {
			$this->session->set_flashdata('notif', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <h4><i class='icon fa fa-warning'></i> Alert!</h4> Harus Login Terlebih Dahulu</div>");
			redirect(base_url('login'));
		}
	}

	public function index()
	{
		$data['title']   = 'Jurusan';
		$data['content'] = 'jurusan';
		$data['jurusan']   = $this->MJurusan->getJurusan();
		// echo '<pre>';
		// print_r($data['jurusan']);
		// echo '</pre>';
		// exit;
		$this->load->view('template', $data);
	}


	public function action_simpan()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if ($this->form_validation->run() == TRUE) {

			$data['post']['nama']   = $this->input->post('nama');
			$data['post']['status'] = $this->input->post('status');
			$hasil = $this->MJurusan->insert(['nama' => $data['post']['nama'], 'status' => $data['post']['status']]);
			if ($hasil == true) {
				$this->session->set_flashdata('notif', 'Data Berhasil disimpan');
			} else {
				$this->session->set_flashdata('notif', 'Data Gagal disimpan');
			}
		} else {
			$notif = validation_errors();
			$this->session->set_flashdata('notif', $notif);
		}
		redirect('jurusan');
		// echo '<pre>';
		// echo print_r($notif);
		// echo '</pre>';
	}

	public function action_edit()
	{
		$this->form_validation->set_rules('id_edit', 'Id', 'required');
		$this->form_validation->set_rules('nama_edit', 'Nama', 'required');
		$this->form_validation->set_rules('status_edit', 'Status', 'required');
		if ($this->form_validation->run() == TRUE) {
			$data['post']['id']   = $this->input->post('id_edit');
			$data['post']['nama']   = $this->input->post('nama_edit');
			$data['post']['status'] = $this->input->post('status_edit');
			$hasil = $this->MJurusan->edit($data['post']['id'], ['nama' => $data['post']['nama'], 'status' => $data['post']['status']]);
			if ($hasil == true) {
				$this->session->set_flashdata('notif', 'Data Berhasil di edit');
			} else {
				$this->session->set_flashdata('notif', 'Data Gagal di edit');
			}
		} else {
			$notif = validation_errors();
			$this->session->set_flashdata('notif', $notif);
		}
		redirect('jurusan');
		// echo '<pre>';
		// echo print_r($notif);
		// echo '</pre>';
	}
}
