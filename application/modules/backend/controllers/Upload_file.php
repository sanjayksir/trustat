<?php defined('BASEPATH') OR exit('No direct script access allowed');  

 class Upload_file extends CI_Controller {

	function __construct(){

		parent::__construct();		 

		//$this->islogin(); 		

 		$this->load->helper(array('form','url'));

	}

	

	function  log2($str){

     // log to the output

    	$log_str = date('d.m.Y').": {$str}\r\n";

    	echo $log_str;

     // log to file

		if (($fp = fopen(TEMP_DIR.'upload_log.txt', 'a+')) !== false) {

			fputs($fp, $log_str);

			fclose($fp);

		}

	}



 	public function upload(){

		header('Access-Control-Allow-Origin: *');

		error_reporting(E_ALL & ~E_NOTICE);

		ini_set('display_errors',1); 

		ini_set('max_execution_time', 9500);

		set_time_limit (9500);	

 	//check if request is GET and the requested chunk exists or not. this makes testChunks work

		if ($_SERVER['REQUEST_METHOD'] === 'GET') { //echo 'kamal';exit;

			$temp_dir = TEMP_DIR.$_GET['resumableIdentifier'];

			$chunk_file = $temp_dir.'/'.$_GET['resumableFilename'].'.part'.$_GET['resumableChunkNumber'];

			if (file_exists($chunk_file)) {

				 header("HTTP/1.0 200 Ok");

			   } else

			   {

				 header("HTTP/1.0 404 Not Found");

			   }

			}



		// loop through files and move the chunks to a temporarily created directory

		if (!empty($_FILES)) foreach ($_FILES as $file) {

			// check the error status

			if ($file['error'] != 0) {

				$this->log2('error '.$file['error'].' in file '.$_POST['resumableFilename']);

				continue;

			}

		

			// init the destination file (format <filename.ext>.part<#chunk>

			// the file is stored in a temporary directory

			$temp_dir = TEMP_DIR.$_POST['resumableIdentifier'];

			$dest_file = $temp_dir.'/'.$_POST['resumableFilename'].'.part'.$_POST['resumableChunkNumber']; 

		

			// create the temporary directory

			 if (!is_dir($temp_dir)){

				 mkdir($temp_dir, 0777, true);

				 $this->log2('error '.$file['error'].' in file '.$_POST['resumableFilename']);

			} 

			 

			// move the temporary file

			if (!move_uploaded_file($file['tmp_name'], $dest_file)) { 

			

			   $this->log2('Error saving (move_uploaded_file) chunk '.$_POST['resumableChunkNumber'].' for file '.$_POST['resumableFilename']);

			} 

			if($_POST['resumableChunkNumber'] ==$_POST['totalChunk']){

			   // check if all the parts present, and create the final destination file

			   $this->createFileFromChunks($temp_dir, $_POST['resumableFilename'],$_POST['resumableChunkSize'], $_POST['resumableTotalSize']);

			}				

		}

 	}

	

	public function uploadFile(){

		$this->load->view('upload/upload_tpl');

	}

	

	function rrmdir($dir){

		if (is_dir($dir)) {

			$objects = scandir($dir);

			foreach ($objects as $object) {

				if ($object != "." && $object != "..") {

					if (filetype($dir . "/" . $object) == "dir") {

					   $this->rrmdir($dir . "/" . $object); 

					} else {

						unlink($dir . "/" . $object);

					}

				}

			}

			reset($objects);

			rmdir($dir);

		}

	}

	

	function createFileFromChunks($temp_dir, $fileName, $chunkSize, $totalSize) {

    /*$dpath = IMAGEDISKPATH.date('Y').'/'.date('m').'/31';

	if (!is_dir($dpath)) {

		mkdir($dpath, 0777, true);

	}*/

    // count all the parts of this file

    $total_files = 0;

    foreach(scandir($temp_dir) as $file) {

        if (stripos($file, $fileName) !== false) {

            $total_files++;

        }

    }

 	// create the final destination file 

	if (($fp = fopen(TEMP_DIR.''.$fileName, 'w')) !== false) {

		for ($i=1; $i<=$total_files; $i++) {

			fwrite($fp, file_get_contents($temp_dir.'/'.$fileName.'.part'.$i));

			//$this->log2('writing chunk '.$i);

		}

		fclose($fp);

		 $filename = TEMP_DIR.$fileName;

		$finfo =  finfo_open(FILEINFO_MIME, "");

		$mime_type = finfo_file($finfo, $filename);

		finfo_close($finfo);

		$miArr = explode(";",$mime_type);

		$mArr = explode("/",$miArr[0]);  

    	// echo '<pre>'; print_r($TEMP_DIR);

		if($mArr[0] !='video' && $mArr[1] !='ogg' && $mArr[1] !='octet-stream'){echo basename($filename); @unlink($filename); }else{ echo basename($filename);//copy($filename, TEMP_WATCH.$fileName); @unlink($filename); //createImageFolder(); 

		}

	} else {

		$this->log2('cannot create the destination file');

		return false;

	}



	// rename the temporary directory (to avoid access from other 

	// concurrent chunks uploads) and than delete it

	if (rename($temp_dir, $temp_dir.'_UNUSED')) {

		$this->rrmdir($temp_dir.'_UNUSED');

		} else {

		$this->rrmdir($temp_dir);

		}

	}

	

	

	###----------------Image Upload start -------------------##

 function uploadImages(){ // echo '<pre>';print_r($_FILES);

 $data = getimagesize($_FILES['files']['tmp_name'][0]);

 $width = $data[0];

 $height = $data[1];

 

 

	############ Configuration ##############

	$config["image_max_size"]               = $width; //Maximum image size (height and width)

	$config["thumbnail_size"]               = $width; //Thumbnails will be cropped to 200x200 pixels

	$config["thumbnail_prefix"]             = "thumb_"; //Normal thumb Prefix

	$config["destination_folder"]           = TEMP_DIR; //upload directory ends with / (slash)

	$config["thumbnail_destination_folder"] = TEMP_DIR; //upload directory ends with / (slash)

	$config["upload_url"]                   = base_url().'backend/product_attrribute/addStoryIdeaDetails';

	$config["quality"]                      = 90; //jpeg quality

	

	

	/*if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

		echo 'browser error';exit;  //try detect AJAX request, simply exist if no Ajax

	}*/



	if(!isset($_FILES['files']) || !is_uploaded_file($_FILES['files']['tmp_name'][0])){

  	 die('Image file is Missing!');

	}



//count total files in array

	$file_count = count($_FILES["files"]["name"]);



	if($file_count > 0){ //there are more than one file? no problem let's handle multiple files



    for ($x = 0; $x < $file_count; $x++){   //Loop through each uploaded file

   

        //if there's file error, display it

        if ($_FILES["files"]['error'][$x] > 0) {

            print $this->get_upload_error($x);

            exit;

        }



        //Get image info from a valid image file

        $im_info = getimagesize($_FILES["files"]["tmp_name"][$x]);

        if($im_info){

            $im["image_width"]  = $im_info[0]; //image width

            $im["image_height"] = $im_info[1]; //image height

            $im["image_type"]   = $im_info['mime']; //image type

        }else{

            die("Make sure image <b>".$_FILES["files"]["name"][$x]."</b> is valid image file!");

        }

       

        //create image resource using Image type and set the file extension

        switch($im["image_type"]){

            case 'image/png':

                $img_res =  imagecreatefrompng($_FILES["files"]["tmp_name"][$x]);

                $file_extension = ".png";

                break;

            case 'image/gif':

               $img_res = imagecreatefromgif($_FILES["files"]["tmp_name"][$x]);    

               $file_extension = ".gif";

               break;

            case 'image/jpeg':

            case 'image/pjpeg':

                $img_res = imagecreatefromjpeg($_FILES["files"]["tmp_name"][$x]);

                $file_extension = ".jpg";

                break;

            default:

                $img_res = 0;

        }

       

        //set our file variables

        $unique_id =  uniqid(); //unique id for random filename

        $new_file_name = $unique_id . $file_extension;

        $destination_file_save = $config["destination_folder"] . $new_file_name; //file path to destination folder

        $destination_thumbnail_save = $config["thumbnail_destination_folder"] . $config["thumbnail_prefix"]. $new_file_name; //file path to destination thumb folder



        if($img_res){

            ###### resize Image ########

            //Construct a proportional size of new image

            $image_scale    = min($config["image_max_size"]/$im["image_width"], $config["image_max_size"]/$im["image_height"]);

            $new_width      = ceil($image_scale * $im["image_width"]);

            $new_height     = ceil($image_scale * $im["image_height"]);

   

            //Create a new true color image

            $canvas  = imagecreatetruecolor($new_width, $new_height);

            $resample = imagecopyresampled($canvas, $img_res, 0, 0, 0, 0, $new_width, $new_height, $im["image_width"], $im["image_height"]);

            if($resample){

                $save_image = $this->save_image_file($im["image_type"], $canvas, $destination_file_save, $config["quality"]); //save image

                if($save_image){

                    echo $new_file_name;exit;//print '<img src="'.$config["upload_url"] . $new_file_name. '" />'; //output image to browser

                }

            }

           

            if(is_resource($canvas)){

              imagedestroy($canvas);  //free any associated memory

            }



           

            ###### Generate Thumbnail ########

           

            //Offsets

            /*if( $im["image_width"] > $im["image_height"]){

                $y_offset = 0;

                $x_offset = ($im["image_width"] - $im["image_height"]) / 2;

                $s_size     = $im["image_width"] - ($x_offset * 2);

            }else{

                $x_offset = 0;

                $y_offset = ($im["image_height"] - $im["image_width"]) / 2;

                $s_size = $im["image_height"] - ($y_offset * 2);

            }*/

           

            //Create a new true color image

           /* $canvas = imagecreatetruecolor($config["thumbnail_size"], $config["thumbnail_size"]);

            $resample = imagecopyresampled($canvas, $img_res, 0, 0, $x_offset, $y_offset, $config["thumbnail_size"], $config["thumbnail_size"], $s_size, $s_size);

            if($resample){

                $save_image = $this->save_image_file($im["image_type"], $canvas, $destination_thumbnail_save, $config["quality"] );

                if($save_image){

                    print '<img src="'.$config["upload_url"] . $config["thumbnail_prefix"]. $new_file_name. '" />';

                }

            }

           

            if(is_resource($canvas)){

              imagedestroy($canvas);  //free any associated memory

            }*/

         }

       }

	}

 }

 

 //funcion to save image file

function save_image_file($image_type, $canvas, $destination, $quality){

    switch(strtolower($image_type)){

        case 'image/png':

            return imagepng($canvas, $destination); //save png file

        case 'image/gif':

            return imagegif($canvas, $destination); //save gif file                

        case 'image/jpeg': case 'image/pjpeg':

            return imagejpeg($canvas, $destination, $quality);  //save jpeg file

        default:

            return false;

    }

}



function get_upload_error($err_no){

    switch($err_no){

        case 1 : return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';

        case 2 : return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';

        case 3 : return 'The uploaded file was only partially uploaded.';

        case 4 : return 'No file was uploaded.';

        case 5 : return 'Missing a temporary folder. Introduced in PHP 5.0.3';

        case 6 : return 'Failed to write file to disk. Introduced in PHP 5.1.0';

    }

}

	

	###----------------Image Upload end -------------------##

	

###----------------PDF Upload Start -------------------##	

 function uploadAttachment(){
 	$output_dir = "./uploads/";
 	if(isset($_FILES["files"]))
 	{
 		$ret = array();
 		$error =$_FILES["files"]["error"];
    	if(!is_array($_FILES["files"]['name'])) //single file
   		{
             $RandomNum   = time();
             $ImageName      = str_replace(' ','-',strtolower($_FILES['files']['name']));
             $ImageType      = $_FILES['files']['type']; //"image/png", image/jpeg etc.
  			//echo '<pre>===';print_r($ImageType);exit;
             $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
             $ImageExt       = str_replace('.','',$ImageExt);
             $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
             $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
        	 	move_uploaded_file($_FILES["files"]["tmp_name"],$output_dir. $NewImageName);
        	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];
 	       	 	 $ret[$fileName]= $output_dir.$NewImageName;
     	}else
    	{	
  			$ImageType      = $_FILES['files']['type']; //"image/png", image/jpeg etc.
 			  //echo '<pre>=www==';print_r( $_FILES);exit;
 			if($ImageType[0]=='application/pdf'){
            	$fileCount = count($_FILES["files"]['name']);
     			for($i=0; $i < $fileCount; $i++)
     			{
					$RandomNum   = time();
  					$ImageName      = str_replace(' ','-',strtolower($_FILES['files']['name'][$i]));
 					$ImageType      = $_FILES['files']['type'][$i]; //"image/png", image/jpeg etc.
  					$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
 					$ImageExt       = str_replace('.','',$ImageExt);
 					$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
 					$NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
 					$ret[$NewImageName]= $output_dir.$NewImageName;
 					move_uploaded_file($_FILES["files"]["tmp_name"][$i],$output_dir.$NewImageName );
     			}
 			}

    	}
    	echo $NewImageName;exit;
 	}
 }

