<?php

 class Category_model extends CI_Model

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

		$user_id 	= (!empty($this->session->userdata('admin_user_id')))?$this->session->userdata('admin_user_id'):1;

 	  	//echo '*<pre>';print_r($frmData);exit;

 		//echo '***'.$id = $frmData['menu_id'];exit;

		if(!empty($frmData['id'])){

			$UpdateData = array(

				"categoryName"=>$frmData['category']

			);

			

			$whereData = array(

            	'category_Id' => $frmData['id']

        	);

	

			$this->db->set($UpdateData);

			$this->db->where($whereData);

			if($this->db->update('categories')){//echo '===query===='.$this->db->last_query();

				 $this->session->set_flashdata('success', 'Categiory Updated Successfully!');

			}

		}else{ 

			$insertData=array(

				"categoryName"=>$frmData['category'],

				"parent"=>$frmData['parent'],

				"created_by"=>$this->session->userdata('admin_user_id'),

				"status "=>0

  			

			);//echo '<pre>';print_r($insertData);exit;

			if($this->db->insert("categories", $insertData)) {echo '===query===='.$this->db->last_query();

				$this->session->set_flashdata('success', 'Categiory Added Successfully!');

				return true;

			}return false; 

		}

     }

	 function saveChildData($frmData)

    {  

		$user_id 	= (!empty($this->session->userdata('user_id')))?$this->session->userdata('admin_user_id'):1;

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

			if($this->db->update('categories')){

				 $this->session->set_flashdata('success', 'Child Menu Updated Successfully!');

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

			if($this->db->insert("categories", $insertData)){

				$this->session->set_flashdata('success', 'Child Menu Added Successfully!');

				return true;

			}return false; 

		}

     }

	function load_listingData($frmData)

    { 

		$this->db->select('*');

		$this->db->from('categories');

		$this->db->where(array('parent'=>0));

 		$this->db->order_by("categoryName", "ASC");

		$query = $this->db->get();

		//echo '**'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			$result = true;

		}

		return $res;

		 

 	}

	

	function get_edited_data($id)

    { 

		$this->db->select('*');

		$this->db->from('categories');

		$this->db->where(array("category_Id"=>$id));

 		$this->db->order_by("createdDate", "DESC");

		$query = $this->db->get();

		//echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			 $res = $res[0];

		}

		return $res;

  	}

	

	function get_ownership_bkp()

    { 

		$id =  getGroupId();

		$this->db->select('*');

		$this->db->from('categories');

		$this->db->where(array('status'=>'1','ownershipid'=>'1'));

		//$this->db->where('status','1');

		if(!empty($id)){

				//$this->db->where(array("ownershipid"=>$id));

				$this->db->where("(ownershipid=$id or usergroup_id=$id)");

		}

 		$this->db->order_by("usergroup_id", "ASC");

		$query = $this->db->get();

		// echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			 //$res = $res[0];

		}

		return $res;

  	}

	

	function get_ownership_bkp_new()

    { 

		$ownership_id = '1';

		$user_id 	= $this->session->userdata('admin_user_id');

		

		$id =  getGroupId();

		$this->db->select('*');

		$this->db->from('user_group_master');

		

		if($user_id=='1'){

			$this->db->where_in('ownershipid',array('0','1'));

		}else{

			$this->db->where(array('ownershipid'=>'1'));

		}

		

		

		

		$this->db->where(array('status'=>'1'));

 		if(!empty($id) && $id!=1){

				//$this->db->where(array("ownershipid"=>$id));

				$this->db->where("usergroup_id",$id);

		}

		

		

		

		

 		$this->db->order_by("usergroup_id", "ASC");

		$query = $this->db->get();

		 // echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			 //$res = $res[0];

		}

		return $res;

  	}

	

 

	function get_ownership()

    { //echo 'kamal';exit;

		$ownership_id = '1';

		$user_id 	= $this->session->userdata('admin_user_id');

		

		$id =  getGroupId();

		$this->db->select('*');

		$this->db->from('categories');

		

		if($user_id=='1'){

			$this->db->where_in('ownershipid',array('0','1'));

		}else{

			//$this->db->or_where('ownershipid',$id);

			$this->db->or_where('usergroup_id',$id);

			//$this->db->where(array('ownershipid'=>'1'));

		}

		

		

		

		$this->db->where(array('status'=>'1'));

 		if(!empty($id)){

				//$this->db->where(array("ownershipid"=>$id));

				//$this->db->where("usergroup_id",$id);

		}

		

		

		

		

 		$this->db->order_by("usergroup_id", "ASC");

		$query = $this->db->get();

		 // echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			 //$res = $res[0];

		}

		return $res;

  	}

	

	

	 

	

	function get_ownership_user()

    { 

		$ownership_id = '1';

		$user_id 	= $this->session->userdata('admin_user_id');

		

		$id =  getGroupId();

		$this->db->select('*');

		$this->db->from('categories');

		

		if($user_id=='1'){

			 $this->db->where('ownershipid!=',0);

		}else{

			$this->db->or_where('ownershipid',$id);

			$this->db->or_where('usergroup_id',$id);

			//$this->db->where(array('ownershipid'=>'1'));

		}

		

		

		

		$this->db->where(array('status'=>'1'));

 		 

		

		

		

 		$this->db->order_by("usergroup_id", "ASC");

		$query = $this->db->get();

		  // echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			 //$res = $res[0];

		}

		return $res;

  	}

	

	 function save_group($frmData)

    {  

		$user_id 	= (!empty($this->session->userdata('admin_user_id')))?$this->session->userdata('admin_user_id'):1;

		$raw_id		= 0;

 	  //echo '*<pre>';print_r($frmData);exit;

 		//echo '***'.$id = $frmData['menu_id'];exit;

		if(!empty($frmData['group_id'])){

			$UpdateData = array(

				"usergroup_name"=>$frmData['name'],

				"usergroup_desc"=>$frmData['description'],

				"ownershipid"=>$frmData['ownership'],

				"user_id "=>$user_id,

				"lastupdated_by"=>$user_id,

				"lastupdated_on"=>date('Y-m-d H: i: s'),

				"status "=>'1'

			);

			

			$whereData = array(

            	'usergroup_id' => $frmData['group_id']

        	);

	

			$this->db->set($UpdateData);

			$this->db->where($whereData);

			if($this->db->update('categories')){

				 $this->session->set_flashdata('Success', 'Category Updated Successfully!');

				// redirect(base_url().'myspidey_user_group_permissions/add_group/');

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

				"status "=>'1'

			

			);

			

			if($this->db->insert("categories", $insertData)){

				//echo $this->db->last_query();exit;

			// echo '<pre>';print_r($insertData);exit;

				$this->session->set_flashdata('Success', 'Category Added Successfully!');

				//redirect(base_url().'myspidey_user_group_permissions/add_group/');

				return true;

			}return false; 

		}

     }

	function save_permissions_data($frmData)

    {  

 		//$raw_id		= 1;

 		//echo '*<pre>';print_r($frmData);exit;

		//	echo '***'.count($frmData['permission_data']['menu']);exit;

		if(count($frmData['permission_data']['menu'])==0){

			return false;

		}

		

		$user_id 		= (!empty($this->session->userdata('admin_user_id')))?$this->session->userdata('admin_user_id'):1;

 		$usergroup_id 	= $this->input->post('group_id');

		$user_name	 	= $this->session->userdata('user_name');//getUserNameById($user_id);

		$rwa_id 		= $this->input->post('rwa_id');

 		$id 			= $frmData['permission_data']['permission_tbl_id'];

		$show_hide_chks = '';

		$read_chks		= '';

		$write_chks		= '';

		$delete_chks	= '';

		$print_chks	    = '';

		$export_chks    = '';

		

 		if(count($frmData['permission_data']['menu']['read'])>0){

		 	$read_chks = implode(',',$frmData['permission_data']['menu']['read']);

		 }

		 if(count($frmData['permission_data']['menu']['write'])>0){

		 	$write_chks =implode(',',$frmData['permission_data']['menu']['write']);

		 }

		 if(count($frmData['permission_data']['menu']['delete'])>0){

		 	$delete_chks =implode(',',$frmData['permission_data']['menu']['delete']);

		 }

		 if(count($frmData['permission_data']['menu']['print'])>0){

		 	$print_chks =implode(',',$frmData['permission_data']['menu']['print']);

		 } 

		 if(count($frmData['permission_data']['menu']['export'])>0){

		 	$export_chks =implode(',',$frmData['permission_data']['menu']['export']);

		 }

		 if(count($frmData['permission_data']['menu']['show_hide'])>0){

		 	$show_hide_chks =implode(',',$frmData['permission_data']['menu']['show_hide']);

		 }

		 

		 

		if(!empty($id)){

			$UpdateData=array(

				"show_hide_chks"=>$show_hide_chks,

				"read_chks"=>$read_chks,

				"write_chks"=>$write_chks,

				"delete_chks"=>$delete_chks,

				"print_chks"=>$print_chks,

				"export_chks"=>$export_chks,

				"userid"=>$user_id,

				"username"=>$user_name,

				"lastupdated_by"=>$user_id,

				"lastupdated_on"=>date('Y-m-d H: i: s'),

			);//echo '<pre>';print_r($insertData);exit;

			$whereData = array('id' => $id);

	

			$this->db->set($UpdateData);

			$this->db->where($whereData);

			if($this->db->update('categories')){

				 $this->session->set_flashdata('Success', 'Permission Updated Successfully!');

				 redirect(base_url().'myspidey_user_group_permissions/add_group/');

			}

		}else{ 

			$insertData=array(

				"show_hide_chks"=>$show_hide_chks,

				"read_chks"=>$read_chks,

				"write_chks"=>$write_chks,

				"delete_chks"=>$delete_chks,

				"print_chks"=>$print_chks,

				"export_chks"=>$export_chks,

				"usergroup_id"=>$usergroup_id,

				"userid"=>$user_id,

				"username"=>$user_name,

				"rwa_id"=>$rwa_id,

				"created_on"=>date('Y-m-d H: i: s'),

 				"created_by"=>$user_id,

				"lastupdated_by"=>$user_id,

				"lastupdated_on"=>date('Y-m-d H: i: s'),

				"status "=>'1'

 			);//echo '<pre>';print_r($insertData);exit;

			if($this->db->insert("menu_master_permission", $insertData)){

				//echo $this->db->last_query();exit;

				$this->session->set_flashdata('Success', 'Permission Allowed Successfully!');

				redirect(base_url().'myspidey_user_group_permissions/add_group/');

				return true;

			}return false; 

		}

     }

	 

	 function get_group_permission_data(){

		$usergroup_id = $this->uri->segment(3);

	 	$this->db->select('*');

		$this->db->from('menu_master_permission');

		$this->db->where(array("status"=>'1', 'usergroup_id'=>$usergroup_id));

 		$this->db->order_by("usergroup_id", "ASC");

		$query = $this->db->get();

		//echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			 //$res = $res[0];

		}

		return $res; 

	 }

	 

	 function getGroupData($id)

    { 

		$this->db->select('*');

		$this->db->from('user_group_master');

		$this->db->where(array("usergroup_id"=>$id)); 		 

		$query = $this->db->get();

		//echo '***'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();

			 $res = $res[0];

		}

		return $res;

  	}

	

	 function view_users()

    {	

		$res='';

		$id=  $this->input->post('id'); 

		if(!empty($this->input->post('id'))){ 

			$this->db->select('*');

			$this->db->from('backend_user');

			$this->db->where(array("usergroup_id"=>$id)); 		 

			$query = $this->db->get();

			 //echo '***'.$this->db->last_query();exit;

			if ($query->num_rows() > 0) {

				$res = $query->result_array();

				// echo '***<pre>';print_r($res);exit;

 			}

		}

			return $res;

  	}

	

	

	

	 function get_group_permission_rows($id=''){

		 $res = 0;

		$id = $this->input->post('id');

 	 	$this->db->select('count(1) as cnt');

		$this->db->from('menu_master_permission');

		$this->db->where(array("status"=>'1', 'usergroup_id'=>$id));

 		$query = $this->db->get();

		//echo '***'.$this->db->last_query();exit;

		if ($query->result_array()) {

			$res = $query->result_array();

		 	echo $res[0]['cnt'];exit;

			 //$res = $res[0];

		}

 
	 }

 
	 function deleteMenu($ParentId='', $childId){
 		 $sql = "delete from categories where category_Id = '".$ParentId."'";
 		if($this->db->query($sql)){
 			return '1';
 		}
 		return '0';
 	 }

	 
  }