<?php

class Register extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
		//$this->load->library('Ajax_pagination');
        $this->load->model('Register_model');
		$this->load->helper('common_functions');
		$this->load->helper(array('form', 'url','msg_n_email','common_functions_helper'));
		$this->load->library('form_validation');
		//$this->load->library('encrypt');
		//checklogin();
    } 

 /*
  * Listing of inbreifs
  */
    function index()
    {
	    
        $data= array();
		$user_id = $this->session->userdata('user_id');
		$data['reg'] = $this->Register_model->get_userx($user_id);
		//print_r($data['reg']);
		
        $this->load->view('register',$data);
    }
	
  
	function city($id){
		$cites = $this->Register_model->cites($id);
		$result="<option value=''>  Select  </option>";
		foreach($cites as $city){
			$result.= "<option value='$city[city_id]'>$city[city_name]</option>";
			
		}
		echo $result; 
	}
   
   
   function edit()
      { 
         
		 
    	 $uploads = './uploads/registration/';
	if( isset( $_FILES['picture']['name'] ) && ( ! empty( $_FILES['picture']['name'] ) ) ) {
      $pic_1 = $this->upload_image( 'picture', $_FILES['picture'], $uploads );
                    $data['image'] = $pic_1['file_name'];
					$image1 = base_url().'uploads/registration/'.$data['image'];
                }
	if($this->input->post()){
            $id= $this->input->post('user_id');
            $now = date('Y-m-d H:i:s');
			
            $params = array(
                'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
                'user_email_phone' => ($this->input->post('from')=='email')?$this->input->post('email'):$this->input->post('phone'),
				'profile_pick' => $image1? $image1: $this->input->post('profile_pick'),
				'country' => $this->input->post('country_id'),
				'state' => $this->input->post('state_id'),
				'city' => $this->input->post('city_id'),
				'created_date' => $now,
                'updated_date' => $now,
				'contact'=> $this->input->post('phone'),
                
            );


             
            $this->Register_model->update_register($id,$params);
			$this->session->set_flashdata('msg',"Profile has been updated successfully");
            redirect('register');
		}else{
      $this->load->view('register',$data);
		}
      }  
    
	
	 function thanks()
    {
	
        $data= array();
        $this->load->view('thanks',$data);
    }
	
	public function upload_image( $fieldname, $filename, $uploadpath ) {
     
        $fullname = pathinfo( $filename['name'] );

        $file_name = $fullname['filename']; // Get file name without extension
        $file_ext = $fullname['extension']; // Get file extension without . (dot)
        
               $config['upload_path']   = $uploadpath;
               $config['allowed_types'] = 'jpeg|png|jpg|gif|bmp'; 
               $config['max_size']      = 2048000; 
               $config['max_width']     = 11700; 
               $config['max_height']    = 5800;
               $config['file_name'] = time().$filename['name'];
               $this->load->library( 'upload', $config );
               $this->upload->initialize( $config );
               $rwa_logo = $this->upload->do_upload( $fieldname );
               $finfo = $this->upload->data();
                           
               return $finfo;
       
    }
	
	function forgot_password()
	{    
		$this->load->view('change_pass');
 	}
	
	
	
    function reset_password(){    
	
	
		$data = array();
		
	if($this->input->post('submit')=='Submit'){
         $getOTP = getOTP();
		 $msg="Your OTP is ".$getOTP;
         $userID = $this->input->post('email');
		 $this->session->set_userdata('email',$this->input->post('email'));
 		 $chcekVal = $this->Register_model->check_validate($userID);		 
		 if($chcekVal==0){
				echo 0;exit;
 			}elseif($chcekVal[0]['login_from']=='phone'){
				
				
				$this->session->set_userdata('getOTP',$getOTP);
				$this->session->unset_userdata('forgot_user');
				$this->session->unset_userdata('user_id');
				$this->session->set_userdata('forgot_user',$chcekVal[0]['user_id']);
				sendsms($userID,$msg);
				echo 1;exit;
				
			}elseif($chcekVal[0]['login_from']=='email'){
				$this->session->set_userdata('getOTP',$getOTP);
				$this->session->unset_userdata('forgot_user');
				$this->session->unset_userdata('user_id');
				 $this->session->set_userdata('forgot_user',$chcekVal[0]['user_id']);
				 $this->forgotemail('User',$userID,"Forgot password - Spideybuzz",$getOTP);
				echo 2;exit;
			
		}
	}
     if($this->input->post('submit')=='Submit OTP'){
    	 $u_id = $this->session->userdata('forgot_user');
		$otp= $this->input->post('otp');
		
		$chcekVal = $this->session->userdata('getOTP');
		//echo '***'.$this->db->last_query();exit;
		if($chcekVal==$otp) echo 3;
		if($chcekVal!=$otp) echo 4;
		exit;
		
	}
	 if($this->input->post('submit')=='Save Password'){
		$u_id = $this->session->userdata('forgot_user');
		$pass= $this->input->post('password');
		$chackPass = $this->Register_model->update_password($u_id,$pass);
		if($chackPass==1) echo 5;
		if($chackPass==0) echo 6;
		exit;
	 }
		
		
		 
 	}
	function forgotemail($firstname,$to,$sub,$getOTP)
 	{
 		$from = "no-reply@cityspidey.com";
		$reply = "no-reply@cityspidey.com";
		$fromname = "Spideybuzz";
		//$to = $emails; //Recipients list (semicolon separated)
		$url = base_url().'home/';
		$api_key = "0cde1eb63c50a026f79a0e95e19456b4";
		$subject = $sub;
		
		
		//$content = $msg;
		$url = base_url().'home';
		$image = base_url().'assets/sb-images/spidey-buzz.png';
		$content = '<table cellpadding="0" cellspacing="0" width="600" style="width:600px; margin:0 auto;">
			  <tr bgcolor="#fdb302">
				<td><table cellpadding="0" cellspacing="0" style="margin:10px;" >
					<tr>
					  <td><a href="'.$url.'" target="_blank"><img src="'.$image.'" alt="logo"  title="logo" style="100%" /></a></td>
					</tr>
					<tr>
					  <td bgcolor="#4a4a4a" style="color:#FFF; text-align:center;padding:3px; font-family:Arial, Helvetica, sans-serif; font-size:14px;">'.date("jS F Y").'</td>
					</tr>
				  </table></td>
				<td><table cellpadding="0" cellspacing="0"  align="right" style="margin:10px;">
					<tr>
					  <td><a href="#" target="_blank"><img src="http://cityspidey.com/images/facebook_notice_news.jpg" alt="facebook" title="facebook" /></a></td>
					  <td>&nbsp;</td>
					  <td><a href="#" target="_blank"><img src="http://www.cityspidey.com/images/twitter_notice_news.jpg" alt="twitter" title="twitter" /></a></td>
						<td>&nbsp;</td>
					  <td><a href="#" target="_blank"><img src="http://www.cityspidey.com/images/instagram_notice_news.jpg" alt="instagram" title="instagram" /></a></td>
					</tr>
				  </table></td>
			  </tr>';
					
					 
			$content .= '<tr>
			<td colspan="2" style="text-align:left; padding:15px 0 15px 0"><p> Dear SpideyBuzz '.ucfirst($firstname).',</p>
			<p>OTP: '.$getOTP.'</p>
			<p>See you around! </br>
			Spidey	</p></td></tr>';
			 
			
		$content .= '
		  <tr bgcolor="#fdb302">
			<td colspan="2" style="text-align:center; height:50px; line-height:50px;">
				<span>@ '.date("Y").' SpideyBuzz All Rights Reserved</span>
			</td>
		  </tr>
		</table>';
		//echo $content;exit;
		$data=array();
		$data['subject']= $subject;                                                                       
		$data['fromname']= $fromname;                                                             
		$data['api_key'] = $api_key;
		$data['from'] = $from;
		$data['replytoid'] = $reply;
		$data['content']= $content;
		$data['recipients']= $to;
		$apiresult = callApi(@$api_type,@$action,$data);
  }
	
  function change_password()
	{   $user_id 	= $this->session->userdata('user_id'); 
		if($user_id){
			$this->load->view('changepassword');
		}else{
			
			redirect("home");
		}
 	}

  function update_password(){
	   $user_id 	= $this->session->userdata('user_id');
	   $old_p= $this->input->post('opassword');
	   $new_p= $this->input->post('password');
	   $chackPass = $this->Register_model->check_password($user_id,$old_p);
	   if($chackPass==1){
		   
		   $pass = $this->Register_model->update_password($user_id,$new_p);
		  if($pass) echo 1;exit;
		   if(!$pass) echo 2; exit;
	   }else{
		   
		    echo 0;exit;
		   
	   }
	 
	 
 }	
  
}