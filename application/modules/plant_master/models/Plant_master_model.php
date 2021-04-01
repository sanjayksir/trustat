<?php

class plant_master_model extends CI_Model {

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

    function get_plant_details($id) {
        $res = 0;
        $this->db->select('*');
        $this->db->from('plant_master');
        $this->db->where(array('plant_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            // $res=1;
        }
        return $res;
    }

	function get_location_details_plant($id) {
        $res = 0;
        $this->db->select('*');
        $this->db->from('location_master');
        $this->db->where(array('location_id' => $id, 'location_type' => 'Plant'));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            // $res=1;
        }
        return $res;
    }
	
	
    function save_user($frmData) { //echo '<pre>';print_r($frmData);exit;
        $user_id = $this->session->userdata('admin_user_id');
        $is_parent = $this->session->userdata('admin_user_id');
        if (isset($frmData['ccadmin']) && $frmData['ccadmin'] != '') {
            $is_parent = $frmData['ccadmin'];
        }

        if (!empty($frmData['plant_id'])) {
            $UpdateData = array(
                "plant_name" => $frmData['plant_name'],
                "email_id" => $frmData['user_email'],
                "phone " => $frmData['user_mobile'],
                "gst" => $frmData['gst'],
                "address" => $frmData['address'],
                "remark" => $frmData['remark'],
                "state" => $frmData['state_name'],
                "created_by" => $is_parent,
            );

            $whereData = array(
                'plant_id' => $frmData['plant_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('plant_master')) {
                // echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Plant Updated Successfully!');
                return 1;
            }
        } else {
            //$password = generate_password(6);
            $insertData = array(
                "plant_code" => $frmData['customer_code'],
                "plant_name" => $frmData['plant_name'],
                "email_id" => $frmData['user_email'],
                "phone " => $frmData['user_mobile'],
                "gst" => $frmData['gst'],
                "address" => $frmData['address'],
                "remark" => $frmData['remark'],
                "status" => 0,
                "state" => $frmData['state_name'],
                "created_by" => $is_parent
            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("plant_master", $insertData)) {
                $plant_code = $frmData['plant_code'];
                $plant_name = $frmData['plant_name'];
                // echo $this->db->last_query();exit;
                $this->user_registration_mail($plant_code, $plant_name, $frmData['user_email']);
                $this->session->set_flashdata('success', 'Plant Added Successfully!');
                return 1;
            }
            return 0;
        }
    }

    public function user_registration_mail($plant_code = '', $plant_name = '', $email) {//echo '***'.$email;exit;
        $subject = 'Admin:: Welcome to Tracking Portal';
        $body = "<b>Hello <b>User</b>,
								</b><br><br><r>
								 A plant has been created.
								<br>Your Plant Code is :" . $plant_code . "<br />
								<br>Plant name is :" . $plant_name . "<br />
 								 " . "" . '</b>
								<br><br><br>Thanks & Regards<br><b>Team Admin</b>';
        $mail_conf = array(
            'subject' => $subject,
            'to_email' => $email,
            'from_email' => 'admin@'.$_SERVER['SERVER_NAME'],
            'from_name' => 'Admin',
            'body_part' => $body
        );
        if ($this->dmailer->mail_notify($mail_conf)) {
            return true;
        } return false; //echo redirect('accounts/create');
    }

    function checkDuplicateUser($username) {
        $result = '';
        $this->db->select('plant_id');
        $this->db->from('plant_master');

        $this->db->where(array('plant_name' => $username));

        $query = $this->db->get();

        //echo '***'.$this->db->last_query();exit;

        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['plant_id'];
        }
        return $result;
    }

