<?php
 // Check if Admin User logged in
 function admin_checklogin() {
 	$ci = & get_instance();
 	$user_id 	= $ci->session->userdata('admin_user_id');
 	$user_name 	= $ci->session->userdata('user_name');
 	if(empty($user_id) || empty($user_name)){
 		redirect('buzzadmn/login');	
 		exit;
 	}
 }
 // Check if Front User logged in
 
function checklogin() {
 	$ci = & get_instance();
 	$user_id 	= $ci->session->userdata('user_id');
 	$user_email_phone 	= $ci->session->userdata('user_email_phone');
 	if(empty($user_id) || empty($user_email_phone)){
 		redirect( base_url() );
 		exit;
 	}
 }
 
function slugify2($text){
     // replace non letter or digits by -
     $text = preg_replace('~[^\pL\d]+~u', '-', $text);
     $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
 	 // remove unwanted characters
     $text = preg_replace('~[^-\w]+~', '', $text);
     // trim
     $text = trim($text, '-');
     // remove duplicated - symbols
     $text = preg_replace('~-+~', '-', $text);
      // lowercase
     $text = strtolower($text);
      if (empty($text)) {
       return 'n-a';
     }
      return $text;
 }
 
function slugify($str, $options = array()) {
 	 $str = $str['urlName'];
 	// Make sure string is in UTF-8 and strip invalid UTF-8 characters
 	$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
 	$defaults = array(
 		'delimiter' => '-',
 		'limit' => null,
 		'lowercase' => true,
 		'replacements' => array(),
 		'transliterate' => false,
 	);
 	// Merge options
 	$options = array_merge($defaults, $options);
 	$char_map = array(
 		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
 		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
  		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
 		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
 		'ß' => 'ss', 
 		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
 		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
 		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
  		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
 		'ÿ' => 'y',
 		// Latin symbols
  		'©' => '(c)',
 		// Greek
 		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
 		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
 		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
  		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
 		'Ϋ' => 'Y',
 		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
 		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
 		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
 		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
 		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
 		// Turkish
 		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
   		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 
 		// Russian
 		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
  		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
 		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
 		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
 		'Я' => 'Ya',
  		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
  		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
  		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
 		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
 		'я' => 'ya',
 		// Ukrainian
 		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
 		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
  		// Czech
  		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
  		'Ž' => 'Z', 
 		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
 		'ž' => 'z', 
 		// Polish
 		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
  		'Ż' => 'Z', 
  		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
  		'ż' => 'z',
 		// Latvian
 		'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
 		'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
 		'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
 		'š' => 's', 'ū' => 'u', 'ž' => 'z'
 	);

 	// Make custom replacements
 	$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
  	// Transliterate characters to ASCII
  	if ($options['transliterate']) {
  		$str = str_replace(array_keys($char_map), $char_map, $str);
 	}

 	// Replace non-alphanumeric characters with our delimiter
  	$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
 	// Remove duplicate delimiters
 
	$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
 
	// Truncate slug to max. characters
 	$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
 
	// Remove delimiter from ends
 	$str = trim($str, $options['delimiter']);
 	 return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
 }

 
function getChildFromParent($id){
 	$res = 0;
  	$ci = & get_instance();
 	$ci->db->select('*');
  	$ci->db->from('categories');
 	$ci->db->where(array('parent'=>$id));
 	$ci->db->order_by("categoryName", "ASC");
 	$query = $ci->db->get();
 	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
  	}
 	return $res;
 }


function getChildFromParent_ATTR($id){



	$res = 0;



	$ci = & get_instance();



	$ci->db->select('*');



	$ci->db->from('attribute_name');



	$ci->db->where(array('parent'=>$id));



	$ci->db->order_by("name", "ASC");



	$query = $ci->db->get();



	if ($query->num_rows() > 0) {



		$res = $query->result_array();



 	}



	return $res;



	



}

 function get_sub_categories_ATTR($parent,$subcatId){



	 if($parent!=''){



		$ci 	= & get_instance();



		$ci->db->select('product_id, name');



 		$ci->db->where(array('status'=>'1', 'parent'=>$parent));



 		$query = $ci->db->get('attribute_name'); //echo '**'.$ci->db->last_query();exit;



		$res = $query->result_array();



		$result = '';



		 foreach($res as $rec =>$val){



			  $selected = "";



			 if($val['product_id']==$subcatId){



				 $selected = "selected";



			 }



			$result .='<option value="'.$val['product_id'].'" '.$selected.'>'.$val['name'].'</option>';



		 }



		//echo $ci->db->last_query();exit;



		return $result;



	 }



 }



function getUserNameById($id){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('user_name');
	$ci->db->from('backend_user');
	$ci->db->where(array('status'=>'1', 'user_id'=>$id));
 	$query = $ci->db->get();
	//echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = ucfirst($res[0]['user_name']);
 	}
	return $res;
}

function getUserParentIDById($userId){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('is_parent');
	$ci->db->from('backend_user');
	$ci->db->where(array('user_id'=>$userId));
 	$query = $ci->db->get();
	//echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = ucfirst($res[0]['is_parent']);
 	}
	return $res;
}



function getConsumerNameById($id){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('user_name');
	$ci->db->from('consumers');
	$ci->db->where(array('id'=>$id));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['user_name']);

 	}
	return $res;
}

function getRecLocationByInvoiceNumber($InvoiceNumber){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('location_name');
	$ci->db->from('receipt_stock_transfer_in');
	$ci->db->where(array('invoice_number'=>$InvoiceNumber));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['location_name']);

 	}
	return $res;
}

function getRecLocationTypeByInvoiceNumber($InvoiceNumber){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('location_type');
	$ci->db->from('receipt_stock_transfer_in');
	$ci->db->where(array('invoice_number'=>$InvoiceNumber));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['location_type']);

 	}
	return $res;
}

function getProductCodeActicationLevelbyCode($ProductCode){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('pack_level');
	$ci->db->from('printed_barcode_qrcode');
	$ci->db->where(array('barcode_qr_code_no'=>$ProductCode));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['pack_level']);

 	}
	return $res;
}

function getOrderIDbyCode($ProductCode){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('order_id');
	$ci->db->from('printed_barcode_qrcode');
	$ci->db->where(array('barcode_qr_code_no'=>$ProductCode));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['order_id']);

 	}
	return $res;
}

function getProductIDbyProductCode($ProductCode){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('product_id');
	$ci->db->from('printed_barcode_qrcode');
	$ci->db->where(array('barcode_qr_code_no'=>$ProductCode));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['product_id']);

 	}
	return $res;
}

function getCodeIDbyProductCode($ProductCode){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('id');
	$ci->db->from('printed_barcode_qrcode');
	$ci->db->where(array('barcode_qr_code_no'=>$ProductCode));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['id']);

 	}
	return $res;
}


function getProductCodeActicationLevelbyProductID($ProductID){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('pack_level');
	$ci->db->from('printed_barcode_qrcode');
	$ci->db->where(array('barcode_qr_code_no'=>$ProductID));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['pack_level']);

 	}
	return $res;
}



function getAssignedPlantIDbyProductCode($ProductCode){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('plant_id');
	$ci->db->from('printed_barcode_qrcode');
	$ci->db->where(array('barcode_qr_code_no'=>$ProductCode));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['plant_id']);

 	}
	return $res;
}


function getConsumerMobileNumberById($id){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('mobile_no');
	$ci->db->from('consumers');
	$ci->db->where(array('id'=>$id));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['mobile_no']);

 	}
	return $res;
}


function getConsumerFb_TokenById($consumer_id){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('fb_token');
	$ci->db->from('consumers');
	$ci->db->where(array('id'=>$consumer_id));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['fb_token']);

 	}
	return $res;

}


function getUserProfileById($id){
 	$image = '';
	if(!empty($id)){
		$ci = & get_instance();
		$ci->db->select('profile_photo');
		$ci->db->from('backend_user');
		$ci->db->where(array('status'=>'1', 'user_id'=>$id));
		$query = $ci->db->get();
		//echo $ci->db->last_query(); 
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$res1 = $res[0]['profile_photo'];
			if(file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$res1)){
				$image = base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$res1;
			}
		}
	}
 	return $image;
 }
 
 function getUserFullNameById($id){
 	$full_name = '';
	if(!empty($id)){
		$ci = & get_instance();
		$ci->db->select('concat(f_name," ",l_name) as name',FALSE);
		$ci->db->from('backend_user');
		$ci->db->where(array('status'=>'1', 'user_id'=>$id));
		$query = $ci->db->get();
		//echo $ci->db->last_query(); 
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$full_name = ucfirst($res[0]['name']);
		}
	}
 	return $full_name;
 }

 
 
 
 

// Front end user name



function getFrontUserNameById($id){



	$res = 0;



	$ci = & get_instance();



	$ci->db->select('first_name, user_email_phone');



	$ci->db->from('buzz_user');



	$ci->db->where(array('status'=>'1', 'user_id'=>$id));



 	$query = $ci->db->get();



	



	if ($query->num_rows() > 0) {



		$res = $query->result_array();



		if($res[0]['first_name'])



			$res = ucfirst($res[0]['first_name']);



		else



			$res = ucfirst($res[0]['user_email_phone']);



 	}



	return $res;



}







/*This function is used for get the all aopenion poll list : Anil :30/05/2017 */



function getPollOptionDetail($pollid) {



	$res = 0;



	$ci = & get_instance();



	$ci->db->select('option_id,poll_id,options_text,votes_counts');



	$ci->db->from('cs_polloptions');



	$ci->db->where(array('poll_id'=>$pollid));



 	$query = $ci->db->get();



	if ($query->num_rows() > 0) {



		$res = $query->result_array();



 	}



	return $res;        



 }



 /*



 /*This function is used for get country name : Anil :01/06/2017 */



 /*function get_country_name($countryId)



 {



		$res = 0;



		$ci = & get_instance();



		$ci->db->select('country_name');



		$ci->db->from('country');



		$ci->db->where(array('country_id'=>$countryId));



		$query = $ci->db->get();



		if ($query->num_rows() > 0) {



			$res = $query->result_array();



		}



		return $res; 



}



/*This function is used for get city name : Anil :01/06/2017 */



function get_state_name($country_id)



 {



		$res = 0;



		$ci = & get_instance();



		$ci->db->select('state_name, state_id');



		$ci->db->from('states');



		$ci->db->where(array('country_id'=>$country_id));



		$query = $ci->db->get();



		if ($query->num_rows() > 0) {



			$res = $query->result_array();



		}



		return $res; 



}

/*

/*This function is used for get city name : Anil :01/06/2017 */



 function get_city_name($cityId)
  {
 		$res = 0;
 		$ci = & get_instance();
 		$ci->db->select('ci_name');
 		$ci->db->from('city');
 		$ci->db->where(array('id'=>$cityId));
 		$query = $ci->db->get();
 		if ($query->num_rows() > 0) {
 			$res = $query->result_array();
 		}
  		return $res[0]['ci_name']; 
 }
 

 
 
 function getGroupList_GRPS_bkp($grpId='') {
 	$res = 0;
 	$ci = & get_instance();
  	$sql = "SELECT t1.usergroup_name AS lev1, t2.usergroup_name as lev2, t3.usergroup_name as lev3, t4.usergroup_name as lev4
 			FROM user_group_master AS t1
 			LEFT JOIN user_group_master AS t2 ON t2.ownershipid = t1.usergroup_id
 			LEFT JOIN user_group_master AS t3 ON t3.ownershipid = t2.usergroup_id
 			LEFT JOIN user_group_master AS t4 ON t4.ownershipid = t3.usergroup_id
 			WHERE t1.usergroup_id = '1' ;";
 	// $ci->db->select('*');



	//$ci->db->from('user_group_master');



	//$ci->db->where(array('status'=>1, 'usergroupid'=>$pollid));



 	$query = $ci->db->query($sql);



	if ($query->num_rows() > 0) {



		$res = $query->result_array();



 	}



	//echo '<pre>';print_r($res);exit;



	return $res;        



 }



 



  function getGroupList_GRPS($ownershipid='') {



	  if(empty($ownershipid)){



		  $ownershipid =getGroupId();



	  }



	$res = 0;



	$ci = & get_instance();



	$ci->db->select("usergroup_name,usergroup_id, ownershipid, user_id, rwa_id ");



	$ci->db->from('user_group_master'); 



	$ci->db->where('ownershipid',$ownershipid);



	//$ci->db->order_by("usergroup_name", "ASC");



	$query = $ci->db->get();  //echo '=='. $ci->db->last_query();



 	if ($query->num_rows() > 0) {



		$res = $query->result_array();



 	}



	



	return $res;        



 }



 



 



 function getGroupList_AD($grpId="") {



	$res = 0;



	$ci = & get_instance();



	$sql = "SELECT * FROM user_group_master where status = '1' and ownershipid='0'";



  	$query = $ci->db->query($sql);



	if ($query->num_rows() > 0) {



		$res = $query->result_array();



 	}



 	return $res[0];        



 }



 







 function getRWA_DD() {



	$res = 0;



	$ci = & get_instance();



	$ci->db->select('rwa_id, rwa_name');



	$ci->db->from('cs_rwadata');



	$ci->db->where(array('status'=>'1', 'is_visible'=>'1'));



	$ci->db->order_by("rwa_name", "ASC");



	$query = $ci->db->get();



	



	 if ($query->num_rows() > 0) {



		$res = $query->result_array();



 	}



	return $res;          



 }



 



 function get_all_groups_DD() {



	$res = 0;



	$ci = & get_instance();



	$ci->db->select('usergroup_id, usergroup_name,rwa_id,ownershipid');



	$ci->db->from('user_group_master');



	$ci->db->where(array('status'=>'1'));



	$ci->db->order_by("usergroup_name", "ASC");



	$query = $ci->db->get();



	



	 if ($query->num_rows() > 0) {



		$res = $query->result_array();



 	}



	return $res;          



 }



 







 // Get Countries



    function get_countries( $country_id = FALSE ) {



		$ci = & get_instance();



        if ( $country_id === FALSE ) {



            $query = $ci->db->select('country_id, country_name, created_on, created_by, lastupdated_on, lastupdated_by, status')



                    ->from('country')



                    ->order_by('created_on', 'DESC')



                    ->get();







            $res = $query->result_array();



        } else {



            $query = $ci->db->select('country_id, country_name, created_on, created_by, lastupdated_on, lastupdated_by, status')



                    ->from('country')



                    ->where( 'country_id', $country_id )



                    ->order_by('created_on', 'DESC')



                    ->get();



            $res = $query->row_array();



        }



        // echo $ci->db->last_query();



        return $res;



    }



	







    // Get States



    function get_states( $state_id = FALSE ) {



		$ci = & get_instance();



        if ( $state_id === FALSE ) {



            $query = $ci->db->select('state.state_id, country.country_id, country.country_name, state.state_name, state.created_on, state.created_by, state.lastupdated_on, state.lastupdated_by, state.status')



                    ->from('state AS state')



                    ->join('country AS country', 'country.country_id = state.country_id')



                    ->order_by('created_on', 'DESC')



                    ->get();







            $res = $query->result_array();



        } else {



            $query = $ci->db->select('state.state_id, country.country_id, country.country_name, state.state_name, state.created_on, state.created_by, state.lastupdated_on, state.lastupdated_by, state.status')



                    ->from('state AS state')



                    ->join('country AS country', 'country.country_id = state.country_id')



                    ->where( 'state.state_id', $state_id )



                    ->order_by('created_on', 'DESC')



                    ->get();



            $res = $query->row_array();



        }



        //echo $ci->db->last_query();







        return $res;



    }







    // Get City



    function get_cities( $city_id = FALSE ) {



		$ci = & get_instance();



        if ( $city_id === FALSE ) {



            $query = $ci->db->select('city.city_id, state.state_id, state.state_name, city.city_name, city.created_on, city.created_by, city.lastupdated_on, city.lastupdated_by, city.status')



                    ->from('city AS city')



                    ->join('state AS state', 'state.state_id = city.state_id')



                    ->order_by('created_on', 'DESC')



                    ->get();







            $res = $query->result_array();



        } else {



            $query = $ci->db->select('city.city_id, state.state_id, state.state_name, city.city_name, city.created_on, city.created_by, city.lastupdated_on, city.lastupdated_by, city.status')



                    ->from('city AS city')



                    ->join('state AS state', 'state.state_id = city.state_id')



                    ->where( 'city.city_id', $city_id )



                    ->order_by('created_on', 'DESC')



                    ->get();



            $res = $query->row_array();



        }







        return $res;



    }







    // Get Areas



    function get_areas( $area_id = FALSE ) {



		$ci = & get_instance();



        if ( $area_id === FALSE ) {



            $query = $ci->db->select('area.area_id, city.city_id, city.city_name, area.area_name, area.created_on, area.created_by, area.lastupdated_on, area.lastupdated_by, area.status')



                    ->from('cs_area AS area')



                    ->join('city AS city', 'city.city_id = area.city_id')



                    ->order_by('created_on', 'DESC')



                    ->get();







            $res = $query->result_array();



        } else {



            $query = $ci->db->select('area.area_id, city.city_id, city.city_name, area.area_name, area.created_on, area.created_by, area.lastupdated_on, area.lastupdated_by, area.status')



                    ->from('cs_area AS area')



                    ->join('city AS city', 'city.city_id = area.city_id')



                    ->where( 'area.area_id', $area_id )



                    ->order_by('created_on', 'DESC')



                    ->get();



            $res = $query->row_array();



        }







        return $res;



    }



	



function get_user($id)
  {



		$res = 0;



		$ci = & get_instance();



		$ci->db->select('*');



		$ci->db->from('buzz_user');



		$ci->db->where(array('user_id'=>$id));



		$query = $ci->db->get();



		if ($query->num_rows() > 0) {



			$res = $query->result_array();



		}



		return $res; 



}



/*This function is used for get rwa usename : Anil :01/06/2017 */



function get_rwa_username($createdBy)



 {



		$res = 0;



		$ci = & get_instance();



		$ci->db->select('user_name');



		$ci->db->from('backend_user');



		$ci->db->where(array('user_id'=>$createdBy));



		$query = $ci->db->get();



		if ($query->num_rows() > 0) {



			$res = $query->result_array();



		}



		return $res; 



}



 



function getGroupId(){



	$ci = & get_instance();



	$id = $ci->session->userdata('admin_user_id');



	$res = 0;



	$id = !empty($id)?$id:0;



	



	$ci->db->select('*');



	$ci->db->from('backend_user');



	$ci->db->where(array('status'=>'1', 'user_id'=>$id));



 	$query = $ci->db->get();



	//echo '***'.$ci->db->last_query();exit;



	 if ($query->num_rows() > 0) {



		$res = $query->result_array();



		$res = $res[0]['usergroup_id'];



 	}



	return $res;        



	



}

function getMenuList($id='',$option='',$parent=''){//echo '***'.$id;
	if(!empty($option)){
		$visible_menu_list = explode(',',json_decode($option));
	}
	//echo '<pre>';print_r($visible_menu_list);exit;
 	$res = 0;
	$id = !empty($id)?$id:'';
	$ci = & get_instance();
	$ci->db->select('*');
	$ci->db->from('menu_master');
	$ci->db->where(array('status'=>'1'));
	// 
	if($id==''){
		$ci->db->where('parent',0);
	}elseif($id>0){
		$ci->db->where('parent',$id);
	}
	if(!empty($option)){
		$ci->db->where_in('id',$visible_menu_list);
	}//echo $ci->db->last_query();
	//$ci->db->where(array('parent'=>$id));
	//$ci->db->order_by("type", "ASC");
	$ci->db->order_by('order_by','asc');
	$query = $ci->db->get();
	  //echo $ci->db->last_query(); 
	 if ($query->num_rows() > 0) {
		$res = $query->result_array();
 	}
	return $res;          
 }


function getMenuIDByGroup($parent=''){
	$res = 0;
 	$ci = & get_instance();
	$ci->db->select('*');
	$ci->db->from('menu_master_permission');
	if(empty($parent)){
		$ci->db->where(array('status'=>'1'));
	}else if($parent==1){
		$ci->db->where(array('status'=>'1', 'id'=>2));
	}else{
		$ci->db->where(array('status'=>'1', 'id'=>3));
	}
	
 	$query = $ci->db->get();//echo $ci->db->last_query();
	 if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = $res[0]['show_hide_chks'];
 	} 
	return $res;  
 }
 

function getParentIdFromUserId(){
	$ci = & get_instance();
	$userId = $ci->session->userdata('admin_user_id');
	
	$ci->db->select('is_parent');
	$ci->db->from('backend_user');
	$ci->db->where(array('status'=>'1','user_id'=>$userId));
	$query = $ci->db->get();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = $res[0]['is_parent'];
	} 
	return $res;  
}

