<?php

class ScannedproductsModel extends CI_Model {

    public $table = 'scanned_products';

    public function __construct() {
        parent::__construct();
    }

    public function validate($data, $fields) {
        $this->load->library('form_validation');
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($fields);

        //echo "<pre>";print_r($fields);die;
        if ($this->form_validation->run() == FALSE) {
            return Utils::errors($this->form_validation->error_string());
        }
        return true;
    }
    
    public function validDate($value){
        $valid = Utils::validDate($value, 'Y-m-d');	
        if(!$valid){
            $this->form_validation->set_message('date', '%s is not valid.');
            return FALSE;
        }else{ 
            return TRUE;            
        }
    }
    
    public function findBy($conditions = []) {
        $query = $this->db->get_where($this->table, $conditions)->row();
        if (empty($query)) {
            return false;
        }
        return $query;
    }

    public function findProduct($barcode = null) {
        if ($barcode == null) {
            return false;
        }
        $items = [];
        $query = $this->db->select('p.*,pbq.barcode_qr_code_no,pbq.pack_level,pbq.barcode_qr_code_no2,pbq.pack_level2,pbq.stock_status')
                ->from('printed_barcode_qrcode AS pbq')
                ->join('products AS p', 'p.id=pbq.product_id')
                ->where(['pbq.barcode_qr_code_no' => $barcode,'pbq.active_status'=>1])
				->or_where(['pbq.barcode_qr_code_no2' => $barcode])
				// ->or_where('library.available_until =', "00-00-00 00:00:00")
                ->get();
        //echo $this->db->last_query();die;
        //echo "<pre>";print_r($query);die;
        if ($query->num_rows() <= 0) {
            return false;
        }
        $items = $query->row();
        if (!empty($items->attribute_list)) {
            $attributesids = implode(',', json_decode($items->attribute_list, true));
            $items->attribute_list = $this->getAttributes($attributesids);
        }
        if (!empty($items->industry_data)) {
            $indIds = implode(',', json_decode($items->industry_data, true));
            $items->industry_data = $this->getIndustry($indIds);
        }
        return $items;
    }
	
	
	// find ad pushed 
	
