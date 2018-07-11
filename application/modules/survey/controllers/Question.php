<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        if ($this->session->userdata('logged_in')) {
            
        }
    }
    
     public function listing(){
         Utils::debug();
        $data['view'] = 'question_listing';
        if(!empty($this->input->get('page_limit'))){
            $limit = $this->input->get('page_limit');
        }else{
            $limit = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit);
        $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $query = $this->input->get('q',null);
        list($data['total'],$data['plant_data']) = $this->QuestionModel->getAllQuestions($limit,$offset,$query);
        
        $data["links"] = Utils::pagination($data['view'], $data['total']);
        $data['breadcrumb'] = [
            ['title'=>'All Question','url'=>null]
        ];
        $this->load->view('template',$data);
    }

}
