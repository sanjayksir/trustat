<?php
 class Surveys extends MX_Controller {
     function __construct() {
         parent::__construct();
         $this->load->model('Survey_model');
		 $this->load->helper('common_functions_helper');
		 $this->load->library('pagination');
     }
	 
	 


     function set_attributes() {
		 $this->checklogin();
		 
		 if($this->input->post('hidden_field')=='1'){
		 	//echo '<pre>';print_r($this->input->post());exit;
			 $this->Survey_model->saveAttributeList($this->input->post());
		 }
         $data['get_attr'] = $this->Survey_model->getAttributeList();
 		$this->load->view('attribute_list', $data);
     }

    function checklogin(){
 		$user_id 	= $this->session->userdata('admin_user_id');
 		$user_name 	= $this->session->userdata('user_name');
 		if(empty($user_id) && $user_id!=1){
 			redirect(base_url().'login');	exit;
 		}
 	}

     function update_attributes($id) {
		 $this->checklogin();
	 	$data['listData']=$this->Survey_model->getOptionList($id);
	 	if($this->input->post('submit')){
			 $this->Survey_model->update_attribute_val($this->input->post());
		}
         // check if the unitofarea exists before trying to edit it
       //  $data['unitofarea'] = $this->Survey_model->getOptionList($id);
         $this->load->view('attribute_add', $data);
     }
	 
	   

     
 
    
 
 	function add_Survey(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();
		
		$data['Survey_attr'] = $this->Survey_model->get_all_attrs();
		$this->load->view('add_Survey_tpl', $data);
		
	}
	
	
	function update_Survey(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();
		
		//$data['Survey_attr'] = $this->Survey_model->get_all_attrs();
		$data['Survey_data'] = $this->Survey_model->fetch_Survey_detail($this->uri->segment(3));
		$this->load->view('edit_Survey_tpl', $data);
		
	}
 
 
 function getSubCategory_bkp(){
 $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	$id			= $this->input->post('id');
	//print_r($this->input->post());
	$result = '<option value="0">-Select Industry (Level-1)-</option>';
	if(!empty($id)){
 	$this->db->select('Survey_id, name');
 	$this->db->from('attribute_name');
 	$this->db->where('parent',$id);
  	$query = $this->db->get();  //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			
			foreach($res as $val){
				$result .= '<option value="'.$val['Survey_id'].'">'.$val['name'].'</option>';
			}
			
 		}
	}
	$result .= '</option>';		
  	echo $result;exit;
 }
 
 
  function getSubCategory(){
 $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	$id			= $this->input->post('id');
	$level			= $this->input->post('lev');
	//print_r($this->input->post());
	$result = '<option value="0">- Select Industry (Level-'.($level-1).') -</option>';
	if(!empty($id)){
 	$this->db->select('category_Id, categoryName');
 	$this->db->from('categories');
 	$this->db->where('parent',$id);
  	$query = $this->db->get();  //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			
			foreach($res as $val){
				$result .= '<option value="'.$val['category_Id'].'">'.$val['categoryName'].'</option>';
			}
			
			
 		}$result .= '<option value="other">Other</option>';
	}
	$result .= '</option>';		
  	echo $result;exit;
 }
 
 
  function checkSurveyExists($id=''){
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	   $name = $this->input->post('Survey_name');
	   
	   
 	  echo $this->Survey_model->IsExistsSurvey($name,$id='');exit;
  }
  
  function save_Survey($id='') {
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
  		$res = $this->Survey_model->save_Survey($id);
		if($res=='1'){
			echo '1';
		}else{
			echo '0';
		}
		exit;
    }
	
	
 function genate_sku(){
		$name = $this->input->post('name');
		$pin = mt_rand(1000, 9999);
 		echo $res =  slugify2($name).'-'.$pin;
		exit;
   }
   
   public function launch_survey() {
        $this->checklogin();
		/*
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from Surveys where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Survey Deleted Successfully!');
            }
        }
		*/
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->get('search');
       
        if (empty($srch_string)) {
            $srch_string = '';
        }
		$customer_id = $this->session->userdata('admin_user_id');
		
			
        $total_records = $this->Survey_model->total_survey_listing($srch_string);
        $params["orderListing"] = $this->Survey_model->surveys_listing($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('surveys/launch_survey', $total_records);
        $this->load->view('launch_surveys_tpl', $params);
    }
	
	public function create_Survey() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from Surveys where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Survey Deleted Successfully!');
            }
        }
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->get('search');
       
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Survey_model->total_product_listing($srch_string);
        $params["product_list"] = $this->Survey_model->product_listing($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('Survey/create_Survey', $total_records);
        $this->load->view('create_Survey', $params);
    }	
	
	
