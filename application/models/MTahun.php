<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MTahun extends CI_Model
{
    function insert($data)
    {
        $this->db->insert('tahun_ajaran', $data);
        return $this->db->affected_rows();
    }
    function getTahun()
    {
        $query = $this->db->get('tahun_ajaran');
        return $query->result_array();
    }

    public function edit($id, $data)
    {
        $this->db->where('id_tahun_ajaran', $id);
        $this->db->update('tahun_ajaran', $data);
        return $this->db->affected_rows();
    }
}
