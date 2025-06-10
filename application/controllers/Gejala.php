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
}
