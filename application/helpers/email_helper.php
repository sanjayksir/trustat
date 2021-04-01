<?php 
	function callApi($api_type = '', $api_activity = '', $api_input = '') {
		$data = array();
		$result = http_post_form("https://api.falconide.com/falconapi/web.send.rest", $api_input);
		return $result;
	}
	
	function sendemail($firstname, $to, $password, $rwaname, $sub, $opt) {
    
    $from = MAIL_FROM;
    $reply = '';//$_SESSION['email'];
    $fromname = FROM_NAME;//$_SESSION['rwaname'];
  //  $to ='join2kamal@gmail.com';// $emails; //Recipients list (semicolon separated)
    $api_key = API_KEY;
    $subject = $sub;
    

    $content = '<table cellpadding="0" cellspacing="0" width="600" style="width:600px; margin:0 auto;">
						  <tr bgcolor="#fdb302">
							<td><table cellpadding="0" cellspacing="0" style="margin:10px;" >
								<tr>
								  <td><a href="http://www.'.$_SERVER['SERVER_NAME'].'" target="_blank"><img src="http://www.'.$_SERVER['SERVER_NAME'].'/images/logo_notice_news.jpg" alt="www.'.$_SERVER['SERVER_NAME'].'"  title="www.'.$_SERVER['SERVER_NAME'].'" style="100%" /></a></td>
								</tr>
								<tr>
								  <td bgcolor="#4a4a4a" style="color:#FFF; text-align:center;padding:3px; font-family:Arial, Helvetica, sans-serif; font-size:14px;">' . date("jS F Y") . '</td>
								</tr>
							  </table></td>
							<td><table cellpadding="0" cellspacing="0"  align="right" style="margin:10px;">
								<tr>
								  <td><a href="https://www.facebook.com/CitySpidey-794449920700906/?ref=bookmarks" target="_blank"><img src="http://'.$_SERVER['SERVER_NAME'].'/images/facebook_notice_news.jpg" alt="facebook" title="facebook" /></a></td>
								  <td>&nbsp;</td>
								  <td><a href="https://twitter.com/city_spidey" target="_blank"><img src="http://www.'.$_SERVER['SERVER_NAME'].'/images/twitter_notice_news.jpg" alt="twitter" title="twitter" /></a></td>
									<td>&nbsp;</td>
								  <td><a href="https://www.instagram.com/cityspidey_stevemedius/" target="_blank"><img src="http://www.'.$_SERVER['SERVER_NAME'].'/images/instagram_notice_news.jpg" alt="instagram" title="instagram" /></a></td>
								</tr>
							  </table></td>
						  </tr>';


        $content .= '<tr>
									<td colspan="2" style="text-align:left; padding:15px 0 15px 0"><p> Hi Spidey City-zen ' . ',</p>
									<p>Your password has been changed! You\'re new password is: ' .$password . '.</b></p>
<p>We hope you\'ll enjoy our network and features responsibly. There are a few  <a href=\'http://www.'.$_SERVER['SERVER_NAME'].'/terms-and-conditions.php\'> rules </a> to remember to keep our network healthy. </p>
<p>You are advised to change your password after logging in. </p>
<p>See you around! </br>
Spidey	</p></td></tr>';
   

    $content .= '
					  <tr bgcolor="#fdb302">
						<td colspan="2" style="text-align:center; height:50px; line-height:50px;">
							<span>@ 2017 CitySpidey All Rights Reserved</span>
						</td>
					  </tr>
					</table>';


    $data = array();
    $data['subject'] = $subject;
    $data['fromname'] = $fromname;
    $data['api_key'] = API_KEY;
    $data['from'] = $from;
    $data['replytoid'] = $reply;
    $data['content'] = $content;
    $data['recipients'] = $to;
    $apiresult = callApi(@$api_type, @$action, $data);
}


function http_post_form($url, $data, $timeout = 20) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RANGE, "1-2000000");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_REFERER, @$_SERVER['REQUEST_URI']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    $result = curl_error($ch) ? curl_error($ch) : $result;
    curl_close($ch);
    return $result;
}
function generateStrongPassword($length = 6, $add_dashes = false, $available_sets = 'luds')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@?';
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
	$password = str_shuffle($password);
	if(!$add_dashes)
		return $password;
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}

