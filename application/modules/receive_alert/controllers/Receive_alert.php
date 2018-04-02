<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Receive_alert extends MX_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Receive_alert_model', 'alert');
		$this->load->library(array('email','encryption', 'encrypt'));
		$this->load->helper('email');
	}

	// Subscribe Newsletter
	public function receivealert($data) {
		$email = $this->input->post('alert_subscriber_email');
		$cat_id = $this->input->post('cat_id');

		echo $this->alert->receive( $email, $cat_id );
	}

	public function unsubscribe( $category_id ) {
		$data = array();
		$data['category_id'] = array( $category_id );
		$this->load->view( 'unsubscribe_alert', $data );
	}

	public function unsubscribe_alert() {
		$data = array();
		$inputs = $this->input->post();

		// Act if for is submitted

		$category_name = $this->alert->get_category_name($inputs['category_id']);
		$email_res = unsubscribeAlert( $inputs['email'], $category_name, $inputs['category_id'], $inputs['reason'] );
		
		echo "Request has been sent to your registered email. Please confirm unsubscription.";
	}

	public function unsubscribed( $url ) {
		$url = explode( '/', decrypt_url( $url ) );
		
		$success = $this->alert->unsubscribe_alert( $url[0], $url[1], $url[2] );
		$this->load->view('thankyou', $success);
	}

	public function thankyou() {
		$this->load->view('thankyou', array("success" => "Request has been sent to your registered email. Please confirm unsubscription."));
	}
}