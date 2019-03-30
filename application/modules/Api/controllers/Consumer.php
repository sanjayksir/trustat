<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require 'ApiController.php';

class Consumer extends ApiController {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ConsumerModel');
        $this->load->model('Productmodel');
    }

    /**
     * register to add new user api
     * @return registered user details
     */
     
     
     
    public function register() {
        //$this->db->query('TRUNCATE TABLE consumers');
        $data = $this->getInput();
        if (($this->input->method() != 'post') || empty($data)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		
			
			
			
        // if number already exists 
        $checkmobileno = $this->getInput('mobile_no');
        $checkmobileno2 = $checkmobileno['mobile_no'];



        $query = $this->db->get_where('consumers', array('mobile_no' => $checkmobileno2));
        if ($query->num_rows() > 0) {
            $errors = $this->ConsumerModel->signupValidateNew($data);
            if (is_array($errors)) {
                Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
            }
            $this->db->set('modified_at', date("Y-m-d H:i:s"));
            //$this->db->set('user_name',Utils::getVar('user_name', $input));
            //$this->db->set('dob', Utils::getVar('dob', $input));
            // $this->db->set('gender', Utils::getVar('gender', $input));
            $emailid = $this->getInput('email');
            $emailidr = $emailid['email'];
			
			$longitude = $this->getInput('longitude');
			$longituder = $longitude['longitude'];
			$latitude = $this->getInput('latitude');
            $latituder = $latitude['latitude'];
			
			$registration_address = $this->getInput('registration_address');
            $registration_addressr = $registration_address['registration_address'];
			
			$fb_token1 = $this->getInput('fb_token');
            $fb_tokenr = $fb_token1['fb_token'];
			
			$iemi1 = $this->getInput('iemi');
            $iemir = $iemi1['iemi'];
			
			$this->db->set('email', $emailidr);
            $this->db->set('longitude', $longituder);
			$this->db->set('latitude', $latituder);
			$this->db->set('registration_address', $registration_addressr);
			$this->db->set('fb_token', $fb_tokenr);
			$this->db->set('iemi', $iemir);
            $data['verification_code'] = Utils::randomNumber(5);
            $this->db->set('verification_code', $data['verification_code']);
            $this->db->set('password', md5($data['verification_code']));
            $this->db->where('mobile_no', $data['mobile_no']);
            if ($this->db->update($this->ConsumerModel->table)) {
                //$data['token'] = $this->ConsumerModel->authIdentifyDR($data);
                //$data['token'] = $user;
                //$data['password2'] = $checkmobileno[mobile_no];
                //$data['token'] = $data['token'];
                $this->signupMail($data);
               
				
		$mnv1_result = $this->db->select('message_notification_value, message_notification_value_part2')->from('message_notification_master')->where('id', 1)->get()->row();
		$message_notification_value = $mnv1_result->message_notification_value;
		$message_notification_value_part2 = $mnv1_result->message_notification_value_part2;
		
		 //$smstext = 'Welcome to howzzt. Your OTP for mobile verification is ' . $data['verification_code'] . ', please enter the OTP to complete the signup proccess.';
		  $smstext = $message_notification_value . $data['verification_code'] . $message_notification_value_part2;
		
                Utils::sendSMS($data['mobile_no'], $smstext);
                //$this->ConsumerModel->sendFCM("Congratulations! Your re-registration is successfully completed, and you are logged in.", $fb_tokenr);
		$mnv2_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 2)->get()->row();
				$mnvtext2 = $mnv2_result->message_notification_value;
		 //$this->ConsumerModel->sendFCM("Congratulations! Your re-registration is successfully completed, and you are logged in.", $fb_tokenr);
		  $this->ConsumerModel->sendFCM($mnvtext2, $fb_tokenr);
		  $mnv3_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 3)->get()->row();
				$mnvtext3 = $mnv3_result->message_notification_value;
               // Utils::response(['status' => true, 'message' => 'You are re-registered with this device, and you are logged in.', 'data' => $data]);
				Utils::response(['status' => true, 'message' => $mnvtext3, 'data' => $data]);
               
            } else {
				$mnv4_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 4)->get()->row();
				$mnvtext4 = $mnv4_result->message_notification_value;
                Utils::response(['status' => false, 'message' => $mnvtext4], 200);
            }
        } else {

            $errors = $this->ConsumerModel->signupValidateNew($data);
            if (is_array($errors)) {
                Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
            }
            $data['ip'] = $this->input->ip_address();
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['modified_at'] = date("Y-m-d H:i:s");
            //$emailid = $this->getInput('email');
			//$data['email'] = $emailid;
			$fb_tokend = $this->getInput('fb_token');
			$data['fb_token'] = $fb_tokend['fb_token'];
			$iemid = $this->getInput('iemi');
			$data['iemi'] = $iemid['iemi'];

			$longitudeN = $this->getInput('longitude');
			$data['longitude'] = $longitudeN['longitude'];

			$latitudeN = $this->getInput('latitude');
			$data['latitude'] = $latitudeN['latitude'];	

			$registrationAddressN = $this->getInput('registration_address');
			$data['registration_address'] = $registrationAddressN['registration_address'];			
			
            $data['verification_code'] = Utils::randomNumber(5);
            $data['password'] = md5($data['verification_code']);
            if ($this->db->insert('consumers', $data)) {
                $userId = $this->db->insert_id();
                $this->Productmodel->saveLoyltyReg('user-registration', $userId, ['consumer_id' => $userId, 'latitude' =>$data['latitude'], 'longitude' => $data['longitude'], 'registration_address' => $data['registration_address']]);
				$this->Productmodel->saveConsumerPassbookLoyaltyReg('user-registration', $userId, ['consumer_id' => $userId, 'consumer_phone' => $checkmobileno2, 'passbook_title' => "howzzt Registration", 'passbook_event' => "User Registration", 'latitude' =>$data['latitude'], 'longitude' => $data['longitude'], 'registration_address' => $data['registration_address']], 'Loyalty');
                //$data['password'] = $data['mobile_no'];
                //$data['token'] = $this->ConsumerModel->authIdentifyDR($data);
                /*
                  $user = $this->ConsumerModel->authIdentifyDR($data);
                  $data['token'] = $user;
                  if($user == 'mobile'){
                  $this->response(['status'=>false,'message'=>'Mobile No has not been verified.']);
                  }
                  else{
                  $this->response(['status'=>true,'message'=>'Login done successfully.','data'=>$user]);
                  }
                 */
                //$data['password1'] = $checkmobileno;
				
				$loylty = $this->Productmodel->findLoylityBySlug('user-registration');
				//$getloylty = $loylty['loyalty_points'];
                $this->signupMail($data);
                //$mnvtext5 = 'Welcome to howzzt. Your OTP for mobile verification is ' . $data['verification_code'] . ', please enter the OTP to complete the signup proccess.';
				$mnv5_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 5)->get()->row();
				$mnvtext5 = $mnv5_result->message_notification_value;
                Utils::sendSMS($data['mobile_no'], $mnvtext5);
				$fb_token = getConsumerFb_TokenById($userId);
				$mnv6_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 6)->get()->row();
				$mnvtext6 = $mnv6_result->message_notification_value;
               //$this->ConsumerModel->sendFCM('Congratulations! Your registration is complete, and ' . $loylty['loyalty_points'] . ' Loyalty Points have been added in your howzzt loyalty program.', $fb_token);
			   $this->ConsumerModel->sendFCM($mnvtext5, $fb_token);
			   
			   $mnv7_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 7)->get()->row();
				$mnvtext7 = $mnv7_result->message_notification_value;
                //Utils::response(['status' => true, 'message' => 'Your account has been registered successfully.', 'data' => $data], 200);
				Utils::response(['status' => true, 'message' => $mnvtext7, 'data' => $data], 200);
                
                
            } else {
		$mnv8_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 8)->get()->row();
		$mnvtext8 = $mnv8_result->message_notification_value;
                //Utils::response(['status' => false, 'message' => 'Registration has been failed.'], 200);
				Utils::response(['status' => false, 'message' => $mnvtext8], 200);
            }
        }
    }

    /**
     * viewProfile to view the profile details
     * 
     * @param null get id from header token
     * @return json json object with user details
     */
    public function viewProfile() {
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
		$mnv9_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 9)->get()->row();
		$mnvtext9 = $mnv9_result->message_notification_value;
        //Utils::response(['status' => true, 'message' => 'Your account details.', 'data' => $this->auth()]);
		Utils::response(['status' => true, 'message' => $mnvtext9, 'data' => $this->auth()]);
    }

    /**
     * editProfile to edit profile, Login is required.
     * @param json $post like  user_name, dob,gender
     * @return json api responsess
     */
    public function editProfile() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'user_name', 'label' => 'User Name', 'rules' => 'min_length[2]'],
            ['field' => 'email', 'label' => 'Email', 'rules' => 'min_length[2]'],
            ['field' => 'dob', 'label' => 'Date of birth', 'rules' => [$this->ConsumerModel, 'dob_check']],
            ['field' => 'gender', 'label' => 'Gender', 'rules' => 'trim|min_length[2]'],
			['field' => 'alternate_mobile_no', 'label' => 'Alternate Mobile Number', 'rules' => 'min_length[10]'],
			['field' => 'street_address', 'label' => 'Street Address', 'rules' => 'min_length[2]'],
			['field' => 'city', 'label' => 'City', 'rules' => 'min_length[2]'],
			['field' => 'state', 'label' => 'State', 'rules' => 'min_length[2]'],
			['field' => 'pin_code', 'label' => 'Pin Code', 'rules' => 'min_length[2]'],
			['field' => 'monthly_earnings', 'label' => 'Monthly Earnings', 'rules' => 'min_length[2]'],
			['field' => 'job_profile', 'label' => 'Job Profile', 'rules' => 'min_length[2]'],
			['field' => 'education_qualification', 'label' => 'Education Qualification', 'rules' => 'min_length[2]'],
			['field' => 'type_vehicle', 'label' => 'Type Vehicle', 'rules' => 'min_length[2]'],
			['field' => 'profession', 'label' => 'Profession', 'rules' => 'min_length[2]'],
			['field' => 'marital_status', 'label' => 'Marital  Status', 'rules' => 'min_length[2]'],
			['field' => 'no_of_family_members', 'label' => 'Number of Family Members', 'rules' => 'min_length[1]'],
			['field' => 'loan_car_housing', 'label' => 'Loan Type', 'rules' => 'min_length[2]'],
			['field' => 'personal_loan', 'label' => 'Personal Loan', 'rules' => 'min_length[2]'],
			['field' => 'credit_card_loan', 'label' => 'Credit Card Loan', 'rules' => 'min_length[2]'],
			['field' => 'own_a_car', 'label' => 'Own a Car', 'rules' => 'min_length[2]'],
			['field' => 'house_type', 'label' => 'House Type', 'rules' => 'min_length[2]'],
			['field' => 'last_location', 'label' => 'Last Location', 'rules' => 'min_length[2]'],
			['field' => 'life_insurance', 'label' => 'Life Insurance', 'rules' => 'min_length[2]'],
			['field' => 'medical_insurance', 'label' => 'Medical Insurance', 'rules' => 'min_length[2]'],
			['field' => 'height_in_inches', 'label' => 'Height in Inches', 'rules' => 'min_length[2]'],
			['field' => 'weight_in_kg', 'label' => 'Weight in Kgs', 'rules' => 'min_length[2]'],
			['field' => 'hobbies', 'label' => 'Hobbies', 'rules' => 'min_length[2]'],
			['field' => 'sports', 'label' => 'Sports', 'rules' => 'min_length[2]'],
			['field' => 'entertainment', 'label' => 'Entertainment', 'rules' => 'min_length[2]'],
			['field' => 'spouse_gender', 'label' => 'Spouse Gender', 'rules' => 'min_length[2]'],
			['field' => 'spouse_phone', 'label' => 'Spouse Phone', 'rules' => 'min_length[2]'],
			['field' => 'spouse_dob', 'label' => 'Spouse DOB', 'rules' => 'min_length[2]'],
			['field' => 'marriage_anniversary', 'label' => 'Marriage Anniversary', 'rules' => 'min_length[2]'],
			['field' => 'spouse_work_status', 'label' => 'Spouse Work Status', 'rules' => 'min_length[2]'],
			['field' => 'spouse_edu_qualification', 'label' => 'Spouse Educational Qualification', 'rules' => 'min_length[2]'],
			['field' => 'spouse_monthly_income', 'label' => 'Spouse Monthly Income', 'rules' => 'min_length[2]'],
			['field' => 'spouse_loan', 'label' => 'Spouse Loan', 'rules' => 'min_length[2]'],
			['field' => 'spouse_personal_loan', 'label' => 'Spouse Personal Loan', 'rules' => 'min_length[2]'],
			['field' => 'spouse_credit_card_loan', 'label' => 'Spouse Credit Card Loan', 'rules' => 'min_length[2]'],
			['field' => 'spouse_own_a_car', 'label' => 'Spouse Own a Car', 'rules' => 'min_length[2]'],
			['field' => 'spouse_house_type', 'label' => 'Spouse House Type', 'rules' => 'min_length[2]'],
			['field' => 'spouse_height_inches', 'label' => 'Spouse Height in Inches', 'rules' => 'min_length[2]'],
			['field' => 'spouse_weight_kg', 'label' => 'Spouse Weight in Kg', 'rules' => 'min_length[2]'],
			['field' => 'spouse_hobbies', 'label' => 'Spouse Hobbies', 'rules' => 'min_length[2]'],
			['field' => 'spouse_sports', 'label' => 'Spouse Sports', 'rules' => 'min_length[2]'],
			['field' => 'spouse_entertainment', 'label' => 'Spouse Entertainment', 'rules' => 'min_length[2]'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $this->db->set('modified_at', date("Y-m-d H:i:s"));
        $this->db->set('user_name', Utils::getVar('user_name', $input));
        $this->db->set('email', Utils::getVar('email', $input));
        $this->db->set('dob', Utils::getVar('dob', $input));
		$this->db->set('gender', Utils::getVar('gender', $input));		
		$this->db->set('alternate_mobile_no', Utils::getVar('alternate_mobile_no', $input));
		$this->db->set('street_address', Utils::getVar('street_address', $input));
		$this->db->set('city', Utils::getVar('city', $input));
		$this->db->set('state', Utils::getVar('state', $input));
		$this->db->set('pin_code', Utils::getVar('pin_code', $input));
		$this->db->set('monthly_earnings', Utils::getVar('monthly_earnings', $input));
		$this->db->set('job_profile', Utils::getVar('job_profile', $input));
		$this->db->set('education_qualification', Utils::getVar('education_qualification', $input));
		$this->db->set('type_vehicle', Utils::getVar('type_vehicle', $input));
		$this->db->set('profession', Utils::getVar('profession', $input));
		$this->db->set('marital_status', Utils::getVar('marital_status', $input));
		$this->db->set('no_of_family_members', Utils::getVar('no_of_family_members', $input));
		$this->db->set('loan_car_housing', Utils::getVar('loan_car_housing', $input));
		$this->db->set('personal_loan', Utils::getVar('personal_loan', $input));
		$this->db->set('credit_card_loan', Utils::getVar('credit_card_loan', $input));
		$this->db->set('own_a_car', Utils::getVar('own_a_car', $input));
		$this->db->set('house_type', Utils::getVar('house_type', $input));
		$this->db->set('last_location', Utils::getVar('last_location', $input));
		$this->db->set('life_insurance', Utils::getVar('life_insurance', $input));
		$this->db->set('medical_insurance', Utils::getVar('medical_insurance', $input));
		$this->db->set('height_in_inches', Utils::getVar('height_in_inches', $input));
		$this->db->set('weight_in_kg', Utils::getVar('weight_in_kg', $input));
		$this->db->set('hobbies', Utils::getVar('hobbies', $input));
		$this->db->set('sports', Utils::getVar('sports', $input));
		$this->db->set('entertainment', Utils::getVar('entertainment', $input));
		$this->db->set('spouse_gender', Utils::getVar('spouse_gender', $input));
		$this->db->set('spouse_phone', Utils::getVar('spouse_phone', $input));
		$this->db->set('spouse_dob', Utils::getVar('spouse_dob', $input));
		$this->db->set('marriage_anniversary', Utils::getVar('marriage_anniversary', $input));
		$this->db->set('spouse_work_status', Utils::getVar('spouse_work_status', $input));
		$this->db->set('spouse_edu_qualification', Utils::getVar('spouse_edu_qualification', $input));
		$this->db->set('spouse_monthly_income', Utils::getVar('spouse_monthly_income', $input));
		$this->db->set('spouse_loan', Utils::getVar('spouse_loan', $input));
		$this->db->set('spouse_personal_loan', Utils::getVar('spouse_personal_loan', $input));
		$this->db->set('spouse_credit_card_loan', Utils::getVar('spouse_credit_card_loan', $input));
		$this->db->set('spouse_own_a_car', Utils::getVar('spouse_own_a_car', $input));
		$this->db->set('spouse_house_type', Utils::getVar('spouse_house_type', $input));
		$this->db->set('spouse_height_inches', Utils::getVar('spouse_height_inches', $input));
		$this->db->set('spouse_weight_kg', Utils::getVar('spouse_weight_kg', $input));
		$this->db->set('spouse_hobbies', Utils::getVar('spouse_hobbies', $input));
		$this->db->set('spouse_sports', Utils::getVar('spouse_sports', $input));
		$this->db->set('spouse_entertainment', Utils::getVar('spouse_entertainment', $input));
		
        
        $this->db->where('id', $user['id']);
        if ($this->db->update($this->ConsumerModel->table)) {
			$mnv10_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 10)->get()->row();
		$mnvtext10 = $mnv10_result->message_notification_value;		
            //Utils::response(['status' => true, 'message' => 'Your account has been updated.', 'data' => $input]);
			 Utils::response(['status' => true, 'message' => $mnvtext10, 'data' => $input]);
        } else {
            Utils::response(['status' => false, 'message' => 'System failed to update.'], 200);
        }
    }

    /*
      // originalfunction for edit profile...

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
     */

    /**
     * changePassword to change password
     * 
     * @param string $old_password old password
     * @param string $password new password
     * @param string $password_confirmation repeat the original password
     * @return json  json object of api response.
     */
    // add Consumer Family Details function 
    public function addConsumerRelative() {
        $user = $this->auth();
        $data = $this->getInput();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'member_name', 'label' => 'Member Name', 'rules' => 'min_length[2]'],
            ['field' => 'relation', 'label' => 'Relation', 'rules' => 'min_length[2]'],
            ['field' => 'phone_number', 'label' => 'Phone Number', 'rules' => 'trim|required|integer|exact_length[10]'],
            ['field' => 'howzzt_member', 'label' => 'howzzt member', 'rules' => 'trim|in_list[yes,no]'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        $phone_number = $this->getInput('phone_number');

        //$emailid = $this->getInput('email');
        $phone_numberr = $phone_number['phone_number'];

        $isRegistered = $this->ConsumerModel->isHowzztMember($phone_numberr);

        if ($isRegistered == TRUE) {

            $data['howzzt_member'] = "yes";
        } else {

            $data['howzzt_member'] = "no";
        }

        $data['consumer_id'] = $user['id'];
        $data['status'] = "1";
        $data['ip'] = $this->input->ip_address();

        if ($this->db->insert('consumer_family_details', $data)) {
            $this->signupMail($data);
            $smstext = 'You have added ' . $mobile_no . ' as ' . $data['relation'] . ' relation with you.';
            Utils::sendSMS($data['phone_number'], $smstext);
            $userId = $user['id'];
            //$this->Productmodel->saveLoylty('user-registration', $userId, ['user_id' => $userId]);
            Utils::response(['status' => true, 'message' => 'Your Family member has been added successfully.', 'data' => $data], 200);
        } else {
            Utils::response(['status' => false, 'message' => 'Adding relative failed.'], 200);
        }
    }

