<?php


					$domain_name = $_SERVER['SERVER_NAME'];
							echo $domain_name;

							if($domain_name=='trustat.in') {
								$servername = "127.0.0.1";
								$username = "trustat_trdbun";
								$password = "db.up@12live";
								$dbname = "trustat_trdblivedb";
								// this is Live Server
								}
							
							if($domain_name=='mtrck.in') {
								$servername = "127.0.0.1";
								$username = "mtrck_tpdbuser";
								$password = "TP.P@wdd#1!@2dbu";
								$dbname = "mtrck_trackingportaltestingdb";
								// this is Testing Server
								}
								
							if($domain_name=='innovigents.com') {
								$servername = "127.0.0.1";
								$username = "innovige_dbuserdev";
								$password = "db.up@12dev";
								$dbname = "innovige_trdbdev";
								// this is Development Server
								}

							if($domain_name=='localhost') {									
								$servername = "localhost";
								$username = "root";
								$password = "";
								$dbname = "trackingportaldblocal";	
								// this is localhost			
								} 

								
?>