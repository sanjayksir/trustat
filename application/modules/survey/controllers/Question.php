<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends MX_Controller {

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('logged_in')) {
            
        }
    }

}