function getParentIdFromUserIdTAPP($userId){
	$ci = & get_instance();
	//$userId = $ci->session->userdata('admin_user_id');
	
	$ci->db->select('is_parent');
	$ci->db->from('backend_user');
	$ci->db->where(array('status'=>'1','user_id'=>$userId));
	$query = $ci->db->get();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = $res[0]['is_parent'];
	} 
	return $res;  
}


function getDepth($id='',$cnt1){
 	$ci = & get_instance();
  	$sql = "select ownershipid from user_group_master";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
  	$result =$res[0]['ownershipid'];
 	if($result!=0){
 		$cnt1=$cnt1+1;
  		return getDepth($result,$cnt1);
 	}
  	return $cnt1;
 	 //echo '<pre>';print_r( $cnt1);exit;
  }

 
 
 function getMenuIDForSubAdmin(){
	$res = 0;
	//$grp_id = getGroupId();
	//getDepth($grp_id,0);
	//$grp_id = !empty($grp_id)?$grp_id:0;
	$ci = & get_instance();
	$ci->db->select('*');
	$ci->db->from('menu_master_permission');
	$ci->db->where(array('status'=>'1'));
 	$query = $ci->db->get();
	 if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = $res[0]['show_hide_chks'];
 	} 
	return $res;  
 }

 function displayGroupName(){
	$res = '';
 	$ci = & get_instance();
	$id = $ci->session->userdata('admin_user_id');
	$res = 0;
	$id = !empty($id)?$id:0;
	$ci->db->select('U.usergroup_name');
	$ci->db->from('user_group_master as U');
	$ci->db->join('backend_user as B', 'U.usergroup_id = B.usergroup_id', 'left');
	$ci->db->where(array('U.status'=>'1', 'B.user_id'=>$id));
 	$query = $ci->db->get();
	 if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = $res[0]['usergroup_name'];
 	}
	return $res;        
 }


 function displayGroupNameByUrl(){
	$res = '';



 	$ci = & get_instance();



	$id = $ci->uri->segment(3);



	$res = 0;



	$id = !empty($id)?$id:'';



	if($id!=''){



		$ci->db->select('U.usergroup_name');



		$ci->db->from('user_group_master as U');



		$ci->db->join('backend_user as B', 'U.usergroup_id = B.usergroup_id', 'left');



		$ci->db->where(array('U.status'=>'1', 'U.usergroup_id'=>$id));



		$query = $ci->db->get();



		// echo $ci->db->last_query();



		 if ($query->num_rows() > 0) {



			$res = $query->result_array();



			$res = $res[0]['usergroup_name'];



		}



	}else{



		$res='';



	}



	return $res;        



 }



 



 // Get TDS section list



function get_Tds_Section( $tds_id = FALSE ) {



	$ci = & get_instance();



    if ( $tds_id === FALSE ) {



        $query = $ci->db->select('id,section,name,tds_rate,surcharge_rate,edu_rate,case_rate,status')



                ->from('cs_tds_section')



				->where('status',1)



                ->order_by('name', 'ASC')



                ->get();







        $res = $query->result_array();



    } else {



        $query = $ci->db->select('id,section,name,tds_rate,surcharge_rate,edu_rate,case_rate,status')



                ->from('cs_tds_section')



                ->where( 'id', $tds_id )



                ->order_by('name', 'ASC')



                ->get();



        $res = $query->row_array();



    }



    // echo $ci->db->last_query();



    return $res;



}







// Get User Details by ID



function get_user_details_by_id( $userid ) {



	$ci = & get_instance();



	$query = $ci->db->select('userid, username, displayname, firstname, lastname, mobile, email, rwaid, profilephoto')



		->from('cs_userdetails')



		->where(array('userid' => $userid))



		->get();



		$ci->db->last_query();



	return $query->row_array();



}



function check_opinion_poll_options($rwa_type){



		$res = 0;



		$ci = & get_instance();



		$ci->db->select('rwa_id,rwa_type,opinion_poll_options');



		$ci->db->from('cs_rwa_setup');



		$ci->db->where(array('rwa_type'=>$rwa_type));



		$query = $ci->db->get();



		if ($query->num_rows() > 0) {



			$res = $query->result_array();            



		}		



	return $res;



} 







function notification_count(){



	$ci 			= & get_instance();



	## Chcek Login type



	$login_type 	= $ci->session->userdata('login_type');



	## Login type



  	



	$id 			= $ci->session->userdata('admin_user_id');



	$res 			= 0;



	$id 			= !empty($id)?$id:0;



 	



	$ci->db->select('count(1) as cnt');



	$ci->db->from('buzz_idea');



	//$ci->db->where(array('status'=>'1'));



	if($login_type=='reporter'){ 



		$ci->db->where("(is_notification_read=0 and  status=0 and (created_by='".$id."' or updated_by='".$id."') and(assigned=0 OR assigned=2))");



	}



	if($login_type=='input'){



		$ci->db->where("(is_notification_read=0 and  status=1 and (assigned=1 OR assigned=3))");



	}



	



 	$query = $ci->db->get();//echo '****'.$ci->db->last_query();exit;



	$res = $query->result_array();



	return $res = $res[0]['cnt'];         



 }



 



  function notifications_list(){



	$ci 	= & get_instance();



	$id 			= $ci->session->userdata('admin_user_id');



	$id 			= !empty($id)?$id:0;



	



	## Chcek Login type



	$login_type 	= $ci->session->userdata('login_type');



	## Login type



 	$ci->db->select('title, id,created_by,  COUNT(id) as total');



	$ci->db->group_by('created_by'); 



	//$ci->db->where(array('status'=>'1'));



	



	if($login_type=='reporter'){ 



		$ci->db->where("(is_notification_read=0 and status=0 and (created_by='".$id."' or updated_by='".$id."') and(assigned=0 OR assigned=2))");



	}



	if($login_type=='input'){



		$ci->db->where("(is_notification_read=0 and status=1 and (assigned=1 OR assigned=3))");



	}



	



	$ci->db->order_by('created_on', 'desc'); 



	$query = $ci->db->get('buzz_idea');



 	$res = $query->result_array();



 	// echo $ci->db->last_query(); 



 	return $res; 



 }



  function limitstr($string,$limit=''){



	  $str = $string; 



	  if(strlen($string)>$limit){



		  $str = substr($string, 0,$limit).'..'; 



	  }



	  return $str;



 }



 



 function IsSuperGroup($user_group_id){



	 if($user_group_id!=''){



		$ci 	= & get_instance();



		$ci->db->select('owershipid');



 		$ci->db->where(array('status'=>'1', 'usergroup_id'=>$user_group_id));



 		$query = $ci->db->get('user_group_master');



		$res = $query->result_array();



		$result = $res[0]['owershipid']; 



		//echo $ci->db->last_query();exit;



		return $result;



	 }



 }



 function get_sub_categories($parent,$subcatId){



	 if($parent!=''){



		$ci 	= & get_instance();



		$ci->db->select('category_Id, categoryName');



 		$ci->db->where(array('status'=>'1', 'parent'=>$parent));



 		$query = $ci->db->get('categories'); //echo '**'.$ci->db->last_query();exit;



		$res = $query->result_array();



		$result = '';



		 foreach($res as $rec =>$val){



			  $selected = "";



			 if($val['category_Id']==$subcatId){



				 $selected = "selected";



			 }



			$result .='<option value="'.$val['category_Id'].'" '.$selected.'>'.$val['categoryName'].'</option>';



		 }



		//echo $ci->db->last_query();exit;



		return $result;



	 }



 }



 function editorial_logIn_By_Designation($user_id){



	 $return_res = '0';



	 if($user_id!=''){



		$ci 	= & get_instance();



		$ci->db->select('dept_id, designation_id');



 		$ci->db->where(array('status'=>'1', 'user_id'=>$user_id));



 		$query = $ci->db->get('backend_user');



		$res = $query->result_array();



		$result['designation_id'] 			= $res[0]['designation_id']; 



		$result['department_id'] 			= $res[0]['dept_id']; 



		//echo $ci->db->last_query();exit;



		



		if($result['department_id']			== '9' && $result['designation_id']=='15'){



			$return_res = 'reporter';



 			$session_Data = array('editorial_login' => 'reporter');



 		}else if($result['department_id']	== '9' && $result['designation_id']=='16'){



			$return_res = 'input';



 		}else if($result['department_id']	== '10'&& $result['designation_id']=='39'){



			$return_res = 'output1';# For Head OP



 		}else if($result['department_id']	== '10'&& $result['designation_id']=='40'){



 			$return_res = 'output2';# For juniou OP



		}



 	 }



 	 return $return_res;



 }



 



 /*  function user_notifications_list($user_id){



	$ci = & get_instance();



 	$ci->db->select('C.*,U.*');



	$ci->db->from('comments as C');



	$ci->db->join('buzz_user as U','C.user_id = U.user_id');



	$ci->db->where(array('C.user_id'=>$user_id,'C.is_visible'=>'0')); 



	$ci->db->order_by('C.id', 'desc'); 



	$query = $ci->db->get();



 	$res = $query->result_array();



 	//echo $ci->db->last_query();exit;



 	return $res; 



 }



 */



 function get_hours_difference( $date_1, $date_2 ) {



	



	$seconds = strtotime($date_1) - strtotime($date_2);



    $hours = round(abs($seconds / 60 / 60));



  	



  	 



  	if( $hours == 0 ){



        $days_ago='0h';



    }else if( $hours == 1 ){



        $days_ago = $hours. "h";



    }else if( $hours > 1 && $hours < 24){



        $days_ago = $hours. "h";



	}else{



	



  	$days	= ceil(abs($hours /24));



  



	$days_ago= $days. "d";



	}







  	return $days_ago;



}







function get_subCategory($parent_id){



	//$categories = array();



  $ci = & get_instance();



 $ci->db->where('parent', $parent_id);



 $ci->db->order_by('category_Id', 'desc'); 



  $result = $ci->db->get('categories')->result();



  



 return $result;	



	



}  



function get_subCategoryName($id){
 
  $ci = & get_instance();
 
 $ci->db->where('category_Id', $id);

  $result = $ci->db->get('categories')->row_array();

  return $result['categoryName'];	

 } 

function get_subCategoryName_ATTR($id){
 
  $ci = & get_instance();
 
 $ci->db->where('product_id', $id);

  $result = $ci->db->get('attribute_name')->row_array();

  return $result['name'];	

 } 






## Create Story Dwetail URL



function getstoryurl($storyId){



	$result_data = array();



	if(!empty($storyId)){



		$ci = & get_instance();



		$ci->db->select('*');



		$ci->db->from('spidypick');



 		$ci->db->where(array('spidypickId'=>$storyId,'status'=>'1')); 



 		$query = $ci->db->get();



		$res = $query->result_array();



		$result = $res[0];



		$date =date('Y/m/d/',strtotime($result['createdDate']));



		$url = base_url().trim($date).trim($result['story_url']);



		$result_data['url'] = $url; 



		$result_data['data'] = $result;



		//echo $ci->db->last_query();exit;



  	}



	return $result_data; 



}







function getstory($url){



	$result_data = array();



	if(!empty($url)){



		$ci = & get_instance();



		$ci->db->select('*');



		$ci->db->from('spidypick');



 		$ci->db->where(array(TRIM('story_url')=>trim($url),'status'=>'1')); 



 		$query = $ci->db->get();// echo '<pre>';print_r($ci->db->last_query());exit;



		$res = $query->result_array();



		$result = $res[0];



		



  	}







	return $result; 



}







function get_news_also_like($sid){



	   $ci = & get_instance();



	   $id =explode(',',$ids);



	  //if($ids)$ci->db->where_in('spidypickId',$id);



	  $ci->db->where('spidypickId!=',$sid);



       $ci->db->order_by('createdDate', 'DESC');



	   $ci->db->limit(3,30);



       $res = $ci->db->get("spidypick")->result_array();



	  // echo $ci->db->last_query(); //die;



	   return $res;



}



function get_Related_Story_Details($ids,$sid){



	   $ci = & get_instance();



	   $id =explode(',',$ids);



	  if($ids)$ci->db->where_in('spidypickId',$id);



	  $ci->db->where('spidypickId!=',$sid);



       $ci->db->order_by('createdDate', 'DESC');



	   //$ci->db->limit(3,0);



       $res = $ci->db->get("spidypick")->result_array();



	  // echo $ci->db->last_query(); die();	   



	   return $res;



}







function get_news_also_read($id,$ids){



	   $ci = & get_instance();



	   $rid =explode(',',$ids);



	   $ci->db->where_in('spidypickId',$rid);



	   $ci->db->where('spidypickId != ',$id);



	   $ci->db->where('status','1');



       $ci->db->order_by('createdDate', 'DESC');



	   //$ci->db->limit(4,0);



		



       $res = $ci->db->get("spidypick")->result_array();



	   //echo $ci->db->last_query();



	   return $res;



}







## Get Buzz User Name



function getBuzzUserNameById($id){



	$res = 0;



	$ci = & get_instance();



	$ci->db->select('first_name, last_name');



	$ci->db->from('buzz_user');



	$ci->db->where(array('status'=>'1', 'user_id'=>$id));



 	$query = $ci->db->get();



	//echo $ci->db->last_query(); 



	if ($query->num_rows() > 0) {



		$res = $query->result_array();



		$res = ucfirst($res[0]['first_name'].'  '. $res[0]['last_name']);



 	}



	return $res;



	



}











  function get_seo($name){



	$ci 	= & get_instance();



 	$ci->db->select('title,description,keywords');



	if($name==''){



		$ci->db->where('page','home');



	



	}else{



		$ci->db->where('page',$name);



	}



	$query = $ci->db->get('page_seo');



 	$res = $query->result_array();



 	//echo $ci->db->last_query();exit;



 	return $res; 



 }



 



 #get CityId from Area ID



 function getCityFromArea($ids){



	$ci 	= & get_instance();



 	$ci->db->select('city_id');



	$ci->db->where_in('area_id',$ids);



	$query = $ci->db->get('tbl_area');



 	$res = $query->result_array();



 	//echo $ci->db->last_query();exit;



 	return $res; 



 }



 



 



 #get State from Cities ID



 function getStateFromCity($ids){



	$ci 	= & get_instance();



 	$ci->db->select('state_id');



	$ci->db->where_in('city_id',$ids);



	$query = $ci->db->get('tbl_city');



 	$res = $query->result_array();



 	//echo $ci->db->last_query();exit;



 	return $res; 



 }



 



 #get Areas from City ID



 function get_areas_by_city_id( $city_id ) {



 	$result = array();



	$ci = & get_instance();



 	$ci->db->select( '*' );



 	$ci->db->from( 'tbl_area' );



	$ci->db->where( 'city_id', $city_id) ;



	$query = $ci->db->get();



 	$result = $query->result_array();



 	return $result; 



 }



 



 #get Areas from City ID



 function get_city_details_by_id( $city_id ) {



 	$result = array();



	$ci = & get_instance();



 	$ci->db->select( '*' );



 	$ci->db->from( 'tbl_city' );



	$ci->db->where( 'city_id', $city_id) ;



	$query = $ci->db->get();



 	$result = $query->result_array();



 	return $result;



 }















	function get_tags(){



		$ci 	= & get_instance();



		$ci->db->select('tags');



		$ci->db->where('status',1);



		$ci->db->order_by('createdDate', 'DESC');



		$query = $ci->db->get('spidypick');



		$res = $query->result_array();



		$str="";



		foreach($res as $single){



		if($single['tags']!='')$str.= $single['tags'].","; 



		}



		//echo $str;



		$array = explode(",",$str);



		$unique = array_unique($array);



		return $unique; 



	}























 function getSpidypickCommentsCounts($s_id) {



   $ci 	= & get_instance();



    $row = $ci->db



                    ->select('count(id) as count')



                    ->from('comments')



                    ->where('content_id', $s_id)



                    ->where('content_type', '1')



                    ->get()



                    ->result_array();



    return $row[0]['count'];



}



 



 function menu_permissions_login($userId='', $grpId=''){



	$result = array();



	$res=array();



	if(!empty($grpId)){



		$ci 	= & get_instance();



		$ci->db->select('*');



		$ci->db->where(array('usergroup_id'=>$grpId));



		$query = $ci->db->get('menu_master_permission');



		$res = $query->result_array();



		



		@$result=$res[0];



		  //echo $ci->db->last_query();exit;



	}



 	return $result;  



 }



 



 



 ## Single file download



  function file_download($fileName = NULL) {



		$ci->load->helper('download');  



		$fileName = "video_12_1500104173344.MP4";



		   if ($fileName){



			$file =  'uploads/'.$fileName;



			// check file exists    



			if (file_exists ( $file )) {//echo 'kamalssssssssssss';exit;



			 // get file content



			 $data = file_get_contents ( $file );



			 //force download



			 force_download ( $fileName, $data );



			} else {



			 // Redirect to base url



			 redirect ( base_url () );



			}



		   }



		}



	## Zip for all file download	



 



		function zipFilesAndDownload($storyid)



		{	 



 			$getMediaData = getMediaData($storyid);



  			$file_path = './uploads/';



			$files = array_filter($getMediaData);



 			//array('59c8d31fdc4db.jpg', '59c8d320ca186.jpg');



 			 ##



 			 	##merge all the elements in a string with comma separated string



				foreach($files as $f){  



					$result_file .= ','.$f;



				}



 				$files_all = array();



				$files_all = array_filter(explode(',',$result_file));



			 ##



 			$zipname = 'file.zip';



 			$zip = new ZipArchive;



			$zip->open($zipname, ZipArchive::CREATE);



			 



			foreach ($files_all as $file) {//echo '<pre>';print_r($file);exit;



  				$zip->addFile(trim($file_path).trim($file)); 



  			} 



			$zip->close();



 			//then send the headers to download the zip file



 			header("Content-type: application/zip");



			header("Content-Disposition: attachment; filename=$zipname");



 			header("Cache-Control: no-cache, must-revalidate");



			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");



 			//header("Pragma: no-cache");



			//header("Expires: 0");



			readfile("$zipname");



			exit; 



		}







		## get Media data from StoryId



		function getMediaData($storyid){



			$result	= array();



			$res 	= array();



			$ci 	= & get_instance();



			$ci->db->select('images, videos, audios, attachments, demovideos, demoaudios, demoattachments');



			$ci->db->where_in('story_id',$storyid);



			$query  = $ci->db->get('buzz_media_master');



			$res 	= $query->result_array();



			if(count($res)>0){



				$result = $res[0];



			}



			//echo $ci->db->last_query();exit;



			return $result; 



		}



	



	 



  function user_notifications_list($user_id){



	## For post comment



	



	$ci = & get_instance();



 	$ci->db->select('N.id as nid,N.*,U.user_id as uid,U.*,S.spidypickId');



	$ci->db->from('notification as N');



	$ci->db->join('buzz_user as U','N.user_post_id = U.user_id');



	$ci->db->join('spidypick as S','N.content_id = S.spidypickId');



	$ci->db->where(array('N.user_post_id'=>$user_id,'N.view_one'=>0)); 



	$ci->db->order_by('N.id', 'desc'); 



	$query = $ci->db->get();



	$res['post'] = $query->result_array();



	



	$ci->db->flush_cache();



	## For reply comment



	



	



	//$ci = & get_instance();



 	$ci->db->select('N.id as nid,N.*,U.user_id as uid,U.*,S.spidypickId');



	$ci->db->from('notification as N');



	$ci->db->join('buzz_user as U','N.user_reply_id = U.user_id');



	$ci->db->join('spidypick as S','N.content_id = S.spidypickId');



	$ci->db->where(array('N.user_reply_id'=>$user_id,'N.view_two'=>0)); 



	$ci->db->order_by('N.id', 'desc'); 



	$query = $ci->db->get();



	$res['reply'] = $query->result_array();



	//$res['count']= count($res['post'])+count($res['reply']);



	  



	  



	  



	## User gets reply for their posts



	$comment_id_arr = array();



	foreach($res['post'] as $val){



		if($val['parent_id']=='0'){



		$comment_id_arr[]=$val['comment_id'];



		}



	}



	



	//echo '<pre>';print_r($comment_id_arr);exit;



	$res['reply_posts'] =array();



	if(@count($comment_id_arr)>0){



	$ci->db->select('N.id as nid,N.*,U.user_id as uid,U.*,S.spidypickId');



	$ci->db->from('notification as N');



	$ci->db->join('buzz_user as U','N.user_reply_id = U.user_id');



	$ci->db->join('spidypick as S','N.content_id = S.spidypickId');



	$ci->db->where(array('N.user_post_id'=>0,'N.view_two'=>0));



	$ci->db->where_in('comment_id',$comment_id_arr); 



	



	$ci->db->order_by('N.id', 'desc'); 



	$query = $ci->db->get();



	$res['reply_posts'] = $query->result_array();//echo $ci->db->last_query();



	}



	



	$res['count']= count($res['reply_posts'])+count($res['post'])+count($res['reply']);	



 	return $res; 



 }







// Get all stories details data by buzz idea id