	public function findProductForConsumer($consumer_id = null){
        if($consumer_id == null){
            return false;
        }
        
        $query = $this->db->select("pr.*, sp.*")
                ->from('push_advertisements AS sp')
                ->join('products AS pr', 'pr.id=sp.product_id')
                //->where(['sp.consumer_id' => $consumer_id])
				->where(array('sp.consumer_id' => $consumer_id, 'sp.ad_active' => 1))
				->order_by('sp.id', 'desc')
                ->get()
                ->result();
        if(empty($query)){
            return false;
        }
        //echo "<pre>";print_r($query);die;
        $items = [];
        foreach($query as $row){
            $item = [
				'push_ad_id' => $row->id,
                'product_id' => $row->product_id,
				'promotion_id' => $row->promotion_id,
				'product_name' => $row->product_name,
				'promotion_type' => $row->promotion_type,
				'media_type' => $row->media_type,
				'push_date' => $row->ad_push_date,
				'media_play_date' => $row->media_play_date,
				'promotion_title' => $row->promotion_title,
				'brand_name' => $row->brand_name,
				'product_ad_video_response_fbqq' => $row->product_ad_video_response_fbqq,
				'product_ad_audio_response_fbqq' => $row->product_ad_audio_response_fbqq,
				'product_ad_pdf_response_fbqq' => $row->product_ad_pdf_response_fbqq,
				'product_ad_image_response_fbqq' => $row->product_ad_image_response_fbqq,
				//'product_demo_audio_response_fbqq' => $row->product_demo_audio_response_fbqq,
               // 'ad_active' => Utils::exists('push_advertisements', ['product_id'=>$row->id,'consumer_id'=>$consumer_id]),
            ];
           
		  // $consumerId = $row->id;
		   $product_id = $row->product_id;
		   $promotion_id = $row->promotion_id;
			$item['isPushedAdVideoFeedbackGiven'] = $this->isLoyaltyForProductPushedAdVideoFeedbackQuesGiven($consumer_id, $product_id, $promotion_id);
			$item['isPushedAdAudioFeedbackGiven'] = $this->isLoyaltyForProductPushedAdAudioFeedbackQuesGiven($consumer_id, $product_id, $promotion_id);
			$item['isPushedAdPDFFeedbackGiven'] = $this->isLoyaltyForProductPushedAdPDFFeedbackQuesGiven($consumer_id, $product_id, $promotion_id);
			$item['isPushedAdImageFeedbackGiven'] = $this->isLoyaltyForProductPushedAdImageFeedbackQuesGiven($consumer_id, $product_id, $promotion_id);
            if(!empty($row->product_thumb_images)){
                $item['product_thumb_images'] = Utils::setFileUrl($row->product_thumb_images);
            }else{
                $item['product_thumb_images'] = '';
            }
            if(!empty($row->product_images)){
                $item['product_images'] = Utils::setFileUrl($row->product_images);
            }else{
                $item['product_images'] = '';
            }
			
			if(!empty($row->product_code_print_bg_images)){
                $item['product_code_print_bg_images'] = Utils::setFileUrl($row->product_code_print_bg_images);
            }else{
                $item['product_code_print_bg_images'] = '';
            }
			
            if(!empty($row->product_push_ad_video)){
                $item['product_push_ad_video'] = Utils::setFileUrl($row->product_push_ad_video);
            }else{
                $item['product_push_ad_video'] = '';
            }
            if(!empty($row->product_push_ad_audio)){
                $item['product_push_ad_audio'] = Utils::setFileUrl($row->product_push_ad_audio);
            }else{
                $item['product_push_ad_audio'] = '';
            }
			if(!empty($row->product_push_ad_pdf)){
                $item['product_push_ad_pdf'] = Utils::setFileUrl($row->product_push_ad_pdf);
            }else{
                $item['product_push_ad_pdf'] = '';
            }
			if(!empty($row->product_push_ad_image)){
                $item['product_push_ad_image'] = Utils::setFileUrl($row->product_push_ad_image);
            }else{
                $item['product_push_ad_image'] = '';
            }
			
            $items[] = $item;
        }
        return $items;
    }
	
