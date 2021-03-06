<?php
 class Product_model extends CI_Model {
     function __construct() {
         parent::__construct();
		 $this->load->helper('common_functions_helper');
     }
	 
     

     public function getOptionList($id) {
         $q = $this->db
                 ->select('*')
                  ->from('attribute_options')
 				->where("product_id", $id)
                 ->get();//echo $this->db->last_query();exit;
         return $q->result_array();
     }
	 
	 
	 
	  
     function get_property_values($id) {
		$this->db->select("*");
		$this->db->from("attribute_options");
		$this->db->where("product_id", $id);
        return $this->db->get()->result_array();
    }

    function update_attribute_val($params) {// echo '<pre>';print_r($params);exit;
		if(!empty($params['product_attr'])){
			$updaArr = array('name'=> $params['product_attr']);
			$this->db->where('product_id', $params['hid_id']);
			 $response = $this->db->update('attribute_name',$updaArr);
			 //echo $this->db->last_query();exit;
			 if ($response) {
				$this->session->set_flashdata('success', 'Attribute Updated Successfully!');
			  } else {
				$this->session->set_flashdata('success', 'Attribute Not Updated!');
			 }
			 redirect('product/set_attributes');
		 }else{
		 	$this->session->set_flashdata('success', 'Attribute Not Updated!');
			redirect('product/update_attributes/'.$params['hid_id']);
		 }
    }
 
	 
	 function IsExistsProduct($name,$id='') {
		$rows = 0;
		$result = 'true';
		$this->db->select("id");
		$this->db->from("products");
		$this->db->where("product_name", $name);
		if(!empty($id)){
			$this->db->where("id", $id);
		}
		$q = $this->db->get();
        $rows = $q->num_rows();
		if($rows>0){
			$result = 'false';
		} return $result;
    }
	
		 function IsCustomerERPProductID($name,$id='') {
		$rows = 0;
		$result = 'true';
		$this->db->select("id");
		$this->db->from("products");
		$this->db->where("customer_erp_product_id", $name);
		if(!empty($id)){
			$this->db->where("id", $id);
		}
		$q = $this->db->get();
        $rows = $q->num_rows();
		if($rows>0){
			$result = 'false';
		} return $result;
    }
	
	 function isDateMoreThanToday($referral_program_auto_off_date) {
		$result = 'true';
		
		$date_now = date_create(date('Y-m-d'));
		
		$date_next = date_create(date('Y-m-d',strtotime($referral_program_auto_off_date)));
		
		$dateDiff = date_diff($date_now, $date_next);
		$DaysDifference = $dateDiff->format("%R%a")+1;
		
	if ($DaysDifference > 1) {
		//echo 'Date Not Passed';
		//return false;
		
		}else{
			//echo 'Date  Passed';	
		$result = 'false';			
		}
		return $result;
    }
	
	function isDateMoreThanTodayEdit($referral_program_auto_off_date) {
		$result = 'true';
		
		$date_now = date_create(date('Y-m-d'));
		
		$date_next = date_create(date('Y-m-d',strtotime($referral_program_auto_off_date)));
		
		$dateDiff = date_diff($date_now, $date_next);
		$DaysDifference = $dateDiff->format("%R%a")+1;
	if ($DaysDifference > 1) {
		//echo 'Date Not Passed';
		//return false;
		
		}else{
			//echo 'Date  Passed';	
		$result = 'false';			
		}
		return $result;
    }
	
	function getAttributeList() {
		$this->db->select("*");
		$this->db->from("attribute_name");
		//$this->db->where(array("parent"=>'0'));
		$this->db->order_by("name", " desc");
        return $this->db->get()->result_array();
    }
	
 	function get_all_attrs() {
		/*$this->db->select('At.name, Ao.*');
		$this->db->from('attribute_name At');
		$this->db->join('attribute_options Ao',' Ao.product_id = At.product_id','Left');
		$this->db->where("At.lavel",1);*/
		$this->db->select("*");
		$this->db->from("attribute_name");
		$this->db->where(array("parent!="=>'0'));
		$this->db->order_by("product_id", " asc");
       
		
		$query=$this->db->get();
		
		//echo '==>'.$this->db->last_query();exit;
        return $query->result_array();
    }
	
	function save_product(){
 		$user_id 	=$this->session->userdata('admin_user_id');
		$is_parent	= $this->session->userdata('admin_user_id');
		if($this->input->post('ccadmin')!=''){
			$is_parent 	= $this->input->post('ccadmin');	
		}
		// echo '<pre>';print_r($this->input->post());exit;
		$industry 				=  json_encode(array_filter($this->input->post('industry')));
		
		$product_name 			= $this->input->post('product_name');
		$customer_erp_product_id 			= $this->input->post('customer_erp_product_id');
		$brand_name 			= $this->input->post('brand_name');
		$product_sku  			= $this->input->post('product_sku');
		$product_attr 			= json_encode($this->input->post('product_attr'));
		
		## ================for other value================ ##
		$filtered 				= array_filter($this->input->post(), function($k){
   									return preg_match('#textbox_\d#', $k);
								  }, ARRAY_FILTER_USE_KEY);
		$Other_industry_val		=''; 
		$Other_industry_key  	= array_keys($filtered);
		$otherKey 				= $Other_industry_key[0];
		if(!empty($otherKey)){
			$Other_industry_val	= $filtered[$otherKey];
			$remark 			= $this->input->post('remarkbox');
			$other_industry_id 	= $this->checkExistsOtherIndustry($Other_industry_val,$remark);	
 			$Other_industry_val = (!empty($otherKey))?$otherKey.'-||-'.$other_industry_id:'';	
			
		} 
  		
		## ================for other value================ ##
		## essential attributes
		$code_type  			= ($this->input->post('code_type'))?$this->input->post('code_type'):'';
		//$code_activation_type  	= ($this->input->post('code_activation_type'))?$this->input->post('code_activation_type'):'';
		$code_activation_type   = $this->input->post('code_activation_type');
		$delivery_method  		= ($this->input->post('delivery_method'))?$this->input->post('delivery_method'):'';
		$code_key_type  		= ($this->input->post('code_key_type'))?$this->input->post('code_key_type'):'';
		$code_size  			= ($this->input->post('code_size'))?$this->input->post('code_size'):'';
		$code_unity_type  		= ($this->input->post('code_unity_type'))?$this->input->post('code_unity_type'):'';	
		$show_code_below_printed_bar_qr_code  		= ($this->input->post('show_code_below_printed_bar_qr_code'))?$this->input->post('show_code_below_printed_bar_qr_code'):'';	
		$registration_pack  	= ($this->input->post('registration_pack'))?$this->input->post('registration_pack'):'';	
		$retailer_pack  		= ($this->input->post('retailer_pack'))?$this->input->post('retailer_pack'):'';	
	$min_shipper_pack_level  		= ($this->input->post('min_shipper_pack_level'))?$this->input->post('min_shipper_pack_level'):'';	
	$max_shipper_pack_level  		= ($this->input->post('max_shipper_pack_level'))?$this->input->post('max_shipper_pack_level'):'';
	$max_packaging_level_product  		= ($this->input->post('max_packaging_level_product'))?$this->input->post('max_packaging_level_product'):'';
	$number_of_scans_for_super_loyalty  		= $this->input->post('number_of_scans_for_super_loyalty');
	$number_of_loyalty_points_for_super_loyalty  		= $this->input->post('number_of_loyalty_points_for_super_loyalty');	
	$app_notification_message_for_super_loyalty  		= $this->input->post('app_notification_message_for_super_loyalty');	
	$app_passbook_on_screen_display_message_sl  		= $this->input->post('app_passbook_on_screen_display_message_sl');	
	$include_the_product_in_referral_program  		= ($this->input->post('include_the_product_in_referral_program'))?$this->input->post('include_the_product_in_referral_program'):'';	
	$send_ref_message_frm_server  		= $this->input->post('send_ref_message_frm_server');	
	$message_receiver_ref_frm_server  		= $this->input->post('message_receiver_ref_frm_server');	
	$include_the_product_in_super_loyalty  		= ($this->input->post('include_the_product_in_super_loyalty'))?$this->input->post('include_the_product_in_super_loyalty'):'';	
	$gap_period_for_last_activity_of_existing_consumer  		= $this->input->post('gap_period_for_last_activity_of_existing_consumer');	
	$loyalty_rewards_to_sender_consumer_under_referral  		= $this->input->post('loyalty_rewards_to_sender_consumer_under_referral');	
	$number_of_referrals_allowed_to_consumer 	= $this->input->post('number_of_referrals_allowed_to_consumer');	
	$referral_program_auto_off_date = (date('Y-m-d',strtotime($this->input->post('referral_program_auto_off_date'))))?date('Y-m-d',strtotime($this->input->post('referral_program_auto_off_date'))):'';	
	$media_type_for_sending_reference  		= ($this->input->post('media_type_for_sending_reference'))?$this->input->post('media_type_for_sending_reference'):'';
	$custom_message_for_sending_reference  		= ($this->input->post('custom_message_for_sending_reference'))?$this->input->post('custom_message_for_sending_reference'):'';
	$message_for_receiver_of_reference	= ($this->input->post('message_for_receiver_of_reference'))?$this->input->post('message_for_receiver_of_reference'):'';
	$warranty_in_days	= $this->input->post('warranty_in_days');
	$max_referrals_for_product  		= $this->input->post('max_referrals_for_product');
	$message_above_code  		= ($this->input->post('message_above_code'))?$this->input->post('message_above_code'):'';
	$message_below_code  		= ($this->input->post('message_below_code'))?$this->input->post('message_below_code'):'';
	$space_between_twin_code  	= ($this->input->post('space_between_twin_code'))?$this->input->post('space_between_twin_code'):'';	
	$space_for_message_above_code  	= ($this->input->post('space_for_message_above_code'))?$this->input->post('space_for_message_above_code'):'';
	$space_for_message_below_code  	= ($this->input->post('space_for_message_below_code'))?$this->input->post('space_for_message_below_code'):'';
	$space_between_code_rows  	= ($this->input->post('space_between_code_rows'))?$this->input->post('space_between_code_rows'):'';
	$TextFontSize  	= ($this->input->post('TextFontSize'))?$this->input->post('TextFontSize'):'';
	$print_codes_in_batches  	= ($this->input->post('print_codes_in_batches'))?$this->input->post('print_codes_in_batches'):'';
	$space_for_code_below_batchid  	= ($this->input->post('space_for_code_below_batchid'))?$this->input->post('space_for_code_below_batchid'):'';
	$height_of_the_bar_code  	= ($this->input->post('height_of_the_bar_code'))?$this->input->post('height_of_the_bar_code'):'';
	$message_above_secondry_code  	= ($this->input->post('message_above_secondry_code'))?$this->input->post('message_above_secondry_code'):'';
	$message_below_secondry_code  	= ($this->input->post('message_below_secondry_code'))?$this->input->post('message_below_secondry_code'):'';
	$space_for_message_above_secondry_code  	= ($this->input->post('space_for_message_above_secondry_code'))?$this->input->post('space_for_message_above_secondry_code'):'';
	$space_for_message_below_secondry_code  	= ($this->input->post('space_for_message_below_secondry_code'))?$this->input->post('space_for_message_below_secondry_code'):'';
		## essential attributes
		
		$id			  = $this->input->post('id');
		
		
		 if(!empty($id)){
		 	 $updateArr=array(
					"brand_name"=>$brand_name,
					//"attribute_list"=>$product_attr,
					"industry_data"=>$industry,
					"code_type"			  => $code_type,
					"code_activation_type"=> $code_activation_type,
					"delivery_method"	  => $delivery_method,
					"code_key_type"		  => $code_key_type,
					"code_size"			  => $code_size,
					"code_unity_type"	  => $code_unity_type,
					"show_code_below_printed_bar_qr_code"	  => $show_code_below_printed_bar_qr_code,
					"registration_pack"	  => $registration_pack,
					"retailer_pack"	  	  => $retailer_pack,
					"min_shipper_pack_level"	  => $min_shipper_pack_level,
					"max_shipper_pack_level"	  => $max_shipper_pack_level,
					"max_packaging_level_product"	  => $max_packaging_level_product,
					"number_of_scans_for_super_loyalty"	  => $number_of_scans_for_super_loyalty,
					"number_of_loyalty_points_for_super_loyalty"	  => $number_of_loyalty_points_for_super_loyalty,
					"app_notification_message_for_super_loyalty"	  => $app_notification_message_for_super_loyalty,
					"app_passbook_on_screen_display_message_sl"	  => $app_passbook_on_screen_display_message_sl,
					"include_the_product_in_referral_program"	  => $include_the_product_in_referral_program,
					"send_ref_message_frm_server"	  => $send_ref_message_frm_server,
					"message_receiver_ref_frm_server"	  => $message_receiver_ref_frm_server,
					"include_the_product_in_super_loyalty"	  => $include_the_product_in_super_loyalty,
					"gap_period_for_last_activity_of_existing_consumer"	  => $gap_period_for_last_activity_of_existing_consumer,
					"loyalty_rewards_to_sender_consumer_under_referral"	  => $loyalty_rewards_to_sender_consumer_under_referral,
					"number_of_referrals_allowed_to_consumer"	  => $number_of_referrals_allowed_to_consumer,
					"referral_program_auto_off_date"	  => $referral_program_auto_off_date,
					"media_type_for_sending_reference"	  => $media_type_for_sending_reference,
					"custom_message_for_sending_reference"	  => $custom_message_for_sending_reference,
					"message_for_receiver_of_reference"	  => $message_for_receiver_of_reference,
					"warranty_in_days"	  => $warranty_in_days,
					"max_referrals_for_product"	  => $max_referrals_for_product,
					"message_above_code"	  => $message_above_code,
					"message_below_code"	  => $message_below_code,
					"space_between_twin_code"	  => $space_between_twin_code,
					"space_for_message_above_code"	  => $space_for_message_above_code,
					"space_for_message_below_code"	  => $space_for_message_below_code,
					"space_between_code_rows"	  => $space_between_code_rows,
					"TextFontSize"	  => $TextFontSize,
					"print_codes_in_batches"	  => $print_codes_in_batches,
					"space_for_code_below_batchid"	  => $space_for_code_below_batchid,
					"height_of_the_bar_code"	  => $height_of_the_bar_code,
					"message_above_secondry_code"	  => $message_above_secondry_code,
					"message_below_secondry_code"	  => $message_below_secondry_code,
					"space_for_message_above_secondry_code"	  => $space_for_message_above_secondry_code,
					"space_for_message_below_secondry_code"	  => $space_for_message_below_secondry_code,
					"created_by"		  => $is_parent,
					"other_industry"	  => $Other_industry_val
 				);
				//echo '<pre>';print_r($insertData);exit;
				$this->db->where('id', $id);
				if($this->db->update("products", $updateArr)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Updated Successfully!');
					return true;
	
				}return false; 
		 }else{
 			 $insertData=array(
					"product_name"		  => $product_name,
					"customer_erp_product_id"		  => $customer_erp_product_id,
					"brand_name"		  => $brand_name,
					"attribute_list"	  => $product_attr,
					"industry_data"		  => $industry,
					"product_sku"		  => $product_sku,
					"created_by"		  => $is_parent,
					"status"			  => 1,
					"product_description" => '',
					"product_thumb_images"	  => '',
					"product_image"	  => '',
					"product_code_print_bg_images"	  => '',
					"product_video"	      => '',
					"product_audio"		  => '',
					"product_pdf"         => '',
					"product_demo_video"	      => '',
					"product_demo_audio"		  => '',
					"product_user_manual"         => '',
					"product_push_ad_video"	      => '',
					"product_push_ad_audio"	      => '',
					"product_push_ad_pdf"	      => '',
					"product_push_ad_image"	      => '',
					"product_survey_video"	      => '',
					"product_survey_audio"	      => '',
					"product_survey_pdf"	      => '',
					"product_survey_image"	      => '',
					"code_type"			  => $code_type,
					"code_activation_type"=> $code_activation_type,
					"delivery_method"	  => $delivery_method,
					"code_key_type"		  => $code_key_type,
					"registration_pack"	  => $registration_pack,
					"retailer_pack"		  => $retailer_pack,
					"min_shipper_pack_level"	=> $min_shipper_pack_level,
					"max_shipper_pack_level"	=> $max_shipper_pack_level,
					"max_packaging_level_product"	  => $max_packaging_level_product,
					"number_of_scans_for_super_loyalty"	=> $number_of_scans_for_super_loyalty,
					"number_of_loyalty_points_for_super_loyalty"	=> $number_of_loyalty_points_for_super_loyalty,
					"app_notification_message_for_super_loyalty"	=> $app_notification_message_for_super_loyalty,
					"app_passbook_on_screen_display_message_sl"	=> $app_passbook_on_screen_display_message_sl,
					"include_the_product_in_referral_program"	=> $include_the_product_in_referral_program,
					"send_ref_message_frm_server"	=> $send_ref_message_frm_server,
					"message_receiver_ref_frm_server"	=> $message_receiver_ref_frm_server,
					"include_the_product_in_super_loyalty"	=> $include_the_product_in_super_loyalty,
					"gap_period_for_last_activity_of_existing_consumer"	=> $gap_period_for_last_activity_of_existing_consumer,
					"loyalty_rewards_to_sender_consumer_under_referral"	=> $loyalty_rewards_to_sender_consumer_under_referral,
					"number_of_referrals_allowed_to_consumer"	=> $number_of_referrals_allowed_to_consumer,
					"referral_program_auto_off_date"	=> $referral_program_auto_off_date,
					"media_type_for_sending_reference"	=> $media_type_for_sending_reference,
					"custom_message_for_sending_reference"	=> $custom_message_for_sending_reference,
					"message_for_receiver_of_reference"	=> $message_for_receiver_of_reference,
					"warranty_in_days"	=> $warranty_in_days,					
					"max_referrals_for_product"	=> $max_referrals_for_product,
					"TextFontSize"	  => $TextFontSize,
					"height_of_the_bar_code"	  => $height_of_the_bar_code,
					"space_for_message_above_code"	  => $space_for_message_above_code,
					"space_for_message_below_code"	  => $space_for_message_below_code,
					"space_between_code_rows"	  => $space_between_code_rows,
					"message_above_secondry_code"	  => $message_above_secondry_code,
					"message_below_secondry_code"	  => $message_below_secondry_code,
					"space_for_message_above_secondry_code"	  => $space_for_message_above_secondry_code,
					"space_for_message_below_secondry_code"	  => $space_for_message_below_secondry_code,
					"message_above_code"	=> $message_above_code,
					"message_below_code"	=> $message_below_code,
					"space_between_twin_code"	=> $space_between_twin_code,
					"code_size"			  => $code_size,
					"code_unity_type"	  => $code_unity_type,
					"show_code_below_printed_bar_qr_code"	  => $show_code_below_printed_bar_qr_code,
					"print_codes_in_batches"	  => $print_codes_in_batches,
					"space_for_code_below_batchid"	  => $space_for_code_below_batchid,
					"other_industry"	  => $Other_industry_val
					
				); //echo '<pre>';print_r($insertData);exit;
				if($this->db->insert("products", $insertData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Added Successfully!');
					return true;
				}return false; 
		}
	}
	
	
		function save_product_attributes(){
 		$user_id 	=$this->session->userdata('admin_user_id');
		$is_parent	= $this->session->userdata('admin_user_id');
		if($this->input->post('ccadmin')!=''){
			$is_parent 	= $this->input->post('ccadmin');	
		}
		// echo '<pre>';print_r($this->input->post());exit;
		$industry 				=  json_encode(array_filter($this->input->post('industry')));
		
		$product_name 			= $this->input->post('product_name');
		$customer_erp_product_id 			= $this->input->post('customer_erp_product_id');
		$brand_name 			= $this->input->post('brand_name');
		$product_sku  			= $this->input->post('product_sku');
		$product_attr 			= json_encode($this->input->post('product_attr'));
		
		## ================for other value================ ##
		$filtered 				= array_filter($this->input->post(), function($k){
   									return preg_match('#textbox_\d#', $k);
								  }, ARRAY_FILTER_USE_KEY);
		$Other_industry_val		=''; 
		$Other_industry_key  	= array_keys($filtered);
		$otherKey 				= $Other_industry_key[0];
		if(!empty($otherKey)){
			$Other_industry_val	= $filtered[$otherKey];
			$remark 			= $this->input->post('remarkbox');
			$other_industry_id 	= $this->checkExistsOtherIndustry($Other_industry_val,$remark);	
 			$Other_industry_val = (!empty($otherKey))?$otherKey.'-||-'.$other_industry_id:'';	
			
		} 
  		
		## ================for other value================ ##
		## essential attributes
		$code_type  			= ($this->input->post('code_type'))?$this->input->post('code_type'):'';
		$code_activation_type  	= ($this->input->post('code_activation_type'))?$this->input->post('code_activation_type'):'';
		//$code_activation_type   = $this->input->post('code_activation_type');
		$delivery_method  		= ($this->input->post('delivery_method'))?$this->input->post('delivery_method'):'';
		$code_key_type  		= ($this->input->post('code_key_type'))?$this->input->post('code_key_type'):'';
		$code_size  			= ($this->input->post('code_size'))?$this->input->post('code_size'):'';
		$code_unity_type  		= ($this->input->post('code_unity_type'))?$this->input->post('code_unity_type'):'';	
		$show_code_below_printed_bar_qr_code  		= ($this->input->post('show_code_below_printed_bar_qr_code'))?$this->input->post('show_code_below_printed_bar_qr_code'):'';			
		## essential attributes
		
		$id			  = $this->input->post('id');
		
		
		 if(!empty($id)){
		 	 $updateArr=array(
					"attribute_list"=>$product_attr
					
 				);
				//echo '<pre>';print_r($insertData);exit;
				$this->db->where('id', $id);
				if($this->db->update("products", $updateArr)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Updated Successfully!');
					return true;
	
				}return false; 
		 }else{
 			 $insertData=array(
					"product_name"		  => $product_name,
					"customer_erp_product_id"		  => $customer_erp_product_id,
					"brand_name"		  => $brand_name,
					"attribute_list"	  => $product_attr,
					"industry_data"		  => $industry,
					"product_sku"		  => $product_sku,
					"created_by"		  => $is_parent,
					"status"			  => 1,
					"product_description" => '',
					"product_thumb_images"	  => '',
					"product_image"	  => '',
					"product_code_print_bg_images"	  => '',
					"product_video"	      => '',
					"product_audio"		  => '',
					"product_pdf"         => '',
					"product_demo_video"	      => '',
					"product_demo_audio"		  => '',
					"product_user_manual"         => '',
					"product_push_ad_video"	      => '',
					"product_push_ad_audio"	      => '',
					"product_push_ad_pdf"	      => '',
					"product_push_ad_image"	      => '',
					"product_survey_video"	      => '',
					"product_survey_audio"	      => '',
					"product_survey_pdf"	      => '',
					"product_survey_image"	      => '',
					"code_type"			  => $code_type,
					"code_activation_type"=> $code_activation_type,
					"delivery_method"	  => $delivery_method,
					"code_key_type"		  => $code_key_type,
					"code_size"			  => $code_size,
					"code_unity_type"	  => $code_unity_type,
					"show_code_below_printed_bar_qr_code"	  => $show_code_below_printed_bar_qr_code,
					"other_industry"	  => $Other_industry_val
					
				); //echo '<pre>';print_r($insertData);exit;
				if($this->db->insert("products", $insertData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Added Successfully!');
					return true;
				}return false; 
		}
	}
	
	
	function save_product_pack_level(){
 		$user_id 	=$this->session->userdata('admin_user_id');
		$is_parent	= $this->session->userdata('admin_user_id');
		if($this->input->post('ccadmin')!=''){
			$is_parent 	= $this->input->post('ccadmin');	
		}
		// echo '<pre>';print_r($this->input->post());exit;
		//$industry 				=  json_encode(array_filter($this->input->post('industry')));
		$id			 			= $this->input->post('id');
		$product_id 			= $this->input->post('product_id');
		$pack_level1 			= $this->input->post('pack_level1');
		$pack_level2 			= $this->input->post('pack_level2');
		$pack_level3 			= $this->input->post('pack_level3');
		$pack_level4 			= $this->input->post('pack_level4');
		$pack_level5 			= $this->input->post('pack_level5');
		$pack_level6 			= $this->input->post('pack_level6');
		$pack_level7 			= $this->input->post('pack_level7');
		$pack_level8 			= $this->input->post('pack_level8');
		$pack_level9 			= $this->input->post('pack_level9');
		$pack_level10 			= $this->input->post('pack_level10');
		$pack_level11 			= $this->input->post('pack_level11');
		$pack_level12 			= $this->input->post('pack_level12');
		$pack_level13 			= $this->input->post('pack_level13');
		$pack_level14 			= $this->input->post('pack_level14');
		$pack_level15 			= $this->input->post('pack_level15');
		$pack_level16 			= $this->input->post('pack_level16');
		$pack_level17 			= $this->input->post('pack_level17');
		$pack_level18 			= $this->input->post('pack_level18');
		$pack_level19 			= $this->input->post('pack_level19');
		$pack_level20 			= $this->input->post('pack_level20');
		$pack_level21 			= $this->input->post('pack_level21');
		
		
		//$product_attr 			= json_encode($this->input->post('product_attr'));
		
		## ================for other value================ ##
		 
  		
		## ================for other value================ ##
		## essential attributes
		
		 if(!empty($id)){
		 	 $updateArr=array(
					"product_id"=>$product_id,
					"pack_level1"=>$pack_level1,
					"pack_level2"=>$pack_level2,
					"pack_level3"=>$pack_level3,
					"pack_level4"=>$pack_level4,
					"pack_level5"=>$pack_level5,
					"pack_level6"=>$pack_level6,
					"pack_level7"=>$pack_level7,
					"pack_level8"=>$pack_level8,
					"pack_level9"=>$pack_level9,
					"pack_level10"=>$pack_level10,
					"pack_level11"=>$pack_level11,
					"pack_level12"=>$pack_level12,
					"pack_level13"=>$pack_level13,
					"pack_level14"=>$pack_level14,
					"pack_level15"=>$pack_level15,
					"pack_level16"=>$pack_level16,
					"pack_level17"=>$pack_level17,
					"pack_level18"=>$pack_level18,
					"pack_level19"=>$pack_level19,
					"pack_level20"=>$pack_level20,
					"pack_level21"=>$pack_level21
					
 				);
				//echo '<pre>';print_r($insertData);exit;
				$this->db->where('id', $id);
				if($this->db->update("product_packaging_qty_levels", $updateArr)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Packaging Levels Childern Updated Successfully!');
					return true;
	
				} return false; 
		 }else{
 			 $insertData=array(
					"product_id"=>$product_id,
					"pack_level1"=>$pack_level1,
					"pack_level2"=>$pack_level2,
					"pack_level3"=>$pack_level3,
					"pack_level4"=>$pack_level4,
					"pack_level5"=>$pack_level5,
					"pack_level6"=>$pack_level6,
					"pack_level7"=>$pack_level7,
					"pack_level8"=>$pack_level8,
					"pack_level9"=>$pack_level9,
					"pack_level10"=>$pack_level10,
					"pack_level11"=>$pack_level11,
					"pack_level12"=>$pack_level12,
					"pack_level13"=>$pack_level13,
					"pack_level14"=>$pack_level14,
					"pack_level15"=>$pack_level15,
					"pack_level16"=>$pack_level16,
					"pack_level17"=>$pack_level17,
					"pack_level18"=>$pack_level18,
					"pack_level19"=>$pack_level19,
					"pack_level20"=>$pack_level20,
					"pack_level21"=>$pack_level21
					
				); //echo '<pre>';print_r($insertData);exit;
				if($this->db->insert("product_packaging_qty_levels", $insertData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Packaging Levels Childern Added Successfully!');
					return true;
				} return false; 
		}
	}
	
	
	function product_listing($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%') and (created_by=$user_id)");
			}else{
				$this->db->where(array('created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select("*");
		$this->db->from("products");
		if($user_id>1){
		$this->db->where('created_by', $user_id);
			}else{
			$this->db->where('created_by', $customer_id);
			}
		
		$this->db->order_by("created_date", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	

	
	// assigned products listing 	
	function assigned_product_listing($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%') and (created_by=$user_id)");
			}else{
				$this->db->where(array('created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select("*");
		$this->db->from("products");
		//if($user_id>1){
			//$this->db->where('created_by', $user_id);
		//}
		
		$this->db->order_by("created_date", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	
	function total_product_listing($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%') and (created_by=$user_id)");
			}else{
				$this->db->where(array('created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%')");
			}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from('products');
		if($user_id>1){
		$this->db->where('created_by', $user_id);
			}else{
			$this->db->where('created_by', $customer_id);
			}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	  
	  
	function total_product_listing_all($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%') and (created_by=$user_id)");
			}else{
				$this->db->where(array('created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%')");
			}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from('products');
		if($user_id>1){
		$this->db->where('created_by', $user_id);
			}else{
			//$this->db->where('created_by', $customer_id);
			}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	function product_listing_all($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR created_by LIKE '%$srch_string%' OR brand_name LIKE '%$srch_string%') and (created_by=$user_id)");
			}else{
				$this->db->where(array('created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR created_by LIKE '%$srch_string%' OR brand_name LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select("*");
		$this->db->from("products");
		if($user_id>1){
		$this->db->where('created_by', $user_id);
			}else{
			//$this->db->where('created_by', $customer_id);
			}
		
		$this->db->order_by("created_date", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }

	
     function fetch_product_detail($id) {
		$this->db->select("*");
		$this->db->from("products");
		$this->db->where("id", $id);
        return $this->db->get()->result_array();
    }
	
	function fetch_product_pack_level_detail($id) {
		$this->db->select("*");
		$this->db->from("product_packaging_qty_levels");
		$this->db->where("product_id", $id);
        return $this->db->get()->result_array();
    }
	
	function fetch_feedback_question_detail($id) {
		$this->db->select("*");
		$this->db->from("feedback_question_bank");
		$this->db->where("question_id", $id);
        return $this->db->get()->result_array();
    }
	
	
	function saveAttributeList(){
	$level = getAttrDepth($this->input->post('parent'),1);
	if($level==1){
		$level=0;
	}
	$level_count = $level+1;
	$user_id 	= $this->session->userdata('admin_user_id');
		$insertData=array(
					"name"=>$this->input->post('attr_name'),
					"parent"=>$this->input->post('parent'),
					'lavel'=>$level_count,
					"created_date"=>date('Y-m-d h:i:s'),
					"status"=>1
				);//echo '<pre>';print_r($insertData);exit;
				if($this->db->insert("attribute_name", $insertData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Attribute Added Successfully!');
					echo '1';exit;
				}echo  '0'; exit;
	}
	
	function getChild_dropDown($id) {
			$this->db->select('At.name, Ao.*');
			$this->db->from('attribute_name At');
			$this->db->join('attribute_options Ao',' Ao.product_id = At.product_id','Left');
			$this->db->where("At.parent",$id);
			 
			return $this->db->get()->result_array();
		}
		
		function delete_attr($id){
			$this->db->query("delete from products where id='".$id."'");
			$this->session->set_flashdata('success', 'SKU Deleted Successfully!');
			redirect('product/list_product');
		}
		
		function delete_feedback_question($question_id){
			$this->db->query("delete from feedback_question_bank where question_id='".$question_id."'");
			$this->session->set_flashdata('success', 'Deleted Successfully!');
			redirect('product/list_product');
		}
		
		function checkExistsOtherIndustry($indName='',$remark){
			$returnId=0;
			
			$this->db->select('id');
			$this->db->from('other_industry');
			$this->db->where("industry_name",$indName);
			$qry = $this->db->get()->result_array();
			$returnId = $qry[0]['id'];
 			if(!empty($indName) && !empty($returnId)){
				return $returnId;
			}else{
				$insertData = array("industry_name"=>$indName, "remark"=>$remark);
				if($this->db->insert("other_industry", $insertData)) {// echo '===query===='.$this->db->last_query();
 					return $returnId= $this->db->insert_id();
				}
			}
 		}
		// Sanjay
		function save_feedback($postData){
			 $product_id  	 = $postData['ProductID'];
			 $question_type  = $postData['QuestionType'];
			 $question_media_type  = $postData['MediaType'];
			 $question 		 = $postData['Question'];
			 $answer1 		 = $postData['answer1'];
			 $answer2 		 = $postData['answer2'];
			 $answer3 		 = $postData['answer3'];
			 $answer4 		 = $postData['answer4'];
			 $correct_answer = $postData['correctAns'];
			 
			 $question_id = $postData['QuestionID'];
			 if(!empty($question_id)){
		 	 $updateArr=array(
					//"product_id"	  => $product_id,
					//"question_type"	  => $question_type,
					"question_media_type"		  => $question_media_type,
					"question"		  => $question,
					"answer1"	 	  => $answer1,
					"answer2"		  => $answer2,
					"answer3"		  => $answer3,
					"answer4"		  => $answer4,
					"correct_answer"  => $correct_answer,
					"status" 		  => 1
 				);
				//echo '<pre>';print_r($insertData);exit;
				$this->db->where('question_id', $question_id);
				if($this->db->update("feedback_question_bank", $updateArr)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Question Updated Successfully!');
					return true;
	
				}return false; 
		 }else{
			 $insertData=array(
					"product_id"	  => $product_id,
					"question_media_type"	  => $question_media_type,
					"question_type"	  => $question_type,
					"question"		  => $question,
					"answer1"	 	  => $answer1,
					"answer2"		  => $answer2,
					"answer3"		  => $answer3,
					"answer4"		  => $answer4,
					"correct_answer"  => $correct_answer,
					"status" 		  => 1
					 
					
				); //echo '<pre>';print_r($insertData);exit;
				if($this->db->insert("feedback_question_bank", $insertData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Question Added Successfully!');
					return true;
				}return false; 
		}
 }
		
		// Product Description Feedback Questions
		function feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product Description Feedback");
			$where = array('question_type ' => "Product Description Feedback" , 'product_id ' => $id);
			$this->db->where($where);
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			$where = array('question_type ' => "Product Description Feedback" , 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		// Product Image Feedback Questions
		function image_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product Image Feedback"); 
			//$where = array('question_type ' => "Product Image Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Product", 'question_media_type ' => "Image", 'product_id ' => $id);
			$this->db->where($where);
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_image_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			//$where = array('question_type ' => "Product Image Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Product", 'question_media_type ' => "Image", 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		// Product Video Feedback Questions
		function video_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product Video Feedback"); 
			//$where = array('question_type ' => "Product Video Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Product", 'question_media_type ' => "Video", 'product_id ' => $id);
			$this->db->where($where);
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_video_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			//$where = array('question_type ' => "Product Video Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Product", 'question_media_type ' => "Video", 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		
		// Product Audio Feedback Questions
		function audio_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product Audio Feedback");
			//$where = array('question_type ' => "Product Audio Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Product", 'question_media_type ' => "Audio", 'product_id ' => $id);
			$this->db->where($where);			
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_audio_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			//$where = array('question_type ' => "Product Audio Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Product", 'question_media_type ' => "Audio", 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		
		// Product PDF Feedback Questions
		function pdf_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product PDF Feedback"); 
			//$where = array('question_type ' => "Product PDF Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Product", 'question_media_type ' => "PDF", 'product_id ' => $id);
			$this->db->where($where);	
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_pdf_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			//$where = array('question_type ' => "Product PDF Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Product", 'question_media_type ' => "PDF", 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		
		// Product Push Ad Feedback Questions 
		function pushed_ad_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product PDF Feedback"); 
			//$where = array('question_type ' => "Product Pushed Ad Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Advertisement", 'product_id ' => $id);
			$this->db->where($where);	
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_pushed_ad_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			//$where = array('question_type ' => "Product Pushed Ad Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Advertisement", 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		
		// Product Survey Feedback Questions
		function survey_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product PDF Feedback"); 
			$where = array('question_type ' => "Survey" , 'product_id ' => $id);
			$this->db->where($where);	
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		
		function total_survey_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			$where = array('question_type ' => "Survey" , 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		
		// Product Demo Video Feedback Questions
		function demo_video_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product PDF Feedback"); 
			//$where = array('question_type ' => "Demonstration" , 'product_id ' => $id);
			$where = array('question_type ' => "Demonstration", 'question_media_type ' => "Video", 'product_id ' => $id);
			$this->db->where($where);	
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_demo_video_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			//$where = array('question_type ' => "Demonstration" , 'product_id ' => $id);
			$where = array('question_type ' => "Demonstration", 'question_media_type ' => "Video", 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		// Product Demo Audio Feedback Questions Starts
		function demo_audio_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product PDF Feedback"); 
			//$where = array('question_type ' => "Product ADemonstration Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Demonstration", 'question_media_type ' => "Audio", 'product_id ' => $id);
			$this->db->where($where);	
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_demo_audio_feedback_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			//$where = array('question_type ' => "Product ADemonstration Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "Demonstration", 'question_media_type ' => "Audio", 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		// Product Demo Audio Feedback Questions ends
		
		
				// Product  Referral response message Options Starts
		function product_referral_response_message_options_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product PDF Feedback"); 
			//$where = array('question_type ' => "Product ADemonstration Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "ProductReferralResponseMessage", 'product_id ' => $id);
			$this->db->where($where);	
			$this->db->order_by("question_id", " desc");
			$this->db->limit($limit, $start);
			$resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
			return $resultDt ;
		}
		function total_product_referral_response_message_options_listing($srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select('count(1) as total_rows');
			$this->db->from('feedback_question_bank');
			//$where = array('question_type ' => "Product ADemonstration Feedback" , 'product_id ' => $id);
			$where = array('question_type ' => "ProductReferralResponseMessage", 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		// Product  Referral response message Options ends
		
		function IsProductFeedback($pid,$qid='') {
			$rows 		= 0;
			$result 	= 'true';
			$this->db->select("id");
			$this->db->from("product_feedback_questions");
			$this->db->where(array("product_id"=> $pid,"question_id"=> $qid));
			//if(!empty($id)){
				//$this->db->where("id", $id);
			//}
			$q 		   = $this->db->get();
			$rows 	   = $q->num_rows();
			if($rows>0){
			  $result = 'false';
			} return $result;
		}
		
		function save_product_question($pid,$qid,$Chk){
 			if($Chk=='0'){
				$this->db->query("delete from product_feedback_questions where question_id='".$qid."' and  product_id='".$pid."' ");
				//echo $this->db->last_query();exit;
				return true;
			}else{
				$isExists=$this->IsProductFeedback($pid,$qid); 
				if($isExists=='false'){
					return false;
				}
				$insertData=array(
					"question_id"	 => $qid,
					"product_id"	 => $pid 
					);  
				if($this->db->insert("product_feedback_questions", $insertData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Question Added Successfully!');
					return true;
				}
			}
			return false; 
		}
		
	
	
	function list_registered_products_by_consumers($limit,$start,$srch_string=''){
		$resultData = 0;
 		$user_id 	= $this->session->userdata('admin_user_id');
		
		$srch_string = trim($srch_string);
        if ($user_id > 1) {
            //$this->db->where('created_by', $user_id);
            if (!empty($srch_string)) {
                $this->db->where("(PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%'  OR C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR PP.purchase_date LIKE '%$srch_string%') and (P.created_by=$user_id)");
            } else {
                $this->db->where(array('P.created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%'  OR C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR PP.purchase_date LIKE '%$srch_string%')");
            }
        }
		
		
 		$this->db->select('PP.*, C.*, P.product_name, P.product_sku, P.created_by, PP.status',false);
		$this->db->from('purchased_product PP');
		$this->db->join('consumers C', 'C.id = PP.consumer_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		if($user_id > 1){ 
			$this->db->where(array('P.created_by' => $user_id));
		}
   		$this->db->order_by('PP.create_date','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get();  //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
		
	function count_registered_products_by_consumers($srch_string=''){
		$result_data = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		
		$srch_string = trim($srch_string);
        if ($user_id > 1) {
            //$this->db->where('created_by', $user_id);
            if (!empty($srch_string)) {
                $this->db->where("(PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%'  OR C.user_name LIKE '%$srch_string%' OR PP.purchase_date LIKE '%$srch_string%') and (P.created_by=$user_id)");
            } else {
                $this->db->where(array('P.created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%'  OR C.user_name LIKE '%$srch_string%' OR PP.purchase_date LIKE '%$srch_string%')");
            }
        }
		
 		$this->db->select('count(1) as total_rows');
		$this->db->from('purchased_product PP');
		$this->db->join('consumers C', 'C.id = PP.consumer_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		if($user_id > 1){ 
			$this->db->where(array('P.created_by' => $user_id));
		}
 		
   		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 
	 function get_registered_products_by_consumers_details($id) {

        $this->db->select('*');
        $this->db->from('purchased_product');
        //$this->db->join('assign_plants_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('purchased_product_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	
	function update_registered_products_by_consumers($data) {
        $user_id = $this->session->userdata('admin_user_id');
			$id = $data['code_id'];
               // $this->db->set('profile_photo', $frmData['profile_photo']);
                $UpdateData = array(
                    
					"invoice" 				=> $data['invoice_number'],
					"purchase_date" 		=> $data['purchase_date'],
					"warranty_start_date" 	=> $data['warranty_start_date'],
					"warranty_end_date" 	=> $data['warranty_end_date'],
					"expiry_date" 			=> $data['expiry_date'],
					"status" 				=> $data['status'],
					"seller_name" 			=> $data['seller_name'],
					"seller_gst" 			=> $data['seller_gst'],
					"selling_price" 		=> $data['selling_price'],
					"vquery" 				=> $data['query'],
					"modified" 				=> date("Y-m-d H:i:s"),
					"discount" 				=> $data['discount']
                );
             
            $whereData = array(
                'purchased_product_id' => $id
            );

            $this->db->where('purchased_product_id', $id);
				if($this->db->update('purchased_product', $UpdateData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Verification Status Updated Successfully!');
					return true;
	
				}return false; 
        
    }
	
	function update_loyalty_redemption_requests($data) {
        $user_id = $this->session->userdata('admin_user_id');
			$id = $data['lr_id'];
               // $this->db->set('profile_photo', $frmData['profile_photo']);
                $UpdateData = array(
                    
					"coupon_number" 	=> $data['coupon_number'],
					"coupon_type" 		=> $data['coupon_type'],
					"coupon_vendor" 	=> $data['coupon_vendor'],
					"l_status" 			=> $data['l_status'],
					"status_change_date" 	=>date("Y-m-d H:i:s"),
					"courier_details" 		=> $data['courier_details'],
					"modified_at" 			=> date("Y-m-d H:i:s")
                );
             
			$whereData = array(
                'lr_id' => $id
					);

            $this->db->where('lr_id', $id);
				if($this->db->update('loyalty_redemption', $UpdateData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Status Updated Successfully!');
					return true;
	
				}return false; 
        
    }
	
	
		function update_loyalty_redemption_tracek_user_request($data) {
        $user_id = $this->session->userdata('admin_user_id');
			$id = $data['tr_lr_id'];
               // $this->db->set('profile_photo', $frmData['profile_photo']);
                $UpdateData = array(
                    
					"coupon_number" 	=> $data['coupon_number'],
					"coupon_type" 		=> $data['coupon_type'],
					///"coupon_vendor" 	=> $data['coupon_vendor'],
					"l_status" 			=> $data['l_status'],
					"status_change_date" 	=>date("Y-m-d H:i:s"),
					//"courier_details" 		=> $data['courier_details'],
					"modified_at" 			=> date("Y-m-d H:i:s")
                );
             
			$whereData = array(
                'tr_lr_id' => $id
					);

            $this->db->where('tr_lr_id', $id);
				if($this->db->update('tracek_loyalty_redemption', $UpdateData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Status Updated Successfully!');
					return true;
	
				}return false; 
        
    }
	
	function set_product_code_unregistered($data) {
        $user_id = $this->session->userdata('admin_user_id');
			$id = $data['code_id'];
		   $this->db->query("delete from purchased_product where purchased_product_id='".$id."'");
    }
	
	
	// ---
	function list_loyalty_redemption_requests($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
		//$result_data = 0;
		
		
		$srch_string = trim($srch_string);
        if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("LR.redemption_id LIKE '%$srch_string%' OR C.user_name LIKE '%$srch_string%'");
		}
		
 		$this->db->select('LR.*, C.*',false);
		$this->db->from('loyalty_redemption LR');
		$this->db->join('consumers C', 'C.id = LR.user_id');
		/* $this->db->join('products P', 'P.id = PP.product_id');
		if($user_id!=1){ 
			$this->db->where(array('P.created_by' => $user_id));
		} */
   		$this->db->order_by('LR.lr_id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get();  //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
		
	function count_loyalty_redemption_requests($srch_string=''){
		$result_data = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("LR.redemption_id LIKE '%$srch_string%' OR C.user_name LIKE '%$srch_string%'");
		}
		
 		$this->db->select('count(1) as total_rows');
		$this->db->from('loyalty_redemption LR');
		$this->db->join('consumers C', 'C.id = LR.user_id');
		//$this->db->join('consumers C', 'C.id = LR.user_id');
		/*
		$this->db->join('products P', 'P.id = PP.product_id');
		if($user_id!=1){ 
			$this->db->where(array('P.created_by' => $user_id));
		}
 		*/
   		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 
	 function details_loyalty_redemption_requests($id) {

        $this->db->select('*');
        $this->db->from('loyalty_redemption');
        //$this->db->join('assign_plants_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('lr_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	
	function details_loyalty_redemption_request_tracek_user($id) {
        $this->db->select('TLR.*, BU.*');
        $this->db->from('tracek_loyalty_redemption AS TLR');
        $this->db->join('backend_user AS BU', 'BU.user_id = TLR.tr_user_id');
        $this->db->where(array('TLR.tr_lr_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	function details_view_consumer_passbook($id) {

        $this->db->select('*');
        $this->db->from('consumer_passbook');
        //$this->db->join('assign_plants_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	
	
	
	
	
	
	public function sendFVPNotification($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array (
		        'to' => $id,
		         
		         'notification' => array('title' => 'TRUSTAT product Verification', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'TRUSTAT product Verification', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
		);
		$fields = json_encode ( $fields );
		
		$headers = array (
		        'Authorization: key=' . "AAAA4LpXTK8:APA91bHs48XoX1_-4CdsBVyAAVceqQFavfo6Hz3K1U5Phmz2OgYsX7Pr_bNuE8x_PGJBcWs08WHx0JTGh-6goN7ozfl3yB8z9bYe_2ayk0Nmlp9uYOknIKDwq9czlj10rRGQ1bDZ9Nlp", 'Content-Type: application/json'
		);
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		
		$result = curl_exec ( $ch );
		//curl_close ( $ch );
		return $result;
		}
		
		public function sendFBLRNotification($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array (
		        'to' => $id,
		         
		         'notification' => array('title' => 'TRUSTAT Product Verification', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'TRUSTAT Product Verification', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
		);
		$fields = json_encode ( $fields );
		
		$headers = array (
		        'Authorization: key=' . "AAAA4LpXTK8:APA91bHs48XoX1_-4CdsBVyAAVceqQFavfo6Hz3K1U5Phmz2OgYsX7Pr_bNuE8x_PGJBcWs08WHx0JTGh-6goN7ozfl3yB8z9bYe_2ayk0Nmlp9uYOknIKDwq9czlj10rRGQ1bDZ9Nlp", 'Content-Type: application/json'
		);
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		
		$result = curl_exec ( $ch );
		//curl_close ( $ch );
		return $result;
		}
		
		public function findCurrentBalanceByuserId1($consumer_id){
        //return $this->db->select('current_balance')->from('consumer_passbook')->where('consumer_id ="'.$userId.'"')->order_by('transaction_date',"desc")->limit(1)->get()->row();
    
	 //return $this->db->select('current_balance')->from('consumer_passbook')->where('consumer_id ="'.$userId.'"')->limit(1)->order_by('transaction_date','DESC')->get()->row();
	//$userId = 49;
			$this->db->select('current_balance');
			$this->db->from('consumer_passbook');
			$this->db->where('consumer_id', $consumer_id);
			$this->db->order_by('transaction_date','DESC');
			$this->db->limit(1);			
			$query = $this->db->get();
			$result = $query->result();
			return $result;
			}
			
			
	public function saveConsumerPassbookLoyalty1($transactionType = null,$consumer_id = null,$params = [],$transaction_lr_type = null,$points_redeemed = null){
       //sanjay
	   //$customer_id = $this->session->userdata('admin_user_id');
	   $TotalAccumulatedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>"TRUSTAT"))->get()->row();
		
	   $TotalRedeemedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>"TRUSTAT"))->get()->row();
		
		$TotalExpiredPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>"TRUSTAT"))->get()->row();	
		
		$FinalTotalAccumulatedPoints = $TotalAccumulatedPoints->points;
		$FinalTotalRedeemedPoints = $TotalRedeemedPoints->points + $points_redeemed;
		
		if(($TotalExpiredPoints->points)!='')
		{
			$FinalTotalExpiredPoints = $TotalExpiredPoints->points;
		} else {
			$FinalTotalExpiredPoints =0;
			}	
			
		$CurrentBalance = $FinalTotalAccumulatedPoints - ($FinalTotalRedeemedPoints + $FinalTotalExpiredPoints);
		//$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		
		$result2 = $this->db->select('*')->from('loylties')->where('id', 3)->get()->row();
		$result3 = $this->db->select('*')->from('loylties')->where('id', 4)->get()->row();
						
		$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		$Min_Locking_Balance = $result2->loyalty_points;
		
		$CurrentBalanceAfterMinBalanceLocking = $CurrentBalance - $Min_Locking_Balance;
		$Points_Redeemed_in_Multiple_of = $result3->loyalty_points;

		
		$remainder = $CurrentBalanceAfterMinBalanceLocking % $Points_Redeemed_in_Multiple_of;
		$quotient = ($CurrentBalanceAfterMinBalanceLocking - $remainder) / $Points_Redeemed_in_Multiple_of;

		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of-$remainder;
        
		$loyalty_points_expiry_days = loyalty_points_expiry_days($customer_id);
		$Current_Date = date('Y-m-d');
		$loyalty_points_expiry_date = date('Y-m-d', strtotime($Current_Date. ' + ' . $loyalty_points_expiry_days. ' days'));
		$FinalTotalRedeemedExpiredPoints = $FinalTotalRedeemedPoints + $FinalTotalExpiredPoints;
		$date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
       // $date->modify('+3    month');
        $input = [
            'customer_id' => 1,
			'consumer_id' => $consumer_id,
            'points' => $points_redeemed,
            'transaction_type_name' => "Loyalty Rewards redemption",
			'transaction_type_slug' => "loyalty_loints_redeemed",
            'product_id' => 0,
            'params' => json_encode($params),
            'transaction_lr_type' => $transaction_lr_type,
			'customer_loyalty_type' => "TRUSTAT",
			'total_accumulated_points' => $FinalTotalAccumulatedPoints,
			'total_redeemed_points' => $FinalTotalRedeemedExpiredPoints,
            'current_balance' => $CurrentBalance,
			'points_redeemable' => $Points_Redeemable,
			'points_short_of_redumption' => $PointsShortOfRedumption,
            'transaction_date' => $now,
            'loyalty_points_expiry_date' => $loyalty_points_expiry_date
        ];        
        return $this->db->insert('consumer_passbook',$input);
    }
	
	
	public function saveTracekUserPassbookLoyalty1($transactionType = null,$customer_a_user_id = null,$params = [],$transaction_lr_type = null,$points_redeemed = null){
       //sanjay
	   //$customer_id = $this->session->userdata('admin_user_id');
	   $TotalAccumulatedPoints = $this->db->select_sum('points')->from('customer_passbook')->where(array('customer_a_user_id'=>$customer_a_user_id, 'transaction_lr_type'=>"Loyalty"))->get()->row();
		
	   $TotalRedeemedPoints = $this->db->select_sum('points')->from('customer_passbook')->where(array('customer_a_user_id'=>$customer_a_user_id, 'transaction_lr_type'=>"Redemption"))->get()->row();
		
		//$TotalExpiredPoints = $this->db->select_sum('points')->from('customer_passbook')->where(array('customer_a_user_id'=>$customer_a_user_id, 'transaction_lr_type'=>"Expiry"))->get()->row();	
		
		$FinalTotalAccumulatedPoints = $TotalAccumulatedPoints->points;
		$FinalTotalRedeemedPoints = $TotalRedeemedPoints->points + $points_redeemed;
		$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		/*
		if(($TotalExpiredPoints->points)!='')
		{
			$FinalTotalExpiredPoints = $TotalExpiredPoints->points;
		} else {
			$FinalTotalExpiredPoints =0;
			}	
			*/
		//$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		//$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		
		/*
		$result2 = $this->db->select('*')->from('loylties')->where('id', 3)->get()->row();
		$result3 = $this->db->select('*')->from('loylties')->where('id', 4)->get()->row();
						
		
		$Min_Locking_Balance = $result2->loyalty_points;
		
		$CurrentBalanceAfterMinBalanceLocking = $CurrentBalance - $Min_Locking_Balance;
		$Points_Redeemed_in_Multiple_of = $result3->loyalty_points;

		
		$remainder = $CurrentBalanceAfterMinBalanceLocking % $Points_Redeemed_in_Multiple_of;
		$quotient = ($CurrentBalanceAfterMinBalanceLocking - $remainder) / $Points_Redeemed_in_Multiple_of;

		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of-$remainder;
        
		$loyalty_points_expiry_days = loyalty_points_expiry_days($customer_id);
		$Current_Date = date('Y-m-d');
		$loyalty_points_expiry_date = date('Y-m-d', strtotime($Current_Date. ' + ' . $loyalty_points_expiry_days. ' days'));
		*/
		//$FinalTotalRedeemedExpiredPoints = $FinalTotalRedeemedPoints + $FinalTotalExpiredPoints;
		$date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
       // $date->modify('+3    month');
        $input = [
            'parent_customer_id' => getUserParentIDById($customer_a_user_id),
			'customer_a_user_id' => $customer_a_user_id,
            'points' => $points_redeemed,
            'transaction_type_name' => "Tracek Loyalty redemption",
			'transaction_type_slug' => "loyalty_loints_redeemed",
            'product_id' => 0,
			'accumulated_points_by_transaction_type' => $points_redeemed,
            'params' => json_encode($params),
            'transaction_lr_type' => $transaction_lr_type,
			'customer_loyalty_type' => "TRUSTAT",
			'total_accumulated_points' => $FinalTotalAccumulatedPoints,
			'total_redeemed_points' => $FinalTotalRedeemedPoints,
            'current_balance' => $CurrentBalance,
			'points_redeemable' => $CurrentBalance,
			'points_short_of_redumption' => 0,
            'transaction_date' => $now,
            'loyalty_points_expiry_date' => $now
        ];
        
        return $this->db->insert('customer_passbook',$input);
    }
	
	
	public function findLoylityBySlug($transactionType = null){
        $items = [];
        if(empty($transactionType)){
           return false; 
        }
        $query = $this->db->get_where('loylties',['transaction_type_slug'=>$transactionType]);
        if( $query->num_rows() <= 0 ){
            return false;
        }else{
            return $query->row_array();
        }
    }
	
	/*
	public function findCurrentBalanceByuserId($userId){
        //return $this->db->select('current_balance')->from('consumer_passbook')->where('consumer_id ="'.$userId.'"')->order_by('transaction_date',"desc")->limit(1)->get()->row();
    
	 //return $this->db->select('current_balance')->from('consumer_passbook')->where('consumer_id ="'.$userId.'"')->limit(1)->order_by('transaction_date','DESC')->get()->row();
	//$userId = 49;
			$this->db->select('points');
			$this->db->from('consumer_passbook');
			//$this->db->where('consumer_id', $userId);
			$this->db->where(array('consumer_id'=>$userId, 'transaction_lr_type'=>"Loyalty"));
			$this->db->order_by('transaction_date','DESC');
			$this->db->limit(1);			
			$query = $this->db->get();
			$result = $query->result();
			return $result;
			}
			*/
	
	
	public function saveConsumerPassbookLoyalty($transactionType = null, $transactionTypeName = null,$ProductID = null,$consumer_id = null,$params = [], $customer_id = null, $transaction_lr_type = null){
        if( empty($transactionType) || empty($consumer_id) ){
            return false;
        }
        
		/*
       $loylty = $this->findLoylityBySlugAndProductID($transactionType,$ProductID);
        if(empty($loylty)){
            return false;
        }
		*/
		
		
		
	    $customer_loyalty_type = get_customer_loyalty_type_by_customer_id($customer_id);
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result->$transactionType;
		
		if($customer_loyalty_type=="Brand"){
		$TotalAccumulatedPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalAccumulatedPoints = $TotalAccumulatedPointsBrand->points;
		
		$TotalRedeemedPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalRedeemedPoints = $TotalRedeemedPointsBrand->points;
		
		$TotalExpiredPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalExpiredPoints = $TotalExpiredPointsBrand->points;
		
			} else {
		$TotalAccumulatedPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalAccumulatedPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();		
		$TotalAccumulatedPoints = $TotalAccumulatedPointsCustomer->points + $TotalAccumulatedPointsISPL->points;
		
		$TotalRedeemedPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalRedeemedPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();
		$TotalRedeemedPoints = $TotalRedeemedPointsCustomer->points + $TotalRedeemedPointsISPL->points;
		
		$TotalExpiredPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalExpiredPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();
		$TotalExpiredPoints = $TotalExpiredPointsCustomer->points + $TotalExpiredPointsISPL->points;
		}
		
		$FinalTotalAccumulatedPoints = ($TotalAccumulatedPoints) + $TRPoints;
			
		if(($TotalRedeemedPoints)!='')
		{
			$FinalTotalRedeemedPoints = $TotalRedeemedPoints;
		} else {
			$FinalTotalRedeemedPoints =0;
			}
		
		
		/*
		$TotalAccumulatedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$userId, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalRedeemedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$userId, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		
		$FinalTotalAccumulatedPoints = ($TotalAccumulatedPoints->points) + $TRPoints;
		
		if(($TotalRedeemedPoints->points)!='')
		{
			$FinalTotalRedeemedPoints = $TotalRedeemedPoints->points;
		} else {
			$FinalTotalRedeemedPoints =0;
			}
		*/	
			
		$result2 = $this->db->select('*')->from('loylties')->where('id', 3)->get()->row();
		$result3 = $this->db->select('*')->from('loylties')->where('id', 4)->get()->row();
		
		if(($TotalExpiredPoints)!='')
		{
			$FinalTotalExpiredPoints = $TotalExpiredPoints;
		} else {
			$FinalTotalExpiredPoints =0;
			}	
			
		$CurrentBalance = $FinalTotalAccumulatedPoints - ($FinalTotalRedeemedPoints + $FinalTotalExpiredPoints);
			
		//$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		$Min_Locking_Balance = $result2->loyalty_points;
		
		$CurrentBalanceAfterMinBalanceLocking = $CurrentBalance - $Min_Locking_Balance;
		$Points_Redeemed_in_Multiple_of = $result3->loyalty_points;
				
		$remainder = $CurrentBalanceAfterMinBalanceLocking % $Points_Redeemed_in_Multiple_of;
		$quotient = ($CurrentBalanceAfterMinBalanceLocking - $remainder) / $Points_Redeemed_in_Multiple_of;
		/*
		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of - $remainder;
		*/
		if($customer_loyalty_type=="TRUSTAT"){
		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;		
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of - $remainder;
		}else{
		$Points_Redeemable = $CurrentBalance;		
		$PointsShortOfRedumption = 0;	
		}
		
				
		$loyalty_points_expiry_days = loyalty_points_expiry_days($customer_id);
		$Current_Date = date('Y-m-d');
		$loyalty_points_expiry_date = date('Y-m-d', strtotime($Current_Date. ' + ' . $loyalty_points_expiry_days. ' days'));
		$FinalTotalRedeemedExpiredPoints = $FinalTotalRedeemedPoints + $FinalTotalExpiredPoints;
		$date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
       // $date->modify('+3    month');
	   
			$TRLRC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 6)->get()->row();
			$TRLRC_billin_particular_name = $TRLRC_result->billin_particular_name;
			$TRLRC_billin_particular_slug = $TRLRC_result->billin_particular_slug;
			
			$TRLRCData['customer_id'] = $customer_id;
			$TRLRCData['consumer_id'] = $consumer_id;
			$TRLRCData['billing_particular_name'] = $TRLRC_billin_particular_name.' '.$transactionTypeName;		
			$TRLRCData['billing_particular_slug'] = $TRLRC_billin_particular_slug.'_'.$transactionType;
			$TRLRCData['trans_quantity'] = $TRPoints; 
			$TRLRCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRLRCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRLRCData);
			
        $input = [
            'customer_id' => $customer_id,
			'consumer_id' => $consumer_id,
			'promotion_id' => var_dump($Probj->promotion_id),
            'points' => $TRPoints,
            'transaction_type_name' => $transactionTypeName,
			'transaction_type_slug' => $transactionType,
			'product_id' => $ProductID,
            'params' => json_encode($params),
            'transaction_lr_type' => $transaction_lr_type,
			'customer_loyalty_type' => get_customer_loyalty_type_by_customer_id($customer_id),
			'total_accumulated_points' => $FinalTotalAccumulatedPoints,
			'total_redeemed_points' => $FinalTotalRedeemedExpiredPoints,
            'current_balance' => $CurrentBalance,
			'points_redeemable' => $Points_Redeemable,
			'points_short_of_redumption' => $PointsShortOfRedumption,
            'transaction_date' => $now,
            'loyalty_points_expiry_date' => $loyalty_points_expiry_date
        ];
        
        return $this->db->insert('consumer_passbook',$input);
		
    }
	
	function list_all_consumers($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id==1){
			if(!empty($srch_string)){ 
 			$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%' OR city_last_scan LIKE '%$srch_string%' OR gender LIKE '%$srch_string%' OR dob LIKE '%$srch_string%' OR registration_address LIKE '%$srch_string%' OR alternate_mobile_no LIKE '%$srch_string%' OR street_address LIKE '%$srch_string%' OR city LIKE '%$srch_string%' OR state LIKE '%$srch_string%' OR pin_code LIKE '%$srch_string%' OR monthly_earnings LIKE '%$srch_string%' OR job_profile LIKE '%$srch_string%' OR education_qualification LIKE '%$srch_string%' OR type_vehicle LIKE '%$srch_string%' OR profession LIKE '%$srch_string%' OR marital_status LIKE '%$srch_string%' OR no_of_family_members LIKE '%$srch_string%' OR loan_car_housing LIKE '%$srch_string%' OR personal_loan LIKE '%$srch_string%' OR credit_card_loan LIKE '%$srch_string%' OR own_a_car LIKE '%$srch_string%' OR house_type LIKE '%$srch_string%' OR last_location LIKE '%$srch_string%' OR life_insurance LIKE '%$srch_string%' OR medical_insurance LIKE '%$srch_string%' OR height_in_inches LIKE '%$srch_string%' OR weight_in_kg LIKE '%$srch_string%' OR hobbies LIKE '%$srch_string%' OR sports LIKE '%$srch_string%' OR entertainment LIKE '%$srch_string%' OR spouse_gender LIKE '%$srch_string%' OR spouse_phone LIKE '%$srch_string%' OR spouse_dob LIKE '%$srch_string%' OR marriage_anniversary LIKE '%$srch_string%' OR spouse_work_status LIKE '%$srch_string%' OR spouse_edu_qualification LIKE '%$srch_string%' OR spouse_monthly_income LIKE '%$srch_string%' OR spouse_loan LIKE '%$srch_string%' OR spouse_personal_loan LIKE '%$srch_string%' OR spouse_credit_card_loan LIKE '%$srch_string%' OR spouse_own_a_car LIKE '%$srch_string%' OR spouse_house_type LIKE '%$srch_string%' OR spouse_height_inches LIKE '%$srch_string%' OR spouse_weight_kg LIKE '%$srch_string%' OR spouse_hobbies LIKE '%$srch_string%' OR spouse_sports LIKE '%$srch_string%' OR spouse_entertainment LIKE '%$srch_string%' OR modified_at LIKE '%$srch_string%'");
			}	
		}else{
			if(!empty($srch_string)){  			
			$this->db->where("C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR C.email LIKE '%$srch_string%' OR C.city_last_scan LIKE '%$srch_string%' OR C.gender LIKE '%$srch_string%' OR C.dob LIKE '%$srch_string%' OR C.registration_address LIKE '%$srch_string%' OR C.alternate_mobile_no LIKE '%$srch_string%' OR C.street_address LIKE '%$srch_string%' OR C.city LIKE '%$srch_string%' OR C.state LIKE '%$srch_string%' OR C.pin_code LIKE '%$srch_string%' OR C.monthly_earnings LIKE '%$srch_string%' OR C.job_profile LIKE '%$srch_string%' OR C.education_qualification LIKE '%$srch_string%' OR C.type_vehicle LIKE '%$srch_string%' OR C.profession LIKE '%$srch_string%' OR C.marital_status LIKE '%$srch_string%' OR C.no_of_family_members LIKE '%$srch_string%' OR C.loan_car_housing LIKE '%$srch_string%' OR C.personal_loan LIKE '%$srch_string%' OR C.credit_card_loan LIKE '%$srch_string%' OR C.own_a_car LIKE '%$srch_string%' OR C.house_type LIKE '%$srch_string%' OR C.last_location LIKE '%$srch_string%' OR C.life_insurance LIKE '%$srch_string%' OR C.medical_insurance LIKE '%$srch_string%' OR C.height_in_inches LIKE '%$srch_string%' OR C.weight_in_kg LIKE '%$srch_string%' OR C.hobbies LIKE '%$srch_string%' OR C.sports LIKE '%$srch_string%' OR C.entertainment LIKE '%$srch_string%' OR C.spouse_gender LIKE '%$srch_string%' OR C.spouse_phone LIKE '%$srch_string%' OR C.spouse_dob LIKE '%$srch_string%' OR C.marriage_anniversary LIKE '%$srch_string%' OR C.spouse_work_status LIKE '%$srch_string%' OR C.spouse_edu_qualification LIKE '%$srch_string%' OR C.spouse_monthly_income LIKE '%$srch_string%' OR C.spouse_loan LIKE '%$srch_string%' OR C.spouse_personal_loan LIKE '%$srch_string%' OR C.spouse_credit_card_loan LIKE '%$srch_string%' OR C.spouse_own_a_car LIKE '%$srch_string%' OR C.spouse_house_type LIKE '%$srch_string%' OR C.spouse_height_inches LIKE '%$srch_string%' OR C.spouse_weight_kg LIKE '%$srch_string%' OR C.spouse_hobbies LIKE '%$srch_string%' OR C.spouse_sports LIKE '%$srch_string%' OR C.spouse_entertainment LIKE '%$srch_string%' OR C.modified_at LIKE '%$srch_string%'");
			}
		}
		if($user_id==1){
		$this->db->select("*");
		$this->db->from("consumers");
		} else {		
		$this->db->select('C.*');	
		$this->db->from('consumers C');		
		$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		//$this->db->where('CCL.customer_id', $user_id);
		$this->db->where(array('CCL.customer_id' => $user_id, 'CCL.registration_status' => "Registered"));
		$this->db->order_by("C.id", "DESC");		
		}		
		//$this->db->group_by("C.id");
		$this->db->order_by("id", "DESC");
		// $this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function total_all_concumers($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($customer_id)){ 
			
			if(!empty($srch_string)){ 
 				$this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%') and (created_by=$customer_id)");
			}else{
				$this->db->where(array('created_by'=>$customer_id));
			}
			
			}else{
				if(!empty($srch_string)){ 
 				$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%'");
			}else{
				//$this->db->where(array('created_by'=>$customer_id));
			}
			}
				
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%' OR city_last_scan LIKE '%$srch_string%' OR gender LIKE '%$srch_string%' OR dob LIKE '%$srch_string%' OR registration_address LIKE '%$srch_string%' OR alternate_mobile_no LIKE '%$srch_string%' OR street_address LIKE '%$srch_string%' OR city LIKE '%$srch_string%' OR state LIKE '%$srch_string%' OR pin_code LIKE '%$srch_string%' OR monthly_earnings LIKE '%$srch_string%' OR job_profile LIKE '%$srch_string%' OR education_qualification LIKE '%$srch_string%' OR type_vehicle LIKE '%$srch_string%' OR profession LIKE '%$srch_string%' OR marital_status LIKE '%$srch_string%' OR no_of_family_members LIKE '%$srch_string%' OR loan_car_housing LIKE '%$srch_string%' OR personal_loan LIKE '%$srch_string%' OR credit_card_loan LIKE '%$srch_string%' OR own_a_car LIKE '%$srch_string%' OR house_type LIKE '%$srch_string%' OR last_location LIKE '%$srch_string%' OR life_insurance LIKE '%$srch_string%' OR medical_insurance LIKE '%$srch_string%' OR height_in_inches LIKE '%$srch_string%' OR weight_in_kg LIKE '%$srch_string%' OR hobbies LIKE '%$srch_string%' OR sports LIKE '%$srch_string%' OR entertainment LIKE '%$srch_string%' OR spouse_gender LIKE '%$srch_string%' OR spouse_phone LIKE '%$srch_string%' OR spouse_dob LIKE '%$srch_string%' OR marriage_anniversary LIKE '%$srch_string%' OR spouse_work_status LIKE '%$srch_string%' OR spouse_edu_qualification LIKE '%$srch_string%' OR spouse_monthly_income LIKE '%$srch_string%' OR spouse_loan LIKE '%$srch_string%' OR spouse_personal_loan LIKE '%$srch_string%' OR spouse_credit_card_loan LIKE '%$srch_string%' OR spouse_own_a_car LIKE '%$srch_string%' OR spouse_house_type LIKE '%$srch_string%' OR spouse_height_inches LIKE '%$srch_string%' OR spouse_weight_kg LIKE '%$srch_string%' OR spouse_hobbies LIKE '%$srch_string%' OR spouse_sports LIKE '%$srch_string%' OR spouse_entertainment LIKE '%$srch_string%' OR modified_at LIKE '%$srch_string%'");
			}
		}
		
		
		
		if($user_id==1){
		$this->db->select('count(1) as total_rows');
		$this->db->from("consumers");
		} else {
		
		$this->db->select('C.*');	
		$this->db->from('consumers C');		
		$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		//$this->db->where('CCL.customer_id', $user_id);	
		$this->db->where(array('CCL.customer_id' => $user_id, 'CCL.registration_status' => "Registered"));		
		}		
		//$this->db->group_by("C.id");
		//$this->db->order_by("C.id", "DESC");
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	
	function list_consumers_as_per_selection_criterias($limit,$start,$srch_string='') {
		//$user_id = $this->session->userdata('admin_user_id');
		$unique_system_selection_criteria_id = $this->uri->segment(3);
		$customer_id 	= $this->session->userdata('admin_user_id');
		/*
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($customer_id)){ 
			
			if(!empty($srch_string)){ 
 				$this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%') and (created_by=$customer_id)");
			}else{
				$this->db->where(array('created_by'=>$customer_id));
			}
			
			}else{
				if(!empty($srch_string)){ 
 				$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%'");
			}else{
				//$this->db->where(array('created_by'=>$customer_id));
			}
			}
				
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%' OR city_last_scan LIKE '%$srch_string%' OR gender LIKE '%$srch_string%' OR dob LIKE '%$srch_string%' OR registration_address LIKE '%$srch_string%' OR alternate_mobile_no LIKE '%$srch_string%' OR street_address LIKE '%$srch_string%' OR city LIKE '%$srch_string%' OR state LIKE '%$srch_string%' OR pin_code LIKE '%$srch_string%' OR monthly_earnings LIKE '%$srch_string%' OR job_profile LIKE '%$srch_string%' OR education_qualification LIKE '%$srch_string%' OR type_vehicle LIKE '%$srch_string%' OR profession LIKE '%$srch_string%' OR marital_status LIKE '%$srch_string%' OR no_of_family_members LIKE '%$srch_string%' OR loan_car_housing LIKE '%$srch_string%' OR personal_loan LIKE '%$srch_string%' OR credit_card_loan LIKE '%$srch_string%' OR own_a_car LIKE '%$srch_string%' OR house_type LIKE '%$srch_string%' OR last_location LIKE '%$srch_string%' OR life_insurance LIKE '%$srch_string%' OR medical_insurance LIKE '%$srch_string%' OR height_in_inches LIKE '%$srch_string%' OR weight_in_kg LIKE '%$srch_string%' OR hobbies LIKE '%$srch_string%' OR sports LIKE '%$srch_string%' OR entertainment LIKE '%$srch_string%' OR spouse_gender LIKE '%$srch_string%' OR spouse_phone LIKE '%$srch_string%' OR spouse_dob LIKE '%$srch_string%' OR marriage_anniversary LIKE '%$srch_string%' OR spouse_work_status LIKE '%$srch_string%' OR spouse_edu_qualification LIKE '%$srch_string%' OR spouse_monthly_income LIKE '%$srch_string%' OR spouse_loan LIKE '%$srch_string%' OR spouse_personal_loan LIKE '%$srch_string%' OR spouse_credit_card_loan LIKE '%$srch_string%' OR spouse_own_a_car LIKE '%$srch_string%' OR spouse_house_type LIKE '%$srch_string%' OR spouse_height_inches LIKE '%$srch_string%' OR spouse_weight_kg LIKE '%$srch_string%' OR spouse_hobbies LIKE '%$srch_string%' OR spouse_sports LIKE '%$srch_string%' OR spouse_entertainment LIKE '%$srch_string%' OR modified_at LIKE '%$srch_string%'");
			}
		}
		*/
		
		/*
	$this->db->select('*');
    $this->db->where('criteria_id', $criteria_id);
    $this->db->limit(1);// only apply if you have more than same id in your table othre wise comment this line
    $query1 = $this->db->get('consumer_selection_criteria');
    $row = $query1->row();
	*/

		$this->db->select('C.*, CCL.*');		
		$this->db->from('consumers C');		
		$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		//$this->db->where('CCL.customer_id', $customer_id);
		$this->db->where(array('CCL.customer_id' => $customer_id, 'CCL.registration_status' => "Registered"));
		$this->db->group_by("C.id");
		$this->db->order_by("C.id", "DESC");		
		//sanjay2
		$query = $this->db->query("SELECT * FROM consumer_selection_criteria WHERE unique_system_selection_criteria_id =  '$unique_system_selection_criteria_id'");
		$row = $query->row();
		//$row->item_id
		
		//$this->db->where('CCL.customer_id', $customer_id);
		$this->db->where(array('CCL.customer_id' => $customer_id, 'CCL.registration_status' => "Registered"));
		
		if($row->consumer_gender!='all') {
		$this->db->where('C.gender', $row->consumer_gender);
			}
		if($row->consumer_city!='all') {
		$this->db->where('C.city_last_scan', $row->consumer_city);
			}
			
		if($row->city_registration!='all') {
		$this->db->where('C.registration_city', $row->city_registration);
			}
			
		//if($row->city_registration!='all') { $this->db->where('C.registration_city', $row->city_registration); }	
		if($row->consumer_age_option=='SpecifyAge') {
		$consumer_min_dob = date('Y-m-d', strtotime('-' . $row->consumer_min_age . ' years'));
		$consumer_max_dob = date('Y-m-d', strtotime('-' . $row->consumer_max_age . ' years'));
		
		if(!empty($row->consumer_max_age)){ 
		$this->db->where('C.dob >=', $consumer_max_dob);
		//$this->db->or_where('C.dob =', 'NULL');
			}
		if(!empty($row->consumer_min_age)){ 
		$this->db->where('C.dob <=', $consumer_min_dob);
		//$this->db->or_where('C.dob =', 'NULL');
			}
		}
			/*
			$arr = explode(' ',trim($earned_loyalty_points_clubbed));
			$ELP_from = $arr[0];
			$ELP_to = $arr[2];			
			if($earned_loyalty_points_clubbed!='all') { 
			$this->db->where('C.total_accumulated_points BETWEEN "'. $ELP_from . '" and "'. $ELP_to .'"');
				}
			*/
			$arr1 = explode(' ',trim($row->monthly_earnings));
			$ME_from = $arr1[0];
			$ME_to = $arr1[2];			
			if($row->monthly_earnings!='all') { $this->db->where('C.monthly_earnings BETWEEN "'. $ME_from . '" and "'. $ME_to .'"');}	
						
			if($row->job_profile!='all') { $this->db->where('C.job_profile', $row->job_profile); }
			if($row->education_qualification!='all') { $this->db->where('C.education_qualification', $row->education_qualification); }
			if($row->type_vehicle!='all') { $this->db->where('C.type_vehicle', $row->type_vehicle); }
			if($row->profession!='all') { $this->db->where('C.profession', $row->profession); }
			if($row->marital_status!='all') { $this->db->where('C.marital_status', $row->marital_status); }
			if($row->no_of_family_members!='all') { $this->db->where('C.no_of_family_members', $row->no_of_family_members); }
			if($row->loan_car!='all') { $this->db->where('C.loan_car', $row->loan_car); }
			if($row->loan_housing!='all') { $this->db->where('C.loan_housing', $row->loan_housing); }
			if($row->personal_loan!='all') { $this->db->where('C.personal_loan', $row->personal_loan); }
			if($row->credit_card_loan!='all') { $this->db->where('C.credit_card_loan', $row->credit_card_loan); }
			if($row->own_a_car!='all') { $this->db->where('C.own_a_car', $row->own_a_car); }
			if($row->house_type!='all') { $this->db->where('C.house_type', $row->house_type); }
			if($row->last_location!='all') { $this->db->where('C.last_location', $row->last_location); }
			if($row->life_insurance!='all') { $this->db->where('C.life_insurance', $row->life_insurance); }
			if($row->medical_insurance!='all') { $this->db->where('C.medical_insurance', $row->medical_insurance); }
			if($row->height_in_inches!='all') { $this->db->where('C.height_in_inches', $row->height_in_inches); }
			if($row->weight_in_kg!='all') { $this->db->where('C.weight_in_kg', $row->weight_in_kg); }
			if($row->hobbies!='all') { $this->db->where('C.hobbies', $row->hobbies); }
			if($row->sports!='all') { $this->db->where('C.sports', $row->sports); }
			if($row->entertainment!='all') { $this->db->where('C.entertainment', $row->entertainment); }
			if($row->spouse_gender!='all') { $this->db->where('C.spouse_gender', $row->spouse_gender); }
			if($row->spouse_phone!='all') { $this->db->where('C.spouse_phone', $row->spouse_phone); }
			if($row->spouse_dob!='all') { $this->db->where('C.spouse_dob', $row->spouse_dob); }
			if($row->marriage_anniversary!='all') { $this->db->where('C.marriage_anniversary', $row->marriage_anniversary); }
			if($row->spouse_work_status!='all') { $this->db->where('C.spouse_work_status', $row->spouse_work_status); }
			if($row->spouse_edu_qualification!='all') { $this->db->where('C.spouse_edu_qualification', $row->spouse_edu_qualification); }
			if($row->spouse_monthly_income!='all') { $this->db->where('C.spouse_monthly_income', $row->spouse_monthly_income); }
			if($row->spouse_loan!='all') { $this->db->where('C.spouse_loan', $row->spouse_loan); }
			if($row->spouse_personal_loan!='all') { $this->db->where('C.spouse_personal_loan', $row->spouse_personal_loan); }
			if($row->spouse_credit_card_loan!='all') { $this->db->where('C.spouse_credit_card_loan', $row->spouse_credit_card_loan); }
			if($row->spouse_own_a_car!='all') { $this->db->where('C.spouse_own_a_car', $row->spouse_own_a_car); }
			if($row->spouse_house_type!='all') { $this->db->where('C.spouse_house_type', $row->spouse_house_type); }
			if($row->spouse_height_inches!='all') { $this->db->where('C.spouse_height_inches', $row->spouse_height_inches); }
			if($row->spouse_weight_kg!='all') { $this->db->where('C.spouse_weight_kg', $row->spouse_weight_kg); }
			if($row->spouse_hobbies!='all') { $this->db->where('C.spouse_hobbies', $row->spouse_hobbies); }
			if($row->spouse_sports!='all') { $this->db->where('C.spouse_sports', $row->spouse_sports); }
			if($row->spouse_entertainment!='all') { $this->db->where('C.spouse_entertainment', $row->spouse_entertainment); }
			if($row->field_1!='all') { $this->db->where('C.field_1', $row->field_1); }
			if($row->field_2!='all') { $this->db->where('C.field_2', $row->field_2); }
			if($row->field_3!='all') { $this->db->where('C.field_3', $row->field_3); }
			if($row->field_4!='all') { $this->db->where('C.field_4', $row->field_4); }
			if($row->field_5!='all') { $this->db->where('C.field_5', $row->field_5); }
			if($row->field_6!='all') { $this->db->where('C.field_6', $row->field_6); }
			if($row->field_7!='all') { $this->db->where('C.field_7', $row->field_7); }
			if($row->field_8!='all') { $this->db->where('C.field_8', $row->field_8); }
			if($row->field_9!='all') { $this->db->where('C.field_9', $row->field_9); }
			if($row->field_10!='all') { $this->db->where('C.field_10', $row->field_10); }
			if($row->field_11!='all') { $this->db->where('C.field_11', $row->field_11); }
			if($row->field_12!='all') { $this->db->where('C.field_12', $row->field_12); }
			if($row->field_13!='all') { $this->db->where('C.field_13', $row->field_13); }
			if($row->field_14!='all') { $this->db->where('C.field_14', $row->field_14); }
			if($row->field_15!='all') { $this->db->where('C.field_15', $row->field_15); }
			if($row->field_16!='all') { $this->db->where('C.field_16', $row->field_16); }
			if($row->field_17!='all') { $this->db->where('C.field_17', $row->field_17); }
			if($row->field_18!='all') { $this->db->where('C.field_18', $row->field_18); }
			if($row->field_19!='all') { $this->db->where('C.field_19', $row->field_19); }
			if($row->field_20!='all') { $this->db->where('C.field_20', $row->field_20); }
			if($row->field_21!='all') { $this->db->where('C.field_21', $row->field_21); }
			if($row->field_22!='all') { $this->db->where('C.field_22', $row->field_22); }
			if($row->field_23!='all') { $this->db->where('C.field_23', $row->field_23); }
			if($row->field_24!='all') { $this->db->where('C.field_24', $row->field_24); }
			if($row->field_25!='all') { $this->db->where('C.field_25', $row->field_25); }
			if($row->field_26!='all') { $this->db->where('C.field_26', $row->field_26); }
			if($row->field_27!='all') { $this->db->where('C.field_27', $row->field_27); }
			if($row->field_28!='all') { $this->db->where('C.field_28', $row->field_28); }
			if($row->field_29!='all') { $this->db->where('C.field_29', $row->field_29); }
			if($row->field_30!='all') { $this->db->where('C.field_30', $row->field_30); }
			if($row->field_31!='all') { $this->db->where('C.field_31', $row->field_31); }
			if($row->field_32!='all') { $this->db->where('C.field_32', $row->field_32); }
			if($row->field_33!='all') { $this->db->where('C.field_33', $row->field_33); }
			if($row->field_34!='all') { $this->db->where('C.field_34', $row->field_34); }
			if($row->field_35!='all') { $this->db->where('C.field_35', $row->field_35); }
			if($row->field_36!='all') { $this->db->where('C.field_36', $row->field_36); }
			if($row->field_37!='all') { $this->db->where('C.field_37', $row->field_37); }
			if($row->field_38!='all') { $this->db->where('C.field_38', $row->field_38); }
			if($row->field_39!='all') { $this->db->where('C.field_39', $row->field_39); }
			if($row->field_40!='all') { $this->db->where('C.field_40', $row->field_40); }
			if($row->field_41!='all') { $this->db->where('C.field_41', $row->field_41); }
			if($row->field_42!='all') { $this->db->where('C.field_42', $row->field_42); }
			if($row->field_43!='all') { $this->db->where('C.field_43', $row->field_43); }
			if($row->field_44!='all') { $this->db->where('C.field_44', $row->field_44); }
			if($row->field_45!='all') { $this->db->where('C.field_45', $row->field_45); }
			if($row->field_46!='all') { $this->db->where('C.field_46', $row->field_46); }
			if($row->field_47!='all') { $this->db->where('C.field_47', $row->field_47); }
			if($row->field_48!='all') { $this->db->where('C.field_48', $row->field_48); }
			if($row->field_49!='all') { $this->db->where('C.field_49', $row->field_49); }
			if($row->field_50!='all') { $this->db->where('C.field_50', $row->field_50); }
			if($row->field_51!='all') { $this->db->where('C.field_51', $row->field_51); }
			if($row->field_52!='all') { $this->db->where('C.field_52', $row->field_52); }
			if($row->field_53!='all') { $this->db->where('C.field_53', $row->field_53); }
			if($row->field_54!='all') { $this->db->where('C.field_54', $row->field_54); }
			if($row->field_55!='all') { $this->db->where('C.field_55', $row->field_55); }
			if($row->field_56!='all') { $this->db->where('C.field_56', $row->field_56); }
			if($row->field_57!='all') { $this->db->where('C.field_57', $row->field_57); }
			if($row->field_58!='all') { $this->db->where('C.field_58', $row->field_58); }
			if($row->field_59!='all') { $this->db->where('C.field_59', $row->field_59); }
			if($row->field_60!='all') { $this->db->where('C.field_60', $row->field_60); }
			if($row->field_61!='all') { $this->db->where('C.field_61', $row->field_61); }
			if($row->field_62!='all') { $this->db->where('C.field_62', $row->field_62); }
			if($row->field_63!='all') { $this->db->where('C.field_63', $row->field_63); }
			if($row->field_64!='all') { $this->db->where('C.field_64', $row->field_64); }
			if($row->field_65!='all') { $this->db->where('C.field_65', $row->field_65); }
			if($row->field_66!='all') { $this->db->where('C.field_66', $row->field_66); }
			if($row->field_67!='all') { $this->db->where('C.field_67', $row->field_67); }
			if($row->field_68!='all') { $this->db->where('C.field_68', $row->field_68); }
			if($row->field_69!='all') { $this->db->where('C.field_69', $row->field_69); }
			if($row->field_70!='all') { $this->db->where('C.field_70', $row->field_70); }
			if($row->field_71!='all') { $this->db->where('C.field_71', $row->field_71); }
			if($row->field_72!='all') { $this->db->where('C.field_72', $row->field_72); }
			if($row->field_73!='all') { $this->db->where('C.field_73', $row->field_73); }
			if($row->field_74!='all') { $this->db->where('C.field_74', $row->field_74); }
			if($row->field_75!='all') { $this->db->where('C.field_75', $row->field_75); }
			if($row->field_76!='all') { $this->db->where('C.field_76', $row->field_76); }
			if($row->field_77!='all') { $this->db->where('C.field_77', $row->field_77); }
			if($row->field_78!='all') { $this->db->where('C.field_78', $row->field_78); }
			if($row->field_79!='all') { $this->db->where('C.field_79', $row->field_79); }
			if($row->field_80!='all') { $this->db->where('C.field_80', $row->field_80); }
			if($row->field_81!='all') { $this->db->where('C.field_81', $row->field_81); }
			if($row->field_82!='all') { $this->db->where('C.field_82', $row->field_82); }
			if($row->field_83!='all') { $this->db->where('C.field_83', $row->field_83); }
			if($row->field_84!='all') { $this->db->where('C.field_84', $row->field_84); }
			if($row->field_85!='all') { $this->db->where('C.field_85', $row->field_85); }
			if($row->field_86!='all') { $this->db->where('C.field_86', $row->field_86); }
			if($row->field_87!='all') { $this->db->where('C.field_87', $row->field_87); }
			if($row->field_88!='all') { $this->db->where('C.field_88', $row->field_88); }
			if($row->field_89!='all') { $this->db->where('C.field_89', $row->field_89); }
			if($row->field_90!='all') { $this->db->where('C.field_90', $row->field_90); }
			if($row->field_91!='all') { $this->db->where('C.field_91', $row->field_91); }
			if($row->field_92!='all') { $this->db->where('C.field_92', $row->field_92); }
			if($row->field_93!='all') { $this->db->where('C.field_93', $row->field_93); }
			if($row->field_94!='all') { $this->db->where('C.field_94', $row->field_94); }
			if($row->field_95!='all') { $this->db->where('C.field_95', $row->field_95); }
			if($row->field_96!='all') { $this->db->where('C.field_96', $row->field_96); }
			if($row->field_97!='all') { $this->db->where('C.field_97', $row->field_97); }
			if($row->field_98!='all') { $this->db->where('C.field_98', $row->field_98); }
			if($row->field_99!='all') { $this->db->where('C.field_99', $row->field_99); }
			if($row->field_100!='all') { $this->db->where('C.field_100', $row->field_100); }
			if($row->field_101!='all') { $this->db->where('C.field_101', $row->field_101); }
			if($row->field_102!='all') { $this->db->where('C.field_102', $row->field_102); }
			if($row->field_103!='all') { $this->db->where('C.field_103', $row->field_103); }
			if($row->field_104!='all') { $this->db->where('C.field_104', $row->field_104); }
			if($row->field_105!='all') { $this->db->where('C.field_105', $row->field_105); }
			if($row->field_106!='all') { $this->db->where('C.field_106', $row->field_106); }
			if($row->field_107!='all') { $this->db->where('C.field_107', $row->field_107); }
			if($row->field_108!='all') { $this->db->where('C.field_108', $row->field_108); }
			if($row->field_109!='all') { $this->db->where('C.field_109', $row->field_109); }
			if($row->field_110!='all') { $this->db->where('C.field_110', $row->field_110); }
			if($row->field_111!='all') { $this->db->where('C.field_111', $row->field_111); }
			if($row->field_112!='all') { $this->db->where('C.field_112', $row->field_112); }
			if($row->field_113!='all') { $this->db->where('C.field_113', $row->field_113); }
			if($row->field_114!='all') { $this->db->where('C.field_114', $row->field_114); }
			if($row->field_115!='all') { $this->db->where('C.field_115', $row->field_115); }
			if($row->field_116!='all') { $this->db->where('C.field_116', $row->field_116); }
			if($row->field_117!='all') { $this->db->where('C.field_117', $row->field_117); }
			if($row->field_118!='all') { $this->db->where('C.field_118', $row->field_118); }
			if($row->field_119!='all') { $this->db->where('C.field_119', $row->field_119); }
			if($row->field_120!='all') { $this->db->where('C.field_120', $row->field_120); }
			if($row->field_121!='all') { $this->db->where('C.field_121', $row->field_121); }
			if($row->field_122!='all') { $this->db->where('C.field_122', $row->field_122); }
			if($row->field_123!='all') { $this->db->where('C.field_123', $row->field_123); }
			if($row->field_124!='all') { $this->db->where('C.field_124', $row->field_124); }
			if($row->field_125!='all') { $this->db->where('C.field_125', $row->field_125); }
			if($row->field_126!='all') { $this->db->where('C.field_126', $row->field_126); }
			if($row->field_127!='all') { $this->db->where('C.field_127', $row->field_127); }
			if($row->field_128!='all') { $this->db->where('C.field_128', $row->field_128); }
			if($row->field_129!='all') { $this->db->where('C.field_129', $row->field_129); }
			if($row->field_130!='all') { $this->db->where('C.field_130', $row->field_130); }
			if($row->field_131!='all') { $this->db->where('C.field_131', $row->field_131); }
			if($row->field_132!='all') { $this->db->where('C.field_132', $row->field_132); }
			if($row->field_133!='all') { $this->db->where('C.field_133', $row->field_133); }
			if($row->field_134!='all') { $this->db->where('C.field_134', $row->field_134); }
			if($row->field_135!='all') { $this->db->where('C.field_135', $row->field_135); }
			if($row->field_136!='all') { $this->db->where('C.field_136', $row->field_136); }
			if($row->field_137!='all') { $this->db->where('C.field_137', $row->field_137); }
			if($row->field_138!='all') { $this->db->where('C.field_138', $row->field_138); }
			if($row->field_139!='all') { $this->db->where('C.field_139', $row->field_139); }
			if($row->field_140!='all') { $this->db->where('C.field_140', $row->field_140); }
			if($row->field_141!='all') { $this->db->where('C.field_141', $row->field_141); }
			if($row->field_142!='all') { $this->db->where('C.field_142', $row->field_142); }
			if($row->field_143!='all') { $this->db->where('C.field_143', $row->field_143); }
			if($row->field_144!='all') { $this->db->where('C.field_144', $row->field_144); }
			if($row->field_145!='all') { $this->db->where('C.field_145', $row->field_145); }
			if($row->field_146!='all') { $this->db->where('C.field_146', $row->field_146); }
			if($row->field_147!='all') { $this->db->where('C.field_147', $row->field_147); }
			if($row->field_148!='all') { $this->db->where('C.field_148', $row->field_148); }
			if($row->field_149!='all') { $this->db->where('C.field_149', $row->field_149); }
			if($row->field_150!='all') { $this->db->where('C.field_150', $row->field_150); }
			if($row->field_151!='all') { $this->db->where('C.field_151', $row->field_151); }
			if($row->field_152!='all') { $this->db->where('C.field_152', $row->field_152); }
			if($row->field_153!='all') { $this->db->where('C.field_153', $row->field_153); }
			if($row->field_154!='all') { $this->db->where('C.field_154', $row->field_154); }
			if($row->field_155!='all') { $this->db->where('C.field_155', $row->field_155); }
			if($row->field_156!='all') { $this->db->where('C.field_156', $row->field_156); }
			if($row->field_157!='all') { $this->db->where('C.field_157', $row->field_157); }
			if($row->field_158!='all') { $this->db->where('C.field_158', $row->field_158); }
			if($row->field_159!='all') { $this->db->where('C.field_159', $row->field_159); }
			if($row->field_160!='all') { $this->db->where('C.field_160', $row->field_160); }
			if($row->field_161!='all') { $this->db->where('C.field_161', $row->field_161); }
			if($row->field_162!='all') { $this->db->where('C.field_162', $row->field_162); }
			if($row->field_163!='all') { $this->db->where('C.field_163', $row->field_163); }
			if($row->field_164!='all') { $this->db->where('C.field_164', $row->field_164); }
			if($row->field_165!='all') { $this->db->where('C.field_165', $row->field_165); }
			if($row->field_166!='all') { $this->db->where('C.field_166', $row->field_166); }
			if($row->field_167!='all') { $this->db->where('C.field_167', $row->field_167); }
			if($row->field_168!='all') { $this->db->where('C.field_168', $row->field_168); }
			if($row->field_169!='all') { $this->db->where('C.field_169', $row->field_169); }
			if($row->field_170!='all') { $this->db->where('C.field_170', $row->field_170); }
			if($row->field_171!='all') { $this->db->where('C.field_171', $row->field_171); }
			if($row->field_172!='all') { $this->db->where('C.field_172', $row->field_172); }
			if($row->field_173!='all') { $this->db->where('C.field_173', $row->field_173); }
			if($row->field_174!='all') { $this->db->where('C.field_174', $row->field_174); }
			if($row->field_175!='all') { $this->db->where('C.field_175', $row->field_175); }
			if($row->field_176!='all') { $this->db->where('C.field_176', $row->field_176); }
			if($row->field_177!='all') { $this->db->where('C.field_177', $row->field_177); }
			if($row->field_178!='all') { $this->db->where('C.field_178', $row->field_178); }
			if($row->field_179!='all') { $this->db->where('C.field_179', $row->field_179); }
			if($row->field_180!='all') { $this->db->where('C.field_180', $row->field_180); }
			if($row->field_181!='all') { $this->db->where('C.field_181', $row->field_181); }
			if($row->field_182!='all') { $this->db->where('C.field_182', $row->field_182); }
			if($row->field_183!='all') { $this->db->where('C.field_183', $row->field_183); }
			if($row->field_184!='all') { $this->db->where('C.field_184', $row->field_184); }
			if($row->field_185!='all') { $this->db->where('C.field_185', $row->field_185); }
			if($row->field_186!='all') { $this->db->where('C.field_186', $row->field_186); }
			if($row->field_187!='all') { $this->db->where('C.field_187', $row->field_187); }
			if($row->field_188!='all') { $this->db->where('C.field_188', $row->field_188); }
			if($row->field_189!='all') { $this->db->where('C.field_189', $row->field_189); }
			if($row->field_190!='all') { $this->db->where('C.field_190', $row->field_190); }
			if($row->field_191!='all') { $this->db->where('C.field_191', $row->field_191); }
			if($row->field_192!='all') { $this->db->where('C.field_192', $row->field_192); }
			if($row->field_193!='all') { $this->db->where('C.field_193', $row->field_193); }
			if($row->field_194!='all') { $this->db->where('C.field_194', $row->field_194); }
			if($row->field_195!='all') { $this->db->where('C.field_195', $row->field_195); }
			if($row->field_196!='all') { $this->db->where('C.field_196', $row->field_196); }
			if($row->field_197!='all') { $this->db->where('C.field_197', $row->field_197); }
			if($row->field_198!='all') { $this->db->where('C.field_198', $row->field_198); }
			if($row->field_199!='all') { $this->db->where('C.field_199', $row->field_199); }
			if($row->field_200!='all') { $this->db->where('C.field_200', $row->field_200); }
			if($row->field_201!='all') { $this->db->where('C.field_201', $row->field_201); }
		
		$this->db->order_by("C.id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function total_consumers_as_per_selection_criterias($srch_string='') {
		//$user_id 	= $this->session->userdata('admin_user_id');
		$criteria_id = $this->uri->segment(3);
		$customer_id 	= $this->session->userdata('admin_user_id');
		/*
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($customer_id)){ 
			
			if(!empty($srch_string)){ 
 				$this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%') and (created_by=$customer_id)");
			}else{
				$this->db->where(array('created_by'=>$customer_id));
			}
			
			}else{
				if(!empty($srch_string)){ 
 				$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%'");
			}else{
				//$this->db->where(array('created_by'=>$customer_id));
			}
			}
				
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%' OR city_last_scan LIKE '%$srch_string%' OR gender LIKE '%$srch_string%' OR dob LIKE '%$srch_string%' OR registration_address LIKE '%$srch_string%' OR alternate_mobile_no LIKE '%$srch_string%' OR street_address LIKE '%$srch_string%' OR city LIKE '%$srch_string%' OR state LIKE '%$srch_string%' OR pin_code LIKE '%$srch_string%' OR monthly_earnings LIKE '%$srch_string%' OR job_profile LIKE '%$srch_string%' OR education_qualification LIKE '%$srch_string%' OR type_vehicle LIKE '%$srch_string%' OR profession LIKE '%$srch_string%' OR marital_status LIKE '%$srch_string%' OR no_of_family_members LIKE '%$srch_string%' OR loan_car_housing LIKE '%$srch_string%' OR personal_loan LIKE '%$srch_string%' OR credit_card_loan LIKE '%$srch_string%' OR own_a_car LIKE '%$srch_string%' OR house_type LIKE '%$srch_string%' OR last_location LIKE '%$srch_string%' OR life_insurance LIKE '%$srch_string%' OR medical_insurance LIKE '%$srch_string%' OR height_in_inches LIKE '%$srch_string%' OR weight_in_kg LIKE '%$srch_string%' OR hobbies LIKE '%$srch_string%' OR sports LIKE '%$srch_string%' OR entertainment LIKE '%$srch_string%' OR spouse_gender LIKE '%$srch_string%' OR spouse_phone LIKE '%$srch_string%' OR spouse_dob LIKE '%$srch_string%' OR marriage_anniversary LIKE '%$srch_string%' OR spouse_work_status LIKE '%$srch_string%' OR spouse_edu_qualification LIKE '%$srch_string%' OR spouse_monthly_income LIKE '%$srch_string%' OR spouse_loan LIKE '%$srch_string%' OR spouse_personal_loan LIKE '%$srch_string%' OR spouse_credit_card_loan LIKE '%$srch_string%' OR spouse_own_a_car LIKE '%$srch_string%' OR spouse_house_type LIKE '%$srch_string%' OR spouse_height_inches LIKE '%$srch_string%' OR spouse_weight_kg LIKE '%$srch_string%' OR spouse_hobbies LIKE '%$srch_string%' OR spouse_sports LIKE '%$srch_string%' OR spouse_entertainment LIKE '%$srch_string%' OR modified_at LIKE '%$srch_string%'");
			}
		}
		*/
		

			
		$this->db->select('C.*, CCL.*');	
		$this->db->from('consumers C');		
		$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		//$this->db->where('CCL.customer_id', $customer_id);
		$this->db->where(array('CCL.customer_id' => $customer_id, 'CCL.registration_status' => "Registered"));
		$query = $this->db->query("SELECT * FROM consumer_selection_criteria WHERE unique_system_selection_criteria_id =  '$unique_system_selection_criteria_id'");
		$row = $query->row();
		//$row->item_id
		
		//$this->db->where('CCL.customer_id', $customer_id);
		$this->db->where(array('CCL.customer_id' => $customer_id, 'CCL.registration_status' => "Registered"));
		
		if($row->consumer_gender!='all') {
		$this->db->where('C.gender', $row->consumer_gender);
			}
		if($row->consumer_city!='all') {
		$this->db->where('C.city_last_scan', $row->consumer_city);
			}
			
		if($row->city_registration!='all') {
		$this->db->where('C.registration_city', $row->city_registration);
			}
			
		//if($row->city_registration!='all') { $this->db->where('C.registration_city', $row->city_registration); }		
		if($row->consumer_age_option=='SpecifyAge') {
		$consumer_min_dob = date('Y-m-d', strtotime('-' . $row->consumer_min_age . ' years'));
		$consumer_max_dob = date('Y-m-d', strtotime('-' . $row->consumer_max_age . ' years'));
		
		if(!empty($row->consumer_max_age)){ 
		$this->db->where('C.dob >=', $consumer_max_dob);
		//$this->db->or_where('C.dob =', 'NULL');
			}
		if(!empty($row->consumer_min_age)){ 
		$this->db->where('C.dob <=', $consumer_min_dob);
		//$this->db->or_where('C.dob =', 'NULL');
			}
		}
			/*
			$arr = explode(' ',trim($earned_loyalty_points_clubbed));
			$ELP_from = $arr[0];
			$ELP_to = $arr[2];			
			if($earned_loyalty_points_clubbed!='all') { 
			$this->db->where('C.total_accumulated_points BETWEEN "'. $ELP_from . '" and "'. $ELP_to .'"');
				}
			*/
			$arr1 = explode(' ',trim($row->monthly_earnings));
			$ME_from = $arr1[0];
			$ME_to = $arr1[2];			
			if($row->monthly_earnings!='all') { $this->db->where('C.monthly_earnings BETWEEN "'. $ME_from . '" and "'. $ME_to .'"');}	
						
			if($row->job_profile!='all') { $this->db->where('C.job_profile', $row->job_profile); }
			if($row->education_qualification!='all') { $this->db->where('C.education_qualification', $row->education_qualification); }
			if($row->type_vehicle!='all') { $this->db->where('C.type_vehicle', $row->type_vehicle); }
			if($row->profession!='all') { $this->db->where('C.profession', $row->profession); }
			if($row->marital_status!='all') { $this->db->where('C.marital_status', $row->marital_status); }
			if($row->no_of_family_members!='all') { $this->db->where('C.no_of_family_members', $row->no_of_family_members); }
			if($row->loan_car!='all') { $this->db->where('C.loan_car', $row->loan_car); }
			if($row->loan_housing!='all') { $this->db->where('C.loan_housing', $row->loan_housing); }
			if($row->personal_loan!='all') { $this->db->where('C.personal_loan', $row->personal_loan); }
			if($row->credit_card_loan!='all') { $this->db->where('C.credit_card_loan', $row->credit_card_loan); }
			if($row->own_a_car!='all') { $this->db->where('C.own_a_car', $row->own_a_car); }
			if($row->house_type!='all') { $this->db->where('C.house_type', $row->house_type); }
			if($row->last_location!='all') { $this->db->where('C.last_location', $row->last_location); }
			if($row->life_insurance!='all') { $this->db->where('C.life_insurance', $row->life_insurance); }
			if($row->medical_insurance!='all') { $this->db->where('C.medical_insurance', $row->medical_insurance); }
			if($row->height_in_inches!='all') { $this->db->where('C.height_in_inches', $row->height_in_inches); }
			if($row->weight_in_kg!='all') { $this->db->where('C.weight_in_kg', $row->weight_in_kg); }
			if($row->hobbies!='all') { $this->db->where('C.hobbies', $row->hobbies); }
			if($row->sports!='all') { $this->db->where('C.sports', $row->sports); }
			if($row->entertainment!='all') { $this->db->where('C.entertainment', $row->entertainment); }
			if($row->spouse_gender!='all') { $this->db->where('C.spouse_gender', $row->spouse_gender); }
			if($row->spouse_phone!='all') { $this->db->where('C.spouse_phone', $row->spouse_phone); }
			if($row->spouse_dob!='all') { $this->db->where('C.spouse_dob', $row->spouse_dob); }
			if($row->marriage_anniversary!='all') { $this->db->where('C.marriage_anniversary', $row->marriage_anniversary); }
			if($row->spouse_work_status!='all') { $this->db->where('C.spouse_work_status', $row->spouse_work_status); }
			if($row->spouse_edu_qualification!='all') { $this->db->where('C.spouse_edu_qualification', $row->spouse_edu_qualification); }
			if($row->spouse_monthly_income!='all') { $this->db->where('C.spouse_monthly_income', $row->spouse_monthly_income); }
			if($row->spouse_loan!='all') { $this->db->where('C.spouse_loan', $row->spouse_loan); }
			if($row->spouse_personal_loan!='all') { $this->db->where('C.spouse_personal_loan', $row->spouse_personal_loan); }
			if($row->spouse_credit_card_loan!='all') { $this->db->where('C.spouse_credit_card_loan', $row->spouse_credit_card_loan); }
			if($row->spouse_own_a_car!='all') { $this->db->where('C.spouse_own_a_car', $row->spouse_own_a_car); }
			if($row->spouse_house_type!='all') { $this->db->where('C.spouse_house_type', $row->spouse_house_type); }
			if($row->spouse_height_inches!='all') { $this->db->where('C.spouse_height_inches', $row->spouse_height_inches); }
			if($row->spouse_weight_kg!='all') { $this->db->where('C.spouse_weight_kg', $row->spouse_weight_kg); }
			if($row->spouse_hobbies!='all') { $this->db->where('C.spouse_hobbies', $row->spouse_hobbies); }
			if($row->spouse_sports!='all') { $this->db->where('C.spouse_sports', $row->spouse_sports); }
			if($row->spouse_entertainment!='all') { $this->db->where('C.spouse_entertainment', $row->spouse_entertainment); }
			if($row->field_1!='all') { $this->db->where('C.field_1', $row->field_1); }
			if($row->field_2!='all') { $this->db->where('C.field_2', $row->field_2); }
			if($row->field_3!='all') { $this->db->where('C.field_3', $row->field_3); }
			if($row->field_4!='all') { $this->db->where('C.field_4', $row->field_4); }
			if($row->field_5!='all') { $this->db->where('C.field_5', $row->field_5); }
			if($row->field_6!='all') { $this->db->where('C.field_6', $row->field_6); }
			if($row->field_7!='all') { $this->db->where('C.field_7', $row->field_7); }
			if($row->field_8!='all') { $this->db->where('C.field_8', $row->field_8); }
			if($row->field_9!='all') { $this->db->where('C.field_9', $row->field_9); }
			if($row->field_10!='all') { $this->db->where('C.field_10', $row->field_10); }
			if($row->field_11!='all') { $this->db->where('C.field_11', $row->field_11); }
			if($row->field_12!='all') { $this->db->where('C.field_12', $row->field_12); }
			if($row->field_13!='all') { $this->db->where('C.field_13', $row->field_13); }
			if($row->field_14!='all') { $this->db->where('C.field_14', $row->field_14); }
			if($row->field_15!='all') { $this->db->where('C.field_15', $row->field_15); }
			if($row->field_16!='all') { $this->db->where('C.field_16', $row->field_16); }
			if($row->field_17!='all') { $this->db->where('C.field_17', $row->field_17); }
			if($row->field_18!='all') { $this->db->where('C.field_18', $row->field_18); }
			if($row->field_19!='all') { $this->db->where('C.field_19', $row->field_19); }
			if($row->field_20!='all') { $this->db->where('C.field_20', $row->field_20); }
			if($row->field_21!='all') { $this->db->where('C.field_21', $row->field_21); }
			if($row->field_22!='all') { $this->db->where('C.field_22', $row->field_22); }
			if($row->field_23!='all') { $this->db->where('C.field_23', $row->field_23); }
			if($row->field_24!='all') { $this->db->where('C.field_24', $row->field_24); }
			if($row->field_25!='all') { $this->db->where('C.field_25', $row->field_25); }
			if($row->field_26!='all') { $this->db->where('C.field_26', $row->field_26); }
			if($row->field_27!='all') { $this->db->where('C.field_27', $row->field_27); }
			if($row->field_28!='all') { $this->db->where('C.field_28', $row->field_28); }
			if($row->field_29!='all') { $this->db->where('C.field_29', $row->field_29); }
			if($row->field_30!='all') { $this->db->where('C.field_30', $row->field_30); }
			if($row->field_31!='all') { $this->db->where('C.field_31', $row->field_31); }
			if($row->field_32!='all') { $this->db->where('C.field_32', $row->field_32); }
			if($row->field_33!='all') { $this->db->where('C.field_33', $row->field_33); }
			if($row->field_34!='all') { $this->db->where('C.field_34', $row->field_34); }
			if($row->field_35!='all') { $this->db->where('C.field_35', $row->field_35); }
			if($row->field_36!='all') { $this->db->where('C.field_36', $row->field_36); }
			if($row->field_37!='all') { $this->db->where('C.field_37', $row->field_37); }
			if($row->field_38!='all') { $this->db->where('C.field_38', $row->field_38); }
			if($row->field_39!='all') { $this->db->where('C.field_39', $row->field_39); }
			if($row->field_40!='all') { $this->db->where('C.field_40', $row->field_40); }
			if($row->field_41!='all') { $this->db->where('C.field_41', $row->field_41); }
			if($row->field_42!='all') { $this->db->where('C.field_42', $row->field_42); }
			if($row->field_43!='all') { $this->db->where('C.field_43', $row->field_43); }
			if($row->field_44!='all') { $this->db->where('C.field_44', $row->field_44); }
			if($row->field_45!='all') { $this->db->where('C.field_45', $row->field_45); }
			if($row->field_46!='all') { $this->db->where('C.field_46', $row->field_46); }
			if($row->field_47!='all') { $this->db->where('C.field_47', $row->field_47); }
			if($row->field_48!='all') { $this->db->where('C.field_48', $row->field_48); }
			if($row->field_49!='all') { $this->db->where('C.field_49', $row->field_49); }
			if($row->field_50!='all') { $this->db->where('C.field_50', $row->field_50); }
			if($row->field_51!='all') { $this->db->where('C.field_51', $row->field_51); }
			if($row->field_52!='all') { $this->db->where('C.field_52', $row->field_52); }
			if($row->field_53!='all') { $this->db->where('C.field_53', $row->field_53); }
			if($row->field_54!='all') { $this->db->where('C.field_54', $row->field_54); }
			if($row->field_55!='all') { $this->db->where('C.field_55', $row->field_55); }
			if($row->field_56!='all') { $this->db->where('C.field_56', $row->field_56); }
			if($row->field_57!='all') { $this->db->where('C.field_57', $row->field_57); }
			if($row->field_58!='all') { $this->db->where('C.field_58', $row->field_58); }
			if($row->field_59!='all') { $this->db->where('C.field_59', $row->field_59); }
			if($row->field_60!='all') { $this->db->where('C.field_60', $row->field_60); }
			if($row->field_61!='all') { $this->db->where('C.field_61', $row->field_61); }
			if($row->field_62!='all') { $this->db->where('C.field_62', $row->field_62); }
			if($row->field_63!='all') { $this->db->where('C.field_63', $row->field_63); }
			if($row->field_64!='all') { $this->db->where('C.field_64', $row->field_64); }
			if($row->field_65!='all') { $this->db->where('C.field_65', $row->field_65); }
			if($row->field_66!='all') { $this->db->where('C.field_66', $row->field_66); }
			if($row->field_67!='all') { $this->db->where('C.field_67', $row->field_67); }
			if($row->field_68!='all') { $this->db->where('C.field_68', $row->field_68); }
			if($row->field_69!='all') { $this->db->where('C.field_69', $row->field_69); }
			if($row->field_70!='all') { $this->db->where('C.field_70', $row->field_70); }
			if($row->field_71!='all') { $this->db->where('C.field_71', $row->field_71); }
			if($row->field_72!='all') { $this->db->where('C.field_72', $row->field_72); }
			if($row->field_73!='all') { $this->db->where('C.field_73', $row->field_73); }
			if($row->field_74!='all') { $this->db->where('C.field_74', $row->field_74); }
			if($row->field_75!='all') { $this->db->where('C.field_75', $row->field_75); }
			if($row->field_76!='all') { $this->db->where('C.field_76', $row->field_76); }
			if($row->field_77!='all') { $this->db->where('C.field_77', $row->field_77); }
			if($row->field_78!='all') { $this->db->where('C.field_78', $row->field_78); }
			if($row->field_79!='all') { $this->db->where('C.field_79', $row->field_79); }
			if($row->field_80!='all') { $this->db->where('C.field_80', $row->field_80); }
			if($row->field_81!='all') { $this->db->where('C.field_81', $row->field_81); }
			if($row->field_82!='all') { $this->db->where('C.field_82', $row->field_82); }
			if($row->field_83!='all') { $this->db->where('C.field_83', $row->field_83); }
			if($row->field_84!='all') { $this->db->where('C.field_84', $row->field_84); }
			if($row->field_85!='all') { $this->db->where('C.field_85', $row->field_85); }
			if($row->field_86!='all') { $this->db->where('C.field_86', $row->field_86); }
			if($row->field_87!='all') { $this->db->where('C.field_87', $row->field_87); }
			if($row->field_88!='all') { $this->db->where('C.field_88', $row->field_88); }
			if($row->field_89!='all') { $this->db->where('C.field_89', $row->field_89); }
			if($row->field_90!='all') { $this->db->where('C.field_90', $row->field_90); }
			if($row->field_91!='all') { $this->db->where('C.field_91', $row->field_91); }
			if($row->field_92!='all') { $this->db->where('C.field_92', $row->field_92); }
			if($row->field_93!='all') { $this->db->where('C.field_93', $row->field_93); }
			if($row->field_94!='all') { $this->db->where('C.field_94', $row->field_94); }
			if($row->field_95!='all') { $this->db->where('C.field_95', $row->field_95); }
			if($row->field_96!='all') { $this->db->where('C.field_96', $row->field_96); }
			if($row->field_97!='all') { $this->db->where('C.field_97', $row->field_97); }
			if($row->field_98!='all') { $this->db->where('C.field_98', $row->field_98); }
			if($row->field_99!='all') { $this->db->where('C.field_99', $row->field_99); }
			if($row->field_100!='all') { $this->db->where('C.field_100', $row->field_100); }
			if($row->field_101!='all') { $this->db->where('C.field_101', $row->field_101); }
			if($row->field_102!='all') { $this->db->where('C.field_102', $row->field_102); }
			if($row->field_103!='all') { $this->db->where('C.field_103', $row->field_103); }
			if($row->field_104!='all') { $this->db->where('C.field_104', $row->field_104); }
			if($row->field_105!='all') { $this->db->where('C.field_105', $row->field_105); }
			if($row->field_106!='all') { $this->db->where('C.field_106', $row->field_106); }
			if($row->field_107!='all') { $this->db->where('C.field_107', $row->field_107); }
			if($row->field_108!='all') { $this->db->where('C.field_108', $row->field_108); }
			if($row->field_109!='all') { $this->db->where('C.field_109', $row->field_109); }
			if($row->field_110!='all') { $this->db->where('C.field_110', $row->field_110); }
			if($row->field_111!='all') { $this->db->where('C.field_111', $row->field_111); }
			if($row->field_112!='all') { $this->db->where('C.field_112', $row->field_112); }
			if($row->field_113!='all') { $this->db->where('C.field_113', $row->field_113); }
			if($row->field_114!='all') { $this->db->where('C.field_114', $row->field_114); }
			if($row->field_115!='all') { $this->db->where('C.field_115', $row->field_115); }
			if($row->field_116!='all') { $this->db->where('C.field_116', $row->field_116); }
			if($row->field_117!='all') { $this->db->where('C.field_117', $row->field_117); }
			if($row->field_118!='all') { $this->db->where('C.field_118', $row->field_118); }
			if($row->field_119!='all') { $this->db->where('C.field_119', $row->field_119); }
			if($row->field_120!='all') { $this->db->where('C.field_120', $row->field_120); }
			if($row->field_121!='all') { $this->db->where('C.field_121', $row->field_121); }
			if($row->field_122!='all') { $this->db->where('C.field_122', $row->field_122); }
			if($row->field_123!='all') { $this->db->where('C.field_123', $row->field_123); }
			if($row->field_124!='all') { $this->db->where('C.field_124', $row->field_124); }
			if($row->field_125!='all') { $this->db->where('C.field_125', $row->field_125); }
			if($row->field_126!='all') { $this->db->where('C.field_126', $row->field_126); }
			if($row->field_127!='all') { $this->db->where('C.field_127', $row->field_127); }
			if($row->field_128!='all') { $this->db->where('C.field_128', $row->field_128); }
			if($row->field_129!='all') { $this->db->where('C.field_129', $row->field_129); }
			if($row->field_130!='all') { $this->db->where('C.field_130', $row->field_130); }
			if($row->field_131!='all') { $this->db->where('C.field_131', $row->field_131); }
			if($row->field_132!='all') { $this->db->where('C.field_132', $row->field_132); }
			if($row->field_133!='all') { $this->db->where('C.field_133', $row->field_133); }
			if($row->field_134!='all') { $this->db->where('C.field_134', $row->field_134); }
			if($row->field_135!='all') { $this->db->where('C.field_135', $row->field_135); }
			if($row->field_136!='all') { $this->db->where('C.field_136', $row->field_136); }
			if($row->field_137!='all') { $this->db->where('C.field_137', $row->field_137); }
			if($row->field_138!='all') { $this->db->where('C.field_138', $row->field_138); }
			if($row->field_139!='all') { $this->db->where('C.field_139', $row->field_139); }
			if($row->field_140!='all') { $this->db->where('C.field_140', $row->field_140); }
			if($row->field_141!='all') { $this->db->where('C.field_141', $row->field_141); }
			if($row->field_142!='all') { $this->db->where('C.field_142', $row->field_142); }
			if($row->field_143!='all') { $this->db->where('C.field_143', $row->field_143); }
			if($row->field_144!='all') { $this->db->where('C.field_144', $row->field_144); }
			if($row->field_145!='all') { $this->db->where('C.field_145', $row->field_145); }
			if($row->field_146!='all') { $this->db->where('C.field_146', $row->field_146); }
			if($row->field_147!='all') { $this->db->where('C.field_147', $row->field_147); }
			if($row->field_148!='all') { $this->db->where('C.field_148', $row->field_148); }
			if($row->field_149!='all') { $this->db->where('C.field_149', $row->field_149); }
			if($row->field_150!='all') { $this->db->where('C.field_150', $row->field_150); }
			if($row->field_151!='all') { $this->db->where('C.field_151', $row->field_151); }
			if($row->field_152!='all') { $this->db->where('C.field_152', $row->field_152); }
			if($row->field_153!='all') { $this->db->where('C.field_153', $row->field_153); }
			if($row->field_154!='all') { $this->db->where('C.field_154', $row->field_154); }
			if($row->field_155!='all') { $this->db->where('C.field_155', $row->field_155); }
			if($row->field_156!='all') { $this->db->where('C.field_156', $row->field_156); }
			if($row->field_157!='all') { $this->db->where('C.field_157', $row->field_157); }
			if($row->field_158!='all') { $this->db->where('C.field_158', $row->field_158); }
			if($row->field_159!='all') { $this->db->where('C.field_159', $row->field_159); }
			if($row->field_160!='all') { $this->db->where('C.field_160', $row->field_160); }
			if($row->field_161!='all') { $this->db->where('C.field_161', $row->field_161); }
			if($row->field_162!='all') { $this->db->where('C.field_162', $row->field_162); }
			if($row->field_163!='all') { $this->db->where('C.field_163', $row->field_163); }
			if($row->field_164!='all') { $this->db->where('C.field_164', $row->field_164); }
			if($row->field_165!='all') { $this->db->where('C.field_165', $row->field_165); }
			if($row->field_166!='all') { $this->db->where('C.field_166', $row->field_166); }
			if($row->field_167!='all') { $this->db->where('C.field_167', $row->field_167); }
			if($row->field_168!='all') { $this->db->where('C.field_168', $row->field_168); }
			if($row->field_169!='all') { $this->db->where('C.field_169', $row->field_169); }
			if($row->field_170!='all') { $this->db->where('C.field_170', $row->field_170); }
			if($row->field_171!='all') { $this->db->where('C.field_171', $row->field_171); }
			if($row->field_172!='all') { $this->db->where('C.field_172', $row->field_172); }
			if($row->field_173!='all') { $this->db->where('C.field_173', $row->field_173); }
			if($row->field_174!='all') { $this->db->where('C.field_174', $row->field_174); }
			if($row->field_175!='all') { $this->db->where('C.field_175', $row->field_175); }
			if($row->field_176!='all') { $this->db->where('C.field_176', $row->field_176); }
			if($row->field_177!='all') { $this->db->where('C.field_177', $row->field_177); }
			if($row->field_178!='all') { $this->db->where('C.field_178', $row->field_178); }
			if($row->field_179!='all') { $this->db->where('C.field_179', $row->field_179); }
			if($row->field_180!='all') { $this->db->where('C.field_180', $row->field_180); }
			if($row->field_181!='all') { $this->db->where('C.field_181', $row->field_181); }
			if($row->field_182!='all') { $this->db->where('C.field_182', $row->field_182); }
			if($row->field_183!='all') { $this->db->where('C.field_183', $row->field_183); }
			if($row->field_184!='all') { $this->db->where('C.field_184', $row->field_184); }
			if($row->field_185!='all') { $this->db->where('C.field_185', $row->field_185); }
			if($row->field_186!='all') { $this->db->where('C.field_186', $row->field_186); }
			if($row->field_187!='all') { $this->db->where('C.field_187', $row->field_187); }
			if($row->field_188!='all') { $this->db->where('C.field_188', $row->field_188); }
			if($row->field_189!='all') { $this->db->where('C.field_189', $row->field_189); }
			if($row->field_190!='all') { $this->db->where('C.field_190', $row->field_190); }
			if($row->field_191!='all') { $this->db->where('C.field_191', $row->field_191); }
			if($row->field_192!='all') { $this->db->where('C.field_192', $row->field_192); }
			if($row->field_193!='all') { $this->db->where('C.field_193', $row->field_193); }
			if($row->field_194!='all') { $this->db->where('C.field_194', $row->field_194); }
			if($row->field_195!='all') { $this->db->where('C.field_195', $row->field_195); }
			if($row->field_196!='all') { $this->db->where('C.field_196', $row->field_196); }
			if($row->field_197!='all') { $this->db->where('C.field_197', $row->field_197); }
			if($row->field_198!='all') { $this->db->where('C.field_198', $row->field_198); }
			if($row->field_199!='all') { $this->db->where('C.field_199', $row->field_199); }
			if($row->field_200!='all') { $this->db->where('C.field_200', $row->field_200); }
			if($row->field_201!='all') { $this->db->where('C.field_201', $row->field_201); }
		
			
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	
		function list_all_loyalty_customers($id,$limit,$start,$srch_string='') {
			 $user_id = $this->session->userdata('admin_user_id');
			$customer_id = $this->uri->segment(3);
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				//$this->db->where(array('consumer_id'=>$id));
			}
			
		
		$this->db->select("*");
		$this->db->from("consumer_passbook");	
		$this->db->distinct();	
		$this->db->group_by('customer_id');
		//$this->db->where('customer_id != ', 1);
		$this->db->order_by("transaction_date", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function count_total_list_loyalty_customers($id,$srch_string='') {
			 $user_id = $this->session->userdata('admin_user_id');
			 $customer_id = $this->uri->segment(3);
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				//$this->db->where(array('consumer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumer_passbook');
		$this->db->where('customer_id', $id);
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	function count_total_list_view_consumer_passbook($id,$srch_string='') {
		
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				//$this->db->where(array('consumer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumer_passbook');
		$this->db->where('consumer_id', $id);
		$this->db->where('customer_loyalty_type', "TRUSTAT");
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	function list_view_consumer_passbook($id,$limit,$start,$srch_string='') {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				$this->db->where(array('consumer_id'=>$id));
			}
			
		$this->db->select("*");
		$this->db->from("consumer_passbook");		
		$this->db->where('consumer_id', $id);
		$this->db->where('customer_loyalty_type', "TRUSTAT");
		$this->db->order_by("transaction_date", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
// Sanjay 
	function count_total_list_view_blp_consumer_passbook($id,$srch_string='') {
		
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				//$this->db->where(array('consumer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumer_passbook');
		$this->db->where('consumer_id', $id);
		$this->db->where('customer_loyalty_type', "Brand");
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	function list_view_blp_consumer_passbook($id,$limit,$start,$srch_string='') {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				$this->db->where(array('consumer_id'=>$id));
			}
			
			
		$this->db->select("*");
		$this->db->from("consumer_passbook");		
		$this->db->where('consumer_id', $id);
		$this->db->where('customer_loyalty_type', "Brand");
		$this->db->order_by("transaction_date", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
		function list_view_blp_consumer_passbook_cust_dist($id,$limit,$start,$srch_string='') {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				$this->db->where(array('consumer_id'=>$id));
			}
			
			if($this->uri->segment(2)=="list_view_blp_consumer_passbook"){
				$customer_loyalty_type = "Brand";
				}else{
				$customer_loyalty_type = "TRUSTAT";
				}
			
		$this->db->select("*");
		$this->db->from("consumer_passbook");		
		$this->db->where('consumer_id', $id);
		$this->db->where('customer_loyalty_type', $customer_loyalty_type);
		$this->db->group_by('customer_id');
		$this->db->order_by("transaction_date", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	
	function list_all_customers_products() {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			/*
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				$this->db->where(array('consumer_id'=>$id));
			}
			*/
			
		$this->db->select("*");
		$this->db->from("products");		
		//$this->db->where('consumer_id', $id);
		//$this->db->where('customer_loyalty_type', "Brand");
		$this->db->group_by('created_by');
		$this->db->order_by("id", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }

	
	function list_customerwise_consumer_loyalty($id,$limit,$start,$srch_string='') {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
		$user_id 	= $this->session->userdata('admin_user_id');	
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (customer_id=$id)");
			}else{
				$this->db->where(array('customer_id'=>$id));
			}
			
		$this->db->select("*");
		$this->db->from("consumer_passbook");	
		
		$this->db->where(array('customer_id'=>$id, 'transaction_lr_type'=>"Loyalty"));
		
		$this->db->order_by("id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function count_total_list_customerwise_consumer_loyalty($id,$srch_string='') {
		
			//$this->db->where('created_by', $user_id);
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (customer_id=$id)");
			}else{
				$this->db->where(array('customer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumer_passbook');

		$this->db->where(array('customer_id'=>$id, 'transaction_lr_type'=>"Loyalty"));
		
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	function list_customerwise_consumer_loyalty_redemption($id,$limit,$start,$srch_string='') {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (customer_id=$id)");
			}else{
				$this->db->where(array('customer_id'=>$id));
			}
			
		$this->db->select("*");
		$this->db->from("consumer_passbook");	
		if($user_id==1){
			//$this->db->where('customer_id', $user_id);
			$this->db->where(array('customer_id'=>$id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>"Brand"));
		}
		//$this->db->where('customer_id', $id);
		$this->db->where(array('customer_id'=>$id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>"Brand"));
		$this->db->order_by("id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function count_total_list_customerwise_consumer_loyalty_redemption($id,$srch_string='') {
		
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (customer_id=$id)");
			}else{
				$this->db->where(array('customer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumer_passbook');
		//$this->db->where('customer_id', $id);
		$this->db->where(array('customer_id'=>$id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>"Brand"));
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	function count_total_consumer_feedback_question($id, $srch_string='') {
		
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR fqb.question LIKE '%$srch_string%' OR CF.selected_answer LIKE '%$srch_string%') and (user_id=$id)");
			}else{
				$this->db->where(array('user_id'=>$id));
			}		
		
		$this->db->select('count(1) as total_rows');
		$this->db->from("consumer_feedback AS CF");
		$this->db->join('products AS P', 'P.id = CF.product_id','LEFT');
		$this->db->join('feedback_question_bank AS fqb', 'fqb.question_id = CF.question_id','LEFT');
		$this->db->where('CF.user_id', $id);
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	function list_view_consumer_feedback_question($id, $limit_per_page, $start_index, $srch_string='') {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR fqb.question LIKE '%$srch_string%' OR CF.selected_answer LIKE '%$srch_string%') and (user_id=$id)");
			}else{
				$this->db->where(array('user_id'=>$id));
			}
			
		$this->db->select("CF.*, P.product_name, fqb.question");
		$this->db->from("consumer_feedback AS CF");
		$this->db->join('products AS P', 'P.id = CF.product_id','LEFT');
		$this->db->join('feedback_question_bank AS fqb', 'fqb.question_id = CF.question_id','LEFT');
		$this->db->where('CF.user_id', $id);
		$this->db->order_by("CF.created_date", "desc");
		$this->db->limit($limit_per_page, $start_index);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
		
	/*	
public function findLoylityBySlug($transactionType = null){
        $items = [];
        if(empty($transactionType)){
           return false; 
        }
        $query = $this->db->get_where('loylties',['transaction_type_slug'=>$transactionType]);
        if( $query->num_rows() <= 0 ){
            return false;
        }else{
            return $query->row_array();
        }
    }
	
	*/
	
	public function saveLoylty($transactionType = null,$userId = null,$params = []){
        if( empty($transactionType) || empty($userId) ){
            return false;
        }
        
        $loylty = $this->findLoylityBySlug($transactionType);
        if(empty($loylty)){
            return false;
        }
		
		$loyalty_points_expiry_days = loyalty_points_expiry_days(1);
		$Current_Date = date('Y-m-d');
		$loyalty_points_expiry_date = date('Y-m-d', strtotime($Current_Date. ' + ' . $loyalty_points_expiry_days. ' days'));
 		
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $date->modify('+3    month');
        $input = [
            'customer_id' => 1,
			'user_id' => $userId,
            'points' => $loylty['loyalty_points'],
            'transaction_type' => $loylty['transaction_type'],
			'product_id' => 0,
            'params' => json_encode($params),
            'loyalty_points_status' => "Redeemed",
            'modified_at' => "0000-00-00 00:00:00",
            'created_at' => $now,
            'loyalty_points_expiry_date' => $loyalty_points_expiry_date
        ];
        
        return $this->db->insert('loylty_points',$input);
    }
	
	public function findLoylityBySlugAndProductID($transactionType = null,$ProductID = null){
        $items = [];
        if(empty($transactionType)){
           return false; 
        }
        $query = $this->db->get_where('products',['id' => $ProductID]);
        if( $query->num_rows() <= 0 ){
            return false;
        }else{
            return $query->row_array();
        }
    }
	
    public function saveProductLoylty($transactionType = null,$ProductID = null,$userId = null,$params = [], $customer_id = null){
        if( empty($transactionType) || empty($userId) ){
            return false;
        }
        /*
        $loylty = $this->findLoylityBySlugAndProductID($transactionType,$ProductID);
		//print_r  $loylty; exit;
		if(empty($loylty)){
            return false;
        } 
		*/
		$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($customer_id);
		
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		//echo $result->$transactionType;
		
		$loyalty_points_expiry_days = loyalty_points_expiry_days($customer_id);
		$Current_Date = date('Y-m-d');
		$loyalty_points_expiry_date = date('Y-m-d', strtotime($Current_Date. ' + ' . $loyalty_points_expiry_days. ' days'));
 		
		
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $date->modify('+3    month');
        $input = [
            'customer_id' => $customer_id,
			'user_id' => $userId,
            'points' => $result->$transactionType,
            'transaction_type' => $transactionType,
			'customer_loyalty_type' => $customer_loyalty_type,
			'product_id' => $ProductID,
            'params' => json_encode($params),
            'loyalty_points_status' => "Earned",
            'modified_at' => "0000-00-00 00:00:00",
            'created_at' => $now,
            'loyalty_points_expiry_date' => $loyalty_points_expiry_date
        ];
        
        return $this->db->insert('loylty_points',$input);
    }	
	
	function checkDuplicateQuestion($Question, $qid = '', $Product_id) {
		
        $result = 'true';
        $this->db->select('question_id');
        $this->db->from('feedback_question_bank');
        if (!empty($qid)) {
            $this->db->where(array('question_id!=' => $qid, 'product_id' => $Product_id));
        }
        $this->db->where(array('question' => $Question, 'product_id' => $Product_id));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['question_id'];
            $result = 'false';
        }
        return $result;
    }
	
	function list_all_customers($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($customer_id)){ 
			
			if(!empty($srch_string)){ 
 				$this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%') and (created_by=$customer_id)");
			}else{
				$this->db->where(array('created_by'=>$customer_id));
			}
			
			}else{
				if(!empty($srch_string)){ 
 				$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%'");
			}else{
				//$this->db->where(array('created_by'=>$customer_id));
			}
			}
				
		}else{
			if(!empty($srch_string)){ 
 		$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%'");
			}
		}
		
		$this->db->select("BU.*, RM.*");
		$this->db->from("backend_user BU");
		$this->db->join('role_master RM', 'BU.designation_id = RM.id');
		if($user_id==1){
		$this->db->where('is_parent>', 1);
		} else {
		
		//$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->where('is_parent', $user_id);
		
		}
		$this->db->order_by("user_id", " desc");
		// $this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function total_all_customers($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($customer_id)){ 
			
			if(!empty($srch_string)){ 
 				$this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%') and (created_by=$customer_id)");
			}else{
				$this->db->where(array('created_by'=>$customer_id));
			}
			
			}else{
				if(!empty($srch_string)){ 
 				$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%'");
			}else{
				//$this->db->where(array('created_by'=>$customer_id));
			}
			}
				
		}else{
			if(!empty($srch_string)){ 
 	$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%'");
			}
		}
		
		
		
		$this->db->select("BU.*, RM.*");
		$this->db->from("backend_user BU");
		$this->db->join('role_master RM', 'BU.designation_id = RM.id');
		if($user_id==1){
		$this->db->where('is_parent>', 1);
		} else {
		
		//$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->where('is_parent', $user_id);
		
		}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	function count_total_list_view_blp_tracek_user_passbook($id,$srch_string='') {
		
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (customer_a_user_id=$id)");
			}else{
				$this->db->where(array('customer_a_user_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('customer_passbook');
		$this->db->where('customer_a_user_id', $id);		
		//$this->db->where('customer_loyalty_type', "Brand");
		/*
		if($user_id==1){
		$this->db->where('parent_customer_id>', 1);
		} else {		
		$this->db->where('parent_customer_id', $user_id);		
		}
		*/
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	function list_view_blp_tracek_user_passbook($id,$limit,$start,$srch_string='') {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (customer_a_user_id=$id)");
			}else{
				$this->db->where(array('customer_a_user_id'=>$id));
			}
			
		$this->db->select("*");
		$this->db->from("customer_passbook");		
		$this->db->where('customer_a_user_id', $id);
		//$this->db->where('customer_loyalty_type', "Brand");
		/*
		if($user_id==1){
		$this->db->where('parent_customer_id>', 1);
		} else {		
		$this->db->where('parent_customer_id', $user_id);		
		}
			*/
		$this->db->order_by("id", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
public function sendFCM($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array (
		        'to' => $id,
		         
		         'notification' => array('title' => 'Loyalty Approved', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'Loyalty Approved', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
		);
		$fields = json_encode ( $fields );
		
		$headers = array (
		        'Authorization: key=' . "AAAA4LpXTK8:APA91bHs48XoX1_-4CdsBVyAAVceqQFavfo6Hz3K1U5Phmz2OgYsX7Pr_bNuE8x_PGJBcWs08WHx0JTGh-6goN7ozfl3yB8z9bYe_2ayk0Nmlp9uYOknIKDwq9czlj10rRGQ1bDZ9Nlp", 'Content-Type: application/json'
		);
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		
		$result = curl_exec ( $ch );
		//curl_close ( $ch );
		return $result;
		}
		
	function ConsumerReferralDetails2($ProductID, $ConsumerMobileNumber){
		$this->db->select('referral_id,loyalty_points_referral');
		$this->db->where(array("product_id"=> $ProductID, "referred_mobile_no"=> $ConsumerMobileNumber, "referral_consumed"=> 0));
		$this->db->limit(1);// only apply if you have more than same id in your table othre wise comment this line
		$query = $this->db->get('consumer_referral_table');
		$row = $query->row();
		return $row;
	}
	
	
	function total_referral_mis_listing($srch_string='', $from_date_data='', $to_date_data='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(CRT.referral_reference_id LIKE '%$srch_string%' OR CRT.referred_mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR CRT.rs_referred_consumer_TRUSTAT LIKE '%$srch_string%' OR CRT.rs_referred_consumer_customer LIKE '%$srch_string%' OR CRT.geol_city LIKE '%$srch_string%' OR CRT.geol_pin_code LIKE '%$srch_string%' OR CRT.media_type LIKE '%$srch_string%') and (P.created_by=$user_id)");
				if((!empty($from_date_data))&&(!empty($from_date_data))){ 
			$this->db->where('DATE(CRT.referring_datetime) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->where('DATE(CRT.referring_datetime) <=', date('Y-m-d',strtotime($to_date_data)));
				}
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(CRT.referral_reference_id LIKE '%$srch_string%' OR CRT.referred_mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR CRT.rs_referred_consumer_TRUSTAT LIKE '%$srch_string%' OR CRT.rs_referred_consumer_customer LIKE '%$srch_string%' OR CRT.geol_city LIKE '%$srch_string%' OR CRT.geol_pin_code LIKE '%$srch_string%' OR CRT.media_type LIKE '%$srch_string%')");
			if((!empty($from_date_data))&&(!empty($from_date_data))){ 
			$this->db->where('DATE(CRT.referring_datetime) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->where('DATE(CRT.referring_datetime) <=', date('Y-m-d',strtotime($to_date_data)));
			}
			}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from("consumer_referral_table CRT");
		$this->db->join('products P', 'CRT.product_id = P.id');		
		if($user_id>1){
		$this->db->where('P.created_by', $user_id);
			}else{
			$this->db->where('P.created_by', $customer_id);
			}
		if((!empty($from_date_data))&&(!empty($from_date_data))){ 
		$this->db->where('DATE(CRT.referring_datetime) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(CRT.referring_datetime) <=', date('Y-m-d',strtotime($to_date_data)));
		}	
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
		function referral_mis_listing($limit,$start,$srch_string='', $from_date_data='', $to_date_data='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(CRT.referral_reference_id LIKE '%$srch_string%' OR CRT.referred_mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR CRT.rs_referred_consumer_TRUSTAT LIKE '%$srch_string%' OR CRT.rs_referred_consumer_customer LIKE '%$srch_string%' OR CRT.geol_city LIKE '%$srch_string%' OR CRT.geol_pin_code LIKE '%$srch_string%' OR CRT.media_type LIKE '%$srch_string%') and (P.created_by=$user_id)");
			if((!empty($from_date_data))&&(!empty($from_date_data))){ 
			$this->db->where('DATE(CRT.referring_datetime) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->where('DATE(CRT.referring_datetime) <=', date('Y-m-d',strtotime($to_date_data)));
				}
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(CRT.referral_reference_id LIKE '%$srch_string%' OR CRT.referred_mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR CRT.rs_referred_consumer_TRUSTAT LIKE '%$srch_string%' OR CRT.rs_referred_consumer_customer LIKE '%$srch_string%' OR CRT.geol_city LIKE '%$srch_string%' OR CRT.geol_pin_code LIKE '%$srch_string%' OR CRT.media_type LIKE '%$srch_string%')");
			if((!empty($from_date_data))&&(!empty($from_date_data))){ 
			$this->db->where('DATE(CRT.referring_datetime) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->where('DATE(CRT.referring_datetime) <=', date('Y-m-d',strtotime($to_date_data)));
				}
			}
		}
		$this->db->select("CRT.*, P.*");		
		$this->db->from("consumer_referral_table CRT");
		$this->db->join('products P', 'CRT.product_id = P.id');		
		if($user_id>1){
		$this->db->where('P.created_by', $user_id);
			}else{
			$this->db->where('P.created_by', $customer_id);
			}	
		if((!empty($from_date_data))&&(!empty($from_date_data))){ 
		$this->db->where('DATE(CRT.referring_datetime) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(CRT.referring_datetime) <=', date('Y-m-d',strtotime($to_date_data)));
		}
		$this->db->order_by("CRT.referral_id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }

	function total_in_store_redemption_mis_listing($srch_string='', $from_date_data, $to_date_data) {
		$user_id 	= $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(BU.f_name LIKE '%$srch_string%' OR BU.user_id LIKE '%$srch_string%' OR LRCC.consumer_id LIKE '%$srch_string%') and (LRCC.brand_customer_id=$user_id)");
	//$this->db->where('LRCC.request_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(LRCC.request_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(LRCC.request_date) <=', date('Y-m-d',strtotime($to_date_data)));
		}else{
				$this->db->where(array('LRCC.brand_customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(BU.f_name LIKE '%$srch_string%' OR BU.user_id LIKE '%$srch_string%' OR LRCC.consumer_id LIKE '%$srch_string%')");
	//$this->db->where('LRCC.request_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(LRCC.request_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(LRCC.request_date) <=', date('Y-m-d',strtotime($to_date_data)));
			}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from("loyalty_redemption_customer_cashier LRCC");
		$this->db->join('backend_user BU', 'LRCC.brand_customer_id = BU.user_id');		
		if($user_id>1){
		$this->db->where('LRCC.brand_customer_id', $user_id);
			}else{
			$this->db->where('LRCC.brand_customer_id', $customer_id);
			}
		
		if (!empty($from_date_data)) {
		//$this->db->where('LRCC.request_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(LRCC.request_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(LRCC.request_date) <=', date('Y-m-d',strtotime($to_date_data)));
		}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
		function in_store_redemption_mis_listing($limit,$start,$srch_string='', $from_date_data, $to_date_data) {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(BU.f_name LIKE '%$srch_string%' OR BU.user_id LIKE '%$srch_string%' OR LRCC.consumer_id LIKE '%$srch_string%') and (LRCC.brand_customer_id=$user_id)");
		//$this->db->where('LRCC.request_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
			$this->db->where('DATE(LRCC.request_date) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->where('DATE(LRCC.request_date) <=', date('Y-m-d',strtotime($to_date_data)));
		}else{
				$this->db->where(array('LRCC.brand_customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(BU.f_name LIKE '%$srch_string%' OR BU.user_id LIKE '%$srch_string%' OR LRCC.consumer_id LIKE '%$srch_string%')");
	//$this->db->where('LRCC.request_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(LRCC.request_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(LRCC.request_date) <=', date('Y-m-d',strtotime($to_date_data)));
			}
		}
		$this->db->select("LRCC.*, BU.*");		
		$this->db->from("loyalty_redemption_customer_cashier LRCC");
		$this->db->join('backend_user BU', 'LRCC.brand_customer_id = BU.user_id');		
		if($user_id>1){
		$this->db->where('LRCC.brand_customer_id', $user_id);
			}else{
			$this->db->where('LRCC.brand_customer_id', $customer_id);
			}
		if (!empty($from_date_data)) {
		//$this->db->where('LRCC.request_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(LRCC.request_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(LRCC.request_date) <=', date('Y-m-d',strtotime($to_date_data)));
		}
		
		$this->db->order_by("LRCC.lrcc_id", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	
	function total_tracek_loyalty_redemption_count($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%') and (P.created_by=$user_id)");
			}else{
				$this->db->where(array('TLC.customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%')");
			}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from("tracek_loyalty_redemption TLC");
		$this->db->join('backend_user BU', 'TLC.tr_user_id = BU.user_id');		
		if($user_id>1){
		$this->db->where('TLC.customer_id', $user_id);
			}else{
			$this->db->where('TLC.customer_id', $customer_id);
			}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
		function tracek_loyalty_redemption_listing($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%') and (P.created_by=$user_id)");
			}else{
				$this->db->where(array('TLC.customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%')");
			}
		}
		$this->db->select("TLC.*, BU.*");		
		$this->db->from("tracek_loyalty_redemption TLC");
		$this->db->join('backend_user BU', 'TLC.tr_user_id = BU.user_id');		
		if($user_id>1){
		$this->db->where('TLC.customer_id', $user_id);
			}else{
			$this->db->where('TLC.customer_id', $customer_id);
			}		
		$this->db->order_by("TLC.tr_lr_id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	
		function total_mis_redemption_microsite_listing($srch_string='', $from_date_data, $to_date_data) {
		$user_id 	= $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(BU.f_name LIKE '%$srch_string%' OR BU.user_id LIKE '%$srch_string%' OR BU.consumer_id LIKE '%$srch_string%') and (CP.customer_id=$user_id)");
	//$this->db->where('CP.transaction_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(CP.transaction_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(CP.transaction_date) <=', date('Y-m-d',strtotime($to_date_data)));
		}else{
				$this->db->where(array('CP.customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(BU.f_name LIKE '%$srch_string%' OR BU.user_id LIKE '%$srch_string%' OR BU.consumer_id LIKE '%$srch_string%')");
	//$this->db->where('CP.transaction_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(CP.transaction_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(CP.transaction_date) <=', date('Y-m-d',strtotime($to_date_data)));	
		}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from("consumer_passbook CP");
		$this->db->join('backend_user BU', 'CP.customer_id = BU.user_id');		
		if($user_id>1){
		//$this->db->where('CP.customer_id', $user_id);
		$this->db->where(array('CP.customer_id'=>$user_id, 'CP.transaction_type_slug'=>"loyalty_redemption_microsite"));
			}else{
			//$this->db->where('CP.customer_id', $customer_id);
			$this->db->where(array('CP.customer_id'=>$customer_id, 'CP.transaction_type_slug'=>"loyalty_redemption_microsite"));
			}
		if (!empty($from_date_data)) {
	//$this->db->where('CP.transaction_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(CP.transaction_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(CP.transaction_date) <=', date('Y-m-d',strtotime($to_date_data)));
		}	
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
		function list_mis_redemption_microsite_listing($limit,$start,$srch_string='', $from_date_data, $to_date_data) {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(BU.f_name LIKE '%$srch_string%' OR BU.user_id LIKE '%$srch_string%' OR BU.consumer_id LIKE '%$srch_string%') and (CP.customer_id=$user_id)");
	//$this->db->where('CP.transaction_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(CP.transaction_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(CP.transaction_date) <=', date('Y-m-d',strtotime($to_date_data)));
    	}else{
				$this->db->where(array('CP.customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(BU.f_name LIKE '%$srch_string%' OR BU.user_id LIKE '%$srch_string%' OR BU.consumer_id LIKE '%$srch_string%')");
	//$this->db->where('CP.transaction_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(CP.transaction_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(CP.transaction_date) <=', date('Y-m-d',strtotime($to_date_data)));
		}
		}
		$this->db->select("CP.*, BU.*");		
		$this->db->from("consumer_passbook CP");
		$this->db->join('backend_user BU', 'CP.customer_id = BU.user_id');		
		if($user_id>1){
		//$this->db->where('CP.customer_id', $user_id);
		$this->db->where(array('CP.customer_id'=>$user_id, 'CP.transaction_type_slug'=>"loyalty_redemption_microsite"));
			}else{
			//$this->db->where('CP.customer_id', $customer_id);
			$this->db->where(array('CP.customer_id'=>$customer_id, 'CP.transaction_type_slug'=>"loyalty_redemption_microsite"));
			}	
		if (!empty($from_date_data)) {
	//$this->db->where('CP.transaction_date BETWEEN "'. date('Y-m-d', strtotime($from_date_data)). '" and "'. date('Y-m-d', strtotime($to_date_data)).'"');
		$this->db->where('DATE(CP.transaction_date) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(CP.transaction_date) <=', date('Y-m-d',strtotime($to_date_data)));
		}		
		$this->db->order_by("CP.id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	
	function total_ispl_billing_list_items_listing($srch_string='', $from_date_data='', $to_date_data='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(customer_id LIKE '%$srch_string%' OR billing_particular_name LIKE '%$srch_string%' OR trans_quantity LIKE '%$srch_string%') and (customer_id=$user_id)");
			$this->db->where('DATE(trans_date_time) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->where('DATE(trans_date_time) <=', date('Y-m-d',strtotime($to_date_data)));
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(customer_id LIKE '%$srch_string%' OR billing_particular_name LIKE '%$srch_string%' OR trans_quantity LIKE '%$srch_string%') and (customer_id=$customer_id)");
			$this->db->or_where('DATE(trans_date_time) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->or_where('DATE(trans_date_time) <=', date('Y-m-d',strtotime($to_date_data)));
			}else{
				$this->db->where(array('customer_id'=>$customer_id));
			}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from("tr_customer_bill_book");
		//$this->db->join('products P', 'CRT.product_id = P.id');		
		if($user_id>1){
		$this->db->where('customer_id', $user_id);
			}else{
			$this->db->where('customer_id', $customer_id);
			}
		if (!empty($from_date_data)) {
			$this->db->where('DATE(trans_date_time) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->where('DATE(trans_date_time) <=', date('Y-m-d',strtotime($to_date_data)));
		}	
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
		function ispl_billing_list_items_listing($limit,$start,$srch_string='', $from_date_data='', $to_date_data='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(customer_id LIKE '%$srch_string%' OR billing_particular_name LIKE '%$srch_string%' OR trans_quantity LIKE '%$srch_string%') and (customer_id=$user_id)");
			$this->db->where('DATE(trans_date_time) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->where('DATE(trans_date_time) <=', date('Y-m-d',strtotime($to_date_data)));
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(customer_id LIKE '%$srch_string%' OR billing_particular_name LIKE '%$srch_string%' OR trans_quantity LIKE '%$srch_string%') and (customer_id=$customer_id)");
			$this->db->or_where('DATE(trans_date_time) >=', date('Y-m-d',strtotime($from_date_data)));
			$this->db->or_where('DATE(trans_date_time) <=', date('Y-m-d',strtotime($to_date_data)));
			}else{
				$this->db->where(array('customer_id'=>$customer_id));
			}
		}
		$this->db->select("*");		
		$this->db->from("tr_customer_bill_book");
		//$this->db->join('products P', 'CRT.product_id = P.id');		
		if($user_id>1){
		$this->db->where('customer_id', $user_id);
			}else{
			$this->db->where('customer_id', $customer_id);
			}	
		if (!empty($from_date_data)) {
		$this->db->where('DATE(trans_date_time) >=', date('Y-m-d',strtotime($from_date_data)));
		$this->db->where('DATE(trans_date_time) <=', date('Y-m-d',strtotime($to_date_data)));
		}
		$this->db->order_by("cbb_id", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }

// Consumer passbook at Customer

	function count_total_list_view_consumer_passbook_at_customer($id,$srch_string='') {
		$customer_id = $this->session->userdata('admin_user_id');
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				//$this->db->where(array('consumer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumer_passbook');
		$this->db->where('consumer_id', $id);
		$this->db->where('customer_id', $customer_id);
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	function list_view_consumer_passbook_at_customer($id,$limit,$start,$srch_string='') {
		$customer_id = $this->session->userdata('admin_user_id');
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				$this->db->where(array('consumer_id'=>$id));
			}
			
			
		$this->db->select("*");
		$this->db->from("consumer_passbook");		
		$this->db->where('consumer_id', $id);
		$this->db->where('customer_id', $customer_id);
		$this->db->order_by("transaction_date", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	/*	function list_view_consumer_passbook_at_customer_dist($id,$limit,$start,$srch_string='') {
		//echo $id;
			//$this->db->where('created_by', $user_id);
			//$id = 88;
			//$id = $this->uri->segment(3);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%' OR customer_id LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				$this->db->where(array('consumer_id'=>$id));
			}
			
			if($this->uri->segment(2)=="list_view_blp_consumer_passbook"){
				$customer_loyalty_type = "Brand";
				}else{
				$customer_loyalty_type = "TRUSTAT";
				}
			
		$this->db->select("*");
		$this->db->from("consumer_passbook");		
		$this->db->where('consumer_id', $id);
		$this->db->where('customer_loyalty_type', $customer_loyalty_type);
		$this->db->group_by('customer_id');
		$this->db->order_by("transaction_date", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
 */
 
 
 	function list_all_packaging_and_ship_out_orders($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		//$customer_id = $this->uri->segment(3);
		if($user_id>1){
			if(!empty($srch_string)){ 
 				$this->db->where("(psoo_id LIKE '%$srch_string%' OR tracek_user_id LIKE '%$srch_string%' OR tracek_user_name LIKE '%$srch_string%' OR tracek_packer_id LIKE '%$srch_string%' OR tracek_packer_name LIKE '%$srch_string%' OR tracek_packer_assigned_byid LIKE '%$srch_string%' OR tracek_packer_assigned_datetime LIKE '%$srch_string%' OR product_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR microsite_url LIKE '%$srch_string%' OR psoo_quantity LIKE '%$srch_string%' OR psoo_product_origin_type LIKE '%$srch_string%' OR psoo_bin_number LIKE '%$srch_string%' OR psoo_token_id LIKE '%$srch_string%' OR psoo_invoice_number LIKE '%$srch_string%' OR psoo_ip_address LIKE '%$srch_string%' OR psoo_city LIKE '%$srch_string%' OR psoo_pin_code LIKE '%$srch_string%' OR psoo_date_time LIKE '%$srch_string%' OR psoo_pack_date_time LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}					
		}else{
			if(!empty($srch_string)){ 
 		$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%'");
			}
		}
		
		$this->db->select("*");
		$this->db->from("packaging_ship_out_order");
		//$this->db->join('role_master RM', 'BU.designation_id = RM.id');
		if($user_id==1){
		$this->db->where('is_parent>', 1);
		} else {
		
		//$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->where('customer_id', $user_id);
		
		}
		$this->db->group_by("psoo_token_id");
		$this->db->order_by("psoo_id", " desc");
		// $this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function total_all_packaging_and_ship_out_orders($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		//$customer_id = $this->uri->segment(3);
		if($user_id>1){
			if(!empty($srch_string)){ 
 				$this->db->where("(psoo_id LIKE '%$srch_string%' OR tracek_user_id LIKE '%$srch_string%' OR tracek_user_name LIKE '%$srch_string%' OR tracek_packer_id LIKE '%$srch_string%' OR tracek_packer_name LIKE '%$srch_string%' OR tracek_packer_assigned_byid LIKE '%$srch_string%' OR tracek_packer_assigned_datetime LIKE '%$srch_string%' OR product_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR microsite_url LIKE '%$srch_string%' OR psoo_quantity LIKE '%$srch_string%' OR psoo_product_origin_type LIKE '%$srch_string%' OR psoo_bin_number LIKE '%$srch_string%' OR psoo_token_id LIKE '%$srch_string%' OR psoo_invoice_number LIKE '%$srch_string%' OR psoo_ip_address LIKE '%$srch_string%' OR psoo_city LIKE '%$srch_string%' OR psoo_pin_code LIKE '%$srch_string%' OR psoo_date_time LIKE '%$srch_string%' OR psoo_pack_date_time LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}					
		}else{
			if(!empty($srch_string)){ 
 		$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%'");
			}
		}
		
		
		$this->db->select("*");
		$this->db->from("packaging_ship_out_order");
		//$this->db->join('role_master RM', 'BU.designation_id = RM.id');
		if($user_id==1){
		$this->db->where('is_parent>', 1);
		} else {
		
		//$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->group_by("psoo_token_id");
		$this->db->where('customer_id', $user_id);
		
		}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
		
		
		
	function list_all_products_packaging_and_ship_out_report($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$psoo_id = $this->uri->segment(3);
		if($user_id>1){
			if(!empty($srch_string)){ 
 				$this->db->where("(psoo_id LIKE '%$srch_string%' OR tracek_user_id LIKE '%$srch_string%' OR tracek_user_name LIKE '%$srch_string%' OR tracek_packer_id LIKE '%$srch_string%' OR tracek_packer_name LIKE '%$srch_string%' OR tracek_packer_assigned_byid LIKE '%$srch_string%' OR tracek_packer_assigned_datetime LIKE '%$srch_string%' OR product_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR microsite_url LIKE '%$srch_string%' OR psoo_quantity LIKE '%$srch_string%' OR psoo_product_origin_type LIKE '%$srch_string%' OR psoo_bin_number LIKE '%$srch_string%' OR psoo_token_id LIKE '%$srch_string%' OR psoo_invoice_number LIKE '%$srch_string%' OR psoo_ip_address LIKE '%$srch_string%' OR psoo_city LIKE '%$srch_string%' OR psoo_pin_code LIKE '%$srch_string%' OR psoo_date_time LIKE '%$srch_string%' OR psoo_pack_date_time LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}					
		}else{
			if(!empty($srch_string)){ 
 		$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%'");
			}
		}
		
		$this->db->select("*");
		$this->db->from("packaging_order_for_ship_out");
		//$this->db->join('role_master RM', 'BU.designation_id = RM.id');
		if($user_id==1){
		$this->db->where('is_parent>', 1);
		} else {		
		//$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		if($this->uri->segment(2)=='products_packaging_and_ship_out_report_by_packaging_id'){
		$this->db->where('psoo_id', $psoo_id);
		}else{
		$this->db->where('customer_id', $user_id);	
		$this->db->order_by("psoo_id", " desc");
		}		
		}
		//$this->db->group_by("psoo_token_id");
		
		// $this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function total_all_products_packaging_and_ship_out_report($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$psoo_id = $this->uri->segment(3);
		if($user_id>1){
			if(!empty($srch_string)){ 
 				$this->db->where("(psoo_id LIKE '%$srch_string%' OR tracek_user_id LIKE '%$srch_string%' OR tracek_user_name LIKE '%$srch_string%' OR tracek_packer_id LIKE '%$srch_string%' OR tracek_packer_name LIKE '%$srch_string%' OR tracek_packer_assigned_byid LIKE '%$srch_string%' OR tracek_packer_assigned_datetime LIKE '%$srch_string%' OR product_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR microsite_url LIKE '%$srch_string%' OR psoo_quantity LIKE '%$srch_string%' OR psoo_product_origin_type LIKE '%$srch_string%' OR psoo_bin_number LIKE '%$srch_string%' OR psoo_token_id LIKE '%$srch_string%' OR psoo_invoice_number LIKE '%$srch_string%' OR psoo_ip_address LIKE '%$srch_string%' OR psoo_city LIKE '%$srch_string%' OR psoo_pin_code LIKE '%$srch_string%' OR psoo_date_time LIKE '%$srch_string%' OR psoo_pack_date_time LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}					
		}else{
			if(!empty($srch_string)){ 
 		$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%'");
			}
		}		
		
		$this->db->select("*");
		$this->db->from("packaging_order_for_ship_out");
		//$this->db->join('role_master RM', 'BU.designation_id = RM.id');
		if($user_id==1){
		$this->db->where('is_parent>', 1);
		} else {
		
		//$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		if($this->uri->segment(2)=='products_packaging_and_ship_out_report_by_packaging_id'){
		$this->db->where('psoo_id', $psoo_id);
		}else{
		$this->db->where('customer_id', $user_id);	
		//$this->db->order_by("psoo_id", " desc");
		}		
		}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	
	 	function list_all_packaging_and_ship_out_order_details($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$psoo_token_id = $this->uri->segment(3);
		if($user_id>1){
			if(!empty($srch_string)){ 
 				$this->db->where("(psoo_id LIKE '%$srch_string%' OR tracek_user_id LIKE '%$srch_string%' OR tracek_user_name LIKE '%$srch_string%' OR tracek_packer_id LIKE '%$srch_string%' OR tracek_packer_name LIKE '%$srch_string%' OR tracek_packer_assigned_byid LIKE '%$srch_string%' OR tracek_packer_assigned_datetime LIKE '%$srch_string%' OR product_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR microsite_url LIKE '%$srch_string%' OR psoo_quantity LIKE '%$srch_string%' OR psoo_product_origin_type LIKE '%$srch_string%' OR psoo_bin_number LIKE '%$srch_string%' OR psoo_token_id LIKE '%$srch_string%' OR psoo_invoice_number LIKE '%$srch_string%' OR psoo_ip_address LIKE '%$srch_string%' OR psoo_city LIKE '%$srch_string%' OR psoo_pin_code LIKE '%$srch_string%' OR psoo_date_time LIKE '%$srch_string%' OR psoo_pack_date_time LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id, 'psoo_token_id'=>$psoo_token_id));
			}					
		}else{
			if(!empty($srch_string)){ 
 		$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%'");
			}
		}
		
		$this->db->select("*");
		$this->db->from("packaging_ship_out_order");
		//$this->db->join('role_master RM', 'BU.designation_id = RM.id');
		if($user_id==1){
		$this->db->where('is_parent>', 1);
		} else {
		
		//$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->where(array('customer_id'=>$user_id, 'psoo_token_id'=>$psoo_token_id));
		
		}
		//$this->db->group_by("psoo_token_id");
		$this->db->order_by("psoo_id", " desc");
		// $this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function total_all_packaging_and_ship_out_order_details($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$psoo_token_id = $this->uri->segment(3);
		if($user_id>1){
			if(!empty($srch_string)){ 
 				$this->db->where("(psoo_id LIKE '%$srch_string%' OR tracek_user_id LIKE '%$srch_string%' OR tracek_user_name LIKE '%$srch_string%' OR tracek_packer_id LIKE '%$srch_string%' OR tracek_packer_name LIKE '%$srch_string%' OR tracek_packer_assigned_byid LIKE '%$srch_string%' OR tracek_packer_assigned_datetime LIKE '%$srch_string%' OR product_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR microsite_url LIKE '%$srch_string%' OR psoo_quantity LIKE '%$srch_string%' OR psoo_product_origin_type LIKE '%$srch_string%' OR psoo_bin_number LIKE '%$srch_string%' OR psoo_token_id LIKE '%$srch_string%' OR psoo_invoice_number LIKE '%$srch_string%' OR psoo_ip_address LIKE '%$srch_string%' OR psoo_city LIKE '%$srch_string%' OR psoo_pin_code LIKE '%$srch_string%' OR psoo_date_time LIKE '%$srch_string%' OR psoo_pack_date_time LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id, 'psoo_token_id'=>$psoo_token_id));
			}					
		}else{
			if(!empty($srch_string)){ 
 		$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%'");
			}
		}
		
		
		$this->db->select("*");
		$this->db->from("packaging_ship_out_order");
		//$this->db->join('role_master RM', 'BU.designation_id = RM.id');
		if($user_id==1){
		$this->db->where('is_parent>', 1);
		} else {
		
		//$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		//$this->db->group_by("psoo_token_id");
		$this->db->where(array('customer_id'=>$user_id, 'psoo_token_id'=>$psoo_token_id));
		
		}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	function  change_assigned_packaging_supervisor($id,$value){
		$this->db->set(array('tracek_user_id'=>$value, 'tracek_user_name'=>getTracekUserFullNameById($value), 'assigned_to_psupervisor_datetime'=>date('Y-m-d h:i:s')));
		$this->db->where(array('psoo_token_id'=>$id));
 		if($this->db->update('packaging_ship_out_order')){//echo '***'.$this->db->last_query();exit;
			return $value;
		}else{
			return '';
		}
	 }
		
	function  change_assigned_packer($id,$value){
		$this->db->set(array('tracek_packer_id'=>$value, 'tracek_packer_name'=>getTracekUserFullNameById($value), 'tracek_packer_assigned_datetime'=>date('Y-m-d h:i:s')));
		$this->db->where(array('psoo_token_id'=>$id));
 		if($this->db->update('packaging_ship_out_order')){//echo '***'.$this->db->last_query();exit;
			return $value;
		}else{
			return '';
		}
	 }
		
}