function get_story_idea_detail( $story_id ) {



	$ci = & get_instance();



	$res = array();



	$login_type = $ci->session->userdata('login_type');



	$status = ( $login_type == 'reporter' ) ? 0 : 1;







	$ci->db->select('detail.*');



	$ci->db->from('bizz_detail_master AS detail');



	$ci->db->join('buzz_idea AS idea', 'detail.story_id=idea.id');



	$ci->db->where(



		array(



			'idea.id'=>$story_id,



			'detail.status'=>'1',



			'idea.status'=>$status



		)



	);







	$query = $ci->db->get();



	//echo $ci->db->last_query();



	$query->num_rows();



	if ($query->num_rows() > 0) { 



		$res = $query->result_array();



	}



	return $res[0];



}







// Get Story by Story ID



function get_story_details( $story_id ) {
	$ci = & get_instance();
	$res = array();
	$ci->db->select('*');
	$ci->db->from('spidypick');
	$ci->db->where( array( 'spidypickId' => $story_id ) );
	$query = $ci->db->get();
	$query->num_rows();
	if ($query->num_rows() > 0) { 
		$res = $query->result_array();
	}

	return $res[0];
}







function facebook_data(){



		$ci = & get_instance();



		$ci->load->library('facebook');



		$userData = array();



		$ci->load->library('session');



		if(@$_GET['error']=='access_denied'){ redirect("home/logout");echo "<script>window.close();window.opener.location.reload();</script>";



		}



		



		// Check if user is logged in



		if(@$ci->facebook->is_authenticated()){



			// Get user facebook profile details



			$userProfile = $ci->facebook->request('get', '/me?fields=id,first_name,last_name,email,picture');



            // Preparing data for database insertion



            $userData['oauth_provider'] = 'facebook';



            $userData['oauth_uid'] = $userProfile['id'];



            $userData['first_name'] = $userProfile['first_name'];



            $userData['last_name'] = $userProfile['last_name'];



            $userData['user_email_phone'] = $userProfile['email'];



			$userData['login_from'] = 'email';



			$userData['is_verified'] = 1;



			$userData['status'] = '1';



            $userData['profile_pick'] = $userProfile['picture']['data']['url'];



			$ci->load->model('Home/Home_model');



			



            // Insert or update user data



            $userID = $ci->Home_model->checkUser($userData);



			



			// Check user data insert or update status



            if(!empty($userID)){



             



			 $ci->session->set_userdata('user_id',$userID);



			 $ci->session->set_userdata('user_email_phone',$userData['user_email_phone']);



			 echo "<script>window.close();window.opener.location.reload();</script>";



			 //if($ci->db->affected_rows()) redirect(base_url());



				



            } else {



               $userData = array();



            }



			



			// Get logout URL



			$userData['logoutUrl'] = $ci->facebook->logout_url();



		}else{



            $fbuser = '';



			



			// Get login URL



            $userData['authUrl'] =  $ci->facebook->login_url();



        }



		return $userData;



}







function twitter_data(){



	if(isset($_GET['denied'])) echo "<script>window.close();window.opener.location.reload();</script>";



	$ci = & get_instance();



	



	$userData = array();



		



		//Include the twitter oauth php libraries



		include_once APPPATH."libraries/twitter-oauth/twitteroauth.php";



		



		//Twitter API Configuration



		$consumerKey = 'nr1242bbmfrorxPazbxYAVWrC';



		$consumerSecret = '2OyVizB5NNRSZSm8ouydlRF761t89JMISrlpS6AeByd8EdCMmx';



		$oauthCallback = base_url();



		$ci->load->model('Home/Home_model');



			$ci->load->library('session');



		//Get existing token and token secret from session



		$sessToken = $ci->session->userdata('token');



		$sessTokenSecret = $ci->session->userdata('token_secret');



		



		//Get status and user info from session



		



		$sessStatus = $ci->session->userdata('status');



		



		 $sessUserData = $ci->session->userdata('userData');



		 //print_r($sessUserData);



		//die;



		if(isset($sessStatus) && $sessStatus == 'verified'){



			



			//Connect and get latest tweets



			$connection = new TwitterOAuth($consumerKey, $consumerSecret, $sessUserData['accessToken']['oauth_token'], $sessUserData['accessToken']['oauth_token_secret']); 



			$data['tweets'] = $connection->get('statuses/user_timeline', array('screen_name' => $sessUserData['username'], 'count' => 5));







			//User info from session



			$userData = $sessUserData;



			



		}elseif(isset($_REQUEST['oauth_token']) && $sessToken == $_REQUEST['oauth_token']){



			



			//Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name



			$connection = new TwitterOAuth($consumerKey, $consumerSecret, $sessToken, $sessTokenSecret); 



			$accessToken = $connection->getAccessToken($_REQUEST['oauth_verifier']);



			if($connection->http_code == '200'){



				//Get user profile info



				$params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');



				$userInfo = $connection->get('account/verify_credentials', $params);



                //print_r($userInfo);die;



				//Preparing data for database insertion



				$name = explode(" ",$userInfo->name);



				$first_name = isset($name[0])?$name[0]:'';



				$last_name = isset($name[1])?$name[1]:'';



				$userData = array(



					'first_name' => $first_name,



					'last_name' => $last_name,



					'user_email_phone' => $userInfo->email,



					'login_from' => 'email',



					'is_verified' => 1,



			        'status' => '1',



					'profile_pick' => $userInfo->profile_image_url,



					'oauth_provider' => 'twitter',



					'oauth_uid' => $userInfo->id,



				);



				



				//Insert or update user data



				$userID = $ci->Home_model->checkUser($userData);



				if(!empty($userID)){



             



			 $ci->session->set_userdata('user_id',$userID);



			 $ci->session->set_userdata('user_email_phone',$userData['user_email_phone']);



			 echo "<script>window.close();window.opener.location.reload();</script>";	



            } else {



               $userData = array();



            }



				//Store status and user profile info into session



				$userData['accessToken'] = $accessToken;



				$ci->session->set_userdata('status','verified');



				$ci->session->set_userdata('userData',$userData);



				



				//Get latest tweets



				$data['tweets'] = $connection->get('statuses/user_timeline', array('screen_name' => $userInfo->screen_name, 'count' => 5));



			}else{



				$data['error_msg'] = 'Some problem occurred, please try again later!';



			}



		}else{



			//unset token and token secret from session



			$ci->session->unset_userdata('token');



			$ci->session->unset_userdata('token_secret');



			



			//Fresh authentication



			$connection = new TwitterOAuth($consumerKey, $consumerSecret);



			$requestToken = $connection->getRequestToken($oauthCallback);



			



			//Received token info from twitter



			$ci->session->set_userdata('token',$requestToken['oauth_token']);



			$ci->session->set_userdata('token_secret',$requestToken['oauth_token_secret']);



			



			//Any value other than 200 is failure, so continue only if http code is 200



			if($connection->http_code == '200'){



				//redirect user to twitter



				$twitterUrl = $connection->getAuthorizeURL($requestToken['oauth_token']);



				$data['oauthURL'] = $twitterUrl;



			}else{



				$data['oauthURL'] = base_url().'user_authentication';



				$data['error_msg'] = 'Error connecting to twitter! try again later!';



			}



        }







		$data['userData'] = $userData;



		return $data;



}







function google_data(){



	



	    $ci = & get_instance();



		$ci->load->library('google');



		if(strlen($_GET['code'])<100 && strlen($_GET['code'])>0){



			//authenticate user



			$ci->google->getAuthenticate();



			//;



			



			//get user info from google



			$gpInfo = $ci->google->getUserInfo();



			//print_r($gpInfo);exit;



            //preparing data for database insertion



			



            $userData['first_name'] 	= $gpInfo['given_name'];



            $userData['last_name'] 		= $gpInfo['family_name'];



            $userData['user_email_phone'] = $gpInfo['email'];



			$userData['login_from'] 		= 'email';



			$userData['is_verified'] = 1;



			$userData['status'] = '1';



            $userData['profile_pick'] 	= !empty($gpInfo['picture'])?$gpInfo['picture']:'';



			$userData['oauth_provider'] = 'google';



			$userData['oauth_uid'] 		= $gpInfo['id'];



			$ci->load->model('Home/Home_model');



			$ci->load->library('session');



			//insert or update user data to the database



            $userID = $ci->Home_model->checkUser($userData);



			if(!empty($userID)){



			//store status & user info in session



			$ci->session->set_userdata('user_id',$userID);



			$ci->session->set_userdata('userData', $userData);



			$ci->session->set_userdata('user_email_phone',$userData['user_email_phone']);



			echo "<script>window.close();window.opener.location.reload();</script>";exit;	



			} else {



               $userData = array();



            }



			//redirect to home page



			//redirect('home');



		} 



		



		//google login url



		$data['loginURL'] = $ci->google->loginURL();



			



	return $data;



	



	



}







function get_stories_for_newsletter() {



	$result = array();



	$ci = & get_instance();



	$ci->db->select('s.*,c.*')



		->from('spidypick AS s')



		->join('categories AS c', 's.category_id=c.category_Id')



		->where( array( 's.status' => 1 ) )



		->order_by('s.spidypickId', 'DESC')



		->limit(4);







	$query = $ci->db->get();







	$query->num_rows();



	if ($query->num_rows() > 0) { 



		$result = $query->result_array();



	}







	return $result;



}







function get_designation(){



	   $ci = & get_instance();



	   $ci->db->where('status','1');



       $ci->db->order_by('created_on', 'DESC');



	   $res = $ci->db->get("tbl_mst_designation")->result_array();



	   return $res;



}







function get_department(){



	   $ci = & get_instance();



	   $ci->db->where('status','1');



       $ci->db->order_by('created_on', 'DESC');



	   $res = $ci->db->get("tbl_mst_department")->result_array();



	   return $res;



}







function get_source($dep_id,$des_id){



	   $ci = & get_instance();



	   $ci->db->select('user_id,user_name,f_name,l_name');



	  //$ci->db->where('dept_id',$dep_id);



	   //$ci->db->where('designation_id',$des_id);



       $ci->db->order_by('created_on', 'DESC');



	   $res = $ci->db->get("backend_user")->result_array();



	   //echo $ci->db->last_query();exit();



	   return $res;



}



function get_news_user_byName($name){



	   $ci = & get_instance();



	   $user = explode(' ',$name);



$query=$ci->db->select('back_user.f_name,back_user.l_name,back_user.user_id,back_user.user_name,back_user.profile_photo,designation.desi_name,department.dept_name')



              ->from('backend_user AS back_user')



	          ->join('tbl_mst_department AS department', 'back_user.dept_id = department.dept_id')



	          ->join('tbl_mst_designation AS designation', 'back_user.designation_id = designation.desi_id')



	          ->where('back_user.f_name',$user[0])



			  ->where('back_user.l_name',$user[1])



			  ->get();



	   $res = $query->result_array();



	   //print_r($res);



			



	   //echo $ci->db->last_query();exit();



	   return $res;



}



function get_region($ides){



	



	$ci = & get_instance();



	$ids[]= explode(',',$ides);



	$query = $ci->db->from('tbl_area AS area')



                    ->join('tbl_city AS city', 'city.city_id = area.city_id')



					->join('state AS state1', 'state1.state_id = city.state_id')



					->where_in('area.area_id',$ids[0])



                    ->order_by('area.created_on', 'DESC')



                    ->get();



//echo $ci->db->last_query();exit();



$res = $query->result_array();



   return($res);



}



## Get Slider Stories function 



 function create_slider(){



	   $res 	= '';



	   $ci 		= & get_instance();



	   $ci->db->where('status','1');



	   $res 	= $ci->db->get("buzz_slider")->result_array();



	   return $res;



}







## Get Slider Stories from ID 



 function get_slider_stories($ids){



	  $res 		= '';



	  $ci 			= & get_instance();



	  $comma_id	= implode(',',$ids); 



 	  if(count($ids)>0){



			$ci->db->select('spidypickId, spideyImage, spidyName, headline,story_url, releaseDate');



			$ci->db->where_in('spidypickId',$ids);



			$ci->db->where(array('status'=>'1'));



			$ci -> db -> order_by("FIELD ( spidypickId, $comma_id )", '', FALSE);



			$res 		= $ci->db->get("spidypick")->result_array();// echo '***'.$ci->db->last_query();exit();



 	   }



 	  return $res;



}











function main_slider(){



	



	   $ci 			= & get_instance();



	  // $comma_id	= implode(',',$ids); 



	   $ci->db->select('spidypickId, spideyImage, spidyName, headline,story_url');



	   //$ci->db->where_in('spidypickId',$ids);



	   $ci->db->where(array('status'=>'1','spideyImage!='=>''));



	   $ci -> db -> order_by('spidypickId desc');



	   $ci->db->limit(30, 0);



	   $res 		= $ci->db->get("spidypick")->result_array();// echo '***'.$ci->db->last_query();exit();



	   return $res;



	



}











## Get city id by city name



function get_city_id($cityname)



 {



	 $res = 0;



	 if(!empty($cityname)){



 		$ci = & get_instance();



		$ci->db->select('city_id');



		$ci->db->from('tbl_city');



		$ci->db->where(array('city_url_name'=>trim($cityname)));



		$query = $ci->db->get();//echo $ci->db->last_query();exit;



		if ($query->num_rows() > 0) {



			$res = $query->result_array();



			$res = $res[0]['city_id'];



		}		



	 }



	 return $res;



}















function truncateString($str, $chars, $to_space, $replacement="..") {
   if($chars > strlen($str)) return $str;
   $str = substr($str, 0, $chars);
   $space_pos = strrpos($str, " ");
   if($to_space && $space_pos >= 0) {
       $str = substr($str, 0, strrpos($str, " "));
   }
   return($str . $replacement);
 }
 

 function get_share($id){
	$ci = & get_instance();
	$ci->db->select('*');
	$ci->db->from('inbreif');
	$ci->db->where('id',$id);
	$query= $ci->db->get();
	$res= $query->row_array();
	return($res);
 }



function random_num($size) {

	$alpha_key = '';

	$keys = range('A', 'Z');



	for ($i = 0; $i < 2; $i++) {

		$alpha_key .= $keys[array_rand($keys)];

	}



	$length = $size - 4;



	$key = '';

	$keys = range(0, 9);



	for ($i = 0; $i < $length; $i++) {

		$key .= $keys[array_rand($keys)];

	}

	$keys = range('a', 'z');

	for ($i = 0; $i < 2; $i++) {

		$alpha_key2 .= $keys[array_rand($keys)];

	}



	return $alpha_key . $key.$alpha_key2 ;

}


 
 

function create_sub_category_level($category_Id){//echo $category_Id;
 	$child_arr2=array();
 	 $chids2 = array();
 	//$data='';
 	if(empty($data)){
 		$data='';
 	}
	 
 	$data  .= '<div style="margin-top:10px;margin-left:20px;">';
  	$child_arr2 = getChildFromParent($category_Id);
 	 // echo '<pre>';print_r($child_arr2);
  	if($child_arr2>0){
 					foreach($child_arr2 as $chids2){
 						$data.= '<div class="tree_menu_child"><i class="fa fa-angle-double-right" aria-hidden="true"></i> '.$chids2['categoryName'].'&nbsp;&nbsp;&nbsp;
 						&nbsp;<div style="float:right;"><a title="Edit Child" href="'.base_url().'category/get_edit_section/'.$chids2['category_Id'].'"><i class="ace-icon fa fa-pencil"></i></a> </div>&nbsp;&nbsp;<div style="float:right;">&nbsp;&nbsp;<a title="Delete Child" onclick="return deleteAlert('.$chids2['category_Id'].','.$chids2['category_id'].');" href="javascript:void(0);"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>&nbsp;&nbsp; </div>'.'</div>';
 					 	// create_sub_category_level_nth($chids2['category_Id'],20);
						
 					}
 				}
 	echo $data .='</div>';			
 }
 
 
 
 function create_sub_category_level_nth($category_Id){ //echo $category_Id;exit;?>
 	<div style="margin-top:10px;margin-left:30px;">
				<?php ##============== get Child level1====================##
 				$child_arr = getChildFromParent($category_Id);
 				if($child_arr>0){

					foreach($child_arr as $chids){
						echo '<div class="tree_menu_child" style="margin-left:30px;"><i class="fa fa-angle-double-right" aria-hidden="true"></i> '.$chids['categoryName'].'&nbsp;&nbsp;&nbsp;
						&nbsp;<div style="float:right;"><a title="Edit Child" href="'.base_url().'category/get_edit_section/'.$chids['category_Id'].'"><i class="ace-icon fa fa-pencil"></i></a> </div>&nbsp;&nbsp;<div style="float:right;">&nbsp;&nbsp;<a title="Delete Child" onclick="return deleteAlert('.$chids['category_Id'].','.$chids['category_id'].');" href="javascript:void(0);"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>&nbsp;&nbsp; </div>'.'</div>';
					##----------------------Level 2--------------------------##?>
					<?php echo create_sub_category_level_nth($chids['category_Id']);?>
  				<?php ##----------------------Level 2--------------------------##
					}
				}
				##============== get Child level1 end====================##
				?>
              </div>
  <?php }
 

function create_sub_category_level_ATTR($product_id){//echo $category_Id;

	$child_arr2=array();

	 $chids2 = array();

	//$data='';

	if(empty($data)){

		$data='';

	}

	$data  .= '<div style="margin-top:10px;margin-left:20px;">';

 	$child_arr2 = getChildFromParent_ATTR($product_id);

	

	// echo '<pre>';print_r($child_arr2);

 	if($child_arr2>0){

					foreach($child_arr2 as $chids2){

						$data.= '<div class="tree_menu_child"><i class="fa fa-angle-double-right" aria-hidden="true"></i> '.$chids2['name'].'&nbsp;&nbsp;&nbsp;

						&nbsp;<div style="float:right;"><a title="Edit Child" href="'.base_url().'category/get_edit_section/'.$chids2['product_id'].'"><i class="ace-icon fa fa-pencil"></i></a> </div>&nbsp;&nbsp;<div style="float:right;">&nbsp;&nbsp;<a title="Delete Child" onclick="return deleteAlert('.$chids2['product_id'].','.$chids2['product_id'].');" href="javascript:void(0);"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>&nbsp;&nbsp; </div>'.'</div>';

					 

					 

					 //create_sub_category_level($chids2['category_Id']);

					}

				}

	echo $data .='</div>';			

}


 function getCategoryParentName($id=''){
 	$res 		= '';
 	$ci 		= & get_instance();
	$ci->db->select('categoryName');
	$ci->db->from('categories');
	$ci->db->where('category_Id',$id);
	$query = $ci->db->get();// echo $ci->db->last_query();exit;
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 		$res = $res[0]['categoryName'];
	}		
 	return $res;
	}


 function getCategoryParentName_ATTR($id=''){
  	$res 		= '';
  	$ci 		= & get_instance();
 	$ci->db->select('name');
 	$ci->db->from('attribute_name');
 	$ci->db->where('product_id',$id);
 	$query = $ci->db->get();// echo $ci->db->last_query();exit;
 	if ($query->num_rows() > 0) {
  		$res = $query->result_array();
  		$res = $res[0]['name'];
 	}		
  	return $res;
 }


function getAllCategory($parent=''){
 	$res 		= '';
 	$ci 		= & get_instance();
	$ci->db->select('category_Id, categoryName');
	$ci->db->from('categories');
	if($parent!=''){
		$ci->db->where('parent',$parent);
	}
	//$ci->db->where('category_Id',$id);
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 	//	$res = $res[0]['categoryName'];
	}		
 	return $res;
}

function getAllParentIndustries($parent=''){
 	$res 		= '';
 	$ci 		= & get_instance();
	$ci->db->select('category_Id, categoryName');
	$ci->db->from('categories');
	$ci->db->where('parent', 0);
	//$ci->db->where('category_Id',$id);
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 		//$res = $res[0]['categoryName'];
	}		
 	return $res;
}




function getAllRoles(){
	
 	$res 		= '';

 	$ci 		= & get_instance();

	$ci->db->select('id, role_name_slug, role_name_value');

	$ci->db->from('role_master');
	
		$ci->db->where(array('status'=>'1','id!='=>'2'));
		//$ci->db->where('status',1);
	
	
	//$ci->db->where(array('status'=>'1','spideyImage!='=>''));	
	$query = $ci->db->get();  echo $ci->db->last_query(); 

	if ($query->num_rows() > 0) {

 		$res = $query->result_array();

 	//	$res = $res[0]['categoryName'];

	}		
 	return $res;
}


