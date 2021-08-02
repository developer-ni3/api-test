<?php

class MY_Controller extends CI_Controller{

	public $data = array();
	
	function __construct(){
			parent::__construct();
		$this->data['errors'] = array();
		$this->data['site_name'] = config_item('site_name');
		$this->data['city'] = "Mumbai";


		$this->data['meta_title'] = 'MCQ';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('admin_m');
		
		//login check
		
		$exception_uris = array(
			'admin/admin/login',
			'admin/admin/logout'
		);
		
		if(in_array(uri_string(), $exception_uris) == FALSE){
			
				if($this->admin_m->loggedin() == FALSE){
					redirect(base_url('admin/admin/login'));
				}
		}
			
		}
	
}