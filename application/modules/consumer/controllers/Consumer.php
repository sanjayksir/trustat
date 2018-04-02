<?php
 class Consumer extends MX_Controller {
     function __construct() {
         parent::__construct();
         $this->load->model('Product_model');
		 $this->load->helper('common_functions_helper');
     }
	  function checklogin(){
 		$user_id 	= $this->session->userdata('admin_user_id');
 		$user_name 	= $this->session->userdata('user_name');
 		if(empty($user_id) && $user_id!=1){
 			redirect(base_url().'login');	exit;
 		}
 	}
     function consumer_list() {
		 $data = array();
		 $this->checklogin();
        // $data['get_attr'] = $this->Product_model->getAttributeList();
 		 $this->load->view('order_list', $data);
     }

   

      function barcode_scanned() {
		 $data = array();
		 $this->checklogin();
        // $data['get_attr'] = $this->Product_model->getAttributeList();
 		 $this->load->view('order_list', $data);
     }
	 
 
}

