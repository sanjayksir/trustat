<?php

class role_master_model extends CI_Model {

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
            'from_email' => 'admin@innovigents.com',
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
                $this->db->where("(plant_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR plant_code LIKE '%$srch_string%') and (created_by=$user_id)");
            } else {
                $this->db->where(array('created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(plant_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR plant_code LIKE '%$srch_string%')");
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
                $this->db->where("(plant_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%'  OR plant_code LIKE '%$srch_string%') and (created_by=$user_id)");
            } else {
                $this->db->where(array('created_by' => $user_id));
            }
        } else {
            if (!empty($srch_string)) {
                $this->db->where("(plant_name LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR plant_code LIKE '%$srch_string%')");
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

    function save_assign_plants_users($plant_array, $users, $is_edit = '') {  // echo '<pre>cccccccc';print_r($this->uri->segment(3));exit;
        $plant_arr = json_decode($plant_array, true);
        $user_id = $this->session->userdata('admin_user_id');
        if ($this->input->post('is_edit') == 1) {
            $this->db->query('delete from assign_functionalities_to_role where user_id="' . $users . '" and assigned_by="' . $user_id . '"');
        }
        foreach ($plant_arr as $plants) {###ediiit case
            //if($this->input->post('is_edit')==1){
            /* 		$updatedData = array("plant_id"		=> $plants);				 
              $whereData = array('user_id' => $users,"assigned_by"	=> $user_id);
              $this->db->set($updatedData);
              $this->db->where($whereData);
              $this->db->update("assign_plants_to_users", $insertData);
              echo '***'.$this->db->last_query(); */

            //}else{###add case
            $insertData = array(
                "functionality_id" => $plants,
                "role_id" => $users,
                "assigned_by" => $user_id
            );
            if ($this->check_exists_users_plant($plants, $users) == 0) {
                $this->db->insert("assign_functionalities_to_role", $insertData);
                // echo $this->db->last_query();
            }
            //}
        }
        $this->session->set_flashdata('success', 'Functionality Assigned Successfully!');
        return 1;
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
