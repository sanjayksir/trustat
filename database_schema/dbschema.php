<?php
require 'config.php';

// connect to server
mysql_connect($server, $db_user, $db_password) or die ("Could not connect to the Server!" . mysql_errno() . ": " . mysql_error() );

// select database
mysql_select_db($database) or die ("Could not select the Database!" . mysql_errno() . ": " . mysql_error() );
//include('check_login.php');
?>

<?php


$sql = "SHOW TABLES FROM $database";
$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
echo "Database Name : " . $database;
echo "<br> List of tables with data fields and data types is here <br> <br>";
$i = 1;
while ($row = mysql_fetch_row($result)) {	
    echo $i . "-". $row[0];	
	$i++;	
	 $query = "SHOW COLUMNS FROM $row[0]";
        if($output = mysql_query($query)):
            $columns = array();
            while($result1 = mysql_fetch_assoc($output)):
                $columns[] = "<b>".$result1['Field']."</b> ".$result1['Type'];
            endwhile;
        endif;
        echo '<pre>';
        print_r($columns);
        echo '</pre>';	
}

mysql_free_result($result);
?>

<?php
		/*
        $table = 'consumers';
        $query = "SHOW COLUMNS FROM $table";
        if($output = mysql_query($query)):
            $columns = array();
            while($result = mysql_fetch_assoc($output)):
                $columns[] = $result['Field'];
            endwhile;
        endif;
        echo '<pre>';
        print_r($columns);
        echo '</pre>';
		*/
?>
<button onclick="window.print()">Save this page as PDF</button>

