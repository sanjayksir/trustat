<?php

function getSpideyUserDetail($uid) {
    $ci = &get_instance();
    $row = $ci->db
            ->select('user_id ,u_name ,user_name')
            ->from('backend_user')
            ->where('user_id', $uid)
            ->get()
            ->result_array();
    return $row[0]['u_name'];
}
function getSpideyCategoryName($uid) {
    $ci = &get_instance();
    $row = $ci->db
            ->select('categoryName')
            ->from('categories')
            ->where('category_Id', $uid)
            ->get()
            ->result_array();
    return $row[0]['categoryName'];
}
function getCategoryDetail($uid) {
    $ci = &get_instance();
    $row = $ci->db
            ->select('is_main')
            ->from('categories')
            ->where('category_Id', $uid)
            ->get()
            ->result_array();
    return $row[0]['is_main'];
}
function getSpidypickViewCount($s_id) {
    $ci = &get_instance();
    $row = $ci->db
                    ->select_sum('count')
                    ->from('pageview_hits')
                    ->where('story_id', $s_id)
                    ->get()
                    ->result_array();
    return $row[0]['count'];
}

function getSpidypickCommentsCount($s_id) {
    $ci = &get_instance();
    $row = $ci->db
                    ->select('count(id) as count')
                    ->from('comment')
                    ->where('content_id', $s_id)
                    ->where('content_type', '1')
                    ->get()
                    ->result_array();
    return $row[0]['count'];
}
////////////  for pushwoosh start /////////////
function pushNotification($rwaid, $yearmonth, $filename_photo, $selectUsertoNotify, $selected_users, $title, $uploadImage, $type = '', $remoturl = '', $states = '') {
    $bannerPath = '';
    /* if ($uploadImage != '')
      $bannerPath = getPushBanner($yearmonth, $filename_photo); */
    $users = '';
    if ($selectUsertoNotify == 1 || $selectUsertoNotify == 2) {
        $users = $selected_users;
    }

    $deviceList = getUserDevice($rwaid, $users, $type, $states);

    $i = 0;
    $devices[$i] = array();
    $c = 1;
    foreach ($deviceList AS $ek => $ev) {
        $devices[$i][] = $ev['deviceid'];
        $c++;
        if ($c == 1001) {
            $i++;
            $c = 1;
        }
    }

    foreach ($devices AS $dk => $dv) {
        pwCall('createMessage', array(
            'application' => PW_APPLICATION,
            'auth' => PW_AUTH,
            'notifications' => array(
                array(
                    'send_date' => 'now',
                    'content' => $title,
                    'data' => array('url' => $remoturl),
                    'android_banner' => $bannerPath,
                    'devices' => 'e1527ca93dd77bad'//$dv
                )
            )
                )
        );
    }
}

////////////  for pushwoosh end /////////////
////////////  Image crop function for pushwoosh start /////////////
function getPushBanner($yearmonth, $filename) {
    $filename = strtolower($filename);
    $exts = pathinfo($filename);
    if (empty($exts['filename']))
        $exts['filename'] = substr($exts['basename'], 0, -(strlen($exts['extension']) + 1));
    $new_filename = $exts['filename'] . "-t." . $exts['extension'];

    $fn = MEDIA_URL_NOTICEBOARD . $yearmonth . '/' . $filename;
    $size = getimagesize($fn);
    $width = 400;
    $height = 200;

    $src = imagecreatefromstring(file_get_contents($fn));
    $dst = imagecreatetruecolor($width, $height);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
    imagedestroy($src);



    imagejpeg($dst, MEDIA_ABSPATH_NOTICEBOARD . $yearmonth . '/' . $new_filename);
    imagedestroy($dst);
    return MEDIA_URL_NOTICEBOARD . $new_filename;
}

////////////  Image crop function for pushwoosh end /////////////
////////////  Pushwoosh function start /////////////
function pwCall($method, $data) {
    $url = 'https://cp.pushwoosh.com/json/1.3/' . $method;
    $request = json_encode(['request' => $data]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
}

////////////  Pushwoosh function end /////////////

function getUserDevice($rwaid = '', $user = '', $type, $states = '') {

    $ci = &get_instance();

    $ci->db->where(['deviceid!=' => '', 'status' => 1]);
    if ($type == 'grpadmin' || $type == 'grpmember' || $type == 'user') {
        $ci->db->where(['userid' => $user, 'usertype' => 1]);
    } else if ($type == 'rwaadmin') {
        $ci->db->where(['userid' => $user, 'usertype' => 2]);
    } else if ($type == 'grpmembers') {
        $ci->db->where('usertype', 1);
        $ci->db->where_in('userid', $user);
    } else if ($type == 'rwamembers') {
        $ci->db->where(['rwaid' => $rwaid, 'usertype' => 1]);
    } else if ($type == 'all' && $states != '') {
        $ci->db->where_in('state', $states);
        $ci->db->where('usertype', 1);
    } else if ($type == 'all' && $states == '') {
        $ci->db->where('usertype', 1);
    } else {
        $ci->db->where(['usertype' => 1, 'rwaid' => $rwaid]);
        $ci->db->where_in('userid', $user);
    }

    return $ci->db
                    ->select('deviceid')
                    ->from('userdetails')
                    ->get()
                    ->result_array();
}

// Page View Hit Counter
function page_view_counter( $story_id ) {
    $ci = &get_instance();
    $ip = $ci->input->ip_address();
    $user_agent = $ci->input->user_agent();

    $row = $ci->db->select('story_id')
        ->from('pageview_hits')
        ->where('story_id', $story_id)
        ->get();
    $story_exists = $row->num_rows();

    if($story_exists > 0) { // Update pageview_hits table
        $ci->db->query( 'UPDATE pageview_hits SET count=count+1, updated_on="'.date('Y-m-d h:i:s').'" WHERE story_id="'.$story_id.'"' );
    }
    else { // Insert record into pageview_hits
        $insert_data = array('story_id'=>$story_id, 'count'=>'1', 'created_on'=>date('Y-m-d h:i:s'));
        $ci->db->insert('pageview_hits', $insert_data);
        //$story_id = $ci->db->insert_id();
    }

    // Add Page View Information
    $pageinfo_data = array(
        'story_id'  => $story_id,
        'ip_address'=> $ip,
        'user_agent'=> $user_agent,
        'datetime'  => date('Y-m-d h:i:s')
    );
    $ci->db->insert('pageview_info', $pageinfo_data);
}
?>