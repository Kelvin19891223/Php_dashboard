<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assign extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model','user_model');
        $this->load->model('Assign_model','assign_model');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('dashboard/logout'));
            exit;
        }
    }

	public function index()
	{
        $users['output'] = $this->user_model->getAllUsers();
        $this->load->view('assign/index',$users);
	}

    /**
     * Get the assign list
     */
    public function getlist()
    {
        $list = $this->assign_model->getList();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->course_kind;
            $row[] = $item->course_name;
            $row[] = $item->teacher_name;
            $row[] = $item->moderator_name;            
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_item('."'".$item->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_item('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->assign_model->count_all(),
            "recordsFiltered" => $this->assign_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    /**
     * Get the assign role data by id
     */
    public function getInfo($id)
    {
        $data = $this->assign_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add()
    {
        $data = array(
            'course_name' => $this->input->post('course_name'),
            'teacher_name' => $this->input->post('teacher_name'),
            'moderator_name' => $this->input->post('moderator_name'),
            'course_kind' => $this->input->post('course_kind'),
            'course_year' => $this->input->post('course_year'),
            'course_semester' => $this->input->post('course_semester'),
        );
        $insert = $this->assign_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $data = array(
                'course_name' => $this->input->post('course_name'),
                'teacher_name' => $this->input->post('teacher_name'),
                'moderator_name' => $this->input->post('moderator_name'),
                'course_kind' => $this->input->post('course_kind'),         
                'course_year' => $this->input->post('course_year'),
                'course_semester' => $this->input->post('course_semester'),
            );
        $this->assign_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete($id)
    {
        $this->assign_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
