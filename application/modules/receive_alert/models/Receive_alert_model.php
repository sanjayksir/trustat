<?php
class Receive_alert_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    // Check if subscriber email exists in buzz_user table
    public function receive( $email, $cat_id ) {
        $cat_name = $this->get_category_name( $cat_id );
    	$this->db->select( 'email, is_subscribed' )
    		->from( 'receive_alert' )
    		->where( array( 'email' => $email, 'story_category_id' => $cat_id ) );
    	$alert_query = $this->db->get();
	    $receiver = $alert_query->result_array();
    	$if_received = $alert_query->num_rows();

    	if( $if_received > 0 ) {
    		if( $receiver[0]['is_subscribed'] == 1 ) {	// If is_subscribed status is 1
    			$res = "Already subscribed";
    		}
    		else {	// If is_subscribed status is 0 => updated is_subscribed status = 1
    			$this->db->where( 'email', $email );
    			$this->db->update( 'receive_alert', array( 'is_subscribed' => 1 ) );
    			$res = "Your subscription has been registered.";
    		}
    	}
    	else {
	    	$this->db->select( 'user_id, user_email_phone' )
	    		->from( 'buzz_user' )
	    		->where( array( 'user_email_phone' => $email ) );
	    	$buzz_query = $this->db->get();
	    	$result = $buzz_query->result_array();
	    	$rows_count = $buzz_query->num_rows();

	    	// buzz_user table record
	    	if( $rows_count > 0 ) {	// Insert into subscription table with buzz_user's user_id
	    		$this->add_receiver( array( 'user_id' => $result[0]['user_id'], 'email' => $email, 'story_category_id' => $cat_id, 'story_category_name' => $cat_name ) );
	    		$res = "Your subscription has been registered.";
	    	}
	    	else {	// Insert into receive_alert table 
	    		$this->add_receiver( array( 'user_id' => 0, 'email' => $email, 'story_category_id' => $cat_id, 'story_category_name' => $cat_name ) );
	    		$res = "Your subscription has been registered.";
	    	}
	    }
    	return $res;
    }

    // Add Subscriber
    private function add_receiver( $data ) {
    	$this->db->insert( 'receive_alert', $data );
    }

    // Fetch all active subscriber's email IDs
    public function get_receiver_emails($category) {
        $result = array();
    	$this->db->select( 'email,story_category_id,story_category_name' )
    		->from( 'receive_alert' )
    		->where( array( 'story_category_id' => $category, 'is_subscribed' => 1 ) );
        $this->db->order_by( 'id', 'DESC' );
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    // Get Category Name by cat id
    public function get_category_name( $cat_id ) {
        $this->db->select( 'categoryName' )
            ->from( 'categories' )
            ->where( array( 'category_Id' => $cat_id ) );
        
        $row = $this->db->get()->row_array();
        return $row['categoryName'];
    }

    // unsbscribe News Alert by category
    function unsubscribe_alert($category_id, $email, $reason) {
        $this->db->where( array( 'email' => $email, 'story_category_id' => $category_id ) )
            ->set( array( 'is_subscribed' => 0, 'unsubscribe_reason' => $reason, ) )
            ->update('receive_alert');
        if( $this->db->affected_rows() == true ) {
            return 'Unsuscribed successfully!';
        }
        else{
            return 'Error: something is wrong!';
        }
    }
}