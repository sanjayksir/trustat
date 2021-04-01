<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class role_master extends MX_Controller {
      public function __construct() { 
        parent::__construct();
 		$this->load->model(array('role_master_model','myspidey_user_group_permissions_model'));
  		$this->load->helper(array('common_functions_helper'));
   		$user_id 	= $this->session->userdata('admin_user_id');
		$this->load->library('pagination');
 		$user_name 	= $this->session->userdata('user_name');
 		if(empty($user_id) || empty($user_name)){
 			redirect('login');	exit;
		}
      }
	  
      public function list_plants() {
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
		 
		  $total_records 	= $this->plant_master_model->total_get_user_list_all($srch_string);
		 
        //$total_records = $this->Category_model->total_load_listingData($srch_string);
		
		if ($total_records > 0) 
        {
            // get current page records
 			$params['userListing'] 	= $this->plant_master_model->get_user_list_all($limit_per_page, $start_index,$srch_string);
  			
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
    	$this->load->view('list_plant_tpl', $params);
     }
  
     public function add_plant() {
 		 $data					= array();
   		 $this->load->view('add_plant', $data); 
      }
 
	 public function edit_plant() {
 		 $data					= array();
		 $id 					= $this->uri->segment(3);//$this->session->userdata('admin_user_id');
 		 $data['get_user_details'] 	= $this->plant_master_model->get_plant_details($id);
    	 $this->load->view('add_plant', $data); 
      }

 	 public function save_plant() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->plant_master_model->save_user($savedData);  exit;

      }

 	   public function checkUnameEmail(){
 		$uid = $this->input->post('userid');

	  	$email = $this->input->post('user_email');

		$isExists = $this->plant_master_model->checkEmail($email,$uid);

		echo $isExists;exit;	

	  }
	  
	   public function checkPlantName(){
		$plant_id = '';
		$plant_id = $this->input->post('plant_id');
 	  	$plant_name = $this->input->post('plant_name');
 		$isExists = $this->plant_master_model->checkPantName($plant_name,$plant_id);
 		echo $isExists;exit;	
 	  }
	  
	  
	   public function change_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='0';# Now it will be inactive
		 }
		 //$user_id 	= $this->session->userdata('admin_user_id');		
		 echo $status= $this->plant_master_model->change_status($id,$status);exit;
   		  
     }
	 
	  ## get city list
	 
	 function get_city_list()
	  {		$state_id = $this->input->post('state_id');
			$city_list = $this->plant_master_model->get_city_listing($state_id);
			$option='';
			foreach($city_list as $val){
			$option.='<option value="'.$val['id'].'">'.$val['ci_name'].'</option>       ';
			}
			echo $option;exit;
	 }
	 
	  public function view_plant() {
 		 $data						= array();
		 $id 						= $this->uri->segment(3);//$this->session->userdata('admin_user_id');
 		 $data['get_user_details'] 	= $this->plant_master_model->get_plant_details($id);
 		 //echo '***'.$data['get_user_details'][0]['city'];
		 $data['show_city_name']	 =$this->plant_master_model->fetch_city_name( $data['get_user_details'][0]['city']);
   		 $this->load->view('view_plant', $data); 

     }
	 
	   public function assign_plants() {
 		 $data						= array();
 		 $data['get_user_details'] 	= $this->plant_master_model->get_plant_details();
   		 $this->load->view('assign_plant', $data); 

     }
	  public function save_assign_plant() {
			$result = '';
			$plant_array = $this->input->post('plants');
			$sku_array = $this->input->post('sku_product');
			if(count($plant_array)>0 && count($sku_array)>0){
				$result = $this->plant_master_model->save_assign_plants_sku(json_encode($plant_array), json_encode($sku_array));	
			}
			echo  $result;exit;
	
		 }
		 
		public function save_assigned_functionalities_to_role() {
			$result = '';
			$functionality_array = json_encode($this->input->post('functionalities'));
		    $role		 = $this->input->post('role');
			$customer_idF		 = $this->input->post('customer_idF');
			//$user_id		 = $this->input->post('role');
			$role_quantity		 = $this->input->post('role_quantity');			
 			if(count($this->input->post('functionalities'))>0 && count($role)>0){
				$result = $this->role_master_model->save_assigned_functionalities_to_role($functionality_array, $role, $role_quantity, $customer_idF);	
			}
			echo  $result;exit;
 		 } 
		 
		 
		public function getProductList() {
			$result = '';
			$id = $this->input->post('id');
			$user_id 	= $this->session->userdata('admin_user_id');
			## assigned products array
			$assigned_arr = explode(',',get_assigned_products_list($id));
			//print_r($assigned_arr);
			
			$product_data = get_all_products_sku($user_id);
			 foreach($product_data as $res){?>
            <option value="<?php echo $res['id'];?>" <?php if(in_array($res['id'],$assigned_arr )){echo 'selected';}?>><?php echo $res['product_name'];?></option>
          <?php }
			return $result;
	
		 }
		 
		public function getAssignedProductList() {
			$result = '';
			$id = $this->input->post('id');
			$user_id 	= $this->session->userdata('admin_user_id');
			## assigned products array
			$assigned_arr = explode(',',get_assigned_products_to_plant($id));
			//print_r($assigned_arr); kk
			//$res_arr[0]['product_id']
			$product_data = get_all_products_sku($user_id);
			 foreach($product_data as $res){?>
			 <?php if(in_array($res['id'],$assigned_arr)) {?>
         <option value="<?php if(in_array($res['id'],$assigned_arr)){echo $res['id'];}?>"><?php if(in_array($res['id'],$assigned_arr)){echo $res['product_name'];}?></option>
			 <?php } ?>
          <?php }
			return $result;
	
		 }
		 
		 
		 
 		 public function list_assigned_plants_sku() {
			 $data					= array();
			 $user_id 				= $this->session->userdata('admin_user_id');		
			 $data['plant_data'] 	= get_all_plants($user_id);
			 $this->load->view('list_plant_sku_assign', $data);
     	}
		
		public function change_assign_product_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='0';# Now it will be inactive
		 }
		 //$user_id 	= $this->session->userdata('admin_user_id');		
		 echo $status= $this->plant_master_model->qry_change_assign_product_status($id,$status);exit;
   		  
     }
	 
	 
	  public function assign_functionalities_to_role() {
 		 $data						= array();
 		 $data['get_user_details'] 	= $this->role_master_model->get_plant_details();
   		 $this->load->view('assign_functionalities_to_role_tpl', $data); 
     }
	 
	 public function getPlantList() {
			$result = '';
			$id 			= $this->input->post('id');
			$user_id 		= $this->session->userdata('admin_user_id');
			## assigned plants array
 			$assigned_arr = explode(',',get_assigned_plants_list($id));
			
			//print_r($assigned_arr);exit;
			
 			$product_data 	= get_all_plants($user_id);
			 foreach($product_data as $res){?>
				<option value="<?php echo $res['plant_id'];?>" <?php if(in_array($res['plant_id'],$assigned_arr )){echo 'selected';}?>><?php echo $res['plant_name'];?></option>
          <?php }
			return $result;
	 }
	 
		public function getActivePlantList() {
			$result = '';
			$id 			= $this->input->post('id');
			$user_id 		= $this->session->userdata('admin_user_id');
			## assigned plants array
 			$assigned_arr = explode(',',get_assigned_active_plants_list($id));
			
			//print_r($assigned_arr);exit;
			
 			$product_data 	= get_all_active_plants($user_id);
			 foreach($product_data as $res){?>
				<option value="<?php echo $res['plant_id'];?>" <?php if(in_array($res['plant_id'],$assigned_arr )){echo 'selected';}?>><?php echo $res['plant_name'];?></option>
          <?php }
			return $result;
	 }	
	
	public function getActiveFunctionalitiestList() {
			$result = '';
			$id 			= $this->input->post('id');
			$customer_id 			= $this->input->post('customer_id');
			/*
			$user_id 		= $this->session->userdata('admin_user_id');
					if($user_id==1){
			 			$customer_id = $this->uri->segment(2);
			 			 }else{
			 				$customer_id = $user_id;	
						 }
						 */
			## assigned plants array
 			$assigned_arr = explode(',',get_assigned_active_functionalities_list($id, $customer_id));
			$product_data 	= get_all_active_functionalities($customer_id);
			 foreach($product_data as $res){?>
				<option value="<?php echo $res['id'];?>" <?php if(in_array($res['id'],$assigned_arr )){echo 'selected';}?>><?php echo $res['functionality_name_value'];?></option>
          <?php }
			return $result;
	 }
	 
	  function get_created_users_for_the_rolejs(){
			$result = '';
			$roleId 			= $this->input->post('id');
			$user_id 		= $this->session->userdata('admin_user_id');
 		   $role_quantity = get_required_users_for_the_role($roleId);
		   ?>
		   <input name="role_quantity" id="role_quantity" type="number" value="<?php echo $role_quantity;?>"/>
		<?php 
			return $result;
 }
 
	
	
	  public function list_assigned_functionalities_to_role() {
			 $data					= array();
			 $user_id				= $this->session->userdata('admin_user_id');	
				 if($user_id==1){
			 			$parent_id = $this->uri->segment(3);
			 			 }else{
			 				$parent_id = $user_id;	
						 }
			 $data['plant_data'] 	= get_active_roles($parent_id);
			 $this->load->view('list_assigned_functionalities_to_role_tpl', $data);
     	}
		
		
		
		
		public function change_assign_plant_status() {
 		 $id = $this->input->post('id');
		 $plantsId = $this->input->post('plant_id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='0';# Now it will be inactive
		 }
		 //$user_id 	= $this->session->userdata('admin_user_id');		
		 echo $status= $this->plant_master_model->qry_change_assign_plant_status($id,$status,$plantsId);exit;
   		  
     }
	 
	 ### delete Plant
 	   function del(){
	   	 $id = $this->uri->segment(3);
	  	 if(!empty($id)){
 		 	$id = base64_decode($id);
			$result  = $this->plant_master_model->delete_plant($id);
			$productIds = getAssociatedPlantProducts($id);
			//print_r($childIds);exit;
			if($productIds!=''){
				$result  = $this->myspidey_user_master_model->delete_associated_products($id, $productIds);
			}
		   if($result ==1){
		   		$this->session->set_flashdata('success', 'Plant and associated products deleted successfully!.');
		   }else{
		   		$this->session->set_flashdata('success', 'Plant not deleted!');	
		   }
			redirect(base_url().'user_master/list_user/');
	   	 }
	   }
	   
	   
	 // List all roles 
 public function list_all_roles() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->get('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->role_master_model->get_total_roles_count($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->role_master_model->get_roles_list($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('role_master/list_all_roles/', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_all_roles_tpl', $params);
    }
	
	// Add a role 
	public function add_role() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->role_master_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_role_tpl', $data);
    }
	

	// Save a role 
	public function save_role() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->role_master_model->save_role($savedData);  exit;

      }
	  
	
 // Edit a Role
     public function edit_role() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->role_master_model->get_role_details($id);		
        $this->load->view('add_role_tpl', $data);
    }

	public function checkRole() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $role_slug = $this->input->post('role_name_slug');
        $role_name = $this->input->post('role_name_value');
        $isExists = $this->role_master_model->checkRoleSlug($role_name, $role_slug);
        echo $isExists;
        exit;
    }
	
		 // List all functionalities
 public function list_all_functionalities() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->get('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->role_master_model->get_total_functionalities_count($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->role_master_model->get_functionalities_list($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('role_master/list_all_functionalities/', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_all_functionalities_tpl', $params);
    }
	
	// Add a role 
	public function add_functionality() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->role_master_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_functionality_tpl', $data);
    }
	

	// Save a functionality 
	public function save_functionality() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->role_master_model->save_functionality($savedData);  exit;

      }
	  
	
 // Edit a functionality
     public function edit_functionality() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->role_master_model->get_functionality_details($id);		
        $this->load->view('add_functionality_tpl', $data);
    }

	public function checkFunctionality() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $functionality_slug = $this->input->post('functionality_name_slug');
        $functionalitye_name = $this->input->post('functionality_name_value');
        $isExists = $this->role_master_model->checkFunctionalitySlug($functionalitye_name, $functionality_slug);
        echo $isExists;
        exit;
    }

	
	// Auto Email MIS configuration Management Starts
		 // List all Auto Email MIS configuration
 public function list_all_auto_email_mis_masters() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->get('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->role_master_model->get_total_auto_email_mis_masters_count($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->role_master_model->get_auto_email_mis_masters_list($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('role_master/list_all_auto_email_mis_masters/', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_all_auto_email_mis_masters_tpl', $params);
    }
	
	// Add a role 
	public function add_auto_email_mis_master() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->role_master_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_auto_email_mis_master_tpl', $data);
    }
	

	// Save a auto_email_mis_master 
	public function save_auto_email_mis_master() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->role_master_model->save_auto_email_mis_master($savedData);  exit;

      }
	  
	
 // Edit a auto_email_mis_master
     public function edit_auto_email_mis_master() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->role_master_model->get_auto_email_mis_master_details($id);		
        $this->load->view('add_auto_email_mis_master_tpl', $data);
    }

	public function checkAutoEmailMISMaster() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $mis_report_slug = $this->input->post('mis_report_slug');
        $mis_report_name = $this->input->post('mis_report_name');
        $isExists = $this->role_master_model->checkAutoEmailMISMasterSlug($mis_report_name, $mis_report_slug);
        echo $isExists;
        exit;
    }

	// Auto Email MIS configuration Management Ends
	
	// Auto Email MIS Customer Wise Starts
	
	 public function list_all_auto_email_mis_customer() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
		$customer_id = $this->uri->segment(3);
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $srch_string = $this->input->get('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->role_master_model->get_total_auto_email_mis_customer_count($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->role_master_model->get_auto_email_mis_customer_list($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('role_master/list_all_auto_email_mis_customer/' . $customer_id, $total_records, null, 4);
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_all_auto_email_mis_customer_tpl', $params);
    }
	
	/*
	   public function list_all_auto_email_mis_customer() {
        $this->checklogin();
       
        ##--------------- pagination start ----------------##
        // init params
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
		
		if($user_id>1){
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}else{
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}
		
		 
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->role_master_model->get_total_auto_email_mis_customer_count($srch_string);
        $params["userListing"] = $this->role_master_model->get_auto_email_mis_customer_list($limit_per_page, $start_index, $srch_string);
		if($user_id>1){
		$params["links"] = Utils::pagination('role_master/list_all_auto_email_mis_customer', $total_records);
			}else{
			$params["links"] = Utils::pagination('role_master/list_all_auto_email_mis_customer/' . $customer_id, $total_records, null, 4);
			}        	
        $this->load->view('list_all_auto_email_mis_customer_tpl', $params);
    }
	*/
	// Add a role 
	public function add_auto_email_mis_customer() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->role_master_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_auto_email_mis_customer_tpl', $data);
    }
	

	// Save a auto_email_mis_master 
	public function save_auto_email_mis_customer() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->role_master_model->save_auto_email_mis_customer($savedData);  exit;

      }
	  
	
 // Edit a auto_email_mis_customer
     public function edit_auto_email_mis_customer() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->role_master_model->get_auto_email_mis_customer_details($id);		
        $this->load->view('add_auto_email_mis_customer_tpl', $data);
    }
	
	     public function view_auto_email_mis_customer() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->role_master_model->get_auto_email_mis_customer_details($id);		
        $this->load->view('add_auto_email_mis_customer_tpl', $data);
    }

	public function checkAutoEmailMISCustomer() {
        $user_id = $this->session->userdata('admin_user_id');
        $customer_id = $this->input->post('customer_id');

        $mis_report_slug = $this->input->post('mis_report_slug');
        //$mis_report_name = $this->input->post('mis_report_name');
        $isExists = $this->role_master_model->checkAutoEmailMISCustomerSlug($mis_report_slug, $customer_id);
        echo $isExists;
        exit;
    }
	
	// Auto Email MIS Customer Wise Ends
	
	// Customer billing...
	
	 // List all Auto Email MIS configuration
 public function list_all_customer_billing_masters() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->get('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->role_master_model->get_total_customer_billing_master_count($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->role_master_model->get_customer_billing_master_list($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('role_master/list_all_customer_billing_masters/', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_all_customer_billing_masters_tpl', $params);
    }
	
	// Add a role 
	public function add_customer_billing_master() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->role_master_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_customer_billing_master_tpl', $data);
    }
	

	// Save a Customer billing 
	public function save_customer_billing_master() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->role_master_model->save_customer_billing_master($savedData);  exit;

      }
	  
	
 // Edit a Customer billing
     public function edit_customer_billing_master() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->role_master_model->get_customer_billing_master_details($id);		
        $this->load->view('add_customer_billing_master_tpl', $data);
    }

	// end Customer Billing...
	
	
  }?>

