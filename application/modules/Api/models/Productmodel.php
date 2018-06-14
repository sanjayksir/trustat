<?php

class ProductModel extends CI_Model {

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
    public function barcodeProducts($barCodes = null) {
        if ($barCodes == null) {
            return false;
        }
        if(!is_array($barCodes)){
            $barCodes = explode(',', $barCodes);
        }
        
        $query = $this->db->select(['p.*','pbq.id AS pbq_id','pbq.active_status','pbq.pack_level','pbq.barcode_qr_code_no'])
                ->from('printed_barcode_qrcode AS pbq')
                ->join('products AS p', 'p.id=pbq.product_id')
                ->where('pbq.barcode_qr_code_no IN ("'.implode('", "',$barCodes).'")')
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
    public function feedbackQuestion($product=null,$type=null){
        if(is_null($product)){
            return [];
        }
        $query = $this->db->select('q.question_id,q.question,q.question_type,q.answer1,q.answer2,q.answer3,q.answer4,q.correct_answer')
                ->from('feedback_question_bank AS q')
                ->join('product_feedback_questions AS pq', 'pq.question_id=q.question_id','INNER')
                ->where('pq.product_id ="'.$product.'"')
                ->where('q.status =1')
                ->get()
                ->result();
        return $query;
        
    }
    
    
    public function feedbackLoylity($productId,$userId,$transactionType,$params){
        $productQuestion = $this->feedbackQuestion($productId);
        $typeGroup = [];$questionType = null;
        foreach($productQuestion as $row){
            if($row->question_id == $params['question_id']){
                $questionType = $row->question_type;
            }
            $typeGroup[$row->question_type][] = $row->question_id;
        }
        $questionTypeIds = $typeGroup[$questionType];
        if(!empty($questionTypeIds)){
            $answerQuery = $this->db->get_where('consumer_feedback','question_id IN ('.implode(',',$questionTypeIds).') AND user_id="'.$userId.'"');
            if(count($questionTypeIds) == $answerQuery->num_rows()){
                $this->saveLoylty($transactionType,$userId,$params);
            }
        }else{
            $answerQuery = $this->db->get_where('consumer_feedback',['product_id'=>$productId,'user_id'=>$userId]);
            if(count($productQuestion) <= 3){
                if(count($productQuestion) == $answerQuery->num_rows()){
                    $this->saveLoylty($transactionType,$userId,$params);
                }            
            }else{
                if(3 == $answerQuery->num_rows()){
                    $this->saveLoylty($transactionType,$userId,$params);
                }
            }    
        }
        
    }
    
    public function findLoylityBySlug($slug = null){
        $items = [];
        if(empty($slug)){
           return false; 
        }
        $query = $this->db->get_where('loylties',['transaction_type_slug'=>$slug]);
        if( $query->num_rows() <= 0 ){
            return false;
        }else{
            return $query->row_array();
        }
    }
    public function saveLoylty($transactionType = null,$userId = null,$params = []){
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
            'user_id' => $userId,
            'points' => $loylty['points'],
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

}
