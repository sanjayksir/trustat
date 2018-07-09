<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Order_master extends MX_Controller {
      public function __construct() { 
        parent::__construct();
 		$this->load->model(array('order_master_model'));
  		$this->load->helper(array('common_functions_helper'));
   		$user_id 	= $this->session->userdata('admin_user_id');
 		$user_name 	= $this->session->userdata('user_name');
		$this->load->library('pagination');
		
		//echo '***'.base64_decode($this->uri->segment(3));
 		if(empty($user_id) || empty($user_name)){
 			redirect('login');	exit;
		}
      }
	  
      public function list_orders_bkp() {
 		 $data					= array();
  		 $user_id 	= $this->session->userdata('admin_user_id');		
		 $data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
   		 $this->load->view('list_order_tpl', $data);
     }
	 
	 
     public function list_orders() {
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
        $total_records = $this->order_master_model->get_total_order_list_all($srch_string);

        $params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/list_orders', $total_records);

        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_order_tpl', $params);
    }

	
	public function list_orders_at_plant_controllers() {
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
        $total_records = $this->order_master_model->get_total_order_list_all($srch_string);

        $params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/list_orders_at_plant_controllers', $total_records);

        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_orders_at_plant_controllers_tpl', $params);
    }
	
    ## For Plant Controllers
	 public function list_orders_plant_controlllers() {
 		##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page =20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->order_master_model->get_total_order_list_all($srch_string);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index,$srch_string);
             
            $config['base_url'] = base_url() . 'order_master/list_orders_plant_controlllers';
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
  		 $data					= array();
  		 $user_id 	= $this->session->userdata('admin_user_id');		
		 //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
   		 $this->load->view('list_order_plant_ctrl_tpl', $params);
     }
	 
	 
	## For listing all Plant Controllers of a perticular cc admin
	public function list_orders_plant_controlllers_CC() {
 		##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page =20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->order_master_model->get_total_order_list_plcrt($srch_string);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["orderListing"] = $this->order_master_model->get_order_list_plcrt($limit_per_page, $start_index,$srch_string);
             
            $config['base_url'] = base_url() . 'order_master/list_orders_plant_controlllers_CC';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 4;
             
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
  		 $data					= array();
  		 $user_id 	= $this->session->userdata('admin_user_id');		
		 //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
   		 $this->load->view('list_order_plabnt_ctrl_tpl_CC', $params);
     }
	 
	 
	  public function save_order() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->order_master_model->save_orders($savedData);  exit;
      }
  
     public function add_order() {
 		 $data					= array();
   		 $this->load->view('add_plant', $data); 
      }
	  
	/*  public function edit_product($id) {
 		 $data					= array();
   		 $this->load->view('edit_product', $data); 
      }*/
 
	 public function edit_product($id) {
 		 $data					= array();
		 $id 					= $this->uri->segment(3);//$this->session->userdata('admin_user_id');
 		 $data['product_data'] 	= $this->order_master_model->get_order_details($id);
    	 $this->load->view('edit_product', $data); 
     }

 	

 	   public function checkUnameEmail(){
 		$uid = $this->input->post('userid');

	  	$email = $this->input->post('user_email');

		$isExists = $this->plant_master_model->checkEmail($email,$uid);

		echo $isExists;exit;	

	  }
	  
	   public function checkPlantName(){
		$plant_id = '';
		$plant_id = $this->input->post('plant_id');
 	  	$plant_name = $this->input->post('plant_name');
 		$isExists = $this->plant_master_model->checkPantName($plant_name,$plant_id);
 		echo $isExists;exit;	
 	  }
	  
	  
	   public function change_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='0';# Now it will be inactive
		 }
		 //$user_id 	= $this->session->userdata('admin_user_id');		
		 echo $status= $this->order_master_model->change_status($id,$status);exit;
   		  
     }
	 
	   public function change_order_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
 		 echo $status= $this->order_master_model->change_order_status($id,$status);exit;
      }
	 
	 
	 
	  public function view_order() {
 		 $data						= array();
		 $id 						= $this->uri->segment(3);//$this->session->userdata('admin_user_id');
 		 $data['getData'] 	= $this->order_master_model->get_order_details($id);
   		 $this->load->view('view_order', $data);
     }
	 
	   public function assign_plants() {
 		 $data						= array();
 		 $data['get_user_details'] 	= $this->plant_master_model->get_plant_details();
   		 $this->load->view('assign_plant', $data); 

     }
	  public function save_assign_plant() {
			$result = '';
			$plant_array = $this->input->post('plants');
			$sku_array = $this->input->post('sku_product');
			if(count($plant_array)>0 && count($sku_array)>0){
				$result = $this->plant_master_model->save_assign_plants_sku(json_encode($plant_array), json_encode($sku_array));	
			}
			return $result;
	
		 }
		 
		public function save_assign_user_to_pant() {
			$result = '';
			$plant_array = json_encode($this->input->post('plants'));
			$user		 = $this->input->post('user');
 			if(count($this->input->post('plants'))>0 && count($user)>0){
				$result = $this->plant_master_model->save_assign_plants_users($plant_array, $user);	
			}
			return $result;
 		 } 
		 
		 
		public function getProductList() {
			$result = '';
			$id = $this->input->post('id');
			$user_id 	= $this->session->userdata('admin_user_id');
			## assigned products array
			$assigned_arr = explode(',',get_assigned_products_list($id));
			//print_r($assigned_arr);
			
			$product_data = get_all_products_sku($user_id);
			 foreach($product_data as $res){?>
            <option value="<?php echo $res['id'];?>" <?php if(in_array($res['id'],$assigned_arr )){echo 'selected';}?>><?php echo $res['product_name'];?></option>
          <?php }
			return $result;
	
		 }
		 
 		 public function list_assigned_plants_sku() {
			 $data					= array();
			 $user_id 				= $this->session->userdata('admin_user_id');		
			 $data['plant_data'] 	= get_all_plants($user_id);
			 $this->load->view('list_plant_sku_assign', $data);
     	}
		
		public function change_assign_product_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='0';# Now it will be inactive
		 }
		 //$user_id 	= $this->session->userdata('admin_user_id');		
		 echo $status= $this->plant_master_model->qry_change_assign_product_status($id,$status);exit;
   		  
     }
	 
	 
	  public function assign_plant_to_users() {
 		 $data						= array();
 		 $data['get_user_details'] 	= $this->plant_master_model->get_plant_details();
   		 $this->load->view('assign_plant_to_users_tpl', $data); 
     }
	 
	 public function getPlantList() {
			$result = '';
			$id 			= $this->input->post('id');
			$user_id 		= $this->session->userdata('admin_user_id');
			## assigned plants array
 			$assigned_arr = explode(',',get_assigned_plants_list($id));
			
			//print_r($assigned_arr);exit;
			
 			$product_data 	= get_all_plants($user_id);
			 foreach($product_data as $res){?>
				<option value="<?php echo $res['plant_id'];?>" <?php if(in_array($res['plant_id'],$assigned_arr )){echo 'selected';}?>><?php echo $res['plant_name'];?></option>
          <?php }
			return $result;
	 }
	 
	 
	  public function list_assigned_plants_user() {
			 $data					= array();
			 $parent_id				= $this->session->userdata('admin_user_id');		
			 $data['plant_data'] 	= get_all_users($parent_id);
			 $this->load->view('list_plant_user_assign', $data);
     	}
		
		
		public function change_assign_plant_status() {
 		 $id = $this->input->post('id');
		 $plantsId = $this->input->post('plant_id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='0';# Now it will be inactive
		 }
		 //$user_id 	= $this->session->userdata('admin_user_id');		
		 echo $status= $this->plant_master_model->qry_change_assign_plant_status($id,$status,$plantsId);exit;
   		  
     }
	 
	 
	 
	 ## Generate Order QR CODE	 
	 function generate_order($id=''){
		 
		$userid 				= base64_decode($this->input->post('order_id')); 
		$barcodesize 			= $this->input->post('barcodesize'); 
 		//$userOrderData 			= view_order_data($userid);
		//echo '<pre>';print_r($userOrderData);exit;
		// echo '***'.$pass_id = base64_decode($this->uri->segment(3));exit;
		//$data_display = view_order_data();
		 if(empty($id)){
				//redirect('login');	exit;
		 } 
			ob_clean();
			require_once('tcpdf/examples/tcpdf_include.php');
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			 
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			
			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
 			// ---------------------------------------------------------
 			// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.
 			// set font
			$pdf->SetFont('', '', 10);
 			$pdf->setPrintHeader(false);
 			// add a page
			$pdf->AddPage();
   			//$userid 				= base64_decode($this->input->post('order_id'));
 			$userOrderData 			= view_order_data($userid);
			//echo '<pre>';print_r($userOrderData);exit;
			$product_id 			= $userOrderData['product_id'];
			$plant_id 				= $userOrderData['plant_id'];
			$active_status 			= $userOrderData['active_status'];
			$barcode_no 			= $userOrderData['order_tracking_number'];
   			$username				= getUserFullNameById($userOrderData['user_id']);
			$user_id				= $userOrderData['user_id'];
 			$product_name			= $userOrderData['product_name'];
			$product_sku			= $userOrderData['product_sku'];
			$quantity				= $userOrderData['quantity'];
			$delivery_date			= date('Y-m-d',strtotime($userOrderData['delivery_date']));
			$order_created_date     = date('Y-m-d',strtotime($userOrderData['created_date']));
			$status					= $userOrderData['status'];
 			$qrcode 				= $barcode_no;			
 			
			// set style for barcode
			 $style = array(
								'border' => true,
								'vpadding' => 'auto',
								'hpadding' => 'auto',
								'fgcolor' => array(0,0,0), 
								'bgcolor' => false, //array(255,255,255)
								'module_width' => 1, // width of a single module in points
								'module_height' => 1 // height of a single module in points
						  ); 
 			$html='';
			$html = '<!DOCTYPE html>
						<html>
						<head>
						 </head>
						<body>
						<div style="width:650px; margin:0 auto;">
						<table width="650" cellpadding="10" cellspacing="0" border="0" style="">
							<tr  bgcolor="#FFCC00">
								<td colspan="2">
								<span style="font-family: Arial, Helvetica, sans-serif;color: #000;text-transform: uppercase; background:#FFCC00; width:97%; ">Product Order Description</span>
								</td>
							</tr>
 							<tr>
								<td width="80%" valign="top">
									<table cellpadding="10" cellspacing="0" border="0">
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Bar Code No. </strong>: '.$barcode_no.'</td>
										</tr>
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Order By </strong>: '.$username.'</td>
										</tr>
										
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Product Name </strong>: '.ucfirst($product_name).'</td>
										</tr>
							
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Product SKU</strong>: '.$product_sku.'</td>
							</tr>
							 
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Quantity</strong>: <span style="width:250px; float:right;">  '.$quantity.'</span></td>
							</tr>
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Order Date</strong>: <span style="width:250px; float:right;">  '.$order_created_date.'</span></td>
							</tr>
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Delivery Date</strong>: <span style="width:250px; float:right;">  '.$delivery_date.'</span></td>
							</tr>
							
									</table>
								</td>
								<td width="20%">
								
									<table cellpadding="0" cellspacing="0" border="0">
											 
										   <tr>
											<td align="right"> </td> 
										   </tr>
									</table>
 								</td>
							</tr>
 							<tr>
								<td align="left" style="font-family: Arial, Helvetica, sans-serif;color: #000;">Authorised Signatory</td>
								<td align="right" style="font-family: Arial, Helvetica, sans-serif;color: #000;">&nbsp;</td>
							</tr>
 							<tr>
							<td colspan="2"><div style="border-bottom:1px solid #feb400; width:100%; height:1px;">&nbsp;</div></td>
 							</tr>	
							 
  						</table>
						</div>
 						</body>
						</html>';
 			$pdf->writeHTML($html, false); 
			$post = $this->input->post();
			##----------------------------------------------------------------------------------##
			if($this->input->post('qty')>0){
				for($i=1;$i<=$this->input->post('qty');$i++){
				 	$x = $pdf->GetX();
					$y = $pdf->GetY();
					// The width is set to the the same as the cell containing the name.  
					// The Y position is also adjusted slightly.
					//$pdf->Text(20, 25, $qrcode.'-'.$i);
					$pdf->write2DBarcode($qrcode.'-'.$i, 'QRCODE,L', 150, $y, $barcodesize,barcodesize, $style, 'N');
					
					//$pdf->write2DBarcode($qrcode.'_'.$i, 'C128B,L',  $Y, 105, 18, 0.4, $style, 'M');
					//Reset X,Y so wrapping cell wraps around the barcode's cell.
					$pdf->SetXY($x,$y);
					$pdf->Cell(105,32, $qrcode.'-'.$i, 0, 0, 'C', FALSE, '', 0, FALSE, 'C', 'B');
					$pdf->Ln();
			$this->order_master_model->insert_printed_barcode_qrcode($post,$qrcode.'-'.$i,'Qrcode',$product_id,$active_status,$plant_id,$user_id);
				}
				
				$this->insert_print_order_in_table($post,'Qrcode');
 			}
 			##----------------------------------------------------------------------------------##
 			// ---------------------------------------------------------
			//Close and output PDF document
  			//$pdf->write2DBarcode($qrcode, 'QRCODE,L', 161, 60, 30,30, $style, 'N');
 			ob_end_clean();
			$output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        	$pdf->Output("$output", 'I'); // save to file because we can
 			//============================================================+
 	 }
	 
	 #Barcode
	 function generate_order_barcode(){ 
			ob_clean();
			require_once('tcpdf/examples/tcpdf_include.php');
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 			// set document information
			$pdf->SetCreator(PDF_CREATOR);
 			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			
			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			// ---------------------------------------------------------
 			// set a barcode on the page footer
			$pdf->setBarcode(date('Y-m-d H:i:s'));
			
			// set font
			$pdf->SetFont('helvetica', '', 11);
			
			// add a page
			$pdf->AddPage();
			
			// print a message
			$userid 				= base64_decode($this->input->post('order_id')); 
			$barcodesize 			= $this->input->post('barcodesize'); 
			
			
  			$userOrderData 			= view_order_data($userid);
			//echo '<pre>';print_r($userOrderData);exit;
			$product_id 			= $userOrderData['product_id'];
			$plant_id 				= $userOrderData['plant_id'];
			$active_status 			= $userOrderData['active_status'];
			$barcode_no 			= $userOrderData['order_tracking_number'];
   			$username				= getUserFullNameById($userOrderData['user_id']);
			$user_id				= $userOrderData['user_id'];
 			$product_name			= $userOrderData['product_name'];
			$product_sku			= $userOrderData['product_sku'];
			$quantity				= $userOrderData['quantity'];
			$delivery_date			= date('Y-m-d',strtotime($userOrderData['delivery_date']));
			$order_created_date     = date('Y-m-d',strtotime($userOrderData['created_date']));
			$status					= $userOrderData['status'];
 			$qrcode 				= $barcode_no;			
 			
			// set style for barcode
			 $style = array(
								'border' => true,
								'vpadding' => 'auto',
								'hpadding' => 'auto',
								'fgcolor' => array(0,0,0), 
								'bgcolor' => false, //array(255,255,255)
								'module_width' => 1, // width of a single module in points
								'module_height' => 1 // height of a single module in points
						  ); 
 			$html='';
			$html = '<!DOCTYPE html>
						<html>
						<head>
						 </head>
						<body>
						<div style="width:650px; margin:0 auto;">
						<table width="650" cellpadding="10" cellspacing="0" border="0" style="">
							<tr  bgcolor="#FFCC00">
								<td colspan="2">
								<span style="font-family: Arial, Helvetica, sans-serif;color: #000;text-transform: uppercase; background:#FFCC00; width:97%; ">Product Order Description</span>
								</td>
							</tr>
 							<tr>
								<td width="80%" valign="top">
									<table cellpadding="10" cellspacing="0" border="0">
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Bar Code No. </strong>: '.$barcode_no.'</td>
										</tr>
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Order By </strong>: '.$username.'</td>
										</tr>
										
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Product Name </strong>: '.ucfirst($product_name).'</td>
										</tr>
							
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Product SKU</strong>: '.$product_sku.'</td>
							</tr>
							 
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Quantity</strong>: <span style="width:250px; float:right;">  '.$quantity.'</span></td>
							</tr>
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Order Date</strong>: <span style="width:250px; float:right;">  '.$order_created_date.'</span></td>
							</tr>
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Delivery Date</strong>: <span style="width:250px; float:right;">  '.$delivery_date.'</span></td>
							</tr>
							
									</table>
								</td>
								<td width="20%">
								
									<table cellpadding="0" cellspacing="0" border="0">
											 
										   <tr>
											<td align="right"> </td> 
										   </tr>
									</table>
 								</td>
							</tr>
 							<tr>
								<td align="left" style="font-family: Arial, Helvetica, sans-serif;color: #000;">Authorised Signatory</td>
								<td align="right" style="font-family: Arial, Helvetica, sans-serif;color: #000;">&nbsp;</td>
							</tr>
 							<tr>
							<td colspan="2"><div style="border-bottom:1px solid #feb400; width:100%; height:1px;">&nbsp;</div></td>
 							</tr>	
							 
  						</table>
						</div>
 						</body>
						</html>';
			// -----------------------------------------------------------------------------
 			$pdf->SetFont('helvetica', '', 10);
			
 			// define barcode style
			$style = array(
				'position' => '',
				'align' => 'L',
				'stretch' => false,
				'fitwidth' => false,
				'cellfitalign' => '',
				'border' => true,
				'hpadding' => 'auto',
				'vpadding' => 'auto',
				'fgcolor' => array(0,0,0),
				'bgcolor' => false, //array(255,255,255),
				'text' => true,
				'font' => 'helvetica',
				'fontsize' => 8,
				'stretchtext' => 2
			);
			//echo '<pre>';print_r($this->input->post());exit;
			// PRINT VARIOUS 1D BARCODES
			$pdf->writeHTML($html, false, 0, false, 0);
			 $this->input->post('rest_qty');
			 $post = $this->input->post();
			if($this->input->post('rest_qty')>0){
				for($i=1;$i<=$this->input->post('qty');$i++){
				 	$x = $pdf->GetX();
					$y = $pdf->GetY();
					//$style['position'] = 'R';
					$pdf->write1DBarcode($qrcode.'-'.$i, 'C128B', '', $y-8.5, 70, $barcodesize, 0.4, $style, 'L');
					//$pdf->write1DBarcode($qrcode.'-'.$i, 'C128B', '', $y-8.5, 105, 20, 0.4, $style, 'M');
            		//Reset X,Y so wrapping cell wraps around the barcode's cell.
           			 $pdf->SetXY($x,$y);
					 $pdf->Cell(50, 42, '', 0, 1);
					// $pdf->Cell(105, 21, "", 1, 2, 'C', FALSE, '', 0, FALSE, 'C', 'B');
		$this->order_master_model->insert_printed_barcode_qrcode($post, $qrcode.'-'.$i,'barcode',$product_id,$active_status,$plant_id,$user_id);
					
 				}
				
				$this->insert_print_order_in_table($post,'barcode');
 			}
			 // $pdf->Ln();
 			// ---------------------------------------------------------
			//Close and output PDF document
			//ob_end_clean();
			$output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        	$pdf->Output("$output", 'I'); // save to file because we can
 			//============================================================+
 	 }
	 
	 
	 
	 ###------------------------ Testing -------------------------------###
	  function generate_order_barcode2(){
	ob_clean();	
	require_once('tcpdf/examples/tcpdf_include.php');	

	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
 
	
	// set default header data
	$pdf->SetHeaderData('');
	
	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	
	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}
 	// ---------------------------------------------------------
 	// NOTE: 2D barcode algorithms must be implemented on 2dbarcode.php class file.
 	// set font
	$pdf->SetFont('helvetica', '', 11);
	
	// add a page
	$pdf->AddPage();
	
	// print a message
	$txt = "You can also export 2D barcodes in other formats (PNG, SVG, HTML). Check the examples inside the barcode directory.\n";
	$html = '<!DOCTYPE html>
						<html>
						<head>
						 </head>
						<body>
						<div style="width:650px; margin:0 auto;">
						<table width="650" cellpadding="10" cellspacing="0" border="0" style="">
							<tr  bgcolor="#FFCC00">
								<td colspan="2">
								<span style="font-family: Arial, Helvetica, sans-serif;color: #000;text-transform: uppercase; background:#FFCC00; width:97%; ">Product Order Description</span>
								</td>
							</tr>
 							<tr>
								<td width="80%" valign="top">
									<table cellpadding="10" cellspacing="0" border="0">
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Bar Code No. </strong>: '.$barcode_no.'</td>
										</tr>
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Order By </strong>: '.$username.'</td>
										</tr>
										
										<tr>
											<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Product Name </strong>: '.ucfirst($product_name).'</td>
										</tr>
							
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Product SKU</strong>: '.$product_sku.'</td>
							</tr>
							 
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Quantity</strong>: <span style="width:250px; float:right;">  '.$quantity.'</span></td>
							</tr>
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Order Date</strong>: <span style="width:250px; float:right;">  '.$order_created_date.'</span></td>
							</tr>
							<tr>
								<td colspan="2" style="font-family: Arial, Helvetica, sans-serif;color: #000;"><strong style="width: 150px;float: left;">Delivery Date</strong>: <span style="width:250px; float:right;">  '.$delivery_date.'</span></td>
							</tr>
							
									</table>
								</td>
								<td width="20%">
								
									<table cellpadding="0" cellspacing="0" border="0">
											 
										   <tr>
											<td align="right"> </td> 
										   </tr>
									</table>
 								</td>
							</tr>
 							<tr>
								<td align="left" style="font-family: Arial, Helvetica, sans-serif;color: #000;">Authorised Signatory</td>
								<td align="right" style="font-family: Arial, Helvetica, sans-serif;color: #000;">&nbsp;</td>
							</tr>
 							<tr>
							<td colspan="2"><div style="border-bottom:1px solid #feb400; width:100%; height:1px;">&nbsp;</div></td>
 							</tr>	
							 
  						</table>
						</div>
 						</body>
						</html>';
			// -----------------------------------------------------------------------------
 			$pdf->SetFont('helvetica', '', 10);
			
 			// define barcode style
			$style = array(
				'position' => '',
				'align' => 'L',
				'stretch' => false,
				'fitwidth' => false,
				'cellfitalign' => '',
				'border' => true,
				'hpadding' => 'auto',
				'vpadding' => 'auto',
				'fgcolor' => array(0,0,0),
				'bgcolor' => false, //array(255,255,255),
				'text' => true,
				'font' => 'helvetica',
				'fontsize' => 8,
				'stretchtext' => 2
			);
			//echo '<pre>';print_r($this->input->post());exit;
			// PRINT VARIOUS 1D BARCODES
			 $pdf->writeHTML($html, false, 0, false, 0);
	//$pdf->MultiCell(70, 50, $html, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);
	
	
	$pdf->SetFont('helvetica', '', 10);
	
	 
	// set style for barcode
	$style = array(
				'position' => '',
				'align' => 'L',
				'stretch' => false,
				'fitwidth' => false,
				'cellfitalign' => '',
				'border' => true,
				'hpadding' => 'auto',
				'vpadding' => 'auto',
				'fgcolor' => array(0,0,0),
				'bgcolor' => false, //array(255,255,255),
				'text' => true,
				'font' => 'helvetica',
				'fontsize' => 8,
				'stretchtext' => 2
			);
	
	// QRCODE,L : QR-CODE Low error correction
	 
		for($i=1;$i<=25;$i++){
				 	$x = $pdf->GetX();
					$y = $pdf->GetY();
					//$style['position'] = 'R';
					//$pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,L', $y-8.5, 105, 50, 50, $style, 'N');
					$pdf->write1DBarcode('test'.'-'.$i, 'C128B', '', $y-8.5, 50, $barcodesize, 0.4, $style, 'M');
					 
					//$pdf->write1DBarcode($qrcode.'-'.$i, 'C128B', '', $y-8.5, 105, 20, 0.4, $style, 'M');
            		//Reset X,Y so wrapping cell wraps around the barcode's cell.
           			 $pdf->SetXY($x,$y);
					 $pdf->Cell(100, 22, '', 0, 1);
					// $pdf->Cell(105, 21, "", 1, 2, 'C', FALSE, '', 0, FALSE, 'C', 'B');
					
 				}
	// -------------------------------------------------------------------
	// DATAMATRIX (ISO/IEC 16022:2006)
 
	 
	
	// ---------------------------------------------------------
	
	//Close and output PDF document
	$pdf->Output('example_050.pdf', 'I');
	
	//============================================================+
	// END OF FILE
	//============================================================+
		}
	 ###------------------------ Testing -------------------------------###
	 
	 
	 
	 function insert_print_order_in_table($post,$code_type){## code type is barcode, QR code
		 $order_id 				= base64_decode($post['order_id']);
		 $resultSet=0;
		 if(!empty($order_id)){
		 	 $isExists = $this->order_master_model->get_quantity_print_order_history($order_id);
			// print_r( $isExists );exit;
			 if(empty($isExists['total_quantity'])){
			 	$resultSet= $this->order_master_model->insert_print_history($post,$code_type);	
			 }else{
				$resultSet= $this->order_master_model->updatet_print_history($post,$code_type,$isExists['last_printed_rows']);	
			 }
			 
		 }
		 return $resultSet;
	 }
	 
	 function print_box(){
		 $id = $this->uri->segment(3);
		 if($id!=''){
 			 $data['print_data']=$this->order_master_model->get_quantity_print_order_history($id);
			 $data['print_data']['OrderQty']=$this->order_master_model->get_total_quantity_ordered($id);
			$this->load->view('print_order',$data);
		 }
	 }
   }?>

