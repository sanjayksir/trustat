<?php

class Home_model extends CI_Model {
     function __construct() {
        parent::__construct();
    }
 
	##======================By Kamal ============================##
	 
 	function check_validate2(){
		/*$userId = $_POST['userID'];
		$this->db->select('*');
		$this->db->from('buzz_user');
		$this->db->where(array('status'=>1, 'user_email_phone'=>$userId));
 		$query = $this->db->get(); echo '**'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			
			$res = $query->result_array();
 		}
		return $res;*/
	}
	
	function check_validate(){  echo 'kam';exit;
		 
	}
	 
	 
 }
