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

        $this->db->select(['bu.*','ap.plant_id']);
        $this->db->from('backend_user AS bu');
        $this->db->join('assign_plants_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('bu.user_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
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
                    "pan " => $frmData['pan'],
                    "f_name" => $frmData['f_name'],
                    "l_name" => $frmData['l_name'],
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
                    "pan " => $frmData['pan'],
                    "f_name" => $frmData['f_name'],
                    "l_name" => $frmData['l_name'],
                    "user_name" => $frmData['user_name'],
                    "email_id" => $frmData['user_email'],
                    "state " => $frmData['state_name'],
                    "remark " => $frmData['remark'],
                    "city " => $frmData['city_name'],
                    "last_updated_by" => $user_id,
                    "last_updated_on" => date('Y-m-d H:i:s')
                );
            }
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
            $insertData = array(
                "customer_code " => $frmData['customer_code'],
                "mobile_no" => $frmData['user_mobile'],
                "industry" => $frmData['industry'],
                "pan " => $frmData['pan'],
                "f_name" => $frmData['f_name'],
                "l_name" => $frmData['l_name'],
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
               /* I commented this to solve the email sending issue on creatting a new user
			   $assignedPlant = [
                    "plant_id" => $frmData['plant_id'],
                    "user_id" => $this->db->insert_id(),
                    "assigned_by" => $this->session->userdata('admin_user_id')
                ];
                $this->db->insert("assign_plants_to_users", $assignedPlant);
				*/
                $full_name = $frmData['f_name'] . ' ' . $frmData['l_name'];
                $username = $frmData['user_name'];
				
                // echo $this->db->last_query();exit;
				$email = $frmData['user_email']; 
                $this->user_registration_mail($full_name, $username, $password, $email);
                $this->session->set_flashdata('success', 'User Added Successfully!');
                return 1;
            }
            return 0;
        }
    }

	public function user_registration_mail($full_name = '', $username = '', $password = '', $email) {//echo '***'.$email;exit;
        $link = $this->create_link($username, $password);
        $subject = 'Admin:: Welcome to Tracking Portal';
        $body = "<b>Hello <b>" . $full_name . "</b>,
								</b><br><br><r>
								Your registration process has been complete.
								<br>Your login credentials are:<br />
								<br>Your can login with the given credentials after admin approval:<br />
								User Name:  " . $username . "<br>
								Password is:<b>" . $password . '</b>
								Verify your email by clicking here:' . $link . '
								<br>Please wait for admin approval!<br><br>Thanks & Regards<br><b>Team Admin</b>';
        $mail_conf = array(
            'subject' => $subject,
            'to_email' => $email,
            'cc' => 'superadmin@innovigents.com',
            'from_email' => 'admin@innovigents.com',
            'from_name' => 'Admin',
            'body_part' => $body
        );
        if ($this->dmailer->mail_notify($mail_conf)) {
            return true;
        } return false; //echo redirect('accounts/create');
    }
	
    function update_profile_data($frmData) {
        $user_id = $this->session->userdata('admin_user_id');
        if (!empty($user_id)) {
            if (empty($frmData['profile_photo'])) {
                // $this->db->set('profile_photo', $frmData['profile_photo']);
                $UpdateData = array(
                    "mobile_no" => $frmData['user_mobile'],
                    "industry" => $frmData['industry'],
                    "pan " => $frmData['pan'],
                    "f_name" => $frmData['f_name'],
                    "l_name" => $frmData['l_name'],
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
                    "industry" => $frmData['industry'],
                    "pan " => $frmData['pan'],
                    "f_name" => $frmData['f_name'],
                    "l_name" => $frmData['l_name'],
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
            'cc' => 'superadmin@innovigents.com',
            'from_email' => 'admin@innovigents.com',
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

}
