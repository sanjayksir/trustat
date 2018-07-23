<?php

class BarcodeInventoryModel extends CI_Model {

    function __construct() {
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

    public function validDate($value) {
        $valid = Utils::validDate($value, 'Y-m-d');
        if (!$valid) {
            $this->form_validation->set_message('date', '%s is not valid.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function countAll($query) {
        $sqlString = str_replace(array("\n", "\r"), ' ', $query);
        $query = '';
        if (preg_match('/FROM\s(.*)\sORDER/i', $sqlString, $match) == 1) {
            $query = $match[1];
        }
        $sql = $this->db->query('SELECT COUNT(*) AS numrows FROM '.$query);
        return $sql->row()->numrows;
    }

    public function findBy($table, $conditions = []) {
        $query = $this->db->get_where($table, $conditions)->row();
        if (empty($query)) {
            return false;
        }
        return $query;
    }

    public function getTransactionCodes($limit, $offset, $keyword = null) {
        $this->db->select(['tc.id','tc.trax_number','tc.product_id', 'tc.product_code', 'tc.id AS transaction_id', 'tc.trax_number', 'tc.order_number', 'tc.order_date', 'tc.print_date', 'tc.plant_id', 'tc.product_sku', 'tc.quantity', 'tc.source_received_from', 'tc.receive_date', 'tc.status', 'tc.order_id']);
        $this->db->from('transactions_codes AS tc');
        if (!empty($keyword)) {
            $this->db->where('tc.product_sku LIKE "%'.$keyword.'%" OR tc.product_code LIKE "%'.$keyword.'%"');
        }
        $this->db->group_by('tc.id');
        $this->db->limit($limit, $offset);
        $this->db->order_by('tc.id', 'DESC');
        $query = $this->db->get();
        $items = $query->result_array();
        $total = $this->countAll($this->db->last_query());
        //echo "<pre>";print_r($query);die;
        $items = $query->result_array();
        return [$total, $items];
    }

    public function getBarcode($limit, $offset, $keyword = null,$status=null) {
        $user_id = $this->session->userdata('admin_user_id');
        $this->db->select(['pbq.plant_id', 'om.product_sku', 'pbq.barcode_qr_code_no', 'om.order_no', 'om.created_date', 'pbq.modified_at', 'p.delivery_method', 'pbq.receive_date', 'pbq.stock_status', 'pbq.active_status']);
        $this->db->from('printed_barcode_qrcode AS pbq');
        $this->db->join('transactions_codes AS tc', 'tc.product_code=pbq.barcode_qr_code_no','left');
        $this->db->join('products AS p', 'p.id=pbq.product_id');
        $this->db->join('order_master AS om', 'om.order_id=pbq.order_id');
        $this->db->where('pbq.plant_id in (SELECT plant_id from assign_plants_to_users WHERE user_id="'.$user_id.'")');
        if(!empty($status)){
            $this->db->where('pbq.stock_status="'.$status.'"');
        }
        if (!empty($keyword)) {
            $this->db->where('om.product_sku LIKE "%'.$keyword.'%" OR pbq.barcode_qr_code_no LIKE "%'.$keyword.'%"');
        }
        
        $this->db->limit($limit, $offset);
        $this->db->order_by('pbq.id', 'DESC');
        $query = $this->db->get();
        $total = $this->countAll($this->db->last_query());
        //echo "<pre>";print_r($query);die;
        $items = $query->result_array();
        return [$total, $items];
    }
    public function barcodeDetails($orderId) {
        $this->db->select(['pbq.plant_id','pbq.product_id', 'om.product_sku', 'pbq.barcode_qr_code_no', 'om.order_no','om.quantity', 'om.created_date', 'pbq.modified_at', 'p.delivery_method', 'pbq.stock_status', 'pbq.active_status']);
        $this->db->from('printed_barcode_qrcode AS pbq');
        $this->db->join('products AS p', 'p.id=pbq.product_id');
        $this->db->join('order_master AS om', 'om.order_id=pbq.order_id');
        $this->db->where(['pbq.order_id'=>$orderId]);
        $query = $this->db->get();
        $items = $query->row_array();        
        //echo $this->db->last_query();die(' END');
        return $items;
    }

    public function getAssignedPlant($userId = null) {
        if (is_null($userId)) {
            $userId = $this->session->userdata('admin_user_id');
        }
        $this->db->select(['pm.plant_id', 'pm.plant_code', 'pm.plant_name']);
        $this->db->from('plant_master AS pm');
        $this->db->join('assign_plants_to_users AS ap', 'ap.plant_id=pm.plant_id');
        $this->db->where(['ap.status' => 1, 'ap.user_id' => $userId]);
        $sql = $this->db->get();
        $items = [];
        if ($sql->num_rows() > 0) {
            $items = $sql->result_array();
        }
        return $items;
    }

}
