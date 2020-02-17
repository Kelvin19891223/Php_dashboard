<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->session->userdata('logged_in')) {
            redirect(base_url('welcome'));
            exit;
        }
    }

    /**
     *    Login Page 
     */
    public function index() {
        redirect(base_url('auth/login'));
    }

    /**
     *   Login
     */
    public function login() {
        $data['title'] = 'Login';
        $this->load->model('auth_model');

        if (count($_POST)) {
            $this->load->helper('security');
            $this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $data['notif']['message'] = validation_errors();
                $data['notif']['type'] = 'danger';
            } 
            else {
                $data['notif'] = $this->auth_model->Authentification();
            }
        }
        if ($this->session->userdata('logged_in')) {            
            redirect(base_url('welcome'));
            exit;
        }
        
        $this->load->view('auth/login',$data);
    }

    /**
     *   User Regist
     */
    public function register() {
        $data['title'] = 'Register';
        $this->load->model('auth_model');

        if (count($_POST)) {
            $this->load->helper('security');

            $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Password');
            
            if ($this->form_validation->run() == false) {
                $data['notif']['message'] = validation_errors();
                $data['notif']['type'] = 'danger';
            } 
            else {
                $username = $form_id = $this->input->post('username');
                $row = $this->auth_model->check_user($username);
                if($row) {
                    $data['notif']['message'] = "Username must be unique.";
                    $data['notif']['type'] = 'danger';
                } else {
                    $data['notif'] = $this->auth_model->register();
                }
            }
        }
        
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('welcome'));
            exit;
        }
        //die;
        $this->load->view('auth/register', $data);        
    }

    /*
     * Custom callback function
     */

    public function password_check($str) {
        if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
            return true;
        }
        return false;
    }
}
