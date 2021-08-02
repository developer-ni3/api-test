<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->postTbl = 'comments';
    }
    
    /*
     * Insert record
     */
    public function insert($data){
        //add created and modified date if not exists
        if(!array_key_exists("c_created", $data)){
            $data['c_created'] = date("Y-m-d H:i:s");
        }
        
        //insert user data to users table
        $insert = $this->db->insert($this->postTbl, $data);
        
        //return the status
        return $insert?$this->db->insert_id():false;
    }

}