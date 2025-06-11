<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option extends CI_Controller
{
    protected $table_def_gejala = 'm_gejala';
    protected $table_def_penyakit = 'm_penyakit';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Option_model');
    }

    public function get_gejala()
    {
        $data = $this->Option_model->get_all($this->table_def_gejala, ['id', 'nama']);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function get_penyakit()
    {
        $data = $this->Option_model->get_all($this->table_def_penyakit, ['id', 'nama']);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
