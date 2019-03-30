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
		//$code_activation_type  	= ($this->input->post('code_activation_type'))?$this->input->post('code_activation_type'):'';
		$code_activation_type   = $this->input->post('code_activation_type');
		$delivery_method  		= ($this->input->post('delivery_method'))?$this->input->post('delivery_method'):'';
		$code_key_type  		= ($this->input->post('code_key_type'))?$this->input->post('code_key_type'):'';
		$code_size  			= ($this->input->post('code_size'))?$this->input->post('code_size'):'';
		$code_unity_type  		= ($this->input->post('code_unity_type'))?$this->input->post('code_unity_type'):'';	
		$registration_pack  	= ($this->input->post('registration_pack'))?$this->input->post('registration_pack'):'';	
		$retailer_pack  		= ($this->input->post('retailer_pack'))?$this->input->post('retailer_pack'):'';	
		$min_shipper_pack_level  		= ($this->input->post('min_shipper_pack_level'))?$this->input->post('min_shipper_pack_level'):'';	
		$max_shipper_pack_level  		= ($this->input->post('max_shipper_pack_level'))?$this->input->post('max_shipper_pack_level'):'';			
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
					"registration_pack"	  => $registration_pack,
					"retailer_pack"	  	  => $retailer_pack,
					"min_shipper_pack_level"	  => $min_shipper_pack_level,
					"max_shipper_pack_level"	  => $max_shipper_pack_level,
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
					"product_thumb_images"	  => '',
					"product_images"	  => '',
					"product_video"	      => '',
					"product_audio"		  => '',
					"product_pdf"         => '',
					"product_demo_video"	      => '',
					"product_demo_audio"		  => '',
					"product_user_manual"         => '',
					"product_push_ad_video"	      => '',
					"product_survey_video"	      => '',
					"code_type"			  => $code_type,
					"code_activation_type"=> $code_activation_type,
					"delivery_method"	  => $delivery_method,
					"code_key_type"		  => $code_key_type,
					"registration_pack"	  => $registration_pack,
					"retailer_pack"		  => $retailer_pack,
					"min_shipper_pack_level"	=> $min_shipper_pack_level,
					"max_shipper_pack_level"	=> $max_shipper_pack_level,
					"code_size"			  => $code_size,
					"code_unity_type"	  => $code_unity_type,
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
					"brand_name"		  => $brand_name,
					"attribute_list"	  => $product_attr,
					"industry_data"		  => $industry,
					"product_sku"		  => $product_sku,
					"created_by"		  => $is_parent,
					"status"			  => 1,
					"product_description" => '',
					"product_thumb_images"	  => '',
					"product_images"	  => '',
					"product_video"	      => '',
					"product_audio"		  => '',
					"product_pdf"         => '',
					"product_demo_video"	      => '',
					"product_demo_audio"		  => '',
					"product_user_manual"         => '',
					"product_push_ad_video"	      => '',
					"product_survey_video"	      => '',
					"code_type"			  => $code_type,
					"code_activation_type"=> $code_activation_type,
					"delivery_method"	  => $delivery_method,
					"code_key_type"		  => $code_key_type,
					"code_size"			  => $code_size,
					"code_unity_type"	  => $code_unity_type,
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
			$this->session->set_flashdata('success', 'Feedback Question Deleted Successfully!');
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
		
		
		// Product Push Ad Feedback Questions
		function pushed_ad_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product PDF Feedback"); 
			$where = array('question_type ' => "Product Pushed Ad Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product Pushed Ad Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product Survey Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product Survey Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product VDemonstration Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product VDemonstration Feedback" , 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
		// Product Demo Audio Feedback Questions
		function demo_audio_feedback_listing($limit,$start,$srch_string='', $id) {
			$user_id 	= $this->session->userdata('admin_user_id');
			if(!empty($srch_string)){ 
					$this->db->where("(question LIKE '%$srch_string%')");
			} 
			$this->db->select("*");
			$this->db->from("feedback_question_bank");
			//$this->db->where("question_type","Product PDF Feedback"); 
			$where = array('question_type ' => "Product ADemonstration Feedback" , 'product_id ' => $id);
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
			$where = array('question_type ' => "Product ADemonstration Feedback" , 'product_id ' => $id);
			$this->db->where($where);
				$query = $this->db->get(); //echo '***'.$this->db->last_query();
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
				$result_data = $result[0]['total_rows'];
			}
			return $result_data;
		}
		
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
                $this->db->where("(PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%'  OR C.user_name LIKE '%$srch_string%' OR PP.purchase_date LIKE '%$srch_string%') and (P.created_by=$user_id)");
            } else {
                $this->db->where(array('P.created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%'  OR C.user_name LIKE '%$srch_string%' OR PP.purchase_date LIKE '%$srch_string%')");
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
		         
		         'notification' => array('title' => 'howzzt product verifiction', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'howzzt product verifiction', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
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
		
		public function sendFBLRNotification($mess,$id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		
		$fields = array (
		        'to' => $id,
		         
		         'notification' => array('title' => 'howzzt loyalty verification', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'howzzt loyalty verification', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
		       
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
       
	   
	   $TotalAccumulatedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty"))->get()->row();
		$TotalRedeemedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption"))->get()->row();
		
		$FinalTotalAccumulatedPoints = $TotalAccumulatedPoints->points;
		$FinalTotalRedeemedPoints = $TotalRedeemedPoints->points + $points_redeemed;
		
		$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		$Min_Locking_Balance = 100;
		
		$CurrentBalanceAfterMinBalanceLocking = $CurrentBalance - $Min_Locking_Balance;
		$Points_Redeemed_in_Multiple_of = 500;
				
		$remainder = $CurrentBalanceAfterMinBalanceLocking % $Points_Redeemed_in_Multiple_of;
		$quotient = ($CurrentBalanceAfterMinBalanceLocking - $remainder) / $Points_Redeemed_in_Multiple_of;

		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of-$remainder;
        
		
		
		$date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
       // $date->modify('+3    month');
        $input = [
            'customer_id' => 1,
			'consumer_id' => $consumer_id,
            'points' => $points_redeemed,
            'transaction_type_name' => "Loyalty Rewards redemption",
			'transaction_type_slug' => "loyalty_loints_ledeemed",
            'params' => json_encode($params),
            'transaction_lr_type' => $transaction_lr_type,
			'total_accumulated_points' => $FinalTotalAccumulatedPoints,
			'total_redeemed_points' => $FinalTotalRedeemedPoints,
            'current_balance' => $CurrentBalance,
			'points_redeemable' => $Points_Redeemable,
			'points_short_of_redumption' => $PointsShortOfRedumption,
            'transaction_date' => $now
        ];
        
        return $this->db->insert('consumer_passbook',$input);
		
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
		
		// Find Current transuction type
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result->$transactionType;
		
		$TotalAccumulatedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty"))->get()->row();
		$TotalRedeemedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption"))->get()->row();
		
		$result2 = $this->db->select('*')->from('loylties')->where('id', 3)->get()->row();
		$result3 = $this->db->select('*')->from('loylties')->where('id', 4)->get()->row();
		
		
		$FinalTotalAccumulatedPoints = ($TotalAccumulatedPoints->points) + $TRPoints;
		if(($TotalRedeemedPoints->points)!='')
		{
			$FinalTotalRedeemedPoints = $TotalRedeemedPoints->points;
		} else {
			$FinalTotalRedeemedPoints =0;
			}
			
		
		$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		$Min_Locking_Balance = $result2->loyalty_points;
		
		$CurrentBalanceAfterMinBalanceLocking = $CurrentBalance - $Min_Locking_Balance;
		$Points_Redeemed_in_Multiple_of = $result3->loyalty_points;
				
		$remainder = $CurrentBalanceAfterMinBalanceLocking % $Points_Redeemed_in_Multiple_of;
		$quotient = ($CurrentBalanceAfterMinBalanceLocking - $remainder) / $Points_Redeemed_in_Multiple_of;

		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of - $remainder;
		//testing
		$date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
       // $date->modify('+3    month');
        $input = [
            'customer_id' => $customer_id,
			'consumer_id' => $consumer_id,
            'points' => $TRPoints,
            'transaction_type_name' => $transactionTypeName,
			'transaction_type_slug' => $transactionType,
            'params' => json_encode($params),
            'transaction_lr_type' => $transaction_lr_type,
			'total_accumulated_points' => $FinalTotalAccumulatedPoints,
			'total_redeemed_points' => $FinalTotalRedeemedPoints,
            'current_balance' => $CurrentBalance,
			'points_redeemable' => $Points_Redeemable,
			'points_short_of_redumption' => $PointsShortOfRedumption,
            'transaction_date' => $now
        ];
        
        return $this->db->insert('consumer_passbook',$input);
		
    }
	
	function list_all_consumers($limit,$start,$srch_string='') {
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
 			$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%' OR aadhaar_number LIKE '%$srch_string%' OR gender LIKE '%$srch_string%' OR dob LIKE '%$srch_string%' OR registration_address LIKE '%$srch_string%' OR alternate_mobile_no LIKE '%$srch_string%' OR street_address LIKE '%$srch_string%' OR city LIKE '%$srch_string%' OR state LIKE '%$srch_string%' OR pin_code LIKE '%$srch_string%' OR monthly_earnings LIKE '%$srch_string%' OR job_profile LIKE '%$srch_string%' OR education_qualification LIKE '%$srch_string%' OR type_vehicle LIKE '%$srch_string%' OR profession LIKE '%$srch_string%' OR marital_status LIKE '%$srch_string%' OR no_of_family_members LIKE '%$srch_string%' OR loan_car_housing LIKE '%$srch_string%' OR personal_loan LIKE '%$srch_string%' OR credit_card_loan LIKE '%$srch_string%' OR own_a_car LIKE '%$srch_string%' OR house_type LIKE '%$srch_string%' OR last_location LIKE '%$srch_string%' OR life_insurance LIKE '%$srch_string%' OR medical_insurance LIKE '%$srch_string%' OR height_in_inches LIKE '%$srch_string%' OR weight_in_kg LIKE '%$srch_string%' OR hobbies LIKE '%$srch_string%' OR sports LIKE '%$srch_string%' OR entertainment LIKE '%$srch_string%' OR spouse_gender LIKE '%$srch_string%' OR spouse_phone LIKE '%$srch_string%' OR spouse_dob LIKE '%$srch_string%' OR marriage_anniversary LIKE '%$srch_string%' OR spouse_work_status LIKE '%$srch_string%' OR spouse_edu_qualification LIKE '%$srch_string%' OR spouse_monthly_income LIKE '%$srch_string%' OR spouse_loan LIKE '%$srch_string%' OR spouse_personal_loan LIKE '%$srch_string%' OR spouse_credit_card_loan LIKE '%$srch_string%' OR spouse_own_a_car LIKE '%$srch_string%' OR spouse_house_type LIKE '%$srch_string%' OR spouse_height_inches LIKE '%$srch_string%' OR spouse_weight_kg LIKE '%$srch_string%' OR spouse_hobbies LIKE '%$srch_string%' OR spouse_sports LIKE '%$srch_string%' OR spouse_entertainment LIKE '%$srch_string%' OR modified_at LIKE '%$srch_string%'");
			}
		}
		
		$this->db->select("*");
		$this->db->from("consumers");
		if($user_id>1){
			if(!empty($customer_id)){ 
			$this->db->where('created_by', $customer_id);
			}
		}
		
		$this->db->order_by("id", " desc");
		$this->db->limit($limit, $start);
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
 			$this->db->where("user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email LIKE '%$srch_string%' OR aadhaar_number LIKE '%$srch_string%' OR gender LIKE '%$srch_string%' OR dob LIKE '%$srch_string%' OR registration_address LIKE '%$srch_string%' OR alternate_mobile_no LIKE '%$srch_string%' OR street_address LIKE '%$srch_string%' OR city LIKE '%$srch_string%' OR state LIKE '%$srch_string%' OR pin_code LIKE '%$srch_string%' OR monthly_earnings LIKE '%$srch_string%' OR job_profile LIKE '%$srch_string%' OR education_qualification LIKE '%$srch_string%' OR type_vehicle LIKE '%$srch_string%' OR profession LIKE '%$srch_string%' OR marital_status LIKE '%$srch_string%' OR no_of_family_members LIKE '%$srch_string%' OR loan_car_housing LIKE '%$srch_string%' OR personal_loan LIKE '%$srch_string%' OR credit_card_loan LIKE '%$srch_string%' OR own_a_car LIKE '%$srch_string%' OR house_type LIKE '%$srch_string%' OR last_location LIKE '%$srch_string%' OR life_insurance LIKE '%$srch_string%' OR medical_insurance LIKE '%$srch_string%' OR height_in_inches LIKE '%$srch_string%' OR weight_in_kg LIKE '%$srch_string%' OR hobbies LIKE '%$srch_string%' OR sports LIKE '%$srch_string%' OR entertainment LIKE '%$srch_string%' OR spouse_gender LIKE '%$srch_string%' OR spouse_phone LIKE '%$srch_string%' OR spouse_dob LIKE '%$srch_string%' OR marriage_anniversary LIKE '%$srch_string%' OR spouse_work_status LIKE '%$srch_string%' OR spouse_edu_qualification LIKE '%$srch_string%' OR spouse_monthly_income LIKE '%$srch_string%' OR spouse_loan LIKE '%$srch_string%' OR spouse_personal_loan LIKE '%$srch_string%' OR spouse_credit_card_loan LIKE '%$srch_string%' OR spouse_own_a_car LIKE '%$srch_string%' OR spouse_house_type LIKE '%$srch_string%' OR spouse_height_inches LIKE '%$srch_string%' OR spouse_weight_kg LIKE '%$srch_string%' OR spouse_hobbies LIKE '%$srch_string%' OR spouse_sports LIKE '%$srch_string%' OR spouse_entertainment LIKE '%$srch_string%' OR modified_at LIKE '%$srch_string%'");
			}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumers');
		if($user_id>1){
			if(!empty($customer_id)){ 
			$this->db->where('created_by', $customer_id);
			}
		}
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
		//$this->db->where('consumer_id', $id);
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
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				//$this->db->where(array('consumer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumer_passbook');
		$this->db->where('consumer_id', $id);
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
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (consumer_id=$id)");
			}else{
				$this->db->where(array('consumer_id'=>$id));
			}
			
		$this->db->select("*");
		$this->db->from("consumer_passbook");		
		$this->db->where('consumer_id', $id);
		$this->db->order_by("transaction_date", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	
	function list_customerwise_consumer_loyalty($id,$limit,$start,$srch_string='') {
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
			$this->db->where(array('customer_id'=>$id, 'transaction_lr_type'=>"Loyalty"));
		}
		//$this->db->where('customer_id', $id);
		$this->db->where(array('customer_id'=>$id, 'transaction_lr_type'=>"Loyalty"));
		$this->db->order_by("id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	
	function count_total_list_customerwise_consumer_loyalty($id,$srch_string='') {
		
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(transaction_type_name LIKE '%$srch_string%' OR transaction_lr_type LIKE '%$srch_string%' OR current_balance LIKE '%$srch_string%') and (customer_id=$id)");
			}else{
				$this->db->where(array('customer_id'=>$id));
			}			
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('consumer_passbook');
		//$this->db->where('customer_id', $id);
		$this->db->where(array('customer_id'=>$id, 'transaction_lr_type'=>"Loyalty"));
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
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $date->modify('+3    month');
        $input = [
            'customer_id' => 1,
			'user_id' => $userId,
            'points' => $loylty['loyalty_points'],
            'transaction_type' => $loylty['transaction_type'],
            'params' => json_encode($params),
            'status' => 1,
            'modified_at' => $now,
            'created_at' => $now,
            'date_expire' => $date->format('Y-m-d H:i:s')
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
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		//echo $result->$transactionType;
		
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $date->modify('+3    month');
        $input = [
            'customer_id' => $customer_id,
			'user_id' => $userId,
            'points' => $result->$transactionType,
            'transaction_type' => $transactionType,
            'params' => json_encode($params),
            'status' => 1,
            'modified_at' => $now,
            'created_at' => $now,
            'date_expire' => $date->format('Y-m-d H:i:s')
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
	
		
}