###----------------PDF Upload End -------------------##		

function uploadAudio(){

	$output_dir = "./uploads/";

 

if(isset($_FILES["files"]))

{

	$ret = array();

 

	$error =$_FILES["files"]["error"];

   {

 

    	if(!is_array($_FILES["files"]['name'])) //single file

    	{

            $RandomNum   = time();

 

            $ImageName      = str_replace(' ','-',strtolower($_FILES['files']['name']));

            $ImageType      = $_FILES['files']['type']; //"image/png", image/jpeg etc.

 			

            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));

            $ImageExt       = str_replace('.','',$ImageExt);

            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);

            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

 

       	 	move_uploaded_file($_FILES["files"]["tmp_name"],$output_dir. $NewImageName);

       	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];

 

	       	 	 $ret[$fileName]= $output_dir.$NewImageName;

    	}

    	else

    	{

            $fileCount = count($_FILES["files"]['name']);

    		for($i=0; $i < $fileCount; $i++)

    		{

                $RandomNum   = time();

 

                $ImageName      = str_replace(' ','-',strtolower($_FILES['files']['name'][$i]));

                $ImageType      = $_FILES['files']['type'][$i]; //"image/png", image/jpeg etc.

 

                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));

                $ImageExt       = str_replace('.','',$ImageExt);

                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);

                $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

 

                $ret[$NewImageName]= $output_dir.$NewImageName;

    		    move_uploaded_file($_FILES["files"]["tmp_name"][$i],$output_dir.$NewImageName );

    		}

    	}

    }

    echo $NewImageName;exit;
}
}