function getConsumerCitiesofLastScan(){	
 	$res 		= '';
 	$ci 		= & get_instance();
	//$ci->db->distinct('city');
	$ci->db->select('*');
	$ci->db->from('scanned_products');	
	$ci->db->group_by('scan_city');
	$ci->db->order_by("scan_id", " desc");
		//$ci->db->where(array('status'=>'1','id!='=>'2'));
		//$ci->db->where('status',1);
	   //$ci->db->where(array('status'=>'1','spideyImage!='=>''));	
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 	//	$res = $res[0]['categoryName'];
	}		
 	return $res;
}
//Sanjay2
function getConsumerData($city){	
 	$res 		= '';
 	$ci 		= & get_instance();
	//$ci->db->distinct('city');
	$ci->db->select('*');
	$ci->db->from('consumers');	
	$ci->db->group_by($city);
	$ci->db->order_by("id", " desc");
		//$ci->db->where(array('status'=>'1','id!='=>'2'));
		//$ci->db->where('status',1);
	   //$ci->db->where(array('status'=>'1','spideyImage!='=>''));	
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 	//	$res = $res[0]['categoryName'];
	}		
 	return $res;
}

function getConsumerSelectionCriterias($customer_id){	
 	$res 		= '';
 	$ci 		= & get_instance();
	//$ci->db->distinct('city');
	$ci->db->select('*');
	$ci->db->from('consumer_selection_criteria');	
	$ci->db->where('customer_id', $customer_id);
	//$ci->db->group_by($city);
	$ci->db->order_by("criteria_id", " desc");
		//$ci->db->where(array('status'=>'1','id!='=>'2'));
	
	   //$ci->db->where(array('status'=>'1','spideyImage!='=>''));	
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 	//	$res = $res[0]['categoryName'];
	}		
 	return $res;
}


function getAllLocationTypes(){
	
 	$res 		= '';

 	$ci 		= & get_instance();

	$ci->db->select('id, location_type_name');

	$ci->db->from('location_type_master');
	
		//$ci->db->where(array('status'=>'1','id!='=>'2'));
		$ci->db->where('status',1);
	//$ci->db->where(array('status'=>'1','spideyImage!='=>''));	
	$query = $ci->db->get();  echo $ci->db->last_query(); 

	if ($query->num_rows() > 0) {

 		$res = $query->result_array();

 	//	$res = $res[0]['categoryName'];

	}		
 	return $res;
}


function getRoleNameById($id){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('role_name_value');
	$ci->db->from('role_master');
	$ci->db->where(array('status'=>'1', 'id'=>$id));
 	$query = $ci->db->get();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = ucfirst($res[0]['role_name_value']);
 	}
	return $res;
}

function getConsumerFieldName($FieldName){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('cpatm_name');
	$ci->db->from('consumer_profile_attribute_type_master');
	//$ci->db->where(array('status'=>'1', 'id'=>$FieldName));
	$ci->db->where('cpatm_name_slug',$FieldName);
 	$query = $ci->db->get();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = ucfirst($res[0]['cpatm_name']);
 	}
	return $res;
}


function getRoleSlugById($id){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('role_name_slug');
	$ci->db->from('role_master');
	$ci->db->where(array('status'=>'1', 'id'=>$id));
 	$query = $ci->db->get();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = ucfirst($res[0]['role_name_slug']);
 	}
	return $res;
}



function getAttributeTypeNameBySlug($Slug){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('cpatm_name');
	$ci->db->from('consumer_profile_attribute_type_master');
	//$ci->db->where(array('status'=>'1', 'id'=>$Slug));
	$ci->db->where('cpatm_name_slug',$Slug);
 	$query = $ci->db->get();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = ucfirst($res[0]['cpatm_name']);
 	}
	return $res;
}


function getAttributeSlugByName($Name){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('cpm_type_slug,cpm_name');
	$ci->db->from('consumer_profile_master');
	//$ci->db->where(array('status'=>'1', 'id'=>$Slug));
	$ci->db->where('cpm_name',"Laptop");
 	$query = $ci->db->get();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = ucfirst($res[0]['cpm_type_slug']);
 	}
	return $res;
}


function getAllCategory_ATTR($parent=''){
 	$res 		= '';
 	$ci 		= & get_instance();
	$ci->db->select('product_id, name');
	$ci->db->from('attribute_name');
	if($parent!=''){
		$ci->db->where('parent',$parent);
	}
	//$ci->db->where('category_Id',$id);
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 	//	$res = $res[0]['categoryName'];
	}		
 	return $res;
}


function getAllParentAttribute($parent=''){
 	$res 		= '';
 	$ci 		= & get_instance();
	$ci->db->select('product_id, name');
	$ci->db->from('attribute_name');
	//if($parent!=''){
		$ci->db->where('parent', 0);
	//}
	//$ci->db->where('category_Id',$id);
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 	//	$res = $res[0]['categoryName'];
	}		
 	return $res;
}

 
function getProduct_name($id){
  	$res 		= '';
  	$ci 		= & get_instance();
 	$ci->db->select('name');
 	$ci->db->from('attribute_name');
 	$ci->db->where('product_id',$id);
 	$query = $ci->db->get();// echo $ci->db->last_query();exit;
 	if ($query->num_rows() > 0) {
  		$res = $query->result_array();
  	 $res = $res[0]['name'];
 	}		
  	return $res;
 }
 
 function getAllProductName($parent=''){
  	$res 		= '';
  	$ci 		= & get_instance();
 	$ci->db->select('product_id,name');
 	$ci->db->from('attribute_name');
	$parent  = (empty($parent))?0:explode(',',$parent);
	$ci->db->where_in('parent',$parent);
	$ci->db->order_by("parent", "ASC");
 	$query = $ci->db->get(); // echo $ci->db->last_query();exit;
 	if ($query->num_rows() > 0) {
  		$res = $query->result_array();
  	}		
  	return json_encode($res);
 }

 function getAllAttributeNamesAssignedIndustryWise($parent=''){
  	$res 		= '';
  	$ci 		= & get_instance();
 	$ci->db->select('product_id,name');
 	$ci->db->from('attribute_name');
	//$parent  = (empty($parent))?0:explode(',',$parent);
	//$ci->db->where_in(json_decode('industry_id'),$parent);
	$ci->db->like('industry_id', $parent);
	//$ci->db->order_by("industry_id", "ASC");
 	$query = $ci->db->get(); // echo $ci->db->last_query();exit;
 	if ($query->num_rows() > 0) {
  		$res = $query->result_array();
  	}		
  	return json_encode($res);
 }
 
function generate_password( $length = 6 ) {
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$password = substr( str_shuffle( $chars ), 0, $length );
return $password;
}


function show_all_industry_by_ids($id){
	$id_arr = explode(',',$id);
	$id_arr_filter = array_filter($id_arr);
	$res = get_industry_by_id($id_arr_filter);
	$result = '';
	foreach($res as $val){
		$result .=$val['categoryName'];
	}
	return $result;
}

function get_industry_by_id($id){
	$res 		= '';
  	$ci 		= & get_instance();
 	$ci->db->select('categoryName');
 	$ci->db->from('categories');
 	//$ci->db->where('category_Id',$id);
	$ci->db->where_in('category_Id',explode(',',$id));
 	$query = $ci->db->get();// echo $ci->db->last_query();exit;
 	if ($query->num_rows() > 0) {
  		$res = $query->result_array();
  	 //$res = $res[0]['categoryName'];
  	}		
  	return $res;
}

function getAllattributes($parent=''){

 	$res 		= '';

 	$ci 		= & get_instance();

	$ci->db->select('product_id, name');

	$ci->db->from('attribute_name');
	if($parent!=''){
	 $ci->db->where('parent',$parent);
	}
	$query = $ci->db->get();// echo $ci->db->last_query();exit;

	if ($query->num_rows() > 0) {

 		$res = $query->result_array();

 	//	$res = $res[0]['categoryName'];



	}		

 	return $res;
 }


function getAttrDepth($id='',$cnt1){
 	$ci = & get_instance();
  	$sql= "select parent from attribute_name where product_id='".$id."'";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
 	$result =$res[0]['parent'];
 	if(!empty($result)){
 		$cnt1=intval($cnt1)+1;
 		return getAttrDepth($result,$cnt1);
 	}
 	 return $cnt1;
 	// echo '<pre>';print_r( $cnt1);exit;
 }
 
 function getAttrIDFromParentID($id=''){
 $result='';
 	$ci = & get_instance();
  	$sql= "select parent from attribute_name where product_id='".$id."'";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
 	$result =$res[0]['parent'];
 	if(!empty($result)){
 		return $result ; 
 		 
 	}
 	 
 	// echo '<pre>';print_r( $cnt1);exit;
 }
 
 function getAttrIDByDepth($id='',$level){
 	$ci = & get_instance();
  	$sql= "select parent,lavel from attribute_name where product_id='".$id."'";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
 	$result =$res[0]['parent'];
 	if(!empty($result)){
 		//$cnt1=intval($level)+1;
		if($res[0]['level']!=$level){
 			return getAttrDepth($result,$level);
		}
 	}
 	 return $result;
 	// echo '<pre>';print_r( $cnt1);exit;
 }
 
 function getLevelByID($id=''){
 	$ci = & get_instance();
  	$sql= "select parent,lavel from attribute_name where product_id='".$id."'";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
 	$result =$res[0];
 	if(!empty($result)){
   	}
 	 return json_encode($result);
 	// echo '<pre>';print_r( $cnt1);exit;
 }

function checkLavels($id){	
	$ci = & get_instance();
 	if(!empty($id)){
		$res = array();
		$sql= "select product_id, parent,lavel from attribute_name where product_id='".$id."'";
		$q 		= $ci->db->query($sql);
 		$res 	= $q->result_array();
		$result =$res[0];
		//$product_id 		= $result['product_id'];
 		$lavel = $result['lavel'];
		$pid = $result['parent'];
		$product_id = $result['product_id'];
		if($lavel==1){
			return $product_id;
		}return checkLavels($pid);
 		//print_r($array_res);exit;
   	}
 }
 
 function getLastChildLevelIdFromParent($pid){
 	$ci = & get_instance();
 	if(!empty($pid)){
		$res = array();
		$sql= "select product_id,lavel from attribute_name where parent='".$pid."'";
		$q 		= $ci->db->query($sql);
 		$res 	= $q->result_array();
		$result =$res[0];
		if(count($res)==0){
			return $pid;
		}else{
			$product_id = $result['product_id'];
			return getLastChildLevelIdFromParent($product_id);
		}
    }
 }
 
 function getAllOptionsList($id=''){//print_r($id);exit;
 	$allId = implode(',',json_decode($id,true));
 	$ci = & get_instance();
  	$sql= "select * from attribute_options where product_id IN (".$allId.")";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
  	return json_encode($res);
 	// echo '<pre>';print_r( $cnt1);exit;
 }
 
  function getAttrNameFromID($id=''){
  	$ci = & get_instance();
  	$sql= "select name from attribute_name where product_id ='".$id."'";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
  	return $res[0]['name'];
 }
 
 function getParent_fromChilds($id=''){
	$res 		= '';
	if(!empty($id)){
		$allId = explode(',',$id);
		//print_r($allId);
		$ci 		= & get_instance();
		$ci->db->select('parent');
		$ci->db->from('attribute_name');
		$ci->db->where_in('product_id',$allId);
		$query = $ci->db->get(); //echo $ci->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			foreach($res as $record){
				$val[] = $record['parent'];
			}
 		}
	}
  	return array_unique(array_filter($val));
 }

function getParentUsers($id='',$status=''){
  	$ci = & get_instance();
	if(!isset($status) || empty($status)){
		$sql= "select user_id, user_name from backend_user where is_parent ='1'";
	}else{
		$sql= "select user_id, user_name from backend_user where is_parent ='1' and status='1' and is_verified='1'"; 
	}
  	
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
  	return $res;
 }
 
 function findParentIdFromChild($id=''){
 	$ci = & get_instance();
  	$sql= "select parent from attribute_name where product_id='".$id."'";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
 	$result =$res[0]['parent'];
 	if(!empty($result)){
   	}
 	 return ($result);
 	// echo '<pre>';print_r( $cnt1);exit;
 }
 
 function get_all_plants($user_id){
	$res='0';
	$ci = & get_instance();
	$admin_id 				= $ci->session->userdata('admin_user_id');	
	if(!empty($user_id)){
 		$ci->db->select('plant_id,plant_name,plant_code,email_id,phone,created_date,status');
		$ci->db->from('plant_master');
		if($admin_id>1){
			$ci->db->where('created_by',$user_id);
		}
		$query= $ci->db->get();
		$res = $query->result_array();
	}
	return($res);
 }
 
  function getquestionFeedbackDetails($product_id, $user_id, $promotion_id, $product_qr_code){
	$res='0';
	$ci = & get_instance();
	//$admin_id 				= $ci->session->userdata('admin_user_id');	
	if(!empty($user_id)){
 		$ci->db->select('selected_answer, updated_date, question_id');
		$ci->db->from('consumer_feedback');
		$ci->db->where(array('product_id'=>$product_id, 'user_id'=>$user_id, 'promotion_id'=>$promotion_id, 'product_qr_code'=>$product_qr_code));
		
		$query= $ci->db->get();
		$res = $query->result_array();
	}
	return($res);
 }
 
   function getquestionFeedbackDetailsBygetquestionID($product_id, $user_id, $promotion_id, $product_qr_code){
	$res='0';
	$ci = & get_instance();
	//$admin_id 				= $ci->session->userdata('admin_user_id');	
	if(!empty($user_id)){
 		$ci->db->select('selected_answer, updated_date, question_id');
		$ci->db->from('consumer_feedback');
		$ci->db->where(array('product_id'=>$product_id, 'user_id'=>$user_id, 'promotion_id'=>$promotion_id, 'product_qr_code'=>$product_qr_code));
		
		$query= $ci->db->get();
		$res = $query->result_array();
	}
	return($res);
 }
 

 
  function get_all_locations_plant($user_id){
	$res='0';
	$ci = & get_instance();
	$admin_id 				= $ci->session->userdata('admin_user_id');	
	if(!empty($user_id)){
 		$ci->db->select('location_id,location_name,location_code,email_id,phone,created_by,created_date,status');
		$ci->db->from('location_master');
		if($admin_id>1){
			$ci->db->where(array('created_by'=>$user_id, 'location_type'=>'Plant'));
		}
		$query= $ci->db->get();
		$res = $query->result_array();
	}
	return($res);
 }
 
   function get_all_active_locations_plant($user_id){
	$res='0';
	$ci = & get_instance();
	$admin_id 				= $ci->session->userdata('admin_user_id');	
	if(!empty($user_id)){
 		$ci->db->select('location_id,location_name,location_type,location_code,email_id,phone,created_by,created_date,status');
		$ci->db->from('location_master');
		$ci->db->where(array('status'=>'1', 'location_type'=>'Plant'));
		if($admin_id>1){
			$ci->db->where(array('created_by'=>$user_id));
		}
		$query= $ci->db->get();
		$res = $query->result_array();
	}
	return($res);
 }
 // Sanjay
  function get_assigned_locations_product($product_id){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('location_id');
	$ci->db->from('assign_locations');
	$ci->db->where(array('product_id'=>$product_id));
 	$query = $ci->db->get();
	//echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = ucfirst($res[0]['location_id']);
 	}
	return $res;
}

 
 function get_all_active_plants($user_id){
	$res='0';
	$ci = & get_instance();
	$admin_id 				= $ci->session->userdata('admin_user_id');	
	if(!empty($user_id)){
 		$ci->db->select('plant_id,plant_name,plant_code,email_id,phone,created_date,status');
		$ci->db->from('plant_master');
		$ci->db->where(array('status'=>'1'));
		if($admin_id>1){
			$ci->db->where('created_by',$user_id);
		}
		$query= $ci->db->get();
		$res = $query->result_array();
	}
	return($res);
 }
 
  function get_all_active_locations($user_id){
	$res='0';
	$ci = & get_instance();
	$admin_id 				= $ci->session->userdata('admin_user_id');	
	if(!empty($user_id)){
 		$ci->db->select('location_id,location_name,location_type,location_code,email_id,phone,created_date,status');
		$ci->db->from('location_master');
		$ci->db->where(array('status'=>'1'));
		//if($admin_id>1){
			$ci->db->where('created_by',$user_id);
		//}
		$query= $ci->db->get();
		$res = $query->result_array();
	}
	return($res);
 }
 
 //Sanjay
 function get_all_active_functionalities($user_id){
	$res='0';
	$ci = & get_instance();
	$admin_id 				= $ci->session->userdata('admin_user_id');	
	if(!empty($user_id)){
 		$ci->db->select('id,functionality_name_slug,functionality_name_value,status');
		$ci->db->from('functionality_master');
		$ci->db->where(array('status'=>'1'));
		
		$query= $ci->db->get();
		$res = $query->result_array();
	}
	return($res);
 }
 
 function get_active_roles()
  {
 		$res = 0;
 		$ci = & get_instance();
 		$ci->db->select('*');
   		$ci->db->from('role_master');
 		$ci->db->where(array('status'=>'1', 'id!='=>'2'));
   		$query = $ci->db->get();//echo $ci->db->last_query();
  		if ($query->num_rows() > 0) {
  			$res = $query->result_array();
  		}
 		return $res; 
 } 
 
 
 function get_all_products_sku($user_id){
	$res='0';
	if(!empty($user_id)){
 		$ci = & get_instance();
 			$ci->db->select('id, product_name');
			$ci->db->from('products');
			if($user_id > 1){
			$ci->db->where(array('created_by'=>$user_id, 'other_industry NOT LIKE'=>'other%'));
			}
			$query= $ci->db->get();
			$res = $query->result_array();
	}
	return($res);
 }
 
 
 ## get all product For plant controller
 function get_all_products_sku_plant_ctrl($user_id){
	 $ci  = & get_instance();
	 $sql = "select group_concat(AP.product_id) as product_id
	 		 from assign_plants AP 
			 left join assign_plants_to_users PU 
			 on AP.plant_id= PU.plant_id 
			 where PU.user_id = '".$user_id."'";
	$qry 		 = $ci->db->query( $sql );
	$result 	 = $qry->result_array() ;//echo '--->'.$ci->db->last_query();exit;
	$product_ids = $result[0]['product_id'];
	 
	$res='0';
	if(!empty($product_ids)){
 		
 			$ci->db->select('id, product_name');
			$ci->db->from('products');
			$ci->db->where(array('other_industry NOT LIKE'=>'other%'));
			$ci->db->where_in('id',array_unique(explode(',',$product_ids)));
			$query= $ci->db->get();//echo '--->'.$ci->db->last_query();exit;
			$res = $query->result_array();
	}
	return($res);
 }##
 
 
  ## get all product For location controller
 function get_all_products_sku_location_ctrl($user_id){
	 $ci  = & get_instance();
	 $sql = "select group_concat(AP.product_id) as product_id
	 		 from assign_locations AP 
			 left join assign_locations_to_users PU 
			 on AP.location_id= PU.location_id 
			 where PU.user_id = '".$user_id."'";
	$qry 		 = $ci->db->query( $sql );
	$result 	 = $qry->result_array() ;//echo '--->'.$ci->db->last_query();exit;
	$product_ids = $result[0]['product_id'];
	 
	$res='0';
	if(!empty($product_ids)){
 		
 			$ci->db->select('id, product_name');
			$ci->db->from('products');
			$ci->db->where(array('other_industry NOT LIKE'=>'other%'));
			$ci->db->where_in('id',array_unique(explode(',',$product_ids)));
			$query= $ci->db->get();//echo '--->'.$ci->db->last_query();exit;
			$res = $query->result_array();
	}
	return($res);
 }##
 
function get_assigned_products_list($plant_id){
	$res='0';
	$ci = & get_instance();
	 $user_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($plant_id)){
			$ci->db->select('group_concat(product_id) as product_id');
			$ci->db->from('assign_plants');
			$ci->db->where('plant_id',$plant_id, 'assigned_by',$user_id);
			$query= $ci->db->get();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['product_id'];
 }
 
 // Get Assigned product List to the Location
 function get_assigned_products_list_to_location($location_id){
	$res='0';
	$ci = & get_instance();
	 $user_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($location_id)){
			$ci->db->select('group_concat(product_id) as product_id');
			$ci->db->from('assign_locations');
			$ci->db->where('location_id',$location_id, 'assigned_by',$user_id);
			$query= $ci->db->get();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['product_id'];
 }
 
 function get_assigned_products_to_plant($plant_id){
	$res='0';
	$ci = & get_instance();
	 $user_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($plant_id)){
			$ci->db->select('group_concat(product_id) as product_id');
			$ci->db->from('assign_plants');
			$ci->db->where('plant_id',$plant_id, 'assigned_by',$user_id);
			$query= $ci->db->get();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['product_id'];
 }
 
 // Get Assigned product List to the Location
  function get_assigned_products_to_location($location_id){
	$res='0';
	$ci = & get_instance();
	 $user_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($location_id)){
			$ci->db->select('group_concat(product_id) as product_id');
			$ci->db->from('assign_locations');
			$ci->db->where('location_id',$plant_id, 'assigned_by',$user_id);
			$query= $ci->db->get();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['product_id'];
 }
 
 
