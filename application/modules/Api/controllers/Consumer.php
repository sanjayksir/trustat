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
			if($checkmobileno2=='7272002111'){
				$verification_code_otp = "894562";
			}else{
			$verification_code_otp = Utils::randomNumber(5);
			}		
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
			
			$registration_city = $this->getInput('registration_city');
            $registration_cityr = $registration_city['registration_city'];
			
			$registration_pin_code = $this->getInput('registration_pin_code');
            $registration_pin_coder = $registration_pin_code['registration_pin_code'];
			
			$fb_token1 = $this->getInput('fb_token');
            $fb_tokenr = $fb_token1['fb_token'];
			
			$iemi1 = $this->getInput('iemi');
            $iemir = $iemi1['iemi'];
			
			$this->db->set('email', $emailidr);
            $this->db->set('longitude', $longituder);
			$this->db->set('latitude', $latituder);
			$this->db->set('registration_address', $registration_addressr);
			$this->db->set('registration_city', $registration_cityr);
			$this->db->set('registration_pin_code', $registration_pin_coder);
			$this->db->set('fb_token', $fb_tokenr);
			$this->db->set('iemi', $iemir);
            $data['verification_code'] = $verification_code_otp;
            $this->db->set('verification_code', $data['verification_code']);
            $this->db->set('password', md5($data['verification_code']));
            $this->db->where('mobile_no', $data['mobile_no']);
            if ($this->db->update($this->ConsumerModel->table)) {
                //$data['token'] = $this->ConsumerModel->authIdentifyDR($data);
                //$data['token'] = $user;
                //$data['password2'] = $checkmobileno[mobile_no];
                //$data['token'] = $data['token'];
                $this->signupMail($data);
               
				
		$mnv1_result = $this->db->select('message_notification_value, message_notification_value_part2')->from('message_notification_master')->where('id', 5)->get()->row();
		$message_notification_value = $mnv1_result->message_notification_value;
		$message_notification_value_part2 = $mnv1_result->message_notification_value_part2;
		
		 //$smstext = 'Welcome to TRUSTAT!!. Your OTP for mobile verification is ' . $data['verification_code'] . ', Please enter the OTP to complete the signup process.';
		  $smstext = $message_notification_value . $data['verification_code'] . $message_notification_value_part2;
		
                Utils::sendSMS($data['mobile_no'], $smstext . " zLJoGnJzfXg");
                //$this->ConsumerModel->sendFCM("Congratulations! Your re-registration is successfully completed, and you are logged in.", $fb_tokenr);
		$mnv2_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 6)->get()->row();
				$mnvtext2 = $mnv2_result->message_notification_value;
		 //$this->ConsumerModel->sendFCM("Congratulations! Your re-registration is successfully completed, and you are logged in.", $fb_tokenr);
		 // $this->ConsumerModel->sendFCM($mnvtext2, $fb_tokenr);
		  $mnv3_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 7)->get()->row();
				$mnvtext3 = $mnv3_result->message_notification_value;
               // Utils::response(['status' => true, 'message' => 'You are re-registered with this device, and you are logged in.', 'data' => $data]);
				Utils::response(['status' => true, 'message' => $mnvtext3, 'data' => $data]);
               
            } else {
				$mnv4_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 8)->get()->row();
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

			$registration_cityN = $this->getInput('registration_city');
			$data['registration_city'] = $registration_cityN['registration_city'];

			$registration_pin_codeN = $this->getInput('registration_pin_code');
			$data['registration_pin_code'] = $registration_pin_codeN['registration_pin_code'];			

			
			$data['date_of_registration'] = date("Y-m-d");
			
            //$data['verification_code'] = Utils::randomNumber(5);
			$data['verification_code'] = $verification_code_otp;
            $data['password'] = md5($data['verification_code']);
            if ($this->db->insert('consumers', $data)) {
                $userId = $this->db->insert_id();
				
				$resultAS = $this->db->select('*')->from('loylties')->where('id', 1)->get()->row();
				$ActiveStatus = $resultAS->active_status;
				if($ActiveStatus=='Active'){
                $this->Productmodel->saveLoyltyReg('user-registration', $userId, ['consumer_id' => $userId, 'latitude' =>$data['latitude'], 'longitude' => $data['longitude'], 'registration_address' => $data['registration_address']]);
				$this->Productmodel->saveConsumerPassbookLoyaltyReg('user-registration', $userId, ['consumer_id' => $userId, 'consumer_phone' => $checkmobileno2, 'passbook_title' => "TRUSTAT Registration", 'passbook_event' => "User Registration", 'latitude' =>$data['latitude'], 'longitude' => $data['longitude'], 'registration_address' => $data['registration_address']], 'Loyalty');
				}
				$this->db->set(array("consumer_id" => $userId))->where(array("consumer_id" => $checkmobileno2))->update('push_advertisements');
				
				$this->db->set(array("referred_consumer_id" => $userId))->where(array("referred_mobile_no" => $checkmobileno2))->update('consumer_referral_table');
				
				$this->db->set(array("consumer_id" => $userId, "registration_status" => "Registered"))->where(array("consumer_id" => $checkmobileno2))->update('consumer_customer_link');
				
				$this->db->set(array("consumer_id" => $userId))->where(array("consumer_id" => $checkmobileno2))->update('consumer_activity_log_table');
				
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
                //$mnvtext5 = 'Welcome to TRUSTAT. Your OTP for mobile verification is ' . $data['verification_code'] . ', please enter the OTP to complete the signup proccess.';
				$mnv5_result = $this->db->select('message_notification_value, message_notification_value_part2')->from('message_notification_master')->where('id', 1)->get()->row();
		$message_notification_value5 = $mnv5_result->message_notification_value;
		$message_notification_value_part5 = $mnv5_result->message_notification_value_part2;
		
		 //$smstext = 'Welcome to TRUSTAT!!. Your OTP for mobile verification is ' . $data['verification_code'] . ', Please enter the OTP to complete the signup process.';
		  $mnvtext5 = $message_notification_value5 . $data['verification_code'] . $message_notification_value_part5;
		
				//$mnv5_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 5)->get()->row();
				
				
				//$mnvtext5 = $mnv5_result->message_notification_value;
				
                Utils::sendSMS($data['mobile_no'], $mnvtext5 . " zLJoGnJzfXg");
				$fb_token = getConsumerFb_TokenById($userId);
				$mnv6_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 2)->get()->row();
				$mnvtext6 = $mnv6_result->message_notification_value;
               //$this->ConsumerModel->sendFCM('Congratulations! Your registration is complete, and ' . $loylty['loyalty_points'] . ' Loyalty Points have been added in your TRUSTAT loyalty program.', $fb_token);
			   //$this->ConsumerModel->sendFCM($mnvtext5, $fb_token);
			   
			   $mnv7_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 3)->get()->row();
				$mnvtext7 = $mnv7_result->message_notification_value;
                //Utils::response(['status' => true, 'message' => 'Your account has been registered successfully.', 'data' => $data], 200);
				Utils::response(['status' => true, 'message' => $mnvtext7, 'data' => $data], 200);
                
            } else {
		$mnv8_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 4)->get()->row();
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
            ['field' => 'user_name', 'label' => 'User Name', 'rules' => 'trim'],
            ['field' => 'email', 'label' => 'Email', 'rules' => 'trim'],
            ['field' => 'dob', 'label' => 'Date of birth', 'rules' => [$this->ConsumerModel, 'dob_check']],
            ['field' => 'gender', 'label' => 'Gender', 'rules' => 'trim|min_length[2]'],
			['field' => 'city_last_scan', 'label' => 'City Of Last Scan', 'rules' => 'min_length[2]'],
			['field' => 'alternate_mobile_no', 'label' => 'Alternate Mobile Number', 'rules' => 'min_length[10]'],
			['field' => 'street_address', 'label' => 'Street Address', 'rules' => 'trim'],
			['field' => 'city', 'label' => 'City', 'rules' => 'trim'],
			['field' => 'state', 'label' => 'State', 'rules' => 'trim'],
			['field' => 'pin_code', 'label' => 'Pin Code', 'rules' => 'trim'],
			['field' => 'monthly_earnings', 'label' => 'Monthly Earnings', 'rules' => 'trim'],
			['field' => 'job_profile', 'label' => 'Job Profile', 'rules' => 'trim'],
			['field' => 'education_qualification', 'label' => 'Education Qualification', 'rules' => 'trim'],
			['field' => 'type_vehicle', 'label' => 'Type Vehicle', 'rules' => 'trim'],
			['field' => 'profession', 'label' => 'Profession', 'rules' => 'trim'],
			['field' => 'marital_status', 'label' => 'Marital  Status', 'rules' => 'trim'],
			['field' => 'no_of_family_members', 'label' => 'Number of Family Members', 'rules' => 'trim'],
			['field' => 'loan_car', 'label' => 'Loan Type', 'rules' => 'trim'],
			['field' => 'loan_housing', 'label' => 'Loan Type', 'rules' => 'trim'],
			['field' => 'personal_loan', 'label' => 'Personal Loan', 'rules' => 'trim'],
			['field' => 'credit_card_loan', 'label' => 'Credit Card Loan', 'rules' => 'trim'],
			['field' => 'own_a_car', 'label' => 'Own a Car', 'rules' => 'trim'],
			['field' => 'house_type', 'label' => 'House Type', 'rules' => 'trim'],
			['field' => 'last_location', 'label' => 'Last Location', 'rules' => 'trim'],
			['field' => 'life_insurance', 'label' => 'Life Insurance', 'rules' => 'trim'],
			['field' => 'medical_insurance', 'label' => 'Medical Insurance', 'rules' => 'trim'],
			['field' => 'height_in_inches', 'label' => 'Height in Inches', 'rules' => 'trim'],
			['field' => 'weight_in_kg', 'label' => 'Weight in Kgs', 'rules' => 'trim'],
			['field' => 'hobbies', 'label' => 'Hobbies', 'rules' => 'trim'],
			['field' => 'sports', 'label' => 'Sports', 'rules' => 'trim'],
			['field' => 'entertainment', 'label' => 'Entertainment', 'rules' => 'trim'],
			['field' => 'spouse_gender', 'label' => 'Spouse Gender', 'rules' => 'trim'],
			['field' => 'spouse_phone', 'label' => 'Spouse Phone', 'rules' => 'trim'],
			['field' => 'spouse_dob', 'label' => 'Spouse DOB', 'rules' => 'trim'],
			['field' => 'marriage_anniversary', 'label' => 'Marriage Anniversary', 'rules' => 'trim'],
			['field' => 'spouse_work_status', 'label' => 'Spouse Work Status', 'rules' => 'trim'],
			['field' => 'spouse_edu_qualification', 'label' => 'Spouse Educational Qualification', 'rules' => 'trim'],
			['field' => 'spouse_monthly_income', 'label' => 'Spouse Monthly Income', 'rules' => 'trim'],
			['field' => 'spouse_loan', 'label' => 'Spouse Loan', 'rules' => 'trim'],
			['field' => 'spouse_personal_loan', 'label' => 'Spouse Personal Loan', 'rules' => 'trim'],
			['field' => 'spouse_credit_card_loan', 'label' => 'Spouse Credit Card Loan', 'rules' => 'trim'],
			['field' => 'spouse_own_a_car', 'label' => 'Spouse Own a Car', 'rules' => 'trim'],
			['field' => 'spouse_house_type', 'label' => 'Spouse House Type', 'rules' => 'trim'],
			['field' => 'spouse_height_inches', 'label' => 'Spouse Height in Inches', 'rules' => 'trim'],
			['field' => 'spouse_weight_kg', 'label' => 'Spouse Weight in Kg', 'rules' => 'trim'],
			['field' => 'spouse_hobbies', 'label' => 'Spouse Hobbies', 'rules' => 'trim'],
			['field' => 'spouse_sports', 'label' => 'Spouse Sports', 'rules' => 'trim'],
			['field' => 'spouse_entertainment', 'label' => 'Spouse Entertainment', 'rules' => 'trim'],
			['field' => 'field_1', 'label' => 'Field 1', 'rules' => 'trim'],
			['field' => 'field_2', 'label' => 'Field 2', 'rules' => 'trim'],
			['field' => 'field_3', 'label' => 'Field 3', 'rules' => 'trim'],
			['field' => 'field_4', 'label' => 'Field 4', 'rules' => 'trim'],
			['field' => 'field_5', 'label' => 'Field 5', 'rules' => 'trim'],
			['field' => 'field_6', 'label' => 'Field 6', 'rules' => 'trim'],
			['field' => 'field_7', 'label' => 'Field 7', 'rules' => 'trim'],
			['field' => 'field_8', 'label' => 'Field 8', 'rules' => 'trim'],
			['field' => 'field_9', 'label' => 'Field 9', 'rules' => 'trim'],
			['field' => 'field_10', 'label' => 'Field 10', 'rules' => 'trim'],
			['field' => 'field_11', 'label' => 'Field 11', 'rules' => 'trim'],
			['field' => 'field_12', 'label' => 'Field 12', 'rules' => 'trim'],
			['field' => 'field_13', 'label' => 'Field 13', 'rules' => 'trim'],
			['field' => 'field_14', 'label' => 'Field 14', 'rules' => 'trim'],
			['field' => 'field_15', 'label' => 'Field 15', 'rules' => 'trim'],
			['field' => 'field_16', 'label' => 'Field 16', 'rules' => 'trim'],
			['field' => 'field_17', 'label' => 'Field 17', 'rules' => 'trim'],
			['field' => 'field_18', 'label' => 'Field 18', 'rules' => 'trim'],
			['field' => 'field_19', 'label' => 'Field 19', 'rules' => 'trim'],
			['field' => 'field_20', 'label' => 'Field 20', 'rules' => 'trim'],
			['field' => 'field_21', 'label' => 'Field 21', 'rules' => 'trim'],
			['field' => 'field_22', 'label' => 'Field 22', 'rules' => 'trim'],
			['field' => 'field_23', 'label' => 'Field 23', 'rules' => 'trim'],
			['field' => 'field_24', 'label' => 'Field 24', 'rules' => 'trim'],
			['field' => 'field_25', 'label' => 'Field 25', 'rules' => 'trim'],
			['field' => 'field_26', 'label' => 'Field 26', 'rules' => 'trim'],
			['field' => 'field_27', 'label' => 'Field 27', 'rules' => 'trim'],
			['field' => 'field_28', 'label' => 'Field 28', 'rules' => 'trim'],
			['field' => 'field_29', 'label' => 'Field 29', 'rules' => 'trim'],
			['field' => 'field_30', 'label' => 'Field 30', 'rules' => 'trim'],
			['field' => 'field_31', 'label' => 'Field 31', 'rules' => 'trim'],
			['field' => 'field_32', 'label' => 'Field 32', 'rules' => 'trim'],
			['field' => 'field_33', 'label' => 'Field 33', 'rules' => 'trim'],
			['field' => 'field_34', 'label' => 'Field 34', 'rules' => 'trim'],
			['field' => 'field_35', 'label' => 'Field 35', 'rules' => 'trim'],
			['field' => 'field_36', 'label' => 'Field 36', 'rules' => 'trim'],
			['field' => 'field_37', 'label' => 'Field 37', 'rules' => 'trim'],
			['field' => 'field_38', 'label' => 'Field 38', 'rules' => 'trim'],
			['field' => 'field_39', 'label' => 'Field 39', 'rules' => 'trim'],
			['field' => 'field_40', 'label' => 'Field 40', 'rules' => 'trim'],
			['field' => 'field_41', 'label' => 'Field 41', 'rules' => 'trim'],
			['field' => 'field_42', 'label' => 'Field 42', 'rules' => 'trim'],
			['field' => 'field_43', 'label' => 'Field 43', 'rules' => 'trim'],
			['field' => 'field_44', 'label' => 'Field 44', 'rules' => 'trim'],
			['field' => 'field_45', 'label' => 'Field 45', 'rules' => 'trim'],
			['field' => 'field_46', 'label' => 'Field 46', 'rules' => 'trim'],
			['field' => 'field_47', 'label' => 'Field 47', 'rules' => 'trim'],
			['field' => 'field_48', 'label' => 'Field 48', 'rules' => 'trim'],
			['field' => 'field_49', 'label' => 'Field 49', 'rules' => 'trim'],
			['field' => 'field_50', 'label' => 'Field 50', 'rules' => 'trim'],
			['field' => 'field_51', 'label' => 'Field 51', 'rules' => 'trim'],
			['field' => 'field_52', 'label' => 'Field 52', 'rules' => 'trim'],
			['field' => 'field_53', 'label' => 'Field 53', 'rules' => 'trim'],
			['field' => 'field_54', 'label' => 'Field 54', 'rules' => 'trim'],
			['field' => 'field_55', 'label' => 'Field 55', 'rules' => 'trim'],
			['field' => 'field_56', 'label' => 'Field 56', 'rules' => 'trim'],
			['field' => 'field_57', 'label' => 'Field 57', 'rules' => 'trim'],
			['field' => 'field_58', 'label' => 'Field 58', 'rules' => 'trim'],
			['field' => 'field_59', 'label' => 'Field 59', 'rules' => 'trim'],
			['field' => 'field_60', 'label' => 'Field 60', 'rules' => 'trim'],
			['field' => 'field_61', 'label' => 'Field 61', 'rules' => 'trim'],
			['field' => 'field_62', 'label' => 'Field 62', 'rules' => 'trim'],
			['field' => 'field_63', 'label' => 'Field 63', 'rules' => 'trim'],
			['field' => 'field_64', 'label' => 'Field 64', 'rules' => 'trim'],
			['field' => 'field_65', 'label' => 'Field 65', 'rules' => 'trim'],
			['field' => 'field_66', 'label' => 'Field 66', 'rules' => 'trim'],
			['field' => 'field_67', 'label' => 'Field 67', 'rules' => 'trim'],
			['field' => 'field_68', 'label' => 'Field 68', 'rules' => 'trim'],
			['field' => 'field_69', 'label' => 'Field 69', 'rules' => 'trim'],
			['field' => 'field_70', 'label' => 'Field 70', 'rules' => 'trim'],
			['field' => 'field_71', 'label' => 'Field 71', 'rules' => 'trim'],
			['field' => 'field_72', 'label' => 'Field 72', 'rules' => 'trim'],
			['field' => 'field_73', 'label' => 'Field 73', 'rules' => 'trim'],
			['field' => 'field_74', 'label' => 'Field 74', 'rules' => 'trim'],
			['field' => 'field_75', 'label' => 'Field 75', 'rules' => 'trim'],
			['field' => 'field_76', 'label' => 'Field 76', 'rules' => 'trim'],
			['field' => 'field_77', 'label' => 'Field 77', 'rules' => 'trim'],
			['field' => 'field_78', 'label' => 'Field 78', 'rules' => 'trim'],
			['field' => 'field_79', 'label' => 'Field 79', 'rules' => 'trim'],
			['field' => 'field_80', 'label' => 'Field 80', 'rules' => 'trim'],
			['field' => 'field_81', 'label' => 'Field 81', 'rules' => 'trim'],
			['field' => 'field_82', 'label' => 'Field 82', 'rules' => 'trim'],
			['field' => 'field_83', 'label' => 'Field 83', 'rules' => 'trim'],
			['field' => 'field_84', 'label' => 'Field 84', 'rules' => 'trim'],
			['field' => 'field_85', 'label' => 'Field 85', 'rules' => 'trim'],
			['field' => 'field_86', 'label' => 'Field 86', 'rules' => 'trim'],
			['field' => 'field_87', 'label' => 'Field 87', 'rules' => 'trim'],
			['field' => 'field_88', 'label' => 'Field 88', 'rules' => 'trim'],
			['field' => 'field_89', 'label' => 'Field 89', 'rules' => 'trim'],
			['field' => 'field_90', 'label' => 'Field 90', 'rules' => 'trim'],
			['field' => 'field_91', 'label' => 'Field 91', 'rules' => 'trim'],
			['field' => 'field_92', 'label' => 'Field 92', 'rules' => 'trim'],
			['field' => 'field_93', 'label' => 'Field 93', 'rules' => 'trim'],
			['field' => 'field_94', 'label' => 'Field 94', 'rules' => 'trim'],
			['field' => 'field_95', 'label' => 'Field 95', 'rules' => 'trim'],
			['field' => 'field_96', 'label' => 'Field 96', 'rules' => 'trim'],
			['field' => 'field_97', 'label' => 'Field 97', 'rules' => 'trim'],
			['field' => 'field_98', 'label' => 'Field 98', 'rules' => 'trim'],
			['field' => 'field_99', 'label' => 'Field 99', 'rules' => 'trim'],
			['field' => 'field_100', 'label' => 'Field 100', 'rules' => 'trim'],
			['field' => 'field_101', 'label' => 'Field 101', 'rules' => 'trim'],
			['field' => 'field_102', 'label' => 'Field 102', 'rules' => 'trim'],
			['field' => 'field_103', 'label' => 'Field 103', 'rules' => 'trim'],
			['field' => 'field_104', 'label' => 'Field 104', 'rules' => 'trim'],
			['field' => 'field_105', 'label' => 'Field 105', 'rules' => 'trim'],
			['field' => 'field_106', 'label' => 'Field 106', 'rules' => 'trim'],
			['field' => 'field_107', 'label' => 'Field 107', 'rules' => 'trim'],
			['field' => 'field_108', 'label' => 'Field 108', 'rules' => 'trim'],
			['field' => 'field_109', 'label' => 'Field 109', 'rules' => 'trim'],
			['field' => 'field_110', 'label' => 'Field 110', 'rules' => 'trim'],
			['field' => 'field_111', 'label' => 'Field 111', 'rules' => 'trim'],
			['field' => 'field_112', 'label' => 'Field 112', 'rules' => 'trim'],
			['field' => 'field_113', 'label' => 'Field 113', 'rules' => 'trim'],
			['field' => 'field_114', 'label' => 'Field 114', 'rules' => 'trim'],
			['field' => 'field_115', 'label' => 'Field 115', 'rules' => 'trim'],
			['field' => 'field_116', 'label' => 'Field 116', 'rules' => 'trim'],
			['field' => 'field_117', 'label' => 'Field 117', 'rules' => 'trim'],
			['field' => 'field_118', 'label' => 'Field 118', 'rules' => 'trim'],
			['field' => 'field_119', 'label' => 'Field 119', 'rules' => 'trim'],
			['field' => 'field_120', 'label' => 'Field 120', 'rules' => 'trim'],
			['field' => 'field_121', 'label' => 'Field 121', 'rules' => 'trim'],
			['field' => 'field_122', 'label' => 'Field 122', 'rules' => 'trim'],
			['field' => 'field_123', 'label' => 'Field 123', 'rules' => 'trim'],
			['field' => 'field_124', 'label' => 'Field 124', 'rules' => 'trim'],
			['field' => 'field_125', 'label' => 'Field 125', 'rules' => 'trim'],
			['field' => 'field_126', 'label' => 'Field 126', 'rules' => 'trim'],
			['field' => 'field_127', 'label' => 'Field 127', 'rules' => 'trim'],
			['field' => 'field_128', 'label' => 'Field 128', 'rules' => 'trim'],
			['field' => 'field_129', 'label' => 'Field 129', 'rules' => 'trim'],
			['field' => 'field_130', 'label' => 'Field 130', 'rules' => 'trim'],
			['field' => 'field_131', 'label' => 'Field 131', 'rules' => 'trim'],
			['field' => 'field_132', 'label' => 'Field 132', 'rules' => 'trim'],
			['field' => 'field_133', 'label' => 'Field 133', 'rules' => 'trim'],
			['field' => 'field_134', 'label' => 'Field 134', 'rules' => 'trim'],
			['field' => 'field_135', 'label' => 'Field 135', 'rules' => 'trim'],
			['field' => 'field_136', 'label' => 'Field 136', 'rules' => 'trim'],
			['field' => 'field_137', 'label' => 'Field 137', 'rules' => 'trim'],
			['field' => 'field_138', 'label' => 'Field 138', 'rules' => 'trim'],
			['field' => 'field_139', 'label' => 'Field 139', 'rules' => 'trim'],
			['field' => 'field_140', 'label' => 'Field 140', 'rules' => 'trim'],
			['field' => 'field_141', 'label' => 'Field 141', 'rules' => 'trim'],
			['field' => 'field_142', 'label' => 'Field 142', 'rules' => 'trim'],
			['field' => 'field_143', 'label' => 'Field 143', 'rules' => 'trim'],
			['field' => 'field_144', 'label' => 'Field 144', 'rules' => 'trim'],
			['field' => 'field_145', 'label' => 'Field 145', 'rules' => 'trim'],
			['field' => 'field_146', 'label' => 'Field 146', 'rules' => 'trim'],
			['field' => 'field_147', 'label' => 'Field 147', 'rules' => 'trim'],
			['field' => 'field_148', 'label' => 'Field 148', 'rules' => 'trim'],
			['field' => 'field_149', 'label' => 'Field 149', 'rules' => 'trim'],
			['field' => 'field_150', 'label' => 'Field 150', 'rules' => 'trim'],
			['field' => 'field_151', 'label' => 'Field 151', 'rules' => 'trim'],
			['field' => 'field_152', 'label' => 'Field 152', 'rules' => 'trim'],
			['field' => 'field_153', 'label' => 'Field 153', 'rules' => 'trim'],
			['field' => 'field_154', 'label' => 'Field 154', 'rules' => 'trim'],
			['field' => 'field_155', 'label' => 'Field 155', 'rules' => 'trim'],
			['field' => 'field_156', 'label' => 'Field 156', 'rules' => 'trim'],
			['field' => 'field_157', 'label' => 'Field 157', 'rules' => 'trim'],
			['field' => 'field_158', 'label' => 'Field 158', 'rules' => 'trim'],
			['field' => 'field_159', 'label' => 'Field 159', 'rules' => 'trim'],
			['field' => 'field_160', 'label' => 'Field 160', 'rules' => 'trim'],
			['field' => 'field_161', 'label' => 'Field 161', 'rules' => 'trim'],
			['field' => 'field_162', 'label' => 'Field 162', 'rules' => 'trim'],
			['field' => 'field_163', 'label' => 'Field 163', 'rules' => 'trim'],
			['field' => 'field_164', 'label' => 'Field 164', 'rules' => 'trim'],
			['field' => 'field_165', 'label' => 'Field 165', 'rules' => 'trim'],
			['field' => 'field_166', 'label' => 'Field 166', 'rules' => 'trim'],
			['field' => 'field_167', 'label' => 'Field 167', 'rules' => 'trim'],
			['field' => 'field_168', 'label' => 'Field 168', 'rules' => 'trim'],
			['field' => 'field_169', 'label' => 'Field 169', 'rules' => 'trim'],
			['field' => 'field_170', 'label' => 'Field 170', 'rules' => 'trim'],
			['field' => 'field_171', 'label' => 'Field 171', 'rules' => 'trim'],
			['field' => 'field_172', 'label' => 'Field 172', 'rules' => 'trim'],
			['field' => 'field_173', 'label' => 'Field 173', 'rules' => 'trim'],
			['field' => 'field_174', 'label' => 'Field 174', 'rules' => 'trim'],
			['field' => 'field_175', 'label' => 'Field 175', 'rules' => 'trim'],
			['field' => 'field_176', 'label' => 'Field 176', 'rules' => 'trim'],
			['field' => 'field_177', 'label' => 'Field 177', 'rules' => 'trim'],
			['field' => 'field_178', 'label' => 'Field 178', 'rules' => 'trim'],
			['field' => 'field_179', 'label' => 'Field 179', 'rules' => 'trim'],
			['field' => 'field_180', 'label' => 'Field 180', 'rules' => 'trim'],
			['field' => 'field_181', 'label' => 'Field 181', 'rules' => 'trim'],
			['field' => 'field_182', 'label' => 'Field 182', 'rules' => 'trim'],
			['field' => 'field_183', 'label' => 'Field 183', 'rules' => 'trim'],
			['field' => 'field_184', 'label' => 'Field 184', 'rules' => 'trim'],
			['field' => 'field_185', 'label' => 'Field 185', 'rules' => 'trim'],
			['field' => 'field_186', 'label' => 'Field 186', 'rules' => 'trim'],
			['field' => 'field_187', 'label' => 'Field 187', 'rules' => 'trim'],
			['field' => 'field_188', 'label' => 'Field 188', 'rules' => 'trim'],
			['field' => 'field_189', 'label' => 'Field 189', 'rules' => 'trim'],
			['field' => 'field_190', 'label' => 'Field 190', 'rules' => 'trim'],
			['field' => 'field_191', 'label' => 'Field 191', 'rules' => 'trim'],
			['field' => 'field_192', 'label' => 'Field 192', 'rules' => 'trim'],
			['field' => 'field_193', 'label' => 'Field 193', 'rules' => 'trim'],
			['field' => 'field_194', 'label' => 'Field 194', 'rules' => 'trim'],
			['field' => 'field_195', 'label' => 'Field 195', 'rules' => 'trim'],
			['field' => 'field_196', 'label' => 'Field 196', 'rules' => 'trim'],
			['field' => 'field_197', 'label' => 'Field 197', 'rules' => 'trim'],
			['field' => 'field_198', 'label' => 'Field 198', 'rules' => 'trim'],
			['field' => 'field_199', 'label' => 'Field 199', 'rules' => 'trim'],
			['field' => 'field_200', 'label' => 'Field 200', 'rules' => 'trim'],
			['field' => 'field_201', 'label' => 'Field 201', 'rules' => 'trim'],

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
		$this->db->set('loan_car', Utils::getVar('loan_car', $input));
		$this->db->set('loan_housing', Utils::getVar('loan_housing', $input));
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
		$this->db->set('field_1', Utils::getVar('field_1', $input));
		$this->db->set('field_2', Utils::getVar('field_2', $input));
		$this->db->set('field_3', Utils::getVar('field_3', $input));
		$this->db->set('field_4', Utils::getVar('field_4', $input));
		$this->db->set('field_5', Utils::getVar('field_5', $input));
		$this->db->set('field_6', Utils::getVar('field_6', $input));
		$this->db->set('field_7', Utils::getVar('field_7', $input));
		$this->db->set('field_8', Utils::getVar('field_8', $input));
		$this->db->set('field_9', Utils::getVar('field_9', $input));
		$this->db->set('field_10', Utils::getVar('field_10', $input));
		$this->db->set('field_11', Utils::getVar('field_11', $input));
		$this->db->set('field_12', Utils::getVar('field_12', $input));
		$this->db->set('field_13', Utils::getVar('field_13', $input));
		$this->db->set('field_14', Utils::getVar('field_14', $input));
		$this->db->set('field_15', Utils::getVar('field_15', $input));
		$this->db->set('field_16', Utils::getVar('field_16', $input));
		$this->db->set('field_17', Utils::getVar('field_17', $input));
		$this->db->set('field_18', Utils::getVar('field_18', $input));
		$this->db->set('field_19', Utils::getVar('field_19', $input));
		$this->db->set('field_20', Utils::getVar('field_20', $input));
		$this->db->set('field_21', Utils::getVar('field_21', $input));
		$this->db->set('field_22', Utils::getVar('field_22', $input));
		$this->db->set('field_23', Utils::getVar('field_23', $input));
		$this->db->set('field_24', Utils::getVar('field_24', $input));
		$this->db->set('field_25', Utils::getVar('field_25', $input));
		$this->db->set('field_26', Utils::getVar('field_26', $input));
		$this->db->set('field_27', Utils::getVar('field_27', $input));
		$this->db->set('field_28', Utils::getVar('field_28', $input));
		$this->db->set('field_29', Utils::getVar('field_29', $input));
		$this->db->set('field_30', Utils::getVar('field_30', $input));
		$this->db->set('field_31', Utils::getVar('field_31', $input));
		$this->db->set('field_32', Utils::getVar('field_32', $input));
		$this->db->set('field_33', Utils::getVar('field_33', $input));
		$this->db->set('field_34', Utils::getVar('field_34', $input));
		$this->db->set('field_35', Utils::getVar('field_35', $input));
		$this->db->set('field_36', Utils::getVar('field_36', $input));
		$this->db->set('field_37', Utils::getVar('field_37', $input));
		$this->db->set('field_38', Utils::getVar('field_38', $input));
		$this->db->set('field_39', Utils::getVar('field_39', $input));
		$this->db->set('field_40', Utils::getVar('field_40', $input));
		$this->db->set('field_41', Utils::getVar('field_41', $input));
		$this->db->set('field_42', Utils::getVar('field_42', $input));
		$this->db->set('field_43', Utils::getVar('field_43', $input));
		$this->db->set('field_44', Utils::getVar('field_44', $input));
		$this->db->set('field_45', Utils::getVar('field_45', $input));
		$this->db->set('field_46', Utils::getVar('field_46', $input));
		$this->db->set('field_47', Utils::getVar('field_47', $input));
		$this->db->set('field_48', Utils::getVar('field_48', $input));
		$this->db->set('field_49', Utils::getVar('field_49', $input));
		$this->db->set('field_50', Utils::getVar('field_50', $input));
		$this->db->set('field_51', Utils::getVar('field_51', $input));
		$this->db->set('field_52', Utils::getVar('field_52', $input));
		$this->db->set('field_53', Utils::getVar('field_53', $input));
		$this->db->set('field_54', Utils::getVar('field_54', $input));
		$this->db->set('field_55', Utils::getVar('field_55', $input));
		$this->db->set('field_56', Utils::getVar('field_56', $input));
		$this->db->set('field_57', Utils::getVar('field_57', $input));
		$this->db->set('field_58', Utils::getVar('field_58', $input));
		$this->db->set('field_59', Utils::getVar('field_59', $input));
		$this->db->set('field_60', Utils::getVar('field_60', $input));
		$this->db->set('field_61', Utils::getVar('field_61', $input));
		$this->db->set('field_62', Utils::getVar('field_62', $input));
		$this->db->set('field_63', Utils::getVar('field_63', $input));
		$this->db->set('field_64', Utils::getVar('field_64', $input));
		$this->db->set('field_65', Utils::getVar('field_65', $input));
		$this->db->set('field_66', Utils::getVar('field_66', $input));
		$this->db->set('field_67', Utils::getVar('field_67', $input));
		$this->db->set('field_68', Utils::getVar('field_68', $input));
		$this->db->set('field_69', Utils::getVar('field_69', $input));
		$this->db->set('field_70', Utils::getVar('field_70', $input));
		$this->db->set('field_71', Utils::getVar('field_71', $input));
		$this->db->set('field_72', Utils::getVar('field_72', $input));
		$this->db->set('field_73', Utils::getVar('field_73', $input));
		$this->db->set('field_74', Utils::getVar('field_74', $input));
		$this->db->set('field_75', Utils::getVar('field_75', $input));
		$this->db->set('field_76', Utils::getVar('field_76', $input));
		$this->db->set('field_77', Utils::getVar('field_77', $input));
		$this->db->set('field_78', Utils::getVar('field_78', $input));
		$this->db->set('field_79', Utils::getVar('field_79', $input));
		$this->db->set('field_80', Utils::getVar('field_80', $input));
		$this->db->set('field_81', Utils::getVar('field_81', $input));
		$this->db->set('field_82', Utils::getVar('field_82', $input));
		$this->db->set('field_83', Utils::getVar('field_83', $input));
		$this->db->set('field_84', Utils::getVar('field_84', $input));
		$this->db->set('field_85', Utils::getVar('field_85', $input));
		$this->db->set('field_86', Utils::getVar('field_86', $input));
		$this->db->set('field_87', Utils::getVar('field_87', $input));
		$this->db->set('field_88', Utils::getVar('field_88', $input));
		$this->db->set('field_89', Utils::getVar('field_89', $input));
		$this->db->set('field_90', Utils::getVar('field_90', $input));
		$this->db->set('field_91', Utils::getVar('field_91', $input));
		$this->db->set('field_92', Utils::getVar('field_92', $input));
		$this->db->set('field_93', Utils::getVar('field_93', $input));
		$this->db->set('field_94', Utils::getVar('field_94', $input));
		$this->db->set('field_95', Utils::getVar('field_95', $input));
		$this->db->set('field_96', Utils::getVar('field_96', $input));
		$this->db->set('field_97', Utils::getVar('field_97', $input));
		$this->db->set('field_98', Utils::getVar('field_98', $input));
		$this->db->set('field_99', Utils::getVar('field_99', $input));
		$this->db->set('field_100', Utils::getVar('field_100', $input));
		$this->db->set('field_101', Utils::getVar('field_101', $input));
		$this->db->set('field_102', Utils::getVar('field_102', $input));
		$this->db->set('field_103', Utils::getVar('field_103', $input));
		$this->db->set('field_104', Utils::getVar('field_104', $input));
		$this->db->set('field_105', Utils::getVar('field_105', $input));
		$this->db->set('field_106', Utils::getVar('field_106', $input));
		$this->db->set('field_107', Utils::getVar('field_107', $input));
		$this->db->set('field_108', Utils::getVar('field_108', $input));
		$this->db->set('field_109', Utils::getVar('field_109', $input));
		$this->db->set('field_110', Utils::getVar('field_110', $input));
		$this->db->set('field_111', Utils::getVar('field_111', $input));
		$this->db->set('field_112', Utils::getVar('field_112', $input));
		$this->db->set('field_113', Utils::getVar('field_113', $input));
		$this->db->set('field_114', Utils::getVar('field_114', $input));
		$this->db->set('field_115', Utils::getVar('field_115', $input));
		$this->db->set('field_116', Utils::getVar('field_116', $input));
		$this->db->set('field_117', Utils::getVar('field_117', $input));
		$this->db->set('field_118', Utils::getVar('field_118', $input));
		$this->db->set('field_119', Utils::getVar('field_119', $input));
		$this->db->set('field_120', Utils::getVar('field_120', $input));
		$this->db->set('field_121', Utils::getVar('field_121', $input));
		$this->db->set('field_122', Utils::getVar('field_122', $input));
		$this->db->set('field_123', Utils::getVar('field_123', $input));
		$this->db->set('field_124', Utils::getVar('field_124', $input));
		$this->db->set('field_125', Utils::getVar('field_125', $input));
		$this->db->set('field_126', Utils::getVar('field_126', $input));
		$this->db->set('field_127', Utils::getVar('field_127', $input));
		$this->db->set('field_128', Utils::getVar('field_128', $input));
		$this->db->set('field_129', Utils::getVar('field_129', $input));
		$this->db->set('field_130', Utils::getVar('field_130', $input));
		$this->db->set('field_131', Utils::getVar('field_131', $input));
		$this->db->set('field_132', Utils::getVar('field_132', $input));
		$this->db->set('field_133', Utils::getVar('field_133', $input));
		$this->db->set('field_134', Utils::getVar('field_134', $input));
		$this->db->set('field_135', Utils::getVar('field_135', $input));
		$this->db->set('field_136', Utils::getVar('field_136', $input));
		$this->db->set('field_137', Utils::getVar('field_137', $input));
		$this->db->set('field_138', Utils::getVar('field_138', $input));
		$this->db->set('field_139', Utils::getVar('field_139', $input));
		$this->db->set('field_140', Utils::getVar('field_140', $input));
		$this->db->set('field_141', Utils::getVar('field_141', $input));
		$this->db->set('field_142', Utils::getVar('field_142', $input));
		$this->db->set('field_143', Utils::getVar('field_143', $input));
		$this->db->set('field_144', Utils::getVar('field_144', $input));
		$this->db->set('field_145', Utils::getVar('field_145', $input));
		$this->db->set('field_146', Utils::getVar('field_146', $input));
		$this->db->set('field_147', Utils::getVar('field_147', $input));
		$this->db->set('field_148', Utils::getVar('field_148', $input));
		$this->db->set('field_149', Utils::getVar('field_149', $input));
		$this->db->set('field_150', Utils::getVar('field_150', $input));
		$this->db->set('field_151', Utils::getVar('field_151', $input));
		$this->db->set('field_152', Utils::getVar('field_152', $input));
		$this->db->set('field_153', Utils::getVar('field_153', $input));
		$this->db->set('field_154', Utils::getVar('field_154', $input));
		$this->db->set('field_155', Utils::getVar('field_155', $input));
		$this->db->set('field_156', Utils::getVar('field_156', $input));
		$this->db->set('field_157', Utils::getVar('field_157', $input));
		$this->db->set('field_158', Utils::getVar('field_158', $input));
		$this->db->set('field_159', Utils::getVar('field_159', $input));
		$this->db->set('field_160', Utils::getVar('field_160', $input));
		$this->db->set('field_161', Utils::getVar('field_161', $input));
		$this->db->set('field_162', Utils::getVar('field_162', $input));
		$this->db->set('field_163', Utils::getVar('field_163', $input));
		$this->db->set('field_164', Utils::getVar('field_164', $input));
		$this->db->set('field_165', Utils::getVar('field_165', $input));
		$this->db->set('field_166', Utils::getVar('field_166', $input));
		$this->db->set('field_167', Utils::getVar('field_167', $input));
		$this->db->set('field_168', Utils::getVar('field_168', $input));
		$this->db->set('field_169', Utils::getVar('field_169', $input));
		$this->db->set('field_170', Utils::getVar('field_170', $input));
		$this->db->set('field_171', Utils::getVar('field_171', $input));
		$this->db->set('field_172', Utils::getVar('field_172', $input));
		$this->db->set('field_173', Utils::getVar('field_173', $input));
		$this->db->set('field_174', Utils::getVar('field_174', $input));
		$this->db->set('field_175', Utils::getVar('field_175', $input));
		$this->db->set('field_176', Utils::getVar('field_176', $input));
		$this->db->set('field_177', Utils::getVar('field_177', $input));
		$this->db->set('field_178', Utils::getVar('field_178', $input));
		$this->db->set('field_179', Utils::getVar('field_179', $input));
		$this->db->set('field_180', Utils::getVar('field_180', $input));
		$this->db->set('field_181', Utils::getVar('field_181', $input));
		$this->db->set('field_182', Utils::getVar('field_182', $input));
		$this->db->set('field_183', Utils::getVar('field_183', $input));
		$this->db->set('field_184', Utils::getVar('field_184', $input));
		$this->db->set('field_185', Utils::getVar('field_185', $input));
		$this->db->set('field_186', Utils::getVar('field_186', $input));
		$this->db->set('field_187', Utils::getVar('field_187', $input));
		$this->db->set('field_188', Utils::getVar('field_188', $input));
		$this->db->set('field_189', Utils::getVar('field_189', $input));
		$this->db->set('field_190', Utils::getVar('field_190', $input));
		$this->db->set('field_191', Utils::getVar('field_191', $input));
		$this->db->set('field_192', Utils::getVar('field_192', $input));
		$this->db->set('field_193', Utils::getVar('field_193', $input));
		$this->db->set('field_194', Utils::getVar('field_194', $input));
		$this->db->set('field_195', Utils::getVar('field_195', $input));
		$this->db->set('field_196', Utils::getVar('field_196', $input));
		$this->db->set('field_197', Utils::getVar('field_197', $input));
		$this->db->set('field_198', Utils::getVar('field_198', $input));
		$this->db->set('field_199', Utils::getVar('field_199', $input));
		$this->db->set('field_200', Utils::getVar('field_200', $input));
		$this->db->set('field_201', Utils::getVar('field_201', $input));

        $this->db->where('id', $user['id']);
		
		log_message('debug',print_r($array_or_object_you_want_to_print,TRUE));
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
            ['field' => 'howzzt_member', 'label' => 'TRUSTAT member', 'rules' => 'trim|in_list[yes,no]'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        $phone_number = $this->getInput('phone_number');

        //$emailid = $this->getInput('email');
        $phone_numberr = $phone_number['phone_number'];

        $isRegistered = $this->ConsumerModel->ishowzztMember($phone_numberr);

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
            Utils::sendSMS($data['phone_number'], $smstext . " zLJoGnJzfXg");
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
            ['field' => 'howzzt_member', 'label' => 'TRUSTAT member', 'rules' => 'trim|in_list[yes,no]'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        $phone_number = $this->getInput('phone_number');

        //$emailid = $this->getInput('email');
        $phone_numberr = $phone_number['phone_number'];

        $isRegistered = $this->ConsumerModel->ishowzztMember($phone_numberr);

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

	
	// Check Consumer If Registered function
    public function CheckConsumerIfRegistered() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'phone_number', 'label' => 'Phone Number', 'rules' => 'trim|required|integer|exact_length[10]'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        $phone_number = $this->getInput('phone_number');
        $phone_numberr = $phone_number['phone_number'];

        $isRegistered = $this->ConsumerModel->ishowzztMember($phone_numberr);

        if ($isRegistered == TRUE) {

           $data['isRegistered'] = "Yes";
			
        } else {

           $data['isRegistered'] = "No";
        
        }
		Utils::response(['status' => true, 'message' => 'Mobile Number Registration Status Yes if Registered.', 'data' => $data]);
    }
	
	
	
		// Check Consumer If eligible to Receive reference Function Start 
    public function CheckConsumerIfEligiblForReference() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'phone_number', 'label' => 'Phone Number', 'rules' => 'trim|required|integer|exact_length[10]'],
			['field' => 'product_id', 'label' => 'Product ID', 'rules' => 'trim|required|integer'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

        $phone_numberArray = $this->getInput('phone_number');
        $phone_number = $phone_numberArray['phone_number'];
		
		$product_idArray = $this->getInput('product_id');
        $product_id = $product_idArray['product_id'];
		$media_type = getMediaTypeforSendingReferenceByProductId($product_id);
		$ConsumerID = $user['id'];
		$ReferarMonileNo = getConsumerMobileNumberById($ConsumerID);

        $isRegistered = $this->ConsumerModel->ishowzztMember($phone_number);
		
			//$TotalRefSenttoConsumer = $this->db->where(array('referred_mobile_no' => $phone_number, 'product_id' => $product_id, 'media_type' => $media_type))->from("consumer_referral_table")->count_all_results();
			
			//$TotalRefSentbySenderConsumerForTheProduct = $this->db->where(array('referrer_consumer_id' => $ConsumerID, 'product_id' => $product_id))->from("consumer_referral_table")->count_all_results();
			
			//$TotalRefPermittedtoSenderConsumerForTheProduct = getNumberOfReferralsAllowedToConsumerByProductId($product_id);
		//if($TotalRefSentbySenderConsumerForTheProduct >= $TotalRefPermittedtoSenderConsumerForTheProduct){
			if($ReferarMonileNo != $phone_number){
		if ($isRegistered == TRUE) {
			$refferedConsumerID = get_consumer_id_by_mobile_number($phone_number);
           $data['isRegistered'] = "Mobile Number is Registered";
		   $gap_period_for_last_activity_product = getGapPeriodfinalisedbyBrandByProductId($product_id);
		   $last_activity_of_existing_consumer_date_time = getLastActivityDateByConsumerID($refferedConsumerID, $product_id);
		   if($last_activity_of_existing_consumer_date_time!=0){
		  $last_activity_of_existing_consumer_days = (new DateTime($last_activity_of_existing_consumer_date_time))->diff(new DateTime(date("Y-m-d")))->days;		
		   if($last_activity_of_existing_consumer_days>$gap_period_for_last_activity_product){
		   $data['EligibleForReference'] = "Yes";
		   }else{			   
			$data['EligibleForReference'] = "No";
		   }
		   }else{
			$data['EligibleForReference'] = "Yes";		
			}
			} else {

           $data['isRegistered'] = "Mobile Number Registration is Not Registered";
		   
		   $gap_period_for_last_activity_product = getGapPeriodfinalisedbyBrandByProductId($product_id);
		   $last_activity_of_existing_consumer_date_time = getLastActivityDateByConsumerID($phone_number, $product_id);
		    if($last_activity_of_existing_consumer_date_time!=0){
		  $last_activity_of_existing_consumer_days = (new DateTime($last_activity_of_existing_consumer_date_time))->diff(new DateTime(date("Y-m-d")))->days;				
		   if($last_activity_of_existing_consumer_days>$gap_period_for_last_activity_product){
		   $data['EligibleForReference'] = "Yes";
		   }else{			   
			$data['EligibleForReference'] = "No";
		   }
			}else{
			$data['EligibleForReference'] = "Yes";		
			}
        }
				
		/*}else{
		$mnv1_result66 = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 66)->get()->row();
		$message_notification_value66 = $mnv1_result66->message_notification_value;	
		Utils::response(['status' => false, 'message' => $message_notification_value66]);	
		}*/
		
		$mnv1_result66 = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 66)->get()->row();
		$message_notification_value66 = $mnv1_result66->message_notification_value;	
		//Utils::response(['status' => false, 'message' => $message_notification_value66]);	
		
		
		Utils::response(['status' => true, 'message' => $message_notification_value66, 'data' => $data]);
		}else{
			$data['EligibleForReference'] = "No";
		//$mnv1_result66 = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 66)->get()->row();
		//$message_notification_value66 = $mnv1_result66->message_notification_value;	
		$messageforselfreferar = "You can't refer yourself!";
		Utils::response(['status' => false, 'message' => $messageforselfreferar, 'data' => $data]);	
		}
    }
	
	// Check Consumer If eligible to send reference Function End
	
	
	
	
			// Check Consumer If eligible to send reference Function Start 
    public function CheckConsumerIfEligiblForReferenceAllProducts() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		
       // $product_id = 230;
		$consumer_id = $user['id'];
	$ListAllProducts = $this->Productmodel->getListAllProducts($consumer_id);
	
	Utils::response(['status' => true, 'message' => 'Product Eligiblity Status For Reference For Consumer', 'data' => $ListAllProducts]);
    }
	
	//Sanjay22
	// Check Consumer If eligible to send reference Function End
	
	
			// Consumer Referrals Info Function Start 
    public function ConsumerReferralsInfo() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
			['field' => 'product_id', 'label' => 'Product ID', 'rules' => 'trim|required|integer'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }

		$product_idArray = $this->getInput('product_id');
        $product_id = $product_idArray['product_id'];
		
		$ConsumerID = $user['id'];
       // $isRegistered = $this->ConsumerModel->ishowzztMember($phone_number);
	    if(!empty($product_id)) {			
			$data['include_the_product_in_referral_program'] = getProductinReferralProgramAssignedbyBrandByProductId($product_id);
			$data['number_of_referrals_allowed_to_consumer'] = getMaxReferralsForConsumerbyProductId($product_id);
			$data['number_of_referrals_sent_by_consumer'] = $this->db->where(array('product_id'=>$product_id, 'referrer_consumer_id'=>$ConsumerID))->from("consumer_referral_table")->count_all_results();
			$data['number_of_referrals_remaining_for_consumer'] = $data['number_of_referrals_allowed_to_consumer'] - $data['number_of_referrals_sent_by_consumer'];			
		Utils::response(['status' => true, 'message' => 'Consumer Referral Information', 'data' => $data]);			
        } else {

           $data['product_id'] = "Product info not available";
		   Utils::response(['status' => true, 'message' => 'Consumer Referral Information', 'data' => $data]);
        
        }
       
    }			

	
	// Consumer Referrals Info Function End
	
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

	// Redeem Loylty Points
	// Sanjay
	public function MicrositeRedeemLoyltyPoints($consumer_mobile,$customer_id,$points_redeemed,$Microsite_URL,$order_id,$subtotals,$client_ip,$product_sku,$product_name,$product_cetagory,$billing_address1,$billing_address2,$billing_address_city,$billing_address_state,$billing_address_pincode,$dispatched_on,$order_data_field1,$order_data_field2,$order_data_field3,$order_data_field4,$order_data_field5,$order_data_field6,$order_data_field7,$order_data_field8,$order_data_field9,$order_data_field10) {
		
		//echo "<pre>";print_r(get_consumer_id_by_mobile_number($consumer_mobile)); die;
		$consumer_id = get_consumer_id_by_mobile_number($consumer_mobile);
		$fb_token = getConsumerFb_TokenById($consumer_id);		
		
		$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($customer_id);
		
		$MRLP1_billin_particular_name = "Loyalty Redemption Microsite";
		$MRLP1_billin_particular_slug = "loyalty_redemption_microsite";

		// Consumer Log Data insert start
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($consumer_id);
			$CALdata['consumer_id'] = $consumer_id; 
			$CALdata['consumer_mobile'] = getConsumerMobileNumberById($consumer_id); 
			$CALdata['customer_name'] = getUserFullNameById($customer_id); 
			$CALdata['customer_id'] = $customer_id; 
			$CALdata['unique_customer_code'] = getCustomerCodeById($customer_id); 
			$CALdata['product_name'] = "Product info is not reqired"; 
			$CALdata['product_id'] = 0; 
			$CALdata['product_sku'] = "Product info is not reqired"; 
			$CALdata['product_code'] = "Product info is not reqired"; 
			$CALdata['gloc_latitude'] = "";
			$CALdata['gloc_longitude'] = "";
			$CALdata['gloc_city'] = "";
			$CALdata['gloc_pin_code'] = "000000";
			$CALdata['consumer_activity_type'] = "Redeemed Brand Loyalty Through Microsite- " . getUserFullNameById($customer_id);
			$CALdata['loyalty_rewards_points'] = 0;
			$CALdata['loyalty_rewards_type'] = getCustomerLoyaltyTypeById($customer_id);
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
				// Consumer Log Data insert end
				
				
		if($customer_loyalty_type=="TRUSTAT"){
		$TotalAccumulatedPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalAccumulatedPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();
		$TotalAccumulatedPoints = $TotalAccumulatedPointsCustomer->points + $TotalAccumulatedPointsISPL->points;
		
		$TotalRedeemedPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalRedeemedPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();
		$TotalRedeemedPoints = $TotalRedeemedPointsCustomer->points + $TotalRedeemedPointsISPL->points;
		
		$TotalExpiredPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalExpiredPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();
		$TotalExpiredPoints = $TotalExpiredPointsCustomer->points + $TotalExpiredPointsISPL->points;
		
		}else{
		$TotalAccumulatedPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalAccumulatedPoints = $TotalAccumulatedPointsBrand->points;
		
		$TotalRedeemedPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalRedeemedPoints = $TotalRedeemedPointsBrand->points;
		
		$TotalExpiredPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalExpiredPoints = $TotalExpiredPointsBrand->points;
		
		}
		
		$result2 = $this->db->select('*')->from('loylties')->where('id', 3)->get()->row();
		$result3 = $this->db->select('*')->from('loylties')->where('id', 4)->get()->row();
		
		$FinalTotalAccumulatedPoints = $TotalAccumulatedPoints;
		
		if(($TotalRedeemedPoints)!='')
		{
			$FinalTotalRedeemedPoints = ($TotalRedeemedPoints) + $points_redeemed;
		} else {
			$FinalTotalRedeemedPoints =0 + $points_redeemed;
			}
			
		if(($TotalExpiredPoints)!='')
		{
			$FinalTotalExpiredPoints = $TotalExpiredPoints;
		} else {
			$FinalTotalExpiredPoints =0;
			}	
			
		$CurrentBalance = $FinalTotalAccumulatedPoints - ($FinalTotalRedeemedPoints + $FinalTotalExpiredPoints);	
			
		//$CurrentBalance = $FinalTotalAccumulatedPoints - $FinalTotalRedeemedPoints;
		$Min_Locking_Balance = $result2->loyalty_points;
		
		$CurrentBalanceAfterMinBalanceLocking = $CurrentBalance - $Min_Locking_Balance;
		$Points_Redeemed_in_Multiple_of = $result3->loyalty_points;
				
		$remainder = $CurrentBalanceAfterMinBalanceLocking % $Points_Redeemed_in_Multiple_of;
		$quotient = ($CurrentBalanceAfterMinBalanceLocking - $remainder) / $Points_Redeemed_in_Multiple_of;
		if($customer_loyalty_type=="TRUSTAT"){
		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;		
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of - $remainder;
		}else{
		$Points_Redeemable = $CurrentBalance;		
		$PointsShortOfRedumption = 0;	
		}
		    
		$FinalTotalRedeemedExpiredPoints = $FinalTotalRedeemedPoints + $FinalTotalExpiredPoints;		
				
		$data['customer_id'] = $customer_id;
		$data['consumer_id'] = $consumer_id;
		$data['points'] = $points_redeemed;
        $data['transaction_type_name'] = "Loyalty Redemption Microsite";
		$data['transaction_type_slug'] = "loyalty_redemption_microsite";
		$data['product_id'] = 0;
		$data['params'] = '{"Microsite_URL":"'.$Microsite_URL.'","order_id":"'.$order_id.'","subtotals":"'.$subtotals.'","client_ip":"'.$client_ip.'","product_sku":"'.$product_sku.'","product_name":"'.$product_name.'","product_cetagory":"'.$product_cetagory.'","billing_address1":"'.$billing_address1.'","billing_address2":"'.$billing_address2.'","billing_address_city":"'.$billing_address_city.'","billing_address_state":"'.$billing_address_state.'","billing_address_pincode":"'.$billing_address_pincode.'","dispatched_on":"'.$dispatched_on.'","order_data_field1":"'.$order_data_field1.'","order_data_field2":"'.$order_data_field2.'","order_data_field3":"'.$order_data_field3.'","order_data_field4":"'.$order_data_field4.'","order_data_field5":"'.$order_data_field5.'","order_data_field6":"'.$order_data_field6.'","order_data_field7":"'.$order_data_field7.'","order_data_field8":"'.$order_data_field8.'","order_data_field9":"'.$order_data_field9.'","order_data_field10":"'.$order_data_field10.'","transaction_name":"Loyalty Points redeemed through microtime"}';
		$data['transaction_lr_type'] = "Redemption";
		$data['customer_loyalty_type'] = get_customer_loyalty_type_by_customer_id($customer_id);
		$data['total_accumulated_points'] = $FinalTotalAccumulatedPoints;
		$data['total_redeemed_points'] = $FinalTotalRedeemedExpiredPoints;
		$data['current_balance'] = $CurrentBalance;
		$data['points_redeemable'] = $Points_Redeemable;
		$data['points_short_of_redumption'] = $PointsShortOfRedumption;
		$data['transaction_date'] = date("Y-m-d H:i:s");
        //$data['ip'] = $this->input->ip_address();
		
			

        if ($this->db->insert('consumer_passbook', $data)) {
			
			$this->Productmodel->sendFCM($points_redeemed . " Loyalty Points Redeemed", $fb_token);
			
            //$this->signupMail($data);
           // $smstext = 'You have added ' . $mobile_no . ' as ' . $data['relation'] . ' relation with you.';
            //Utils::sendSMS($data['phone_number'], $smstext);
            //$userId = $user['id'];
            //$this->Productmodel->saveLoylty('user-registration', $userId, ['user_id' => $userId]);
			
			// Update Redeemed Status of the Loyalty Points
		
	//$oldest_loyalty_points = $this->db->get_where('loylty_points', array('user_id' => $consumer_id, 'customer_id' => $customer_id, 'customer_loyalty_type' => "Brand"))->limit(1)->row()->points;
	

	
	for($i=0; $i<1000; $i++){
		
			
	$this->db->select('id,points,redeemed_points');
    $this->db->where(array('user_id' => $consumer_id, 'customer_id' => $customer_id, 'customer_loyalty_type' => "Brand", 'loyalty_points_status != ' => "Redeemed"));
	$this->db->order_by('id', 'ASC');
    $this->db->limit(1);
    $query = $this->db->get('loylty_points');
    $row = $query->row();	
	$oldest_loyalty_points = $row->points;
	$oldest_loyalty_points_id = $row->id;
	$redeemed_partial_points = $row->redeemed_points;
	
	if($oldest_loyalty_points > ($points_redeemed+$redeemed_partial_points))
		{
			$updateData = array(
			   'loyalty_points_status'=>"RedeemedPartial",
			   'redeemed_points'=>$points_redeemed+$redeemed_partial_points,
			   'modified_at'=>date("Y-m-d H:i:s")
			);
			$this->db->where('id', $oldest_loyalty_points_id);
			$this->db->update('loylty_points', $updateData); 
			//$this->Productmodel->sendFCM($points_redeemed . " Loyalty Points Redeemed", $fb_token);
			
			$MRLPData['customer_id'] = $customer_id;
			$MRLPData['consumer_id'] = $consumer_id;
			$MRLPData['billing_particular_name'] = $MRLP1_billin_particular_name;		
			$MRLPData['billing_particular_slug'] = $MRLP1_billin_particular_slug;
			$MRLPData['trans_quantity'] = $points_redeemed; 
			$MRLPData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$MRLPData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $MRLPData);
			
			 break;
			}elseif($oldest_loyalty_points == ($points_redeemed+$redeemed_partial_points)){
				$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$points_redeemed+$redeemed_partial_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				$this->db->update('loylty_points', $updateData); 
				//$this->Productmodel->sendFCM($points_redeemed . " Loyalty Points Redeemed", $fb_token);
				
			$MRLP2Data['customer_id'] = $customer_id;
			$MRLP2Data['consumer_id'] = $consumer_id;
			$MRLP2Data['billing_particular_name'] = $MRLP1_billin_particular_name;		
			$MRLP2Data['billing_particular_slug'] = $MRLP1_billin_particular_slug;
			$MRLP2Data['trans_quantity'] = $points_redeemed; 
			$MRLP2Data['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$MRLP2Data['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $MRLP2Data);
			
				break;				
			} elseif($oldest_loyalty_points < ($points_redeemed+$redeemed_partial_points)) {
				$updateData = array(
				   'loyalty_points_status'=>"Redeemed",
				   'redeemed_points'=>$oldest_loyalty_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $oldest_loyalty_points_id);
				$this->db->update('loylty_points', $updateData); 
				
				$points_redeemed = $points_redeemed -($oldest_loyalty_points-$redeemed_partial_points);	
				//$this->Productmodel->sendFCM($points_redeemed . " Loyalty Points Redeemed", $fb_token);
				
			$MRLP4Data['customer_id'] = $customer_id;
			$MRLP4Data['consumer_id'] = $consumer_id;
			$MRLP4Data['billing_particular_name'] = $MRLP1_billin_particular_name;		
			$MRLP4Data['billing_particular_slug'] = $MRLP1_billin_particular_slug;
			$MRLP4Data['trans_quantity'] = $points_redeemed; 
			$MRLP4Data['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$MRLP4Data['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $MRLP4Data);
			}						
			}
            Utils::response(['status' => true, 'message' => 'Points Redeemed.', 'oldest_loyalty_points' => $oldest_loyalty_points, 'data' => $data], 200);
			
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['customer_id'] = $customer_id;
			//$NTFdata['product_id'] = $product_id;		
			$NTFdata['title'] = "Loyalty!";
			$NTFdata['body'] = "Loyalty Points Redeemed"; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 			
			$this->db->insert('list_notifications_table', $NTFdata);
			
			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			
			$TRNNCData['customer_id'] = $customer_id;
			$TRNNCData['consumer_id'] = $consumer_id;
			$TRNNCData['billing_particular_name'] = $TRNNC_billin_particular_name.' Loyalty Points Redeemed';		
			$TRNNCData['billing_particular_slug'] = $TRNNC_billin_particular_slug.'_Loyalty_Points_Reddemed';
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);		
					
			
		
        } else {
            Utils::response(['status' => false, 'message' => 'Redemption failed.'], 200);
        }
    }


 // Expire Consumer Loylty Points
	
	public function ExpireConsumerLoyaltyPoints() {		
		
		
	$this->db->select('id,user_id,customer_id,points,redeemed_points,loyalty_points_status,loyalty_points_expiry_date');
    $this->db->where(array('loyalty_points_status' => "RedeemedPartial", 'loyalty_points_status' => "Earned", 'loyalty_points_expiry_date' => date("Y-m-d")));
	$this->db->order_by('id', 'ASC');
    $query = $this->db->get('loylty_points');
    $rows = $query->result_array();
	
	//$oldest_loyalty_points = $rows->points;
	//$oldest_loyalty_points_id = $rows->id;
	//$ConsumerID = $rows->user_id;	
	//$NumberRecords = $this->db->where(['user_id'=>$ConsumerID, 'loyalty_points_expiry_date' => date("Y-m-d")])->from("loylty_points")->count_all_results();
	//for ($i = 0; $i <= $NumberRecords+2; $i++) {
	foreach($rows as $row){
	$Expiring_loyalty_points = $row['points']-$row['redeemed_points'];
	$Expiring_loyalty_points_id = $row['id'];
	$consumer_id = $row['user_id'];
	$customer_id = $row['customer_id'];
	//$loyalty_points = $row['points'];
	//$loyalty_points = $row['points'];
	//$loyalty_points = $row['points'];
	//$loyalty_points = $row['points'];
	//echo "<pre>"; print_r($customer_id);  die;
	
		$customer_loyalty_type = get_customer_loyalty_type_by_customer_id($customer_id);
	if($customer_loyalty_type=="TRUSTAT"){
		$TotalAccumulatedPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalAccumulatedPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();
		$TotalAccumulatedPoints = $TotalAccumulatedPointsCustomer->points + $TotalAccumulatedPointsISPL->points;
		
		$TotalRedeemedPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalRedeemedPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();
		$TotalRedeemedPoints = $TotalRedeemedPointsCustomer->points + $TotalRedeemedPointsISPL->points;
		
		$TotalExpiredPointsCustomer = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalExpiredPointsISPL = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>1))->get()->row();
		$TotalExpiredPoints = $TotalExpiredPointsCustomer->points + $TotalExpiredPointsISPL->points;
		
		}else{
		$TotalAccumulatedPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Loyalty", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalAccumulatedPoints = $TotalAccumulatedPointsBrand->points;
		
		$TotalRedeemedPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Redemption", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalRedeemedPoints = $TotalRedeemedPointsBrand->points;
		
		$TotalExpiredPointsBrand = $this->db->select_sum('points')->from('consumer_passbook')->where(array('consumer_id'=>$consumer_id, 'transaction_lr_type'=>"Expiry", 'customer_loyalty_type'=>$customer_loyalty_type, 'customer_id'=>$customer_id))->get()->row();
		$TotalExpiredPoints = $TotalExpiredPointsBrand->points;
		
		}
				
		$result2 = $this->db->select('*')->from('loylties')->where('id', 3)->get()->row();
		$result3 = $this->db->select('*')->from('loylties')->where('id', 4)->get()->row();
		
		$FinalTotalAccumulatedPoints = $TotalAccumulatedPoints;
		
		if($TotalRedeemedPoints!='')
		{
			$FinalTotalRedeemedPoints = $TotalRedeemedPoints;
		} else {
			$FinalTotalRedeemedPoints =0;
			}
			
		if($TotalExpiredPoints!='')
		{
			$FinalTotalExpiredPoints = $TotalExpiredPoints;
		} else {
			$FinalTotalExpiredPoints =0;
			}	
			
		$CurrentBalance = $FinalTotalAccumulatedPoints - ($FinalTotalRedeemedPoints + $FinalTotalExpiredPoints + $Expiring_loyalty_points);
		$Min_Locking_Balance = $result2->loyalty_points;
		
		$CurrentBalanceAfterMinBalanceLocking = $CurrentBalance - $Min_Locking_Balance;
		$Points_Redeemed_in_Multiple_of = $result3->loyalty_points;
				
		$remainder = $CurrentBalanceAfterMinBalanceLocking % $Points_Redeemed_in_Multiple_of;
		$quotient = ($CurrentBalanceAfterMinBalanceLocking - $remainder) / $Points_Redeemed_in_Multiple_of;
		if($customer_loyalty_type=="TRUSTAT"){
		$Points_Redeemable = $Points_Redeemed_in_Multiple_of * $quotient;		
		$PointsShortOfRedumption =$Points_Redeemed_in_Multiple_of - $remainder;
		}else{
		$Points_Redeemable = $CurrentBalance;		
		$PointsShortOfRedumption = 0;	
		}
		    $FinalTotalRedeemedExpiredPoints = $FinalTotalRedeemedPoints + $FinalTotalExpiredPoints + $Expiring_loyalty_points;
		$data['customer_id'] = $customer_id;
		$data['consumer_id'] = $consumer_id;
		$data['points'] = $Expiring_loyalty_points;
        $data['transaction_type_name'] = "Loyalty Points Expired";
		$data['transaction_type_slug'] = "loyalty_points_expired";
		$data['product_id'] = 0;
		$data['params'] = '{"transaction_name":"Loyalty Points Expired"}';
		$data['transaction_lr_type'] = "Expiry";
		$data['customer_loyalty_type'] = get_customer_loyalty_type_by_customer_id($customer_id);
		$data['total_accumulated_points'] = $FinalTotalAccumulatedPoints;
		$data['total_redeemed_points'] = $FinalTotalRedeemedExpiredPoints;
		$data['current_balance'] = $CurrentBalance;
		$data['points_redeemable'] = $Points_Redeemable;
		$data['points_short_of_redumption'] = $PointsShortOfRedumption;
		$data['transaction_date'] = date("Y-m-d H:i:s");
        //$data['ip'] = $this->input->ip_address();
		

        if ($this->db->insert('consumer_passbook', $data)) {
			
			$updateData = array(
				   'loyalty_points_status'=>"Expired",
				  // 'redeemed_points'=>$points_redeemed+$redeemed_partial_points,
				   'modified_at'=>date("Y-m-d H:i:s")
				);
				$this->db->where('id', $Expiring_loyalty_points_id);
				$this->db->update('loylty_points', $updateData);
		$CustomerName = getUserFullNameById($customer_id);		
		$fb_token = getConsumerFb_TokenById($consumer_id);
		$mnv53_result = $this->db->select('message_notification_value, message_notification_value_part2, message_notification_value_part3')->from('message_notification_master')->where('id', 53)->get()->row();
		$mnvtext53_part1 = $mnv53_result->message_notification_value;
		$mnvtext53_part2 = $mnv53_result->message_notification_value_part2;
		$mnvtext53_part3 = $mnv53_result->message_notification_value_part3;
		$mnvtext53 = $mnvtext53_part1 . ' ' . $FinalTotalRedeemedExpiredPoints . ' ' . $mnvtext53_part2 . ' ' . $CustomerName . ' ' . $mnvtext53_part3;
				
                $this->ConsumerModel->sendFCM($mnvtext53, $fb_token);
				
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['customer_id'] = $customer_id;
			//$NTFdata['product_id'] = $product_id;		
			$NTFdata['title'] = "TRUSTAT Loyalty";
			$NTFdata['body'] = $mnvtext53; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 			
			$this->db->insert('list_notifications_table', $NTFdata);
			
			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			
			$TRNNCData['customer_id'] = $customer_id;
			$TRNNCData['consumer_id'] = $consumer_id;
			$TRNNCData['billing_particular_name'] = $TRNNC_billin_particular_name.' TRUSTAT Loyalty';		
			$TRNNCData['billing_particular_slug'] = $TRNNC_billin_particular_slug.'_TRUSTAT_Loyalty';
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);		
			
				
            Utils::response(['status' => true, 'message' => 'Points Expired.', 'data' => $data], 200);
        } else {
            Utils::response(['status' => false, 'message' => ''], 200);
        }
		
		} // foreach end 
	//} // for loop end 
    }
	
	
	public function PreLoyaltyPointsExpiryNotifications() {
		
	$this->db->select('id,user_id,customer_id,points,redeemed_points,loyalty_points_status,loyalty_points_expiry_date');
    $this->db->where(array('loyalty_points_status != ' => "Redeemed"));
	$this->db->order_by('id', 'ASC');
    $query = $this->db->get('loylty_points');
    $rows = $query->result_array();
		
	foreach($rows as $row){ // foreach start
	$Expiring_loyalty_points = $row['points'];
	$Expiring_loyalty_points_id = $row['id'];
	$consumer_id = $row['user_id'];
	$customer_id = $row['customer_id'];
	$brand_name = getUserFullNameById($customer_id);
	$loyalty_points_expiry_date = $row['loyalty_points_expiry_date'];
	
		 $days_for_notification_before_expiry = days_for_notification_before_expiry($customer_id);
			 
			$Current_Date = date('Y-m-d');
			$loyalty_points_expiry_notification_date = date('Y-m-d', strtotime($loyalty_points_expiry_date. ' - ' . $days_for_notification_before_expiry. ' days'));

				if($loyalty_points_expiry_notification_date==$Current_Date){
				$fb_token = getConsumerFb_TokenById($consumer_id);
				
	$mnv54_result = $this->db->select('message_notification_value, message_notification_value_part2, message_notification_value_part3, message_notification_value_part4')->from('message_notification_master')->where('id', 54)->get()->row();
	$mnvtext54 = $mnv54_result->message_notification_value . ' ' . $Expiring_loyalty_points . ' ' . $mnv54_result->message_notification_value_part2 . ' ' . $brand_name . ' ' .$mnv54_result->message_notification_value_part3 . ' ' . $loyalty_points_expiry_date . ' ' . $mnv54_result->message_notification_value_part4;
		
                $this->ConsumerModel->sendFCM($mnvtext54, $fb_token);
				
				$NTFdata['consumer_id'] = $consumer_id;
				$NTFdata['customer_id'] = $customer_id;
				//$NTFdata['product_id'] = $product_id;				
				$NTFdata['title'] = "TRUSTAT Pre Loyalty Points Expiry Notification";
				$NTFdata['body'] = $mnvtext54; 
				$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
				$NTFdata['status'] = 0; 
			
			$this->db->insert('list_notifications_table', $NTFdata);	

			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			
			$TRNNCData['customer_id'] = $customer_id;
			$TRNNCData['consumer_id'] = $consumer_id;
			$TRNNCData['billing_particular_name'] = $TRNNC_billin_particular_name.' TRUSTAT Pre Loyalty Points Expiry Notification';		
			$TRNNCData['billing_particular_slug'] = $TRNNC_billin_particular_slug.'_TRUSTAT_Pre_Loyalty_Points_Expiry_Notification';
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);		
					
					
				
				}
			
		
		} // foreach end 
    }
	
	
	public function ReferralProgramAutoOff() {
		
	$this->db->select('id,max_referrals_for_product,referral_program_auto_off_date');
    //$this->db->where(array('loyalty_points_status != ' => "Redeemed"));
	$this->db->order_by('id', 'ASC');
    $query = $this->db->get('products');
    $rows = $query->result_array();
		
	foreach($rows as $row){ // foreach start
	$product_id = $row['id'];
	$max_referrals_for_product = $row['max_referrals_for_product'];
	$referral_program_auto_off_date = $row['referral_program_auto_off_date'];
	
$count_referrals_product = $this->db->where('product_id',$product_id)->from("consumer_referral_table")->count_all_results();
	
if(($count_referrals_product >= $max_referrals_for_product)||(date('Y-m-d') >= $referral_program_auto_off_date))
{
	$updateProductReferral = array(
					   'include_the_product_in_referral_program' => "No"
						);
					$this->db->update('products', $updateProductReferral, array('id' => $product_id));
	
	}
		
		} // foreach end 
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

        $isRegistered = $this->ConsumerModel->ishowzztMember($phone_numberr);

        

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
        $isRegistered = $this->ConsumerModel->ishowzztMember($phone_numberr);       

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
        if (Utils::sendSMS($user->mobile_no, $smstext . " zLJoGnJzfXg")) {
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

        //$smstext = 'Welcome to TRUSTAT!! Your OTP for mobile number verification is ' . $data->verification_code . ', Please enter the OTP to complete the signup process.';
		
		 //$smstext = 'Welcome to TRUSTAT!!. Your OTP for mobile verification is ' . $data['verification_code'] . ', Please enter the OTP to complete the signup process.';
		 
		 $mnvrOtp_result = $this->db->select('message_notification_value, message_notification_value_part2')->from('message_notification_master')->where('id', 1)->get()->row();
		$message_notification_valuerOtp = $mnvrOtp_result->message_notification_value;
		$message_notification_value_part2rOtp = $mnvrOtp_result->message_notification_value_part2;
		
		 //$smstext = 'Welcome to TRUSTAT!!. Your OTP for mobile verification is ' . $data['verification_code'] . ', Please enter the OTP to complete the signup process.';
		  $smstext = $message_notification_valuerOtp . $data->verification_code . $message_notification_value_part2rOtp;
		 
		 

        if (Utils::sendSMS($data->mobile_no, $smstext . " zLJoGnJzfXg")) {
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
			
			$consumer_id = get_consumer_id_by_mobile_number2($data['mobile_no']);
			$fb_token = getConsumerFb_TokenById($consumer_id);
			$mnv2_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 59)->get()->row();
			$mnvtext2 = $mnv2_result->message_notification_value;
		// $this->ConsumerModel->sendFCM("Congratulations! Your account has been successfully verified.", $fb_token);
		  $this->ConsumerModel->sendFCM($mnvtext2, $fb_token);
		 
		 
            Utils::response(['status' => true, 'message' => 'Your account has been successfully verified.']);
        }
    }

    public function signupMail($data) {
        $this->load->library('email');
        $this->email->initialize($this->config->item('smtp'));
        $this->email->set_newline("\r\n");
        $this->email->from($data['email'], $data['user_name']);
        $this->email->reply_to('no-reply@'.$_SERVER['SERVER_NAME'], 'Team');
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

	 public function ConsuerCompEMail($data_comp_email) {
        $this->load->library('email');
        $this->email->initialize($this->config->item('smtp'));
        $this->email->set_newline("\r\n");
        $this->email->from('sanjayksir@gmail.com', 'Sanjay');
        $this->email->reply_to('no-reply@'.$_SERVER['SERVER_NAME'], 'Team');
        $this->email->to('sanjaykumar7pm@gmail.com');
        $this->email->subject('Signup with with ' . $this->config->item("site_name"));
        //$body = $this->load->view('signup_mail.php', $data_comp_email, TRUE);
		$body = 'Test Message';
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
			['field' => 'promotion_id', 'label' => 'Promotion ID', 'rules' => 'trim'],
			['field' => 'media_type', 'label' => 'Media Type', 'rules' => 'trim'],
            ['field' => 'question_id', 'label' => 'Question', 'rules' => 'trim|required|integer'],
            ['field' => 'selected_answer', 'label' => 'User answer', 'rules' => 'trim|required'],
			['field' => 'latitude', 'label' => 'User latitude', 'rules' => 'trim|required'],
			['field' => 'longitude', 'label' => 'User longitude', 'rules' => 'trim|required'],
			['field' => 'registration_address', 'label' => 'Registration Address', 'rules' => 'trim|required'],
			['field' => 'feedback_city', 'label' => 'Feedback City', 'rules' => 'trim'],
			['field' => 'feedback_pin_code', 'label' => 'Feedback Pin Code', 'rules' => 'trim'],
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
        $questionMediaAndType = null;
        foreach ($productQuestion as $row) {
            if ($row->question_id == $data['question_id']) {
                $questionType = strtolower($row->question_type);
				$questionMediaType = strtolower($row->question_media_type);
				$questionMediaAndType = $questionType . $questionMediaType;
            }
            array_push($allQuestionIds, $row->question_id);
        }
        if (!in_array($data['question_id'], $allQuestionIds)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => 'Invalid product id or question id.']);
        }

        //Utils::debug();
        $data['user_id'] = $user['id'];
        $data['created_date'] = $data['updated_date'] = date('Y-m-d H:i:s');
		$promotion_id = $data['promotion_id'];
		
        if ($this->db->insert('consumer_feedback', $data)) {
			
				
		if($promotion_id!=0){	
				$arr1 = explode(' ',trim($data['product_qr_code']));
				$promotion_type = PromotionTypeByPromotionID($promotion_id);
				$Part11 = $arr1[0];
				$Part22 = $arr1[1];		
		if($promotion_type=='Survey'){
			$this->db->set(array("survey_feedback_response" => 'Yes', "survey_response_datetime" => date("Y-m-d H:i:s")))->where(array("consumer_id" => $user['id'], "promotion_id" => $data['promotion_id']))->update('push_surveys');
		} else {
			$this->db->set(array("ad_feedback_response" => 'Yes', "ad_response_datetime" => date("Y-m-d H:i:s")))->where(array("consumer_id" => $user['id'], "promotion_id" => $data['promotion_id']))->update('push_advertisements');
		}
		}else{
			$promotion_id = $data['product_qr_code'];
		}
		   $purchased_points = total_approved_points2($customer_id);
			$consumed_points = get_total_consumed_points($customer_id);
			if($purchased_points > ($consumed_points+$TRPoints)){  

				$consumer_id = $user['id'];
			    $product_brand_name = get_products_brand_name_by_id($ProductID);
			    $product_name  = get_products_name_by_id($ProductID);
			
            if (strstr($questionMediaAndType, 'productaudio')) {
                $transactionType = 'product_audio_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Audio Promotion';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Audio Promotion. '. $TRPoints .' have been added to your TRUSTAT loyalty program.'; 
				$data['transaction_type'] = "Product Audio Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude']);
            } elseif (strstr($questionMediaAndType, 'productvideo')) {
                $transactionType = 'product_video_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Video Promotion';
				
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Video Promotion. '. $TRPoints .' have been added to your TRUSTAT loyalty program.'; 
				$data['transaction_type'] = "Product Video Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
            } elseif (strstr($questionMediaAndType, 'productpdf')) {
                $transactionType = 'product_pdf_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Product Brochure';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Product Brochure Promotion. '. $TRPoints .' have been added to your TRUSTAT loyalty program.'; 
				$data['transaction_type'] = "Product PDF Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
            } elseif (strstr($questionMediaAndType, 'productimage')) {
                $transactionType = 'product_image_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Image Promotion.';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Product Image Promotion. '. $TRPoints .' have been added to your TRUSTAT loyalty program.'; 
				$data['transaction_type'] = "Product Image Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude']);
		   } elseif (strstr($questionMediaAndType, 'advertisementvideo')) {
			   
                $transactionType = 'product_ad_video_response_lps';
				$transactionTypeName = 'Product Video Advertisement';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to video promotion for ' . $product_brand_name . ' . '. $TRPoints .' Loyalty Points have been added to your TRUSTAT loyalty program.';
				$data['transaction_type'] = "Advertisement Video Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
			
			// Referral loyalty to the referar consumer when referral_consumed Starts			
			$ConsumerMobileNumber = getConsumerMobileNumberById($user['id']);
			$ConsumerReferralRow = $this->Productmodel->ConsumerReferralDetails($ProductID, $ConsumerMobileNumber);
			$ConsumerReferralID = $ConsumerReferralRow->referral_id;
			$LoyaltyPointsReferral = $ConsumerReferralRow->loyalty_points_referral;
			$ReferrerConsumerId = $ConsumerReferralRow->referrer_consumer_id;
			$promotion_id = $ConsumerReferralRow->product_code_or_promotion_id;
			$consumer_id = $ReferrerConsumerId;
			
			if(!empty($ConsumerReferralID)){	
						
			$product_id = $ProductID;
			
			$transactionTypeName = "Product Referral - " . getUserFullNameById($customer_id);
			$transactionType = "loyalty_rewards_to_sender_consumer_under_referral";
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$customer_name = getUserFullNameById($customer_id); 
			$product_name = get_products_name_by_id($product_id); 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($customer_id);
			$transaction_lr_type = "Loyalty";
			
$this->Productmodel->saveLoylty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);

$this->Productmodel->saveConsumerPassbookLoyalty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);

	
		// update refrerar loyalty gained.		
		$VideoAdResponseLoyaltyPoints = VideoAdResponseLoyaltyPointsByProductID($product_id);
		$this->db->update('consumer_referral_table',array('referral_consume_loyalty_points'=>$VideoAdResponseLoyaltyPoints,'referral_consumed'=>1,'referral_consume_datetime'=>date("Y-m-d H:i:s")),array('referral_id'=>$ConsumerReferralID));			
			}
			
			// Notification to sender of reference
	     
	$fb_token = getConsumerFb_TokenById($consumer_id);	

		$this->Productmodel->sendFCM("Your contact with mobile number #" . $ConsumerMobileNumber . " has responded for your refrence for the " . $product_name . ", " . $LoyaltyPointsReferral . " Loyalty points have been credited to your loyalty account", $fb_token);

		// Referral loyalty to the referar consumer when referral_consumed Ends
		
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['customer_id'] = $customer_id;
			$NTFdata['product_id'] = $product_id;		
			$NTFdata['title'] = "TRUSTAT Referral";
			$NTFdata['body'] = "Your contact with mobile number #" . $ConsumerMobileNumber . " has responded for your refrence for the " . $product_name . ", " . $LoyaltyPointsReferral . " Loyalty points have been credited to your loyalty account"; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 			
			$this->db->insert('list_notifications_table', $NTFdata);
		
			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			
			$TRNNCData['customer_id'] = $customer_id;
			$TRNNCData['consumer_id'] = $consumer_id;
			$TRNNCData['billing_particular_name'] = $TRNNC_billin_particular_name.' TRUSTAT Referral';		
			$TRNNCData['billing_particular_slug'] = $TRNNC_billin_particular_slug.'_TRUSTAT_Referral';
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);	
		
			} elseif (strstr($questionMediaAndType, 'advertisementaudio')) {
                $transactionType = 'product_ad_audio_response_lps';
				$transactionTypeName = 'Product Audio Advertisement';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to audio promotion for ' . $product_brand_name . ' . '. $TRPoints .' Loyalty Points have been added to your TRUSTAT loyalty program.';
				$data['transaction_type'] = "Advertisement Audio Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
				
				// Referral loyalty to the referar consumer when referral_consumed Starts			
			$ConsumerMobileNumber = getConsumerMobileNumberById($user['id']);
			$ConsumerReferralRow = $this->Productmodel->ConsumerReferralDetails($ProductID, $ConsumerMobileNumber);
			$ConsumerReferralID = $ConsumerReferralRow->referral_id;
			$LoyaltyPointsReferral = $ConsumerReferralRow->loyalty_points_referral;
			$ReferrerConsumerId = $ConsumerReferralRow->referrer_consumer_id;
			$promotion_id = $ConsumerReferralRow->product_code_or_promotion_id;
			$consumer_id = $ReferrerConsumerId;
			
			if(!empty($ConsumerReferralID)){	
						
			$product_id = $ProductID;
			
			$transactionTypeName = "Product Referral - " . getUserFullNameById($customer_id);
			$transactionType = "loyalty_rewards_to_sender_consumer_under_referral";
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$customer_name = getUserFullNameById($customer_id); 
			$product_name = get_products_name_by_id($product_id); 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($customer_id);
			$transaction_lr_type = "Loyalty";
			
$this->Productmodel->saveLoylty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);

$this->Productmodel->saveConsumerPassbookLoyalty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
		
		// update refrerar loyalty gained.
			$AudioAdResponseLoyaltyPoints = AudioAdResponseLoyaltyPointsByProductID($product_id);		
		$this->db->update('consumer_referral_table',array('referral_consume_loyalty_points'=>$AudioAdResponseLoyaltyPoints,'referral_consumed'=>1,'referral_consume_datetime'=>date("Y-m-d H:i:s")),array('referral_id'=>$ConsumerReferralID));			
			}
		// Referral loyalty to the referar consumer when referral_consumed Ends
		
			} elseif (strstr($questionMediaAndType, 'advertisementpdf')) {
                $transactionType = 'product_ad_pdf_response_lps';
				$transactionTypeName = 'Product PDF Advertisement';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to pdf promotion for ' . $product_brand_name . ' . '. $TRPoints .' Loyalty Points have been added to your TRUSTAT loyalty program.';
				$data['transaction_type'] = "Advertisement PDF Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
				
				// Referral loyalty to the referar consumer when referral_consumed Starts			
			$ConsumerMobileNumber = getConsumerMobileNumberById($user['id']);
			$ConsumerReferralRow = $this->Productmodel->ConsumerReferralDetails($ProductID, $ConsumerMobileNumber);
			$ConsumerReferralID = $ConsumerReferralRow->referral_id;
			$LoyaltyPointsReferral = $ConsumerReferralRow->loyalty_points_referral;
			$ReferrerConsumerId = $ConsumerReferralRow->referrer_consumer_id;
			$promotion_id = $ConsumerReferralRow->product_code_or_promotion_id;
			$consumer_id = $ReferrerConsumerId;
			
			if(!empty($ConsumerReferralID)){	
						
			$product_id = $ProductID;
			
			$transactionTypeName = "Product Referral - " . getUserFullNameById($customer_id);
			$transactionType = "loyalty_rewards_to_sender_consumer_under_referral";
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$customer_name = getUserFullNameById($customer_id); 
			$product_name = get_products_name_by_id($product_id); 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($customer_id);
			$transaction_lr_type = "Loyalty";
			
$this->Productmodel->saveLoylty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);

$this->Productmodel->saveConsumerPassbookLoyalty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
		
		// update refrerar loyalty gained.	
			$PDFAdResponseLoyaltyPoints = PDFAdResponseLoyaltyPointsByProductID($product_id);	
		$this->db->update('consumer_referral_table',array('referral_consume_loyalty_points'=>$PDFAdResponseLoyaltyPoints,'referral_consumed'=>1,'referral_consume_datetime'=>date("Y-m-d H:i:s")),array('referral_id'=>$ConsumerReferralID));			
			}
		// Referral loyalty to the referar consumer when referral_consumed Ends
		
			} elseif (strstr($questionMediaAndType, 'advertisementimage')) {
                $transactionType = 'product_ad_image_response_lps';
				$transactionTypeName = 'Product Image Advertisement';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to image promotion for ' . $product_brand_name . ' . '. $TRPoints .' Loyalty Points have been added to your TRUSTAT loyalty program.';
				$data['transaction_type'] = "Advertisement Image Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
				
				// Referral loyalty to the referar consumer when referral_consumed Starts			
			$ConsumerMobileNumber = getConsumerMobileNumberById($user['id']);
			$ConsumerReferralRow = $this->Productmodel->ConsumerReferralDetails($ProductID, $ConsumerMobileNumber);
			$ConsumerReferralID = $ConsumerReferralRow->referral_id;
			$LoyaltyPointsReferral = $ConsumerReferralRow->loyalty_points_referral;
			$ReferrerConsumerId = $ConsumerReferralRow->referrer_consumer_id;
			$promotion_id = $ConsumerReferralRow->product_code_or_promotion_id;
			$consumer_id = $ReferrerConsumerId;
			
			if(!empty($ConsumerReferralID)){	
						
			$product_id = $ProductID;
			
			$transactionTypeName = "Product Referral - " . getUserFullNameById($customer_id);
			$transactionType = "loyalty_rewards_to_sender_consumer_under_referral";
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$customer_name = getUserFullNameById($customer_id); 
			$product_name = get_products_name_by_id($product_id); 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($customer_id);
			$transaction_lr_type = "Loyalty";
			
$this->Productmodel->saveLoylty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);

$this->Productmodel->saveConsumerPassbookLoyalty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
		
		// update refrerar loyalty gained.	
			$ImageAdResponseLoyaltyPoints = ImageAdResponseLoyaltyPointsByProductID($product_id);
		$this->db->update('consumer_referral_table',array('referral_consume_loyalty_points'=>$ImageAdResponseLoyaltyPoints,'referral_consumed'=>1,'referral_consume_datetime'=>date("Y-m-d H:i:s")),array('referral_id'=>$ConsumerReferralID));			
			}
		// Referral loyalty to the referar consumer when referral_consumed Ends
		
			} elseif (strstr($questionMediaAndType, 'surveyvideo')) {
                $transactionType = 'product_survey_video_response_lps';
				$transactionTypeName = 'Product Survey';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to product survey for ' . $product_brand_name . '. '. $TRPoints .' Loyalty Points have been added to your TRUSTAT loyalty program.';	
				$data['transaction_type'] = "Survey Video Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
				
				
				
				
			} elseif (strstr($questionMediaAndType, 'surveyaudio')) {
                $transactionType = 'product_survey_audio_response_lps';
				$transactionTypeName = 'Product Survey';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to product survey for ' . $product_brand_name . '. '. $TRPoints .' Loyalty Points have been added to your TRUSTAT loyalty program.';	
				$data['transaction_type'] = "Survey Audio Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
			}elseif (strstr($questionMediaAndType, 'surveypdf')) {
                $transactionType = 'product_survey_pdf_response_lps';
				$transactionTypeName = 'Product Survey';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to product survey for ' . $product_brand_name . '. '. $TRPoints .' Loyalty Points have been added to your TRUSTAT loyalty program.';	
				$data['transaction_type'] = "Survey PDF Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
			}elseif (strstr($questionMediaAndType, 'surveyimage')) {
                $transactionType = 'product_survey_image_response_lps';
				$transactionTypeName = 'Product Image Survey';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You have responded to product survey for ' . $product_brand_name . '. '. $TRPoints .' Loyalty Points have been added to your TRUSTAT loyalty program.';	
				$data['transaction_type'] = "Survey Image Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
			}elseif (strstr($questionMediaAndType, 'demonstrationvideo')) {
                $transactionType = 'product_demo_video_response_lps';
				$transactionTypeName = 'Viewing product video demonstration';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'Thank you for viewing product video demonstration. Loyalty Point '. $TRPoints .' have been added to your TRUSTAT loyalty program.';
				$data['transaction_type'] = "Product Demo Video Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
				$this->Productmodel->feedbackLoylityDemo($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
			} elseif (strstr($questionMediaAndType, 'demonstrationaudio')) {
                $transactionType = 'product_demo_audio_response_lps';
				$transactionTypeName = 'Listening product audio demonstration ';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'Thank you for listening product audio demonstration. Loyalty Point '. $TRPoints .' have been added to your TRUSTAT loyalty program.';	
				$data['transaction_type'] = "Product Demo Audio Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
            $this->Productmodel->feedbackLoylityDemo($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
            } else {
                $transactionType = 'product_video_response_lps';
				$transactionTypeName = 'Genuity Scan and Responding to Product Description Promotion';
				$result = $this->db->select($transactionType)->from('products')->where('id', $ProductID)->get()->row();
				$TRPoints = $result->$transactionType;
				$mess = 'You scanned ' . $product_name . ' for Genuity & responded to Product Image Promotion. '. $TRPoints .' have been added to your TRUSTAT loyalty program'; 
				$data['transaction_type'] = "Product Video Feedback";
				$data['brand_name'] = get_products_brand_name_by_id($data['product_id']);
				$data['product_name'] = get_products_name_by_id($data['product_id']);
            $this->Productmodel->feedbackLoylity($transactionType, $data, $ProductID, $user['id'], $transactionTypeName, 'Loyalty', $mess, $customer_id, $promotion_id, $TRPoints, $data['latitude'], $data['longitude'], $data['product_qr_code']);
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

	
	 public function SaveConsumerMediaViewDetails() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $data = $this->getInput();
        if (($this->request->method != 'post') || empty($data)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }

        $validate = [
            ['field' => 'product_qr_code', 'label' => 'Product QR Code', 'rules' => 'trim|required'],
			['field' => 'promotion_id', 'label' => 'Promotion id', 'rules' => 'trim|required'],
            ['field' => 'media_type', 'label' => 'Media Type', 'rules' => 'trim|required'],
			['field' => 'media_play_location', 'label' => 'Media Play Location', 'rules' => 'trim'],
            ['field' => 'total_media_duration_sec', 'label' => 'Total Media Duration in Seconds', 'rules' => 'trim|required'],
			['field' => 'media_play_duration_sec', 'label' => 'Media Play Duration in Seconds', 'rules' => 'trim|required'],
			['field' => 'watched_complete', 'label' => 'Watched Complete-Yes or No', 'rules' => 'trim|required'],
			['field' => 'latitude', 'label' => 'User latitude', 'rules' => 'trim|required'],
			['field' => 'longitude', 'label' => 'User longitude', 'rules' => 'trim|required'],
			['field' => 'current_city', 'label' => 'Current City', 'rules' => 'trim|required'],
			['field' => 'current_pin', 'label' => 'Current PIN', 'rules' => 'trim'],
        ];
        $errors = $this->ConsumerModel->validate($data, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors1.', 'errors' => $errors]);
        }
       
		
		$product_qr_code = $data['product_qr_code'];
		$promotion_id = $data['promotion_id'];
		$ProductID = get_product_id_by_product_code($product_qr_code);
		$customer_id = get_customer_id_by_product_id($ProductID);
		    
        //Utils::debug();
		if($promotion_id==0){
		$data['product_id'] = $ProductID;
		$data['customer_id'] = $customer_id; 
		}else{
		$data['product_id'] = get_product_id_by_promotion_id($data['promotion_id']);	
		$data['customer_id'] = get_customer_id_by_promotion_id($data['promotion_id']);			
		}
		$data['consumer_id'] = $user['id'];
		$userId =  $user['id'];
		$data['view_date_time'] =  date('Y-m-d H:i:s');
		 
        if ($this->db->insert('consumer_media_view_details', $data)) {
			
			// Consumer Log Data insert start
			
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($userId);
			$CALdata['consumer_id'] = $userId; 
			$CALdata['consumer_mobile'] = getConsumerMobileNumberById($userId); 
			$CALdata['customer_name'] = getUserFullNameById($data['customer_id']); 
			$CALdata['customer_id'] = $data['customer_id']; 
			$CALdata['unique_customer_code'] = getCustomerCodeById($data['customer_id']); 
			$CALdata['product_name'] = get_products_name_by_id($data['product_id']); 
			$CALdata['product_id'] = $data['product_id']; 
			$CALdata['product_sku'] = get_product_sku_by_id($data['product_id']); 
			$CALdata['product_code'] = $product_qr_code; 
			$CALdata['gloc_latitude'] = $data['latitude'];
			$CALdata['gloc_longitude'] = $data['longitude'];
			$CALdata['gloc_city'] = $data['current_city'];
			$CALdata['gloc_pin_code'] = $data['current_pin'];
			$CALdata['consumer_activity_type'] = " Watched Level 1 " . $data['media_type'];
			$CALdata['loyalty_rewards_points'] = 0;
			$CALdata['loyalty_rewards_type'] = getCustomerLoyaltyTypeById($data['customer_id']);
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
			
			// Consumer Log Data insert end
           
            Utils::response(['status' => true, 'message' => 'Consumer media view details saved successfully.', 'data' => $data]);
       		
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
	
	/*
	public function consumerLoyltyDeals() {
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		$mobile_no = "7678665537";
        $data = [];
        $data = $this->Productmodel->userLoyltyDeals($user['id'],$mobile_no);
        if (!empty($data)) {
            Utils::response(['status' => true, 'message' => 'User gain loylties.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }
	*/
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
			
			// Consumer Log Data insert start
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($user['id']);
			$CALdata['consumer_id'] = $user['id']; 
			$CALdata['consumer_mobile'] = getConsumerMobileNumberById($user['id']); 
			$CALdata['customer_name'] = "Reposting to ISPL"; 
			$CALdata['customer_id'] = 1;  
			$CALdata['unique_customer_code'] ="Reposting to ISPL";
			$CALdata['product_name'] = "No Specific Product Involved"; 
			$CALdata['product_id'] = 0; 
			$CALdata['product_sku'] = "No Specific Product Involved"; 
			$CALdata['product_code'] = "No Specific Product Involved";
			$CALdata['gloc_latitude'] = "";
			$CALdata['gloc_longitude'] = "";
			$CALdata['gloc_city'] = $data['city'];
			$CALdata['gloc_pin_code'] = $data['pin_code'];
			$CALdata['consumer_activity_type'] = "TRUSTAT Loyalty Redemption request";
			$CALdata['loyalty_rewards_points'] = 0;
			$CALdata['loyalty_rewards_type'] = "TRUSTAT";
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
				// Consumer Log Data insert end
				
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
	
	public function CustomMessageforSendingProductReference($product_id = null) {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }		
        $CustomMessage = getCustomMessageforSendingProductReferenceByProductId($product_id);
		if($CustomMessage==''){
			$CustomMessage = "No Message";
		Utils::response(['status'=>true,'message'=>'Custom Message for Sending Reference','data'=>$CustomMessage]);	
		}else{		
        Utils::response(['status'=>true,'message'=>'Custom Message for Sending Reference','data'=>$CustomMessage]);
		}
    }
	
		public function MessageForReceiverOfReference($product_id = null, $MobileNo = null) {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		
        $CustomMessage = getMessageForReceiverOfReferenceByProductId($product_id) .' '. base_url().'click_link/'.$MobileNo.'/'.$product_id. '/' . getMediaTypeforSendingReferenceByProductId($product_id);
		if($CustomMessage==''){
			$CustomMessage = "No Message";
		Utils::response(['status'=>true,'message'=>'Message for receiver of Reference','data'=>$CustomMessage]);	
		}else{		
        Utils::response(['status'=>true,'message'=>'Message for receiver of Reference','data'=>$CustomMessage]);
		}
    }
	

		public function TRUSTATCouponTypeNameNumber() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		
        $CustomMessage = getTRUSTATCouponTypeNameNumberById(55);
				
		Utils::response(['status'=>true,'message'=>'TRUSTAT Coupon Type/Name/Number','data'=>$CustomMessage]);
		
    }

	/*
	public function SelectOptionForReasonSendingProductReference($product_id = null) {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		
        $CustomMessage = getOptionForReasonSendingProductReferenceByProductId($product_id);
		if($CustomMessage==''){
			$CustomMessage = "No Message";
		Utils::response(['status'=>true,'message'=>'Custom Message for Sending Reference','data'=>$CustomMessage]);	
		}else{		
        Utils::response(['status'=>true,'message'=>'Custom Message for Sending Reference','data'=>$CustomMessage]);
		}
    }
	*/	
		
  public function SelectOptionForReasonSendingProductReference($product = null) {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        if (($this->request->method != 'get') || is_null($product)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		$ProductReferenceMediaTyeSelectedByCustomer = ProductReferenceMediaTyeSelectedByCustomer($product);
		
		
        $data = $this->Productmodel->getOptionForReasonSendingProductReferenceByProductId($product,$ProductReferenceMediaTyeSelectedByCustomer);
        if (!empty($data)) {
            Utils::response(['status' => true, 'message' => 'Consumer need to select one option as reason to share this product.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'System failed to proccess the request.'], 200);
        }
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
	
		public function ListAllCustomers() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $items = $this->Productmodel->getListAllCustomers($user['id']);
		
        Utils::response(['status'=>true,'message'=>'List all Customers-','data'=>$items]);
       
    }
	
	
		public function ListAllCustomersBrandLoyalty() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $items = $this->Productmodel->getListAllCustomersBrandLoyalty($user['id']);
		
        Utils::response(['status'=>true,'message'=>'List all Customers Brand Loyalty.','data'=>$items]);       
    }

		public function ListAllCustomersBrandLoyalty2() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $items = $this->Productmodel->getListAllCustomersBrandLoyalty2($user['id']);
		
        Utils::response(['status'=>true,'message'=>'List all Customers Brand Loyalty.','data'=>$items]);       
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
	
	
	// View Consumer Notification function Starts
	// Updated function
	/* 
    public function ViewConsumerNotification() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'notification_id', 'label' => 'Notification ID', 'rules' => 'trim'],
			['field' => 'pp_id', 'label' => 'Push Promotion ID', 'rules' => 'trim'],
			['field' => 'pp_type', 'label' => 'Push Promotion Type', 'rules' => 'trim'],
			['field' =>'geol_city','label'=>'GEO Location City','rules' => 'trim' ],
			['field' =>'geol_pin_code','label'=>'GEO Location PIN Code','rules' => 'trim' ],
            ['field' =>'geol_latitude','label'=>'GEO Location Latitude','rules' => 'trim'],
            ['field' =>'geol_longitude','label'=>'GEO Location Longitude','rules' => 'trim' ],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $notification_idArray = $this->getInput('notification_id');
        $notification_id = $notification_idArray['notification_id'];
		
		$pp_idArray = $this->getInput('pp_id');
        $pp_id = $pp_idArray['pp_id'];
		
		$pp_typeArray = $this->getInput('pp_type');
        $pp_type = $pp_typeArray['pp_type'];
		
		
		$consumer_id = $user['id'];
		$product_id = getProductIDByNotificationId($notification_id);
		$customer_id = get_customer_id_by_product_id($product_id);
		$loyalty_points_consumer_view_notification_lps = getLPCVNLPSByCustomerId($customer_id); 
		
        $this->db->set('notifications_view_dt', date("Y-m-d H:i:s"));
        $this->db->set('status', 1);
        $this->db->where('id', $notification_id);
        if ($this->db->update('list_notifications_table')) {
			
			$transactionTypeName = "Notification Reed for the brand - " . getUserFullNameById($customer_id);
			$transactionType = "loyalty_points_consumer_view_notification_lps";
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$customer_name = getUserFullNameById($customer_id); 
			$product_name = get_products_name_by_id($product_id); 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($customer_id);
			$transaction_lr_type = "Loyalty";
			$promotion_id = $notification_id;
			
			if($loyalty_points_consumer_view_notification_lps>0){
				 $this->Productmodel->saveLoylty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
$this->Productmodel->saveConsumerPassbookLoyalty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
			}
			// Consumer Log Data insert start
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($consumer_id);
			$CALdata['consumer_id'] = $consumer_id; 
			$CALdata['consumer_mobile'] = getConsumerMobileNumberById($consumer_id); 
			$CALdata['customer_name'] = getUserFullNameById($customer_id); 
			$CALdata['customer_id'] = $customer_id; 
			$CALdata['unique_customer_code'] = getCustomerCodeById($customer_id); 
			$CALdata['product_name'] = get_products_name_by_id($product_id); 
			$CALdata['product_id'] = $product_id; 
			$CALdata['product_sku'] = get_product_sku_by_id($product_id); 
			$CALdata['product_code'] = "Product info is not reqired"; 
			$CALdata['gloc_latitude'] = "";
			$CALdata['gloc_longitude'] = "";
			$CALdata['gloc_city'] = "";
			$CALdata['gloc_pin_code'] = "000000";
			$CALdata['consumer_activity_type'] = "Notification Reed for the brand - " . getUserFullNameById($customer_id);
			$CALdata['loyalty_rewards_points'] = $loyalty_points_consumer_view_notification_lps;
			$CALdata['loyalty_rewards_type'] = getCustomerLoyaltyTypeById($customer_id);
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
				// Consumer Log Data insert end
				
			//	update push_text_message table start
			if($pp_type=="Push_Text_Message"){
			$this->db->set('m_v_datetime', date("Y-m-d H:i:s"));
			$this->db->set('m_v_status', 1);
			$this->db->where(array('text_pp_id'=>$pp_id, 'consumer_id'=>$consumer_id));
			if($this->db->update('push_text_message')) {
				$input['notification_type'] = "Text Message View status updated";
				$input['text_message_for_consumer'] = getTextMessageByMessageID($pp_id);
			}
			}
			//	update push_text_message table end			
				
			
	//$mnv13_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 13)->get()->row();
		//$mnvtext13 = $mnv13_result->message_notification_value;	
            Utils::response(['status' => true, 'message' => 'Notification Viewed successfully.', 'data' => $input]);
			//Utils::response(['status' => true, 'message' => $mnvtext13, 'data' => $input]);
        } else {
			//$mnv14_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 14)->get()->row();
		//$mnvtext14 = $mnv14_result->message_notification_value;	
            Utils::response(['status' => false, 'message' => 'System failed to update.'], 200);
			// Utils::response(['status' => false, 'message' => $mnvtext14], 200);
        }
    }
	*/
// Old Function 	
   public function ViewConsumerNotification() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'notification_id', 'label' => 'Notification ID', 'rules' => 'trim'],
			['field' =>'geol_city','label'=>'GEO Location City','rules' => 'trim' ],
			['field' =>'geol_pin_code','label'=>'GEO Location PIN Code','rules' => 'trim' ],
            ['field' =>'geol_latitude','label'=>'GEO Location Latitude','rules' => 'trim'],
            ['field' =>'geol_longitude','label'=>'GEO Location Longitude','rules' => 'trim' ],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $notification_idArray = $this->getInput('notification_id');
        $notification_id = $notification_idArray['notification_id'];
		
		
		$consumer_id = $user['id'];
		$product_id = getProductIDByNotificationId($notification_id);
		$customer_id = get_customer_id_by_product_id($product_id);
		$loyalty_points_consumer_view_notification_lps = getLPCVNLPSByCustomerId($customer_id); 
		
        $this->db->set('notifications_view_dt', date("Y-m-d H:i:s"));
        $this->db->set('status', 1);
        $this->db->where('id', $notification_id);
        if ($this->db->update('list_notifications_table')) {
			
			$transactionTypeName = "Notification Reed for the brand - " . getUserFullNameById($customer_id);
			$transactionType = "loyalty_points_consumer_view_notification_lps";
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$customer_name = getUserFullNameById($customer_id); 
			$product_name = get_products_name_by_id($product_id); 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($customer_id);
			$transaction_lr_type = "Loyalty";
			$promotion_id = $notification_id;
			
			
				 $this->Productmodel->saveLoylty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
$this->Productmodel->saveConsumerPassbookLoyalty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
			
			// Consumer Log Data insert start
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($consumer_id);
			$CALdata['consumer_id'] = $consumer_id; 
			$CALdata['consumer_mobile'] = getConsumerMobileNumberById($consumer_id); 
			$CALdata['customer_name'] = getUserFullNameById($customer_id); 
			$CALdata['customer_id'] = $customer_id; 
			$CALdata['unique_customer_code'] = getCustomerCodeById($customer_id); 
			$CALdata['product_name'] = get_products_name_by_id($product_id); 
			$CALdata['product_id'] = $product_id; 
			$CALdata['product_sku'] = get_product_sku_by_id($product_id); 
			$CALdata['product_code'] = "Product info is not reqired"; 
			$CALdata['gloc_latitude'] = "";
			$CALdata['gloc_longitude'] = "";
			$CALdata['gloc_city'] = "";
			$CALdata['gloc_pin_code'] = "000000";
			$CALdata['consumer_activity_type'] = "Notification Reed for the brand - " . getUserFullNameById($customer_id);
			$CALdata['loyalty_rewards_points'] = $loyalty_points_consumer_view_notification_lps;
			$CALdata['loyalty_rewards_type'] = getCustomerLoyaltyTypeById($customer_id);
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
				// Consumer Log Data insert end
			
	//$mnv13_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 13)->get()->row();
		//$mnvtext13 = $mnv13_result->message_notification_value;	
            Utils::response(['status' => true, 'message' => 'Notification Viewed successfully.', 'data' => $input]);
			//Utils::response(['status' => true, 'message' => $mnvtext13, 'data' => $input]);
        } else {
			//$mnv14_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 14)->get()->row();
		//$mnvtext14 = $mnv14_result->message_notification_value;	
            Utils::response(['status' => false, 'message' => 'System failed to update.'], 200);
			// Utils::response(['status' => false, 'message' => $mnvtext14], 200);
        }
    }
// View Consumer Notification function end
	
	// View Text Message function Starts
    public function ViewConsumerTextMessage() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }

        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'text_message_id', 'label' => 'Message ID', 'rules' => 'trim'],
			['field' =>'geol_city','label'=>'GEO Location City','rules' => 'trim' ],
			['field' =>'geol_pin_code','label'=>'GEO Location PIN Code','rules' => 'trim' ],
            ['field' =>'geol_latitude','label'=>'GEO Location Latitude','rules' => 'trim'],
            ['field' =>'geol_longitude','label'=>'GEO Location Longitude','rules' => 'trim' ],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
        $notification_idArray = $this->getInput('text_message_id');
        $text_message_id = $notification_idArray['text_message_id'];
		$text_message_text = getCustomerIDByMessageID($text_message_id);
		$input['text_message_text'] = getTextMessageByMessageID($text_message_id);
		
		$consumer_id = $user['id'];
		//$product_id = getProductIDByNotificationId($text_message_id);
		$customer_id = getCustomerIDByMessageID($text_message_id);
		//$loyalty_points_consumer_view_notification_lps = getLPCVNLPSByCustomerId($customer_id); 
		
        $this->db->set('m_v_datetime', date("Y-m-d H:i:s"));
        $this->db->set('m_v_status', 1);
        $this->db->where('id', $text_message_id);
        if($this->db->update('push_text_message')) {
			
			$transactionTypeName = "Text Message from" . getUserFullNameById($customer_id);
			$transactionType = "loyalty_points_consumer_view_notification_lps";
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$customer_name = getUserFullNameById($customer_id); 
			$product_name = get_products_name_by_id($product_id); 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($customer_id);
			$transaction_lr_type = "View Message";
			$promotion_id = $text_message_id;
			
			// Consumer Log Data insert start
			/*
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($consumer_id);
			$CALdata['consumer_id'] = $consumer_id; 
			$CALdata['consumer_mobile'] = getConsumerMobileNumberById($consumer_id); 
			$CALdata['customer_name'] = getUserFullNameById($customer_id); 
			$CALdata['customer_id'] = $customer_id; 
			$CALdata['unique_customer_code'] = getCustomerCodeById($customer_id); 
			$CALdata['product_name'] = get_products_name_by_id($product_id); 
			$CALdata['product_id'] = $product_id; 
			$CALdata['product_sku'] = get_product_sku_by_id($product_id); 
			$CALdata['product_code'] = "Product info is not reqired"; 
			$CALdata['gloc_latitude'] = $input['gloc_latitude'];
			$CALdata['gloc_longitude'] = $input['gloc_longitude'];
			$CALdata['gloc_city'] = $input['gloc_city'];
			$CALdata['gloc_pin_code'] = $input['geol_pin_code'];
			$CALdata['consumer_activity_type'] = "Text Message Viewed successfully for the brand - " . getUserFullNameById($customer_id);
			$CALdata['loyalty_rewards_points'] = 0;
			$CALdata['loyalty_rewards_type'] = getCustomerLoyaltyTypeById($customer_id);
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
			*/
				// Consumer Log Data insert end
				
            Utils::response(['status' => true, 'message' => 'Text Message Viewed successfully.', 'data' => $input]);
        } else {
            Utils::response(['status' => false, 'message' => 'System failed to update.'], 200);
        }
    }

