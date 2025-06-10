<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{
    public function index()
    {
        $data['contents'] = $this->load->view('beranda_view', '', true); // return sebagai string
        $this->load->view('templates/user_templates', $data);
    }
}
