<?php

class Productmodel extends CI_Model {

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
        $query = $this->db->select(['p.*','pbq.id AS pbq_id','pbq.active_status','pbq.pack_level','pbq.barcode_qr_code_no'])
                ->from('printed_barcode_qrcode AS pbq')
                ->join('products AS p', 'p.id=pbq.product_id')
                ->where(['pbq.barcode_qr_code_no' => $barcode])
                ->get();
        //echo $this->db->last_query();die;
        //echo "<pre>";print_r($query);die;
        if ($query->num_rows() <= 0) {
            return false;
        }
        $items = $query->row();
        //echo "<pre>";print_r($items);die;
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
    public function productsByUser($userId = null,$limit=50,$offset=0) {
        if ($userId == null) {
            return false;
        }
        $query = $this->db->select(['p.*','pbq.id AS pbq_id','pbq.active_status','pbq.pack_level','pbq.barcode_qr_code_no'])
                ->from('printed_barcode_qrcode AS pbq')
                ->join('products AS p', 'p.id=pbq.product_id')
                ->where(['pbq.customer_id' => $userId])
                ->limit($limit,$offset)
                ->get()
                ->result();
        //echo $this->db->last_query();die;
        //echo "<pre>";print_r($query);die;
        if (empty($query)) {
            return false;
        }
        $items = [];
        foreach($query as $row){
            $item = [
                'pack_level' => $row->pack_level,
                'bar_code' => $row->barcode_qr_code_no,
                'active_status' => $row->active_status,
                'product_id' => $row->id,
                'product_name' => $row->product_name,
                'product_sku' => $row->product_sku,
                'product_description' => $row->product_description,
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
    public function viewInventory($userId = null,$limit=50,$offset=0) {
        if ($userId == null) {
            return false;
        }
        $query = $this->db->select(['p.*','pbq.id AS pbq_id','pbq.active_status','pbq.pack_level','pbq.barcode_qr_code_no','pi.id AS inventory_id','pi.customer_id','pi.plant_id','pi.created_at'])
                ->from('physical_inventory AS pi')
                ->join('printed_barcode_qrcode AS pbq','pbq.barcode_qr_code_no=pi.bar_code')
                ->join('products AS p', 'p.id=pbq.product_id')
                ->where(['pbq.customer_id' => $userId])
                ->limit($limit,$offset)
                ->get()
                ->result();
        //echo $this->db->last_query();die;
        //echo "<pre>";print_r($query);die;
        if (empty($query)) {
            return false;
        }
        $items = [];
        foreach($query as $row){
            $item = [
                'inventory_id' => $row->inventory_id,
                'plant_id' => $row->plant_id,
                'created_at' => $row->created_at,
                'pack_level' => $row->pack_level,
                'bar_code' => $row->barcode_qr_code_no,
                'active_status' => $row->active_status,
                'product_id' => $row->id,
                'product_name' => $row->product_name,
                'product_sku' => $row->product_sku,
                'product_description' => $row->product_description,
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
    public function barcodeProducts($barCodes = null, $userId = null) {
        if ($barCodes == null) {
            return false;
        }
        if(!is_array($barCodes)){
            $barCodes = explode(',', $barCodes);
        }
        $userParentId = getUserParentIDById($userId);
        $query = $this->db->select(['p.*','pbq.id AS pbq_id','pbq.active_status','pbq.pack_level','pbq.barcode_qr_code_no','pbq.product_id'])
                ->from('printed_barcode_qrcode AS pbq')
                ->join('products AS p', 'p.id=pbq.product_id')
				->where_in("pbq.active_status",1)
                ->where('pbq.barcode_qr_code_no IN ("'.implode('", "',$barCodes).'")')
				->where('p.created_by ="'.$userParentId.'"') 
                ->get()
                ->result();
        //echo $this->db->last_query();die;
      // echo print_r($query);die;
        if (empty($query)) {
            return false;
        }
        $items = [];
        foreach($query as $row){
            $item = [
                'pack_level' => $row->pack_level,
				'code_unity_type' => $row->code_unity_type,
                'bar_code' => $row->barcode_qr_code_no,
                'active_status' => $row->active_status,
				'created_by' => $row->created_by,
                'product_id' => $row->id,
                'product_name' => $row->product_name,
                'product_sku' => $row->product_sku,
                'product_description' => $row->product_description,
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
	
	public function ListfollowingCodes($barCodes = null, $userId = null, $product_id = null) {
        if ($barCodes == null) {
            return false;
        }
        if(!is_array($barCodes)){
            $barCodes = explode(',', $barCodes);
        }
        $userParentId = getUserParentIDById($userId);
        $query = $this->db->select('barcode_qr_code_no')
                ->from('printed_barcode_qrcode')
                //->join('products AS p', 'p.id=pbq.product_id')
				->where_in("active_status",1)
                //->where('pbq.barcode_qr_code_no IN ("'.implode('", "',$barCodes).'")')
				//->where('p.created_by ="'.$userParentId.'"') 
				//->where('product_id ="'.$product_id.'"', 'batch_id', "")
				->where('product_id ="'.$product_id.'" AND batch_id=""')
				//->where('batch_id', 0) 				
                ->get()
                ->result();
        //echo $this->db->last_query();die;
      // echo print_r($query);die;
        if (empty($query)) {
            return false;
        }
        $items = [];
        foreach($query as $row){
            $item = [
                'bar_code' => $row->barcode_qr_code_no,
                
            ];
           
           
            
            $items[] = $item;
        }
        return $items;
    }
	
	public function barcodeProductsInactive($barCodes = null, $userId = null) {
        if ($barCodes == null) {
            return false;
        }
        if(!is_array($barCodes)){
            $barCodes = explode(',', $barCodes);
        }
        $userParentId = getUserParentIDById($userId);
		$userParentId2 = getUserParentIDById($userParentId);
        $query = $this->db->select(['p.*','pbq.id AS pbq_id','pbq.active_status','pbq.pack_level','p.created_by','pbq.barcode_qr_code_no','pbq.product_id'])
                ->from('printed_barcode_qrcode AS pbq')
                ->join('products AS p', 'p.id=pbq.product_id')
				
                ->where('pbq.barcode_qr_code_no IN ("'.implode('", "',$barCodes).'")')
				//->or_where("p.created_by", getUserParentIDById($userId)) // Check if Customer is same
				 //->where('p.created_by ="'.getUserParentIDById($userId).'"')
				 ->where('p.created_by ="'.$userParentId.'" OR p.created_by="'.$userParentId2.'"') 
				 //->where('p.created_by ="'.$userParentId.'" OR status="'.$userParentId2.'"') 
                ->get()
                ->result();
        //echo $this->db->last_query();die;
        //echo "<pre>";print_r($query);//die;
        if (empty($query)) {
            return false;
        }
        $items = [];
        foreach($query as $row){
            $item = [
                'pack_level' => $row->pack_level,
				'code_unity_type' => $row->code_unity_type,
                'bar_code' => $row->barcode_qr_code_no,
                'active_status' => $row->active_status,
                'product_id' => $row->id,
                'product_name' => $row->product_name,
                'product_sku' => $row->product_sku,
				'created_by' => $row->created_by,
                'product_description' => $row->product_description,
				'min_shipper_pack_level' => $row->min_shipper_pack_level,
				'max_shipper_pack_level' => $row->max_shipper_pack_level,
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
    
    public function findScannedProducts($userid = null){
        if($userid == null){
            return false;
        }
        $query = $this->db->select("sp.bar_code,sp.latitude,sp.longitude,sp.created_at,pr.*")
                ->from($this->table.' AS sp')
                ->join('products AS pr', 'pr.id=sp.product_id')
                ->where(['sp.consumer_id' => $userid])
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
                'product_id' => $row->id,
                'bar_code' => $row->bar_code,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude,
                'created_at' => $row->created_at,
                'product_name' => $row->product_name,
                'product_sku' => $row->product_sku,
                'product_description' => $row->product_description,
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
    public function findPurchasedProducts($userId = null,$productId = null){
        if($userId == null){
            return false;
        }
        $conditions = ['pp.consumer_id' => $userId];
        if(!empty($productId)){
            $conditions['pp.product_id'] = $productId;
        }
        $query = $this->db->select("pp.id AS purchased_id,pp.bar_code,pp.ordered_date,pp.invoice,pp.invoice_image,pp.expiry_date,pr.*")
                ->from('purchased_product AS pp')
                ->join('products AS pr', 'pr.id=pp.product_id')
                ->where($conditions)
				->order_by('modified', 'desc')
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
                'ordered_date' => $row->ordered_date,
                'invoice' => $row->invoice,
                'expiry_date' => $row->expiry_date,
                'invoice_image' => (!empty($row->invoice_image))?base_url($row->invoice_image):"",
                'product_id' => $row->id,
                'product_name' => $row->product_name,
                'product_sku' => $row->product_sku,
                'product_description' => $row->product_description,
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
        if(!empty($productId)){
            return array_shift($items);
        }else{
            return $items;
        }
        
    }

    public function getAttributes($ids) {        
        if(empty($ids)){
            return;
        }
        if(is_array($ids) || strstr($ids,'Array')){
            return;
        }
        $query = $this->db->select('a.name,p.name as value')
                ->from('attribute_name AS a')
                ->join('attribute_name AS p', 'p.parent=a.product_id')
                ->where('p.product_id IN (' . $ids . ')')
                ->get()
                ->result();
        return $query;
    }

    function getIndustry($ids) {
        if(empty($ids)){
            return;
        }
        $query = $this->db->select('categoryName AS industry')
                ->from('categories')
                ->where_in('category_Id', $ids)
                ->get()
                ->result();
        return $query;
    }
    public function questionSets($product=null,$userId=null){
        if(is_null($product)){
            return [];
        }
        $query = $this->db->select('q.question_id,q.question,q.question_type,q.answer1,q.answer2,q.answer3,q.answer4,q.correct_answer')
                ->from('feedback_question_bank AS q')
                ->join('product_feedback_questions AS pq', 'pq.question_id=q.question_id','INNER')
                ->where('pq.product_id ="'.$product.'"')                
                ->where('q.status =1')
                ->where('q.question_id NOT IN (SELECT question_id FROM consumer_feedback as cf WHERE cf.user_id = "'.$userId.'")')
                ->get()
                ->result();
        return $query;
        
    }
    public function feedbackQuestion($product=null,$type=null){
        if(is_null($product)){
            return [];
        }
        $query = $this->db->select('q.question_id,q.question,q.question_type,q.answer1,q.answer2,q.answer3,q.answer4,q.correct_answer')
                ->from('feedback_question_bank AS q')
                ->join('product_feedback_questions AS pq', 'pq.question_id=q.question_id','INNER')
                ->where('pq.product_id ="'.$product.'"')
                ->where('q.status =1')
				->order_by('rand()')
				//->limit(3)
                ->get()
                ->result();
        return $query;
        
    }
    
    
    public function feedbackLoylity($transactionType, $params, $ProductID, $userId, $transactionTypeName, $transaction_lr_type, $mess, $customer_id){
       // $answerQuery = $this->db->get_where('loylty_points',"user_id='".$userId."'");
		 $answerQuery = $this->db->get_where('loylty_points',"user_id='".$userId."' AND transaction_type='".$transactionType."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_id'] == $params['product_id'])){
                    return false;
                }              
            }
        }
		$this->saveLoylty($transactionType, $params, $ProductID, $userId, $transactionTypeName, $transaction_lr_type, $customer_id);
		$this->saveConsumerPassbookLoyalty($transactionType, $params, $ProductID, $userId, $transactionTypeName, $transaction_lr_type, $customer_id);
		
		$id = getConsumerFb_TokenById($userId);
		
		$this->sendFCM($mess,$id);
		
		//$this->sendFCM2($transactionType,$id);
    }
	
	
	public function feedbackLoylityDemo($transactionType, $params, $ProductID, $userId, $transactionTypeName, $transaction_lr_type, $mess, $customer_id){
       // $answerQuery = $this->db->get_where('loylty_points',"user_id='".$userId."'");
		 $answerQuery = $this->db->get_where('loylty_points',"user_id='".$userId."' AND transaction_type='".$transactionType."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_qr_code'] == $params['product_qr_code'])){
                    return false;
                }              
            }
        }
		$this->saveLoylty($transactionType, $params, $ProductID, $userId, $transactionTypeName, $transaction_lr_type, $customer_id);
		$this->saveConsumerPassbookLoyalty($transactionType, $params, $ProductID, $userId, $transactionTypeName, $transaction_lr_type, $customer_id);
		
		$id = getConsumerFb_TokenById($userId);
		
		$this->sendFCM($mess,$id);
		
		//$this->sendFCM2($transactionType,$id);
    }
	
	
	public function sendFCM($mess,$id) {
$url = 'https://fcm.googleapis.com/fcm/send';

$fields = array (
        'to' => $id,
         
         'notification' => array('title' => 'howzzt notification', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
				  'data' => array('title' => 'howzzt notification', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
       
);
$fields = json_encode ( $fields );

$headers = array (
        'Authorization: key=' . "AAAA446l5pE:APA91bE3nQ0T5E9fOH-y4w_dkOLU1e9lV7Wn0OmVLaKNnE8tXcZ0eC3buduhCwHL1ICaJ882IHfLy-akAe7Nih7M1RewkO9IzAR-ELdPgmORtb7KjriRrQspVHkIb9GRZPOjXuqfPInlOAly5-65sEEUbGlcoujMgw",
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


public function sendFCM2($mess,$id) {
$url = 'https://fcm.googleapis.com/fcm/send';

$fields = array (
        'to' => $id,
         
         'notification' => array('title' => 't2', 'body' =>  $mess, 'sound'=>'Default', 'timestamp'=>date("Y-m-d H:i:s",time())),
		 'data' => array('title' => 'howzzt survey', 'body' =>  $mess, 'sound'=>'Default', 'content_available'=>true, 'priority'=>'high', 'timestamp'=>date("Y-m-d H:i:s",time()))
       
);
$fields = json_encode ( $fields );

$headers = array (
        'Authorization: key=' . "AAAA446l5pE:APA91bE3nQ0T5E9fOH-y4w_dkOLU1e9lV7Wn0OmVLaKNnE8tXcZ0eC3buduhCwHL1ICaJ882IHfLy-akAe7Nih7M1RewkO9IzAR-ELdPgmORtb7KjriRrQspVHkIb9GRZPOjXuqfPInlOAly5-65sEEUbGlcoujMgw",
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

	/*
	public function feedbackLoylityPassbook($transactionType, $transactionTypeName, $ProductID, $consumer_id, $params, $transaction_lr_type){
       $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumer_id."' AND transaction_type='".$transactionType."'");
	  //$answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumer_id."' AND transaction_type='".$transactionType."'");
        if($answerQuery->num_rows() > 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                 if(($paramsValue['product_id'] == 151)){                
                   return false;
                }             
            }
        }
        $this->saveConsumerPassbookLoyalty($transactionType, $transactionTypeName, $ProductID, $consumer_id, $params, $transaction_lr_type);
    }
    */
	/* new 
	public function feedbackLoylity($transactionType = null, $ProductID = null,$consumer_id = null,$params = [],$transaction_lr_type = null){
		/*
        if( empty($transactionType) || empty($userId) ){
            return false;
        }
        
        $loylty = $this->findLoylityBySlug($transactionType);
        if(empty($loylty)){
            return false;
        }
		
		
		
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result->$transactionType;
		
		
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $date->modify('+3    month');
        $input = [
            'customer_id' => $customer_id,
			'user_id' => $consumer_id,
            'points' => $TRPoints,
            'transaction_type' => $transactionType,
            'params' => json_encode($params),
            'status' => 1,
            'modified_at' => $now,
            'created_at' => $now,
            'date_expire' => $date->format('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('loylty_points',$input);
    }
	*/
	
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
	
	
	//$this->saveLoylty($transactionType, $params, $ProductID, $userId, $transactionTypeName, $transaction_lr_type);
    public function saveLoylty($transactionType = null, $params = [], $ProductID = null, $userId = null, $transactionTypeName = null, $transaction_lr_type = null, $customer_id = null){
      /* 
	   if( empty($transactionType) || empty($userId) ){
            return false;
        }
        
        $loylty = $this->findLoylityBySlug($transactionType);
        if(empty($loylty)){
            return false;
        }
		*/
		
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result->$transactionType;
		
		
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $date->modify('+3    month');
        $input = [
            'customer_id' => $customer_id,
			'user_id' => $userId,
            'points' => $TRPoints,
            'transaction_type' => $transactionType,
            'params' => json_encode($params),
            'status' => 1,
            'modified_at' => $now,
            'created_at' => $now,
            'date_expire' => $date->format('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('loylty_points',$input);
    }
	
	
	public function saveLoyltyProductReg($transactionType = null, $userId = null, $ProductID = null, $params = [], $customer_id = null){
      
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result->$transactionType;
		
		
        $date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
        $date->modify('+3    month');
        $input = [
			'customer_id' => $customer_id,
            'user_id' => $userId,
            'points' => $TRPoints,
            'transaction_type' => $transactionType,
            'params' => json_encode($params),
            'status' => 1,
            'modified_at' => $now,
            'created_at' => $now,
            'date_expire' => $date->format('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('loylty_points',$input);
    }
	
	public function saveLoyltyPassbook($transactionType = null,$userId = null,$params = []){
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
            'customer_id' => $customer_id,
			'user_id' => $userId,
            'points' => $loylty['loyalty_points'],
            'transaction_type' => $transactionType,
            'params' => json_encode($params),
            'status' => 1,
            'modified_at' => $now,
            'created_at' => $now,
            'date_expire' => $date->format('Y-m-d H:i:s')
        ];        
        return $this->db->insert('consumer_passbook',$input);
    }
	
	
	public function findCurrentBalanceByuserId($userId){
        //return $this->db->select('current_balance')->from('consumer_passbook')->where('consumer_id ="'.$userId.'"')->order_by('transaction_date',"desc")->limit(1)->get()->row();
    
	 //return $this->db->select('current_balance')->from('consumer_passbook')->where('consumer_id ="'.$userId.'"')->limit(1)->order_by('transaction_date','DESC')->get()->row();
	//$userId = 49;
			$this->db->select('current_balance');
			$this->db->from('consumer_passbook');
			$this->db->where('consumer_id', $userId);
			$this->db->order_by('transaction_date','DESC');
			$this->db->limit(1);			
			$query = $this->db->get();
			$result = $query->result();
			return $result;
			}
	
	/* old 
	public function saveConsumerPassbookLoyalty($transactionType = null,$userId = null,$params = [],$transaction_lr_type = null){
        if( empty($transactionType) || empty($userId) ){
            return false;
        }
        
        $loylty = $this->findLoylityBySlug($transactionType);
        if(empty($loylty)){
            return false;
        }
		$TCurrentBalance = $this->findCurrentBalanceByuserId($userId);
		
		//echo $CurrentBalance[0]['current_balance'];
		
		foreach($TCurrentBalance as $row){
			//echo $row['current_balance'];
			// $row->current_balance;
		$CurrentBalance1 = $row->current_balance;
		$CurrentBalance2 = $loylty['loyalty_points'];
		$CurrentBalance = $CurrentBalance1+$CurrentBalance2;
		
		$date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
       // $date->modify('+3    month');
        $input = [
			'customer_id' => $customer_id,
            'consumer_id' => $userId,
            'points' => $loylty['loyalty_points'],
            'transaction_type_name' => $loylty['transaction_type'],
			'transaction_type_slug' => $loylty['transaction_type_slug'],
            'params' => json_encode($params),
            'transaction_lr_type' => $transaction_lr_type,
            'current_balance' => $CurrentBalance,
            'transaction_date' => $now
        ];
        
        return $this->db->insert('consumer_passbook',$input);
		}
    }
	*/
	
	
	//$this->saveConsumerPassbookLoyalty($transactionType, $params, $ProductID, $userId, $transactionTypeName, $transaction_lr_type);
	public function saveConsumerPassbookLoyalty($transactionType = null, $params = [], $ProductID = null, $userId = null, $transactionTypeName = null,  $transaction_lr_type = null, $customer_id = null){
          
		/*
		if( empty($transactionType) || empty($consumer_id) ){
            return false;
        } 
       $loylty = $this->findLoylityBySlugAndProductID($transactionType,$ProductID);
        if(empty($loylty)){
            return false;
        }
		*/
		
		// Find Current transuction type
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result->$transactionType;
		
		$TotalAccumulatedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$userId, 'transaction_lr_type'=>"Loyalty"))->get()->row();
		$TotalRedeemedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$userId, 'transaction_lr_type'=>"Redemption"))->get()->row();
		
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
			'consumer_id' => $userId,
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
	
	
	public function saveConsumerPassbookLoyaltyProductReg($transactionType = null, $params = [], $customer_id = null, $ProductID = null, $userId = null, $transactionTypeName = null,  $transaction_lr_type = null){
          
		/*
		if( empty($transactionType) || empty($consumer_id) ){
            return false;
        } 
       $loylty = $this->findLoylityBySlugAndProductID($transactionType,$ProductID);
        if(empty($loylty)){
            return false;
        }
		*/
		
		// Find Current transuction type
		$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
		$TRPoints = $result->$transactionType;
		
		$TotalAccumulatedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$userId, 'transaction_lr_type'=>"Loyalty"))->get()->row();
		$TotalRedeemedPoints = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$userId, 'transaction_lr_type'=>"Redemption"))->get()->row();
		
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
            'consumer_id' => $userId,
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
	
	public function saveConsumerPassbookLoyaltyReg($transactionType = null,$userId = null,$params = [],$transaction_lr_type = null){
        if( empty($transactionType) || empty($userId) ){
            return false;
        }
        
        $loylty = $this->findLoylityBySlug($transactionType);
        if(empty($loylty)){
            return false;
        }
		$TCurrentBalance = $this->findCurrentBalanceByuserId($userId);
		
		//echo $CurrentBalance[0]['current_balance'];
		
		
		$CurrentBalance = $loylty['loyalty_points'];
		
		$result2 = $this->db->select('*')->from('loylties')->where('id', 3)->get()->row();
		$result3 = $this->db->select('*')->from('loylties')->where('id', 4)->get()->row();
		
		
		$FinalTotalAccumulatedPoints = $CurrentBalance;
		$FinalTotalRedeemedPoints = 0;
		
		
		$Min_Locking_Balance = $result2->loyalty_points;
		
		$CurrentBalanceAfterMinBalanceLocking = $CurrentBalance - $Min_Locking_Balance;
		$Points_Redeemed_in_Multiple_of = $result3->loyalty_points;
				
		$remainder = $CurrentBalanceAfterMinBalanceLocking % $Points_Redeemed_in_Multiple_of;
		$quotient = ($CurrentBalanceAfterMinBalanceLocking - $remainder) / $Points_Redeemed_in_Multiple_of;

		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of - $remainder;
		
		
		$date = new DateTime();
        $now = $date->format('Y-m-d H:i:s');
       // $date->modify('+3    month');
        $input = [
            'customer_id' => 1,			
			'consumer_id' => $userId,
            'points' => $loylty['loyalty_points'],
            'transaction_type_name' => "User Registration",
			'transaction_type_slug' => $transactionType,
            'params' => json_encode($params),
            'transaction_lr_type' => $transaction_lr_type,
			'total_accumulated_points' => $loylty['loyalty_points'],
			'total_redeemed_points' => 0,
            'current_balance' => $CurrentBalance,
			'points_redeemable' => $Points_Redeemable,
			'points_short_of_redumption' => $PointsShortOfRedumption,
            'transaction_date' => $now	
			
        ];
        
        return $this->db->insert('consumer_passbook',$input);
		
    }
	
	public function saveLoyltyReg($transactionType = null,$userId = null,$params = []){
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
	
    
    public function userLoylty($userId=null){
        if(empty($userId)){
            return [];
        }
        $query = $this->db->select('id,id AS transaction_type_id,user_id,points,transaction_type,transaction_type AS transaction_type_name,params,date_expire,created_at,modified_at')
                ->from('loylty_points')
                ->where('user_id ="'.$userId.'"')
                ->where('status =1')
                ->get();
        if( $query->num_rows() <= 0 ){
            return [];
        }
        $result = $query->result();
        $items = array_map(function($obj){
            $obj->params = json_decode($obj->params);
            return $obj;
        }, $result);
        return $items;
        
    }
    
    public function getRedemption($userId){
        if(empty($userId)){
            return false;
        }
        $query = $this->db->select('lr.aadhaar_number,lr.alternate_mobile_no,lr.city,lr.state,lr.street_address,lr.pin_code,lr.points_redeemed,lr.coupon_number,lr.coupon_type,lr.coupon_vendor,lr.courier_details,lr.l_status,lr.l_created_at')
                ->from('loyalty_redemption AS lr')
                ->join('consumers as c','c.id=lr.user_id')
                ->where('user_id ="'.$userId.'"')
				->order_by('l_created_at', 'desc')
                ->get();
        if( $query->num_rows() <= 0 ){
            return [];
        }
        $result = $query->result_array();
        return $result;
    }
	
    public function getComplaints($userId){
        if(empty($userId)){
            return false;
        }
        $query = $this->db->select('P.product_name, lr.*, c.user_name')
                ->from('consumer_complaint AS lr')
                ->join('consumers as c','c.id=lr.consumer_id')
				->join('products as P','P.id=lr.product_id')
                ->where('consumer_id ="'.$userId.'"')
				->order_by('lr.created_at', 'desc')
                ->get();
        if( $query->num_rows() <= 0 ){
            return [];
        }
        $result = $query->result_array();
        return $result;
    }
	
	
	    public function getConsumerNotifications($userId){
        if(empty($userId)){
            return false;
        }
        $query = $this->db->select('*')
                ->from('list_notifications_table')
                //->join('consumers as c','c.id=lr.consumer_id')
				//->join('products as P','P.id=lr.product_id')
                ->where('consumer_id ="'.$userId.'"')
				->order_by('id', 'desc')
                ->get();
        if( $query->num_rows() <= 0 ){
            return [];
        }
        $result = $query->result_array();
        return $result;
    }
	
	
	   public function getResponsesOnComplaint($complaint_id){
        if(empty($complaint_id)){
            return false;
        }
        $query = $this->db->select('*')
                ->from('consumer_complaint_reply')
                //->join('consumers as c','c.id=lr.consumer_id')
				//->join('products as P','P.id=lr.product_id')
                ->where('complaint_id ="'.$complaint_id.'"')
				//->order_by('lr.id', 'desc')
                ->get();
        if( $query->num_rows() <= 0 ){
            return [];
        }
        $result = $query->result_array();
        return $result;
    }
	
	/*
	public function getConsumerPassBook($userId){
        if(empty($userId)){
            return false;
        }
        $query = $this->db->select('*')
                ->from('consumer_passbook')
               // ->join('consumers as c','c.id=lr.user_id')
                ->where('consumer_id ="'.$userId.'"')
				->order_by('transaction_date', 'desc')
				->get();
        if( $query->num_rows() <= 0 ){
            return [];
        }
        $result = $query->result_array();
        return $result;
    }
	*/
	
	public function getConsumerPassBook($userId=null){
        if(empty($userId)){
            return [];
        }
        $query = $this->db->select('*')
                ->from('consumer_passbook')
                ->where('consumer_id ="'.$userId.'"')
				->order_by('transaction_date', 'desc')
               // ->where('status =1')
                ->get();
        if( $query->num_rows() <= 0 ){
            return [];
        }
        $result = $query->result();
        $items = array_map(function($obj){
            $obj->params = json_decode($obj->params);
            return $obj;
        }, $result);
        return $items;
        
    }
	
	
	Public function isPackLevelSeted($bar_code=null, $parent_bar_code=null) {
		// $answerQuery = $this->db->get_where('packaging_codes_pcr', array('bar_code' => $bar_code, 'parent_bar_code' => $parent_bar_code));
        $answerQuery = $this->db->get_where('packaging_codes_pcr', array('bar_code' => $bar_code));
		//print $answerQuery;
        if($answerQuery->num_rows() < 1){
           return true;
        }
		//return false;
    }
	
	Public function isPackLevelSetedExits($bar_code=null, $parent_bar_code=null) {
        $answerQuery = $this->db->get_where('packaging_codes_pcr', array('bar_code' => $bar_code, 'parent_bar_code' => $parent_bar_code));
		//print $answerQuery;
        if($answerQuery->num_rows() > 0){
           return true;
        }
		//return false;
    }
	
	
	Public function isItemAlreadyExists($bar_code=null) {
        $answerQuery = $this->db->get_where('dispatch_stock_transfer_out', array('bar_code' => $bar_code));
		//print $answerQuery;
        if($answerQuery->num_rows() < 1){
           return true;
        }
		//return false;
    }
	
	Public function isItemAlreadyExistsStockIn($bar_code=null) {
        $answerQuery = $this->db->get_where('receipt_stock_transfer_in', array('bar_code' => $bar_code));
		//print $answerQuery;
        if($answerQuery->num_rows() < 1){
           return true;
        }
		//return false;
    }
	
	

	
	Public function isItemAlreadyExistsInInventory($bar_code=null) {
        $answerQuery = $this->db->get_where('physical_inventory_check', array('bar_code' => $bar_code));
		//print $answerQuery;
        if($answerQuery->num_rows() < 1){
           return true;
        }
		//return false;
    }
	
	
	Public function isAnyChildAdded($bar_code=null) {
        $answerQuery = $this->db->get_where('packaging_codes_pcr', array('parent_bar_code' => $bar_code));
		//print $answerQuery;
        if($answerQuery->num_rows() < 1){
           return true;
        }
		//return false;
    }
	
	
	public function location_type_master(){
        $items = [];
        $query = $this->db->select('*')->from('location_type_master')->get();
        if($query->num_rows() <= 0){
            return false;
        }
        return $query->result_array();
    }
	
	public function location_master($ParentuserId){
        $items = [];
		$query = $this->db->select('*')->from('location_master')->where('created_by', $ParentuserId)->get();
       // $query = $this->db->select('*')->from('location_master')->get();
        if($query->num_rows() <= 0){
            return false;
        }
        return $query->result_array();
    }
	
	public function PhysicalInventoryOnHand($ParentuserId){
        $items = [];
		//$query = $this->db->select('*')->from('inventory_on_hand')->where('created_by_parent_id', $ParentuserId)->get();
       // $query = $this->db->select('*')->from('location_master')->get();
	   /*
	   $this->db->select(' C.*, P.product_name, P.product_sku, P.product_description, P.created_by',false);
		$this->db->from('inventory_on_hand C');
		//$this->db->join('packaging_codes_pcr S', 'C.id = S.consumer_id');
		$this->db->join('products P', 'P.id = C.product_id');
		$this->db->where(array('P.created_by' => $ParentuserId));
   		$this->db->order_by('C.update_date','desc');
		*/
		 $query = $this->db->select(' C.*, P.product_name, P.product_sku, P.product_description, P.created_by, lm.location_name',false)
                ->from('inventory_on_hand C')
				->join('location_master AS lm','lm.location_id=C.location_id')
                ->join('products P', 'P.id = C.product_id')
				//->where_in("pbq.active_status",1)
                ->where(array('P.created_by' => $ParentuserId))
				->order_by('C.update_date','desc') 
                ->get();
		
        if($query->num_rows() <= 0){
            return false;
        }
        return $query->result_array();
    }
	
	
	Public function isProductExistsinLocation($product_id=null,$location_id=null,$code_packaging_level=null) {
       // $answerQuery = $this->db->get_where('inventory_on_hand', array('product_id' => $data['product_id'], 'location_id' => $data['location_id']));
		$answerQuery = $this->db->get_where('inventory_on_hand', array('product_id' => $product_id, 'location_id' => $location_id, 'code_packaging_level' => $code_packaging_level));
		//print $answerQuery;
        if($answerQuery->num_rows() > 0){
           return true;
        }
		//return false;
    }
	
	Public function isProductExistsinLocationSummery($product_id=null,$location_id=null,$code_packaging_level=null) {
       // $answerQuery = $this->db->get_where('physical_inventory_summary', array('product_id' => $data['product_id'], 'location_id' => $data['location_id']));
		$answerQuery = $this->db->get_where('physical_inventory_summary', array('product_id' => $product_id, 'location_id' => $location_id, 'pack_level' => $code_packaging_level));
		//print $answerQuery;
        if($answerQuery->num_rows() > 0){
           return true;
        }
		//return false;
    }
	
}
