<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require 'ApiController.php';

/**
 * Description of BarCodeController
 *
 * @author Sanjay
 */
class ScannedProduct extends ApiController {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ScannedproductsModel');
        $this->load->model('Productmodel');
        $this->load->model('ConsumerModel');
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
			['field' =>'scan_city','label'=>'Scan City','rules' => 'trim' ],
            ['field' =>'latitude','label'=>'Latitude','rules' => 'trim'],
            ['field' =>'longitude','label'=>'Longitude','rules' => 'trim' ],
			//['field' =>'registration_address','label'=>'Registration Address','rules' => 'trim|required' ],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $result = $this->ScannedproductsModel->findProduct($data['bar_code']);
        $bar_code_data = $data['bar_code'];
		$product_id = $result->id;
		$consumerId = $user['id'];
		// function to get product registration status
        $isRegistered = $this->ScannedproductsModel->isProductRegistered($bar_code_data);   
	
        $isLoyaltyForVideoFBQuesGiven = $this->ScannedproductsModel->isLoyaltyForVideoFBQuesGiven($consumerId,$product_id);
        $isLoyaltyForAudioFBQuesGiven = $this->ScannedproductsModel->isLoyaltyForAudioFBQuesGiven($consumerId,$product_id);
        $isLoyaltyForImageFBQuesGiven = $this->ScannedproductsModel->isLoyaltyForImageFBQuesGiven($consumerId,$product_id);
        $isLoyaltyForPDFFBQuesGiven = $this->ScannedproductsModel->isLoyaltyForPDFFBQuesGiven($consumerId,$product_id);
		$isLoyaltyForProductPushedAdVideoFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductPushedAdVideoFeedbackQuesGiven($consumerId,$product_id);
		$isLoyaltyForProductPushedAdAudioFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductPushedAdAudioFeedbackQuesGiven($consumerId,$product_id);
		$isLoyaltyForProductPushedAdPDFFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductPushedAdPDFFeedbackQuesGiven($consumerId,$product_id);
		$isLoyaltyForProductPushedAdImageFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductPushedAdImageFeedbackQuesGiven($consumerId,$product_id);
		
		$isLoyaltyForProductSurveyVideoFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductSurveyVideoFeedbackQuesGiven($consumerId,$product_id);
		$isLoyaltyForProductSurveyAudioFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductSurveyAudioFeedbackQuesGiven($consumerId,$product_id);
		$isLoyaltyForProductSurveyPDFFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductSurveyPDFFeedbackQuesGiven($consumerId,$product_id);
		$isLoyaltyForProductSurveyImageFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductSurveyImageFeedbackQuesGiven($consumerId,$product_id);
		
		$isLoyaltyForProductDemoVideoFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductDemoVideoFeedbackQuesGiven($consumerId,$product_id);
		$isLoyaltyForProductDemoAudioFeedbackQuesGiven = $this->ScannedproductsModel->isLoyaltyForProductDemoAudioFeedbackQuesGiven($consumerId,$product_id);
		
