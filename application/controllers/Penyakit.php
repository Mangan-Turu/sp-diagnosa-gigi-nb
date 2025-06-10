<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends My_Controller
{
    protected $for_role = 'admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Users_model');
    }

    public function index()
    {
        $data['title'] = 'Data Penyakit';
        $data['contents'] = $this->load->view('penyakit_view', '', true);
        $this->load->view('templates/admin_templates', $data);
    }
}
