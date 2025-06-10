<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi extends CI_Controller
{
    protected $for_role = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Gejala_model');
        $this->load->model('Users_model');
        $this->load->model('Konsultasi_model');
        check_role($this->for_role);
    }

    public function index()
    {
        $data['gejala'] = $this->Gejala_model->get_all();
        $data['user']   = $this->Users_model->get_by_email($this->session->userdata('email'));

        $data['contents'] = $this->load->view('konsultasi_view', $data, true);
        $this->load->view('templates/user_templates', $data);
    }

    public function hasil()
    {
        $riwayat_id = $this->input->get('id');

        $data['riwayat'] = null;

        if($riwayat_id) {
            $data['riwayat'] = $this->Konsultasi_model->get_by_id($riwayat_id);
        }

        $data['title'] = 'Hasil Konsultasi';
        $data['contents'] = $this->load->view('konsultasi_hasil_view', $data, true);
        $this->load->view('templates/user_templates', $data);
    }

    public function submit()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('umur', 'Umur', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['gejala'] = $this->Gejala_model->get_all();
            $data['user']   = (object)[
                'nama'          => set_value('nama'),
                'umur'          => set_value('umur'),
                'jenis_kelamin' => set_value('jenis_kelamin'),
                'no_hp'         => set_value('no_hp'),
                'alamat'        => set_value('alamat')
            ];
            $data['alert_danger'] = validation_errors();

            $data['contents'] = $this->load->view('konsultasi_view', $data, true);
            $this->load->view('templates/user_templates', $data);
        } else {

            $result = $this->Konsultasi_model->store([
                'user_id'       => $this->session->userdata('user_id'),
                'nama'          => $this->input->post('nama', true),
                'umur'          => $this->input->post('umur', true),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
                'no_hp'         => $this->input->post('no_hp', true),
                'alamat'        => $this->input->post('alamat', true),
                'gejala'        => $this->input->post('gejala') ?? []
            ]);

            $this->session->set_flashdata('alert_success', 'Data berhasil disimpan.');
            redirect('konsultasi/hasil?id=' . $result);
        }
    }
}
