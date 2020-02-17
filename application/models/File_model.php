<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends CI_Model {

	var $table = 'files';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		    $this->search = '';

	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function getDataByFormid($type,$id) {
		$this->db->from($this->table);
		$this->db->where('form_id',$id);
		$this->db->where('kind',$type);
		$this->db->order_by("uploaded_on", "asc");
		$query = $this->db->get()->result();
		return $query;
	}

	public function getDataByid($id) {
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get()->result();
		return $query;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
}
