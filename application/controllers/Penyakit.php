<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends My_Controller
{
    protected $for_role = 'admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Penyakit_model');
    }

    public function index()
    {
        $data['title'] = 'Data Penyakit';
        $data['penyakit'] = $this->Penyakit_model->get_all();
        $data['contents'] = $this->load->view('penyakit_view', $data, true);
        $this->load->view('templates/admin_templates', $data);
    }
}
