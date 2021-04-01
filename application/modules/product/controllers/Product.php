<?php
 class Product extends MX_Controller {
     function __construct() {
         parent::__construct();
         $this->load->model('Product_model');
		 $this->load->helper('common_functions_helper');
		 $this->load->library('pagination');
		 //$this->load->model('api/Productmodel');
     }

     function set_attributes() {
		 $this->checklogin();

		 if($this->input->post('hidden_field')=='1'){
		 	//echo '<pre>';print_r($this->input->post());exit;
			 $this->Product_model->saveAttributeList($this->input->post());
		 }
         $data['get_attr'] = $this->Product_model->getAttributeList();
 		$this->load->view('attribute_list', $data);
     }

    function checklogin(){
 		$user_id 	= $this->session->userdata('admin_user_id');
 		$user_name 	= $this->session->userdata('user_name');
 		if(empty($user_id) && $user_id!=1){
 			redirect(base_url().'login');	exit;
 		}
 	}

     function update_attributes($id) {
		 $this->checklogin();
	 	$data['listData']=$this->Product_model->getOptionList($id);
	 	if($this->input->post('submit')){
			 $this->Product_model->update_attribute_val($this->input->post());
		}
         // check if the unitofarea exists before trying to edit it
       //  $data['unitofarea'] = $this->Product_model->getOptionList($id);
         $this->load->view('attribute_add', $data);
     }







 	function add_product(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();

		$data['product_attr'] = $this->Product_model->get_all_attrs();
		$this->load->view('add_product_tpl', $data);

	}


	function update_product(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();

		//$data['product_attr'] = $this->Product_model->get_all_attrs();
		$data['product_data'] = $this->Product_model->fetch_product_detail($this->uri->segment(3));
		$this->load->view('edit_product_tpl', $data);

	}

	function add_product_attributes(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();
		//$data['product_attr'] = $this->Product_model->get_all_attrs();
		$data['product_data'] = $this->Product_model->fetch_product_detail($this->uri->segment(3));
		$this->load->view('add_product_attributes_tpl', $data);
		}
	
	function manage_packaging(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();
		//$data['product_attr'] = $this->Product_model->get_all_attrs();
		$data['product_data'] = $this->Product_model->fetch_product_pack_level_detail($this->uri->segment(3));
		$this->load->view('manage_packaging_tpl', $data);
		}
		
		

 function getSubCategory_bkp(){
 $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	$id			= $this->input->post('id');
	//print_r($this->input->post());
	$result = '<option value="0">-Select Industry (Level-1)-</option>';
	if(!empty($id)){
 	$this->db->select('product_id, name');
 	$this->db->from('attribute_name');
 	$this->db->where('parent',$id);
  	$query = $this->db->get();  //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();

			foreach($res as $val){
				$result .= '<option value="'.$val['product_id'].'">'.$val['name'].'</option>';
			}

 		}
	}
	$result .= '</option>';
  	echo $result;exit;
 }


  function getSubCategory(){
 $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	$id			= $this->input->post('id');
	$level			= $this->input->post('lev');
	//print_r($this->input->post());
	$result = '<option value="0">- Select Industry (Level-'.($level-1).') -</option>';
	if(!empty($id)){
 	$this->db->select('category_Id, categoryName');
 	$this->db->from('categories');
 	$this->db->where('parent',$id);
  	$query = $this->db->get();  //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();

			foreach($res as $val){
				$result .= '<option value="'.$val['category_Id'].'">'.$val['categoryName'].'</option>';
			}


 		}$result .= '<option value="other">Other</option>';
	}
	$result .= '</option>';
  	echo $result;exit;
 }


  function checkProductExists($id=''){
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	   $name = $this->input->post('product_name');


 	  echo $this->Product_model->IsExistsProduct($name,$id='');exit;
  }
  
    function checkCustomerERPProductID($id=''){
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	   $name = $this->input->post('customer_erp_product_id');


 	  echo $this->Product_model->IsCustomerERPProductID($name,$id='');exit;
  }
  
  
  function checkDateMoreThanToday(){
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		
	   $referral_program_auto_off_date = $this->input->post('referral_program_auto_off_date');

 	 echo $this->Product_model->isDateMoreThanToday($referral_program_auto_off_date);exit; 
  }
  
    function checkDateMoreThanTodayEdit(){
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		
	   $referral_program_auto_off_date = $this->input->post('referral_program_auto_off_date');

 	 echo $this->Product_model->isDateMoreThanTodayEdit($referral_program_auto_off_date);exit; 
  }

  function save_product($id='') {
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
  		$res = $this->Product_model->save_product($id);
		if($res=='1'){
			echo '1';
		}else{
			echo '0';
		}
		exit;
    }

	
	  function save_product_attributes($id='') {
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
  		$res = $this->Product_model->save_product_attributes($id);
		if($res=='1'){
			echo '1';
		}else{
			echo '0';
		}
		exit;
    }
	
	function save_product_pack_level() {
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
  		$res = $this->Product_model->save_product_pack_level();
		if($res=='1'){
			echo '1';
		}else{
			echo '0';
		}
		exit;
    }
	

 function genate_sku(){
		//$name = $this->input->post('name');
		$string = $this->input->post('name');
		function initials($str) {
				$ret = '';
				foreach (explode(' ', $str) as $word)
					$ret .= strtoupper($word[0]);
				return $ret;
			}
		//echo initials($string);

		$name = initials($string);
		$pin = mt_rand(100, 999);
 		echo $res =  slugify2($name).$pin;
		exit;
   }

   public function list_product() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
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
        $total_records = $this->Product_model->total_product_listing($srch_string);
        $params["product_list"] = $this->Product_model->product_listing($limit_per_page, $start_index, $srch_string);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/list_product', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/list_product/' . $customer_id, $total_records, null, 4);
			}
		
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			
        $this->load->view('product_list', $params);
    }
	
	
   public function list_all_products() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
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
		
		/*
		$params["TotalNumberofScannedCodesLevel0"] = $this->db->where('pack_level', 0)
		->from("scanned_products")
		->join('printed_barcode_qrcode', 'printed_barcode_qrcode.barcode_qr_code_no = scanned_products.bar_code', 'left')
		->count_all_results();  
		$params["TotalNumberofScannedCodesLevel1"] = $this->db->where('pack_level', 1)
		->from("scanned_products")
		->join('printed_barcode_qrcode', 'printed_barcode_qrcode.barcode_qr_code_no = scanned_products.bar_code', 'left')
		->count_all_results(); 
		*/
		
        $total_records = $this->Product_model->total_product_listing_all($srch_string);
        $params["product_list"] = $this->Product_model->product_listing_all($limit_per_page, $start_index, $srch_string);
		$params["list_all_customers_products"] = $this->Product_model->list_all_customers_products();
		if($user_id>1){
		$params["links"] = Utils::pagination('product/list_all_products', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/list_all_products/' . $customer_id, $total_records, null, 4);
			}
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('list_all_products_tpl', $params);
    }	
