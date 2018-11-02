<?php
$Dir="./";
	$target1 = $Dir . basename( $_FILES['f1']['name']) ;
	//$profileName=$cn.$_FILES['f1']['name'];
	if(@move_uploaded_file($_FILES['f1']['tmp_name'], $target1)){
   echo "File Uploaded <a href='data.php'>OK</a>";
   }else {
   echo "Sorry, there was a problem uploading your file.";}
   ?>