###----------------PDF Upload Start -------------------##	

 function uploadUserManual(){
 	$output_dir = "./uploads/";
 	if(isset($_FILES["files"]))
 	{
 		$ret = array();
 		$error =$_FILES["files"]["error"];
    	if(!is_array($_FILES["files"]['name'])) //single file
   		{
             $RandomNum   = time();
             $ImageName      = str_replace(' ','-',strtolower($_FILES['files']['name']));
             $ImageType      = $_FILES['files']['type']; //"image/png", image/jpeg etc.
  			//echo '<pre>===';print_r($ImageType);exit;
             $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
             $ImageExt       = str_replace('.','',$ImageExt);
             $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
             $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
        	 	move_uploaded_file($_FILES["files"]["tmp_name"],$output_dir. $NewImageName);
        	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];
 	       	 	 $ret[$fileName]= $output_dir.$NewImageName;
     	}else
    	{	
  			$ImageType      = $_FILES['files']['type']; //"image/png", image/jpeg etc.
 			  //echo '<pre>=www==';print_r( $_FILES);exit;
 			if($ImageType[0]=='application/pdf'){
            	$fileCount = count($_FILES["files"]['name']);
     			for($i=0; $i < $fileCount; $i++)
     			{
					$RandomNum   = time();
  					$ImageName      = str_replace(' ','-',strtolower($_FILES['files']['name'][$i]));
 					$ImageType      = $_FILES['files']['type'][$i]; //"image/png", image/jpeg etc.
  					$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
 					$ImageExt       = str_replace('.','',$ImageExt);
 					$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
 					$NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
 					$ret[$NewImageName]= $output_dir.$NewImageName;
 					move_uploaded_file($_FILES["files"]["tmp_name"][$i],$output_dir.$NewImageName );
     			}
 			}

    	}
    	echo $NewImageName;exit;
 	}
 }