// edit Consumer Family Member function
    public function editConsumerRelative($relation_id) {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'member_name', 'label' => 'Member Name', 'rules' => 'min_length[2]'],
            ['field' => 'relation', 'label' => 'Relation', 'rules' => 'min_length[2]'],
            ['field' => 'phone_number', 'label' => 'Phone Number', 'rules' => 'trim|required|integer|exact_length[10]'],
            ['field' => 'howzzt_member', 'label' => 'howzzt member', 'rules' => 'trim|in_list[yes,no]'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        $phone_number = $this->getInput('phone_number');

        //$emailid = $this->getInput('email');
        $phone_numberr = $phone_number['phone_number'];

        $isRegistered = $this->ConsumerModel->isHowzztMember($phone_numberr);

        if ($isRegistered == TRUE) {

            $howzzt_member = "yes";
        } else {

            $howzzt_member = "no";
        }

        $this->db->set('modified_at', date("Y-m-d H:i:s"));
        $this->db->set('member_name', Utils::getVar('member_name', $input));
        $this->db->set('relation', Utils::getVar('relation', $input));
        $this->db->set('phone_number', Utils::getVar('phone_number', $input));
        $this->db->set('howzzt_member', $howzzt_member);
        $this->db->where('relation_id', $relation_id);
        if ($this->db->update('consumer_family_details')) {

            Utils::response(['status' => true, 'message' => 'Your Family Member details have been updated.', 'data' => $input]);
        } else {
            Utils::response(['status' => false, 'message' => 'System failed to update.'], 200);
        }
    }

