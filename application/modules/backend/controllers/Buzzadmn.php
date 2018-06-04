<?php
class Buzzadmn extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('myspidey_login_model');
        $this->load->model('receive_alert/Receive_alert_model', 'alert');
		$this->load->helper(array('form', 'url','email_helper','common_functions_helper', 'wordcloud'));
		$this->load->library('form_validation','email');
		$this->load->model('Buzzadmn_model');
    }
	
	function checklogin(){
		$user_id 	= $this->session->userdata('admin_user_id');
		$user_name 	= $this->session->userdata('user_name');
		if(empty($user_id) || empty($user_name)){
			redirect('buzzadmn/login');	exit;
		}
	}
	
	function getURL(){
		$res='';
		$result = '';
		$urlName = $this->input->post();
		$story_id = $this->input->post('id');
		if(!empty($urlName)){
  			$res =  slugify($urlName);
			$result = $this->load->Buzzadmn_model->checkStoryExists($res,$story_id);
			if(empty($result)){
				echo $urlName;exit;
			}else{
				echo 1;exit;
			}
		}
		 	
	}
	
    function index() {
		$this->checklogin();
        $search_keyword = '';
        if (!empty($this->input->post('search'))) {
            $search_keyword = $this->input->post('search');
        }
		
		   
	

        $this->load->library('pagination');
        $config = array(
						'base_url' => base_url('buzzadmn/index/'),
						'per_page' => 20,
						'total_rows' => $this->Buzzadmn_model->SpideyPickNumRows($search_keyword),
						'full_tag_open' => '<ul class="pagination">',
						'full_tag_close' => '</ul>',
						'first_tag_open' => '<li>',
						'first_tag_close' => '</li>',
						'last_tag_open' => '<li>',
						'last_tag_close' => '</li>',
						'first_link' => 'First',
						'last_link' => 'Last',
						'next_tag_open' => '<li>',
						'next_tag_close' => '</li>',
						'prev_tag_open' => '<li>',
						'prev_tag_close' => '</li>',
						'num_tag_open' => '<li>',
						'num_tag_close' => '</li>',
						'cur_tag_open' => '<li class="active"><a>',
						'cur_tag_close' => '</a></li>',
					);
					//$config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $data['spideypiclist'] = $this->Buzzadmn_model->getSpideyPickList($search_keyword, $config['per_page'], $this->uri->segment(3));
        $this->load->view('buzzadmn/spidybuzzlist', $data);
    }
	 
	function getLoggedIn()
	{ // echo '<pre>';print_r($_POST);exit; 
		$data = array();
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('username', 'Username', 'required');
		//$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE){
			return $this->myspidey_login_model->getLogin();
		}else{
			 $this->load->view('buzzadmn/login_tpl',$data);
		}
 	}
	
	function dashboard()
	{
	//	echo '<pre>';print_r($this->session->userdata());
		$data = array();
		$this->checklogin();
		$this->load->view('buzzadmn/dashboard');       
 	}	 
	
	function logout()
	{
		$user_data = $this->session->all_userdata();
			foreach ($user_data as $key => $value) {
				if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
					$this->session->unset_userdata($key);
				}
			}
			
			
		$this->session->sess_destroy();//echo '<pre>';print_r($this->session->userdata());exit;
		redirect('/buzzadmn/login');
	}	
	
	function spidey_forgot_pass()
	{   
		//echo 'kamal';exit;
		$email = $this->input->post('email');
		$UserData =  getDataFromEmail($email);
		$firstname = $UserData['user_name'];//echo '<pre>';print_r($UserData);exit;
		$sub = "CitySpidey:Password Changed Request!";
		$data = array();
 		if(!empty($email)){
			$chkEMail = $this->myspidey_login_model->checkEmailExists($email); 
			if(	$chkEMail==1){
				$password = $this->myspidey_login_model->updatepassword($email);
				if(!empty($password)){
					
					
					if( sendemail($firstname, $email, $password, '', $sub, ''))//sendemail($firstname, $to, $password, $rwaname, $sub, $opt) {
					{
						$msg = "1";
					}
					else{
						$msg = "0";
					}
					echo $msg;exit;
				}
			}
		}
 	}
	
	
	function change_password()
	{    
		$this->load->view('change_pass');
 	}
	function reset_password()
	{    
		$data = array();
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
 		$this->form_validation->set_rules('password', 'password', 'required');
		//$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'required');
 		//$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
 		//$this->form_validation->set_rules('password', 'Password', 'required');
		 parse_str($_POST[form_data], $searcharray);
		return $this->myspidey_login_model->reset_password($searcharray);
		 
		 
 	}
	
	function addSpidyBuzz($spidey_id = '') {
		$this->checklogin();
        $states 			= $this->Buzzadmn_model->getState();
        $categories 		= $this->Buzzadmn_model->getCategoryList();
        $data['states'] 	= $states;
        $data['categories'] = $categories;
        if ($spidey_id) {
            $data['buzz'] 	= $this->Buzzadmn_model->find_spidey_buzz($spidey_id);
            if (!empty($data['buzz'][0]['spidypickId'])) {
                $data['related_story'] = $this->Buzzadmn_model->getRelatedStory($data['buzz'][0]['related_storyId']);
            }
        }
        $this->load->view('buzzadmn/spidybuzzadd', $data);
    }
	
	
	## =========================for Editorial New story submit==========================##
	function addSpidyBuzz_idea($spidey_id = '') {
		$this->checklogin();
        $states 			= $this->Buzzadmn_model->getState();
        $categories 		= $this->Buzzadmn_model->getCategoryList();
        $data['states'] 	= $states;
        $data['categories'] = $categories;
         $this->load->view('buzzadmn/spidybuzzadd_editorial', $data);
    }
	
	function saveSpidyBuzz_editorial() {
		$this->checklogin();
		 $spidey_id = $this->input->post('post_id');
		// echo '<pre>';print_r($_POST);exit;
		$checker 					= TRUE;
		$data['Imgs'] 				= $this->saveSpidyBuzz_slider_IMG($_FILES,$checker);
 		 
        if ($checker) {
            $post = $this->input->post();
			$post['Imgs']=$data['Imgs'];
			//echo '<pre>';print_r($post);exit;
            unset($post['save_course']);
            $post['spideyImageSmall'] = $small_image_path;
            $post['spideyImage'] = $big_image_path;
            $last_id = $this->Buzzadmn_model->storeSpideyBuzz($post);
			//echo $this->db->last_query();exit;
            if ($last_id) {
				$update_sub_op_data =  $this->Buzzadmn_model->update_sub_op_data($spidey_id);
                $this->_flashAndRedirect(true, 'Story added successfully.', 'Failed to add story.');
                if ($post['status'] == 1) {
                    $this->_setPushNotification($last_id, $post['title'], implode(',', $post['state']));
                    $this->Buzzadmn_model->updateIfNotified($last_id);
                }
                redirect('buzzadmn/index');
            } else {
                $this->_flashAndRedirect(false, 'Story added successfully.', 'Failed to add story.');
                 redirect('buzzadmn/addSpidyBuzz');
            }
        }
    }
	## =========================for Editorial New story submit==========================##
	
	
	
	function get_Img_dimention($file_tmp_name){
		$img=getimagesize($file_tmp_name);
		$minimum = array('width' => '640', 'height' => '480');
		$width= $img[0];
		$height =$img[1];
		$size = array('width'=>$width, 'height'=>$height);
		return json_encode($size);
	}
	
	
	function ImageRename($fileFldName){
		if(!empty($fileFldName)){
			$RandomNum   		= time();
			$ImageNameImg      	= str_replace(' ','-',strtolower($_FILES[$fileFldName]['name']));
			$ImageExt 			= pathinfo($ImageNameImg, PATHINFO_EXTENSION);
			$ImageName      	= str_replace(' ','-',strtolower(basename($_FILES[$fileFldName]['name'],".".$ImageExt)));
			
			//echo '<pre>';print_r($ImageName);exit;
			 
 			
			
			//$ImageName      = basename(strtolower($_FILES[$fileFldName]['type'])); //"image/png", image/jpeg etc.
			//$ImageExt 		= substr($ImageName, strrpos($ImageName, '.'));
			//$ImageExt       = str_replace('.','-',$ImageExt);
			$ImageName      = str_replace('.', "", $ImageName);
			$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName); 
			$NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
			return $NewImageName;
		}
		
	}
	
	
	
	
	function saveSpidyBuzz_slider_IMG($files,$checker){	
 		$uploads = './uploads/spidey/';
		$data 					  = array();
 		$config_img['upload_path'] = $uploads;
        $config_img['allowed_types']  = '*';//'JPEG|JPG|image/JPEG|image/JPG|IMAGE/JPEG|image/jpeg|jpg|PNG|png|image/png |image/PNG|GIF|jpeg|gif';
        $config_img['max_size'] = '1024*10';
        $config['max_width'] = '2000';
        $config['max_height'] = '2000';
		//$type = getimagesize($files['spideyImage']['tmp_name']);
		//print_r($type );exit;
 
 		 if( isset( $files['spideyImage']['name'] ) && ( ! empty( $files['spideyImage']['name'] ) ) ) {  ##(1024X580)
 					#check img Size
					$img0				= $this->ImageRename('spideyImage');
					$tmp_name 			= $files['spideyImage']['tmp_name'];
					$size_arr0 			= json_decode($this->get_Img_dimention($tmp_name));
					//echo '&&&&&&&&<pre>';print_r($files['spideyImage']);exit;
					if($size_arr0->width<'1024' || $size_arr0->height<'580'){
						$data['spideyImage_valid'] = FALSE;
					}else{
							$config_img['file_name']=$img0;
							$this->load->library('upload', $config_img);
							$this->upload->initialize($config_img);
							if (!$this->upload->do_upload('spideyImage')) {
								$error = array('error' => $this->upload->display_errors());
								//echo '<pre>kama=';print_r($error);
								//exit;
								$checker = FALSE;
								 $this->_flashAndRedirect($checker, 'Big Image is uploaded successfully.', 'Big Image is not uploaded');
 						 		//redirect('buzzadmn/addSpidyBuzz');
							}
							$this->imageResize($this->upload->data(),'775x437');
							//$this->imageResize($this->upload->data(),'300x300');
                           /* $this->imageResize($this->upload->data(),'300x169');
							$this->imageResize($this->upload->data(),'300x149');
                            $this->imageResize($this->upload->data(),'222x190');*/
                            
							$data['spideyImage'] = $img0;
							$data['spideyImage_valid'] = TRUE;
					}
        }
		
		   
		return $data ;
	}
	
	 function saveSpidyBuzz() {
		 $this->checklogin();
		// echo '<pre>';print_r($_POST);exit;
		$checker 					= TRUE;
		$data['Imgs'] 				= $this->saveSpidyBuzz_slider_IMG($_FILES,$checker);
 		 
		 /*$big_image_path 			= $this->ImageRename('spideyImage');//basename($_FILES['spideyImage']['name'], $big_ext) . '_' . time() . $big_ext;
		$data['Imgs']['spideyImage']= $big_image_path ;
		$big_ext 					= '.' . pathinfo($_FILES['spideyImage']['name'], PATHINFO_EXTENSION);
		$big_config 				= array(
										'upload_path' => './uploads/spidey/', // './uploads/spidey_pics/',
										'allowed_types' => 'jpg|gif|png|jpeg',
										'file_name' => $big_image_path
										);
		$this->load->library('upload', $big_config);
		$this->upload->initialize($big_config);
		 if (!$this->upload->do_upload('spideyImage')) {
				  $checker = FALSE;
				  $this->_flashAndRedirect($checker, 'Big Image is uploaded successfully.', 'Big Image is not uploaded');
				  //redirect('Buzzadmn/addSpidyBuzz');
		}*/
		 
		 
        if ($checker) {
            $post = $this->input->post();
			$post['Imgs']=$data['Imgs'];
			//echo '<pre>';print_r($post);exit;
            unset($post['save_course']);
            $post['spideyImageSmall'] = $small_image_path;
            $post['spideyImage'] = $big_image_path;
            $last_id = $this->Buzzadmn_model->storeSpideyBuzz($post);
			//echo $this->db->last_query();exit;
            if ($last_id) {
            	// Get Story by last insert id
            	$storydata = $this->Buzzadmn_model->find_spidey_buzz( $last_id );

            	// Send Email alerts to the registed receivers
            	$emails = array();
				$email_list = $this->alert->get_receiver_emails( $storydata[0]['sub_category_id'] );

				for( $count = 0; $count < count($email_list); $count++ ){
					$emails[] = $email_list[$count]['email'];
					$category = $email_list[$count]['story_category_name'];
				}
				
				if( ! empty( $emails ) ) {
					foreach ($emails as $email) {
				        $receivers[] = $email;
					}

					$to = implode( ',', $receivers );
					receiveAlert( $to, $category, $storydata );
				}
				// =============================================

                $this->_flashAndRedirect(true, 'Story added successfully.', 'Failed to add story.');
                if ($post['status'] == 1) {
                    $this->_setPushNotification($last_id, $post['title'], implode(',', $post['state']));
                    $this->Buzzadmn_model->updateIfNotified($last_id);
                }
                redirect('buzzadmn/index');
            } else {
                $this->_flashAndRedirect(false, 'Story added successfully.', 'Failed to add story.');

                 redirect('buzzadmn/addSpidyBuzz');
            }
        }
    }
	 public function upload_image( $fieldname, $filename, $uploadpath ) {
        //echo $fieldname;die;
        $fullname = pathinfo( $filename['name'] );

        $file_name = $fullname['filename']; // Get file name without extension
        $file_ext = $fullname['extension']; // Get file extension without . (dot)
        //echo "<pre>";

        //if( $filename['size'] <= 2048000 ) {
               $config['upload_path']   = $uploadpath;
               $config['allowed_types'] = 'jpeg|png|jpg|gif|bmp'; 
               $config['max_size']      = 2048000; 
               $config['max_width']     = 1024; 
               $config['max_height']    = 580;
               $config['file_name'] = time().$filename['name'];

               $this->load->library( 'upload', $config );
               $this->upload->initialize( $config );

               $rwa_logo = $this->upload->do_upload( $fieldname );

               $finfo = $this->upload->data();
               
               //print_r($finfo);die;
               return $finfo;
        /*    }
            else {
                $this->session->set_flashdata('checkimg', "Upload max filesize 2MB");
                $this->load->view( 'add_notice' );
            }
        */
    }
 
 
 	function updateSpidyBuzz($spidey_pic_id) {
		$this->checklogin();
        $small_image_path = $big_image_path = '';
        $checker = TRUE;
        if ($_FILES['spideyImageSmall']['name'] != '') {
            $ext = '.' . pathinfo($_FILES['spideyImageSmall']['name'], PATHINFO_EXTENSION);
            $small_image_path = basename($_FILES['spideyImageSmall']['name'], $ext) . '_' . time() . $ext;
            $small_config = array(
									'upload_path' => './uploads/spidey/', //'./uploads/spidey_pics',
									'allowed_types' => 'jpg|gif|png|jpeg',
									'file_name' => $small_image_path
								);
            $this->load->library('upload', $small_config);
            $this->upload->initialize($small_config);

            if (!$this->upload->do_upload('spideyImageSmall')) {
                //$checker = FALSE;
                //$this->_flashAndRedirect($checker, 'Small Image is uploaded successfully.', 'Small Image is not uploaded');
               // redirect('Buzzadmn/addSpidyBuzz/' . $spidey_pic_id);
            }
        }


        if ($_FILES['spideyImage']['name'] != '') {
            $big_ext = '.' . pathinfo($_FILES['spideyImage']['name'], PATHINFO_EXTENSION);
            $big_image_path = basename($_FILES['spideyImage']['name'], $big_ext) . '_' . time() . $big_ext;
            $big_config = array(
									'upload_path' => './uploads/spidey/', //'./uploads/spidey_pics',
									'allowed_types' => 'jpg|gif|png|jpeg',
									'file_name' => $big_image_path
							   );
            $this->load->library('upload', $big_config);
            $this->upload->initialize($big_config);

            if (!$this->upload->do_upload('spideyImage')) {
               // $checker = FALSE;
               // $this->_flashAndRedirect($checker, 'Big Image is uploaded successfully.', 'Big Image is not uploaded');
               // redirect('Buzzadmn/addSpidyBuzz/' . $spidey_pic_id);
            }
			/*$this->imageResize($this->upload->data(),'300x300');
            $this->imageResize($this->upload->data(),'300x169');
			$this->imageResize($this->upload->data(),'300x149');
            $this->imageResize($this->upload->data(),'222x190');*/
        }

        if ($checker) {
            $post = $this->input->post();
            unset($post['save_course']);
            if ($small_image_path)
                $post['spideyImageSmall'] = $small_image_path;
            if ($big_image_path)
                $post['spideyImage'] = $big_image_path;
            if ($this->Buzzadmn_model->storeSpideyBuzz($post)) {
                $this->_flashAndRedirect(true, 'Story updated successfully.', 'Failed to updated story.');
                if ($post['currstatus'] == 0 && $post['status'] == 1) {
                    $this->_setPushNotification($post['spidypickId'], $post['title'], implode(',', $post['state']));
                    $this->Buzzadmn_model->updateIfNotified($post['spidypickId']);
                }
                redirect('buzzadmn/index/');
            } else {
                $this->_flashAndRedirect(false, 'Story updated successfully.', 'Failed to updated story.');
                redirect('buzzadmn/index/');
            }
        }
    }
	
	 function spideyStatus($spidey_id, $status) {
		 $this->checklogin();
        $status = ($status) ? 0 : 1;
        $this->Buzzadmn_model->publish_unpublish($spidey_id, $status);
        $spidey_detail = $this->Buzzadmn_model->find_spidey_buzz($spidey_id);
        //echo 'if_notified - ' . $spidey_detail[0]['if_notified'];
        if (!$spidey_detail[0]['if_notified']) {
            $this->_setPushNotification($spidey_id, $spidey_detail[0]['spidyName'], '');
            $this->Buzzadmn_model->updateIfNotified($spidey_id);
        }
        redirect('buzzadmn/index');
    }

    function saveAutoSaveSpidyBuzz() {
        $post = $this->input->post();
        unset($post['save_course']);
        $last_id = $this->Buzzadmn_model->storeSpideyBuzz($post);
        echo $last_id;
        exit;
    }
	
    function preview($spidey_pic_id) {
		$this->checklogin();
        $spidey_title = $this->Buzzadmn_model->getSpideyTitle($spidey_pic_id);
        redirect('http://www.cityspidey.com/spideypick_detail.php?id=' . $spidey_pic_id . '&sef=' . $spidey_title[0]['spidyName']);
    }
	
	 private function _flashAndRedirect($successful, $successmsg, $failmsg) {
        if ($successful) {
            $this->session->set_flashdata('feedback', $successmsg);
            $this->session->set_flashdata('feedback_class', 'alert-success');
        } else {
            $this->session->set_flashdata('feedback', $failmsg);
            $this->session->set_flashdata('feedback_class', 'alert-danger');
        }
    }

    private function _setPushNotification($spidey_id, $title, $states) {
        // Create JSON FILE IN API In Add New Story//
        //$this->create_detail_file($lastid);
        $type = 'all';
        $title = 'Fresh on SpideyBuzz: ' . strip_tags($title);
        $remoturl = 'com.cityspidey://spideybuzz?id=' . $spidey_id;
        //$this->db->pushNotification('', '', '', '', '', $title, '', $type, $remoturl);
        pushNotification('', '', '', '', '', $title, '', $type, $remoturl, $states);
    }

    function getRelatedStories() {
        $dataArray = $this->input->post();
        return $this->Buzzadmn_model->relatedStory($dataArray);
        exit;
    }
	
	 function getSubCategoryList(){
		 $id = $this->input->post('id');
		 $res = $this->Buzzadmn_model->getSubCategoryList($id);
		 echo $res;exit;
	 }

	function togglebreakingnews()
	{
		if ($this->input->post('save_chk') == true){
			$story_id = $this->input->post('story_id');
			return $this->Buzzadmn_model->make_breaking_news($_POST);
		}else{
			 $this->load->view('buzzadmn/login_tpl',$data);
		}
	}
	  
	 function download($fileName = NULL) {
		$this->load->helper('download');  
		$fileName = "video_12_1500104173344.MP4";
		   if ($fileName){
			$file =  'uploads/temp/'.$fileName;
			// check file exists    
			if (file_exists ( $file )) {//echo 'test';exit;
			 // get file content
			 $data = file_get_contents ( $file );
			 //force download
			 force_download ( $fileName, $data );
			} else {
			 // Redirect to base url
			 redirect ( base_url () );
			}
		   }
		}
 	
	function getCities()
	{ 
		$state_id = $this->input->post('id');
		$result = $this->Buzzadmn_model->fetchCity($state_id);
		//echo '<pre>kam===='; exit;
		echo json_encode($result);exit;
  	}	
	
	function getArea()
	{ 
		$city_id = $this->input->post('id');
		$result = $this->Buzzadmn_model->fetchArea($city_id);
		//echo '<pre>';print_r($result);exit;
		echo json_encode($result);exit;
  	}

	function imageResize($file,$param){
$config=array();

switch($param){
	case'775x437':
      $w=775;
     // $h=169;
	  $file_path='./uploads/spidey/thumb_buzz/'.$file['file_name'];
      break;
	 case'300x300':
      $w=300;
     // $h=169;
	  $file_path='./uploads/spidey/thumb_300x300/'.$file['file_name'];
      break;
    case'300x169':
      $w=300;
     // $h=169;
	  $file_path='./uploads/spidey/thumb_300x169/'.$file['file_name'];
      break;
    case'300x149':
      $w=300;
      //$h=149;
	  $file_path='./uploads/spidey/thumb_300x149/'.$file['file_name'];
      break;	  
    case'222x190':
      $w=222;
      //$h=190;
	  $file_path='./uploads/spidey/thumb_222x190/'.$file['file_name'];
     break;	
      }
 $config['image_library'] = 'gd2';
 $config['source_image'] = $file['full_path'];
 $config['new_image'] = $file_path;
 $config['maintain_ratio'] = true;

 $config['width'] = $w;
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
 #####-------------- Slider Settings function to list the story in slider -----------------------#########
	function slider_settings()
	{ 	  	//echo '<pre>';print_r($_POST['slider_id_hid']);
	 		// echo '<pre>';print_r($_POST['story_order']);
			$slider_ids_with_order 	= array();
			$slider_ids_hid			= array();
			$data['setSliderCnt'] 	=  true;
			$slider_ids_with_order 	= $_POST['story_order'];
			$slider_ids_hid			= explode(',',$_POST['slider_id_hid']);
			$get_checked_ids_arr 	= array();
			if(!empty($_POST['slider_id_hid'])){
  				foreach($slider_ids_with_order as $key=>$val){
 					$value = array_values($val);
					if(in_array(key($val),$slider_ids_hid)){
						$get_checked_ids_arr[key($val)] = $value[0];
					}
 				}
				//$update_slider_story = $this->Buzzadmn_model->update_slider_story(json_encode($get_checked_ids_arr));
			}
		// echo '<pre>';print_r(json_encode($get_checked_ids_arr));exit;
  		$this->checklogin();
        $search_keyword = '';
        if (!empty($this->input->post('search'))) {
            $search_keyword = $this->input->post('search');
        }
		##------------- Set slider count----------##
		if (!empty($this->input->post('submitcnt'))) { 
            $slider_cnt = $this->input->post('slider_cnt');
			$updateSliderCnt =  $this->Buzzadmn_model->updateSliderCount($slider_cnt);
			$this->session->set_flashdata('feedback', 'Slider count set!');
			$data['slider_cnt'] =  $slider_cnt;
			$data['setSliderCnt'] =  false;
        }else{  
			$data['slider_cnt'] =  $this->Buzzadmn_model->getslidetCnt();
			 
		}
		## Set Slider stories
		if (!empty($this->input->post('submitIds'))) {
            $slider_id_hid = $this->input->post('slider_id_hid');
			//echo '<pre>';print_r($get_checked_ids_arr);exit;
			$updateSliderCnt =  $this->Buzzadmn_model->updateSliderStories(json_encode(array_filter($get_checked_ids_arr)));
			$this->session->set_flashdata('feedback', 'Slider count set!');
			//$data['setSliderCnt'] =  true;
			 
        }
		##------------- Set slider count----------##
        $this->load->library('pagination');
        $config = array(
						'base_url' => base_url('buzzadmn/slider_settings/'),
						'per_page' => 20,
						'total_rows' => $this->Buzzadmn_model->SpideyPickNumRows($search_keyword),
						'full_tag_open' => '<ul class="pagination">',
						'full_tag_close' => '</ul>',
						'first_tag_open' => '<li>',
						'first_tag_close' => '</li>',
						'last_tag_open' => '<li>',
						'last_tag_close' => '</li>',
						'first_link' => 'First',
						'last_link' => 'Last',
						'next_tag_open' => '<li>',
						'next_tag_close' => '</li>',
						'prev_tag_open' => '<li>',
						'prev_tag_close' => '</li>',
						'num_tag_open' => '<li>',
						'num_tag_close' => '</li>',
						'cur_tag_open' => '<li class="active"><a>',
						'cur_tag_close' => '</a></li>',
					);
        $this->pagination->initialize($config);
		
		## Get slider selected storyId
		$sliderIds= $this->Buzzadmn_model->getSliderIds();
		$data['spideyIds'] =json_decode(json_encode($sliderIds),true);
 		 
        $data['spideypiclist'] = $this->Buzzadmn_model->getSpideyPickList($search_keyword, $config['per_page'], $this->uri->segment(3));
        $this->load->view('buzzadmn/spidybuzzlist_slider', $data);
    	 
  	}
#####-------------- Slider Settings function to list the story in slider -----------------------#########

  	// Set Is_Main story for special section
	function set_is_main() {
		$story_id = $this->input->post('story_id');

		$result = $this->Buzzadmn_model->setIsMain( $story_id );
		if($result)
			echo "success";
		else
			echo "failed";
	}
	
	function profile(){
		 $this->checklogin();
		 $data['userData'] = 	$this->load->Buzzadmn_model->getUserDetail();
		 $this->load->view('buzzadmn/admin_profile', $data);
	}
 }
