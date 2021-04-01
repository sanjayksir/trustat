<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
</head>
<body>

		<?php
                 	   function UserAgentRegCheck($regText)
                {
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    return preg_match('@('.$regText.')@', $useragent);
                }

                function isIphone() {
                    return UserAgentRegCheck('iPad|iPod|iPhone');
                }

                function isAndroid() {
                    return UserAgentRegCheck('Android');
                }

                function isMobile(){
                    return UserAgentRegCheck('iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS');
                }
			?>
			
				<?php if(isIphone()) { ?>
								  <script type="text/javascript">
										window.location = "https://apps.apple.com/in/app/snapchat/id447188370";
									</script>
							<?php  }else { ?>
								 <script type="text/javascript">
									window.location = "https://play.google.com/store/apps/details?id=com.snapchat.android&hl=en";
								</script>
							<?php } ?>		

</body>
</html>