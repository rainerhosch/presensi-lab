<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MLogin extends CI_Model
{
    public function cek_login($where)
    {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }
}
