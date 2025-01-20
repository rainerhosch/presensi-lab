<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MKelas extends CI_Model
{
    function insert($data)
    {
        $this->db->insert('kelas', $data);
        return $this->db->affected_rows();
    }
    function getKelas()
    {
        $query = $this->db->get('kelas');
        return $query->result_array();
    }

    public function edit($id, $data)
    {
        $this->db->where('id_kelas', $id);
        $this->db->update('kelas', $data);
        return $this->db->affected_rows();
    }
}
