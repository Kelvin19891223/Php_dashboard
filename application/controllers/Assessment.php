<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Assessment_model','assessment_model');
        $this->load->model('Assign_model','assign_model');
        $this->load->model('File_model','file');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('dashboard/logout'));
            exit;
        }
    }

	public function index()
	{
        
    }
    
    /**
     * show the assessment form
     * 1 ; Taught Form
     * 2 ; Moderate Form
     */
    public function form($id) 
    {
        $data['output'] = $this->assign_model->getDataByKind($id);
        $data['flag'] = $id;
        $this->load->view('assessment/index',$data);
    }

    /**
     * Show the Form list
     * id : course id
     * One course can have multiple assessment form
     */
    public function assessment_form($id) {
        $result = $this->assign_model->get_by_id($id);
        $data['course_id'] = $id;
        $data['course_name'] = $result->course_name;
        if($result->course_kind == "Taught")
            $data['flag'] = 1;
        else
            $data['flag'] = 2;
        $this->load->view('assessment/list',$data);
    }

    public function getlist($id)
    {
        $list = $this->assessment_model->getlist($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {            
            $no++;
            $row = array();
            $row[] = $item->course_description;
            $row[] = '<a class="" href="javascript:void(0)" title="Edit" onclick="upload_schedule('."'".$item->id."'".')"><i class="glyphicon glyphicon-pencil"></i>replace</a>
            &nbsp;&nbsp;<a class="" href="javascript:void(0)" title="Edit" onclick="download_schedule('."'".$item->id."'".')">'.$item->course_schedule_origin.'</a>';
            $row[] = '<a class="" href="javascript:void(0)" title="Edit" onclick="upload_prescription('."'".$item->id."'".')"><i class="glyphicon glyphicon-pencil"></i>replace</a>
            &nbsp;&nbsp;<a class="" href="javascript:void(0)" title="Edit" onclick="download_prescription('."'".$item->id."'".')">'.$item->course_prescription_origin.'</a>';
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_item('."'".$item->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Called Form</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_item('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->assessment_model->count_all($id),
            "recordsFiltered" => $this->assessment_model->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->assessment_model->getDataById($id);        
        if($data) {            
            $data->post_event_status = explode("_",$data->post_event_status);
            $data->pre_event_status = explode("_",$data->pre_event_status);      
            $data->assessment_description = $this->file->getDataByFormid('assessment_description',$id);
            $data->marking_criteria = $this->file->getDataByFormid('marking_criteria',$id);
            $data->exam_solution = $this->file->getDataByFormid('exam_solution',$id);
            $data->pre_event_file = $this->file->getDataByFormid('pre_event_file',$id);
            $data->post_event_file = $this->file->getDataByFormid('post_event_file',$id);
            $data->student_sample_low = $this->file->getDataByFormid('student_sample_low',$id);
            $data->student_sample_medium = $this->file->getDataByFormid('student_sample_medium',$id);
            $data->student_sample_high = $this->file->getDataByFormid('student_sample_high',$id);
        }
        echo json_encode($data);
    }

    public function add() {    
        $pre_status = $this->input->post('pre_event_status');
        $pre_event_status = "";
        /*foreach ($pre_status as $color){ 
            $pre_event_status = $pre_event_status . $color . "_";
        }*/
	$pre_event_status = $pre_status . "_";

        $post_event_status1 = $this->input->post('post_event_status');
        $post_event_status = "";
        /*foreach ($post_event_status1 as $color){ 
            $post_event_status = $post_event_status . $color . "_";
        }*/
	$post_event_status = $post_event_status1 . "_";

        //save assessment form
        $data = array(
            'pre_event_status' => $pre_event_status,
            'course_name' => $this->input->post('course_name'),
            'post_event_status' => $post_event_status,

            'year' => $this->input->post('year'),
            'semester' => $this->input->post('semester'),            
            'assessment_release_date' => $this->input->post('assessment_release_date'),   
            'submission_due_date' => $this->input->post('submission_due_date'),
            'course_id' => $this->input->post('course_id'),
            'pre_reminder' => $this->input->post('pre_reminder'),
            'pre_reminder_day' => $this->input->post('pre_reminder_day'),
            'post_reminder' => $this->input->post('post_reminder'),
            'post_reminder_day' => $this->input->post('post_reminder_day'),
            'course_description' => $this->input->post('course_description'),
        );
                
        $form_id = $this->assessment_model->save($data);

        
        $target_dir = "uploads/" . $form_id . "_" . $this->input->post('course_name') ."/";
        if(!is_dir($target_dir))
            mkdir($target_dir,0755,true);
        $status = 0;
        
        $user = $this->session->userdata('logged_in');  
         
        if($user)
            $user = $user['username'];

        $target_file = $target_dir  . uniqid() . basename($_FILES["assessment_description"]["name"]);   
        
        if (move_uploaded_file($_FILES["assessment_description"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'assessment_description',
                'origin_name' => basename($_FILES["assessment_description"]["name"]),
                'description' => $this->input->post('assessment_description_version_history'),
                'username' => $user,
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["marking_criteria"]["name"]);            
        if (move_uploaded_file($_FILES["marking_criteria"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'marking_criteria',
                'origin_name' => basename($_FILES["marking_criteria"]["name"]),
                'description' => $this->input->post('marking_criteria_version_history'),
                'username' => $user,
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["exam_solution"]["name"]);            
        if (move_uploaded_file($_FILES["exam_solution"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'exam_solution',
                'origin_name' => basename($_FILES["exam_solution"]["name"]),
                'description' => $this->input->post('exam_solution_version_history'),
                'username' => $user,
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["pre_event_file"]["name"]);            
        if (move_uploaded_file($_FILES["pre_event_file"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'pre_event_file',
                'origin_name' => basename($_FILES["pre_event_file"]["name"]),
                'description' => $this->input->post('pre_event_version_history'),
                'username' => $user,
                'comment' => $this->input->post('pre_event_comment'),
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["post_event_file"]["name"]);            
        if (move_uploaded_file($_FILES["post_event_file"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'post_event_file',
                'origin_name' => basename($_FILES["post_event_file"]["name"]),
                'description' => $this->input->post('post_event_version_history'),
                'username' => $user,
                'comment' => $this->input->post('post_event_comment'),
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["student_sample_low"]["name"]);            
        if (move_uploaded_file($_FILES["student_sample_low"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'student_sample_low',
                'origin_name' => basename($_FILES["student_sample_low"]["name"]),
                'description' => $this->input->post('student_sample_low_version_history'),
                'username' => $user,
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["student_sample_medium"]["name"]);            
        if (move_uploaded_file($_FILES["student_sample_medium"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'student_sample_medium',
                'origin_name' => basename($_FILES["student_sample_medium"]["name"]),
                'description' => $this->input->post('student_sample_med_version_history'),
                'username' => $user,
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["student_sample_high"]["name"]);            
        if (move_uploaded_file($_FILES["student_sample_high"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'student_sample_high',
                'origin_name' => basename($_FILES["student_sample_high"]["name"]),
                'description' => $this->input->post('student_sample_high_version_history'),
                'username' => $user,
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        
        
        $data = array(
            'type' => 'success',
            'message' => 'Success to save'
        );
        echo json_encode($data);
        //redirect(site_url().'welcome');
        //echo json_encode(array("status" => TRUE));
    }

    public function update() {    

        $form_id = $this->input->post('id');

        $pre_status = $this->input->post('pre_event_status');
        $pre_event_status = "";
	//$pre_event_status = $pre_status . "_";
        foreach ($pre_status as $color){ 
            $pre_event_status = $pre_event_status . $color . "_";
        }

        $post_event_status1 = $this->input->post('post_event_status');
        $post_event_status = "";
	//$post_event_status = $post_event_status1 . "_";
        foreach ($post_event_status1 as $color){ 
            $post_event_status = $post_event_status . $color . "_";
        }

        //update assessment form
        $data = array(
            'pre_event_status' => $pre_event_status,
            'course_name' => $this->input->post('course_name'),
            'post_event_status' => $post_event_status,

            'year' => $this->input->post('year'),
            'semester' => $this->input->post('semester'),            
            'assessment_release_date' => $this->input->post('assessment_release_date'),   
            'submission_due_date' => $this->input->post('submission_due_date'),
            'course_id' => $this->input->post('course_id'),
            'pre_reminder' => $this->input->post('pre_reminder'),
            'pre_reminder_day' => $this->input->post('pre_reminder_day'),
            'post_reminder' => $this->input->post('post_reminder'),
            'post_reminder_day' => $this->input->post('post_reminder_day'),
            'course_description' => $this->input->post('course_description'),
        );
                
        $this->assessment_model->update(array('id' => $form_id),$data);
        
        $target_dir = "uploads/" . $form_id . "_" . $this->input->post('course_name') ."/";
        if(!is_dir($target_dir))
            mkdir($target_dir,0755,true);
        $status = 0;
        
        $user = $this->session->userdata('logged_in');  
        
       if($user)
           $user = $user['username'];
        $target_file = $target_dir  . uniqid() . basename($_FILES["assessment_description"]["name"]);   
               
        if (move_uploaded_file($_FILES["assessment_description"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'assessment_description',
                'origin_name' => basename($_FILES["assessment_description"]["name"]),
                'username' => $user,
                /*'description' => $this->input->post('assessment_description_version_history'),*/
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["marking_criteria"]["name"]);            
        if (move_uploaded_file($_FILES["marking_criteria"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'marking_criteria',
                'origin_name' => basename($_FILES["marking_criteria"]["name"]),
                'username' => $user,
                /*'description' => $this->input->post('marking_criteria_version_history'),*/
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["exam_solution"]["name"]);            
        if (move_uploaded_file($_FILES["exam_solution"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'exam_solution',
                'origin_name' => basename($_FILES["exam_solution"]["name"]),
                'username' => $user,
                /*'description' => $this->input->post('exam_solution_version_history'),*/
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["pre_event_file"]["name"]);            
        if (move_uploaded_file($_FILES["pre_event_file"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'pre_event_file',
                'origin_name' => basename($_FILES["pre_event_file"]["name"]),
                'username' => $user,
                /*'description' => $this->input->post('pre_event_version_history'),*/
                'comment' => $this->input->post('pre_event_comment'),
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["post_event_file"]["name"]);            
        if (move_uploaded_file($_FILES["post_event_file"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'post_event_file',
                'origin_name' => basename($_FILES["post_event_file"]["name"]),
                'username' => $user,
                /*'description' => $this->input->post('post_event_version_history'),*/
                'comment' => $this->input->post('post_event_comment'),
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["student_sample_low"]["name"]);            
        if (move_uploaded_file($_FILES["student_sample_low"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'student_sample_low',
                'origin_name' => basename($_FILES["student_sample_low"]["name"]),
                'username' => $user,
                /*'description' => $this->input->post('student_sample_low_version_history'),*/
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["student_sample_medium"]["name"]);            
        if (move_uploaded_file($_FILES["student_sample_medium"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'student_sample_medium',
                'origin_name' => basename($_FILES["student_sample_medium"]["name"]),
                'username' => $user,
                /*'description' => $this->input->post('student_sample_med_version_history'),*/
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }

        $target_file = $target_dir  . uniqid() . basename($_FILES["student_sample_high"]["name"]);            
        if (move_uploaded_file($_FILES["student_sample_high"]["tmp_name"], $target_file)) {            
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'file_name' => $target_file,
                'uploaded_on' => date("Y-m-d H:i:s"),
                'kind' => 'student_sample_high',
                'origin_name' => basename($_FILES["student_sample_high"]["name"]),
                'username' => $user,
                /*'description' => $this->input->post('student_sample_high_version_history'),*/
                'form_id' => $form_id
            );
            $this->file->save($data);
        } else {
            $status = 1;
        }
        
        $data = array(
            'type' => 'success',
            'message' => 'Success to save'
        );
        echo json_encode($data);
    }

    public function delete($id) {
        $this->assessment_model->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function download_file($id) {
        $result = $this->file->getDataByid($id);        
        $file_path = $result[0]->file_name;
        $filename = $result[0]->origin_name;
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"".$filename."\""); 
        echo readfile($file_path);
    }

    public function delete_file($id) {
        $result = $this->file->getDataByid($id);                
        $file_path = $result[0]->file_name;    
        unlink($file_path);
        $this->file->delete($id);
        echo json_encode(array());
    }
}