###----------------PDF Upload End -------------------##		

function uploadDemoAudio(){

	$output_dir = "./uploads/";

 

if(isset($_FILES["files"]))

{

	$ret = array();

 

	$error =$_FILES["files"]["error"];

   {

 

    	if(!is_array($_FILES["files"]['name'])) //single file

    	{

            $RandomNum   = time();

 

            $ImageName      = str_replace(' ','-',strtolower($_FILES['files']['name']));

            $ImageType      = $_FILES['files']['type']; //"image/png", image/jpeg etc.

 			

            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));

            $ImageExt       = str_replace('.','',$ImageExt);

            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);

            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

 

       	 	move_uploaded_file($_FILES["files"]["tmp_name"],$output_dir. $NewImageName);

       	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];

 

	       	 	 $ret[$fileName]= $output_dir.$NewImageName;

    	}

    	else

    	{

            $fileCount = count($_FILES["files"]['name']);

    		for($i=0; $i < $fileCount; $i++)

    		{

                $RandomNum   = time();

 

                $ImageName      = str_replace(' ','-',strtolower($_FILES['files']['name'][$i]));

                $ImageType      = $_FILES['files']['type'][$i]; //"image/png", image/jpeg etc.

 

                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));

                $ImageExt       = str_replace('.','',$ImageExt);

                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);

                $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

 

                $ret[$NewImageName]= $output_dir.$NewImageName;

    		    move_uploaded_file($_FILES["files"]["tmp_name"][$i],$output_dir.$NewImageName );

    		}

    	}

    }

    echo $NewImageName;exit;
}
}	


}

