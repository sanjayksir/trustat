<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'ApiController.php';

class Customer extends ApiController {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('CustomerModel');
        $this->load->model('Productmodel');
		
		 $this->load->model('ScannedproductsModel');
	     $this->load->model('ConsumerModel');
			
			
		$this->load->library(array('Dmailer', 'form_validation', 'email'));
    }
    
    /**
     * addInventory to create inventory
     * 
     * @param String $bar_code product bar code
     * @param String $plant_id level of the the product
     * @return Object $response as object which contain the product details
     */
    
    public function addInventory(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ]
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
        if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
		
		$product_id = getProductIDbyProductCode($data['bar_code']);
		
        $inventory = [
            'plant_id' => $user['plant_id'],
            'customer_id' => $user['user_id'],
            'created_at' => (new DateTime('now'))->format('Y-m-d H:i:s')
        ];
        $status = true;
        foreach(explode(',',$data['bar_code']) as $ind => $code){
            $inventory['bar_code'] = $code;
            if($this->db->insert('physical_inventory', $inventory)){
				
			$transactionType = "physical_inventory_check";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Physical inventory check";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
				
                continue;
            }else{
                $this->response(['status'=>false,'message'=>'Failed to create inventory for barcode '.$code.' .']);
            }
        }
		
		
        $this->response(['status'=>true,'message'=>'Inventory has been created successfully.']);
    }
    
    /**
     * viewProduct method to list the product which is get activated and has been set the lebel
     * 
     * @param Int $limit How much record need to retrieve
     * @param Int $offset Offset of limit to retrieve the record
     * @return Obj Json object to return the list of products
     */
    
    public function viewInventory(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $result = $this->Productmodel->viewInventory($user['user_id'],$data['limit'],$data['offset']);
        //echo "<pre>";print_r($result);die;
        if(!empty($result)){
            $this->response(['status'=>true,'message'=>'List of product inventory','data'=>$result],200);
        }else{
            $this->response(['status'=>true,'message'=>'There is no record.'],200);
        }
        
    }
    /**
     * viewProduct method to list the product which is get activated and has been set the lebel
     * 
     * @param Int $limit How much record need to retrieve
     * @param Int $offset Offset of limit to retrieve the record
     * @return Obj Json object to return the list of products
     */
    
    public function viewProduct(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $result = $this->Productmodel->productsByUser($user['user_id'],$data['limit'],$data['offset']);
        //echo "<pre>";print_r($result);die;
        if(!empty($result)){
            $this->response(['status'=>true,'message'=>'List of products','data'=>$result],200);
        }else{
            $this->response(['status'=>true,'message'=>'There is no record.'],200);
        }        
    }
	
    
	public function viewProductLevel(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
            ['field' =>'pack_level','label'=>'Packet Level','rules' => 'required'],
            ['field' =>'activation_location_id','label'=>'Location ID','rules' => 'required']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProductsInactive($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     
		 //$userParentId = getUserParentIDById($userId);
		//echo print_r($result[0]['created_by']) . "<br>"; 
		//echo print_r($userParentId) . "<br>";
		//echo print_r($result);
		//	die;
			
			//echo print_r($result[0]['active_status']);
        
        /*
		foreach(explode(',',$data['bar_code']) as $ind => $code){
           $this->db->or_where('barcode_qr_code_no',$code);
        }
		*/
		
		$current_active_status = $result[0]['active_status'];
		
		//if($current_active_status==0){
		 $isAnyChildAdded = $this->Productmodel->isAnyChildAdded($data['bar_code']);
		
		//if($isAnyChildAdded==true){
			
			
		//$this->db->set('active_status',1);
        $this->db->set('pack_level', $data['pack_level']);
        //$this->db->set('activation_location_id',$data['activation_location_id']);
        $this->db->set('customer_id',$user['user_id']);
        //$this->db->set('modified_at', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->set('activation_date', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->where('barcode_qr_code_no', $data['bar_code']);
		
        if($this->db->update('printed_barcode_qrcode')){
			
			/*
			$tlogdata['trax_slug'] = "viewProductLevel"; 
			$tlogdata['trax_name'] = "View Product Details"; 
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['activation_location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
			$this->db->insert('list_transactions_table', $tlogdata);
			*/
		/*
			$data2['barcode_qr_code_no'] = $data['bar_code'];
			$data2['product_id'] = $result[0]['product_id'];
			$data2['packaging_level'] = $data['pack_level'];
			$data2['parent_barcode_qr_code'] = 0;
			$this->db->insert('packaging_codes_pc', $data2);
		*/	
			$product_id = $result[0]['product_id'];
			
			$pack_level_field_name = "pack_level" . $data['pack_level'];
			
			$results2 = $this->db->select($pack_level_field_name)->from('product_packaging_qty_levels')->where('product_id', $product_id)->get()->row();
			$result['number_of_children'] = $results2->$pack_level_field_name;
			
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
		
		
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'new_pack_level'=>$data['pack_level'],'data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		/*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item already under process to add its children.'],200); 
        }
		
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item is already activated.'],200); 
        }
		*/
    }
	
		public function ListfollowingCodes(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ]
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProductsInactive($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     
		 //$userParentId = getUserParentIDById($userId);
		//echo print_r($result[0]['created_by']) . "<br>"; 
		//echo print_r($userParentId) . "<br>";
		//echo print_r($result);
		//	die;
			
			//echo print_r($result[0]['active_status']);
        
        /*
		foreach(explode(',',$data['bar_code']) as $ind => $code){
           $this->db->or_where('barcode_qr_code_no',$code);
        }
		*/
		
		$current_active_status = $result[0]['active_status'];
		
		if($current_active_status==1){
		// $isAnyChildAdded = $this->Productmodel->isAnyChildAdded($data['bar_code']);
		
		
        if(!empty($data['bar_code'])){
			
			$product_id = $result[0]['product_id'];
			
			$transactionType = "scan_for_list_following_codes";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Scan for List following Codes";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['scan_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
		$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
		
			$data['list_following_codes'] = $this->Productmodel->ListfollowingCodes($data['bar_code'], $userId, $product_id);
			
			$this->response(['status'=>true,'message'=>'List of the following Codes is ','list_following_codes'=>$data['list_following_codes']]);
			
        }else{
            $this->response(['status'=>false,'message'=>'System failed to display the data.'],200); 
        }
		/*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item already under process to add its children.'],200); 
        }
		*/
		}else{
            $this->response(['status'=>false,'message'=>'System failed to assign batch id because this code is not activated.'],200); 
        }
		
    }
	
    /**
     * addProductLevel to add level and change status of product by the help of qr bar code
     * 
     * @param String $bar_code product bar code
     * @param String $product_level level of the the product
     * @return Object $response as object whcih contain the product details
     */
    
    public function addProductLevel(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
            ['field' =>'pack_level','label'=>'Packet Level','rules' => 'required'],
            ['field' =>'activation_location_id','label'=>'Location ID','rules' => 'required'],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProductsInactive($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     
		 //$userParentId = getUserParentIDById($userId);
		//echo print_r($result[0]['created_by']) . "<br>"; 
		//echo print_r($userParentId) . "<br>";
		//echo print_r($result);
		//die;
			
			//echo print_r($result[0]['active_status']);
        
        /*
		foreach(explode(',',$data['bar_code']) as $ind => $code){
           $this->db->or_where('barcode_qr_code_no',$code);
        }
		*/
		
		$current_active_status = $result[0]['active_status'];
		
		if($current_active_status==0){
		 $isAnyChildAdded = $this->Productmodel->isAnyChildAdded($data['bar_code']);
		
		//if($isAnyChildAdded==true){
			
			
		$this->db->set('active_status',1);
        $this->db->set('pack_level', $data['pack_level']);
        $this->db->set('activation_location_id',$data['activation_location_id']);
        $this->db->set('customer_id',$user['user_id']);
        //$this->db->set('modified_at', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->set('activation_date', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->where('barcode_qr_code_no', $data['bar_code']);		
		
		
        if($this->db->update('printed_barcode_qrcode')){
			
		$designation_id = getDesignationIDByUserId($userId);
		$functionality_name_slug = "bar_code_activation_for_all_levels";
		$customer_id = $result[0]['created_by'];
		$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
		if($loyalty_points >=1){
			$is_loyalty_available = "Yes";
		}else{
			$is_loyalty_available = "No";
		}
			
			$tlogdata['trax_slug'] = "addProductLevel"; 
			$tlogdata['trax_name'] = "Add Product Level Activate";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['activation_location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
		/*
			$data2['barcode_qr_code_no'] = $data['bar_code'];
			$data2['product_id'] = $result[0]['product_id'];
			$data2['packaging_level'] = $data['pack_level'];
			$data2['parent_barcode_qr_code'] = 0;
			$this->db->insert('packaging_codes_pc', $data2);
		*/	
			$product_id = $result[0]['product_id'];
			
			$pack_level_field_name = "pack_level" . $data['pack_level'];
			
			$results2 = $this->db->select($pack_level_field_name)->from('product_packaging_qty_levels')->where('product_id', $product_id)->get()->row();
			$result['number_of_children'] = $results2->$pack_level_field_name;
			
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
			$transactionType = "bar_code_activation_for_all_levels";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Barcode Activation";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
			$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['activation_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
			
			$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
						
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'new_pack_level'=>$data['pack_level'],'data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		/*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item already under process to add its children.'],200); 
        } */
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item is already activated.'],200); 
        }
    }
	
	public function addShipperBoxPackLevel(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
            ['field' =>'pack_level','label'=>'Packet Level','rules' => 'required'],
            ['field' =>'activation_location_id','label'=>'Location ID','rules' => 'required'],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim'],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']

        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProductsInactive($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     
		 //$userParentId = getUserParentIDById($userId);
		//echo print_r($result[0]['min_shipper_pack_level']) . "<br>"; 
		//echo print_r($userParentId) . "<br>";
		//echo print_r($result);
		
			
		//	echo print_r($result[0]['active_status']);
        //die;
        /*
		foreach(explode(',',$data['bar_code']) as $ind => $code){
           $this->db->or_where('barcode_qr_code_no',$code);
        }
		*/
		
		$current_active_status = $result[0]['active_status'];
		if($result[0]['min_shipper_pack_level']==$result[0]['max_shipper_pack_level']){
		if($current_active_status==0){
		 $isAnyChildAdded = $this->Productmodel->isAnyChildAdded($data['bar_code']);
		
		//if($isAnyChildAdded==true){
			
			
		$this->db->set('active_status',1);
        $this->db->set('pack_level', $data['pack_level']);
        $this->db->set('activation_location_id',$data['activation_location_id']);
        $this->db->set('customer_id',$user['user_id']);
        //$this->db->set('modified_at', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->set('activation_date', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->where('barcode_qr_code_no', $data['bar_code']);
		
        if($this->db->update('printed_barcode_qrcode')){
			
			$designation_id = getDesignationIDByUserId($userId);
					$functionality_name_slug = "shipper_box_barcode_activation";
					$customer_id = $result[0]['created_by'];
					$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
					if($loyalty_points >=1){
						$is_loyalty_available = "Yes";
					}else{
						$is_loyalty_available = "No";
					}
			
			$tlogdata['trax_slug'] = "addProductLevel"; 
			$tlogdata['trax_name'] = "Add Product Level Activate";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['activation_location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;	
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
		/*
			$data2['barcode_qr_code_no'] = $data['bar_code'];
			$data2['product_id'] = $result[0]['product_id'];
			$data2['packaging_level'] = $data['pack_level'];
			$data2['parent_barcode_qr_code'] = 0;
			$this->db->insert('packaging_codes_pc', $data2);
		*/	
			$product_id = $result[0]['product_id'];
			
			$pack_level_field_name = "pack_level" . $data['pack_level'];
			
			$results2 = $this->db->select($pack_level_field_name)->from('product_packaging_qty_levels')->where('product_id', $product_id)->get()->row();
			$result['number_of_children'] = $results2->$pack_level_field_name;
			
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
			
			
			$transactionType = "shipper_box_barcode_activation";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Add Shipper Box Pack Level";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['add_shipper_box_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
		$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'Level has been added to the Shipper Box.','number_of_children_added'=>$data['number_of_children_added'],'new_pack_level'=>$data['pack_level'],'data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		/*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item already under process to add its children.'],200); 
        } */
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item is already activated.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because Min Shipper Pack Level and Max Shipper Pack Level are not same defined in the Product Definition.'],200); 
        }
    }
	
	
	
	public function LinkBarcodewithProductionBatchId(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
            ['field' =>'batch_id','label'=>'Packet Level','rules' => 'required'],
            ['field' =>'location_id','label'=>'Location ID','rules' => 'required'],
			['field' =>'batch_mfg_date','label'=>'Batch ID Date','rules' => 'required'],
			['field' =>'quantity','label'=>'Number Of Code Items','rules' => 'required'],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     
		 //$userParentId = getUserParentIDById($userId);
		//echo print_r($result[0]['created_by']) . "<br>"; 
		//echo print_r($userParentId) . "<br>";
		//echo print_r($result);
		//die;
			
			//echo print_r($result[0]['active_status']);
        
        /*
		foreach(explode(',',$data['bar_code']) as $ind => $code){
           $this->db->or_where('barcode_qr_code_no',$code);
        }
		*/
		
		$current_active_status = $result[0]['active_status'];
		
		if($current_active_status==1){
		 $isAnyChildAdded = $this->Productmodel->isAnyChildAdded($data['bar_code']);
		
		//if($isAnyChildAdded==true){
			
			
		//$this->db->set('active_status',1);
        $this->db->set('batch_id', $data['batch_id']);
        $this->db->set('batch_mfg_date', $data['batch_mfg_date']);
       // $this->db->set('customer_id',$user['user_id']);
        //$this->db->set('modified_at', (new DateTime('now'))->format('Y-m-d H:i:s'));
		//$this->db->set('activation_date', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->where('barcode_qr_code_no', $data['bar_code']);
		
        if($this->db->update('printed_barcode_qrcode')){
			
					
			$designation_id = getDesignationIDByUserId($userId);
					$functionality_name_slug = "link_barcode_with_production_batch_id";
					$customer_id = $result[0]['created_by'];
					$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
					if($loyalty_points >=1){
						$is_loyalty_available = "Yes";
					}else{
						$is_loyalty_available = "No";
					}
		
			
			$tlogdata['trax_slug'] = "addBatchId"; 
			$tlogdata['trax_name'] = "Add Batch Id";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;	
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			$ABilogdata['batch_id'] = $data['batch_id'];  
			$ABilogdata['product_id'] = $result[0]['product_id']; 
			$ABilogdata['product_name'] = get_products_name_by_id($result[0]['product_id']);
			$ABilogdata['order_id'] = $userId; 
			$ABilogdata['order_number'] = $userId; 
			$ABilogdata['order_date'] = date('Y-m-d H:i:s'); 
			$ABilogdata['print_id'] = $userId; 
			$ABilogdata['print_date'] = date('Y-m-d H:i:s');  
			$ABilogdata['location_id'] = $data['location_id']; 
			$ABilogdata['product_sku'] = $result[0]['product_sku'];
			$ABilogdata['quantity'] = $data['quantity']; 
			$ABilogdata['first_code_number'] = $data['bar_code'];
			$ABilogdata['batchid_assigned_by'] = $userId;
			$ABilogdata['batchid_assign_date'] = date('Y-m-d H:i:s'); 
			$ABilogdata['issue_location'] = $data['location_id']; 
			$ABilogdata['last_code_number'] = $data['bar_code'];
			$ABilogdata['batch_mfg_date'] = $data['batch_mfg_date'];  
			$ABilogdata['status'] = 1;
				
			
			$this->db->insert('link_code_with_batchid_trans', $ABilogdata);
			
			
		/*
			$data2['barcode_qr_code_no'] = $data['bar_code'];
			$data2['product_id'] = $result[0]['product_id'];
			$data2['packaging_level'] = $data['pack_level'];
			$data2['parent_barcode_qr_code'] = 0;
			$this->db->insert('packaging_codes_pc', $data2);
		*/	
			$product_id = $result[0]['product_id'];
			/*
			$pack_level_field_name = "pack_level" . $data['pack_level'];
			
			$results2 = $this->db->select($pack_level_field_name)->from('product_packaging_qty_levels')->where('product_id', $product_id)->get()->row();
			$result['number_of_children'] = $results2->$pack_level_field_name;
			
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
			
		
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'The Codes Linked with Production Batch Id.','number_of_children_added'=>$data['number_of_children_added'],'new_pack_level'=>$data['pack_level'],'data'=>$result]);
			*/
			
			$transactionType = "link_barcode_with_production_batch_id";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Link Barcode with Production Batch Id";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['link_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);	
			
			 $this->response(['status'=>true,'message'=>'The Codes Linked with Production Batch Id.','data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		/*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item already under process to add its children.'],200); 
        } */
		}else{
            $this->response(['status'=>false,'message'=>'System failed to Linked the Codes with Production Batch Id because this item is not activated.'],200); 
        }
    }
	
	
    // Packaging Start  
	public function addProductLevelParentActivate(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'plant_id','label'=>'Plant id is required','rules' => 'required' ],
			['field' =>'location_id','label'=>'Location id is required','rules' => 'required' ],
			['field' =>'parent_bar_code','label'=>'Parent Barcode','rules' => 'required' ],
			['field' =>'parent_pack_level','label'=>'Parent Pack Barcode','rules' => 'required' ],
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
		$data['customer_user_id'] = $userId;
		$data['create_date'] = date('Y-m-d H:i:s');
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        } 
		
		//echo print_r($result);
			//	die;
		   //echo print_r($result[0]['product_id']); 
		   
			$results2 = $this->db->select('pack_level')->from('printed_barcode_qrcode')->where('barcode_qr_code_no', $data['bar_code'])->get()->row();
			//$result['number_of_children'] = $results2->$pack_level_field_name;
			//$data['parent_barcode_qr_code'] = $data['parent_bar_code'];
			///$data['barcode_qr_code_no'] = $data['bar_code'];
			$data['packaging_level'] = $results2->pack_level;
			$data['product_id'] = $result[0]['product_id'];
			$data['unpackaging_status'] = "Packaged";
			//$data['packaging_level'] = $data['pack_level'];
			$product_id = $data['product_id'];
			$packaging_level = $data['packaging_level'] + 1;
			$parent_pack_level = $data['parent_pack_level'];
			$code_unity_type = $result[0]['code_unity_type'];
			$spackaging_qty_levels = "pack_level" . $data['parent_pack_level'];
			
			
		//$number_of_children_added_in_basecode = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
		$number_of_children_added_in_basecode = $this->db->where(['parent_bar_code'=>$data['parent_bar_code']])->from("packaging_codes_pcr")->count_all_results();
		
		$results4 = $this->db->select($spackaging_qty_levels)->from('product_packaging_qty_levels')->where('product_id', $data['product_id'])->get()->row();
		$number_of_children_required_in_basecode = $results4->$spackaging_qty_levels;
		
		/*
		echo print_r($data['packaging_level']) . "<br>"; 
		echo print_r($number_of_children_required_in_basecode) . "<br>"; 
		echo print_r($number_of_children_added_in_basecode) . "<br>"; 
		echo print_r($code_unity_type) . "<br>"; 
		exit;			
		*/
			
		$parent_product_packaging_qty_levels = "pack_level" . $data['parent_pack_level'];
				 
	$number_of_children_added_in_parentcode = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
		$results5 = $this->db->select($parent_product_packaging_qty_levels)->from('product_packaging_qty_levels')->where('product_id', $data['product_id'])->get()->row();
		$number_of_children_required_in_parentcode = $results5->$parent_product_packaging_qty_levels;
			
			//echo print_r($result) . "<br>"; 
			/*
		echo print_r($data['parent_pack_level']) . "<br>"; 
		echo print_r($number_of_children_required_in_parentcode) . "<br>"; 
		echo print_r($number_of_children_added_in_parentcode) . "<br>"; 
		echo print_r($code_unity_type) . "<br>"; 
		exit;
			*/
		//echo $packaging_level . $parent_pack_level; 
		//echo print_r($parent_pack_level);  exit;
       // foreach(explode(',',$data['bar_code']) as $ind => $code){
            //$this->db->or_where('barcode_qr_code_no',$code);
        //$data['bar_code'] = $code;
		// if(2 < 2){
			
			$transactionType = "packaging";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Packaging";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
			
		if($code_unity_type=='Single'){ 
		if($data['packaging_level'] > 0){ 
		 if($number_of_children_required_in_basecode >= $number_of_children_added_in_basecode){ // incomplete or empty box can not be packed
		 if($number_of_children_required_in_parentcode > $number_of_children_added_in_parentcode){ // Only number of childrent can be added as defined in parent code
		if($packaging_level == $parent_pack_level){ // Only one level lower level code can be added in the parent box
			$isPackLevelSeted = $this->Productmodel->isPackLevelSeted($data['bar_code'], $data['parent_bar_code']);
		if($isPackLevelSeted==true){ // if the code is already added in any other box
        if($this->db->insert('packaging_codes_pcr', $data)){
			
			$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "packaging";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
					
			$tlogdata['trax_slug'] = "addProductLevelParentActivate"; 
			$tlogdata['trax_name'] = "Product Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s');
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['activation_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
			
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);			
			
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
			
		 if($data['number_of_children_added'] < $number_of_children_required_in_basecode){
			$data['packaging_status'] = "Packaging Incomplete"; 
			}else{
			$data['packaging_status'] = "Packaging Completed"; 
			}
			
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'packaging_status'=>$data['packaging_status'],'data'=>$result]);
			
			
			
			
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because this code is already added in packaging.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because packaging level miss match.'],200); 
        }
		}else{
            $this->response(['status'=>false, $number_of_children_required_in_parentcode, $number_of_children_added_in_parentcode, 'message'=>'System failed to add packaging because packaging box is filled.'],200); 
        }
		}else{
            $this->response(['status'=>false, 'number_of_children_required_in_basecode'=>$number_of_children_required_in_basecode, 'number_of_children_added_in_basecode'=>$number_of_children_added_in_basecode, 'message'=>'System failed to add packaging because incomplete or empty box can not be packed.'],200); 
        }
		}else{ // this condition is for level 0 code adding
            if($number_of_children_required_in_parentcode > $number_of_children_added_in_parentcode){ // Only number of childrent can be added as defined in parent code
		if($packaging_level == $parent_pack_level){ // Only one level lower level code can be added in the parent box
			$isPackLevelSeted = $this->Productmodel->isPackLevelSeted($data['bar_code'], $data['parent_bar_code']);
		if($isPackLevelSeted==true){ // if the code is already added in any other box
        if($this->db->insert('packaging_codes_pcr', $data)){
			
			$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "packaging";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
			$tlogdata['trax_slug'] = "addProductLevelParentActivate"; 
			$tlogdata['trax_name'] = "Product Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['activation_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
		
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
			
		 if($data['number_of_children_added'] < $number_of_children_required_in_basecode){
			$data['packaging_status'] = "Packaging Incomplete"; 
			//$data['spackaging_qty_levels'] = $spackaging_qty_levels;
			//$data['number_of_children_added'] = $data['number_of_children_added']; 
			//$data['number_of_children_added'] = $number_of_children_required_in_basecode; 
			}else{
			$data['packaging_status'] = "Packaging Completed"; 	
			//$data['number_of_children_added'] = $data['number_of_children_added']; 
			//$data['number_of_children_allowed'] = $number_of_children_required_in_basecode;  
			//$data['spackaging_qty_levels'] = $spackaging_qty_levels;
			}
			
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'packaging_status'=>$data['packaging_status'],'data'=>$data]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because this code is already added in packaging.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because packaging level miss match.'],200); 
        }
		}else{
            $this->response(['status'=>false, 'message'=>'System failed to add packaging because packaging box is filled.'],200); 
        }
        }//
		}else{ // loop for twin
            
		if($data['packaging_level'] > 1){ 
		 if($number_of_children_required_in_basecode <= $number_of_children_added_in_basecode){ // incomplete or empty box can not be packed
		 if($number_of_children_required_in_parentcode > $number_of_children_added_in_parentcode){ // Only number of childrent can be added as defined in parent code
		if($packaging_level == $parent_pack_level){ // Only one level lower level code can be added in the parent box
			$isPackLevelSeted = $this->Productmodel->isPackLevelSeted($data['bar_code'], $data['parent_bar_code']);
		if($isPackLevelSeted==true){ // if the code is already added in any other box
        if($this->db->insert('packaging_codes_pcr', $data)){
			
			$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "packaging";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
					
			$tlogdata['trax_slug'] = "addProductLevelParentActivate"; 
			$tlogdata['trax_name'] = "Product Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['activation_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
			
			$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
			
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
			
		 if($data['number_of_children_added'] < $number_of_children_required_in_basecode){
			$data['packaging_status'] = "Packaging Incomplete"; 
			}else{
			$data['packaging_status'] = "Packaging Completed"; 
			}
		
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'packaging_status'=>$data['packaging_status'],'data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because this code is already added in packaging.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because packaging level miss match.'],200); 
        }
		}else{
            $this->response(['status'=>false, 'message'=>'System failed to add packaging because packaging box is filled.'],200); 
        }
		}else{
            $this->response(['status'=>false, 'message'=>'System failed to add packaging because incomplete or empty box can not be packed.'],200); 
        }
		}else{ // this condition is for level 0 code adding
            if($number_of_children_required_in_parentcode > $number_of_children_added_in_parentcode){ // Only number of childrent can be added as defined in parent code
		if($packaging_level == $parent_pack_level){ // Only one level lower level code can be added in the parent box
			$isPackLevelSeted = $this->Productmodel->isPackLevelSeted($data['bar_code'], $data['parent_bar_code']);
		if($isPackLevelSeted==true){ // if the code is already added in any other box
        if($this->db->insert('packaging_codes_pcr', $data)){
			
			$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "packaging";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
					
			$tlogdata['trax_slug'] = "addProductLevelParentActivate"; 
			$tlogdata['trax_name'] = "Product Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			$transactionType = "add_product_level_parent_activate";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "add Product Level Parent Activate";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
				
			$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['activation_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
			
			$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
			
		 if($data['number_of_children_added'] < $number_of_children_required_in_basecode){
			$data['packaging_status'] = "Packaging Incomplete"; 
			}else{
			$data['packaging_status'] = "Packaging Completed"; 
			}
		
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'packaging_status'=>$data['packaging_status'],'data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because this code is already added in packaging.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because packaging level miss match.'],200); 
        }
		}else{
            $this->response(['status'=>false, 'message'=>'System failed to add packaging because packaging box is filled.'],200); 
        }
        }			
			
        }
		
		
    }
	
	// Packaging end 
		public function ShipOutOrder(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'request_id','label'=>'Order Number is required','rules' => 'required' ],
			['field' =>'plant_id','label'=>'plant_id is required','rules' => 'required' ],
			['field' =>'shipper_box_barcode','label'=>'Shipper Box Barcode is required','rules' => 'required' ],
			['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
			['field' =>'invoice_number','label'=>'Invoice Number','rules' => 'required' ],
			['field' =>'transaction_type','label'=>'Transaction Type','rules' => 'required' ],
			['field' =>'location_type','label'=>'Location Type','rules' => 'required' ],
			['field' =>'location_id','label'=>'Location id','rules' => 'required' ],
			['field' =>'location_name','label'=>'Location Name','rules' => 'required' ],
			['field' =>'created_by_id','label'=>'Created By','rules' => 'required' ],
			['field' =>'transfer_out_date','label'=>'Date is not given','rules' => 'required' ],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim'],
			['field' =>'scan_geo_loc_address','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        } 
				//$data['request_id'] = rand(1111111111,9999999999);
				$data['created_date_time'] = date("Y-m-d H:i:s");
				
		$data['product_id'] = $result[0]['product_id'];	
		$data['code_packaging_level'] = $result[0]['pack_level'];			
		 $isItemAlreadyExists = $this->Productmodel->isItemAlreadyExists($data['bar_code']);
		 
		  $isitMaster = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
		 
		//if($isitMaster>0){
		//if($isItemAlreadyExists==true){
		    if($this->db->insert('dispatch_stock_transfer_out', $data)){
				
				$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "ship_out_order";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
					
			$tlogdata['trax_slug'] = "ShipOutOrder"; 
			$tlogdata['trax_name'] = "Ship Out Order";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;	
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			$product_id = $data['product_id']; 
			$location_id = $data['location_id'];
			$code_packaging_level = $data['code_packaging_level'];
			$isProductExistsinLocation = $this->Productmodel->isProductExistsinLocation($product_id, $location_id, $code_packaging_level);
			//$isProductExistsinLocation != true;
			$data2['plant_id'] = $data['plant_id'];
			$data2['location_id'] = $data['location_id'];
			$data2['product_id'] = $data['product_id'];
			$data2['code_packaging_level'] = $data['code_packaging_level'];
			$data2['created_by_id'] = $userId;
			$data2['update_date'] = date("Y-m-d H:i:s");
			if($isProductExistsinLocation==true){
				
				$Rstock_transfer_out_qty = $this->db->select('stock_transfer_out_qty')->from('inventory_on_hand')->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']))->get()->row();
				$stock_transfer_out_qty = $Rstock_transfer_out_qty->stock_transfer_out_qty;
				
				$data2['stock_transfer_out_qty'] = $stock_transfer_out_qty+1;
				$this->db->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']));
				$this->db->update('inventory_on_hand', $data2);
				
			} else {
				$data2['stock_transfer_out_qty'] = 1;
				$data2['stock_transfer_in_qty'] = 0;
				$this->db->insert('inventory_on_hand',$data2);
				
			}
			
			$transactionType = "ship_out_order";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Ship Out Order";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['delink_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);	
	
            $this->response(['status'=>true,'message'=>'Ship Out Order has been added.','stock_data'=>$data,'code_data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to Ship Out Order.'],200); 
        } /*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Out-Stock because this item already exists.'],200); 
        } 
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Ship Out Order because only master carton can be Dispatch.'],200); 
        }*/
    }
	
	
	public function DispatchStockTransferOut(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'request_id','label'=>'Request ID','rules' => 'trim'],
			['field' =>'plant_id','label'=>'plant_id is required','rules' => 'required' ],
			['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
			['field' =>'invoice_number','label'=>'Invoice Number','rules' => 'required' ],
			['field' =>'transaction_type','label'=>'Transaction Type','rules' => 'required' ],
			['field' =>'location_type','label'=>'Location Type','rules' => 'required' ],
			['field' =>'location_id','label'=>'Location id','rules' => 'required' ],
			['field' =>'location_name','label'=>'Location Name','rules' => 'required' ],
			['field' =>'created_by_id','label'=>'Created By','rules' => 'required' ],
			['field' =>'transfer_out_date','label'=>'Date is not given','rules' => 'required' ],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        } 
				$data['request_id'] = rand(1111111111,9999999999);
				$data['created_date_time'] = date("Y-m-d H:i:s");
				
		$data['product_id'] = $result[0]['product_id'];	
		$data['code_packaging_level'] = $result[0]['pack_level'];	
			$product_id = $data['product_id']; 
			$location_id = $data['location_id'];
			$code_packaging_level = $data['code_packaging_level'];
		$isProductExistsinLocationOverallGlobalInventoryInHand = $this->Productmodel->isProductExistsinLocationOverallGlobalInventoryInHand($product_id, $location_id, $code_packaging_level, $userId);
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
		$query_tr_ref_id = $this->db->select('tr_ref_id')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$tr_ref_id = $query_tr_ref_id->tr_ref_id;
				$data['tr_ref_id'] = $tr_ref_id;
			} else {
				$query_tr_ref_id = $this->db->select('id')->from('overall_global_inventory_in_hand')->where(array('product_id' => $product_id, 'location_id' => $location_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$trid1 = $query_tr_ref_id->id;
				$trid = $trid1;
				$tr_ref_id = $trid.$data['request_id'];
				$data['tr_ref_id'] = $tr_ref_id;			
			}
			
		
		 $isItemAlreadyExists = $this->Productmodel->isItemAlreadyExists($data['bar_code']);
		 
		  $isitMaster = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
		 
		if($isitMaster>0){
		//if($isItemAlreadyExists==true){
		    if($this->db->insert('dispatch_stock_transfer_out', $data)){
				
				$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "dispatch_from_plant_or_warehouse_to_warehouse";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
				
			$tlogdata['trax_slug'] = "DispatchStockTransferOut"; 
			$tlogdata['trax_name'] = "Stock Transfer Out";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;	
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
		 $ifProductCodeExistsInOverallGlobalInventoryClosing = $this->Productmodel->ifProductCodeExistsInOverallGlobalInventoryClosing($data['bar_code'], $location_id, $userId);
		if($ifProductCodeExistsInOverallGlobalInventoryClosing==true){				
			$GlobalInventoryClosing_query = $this->db->select('stock_status')->from('overall_global_inventory_closing')->where(array('product_bar_code' => $data['bar_code'], 'location_id' => $location_id, 'created_by_id' => $userId))->get()->row();
				$stock_status = $GlobalInventoryClosing_query->stock_status;				
				$GlobalInventoryClosingData['stock_status'] = $stock_status-1;
				$this->db->where(array('product_bar_code' => $data['bar_code']));
				$this->db->update('overall_global_inventory_closing', $GlobalInventoryClosingData);		
			} else {				
			$OGICData['tr_ref_id'] = $tr_ref_id;
			$OGICData['trax_slug'] = "ReceiptStockTransferOutClosing"; 
			$OGICData['trax_name'] = "Stock Transfer Out Closing";
			$OGICData['request_id'] = $data['request_id'];
			$OGICData['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$OGICData['invoice_number'] = $data['invoice_number'];
			$OGICData['product_id'] = $result[0]['product_id']; 
			$OGICData['product_sku'] = $result[0]['product_sku']; 
			$OGICData['product_bar_code'] = $data['bar_code'];
			$OGICData['stock_status'] = -1;
			$OGICData['code_packaging_level'] = $code_packaging_level;
			$OGICData['transaction_type'] = "ReceiptStockTransferInClosing";
			$OGICData['location_type'] = get_locations_type_by_id($location_id); 
			$OGICData['location_id'] = $data['location_id']; 			
			$OGICData['location_name'] = get_locations_name_by_id($data['location_id']);
			$OGICData['transfer_date'] = date('Y-m-d'); 
			$OGICData['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$OGICData['created_by_id'] = $userId; 
			$OGICData['parent_customer_id'] = $result[0]['created_by']; 
			$OGICData['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$OGICData['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$OGICData['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$OGICData['scan_loc_city'] = $data['scan_loc_city']; 
			$OGICData['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			
			$this->db->insert('overall_global_inventory_closing', $OGICData);
			}
			
			
			$isProductExistsinLocation = $this->Productmodel->isProductExistsinLocation($product_id, $location_id, $code_packaging_level);
			//$isProductExistsinLocation != true;
			$data2['plant_id'] = $data['plant_id'];
			$data2['location_id'] = $data['location_id'];
			$data2['product_id'] = $data['product_id'];
			$data2['code_packaging_level'] = $data['code_packaging_level'];
			$data2['created_by_id'] = $userId;
			$data2['update_date'] = date("Y-m-d H:i:s");
			if($isProductExistsinLocation==true){
				
				$Rstock_transfer_out_qty = $this->db->select('stock_transfer_out_qty')->from('inventory_on_hand')->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']))->get()->row();
				$stock_transfer_out_qty = $Rstock_transfer_out_qty->stock_transfer_out_qty;
				
				$data2['stock_transfer_out_qty'] = $stock_transfer_out_qty+1;
				$this->db->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']));
				$this->db->update('inventory_on_hand', $data2);
				
			} else {
				$data2['tr_ref_id'] = $tr_ref_id;
				$data2['stock_transfer_out_qty'] = 1;
				$data2['stock_transfer_in_qty'] = 0;
				$this->db->insert('inventory_on_hand',$data2);
				
			}
			
			
			
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
				$Rdirect_customer_sale_qty = $this->db->select('stock_transfer_out_qty, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'created_by_id' => $userId, 'code_packaging_level' => $code_packaging_level, 'inventory_date' => date("Y-m-d")))->get()->row();
				
				$stock_transfer_out_qty = $Rdirect_customer_sale_qty->stock_transfer_out_qty;
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				
				
				$data20['stock_transfer_out_qty'] = $stock_transfer_out_qty+1;
				$data20['closing_inventory_quantity'] = $closing_inventory_quantity-1;
				$this->db->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")));
				$this->db->update('overall_global_inventory_in_hand', $data20);				
			} else {
				
				$Rdirect_customer_sale_qty = $this->db->select('tr_ref_id, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId))->order_by('id', 'desc')->limit(1)->get()->row();
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				$prev_tr_ref_id = $Rdirect_customer_sale_qty->tr_ref_id;
				
				$data21['prev_tr_ref_id'] = $prev_tr_ref_id;
				$data21['tr_ref_id'] = $tr_ref_id;
				$data21['product_id'] = $product_id;
				$data21['location_id'] = $location_id;
				$data21['created_by_id'] = $userId;
				$data21['opening_inventory_quantity'] = $closing_inventory_quantity;
				$data21['product_returned_from_customer_qty'] = 0;
				$data21['stock_transfer_out_qty'] = 1;
				$data21['direct_customer_sale_qty'] = 0;
				$data21['stock_transfer_in_qty'] = 0;
				$data21['closing_inventory_quantity'] = $closing_inventory_quantity-1;
				$data21['code_packaging_level'] = $code_packaging_level;
				$data21['inventory_date'] = date("Y-m-d");
				$data21['update_date'] = date("Y-m-d H:i:s");;
				$this->db->insert('overall_global_inventory_in_hand',$data21);				
			}
			
			
			$transactionType = "dispatch_from_plant_or_warehouse_to_warehouse";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Dispatch from plant/Warehouse to Warehouse (Stock Transfer-Out)";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['tansfer_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
            $this->response(['status'=>true,'message'=>'Dispatch Stock Transfer-Out has been added.','stock_data'=>$data,'code_data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to Dispatch Stock Transfer-Out.'],200); 
        } /*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Out-Stock because this item already exists.'],200); 
        } */
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Out-Stock because only master carton can be Dispatch.'],200); 
        }
    }
	
	public function ReceiptStockTransferIn(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'request_id','label'=>'Request ID','rules' => 'trim'],
			['field' =>'plant_id','label'=>'plant_id is required','rules' => 'required' ],
			['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
			['field' =>'invoice_number','label'=>'Invoice Number','rules' => 'required' ],
			['field' =>'transaction_type','label'=>'Transaction Type','rules' => 'required' ],
			['field' =>'location_type','label'=>'Location Type','rules' => 'required' ],
			['field' =>'location_id','label'=>'Location id','rules' => 'required' ],
			['field' =>'location_name','label'=>'Location Name','rules' => 'required' ],
			['field' =>'created_by_id','label'=>'Created By','rules' => 'required' ],
			['field' =>'transfer_out_date','label'=>'Date is not given','rules' => 'required' ],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
            
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        } 
				//$data['request_id'] = rand(1111111111,9999999999); 
				$data['created_date_time'] = date("Y-m-d H:i:s");
				
		$data['product_id'] = $result[0]['product_id'];
		$data['code_packaging_level'] = $result[0]['pack_level'];
		
			$product_id = $data['product_id']; 
			$location_id = $data['location_id'];
			$code_packaging_level = $data['code_packaging_level'];
			
		$isProductExistsinLocationOverallGlobalInventoryInHand = $this->Productmodel->isProductExistsinLocationOverallGlobalInventoryInHand($product_id, $location_id, $code_packaging_level, $userId);
		
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
		$query_tr_ref_id = $this->db->select('tr_ref_id')->from('overall_global_inventory_in_hand')->where(array('product_id' => $product_id, 'location_id' => $location_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$tr_ref_id1 = $query_tr_ref_id->tr_ref_id;
				$data['tr_ref_id'] = $tr_ref_id1;
			} else {
				$query_tr_ref_id = $this->db->select('id')->from('overall_global_inventory_in_hand')->where(array('product_id' => $product_id, 'location_id' => $location_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$trid1 = $query_tr_ref_id->id;
				$trid = $trid1;
				$tr_ref_id = $trid.$data['request_id'];
				$data['tr_ref_id'] = $tr_ref_id;			
			}
			
		 $isItemAlreadyExistsStockIn = $this->Productmodel->isItemAlreadyExistsStockIn($data['bar_code']);
		
		 $isitMaster = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
		 
		if($isitMaster>0){
		//if($isItemAlreadyExistsStockIn==true){
		    if($this->db->insert('receipt_stock_transfer_in', $data)){
				
				$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "receipt_at_warehouse_or_plant";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
					
					
			$tlogdata['trax_slug'] = "ReceiptStockTransferIn"; 
			$tlogdata['trax_name'] = "Stock Transfer In";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			$ifProductCodeExistsInOverallGlobalInventoryClosing = $this->Productmodel->ifProductCodeExistsInOverallGlobalInventoryClosing($data['bar_code'], $location_id, $userId);
		
		if($ifProductCodeExistsInOverallGlobalInventoryClosing==true){				
			$GlobalInventoryClosing_query = $this->db->select('stock_status')->from('overall_global_inventory_closing')->where(array('product_bar_code' => $data['bar_code'], 'location_id' => $location_id, 'created_by_id' => $userId))->get()->row();
				$stock_status = $GlobalInventoryClosing_query->stock_status;				
				$GlobalInventoryClosingData['stock_status'] = $stock_status+1;
				$this->db->where(array('product_bar_code' => $data['bar_code']));
				$this->db->update('overall_global_inventory_closing', $GlobalInventoryClosingData);		
			} else {				
			$OGICData['tr_ref_id'] = $data['tr_ref_id'];
			$OGICData['trax_slug'] = "ReceiptStockTransferInClosing"; 
			$OGICData['trax_name'] = "Stock Transfer In Closing";
			$OGICData['request_id'] = $data['request_id'];
			$OGICData['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$OGICData['invoice_number'] = $data['invoice_number'];
			$OGICData['product_id'] = $result[0]['product_id']; 
			$OGICData['product_sku'] = $result[0]['product_sku']; 
			$OGICData['product_bar_code'] = $data['bar_code'];
			$OGICData['stock_status'] = 1;
			$OGICData['code_packaging_level'] = $code_packaging_level;
			$OGICData['transaction_type'] = "ReceiptStockTransferInClosing";
			$OGICData['location_type'] = get_locations_type_by_id($location_id); 
			$OGICData['location_id'] = $data['location_id']; 			
			$OGICData['location_name'] = get_locations_name_by_id($data['location_id']);
			$OGICData['transfer_date'] = date('Y-m-d'); 
			$OGICData['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$OGICData['created_by_id'] = $userId; 
			$OGICData['parent_customer_id'] = $result[0]['created_by']; 
			$OGICData['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$OGICData['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$OGICData['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$OGICData['scan_loc_city'] = $data['scan_loc_city']; 
			$OGICData['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			
			$this->db->insert('overall_global_inventory_closing', $OGICData);
			}
			
			
			
			$isProductExistsinLocation = $this->Productmodel->isProductExistsinLocation($product_id, $location_id, $code_packaging_level);
			//$isProductExistsinLocation != true;
			
			$data2['plant_id'] = $data['plant_id'];
			$data2['location_id'] = $data['location_id'];
			$data2['product_id'] = $data['product_id'];
			$data2['code_packaging_level'] = $data['code_packaging_level'];
			$data2['created_by_id'] = $userId;
			$data2['update_date'] = date("Y-m-d H:i:s");
			if($isProductExistsinLocation==true){
				
				$Rstock_transfer_in_qty = $this->db->select('stock_transfer_in_qty')->from('inventory_on_hand')->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']))->get()->row();
				$stock_transfer_in_qty = $Rstock_transfer_in_qty->stock_transfer_in_qty;
				
				$data2['stock_transfer_in_qty'] = $stock_transfer_in_qty+1;
				$this->db->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']));
				$this->db->update('inventory_on_hand', $data2);
				
			} else {
				$data2['tr_ref_id'] = $data['tr_ref_id'];
				$data2['stock_transfer_out_qty'] = 0;
				$data2['stock_transfer_in_qty'] = 1;
				$this->db->insert('inventory_on_hand',$data2);
				
			}
			
			
			
			
	
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
				$Rdirect_customer_sale_qty = $this->db->select('stock_transfer_in_qty, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$stock_transfer_in_qty = $Rdirect_customer_sale_qty->stock_transfer_in_qty;
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				//$opening_inventory_quantity = $Rdirect_customer_sale_qty->opening_inventory_quantity;
				
				$dataOGIH1['stock_transfer_in_qty'] = $stock_transfer_in_qty+1;
				$dataOGIH1['closing_inventory_quantity'] = $closing_inventory_quantity+1;
				$this->db->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")));
				$this->db->update('overall_global_inventory_in_hand', $dataOGIH1);				
			} else {
				$Rdirect_customer_sale_qty = $this->db->select('tr_ref_id, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId))->order_by('id', 'desc')->limit(1)->get()->row();
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				$prev_tr_ref_id = $Rdirect_customer_sale_qty->tr_ref_id;
				
				$dataOGIH2['prev_tr_ref_id'] = $prev_tr_ref_id;
				$dataOGIH2['tr_ref_id'] = $data['tr_ref_id'];
				$dataOGIH2['plant_id'] = 11;
				$dataOGIH2['product_id'] = $product_id;
				$dataOGIH2['location_id'] = $location_id;
				$dataOGIH2['created_by_id'] = $userId;
				$dataOGIH2['opening_inventory_quantity'] = $closing_inventory_quantity+0;				
				$dataOGIH2['stock_transfer_out_qty'] = 0;
				$dataOGIH2['direct_customer_sale_qty'] = 0;
				$dataOGIH2['stock_transfer_in_qty'] = 1;
				$dataOGIH2['product_returned_from_customer_qty'] = 0;
				$dataOGIH2['closing_inventory_quantity'] = $closing_inventory_quantity + 1;
				$dataOGIH2['code_packaging_level'] = $code_packaging_level;
				$dataOGIH2['inventory_date'] = date("Y-m-d");
				$dataOGIH2['update_date'] = date("Y-m-d H:i:s");
				$this->db->insert('overall_global_inventory_in_hand',$dataOGIH2);				
			}
			
			$transactionType = "receipt_at_warehouse_or_plant";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Receipt at Warehouse/Plant (Stock Transfer-In)";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['transfer_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);	
	
            $this->response(['status'=>true,'message'=>'Receipt Stock Transfer-In has been added.','stock_data'=>$data,'code_data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to Dispatch Stock Transfer-In.'],200); 
        } /*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Stock Transfer-In because this item already exists.'],200); 
        } */
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Stock Transfer-In because only master carton can be Stock Transfer-In.'],200); 
        }
		
    }
	
	public function PhysicalInventoryCheck(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'plant_id','label'=>'plant_id is required','rules' => 'required' ],
			['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
			['field' =>'pi_number','label'=>'Physical Inventory Number','rules' => 'required' ],
			['field' =>'transaction_type','label'=>'Transaction Type','rules' => 'required' ],
			['field' =>'location_type','label'=>'Location Type','rules' => 'required' ],
			['field' =>'location_id','label'=>'Location id','rules' => 'required' ],
			['field' =>'location_name','label'=>'Location Name','rules' => 'required' ],
			['field' =>'created_by_id','label'=>'Created By','rules' => 'required' ],
			['field' =>'inventory_in_date','label'=>'Date is not given','rules' => 'required' ],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
            
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
		$barCodes = $data['bar_code'];
		$data['created_by_parent_id'] = getParentIdFromUserIdTAPP($userId);
        $result = $this->Productmodel->barcodeProductsInactive($barCodes, $userId);
		$array = array('product_id' => $result[0]['product_id'], 'location_id' => $data['location_id']);
		$total_codes_quantity_of_productr = $this->db->where($array)->from("physical_inventory_check")->count_all_results();
		$result['total_codes_quantity_of_product'] = $total_codes_quantity_of_productr + 1;
		//echo "<pre>";print_r($result);die;
		
		 if(empty($result) || $result[0]['product_id']==""){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        } 
		
				$data['request_id'] = rand(1111111111,9999999999); 
				$data['created_date_time'] = date("Y-m-d H:i:s");
				$data['product_id'] = $result[0]['product_id'];
				//$data['code_packaging_level'] = $result[0]['pack_level'];
				//echo "<pre>";print_r($data['product_id']);die;
		 $isItemAlreadyExistsInInventory = $this->Productmodel->isItemAlreadyExistsInInventory($data['bar_code']);
		
		
			$product_id = $data['product_id']; 
			$location_id = $data['location_id'];
			$code_packaging_level = $result[0]['pack_level'];
		
		$isProductExistsinLocationSummery = $this->Productmodel->isProductExistsinLocationSummery($product_id, $location_id, $code_packaging_level);
			$data2['plant_id'] = $data['plant_id'];
			$data2['pi_number'] = $data['pi_number'];
			$data2['pi_summery_date'] = date("Y-m-d H:i:s");
			$data2['location_id'] = $data['location_id'];
			$data2['location_name'] = get_locations_name_by_id($data['location_id']);
			$data2['product_id'] = $data['product_id'];
			$data2['product_sku'] = get_product_sku_by_id($data['product_id']);
			$data2['product_name'] = get_products_name_by_id($data['product_id']);
			$data2['pack_level'] = $result[0]['pack_level'];
			$data2['customer_user_id'] = $userId;
			if($isProductExistsinLocationSummery==true){				
				
				$Rqty_as_per_pi = $this->db->select('qty_as_per_pi')->from('physical_inventory_summary')->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'pack_level' => $data2['pack_level']))->get()->row();
				$qty_as_per_pi = $Rqty_as_per_pi->qty_as_per_pi;
				
				$data2['qty_as_per_pi'] = $qty_as_per_pi+1;
				$this->db->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'pack_level' => $data2['pack_level']));
				
				$this->db->update('physical_inventory_summary', $data2);
				
			} else {
				
				
				$data2['qty_as_per_pi'] = 1;
				
				$Rstock_transfer_in_qty = $this->db->select('stock_transfer_in_qty')->from('inventory_on_hand')->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['pack_level']))->get()->row();
				$stock_transfer_in_qty = $Rstock_transfer_in_qty->stock_transfer_in_qty;
				
				$Rstock_transfer_out_qty = $this->db->select('stock_transfer_out_qty')->from('inventory_on_hand')->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['pack_level']))->get()->row();
				$stock_transfer_out_qty = $Rstock_transfer_out_qty->stock_transfer_out_qty;
				
				$data2['qty_as_per_on_hand'] = $stock_transfer_out_qty - $stock_transfer_in_qty;
				$this->db->insert('physical_inventory_summary',$data2);
				
			}
			
			
			
		
		//if($isItemAlreadyExistsInInventory==true){
		    if($this->db->insert('physical_inventory_check', $data)){
				
			$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "physical_inventory_check";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
					
			$tlogdata['trax_slug'] = "PhysicalInventoryCheck"; 
			$tlogdata['trax_name'] = "Physical Inventory Check";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;
		
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			$transactionType = "physical_inventory_check";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Physical Inventory Check";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['inventory_check_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->response(['status'=>true,'message'=>'Physical inventory  has been added.','stock_data'=>$data,'code_data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add.'],200); 
        } /*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add Physical inventory check because this item already exists.'],200); 
        } */
		
    }
	
	
	public function DeleteProductParentDelink(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'location_id','label'=>'location id is required','rules' => 'required' ],
			['field' =>'parent_bar_code','label'=>'Parent Barcode','rules' => 'required' ],
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
		$product_id = $result[0]['product_id']; 
		//echo print_r($result); die;
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     
		 $isPackLevelSetedExits = $this->Productmodel->isPackLevelSetedExits($data['bar_code'],$data['parent_bar_code']);
		if($isPackLevelSetedExits==true){
			
		$this->db->set('unpackaging_status', "Un-Packaging Done");
        $this->db->set('unpackaging_date', (new DateTime('now'))->format('Y-m-d H:i:s'));
        $this->db->set('unpacked_by_id', $user['user_id']);
		 $this->db->set('unpackaging_location_id', $data['location_id']);
        $this->db->where(array('bar_code' => $data['bar_code'], 'parent_bar_code' => $data['parent_bar_code']));
	
	
        if($this->db->update('packaging_codes_pcr')){
			
			$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "unpackaging";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
					
			$tlogdata['trax_slug'] = "DeleteProductParentDelink"; 
			$tlogdata['trax_name'] = "Un-Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;	
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			if (!$this->db->affected_rows()) {
					$this->response(['status'=>false,'message'=>'System failed to Child De-Linked, incorrect parent.'],200); 
				} else {
					
			$transactionType = "unpackaging";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Un-Packaging";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['delink_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);	
					$this->response(['status'=>true,'message'=>'Child De-Linked Successfully.','data'=>$result]);
					
	
				}
        }else{ $this->response(['status'=>false,'message'=>'System failed to Child De-Linked, incorrect parent.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'Child does not exist.'],200); 
        }
    }	
	
	
	
	public function location_type_master(){
       
		$user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
		
		
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $data = [];
        $data = $this->Productmodel->location_type_master();
                if(!empty($data)){
            Utils::response(['status'=>true,'message'=>'List of locations.','data'=>$data]);
        }else{
            Utils::response(['status'=>false,'message'=>'There is no record found.'],200);
        }
    }
	
	public function location_master(){
       
		$user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
		
		
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $data = [];
		$userId = $user['user_id'];
		$ParentuserId = getParentIdFromUserIdTAPP($userId);
		//print_r($userId);
		//print_r($ParentuserId); exit;
        $data = $this->Productmodel->location_master($ParentuserId);
                if(!empty($data)){
            Utils::response(['status'=>true,'message'=>'List of locations.','data'=>$data]);
        }else{
            Utils::response(['status'=>false,'message'=>'There is no record found.'],200);
        }
    }
	
	public function location_details_byid($location_id){
       
		$user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
		
		
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $data = [];
		$userId = $user['user_id'];
		$ParentuserId = getParentIdFromUserIdTAPP($userId);
		//print_r($userId);
		//print_r($ParentuserId); exit;
        $data = $this->Productmodel->location_details_byid($location_id);
                if(!empty($data)){
            Utils::response(['status'=>true,'message'=>'List of locations.','data'=>$data]);
        }else{
            Utils::response(['status'=>false,'message'=>'There is no record found.'],200);
        }
    }
	
	public function PhysicalInventoryOnHand(){
       
		$user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
		
		
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $data = [];
		$userId = $user['user_id'];
		$ParentuserId = getParentIdFromUserIdTAPP($userId);
		//print_r($userId);
		//print_r($ParentuserId); exit;
        $data = $this->Productmodel->PhysicalInventoryOnHand($ParentuserId);
		//echo print_r($data[0]['location_id']); exit;
		//$data['location_name']= get_locations_name_by_id($data[0]['location_id']);
                if(!empty($data)){
            Utils::response(['status'=>true,'message'=>'List Physical Inventory On Hand.','data'=>$data]);
        }else{
            Utils::response(['status'=>false,'message'=>'There is no record found.'],200);
        }
    }
	
	
	  public function TCLoyaltyRedemptionRequest() {
        //Utils::debug();
         $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'location_id','label'=>'location id is required','rules' => 'required|trim'],
			['field' =>'consumer_mobile_no','label'=>'Consumer Mobile Number','rules' => 'trim|required|integer|exact_length[10]'],
			['field' =>'invoice_value','label'=>'Invoice Value','rules' => 'required|trim'],
			//['field' =>'points_redeemed','label'=>'Redeemed Points','rules' => 'required|trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $data['consumer_id'] = get_consumer_id_by_mobile_number($data['consumer_mobile_no']);
		$data['cashier_tracek_user_id'] = $userId;
		$data['brand_customer_id'] = getUserParentIDById($userId);
		$data['redemption_otp'] = Utils::randomNumber(5);
		$data['request_date'] = date("Y-m-d H:i:s");
		$data['lr_status'] = 0;
		$customer_id = getUserParentIDById($userId);
		$customer_name = getUserFullNameById($customer_id);
		
		$loyalty_point_weightage_with_compare_to_currency = getLoyaltyPointWeightageByCustomerId(getUserParentIDById($userId));
		$currency_points_tobe_redeemed = ($data['invoice_value']*100)/$loyalty_point_weightage_with_compare_to_currency;
		
		$percent_loyalty_points_redeemed_cashier_store = getPercentLoyaltyPointsRedeemedCashierStoreByCustomerId(getUserParentIDById($userId));
		
		
		
		$points_tobe_redeemed = round((($percent_loyalty_points_redeemed_cashier_store/100)*$currency_points_tobe_redeemed),0,PHP_ROUND_HALF_DOWN);
		
		// consumer loyalty info
					$this->db->select_sum('cpb.points');
			$this->db->from('consumer_passbook as cpb');
			$this->db->join('consumers as c','c.id=cpb.consumer_id');
	$this->db->where(array('c.mobile_no' => $data['consumer_mobile_no'], 'cpb.customer_id' => $data['brand_customer_id'], 'cpb.transaction_lr_type' =>  "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;	
			
			$this->db->select_sum('cpb.points');
			$this->db->from('consumer_passbook as cpb');
			$this->db->join('consumers as c','c.id=cpb.consumer_id');
	$this->db->where(array('c.mobile_no' => $data['consumer_mobile_no'], 'cpb.customer_id' => $data['brand_customer_id'], 'cpb.transaction_lr_type' =>  "Redemption"));	
			$query2=$this->db->get();
			$Total_Points_Redeemed=$query2->row()->points;
			
			$this->db->select_sum('cpb.points');
			$this->db->from('consumer_passbook as cpb');
			$this->db->join('consumers as c','c.id=cpb.consumer_id');
	$this->db->where(array('c.mobile_no' => $data['consumer_mobile_no'], 'cpb.customer_id' => $data['brand_customer_id'], 'cpb.transaction_lr_type' =>  "Expiry"));	
			$query3=$this->db->get();
			$Total_Points_Expiry=$query3->row()->points;
			
			//$Earned_Loyalty_Points = $this->Productmodel->getconsumerEarnedLoyaltyPoints();
			//$Redeemed_Loyalty_Points = $this->Productmodel->getconsumerRedeemedLoyaltyPoints();
			
				$Balance_Loyalty_Points = $Total_Earned_Points - ($Total_Points_Redeemed+$Total_Points_Expiry);
		// consumer loyalty info end 
		if($Balance_Loyalty_Points >= $points_tobe_redeemed){
			$data['points_redeemed'] = $points_tobe_redeemed;
			$duscount_rupees_value = round((($points_tobe_redeemed*getLoyaltyPointWeightageByCustomerId($customer_id))/100),0,PHP_ROUND_HALF_DOWN);
		}else{
			$data['points_redeemed'] = $Balance_Loyalty_Points;
			$duscount_rupees_value = round((($Balance_Loyalty_Points*getLoyaltyPointWeightageByCustomerId($customer_id))/100),0,PHP_ROUND_HALF_DOWN);
		}
		$smstext = 'Please Share OTP ' . $data['redemption_otp'] . ', with cashier to redeem your ' . $data['points_redeemed'] . ' loyalty points of ' . $customer_name . ' with redemption value of Rs. ' . $duscount_rupees_value . ' against your invoice value of Rs. ' . $data['invoice_value'] . '. ';
		  //$smstext = $message_notification_value . $data['redemption_otp'] . $message_notification_value_part2;
		
                Utils::sendSMS($data['consumer_mobile_no'], $smstext . " zLJoGnJzfXg");
				
				$fb_token = getConsumerFb_TokenById($data['consumer_id']);
				$this->ConsumerModel->sendFCM($smstext, $fb_token);
				
				
			$TRNNCData['customer_id'] = getUserParentIDById($userId);
			$TRNNCData['consumer_id'] = $data['consumer_id'];
			$TRNNCData['billing_particular_name'] = $smstext;		
			$TRNNCData['billing_particular_slug'] = $smstext;
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);
			
			
			$NTFdata['consumer_id'] = $data['consumer_id']; 
			$NTFdata['customer_id'] = getUserParentIDById($userId); 
			$NTFdata['title'] = "Loyalty Redemption by Cashier";
			$NTFdata['body'] = $smstext; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
			
				
			$data['opening_loyalty_balance'] = $Balance_Loyalty_Points;	
        if ($this->db->insert('loyalty_redemption_customer_cashier', $data)) {
			
			$data['consumer_name'] = getConsumerNameById($data['consumer_id']);
			$data['total_balance_Loyalty_Points'] = $Balance_Loyalty_Points;
			
			// Tracek Cashier User Log Data insert start
			
			// Tracek Cashier User Log Data insert end
				
            //$this->Productmodel->saveLoylty('loyalty-redemption', $user['id'], ['user_id' => $user['id'],'redemption_id'=>$redemptionId]);
		//$mnv19_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 19)->get()->row();
		//$mnvtext19 = $mnv19_result->message_notification_value;
            Utils::response(['status'=>true,'message'=>'Thank you for your redemption request, after OTP verification, your request will be processed instantly.', 'data' =>$data]);
			//Utils::response(['status'=>true,'message'=>$mnvtext19]);
        }else{
		//$mnv20_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 20)->get()->row();
		//$mnvtext20 = $mnv20_result->message_notification_value;
            Utils::response(['status'=>false,'message'=>'Failed to accept the redemption request.Please contact support team.']);
			//Utils::response(['status'=>false,'message'=>$mnvtext20]);
        }
		
		}
		
	public function TCLoyaltyRedemptionverifyOtp() {
		
		 $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' => 'consumer_mobile_no', 'label' => 'Consumer Mobile No', 'rules' => 'trim|required|integer|exact_length[10]'],
            ['field' => 'redemption_otp', 'label' => 'One time password for loyalty redemption.', 'rules' => 'required|min_length[6]']
        ];
		
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		
		$userId = $user['user_id'];
		$CashierId = $userId;
		$transaction_id = getTransactionIDByMobileNoOTP($data['consumer_mobile_no'],$data['redemption_otp']);
        $dbdata = $this->CustomerModel->findByLoyaltyRedemption(['consumer_mobile_no' => $data['consumer_mobile_no'],'redemption_otp' => $data['redemption_otp'],'lr_status' => 0]);
		
		$transaction_id2 = $dbdata->lrcc_id;
		
        if (!$dbdata) {
            Utils::response(['status' => false, 'message' => 'Invalid Transaction tried.']);
        }
		
			$parent_customer_id = getUserParentIDById($userId);	
			$transactionTypeName = "Loyalty Redemption in store - " . getUserFullNameById($parent_customer_id);
			$transactionType = "Loyalty Redemption at Retail Store";
			$redeeming_points = $dbdata->points_redeemed;
			$loyalty_points_redeemd_rs = round((($redeeming_points*getLoyaltyPointWeightageByCustomerId($parent_customer_id))/100),0,PHP_ROUND_HALF_DOWN);
			$opening_loyalty_balance = $dbdata->opening_loyalty_balance;
			$closing_loyalty_balance = $opening_loyalty_balance - $redeeming_points;
			$product_id = 0;
			$consumer_id = get_consumer_id_by_mobile_number($data['consumer_mobile_no']);			
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = getUserFullNameById($parent_customer_id);
			$customer_name = getUserFullNameById($parent_customer_id); 
			$product_name = "Retail Store"; 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($parent_customer_id);
			$transaction_lr_type = "Redemption";
			$promotion_id = 0;
		
        if ($dbdata->redemption_otp == $data['redemption_otp']){
				
				$data5['lr_status'] = 1;
				$data5['verification_date'] = date("Y-m-d H:i:s");
				$data5['closing_loyalty_balance'] = $closing_loyalty_balance;
				$this->db->where(array('lrcc_id' => $transaction_id2));
				$this->db->update('loyalty_redemption_customer_cashier', $data5);
				
		
		// update redeemed loyalty 	 
	//$i = 1000;			
//	for($i=0; $i <= 10; $i++){
	$this->db->select('id, points, redeemed_points, loyalty_points_status');
    $this->db->where(array('user_id' => $consumer_id, 'customer_id' => $parent_customer_id, 'modified_at' => "0000-00-00 00:00:00"));
	//$this->db->where("loyalty_points_status='Earned' OR loyalty_points_status='RedeemedPartial'");
	//->where("CCL.consumer_id ='".$consumer_id."' OR PA.consumer_id ='".$consumer_id."'")
	//$this->db->where("user_id ='" . $consumer_id . "' AND customer_id='" . $parent_customer_id . "' AND loyalty_points_status='Earned' OR loyalty_points_status='RedeemedPartial'");
	//$this->db->where('user_id', $consumer_id);
	//$this->db->where('customer_id', $parent_customer_id);
	//$this->db->where('loyalty_points_status', "Earned");
	//$this->db->where('loyalty_points_status', "RedeemedPartial");
	$this->db->order_by('id', 'ASC');
    $this->db->limit(1);
    $query = $this->db->get('loylty_points');
    $row = $query->row();	
	$oldest_loyalty_points = $row->points;
	$oldest_loyalty_points_id = $row->id;
	$redeemed_partial_points = $row->redeemed_points;	
	
	$loyalty_points_status = $row->loyalty_points_status;
	
	//$c_redeeming = $redeeming_points;
	if($oldest_loyalty_points !=""){
		//if(($redeemed_partial_points=="Earned")||($redeemed_partial_points=="RedeemedPartial")){
	if($oldest_loyalty_points > ($redeeming_points+$redeemed_partial_points))
		{				
			$updateData = array(
			   'loyalty_points_status'=>"RedeemedPartial",
			   'redeemed_points'=>$redeeming_points+$redeemed_partial_points,
			   'modified_at'=>"0000-00-00 00:00:00"
			);
			$this->db->where('id', $oldest_loyalty_points_id);
			$this->db->update('loylty_points', $updateData); 
			
			$this->Productmodel->saveConsumerPassbookLoyaltyCashier($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' =>0,'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $parent_customer_id, $promotion_id, $redeeming_points, $CashierId);
			
		//	$this->db->where('lrcc_id', $transaction_id);
		//	$this->db->update('loyalty_redemption_customer_cashier', array('closing_loyalty_balance' => $c_redeeming));
			// break;
			}elseif($oldest_loyalty_points == ($redeeming_points+$redeemed_partial_points)){
				$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$redeeming_points+$redeemed_partial_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				$this->db->update('loylty_points', $updateData); 
				
			//$this->db->where('lrcc_id', $transaction_id);
			//$this->db->update('loyalty_redemption_customer_cashier', array('closing_loyalty_balance' => $c_redeeming));			
			
			$this->Productmodel->saveConsumerPassbookLoyaltyCashier($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $parent_customer_id, $promotion_id, $redeeming_points, $CashierId);			
			//break;				
			}else{ //if($oldest_loyalty_points < ($redeeming_points+$redeemed_partial_points))
			
			$this->Productmodel->saveConsumerPassbookLoyaltyCashier($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => 0,'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $parent_customer_id, $promotion_id, $redeeming_points, $CashierId);	
			
			$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$oldest_loyalty_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				//$this->db->where(array('customer_id'=>$parent_customer_id, 'user_id'=>$consumer_id));
				$this->db->update('loylty_points', $updateData); 	
				
				$redeeming_points2 = $redeeming_points - ($oldest_loyalty_points-$redeemed_partial_points);
				while($redeeming_points2 > 0){	
					
	$this->db->select('id, points, redeemed_points, loyalty_points_status');
    $this->db->where(array('user_id' => $consumer_id, 'customer_id' => $parent_customer_id, 'modified_at' => "0000-00-00 00:00:00"));
	$this->db->order_by('id', 'ASC');
    $this->db->limit(1);
    $query = $this->db->get('loylty_points');
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
			$this->db->update('loylty_points', $updateData2); 
			$FinalRedeemingPoints = $redeeming_points2+$redeemed_partial_points2;
			//break;
			}elseif($oldest_loyalty_points2 == ($redeeming_points2+$redeemed_partial_points2)){
				$updateData2 = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$redeeming_points2+$redeemed_partial_points2,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id2);
				$this->db->update('loylty_points', $updateData2); 	
				$FinalRedeemingPoints = $redeeming_points2+$redeemed_partial_points2;	
			//break;				
			}else{ //if($oldest_loyalty_points < ($redeeming_points+$redeemed_partial_points))			
			$updateData2 = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$oldest_loyalty_points2,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id2);
				//$this->db->where(array('customer_id'=>$parent_customer_id, 'user_id'=>$consumer_id));
				$this->db->update('loylty_points', $updateData2);	
				$FinalRedeemingPoints = $oldest_loyalty_points2;
			//continue;
			}			
				}
				$redeeming_points2 = $redeeming_points2 - ($oldest_loyalty_points2-$redeemed_partial_points2);
				}
			}
			//}		
			}
			
		 // end update redeemed loyalty 
		 /*
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "Loyalty Redemption";
			$NTFdata['body'] = "Loyalty Redemption by Cashier while Consumer shopping"; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 			
			$this->db->insert('list_notifications_table', $NTFdata);
			*/
			

			$dataT['transaction_id'] = $transaction_id;
			$dataT['consumer_name'] = $consumer_name;
			$dataT['consumer_mobile_no'] = $data['consumer_mobile_no'];
			$dataT['discount_given'] = $loyalty_points_redeemd_rs;
			//$dataT['loyalty_points_redeemd'] = $loyalty_points_redeemd_rs;
			//$dataT['discount_given'] = $loyalty_points_redeemd_rs;
			
            Utils::response(['status' => true, 'message' => 'Consumer Loyalty processed Successfully. Please provide your invoice number with Transaction ID ' . $transaction_id . ' to complete the billing.', 'data' =>$dataT]);
        }else{
		 Utils::response(['status' => false, 'message' => 'OTP has not been matched.-' . $data['consumer_mobile_no']]);	
		}
    }	
	
	
		public function TCFeedInvoiceNumber() {
		
		 $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' => 'transaction_id', 'label' => 'Transaction ID', 'rules' => 'trim|required|integer'],
            ['field' => 'invoice_number', 'label' => 'Invoice Number', 'rules' => 'trim|required']
        ];
		
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		
		$userId = $user['user_id'];
		$CashierId = $userId;
		/*
        $dbdata = $this->CustomerModel->findByLoyaltyRedemption(['consumer_mobile_no' => $data['consumer_mobile_no'],'redemption_otp' => $data['redemption_otp'],'lr_status' => 0]);
        if (!$dbdata) {
            Utils::response(['status' => false, 'message' => 'Invalid Transaction tried.']);
        }
		*/
        if (!empty($data['transaction_id'])){
				
				$data6['invoice_number'] = $data['invoice_number'];
				$this->db->where(array('lrcc_id' => $data['transaction_id']));
				$this->db->update('loyalty_redemption_customer_cashier', $data6);
				
				
		 // end update redeemed loyalty 
		// $consumer_id = getConsumerIDByTransactionID($data['transaction_id']);
		 
		 
			$this->db->select('consumer_id, consumer_mobile_no, points_redeemed, invoice_value, brand_customer_id');
			$this->db->where(array('lrcc_id' => $data['transaction_id']));
			//$this->db->order_by('id', 'ASC');
			//$this->db->limit(1);
			$query = $this->db->get('loyalty_redemption_customer_cashier');
			$row = $query->row();	
			$consumer_id = $row->consumer_id;
			$consumer_mobile_no = $row->consumer_mobile_no;
			$points_redeemed = $row->points_redeemed;	
			$invoice_value = $row->invoice_value;
			$brand_customer_id = $row->brand_customer_id;
			$brand_customer_name = getUserFullNameById($brand_customer_id);
			$loyalty_points_redeemd_rs = round((($points_redeemed*getLoyaltyPointWeightageByCustomerId($brand_customer_id))/100),0,PHP_ROUND_HALF_DOWN);
			
			$smstextnotificationbody = "Thanks for shopping. ". $points_redeemed ." loyalty points of " . $brand_customer_name ." with redemption value of Rs ". $loyalty_points_redeemd_rs ."  have been redeemed against your invoice value of Rs ". $invoice_value;
			
			$fb_token = getConsumerFb_TokenById($consumer_id);
			$this->ConsumerModel->sendFCM($smstextnotificationbody, $fb_token);
		 
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "Invoice Number inserted by Cashier and Send Confirmation notification to consumer";
			$NTFdata['body'] = $smstextnotificationbody; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
			
			
			
			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			
			$TRNNCData['customer_id'] = getUserParentIDById($userId);
			$TRNNCData['consumer_id'] = $consumer_id;
			$TRNNCData['billing_particular_name'] = $TRNNC_billin_particular_name.' Invoice Number Feeded by Cashier';		
			$TRNNCData['billing_particular_slug'] = $TRNNC_billin_particular_slug.'_Invoice_Number_Feeded_by_Cashier';
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);
			
			
			$dataT['transaction_id'] = $data['transaction_id'];
			$dataT['consumer_name'] = getConsumerNameById($consumer_id);
			$dataT['consumer_mobile_no'] = getConsumerMobileNumberById($consumer_id);
			$dataT['discount_given'] = getPointsRedeemedByTransactionID($data['transaction_id']);
			$dataT['invoice_number'] = $data['invoice_number'];
			
			
            Utils::response(['status' => true, 'message' => 'Consumer Loyalty processed Successfully.', 'data' =>$dataT]);
        }else{
		 Utils::response(['status' => false, 'message' => 'Invalid Transaction ID.-' . $data]);	
		}
    }
	
	/*
	public function addProductLevelParentActivate(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'parent_bar_code','label'=>'Parent Barcode','rules' => 'required' ],
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
            ['field' =>'pack_level','label'=>'Packet Level','rules' => 'required']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $result = $this->Productmodel->barcodeProducts($data['bar_code']);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     

		//echo print_r($result[0]['product_id']); 
		
			//die;
        $this->db->set('active_status',1);
        $this->db->set('pack_level',$data['pack_level']);
        $this->db->set('plant_id',$user['plant_id']);
        $this->db->set('customer_id',$user['user_id']);
        $this->db->set('modified_at', (new DateTime('now'))->format('Y-m-d H:i:s'));
        foreach(explode(',',$data['bar_code']) as $ind => $code){
            $this->db->or_where('barcode_qr_code_no',$code);
        }
        if($this->db->update('printed_barcode_qrcode')){
			
			
		
			$data2['barcode_qr_code_no'] = $data['bar_code'];
			$data2['product_id'] = $result[0]['product_id'];
			$data2['packaging_level'] = $data['pack_level'];
			$data2['parent_barcode_qr_code'] = $data['parent_bar_code'];
			$this->db->insert('packaging_codes_pc', $data2);
		
			$product_id = $result[0]['product_id'];
			
			$pack_level_field_name = "pack_level" . $data['pack_level'];
			
			$results2 = $this->db->select($pack_level_field_name)->from('product_packaging_qty_levels')->where('product_id', $product_id)->get()->row();
			$result['number_of_children'] = $results2->$pack_level_field_name;
			
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'Level has been added.','new_pack_level'=>$data['pack_level'],'data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
    }
	
	*/
	
    /**
     * login method to get user logged in by api
     * 
     * @param String $username unique username or email
     * @param String $password password to check authentication
     * @return Object $response contain user details with valid and encrypted token
     */
    
    public function login() {
        $data = $this->getInput();
        if(($this->request->method != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'password','label'=>'Password','rules' => 'trim|required'],
            ['field' =>'device_id','label'=>'Device Id','rules' => 'trim|required']
        ];
        if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            array_push($validate, ['field' =>'username','label'=>'Email','rules' => 'trim|required|valid_email']);
        }else{
            array_push($validate,['field' =>'username','label'=>'User name','rules' => 'trim|required' ]);
        }
        $errors = $this->CustomerModel->validate($data,$validate);
        if(is_array($errors)){
            $this->response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }        
        $user = $this->CustomerModel->authIdentify($data);
        if($user == 'email'){
            $this->response(['status'=>false,'message'=>'Email has not been verified.']);
        }
        if($user == 'mobile'){
            $this->response(['status'=>false,'message'=>'Mobile No has not been verified.']);
        }
        
        if(!is_object($user)){
            $this->response(['status'=>false,'message'=>'Invalid Credentials.']);
        }else{
            $userPlant = $this->db->get_where('assign_plants_to_users',['user_id'=>$user->user_id])->row();
            $user->plant_id = $userPlant->plant_id;
			$userLocation = $this->db->select('location_id')->get_where('assign_locations_to_users',['user_id'=>$user->user_id,'status'=>1])->result_array();
            $user->location_id = $userLocation;
			$user->designation_name_slug = getRoleSlugById($user->designation_id);
			$user->designation_name_value = getRoleNameById($user->designation_id);
			$functionalities = get_assigned_functionalities_to_role_list($user->designation_id, getUserParentIDById($user->user_id));
			//$user->userid = $user->user_id;
			$user->assigned_functionalities_slug = get_functionality_slug_by_id($functionalities);
			$user->assigned_functionalities_name = get_functionality_name_by_id($functionalities);
			$user->company_name = getUserFullNameById(getUserParentIDById($user->user_id));
			$user->company_logo = getUserProfileById(getUserParentIDById($user->user_id));
            $this->response(['status'=>true,'message'=>'Login done successfully.','data'=>$user]);
        }
        
    }
    /**
     * logout user get logged out by using header token
     * 
     * @param String $token Token comes from header
     * @return Object $response in json object
     */
    public function logout() {
        if($this->request->method != 'get'){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        if(empty($this->request->token)){
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
		
        $this->load->model('UserLogModel');
        $this->db->where('token',$this->request->token)->delete($this->UserLogModel->table);
        $this->response(['status'=>true,'message'=>'Logout successfully.']);
    }
	
	
	 /**
     * forgotPassword method to reset password.
     * 
     * @param String $mobile_no|$email either mobile no or email
     * @return Json generated random password
     */
    public function forgotPassword($username = null) {
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $username = urldecode($username);
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $validate = [['field' => 'username', 'label' => 'Email', 'rules' => 'trim|required|valid_email']];
            $condition = ['email_id' => $username];
        } else {
            $validate = [['field' => 'username', 'label' => 'Mobile No', 'rules' => 'trim|required|integer|exact_length[10]']];
            $condition = ['mobile_no' => $username];
        }
        $errors = $this->CustomerModel->validate(['username' => $username], $validate);
        if (is_array($errors)) {
            $this->response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $user = $this->CustomerModel->findBy($condition);
        if (!$user) {
            Utils::response(['status' => false, 'message' => 'Record not found.']);
        }
        $password = Utils::randomNumber(8);
        $user->password = md5($password);
        $smstext = 'System generated password is ' . $password . ' Please change it after doing logging.';
        if (Utils::sendSMS($user->mobile_no, $smstext . " zLJoGnJzfXg")) {
            if ($this->db->update('backend_user', ['password' => $user->password], ['user_id' => $user->user_id])) {
                Utils::response(['status' => true, 'message' => 'A new password has been sent to your registered mobile no.']);
            } else {
                Utils::response(['status' => false, 'message' => 'There is system error to reset password.']);
            }
        } else {
            Utils::response(['status' => false, 'message' => 'Failed to send message, Try after some time.']);
        }
    }


	public function TracekUserPassBook() {
		$user = $this->customerAuth();
		if($this->request->method != 'get'){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        if(empty($this->request->token)){
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
		$userId = $user['user_id'];

		$checkifrquestinprocess = $this->db->where(array('tr_user_id' => $userId, 'l_status' => 0))->count_all_results('tracek_loyalty_redemption');
		
        $data = [];
        $data = $this->Productmodel->getTracekUserPassBook($userId);
		
        if (!empty($data)) {
            Utils::response(['status' => true, 'min_max_redemption_points_consumer' => '1', 'count_lyalty_request_in_process' => $checkifrquestinprocess, 'message' => 'User gain loylties.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }


	public function TracekUserPassBookDashboard() {
		$user = $this->customerAuth();
			if($this->request->method != 'get'){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        if(empty($this->request->token)){
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
		$userId = $user['user_id'];

	
		$checkifrquestinprocess = $this->db->where(array('tr_user_id' => $userId, 'l_status' => 0))->count_all_results('tracek_loyalty_redemption');
		
        $data = [];
        $data = $this->Productmodel->getTracekUserPassBookDashboard($userId);
		
        if (!empty($data)) {
            Utils::response(['status' => true, 'min_max_redemption_points_consumer' => '1', 'count_lyalty_request_in_process' => $checkifrquestinprocess, 'message' => 'User gain loylties.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }

	
		public function TracekUserPassBookDashboardActivityWise() {
		$user = $this->customerAuth();
			if($this->request->method != 'get'){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        if(empty($this->request->token)){
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
		$userId = $user['user_id'];
		$parent_customer_id = getUserParentIDById($userId);
		$parent_customer_name = getUserFullNameById($parent_customer_id);
		$parent_customer_logo = getUserProfileById($parent_customer_id);
		
		$checkifrquestinprocess = $this->db->where(array('tr_user_id' => $userId, 'l_status' => 0))->count_all_results('tracek_loyalty_redemption');
		
        $data = [];
        $data = $this->Productmodel->getTracekUserPassBookDashboardActivityWise($userId);
		
        if (!empty($data)) {
            Utils::response(['status' => true, 'min_max_redemption_points_consumer' => '1', 'count_loyalty_request_in_process' => $checkifrquestinprocess, 'company_name' => $parent_customer_name, 'company_logo' => $parent_customer_logo, 'message' => 'User gain loylties.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }
	

   public function TracekLoyaltyRedemptionRequest() {
 		 $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' => 'tr_lr_points_redeemed', 'label' => 'Redeemed Loyalty Points', 'rules' => 'trim|required|integer'],
			['field' => 'gloc_city', 'label' => 'Redeem City', 'rules' => 'trim'],
			['field' => 'gloc_pin_code', 'label' => 'Pin Code', 'rules' => 'trim'],
			['field' => 'gloc_latitude', 'label' => 'Latitude', 'rules' => 'trim'],
			['field' => 'gloc_longitude', 'label' => 'Longitude', 'rules' => 'trim'],
        ];
		
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		
		$userId = $user['user_id'];	
	
	   $redemtionData['tr_user_id'] = $userId;
	   $redemtionData['customer_id'] = getUserParentIDById($userId);
	   $redemtionData['tr_lr_redemption_id'] = mt_rand(1111111111,9999999999);
	   $redemtionData['tr_lr_points_redeemed'] = $data['tr_lr_points_redeemed'];
	   $redemtionData['tr_user_mobile_no'] = get_customer_mobile_no_id($userId);
	   $redemtionData['tr_user_alternate_mobile_no'] = 0;
	   $redemtionData['tr_user_street_address'] = "";
	   $redemtionData['tr_user_city'] = $data['gloc_city'];
	   $redemtionData['tr_user_state'] = "";
	   $redemtionData['tr_user_pin_code'] = $data['gloc_pin_code'];
	   $redemtionData['coupon_number'] = "";
	   $redemtionData['coupon_type'] = "";
   	   $redemtionData['coupon_vendor'] = "";   
	   $redemtionData['request_date'] = date("Y-m-d H:i:s");
       $redemtionData['l_status'] = 0;
	   $redemtionData['status_change_date'] = "0000-00-00 00:00:00";
	   $redemtionData['courier_details'] = "";
   	   $redemtionData['aadhaar_number'] = "";
	   $redemtionData['l_created_at'] = date("Y-m-d H:i:s");
       $redemtionData['modified_at'] = "0000-00-00 00:00:00";
	   
		$checkifrquestinprocess = $this->db->where(array('tr_user_id' => $userId, 'l_status' => 0))->count_all_results('tracek_loyalty_redemption');
		if($checkifrquestinprocess < 1) {
        if($this->db->insert('tracek_loyalty_redemption', $redemtionData)){
			
			// Consumer Log Data insert start
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['tracek_user_name'] = getTracekUserFullNameById($userId);
			$CALdata['tracek_user_id'] = $userId; 
			$CALdata['tracek_user_mobile'] = get_customer_mobile_no_id($userId); 
			$CALdata['customer_name'] = getUserFullNameById(getUserParentIDById($userId));
			$CALdata['customer_id'] = getUserParentIDById($userId); 
			$CALdata['unique_customer_code'] = getCustomerCodeById(getUserParentIDById($userId));
			$CALdata['product_name'] = "No Specific Product Involved"; 
			$CALdata['product_id'] = 0; 
			$CALdata['product_sku'] = "No Specific Product Involved"; 
			$CALdata['product_code'] = "No Specific Product Involved";
			$CALdata['gloc_latitude'] = $data['gloc_latitude'];
			$CALdata['gloc_longitude'] = $data['gloc_longitude'];
			$CALdata['gloc_city'] = $data['gloc_city'];
			$CALdata['gloc_pin_code'] = $data['gloc_pin_code'];
			$CALdata['tracek_user_activity_type'] = "Tacek Loyalty Redemption request";
			$CALdata['loyalty_rewards_points'] = 0;
			$CALdata['customer_loyalty_type'] = getCustomerLoyaltyTypeById(getUserParentIDById($userId));
			
			$this->db->insert('tracek_user_activity_log_table', $CALdata);
				// Consumer Log Data insert end
				
				
			$TRLR_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 20)->get()->row();
			$TRLR_billin_particular_name = $TRLR_result->billin_particular_name;
			$TRLR_billin_particular_slug = $TRLR_result->billin_particular_slug;
		
			$TRLRData['customer_id'] = getUserParentIDById($userId);
			//$TRLRData['consumer_id'] = getUserParentIDById($userId);
			$TRLRData['billing_particular_name'] = $TRLR_billin_particular_name;		
			$TRLRData['billing_particular_slug'] = $TRLR_billin_particular_slug;
			$TRLRData['trans_quantity'] = $data['tr_lr_points_redeemed']; 
			$TRLRData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRLRData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRLRData);
				
           // $redemptionId = $this->db->insert_id();
           // $this->db->update('consumers',$consumerData,['id'=>$userId]);
            //$this->Productmodel->saveLoylty('loyalty-redemption', $userId, ['user_id' => $userId,'redemption_id'=>$redemptionId]);
		//$mnv19_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 19)->get()->row();
		//$mnvtext19 = $mnv19_result->message_notification_value;
            Utils::response(['status'=>true,'message'=>'Thank you for your redemption request, after validation, your request will be processed in next 7-10 Working days.']);
			//Utils::response(['status'=>true,'message'=>$mnvtext19]);
        }else{
		//$mnv20_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 20)->get()->row();
		//$mnvtext20 = $mnv20_result->message_notification_value;
           Utils::response(['status'=>false,'message'=>'Failed to accept the redemption request.Please contact support team.']);
		//	Utils::response(['status'=>false,'message'=>$mnvtext20]);
        }
		}else{
		//$mnv21_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 21)->get()->row();
		//$mnvtext21 = $mnv21_result->message_notification_value;
            Utils::response(['status'=>false,'message'=>'Failed to accept the redemption request because your request is already in process.']);
			//Utils::response(['status'=>false,'message'=>$mnvtext21]);
        }
		}
		
		
		
	public function PrePurchaseScanReportExportExcel($customer_id, $mis_data_duration) {
		
				include('url_base_con_db_mysqli.php');
//mysql and db connection

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {  //error check
    die("Connection failed: " . $con->connect_error);
}
else
{

}

//$DB_TBLName = "scanned_products"; 
$filename = "PrePurchaseScanReport";  //your_file_name
$file_ending = "xls";   //file_extention

$current_date = date('Y-m-d');
switch ($mis_data_duration) {
  case "Day":
   $from_date = date('Y-m-d', strtotime('-1 days'));
    break;
  case "Week":
   $from_date = date('Y-m-d', strtotime('-7 days'));
    break;
  case "Month":
   $from_date = date('Y-m-d', strtotime('-30 days'));
    break;
  default:
   $from_date = date('Y-m-d', strtotime('-365 days'));
}


header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.$file_ending");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = ",";

//$sql="SELECT consumer_id, product_id, bar_code, scan_city, created_at FROM scanned_products where customer_id=$customer_id";
//$sql="SELECT t3.user_name, t2.product_name, t1.bar_code, t1.scan_city, t1.created_at FROM scanned_products t1, products	t2, consumers t3, WHERE	t1.product_id = t2.id AND t1.consumer_id = t3.id AND t1.customer_id = $customer_id";

$sql="SELECT P.product_name, COUNT(SP.scan_city), SP.scan_city
FROM scanned_products SP
INNER JOIN products P ON P.id = SP.product_id
INNER JOIN printed_barcode_qrcode PBC ON PBC.barcode_qr_code_no = SP.bar_code
WHERE SP.customer_id = $customer_id AND PBC.pack_level = 1 AND SP.code_scan_date BETWEEN '" . $from_date . "' AND '" . $current_date . "'
GROUP BY SP.scan_city
ORDER BY SP.code_scan_date DESC";

$resultt = $con->query($sql);
while ($property = mysqli_fetch_field($resultt)) { //fetch table field name
    //echo $property->name.",";
	//echo "Consumer ID".","."Product Bar Code"."\t"."Scan City"."\t"."Scan Date"."\t";
}
//print("<img src='http://innovigents.com/uploads/rwaprofilesettings/thumb/thumb_organic-india-logo-02_1585390274.jpg' alt='Organic India'>"."\n");
//$objDrawing = new PHPExcel_Worksheet_Drawing();
//$objDrawing->setPath('http://innovigents.com/uploads/rwaprofilesettings/thumb/thumb_organic-india-logo-02_1585390274.jpg');
$customer_name = getUserFullNameById($customer_id);	
print("Company Name - ".$customer_name."\n");
print("Report Name - Pre Purchase Scan Report"."\n");
print("Report Date - ".$current_date."\n");
print("Period - Last 1 ".$mis_data_duration."\n");
print(date()."\n");
echo "Product Name".","."Number of Scans".","."Scan City"."\t";
print("\n");    

		while($row = mysqli_fetch_row($resultt))  //fetch_table_data
		{
			$schema_insert = "";
			for($j=0; $j< mysqli_num_fields($resultt);$j++)
			{
				if(!isset($row[$j]))
					$schema_insert .= "NULL".$sep;
				elseif ($row[$j] != "")
					$schema_insert .= "$row[$j]".$sep;
				else
					$schema_insert .= "".$sep;
			}
			$schema_insert = str_replace($sep."$", "", $schema_insert);
			$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
			$schema_insert .= "\t";
			print(trim($schema_insert));
			print "\n";
		}
	
    }
	
	public function PostPurchaseScanReportExportExcel($customer_id, $mis_data_duration) {		
		include('url_base_con_db_mysqli.php');
		//mysql and db connection
		$con = new mysqli($servername, $username, $password, $dbname);
		if ($con->connect_error) {  //error check
			die("Connection failed: " . $con->connect_error);
		}
		else
		{

		}

		//$DB_TBLName = "scanned_products"; 
		$filename = "PostPurchaseScanReport";  //your_file_name
		$file_ending = "xls";   //file_extention

		// report configuration 

		$current_date = date('Y-m-d');
		switch ($mis_data_duration) {
		  case "Day":
		   $from_date = date('Y-m-d', strtotime('-1 days'));
			break;
		  case "Week":
		   $from_date = date('Y-m-d', strtotime('-7 days'));
			break;
		  case "Month":
		   $from_date = date('Y-m-d', strtotime('-30 days'));
			break;
		  default:
		   $from_date = date('Y-m-d', strtotime('-365 days'));
		}

		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.$file_ending");  
		header("Pragma: no-cache"); 
		header("Expires: 0");

		$sep = ",";

		//$sql="SELECT consumer_id, product_id, bar_code, scan_city, created_at FROM scanned_products where customer_id=$customer_id";
		//$sql="SELECT t3.user_name, t2.product_name, t1.bar_code, t1.scan_city, t1.created_at FROM scanned_products t1, products	t2, consumers t3, WHERE	t1.product_id = t2.id AND t1.consumer_id = t3.id AND t1.customer_id = $customer_id";

		$sql="SELECT P.product_name, COUNT(SP.scan_city), SP.scan_city
		FROM scanned_products SP
		INNER JOIN products P ON P.id = SP.product_id
		INNER JOIN printed_barcode_qrcode PBC ON PBC.barcode_qr_code_no = SP.bar_code
		WHERE SP.customer_id = $customer_id AND PBC.pack_level = 0 AND SP.code_scan_date BETWEEN '" . $from_date . "' AND '" . $current_date . "'
		GROUP BY SP.scan_city
		ORDER BY SP.code_scan_date DESC";

		$resultt = $con->query($sql);
		while ($property = mysqli_fetch_field($resultt)) { //fetch table field name
			//echo $property->name.",";
			//echo "Consumer ID".","."Product Bar Code".","."Scan City".","."Scan Date".",";
		}
		//print("<img src='http://innovigents.com/uploads/rwaprofilesettings/thumb/thumb_organic-india-logo-02_1585390274.jpg' alt='Organic India'>"."\n");
		//$objDrawing = new PHPExcel_Worksheet_Drawing();
		//$objDrawing->setPath('http://innovigents.com/uploads/rwaprofilesettings/thumb/thumb_organic-india-logo-02_1585390274.jpg');
		$customer_name = getUserFullNameById($customer_id);	
		print("Company Name - ".$customer_name."\n");
		print("Report Name - Post Purchase Scan Report"."\n");
		print("Report Date - ".$current_date."\n");
		print("Period - Last 1 ".$mis_data_duration."\n");
		print(date()."\n");
		echo "Product Name".","."Number of Scans".","."Scan City"."\t";
		print("\n");  
		while($row = mysqli_fetch_row($resultt))  //fetch_table_data
		{
			$schema_insert = "";
			for($j=0; $j< mysqli_num_fields($resultt);$j++)
			{
				if(!isset($row[$j]))
					$schema_insert .= "NULL".$sep;
				elseif ($row[$j] != "")
					$schema_insert .= "$row[$j]".$sep;
				else
					$schema_insert .= "".$sep;
			}
			$schema_insert = str_replace($sep."$", "", $schema_insert);
			$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
			$schema_insert .= ",";
			print(trim($schema_insert));
			print "\n";
		}	
    }
	
	
	public function OverallGlobalInventoryinHandReportExportExcel($customer_id, $mis_data_duration) {		
		include('url_base_con_db_mysqli.php');
		//mysql and db connection
		$con = new mysqli($servername, $username, $password, $dbname);
		if ($con->connect_error) {  //error check
			die("Connection failed: " . $con->connect_error);
		}
		else
		{

		}

		//$DB_TBLName = "scanned_products"; 
		$filename = "Overall Global Inventory in Hand Report";  //your_file_name
		$file_ending = "xls";   //file_extention

		// report configuration 

		$current_date = date('Y-m-d');
		switch ($mis_data_duration) {
		  case "Day":
		   $from_date = date('Y-m-d', strtotime('-1 days'));
			break;
		  case "Week":
		   $from_date = date('Y-m-d', strtotime('-7 days'));
			break;
		  case "Month":
		   $from_date = date('Y-m-d', strtotime('-30 days'));
			break;
		  default:
		   $from_date = date('Y-m-d', strtotime('-365 days'));
		}

		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=$filename.$file_ending");  
		header("Pragma: no-cache"); 
		header("Expires: 0");

		$sep = ",";

		//$sql="SELECT consumer_id, product_id, bar_code, scan_city, created_at FROM scanned_products where customer_id=$customer_id";
		//$sql="SELECT t3.user_name, t2.product_name, t1.bar_code, t1.scan_city, t1.created_at FROM scanned_products t1, products	t2, consumers t3, WHERE	t1.product_id = t2.id AND t1.consumer_id = t3.id AND t1.customer_id = $customer_id";

		$sql="SELECT OGIIH.update_date, OGIIH.created_by_id, BU.l_name, LM.location_name, P.product_name, P.product_sku, OGIIH.code_packaging_level, OGIIH.opening_inventory_quantity, OGIIH.stock_transfer_in_qty, OGIIH.stock_transfer_out_qty, OGIIH.direct_customer_sale_qty, OGIIH.product_returned_from_customer_qty, OGIIH.closing_inventory_quantity, OGIIH.closing_inventory_quantity
		FROM overall_global_inventory_in_hand OGIIH
		JOIN products P ON P.id = OGIIH.product_id
		JOIN backend_user BU ON BU.user_id = OGIIH.created_by_id
		JOIN location_master LM ON LM.location_id = OGIIH.location_id
		WHERE OGIIH.product_id = $customer_id AND OGIIH.inventory_date BETWEEN '" . $from_date . "' AND '" . $current_date . "'
		ORDER BY OGIIH.update_date
		ORDER BY OGIIH.location_id
		ORDER BY OGIIH.product_id
		ORDER BY OGIIH.created_by_id DESC";

		$resultt = $con->query($sql);
		while ($property = mysqli_fetch_field($resultt)) { //fetch table field name
			//echo $property->name.",";
			//echo "Consumer ID".","."Product Bar Code".","."Scan City".","."Scan Date".",";
		}
		//print("<img src='http://innovigents.com/uploads/rwaprofilesettings/thumb/thumb_organic-india-logo-02_1585390274.jpg' alt='Organic India'>"."\n");
		//$objDrawing = new PHPExcel_Worksheet_Drawing();
		//$objDrawing->setPath('http://innovigents.com/uploads/rwaprofilesettings/thumb/thumb_organic-india-logo-02_1585390274.jpg');
		$customer_name = getUserFullNameById($customer_id);	
		print("Company Name - ".$customer_name."\n");
		print("Report Name - Overall Global Inventory in Hand Report"."\n");
		print("Report Date - ".$current_date."\n");
		print("Period - Last 1 ".$mis_data_duration."\n");
		print(date()."\n");
		echo "Last Updated".","."Tracek User ID".","."Tracek User Name".","."Location Name".","."Product Name".","."Product SKU".","."Packaging Level".","."Opening Quantity for the Period Start Date".","."Stock Transfer-In Quantity".","."Stock Transfer-Out Quantity".","."Sales to Customers".","."Sales return from customer".","."Closing inventory for period end date".","."Balance for Level 0 Inventory"."\t";
		print("\n");  
		while($row = mysqli_fetch_row($resultt))  //fetch_table_data
		{
			$schema_insert = "";
			for($j=0; $j< mysqli_num_fields($resultt);$j++)
			{
				if(!isset($row[$j]))
					$schema_insert .= "NULL".$sep;
				elseif ($row[$j] != "")
					$schema_insert .= "$row[$j]".$sep;
				else
					$schema_insert .= "".$sep;
			}
			$schema_insert = str_replace($sep."$", "", $schema_insert);
			$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
			$schema_insert .= ",";
			print(trim($schema_insert));
			print "\n";
		}	
    }

	
    	public function AutoEmailMISCustomerSend() {
    		$current_date = date('Y-m-d');
    	$this->db->select('rc_id, customer_id, mis_report_name, mis_report_slug, active_status, auto_email_frequency, mis_data_duration, to_email_ids, email_subject, email_body');
        $this->db->where(array('active_status' => "Continue", 'auto_email_sent_date != ' => $current_date));
    	$this->db->order_by('rc_id', 'ASC');
        $query = $this->db->get('auto_email_mis_customer');
        $rows = $query->result_array();
    		
    	foreach($rows as $row){ // foreach start
    	$rc_id = $row['rc_id'];
    	$customer_id = $row['customer_id'];
    	$mis_report_name = $row['mis_report_name'];
    	$mis_report_slug = $row['mis_report_slug'];
    	$auto_email_frequency = $row['auto_email_frequency'];
    	$mis_data_duration = $row['mis_data_duration'];
    	$to_email_ids = $row['to_email_ids'];
    	$email_subject = $row['email_subject'];
    	$email_body = $row['email_body'];
		$last_auto_email_sent_date = $row['auto_email_sent_date'];
		$create_date = $row['create_date'];		
    	$customer_name = getUserFullNameById($customer_id);	
    	
    	if($mis_report_slug=="pre_purchase_scan_report"){
    		$report_download_link = "http://".$_SERVER['SERVER_NAME']."/api/customer/pre_purchase_scan_report_export_excel/".$customer_id."/".$mis_data_duration;
    	}elseif($mis_report_slug=="post_purchase_scan_report"){
    		$report_download_link = "http://".$_SERVER['SERVER_NAME']."/api/customer/post_purchase_scan_report_export_excel/".$customer_id."/".$mis_data_duration;
    	}else{}
										if($last_auto_email_sent_date=='0000-00-00'){
											$previous_date = $create_date;
										}else{
											$previous_date = $last_auto_email_sent_date;
										}
													$date1 = date_create($previous_date);
													$date2 = date_create(date('Y-m-d'));
													//difference between two dates
													$diff = date_diff($date1,$date2);
													//count days
													$day_count = ($diff->format("%a"))+1;
				
				switch ($auto_email_frequency) {
					  case "Daily":
					   $report_send_days = 1;
						break;
					  case "Weekly":
					   $report_send_days = 7;
						break;
					  case "Monthly":
					   $report_send_days = 30;
						break;
					  default:
					   $report_send_days = 365;
					}

				
    				if($day_count>=$report_send_days){
    				$updateData = array(
    			   'auto_email_sent_date'=>$current_date
    				);
    			$this->db->where('rc_id', $rc_id);
    			$this->db->update('auto_email_mis_customer', $updateData); 
    			
    			$this->AutoEmailMIS($mis_report_name, $to_email_ids, $email_subject, $email_body, $customer_name, $report_download_link);	
				
				$cbb1_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 11)->get()->row();
			$billin_particular_name = $cbb1_result->billin_particular_name;
			$billin_particular_slug = $cbb1_result->billin_particular_slug;
		
			$AutoEmailMISCBB['customer_id'] = $customer_id;
			$AutoEmailMISCBB['billing_particular_name'] = $billin_particular_name;		
			$AutoEmailMISCBB['billing_particular_slug'] = $billin_particular_slug;
			$AutoEmailMISCBB['trans_quantity'] = 1; 
			$AutoEmailMISCBB['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$AutoEmailMISCBB['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $AutoEmailMISCBB);
    				}
    		} // foreach end 
    }
	
	
	public function AutoEmailMIS($mis_report_name, $to_email_ids, $email_subject, $email_body, $customer_name, $report_download_link) 
		{
	   $subject = $email_subject;
        $body = "Hello <b>" . $customer_name . "</b>,
						<br><br>
						 " . $email_body . "
						<br>
						<br><a href='". $report_download_link ."'><img src='http://".$_SERVER['SERVER_NAME']."/assets/images/excel_xls.png' alt='". $mis_report_name ."'> ". $mis_report_name ."</a></b>.
 						<br><br><b>ISPL Team</b>";
        $mail_conf = array(
            'subject' => $email_subject,
            'to_email' => $to_email_ids,
            'cc' => 'sanjay@innovigent.in',
            'from_email' => 'admin@'.$_SERVER['SERVER_NAME'],
            'from_name' => 'ISPL',
            'body_part' => $body
        );
        if ($this->dmailer->mail_notify($mail_conf)) {
            return true;
        } return false; //echo redirect('accounts/create');
    }

	
	
	
	    public function AutoEmailBillingMISSuperAdminSend() {
    		$current_date = date('Y-m-d');
			/*
    	$this->db->select('rc_id, customer_id, mis_report_name, mis_report_slug, active_status, auto_email_frequency, mis_data_duration, to_email_ids, email_subject, email_body');
        $this->db->where(array('active_status' => "Continue", 'auto_email_sent_date != ' => $current_date));
    	$this->db->order_by('rc_id', 'ASC');
        $query = $this->db->get('auto_email_mis_customer');
        $rows = $query->result_array();
		*/
		$this->db->select('user_id, designation_id, status');
        $this->db->where(array('designation_id' => 2));
		$this->db->order_by('user_id', 'DESC');
        $query = $this->db->get('backend_user');
        $rows = $query->result_array();	
    		
    	foreach($rows as $row){ // foreach start
    	$customer_id = $row['user_id'];
    	$mis_data_duration = 31;
    	$customer_name = getUserFullNameById($customer_id);	
		$mis_report_name = "CustomerBillingReport ".$customer_name;
		$to_email_ids = "sanjayksir@gmail.com";
		$email_subject = "CustomerBillingReport ".$customer_name;
		$email_body = "Customer Billing Report is here for the Customer ".$customer_name;
		
    	//echo $customer_id;
		
		$report_download_link = "http://".$_SERVER['SERVER_NAME']."/api/customer/customer_billing_report_export_excel/".$customer_id."/".$mis_data_duration;
    	
    			$this->AutoEmailBillingMISToSUA($mis_report_name, $to_email_ids, $email_subject, $email_body, $customer_name, $report_download_link);	
				
    		} // foreach end 
    }
	
	public function AutoEmailBillingMISToSUA($mis_report_name, $to_email_ids, $email_subject, $email_body, $customer_name, $report_download_link) 
		{
	   $subject = $email_subject;
        $body = "Hello <b> ISPL Admin</b>,
						<br><br>
						 " . $email_body . "
						<br>
						<br><a href='". $report_download_link ."'><img src='http://".$_SERVER['SERVER_NAME']."/assets/images/excel_xls.png' alt='". $mis_report_name ."'> ". $mis_report_name ."</a></b>.
 						<br><br><b>ISPL Team</b>";
        $mail_conf = array(
            'subject' => $email_subject,
            'to_email' => $to_email_ids,
            'cc' => 'sanjaykumar7pm@gmail.com',
            'from_email' => 'admin@'.$_SERVER['SERVER_NAME'],
            'from_name' => 'ISPL',
            'body_part' => $body
        );
        if ($this->dmailer->mail_notify($mail_conf)) {
            return true;
        } return false; //echo redirect('accounts/create');
    }
	
	
		public function CustomerBillingReportExportExcel($customer_id, $mis_data_duration) {
		
				include('url_base_con_db_mysqli.php');
					//mysql and db connection

					$con = new mysqli($servername, $username, $password, $dbname);

					if ($con->connect_error) {  //error check
						die("Connection failed: " . $con->connect_error);
					}
					else
					{

					}

					//$DB_TBLName = "scanned_products"; 
					$filename = "CustomerBillingReport_".date('Y-m-d');  //your_file_name
					$file_ending = "xls";   //file_extention

					$current_date = date('Y-m-d');
					$from_date = date('Y-m-d', strtotime('-'.$mis_data_duration.' days'));
					/*
					switch ($mis_data_duration) {
					  case "Day":
					   $from_date = date('Y-m-d', strtotime('-1 days'));
						break;
					  case "Week":
					   $from_date = date('Y-m-d', strtotime('-7 days'));
						break;
					  case "Month":
					   $from_date = date('Y-m-d', strtotime('-30 days'));
						break;
					  default:
					   $from_date = date('Y-m-d', strtotime('-365 days'));
					}
					*/

					header("Content-Type: application/xls");    
					header("Content-Disposition: attachment; filename=$filename.$file_ending");  
					header("Pragma: no-cache"); 
					header("Expires: 0");

					$sep = ",";

					//$sql="SELECT consumer_id, product_id, bar_code, scan_city, created_at FROM scanned_products where customer_id=$customer_id";
					//$sql="SELECT t3.user_name, t2.product_name, t1.bar_code, t1.scan_city, t1.created_at FROM scanned_products t1, products	t2, consumers t3, WHERE	t1.product_id = t2.id AND t1.consumer_id = t3.id AND t1.customer_id = $customer_id";
					/*
					$sql="SELECT P.product_name, COUNT(SP.scan_city), SP.scan_city
					FROM scanned_products SP
					INNER JOIN products P ON P.id = SP.product_id
					INNER JOIN printed_barcode_qrcode PBC ON PBC.barcode_qr_code_no = SP.bar_code
					WHERE SP.customer_id = $customer_id AND PBC.pack_level = 1 AND SP.code_scan_date BETWEEN '" . $from_date . "' AND '" . $current_date . "'
					GROUP BY SP.scan_city
					ORDER BY SP.code_scan_date DESC";
					*/
					
					$sql="SELECT customer_id, billing_particular_name, billing_particular_slug, SUM(trans_quantity), trans_date_time
					FROM tr_customer_bill_book
					WHERE customer_id = $customer_id AND trans_date_time BETWEEN '" . $from_date . "' AND '" . $current_date . "'
					GROUP BY billing_particular_slug ORDER BY cbb_id DESC";
					

					$resultt = $con->query($sql);
					while ($property = mysqli_fetch_field($resultt)) { //fetch table field name
						//echo $property->name.",";
						//echo "Consumer ID".","."Product Bar Code"."\t"."Scan City"."\t"."Scan Date"."\t";
					}
					//print("<img src='http://innovigents.com/uploads/rwaprofilesettings/thumb/thumb_organic-india-logo-02_1585390274.jpg' alt='Organic India'>"."\n");
					//$objDrawing = new PHPExcel_Worksheet_Drawing();
					//$objDrawing->setPath('http://innovigents.com/uploads/rwaprofilesettings/thumb/thumb_organic-india-logo-02_1585390274.jpg');
					$customer_name = getUserFullNameById($customer_id);	
					print("Company Name - ".$customer_name."\n");
					print("Report Name - Customer Billing Report"."\n");
					print("Report Date - ".date('j M Y', strtotime($current_date))."\n");
					print("Period - Last ".$mis_data_duration." Days \n");
					print("Duration - From ".date('j M Y', strtotime($from_date))." to ".date('j M Y', strtotime($current_date))." \n");
					print(date()."\n");
					echo "Customer ID".","."Billing Particular Name".","."Billing Particular Slug".","."Transaction Quantity".","."Transaction Date"."\t";
					print("\n");    

							while($row = mysqli_fetch_row($resultt))  //fetch_table_data
							{
								$schema_insert = "";
								for($j=0; $j< mysqli_num_fields($resultt);$j++)
								{
									if(!isset($row[$j]))
										$schema_insert .= "NULL".$sep;
									elseif ($row[$j] != "")
										$schema_insert .= "$row[$j]".$sep;
									else
										$schema_insert .= "".$sep;
								}
								$schema_insert = str_replace($sep."$", "", $schema_insert);
								$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
								$schema_insert .= "\t";
								print(trim($schema_insert));
								print "\n";
		}
	
    }
	
   	public function BusinessPartnerScanCode(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'scanned_bar_code','label'=>'Barcode','rules' => 'required' ], 
			['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProductsInactive($data['scanned_bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     
		 $parent_customer_id = getUserParentIDById($userId);
		 $product_id = getProductIDbyProductCode($data['scanned_bar_code']);
		 
		 $designation_id = getDesignationIDByUserId($userId);
		 
		 $isBPLoyaltyAlreadyGiven = $this->Productmodel->isBPLoyaltyAlreadyGiven($data['scanned_bar_code']);
		//$isBPLoyaltyAlreadyGiven = true;
				
		$current_active_status = $result[0]['active_status'];	
		$scanned_bar_code_pck_level = $result[0]['pack_level'];	
		
			$BPSCDData['tracek_user_id'] = $userId; 
			$BPSCDData['parent_customer_id'] = $parent_customer_id;
			$BPSCDData['scanned_bar_code'] = $data['scanned_bar_code'];	
			$BPSCDData['product_id'] = $product_id;	
			$BPSCDData['scan_loc_latitude'] = $data['scan_loc_latitude'];	
			$BPSCDData['scan_loc_longitude'] = $data['scan_loc_longitude'];	
			$BPSCDData['scan_loc_city'] = $data['scan_loc_city'];	
			$BPSCDData['scan_loc_pin_code'] = $data['scan_loc_pin_code'];	
			$BPSCDData['scanned_bar_code_pck_level'] = $scanned_bar_code_pck_level;
			$BPSCDData['date_time'] = date("Y-m-d H:i:s",time()); 
			
			$this->db->insert('business_partner_scan_code_details', $BPSCDData);
			
        if(($scanned_bar_code_pck_level==0)&&($designation_id==18)&&($isBPLoyaltyAlreadyGiven!=true)){
			
			$transactionType = "business_partner_scan_code";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Business Partner Scanned Code";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
				$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['business_partner_scan_code' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['scanned_bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
				$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['business_partner_scan_code' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['scanned_bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
			$mnv70_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 70)->get()->row();
			$mnvtext70 = $mnv70_result->message_notification_value;
		
            $this->response(['status'=>true,'message'=>$mnvtext70,'code_pack_level'=>$scanned_bar_code_pck_level]);
        }else{
            $this->response(['status'=>false,'message'=>'You are not eligible to get the loyalty on this scan.'],200); 
        }
		/*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item already under process to add its children.'],200); 
        }
		
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item is already activated.'],200); 
        }
		*/
    }
	

   	public function ScanCodeasSoldOutDirectCustomerSale(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'request_id','label'=>'Request ID','rules' => 'trim'],
            ['field' =>'scan_sold_bar_code','label'=>'Product Barcode','rules' => 'required'], 
			['field' =>'invoice_number','label'=>'Product Barcode','rules' => 'trim'], 
			['field' =>'location_id','label'=>'Location ID','rules' => 'required' ], 
			['field' =>'tracek_user_role','label'=>'Tracek User Role','rules' => 'required'], 
			['field' =>'location_type','label'=>'Location Type','rules' => 'required' ], 
			['field' =>'location_name','label'=>'Location Name','rules' => 'required' ],
			['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProductsInactive($data['scan_sold_bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        }     
		 $parent_customer_id = getUserParentIDById($userId);
		 $product_id = getProductIDbyProductCode($data['scan_sold_bar_code']);
		 $location_id = $data['location_id'];
		 
		 $designation_id = getDesignationIDByUserId($userId);
		 $stock_status = "StockOuttoMarket";
		 $isProductCodeAlreadyInTheMkt = $this->Productmodel->isProductCodeAlreadyInTheMkt($data['scan_sold_bar_code'], $stock_status);
		//$isBPLoyaltyAlreadyGiven = true;

			$code_packaging_level = getProductCodeActicationLevelbyCode($data['scan_sold_bar_code']);
			
			
		$isProductExistsinLocationOverallGlobalInventoryInHand = $this->Productmodel->isProductExistsinLocationOverallGlobalInventoryInHand($product_id, $location_id, $code_packaging_level, $userId);
		
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
		$query_tr_ref_id = $this->db->select('tr_ref_id')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$tr_ref_id = $query_tr_ref_id->tr_ref_id;
				$data['tr_ref_id'] = $tr_ref_id;
			} else {
				$query_tr_ref_id = $this->db->select('id')->from('overall_global_inventory_in_hand')->where(array('product_id' => $product_id, 'location_id' => $location_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$trid1 = $query_tr_ref_id->id;
				$trid = $trid1;
				$tr_ref_id = $trid.$data['request_id'];
				$data['tr_ref_id'] = $tr_ref_id;			
			}
			
		$current_active_status = $result[0]['active_status'];	
		$scan_sold_bar_code_pck_level = $result[0]['pack_level'];	
		
			$SCASODCSData['tr_ref_id'] = $tr_ref_id; 
			$SCASODCSData['tracek_user_id'] = $userId; 
			$SCASODCSData['location_id'] = $data['location_id']; 
			$SCASODCSData['tracek_user_role'] = $data['tracek_user_role'];
			$SCASODCSData['parent_customer_id'] = $parent_customer_id;
			$SCASODCSData['scan_sold_bar_code'] = $data['scan_sold_bar_code'];	
			$SCASODCSData['stock_status'] = "StockOuttoMarket";	
			$SCASODCSData['product_id'] = $product_id;	
			$SCASODCSData['scan_loc_latitude'] = $data['scan_loc_latitude'];	
			$SCASODCSData['scan_loc_longitude'] = $data['scan_loc_longitude'];	
			$SCASODCSData['scan_loc_city'] = $data['scan_loc_city'];	
			$SCASODCSData['scan_loc_pin_code'] = $data['scan_loc_pin_code'];	
			$SCASODCSData['scan_sold_bar_code_pck_level'] = $scan_sold_bar_code_pck_level;
			$SCASODCSData['date_time'] = date("Y-m-d H:i:s",time()); 
			
        if($isProductCodeAlreadyInTheMkt!=true){
			
			$this->db->insert('scan_code_as_sold_out_direct_customer_sale', $SCASODCSData);
			
			
$ifProductCodeExistsInOverallGlobalInventoryClosing = $this->Productmodel->ifProductCodeExistsInOverallGlobalInventoryClosing($data['scan_sold_bar_code'], $location_id, $userId);			
		if($ifProductCodeExistsInOverallGlobalInventoryClosing==true){				
			$GlobalInventoryClosing_query = $this->db->select('stock_status')->from('overall_global_inventory_closing')->where(array('product_bar_code' => $data['scan_sold_bar_code'], 'location_id' => $location_id, 'created_by_id' => $userId))->get()->row();
			$stock_status = $GlobalInventoryClosing_query->stock_status;				
				$GlobalInventoryClosingData['stock_status'] = $stock_status-1;
				$this->db->where(array('product_bar_code' => $data['scan_sold_bar_code']));
				$this->db->update('overall_global_inventory_closing', $GlobalInventoryClosingData);		
			} else {				
			$OGICData['tr_ref_id'] = $tr_ref_id;
			$OGICData['trax_slug'] = "DirectCustomerSaleClosing"; 
			$OGICData['trax_name'] = "DirectCustomerSale Closing";
			$OGICData['request_id'] = $data['request_id'];
			$OGICData['plant_id'] = getAssignedPlantIDbyProductCode($data['scan_sold_bar_code']); 
			$OGICData['invoice_number'] = $data['invoice_number'];
			$OGICData['product_id'] = $result[0]['product_id']; 
			$OGICData['product_sku'] = $result[0]['product_sku']; 
			$OGICData['product_bar_code'] = $data['scan_sold_bar_code'];
			$OGICData['stock_status'] = -1;
			$OGICData['code_packaging_level'] = $code_packaging_level;
			$OGICData['transaction_type'] = "DirectCustomerSaleClosing";
			$OGICData['location_type'] = get_locations_type_by_id($location_id); 
			$OGICData['location_id'] = $data['location_id']; 			
			$OGICData['location_name'] = get_locations_name_by_id($data['location_id']);
			$OGICData['transfer_date'] = date('Y-m-d'); 
			$OGICData['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$OGICData['created_by_id'] = $userId; 
			$OGICData['parent_customer_id'] = $result[0]['created_by']; 
			$OGICData['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$OGICData['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$OGICData['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$OGICData['scan_loc_city'] = $data['scan_loc_city']; 
			$OGICData['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			
			$this->db->insert('overall_global_inventory_closing', $OGICData);
			}
			
			
			
			$transactionType = "code_as_sold_out";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Code Sold Out";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
			 
			
			//$location_id = getAssignedLocationIDByUserID($userId);
			$isProductExistsinLocation = $this->Productmodel->isProductExistsinLocation($product_id, $location_id, $code_packaging_level);
			//$isProductExistsinLocation != true;
			//$data2['plant_id'] = $data['plant_id'];
			//$data2['location_id'] = $location_id;
			//$data2['product_id'] = $product_id;
			//$data2['code_packaging_level'] = $code_packaging_level;
			$data2['update_date'] = date("Y-m-d H:i:s");
			if($isProductExistsinLocation==true){
				
				$Rdirect_customer_sale_qty = $this->db->select('direct_customer_sale_qty')->from('inventory_on_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level))->get()->row();
				$direct_customer_sale_qty = $Rdirect_customer_sale_qty->direct_customer_sale_qty;
				
				$data2['direct_customer_sale_qty'] = $direct_customer_sale_qty+1;
				$this->db->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level));
				$this->db->update('inventory_on_hand', $data2);
				
			} else {
				$data2['tr_ref_id'] = $tr_ref_id;
				$data2['stock_transfer_in_qty'] = 0;
				$data2['stock_transfer_out_qty'] = 0;
				$data2['direct_customer_sale_qty'] = 1;
				$this->db->insert('inventory_on_hand',$data2);
				
			}
			
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
				$Rdirect_customer_sale_qty = $this->db->select('direct_customer_sale_qty, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$direct_customer_sale_qty = $Rdirect_customer_sale_qty->direct_customer_sale_qty;
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				
				$data27['direct_customer_sale_qty'] = $direct_customer_sale_qty+1;
				$data27['closing_inventory_quantity'] = $closing_inventory_quantity-1;
				$this->db->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")));
				$this->db->update('overall_global_inventory_in_hand', $data27);				
			} else {
				$Rdirect_customer_sale_qty = $this->db->select('tr_ref_id, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId))->order_by('id', 'desc')->limit(1)->get()->row();
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				$prev_tr_ref_id = $Rdirect_customer_sale_qty->tr_ref_id;
				
				$data26['prev_tr_ref_id'] = $prev_tr_ref_id;
				$data26['tr_ref_id'] = $tr_ref_id;
				$data26['product_id'] = $product_id;
				$data26['location_id'] = $location_id;
				$data26['created_by_id'] = $userId;
				$data26['opening_inventory_quantity'] = $closing_inventory_quantity;
				$data26['product_returned_from_customer_qty'] = 0;
				$data26['stock_transfer_out_qty'] = 0;
				$data26['direct_customer_sale_qty'] = 1;
				$data26['stock_transfer_in_qty'] = 0;
				$data26['closing_inventory_quantity'] = $closing_inventory_quantity-1;
				$data26['code_packaging_level'] = $code_packaging_level;
				$data26['inventory_date'] = date("Y-m-d");;
				$data26['update_date'] = date("Y-m-d H:i:s");;
				$this->db->insert('overall_global_inventory_in_hand',$data26);				
			}
			
				
				$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['code_as_sold_out' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['scan_sold_bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
				$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['code_as_sold_out' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['scan_sold_bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
			$mnv71_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 71)->get()->row();
			$mnvtext71 = $mnv71_result->message_notification_value;
		
            $this->response(['status'=>true,'message'=>$mnvtext71,'code_pack_level'=>$scan_sold_bar_code_pck_level]);
        }else{
			$mnv72_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 72)->get()->row();
			$mnvtext72 = $mnv72_result->message_notification_value;
			
            //$this->response(['status'=>false,'message'=>'This code is already out for the market.'],200); 
			 $this->response(['status'=>false,'message'=>$mnvtext72],200); 
        }
		/*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item already under process to add its children.'],200); 
        }
		
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item is already activated.'],200); 
        }
		*/
    }
	
	
	
	 public function ProductReturnedFromCustomer(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'request_id','label'=>'Request ID','rules' => 'trim'],
			['field' =>'type_of_return','label'=>'Location ID' ],
			['field' =>'returning_product_condition','label'=>'Returning ProductC Condition' ],
			['field' =>'consumer_name','label'=>'Customer Name','rules' => 'trim' ],
			['field' =>'consumer_mobile_no','label'=>'Customer Name','rules' => 'trim' ],
            ['field' =>'return_product_bar_code','label'=>'Returning Product Barcode','rules' => 'trim' ], 
			['field' =>'return_receipt_number','label'=>'Product Barcode','rules' => 'trim' ], 
			['field' =>'location_id','label'=>'Location ID' ], 
			['field' =>'product_id','label'=>'Product ID','rules' => 'trim' ],
			['field' =>'product_return_description','label'=>'Product Return Description','rules' => 'trim' ],			
			['field' =>'returning_item_image','label'=>'Returning Item Image','rules' => 'trim' ],
			['field' =>'return_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'return_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'return_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'return_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
			$userId = $user['user_id'];          
			$parent_customer_id = getUserParentIDById($userId);
			$location_id = $data['location_id'];
			$stock_status = "ProductReturnedFromCustomer";
			$designation_id = getDesignationIDByUserId($userId);
			
		 if($data['return_product_bar_code']!=''){
			$result = $this->Productmodel->barcodeProductsInactive($data['return_product_bar_code'], $userId);
				 if(empty($result)){
					$this->response(['status'=>false,'message'=>'Record not found.'],200);
				}    
			$product_id = getProductIDbyProductCode($data['return_product_bar_code']);
			$code_packaging_level = $result[0]['pack_level'];
			
			$isProductExistsinLocationOverallGlobalInventoryInHand = $this->Productmodel->isProductExistsinLocationOverallGlobalInventoryInHand($product_id, $location_id, $code_packaging_level, $userId);
			
			$isProductCodeAlreadyReturned = $this->Productmodel->isProductCodeAlreadyReturned($data['return_product_bar_code'], $stock_status);
		 }else{
			$code_packaging_level = 1;
			$product_id = $data['product_id'];	
			$isProductExistsinLocationOverallGlobalInventoryInHand = true;
			$isProductCodeAlreadyReturned = false;			
		 }	 
		 
		//$isBPLoyaltyAlreadyGiven = true;
		//$code_packaging_level = $data['code_packaging_level'];
			
		$isProductExistsinLocationOverallGlobalInventoryInHand = $this->Productmodel->isProductExistsinLocationOverallGlobalInventoryInHand($product_id, $location_id, $code_packaging_level, $userId);
		
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
		$query_tr_ref_id = $this->db->select('tr_ref_id')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$tr_ref_id = $query_tr_ref_id->tr_ref_id;
				$SCASODCSData['tr_ref_id'] = $tr_ref_id;
			} else {
				$query_tr_ref_id = $this->db->select('id')->from('overall_global_inventory_in_hand')->where(array('product_id' => $product_id, 'location_id' => $location_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$trid1 = $query_tr_ref_id->id;
				$trid = $trid1;
				$tr_ref_id = $trid.$data['request_id'];
				$SCASODCSData['tr_ref_id'] = $tr_ref_id;			
			}
		
			$SCASODCSData['tracek_user_id'] = $userId;
			//$SCASODCSData['tr_ref_id'] = $data['tr_ref_id'];	
			$SCASODCSData['tracek_user_role'] = get_role_name_by_designation_id(getDesignationIDByUserId($userId));
			$SCASODCSData['parent_customer_id'] = $parent_customer_id;
			$SCASODCSData['location_id'] = $location_id; 
			$SCASODCSData['location_type'] = get_locations_type_by_id($location_id); 
			$SCASODCSData['location_name'] = get_locations_name_by_id($location_id); 
			$SCASODCSData['return_product_bar_code'] = $data['return_product_bar_code'];
			$SCASODCSData['return_receipt_number'] = $data['return_receipt_number'];
			$SCASODCSData['type_of_return'] = $data['type_of_return'];
			$SCASODCSData['returning_product_condition'] = $data['returning_product_condition'];
			$SCASODCSData['consumer_name'] = $data['consumer_name'];
			$SCASODCSData['consumer_mobile_no'] = $data['consumer_mobile_no'];			
			$SCASODCSData['stock_status'] = $stock_status;	
			$SCASODCSData['product_id'] = $product_id;
			$SCASODCSData['product_return_description'] = $data['product_return_description'];			
			$SCASODCSData['return_loc_latitude'] = $data['return_loc_latitude'];	
			$SCASODCSData['return_loc_longitude'] = $data['return_loc_longitude'];	
			$SCASODCSData['return_loc_city'] = $data['return_loc_city'];	
			$SCASODCSData['return_loc_pin_code'] = $data['return_loc_pin_code'];	
			$SCASODCSData['returned_product_bar_code_pck_level'] = $code_packaging_level;
			$SCASODCSData['date_time'] = date("Y-m-d H:i:s",time()); 
			
			
			 if(!empty($data['returning_item_image'])){
            $this->load->library('upload', [
                'upload_path'=>'./uploads/returned_products_images/',
                'allowed_types'=>'gif|jpg|JPEG|png|pdf',
                'max_size'=>'5120',
            ]);
            
            if(!$this->upload->do_upload('returning_item_image')){
                $this->response(['status'=>false,'message'=> Utils::errors($this->upload->display_errors())]);
            }
            $SCASODCSData['returning_item_image'] = 'uploads/returned_products_images/'.$this->upload->data('file_name');
        }
		
        if($isProductCodeAlreadyReturned!=true){
			
			$this->db->insert('product_returned_from_customer', $SCASODCSData);
			
			
	$ifProductCodeExistsInOverallGlobalInventoryClosing = $this->Productmodel->ifProductCodeExistsInOverallGlobalInventoryClosing($data['return_product_bar_code'], $location_id, $userId);
		if($ifProductCodeExistsInOverallGlobalInventoryClosing==true){				
				$GlobalInventoryClosing_query = $this->db->select('stock_status')->from('overall_global_inventory_closing')->where(array('product_bar_code' => $data['return_product_bar_code'], 'location_id' => $location_id, 'created_by_id' => $userId))->get()->row();
			$stock_status = $GlobalInventoryClosing_query->stock_status;				
				$GlobalInventoryClosingData['stock_status'] = $stock_status+1;
				$this->db->where(array('product_bar_code' => $data['return_product_bar_code']));
				$this->db->update('overall_global_inventory_closing', $GlobalInventoryClosingData);		
			} else {				
			$OGICData['tr_ref_id'] = $tr_ref_id;
			$OGICData['trax_slug'] = "ReturnedFromCustomerClosing"; 
			$OGICData['trax_name'] = "Returned From Customer Closing";
			$OGICData['request_id'] = $data['request_id'];
			$OGICData['plant_id'] = getAssignedPlantIDbyProductCode($data['return_product_bar_code']); 
			$OGICData['invoice_number'] = $data['invoice_number'];
			$OGICData['product_id'] = $product_id; 
			$OGICData['product_sku'] = get_product_sku_by_id($product_id); 
			$OGICData['product_bar_code'] = $data['return_product_bar_code'];
			$OGICData['stock_status'] = 1;
			$OGICData['code_packaging_level'] = $code_packaging_level;
			$OGICData['transaction_type'] = "ReturnedFromCustomeraClosing";
			$OGICData['location_type'] = get_locations_type_by_id($location_id); 
			$OGICData['location_id'] = $data['location_id']; 			
			$OGICData['location_name'] = get_locations_name_by_id($data['location_id']);
			$OGICData['transfer_date'] = date('Y-m-d'); 
			$OGICData['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$OGICData['created_by_id'] = $userId; 
			$OGICData['parent_customer_id'] = $parent_customer_id; 
			$OGICData['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$OGICData['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$OGICData['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$OGICData['scan_loc_city'] = $data['scan_loc_city']; 
			$OGICData['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			
			
			$this->db->insert('overall_global_inventory_closing', $OGICData);
			}
			
			
			$transactionType = "product_returned_from_customer";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "ProductReturnedFromCustomer";
			//$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
			 //$code_packaging_level = getProductCodeActicationLevelbyCode($data['return_product_bar_code']);
			
			//$location_id = getAssignedLocationIDByUserID($userId);
			//$isProductExistsinLocationOverallGlobalInventoryInHand = $this->Productmodel->isProductExistsinLocationOverallGlobalInventoryInHand($product_id, $location_id, $code_packaging_level);
			//$isProductExistsinLocation != true;
			//$data2['plant_id'] = $data['plant_id'];
			//$data2['location_id'] = $location_id;
			//$data2['product_id'] = $product_id;
			//$data2['code_packaging_level'] = $code_packaging_level;
			$data2['update_date'] = date("Y-m-d H:i:s");
			if($isProductExistsinLocationOverallGlobalInventoryInHand==true){
				
				$Rdirect_customer_sale_qty = $this->db->select('product_returned_from_customer_qty, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$product_returned_from_customer_qty = $Rdirect_customer_sale_qty->product_returned_from_customer_qty;
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				
				$data25['product_returned_from_customer_qty'] = $product_returned_from_customer_qty+1;
				$data25['closing_inventory_quantity'] = $closing_inventory_quantity+1;
				$this->db->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")));
				$this->db->update('overall_global_inventory_in_hand', $data25);
				
			} else {
				$Rdirect_customer_sale_qty = $this->db->select('tr_ref_id, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId))->order_by('id', 'desc')->limit(1)->get()->row();
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				$prev_tr_ref_id = $Rdirect_customer_sale_qty->tr_ref_id;
				
				$data24['prev_tr_ref_id'] = $prev_tr_ref_id;
				$data24['tr_ref_id'] = $tr_ref_id;
				$data24['plant_id'] = 11;
				$data24['product_id'] = $product_id;
				$data24['location_id'] = $location_id;
				$data24['created_by_id'] = $userId;
				$data24['opening_inventory_quantity'] = $closing_inventory_quantity+0;
				$data24['stock_transfer_in_qty'] = 0;
				$data24['stock_transfer_out_qty'] = 0;
				$data24['direct_customer_sale_qty'] = 0;
				$data24['product_returned_from_customer_qty'] = 1;
				$data24['closing_inventory_quantity'] = $closing_inventory_quantity+1;
				$data24['code_packaging_level'] = $code_packaging_level;
				$data24['inventory_date'] = date("Y-m-d");
				$data24['update_date'] = date("Y-m-d H:i:s");;
				$this->db->insert('overall_global_inventory_in_hand',$data24);
				
			}
				
				$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['product_returned_from_customer' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['return_product_bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
				$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['product_returned_from_customer' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['return_product_bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
			$mnv73_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 73)->get()->row();
			$mnvtext73 = $mnv73_result->message_notification_value;
		
            $this->response(['status'=>true,'message'=>$mnvtext73,'code_pack_level'=>$code_packaging_level]);
        }else{
			$mnv74_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 74)->get()->row();
			$mnvtext74 = $mnv74_result->message_notification_value;
			
            //$this->response(['status'=>false,'message'=>'This code is already Returned from the customer.'],200); 
			 $this->response(['status'=>false,'message'=>$mnvtext74],200); 
        }
		/*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item already under process to add its children.'],200); 
        }
		
		}else{
            $this->response(['status'=>false,'message'=>'System failed to change packaging level because this item is already activated.'],200); 
        }
		*/
   }


	
	
	// List all Products
	
	 public function all_products_list(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
		
		$user_id = $user['user_id'];
		$parent_user_id = get_parent_id($user_id);
		$all_products_list = get_list_all_products($parent_user_id);
		$empty_productD['id'] = 0;
		$empty_productD['created_by'] = $parent_user_id;
		$empty_productD['product_name'] = "Other";
		
			 $this->response(['status'=>true,'message'=>$all_products_list, 'empty_product'=>$empty_productD],200); 
			
    }
	
	// Update All Tracek Users Overall Global Inventory in Hand 
			/*
		public function UpdateAllTracekUsersOverallGlobalInventoryinHand(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'plant_id','label'=>'plant_id is required','rules' => 'required' ],
			['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
			['field' =>'invoice_number','label'=>'Invoice Number','rules' => 'required' ],
			['field' =>'transaction_type','label'=>'Transaction Type','rules' => 'required' ],
			['field' =>'location_type','label'=>'Location Type','rules' => 'required' ],
			['field' =>'location_id','label'=>'Location id','rules' => 'required' ],
			['field' =>'location_name','label'=>'Location Name','rules' => 'required' ],
			['field' =>'created_by_id','label'=>'Created By','rules' => 'required' ],
			['field' =>'transfer_out_date','label'=>'Date is not given','rules' => 'required' ],
            ['field' =>'scan_loc_latitude','label'=>'Scan Location Latitude','rules' => 'trim'],
            ['field' =>'scan_loc_longitude','label'=>'Scan Location Longitude','rules' => 'trim'],
            ['field' =>'scan_loc_city','label'=>'Scan Location City','rules' => 'trim'],
            ['field' =>'scan_loc_pin_code','label'=>'Scan Location PIN Code','rules' => 'trim']
            
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        } 
				$data['request_id'] = rand(1111111111,9999999999); 
				$data['created_date_time'] = date("Y-m-d H:i:s");
				
		$data['product_id'] = $result[0]['product_id'];
		$data['code_packaging_level'] = $result[0]['pack_level'];
		
			$product_id = $data['product_id']; 
			$location_id = $data['location_id'];
			$code_packaging_level = $data['code_packaging_level'];
			
		$isProductExistsinLocationOverallGlobalInventoryInHand = $this->Productmodel->isProductExistsinLocationOverallGlobalInventoryInHand($product_id, $location_id, $code_packaging_level, $userId);
		
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
		$query_tr_ref_id = $this->db->select('tr_ref_id')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$tr_ref_id = $query_tr_ref_id->tr_ref_id;
				$data['tr_ref_id'] = $tr_ref_id;
			} else {
				$todaytr_ref_id = date("Ymd");
				$randtr_ref_id = strtoupper(substr(uniqid(sha1(time())),0,4));
				$tr_ref_id = $todaytr_ref_id . $randtr_ref_id;
				$data['tr_ref_id'] = $tr_ref_id;			
			}
		 $isItemAlreadyExistsStockIn = $this->Productmodel->isItemAlreadyExistsStockIn($data['bar_code']);
		
		 $isitMaster = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
		 
		if($isitMaster>0){
		//if($isItemAlreadyExistsStockIn==true){
		    if($this->db->insert('receipt_stock_transfer_in', $data)){
				
				$designation_id = getDesignationIDByUserId($userId);
						$functionality_name_slug = "receipt_at_warehouse_or_plant";
						$customer_id = $result[0]['created_by'];
						$loyalty_points = getLoyaltyPointsByIDNLID($designation_id, $functionality_name_slug, $customer_id);
						if($loyalty_points >=1){
							$is_loyalty_available = "Yes";
						}else{
							$is_loyalty_available = "No";
						}
					
					
			$tlogdata['trax_slug'] = "ReceiptStockTransferIn"; 
			$tlogdata['trax_name'] = "Stock Transfer In";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$tlogdata['scan_loc_city'] = $data['scan_loc_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['bar_code']);
			$tlogdata['is_loyalty_available'] = $is_loyalty_available;
			$tlogdata['loyalty_points'] = $loyalty_points;
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			$ifProductCodeExistsInOverallGlobalInventoryClosing = $this->Productmodel->ifProductCodeExistsInOverallGlobalInventoryClosing($data['bar_code'], $location_id, $userId);
		
		if($ifProductCodeExistsInOverallGlobalInventoryClosing==true){				
			$GlobalInventoryClosing_query = $this->db->select('stock_status')->from('overall_global_inventory_closing')->where(array('product_bar_code' => $data['bar_code'], 'location_id' => $location_id, 'created_by_id' => $userId))->get()->row();
				$stock_status = $GlobalInventoryClosing_query->stock_status;				
				$GlobalInventoryClosingData['stock_status'] = $stock_status+1;
				$this->db->where(array('product_bar_code' => $data['bar_code']));
				$this->db->update('overall_global_inventory_closing', $GlobalInventoryClosingData);		
			} else {				
			$OGICData['tr_ref_id'] = $tr_ref_id;
			$OGICData['trax_slug'] = "ReceiptStockTransferInClosing"; 
			$OGICData['trax_name'] = "Stock Transfer In Closing";
			$OGICData['request_id'] = $data['request_id'];
			$OGICData['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$OGICData['invoice_number'] = $data['invoice_number'];
			$OGICData['product_id'] = $result[0]['product_id']; 
			$OGICData['product_sku'] = $result[0]['product_sku']; 
			$OGICData['product_bar_code'] = $data['bar_code'];
			$OGICData['stock_status'] = 1;
			$OGICData['code_packaging_level'] = $code_packaging_level;
			$OGICData['transaction_type'] = "ReceiptStockTransferInClosing";
			$OGICData['location_type'] = get_locations_type_by_id($location_id); 
			$OGICData['location_id'] = $data['location_id']; 			
			$OGICData['location_name'] = get_locations_name_by_id($data['location_id']);
			$OGICData['transfer_date'] = date('Y-m-d'); 
			$OGICData['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$OGICData['created_by_id'] = $userId; 
			$OGICData['parent_customer_id'] = $result[0]['created_by']; 
			$OGICData['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$OGICData['scan_loc_latitude'] = $data['scan_loc_latitude']; 
			$OGICData['scan_loc_longitude'] = $data['scan_loc_longitude']; 
			$OGICData['scan_loc_city'] = $data['scan_loc_city']; 
			$OGICData['scan_loc_pin_code'] = $data['scan_loc_pin_code']; 
			
			$this->db->insert('overall_global_inventory_closing', $OGICData);
			}
			
			
			
			$isProductExistsinLocation = $this->Productmodel->isProductExistsinLocation($product_id, $location_id, $code_packaging_level);
			//$isProductExistsinLocation != true;
			
			$data2['plant_id'] = $data['plant_id'];
			$data2['location_id'] = $data['location_id'];
			$data2['product_id'] = $data['product_id'];
			$data2['code_packaging_level'] = $data['code_packaging_level'];
			$data2['created_by_id'] = $userId;
			$data2['update_date'] = date("Y-m-d H:i:s");
			if($isProductExistsinLocation==true){
				
				$Rstock_transfer_in_qty = $this->db->select('stock_transfer_in_qty')->from('inventory_on_hand')->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']))->get()->row();
				$stock_transfer_in_qty = $Rstock_transfer_in_qty->stock_transfer_in_qty;
				
				$data2['stock_transfer_in_qty'] = $stock_transfer_in_qty+1;
				$this->db->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']));
				$this->db->update('inventory_on_hand', $data2);
				
			} else {
				$data2['tr_ref_id'] = $tr_ref_id;
				$data2['stock_transfer_out_qty'] = 0;
				$data2['stock_transfer_in_qty'] = 1;
				$this->db->insert('inventory_on_hand',$data2);
				
			}
			
			
			
			
	
		if($isProductExistsinLocationOverallGlobalInventoryInHand==true){				
				$Rdirect_customer_sale_qty = $this->db->select('stock_transfer_in_qty, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")))->get()->row();
				$stock_transfer_in_qty = $Rdirect_customer_sale_qty->stock_transfer_in_qty;
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				//$opening_inventory_quantity = $Rdirect_customer_sale_qty->opening_inventory_quantity;
				
				$data2['stock_transfer_in_qty'] = $stock_transfer_in_qty+1;
				$data2['closing_inventory_quantity'] = $closing_inventory_quantity+1;
				$this->db->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId, 'inventory_date' => date("Y-m-d")));
				$this->db->update('overall_global_inventory_in_hand', $data2);				
			} else {
				$Rdirect_customer_sale_qty = $this->db->select('tr_ref_id, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $userId))->order_by('id', 'desc')->limit(1)->get()->row();
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				$prev_tr_ref_id = $Rdirect_customer_sale_qty->tr_ref_id;
				
				$data2['prev_tr_ref_id'] = $prev_tr_ref_id;
				$data2['tr_ref_id'] = $tr_ref_id;
				$data2['plant_id'] = 11;
				$data2['product_id'] = $product_id;
				$data2['location_id'] = $location_id;
				$data2['created_by_id'] = $userId;
				$data2['opening_inventory_quantity'] = $closing_inventory_quantity+0;				
				$data2['stock_transfer_out_qty'] = 0;
				$data2['direct_customer_sale_qty'] = 0;
				$data2['stock_transfer_in_qty'] = 1;
				$data2['product_returned_from_customer_qty'] = 0;
				$data2['closing_inventory_quantity'] = $closing_inventory_quantity + 1;
				$data2['code_packaging_level'] = $code_packaging_level;
				$data2['inventory_date'] = date("Y-m-d");
				$data2['update_date'] = date("Y-m-d H:i:s");
				$this->db->insert('overall_global_inventory_in_hand',$data2);				
			}
			
			$transactionType = "receipt_at_warehouse_or_plant";	
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$product_name = get_products_name_by_id($product_id);
			$transactionTypeName = "Receipt at Warehouse/Plant (Stock Transfer-In)";
			$parent_customer_id = get_customer_id_by_product_id($product_id);
			$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($parent_customer_id);	
			
	$this->Productmodel->saveCustomerLoyaltyPassbookProductScan($transactionType, ['transfer_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);
	
	$this->Productmodel->saveCustomerLoyaltyPointsProductScan($transactionType, ['add_physical_inventory_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => $data['bar_code']], $parent_customer_id, $product_id, $userId, $transactionTypeName, 'Loyalty', $customer_loyalty_type);	
	
            $this->response(['status'=>true,'message'=>'Receipt Stock Transfer-In has been added.','stock_data'=>$data,'code_data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to Dispatch Stock Transfer-In.'],200); 
        } /*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Stock Transfer-In because this item already exists.'],200); 
        } */ /*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Stock Transfer-In because only master carton can be Stock Transfer-In.'],200); 
        }
    }
	*/
	
	
	public function UpdateAllTracekUsersOverallGlobalInventoryinHand(){
       
        $data = $this->getInput();
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
		$dmmid = 1;
        $resultCustomers = $this->Productmodel->getListAllCustomers($dmmid);
        //echo "<pre>";print_r($result);die;
		foreach($resultCustomers as $ListAllCustomers){ 
		$costomer_id = $ListAllCustomers['user_id'] . "\n"; 
		$list_get_all_tracek_users = get_all_users($ListAllCustomers['user_id']);
		
		foreach($list_get_all_tracek_users as $all_tracek_users){ 
		
		$tracek_user_id = $all_tracek_users['user_id'] . "\n"; 
		$location_id = getAssignedLocationIDByUserID($tracek_user_id);
		$list_get_all_products = get_list_all_products($ListAllCustomers['user_id']);	
			
		foreach($list_get_all_products as $all_products){ 		
		
		$product_id = $all_products['id'];
		$MaxPackagingLevelProductPack = getMaxPackagingLevelProductByProductID($product_id);
		//$code_packaging_level = 1;
		//echo $all_products['id'] . "\n"; 
		//echo $all_products['product_name'] . "\n"; 
		//echo $location_id . "- location_id - \n"; 
		//echo $product_id . "- product_id - \n"; 
		
		for ($code_packaging_level = 1; $code_packaging_level <= $MaxPackagingLevelProductPack; $code_packaging_level++) {
		$isProductExistsinLocationOverallGlobalInventoryInHandAnyDate = $this->Productmodel->isProductExistsinLocationOverallGlobalInventoryInHandAnyDate($product_id, $location_id, $code_packaging_level, $tracek_user_id);		
		
				$todaytr_ref_id = date("YmdHis");
				//$randtr_ref_id = strtoupper(substr(uniqid(sha1(time())),0,4));
				$randtr_ref_id = mt_rand(100000,999999);
				$tr_ref_id = $todaytr_ref_id . $randtr_ref_id;
			
		
		if($isProductExistsinLocationOverallGlobalInventoryInHandAnyDate==true){	
			/*
				$Rdirect_customer_sale_qty = $this->db->select('opening_inventory_quantity, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $tracek_user_id, 'inventory_date' => date("Y-m-d")))->get()->row();
				$stock_transfer_in_qty = $Rdirect_customer_sale_qty->stock_transfer_in_qty;
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				$opening_inventory_quantity = $Rdirect_customer_sale_qty->opening_inventory_quantity;
				
				$data2['opening_inventory_quantity'] = $opening_inventory_quantity;
				$data2['closing_inventory_quantity'] = $closing_inventory_quantity;
				$this->db->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $tracek_user_id, 'inventory_date' => date("Y-m-d")));
				$this->db->update('overall_global_inventory_in_hand', $data2);	*/		
				$Rdirect_customer_sale_qty = $this->db->select('tr_ref_id, opening_inventory_quantity, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $tracek_user_id))->order_by('id', 'desc')->limit(1)->get()->row();
				$opening_inventory_quantity = $Rdirect_customer_sale_qty->opening_inventory_quantity;
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;				
				$prev_tr_ref_id = $Rdirect_customer_sale_qty->tr_ref_id;
				
				$data23['prev_tr_ref_id'] = $prev_tr_ref_id;
				$data23['tr_ref_id'] = $tr_ref_id;
				$data23['plant_id'] = 11;
				$data23['product_id'] = $product_id;
				$data23['location_id'] = $location_id;
				$data23['created_by_id'] = $tracek_user_id;
				$data23['opening_inventory_quantity'] = $closing_inventory_quantity + 0;				
				$data23['stock_transfer_out_qty'] = 0;
				$data23['direct_customer_sale_qty'] = 0;
				$data23['stock_transfer_in_qty'] = 0;
				$data23['product_returned_from_customer_qty'] = 0;
				$data23['closing_inventory_quantity'] = $closing_inventory_quantity + 0;
				$data23['code_packaging_level'] = $code_packaging_level;
				$data23['inventory_date'] = date("Y-m-d");
				$data23['update_date'] = date("Y-m-d H:i:s");
				$this->db->insert('overall_global_inventory_in_hand',$data23);	
			} else {
				
				$Rdirect_customer_sale_qty = $this->db->select('tr_ref_id, closing_inventory_quantity')->from('overall_global_inventory_in_hand')->where(array('location_id' => $location_id, 'product_id' => $product_id, 'code_packaging_level' => $code_packaging_level, 'created_by_id' => $tracek_user_id))->order_by('id', 'desc')->limit(1)->get()->row();
				$closing_inventory_quantity = $Rdirect_customer_sale_qty->closing_inventory_quantity;
				$prev_tr_ref_id = $Rdirect_customer_sale_qty->tr_ref_id;
				
				$data22['prev_tr_ref_id'] = $prev_tr_ref_id;
				$data22['tr_ref_id'] = $tr_ref_id;
				$data22['plant_id'] = 11;
				$data22['product_id'] = $product_id;
				$data22['location_id'] = $location_id;
				$data22['created_by_id'] = $tracek_user_id;
				$data22['opening_inventory_quantity'] = 0;				
				$data22['stock_transfer_out_qty'] = 0;
				$data22['direct_customer_sale_qty'] = 0;
				$data22['stock_transfer_in_qty'] = 0;
				$data22['product_returned_from_customer_qty'] = 0;
				$data22['closing_inventory_quantity'] = 0;
				$data22['code_packaging_level'] = $code_packaging_level;
				$data22['inventory_date'] = date("Y-m-d");
				$data22['update_date'] = date("Y-m-d H:i:s");
				$this->db->insert('overall_global_inventory_in_hand',$data22);				
			}
			
			//$this->response(['status'=>true,'message'=>'Overall Global Inventory in Hand Auto Updated','data'=>$tr_ref_id],200);
		}
		}
		}
		/*
        if(!empty($ListAllCustomers)){
            $this->response(['status'=>true,'message'=>'List of products','data'=>$ListAllCustomers],200);
        }else{
            $this->response(['status'=>true,'message'=>'There is no record.'],200);
        }
			*/
		} 		
    }
	
	
	
	
	// List Packaging and Ship out Order request at Packaging Supervisor API Strats 
	  public function ListPackagingandShipOutOrderRequestAtPackagingSupervisor(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
       // $result = $this->Productmodel->productsByUser($user['user_id'],$data['limit'],$data['offset']);
		$result = $this->Productmodel->ListPackagingandShipOutOrderRequestAtPackagingSupervisor(get_parent_id($user['user_id']),$data['limit'],$data['offset']);
        //echo "<pre>";print_r($result);die;
        if(!empty($result)){
            $this->response(['status'=>true,'message'=>'List Packaging and Ship out Order request at Packaging Supervisor','data'=>$result],200);
        }else{
            $this->response(['status'=>true,'message'=>'There is no record.'],200);
        }        
    }
	
	// List Packaging and Ship out Order request at Packaging Supervisor API Ends
	
	
	// Assign Packaging and Ship out Order request to Packer starts 	
	public function AssignPackagingandShipOutOrderRequestToPacker($psoo_token_id, $tracek_packer_id){ 		
		$user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
       
        $data = $this->getInput();
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
		
        //echo "<pre>";print_r($result);die;		
		$userId = $user['user_id'];        
		$tracek_packer_name = getTracekUserFullNameById($tracek_packer_id);		 
		//$this->db->set('active_status',1);
        $this->db->set('tracek_packer_id', $tracek_packer_id);		
        $this->db->set('tracek_packer_name',$tracek_packer_name);
        $this->db->set('tracek_packer_assigned_byid', $userId);
        $this->db->set('tracek_packer_assigned_datetime', (new DateTime('now'))->format('Y-m-d H:i:s'));
		//$this->db->set('activation_date', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->where('psoo_token_id', $psoo_token_id);		
        if($this->db->update('packaging_ship_out_order')){
		
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'Order Assigned to packer '.$tracek_packer_name,'unique_token_id'=>$psoo_token_id]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }		
    }	
	// Assign Packaging and Ship out Order request to Packer ends 
	
	
		// Packaging Order for ship out Starts
		public function PackagingOrderForShipOut(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'psoo_id','label'=>'Packaging Ship Out Order','rules' => 'required' ],
			['field' =>'poso_master_product_code','label'=>'Packaging Master Product Barcode','rules' => 'required' ],
			['field' =>'poso_product_code','label'=>'Packaging Product Barcode','rules' => 'required' ],
			['field' =>'poso_latitude','label'=>'Packaging location latitude','rules' => 'required' ],
			['field' =>'poso_longitude','label'=>'Packaging location longitude','rules' => 'required' ],
			['field' =>'poso_city','label'=>'Packaging location city','rules' => 'required' ],
			['field' =>'poso_pin_code','label'=>'Packaging location pin code','rules' => 'required' ]
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['poso_product_code'], $userId);
		 if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        } 
		
		$resultMPC = $this->Productmodel->barcodeProducts($data['poso_master_product_code'], $userId);
		 if(empty($resultMPC)){
            $this->response(['status'=>false,'message'=>'Record not found.'],200);
        } 
		
		$resultMPCLevel1Only = $this->Productmodel->barcodeProductsLevel1Only($data['poso_master_product_code'], $userId);
		 if(empty($resultMPCLevel1Only)){
            $this->response(['status'=>false,'message'=>'This is not a master code.'],200);
        }
		
				//$data['request_id'] = rand(1111111111,9999999999);
				
		/*		
		$data['product_id'] = $result[0]['product_id'];	
		$data['code_packaging_level'] = $result[0]['pack_level'];			
		 $isItemAlreadyExists = $this->Productmodel->isItemAlreadyExists($data['poso_product_code']);
		 
		  $isitMaster = $this->db->where('parent_bar_code',$data['poso_product_code'])->from("packaging_codes_pcr")->count_all_results();
		 */
		//if($isitMaster>0){
		//if($isItemAlreadyExists==true){
			
	$psoo_query = $this->db->select('customer_id, tracek_user_id, tracek_user_name, tracek_packer_id, tracek_packer_name, tracek_packer_assigned_byid, tracek_packer_assigned_datetime, product_id, product_name, psoo_token_id, psoo_invoice_number, psoo_product_origin_type, microsite_url, psoo_bin_number, psoo_packed_quantity, psoo_quantity, psoo_codes')->from('packaging_ship_out_order')->where(array('psoo_id' => $data['psoo_id']))->get()->row();
				$customer_id = $psoo_query->customer_id;
				$tracek_user_id = $psoo_query->tracek_user_id;				
				$tracek_user_name = $psoo_query->tracek_user_name;
				//$tracek_packer_id = $psoo_query->tracek_packer_id;
				//$tracek_packer_name = $psoo_query->tracek_packer_name;
				$tracek_packer_assigned_byid = $psoo_query->tracek_packer_assigned_byid;
				$tracek_packer_assigned_datetime = $psoo_query->tracek_packer_assigned_datetime;
				$product_id = $psoo_query->product_id;
				$product_name = $psoo_query->product_name;
				$poso_token_id = $psoo_query->psoo_token_id;
				$poso_invoice_number = $psoo_query->psoo_invoice_number;
				$poso_product_origin_type = $psoo_query->psoo_product_origin_type;
				$microsite_url = $psoo_query->microsite_url;
				$poso_bin_number = $psoo_query->psoo_bin_number;
				
				$psoo_packed_quantity = $psoo_query->psoo_packed_quantity;
				$psoo_quantity = $psoo_query->psoo_quantity;
				$psoo_codes = $psoo_query->psoo_codes;
			
			$data['customer_id'] = $customer_id;
			$data['tracek_user_id'] = $tracek_user_id;
			$data['tracek_user_name'] = $tracek_user_name;
			$data['tracek_packer_id'] = $userId;
			$data['tracek_packer_name'] = getTracekUserFullNameById($userId);
			$data['tracek_packer_assigned_byid'] = $tracek_packer_assigned_byid;			
			$data['tracek_packer_assigned_datetime'] = $tracek_packer_assigned_datetime;
			$data['product_id'] = $product_id;
			$data['product_name'] = $product_name;
			$data['poso_token_id'] = $poso_token_id;
			$data['poso_invoice_number'] = $poso_invoice_number;
			$data['poso_product_origin_type'] = $poso_product_origin_type;
			$data['poso_microsite_url'] = $microsite_url;
			$data['poso_bin_number'] = $poso_bin_number;
			$data['poso_ip_address'] = $this->input->ip_address();
			$data['poso_date_time'] = date("Y-m-d H:i:s");
			
		    if($this->db->insert('packaging_order_for_ship_out', $data)){
				
			if($psoo_packed_quantity==0){	
				$this->db->set('psoo_packing_start_date_time', date("Y-m-d H:i:s"));
				$this->db->set('psoo_master_product_code', $data['poso_master_product_code']);
				}
				if(($psoo_packed_quantity+1)==$psoo_quantity){
				$this->db->set('psoo_packing_end_date_time', date("Y-m-d H:i:s"));
				}
			$this->db->set('psoo_codes', ($psoo_codes.",".$data['poso_product_code']));	
			$this->db->set('psoo_packed_quantity', ($psoo_packed_quantity+1));
			$this->db->where('psoo_id', $data['psoo_id']);
			$this->db->update('packaging_ship_out_order');				
					
				
			$tlogdata['trax_slug'] = "PackagingOrderForShipOut"; 
			$tlogdata['trax_name'] = "Packaging Order For Ship Out";
			$tlogdata['parent_customer_id'] = $customer_id; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['agent_customer_role'] = getRoleNameById(getDesignationIDByUserId($userId));
			$tlogdata['product_id'] = $product_id; 
			$tlogdata['product_code'] = $data['poso_product_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['poso_product_code']); 
			$tlogdata['location_id'] = ""; 
			$tlogdata['product_sku'] = ""; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			$tlogdata['scan_loc_latitude'] = $data['poso_latitude']; 
			$tlogdata['scan_loc_longitude'] = $data['poso_longitude']; 
			$tlogdata['scan_loc_city'] = $data['poso_city']; 
			$tlogdata['scan_loc_pin_code'] = $data['poso_pin_code']; 
			$tlogdata['scanned_code_level'] = getProductCodeActicationLevelbyCode($data['poso_product_code']);
			$tlogdata['is_loyalty_available'] = 0;
			$tlogdata['loyalty_points'] = 0;	
			
			$this->db->insert('list_transactions_table', $tlogdata);
	
            $this->response(['status'=>true,'message'=>'Packaging Order For Ship Out done.','packaging_done'=>$data]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to Ship Out Order.'],200); 
        } /*
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Out-Stock because this item already exists.'],200); 
        } 
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add this item Ship Out Order because only master carton can be Dispatch.'],200); 
        }*/
    }
		
	// Packaging Order for ship out ends 
	
		// List Packers at Packaging Supervisor API Strats 
	  public function ListPackersAtPackagingSupervisor(){
        $user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
       // $result = $this->Productmodel->productsByUser($user['user_id'],$data['limit'],$data['offset']);
		$result = getAllPackerUser(get_parent_id($user['user_id']));
        //echo "<pre>";print_r($result);die;
        if(!empty($result)){
            $this->response(['status'=>true,'message'=>'List Packers at Packaging Supervisor','data'=>$result],200);
        }else{
            $this->response(['status'=>true,'message'=>'There is no record.'],200);
        }        
    }
	
	// List Packers at Packaging Supervisor API Ends
	
	
		// Initiate Short Closure By Packer starts 	
	public function InitiateShortClosureByPacker($psoo_id){ 		
		$user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
       
        $data = $this->getInput();
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
				
        //echo "<pre>";print_r($result);die;		
		$userId = $user['user_id'];        
		$tracek_packer_name = getTracekUserFullNameById($userId);		 
		//$this->db->set('active_status',1);
        // $this->db->set('tracek_packer_name',$tracek_packer_name);
        //$this->db->set('tracek_packer_assigned_byid', $userId);
        $this->db->set('short_closure', "Short Closure Requested");		
        //$this->db->set('short_closure_datetime', (new DateTime('now'))->format('Y-m-d H:i:s'));
		//$this->db->set('activation_date', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->where('psoo_id', $psoo_id);		
        if($this->db->update('packaging_ship_out_order')){		
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'Short Closure Requested by packer '.$tracek_packer_name,'psoo_id'=>$psoo_id]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }		
    }	
	// Initiate Short Closure By Packer ends 

	
 		// Response Short Closure Request By Packaging Supervisor starts 	
	public function ResponseShortClosureRequestByPSupervisor($psoo_id, $requestresponse){ 		
		$user = $this->customerAuth();
        if(empty($user)){
            $this->response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
       
        $data = $this->getInput();
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
				
        //echo "<pre>";print_r($result);die;		
		$userId = $user['user_id'];        
		$tracek_packer_name = getTracekUserFullNameById($userId);		 
		//$this->db->set('active_status',1);
        // $this->db->set('tracek_packer_name',$tracek_packer_name);
        //$this->db->set('tracek_packer_assigned_byid', $userId);
        $this->db->set('short_closure', $requestresponse);		
        //$this->db->set('short_closure_datetime', (new DateTime('now'))->format('Y-m-d H:i:s'));
		//$this->db->set('activation_date', (new DateTime('now'))->format('Y-m-d H:i:s'));
		$this->db->where('psoo_id', $psoo_id);		
        if($this->db->update('packaging_ship_out_order')){		
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'Short Closure Requeste response by '.$tracek_packer_name,'psoo_id'=>$psoo_id]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }		
    }	
	// Initiate Short Closure By Packer ends 
	
	
	// Auto Email Tracek Reports Send Starts 	
	   public function AutoEmailTracekReportsSend() {
    		$current_date = date('Y-m-d');
    	$this->db->select('ltrc_id, customer_id, report_name, tracek_report_slug, report_auto_email_status, report_site_url');
        $this->db->where(array('report_auto_email_status' => "Continue"));
    	$this->db->order_by('ltrc_id', 'ASC');
        $query = $this->db->get('list_tracek_report_customer');
        $rows = $query->result_array();
    		
    	foreach($rows as $row){ // foreach start
    	$ltrc_id = $row['ltrc_id'];
    	$customer_id = $row['customer_id'];
    	$report_name = $row['report_name'];
    	$tracek_report_slug = $row['tracek_report_slug'];
    	$auto_email_frequency = "Daily";
    	$report_site_url = $row['report_site_url'];
    	$to_email_ids = getCustomerEmailById($customer_id);
    	$email_subject = $report_name;
    	$email_body = "Your ".$report_name." is here.";
		//$last_auto_email_sent_date = $row['auto_email_status_date'];
		//$create_date = $row['create_date'];		
    	$customer_name = getUserFullNameById($customer_id);	
    	/*
    	if($tracek_report_slug=="pre_purchase_scan_report"){
    		$report_download_link = "http://".$_SERVER['SERVER_NAME']."/api/customer/pre_purchase_scan_report_export_excel/".$customer_id."/".$mis_data_duration;
    	}elseif($tracek_report_slug=="post_purchase_scan_report"){
    		$report_download_link = "http://".$_SERVER['SERVER_NAME']."/api/customer/post_purchase_scan_report_export_excel/".$customer_id."/".$mis_data_duration;
    	}else{}
		*/		
		$report_download_link = "http://".$_SERVER['SERVER_NAME']."/api/customer/".$report_site_url."/".$customer_id;
		/*
										if($last_auto_email_sent_date=='0000-00-00'){
											$previous_date = $create_date;
										}else{
											$previous_date = $last_auto_email_sent_date;
										}
													$date1 = date_create($previous_date);
													$date2 = date_create(date('Y-m-d'));
													//difference between two dates
													$diff = date_diff($date1,$date2);
													//count days
													$day_count = ($diff->format("%a"))+1;
				
				switch ($auto_email_frequency) {
					  case "Daily":
					   $report_send_days = 1;
						break;
					  case "Weekly":
					   $report_send_days = 7;
						break;
					  case "Monthly":
					   $report_send_days = 30;
						break;
					  default:
					   $report_send_days = 365;
					}

				
    				if($day_count>=$report_send_days){
    				$updateData = array(
    			   'auto_email_status_date'=>$current_date
    				);
					*/
				$updateData = array(
    			   'auto_email_status_date'=>$current_date
    				);	
    			$this->db->where('ltrc_id', $ltrc_id);
    			$this->db->update('list_tracek_report_customer', $updateData); 
    			
    			$this->AutoEmailTracekReports($report_name, $to_email_ids, $email_subject, $email_body, $customer_name, $report_download_link);	
				/*
				$cbb1_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 11)->get()->row();
			$billin_particular_name = $cbb1_result->billin_particular_name;
			$billin_particular_slug = $cbb1_result->billin_particular_slug;
		
			$AutoEmailMISCBB['customer_id'] = $customer_id;
			$AutoEmailMISCBB['billing_particular_name'] = $billin_particular_name;		
			$AutoEmailMISCBB['billing_particular_slug'] = $billin_particular_slug;
			$AutoEmailMISCBB['trans_quantity'] = 1; 
			$AutoEmailMISCBB['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$AutoEmailMISCBB['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $AutoEmailMISCBB);
			*/
    				//}
    		} // foreach end 
    }
	
	
	public function AutoEmailTracekReports($report_name, $to_email_ids, $email_subject, $email_body, $customer_name, $report_download_link) 
		{
	   $subject = $email_subject;
        $body = "Hello <b>" . $customer_name . "</b>,
						<br><br>
						 " . $email_body . "
						<br>
						<br><a href='". $report_download_link ."'><img src='http://".$_SERVER['SERVER_NAME']."/assets/images/excel_xls.png' alt='". $report_name ."'> ". $report_name ."</a></b>.
 						<br><br><b>ISPL Team</b>";
        $mail_conf = array(
            'subject' => $email_subject,
            'to_email' => 'sanjay@innovigent.in',
            'cc' => 'sanjay@innovigent.in',
            'from_email' => 'admin@'.$_SERVER['SERVER_NAME'],
            'from_name' => 'ISPL',
            'body_part' => $body
        );
        if ($this->dmailer->mail_notify($mail_conf)) {
            return true;
        } return false; //echo redirect('accounts/create');
    }

	
	// Auto Email Tracek Reports Send
    
}
