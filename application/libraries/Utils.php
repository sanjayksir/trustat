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
           $fileUrl = site_url('uploads/tmp/'.$files[$i]);
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

}
