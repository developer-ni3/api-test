<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Follower extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->postTbl = 'followers';
    }
    
    /*
     * Insert record
     */
    public function insert($data){
        //add created and modified date if not exists
        if(!array_key_exists("f_created", $data)){
            $data['f_created'] = date("Y-m-d H:i:s");
        }
        
        //insert user data to users table
        $insert = $this->db->insert($this->postTbl, $data);
        
        //return the status
        return $insert?$this->db->insert_id():false;
    }

    /*
     * Delete data
     */
    public function delete($where = array()){
        //update user from users table
        $this->db->where($where);
        //$this->db->delete($this->postTbl);

        $delete = $this->db->delete($this->postTbl);
        //echo $this->db->last_query(); die;
        //return the status
        return $delete?true:false;
    }

}