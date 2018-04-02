<?php

class Editorial extends MX_Controller {

    function __construct() {//echo md5('travel@123');exit;
        parent::__construct();
        // $this->load->library('Ajax_pagination');
		
        $this->load->model('Buzzadmn_model');
		$this->load->helper("url");
		$this->load->library("pagination");
 		$user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
		
        if (empty($user_id) || empty($user_name)) {
            redirect('buzzadmn');
            exit;
        }
    }
   
   function check_login_type($type){
		$login_type = $this->session->userdata('login_type');
		if($login_type!=$type){
			redirect('buzzadmn/dashboard');
		}
   }
	##======================By Kamal ============================##
	
	function index(){
		//echo '<pre>';print_r($this->session->userdata());exit;
		//$this->check_login_type('input'); 
	}
 	function listing() {
			$this->check_login_type('reporter');
			$pagingUri = 4;
 		 ##-------------------------- Pagination Code ------------------------##
			$user_id 				 		= $this->session->userdata('admin_user_id');
 			$srchcondition 					= '';
			if(!empty($this->input->post('srchDD'))){
				$srchcondition 		 		= json_encode($this->input->post());
			}
 			$assigned 			 	 		= 0;
			$status 			 	 		= 0; 
			##
 			$config = array();
			$config["base_url"] 			= base_url() . "buzzadmn/editorial/listing/";
			$config["total_rows"] 			= $this->Buzzadmn_model->totalIdeaList($user_id,$srchcondition,$status,$assigned);
			$config["per_page"] 			= 5;
			$config["uri_segment"] 			= $pagingUri;			
			##
			
			$config['use_page_numbers'] 	= TRUE;
			$config['num_links'] 			= $config["total_rows"];
 			$config['full_tag_open'] 		= "<ul class='pagination'>";
			$config['full_tag_close']		= '</ul>';
			$config['num_tag_open'] 		= '<li>';
			$config['num_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
 			$config['prev_link'] 			= '<i class="fa fa-long-arrow-left"></i>Previous';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
 			$config['next_link'] 			= 'Next<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li> ' ;
 			##
  			$this->pagination->initialize($config);
 			$page 							= ($this->uri->segment($pagingUri)) ? $this->uri->segment($pagingUri) : 0;
 			$data["listData"] 				= $this->Buzzadmn_model->fetchStoryIdeaList($config["per_page"], $page, $user_id,$srchcondition,$status,$assigned);
			$data["links"] 					= $this->pagination->create_links();
 		 ##-------------------------- Pagination Code ------------------------##
		  
        	$this->load->view('Editorial/reporter_listing', $data);
    }
	
    function addStoryIdea($spidey_id = '') {
		$this->check_login_type('reporter');
		if(!empty($this->input->post('hiddenval'))){
			$story_idea 		= $this->input->post('story_idea');
			$eta	    		= $this->input->post('eta');
			$clickedBtn	    	= $this->input->post('clickedBtn');
			$status 			= (!empty($clickedBtn) && $clickedBtn=='Save')?0:1;
			$data['story_idea'] = $story_idea;
			$data['eta'] 		= $eta;
			$data['status'] 	= $status;
			echo $returnVal 	= $this->Buzzadmn_model->saveStoryIdea($data);exit;
		}
          $this->load->view('Editorial/add_story_idea');
    }
	
	function editStoryIdea() {
		$this->check_login_type('reporter');
		$story_id = $this->input->post('storyId');
 		if(!empty($this->input->post('hiddenval')) && !empty($story_id)){
			$story_idea 		= $this->input->post('story_idea');
			$eta	    		= $this->input->post('eta');
			$clickedBtn	   		= $this->input->post('clickedBtn');
			$storyId	   		= $this->input->post('storyId');
			$status 			= (!empty($clickedBtn) && $clickedBtn=='Save')?0:1;
			$data['story_idea'] = $story_idea;
			$data['eta'] 		= $eta;
			$data['status'] 	= $status;
			$data['storyId'] 	= $storyId;
			echo $returnVal 	= $this->Buzzadmn_model->saveStoryIdea($data);exit;
		}
 			$data['resData'] 	= $this->Buzzadmn_model->fetchStoryIdea($this->uri->segment(4));
          	$this->load->view('Editorial/add_story_idea', $data);
    }
	
	function deleteStoryIdea(){
		$story_id = $this->input->post('StoryId');
		$user_id = $this->session->userdata('admin_user_id');
		if(!empty($story_id) && !empty($user_id)){				
			if($this->Buzzadmn_model->deleteStoryIdea($story_id, $user_id)==true){
				 $this->session->set_flashdata('success', 'Idea Deleted Successfully!');
				// redirect(base_url().'Buzzadmn/Editorial/');
				echo '1';exit;
			}
		}
	}
	
	function listing_user_wise() {
		    //$uID 							= $this->uri->segment(4);
			$pagingUri = 5;
 			// echo '****'.$uID = $this->encrypt->encode($uID,'test');//($uID);
		 ##-------------------------- Pagination Code ------------------------##
			$user_id 						= $this->uri->segment(4);
			
			
			$srchcondition 					= '';
			if(!empty($this->input->post('srchDD'))){
				$srchcondition 				= json_encode($this->input->post());
			}
			
			// print_r($this->input->post());//exit;
			$config = array();
			$config["base_url"] 			= base_url() . "buzzadmn/editorial/listing_user_wise/".$user_id.'/';
			$config["total_rows"] 			= $this->Buzzadmn_model->totalIdeaList_user($user_id,$srchcondition);
			$config["per_page"] 			= 5;
			$config["uri_segment"] 			= $pagingUri;			
			##
			
			$config['use_page_numbers'] 	= TRUE;
			$config['num_links'] 			= $config["total_rows"];
 			$config['full_tag_open'] 		= "<ul class='pagination'>";
			$config['full_tag_close']		= '</ul>';
			$config['num_tag_open'] 		= '<li>';
			$config['num_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
 			$config['prev_link'] 			= '<i class="fa fa-long-arrow-left"></i>Previous';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
 			$config['next_link'] 			= 'Next<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li> ' ;
 			##
  			$this->pagination->initialize($config);
 			$page 							= ($this->uri->segment($pagingUri)) ? $this->uri->segment($pagingUri) : 0;
 			$data["listData"] 				= $this->Buzzadmn_model->fetchStoryIdeaList_user($config["per_page"], $page, $user_id,$srchcondition);
			$data["links"] 					= $this->pagination->create_links();
 		 ##-------------------------- Pagination Code ------------------------##
		  
        	$this->load->view('Editorial/editorial_list', $data);
    }
	
	function show_notifications(){
		$story = '';
 		$data['resData'] 	= $this->Buzzadmn_model->show_notifications_story(); 
		echo $story=json_encode($data);exit;
	}
	
	function update_notifications(){
		$story  = '';
		$storyId = $this->input->post('id');
 		echo $res 	= $this->Buzzadmn_model->update_notification_story($storyId); exit;
	}
 	 
	## Saving Story Details===DONE 
	function addStoryDetails() { //echo '<pre>';print_r($this->input->post());exit;
		$this->check_login_type('reporter'); 
		//echo $this->input->post('clickedBtn'); exit;
		if(!empty($this->input->post('hiddenval')) &&  $this->input->post('storyId')!=''){//echo 'kam';exit;
			$pickDesc	 		= $this->input->post('pickDesc');
 			$clickedBtn	    	= $this->input->post('clickedBtn'); 
			$status 			= (!empty($clickedBtn) && $clickedBtn=='Save') ? '0' : '1';
			$spidey_id 			= $this->input->post('storyId');
			$data['pickDesc'] 	= $pickDesc;
 			$data['status'] 	= $status;
			
			## Media Files
			$allImageList_arr 	= $this->input->post('all_Images_list');
			$allImageList 		= $allImageList_arr[0];
			
			$all_videos_list_arr= $this->input->post('all_videos_list');
			$allVideoList 		= $all_videos_list_arr[0];
			
			$all_audios_list_arr= $this->input->post('all_audios_list');
			$allAudioList 		= $all_audios_list_arr[0];
			
			$allAttachment_arr 	= $this->input->post('all_attachments_list');
			$allAttachmentList = $allAttachment_arr[0];
			## Media Files
			$data['images']		= $allImageList;
			$data['videos']		= $allVideoList;
			$data['audios']		= $allAudioList;
			$data['attachments']= $allAttachmentList;
			$data['storyId']	= $spidey_id;
			//echo '<pre>';print_r($data);exit;
			if($this->input->post('clickedBtn')=='Submit' || $this->input->post('clickedBtn')=='Save'){
				 $this->session->set_flashdata('success', 'Idea '.$this->input->post('clickedBtn').' Successfully!');
			}
			
			echo $returnVal 	= $this->Buzzadmn_model->saveIdeaDetail($data);
			exit;
		}
         // $this->load->view('Editorial/add_story_idea_details/');
    }
	
	## OPen Story Details=== DONE
	function addStoryIdeaDetails($spidey_id = '') {
		$this->check_login_type('reporter');
		//echo "dfsdf"; die();
		$data['storyIdea']  = $this->Buzzadmn_model->fetchStoryIdea($spidey_id);		
        $this->load->view('Editorial/add_story_idea_details', $data);
    }
	
	
	### =========================EDITORIAL FUNCTIONS STARTS==================================##
 	function manage() {
 		$this->check_login_type('input'); 
			$pagingUri 						= 4;
 		 ##-------------------------- Pagination Code ------------------------##
			$user_id 						= $this->session->userdata('admin_user_id');
  			$srchcondition 					= '';
			if(!empty($this->input->post('srchDD'))){
				$srchcondition 				= json_encode($this->input->post());
			}
 			// print_r($this->input->post());//exit;
			$config = array();
			$config["base_url"] 			= base_url() . "buzzadmn/editorial/manage/";
			$config["total_rows"] 			= $this->Buzzadmn_model->totalIdeaList($user_id,$srchcondition,'1');
			$config["per_page"] 			= 5;
			$config["uri_segment"] 			= $pagingUri;			
			##
			
			$config['use_page_numbers'] 	= TRUE;
			$config['num_links'] 			= $config["total_rows"];
 			$config['full_tag_open'] 		= "<ul class='pagination'>";
			$config['full_tag_close']		= '</ul>';
			$config['num_tag_open'] 		= '<li>';
			$config['num_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
 			$config['prev_link'] 			= '<i class="fa fa-long-arrow-left"></i>Previous';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
 			$config['next_link'] 			= 'Next<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li> ' ;
 			
			##
  			$this->pagination->initialize($config);
 			$page 							= ($this->uri->segment($pagingUri)) ? $this->uri->segment($pagingUri) : 0;
 			$data["listData"] 				= $this->Buzzadmn_model->fetchStoryIdeaList($config["per_page"], $page, $user_id,$srchcondition,'1');
			$data["links"] 					= $this->pagination->create_links();
 		 ##-------------------------- Pagination Code ------------------------##
		  
        	$this->load->view('Editorial/editorial_list', $data);
    }
 	
	
	## ============================= For user story listing =========================================##
	function userStoryListing() {
 		$this->check_login_type('input'); 
			$pagingUri 						= 4;
 		 ##-------------------------- Pagination Code ------------------------##
			$user_id 						= $this->session->userdata('admin_user_id');
  			$srchcondition 					= '';
			if(!empty($this->input->post('srchDD'))){
				$srchcondition 				= json_encode($this->input->post());
			}
 			// print_r($this->input->post());//exit;
			$config = array();
			$config["base_url"] 			= base_url() . "buzzadmn/editorial/userStoryListing/";
			$config["total_rows"] 			= $this->Buzzadmn_model->user_story_totalIdea_list($user_id,$srchcondition,'1');
			$config["per_page"] 			= 5;
			$config["uri_segment"] 			= $pagingUri;			
			##
 			$config['use_page_numbers'] 	= TRUE;
			$config['num_links'] 			= $config["total_rows"];
 			$config['full_tag_open'] 		= "<ul class='pagination'>";
			$config['full_tag_close']		= '</ul>';
			$config['num_tag_open'] 		= '<li>';
			$config['num_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
 			$config['prev_link'] 			= '<i class="fa fa-long-arrow-left"></i>Previous';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
 			$config['next_link'] 			= 'Next<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li> ' ;
 			
			##
  			$this->pagination->initialize($config);
 			$page 							= ($this->uri->segment($pagingUri)) ? $this->uri->segment($pagingUri) : 0;
 			$data["listData"] 				= $this->Buzzadmn_model->fetchUserStoryIdeaList($config["per_page"], $page, $user_id,$srchcondition,'1');
			$data["links"] 					= $this->pagination->create_links();
 		 ##-------------------------- Pagination Code ------------------------##
		  
        	$this->load->view('editorial/user_story_list', $data);
    }
	
	function approved_user_story() {
		$story_id = $this->input->post('StoryId');
  		echo $this->Buzzadmn_model->approved_user_story($story_id);	exit;	
     }
	 
	 function editUserStoryDetail() {
		//echo $this->uri->segment(4);
		$insertData = array();
		$data = array();
  		$story_id = $this->input->post('storyId');
 		if(!empty($this->input->post('hiddenval')) && !empty($story_id)){
			$story_idea 		= $this->input->post('pickDescEdit');
 			$clickedBtn	   		= $this->input->post('clickedBtn');
			$storyId	   		= $this->input->post('storyId');
			$login_type 		= $this->session->userdata('login_type');
			$data['story_idea'] = $story_idea;
			$user_id 		  = $this->session->userdata('admin_user_id');
 			//$data['status'] 	= $status;
			$data['storyId'] 	= $storyId;
			
			$insertData=array(
							"reporter_content"=>trim($story_idea),
							"story_id"=>$storyId,
							"reporter_id"=>$user_id,
							"created_on"=>date('Y-m-d H:i:s'),
							"created_by"=>$user_id,
							"status"=>$data['status']
			);
			
			//if($login_type=='input'){ 
			if(trim($clickedBtn)=='Save'){ //echo 'kam1';
				$insertData['is_input_edit']  = '1';
				$insertData['status'] 		= '0';
				$insertData['assigned'] 		= '2';
				//print_r($insertData);exit;	
			}
			else if(trim($clickedBtn)=='Submit'){ //echo 'kam2';
				$insertData['status'] 		= '1';
				$insertData['assigned'] 		= '2';
				//print_r($insertData);exit;	
			}
			echo $returnVal 	= $this->Buzzadmn_model->UpdateIdeaDetail($insertData);exit;
			//echo '***'.$this->db->last_query();exit;
			//}
			  
		}
		$data['resData'] 	= $this->Buzzadmn_model->fetchUserStoryetail($this->uri->segment(4));
		//print_r($data);exit;
		$data['storyIdea']  = $data['resData'];//$this->Buzzadmn_model->fetchStoryIdea($this->uri->segment(4));
		//echo '<pre>'; print_r($data);exit;
		$this->load->view('Editorial/edit_user_story_idea_details', $data);
    }
	
 	## ============================= For user story listing =========================================##
	
	
	function getAllReporters(){
 		$this->check_login_type('input');  
		$strory_id = $this->input->post('StoryId');
		if($strory_id!=''){		
		$getAllReportersWithStory=$this->Buzzadmn_model->getAllReportersWithStory($strory_id);
		$reportersList = $getAllReportersWithStory['reporters'];
		$msg =''; //echo '<pre>';	print_r($getAllReportersWithStory);exit;
		$msg .= '<div style="width:90%"><p>Story Idea: '.$getAllReportersWithStory['story_data']['title'].' &nbsp;('.$getAllReportersWithStory['story_data']['user_name'].'):</p>';
        $msg .= '<form name="assign_frm" id="assign_frm" method="post" action="'.base_url().'buzzadmn/editorial/assignIdea'.'">
					<div class="ace-scroll" style="overflow-y: scroll;height:250px;"><ul class="scroll-listing">';
		 $msg .= '<input type="hidden" name="hid_val" value="1"><input type="hidden" name="storyIdeaId" value="'.$getAllReportersWithStory['story_data']['id'].'">';
        foreach($reportersList as $key=>$val){
			$selected = '';
			if($val['user_id']==$getAllReportersWithStory['story_data']['created_by']){
				$selected = "selected";
			}
		 $msg .= '<li style="width:90%"><span>'.$val['user_name'].'</span>&nbsp;<input type="radio" '.$selected.' name="assignUser" value="'.$val['user_id'].'"></li>';
				 }
                 
        $msg .= '</ul></div>';
	   	$msg .=	'<input type="submit" name="assign" value="Assign">';
	   echo $msg .=	'</form></div>';exit;
		}
	}
	
	function editStoryDetail() {
		//echo $this->uri->segment(4);
		$insertData = array();
		$data = array();
  		$story_id = $this->input->post('storyId');
 		if(!empty($this->input->post('hiddenval')) && !empty($story_id)){
			$story_idea 		= $this->input->post('pickDescEdit');
 			$clickedBtn	   		= $this->input->post('clickedBtn');
			$storyId	   		= $this->input->post('storyId');
			$login_type 		= $this->session->userdata('login_type');
			$data['story_idea'] = $story_idea;
			$user_id 		  = $this->session->userdata('admin_user_id');
 			//$data['status'] 	= $status;
			$data['storyId'] 	= $storyId;
			
			$insertData=array(
							"reporter_content"=>trim($story_idea),
							"story_id"=>$storyId,
							"reporter_id"=>$user_id,
							"created_on"=>date('Y-m-d H:i:s'),
							"created_by"=>$user_id,
							"status"=>$data['status']
			);
			
 			if($login_type=='reporter'){// echo 'kam';exit;
				if($clickedBtn=='Save'){
					 
					$insertData['storyId'] 			= $storyId;
					$insertData['is_reporter_edit'] = 1;
					$insertData['status']			= 0;
					$buzzideaUpdate 				= $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
 				}
				else{
					$insertData['storyId'] 			= $storyId;
					$insertData['status']			= 1;
					$insertData['assigned']			= 3;
					$buzzideaUpdate 	= $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
 				}
				//echo $buzzideaUpdate 	= $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
				echo $returnVal 		= $this->Buzzadmn_model->UpdateIdeaDetail($insertData);
				//echo '***'.$this->db->last_query();exit;
			}
			if($login_type=='input'){ 
				if(trim($clickedBtn)=='Save'){ //echo 'kam1';
					$insertData['is_input_edit']  = '1';
					$insertData['status'] 		= '0';
					$insertData['assigned'] 		= '2';
					//print_r($insertData);exit;	
 				}
				else if(trim($clickedBtn)=='Submit'){ //echo 'kam2';
					$insertData['status'] 		= '1';
					$insertData['assigned'] 		= '2';
					//print_r($insertData);exit;	
				}
				echo $returnVal 	= $this->Buzzadmn_model->UpdateIdeaDetail($insertData);exit;
				//echo '***'.$this->db->last_query();exit;
			}
			  
		}
 			$data['resData'] 	= $this->Buzzadmn_model->fetchStoryetailIdea($this->uri->segment(4));
			//print_r($data);exit;
			$data['storyIdea']  = $this->Buzzadmn_model->fetchStoryIdea($this->uri->segment(4));
			//echo '<pre>'; print_r($data);exit;
          	$this->load->view('Editorial/edit_story_idea_details', $data);
    }
	
	function assignIdea(){
		$hid_val = $this->input->post('hid_val');
		$storyId = $this->input->post('storyIdeaId');
		$reporterId = $this->input->post('assignUser');
		$res 	= $this->Buzzadmn_model->update_assignIdea($storyId, $reporterId); 
		if($res){
			 $this->session->set_flashdata('success', 'Idea Assigned Successfully!');
			  redirect(base_url().'buzzadmn/Editorial/manage');
		}
		 
	}
	
	
 	## When idea Assiged To User then it calls
 	function listAssignedIdeas() {
			$pagingUri = 4;
 		 ##-------------------------- Pagination Code ------------------------##
			$user_id 				 		= $this->session->userdata('admin_user_id');
 			$srchcondition 					= '';
			if(!empty($this->input->post('srchDD'))){
				$srchcondition 		 		= json_encode($this->input->post());
			}
 			$status 			 	 		= 0;//echo '***'.$this->uri->segment(3);exit;
			## For Separating the Saved and assigned Ideas
		    $assigned 			 			= 2;
 			 
 			// print_r($this->input->post());//exit;
			$config = array();
			$config["base_url"] 			= base_url() . "buzzadmn/Editorial/listing/";
			$config["total_rows"] 			= $this->Buzzadmn_model->totalIdeaList($user_id,$srchcondition,$status,$assigned);
			$config["per_page"] 			= 5;
			$config["uri_segment"] 			= $pagingUri;			
			##
			
			$config['use_page_numbers'] 	= TRUE;
			$config['num_links'] 			= $config["total_rows"];
 			$config['full_tag_open'] 		= "<ul class='pagination'>";
			$config['full_tag_close']		= '</ul>';
			$config['num_tag_open'] 		= '<li>';
			$config['num_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
 			$config['prev_link'] 			= '<i class="fa fa-long-arrow-left"></i>Previous';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
 			$config['next_link'] 			= 'Next<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li> ' ;
 			##
  			$this->pagination->initialize($config);
 			$page 							= ($this->uri->segment($pagingUri)) ? $this->uri->segment($pagingUri) : 0;
 			$data["listData"] 				= $this->Buzzadmn_model->fetchStoryIdeaList($config["per_page"], $page, $user_id,$srchcondition,$status,$assigned);
			$data["links"] 					= $this->pagination->create_links();
 		 ##-------------------------- Pagination Code ------------------------##
		  
        	$this->load->view('Editorial/reporter_listing_assigned', $data);
    }
	
	
	##======================By Kamal ============================##
	
	 ##======================= Out Put Section start ================================##
	 function suboutput() {	//print_r($this->session->userdata());exit;
 		$this->check_login_type('outputsub'); 
			$pagingUri 						= 4;
 		 ##-------------------------- Pagination Code ------------------------##
			$user_id 						= $this->session->userdata('admin_user_id');
  			$srchcondition 					= '';
			if(!empty($this->input->post('srchDD'))){
				$srchcondition 				= json_encode($this->input->post());
			}
 			// print_r($this->input->post());//exit;
			$config = array();
			$config["base_url"] 			= base_url() . "buzzadmn/editorial/manage/";
			$config["total_rows"] 			= $this->Buzzadmn_model->totalIdeaList($user_id,$srchcondition,'1');
			$config["per_page"] 			= 5;
			$config["uri_segment"] 			= $pagingUri;			
			##
			
			$config['use_page_numbers'] 	= TRUE;
			$config['num_links'] 			= $config["total_rows"];
 			$config['full_tag_open'] 		= "<ul class='pagination'>";
			$config['full_tag_close']		= '</ul>';
			$config['num_tag_open'] 		= '<li>';
			$config['num_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
 			$config['prev_link'] 			= '<i class="fa fa-long-arrow-left"></i>Previous';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
 			$config['next_link'] 			= 'Next<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li> ' ;
 			
			##
  			$this->pagination->initialize($config);
 			$page 							= ($this->uri->segment($pagingUri)) ? $this->uri->segment($pagingUri) : 0;
 			$data["listData"] 				= $this->Buzzadmn_model->fetchStoryIdeaList($config["per_page"], $page, $user_id,$srchcondition,'1');
			
			//echo '******'.$this->db->last_query();exit;
			$data["links"] 					= $this->pagination->create_links();
 		 ##-------------------------- Pagination Code ------------------------##
		  
        	$this->load->view('Editorial/output_sub_list', $data);
    }
	
	
	function viewOPstoryDetail() {
		//echo $this->uri->segment(4);
  		$story_id = $this->input->post('storyId');
 		if(!empty($this->input->post('hiddenval')) && !empty($story_id)){ 
			$story_idea 		= $this->input->post('pickDescEdit');
 			$clickedBtn	   		= $this->input->post('clickedBtn');
			$storyId	   		= $this->input->post('storyId');
			$login_type 		= $this->session->userdata('login_type');
			$data['story_idea'] = $story_idea;
			$user_id 		  = $this->session->userdata('admin_user_id');
 			//$data['status'] 	= $status;
			$data['storyId'] 	= $storyId;
			
			$insertData=array(
							"reporter_content"=>trim($story_idea),
							"story_id"=>$storyId,
							"reporter_id"=>$user_id,
							"created_on"=>date('Y-m-d H:i:s'),
							"created_by"=>$user_id,
							"status"=>$data['status']
			);
			
 			 
			if($login_type=='outputsub'){
				if($clickedBtn=='Save'){
					$insertData['is_output_edit']  = 1;
 				}
				else{
					$insertData['status'] 		= 1;
					$insertData['assigned'] 		= 2;	
				}
				echo $returnVal 	= $this->Buzzadmn_model->UpdateIdeaDetail($insertData);exit;
			}
			  
		}
 			$data['resData'] 	= $this->Buzzadmn_model->fetchStoryetailIdea($this->uri->segment(4));
			//print_r($data);exit;
			$data['storyIdea']  = $this->Buzzadmn_model->fetchStoryIdea($this->uri->segment(4));
          	$this->load->view('Editorial/edit_story_idea_details', $data);
    }
	
	
	function editStoryDetail_op() {
 		$insertData 		= array();
		$mediaList 			= array();
  		$storyId 			= $this->uri->segment(4); 
		$data['resData'] 	= $this->Buzzadmn_model->fetchStoryetailIdea($storyId);
 		$data['storyIdea']  = $this->Buzzadmn_model->fetchStoryIdea_sub($storyId);
 		## Get ALl Story Media- like images videos, mp3 and pdf list and download them
 		$data['mediaList']			= $this->Buzzadmn_model->getstoryMedia($storyId);
		//echo '<pre>';print_r($mediaList);exit;
		## Get ALl Story Media- like images videos, mp3 and pdf list and download them
 		$this->load->view('Editorial/edit_story_op_details', $data);
    }
	 
 	 ##======================= Out Put Section start ================================##
	function download(){
		$id = trim($this->uri->segment(4));
		zipFilesAndDownload($id);exit;
	}
	
	 
	/*function download_single($filename = NULL) {
		//echo $this->uri->segment(4);exit;
		$this->load->helper('download');  
		//$fileName = "video_12_1500104173344.MP4";
		   if ($fileName){
			$file =  'uploads/temp/'.$fileName;
			// check file exists    
			if (file_exists ( $file )) {//echo 'kamalssssssssssss';exit;
			 // get file content
			 $data = file_get_contents ( $file );
			 //force download
			 force_download ( $fileName, $data );
			} else {
			 // Redirect to base url
			 redirect ( base_url () );
			}
		   }
		}*/
		
		function single_file_dwld2($file){
		 	ob_clean();
			 
			 // "bill"
			//echo $this->uri->segment(4);exit;
			 $file = $this->uri->segment(4);//$_GET['filename'];
			$download_path = 'uploads/temp/'.$file;
			
			$path_info = pathinfo($file_to_download);
			$mimetype = 'file';
			if($path_info['extension']=='mp4'){
				$mimetype = 'mp4';
			}
			
			$file_to_download = $download_path; // file to be downloaded
			header("Expires: 0");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache"); 
			header("Pragma: no-cache");  header("Content-type: application/$mimetype");
			header('Content-length: '.filesize($file_to_download));
			header('Content-disposition: attachment; filename='.basename($file_to_download));
			readfile($file_to_download);
			exit;
		}
		
		
		function single_file_dwld($file){ 
		$file = trim($file);
 			$filename = 'uploads/temp/'.trim($this->uri->segment(4)); 
			ob_clean();
			$ctype="application/[extension]";
			// required for IE, otherwise Content-disposition is ignored
			if(ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off');
			
			header("Pragma: public"); // required
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); // required for certain browsers
			header("Content-Type: $ctype");
 			// change, added quotes to allow spaces in filenames
 			header("Content-Disposition: attachment; filename=".basename(trim($filename))."" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($filename));
			readfile("$filename");
			exit();
		}
		
		function buzz_story_listing() {
 		//checklogin();
 		$this->check_login_type('input'); 
			$pagingUri 						= 4;
 		 ##-------------------------- Pagination Code ------------------------##
			$user_id 						= $this->session->userdata('admin_user_id');
  			$srchcondition 					= '';
			if(!empty($this->input->post('srchDD'))){
				$srchcondition 				= json_encode($this->input->post());
			}
 			// print_r($this->input->post());//exit;
			$config = array();
			$config["base_url"] 			= base_url() . "buzzadmn/editorial/buzz_story_listing/";
			$config["total_rows"] 			= $this->Buzzadmn_model->buzz_totalIdeaList($user_id,$srchcondition,'1');
			$config["per_page"] 			= 5;
			$config["uri_segment"] 			= $pagingUri;			
			##
			
			$config['use_page_numbers'] 	= TRUE;
			$config['num_links'] 			= $config["total_rows"];
 			$config['full_tag_open'] 		= "<ul class='pagination'>";
			$config['full_tag_close']		= '</ul>';
			$config['num_tag_open'] 		= '<li>';
			$config['num_tag_close'] 		= '</li>';
			$config['cur_tag_open'] 		= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 		= '</a></li>';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
			$config['first_tag_open'] 		= '<li>';
			$config['first_tag_close'] 		= '</li>';
			$config['last_tag_open'] 		= '<li>';
			$config['last_tag_close'] 		= '</li>';
 			$config['prev_link'] 			= '<i class="fa fa-long-arrow-left"></i>Previous';
			$config['prev_tag_open'] 		= '<li>';
			$config['prev_tag_close'] 		= '</li>';
 			$config['next_link'] 			= 'Next<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] 		= '<li>';
			$config['next_tag_close'] 		= '</li> ' ;
 			
			##
  			$this->pagination->initialize($config);
 			$page 							= ($this->uri->segment($pagingUri)) ? $this->uri->segment($pagingUri) : 0;
 			$data["listData"] 				= $this->Buzzadmn_model->fetchBuzzStoryIdeaList($config["per_page"], $page, $user_id,$srchcondition,'1');
			$data["links"] 					= $this->pagination->create_links();
 		 ##-------------------------- Pagination Code ------------------------##
		  
        	$this->load->view('Editorial/user_story_list', $data);
    }

    // Approve Buzz Story
    function approve_buzz_story() {
		$story_id = $this->input->post('story_id');
		$user_id = $this->session->userdata('admin_user_id');
		if( !empty($story_id) && !empty($user_id) ) {
			if($this->Buzzadmn_model->approveBuzzStory( $story_id, $user_id ) == true ) {
				$this->session->set_flashdata('success', 'Buzz story has been approved Successfully!');
				echo '1';
				exit;
			}
		}
	}

    // Reject Buzz Story
    function reject_buzz_story() {
		$story_id = $this->input->post('story_id');
		$user_id = $this->session->userdata('admin_user_id');
		if( !empty($story_id) && !empty($user_id) ) {
			if($this->Buzzadmn_model->rejectBuzzStory( $story_id, $user_id ) == true ) {
				$this->session->set_flashdata('success', 'Buzz story has been rejected!');
				echo '2';
				exit;
			}
		}
	}

	// Edit Buzz Story by Editor
	function editBuzzStoryDetail() {
		//echo "story";exit;
		//echo $this->uri->segment(4);
		$insertData = array();
		$data = array();
  		$story_id = $this->input->post('storyId');
 		if(!empty($this->input->post('hiddenval')) && !empty($story_id)){
			$story_idea 		= $this->input->post('pickDescEdit');
 			$clickedBtn	   		= $this->input->post('clickedBtn');
			$storyId	   		= $this->input->post('storyId');
			$login_type 		= $this->session->userdata('login_type');
			$data['story_idea'] = $story_idea;
			$user_id 		  = $this->session->userdata('admin_user_id');
 			//$data['status'] 	= $status;
			$data['storyId'] 	= $storyId;
			
			$insertData=array(
							"reporter_content"=>trim($story_idea),
							"story_id"=>$storyId,
							"reporter_id"=>$user_id,
							"created_on"=>date('Y-m-d H:i:s'),
							"created_by"=>$user_id,
							"status"=>$data['status']
			);
			
 			if($login_type=='reporter'){// echo 'kam';exit;
				if($clickedBtn=='Save'){
					 
					$insertData['storyId'] 			= $storyId;
					$insertData['is_reporter_edit'] = 1;
					$insertData['status']			= 0;
					$buzzideaUpdate 				= $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
 				}
				else{
					$insertData['storyId'] 			= $storyId;
					$insertData['status']			= 1;
					$insertData['assigned']			= 3;
					$buzzideaUpdate 	= $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
 				}
				//echo $buzzideaUpdate 	= $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
				echo $returnVal 		= $this->Buzzadmn_model->UpdateIdeaDetail($insertData);
				//echo '***'.$this->db->last_query();exit;
			}
			if($login_type=='input'){ 
				if(trim($clickedBtn)=='Save'){ //echo 'kam1';
					$insertData['is_input_edit']  	= '1';
					$insertData['status'] 			= '0';
					$insertData['assigned'] 		= '2';
					//print_r($insertData);exit;	
 				}
				else if(trim($clickedBtn)=='Submit'){ //echo 'kam2';
					$insertData['status'] 		= '1';
					$insertData['assigned'] 	= '2';
					//print_r($insertData);exit;	
				}
				echo $returnVal 	= $this->Buzzadmn_model->UpdateIdeaDetail($insertData);exit;
				//echo '***'.$this->db->last_query();exit;
			}
 		}
 			$data['resData'] 	= $this->Buzzadmn_model->fetchStoryetailIdea($this->uri->segment(4));
			//print_r($data);exit;
			$data['storyIdea']  = $this->Buzzadmn_model->fetchStoryIdea($this->uri->segment(4));
			//echo '<pre>'; print_r($data);exit;
          	$this->load->view('Editorial/edit_buzz_story_idea_details', $data);
    }
	
	function view_idea_listing(){
		//checklogin();
		//$this->check_login_type('reporter'); 
		$login_type 					= $this->session->userdata('login_type');
		$user_id 						= $this->session->userdata('admin_user_id');
		$srchcondition 					= '';
		if(!empty($this->input->post('srchDD'))){
			$srchcondition 				= json_encode($this->input->post());
		}
		$data["listData"] 				= $this->Buzzadmn_model->fetch_notification_list($user_id,$srchcondition,'1');
		//echo '***'.$this->db->last_query();exit;
		//echo '<pre>';print_r($data["listData"] 	);exit;
		$tpl = "reporter_listing_assigned";
		if($login_type=='input'){
			$tpl = "editorial_list";
		}
		 
		
		$this->load->view('Editorial/'.$tpl, $data);
 	}

 
}  