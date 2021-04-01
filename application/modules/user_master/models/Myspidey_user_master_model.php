<?php

class Myspidey_user_master_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library(array('Dmailer', 'form_validation', 'email'));
    }

    function get_ownership($id) {
        $this->db->select('*');
        $this->db->from('user_group_master');
        $this->db->where(array("status" => '1'));
        $this->db->order_by("usergroup_id", "ASC");
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        return $res;
    }

    function get_user_details($id) {

        $this->db->select(['bu.*','ap.location_id']);
        $this->db->from('backend_user AS bu');
        $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('bu.user_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	
	function get_total_common_points_loyalty_list_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("transaction_type LIKE '%$srch_string%' OR loyalty_points LIKE '%$srch_string%'");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            //$this->db->where(array('is_parent' => $user_id));
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('loylties');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
	
	function get_common_points_loyalty_list_all($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("transaction_type LIKE '%$srch_string%' OR loyalty_points LIKE '%$srch_string%'");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            //$this->db->where(array('is_parent' => $user_id));
        }
		
		
		
		

        $this->db->select('*');
        $this->db->from('loylties');
       // $this->db->order_by('id', 'desc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        //echo $this->db->last_query();die;
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result_data = $query->result_array();
        }
        return $result_data;
    }
	
	function get_common_point_master_details($id) {

        $this->db->select(['*']);
        $this->db->from('loylties');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	function update_common_point_master_data($frmData) {
           
                $UpdateData = array(
                    "loyalty_points" => $frmData['loyalty_points'],
					"expiry_days" => $frmData['expiry_days'],
					"active_status" => $frmData['active_status'],					
					"created_at" => date('Y-m-d H:i:s'),
					"modified_at" => date('Y-m-d H:i:s')
                );
            


			$id = $this->uri->segment(3);
            $whereData = array(
                'id' => $frmData['id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('loylties')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Common Point Data Updated Successfully!');
                return true;
            }
        
    }
	
	
		function update_common_point_master_data_otp($frmData) {
           
                $UpdateData = array(
                    
					"otp" => $frmData['loyalty_points'],
					"otp_datetime" => date('Y-m-d H:i:s')
                );
            


			//$id = $this->uri->segment(4);
            $whereData = array(
                'user_id' => $frmData['customer_id'],
				'otp' => $frmData['loyalty_points']
            );

            //$this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->delete('backend_user')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Customer Account Deleted Successfully!');
                return true;
            }else{
				$this->session->set_flashdata('success', 'Couldn’t complete the action!');
			}
        
    }

	
	function get_total_message_notification_list_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
             $this->db->where("message_type LIKE '%$srch_string%' OR module_name LIKE '%$srch_string%' OR module_submodule_location_details LIKE '%$srch_string%' OR message_notification_value LIKE '%$srch_string%'");
        } else {
            
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('message_notification_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
	
	function get_message_notification_list_all($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("message_type LIKE '%$srch_string%' OR module_name LIKE '%$srch_string%' OR module_submodule_location_details LIKE '%$srch_string%' OR message_notification_value LIKE '%$srch_string%'");
        } else {
            
        }
				
        $this->db->select('*');
        $this->db->from('message_notification_master');
       // $this->db->order_by('id', 'desc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        //echo $this->db->last_query();die;
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result_data = $query->result_array();
        }
        return $result_data;
    }
	
	
		function get_message_notification_details($id) {

        $this->db->select(['*']);
        $this->db->from('message_notification_master');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	
		function update_message_notification_details_data($frmData) {
           
                $UpdateData = array(
                    
					"message_notification_value" => $frmData['message_notification_value'],
					"message_notification_value_part2" => $frmData['message_notification_value_part2'],
					"message_notification_value_part3" => $frmData['message_notification_value_part3'],
					"message_notification_value_part4" => $frmData['message_notification_value_part4'],
					"modified_at" => date('Y-m-d H:i:s')
                );
            


			$id = $this->uri->segment(3);
            $whereData = array(
                'id' => $frmData['id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('message_notification_master')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Data Updated Successfully!');
                return true;
            }
        
    }
	
	
	
    function save_user($frmData) {   //echo '<pre>';print_r($frmData);exit;
        $user_id = $this->session->userdata('admin_user_id');
        $is_parent = $this->session->userdata('admin_user_id');
        if (isset($frmData['ccadmin']) && $frmData['ccadmin'] != '') {
            $is_parent = $frmData['ccadmin'];
        }
        
        /* if($user_id>1){## if user id is greater than one means plant controller is created by cc admin
          $user_type='plant controller';
          }else{
          $user_type='ccc admin';
          } */
        //$user_exists = $this->checkDuplicateUser($frmData['user_name']);
        if (!empty($user_exists)) {
            return 2;
        }
        //$frmData['profile_photo']=

        if (!empty($frmData['user_id'])) {
            if (!empty($frmData['profile_photo'])) {
                $UpdateData = array(
                    "customer_code " => $frmData['customer_code'],
                    "mobile_no" => $frmData['user_mobile'],
                    "industry" => $frmData['industry'],
					"designation_id" => $frmData['role'],
                    "pan " => $frmData['pan'],
                    "f_name" => $frmData['f_name'],
                    "l_name" => $frmData['l_name'],
					"l_name"=>$frmData['l_name'],
					"days_for_expiry_of_point_credited"=>$frmData['days_for_expiry_of_point_credited'],
					"days_for_notification_before_expiry_of_lps"=>$frmData['days_for_notification_before_expiry_of_lps'],
					"loyalty_points_consumer_view_notification_lps"=>$frmData['loyalty_points_consumer_view_notification_lps'],
					"percent_lty_pts_consumer_red_cashier"=>$frmData['percent_lty_pts_consumer_red_cashier'],
					"loyalty_point_weightage"=>$frmData['loyalty_point_weightage'],
					"brand_loyalty_redemption_type"=>$frmData['brand_loyalty_redemption_type'],
					"brand_loyalty_store_redemption_message"=>$frmData['brand_loyalty_store_redemption_message'],
					"trustat_coupon_type_name_number"=>$frmData['trustat_coupon_type_name_number'],
					"customer_loyalty_type" => $frmData['Customer_Loyalty_Type'],
					"customer_microsite_url" => $frmData['customer_microsite_url'],
					"complaint_email_id"=>$frmData['complaint_email_id'],
					"feedback_email_id"=>$frmData['feedback_email_id'],				
                    "user_name" => $frmData['user_name'],
                    "email_id" => $frmData['user_email'],
                    "state " => $frmData['state_name'],					
                    "city " => $frmData['city_name'],
                    "remark " => $frmData['remark'],
                    "profile_photo" => $frmData['profile_photo'],
                    "last_updated_by" => $user_id,
                    "last_updated_on" => date('Y-m-d H:i:s')
                );
				
			
			
            } else {
                $UpdateData = array(
                    "customer_code " => $frmData['customer_code'],
                    "mobile_no" => $frmData['user_mobile'],
                    "industry" => $frmData['industry'],
					"designation_id" => $frmData['role'],
                    "pan " => $frmData['pan'],
                    "f_name" => $frmData['f_name'],
                    "l_name" => $frmData['l_name'],
					"l_name"=>$frmData['l_name'],
					"days_for_expiry_of_point_credited"=>$frmData['days_for_expiry_of_point_credited'],
					"days_for_notification_before_expiry_of_lps"=>$frmData['days_for_notification_before_expiry_of_lps'],
					"loyalty_points_consumer_view_notification_lps"=>$frmData['loyalty_points_consumer_view_notification_lps'],
					"brand_loyalty_redemption_type"=>$frmData['brand_loyalty_redemption_type'],
					"brand_loyalty_store_redemption_message"=>$frmData['brand_loyalty_store_redemption_message'],
					"trustat_coupon_type_name_number"=>$frmData['trustat_coupon_type_name_number'],
					"percent_lty_pts_consumer_red_cashier"=>$frmData['percent_lty_pts_consumer_red_cashier'],
					"loyalty_point_weightage"=>$frmData['loyalty_point_weightage'],
					"customer_loyalty_type" => $frmData['Customer_Loyalty_Type'],
					"customer_microsite_url" => $frmData['customer_microsite_url'],
					"complaint_email_id"=>$frmData['complaint_email_id'],
					"feedback_email_id"=>$frmData['feedback_email_id'],				
                    "user_name" => $frmData['user_name'],
                    "email_id" => $frmData['user_email'],
                    "state " => $frmData['state_name'],
                    "remark " => $frmData['remark'],
                    "city " => $frmData['city_name'],
                    "last_updated_by" => $user_id,
                    "last_updated_on" => date('Y-m-d H:i:s')
                );
            }
			
			if($frmData['plant_id']!=''){
            $assignedPlant = [
                "plant_id" => $frmData['plant_id'],
                "assigned_by" => $this->session->userdata('admin_user_id')
            ];
            $apQuery = $this->db->get_where('assign_plants_to_users',['user_id'=>$frmData['user_id']]);
            if($apQuery->num_rows() > 0){
                $this->db->where(['user_id'=>$frmData['user_id']]);
                $this->db->set($assignedPlant);
                $this->db->update("assign_plants_to_users");
            }else{
                $assignedPlant['user_id'] = $frmData['user_id'];
                $this->db->insert("assign_plants_to_users", $assignedPlant);
            } 
			}
				
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'user_id' => $frmData['user_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('backend_user')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'User Updated Successfully!');
                return 1;
            }
        } else {
            if (empty($frmData['profile_photo'])) {
                $frmData['profile_photo'] = '';
            }
            $password = generate_password(6);
			 //$password = "password";
            $insertData = array(
                "customer_code " => $frmData['customer_code'],
                "mobile_no" => $frmData['user_mobile'],
                "industry" => $frmData['industry'],
				"designation_id" => $frmData['role'],
                "pan " => $frmData['pan'],
                "f_name" => $frmData['f_name'],
                "l_name" => $frmData['l_name'],
				"days_for_expiry_of_point_credited"=>$frmData['days_for_expiry_of_point_credited'],
				"days_for_notification_before_expiry_of_lps"=>$frmData['days_for_notification_before_expiry_of_lps'],
				"loyalty_points_consumer_view_notification_lps"=>$frmData['loyalty_points_consumer_view_notification_lps'],
				"percent_lty_pts_consumer_red_cashier"=>$frmData['percent_lty_pts_consumer_red_cashier'],
				"loyalty_point_weightage"=>$frmData['loyalty_point_weightage'],
				"brand_loyalty_redemption_type"=>$frmData['brand_loyalty_redemption_type'],
				"brand_loyalty_store_redemption_message"=>$frmData['brand_loyalty_store_redemption_message'],
				"trustat_coupon_type_name_number"=>$frmData['trustat_coupon_type_name_number'],
				"customer_loyalty_type" => $frmData['Customer_Loyalty_Type'],
				"customer_microsite_url" => $frmData['customer_microsite_url'],
				"complaint_email_id"=>$frmData['complaint_email_id'],
				"feedback_email_id"=>$frmData['feedback_email_id'],				
                "user_name" => $frmData['user_name'],
                "password" => md5($password),
                "email_id" => $frmData['user_email'],
                "state " => $frmData['state_name'],
                "city " => $frmData['city_name'],
                "remark " => $frmData['remark'],
                "profile_photo" => $frmData['profile_photo'],
                "created_by" => $user_id,
                "is_parent" => $is_parent,
                "is_admin" => 1
            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("backend_user", $insertData)) {
				if($frmData['plant_id']!=''){
              $assignedPlant = [
                    "plant_id" => $frmData['plant_id'],
                    "user_id" => $this->db->insert_id(),
                    "assigned_by" => $this->session->userdata('admin_user_id')
                ];
                $this->db->insert("assign_plants_to_users", $assignedPlant);
				}
				
				
				$first_name = $frmData['f_name'];
				$last_name = $frmData['l_name'];
                $full_name = $frmData['f_name'] . ' ' . $frmData['l_name'];
                $username = $frmData['user_name'];
				
                // echo $this->db->last_query();exit;
				$email = $frmData['user_email']; 
				// Email is not going to the user right now
                $this->user_registration_mail($first_name, $full_name, $username, $password, $email, $last_name);
                $this->session->set_flashdata('success', 'User Added Successfully!');
				
			$AddTRUser_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 17)->get()->row();
			$AddTRUser_billin_particular_name = $AddTRUser_result->billin_particular_name;
			$AddTRUser_billin_particular_slug = $AddTRUser_result->billin_particular_slug;
			
			$AddTRUserData['customer_id'] = $is_parent;
			$AddTRUserData['billing_particular_name'] = $AddTRUser_billin_particular_name;		
			$AddTRUserData['billing_particular_slug'] = $AddTRUser_billin_particular_slug;
			$AddTRUserData['trans_quantity'] = 1; 
			$AddTRUserData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$AddTRUserData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $AddTRUserData);
			
                return 1;
            }
            return 0;
        }
    }

	public function user_registration_mail($first_name = '', $full_name = '', $username = '', $password = '', $email, $last_name = '') {//echo '***'.$email;exit;
        $link = $this->create_link($username, $password);
        $subject = $last_name . '; Welcome to your new Tracek Account';
        $body = "<b>Greetings!!! from Innovigent Solutions,</b><br />
								<br />
								Your registration process has been initiated at our end.<br />
								<br />
								Your login user id and password are as under:<br />
								<br />
								User Name:  " . $username . "<br />
								Password is:<b>" . $password . '</b><br /><br />
								Please click on below link to activate your <b>“Tracek”</b> account:<br />
								' . $link . ' <br /><br />
								Post email verification, you can update your account profile. In case of any assistance, please send us an email CustomerSupport@'.$_SERVER['SERVER_NAME'].' or call at +91-9899703291. <br /><br />				
								
								
								Regards <br />
								<b>Team Admin</b><br /> 
								<img src="https://'.$_SERVER['SERVER_NAME'].'/uploads/rwaprofilesettings/thumb/thumb_tlogo_1523866687.jpg" alt="ISPL Admin" height="40" width="80">';
        $mail_conf = array(
            'subject' => $subject,
            'to_email' => $email,
            'cc' => 'superadmin@'.$_SERVER['SERVER_NAME'],
            'from_email' => 'admin@'.$_SERVER['SERVER_NAME'],
            'from_name' => 'ISPL Admin',
            'body_part' => $body
        );
        if ($this->dmailer->mail_notify($mail_conf)) {
            return true;
        } return false; //echo redirect('accounts/create');
    }
	
	
		function get_location_details($location_id) {
        $res = 0;
        $this->db->select('*');
        $this->db->from('location_master');
        $this->db->where(array('location_id' => $location_id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            // $res=1;
        }
        return $res;
    }
	
	function save_location11($frmData) {   //echo '<pre>';print_r($frmData);exit;
        $user_id = $this->session->userdata('admin_user_id');
        $is_parent = $this->session->userdata('admin_user_id');
		/*
        if (isset($frmData['ccadmin']) && $frmData['ccadmin'] != '') {
            $is_parent = $frmData['ccadmin'];
        }
        */
        /* if($user_id>1){## if user id is greater than one means plant controller is created by cc admin
          $user_type='plant controller';
          }else{
          $user_type='ccc admin';
          } */
        //$user_exists = $this->checkDuplicateUser($frmData['user_name']);
		/*
        if (!empty($user_exists)) {
            return 2;
        }
		*/
        //$frmData['profile_photo']=

        if (!empty($frmData['location_id'])) {
            if (!empty($frmData['location_image'])) {
                $UpdateData = array(
                 "location_code" => $frmData['location_code'],
                "location_name" => $frmData['location_name'],
				"location_type" => $frmData['location_type'],
                "email_id" => $frmData['user_email'],
                "phone " => $frmData['user_mobile'],
                "gst" => $frmData['gst'],
                "street_address" => $frmData['street_address'],
				"locality" => $frmData['locality'],
				"city" => $frmData['city'],
				"district" => $frmData['district'],
				"pin_code" => $frmData['pin_code'],
				"landmark" => $frmData['landmark'],
				"store_timings" => $frmData['store_timings'],
				"location_longitude" => $frmData['location_longitude'],
				"location_latitude" => $frmData['location_latitude'],
				"location_image" => base_url().'uploads/location_images/' . $frmData['location_image'],
                "remark" => $frmData['remark'],
                "status" => 1,
                "state" => $frmData['state_name'],
                //"created_by" => $frmData['ccadmin'],
				"updated_date" => date("Y-m-d H:i:s")
                );
            } else {
                $UpdateData = array(
				"location_code" => $frmData['location_code'],
                "location_name" => $frmData['location_name'],
				"location_type" => $frmData['location_type'],
                "email_id" => $frmData['user_email'],
                "phone " => $frmData['user_mobile'],
                "gst" => $frmData['gst'],
                "street_address" => $frmData['street_address'],
				"locality" => $frmData['locality'],
				"city" => $frmData['city'],
				"district" => $frmData['district'],
				"pin_code" => $frmData['pin_code'],
				"landmark" => $frmData['landmark'],
				"store_timings" => $frmData['store_timings'],
				"location_longitude" => $frmData['location_longitude'],
				"location_latitude" => $frmData['location_latitude'],
				//"location_image" => base_url().'uploads/location_images/' . $frmData['location_image'],
                "remark" => $frmData['remark'],
                "status" => 1,
                "state" => $frmData['state_name'],
                //"created_by" => $frmData['ccadmin'],
				"updated_date" => date("Y-m-d H:i:s")
                );
            }
			/*
			if($frmData['plant_id']!=''){
            $assignedPlant = [
                "plant_id" => $frmData['plant_id'],
                "assigned_by" => $this->session->userdata('admin_user_id')
            ];
            $apQuery = $this->db->get_where('assign_plants_to_users',['user_id'=>$frmData['user_id']]);
            if($apQuery->num_rows() > 0){
                $this->db->where(['user_id'=>$frmData['user_id']]);
                $this->db->set($assignedPlant);
                $this->db->update("assign_plants_to_users");
            }else{
                $assignedPlant['user_id'] = $frmData['user_id'];
                $this->db->insert("assign_plants_to_users", $assignedPlant);
            } 
			}
			*/	
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'location_id' => $frmData['location_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('location_master')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Updated Successfully!');
				//header('Location: http://www.google.com');
                return 1;
            }
        } else {
            if (empty($frmData['location_image'])) {
                $frmData['location_image'] = '';
            }
            //$password = generate_password(6);
			 //$password = "password";
            $insertData = array(
                "location_code" => $frmData['location_code'],
                "location_name" => $frmData['location_name'],
				"location_type" => $frmData['location_type'],
                "email_id" => $frmData['user_email'],
                "phone" => $frmData['user_mobile'],
                "gst" => $frmData['gst'],
                "street_address" => $frmData['street_address'],
				"locality" => $frmData['locality'],
				"city" => $frmData['city'],
				"district" => $frmData['district'],
				"pin_code" => $frmData['pin_code'],
				"landmark" => $frmData['landmark'],
				"store_timings" => $frmData['store_timings'],
				"location_longitude" => $frmData['location_longitude'],
				"location_latitude" => $frmData['location_latitude'],
				"location_image" => base_url().'uploads/location_images/' . $frmData['location_image'],
                "remark" => $frmData['remark'],
                "status" => 1,
                "state" => $frmData['state_name'],
                "created_by" => $frmData['ccadmin'],
				"created_date" => date("Y-m-d H:i:s")				
            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("location_master", $insertData)) {
				/*
				if($frmData['plant_id']!=''){
              $assignedPlant = [
                    "plant_id" => $frmData['plant_id'],
                    "user_id" => $this->db->insert_id(),
                    "assigned_by" => $this->session->userdata('admin_user_id')
                ];
                $this->db->insert("assign_plants_to_users", $assignedPlant);
				}
				*/
				
				//$first_name = $frmData['f_name'];
				//$last_name = $frmData['l_name'];
                //$full_name = $frmData['f_name'] . ' ' . $frmData['l_name'];
                //$username = $frmData['user_name'];
				
                // echo $this->db->last_query();exit;
				//$email = $frmData['user_email']; 
				// Email is not going to the user right now
               // $this->user_registration_mail($first_name, $full_name, $username, $password, $email, $last_name);
                $this->session->set_flashdata('success', 'Added Successfully!');
                return 1;
            }
            return 0;
        }
    }
	
    function update_profile_data($frmData) {
        $user_id = $this->session->userdata('admin_user_id');
        if (!empty($user_id)) {
            if (empty($frmData['profile_photo'])) {
                // $this->db->set('profile_photo', $frmData['profile_photo']);
                $UpdateData = array(
                    "mobile_no" => $frmData['user_mobile'],
                    //"industry" => $frmData['industry'],
                    //"pan " => $frmData['pan'],
                    "f_name" => $frmData['f_name'],
                    "l_name" => $frmData['l_name'],
					"customer_microsite_url"=>$frmData['customer_microsite_url'],
					"complaint_email_id"=>$frmData['complaint_email_id'],
					"feedback_email_id"=>$frmData['feedback_email_id'],				
					"days_for_expiry_of_point_credited" => $frmData['days_for_expiry_of_point_credited'],
                    "days_for_notification_before_expiry_of_lps" => $frmData['days_for_notification_before_expiry_of_lps'],
                    "user_name" => $frmData['user_name'],
                    "email_id" => $frmData['user_email'],
                    "state " => $frmData['state_name'],
                    "city " => $frmData['city_name'],
                    "remark " => $frmData['remark'],
                    //"profile_photo"=>$frmData['profile_photo'],
                    "last_updated_by" => $user_id,
                    "last_updated_on" => date('Y-m-d H:i:s')
                );
            } else {
                $UpdateData = array(
                    "mobile_no" => $frmData['user_mobile'],
                    //"industry" => $frmData['industry'],
                    //"pan " => $frmData['pan'],
                    "f_name" => $frmData['f_name'],
                    "l_name" => $frmData['l_name'], 
					"customer_microsite_url"=>$frmData['customer_microsite_url'],
					"complaint_email_id"=>$frmData['complaint_email_id'],
					"feedback_email_id"=>$frmData['feedback_email_id'],				
					"days_for_expiry_of_point_credited" => $frmData['days_for_expiry_of_point_credited'],
                    "days_for_notification_before_expiry_of_lps" => $frmData['days_for_notification_before_expiry_of_lps'],
                    "user_name" => $frmData['user_name'],
                    "email_id" => $frmData['user_email'],
                    "state " => $frmData['state_name'],
                    "city " => $frmData['city_name'],
                    "remark " => $frmData['remark'],
                    "profile_photo" => $frmData['profile_photo'],
                    "last_updated_by" => $user_id,
                    "last_updated_on" => date('Y-m-d H:i:s')
                );
            }



            $whereData = array(
                'user_id' => $user_id
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('backend_user')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'User Updated Successfully!');
                return 1;
            }
        }
    }

    

    function checkDuplicateUser($username) {
        $result = '';
        $this->db->select('user_id');
        $this->db->from('backend_user');

        $this->db->where(array('user_name' => $username));

        $query = $this->db->get();

        //echo '***'.$this->db->last_query();exit;

        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['user_id'];
        }
        return $result;
    }

    function checkEmail($email, $uid = '') {
        $result = 'true';
        $this->db->select('user_id');
        $this->db->from('backend_user');
        if (!empty($uid)) {
            $this->db->where(array('user_id!=' => $uid));
        }
        $this->db->where(array('email_id' => $email));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['user_id'];
            $result = 'false';
        }
        return $result;
    }
	
	function checkMobileNo($mobile, $uid = '') {
        $result = 'true';
        $this->db->select('user_id');
        $this->db->from('backend_user');
        if (!empty($uid)) {
            $this->db->where(array('user_id!=' => $uid));
        }
        $this->db->where(array('mobile_no' => $mobile));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['user_id'];
            $result = 'false';
        }
        return $result;
    }
	

    function checkUserName($uname, $uid = '') {
        $result = 'true';
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
        $this->db->select('user_id');
        $this->db->from('backend_user');
        if (!empty($uid)) {
            $this->db->where(array('user_id!=' => $uid));
        }
        $this->db->where(array('user_name' => $uname));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['user_id'];
            $result = 'false';
        }
        return $result;
    }

    ## List Users

    function get_user_list($user_session_Id) {
        $result = '';
        $this->db->select('*');
        $this->db->from('backend_user');

        $this->db->where(array('is_parent' => $user_session_Id));

        $query = $this->db->get();

        //echo '***'.$this->db->last_query();exit;

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
    }

    ## ----------------------For plant controller viewed in admin----------------------##

    function get_total_plant_user_list_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        /* if(!empty($srch_string) && $user_id==1){ 
          $this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%') and (is_parent=$user_id)");
          }
          if($user_id>1){
          if(!empty($srch_string)){
          $this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%') and (is_parent=$user_id)");
          }else{
          $this->db->where(array('is_parent'=>$user_id));
          }
          } */
        if ($user_id == 1) {
            $is_parent = "is_parent>1";
        } else {
            $is_parent = "is_parent=$user_id";
        }
        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and ($is_parent)");
        } else {
            $this->db->where($is_parent);
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('backend_user');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }

    function get_plant_user_list_all($limit, $start, $srch_string = '') {
        $user_id = $this->session->userdata('admin_user_id');
        $result = '';
        if ($user_id == 1) {
            $is_parent = "is_parent>1";
        } else {
            $is_parent = "is_parent=$user_id";
        }

        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and ($is_parent)");
        } else {
            $this->db->where($is_parent);
        }
        $this->db->select('*');
        $this->db->from('backend_user');

        $this->db->order_by("status asc,created_on desc");

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
	
	
    function get_total_tracek_users_list_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
        /* if(!empty($srch_string) && $user_id==1){ 
          $this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%') and (is_parent=$user_id)");
          }
          if($user_id>1){
          if(!empty($srch_string)){
          $this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%') and (is_parent=$user_id)");
          }else{
          $this->db->where(array('is_parent'=>$user_id));
          }
          } */
        if ($user_id == 1) {
            $is_parent = "is_parent=$customer_id";
        } else {
            $is_parent = "is_parent=$user_id";
        }
        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and ($is_parent)");
        } else {
            $this->db->where($is_parent);
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('backend_user');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }

    function get_tracek_user_list_all($limit, $start, $srch_string = '') {
        $user_id = $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
        $result = '';
        if ($user_id == 1) {
            $is_parent = "is_parent=$customer_id";
        } else {
            $is_parent = "is_parent=$user_id";
        }

        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and ($is_parent)");
        } else {
            $this->db->where($is_parent);
        }
        $this->db->select('*');
        $this->db->from('backend_user');

        $this->db->order_by("status asc,created_on desc");

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
	



    ##----------------------------------plant list end-------------------##

    function get_total_user_list_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR CONCAT(f_name, ' ', l_name) LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and (is_parent=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('is_parent' => $user_id));
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('backend_user');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
    function get_user_list_all($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR CONCAT(f_name, ' ', l_name) LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and (is_parent=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('is_parent' => $user_id));
        }

        $this->db->select('*');
        $this->db->from('backend_user');
        $this->db->order_by('user_id', 'desc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        //echo $this->db->last_query();die;
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result_data = $query->result_array();
        }
        return $result_data;
    }

    function get_total_plevel_user_list_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        /* if(!empty($srch_string) && $user_id==1){ 
          $this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%') and (is_parent=$user_id)");
          }
          if($user_id>1){
          if(!empty($srch_string)){
          $this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%') and (is_parent=$user_id)");
          }else{
          $this->db->where(array('is_parent'=>$user_id));
          }
          } */

        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and (is_parent=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('is_parent' => $user_id));
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('backend_user');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }

    function get_plevel_user_list_all($limit, $start, $srch_string = '') {
        $result = '';
        $user_id = $this->session->userdata('admin_user_id');
        if (empty($user_id)) {
            $user_id = 1;
        }
        //print_r($this->session->userdata());
        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and (is_parent=$user_id)");
        } else {
            //$user_id=1;
            $this->db->where(array('is_parent' => $user_id));
        }
        $this->db->select('*');
        $this->db->from('backend_user');
        $this->db->order_by("status asc,created_on desc");
        //$this->db->order_by(array('status'=>'asc','created_on'=>'desc'));//
        //$this->db->order_by('user_name','asc');
        $this->db->limit($limit, $start);
        $query = $this->db->get(); //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
    }

    function change_status($id, $value) {
        $this->db->set(array('status' => $value));
        $this->db->where(array('user_id' => $id));
        if ($this->db->update('backend_user')) {
            $user_detail = get_user_email_name($id);
            $email = $user_detail['email_id'];
            $full_name = $user_detail['f_name'] . ' ' . $user_detail['l_name'];
            if (!empty($email)) {
                $mailSent = $this->change_status_mail($full_name, $email, $value);
            }
            return $value;
        } else {
            return '';
        }
    }

    function get_city_listing($state_id) {
        $res = 0;
        $this->db->select('id, ci_name');
        $this->db->from('city');
        $this->db->where(array('state_id' => $state_id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        return $res;
    }

    function fetch_city_name($id) {
        $res = 0;
        $this->db->select('id, ci_name');
        $this->db->from('city');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['ci_name'];
        }
        return $res;
    }

    public function change_status_mail($full_name, $email, $status) {//echo '***'.$email;exit;
        $st = "Inactive";
        if ($status == 1) {
            $st = "Active";
        }
        $subject = 'Admin:: Welcome to Tracking Portal';
        $body = "<b>Hello <b>" . $full_name . "</b>,
								 <br><br><br>
								Your Status has been changed by admin, You are currently:<b>" . $st . "</b>.
 								<br><br><br>Thanks & Regards<br><b>Team Admin</b>";
        $mail_conf = array(
            'subject' => "User Status Changed",
            'to_email' => $email,
            'cc' => 'superadmin@'.$_SERVER['SERVER_NAME'],
            'from_email' => 'admin@'.$_SERVER['SERVER_NAME'],
            'from_name' => 'Admin',
            'body_part' => $body
        );
        if ($this->dmailer->mail_notify($mail_conf)) {
            return true;
        } return false; //echo redirect('accounts/create');
    }

    function create_link($username, $password) {
        $username = base64_encode($username);
        $password = base64_encode($password);
        $url = base_url() . 'user_master/verify/' . $username . '/' . $password;

        return $url;
    }

    function link_verification($username, $password) {
        $UpdateData = array("is_verified" => 1, "status" => '0');
        $whereData = array('user_name' => $username, 'password' => md5($password));

        $this->db->set($UpdateData);
        $this->db->where($whereData);
        $this->db->update('backend_user');
        if ($this->db->affected_rows() > 0) {//echo $this->db->last_query();exit;
            $this->session->set_flashdata('success', 'User Updated Successfully!');
            return 1;
        } else {
            return 0;
        }
    }

    function delete_user($id) {
        $this->db->where('user_id', $id);
        if ($this->db->delete('backend_user')) {
            return '1';
        }
    }
	
	  function delete_user_confirm_otp($id, $confirm_otp) {		  
		  //$id = $this->uri->segment(3);
			//$otp =  $frmData['otp'];
         $this->db->where(array('user_id' => $id, 'otp' => $confirm_otp));
		  //$this->db->where(array('user_id' => $id));
        if ($this->db->delete('backend_user')) {
            return '1';
        }
    }

    function delete_child_users($id) {

        $this->db->where_in('user_id', explode(',', $id));
        if ($this->db->delete('backend_user')) {
            return '1';
        }
    }
    public function getPlants(){  
        $this->db->select('pm.*');
        $this->db->from('plant_master AS pm');
        $this->db->join('assign_plants_to_users AS ap', 'ap.plant_id = pm.plant_id');
        $this->db->where(['ap.user_id'=>$this->session->userdata('admin_user_id')]);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
                return $query->result_array();
        }
        return false;
    }
	
		public function send_email_with_otp_delete_customer($customer_id, $otp_code)
		{//echo '***'.$email;exit;
		$subject    =  'ISPL Admin:: OTP to Delete a Customer';
		$body			=	"Hello <b>ISPL Admin</b>,
								<br><br>
								 This is auto generated secure OTP to delete your customer. <br> Please conceder the deleted customer can't be recovered.<br>
								<br>OTP Code is : <b>".$otp_code."</b><br />
								<br>Customer ID is : <b>".$customer_id."</b><br />
								<br>Customer Company Name is : <b>".getUserFullNameById($customer_id)."</b><br />
 								 "."".'
								<br><br><br>Thanks & Regards<br><b>Team ISPL</b>';												
		$mail_conf =  array(
		'subject'=>$subject,
		'to_email'=>'sikka@innovigent.in',
		'from_email'=>'admin@'.$_SERVER['SERVER_NAME'],
		'from_name'=> 'ISPL Admin',
		'body_part'=>$body
		);
		if($this->dmailer->mail_notify($mail_conf)){
		 return true;
		} return true; //echo redirect('accounts/create');
	 }
	 
	 
	 	function update_otp_delete_customer($customer_id, $otp_code) {
           
                $UpdateData = array(
                    
					"otp" => $otp_code,
					"otp_datetime" => date('Y-m-d H:i:s')
                );
				
            $whereData = array(
                'user_id' => $customer_id
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('backend_user')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'OTP Updated Successfully!');
                return true;
            }
        
    }


}