	// Push Notification 
	
function sendFCM($mess,$id) {
$url = 'https://fcm.googleapis.com/fcm/send';

$fields = array (
        'to' => $id,
         
         'notification' => array('title' => 'TRUSTAT Ad', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
		 'data' => array('title' => 'TRUSTAT Ad', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
       
);
$fields = json_encode ( $fields );

$headers = array (
        'Authorization: key=' . "AAAA4LpXTK8:APA91bHs48XoX1_-4CdsBVyAAVceqQFavfo6Hz3K1U5Phmz2OgYsX7Pr_bNuE8x_PGJBcWs08WHx0JTGh-6goN7ozfl3yB8z9bYe_2ayk0Nmlp9uYOknIKDwq9czlj10rRGQ1bDZ9Nlp",
        'Content-Type: application/json'
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
	
	
	// \find ad pushed
	
	
	
	
	
	// find Survey pushed 
	
	public function findProductForConsumerSurvey($consumer_id = null){
        if($consumer_id == null){
            return false;
        }
        
        $query = $this->db->select("pr.*,sp.*")
                ->from('push_surveys AS sp')
                ->join('products AS pr', 'pr.id=sp.product_id')
                ->where(array('sp.consumer_id' => $consumer_id, 'sp.survey_active' => 1))
				->order_by('sp.id', 'desc')
                ->get()
                ->result();
        if(empty($query)){
            return false;
        }
        //echo "<pre>";print_r($query);die;
        $items = [];
        foreach($query as $row){
            $item = [
				'push_survey_id' => $row->id,
                'product_id' => $row->product_id,
				'promotion_id' => $row->promotion_id,
				'product_name' => $row->product_name,
				'promotion_type' => $row->promotion_type,
				'media_type' => $row->media_type,
				'push_date' => $row->survey_push_date,
				'media_play_date' => $row->media_play_date,
				'promotion_title' => $row->promotion_title,
				'brand_name' => $row->brand_name,
				'product_survey_video_response_fbqq' => $row->product_survey_video_response_fbqq,
				'product_survey_audio_response_fbqq' => $row->product_survey_audio_response_fbqq,
				'product_survey_pdf_response_fbqq' => $row->product_survey_pdf_response_fbqq,
				'product_survey_image_response_fbqq' => $row->product_survey_image_response_fbqq,
				//'product_demo_audio_response_fbqq' => $row->product_demo_audio_response_fbqq,
               // 'ad_active' => Utils::exists('push_advertisements', ['product_id'=>$row->id,'consumer_id'=>$consumer_id]),
            ];
			
	//$consumerId = 29;
	$product_id = $row->product_id;
	$promotion_id = $row->promotion_id;
	$customerId = get_customer_id_by_product_id($product_id);
	$customer_purchased_points = total_approved_points2($customerId);
	$customer_consumed_points = get_total_consumed_points($customerId);
	$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($customerId);
	$customer_loyalty_balance = $customer_purchased_points - $customer_consumed_points;	
	/*
	if($customer_loyalty_type=="TRUSTAT"){
				$item['GiveLoyalty'] = "Yes";
			}else{
			$item['GiveLoyalty'] = "No";
			}
		*/
		/*
		if($customer_loyalty_type=="TRUSTAT"){
			if(($customer_loyalty_balance-($row->product_survey_video_response_lps))< 0){
				$item['GiveLoyalty'] = "Yes";
			} else{
				$item['GiveLoyalty'] = "No";
		    } } else {
			$item['GiveLoyalty'] = "No";
		}
		*/
	$item['isGiven'] = $this->isLoyaltyForProductSurveyVideoFeedbackQuesGiven($consumer_id, $product_id, $promotion_id);
			
			$item['cid'] = $consumer_id;
		
           
            if(!empty($row->product_thumb_images)){
                $item['product_thumb_images'] = Utils::setFileUrl($row->product_thumb_images);
            }else{
                $item['product_thumb_images'] = '';
            }
            if(!empty($row->product_images)){
                $item['product_images'] = Utils::setFileUrl($row->product_images);
            }else{
                $item['product_images'] = '';
            }
			if(!empty($row->product_code_print_bg_images)){
                $item['product_code_print_bg_images'] = Utils::setFileUrl($row->product_code_print_bg_images);
            }else{
                $item['product_code_print_bg_images'] = '';
            }
			
            if(!empty($row->product_survey_video)){
                $item['product_survey_video'] = Utils::setFileUrl($row->product_survey_video);
            }else{
                $item['product_survey_video'] = '';
            }
			if(!empty($row->product_survey_audio)){
                $item['product_survey_audio'] = Utils::setFileUrl($row->product_survey_audio);
            }else{
                $item['product_survey_audio'] = '';
            }
			if(!empty($row->product_survey_pdf)){
                $item['product_survey_pdf'] = Utils::setFileUrl($row->product_survey_pdf);
            }else{
                $item['product_survey_pdf'] = '';
            }
			if(!empty($row->product_survey_image)){
                $item['product_survey_image'] = Utils::setFileUrl($row->product_survey_image);
            }else{
                $item['product_survey_image'] = '';
            }
            
            $items[] = $item;
        }
        return $items;
    }
	
	// Push notification Survey
	
	function sendFCMSurvey($mess,$consumer_id) {
$url = 'https://fcm.googleapis.com/fcm/send';

$fields = array (
        'to' => $consumer_id,
         
         'notification' => array('title' => 'TRUSTAT Survey', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
		 'data' => array('title' => 'TRUSTAT survey', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
       
);
$fields = json_encode ( $fields );

$headers = array (
        'Authorization: key=' . "AAAA4LpXTK8:APA91bHs48XoX1_-4CdsBVyAAVceqQFavfo6Hz3K1U5Phmz2OgYsX7Pr_bNuE8x_PGJBcWs08WHx0JTGh-6goN7ozfl3yB8z9bYe_2ayk0Nmlp9uYOknIKDwq9czlj10rRGQ1bDZ9Nlp",
        'Content-Type: application/json'
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

	// \find Survey pushed
	
	// check if the product code is registered or not 
	
    Public function isProductRegistered($bar_code_data, $bar_code2_data) {
       // $query = $this->db->get_where('purchased_product', array('bar_code' => $bar_code_data));
	   $query = $this->db->get_where('purchased_product',"bar_code='".$bar_code_data."' OR bar_code='".$bar_code2_data."'");
        if ($query->num_rows() > 0) {
            $data = $query->row_array();            
            return $data;
        } else {
            return false;
        }
    }
	
	Public function isConsAlreadyLinkedtoCust($consumer_id, $customer_id) {
        $query = $this->db->get_where('consumer_customer_link', array('consumer_id' => $consumer_id, 'customer_id' => $customer_id));
		//$query = $this->db->get_where('consumer_customer_link', array("consumer_id='".$consumer_id."' AND customer_id='".$customer_id."'", 'product_id' => $product_id));
	   //$query = $this->db->get_where('consumer_customer_link',"bar_code='".$bar_code_data."' OR bar_code='".$bar_code2_data."'");
        if ($query->num_rows() > 0) {
            $data = $query->row_array();            
            return $data;
        } else {
            return false;
        }
    }

	// checking if the Loyalty given to the user on Video type questions on code 
    Public function isLoyaltyForVideoFBQuesGiven($consumerId, $product_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_video_response_lps'");
		//print $answerQuery;
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    
                  return "Given";
                }             
            }
        }
        //return false;
		return "Not Given";
    }
	
		// checking if the Loyalty given to the user on Audio type questions on code 
    Public function isLoyaltyForAudioFBQuesGiven($consumerId, $product_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_audio_response_lps'");
		
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
                   if($paramsValue != ''){
						//return $row;
						return "Given";
					}
                }                
            }
        }
        //return false;
		return "Not Given";
    }
	
		// checking if the Loyalty given to the user on Image type questions on code 
    Public function isLoyaltyForImageFBQuesGiven($consumerId, $product_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_image_response_lps'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
                   if($paramsValue != ''){
						//return $row;
						return "Given";
					}
                }                
            }
        }
        //return false;
		return "Not Given";
    }
	
			// checking if the Loyalty given to the user on PDF type questions on code 
    Public function isLoyaltyForPDFFBQuesGiven($consumerId, $product_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_pdf_response_lps'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
                    if($paramsValue != ''){
						//return $row;
						return "Given";
					}
                }                
            }
        }
        return "Not Given";
    }
	
	// checking if the Loyalty given to the user on on Advertisement Video Product Pushed Ad Feedback type questions on code 
    Public function isLoyaltyForProductPushedAdVideoFeedbackQuesGiven($consumer_id, $product_id, $promotion_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumer_id."' AND promotion_id='".$promotion_id."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['promotion_id'] == $promotion_id)){
                    $row->params = $paramsValue;
                    if($paramsValue != ''){
						//return $row;
						return "Given";
					}
                }                
            }
        }
        return "Not Given";
    }
	
		// checking if the Loyalty given to the user on on Advertisement Audio Product Pushed Ad Feedback type questions on code 
    Public function isLoyaltyForProductPushedAdAudioFeedbackQuesGiven($consumer_id, $product_id, $promotion_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumer_id."' AND transaction_type='product_ad_video_response_lps' AND transaction_type='".$promotion_id."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
                    if($paramsValue != ''){
						//return $row;
						return "Given";
					}
                }                
            }
        }
        return "Not Given";
    }
	
		// checking if the Loyalty given to the user on on Advertisement PDF Product Pushed Ad Feedback type questions on code 
    Public function isLoyaltyForProductPushedAdPDFFeedbackQuesGiven($consumer_id, $product_id, $promotion_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumer_id."' AND transaction_type='product_ad_video_response_lps' AND transaction_type='".$promotion_id."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
                    if($paramsValue != ''){
						//return $row;
						return "Given";
					}
                }                
            }
        }
        return "Not Given";
    }
	
		// checking if the Loyalty given to the user on on Advertisement Image Product Pushed Ad Feedback type questions on code 
    Public function isLoyaltyForProductPushedAdImageFeedbackQuesGiven($consumer_id, $product_id, $promotion_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumer_id."' AND transaction_type='product_ad_video_response_lps' AND transaction_type='".$promotion_id."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
                    if($paramsValue != ''){
						//return $row;
						return "Given";
					}
                }                
            }
        }
        return "Not Given";
    }
	
	// checking if the Loyalty given to the user on on Product Video Survey Feedback type questions on code 
    Public function isLoyaltyForProductSurveyVideoFeedbackQuesGiven($consumerId, $product_id, $promotion_id) {
       // $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_survey_video_response_lps'");
		$answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND promotion_id='".$promotion_id."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['promotion_id'] == $promotion_id)){
                    $row->params = $paramsValue;
					if($paramsValue != ''){
						//return $row;
						return "Given";
					}
					
                    
                }                
            }
        }
        return "Not Given";
    }
	
	// checking if the Loyalty given to the user on on Product Audio Survey Feedback type questions on code 
    Public function isLoyaltyForProductSurveyAudioFeedbackQuesGiven($consumerId, $product_id, $promotion_id) {
       // $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_survey_video_response_lps'");
		$answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_survey_video_response_lps' AND transaction_type='".$promotion_id."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
					if($paramsValue != ''){
						//return $row;
						return "Given";
					}
					
                    
                }                
            }
        }
        return "Not Given";
    }
	
	// checking if the Loyalty given to the user on on Product PDF Survey Feedback type questions on code 
    Public function isLoyaltyForProductSurveyPDFFeedbackQuesGiven($consumerId, $product_id, $promotion_id) {
       // $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_survey_video_response_lps'");
		$answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_survey_video_response_lps' AND transaction_type='".$promotion_id."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
					if($paramsValue != ''){
						//return $row;
						return "Given";
					}
					
                    
                }                
            }
        }
        return "Not Given";
    }
	
	// checking if the Loyalty given to the user on on Product Image Survey Feedback type questions on code 
    Public function isLoyaltyForProductSurveyImageFeedbackQuesGiven($consumerId, $product_id, $promotion_id) {
       // $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_survey_video_response_lps'");
		$answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_survey_video_response_lps' AND transaction_type='".$promotion_id."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
					if($paramsValue != ''){
						//return $row;
						return "Given";
					}
					
                    
                }                
            }
        }
        return "Not Given";
    }
	
	
	// checking if the Loyalty given to the user on on Product Survey Feedback type questions on code 
    Public function isLoyaltyForProductDemoVideoFeedbackQuesGiven($consumerId, $product_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_demo_video_response_lps'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
					if($paramsValue != ''){
						//return $row;
						return "Given";
					} 
					
                    
                }                
            }
        }
        return "Not Given";
    }
	
	// checking if the Loyalty given to the user on on Product Survey Feedback type questions on code 
    Public function isLoyaltyForProductDemoAudioFeedbackQuesGiven($consumerId, $product_id) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='product_demo_audio_response_lps'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $product_id)){
                    $row->params = $paramsValue;
					if($paramsValue != ''){
						//return $row;
						return "Given";
					}
					
                    
                }                
            }
        }
        return "Not Given";
    }
	
    /*
    public function isProductRegistered($bar_code_data) {

        $query = $this->db->get_where('purchased_product', array('bar_code' => $bar_code_data));

        if ($query->num_rows() > 0) {
			
			$data = $query->row_array();

			$value = $data['status'];

			return $value
			
			//return r;
            //return TRUE;
        } else {
            return FALSE;
        }
    }
*/
    public function findScannedProducts($userid = null){
        if($userid == null){
            return false;
        }
        
        $query = $this->db->select("sp.scan_id,sp.bar_code,sp.latitude,sp.longitude,sp.created_at,pr.*")
                ->from($this->table.' AS sp')
                ->join('products AS pr', 'pr.id=sp.product_id')
                ->where(['sp.consumer_id' => $userid, 'sp.del_by_cs' => 0])
				->order_by('created_at', 'desc')
                ->get()
                ->result();
        if(empty($query)){
            return false;
        }
        //echo "<pre>";print_r($query);die;
        $items = [];
        foreach($query as $row){
            $item = [
				'scan_id' => $row->scan_id,
                'product_id' => $row->id,
                'bar_code' => $row->bar_code,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude,
                'created_at' => $row->created_at,
                'product_name' => $row->product_name,
                'product_sku' => $row->product_sku,
                'product_description' => $row->product_description,
                'purchased' => Utils::exists('purchased_product', ['product_id'=>$row->id,'consumer_id'=>$userid]),
            ];
            if (!empty($row->attribute_list)) {
                $attributesids = implode(',', json_decode($row->attribute_list, true));
                $item['attribute_list'] = $this->getAttributes($attributesids);
            }else{
                $item['attribute_list'] = [];
            }
            if (!empty($row->industry_data)) {
                $indIds = implode(',', json_decode($row->industry_data, true));
                $item['industry_data'] = $this->getIndustry($indIds);
            }else{
                $item['industry_data'] = [];
            }
            if(!empty($row->product_thumb_images)){
                $item['product_thumb_images'] = Utils::setFileUrl($row->product_thumb_images);
            }else{
                $item['product_thumb_images'] = '';
            }
			if(!empty($row->product_images)){
                $item['product_images'] = Utils::setFileUrl($row->product_images);
            }else{
                $item['product_images'] = '';
            }
			if(!empty($row->product_code_print_bg_images)){
                $item['product_code_print_bg_images'] = Utils::setFileUrl($row->product_code_print_bg_images);
            }else{
                $item['product_code_print_bg_images'] = '';
            }
            if(!empty($row->product_video)){
                $item['product_video'] = Utils::setFileUrl($row->product_video);
            }else{
                $item['product_video'] = '';
            }
            if(!empty($row->product_audio)){
                $item['product_audio'] = Utils::setFileUrl($row->product_audio);
            }else{
                $item['product_audio'] = '';
            }
            if(!empty($row->product_pdf)){
                $item['product_pdf'] = Utils::setFileUrl($row->product_pdf);
            }else{
                $item['product_pdf'] = '';
            }
            $items[] = $item;
        }
        return $items;
    }
	
	
	
    public function findPurchasedProducts($userId = null,$productId = null,$barCode=null){
        if($userId == null){
            return false;
        }
        $conditions = ['pp.consumer_id' => $userId];
        if(!empty($productId)){
            $conditions['pp.product_id'] = $productId;
        }elseif(!empty($barCode)){
            $conditions['pp.bar_code'] = $barCode;
        }
        $query = $this->db->select("pp.purchased_product_id AS purchased_id,pp.bar_code,pp.purchase_date,pp.create_date,pp.invoice,pp.invoice_image,pp.expiry_date,pp.warranty_start_date,pp.warranty_end_date,pp.loyalty_points_earned,pp.seller_name,pp.selling_price,pp.discount,pr.*")
                ->from('purchased_product AS pp')
                ->join('products AS pr', 'pr.id=pp.product_id')
                ->where($conditions)
				->order_by('create_date', 'desc')
                ->get()
                ->result();
        //echo $this->db->last_query();die;
        if(empty($query)){
            return false;
        }
        $items = [];
        foreach($query as $row){
            $item = [
                'bar_code' => $row->bar_code,
                'purchased_id' => $row->purchased_id,
                'purchase_date' => $row->purchase_date,
				'seller_name' => $row->seller_name,
				'selling_price' => $row->selling_price,
				'discount' => $row->discount,
				'product_registration_date' => $row->create_date,
                'invoice' => $row->invoice,
                'expiry_date' => $row->expiry_date,
				'warranty_start_date' => $row->warranty_start_date,
				'warranty_end_date' => $row->warranty_end_date,
				'status' => $row->status,
				'product_demo_video' => $row->product_demo_video,
				'product_demo_audio' => $row->product_demo_audio,
				'product_user_manual' => $row->product_user_manual,
				'loyalty_points_earned' => $row->loyalty_points_earned,
                'invoice_image' => (!empty($row->invoice_image))?base_url($row->invoice_image):"",
                'product_id' => $row->id,
                'product_name' => $row->product_name,
                'product_sku' => $row->product_sku,
                'product_description' => $row->product_description,
				'product_demo_video_response_fbqq' => $row->product_demo_video_response_fbqq,
				'product_demo_audio_response_fbqq' => $row->product_demo_audio_response_fbqq,
            ];
            if (!empty($row->attribute_list)) {
                $attributesids = implode(',', json_decode($row->attribute_list, true));
                $item['attribute_list'] = $this->getAttributes($attributesids);
            }else{
                $item['attribute_list'] = [];
            }
			
			
			
            if (!empty($row->industry_data)) {
                $indIds = implode(',', json_decode($row->industry_data, true));
                $item['industry_data'] = $this->getIndustry($indIds);
            }else{
                $item['industry_data'] = [];
            }
            if(!empty($row->product_thumb_images)){
                $item['product_thumb_images'] = Utils::setFileUrl($row->product_thumb_images);
            }else{
                $item['product_thumb_images'] = '';
            }
			if(!empty($row->product_images)){
                $item['product_images'] = Utils::setFileUrl($row->product_images);
            }else{
                $item['product_images'] = '';
            }
			if(!empty($row->product_code_print_bg_images)){
                $item['product_code_print_bg_images'] = Utils::setFileUrl($row->product_code_print_bg_images);
            }else{
                $item['product_code_print_bg_images'] = '';
            }
			
            if(!empty($row->product_video)){
                $item['product_video'] = Utils::setFileUrl($row->product_video);
            }else{
                $item['product_video'] = '';
            }
            if(!empty($row->product_audio)){
                $item['product_audio'] = Utils::setFileUrl($row->product_audio);
            }else{
                $item['product_audio'] = '';
            }
            if(!empty($row->product_pdf)){
                $item['product_pdf'] = Utils::setFileUrl($row->product_pdf);
            }else{
                $item['product_pdf'] = '';
            }
			if(!empty($row->product_demo_video)){
                $item['product_demo_video'] = Utils::setFileUrl($row->product_demo_video);
				$bar_code = $row->bar_code;
				$isDemoVideoFeedbackGiven = $this->isDemoVideoFeedbackGiven($userId, $bar_code);
				$item['isDemoVideoFeedbackGiven'] = $isDemoVideoFeedbackGiven;
            }else{
                $item['product_demo_video'] = '';
            }
			if(!empty($row->product_demo_audio)){
                $item['product_demo_audio'] = Utils::setFileUrl($row->product_demo_audio);
				$bar_code = $row->bar_code;
				$isDemoAudioFeedbackGiven = $this->isDemoAudioFeedbackGiven($userId, $bar_code);
				$item['isDemoAudioFeedbackGiven'] = $isDemoAudioFeedbackGiven;
            }else{
                $item['product_demo_audio'] = '';
            }
			if(!empty($row->product_user_manual)){
                $item['product_user_manual'] = Utils::setFileUrl($row->product_user_manual);
            }else{
                $item['product_user_manual'] = '';
            }
			
            $items[] = $item;
        }
        if(!empty($productId)){
            return array_shift($items);
        }else{
            return $items;
        }
        
    }
	
	
	Public function isDemoVideoFeedbackGiven($userId, $bar_code) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$userId."' AND transaction_type='product_demo_video_response_lps'");
		//print $answerQuery;
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_qr_code'] == $bar_code)){                    
                  return "Given";
                }             
            }
        }
        //return false;
		return "Not Given";
    }
	
	Public function isDemoAudioFeedbackGiven($userId, $bar_code) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$userId."' AND transaction_type='product_demo_audio_response_lps'");
		//print $answerQuery;
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_qr_code'] == $bar_code)){                    
                  return "Given";
                }             
            }
        }
        //return false;
		return "Not Given";
    }
	
	
    public function getAttributes($ids) {
        $query = $this->db->select('a.name,p.name as value')
                ->from('attribute_name AS a')
                ->join('attribute_name AS p', 'p.parent=a.product_id')
                ->where('p.product_id IN (' . $ids . ')')
                ->get()
                ->result();
        return $query;
    }

    function getIndustry($ids) {
        $query = $this->db->select('categoryName AS industry')
                ->from('categories')
                ->where_in('category_Id', $ids)
                ->get()
                ->result();
        return $query;
    }

}
