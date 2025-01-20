<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MJurusan extends CI_Model
{
    function insert($data)
    {
        $this->db->insert('jurusan', $data);
        return $this->db->affected_rows();
    }
    function getJurusan()
    {
        $query = $this->db->get('jurusan');
        return $query->result_array();
    }

    public function edit($id, $data)
    {
        $this->db->where('id_jurusan', $id);
        $this->db->update('jurusan', $data);
        return $this->db->affected_rows();
    }
}