// Delete Consumer Family Member function

    public function DeleteConsumerRelative($relation_id) {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        if ($this->db->delete('consumer_family_details', array('relation_id' => $relation_id))) {
            Utils::response(['status' => true, 'message' => 'Your Family Member Deleted Successfully.']);
        } else {
            Utils::response(['status' => false, 'message' => 'System failed to delete.'], 200);
        }
    }

    public function ListConsumerRelatives() {
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $userid = $user['id'];
        $result = $this->ConsumerModel->findConsumerRelatives($userid);
        if (empty($result)) {
            $this->response(['status' => false, 'message' => 'Record not found'], 200);
        }
        $this->response(['status' => true, 'message' => 'Relative are-', 'data' => $result]);
    }

	    // add Consumer Kid Details function 
    public function addConsumerKid() {
        $user = $this->auth();
        $data = $this->getInput();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'kid_name', 'label' => 'Kid Name', 'rules' => 'min_length[2]'],
            ['field' => 'kid_gender', 'label' => 'Kid Gender', 'rules' => 'min_length[2]'],
            ['field' => 'kid_phone_number', 'label' => 'Kid Phone Number', 'rules' => 'trim|required|integer|exact_length[10]'],
			['field' => 'kid_dob', 'label' => 'Kid Date of birth', 'rules' => [$this->ConsumerModel, 'dob_check']],
			['field' => 'kid_height', 'label' => 'Kid Height ', 'rules' => 'min_length[2]'],
			['field' => 'kid_weight', 'label' => 'Kid Weight ', 'rules' => 'min_length[2]'],
			['field' => 'kid_hobbies', 'label' => 'Kid Hobbies', 'rules' => 'min_length[2]'],
			['field' => 'kid_sports_like', 'label' => 'Sports Like', 'rules' => 'min_length[2]'],
			['field' => 'kid_entertainment_like', 'label' => 'Kid Entertainment Like', 'rules' => 'min_length[2]'],
           
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        $phone_number = $this->getInput('phone_number');

        //$emailid = $this->getInput('email');
        $phone_numberr = $phone_number['phone_number'];

        $isRegistered = $this->ConsumerModel->isHowzztMember($phone_numberr);

        

        $data['consumer_id'] = $user['id'];
        $data['status'] = "1";
		$data['create_date'] = date("Y-m-d H:i:s");
        $data['ip'] = $this->input->ip_address();

        if ($this->db->insert('consumer_kid_details', $data)) {
            //$this->signupMail($data);
           // $smstext = 'You have added ' . $data['relation'] . ' as ' . $data['relation'] . ' relation with you.';
            //Utils::sendSMS($data['phone_number'], $smstext);
           // $userId = $user['id'];
            //$this->Productmodel->saveLoylty('user-registration', $userId, ['user_id' => $userId]);
			$mnv11_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 11)->get()->row();
		$mnvtext11 = $mnv11_result->message_notification_value;	
            //Utils::response(['status' => true, 'message' => 'Your Kid has been added successfully.', 'data' => $data], 200);
			Utils::response(['status' => true, 'message' => $mnvtext11, 'data' => $data], 200);
        } else {
			$mnv12_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 12)->get()->row();
		$mnvtext12 = $mnv12_result->message_notification_value;	
            //Utils::response(['status' => false, 'message' => 'Adding Kid failed.'], 200);
			Utils::response(['status' => false, 'message' => $mnvtext12], 200);
        }
    }

