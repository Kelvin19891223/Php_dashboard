<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

    var $table = 'users';	
    
    function __construct() {
        parent::__construct();
        parent::__construct();
		$this->load->database();
    }

    public function Authentification() {
        $notif = array();
        $email = $this->input->post('email');
        $password = Utils::hash('sha1', $this->input->post('password'), AUTH_SALT);

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $row = $query->row();
            
            $sess_data = array(
                'users_id' => $row->users_id,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'email' => $row->email,
                'username' => $row->username,
                'phone' => $row->phone,
                'level' => $row->level,
            );                
            $this->session->set_userdata('logged_in', $sess_data);                
            $this->update_last_login($row->users_id);             
            
        } else {
            $notif['message'] = 'Username or password incorrect !';
            $notif['type'] = 'danger';
        }

        return $notif;
    }

    /**
     * Update Last Login Info
     */
    private function update_last_login($users_id) {
        $sql = "UPDATE users SET last_login = NOW() WHERE users_id=" . $this->db->escape($users_id);
        $this->db->query($sql);
    }

    public function register() {
        $notif = array();
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'phone' => $this->input->post('phone'),
            'level' => $this->input->post('level'),
            'password' => Utils::hash('sha1', $this->input->post('password'), AUTH_SALT),
            'is_active' => $this->input->post('is_active') ? : 0
        );        

        $this->db->insert('users', $data);
        $users_id = $this->db->insert_id();
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'phone' => $this->input->post('phone'),
            'password' => Utils::hash('sha1', $this->input->post('password'), AUTH_SALT),
            'is_active' => $this->input->post('is_active') ? : 0,
            'users_id' => $users_id
        );  

        if ($this->db->affected_rows() > 0) {
            $notif['message'] = 'Saved successfully';
            $notif['type'] = 'success';
            unset($_POST);
            $this->session->set_userdata('logged_in', $data);                
            $this->update_last_login($users_id);  
        } else {
            $notif['message'] = 'Something wrong !';
            $notif['type'] = 'danger';
        }
        return $notif;
    }

    public function check_email($email) {
        $sql = "SELECT * FROM users WHERE email = " . $this->db->escape($email);
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            $row = $res->row();
            return $row;
        }
        return null;
    }

    public function check_user($user) {
        $sql = "SELECT * FROM users WHERE username = '" . $user . "'";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            $row = $res->row();
            return $row;
        }
        return null;
    }
}
