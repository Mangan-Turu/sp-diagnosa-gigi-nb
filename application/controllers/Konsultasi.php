<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi extends CI_Controller
{
    protected $for_role = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Gejala_model');
        $this->load->model('Users_model');
        $this->load->model('Konsultasi_model');
        $this->load->model('Riwayat_model');
        $this->load->model('Penyakit_model');
        check_role($this->for_role);
    }

    public function index()
    {
        $data['gejala'] = $this->Gejala_model->get_all();
        $data['user']   = $this->Users_model->get_by_email($this->session->userdata('email'));

        $data['contents'] = $this->load->view('konsultasi_view', $data, true);
        $this->load->view('templates/user_templates', $data);
    }

    public function hasil()
    {
        // for ($i = 1; $i <= 50; $i++) {
        //     $riwayat_id = $i;
        //     $get_hasil = $this->hitung($riwayat_id);

        //     $this->Riwayat_model->update_penyakit_id($riwayat_id, $get_hasil['penyakit_id'], $get_hasil['probabilitas']);
        // }

        $riwayat_id = $this->input->get('id');
        $get_hasil = $this->hitung($riwayat_id);

        $this->Riwayat_model->update_penyakit_id($riwayat_id, $get_hasil['penyakit_id'], $get_hasil['probabilitas']);

        $data['riwayat'] = null;

        if ($riwayat_id) {
            $data['riwayat'] = $this->Konsultasi_model->get_by_id($riwayat_id);
        }

        $data['title'] = 'Hasil Konsultasi';
        $data['contents'] = $this->load->view('konsultasi_hasil_view', $data, true);
        $this->load->view('templates/user_templates', $data);
    }

    public function submit()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('umur', 'Umur', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['gejala'] = $this->Gejala_model->get_all();
            $data['user']   = (object)[
                'nama'          => set_value('nama'),
                'umur'          => set_value('umur'),
                'jenis_kelamin' => set_value('jenis_kelamin'),
                'no_hp'         => set_value('no_hp'),
                'alamat'        => set_value('alamat')
            ];
            $data['alert_danger'] = validation_errors();

            $data['contents'] = $this->load->view('konsultasi_view', $data, true);
            $this->load->view('templates/user_templates', $data);
        } else {

            $result = $this->Konsultasi_model->store([
                'user_id'       => $this->session->userdata('user_id'),
                'nama'          => $this->input->post('nama', true),
                'umur'          => $this->input->post('umur', true),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
                'no_hp'         => $this->input->post('no_hp', true),
                'alamat'        => $this->input->post('alamat', true),
                'gejala'        => $this->input->post('gejala') ?? []
            ]);

            $this->session->set_flashdata('alert_success', 'Data berhasil disimpan.');
            redirect('konsultasi/hasil?id=' . $result);
        }
    }


    public function hitung($id)
    {
        // ambil data pasien 1
        $get_riwayat = $this->Riwayat_model->get_by_id($id);
        $get_gejalas = $get_riwayat['gejala'];
        $get_master_gejala = $this->Gejala_model->get_all();
        $get_master_penyakit = $this->Penyakit_model->get_all();
        // $get_rules = $this->Penyakit_model->get_rules_by_id();
        // echo json_encode($get_gejalas); die;

        // echo "<pre>";
        // print_r($get_gejalas);
        // echo "</pre>";
        // die;

        // 1. menentukan nilai nc pasa masing" penyakit
        $penyakit = $this->Penyakit_model->get_all();

        $nilai_nc = [];
        foreach ($penyakit as $key => $item) {

            $rule = [];
            foreach ($get_gejalas as $gejala) {
                $rule[] = [
                    'rule_id' => null,
                    'gejala_id' => $gejala['id'],
                    'gejala_kode' => $gejala['kode'],
                    'gejala_selected' => $this->Penyakit_model->check_exist($item['id'], $gejala['id']),
                ];
            }

            // echo "<pre>";
            // print_r($rule);
            // echo "</pre>";

            $tmp = [
                'penyakit_id'       => $item['id'],
                'penyakit_kode'     => $item['kode'],
                'nama'              => $item['nama'],
                'total_penyakit'    => count($get_master_penyakit),
                'n'                 => 1,
                'm'                 => count($get_master_gejala),
                'rules'             => $rule,
            ];

            $nilai_nc_f = $tmp['n'] / $tmp['total_penyakit'];
            $nilai_nc_f = floor($nilai_nc_f * 1000) / 1000;
            $tmp['nilai_nc'] = $nilai_nc_f;

            $nilai_nc[] = $tmp;
        }

        // echo "<pre>";
        // print_r($nilai_nc);
        // echo "</pre>";

        // 2. Menghitung nilai P(ai|vj) dan menghitung nilai P(vj)
        $nilai_p = [];
        foreach ($nilai_nc as $key => $item) {

            $tmp = [
                'penyakit_id'           => $item['penyakit_id'],
                'penyakit_kode'        => $item['penyakit_kode'],
                'penyakit_nama'        => $item['nama'],
                'penyakit_total'       => $item['total_penyakit'],
                'penyakit_n'           => $item['n'],
                'penyakit_m'           => $item['m'],
                'nilai_nc'             => $item['nilai_nc'],
            ];

            $rules = [];
            foreach ($item['rules'] as $rule) {
                $pembilang  = $rule['gejala_selected'] + $item['m'] * $item['nilai_nc'];
                $pembagi    = $item['n'] + $item['m'];
                $result     = $pembilang / $pembagi;

                $rules[] = [
                    'rule_id'              => $rule['rule_id'],
                    'gejala_id'            => $rule['gejala_id'],
                    'gejala_kode'          => $rule['gejala_kode'],
                    'gejala_selected'      => $rule['gejala_selected'],
                    'nilai_p'              => number_format($result, 4, '.', '')
                ];
            }

            $tmp['rules'] = $rules;
            $nilai_p[] = $tmp;
        }

        // echo "<pre>";
        // print_r($nilai_p);
        // echo "</pre>";

        // 3. Menghitung P(ai|vj) x P(vj) untuk tiap v
        $probabilitas = [];
        foreach ($nilai_p as $item) {
            $hasil_perkalian = 1;
            foreach ($item['rules'] as $r) {
                $hasil_perkalian *= $r['nilai_p'];
            }

            $result = $item['nilai_nc'] * $hasil_perkalian;
            $probabilitas[] = [
                'penyakit_id'    => $item['penyakit_id'],
                'penyakit_kode'  => $item['penyakit_kode'],
                'penyakit_nama'  => $item['penyakit_nama'],
                'probabilitas'   => number_format($result, 8, '.', ''),
            ];
        }

        // echo "<pre>";
        // print_r($probabilitas);
        // echo "</pre>";

        // 4. Hasil
        // ambil hasil terbesar
        $hasil = [];
        $max = 0;
        foreach ($probabilitas as $item) {
            if ($item['probabilitas'] > $max) {
                $max = $item['probabilitas'];
                $hasil = [
                    'penyakit_id'    => $item['penyakit_id'],
                    'penyakit_kode'  => $item['penyakit_kode'],
                    'penyakit_nama'  => $item['penyakit_nama'],
                    'probabilitas'   => $item['probabilitas'],
                ];
            }
        }
        // echo "<pre>";
        // print_r($hasil);
        // echo "</pre>";

        return $hasil;
    }

    public function perhitungan()
    {
        $get_riwayat_all = $this->Riwayat_model->get_all();

        $data = [];
        foreach ($get_riwayat_all as $riwayat) {
            $result = $this->hitung($riwayat['id']);
            echo $result['probabilitas'] . '<br>';
        }
    }
}
