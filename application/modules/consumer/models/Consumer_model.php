<?php
 class Consumer_model extends CI_Model {
     function __construct() {
         parent::__construct();
     }
	 
     
    function save_consumer_selection_criteria($frmData) {   
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($frmData['criteria_id'])) {
           
                $UpdateData = array(
                    "customer_id " => $user_id,
                    "promotion_type" => $frmData['promotion_type'],
                    "consumer_gender" => $frmData['consumer_gender'],
					"consumer_min_age" => $frmData['consumer_min_age'],
                    "consumer_max_age" => $frmData['consumer_max_age'],
                    "consumer_city" => $frmData['consumer_city'],
                    "consumer_pin" => $frmData['consumer_pin'],
					"updated_by_id" => $user_id,
					"update_date" => date('Y-m-d H:i:s'),
                    "status" => 1
                    
                );
            
			
			
				
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'criteria_id' => $frmData['criteria_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('consumer_selection_criteria')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Consumer Selection Criteria Updated Successfully!');
                return 1;
            }
        } else {
            
            $insertData = array(
					"customer_id " => $user_id,
                    "promotion_type" => $frmData['promotion_type'],
                    "consumer_gender" => $frmData['consumer_gender'],
					"consumer_min_age" => $frmData['consumer_min_age'],
                    "consumer_max_age" => $frmData['consumer_max_age'],
                    "consumer_city" => $frmData['consumer_city'],
                    "consumer_pin" => $frmData['consumer_pin'],
					"created_by_id" => $user_id,
					"create_date" => date('Y-m-d H:i:s'),
                    "status" => 1
            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("consumer_selection_criteria", $insertData)) {
				
				
                $this->session->set_flashdata('success', 'Consumer Selection Criteria Added Successfully!');
                return 1;
            }
            return 0;
        }
    }
	
    

    function get_total_consumer_selection_criterias_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR CONCAT(f_name, ' ', l_name) LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and (customer_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('customer_id' => $user_id));
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('consumer_selection_criteria');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
    function get_list_consumer_selection_criterias_all($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(user_name LIKE '%$srch_string%' OR mobile_no LIKE '%$srch_string%' OR email_id LIKE '%$srch_string%' OR CONCAT(f_name, ' ', l_name) LIKE '%$srch_string%' OR f_name LIKE '%$srch_string%' OR l_name LIKE '%$srch_string%') and (customer_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('customer_id' => $user_id));
        }

        $this->db->select('*');
        $this->db->from('consumer_selection_criteria');
        $this->db->order_by('criteria_id', 'desc');
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


    function get_consumer_selection_criteria_details($id) {

        $this->db->select('*');
        $this->db->from('consumer_selection_criteria');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('criteria_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	
	    function checkPromotionType($uname, $uid = '') {
        $result = 'true';
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
        $this->db->select('criteria_id');
        $this->db->from('consumer_selection_criteria');
        if (!empty($uid)) {
            $this->db->where(array('criteria_id!=' => $uid));
        }
        $this->db->where(array('promotion_type' => $uname));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['criteria_id'];
            $result = 'false';
        }
        return $result;
    }
	
	

}
