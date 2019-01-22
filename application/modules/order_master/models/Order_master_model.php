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
	
	function get_product_code_details($id)
     {  
	 
	  $id = $this->uri->segment(4);
		$this->db->select('*');
		$this->db->from('printed_barcode_qrcode');
		$this->db->where(array('barcode_qr_code_no'=>$id));
 		$query = $this->db->get();
		 // echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$res = $res[0];
		}
		return $res;
  	}
	
	function get_product_code_transduction_details($id)
     {  
		$this->db->select('*');
		$this->db->from('list_transactions_table');
		$this->db->where(array('id'=>15));
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
						$rnpin = mt_rand(1000, 9999);
						$product_arr 			= get_products_sku_by_product_id($product_id);
						$order_tracking_no 		= $product_arr[0]['product_sku']/* .'-'.$rnpin*/;
						$active_status			= $product_arr[0]['code_activation_type'];
						if(!empty($frmData['deliverydate'])){
								$date = date('Y-m-d',strtotime($frmData['deliverydate']));
							}else{
								$date = '0000-00-00';
							}
						
						##------------ check exists entries--------------##
						$check_exists_entry 	= '';//$this->check_product_order( $user_id,$product_id);
						##------------ check exists entries--------------##
						$datecodedno = date('YmdHis');
						if(empty($check_exists_entry)){
							$insertData		 	=array(
								"order_no"				=> $datecodedno,
								"order_tracking_number"	=> $order_tracking_no,
								"user_id"				=> $user_id,
								"product_name"			=> $product_arr[0]['product_name'],
								"product_sku"			=> $product_arr[0]['product_sku'],
								"product_id"			=> $product_id,
								"quantity"				=> $frmData['quantity'],
								"plant_id"				=> $frmData['plant_id'],
								"delivery_date"			=> $date,
								"status"				=> 0,
								"active_status"			=> $active_status,
								//"delivery_date"			=> date('Y-m-d'),
								"updated_date"			=> date('Y-m-d',strtotime('0')),
								"updated_by"			=> '0'
							 );//echo '<pre>';print_r($insertData);exit;
								if($this->db->insert("order_master", $insertData)){
										$get_user_detail= get_user_email_name($user_id);
										$last_inserted = $this->db->insert_id();
										if($last_inserted){
											$user_name = getUserNameById($user_id);
											$order_tracking_no = $order_tracking_no.'-'/*. str_pad($str,4,"0",STR_PAD_LEFT).'-'*/.$last_inserted;
											$this->db->where('order_id',$last_inserted);
											$this->db->set(array('order_tracking_number'=>$order_tracking_no));
											$this->db->update('order_master');
											
										}
										if($this->place_order_mail($product_arr[0]['product_sku'], $product_arr[0]['product_name'], $order_tracking_no,$get_user_detail['email_id'], $user_name)
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
		if ($query->num_rows() > 0){
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
 			$this->db->where("(product_name LIKE '%$srch_string%' OR order_tracking_number LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR O.order_no LIKE '%$srch_string%')");
		}
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(product_name LIKE '%$srch_string%' OR order_tracking_number LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR O.order_no LIKE '%$srch_string%') and (user_id=$user_id)");
			}else{
				$this->db->where(array('user_id'=>$user_id));
			}
	 	}
		//$this->db->select('count(1) as total_rows');
		//$this->db->from('order_master');
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('order_master O');
		//$this->db->join('print_orders_history P', 'O.order_id= P.order_id');
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
 			$this->db->where("(O.product_name LIKE '%$srch_string%' OR O.order_tracking_number LIKE '%$srch_string%' OR O.product_sku LIKE '%$srch_string%' OR O.order_no LIKE '%$srch_string%')");
		}
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(O.product_name LIKE '%$srch_string%' OR O.order_tracking_number LIKE '%$srch_string%' OR O.product_sku LIKE '%$srch_string%' OR O.order_no LIKE '%$srch_string%') and (O.user_id=$user_id)");
			}else{
				$this->db->where(array('O.user_id'=>$user_id));
			}
	 	}
		/*"SELECT O.`order_tracking_number` , O.`product_name` , O.`product_sku` , O.`quantity` , O.`delivery_date` , O.`status` , P.code_type
FROM `order_master` O
LEFT JOIN print_orders_history P ON O.order_id = P.order_id";
 */
		
		$this->db->select(' O.user_id,O.product_id, O.order_id, O.order_no, O.order_tracking_number , O.product_name, O.product_sku , O.quantity , O.delivery_date , O.created_date , O.order_status ',false);
		$this->db->from('order_master O');
		//$this->db->join('print_orders_history P', 'O.order_id= P.order_id');
		
 		$this->db->order_by('O.created_date','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get();  //echo '***'.$this->db->last_query();
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
		$sql.="order by OM.created_date desc limit $start, $limit";
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
 		if($this->db->update('order_master')){//echo '***'.$this->db->last_query();exit;
			return $value;
		}else{
			return '';
		}
 		  
 		
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
	 
	 
	

	 
	 #### -----------------Printed barcode----------------#####
	 function insert_printed_barcode_qrcode($post, $code, $code2, $code_type,$product_id='',$active_status,$plant_id,$user_id){
		 $order_id 				= base64_decode($post['order_id']);
		 $post_code 			= $code;
		 $post_code2 			= $code2;
		 //$rnpin2 = mt_rand(1000, 9999);
		// $barcode_qr_code_no2   =  $code . '-' . $rnpin2;
			//$print_id = date('YmdHis') . "" . uniqid();
	//return $last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get('order_print_listing')->row();
			//$print_idb1 = $this->last_record();
	$row = $this->db->select("*")->limit(1)->order_by('id',"DESC")->get("order_print_listing")->row();
			$print_id =  $row->id + 1;
			$date = date('m/d/Y h:i:s a', time());
		 $insertData = array(
				"print_id"				=> $print_id,
				"order_id"				=> $order_id,
				"barcode_qr_code_no"	=> $post_code,
				"barcode_qr_code_no2"	=> $post_code2,
				"product_id"			=> $product_id,
				"plant_id"				=> $plant_id,
				"print_user_id"			=> $user_id,
				"active_status"			=> $active_status,
				"customer_id"			=> '0',
				"stock_status"			=> 'Not Received',
				"modified_at"			=> date('Y-m-d H:i:s')
			 ); 
		 
		if($this->db->insert("printed_barcode_qrcode", $insertData)){
			return true;
		}else{
			return false;
		}
	 }
	 
	 
	 function insert_upload_bulk_codes($post, $code, $code2, $active_status, $plant_id, $user_id, $product2_array){
		 $product2_arr = json_decode($product2_array, true); 
		 
		// $order_id 				= base64_decode($post['order_id']);
		 $post_code 			= $code;
		 $post_code2 			= $code2;
		 //$rnpin2 = mt_rand(1000, 9999);
		// $barcode_qr_code_no2   =  $code . '-' . $rnpin2;
			//$print_id = date('YmdHis') . "" . uniqid();
	//return $last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get('order_print_listing')->row();
			//$print_idb1 = $this->last_record();
	//$row = $this->db->select("*")->limit(1)->order_by('id',"DESC")->get("order_print_listing")->row();
			//$print_id =  $row->id + 1;
			$date = date('m/d/Y h:i:s a', time());
			foreach ($product2_arr as $product2s) {
		 $insertData = array(
				"print_id"				=> 1,
				"order_id"				=> 1,
				"barcode_qr_code_no"	=> $post_code,
				"barcode_qr_code_no2"	=> get_product_sku_by_id($product2s) . '-' . $post_code2,
				"pack_level"			=> 0,
				"pack_level2"			=> 0,
				"product_id"			=> $product2s,
				"plant_id"				=> $plant_id,
				"print_user_id"			=> $user_id,
				"active_status"			=> 1,
				"customer_id"			=> 0,
				"stock_status"			=> 'Customer_Code',
				"modified_at"			=> date('Y-m-d H:i:s'),
				"receive_date"			=> date('Y-m-d H:i:s')
			 ); 
		 
		if($this->db->insert("printed_barcode_qrcode", $insertData)){
			$this->session->set_flashdata('success', 'Order Updated!');
 			return true;
		}else{
			$this->session->set_flashdata('success', 'Error!');
 			return false;
		}
	}
 }
	 
	 
	function insert_order_print_listing($post, $code_type){
		 $order_id 				= base64_decode($post['order_id']);
 		 $printer_current_qty 	= $post['qty'];
		 $print_code_type 		= $code_type;
		 $total_quantity 		= $this->get_total_quantity_ordered($order_id) ;
		 $insertData = array(
				//"print_id"			=> $print_id,
				"order_id"			=> $order_id,
				"last_printed_rows"	=> $printer_current_qty,
				"total_quantity"	=> $total_quantity,
				"code_type"			=> $print_code_type
			 ); 
		 
		if($this->db->insert("order_print_listing", $insertData)){
			return true;
		}else{
			return false;
		}
	 }
	 
	 function get_barcode_total_order_print_list_all($srch_string=''){
		$resultData = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.email LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR C.user_name LIKE '%$srch_string%')");
		} 
		*/
		
		if($user_id>1){
			
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR Ppp.plant_name LIKE '%$srch_string%' OR B.user_name LIKE '%$srch_string%') OR PP.barcode_qr_code_no LIKE '%$srch_string%'");
				$this->db->where_in(array('P.created_by'=>$user_id));
				
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR Ppp.plant_name LIKE '%$srch_string%' OR B.user_name LIKE '%$srch_string%') OR PP.barcode_qr_code_no LIKE '%$srch_string%'");
			}
		}
		
		
 		$this->db->select('count(1) as total_rows');
		$this->db->from('printed_barcode_qrcode PP');
		$this->db->join('backend_user B', 'B.user_id = PP.print_user_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		$this->db->join('plant_master Ppp', 'Ppp.plant_id = PP.plant_id');
		//$this->db->where(array('P.created_by' => $user_id));
 		
   		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$resultData = $result[0]['total_rows'];
 		}
		return $resultData;
	 }
	 
	 	
		
 function get_printed_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		/*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR Ppp.plant_name LIKE '%$srch_string%' OR B.user_name LIKE '%$srch_string%') OR PP.barcode_qr_code_no LIKE '%$srch_string%'");
		}
		*/
		
		
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR Ppp.plant_name LIKE '%$srch_string%' OR B.user_name LIKE '%$srch_string%') OR PP.barcode_qr_code_no LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%'");
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR Ppp.plant_name LIKE '%$srch_string%' OR B.user_name LIKE '%$srch_string%') OR PP.barcode_qr_code_no LIKE '%$srch_string%'");
			}
		}
		
 		$this->db->select('PP.*, P.product_name, P.product_sku, P.created_by, B.user_name, Ppp.plant_name, Ppp.address',false);
		$this->db->from('printed_barcode_qrcode PP');
		$this->db->join('backend_user B', 'B.user_id = PP.print_user_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		$this->db->join('plant_master Ppp', 'Ppp.plant_id = PP.plant_id');
		//$this->db->where(array('P.created_by' => $user_id));
   		$this->db->order_by('id','desc');
		
		/*
		$this->db->select(' D.*, S.*, P.product_name, P.product_sku',false);
		$this->db->from('backend_user D');
		$this->db->join('printed_barcode_qrcode S', 'D.user_id = S.customer_id');
		$this->db->join('products P', 'P.id = S.product_id');
   		$this->db->order_by('S.modified_at','desc');
		*/
		
		
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	  function get_total_printed_code_list_all($srch_string=''){
		$result_data = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR Ppp.plant_name LIKE '%$srch_string%' OR B.user_name LIKE '%$srch_string%') OR PP.barcode_qr_code_no LIKE '%$srch_string%'");
		}
		*/
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR Ppp.plant_name LIKE '%$srch_string%' OR B.user_name LIKE '%$srch_string%') OR PP.barcode_qr_code_no LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%'");
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR Ppp.plant_name LIKE '%$srch_string%' OR B.user_name LIKE '%$srch_string%') OR PP.barcode_qr_code_no LIKE '%$srch_string%'");
			}
		}
		
 		$this->db->select('count(1) as total_rows');
		$this->db->from('printed_barcode_qrcode PP');
		$this->db->join('backend_user B', 'B.user_id = PP.print_user_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		$this->db->join('plant_master Ppp', 'Ppp.plant_id = PP.plant_id');
 		$this->db->where(array('P.created_by' => $user_id));
   		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 
	 
	 
	 function count_scanned_barqrcodelist($srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
                    $this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')");                    
		}
		*/
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%') AND P.created_by LIKE '%$user_id%'"); 
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')"); 
			}
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('consumers C');
		$this->db->join('scanned_products S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = S.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 
	 function get_scanned_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 /*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')");              
		}
		*/
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')  AND P.created_by LIKE '%$user_id%'"); 
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')"); 
			}
		}
		
		 
 		$this->db->select(' C.*, S.*, P.product_name, P.product_sku',false);
		$this->db->from('consumers C');
		$this->db->join('scanned_products S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = S.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
   		$this->db->order_by('S.created_at','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 
	 
	  function count_physical_packaging_barqrcodelist($srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.bar_code LIKE '%$srch_string%' OR C.parent_bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.packaging_level LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.bar_code LIKE '%$srch_string%' OR C.parent_bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.packaging_level LIKE '%$srch_string%')"); 
			}
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('packaging_codes_pcr C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->where(array('P.created_by' => $user_id));
		$this->db->join('products P', 'P.id = C.product_id');
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 function get_physical_packaging_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		} */
		 
		 if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.bar_code LIKE '%$srch_string%' OR C.parent_bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.packaging_level LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.bar_code LIKE '%$srch_string%' OR C.parent_bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.packaging_level LIKE '%$srch_string%')"); 
			}
		}
		
 		$this->db->select(' C.*, P.product_name, P.product_sku, P.created_by',false);
		$this->db->from('packaging_codes_pcr C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
   		$this->db->order_by('C.id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 
	 function count_physical_unpackaging_barqrcodelist($srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.bar_code LIKE '%$srch_string%' OR C.parent_bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.packaging_level LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.bar_code LIKE '%$srch_string%' OR C.parent_bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.packaging_level LIKE '%$srch_string%')"); 
			}
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('packaging_codes_pcr C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->where(array('P.created_by' => $user_id));
		$this->db->join('products P', 'P.id = C.product_id');
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 function get_physical_unpackaging_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		} */
		 
		 if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.bar_code LIKE '%$srch_string%' OR C.parent_bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.packaging_level LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.bar_code LIKE '%$srch_string%' OR C.parent_bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR C.packaging_level LIKE '%$srch_string%')"); 
			}
		}
		
 		$this->db->select(' C.*, P.product_name, P.product_sku, P.created_by',false);
		$this->db->from('packaging_codes_pcr C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
   		$this->db->order_by('C.id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 
	 function count_stock_transfer_out_barqrcodelist($srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR P.product_sku LIKE '%$srch_string%' OR C.invoice_number LIKE '%$srch_string%' OR C.location_type LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR P.product_sku LIKE '%$srch_string%' OR C.invoice_number LIKE '%$srch_string%' OR C.location_type LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%')"); 
			}
		}
		
		 
 		$this->db->select('count(1) as total_rows');
		//$this->db->distinct('C.invoice_number');
		$this->db->from('dispatch_stock_transfer_out C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->where(array('P.created_by' => $user_id));
		$this->db->group_by('C.invoice_number');
		$this->db->join('products P', 'P.id = C.product_id');
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 function get_stock_transfer_out_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR P.product_sku LIKE '%$srch_string%' OR C.invoice_number LIKE '%$srch_string%' OR C.location_type LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR P.product_sku LIKE '%$srch_string%' OR C.invoice_number LIKE '%$srch_string%' OR C.location_type LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%')"); 
			}
		}
		
		
		$this->db->select(' C.*, P.product_name, P.product_sku, P.created_by',false);
		$this->db->from('dispatch_stock_transfer_out C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
		$this->db->group_by('C.invoice_number');
   		$this->db->order_by('C.dispatch_id','desc');
		
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 function count_stock_transfer_out_invoice_details($srch_string=''){
		$invoice_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR P.product_sku LIKE '%$srch_string%' OR C.bar_code LIKE '%$srch_string%' OR C.location_type LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR P.product_sku LIKE '%$srch_string%' OR C.bar_code LIKE '%$srch_string%' OR C.location_type LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%')"); 
			}
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('dispatch_stock_transfer_out C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
   		 $this->db->where(array('invoice_number' => $invoice_number, 'P.created_by' => $user_id));
		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 function get_stock_transfer_out_invoice_details($limit,$start,$srch_string=''){
		 $invoice_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
	/*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		} */
		
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR P.product_sku LIKE '%$srch_string%' OR C.bar_code LIKE '%$srch_string%' OR C.location_type LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR P.product_sku LIKE '%$srch_string%' OR C.bar_code LIKE '%$srch_string%' OR C.location_type LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%')"); 
			}
		}
		
		
		$this->db->select(' C.*, P.product_name, P.product_sku, P.product_description',false);
		$this->db->from('dispatch_stock_transfer_out C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		 $this->db->where(array('invoice_number' => $invoice_number, 'P.created_by' => $user_id));
		//$this->db->group_by('C.invoice_number');
   		$this->db->order_by('C.dispatch_id','desc');
		
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 
	 function count_stock_transfer_in_barqrcodelist($srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
                    $this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");                    
		}
		*/
		 
		  if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR C.invoice_number LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR C.invoice_number LIKE '%$srch_string%')"); 
			}
		}
		
 		$this->db->select('count(1) as total_rows');
		$this->db->from('receipt_stock_transfer_in C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
		$this->db->group_by('C.invoice_number');
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 function get_stock_transfer_in_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 */
		 
		 if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR C.invoice_number LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR C.invoice_number LIKE '%$srch_string%')"); 
			}
		}
		
 		$this->db->select(' C.*, P.product_name, P.product_sku, P.created_by',false);
		$this->db->from('receipt_stock_transfer_in C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
		$this->db->group_by('C.invoice_number');
   		$this->db->order_by('C.receipt_id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 function count_stock_transfer_in_invoice_details($srch_string=''){
		$invoice_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR C.bar_code LIKE '%$srch_string%' OR C.code_packaging_level LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR C.bar_code LIKE '%$srch_string%' OR C.code_packaging_level LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%')"); 
			}
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('receipt_stock_transfer_in C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
   		$this->db->where(array('invoice_number' => $invoice_number, 'P.created_by' => $user_id));
		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 function get_stock_transfer_in_invoice_details($limit,$start,$srch_string=''){
		 $invoice_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		*/
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(P.product_name LIKE '%$srch_string%' OR C.bar_code LIKE '%$srch_string%' OR C.code_packaging_level LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");  
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(P.product_name LIKE '%$srch_string%' OR C.bar_code LIKE '%$srch_string%' OR C.code_packaging_level LIKE '%$srch_string%' OR C.location_name LIKE '%$srch_string%')"); 
			}
		}
		
		$this->db->select(' C.*, P.product_name',false);
		$this->db->from('receipt_stock_transfer_in C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('invoice_number' => $invoice_number, 'P.created_by' => $user_id));
		//$this->db->group_by('C.invoice_number');
   		$this->db->order_by('C.receipt_id','desc');
		
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 function count_physical_inventory_check_barqrcodelist($srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
                    $this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");                    
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('physical_inventory_check C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 function get_physical_inventory_check_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select(' C.*, P.product_name, P.product_sku, P.created_by',false);
		$this->db->from('physical_inventory_check C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
		$this->db->group_by('C.pi_number');
   		$this->db->order_by('C.id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 function count_physical_inventory_details($srch_string=''){
		$pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
                    $this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");                    
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('physical_inventory_check C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('pi_number' => $pi_number, 'P.created_by' => $user_id));
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 function get_physical_inventory_details($limit,$start,$srch_string=''){
		 $pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select(' C.*, P.product_name, P.product_sku',false);
		$this->db->from('physical_inventory_check C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		//$this->db->group_by('C.pi_number');
		$this->db->where(array('pi_number' => $pi_number, 'P.created_by' => $user_id));
   		$this->db->order_by('C.id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 function count_physical_inventory_summary($srch_string=''){
		$pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
                    $this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");                    
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('physical_inventory_summary C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('pi_number' => $pi_number, 'P.created_by' => $user_id));
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 function get_physical_inventory_summary($limit,$start,$srch_string=''){
		 $pi_number = $this->uri->segment(3);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select(' C.*, P.product_name, P.product_sku',false);
		$this->db->from('physical_inventory_summary C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		//$this->db->group_by('C.pi_number');
		$this->db->where(array('pi_number' => $pi_number, 'P.created_by' => $user_id));
   		$this->db->order_by('C.pi_summery_n','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 
	 function count_product_code_details($srch_string=''){
		$pi_number = $this->uri->segment(4);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
                    $this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");                    
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('list_transactions_table C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('product_code' => $pi_number, 'P.created_by' => $user_id));
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 function get_product_code_details2($limit,$start,$srch_string=''){
		 $pi_number = $this->uri->segment(4);
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select(' C.*, P.product_name, P.product_sku',false);
		$this->db->from('list_transactions_table C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		//$this->db->group_by('C.pi_number');
		$this->db->where(array('product_code' => $pi_number, 'P.created_by' => $user_id));
   		$this->db->order_by('C.id','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 
	 
	 
	 function count_inventory_on_hand_barqrcodelist($srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
                    $this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");                    
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('inventory_on_hand C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 function get_inventory_on_hand_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')");              
		}
		 
 		$this->db->select(' C.*, P.product_name, P.product_sku, P.product_description, P.created_by',false);
		$this->db->from('inventory_on_hand C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $user_id));
   		$this->db->order_by('C.update_date','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 function get_purchsed_barqrcodelist($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 /*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR C.user_name LIKE '%$srch_string%')");
		}
		*/
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%') AND P.created_by LIKE '%$user_id%'"); 
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')"); 
			}
		}
		
		 
 		$this->db->select(' C.*, PP.*, P.product_name, P.product_sku',false);
		$this->db->from('consumers C');
		$this->db->join('purchased_product PP', 'C.id = PP.consumer_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		$this->db->where(array('P.created_by' => $user_id));
   		$this->db->order_by('PP.ordered_date','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 

	 
	 
	 function get_complaint_log($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 /*
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')");              
		}
		*/
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%') AND P.created_by LIKE '%$user_id%'"); 
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')"); 
			}
		}
		
		 
 		$this->db->select(' C.*, S.*, P.product_name, P.product_sku',false);
		$this->db->from('consumers C');
		$this->db->join('consumer_complaint S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = S.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
   		$this->db->order_by('S.created_at','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 
	 
	 function count_complaint_log($srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
		/*
		if(!empty($srch_string) && $user_id==1){ 
                    $this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')");                    
		}
		*/
		if($user_id>1){
			//$this->db->where('created_by', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')"); 
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(C.user_name LIKE '%$srch_string%' OR C.mobile_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR S.bar_code LIKE '%$srch_string%')"); 
			}
		}
		 
 		$this->db->select('count(1) as total_rows');
		$this->db->from('consumers C');
		$this->db->join('consumer_complaint S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = S.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	
	 
	 function get_feedback_on_product($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
                
                $condition = null;
 
		if(!empty($srch_string) && $user_id > 1){ 
 			$condition= "(C.user_name LIKE '%$srch_string%' OR PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR PP.rating LIKE '%$srch_string%' OR PP.description LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')";
		}
		$total = $this->totalFeedbacksOnProducts($condition);
                if(!empty($condition)){
                    $this->db->where($condition);
                } 
 		$this->db->select(' C.*, PP.*, P.product_name, P.product_sku',false);
		$this->db->from('consumers C');
		$this->db->join('feedback_on_product PP', 'C.id = PP.consumer_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
   		$this->db->order_by('PP.created_at','desc');
                
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return [$total,$resultData];
	 }
	 
	 
	 function totalFeedbacksOnProducts($condition){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
                
                $condition = null;
 
		if(!empty($srch_string) && $user_id>1){ 
 			$condition= "(C.user_name LIKE '%$srch_string%' OR PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' OR PP.rating LIKE '%$srch_string%' OR PP.description LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')";
		}
		
                if(!empty($condition)){
                    $this->db->where($condition);
                } 
                
 		$this->db->select(' C.*, PP.*, P.product_name, P.product_sku',false);
		$this->db->from('consumers C');
		$this->db->join('feedback_on_product PP', 'C.id = PP.consumer_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
   		$this->db->order_by('PP.created_at','desc');
                
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return count($resultData);
	 }
	 
	 
	 
	 function get_warranty_claims($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
                
                $condition = null;
 
		if(!empty($srch_string) && $user_id > 1){ 
 			$condition= "(C.user_name LIKE '%$srch_string%' OR PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')";
		}
		$total = $this->totalWarrantyClaims($condition);
                if(!empty($condition)){
                    $this->db->where($condition);
                } 
 		$this->db->select(' C.*, PP.*, P.product_name, P.product_sku',false);
		$this->db->from('consumers C');
		$this->db->join('purchased_product PP', 'C.id = PP.consumer_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
   		$this->db->order_by('PP.ordered_date','desc');
                
		$this->db->limit($limit, $start);
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return [$total,$resultData];
	 }
	 
	 function totalWarrantyClaims($condition){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
                
                $condition = null;
 
		if(!empty($srch_string) && $user_id> 1){ 
 			$condition= "(C.user_name LIKE '%$srch_string%' OR PP.bar_code LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%' AND P.created_by LIKE '%$user_id%')";
		}
		
                if(!empty($condition)){
                    $this->db->where($condition);
                } 
                
 		$this->db->select(' C.*, PP.*, P.product_name, P.product_sku',false);
		$this->db->from('consumers C');
		$this->db->join('purchased_product PP', 'C.id = PP.consumer_id');
		$this->db->join('products P', 'P.id = PP.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
   		$this->db->order_by('PP.ordered_date','desc');
                
   		$query = $this->db->get(); // echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return count($resultData);
	 }
	 
	 function get_ordered_product_detail($orderId=''){
		$quantity=0;
		if(!empty($orderId)){
			$this->db->select('O.*,P.barcode_qr_code_no ',false);
			$this->db->from('order_master O');
			$this->db->where(array('O.order_id'=>$orderId));
			$this->db->join('printed_barcode_qrcode P', 'O.order_id= P.order_id');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$res 		= $query->result_array();
				$result 	= $res[0];
			}
 		}	return $result;	
	}
	
	
	function view_barcode_ordered_data($product_id,$order_id) {
        $this->db->select('P.*, O.user_id, O.quantity, O.order_tracking_number, O.delivery_date,QR.barcode_qr_code_no',false);
        $this->db->from('products P');
		$this->db->join('order_master O','O.product_id= P.id');
		$this->db->join('printed_barcode_qrcode QR','QR.order_id= O.order_id');
         $this->db->where(array('O.order_id' => $order_id,'O.product_id' => $product_id ));
        $query = $this->db->get();   //echo '**'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        return json_encode($res[0]);
    }
	 #### -----------------Printed barcode----------------#####
	 
	 
	 ##----------- getting all plant controlllers order listing----------------##
	 
	 function get_total_order_list_plcrt($srch_string=''){
		$result_data = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(O.order_no LIKE '%$srch_string%' OR O.product_sku LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%')");
		}
		
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(O.order_no LIKE '%$srch_string%' OR O.product_sku LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%') and (P.created_by=$user_id)");
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}
	 	}
 		 
		$this->db->select('count(1) as total_rows');
		$this->db->from('order_master O');
		$this->db->join('products P','P.id= O.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
		$this->db->order_by('O.created_date','desc'); 
   		$query = $this->db->get();  //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 function get_order_list_plcrt($limit,$start,$srch_string=''){
		$resultData = array();
 		$user_id 	= $this->session->userdata('admin_user_id');
 		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(O.order_no LIKE '%$srch_string%' OR O.product_sku LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%')");
		}
		
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(O.order_no LIKE '%$srch_string%' OR O.product_sku LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%') and (P.created_by=$user_id)");
			}else{
				$this->db->where(array('P.created_by'=>$user_id));
			}
	 	}
		
 		$this->db->select('O.*, P.product_name',false);
		$this->db->from('order_master O');
		$this->db->join('products P','P.id= O.product_id');
		$this->db->where(array('P.created_by'=>$user_id));
		$this->db->order_by('O.created_date','desc');
 		$this->db->limit($limit, $start);
   		$query = $this->db->get();   //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 function get_total_order_list_allx($srch_string=''){
		$result_data = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR order_tracking_number LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR O.order_no LIKE '%$srch_string%')");
		}
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(product_name LIKE '%$srch_string%' OR order_tracking_number LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR O.order_no LIKE '%$srch_string%') and (user_id=$user_id)");
			}else{
				$this->db->where(array('user_id'=>$user_id));
			}
	 	}
		//$this->db->select('count(1) as total_rows');
		//$this->db->from('order_master');
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('order_master O');
		//$this->db->join('print_orders_history P', 'O.order_id= P.order_id');
		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 
	 function get_order_list_allx($limit,$start,$srch_string=''){
		$resultData = array();
		
		$user_id 	= $this->session->userdata('admin_user_id');
		/*if($user_id>1){
			$this->db->where(array('user_id'=>$user_id));
	 	}*/
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(O.product_name LIKE '%$srch_string%' OR O.order_tracking_number LIKE '%$srch_string%' OR O.product_sku LIKE '%$srch_string%' OR O.order_no LIKE '%$srch_string%')");
		}
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(O.product_name LIKE '%$srch_string%' OR O.order_tracking_number LIKE '%$srch_string%' OR O.product_sku LIKE '%$srch_string%' OR O.order_no LIKE '%$srch_string%') and (O.user_id=$user_id)");
			}else{
				$this->db->where(array('O.user_id'=>$user_id));
			}
	 	}
		/*"SELECT O.`order_tracking_number` , O.`product_name` , O.`product_sku` , O.`quantity` , O.`delivery_date` , O.`status` , P.code_type
FROM `order_master` O
LEFT JOIN print_orders_history P ON O.order_id = P.order_id";
 */
		
		$this->db->select(' O.user_id,O.product_id, O.order_id, O.order_no, O.order_tracking_number , O.product_name, O.product_sku , O.quantity , O.delivery_date , O.created_date , O.order_status ',false);
		$this->db->from('order_master O');
		//$this->db->join('print_orders_history P', 'O.order_id= P.order_id');
		
 		$this->db->order_by('O.created_date','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get();  //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 /*function get_order_list_plcrt($product_id,$order_id) {
		 	$sql = "SELECT O.order_id, O.order_tracking_number, O.product_name, O.product_sku, O.quantity, O.delivery_date, O.created_date, O.order_status
			FROM `order_master` `O`
			left join backend_user BU
			ON `O`.`user_id` = BU.user_id
			WHERE `BU`.`is_parent` = '221'
			ORDER BY `O`.`created_date` DESC
			LIMIT 20 ";
	 }*/
	 ##----------- getting all plant controlllers order listing----------------##
	 
	 
	 function get_customer_codes_list_all($limit,$start,$srch_string=''){
		$resultData = array();
		
		$user_id 	= $this->session->userdata('admin_user_id');
		/*if($user_id>1){
			$this->db->where(array('user_id'=>$user_id));
	 	}*/
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(PP.barcode_qr_code_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%')");
		}
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(PP.barcode_qr_code_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%') and (P.created_by=$user_id)");
			}else{
				$this->db->where(array('PP.stock_status'=>"Customer_Code", 'P.created_by'=>$user_id));
			}
	 	}
		
		
		$this->db->select('PP.*, P.created_by, P.product_name');
		$this->db->from('printed_barcode_qrcode PP');
		$this->db->join('products P', 'P.id= PP.product_id');
		//$this->db->where(array('user_id'=>$user_id 'stock_status'=>"Customer_Code"));
		$this->db->where(array('PP.stock_status'=>"Customer_Code", 'P.created_by'=>$user_id));
 		$this->db->order_by('modified_at','desc');
		$this->db->limit($limit, $start);
   		$query = $this->db->get();  //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$resultData = $query->result_array();
 		}
		return $resultData;
	 }
	 
	 function get_total_customer_codes_all($srch_string=''){
		$result_data = 0;
		$user_id 	= $this->session->userdata('admin_user_id');
		
		if(!empty($srch_string) && $user_id==1){ 
 			$this->db->where("(PP.barcode_qr_code_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%')");
		}
		if($user_id>1){
			if(!empty($srch_string)){ 
				$this->db->where("(PP.barcode_qr_code_no LIKE '%$srch_string%' OR P.product_name LIKE '%$srch_string%') and (P.created_by=$user_id)");
			}else{
				$this->db->where(array('PP.stock_status'=>"Customer_Code", 'P.created_by'=>$user_id));
			}
	 	}
		
		$this->db->select('count(1) as total_rows');
		$this->db->from('printed_barcode_qrcode PP');
		$this->db->join('products P', 'P.id= PP.product_id');
		//$this->db->where(array('user_id'=>$user_id 'stock_status'=>"Customer_Code"));
		$this->db->where(array('PP.stock_status'=>"Customer_Code", 'P.created_by'=>$user_id));
		//$this->db->join('print_orders_history P', 'O.order_id= P.order_id');
		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
	 }
	 
	 
	 function delete_customer_code($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('printed_barcode_qrcode')) {
            return '1';
        }
    }
	
	
	function change_customer_code_status($id, $status) {
        $this->db->set(array('active_status' => $status));
        $this->db->where(array('id' => $id));
        if ($this->db->update('printed_barcode_qrcode')) {
            
            return $status;
        } else {
            return '';
        }
    }
	
	
	function get_customer_code_details($id) {

        $this->db->select('id, barcode_qr_code_no, barcode_qr_code_no2, active_status, modified_at');
        $this->db->from('printed_barcode_qrcode');
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
	
	
	function update_customer_code($data) {
        $user_id = $this->session->userdata('admin_user_id');
			$id = $data['code_id'];
               // $this->db->set('profile_photo', $frmData['profile_photo']);
                $UpdateData = array(
                    "barcode_qr_code_no" => $data['barcode_qr_code_no']
                );
             
            $whereData = array(
                'id' => $id
            );

            $this->db->where('id', $id);
				if($this->db->update('printed_barcode_qrcode', $UpdateData)) {// echo '===query===='.$this->db->last_query();
					$this->session->set_flashdata('success', 'Codes Updated Successfully!');
					return true;
	
				}return false; 
        
    }
	
	
	 
	 
	 function get_product_code_parent_details($product_code)
     {  
		$this->db->select('*');
		$this->db->from('packaging_codes_pcr');
		$this->db->where(array('bar_code'=>$product_code));
 		$query = $this->db->get();
		 // echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$res = $res[0];
		}
		return $res;
  	}
	
	public function get_product_code_childern_details ($product_code){
		$this->db->select('*');
			$this->db->where('parent_bar_code',$product_code);
			$result = $this->db->get('packaging_codes_pcr')->result_array();
			return $result;
	}

	 
  }