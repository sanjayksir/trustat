<?php

							$domain_name = $_SERVER['SERVER_NAME'];
							echo $domain_name;

							if($domain_name=='trustat.in') {
								mysql_connect("127.0.0.1", "trustat_trdbun", "db.up@12live");
								mysql_select_db("trustat_trdblivedb");
								// this is Live Server
								}
							
							if($domain_name=='mtrck.in') {
								mysql_connect("127.0.0.1", "mtrck_tpdbuser", "TP.P@wdd#1!@2dbu");
								mysql_select_db("mtrck_trackingportaltestingdb");
								// this is Testing Server
								}
								
							if($domain_name=='innovigents.com') {
								mysql_connect("127.0.0.1", "innovige_dbuserdev", "db.up@12dev");
								mysql_select_db("innovige_trdbdev");
								// this is Development Server
								}

							if($domain_name=='localhost') {									
								mysql_connect("localhost", "root", "");
								mysql_select_db("trackingportaldblocal");	
							// this is localhost			
								} 
								
							
								
								
?>