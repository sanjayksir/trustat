<?php

 
class Register_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
		 $this->load->database();
    }
    
	 
   function cites($id){
	   
	   $this->db->select('city_id,city_name')
                    ->from('city')
                    ->where('state_id',$id)
                    ->order_by('created_on', 'DESC');
      $res = $this->db->get()->result_array();
	 
	  return $res;
   }
   
   /*
 * function to add new inbreif
 */
    function update_register($id,$params)
    {
       
	    $this->db->where('user_id',$id);
       if($this->db->update('buzz_user',$params))
		   {
			   //echo '**********'.$this->db->last_query();exit;
        return true;
      }
      else
      {
        return false;
      }
		//echo $this->db->last_query();exit;
        
    }
	 function get_userx($id)
    {
       
	  $this->db->where('user_id',$id);
      return $this->db->get('buzz_user')->result_array();
	  //echo $this->db->last_query();exit;
    }
	
	function reset_password($frmData='')
	{
		$password = $frmData['password'];
		$user_id 	= $this->session->userdata('user_id');
		$ArrData 		= array("password"=>md5($password));
		$whereData 		= array("user_id"=>$user_id);
 		$this->db->set($ArrData);
        $this->db->where($whereData);
        $query2 		= $this->db->update('buzz_user'); 
		//echo '***'.$this->db->last_query();exit;
		if($query2){
			echo  '1' ;exit;
		}echo  '0';exit;
 	}
	
	function check_validate($userID){
		
			$this->db->select('count(1) as cnt');
			$this->db->from('buzz_user');
			$this->db->where(array('status'=>1, 'user_email_phone'=>$userID));
			$query = $this->db->get();   
			$result=$query->result_array();
			//echo '***'.$this->db->last_query();exit;
			$cnt = $result[0]['cnt'];
			if($cnt==0)
			{
			return 0;			
			}else{
			$this->db->select('*');
			$this->db->from('buzz_user');
			$this->db->where(array('status'=>1, 'user_email_phone'=>$userID));
			$query = $this->db->get();   
			$result=$query->result_array();
			//echo '***'.$this->db->last_query();exit;
				return $result;
				
			}
		
	}
	 
	
	function validateEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	function validatePhone($u) {
		$mobile = $u;
		$isphone = preg_match('/^((\91)|0?)[7-9]{1}\d{9}$/', $mobile);
        return $isphone;
    }
	
	function update_user($userId,$pass,$getOTP, $loginFrom){
		 $insertData = array('user_email_phone'=>$userId,'password'=>md5($pass),'otp'=>$getOTP, 'login_from'=>$loginFrom,"created_date"=>date('Y-m-d H:i:s'),'status'=>1);
		 if($this->db->insert('buzz_user',$insertData)){
		 	return '1';
		 }return '0';
	}
	
	function get_otp($userId){
		
		$this->db->select('otp');
		$this->db->where('user_email_phone',$userId);
       $query= $this->db->get("buzz_user"); 
	   $result=$query->result_array();
	   //echo $this->db->last_query();//exit;
	   
	return $result[0]['otp'];
	}
	
	function check_otp($otp,$uid){
		
			$this->db->select('count(1) as cnt');
			$this->db->from('buzz_user');
			$this->db->where(array('otp'=>$otp, 'user_id'=>$uid));
			$query = $this->db->get();   
			$result=$query->result_array();
			
			$cnt = $result[0]['cnt'];
			if($cnt>0)
			{
			return 1;
			}else{
				
				return 0;
			}
		
	}
	
function update_password($u,$p){
	
	        $pass= md5($p);
			$this->db->where(array('user_id'=>$u));
			$response= $this->db->update('buzz_user',array('password'=>$pass));
			//echo '***'.$this->db->last_query();exit;
			if($response)
			{
				return 1;
			}else{
				
				return 0;
				
			}
	}
	
	function check_password($u,$p){
	
	        $this->db->select('count(1) as cnt');
			$this->db->from('buzz_user');
			$this->db->where(array('password'=>md5($p), 'user_id'=>$u));
			$query = $this->db->get();   
			$result=$query->result_array();
			
			$cnt = $result[0]['cnt'];
			if($cnt>0)
			{
			return 1;
			}else{
				
				return 0;
			}
		
	}
}