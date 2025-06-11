<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gejala extends My_Controller
{
    protected $for_role = 'admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Gejala_model');
    }

    public function index()
    {
        $data['title'] = 'Data Gejala';
        $data['gejala'] = $this->Gejala_model->get_all();

        $data['contents'] = $this->load->view('gejala_view', $data, true);
        $this->load->view('templates/admin_templates', $data);
    }

    public function store()
    {
        $mode = $this->input->post('mode', TRUE);
        $id = $this->input->post('id', TRUE);

        if ($mode === 'tambah') {
            $this->db->select('kode');
            $this->db->like('kode', 'G');
            $this->db->order_by('kode', 'DESC');
            $this->db->limit(1);
            $last = $this->db->get('m_gejala')->row();

            if ($last) {
                $num = (int) substr($last->kode, 1);
                $kode = 'G' . str_pad($num + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $kode = 'G01';
            }

            $_POST['kode'] = $kode;
        }

        $this->form_validation->set_rules('nama', 'Nama Gejala', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('gejala');
        }

        $data = [
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama'),
            'deskripsi' => $this->input->post('deskripsi')
        ];

        if ($mode === 'tambah') {
            $this->Gejala_model->insert($data);
            $this->session->set_flashdata('success', 'Gejala berhasil ditambahkan.');
        } else {
            if (!$id) {
                $this->session->set_flashdata('error', 'ID gejala tidak ditemukan.');
                redirect('gejala');
            }
            $this->Gejala_model->update($id, $data);
            $this->session->set_flashdata('success', 'Gejala berhasil diperbarui.');
        }

        redirect('gejala');
    }

    public function delete($id)
    {
        $this->Gejala_model->delete($id);
        $this->session->set_flashdata('success', 'Gejala berhasil dihapus.');
        redirect('gejala');
    }
    
}
