<?php
// Get all active children comments
function child_comments( $parent_id ) {
	$ci = & get_instance();
	$ci->db->select("*")->from('comments');

	$ci->db->where( array( 'status' => 1, 'published' => 1, 'parent_id' => $parent_id, 'comment_level' => 1 ) );
    $ci->db->order_by('id', 'ASC');
    $query = $ci->db->get();

    return $query->result_array();
}

// Get all active parent comments
function parent_comments( $content_id ) {
	$ci = & get_instance();
	$ci->db->select("*")->from('comments');
	$ci->db->where( array( 'content_id' => $content_id, 'status' => 1, 'published' => 1, 'parent_id' => 0 ) );
    $ci->db->order_by('id', 'ASC');
    $query = $ci->db->get();

    return $query->result_array();
}

// Get all active comments
function get_active_comments_or_by_news_id( $news_id ) {
	$ci = & get_instance();
    $ci->db->order_by( 'created_on', 'DESC' );
    $ci->db->where( array( 'status' => 1, 'published' => 1, 'content_id' => $news_id ) );
    $query = $ci->db->get( 'comments' );

    return $query->result_array();
}

// Get days from posted date
function get_days_difference( $date_1, $date_2 ) {
	$date_1 	= new DateTime( $date_1 );
  	$date_2 	= new DateTime( $date_2 );
  	$interval 	= date_diff( $date_1, $date_2 );
  	$days 		= $interval->days;
  	
  	if( $days == 0 )
        $days_ago = "Today";
    else if( $days == 1 )
        $days_ago = $days. " Day Ago";
    else if( $days > 1 )
        $days_ago = $days. " Days Ago";

  	return $days_ago;
}

// Detect browsing device
function detectDevice() {
    $userAgent = $_SERVER["HTTP_USER_AGENT"];
    $devicesTypes = array(
        "computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
        "tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
        "mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
        "bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis"),
    );
    foreach($devicesTypes as $deviceType => $devices) {           
        foreach($devices as $device) {
            if(preg_match("/" . $device . "/i", $userAgent)) {
                $deviceName = $deviceType;
            }
        }
    }
    return ucfirst( $deviceName );
}

// Count number of rows of likes into likes_map table
function count_comment_likes( $comment_id, $user_id, $like_type ) {
	$ci = & get_instance();
    $query = $ci->db->select( "*" )
        ->from( "comment_likes" )
        ->where( array( 'comment_id' => $comment_id, 'user_id' => $user_id, 'like_type' => $like_type ) )
        ->get();
    $total_likes = $query->num_rows();

    return $total_likes; 
}

// Count total comments on a news
function count_all_comments_by_news_id( $news_id ) {
    $ci = & get_instance();
    $total_comments = 0;
    $query = $ci->db->select( "*" )
        ->from( "comments" )
        ->where( array( 'content_id' => $news_id ) )
        ->get();
    $total_comments = $query->num_rows();

    return $total_comments; 
}

// Get all likes by news id
function get_likes_by_news_id( $news_id ) {
    $result = array();
    $ci = & get_instance();
    $ci->db->select( "likes" )->from( "spidypick" )->where( 'spidypickId', $news_id );
    $result = $ci->db->get()->result();

    if( ! empty( $result ) ) {
        return $result;
    }
}

function get_likes_by_comment_id( $comment_id, $like_type ) {
    $result = array();
    $ci = & get_instance();
    $like_dislike = $like_type == 1 ? 'likes' : 'dislikes';

    $ci->db->select( $like_dislike )->from( "comments" )->where( 'id', $comment_id );
    $result = $ci->db->get()->result();

    if( ! empty( $result ) ) {
        return $result;
    }
}

function get_likes_dislikes_by_comment_id( $comment_id ) {
    $result = array();
    $ci = & get_instance();

    $ci->db->select( 'likes,dislikes' )->from( "comments" )->where( 'id', $comment_id );
    $result = $ci->db->get()->result();

    if( ! empty( $result ) ) {
        return $result;
    }
}

// Count number of rows of likes into likes_map table
function count_news_likes( $news_id, $user_id ) {
    $result = array();
    $ci = & get_instance();
    $query = $ci->db->select( "*" )
        ->from( "likes_map" )
        ->where( array( 'content_id' => $news_id, 'user_id' => $user_id ) )
        ->get();
    $result = $query->num_rows();

    if( ! empty( $result ) ) {
        return $result;
    }
}

// Count all replies of a comment
function count_all_replies_by_comment_id( $comment_id ) {
    $ci = & get_instance();
    $total_replies = 0;
    $replies = "";
    $query = $ci->db->select( "*" )
        ->from( "comments" )
        ->where( array( 'parent_id' => $comment_id, 'status' => 1 ) )
        ->get();
    $total_replies = $query->num_rows();
    if( $total_replies > 0 ) {
        if( $total_replies == 1 ) {
            $replies = $total_replies . ' Reply';
        }
        else if( $total_replies > 1 ) {
            $replies = $total_replies . ' Replies';
        }
    }

    return $replies; 
}