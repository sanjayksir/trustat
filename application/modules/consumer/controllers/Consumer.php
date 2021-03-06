<?php
 class Consumer extends MX_Controller {
     function __construct() {
         parent::__construct();
         $this->load->model('Consumer_model');
		 $this->load->helper('common_functions_helper');
     }
	  function checklogin(){
 		$user_id 	= $this->session->userdata('admin_user_id');
 		$user_name 	= $this->session->userdata('user_name');
 		if(empty($user_id) && $user_id!=1){
 			redirect(base_url().'login');	exit;
 		}
 	}
     function consumer_list() {
		 $data = array();
		 $this->checklogin();
        // $data['get_attr'] = $this->Product_model->getAttributeList();
 		 $this->load->view('order_list', $data);
     }

   

      function barcode_scanned() {
		 $data = array();
		 $this->checklogin();
        // $data['get_attr'] = $this->Product_model->getAttributeList();
 		 $this->load->view('order_list', $data);
     }
	 
	 
	     public function list_consumer_selection_criterias() {
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
        $total_records = $this->Consumer_model->get_total_consumer_selection_criterias_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->Consumer_model->get_list_consumer_selection_criterias_all($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('consumer/list_consumer_selection_criterias', $total_records);;
        }
			
		
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_consumer_selection_criterias_tpl', $params);
    }
	 
 
     public function add_consumer_selection_criteria() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->Consumer_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_consumer_selection_criteria_tpl', $data);
    }
	

	
	public function save_consumer_selection_criteria() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->Consumer_model->save_consumer_selection_criteria($savedData);  exit;

      }
	  
	  
	public function save_number_of_consumers_selected() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->Consumer_model->save_number_of_consumers_selected($savedData);  exit;

      }	  
	  
	public function number_of_consumers_selected() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();		
        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->Consumer_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
		$unique_system_selection_criteria_id = $this->uri->segment(3);		
		 $data['get_user_details'] = $this->Consumer_model->get_consumer_selection_criteria_details($unique_system_selection_criteria_id);$this->load->view('number_of_consumers_selected_tpl', $data);
    }  
	
 
     public function edit_consumer_selection_criteria() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
        $data['get_user_details'] = $this->Consumer_model->get_consumer_selection_criteria_details($id);

        $this->load->view('add_consumer_selection_criteria_tpl', $data);
    }
	
     public function view_consumer_selection_criteria() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
        $data['get_user_details'] = $this->Consumer_model->get_consumer_selection_criteria_details($id);

        $this->load->view('add_consumer_selection_criteria_tpl', $data);
    }	
	
	public function checkPromotionType() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $uid = $this->input->post('criteriaid');
        $promotion_type = $this->input->post('promotion_type');
        $isExists = $this->Consumer_model->checkPromotionType($promotion_type, $user_id, $uid);
        echo $isExists;
        exit;
    }
	
	
		  // Consumer Profile Attributes Work 
 public function list_consumer_profile_attributes() {
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
        $total_records = $this->Consumer_model->get_total_consumer_profile_attributes_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->Consumer_model->get_list_consumer_profile_attributes_all($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('consumer/list_consumer_profile_attributes/', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_consumer_profile_attributes_tpl', $params);
    }
	
	
	public function add_consumer_profile_attribute() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->Consumer_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_consumer_profile_attribute_tpl', $data);
    }
	

	
	public function save_consumer_profile_attribute() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->Consumer_model->save_consumer_profile_attributes($savedData);  exit;

      }
	  
	
 
     public function edit_consumer_profile_attribute() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->Consumer_model->get_consumer_profile_attribute_details($id);		
        $this->load->view('add_consumer_profile_attribute_tpl', $data);
    }
	
     public function view_consumer_profile_attribute() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
        $data['get_user_details'] = $this->Consumer_model->get_consumer_selection_criteria_details($id);

        $this->load->view('add_consumer_selection_criteria_tpl', $data);
    }	
	
	public function checkProfileAttribute() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $cpm_type_slug = $this->input->post('attribute_type_slug');
        $Profile_Attribute = $this->input->post('attribute_nameA');
        $isExists = $this->Consumer_model->checkProfileAttribute($Profile_Attribute, $user_id, $cpm_type_slug);
        echo $isExists;
        exit;
    }
	
	    function Del_Attribute() {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $id = base64_decode($id);
            $result = $this->Consumer_model->Del_Attribute($id);
           
            if ($result == 1) {
                $this->session->set_flashdata('success', 'Consumer Profile Attribute deleted successfully!.');
            } else {
                $this->session->set_flashdata('success', 'Consumer Profile Attribute not deleted!');
            }
            redirect(base_url() . 'consumer/list_consumer_profile_attributes');
        }
    }
	
    // Consumer Profile Attributes Work end
	
 // Consumer Profile Attribute Type Master Work Start list_consumer_profile_attribute_types
 public function list_consumer_profile_attribute_types() {
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
        $total_records = $this->Consumer_model->get_total_consumer_profile_attribute_types_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->Consumer_model->get_list_consumer_profile_attribute_types_all($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('consumer/list_consumer_profile_attribute_types', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_consumer_profile_attribute_types_tpl', $params);
    }
	
	
	public function add_consumer_profile_attribute_type() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->Consumer_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_consumer_profile_attribute_type_tpl', $data);
    }
	


	
	public function save_consumer_profile_attribute_types() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->Consumer_model->save_consumer_profile_attribute_types($savedData);  exit;
      }
	  
	
 
     public function edit_consumer_profile_attribute_type() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->Consumer_model->get_consumer_profile_attribute_type_details($id);		
        $this->load->view('add_consumer_profile_attribute_type_tpl', $data);
    }
	
     public function view_consumer_profile_attribute_type() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
        $data['get_user_details'] = $this->Consumer_model->get_consumer_selection_criteria_details($id);

        $this->load->view('add_consumer_selection_criteria_tpl', $data);
    }	
	
	public function checkProfileAttributeType() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $cpatmid = $this->input->post('cpatm_id');
        $Profile_AttributeType = $this->input->post('cpatm_name');
        $isExists = $this->Consumer_model->checkProfileAttributeType($Profile_AttributeType, $user_id, $cpatmid);
        echo $isExists;
        exit;
    }
	
	    function Del_AttributeType() {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $id = base64_decode($id);
            $result = $this->Consumer_model->Del_AttributeType($id);
           
            if ($result == 1) {
                $this->session->set_flashdata('success', 'Consumer Profile Attribute Type deleted successfully!.');
            } else {
                $this->session->set_flashdata('success', 'Consumer Profile Attribute Type not deleted!');
            }
            redirect(base_url() . 'consumer/list_consumer_profile_attribute_types');
        }
    }
	
    // Consumer Profile Attribute Type Master Work Start end
	
	// FAQ Master Start
	public function list_faqs_master() {
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
        $total_records = $this->Consumer_model->get_total_faqs_master_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->Consumer_model->get_list_faqs_master_all($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('consumer/list_faqs_master/', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_faqs_master_tpl', $params);
    }
	
  public function add_faqs_master() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->Consumer_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_faqs_master_tpl', $data);
    }
	

	
	public function save_faqs_master() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->Consumer_model->save_faqs_master($savedData);  exit;

      }
	  
	  
	   
     public function edit_faqs_master() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->Consumer_model->get_faqs_master_details($id);		
        $this->load->view('add_faqs_master_tpl', $data);
    }
	
     public function view_faqs_master() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
        $data['get_user_details'] = $this->Consumer_model->get_faqs_master_details($id);

        $this->load->view('add_faqs_master_tpl', $data);
    }	
	
	public function checkFAQs() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        //$cpm_type_slug = $this->input->post('attribute_type_slug');
        $faq_question = $this->input->post('faq_question');
        $isExists = $this->Consumer_model->checkProfileAttribute($faq_question);
        echo $isExists;
        exit;
    }
	
	    function Del_FAQs() {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $id = base64_decode($id);
            $result = $this->Consumer_model->Del_FAQs($id);
           
            if ($result == 1) {
                $this->session->set_flashdata('success', 'Record deleted successfully!.');
            } else {
                $this->session->set_flashdata('success', 'Record not deleted!');
            }
            redirect(base_url() . 'consumer/list_faqs_master');
        }
    }
	
	// FAQ Master Start
	
	
