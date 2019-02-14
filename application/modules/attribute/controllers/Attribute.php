<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Attribute extends MX_Controller {
     public function __construct() {
        parent::__construct();
		$this->load->helper('common_functions_helper');
		$this->load->model('Attribute_model');
		$user_id 	= $this->session->userdata('admin_user_id');
		$user_name 	= $this->session->userdata('user_name');
		if(empty($user_id) || $user_id!=1){
			 redirect('/backend/login');exit;
		}
 		//$this->load->library(array('encrypt','MY_Encrypt'));
      }
 	  
     public function listing() {
		//$this->checklogin();
        $data = array();
		$data['listingData']=$this->Attribute_model->load_listingData();
		$this->load->view('user_group_permission_main', $data); 
     }
	 
	   public function getListingData() {
		//$this->checklogin();
        $data = array();
		return $this->Attribute_model->load_listingData();
      }
	 
	 # Save Menu function
	 public function saveData() {
		 parse_str($_POST[form_data], $searcharray);
		
		 //echo '<pre>';print_r($searcharray);exit;
 			$this->Attribute_model->saveMenu($searcharray);
       }
	   
	 
	 # get_edit_section function
	 public function get_edit_section() {
		 $data					= array();
		 $id 					= $this->uri->segment(3);
		 $data['edited_data'] 	= $this->Attribute_model->get_edited_data($id);
 		//echo '<pre>' ;print_r($data);exit;
  		 $this->load->view('user_group_permission_main', $data); 
     }
	
	 public function get_child_menu() {
		 $data					= array();
   		 $this->load->view('child_menu', $data); 
     }
	  
	  # Save Menu function
	 public function saveChildData() {
		parse_str($_POST[form_data], $searcharray);
 		$this->Attribute_model->saveChildData($searcharray);
     }
	 
	 public function edit_child_industry() {
		 $data					= array();
		 $id 					= $this->uri->segment(3);
		 $data['edited_data'] 	= $this->Attribute_model->get_edited_data($id);
   		 $this->load->view('child_menu', $data); 
     }
	 
	 public function add_group() {
		 $data					= array();
		// $id 					= $this->uri->segment(3);
		 $data['ownership'] 	= $this->Attribute_model->get_ownership();
   		 $this->load->view('add_group', $data); 
     }
	 
	 public function edit_group() {
		 $data					= array();
		 $id 					= $this->uri->segment(3);
		
		 ## For Drop down
		 $data['ownership'] 	= $this->Attribute_model->get_ownership();
		 $data['getGroupData'] 	= $this->Attribute_model->getGroupData($id);
   		 $this->load->view('edit_group', $data); 
     }
	 
	 public function save_group() {
		 parse_str($_POST[form_data], $searcharray);
 		 //echo '<pre>';print_r($searcharray);exit;
 		$this->Attribute_model->save_group($searcharray);
     }
	 
	/* public function view_users($id) {	
	 	$data['group_id']	 = $id; 
		$data['users']=$this->Attribute_model->view_users($id);
 		$this->load->view('view_users',$data);
     }
	 
	 
	 public function set_permissions() {	
	 	$data['group_id'] = $this->uri->segment(3);
    	$this->load->view('user_permissions_tpl',$data);
     }*/
 	 
	/* public function save_permissions() {	
 	 	//echo '<pre>';print_r($this->input->post());exit;
 		$data['permission_data'] = $this->input->post();
 		$this->Attribute_model->save_permissions_data($data);
  		$this->load->view('user_permissions_tpl',$data);
     }
	 
	  public function edit_permissions() {	
	 	$data['group_id'] = $this->uri->segment(3);
		$data['group_permissions']=$this->Attribute_model->get_group_permission_data();
		//print_r($data['group_permissions']);
  		$this->load->view('user_permissions_tpl',$data);
     }
	  public function isPermissionExists() {	
	 	$id = $this->input->post('id');
		$count=$this->Attribute_model->get_group_permission_rows();
       }*/
	 public function delete_menu() {
		   $parentId 			= $this->input->post('parent_id');
		   $child_id 			= $this->input->post('child_id');
 		   $data				= array();
 		   $res		    		= $this->Attribute_model->deleteMenu($parentId, $child_id);
		   echo $res;exit;
      } 
	  

	
		public function checkAttribute() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $parent = $this->input->post('product_id');

        $mobile = $this->input->post('attribute');

        $isExists = $this->Attribute_model->checkAttribute($mobile, $parent);

        echo $isExists;
        exit;
    }
	
 }
