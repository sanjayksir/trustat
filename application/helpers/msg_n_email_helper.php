<?php 
	function http_post_form($url,$data,$timeout=20) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url); 
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_RANGE,"1-2000000");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		curl_setopt($ch, CURLOPT_REFERER, @$_SERVER['REQUEST_URI']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($ch); 
		$result = curl_error($ch) ? curl_error($ch) : $result;
		curl_close($ch);
		return $result;
	}
	
	function sendsms($to,$msg)
	{
		$emailapi="cityspidey&password=123456&mobile=".$to."&text=".urlencode($msg)."&senderid=SPIDEY&route_id=2&Unicode=0";
		$emailsnd=$emailapi;
		$cSession=curl_init();
		curl_setopt($cSession,CURLOPT_URL,"http://hindit.co.in/API/pushsms.aspx?loginID=".$emailsnd);
		curl_setopt($cSession,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cSession,CURLOPT_HEADER, false);
		curl_setopt($cSession,CURLOPT_VERBOSE, 0);    
		//curl_setopt($cSession,CURLOPT_POST,true); 
		curl_exec($cSession);
		//$result = curl_exec($cSession);
		curl_close($cSession);
	}
	
	
	
	function encrypt_email($email){
		$ci = & get_instance();
		$base64 = $ci->encrypt->encode($email);
		return $urisafe = strtr($base64, '+/=', '-_,');
  	}
	
	
	function decrypt_email($email){
		$ci = & get_instance();
		$base64 = strtr($email, '-_,', '+/=');
		return $base64 = $ci->encrypt->decode($base64);
  	}		

	function callApi($api_type='', $api_activity='', $api_input='') {
            $data = array();
            $result =http_post_form("https://api.falconide.com/falconapi/web.send.rest", $api_input);
            return $result;
	}
	
  	function sendemail($firstname,$to,$password,$rwaname,$sub,$getOTP)
 	{
 		$from = "no-reply@cityspidey.com";
		$reply =  $_SESSION['email'];
		$fromname = $_SESSION['rwaname'];
		//$to = $emails; //Recipients list (semicolon separated)
		$url = base_url().'home/';
		$api_key = "0cde1eb63c50a026f79a0e95e19456b4";
		$subject = $sub;
		$verify_url =  $url.'verifying/?msg='.encrypt_email($to);
		
		//$content = $msg;
		$url = base_url().'home';
		$image = BASE_URL.'assets/sb-images/spidey-buzz.png';
		$content = '<table cellpadding="0" cellspacing="0" width="600" style="width:600px; margin:0 auto;">
			  <tr bgcolor="#fdb302">
				<td><table cellpadding="0" cellspacing="0" style="margin:10px;" >
					<tr>
					  <td><a href="'.$url.'" target="_blank"><img src="'.$image.'" alt="Spidey Buzz"  title="Spidey Buzz" style="100%" /></a></td>
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
			<p>Congratulations! You\'re now a member of <a href="'.$url.'">'.$url.'</a></p>
			<p>Click on this link and put the OTP below to verify!<br> <a href="'.$verify_url.'">Verify Me</a></p>
			<p>Email: '.$to.'</p>
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
		//echo $content;//exit;
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
  
  function getOTP(){
  	$digits = 6;
	return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
  }
  
  
  function emailMessage($firstname,$to,$sub,$name,$email,$phone,$message)
 	{
 		$from = "no-reply@cityspidey.com";
		$reply =  $to;
		$fromname = "Spidey Buzz";
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
					  <td><a href="'.$url.'" target="_blank"><img src="'.$image.'" alt="'.$url.'"  title='.$url.' style="100%" /></a></td>
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
			<p>Congratulations! Feedback Details are: </p>
			<p>Name: '.$name.'</p>
			<p>Email: '.$email.'</p>
			<p>Phone: '.$phone.'</p>
			<p>Message: '.$message.'</p>
			</td></tr>';
			 
			
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
  
  function emailCareer($to,$sub,$name,$age,$message,$attachment)
 	{
 		$from = "no-reply@cityspidey.com";
		$reply =  $to;
		$fromname = "Spidey Buzz";
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
					  <td><a href="'.$url.'" target="_blank"><img src="'.$image.'" alt="'.$url.'"  title='.$url.' style="100%" /></a></td>
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
			<td colspan="2" style="text-align:left; padding:15px 0 15px 0">
			<p>Career Details are: </p>
			<p>Name: '.$name.'</p>
			<p>Age: '.$age.'</p>
			<p>Message: '.$message.'</p>
			<p>Attachment : <a href="'.$attachment.'">View</a></p>
			</td></tr>';
			 
			
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
		//$data['attachmentid']= $attachment;
		$apiresult = callApi(@$api_type,@$action,$data);
  }
?>