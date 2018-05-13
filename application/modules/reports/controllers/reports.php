<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('reports_model'));
        $this->load->helper(array('common_functions_helper'));
        $user_id = $this->session->userdata('admin_user_id');
        $user_name = $this->session->userdata('user_name');
        $this->load->library('pagination');

        //echo '***'.base64_decode($this->uri->segment(3));
        if (empty($user_id) || empty($user_name)) {
            redirect('login');
            exit;
        }
    }

    public function barcode_status_reports() {
        ##--------------- pagination start ----------------##
        // init params
        $params = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $srch_string = $this->input->post('search');
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->get_total_order_list_all($srch_string);

        if ($total_records > 0) {
            // get current page records
            $params["orderListing"] = $this->order_master_model->get_order_list_all($limit_per_page, $start_index, $srch_string);

            $config['base_url'] = base_url() . 'order_master/list_orders';
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
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_order_tpl', $params);
    }

    /* public function edit_product($id) {
      $data					= array();
      $id 					= $this->uri->segment(3);//$this->session->userdata('admin_user_id');
      $data['product_data'] 	= $this->order_master_model->get_order_details($id);
      $this->load->view('edit_product', $data);
      }

     */
}
?>

