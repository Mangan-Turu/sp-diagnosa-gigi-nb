<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gejala_model extends CI_Model
{
    protected $table_def = 'm_gejala';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->table_def, $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table_def);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table_def, $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table_def);
    }
}
