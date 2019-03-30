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
        $data['title'] = 'List of recieved codes';
        $data['view'] = 'receive_codes_tpl';
        if (!empty($this->input->get('page_limit'))) {
            $limit = $this->input->get('page_limit');
        } else {
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search', null);
        list($data['total'], $data['items']) = $this->BarcodeInventoryModel->getBarcode($limit, $offset, $query,'Received');

        $data["links"] = Utils::pagination('barcode_inventory/receive_codes', $data['total']);
        $data['breadcrumb'] = [
            ['title' => 'Recieve Barcode Inventory', 'url' => null]
        ];
        $this->load->view('template', $data);
    }
	
	
	    public function link_code_with_batchid() {
        #Utils::debug();
		
		$barcodeDetailsByProductID = $this->BarcodeInventoryModel->permissionssss(217);
		
		
   
		/*
		//Print
		echo getProductIDbyProductCode('8pw-7956-5118-6');
		//print($barcodeDetailsByProductID);
		
		
		
		foreach ($barcodeDetailsByProductID as $key => $value) {
				echo $value->barcode_qr_code_no;
			}
			
			exit;
			*/
			
        $data['title'] = 'List Linked Codes with Batch Id Detailed';
        $data['view'] = 'link_code_with_batchid_tpl';
        if (!empty($this->input->get('page_limit'))) {
            $limit = $this->input->get('page_limit');
        } else {
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search', null);
        list($data['total'], $data['items']) = $this->BarcodeInventoryModel->getBarcodeswithBatchId($limit, $offset, $query,'Received');

        $data["links"] = Utils::pagination('barcode_inventory/link_code_with_batchid', $data['total']);
        $data['breadcrumb'] = [
            ['title' => 'Link Codes with Batch Id', 'url' => null]
        ];
        $this->load->view('template', $data);
    }
	
	public function all_barcode_inventory() {
        #Utils::debug();
        $data['title'] = 'List All Barcode Inventory';
        $data['view'] = 'all_barcode_inventory_tpl';
        if (!empty($this->input->get('page_limit'))) {
            $limit = $this->input->get('page_limit');
        } else {
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search', null);
        list($data['total'], $data['items']) = $this->BarcodeInventoryModel->getAllBarcode($limit, $offset, $query,'Received');

        $data["links"] = Utils::pagination('barcode_inventory/all_barcode_inventory', $data['total']);
        $data['breadcrumb'] = [
            ['title' => 'Barcode Inventory', 'url' => null]
        ];
        $this->load->view('template', $data);
    }
	

    public function addbarcode_transaction() {
       /*
	   $data['plants'] = $this->BarcodeInventoryModel->getAssignedPlant();
        foreach ($data['plants'] as $row) {
            $data['plantcontroller'][$row['plant_id']] = $row['plant_name'];
        }
		*/
		$data['locations'] = $this->BarcodeInventoryModel->getAssignedLocation();
        foreach ($data['locations'] as $row) {
            $data['locationcontroller'][$row['location_id']] = $row['location_name'];
        }
		
        $this->load->view('barcode_inventory/addbarcode_transaction', $data);
    }
	
	
	

	    public function addlinkcode_with_batchid_transaction() {
        $data['plants'] = $this->BarcodeInventoryModel->getAssignedPlant();
        foreach ($data['plants'] as $row) {
            $data['plantcontroller'][$row['plant_id']] = $row['plant_name'];
        }
		
		$data['locations'] = $this->BarcodeInventoryModel->getCCCLocation();
        foreach ($data['locations'] as $row) {
            $data['locationcontroller'][$row['location_id']] = $row['location_name'];
        }
		
        $this->load->view('barcode_inventory/addlinkcode_with_batchid_transaction_tpl', $data);
    }
	
    public function get_order() {
        $plantId = $this->input->post('plant_id', null);
        if (is_null($plantId)) {
            Utils::response(['status' => false, 'message' => 'Invalid plant id']);
        }
        $result = $this->db->get_where('order_master', ['plant_id' => $plantId])->result_array();
        if (empty($result)) {
            Utils::response(['status' => false, 'message' => 'Order is not associated.']);
        }
        $orders = array_column($result, 'order_tracking_number', 'order_id');

        Utils::response(['status' => true, 'data' => Utils::selectOptions('order_id', ['options' => $orders, 'empty' => 'Select Order'])]);
    }

    public function get_printed_order() {
        $orderId = $this->input->post('order_id', null);
        if (is_null($orderId)) {
            Utils::response(['status' => false, 'message' => 'Invalid order id']);
        }
        $result = $this->db->get_where('order_print_listing', ['order_id' => $orderId])->result_array();
        if (empty($result)) {
            Utils::response(['status' => false, 'message' => 'Still order is not printed.']);
        }
        //$orders = array_column($result, 'total_quantity','id');
        $optionVal = '<option value="">Select One</option>';
        foreach ($result as $row) {
            $optionVal .= '<option value="'.$row['id'].'">' . 'Printed Quantity ='.$row['last_printed_rows'].' | Total Quantity ='.$row['total_quantity'] . '</option>';
        }
        Utils::response(['status' => true, 'data' => $optionVal]);
    }
    public function get_printed_code() {
        $printId = $this->input->post('print_id', null);
        if (is_null($printId)) {
            Utils::response(['status' => false, 'message' => 'Invalid order id']);
        }
        $result = $this->db->get_where('printed_barcode_qrcode', ['print_id' => $printId])->result_array();
        if (empty($result)) {
            Utils::response(['status' => false, 'message' => 'Still order is not printed.']);
        }
        //$orders = array_column($result, 'total_quantity','id');
        $plantList = '';
        foreach ($result as $row) {
            $plantList .= '<label><input type="checkbox" name="printed_code[]" value="' . $row['barcode_qr_code_no'] . '" checked="checked" class="printedcode">' . $row['barcode_qr_code_no'] . '</label>&nbsp;';
        }
        Utils::response(['status' => true, 'data' => $plantList]);
    }

    public function save_transaction() {
        $post = $this->input->post();
        if (empty($post['plant_id'])) {
            Utils::response(['status' => false, 'message' => 'Please select plant.']);
        } elseif (empty($post['order_id'])) {
            Utils::response(['status' => false, 'message' => 'Please select order.']);
        } elseif (empty($post['printed_order'])) {
            Utils::response(['status' => false, 'message' => 'Please select printed order.']);
        }elseif (empty($post['printed_code'])) {
            Utils::response(['status' => false, 'message' => 'Please select printed code.']);
        }
        $stExQuery = $this->db->get_where('printed_barcode_qrcode','print_id="'.$post['printed_order'].'" AND stock_status ="'.trim($post['status_type']).'"');
        if($stExQuery->num_rows()){
            $statusExist = $stExQuery->row_array();
            Utils::response(['status' => false, 'message' => 'This order already has been '.trim($post['status_type'])]);
        }
        
        $barcodeDetails = $this->BarcodeInventoryModel->barcodeDetails($post['order_id']);
        
        $tData = [
            'trax_number' => Utils::randomNumber(6),
            'product_id' => $barcodeDetails['product_id'],
            'product_code' => $barcodeDetails['barcode_qr_code_no'],
            'order_id' => $post['order_id'],
            'order_number' => $barcodeDetails['order_no'],
            'order_date' => $barcodeDetails['created_date'],
            'print_date' => $barcodeDetails['modified_at'],
            'plant_id' => $barcodeDetails['plant_id'],
            'product_sku' => $barcodeDetails['product_sku'],
            'quantity' => $barcodeDetails['quantity'],
            'source_received_from' => $barcodeDetails['delivery_method'],
            'receive_date' => date("Y-m-d H:i:s"),
            'first_code_number' => current($post['printed_code']),
            'last_code_number' => end($post['printed_code']),
			'issue_location' => ($post['status_type'] == 'Issued')?$post['issue_location']:0,
            'status' => ($post['status_type'] == 'Received')?1:2
        ];
        if ($this->db->insert('transactions_codes', $tData)) {
            $this->db->update("printed_barcode_qrcode", ['stock_status' => $post['status_type'],'issue_location' => $post['issue_location'],'receive_date'=>date('Y-m-d H:i:s')], 'print_id ="'.$post['printed_order'].'"');
            Utils::response(['status' => true, 'message' => 'Transaction has been '.$post['status_type'].'.']);
        } else {
            
        }
    }
	
	
	public function save_link_code_with_batchid_mt() {
		$user_id 	= $this->session->userdata('admin_user_id');
        $post = $this->input->post();
		$last_code_number = getCodeIDbyProductCode($post['last_code_number']);
		$first_code_number = getCodeIDbyProductCode($post['first_code_number']);
        if (empty($post['first_code_number'])) {
            Utils::response(['status' => false, 'message' => 'Please Enter From Barcode.']);
        } elseif (empty($post['last_code_number'])) {
            Utils::response(['status' => false, 'message' => 'Please Enter To Barcode.']);
        } elseif (empty($post['batch_id'])) {
            Utils::response(['status' => false, 'message' => 'Please Enter Batch Id.']);
        }elseif (empty($post['batch_mfg_date'])) {
            Utils::response(['status' => false, 'message' => 'Please Enter Batch Mfg Date.']);
        } elseif ($first_code_number > $last_code_number) {
            Utils::response(['status' => false, 'message' => 'Please Enter The Codes in correct serial.']);
        }
		/*
        $stExQuery = $this->db->get_where('printed_barcode_qrcode','print_id="'.$post['printed_order'].'" AND stock_status ="'.trim($post['status_type']).'"');
        if($stExQuery->num_rows()){
            $statusExist = $stExQuery->row_array();
            Utils::response(['status' => false, 'message' => 'This order already has been '.trim($post['status_type'])]);
        }
		*/
		//getOrderIDbyCode($ProductCode);
        
        $barcodeDetails = $this->BarcodeInventoryModel->barcodeDetails(getOrderIDbyCode($post['first_code_number']));
		
		$quantity = $last_code_number - $first_code_number;
			
        $BatchID = Utils::randomNumber(6);
        $tData = [
            'batch_id' => $post['batch_id'],
            'product_id' => $barcodeDetails['product_id'],
            'product_name' => get_products_name_by_id($barcodeDetails['product_id']),
            'order_id' => $post['order_id'],
            'order_number' => $barcodeDetails['order_no'],
            'print_id' => $barcodeDetails['print_id'],
			'order_date' => $barcodeDetails['created_date'],
            'print_date' => $barcodeDetails['modified_at'],
            'location_id' => $barcodeDetails['plant_id'],
            'product_sku' => $barcodeDetails['product_sku'],
            'quantity' => $quantity,
            'batchid_assigned_by' => $user_id,
			'batchid_assign_date' => date('Y-m-d H:i:s'),
            'batch_mfg_date' => $post['batch_mfg_date'],			
            'first_code_number' => $post['first_code_number'],
            'last_code_number' => $post['last_code_number'],
			'issue_location' => $barcodeDetails['plant_id'],
            'status' => 1
        ];
        if ($this->db->insert('link_code_with_batchid_trans', $tData)) {
			
			
			$this->db->update("printed_barcode_qrcode", ['batch_id' => $post['batch_id'],'batch_mfg_date' => $post['batch_mfg_date']], 'id BETWEEN "'. $first_code_number .'" AND "'. $last_code_number .'" AND batch_id="" AND active_status="1"');
			
			
			/*
			$barcodeDetailsByProductID = $this->BarcodeInventoryModel->barcodeIDProductID(getProductIDbyProductCode($post['first_code_number']));
			//$first_code_number = null;
			/*
			foreach ($barcodeDetailsByProductID as $key => $value) {
				echo $key . ' contains ' . $value . '<br/>';
			}
			
			//for ($i = $first_code_number; $i <= $last_code_number; $i++){
				//for ($i = 0; $i < 10; $i++){
			foreach($barcodeDetailsByProductID as $key => $value){
				// if(strstr(strtolower($value->barcode_qr_code_no), $post['first_code_number'])){
            if((($value->id) == $first_code_number)){
                //$first_code_number = $list;
                //break;
				
				
		$this->db->update("printed_barcode_qrcode", ['batch_id' => $post['batch_id'],'batch_mfg_date' => $post['batch_mfg_date']], 'id ="'. $first_code_number .'"');
				 
				 
			//foreach($barcodeDetailsByProductID as $key => $value){
				// if(strstr(strtolower($value->barcode_qr_code_no), $post['last_code_number'])){
            if((($value->id) == $last_code_number)){
                //$last_code_number = $list;
                break;				
				
            }else{
                continue;
            }
			//}	
            }else{
                continue;
            }
			}
				//}
		
		*/
			
            Utils::response(['status' => true, 'message' => 'Activated Barcodes of the given range linked with Production Batch Id '.$post['batch_id'].'.']);
        } else {
            
        }
    }
	

    public function received_codes() {
        $data['title'] = 'List of recieved codes';
        $data['view'] = 'received_codes_tpl';
        if (!empty($this->input->get('page_limit'))) {
            $limit = $this->input->get('page_limit');
        } else {
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search', null);
        list($data['total'], $data['items']) = $this->BarcodeInventoryModel->getTransactionCodes($limit, $offset, $query);
        //echo "<pre>";print_r($data['items']);die;
        $data["links"] = Utils::pagination('barcode_inventory/received_codes', $data['total']);
        $data['breadcrumb'] = [
            ['title' => 'Recieve Barcode Inventory', 'url' => null]
        ];
        $this->load->view('template', $data);
    }
	
 public function list_assign_batchid_transactions() {
        $data['title'] = 'List Assign Batch Id Transactions';
        $data['view'] = 'list_assign_batchid_transactions_tpl';
        if (!empty($this->input->get('page_limit'))) {
            $limit = $this->input->get('page_limit');
        } else {
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search', null);
        list($data['total'], $data['items']) = $this->BarcodeInventoryModel->getTransactionAssignBatchIdtoCodes($limit, $offset, $query);
        //echo "<pre>";print_r($data['items']);die;
        $data["links"] = Utils::pagination('barcode_inventory/list_assign_batchid_transactions', $data['total']);
        $data['breadcrumb'] = [
            ['title' => 'List Assign Batch Id Transactions', 'url' => null]
        ];
        $this->load->view('template', $data);
    }

    public function issue_codes() {
        #Utils::debug();
        $data['title'] = 'List of issued codes';
        $data['view'] = 'issue_codes_tpl';
        if (!empty($this->input->get('page_limit'))) {
            $limit = $this->input->get('page_limit');
        } else {
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search', null);
        list($data['total'], $data['items']) = $this->BarcodeInventoryModel->getBarcode($limit, $offset, $query,'Issued');

        $data["links"] = Utils::pagination('barcode_inventory/issue_codes', $data['total']);
        $data['breadcrumb'] = [
            ['title' => 'Issued Barcode Inventory', 'url' => null]
        ];
        $this->load->view('template', $data);
    }
    public function issued_codes() {
        $data['title'] = 'List of Issued codes';
        $data['view'] = 'issued_codes_tpl';
        if (!empty($this->input->get('page_limit'))) {
            $limit = $this->input->get('page_limit');
        } else {
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $query = $this->input->get('search', null);
        list($data['total'], $data['items']) = $this->BarcodeInventoryModel->getTransactionCodes($limit, $offset, $query);
        //echo "<pre>";print_r($data['items']);die;
        $data["links"] = Utils::pagination('barcode_inventory/received_codes', $data['total']);
        $data['breadcrumb'] = [
            ['title' => 'Issued Barcode Inventory', 'url' => null]
        ];
        $this->load->view('template', $data);
    }
    
    public function barcode_order_status($id =null,$modal=null){
        if(is_null($id) || is_null($modal)){
            Utils::response(['status' => false, 'message' => 'Invalid request']);
        }
        
        if(strtolower($modal) == 'transactions' ){
            $this->db->query('UPDATE transactions_codes SET status = NOT status WHERE id='.trim($id));
        }elseif(strtolower($modal) == 'barcode' ){
            $this->db->query('UPDATE printed_barcode_qrcode SET active_status = NOT active_status WHERE id='.trim($id));
        }
        //echo $this->db->last_query();die;
        Utils::response(['status' => true, 'message' => 'Status changed successfully.']);
    }

}
?>

