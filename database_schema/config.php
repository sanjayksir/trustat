
			<?php

							$domain_name = $_SERVER['SERVER_NAME'];
							//echo $domain_name;

							if($domain_name=='trustat.in') {								
								$db_user = "trustat_trdbun"; 
								$db_password = "db.up@12live";
								$database = "trustat_trdblivedb";
								$server = "127.0.0.1";								
								// this is Live Server
								}
							
							if($domain_name=='mtrck.in') {								
								$db_user = "mtrck_tpdbuser"; 
								$db_password = "TP.P@wdd#1!@2dbu";
								$database = "mtrck_trackingportaltestingdb";
								$server = "127.0.0.1";								
								// this is Testing Server
								}
								
							if($domain_name=='innovigents.com') {
								$db_user = "innovige_dbuserdev"; 
								$db_password = "db.up@12dev";
								$database = "innovige_trdbdev";
								$server = "127.0.0.1";
								// this is Development Server
								}

							if($domain_name=='localhost') {	
								$db_user = "root"; 
								$db_password = "";
								$database = "trackingportaldblocal";
								$server = "127.0.0.1";

							// this is localhost			
								} 
								
?>