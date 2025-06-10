<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends My_Controller
{
    protected $for_role = 'admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Data Riwayat';
        $data['contents'] = $this->load->view('riwayat_view', '', true);
        $this->load->view('templates/admin_templates', $data);
    }
}
