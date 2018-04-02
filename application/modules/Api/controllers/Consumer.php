<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'ApiController.php';

class Consumer extends ApiController {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ConsumerModel');
    }
    
    /**
     * register to add new user api
     * @return registered user details
     */
    
    public function register(){
        //$this->db->query('TRUNCATE TABLE consumers');
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }

        $errors = $this->ConsumerModel->signupValidate($data);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $data['ip'] =  $this->input->ip_address();        
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['modified_at'] = date("Y-m-d H:i:s");
        $data['verification_code'] = Utils::randomNumber(5);
        $data['password'] =  md5($data['verification_code']);
        if($this->db->insert('consumers', $data)){
            $data['password'] = $data['mobile_no'];
            $this->signupMail($data);
            $smstext = 'Your OTP is '.$data['verification_code'].', Your OTP is your login password as well as mobile verification password to complete the signup proccess';
            Utils::sendSMS($data['mobile_no'],$smstext);
            Utils::response(['status'=>true,'message'=>'Your account has been registered.','data'=>$data],200);
        }else{
            Utils::response(['status'=>false,'message'=>'Registration has been failed.'],200);
        }
        
    }
    
    /**
     * viewProfile to view the profile details
     * 
     * @param null get id from header token
     * @return json json object with user details
     */
    
    public function viewProfile(){
        if(empty($this->auth())){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        Utils::response(['status'=>true,'message'=>'Your account details.','data'=>$this->auth()]);
    }
    
    /**
     * editProfile to edit profile, Login is required.
     * @param json $post like  user_name, dob,gender
     * @return json api response
     */
    
    public function editProfile(){
        $user = $this->auth();
        if(empty($user)){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        
        $input = $this->getInput();
        if(($this->input->method() != 'post') || empty($input)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'user_name','label'=>'User Name','rules' => 'required|min_length[8]' ],
            ['field' =>'dob','label'=>'Date of birth','rules' => ['required',['dob_check',[$this->ConsumerModel,'dob_check']]] ],
            ['field' =>'gender','label'=>'Gender','rules' => 'trim|required|in_list[male,female]' ],
        ];
        $errors = $this->ConsumerModel->validate($input,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $this->db->set('modified_at', date("Y-m-d H:i:s"));
        $this->db->set('user_name',Utils::getVar('user_name', $input));
        $this->db->set('dob', Utils::getVar('dob', $input));
        $this->db->set('gender', Utils::getVar('gender', $input));
        $this->db->where('id',$user['id']);
        if($this->db->update($this->ConsumerModel->table)){
            Utils::response(['status'=>true,'message'=>'Your account has been updated.','data'=>$input]);
        }else{
            Utils::response(['status'=>false,'message'=>'System failed to update.'],200);
        }
    }
    
    /**
     * changePassword to change password
     * 
     * @param string $old_password old password
     * @param string $password new password
     * @param string $password_confirmation repeat the original password
     * @return json  json object of api response.
     */
    
    public function changePassword(){
        $user = $this->auth();
        if(empty($user)){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }
        
        $input = $this->getInput();
        if(($this->input->method() != 'post') || empty($input)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'old_password','label'=>'Previous Password','rules' => ['required'] ],
            ['field' =>'new_password','label'=>'New Password','rules' => 'required|min_length[8]'],
            ['field' =>'confirm_password','label'=>'Confirm Password','rules'=>'required|matches[new_password]']
        ];
        $errors = $this->ConsumerModel->validate($input,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        if(md5($input['old_password']) != $user['password']){
            $this->response(['status'=>false,'message'=>'Previous password not matched.']);
        }
        if ($this->db->update($this->ConsumerModel->table,['password'=>md5($input['new_password'])],['id'=>$user['id']])) {
                $this->response(['status'=>true,'message'=>'New password has been changed successfully.']);
            }else{
                $this->response(['status'=>false,'message'=>'Failed to save new password.']);
        }
    }
    
    /**
     * forgotPassword method to reset password.
     * 
     * @param String $mobile_no|$email either mobile no or email
     * @return Json generated random password
     */
    public function forgotPassword($username=null){
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $username = urldecode($username);
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $validate = [['field' =>'username','label'=>'Email','rules' => 'trim|required|valid_email']];
            $condition = ['email'=>$username];
        }else{
            $validate = [['field' =>'username','label'=>'Mobile No','rules' => 'trim|required|integer|exact_length[10]']];
            $condition = ['mobile_no'=>$username];
        }
        $errors = $this->ConsumerModel->validate(['username'=>$username],$validate);
        if(is_array($errors)){
            $this->response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $user = $this->ConsumerModel->findBy($condition);
        if(!$user){
            Utils::response(['status'=>false,'message'=>'Record not found.']);
        }
        $password = Utils::randomNumber(8);
        $user->password = md5($password);
        $smstext = 'System generated password is '.$password.' Please change it after doing logging.';
        if(Utils::sendSMS($user->mobile_no,$smstext)){
            if ($this->db->update($this->ConsumerModel->table,['password'=>$user->password],['id'=>$user->id])) {
                Utils::response(['status'=>true,'message'=>'A new password has been sent to your registered mobile no.']);
            }else{
                Utils::response(['status'=>false,'message'=>'There is system error to reset password.']);
            }
        }else{
            Utils::response(['status'=>false,'message'=>'Failed to send message, Try after some time.']);
        }
    }
    
    public function resendOtp($mobile=null){
        if(($this->input->method() != 'get')){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'mobile_no','label'=>'Mobile No','rules' => 'trim|required|integer|exact_length[10]']            
        ];
        $errors = $this->ConsumerModel->validate(['mobile_no'=>$mobile],$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $data = $this->ConsumerModel->findBy(['mobile_no'=>$mobile]);
        if(!$data){
            Utils::response(['status'=>false,'message'=>'Record not found from given mobile no.']);
        }
        $data->verification_code = Utils::randomNumber(5);
        $smstext = 'Your OTP to complete the signup proccess is '.$data->verification_code.'. OTP is valid for 15 mins. Please do not share this to anyone.';
        if(Utils::sendSMS($data->mobile_no,$smstext)){
            if ($this->db->update($this->ConsumerModel->table,$data,['mobile_no'=>$data->mobile_no])) {
                Utils::response(['status'=>true,'message'=>'OTP has been sent successfully.']);
            }else{
                Utils::response(['status'=>false,'message'=>'Record not found from given mobile no.']);
            }
        }else{
            Utils::response(['status'=>false,'message'=>'Failed to send message, Try after some time.']);
        }
    }
    
    public function verifyOtp(){
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'mobile_no','label'=>'Mobile No','rules' => 'trim|required|integer|exact_length[10]' ],
            ['field' =>'otp','label'=>'One time password','rules' => 'required|min_length[6]' ],
        ];
        $errors = $this->ConsumerModel->validate($data,$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $dbdata = $this->ConsumerModel->findBy(['mobile_no'=>$data['mobile_no']]);
        if(!$dbdata){
            Utils::response(['status'=>false,'message'=>'Record not found from given mobile no.']);
        }
        if($dbdata->verification_code != $data['otp']){
            Utils::response(['status'=>false,'message'=>'OTP has not been matched.']);
        }
        $dbdata->verification_code = null;
        $dbdata->is_verified = ($dbdata->is_verified == 3)?1:2;
        if ($this->db->update($this->ConsumerModel->table,$dbdata,['mobile_no'=>$dbdata->mobile_no])) {
                Utils::response(['status'=>true,'message'=>'Your account has been successfully verified.']);
            }
        
        
    }
   
    public function signupMail($data){
        $this->load->library('email');
        $this->email->initialize($this->config->item('smtp'));
        $this->email->set_newline("\r\n");
        $this->email->from($data['email'], $data['user_name']);
        $this->email->reply_to('no-reply@innovigents.com', 'Team');
        $this->email->to($this->config->item('admin_email'));
        $this->email->subject('Signup with with '.$this->config->item("site_name"));        
        $body = $this->load->view('signup_mail.php',$data,TRUE);
        $this->email->message($body); 
        if($this->email->send()){
            return true;
        }else{
            return false;
        }
        //echo $this->email->print_debugger();die;
    }
    
    public function resendMail(){
        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'email','label'=>'Email','rules' => 'trim|required|valid_email']            
        ];
        $errors = $this->ConsumerModel->validate(['email'=>$data['email']],$validate);
        if(is_array($errors)){
            Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }
        $user = $this->ConsumerModel->findBy(['email'=>$data['email']]);
        if(!$user){
            Utils::response(['status'=>false,'message'=>'Record not found from given email.']);
        }
        
        if($this->signupMail((array)$user)){            
            Utils::response(['status'=>true,'message'=>'Mail has been sent successfully.']);
        }else{
            Utils::response(['status'=>false,'message'=>'Failed to send message, Try after some time.']);
        }
    }
    public function mailVerification($token = null,$email = null){
        if (!$token || !$email) {
            show_error('Invalid url.');
        }
        $user = $this->ConsumerModel->findBy(['email'=> urldecode($email)]);
        if (empty($user)) {
            show_error('Account not found, Please read email carefully and try again.');
        }
        
        if ($user->is_verified > 0) {
            $this->session->set_flashdata('flash','Your Account has been already activated. You can now log in using the username and password you chose during the registration');
            //return $this->redirect('/');
        } else {
            if ($token != md5($user->email)) {
                show_error('Invalid token. Please read email carefully and try again.');
            }
            $user->is_verified = ($user->is_verified == 2)?1:3;
            if ($this->db->update($this->ConsumerModel->table,$user,['email'=>$user->email])) {
                $this->session->set_flashdata('flash','Your Account has been successfully activated. You can now log in using the username and password you chose during the registration.');
            } else {
                $this->session->set_flashdata('flash', 'This link has no longer existing.');
            }
        }
        $this->load->view('mail_verification');
    }
    

    public function login() {
        $data = $this->getInput();
        if(($this->request->method != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
            ['field' =>'password','label'=>'Password','rules' => 'trim|required'],
            ['field' =>'device_id','label'=>'Device Id','rules' => 'trim|required']
        ];
        if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            array_push($validate, ['field' =>'username','label'=>'Email','rules' => 'trim|required|valid_email']);
        }else{
            array_push($validate,['field' =>'username','label'=>'Mobile No','rules' => 'trim|required|integer|exact_length[10]' ]);
        }
        $errors = $this->ConsumerModel->validate($data,$validate);
        if(is_array($errors)){
            $this->response(['status'=>false,'message'=>'Validation errors.','errors'=>$errors]);
        }        
        $user = $this->ConsumerModel->authIdentify($data);
        if($user == 'email'){
            $this->response(['status'=>false,'message'=>'Email has not been verified.']);
        }
        if($user == 'mobile'){
            $this->response(['status'=>false,'message'=>'Mobile No has not been verified.']);
        }
        if(!is_object($user)){
            $this->response(['status'=>false,'message'=>'Invalid Credentials.']);
        }else{
            $this->response(['status'=>true,'message'=>'Login done successfully.','data'=>$user]);
        }
        
    }

    public function logout() {
        if($this->request->method != 'get'){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        if(empty($this->request->token)){
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $this->load->model('UserLogModel');
        $this->db->where('token',$this->request->token)->delete($this->UserLogModel->table);
        $this->response(['status'=>true,'message'=>'Logout successfully.']);
    }

}
