<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_model extends CI_Model
{
    protected $table_def = 't_riwayat';
    protected $table_def_detail = 't_riwayat_detail';
    protected $table_gejala = 'm_gejala';
    protected $table_penyakit = 'm_penyakit';

    public function __construct()
    {
        parent::__construct();
    }

    public function store($data)
    {
        $this->db->insert($this->table_def, $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_all()
    {
        $this->db->select('
            t_riwayat.*, 
            m_penyakit.nama AS nama_penyakit, 
            GROUP_CONCAT(m_gejala.kode ORDER BY m_gejala.kode) AS gejala_kode, 
            GROUP_CONCAT(m_gejala.nama ORDER BY m_gejala.kode) AS gejala_nama
        ');
        $this->db->from($this->table_def);
        $this->db->join($this->table_def_detail, 't_riwayat.id = t_riwayat_detail.riwayat_id', 'left');
        $this->db->join($this->table_gejala, 't_riwayat_detail.gejala_id = m_gejala.id', 'left');
        $this->db->join($this->table_penyakit, 't_riwayat.penyakit_id = m_penyakit.id', 'left');
        $this->db->group_by('t_riwayat.id');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }
}
