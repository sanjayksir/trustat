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
            $params["links"] = Utils::pagination('user_master/list_user', $total_records);;
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
        $username = $this->input->post('promotion_type');
        $isExists = $this->Consumer_model->checkPromotionType($username, $uid);
        echo $isExists;
        exit;
    }
	
 
}

