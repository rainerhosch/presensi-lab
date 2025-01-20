<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MSiswa');
		$this->load->model('MJurusan');
		$this->load->model('MAngkatan');
		$this->load->model('MKelas');
		$this->load->library('form_validation');
		if ($this->session->userdata('role') == 'admin') {
		} else {
			$this->session->set_flashdata('notif', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <h4><i class='icon fa fa-warning'></i> Alert!</h4> Harus Login Terlebih Dahulu</div>");
			redirect(base_url('login'));
		}
	}

	public function index()
	{
		$data['title']   = 'Data Siswa';
		$data['content'] = 'siswa';
		$data['kelas']   = $this->MKelas->getKelas();
		$data['jurusan']   = $this->MJurusan->getJurusan();
		$data['angkatan']   = $this->MAngkatan->getangkatan();
		$data['siswa']   = $this->MSiswa->getSiswa([]);
		// echo '<pre>';
		// print_r($data['siswa']);
		// echo '</pre>';
		// exit;
		$this->load->view('template', $data);
	}


	public function action_simpan()
	{
		$this->form_validation->set_rules('nisn', 'Nisn', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('angkatan', 'Angkatan', 'required');
		$this->form_validation->set_rules('kelas', 'Kelas', 'required');
		$this->form_validation->set_rules('jurusan', 'Jurusan', 'required');
		if ($this->form_validation->run() == TRUE) {
			$data['post']	= $this->input->post();

			$data_insert	= [
				'nisn'			=> $data['post']['nisn'],	
				'nama'			=> $data['post']['nama'],
				'id_angkatan'	=> $data['post']['angkatan'],
				'id_kelas'		=> $data['post']['kelas'],
				'id_jurusan'	=> $data['post']['jurusan'],
				'alamat'		=> $data['post']['alamat'],
				'status'		=> 1,
			];
			
			$hasil = $this->MSiswa->insert($data_insert);
			if ($hasil == true) {
				$this->session->set_flashdata('notif', 'Data Berhasil disimpan');
			} else {
				$this->session->set_flashdata('notif', 'Data Gagal disimpan');
			}
		} else {
			$notif = validation_errors();
			$this->session->set_flashdata('notif', $notif);
		}
		redirect('siswa');
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
			$hasil = $this->MSiswa->edit($data['post']['id'], ['nama' => $data['post']['nama'], 'status' => $data['post']['status']]);
			if ($hasil == true) {
				$this->session->set_flashdata('notif', 'Data Berhasil di edit');
			} else {
				$this->session->set_flashdata('notif', 'Data Gagal di edit');
			}
		} else {
			$notif = validation_errors();
			$this->session->set_flashdata('notif', $notif);
		}
		redirect('siswa');
		// echo '<pre>';
		// echo print_r($notif);
		// echo '</pre>';
	}
}
