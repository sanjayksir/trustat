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
            $params["PrintedCodeListing"] = $this->order_master_model->get_printed_barqrcodelist($limit_per_page, $start_index,$srch_string);
             
            $config['base_url'] = base_url() . 'order_master/barcode/list_printed_report';
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
   		 $this->load->view('list_printed_report_tpl', $params);
     }
	
	
	
	## For scanned reports
	public function list_scanned_report() {
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
            $params["ScanedCodeListing"] = $this->order_master_model->get_scanned_barqrcodelist($limit_per_page, $start_index,$srch_string);
             
            $config['base_url'] = base_url() . 'order_master/barcode/list_scanned_report';
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
   		 $this->load->view('list_scanned_report_tpl', $params);
     }
	 
	
   }?>

