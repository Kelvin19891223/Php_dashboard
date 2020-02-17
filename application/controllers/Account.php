<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model','user_model');  
        $this->load->model('Assessment_model','assessment_model');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('dashboard/logout'));
            exit;
        }   
    }

	public function index()
	{
        
    }
    
    /**
     * Show the registration
     */
    public function regist() {
        $this->load->view('account/regist');
    }

    public function getlist()
    {
        $list = $this->user_model->getlist();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {            
            $no++;
            $row = array();
            $row[] = $person->first_name;
            $row[] = $person->last_name;
            $row[] = $person->address;
            $row[] = $person->username;
            $row[] = $person->email;
            $row[] = $person->phone;
            $row[] = $person->dob;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_item('."'".$person->users_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_item('."'".$person->users_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user_model->count_all(),
            "recordsFiltered" => $this->user_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add()
    {        
        $data = array(
            'first_name' => $this->input->post('firstName'),
            'last_name' => $this->input->post('lastName'),            
            'address' => $this->input->post('address'),
            'dob' => $this->input->post('dob'),
            'username' => $this->input->post('username'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'password' => Utils::hash('sha1', $this->input->post('password'), AUTH_SALT),
        );
        $result = $this->user_model->save($data);
        echo json_encode($result);
    }

    public function update()
    {
        $data = array(
            'first_name' => $this->input->post('firstName'),
            'last_name' => $this->input->post('lastName'),
            'address' => $this->input->post('address'),
            'dob' => $this->input->post('dob'),
            'username' => $this->input->post('username'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'password' => Utils::hash('sha1', $this->input->post('password'), AUTH_SALT),
        );        
        $result = $this->user_model->update(array('users_id' => $this->input->post('uid')), $data);
        echo json_encode($result);
    }

    public function delete($id)
    {
        $this->user_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function edit($id)
    {
        $data = $this->user_model->get_by_id($id);
        echo json_encode($data);
    }

    /**
     * display my account
     */
    public function account() {        
        $user = $this->session->userdata('logged_in');   
        $data['output'] = $this->user_model->get_by_id_view($user['users_id']);
        $data['output1'] = $this->assessment_model->getAllData();
        $this->load->view('account/account', $data);
    }
}