function get_assigned_plant_user_list($user_id){
	$res='0';
	$ci = & get_instance();
	 $admin_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($user_id)){ 
			$ci->db->select('group_concat(plant_id) as plant_id');
			$ci->db->from('assign_plants_to_users');
			$ci->db->where(array('user_id'=>$user_id, 'assigned_by'=>$admin_id));
			$query= $ci->db->get();//echo '***'. $ci->db->last_query();exit;
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['plant_id'];
 } 
 
 
 
 function get_assigned_location_user_list($user_id){
	$res='0';
	$ci = & get_instance();
	 $admin_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($user_id)){ 
			$ci->db->select('group_concat(location_id) as location_id');
			$ci->db->from('assign_locations_to_users');
			$ci->db->where(array('user_id'=>$user_id, 'assigned_by'=>$admin_id));
			$query= $ci->db->get();//echo '***'. $ci->db->last_query();exit;
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['location_id'];
 } 
 
 function get_assigned_functionalities_to_role_list($roleId){
	$res='0';
	$ci = & get_instance();
	 $admin_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($roleId)){ 
			$ci->db->select('group_concat(functionality_id) as functionality_id');
			$ci->db->from('assign_functionalities_to_role');
			//$ci->db->where(array('role_id'=>$user_id, 'assigned_by'=>$admin_id));
			$ci->db->where(array('role_id'=>$roleId));
			$query= $ci->db->get();//echo '***'. $ci->db->last_query();exit;
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['functionality_id'];
 }
 
  function get_required_users_for_the_role($roleId){
	$res='0';
	$ci = & get_instance();
	 $admin_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($roleId)){ 
			$ci->db->select('concat(role_quantity) as role_quantity');
			$ci->db->from('assign_functionalities_to_role');
			//$ci->db->where(array('role_id'=>$user_id, 'assigned_by'=>$admin_id));
			$ci->db->where(array('role_id'=>$roleId, 'assigned_by'=>$admin_id));
			$query= $ci->db->get();//echo '***'. $ci->db->last_query();exit;
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['role_quantity'];
 }
 
 function get_created_users_for_the_role($roleId){
	$res='0';
	$ci = & get_instance();
	 $admin_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($roleId)){ 
			$ci->db->select('*');
			$ci->db->from('backend_user');
			//$ci->db->where(array('role_id'=>$user_id, 'assigned_by'=>$admin_id));
			$ci->db->where(array('designation_id'=>$roleId, 'is_parent'=>$admin_id));
			$query= $ci->db->get();//echo '***'. $ci->db->last_query();exit;
			$res_arr = $query->num_rows();
 		}
 	return $res_arr;
 }
 
 

 function get_assigned_plant_user_list2($user_id){
	$res='0';
	$ci = & get_instance();
	 //$admin_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($user_id)){ 
			$ci->db->select('group_concat(plant_id) as plant_id');
			$ci->db->from('assign_plants_to_users');
			$ci->db->where(array('user_id'=>$user_id));
			$query= $ci->db->get();//echo '***'. $ci->db->last_query();exit;
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['plant_id'];
 }
 
 function get_plants_name_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(plant_name) as name');
			$ci->db->from('plant_master');
			$ci->db->where_in('plant_id',explode(',',$id));
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['name'];
 }
 
  function get_question_desc_by_id($question_id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($question_id)){
			$ci->db->select('group_concat(question) as question');
			$ci->db->from('feedback_question_bank');
			$ci->db->where_in('question_id',explode(',',$question_id));
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['question'];
 }
 
   function get_question_desc_by_id_options($question_id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($question_id)){
			$ci->db->select('*');
			$ci->db->from('feedback_question_bank');
			$ci->db->where_in('question_id',explode(',',$question_id));
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			//$res_arr = $query->result_array();
 		}
 	return $query;
 }
 
 
  function get_locations_name_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(location_name) as name');
			$ci->db->from('location_master');
			$ci->db->where_in('location_id',explode(',',$id));
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['name'];
 }
 
 function get_locations_type_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(location_type) as type');
			$ci->db->from('location_master');
			$ci->db->where_in('location_id',explode(',',$id));
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['type'];
 }
 

  function get_functionality_name_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(functionality_name_value) as name');
			$ci->db->from('functionality_master');
			$ci->db->where_in('id',explode(',',$id));
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['name'];
 }
 
   function get_role_name_by_designation_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(role_name_value) as name');
			$ci->db->from('role_master');
			$ci->db->where_in('id',explode(',',$id));
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['name'];
 }
 
   function get_product_id_by_product_code($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(product_id) as product_id');
			$ci->db->from('printed_barcode_qrcode');
			$ci->db->where_in('barcode_qr_code_no',$id);
			//$ci->db->or_where('barcode_qr_code_no2',$id);
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['product_id'];
 }
 
 function get_functionality_slug_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(functionality_name_slug) as slug');
			$ci->db->from('functionality_master');
			$ci->db->where_in('id',explode(',',$id));
			$query= $ci->db->get();//echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['slug'];
 }
 
 function checkProductsId_having_other_industry($product_id){
	 $ci = & get_instance();
	 	$res = array();
		 if(!empty($product_id)){
 		 $sql = "SELECT id
				FROM `products`
				WHERE id
				IN ( ".$product_id." )
				AND other_industry like 'textbox%'";
				$qry = $ci->db->query($sql);
			//echo $ci->db->last_query();
			if ($qry->num_rows() > 0) {
				$res = $qry->result_array();
			}
		 }
 		return $res; 
 }
 
 
function get_products_name_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$id2 = checkProductsId_having_other_industry($id);
			$ids = explode(',',$id);
			$get_ids = array_diff($ids, $id2);
			$ci->db->select('group_concat(product_name) as name');
			$ci->db->from('products');
 			$ci->db->where_in('id',$get_ids);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['name'];
 }
 
 function get_industry_name_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			//$id2 = checkProductsId_having_other_industry($id);
			//$ids = explode(',',$id);
			//$get_ids = array_diff($ids, $id2);
			$ci->db->select('group_concat(categoryName) as name');
			$ci->db->from('categories');
 			$ci->db->where_in('category_Id',$id);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['name'];
 }
 
 
 function get_question_by_question_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(question) as question');
			$ci->db->from('feedback_question_bank');
 			$ci->db->where_in('question_id',$id);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['question'];
 }
 
 
 function get_products_brand_name_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$id2 = checkProductsId_having_other_industry($id);
			$ids = explode(',',$id);
			$get_ids = array_diff($ids, $id2);
			$ci->db->select('group_concat(brand_name) as brand_name');
			$ci->db->from('products');
 			$ci->db->where_in('id',$get_ids);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['brand_name'];
 }
 
  function get_customer_id_by_product_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(created_by) as created_by');
			$ci->db->from('products');
 			$ci->db->where_in('id',$id);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['created_by'];
 }
 
   function get_customer_loyalty_type_by_customer_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$ci->db->select('group_concat(customer_loyalty_type) as customer_loyalty_type');
			$ci->db->from('backend_user');
 			$ci->db->where_in('user_id',$id);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['customer_loyalty_type'];
 }
 
 
  function loyalty_points_expiry_days($customer_id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($customer_id)){
			$ci->db->select('group_concat(days_for_expiry_of_point_credited) as days_for_expiry_of_point_credited');
			$ci->db->from('backend_user');
 			$ci->db->where_in('user_id',$customer_id);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['days_for_expiry_of_point_credited'];
 }
 
 function get_products_attribute_list_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$id2 = checkProductsId_having_other_industry($id);
			$ids = explode(',',$id);
			$get_ids = array_diff($ids, $id2);
			$ci->db->select('group_concat(attribute_list) as attributes');
			$ci->db->from('products');
 			$ci->db->where_in('id',$get_ids);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['attributes'];
 }
 
 
 
 function get_product_sku_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 		if(!empty($id)){
			$id2 = checkProductsId_having_other_industry($id);
			$ids = explode(',',$id);
			$get_ids = array_diff($ids, $id2);
			$ci->db->select('group_concat(product_sku) as sku');
			$ci->db->from('products');
 			$ci->db->where_in('id',$get_ids);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['sku'];
 }
 
  function get_product_product_description_by_id($id){ 
	$res='0';
	$ci = & get_instance();
	 
 			$ci->db->select('group_concat(product_description) as product_description');
			$ci->db->from('products');
 			$ci->db->where_in('id',$id);
			$query= $ci->db->get(); //echo '***'.$ci->db->last_query();
			$res_arr = $query->result_array();
 		
 	return $res_arr[0]['product_description'];
 }

 
 

function get_assigned_plants_list($id){
	$res='0';
	$ci = & get_instance();
	 $user_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($id)){
			$ci->db->select('group_concat(plant_id) as plantId');
			$ci->db->from('assign_plants_to_users');
			$ci->db->where(array('user_id'=>$id, 'assigned_by'=>$user_id));
			$query= $ci->db->get();//echo $ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['plantId'];
 }
 
 function get_assigned_active_plants_list($id){
	$res='0';
	$ci = & get_instance();
	 $user_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($id)){
			$ci->db->select('group_concat(plant_id) as plantId');
			$ci->db->from('assign_plants_to_users');
			$ci->db->where(array('user_id'=>$id, 'assigned_by'=>$user_id,'status'=>'1'));
			$query= $ci->db->get();//echo $ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['plantId'];
 }
 
  function get_assigned_active_locations_list($id){
	$res='0';
	$ci = & get_instance();
	 $user_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($id)){
			$ci->db->select('group_concat(location_id) as plantId');
			$ci->db->from('assign_locations_to_users');
			$ci->db->where(array('user_id'=>$id, 'assigned_by'=>$user_id,'status'=>'1'));
			$query= $ci->db->get();//echo $ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['plantId'];
 }
 
 function get_assigned_active_functionalities_list($id){
	$res='0';
	$ci = & get_instance();
	 $user_id 				= $ci->session->userdata('admin_user_id');	
 		if(!empty($id)){
			$ci->db->select('group_concat(functionality_id) as functionalityId');
			$ci->db->from('assign_functionalities_to_role');
			$ci->db->where(array('role_id'=>$id, 'assigned_by'=>$user_id,'status'=>'1'));
			$query= $ci->db->get();//echo $ci->db->last_query();
			$res_arr = $query->result_array();
 		}
 	return $res_arr[0]['functionalityId'];
 }
 
 
 function get_all_users($id)
  {
 		$res = 0;
 		$ci = & get_instance();
 		$ci->db->select('*');
   		$ci->db->from('backend_user');
 		$ci->db->where(array('is_parent'=>$id));
   		$query = $ci->db->get();//echo $ci->db->last_query();
  		if ($query->num_rows() > 0) {
  			$res = $query->result_array();
  		}
 		return $res; 
 }
 

 
  
 function get_active_users($id)
  {
 		$res = 0;
 		$ci = & get_instance();
 		$ci->db->select('*');
   		$ci->db->from('backend_user');
 		$ci->db->where(array('is_parent'=>$id,'status'=>'1'));
   		$query = $ci->db->get();//echo $ci->db->last_query();
  		if ($query->num_rows() > 0) {
  			$res = $query->result_array();
  		}
 		return $res; 
 } 
 
  function get_all_users_exclude_pc($id)
  {
 		$res = 0;
 		$ci = & get_instance();
 		$ci->db->select('*');
   		$ci->db->from('backend_user');
 		$ci->db->where(array('is_parent'=>$id,'status'=>'1','designation_id!='=>'2'));
   		$query = $ci->db->get();//echo $ci->db->last_query();
  		if ($query->num_rows() > 0) {
  			$res = $query->result_array();
  		}
 		return $res; 
 } 
 
  
function get_parent_user($id,$statusVal='')
  {
 		$res = 0;
 		$ci = & get_instance();
 		$ci->db->select('*');
   		$ci->db->from('backend_user');
 		$ci->db->where(array('user_id'=>$id));
		if($statusVal==1){
			$ci->db->where('status','1');
		}
   		$query = $ci->db->get();  //echo $ci->db->last_query();exit;
  		if ($query->num_rows() > 0) {
  			$res = $query->result_array();
  		}
 		return $res; 
 }
 
 
 function list_assigned_plants_of_plant_ctrl($userid){
		$res 	= 0;
 		$ci 	= & get_instance();
 		$ci->db->select('GROUP_CONCAT(plant_id)');
   		$ci->db->from('assign_plants_to_users');
 		$ci->db->where(array('user_id'=>$userid));
   		$query 	= $ci->db->get();//echo $ci->db->last_query();
  		if ($query->num_rows() > 0) {
  			$res= $query->result_array();
  		}
 		return $res; 
 }
 
 
 function get_products_sku_by_product_id($product_id){
	$res='0';
	if(!empty($product_id)){
 		$ci = & get_instance();
 			$ci->db->select('product_sku, product_name,code_activation_type');
			$ci->db->from('products');
			$ci->db->where('id',$product_id);
			$query= $ci->db->get();
			$res = $query->result_array();
	}
	return($res);
 }
 
 
 function order_status($status=''){ 
 	switch ($status){
		case '0' :
		 $res ='Pending';
		 break;
		 case '1' :
		 $res ='Approved';
		 break;
		 case '2' :
		 $res ='Rejected';
		 break;
		 
	}return $res;
 }
 
  function promotion_status($status=''){ 
 	switch ($status){
		case '0' :
		 $res ='Pending';
		 break;
		 case '1' :
		 $res ='Live';
		 break;
		 case '2' :
		 $res ='Closed';
		 break;
		 
	}return $res;
 }
 
 /*function get_products_sku_by_product_id($product_id){
	$res='0';
	if(!empty($product_id)){
 		$ci = & get_instance();
 			$ci->db->select('product_sku, product_name');
			$ci->db->from('products');
			$ci->db->where('id',$product_id);
			$query= $ci->db->get();
			$res = $query->result_array();
	}
	return($res);
 }
 */
 function assigned_plants($user_id=''){
	 $res = 0;
	 if(!empty($user_id)){
		$ci = & get_instance();
 		$query = $ci ->db
					 ->select('GROUP_CONCAT( pm.plant_name ) plant_names')
					 ->from('plant_master AS pm')->join('assign_plants_to_users pl', 'pl.plant_id = pm.plant_id', 'left')
					 ->where('pl.user_id',$user_id)
 					 ->get();//echo $ci->db->last_query();
		$res = $query->result_array();
			   
 	 }
	 return $res[0]['plant_names'];
 }
 
  function assigned_locations($user_id=''){
	 $res = 0;
	 if(!empty($user_id)){
		$ci = & get_instance();
 		$query = $ci ->db
					 ->select('GROUP_CONCAT( pm.location_name ) location_names')
					 ->from('location_master AS pm')->join('assign_locations_to_users pl', 'pl.location_id = pm.location_id', 'left')
					 ->where('pl.user_id',$user_id)
 					 ->get();//echo $ci->db->last_query();
		$res = $query->result_array();
			   
 	 }
	 return $res[0]['location_names'];
 }
 
 ## function to show the name of that users, the plant assined to them.
 function assogned_users_of_the_plant($user_id='',$plant_id){
	 $res = 0;
	 if(!empty($user_id)){
		$ci = & get_instance();
 		$query = $ci ->db
					 ->select('GROUP_CONCAT( DISTINCT  f_name," ", l_name ) fullname',FALSE)
					 ->from('backend_user AS bu')->join('assign_plants_to_users pl', 'pl.user_id = bu.user_id', 'left')
					 ->where(array('pl.assigned_by'=>$user_id, 'pl.plant_id'=>$plant_id))
 					 ->get();//echo $ci->db->last_query();
		$res = $query->result_array();
  	 }
	 return $res[0]['fullname'];
 }
 
 
  function assigned_users_of_the_location($user_id='',$plant_id){
	 $res = 0;
	 if(!empty($user_id)){
		$ci = & get_instance();
 		$query = $ci ->db
					 ->select('GROUP_CONCAT( DISTINCT  f_name," ", l_name ) fullname',FALSE)
					 ->from('backend_user AS bu')->join('assign_locations_to_users pl', 'pl.user_id = bu.user_id', 'left')
					 ->where(array('pl.assigned_by'=>$user_id, 'pl.location_id'=>$plant_id))
 					 ->get();//echo $ci->db->last_query();
		$res = $query->result_array();
  	 }
	 return $res[0]['fullname'];
 }
 
  function view_order_data($userId){
  	$resData = 0;
	$ci = & get_instance();
    $query =$ci->db->select('*')->from('order_master')->where(array('order_id'=>$userId))->get();
	//echo $ci->db->last_query();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$resData = $res[0];
	}
	return $resData;
 }
 
   function get_product_data($ProductId){
  	$resData = 0;
	$ci = & get_instance();
    $query =$ci->db->select('*')->from('products')->where(array('id'=>$ProductId))->get();
	//echo $ci->db->last_query();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$resData = $res[0];
	}
	return $resData;
 }
 
function get_user_email_name($userid){
	$ci = & get_instance();
	$resdata=array();
	$query =$ci->db->select('email_id,f_name,l_name')->from("backend_user")->where(array('user_id'=>$userid))->get();
 	if ($query->num_rows() > 0) {
		$result = $query->result_array();
		$resdata=$result[0];
	}
	return $resdata;
 }
 
 
 //sanjay
 function get_consumer_id_by_mobile_number($consumer_mobile){
	$ci = & get_instance();
	$resdata=array();
	$query =$ci->db->select('id')->from("consumers")->where(array('mobile_no'=>$consumer_mobile))->get();
 	if ($query->num_rows() > 0) {
		$result = $query->result_array();
		$resdata=$result[0]['id'];
	}
	return $resdata;
 }
 
 
 
 function getSeoTitle($url='',$params=''){
 $ci = & get_instance();
 $user_id 	= $ci->session->userdata('admin_user_id');
 	$uri=$ci->uri->segment(2);
 	switch ($uri) {
    case "dashboard":
        $title = "Dashboard";
        break;
    case "list_plant_controllers": 
		$title = "User Listing";
        break;
    case "add_user": 
		 $title =  ($user_id>1)?"User:Add":"CCC Admin:Add";
        break;
	 case "view_user": 
		 $title =  ($user_id>1)?"View User":"View CCC Admin";
        break;	
		
	case "list_user": 
			$title = "List CCC Admin";
      break;
	case "list_orders": 
			$title = "Order Listing";
      break;
	case "edit_product": 
			$title = "Product Edit";
      break;
	case "change_password": 
			$title = "Change Password";
      break;
	case "profile_user": 
			$title = "User Profile";
      break;
	case "edit_profile_user": 
			$title = "Edit Profile";
      break;
	case "list_plants": 
			$title = "List Plants";
      break;  
	case "add_plant": 
			$title = "Add Plants";
      break;    
	case "edit_plant": 
			$title = "Edit Plants";
      break;   
	case "view_plant": 
			$title = "View Plants";
      break;   
	case "list_assigned_plants_sku": 
			$title = "Assigning Plants";
      break;  
	  
	  case "list_assigned_locations_sku": 
			$title = "Assigning locations";
      break; 
	   
	 case "list_product": 
			$title = "List Products";
      break;  
	case "add_product": 
			$title = "Add Products";
      break;   
	case "update_product": 
			$title = "Edit Products";
      break;     
	case "listing": 
			$title = "List Attributes";
      break;  
	case "get_edit_section": 
			$title = "Edit Attributes";
      break;   
	  
    default:
       $title = "Admin";
	} 
	return $title;
 }
 
 function getEssentialAttributes($productid=''){
  	$ci = & get_instance();
	$result = array();
  	$sql= "select code_type, code_activation_type, delivery_method, code_key_type, code_unity_type, code_size from products where id ='".$productid."'";
 	$q = $ci->db->query($sql);
 	$res = array();
 	$res = $q->result_array();
	if($q->num_rows()>0){
		$result = $res[0];
	}
  	return $result;
 }
 
 function printEssentialAttributes($order_id=''){
  	$ci = & get_instance();
	$result = array();
	$qry = $ci->db->select('O.product_id, P.code_type,P.code_unity_type,P.code_activation_type,P.delivery_method,P.code_key_type,P.code_size,P.created_by')
			 ->from('products P')
			 ->join('order_master O','P.id=O.product_id', 'left')
			 ->where('O.order_id',$order_id)
			 ->get();
  //	echo $ci->db->last_query();exit;
	if($qry->num_rows()>0){
		$res = $qry->result_array();
		$result = $res[0];
	}
  	return $result;
 }
 
 function getOtherIndustryData($id=''){
	 $name = '';
	 if(!empty($id)){
		$ci 	 = & get_instance();
		$query	 =$ci->db->select('industry_name,remark')->from('other_industry')->where(array('id'=>$id))->get();
		//echo $ci->db->last_query();
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0];
		}
		return $result; 
	 }
 }
 
 ## get all products name related to the assigned plant
 function productNameByAssignedPlants($plant_id=''){
  	$ci = & get_instance();
	$result = array();
 	 $sql = "select group_concat(P.product_name) name
	 		 from products P 
			 left join assign_plants AP 
			 on AP.product_id= P.id 
			 where AP.plant_id = '".$plant_id."'";
	$qry 		 = $ci->db->query( $sql );
   //	echo $ci->db->last_query();exit;
	if($qry->num_rows()>0){
		$res = $qry->result_array();
		$result = $res[0]['name'];
	}
  	return $result;
  }
  
  
  ## get all products name related to the assigned location
 function productNameByAssignedLocations($plant_id=''){
  	$ci = & get_instance();
	$result = array();
 	 $sql = "select group_concat(P.product_name) name
	 		 from products P 
			 left join assign_locations AP 
			 on AP.product_id= P.id 
			 where AP.location_id = '".$plant_id."'";
	$qry 		 = $ci->db->query( $sql );
   //	echo $ci->db->last_query();exit;
	if($qry->num_rows()>0){
		$res = $qry->result_array();
		$result = $res[0]['name'];
	}
  	return $result;
  }
  
  function question_id_by_product($product_id){
  	$ci = & get_instance();
	$res = array();
 	 $sql = "select  group_concat(question_id) as id
	 		 from product_feedback_questions
 			 where product_id = '".$product_id."'";
	$qry = $ci->db->query( $sql );
 // echo $ci->db->last_query();exit;
	if($qry->num_rows()>0){
		$res = $qry->result_array();
 	}//echo $res[0]['id'];
  	return $res[0]['id'];
  }
  
 
 
 
  
  function getAllChildFromParentUser($id=''){
 	$ci = & get_instance();
	$result = '';
 	if(!empty($id)){
		$sql= "select group_concat(user_id) as id from backend_user where is_parent='".$id."'";
		$q = $ci->db->query($sql);
		$res = $q->result_array();
 		if(count($result)>0){
			$result= $res[0]['id'];
		}
	 }
 	 return $result;
  }
  function getAssociatedPlantProducts($id=''){
 	$ci = & get_instance();
	$result = '';
 	if(!empty($id)){
		$sql= "select group_concat(product_id) as productId from assign_plants where plant_id='".$id."'";
		$q = $ci->db->query($sql);
		$res = $q->result_array();
 		if(count($result)>0){
			$result= $res[0]['productId'];
		}
	 }
 	 return $result;
  }
  
    function get_parent_id($user_id){
	$ci = & get_instance();
	$ci->db->select('is_parent');
	$ci->db->from('backend_user');
	$ci->db->where(array('status'=>'1','user_id'=>$user_id));
	$query = $ci->db->get();//echo $ci->db->last_query();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = $res[0]['is_parent'];
	} 
	return $res;  
}

