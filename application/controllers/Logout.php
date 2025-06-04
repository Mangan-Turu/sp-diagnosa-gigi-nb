<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
        // Hapus session
        $this->session->unset_userdata('is_logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');

        // Redirect ke halaman login
        redirect('login');
    }
}
