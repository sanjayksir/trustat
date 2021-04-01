<?php

							$domain_name = $_SERVER['SERVER_NAME'];
							//echo $domain_name;

							if($domain_name=='trustat.in') {
								$link = mysql_connect('127.0.0.1','trustat_trdbun','db.up@12live');
								mysql_select_db('trustat_trdblivedb', $link);
								// this is Live Server
								}
							
							if($domain_name=='mtrck.in') {
								$link = mysql_connect('127.0.0.1','mtrck_tpdbuser','TP.P@wdd#1!@2dbu');
								mysql_select_db('mtrck_trackingportaltestingdb', $link);
								// this is Testing Server
								}
								
							if($domain_name=='innovigents.com') {
								$link = mysql_connect('127.0.0.1','innovige_dbuserdev','db.up@12dev');
								mysql_select_db('innovige_trdbdev', $link);
								// this is Development Server
								}

							if($domain_name=='localhost') {									
								$link = mysql_connect('localhost','root','');
								mysql_select_db('trackingportaldblocal', $link);
							// this is localhost			
								} 
								
?>

