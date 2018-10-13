<?php

class Product_attrribute extends MX_Controller {

    function __construct() {//echo md5('travel@123');exit;
        parent::__construct();
        $this->load->model('Buzzadmn_model');
        $this->load->helper("url");
        //$this->load->library("pagination");
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');

        if (empty($user_id) || empty($user_name)) {
//            redirect('backend/login');
//            exit;
        }
    }

    ##======================By Kamal ============================##

    function addStoryDetails() { //echo '<pre>';print_r($this->input->post());exit;
        //echo $this->input->post('clickedBtn'); exit;
        if (!empty($this->input->post('hiddenval'))) { //echo 'kam';exit;
            $pickDesc = $this->input->post('pickDesc');
            $clickedBtn = $this->input->post('clickedBtn');
            $status = (!empty($clickedBtn) && $clickedBtn == 'Save') ? '0' : '1';
            $spidey_id = $this->input->post('product_id');
            $data['pickDesc'] = $pickDesc;
            $data['status'] = $status;
            //print_r($this->input->post());exit;
            ## Media Files
			
			$allPTImageList_arr = $this->input->post('all_PTImages_list');
            $allPTImageList = $allPTImageList_arr[0];
			
            $allImageList_arr = $this->input->post('all_Images_list');
            $allImageList = $allImageList_arr[0];

            $all_videos_list_arr = $this->input->post('all_videos_list');
            $allVideoList = $all_videos_list_arr[0];

            $all_audios_list_arr = $this->input->post('all_audios_list');
            $allAudioList = $all_audios_list_arr[0];

            $allAttachment_arr = $this->input->post('all_attachments_list');
            $allAttachmentList = $allAttachment_arr[0];

            $allProductDemoVideo_arr = $this->input->post('all_product_demo_video_list');
            $allProductDemoVideoList = $allProductDemoVideo_arr[0];

            $allProductDemoAudio_arr = $this->input->post('all_product_demo_audio_list');
            $allProductDemoAudioList = $allProductDemoAudio_arr[0];

            $allProductUserManual_arr = $this->input->post('all_product_user_manual_list');
            $allProductUserManualList = $allProductUserManual_arr[0];
			
			$allProductPushAdVideo_arr = $this->input->post('all_product_push_ad_video_list');
            $allProductPushAdVideoList = $allProductPushAdVideo_arr[0];
			
			$allProductSurveyVideo_arr = $this->input->post('all_product_survey_video_list');
            $allProductSurveyVideoList = $allProductSurveyVideo_arr[0];
            ## Media Files
            $data['ptimages'] = $allPTImageList;
			$data['images'] = $allImageList;
            $data['videos'] = $allVideoList;
            $data['audios'] = $allAudioList;
            $data['attachments'] = $allAttachmentList;
            $data['demovideo'] = $allProductDemoVideoList;
			$data['push_advideo'] = $allProductPushAdVideoList;
			$data['surveyvideo'] = $allProductSurveyVideoList;
            $data['demoaudio'] = $allProductDemoAudioList;
            $data['demoattachments'] = $allProductUserManualList;
            $data['product_id'] = $spidey_id;
            //echo '<pre>';print_r($data);exit;
            if ($this->input->post('clickedBtn') == 'Submit' || $this->input->post('clickedBtn') == 'Save') {
                $this->session->set_flashdata('success', 'Idea ' . $this->input->post('clickedBtn') . ' Successfully!');
            }

            echo $returnVal = $this->Buzzadmn_model->saveIdeaDetail($data);
            exit;
        }
        // $this->load->view('Editorial/add_story_idea_details/');
    }

    ## OPen Story Details=== DONE

    function att_detail($productId = null) {
        if(is_null($productId)){
            throw new Exception('Ivalid product id.');
        }
        $data = $this->db->get_where('products',['id'=>$productId])->row();
        if(empty($data)){
            throw new Exception('Ivalid product id.');
        }
        $this->load->view('Editorial/add_story_idea_details', $data);
    }
    
