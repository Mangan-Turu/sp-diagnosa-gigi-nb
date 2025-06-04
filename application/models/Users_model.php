<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
    protected $table_users = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function store($data)
    {
        $this->db->insert($this->table_users, $data);
        return $this->db->affected_rows() > 0;
    }

    // Cek apakah email sudah ada di database
    public function check_email_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get($this->table_users);

        return $query->num_rows() > 0;
    }

    public function get_by_email($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row();
    }
}
