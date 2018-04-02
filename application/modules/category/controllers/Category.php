<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Category extends MX_Controller {

     public function __construct() {

        parent::__construct();

		$this->load->helper('common_functions_helper');

		$this->load->model('Category_model');
		$this->load->library('pagination');
		$user_id 	= $this->session->userdata('admin_user_id');

		$user_name 	= $this->session->userdata('user_name');

		if(empty($user_id) || $user_id!=1){

			 redirect('login');exit;
 		}
  		//$this->load->library(array('encrypt','MY_Encrypt'));
    }

       public function listing() {
		#--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
		
        $total_records = $this->Category_model->total_load_listingData($srch_string);
		
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["listingData"] = $this->Category_model->load_listingData($limit_per_page, $start_index,$srch_string);
			//$data['listingData']=$this->Category_model->load_listingData();
             
            $config['base_url'] = base_url() . 'category/listing/';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
 			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';	
			$config["first_link"] = "&laquo;";
			$config["first_tag_open"] = "<li>";
			$config["first_tag_close"] = "</li>";
			$config["last_link"] = "&raquo;";
			$config["last_tag_open"] = "<li>";
			$config["last_tag_close"] = "</li>";
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '<li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '<li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
 
			## paging style configuration End 
            $this->pagination->initialize($config);
             // build paging links
            $params["links"] = $this->pagination->create_links();
        }
		##--------------- pagination End ----------------##
		//$data['listingData']=$this->Category_model->load_listingData();

		$this->load->view('user_group_permission_main', $params); 

     }

	 

	   public function getListingData() {

		//$this->checklogin();

        $data = array();

		return $this->Category_model->load_listingData();

      }

	 

	 # Save Menu function

	 public function saveData() {

		 parse_str($_POST[form_data], $searcharray);
 		 //echo '<pre>';print_r($searcharray);exit;
  			echo $this->Category_model->saveMenu($searcharray);exit;
        }

	   

	 

	 # get_edit_section function

	 public function get_edit_section() {

		 $data					= array();

		 $id 					= $this->uri->segment(3);

		 $data['edited_data'] 	= $this->Category_model->get_edited_data($id);

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

 		$this->Category_model->saveChildData($searcharray);

     }

	 

	 public function edit_child_industry() {

		 $data					= array();

		 $id 					= $this->uri->segment(3);

		 $data['edited_data'] 	= $this->Category_model->get_edited_data($id);

   		 $this->load->view('child_menu', $data); 

     }

	 

	 public function add_group() {

		 $data					= array();

		// $id 					= $this->uri->segment(3);

		 $data['ownership'] 	= $this->Category_model->get_ownership();

   		 $this->load->view('add_group', $data); 

     }

	 

	 public function edit_group() {

		 $data					= array();

		 $id 					= $this->uri->segment(3);

		

		 ## For Drop down

		 $data['ownership'] 	= $this->Category_model->get_ownership();

		 $data['getGroupData'] 	= $this->Category_model->getGroupData($id);

   		 $this->load->view('edit_group', $data); 

     }

	 

	 public function save_group() {

		 parse_str($_POST[form_data], $searcharray);

 		 //echo '<pre>';print_r($searcharray);exit;

 		$this->Category_model->save_group($searcharray);

     }

	 

	 public function view_users($id) {	

	 	$data['group_id']	 = $id; 

		$data['users']=$this->Category_model->view_users($id);

 		$this->load->view('view_users',$data);

     }

	 

	 

	 public function set_permissions() {	

	 	$data['group_id'] = $this->uri->segment(3);

    	$this->load->view('user_permissions_tpl',$data);

     }

 	 

	 public function save_permissions() {	

 	 	//echo '<pre>';print_r($this->input->post());exit;

 		$data['permission_data'] = $this->input->post();

 		$this->Category_model->save_permissions_data($data);

  		$this->load->view('user_permissions_tpl',$data);

     }

	 

	  public function edit_permissions() {	

	 	$data['group_id'] = $this->uri->segment(3);

		$data['group_permissions']=$this->Category_model->get_group_permission_data();

		//print_r($data['group_permissions']);

  		$this->load->view('user_permissions_tpl',$data);

     }

	  public function isPermissionExists() {	

	 	$id = $this->input->post('id');

		$count=$this->Category_model->get_group_permission_rows();

       }

	 public function delete_menu() {

		   $parentId 			= $this->input->post('parent_id');

		   $child_id 			= $this->input->post('child_id');

 		   $data				= array();

 		   $res		    		= $this->Category_model->deleteMenu($parentId, $child_id);

		   echo $res;exit;

      } 
	  
	  function list_other_industry(){
		  
 		 $data					= array();
		 
		 #--------------- pagination start ----------------##
		 // init params
		$params = array();
		$limit_per_page = 20;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$srch_string =  $this->input->post('search'); 
		
		if(empty($srch_string)){
			$srch_string ='';
		}
		  $user_id 	= $this->session->userdata('admin_user_id');	
		 
		  $total_records 	= $this->Category_model->total_get_all_other_industry($srch_string);
		 
        //$total_records = $this->Category_model->total_load_listingData($srch_string);
		
		if ($total_records > 0) 
        {
            // get current page records
 			$params['userListing'] 	= $this->Category_model->get_all_other_industry($limit_per_page, $start_index,$srch_string);
  			
			//$data['listingData']=$this->Category_model->load_listingData();
             
            $config['base_url'] = base_url() . 'plant_master/list_plants';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
 			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';	
			$config["first_link"] = "&laquo;";
			$config["first_tag_open"] = "<li>";
			$config["first_tag_close"] = "</li>";
			$config["last_link"] = "&raquo;";
			$config["last_tag_open"] = "<li>";
			$config["last_tag_close"] = "</li>";
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '<li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '<li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
 
			## paging style configuration End 
            $this->pagination->initialize($config);
             // build paging links
            $params["links"] = $this->pagination->create_links();
        }
		##--------------- pagination End ----------------##
    	$this->load->view('list_other_industry', $params);
	  }

	 public function change_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='0';# Now it will be inactive
		 }
 		 echo $status= $this->Category_model->change_status($id,$status);exit;
      }
	  
	   public function edit_other_industry() {
  		 $data					= array();
		 $id 					= $this->uri->segment(3);//$this->session->userdata('admin_user_id');
 		 $data['get_user_details'] 	= $this->Category_model->get_other_industry_details($id);
    	 $this->load->view('edit_other_industry', $data); 
      }
	  
	  function updateSaveIndustry(){
	  	$returnData=0;
	  	if($this->input->post('submit') && $this->input->post('submit')=='Update Industry'){
			$id = $this->input->post('id');
			$name = $this->input->post('industry_name');
			if($this->Category_model->update_other_industry($id,$name)){
				$returnData= 1;
			}
		}
		return $returnData;
	  }
	  
	  function checkName(){
		 	$id = $this->input->post('id');
			$name = $this->input->post('industry_name');
			echo $this->Category_model->checkExistsIndustry($id,$name);exit;
	  }
	  

  }

