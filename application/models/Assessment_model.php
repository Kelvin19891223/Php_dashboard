<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_model extends CI_Model {

	var $table = 'assessment_form';
	var $column = array('course_name','course_schedule','course_prescription','id','assessment_description','marking_criteria',
			'exam_solution','assessment_release_date','submission_due_date','pre_event_file','pre_event_status','post_event_file','post_event_status',
			'student_sample_high','student_sample_medium','student_sample_low');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			//$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function getDataById($id) {
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	function getList($id)
	{
		$this->_get_datatables_query();
		$this->db->where('course_id',$id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id)
	{
		$this->_get_datatables_query();
		$this->db->where('course_id',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id)
	{
		$this->db->from($this->table);
		$this->db->where('course_id',$id);
		return $this->db->count_all_results();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function getAllData() {
		$this->db->from($this->table);				
		$query = $this->db->get();
		return $query->result();
	}

	function get_taught_course($flag)
	{
		$this->db->select('*');
		$this->db->from("assessment_form");		
		$this->db->join('assign_role', 'assign_role.id = assessment_form.course_id');				
		if($flag==1)
			$this->db->where('course_kind','Taught');
		else
			$this->db->where('course_kind','Moderate');
		$query = $this->db->get();	
		$result = $query->result();
		
		return $result;//$query->result();
	}

	function get_notify($type) {
		if($type == 1)		
			$result = $this->db->query("select pre_reminder as reminder, assessment_release_date AS day from assessment_form where assessment_release_date LIKE ADDDATE(CURDATE(), pre_reminder_day) ");
		else
			$result = $this->db->query("select post_reminder as reminder, submission_due_date as day from assessment_form where assessment_release_date LIKE ADDDATE(CURDATE(), post_reminder_day) ");
		return $result->result();
	}
}
