<?php
 class Advertisement_model extends CI_Model {
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
		$code_activation_type   = $this->input->post('code_activation_type');
		$delivery_method  		= ($this->input->post('delivery_method'))?$this->input->post('delivery_method'):'';
		$code_key_type  		= ($this->input->post('code_key_type'))?$this->input->post('code_key_type'):'';
		$code_size  			= ($this->input->post('code_size'))?$this->input->post('code_size'):'';		
		## essential attributes
		
		$id			  = $this->input->post('id');
		
		
		 if(!empty($id)){
		 	 $updateArr=array(
					"brand_name"=>$brand_name,
					"attribute_list"=>$product_attr,
					"industry_data"=>$industry,
					"code_type"			  => $code_type,
					"code_activation_type"=> $code_activation_type,
					"delivery_method"	  => $delivery_method,
					"code_key_type"		  => $code_key_type,
					"code_size"			  => $code_size,
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
					"brand_name"		  => $brand_name,
					"attribute_list"	  => $product_attr,
					"industry_data"		  => $industry,
					"product_sku"		  => $product_sku,
					"created_by"		  => $is_parent,
					"status"			  => 1,
					"product_description" => '',
					"product_images"	  => '',
					"product_video"	      => '',
					"product_audio"		  => '',
					"product_pdf"         => '',
					"product_demo_video"	      => '',
					"product_demo_audio"		  => '',
					"product_user_manual"         => '',
					"code_type"			  => $code_type,
					"code_activation_type"=> $code_activation_type,
					"delivery_method"	  => $delivery_method,
					"code_key_type"		  => $code_key_type,
					"code_size"			  => $code_size,
					"other_industry"	  => $Other_industry_val
					
				); //echo '<pre>';print_r($insertData);exit;
				if($this->db->insert("products", $insertData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Product Added Successfully!');
					return true;
				}return false; 
		}
	}
	
	function product_listing($limit,$start,$srch_string='') {
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
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	  
     function fetch_product_detail($id) {
		$this->db->select("*");
		$this->db->from("products");
		$this->db->where("id", $id);
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
		
		function save_feedback($postData){
			 $product_id  	 = $postData['ProductID'];
			 $question_type  = $postData['QuestionType'];
			 $question 		 = $postData['Question'];
			 $answer1 		 = $postData['answer1'];
			 $answer2 		 = $postData['answer2'];
			 $answer3 		 = $postData['answer3'];
			 $answer4 		 = $postData['answer4'];
			 $correct_answer = $postData['correctAns'];
			 
			 $insertData=array(
					"product_id"	  => $product_id,
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
			$where = array('question_type ' => "Product Image Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product Image Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product Video Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product Video Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product Audio Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product Audio Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product PDF Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product PDF Feedback" , 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		function IsProductAdvertisementOn($cid,$pid='') {
			$rows 		= 0;
			$result 	= 'true';
			$this->db->select("id");
			$this->db->from("push_advertisements");
			$this->db->where(array("product_id"=> $pid));
			//if(!empty($id)){
				//$this->db->where("id", $id);
			//}
			$q 		   = $this->db->get();
			$rows 	   = $q->num_rows();
			if($rows>0){
			  $result = 'false';
			} return $result;
		}
		
		function save_push_advertisement($customer_id,$product_id,$promotion_id,$promotion_title,$Chk){
 			if($Chk=='2'){
				//$this->db->query("delete from push_surveys where promotion_id='".$promotion_id."' ");
				
				$data = array(
               'ad_active' => $Chk,
               'abandoned_date' => date('Y-m-d H:i:s')
				);

						$where = array('promotion_id' => $promotion_id);
						$this->db->where($where);
						$this->db->update('push_advertisements ', $data); 


				$this->session->set_flashdata('success', 'Ad un-Pushed Successfully!');
				//echo $this->db->last_query();exit;
				return true;
			}else{
				/*
				$isExists=$this->IsProductAdvertisementOn($cid,$pid); 
				if($isExists=='false'){
					return false;
				}
				*/
				/*  new work */
				/*
				$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{  
				//$consumer_ida = $user->id; 
				//echo $consumer_ida; exit;
				*/
				
								$this->db->select('*');
			$this->db->from('consumer_selection_criteria');
			//$this->db->where('transaction_lr_type', "Loyalty");
			$this->db->where(array('customer_id' => $customer_id, 'promotion_type' => "Advertisement-Video"));
			$query=$this->db->get();						   
        $csc_consumer_gender = $query->row()->consumer_gender;
		$csc_consumer_min_age = $query->row()->consumer_min_age;
		$csc_consumer_max_age = $query->row()->consumer_max_age;
		$csc_consumer_city = $query->row()->consumer_city;
		$csc_consumer_pin = $query->row()->consumer_pin;
		
		function reverse_birthday( $years ){
								return date('Y-m-d', strtotime($years . ' years ago'));
								}
								if($csc_consumer_min_age=='0') {
								$csc_consumer_min_dob = '';
									} else {
								$csc_consumer_min_dob = reverse_birthday( $csc_consumer_min_age );
									}
								if($csc_consumer_max_age=='0') {
								$csc_consumer_max_dob = '';
									} else {
								$csc_consumer_max_dob = reverse_birthday( $csc_consumer_max_age );
									}
		
		//$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
		$AllSelectedConsumersByACustomer = AllSelectedConsumersByACustomer($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_pin, $csc_consumer_min_dob, $csc_consumer_max_dob);
				
				foreach ($AllSelectedConsumersByACustomer as $consumer_id)  
				{ 
				
				$insertData=array(
					"customer_id"	 => $customer_id,
					"consumer_id"	 => $consumer_id,
					"product_id"	 => $product_id,
					"promotion_id"	 => $promotion_id,
					"promotion_title"	 => $promotion_title,
					"media_type"	 => "Advertisements Video",
					"ad_push_date"	 => date("Y-m-d H:i:s"),
					"media_play_date"	 => "0000-00-00 00:00:00",
					"ad_feedback_response"	 => "",
					"ad_active"	 => "1"
					
					);
				  
				  $this->db->insert("push_advertisements", $insertData);
				  
				  
				} 
				
					$this->session->set_flashdata('success', 'Ad Pushed Successfully!');
					return true;
					//redirect('advertisement/launch_advertisement');
					
			}
			return false; 
		}
		
		
		public function sendFCM($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array (
		        'to' => $id,
		         
		         'notification' => array('title' => 'howzzt advertisement', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'howzzt advertisement', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
		);
		$fields = json_encode ( $fields );
		
		$headers = array (
		        'Authorization: key=' . "AAAA446l5pE:APA91bE3nQ0T5E9fOH-y4w_dkOLU1e9lV7Wn0OmVLaKNnE8tXcZ0eC3buduhCwHL1ICaJ882IHfLy-akAe7Nih7M1RewkO9IzAR-ELdPgmORtb7KjriRrQspVHkIb9GRZPOjXuqfPInlOAly5-65sEEUbGlcoujMgw", 'Content-Type: application/json'
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
		
		
		
		public function sendTextFCM($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array (
		        'to' => $id,
		         
		         'notification' => array('title' => 'howzzt text message', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'howzzt text message', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
		);
		$fields = json_encode ( $fields );
		
		$headers = array (
		        'Authorization: key=' . "AAAA446l5pE:APA91bE3nQ0T5E9fOH-y4w_dkOLU1e9lV7Wn0OmVLaKNnE8tXcZ0eC3buduhCwHL1ICaJ882IHfLy-akAe7Nih7M1RewkO9IzAR-ELdPgmORtb7KjriRrQspVHkIb9GRZPOjXuqfPInlOAly5-65sEEUbGlcoujMgw", 'Content-Type: application/json'
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
		
		
		function change_status2($id, $value) {
        $this->db->set(array('request_status' => $value));
        $this->db->where(array('promotion_id' => $id));
        if ($this->db->update('push_promotion_master')) {
            return $value;
        } else {
            return '';
        }
        //echo '***'.$this->db->last_query();exit;
    }
	
	
	
	
	function total_advertisement_listing($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(promotion_request_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR promotion_media_type LIKE '%$srch_string%') and (user_id=$user_id)");
			}else{
				$this->db->where(array('user_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(promotion_request_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR promotion_media_type LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('push_promotion_master');
		$this->db->where('promotion_type', "Advertisement");
		if($user_id>1){
			$this->db->where('user_id', $user_id);
		}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }
	
	
	function advertisement_listing($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(promotion_request_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR promotion_media_type LIKE '%$srch_string%') and (user_id=$user_id)");
			}else{
				$this->db->where(array('user_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(promotion_request_id LIKE '%$srch_string%' OR product_name LIKE '%$srch_string%' OR promotion_media_type LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select("*");
		$this->db->from("push_promotion_master");
		$this->db->where('promotion_type', "Advertisement");
		if($user_id>1){
			$this->db->where('user_id', $user_id);
		}
		
		$this->db->order_by("promotion_id", "desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function save_promotion_request($frmData){ //echo '<pre>';print_r($frmData);exit;
		$user_id 	=$this->session->userdata('admin_user_id');
		//$user_exists = $this->checkDuplicateUser($frmData['user_name']);
		
		$product_arr = $frmData['product'];
		// echo '<pre>kam=';print_r($frmData );exit;
		if(!empty($frmData['promotion_id'])){## edit case
					foreach($product_arr as $product_id){//echo '---'.$product_id;
 						$random_no 				= generate_password(4);
						$product_arr 			= get_products_sku_by_product_id($product_id);
						$order_tracking_no 		= $product_arr[0]['product_sku'];
						
						##------------ check exists entries--------------##
						$check_exists_entry 	= $this->check_product_order( $user_id,$product_id,$frmData['promotion_id']);
						##------------ check exists entries--------------##
						if(!empty($check_exists_entry)){ 
							if(!empty($frmData['deliverydate'])){
								$date = date('Y-m-d',strtotime($frmData['deliverydate']));
							}else{
								$date = '0000-00-00';
							}
 							$UpdateData		 	=array(
								"quantity"				=> $frmData['quantity'],
								"delivery_date"			=>  $date,
								"status"				=> 0,
								"updated_date"			=> date('Y-m-d'),
								"updated_by"			=> '0'
							 ); 
							 $this->db->set($UpdateData);
							 $this->db->where(array('promotion_id'=>$frmData['promotion_id']));
  							if($this->db->update("push_promotion_master")){
								$this->session->set_flashdata('success', 'Push Updated!');
 								$result = 1;
							}else{
								$this->session->set_flashdata('success', 'Push Not Updated!');
								$result = 0;
							}
						 }else{
 							$this->save_promotion_add(json_encode($frmData));
							$result = 1;
						}
					} 
				}else{
						$this->save_promotion_add(json_encode($frmData));
						$result = 1;
					 }return $result;
		  }
		  
		  
		  
		  function save_promotion_add($frmData){//echo '33333==';print_r($frmData);exit;
		$frmData = json_decode($frmData,true);
		$product_arr = $frmData['product'];
		$user_id 	=$this->session->userdata('admin_user_id');
		foreach($product_arr as $product_id){
			$check_exists_entry = 0;
 			//echo '<pre>';print_r($product_arr);exit;
						$random_no 				= generate_password(4);
						$rnpin = mt_rand(1000, 9999);
						$product_arr 			= get_products_sku_by_product_id($product_id);
						$order_tracking_no 		= $product_arr[0]['product_sku']/* .'-'.$rnpin*/;
						$active_status			= $product_arr[0]['code_activation_type'];
						
						
						##------------ check exists entries--------------##
						$check_exists_entry 	= '';//$this->check_product_order( $user_id,$product_id);
						##------------ check exists entries--------------##
						$datecodedno = date('YmdHis');
						if(empty($check_exists_entry)){
							$insertData		 	=array(
								"promotion_request_id"	=> $datecodedno,
								"promotion_title"		=> $frmData['promotion_title'],
								"request_date_time"		=> date('Y-m-d H:i:s'),
								"user_id"				=> $user_id,
								"product_id"			=> $product_id,
								"product_name"			=> $product_arr[0]['product_name'],
								"promotion_media_type"	=> $frmData['promotion_media_type'],
								"number_of_consumers"	=> $frmData['number_of_consumers'],
								"request_status"		=> 0,
								"promotion_type"		=> $frmData['promotion_type'],								
								"updated_by_id"			=> '0'
							 );//echo '<pre>';print_r($insertData);exit;
								if($this->db->insert("push_promotion_master", $insertData)){
									/*
										$get_user_detail= get_user_email_name($user_id);
										$last_inserted = $this->db->insert_id();
										if($last_inserted){
											$user_name = getUserNameById($user_id);
											$last_inserted;
											$this->db->where('promotion_request_id',$last_inserted);
											//$this->db->set(array('order_tracking_number'=>$order_tracking_no));
											$this->db->update('push_promotion_master');
											
										}
										if($this->place_order_mail($product_arr[0]['product_sku'], $product_arr[0]['product_name'], $order_tracking_no,$get_user_detail['email_id'], $user_name)
											 )
											 {
									$this->session->set_flashdata('success', 'Request Placed!');
									$result = 1;
									}else{
									$result = 0;
									}
								
								*/
								$this->session->set_flashdata('success', 'Request Placed!');
								}else{
										$this->session->set_flashdata('success', 'Order Not Placed!');
										$result = 0;
								}
							}else{
								$result = 0;
							}
						} 
		return $result;
	}
	 public function place_order_mail($product_code, $product_name, $tracking_no,$email,$user_name)
	 {//echo '***'.$email;exit;
		$subject    =  'ISPL Admin:: Welcome to Tracking Portal';
		$body			=	"<b>Hello <b>".$user_name."</b>,
								</b><br><br><r>
								 A Order has been Placed.
								<br>Product Code is :".$product_code."<br />
								<br>Product Name is :".$product_name."<br />
								<br>Tracking Order No is :".$tracking_no."<br />
 								 "."".'</b>
								<br><br><br>Thanks & Regards<br><b>Team ISPL</b>';												
		$mail_conf =  array(
		'subject'=>$subject,
		'to_email'=>$email,
		'from_email'=>'admin@innovigents.com',
		'from_name'=> 'ISPL Admin',
		'body_part'=>$body
		);
		if($this->dmailer->mail_notify($mail_conf)){
		 return true;
		} return false;//echo redirect('accounts/create');
	 }
	
	
	function count_advertisement_details($srch_string=''){
		$pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id>1){ 
 			$this->db->where("(S.user_name LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.media_type LIKE '%$srch_string%' OR C.ad_feedback_response LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('push_advertisements C');
		$this->db->join('consumers S', 'S.id = C.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		//$this->db->where(array('C.promotion_id' => $pi_number, 'P.created_by' => $user_id));
		$this->db->where(array('C.promotion_id' => $pi_number));
		if($user_id>1){
			$this->db->where('P.created_by', $user_id);
		}
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 function get_advertisement_details($limit,$start,$srch_string=''){
		 $pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id>1){ 
 			$this->db->where("(S.user_name LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.media_type LIKE '%$srch_string%' OR C.ad_feedback_response LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select(' C.*, P.product_name, S.user_name',false);
		$this->db->from('push_advertisements C');
		$this->db->join('consumers S', 'S.id = C.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		//$this->db->group_by('C.pi_number');
		//$this->db->where(array('C.promotion_id' => $pi_number, 'P.created_by' => $user_id));
		
		$this->db->where(array('C.promotion_id' => $pi_number));
		if($user_id>1){
			$this->db->where('P.created_by', $user_id);
		}
		
   		$this->db->order_by('C.promotion_id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	
	function review_advertisement_data($id) {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where(array('id' => $id));
        $query = $this->db->get(); //echo '**'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            //
            $res = $query->result_array();
        }
        return json_encode($res[0]);
    }
	
	
				
}
		
