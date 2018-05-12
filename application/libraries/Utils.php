<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author subhash
 */
class Utils {    
    private static $ci= null;
    
    public function __construct() {
        self::$ci = & get_instance();
    }
    /**
     * getVar method to return the value from array
     * 
     * @param string $var key of array
     * @param array $array array of keys
     * 
     * @return string value of key
     */
    public static function getVar($var,$array){
        if(is_array($array)){
            if(isset($array[$var])){
                return $array[$var];
            }else{
                return "";
            }
        }
    }

    public static function response($message, $code = 200) {
        self::$ci->output->set_content_type('application/json')
                ->set_status_header($code)
                ->set_output(json_encode($message))
                ->_display();
        exit(0);
    }
    
    public static function randomString(){
        //Generate a random string.
        $token = openssl_random_pseudo_bytes(16);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        return $token;
    }
    
    public static function randomNumber($count=5){
        $no = null;
        for($i = 0; $i <= $count; $i++) {
            $no .= mt_rand(0,9); 
        }
        return $no;
    }

    public static function validDate($date, $format = 'dmY') {
        $dateInFormat = DateTime::createFromFormat($format, $date);
        return ($dateInFormat && $dateInFormat->format('Y-m-d') === $date);
    }

    public static function getRawPostData() {
        include_once 'stream.php';
        $input = file_get_contents('php://input');
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
        $inputArray = [];
        
        //mb_parse_str($input,$inputArray);
//        parse_str($input, $inputArray);
//        is_array($inputArray) OR $inputArray = array();
//        echo count($inputArray);
	echo "<pre>";print_r($matches);die;
        
    }
    public static function errors($errorStr){
        $string = strip_tags($errorStr);
        return explode(PHP_EOL, trim($string, PHP_EOL));
    }
    
    public static function encryption(){
        
    }
    public static function decryption(){
        
    }
    
    public static function setFileUrl($files){
       $files = explode(',',$files);
       $fileWithPath = [];
       for($i = 0;$i< count($files); $i++){
           $fileUrl = site_url('uploads/temp/'.$files[$i]);
           array_push($fileWithPath, $fileUrl);
       }
       return $fileWithPath;
    }
    
    public static function sendSMS_gateway($mobile,$message){
        $gateway = self::$ci->config->item('sms');        
        $query = [            
            "APIKey"=>$gateway['apikey'],
            "senderid"=>$gateway['senderid'],
            "channel"=>1,
            "DCS"=>"0",
            "flashsms"=>'0',
            "number" => $mobile,
            "text"=>$message,
            "route"=>16            
        ];
        $httpResponse = file_get_contents($gateway['url'].'?'. http_build_query($query));
        $response = json_decode($httpResponse);
        if($response->ErrorCode == 000){
          return true;
        }else{
            return false;
        }
    }
    public static function sendSMS($mobile, $message) {
        $gateway = self::$ci->config->item('sms');        
        $query = [
            'username' => $gateway['username'],
            'password' => $gateway['password'],
            'from' => $gateway['from'],
            'to' => $mobile,
            'text' => $message,
        ];
        $url=$gateway['url'].'?'. http_build_query($query);
        $httpResponse = file_get_contents($url);
        return $httpResponse;
    }

