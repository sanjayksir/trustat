<?php
 class Textmessages extends MX_Controller {
     function __construct() {
         parent::__construct();
         $this->load->model('Textmessage_model');
		 $this->load->helper('common_functions_helper');
		 $this->load->library('pagination');
		 //$this->load->model('Api/ConsumerModel');
     }

	 function test() {
					 echo "sss";
				 }

	 
     function set_attributes() {
		 $this->checklogin();
		 
		 if($this->input->post('hidden_field')=='1'){
		 	//echo '<pre>';print_r($this->input->post());exit;
			 $this->Advertisement_model->saveAttributeList($this->input->post());
		 }
         $data['get_attr'] = $this->Advertisement_model->getAttributeList();
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
	 	$data['listData']=$this->Advertisement_model->getOptionList($id);
	 	if($this->input->post('submit')){
			 $this->Advertisement_model->update_attribute_val($this->input->post());
		}
         // check if the unitofarea exists before trying to edit it
       //  $data['unitofarea'] = $this->Advertisement_model->getOptionList($id);
         $this->load->view('attribute_add', $data);
     }
	 
	   

     
 
    
 
 	function add_Advertisement(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();
		
		$data['Advertisement_attr'] = $this->Advertisement_model->get_all_attrs();
		$this->load->view('add_Advertisement_tpl', $data);
		
	}
	
	
	function update_Advertisement(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();
		
		//$data['Advertisement_attr'] = $this->Advertisement_model->get_all_attrs();
		$data['Advertisement_data'] = $this->Advertisement_model->fetch_Advertisement_detail($this->uri->segment(3));
		$this->load->view('edit_Advertisement_tpl', $data);
		
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
 	$this->db->select('Advertisement_id, name');
 	$this->db->from('attribute_name');
 	$this->db->where('parent',$id);
  	$query = $this->db->get();  //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			
			foreach($res as $val){
				$result .= '<option value="'.$val['Advertisement_id'].'">'.$val['name'].'</option>';
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
 
 
  function checkAdvertisementExists($id=''){
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	   $name = $this->input->post('Advertisement_name');
	   
	   
 	  echo $this->Advertisement_model->IsExistsAdvertisement($name,$id='');exit;
  }
  
  function save_Advertisement($id='') {
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
  		$res = $this->Advertisement_model->save_Advertisement($id);
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
   
   public function launch_advertisement() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from Advertisements where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Advertisement Deleted Successfully!');
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
        $total_records = $this->Advertisement_model->total_product_listing($srch_string);
        $params["product_list"] = $this->Advertisement_model->product_listing($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('advertisement/launch_advertisement', $total_records);
        $this->load->view('launch_advertisement', $params);
    }
	
	public function create_advertisement() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from Advertisements where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Advertisement Deleted Successfully!');
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
        $total_records = $this->Advertisement_model->total_product_listing($srch_string);
        $params["product_list"] = $this->Advertisement_model->product_listing($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('advertisement/create_advertisement', $total_records);
        $this->load->view('create_advertisement', $params);
    }	
	
	
// list assigned Advertisements to Plant controller 

function list_assigned_Advertisements() {
		 $this->checklogin();
		 if(!empty($this->input->post('del_submit'))){
		 	if($this->db->query("delete from Advertisements where id='".$this->input->post('del_submit')."'")){
				$this->session->set_flashdata('success', 'Advertisement Deleted Successfully!');	
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
        $total_records = $this->Advertisement_model->total_Advertisement_listing($srch_string);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Advertisement_list"] = $this->Advertisement_model->assigned_Advertisement_listing($limit_per_page, $start_index,$srch_string);
             
            $config['base_url'] = base_url() . 'Advertisement/list_assigned_Advertisements';
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
		
       //  $data['Advertisement_list'] = $this->Advertisement_model->Advertisement_listing();
 		$this->load->view('list_assigned_Advertisements', $params);
     }
	 
	 
	
	 function getChildsDD(){
	 	$id 	= $this->input->post('id');
		$parent =  explode(',',$this->input->post('child'));
	 	if($id!=''){
			$data = json_decode(getAllAdvertisementName($id),true);//print_r($data);exit;
			$options = ""; 
			$dd =  '<select class="form-control" name="Advertisement_attr[]" multiple="multiple"><option>select Child Advertisement</option>';
			foreach($data as $rec){
				$selected = '';
				if(in_array($rec['Advertisement_id'],$parent)){
					$selected = 'selected="selected"';
				}
				$dd .= '<option '.$selected.'value="'.$rec['Advertisement_id'].'">'.$rec['name'].'</option>';
			}
 			$dd .=  '</select>';
			echo $dd;exit;
	 	}
	 }
	 
	 function delete_attribute($id){//echo '**'.$id;exit;
	 	$data = $this->Advertisement_model->delete_attr($id);
	 }
	 
	 function add_description(){
		$this->load->view('Advertisement_media_add');
	}
	
	
	 function media_uploader(){
 		 //echo '<pre>';print_r($res);exit;	
		//echo '<pre>';print_r($_FILES);exit;
		if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$res = $this->upload_File('upload_file', array('jpg','JPEG','png'), 'uploads/Advertisement_media' ,'500','500','2000');
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
			  $file_path='./uploads/Advertisement_media/thumb/'.$file['file_name'];
			  break;
			case'222x190':
			  $w=222;
			  //$h=190;
			  $file_path='./uploads/Advertisement_media/thumb/'.$file['file_name'];
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
		echo $data = $this->Advertisement_model->save_feedback($data);exit;
	}
	
	// Advertisement Description Feedback Questions
 function ask_feedback($id=''){
		if(empty($id)){
			redirect('Advertisement/list_Advertisement');
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
        $total_records = $this->Advertisement_model->total_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Advertisement_list"] = $this->Advertisement_model->feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Advertisement/ask_feedback_tpl';
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
			$params["Advertisement_id"] = $id;
        }
		##--------------- pagination End ----------------##
		
       //  $data['Advertisement_list'] = $this->Advertisement_model->Advertisement_listing();
 		$this->load->view('ask_feedback_tpl', $params);
     
	}
	
	// Advertisement Image Feedback Questions
	function ask_image_feedback($id=''){
		if(empty($id)){
			redirect('Advertisement/list_Advertisement');
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
        $total_records = $this->Advertisement_model->total_image_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Advertisement_list"] = $this->Advertisement_model->image_feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Advertisement/ask_feedback';
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
		
       //  $data['Advertisement_list'] = $this->Advertisement_model->Advertisement_listing();
 		$this->load->view('ask_image_feedback_tpl', $params);
     
	}
	// Advertisement Video Feedback Questions
	function ask_video_feedback($id=''){
		if(empty($id)){
			redirect('Advertisement/list_Advertisement');
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
        $total_records = $this->Advertisement_model->total_video_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Advertisement_list"] = $this->Advertisement_model->video_feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Advertisement/ask_feedback';
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
		
       //  $data['Advertisement_list'] = $this->Advertisement_model->Advertisement_listing();
 		$this->load->view('ask_video_feedback_tpl', $params);
     
	}
	// Advertisement Audio Feedback Questions
	function ask_audio_feedback($id=''){
		if(empty($id)){
			redirect('Advertisement/list_Advertisement');
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
        $total_records = $this->Advertisement_model->total_audio_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Advertisement_list"] = $this->Advertisement_model->audio_feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Advertisement/ask_feedback';
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
		
       //  $data['Advertisement_list'] = $this->Advertisement_model->Advertisement_listing();
 		$this->load->view('ask_audio_feedback_tpl', $params);
     
	}
	// Advertisement PDF Feedback Questions
	function ask_pdf_feedback($id=''){
		if(empty($id)){
			redirect('Advertisement/list_Advertisement');
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
        $total_records = $this->Advertisement_model->total_pdf_feedback_listing($srch_string, $id);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["Advertisement_list"] = $this->Advertisement_model->pdf_feedback_listing($limit_per_page, $start_index,$srch_string, $id);
             
            $config['base_url'] = base_url() . 'Advertisement/ask_feedback';
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
		
       //  $data['Advertisement_list'] = $this->Advertisement_model->Advertisement_listing();
 		$this->load->view('ask_pdf_feedback_tpl', $params);
     
	}
	
	
	function check2(){
	 	
		echo $this->Advertisement_model->sendFCM("addddd...",'AAAA446l5pE:APA91bE3nQ0T5E9fOH-y4w_dkOLU1e9lV7Wn0OmVLaKNnE8tXcZ0eC3buduhCwHL1ICaJ882IHfLy-akAe7Nih7M1RewkO9IzAR-ELdPgmORtb7KjriRrQspVHkIb9GRZPOjXuqfPInlOAly5-65sEEUbGlcoujMgw');
		 
		
		 	}
		 	
	
	function save_push_advertisement(){
	 	$this->checklogin();		
		$customer_id=$this->input->post('c_id');
		$product_id	=$this->input->post('p_id');
		$Chk = $this->input->post('Chk');
		echo $this->Textmessage_model->save_push_advertisement($customer_id,$product_id,$Chk);
		if($Chk==0){
		$value='';
		} else {
			$value=1;
		}
		 echo $status= $this->Textmessage_model->change_status($product_id,$value);exit;
		 $query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$cid."';");
				
				foreach ($query->result() as $user)  
				{
		 $consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Textmessage_model->sendFCM("An Advertisement Posted!!..", $fb_token);
		 
		 $NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "howzzt text message";
			$NTFdata['body'] = "A Text Message Posted!!.."; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 1; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
			
		 }
		//echo  $this->text_message_model->sendFCM("Advertisement pushed!",$fb_token);
		exit;
 	}
	
	function send_text_message(){
		//echo "test";
	 	$this->checklogin();		
		$customer_id=$this->input->post('c_id');
		$message_id	=$this->input->post('m_id');
		$Chk = $this->input->post('Chk');
		$text_message	=$this->input->post('text_message');
		$this->load->view('text_messages_listing');
			if($Chk==1){
			$send_status=1;
		}else{
			
			$send_status=0;
		}
		
		$this->Textmessage_model->save_push_sent_text_message($customer_id,$text_message,$send_status);
	
		$this->Textmessage_model->update_push_text_message_request($message_id,$send_status);
		$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{
		 $consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Textmessage_model->sendFCM($text_message, $fb_token);
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "howzzt text message";
			$NTFdata['body'] = $text_message; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 1; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
		 
		 }
		//echo  $this->Advertisement_model->sendFCM("Advertisement pushed!",$fb_token);
		exit;
		
		/*
		$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{
		 $consumer_id = $user->consumer_id;
		  $fb_token = getConsumerFb_TokenById(17);
		 $this->Textmessage_model->sendFCM($consumer_id, $fb_token);
		
		redirect(base_url().'textmessages/approve_text_messages');	exit;
		
		
		}
		*/
 	}
	
	
	
	function send_text_message2(){
	 	$this->checklogin();		
		//$customer_id=$this->input->post('c_id');
		//$product_id	=$this->input->post('p_id');
		//$Chk = $this->input->post('Chk');
		$customer_id 	= $this->session->userdata('admin_user_id');
		$text_message	=$this->input->post('text_message');
		if($text_message==''){
		$this->load->view('send_text_message2');
		} else {
		//echo $this->Textmessage_model->save_push_advertisement($customer_id,$product_id,$Chk);
		 
		 $query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{
		 $consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Textmessage_model->sendFCM($text_message, $fb_token);
		 $NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "howzzt text message";
			$NTFdata['body'] = $text_message; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 1; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
		 
		 }
		//echo  $this->Textmessage_model->sendFCM("tmp",$fb_token);
		redirect(base_url().'textmessages/send_text_message2');	exit;
		}
 	}
	
	
	
		   public function change_status() {
 		 $id = $this->input->post('id');
		 $status = $this->input->post('value');
		 if(strtolower($status)=='inactive'){
			 $status ='1';# Now it will be active
		 }else{
		 	$status ='0';# Now it will be inactive
		 }
		 //$user_id 	= $this->session->userdata('admin_user_id');		
		 echo $status= $this->Textmessage_model->change_status($id,$status);exit;
   		  
     }
	 
	 
	 function push_text_message_request(){
		//echo "test";
	 	$this->checklogin();		
		//$customer_id=$this->input->post('c_id');
		//$product_id	=$this->input->post('p_id');
		//$Chk = $this->input->post('Chk');
		//echo "kk";
		$customer_id 	= $this->session->userdata('admin_user_id');
		$text_message	=$this->input->post('text_message');
		$quantity	=$this->input->post('quantity');
		if($text_message==''){
		$this->load->view('send_text_message');
		} else {
		$this->Textmessage_model->save_push_text_message_request($customer_id,$text_message,$quantity);
		 
		//echo  $this->text_message_model->sendFCM("Advertisement pushed!",$fb_token);
		redirect(base_url().'textmessages/push_text_message_request');	exit;
		
		}
 	}
	
	 
	 public function approve_text_messages() {
		 //echo "aaaa";
		 /*
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from push_text_message where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Text Message Deleted Successfully!');
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
       // $total_records = $this->Textmessage_model->total_product_listing($srch_string);
        //$params["product_list"] = $this->Textmessage_model->product_listing($limit_per_page, $start_index, $srch_string);
		
		$total_records = $this->Textmessage_model->total_text_messages_request_listing($srch_string);
        $params["product_list"] = $this->Textmessage_model->text_messages_request_listing($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('textmessages/approve_text_messages', $total_records);
        $this->load->view('text_messages_listing', $params);
    }
	
	
		 function purchase_points(){
		//echo "test";
	 	$this->checklogin();		
		//$customer_id=$this->input->post('c_id');
		//$product_id	=$this->input->post('p_id');
		//$Chk = $this->input->post('Chk');
		//echo "kk";
		$customer_id 	= $this->session->userdata('admin_user_id');
		$text_comments	=$this->input->post('text_comments');
		$purchasing_points	=$this->input->post('purchasing_points');
		if($purchasing_points==''){
		$this->load->view('send_request_purchase_points');
		} else {
		$this->Textmessage_model->send_purchase_points_request($customer_id,$text_comments,$purchasing_points);
		 
		//echo  $this->text_message_model->sendFCM("Advertisement pushed!",$fb_token);
		redirect(base_url().'textmessages/purchase_points');	exit;
		
		}
 	}
	
	
	public function approve_purchase_points_requests() {
		 //echo "aaaa";
		 /*
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from push_text_message where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Text Message Deleted Successfully!');
            }
        }
		*/
        ##--------------- pagination start ----------------##
        // init params
		$user_id 	= $this->session->userdata('admin_user_id');
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
       // $total_records = $this->Textmessage_model->total_product_listing($srch_string);
        //$params["product_list"] = $this->Textmessage_model->product_listing($limit_per_page, $start_index, $srch_string);
		
		$total_records = $this->Textmessage_model->total_purchase_points_request_listing($srch_string);
        $params["product_list"] = $this->Textmessage_model->get_purchase_points_requests_listing($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('textmessages/approve_purchase_points_requests', $total_records);
		$params["total_approved_points"] = $this->Textmessage_model->total_approved_points($user_id);
		$params["waiting_approval_points"] = $this->Textmessage_model->waiting_approval_points($user_id);
		
        $this->load->view('purchase_points_request_listing', $params);
    }
	

	
	
	public function list_approved_purchases_by_customer() {
        $this->checklogin();
		$user_id 	= $this->session->userdata('admin_user_id');
		//if($user_id==1){ $id = 1; }
		
       $id = $this->uri->segment(3);
		//echo $id;
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
        $total_records = $this->Textmessage_model->total_approved_purchases_by_customer_listing($id,$srch_string);
        $params["list_approved_purchases_by_customer"] = $this->Textmessage_model->get_approved_purchases_by_customer_listing($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_approved_purchases_by_customer/' . $id, $total_records, null, 4);
		//echo $user_id;
        $this->load->view('list_approved_purchases_by_customer_tpl', $params);
    }	
	
	
function save_approve_purchase_points_requests(){
		//echo "test";
	 	$this->checklogin();		
		$customer_id=$this->input->post('c_id');
		$message_id	=$this->input->post('m_id');
		$Chk = $this->input->post('Chk');
		$text_message	=$this->input->post('text_comments');
		$this->load->view('purchase_points_request_listing');
			if($Chk==1){
			$send_status=1;
		}else{
			
			$send_status=0;
		}
		
		//$this->Textmessage_model->save_push_sent_text_message($customer_id,$text_message,$send_status);
	
		$this->Textmessage_model->update_push_text_message_request($message_id,$send_status);
		/*
		$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{
		 $consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Textmessage_model->sendFCM($text_message, $fb_token);
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "howzzt text message";
			$NTFdata['body'] = $text_message; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 1; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
		 
		 }
		//echo  $this->Advertisement_model->sendFCM("Advertisement pushed!",$fb_token);
		//exit;
		
		
		$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{
		 $consumer_id = $user->consumer_id;
		  $fb_token = getConsumerFb_TokenById(17);
		 $this->Textmessage_model->sendFCM($consumer_id, $fb_token);
		
		redirect(base_url().'textmessages/approve_text_messages');	exit;
		
		
		}
		*/
 	}
	
	 
}

