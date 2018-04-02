<?php

class Myspidey_login_model extends CI_Model

{

    function __construct()

    {

        parent::__construct();

		$this->load->helper('common_functions_helper');//editorial_logIn_By_Designation

    }

     function getLogin()
     { 
  		$user_name = $this->input->post('username');
 		$user_pass = $this->input->post('password');
 		$pass='';
 		if(!empty($user_pass)){
 			$pass = md5($user_pass);
 		}
		
		$qry  				= $this->db->select("status, is_verified")->from('backend_user')->where(array('user_name'=>$user_name, 'password'=>$pass))->limit(1)->get();
		$res  				= $qry->result_array();
		$resultArStatus 	= $res[0]['status'];
		$resultArVerified 	= $res[0]['is_verified'];
		if( $qry->num_rows()>0){
 			if($resultArStatus==0 && $resultArVerified==0){
				echo 'status-verification-both';exit;
			}
			else if($resultArVerified==0){
				echo 'verification';exit;
			}
			else if($resultArStatus==0){
				echo 'status';exit;
			}else{
					$whereArray = array('user_name'=>$user_name, 'password'=>$pass,'status'=>'1');
					$this->db->select(array('user_id','user_name', 'is_admin'));
					$this->db->from('backend_user');
					$this->db->where($whereArray);
					$this->db->limit(1);
					$query = $this->db->get();
					if ($query->num_rows() > 0) { //echo $this->db->last_query();
  			$res = $query->result_array(); 
  			## -------------Group Permission details------------------##
 			$user_id	  = $res[0]['user_id'];
  			$login_type ='admin';
  			$newdata = array(
 			   'admin_user_id'  	=> $res[0]['user_id'],
 			   'user_name'  => $res[0]['user_name'],
 			   'login_type'  => $login_type,
 			   'logged_in'  => TRUE
 		   );
  			$this->session->set_userdata($newdata);
             echo trim($login_type);exit;
         }  
			}
		}else{
			echo 'wrong-pass';exit;
		}
     }

 
	function checkEmailExists($email='')

	{

		$result = false;

		$whereData = array('');

		$this->db->select('user_id');

		$this->db->from('backend_user');

		$this->db->where($whereData);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			$result = true;

		}

		return true;

 	}

	

	

	function updatepassword($email)

	{

 		$get_password 	= generateStrongPassword(); 

		$result 		= false;

 		$ArrData 		= array("password"=>md5($get_password));

		$whereData 		= array("email_id"=>$email);

 		$this->db->set($ArrData);

        $this->db->where($whereData);

        $query2 		= $this->db->update('backend_user'); 

		//echo '***'.$this->db->last_query();exit;

		if($query2){

			return $get_password ;

		}return '0';

 	}

	

	function reset_password($frmData='')

	{

		$password = $frmData['password'];

		$user_id 	= $this->session->userdata('admin_user_id');

		$ArrData 		= array("password"=>md5($password));

		$whereData 		= array("user_id"=>$user_id);

 		$this->db->set($ArrData);

        $this->db->where($whereData);

        $query2 		= $this->db->update('backend_user'); 

		//echo '***'.$this->db->last_query();exit;

		if($query2){

			echo  '1' ;exit;

		}echo  '0';exit;

 	}
	
	## register user
	 function get_register_user($data) { // echo '<pre>';print_r($data);exit;
       $parent 	 		= '';
		$parent 	 		= $this->input->post('parent');		
        $user_email  		= $this->input->post('user_email');
        $register_username  = $this->input->post('register_username');
		$register_password  = $this->input->post('register_password');
		if(!isset($parent) || $parent==0){
		$parent=1;
		}
		$is_parent  		= $parent;
        $insertData  = array(
            "user_name" 	=> 	trim($register_username),
            "password" 		=> 	trim(md5($register_password)),
            "email_id" 		=> 	trim($user_email),
			"is_parent" 	=>  trim($parent),
            "created_on" 	=> date('Y-m-d H:i:s'),
            "created_by" 	=> '0',
			"customer_code" => random_num(9),
			"industry" 		=> '0',
			"pan" 			=> '',
			"state" 		=> '0',
			"city" 			=> '0',
			"mobile_no" 	=> '',
            "status" 		=>'0'
        );
        $checkStoryUpdate = $this->chcekExistsUsernameEmail($register_username, $user_email);
        if ($checkStoryUpdate == 0){ 
			if ($this->db->insert("backend_user", $insertData)) {
                 return 1;
            }else{
				return 0;
			}
		} else{
			return 2;
		}
         echo $this->db->last_query();exit;
     }
	
	function chcekExistsUsernameEmail($user_name, $email){ 
        $result = array();
         if (!empty($user_name) && !empty($email)) {
            $this->db->select('user_id');
            $this->db->from('backend_user');
            $this->db->or_where(array('user_name' => $user_name,'email_id' => $email));
            $query = $this->db->get(); //echo '---sql='.$this->db->last_query();exit;
            $result = $query->result_array();
            //$res = $result[0]['detail_id'];
            if ($result[0]['user_id']!='') {
                return '1';
            } else {
                return '0';
            }
        }
      }
	  
	 
}