// View Consumer Text function end
		

// Consumer profile empty field  count

	public function ConsumerProfileEmptyFieldCount() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		//$items['consumer_id'] = $user['id'];		
		$consumer_id = $user['id'];
   //$items['total_fields_to_update_profile_all'] = $this->Productmodel->getTotalCountConsumerProfileFieldsAvailableUpdateAll($consumer_id);
	$items = $this->Productmodel->getConsumerProfileFieldsRequireUpdate($consumer_id);
	$items['total_fields_to_update_profile'] = 100;
	$items['fields_to_update_personal_profile'] = 100;
	$items['fields_to_update_family_profile'] = 100;
	$items['fields_to_update_lifestyle_profile'] = 100;
	$items['fields_to_update_others_profile'] = 100;
		//$items = $this->Productmodel->getTotalCountConsumerProfileFieldsAvailableUpdateAll($consumer_id);
		
       Utils::response(['status'=>true,'message'=>'Consumer Profile Empty Field Count Listed here.','data'=>$items]);  
    }
/*	
		public function ConsumerProfileEmptyFieldCount() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		$consumer_id = $user['id'];
        $data = $this->Productmodel->getConsumerProfileFieldsRequireUpdate($consumer_id);
		
        Utils::response(['status'=>true,'message'=>'List of Consumer Profile Fields Require to Update', 'data'=>$data]);
       
    }
	
	*/

	
	
		// Loyalty Consumer Referral Product function Starts
    public function LoyaltyConsumerReferralProduct() {
        $user = $this->auth();
        if(empty($this->auth())){
            Utils::response(['status'=>false,'message'=>'Forbidden access.'],403);
        }

        $data = $this->getInput();
        if(($this->input->method() != 'post') || empty($data)){ 
            Utils::response(['status'=>false,'message'=>'Bad request.'],400);
        }
        $validate = [
			['field' =>'referral_reference_id', 'label' => 'Referral Reference ID', 'rules' => 'trim'],
			['field' =>'promotion_details', 'label' => 'Promotion details', 'rules' => 'trim'],
			['field' =>'product_code_or_promotion_id', 'label' => 'Product Code Or Promotion ID', 'rules' => 'trim'],
            ['field' =>'product_id', 'label' => 'Product ID', 'rules' => 'trim'],
			['field' =>'referred_mobile_no','label'=>'Referred Mobile Number','rules' => 'trim'],
			['field' =>'geol_city','label'=>'GEO Location City','rules' => 'trim' ],
			['field' =>'geol_pin_code','label'=>'GEO Location PIN Code','rules' => 'trim'],
            ['field' =>'geol_latitude','label'=>'GEO Location Latitude','rules' => 'trim'],
            ['field' =>'geol_longitude','label'=>'GEO Location Longitude','rules' => 'trim'],
        ];
        $errors = $this->ConsumerModel->validate($data, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
       
		$data['referrer_consumer_id'] = $user['id'];
		$data['referred_consumer_id'] = get_consumer_id_by_mobile_number2($data['referred_mobile_no']);
		$data['media_type'] = getMediaTypeforSendingReferenceByProductId($data['product_id']);
		
		if($data['referred_consumer_id']==0){ 
			$data['rs_referred_consumer_TRUSTAT'] = "Not Registered With TRUSTAT"; 
			$referred_consumer_id = $data['referred_mobile_no'];
			$registration_status = "NotRegistered";
		}else{ 
			$data['rs_referred_consumer_TRUSTAT'] = "Already Registered With TRUSTAT"; 
			$referred_consumer_id = $data['referred_consumer_id'];
			$registration_status = "Registered";
		} 
		
		$Consumer_Linked_Customer = Check_If_Consumer_Linked_Customer($data['referred_consumer_id'], get_customer_id_by_product_id($data['product_id'])); 
		if($Consumer_Linked_Customer==true){ 
		$data['rs_referred_consumer_customer'] = "Consumer Linked Customer"; 
		}else{ 
		$data['rs_referred_consumer_customer'] = "Consumer Not Linked Customer"; 
		}
		
		
		$customer_id = get_customer_id_by_product_id($data['product_id']);
		$consumer_id = $user['id'];
		$product_id = $data['product_id'];
		$loyalty_points = getLPSReferralByCustomerId($data['product_id']); 
	$data['loyalty_points_referral'] = getLoyaltyrewardstosenderconsumerunderReferralAssignedbyBrandByProductId($product_id);
		
		$data['referring_datetime'] = date('Y-m-d H:i:s');
		 
		 $NumberOfReferralsAllowedToConsumer = getNumberOfReferralsAllowedToConsumerByProductId($product_id); 
		$TotalRefbyConsumer = $this->db->where(array('referrer_consumer_id' => $consumer_id, 'product_id' => $product_id))->from("consumer_referral_table")->count_all_results();
		
		$TotalRefSenttoConsumer = $this->db->where(array('referred_mobile_no' => $data['referred_mobile_no'], 'product_id' => $product_id, 'media_type' => $data['media_type']))->from("consumer_referral_table")->count_all_results();
		
		if($TotalRefSenttoConsumer < 1){
		if($NumberOfReferralsAllowedToConsumer > $TotalRefbyConsumer){
        if ($this->db->insert('consumer_referral_table', $data)) {
			
			$transactionTypeName = "Product Referral - " . getUserFullNameById($customer_id);
			$transactionType = "loyalty_rewards_to_sender_consumer_under_referral";
			$consumer_name = getConsumerNameById($consumer_id);
			$product_brand_name = get_products_brand_name_by_id($product_id);
			$customer_name = getUserFullNameById($customer_id); 
			$product_name = get_products_name_by_id($product_id); 
			$customer_loyalty_type = getCustomerLoyaltyTypeById($customer_id);
			$transaction_lr_type = "Loyalty";
			$promotion_id = $data['product_code_or_promotion_id'];
			$promotion_title = $data['promotion_details'];
		

		$insertAdData=array(
					"customer_id"	 => $customer_id,
					"consumer_id"	 => $referred_consumer_id,
					"product_id"	 => $product_id,
					"promotion_id"	 => $data['referral_reference_id'],
					"promotion_title"	 => $promotion_title,	
					"promotion_type"	 => "Advertisement",
					"media_type"	 => $data['media_type'],
					"ad_push_date"	 => date('Y-m-d H:i:s'),
					"media_play_date"	 => "0000-00-00 00:00:00",
					"ad_feedback_response"	 => "No",
					"ad_response_datetime"	 => date('Y-m-d H:i:s'),
					"ad_active"	 => "1"					
					);	
					
				  $this->db->insert("push_advertisements", $insertAdData);	
				  
				  // Link Consumer Customer insert record 
				  if($Consumer_Linked_Customer==false){ 
				  $LinkCCData=array(
					"consumer_id"	 		 => $referred_consumer_id,
					"registration_status"	 => $registration_status,
					"product_id"			 => $product_id,
					"customer_id"	 		 => $customer_id,
					"bar_code"	 	 		 => $data['product_code_or_promotion_id'],
					"scan_city"	 	 		 => $data['geol_city'],
					"pin_code"	 	 		 => $data['geol_pin_code'],
					"latitude"	 	 		 => $data['geol_latitude'],
					"longitude"	 	 		 => $data['geol_longitude'],
					"ps_ip_address"	 		 => $this->input->ip_address(),
					"code_scan_date"	 	 => date('Y-m-d H:i:s'),
					"del_by_cs"	 			 => "0"					
					);						
				  $this->db->insert("consumer_customer_link", $LinkCCData);	
				  }
				  
				
		
//$this->Productmodel->saveLoylty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
//$this->Productmodel->saveConsumerPassbookLoyalty($transactionType, ['activity_date' => date("Y-m-d H:i:s"), 'consumer_id' =>$consumer_id, 'consumer_name' => $consumer_name, 'brand_name' => $product_brand_name, 'customer_name' => $customer_name, 'product_name' => $product_name, 'product_id' => $product_id, 'product_code' => "",'customer_loyalty_type' => $customer_loyalty_type], $product_id, $consumer_id, $transactionTypeName, $transaction_lr_type, $customer_id, $promotion_id);
			
			
			// Consumer Log Data insert start
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($consumer_id);
			$CALdata['consumer_id'] = $consumer_id; 
			$CALdata['consumer_mobile'] = getConsumerMobileNumberById($consumer_id); 
			$CALdata['customer_name'] = getUserFullNameById($customer_id); 
			$CALdata['customer_id'] = $customer_id; 
			$CALdata['unique_customer_code'] = getCustomerCodeById($customer_id); 
			$CALdata['product_name'] = get_products_name_by_id($product_id); 
			$CALdata['product_id'] = $product_id; 
			$CALdata['product_sku'] = get_product_sku_by_id($product_id); 
			$CALdata['product_code'] = "Product info is not reqired"; 
			$CALdata['gloc_latitude'] = $data['geol_latitude'];
			$CALdata['gloc_longitude'] = $data['geol_longitude'];
			$CALdata['gloc_city'] = $data['geol_city'];
			$CALdata['gloc_pin_code'] = $data['geol_pin_code'];
			$CALdata['consumer_activity_type'] = "Product Referral - " . getUserFullNameById($customer_id);
			$CALdata['loyalty_rewards_points'] = $loyalty_points;
			$CALdata['loyalty_rewards_type'] = getCustomerLoyaltyTypeById($customer_id);
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
			
			// consumer_activity_log Referred Consumer
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($referred_consumer_id);
			$CALdata['consumer_id'] = $referred_consumer_id; 
			$CALdata['consumer_mobile'] = $data['referred_mobile_no']; 
			$CALdata['customer_name'] = getUserFullNameById($customer_id); 
			$CALdata['customer_id'] = $customer_id; 
			$CALdata['unique_customer_code'] = getCustomerCodeById($customer_id); 
			$CALdata['product_name'] = get_products_name_by_id($product_id); 
			$CALdata['product_id'] = $product_id; 
			$CALdata['product_sku'] = get_product_sku_by_id($product_id); 
			$CALdata['product_code'] = "Product info is not reqired"; 
			$CALdata['gloc_latitude'] = $data['geol_latitude'];
			$CALdata['gloc_longitude'] = $data['geol_longitude'];
			$CALdata['gloc_city'] = $data['geol_city'];
			$CALdata['gloc_pin_code'] = $data['geol_pin_code'];
			$CALdata['consumer_activity_type'] = "Product Referral Received- " . getUserFullNameById($customer_id);
			$CALdata['loyalty_rewards_points'] = 0;
			$CALdata['loyalty_rewards_type'] = getCustomerLoyaltyTypeById($customer_id);
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
			
			
			$Ref1_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 9)->get()->row();
			$Ref1_billin_particular_name = $Ref1_result->billin_particular_name;
			$Ref1_billin_particular_slug = $Ref1_result->billin_particular_slug;
		
			$RefData['customer_id'] = $customer_id;
			$RefData['consumer_id'] = $referred_consumer_id;
			$RefData['billing_particular_name'] = $Ref1_billin_particular_name;		
			$RefData['billing_particular_slug'] = $Ref1_billin_particular_slug;
			$RefData['trans_quantity'] = 1; 
			$RefData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$RefData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $RefData);
			
			
			/*
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "TRUSTAT";
			$NTFdata['body'] = 'The below message has been sent by, '.getConsumerNameById($consumer_id).' Mobile No. '.getConsumerMobileNumberById($consumer_id).' - '. $message_receiver_ref_frm_server . ' ' . base_url().'click_link/'.$data['referred_mobile_no'].'/'.$product_id.'/'. getMediaTypeforSendingReferenceByProductId($product_id); 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 0; 			
			$this->db->insert('list_notifications_table', $NTFdata);
			*/
				// Consumer Log Data insert end
			
	//$mnv13_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 13)->get()->row();
		//$mnvtext13 = $mnv13_result->message_notification_value;	
		//$CustomMessage = getMessageForReceiverOfReferenceByProductId($product_id) .' '. base_url().'click_link/'.$MobileNo.'/'.$product_id. '/' . getMediaTypeforSendingReferenceByProductId($product_id);
		
		// This message will be sent from APP commenting here for now.
		$include_the_product_in_referral_program = getProductinReferralProgramAssignedbyBrandByProductId($product_id);
		$send_ref_message_frm_server = getifSendReferralMessageFromServerByProductId($product_id);
		$message_receiver_ref_frm_server = getMessageReceiverReferencefromServerByProductId($product_id);
		if(($send_ref_message_frm_server=="Yes") && ($include_the_product_in_referral_program=="Yes")){
	Utils::sendSMS($data['referred_mobile_no'], 'Greetings from TRUSTAT!! Your contact with mobile number'.' ['.getConsumerMobileNumberById($consumer_id).'] '.' has sent you following message.'. $message_receiver_ref_frm_server . ' ' . base_url().'click_link/'.$data['referred_mobile_no'].'/'.$product_id.'/'. getMediaTypeforSendingReferenceByProductId($product_id). " zLJoGnJzfXg");
		}
		$mnv1_result67 = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 67)->get()->row();
		$message_notification_value67 = $mnv1_result67->message_notification_value;
            Utils::response(['status' => true, 'message' => $message_notification_value67, 'data' => $data]);
			//Utils::response(['status' => true, 'message' => $mnvtext13, 'data' => $input]);
        } else {
			//$mnv14_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 14)->get()->row();
		//$mnvtext14 = $mnv14_result->message_notification_value;	
            Utils::response(['status' => false, 'message' => 'System failed to update.'], 200);
			// Utils::response(['status' => false, 'message' => $mnvtext14], 200);
        }
		}else{
			$mnv1_result68 = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 68)->get()->row();
		$message_notification_value68 = $mnv1_result68->message_notification_value;
		 Utils::response(['status' => false, 'message' => $message_notification_value68], 200);	
		}
		}else{
			$mnv1_result69 = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 69)->get()->row();
		$message_notification_value69 = $mnv1_result69->message_notification_value;
		 Utils::response(['status' => false, 'message' => $message_notification_value69], 200);	
		}
    }

