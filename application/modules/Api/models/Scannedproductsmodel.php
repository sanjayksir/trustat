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
        $query = $this->db->select('p.*,pbq.pack_level')
                ->from('printed_barcode_qrcode AS pbq')
                ->join('products AS p', 'p.id=pbq.product_id')
                ->where(['pbq.barcode_qr_code_no' => $barcode,'pbq.active_status'=>1])
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
	// check if the product code is registered or not 
	
    Public function isProductRegistered($bar_code_data) {
        $query = $this->db->get_where('purchased_product', array('bar_code' => $bar_code_data));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();            
            return $data;
        } else {
            return false;
        }
    }

	// checking if the Loyalty given to the user on Video type questions on code 
    Public function isLoyaltyForVideoFBQuesGiven($bar_code_data, $consumerId) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='Scan for Genuity and Video Response'");
        if($answerQuery->num_rows() >= 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_qr_code'] == $bar_code_data)){
                    $row->params = $paramsValue;
                    return $row;
                }                
            }
        }
        return false;
    }
	
		// checking if the Loyalty given to the user on Audio type questions on code 
    Public function isLoyaltyForAudioFBQuesGiven($bar_code_data, $consumerId) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='Scan for Genuity and Audio Response'");
        if($answerQuery->num_rows() >= 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_qr_code'] == $bar_code_data)){
                    $row->params = $paramsValue;
                    return $row;
                }                
            }
        }
        return false;
    }
	
		// checking if the Loyalty given to the user on Image type questions on code 
    Public function isLoyaltyForImageFBQuesGiven($bar_code_data, $consumerId) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='Scan for Genuity and Video Response'");
        if($answerQuery->num_rows() >= 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_qr_code'] == $bar_code_data)){
                    $row->params = $paramsValue;
                    return $row;
                }                
            }
        }
        return false;
    }
	
			// checking if the Loyalty given to the user on PDF type questions on code 
    Public function isLoyaltyForPDFFBQuesGiven($bar_code_data, $consumerId) {
        $answerQuery = $this->db->get_where('loylty_points',"user_id='".$consumerId."' AND transaction_type='Scan for Genuity and pdf Response'");
        if($answerQuery->num_rows() >= 0){
            $dataItems = $answerQuery->result();
            foreach($dataItems as $row){
                $paramsValue = json_decode($row->params,true);                
                if(($paramsValue['product_qr_code'] == $bar_code_data)){
                    $row->params = $paramsValue;
                    return $row;
                }                
            }
        }
        return false;
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
        $query = $this->db->select("pp.id AS purchased_id,pp.bar_code,pp.ordered_date,pp.invoice,pp.invoice_image,pp.expiry_date,pp.warranty_start_date,pp.warranty_end_date,pr.*")
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
				'warranty_start_date' => $row->warranty_start_date,
				'warranty_end_date' => $row->warranty_end_date,
				'product_demo_video' => $row->product_demo_video,
				'product_demo_audio' => $row->product_demo_audio,
				'product_user_manual' => $row->product_user_manual,
				'loyalty_points_earned' => '10',
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
			if(!empty($row->product_demo_video)){
                $item['product_demo_video'] = Utils::setFileUrl($row->product_demo_video);
            }else{
                $item['product_demo_video'] = '';
            }
			if(!empty($row->product_demo_audio)){
                $item['product_demo_audio'] = Utils::setFileUrl($row->product_demo_audio);
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
