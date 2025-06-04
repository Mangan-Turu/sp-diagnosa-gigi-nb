<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$data['contents'] = $this->load->view('login_view', '', true); // return sebagai string
		$this->load->view('templates/auth_templates', $data);
	}

	public function submit()
	{
		$this->load->library('form_validation');
		$this->load->model('Users_model');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$data['contents'] = $this->load->view('login_view', '', true);
			$this->load->view('templates/auth_templates', $data);
		} else {
			$email = $this->input->post('email', true);
			$password = $this->input->post('password');

			$user = $this->Users_model->get_by_email($email);

			if ($user && password_verify($password, $user->password)) {
				// Set session login
				$this->session->set_userdata([
					'is_logged_in' 	=> true,
					'user_id' 		=> $user->id,
					'role' 			=> $user->role,
					'name' 			=> $user->name,
					'email' 		=> $user->email,
				]);

				redirect('dashboard');
			} else {
				// Email atau password salah
				$this->session->set_flashdata('alert_danger', 'Email atau password salah.');
				redirect('login');
			}
		}
	}
}
