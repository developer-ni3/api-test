<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Posts extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('post');
    }

    public function post_post() {
        // Get the post data
        $fileExt = pathinfo($_FILES["post"]["name"], PATHINFO_EXTENSION);
        //print_r($fileExt);
        $user_id = strip_tags($this->post('user_id'));
        $caption = strip_tags($this->post('caption'));
    
        // Validate the post data
        if(!empty($user_id) && !empty($_FILES['post']['name'])){
            $allowed_images = array('gif', 'png', 'jpg', 'jpeg');
            $allowed_videos = array('avi', 'flv', 'wmv', 'wma', 'mp4');
            $config['upload_path'] = 'uploads/post/';
            if (in_array($fileExt, $allowed_images)) {
                // is an image
               // echo 111111111;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                //$config['max_size'] = '200';
                //$config['max_width']  = '250';
                //$config['max_height']  = '250';
                $config['file_name']  = $_FILES['post']['name'];
                $post_type = 0;
            }elseif (in_array($fileExt, $allowed_videos)) { 
                // is a video
                $config['max_size'] = '50240';
                $config['allowed_types'] = 'avi|flv|wmv|wma|mp4';
                $config['overwrite'] = FALSE;
                $config['remove_spaces'] = TRUE;
                $video_name = $_FILES['post']['name'];
                $config['file_name'] = $video_name;
                $post_type = 1;
            }
            
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            
            if($this->upload->do_upload('post')){
                $uploadData = $this->upload->data();
                $post = $uploadData['file_name'];
            }else{
                $this->response("size !!!!!Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response("Please choose file to upload", REST_Controller::HTTP_BAD_REQUEST);
        }

        // Insert user data
        $userData = array(
            'p_u_id' => $user_id,
            'p_caption' => $caption,
            'p_type' => $post_type,
            'p_link' => base_url('uploads/post/'.$post)
        );
        $insert = $this->post->insert($userData);
        
        // Check if the user data is inserted
        if($insert){
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'message' => 'The post has been added successfully.',
                'data' => $insert
            ], REST_Controller::HTTP_OK);
        }else{
            // Set the response and exit
            $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