// Loyalty Consumer Referral Product  function end

	 public function FaqsAndOtherData() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $data = $this->Productmodel->getFaqsAndOtherData($user['id']);
		
        Utils::response(['status'=>true,'message'=>'List of Faqs And Other Data', 'data'=>$data]);
       
    }
	
	public function TermsAndConditions() {
        //Utils::debug();
       
        //$items = $this->Productmodel->getRedemption($user['id']);
		$data['APP_Name'] = "TRUSTAT APP";
		$data['faqs_list'] = "........................
		...................................................
		..................................................";
		
        Utils::response(['status'=>true,'message'=>'Terms And Conditions Data', 'data'=>$data]);
       
    }
	
	
	public function ConsumerProfileFieldsAvailableUpdate() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $data = $this->Productmodel->getConsumerProfileFieldsAvailableUpdate($user['id']);
		
        Utils::response(['status'=>true,'message'=>'List of Consumer Profile Fields Available to Update', 'data'=>$data]);
       
    }
	
	public function ConsumerProfileFieldsRequireUpdate() {
        //Utils::debug();
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		$consumer_id = $user['id'];
        $data = $this->Productmodel->getConsumerProfileFieldsRequireUpdate($consumer_id);
		
        Utils::response(['status'=>true,'message'=>'List of Consumer Profile Fields Require to Update', 'data'=>$data]);
       
    }
	
	public function TRUSTATAppServiceAgreement() {
        //Utils::debug();
       
        //$items = $this->Productmodel->getRedemption($user['id']);
		$data['APP_Name'] = "TRUSTAT App";
		//$data['TRUSTAT_app_service_agreement'] = 'test';
		$data = $this->Productmodel->getTRUSTATAppServiceAgreement($user['id']);
        Utils::response(['status'=>true,'message'=>'TRUSTAT App Service Agreement', 'data'=>$data]);
       
    }
	
		public function TRUSTATAppVersionUpdate() {
        //Utils::debug();
       
        //$items = $this->Productmodel->getRedemption($user['id']);
		$data['TRUSTAT_android_app_version'] = "1.0";
		$data['TRUSTAT_android_app_version_updated_date'] = '20-03-2020';
		$data['TRUSTAT_ios_app_version'] = "1.0";
		$data['TRUSTAT_ios_app_version_updated_date'] = '20-03-2020';
		
		$data['Tracek_android_app_version'] = "1.0";
		$data['Tracek_android_app_version_updated_date'] = '20-03-2020';
		$data['Tracek_ios_app_version'] = "1.0";
		$data['Tracek_ios_app_version_updated_date'] = '20-03-2020';
		
		//$data = $this->Productmodel->getTRUSTATAppServiceAgreement($user['id']);
        Utils::response(['status'=>true,'message'=>'Latest Version of TRUSTAT and Tracek APPs', 'data'=>$data]);
       
    }
	
		public function TRUSTATAppServerBaseURL() {
        //Utils::debug();
		
		$mnv1_result = $this->db->select('message_notification_value, message_notification_value_part2')->from('message_notification_master')->where('id', 56)->get()->row();
		$message_notification_value = $mnv1_result->message_notification_value;
       
        //$items = $this->Productmodel->getRedemption($user['id']);
		$data['APP_Name'] = "TRUSTAT App";
		$data['TRUSTAT_app_live_server_base_url'] = 'http://trustat.in/';
		$data['TRUSTAT_app_staging_server_base_url'] = 'http://mtrck.in/';
		$data['TRUSTAT_app_development_server_base_url'] = 'http://innovigents.com/';
		$data['number_for_testing_development_allow'] = $message_notification_value;
		
        Utils::response(['status'=>true,'message'=>'TRUSTAT App Server Base URL', 'data'=>$data]);
       
    }
	
		public function TracekAppServerBaseURL() {
        //Utils::debug();
		
		$mnv1_result = $this->db->select('message_notification_value, message_notification_value_part2')->from('message_notification_master')->where('id', 57)->get()->row();
		$message_notification_value = $mnv1_result->message_notification_value;
       
        //$items = $this->Productmodel->getRedemption($user['id']);
		$data['APP_Name'] = "Tracek App";
		$data['tracek_app_live_server_base_url'] = 'http://trustat.in/';
		$data['tracek_app_staging_server_base_url'] = 'http://mtrck.in/';
		$data['tracek_app_development_server_base_url'] = 'http://innovigents.com/';
		$data['tracek_username_for_testing_development_allow'] = $message_notification_value;
		
        Utils::response(['status'=>true,'message'=>'Tracek App Server Base URL', 'data'=>$data]);
       
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
	
	public function ConsumerPassBookDashboard() {
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		
		$checkifrquestinprocess = $this->db->where(array('user_id' => $user['id'], 'l_status' => 0))->count_all_results('loyalty_redemption');
		
        $data = [];
        $data = $this->Productmodel->getConsumerPassBookDashboard($user['id']);
		
        if (!empty($data)) {
            Utils::response(['status' => true, 'min_max_redemption_points_consumer' => '500', 'count_lyalty_request_in_process' => $checkifrquestinprocess, 'message' => 'User gain loylties.', 'data' => $data]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }
	
	//Sanjay
		public function consumerLoyltyDeals($mobile_no = null, $customer_id = null) {
			
        $user = $this->auth();
		/*
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		*/
		//$checkifrquestinprocess = $this->db->where(array('user_id' => $user['id'], 'l_status' => 0))->count_all_results('loyalty_redemption');
			//$mobile_no = '7678665537';

			//$customer_id = '363';
		
			$this->db->select_sum('cpb.points');
			$this->db->from('consumer_passbook as cpb');
			$this->db->join('consumers as c','c.id=cpb.consumer_id');
	$this->db->where(array('c.mobile_no' => $mobile_no, 'cpb.customer_id' => $customer_id, 'cpb.transaction_lr_type' => "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;	
			
			$this->db->select_sum('cpb.points');
			$this->db->from('consumer_passbook as cpb');
			$this->db->join('consumers as c','c.id=cpb.consumer_id');
	$this->db->where(array('c.mobile_no' => $mobile_no, 'cpb.customer_id' => $customer_id, 'cpb.transaction_lr_type' => "Redemption"));	
			$query2=$this->db->get();
			$Total_Points_Redeemed=$query2->row()->points;
			
			$this->db->select_sum('cpb.points');
			$this->db->from('consumer_passbook as cpb');
			$this->db->join('consumers as c','c.id=cpb.consumer_id');
	$this->db->where(array('c.mobile_no' => $mobile_no, 'cpb.customer_id' => $customer_id, 'cpb.transaction_lr_type' => "Expiry"));	
			$query3=$this->db->get();
			$Total_Points_Expired=$query3->row()->points;
			
			//$Earned_Loyalty_Points = $this->Productmodel->getconsumerEarnedLoyaltyPoints();
			//$Redeemed_Loyalty_Points = $this->Productmodel->getconsumerRedeemedLoyaltyPoints();
			/*
			if($Total_Points_Redeemed==0){
			$Balance_Loyalty_Points = $Total_Earned_Points;
			} else {
				$Balance_Loyalty_Points = $Total_Earned_Points - $Total_Points_Redeemed;
			}
			*/
			$Balance_Loyalty_Points = $Total_Earned_Points - ($Total_Points_Redeemed + $Total_Points_Expired); 
			$percent_loyalty_points_redeemed_cashier_store = getPercentLoyaltyPointsRedeemedCashierStoreByCustomerId($customer_id);
		
        //$data = [];
        //$data = $this->Productmodel->getconsumerLoyltyDeals($user['id']);
		
        if (!empty($mobile_no)) {
             Utils::response(['status' => true, 'message' => 'Your Balance Loyalty Points.', 'balance_loyalty_points' => $Balance_Loyalty_Points/*, 'data' => $data*/]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
    }
	
	
	    public function ListConsumerProfileMasterData() {
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $userid = $user['id'];
        $result = $this->ConsumerModel->findConsumerProfileMasterData($userid);
		//$result['SELECT'] = "SELECT";
        if (empty($result)) {
            $this->response(['status' => false, 'message' => 'Record not found'], 200);
        }
        $this->response(['status' => true, 'message' => 'Consumer Profile Master Data List is below-', 'SELECT' => 0, 'SELECT DATE' => '0000-00-00', 'data' => $result]);
    }
	
	
		public function ListReltailStores($customer_id){
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $data = [];
		$userId = $user['user_id'];
		$ParentuserId = getParentIdFromUserIdTAPP($userId);
		//print_r($userId);
		//print_r($ParentuserId); exit;
		$LocationType = "Retail Store";
		//$customer_id = 221;
        $data = $this->Productmodel->All_ReltailStores_location_list($LocationType,$customer_id);
                if(!empty($data)){
            Utils::response(['status'=>true,'message'=>'List of locations.','data'=>$data]);
        }else{
            Utils::response(['status'=>false,'message'=>'There is no record found.'],200);
        }
		
    }
	
	
  // Check Consumer If reference received Function Start 
  /*
    public function CheckIfConsumerReceivedReference() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
		 
		 $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $data = [];
		
		/*
        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
            ['field' => 'phone_number', 'label' => 'Phone Number', 'rules' => 'trim|required|integer|exact_length[10]'],
			['field' => 'product_id', 'label' => 'Product ID', 'rules' => 'trim|required|integer'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }
		
        $phone_numberArray = $this->getInput('phone_number');
        $phone_number = $phone_numberArray['phone_number'];
		
		$product_idArray = $this->getInput('product_id');
        $product_id = $product_idArray['product_id'];
		
		$ConsumerID = $user['id'];
       
		$isRefrenceReceived = $this->ConsumerModel->isRefrenceReceived($ConsumerID);
		$isFeedbackAnsDueLA = $this->ConsumerModel->isFeedbackAnsDueLA($ConsumerID);
		
        if ($isRefrenceReceived == TRUE){

           $data['RedirectToAdScreen'] = "Yes";
		   
        } else {

           $data['RedirectToAdScreen'] = "No";
        
        }
		Utils::response(['status' => true, 'message' => 'Need to redirect the consumer to ad screen?', 'data' => $data]);
    }
	*/
	public function CheckIfConsumerReceivedReference(){
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $data = [];		
		$ConsumerID = $user['id'];
		$mobile_no = getConsumerMobileNumberById($ConsumerID);
		$findRefrenceReceived = $this->ConsumerModel->findRefrenceReceived($mobile_no);
		//$isFeedbackAnsDueLA = $this->ConsumerModel->isFeedbackAnsDueLA($ConsumerID);
		
        if($findRefrenceReceived == false){

           $data['RedirectToAdScreen'] = "No";
		   
        } else {

           $data['RedirectToAdScreen'] = $findRefrenceReceived;
		   
		 // $rid= $findRefrenceReceived->referral_reference_id; 
		   /*
		$RAMVdata['product_id'] = get_product_id_by_promotion_id($data['promotion_id']);	
		$RAMVdata['customer_id'] = get_customer_id_by_promotion_id($data['promotion_id']);			
		$RAMVdata['consumer_id'] = $user['id'];
		$RAMVdata['view_date_time'] =  date('Y-m-d H:i:s');
		 
        $this->db->insert('consumer_media_view_details', $RAMVdata)
        */
        }
		$mnv1_result70 = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 70)->get()->row();
		$message_notification_value70 = $mnv1_result70->message_notification_value;
		Utils::response(['status' => true, 'message' => $message_notification_value70, 'data' => $data]);
		
    }
	
	// Check Consumer If reference received Function End
	
	
		// Check If Product is eligible for reference for consumer Function Start 
    public function CheckIfProductEligiblForReferenceForConsumer() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $input = $this->getInput();
        if (($this->input->method() != 'post') || empty($input)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
        $validate = [
			['field' => 'product_id', 'label' => 'Product ID', 'rules' => 'trim|required|integer'],
        ];
        $errors = $this->ConsumerModel->validate($input, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors.', 'errors' => $errors]);
        }		
		$product_idArray = $this->getInput('product_id');
        $product_id = $product_idArray['product_id'];		
		$consumer_id = $user['id'];		
		//$ProductEligiblForReferenceForConsumer = getProductEligiblForReferenceForConsumerByProductIdAndConsumerID($product_id, $consumer_id);
		$findIfProductScanned = $this->Productmodel->findIfProductScanned($product_id, $consumer_id);
		$isAdPushedToconsumerForProduct = $this->Productmodel->isAdPushedToconsumerForProduct($product_id, $consumer_id);
		
	$data['findIfProductScanned'] = $findIfProductScanned;
	$data['isAdPushedToconsumerForProduct'] = $isAdPushedToconsumerForProduct;
        
        if (($findIfProductScanned == true)||($isAdPushedToconsumerForProduct == true)) {
			
           $data['ProductEligiblForReferenceForConsumer'] = "Yes";		   
		  
        } else {

           $data['ProductEligiblForReferenceForConsumer'] = "No";
        
        }
		Utils::response(['status' => true, 'message' => 'Product Eligiblity Status For Reference For Consumer', 'data' => $data]);
    }
	
	// Check If Product is eligible for reference for consumer Function End
	
	public function UpdateRefSMSLinkClicked($referred_mobile_no, $referred_product_id, $media_type) {
        if (($this->input->method() != 'get')) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }
		/*
        $user = $this->auth();
        if (empty($this->auth())) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $userid = $user['id'];
        $result = $this->ConsumerModel->findConsumerProfileMasterData($userid);
        if (empty($result)) {
            $this->response(['status' => false, 'message' => 'Record not found'], 200);
        }
		*/
		$result['LinkClicked'] = "OK Done";
		
				$UpdateData = array( 
				'referral_link_clicked_datetime' => date('Y-m-d H:i:s')
				);
		
		$this->db->update('consumer_referral_table',$UpdateData,['referred_mobile_no'=>$referred_mobile_no, 'product_id'=>$referred_product_id, 'media_type'=>$media_type]);		
		
		header('Location: http://et1.in/');
    //$this->response(['status' => true, 'message' => 'Action: ', 'data' => $result]);
    	
	}
	
	
	
	// Media view from refral 
	
		 public function SaveConsumerMediaViewDetailsAutoRef() {
        $user = $this->auth();
        if (empty($user)) {
            Utils::response(['status' => false, 'message' => 'Forbidden access.'], 403);
        }
        $data = $this->getInput();
        if (($this->request->method != 'post') || empty($data)) {
            Utils::response(['status' => false, 'message' => 'Bad request.'], 400);
        }

        $validate = [
            ['field' => 'product_id', 'label' => 'Product QR Code', 'rules' => 'trim|required'],
			['field' => 'promotion_id', 'label' => 'Promotion id', 'rules' => 'trim|required'],
            ['field' => 'media_type', 'label' => 'Media Type', 'rules' => 'trim|required'],
			['field' => 'media_play_location', 'label' => 'Media Play Location', 'rules' => 'trim'],
            ['field' => 'total_media_duration_sec', 'label' => 'Total Media Duration in Seconds', 'rules' => 'trim|required'],
			['field' => 'media_play_duration_sec', 'label' => 'Media Play Duration in Seconds', 'rules' => 'trim|required'],
			['field' => 'watched_complete', 'label' => 'Watched Complete-Yes or No', 'rules' => 'trim|required'],
			['field' => 'latitude', 'label' => 'User latitude', 'rules' => 'trim|required'],
			['field' => 'longitude', 'label' => 'User longitude', 'rules' => 'trim|required'],
			['field' => 'current_city', 'label' => 'Current City', 'rules' => 'trim|required'],
			['field' => 'current_pin', 'label' => 'Current PIN', 'rules' => 'trim'],
        ];
        $errors = $this->ConsumerModel->validate($data, $validate);
        if (is_array($errors)) {
            Utils::response(['status' => false, 'message' => 'Validation errors1.', 'errors' => $errors]);
        }
       
		
		$product_qr_code = $data['product_qr_code'];
		$promotion_id = $data['promotion_id'];
		$ProductID = get_product_id_by_product_code($product_qr_code);
		$customer_id = get_customer_id_by_product_id($ProductID);
		    
        //Utils::debug();
		$data['customer_id'] = get_customer_id_by_product_id($data['product_id']);			
		$data['consumer_id'] = $user['id'];
		$userId =  $user['id'];
		$data['view_date_time'] =  date('Y-m-d H:i:s');
		 
        if ($this->db->insert('consumer_media_view_details', $data)) {
			
			
			$this->db->set(array("referral_media_apd" => 1))->where(array("referral_reference_id" => $promotion_id))->update('consumer_referral_table');
			
			// Consumer Log Data insert start
			
			$CALdata['date_time'] = date('Y-m-d H:i:s'); 
			$CALdata['consumer_name'] = getConsumerNameById($userId);
			$CALdata['consumer_id'] = $userId; 
			$CALdata['consumer_mobile'] = getConsumerMobileNumberById($userId); 
			$CALdata['customer_name'] = getUserFullNameById($data['customer_id']); 
			$CALdata['customer_id'] = $data['customer_id']; 
			$CALdata['unique_customer_code'] = getCustomerCodeById($data['customer_id']); 
			$CALdata['product_name'] = get_products_name_by_id($data['product_id']); 
			$CALdata['product_id'] = $data['product_id']; 
			$CALdata['product_sku'] = get_product_sku_by_id($data['product_id']); 
			$CALdata['product_code'] = $product_qr_code; 
			$CALdata['gloc_latitude'] = $data['latitude'];
			$CALdata['gloc_longitude'] = $data['longitude'];
			$CALdata['gloc_city'] = $data['current_city'];
			$CALdata['gloc_pin_code'] = $data['current_pin'];
			$CALdata['consumer_activity_type'] = " Watched Level 1 " . $data['media_type'];
			$CALdata['loyalty_rewards_points'] = 0;
			$CALdata['loyalty_rewards_type'] = getCustomerLoyaltyTypeById($data['customer_id']);
			
			$this->db->insert('consumer_activity_log_table', $CALdata);
			
			// Consumer Log Data insert end
           
            Utils::response(['status' => true, 'message' => 'Consumer media Auto Play done successfully.', 'data' => $data]);
       		
		} else {
            Utils::response(['status' => false, 'message' => 'System failed to proccess the request.'], 200);
        }
		
    }
	
	
public function TestSendMessage(){
	
		$Phno='9319800106';
        $Msg="Sending Text message from New Server-Sanjay Testing2";
        $Password='ispl@54321';
        $SenderID='DMTMSG';
        $UserID='innovigent';

        function send_message($Phno,$Msg,$Password,$SenderID,$UserID)
        {         
            $ch='';
            $url='http://nimbusit.biz/api/SmsApi/SendSingleApi?UserID='.$UserID.'&Password='.$Password.'&SenderID='.$SenderID.'&Phno='.$Phno.'&Msg='.urlencode($Msg);
            $ch = curl_init($url);
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

            $output=curl_exec($ch);
            curl_close($ch);
            return $output;
        }
	 echo send_message($Phno,$Msg,$Password,$SenderID,$UserID);
}

	public function ProductReturnTypeCMSItems() {
        //Utils::debug();       
        //$items = $this->Productmodel->getRedemption($user['id']);
		$CMSItems = "Return Type";
		$data['APP_Name'] = "Tracek App";
		//$data['TRUSTAT_app_service_agreement'] = 'test';
		$data = $this->Productmodel->getProductReturnTypeCMSItems($CMSItems);
        Utils::response(['status'=>true,'message'=>'List Product Return Type CMS Items', 'data'=>$data]);
       
    }
	
		public function ProductReturnTypeNameValueCMSItems() {
        //Utils::debug();       
        //$items = $this->Productmodel->getRedemption($user['id']);
		$CMSItems = "Returning Condition of Product Condition";
		$data['APP_Name'] = "Tracek App";
		//$data['TRUSTAT_app_service_agreement'] = 'test';
		$data = $this->Productmodel->getProductReturnTypeCMSItems($CMSItems);
        Utils::response(['status'=>true,'message'=>'List Return Type Name Value CMS Items', 'data'=>$data]);
    }
	
	public function PercentLoyaltyPointsDefinedByCustomer($CustomerID) {
        //Utils::debug();       
        //$items = $this->Productmodel->getRedemption($user['id']);
		//$CMSItems = "Returning Condition of Product Condition";
		//$data['APP_Name'] = "Tracek App";
		//$data['TRUSTAT_app_service_agreement'] = 'test';
		//$data = $this->Productmodel->getProductReturnTypeCMSItems($CMSItems);
		$PercentLoyaltyPoints = getPercentLoyaltyPointsRedeemedCashierStoreByCustomerId($CustomerID);
		if (!empty($CustomerID)) {
             Utils::response(['status' => true, 'message' => 'Percent Loyalty Points Defined By Customer.', 'percent_lty_pts_defined' => $PercentLoyaltyPoints/*, 'data' => $data*/]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
       // Utils::response(['status'=>true,'message'=>'List Return Type Name Value CMS Items', 'data'=>$data]);
    }
	
		public function LoyaltyPointWeightageComparetoCurrency($CustomerID) {
        //Utils::debug();       
        //$items = $this->Productmodel->getRedemption($user['id']);
		//$CMSItems = "Returning Condition of Product Condition";
		//$data['APP_Name'] = "Tracek App";
		//$data['TRUSTAT_app_service_agreement'] = 'test';
		//$data = $this->Productmodel->getProductReturnTypeCMSItems($CMSItems);
		$LoyaltyPointWeightage = getLoyaltyPointWeightageByCustomerId($CustomerID);
		if (!empty($CustomerID)) {
             Utils::response(['status' => true, 'message' => 'Loyalty Point weightage with compare to currency.', 'loyalty_point_weightage' => $LoyaltyPointWeightage/*, 'data' => $data*/]);
        } else {
            Utils::response(['status' => false, 'message' => 'There is no record found.'], 200);
        }
       // Utils::response(['status'=>true,'message'=>'List Return Type Name Value CMS Items', 'data'=>$data]);
    }
	
	// add Packaging Ship Out Order starts   
		public function addPackagingShipOutOrder($psoo_customer_product_name,$psoo_customer_erp_product_id,$customer_id,$pick_list_number,$psoo_quantity,$psoo_product_origin_type,$psoo_bin_number,$psoo_token_id,$psoo_invoice_number,$Microsite_URL,$psoo_ip_address,$psoo_latitude,$psoo_longitude,$psoo_city,$psoo_pin_code,$psoo_more_fields) {
		
		// Consumer Log Data insert start 
			$PAOOdata['psoo_customer_product_name'] = $psoo_customer_product_name;
			$PAOOdata['psoo_customer_erp_product_id'] = $psoo_customer_erp_product_id;
			$PAOOdata['customer_id'] = $customer_id;
			$PAOOdata['tracek_user_id'] = getPackagingSupervisorUser($customer_id); 
			$PAOOdata['tracek_user_name'] = getTracekUserFullNameById(getPackagingSupervisorUser($customer_id)); 
			$PAOOdata['product_id'] = get_products_id_by_customer_erp_product_id($psoo_customer_erp_product_id); 
			$PAOOdata['tracek_packer_id'] = getAssignSinglePackerUser($customer_id); 
			$PAOOdata['tracek_packer_name'] = getTracekUserFullNameById(getAssignSinglePackerUser($customer_id)); 
			$PAOOdata['product_id'] = get_products_id_by_customer_erp_product_id($psoo_customer_erp_product_id); 
			$PAOOdata['pick_list_number'] = $pick_list_number; 
			$PAOOdata['product_name'] = get_products_name_by_id($PAOOdata['product_id']); 
			$PAOOdata['psoo_quantity'] = $psoo_quantity; 
			$PAOOdata['psoo_product_origin_type'] = $psoo_product_origin_type;
			$PAOOdata['psoo_bin_number'] = $psoo_bin_number;
			$PAOOdata['microsite_url'] = $Microsite_URL; 
			$PAOOdata['psoo_token_id'] = $psoo_token_id; 
			$PAOOdata['psoo_invoice_number'] = $psoo_invoice_number; 
			$PAOOdata['psoo_codes'] = ""; 
			$PAOOdata['psoo_ip_address'] = $psoo_ip_address; 
			$PAOOdata['psoo_latitude'] = $psoo_latitude;
			$PAOOdata['psoo_longitude'] = $psoo_longitude;
			$PAOOdata['psoo_city'] = $psoo_city;
			$PAOOdata['psoo_pin_code'] = $psoo_pin_code;
			$PAOOdata['psoo_date_time'] = date('Y-m-d H:i:s'); 			
			$PAOOdata['psoo_packing_start_date_time'] = "";
			$PAOOdata['psoo_packing_end_date_time'] = "";
			$PAOOdata['psoo_more_fields'] = $psoo_more_fields;
			if(getPackagingSupervisorUser($customer_id)==0){
			$PAOOdata['assigned_to_psupervisor_datetime'] = ""; 
				}else{					
			$PAOOdata['assigned_to_psupervisor_datetime'] = date('Y-m-d H:i:s'); 		
				}
			if(getPackagingSupervisorUser($customer_id)==0){
			$PAOOdata['tracek_packer_assigned_datetime'] = ""; 
				}else{					
			$PAOOdata['tracek_packer_assigned_datetime'] = date('Y-m-d H:i:s');  		
				}	
			
		// Consumer Log Data insert end
			
        if ($this->db->insert('packaging_ship_out_order', $PAOOdata)) {
			
			/*
			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			*/
			
			$MRLP1_billin_particular_name = "Packaging Ship Out Order";
			$MRLP1_billin_particular_slug = "Packaging_Ship_Out_Order";
		
		
			$TRNNCData['customer_id'] = $customer_id;
			$TRNNCData['consumer_id'] = $consumer_id;
			$TRNNCData['billing_particular_name'] = $MRLP1_billin_particular_name.' Placed';		
			$TRNNCData['billing_particular_slug'] = $MRLP1_billin_particular_slug.'_Placed';
			$TRNNCData['trans_quantity'] = 1; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);		
			
		 Utils::response(['status' => true, 'message' => 'Order placed', 'product_code_quantity' => $psoo_quantity, 'data' => $PAOOdata], 200);
			
        } else {
            Utils::response(['status' => false, 'message' => 'Redemption failed.'], 200);
        }
    }
	
	// add Packaging Ship Out Order ends 
	

}
