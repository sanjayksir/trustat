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
			$NTFdata['title'] = "TRUSTAT text message";
			$NTFdata['body'] = "A Text Message Posted!!.."; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 1; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
			
		 }
		//echo  $this->text_message_model->sendFCM("Advertisement pushed!",$fb_token);
		exit;
 	}
	
	function reverse_birthday( $years ){
			return date('Y-m-d', strtotime($years . ' years ago'));
							}
/*							
	function AllSelectedConsumersByACustomer2($customer_id, $csc_consumer_gender, $csc_consumer_city){
		$this->db->select('C.id');	
		$this->db->from('consumers C');		
		$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->where('CCL.customer_id', $customer_id);
		
		if(($csc_consumer_gender=='male')||($csc_consumer_gender=='female')) {
		$this->db->where('C.gender', $csc_consumer_gender);
			}
			
		if(!empty($csc_consumer_city)){ 			
		$this->db->where('C.city', $csc_consumer_city);
			}
			
		$query = $this->db->get();
		$result = $query->result();
		return $result;
}
*/

function AllSelectedConsumersByACustomer2($customer_id, $consumer_selection_criteria){
	   	
			
		$this->db->select('C.id');	
		$this->db->from('consumers C');		
		$this->db->join('consumer_customer_link CCL', 'CCL.consumer_id = C.id');
		$this->db->where('CCL.customer_id', $customer_id);
		
		
		
		$query = $this->db->query("SELECT * FROM consumer_selection_criteria WHERE unique_system_selection_criteria_id =  '$consumer_selection_criteria'");
		$row = $query->row();
		//$row->item_id
		
		//$this->db->where('CCL.customer_id', $customer_id);
		
		if($row->consumer_gender!='all') {
		$this->db->where('C.gender', $row->consumer_gender);
			}
		if($row->consumer_city!='all') {
		$this->db->where('C.city', $row->consumer_city);
			}
		
		$consumer_min_dob = date('Y-m-d', strtotime('-' . $row->consumer_min_age . ' years'));
		$consumer_max_dob = date('Y-m-d', strtotime('-' . $row->consumer_max_age . ' years'));
		
		if(!empty($row->consumer_max_age)){ 
		$this->db->where('C.dob >=', $consumer_max_dob);
		//$this->db->or_where('C.dob =', 'NULL');
			}
		if(!empty($row->consumer_min_age)){ 
		$this->db->where('C.dob <=', $consumer_min_dob);
		//$this->db->or_where('C.dob =', 'NULL');
			}
			
			/*
			$arr = explode(' ',trim($earned_loyalty_points_clubbed));
			$ELP_from = $arr[0];
			$ELP_to = $arr[2];			
			if($earned_loyalty_points_clubbed!='all') { 
			$this->db->where('C.total_accumulated_points BETWEEN "'. $ELP_from . '" and "'. $ELP_to .'"');
				}
			*/
			$arr1 = explode(' ',trim($row->monthly_earnings));
			$ME_from = $arr1[0];
			$ME_to = $arr1[2];			
			if($row->monthly_earnings!='all') { $this->db->where('C.monthly_earnings BETWEEN "'. $ME_from . '" and "'. $ME_to .'"');}	
						
			if($row->job_profile!='all') { $this->db->where('C.job_profile', $row->job_profile); }
			if($row->education_qualification!='all') { $this->db->where('C.education_qualification', $row->education_qualification); }
			if($row->type_vehicle!='all') { $this->db->where('C.type_vehicle', $row->type_vehicle); }
			if($row->profession!='all') { $this->db->where('C.profession', $row->profession); }
			if($row->marital_status!='all') { $this->db->where('C.marital_status', $row->marital_status); }
			if($row->no_of_family_members!='all') { $this->db->where('C.no_of_family_members', $row->no_of_family_members); }
			if($row->loan_car!='all') { $this->db->where('C.loan_car', $row->loan_car); }
			if($row->loan_housing!='all') { $this->db->where('C.loan_housing', $row->loan_housing); }
			if($row->personal_loan!='all') { $this->db->where('C.personal_loan', $row->personal_loan); }
			if($row->credit_card_loan!='all') { $this->db->where('C.credit_card_loan', $row->credit_card_loan); }
			if($row->own_a_car!='all') { $this->db->where('C.own_a_car', $row->own_a_car); }
			if($row->house_type!='all') { $this->db->where('C.house_type', $row->house_type); }
			if($row->last_location!='all') { $this->db->where('C.last_location', $row->last_location); }
			if($row->life_insurance!='all') { $this->db->where('C.life_insurance', $row->life_insurance); }
			if($row->medical_insurance!='all') { $this->db->where('C.medical_insurance', $row->medical_insurance); }
			if($row->height_in_inches!='all') { $this->db->where('C.height_in_inches', $row->height_in_inches); }
			if($row->weight_in_kg!='all') { $this->db->where('C.weight_in_kg', $row->weight_in_kg); }
			if($row->hobbies!='all') { $this->db->where('C.hobbies', $row->hobbies); }
			if($row->sports!='all') { $this->db->where('C.sports', $row->sports); }
			if($row->entertainment!='all') { $this->db->where('C.entertainment', $row->entertainment); }
			if($row->spouse_gender!='all') { $this->db->where('C.spouse_gender', $row->spouse_gender); }
			if($row->spouse_phone!='all') { $this->db->where('C.spouse_phone', $row->spouse_phone); }
			if($row->spouse_dob!='all') { $this->db->where('C.spouse_dob', $row->spouse_dob); }
			if($row->marriage_anniversary!='all') { $this->db->where('C.marriage_anniversary', $row->marriage_anniversary); }
			if($row->spouse_work_status!='all') { $this->db->where('C.spouse_work_status', $row->spouse_work_status); }
			if($row->spouse_edu_qualification!='all') { $this->db->where('C.spouse_edu_qualification', $row->spouse_edu_qualification); }
			if($row->spouse_monthly_income!='all') { $this->db->where('C.spouse_monthly_income', $row->spouse_monthly_income); }
			if($row->spouse_loan!='all') { $this->db->where('C.spouse_loan', $row->spouse_loan); }
			if($row->spouse_personal_loan!='all') { $this->db->where('C.spouse_personal_loan', $row->spouse_personal_loan); }
			if($row->spouse_credit_card_loan!='all') { $this->db->where('C.spouse_credit_card_loan', $row->spouse_credit_card_loan); }
			if($row->spouse_own_a_car!='all') { $this->db->where('C.spouse_own_a_car', $row->spouse_own_a_car); }
			if($row->spouse_house_type!='all') { $this->db->where('C.spouse_house_type', $row->spouse_house_type); }
			if($row->spouse_height_inches!='all') { $this->db->where('C.spouse_height_inches', $row->spouse_height_inches); }
			if($row->spouse_weight_kg!='all') { $this->db->where('C.spouse_weight_kg', $row->spouse_weight_kg); }
			if($row->spouse_hobbies!='all') { $this->db->where('C.spouse_hobbies', $row->spouse_hobbies); }
			if($row->spouse_sports!='all') { $this->db->where('C.spouse_sports', $row->spouse_sports); }
			if($row->spouse_entertainment!='all') { $this->db->where('C.spouse_entertainment', $row->spouse_entertainment); }
			if($row->field_1!='all') { $this->db->where('C.field_1', $row->field_1); }
			if($row->field_2!='all') { $this->db->where('C.field_2', $row->field_2); }
			if($row->field_3!='all') { $this->db->where('C.field_3', $row->field_3); }
			if($row->field_4!='all') { $this->db->where('C.field_4', $row->field_4); }
			if($row->field_5!='all') { $this->db->where('C.field_5', $row->field_5); }
			if($row->field_6!='all') { $this->db->where('C.field_6', $row->field_6); }
			if($row->field_7!='all') { $this->db->where('C.field_7', $row->field_7); }
			if($row->field_8!='all') { $this->db->where('C.field_8', $row->field_8); }
			if($row->field_9!='all') { $this->db->where('C.field_9', $row->field_9); }
			if($row->field_10!='all') { $this->db->where('C.field_10', $row->field_10); }
			if($row->field_11!='all') { $this->db->where('C.field_11', $row->field_11); }
			if($row->field_12!='all') { $this->db->where('C.field_12', $row->field_12); }
			if($row->field_13!='all') { $this->db->where('C.field_13', $row->field_13); }
			if($row->field_14!='all') { $this->db->where('C.field_14', $row->field_14); }
			if($row->field_15!='all') { $this->db->where('C.field_15', $row->field_15); }
			if($row->field_16!='all') { $this->db->where('C.field_16', $row->field_16); }
			if($row->field_17!='all') { $this->db->where('C.field_17', $row->field_17); }
			if($row->field_18!='all') { $this->db->where('C.field_18', $row->field_18); }
			if($row->field_19!='all') { $this->db->where('C.field_19', $row->field_19); }
			if($row->field_20!='all') { $this->db->where('C.field_20', $row->field_20); }
			if($row->field_21!='all') { $this->db->where('C.field_21', $row->field_21); }
			if($row->field_22!='all') { $this->db->where('C.field_22', $row->field_22); }
			if($row->field_23!='all') { $this->db->where('C.field_23', $row->field_23); }
			if($row->field_24!='all') { $this->db->where('C.field_24', $row->field_24); }
			if($row->field_25!='all') { $this->db->where('C.field_25', $row->field_25); }
			if($row->field_26!='all') { $this->db->where('C.field_26', $row->field_26); }
			if($row->field_27!='all') { $this->db->where('C.field_27', $row->field_27); }
			if($row->field_28!='all') { $this->db->where('C.field_28', $row->field_28); }
			if($row->field_29!='all') { $this->db->where('C.field_29', $row->field_29); }
			if($row->field_30!='all') { $this->db->where('C.field_30', $row->field_30); }
			if($row->field_31!='all') { $this->db->where('C.field_31', $row->field_31); }
			if($row->field_32!='all') { $this->db->where('C.field_32', $row->field_32); }
			if($row->field_33!='all') { $this->db->where('C.field_33', $row->field_33); }
			if($row->field_34!='all') { $this->db->where('C.field_34', $row->field_34); }
			if($row->field_35!='all') { $this->db->where('C.field_35', $row->field_35); }
			if($row->field_36!='all') { $this->db->where('C.field_36', $row->field_36); }
			if($row->field_37!='all') { $this->db->where('C.field_37', $row->field_37); }
			if($row->field_38!='all') { $this->db->where('C.field_38', $row->field_38); }
			if($row->field_39!='all') { $this->db->where('C.field_39', $row->field_39); }
			if($row->field_40!='all') { $this->db->where('C.field_40', $row->field_40); }
			if($row->field_41!='all') { $this->db->where('C.field_41', $row->field_41); }
			if($row->field_42!='all') { $this->db->where('C.field_42', $row->field_42); }
			if($row->field_43!='all') { $this->db->where('C.field_43', $row->field_43); }
			if($row->field_44!='all') { $this->db->where('C.field_44', $row->field_44); }
			if($row->field_45!='all') { $this->db->where('C.field_45', $row->field_45); }
			if($row->field_46!='all') { $this->db->where('C.field_46', $row->field_46); }
			if($row->field_47!='all') { $this->db->where('C.field_47', $row->field_47); }
			if($row->field_48!='all') { $this->db->where('C.field_48', $row->field_48); }
			if($row->field_49!='all') { $this->db->where('C.field_49', $row->field_49); }
			if($row->field_50!='all') { $this->db->where('C.field_50', $row->field_50); }
			if($row->field_51!='all') { $this->db->where('C.field_51', $row->field_51); }
			if($row->field_52!='all') { $this->db->where('C.field_52', $row->field_52); }
			if($row->field_53!='all') { $this->db->where('C.field_53', $row->field_53); }
			if($row->field_54!='all') { $this->db->where('C.field_54', $row->field_54); }
			if($row->field_55!='all') { $this->db->where('C.field_55', $row->field_55); }
			if($row->field_56!='all') { $this->db->where('C.field_56', $row->field_56); }
			if($row->field_57!='all') { $this->db->where('C.field_57', $row->field_57); }
			if($row->field_58!='all') { $this->db->where('C.field_58', $row->field_58); }
			if($row->field_59!='all') { $this->db->where('C.field_59', $row->field_59); }
			if($row->field_60!='all') { $this->db->where('C.field_60', $row->field_60); }
			if($row->field_61!='all') { $this->db->where('C.field_61', $row->field_61); }
			if($row->field_62!='all') { $this->db->where('C.field_62', $row->field_62); }
			if($row->field_63!='all') { $this->db->where('C.field_63', $row->field_63); }
			if($row->field_64!='all') { $this->db->where('C.field_64', $row->field_64); }
			if($row->field_65!='all') { $this->db->where('C.field_65', $row->field_65); }
			if($row->field_66!='all') { $this->db->where('C.field_66', $row->field_66); }
			if($row->field_67!='all') { $this->db->where('C.field_67', $row->field_67); }
			if($row->field_68!='all') { $this->db->where('C.field_68', $row->field_68); }
			if($row->field_69!='all') { $this->db->where('C.field_69', $row->field_69); }
			if($row->field_70!='all') { $this->db->where('C.field_70', $row->field_70); }
			if($row->field_71!='all') { $this->db->where('C.field_71', $row->field_71); }
			if($row->field_72!='all') { $this->db->where('C.field_72', $row->field_72); }
			if($row->field_73!='all') { $this->db->where('C.field_73', $row->field_73); }
			if($row->field_74!='all') { $this->db->where('C.field_74', $row->field_74); }
			if($row->field_75!='all') { $this->db->where('C.field_75', $row->field_75); }
			if($row->field_76!='all') { $this->db->where('C.field_76', $row->field_76); }
			if($row->field_77!='all') { $this->db->where('C.field_77', $row->field_77); }
			if($row->field_78!='all') { $this->db->where('C.field_78', $row->field_78); }
			if($row->field_79!='all') { $this->db->where('C.field_79', $row->field_79); }
			if($row->field_80!='all') { $this->db->where('C.field_80', $row->field_80); }
			if($row->field_81!='all') { $this->db->where('C.field_81', $row->field_81); }
			if($row->field_82!='all') { $this->db->where('C.field_82', $row->field_82); }
			if($row->field_83!='all') { $this->db->where('C.field_83', $row->field_83); }
			if($row->field_84!='all') { $this->db->where('C.field_84', $row->field_84); }
			if($row->field_85!='all') { $this->db->where('C.field_85', $row->field_85); }
			if($row->field_86!='all') { $this->db->where('C.field_86', $row->field_86); }
			if($row->field_87!='all') { $this->db->where('C.field_87', $row->field_87); }
			if($row->field_88!='all') { $this->db->where('C.field_88', $row->field_88); }
			if($row->field_89!='all') { $this->db->where('C.field_89', $row->field_89); }
			if($row->field_90!='all') { $this->db->where('C.field_90', $row->field_90); }
			if($row->field_91!='all') { $this->db->where('C.field_91', $row->field_91); }
			if($row->field_92!='all') { $this->db->where('C.field_92', $row->field_92); }
			if($row->field_93!='all') { $this->db->where('C.field_93', $row->field_93); }
			if($row->field_94!='all') { $this->db->where('C.field_94', $row->field_94); }
			if($row->field_95!='all') { $this->db->where('C.field_95', $row->field_95); }
			if($row->field_96!='all') { $this->db->where('C.field_96', $row->field_96); }
			if($row->field_97!='all') { $this->db->where('C.field_97', $row->field_97); }
			if($row->field_98!='all') { $this->db->where('C.field_98', $row->field_98); }
			if($row->field_99!='all') { $this->db->where('C.field_99', $row->field_99); }
			if($row->field_100!='all') { $this->db->where('C.field_100', $row->field_100); }
			if($row->field_101!='all') { $this->db->where('C.field_101', $row->field_101); }
			if($row->field_102!='all') { $this->db->where('C.field_102', $row->field_102); }
			if($row->field_103!='all') { $this->db->where('C.field_103', $row->field_103); }
			if($row->field_104!='all') { $this->db->where('C.field_104', $row->field_104); }
			if($row->field_105!='all') { $this->db->where('C.field_105', $row->field_105); }
			if($row->field_106!='all') { $this->db->where('C.field_106', $row->field_106); }
			if($row->field_107!='all') { $this->db->where('C.field_107', $row->field_107); }
			if($row->field_108!='all') { $this->db->where('C.field_108', $row->field_108); }
			if($row->field_109!='all') { $this->db->where('C.field_109', $row->field_109); }
			if($row->field_110!='all') { $this->db->where('C.field_110', $row->field_110); }
			if($row->field_111!='all') { $this->db->where('C.field_111', $row->field_111); }
			if($row->field_112!='all') { $this->db->where('C.field_112', $row->field_112); }
			if($row->field_113!='all') { $this->db->where('C.field_113', $row->field_113); }
			if($row->field_114!='all') { $this->db->where('C.field_114', $row->field_114); }
			if($row->field_115!='all') { $this->db->where('C.field_115', $row->field_115); }
			if($row->field_116!='all') { $this->db->where('C.field_116', $row->field_116); }
			if($row->field_117!='all') { $this->db->where('C.field_117', $row->field_117); }
			if($row->field_118!='all') { $this->db->where('C.field_118', $row->field_118); }
			if($row->field_119!='all') { $this->db->where('C.field_119', $row->field_119); }
			if($row->field_120!='all') { $this->db->where('C.field_120', $row->field_120); }
			if($row->field_121!='all') { $this->db->where('C.field_121', $row->field_121); }
			if($row->field_122!='all') { $this->db->where('C.field_122', $row->field_122); }
			if($row->field_123!='all') { $this->db->where('C.field_123', $row->field_123); }
			if($row->field_124!='all') { $this->db->where('C.field_124', $row->field_124); }
			if($row->field_125!='all') { $this->db->where('C.field_125', $row->field_125); }
			if($row->field_126!='all') { $this->db->where('C.field_126', $row->field_126); }
			if($row->field_127!='all') { $this->db->where('C.field_127', $row->field_127); }
			if($row->field_128!='all') { $this->db->where('C.field_128', $row->field_128); }
			if($row->field_129!='all') { $this->db->where('C.field_129', $row->field_129); }
			if($row->field_130!='all') { $this->db->where('C.field_130', $row->field_130); }
			if($row->field_131!='all') { $this->db->where('C.field_131', $row->field_131); }
			if($row->field_132!='all') { $this->db->where('C.field_132', $row->field_132); }
			if($row->field_133!='all') { $this->db->where('C.field_133', $row->field_133); }
			if($row->field_134!='all') { $this->db->where('C.field_134', $row->field_134); }
			if($row->field_135!='all') { $this->db->where('C.field_135', $row->field_135); }
			if($row->field_136!='all') { $this->db->where('C.field_136', $row->field_136); }
			if($row->field_137!='all') { $this->db->where('C.field_137', $row->field_137); }
			if($row->field_138!='all') { $this->db->where('C.field_138', $row->field_138); }
			if($row->field_139!='all') { $this->db->where('C.field_139', $row->field_139); }
			if($row->field_140!='all') { $this->db->where('C.field_140', $row->field_140); }
			if($row->field_141!='all') { $this->db->where('C.field_141', $row->field_141); }
			if($row->field_142!='all') { $this->db->where('C.field_142', $row->field_142); }
			if($row->field_143!='all') { $this->db->where('C.field_143', $row->field_143); }
			if($row->field_144!='all') { $this->db->where('C.field_144', $row->field_144); }
			if($row->field_145!='all') { $this->db->where('C.field_145', $row->field_145); }
			if($row->field_146!='all') { $this->db->where('C.field_146', $row->field_146); }
			if($row->field_147!='all') { $this->db->where('C.field_147', $row->field_147); }
			if($row->field_148!='all') { $this->db->where('C.field_148', $row->field_148); }
			if($row->field_149!='all') { $this->db->where('C.field_149', $row->field_149); }
			if($row->field_150!='all') { $this->db->where('C.field_150', $row->field_150); }
			if($row->field_151!='all') { $this->db->where('C.field_151', $row->field_151); }
			if($row->field_152!='all') { $this->db->where('C.field_152', $row->field_152); }
			if($row->field_153!='all') { $this->db->where('C.field_153', $row->field_153); }
			if($row->field_154!='all') { $this->db->where('C.field_154', $row->field_154); }
			if($row->field_155!='all') { $this->db->where('C.field_155', $row->field_155); }
			if($row->field_156!='all') { $this->db->where('C.field_156', $row->field_156); }
			if($row->field_157!='all') { $this->db->where('C.field_157', $row->field_157); }
			if($row->field_158!='all') { $this->db->where('C.field_158', $row->field_158); }
			if($row->field_159!='all') { $this->db->where('C.field_159', $row->field_159); }
			if($row->field_160!='all') { $this->db->where('C.field_160', $row->field_160); }
			if($row->field_161!='all') { $this->db->where('C.field_161', $row->field_161); }
			if($row->field_162!='all') { $this->db->where('C.field_162', $row->field_162); }
			if($row->field_163!='all') { $this->db->where('C.field_163', $row->field_163); }
			if($row->field_164!='all') { $this->db->where('C.field_164', $row->field_164); }
			if($row->field_165!='all') { $this->db->where('C.field_165', $row->field_165); }
			if($row->field_166!='all') { $this->db->where('C.field_166', $row->field_166); }
			if($row->field_167!='all') { $this->db->where('C.field_167', $row->field_167); }
			if($row->field_168!='all') { $this->db->where('C.field_168', $row->field_168); }
			if($row->field_169!='all') { $this->db->where('C.field_169', $row->field_169); }
			if($row->field_170!='all') { $this->db->where('C.field_170', $row->field_170); }
			if($row->field_171!='all') { $this->db->where('C.field_171', $row->field_171); }
			if($row->field_172!='all') { $this->db->where('C.field_172', $row->field_172); }
			if($row->field_173!='all') { $this->db->where('C.field_173', $row->field_173); }
			if($row->field_174!='all') { $this->db->where('C.field_174', $row->field_174); }
			if($row->field_175!='all') { $this->db->where('C.field_175', $row->field_175); }
			if($row->field_176!='all') { $this->db->where('C.field_176', $row->field_176); }
			if($row->field_177!='all') { $this->db->where('C.field_177', $row->field_177); }
			if($row->field_178!='all') { $this->db->where('C.field_178', $row->field_178); }
			if($row->field_179!='all') { $this->db->where('C.field_179', $row->field_179); }
			if($row->field_180!='all') { $this->db->where('C.field_180', $row->field_180); }
			if($row->field_181!='all') { $this->db->where('C.field_181', $row->field_181); }
			if($row->field_182!='all') { $this->db->where('C.field_182', $row->field_182); }
			if($row->field_183!='all') { $this->db->where('C.field_183', $row->field_183); }
			if($row->field_184!='all') { $this->db->where('C.field_184', $row->field_184); }
			if($row->field_185!='all') { $this->db->where('C.field_185', $row->field_185); }
			if($row->field_186!='all') { $this->db->where('C.field_186', $row->field_186); }
			if($row->field_187!='all') { $this->db->where('C.field_187', $row->field_187); }
			if($row->field_188!='all') { $this->db->where('C.field_188', $row->field_188); }
			if($row->field_189!='all') { $this->db->where('C.field_189', $row->field_189); }
			if($row->field_190!='all') { $this->db->where('C.field_190', $row->field_190); }
			if($row->field_191!='all') { $this->db->where('C.field_191', $row->field_191); }
			if($row->field_192!='all') { $this->db->where('C.field_192', $row->field_192); }
			if($row->field_193!='all') { $this->db->where('C.field_193', $row->field_193); }
			if($row->field_194!='all') { $this->db->where('C.field_194', $row->field_194); }
			if($row->field_195!='all') { $this->db->where('C.field_195', $row->field_195); }
			if($row->field_196!='all') { $this->db->where('C.field_196', $row->field_196); }
			if($row->field_197!='all') { $this->db->where('C.field_197', $row->field_197); }
			if($row->field_198!='all') { $this->db->where('C.field_198', $row->field_198); }
			if($row->field_199!='all') { $this->db->where('C.field_199', $row->field_199); }
			if($row->field_200!='all') { $this->db->where('C.field_200', $row->field_200); }
			if($row->field_201!='all') { $this->db->where('C.field_201', $row->field_201); }
			

		$query = $this->db->get();
		$result = $query->result();
		return $result;
}

	function send_text_message(){
		//echo "test";
	 	$this->checklogin();		
		$customer_id = $this->input->post('c_id');
		$message_id	= $this->input->post('m_id');
		$Chk = $this->input->post('Chk');
		$text_message	= $this->input->post('text_message');
		$consumer_selection_criteria = $this->input->post('unique_system_selection_criteria_id');
		$this->load->view('text_messages_listing');
			if($Chk==1){
			$send_status=1;
		}else{
			
			$send_status=0;
		}
		if($consumer_selection_criteria=="All") {		
		
		$this->Textmessage_model->save_push_sent_text_message($customer_id,$text_message,$send_status,$consumer_selection_criteria);
		$this->Textmessage_model->update_push_text_message_request($message_id,$send_status);

		$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
		
				
				foreach ($query->result() as $user)  
				{
		 $consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Textmessage_model->sendFCM($text_message, $fb_token);	
		 
		 	$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "TRUSTAT text message";
			$NTFdata['body'] = $text_message; 
			$NTFdata['timestamp'] = date("Y-m-d H:i:s",time()); 
			$NTFdata['status'] = 1; 
			
			$this->db->insert('list_notifications_table', $NTFdata);
		 }	
			
		
		exit;
		
		}else{
		$this->Textmessage_model->save_push_sent_text_message($customer_id,$text_message,$send_status,$consumer_selection_criteria);
	
		$this->Textmessage_model->update_push_text_message_request($message_id, $send_status);
		
		/*
		$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{
				$consumer_id = $user->consumer_id;
		 
		 */
			

		
									
								
		$AllSelectedConsumersByACustomer = $this->AllSelectedConsumersByACustomer2($customer_id, $consumer_selection_criteria);
		
				
				foreach ($AllSelectedConsumersByACustomer as $consumer_idArray) 
				{
					$consumer_id = $consumer_idArray->id;
		
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Textmessage_model->sendFCM($text_message, $fb_token);
		 
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "TRUSTAT text message";
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
			$NTFdata['title'] = "TRUSTAT text message";
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
		
				$arr = explode('-',trim($quantity));
				$qty = $arr[0];
				$unique_system_selection_criteria_id = $arr[1];
				
		if($text_message==''){
			
			$customer_id = $this->session->userdata('admin_user_id');
		
			$this->db->select('*');
			$this->db->from('consumer_selection_criteria');
			$this->db->where('customer_id', $customer_id);
			//$this->db->where(array('customer_id' => $customer_id, 'promotion_type' => "Communication-Text"));
			$query=$this->db->get();
		
			
		$this->load->view('send_text_message', $params);
		} else {
		$this->Textmessage_model->save_push_text_message_request($customer_id,$text_message,$qty,$unique_system_selection_criteria_id);
		 
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
	
		$this->Textmessage_model->update_purchased_purchased_loyalty_points($message_id,$send_status);
		/*
		$query = $this->db->query("SELECT * FROM consumer_customer_link where customer_id='".$customer_id."';");
				
				foreach ($query->result() as $user)  
				{
		 $consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Textmessage_model->sendFCM($text_message, $fb_token);
			$NTFdata['consumer_id'] = $consumer_id; 
			$NTFdata['title'] = "TRUSTAT text message";
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

