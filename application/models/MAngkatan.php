<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MAngkatan extends CI_Model
{
    function insert($data)
    {
        $this->db->insert('angkatan', $data);
        return $this->db->affected_rows();
    }
    function getangkatan()
    {
        $query = $this->db->get('angkatan');
        return $query->result_array();
    }

    public function edit($id, $data)
    {
        $this->db->where('id_angkatan', $id);
        $this->db->update('angkatan', $data);
        return $this->db->affected_rows();
    }
}
