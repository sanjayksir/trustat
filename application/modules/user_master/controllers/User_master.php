<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_master extends MX_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model(['myspidey_user_master_model']);

        $this->load->model('myspidey_user_group_permissions_model');

        $this->load->helper(array('common_functions_helper', 'image_upload_helper'));
        //echo '<pre>';print_r($this->session->userdata());exit;
        $this->load->library('pagination');
    }

    public function list_user() {
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
        $total_records = $this->myspidey_user_master_model->get_total_user_list_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->myspidey_user_master_model->get_user_list_all($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('user_master/list_user', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_user_tpl', $params);
    }

    public function list_plant_controllers() {

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
        $total_records = $this->myspidey_user_master_model->get_total_plant_user_list_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->myspidey_user_master_model->get_plant_user_list_all($limit_per_page, $start_index, $srch_string);
            //$params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index,$srch_string);
            $params["links"] = Utils::pagination('user_master/list_plant_controllers', $total_records);
        }
        ##--------------- pagination End ----------------##
        $this->load->view('list_plant_con_tpl', $params);
    }
	
	
    public function list_tracek_users() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
		$customer_id = $this->uri->segment(3);
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
        $total_records = $this->myspidey_user_master_model->get_total_tracek_users_list_all($srch_string);

       // if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->myspidey_user_master_model->get_tracek_user_list_all($limit_per_page, $start_index, $srch_string);
            //$params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index,$srch_string);
            $params["links"] = Utils::pagination('user_master/list_tracek_users/' . $customer_id, $total_records, null, 4);
       // }
        ##--------------- pagination End ----------------##
        $this->load->view('list_tracek_users_tpl', $params);
    }
	
	
		public function list_tracek_usersold() {
        $this->checklogin();
       $customer_id = $this->uri->segment(3);
	
		//echo $id;
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
        $total_records = $this->myspidey_user_master_model->get_total_tracek_users_list_all($customer_id, $srch_string);
        $params["userListing"] = $this->myspidey_user_master_model->get_tracek_user_list_all($customer_id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('user_master/list_tracek_users/' . $customer_id, $total_records);
		//echo "test";
        $this->load->view('list_plant_con_tpl', $params);
    }
	
	
	public function list_view_consumer_passbook() {
        $this->checklogin();
       $id = $this->uri->segment(3);
	
		//echo $id;
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
        $total_records = $this->myspidey_user_master_model->count_total_list_view_consumer_passbook($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->myspidey_user_master_model->list_view_consumer_passbook($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_view_consumer_passbook/' . $id, $total_records);
		//echo "test";
        $this->load->view('list_view_consumer_passbook_tpl', $params);
    }
	
	

    public function list_customer_app_users() {

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
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->post('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->myspidey_user_master_model->get_total_plant_user_list_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->myspidey_user_master_model->get_plant_user_list_all($limit_per_page, $start_index, $srch_string);
            //$params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index,$srch_string);

            $config['base_url'] = base_url() . 'user_master/list_customer_app_users';
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
        $this->load->view('list_customer_app_users_tpl', $params);
    }

    public function list_plevel_user() {
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
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->post('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->myspidey_user_master_model->get_total_plevel_user_list_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->myspidey_user_master_model->get_plevel_user_list_all($limit_per_page, $start_index, $srch_string);
            //$params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index,$srch_string);

            $config['base_url'] = base_url() . 'user_master/list_plevel_user';
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

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_plevel_user_tpl', $params);
    }

    public function add_user() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->myspidey_user_master_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $this->load->view('add_member', $data);
    }

    public function add_plant_controller() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();

        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->myspidey_user_master_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();

        $this->load->view('add_member', $data);
    }

    public function add_customer_app_user() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $plants= $this->myspidey_user_master_model->getPlants();        
        $data['plants'] = array_column($plants, 'plant_name','plant_id');
        // $id 					= $this->uri->segment(3);
        // $data['ownership'] 	= $this->myspidey_user_master_model->get_ownership($id);
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();

        $this->load->view('add_customer_app_user', $data);
    }

    public function edit_user() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
        $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);

        $this->load->view('add_member', $data);
    }

    public function edit_plevel_user() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        $plants= $this->myspidey_user_master_model->getPlants();        
        $data['plants'] = array_column($plants, 'plant_name','plant_id');

        $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);

        $this->load->view('add_customer_app_user', $data);
    }

    public function edit_plant_controller() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {
            redirect('login');
            exit;
        }
        $data = array();
        $plants= $this->myspidey_user_master_model->getPlants();        
        $data['plants'] = array_column($plants, 'plant_name','plant_id');
        $id = $this->uri->segment(3);
        $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);
        $this->load->view('add_member', $data);
    }

    public function save_user() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        parse_str($_POST['newdata'], $searcharray);
        
        ## helper used for image upload

        $res = upload_image_n_thumb($_FILES['file'], 'uploads/rwaprofilesettings', 'thumb');

        $searcharray['profile_photo'] = '';

        $result = json_decode($res);

        if (!empty($result[0]->success)) {
            $searcharray['profile_photo'] = $result[0]->success;
        }
        echo $this->myspidey_user_master_model->save_user($searcharray);
        exit;
    }
	
	     public function add_location() {
 		 $data					= array();
   		 $this->load->view('add_location', $data); 
      }
 
 
	 public function edit_location() {
 		 $data					= array();
		 $location_id 					= $this->uri->segment(3);//$this->session->userdata('admin_user_id');
 		 $data['get_user_details'] 	= $this->myspidey_user_master_model->get_location_details($location_id);
    	 $this->load->view('add_location', $data); 
      }
	  
		public function save_location11() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        parse_str($_POST['newdata'], $searcharray);
        
        ## helper used for image upload

        $res = upload_image_n_thumb($_FILES['file'], 'uploads/location_images', 'thumb');

        $searcharray['location_image'] = '';

        $result = json_decode($res);

        if (!empty($result[0]->success)) {
            $searcharray['location_image'] = $result[0]->success;
        }
        echo $this->myspidey_user_master_model->save_location11($searcharray);
        exit;
    }  
	

    public function update_profile() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        parse_str($_POST['newdata'], $searcharray);
        //echo '<pre>'; print_r($searcharray);exit;
        ## helper used for image upload

        $res = upload_image_n_thumb($_FILES['file'], 'uploads/rwaprofilesettings', 'thumb');

        $searcharray['profile_photo'] = '';

        $result = json_decode($res);

        if (!empty($result[0]->success)) {
            $searcharray['profile_photo'] = $result[0]->success;
        }

        echo $this->myspidey_user_master_model->update_profile_data($searcharray);
        exit;
    }

    public function checkUnameEmail() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $uid = $this->input->post('userid');

        $email = $this->input->post('user_email');

        $isExists = $this->myspidey_user_master_model->checkEmail($email, $uid);

        echo $isExists;
        exit;
    }
	
	public function checkUserMobileNo() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $uid = $this->input->post('userid');

        $mobile = $this->input->post('user_mobile');

        $isExists = $this->myspidey_user_master_model->checkMobileNo($mobile, $uid);

        echo $isExists;
        exit;
    }

    public function checkUserName() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        $uid = $this->input->post('userid');
        $username = $this->input->post('user_name');
        $isExists = $this->myspidey_user_master_model->checkUserName($username, $uid);
        echo $isExists;
        exit;
    }

    public function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('value');
        if (strtolower($status) == 'inactive') {
            $status = '1'; # Now it will be active
        } else {
            $status = '0'; # Now it will be inactive
        }
        //$user_id 	= $this->session->userdata('admin_user_id');		
        echo $status = $this->myspidey_user_master_model->change_status($id, $status);
        exit;
    }

    ## get city list

    function get_city_list() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $state_id = $this->input->post('state_id');
        $city_list = $this->myspidey_user_master_model->get_city_listing($state_id);
        $option = '';
        foreach ($city_list as $val) {
            $option .= '<option value="' . $val['id'] . '">' . $val['ci_name'] . '</option>       ';
        }
        echo $option;
        exit;
    }

    public function view_user() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);
        //echo '***'.$data['get_user_details'][0]['city'];
        $data['show_city_name'] = $this->myspidey_user_master_model->fetch_city_name($data['get_user_details'][0]['city']);
        $this->load->view('view_member', $data);
    }
	

    public function view_plevel_user() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }


        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);
        //echo '***'.$data['get_user_details'][0]['city'];
        $data['show_city_name'] = $this->myspidey_user_master_model->fetch_city_name($data['get_user_details'][0]['city']);
        $this->load->view('view_plevel_profile_tpl', $data);
    }

    ## User Profile

    public function profile_user() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->session->userdata('admin_user_id');
        $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);
        $this->load->view('profile_user_tpl', $data);
    }

    public function edit_profile_user() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->session->userdata('admin_user_id');
        $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);
        $this->load->view('edit_profile_user_tpl', $data);
    }

    public function verify() {
        $username = base64_decode($this->uri->segment(3));
        $password = base64_decode($this->uri->segment(4));
        $returnData = $this->myspidey_user_master_model->link_verification($username, $password);
        if ($returnData == 1) {
            $this->session->set_flashdata('success', 'Email verification of your account is successful!  Please Wait for admin approval!.');
        } else {
            $this->session->set_flashdata('success', 'Registration not Approved!');
        }
        $this->load->view('verification_tpl', $data);
    }

	    ### delete user

    function send_otp_delete_customer() {
        $customer_id = $this->uri->segment(3);
        if (!empty($customer_id)) {
            $customer_id = base64_decode($customer_id);
            //$result = $this->myspidey_user_master_model->delete_user($id);
            //$childIds = getAllChildFromParentUser($id);
            //print_r($childIds);exit;
            //if ($childIds != '') {
				
				$otp_code = Utils::randomNumber(5);
				//$otp_code = 11456;
                $result = $this->myspidey_user_master_model->send_email_with_otp_delete_customer($customer_id, $otp_code);
           // }
            if($result==true) {				
				$this->myspidey_user_master_model->update_otp_delete_customer($customer_id, $otp_code);				
                $this->session->set_flashdata('success', 'OTP sent successfully! Please check your Email and complete the process to delete the user.');
            } else {				
                $this->session->set_flashdata('success', 'OTP not sent! Please try after some time.');
            }
            redirect(base_url() . 'user_master/list_user/');
        }
    }
	
    ### delete user

    function del() {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $id = base64_decode($id);
            $result = $this->myspidey_user_master_model->delete_user($id);
            $childIds = getAllChildFromParentUser($id);
            //print_r($childIds);exit;
            if ($childIds != '') {
                $result = $this->myspidey_user_master_model->delete_child_users($childIds);
            }
            if ($result == 1) {
                $this->session->set_flashdata('success', 'User deleted successfully!.');
            } else {
                $this->session->set_flashdata('success', 'User not deleted!');
            }
            redirect(base_url() . 'user_master/list_user/');
        }
    }
	
	//sss8888
	    function del_confirm_otp() {
        $id = $this->uri->segment(3);
		//$otp = $this->input->post('otp');
		 $confirm_otp = $this->input->post('confirm_otp');
		 
        if (!empty($id)) {
            //$id = base64_decode($id);
			//parse_str($_POST['newdata'], $searcharray);
            $result = $this->myspidey_user_master_model->delete_user_confirm_otp($id, $confirm_otp);
            $childIds = getAllChildFromParentUser($id);
            //print_r($childIds);exit;
            
            if ($result == 1) {
                $this->session->set_flashdata('success', 'User deleted successfully!.');
				
				if ($childIds != '') {
                $result = $this->myspidey_user_master_model->delete_child_users($childIds);
            }
			
            } else {
                $this->session->set_flashdata('success', 'User not deleted!');
            }
            redirect(base_url() . 'user_master/list_user/');
        }
    }

    function del_plevel_user() {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $id = base64_decode($id);
            $result = $this->myspidey_user_master_model->delete_user($id);
            $childIds = getAllChildFromParentUser($id);
            //print_r($childIds);exit;
            if ($childIds != '') {
                $result = $this->myspidey_user_master_model->delete_child_users($childIds);
            }
            if ($result == 1) {
                $this->session->set_flashdata('success', 'User deleted successfully!.');
            } else {
                $this->session->set_flashdata('success', 'User not deleted!');
            }
            redirect(base_url() . 'user_master/list_plevel_user/');
        }
    }

    function delplant() {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $id = base64_decode($id);
            $result = $this->myspidey_user_master_model->delete_user($id);
            //$childIds = getAllChildFromParentUser($id);
            //print_r($childIds);exit;

            if ($result == 1) {
                $this->session->set_flashdata('success', 'User deleted successfully!.');
            } else {
                $this->session->set_flashdata('success', 'User deleted!');
            }
            redirect(base_url() . 'user_master/list_user/');
        }
    }
	
	
	
	public function list_common_points_loyalty() {
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
        $total_records = $this->myspidey_user_master_model->get_total_common_points_loyalty_list_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->myspidey_user_master_model->get_common_points_loyalty_list_all($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('user_master/list_common_points_loyalty', $total_records);;
        }
        ##--------------- pagination End ----------------##

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_common_points_loyalty_tpl', $params);
    }
	/*
	public function common_point_master($id) {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        $data = array();
        $id = $this->session->userdata('admin_user_id');
        $data['get_user_details'] = $this->myspidey_user_master_model->get_common_point_master_details($id);
        $this->load->view('edit_common_point_master_tpl', $data);
    }
	*/
	public function edit_common_point() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
       // $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);
		$data['get_user_details'] = $this->myspidey_user_master_model->get_common_point_master_details($id);

        $this->load->view('edit_common_point_master_tpl', $data);
    }
	
	public function update_common_point_master() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        parse_str($_POST['newdata'], $searcharray);
       
		//$id = $this->uri->segment(3);

        echo $this->myspidey_user_master_model->update_common_point_master_data($searcharray);
        exit;
    }
	
	
	public function update_common_point_master_otp() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        parse_str($_POST['newdata'], $searcharray);
       
		//$id = $this->uri->segment(3);

        echo $this->myspidey_user_master_model->update_common_point_master_data_otp($searcharray);
        exit;
    }
	
	public function list_message_notification_master() {
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
        $total_records = $this->myspidey_user_master_model->get_total_message_notification_list_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params['userListing'] = $this->myspidey_user_master_model->get_message_notification_list_all($limit_per_page, $start_index, $srch_string);
            
            // build paging links
            $params["links"] = Utils::pagination('user_master/list_message_notification_master', $total_records);;
        }
        ##--------------- pagination End ----------------##
		
		$result = $this->db->select('loyalty_points')->from('loylties')->where('transaction_type_slug', 'user-registration')->limit(1)->get()->row();
			$user_registration_points = $result->loyalty_points;
			$params["user_registration_points"] = $user_registration_points;

        $user_id = $this->session->userdata('admin_user_id');
        $this->load->view('list_message_notification_master_tpl', $params);
    }
	
	
		public function edit_message_notification() {

        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }

        $data = array();
        $id = $this->uri->segment(3); //$this->session->userdata('admin_user_id');
        //$data['ownership'] 	= $this->myspidey_user_group_permissions_model->get_ownership_user();
        
       // $data['get_user_details'] = $this->myspidey_user_master_model->get_user_details($id);
		$data['get_user_details'] = $this->myspidey_user_master_model->get_message_notification_details($id);
		
		$result = $this->db->select('loyalty_points')->from('loylties')->where('transaction_type_slug', 'user-registration')->limit(1)->get()->row();
			$user_registration_points = $result->loyalty_points;
			$data["user_registration_points"] = $user_registration_points;
			

        $this->load->view('edit_message_notification_tpl', $data);
    }
	
  public function update_message_notification_details() {
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        if (empty($user_id) || empty($user_name)) {

            redirect('login');
            exit;
        }
        parse_str($_POST['newdata'], $searcharray);
       
		//$id = $this->uri->segment(3);

        echo $this->myspidey_user_master_model->update_message_notification_details_data($searcharray);
        exit;
    }

	function delete_user_accept_otp(){
		 $id = $this->uri->segment(3);
		 if($id!=''){
 			 $data['customer_id']=$id;
			$this->load->view('delete_user_accept_otp_master_tpl',$data);
		 }
		// $this->load->view('delete_accept_otp');
	 }
	 

}
?>

