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

    public function get_by_id($riwayat_id)
    {
        $this->db->select('
            t_riwayat.id as riwayat_id, t_riwayat.user_id, t_riwayat.nama as user_nama, t_riwayat.alamat, t_riwayat.jenis_kelamin, t_riwayat.umur, t_riwayat.no_hp,
            m_gejala.id as gejala_id,m_gejala.kode as gejala_kode, m_gejala.nama as gejala_nama');
        $this->db->from('t_riwayat');
        $this->db->join('t_riwayat_detail', 't_riwayat.id = t_riwayat_detail.riwayat_id');
        $this->db->join('m_gejala', 'm_gejala.id = t_riwayat_detail.gejala_id');
        $this->db->where('t_riwayat.id', $riwayat_id);

        $query = $this->db->get();
        $result = $query->result();

        if (empty($result)) return null;

        $data = [
            'id' => $result[0]->riwayat_id,
            'user_id' => $result[0]->user_id,
            'nama_user' => $result[0]->user_nama,
            'alamat' => $result[0]->alamat,
            'jenis_kelamin' => $result[0]->jenis_kelamin,
            'umur' => $result[0]->umur,
            'no_hp' => $result[0]->no_hp,
            'gejala' => []
        ];

        foreach ($result as $row) {
            $data['gejala'][] = [
                'id' => $row->gejala_id,
                'kode' => $row->gejala_kode,
                'nama' => $row->gejala_nama,
                'nilai' => 1
            ];
        }

        return $data;
    }
}
