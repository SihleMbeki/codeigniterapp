<?php
class Account_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_user($username, $password, $token) {
        $data = [
            'Username' => $username,
            'Password' => password_hash($password, PASSWORD_DEFAULT),
            'Token' => $token
        ];
        return $this->db->insert('accounts', $data);
    }

    public function username_exists($username) {
        return $this->db->get_where('accounts', ['Username' => $username])->num_rows() > 0;
    }
}