function getDataFromEmail($email=''){
	$ci = & get_instance();
	$ci->db->select('*');
	$ci->db->from('backend_user');
	$ci->db->where('email_id', $email);
	$query = $ci->db->get();
	//echo '==='.$ci->db->last_query();
    $result = $query->row_array();
    return $result;
}

function encrypt_url($url){
	$ci = & get_instance();
	$ci->load->library(array('encrypt'));

	$enc_email = $ci->encrypt->encode($url);
	$enc_email = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_email);

	return $enc_email;
}


function decrypt_url($url){
	$ci = & get_instance();
	$ci->load->library(array('encrypt'));

	$dec_email = str_replace(array('-', '_', '~'), array('+', '/', '='), $url);
	$dec_email = $ci->encrypt->decode($dec_email);

	return $dec_email;
}	

// Send Receive Alert emails
function receiveAlert($emails, $category, $storydata) {
	$from = "no-reply@".$_SERVER['SERVER_NAME'];
	$fromname = "Spidey Buzz";
	$to = $emails; //Recipients list (semicolon separated)
	$url = base_url().'home/';
	$api_key = "0cde1eb63c50a026f79a0e95e19456b4";
	$subject = "News Alert: ".$category;

	$storyUrl =  getstoryurl( $storydata[0]['spidypickId'] );
	if( $storydata[0]['spideyImage'] && file_exists('./uploads/spidey/'.$storydata[0]['spideyImage'] ) ) {
		$story_image = base_url().'uploads/spidey/'.$storydata[0]['spideyImage'];
	}
	else {
		$story_image = base_url().'uploads/noimage/no-image-614x373.png';
	}
	
	
	//$content = $msg;
	$url = base_url().'home';
	$image = base_url().'assets/sb-images/spidey-buzz.png';
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SpideyBuzz Newsletter</title>
	</head>

	<body style="margin:0;padding:0;border:0;@import url(https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i);
	@import url(https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i;">
	<center>
	<table cellpadding="0" cellspacing="0" width="600" style="max-width:600px; margin:0 auto;padding:0;border:0;">
	  <tr>
	    <td><table cellpadding="0" cellspacing="0" width="100%">
	        <tr>
	          <td bgcolor="#595959" ><table bgcolor="#595959" cellpadding="0" cellspacing="0" width="50%" style="padding:20px" align="left">
	              <tr>
	                <td valign="top"><span style="font:bold 40px \'Merriweather\', serif;  color:#FFF; text-align:left;">News Alert</span></td>
	              </tr>
	              <tr>
	                <td align="left" valign="top"><span style="font:bold 20px \'Merriweather\', serif; color:#FFF; text-align:left;">'.date("F Y").'</span></td>
	              </tr>
	            </table></td>
	          <td bgcolor="#fea800"><table bgcolor="#fea800" cellpadding="0" cellspacing="0" width="50%"  align="right">
	              <tr>
	                <td><a href="'.base_url().'"><img src="'.ASSETS_PATH.'sb-images/spideybuzz.png" alt="Spidey Buzz" title="Spidey Buzz" /></a></td>
	              </tr>
	            </table></td>
	        </tr>
	      </table></td>
	  </tr>
	  <tr>
	    <td bgcolor="#a6a6a6"><table cellpadding="0" cellspacing="0" width="100%" style="padding:20px 20px 0 20px;">
	       	<!--please take this code in loop-->
	        <tr>
	          <td><table align="center" width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0"  style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;-webkit-box-shadow: 1px 1px 10px 1px #818080;box-shadow: 1px 1px 10px 1px #818080;;margin-bottom:20px;">
	              <tbody>
	                <tr>
	                  <td><img src="'.$story_image.'" alt="'.$storydata[0]['spidyName'].'" style="height:278px; width:560px;"></td>
	                </tr>
	                <tr>
	                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:20px;" >
	                      <tbody>
	                        <tr>
	                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                              <tbody>
	                                <tr>
	                                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                                      <tbody>
	                                        <tr>
	                                          <td width="100%" align="left"><a href="'.$storyUrl['url'].'" style="font:12px/22px \'Roboto\', serif; color:#000; text-decoration:none; background:#fea800; float:left; padding:3px 19px; border-radius:13px; text-transform:uppercase;">'.$category.'</a></td>
	                                        </tr>
	                                      </tbody>
	                                    </table></td>
	                                </tr>
	                                <tr>
	                                  <td height="10"></td>
	                                </tr>
	                                <tr>
	                                  <td style="font:bold 25px \'Merriweather\', serif; color:#535353;"><a href="'.$storyUrl['url'].'" style="text-decoration:none; color:#535353;">'.$storydata[0]['spidyName'].'</a></td>
	                                </tr>
	                                <tr>
	                                  <td height="10"></td>
	                                </tr>
	                                <tr>
	                                  <td style="font:22px/22px \'Roboto\', serif; color:#ff0000;"><a href="'.$storyUrl['url'].'" style="color:#ff0000; text-decoration:none;">Read more</a></td>
	                                </tr>
	                              </tbody>
	                            </table></td>
	                        </tr>
	                      </tbody>
	                    </table></td>
	                </tr>
	              </tbody>
	            </table></td>
	        </tr>
	        <!--Code end for loop section-->

	      </table></td>
	  </tr>
	  <tr bgcolor="#a6a6a6">
	      <td height="20"></td>
	    </tr>
	  <tr>
	  	<td>
	        <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#535353" >
	  <tr>
	    <td><table align="center" width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;padding:10px;font-family: \'Roboto\'; color:#FFFFFF; font-size:18px;">
	        <tr>
	          <td><table cellpadding="0" cellspacing="0" width="100%" style="padding:20px;">
	              <tr>
	                <td><table cellpadding="0" cellspacing="0" width="80%" align="left">
	                    <tr>
	                      <td><span style="font-size:18px;font-family: \'Roboto\';color:#FFFFFF">For any queries contact <br />
	                        Customer Support: <br />
	                        <a href="#" style="text-decoration:none; color:#fea800;">cs@'.$_SERVER['SERVER_NAME'].'</a></span></td>
	                    </tr>
	                    <tr>
	                      <td height="20"></td>
	                    </tr>
	                    <tr>
	                      <td><span style="font-size:18px;font-family: \'Roboto\';color:#FFFFFF">Do not want to receive emails from us? <a href="'.base_url().'receive_alert/unsubscribe/'.$storydata[0]['sub_category_id'].'" style="color:#ff0000;text-decoration:none;">Unsubscribe</a></span></td>
	                    </tr>
	                  </table></td>
	                <td valign="top"><table cellpadding="0" cellspacing="0" width="80%" align="right">
	                    <tr>
	                      <td align="right"><table>
	                          <tr>
	                            <td><a href="'.FACEBOOK_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/facebook.png" width="37" height="37" alt="Facebook" title="Facebook"  /></a></td>
	                            <td><a href="'.INSTAGRAM_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/instagram.png" width="37" height="37" alt="Instagram" title="Instagram"  /></a></td>
	                            <td><a href="'.TWITTER_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/twitter.png" width="37" height="37" alt="Twitter" title="Twitter"  /></a></td>
	                            <td><a href="'.YOUTUBE_CHANNEL.'"><img src="'.ASSETS_PATH.'sb-images/youtube.png" width="37" height="37" alt="Youtube" title="Youtube"  /></a></td>
	                          </tr>
	                        </table></td>
	                    </tr>
	                    <tr>
	                      <td height="30"></td>
	                    </tr>
	                    <tr>
	                      <td align="right"><span style="font:bold 23px \'Merriweather\', serif; text-align:right; color:#FFFFFF;">For your daily dosage of Hyperlocal news</span></td>
	                    </tr>
	                  </table></td>
	              </tr>
	            </table></td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	    </td>
	  </tr>
	</table>
	</center>
	</body>
	</html>
	';
	//echo $content;exit;
	$data=array();
	$data['subject']= $subject;                                                                       
	$data['fromname']= $fromname;                                                             
	$data['api_key'] = $api_key;
	$data['from'] = $from;
	$data['content']= $content;
	$data['recipients']= $to;
	$apiresult = callApi(@$api_type,@$action,$data);
}

// Unsubscribe Receive Alert emails
function unsubscribeAlert($email, $category, $category_id, $reason) {
	$ci =& get_instance();
    $ci->load->library('encryption');

	$from = "no-reply@".$_SERVER['SERVER_NAME'];
	$fromname = "Spidey Buzz";
	$to = $email; //Recipients list (semicolon separated)
	$url = base_url().'home/';
	$api_key = "0cde1eb63c50a026f79a0e95e19456b4";
	$subject = "Unsubscribe News Alert: ".$category;
	
	//$content = $msg;
	$url = base_url().'home';
	$image = base_url().'assets/sb-images/spidey-buzz.png';
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SpideyBuzz Newsletter</title>
	</head>

	<body style="margin:0;padding:0;border:0;@import url(https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i);
	@import url(https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i;">
	<center>
	<table cellpadding="0" cellspacing="0" width="600" style="max-width:600px; margin:0 auto;padding:0;border:0;">
	  <tr>
	    <td><table cellpadding="0" cellspacing="0" width="100%">
	        <tr>
	          <td bgcolor="#595959" ><table bgcolor="#595959" cellpadding="0" cellspacing="0" width="50%" style="padding:20px" align="left">
	              <tr>
	                <td valign="top"><span style="font:bold 40px \'Merriweather\', serif;  color:#FFF; text-align:left;">News Alert</span></td>
	              </tr>
	              <tr>
	                <td align="left" valign="top"><span style="font:bold 20px \'Merriweather\', serif; color:#FFF; text-align:left;">'.date("F Y").'</span></td>
	              </tr>
	            </table></td>
	          <td bgcolor="#fea800"><table bgcolor="#fea800" cellpadding="0" cellspacing="0" width="50%"  align="right">
	              <tr>
	                <td><a href="'.base_url().'"><img src="'.ASSETS_PATH.'sb-images/spideybuzz.png" alt="Spidey Buzz" title="Spidey Buzz" /></a></td>
	              </tr>
	            </table></td>
	        </tr>
	      </table></td>
	  </tr>
	  <tr bgcolor="#a6a6a6">
	      <td height="20">
	      <table cellpadding="0" cellspacing="0" width="100%">
	      	<tr>
	      		<td><span style="font:bold 16px \'Merriweather\', serif; color:#FFF; text-align:left;">Please click the Unsubscribe link below</span></td>
	      	</tr>
	      </table
	      </td>
	    </tr>
	  <tr>
	  	<td>
	        <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#535353" >
			  <tr>
			    <td><table align="center" width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;padding:10px;font-family: \'Roboto\'; color:#FFFFFF; font-size:18px;">
			        <tr>
			          <td><table cellpadding="0" cellspacing="0" width="100%" style="padding:20px;">
			              <tr>
			                <td><table cellpadding="0" cellspacing="0" width="80%" align="left">
			                    <tr>
			                      <td><span style="font-size:18px;font-family: \'Roboto\';color:#FFFFFF">For any queries contact <br />
			                        Customer Support: <br />
			                        <a href="#" style="text-decoration:none; color:#fea800;">cs@'.$_SERVER['SERVER_NAME'].'</a></span></td>
			                    </tr>
			                    <tr>
			                      <td height="20"></td>
			                    </tr>
			                    <tr>
			                      <td><span style="font-size:18px;font-family: \'Roboto\';color:#FFFFFF">Do not want to receive emails from us? <a href="'.base_url().'receive_alert/unsubscribed/'.encrypt_url($category_id.'/'.$email.'/'.$reason).'" style="color:#ff0000;text-decoration:none;">Unsubscribe</a></span></td>
			                    </tr>
			                  </table></td>
			                <td valign="top"><table cellpadding="0" cellspacing="0" width="80%" align="right">
			                    <tr>
			                      <td align="right"><table>
			                          <tr>
			                            <td><a href="'.FACEBOOK_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/facebook.png" width="37" height="37" alt="Facebook" title="Facebook"  /></a></td>
			                            <td><a href="'.INSTAGRAM_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/instagram.png" width="37" height="37" alt="Instagram" title="Instagram"  /></a></td>
			                            <td><a href="'.TWITTER_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/twitter.png" width="37" height="37" alt="Twitter" title="Twitter"  /></a></td>
			                            <td><a href="'.YOUTUBE_CHANNEL.'"><img src="'.ASSETS_PATH.'sb-images/youtube.png" width="37" height="37" alt="Youtube" title="Youtube"  /></a></td>
			                          </tr>
			                        </table></td>
			                    </tr>
			                    <tr>
			                      <td height="30"></td>
			                    </tr>
			                    <tr>
			                      <td align="right"><span style="font:bold 23px \'Merriweather\', serif; text-align:right; color:#FFFFFF;">For your daily dosage of Hyperlocal news</span></td>
			                    </tr>
			                  </table></td>
			              </tr>
			            </table></td>
			        </tr>
			      </table></td>
			  </tr>
			</table>
	    </td>
	  </tr>
	</table>
	</center>
	</body>
	</html>';
	//echo $content;exit;
	$data=array();
	$data['subject']= $subject;                                                                       
	$data['fromname']= $fromname;                                                             
	$data['api_key'] = $api_key;
	$data['from'] = $from;
	$data['content']= $content;
	$data['recipients']= $to;
	$apiresult = callApi(@$api_type,@$action,$data);
	return $apiresult;
}

// Send Receive Newsletter emails
function subscribeNewsletter($emails) {
	$from = "no-reply@".$_SERVER['SERVER_NAME'];
	$fromname = "Spidey Buzz";
	$to = $emails; //Recipients list (semicolon separated)
	$url = base_url().'home/';
	$api_key = "0cde1eb63c50a026f79a0e95e19456b4";
	$subject = "Newsletter subscription received!";

	//$content = $msg;
	$url = base_url().'home';
	$image = base_url().'assets/sb-images/spidey-buzz.png';
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SpideyBuzz Newsletter</title>
	</head>

	<body style="margin:0;padding:0;border:0;@import url(https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i);
	@import url(https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i;">
	<center>
	<table cellpadding="0" cellspacing="0" width="600" style="max-width:600px; margin:0 auto;padding:0;border:0;">
	  <tr>
	    <td><table cellpadding="0" cellspacing="0" width="100%">
	        <tr>
	          <td bgcolor="#595959" ><table bgcolor="#595959" cellpadding="0" cellspacing="0" width="50%" style="padding:20px" align="left">
	              <tr>
	                <td valign="top"><span style="font:bold 40px \'Merriweather\', serif;  color:#FFF; text-align:left;">Newsletter</span></td>
	              </tr>
	              <tr>
	                <td align="left" valign="top"><span style="font:bold 20px \'Merriweather\', serif; color:#FFF; text-align:left;">'.date("F Y").'</span></td>
	              </tr>
	            </table></td>
	          <td bgcolor="#fea800"><table bgcolor="#fea800" cellpadding="0" cellspacing="0" width="50%"  align="right">
	              <tr>
	                <td><a href="'.base_url().'"><img src="'.ASSETS_PATH.'sb-images/spideybuzz.png" alt="Spidey Buzz" title="Spidey Buzz" /></a></td>
	              </tr>
	            </table></td>
	        </tr>
	      </table></td>
	  </tr>
	  <tr>
	    <td bgcolor="#a6a6a6"><table cellpadding="0" cellspacing="0" width="100%" style="padding:20px 20px 0 20px;">';
	    	$latest4stories = get_stories_for_newsletter();
	    	foreach( $latest4stories as $stories ) {
		       	$storyUrl =  getstoryurl( $stories['spidypickId'] );
				if( $stories['spideyImage'] && file_exists('./uploads/spidey/'.$stories['spideyImage'] ) ) {
					$story_image = base_url().'uploads/spidey/'.$stories['spideyImage'];
				}
				else {
					$story_image = base_url().'uploads/noimage/no-image-614x373.png';
				}

		        $content .= '<tr>
		          <td><table align="center" width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0"  style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;-webkit-box-shadow: 1px 1px 10px 1px #818080;box-shadow: 1px 1px 10px 1px #818080;;margin-bottom:20px;">
		              <tbody>
		                <tr>
		                  <td><img src="'.$story_image.'" alt="'.$stories['spidyName'].'" style="height:278px; width:560px;"></td>
		                </tr>
		                <tr>
		                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:20px;" >
		                      <tbody>
		                        <tr>
		                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		                              <tbody>
		                                <tr>
		                                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		                                      <tbody>
		                                        <tr>
		                                          <td width="100%" align="left"><a href="'.$storyUrl['url'].'" style="font:12px/22px \'Roboto\', serif; color:#000; text-decoration:none; background:#fea800; float:left; padding:3px 19px; border-radius:13px; text-transform:uppercase;">'.$stories['categoryName'].'</a></td>
		                                        </tr>
		                                      </tbody>
		                                    </table></td>
		                                </tr>
		                                <tr>
		                                  <td height="10"></td>
		                                </tr>
		                                <tr>
		                                  <td style="font:bold 25px \'Merriweather\', serif; color:#535353;"><a href="'.$storyUrl['url'].'" style="text-decoration:none; color:#535353;">'.$stories['spidyName'].'</a></td>
		                                </tr>
		                                <tr>
		                                  <td height="10"></td>
		                                </tr>
		                                <tr>
		                                  <td style="font:22px/22px \'Roboto\', serif; color:#ff0000;"><a href="'.$storyUrl['url'].'" style="color:#ff0000; text-decoration:none;">Read more</a></td>
		                                </tr>
		                              </tbody>
		                            </table></td>
		                        </tr>
		                      </tbody>
		                    </table></td>
		                </tr>
		              </tbody>
		            </table></td>
		        </tr>';
		    }
	      $content .= '</table></td>
	  </tr>
	  <tr bgcolor="#a6a6a6">
	      <td height="20"></td>
	    </tr>
	  <tr>
	  	<td>
	        <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#535353" >
	  <tr>
	    <td><table align="center" width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;padding:10px;font-family: \'Roboto\'; color:#FFFFFF; font-size:18px;">
	        <tr>
	          <td><table cellpadding="0" cellspacing="0" width="100%" style="padding:20px;">
	              <tr>
	                <td><table cellpadding="0" cellspacing="0" width="80%" align="left">
	                    <tr>
	                      <td><span style="font-size:18px;font-family: \'Roboto\';color:#FFFFFF">For any queries contact <br />
	                        Customer Support: <br />
	                        <a href="#" style="text-decoration:none; color:#fea800;">cs@'.$_SERVER['SERVER_NAME'].'</a></span></td>
	                    </tr>
	                    <tr>
	                      <td height="20"></td>
	                    </tr>
	                    <tr>
	                      <td><span style="font-size:18px;font-family: \'Roboto\';color:#FFFFFF">Do not want to receive emails from us? <a href="'.base_url().'subscription/unsubscribe" style="color:#ff0000;text-decoration:none;">Unsubscribe</a></span></td>
	                    </tr>
	                  </table></td>
	                <td valign="top"><table cellpadding="0" cellspacing="0" width="80%" align="right">
	                    <tr>
	                      <td align="right"><table>
	                          <tr>
	                            <td><a href="'.FACEBOOK_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/facebook.png" width="37" height="37" alt="Facebook" title="Facebook"  /></a></td>
	                            <td><a href="'.INSTAGRAM_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/instagram.png" width="37" height="37" alt="Instagram" title="Instagram"  /></a></td>
	                            <td><a href="'.TWITTER_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/twitter.png" width="37" height="37" alt="Twitter" title="Twitter"  /></a></td>
	                            <td><a href="'.YOUTUBE_CHANNEL.'"><img src="'.ASSETS_PATH.'sb-images/youtube.png" width="37" height="37" alt="Youtube" title="Youtube"  /></a></td>
	                          </tr>
	                        </table></td>
	                    </tr>
	                    <tr>
	                      <td height="30"></td>
	                    </tr>
	                    <tr>
	                      <td align="right"><span style="font:bold 23px \'Merriweather\', serif; text-align:right; color:#FFFFFF;">For your daily dosage of Hyperlocal news</span></td>
	                    </tr>
	                  </table></td>
	              </tr>
	            </table></td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	    </td>
	  </tr>
	</table>
	</center>
	</body>
	</html>
	';
	//echo $content;exit;
	$data=array();
	$data['subject']= $subject;                                                                       
	$data['fromname']= $fromname;                                                             
	$data['api_key'] = $api_key;
	$data['from'] = $from;
	$data['content']= $content;
	$data['recipients']= $to;
	$apiresult = callApi(@$api_type,@$action,$data);
}

// Unsubscribe Newsletter emails
function unsubscribeNewsletter($email, $reason) {
	$ci =& get_instance();
    $ci->load->library('encryption');

	$from = "no-reply@".$_SERVER['SERVER_NAME'];
	$fromname = "Spidey Buzz";
	$to = $email; //Recipients list (semicolon separated)
	$url = base_url().'home/';
	$api_key = "0cde1eb63c50a026f79a0e95e19456b4";
	$subject = "Unsubscribe Newsletter";
	
	//$content = $msg;
	$url = base_url().'home';
	$image = base_url().'assets/sb-images/spidey-buzz.png';
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SpideyBuzz Newsletter</title>
	</head>

	<body style="margin:0;padding:0;border:0;@import url(https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i);
	@import url(https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i;">
	<center>
	<table cellpadding="0" cellspacing="0" width="600" style="max-width:600px; margin:0 auto;padding:0;border:0;">
	  <tr>
	    <td><table cellpadding="0" cellspacing="0" width="100%">
	        <tr>
	          <td bgcolor="#595959" ><table bgcolor="#595959" cellpadding="0" cellspacing="0" width="50%" style="padding:20px" align="left">
	              <tr>
	                <td valign="top"><span style="font:bold 40px \'Merriweather\', serif;  color:#FFF; text-align:left;">Newsletter</span></td>
	              </tr>
	              <tr>
	                <td align="left" valign="top"><span style="font:bold 20px \'Merriweather\', serif; color:#FFF; text-align:left;">'.date("F Y").'</span></td>
	              </tr>
	            </table></td>
	          <td bgcolor="#fea800"><table bgcolor="#fea800" cellpadding="0" cellspacing="0" width="50%"  align="right">
	              <tr>
	                <td><a href="'.base_url().'"><img src="'.ASSETS_PATH.'sb-images/spideybuzz.png" alt="Spidey Buzz" title="Spidey Buzz" /></a></td>
	              </tr>
	            </table></td>
	        </tr>
	      </table></td>
	  </tr>
	  <tr bgcolor="#a6a6a6">
	      <td height="20">
	      <table cellpadding="0" cellspacing="0" width="100%">
	      	<tr>
	      		<td><span style="font:bold 16px \'Merriweather\', serif; color:#FFF; text-align:left;">Please click the Unsubscribe link below</span></td>
	      	</tr>
	      </table
	      </td>
	    </tr>
	  <tr>
	  	<td>
	        <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#535353" >
			  <tr>
			    <td><table align="center" width="100%"  border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;padding:10px;font-family: \'Roboto\'; color:#FFFFFF; font-size:18px;">
			        <tr>
			          <td><table cellpadding="0" cellspacing="0" width="100%" style="padding:20px;">
			              <tr>
			                <td><table cellpadding="0" cellspacing="0" width="80%" align="left">
			                    <tr>
			                      <td><span style="font-size:18px;font-family: \'Roboto\';color:#FFFFFF">For any queries contact <br />
			                        Customer Support: <br />
			                        <a href="#" style="text-decoration:none; color:#fea800;">cs@'.$_SERVER['SERVER_NAME'].'</a></span></td>
			                    </tr>
			                    <tr>
			                      <td height="20"></td>
			                    </tr>
			                    <tr>
			                      <td><span style="font-size:18px;font-family: \'Roboto\';color:#FFFFFF">Do not want to receive emails from us? <a href="'.base_url().'subscription/unsubscribed/'.encrypt_url($email.'/'.$reason).'" style="color:#ff0000;text-decoration:none;">Unsubscribe</a></span></td>
			                    </tr>
			                  </table></td>
			                <td valign="top"><table cellpadding="0" cellspacing="0" width="80%" align="right">
			                    <tr>
			                      <td align="right"><table>
			                          <tr>
			                            <td><a href="'.FACEBOOK_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/facebook.png" width="37" height="37" alt="Facebook" title="Facebook"  /></a></td>
			                            <td><a href="'.INSTAGRAM_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/instagram.png" width="37" height="37" alt="Instagram" title="Instagram"  /></a></td>
			                            <td><a href="'.TWITTER_PAGE.'"><img src="'.ASSETS_PATH.'sb-images/twitter.png" width="37" height="37" alt="Twitter" title="Twitter"  /></a></td>
			                            <td><a href="'.YOUTUBE_CHANNEL.'"><img src="'.ASSETS_PATH.'sb-images/youtube.png" width="37" height="37" alt="Youtube" title="Youtube"  /></a></td>
			                          </tr>
			                        </table></td>
			                    </tr>
			                    <tr>
			                      <td height="30"></td>
			                    </tr>
			                    <tr>
			                      <td align="right"><span style="font:bold 23px \'Merriweather\', serif; text-align:right; color:#FFFFFF;">For your daily dosage of Hyperlocal news</span></td>
			                    </tr>
			                  </table></td>
			              </tr>
			            </table></td>
			        </tr>
			      </table></td>
			  </tr>
			</table>
	    </td>
	  </tr>
	</table>
	</center>
	</body>
	</html>';
	//echo $content;exit;
	$data=array();
	$data['subject']= $subject;                                                                       
	$data['fromname']= $fromname;                                                             
	$data['api_key'] = $api_key;
	$data['from'] = $from;
	$data['content']= $content;
	$data['recipients']= $to;
	$apiresult = callApi(@$api_type,@$action,$data);
	return $apiresult;
}
?>