// CMS for Product Returned From Customer Start
 public function list_consumer_return_cms_items() {
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
        $total_records = $this->Consumer_model->get_total_product_returned_from_customer_cms_items_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->Consumer_model->get_list_product_returned_from_customer_cms_items_all($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('consumer/list_consumer_return_cms_items/', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_consumer_return_cms_items_tpl', $params);
    }
	
	
	public function add_consumer_return_cms_item() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->Consumer_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_consumer_return_cms_item_tpl', $data);
    }
	

	
	public function save_consumer_return_cms_item() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->Consumer_model->save_consumer_return_cms_item($savedData);  exit;

      }
	  
	
 
     public function edit_consumer_return_cms_items() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();        
        $data['get_user_details'] = $this->Consumer_model->get_product_returned_from_customer_cms_item_details($id);		
        $this->load->view('add_consumer_return_cms_item_tpl', $data);
    }
	
     public function view_consumer_return_cms_item() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
        $data['get_user_details'] = $this->Consumer_model->get_consumer_selection_criteria_details($id);

        $this->load->view('add_consumer_selection_criteria_tpl', $data);
    }	
	
	public function checkConsumerReturnCMSItem() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $return_cms_type_name_slug = $this->input->post('return_cms_type_name_slug');
       // $Profile_Attribute = $this->input->post('attribute_nameA');
        $isExists = $this->Consumer_model->checkConsumerReturnCMSItem($return_cms_type_name_slug);
        echo $isExists;
        exit;
    }
	
	    function Del_ConsumerReturnCMSItem() {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $id = base64_decode($id);
            $result = $this->Consumer_model->Del_ConsumerReturnCMSItem($id);
           
            if ($result == 1) {
                $this->session->set_flashdata('success', 'Product Returned From Consumer CMS Item deleted successfully!.');
            } else {
                $this->session->set_flashdata('success', 'Product Returned From Consumer CMS Item not deleted!');
            }
            redirect(base_url() . 'consumer/list_consumer_return_cms_items');
        }
    }
	
    // Product Returned From Consumer CMS Items Work end
	
 
}

