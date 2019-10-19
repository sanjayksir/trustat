<?php
 class Myspidey_user_master_model extends CI_Model
 {
    function __construct()
    {
        parent::__construct();
     }
   
	function get_ownership($id)
    { 
		$this->db->select('*');
		$this->db->from('user_group_master');
		$this->db->where(array("status"=>'1'));
 		$this->db->order_by("usergroup_id", "ASC");
		$query = $this->db->get();
		//echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			 //$res = $res[0];
		}
		return $res;
  	}
	function get_user_details($id)
    { 
		$this->db->select('*');
		$this->db->from('backend_user');
		$this->db->where(array("status"=>'1', 'user_id'=>$id));
 		$query = $this->db->get();
		//echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			 //$res = $res[0];
		}
		return $res;
  	}
	 function save_user($frmData)
    { 
		$user_id 	=1;//$this->session->userdata('user_id');
 		$user_exists = $this->checkDuplicateUser($frmData['user_name']);
		if(!empty($user_exists)){
			return 2;
		}
		if(!empty($frmData['user_id'])){
			
			if(!empty($frmData['profile_photo'])){
 				$this->db->set('profile_photo', $frmData['profile_photo']);
			}
			$UpdateData = array(
			    "f_name"=>$frmData['f_name'],
			    "l_name"=>$frmData['l_name'],
				"customer_microsite_url"=>$frmData['customer_microsite_url'],
				"days_for_expiry_of_point_credited"=>$frmData['days_for_expiry_of_point_credited'],
				"days_for_notification_before_expiry_of_lps"=>$frmData['days_for_notification_before_expiry_of_lps'],
				"mobile_no"=>$frmData['user_mobile'],
				"email_id"=>$frmData['user_email'],
                "usergroup_id "=>$frmData['user_group'],
				"dept_id"=>$frmData['department'],
                "designation_id"=>$frmData['designation'],	
				"rwa_id "=>$frmData['rwa_name'],
				"last_updated_by"=>$user_id,
				"last_updated_on"=>date('Y-m-d H: i: s'),
 			);
			
			$whereData = array(
            	'user_id' => $frmData['user_id']
        	);
	
			$this->db->set($UpdateData);
			$this->db->where($whereData);
			if($this->db->update('backend_user')){
				// echo '***'.$this->db->last_query();exit;
				 $this->session->set_flashdata('success', 'Menu Updated Successfully!');
				 return 1;
			}
		}else{ 
			$insertData=array(
				"user_name"=>$frmData['user_name'],
				"mobile_no"=>$frmData['user_mobile'],
				"email_id"=>$frmData['user_email'],
				"profile_photo"=>$frmData['profile_photo'],
				"usergroup_id "=>$frmData['user_group'],
				"dept_id"=>$frmData['department'],
                "designation_id"=>$frmData['designation'],	
				"rwa_id "=>$frmData['rwa_name'],
				"created_by"=>$user_id,
				"created_on"=>date('Y-m-d H: i: s'),
				"status "=>'1',
				"is_admin "=>'1',
				"f_name"=>$frmData['f_name'],
			    "l_name"=>$frmData['l_name'],
				"customer_microsite_url"=>$frmData['customer_microsite_url'],
				"days_for_expiry_of_point_credited"=>$frmData['days_for_expiry_of_point_credited'],
			    "days_for_notification_before_expiry_of_lps"=>$frmData['days_for_notification_before_expiry_of_lps']
			
			);//echo '<pre>';print_r($insertData);exit;
			if($this->db->insert("backend_user", $insertData)){
				//echo $this->db->last_query();exit;
				$this->session->set_flashdata('success', 'User Added Successfully!');
				return 1;
			}
			return 0; 
		}
     }
	 
	 function checkDuplicateUser($username){
		$result = '';
	 	$this->db->select('user_id');
		$this->db->from('backend_user');
		$this->db->where(array('user_name'=>$username));
 		$query = $this->db->get();
		//echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0]['user_id'];
		}
		return $result;
	 }
	 
	 function checkEmail($email, $uid=''){
		$result = 'true';
 	 	$this->db->select('user_id');
		$this->db->from('backend_user');
		if(!empty($uid)){
			$this->db->where(array('user_id!='=>$uid));
		}
		$this->db->where(array('email_id'=>$email));
 		$query = $this->db->get();
		 //echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0]['user_id'];
			$result = 'false';
		}
		return $result;
	 }
	
  }