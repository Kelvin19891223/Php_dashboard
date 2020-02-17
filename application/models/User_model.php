<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	var $table = 'users';
	var $column = array('first_name','last_name','email','password','address','is_active','created_at','last_login','username','phone','user_level','gender','address','level','dob');
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
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

    /**
     * Get the All User Info
     */
    public function getAllUsers() {
        $this->db->from($this->table);
		$query = $this->db->get();
		return $query->result();
	}
	
	function getlist()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('users_id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		if($this->getData('email',$data['email']) != 0 || $this->getData('username',$data['username']) != 0 )
		{
			$notif['message'] = 'Email or Username must be unique.';
			$notif['type'] = 'error'; 
		} else if($data['password'] == '70cd335bc843b7234b6068eba9577563c3189410') {
			$notif['message'] = 'Password must have a string.';
			$notif['type'] = 'error'; 
		} else if(!$data['first_name'] || !$data['last_name']) {
			$notif['message'] = 'First name or Last name must have a string.';
			$notif['type'] = 'error'; 
		} else if(!$data['username']) {
			$notif['message'] = 'Username must have a string.';
			$notif['type'] = 'error'; 
		} else if(!$data['email']) {
			$notif['message'] = 'Email must have a string.';
			$notif['type'] = 'error'; 
		} else 
		{
			$this->db->insert($this->table, $data);
			$users_id = $this->db->insert_id();        
			if ($this->db->affected_rows() > 0) {
				$notif['message'] = 'Saved successfully';
				$notif['type'] = 'success';            
			} else {
				$notif['message'] = 'Something wrong !';
				$notif['type'] = 'danger';
			}
		}
        return $notif;
	}

	public function update($where, $data)
	{
		if($this->getData('email',$data['email']) > 1)
		{
			$notif['message'] = 'Email must be unique.';
			$notif['type'] = 'error'; 
		} else if($data['password'] == '70cd335bc843b7234b6068eba9577563c3189410') {
			$notif['message'] = 'Password must have a string.';
			$notif['type'] = 'error'; 
		} else if(!$data['first_name'] || !$data['last_name']) {
			$notif['message'] = 'First name or Last name must have a string.';
			$notif['type'] = 'error'; 
		} else if(!$data['username']) {
			$notif['message'] = 'Username must have a string.';
			$notif['type'] = 'error'; 
		} else if(!$data['email']) {
			$notif['message'] = 'Email must have a string.';
			$notif['type'] = 'error'; 
		} else 
		{
			$this->db->update($this->table, $data, $where);			
			$notif['message'] = 'Saved successfully';
			$notif['type'] = 'success';            
		}
		return $notif;		
	}

	public function delete_by_id($id)
	{
		$this->db->where('users_id', $id);
		$this->db->delete($this->table);
	}

	public function getData($kind,$value) {
		$this->db->from($this->table);
		$this->db->where($kind, $value);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_by_id_view($id)
	{
		$this->db->from($this->table);
		$this->db->where('users_id',$id);
		$query = $this->db->get();
		$results = "";
		if($query->num_rows() > 0) {
			$results = $query->result();
		}
		return $results;
	}
}
