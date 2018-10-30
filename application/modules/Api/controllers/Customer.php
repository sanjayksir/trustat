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
        $result = $this->Productmodel->barcodeProducts($data['bar_code']);
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
			
            //echo $this->db->last_query();die;
            $this->response(['status'=>true,'message'=>'Level has been added.','new_pack_level'=>$data['pack_level'],'data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
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
			['field' =>'parent_bar_code','label'=>'Parent Barcode','rules' => 'required' ],
			['field' =>'parent_pack_level','label'=>'Parent Pack Barcode','rules' => 'required' ],
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ]
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
		   
		   
			$results2 = $this->db->select('pack_level')->from('printed_barcode_qrcode')->where('barcode_qr_code_no', $data['bar_code'])->get()->row();
			//$result['number_of_children'] = $results2->$pack_level_field_name;
			//$data['parent_barcode_qr_code'] = $data['parent_bar_code'];
			///$data['barcode_qr_code_no'] = $data['bar_code'];
			$data['packaging_level'] = $results2->pack_level;
			$data['product_id'] = $result[0]['product_id'];
			//$data['packaging_level'] = $data['pack_level'];
			
		
       // foreach(explode(',',$data['bar_code']) as $ind => $code){
            //$this->db->or_where('barcode_qr_code_no',$code);
        //$data['bar_code'] = $code;
		
		 $isPackLevelSeted = $this->Productmodel->isPackLevelSeted($data['bar_code']);
		
		if($isPackLevelSeted==true){
        if($this->db->insert('packaging_codes_pcr', $data)){
			
			$data['child_added'] = $this->db->where('parent_bar_code',$data['parent_bar_code'])->from("packaging_codes_pcr")->count_all_results();
		
            $this->response(['status'=>true,'message'=>'Level has been added.','number_of_children_added'=>$data['child_added'],'data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to add level.'],200); 
        }
		}else{
            $this->response(['status'=>false,'message'=>'System failed to add packaging because this code is already added in packaging.'],200); 
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
    
}
