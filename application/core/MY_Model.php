<?php

class MY_Model extends CI_Model{
	
	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	public $rules = array();
	protected $_timestamps = FALSE;
	
	function __construct(){
		
		parent::__construct();
	}
	
	public function array_from_post($fields){
		foreach($fields as $field){
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}
	
	public function get($id = NULL, $single = FALSE){
//IF ID IS PASSED */
		if($id != NULL){
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method ='row';
		}
//IF ID IS NOT PASSED AND SINGLE ROW IS ASKED FROM DB
		elseif($single == TRUE){
			$method = 'row';
		}
//IF ID IS NOT PASSED AND MULTIPLE RESULTS ARE ASKED FROM DB
		else{
			$method = 'result';
		}
//IF COUNT IS NOT NULL
		// if(!count($this->db->ar_orderby)){
		// 	$this->db->order_by($this->_order_by);
		// }
		return $this->db->get($this->_table_name)->$method();
	}
	
	
	public function get_by($where, $single = FALSE){
		$this->db->where($where);
		return $this->get(NULL, $single);
	}
	// new function to load 10  items
	public function get_byten($where, $data=[],$single = FALSE){
		
		$this->db->where($where);
		$this->db->limit(10, 10*$data);
		return $this->get(NULL, $single);
	}
	
	public function save($data, $id = NULL){
//Set Timestamps
		
		if($this->_timestamps == TRUE){
			$now = date('Y-m-d H:i:s');
			$id || $data['created'] = $now;
			$data['modified'] = $now;
			
		}
		
//Insert
		if($id === NULL){
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id = $this->db->insert_id();
		}
//Update
		else{
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->set($data);
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name);
			
		}
		return $id;
	}
	
	public function delete($id){
		$filter = $this->_primary_filter;
		$id = $filter($id);
		
		if(!$id){
			return FALSE;
		}
		$this->db->where($this->_primary_key, $id);
		$this->db->limit(1);
		$this->db->delete($this->_table_name);
	}
	
}

?>