function show_industry_by_level_wise($array_id){
	$ci = & get_instance();
 	$result = '';
	
	$ci->db->select('industry_data');
	$ci->db->from('products');
	$ci->db->where("INSTR(`other_industry`,'-||-$array_id')>0");
	$query = $ci->db->get(); //echo $ci->db->last_query();
	if ($query->num_rows() > 0) {
		$res = $query->result_array();
		$res = $res[0]['industry_data'];
	} 
	// print_r(json_decode($res));exit;
	foreach(json_decode($res) as $key=>$val){//print_r($val);
		if($key!='0' && $val!='other'){
			$result .="<br>&nbsp;&nbsp;-->";
		}
	 	$name = get_industry_by_id($val);
		$result .= $name[0]['categoryName'];
		//print_r($result);
	}
	return $result;
}

function product_delivery_method($int=''){
	$result = "-";
	if(!empty($int)){
		switch($int){
		case '1':
			$result = "Physically Printing By Super Admin";
		 break;
		 
		 case '2':
			$result = "Physically Printing By CCC Admin";
		 break;
		 
		 case '3':
			$result = "Physically Printing By Designated Plant Controller";
		 break;
		 
		 case '4':
			$result = "Deliver By E - Mode";
		 break;
 		}
	}
	return $result;
}

function getProductSize($val=''){
	$value = '-';
	if($val!=''){
		switch($val){
			case 'S':
			$value= 'Small';
			break;
			
			case 'M':
			$value= 'Medium';
			break;
			
			case 'L':
			$value= 'Large';
			break;
		}
	}
	return $value;
}

function isProductRegistered($bar_code_data) {
        $query = $this->db->get_where('purchased_product', array('bar_code' => $bar_code_data));
	   //$query = $this->db->get_where('purchased_product',"bar_code='".$bar_code_data."' OR bar_code='".$bar_code2_data."'");
        if ($query->num_rows() > 0) {
            $data = $query->row_array();            
            return true;
        } else {
            return false;
        }
    }
	
	
