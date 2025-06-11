<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit_model extends CI_Model
{
    protected $table_def    = 'm_penyakit';
    protected $table_rules  = 't_rules';

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

    public function get_rules_by_id($penyakit_id)
    {
        $this->db->select('t_rules.id, m_gejala.id as gejala_id, m_gejala.kode as gejala_kode, m_gejala.nama as gejala_nama');
        $this->db->from($this->table_rules);
        $this->db->join('m_gejala', 't_rules.gejala_id = m_gejala.id', 'left');
        $this->db->where('t_rules.penyakit_id', $penyakit_id);
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

    public function check_exist($penyakit_id, $gejala_id)
    {
        $this->db->from('t_rules');
        $this->db->where('penyakit_id', $penyakit_id);
        $this->db->where('gejala_id', $gejala_id);

        $query = $this->db->get();
        return $query->num_rows() > 0 ? 1 : 0;
    }
}
