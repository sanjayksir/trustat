<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'ApiController.php';

class Customer extends ApiController {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('CustomerModel');
        $this->load->model('Productmodel');
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
        $inventory = [
            'plant_id' => $user['plant_id'],
            'customer_id' => $user['user_id'],
            'created_at' => (new DateTime('now'))->format('Y-m-d H:i:s')
        ];
        $status = true;
        foreach(explode(',',$data['bar_code']) as $ind => $code){
            $inventory['bar_code'] = $code;
            if($this->db->insert('physical_inventory', $inventory)){
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
			
			$tlogdata['trax_slug'] = "addProductLevel"; 
			$tlogdata['trax_name'] = "Add Product Level Activate";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['activation_location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
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
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ]
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
			
			$packaging_level = $data['packaging_level'] + 1;
			$parent_pack_level = $data['parent_pack_level'];
			$code_unity_type = $result[0]['code_unity_type'];
			$spackaging_qty_levels = "pack_level" . $data['packaging_level'];
			
			
		$number_of_children_added_in_basecode = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
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
			
		
			
		if($code_unity_type=='Single'){ 
		if($data['packaging_level'] > 0){ 
		 if($number_of_children_required_in_basecode <= $number_of_children_added_in_basecode){ // incomplete or empty box can not be packed
		 if($number_of_children_required_in_parentcode > $number_of_children_added_in_parentcode){ // Only number of childrent can be added as defined in parent code
		if($packaging_level == $parent_pack_level){ // Only one level lower level code can be added in the parent box
			$isPackLevelSeted = $this->Productmodel->isPackLevelSeted($data['bar_code'], $data['parent_bar_code']);
		if($isPackLevelSeted==true){ // if the code is already added in any other box
        if($this->db->insert('packaging_codes_pcr', $data)){
			
			
			$tlogdata['trax_slug'] = "addProductLevelParentActivate"; 
			$tlogdata['trax_name'] = "Product Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
		
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'data'=>$result]);
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
            $this->response(['status'=>false, $number_of_children_required_in_basecode, $number_of_children_added_in_basecode, 'message'=>'System failed to add packaging because incomplete or empty box can not be packed.'],200); 
        }
		}else{ // this condition is for level 0 code adding
            if($number_of_children_required_in_parentcode > $number_of_children_added_in_parentcode){ // Only number of childrent can be added as defined in parent code
		if($packaging_level == $parent_pack_level){ // Only one level lower level code can be added in the parent box
			$isPackLevelSeted = $this->Productmodel->isPackLevelSeted($data['bar_code'], $data['parent_bar_code']);
		if($isPackLevelSeted==true){ // if the code is already added in any other box
        if($this->db->insert('packaging_codes_pcr', $data)){
			
			
			$tlogdata['trax_slug'] = "addProductLevelParentActivate"; 
			$tlogdata['trax_name'] = "Product Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
		
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'data'=>$result]);
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
			
			
			$tlogdata['trax_slug'] = "addProductLevelParentActivate"; 
			$tlogdata['trax_name'] = "Product Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
		
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'data'=>$result]);
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
			
			
			$tlogdata['trax_slug'] = "addProductLevelParentActivate"; 
			$tlogdata['trax_name'] = "Product Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			$data['number_of_children_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
		
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['number_of_children_added'],'data'=>$result]);
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
			['field' =>'plant_id','label'=>'plant_id is required','rules' => 'required' ],
			['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
			['field' =>'invoice_number','label'=>'Invoice Number','rules' => 'required' ],
			['field' =>'transaction_type','label'=>'Transaction Type','rules' => 'required' ],
			['field' =>'location_type','label'=>'Location Type','rules' => 'required' ],
			['field' =>'location_id','label'=>'Location id','rules' => 'required' ],
			['field' =>'location_name','label'=>'Location Name','rules' => 'required' ],
			['field' =>'created_by_id','label'=>'Created By','rules' => 'required' ],
			['field' =>'transfer_out_date','label'=>'Date is not given','rules' => 'required' ]
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
		 $isItemAlreadyExists = $this->Productmodel->isItemAlreadyExists($data['bar_code']);
		 
		  $isitMaster = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
		 
		if($isitMaster>0){
		//if($isItemAlreadyExists==true){
		    if($this->db->insert('dispatch_stock_transfer_out', $data)){
				
				
			$tlogdata['trax_slug'] = "DispatchStockTransferOut"; 
			$tlogdata['trax_name'] = "Stock Transfer Out";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 	
			
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
			$data2['created_by_id'] = $data['created_by_id'];
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
			['field' =>'plant_id','label'=>'plant_id is required','rules' => 'required' ],
			['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
			['field' =>'invoice_number','label'=>'Invoice Number','rules' => 'required' ],
			['field' =>'transaction_type','label'=>'Transaction Type','rules' => 'required' ],
			['field' =>'location_type','label'=>'Location Type','rules' => 'required' ],
			['field' =>'location_id','label'=>'Location id','rules' => 'required' ],
			['field' =>'location_name','label'=>'Location Name','rules' => 'required' ],
			['field' =>'created_by_id','label'=>'Created By','rules' => 'required' ],
			['field' =>'transfer_out_date','label'=>'Date is not given','rules' => 'required' ]
            
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
		 $isItemAlreadyExistsStockIn = $this->Productmodel->isItemAlreadyExistsStockIn($data['bar_code']);
		
		 $isitMaster = $this->db->where('parent_bar_code',$data['bar_code'])->from("packaging_codes_pcr")->count_all_results();
		 
		if($isitMaster>0){
		//if($isItemAlreadyExistsStockIn==true){
		    if($this->db->insert('receipt_stock_transfer_in', $data)){
				
			
			$tlogdata['trax_slug'] = "ReceiptStockTransferIn"; 
			$tlogdata['trax_name'] = "Stock Transfer In";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
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
			$data2['created_by_id'] = $data['created_by_id'];
			$data2['update_date'] = date("Y-m-d H:i:s");
			if($isProductExistsinLocation==true){
				
				$Rstock_transfer_in_qty = $this->db->select('stock_transfer_in_qty')->from('inventory_on_hand')->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']))->get()->row();
				$stock_transfer_in_qty = $Rstock_transfer_in_qty->stock_transfer_in_qty;
				
				$data2['stock_transfer_in_qty'] = $stock_transfer_in_qty+1;
				$this->db->where(array('location_id' => $data2['location_id'], 'product_id' => $data2['product_id'], 'code_packaging_level' => $data2['code_packaging_level']));
				$this->db->update('inventory_on_hand', $data2);
				
			} else {
				$data2['stock_transfer_out_qty'] = 0;
				$data2['stock_transfer_in_qty'] = 1;
				$this->db->insert('inventory_on_hand',$data2);
				
			}
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
			['field' =>'inventory_in_date','label'=>'Date is not given','rules' => 'required' ]
            
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
				//echo "<pre>";print_r($data['product_id']);die;
		 $isItemAlreadyExistsInInventory = $this->Productmodel->isItemAlreadyExistsInInventory($data['bar_code']);
		
		//if($isItemAlreadyExistsInInventory==true){
		    if($this->db->insert('physical_inventory_check', $data)){
				
			
			$tlogdata['trax_slug'] = "PhysicalInventoryCheck"; 
			$tlogdata['trax_name'] = "Physical Inventory Check";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
		
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
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ]
        ];
        $errors = $this->Productmodel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$userId = $user['user_id'];
        $result = $this->Productmodel->barcodeProducts($data['bar_code'], $userId);
		
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
			
			
			$tlogdata['trax_slug'] = "DeleteProductParentDelink"; 
			$tlogdata['trax_name'] = "Un-Packaging";
			$tlogdata['parent_customer_id'] = $result[0]['created_by']; 
			$tlogdata['agent_customer_id'] = $userId; 
			$tlogdata['product_id'] = $result[0]['product_id']; 
			$tlogdata['product_code'] = $data['bar_code']; 
			$tlogdata['plant_id'] = getAssignedPlantIDbyProductCode($data['bar_code']); 
			$tlogdata['location_id'] = $data['location_id']; 
			$tlogdata['product_sku'] = $result[0]['product_sku']; 
			$tlogdata['transaction_datetime'] = date('Y-m-d H:i:s'); 
			
			$this->db->insert('list_transactions_table', $tlogdata);
			
			
			if (!$this->db->affected_rows()) {
					$this->response(['status'=>false,'message'=>'System failed to Child De-Linked, incorrect parent.'],200); 
				} else {
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
			$userLocation = $this->db->get_where('assign_locations_to_users',['user_id'=>$user->user_id])->row();
            $user->location_id = $userLocation->location_id;
			$user->designation_name_slug = getRoleSlugById($user->designation_id);
			$user->designation_name_value = getRoleNameById($user->designation_id);
			$functionalities = get_assigned_functionalities_to_role_list($user->designation_id);
			//$user->userid = $user->user_id;
			$user->assigned_functionalities_slug = get_functionality_slug_by_id($functionalities);
			$user->assigned_functionalities_name = get_functionality_name_by_id($functionalities);
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
        if (Utils::sendSMS($user->mobile_no, $smstext)) {
            if ($this->db->update('backend_user', ['password' => $user->password], ['user_id' => $user->user_id])) {
                Utils::response(['status' => true, 'message' => 'A new password has been sent to your registered mobile no.']);
            } else {
                Utils::response(['status' => false, 'message' => 'There is system error to reset password.']);
            }
        } else {
            Utils::response(['status' => false, 'message' => 'Failed to send message, Try after some time.']);
        }
    }
	
    
}
