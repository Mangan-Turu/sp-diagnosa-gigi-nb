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
        check_role($this->for_role);
    }

    public function index()
    {
        $data['gejala'] = $this->Gejala_model->get_all();

        $data['contents'] = $this->load->view('konsultasi_view', $data, true);
        $this->load->view('templates/user_templates', $data);
    }
}
