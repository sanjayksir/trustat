<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode_inventory extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('BarcodeInventoryModel'));
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        //echo '***'.base64_decode($this->uri->segment(3));
        if (empty($user_id) || empty($user_name)) {
            redirect('login');
            exit;
        }
    }

    public function receive_codes() {
        #Utils::debug();
        $data['title'] = 'List of recieve codes';
        $data['view'] = 'receive_codes_tpl';
        if(!empty($this->input->get('page_limit'))){
            $limit = $this->input->get('page_limit');
        }else{
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search',null);
        list($data['total'],$data['items']) = $this->BarcodeInventoryModel->getBarcode($limit,$offset,$query);
        
        $data["links"] = Utils::pagination('barcode_inventory/receive_codes', $data['total']);
        $data['breadcrumb'] = [
            ['title'=>'Recieve Barcode Inventory','url'=>null]
        ];
        $this->load->view('template',$data);
    }
    
    public function addbarcode_transaction(){
        $data['plants'] = $this->BarcodeInventoryModel->getAssignedPlant();
        foreach($data['plants'] as $row){
            $data['plantcontroller'][$row['plant_id']] = $row['plant_name'];
        }
        $this->load->view('barcode_inventory/addbarcode_transaction',$data);
    }
    
    public function get_order(){
        $plantId = $this->input->post('plant_id',null);
        if(is_null($plantId)){
            Utils::response(['status'=>false,'message'=>'Invalid plant id']);
        }
        $result = $this->db->get_where('order_master',['plant_id'=>$plantId])->result_array();
        if(empty($result)){
            Utils::response(['status'=>false,'message'=>'Order is not associated.']);
        }
        $orders = array_column($result, 'order_tracking_number','order_id');
        
        Utils::response(['status'=>true,'data'=>Utils::selectOptions('order_id',['options'=>$orders,'empty'=>'Select Order'])]);
    }
    public function get_order_history(){
        $orderId = $this->input->post('order_id',null);
        if(is_null($orderId)){
            Utils::response(['status'=>false,'message'=>'Invalid order id']);
        }
        $result = $this->db->get_where('order_print_listing',['order_id'=>$orderId])->result_array();
        if(empty($result)){
            Utils::response(['status'=>false,'message'=>'Still order is not printed.']);
        }
        //$orders = array_column($result, 'total_quantity','id');
        $plantList = '';
        foreach($result as $row){
            $plantList .= '<label><input type="checkbox" name="printed[]" value="'.$row['id'].'">'.$row['total_quantity'].'</label>&nbsp;';
        }
        Utils::response(['status'=>true,'data'=>$plantList]);
    }
    
    public function save_transaction(){
        $post = $this->input->post();
        if(empty($post['plant_id'])){
            Utils::response(['status'=>false,'message'=>'Please select plant.']);
        }elseif(empty($post['order_id'])){
            Utils::response(['status'=>false,'message'=>'Please select order.']);
        }elseif(empty($post['printed'])){
            Utils::response(['status'=>false,'message'=>'Please select print.']);
        }
        $barcodeDetails = $this->BarcodeInventoryModel->barcodeDetails($post['order_id']);
        
        $tData = [
            'trax_number'=> Utils::randomNumber(6),
            'product_id' => $barcodeDetails['product_id'],
            'product_code' => $barcodeDetails['barcode_qr_code_no'], 
            'order_id' => $post['order_id'], 
            'order_number' => $barcodeDetails['order_no'], 
            'order_date' => $barcodeDetails['created_date'], 
            'print_date' => $barcodeDetails['modified_at'], 
            'plant_id' => $barcodeDetails['plant_id'], 
            'product_sku' => $barcodeDetails['product_sku'], 
            //'quantity' => $barcodeDetails[''], 
            'source_received_from' => $barcodeDetails['delivery_method'], 
            'receive_date' => date("Y-m-d H:i:s"), 
            'status' => 1
        ];
        if($this->db->insert('transactions_codes', $tData )){
            $this->db->update("printed_barcode_qrcode",['stock_status'=>$post['status_type']],'print_id IN ('.implode(',', $post['printed']).')');
            Utils::response(['status'=>true,'message'=>'Transaction has been received.']);
        }else{
            
        }
        
    }

    public function received_codes() {
        $data['title'] = 'List of recieved codes';
        $data['view'] = 'received_codes_tpl';
        if(!empty($this->input->get('page_limit'))){
            $limit = $this->input->get('page_limit');
        }else{
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search',null);
        list($data['total'],$data['items']) = $this->BarcodeInventoryModel->getTransactionCodes($limit,$offset,$query);
        
        $data["links"] = Utils::pagination('barcode_inventory/received_codes', $data['total']);
        $data['breadcrumb'] = [
            ['title'=>'Recieve Barcode Inventory','url'=>null]
        ];
        $this->load->view('template',$data);
    }
}
?>

