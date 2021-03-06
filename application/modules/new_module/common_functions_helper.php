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



    // transliterate

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

		// Latin

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

	

	//print_r($str);

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

/*function get_city_name($cityId)

 {

		$res = 0;

		$ci = & get_instance();

		$ci->db->select('city_name');

		$ci->db->from('city');

		$ci->db->where(array('city_id'=>$cityId));

		$query = $ci->db->get();

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

		}

		return $res; 

}

*/





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



 

function getMenuList($id='',$option=''){

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
	//$ci->db->where_in(array('id'=>'1,3,27'));

	

	if(empty($id)){

		$ci->db->where('parent',0);

		//$ci->db->where(array('parent'=>0));

	}else{

		$ci->db->where('parent',$id);

	}

	if(!empty($option)){

		$ci->db->where_in('id',$visible_menu_list);

	}

	 

	//$ci->db->where(array('parent'=>$id));

	

	$ci->db->order_by("type", "ASC");

	$query = $ci->db->get();

	// echo $ci->db->last_query();exit;

	 if ($query->num_rows() > 0) {

		$res = $query->result_array();

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

 

 function getMenuIDByGroup(){

	

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

			$file =  'uploads/temp/'.$fileName;

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
						&nbsp;<div style="float:right;"><a title="Edit Child" href="'.base_url().'myspidey_user_group_permissions/edit_child_menu/'.$chids2['category_Id'].'"><i class="ace-icon fa fa-pencil"></i></a> </div>&nbsp;&nbsp;<div style="float:right;">&nbsp;&nbsp;<a title="Delete Child" onclick="return deleteAlert('.$chids2['category_Id'].','.$chids2['category_id'].');" href="javascript:void(0);"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>&nbsp;&nbsp; </div>'.'</div>';
					 
					 
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


function getAllCategory(){
 	$res 		= '';
 	$ci 		= & get_instance();
	$ci->db->select('category_Id, categoryName');
	$ci->db->from('categories');
	//$ci->db->where('category_Id',$id);
	$query = $ci->db->get();// echo $ci->db->last_query();exit;
	if ($query->num_rows() > 0) {
 		$res = $query->result_array();
 	//	$res = $res[0]['categoryName'];

	}		
 	return $res;

}

?>