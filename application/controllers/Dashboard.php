<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Assessment_model','assessment_model');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('dashboard/logout'));
            exit;
        }
    }

    /**
     * 1 : taught
     * 2 : moderate
     */
	public function form($flag)
	{
        $list['output'] = $this->assessment_model->get_taught_course($flag);
        $list['flag'] = $flag;
        $this->load->view('dashboard/index',$list);
    }   

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url().'auth/login');
    }
}
