<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends My_Controller
{
    protected $for_role = 'admin';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Riwayat_model');
        $this->load->model('Gejala_model');
        $this->load->model('Users_model');
        $this->load->model('Konsultasi_model');
        $this->load->model('Penyakit_model');
    }

    public function index()
    {
        $data['title'] = 'Data Riwayat';
        $data['riwayat'] = $this->Riwayat_model->get_all();
        $data['contents'] = $this->load->view('riwayat_view', $data, true);
        $this->load->view('templates/admin_templates', $data);
    }

    public function perhitungan()
    {
        $data['title'] = 'Perhitungan Riwayat';

        $get_riwayat_all = $this->Riwayat_model->get_all();

        $data['hasils'] = [];
        foreach ($get_riwayat_all as $riwayat) {
            $hasil = $this->hitung($riwayat['id']);
            $data['hasils'][] = [
                'riwayat_id' => $riwayat['id'],
                'user_id' => $hasil['user_id'],
                'user_nama' => $hasil['user_nama'],
                'penyakit_id' => $hasil['hasil']['penyakit_id'],
                'penyakit_kode' => $hasil['hasil']['penyakit_kode'],
                'penyakit_nama' => $hasil['hasil']['penyakit_nama'],
                'probabilitas' => $hasil['hasil']['probabilitas'],
                'perhitungan' => $hasil['perhitungan']
            ];
        }

        $data['contents'] = $this->load->view('riwayat_perhitungan_view', $data, true);
        $this->load->view('templates/admin_templates', $data);
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
                'pasien_id'         => $get_riwayat['id'],
                'pasien_nama'       => $get_riwayat['nama_user'],
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

        foreach ($nilai_nc as $item) {
            $tmp = [
                'penyakit_id'     => $item['penyakit_id'],
                'penyakit_kode'   => $item['penyakit_kode'],
                'penyakit_nama'   => $item['nama'],
                'penyakit_total'  => $item['total_penyakit'],
                'penyakit_n'      => $item['n'],
                'penyakit_m'      => $item['m'],
                'nilai_nc'        => $item['nilai_nc'],
            ];

            $rules = [];
            foreach ($item['rules'] as $rule) {
                $pembilang  = $rule['gejala_selected'] + ($item['m'] * $item['nilai_nc']);
                $pembagi    = $item['n'] + $item['m'];
                $result     = $pembilang / $pembagi;

                $rules[] = [
                    'rule_id'         => $rule['rule_id'],
                    'gejala_id'       => $rule['gejala_id'],
                    'gejala_kode'     => $rule['gejala_kode'],
                    'gejala_selected' => $rule['gejala_selected'],
                    'nilai_p'         => floor($result * 1000) / 1000,
                ];
            }

            $tmp['rules'] = $rules;
            $nilai_p[] = $tmp;
        }

        // 3. Menghitung P(ai|vj) x P(vj) untuk tiap v dan menambahkannya ke $nilai_p
        $probabilitas = [];

        foreach ($nilai_p as $index => $item) {
            $hasil_perkalian = 1;
            foreach ($item['rules'] as $r) {
                $nilai = $r['nilai_p'];
                $nilai_terpotong = floor($nilai * 1000) / 1000;
                $hasil_perkalian *= number_format($r['nilai_p'], 3, '.', '');
            }

            $result = $item['nilai_nc'] * $hasil_perkalian;
            $nilai_p[$index]['probabilitas'] = round($result, 8); // dimasukkan ke dalam nilai_p

            $probabilitas[] = [
                'penyakit_id'    => $item['penyakit_id'],
                'penyakit_kode'  => $item['penyakit_kode'],
                'penyakit_nama'  => $item['penyakit_nama'],
                'probabilitas'   => round($result, 8),
            ];
        }

        // Jika mau tampilkan untuk debug
        // echo "<pre>"; print_r($nilai_p); echo "</pre>";


        // echo "<pre>";
        // print_r($probabilitas);
        // echo "</pre>";


        // 4. Hasil
        // ambil hasil terbesar
        // $hasil = [];
        // $max = 0;
        // foreach ($probabilitas as $item) {
        //     if ($item['probabilitas'] > $max) {
        //         $max = $item['probabilitas'];
        //         $hasil = [
        //             'penyakit_id'    => $item['penyakit_id'],
        //             'penyakit_kode'  => $item['penyakit_kode'],
        //             'penyakit_nama'  => $item['penyakit_nama'],
        //             'probabilitas'   => $item['probabilitas'],
        //         ];
        //     }
        // }
        // echo "<pre>";
        // print_r($hasil);
        // echo "</pre>";

        // $output = [
        //     'user_id'     => $get_riwayat['user_id'],
        //     'user_nama'   => $get_riwayat['nama_user'],
        //     'hasil'       => $hasil, // bisa juga ambil dari probabilitas tertinggi
        //     'perhitungan' => $nilai_p
        // ];

        // echo "<pre>";
        // print_r($output);
        // echo "</pre>";

        // Menentukan penyakit dengan probabilitas tertinggi
        $hasil = null;
        $max = 0;

        foreach ($nilai_p as $item) {
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

        // Jika tidak ada hasil, pastikan tetap ada struktur kosong (opsional tapi aman)
        if ($hasil === null) {
            $hasil = [
                'penyakit_id'    => null,
                'penyakit_kode'  => null,
                'penyakit_nama'  => null,
                'probabilitas'   => 0,
            ];
        }

        // Output akhir
        $output = [
            'user_id'     => $get_riwayat['user_id'],
            'user_nama'   => $get_riwayat['nama_user'],
            'hasil'       => $hasil,
            'perhitungan' => $nilai_p
        ];

        // echo '<pre>';
        // print_r($output);
        // echo '</pre>';

        return $output;
    }
}
