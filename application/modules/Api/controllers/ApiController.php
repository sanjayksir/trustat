<?php
//https://github.com/amithorakeri/CodeigniterRESTAPI/blob/master/application/config/routes.php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api
 *
 * @author Sanjay
 */
class ApiController extends MX_Controller {
    public $request = null;
    public $auth = null;

    public function __construct() {
        parent::__construct();
        $this->request = new stdClass();
        $this->request->ssl = is_https();
        $this->request->method = $this->input->method();        
        $this->request->content_type = $this->input->server('CONTENT_TYPE');
        $this->request->token = $this->input->server('HTTP_TOKEN');
    }
    /**
     * getInput method to get any type of request and filter it
     */
    public function getInput(){
        $contentType = $this->request->content_type;
        $input = [];
        if(strpos($contentType, 'application/json') !== false){
            $input  = json_decode($this->input->raw_input_stream, true);            
        }elseif(strpos($contentType, 'multipart/form-data') !== false){
            $input = $this->input->post();
            if(!empty($_FILES)){
                $input += $_FILES;
            }
            
        }else{
            $input = $this->input->get();
        }
        return $input;
    }
    /**
     * response to make response body in json and sent back to the client
     */
    public function response($message, $code = 200) {        
        $this->output
                ->set_status_header($code)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($message))
                ->_display();
        exit();
    }
    /* consumer authentication */
    public function auth($key=null){
        $this->load->model('ConsumerModel');        
        $user = $this->ConsumerModel->verifyToken($this->request->token);
        if($key != null && array_key_exists($key, $user)){
            return $user[$key];
        }else{
            return $user;
        }        
    }
    /* customer authentication */
    public function customerAuth($key=null){
        $this->load->model('CustomerModel');
        $plant = $this->input->server('HTTP_PLANT');
        if(empty($plant)){
            $this->response(['status'=>false,'message'=>'Parent is required in header.']);
        }
        $user = $this->CustomerModel->verifyToken($this->request->token,$plant);
        if($user == 'plant'){
            $this->response(['status'=>false,'message'=>'User is not assigned.']);
        }
        if($key != null && array_key_exists($key, $user)){
            return $user[$key];
        }else{
            return $user;
        }        
    }
    
    /**
     * Retrieve the validation errors
     *
     * @access public
     * @return array
     */
    public function errors(){
        $string = strip_tags($this->form_validation->error_string());
        return explode(PHP_EOL, trim($string, PHP_EOL));
    }
}
