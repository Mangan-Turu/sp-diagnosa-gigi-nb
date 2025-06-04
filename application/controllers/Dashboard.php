<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    protected $for_role = 'admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Users_model');

        check_role($this->for_role);
    }

    public function index()
    {
        $data['contents'] = $this->load->view('dashboard_view', '', true);
        $this->load->view('templates/admin_templates', $data);
    }
}
