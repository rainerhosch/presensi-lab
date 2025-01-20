<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class MScan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function cek($where)
    {
        $this->db->select('*');
        $this->db->from('siswa');
        // $this->db->join('siswa', 'siswa.id_siswa = presensi.id_siswa');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function cek_last_absen($where)
    {
        $this->db->select('*');
        $this->db->from('presensi');
        $this->db->where($where);
        $this->db->order_by('id_presensi', 'DESC');
        $this->db->limit(1);
        // ORDER BY id DESC LIMIT 0, 1
        return $this->db->get()->row_array();
    }

    public function update_absen($where, $data)
    {
        $this->db->update('presensi', $data, $where);
        return $this->db->affected_rows();
    }
    public function insert_absen($data)
    {
        $this->db->insert('presensi', $data);
        return $this->db->affected_rows();
    }

    public function data_presensi($where)
    {
        $this->db->select('siswa.*, kelas.nama AS kelas, jurusan.nama AS jurusan, presensi.tgl_check_in, presensi.jam_check_in, presensi.tgl_check_out, presensi.jam_check_out');
        $this->db->from('presensi');
        $this->db->join('siswa', 'siswa.id_siswa = presensi.id_siswa');
        $this->db->join('jurusan', 'siswa.id_jurusan = jurusan.id_jurusan');
        $this->db->join('kelas', 'siswa.id_kelas = kelas.id_kelas');
        $this->db->where($where);
        $this->db->order_by('`presensi`.`id_presensi`', 'DESC');
        return $this->db->get()->result_array();
    }
}