// list assigned Surveys to Plant controller 

function list_assigned_Surveys() {
		 $this->checklogin();
		 if(!empty($this->input->post('del_submit'))){
		 	if($this->db->query("delete from Surveys where id='".$this->input->post('del_submit')."'")){
				$this->session->set_flashdata('success', 'Survey Deleted Successfully!');	
			}
		 }
		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Survey_model->total_Survey_listing($srch_string);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Survey_list"] = $this->Survey_model->assigned_Survey_listing($limit_per_page, $start_index,$srch_string);
             
            $config['base_url'] = base_url() . 'Survey/list_assigned_Surveys';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
 			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';	
			$config["first_link"] = "&laquo;";
			$config["first_tag_open"] = "<li>";
			$config["first_tag_close"] = "</li>";
			$config["last_link"] = "&raquo;";
			$config["last_tag_open"] = "<li>";
			$config["last_tag_close"] = "</li>";
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '<li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '<li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
 
			## paging style configuration End 
            $this->pagination->initialize($config);
             // build paging links
            $params["links"] = $this->pagination->create_links();
        }
		##--------------- pagination End ----------------##
		
       //  $data['Survey_list'] = $this->Survey_model->Survey_listing();
 		$this->load->view('list_assigned_Surveys', $params);
     }
	 
	 
	
	 function getChildsDD(){
	 	$id 	= $this->input->post('id');
		$parent =  explode(',',$this->input->post('child'));
	 	if($id!=''){
			$data = json_decode(getAllSurveyName($id),true);//print_r($data);exit;
			$options = ""; 
			$dd =  '<select class="form-control" name="Survey_attr[]" multiple="multiple"><option>select Child Survey</option>';
			foreach($data as $rec){
				$selected = '';
				if(in_array($rec['Survey_id'],$parent)){
					$selected = 'selected="selected"';
				}
				$dd .= '<option '.$selected.'value="'.$rec['Survey_id'].'">'.$rec['name'].'</option>';
			}
 			$dd .=  '</select>';
			echo $dd;exit;
	 	}
	 }
	 
	 function delete_attribute($id){//echo '**'.$id;exit;
	 	$data = $this->Survey_model->delete_attr($id);
	 }
	 
	 function add_description(){
		$this->load->view('Survey_media_add');
	}
	
	
	 function media_uploader(){
 		 //echo '<pre>';print_r($res);exit;	
		//echo '<pre>';print_r($_FILES);exit;
		if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$res = $this->upload_File('upload_file', array('jpg','JPEG','png'), 'uploads/Survey_media' ,'500','500','2000');
			if($res){
				echo '<pre>';print_r($res);exit;	
			}else{
				echo 'general_system_error';
			}
			/*$vpb_file_name = strip_tags($_FILES['upload_file']['name']); //File Name
			$vpb_file_id = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file name
			$vpb_file_size = $_FILES['upload_file']['size']; // File Size
			$vpb_uploaded_files_location = 'uploaded_files/'; //This is the directory where uploaded files are saved on your server
			$vpb_final_location = $vpb_uploaded_files_location . $vpb_file_name; //Directory to save file plus the file to be saved
 			
			//Without Validation and does not save filenames in the database
			if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location)){
				//Display the file id
				echo $vpb_file_id;
			}else{
				//Display general system error
				echo 'general_system_error';
			}
 	 	*/
		}
	}
	
 	//=====================================================================//
	## file rename	
 	function ImageRename($fileFldName){
		if(!empty($fileFldName)){
			$RandomNum   		= time();
			$ImageNameImg      	= str_replace(' ','-',strtolower($_FILES[$fileFldName]['name']));
			$ImageExt 			= pathinfo($ImageNameImg, PATHINFO_EXTENSION);
			$ImageName      	= str_replace(' ','-',strtolower(basename($_FILES[$fileFldName]['name'],".".$ImageExt)));
 			$ImageName      	= str_replace('.', "", $ImageName);
			$ImageName      	= preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName); 
			$NewImageName 		= $ImageName.'-'.$RandomNum.'.'.$ImageExt;
			return $NewImageName;
		}
 	}
	
	function get_Img_dimention($file_tmp_name){
 		$img		= getimagesize($file_tmp_name);
		//$minimum 	= array('width' => '200', 'height' => '180');
		$width		= $img[0];
		$height 	= $img[1];
		$size 		= array('width'=>$width, 'height'=>$height);
		return json_encode($size);
	}
	
	function imageResize($file,$param){
		$config=array();
 		switch($param){
			case'400x400':
			  $w=400;
			  //$h=169;
			  $file_path='./uploads/Survey_media/thumb/'.$file['file_name'];
			  break;
			case'222x190':
			  $w=222;
			  //$h=190;
			  $file_path='./uploads/Survey_media/thumb/'.$file['file_name'];
			 break;	
		 }
		 $config['image_library'] 	= 'gd2';
		 $config['source_image'] 	= $file['full_path'];
		 $config['new_image'] 		= $file_path;
		 $config['maintain_ratio'] 	= true;
 		 $config['width'] 			= $w;
		 //$config['height'] = $h;
		
		 // Load the Library
		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config);
		
		 // resize image
		 $this->image_lib->resize();
		
		 // handle if there is any problem
		 if ( ! $this->image_lib->resize()){
		  echo $this->image_lib->display_errors();
		 }
	}
	
 	//=============================== Main function of upload file ==================================//
	#file_input_type_name: Name of the file type
	#file_type_arr: must be array like: array('.jpg','.png');
	#Path: must be without leading and traing slashes. Like: uploads/image;
	#max_size: max size to upload

 	function upload_File($file_input_type_name,$file_type_arr, $path ,$img_width,$img_height,$max_size){
 		//echo '<pre>';print_r($_FILES);exit;
   		if(empty($file_type_arr)){## File Type chcek
			$file_type_arr = "JPEG,JPG,image/JPEG,image/JPG,IMAGE/JPEG,image/jpeg,jpg,PNG,png,image/png,image/PNG,GIF,jpeg,gif";
		}else{
			$file_type_str = implode("|", $file_type_arr);
		}
		$uploads = './'.$path.'/';## File Path chcek
		if(empty($max_size)){## file Size
			$max_size=1024;
		}
		if(empty($img_width)){## file width
			$img_width=1000;
		}
		if(empty($img_height)){## file height
			$img_height=600;
		}
 		
 		$data 					  	= array();
 		$config_img['upload_path'] 	= $uploads;
        $config_img['allowed_types']= $file_type_arr;//'JPEG|JPG|image/JPEG|image/JPG|IMAGE/JPEG|image/jpeg|jpg|PNG|png|image/png |image/PNG|GIF|jpeg|gif';
        $config_img['max_size'] 	= $max_size*'10';
        $config['max_width'] 		= $img_width;
        $config['max_height'] 		= $img_height;
		$file_size	 				= $_FILES["size"] / 1024;
		//$type = getimagesize($files['spideyImage']['tmp_name']);
		//print_r($type );exit;
  		 if( isset( $_FILES[$file_input_type_name]['name'] ) && ( ! empty( $_FILES[$file_input_type_name]['name'] ) ) ) {//echo 'kam';exit;
			#check img Size
			$img0		= $this->ImageRename($file_input_type_name);
			$tmp_name 	= $_FILES[$file_input_type_name]['tmp_name'];
			//$size_arr0 	= json_decode($this->get_Img_dimention($tmp_name));
			 //echo '&&&&&&&&<pre>';print_r($size_arr0);exit;
			 
			if($file_size>$config_img['max_size']){	//$size_arr0->width<$img_width || $size_arr0->height<$img_height){//echo 'kam1111';exit;
 				//$data['uploadFile'] = "Max Size limit crossed!"; 
				//return $data ;
				return "Max Size limit crossed!";
			}else{
					$config_img['file_name']=$img0;
					$this->load->library('upload', $config_img);
					$this->upload->initialize($config_img);
					if (!$this->upload->do_upload($file_input_type_name)) {
						//$error = array('error' => $this->upload->display_errors());
 						//$data['uploadFile']= $this->upload->display_errors();
						return $this->upload->display_errors() ;
 					}
					$this->imageResize($this->upload->data(),'400x400');
					//$this->imageResize($this->upload->data(),'300x300');
					//$data[$file_input_type_name] = $img0;
					//$data['uploadFile'] = "file uploaded!";
					return $img0;
					//echo $data['uploadFile'] = "File Uploaded!";exit;
			}
        }
  		
	}
	
	function add_feedback(){
		 $data					= array();
   		 $this->load->view('add_feedback', $data); 
	}
	
	function add_image_feedback(){
		 $data					= array();
   		 $this->load->view('add_image_feedback', $data); 
	}
	
	function add_video_feedback(){
		 $data					= array();
   		 $this->load->view('add_video_feedback', $data); 
	}
	
	function add_audio_feedback(){
		 $data					= array();
   		 $this->load->view('add_audio_feedback', $data); 
	}
	
	function add_pdf_feedback(){
		 $data					= array();
   		 $this->load->view('add_pdf_feedback', $data); 
	}
	
	
	function save_feedback(){
		$data					= array();
		$data = $this->input->post();
		//print_r($data);exit;
		echo $data = $this->Survey_model->save_feedback($data);exit;
	}
	
	// Survey Description Feedback Questions
 function ask_feedback($id=''){
		if(empty($id)){
			redirect('Survey/list_Survey');
		}	
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Survey_model->total_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Survey_list"] = $this->Survey_model->feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Survey/ask_feedback_tpl';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
 			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';	
			$config["first_link"] = "&laquo;";
			$config["first_tag_open"] = "<li>";
			$config["first_tag_close"] = "</li>";
			$config["last_link"] = "&raquo;";
			$config["last_tag_open"] = "<li>";
			$config["last_tag_close"] = "</li>";
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '<li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '<li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
 
			## paging style configuration End 
            $this->pagination->initialize($config);
             // build paging links
            $params["links"] = $this->pagination->create_links();
			$params["Survey_id"] = $id;
        }
		##--------------- pagination End ----------------##
		
       //  $data['Survey_list'] = $this->Survey_model->Survey_listing();
 		$this->load->view('ask_feedback_tpl', $params);
     
	}
	
	// Survey Image Feedback Questions
	function ask_image_feedback($id=''){
		if(empty($id)){
			redirect('Survey/list_Survey');
		}	
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 10;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Survey_model->total_image_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Survey_list"] = $this->Survey_model->image_feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Survey/ask_feedback';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
 			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';	
			$config["first_link"] = "&laquo;";
			$config["first_tag_open"] = "<li>";
			$config["first_tag_close"] = "</li>";
			$config["last_link"] = "&raquo;";
			$config["last_tag_open"] = "<li>";
			$config["last_tag_close"] = "</li>";
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '<li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '<li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
 
			## paging style configuration End 
            $this->pagination->initialize($config);
             // build paging links
            $params["links"] = $this->pagination->create_links();
        }
		##--------------- pagination End ----------------##
		
       //  $data['Survey_list'] = $this->Survey_model->Survey_listing();
 		$this->load->view('ask_image_feedback_tpl', $params);
     
	}
	// Survey Video Feedback Questions
	function ask_video_feedback($id=''){
		if(empty($id)){
			redirect('Survey/list_Survey');
		}	
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Survey_model->total_video_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Survey_list"] = $this->Survey_model->video_feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Survey/ask_feedback';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
 			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';	
			$config["first_link"] = "&laquo;";
			$config["first_tag_open"] = "<li>";
			$config["first_tag_close"] = "</li>";
			$config["last_link"] = "&raquo;";
			$config["last_tag_open"] = "<li>";
			$config["last_tag_close"] = "</li>";
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '<li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '<li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
 
			## paging style configuration End 
            $this->pagination->initialize($config);
             // build paging links
            $params["links"] = $this->pagination->create_links();
        }
		##--------------- pagination End ----------------##
		
       //  $data['Survey_list'] = $this->Survey_model->Survey_listing();
 		$this->load->view('ask_video_feedback_tpl', $params);
     
	}
	// Survey Audio Feedback Questions
	function ask_audio_feedback($id=''){
		if(empty($id)){
			redirect('Survey/list_Survey');
		}	
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Survey_model->total_audio_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Survey_list"] = $this->Survey_model->audio_feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Survey/ask_feedback';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
 			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';	
			$config["first_link"] = "&laquo;";
			$config["first_tag_open"] = "<li>";
			$config["first_tag_close"] = "</li>";
			$config["last_link"] = "&raquo;";
			$config["last_tag_open"] = "<li>";
			$config["last_tag_close"] = "</li>";
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '<li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '<li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
 
			## paging style configuration End 
            $this->pagination->initialize($config);
             // build paging links
            $params["links"] = $this->pagination->create_links();
        }
		##--------------- pagination End ----------------##
		
       //  $data['Survey_list'] = $this->Survey_model->Survey_listing();
 		$this->load->view('ask_audio_feedback_tpl', $params);
     
	}
	// Survey PDF Feedback Questions
	function ask_pdf_feedback($id=''){
		if(empty($id)){
			redirect('Survey/list_Survey');
		}	
 		 $this->checklogin();
 		 ##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->Survey_model->total_pdf_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Survey_list"] = $this->Survey_model->pdf_feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Survey/ask_feedback';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
 			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';	
			$config["first_link"] = "&laquo;";
			$config["first_tag_open"] = "<li>";
			$config["first_tag_close"] = "</li>";
			$config["last_link"] = "&raquo;";
			$config["last_tag_open"] = "<li>";
			$config["last_tag_close"] = "</li>";
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '<li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '<li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
 
			## paging style configuration End 
            $this->pagination->initialize($config);
             // build paging links
            $params["links"] = $this->pagination->create_links();
        }
		##--------------- pagination End ----------------##
		
       //  $data['Survey_list'] = $this->Survey_model->Survey_listing();
 		$this->load->view('ask_pdf_feedback_tpl', $params);
     
	}
	
	
		 function check4(){ 	
		 
		  $fb_token = "cdPQ1CE_uwM:APA91bFRbTrm0v3EN0jirO3ZrU6LvQxumlcmu6LPVqtggECBcDH6PZlk4RfHj7uFwa8hu72Wnscg1YOA-itG6Am7JUMl3a9lfjuJTS9Q9Kz8FRvda5fo3JHaDL62lFjsVuKqHFqwMUkF";
		  
		//echo $this->Survey_model->sendFCM("Sanjay....A Survey Posted!!", $fb_token);
		 echo $this->Survey_model->sendFCM('Congratulations! Your registration is complete, and Loyalty Points have been added in your TRUSTAT loyalty program.', $fb_token);
		 
		// $this->Survey_model->sendFCM("A Survey Posted!!", $fb_token);
		 
		 	}
			
			
		function reverse_birthday( $years ){
			return date('Y-m-d', strtotime($years . ' years ago'));
							}
								
			
	function save_push_survey(){
	 	$this->checklogin();		
		$customer_id=$this->input->post('c_id');
		$product_id	=$this->input->post('p_id');
		$promotion_id =$this->input->post('promotion_id');
		$promotion_title =$this->input->post('promotion_title');
		$promotion_notification_message =$this->input->post('promotion_notification_message');
		$consumer_selection_criteria =$this->input->post('sent_to');
		$promotion_media_type =$this->input->post('promotion_media_type');
		$number_of_consumers =$this->input->post('number_of_consumers');
		$Chk = $this->input->post('Chk');
 echo $this->Survey_model->save_push_Survey($customer_id,$product_id,$promotion_id,$promotion_title,$consumer_selection_criteria,$promotion_media_type,$Chk);
		
		if($Chk==2){
		$value=2;
		} else {
			$value=1;
		}
		
		if($value==1){
			
			$cbb1_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 8)->get()->row();
			$billin_particular_name = $cbb1_result->billin_particular_name;
			$billin_particular_slug = $cbb1_result->billin_particular_slug;
		
			$CBBdata['customer_id'] = $customer_id;
			$CBBdata['billing_particular_name'] = $billin_particular_name;		
			$CBBdata['billing_particular_slug'] = $billin_particular_slug;
			$CBBdata['trans_quantity'] = $number_of_consumers; 
			$CBBdata['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$CBBdata['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $CBBdata);
			
			$TRNNC_result = $this->db->select('billin_particular_name, billin_particular_slug')->from('customer_billing_particular_master')->where('cbpm_id', 10)->get()->row();
			$TRNNC_billin_particular_name = $TRNNC_result->billin_particular_name;
			$TRNNC_billin_particular_slug = $TRNNC_result->billin_particular_slug;
			
			$TRNNCData['customer_id'] = $customer_id;
			//$TRNNCData['consumer_id'] = $consumer_id;
			$TRNNCData['billing_particular_name'] = $TRNNC_billin_particular_name.' Survey';		
			$TRNNCData['billing_particular_slug'] = $TRNNC_billin_particular_slug.'_survey';
			$TRNNCData['trans_quantity'] = $number_of_consumers; 
			$TRNNCData['trans_date_time'] = date("Y-m-d H:i:s",time()); 
			$TRNNCData['trans_status'] = 1; 			
			$this->db->insert('tr_customer_bill_book', $TRNNCData);	
			
		}
		
		echo $status= $this->Survey_model->change_status($promotion_id,$value);
		
		if($consumer_selection_criteria=="All") {
		
		//echo $status= $this->Survey_model->change_status($promotion_id,$value);
		$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."' AND registration_status='Registered';");
				
				foreach ($query->result() as $user)  
				{
		  $consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 $mnv50_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 50)->get()->row();
		$mnvtext50 = $mnv50_result->message_notification_value;
			//sleep(15);
		 
		 	
			if($Chk==1){
			sleep(2);
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "TRUSTAT!!";
			$NTFdata['body'] = $promotion_notification_message; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s"); 
			$NTFdata['status'] = 0; 			
			$this->db->insert('list_notifications_table', $NTFdata);
			$this->Survey_model->sendFCM($promotion_notification_message, $fb_token);
			}
		 }
			}else{				
			
		// echo $status= $this->Survey_model->change_status($promotion_id,$value);
		
		$AllSelectedConsumersByACustomer = $this->Survey_model->AllSelectedConsumersByACustomer2($customer_id, $consumer_selection_criteria);
				
				foreach ($AllSelectedConsumersByACustomer as $consumer_idArray)  
				{ 
				$consumer_id = $consumer_idArray->id;
		 //$consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		$mnv50_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 50)->get()->row();
		$mnvtext50 = $mnv50_result->message_notification_value;
		 //$this->Survey_model->sendFCM("Here is a Survey for you from TRUSTAT.", $fb_token);
		// sleep(15);
		 
			
			if($Chk==1){
			sleep(2);
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "TRUSTAT!!";
			$NTFdata['body'] = $promotion_notification_message; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s"); 
			$NTFdata['status'] = 0; 			
			$this->db->insert('list_notifications_table', $NTFdata);
			$this->Survey_model->sendFCM($promotion_notification_message, $fb_token);
			}
		 }
		}
		exit;		
 	}
	
	public function change_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='2';# Now it will be inactive
		 }
		 //$user_id 	= $this->session->userdata('admin_user_id');		
		 echo $status= $this->Survey_model->change_status($id,$status);exit;
     }
	 
	 
	 public function save_promotion_request() {
		  //print_r($_POST);exit;
		  $savedData = $this->input->post();
  		  echo $this->Survey_model->save_promotion_request($savedData);  exit;
      }
	  
	public function change_order_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
 		 echo $status= $this->Survey_model->change_order_status($id,$status);exit;
      }
	  
	  
	  
	 
	public function view_survey_details() {
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Survey_model->count_survey_details($srch_string);

        $params["ScanedCodeListing"] = $this->Survey_model->get_survey_details($limit_per_page, $start_index, $srch_string);
		
        $params["links"] = Utils::pagination('surveys/view_survey_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('view_survey_details_tpl', $params);
    }
	
	
	public function view_survey_response_by_question_answer() {
        ##--------------- pagination start ----------------##
        // init params
		
		
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
		
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');
		
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Survey_model->count_survey_details_by_question_answer($srch_string, $from_date_data, $to_date_data);

        $params["ScanedCodeListing"] = $this->Survey_model->get_survey_details_by_question_answer($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		
        $params["links"] = Utils::pagination('surveys/view_survey_response_by_question_answer', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
		$promotion_id = $this->uri->segment(3);
		
		$this->db->select('*');
			$this->db->from('push_promotion_master');
			$this->db->where('promotion_id', $promotion_id);
			//$this->db->where(array('promotion_id' => $promotion_id, 'promotion_type' => "Survey"));
			$query=$this->db->get(); 
		
		 $params["promotion_type"] = $query->row()->promotion_type;
		 $params["promotion_media_type"] = $query->row()->promotion_media_type;
		 $params["promotion_title"] = $query->row()->promotion_title;
		 $params["promotion_request_id"] = $query->row()->promotion_request_id;
		 $params["request_date_time"] = $query->row()->request_date_time;
		 $params["request_update_datetime"] = $query->row()->request_update_datetime;
		 $params["promotion_launch_date_time"] = $query->row()->promotion_launch_date_time;
		 $params["promotion_closure_date_time"] = $query->row()->promotion_closure_date_time;
		 $params["number_of_consumers"] = $query->row()->number_of_consumers;
		 $params["unique_system_selection_criteria_id"] = $query->row()->unique_system_selection_criteria_id;
		 $params["product_id"] = $query->row()->product_id;
		  $product_id = $query->row()->product_id;
		  
		  $this->db->select('*');
			$this->db->from('products');
			$this->db->where('id', $product_id);
			//$this->db->where(array('promotion_id' => $promotion_id, 'promotion_type' => "Survey"));
			$query1=$this->db->get(); 
		$params["product_name"] = $query1->row()->product_name;
		$params["product_survey_video"] = $query1->row()->product_survey_video;
		$params["product_survey_audio"] = $query1->row()->product_survey_audio;
		$params["product_survey_pdf"] = $query1->row()->product_survey_pdf;
		$params["product_survey_image"] = $query1->row()->product_survey_image;
		$params["Number_of_responses_from_consumers"] = $total_records;
		  
		
        $this->load->view('view_survey_response_by_question_answer_tpl', $params);
    }
	
	public function view_survey_response_by_question_answer_download() {
        ##--------------- pagination start ----------------##
        // init params
		
		$mnv58_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 58)->get()->row();
		$mnvtext58 = $mnv58_result->message_notification_value;
		
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $mnvtext58;
        }else{
            $limit_per_page = $mnvtext58;
        }
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');
		
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->Survey_model->count_survey_details_by_question_answer($srch_string, $from_date_data, $to_date_data);

        $params["ScanedCodeListing"] = $this->Survey_model->get_survey_details_by_question_answer($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
		
        $params["links"] = Utils::pagination('surveys/view_survey_response_by_question_answer_download', $total_records,null,4);
        $params["links2"] = Utils::pagination2('surveys/view_survey_response_by_question_answer_download', $total_records,null,4);
		$params["total_records2"] = $total_records;
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
		$promotion_id = $this->uri->segment(3);
		
		$this->db->select('*');
			$this->db->from('push_promotion_master');
			$this->db->where('promotion_id', $promotion_id);
			//$this->db->where(array('promotion_id' => $promotion_id, 'promotion_type' => "Survey"));
			$query=$this->db->get(); 
		
		 $params["promotion_type"] = $query->row()->promotion_type;
		 $params["promotion_media_type"] = $query->row()->promotion_media_type;
		 $params["promotion_title"] = $query->row()->promotion_title;
		 $params["promotion_request_id"] = $query->row()->promotion_request_id;
		 $params["request_date_time"] = $query->row()->request_date_time;
		 $params["request_update_datetime"] = $query->row()->request_update_datetime;
		 $params["promotion_launch_date_time"] = $query->row()->promotion_launch_date_time;
		 $params["promotion_closure_date_time"] = $query->row()->promotion_closure_date_time;
		 $params["number_of_consumers"] = $query->row()->number_of_consumers;
		 $params["unique_system_selection_criteria_id"] = $query->row()->unique_system_selection_criteria_id;
		 $params["product_id"] = $query->row()->product_id;
		  $product_id = $query->row()->product_id;
		  
		  $this->db->select('*');
			$this->db->from('products');
			$this->db->where('id', $product_id);
			//$this->db->where(array('promotion_id' => $promotion_id, 'promotion_type' => "Survey"));
			$query1=$this->db->get(); 
		$params["product_name"] = $query1->row()->product_name;
		$params["product_survey_video"] = $query1->row()->product_survey_video;
		$params["product_survey_audio"] = $query1->row()->product_survey_audio;
		$params["product_survey_pdf"] = $query1->row()->product_survey_pdf;
		$params["product_survey_image"] = $query1->row()->product_survey_image;
		$params["Number_of_responses_from_consumers"] = $total_records;
		  
        $this->load->view('view_survey_response_by_question_answer_download_tpl', $params);
    }

	
	function review_survey($id = '') {
        if (empty($id)) {
            redirect('surveys/launch_survey');
        }
        $data['detailData'] = $this->Survey_model->review_survey_data($id);
        $this->load->view('review_survey_tpl', $data);
    }
	
	 
}

