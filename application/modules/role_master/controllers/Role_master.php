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
			$role_quantity		 = $this->input->post('role_quantity');			
 			if(count($this->input->post('functionalities'))>0 && count($role)>0){
				$result = $this->role_master_model->save_assigned_functionalities_to_role($functionality_array, $role, $role_quantity);	
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
			$user_id 		= $this->session->userdata('admin_user_id');
			## assigned plants array
 			$assigned_arr = explode(',',get_assigned_active_functionalities_list($id));
			
			//print_r($assigned_arr);exit;
			
 			$product_data 	= get_all_active_functionalities($user_id);
			 foreach($product_data as $res){?>
				<option value="<?php echo $res['id'];?>" <?php if(in_array($res['id'],$assigned_arr )){echo 'selected';}?>><?php echo $res['functionality_name_value'];?></option>
          <?php }
			return $result;
	 }
	 
	 
	
	
	  public function list_assigned_functionalities_to_role() {
			 $data					= array();
			 $parent_id				= $this->session->userdata('admin_user_id');		
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
	 
  }?>

