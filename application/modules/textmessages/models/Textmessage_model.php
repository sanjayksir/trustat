<?php
 class Textmessage_model extends CI_Model {
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
	
	function text_messages_request_listing($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(customer_name LIKE '%$srch_string%' OR text_message LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(customer_name LIKE '%$srch_string%' OR text_message LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select("*");
		$this->db->from("push_text_message_request");
		//if($user_id>1){
			//$this->db->where('created_by', $user_id);
		//}
		
		$this->db->order_by("request_date", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	
			
	
	function total_text_messages_request_listing($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 
		
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(customer_name LIKE '%$srch_string%' OR text_message LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(customer_name LIKE '%$srch_string%' OR text_message LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('push_text_message_request');
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
		
		function save_push_sent_text_message($customer_id,$text_message,$send_status){
				if($send_status=='0'){
				$this->db->query("delete from push_text_message where customer_id='".$customer_id."' ");
				$this->session->set_flashdata('success', 'Text un-Pushed Successfully!');
				//echo $this->db->last_query();exit;
				return true;
			}else{
			
			
 				$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				foreach ($query->result() as $user)  
				{  
				//$consumer_ida = $user->id; 
				//echo $consumer_ida; exit;
				$insertData=array(
					"customer_id"	 => $customer_id,
					"consumer_id"	 => $user->consumer_id,
					"text_message"	 => $text_message,
					"message_push_date"	 => date("Y-m-d H:i:s"),
					"message_active"	 => "1"
					
					);
				  $this->db->insert("push_text_message", $insertData);
				 }
					$this->session->set_flashdata('success', 'Ad Pushed Successfully!');
					return true;
			}
		}
			
			function save_push_text_message_request($customer_id,$text_message,$quantity){
 				
				$insertData=array(
					"customer_id"	 => $customer_id,
					"customer_name"	 => getUserFullNameById($customer_id),
					"text_message"	 => $text_message,
					"quantity"	 	 => $quantity,
					"request_date"	 => date("Y-m-d H:i:s"),
					"send_status"	 => "0"
					);
				  $this->db->insert("push_text_message_request", $insertData);
				
					$this->session->set_flashdata('success', 'Text Message Push Request sent Successfully!');
					return true;
			}
		
		
		function update_push_text_message_request($message_id,$send_status){
 				
				$insertData=array(
					"approval_date"	 => date("Y-m-d H:i:s"),
					"approval_status"	 => $send_status
					);
					$this->db->where('id', $message_id);
				  $this->db->update("purchased_loyalty_points", $insertData);
				
					$this->session->set_flashdata('success', 'Text Message Push Request sent Successfully!');
					return true;
			 
			}
		
		
		public function sendFCM($mess,$id) {
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
		
		
		public function sendTMNotification($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array (
		        'to' => $id,
		         
		         'notification' => array('title' => 'howzzt text message received', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'howzzt text message received', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
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
        $this->db->set(array('push_ad_req' => $value));
        $this->db->where(array('id' => $id));
        if ($this->db->update('products')) {
            return $value;
        } else {
            return '';
        }
        //echo '***'.$this->db->last_query();exit;
    }
	
	
	function send_purchase_points_request($customer_id,$text_comments,$purchasing_points){
 				$random_no = random_num(10);
				$insertData=array(
					"request_id"	 	=> $random_no,
					"customer_id"	 	=> $customer_id,
					"customer_name"	 	=> getUserFullNameById($customer_id),
					"purchasing_points"	=> $purchasing_points,
					"text_comments"	 	=> $text_comments,
					"request_date"	 	=> date("Y-m-d H:i:s"),
					"approval_date"	 	=> "0000-00-00 00:00:00",
					"approval_status"	=> "0"
					);
				  $this->db->insert("purchased_loyalty_points", $insertData);
				
					$this->session->set_flashdata('success', 'Purchase Points Request sent Successfully!');
					return true;
			}
			
			
			
	function get_purchase_points_requests_listing($limit,$start,$srch_string='') {
		
		$user_id 	= $this->session->userdata('admin_user_id');
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(request_id LIKE '%$srch_string%' OR customer_name LIKE '%$srch_string%' OR purchasing_points LIKE '%$srch_string%' OR text_comments LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(request_id LIKE '%$srch_string%' OR customer_name LIKE '%$srch_string%' OR purchasing_points LIKE '%$srch_string%' OR text_comments LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select("*");
		$this->db->from("purchased_loyalty_points");
		if($user_id>1){
			$this->db->where('customer_id', $user_id);
		}
		
		$this->db->order_by("id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	
			
	
	function total_purchase_points_request_listing($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 
		
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(request_id LIKE '%$srch_string%' OR customer_name LIKE '%$srch_string%' OR purchasing_points LIKE '%$srch_string%' OR text_comments LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(request_id LIKE '%$srch_string%' OR customer_name LIKE '%$srch_string%' OR purchasing_points LIKE '%$srch_string%' OR text_comments LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('purchased_loyalty_points');
		if($user_id>1){
			$this->db->where('customer_id', $user_id);
		}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }		


	function total_approved_points($user_id) {
				$this->db->select_sum('purchasing_points');
				$this->db->from('purchased_loyalty_points');
				$this->db->where(array('customer_id'=> $user_id, 'approval_status'=> 1));
				$query=$this->db->get();		
		return $query->row()->purchasing_points;
    }
	
	function waiting_approval_points($user_id) {
				$this->db->select_sum('purchasing_points');
				$this->db->from('purchased_loyalty_points');
				$this->db->where(array('customer_id'=> $user_id, 'approval_status'=> 0));
				$query=$this->db->get();		
		return $query->row()->purchasing_points;
    }
	
	

	
			
	


	function get_approved_purchases_by_customer_listing($id,$limit,$start,$srch_string='') {
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
		$this->db->from("purchased_loyalty_points");	
		
		$this->db->where('customer_id', $id);
		$this->db->order_by("id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function total_approved_purchases_by_customer_listing($id,$srch_string='') {
		
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (customer_id=$id)");
			}else{
				$this->db->where(array('customer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('purchased_loyalty_points');
		$this->db->where('customer_id', $id);
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }



	
}
		