// edit Consumer Kid function
    public function editConsumerKid($kid_id) {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'kid_name', 'label' => 'Kid Name', 'rules' => 'min_length[2]'],
            ['field' => 'kid_gender', 'label' => 'Kid Gender', 'rules' => 'min_length[2]'],
            ['field' => 'kid_phone_number', 'label' => 'Kid Phone Number', 'rules' => 'trim|required|integer|exact_length[10]'],
			['field' => 'kid_dob', 'label' => 'Kid Date of birth', 'rules' => [$this->ConsumerModel, 'dob_check']],
			['field' => 'kid_height', 'label' => 'Kid Height ', 'rules' => 'min_length[2]'],
			['field' => 'kid_weight', 'label' => 'Kid Weight ', 'rules' => 'min_length[2]'],
			['field' => 'kid_hobbies', 'label' => 'Kid Hobbies', 'rules' => 'min_length[2]'],
			['field' => 'kid_sports_like', 'label' => 'Sports Like', 'rules' => 'min_length[2]'],
			['field' => 'kid_entertainment_like', 'label' => 'Kid Entertainment Like', 'rules' => 'min_length[2]'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $phone_number = $this->getInput('phone_number');
        //$emailid = $this->getInput('email');
        $phone_numberr = $phone_number['phone_number'];
        $isRegistered = $this->ConsumerModel->isHowzztMember($phone_numberr);       

        $this->db->set('modified_date', date("Y-m-d H:i:s"));
        $this->db->set('kid_name', Utils::getVar('kid_name', $input));
        $this->db->set('kid_gender', Utils::getVar('kid_gender', $input));
        $this->db->set('kid_phone_number', Utils::getVar('kid_phone_number', $input));
		$this->db->set('kid_dob', Utils::getVar('kid_dob', $input));
        $this->db->set('kid_height', Utils::getVar('kid_height', $input));
        $this->db->set('kid_weight', Utils::getVar('kid_weight', $input));
		$this->db->set('kid_hobbies', Utils::getVar('kid_hobbies', $input));
        $this->db->set('kid_sports_like', Utils::getVar('kid_sports_like', $input));
        $this->db->set('kid_entertainment_like', Utils::getVar('kid_entertainment_like', $input));
        $this->db->where('kid_id', $kid_id);
        if ($this->db->update('consumer_kid_details')) {
	$mnv13_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 13)->get()->row();
		$mnvtext13 = $mnv13_result->message_notification_value;	
            //Utils::response(['status' => true, 'message' => 'Your Kid details have been updated successfully.', 'data' => $input]);
			Utils::response(['status' => true, 'message' => $mnvtext13, 'data' => $input]);
        } else {
			$mnv14_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 14)->get()->row();
		$mnvtext14 = $mnv14_result->message_notification_value;	
            //Utils::response(['status' => false, 'message' => 'System failed to update.'], 200);
			 Utils::response(['status' => false, 'message' => $mnvtext14], 200);
        }
    }