    public static function selectOptions($name=null,$attributes) {
        $optionVal = '';
        if (!empty($attributes['empty'])) {
            if (is_string($attributes['empty'])) {
                $optionVal .= '<option value="">' . $attributes['empty'] . '</option>';
            } else {
                $optionVal .= '<option value="">Select One</option>';
}
        }
        $values = [];
        if(!empty($attributes['value'])){
            if(!is_array($attributes['value'])){
                $values[] = $attributes['value'];
            }else{
                $values = $attributes['value'];            
            }
        }
        if (!empty($attributes['options'])) {
            foreach ($attributes['options'] as $key => $text) {
                $selected = null;
                if (!empty($attributes['indextext'])) {
                    if(in_array($text, $values)){
                        $selected = 'selected="selected"';
                    }
                    $optionVal .= '<option value="' . $text . '" '.$selected.'>' . $text . '</option>';
                } else {
                    if(in_array($key, $values)){
                        $selected = 'selected="selected"';
                    }
                    $optionVal .= '<option value="' . $key . '" '.$selected.'>' . $text . '</option>';
                }
            }
        }
        return $optionVal;
    }
    public static function elemValue($key,$data){
        if (self::$ci->input->server('REQUEST_METHOD') == 'POST'){
            $input = self::$ci->input->post();
            if(array_key_exists($key,$input)){
                $value =  $input[$key];
            }else{
                $value = null;
            }
        }
        if(is_array($data) || is_object($data)){
            if(is_array($data) && array_key_exists($key,$data)){
                $value = $data[$key];
            }elseif(is_object($data) && property_exists($data, $key)){
                $value = $data->{$key};
            }else{
                $segments = explode('.', $key);
                foreach ($segments as $segment) {
                    if (is_array($data) && array_key_exists($segment, $data)) {
                        $value = $data = $data[$segment];
                    } else if (is_object($data) && property_exists($data, $segment)) {
                        $value = $data = $data->{$segment};
                    } else {
                        $value = null;
                        break;
                    }
                }
            }
        }else{
            $value =  $data;
        }
        
        return $value;
    }
    
    public static function filterItems($data, $key, $default = null) {
        $value = $default;
        if (is_array($data) && array_key_exists($key, $data)) {
            $value = $data[$key];
        } else if (is_object($data) && property_exists($data, $key)) {
            $value = $data->$key;
        } else {
            $segments = explode('.', $key);
            foreach ($segments as $segment) {
                if (is_array($data) && array_key_exists($segment, $data)) {
                    $value = $data = $data[$segment];
                } else if (is_object($data) && property_exists($data, $segment)) {
                    $value = $data = $data->$segment;
                } else {
                    $value = $default;
                    break;
                }
            }
        }
        return $value;
    }
    public static function pagination($url,$totalRecords,$limit = null){
        if(is_null($limit)){
            $limit = self::$ci->config->item('pageLimit');
        }
        if(empty($url)){
            $url = self::$ci->uri->uri_string();
        }
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $totalRecords;
        $config['per_page'] = $limit;
        $config["uri_segment"] = 3;             
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';	
        $config["first_link"] = "&laquo;";
        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";
        $config["last_link"] = "&raquo;";
        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '<li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '<li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['reuse_query_string'] = TRUE;
        self::$ci->pagination->initialize($config);
        $pagelink = self::$ci->pagination->create_links();
        if(empty($pagelink)){
            return '';
        }
        $curpage = self::$ci->pagination->cur_page;
        $startPage = ($curpage - 1) * $limit + 1;
        if ($startPage == 0){
            $startPage= 1;
        }
        $endPage = $startPage+$limit-1;
        if ($endPage < $limit){
            $endPage = $limit;
        }elseif($endPage > $totalRecords){
            $endPage = $totalRecords;
        }
        return '<div class="col-sm-4"><span class="counter">Showing '.$startPage.' to '.$endPage.' of '.$totalRecords.' entries</span></div><div class="col-sm-8">'.$pagelink.'</div>';
    }
    
    public static function countAll($table,$conditions = null) {
        self::$ci->db->select('COUNT(*) AS `numrows`');
        if(!empty($conditions)){
            self::$ci->db->where($conditions);
        }
        $query = self::$ci->db->get($table);
        return $query->row()->numrows;
    }
    
    public static function currentUrl() {
        $url = self::$ci->uri->uri_string();
        $param = $_SERVER['QUERY_STRING'];
        return !empty($param) ? $url . '?' . $param : $url;
    }
    
    public function debug(){
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }

}
