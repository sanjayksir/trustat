<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        $data['view'] = 'add_survey';
        $this->load->view('template',$data);
    }

}