function isProductCodeRegistered($bar_code_data){
	$ci = & get_instance();
	$ci->db->select('bar_code');
	$ci->db->from('purchased_product');
	$ci->db->where(array('bar_code'=>$bar_code_data));
	$query = $ci->db->get();//echo $ci->db->last_query();
	if ($query->num_rows() > 0) {
		 return true;
        } else {
            return false;
        } 
}



   function NumberOfAllConsumersOfACustomer($customer_id){
		$ci = & get_instance();
		$ci->db->select('customer_id');
		$ci->db->from('consumer_customer_link');
		$ci->db->where(array('customer_id'=>$customer_id));
		$query = $ci->db->get();//echo $ci->db->last_query();
		return $query->num_rows();
}

   function NumberOfSelectedConsumersByACustomer($customer_id, $consumer_gender, $consumer_city, $consumer_min_age, $consumer_max_age,$earned_loyalty_points_clubbed, $monthly_earnings, $job_profile, $education_qualification, $type_vehicle, $profession, $marital_status, $no_of_family_members, $loan_car, $loan_housing, $personal_loan, $credit_card_loan, $own_a_car, $house_type, $last_location, $life_insurance, $medical_insurance, $height_in_inches, $weight_in_kg, $hobbies, $sports, $entertainment, $spouse_gender, $spouse_phone, $spouse_dob, $marriage_anniversary, $spouse_work_status, $spouse_edu_qualification, $spouse_monthly_income, $spouse_loan, $spouse_personal_loan, $spouse_credit_card_loan, $spouse_own_a_car, $spouse_house_type, $spouse_height_inches, $spouse_weight_kg, $spouse_hobbies, $spouse_sports, $spouse_entertainment, $field_1, $field_2, $field_3, $field_4, $field_5, $field_6, $field_7, $field_8, $field_9, $field_10, $field_11, $field_12, $field_13, $field_14, $field_15, $field_16, $field_17, $field_18, $field_19, $field_20, $field_21, $field_22, $field_23, $field_24, $field_25, $field_26, $field_27, $field_28, $field_29, $field_30, $field_31, $field_32, $field_33, $field_34, $field_35, $field_36, $field_37, $field_38, $field_39, $field_40, $field_41, $field_42, $field_43, $field_44, $field_45, $field_46, $field_47, $field_48, $field_49, $field_50, $field_51, $field_52, $field_53, $field_54, $field_55, $field_56, $field_57, $field_58, $field_59, $field_60, $field_61, $field_62, $field_63, $field_64, $field_65, $field_66, $field_67, $field_68, $field_69, $field_70, $field_71, $field_72, $field_73, $field_74, $field_75, $field_76, $field_77, $field_78, $field_79, $field_80, $field_81, $field_82, $field_83, $field_84, $field_85, $field_86, $field_87, $field_88, $field_89, $field_90, $field_91, $field_92, $field_93, $field_94, $field_95, $field_96, $field_97, $field_98, $field_99, $field_100, $field_101, $field_102, $field_103, $field_104, $field_105, $field_106, $field_107, $field_108, $field_109, $field_110, $field_111, $field_112, $field_113, $field_114, $field_115, $field_116, $field_117, $field_118, $field_119, $field_120, $field_121, $field_122, $field_123, $field_124, $field_125, $field_126, $field_127, $field_128, $field_129, $field_130, $field_131, $field_132, $field_133, $field_134, $field_135, $field_136, $field_137, $field_138, $field_139, $field_140, $field_141, $field_142, $field_143, $field_144, $field_145, $field_146, $field_147, $field_148, $field_149, $field_150, $field_151, $field_152, $field_153, $field_154, $field_155, $field_156, $field_157, $field_158, $field_159, $field_160, $field_161, $field_162, $field_163, $field_164, $field_165, $field_166, $field_167, $field_168, $field_169, $field_170, $field_171, $field_172, $field_173, $field_174, $field_175, $field_176, $field_177, $field_178, $field_179, $field_180, $field_181, $field_182, $field_183, $field_184, $field_185, $field_186, $field_187, $field_188, $field_189, $field_190, $field_191, $field_192, $field_193, $field_194, $field_195, $field_196, $field_197, $field_198, $field_199, $field_200, $field_201){
	   	
	
		$ci = & get_instance();
		$ci->db->select('CCL.customer_id');		
		$ci->db->from('consumer_customer_link CCL');
		//$ci->db->join('consumer_selection_criteria CSC', 'CSC.customer_id = CCL.customer_id');
		$ci->db->join('consumers C', 'C.id = CCL.consumer_id');
		$array = array('CCL.customer_id' => $customer_id);
		$ci->db->where($array);
		
		
		if($consumer_gender!='all') {
		$ci->db->where('C.gender', $consumer_gender);
			}
			
		if($consumer_city!='all') {
		$ci->db->where('C.city', $consumer_city);
			}	
		
		$consumer_min_dob = date('Y-m-d', strtotime('-' . $consumer_min_age . ' years'));
		$consumer_max_dob = date('Y-m-d', strtotime('-' . $consumer_max_age . ' years'));
		
		if(!empty($consumer_max_age)){ 
		$ci->db->where('C.dob >=', $consumer_max_dob);
		//$ci->db->or_where('C.dob =', 'NULL');
			}
		if(!empty($consumer_min_age)){ 
		$ci->db->where('C.dob <=', $consumer_min_dob);
		//$ci->db->or_where('C.dob =', 'NULL');
			}
			
			/*
			$arr = explode(' ',trim($earned_loyalty_points_clubbed));
			$ELP_from = $arr[0];
			$ELP_to = $arr[2];			
			if($earned_loyalty_points_clubbed!='all') { 
			$ci->db->where('C.total_accumulated_points BETWEEN "'. $ELP_from . '" and "'. $ELP_to .'"');
				}
			*/
			$arr1 = explode(' ',trim($monthly_earnings));
			$ME_from = $arr1[0];
			$ME_to = $arr1[2];			
			if($monthly_earnings!='all') { $ci->db->where('C.monthly_earnings BETWEEN "'. $ME_from . '" and "'. $ME_to .'"');}
			
				
						
			if($job_profile!='all') { $ci->db->where('C.job_profile', $job_profile); }
			if($education_qualification!='all') { $ci->db->where('C.education_qualification', $education_qualification); }
			if($type_vehicle!='all') { $ci->db->where('C.type_vehicle', $type_vehicle); }
			if($profession!='all') { $ci->db->where('C.profession', $profession); }
			if($marital_status!='all') { $ci->db->where('C.marital_status', $marital_status); }
			if($no_of_family_members!='all') { $ci->db->where('C.no_of_family_members', $no_of_family_members); }
			if($loan_car!='all') { $ci->db->where('C.loan_car', $loan_car); }
			if($loan_housing!='all') { $ci->db->where('C.loan_housing', $loan_housing); }
			if($personal_loan!='all') { $ci->db->where('C.personal_loan', $personal_loan); }
			if($credit_card_loan!='all') { $ci->db->where('C.credit_card_loan', $credit_card_loan); }
			if($own_a_car!='all') { $ci->db->where('C.own_a_car', $own_a_car); }
			if($house_type!='all') { $ci->db->where('C.house_type', $house_type); }
			if($last_location!='all') { $ci->db->where('C.last_location', $last_location); }
			if($life_insurance!='all') { $ci->db->where('C.life_insurance', $life_insurance); }
			if($medical_insurance!='all') { $ci->db->where('C.medical_insurance', $medical_insurance); }
			if($height_in_inches!='all') { $ci->db->where('C.height_in_inches', $height_in_inches); }
			if($weight_in_kg!='all') { $ci->db->where('C.weight_in_kg', $weight_in_kg); }
			if($hobbies!='all') { $ci->db->where('C.hobbies', $hobbies); }
			if($sports!='all') { $ci->db->where('C.sports', $sports); }
			if($entertainment!='all') { $ci->db->where('C.entertainment', $entertainment); }
			if($spouse_gender!='all') { $ci->db->where('C.spouse_gender', $spouse_gender); }
			if($spouse_phone!='all') { $ci->db->where('C.spouse_phone', $spouse_phone); }
			if($spouse_dob!='all') { $ci->db->where('C.spouse_dob', $spouse_dob); }
			if($marriage_anniversary!='all') { $ci->db->where('C.marriage_anniversary', $marriage_anniversary); }
			if($spouse_work_status!='all') { $ci->db->where('C.spouse_work_status', $spouse_work_status); }
			if($spouse_edu_qualification!='all') { $ci->db->where('C.spouse_edu_qualification', $spouse_edu_qualification); }
			if($spouse_monthly_income!='all') { $ci->db->where('C.spouse_monthly_income', $spouse_monthly_income); }
			if($spouse_loan!='all') { $ci->db->where('C.spouse_loan', $spouse_loan); }
			if($spouse_personal_loan!='all') { $ci->db->where('C.spouse_personal_loan', $spouse_personal_loan); }
			if($spouse_credit_card_loan!='all') { $ci->db->where('C.spouse_credit_card_loan', $spouse_credit_card_loan); }
			if($spouse_own_a_car!='all') { $ci->db->where('C.spouse_own_a_car', $spouse_own_a_car); }
			if($spouse_house_type!='all') { $ci->db->where('C.spouse_house_type', $spouse_house_type); }
			if($spouse_height_inches!='all') { $ci->db->where('C.spouse_height_inches', $spouse_height_inches); }
			if($spouse_weight_kg!='all') { $ci->db->where('C.spouse_weight_kg', $spouse_weight_kg); }
			if($spouse_hobbies!='all') { $ci->db->where('C.spouse_hobbies', $spouse_hobbies); }
			if($spouse_sports!='all') { $ci->db->where('C.spouse_sports', $spouse_sports); }
			if($spouse_entertainment!='all') { $ci->db->where('C.spouse_entertainment', $spouse_entertainment); }
			if($field_1!='all') { $ci->db->where('C.field_1', $field_1); }
			if($field_2!='all') { $ci->db->where('C.field_2', $field_2); }
			if($field_3!='all') { $ci->db->where('C.field_3', $field_3); }
			if($field_4!='all') { $ci->db->where('C.field_4', $field_4); }
			if($field_5!='all') { $ci->db->where('C.field_5', $field_5); }
			if($field_6!='all') { $ci->db->where('C.field_6', $field_6); }
			if($field_7!='all') { $ci->db->where('C.field_7', $field_7); }
			if($field_8!='all') { $ci->db->where('C.field_8', $field_8); }
			if($field_9!='all') { $ci->db->where('C.field_9', $field_9); }
			if($field_10!='all') { $ci->db->where('C.field_10', $field_10); }
			if($field_11!='all') { $ci->db->where('C.field_11', $field_11); }
			if($field_12!='all') { $ci->db->where('C.field_12', $field_12); }
			if($field_13!='all') { $ci->db->where('C.field_13', $field_13); }
			if($field_14!='all') { $ci->db->where('C.field_14', $field_14); }
			if($field_15!='all') { $ci->db->where('C.field_15', $field_15); }
			if($field_16!='all') { $ci->db->where('C.field_16', $field_16); }
			if($field_17!='all') { $ci->db->where('C.field_17', $field_17); }
			if($field_18!='all') { $ci->db->where('C.field_18', $field_18); }
			if($field_19!='all') { $ci->db->where('C.field_19', $field_19); }
			if($field_20!='all') { $ci->db->where('C.field_20', $field_20); }
			if($field_21!='all') { $ci->db->where('C.field_21', $field_21); }
			if($field_22!='all') { $ci->db->where('C.field_22', $field_22); }
			if($field_23!='all') { $ci->db->where('C.field_23', $field_23); }
			if($field_24!='all') { $ci->db->where('C.field_24', $field_24); }
			if($field_25!='all') { $ci->db->where('C.field_25', $field_25); }
			if($field_26!='all') { $ci->db->where('C.field_26', $field_26); }
			if($field_27!='all') { $ci->db->where('C.field_27', $field_27); }
			if($field_28!='all') { $ci->db->where('C.field_28', $field_28); }
			if($field_29!='all') { $ci->db->where('C.field_29', $field_29); }
			if($field_30!='all') { $ci->db->where('C.field_30', $field_30); }
			if($field_31!='all') { $ci->db->where('C.field_31', $field_31); }
			if($field_32!='all') { $ci->db->where('C.field_32', $field_32); }
			if($field_33!='all') { $ci->db->where('C.field_33', $field_33); }
			if($field_34!='all') { $ci->db->where('C.field_34', $field_34); }
			if($field_35!='all') { $ci->db->where('C.field_35', $field_35); }
			if($field_36!='all') { $ci->db->where('C.field_36', $field_36); }
			if($field_37!='all') { $ci->db->where('C.field_37', $field_37); }
			if($field_38!='all') { $ci->db->where('C.field_38', $field_38); }
			if($field_39!='all') { $ci->db->where('C.field_39', $field_39); }
			if($field_40!='all') { $ci->db->where('C.field_40', $field_40); }
			if($field_41!='all') { $ci->db->where('C.field_41', $field_41); }
			if($field_42!='all') { $ci->db->where('C.field_42', $field_42); }
			if($field_43!='all') { $ci->db->where('C.field_43', $field_43); }
			if($field_44!='all') { $ci->db->where('C.field_44', $field_44); }
			if($field_45!='all') { $ci->db->where('C.field_45', $field_45); }
			if($field_46!='all') { $ci->db->where('C.field_46', $field_46); }
			if($field_47!='all') { $ci->db->where('C.field_47', $field_47); }
			if($field_48!='all') { $ci->db->where('C.field_48', $field_48); }
			if($field_49!='all') { $ci->db->where('C.field_49', $field_49); }
			if($field_50!='all') { $ci->db->where('C.field_50', $field_50); }
			if($field_51!='all') { $ci->db->where('C.field_51', $field_51); }
			if($field_52!='all') { $ci->db->where('C.field_52', $field_52); }
			if($field_53!='all') { $ci->db->where('C.field_53', $field_53); }
			if($field_54!='all') { $ci->db->where('C.field_54', $field_54); }
			if($field_55!='all') { $ci->db->where('C.field_55', $field_55); }
			if($field_56!='all') { $ci->db->where('C.field_56', $field_56); }
			if($field_57!='all') { $ci->db->where('C.field_57', $field_57); }
			if($field_58!='all') { $ci->db->where('C.field_58', $field_58); }
			if($field_59!='all') { $ci->db->where('C.field_59', $field_59); }
			if($field_60!='all') { $ci->db->where('C.field_60', $field_60); }
			if($field_61!='all') { $ci->db->where('C.field_61', $field_61); }
			if($field_62!='all') { $ci->db->where('C.field_62', $field_62); }
			if($field_63!='all') { $ci->db->where('C.field_63', $field_63); }
			if($field_64!='all') { $ci->db->where('C.field_64', $field_64); }
			if($field_65!='all') { $ci->db->where('C.field_65', $field_65); }
			if($field_66!='all') { $ci->db->where('C.field_66', $field_66); }
			if($field_67!='all') { $ci->db->where('C.field_67', $field_67); }
			if($field_68!='all') { $ci->db->where('C.field_68', $field_68); }
			if($field_69!='all') { $ci->db->where('C.field_69', $field_69); }
			if($field_70!='all') { $ci->db->where('C.field_70', $field_70); }
			if($field_71!='all') { $ci->db->where('C.field_71', $field_71); }
			if($field_72!='all') { $ci->db->where('C.field_72', $field_72); }
			if($field_73!='all') { $ci->db->where('C.field_73', $field_73); }
			if($field_74!='all') { $ci->db->where('C.field_74', $field_74); }
			if($field_75!='all') { $ci->db->where('C.field_75', $field_75); }
			if($field_76!='all') { $ci->db->where('C.field_76', $field_76); }
			if($field_77!='all') { $ci->db->where('C.field_77', $field_77); }
			if($field_78!='all') { $ci->db->where('C.field_78', $field_78); }
			if($field_79!='all') { $ci->db->where('C.field_79', $field_79); }
			if($field_80!='all') { $ci->db->where('C.field_80', $field_80); }
			if($field_81!='all') { $ci->db->where('C.field_81', $field_81); }
			if($field_82!='all') { $ci->db->where('C.field_82', $field_82); }
			if($field_83!='all') { $ci->db->where('C.field_83', $field_83); }
			if($field_84!='all') { $ci->db->where('C.field_84', $field_84); }
			if($field_85!='all') { $ci->db->where('C.field_85', $field_85); }
			if($field_86!='all') { $ci->db->where('C.field_86', $field_86); }
			if($field_87!='all') { $ci->db->where('C.field_87', $field_87); }
			if($field_88!='all') { $ci->db->where('C.field_88', $field_88); }
			if($field_89!='all') { $ci->db->where('C.field_89', $field_89); }
			if($field_90!='all') { $ci->db->where('C.field_90', $field_90); }
			if($field_91!='all') { $ci->db->where('C.field_91', $field_91); }
			if($field_92!='all') { $ci->db->where('C.field_92', $field_92); }
			if($field_93!='all') { $ci->db->where('C.field_93', $field_93); }
			if($field_94!='all') { $ci->db->where('C.field_94', $field_94); }
			if($field_95!='all') { $ci->db->where('C.field_95', $field_95); }
			if($field_96!='all') { $ci->db->where('C.field_96', $field_96); }
			if($field_97!='all') { $ci->db->where('C.field_97', $field_97); }
			if($field_98!='all') { $ci->db->where('C.field_98', $field_98); }
			if($field_99!='all') { $ci->db->where('C.field_99', $field_99); }
			if($field_100!='all') { $ci->db->where('C.field_100', $field_100); }
			if($field_101!='all') { $ci->db->where('C.field_101', $field_101); }
			if($field_102!='all') { $ci->db->where('C.field_102', $field_102); }
			if($field_103!='all') { $ci->db->where('C.field_103', $field_103); }
			if($field_104!='all') { $ci->db->where('C.field_104', $field_104); }
			if($field_105!='all') { $ci->db->where('C.field_105', $field_105); }
			if($field_106!='all') { $ci->db->where('C.field_106', $field_106); }
			if($field_107!='all') { $ci->db->where('C.field_107', $field_107); }
			if($field_108!='all') { $ci->db->where('C.field_108', $field_108); }
			if($field_109!='all') { $ci->db->where('C.field_109', $field_109); }
			if($field_110!='all') { $ci->db->where('C.field_110', $field_110); }
			if($field_111!='all') { $ci->db->where('C.field_111', $field_111); }
			if($field_112!='all') { $ci->db->where('C.field_112', $field_112); }
			if($field_113!='all') { $ci->db->where('C.field_113', $field_113); }
			if($field_114!='all') { $ci->db->where('C.field_114', $field_114); }
			if($field_115!='all') { $ci->db->where('C.field_115', $field_115); }
			if($field_116!='all') { $ci->db->where('C.field_116', $field_116); }
			if($field_117!='all') { $ci->db->where('C.field_117', $field_117); }
			if($field_118!='all') { $ci->db->where('C.field_118', $field_118); }
			if($field_119!='all') { $ci->db->where('C.field_119', $field_119); }
			if($field_120!='all') { $ci->db->where('C.field_120', $field_120); }
			if($field_121!='all') { $ci->db->where('C.field_121', $field_121); }
			if($field_122!='all') { $ci->db->where('C.field_122', $field_122); }
			if($field_123!='all') { $ci->db->where('C.field_123', $field_123); }
			if($field_124!='all') { $ci->db->where('C.field_124', $field_124); }
			if($field_125!='all') { $ci->db->where('C.field_125', $field_125); }
			if($field_126!='all') { $ci->db->where('C.field_126', $field_126); }
			if($field_127!='all') { $ci->db->where('C.field_127', $field_127); }
			if($field_128!='all') { $ci->db->where('C.field_128', $field_128); }
			if($field_129!='all') { $ci->db->where('C.field_129', $field_129); }
			if($field_130!='all') { $ci->db->where('C.field_130', $field_130); }
			if($field_131!='all') { $ci->db->where('C.field_131', $field_131); }
			if($field_132!='all') { $ci->db->where('C.field_132', $field_132); }
			if($field_133!='all') { $ci->db->where('C.field_133', $field_133); }
			if($field_134!='all') { $ci->db->where('C.field_134', $field_134); }
			if($field_135!='all') { $ci->db->where('C.field_135', $field_135); }
			if($field_136!='all') { $ci->db->where('C.field_136', $field_136); }
			if($field_137!='all') { $ci->db->where('C.field_137', $field_137); }
			if($field_138!='all') { $ci->db->where('C.field_138', $field_138); }
			if($field_139!='all') { $ci->db->where('C.field_139', $field_139); }
			if($field_140!='all') { $ci->db->where('C.field_140', $field_140); }
			if($field_141!='all') { $ci->db->where('C.field_141', $field_141); }
			if($field_142!='all') { $ci->db->where('C.field_142', $field_142); }
			if($field_143!='all') { $ci->db->where('C.field_143', $field_143); }
			if($field_144!='all') { $ci->db->where('C.field_144', $field_144); }
			if($field_145!='all') { $ci->db->where('C.field_145', $field_145); }
			if($field_146!='all') { $ci->db->where('C.field_146', $field_146); }
			if($field_147!='all') { $ci->db->where('C.field_147', $field_147); }
			if($field_148!='all') { $ci->db->where('C.field_148', $field_148); }
			if($field_149!='all') { $ci->db->where('C.field_149', $field_149); }
			if($field_150!='all') { $ci->db->where('C.field_150', $field_150); }
			if($field_151!='all') { $ci->db->where('C.field_151', $field_151); }
			if($field_152!='all') { $ci->db->where('C.field_152', $field_152); }
			if($field_153!='all') { $ci->db->where('C.field_153', $field_153); }
			if($field_154!='all') { $ci->db->where('C.field_154', $field_154); }
			if($field_155!='all') { $ci->db->where('C.field_155', $field_155); }
			if($field_156!='all') { $ci->db->where('C.field_156', $field_156); }
			if($field_157!='all') { $ci->db->where('C.field_157', $field_157); }
			if($field_158!='all') { $ci->db->where('C.field_158', $field_158); }
			if($field_159!='all') { $ci->db->where('C.field_159', $field_159); }
			if($field_160!='all') { $ci->db->where('C.field_160', $field_160); }
			if($field_161!='all') { $ci->db->where('C.field_161', $field_161); }
			if($field_162!='all') { $ci->db->where('C.field_162', $field_162); }
			if($field_163!='all') { $ci->db->where('C.field_163', $field_163); }
			if($field_164!='all') { $ci->db->where('C.field_164', $field_164); }
			if($field_165!='all') { $ci->db->where('C.field_165', $field_165); }
			if($field_166!='all') { $ci->db->where('C.field_166', $field_166); }
			if($field_167!='all') { $ci->db->where('C.field_167', $field_167); }
			if($field_168!='all') { $ci->db->where('C.field_168', $field_168); }
			if($field_169!='all') { $ci->db->where('C.field_169', $field_169); }
			if($field_170!='all') { $ci->db->where('C.field_170', $field_170); }
			if($field_171!='all') { $ci->db->where('C.field_171', $field_171); }
			if($field_172!='all') { $ci->db->where('C.field_172', $field_172); }
			if($field_173!='all') { $ci->db->where('C.field_173', $field_173); }
			if($field_174!='all') { $ci->db->where('C.field_174', $field_174); }
			if($field_175!='all') { $ci->db->where('C.field_175', $field_175); }
			if($field_176!='all') { $ci->db->where('C.field_176', $field_176); }
			if($field_177!='all') { $ci->db->where('C.field_177', $field_177); }
			if($field_178!='all') { $ci->db->where('C.field_178', $field_178); }
			if($field_179!='all') { $ci->db->where('C.field_179', $field_179); }
			if($field_180!='all') { $ci->db->where('C.field_180', $field_180); }
			if($field_181!='all') { $ci->db->where('C.field_181', $field_181); }
			if($field_182!='all') { $ci->db->where('C.field_182', $field_182); }
			if($field_183!='all') { $ci->db->where('C.field_183', $field_183); }
			if($field_184!='all') { $ci->db->where('C.field_184', $field_184); }
			if($field_185!='all') { $ci->db->where('C.field_185', $field_185); }
			if($field_186!='all') { $ci->db->where('C.field_186', $field_186); }
			if($field_187!='all') { $ci->db->where('C.field_187', $field_187); }
			if($field_188!='all') { $ci->db->where('C.field_188', $field_188); }
			if($field_189!='all') { $ci->db->where('C.field_189', $field_189); }
			if($field_190!='all') { $ci->db->where('C.field_190', $field_190); }
			if($field_191!='all') { $ci->db->where('C.field_191', $field_191); }
			if($field_192!='all') { $ci->db->where('C.field_192', $field_192); }
			if($field_193!='all') { $ci->db->where('C.field_193', $field_193); }
			if($field_194!='all') { $ci->db->where('C.field_194', $field_194); }
			if($field_195!='all') { $ci->db->where('C.field_195', $field_195); }
			if($field_196!='all') { $ci->db->where('C.field_196', $field_196); }
			if($field_197!='all') { $ci->db->where('C.field_197', $field_197); }
			if($field_198!='all') { $ci->db->where('C.field_198', $field_198); }
			if($field_199!='all') { $ci->db->where('C.field_199', $field_199); }
			if($field_200!='all') { $ci->db->where('C.field_200', $field_200); }
			if($field_201!='all') { $ci->db->where('C.field_201', $field_201); }
		
		
		
		
		
		/*
		if(($consumer_gender=='male')||($consumer_gender=='female')) {
		$ci->db->where('C.gender', $consumer_gender);
			}
			
		if(!empty($csc_consumer_city)){ 			
		$ci->db->where('C.city', $csc_consumer_city);
			}
			/*
		if($csc_consumer_pin!=0){ 			
		$ci->db->where('C.pin_code', $csc_consumer_pin);
			}	
			*/
			/*
		if(!empty($csc_consumer_min_dob)){ 			
		$ci->db->where('C.dob <', $csc_consumer_min_dob);
			}	
		
		if(!empty($csc_consumer_max_dob)){ 			
		$ci->db->where('C.dob >', $csc_consumer_max_dob);
			}
		
		*/

		//$ci->db->where("$CurrentAge BETWEEN $minvalue AND $maxvalue");
		
		//$ci->db->where("$CurrentAge BETWEEN $minvalue AND $maxvalue");
		$query = $ci->db->get();//echo $ci->db->last_query();
		return $query->num_rows();
}

 
	


   function NumberOfSelectedConsumersByACustomer2($customer_id, $unique_system_selection_criteria_id){
	   	
	
		$ci = & get_instance();
		$ci->db->select('C.*');
		$ci->db->from('consumers C');		
		$ci->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		
		//$ci->db->join('consumer_passbook CP', 'CP.consumer_id = C.id'); // see
		
		//$ci->db->join('consumers C', 'C.id = CCL.consumer_id');
		//$array = array('CCL.customer_id' => $customer_id);
		$query = $ci->db->query("SELECT * FROM consumer_selection_criteria WHERE unique_system_selection_criteria_id =  '$unique_system_selection_criteria_id'");
		$row = $query->row();
		//$row->item_id
		
		$ci->db->where('CCL.customer_id', $customer_id);
		
		if($row->consumer_gender!='all') {
		$ci->db->where('C.gender', $row->consumer_gender);
			}
		if($row->consumer_city!='all') {
		$ci->db->where('C.city', $row->consumer_city);
			}
		
		$consumer_min_dob = date('Y-m-d', strtotime('-' . $row->consumer_min_age . ' years'));
		$consumer_max_dob = date('Y-m-d', strtotime('-' . $row->consumer_max_age . ' years'));
		
		if(!empty($row->consumer_max_age)){ 
		$ci->db->where('C.dob >=', $consumer_max_dob);
		//$ci->db->or_where('C.dob =', 'NULL');
			}
		if(!empty($row->consumer_min_age)){ 
		$ci->db->where('C.dob <=', $consumer_min_dob);
		//$ci->db->or_where('C.dob =', 'NULL');
			}
			
			/*
			$arr = explode(' ',trim($earned_loyalty_points_clubbed));
			$ELP_from = $arr[0];
			$ELP_to = $arr[2];			
			if($earned_loyalty_points_clubbed!='all') { 
			$ci->db->where('C.total_accumulated_points BETWEEN "'. $ELP_from . '" and "'. $ELP_to .'"');
				}
			*/
			$arr1 = explode(' ',trim($row->monthly_earnings));
			$ME_from = $arr1[0];
			$ME_to = $arr1[2];			
			if($row->monthly_earnings!='all') { $ci->db->where('C.monthly_earnings BETWEEN "'. $ME_from . '" and "'. $ME_to .'"');}	
						
			if($row->job_profile!='all') { $ci->db->where('C.job_profile', $row->job_profile); }
			if($row->education_qualification!='all') { $ci->db->where('C.education_qualification', $row->education_qualification); }
			if($row->type_vehicle!='all') { $ci->db->where('C.type_vehicle', $row->type_vehicle); }
			if($row->profession!='all') { $ci->db->where('C.profession', $row->profession); }
			if($row->marital_status!='all') { $ci->db->where('C.marital_status', $row->marital_status); }
			if($row->no_of_family_members!='all') { $ci->db->where('C.no_of_family_members', $row->no_of_family_members); }
			if($row->loan_car!='all') { $ci->db->where('C.loan_car', $row->loan_car); }
			if($row->loan_housing!='all') { $ci->db->where('C.loan_housing', $row->loan_housing); }
			if($row->personal_loan!='all') { $ci->db->where('C.personal_loan', $row->personal_loan); }
			if($row->credit_card_loan!='all') { $ci->db->where('C.credit_card_loan', $row->credit_card_loan); }
			if($row->own_a_car!='all') { $ci->db->where('C.own_a_car', $row->own_a_car); }
			if($row->house_type!='all') { $ci->db->where('C.house_type', $row->house_type); }
			if($row->last_location!='all') { $ci->db->where('C.last_location', $row->last_location); }
			if($row->life_insurance!='all') { $ci->db->where('C.life_insurance', $row->life_insurance); }
			if($row->medical_insurance!='all') { $ci->db->where('C.medical_insurance', $row->medical_insurance); }
			if($row->height_in_inches!='all') { $ci->db->where('C.height_in_inches', $row->height_in_inches); }
			if($row->weight_in_kg!='all') { $ci->db->where('C.weight_in_kg', $row->weight_in_kg); }
			if($row->hobbies!='all') { $ci->db->where('C.hobbies', $row->hobbies); }
			if($row->sports!='all') { $ci->db->where('C.sports', $row->sports); }
			if($row->entertainment!='all') { $ci->db->where('C.entertainment', $row->entertainment); }
			if($row->spouse_gender!='all') { $ci->db->where('C.spouse_gender', $row->spouse_gender); }
			if($row->spouse_phone!='all') { $ci->db->where('C.spouse_phone', $row->spouse_phone); }
			if($row->spouse_dob!='all') { $ci->db->where('C.spouse_dob', $row->spouse_dob); }
			if($row->marriage_anniversary!='all') { $ci->db->where('C.marriage_anniversary', $row->marriage_anniversary); }
			if($row->spouse_work_status!='all') { $ci->db->where('C.spouse_work_status', $row->spouse_work_status); }
			if($row->spouse_edu_qualification!='all') { $ci->db->where('C.spouse_edu_qualification', $row->spouse_edu_qualification); }
			if($row->spouse_monthly_income!='all') { $ci->db->where('C.spouse_monthly_income', $row->spouse_monthly_income); }
			if($row->spouse_loan!='all') { $ci->db->where('C.spouse_loan', $row->spouse_loan); }
			if($row->spouse_personal_loan!='all') { $ci->db->where('C.spouse_personal_loan', $row->spouse_personal_loan); }
			if($row->spouse_credit_card_loan!='all') { $ci->db->where('C.spouse_credit_card_loan', $row->spouse_credit_card_loan); }
			if($row->spouse_own_a_car!='all') { $ci->db->where('C.spouse_own_a_car', $row->spouse_own_a_car); }
			if($row->spouse_house_type!='all') { $ci->db->where('C.spouse_house_type', $row->spouse_house_type); }
			if($row->spouse_height_inches!='all') { $ci->db->where('C.spouse_height_inches', $row->spouse_height_inches); }
			if($row->spouse_weight_kg!='all') { $ci->db->where('C.spouse_weight_kg', $row->spouse_weight_kg); }
			if($row->spouse_hobbies!='all') { $ci->db->where('C.spouse_hobbies', $row->spouse_hobbies); }
			if($row->spouse_sports!='all') { $ci->db->where('C.spouse_sports', $row->spouse_sports); }
			if($row->spouse_entertainment!='all') { $ci->db->where('C.spouse_entertainment', $row->spouse_entertainment); }
			if($row->field_1!='all') { $ci->db->where('C.field_1', $row->field_1); }
			if($row->field_2!='all') { $ci->db->where('C.field_2', $row->field_2); }
			if($row->field_3!='all') { $ci->db->where('C.field_3', $row->field_3); }
			if($row->field_4!='all') { $ci->db->where('C.field_4', $row->field_4); }
			if($row->field_5!='all') { $ci->db->where('C.field_5', $row->field_5); }
			if($row->field_6!='all') { $ci->db->where('C.field_6', $row->field_6); }
			if($row->field_7!='all') { $ci->db->where('C.field_7', $row->field_7); }
			if($row->field_8!='all') { $ci->db->where('C.field_8', $row->field_8); }
			if($row->field_9!='all') { $ci->db->where('C.field_9', $row->field_9); }
			if($row->field_10!='all') { $ci->db->where('C.field_10', $row->field_10); }
			if($row->field_11!='all') { $ci->db->where('C.field_11', $row->field_11); }
			if($row->field_12!='all') { $ci->db->where('C.field_12', $row->field_12); }
			if($row->field_13!='all') { $ci->db->where('C.field_13', $row->field_13); }
			if($row->field_14!='all') { $ci->db->where('C.field_14', $row->field_14); }
			if($row->field_15!='all') { $ci->db->where('C.field_15', $row->field_15); }
			if($row->field_16!='all') { $ci->db->where('C.field_16', $row->field_16); }
			if($row->field_17!='all') { $ci->db->where('C.field_17', $row->field_17); }
			if($row->field_18!='all') { $ci->db->where('C.field_18', $row->field_18); }
			if($row->field_19!='all') { $ci->db->where('C.field_19', $row->field_19); }
			if($row->field_20!='all') { $ci->db->where('C.field_20', $row->field_20); }
			if($row->field_21!='all') { $ci->db->where('C.field_21', $row->field_21); }
			if($row->field_22!='all') { $ci->db->where('C.field_22', $row->field_22); }
			if($row->field_23!='all') { $ci->db->where('C.field_23', $row->field_23); }
			if($row->field_24!='all') { $ci->db->where('C.field_24', $row->field_24); }
			if($row->field_25!='all') { $ci->db->where('C.field_25', $row->field_25); }
			if($row->field_26!='all') { $ci->db->where('C.field_26', $row->field_26); }
			if($row->field_27!='all') { $ci->db->where('C.field_27', $row->field_27); }
			if($row->field_28!='all') { $ci->db->where('C.field_28', $row->field_28); }
			if($row->field_29!='all') { $ci->db->where('C.field_29', $row->field_29); }
			if($row->field_30!='all') { $ci->db->where('C.field_30', $row->field_30); }
			if($row->field_31!='all') { $ci->db->where('C.field_31', $row->field_31); }
			if($row->field_32!='all') { $ci->db->where('C.field_32', $row->field_32); }
			if($row->field_33!='all') { $ci->db->where('C.field_33', $row->field_33); }
			if($row->field_34!='all') { $ci->db->where('C.field_34', $row->field_34); }
			if($row->field_35!='all') { $ci->db->where('C.field_35', $row->field_35); }
			if($row->field_36!='all') { $ci->db->where('C.field_36', $row->field_36); }
			if($row->field_37!='all') { $ci->db->where('C.field_37', $row->field_37); }
			if($row->field_38!='all') { $ci->db->where('C.field_38', $row->field_38); }
			if($row->field_39!='all') { $ci->db->where('C.field_39', $row->field_39); }
			if($row->field_40!='all') { $ci->db->where('C.field_40', $row->field_40); }
			if($row->field_41!='all') { $ci->db->where('C.field_41', $row->field_41); }
			if($row->field_42!='all') { $ci->db->where('C.field_42', $row->field_42); }
			if($row->field_43!='all') { $ci->db->where('C.field_43', $row->field_43); }
			if($row->field_44!='all') { $ci->db->where('C.field_44', $row->field_44); }
			if($row->field_45!='all') { $ci->db->where('C.field_45', $row->field_45); }
			if($row->field_46!='all') { $ci->db->where('C.field_46', $row->field_46); }
			if($row->field_47!='all') { $ci->db->where('C.field_47', $row->field_47); }
			if($row->field_48!='all') { $ci->db->where('C.field_48', $row->field_48); }
			if($row->field_49!='all') { $ci->db->where('C.field_49', $row->field_49); }
			if($row->field_50!='all') { $ci->db->where('C.field_50', $row->field_50); }
			if($row->field_51!='all') { $ci->db->where('C.field_51', $row->field_51); }
			if($row->field_52!='all') { $ci->db->where('C.field_52', $row->field_52); }
			if($row->field_53!='all') { $ci->db->where('C.field_53', $row->field_53); }
			if($row->field_54!='all') { $ci->db->where('C.field_54', $row->field_54); }
			if($row->field_55!='all') { $ci->db->where('C.field_55', $row->field_55); }
			if($row->field_56!='all') { $ci->db->where('C.field_56', $row->field_56); }
			if($row->field_57!='all') { $ci->db->where('C.field_57', $row->field_57); }
			if($row->field_58!='all') { $ci->db->where('C.field_58', $row->field_58); }
			if($row->field_59!='all') { $ci->db->where('C.field_59', $row->field_59); }
			if($row->field_60!='all') { $ci->db->where('C.field_60', $row->field_60); }
			if($row->field_61!='all') { $ci->db->where('C.field_61', $row->field_61); }
			if($row->field_62!='all') { $ci->db->where('C.field_62', $row->field_62); }
			if($row->field_63!='all') { $ci->db->where('C.field_63', $row->field_63); }
			if($row->field_64!='all') { $ci->db->where('C.field_64', $row->field_64); }
			if($row->field_65!='all') { $ci->db->where('C.field_65', $row->field_65); }
			if($row->field_66!='all') { $ci->db->where('C.field_66', $row->field_66); }
			if($row->field_67!='all') { $ci->db->where('C.field_67', $row->field_67); }
			if($row->field_68!='all') { $ci->db->where('C.field_68', $row->field_68); }
			if($row->field_69!='all') { $ci->db->where('C.field_69', $row->field_69); }
			if($row->field_70!='all') { $ci->db->where('C.field_70', $row->field_70); }
			if($row->field_71!='all') { $ci->db->where('C.field_71', $row->field_71); }
			if($row->field_72!='all') { $ci->db->where('C.field_72', $row->field_72); }
			if($row->field_73!='all') { $ci->db->where('C.field_73', $row->field_73); }
			if($row->field_74!='all') { $ci->db->where('C.field_74', $row->field_74); }
			if($row->field_75!='all') { $ci->db->where('C.field_75', $row->field_75); }
			if($row->field_76!='all') { $ci->db->where('C.field_76', $row->field_76); }
			if($row->field_77!='all') { $ci->db->where('C.field_77', $row->field_77); }
			if($row->field_78!='all') { $ci->db->where('C.field_78', $row->field_78); }
			if($row->field_79!='all') { $ci->db->where('C.field_79', $row->field_79); }
			if($row->field_80!='all') { $ci->db->where('C.field_80', $row->field_80); }
			if($row->field_81!='all') { $ci->db->where('C.field_81', $row->field_81); }
			if($row->field_82!='all') { $ci->db->where('C.field_82', $row->field_82); }
			if($row->field_83!='all') { $ci->db->where('C.field_83', $row->field_83); }
			if($row->field_84!='all') { $ci->db->where('C.field_84', $row->field_84); }
			if($row->field_85!='all') { $ci->db->where('C.field_85', $row->field_85); }
			if($row->field_86!='all') { $ci->db->where('C.field_86', $row->field_86); }
			if($row->field_87!='all') { $ci->db->where('C.field_87', $row->field_87); }
			if($row->field_88!='all') { $ci->db->where('C.field_88', $row->field_88); }
			if($row->field_89!='all') { $ci->db->where('C.field_89', $row->field_89); }
			if($row->field_90!='all') { $ci->db->where('C.field_90', $row->field_90); }
			if($row->field_91!='all') { $ci->db->where('C.field_91', $row->field_91); }
			if($row->field_92!='all') { $ci->db->where('C.field_92', $row->field_92); }
			if($row->field_93!='all') { $ci->db->where('C.field_93', $row->field_93); }
			if($row->field_94!='all') { $ci->db->where('C.field_94', $row->field_94); }
			if($row->field_95!='all') { $ci->db->where('C.field_95', $row->field_95); }
			if($row->field_96!='all') { $ci->db->where('C.field_96', $row->field_96); }
			if($row->field_97!='all') { $ci->db->where('C.field_97', $row->field_97); }
			if($row->field_98!='all') { $ci->db->where('C.field_98', $row->field_98); }
			if($row->field_99!='all') { $ci->db->where('C.field_99', $row->field_99); }
			if($row->field_100!='all') { $ci->db->where('C.field_100', $row->field_100); }
			if($row->field_101!='all') { $ci->db->where('C.field_101', $row->field_101); }
			if($row->field_102!='all') { $ci->db->where('C.field_102', $row->field_102); }
			if($row->field_103!='all') { $ci->db->where('C.field_103', $row->field_103); }
			if($row->field_104!='all') { $ci->db->where('C.field_104', $row->field_104); }
			if($row->field_105!='all') { $ci->db->where('C.field_105', $row->field_105); }
			if($row->field_106!='all') { $ci->db->where('C.field_106', $row->field_106); }
			if($row->field_107!='all') { $ci->db->where('C.field_107', $row->field_107); }
			if($row->field_108!='all') { $ci->db->where('C.field_108', $row->field_108); }
			if($row->field_109!='all') { $ci->db->where('C.field_109', $row->field_109); }
			if($row->field_110!='all') { $ci->db->where('C.field_110', $row->field_110); }
			if($row->field_111!='all') { $ci->db->where('C.field_111', $row->field_111); }
			if($row->field_112!='all') { $ci->db->where('C.field_112', $row->field_112); }
			if($row->field_113!='all') { $ci->db->where('C.field_113', $row->field_113); }
			if($row->field_114!='all') { $ci->db->where('C.field_114', $row->field_114); }
			if($row->field_115!='all') { $ci->db->where('C.field_115', $row->field_115); }
			if($row->field_116!='all') { $ci->db->where('C.field_116', $row->field_116); }
			if($row->field_117!='all') { $ci->db->where('C.field_117', $row->field_117); }
			if($row->field_118!='all') { $ci->db->where('C.field_118', $row->field_118); }
			if($row->field_119!='all') { $ci->db->where('C.field_119', $row->field_119); }
			if($row->field_120!='all') { $ci->db->where('C.field_120', $row->field_120); }
			if($row->field_121!='all') { $ci->db->where('C.field_121', $row->field_121); }
			if($row->field_122!='all') { $ci->db->where('C.field_122', $row->field_122); }
			if($row->field_123!='all') { $ci->db->where('C.field_123', $row->field_123); }
			if($row->field_124!='all') { $ci->db->where('C.field_124', $row->field_124); }
			if($row->field_125!='all') { $ci->db->where('C.field_125', $row->field_125); }
			if($row->field_126!='all') { $ci->db->where('C.field_126', $row->field_126); }
			if($row->field_127!='all') { $ci->db->where('C.field_127', $row->field_127); }
			if($row->field_128!='all') { $ci->db->where('C.field_128', $row->field_128); }
			if($row->field_129!='all') { $ci->db->where('C.field_129', $row->field_129); }
			if($row->field_130!='all') { $ci->db->where('C.field_130', $row->field_130); }
			if($row->field_131!='all') { $ci->db->where('C.field_131', $row->field_131); }
			if($row->field_132!='all') { $ci->db->where('C.field_132', $row->field_132); }
			if($row->field_133!='all') { $ci->db->where('C.field_133', $row->field_133); }
			if($row->field_134!='all') { $ci->db->where('C.field_134', $row->field_134); }
			if($row->field_135!='all') { $ci->db->where('C.field_135', $row->field_135); }
			if($row->field_136!='all') { $ci->db->where('C.field_136', $row->field_136); }
			if($row->field_137!='all') { $ci->db->where('C.field_137', $row->field_137); }
			if($row->field_138!='all') { $ci->db->where('C.field_138', $row->field_138); }
			if($row->field_139!='all') { $ci->db->where('C.field_139', $row->field_139); }
			if($row->field_140!='all') { $ci->db->where('C.field_140', $row->field_140); }
			if($row->field_141!='all') { $ci->db->where('C.field_141', $row->field_141); }
			if($row->field_142!='all') { $ci->db->where('C.field_142', $row->field_142); }
			if($row->field_143!='all') { $ci->db->where('C.field_143', $row->field_143); }
			if($row->field_144!='all') { $ci->db->where('C.field_144', $row->field_144); }
			if($row->field_145!='all') { $ci->db->where('C.field_145', $row->field_145); }
			if($row->field_146!='all') { $ci->db->where('C.field_146', $row->field_146); }
			if($row->field_147!='all') { $ci->db->where('C.field_147', $row->field_147); }
			if($row->field_148!='all') { $ci->db->where('C.field_148', $row->field_148); }
			if($row->field_149!='all') { $ci->db->where('C.field_149', $row->field_149); }
			if($row->field_150!='all') { $ci->db->where('C.field_150', $row->field_150); }
			if($row->field_151!='all') { $ci->db->where('C.field_151', $row->field_151); }
			if($row->field_152!='all') { $ci->db->where('C.field_152', $row->field_152); }
			if($row->field_153!='all') { $ci->db->where('C.field_153', $row->field_153); }
			if($row->field_154!='all') { $ci->db->where('C.field_154', $row->field_154); }
			if($row->field_155!='all') { $ci->db->where('C.field_155', $row->field_155); }
			if($row->field_156!='all') { $ci->db->where('C.field_156', $row->field_156); }
			if($row->field_157!='all') { $ci->db->where('C.field_157', $row->field_157); }
			if($row->field_158!='all') { $ci->db->where('C.field_158', $row->field_158); }
			if($row->field_159!='all') { $ci->db->where('C.field_159', $row->field_159); }
			if($row->field_160!='all') { $ci->db->where('C.field_160', $row->field_160); }
			if($row->field_161!='all') { $ci->db->where('C.field_161', $row->field_161); }
			if($row->field_162!='all') { $ci->db->where('C.field_162', $row->field_162); }
			if($row->field_163!='all') { $ci->db->where('C.field_163', $row->field_163); }
			if($row->field_164!='all') { $ci->db->where('C.field_164', $row->field_164); }
			if($row->field_165!='all') { $ci->db->where('C.field_165', $row->field_165); }
			if($row->field_166!='all') { $ci->db->where('C.field_166', $row->field_166); }
			if($row->field_167!='all') { $ci->db->where('C.field_167', $row->field_167); }
			if($row->field_168!='all') { $ci->db->where('C.field_168', $row->field_168); }
			if($row->field_169!='all') { $ci->db->where('C.field_169', $row->field_169); }
			if($row->field_170!='all') { $ci->db->where('C.field_170', $row->field_170); }
			if($row->field_171!='all') { $ci->db->where('C.field_171', $row->field_171); }
			if($row->field_172!='all') { $ci->db->where('C.field_172', $row->field_172); }
			if($row->field_173!='all') { $ci->db->where('C.field_173', $row->field_173); }
			if($row->field_174!='all') { $ci->db->where('C.field_174', $row->field_174); }
			if($row->field_175!='all') { $ci->db->where('C.field_175', $row->field_175); }
			if($row->field_176!='all') { $ci->db->where('C.field_176', $row->field_176); }
			if($row->field_177!='all') { $ci->db->where('C.field_177', $row->field_177); }
			if($row->field_178!='all') { $ci->db->where('C.field_178', $row->field_178); }
			if($row->field_179!='all') { $ci->db->where('C.field_179', $row->field_179); }
			if($row->field_180!='all') { $ci->db->where('C.field_180', $row->field_180); }
			if($row->field_181!='all') { $ci->db->where('C.field_181', $row->field_181); }
			if($row->field_182!='all') { $ci->db->where('C.field_182', $row->field_182); }
			if($row->field_183!='all') { $ci->db->where('C.field_183', $row->field_183); }
			if($row->field_184!='all') { $ci->db->where('C.field_184', $row->field_184); }
			if($row->field_185!='all') { $ci->db->where('C.field_185', $row->field_185); }
			if($row->field_186!='all') { $ci->db->where('C.field_186', $row->field_186); }
			if($row->field_187!='all') { $ci->db->where('C.field_187', $row->field_187); }
			if($row->field_188!='all') { $ci->db->where('C.field_188', $row->field_188); }
			if($row->field_189!='all') { $ci->db->where('C.field_189', $row->field_189); }
			if($row->field_190!='all') { $ci->db->where('C.field_190', $row->field_190); }
			if($row->field_191!='all') { $ci->db->where('C.field_191', $row->field_191); }
			if($row->field_192!='all') { $ci->db->where('C.field_192', $row->field_192); }
			if($row->field_193!='all') { $ci->db->where('C.field_193', $row->field_193); }
			if($row->field_194!='all') { $ci->db->where('C.field_194', $row->field_194); }
			if($row->field_195!='all') { $ci->db->where('C.field_195', $row->field_195); }
			if($row->field_196!='all') { $ci->db->where('C.field_196', $row->field_196); }
			if($row->field_197!='all') { $ci->db->where('C.field_197', $row->field_197); }
			if($row->field_198!='all') { $ci->db->where('C.field_198', $row->field_198); }
			if($row->field_199!='all') { $ci->db->where('C.field_199', $row->field_199); }
			if($row->field_200!='all') { $ci->db->where('C.field_200', $row->field_200); }
			if($row->field_201!='all') { $ci->db->where('C.field_201', $row->field_201); }

		
		
		$query = $ci->db->get();//echo $ci->db->last_query();
		return $query->num_rows();
}


   function consumer_selection_criteria_values($criteria_id){	   		
		$ci = & get_instance();
		$ci->db->select('*');
		$ci->db->from('consumer_selection_criteria');
		$ci->db->where('criteria_id', $criteria_id);
		//$ci->db->limit(1);// only apply if you have more than same id in your table othre wise comment this line
		$query = $ci->db->get();
		return $query->row();
}



