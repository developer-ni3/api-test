<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class FolloUnfollow extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('follower');
    }

    public function follow_post() {
        // Get the post data
        $following_id = strip_tags($this->post('following_id'));
        $follower_id = strip_tags($this->post('follower_id'));
        if(!empty($follower_id) && !empty($following_id)){
            // Insert user data
            $userData = array(
                'f_following' => $following_id,
                'f_follower' => $follower_id
            );
            $insert = $this->follower->insert($userData);
            
            // Check if the user data is inserted
            if($insert){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'You have started following.',
                    'data' => $insert
                ], REST_Controller::HTTP_OK);
            }else{
                // Set the response and exit
                $this->response("Some problems occurred, please try again.1", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            // Set the response and exit
            $this->response("Some problems occurred, please try again.2", REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function unfollow_post(){
        //update user from users table       
        $following_id = strip_tags($this->post('following_id'));
        $follower_id = strip_tags($this->post('follower_id'));

        if(!empty($follower_id) && !empty($following_id)){
            $where = array();
            $where = array('f_follower'=>$follower_id,'f_following'=>$following_id);
            $delete = $this->follower->delete($where);
            if($delete){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'You have unfollowed successfully'
                ], REST_Controller::HTTP_OK);
            }else{
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            // Set the response and exit
            $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