    function checkEmail($email, $uid = '') {
        $result = 'true';
        $this->db->select('plant_id');
        $this->db->from('plant_master');
        if (!empty($uid)) {
            $this->db->where(array('plant_id!=' => $uid));
        }
        $this->db->where(array('email_id' => $email));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['plant_id'];
            $result = 'false';
        }
        return $result;
    }

    function checkPantName($plantName, $uid = '') {
        $result = 'true';
        $this->db->select('plant_id');
        $this->db->from('plant_master');
        if (!empty($uid)) {
            $this->db->where(array('plant_id!=' => $uid));
        }
        $this->db->where(array('plant_name' => $plantName));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            if (!empty($res[0]['plant_id'])) {
                $result = 'false';
            }
        }
        //echo '==='.$result;exit;
        return $result;
    }

    ## List Users

    function get_user_list($user_session_Id) {
        $result = '';
        $this->db->select('*');
        $this->db->from('plant_master');

        $this->db->where(array('created_by' => $user_session_Id));

        $query = $this->db->get();

        //echo '***'.$this->db->last_query();exit;

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
    }

    function total_get_user_list_all($srch_string = '') {
        $result = '';
        $user_id = $this->session->userdata('admin_user_id');
        $srch_string = trim($srch_string);
        if ($user_id > 1) {
            //$this->db->where('created_by', $user_id);
            if (!empty($srch_string)) {
                $this->db->where("(plant_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR plant_code LIKE '%$srch_string%' OR phone LIKE '%$srch_string%') and (created_by=$user_id)");
            } else {
                $this->db->where(array('created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(plant_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR plant_code LIKE '%$srch_string%' OR phone LIKE '%$srch_string%')");
            }
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('plant_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }

    function get_user_list_all($limit, $start, $srch_string = '') {
        $result = '';
        $srch_string = trim($srch_string);
        $user_id = $this->session->userdata('admin_user_id');
        if ($user_id > 1) {
            //$this->db->where('created_by', $user_id);
            if (!empty($srch_string)) {
                $this->db->where("(plant_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%'  OR plant_code LIKE '%$srch_string%' OR phone LIKE '%$srch_string%') and (created_by=$user_id)");
            } else {
                $this->db->where(array('created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(plant_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR plant_code LIKE '%$srch_string%' OR phone LIKE '%$srch_string%')");
            }
        }

        $this->db->select('*');
        $this->db->from('plant_master');
        $this->db->order_by('plant_id', 'desc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get(); //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
    }
	// Location Type Names 
	function total_get_location_type_list_all($srch_string = '') {
        $result = '';
        $user_id = $this->session->userdata('admin_user_id');
        $srch_string = trim($srch_string);
        if ($user_id > 1) {
            //$this->db->where('created_by', $user_id);
            if (!empty($srch_string)) {
                $this->db->where("(location_type_name LIKE '%$srch_string%') and (created_by=$user_id)");
            } else {
                $this->db->where(array('created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(location_type_name LIKE '%$srch_string%')");
            }
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('location_type_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }

    function get_location_type_list_all($limit, $start, $srch_string = '') {
        $result = '';
        $srch_string = trim($srch_string);
        $user_id = $this->session->userdata('admin_user_id');
        if ($user_id > 1) {
            //$this->db->where('created_by', $user_id);
            if (!empty($srch_string)) {
                $this->db->where("(location_type_name LIKE '%$srch_string%') and (created_by=$user_id)");
            } else {
                $this->db->where(array('created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(location_type_name LIKE '%$srch_string%')");
            }
        }

        $this->db->select('*');
        $this->db->from('location_type_master');
        $this->db->order_by('id', 'asc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get(); //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
    }
	
	function get_location_type_details($id) {
        $res = 0;
        $this->db->select('*');
        $this->db->from('location_type_master');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            // $res=1;
        }
        return $res;
    }
	
	function save_location_type($frmData) { //echo '<pre>';print_r($frmData);exit;
        
        if (!empty($frmData['id'])) {
            $UpdateData = array(
                "location_type_name" => $frmData['location_type_name'],
				"status" => 1,
                "modify_date" => date('Y-m-d H:i:s')
            );

            $whereData = array(
                'id' => $frmData['id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('location_type_master')) {
                // echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Location Type Updated Successfully!');
                return 1;
            }
        } else {
            //$password = generate_password(6);
            $insertData = array(
                "location_type_name" => $frmData['location_type_name'],
				"created_by_id" => 1,
				"status" => 1,
                "create_date" => date('Y-m-d H:i:s'),
				"modify_date" => date('Y-m-d H:i:s')
            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("location_type_master", $insertData)) {
                
                $this->session->set_flashdata('success', 'Location Type Added Successfully!');
                return 1;
            }
            return 0;
        }
    }
	
	function checkLocationTypeName($location_type_name, $location_type_id = '') {
        $result = 'true';
        $this->db->select('id');
        $this->db->from('location_type_master');
        if (!empty($location_type_id)) {
            $this->db->where(array('id!=' => $location_type_id));
        }
        $this->db->where(array('location_type_name' => $location_type_name));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            if (!empty($res[0]['id'])) {
                $result = 'false';
            }
        }
        //echo '==='.$result;exit;
        return $result;
    }
	
	// end location type name 
	
	// Location Names 
	function total_get_location_list_all($srch_string = '') {
        $result = '';
        $user_id = $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
        $srch_string = trim($srch_string);
        if ($user_id > 1) {
			 if (!empty($customer_id)) {
            //$this->db->where('created_by', $user_id);
            if (!empty($srch_string)) {
                $this->db->where("(location_code LIKE '%$srch_string%' OR location_type LIKE '%$srch_string%' OR location_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR phone LIKE '%$srch_string%') and (created_by=$customer_id)");
            } else {
               // $this->db->where(array('created_by' => $user_id));
            }
			} else {
                if (!empty($srch_string)) {
                $this->db->where("(location_code LIKE '%$srch_string%' OR location_type LIKE '%$srch_string%' OR location_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR phone LIKE '%$srch_string%') and (created_by=$user_id)");
            } else {
                $this->db->where(array('created_by' => $user_id));
            }
            }
			
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(location_code LIKE '%$srch_string%' OR location_type LIKE '%$srch_string%' OR location_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR phone LIKE '%$srch_string%')");
            }
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('location_master');
		if($user_id>1){
			$this->db->where('created_by', $user_id);
		}else{
		$this->db->where('created_by', $customer_id);
		}
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }

    function get_location_list_all($limit, $start, $srch_string = '') {
        $result = '';
        $srch_string = trim($srch_string);
        $user_id = $this->session->userdata('admin_user_id');
        $customer_id = $this->uri->segment(3);        
        if ($user_id > 1) {
			 if (!empty($customer_id)) {
            //$this->db->where('created_by', $user_id);
            if (!empty($srch_string)) {
                $this->db->where("(location_code LIKE '%$srch_string%' OR location_type LIKE '%$srch_string%' OR location_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR phone LIKE '%$srch_string%') and (created_by=$customer_id)");
            } else {
               // $this->db->where(array('created_by' => $user_id));
            }
			} else {
                if (!empty($srch_string)) {
                $this->db->where("(location_code LIKE '%$srch_string%' OR location_type LIKE '%$srch_string%' OR location_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR phone LIKE '%$srch_string%') and (created_by=$user_id)");
            } else {
                $this->db->where(array('created_by' => $user_id));
            }
            }			
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(location_code LIKE '%$srch_string%' OR location_type LIKE '%$srch_string%' OR location_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR phone LIKE '%$srch_string%')");
            }
        }
        $this->db->select('*');
        $this->db->from('location_master');
		if($user_id>1){
			$this->db->where('created_by', $user_id);
		}else{
		$this->db->where('created_by', $customer_id);
		}
        $this->db->order_by('location_id', 'asc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get(); //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
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
	
		function get_assign_loyalty_activity_role_details($assign_id) {
        $res = 0;
        $this->db->select('*');
        $this->db->from('assign_loyalty_functionalities_rolewise');
        $this->db->where(array('assign_id' => $assign_id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            // $res=1;
        }
        return $res;
    }
	
	function save_location($frmData) { //echo '<pre>';print_r($frmData);exit;
        $user_id = $this->session->userdata('admin_user_id');
        $is_parent = $this->session->userdata('admin_user_id');
        if (isset($frmData['ccadmin']) && $frmData['ccadmin'] != '') {
            $is_parent = $frmData['ccadmin'];
        }

        if (!empty($frmData['location_id'])) {
			
			if(!empty($frmData['location_image'])){
 				$this->db->set('location_image', $frmData['location_image']);
			}
			
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
				//"location_image" => $frmData['location_image'],
                "remark" => $frmData['remark'],
                "status" => 1,
                "state" => $frmData['state_name'],
                "created_by" => $user_id,
				"updated_date" => date("Y-m-d H:i:s")
            );

            $whereData = array(
                'location_id' => $frmData['location_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('location_master')) {
                // echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Location Updated Successfully!');
                return 1;
            }
        } else {
            //$password = generate_password(6);
            $insertData = array(
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
				"location_image" => $frmData['location_image'],
                "remark" => $frmData['remark'],
                "status" => 1,
                "state" => $frmData['state_name'],
                "created_by" => $user_id,
				"created_date" => date("Y-m-d H:i:s")
				
            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("location_master", $insertData)) {
                //$plant_code = $frmData['plant_code'];
                //$plant_name = $frmData['plant_name'];
                // echo $this->db->last_query();exit;
               // $this->user_registration_mail($plant_code, $plant_name, $frmData['user_email']);
                $this->session->set_flashdata('success', 'Location Added Successfully!');
                return 1;
            }
            return 0;
        }
    }
	




  function save_userL($frmData) {   //echo '<pre>';print_r($frmData);exit;
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
					"brand_loyalty_redemption_type"=>$frmData['brand_loyalty_redemption_type'],
					"brand_loyalty_store_redemption_message"=>$frmData['brand_loyalty_store_redemption_message'],
					"trustat_coupon_type_name_number"=>$frmData['trustat_coupon_type_name_number'],
					"customer_loyalty_type" => $frmData['Customer_Loyalty_Type'],
					"customer_microsite_url" => $frmData['customer_microsite_url'],
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
					"customer_loyalty_type" => $frmData['Customer_Loyalty_Type'],
					"customer_microsite_url" => $frmData['customer_microsite_url'],
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
				"brand_loyalty_redemption_type"=>$frmData['brand_loyalty_redemption_type'],
				"brand_loyalty_store_redemption_message"=>$frmData['brand_loyalty_store_redemption_message'],
				"trustat_coupon_type_name_number"=>$frmData['trustat_coupon_type_name_number'],
				"customer_loyalty_type" => $frmData['Customer_Loyalty_Type'],
				"customer_microsite_url" => $frmData['customer_microsite_url'],
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
                return 1;
            }
            return 0;
        }
    }	
	
	function save_assign_loyalty_activity_role($frmData) { //echo '<pre>';print_r($frmData);exit;
        $user_id = $this->session->userdata('admin_user_id');		
		/*
		if($user_id==1){
			 			$customer_id = $this->uri->segment(4);
			 			 }else{
			 				$customer_id = $user_id;	
						 } 
        $is_parent = $this->session->userdata('admin_user_id');
		      
	   if (isset($frmData['ccadmin']) && $frmData['ccadmin'] != '') {
            $is_parent = $frmData['ccadmin'];
        }	*/	
        if (!empty($frmData['assign_id'])) {
            $UpdateData = array(
					"role_id" => $frmData['role_id'],
					"product_management" => $frmData['product_management'],
					"bar_code_ordering" => $frmData['bar_code_ordering'],
					"bar_code_delivery_online" => $frmData['bar_code_delivery_online'],
					"bar_code_printing_online" => $frmData['bar_code_printing_online'],
					"bar_code_printing_offline" => $frmData['bar_code_printing_offline'],
					"bar_code_activation_for_all_levels" => $frmData['bar_code_activation_for_all_levels'],
					"dispatch_from_plant_or_warehouse_to_warehouse" => $frmData['dispatch_from_plant_or_warehouse_to_warehouse'],
					"receipt_at_warehouse_or_plant" => $frmData['receipt_at_warehouse_or_plant'],
					"dispatch_from_plant_or_warehouse_to_customers" => $frmData['dispatch_from_plant_or_warehouse_to_customers'],
					"product_return_from_customer" => $frmData['product_return_from_customer'],
					"physical_inventory_check" => $frmData['physical_inventory_check'],
					"packaging" => $frmData['packaging'],
					"unpackaging" => $frmData['unpackaging'],
					"physical_inventory_on_hand" => $frmData['physical_inventory_on_hand'],
					"link_barcode_with_production_batch_id" => $frmData['link_barcode_with_production_batch_id'],
					"shipper_box_barcode_activation" => $frmData['shipper_box_barcode_activation'],
					"ship_out_order" => $frmData['ship_out_order'],
					"activate_printed_batched_of_codes" => $frmData['activate_printed_batched_of_codes'],
					"loyalty_redemption_while_consumer_shopping" => $frmData['loyalty_redemption_while_consumer_shopping'],					
					"functionality_1" => $frmData['functionality_1'],
					"functionality_2" => $frmData['functionality_2'],
					"functionality_3" => $frmData['functionality_3'],
					"functionality_4" => $frmData['functionality_4'],
					"functionality_5" => $frmData['functionality_5'],
					"functionality_6" => $frmData['functionality_6'],
					"functionality_7" => $frmData['functionality_7'],
					"functionality_8" => $frmData['functionality_8'],
					"functionality_9" => $frmData['functionality_9'],
					"functionality_10" => $frmData['functionality_10'],
					"functionality_11" => $frmData['functionality_11'],
					"functionality_12" => $frmData['functionality_12'],
					"functionality_13" => $frmData['functionality_13'],
					"functionality_14" => $frmData['functionality_14'],
					"functionality_15" => $frmData['functionality_15'],
					"functionality_16" => $frmData['functionality_16'],
					"functionality_17" => $frmData['functionality_17'],
					"functionality_18" => $frmData['functionality_18'],
					"functionality_19" => $frmData['functionality_19'],
					"functionality_20" => $frmData['functionality_20'],
					"functionality_21" => $frmData['functionality_21'],
					"assigned_by" => $user_id,
					"customer_id" => $frmData['ccadmin'],
					"status" => 1
            );
	
            $whereData = array(
                'assign_id' => $frmData['assign_id']
            );
	
            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if($this->db->update('assign_loyalty_functionalities_rolewise')) {
                 //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Loyalty Points Updated Successfully!');
                return 1;
            }
        } else {
            $insertData = array(
                "role_id" => $frmData['role_id'],
				"product_management" => $frmData['product_management'],
				"bar_code_ordering" => $frmData['bar_code_ordering'],
				"bar_code_delivery_online" => $frmData['bar_code_delivery_online'],
				"bar_code_printing_online" => $frmData['bar_code_printing_online'],
				"bar_code_printing_offline" => $frmData['bar_code_printing_offline'],
				"bar_code_activation_for_all_levels" => $frmData['bar_code_activation_for_all_levels'],
				"dispatch_from_plant_or_warehouse_to_warehouse" => $frmData['dispatch_from_plant_or_warehouse_to_warehouse'],
				"receipt_at_warehouse_or_plant" => $frmData['receipt_at_warehouse_or_plant'],
				"dispatch_from_plant_or_warehouse_to_customers" => $frmData['dispatch_from_plant_or_warehouse_to_customers'],
				"product_return_from_customer" => $frmData['product_return_from_customer'],
				"physical_inventory_check" => $frmData['physical_inventory_check'],
				"packaging" => $frmData['packaging'],
				"unpackaging" => $frmData['unpackaging'],
				"physical_inventory_on_hand" => $frmData['physical_inventory_on_hand'],
				"link_barcode_with_production_batch_id" => $frmData['link_barcode_with_production_batch_id'],
				"shipper_box_barcode_activation" => $frmData['shipper_box_barcode_activation'],
				"ship_out_order" => $frmData['ship_out_order'],
				"activate_printed_batched_of_codes" => $frmData['activate_printed_batched_of_codes'],
				"loyalty_redemption_while_consumer_shopping" => $frmData['loyalty_redemption_while_consumer_shopping'],					
				"scan_for_list_following_codes" => $frmData['scan_for_list_following_codes'],
					"functionality_1" => $frmData['functionality_1'],
					"functionality_2" => $frmData['functionality_2'],
					"functionality_3" => $frmData['functionality_3'],
					"functionality_4" => $frmData['functionality_4'],
					"functionality_5" => $frmData['functionality_5'],
					"functionality_6" => $frmData['functionality_6'],
					"functionality_7" => $frmData['functionality_7'],
					"functionality_8" => $frmData['functionality_8'],
					"functionality_9" => $frmData['functionality_9'],
					"functionality_10" => $frmData['functionality_10'],
					"functionality_11" => $frmData['functionality_11'],
					"functionality_12" => $frmData['functionality_12'],
					"functionality_13" => $frmData['functionality_13'],
					"functionality_14" => $frmData['functionality_14'],
					"functionality_15" => $frmData['functionality_15'],
					"functionality_16" => $frmData['functionality_16'],
					"functionality_17" => $frmData['functionality_17'],
					"functionality_18" => $frmData['functionality_18'],
					"functionality_19" => $frmData['functionality_19'],
					"functionality_20" => $frmData['functionality_20'],
					"functionality_21" => $frmData['functionality_21'],
				"assigned_by" => $user_id,
				"customer_id" => $frmData['ccadmin'],
				"status" => 1,
				"created_date" => date("Y-m-d H:i:s")
				
            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("assign_loyalty_functionalities_rolewise", $insertData)) {
                //$plant_code = $frmData['plant_code'];
                //$plant_name = $frmData['plant_name'];
                // echo $this->db->last_query();exit;
               // $this->user_registration_mail($plant_code, $plant_name, $frmData['user_email']);
                $this->session->set_flashdata('success', 'Loyalty Points Assigned Successfully!');
                return 1;
            }
            return 0;
        }
    }
	
	
	function checkLocationName($location_name, $location_id = '') {
        $result = 'true';
        $this->db->select('location_id');
        $this->db->from('location_master');
        if (!empty($location_id)) {
            $this->db->where(array('location_id!=' => $location_id));
        }
        $this->db->where(array('location_name' => $location_name));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            if (!empty($res[0]['location_id'])) {
                $result = 'false';
            }
        }
        //echo '==='.$result;exit;
        return $result;
    }
	
	// end location name 

    function change_status($id, $value) {
        $this->db->set(array('status' => $value));
        $this->db->where(array('plant_id' => $id));
        if ($this->db->update('plant_master')) {
            return $value;
        } else {
            return '';
        }
        //echo '***'.$this->db->last_query();exit;
    }

	function change_location_status($id, $value) {
        $this->db->set(array('status' => $value));
        $this->db->where(array('location_id' => $id));
        if ($this->db->update('location_master')) {
            return $value;
        } else {
            return '';
        }
        //echo '***'.$this->db->last_query();exit;
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

    function save_assign_plants_sku($plant_array, $sku_array) {  //echo '<pre>';print_r($frmData);exit;
        $plant_arr = json_decode($plant_array, true);
        //print_r($plant_arr);
        $sku_arr = json_decode($sku_array, true);
        $user_id = $this->session->userdata('admin_user_id');
        //echo 'delete from assign_plants where plant_id="'.$plant_arr.'" and assigned_by="'.$user_id.'"';
        $this->db->query('delete from assign_plants where plant_id="' . $plant_arr[0] . '" and assigned_by="' . $user_id . '"');

        if (!empty($frmData['plant_id'])) {
            /* $UpdateData = array(
              "plant_id"	=> $frmData['plant_name'],
              "product_id"		=> $frmData['user_email'],
              "assigned_by"	=> $user_id
              );

              $whereData = array(
              'plant_id' => $frmData['plant_id']
              );

              $this->db->set($UpdateData);
              $this->db->where($whereData);
              if($this->db->update('plant_master')){
              // echo '***'.$this->db->last_query();exit;
              $this->session->set_flashdata('success', 'Plant Assigned Successfully!');
              return 1;
              } */
        } else {
            //$password = generate_password(6);
            foreach ($plant_arr as $plant) {
                foreach ($sku_arr as $sku) {

                    $insertData = array(
                        "plant_id" => $plant,
                        "product_id" => $sku,
                        "assigned_by" => $user_id
                    );
                    if ($this->check_exists($plant, $sku) == 0) {
                        $this->db->insert("assign_plants", $insertData);
                    }
                }
            }
            $this->session->set_flashdata('success', 'Plant Assigned Successfully!');
            return 1;
        }
        return '0';
    }

	
	function save_assign_locations_sku($plant_array, $sku_array) {  //echo '<pre>';print_r($frmData);exit;
        $plant_arr = json_decode($plant_array, true);
        //print_r($plant_arr);
        $sku_arr = json_decode($sku_array, true);
        //$user_id = $this->session->userdata('admin_user_id');
		$user_id = getOwnerCustNameByLocationId($plant_arr[0]);
        //echo 'delete from assign_plants where plant_id="'.$plant_arr.'" and assigned_by="'.$user_id.'"';
        $this->db->query('delete from assign_locations where location_id="' . $plant_arr[0] . '" and assigned_by="' . $user_id . '"');

        if (!empty($frmData['location_id'])) {
            /* $UpdateData = array(
              "plant_id"	=> $frmData['plant_name'],
              "product_id"		=> $frmData['user_email'],
              "assigned_by"	=> $user_id
              );

              $whereData = array(
              'plant_id' => $frmData['plant_id']
              );

              $this->db->set($UpdateData);
              $this->db->where($whereData);
              if($this->db->update('plant_master')){
              // echo '***'.$this->db->last_query();exit;
              $this->session->set_flashdata('success', 'Plant Assigned Successfully!');
              return 1;
              } */
        } else {
            //$password = generate_password(6);
            foreach ($plant_arr as $plant) {
                foreach ($sku_arr as $sku) {

                    $insertData = array(
                        "location_id" => $plant,
                        "product_id" => $sku,
                        "assigned_by" => $user_id
                    );
                    if ($this->check_exists($plant, $sku) == 0) {
                        $this->db->insert("assign_locations", $insertData);
                    }
                }
            }
            $this->session->set_flashdata('success', 'Location Assigned Successfully!');
            return 1;
        }
        return '0';
    }
	
	
    function save_assign_plants_users($plant_array, $plant_controller_user, $assigned_by, $is_edit = '') {  
        $user_id = $this->session->userdata('admin_user_id');
        $plant_arr = json_decode($plant_array, true); 
       if($user_id==1){
                   
            if ($this->input->post('is_edit') == 1) {
                $this->db->query('delete from assign_plants_to_users where user_id="' . $plant_controller_user . '" and assigned_by="' . $assigned_by . '"');
            }
            foreach ($plant_arr as $plants) { 
                $insertData = array(
                    "plant_id" => $plants,
                    "user_id" => $plant_controller_user,
                    "assigned_by" => $assigned_by
                );
                if ($this->check_exists_users_plant($plants, $users) == 0) {
                    $this->db->insert("assign_plants_to_users", $insertData);
                     // echo $this->db->last_query();
                } 
            }
       }else{ 
           $users =$plant_controller_user;
            if ($this->input->post('is_edit') == 1) {
                $this->db->query('delete from assign_plants_to_users where user_id="' . $users . '" and assigned_by="' . $user_id . '"');
            }
            foreach ($plant_arr as $plants) { 
                $insertData = array(
                    "plant_id" => $plants,
                    "user_id" => $users,
                    "assigned_by" => $user_id
                );
                if ($this->check_exists_users_plant($plants, $users) == 0) {
                    $this->db->insert("assign_plants_to_users", $insertData); 
                } 
            } 
       } 
        $this->session->set_flashdata('success', 'Plant Assigned Successfully!');
        return 1;
    }
	
	
	function save_assign_locations_users($plant_array, $plant_controller_user, $assigned_by, $is_edit = '') {  
        $user_id = $this->session->userdata('admin_user_id');
        $plant_arr = json_decode($plant_array, true); 
       if($user_id==1){
                   
            if ($this->input->post('is_edit') == 1) {
                $this->db->query('delete from assign_locations_to_users where user_id="' . $plant_controller_user . '" and assigned_by="' . $assigned_by . '"');
            }
            foreach ($plant_arr as $plants) { 
                $insertData = array(
                    "location_id" => $plants,
                    "user_id" => $plant_controller_user,
                    "assigned_by" => $assigned_by
                );
                if ($this->check_exists_users_location($plants, $users) == 0) {
                    $this->db->insert("assign_locations_to_users", $insertData);
                     // echo $this->db->last_query();
                } 
            }
       }else{ 
           $users =$plant_controller_user;
            if ($this->input->post('is_edit') == 1) {
                $this->db->query('delete from assign_locations_to_users where user_id="' . $users . '" and assigned_by="' . $user_id . '"');
            }
            foreach ($plant_arr as $plants) { 
                $insertData = array(
                    "location_id" => $plants,
                    "user_id" => $users,
                    "assigned_by" => $user_id
                );
                if ($this->check_exists_users_location($plants, $users) == 0) {
                    $this->db->insert("assign_locations_to_users", $insertData); 
                } 
            } 
       } 
        $this->session->set_flashdata('success', 'Location Assigned Successfully!');
        return 1;
    }
	
	
	function save_assign_role_to_activitis($plant_array, $plant_controller_user, $assigned_by, $is_edit = '', $loyalty_points) {  
        $user_id = $this->session->userdata('admin_user_id');
        $plant_arr = json_decode($plant_array, true); 
       if($user_id==1){
                   
            if ($this->input->post('is_edit') == 1) {
                $this->db->query('delete from assign_activities_to_roles where role_id="' . $plant_controller_user . '" and assigned_by="' . $assigned_by . '"');
            }
            foreach ($plant_arr as $plants) { 
                $insertData = array(
                    "activity_id" => $plants,
                    "role_id" => $plant_controller_user,
					"loyalty_points" => $loyalty_points,
                    "assigned_by" => $assigned_by
                );
                if ($this->check_exists_role_activity($plants, $users) == 0) {
                    $this->db->insert("assign_activities_to_roles", $insertData);
                     // echo $this->db->last_query();
                } 
            }
       }else{ 
           $users =$plant_controller_user;
            if ($this->input->post('is_edit') == 1) {
                $this->db->query('delete from assign_activities_to_roles where role_id="' . $users . '" and assigned_by="' . $user_id . '"');
            }
            foreach ($plant_arr as $plants) { 
                $insertData = array(
                    "activity_id" => $plants,
                    "role_id" => $users,
					"loyalty_points" => $loyalty_points,
                    "assigned_by" => $user_id
                );
                if ($this->check_exists_role_activity($plants, $users) == 0) {
                    $this->db->insert("assign_activities_to_roles", $insertData); 
                } 
            } 
       } 
        $this->session->set_flashdata('success', 'Activities Assigned Successfully!');
        return 1;
    }
	
	
	function check_exists_role_activity($plant_id, $userid) {
        $this->db->select('id');
        $this->db->from('assign_activities_to_roles');
        $this->db->where(array('activity_id' => $plant_id, 'role_id' => $userid));
        $query = $this->db->get(); //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['id'];
        }
        return $result;
    }
	
function check_exists_users_location($plant_id, $userid) {
        $this->db->select('id');
        $this->db->from('assign_locations_to_users');
        $this->db->where(array('location_id' => $plant_id, 'user_id' => $userid));
        $query = $this->db->get(); //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['id'];
        }
        return $result;
    }
	
	
    function check_exists_users_plant($plant_id, $userid) {
        $this->db->select('id');
        $this->db->from('assign_plants_to_users');
        $this->db->where(array('plant_id' => $plant_id, 'user_id' => $userid));
        $query = $this->db->get(); //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['id'];
        }
        return $result;
    }

    function check_exists($plant_id, $product_id) {
        $this->db->select('plant_id');
        $this->db->from('assign_plants');
        $this->db->where(array('plant_id' => $plant_id, 'product_id' => $product_id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['plant_id'];
        }
        return $result;
    }

    function qry_change_assign_product_status($id, $value) {//print_r($this->input->post());
        $this->db->set(array('status' => $value));
        $this->db->where(array('plant_id' => $id));
        if ($this->db->update('plant_master')) {
            //echo '***'.$this->db->last_query();exit;
            return $value;
        } else {
            return '';
        }
    }

    function qry_change_assign_plant_status($id, $value, $plant_id) {
        $run_query = 1;
        $plant_arr = explode(',', $plant_id);
        // print_r($plant_arr);exit;
        foreach ($plant_arr as $pltId) {
            $this->db->set(array('status' => $value));
            $this->db->where(array('plant_id' => $pltId, 'user_id' => $id));
            if (!$this->db->update('assign_plants_to_users')) {//echo '**'.$this->db->last_query();exit;
                $run_query = 0;
            }
        }return $value;
    }
	
	function qry_change_assign_location_status($id, $value, $plant_id) {
        $run_query = 1;
        $plant_arr = explode(',', $plant_id);
        // print_r($plant_arr);exit;
        foreach ($plant_arr as $pltId) {
            $this->db->set(array('status' => $value));
            $this->db->where(array('location_id' => $pltId, 'user_id' => $id));
            if (!$this->db->update('assign_locations_to_users')) {//echo '**'.$this->db->last_query();exit;
                $run_query = 0;
            }
        }return $value;
    }

    function delete_plant($id) {
        $this->db->where('plant_id', $id);
        if ($this->db->delete('plant_master')) {
            return '1';
        }
    }

    function delete_associated_products($plant_id, $product_id) {

        $this->db->where(array('plant_id' => $plant_id));
        if ($this->db->delete('assign_plants')) {
            //return '1';
        }

        $product_id = explode(',', $product_id);
        $this->db->where_in('id', $product_id);
        if ($this->db->delete('products')) {
            return '1';
        }
    }
    function getAllPlants($user_id,$limit,$offset,$keyword = null) {        
        if (empty($user_id)) {
            return false;
        }
        
        $admin_id = $this->session->userdata('admin_user_id');
        
        $condition = null;
        if ($admin_id > 1) {
            $condition[] = sprintf('created_by="%d"',$user_id);
        }
        if(!empty($keyword)){
            $condition[] = sprintf('plant_id LIKE "%%%1$s%%" OR plant_name LIKE "%%%1$s%%" OR plant_code LIKE "%%%1$s%%" OR email_id LIKE "%%%1$s%%" OR phone LIKE "%%%1$s%%"',$keyword);
            
        }
        $conditions = trim(implode(' AND ',$condition),' AND ');
        $total = Utils::countAll('plant_master', $conditions);
        $this->db->select('plant_id,plant_name,plant_code,email_id,phone,created_date,status');
        $this->db->from('plant_master');
        if(!empty($conditions)){
            $this->db->where($conditions);
        }
        $this->db->order_by('plant_id', 'DESC');
        if (empty($keyword)) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $items = $query->result_array();
        //echo $this->db->last_query();
        return [$total,$items];
    }

}
