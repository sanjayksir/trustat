<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Barcode extends MX_Controller {
      public function __construct() { 
        parent::__construct();  
 		$this->load->model(array('order_master_model'));
  		$this->load->helper(array('common_functions_helper'));
   		$user_id 	= $this->session->userdata('admin_user_id');
 		$user_name 	= $this->session->userdata('user_name');
		$this->load->library('pagination');
 		//echo '***'.base64_decode($this->uri->segment(3));
 		if(empty($user_id) || empty($user_name)){
 			redirect('login');	exit;
		}
      }
	  
      
	 
	 
	public function list_orders() {
 		##--------------- pagination start ----------------##
		 // init params
        $params = array();
        $limit_per_page =20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$srch_string =  $this->input->post('search'); 
		if(empty($srch_string)){
			$srch_string ='';
		}
        $total_records = $this->order_master_model->get_barcode_total_order_list_all($srch_string);
		
		if ($total_records > 0) 
        {
            // get current page records
            $params["orderListing"] = $this->order_master_model->get_barcode_order_list_all($limit_per_page, $start_index,$srch_string);
             
            $config['base_url'] = base_url() . 'order_master/barcode/list_orders';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 4;
             
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
  		 $data					= array();
  		 $user_id 	= $this->session->userdata('admin_user_id');		
		 //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
   		 $this->load->view('list_barcode_order_tpl', $params);
     }
	 
	public function set_barcode()
	{ /*ob_end_clean();
		$code = $temp = rand(10000, 99999);
		//load library
		$this->load->library('zend');
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		//generate barcode
		$code = time().'1222';
		$file = Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
		imagepng($file,"./barcode/{$code}.png");
        $data['barcode'] = $code.'.png';*/
	}
	
	public function qr_item()
    {
		 ob_end_clean();
		$this->load->library('pdf');
		$this->load->library('QR_BarCode.php');
		$pdf = $this->pdf->load();
		$pdf->allow_charset_conversion = true;
	   //$pdf->charset_in = 'iso-8859-4';
      
  		##-----------------QR CODE--------------------------##
 		$qr = new QR_BarCode(); 
 		// create text QR code 
 		$qr->text("pooja"); 
 		$qr->qrCode() ;exit;
		// render QR code 
		//ob_end_clean();
 	    //$html = mb_convert_encoding($qr->qrCode(), 'UTF-8', 'UTF-8');
		##-----------------QR CODE--------------------------##
 	 	$pdf->WriteHTML('kamal'.$qr->qrCode()); // write the HTML into the PDF
 		$output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I'); // save to file because we can
        exit();
    }
	
	
	function view_detail(){
		 $id = $this->uri->segment(4);
		 if($id!=''){
 			$data['order_detail']=$this->order_master_model->get_ordered_product_detail($id);
 			$this->load->view('barcode_print_order',$data);
		 }
	 }
	 
	 
	 function view_order_barcode($product_id='', $order_id=''){
		if(empty($product_id) || empty($order_id)){
			redirect('list_orders');
		}	
		$data['detailData']				= $this->order_master_model->view_barcode_ordered_data($product_id,$order_id );
		$this->load->view('view_barcode_order', $data);			
	}
	
	
	
	## For Printed Bar/Qr Code report
    public function list_printed_report() {
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
        $total_records = $this->order_master_model->get_total_printed_code_list_all($srch_string);		
		//echo $total_records;
		//$total_records = 1000;
        $params["PrintedCodeListing"] = $this->order_master_model->get_printed_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_printed_report', $total_records,null,4);        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_printed_report_tpl', $params);
    }

    ## For scanned reports
    public function list_scanned_report() {
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
        $total_records = $this->order_master_model->count_scanned_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_scanned_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_scanned_report', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_scanned_report_tpl', $params);
    }
	
	
	    ## Consumer Activity Log Starts
    public function ConsumerActivityLog() {
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
        $total_records = $this->order_master_model->count_consumer_activity_log_list_records($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_consumer_activity_log_list($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/ConsumerActivityLog', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('consumer_activity_log_tpl', $params);
    }
	
	## Consumer Activity Log End
	
	
		    ## Consumer Product Referral Report Starts
    public function ConsumerProductReferralReport() {
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
        $total_records = $this->order_master_model->count_consumer_product_referral_report_records($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_consumer_product_referral_report_list_records($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/ConsumerProductReferralReport', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('consumer_product_referral_report_tpl', $params);
    }	
	## Consumer Product Referral Report End
	
	
		    ## Tracek User Activity Log
    public function TracekUserActivityLog() {
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
        $total_records = $this->order_master_model->count_tracek_user_activity_log_list_records($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_tracek_user_activity_log_list($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/TracekUserActivityLog', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('tracek_user_activity_log_tpl', $params);
    }
	
	 ## Tracek User Activity Log end 
	    public function BasicCustomerReportLevel0() {
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
        $total_records = $this->order_master_model->count_basic_customer_report_level0_list($srch_string, $from_date_data, $to_date_data);

        $params["ScanedCodeListing"] = $this->order_master_model->get_basic_customer_report_level0_list($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
        $params["links"] = Utils::pagination('order_master/barcode/BasicCustomerReportLevel0', $total_records,null,4);
        $params["links2"] = Utils::pagination2('order_master/barcode/BasicCustomerReportLevel0', $total_records,null,4);
        $params["total_records2"] = $total_records;
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_basic_customer_report_level0_tpl', $params);
    }
	
	public function BasicCustomerReportLevel0Download() {
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
		
        $this->config->set_item('pageLimit2', $limit_per_page);
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->count_basic_customer_report_level0_list($srch_string, $from_date_data, $to_date_data);

        $params["ScanedCodeListing"] = $this->order_master_model->get_basic_customer_report_level0_list($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
        $params["links"] = Utils::pagination('order_master/barcode/BasicCustomerReportLevel0Download', $total_records,null,4);
        $params["links2"] = Utils::pagination2('order_master/barcode/BasicCustomerReportLevel0Download', $total_records,null,4);
        $params["total_records2"] = $total_records;
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_basic_customer_report_level0_download_tpl', $params);
    }

	
	public function BasicCustomerReportLevel1() {
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
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->count_basic_customer_report_level1_list($srch_string, $from_date_data, $to_date_data);

        $params["ScanedCodeListing"] = $this->order_master_model->get_basic_customer_report_level1_list($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
        $params["links"] = Utils::pagination('order_master/barcode/BasicCustomerReportLevel1', $total_records,null,4);
		
	   // $params["links2"] = Utils::pagination2('order_master/barcode/BasicCustomerReportLevel1', $total_records,null,4);
        //$params["total_records2"] = $total_records;
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_basic_customer_report_level1_tpl', $params);
    }
	
	
		public function BasicCustomerReportLevel1Download() {
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
        $this->config->set_item('pageLimit2', $limit_per_page);
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $srch_string = $this->input->get('search');
		
		$from_date_data = $this->input->get('from_date_data');
		$to_date_data = $this->input->get('to_date_data');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->count_basic_customer_report_level1_list($srch_string, $from_date_data, $to_date_data);

        $params["ScanedCodeListing"] = $this->order_master_model->get_basic_customer_report_level1_list($limit_per_page, $start_index, $srch_string, $from_date_data, $to_date_data);
        $params["links"] = Utils::pagination('order_master/barcode/BasicCustomerReportLevel1Download', $total_records,null,4);
		
	    $params["links2"] = Utils::pagination2('order_master/barcode/BasicCustomerReportLevel1Download', $total_records,null,4);
        $params["total_records2"] = $total_records;
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_basic_customer_report_level1_download_tpl', $params);
    }
	
	
public function BasicCustomerReportLevel0Product() {
        ##--------------- pagination start ----------------##
        // init params
		$product_id = $this->uri->segment(4);
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->count_basic_customer_report_level0_list_product($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_basic_customer_report_level0_list_product($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/BasicCustomerReportLevel0Product/'.$product_id, $total_records,null,5);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_basic_customer_report_level0_product_tpl', $params);
    }
	
	
	public function BasicCustomerReportLevel1Product() {
        ##--------------- pagination start ----------------##
        // init params
		$product_id = $this->uri->segment(4);
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->count_basic_customer_report_level1_list_product($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_basic_customer_report_level1_list_product($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/BasicCustomerReportLevel1Product/'.$product_id, $total_records,null,5);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_basic_customer_report_level1_product_tpl', $params);
    }
	
	public function list_physical_packaging_report() {
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
        $total_records = $this->order_master_model->count_physical_packaging_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_physical_packaging_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_physical_packaging_report', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_physical_packaging_report_tpl', $params);
    }
	
	public function list_physical_unpackaging_report() {
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
        $total_records = $this->order_master_model->count_physical_unpackaging_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_physical_unpackaging_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_physical_unpackaging_report', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_physical_unpackaging_report_tpl', $params);
    }
	
	
		public function ship_out_order_report_list() {
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
        $total_records = $this->order_master_model->count_ship_out_order_report_list($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_ship_out_order_report_list($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/ship_out_order_report_list', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('ship_out_order_report_list_tpl', $params);
    }
	
	public function ship_out_order_details() {
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
        $total_records = $this->order_master_model->count_stock_transfer_out_invoice_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_stock_transfer_out_invoice_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_stock_transfer_out_invoice_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('ship_out_order_details_tpl', $params);
    }
	
	
	public function list_stock_transfer_out_report() {
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
        $total_records = $this->order_master_model->count_stock_transfer_out_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_stock_transfer_out_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_stock_transfer_out_report', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_stock_transfer_out_report_tpl', $params);
    }
	
	public function list_stock_transfer_out_invoice_details() {
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
        $total_records = $this->order_master_model->count_stock_transfer_out_invoice_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_stock_transfer_out_invoice_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_stock_transfer_out_invoice_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_stock_transfer_out_invoice_details_tpl', $params);
    }
	
	
	public function list_stock_transfer_in_report() {
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
        $total_records = $this->order_master_model->count_stock_transfer_in_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_stock_transfer_in_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_stock_transfer_in_report', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_stock_transfer_in_report_tpl', $params);
    }
	
	
	public function list_stock_transfer_in_invoice_details() {
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
        $total_records = $this->order_master_model->count_stock_transfer_in_invoice_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_stock_transfer_in_invoice_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_stock_transfer_in_invoice_details/', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_stock_transfer_in_invoice_details_tpl', $params);
    }
	
	public function list_physical_inventory_check_report() {
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
        $total_records = $this->order_master_model->count_physical_inventory_check_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_physical_inventory_check_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_physical_inventory_check_report', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_physical_inventory_check_report_tpl', $params);
    }
	
	public function list_physical_inventory_details() {
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
        $total_records = $this->order_master_model->count_physical_inventory_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_physical_inventory_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_physical_inventory_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_physical_inventory_details_tpl', $params);
    }
	
	
	public function list_physical_inventory_summary() {
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
        $total_records = $this->order_master_model->count_physical_inventory_summary($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_physical_inventory_summary($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_physical_inventory_summary', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_physical_inventory_summary_tpl', $params);
    }
	
	
	public function view_product_code_details() {
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
        $total_records = $this->order_master_model->count_product_code_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_product_code_details2($limit_per_page, $start_index, $srch_string);
		$params['detailData']		= $this->order_master_model->get_product_code_details($id);
        $params["links"] = Utils::pagination('order_master/barcode/view_product_code_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('view_product_code_details_tpl', $params);
    }
	
	
	public function inventory_on_hand_report() {
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
        $total_records = $this->order_master_model->count_inventory_on_hand_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_inventory_on_hand_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/inventory_on_hand_report', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_inventory_on_hand_report_tpl', $params);
    }

    public function list_purchased_products() {
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
        $total_records = $this->order_master_model->get_barcode_total_order_list_all($srch_string);
		$params["ScanedCodeListing"] = $this->order_master_model->get_purchsed_barqrcodelist($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_purchased_products', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
         $data					= array();
         $user_id 	= $this->session->userdata('admin_user_id');		
         //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
         $this->load->view('list_purchased_products_report_tpl', $params);
     }
	
## For complaint reports
    public function list_complaint_logOld2() {
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
        //$total_records = $this->order_master_model->count_scanned_barqrcodelist($srch_string);
		$total_records = $this->order_master_model->count_complaint_log($srch_string);
        $params["ScanedCodeListing"] = $this->order_master_model->get_complaint_log($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_complaint_log', $total_records, null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_complaint_log_tpl', $params);
    }
	

		public function list_complaint_logOld() {
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
        
        list($total_records,$params["ScanedCodeListing"]) = $this->order_master_model->get_complaint_log($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_complaint_log', $total_records,null,4);
		
		
        ##--------------- pagination End ----------------##
         $data					= array();
         $user_id 	= $this->session->userdata('admin_user_id');		
         //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
         $this->load->view('list_complaint_log_tpl', $params);
     }

	 
	 public function list_feedback_on_product() {
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
        
        list($total_records,$params["ScanedCodeListing"]) = $this->order_master_model->get_feedback_on_product($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_feedback_on_product', $total_records,null,4);
		
		
        ##--------------- pagination End ----------------##
         $data					= array();
         $user_id 	= $this->session->userdata('admin_user_id');		
         //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
         $this->load->view('list_feedback_on_product_tpl', $params);
     }
	 
	 
	 
	public function list_warranty_claims() {
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
        list($total_records,$params["ScanedCodeListing"]) =$this->order_master_model->get_warranty_claims($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_warranty_claims', $total_records,null,4);
		
		
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');		
	
        $this->load->view('list_warranty_claims_tpl', $params);
     }	 
	 
	
	public function list_complaint_log() {
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
        list($total_records,$params["ScanedCodeListing"]) =$this->order_master_model->get_complaint_log($limit_per_page, $start_index,$srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_complaint_log', $total_records,null,4);
		
		
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');		
	
        $this->load->view('list_complaint_log_tpl', $params);
     }
	 
	public function overall_global_inventory_in_hand() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_in_hand_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_in_hand_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/overall_global_inventory_in_hand', $total_records,null,4);
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_in_hand_report_tpl', $params);
    }

	public function overall_global_inventory_in_hand_download() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_in_hand_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_in_hand_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/overall_global_inventory_in_hand_download', $total_records,null,4);
		
		$params["links2"] = Utils::pagination2('product/overall_global_inventory_in_hand_download', $total_records);
		$params["total_records2"] = $total_records;	
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_in_hand_report_download_tpl', $params);
    }	
	
	public function list_overall_global_inventory_stock_transfer_out_invoice_details() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_stock_transfer_out_invoice_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_stock_transfer_out_invoice_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_overall_global_inventory_stock_transfer_out_invoice_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_stock_transfer_out_invoice_details_tpl', $params);
    }
	
	
		public function list_overall_global_inventory_stock_transfer_in_invoice_details() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_stock_transfer_in_invoice_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_stock_transfer_in_invoice_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_overall_global_inventory_stock_transfer_in_invoice_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_stock_transfer_in_invoice_details_tpl', $params);
    }
	
	
	public function list_overall_global_inventory_product_sale_details() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_product_sale_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_product_sale_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_overall_global_inventory_product_sale_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_product_sale_details_tpl', $params);
    }
	
	public function list_overall_global_inventory_product_returned_details() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_product_returned_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_product_returned_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_overall_global_inventory_product_returned_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_product_returned_details_tpl', $params);
    }
	
	
	public function list_overall_global_inventory_closing_details() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_closing_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_closing_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_overall_global_inventory_closing_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_closing_details_tpl', $params);
    }
	
		public function list_overall_global_inventory_opening_details() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_opening_details($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_opening_details($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_overall_global_inventory_opening_details', $total_records,null,4);
        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_opening_details_tpl', $params);
    }
	
	
	
		## For Product Bar/Qr Code History report
    public function list_product_code_history() {
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
        $total_records = $this->order_master_model->get_total_product_code_history_all($srch_string);		
		//echo $total_records;
		//$total_records = 1000;
        $params["PrintedCodeListing"] = $this->order_master_model->get_product_code_history_list($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/list_product_code_history', $total_records,null,4);        
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_product_code_report_tpl', $params);
		}
	
	
		public function unpacked_inventory_in_hand() {
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
        $total_records = $this->order_master_model->count_unpacked_inventory_in_hand_barqrcodes($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_unpacked_inventory_in_hand_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/unpacked_inventory_in_hand', $total_records,null,4);
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_unpacked_inventory_in_hand_report_tpl', $params);
    }

	public function unpacked_inventory_in_hand_download() {
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
        $total_records = $this->order_master_model->count_unpacked_inventory_in_hand_barqrcodes($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_unpacked_inventory_in_hand_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/unpacked_inventory_in_hand_download', $total_records,null,4);
        
		$params["links2"] = Utils::pagination2('product/unpacked_inventory_in_hand_download', $total_records);
		$params["total_records2"] = $total_records;	
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_unpacked_inventory_in_hand_report_download_tpl', $params);
    }


		public function unpacked_inventory_in_hand_list_codes() {
        ##--------------- pagination start ----------------##
        // init params
		$product_id 	= $this->uri->segment(4);
		$code_pack_level 	= $this->uri->segment(5);
		
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->count_unpacked_inventory_in_hand_list_codes($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_unpacked_inventory_in_hand_list_codes($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/unpacked_inventory_in_hand_list_codes/'.$product_id.'/'.$code_pack_level, $total_records,null,6);
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_unpacked_inventory_in_hand_list_codes_tpl', $params);
		}

		public function unpacked_inventory_in_hand_list_codes_download() {
        ##--------------- pagination start ----------------##
        // init params
		$product_id 	= $this->uri->segment(4);
		$code_pack_level 	= $this->uri->segment(5);
        $params = array();
        if(!empty($this->input->get('page_limit'))){
            $limit_per_page = $this->input->get('page_limit');
        }else{
            $limit_per_page = $this->config->item('pageLimit');
        }
        $this->config->set_item('pageLimit', $limit_per_page);
        $start_index = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $srch_string = $this->input->get('search');
        
        if (empty($srch_string)) {
            $srch_string = '';
        }
        $total_records = $this->order_master_model->count_unpacked_inventory_in_hand_list_codes($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_unpacked_inventory_in_hand_list_codes($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/unpacked_inventory_in_hand_list_codes_download/'.$product_id.'/'.$code_pack_level, $total_records,null,6);
		
		$params["links2"] =  Utils::pagination('order_master/barcode/unpacked_inventory_in_hand_list_codes_download/'.$product_id.'/'.$code_pack_level, $total_records,null,6);
		$params["total_records2"] = $total_records;	
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_unpacked_inventory_in_hand_list_codes_download_tpl', $params);
		}
		
		
	public function overall_global_inventory_in_hand_tr_records() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_in_hand_tr_records_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_in_hand_tr_records_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/overall_global_inventory_in_hand_tr_records', $total_records,null,4);
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_in_hand_report_tr_records_tpl', $params);
    }

	public function overall_global_inventory_in_hand_tr_records_download() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_in_hand_tr_records_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_in_hand_tr_records_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/overall_global_inventory_in_hand_tr_records_download', $total_records,null,4);
		
		$params["links2"] = Utils::pagination2('product/overall_global_inventory_in_hand_tr_records_download', $total_records);
		$params["total_records2"] = $total_records;	
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_in_hand_report_tr_records_download_tpl', $params);
    }


	public function overall_global_inventory_in_hand_all_records() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_in_hand_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_in_hand_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/overall_global_inventory_in_hand_all_records', $total_records,null,4);
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_in_hand_report_tpl', $params);
    }

	public function overall_global_inventory_in_hand_all_records_download() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_in_hand_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_in_hand_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/overall_global_inventory_in_hand_all_records_download', $total_records,null,4);
		
		$params["links2"] = Utils::pagination2('product/overall_global_inventory_in_hand_all_records_download', $total_records);
		$params["total_records2"] = $total_records;	
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_in_hand_report_download_tpl', $params);
    }
	
	
		public function overall_global_inventory_in_hand_tr_all_records() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_in_hand_tr_records_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_in_hand_tr_records_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/overall_global_inventory_in_hand_tr_records', $total_records,null,4);
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_in_hand_report_tr_records_tpl', $params);
    }

	public function overall_global_inventory_in_hand_tr_all_records_download() {
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
        $total_records = $this->order_master_model->count_overall_global_inventory_in_hand_tr_records_barqrcodelist($srch_string);

        $params["ScanedCodeListing"] = $this->order_master_model->get_overall_global_inventory_in_hand_tr_records_barqrcodelist($limit_per_page, $start_index, $srch_string);
        $params["links"] = Utils::pagination('order_master/barcode/overall_global_inventory_in_hand_tr_records_download', $total_records,null,4);
		
		$params["links2"] = Utils::pagination2('product/overall_global_inventory_in_hand_tr_records_download', $total_records);
		$params["total_records2"] = $total_records;	
        
		//$params["just_before_closing_id"] = 
        ##--------------- pagination End ----------------##
        $data = array();
        $user_id = $this->session->userdata('admin_user_id');
        //$data['orderListing'] 	= $this->order_master_model->get_order_list_all($user_id);
        $this->load->view('list_overall_global_inventory_in_hand_report_tr_records_download_tpl', $params);
    }
	
	
   }
   
   ?>

