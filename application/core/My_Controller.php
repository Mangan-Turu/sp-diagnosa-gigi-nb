<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
    protected $for_role = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Users_model');

        $this->check_role($this->for_role);
    }

    public function check_role($requiredRole)
    {
        $ci = &get_instance();

        $isLoggedIn = $ci->session->userdata('is_logged_in');
        $userRole   = $ci->session->userdata('role');

        if(!$isLoggedIn) {
            $ci->session->set_flashdata('alert_danger', 'Anda harus login terlebih dahulu.');
            redirect('login');
        }

        if(!$userRole) {
            $ci->session->set_flashdata('alert_danger', 'Peran pengguna tidak ditemukan.');
            redirect('login');
        }

        if($userRole === 'admin') {
            redirect('dashboard');
        }

        if($userRole === 'user') {
            redirect('konsultasi');
        }

    }

    public function check_role_any($allowedRoles = [])
    {
        $ci = &get_instance();

        $isLoggedIn = $ci->session->userdata('is_logged_in');
        $userRole   = $ci->session->userdata('role');

        if (!$isLoggedIn || !in_array($userRole, $allowedRoles)) {
            $ci->session->set_flashdata('alert_danger', 'Akses ditolak.');
            redirect('login');
        }
    }
}
