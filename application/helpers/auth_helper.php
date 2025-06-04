<?php
defined('BASEPATH') or exit('No direct script access allowed');

function check_role($requiredRole)
{
    $ci = &get_instance();

    $isLoggedIn = $ci->session->userdata('is_logged_in');
    $userRole   = $ci->session->userdata('role');

    if (!$isLoggedIn || $userRole !== $requiredRole) {
        $ci->session->set_flashdata('alert_danger', 'Anda tidak memiliki akses sebagai ' . $requiredRole . '.');
        redirect('login');
    }
}

function check_role_any($allowedRoles = [])
{
    $ci = &get_instance();

    $isLoggedIn = $ci->session->userdata('is_logged_in');
    $userRole   = $ci->session->userdata('role');

    if (!$isLoggedIn || !in_array($userRole, $allowedRoles)) {
        $ci->session->set_flashdata('alert_danger', 'Akses ditolak.');
        redirect('login');
    }
}
