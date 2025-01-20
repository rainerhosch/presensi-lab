<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MSiswa extends CI_Model
{
    function insert($data)
    {
        $this->db->insert('siswa', $data);
        return $this->db->affected_rows();
    }
    // function getsiswa()
    // {
    //     $query = $this->db->get('siswa');
    //     return $query->result_array();
    // }

    public function getsiswa($where)
    {
        $this->db->select('siswa.nisn, siswa.nama, kelas.nama AS kelas, jurusan.nama AS jurusan');
        $this->db->from('siswa');
        $this->db->join('jurusan', 'siswa.id_jurusan = jurusan.id_jurusan');
        $this->db->join('kelas', 'siswa.id_kelas = kelas.id_kelas');
        $this->db->where($where);
        $this->db->order_by('`siswa`.`id_siswa`', 'DESC');
        return $this->db->get()->result_array();
    }

    public function edit($id, $data)
    {
        $this->db->where('id_siswa', $id);
        $this->db->update('siswa', $data);
        return $this->db->affected_rows();
    }
}
