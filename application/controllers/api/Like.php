<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Like extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('likes');
    }

    public function like_post() {
        // Get the post data
        $user_id = strip_tags($this->post('user_id'));
        $post_id = strip_tags($this->post('post_id'));

        // Insert user data
        $userData = array(
            'l_p_id' => $post_id,
            'l_u_id' => $user_id
        );
        $insert = $this->likes->insert($userData);
        
        // Check if the user data is inserted
        if($insert){
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'message' => 'Liked',
                'data' => $insert
            ], REST_Controller::HTTP_OK);
        }else{
            // Set the response and exit
            $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
