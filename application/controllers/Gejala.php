<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gejala extends My_Controller
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
        $data['title'] = 'Data Gejala';
        $data['contents'] = $this->load->view('gejala_view', '', true);
        $this->load->view('templates/admin_templates', $data);
    }
}
