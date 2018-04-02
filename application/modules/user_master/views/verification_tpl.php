<!DOCTYPE html>

<html lang="en">

	<head>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<meta charset="utf-8" />

		<title>Hozzt Login</title>

 		<meta name="description" content="User login page" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE, NO-STORE, must-revalidate">

        <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

        <META HTTP-EQUIV="EXPIRES" CONTENT=0>



<script src="<?php echo ASSETS_PATH;?>js/jquery-2.1.4.min.js"></script>

		<!-- bootstrap & fontawesome -->

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />

		<link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />



		<!-- text fonts -->

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fonts.googleapis.com.css" />



		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.min.css" />



		<!--[if lte IE 9]>

			<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.min.css" />

		<![endif]-->

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-rtl.min.css" />



		<!--[if lte IE 9]>

		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.min.css" />

		<![endif]-->



		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->



		<!--[if lte IE 8]>

		<script src="<?php echo base_url();?>assets/js/html5shiv.min.js"></script>

		<script src="<?php echo base_url();?>assets/js/respond.min.js"></script>

		<![endif]-->

         

                                                        

	</head>



	<body class="login-layout">

		<div class="main-container">

			<div class="main-content">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1">

						<div class="col-sm-12">

							<div class="center">

							 
							</div>



							<div class="space-6"></div>

	<div class="toolbar clearfix" style="margin-top:100px;">
<?php if($this->session->flashdata('success')!=''){ ?> <div class="alert alert-block alert-success">
									 
										<a style="color:#000099" class="close" href="<?php echo base_url().'login/';?>">Login</a>
									 

									<i class="ace-icon fa fa-check green"></i>

									<?php echo $this->session->flashdata('success'); ?>
								</div>
                        <?php } ?> 
										</div>

							 
 						</div>

					</div><!-- /.col -->

				</div><!-- /.row -->

			</div><!-- /.main-content -->

		</div><!-- /.main-container -->



		<!-- basic scripts -->



		<!--[if !IE]> -->

		<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>



		<!-- <![endif]-->



		<!--[if IE]>

<script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>