// Delete Consumer Kid function

    public function DeleteConsumerKid($kid_id) {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        if ($this->db->delete('consumer_kid_details', array('kid_id' => $kid_id))) {
		$mnv15_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 15)->get()->row();
		$mnvtext15 = $mnv15_result->message_notification_value;	
            //Utils::response(['status' => true, 'message' => 'The Kid Deleted Successfully.']);
			 Utils::response(['status' => true, 'message' => $mnvtext15]);
        } else {
		$mnv16_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 16)->get()->row();
		$mnvtext16 = $mnv16_result->message_notification_value;
            //Utils::response(['status' => false, 'message' => 'System failed to delete.'], 200);
			Utils::response(['status' => false, 'message' => 'System failed to delete.'], 200);
        }
    }

    public function ListConsumerKids() {
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $userid = $user['id'];
        $result = $this->ConsumerModel->findConsumerKids($userid);
        if (empty($result)) {
            $this->response(['status' => false, 'message' => 'Record not found'], 200);
        }
        $this->response(['status' => true, 'message' => 'Kid are-', 'data' => $result]);
    }
	
	
	
    public function changePassword() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'old_password', 'label' => 'Previous Password', 'rules' => ['required']],
            ['field' => 'new_password', 'label' => 'New Password', 'rules' => 'required|min_length[8]'],
            ['field' => 'confirm_password', 'label' => 'Confirm Password', 'rules' => 'required|matches[new_password]']
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        if (md5($input['old_password']) != $user['password']) {
            $this->response(['status' => false, 'message' => 'Previous password not matched.']);
        }
        if ($this->db->update($this->ConsumerModel->table, ['password' => md5($input['new_password'])], ['id' => $user['id']])) {
            $this->response(['status' => true, 'message' => 'New password has been changed successfully.']);
        } else {
            $this->response(['status' => false, 'message' => 'Failed to save new password.']);
        }
    }

    /**
     * forgotPassword method to reset password.
     * 
     * @param String $mobile_no|$email either mobile no or email
     * @return Json generated random password
     */
    public function forgotPassword($username = null) {
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $username = urldecode($username);
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $validate = [['field' => 'username', 'label' => 'Email', 'rules' => 'trim|required|valid_email']];
            $condition = ['email' => $username];
        } else {
            $validate = [['field' => 'username', 'label' => 'Mobile No', 'rules' => 'trim|required|integer|exact_length[10]']];
            $condition = ['mobile_no' => $username];
        }
        $errors = $this->ConsumerModel->validate(['username' => $username], $validate);
        if (is_array($errors)) {
            $this->response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $user = $this->ConsumerModel->findBy($condition);
        if (!$user) {
            Utils::response(['status' => false, 'message' => 'Record not found.']);
        }
        $password = Utils::randomNumber(8);
        $user->password = md5($password);
        $smstext = 'System generated password is ' . $password . ' Please change it after doing logging.';
        if (Utils::sendSMS($user->mobile_no, $smstext)) {
            if ($this->db->update($this->ConsumerModel->table, ['password' => $user->password], ['id' => $user->id])) {
                Utils::response(['status' => true, 'message' => 'A new password has been sent to your registered mobile no.']);
            } else {
                Utils::response(['status' => false, 'message' => 'There is system error to reset password.']);
            }
        } else {
            Utils::response(['status' => false, 'message' => 'Failed to send message, Try after some time.']);
        }
    }

    public function resendOtp($mobile = null) {
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'mobile_no', 'label' => 'Mobile No', 'rules' => 'trim|required|integer|exact_length[10]']
        ];
        $errors = $this->ConsumerModel->validate(['mobile_no' => $mobile], $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $data = $this->ConsumerModel->findBy(['mobile_no' => $mobile]);
        if (!$data) {
            Utils::response(['status' => false, 'message' => 'Record not found from given mobile no.']);
        }
        $genRandomNo = Utils::randomNumber(5);
        $data->verification_code = $genRandomNo;
        $data->password = md5($genRandomNo);

        $smstext = 'Welcome to howzzt. Your OTP for mobile verification is ' . $data->verification_code . ', please enter the OTP to complete the signup proccess.';

        if (Utils::sendSMS($data->mobile_no, $smstext)) {
            if ($this->db->update($this->ConsumerModel->table, $data, ['mobile_no' => $data->mobile_no])) {
                Utils::response(['status' => true, 'message' => 'OTP has been sent successfully.']);
            } else {
                Utils::response(['status' => false, 'message' => 'Record not found from given mobile no.']);
            }
        } else {
            Utils::response(['status' => false, 'message' => 'Failed to send message, Try after some time.']);
        }
    }

    public function verifyOtp() {
        $data = $this->getInput();
        if (($this->input->method() != 'post') || empty($data)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'mobile_no', 'label' => 'Mobile No', 'rules' => 'trim|required|integer|exact_length[10]'],
            ['field' => 'otp', 'label' => 'One time password', 'rules' => 'required|min_length[6]'],
        ];
        $errors = $this->ConsumerModel->validate($data, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $dbdata = $this->ConsumerModel->findBy(['mobile_no' => $data['mobile_no']]);
        if (!$dbdata) {
            Utils::response(['status' => false, 'message' => 'Record not found from given mobile no.']);
        }
        if ($dbdata->verification_code != $data['otp']) {
            Utils::response(['status' => false, 'message' => 'OTP has not been matched.']);
        }
        $dbdata->verification_code = null;
        $dbdata->is_verified = ($dbdata->is_verified == 3) ? 1 : 2;
        if ($this->db->update($this->ConsumerModel->table, $dbdata, ['mobile_no' => $dbdata->mobile_no])) {
            Utils::response(['status' => true, 'message' => 'Your account has been successfully verified.']);
        }
    }

    public function signupMail($data) {
        $this->load->library('email');
        $this->email->initialize($this->config->item('smtp'));
        $this->email->set_newline("\r\n");
        $this->email->from($data['email'], $data['user_name']);
        $this->email->reply_to('no-reply@innovigents.com', 'Team');
        $this->email->to($this->config->item('admin_email'));
        $this->email->subject('Signup with with ' . $this->config->item("site_name"));
        $body = $this->load->view('signup_mail.php', $data, TRUE);
        $this->email->message($body);
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
        //echo $this->email->print_debugger();die;
    }

    public function resendMail() {
        $data = $this->getInput();
        if (($this->input->method() != 'post') || empty($data)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email']
        ];
        $errors = $this->ConsumerModel->validate(['email' => $data['email']], $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $user = $this->ConsumerModel->findBy(['email' => $data['email']]);
        if (!$user) {
            Utils::response(['status' => false, 'message' => 'Record not found from given email.']);
        }

        if ($this->signupMail((array) $user)) {
            Utils::response(['status' => true, 'message' => 'Mail has been sent successfully.']);
        } else {
            Utils::response(['status' => false, 'message' => 'Failed to send message, Try after some time.']);
        }
    }

    public function mailVerification($token = null, $email = null) {
        if (!$token || !$email) {
            show_error('Invalid url.');
        }
        $user = $this->ConsumerModel->findBy(['email' => urldecode($email)]);
        if (empty($user)) {
            show_error('Account not found, Please read email carefully and try again.');
        }

        if ($user->is_verified > 0) {
            $this->session->set_flashdata('flash', 'Your Account has been already activated. You can now log in using the username and password you chose during the registration');
            //return $this->redirect('/');
        } else {
            if ($token != md5($user->email)) {
                show_error('Invalid token. Please read email carefully and try again.');
            }
            $user->is_verified = ($user->is_verified == 2) ? 1 : 3;
            if ($this->db->update($this->ConsumerModel->table, $user, ['email' => $user->email])) {
                $this->session->set_flashdata('flash', 'Your Account has been successfully activated. You can now log in using the username and password you chose during the registration.');
            } else {
                $this->session->set_flashdata('flash', 'This link has no longer existing.');
            }
        }
        $this->load->view('mail_verification');
    }

    public function login() {
        $data = $this->getInput();
        if (($this->request->method != 'post') || empty($data)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'password', 'label' => 'Password', 'rules' => 'trim|required'],
            ['field' => 'device_id', 'label' => 'Device Id', 'rules' => 'trim|required']
        ];
        if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            array_push($validate, ['field' => 'username', 'label' => 'Email', 'rules' => 'trim|required|valid_email']);
        } else {
            array_push($validate, ['field' => 'username', 'label' => 'Mobile No', 'rules' => 'trim|required|integer|exact_length[10]']);
        }
        $errors = $this->ConsumerModel->validate($data, $validate);
        if (is_array($errors)) {
            $this->response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $user = $this->ConsumerModel->authIdentify($data);
        if ($user == 'email') {
            $this->response(['status' => false, 'message' => 'Email has not been verified.']);
        }
        if ($user == 'mobile') {
            $this->response(['status' => false, 'message' => 'Mobile No has not been verified.']);
        }
        if (!is_object($user)) {
            $this->response(['status' => false, 'message' => 'Invalid Credentials.']);
        } else {
            if (!empty($user->avatar_url)) {
                $user->avatar_url = base_url($user->avatar_url);
            }
            $this->response(['status' => true, 'message' => 'Login done successfully.', 'data' => $user]);
        }
    }

    public function logout() {
        if ($this->request->method != 'get') {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        if (empty($this->request->token)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $this->load->model('UserLogModel');
        $this->db->where('token', $this->request->token)->delete($this->UserLogModel->table);
        $this->response(['status' => true, 'message' => 'Logout successfully.']);
    }

    /**
     * uploadAvatar method to upload profile pic.
     * 
     * @param Array $avatar avatar property like size,type,tmp_name and name
     * @return Object $response contain uploaded avatar url or failed message
     */
    public function uploadAvatar() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $data = $this->getInput();
        if (($this->request->method != 'post') || empty($data)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }

        $this->load->library('upload', [
            'upload_path' => './uploads/consumer/',
            'allowed_types' => 'gif|jpg|png|jpeg',
            'max_size' => '5120',
        ]);
        if (!$this->upload->do_upload('avatar')) {
            $this->response(['status' => false, 'message' => Utils::errors($this->upload->display_errors())]);
        }
        $data['avatar_url'] = 'uploads/consumer/' . $this->upload->data('file_name');
        $this->db->set('avatar_url', $data['avatar_url']);
        $this->db->where('id', $user['id']);
        if ($this->db->update($this->ConsumerModel->table)) {
            unset($data['avatar']);
            $data['avatar_url'] = base_url($data['avatar_url']);
		$mnv17_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 17)->get()->row();
		$mnvtext17 = $mnv17_result->message_notification_value;
           // Utils::response(['status' => true, 'message' => 'Image has been uploaded successfully.', 'data' => $data]);
			 Utils::response(['status' => true, 'message' => $mnvtext17, 'data' => $data]);
        } else {
		$mnv18_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 18)->get()->row();
		$mnvtext18 = $mnv18_result->message_notification_value;
            //Utils::response(['status' => false, 'message' => 'System failed to upload.'], 200);
			Utils::response(['status' => false, 'message' => $mnvtext18], 200);
        }
    }

    public function feedbackQuestion($product = null) {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        if (($this->request->method != 'get') || is_null($product)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $data = $this->Productmodel->feedbackQuestion($product);
        if (!empty($data)) {
            Utils::response(['status' => true, 'message' => 'List of questions for feedback.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'System failed to proccess the request.'], 200);
        }
    }

    public function feedbackAnswer() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $data = $this->getInput();
        if (($this->request->method != 'post') || empty($data)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }

        $validate = [
            ['field' => 'product_id', 'label' => 'Product', 'rules' => 'trim|required|integer'],
            ['field' => 'product_qr_code', 'label' => 'Product QR Code', 'rules' => 'trim|required'],
            ['field' => 'question_id', 'label' => 'Question', 'rules' => 'trim|required|integer'],
            ['field' => 'selected_answer', 'label' => 'User answer', 'rules' => 'trim|required'],
			['field' => 'latitude', 'label' => 'User latitude', 'rules' => 'trim|required'],
			['field' => 'longitude', 'label' => 'User longitude', 'rules' => 'trim|required'],
			['field' => 'registration_address', 'label' => 'Registration Address', 'rules' => 'trim|required'],
        ];
        $errors = $this->ConsumerModel->validate($data, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors1.', 'errors' => $errors]);
        }
        /* $alreadyAnswered = $this->db->get_where('consumer_feedback',['product_qr_code'=>$data['product_qr_code'],'user_id'=>$user['id'],'question_id'=>$data['question_id']])->row();
          if(count($alreadyAnswered) > 0){
          Utils::response(['status'=>false,'message'=>'Validation errors.','errors'=>'You have already answered of this question for code.']);
          } */
        $productQuestion = $this->Productmodel->feedbackQuestion($data['product_id']);
        if (empty($productQuestion)) {
            Utils::response(['status' => false, 'message' => 'Validation errors2.', 'errors' => 'Invalid question id or product id.']);
        }
		
		
		$ProductID = $data['product_id'];
		$customer_id = get_customer_id_by_product_id($ProductID);
		$Product_code = $data['product_qr_code'];
        $allQuestionIds = [];
        $questionType = null;
        foreach ($productQuestion as $row) {
            if ($row->question_id == $data['question_id']) {
                $questionType = strtolower($row->question_type);
            }
            array_push($allQuestionIds, $row->question_id);
        }
        if (!in_array($data['question_id'], $allQuestionIds)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => 'Invalid product id or question id.']);
        }

        //Utils::debug();
        $data['user_id'] = $user['id'];
        $data['created_date'] = $data['updated_date'] = date('Y-m-d H:i:s');
		
		
        if ($this->db->insert('consumer_feedback', $data)) {
           
		   $purchased_points = total_approved_points2($customer_id);
			$consumed_points = get_total_consumed_points($customer_id);
			if($purchased_points > ($consumed_points+$TRPoints)){  

				$consumer_id = $user['id'];
			    $product_brand_name = get_products_brand_name_by_id($ProductID);
			    $product_name  = get_products_name_by_id($ProductID);
			
            if (strstr($questionType, 'audio')) {
                $transactionType = 'product_audio_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Audio Promotion';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Audio Promotion. '. $TRPoints .' have been added to your howzzt loyalty program.'; 
				$data['transaction_type'] = $questionType;
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
            } elseif (strstr($questionType, 'video')) {
                $transactionType = 'product_video_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Video Promotion';
				
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Video Promotion. '. $TRPoints .' have been added to your howzzt loyalty program.'; 
				$data['transaction_type'] = $questionType;
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
            } elseif (strstr($questionType, 'pdf')) {
                $transactionType = 'product_pdf_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Product Brochure';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Product Brochure Promotion. '. $TRPoints .' have been added to your howzzt loyalty program.'; 
				$data['transaction_type'] = $questionType;
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
            } elseif (strstr($questionType, 'Product Image Feedback')) {
                $transactionType = 'product_image_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Image Promotion.';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Product Image Promotion. '. $TRPoints .' have been added to your howzzt loyalty program.'; 
				$data['transaction_type'] = $questionType;
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
		   } elseif (strstr($questionType, 'pushed')) {
                $transactionType = 'product_ad_response_lps';
				$transactionTypeName = 'Product Advertisement';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to video promotion for ' . $product_brand_name . ' . '. $TRPoints .' Loyalty Points have been added to your howzzt loyalty program.';
				$data['transaction_type'] = $questionType;
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
			} elseif (strstr($questionType, 'survey')) {
                $transactionType = 'product_survey_response_lps';
				$transactionTypeName = 'Product Survey';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to product survey for ' . $product_brand_name . '. '. $TRPoints .' Loyalty Points have been added to your howzzt loyalty program.';	
				$data['transaction_type'] = $questionType;
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
			} elseif (strstr($questionType, 'vdemonstration')) {
                $transactionType = 'product_demo_video_response_lps';
				$transactionTypeName = 'Viewing product video demonstration';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'Thank you for viewing product video demonstration. Loyalty Point. '. $TRPoints .' have been added to your howzzt loyalty program.';
				$data['transaction_type'] = $questionType;
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylityDemo($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
			} elseif (strstr($questionType, 'ademonstration')) {
                $transactionType = 'product_demo_audio_response_lps';
				$transactionTypeName = 'Listening product audio demonstration ';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'Thank you for listening product audio demonstration. Loyalty Point '. $TRPoints .' have been added to your howzzt loyalty program.';	
				$data['transaction_type'] = $questionType;
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
            $this->Productmodel->feedbackLoylityDemo($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
            } else {
                $transactionType = 'product_image_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Product Description Promotion';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Product Image Promotion. '. $TRPoints .' have been added to your howzzt loyalty program'; 
				$data['transaction_type'] = "product image feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
            $this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id);
            }
            
			
				//$id = getConsumerFb_TokenById(29);
		  
				//$this->Productmodel->sendFCM($transactionType, $id);
			
			//$this->Productmodel->feedbackLoylityPassbook($user['id'], $transactionType, $data, $ProductID, $transactionTypeName, 'Loyalty');
            Utils::response(['status' => true, 'message' => 'Feedback answer has been saved successfully.', 'data' => $data]);
        } else {
           Utils::response(['status' => true, 'message' => 'Feedback answer has been saved successfully.', 'data' => $data]);
        }
		
		} else {
            Utils::response(['status' => false, 'message' => 'System failed to proccess the request.'], 200);
        }
		
		
		
    }

    /**
     * loylty method to retrieve thelist of loylty for various transaction type
     */
    public function loylty() {
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $data = [];
        $data = $this->ConsumerModel->loylty();
        if (!empty($data)) {
            Utils::response(['status' => true, 'message' => 'List of loylties.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }

    public function consumerLoylty() {
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $data = [];
        $data = $this->Productmodel->userLoylty($user['id']);
        if (!empty($data)) {
            Utils::response(['status' => true, 'message' => 'User gain loylties.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }

    public function redemptionAdd() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'post')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $data = $this->getInput();
        $cSchema = ['aadhaar_number','alternate_mobile_no','city','state','street_address','pin_code'];
        $rSchema = ['aadhaar_number','alternate_mobile_no','city','state','street_address','pin_code','points_redeemed','coupon_number','coupon_type','coupon_vendor','courier_details'];
        $consumerData = array_intersect_key($data, array_flip($cSchema));
        $consumerData['modified_at'] = date("Y-m-d H:i:s");
        $redemtionData = array_intersect_key($data, array_flip($rSchema));
        $redemtionData['l_created_at'] = date("Y-m-d H:i:s");
		$redemtionData['redemption_id'] = mt_rand(1111111111,9999999999);
        $redemtionData['modified_at'] = date("Y-m-d H:i:s");
		$redemtionData['request_date'] = date("Y-m-d H:i:s");
		$redemtionData['mobile_no'] = getConsumerMobileNumberById($user['id']);
        $redemtionData['l_status'] = 0;
        $redemtionData['user_id'] = $user['id'];
		
		$checkifrquestinprocess = $this->db->where(array('user_id' => $user['id'], 'l_status' => 0))->count_all_results('loyalty_redemption');
		if ($checkifrquestinprocess < 1) {
        if ($this->db->insert('loyalty_redemption', $redemtionData)) {
            $redemptionId = $this->db->insert_id();
            $this->db->update('consumers',$consumerData,['id'=>$user['id']]);
            //$this->Productmodel->saveLoylty('loyalty-redemption', $user['id'], ['user_id' => $user['id'],'redemption_id'=>$redemptionId]);
		$mnv19_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 19)->get()->row();
		$mnvtext19 = $mnv19_result->message_notification_value;
            //Utils::response(['status'=>true,'message'=>'Thank you for your redemption request, after validation, your request will be processed in next 7-10 Working days.']);
			Utils::response(['status'=>true,'message'=>$mnvtext19]);
        }else{
		$mnv20_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 20)->get()->row();
		$mnvtext20 = $mnv20_result->message_notification_value;
           // Utils::response(['status'=>false,'message'=>'Failed to accept the redemption request.Please contact support team.']);
			Utils::response(['status'=>false,'message'=>$mnvtext20]);
        }
		}else{
		$mnv21_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 21)->get()->row();
		$mnvtext21 = $mnv21_result->message_notification_value;
            //Utils::response(['status'=>false,'message'=>'Failed to accept the redemption request because your request is already in process.']);
			Utils::response(['status'=>false,'message'=>$mnvtext21]);
        }
		}
		
	public function ConsumerResponseComplaint() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'post')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $data = $this->getInput();
        $cSchema = ['status'];
        $rSchema = ['complaint_id','complain_code','product_id','bar_code','customer_id','reply_by','comments'];
        $consumerData = array_intersect_key($data, array_flip($cSchema));
        //$consumerData['modified_at'] = date("Y-m-d H:i:s");
        $redemtionData = array_intersect_key($data, array_flip($rSchema));
        $redemtionData['date_time'] = date("Y-m-d H:i:s");
		//$redemtionData['redemption_id'] = mt_rand(1111111111,9999999999);
        //$redemtionData['modified_at'] = date("Y-m-d H:i:s");
		//$redemtionData['request_date'] = date("Y-m-d H:i:s");
		//$redemtionData['mobile_no'] = getConsumerMobileNumberById($user['id']);
        //$redemtionData['l_status'] = 0;
        $redemtionData['consumer_id'] = $user['id'];
		
        if ($this->db->insert('consumer_complaint_reply', $redemtionData)) {
            $redemptionId = $this->db->insert_id();
            $this->db->update('consumer_complaint',$consumerData,['id'=>$data['complaint_id']]);
            //$this->Productmodel->saveLoylty('loyalty-redemption', $user['id'], ['user_id' => $user['id'],'redemption_id'=>$redemptionId]);
           
		$mnv22_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 22)->get()->row();
		$mnvtext22 = $mnv22_result->message_notification_value;
		//Utils::response(['status'=>true,'message'=>'Thank you for responding on complaint, we will review your response in next 7-10 Working days.']);
		Utils::response(['status'=>true,'message'=>$mnvtext22]);
        }else{
		$mnv23_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 23)->get()->row();
		$mnvtext23 = $mnv23_result->message_notification_value;
            //Utils::response(['status'=>false,'message'=>'Failed to respond on the complaint. Please contact support team.']);
			Utils::response(['status'=>false,'message'=>$mnvtext23]);
        }
		
		}


	
	
	   public function ListResponsesOnComplaint($complaintid = null) {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $items = $this->Productmodel->getResponsesOnComplaint($complaintid);
        Utils::response(['status'=>true,'message'=>'List of Responses On Complaint','data'=>$items]);
       
    }
		
		
    public function redemption() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $items = $this->Productmodel->getRedemption($user['id']);
        Utils::response(['status'=>true,'message'=>'List of redemption','data'=>$items]);
       
    }
	
	
	    public function Complaints() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $items = $this->Productmodel->getComplaints($user['id']);
        Utils::response(['status'=>true,'message'=>'List of complaints','data'=>$items]);
       
    }
	
		  public function ListConsumerNotifications() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $items = $this->Productmodel->getConsumerNotifications($user['id']);
        Utils::response(['status'=>true,'message'=>'List of Consumer Notifications.','data'=>$items]);
       
    }
	
	
	    public function FaqsAndOtherData() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        //$items = $this->Productmodel->getRedemption($user['id']);
		$data['consumer_id'] = $user['id'];
		$data['faqs_list'] = "
		Question 1. Data..................<br>
		Answer - Data..................<br>
		Question 2. Data..................<br>
		Answer - Data..................<br>
		Question 3. Data..................<br>
		Answer - Data..................<br>
		Question 4. Data..................<br>
		Answer - Data..................<br>
		Question 5. Data..................<br>
		Answer - Data..................<br>
		Question 6. Data..................<br>
		Answer - Data..................<br>
		Question 6. Data..................<br>
		Answer - Data..................<br>
		Question 8. Data..................<br>
		Answer - Data..................<br>
		
		";
		
        Utils::response(['status'=>true,'message'=>'List of Faqs And Other Data', 'data'=>$data]);
       
    }
	
	public function TermsAndConditions() {
        //Utils::debug();
       
        //$items = $this->Productmodel->getRedemption($user['id']);
		$data['APP_Name'] = "howzzt app";
		$data['faqs_list'] = "........................
		...................................................
		..................................................";
		
        Utils::response(['status'=>true,'message'=>'Terms And Conditions Data', 'data'=>$data]);
       
    }
	
	
	/*
	public function ConsumerPassBook() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $items = $this->Productmodel->getConsumerPassBook($user['id']);
        Utils::response(['status'=>true,'message'=>'List of Consumer PassBook','data'=>$items]);
       

    }
	*/
	public function ConsumerPassBook() {
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		
		$checkifrquestinprocess = $this->db->where(array('user_id' => $user['id'], 'l_status' => 0))->count_all_results('loyalty_redemption');
		
        $data = [];
        $data = $this->Productmodel->getConsumerPassBook($user['id']);
		
        if (!empty($data)) {
            Utils::response(['status' => true, 'min_max_redemption_points_consumer' => '500', 'count_lyalty_request_in_process' => $checkifrquestinprocess, 'message' => 'User gain loylties.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }
	
	

}