		$mnv25_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 25)->get()->row();
		$mnvtext25 = $mnv25_result->message_notification_value;
		$mnv26_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 26)->get()->row();
		$mnvtext26 = $mnv26_result->message_notification_value;
		$mnv27_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 27)->get()->row();
		$mnvtext27 = $mnv27_result->message_notification_value;
		$mnv28_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 28)->get()->row();
		$mnvtext28 = $mnv28_result->message_notification_value;
		$mnv29_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 29)->get()->row();
		$mnvtext29 = $mnv29_result->message_notification_value;
		$mnv30_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 30)->get()->row();
		$mnvtext30 = $mnv30_result->message_notification_value;
        
        if(empty($result)){
            $data['user_id'] = $user['id'];
            $data['created'] = date('Y-m-d H:i:s');
            $this->db->insert('scanned_product_logs', $data);
		$mnv24_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 24)->get()->row();
		$mnvtext24 = $mnv24_result->message_notification_value;
            //$this->response(['status'=>false,'message'=>'This product and barcode is not supported by TRUSTAT.'],200);
			$this->response(['status'=>false,'message'=>$mnvtext24],200);
        }
		if(!empty($result->product_thumb_images)){
            $result->product_thumb_images = Utils::setFileUrl($result->product_thumb_images);
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
		if(!empty($result->product_demo_video)){
            $result->product_demo_video = Utils::setFileUrl($result->product_demo_video);
        }
		if(!empty($result->product_demo_audio)){
            $result->product_demo_audio = Utils::setFileUrl($result->product_demo_audio);
        }
		if(!empty($result->product_user_manual)){
            $result->product_user_manual = Utils::setFileUrl($result->product_user_manual);
        }
		$result->product_registration_status = $isRegistered;

		$result->isLoyaltyForVideoFBQuesGiven = $isLoyaltyForVideoFBQuesGiven;
		$result->isLoyaltyForAudioFBQuesGiven = $isLoyaltyForAudioFBQuesGiven;
		$result->isLoyaltyForImageFBQuesGiven = $isLoyaltyForImageFBQuesGiven;
		$result->isLoyaltyForPDFFBQuesGiven = $isLoyaltyForPDFFBQuesGiven;
		$result->isLoyaltyForProductPushedAdVideoFeedbackQuesGiven = $isLoyaltyForProductPushedAdVideoFeedbackQuesGiven;
		$result->isLoyaltyForProductPushedAdAudioFeedbackQuesGiven = $isLoyaltyForProductPushedAdAudioFeedbackQuesGiven;
		$result->isLoyaltyForProductPushedAdPDFFeedbackQuesGiven = $isLoyaltyForProductPushedAdPDFFeedbackQuesGiven;
		$result->isLoyaltyForProductPushedAdImageFeedbackQuesGiven = $isLoyaltyForProductPushedAdImageFeedbackQuesGiven;
		
		$result->isLoyaltyForProductSurveyVideoFeedbackQuesGiven = $isLoyaltyForProductSurveyVideoFeedbackQuesGiven;
		$result->isLoyaltyForProductSurveyAudioFeedbackQuesGiven = $isLoyaltyForProductSurveyAudioFeedbackQuesGiven;
		$result->isLoyaltyForProductSurveyPDFFeedbackQuesGiven = $isLoyaltyForProductSurveyPDFFeedbackQuesGiven;
		$result->isLoyaltyForProductSurveyImageFeedbackQuesGiven = $isLoyaltyForProductSurveyImageFeedbackQuesGiven;
		
		$result->isLoyaltyForProductDemoVideoFeedbackQuesGiven = $isLoyaltyForProductDemoVideoFeedbackQuesGiven;
		$result->isLoyaltyForProductDemoAudioFeedbackQuesGiven = $isLoyaltyForProductDemoAudioFeedbackQuesGiven;
		
		

		$result->scanned_code = $data['bar_code']; 
		if($data['bar_code'] == $result->barcode_qr_code_no) {
			
		$result->activation_level = $result->pack_level; 
		
		
		} else {
			
		$result->activation_level = $result->pack_level2; 
			
		}                 
        $data['consumer_id'] = $user['id'];
        $data['product_id'] = $result->id;
		$data['customer_id'] = $result->created_by;
        $data['created_at'] = date("Y-m-d H:i:s");
		$data['del_by_cs'] = 0;
        //$result->pack_level = $result->pack_level;
		
		$consumer_id = $data['consumer_id'];
		$customer_id = $data['customer_id'];
		$product_id = $data['product_id'];
		
		
		
		$isConsAlreadyLinkedtoCust = $this->ScannedproductsModel->isConsAlreadyLinkedtoCust($consumer_id, $customer_id);
		
		if($isConsAlreadyLinkedtoCust==false){
		$this->db->insert('consumer_customer_link', $data);
		}
		
        if($this->db->insert($this->ScannedproductsModel->table, $data)){
			
			
			//$this->db->insert('consumer_customer_link', $data);
			
			
			if($result->barcode_qr_code_no == $data['bar_code']) {
            if( $result->pack_level == 0 ){
                if( $isRegistered ){
					
					if( $isRegistered == completed ){
					
                    //$result->message1 = 'This product is already registered, please contact your retailer/manufacturer for further details.';
					$result->message1 = $mnvtext25;
                }else {
					//$result->message1 = 'This product registration is already under process. Outcome of product registration will be notified to TRUSTAT member, who had initiated the registration process.';
					$result->message1 = $mnvtext26;
				}
				}else{
                    //$result->message1 = 'Thank You for initiating Product Registration, Click Ok to scan and upload valid invoice for this product purchase and activate the warranty.';
					$result->message1 = $mnvtext27;
                }
            }elseif( $result->pack_level == 1 ){
                //$result->message1 = 'Scanned product details for lavel '.$result->pack_level.'.';
				//$result->message1 = 'The barcode you have scanned is on the product packing, please scan the barcode on the product for registration.';
				$result->message1 = $mnvtext29;
            }elseif($result->pack_level > 1){
                //$result->message1 = 'This is not a product barcode for consumer, Please scan barcode placed on consumer pack';
				$result->message1 = $mnvtext30;
            }
			} else {
				
			if( $result->pack_level2 == 0 ){
                if( $isRegistered ){
					
					if( $isRegistered == completed ){
					
                    //$result->message1 = 'This product is already registered, please contact your retailer/manufacturer for further details';
					$result->message1 = $mnvtext25;
                }else {
					//$result->message1 = 'This product registration is already under process. Outcome of product registration will be notified to TRUSTAT member, who had initiated the registration process';
					$result->message1 = $mnvtext26;
				}
				}else{
                   // $result->message1 = 'Thank You for initiating Product Registration, Click Ok to scan and upload valid invoice for this product purchase and activate the warranty';
					 $result->message1 = $mnvtext27;
                }
            }elseif( $result->pack_level2 == 1 ){
                //$result->message1 = 'Scanned product details for lavel '.$result->pack_level.'.';
				//$result->message1 = 'The barcode you have scanned is on the product packing, please scan the barcode on the product for registration.';
				$result->message1 = $mnvtext29;
            }elseif($result->pack_level2 > 1){
                //$result->message1 = 'This is not a product barcode for consumer, Please scan barcode placed on consumer pack';
				$result->message1 = $mnvtext30;
            }	
			}
			
            //$this->response(['status'=>true,'message'=>'Scanned product details for lavel '.$result->pack_level.'.','data'=>$result]);
		$mnv31_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 31)->get()->row();
		$mnvtext31 = $mnv31_result->message_notification_value;
			//$this->response(['status'=>true,'message'=>'Thanks for scanning the product.','data'=>$result]);
			$this->response(['status'=>true,'message'=>$mnvtext31,'data'=>$result]);
        }else{
		$mnv32_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 32)->get()->row();
		$mnvtext32 = $mnv32_result->message_notification_value;	
           // $this->response(['status'=>false,'message'=>'System failed to scan the record.'],200); 
			$this->response(['status'=>false,'message'=>$mnvtext32],200); 
        }
    }
   
   
   
   
   // Products Advertisement API  
   public function productsAdvertisements(){
        $user = $this->auth();
        if(empty($this->auth())){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'consumer_id','label'=>'Consumer ID','rules' => 'required' ],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$consumer_id = $data['consumer_id']; 
		//echo $consumer_id; exit;
        $result = $this->ScannedproductsModel->findProductForConsumer($consumer_id);
		//$result = $this->ScannedproductsModel->sendFCM($mess,$consumer_id);
		//echo $result;
		/* 
        if(!empty($result->product_video)){
             $result->product_video = Utils::setFileUrl($result->product_video);
			echo $result->product_video;
			
        }*/
		
		if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        $this->response(['status'=>true,'message'=>'Push Advertisements','data'=>$result]);
		
    }
   
   //   \Advertisement
   
   // Products Survey API  
   public function productsSurveys(){
        $user = $this->auth();
        if(empty($this->auth())){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'consumer_id','label'=>'Consumer ID','rules' => 'required' ],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		$consumer_id = $data['consumer_id']; 
		//echo $consumer_id; exit;
        $result = $this->ScannedproductsModel->findProductForConsumerSurvey($consumer_id);
		//$result = $this->ScannedproductsModel->sendFCMSurvey($mess,$consumer_id);
		
		//echo $result;
		/* 
        if(!empty($result->product_video)){
             $result->product_video = Utils::setFileUrl($result->product_video);
			echo $result->product_video;
			
        }*/
		
		if(empty($result)){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        $this->response(['status'=>true,'message'=>'Push Surveys','data'=>$result]);
		
    }
   
   //   \Survey
   
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
     * registerProduct to order the product....
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
			['field' =>'latitude','label'=>'Latitude','rules' => 'required'],
			['field' =>'longitude','label'=>'Longitude','rules' => 'required'],
			['field' =>'registration_address','label'=>'Registration Address','rules' => 'trim|required' ],
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
		
		$mnv33_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 33)->get()->row();
		$mnvtext33 = $mnv33_result->message_notification_value;
		
		$mnv34_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 34)->get()->row();
		$mnvtext34 = $mnv34_result->message_notification_value;
		
		$mnv35_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 35)->get()->row();
		$mnvtext35 = $mnv35_result->message_notification_value;
		
		$mnv36_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 36)->get()->row();
		$mnvtext36 = $mnv36_result->message_notification_value;
		
		$mnv37_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 37)->get()->row();
		$mnvtext37 = $mnv37_result->message_notification_value;
			$Product_id = getProductIDbyProductCode($data['bar_code']);
			$customerId = get_customer_id_by_product_id($Product_id);
			
				$purchased_points = total_approved_points2($customerId);
				$consumed_points = get_total_consumed_points($customerId);
				$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($customerId);
				//$data['customer_loyalty_type'] = $customer_loyalty_type;
				//$closing_balance = $purchased_points - $consumed_points;
			//echo "<pre>";print_r($customer_loyalty_type); die;
		 
        $result = $this->ScannedproductsModel->findProduct($data['bar_code']);
        
        if(empty($result)){
            $this->response(['status'=>false,'message'=>'This product and barcode is not supported by TRUSTAT.'],200);
        }
        //echo "<pre>";print_r($result);die;
        $bar_code_data = $result->barcode_qr_code_no;
		$bar_code2_data = $result->barcode_qr_code_no2;
        $isRegistered = $this->ScannedproductsModel->isProductRegistered($bar_code_data, $bar_code2_data); 
		if($result->barcode_qr_code_no == $data['bar_code']){
        if( $result->pack_level == 1 ){
            //$data['message1'] = 'The barcode you have scanned is on the product packing, please scan the barcode on the product for registration upon purchase for loyalty rewards';
			$data['message1'] = $mnvtext33;
           // $this->response(['status'=>true,'message'=>'Product registration failed for pack level '.$result->pack_level.'.','data'=>$data]);
			$this->response(['status'=>true,'message'=>$mnvtext34.' '.$result->pack_level.'.','data'=>$data]);
        }elseif($result->pack_level > 1){
           // $data['message1'] = 'The barcode you have scanned is on the product packing, please scan the barcode on the product for registration upon purchase for loyalty rewards';
			 $data['message1'] = $mnvtext33;
            //$this->response(['status'=>true,'message'=>'Product registration failed for pack level '.$result->pack_level.'.','data'=>$data]);
			$this->response(['status'=>true,'message'=>$mnvtext34.' '.$result->pack_level.'.','data'=>$data]);
        }
		} else {
		if( $result->pack_level2 == 1 ){
            //$data['message1'] = 'The barcode you have scanned is on the product packing, please scan the barcode on the product for registration upon purchase for loyalty rewards';
			$data['message1'] = $mnvtext33;
            //$this->response(['status'=>false,'message'=>'Product registration failed for pack level '.$result->pack_level2.'.','data'=>$data]);
			$this->response(['status'=>false,'message'=>$mnvtext34.' '.$result->pack_level2.'.','data'=>$data]);
        }elseif($result->pack_level2 > 1){
            //$data['message1'] = 'The barcode you have scanned is on the product packing, please scan the barcode on the product for registration upon purchase for loyalty rewards';
			$data['message1'] = $mnvtext33;
           // $this->response(['status'=>false,'message'=>'Product registration failed for pack level '.$result->pack_level2.'.','data'=>$data]);
			$this->response(['status'=>false,'message'=> $mnvtext34.' '.$result->pack_level2.'.','data'=>$data]);
        }	
			
		}	
		
		if($result->stock_status!='Customer_Code'){
        if(!empty($isRegistered)){
            if($isRegistered['status'] == 0){
                //$data['message1'] = $message = 'This product registration is already under process. Outcome of product registration will be notified to TRUSTAT member, who had initiated the registration process.';
				$data['message1'] = $message = $mnvtext35;
            }elseif($isRegistered['status'] == 1){
                //$data['message1']  = $message = 'This product is already registered, please contact your retailer/manufacturer for further details.';
				$data['message1']  = $message = $mnvtext35;
            }
            $this->response(['status'=>true,'message'=>$message,'data'=>$data]);
        }
		}
		
        //$data['invoice_image'] = null;
        if(!empty($data['invoice_image'])){
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
        $warrenty = null;
        foreach($result->attribute_list as $list){
            if(strstr(strtolower($list->name), 'warranty')){
                $warrenty = $list->value;
                break;
            }else{
                continue;
            }
        }
        $data['purchase_date'] = $data['purchase_date'];
        //$data['warranty_start_date'] = '0000-00-00';
        //$data['warranty_end_date'] = '0000-00-00';
        $data['consumer_id'] = $user['id'];
        $data['product_id'] = $result->id;
        $data['modified'] = date('Y-m-d H:i:s');
		$data['create_date'] = date('Y-m-d H:i:s');
		$consumer_id = $user['id'];
		$ProductID = $result->id;
		$product_brand_name = get_products_brand_name_by_id($ProductID);
		$customer_name = getUserFullNameById($customerId);
		$customer_id = get_customer_id_by_product_id($ProductID);
		$product_name = get_products_name_by_id($ProductID);
		$consumer_name = getConsumerNameById($consumer_id);		
		
		$transactionType = 'product_registration_lps';
		$transactionTypeName = 'Product Registration';
				
		$result2 = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result2->$transactionType;
				
		if($purchased_points > ($consumed_points+$TRPoints)){
				$data['loyalty_points_earned'] = $TRPoints;
				 }else{
            $data['loyalty_points_earned'] = 0;			
				}
				
		
        if(!empty($warrenty)){
            $data['status'] = 0;
        }else{
            $data['status'] = 1;
			
        }
        
        unset($data['purchase_date']);
        //echo "<pre>";print_r($data);die;        
        if($this->db->insert('purchased_product', $data)){
            $data['invoice_image'] = site_url($data['invoice_image']);
            $data['pack_level'] = $result->pack_level;
            $data['id'] = $this->db->insert_id();
            if(is_null($warrenty)){
				if($result->stock_status!='Customer_Code'){
                //$loyltyPoints = $this->db->get_where('loylties', ['transaction_type_slug' => 'product-registration-without-warranty'])->row();
				$LPconsumed_points = $consumed_points+$TRPoints;
				//echo "<pre>";print_r($LPconsumed_points); die;
				
				
				if($purchased_points > ($consumed_points+$TRPoints)){
                $message = 'Thank You for Product Registration. '. $TRPoints .' loyalty points will be added to your TRUSTAT loyalty account';
				//echo "<pre>Jyada";print_r($LPconsumed_points); die;
				}else{
					$message = 'Thank You for Product Registration!';
					//echo "<pre>kam";print_r($LPconsumed_points); die;
					}
				
			   // $transactionType = 'product-registration-without-warranty'; 
				$transactionType = "product_registration_lps";
			    $transactionTypeName = "Scan for product registration";
			   
				$userId = $user['id'];	
				
				
				
				if($purchased_points > ($consumed_points+$TRPoints)){
	$this->Productmodel->saveLoyltyProductReg($transactionType, $userId, $ProductID, ['verification_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $ProductID, 'product_code' => $data['bar_code'],'customer_loyalty_type' => $customer_loyalty_type], $customer_id, $customer_loyalty_type);
				//$this->Productmodel->saveConsumerPassbookLoyalty($transactionType, $userId, ['user_id' => $userId, 'brand_name' => $result->brand_name, 'product_name' => $result->product_name, 'product_code' => $data['bar_code'], 'user_id' => $userId], 'Loyalty');
				
				
				$this->Productmodel->saveConsumerPassbookLoyaltyProductReg($transactionType, ['verification_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $ProductID, 'product_code' => $data['bar_code'],'customer_loyalty_type' => $customer_loyalty_type], $customer_id, $ProductID, $userId, $transactionTypeName,  'Loyalty', $customer_loyalty_type);
				}
				
				$fb_token = getConsumerFb_TokenById($userId);
              // $this->ConsumerModel->sendFCM('Thank you for Product Registration, Please check the details in "my purchase list" in TRUSTAT App.', $fb_token);
			    $this->ConsumerModel->sendFCM($mnvtext37, $fb_token);
				$NTFdata['consumer_id'] = $userId; 
				$NTFdata['title'] = "TRUSTAT notification";
				$NTFdata['body'] = $mnvtext37; 
				$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
				$NTFdata['status'] = 1; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
			   
				
				}else{
				// $loyltyPoints = $this->db->get_where('loylties', ['transaction_type_slug' => 'product-registration-without-warranty'])->row();
                $message = 'Thank You for Product Registration.';
                $transactionType = 'product-registration-without-warranty';  	
					
				}
				
            }else{
				if($result->stock_status!='Customer_Code'){
                //$loyltyPoints = $this->db->get_where('loylties', ['transaction_type_slug' => 'product-registration-with-warranty'])->row();
               
				if($purchased_points > ($consumed_points+$TRPoints)){
		$mnv38_result = $this->db->select('message_notification_value,message_notification_value_part2')->from('message_notification_master')->where('id', 38)->get()->row();
		$mnvtext38_1 = $mnv38_result->message_notification_value;
		$mnvtext38_2 = $mnv38_result->message_notification_value_part2;		
				//$message = 'Thank you for uploading the invoice, your product warranty will be activated and '. $TRPoints .' loyalty points will be added to your loyalty account after validation of uploaded invoice';
				$message = $mnvtext38_1 . ' '. $TRPoints .' ' . $mnvtext38_2;
				}
		$mnv39_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 39)->get()->row();
		$mnvtext39 = $mnv39_result->message_notification_value;
				//$message = 'Thank you for uploading the invoice, your product warranty will be activated';
				$message = $mnvtext39;
                $transactionType = 'product-registration-with-warranty';
                //$data['message1'] = 'Thank You for initiating Product Registration, Click Ok to scan and upload valid invoice for this product purchase and activate the warranty.';
				$data['message1'] = $mnvtext28;
				}else {
				//$loyltyPoints = $this->db->get_where('loylties', ['transaction_type_slug' => 'product-registration-with-warranty'])->row();
        $mnv40_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 40)->get()->row();
		$mnvtext40 = $mnv40_result->message_notification_value;
				//$message = 'Thank you for uploading the invoice, your product warranty will be activated and after validation of uploaded invoice';
				$message = $mnvtext40;
                $transactionType = 'product-registration-with-warranty';
                //$data['message1'] = 'Thank You for initiating Product Registration, Click Ok to scan and upload valid invoice for this product purchase and activate the warranty.';
				$data['message1'] = $mnvtext28;				
					
					
				}
            }
            $this->response(['status'=>true,'message'=>$message,'data'=>$data]);
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
		$mnv41_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 41)->get()->row();
		$mnvtext41 = $mnv41_result->message_notification_value;
        //$this->response(['status'=>true,'message'=>'List of purchased products.','data'=>$result]);
		$this->response(['status'=>true,'message'=>$mnvtext41,'data'=>$result]);
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
		$mnv42_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 42)->get()->row();
		$mnvtext42 = $mnv42_result->message_notification_value;
        //$this->response(['status'=>true,'message'=>'Purchased products details are','data'=>$result]);
		$this->response(['status'=>true,'message'=>$mnvtext42,'data'=>$result]);
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
            ['field' =>'bar_code','label'=>'Bar code','rules' => 'trim|required'],
            ['field' =>'type','label'=>'Latitude','rules' => 'required'],
            ['field' =>'description','label'=>'Longitude','rules' => 'trim|required' ],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        if(is_array($errors)){
            $this->response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $result = $this->ScannedproductsModel->findPurchasedProducts($user['id'],null,$data['bar_code']);
        if(empty($result[0])){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
        $data['product_id'] = $result[0]['product_id'];
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['consumer_id'] = $user['id'];
        $data['complain_code']= Utils::randomNumber(5);
        $data['status']= 'pending';
        if($this->db->insert('consumer_complaint', $data)){
            Utils::sendSMS($user['mobile_no'], 'Your complaint code is '.$data['complain_code'].'. The compliant has been transfered to the respective brand owner for quick redressal.');
            //Utils::sendSMS($this->config->item('adminMobile'), 'A consumer has looged a complain with compoain code '.$data['complain_code'].' with following description '.$data['description']);
	   $mnv43_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 43)->get()->row();
		$mnvtext43 = $mnv43_result->message_notification_value;
            //$this->response(['status'=>true,'message'=>'Your complaint has been logged successfully.','data'=>$data]);
			$this->response(['status'=>true,'message'=>$mnvtext43,'data'=>$data]);
        }else{
            $this->response(['status'=>false,'message'=>'System failed to log the complaint.'],200); 
        }
    }
	
	public function FeedbackOnProduct(){
        $user = $this->auth();
        if(empty($this->auth())){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'bar_code','label'=>'Product Code','rules' => 'trim|required'],
            ['field' =>'rating','label'=>'Product Rating','rules' => 'required'],
			['field' => 'latitude', 'label' => 'User latitude', 'rules' => 'trim|required'],
			['field' => 'longitude', 'label' => 'User longitude', 'rules' => 'trim|required'],
			['field' =>'registration_address','label'=>'Registration Address','rules' => 'trim|required' ],
			//['field' =>'type','label'=>'Latitude','rules' => 'required'],
            ['field' =>'description','label'=>'Product Description','rules' => 'trim|required' ],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        if(is_array($errors)){
            $this->response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
		
        $result = $this->ScannedproductsModel->findPurchasedProducts($user['id'],null,$data['bar_code']);
        if(empty($result[0])){
            $this->response(['status'=>false,'message'=>'Record not found'],200);
        }
		$results2 = $this->db->select('product_id')->from('printed_barcode_qrcode')->where('barcode_qr_code_no', $data['bar_code'])->or_where('barcode_qr_code_no2', $data['bar_code'])->get()->row();
		$ProductID = $results2->product_id;
		
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['consumer_id'] = $user['id'];
		$data['product_id'] = $ProductID;
		$data['ip_address'] =  $this->input->ip_address();
        //$data['complain_code']= Utils::randomNumber(5);
        //$data['status']= 'pending';
		$transactionType = "feedback_on_product_lps";
		$transactionTypeName = "Product Feedback";
		$customer_id = get_customer_id_by_product_id($ProductID);
		$result3 = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result3->$transactionType;
			$purchased_points = total_approved_points2($customer_id);
			$consumed_points = get_total_consumed_points($customer_id);
			if($purchased_points > ($consumed_points+$TRPoints)){	
		$mnv44_result = $this->db->select('message_notification_value,message_notification_value_part2')->from('message_notification_master')->where('id', 44)->get()->row();
		$mnvtext44_1 = $mnv44_result->message_notification_value;	
		$mnvtext44_2 = $mnv44_result->message_notification_value_part2;		
		//$mess = 'Thank you for posting your product experince. Loyalty Point '. $TRPoints .' have been added to your TRUSTAT loyalty program.'; 
		$mess = $mnvtext44_1 .' '. $TRPoints .' '. $mnvtext44_2;
			}
			
		$mnv45_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 45)->get()->row();
		$mnvtext45 = $mnv45_result->message_notification_value;
		
			$mess = $mnvtext45; 
		
        if($this->db->insert('feedback_on_product', $data)){
            //Utils::sendSMS($user['mobile_no'], 'Your feedback submitted successfully.');
            //Utils::sendSMS($this->config->item('adminMobile'), 'A consumer has looged a complain with compoain code '.$data['complain_code'].' with following description '.$data['description']);
			$data['product_id'] = $ProductID;
			$purchased_points = total_approved_points2($customer_id);
			$consumed_points = get_total_consumed_points($customer_id);
			$data['customer_name'] = getUserFullNameById($customer_id);
		
			$data['customer_loyalty_type'] = get_customer_loyalty_type_by_customer_id($customer_id);
			$customer_loyalty_type = $data['customer_loyalty_type'];
			if($purchased_points > ($consumed_points+$TRPoints)){
			$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $customer_loyalty_type);
			}
		$mnv46_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 46)->get()->row();
		$mnvtext46 = $mnv46_result->message_notification_value;
           //$this->response(['status'=>true,'message'=>'Your feedback submitted successfully.','data'=>$data]);
			$this->response(['status'=>true,'message'=>$mnvtext46,'data'=>$data]);
        }else{
		$mnv47_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 47)->get()->row();
		$mnvtext47 = $mnv47_result->message_notification_value;
            //$this->response(['status'=>false,'message'=>'System failed to log the complaint.'],200); 
			$this->response(['status'=>false,'message'=>$mnvtext47],200);
        }
    }
	
	// Scanned product deleted by the consumer from scanned product list 
	
	
	
	    public function DeleteScanedProduct() {
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
            ['field' =>'scan_id','label'=>'Scan ID','rules' => 'required' ],
        ];
        $errors = $this->ScannedproductsModel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $result = $this->ScannedproductsModel->findProduct($data['bar_code']);
        $bar_code_data = $data['bar_code'];
		$scan_id = $data['scan_id'];
		
		$this->db->set('del_by_cs', 1);
        $this->db->set('del_by_cs_date', date("Y-m-d H:i:s"));
        $this->db->where('scan_id', $scan_id);
        if ($this->db->update('scanned_products')) {
		$mnv48_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 48)->get()->row();
		$mnvtext48 = $mnv48_result->message_notification_value;
            Utils::response(['status' => true, 'message' => $mnvtext48, 'data' => $bar_code_data]);
        } else {
		$mnv49_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 49)->get()->row();
		$mnvtext49 = $mnv49_result->message_notification_value;	
            Utils::response(['status' => false, 'message' => $mnvtext49], 200);
        }
    }
	
}
