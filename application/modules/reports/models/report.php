<?php
 class Order_master_model extends CI_Model
 {
    function __construct()
    {
        parent::__construct();
		$this->load->library(array('Dmailer','form_validation','email'));
     }
 	 

	function get_order_details($id)
     {  
		$this->db->select('*');
		$this->db->from('order_master');
		$this->db->where(array('order_id'=>$id));
 		$query = $this->db->get();
		// echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$res = $res[0];
		}
		return $res;
  	}


	function check_product_order( $user_id='',$product_id='', $order_id=''){
		$result = '';
		$this->db->select('order_id');
		$this->db->from('order_master');
		if(!empty($order_id)){
 			$this->db->where(array('user_id'=>$user_id, 'product_id'=>$product_id, 'order_id'=>$order_id));
		}else{
			$this->db->where(array('user_id'=>$user_id, 'product_id'=>$product_id));
		}
  		$query = $this->db->get();
 		// echo '***'.$this->db->last_query(); 
 		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0]['order_id'];
		}
		return $result;
	}
	 function save_orders($frmData){ //echo '<pre>';print_r($frmData);exit;
		$user_id 	=$this->session->userdata('admin_user_id');
		//$user_exists = $this->checkDuplicateUser($frmData['user_name']);
	 
		$product_arr = $frmData['product'];
		 // echo '<pre>kam=';print_r($frmData );exit;
		if(!empty($frmData['order_id'])){## edit case
					foreach($product_arr as $product_id){//echo '---'.$product_id;
 						$random_no 				= generate_password(4);
						$product_arr 			= get_products_sku_by_product_id($product_id);
						$order_tracking_no 		= $product_arr[0]['product_sku'];
						
						##------------ check exists entries--------------##
						$check_exists_entry 	= $this->check_product_order( $user_id,$product_id,$frmData['order_id']);
						##------------ check exists entries--------------##
						if(!empty($check_exists_entry)){ 
 							$UpdateData		 	=array(
								"quantity"				=> $frmData['quantity'],
								"delivery_date"			=>  date('Y-m-d',strtotime($frmData['deliverydate'])),
								"status"				=> 0,
								"updated_date"			=> date('Y-m-d'),
								"updated_by"			=> '0'
							 ); 
							 $this->db->set($UpdateData);
							 $this->db->where(array('order_id'=>$frmData['order_id']));
  							if($this->db->update("order_master")){
								$this->session->set_flashdata('success', 'Order Updated!');
 								$result = 1;
							}else{
								$this->session->set_flashdata('success', 'Order Not Updated!');
								$result = 0;
							}
						 }else{
 							$this->save_order_add(json_encode($frmData));
							$result = 1;
						}
					} 
				}else{
						$this->save_order_add(json_encode($frmData));
						$result = 1;
					 }return $result;
		  }
	
	
	function save_order_add($frmData){//echo '33333==';print_r($frmData);exit;
		$frmData = json_decode($frmData,true);
		$product_arr = $frmData['product'];
		$user_id 	=$this->session->userdata('admin_user_id');
		foreach($product_arr as $product_id){
			$check_exists_entry = 0;
 			//echo '<pre>';print_r($product_arr);exit;
						$random_no 				= generate_password(4);
						$product_arr 			= get_products_sku_by_product_id($product_id);
						$order_tracking_no 		= $product_arr[0]['product_sku'];
						##------------ check exists entries--------------##
						$check_exists_entry 	= '';//$this->check_product_order( $user_id,$product_id);
						##------------ check exists entries--------------##
						if(empty($check_exists_entry)){
							$insertData		 	=array(
								"order_tracking_number"	=> $order_tracking_no,
								"user_id"				=> $user_id,
								"product_name"			=> $product_arr[0]['product_name'],
								"product_sku"			=> $product_arr[0]['product_sku'],
								"product_id"			=> $product_id,
								"quantity"				=> $frmData['quantity'],
								"delivery_date"			=>  date('Y-m-d',strtotime($frmData['deliverydate'])),
								"status"				=> 0,
								//"delivery_date"			=> date('Y-m-d'),
								"updated_date"			=> date('Y-m-d',strtotime('0')),
								"updated_by"			=> '0'
							 );//echo '<pre>';print_r($insertData);exit;
								if($this->db->insert("order_master", $insertData)){
										$last_inserted = $this->db->insert_id();
										if($last_inserted){
											$order_tracking_no = $order_tracking_no.'-'. str_pad($str,4,"0",STR_PAD_LEFT).'-'.$last_inserted;
											$this->db->where('order_id',$last_inserted);
											$this->db->set(array('order_tracking_number'=>$order_tracking_no));
											$this->db->update('order_master');
											
										}
										if($this->place_order_mail($product_arr[0]['product_sku'], $product_arr[0]['product_name'], $order_tracking_no,'sanjaykumar7pm@gmail.com ')
											 ){
									$result = 1;
									}else{
									$result = 0;
									}
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
	 public function place_order_mail($product_code, $product_name, $tracking_no,$email)
	 {//echo '***'.$email;exit;
		$subject    =  'Admin:: Welcome to Tracking Portal';
		$body			=	"<b>Hello <b>User</b>,
								</b><br><br><r>
								 A Order has been Placed.
								<br>Product Code is :".$product_code."<br />
								<br>Product Name is :".$product_name."<br />
								<br>Tracking Order No is :".$tracking_no."<br />
 								 "."".'</b>
								<br><br><br>Thanks & Regards<br><b>Team Admin</b>';												
		$mail_conf =  array(
		'subject'=>$subject,
		'to_email'=>$email,
		'from_email'=>'admin@'.$_SERVER['SERVER_NAME'],
		'from_name'=> 'Admin',
		'body_part'=>$body
		);
		if($this->dmailer->mail_notify($mail_conf)){
		 return true;
		} return false;//echo redirect('accounts/create');
	 }

	 

	 function checkDuplicateUser($username){
		$result = '';
	 	$this->db->select('plant_id');
		$this->db->from('plant_master');

		$this->db->where(array('plant_name'=>$username));

 		$query = $this->db->get();

		//echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0]['plant_id'];
		}
		return $result;
	 }
	 

	 function checkEmail($email, $uid=''){
		$result = 'true';
 	 	$this->db->select('plant_id');
		$this->db->from('plant_master');
		if(!empty($uid)){
			$this->db->where(array('plant_id!='=>$uid));
		}
		$this->db->where(array('email_id'=>$email));
 		$query = $this->db->get();
		//echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0]['plant_id'];
			$result = 'false';
		}
		return $result;
	 }	
	 
	  function checkPantName($plantName,$uid=''){
		$result = 'true';
 	 	$this->db->select('plant_id');
		$this->db->from('plant_master');
		if(!empty($uid)){
			$this->db->where(array('plant_id!='=>$uid));
		}
		$this->db->where(array('plant_name'=>$plantName));
 		$query = $this->db->get();
		 //echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			if(!empty($res[0]['plant_id'])){
				$result ='false';
			}
 		}
		//echo '==='.$result;exit;
		return $result;
	 }	
	 ## List Users
	 function get_user_list($user_session_Id){
		$result = '';
	 	$this->db->select('*');
		$this->db->from('plant_master');

		$this->db->where(array('created_by'=>$user_session_Id));

 		$query = $this->db->get();

		//echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
 		}
		return $result;
	 }
	 function get_total_order_list_all($srch_string=''){
		$result_data = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%')");
		}
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%') and (user_id=$user_id)");
			}else{
				$this->db->where(array('user_id'=>$user_id));
			}
	 	}
		$this->db->select('count(1) as total_rows');
		$this->db->from('order_master');
   		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 function get_order_list_all($limit,$start,$srch_string=''){
		$resultData = array();
		
		$user_id 	= $this->session->userdata('admin_user_id');
		/*if($user_id>1){
			$this->db->where(array('user_id'=>$user_id));
	 	}*/
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%')");
		}
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%') and (user_id=$user_id)");
			}else{
				$this->db->where(array('user_id'=>$user_id));
			}
	 	}
		
		
		$this->db->select('*');
		$this->db->from('order_master');
 		$this->db->order_by('order_id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 ## For plnat controller
	  function get_total_order_list_all_plant_ctrl($srch_string=''){
		$result_data = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		$sql = "select count(1) as total_rows from order_master OM inner join assign_plants_to_users PL ON PL.assigned_by=OM.user_id  where PL.user_id = '".$user_id ."'";
		if(!empty($srch_string)){ 
 			$sql.="and (product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%')";
		}
	 
   		$query = $this->db->query($sql); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	  function get_order_list_all_plant_ctrl($limit,$start,$srch_string=''){
		$resultData = array();
		
		$user_id 	= $this->session->userdata('admin_user_id');
		 
		$sql = "select OM.*,PL.user_id as UID from assign_plants_to_users PL right JOIN order_master OM ON PL.assigned_by=OM.user_id where PL.user_id = '".$user_id ."'";
		if(!empty($srch_string)){ 
 			$sql.="and (product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%')";
		}
		$sql.="order by OM.order_id desc limit $start, $limit";
		/*$this->db->select('*');
		$this->db->from('order_master');
 		$this->db->order_by('order_id','desc');
		$this->db->limit($limit, $start);*/
   		$query = $this->db->query($sql); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 ####
	 
	 
	 function  change_status($id,$value){
		$this->db->set(array('status'=>$value));
		$this->db->where(array('order_id'=>$id));
 		if($this->db->update('order_master')){
			return $value;
		}else{
			return '';
		}
 		 // echo '***'.$this->db->last_query();exit;
 		
	 }
	 function  change_order_status($id,$value){
		$this->db->set(array('order_status'=>$value));
		$this->db->where(array('order_id'=>$id));
 		if($this->db->update('order_master')){
			return $value;
		}else{
			return '';
		}
 		 // echo '***'.$this->db->last_query();exit;
 		
	 }
	 
	 function get_city_listing($state_id){
	 	$res = 0;
 		$this->db->select('id, ci_name');
 		$this->db->from('city');
 		$this->db->where(array('state_id'=>$state_id));
 		$query = $this->db->get();
 		if ($query->num_rows() > 0) {
 			$res = $query->result_array();
 		}
 		return $res; 
	 }
	 
	 
	  function fetch_city_name($id){
	 	$res = 0;
 		$this->db->select('id, ci_name');
 		$this->db->from('city');
 		$this->db->where(array('id'=>$id));
 		$query = $this->db->get();
 		if ($query->num_rows() > 0) {
 			$res = $query->result_array();
			$result = $res[0]['ci_name'];
 		}
 		return $res; 
	 }

	
	function save_assign_plants_sku($plant_array, $sku_array)
    { 	//echo '<pre>';print_r($frmData);exit;
		$plant_arr 		= json_decode($plant_array,true);
		$sku_arr 		= json_decode($sku_array,true);
		$user_id 		= $this->session->userdata('admin_user_id');
 		if(!empty($frmData['plant_id'])){
 			/*$UpdateData = array(
				"plant_id"	=> $frmData['plant_name'],
				"product_id"		=> $frmData['user_email'],
  				"assigned_by"	=> $user_id
  			);

			$whereData = array(
            	'plant_id' => $frmData['plant_id']
        	);

			$this->db->set($UpdateData);
			$this->db->where($whereData);
			if($this->db->update('plant_master')){
				// echo '***'.$this->db->last_query();exit;
				 $this->session->set_flashdata('success', 'Plant Assigned Successfully!');
 				 return 1;
 			}*/
 		}else{ 
 			//$password = generate_password(6);
			
			foreach($plant_arr as $plant){
				foreach($sku_arr as $sku){
					
					$insertData=array(
						"plant_id"		=> $plant,
						"product_id"	=> $sku,
						"assigned_by"	=> $user_id
					 ); 
					 if($this->check_exists($plant,$sku)==0){
						  $this->db->insert("assign_plants", $insertData);
					 }
				}
 			}
			$this->session->set_flashdata('success', 'Plant Assigned Successfully!');
 			return 1;
 		}
		return '0';
      }
	  
	 function save_assign_plants_users($plant_array, $users)
    { 	 //echo '<pre>cccccccc';print_r($plant_array);exit;
		$plant_arr 		= json_decode($plant_array,true);		 
		$user_id 		= $this->session->userdata('admin_user_id');
 		foreach($plant_arr as $plants){
			$insertData = array(
				"plant_id"		=> $plants,
				"user_id"		=> $users,
				"assigned_by"	=> $user_id
			 ); 
			 if($this->check_exists_users_plant($plants,$users)==0){
				  $this->db->insert("assign_plants_to_users", $insertData);
				 // echo $this->db->last_query();
			 }
		}
		$this->session->set_flashdata('success', 'Plant Assigned Successfully!');
		return 1; 
 		 
      } 
	  function check_exists_users_plant($plant_id, $userid){
	  	$this->db->select('id');
 		$this->db->from('assign_plants_to_users');
 		$this->db->where(array('plant_id'=>$plant_id, 'user_id'=>$userid));
 		$query = $this->db->get(); //echo $this->db->last_query();
 		if ($query->num_rows() > 0) {
 			$res = $query->result_array();
			$result = $res[0]['id'];
 		}
 		return $result; 
	  }
	  
	  function check_exists($plant_id, $product_id){
	  	$this->db->select('plant_id');
 		$this->db->from('assign_plants');
 		$this->db->where(array('plant_id'=>$plant_id, 'product_id'=>$product_id));
 		$query = $this->db->get();
 		if ($query->num_rows() > 0) {
 			$res = $query->result_array();
			$result = $res[0]['plant_id'];
 		}
 		return $result; 
	  }
	function qry_change_assign_product_status($id,$value){//print_r($this->input->post());
		$this->db->set(array('status'=>$value));
		$this->db->where(array('plant_id'=>$id));
 		if($this->db->update('plant_master')){
			 //echo '***'.$this->db->last_query();exit;
			return $value;
		}else{
			return '';
		}
 	 }
	 
	 function qry_change_assign_plant_status($id,$value,$plant_id){
	 $run_query = 1;
	 $plant_arr = explode(',',$plant_id) ;
	// print_r($plant_arr);exit;
	 foreach( $plant_arr as $pltId){
 			$this->db->set(array('status'=>$value));
			$this->db->where(array('plant_id'=>$pltId, 'user_id'=>$id));
			if(!$this->db->update('assign_plants_to_users')){//echo '**'.$this->db->last_query();exit;
 				$run_query=0;
			}			 
		}return $value;
 	 }
	 
	function get_total_quantity_ordered($orderId=''){
		$quantity=0;
		if(!empty($orderId)){
			$this->db->select('quantity');
			$this->db->from('order_master');
			$this->db->where(array('order_id'=>$orderId));
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$res 		= $query->result_array();
				$quantity 	= $res[0]['quantity'];
			}
 		}	return $quantity;	
	}
	
	
	function get_quantity_print_order_history($orderId=''){
		$result = array();
		if(!empty($orderId)){
			$this->db->select('last_printed_rows,total_quantity');
			$this->db->from('print_orders_history');
			$this->db->where(array('order_id'=>$orderId));
			$query 		= $this->db->get();//echo $this->db->last_query();
			if ($query->num_rows() > 0) {
				$res 	= $query->result_array();
				$result = $res[0];
			}
			return $result;				
		}		
	}
	 
	 function insert_print_history($post, $code_type){
		 $order_id 				= base64_decode($post['order_id']);
 		 $printer_current_qty 	= $post['qty'];
		 $print_code_type 		= $code_type;
		 $total_quantity 		= $this->get_total_quantity_ordered($order_id) ;
		 $insertData = array(
				"order_id"			=> $order_id,
				"last_printed_rows"	=> $printer_current_qty,
				"total_quantity"	=> $total_quantity,
				"code_type"			=> $print_code_type
			 ); 
		 
		if($this->db->insert("print_orders_history", $insertData)){
			return true;
		}else{
			return false;
		}
	 }
	 
	 function updatet_print_history($post, $code_type,$last_qty){
		 $order_id 				= base64_decode($post['order_id']);
 		 $printer_current_qty 	= $last_qty+$post['qty'];
		 $print_code_type 		= $code_type;
		 $total_quantity 		= $this->get_total_quantity_ordered($order_id) ;
		  
		 $updateData = array(		
				"last_printed_rows"	=> $printer_current_qty,
				"total_quantity"	=> $total_quantity,
				"code_type"			=> $print_code_type
			 ); 
		$this->db->set($updateData);
		$this->db->where(array("order_id"	=> $order_id)); 
		if($this->db->update("print_orders_history")){
			return true;
		}else{
			return false;
		}
	 }
	 
	 
  }