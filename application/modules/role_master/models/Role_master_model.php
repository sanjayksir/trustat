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

    function save_assigned_functionalities_to_role($functionality_array, $roles, $role_quantity, $customer_idF, $is_edit = '') {  // echo '<pre>cccccccc';print_r($this->uri->segment(3));exit;
        $functionality_arr = json_decode($functionality_array, true);
        $user_id = $this->session->userdata('admin_user_id');
				if($user_id==1){
			 			$customer_id = $customer_idF;
			 			 }else{
			 				$customer_id = $user_id;	
						 }
		
       // if ($this->input->post('is_edit') == 1) {
            $this->db->query('delete from assign_functionalities_to_role where role_id="' . $roles . '" and customer_id="' . $customer_id . '"');
	// $this->db->query('delete from assign_functionalities_to_role where role_id="' . $roles . '" AND customer_id="' . $customer_id . '"');
        //}
        foreach ($functionality_arr as $functionalities) {###ediiit case
            //if($this->input->post('is_edit')==1){
            /* 		$updatedData = array("plant_id"		=> $plants);				 
              $whereData = array('user_id' => $users,"assigned_by"	=> $user_id);
              $this->db->set($updatedData);
              $this->db->where($whereData);
              $this->db->update("assign_plants_to_users", $insertData);
              echo '***'.$this->db->last_query(); */

            //}else{###add case
            $insertData = array(
                "functionality_id" => $functionalities,
                "role_id" => $roles,
				"role_quantity" => $role_quantity,
				"customer_id" => $customer_id,
				"update_date" => date('Y-m-d h:i:s'),
                "assigned_by" => $user_id
            );
           // if ($this->check_exists_users_role($roles, $user_id) == 0) {
                $this->db->insert("assign_functionalities_to_role", $insertData);
                // echo $this->db->last_query();
           // }
            //}
        }
        $this->session->set_flashdata('success', 'Functionality Assigned Successfully!');
        return 1;
    }

    function check_exists_users_role($roles, $user_id) {
        $this->db->select('id');
        $this->db->from('assign_functionalities_to_role');
        $this->db->where(array('role_id' => $roles, 'assigned_by' => $user_id));
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
	
  function get_total_roles_count($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR cpm_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 
       

        $this->db->select('count(1) as total_rows');
        $this->db->from('role_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
    function get_roles_list($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR cpm_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 

        $this->db->select('*');
        $this->db->from('role_master');
        $this->db->order_by('id', 'ASC');
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
	
	
	
	
 function checkRoleSlug($role_name, $role_slug) {
        $result = 'true';
		/*
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
		*/
		//$role_slug = getAttributeSlugByName($Profile_Attribute);
        $this->db->select('role_name_value, role_name_slug');
        $this->db->from('role_master');
		/*
        if (!empty($cpmid)) {
            $this->db->where(array('cpm_id!=' => $cpmid));
        }*/
        $this->db->where(array('role_name_value' => $role_name));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$result = $res[0]['role_name_value'];
            $result = 'false';
        }
        return $result;
    }
	

	function save_role($frmData) {   
        $user_id = $this->session->userdata('admin_user_id'); 
		
        if (!empty($frmData['id'])) {           
                $UpdateData = array(
					"role_name_value" => $frmData['role_name_value'],
					"created_by_id" => $user_id,
					"modify_date" => date('Y-m-d H:i:s'),
                    "status" => 1                    
                );
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'id' => $frmData['id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('role_master')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Role Updated Successfully!');
                return 1;
            }
        } else {            
            $insertData = array(
					"created_by_id " => $user_id,
					"role_name_value" => $frmData['role_name_value'],
					"role_name_slug" => $frmData['role_name_slug'],
					"create_date" => date('Y-m-d H:i:s'),
                    "status" => 1
            ); //echo '<pre>';print_r($insertData);exit;
            if ($this->db->insert("role_master", $insertData)) {
                $this->session->set_flashdata('success', 'Role Added Successfully!');
                return 1;
            }
            return 0;
        }
    }

	
	function get_role_details($id) {
        $this->db->select('*');
        $this->db->from('role_master');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }

		// functionalities	Start
	
	 function get_total_functionalities_count($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(functionality_name_value LIKE '%$srch_string%' OR functionality_name_slug LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 
       

        $this->db->select('count(1) as total_rows');
        $this->db->from('functionality_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
	
    function get_functionalities_list($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(functionality_name_value LIKE '%$srch_string%' OR functionality_name_slug LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 

        $this->db->select('*');
        $this->db->from('functionality_master');
        $this->db->order_by('id', 'ASC');
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
	
	
	
	
 function checkFunctionalitySlug($functionality_name, $functionality_slug) {
        $result = 'true';
		/*
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
		*/
		//$functionality_slug = getAttributeSlugByName($Profile_Attribute);
        $this->db->select('functionality_name_value, functionality_name_slug');
        $this->db->from('functionality_master');
		/*
        if (!empty($cpmid)) {
            $this->db->where(array('cpm_id!=' => $cpmid));
        }*/
        $this->db->where(array('functionality_name_value' => $functionality_name));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$result = $res[0]['functionality_name_value'];
            $result = 'false';
        }
        return $result;
    }
	

	function save_functionality($frmData) {   
        $user_id = $this->session->userdata('admin_user_id'); 
		
        if (!empty($frmData['id'])) {           
                $UpdateData = array(
					"functionality_name_value" => $frmData['functionality_name_value'],
					"created_by_id" => $user_id,
					"modify_date" => date('Y-m-d H:i:s'),
                    "status" => 1                    
                );
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'id' => $frmData['id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('functionality_master')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Functionality Updated Successfully!');
                return 1;
            }
        } else {            
            $insertData = array(
					"created_by_id " => $user_id,
					"functionality_name_value" => $frmData['functionality_name_value'],
					"functionality_name_slug" => $frmData['functionality_name_slug'],
					"create_date" => date('Y-m-d H:i:s'),
                    "status" => 1
            ); //echo '<pre>';print_r($insertData);exit;
            if ($this->db->insert("functionality_master", $insertData)) {
                $this->session->set_flashdata('success', 'Functionality Added Successfully!');
                return 1;
            }
            return 0;
        }
    }

	
	function get_functionality_details($id) {
        $this->db->select('*');
        $this->db->from('functionality_master');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	
			// functionalities	ends
			
		//	Auto Email MIS configuration Management starts
	
	 function get_total_auto_email_mis_masters_count($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR mis_report_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 
       

        $this->db->select('count(1) as total_rows');
        $this->db->from('auto_email_mis_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
    function get_auto_email_mis_masters_list($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR mis_report_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 

        $this->db->select('*');
        $this->db->from('auto_email_mis_master');
        $this->db->order_by('r_id', 'ASC');
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
	
	
	
	
 function checkAutoEmailMISMasterSlug($mis_report_name, $mis_report_slug) {
        $result = 'true';
		/*
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
		*/
		//$functionality_slug = getAttributeSlugByName($Profile_Attribute);
        $this->db->select('mis_report_name, mis_report_slug');
        $this->db->from('auto_email_mis_master');
		/*
        if (!empty($cpmid)) {
            $this->db->where(array('cpm_id!=' => $cpmid));
        }*/
        $this->db->where(array('mis_report_name' => $mis_report_name));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$result = $res[0]['mis_report_name'];
            $result = 'false';
        }
        return $result;
    }
	

	function save_auto_email_mis_master($frmData) {   
        $user_id = $this->session->userdata('admin_user_id'); 
		
        if (!empty($frmData['r_id'])) {           
                $UpdateData = array(
					"mis_report_name" => $frmData['mis_report_name'],
					"created_by_id" => $user_id,
					"modify_date" => date('Y-m-d H:i:s'),
                    "status" => 1                    
                );
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'r_id' => $frmData['r_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('auto_email_mis_master')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Auto Email MIS Master Updated Successfully!');
                return 1;
            }
        } else {            
            $insertData = array(
					"created_by_id " => $user_id,
					"mis_report_name" => $frmData['mis_report_name'],
					"mis_report_slug" => $frmData['mis_report_slug'],
					"create_date" => date('Y-m-d H:i:s'),
                    "status" => 1
            ); //echo '<pre>';print_r($insertData);exit;
            if ($this->db->insert("auto_email_mis_master", $insertData)) {
                $this->session->set_flashdata('success', 'Auto Email MIS Master Added Successfully!');
                return 1;
            }
            return 0;
        }
    }

	
	function get_auto_email_mis_master_details($id) {
        $this->db->select('*');
        $this->db->from('auto_email_mis_master');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('r_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }

	// Auto Email MIS configuration Management ends
	
	
			//	Auto Email MIS Customer starts
	
	 function get_total_auto_email_mis_customer_count($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        $customer_id = $this->uri->segment(3);
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR mis_report_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        }        

        $this->db->select('count(1) as total_rows');
        $this->db->from('auto_email_mis_customer');
		$this->db->where(array('customer_id' => $customer_id));
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
	
    function get_auto_email_mis_customer_list($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        $customer_id = $this->uri->segment(3);
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR mis_report_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 

        $this->db->select('*');
        $this->db->from('auto_email_mis_customer');
		$this->db->where(array('customer_id' => $customer_id));
        $this->db->order_by('rc_id', 'ASC');
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
	
	/*
	function get_total_auto_email_mis_customer_count($srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		 $customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('customer_id', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%')");
			}
		}
		$this->db->select('count(1) as total_rows');
		$this->db->from('auto_email_mis_customer');
		if($user_id>1){
		$this->db->where('customer_id', $user_id);
			}else{
			$this->db->where('customer_id', $customer_id);
			}
    		$query = $this->db->get(); //echo '***'.$this->db->last_query();
 		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$result_data = $result[0]['total_rows'];
 		}
		return $result_data;
    }

		function get_auto_email_mis_customer_list($limit,$start,$srch_string='') {
		$user_id 	= $this->session->userdata('admin_user_id');
		$customer_id = $this->uri->segment(3);
		if($user_id>1){
			//$this->db->where('customer_id', $user_id);
			if(!empty($srch_string)){ 
 				$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%') and (customer_id=$user_id)");
			}else{
				$this->db->where(array('customer_id'=>$user_id));
			}			
		}else{
			if(!empty($srch_string)){ 
 			$this->db->where("(product_name LIKE '%$srch_string%' OR product_sku LIKE '%$srch_string%' OR product_description LIKE '%$srch_string%')");
			}
		}
		
		$this->db->select("*");
		$this->db->from("auto_email_mis_customer");
		if($user_id>1){
		$this->db->where('customer_id', $user_id);
			}else{
			$this->db->where('customer_id', $customer_id);
			}
		
		$this->db->order_by("rc_id", " desc");
		$this->db->limit($limit, $start);
        $resultDt = $this->db->get()->result_array();//echo $this->db->last_query();
		return $resultDt ;
    }
	*/
 function checkAutoEmailMISCustomerSlug($mis_report_slug, $customer_id) {
        $result = 'true';
		$customer_ids = $this->uri->segment(4);
		/*
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
		*/
		//$functionality_slug = getAttributeSlugByName($Profile_Attribute);
        $this->db->select('mis_report_slug, customer_id');
        $this->db->from('auto_email_mis_customer');
		/*
        if (!empty($cpmid)) {
            $this->db->where(array('cpm_id!=' => $cpmid));
        }*/
        $this->db->where(array('mis_report_slug' => $mis_report_slug, 'customer_id' => $customer_id));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$result = $res[0]['mis_report_name'];
            $result = 'false';
        }
        return $result;
    }
	

	function save_auto_email_mis_customer($frmData) {   
        $user_id = $this->session->userdata('admin_user_id'); 
		$customer_id = $this->uri->segment(3);
        if (!empty($frmData['rc_id'])) {           
                $UpdateData = array(
					"created_by_id" => $user_id,
					"customer_id" => $frmData['customer_id'],
					//"mis_report_name" => getAutoEmailMISMasterNameBySlug($frmData['mis_report_slug']),
					//"mis_report_slug" => $frmData['mis_report_slug'],
					"auto_email_frequency" => $frmData['auto_email_frequency'],
					"mis_data_duration" => $frmData['mis_data_duration'],
					"active_status" => $frmData['active_status'],
					"to_email_ids" => $frmData['to_email_ids'],
					"email_subject" => $frmData['email_subject'],
					"email_body" => $frmData['email_body'],
					"modify_date" => date('Y-m-d H:i:s')
                );
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'rc_id' => $frmData['rc_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('auto_email_mis_customer')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Auto Email MIS Customer Updated Successfully!');
                return 1;
            }
        } else {            
            $insertData = array(
					"created_by_id " => $user_id,
					"customer_id" => $frmData['customer_id'],
					"mis_report_name" => getAutoEmailMISMasterNameBySlug($frmData['mis_report_slug']),
					"mis_report_slug" => $frmData['mis_report_slug'],
					"auto_email_frequency" => $frmData['auto_email_frequency'],
					"mis_data_duration" => $frmData['mis_data_duration'],
					"active_status" => $frmData['active_status'],
					"to_email_ids" => $frmData['to_email_ids'],
					"email_subject" => $frmData['email_subject'],
					"email_body" => $frmData['email_body'],
					"create_date" => date('Y-m-d H:i:s')
            ); //echo '<pre>';print_r($insertData);exit;
            if ($this->db->insert("auto_email_mis_customer", $insertData)) {
                $this->session->set_flashdata('success', 'Auto Email MIS Customer Added Successfully!');
                return 1;
            }
            return 0;
        }
    }

	
	function get_auto_email_mis_customer_details($id) {
        $this->db->select('*');
        $this->db->from('auto_email_mis_customer');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('rc_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }

	// Auto Email MIS Customer ends
	
	// Customer Billing Master starts 
	
	 function get_total_customer_billing_master_count($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(billin_particular_name LIKE '%$srch_string%' OR billin_particular_slug LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 
       

        $this->db->select('count(1) as total_rows');
        $this->db->from('customer_billing_particular_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
	
    function get_customer_billing_master_list($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(billin_particular_name LIKE '%$srch_string%' OR billin_particular_slug LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 

        $this->db->select('*');
        $this->db->from('customer_billing_particular_master');
        $this->db->order_by('cbpm_id', 'ASC');
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
	
	
	
	
 function checkCustomerBillingMasterSlug($mis_report_name, $mis_report_slug) {
        $result = 'true';
		/*
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
		*/
		//$functionality_slug = getAttributeSlugByName($Profile_Attribute);
        $this->db->select('mis_report_name, mis_report_slug');
        $this->db->from('auto_email_mis_master');
		/*
        if (!empty($cpmid)) {
            $this->db->where(array('cpm_id!=' => $cpmid));
        }*/
        $this->db->where(array('mis_report_name' => $mis_report_name));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$result = $res[0]['mis_report_name'];
            $result = 'false';
        }
        return $result;
    }
	

	function save_customer_billing_master($frmData) {   
        $user_id = $this->session->userdata('admin_user_id'); 
		
        if (!empty($frmData['cbpm_id'])) {           
                $UpdateData = array(
					"billin_particular_name" => $frmData['billin_particular_name'],
					"created_by_id" => $user_id,
					"date_updated" => date('Y-m-d H:i:s')
                );
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'cbpm_id' => $frmData['cbpm_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('customer_billing_particular_master')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Customer Billing Master Updated Successfully!');
                return 1;
            }
        } else {            
            $insertData = array(
					"created_by_id " => $user_id,
					"billin_particular_name" => $frmData['billin_particular_name'],
					"billin_particular_slug" => $frmData['billin_particular_slug'],
					"date_created" => date('Y-m-d H:i:s')
            ); //echo '<pre>';print_r($insertData);exit;
            if ($this->db->insert("customer_billing_particular_master", $insertData)) {
                $this->session->set_flashdata('success', 'Customer Billing Master Added Successfully!');
                return 1;
            }
            return 0;
        }
    }

	
	function get_customer_billing_master_details($id) {
        $this->db->select('*');
        $this->db->from('customer_billing_particular_master');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('cbpm_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }

	// Customer Billing configuration Management ends
	
	
			//	Auto Email MIS Customer starts
	/*
	 function get_total_auto_email_mis_customer_count($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        $customer_id = $this->uri->segment(3);
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR mis_report_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        }        

        $this->db->select('count(1) as total_rows');
        $this->db->from('auto_email_mis_customer');
		$this->db->where(array('customer_id' => $customer_id));
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
	
    function get_auto_email_mis_customer_list($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        $customer_id = $this->uri->segment(3);
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR mis_report_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } 

        $this->db->select('*');
        $this->db->from('auto_email_mis_customer');
		$this->db->where(array('customer_id' => $customer_id));
        $this->db->order_by('rc_id', 'ASC');
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
	*/
	// Customer billing master
	

}
