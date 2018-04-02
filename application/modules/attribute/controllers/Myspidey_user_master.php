<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Myspidey_user_master extends MX_Controller {
     public function __construct() { 
        parent::__construct();
		$this->load->model('myspidey_user_master_model');
		$this->load->model('myspidey_user_group_permissions_model');
		$this->load->helper(array('common_functions_helper','image_upload_helper'));
		
		$user_id 	= $this->session->userdata('admin_user_id');
		$user_name 	= $this->session->userdata('user_name');
		if(empty($user_id) || empty($user_name)){
			redirect('myspidey_login');	exit;
		}
      }
	 

     public function add_user() {
		 $data					= array();
		// $id 					= $this->uri->segment(3);
		 // $data['ownership'] 	= $this->myspidey_user_master_model->get_ownership($id);
		 $data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
   		 $this->load->view('add_member', $data); 
     }
	 
	 public function edit_user() {
		 $data					= array();
		 $id 					= $this->uri->segment(4);
		 $data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
		 $data['get_user_details'] 	= $this->myspidey_user_master_model->get_user_details($id);
   		 $this->load->view('add_member', $data); 
     }
	 
	 public function save_user() {
 		  parse_str($_POST['newdata'], $searcharray);
		  //echo '<pre>'; print_r($searcharray);exit;
 		  ## helper used for image upload
		  $res = upload_image_n_thumb($_FILES['file'] , 'uploads/rwaprofilesettings','thumb');
		  $searcharray['profile_photo']='';
		  $result = json_decode($res);
		  if(!empty($result[0]->success)){
			  $searcharray['profile_photo']=$result[0]->success;
 		  }
		  echo $this->myspidey_user_master_model->save_user($searcharray);  exit;
      }
	  
	  
	   public function checkUnameEmail(){
		$uid = $this->input->post('userid');
	  	$email = $this->input->post('user_email');
		$isExists = $this->myspidey_user_master_model->checkEmail($email,$uid);
		echo $isExists;exit;	
	  }
  }?>
