<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gejala_model extends CI_Model
{
    protected $table_users = 'm_gejala';

    public function __construct()
    {
        parent::__construct();
    }

    public function store($data)
    {
        $this->db->insert($this->table_users, $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table_users);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }
}
