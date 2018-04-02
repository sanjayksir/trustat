<?php
class Backend_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

 	##======================By Kamal ============================##
 	function saveStoryIdea($data){
 		$user_id = $this->session->userdata('admin_user_id');
   		$storyId = $data['storyId'];
 		$user_name = $this->session->userdata('user_name');
   		$insertData=array(
 				"title"=>$data['story_idea'],
 				"eta"=>$data['eta'],
 				"created_on"=>date('Y-m-d H:i:s'),
 				"created_by"=>$user_id,
 				"user_name"=>$user_name,
 				"status"=>$data['status'],
 				"assigned "=>$data['status']## I have given same value to asiige as if status ==0 thenasign must be zero  and if status ==1 then assign must be 1
  			);
 
 			if($storyId!=''){
  				$updatedData=array(
 				"title"=>$data['story_idea'],
 				"eta"=>$data['eta'],
 				"updated_on"=>date('Y-m-d H:i:s'),
 				"updated_by"=>$user_id,
 				"user_name"=>$user_name,
 				"status"=>$data['status'],
 				"assigned "=>$data['status']
  			);

				$whereData = array('id'=>$storyId);

				$this->db->set($updatedData);

				$this->db->where($whereData);

				if($this->db->update('buzz_idea')){

					//echo $this->db->last_query();exit;

					return $data['status'];

				} 

			}else{

				if($this->db->insert("buzz_idea", $insertData)){

					return $data['status'];

				}

			}

			return '2'; 

	}

	

 	function fetchStoryIdea($spidey_id){

		$this->db->select('*');

		$this->db->from('buzz_idea');

		$this->db->where(array('status'=>0, 'id'=>$spidey_id));

 		$query = $this->db->get();//echo '**'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			//

			$res = $query->result_array();

 		}

		return $res;

	}

	

	function fetchStoryIdea_sub($spidey_id){

		$this->db->select('*');

		$this->db->from('buzz_idea');

		$this->db->where(array('id'=>$spidey_id));

 		$query = $this->db->get();//echo '**'.$this->db->last_query();exit;

		if ($query->num_rows() > 0) {

			//

			$res = $query->result_array();

 		}

		return $res;

	}

	

	function fetchStoryetailIdea($spidey_id){

		$res = array();

		$login_type 	= $this->session->userdata('login_type');

		if($login_type 	== 'reporter'){

			$status = 0;

		}else{

 			$status = 1;

		}

		$this->db->select('bizz_detail_master.*');

		$this->db->from('bizz_detail_master');

		$this->db->join('buzz_idea', 'bizz_detail_master.story_id= buzz_idea.id');

		$this->db->where(array('buzz_idea.id'=>$spidey_id, 'bizz_detail_master.status'=>'1', 'buzz_idea.status'=>$status));

		$query2 = $this->db->get(); // echo '**'.$this->db->last_query();exit;

		 

		$query2->num_rows(); //

		if ($query2->num_rows() > 0) { 

 			$res = $query2->result_array();

			//print_r($res);

 		}

		return $res;

	}

	

	

	## User Based

	function fetchUserStoryetail($spidey_id){

		$res = array();

		$login_type 	= $this->session->userdata('login_type');

		if($login_type 	== 'reporter'){

			$status = 0;

		}else{

 			$status = 1;

		}

		$this->db->select('*');

		$this->db->from('buzz_people_story');

 		$this->db->where(array('status'=>2, 'editor_action'=>'1'));

		$query2 = $this->db->get(); // echo '**'.$this->db->last_query();exit;

		 

		$query2->num_rows(); //

		if ($query2->num_rows() > 0) { 

 			$res = $query2->result_array();

			//print_r($res);

 		}

		return $res;

	}

	

	

	

	function deleteStoryIdea($spidey_id,$user_id){

		$res=false;

		$updatedData=array("is_delete "=>1);

		$whereData = array('id'=>$spidey_id, 'created_by'=>$user_id);

		$this->db->set($updatedData);

		$this->db->where($whereData);

		if($this->db->update('buzz_idea')){

			//echo $this->db->last_query();exit;

			$res=true;			

		} return $res;

 	}

	

	function deleteUserStoryIdea($story_id){

         return $this->db->where('id', $story_id)->update('buzz_people_story', array('editor_action' => 2));//  echo '**'.$this->db->last_query();exit;

  	}

	

	function totalIdeaList($user_id,$srchcondition='',$status='',$assigned=''){

	 //echo '***'.$this->uri->segment(3);exit;

		if(!empty($srchcondition)){

			$srchData = json_decode($srchcondition);

			$whereCondition = $this->searchIdea($srchcondition);

		}

		//echo '***'.$this->uri->segment(3);exit; 

		## For Reporter Listing

		if($this->uri->segment(3)=='listing'){

			$whereData = array('status'=>0,'assigned'=>0,'is_delete'=>0,'created_by'=>$user_id);

		} else if($this->uri->segment(3)=='listAssignedIdeas'){

			$whereData = array('status'=>0,'assigned'=>2, 'is_delete'=>0,'created_by'=>$user_id);

 		}

		## For Reporter Listing

		

 		## For Editorial  Listing

		elseif($this->uri->segment(3)=='manage'){

			$whereData = array('status'=>1,'is_delete'=>0,'buzz_story_id'=>0);

 			$this->db->where_in('assigned', array(1,3));

		} ## For Editorial Listing

		

		 ## For outputsub Listing 

		elseif($this->uri->segment(3)=='suboutput'){

			$whereData = array('status'=>1,'is_delete'=>0);

 			$this->db->where_in('assigned', array(3));

		}  

		 ## For outputsub Listing

		//print_r($whereData);exit;

		$this->db->select('count(1) as cnt');

		$this->db->from('buzz_idea');

		$this->db->where($whereData);

 		$query = $this->db->get();  // echo '---sql='.$this->db->last_query();exit;

		$total_rows = 0;

		$total_rows = $query->num_rows() ;

		$result = $query->result_array(); 

		$res = $result[0]['cnt'];

 		 return $res;

 	}

	

	function fetchStoryIdeaList($limit,$start, $user_id,$srchcondition='',$status,$assigned){

		if(!empty($srchcondition)){

			$srchData = json_decode($srchcondition);

			$whereCondition = $this->searchIdea($srchcondition);

		}

		## For Reporter Listing

		if($this->uri->segment(3)=='listing'){

			$whereData = array('status'=>0,'assigned'=>0,'is_delete'=>0,'created_by'=>$user_id);

		} else if($this->uri->segment(3)=='listAssignedIdeas'){

			$whereData = array('status'=>0,'assigned'=>2, 'is_delete'=>0,'created_by'=>$user_id);

 		}

		## For Reporter Listing

 		## For Editorial  Listing

		elseif($this->uri->segment(3)=='manage'){

			$whereData = array('status'=>1,'is_delete'=>0,'buzz_story_id'=>0);

 			$this->db->where_in('assigned', array(1,3));

		}  

		 ## For Editorial Listing

		 ## For outputsub Listing 

		elseif($this->uri->segment(3)=='suboutput'){

			$whereData = array('status'=>1,'is_delete'=>0);

 			$this->db->where_in('assigned', array(2));

		}  

		 ## For outputsub Listing

		

		

		if($start>1){

			$start = ($start-1)*$limit;

		}

		$this->db->select('*');

		$this->db->from('buzz_idea');

		$this->db->where($whereData);

		$this->db->order_by('created_on','DESC');

 		$this->db->limit($limit, $start);

		

 		$query = $this->db->get();

		// echo $this->db->last_query();exit;

		if ($query->num_rows() > 0) {

		  	

			$res = $query->result_array();

 		}

		return $res;

	}

	

	

	##================================= User based story listing in editorial section	 ==================================##

	function fetchUserStoryIdeaList($limit,$start, $user_id,$srchcondition='',$status,$assigned){

 		if($start>1){

			$start = ($start-1)*$limit;

		}

 

		$whereData = array('status'=>2, 'editor_action'=>0);

		$this->db->select('*');

		$this->db->from('buzz_people_story');

		$this->db->where($whereData);

		$this->db->order_by('created_on','DESC');

 		$this->db->limit($limit, $start);

		

 		$query = $this->db->get();

		// echo $this->db->last_query();exit;



		if ($query->num_rows() > 0) {

		  	

			$res = $query->result_array();

 		}

		return $res;

	}

	

	function user_story_totalIdea_list($user_id,$srchcondition='',$status='',$assigned=''){

		$whereData = array('status'=>2, 'editor_action'=>0);

 		$this->db->select('count(1) as cnt');

		$this->db->from('buzz_people_story');

		$this->db->where($whereData);

 		$query = $this->db->get();  // echo '---sql='.$this->db->last_query();exit;

		$total_rows = 0;

		$total_rows = $query->num_rows() ;

		$result = $query->result_array(); 

		$res = $result[0]['cnt'];

 		 return $res;

 	}

	

	##================================= User based story listing in editorial section	 ==================================##

	## User wise

	function fetchStoryIdeaList_user($limit,$start, $user_id,$srchcondition='',$status,$assigned){

		if(!empty($srchcondition)){

			$srchData = json_decode($srchcondition);

			$whereCondition = $this->searchIdea($srchcondition);

		}

		if(!empty($status)){

			$status = 1;

		}else{

			$status =0;

		}

		if($start>1){

			$start = ($start-1)*$limit;

		}

		$this->db->select('*');

		$this->db->from('buzz_idea');

		$this->db->where(array('status'=>$status, 'created_by'=>$user_id));

 		$this->db->limit($limit, $start);

 		$query = $this->db->get();

		//echo '**'.$this->db->last_query();exit;



		if ($query->num_rows() > 0) {

		  	

			$res = $query->result_array();

 		}

		return $res;

	}

	function totalIdeaList_user($user_id,$srchcondition='',$status){

		if(!empty($srchcondition)){

			$srchData = json_decode($srchcondition);

			$whereCondition = $this->searchIdea($srchcondition);

		}

		if(!empty($status)){

			$status = 1;

		}else{

			$status =0;

		}

		$this->db->select('count(1) as cnt');

		$this->db->from('buzz_idea');

		$this->db->where(array('status'=>$status, 'created_by'=>$user_id));

 		$query = $this->db->get();  //echo '---sql='.$this->db->last_query();exit;

		$total_rows = 0;

		$total_rows = $query->num_rows() ;

		$result = $query->result_array(); 

		$res = $result[0]['cnt'];

 		return $res;

 	}

 	

	function searchIdea($srchData){

		$srchData = json_decode($srchData,true);

		if(count($srchData)>0){

			if($srchData['srchDD']==2){

  			return $whereCondition = $this->db->where('cast(created_on as date)  BETWEEN "'. date('Y-m-d', strtotime($srchData['fromdate'])). '" and "'. date('Y-m-d', strtotime($srchData['todate'])).'"'); 

			}else if($srchData['srchDD']==1){				

			 $whereCondition = '(title LIKE "'.$srchData['search'].'%" or user_name LIKE "%'.$srchData['search'].'%")';

       		 return $this->db->where($whereCondition);

 			}

		}

 	}

	

	function show_notifications_story(){

		$this->db->select('id, title, user_name');

		$this->db->from('buzz_idea');

		$this->db->where(array('notification_view'=>0,'status'=>'1'));

		$this->db->limit(1);

 		$query = $this->db->get();  //echo '---sql='.$this->db->last_query();exit;

		$total_rows = 0;

		$total_rows = $query->num_rows() ;

		$result = $query->result_array(); 

		$res = $result[0];

 		return $res;

	}

	

 	function update_notification_story($storyId){

 		$updatedData = array('notification_view'=>'1');

		$whereData = array('id'=>$storyId);

		$this->db->set($updatedData);

		$this->db->where($whereData);

		if($this->db->update('buzz_idea')){

			//echo $this->db->last_query();exit;

			return '1';

		}return '0';

 	}

	

	## ADD STORY DETAILS  Chnage the tables status field also for idea and detail table

	function saveIdeaDetail($data){//echo '<pre>';print_r($data);exit;

		$user_id = $this->session->userdata('admin_user_id');

  		$storyId = $data['storyId'];

		$user_name = $this->session->userdata('user_name');//echo '*222**'.$data['status'];

  		$insertData=array(

				"reporter_content"=>trim($data['pickDesc']),

				"story_id"=>$storyId,

				"reporter_id"=>$user_id,

				"created_on"=>date('Y-m-d H:i:s'),

				"created_by"=>$user_id,

				//"user_name"=>$user_name,

				"status"=>$data['status']

 			);

			

		$checkStoryUpdate = $this->chcekExistsDetail($storyId);

 		if($checkStoryUpdate!=0){

 				$updatedData=array(

 				"reporter_content"=>trim($data['pickDesc']),

				"reporter_id"=>$user_id,

				"updated_on"=>date('Y-m-d H:i s'),

				"updated_by"=>$user_id,

				//"user_name"=>$user_name,

				"status"=>$data['status']

 			);

 				//print_r($updatedData);exit;

			$whereData = array('story_id'=>$storyId);

				$this->db->set($updatedData);

				$this->db->where($whereData);

				if($this->db->update('bizz_detail_master')){ //echo $this->db->last_query();exit;

				 

					##

					$this->insertMedia($data);	

 					$this->update_story_idea_edit_status($data['status'],$storyId);

 					##

					//echo $this->db->last_query();exit;

					return '1';

				} 

			}else{

				$submit_action = $this->input->post('submit_action'); 

				$this->insertMedia($data); //echo $this->db->last_query();exit;

				if($submit_action==1){

					$this->db->insert("bizz_detail_master", $insertData);

					$this->update_story_idea_edit_status($data['status'],$storyId);

				}

  				

  				return '0';

			}

 		//echo '***'.$data['status'];exit;

		//echo $this->db->last_query();exit;	

		return '2'; 

	}

	

 	##For Reporter Edit change and save

	function update_story_idea_edit_status($status='',$storyId){

		if($status==0){

 				$updatedData=array(

					"status"=>0,

					"is_reporter_edit"=>1

 				);

 		}else{

				$updatedData=array(

					"assigned"=>1,

					"status"=>1

  				);

		}

		$whereData = array('id'=>$storyId);

		$this->db->set($updatedData);

		$this->db->where($whereData);

		$this->db->update('buzz_idea');	

		return '1';

	}

	

	function UpdateIdeaDetail($data){   // echo '<pre>kqamal===';print_r($data);exit;

		$user_id 		  = $this->session->userdata('admin_user_id');

  		$storyId 		  = $data['story_id'];

		$user_name 		  = $this->session->userdata('user_name');

 		$checkStoryUpdate = $this->chcekExistsDetail($storyId);

		$insertData		  = array();

		$insertData=array(

							"story_id"=>$storyId,

							"reporter_id"=>$user_id,

							"created_on"=>date('Y-m-d H:i:s'),

							"created_by"=>$user_id,

							"status"=>$data['status']);

		$updatedData=array(

 			"reporter_id"=>$user_id,

			"updated_on"=>date('Y-m-d H:i s'),

			"updated_by"=>$user_id,

			"status"=>$data['status'],

			

		);

		

		$login_type 	= $this->session->userdata('login_type');

		if($login_type 	== 'reporter'){

			$content	= "reporter_content";

			$dataContent = "reporter_content";

		}

		if($login_type 	== 'input'){

			$content = "editorial_content";

			$dataContent = "reporter_content";

		}

		//$insertData[$content]=trim($data[$dataContent]);

 		$updatedData[$content]=trim($data[$dataContent]);

		 	 

 		if($checkStoryUpdate!='0'){

			$whereData = array('story_id'=>$storyId);

			$this->db->set($updatedData);

			$this->db->where($whereData);

				if($this->db->update('bizz_detail_master')){

					 // echo $this->db->last_query();exit;

					 $whereData = array('id'=>$storyId);

					 

					 $updt = array("assigned"=>$data['assigned'],"status"=>$data['status']);

					 $this->db->set($updt);

					 $this->db->where($whereData);

					 $this->db->update('buzz_idea');

					return '1';

				} 

		}else{

			if($this->db->insert("bizz_detail_master", $insertData)){

				$this->insertMedia($data); //echo $this->db->last_query();exit;				

				return '0';

			}

		}

		return '2'; 

	}

	

	function UpdateBuzzIdea($data){

		$user_id 		  = $this->session->userdata('admin_user_id');

		$user_name 		  = $this->session->userdata('user_name');

  		$storyId 		  = $data['storyId'];		

		$status 		  = $data['status'];

		$is_reporter_edit = $data['is_reporter_edit'] ;

		$assigned		  = $data['assigned'] ;

		$updatedData 	  = array();

 		//echo '<pre>';print_r($data);exit;

		 

		$updatedData['status']=$status;

		 

		if(!empty($is_reporter_edit)){

			$updatedData['is_reporter_edit']=$is_reporter_edit;

 		}

		if(!empty($assigned)){

			$updatedData['assigned']=$assigned;

 		}

		$updatedData['updated_on']=date('Y-m-d H:i s');

		$updatedData['updated_by']=$user_id;

		 

 		$whereData = array('id'=>$storyId);

		//$this->db->set($updatedData);

		$this->db->where($whereData);

		if($this->db->update('buzz_idea',$updatedData)){

			//echo $this->db->last_query();exit;

 			return '1';

		} 

 			return '2'; 

	}

	

	function insertMedia($data){

			//echo '**<pre>'.print_r($data);exit;

			$checkStoryUpdate = $this->chcekExistsMedia($data['storyId']);

			

			$insertData=array(

				"story_id"=>$data['storyId'],

				"images"=>trim($data['images']),

				"videos"=>trim($data['videos']),

				"audios"=>trim($data['audios']),

				"attachments"=>trim($data['attachments']),

				"status"=>'1' 

 			);

 			if($checkStoryUpdate=='1'){

				$update_array = array();

				$arr = array();

				$checker=0;//echo '***'.$data['images'];

				if($data['images']!=''){

					$checker=1;

					$arr = array("images"=>trim($data['images']));

					$update_array = array_merge($update_array, $arr);

					

				}

				if($data['videos']!=''){

					$checker=1;

					$arr = array("videos"=>trim($data['videos']));

					$update_array = array_merge($update_array, $arr);

				}

				if($data['audios']!=''){

					$checker=1;

					$arr = array("audios"=>trim($data['audios']));

					$update_array = array_merge($update_array, $arr);

				}

				if($data['attachments']!=''){

					$checker=1;

					$arr = array("attachments"=>trim($data['attachments']));

					$update_array = array_merge($update_array, $arr);

				}

				

				//echo '<pre>';print_r($update_array);exit;

				if($checker==1){

					$whereData = array('story_id'=>$data['storyId']);

					$this->db->set($update_array);

					$this->db->where($whereData);

					if($this->db->update('buzz_media_master')){

					 // echo $this->db->last_query();exit;

						return '1';

					} 

					return '2';

				}

			}else{

				if($this->db->insert("buzz_media_master", $insertData)){					

						return '0';

				}

			}

			return '3';

	}

	

	function chcekExistsDetail($storyId){

		$result = array();



 		if(!empty($storyId)){ 

			$this->db->select('detail_id');

			$this->db->from('bizz_detail_master');

			$this->db->where(array('story_id'=>$storyId));

			$query = $this->db->get();  //echo '---sql='.$this->db->last_query();exit;

			$total_rows = 0;

			$total_rows = $query->num_rows() ;

			$result = $query->result_array();

			//$res = $result[0]['detail_id'];

			if( ! empty($result) ){

				return '1';

			}else{

				return '0';

			}

 		}

 		return '2';		 

	}

	

	

	function chcekExistsMedia($storyId){

 		if(!empty($storyId)){ 

			$this->db->select('media_id');

			$this->db->from('buzz_media_master');

			$this->db->where(array('story_id'=>$storyId));

			$query = $this->db->get();  //echo '---sql='.$this->db->last_query();exit;

			$total_rows = 0;

			$total_rows = $query->num_rows() ;

			$result = $query->result_array(); 

			$res = $result[0]['media_id'];

			if($res!=''){

				return '1';

			}else{

				return '0';

			}

 		}return '2';		 

	}

	

	function getAllReportersWithStory($storyId){ 

		$this->db->select('id, title, created_by, user_name');

		$this->db->from('buzz_idea');

		$this->db->where(array('id'=>$storyId,'status'=>'1'));

		$query = $this->db->get();  //echo '---sql='.$this->db->last_query();exit;

		 $total_rows = 0;

		$total_rows = $query->num_rows() ;

		if($total_rows>0){

			$result = $query->result_array(); 

			$res['story_data'] = $result[0];

		} 

		

		$this->db->select('user_id, user_name');

		$this->db->from('backend_user');

		$this->db->where(array('status'=>'1'));

		$query = $this->db->get();  //echo '---sql='.$this->db->last_query();exit;

		$total_rows = 0;

		$total_rows = $query->num_rows() ;

		if($total_rows>0){

			$result = $query->result_array(); 

		}

		$res['reporters']=$result;

  		if($res!=''){

			return $res;

		}else{

			return '0';

		}	 

	}

	

	

	function update_assignIdea($story_id, $reporterId){

		$whereData 		= array('id'=>$story_id);

		$update_array 	= array("created_by"=>$reporterId,"status"=>'0', "assigned"=>'2');

		$this->db->set($update_array);

		$this->db->where($whereData);

		if($this->db->update('buzz_idea')){

		 // echo $this->db->last_query();exit;

			return '1';

		}else{

			return '0';

 		}

	}

	

	

	function update_sub_op_data($story_id){

		$whereData 		= array('id'=>$story_id);

		$user_id = $this->session->userdata('admin_user_id');

		$update_array 	= array("updated_by"=>$user_id,"status"=>'2', "assigned"=>'3');

		$this->db->set($update_array);

		$this->db->where($whereData);

		if($this->db->update('buzz_idea')){

		// echo $this->db->last_query();exit;

			return '1';

		}else{

			return '0';

 		}

	}

 	 

	 

	 

	 

	 

   	##======================By Kamal ============================##

	

	##===================== By Rocky==============================##

	 function getSpideyPickList($search_keyword, $limit, $offset) {

        $this->db->select("*");

        $this->db->from("spidypick");

        if ($search_keyword && $search_keyword != '') {

            $this->db->like('spidypickId', $search_keyword);

            $this->db->or_like('spidyName', $search_keyword);

            $this->db->or_like('headline', $search_keyword);

            $this->db->or_like('subHeadLine', $search_keyword);

        }

		$this->db->where('category_id !=','');

        $this->db->limit($limit, $offset);

        $this->db->order_by("spidypickId", " desc");

        return $this->db->get()->result_array();

    }



    public function SpideyPickNumRows($search_keyword) {

        $this->db->select("spidypickId");

        $this->db->from("spidypick");

        if ($search_keyword && $search_keyword != '') {

            $this->db->like('spidypickId', $search_keyword);

            $this->db->or_like('spidyName', $search_keyword);

            $this->db->or_like('headline', $search_keyword);

            $this->db->or_like('subHeadLine', $search_keyword);

        }

        return $this->db->get()->num_rows();



        /* $q = $this->db

          ->select('spidypickId')

          ->from('spidypick')

          ->get();

          return $q->num_rows(); */

    }



    public function storeSpideyBuzz($array) {  // echo '<pre>kam==';print_r($array);exit;	

        $buzz_data = array(

            'spidyName' 			=> stripslashes(addslashes($array['title'])),

            'headline' 				=> stripslashes(addslashes($array['headline'])),

            'subHeadLine' 			=> stripslashes(addslashes($array['subHeadLine'])),

            'pickDesc' 				=> $array['pickDesc'],

            'tags' 					=> $array['videoLink'],

            'category_id' 			=> $array['category_id'],

			'sub_category_id' 		=> $array['sub_category_id'],

            'status' 				=> $array['status'],

			'area_id'				=> implode(',', $array['area']),

            'if_notified' 			=> ($array['status']) ? 1 : 0,

			'photocaption' 			=> $array['photocaption'],

            'photocredit' 			=> $array['photocredit'],

            'is_breaking_news' 		=>  ($array['is_breaking']) ? 1 : 0,

			'breaking_news_title'	=> $array['breakingFld'],

			'is_tricky_title' 		=> ($array['is_tricky']) ? 1 : 0,

			'tricky_title_name' 	=> $array['trickyFld'],

            'related_storyId'		=> implode(',', $array['related_storyId']),

            'related_storyTxt' 		=> $array['related_storyTxt'],

			'story_url' 			=> trim($array['url']),

			'story_for' 			=> trim($array['story_for']),

			'videos' 				=> trim($array['video_media'])

			

            //'commentbox' => $array['commentbox'],

			            //'spideyImage' => $array['spideyImage'],

            //'spideyImageSmall' => $array['spideyImageSmall'],

            //'releaseDate' => ($array['status']) ? date('Y-m-d H:i:s') : '',

        );

		##-------------------- Image Fields----------------------##

		if (count($array['area'])>0){

			$buzz_data['area_id'] = implode(',',$array['area']);

		}

		if ($array['Imgs']['spideyImage']!= ''){

			$buzz_data['spideyImage'] = $array['Imgs']['spideyImage'];

		}

		if ($array['Imgs']['spideyImage1'] != ''){

			$buzz_data['banner_image1'] = $array['Imgs']['spideyImage1'];

		}

		if ($array['Imgs']['spideyImageSmall1']!= ''){

			$buzz_data['banner_image2'] = $array['Imgs']['spideyImageSmall1'];

		}

		if ($array['Imgs']['spideyImage2']!= ''){

			$buzz_data['banner_image3'] = $array['Imgs']['spideyImage2'];

		}

		if ($array['Imgs']['spideyImageSmall2']!= ''){

			$buzz_data['banner_image4'] = $array['Imgs']['spideyImageSmall2'];

		}

		if ($array['Imgs']['spideyImage']!= ''){

			$buzz_data['spideyImage'] = $array['Imgs']['spideyImage'];

		}

		##-------------------- Image Fields----------------------##



        if ($array['spidypickId'] && $array['spidypickId'] != '' && $array['spidypickId'] > 0) {###---------- EDIT Story CODE

            if ($array['spideyImage'] != '')

                $buzz_data['spideyImage'] = $array['spideyImage'];

            if ($array['spideyImageSmall'] != '')

                $buzz_data['spideyImageSmall'] = $array['spideyImageSmall'];

				$buzz_data['updatedby'] = $this->session->user_id;

				$buzz_data['updatedOn'] = date('Y-m-d H:i:s'); //echo $this->db->last_query();exit;

				return $this->db->where('spidypickId', $array['spidypickId'])->update('spidypick', $buzz_data);

        } else {																									               ###------------------ ADD Story DETAIL

   				$buzz_data['createdby'] = $this->session->user_id;

				$buzz_data['createdDate'] = date('Y-m-d H:i:s');

				$buzz_data['releaseDate'] = ($array['status']) ? date('Y-m-d H:i:s') : NULL;

 				$this->db->insert('spidypick', $buzz_data);

				

				return $this->db->insert_id();

        }

    }



    public function updateIfNotified($s_id) {

        return $this->db->where('spidypickId', $s_id)->update('spidypick', array('if_notified' => '1'));

    }



    public function getSpideyTitle($spidey_pic_id) {

        return $this->db->select('spidyName,headline')->from('spidypick')->get()->result_array();

    }



    public function getState() {

        return $this->db->select('*')->from('tbl_state')->get()->result_array();

    }



    public function getCategoryList() {

        $this->db->select("category_Id,categoryName,parent");

        $this->db->from("categories");

        $this->db->where(array("status"=>'1', 'parent'=>0));

 		$this->db->order_by("categoryName", " asc");

        return $this->db->get()->result_array();

    }

	

	public function getSubCategoryList($id) {

        $this->db->select("category_Id,categoryName,parent");

        $this->db->from("categories");

        $this->db->where(array("status"=>1, 'parent='=>$id));

 		$this->db->order_by("categoryName", " asc");

       $res = $this->db->get()->result_array(); //echo $this->db->last_query();exit;

	   $con = '';

	  // echo '<pre>';print_r($res);

	   foreach($res as $val){

		  $con  .= ' <option value="'. $val['category_Id'].'">'. $val['categoryName'].'</option>';

		   

	   }

	   return $con;

    }



    public function find_spidey_buzz($spidey_id) {

        return $this->db->select('*')->from('spidypick')->where(array('spidypickId' => $spidey_id))->get()->result_array();

    }



    public function relatedStory($array) {

        if (isset($array['type']) && $array['type'] == 'related') {

            $txt = $array['related_storyTxt'];

            $block = '<table class="related_story_data">';

            //$block.='<table border="0" cellpadding="5" cellspacing="5" width="100%">';

            $row = $this->db

                    ->select('spidypickId,spidyName,headline')

                    ->from('spidypick')

                    ->where("(status='1') and (spidyName like '%$txt%' or headline like '%$txt%')")

                    //->where('status', '1')

                    //->like('spidyName', $txt)

                    //->or_like('headline', $txt)

                    ->order_by('spidypickId', 'desc')

                    ->get()

                    ->result_array();

            for ($i = 0; $i < count($row); $i++) {

                $block .= '<tr><td width="25"><input type="checkbox" name="related_storyId[]" class="related_story" id="related_storyId" value="' . $row[$i]['spidypickId'] . '"></td><td id="related_content_' . $row[$i]['spidypickId'] . '">' . stripslashes($row[$i]['spidyName']) . '</td></tr>';

            }

            $block .= '</table>';

            $block .= "<script type=\"text/javascript\">

                            $(document).ready(function(){

                                $('.related_story').change(function(){

                                        chk_global = '';

                                        localStorage.removeItem('chk_global');

                                        $('.related_story').each(function(){

                                                if($(this).is(\":checked\")){

                                                        var con = $('#related_content_'+$(this).val()).html();

                                                        chk_global+='<tr><td width=\"25\"><input type=\"checkbox\" name=\"related_storyId[]\" class=\"related_story\" id=\"related_storyId\" value=\"'+$(this).val()+'\" checked></td><td id=\"related_content_'+$(this).val()+'\">'+con+'</td></tr>';

                                                }

                                        });

                                        localStorage.setItem(\"chk_global\", chk_global);

                                });

                            });

                        </script>";



            echo $block;

        }

    }



    public function getRelatedStory($story_ids) {

        $txtid = explode(",", $story_ids);

        $row = $this->db

                ->select('spidypickId,spidyName,headline')

                ->from('spidypick')

                ->where_in('spidypickId', $txtid)

                ->where('status', '1')

                ->get()

                ->result_array();



        $block = '<table class="related_story_data">';



        foreach ($row as $r) {//for ($relstory = 0; $relstory < sizeof($txtid); $relstory++) {

            $block .= '<tr>

                        <td>

                        <input type="checkbox" name="related_storyId[]" class="related_story" id="related_storyId" value="' . $r['spidypickId'] . '" checked>

                        </td>

                        <td id="related_content_' . $r['spidypickId'] . '">' . stripslashes($r['spidyName']) . '</td>

                        </tr>';

        }

        $block .= '</table>';

        return $block;

    }



    function publish_unpublish($spidey_id, $status) {

         if($this->db->where('spidypickId', $spidey_id)->update('spidypick', array('status' => $status))){

			

			return 1;

		}else{

			return 0;

		}

    }

	

	

	##===================== By Rocky==============================##

	

	function approved_user_story($story_id) {

        return $this->db->where('id', $story_id)->update('buzz_people_story', array('editor_action' => 1));//  echo '**'.$this->db->last_query();exit;

    }

	

	function get_media_details($storyId){

		if(!empty($storyId)){ 

			$this->db->select('*');

			$this->db->from('buzz_media_master');

			$this->db->where(array('story_id'=>$storyId));

			$query = $this->db->get();  //echo '---sql='.$this->db->last_query();exit;

			$total_rows = 0;

			$total_rows = $query->num_rows() ;

			$result = $query->result_array(); 

 			 return $result[0];

 

		}

	}

	 

	

	public function make_breaking_news($post_array){

		$res = '1';

		//print_r($post_array); exit;

		$story_id = $post_array['story_id'];

		$value = $post_array['chk_val'];

		if($value == 1){

		$count = $this->db->query("SELECT count(*) as total from spidypick where is_breaking_news='1'")->row()->total;

		if($count>=3){

			echo $res = '2';exit;

		}else{

		

			$breaking_news_title = $this->db->query("SELECT breaking_news_title from spidypick where spidypickId='".$story_id."'")->row()->breaking_news_title;

			if(!empty($breaking_news_title)) 

			{

				$this->db->set('is_breaking_news', $value); 

				$this->db->where('spidypickId', $story_id); 

				$this->db->update('spidypick'); 

				

			}else{

				echo $res = '3';exit;

				

			}

		}

		}else{

			$this->db->set('is_breaking_news', $value); 

			$this->db->where('spidypickId', $story_id); 

			$this->db->update('spidypick'); 

			

		}

		echo $res;exit;

		

	}

	function checkStoryExists($url='',$id='')

	{

		$result = $url;

		$pick=0;

		$whereData = array('story_url'=>$url);

		if(!empty($id)){

			$whereData = array('story_url'=>$url,'spidypickId!='=>$id);

		}

		

		$this->db->select('spidypickId');

		$this->db->from('spidypick');

		$this->db->where($whereData);

		$query = $this->db->get(); //echo $this->db->last_query();

		//echo $query->num_rows();exit;

		if ($query->num_rows() > 0) {

			$res = $query->result_array();//echo '**';print_r($res);

			$pick = $res[0]['spidypickId'];

			if($pick>0){

				$result=1;

			};

		}

		echo  $result;exit;

 	}

	

	function fetchCity($id='')

	{

		$result 		= '';

 		$this->db->select('*');

		$this->db->from('tbl_city');

		if(!empty($id)){

			$this->db->where_in('state_id', $id);

		}else{

 

			echo json_encode('');exit;

		}

 		$query 			= $this->db->get();  //echo $this->db->last_query();exit;

 		if ($query->num_rows() > 0) {

			$res 		= $query->result_array(); //echo '**<pre>';print_r($res);

			$cityARR = array();

			$all_city_ids =array();

			$cityARR = explode(',',$this->input->post('all_selected_city'));

  			 foreach ($res as $s){ 

			 $checked = '';

			

			if(in_array($s['city_id'],$cityARR)){

				$checked = "checked";

 			}

			  $all_city_ids[] = $s['city_id'];

 			   $result['citys']  .='<div style="width:70%;float:left;"> <label for="'.$s['city_name'].'" >'. $s['city_name'].'</label></div>'.

				 '<div style="width:30%;float:right;"> <input '.$checked.' id="city_'.$s['city_id'].'" type="checkbox" class="state_chk" name="city[]" value="'.$s['city_id'].'" 

				 onclick="javascript: display_area(this.id);"></div>'; 

				// $result['citys'][]="kamal";

		   } 

		  

		  	if($all_city_ids){

				 $result['areas'] =  $all_city_ids;	

			}

  		}

		

		

		echo  json_encode($result);exit;

 	}

	

	function fetchArea($id='')

	{

		$result 		= '';

 		$this->db->select('*');

		$this->db->from('tbl_area');

 		if(!empty($id)){

			$this->db->where_in('city_id', $id);

		}else{

			echo json_encode('');exit;

		}

		

		$query 			= $this->db->get(); 	//echo $this->db->last_query();

		//echo $query->num_rows();exit;

		if ($query->num_rows() > 0) {

			$res 		= $query->result_array();//echo '**<pre>';print_r($res);

  			 foreach ($res as $s){ 

 			  $result  .='<div style="width:70%;float:left;"> <label for="'.$s['area_name'].'" >'. $s['area_name'].'</label></div>'.

				 '<div style="width:30%;float:right;"> <input id="area_'.$s['area_id'].'" type="checkbox" class="state_chk" name="area[]" value="'.$s['area_id'].'"></div>';

		   }  

 			//foreach($res as $val){

				//$result.='<option value="'.$val['city_id'].'">'.$val['city_name'].'</option>';

			//}

 		}

		echo  json_encode($result);exit;

 	}

	

	function getstoryMedia($storyId=''){

		$resultMedia = array();

		$sql = $this->db->select('*');

		$this->db->from('buzz_media_master');

		$this->db->where('story_id', $storyId);

		$query 			= $this->db->get(); //echo $this->db->last_query();	

		if ($query->num_rows() > 0) {

			$resultMedia = $query->result_array();

			$resultMedia  = $resultMedia[0];

		}

		return $resultMedia;

	}

	

	

	## Update slider count

	function updateSliderCount($slider_cnt){

		$res=false;

		$user_id = $this->session->userdata('admin_user_id');

		$updatedData=array("slider_cnt"=>$slider_cnt,'updated_by'=>$user_id);

		$whereData = array('id'=>1 );

		$this->db->set($updatedData);

		$this->db->where($whereData);

		if($this->db->update('buzz_slider')){//echo $this->db->last_query();	exit;

 			$res=true;			

		}return $res;

 	}

	

	## Update slider count

	function getslidetCnt(){

		$res=0;

 		$sql = $this->db->select('slider_cnt');

		$this->db->from('buzz_slider');

		$this->db->where('id', 1);

		$query 			  = $this->db->get();  //echo $this->db->last_query();	

		if ($query->num_rows() > 0) {

			$resultMedia  = $query->result_array();

			$resultMedia  = $resultMedia[0]['slider_cnt'];

		}

 		return $resultMedia;

 	}

	

	## Update slider count

	function updateSliderStories($ids){

		$res=false;

		$user_id = $this->session->userdata('admin_user_id');

		$updatedData=array("story_ids"=>$ids,'updated_by'=>$user_id);

		$whereData = array('id'=>1);

		$this->db->set($updatedData);

		$this->db->where($whereData);

		if($this->db->update('buzz_slider')){ //echo $this->db->last_query();	exit;

 			$res=true;			

		}return $res;

 	}

	

	## get Slider ids

	function getSliderIds(){

		$res=0;

 		$sql = $this->db->select('story_ids');

		$this->db->from('buzz_slider');

		$this->db->where('id', 1);

		$query 			  = $this->db->get();  //echo $this->db->last_query();	

		if ($query->num_rows() > 0) {

			$resultMedia  = $query->result_array();

			$resultMedia  = $resultMedia[0]['story_ids'];

			$resultMedia = json_decode($resultMedia);

			

		}

 		return $resultMedia;

 	}



	// =================================== By Verendra ============================= //

	// Buzz story listing in backend

	function fetchBuzzStoryIdeaList($limit,$start, $user_id,$srchcondition='',$status,$assigned){

		if(!empty($srchcondition)){

			$srchData = json_decode($srchcondition);

			$whereCondition = $this->searchIdea($srchcondition);

		}



 		## For Editorial  Listing

		elseif($this->uri->segment(3)=='buzz_story_listing'){

			//$whereData = array('status'=>1,'is_delete'=>0,'buzz_story_id !='=>0);

			$whereData = array('buzz_story_id !='=>0);

			//$this->db->where_in('assigned', array(1,3));

 			$this->db->where_in('assigned', array(1,2));

		}  

		 ## For Editorial Listing

		 ## For outputsub Listing 

		elseif($this->uri->segment(3)=='suboutput'){

			$whereData = array('status'=>1,'is_delete'=>0,'buzz_story_id !='=>0);

 			$this->db->where_in('assigned', array(2));

		}  

		 ## For outputsub Listing

		

		

		if($start>1){

			$start = ($start-1)*$limit;

		}

		$this->db->select('buzz_idea.*, buzz_people_story.editor_action');

		$this->db->from('buzz_idea');

		$this->db->join('buzz_people_story', 'buzz_idea.buzz_story_id=buzz_people_story.id');

		$this->db->where($whereData);

		$this->db->order_by('created_on','DESC');

 		$this->db->limit($limit, $start);

		

 		$query = $this->db->get();

		// echo $this->db->last_query();exit;



		if ($query->num_rows() > 0) {

		  	

			$res = $query->result_array();

 		}

		return $res;

	}



	// Buzz Total stories

	function buzz_totalIdeaList($user_id,$srchcondition='',$status='',$assigned=''){

	 //echo '***'.$this->uri->segment(3);exit;

		if(!empty($srchcondition)){

			$srchData = json_decode($srchcondition);

			$whereCondition = $this->searchBuzzIdea($srchcondition);

		}

		

 		## For Editorial  Listing

		elseif($this->uri->segment(3)=='buzz_story_listing'){

			//$whereData = array('status'=>1,'is_delete'=>0,'buzz_story_id !='=>0);

			$whereData = array('buzz_story_id !='=>0);

 			//$this->db->where_in('assigned', array(1,2));

 			$this->db->where_in('assigned', array(1,2));

		} ## For Editorial Listing

		

		 ## For outputsub Listing 

		elseif($this->uri->segment(3)=='suboutput'){

			$whereData = array('status'=>1,'is_delete'=>0,'buzz_story_id !='=>0);

 			$this->db->where_in('assigned', array(3));

		}  

		 ## For outputsub Listing

		//print_r($whereData);exit;

		$this->db->select('count(1) as cnt');

		$this->db->from('buzz_idea');

		$this->db->where($whereData);

 		$query = $this->db->get();   //echo '---sql='.$this->db->last_query();//exit;

		$total_rows = 0;

		$total_rows = $query->num_rows() ;

		$result = $query->result_array(); 

		$res = $result[0]['cnt'];

 		 return $res;

 	}

 	

 	// Search data in buzz table

	function searchBuzzIdea($srchData){

		$srchData = json_decode($srchData,true);

		if(count($srchData)>0){

			if($srchData['srchDD']==2){

  			return $whereCondition = $this->db->where('cast(created_on as date)  BETWEEN "'. date('Y-m-d', strtotime($srchData['fromdate'])). '" and "'. date('Y-m-d', strtotime($srchData['todate'])).'"'); 

			}else if($srchData['srchDD']==1){				

			 $whereCondition = '(title LIKE "'.$srchData['search'].'%")';

       		 return $this->db->where($whereCondition);

 			}

		}

 	}



 	// Approve Buzz Story

 	function approveBuzzStory( $spidey_id, $user_id ) {

		$res = false;

		

		// Update table buzz_people_story

		$this->db->where( array( 'id' => $spidey_id ) );

		$this->db->update( 'buzz_people_story', array( 'editor_action' => 1 ) );



		// Update table buzz_idea

		$this->db->where( array( 'buzz_story_id' => $spidey_id ) );

		if( $this->db->update( 'buzz_idea', array( "status" => 1, "assigned" => 2 ) ) ) {

			$res = true;

		}



		return $res;

 	}



 	// Reject Buzz Story

 	function rejectBuzzStory( $spidey_id, $user_id ) {

		$res = false;

		

		// Update table buzz_people_story

		$this->db->where( array( 'id' => $spidey_id ) );

		$this->db->update( 'buzz_people_story', array( 'editor_action' => 2 ) );



		// Update table buzz_idea

		$this->db->where( array( 'buzz_story_id' => $spidey_id ) );

		if( $this->db->update( 'buzz_idea', array( "status" => 1, "assigned" => 2 ) ) ) {

			$res = true;

		}



		return $res;

 	}



 	// Set Is_Main story for special section

 	function setIsMain( $story_id ) {

 		// Set 0 for all stories

 		$this->db->update('spidypick', array( 'is_main_in_special' => 0 ));



 		// Set 1 for clicked Story ID record

 		$this->db->where( 'spidypickId', $story_id );

 		$this->db->update('spidypick', array( 'is_main_in_special' => 1 ));



 		$updated_status = $this->db->affected_rows();



 		if( $updated_status )

 			return true;

 		else

 			return false;

 	}

	

	function fetch_notification_list(){

		$id 			= $this->session->userdata('admin_user_id');

		$id 			= !empty($id)?$id:0;

		

		$login_type 	= $this->session->userdata('login_type');

		

		$this->db->select('*');

		$this->db->from('buzz_idea');

		

		if($login_type=='reporter'){ 

			

 			$this->db->where("(is_notification_read=0 and status=1 and (created_by='".$id."' or updated_by='".$id."') and(assigned=0 OR assigned=2))");

		}

		

		if($login_type=='input'){

			 

			$this->db->where("(is_notification_read=0 and status=1 and (assigned=1 OR assigned=3))");

		}

		$this->db->order_by('created_on', 'desc'); 

 		$query = $this->db->get();  // echo '---sql='.$this->db->last_query();exit;

		$this->update_notification_view_count();

		$total_rows = 0;

		$total_rows = $query->num_rows() ;

		$result = $query->result_array(); 

  		return $result;

	}

	

	function update_notification_view_count(){

		$login_type 	= $this->session->userdata('login_type');

		$id 			= $this->session->userdata('admin_user_id');

		$id 			= !empty($id)?$id:0;

		$updatedData	= array("is_notification_read"=>1);

		$this->db->set($updatedData);

		if($login_type=='reporter'){

			$this->db->where("created_by='".$id."' or updated_by='".$id."'");

		}

		if($login_type=='input'){

			$this->db->where("(status=1 and  (assigned=1 or assigned=3))");

		}

		if($this->db->update('buzz_idea')){

			 //echo $this->db->last_query();exit;

			

		}

	}

	

	function getUserDetail(){

		$user_id 	= $this->session->userdata('admin_user_id');

		$this->db->select('*');

		$this->db->from('backend_user');

		$this->db->where(array('status'=>'1', 'user_id'=>$user_id));

		$query = $this->db->get();  //echo '---sql='.$this->db->last_query();exit;

		$total_rows = 0;

		$result = array();

		$total_rows = $query->num_rows() ;
 		if($total_rows>0){
 			$result = $query->result_array(); 
 		}
 		return $result;
 	}
	
	function checking_password($pass){
		$userId=0;
		$returndata='false';
		$this->db->select('user_id');
 		$this->db->from('backend_user');
 		$this->db->where(array('password'=>md5($pass)));
  		$query = $this->db->get();//echo '**'.$this->db->last_query();exit;
 		if ($query->num_rows() > 0) {
 			$res = $query->result_array();
			$userId=$res[0]['user_id'];
			if($userId!=''){
				$returndata='true';
			}
  		}
 		return $returndata;
 	}
 }