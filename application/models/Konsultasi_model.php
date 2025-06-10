<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi_model extends CI_Model
{
    protected $table_riwayat        = 't_riwayat';
    protected $table_riwayat_detail = 't_riwayat_detail';
    protected $table_gejala         = 'm_gejala';
    protected $table_penyakit       = 'm_penyakit';

    public function __construct()
    {
        parent::__construct();
    }

    public function store($data)
    {
        $this->db->trans_start();

        $data_chunk = [
            'user_id'       => $data['user_id'] ?? null,
            'nama'          => $data['nama'],
            'alamat'        => $data['alamat'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'umur'          => $data['umur'],
            'no_hp'         => $data['no_hp'],
            'penyakit_id'   => null,
            'created_at'    => date('Y-m-d H:i:s'),
            'created_by'    => $data['user_id'] ?? null,
            'update_at'     => date('Y-m-d H:i:s'),
            'update_by'     => $data['user_id'] ?? null,
            'deleted'       => 0
        ];

        $this->db->insert($this->table_riwayat, $data_chunk);
        $riwayat_id = $this->db->insert_id();

        $data_detail = [];
        foreach ($data['gejala'] as $value) {
            $data_detail[] = [
                'riwayat_id' => $riwayat_id,
                'gejala_id'  => $value,
            ];
        }

        $this->db->insert_batch($this->table_riwayat_detail, $data_detail);
        $this->db->trans_complete();

        // return $this->db->trans_status();
        return $riwayat_id;
    }

    public function get_by_id($riwayat_id)
    {
        $this->db->select('t_riwayat.*, m_penyakit.nama as nama_penyakit, GROUP_CONCAT(m_gejala.kode) as gejala_kode, GROUP_CONCAT(m_gejala.nama) as gejala_nama');
        $this->db->from($this->table_riwayat);
        $this->db->join($this->table_riwayat_detail, 't_riwayat.id = t_riwayat_detail.riwayat_id', 'left');
        $this->db->join($this->table_gejala, 't_riwayat_detail.gejala_id = m_gejala.id', 'left');
        $this->db->join($this->table_penyakit, 't_riwayat.penyakit_id = m_penyakit.id', 'left');
        $this->db->where('t_riwayat.id', $riwayat_id);
        $this->db->group_by('t_riwayat.id');

        return $this->db->get()->row();
    }
}