    public function media_description($productId= null){        
        if(is_null($productId)){
            $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>false,'message'=>'Invalid request.']));
        }        
        $pId = base64_decode($productId);
        $product = $this->db->get_where('products',['id'=>$pId])->row_array();
        if(empty($product)){
            $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>false,'message'=>'Invalid product.']));
        }
        if($this->db->update('products',$this->input->post(),['id'=>$pId])){
            $response = ['status'=>true,'message'=>'Product Loyalty & Description updated successfully.'];
        }else{
            $response = ['status'=>false,'message'=>'Failed to add/edit description.'];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function media_attribute($fileName,$productId= null){        
        if(is_null($fileName) || is_null($productId)){
            $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>false,'message'=>'Invalid request.']));
        }
        $data[$fileName] = $this->mediaUpload($fileName);
        if(is_array($data[$fileName])){
            $data[$fileName] = implode(',', $data[$fileName]);
        }else{
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status'=>false,
                'message'=>$data[$fileName]               
            ]));
        }
        $pId = base64_decode($productId);
        $product = $this->db->get_where('products',['id'=>$pId])->row_array();
        if(!empty($product[$fileName])){
            $data[$fileName] = $data[$fileName].','.$product[$fileName];
        }
        if($this->db->update('products',$data,['id'=>$pId])){
            $response = ['status'=>true,'message'=>'Media file have been updated successfully.'];
        }else{
            $response = ['status'=>false,'message'=>'Media file failed to update.'];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
      
    }
    
    public function view_media_file($fileName,$productId= null){
        if(is_null($fileName) || is_null($productId)){
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status'=>false,'message'=>'Invalid request.'
                ]));
        }
        $pId = base64_decode($productId);
        $mediaLocation = $this->config->item('media_location');
        if(empty($mediaLocation)){
            die("Define the media location directory.");
        }
        $mediaStore = FCPATH.$mediaLocation;
        $product = $this->db->get_where('products',['id'=>$pId])->row_array();
        $fItems = [];
        if(!empty($product[$fileName])){
            $productItem = explode(',',$product[$fileName]);
            foreach($productItem as $key => $value){
                $fItems[] = [
                    'name'=> end(explode('/',$value)),
                    'path'=> $this->getThumb($value),
                    'size'=> filesize($mediaStore.'/'.$value)
                ];
            }            
        }
        //echo "<pre>";print_r($fItems);die;
        $this->output->set_content_type('application/json')->set_output(json_encode($fItems));
        
    }
    
    public function delete_media_file($fileName,$productId= null){
        $file = $this->input->post('file');        
        if(is_null($fileName) || is_null($productId) || !empty($file)){
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status'=>false,'message'=>'Invalid request.'
                ]));
        }
        $pId = base64_decode($productId);
        $mediaLocation = $this->config->item('media_location');
        if(empty($mediaLocation)){
            die("Define the media location directory.");
        }
        $mediaStore = FCPATH.$mediaLocation;
        $product = $this->db->get_where('products',['id'=>$pId])->row_array();        
        $fItems = null;
        if(!empty($product[$fileName])){
            $productItem = explode(',',$product[$fileName]);            
            $index = array_search($file,$productItem );
            if($index !== false){
                unlink($mediaStore.'/'.$file);
                unset($productItem[$index]);
            }
            if(!empty($productItem)){
                $fItems = implode(',',$productItem);
            }else{
                $fItems = '';
            }
            if($this->db->update('products',[$fileName =>$fItems],['id'=>$pId])){
                $response = ['status'=>true,'message'=>'Deleted successfully.'];
            }else{
                $response = ['status'=>false,'message'=>'Failed to delete file.'];
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        
    }
    
    public function mediaUpload($fileName) {
        ini_set("memory_limit", "256M");
        ini_set("max_execution_time", 30000);        
        
        $json = array();
        $mediaLocation = $this->config->item('media_location');
        if(empty($mediaLocation)){
            die("Define the media location directory.");
        }
        $mediaStore = FCPATH.$mediaLocation;        
        $fileItems = [];
        if(is_array($files[$fileName]['name'])){
            $files = $_FILES;
            $total = count($files[$fileName]['name']);        
            unset($_FILES);
            for ($i = 0; $i < $total; $i++) {
                $_FILES[$fileName]['name'] = $files[$fileName]['name'][$i];
                $_FILES[$fileName]['type'] = $files[$fileName]['type'][$i];
                $_FILES[$fileName]['tmp_name'] = $files[$fileName]['tmp_name'][$i];
                $_FILES[$fileName]['error'] = $files[$fileName]['error'][$i];
                $_FILES[$fileName]['size'] = $files[$fileName]['size'][$i];
                //echo $mediaStore.'/';die;
                $this->load->library('upload', [
                    'upload_path'=>'./'.$mediaLocation.'/',
                    'allowed_types'=>$this->config->item('media_allowed_types'),
                    'overwrite'=>false
                ]);
                if($this->upload->do_upload($fileName)){
                    $fileItems [] = $this->upload->data('file_name');                
                }else{
                    echo $this->upload->display_errors();die;
                }            
            }
        }else{
            $this->load->library('upload', [
                'upload_path'=>'./'.$mediaLocation.'/',
                'allowed_types'=>$this->config->item('media_allowed_types'),
                //'max_size'=>'5120',
                'overwrite'=>false
            ]);
            
            if($this->upload->do_upload($fileName)){
                $fileItems [] = $this->upload->data('file_name');                
            }else{
                echo $this->upload->display_errors();die;
            }            
        }
        return $fileItems ;
    }
    
    public function getThumb($file){		
        $fileExt = pathinfo($file,PATHINFO_EXTENSION);
        $mediaLocation = $this->config->item('media_location');        
        $imageType = explode('|',$this->config->item('image_type'));        
        $videoType = explode('|',$this->config->item('video_type'));        
        if(in_array($fileExt,$imageType)){
            $thumb =site_url($mediaLocation.'/'.$file);
        }elseif(in_array($fileExt, $videoType)){
            $thumb = site_url('assets/images/mp4.jpg');
        }elseif(in_array($fileExt, ['mp3'])){
            $thumb = site_url('assets/images/mp3.jpg');
        }elseif(in_array($fileExt, ['pdf'])){
            $thumb = site_url('assets/images/pdf.jpg');
        }
        return $thumb;
    }

    ### =========================EDITORIAL FUNCTIONS STARTS==================================##

    function manage() {
        
    }

    ## ============================= For user story listing =========================================##
    ##======================By Kamal ============================##
    ##======================= Out Put Section start ================================##

    function suboutput() {
        
    }

    function viewOPstoryDetail() {
        
    }

    function editStoryDetail_op() {
        $insertData = array();
        $mediaList = array();
        $storyId = $this->uri->segment(4);
        $data['resData'] = $this->Buzzadmn_model->fetchStoryetailIdea($storyId);
        $data['storyIdea'] = $this->Buzzadmn_model->fetchStoryIdea_sub($storyId);
        ## Get ALl Story Media- like images videos, mp3 and pdf list and download them
        $data['mediaList'] = $this->Buzzadmn_model->getstoryMedia($storyId);
        //echo '<pre>';print_r($mediaList);exit;
        ## Get ALl Story Media- like images videos, mp3 and pdf list and download them
        $this->load->view('Editorial/edit_story_op_details', $data);
    }

    ##======================= Out Put Section start ================================##

    function download() {
        $id = trim($this->uri->segment(4));
        zipFilesAndDownload($id);
        exit;
    }

    /* function download_single($filename = NULL) {
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
      } */

    function single_file_dwld2($file) {
        ob_clean();

        // "bill"
        //echo $this->uri->segment(4);exit;
        $file = $this->uri->segment(4); //$_GET['filename'];
        $download_path = 'uploads/' . $file;

        $path_info = pathinfo($file_to_download);
        $mimetype = 'file';
        if ($path_info['extension'] == 'mp4') {
            $mimetype = 'mp4';
        }

        $file_to_download = $download_path; // file to be downloaded
        header("Expires: 0");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Pragma: no-cache");
        header("Content-type: application/$mimetype");
        header('Content-length: ' . filesize($file_to_download));
        header('Content-disposition: attachment; filename=' . basename($file_to_download));
        readfile($file_to_download);
        exit;
    }

    function single_file_dwld($file) {
        $file = trim($file);
        $filename = 'uploads/' . trim($this->uri->segment(4));
        ob_clean();
        $ctype = "application/[extension]";
        // required for IE, otherwise Content-disposition is ignored
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');

        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false); // required for certain browsers
        header("Content-Type: $ctype");
        // change, added quotes to allow spaces in filenames
        header("Content-Disposition: attachment; filename=" . basename(trim($filename)) . "");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($filename));
        readfile("$filename");
        exit();
    }

    function buzz_story_listing() {
        
    }

    // Approve Buzz Story
    function approve_buzz_story() {
        
    }

    // Reject Buzz Story
    function reject_buzz_story() {
        
    }

    // Edit Buzz Story by Editor
    function editBuzzStoryDetail() {
        //echo "story";exit;
        //echo $this->uri->segment(4);
        $insertData = array();
        $data = array();
        $story_id = $this->input->post('storyId');
        if (!empty($this->input->post('hiddenval')) && !empty($story_id)) {
            $story_idea = $this->input->post('pickDescEdit');
            $clickedBtn = $this->input->post('clickedBtn');
            $storyId = $this->input->post('storyId');
            $login_type = $this->session->userdata('login_type');
            $data['story_idea'] = $story_idea;
            $user_id = $this->session->userdata('admin_user_id');
            //$data['status'] 	= $status;
            $data['storyId'] = $storyId;

            $insertData = array(
                "reporter_content" => trim($story_idea),
                "story_id" => $storyId,
                "reporter_id" => $user_id,
                "created_on" => date('Y-m-d H:i:s'),
                "created_by" => $user_id,
                "status" => $data['status']
            );

            if ($login_type == 'reporter') {// echo 'kam';exit;
                if ($clickedBtn == 'Save') {

                    $insertData['storyId'] = $storyId;
                    $insertData['is_reporter_edit'] = 1;
                    $insertData['status'] = 0;
                    $buzzideaUpdate = $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
                } else {
                    $insertData['storyId'] = $storyId;
                    $insertData['status'] = 1;
                    $insertData['assigned'] = 3;
                    $buzzideaUpdate = $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
                }
                //echo $buzzideaUpdate 	= $this->Buzzadmn_model->UpdateBuzzIdea($insertData);
                echo $returnVal = $this->Buzzadmn_model->UpdateIdeaDetail($insertData);
                //echo '***'.$this->db->last_query();exit;
            }
            if ($login_type == 'input') {
                if (trim($clickedBtn) == 'Save') { //echo 'kam1';
                    $insertData['is_input_edit'] = '1';
                    $insertData['status'] = '0';
                    $insertData['assigned'] = '2';
                    //print_r($insertData);exit;	
                } else if (trim($clickedBtn) == 'Submit') { //echo 'kam2';
                    $insertData['status'] = '1';
                    $insertData['assigned'] = '2';
                    //print_r($insertData);exit;	
                }
                echo $returnVal = $this->Buzzadmn_model->UpdateIdeaDetail($insertData);
                exit;
                //echo '***'.$this->db->last_query();exit;
            }
        }
        $data['resData'] = $this->Buzzadmn_model->fetchStoryetailIdea($this->uri->segment(4));
        //print_r($data);exit;
        $data['storyIdea'] = $this->Buzzadmn_model->fetchStoryIdea($this->uri->segment(4));
        //echo '<pre>'; print_r($data);exit;
        $this->load->view('Editorial/edit_buzz_story_idea_details', $data);
    }

    function view($id = '') {
        if (empty($id)) {
            redirect('product/list_product');
        }
        $data['detailData'] = $this->Buzzadmn_model->view_product_data($id);
        $this->load->view('Editorial/view_product_detail', $data);
    }

}
