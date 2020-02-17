<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Assessment_model','assessment_model');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('dashboard/logout'));
            exit;
        }
    }

	public function index()
	{
        $list['output'] = $this->assessment_model->getAllData();               
        $this->load->view('reminder/index',$list);  
    }

    public function get_course_info($id) {
        $data = $this->assessment_model->getDataById($id);        
        echo json_encode($data);
    }

    public function update()
    {
        $type = $this->input->post('flag');

        if($type=='1') {
            $data = array(
                'pre_reminder' => $this->input->post('reminder'),
                'pre_reminder_day' => $this->input->post('reminder_day'),                                
            );
        } else {
            $data = array(                
                'post_reminder' => $this->input->post('reminder'),
                'post_reminder_day' => $this->input->post('reminder_day'),                
            );
        }
        $this->assessment_model->update(array('id' => $this->input->post('id')), $data);       
        echo json_encode(array("status" => TRUE));
    }

    public function get_notify() {        
        $data = $this->assessment_model->get_notify(1); 
        $data1 = $this->assessment_model->get_notify(2);        
        echo json_encode(array_merge($data,$data1));
    }
}
