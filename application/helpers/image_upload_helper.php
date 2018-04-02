<?php

/*require_once 'config.php';

$data = array();

if( isset( $_POST['image_upload'] ) && !empty( $_FILES['images'] )){

	upload_image_n_thumb( $_FILES['images'] , '');

} else {

	$data[] = 'No Image Selected..';

}*/



function upload_image_n_thumb($files , $folderPath, $thumb_folder_name=''){

 	//get the structured array

	 //$images = restructure_array(  $_FILES );

	

	 //echo '***==><pre>'.print_r($images);exit;

	$allowedExts = array("gif", "jpeg", "jpg", "png");

	

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

		$ip = $_SERVER['HTTP_CLIENT_IP'];

	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

	} else {

		$ip = $_SERVER['REMOTE_ADDR'];

	}

	

	// foreach ( $images as $key => $value){

		//$i = $key+1;

		//create directory if not exists

		if (!file_exists($folderPath)) {

			mkdir('images', 0777, true);

		}

 $i=0;

		$image_name =strtolower( normalizeString($files['name']));

 		//$image_name = get_unique_file($image_name);

 		//get image extension

		$ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

		

 		$file_base_name = basename($image_name, '.'.$ext);

		

		//assign unique name to image

		$name = $file_base_name.'_'.time().'.'.$ext; 

		//$name = $image_name;

		//image size calcuation in KB

		$image_size = $files["size"] / 1024;

		$image_flag = true;

		//max image size

		$max_size = 2000;

		if( in_array($ext, $allowedExts) && $image_size < $max_size ){

			$image_flag = true;

		} else {

			$image_flag = false;

			$data[$i]['error'] = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';

		} 

		

		if( $files["error"] > 0 ){

			$image_flag = false;

			$data[$i]['error'] = '';

			$data[$i]['error'].= '<br/> '.$image_name.' Image contains error - Error Code : '.$files["error"];

		}

		

		if($image_flag){

			move_uploaded_file($files["tmp_name"], './'.$folderPath.'/'.$name);

			$src = './'.$folderPath."/".$name;

			$dist ='./'.$folderPath. "/".$thumb_folder_name.'/'."thumb_".$name;

			$data[$i]['success'] = $thumbnail = $name;

			thumbnail($src, $dist, 200);

			//$data['suc']='success';

  		}

	// }

 	return json_encode($data);

 }



function restructure_array(array $images)

{

	$result = array();



	foreach ($images as $key => $value) {

		foreach ($value as $k => $val) {

			for ($i = 0; $i < count($val); $i++) {

				$result[$i][$k] = $val[$i];

			}

		}

	}



	return $result;

}

  

function thumbnail($src, $dist, $dis_width = 100 ){

	$img = '';

	$extension = strtolower(strrchr($src, '.'));

	switch($extension)

	{

		case '.jpg':

		case '.jpeg':

			$img = @imagecreatefromjpeg($src);

			break;

		case '.gif':

			$img = @imagecreatefromgif($src);

			break;

		case '.png':

			$img = @imagecreatefrompng($src);

			break;

	}

	$width = imagesx($img);

	$height = imagesy($img);









	$dis_height = $dis_width * ($height / $width);



	$new_image = imagecreatetruecolor($dis_width, $dis_height);

	imagecopyresampled($new_image, $img, 0, 0, 0, 0, $dis_width, $dis_height, $width, $height);





	$imageQuality = 100;



	switch($extension)

	{

		case '.jpg':

		case '.jpeg':

			if (imagetypes() & IMG_JPG) {

				imagejpeg($new_image, $dist, $imageQuality);

			}

			break;



		case '.gif':

			if (imagetypes() & IMG_GIF) {

				imagegif($new_image, $dist);

			}

			break;



		case '.png':

			$scaleQuality = round(($imageQuality/100) * 9);

			$invertScaleQuality = 9 - $scaleQuality;



			if (imagetypes() & IMG_PNG) {

				imagepng($new_image, $dist, $invertScaleQuality);

			}

			break;

	}

	imagedestroy($new_image);}

	

	

##----------- create file name sanitizer ----------------##

 function normalizeString ($str = '')

	{

		$str = strip_tags($str); 

		$str = preg_replace('/[\r\n\t ]+/', ' ', $str);

		$str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);

		//$str = strtolower($str);

		$str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );

		$str = htmlentities($str, ENT_QUOTES, "utf-8");

		$str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);

		$str = str_replace(' ', '-', $str);

		$str = rawurlencode($str);

		$str = str_replace('%', '-', $str);

		return $str;

	}

	##----------- create file name sanitizer ----------------##

	

	function get_unique_file($updir,$newfilename )

	{

		if(empty($newfilename))

		{

			return $error_msg="No File";

		}

		$ext = pathinfo( $newfilename, PATHINFO_EXTENSION);

		$file = basename($newfilename,'.'.$ext);						

		$ext = pathinfo( $newfilename, PATHINFO_EXTENSION);

		$counter=1;

		while(file_exists($updir.$newfilename)) { 

			$updir.$newfilename;

			$newfilename=$file. $counter  .'.'. $ext;

			$counter++;

		}

		return $newfilename;

	}

	

	