// list assigned products to Plant controller

   public function referral_mis() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
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
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');
		
		if($user_id>1){
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}else{
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}
		
		 
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Product_model->total_referral_mis_listing($srch_string, $from_date_data, $to_date_data);
        $params["product_list"] = $this->Product_model->referral_mis_listing($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/referral_mis', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/referral_mis/' . $customer_id, $total_records, null, 4);
			}
		
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('referral_mis_tpl', $params);
    }
	
	   public function referral_mis_download() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
		
		$mnv58_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 58)->get()->row();
		$mnvtext58 = $mnv58_result->message_notification_value;
		
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $mnvtext58;
        }else{
            $limit_per_page = $mnvtext58;
        }
		
        ##--------------- pagination start ----------------##
        // init params
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $mnvtext58;
        }else{
            $limit_per_page = $mnvtext58;
        }
        $this->config->set_item('pageLimit2', $limit_per_page);
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');
		
		if($user_id>1){
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}else{
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}
        $srch_string = $this->input->get('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Product_model->total_referral_mis_listing($srch_string, $from_date_data, $to_date_data);
        $params["product_list"] = $this->Product_model->referral_mis_listing($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/referral_mis', $total_records);
		$params["links2"] = Utils::pagination2('product/referral_mis', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/referral_mis/' . $customer_id, $total_records, null, 4);
			$params["links2"] = Utils::pagination2('product/referral_mis/' . $customer_id, $total_records, null, 4);
			}
		$params["total_records2"] = $total_records; 
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('referral_mis_download_tpl', $params);
    }
	
	// In-Store Redemption MIS Report
	
	
	   public function tracek_loyalty_redemption() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
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
        $total_records = $this->Product_model->total_tracek_loyalty_redemption_count($srch_string);
        $params["product_list"] = $this->Product_model->tracek_loyalty_redemption_listing($limit_per_page, $start_index, $srch_string);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/tracek_loyalty_redemption', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/tracek_loyalty_redemption/' . $customer_id, $total_records, null, 4);
			}
		
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('tracek_loyalty_redemption_tpl', $params);
    }
	
	// 
	
   public function in_store_redemption_mis() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
        ##--------------- pagination start ----------------##
        // init params
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');

		
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
        $total_records = $this->Product_model->total_in_store_redemption_mis_listing($srch_string, $from_date_data, $to_date_data);
        $params["product_list"] = $this->Product_model->in_store_redemption_mis_listing($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/in_store_redemption_mis', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/in_store_redemption_mis/' . $customer_id, $total_records, null, 4);
			}
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('in_store_redemption_mis_tpl', $params);
    }
	
	
	   public function in_store_redemption_mis_download() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
        ##--------------- pagination start ----------------##
        // init params
		
		$mnv58_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 58)->get()->row();
		$mnvtext58 = $mnv58_result->message_notification_value;
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');

		
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $mnvtext58;
        }else{
            $limit_per_page = $mnvtext58;
        }
        $this->config->set_item('pageLimit2', $limit_per_page);
		
		if($user_id>1){
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}else{
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}
		
		 
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Product_model->total_in_store_redemption_mis_listing($srch_string, $from_date_data, $to_date_data);
        $params["product_list"] = $this->Product_model->in_store_redemption_mis_listing($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/in_store_redemption_mis', $total_records);
		$params["links2"] = Utils::pagination2('product/in_store_redemption_mis', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/in_store_redemption_mis/' . $customer_id, $total_records, null, 4);
			$params["links2"] = Utils::pagination2('product/in_store_redemption_mis/' . $customer_id, $total_records, null, 4);
			}
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
		$params["total_records2"] = $total_records;	
        $this->load->view('in_store_redemption_mis_download_tpl', $params);
    }
	
	   public function mis_redemption_microsite() {
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
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');

		
		if($user_id>1){
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}else{
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}		
		 
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Product_model->total_mis_redemption_microsite_listing($srch_string, $from_date_data, $to_date_data);
        $params["product_list"] = $this->Product_model->list_mis_redemption_microsite_listing($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/mis_redemption_microsite', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/mis_redemption_microsite/' . $customer_id, $total_records, null, 4);
			}
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('mis_redemption_microsite_tpl', $params);
    }

	   public function mis_redemption_microsite_download() {
        $this->checklogin();
       
        ##--------------- pagination start ----------------##
        // init params
		
		$mnv58_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 58)->get()->row();
		$mnvtext58 = $mnv58_result->message_notification_value;
		
		
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $mnvtext58;
        }else{
            $limit_per_page = $mnvtext58;
        }
        $this->config->set_item('pageLimit2', $limit_per_page);
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');

		
		if($user_id>1){
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}else{
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}		
		 
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Product_model->total_mis_redemption_microsite_listing($srch_string, $from_date_data, $to_date_data);
        $params["product_list"] = $this->Product_model->list_mis_redemption_microsite_listing($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		if($user_id>1){
			$params["links"] = Utils::pagination('product/mis_redemption_microsite_download', $total_records);
		$params["links2"] = Utils::pagination2('product/mis_redemption_microsite_download', $total_records);
			}else{
				$params["links"] = Utils::pagination('product/mis_redemption_microsite_download/' . $customer_id, $total_records, null, 4);
			$params["links2"] = Utils::pagination2('product/mis_redemption_microsite_download/' . $customer_id, $total_records, null, 4);
			}
		$params["total_records2"] = $total_records;	
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('mis_redemption_microsite_download_tpl', $params);
    }
	
	
