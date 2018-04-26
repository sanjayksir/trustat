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

}
