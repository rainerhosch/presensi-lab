<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MScan', 'Scan');
		$this->load->library('form_validation');
	}

	public function action_simpan()
	{
		// MHS
		$manif = 0;
		$insertV = 0;
		$manif_out = 0;
		$jam_now = date("H:i:s");
		$format  = date("Y-m-d");
		$create_at  = date("Y-m-d H:i:s");
		$nisn = $this->input->post('nisn');
		// $nisn = 12345;

		$where_ = [
			'siswa.nisn' => $nisn
		];

		$cek  = $this->Scan->cek($where_);
		// echo '<pre>';
		// echo print_r($this->db->last_query());
		// echo '</pre>';
		// exit();
		if ($cek > 0) {


			$where_presensi = [
				'id_siswa' => $cek['id_siswa'],
				'tgl_check_out' => '0000-00-00'
			];

			$where_max = [
				'id_siswa' => $cek['id_siswa']
			];

			$cek_max_id = $this->Scan->cek_last_absen($where_presensi);

			if (empty($cek_max_id)) {
				$cek_max_id['id_presensi'] = null;
				$cek_max_id['tgl_check_in'] = null;
				$cek_max_id['jam_check_in'] = null;
				$cek_max_id['tgl_check_out'] = null;
				$cek_max_id['jam_check_out'] = null;
			}
			$cek_last_absen = $this->Scan->cek_last_absen($where_max);
			if (empty($cek_last_absen)) {

				$cek_max_id['id_presensi'] = null;
				$cek_last_absen['tgl_check_in'] = null;
				$cek_last_absen['jam_check_in'] = null;
				$cek_last_absen['tgl_check_out'] = null;
				$cek_last_absen['jam_check_out'] = null;
			}

			$create_at_last = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];

			$checkout_last = $cek_last_absen['tgl_check_out'] . ' ' . $cek_last_absen['jam_check_out'];
			$diff  = date_diff(date_create($create_at_last), date_create());
			// echo '<pre>';
			// echo print_r($diff);
			// echo '</pre>';
			// exit();
			$dataJam =  $diff->d . ' hari, ' . $diff->h . ' jam, ' . $diff->i . ' menit, ' . $diff->s . ' detik, ';
			$diff_mulai  = date_diff(date_create($checkout_last), date_create());
			$dataJam_mulai =  $diff_mulai->d . ' hari, ' . $diff_mulai->h . ' jam, ' . $diff_mulai->i . ' menit, ' . $diff_mulai->s . ' detik, ';
			$checkout_last2 = $cek_max_id['tgl_check_out'] . ' ' . $cek_max_id['jam_check_out'];
			$diff_mulai2  = date_diff(date_create($checkout_last2), date_create());

			// ABSEN TERAKHIR
			if ($cek_last_absen !== null && $cek_last_absen['tgl_check_out'] == '0000-00-00') {

				//UPDATE CHECKOUT

				if ($diff->d < 1 && ($diff->i >= 1 && $diff->h >= 0 && $diff->h <= 16)) {
					$data_jam = [
						'tgl_check_out' => $format,
						'jam_check_out' => $jam_now
					];
					$prosesUpdate = $this->Scan->update_absen(['id_presensi' => $cek_last_absen['id_presensi']], $data_jam);
					// JIKA BERHASIL
					if ($prosesUpdate > 0) {
						$data = 'Terima kasih';
						$status = 2;
						$manif_out = 1;
					} else {
						$data = 'Tidak Tersimpan';
						$status = 0;
					}
					// JIKA 24 JAM BELUM CHECKOUT
				} else if ($diff->d > 0) {
					$times = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];
					$dt = new DateTime($times);
					$dt->modify('+ 1 hour');
					$tglk = date_format($dt, "Y-m-d");
					$jamk = date_format($dt, "H:i:s");
					$data_jam = [
						'tgl_check_out' => $tglk,
						'jam_check_out' => $jamk
					];
					$prosesUpdate = $this->Scan->update_absen(['id_presensi' => $cek_last_absen['id_presensi']], $data_jam);
					if ($prosesUpdate > 0) {
						$data = 'Checkout kemarin, Silahkan Scan lagi...';
						$status = 6;
						$manif_out = 1;
					} else {
						$data = 'Tidak Tersimpan';
						$status = 0;
					}
					//JIKA BELUM CHECK OUT
				} else if ($diff->d > 0 && $diff->h > 15) {
					$times = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];
					$dt = new DateTime($times);
					$dt->modify('+ 1 hour');
					$tglk = date_format($dt, "Y-m-d");
					$jamk = date_format($dt, "H:i:s");
					$data_jam = [
						'tgl_check_out' => $tglk,
						'jam_check_out' => $jamk
					];
					$prosesUpdate = $this->Scan->update_absen(['id_presensi' => $cek_last_absen['id_presensi']], $data_jam);
					if ($prosesUpdate > 0) {
						$data = 'Checkout kemarin, Silahkan Scan lagi...';
						$status = 6;
						$manif_out = 1;
					} else {
						$data = 'Tidak Tersimpan';
						$status = 0;
					}
					//JIKA BELUM CHECK OUT
				} else if ($diff->d < 1 && $diff->h > 15) {
					$times = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];
					$dt = new DateTime($times);
					$dt->modify('+ 1 hour');
					$tglk = date_format($dt, "Y-m-d");
					$jamk = date_format($dt, "H:i:s");
					$data_jam = [
						'tgl_check_out' => $tglk,
						'jam_check_out' => $jamk
					];
					$prosesUpdate = $this->Scan->update_absen(['id_absensi' => $cek_last_absen['id_presensi']], $data_jam);
					if ($prosesUpdate > 0) {
						$data = 'Checkout kemarin, Silahkan Scan lagi...';
						$status = 6;
						$manif_out = 1;
					} else {
						$data = 'Tidak Tersimpan';
						$status = 0;
					}
					//JIKA BELUM PULANG
				} else {
					$data = 'Tunggu satu menit...';
					$status = 3;
				}
				//JIKA ABSEN BELUM PERNAH DIBUAT 
			} else {
				//JIKA SUDAH ABSEN HARI INI 1 MENIT
				if ($cek_max_id['id_presensi'] !== null && $diff_mulai2->d < 1 && $diff_mulai2->h < 1 && $diff_mulai2->i < 1) {
					$create_last_w = $cek_max_id['tgl_check_in'] . ' ' . $cek_max_id['jam_check_in'];
					$checkout_last_w  = $cek_max_id['tgl_check_out'] . ' ' . $cek_max_id['jam_check_out'];
					$diff  = date_diff(date_create($checkout_last_w), date_create($create_last_w));
					$dataJam =  $diff->d . ' hari, ' . $diff->h . ' jam, ' . $diff->i . ' menit, ' . $diff->s . ' detik, ';
					$data = 'Sudah mengisi list...';
					$status = 4;
					// BATAS CEK IN
				} else {
					$where_data = [
						'id_siswa'  => $cek['id_siswa'],
						'id_tahun_ajaran'  => 2025,
						'tgl_check_in'  => $format,
						'jam_check_in'  => $jam_now,
						'tgl_check_out' => '',
						'jam_check_out' => ''
					];
					$prosesInsert = $this->Scan->insert_absen($where_data);
					$dataJam = '-';
					$data    = 'Scan Tersimpan.';
					$status  = 1;
					$manif   = 1;
					$insertV = 1;
				}
			}

			//MANIPULASI WAKTU
			if ($manif == 1) {
				$awalW = $create_at;
			} else {
				$awalW = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];
			}

			if ($insertV == 1) {
				$akhirW = '-';
			} else {
				if ($cek_last_absen['tgl_check_out'] != '0000-00-00') {
					$akhirW = $cek_last_absen['tgl_check_out'] . ' ' . $cek_last_absen['jam_check_out'];
				} else {
					$akhirW = $manif_out == 1 ? $create_at : '-';
				}
			}
			//END MANIPULASI WAKTU

			// ENCODE JSON
			$Edata = [
				'notif' => $data,
				'nisn' => $cek['nisn'],
				'nama' => $cek['nama'],
				'status' => $status,
				'dataJam_mulai' => $dataJam_mulai,
				'dataJam' => $dataJam,
				'sql' => $cek_last_absen,
				'awal' => $awalW,
				'akhir' => $akhirW,
				'max' => $cek_max_id
			];
		} else {
			$Edata = [
				'error' => 1
			];
		}
		echo json_encode($Edata);
		// redirect('siswa');
		// echo '<pre>';
		// echo print_r($notif);
		// echo '</pre>';
	}
}
