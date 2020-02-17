<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('dashboard/logout'));
            exit;
        }
    }

	public function index()
	{
        $data = $this->session->userdata('logged_in');
		$this->load->view('welcome/index',$data);
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url().'auth/login');
    }

    
}
