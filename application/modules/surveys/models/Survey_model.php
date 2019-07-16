<?php
 class Survey_model extends CI_Model {
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
	
	
		function total_survey_listing($srch_string='') {
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
		$this->db->where('promotion_type', "Survey");
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
	
	
	function surveys_listing($limit,$start,$srch_string='') {
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
		$this->db->where('promotion_type', "Survey");
		if($user_id>1){
			$this->db->where('user_id', $user_id);
		}
		
		$this->db->order_by("promotion_id", "desc");
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
		
		function IsProductSurveyOn($cid,$pid='') {
			$rows 		= 0;
			$result 	= 'true';
			$this->db->select("id");
			$this->db->from("push_surveys");
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
		/*
	function AllSelectedConsumersByACustomer2($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_min_dob, $csc_consumer_max_dob){
		$this->db->select('C.id');	
		$this->db->from('consumers C');		
		$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->where('CCL.customer_id', $customer_id);
		
		if(($csc_consumer_gender=='male')||($csc_consumer_gender=='female')) {
		$this->db->where('C.gender', $csc_consumer_gender);
			}
			
		if(!empty($csc_consumer_city)){ 			
		$this->db->where('C.city', $csc_consumer_city);
			}
			
			if(!empty($csc_consumer_min_dob)){ 			
		$ci->db->where('C.dob <', $csc_consumer_min_dob);
			}	
		
		if(!empty($csc_consumer_max_dob)){ 			
		$ci->db->where('C.dob >', $csc_consumer_max_dob);
			}
			
			$query = $this->db->get();
		$result = $query->result();
		return $result;
}
*/

function AllSelectedConsumersByACustomer2($customer_id, $consumer_selection_criteria){
	   	
			
		$this->db->select('C.id');	
		$this->db->from('consumers C');		
		$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->where('CCL.customer_id', $customer_id);
		
		
		
		$query = $this->db->query("SELECT * FROM consumer_selection_criteria WHERE unique_system_selection_criteria_id =  '$consumer_selection_criteria'");
		$row = $query->row();
		//$row->item_id
		
		//$this->db->where('CCL.customer_id', $customer_id);
		
		if($row->consumer_gender!='all') {
		$this->db->where('C.gender', $row->consumer_gender);
			}
		if($row->consumer_city!='all') {
		$this->db->where('C.city', $row->consumer_city);
			}
		
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
			

		$query = $this->db->get();
		$result = $query->result();
		return $result;
}


		
		function save_push_survey($customer_id,$product_id,$promotion_id,$promotion_title,$consumer_selection_criteria,$promotion_media_type,$Chk){
 			if($Chk=='2'){
				//$this->db->query("delete from push_surveys where promotion_id='".$promotion_id."' ");
				
				$data = array(
               'survey_active' => $Chk,
               'abandoned_date' => date('Y-m-d H:i:s')
				);

						$where = array('promotion_id' => $promotion_id);
						$this->db->where($where);
						$this->db->update('push_surveys ', $data); 


				$this->session->set_flashdata('success', 'Survey un-Pushed Successfully!');
				//echo $this->db->last_query();exit;
				return true;
			}else{
				
				/*
				$isExists=$this->IsProductSurveyOn($customer_id,$product_id); 
				if($isExists=='false'){
					return false;
				}
				*/
				/*  new work */
				
				//$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				if($consumer_selection_criteria=="All") {
					
					$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{  
				//$consumer_ida = $user->id; 
				//echo $consumer_ida; exit;
				$insertData=array(
					"customer_id"	 => $customer_id,
					"consumer_id"	 => $user->consumer_id,
					"product_id"	 => $product_id,
					"promotion_id"	 => $promotion_id,
					"promotion_title"	 => $promotion_title,
					"promotion_type"	 => "Survey",
					"media_type"	 => $promotion_media_type,
					"survey_push_date"	 => date('Y-m-d H:i:s'),
					"media_play_date"	 => "0000-00-00 00:00:00",
					"survey_feedback_response"	 => "No",
					"survey_active"	 => "1"
					);
				  
				  $this->db->insert("push_surveys", $insertData);
				  
				} 
					
					}else{
						
		
			
		$AllSelectedConsumersByACustomer = $this->AllSelectedConsumersByACustomer2($customer_id, $consumer_selection_criteria);
				
				foreach ($AllSelectedConsumersByACustomer as $consumer_idArray)  
				{ 
				$consumer_id = $consumer_idArray->id;
				//$consumer_id = $user; 
				//echo $consumer_ida; exit;
				$insertData=array(
					"customer_id"	 => $customer_id,
					"consumer_id"	 => $consumer_id,
					"product_id"	 => $product_id,
					"promotion_id"	 => $promotion_id,
					"promotion_title"	 => $promotion_title,
					"promotion_type"	 => "Survey",
					"media_type"	 => $promotion_media_type,
					"survey_push_date"	 => date('Y-m-d H:i:s'),
					"media_play_date"	 => "0000-00-00 00:00:00",
					"survey_feedback_response"	 => "No",
					"survey_active"	 => "1"
					);
				  
				  $this->db->insert("push_surveys", $insertData);
				  
				  
				} 
				}
					$this->session->set_flashdata('success', 'Survey Pushed Successfully!');
					return true;
			}
			return false; 
		}
		
		
		public function sendFCM($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array (
		        'to' => $id,
		         
		         'notification' => array('title' => 'TRUSTAT survey', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'TRUSTAT survey', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
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
		
		
		
		function change_status($id, $value) {
			$user_id 	=$this->session->userdata('admin_user_id');
			if($value==1){
        $this->db->set(array('request_status' => $value,'updated_by_id' => $user_id,'promotion_launch_date_time' => date('Y-m-d h:i:s')));
			} elseif($value==2){
		$this->db->set(array('request_status' => $value,'updated_by_id' => $user_id,'promotion_closure_date_time' => date('Y-m-d h:i:s')));
			}
        $this->db->where(array('promotion_id' => $id));
        if ($this->db->update('push_promotion_master')) {
            return $value;
        } else {
            return '';
        }
        //echo '***'.$this->db->last_query();exit;
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
		
		
				$arr1 = explode('-',trim($frmData['number_of_consumers_ci']));
				$qty = $arr1[0];
				$unique_system_selection_criteria_id = $arr1[1];
				
		
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
						$datecodedno = $user_id . date('YmdHis');
						if(empty($check_exists_entry)){
							$insertData		 	=array(
								"promotion_request_id"	=> $datecodedno,
								"unique_system_selection_criteria_id"	=> $unique_system_selection_criteria_id,
								"promotion_title"	=> $frmData['promotion_title'],
								"request_date_time"		=> date('Y-m-d H:i:s'),
								"user_id"				=> $user_id,
								"product_id"			=> $product_id,
								"product_name"			=> $product_arr[0]['product_name'],
								"promotion_media_type"	=> $frmData['promotion_media_type'],
								"number_of_consumers"	=> $qty,
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
		  
	

		function  change_order_status($id,$value){
		$this->db->set(array('request_status'=>$value));
		$this->db->where(array('promotion_id'=>$id));
 		if($this->db->update('push_promotion_master')){//echo '***'.$this->db->last_query();exit;
			return $value;
		}else{
			return '';
		}
	 }
	 
	function count_survey_details($srch_string=''){
		$pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id>1){ 
 			$this->db->where("(S.user_name LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.media_type LIKE '%$srch_string%' OR C.survey_feedback_response LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('push_surveys C');
		$this->db->join('consumers S', 'S.id = C.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
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
	 
	 function get_survey_details($limit,$start,$srch_string=''){
		 $pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id>1){ 
 			$this->db->where("(S.user_name LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.media_type LIKE '%$srch_string%' OR C.survey_feedback_response LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select(' C.*, P.product_name, S.user_name, S.mobile_no, email,
																				avatar_url,
																				created_at,
																				aadhaar_number,
																				gender,
																				dob,
																				registration_address,
																				alternate_mobile_no,
																				street_address,
																				city,
																				state,
																				pin_code,
																				monthly_earnings,
																				job_profile,
																				education_qualification,
																				type_vehicle,
																				profession,
																				marital_status,
																				no_of_family_members,
																				loan_car,
																				loan_housing,
																				personal_loan,
																				credit_card_loan,
																				own_a_car,
																				house_type,
																				last_location,
																				life_insurance,
																				medical_insurance,
																				height_in_inches,
																				weight_in_kg,
																				hobbies,
																				sports,
																				entertainment,
																				spouse_gender,
																				spouse_phone,
																				spouse_dob,
																				marriage_anniversary,
																				spouse_work_status,
																				spouse_edu_qualification,
																				spouse_monthly_income,
																				spouse_loan,
																				spouse_personal_loan,
																				spouse_credit_card_loan,
																				spouse_own_a_car,
																				spouse_house_type,
																				spouse_height_inches,
																				spouse_weight_kg,
																				spouse_hobbies,
																				spouse_sports,
																				spouse_entertainment,
																				modified_at,
																				field_1,
																				field_2,
																				field_3,
																				field_4,
																				field_5,
																				field_6,
																				field_7,
																				field_8,
																				field_9,
																				field_10,
																				field_11,
																				field_12,
																				field_13,
																				field_14,
																				field_15,
																				field_16,
																				field_17,
																				field_18,
																				field_19,
																				field_20,
																				field_21,
																				field_22,
																				field_23,
																				field_24,
																				field_25,
																				field_26,
																				field_27,
																				field_28,
																				field_29,
																				field_30,
																				field_31,
																				field_32,
																				field_33,
																				field_34,
																				field_35,
																				field_36,
																				field_37,
																				field_38,
																				field_39,
																				field_40,
																				field_41,
																				field_42,
																				field_43,
																				field_44,
																				field_45,
																				field_46,
																				field_47,
																				field_48,
																				field_49,
																				field_50,
																				field_51,
																				field_52,
																				field_53,
																				field_54,
																				field_55,
																				field_56,
																				field_57,
																				field_58,
																				field_59,
																				field_60,
																				field_61,
																				field_62,
																				field_63,
																				field_64,
																				field_65,
																				field_66,
																				field_67,
																				field_68,
																				field_69,
																				field_70,
																				field_71,
																				field_72,
																				field_73,
																				field_74,
																				field_75,
																				field_76,
																				field_77,
																				field_78,
																				field_79,
																				field_80,
																				field_81,
																				field_82,
																				field_83,
																				field_84,
																				field_85,
																				field_86,
																				field_87,
																				field_88,
																				field_89,
																				field_90,
																				field_91,
																				field_92,
																				field_93,
																				field_94,
																				field_95,
																				field_96,
																				field_97,
																				field_98,
																				field_99,
																				field_100,
																				field_101,
																				field_102,
																				field_103,
																				field_104,
																				field_105,
																				field_106,
																				field_107,
																				field_108,
																				field_109,
																				field_110,
																				field_111,
																				field_112,
																				field_113,
																				field_114,
																				field_115,
																				field_116,
																				field_117,
																				field_118,
																				field_119,
																				field_120,
																				field_121,
																				field_122,
																				field_123,
																				field_124,
																				field_125,
																				field_126,
																				field_127,
																				field_128,
																				field_129,
																				field_130,
																				field_131,
																				field_132,
																				field_133,
																				field_134,
																				field_135,
																				field_136,
																				field_137,
																				field_138,
																				field_139,
																				field_140,
																				field_141,
																				field_142,
																				field_143,
																				field_144,
																				field_145,
																				field_146,
																				field_147,
																				field_148,
																				field_149,
																				field_150,
																				field_151,
																				field_152,
																				field_153,
																				field_154,
																				field_155,
																				field_156,
																				field_157,
																				field_158,
																				field_159,
																				field_160,
																				field_161,
																				field_162,
																				field_163,
																				field_164,
																				field_165,
																				field_166,
																				field_167,
																				field_168,
																				field_169,
																				field_170,
																				field_171,
																				field_172,
																				field_173,
																				field_174,
																				field_175,
																				field_176,
																				field_177,
																				field_178,
																				field_179,
																				field_180,
																				field_181,
																				field_182,
																				field_183,
																				field_184,
																				field_185,
																				field_186,
																				field_187,
																				field_188,
																				field_189,
																				field_190,
																				field_191,
																				field_192,
																				field_193,
																				field_194,
																				field_195,
																				field_196,
																				field_197,
																				field_198,
																				field_199,
																				field_200,
																				field_201, S.id',false);
		$this->db->from('push_surveys C');
		$this->db->join('consumers S', 'S.id = C.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		//$this->db->group_by('C.pi_number');
		//$this->db->where(array('C.promotion_id' => $pi_number, 'C.survey_feedback_response !=' => "NULL"));
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
	

	function count_survey_details_by_question_answer($srch_string=''){
		$pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id>1){ 
 			$this->db->where("(S.user_name LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.media_type LIKE '%$srch_string%' OR C.survey_feedback_response LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('push_surveys C');
		$this->db->join('consumers S', 'S.id = C.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		//$this->db->where(array('C.promotion_id' => $pi_number));
		$this->db->where(array('C.promotion_id' => $pi_number, 'C.survey_feedback_response' => "Yes"));
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
	 
	 function get_survey_details_by_question_answer($limit,$start,$srch_string=''){
		 $pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id>1){ 
 			$this->db->where("(S.user_name LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.media_type LIKE '%$srch_string%' OR C.survey_feedback_response LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select(' C.*, P.product_name, S.user_name, S.mobile_no, email,
																				avatar_url,
																				created_at,
																				aadhaar_number,
																				gender,
																				dob,
																				registration_address,
																				alternate_mobile_no,
																				street_address,
																				city,
																				state,
																				pin_code,
																				monthly_earnings,
																				job_profile,
																				education_qualification,
																				type_vehicle,
																				profession,
																				marital_status,
																				no_of_family_members,
																				loan_car,
																				loan_housing,
																				personal_loan,
																				credit_card_loan,
																				own_a_car,
																				house_type,
																				last_location,
																				life_insurance,
																				medical_insurance,
																				height_in_inches,
																				weight_in_kg,
																				hobbies,
																				sports,
																				entertainment,
																				spouse_gender,
																				spouse_phone,
																				spouse_dob,
																				marriage_anniversary,
																				spouse_work_status,
																				spouse_edu_qualification,
																				spouse_monthly_income,
																				spouse_loan,
																				spouse_personal_loan,
																				spouse_credit_card_loan,
																				spouse_own_a_car,
																				spouse_house_type,
																				spouse_height_inches,
																				spouse_weight_kg,
																				spouse_hobbies,
																				spouse_sports,
																				spouse_entertainment,
																				modified_at,
																				field_1,
																				field_2,
																				field_3,
																				field_4,
																				field_5,
																				field_6,
																				field_7,
																				field_8,
																				field_9,
																				field_10,
																				field_11,
																				field_12,
																				field_13,
																				field_14,
																				field_15,
																				field_16,
																				field_17,
																				field_18,
																				field_19,
																				field_20,
																				field_21,
																				field_22,
																				field_23,
																				field_24,
																				field_25,
																				field_26,
																				field_27,
																				field_28,
																				field_29,
																				field_30,
																				field_31,
																				field_32,
																				field_33,
																				field_34,
																				field_35,
																				field_36,
																				field_37,
																				field_38,
																				field_39,
																				field_40,
																				field_41,
																				field_42,
																				field_43,
																				field_44,
																				field_45,
																				field_46,
																				field_47,
																				field_48,
																				field_49,
																				field_50,
																				field_51,
																				field_52,
																				field_53,
																				field_54,
																				field_55,
																				field_56,
																				field_57,
																				field_58,
																				field_59,
																				field_60,
																				field_61,
																				field_62,
																				field_63,
																				field_64,
																				field_65,
																				field_66,
																				field_67,
																				field_68,
																				field_69,
																				field_70,
																				field_71,
																				field_72,
																				field_73,
																				field_74,
																				field_75,
																				field_76,
																				field_77,
																				field_78,
																				field_79,
																				field_80,
																				field_81,
																				field_82,
																				field_83,
																				field_84,
																				field_85,
																				field_86,
																				field_87,
																				field_88,
																				field_89,
																				field_90,
																				field_91,
																				field_92,
																				field_93,
																				field_94,
																				field_95,
																				field_96,
																				field_97,
																				field_98,
																				field_99,
																				field_100,
																				field_101,
																				field_102,
																				field_103,
																				field_104,
																				field_105,
																				field_106,
																				field_107,
																				field_108,
																				field_109,
																				field_110,
																				field_111,
																				field_112,
																				field_113,
																				field_114,
																				field_115,
																				field_116,
																				field_117,
																				field_118,
																				field_119,
																				field_120,
																				field_121,
																				field_122,
																				field_123,
																				field_124,
																				field_125,
																				field_126,
																				field_127,
																				field_128,
																				field_129,
																				field_130,
																				field_131,
																				field_132,
																				field_133,
																				field_134,
																				field_135,
																				field_136,
																				field_137,
																				field_138,
																				field_139,
																				field_140,
																				field_141,
																				field_142,
																				field_143,
																				field_144,
																				field_145,
																				field_146,
																				field_147,
																				field_148,
																				field_149,
																				field_150,
																				field_151,
																				field_152,
																				field_153,
																				field_154,
																				field_155,
																				field_156,
																				field_157,
																				field_158,
																				field_159,
																				field_160,
																				field_161,
																				field_162,
																				field_163,
																				field_164,
																				field_165,
																				field_166,
																				field_167,
																				field_168,
																				field_169,
																				field_170,
																				field_171,
																				field_172,
																				field_173,
																				field_174,
																				field_175,
																				field_176,
																				field_177,
																				field_178,
																				field_179,
																				field_180,
																				field_181,
																				field_182,
																				field_183,
																				field_184,
																				field_185,
																				field_186,
																				field_187,
																				field_188,
																				field_189,
																				field_190,
																				field_191,
																				field_192,
																				field_193,
																				field_194,
																				field_195,
																				field_196,
																				field_197,
																				field_198,
																				field_199,
																				field_200,
																				field_201, S.id',false);
		$this->db->from('push_surveys C');
		$this->db->join('consumers S', 'S.id = C.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		//$this->db->group_by('C.pi_number');
		$this->db->where(array('C.promotion_id' => $pi_number, 'C.survey_feedback_response' => "Yes"));
		//$this->db->where(array('C.promotion_id' => $pi_number));
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
	 
	function review_survey_data($id) {
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