function list_assigned_products() {
		 $this->checklogin();
		 if(!empty($this->input->post('del_submit'))){
		 	if($this->db->query("delete from products where id='".$this->input->post('del_submit')."'")){
				$this->session->set_flashdata('success', 'Product Deleted Successfully!');
			}
		 }
		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_product_listing($srch_string);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->assigned_product_listing($limit_per_page, $start_index,$srch_string);

            $config['base_url'] = base_url() . 'product/list_assigned_products';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('list_assigned_products', $params);
     }



	 function getChildsDD(){
	 	$id 	= $this->input->post('id');
		$parent =  explode(',',$this->input->post('child'));
	 	if($id!=''){
			$data = json_decode(getAllProductName($id),true);//print_r($data);exit;
			$options = "";
			$dd =  '<select class="form-control" name="product_attr[]" size="20" style="height: 100%;" multiple="multiple" required>';
			foreach($data as $rec){
				$selected = '';
				if(in_array($rec['product_id'],$parent)){
					$selected = 'selected="selected"';
				}
				$dd .= '<option '.$selected.'value="'.$rec['product_id'].'">'.$rec['name'].'</option>';
			}
 			$dd .=  '</select>';
			echo $dd;exit;
	 	}
	 }

	 function delete_attribute($id){//echo '**'.$id;exit;
	 	$data = $this->Product_model->delete_attr($id);
	 }

	 function add_description(){
		$this->load->view('product_media_add');
	}


	 function media_uploader(){
 		 //echo '<pre>';print_r($res);exit;
		//echo '<pre>';print_r($_FILES);exit;
		if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$res = $this->upload_File('upload_file', array('jpg','JPEG','png'), 'uploads/product_media' ,'500','500','2000');
			if($res){
				echo '<pre>';print_r($res);exit;
			}else{
				echo 'general_system_error';
			}
			/*$vpb_file_name = strip_tags($_FILES['upload_file']['name']); //File Name
			$vpb_file_id = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file name
			$vpb_file_size = $_FILES['upload_file']['size']; // File Size
			$vpb_uploaded_files_location = 'uploaded_files/'; //This is the directory where uploaded files are saved on your server
			$vpb_final_location = $vpb_uploaded_files_location . $vpb_file_name; //Directory to save file plus the file to be saved

			//Without Validation and does not save filenames in the database
			if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location)){
				//Display the file id
				echo $vpb_file_id;
			}else{
				//Display general system error
				echo 'general_system_error';
			}
 	 	*/
		}
	}

 	//=====================================================================//
	## file rename
 	function ImageRename($fileFldName){
		if(!empty($fileFldName)){
			$RandomNum   		= time();
			$ImageNameImg      	= str_replace(' ','-',strtolower($_FILES[$fileFldName]['name']));
			$ImageExt 			= pathinfo($ImageNameImg, PATHINFO_EXTENSION);
			$ImageName      	= str_replace(' ','-',strtolower(basename($_FILES[$fileFldName]['name'],".".$ImageExt)));
 			$ImageName      	= str_replace('.', "", $ImageName);
			$ImageName      	= preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
			$NewImageName 		= $ImageName.'-'.$RandomNum.'.'.$ImageExt;
			return $NewImageName;
		}
 	}

	function get_Img_dimention($file_tmp_name){
 		$img		= getimagesize($file_tmp_name);
		//$minimum 	= array('width' => '200', 'height' => '180');
		$width		= $img[0];
		$height 	= $img[1];
		$size 		= array('width'=>$width, 'height'=>$height);
		return json_encode($size);
	}

	function imageResize($file,$param){
		$config=array();
 		switch($param){
			case'400x400':
			  $w=400;
			  //$h=169;
			  $file_path='./uploads/product_media/thumb/'.$file['file_name'];
			  break;
			case'222x190':
			  $w=222;
			  //$h=190;
			  $file_path='./uploads/product_media/thumb/'.$file['file_name'];
			 break;
		 }
		 $config['image_library'] 	= 'gd2';
		 $config['source_image'] 	= $file['full_path'];
		 $config['new_image'] 		= $file_path;
		 $config['maintain_ratio'] 	= true;
 		 $config['width'] 			= $w;
		 //$config['height'] = $h;

		 // Load the Library
		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config);

		 // resize image
		 $this->image_lib->resize();

		 // handle if there is any problem
		 if ( ! $this->image_lib->resize()){
		  echo $this->image_lib->display_errors();
		 }
	}

 	//=============================== Main function of upload file ==================================//
	#file_input_type_name: Name of the file type
	#file_type_arr: must be array like: array('.jpg','.png');
	#Path: must be without leading and traing slashes. Like: uploads/image;
	#max_size: max size to upload

 	function upload_File($file_input_type_name,$file_type_arr, $path ,$img_width,$img_height,$max_size){
 		//echo '<pre>';print_r($_FILES);exit;
   		if(empty($file_type_arr)){## File Type chcek
			$file_type_arr = "JPEG,JPG,image/JPEG,image/JPG,IMAGE/JPEG,image/jpeg,jpg,PNG,png,image/png,image/PNG,GIF,jpeg,gif";
		}else{
			$file_type_str = implode("|", $file_type_arr);
		}
		$uploads = './'.$path.'/';## File Path chcek
		if(empty($max_size)){## file Size
			$max_size=1024;
		}
		if(empty($img_width)){## file width
			$img_width=1000;
		}
		if(empty($img_height)){## file height
			$img_height=600;
		}

 		$data 					  	= array();
 		$config_img['upload_path'] 	= $uploads;
        $config_img['allowed_types']= $file_type_arr;//'JPEG|JPG|image/JPEG|image/JPG|IMAGE/JPEG|image/jpeg|jpg|PNG|png|image/png |image/PNG|GIF|jpeg|gif';
        $config_img['max_size'] 	= $max_size*'10';
        $config['max_width'] 		= $img_width;
        $config['max_height'] 		= $img_height;
		$file_size	 				= $_FILES["size"] / 1024;
		//$type = getimagesize($files['spideyImage']['tmp_name']);
		//print_r($type );exit;
  		 if( isset( $_FILES[$file_input_type_name]['name'] ) && ( ! empty( $_FILES[$file_input_type_name]['name'] ) ) ) {//echo 'kam';exit;
			#check img Size
			$img0		= $this->ImageRename($file_input_type_name);
			$tmp_name 	= $_FILES[$file_input_type_name]['tmp_name'];
			//$size_arr0 	= json_decode($this->get_Img_dimention($tmp_name));
			 //echo '&&&&&&&&<pre>';print_r($size_arr0);exit;

			if($file_size>$config_img['max_size']){	//$size_arr0->width<$img_width || $size_arr0->height<$img_height){//echo 'kam1111';exit;
 				//$data['uploadFile'] = "Max Size limit crossed!";
				//return $data ;
				return "Max Size limit crossed!";
			}else{
					$config_img['file_name']=$img0;
					$this->load->library('upload', $config_img);
					$this->upload->initialize($config_img);
					if (!$this->upload->do_upload($file_input_type_name)) {
						//$error = array('error' => $this->upload->display_errors());
 						//$data['uploadFile']= $this->upload->display_errors();
						return $this->upload->display_errors() ;
 					}
					$this->imageResize($this->upload->data(),'400x400');
					//$this->imageResize($this->upload->data(),'300x300');
					//$data[$file_input_type_name] = $img0;
					//$data['uploadFile'] = "file uploaded!";
					return $img0;
					//echo $data['uploadFile'] = "File Uploaded!";exit;
			}
        }

	}

	function add_feedback(){
		 $data					= array();
   		 $this->load->view('feedback', $data);
	}

	function add_image_feedback(){
		 $data					= array();
   		 $this->load->view('image_feedback', $data);
	}
	
	function edit_feedback(){
		 $data					= array();
		 $data['product_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('feedback', $data);
	}
	
	function edit_image_feedback(){
		 $data					= array();
		 $data['product_image_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('image_feedback', $data);
	}
	
	function edit_video_feedback(){
		 $data					= array();
		 $data['product_video_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('video_feedback', $data);
	}
	
	function edit_audio_feedback(){
		 $data					= array();
		 $data['product_audio_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('audio_feedback', $data);
	}
	
	function edit_pdf_feedback(){
		 $data					= array();
		 $data['product_pdf_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('pdf_feedback', $data);
	}
	function edit_pushed_ad_feedback(){
		 $data					= array();
		 $data['product_pushed_ad_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('pushed_ad_feedback', $data);
	}
	function edit_survey_feedback(){
		 $data					= array();
		 $data['product_survey_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('survey_feedback', $data);
	}
	
	function edit_demo_audio_feedback(){
		 $data					= array();
		 $data['edit_demo_audio_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('demo_audio_feedback', $data);
	}
	
	function edit_demo_video_feedback(){
		 $data					= array();
		 $data['edit_demo_video_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('demo_video_feedback', $data);
	}
	
	function edit_product_referral_response_message_options(){
		 $data					= array();
		 $data['edit_demo_audio_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('referral_response_message_options', $data);
	}
	
   /*
	function delete_attribute($id){//echo '**'.$id;exit;
	 	$data = $this->Product_model->delete_attr($id);
	 }
	 */
	 
	 function delete_feedback_question($question_id){//echo '**'.$id;exit;
	 	$data = $this->Product_model->delete_feedback_question($question_id);
	 }
	
	
	
	
	function add_video_feedback(){
		 $data					= array();
   		 $this->load->view('video_feedback', $data);
	}

	function add_audio_feedback(){
		 $data					= array();
   		 $this->load->view('audio_feedback', $data);
	}

	function add_pdf_feedback(){
		 $data					= array();
   		 $this->load->view('pdf_feedback', $data);
	}

	function add_pushed_ad_feedback(){
		 $data					= array();
   		 $this->load->view('pushed_ad_feedback', $data);
	}

	function add_survey_feedback(){
		 $data					= array();
   		 $this->load->view('survey_feedback', $data);
	}
	
	function add_demo_video_feedback(){
		 $data					= array();
   		 $this->load->view('demo_video_feedback', $data);
	}
	
	function add_demo_audio_feedback(){
		 $data					= array();
   		 $this->load->view('demo_audio_feedback', $data);
	}

	function save_feedback(){
		$data					= array();
		$data = $this->input->post();
		//print_r($data);exit;
		echo $data = $this->Product_model->save_feedback($data);exit;
	}

	// Product Description Feedback Questions
 function ask_feedback($id=''){
		if(empty($id)){
			redirect('product/ask_feedback');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_feedback';
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
			$params["product_id"] = $id;
        }
		##--------------- pagination End ----------------##

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_feedback_tpl', $params);

	}

	// Product Image Feedback Questions
	function ask_image_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 10;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_image_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->image_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_image_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_image_feedback_tpl', $params);

	}
	// Product Video Feedback Questions
	function ask_video_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_video_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->video_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_video_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_video_feedback_tpl', $params);

	}
	// Product Audio Feedback Questions
	function ask_audio_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_audio_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->audio_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_audio_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_audio_feedback_tpl', $params);

	}
	// Product PDF Feedback Questions
	function ask_pdf_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_pdf_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->pdf_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_pdf_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_pdf_feedback_tpl', $params);

	}

	// Product Push Ad Feedback Questions
	function ask_pushed_ad_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_pushed_ad_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->pushed_ad_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_pushed_ad_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_pushed_ad_feedback_tpl', $params);

	}

	// Product Survey Feedback Questions
	function ask_survey_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_survey_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->survey_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_survey_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_survey_feedback_tpl', $params);

	}
	
	// Product Demo Audio Feedback Questions
	function ask_demo_audio_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_demo_audio_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->demo_audio_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_demo_audio_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_demo_audio_feedback_tpl', $params);

	}
	
	
		// List Product Referral Title message Options 
	function ask_product_referral_response_message_options($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_product_referral_response_message_options_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->product_referral_response_message_options_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/manage_referral_response_message_options';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_manage_referral_response_message_options_tpl', $params);

	}
	// List Product Referral Title message Options end
	
	// Add Product Referral Title message Options start
		function add_referral_response_message_options(){
		 $data					= array();
   		 $this->load->view('referral_response_message_options', $data);
	}
	
	// Add Product Referral Title message Options end
	
	// Product Demo Video Feedback Questions
	function ask_demo_video_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
		}
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search');
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Product_model->total_demo_video_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->demo_video_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_demo_video_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_demo_video_feedback_tpl', $params);

	}

	function save_product_question(){
	 	$this->checklogin();
		$product_id	=$this->input->post('p_id');
		$question_id=$this->input->post('q_id');
		$Chk = $this->input->post('Chk');
		echo $this->Product_model->save_product_question($product_id,$question_id,$Chk);exit;
 	}
	


	public function list_registered_products_by_consumers() {
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
        
        if(empty($srch_string)){
                $srch_string ='';
        }
        $total_records = $this->Product_model->count_registered_products_by_consumers($srch_string);
		$params["ScanedCodeListing"] = $this->Product_model->list_registered_products_by_consumers($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('product/list_registered_products_by_consumers', $total_records);
        
        ##--------------- pagination End ----------------##
        // $data					= array();
        // $user_id 	= $this->session->userdata('admin_user_id');		
        // $params["ScanedCodeListing"] = $this->Product_model->list_registered_products_by_consumers($limit_per_page, $start_index,$srch_string);
         $this->load->view('list_registered_products_by_consumers_tpl', $params);
     }

	 
	 
		public function verity_registered_products_by_consumers() {
		
		$data = array();
        $id = $this->uri->segment(3);
		

        $data['get_registered_products_by_consumers_details'] = $this->Product_model->get_registered_products_by_consumers_details($id);
        $this->load->view('verity_registered_products_by_consumers_tpl', $data);
    }
	
	public function verity_registered_products_by_consumers_view() {
		
		$data = array();
        $id = $this->uri->segment(3);
		

        $data['get_registered_products_by_consumers_details'] = $this->Product_model->get_registered_products_by_consumers_details($id);
        $this->load->view('verity_registered_products_by_consumers_tpl', $data);
    }
	 
	 public function update_registered_products_by_consumers() {
        $data					= array();
		$data = $this->input->post();
		$consumer_id = $data['consumer_id'];
		$consumer_name = getConsumerNameById($consumer_id);
		$ProductID = $data['product_id'];
		$customer_id = get_customer_id_by_product_id($ProductID);
		$bar_code = $data['bar_code'];
		$product_brand_name = $data['product_brand_name'];
		$product_name = $data['product_name'];
		$status = $data['status'];
		if($status==1) {
			
			//$transactionType = "successful-verification-of-invoice-uploaded-for-product-registration";
			$transactionType = "product_registration_lps";
			$transactionTypeName = "Successful verification of invoice uploaded for product registration";
				$this->Product_model->saveProductLoylty($transactionType, $ProductID, $consumer_id, ['transaction_date' => date("Y-m-d H:i:s"),'consumer_id' => $consumer_id,'product_id' => $ProductID], $customer_id);
				$this->Product_model->saveConsumerPassbookLoyalty($transactionType, $transactionTypeName, $ProductID, $consumer_id, ['verification_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $ProductID, 'product_code' => $bar_code], $customer_id, 'Loyalty');
				
			//$vquery = "Congratulations! Your invoice validation is successful. Warranty, if applicable shall be now effective. Please check the details in 'my purchase list' in TRUSTAT App.";	
			$mnv60_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 60)->get()->row();
			$mnvtext60 = $mnv60_result->message_notification_value;
			
			//$vquery = "Congratulations! Your invoice validation is successful. Warranty, if applicable shall be now effective. Please check the details in 'my purchase list' in TRUSTAT App";
			$vquery = $mnvtext60;
		
		
		} else{
			$vquery = $data['vquery'];
			$data = $this->Product_model->set_product_code_unregistered($data);
		}
		
		//print_r($data);exit;
		echo $data = $this->Product_model->update_registered_products_by_consumers($data);
		
		//$consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Product_model->sendFVPNotification($vquery, $fb_token);
		 
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "TRUSTAT product Verification";
			$NTFdata['body'] = $vquery; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
			
			
			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			
			$TRNNCData['customer_id'] = $customer_id;
			$TRNNCData['consumer_id'] = $consumer_id;
			$TRNNCData['billing_particular_name'] = $TRNNC_billin_particular_name.' Uplate product Verification';		
			$TRNNCData['billing_particular_slug'] = $TRNNC_billin_particular_slug.'_update_product_verifiction';
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);		
			
			
		
		exit;
		
    }
	
	public function update_loyalty_redemption_requests() {
        $data					= array();
		$data = $this->input->post();
		$consumer_id = $data['user_id'];
		$points_redeemed = $data['points_redeemed'];
		$coupon_vendor = $data['coupon_vendor'];
		$coupon_number = $data['coupon_number'];
		//$points_redeemed = $data['points_redeemed'];
		$consumer_address = $data['consumer_address'];
		$courier_number = $data['courier_details'];
		
		$l_status = $data['l_status'];
		if($l_status==1) {
			
		//$this->Product_model->saveLoylty($transactionType, $userId, ['user_id' => $userId]);
		$transactionType = $points_redeemed . "Loyalty Points Redeemed";
		$this->Product_model->saveConsumerPassbookLoyalty1($transactionType, $consumer_id, ['transaction_date' => date("Y-m-d H:i:s"),'points_redeemed' => $points_redeemed,'coupon_number' => $coupon_number], 'Redemption', $points_redeemed);
		
				
		// this message for app$vquery = "Congratulations! Your Loyalty Points redumption request is processed successfully, we will update you for further information.";	
		$vquery = $coupon_vendor . " voucher for Rs." . $points_redeemed . " has been sent to your address " .$consumer_address. " vide courier number ". $courier_number;  
		} else{
			$vquery = "Your Loyalty Points redumption request is still pending...";	
		}
		
		//print_r($data);exit;
		echo $data = $this->Product_model->update_loyalty_redemption_requests($data);
		
		//$consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Product_model->sendFBLRNotification($vquery, $fb_token);
		 
	// update redeemed loyalty 	 
	for($i=0; $i<1000; $i++){
	$this->db->select('id,points,redeemed_points');
    $this->db->where(array('user_id' => $consumer_id, 'customer_loyalty_type' => "TRUSTAT", 'loyalty_points_status != ' => "Redeemed"));
	$this->db->order_by('id', 'ASC');
    $this->db->limit(1);
    $query = $this->db->get('loylty_points');
    $row = $query->row();
	
	$oldest_loyalty_points = $row->points;
	$oldest_loyalty_points_id = $row->id;
	$redeemed_partial_points = $row->redeemed_points;
	
	if($oldest_loyalty_points > ($points_redeemed+$redeemed_partial_points))
		{
			$updateData = array(
			   'loyalty_points_status'=>"RedeemedPartial",
			   'redeemed_points'=>$points_redeemed+$redeemed_partial_points,
			   'modified_at'=>date("Y-m-d H:i:s")
			);
			$this->db->where('id', $oldest_loyalty_points_id);
			$this->db->update('loylty_points', $updateData); 
			 break;
			}elseif($oldest_loyalty_points == ($points_redeemed+$redeemed_partial_points)){
				$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$points_redeemed+$redeemed_partial_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				$this->db->update('loylty_points', $updateData); 
				break;				
			} elseif($oldest_loyalty_points < ($points_redeemed+$redeemed_partial_points)) {
				$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$oldest_loyalty_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				$this->db->update('loylty_points', $updateData); 
				
				$points_redeemed = $points_redeemed -($oldest_loyalty_points-$redeemed_partial_points);	
			}
	/*
	$balancepoints =  $oldest_loyalty_points - ($points_redeemed+$redeemed_partial_points);		
	if($balancepoints > 0)	{
			$updateData = array(
			   'loyalty_points_status'=>"RedeemedPartial",
			   'redeemed_points'=>$points_redeemed+$redeemed_partial_points,
			   'modified_at'=>date("Y-m-d H:i:s")
			);
			$this->db->where('id', $oldest_loyalty_points_id);
			$this->db->update('loylty_points', $updateData); 
			 break;
			}else{
				$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$oldest_loyalty_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				$this->db->update('loylty_points', $updateData); 				
			}
			*/
			}
		 // end update redeemed loyalty 
		 
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "Uplate Loyalty Redemption Request";
			$NTFdata['body'] = $vquery; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
			
			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			
			$TRNNCData['customer_id'] = $customer_id;
			$TRNNCData['consumer_id'] = 1;
			$TRNNCData['billing_particular_name'] = $TRNNC_billin_particular_name.' Uplate Loyalty Redemption Request';		
			$TRNNCData['billing_particular_slug'] = $TRNNC_billin_particular_slug.'_update_loyalty_redemption_request';
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);		
			
		
		exit;
		
    }
	
	
	
	public function list_loyalty_redemption_requests() {
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
        
        if(empty($srch_string)){
                $srch_string ='';
        }
        $total_records = $this->Product_model->count_loyalty_redemption_requests($srch_string);
		$params["ScanedCodeListing"] = $this->Product_model->list_loyalty_redemption_requests($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('product/list_loyalty_redemption_requests', $total_records);
        
        ##--------------- pagination End ----------------##
         $data					= array();
         $user_id 	= $this->session->userdata('admin_user_id');		
         $params["ScanedCodeListing"] = $this->Product_model->list_loyalty_redemption_requests($limit_per_page, $start_index,$srch_string);
         $this->load->view('list_loyalty_redemption_requests_tpl', $params);
     }

	 
	 
  public function details_loyalty_redemption_requests() {
		
		$data = array();
        $id = $this->uri->segment(3);
		//echo $id;

        $data['get_loyalty_redemption_requests_details'] = $this->Product_model->details_loyalty_redemption_requests($id);
        $this->load->view('details_loyalty_redemption_requests_tpl', $data);
    }
	
	
	 public function loyalty_redemption_request_tracek_user() {
		
		$data = array();
        $id = $this->uri->segment(3);
		//echo $id;

        $data['get_loyalty_redemption_requests_details'] = $this->Product_model->details_loyalty_redemption_request_tracek_user($id);
        $this->load->view('loyalty_redemption_request_tracek_user_tpl', $data);
    }
	
	
		 public function view_loyalty_redemption_request_tracek_user() {
		
		$data = array();
        $id = $this->uri->segment(3);
		//echo $id;

        $data['get_loyalty_redemption_requests_details'] = $this->Product_model->details_loyalty_redemption_request_tracek_user($id);
        $this->load->view('view_loyalty_redemption_request_tracek_user_tpl', $data);
    }
	
	public function update_loyalty_redemption_tracek_user_request() {
        $data					= array();
		$data = $this->input->post();
		$tr_user_id = $data['tr_user_id'];
		$points_redeemed = $data['points_redeemed'];
		$coupon_type = $data['coupon_type'];
		$coupon_number = $data['coupon_number'];
		//$points_redeemed = $data['points_redeemed'];
		//$consumer_address = $data['consumer_address'];
		//$courier_number = $data['courier_details'];
		$tracek_user_parent_id = getUserParentIDById($tr_user_id);
		$l_status = $data['l_status'];
		if($l_status==1) {			
		//$this->Product_model->saveLoylty($transactionType, $userId, ['user_id' => $userId]);
		$transactionType = "Redemption";
		// this message for app$vquery = "Congratulations! Your Loyalty Points redumption request is processed successfully, we will update you for further information.";	
		
		//$vquery = $coupon_type . " voucher for Rs." . $points_redeemed . " has been sent to your address " .$coupon_number. " vide courier number ";  
		
		
		//print_r($data);exit;
		echo $data = $this->Product_model->update_loyalty_redemption_tracek_user_request($data);
		
	$this->db->select('id, points, redeemed_points, loyalty_points_status');
    $this->db->where(array('tracek_user_id' => $tr_user_id, 'customer_id' => $tracek_user_parent_id, 'modified_at' => "0000-00-00 00:00:00"));
	$this->db->order_by('id', 'ASC');
    $this->db->limit(1);
    $query = $this->db->get('tracek_loylty_points');
    $row = $query->row();	
	$oldest_loyalty_points = $row->points;
	$oldest_loyalty_points_id = $row->id;
	$redeemed_partial_points = $row->redeemed_points;	
	
	$loyalty_points_status = $row->loyalty_points_status;
	
	//$c_redeeming = $redeeming_points;
	if($oldest_loyalty_points !=""){
		//if(($redeemed_partial_points=="Earned")||($redeemed_partial_points=="RedeemedPartial")){
	if($oldest_loyalty_points > ($points_redeemed+$redeemed_partial_points))
		{				
			$updateData = array(
			   'loyalty_points_status'=>"RedeemedPartial",
			   'redeemed_points'=>$points_redeemed+$redeemed_partial_points,
			   'modified_at'=>"0000-00-00 00:00:00"
			);
			$this->db->where('id', $oldest_loyalty_points_id);
			$this->db->update('tracek_loylty_points', $updateData); 
			
			//$this->Productmodel->saveConsumerPassbookLoyaltyCashier($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' =>0,'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $parent_customer_id, $promotion_id, $redeeming_points, $CashierId);
			
			$this->Product_model->saveTracekUserPassbookLoyalty1($transactionType, $tr_user_id, ['transaction_date' => date("Y-m-d H:i:s"),'points_redeemed' => $points_redeemed,'coupon_number' => $coupon_number], 'Redemption', $points_redeemed);
			
		//	$this->db->where('lrcc_id', $transaction_id);
		//	$this->db->update('loyalty_redemption_customer_cashier', array('closing_loyalty_balance' => $c_redeeming));
			// break;
			}elseif($oldest_loyalty_points == ($points_redeemed+$redeemed_partial_points)){
				$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$points_redeemed+$redeemed_partial_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				$this->db->update('tracek_loylty_points', $updateData); 
				
			//$this->db->where('lrcc_id', $transaction_id);
			//$this->db->update('loyalty_redemption_customer_cashier', array('closing_loyalty_balance' => $c_redeeming));			
			
			//$this->Productmodel->saveConsumerPassbookLoyaltyCashier($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $parent_customer_id, $promotion_id, $redeeming_points, $CashierId);			
			//break;		

				$this->Product_model->saveTracekUserPassbookLoyalty1($transactionType, $tr_user_id, ['transaction_date' => date("Y-m-d H:i:s"),'points_redeemed' => $points_redeemed,'coupon_number' => $coupon_number], 'Redemption', $points_redeemed);
				
			}else{ //if($oldest_loyalty_points < ($redeeming_points+$redeemed_partial_points))
			
			//$this->Productmodel->saveConsumerPassbookLoyaltyCashier($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => 0,'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $parent_customer_id, $promotion_id, $redeeming_points, $CashierId);	
		
		$this->Product_model->saveTracekUserPassbookLoyalty1($transactionType, $tr_user_id, ['transaction_date' => date("Y-m-d H:i:s"),'points_redeemed' => $points_redeemed,'coupon_number' => $coupon_number], 'Redemption', $points_redeemed);
		
			$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$oldest_loyalty_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				//$this->db->where(array('customer_id'=>$parent_customer_id, 'user_id'=>$consumer_id));
				$this->db->update('tracek_loylty_points', $updateData); 	
				
				$redeeming_points2 = $points_redeemed - ($oldest_loyalty_points-$redeemed_partial_points);
				while($redeeming_points2 > 0){	
					
	$this->db->select('id, points, redeemed_points, loyalty_points_status, loyalty_points_status');
    $this->db->where(array('tracek_user_id' => $tr_user_id, 'customer_id' => $tracek_user_parent_id, 'modified_at' => "0000-00-00 00:00:00"));
	$this->db->order_by('id', 'ASC');
    $this->db->limit(1);
    $query = $this->db->get('tracek_loylty_points');
    $row = $query->row();	
	$oldest_loyalty_points2 = $row->points;
	$oldest_loyalty_points_id2 = $row->id;
	$redeemed_partial_points2 = $row->redeemed_points;	
	$loyalty_points_status = $row->loyalty_points_status;
	if($oldest_loyalty_points2 !=""){
		if($oldest_loyalty_points2 > ($redeeming_points2+$redeemed_partial_points2))
			{				
			$updateData2 = array(
			   'loyalty_points_status'=>"RedeemedPartial",
			   'redeemed_points'=>$redeeming_points2+$redeemed_partial_points2,
			   'modified_at'=>"0000-00-00 00:00:00"
			);
			$this->db->where('id', $oldest_loyalty_points_id2);
			$this->db->update('tracek_loylty_points', $updateData2); 
			//break;
			}elseif($oldest_loyalty_points2 == ($redeeming_points2+$redeemed_partial_points2)){
				$updateData2 = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$redeeming_points2+$redeemed_partial_points2,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id2);
				$this->db->update('tracek_loylty_points', $updateData2); 							
			//break;				
			}else{ //if($oldest_loyalty_points < ($redeeming_points+$redeemed_partial_points))
			$updateData2 = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$oldest_loyalty_points2,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id2);
				//$this->db->where(array('customer_id'=>$parent_customer_id, 'user_id'=>$consumer_id));
				$this->db->update('tracek_loylty_points', $updateData2);			
			//continue;
			}			
				}
				$redeeming_points2 = $redeeming_points2 - ($oldest_loyalty_points2-$redeemed_partial_points2);
				}
			}
			//}		
			}
			}else{
			exit;
			//$vquery = "Your Loyalty Points redumption request is still pending...";	
		}
	
		 // end update redeemed loyalty 
			/*
			$NTFdata['date_time'] = date("Y-m-d H:i:s",time());			
			$NTFdata['tracek_user_name'] = getTracekUserFullNameById($tr_user_id); 
			$NTFdata['tracek_user_id'] = $tr_user_id;
			$NTFdata['tracek_user_mobile'] = get_customer_mobile_no_id($tr_user_id); 			
			$NTFdata['customer_name'] = getUserFullNameById(getUserParentIDById($tr_user_id)); 
			$NTFdata['customer_id'] = getUserParentIDById($tr_user_id); 
			$NTFdata['unique_customer_code'] = getUserParentIDById($tr_user_id); 
			$NTFdata['product_name'] = 0; 
			$NTFdata['product_id'] = 0; 
			$NTFdata['product_sku'] = 0; 
			$NTFdata['product_code'] = 0; 
			$NTFdata['gloc_latitude'] = 0; 
			$NTFdata['gloc_longitude'] = 0; 
			$NTFdata['gloc_city'] = 0; 
			$NTFdata['gloc_pin_code'] = 0; 
			$NTFdata['tracek_user_activity_type'] = 0; 
			$NTFdata['loyalty_rewards_points'] = 0; 
			$NTFdata['customer_loyalty_type'] = 0; 
			
			
			$this->db->insert('tracek_user_activity_log_table', $NTFdata);
			*/
			
		
		exit;
		
    }
	
	
	
	 
	 public function details_view_loyalty_redemption_request() {
		
		$data = array();
        $id = $this->uri->segment(3);
		//echo $id;

        $data['get_loyalty_redemption_requests_details'] = $this->Product_model->details_loyalty_redemption_requests($id);
        $this->load->view('details_view_loyalty_redemption_request_tpl', $data);
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
        $total_records = $this->Product_model->count_total_list_view_consumer_passbook($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->Product_model->list_view_consumer_passbook($id, $limit_per_page, $start_index, $srch_string);
      $params["list_view_consumer_passbook_cust_dist"] = $this->Product_model->list_view_blp_consumer_passbook_cust_dist($id, $limit_per_page, $start_index, $srch_string); 
	   $params["links"] = Utils::pagination('product/list_view_consumer_passbook/' . $id, $total_records);
		//echo "test";
        $this->load->view('list_view_consumer_passbook_tpl', $params);
    }
	
	public function list_view_blp_consumer_passbook() {
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
        $total_records = $this->Product_model->count_total_list_view_blp_consumer_passbook($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->Product_model->list_view_blp_consumer_passbook($id, $limit_per_page, $start_index, $srch_string);
		$params["list_view_consumer_passbook_cust_dist"] = $this->Product_model->list_view_blp_consumer_passbook_cust_dist($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_view_blp_consumer_passbook/' . $id, $total_records);
		//echo "test";
        $this->load->view('list_view_consumer_passbook_tpl', $params);
    }
	
	
		public function list_view_blp_tracek_user_passbook() {
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
        $total_records = $this->Product_model->count_total_list_view_blp_tracek_user_passbook($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->Product_model->list_view_blp_tracek_user_passbook($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_view_blp_tracek_user_passbook/' . $id, $total_records);
		//echo "test";
        $this->load->view('list_view_tracek_user_passbook_tpl', $params);
    }
	
	public function list_customerwise_consumer_loyalty_details() {
        $this->checklogin();
		$user_id 	= $this->session->userdata('admin_user_id');
		//if($user_id==1){ $id = 1; }
		
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
        $total_records = $this->Product_model->count_total_list_customerwise_consumer_loyalty($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->Product_model->list_customerwise_consumer_loyalty($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_customerwise_consumer_loyalty_details/' . $id, $total_records, null, 4);
		//echo $user_id;
        $this->load->view('list_view_customerwise_consumer_loyalty_tpl', $params);
    }
	
	
		public function list_customerwise_consumer_loyalty_redemption_details() {
        $this->checklogin();
		$user_id 	= $this->session->userdata('admin_user_id');
		//if($user_id==1){ $id = 1; }
		
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
        $total_records = $this->Product_model->count_total_list_customerwise_consumer_loyalty_redemption($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->Product_model->list_customerwise_consumer_loyalty_redemption($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_customerwise_consumer_loyalty_redemption_details/' . $id, $total_records, null, 4);
		//echo $user_id;
        $this->load->view('list_view_customerwise_consumer_loyalty_redemption_tpl', $params);
    }
	
	
	
	public function list_view_consumer_feedback_details() {
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
		
		//$result = $this->db->select('age')->from('my_users_table')->where('id', '3')->limit(1)->get()->row_array();
		//echo $result['age'];
		
		$params["consumer_details"] = $this->db->select('*')->from('consumers')->where('id', $id)->get()->row_array();
        $total_records = $this->Product_model->count_total_consumer_feedback_question($id, $srch_string);
        $params["consumer_feedback_question"] = $this->Product_model->list_view_consumer_feedback_question($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_view_consumer_feedback_details/' . $id, $total_records);
		
        //$params["links"] = Utils::pagination('product/list_product', $total_records);
	//echo $id;
        $this->load->view('list_view_consumer_feedback_details_tpl', $params);
    }
	
	
	
	public function list_consumer_loyalties() {
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
        
        if(empty($srch_string)){
                $srch_string ='';
        }
        $total_records = $this->Product_model->count_loyalty_redemption_requests($srch_string);
		$params["ScanedCodeListing"] = $this->Product_model->list_loyalty_redemption_requests($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('product/list_consumer_loyalties', $total_records);
        
        ##--------------- pagination End ----------------##
         $data					= array();
         $user_id 	= $this->session->userdata('admin_user_id');		
         $params["ScanedCodeListing"] = $this->Product_model->list_loyalty_redemption_requests($limit_per_page, $start_index,$srch_string);
         $this->load->view('list_consumer_loyalties_tpl', $params);
     }
	 

	 public function list_all_consumers() {
        $this->checklogin();
       $user_id = $this->session->userdata('admin_user_id');
	   $customer_id = $this->uri->segment(3);
		
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        //$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		if(($user_id==1) && ($customer_id!="")){
		$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}else{
			$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}
			
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = '';//$this->Product_model->total_all_concumers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_consumers($limit_per_page, $start_index, $srch_string);
		
		if(($user_id==1) && ($customer_id!="")){
		 $params["links"] = Utils::pagination('product/list_all_consumers/', $total_records, null, 4);
			}else{
			 $params["links"] = Utils::pagination('product/list_all_consumers', $total_records);
			}
       
        $this->load->view('list_all_consumers_tpl', $params);
    }
	
	
		public function list_consumers_as_per_selection_criterias() {
        $this->checklogin();
       $user_id = $this->session->userdata('admin_user_id');
	   $criteria_id = $this->uri->segment(3);
	   $customer_id = $this->session->userdata('admin_user_id');
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        //$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
		
        $total_records = $this->Product_model->total_consumers_as_per_selection_criterias($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_consumers_as_per_selection_criterias($limit_per_page, $start_index, $srch_string,null,4);
		
	  $params["links"] = Utils::pagination('product/list_consumers_as_per_selection_criterias'.$criteria_id, $total_records);
			
       
        $this->load->view('list_consumers_as_per_selection_criterias_tpl', $params);
    }
	
	
	public function list_consumers_loyalty_summary() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->total_all_concumers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_consumers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_consumers_loyalty_summary', $total_records);
		$params["total_records"] =  $total_records;
		
			$this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			$this->db->where('transaction_lr_type', "Loyalty");
			//$this->db->where(array('transaction_lr_type' => "Loyalty", 'transaction_lr_type' => "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;		
		    $params["Total_Earned_Points"] = $Total_Earned_Points; 
		
		    $this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			$this->db->where('transaction_lr_type', "Redemption");
			$query=$this->db->get();
			$Total_Points_Redeemed=$query->row()->points;	
			$params["Total_Points_Redeemed"] = $Total_Points_Redeemed;
			
			
			$result = $this->db->select('loyalty_points')->from('loylties')->where('transaction_type_slug', 'minimum_locking_balance')->limit(1)->get()->row();
			$minimum_locking_balance = $result->loyalty_points;
			$params["minimum_locking_balance"] = $minimum_locking_balance;
		
        $this->load->view('list_consumers_loyalty_summary_tpl', $params);
    }
	
	
	
	public function list_customer_loyalty_summary() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->count_total_list_loyalty_customers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_loyalty_customers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_customer_loyalty_summary', $total_records);
		$params["total_consumers"] =  $this->db->count_all_results('consumers');
		//$params["total_customers"] =  $this->db->count_all('backend_user', array('designation_id' =>'2'));
		//$params["total_customers"] =  $this->db->count_all_results('backend_user', array('designation_id' =>'2'));
		
			$query5 = $this->db->where('designation_id', '2')->get('backend_user');
			$params["total_customers"] = $query5->num_rows();
		
			$this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			$this->db->where('transaction_lr_type', "Loyalty");
			//$this->db->where(array('transaction_lr_type' => "Loyalty", 'transaction_lr_type' => "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;		
		    $params["Total_Earned_Points"] = $Total_Earned_Points; 
		
		    $this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			$this->db->where('transaction_lr_type', "Redemption");
			$query=$this->db->get();
			$Total_Points_Redeemed=$query->row()->points;	
			$params["Total_Points_Redeemed"] = $Total_Points_Redeemed;
			
			$result = $this->db->select('loyalty_points')->from('loylties')->where('transaction_type_slug', 'minimum_locking_balance')->limit(1)->get()->row();
			$minimum_locking_balance = $result->loyalty_points;
			$params["minimum_locking_balance"] = $minimum_locking_balance;
			
        $this->load->view('list_customer_loyalty_summary_tpl', $params);
    }
	
	public function consumer_brand_loyalty_dashboard() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->count_total_list_loyalty_customers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_loyalty_customers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/consumer_brand_loyalty_dashboard', $total_records);
		
        $this->load->view('consumer_brand_loyalty_dashboard_tpl', $params);
    }
	
	public function view_customer_loyalties() {
        $this->checklogin();
        $user_id = $this->session->userdata('admin_user_id');
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
        $total_records = $this->Product_model->count_total_list_loyalty_customers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_loyalty_customers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/view_customer_loyalties', $total_records);
		$params["total_records"] =  $total_records;
		
			$this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			//$this->db->where('transaction_lr_type', "Loyalty");
			$this->db->where(array('customer_id' => $user_id, 'transaction_lr_type' => "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;		
		    $params["Total_Earned_Points"] = $Total_Earned_Points; 
			
			$this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			//$this->db->where('transaction_lr_type', "Loyalty");
			$this->db->where(array('customer_id' => $user_id, 'transaction_type_slug' => "loyalty_redemption_microsite"));
			$query_ms=$this->db->get();
			$Total_Points_Redeemed_ms=$query_ms->row()->points;		
		    $params["Total_Points_Redeemed_ms"] = $Total_Points_Redeemed_ms; 
		
		    
        $this->load->view('view_customer_loyalties_tpl', $params);
    }
	
	
	public function checkDuplicateQuestion() {
        $user_id = $this->session->userdata('admin_user_id');
       // $Question = $this->session->userdata('Question');

       $Product_id = $this->uri->segment(3);
	   //echo $Product_id;
		$Question = $this->input->post('Question');
        $qid = $this->input->post('questionid');
		$Product_id = $this->input->post('Productid');

        $isExists = $this->Product_model->checkDuplicateQuestion($Question, $qid, $Product_id);

        echo $isExists;
        exit;
    }
	
	
		public function list_tracek_users_loyalty_summary() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->total_all_customers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_customers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_tracek_users_loyalty_summary', $total_records);
		$params["total_records"] =  $total_records;
		
			$this->db->select_sum('points');
			$this->db->from('customer_passbook');
			$this->db->where('transaction_lr_type', "Loyalty");
			//$this->db->where(array('transaction_lr_type' => "Loyalty", 'transaction_lr_type' => "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;		
		    $params["Total_Earned_Points"] = $Total_Earned_Points; 
		
		    $this->db->select_sum('points');
			$this->db->from('customer_passbook');
			$this->db->where('transaction_lr_type', "Redemption");
			$query=$this->db->get();
			$Total_Points_Redeemed=$query->row()->points;	
			$params["Total_Points_Redeemed"] = $Total_Points_Redeemed;
			
			$result = $this->db->select('loyalty_points')->from('loylties')->where('transaction_type_slug', 'minimum_locking_balance')->limit(1)->get()->row();
			$minimum_locking_balance = $result->loyalty_points;
			$params["minimum_locking_balance"] = $minimum_locking_balance;
		
        $this->load->view('list_tracek_users_loyalty_summary_tpl', $params);
    }
	
	
 public function ispl_billing_list_items() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
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
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');
		
		if($user_id>1){
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}else{
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}
		
		 
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Product_model->total_ispl_billing_list_items_listing($srch_string, $from_date_data, $to_date_data);
        $params["product_list"] = $this->Product_model->ispl_billing_list_items_listing($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/ispl_billing_list_items', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/ispl_billing_list_items/' . $customer_id, $total_records, null, 4);
			}		
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('ispl_billing_list_items_tpl', $params);
    }
	
	   public function ispl_billing_list_items_download() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
            }
        }
		
		$mnv58_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 58)->get()->row();
		$mnvtext58 = $mnv58_result->message_notification_value;
		
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $mnvtext58;
        }else{
            $limit_per_page = $mnvtext58;
        }
		
        ##--------------- pagination start ----------------##
        // init params
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $mnvtext58;
        }else{
            $limit_per_page = $mnvtext58;
        }
        $this->config->set_item('pageLimit2', $limit_per_page);
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');
		
		if($user_id>1){
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			}else{
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			}
		
		 
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Product_model->total_ispl_billing_list_items_listing($srch_string, $from_date_data, $to_date_data);
        $params["product_list"] = $this->Product_model->ispl_billing_list_items_listing($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		if($user_id>1){
		$params["links"] = Utils::pagination('product/ispl_billing_list_items', $total_records);
		$params["links2"] = Utils::pagination2('product/ispl_billing_list_items', $total_records);
			}else{
			$params["links"] = Utils::pagination('product/ispl_billing_list_items/' . $customer_id, $total_records, null, 4);
			$params["links2"] = Utils::pagination2('product/ispl_billing_list_items/' . $customer_id, $total_records, null, 4);
			}
		$params["total_records2"] = $total_records; 
		/*
        $ConsumerReferralDetails = $this->Product_model->ConsumerReferralDetails2("230", "9971411559");
			$params["ConsumerReferralID"] = $ConsumerReferralDetails->referral_id;
			$params["loyalty_points_referral"] = $ConsumerReferralDetails->loyalty_points_referral;
			*/
        $this->load->view('ispl_billing_list_items_download_tpl', $params);
    }
	
	
	
	public function view_consumer_passbook_at_customer() {
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
        $total_records = $this->Product_model->count_total_list_view_consumer_passbook_at_customer($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->Product_model->list_view_consumer_passbook_at_customer($id, $limit_per_page, $start_index, $srch_string);
		//$params["list_view_consumer_passbook_cust_dist"] = $this->Product_model->list_view_consumer_passbook_at_customer_dist($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/view_consumer_passbook_at_customer/' . $id, $total_records);
		//echo "test";
        $this->load->view('view_consumer_passbook_at_customer_tpl', $params);
    }

	

	public function list_packaging_and_ship_out_order_report() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->total_all_packaging_and_ship_out_orders($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_packaging_and_ship_out_orders($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_packaging_and_ship_out_order_report', $total_records);
		$params["total_records"] =  $total_records;
		
        $this->load->view('list_packaging_and_ship_out_order_report_tpl', $params);
    }
	
	
		public function list_packaging_and_ship_out_order_report_details() {
        $this->checklogin();
		$user_id 	= $this->session->userdata('admin_user_id');
        $psoo_token_id = $this->uri->segment(3);
		
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
       // $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
			
        $srch_string = $this->input->get('search');

        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Product_model->total_all_packaging_and_ship_out_order_details($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_packaging_and_ship_out_order_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_packaging_and_ship_out_order_report_details/' . $psoo_token_id, $total_records, null, 4);
		$params["total_records"] =  $total_records;
		
        $this->load->view('list_packaging_and_ship_out_order_report_details_tpl', $params);
    }
	
	/*
	
			public function list_packaging_and_ship_out_order_report_details() {
				$this->checklogin();
				   $user_id = $this->session->userdata('admin_user_id');
				   $criteria_id = $this->uri->segment(3);
				   $customer_id = $this->session->userdata('admin_user_id');
					##--------------- pagination start ----------------##
					// init params
					$params = array();
					if(!empty($this->input->get('page_limit'))){
						$limit_per_page = $this->input->get('page_limit');
					}else{
						$limit_per_page = $this->config->item('pageLimit');
					}
					$this->config->set_item('pageLimit', $limit_per_page);
					//$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
					$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
					$srch_string = $this->input->get('search');

					if (empty($srch_string)) {
						$srch_string = '';
					}
					
					$total_records = $this->Product_model->total_all_packaging_and_ship_out_order_details($srch_string);
					$params["list_all_consumers"] = $this->Product_model->list_all_packaging_and_ship_out_orders($limit_per_page, $start_index, $srch_string,null,4);
					
				  $params["links"] = Utils::pagination('product/list_packaging_and_ship_out_order_report_details'.$criteria_id, $total_records);						
				   
					$this->load->view('list_packaging_and_ship_out_order_report_details_tpl', $params);
				}
	
	*/
	
		public function list_products_packaging_and_ship_out_report() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->total_all_products_packaging_and_ship_out_report($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_products_packaging_and_ship_out_report($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_products_packaging_and_ship_out_report', $total_records);
		$params["total_records"] =  $total_records;
		
        $this->load->view('list_products_packaging_and_ship_out_report_tpl', $params);
    }
	
		 public function change_assigned_packaging_supervisor() {
 		 $id = $this->input->post('id');
		 $value = $this->input->post('value');
		 
		
 		 echo $status= $this->Product_model->change_assigned_packaging_supervisor($id,$value);exit;
      }
	  
	  
	   public function change_assigned_packer() {
 		 $id = $this->input->post('id');
		 $value = $this->input->post('value');
		 
		
 		 echo $status= $this->Product_model->change_assigned_packer($id,$value);exit;
      }
	  
	  
	  
	  		public function list_products_packaging_and_ship_out_report_packaging_id() {
				$this->checklogin();
				
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
				$total_records = $this->Product_model->total_all_products_packaging_and_ship_out_report($srch_string);
				$params["list_all_consumers"] = $this->Product_model->list_all_products_packaging_and_ship_out_report($limit_per_page, $start_index, $srch_string);
				$params["links"] = Utils::pagination('product/list_products_packaging_and_ship_out_report', $total_records);
				$params["total_records"] =  $total_records;
				
				$this->load->view('list_products_packaging_and_ship_out_report_tpl', $params);
			}
	  
	
}

