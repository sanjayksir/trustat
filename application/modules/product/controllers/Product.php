<?php
 class Product extends MX_Controller {
     function __construct() {
         parent::__construct();
         $this->load->model('Product_model');
		 $this->load->helper('common_functions_helper');
		 $this->load->library('pagination');
		 //$this->load->model('api/Productmodel');
     }

     function set_attributes() {
		 $this->checklogin();

		 if($this->input->post('hidden_field')=='1'){
		 	//echo '<pre>';print_r($this->input->post());exit;
			 $this->Product_model->saveAttributeList($this->input->post());
		 }
         $data['get_attr'] = $this->Product_model->getAttributeList();
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
	 	$data['listData']=$this->Product_model->getOptionList($id);
	 	if($this->input->post('submit')){
			 $this->Product_model->update_attribute_val($this->input->post());
		}
         // check if the unitofarea exists before trying to edit it
       //  $data['unitofarea'] = $this->Product_model->getOptionList($id);
         $this->load->view('attribute_add', $data);
     }







 	function add_product(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();

		$data['product_attr'] = $this->Product_model->get_all_attrs();
		$this->load->view('add_product_tpl', $data);

	}


	function update_product(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();

		//$data['product_attr'] = $this->Product_model->get_all_attrs();
		$data['product_data'] = $this->Product_model->fetch_product_detail($this->uri->segment(3));
		$this->load->view('edit_product_tpl', $data);

	}

	function add_product_attributes(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();
		//$data['product_attr'] = $this->Product_model->get_all_attrs();
		$data['product_data'] = $this->Product_model->fetch_product_detail($this->uri->segment(3));
		$this->load->view('add_product_attributes_tpl', $data);
		}
	
	function manage_packaging(){
		$user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
		$data = array();
		//$data['product_attr'] = $this->Product_model->get_all_attrs();
		$data['product_data'] = $this->Product_model->fetch_product_pack_level_detail($this->uri->segment(3));
		$this->load->view('manage_packaging_tpl', $data);
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
 	$this->db->select('product_id, name');
 	$this->db->from('attribute_name');
 	$this->db->where('parent',$id);
  	$query = $this->db->get();  //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) {
			$res = $query->result_array();

			foreach($res as $val){
				$result .= '<option value="'.$val['product_id'].'">'.$val['name'].'</option>';
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


  function checkProductExists($id=''){
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
	   $name = $this->input->post('product_name');


 	  echo $this->Product_model->IsExistsProduct($name,$id='');exit;
  }

  function save_product($id='') {
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
  		$res = $this->Product_model->save_product($id);
		if($res=='1'){
			echo '1';
		}else{
			echo '0';
		}
		exit;
    }

	
	  function save_product_attributes($id='') {
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
  		$res = $this->Product_model->save_product_attributes($id);
		if($res=='1'){
			echo '1';
		}else{
			echo '0';
		}
		exit;
    }
	
	function save_product_pack_level() {
  $user_id 	= $this->session->userdata('admin_user_id');
		if(empty($user_id)){
 			redirect(base_url().'login');	exit;
 		}
  		$res = $this->Product_model->save_product_pack_level();
		if($res=='1'){
			echo '1';
		}else{
			echo '0';
		}
		exit;
    }
	

 function genate_sku(){
		//$name = $this->input->post('name');
		$string = $this->input->post('name');
		function initials($str) {
				$ret = '';
				foreach (explode(' ', $str) as $word)
					$ret .= strtoupper($word[0]);
				return $ret;
			}
		//echo initials($string);

		$name = initials($string);
		$pin = mt_rand(1000, 9999);
 		echo $res =  slugify2($name).'-'.$pin;
		exit;
   }

   public function list_product() {
        $this->checklogin();
        if (!empty($this->input->post('del_submit'))) {
            if ($this->db->query("delete from products where id='" . $this->input->post('del_submit') . "'")) {
                $this->session->set_flashdata('success', 'Product Deleted Successfully!');
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
        $total_records = $this->Product_model->total_product_listing($srch_string);
        $params["product_list"] = $this->Product_model->product_listing($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_product', $total_records);
        $this->load->view('product_list', $params);
    }
// list assigned products to Plant controller

function list_assigned_products() {
		 $this->checklogin();
		 if(!empty($this->input->post('del_submit'))){
		 	if($this->db->query("delete from products where id='".$this->input->post('del_submit')."'")){
				$this->session->set_flashdata('success', 'Product Deleted Successfully!');
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
        $total_records = $this->Product_model->total_product_listing($srch_string);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->assigned_product_listing($limit_per_page, $start_index,$srch_string);

            $config['base_url'] = base_url() . 'product/list_assigned_products';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('list_assigned_products', $params);
     }



	 function getChildsDD(){
	 	$id 	= $this->input->post('id');
		$parent =  explode(',',$this->input->post('child'));
	 	if($id!=''){
			$data = json_decode(getAllProductName($id),true);//print_r($data);exit;
			$options = "";
			$dd =  '<select class="form-control" name="product_attr[]" size="20" style="height: 100%;" multiple="multiple" required>';
			foreach($data as $rec){
				$selected = '';
				if(in_array($rec['product_id'],$parent)){
					$selected = 'selected="selected"';
				}
				$dd .= '<option '.$selected.'value="'.$rec['product_id'].'">'.$rec['name'].'</option>';
			}
 			$dd .=  '</select>';
			echo $dd;exit;
	 	}
	 }

	 function delete_attribute($id){//echo '**'.$id;exit;
	 	$data = $this->Product_model->delete_attr($id);
	 }

	 function add_description(){
		$this->load->view('product_media_add');
	}


	 function media_uploader(){
 		 //echo '<pre>';print_r($res);exit;
		//echo '<pre>';print_r($_FILES);exit;
		if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$res = $this->upload_File('upload_file', array('jpg','JPEG','png'), 'uploads/product_media' ,'500','500','2000');
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
			  $file_path='./uploads/product_media/thumb/'.$file['file_name'];
			  break;
			case'222x190':
			  $w=222;
			  //$h=190;
			  $file_path='./uploads/product_media/thumb/'.$file['file_name'];
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
   		 $this->load->view('feedback', $data);
	}

	function add_image_feedback(){
		 $data					= array();
   		 $this->load->view('image_feedback', $data);
	}
	
	function edit_feedback(){
		 $data					= array();
		 $data['product_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('feedback', $data);
	}
	
	function edit_image_feedback(){
		 $data					= array();
		 $data['product_image_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('image_feedback', $data);
	}
	
	function edit_video_feedback(){
		 $data					= array();
		 $data['product_video_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('video_feedback', $data);
	}
	
	function edit_audio_feedback(){
		 $data					= array();
		 $data['product_audio_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('audio_feedback', $data);
	}
	
	function edit_pdf_feedback(){
		 $data					= array();
		 $data['product_pdf_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('pdf_feedback', $data);
	}
	function edit_pushed_ad_feedback(){
		 $data					= array();
		 $data['product_pushed_ad_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('pushed_ad_feedback', $data);
	}
	function edit_survey_feedback(){
		 $data					= array();
		 $data['product_survey_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('survey_feedback', $data);
	}
	
	function edit_demo_audio_feedback(){
		 $data					= array();
		 $data['edit_demo_audio_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('demo_audio_feedback', $data);
	}
	
	function edit_demo_video_feedback(){
		 $data					= array();
		 $data['edit_demo_video_feedback_data'] = $this->Product_model->fetch_feedback_question_detail($this->uri->segment(4));
   		 $this->load->view('demo_video_feedback', $data);
	}
   /*
	function delete_attribute($id){//echo '**'.$id;exit;
	 	$data = $this->Product_model->delete_attr($id);
	 }
	 */
	 
	 function delete_feedback_question($question_id){//echo '**'.$id;exit;
	 	$data = $this->Product_model->delete_feedback_question($question_id);
	 }
	
	
	
	
	function add_video_feedback(){
		 $data					= array();
   		 $this->load->view('video_feedback', $data);
	}

	function add_audio_feedback(){
		 $data					= array();
   		 $this->load->view('audio_feedback', $data);
	}

	function add_pdf_feedback(){
		 $data					= array();
   		 $this->load->view('pdf_feedback', $data);
	}

	function add_pushed_ad_feedback(){
		 $data					= array();
   		 $this->load->view('pushed_ad_feedback', $data);
	}

	function add_survey_feedback(){
		 $data					= array();
   		 $this->load->view('survey_feedback', $data);
	}
	
	function add_demo_video_feedback(){
		 $data					= array();
   		 $this->load->view('demo_video_feedback', $data);
	}
	
	function add_demo_audio_feedback(){
		 $data					= array();
   		 $this->load->view('demo_audio_feedback', $data);
	}

	function save_feedback(){
		$data					= array();
		$data = $this->input->post();
		//print_r($data);exit;
		echo $data = $this->Product_model->save_feedback($data);exit;
	}

	// Product Description Feedback Questions
 function ask_feedback($id=''){
		if(empty($id)){
			redirect('product/ask_feedback');
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
        $total_records = $this->Product_model->total_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_feedback';
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
			$params["product_id"] = $id;
        }
		##--------------- pagination End ----------------##

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_feedback_tpl', $params);

	}

	// Product Image Feedback Questions
	function ask_image_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
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
        $total_records = $this->Product_model->total_image_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->image_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_image_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_image_feedback_tpl', $params);

	}
	// Product Video Feedback Questions
	function ask_video_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
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
        $total_records = $this->Product_model->total_video_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->video_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_video_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_video_feedback_tpl', $params);

	}
	// Product Audio Feedback Questions
	function ask_audio_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
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
        $total_records = $this->Product_model->total_audio_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->audio_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_audio_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_audio_feedback_tpl', $params);

	}
	// Product PDF Feedback Questions
	function ask_pdf_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
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
        $total_records = $this->Product_model->total_pdf_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->pdf_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_pdf_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_pdf_feedback_tpl', $params);

	}

	// Product Push Ad Feedback Questions
	function ask_pushed_ad_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
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
        $total_records = $this->Product_model->total_pushed_ad_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->pushed_ad_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_pushed_ad_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_pushed_ad_feedback_tpl', $params);

	}

	// Product Survey Feedback Questions
	function ask_survey_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
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
        $total_records = $this->Product_model->total_survey_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->survey_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_survey_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_survey_feedback_tpl', $params);

	}
	
	// Product Demo Audio Feedback Questions
	function ask_demo_audio_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
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
        $total_records = $this->Product_model->total_demo_audio_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->demo_audio_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_demo_audio_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_demo_audio_feedback_tpl', $params);

	}
	
	// Product Demo Video Feedback Questions
	function ask_demo_video_feedback($id=''){
		if(empty($id)){
			redirect('product/list_product');
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
        $total_records = $this->Product_model->total_demo_video_feedback_listing($srch_string, $id);

		if ($total_records > 0)
        {
            // get current page records
            $params["product_list"] = $this->Product_model->demo_video_feedback_listing($limit_per_page, $start_index,$srch_string, $id);

            $config['base_url'] = base_url() . 'product/ask_demo_video_feedback';
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

       //  $data['product_list'] = $this->Product_model->product_listing();
 		$this->load->view('ask_demo_video_feedback_tpl', $params);

	}

	function save_product_question(){
	 	$this->checklogin();
		$product_id	=$this->input->post('p_id');
		$question_id=$this->input->post('q_id');
		$Chk = $this->input->post('Chk');
		echo $this->Product_model->save_product_question($product_id,$question_id,$Chk);exit;
 	}
	


	public function list_registered_products_by_consumers() {
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
        
        if(empty($srch_string)){
                $srch_string ='';
        }
        $total_records = $this->Product_model->count_registered_products_by_consumers($srch_string);
		$params["ScanedCodeListing"] = $this->Product_model->list_registered_products_by_consumers($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('product/list_registered_products_by_consumers', $total_records);
        
        ##--------------- pagination End ----------------##
        // $data					= array();
        // $user_id 	= $this->session->userdata('admin_user_id');		
        // $params["ScanedCodeListing"] = $this->Product_model->list_registered_products_by_consumers($limit_per_page, $start_index,$srch_string);
         $this->load->view('list_registered_products_by_consumers_tpl', $params);
     }

	 
	 
		public function verity_registered_products_by_consumers() {
		
		$data = array();
        $id = $this->uri->segment(3);
		

        $data['get_registered_products_by_consumers_details'] = $this->Product_model->get_registered_products_by_consumers_details($id);
        $this->load->view('verity_registered_products_by_consumers_tpl', $data);
    }
	 
	 public function update_registered_products_by_consumers() {
        $data					= array();
		$data = $this->input->post();
		$consumer_id = $data['consumer_id'];
		$consumer_name = getConsumerNameById($consumer_id);
		$ProductID = $data['product_id'];
		$customer_id = get_customer_id_by_product_id($ProductID);
		$bar_code = $data['bar_code'];
		$product_brand_name = $data['product_brand_name'];
		$product_name = $data['product_name'];
		$status = $data['status'];
		if($status==1) {
			
			//$transactionType = "successful-verification-of-invoice-uploaded-for-product-registration";
			$transactionType = "product_registration_lps";
			$transactionTypeName = "Successful verification of invoice uploaded for product registration ";
				$this->Product_model->saveProductLoylty($transactionType, $ProductID, $consumer_id, ['transaction_date' => date("Y-m-d H:i:s"),'consumer_id' => $consumer_id,'product_id' => $ProductID], $customer_id);
				$this->Product_model->saveConsumerPassbookLoyalty($transactionType, $transactionTypeName, $ProductID, $consumer_id, ['verification_date' => date("Y-m-d H:i:s"), 'brand_name' => $product_brand_name, 'product_name' => $product_name, 'product_id' => $ProductID, 'product_code' => $bar_code], $customer_id, 'Loyalty');
				
			//$vquery = "Congratulations! Your invoice validation is successful. Warranty, if applicable shall be now effective. Please check the details in 'my purchase list' in howzzt App.";	
			
			$vquery = "Congratulations! Your invoice validation is successful. Warranty, if applicable shall be now effective. Please check the details in 'my purchase list' in howzzt App";
		
		
		} else{
			$vquery = $data['vquery'];
			$data = $this->Product_model->set_product_code_unregistered($data);
		}
		
		//print_r($data);exit;
		echo $data = $this->Product_model->update_registered_products_by_consumers($data);
		
		//$consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Product_model->sendFVPNotification($vquery, $fb_token);
		
		exit;
		
    }
	
	public function update_loyalty_redemption_requests() {
        $data					= array();
		$data = $this->input->post();
		$consumer_id = $data['user_id'];
		$points_redeemed = $data['points_redeemed'];
		$coupon_vendor = $data['coupon_vendor'];
		$coupon_number = $data['coupon_number'];
		$points_redeemed = $data['points_redeemed'];
		$consumer_address = $data['consumer_address'];
		$courier_number = $data['courier_details'];
		
		$l_status = $data['l_status'];
		if($l_status==1) {
			
		//$this->Product_model->saveLoylty($transactionType, $userId, ['user_id' => $userId]);
		$transactionType = $points_redeemed . "Loyalty Points Redeemed";
		$this->Product_model->saveConsumerPassbookLoyalty1($transactionType, $consumer_id, ['transaction_date' => date("Y-m-d H:i:s"),'points_redeemed' => $points_redeemed,'coupon_number' => $coupon_number], 'Redemption', $points_redeemed);
		
				
		// this message for app$vquery = "Congratulations! Your Loyalty Points redumption request is processed successfully, we will update you for further information.";	
		$vquery = $coupon_vendor . " Voucher for Rs." . $points_redeemed . "has been sent to your address" .$consumer_address. "vide courier number". $courier_number;  
		} else{
			$vquery = "Your Loyalty Points redumption request is still pending...";	
		}
		
		//print_r($data);exit;
		echo $data = $this->Product_model->update_loyalty_redemption_requests($data);
		
		//$consumer_id = $user->consumer_id;
		 $fb_token = getConsumerFb_TokenById($consumer_id);
		 
		 $this->Product_model->sendFBLRNotification($vquery, $fb_token);
		
		exit;
		
    }
	
	
	
	public function list_loyalty_redemption_requests() {
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
        
        if(empty($srch_string)){
                $srch_string ='';
        }
        $total_records = $this->Product_model->count_loyalty_redemption_requests($srch_string);
		$params["ScanedCodeListing"] = $this->Product_model->list_loyalty_redemption_requests($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('product/list_loyalty_redemption_requests', $total_records);
        
        ##--------------- pagination End ----------------##
         $data					= array();
         $user_id 	= $this->session->userdata('admin_user_id');		
         $params["ScanedCodeListing"] = $this->Product_model->list_loyalty_redemption_requests($limit_per_page, $start_index,$srch_string);
         $this->load->view('list_loyalty_redemption_requests_tpl', $params);
     }

		public function details_loyalty_redemption_requests() {
		
		$data = array();
        $id = $this->uri->segment(3);
		//echo $id;

        $data['get_loyalty_redemption_requests_details'] = $this->Product_model->details_loyalty_redemption_requests($id);
        $this->load->view('details_loyalty_redemption_requests_tpl', $data);
    }
	 
	 public function details_view_loyalty_redemption_request() {
		
		$data = array();
        $id = $this->uri->segment(3);
		//echo $id;

        $data['get_loyalty_redemption_requests_details'] = $this->Product_model->details_loyalty_redemption_requests($id);
        $this->load->view('details_view_loyalty_redemption_request_tpl', $data);
    }
	
	
	
	public function list_view_consumer_passbook() {
        $this->checklogin();
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
        $total_records = $this->Product_model->count_total_list_view_consumer_passbook($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->Product_model->list_view_consumer_passbook($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_view_consumer_passbook/' . $id, $total_records);
		//echo "test";
        $this->load->view('list_view_consumer_passbook_tpl', $params);
    }
	
	
	public function list_customerwise_consumer_loyalty_details() {
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
        $total_records = $this->Product_model->count_total_list_customerwise_consumer_loyalty($id,$srch_string);
        $params["list_view_consumer_passbook"] = $this->Product_model->list_customerwise_consumer_loyalty($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_customerwise_consumer_loyalty_details/' . $id, $total_records, null, 4);
		//echo $user_id;
        $this->load->view('list_view_customerwise_consumer_loyalty_tpl', $params);
    }
	
	
	
	public function list_view_consumer_feedback_details() {
        $this->checklogin();
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
		
		//$result = $this->db->select('age')->from('my_users_table')->where('id', '3')->limit(1)->get()->row_array();
		//echo $result['age'];
		
		$params["consumer_details"] = $this->db->select('*')->from('consumers')->where('id', $id)->get()->row_array();
        $total_records = $this->Product_model->count_total_consumer_feedback_question($id, $srch_string);
        $params["consumer_feedback_question"] = $this->Product_model->list_view_consumer_feedback_question($id, $limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_view_consumer_feedback_details/' . $id, $total_records);
		
        //$params["links"] = Utils::pagination('product/list_product', $total_records);
	//echo $id;
        $this->load->view('list_view_consumer_feedback_details_tpl', $params);
    }
	
	
	
	public function list_consumer_loyalties() {
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
        
        if(empty($srch_string)){
                $srch_string ='';
        }
        $total_records = $this->Product_model->count_loyalty_redemption_requests($srch_string);
		$params["ScanedCodeListing"] = $this->Product_model->list_loyalty_redemption_requests($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('product/list_consumer_loyalties', $total_records);
        
        ##--------------- pagination End ----------------##
         $data					= array();
         $user_id 	= $this->session->userdata('admin_user_id');		
         $params["ScanedCodeListing"] = $this->Product_model->list_loyalty_redemption_requests($limit_per_page, $start_index,$srch_string);
         $this->load->view('list_consumer_loyalties_tpl', $params);
     }
	 

	 public function list_all_consumers() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->total_all_concumers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_consumers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_all_consumers_tpl', $total_records);
        $this->load->view('list_all_consumers_tpl', $params);
    }
	
	
	
	
	public function list_consumers_loyalty_summary() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->total_all_concumers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_consumers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_consumers_loyalty_summary', $total_records);
		$params["total_records"] =  $total_records;
		
			$this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			$this->db->where('transaction_lr_type', "Loyalty");
			//$this->db->where(array('transaction_lr_type' => "Loyalty", 'transaction_lr_type' => "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;		
		    $params["Total_Earned_Points"] = $Total_Earned_Points; 
		
		    $this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			$this->db->where('transaction_lr_type', "Redemption");
			$query=$this->db->get();
			$Total_Points_Redeemed=$query->row()->points;	
			$params["Total_Points_Redeemed"] = $Total_Points_Redeemed;
			
			$result = $this->db->select('loyalty_points')->from('loylties')->where('transaction_type_slug', 'minimum_locking_balance')->limit(1)->get()->row();
			$minimum_locking_balance = $result->loyalty_points;
			$params["minimum_locking_balance"] = $minimum_locking_balance;
		
        $this->load->view('list_consumers_loyalty_summary_tpl', $params);
    }
	
	
	
	public function list_customer_loyalty_summary() {
        $this->checklogin();
        
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
        $total_records = $this->Product_model->count_total_list_loyalty_customers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_loyalty_customers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/list_customer_loyalty_summary', $total_records);
		$params["total_records"] =  $total_records;
		
			$this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			$this->db->where('transaction_lr_type', "Loyalty");
			//$this->db->where(array('transaction_lr_type' => "Loyalty", 'transaction_lr_type' => "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;		
		    $params["Total_Earned_Points"] = $Total_Earned_Points; 
		
		    $this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			$this->db->where('transaction_lr_type', "Redemption");
			$query=$this->db->get();
			$Total_Points_Redeemed=$query->row()->points;	
			$params["Total_Points_Redeemed"] = $Total_Points_Redeemed;
			
			$result = $this->db->select('loyalty_points')->from('loylties')->where('transaction_type_slug', 'minimum_locking_balance')->limit(1)->get()->row();
			$minimum_locking_balance = $result->loyalty_points;
			$params["minimum_locking_balance"] = $minimum_locking_balance;
		
        $this->load->view('list_customer_loyalty_summary_tpl', $params);
    }
	
	public function view_customer_loyalties() {
        $this->checklogin();
        $user_id = $this->session->userdata('admin_user_id');
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
        $total_records = $this->Product_model->count_total_list_loyalty_customers($srch_string);
        $params["list_all_consumers"] = $this->Product_model->list_all_loyalty_customers($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('product/view_customer_loyalties', $total_records);
		$params["total_records"] =  $total_records;
		
			$this->db->select_sum('points');
			$this->db->from('consumer_passbook');
			//$this->db->where('transaction_lr_type', "Loyalty");
			$this->db->where(array('customer_id' => $user_id, 'transaction_lr_type' => "Loyalty"));
			$query=$this->db->get();
			$Total_Earned_Points=$query->row()->points;		
		    $params["Total_Earned_Points"] = $Total_Earned_Points; 
		
		    
        $this->load->view('view_customer_loyalties_tpl', $params);
    }
	
	
	
}