<![endif]-->

		<script type="text/javascript">

			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");

		</script>



		<!-- inline scripts related to this page -->

		<script type="text/javascript">

			jQuery(function($) {

			 $(document).on('click', '.toolbar a[data-target]', function(e) {

				e.preventDefault();

				var target = $(this).data('target');

				$('.widget-box.visible').removeClass('visible');//hide others

				$(target).addClass('visible');//show target

			 });

			});

			 

			//you don't need this, just used for changing background

			jQuery(function($) {

			 $('#btn-login-dark').on('click', function(e) {

				$('body').attr('class', 'login-layout');

				$('#id-text2').attr('class', 'white');

				$('#id-company-text').attr('class', 'blue');

				

				e.preventDefault();

			 });

			 $('#btn-login-light').on('click', function(e) {

				$('body').attr('class', 'login-layout light-login');

				$('#id-text2').attr('class', 'grey');

				$('#id-company-text').attr('class', 'blue');

				

				e.preventDefault();

			 });

			 $('#btn-login-blur').on('click', function(e) {

				$('body').attr('class', 'login-layout blur-login');

				$('#id-text2').attr('class', 'white');

				$('#id-company-text').attr('class', 'light-blue');

				

				e.preventDefault();

			 });
 			});

 			function ValidateEmail(email)   
			{  
				 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))  
				  { 
					return (true)  
				  }  
					return (false)  
			}  
 
			function validateForgotPass(){

 				var url = "<?php echo base_url().'backend/spidey_forgot_pass';?>";

				var email =  $('#email').val();

 				$('#email').css('border', '');

 				$('#eror_msg_forgot').hide();

				

				if(email==''){

					$('#email').css('border', '1px dotted red');

					return false;

				}

				if(email!='' && ValidateEmail(email)==false){

 					$('#email').css('border', '1px dotted red');

					return false;

				}

				$.ajax({

					'url': url,

					data:{"email":email},

					beforeSend: function() {

						$("#displayAfterForgot").show();

						$("#submitbtnForgot").hide();

					},

					//dataType:"post",

					type:"POST",

					success:function(msg){

						if(msg.trim()=='0' || parseInt(msg.trim())==0 || msg.trim()==0){

							$('#eror_msg_forgot').html('Your Password is Sent to your Email ID!').css('color', 'green').show().delay(5000).fadeOut('slow');;
							$("#email").val('');
							$("#displayAfterForgot").hide();
 							$("#submitbtnForgot").show();

						}else{

							$('#eror_msg_forgot').html('Error..IN Sending Mail!').css('color', 'red').show().delay(5000).fadeOut('slow');;

							$("#displayAfterForgot").hide();

							$("#submitbtnForgot").show();

						}

					}					

				})

				 return false;

			}
 			function validateLogin(){  

				var url = "<?php echo base_url().'backend/getLoggedIn';?>";
				var username =  $('#username').val();
				var password =  $('#password').val();
				$('#username').css('border', '');
				$('#password').css('border', '');
				$('#eror_msg').hide();
				<!--if(username=='' && password==''){-->
				if(username==''){
					$('#username').css('border', '1px dotted red');
					$('#password').css('border', '1px dotted red');
					return false;
				}else if(username==''){
					$('#username').css('border', '1px dotted red');
					return false;
				}
				$.ajax({
					'url': url,
					data:{"username":username, "password":password},
					beforeSend: function() {
						$("#displayAfter").show();
						$("#submitbtn").hide();
					},
					type:"POST",
					success:function(msg){

						if( $.trim(msg)!=0 ){//alert(msg);

							if($.trim(msg)=='admin' ){

								window.location.href="<?php echo base_url();?>backend/dashboard";

							}else if($.trim(msg)=='reporter') {

								//window.location.href="<?php echo base_url();?>backend/editorial/listing";

								window.location.href="<?php echo base_url();?>backend/dashboard";

							}else if($.trim(msg)=='input') {

								//window.location.href="<?php echo base_url();?>backend/editorial/manage/";

								window.location.href="<?php echo base_url();?>backend/dashboard";

							}else if($.trim(msg)=='outputsub') {

								 //window.location.href="<?php echo base_url();?>backend/editorial/suboutput/";

								 window.location.href="<?php echo base_url();?>backend/dashboard";

							}

							else if($.trim(msg)=='output') {

								 //window.location.href="<?php echo base_url();?>backend/addSpidyBuzz/";

								 window.location.href="<?php echo base_url();?>backend/dashboard";

							}

						}else{

							$('#eror_msg').html('User Name/ Password is not correct!').css('color', 'red').show().delay(5000).fadeOut('slow');;

							$("#displayAfter").hide();

							$("#submitbtn").show();

						}

					}					

				})

				 return false;

			}
			
			<!---- Signup ----->			
			function validateUser(){  

				var url 				= "<?php echo base_url().'backend/user_registration';?>";
 				var username 			=  $('#register_username').val();
 				var password 			=  $('#register_password').val();
				var user_email 			=  $('#user_email').val();
				var confirm_password 	=  $('#register_cpassword').val();
				
				$('#register_username').css('border', '1px dotted red');
				$('#user_email').css('border', '1px dotted red');
				$('#register_password').css('border', '1px dotted red');
				$('#register_cpassword').css('border', '1px dotted red');
 				$('#eror_msg').hide();
				
				 
 				<!--if(username=='' && password==''){-->
 				if(username!=''){
 					$('#register_username').css('border', '');
 					//return false;
 				}else{
					return false;
				}
				if(user_email!='' && ValidateEmail(user_email) ==true){
 					$('#user_email').css('border', '');
 					//return false;
 				}else{
					return false;
				}
				if(password!='' && password== confirm_password){
 					$('#register_password').css('border', '');
					$('#register_cpassword').css('border', '');
 					//return false;
 				}else{
					$('#register_password').css('border', '1px dotted red');
					$('#register_cpassword').css('border', '1px dotted red');
					return false;
				}
				if(confirm_password!='' && password== confirm_password){
 					$('#register_cpassword').css('border', '');
					$('#register_cpassword').css('border', '');
 					//return false;
 				}else{
					$('#register_password').css('border', '1px dotted red');
					$('#register_cpassword').css('border', '1px dotted red');
					return false;
				}
				 
 				$.ajax({
 					'url': url,
 					data: $("#registration").serialize(),
 					beforeSend: function() {
 						//$("#displayAfter").show();
 						//$("#submitbtn").hide();
 					},
 					type:"POST",
 					success:function(msg){
					
 						if( $.trim(msg)==1 ){ 
  							 window.location.href="<?php echo base_url();?>backend/profile";
 						}else{
 							$('#eror_msg').html('Error in saving!').css('color', 'red').show().delay(5000).fadeOut('slow');;
 							$("#displayAfter").hide();
 							$("#submitbtn").show();
 						}
 					}					
 				})

				 return false;
 			}
			<!---- Signup ----->
		</script>
 	</body>
 </html>

