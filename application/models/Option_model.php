<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option_model extends CI_Model
{
    public function get_all($table_name, $select = ['id', 'nama'])
    {
        $this->db->select(implode(',', $select));
        $query = $this->db->get($table_name);
        return $query->result_array();
    }
}
