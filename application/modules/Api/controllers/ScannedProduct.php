<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require 'ApiController.php';

/**
 * Description of BarCodeController
 *
 * @author subhash
 */
class ScannedProduct extends ApiController {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ScannedproductsModel');
    }
    /**
     * productScanning scan the product with the help of bar code and keep the recrod.
     */
    public function productScanning(){
        $user = $this->auth();
        if(empty($this->auth())){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required' ],
            ['field' =>'latitude','label'=>'Latitude','rules' => 'required'],
            ['field' =>'longitude','label'=>'Longitude','rules' => 'trim|required' ],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $result = $this->ScannedproductsModel->findProduct($data['bar_code']);
        $bar_code_data = $data['bar_code'];
		// function to get product registration status
        $isRegistered = $this->ScannedproductsModel->isProductRegistered($bar_code_data);
        //echo $isRegistered;
        if(empty($result)){
            $data['user_id'] = $user['id'];
            $data['created'] = date('Y-m-d H:i:s');
            $this->db->insert('scanned_product_logs', $data);
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        if(!empty($result->product_images)){
            $result->product_images = Utils::setFileUrl($result->product_images);
        }
        if(!empty($result->product_video)){
            $result->product_video = Utils::setFileUrl($result->product_video);
        }
        if(!empty($result->product_audio)){
            $result->product_audio = Utils::setFileUrl($result->product_audio);
        }
        if(!empty($result->product_pdf)){
            $result->product_pdf = Utils::setFileUrl($result->product_pdf);
        }
	$result->product_registration_status = $isRegistered;
		
        $data['consumer_id'] = $user['id'];
        $data['product_id'] = $result->id;
        $data['created_at'] = date("Y-m-d H:i:s");
        if($this->db->insert($this->ScannedproductsModel->table, $data)){
            $this->response(['status'=>true,'message'=>'Scanned product details for lavel '.$result->pack_level.'.','data'=>$result]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to scan the record.'],200); 
        }
    }
    
    /**
     * viewScannedProduct method to show the product which has been scanned by the user
     */
    
    public function viewScannedProduct(){
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $user = $this->auth();
        if(empty($this->auth())){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $result = $this->ScannedproductsModel->findScannedProducts($user['id']);
        if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        $this->response(['status'=>true,'message'=>'Scanned product details.','data'=>$result]);
    }
    
    /**
     * registerProduct to order the product
     */
    public function registerProduct(){
        $data = $this->getInput();
        //echo "<pre>";print_r($data);die;
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $user = $this->auth();
        if(empty($user)){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Barcode','rules' => 'required'],
            ['field' =>'purchase_date','label'=>'Purchase date','rules' => ['required',['date',[$this->ScannedproductsModel,'validDate']]]],
            ['field' =>'invoice','label'=>'Invoice','rules' => ['trim']],
            //['field' =>'invoice_image','label'=>'Invoice image','rules' => [['file',[$this->ScannedproductsModel,'validFile']]]],
            ['field' =>'expiry_date','label'=>'Expiry date','rules' => ['',['date',[$this->ScannedproductsModel,'validDate']]]],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        /*
        if(is_array($errors) || empty($data['invoice_image'])){
            if($errors){
                Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>'Invoice image is required.']);
            }else{
                Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
            }            
        }
		*/
        $result = $this->ScannedproductsModel->findProduct($data['bar_code']);
        
        if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        $data['invoice_image'] = null;
        if(!empty($data['invoice_image'])){die("END");
            $this->load->library('upload', [
                'upload_path'=>'./uploads/invoice/',
                'allowed_types'=>'gif|jpg|png|pdf',
                'max_size'=>'5120',
            ]);
            
            if(!$this->upload->do_upload('invoice_image')){
                $this->response(['status'=>false,'message'=> Utils::errors($this->upload->display_errors())]);
            }
            $data['invoice_image'] = 'uploads/invoice/'.$this->upload->data('file_name');
        }
        $data['purchase_date'] = $data['purchase_date'];
        $data['consumer_id'] = $user['id'];
        $data['product_id'] = $result->id;
        $data['modified'] = date('Y-m-d H:i:s');
        $data['status'] = 0;
        unset($data['purchase_date']);
        //echo "<pre>";print_r($data);die;        
        if($this->db->insert('purchased_product', $data)){
            $data['pack_level'] = $result->pack_level;
            $data['id'] = $this->db->insert_id();
            //$data['invoice_image'] = base_url($data['invoice_image']);
            $this->response(['status'=>true,'message'=>'Product has been registered for pack level '.$result->pack_level.'.','data'=>$data]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to register the product.']);
        }
    } 
    
    public function purchasedProduct(){
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $user = $this->auth();
        if(empty($user)){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $result = $this->ScannedproductsModel->findPurchasedProducts($user['id']);
        if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        $this->response(['status'=>true,'message'=>'List of purchased products.','data'=>$result]);
    }
    public function purchasedProductDetails($productId = null){
        if(($this->input->method() != 'get') || empty($productId)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $user = $this->auth();
        if(empty($user)){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $result = $this->ScannedproductsModel->findPurchasedProducts($user['id'],$productId);
        if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        $this->response(['status'=>true,'message'=>'List of purchased products.','data'=>$result]);
    }
    
    public function complaint(){
        $user = $this->auth();
        if(empty($this->auth())){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'product_id','label'=>'Product id','rules' => 'trim|required'],
            ['field' =>'type','label'=>'Latitude','rules' => 'required'],
            ['field' =>'description','label'=>'Longitude','rules' => 'trim|required' ],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        if(is_array($errors)){
            $this->response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $result = $this->ScannedproductsModel->findPurchasedProducts($user['id'],$data['product_id']);
        if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['consumer_id'] = $user['id'];
        $data['complain_code']= Utils::randomNumber(5);
        $data['status']= 'pending';
        if($this->db->insert('consumer_complaint', $data)){
            Utils::sendSMS($user['mobile_no'], 'Your compain code is '.$data['complain_code'].'. Our teem will contact you shortly.');
            //Utils::sendSMS($this->config->item('adminMobile'), 'A consumer has looged a complain with compoain code '.$data['complain_code'].' with following description '.$data['description']);
            $this->response(['status'=>true,'message'=>'Your complain has been logged successfully.','data'=>$data]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to log the complaint.'],200); 
        }
    }
}
