<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Barcode_inventory extends MX_Controller {
      public function __construct() { 
        parent::__construct();
 		$this->load->model(array('Barcode_inventory_model'));
  		$this->load->helper(array('common_functions_helper'));
   		$user_id 	= $this->session->userdata('admin_user_id');
 		$user_name 	= $this->session->userdata('user_name');
		$this->load->library('pagination');
		
		//echo '***'.base64_decode($this->uri->segment(3));
 		if(empty($user_id) || empty($user_name)){
 			redirect('login');	exit;
		}
      }
	  
      
	 
	 
     public function received_codes() {
       
        $this->load->view('received_codes_tpl');
    }

    public function receive_codes() {
       
        $this->load->view('receive_codes_tpl');
    }
	
	public function issued_codes() {
       
        $this->load->view('issued_codes_tpl');
    }
	
	public function issue_codes() {
       
        $this->load->view('issue_codes');
    }
	 
	 
	
	 
	 
     
	 

 	

 	   public function checkUnameEmail(){
 		$uid = $this->input->post('userid');

	  	$email = $this->input->post('user_email');

		$isExists = $this->plant_master_model->checkEmail($email,$uid);

		echo $isExists;exit;	

	  }
	  
	  
	  
	  
	   
	 
	 
	 
	 
	 
	   
	 
		 
		
		 
		 
		
		 
 		 
		
		
	 
	 
	 
	 
	 
	 
	  
		
		
		
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
   }?>

