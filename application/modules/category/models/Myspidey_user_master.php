<?php
 class Myspidey_user_group_permissions_model extends CI_Model
 {
    function __construct()
    {
        parent::__construct();
     }
  /*
  * Get importantnos by ID
  */
    function saveMenu($frmData)
    {  
		$user_id 	= $this->session->userdata('user_id');
 		// echo '*<pre>';print_r($frmData);exit;
 		//echo '***'.$id = $frmData['menu_id'];exit;
		if(!empty($frmData['menu_id'])){
			$UpdateData = array(
				"menu"=>$frmData['title'],
				"order_by"=>$frmData['order'],
				"lastupdated_on"=>date('Y-m-d H: i: s'),
				"lastupdated_by "=>$user_id,
				"status "=>1
			);
			
			$whereData = array(
            	'id' => $frmData['menu_id']
        	);
	
			$this->db->set($UpdateData);
			$this->db->where($whereData);
			if($this->db->update('menu_master')){
				 $this->session->set_flashdata('Success', 'Menu Updated Successfully!');
			}
		}else{ 
			$insertData=array(
				"menu"=>$frmData['title'],
				"parent"=>0,
				"url"=>$frmData['url'],
				"order_by"=>$frmData['order'],
				"created_on"=>date('Y-m-d H: i: s'),
				"created_by "=>$user_id,
				"status "=>1
			
			);//echo '<pre>';print_r($insertData);exit;
			if($this->db->insert("menu_master", $insertData)){
				$this->session->set_flashdata('Success', 'Menu Added Successfully!');
				return true;
			}return false; 
		}
     }
	 function saveChildData($frmData)
    {  
		$user_id 	= $this->session->userdata('user_id');
 		 //echo '*<pre>';print_r($frmData);exit;
 		//echo '***'.$id = $frmData['menu_id'];exit;
		if(!empty($frmData['menu_id'])){
			$UpdateData = array(
				"menu"=>$frmData['title'],
				"order_by"=>$frmData['order'],
				"lastupdated_on"=>date('Y-m-d H: i: s'),
				"lastupdated_by "=>$user_id,
				"status "=>1
			);
			
			$whereData = array(
            	'id' => $frmData['menu_id']
        	);
	
			$this->db->set($UpdateData);
			$this->db->where($whereData);
			if($this->db->update('menu_master')){
				 $this->session->set_flashdata('Success', 'Child Menu Updated Successfully!');
			}
		}else{ 
			$parent = $frmData['parent_id'];
			$insertData=array(
				"menu"=>$frmData['title'],
				"parent"=>$parent,
				"url"=>$frmData['url'],
				"order_by"=>$frmData['order'],
				"created_on"=>date('Y-m-d H: i: s'),
				"created_by "=>$user_id,
				"status "=>1
			
			);//echo '<pre>';print_r($insertData);exit;
			if($this->db->insert("menu_master", $insertData)){
				$this->session->set_flashdata('Success', 'Child Menu Added Successfully!');
				return true;
			}return false; 
		}
     }
	function load_listingData($frmData)
    { 
		$this->db->select('*');
		$this->db->from('menu_master');
		$this->db->where(array('status'=>1, 'parent'=>0));
 		$this->db->order_by("order_by", "ASC");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = true;
		}
		return $res;
		 
 	}
	
	function get_edited_data($id)
    { 
		$this->db->select('*');
		$this->db->from('menu_master');
		$this->db->where(array("id"=>$id));
 		$this->db->order_by("created_on", "DESC");
		$query = $this->db->get();
		//echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			 $res = $res[0];
		}
		return $res;
  	}
	
	function get_ownership($id)
    { 
		$this->db->select('*');
		$this->db->from('user_group_master');
		$this->db->where(array("status"=>'1'));
 		$this->db->order_by("usergroup_id", "ASC");
		$query = $this->db->get();
		//echo '***'.$this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			 //$res = $res[0];
		}
		return $res;
  	}
	
	 function save_group($frmData)
    {  
		$user_id 	=1;// $this->session->userdata('user_id');
		$raw_id = 1;
 		 // echo '*<pre>';print_r($frmData);exit;
 		//echo '***'.$id = $frmData['menu_id'];exit;
		if(!empty($frmData['menu_id'])){
			$UpdateData = array(
				"usergroup_name"=>$frmData['name'],
				"usergroup_desc"=>$frmData['description'],
				"ownershipid"=>$frmData['ownership'],
				"user_id "=>$user_id,
				"rwa_id "=>$raw_id,
				"created_by"=>$user_id,
				"lastupdated_on"=>date('Y-m-d H: i: s'),
				"status "=>0
			);
			
			$whereData = array(
            	'id' => $frmData['menu_id']
        	);
	
			$this->db->set($UpdateData);
			$this->db->where($whereData);
			if($this->db->update('user_group_master')){
				 $this->session->set_flashdata('Success', 'Menu Updated Successfully!');
			}
		}else{ 
			$insertData=array(
				"usergroup_name"=>$frmData['name'],
				"usergroup_desc"=>$frmData['description'],
				"ownershipid"=>$frmData['ownership'],
				"user_id "=>$user_id,
				"rwa_id "=>$raw_id,
				"created_by"=>$user_id,
				"lastupdated_on"=>date('Y-m-d H: i: s'),
				"status "=>1
			
			);//echo '<pre>';print_r($insertData);exit;
			if($this->db->insert("user_group_master", $insertData)){
				$this->session->set_flashdata('Success', 'Menu Added Successfully!');
				return true;
			}return false; 
		}
     }
	
  }