<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
</head>
<body>

<?php
  $lat= 26.754347; //latitude
  $lng= 81.001640; //longitude
  $address= getaddress($lat,$lng);
  if($address)
  {
    echo $address."F";
  }
  else
  {
    echo "Not found";
  }
?>

</body>
</html>