//Sanjay
   function AllSelectedConsumersByACustomer($customer_id, $consumer_gender, $csc_consumer_city, $csc_consumer_pin, $csc_consumer_min_dob, $csc_consumer_max_dob){
	   
		$ci = & get_instance();
		$ci->db->select('C.id');	
		$ci->db->from('consumers C');		
		$ci->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$ci->db->where('CCL.customer_id', $customer_id);
		if(($consumer_gender=='male')||($consumer_gender=='female')) {
		$ci->db->where('C.gender', $consumer_gender);
			}			
		if(!empty($csc_consumer_city)){ 			
		$ci->db->where('C.city', $csc_consumer_city);
			}
			
		if(!empty($csc_consumer_min_dob)){ 			
		//$ci->db->where('C.dob <', $csc_consumer_min_dob);
		$ci->db->where('C.dob  <=', $csc_consumer_min_dob);
			}	
		
		if(!empty($csc_consumer_max_dob)){ 			
		//$ci->db->where('C.dob >', $csc_consumer_max_dob);
		$ci->db->where('C.dob >=', $csc_consumer_max_dob);
			}
			
		//$dobthenMin = date('Y-m-d', strtotime("-".$csc_consumer_min_dob." years"));
		//$dobthenMax = date('Y-m-d', strtotime("-".$csc_consumer_max_dob." years"));
		//$ci->db->where('C.dob BETWEEN "'. date('Y-m-d', strtotime($csc_consumer_min_dob)). '" and "'. date('Y-m-d', strtotime($csc_consumer_max_dob)).'"');	
			//$ci->db->where("C.dob BETWEEN $csc_consumer_min_dob AND $csc_consumer_max_dob");	
			/*
			if(!empty($csc_consumer_min_dob)){
				$dobthenMin = date('Y-m-d', strtotime("-".$csc_consumer_min_dob." years"));
		$ci->db->where('C.dob  >=', $dobthenMin);
		//$ci->db->where(' C.dob >= date("'.$dobthenMin.'")');
			}	
		
		if(!empty($csc_consumer_max_dob)){ 	
		$dobthenMax = date('Y-m-d', strtotime("-".$csc_consumer_max_dob." years"));		
		$ci->db->where('C.dob <=', $dobthenMax);
		//$ci->db->where(' C.dob <= date("'.$dobthenMax.'")');
			}
			
			/*
		if(!empty($csc_consumer_min_dob)){
				$dobthenMin = date('Y-m-d', strtotime("-".$csc_consumer_min_dob." years"));
		$ci->db->where('C.dob  >=', $dobthenMin);
			}	
		
		if(!empty($csc_consumer_max_dob)){ 	
		$dobthenMax = date('Y-m-d', strtotime("-".$csc_consumer_max_dob." years"));		
		$ci->db->where('C.dob <=', $dobthenMax);
			}	
			
			
		if($csc_consumer_pin!=0){ 			
		$ci->db->where('C.pin_code', $csc_consumer_pin);
			}	
			
		if(!empty($csc_consumer_min_dob)){ 			
		$ci->db->where('C.dob <', $csc_consumer_min_dob);
			}	
		
		if(!empty($csc_consumer_max_dob)){ 			
		$ci->db->where('C.dob >', $csc_consumer_max_dob);
			}
		*/
		$query = $ci->db->get();//echo $ci->db->last_query();
		//return $query->num_rows();
		//return $query->row();
		$result = $query->result();
		return $result;


}


	function total_approved_points2($user_id) {
		$ci = & get_instance();
				$ci->db->select_sum('purchasing_points');
				$ci->db->from('purchased_loyalty_points');
				$ci->db->where(array('customer_id'=> $user_id, 'approval_status'=> 1));
				$query=$ci->db->get();		
			return $query->row()->purchasing_points;
    }
	
	
	function get_total_consumed_points($user_id) {
		$ci = & get_instance();
				$ci->db->select_sum('points');
				$ci->db->from('consumer_passbook');
				$ci->db->where(array('customer_id'=> $user_id, 'transaction_lr_type'=> "Loyalty"));
				$query=$ci->db->get();		
			return $query->row()->points;
    }

	function get_total_consumer_loyalty_points_customerwise($consumer_id, $customer_id) {
		$ci = & get_instance();	
		$ci->db->select_sum('points');
		$ci->db->from('consumer_passbook');
		$ci->db->where(array('consumer_id'=> $consumer_id, 'customer_id'=> $customer_id));
		$query=$ci->db->get();
		return $query->row()->points;
	} 
	
	function get_total_consumer_loyalty_points_all($consumer_id) {
		$ci = & get_instance();	
		$ci->db->select_sum('points');
		$ci->db->from('consumer_passbook');
		$ci->db->where('consumer_id', $consumer_id);
		$query=$ci->db->get();
		return $query->row()->points;
	}
	
	
 
 function get_all_consumer_profile_attribute_types(){	
		$res 		= '';
		$ci 		= & get_instance();
		$ci->db->select('cpatm_id, cpatm_name, cpatm_name_slug, profile_bucket');
		$ci->db->from('consumer_profile_attribute_type_master');	
		//$ci->db->where(array('status'=>'1','id!='=>'2'));
		//$ci->db->where('status',1);
		//$ci->db->where(array('status'=>'1','spideyImage!='=>''));	
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 	//	$res = $res[0]['categoryName'];
	}		
 	return $res;
}
/*
 function Check_Selection_Criteria_Exists($key){	
		$res 		= '';
		$ci 		= & get_instance();
		$ci->db->select('cpatm_name_slug');
		$ci->db->from('consumer_profile_attribute_type_master');	
		//$ci->db->where(array('status'=>'1','id!='=>'2'));
		$ci->db->where('cpatm_name_slug',$key);
		//$ci->db->where(array('status'=>'1','spideyImage!='=>''));	
	$query = $ci->db->get();  echo $ci->db->last_query(); 
	if ($query->num_rows() > 0) {		 
			return true;		 
				}		
		return false;
	}
*/

function Check_Selection_Criteria_Exists($key)
{		$res 		= '';
		$ci 		= & get_instance();
    $ci->db->where('cpm_type_slug',$key);
    $query = $ci->db->get('consumer_profile_master');
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}


function last_printed_batch_id($customer_id)
	{ 
	$ci = & get_instance();   
	$user_id 	= $ci->session->userdata('user_id');	
	/*
	$row = $ci->db->select("*")->limit(1)->order_by('id',"DESC")->get("order_print_listing")->where('customer_id', $user_id)->row();
	return $row->print_batch_id; //it will provide latest or last record id.
	*/
	
	$ci->db->select('*');
    $ci->db->where('customer_id', $customer_id);
    $ci->db->order_by('id',"DESC");
	$ci->db->limit(1);
    $query = $ci->db->get('order_print_listing');
    $row = $query->row();
	return $row->print_batch_id;
	} 

	/*
function getCustomerIDByOrderId($OrderId){
	$res = 0;
	$ci = & get_instance();
	$ci->db->select('user_name');
	$ci->db->from('consumers');
	$ci->db->where(array('id'=>$OrderId));
	$query = $ci->db->get();

	if ($query->num_rows() > 0) {
	$res = $query->result_array();

		$res = ucfirst($res[0]['user_name']);

 	}
	return $res;
}
*/
	
?>