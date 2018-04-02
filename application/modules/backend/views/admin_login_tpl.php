<!DOCTYPE html>

<html lang="en">

	<head>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<meta charset="utf-8" />

		<title>Super Admin Login</title>

 		<meta name="description" content="User login page" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE, NO-STORE, must-revalidate">

        <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

        <META HTTP-EQUIV="EXPIRES" CONTENT=0>
 
<script src="<?php echo ASSETS_PATH;?>js/jquery-2.1.4.min.js"></script>
<script src="<?php echo ASSETS_PATH;?>js/jquery.validate.js"></script>
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

         

                                                        
<style>.error{color:#FF0000;}</style>
	</head>



	<body class="login-layout">

		<div class="main-container">

			<div class="main-content">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1">

						<div class="login-container">

							<div class="center">

								<h1>

                                	

									<!--<i class="ace-icon fa fa-leaf green"></i>

									<span class="red">Ace</span>

									<span class="white" id="id-text2">Application</span>-->

								</h1>

								<!--<h4 class="blue" id="id-company-text">&copy; Company Name</h4>-->

							</div>
 							<div class="space-6"></div>
 							<div class="position-relative">
 								<div id="login-box" class="login-box visible widget-box no-border">
 									<div class="widget-body">
 										<div class="widget-main">
 											<h4 class="header blue lighter bigger center" style="color:#4a4a4a !important; font-weight:bold;">
 												Super Admin Login
 											</h4>
 											<span class="space-6" id="eror_msg" style="display:none;"></span>
											<span class="space-6" >
											<?php if($this->session->flashdata('success')!=''){ ?> 
											<div class="alert alert-block alert-success">
 														<i class="ace-icon fa fa-check green"></i>
 														<?php echo $this->session->flashdata('success'); ?>
													</div>
											<?php } ?>
						
											</span>
                                             <?php

												echo "<div class='error_msg' style='color:red;'>";

												if (isset($error_message)) {

												echo $error_message;

												}

												echo validation_errors();

												echo "</div>";

											?>



											<form name="spidey_login" id="spidey_login" action="<?php echo base_url().'backend/getLoggedIn';?>" method="post" onSubmit="return validateLogin();">

												<fieldset>
 													<label class="block clearfix">
 														<span class="block input-icon input-icon-right">
 															<input type="text" name="username" id="username" class="form-control" placeholder="Username" />
 															<i class="ace-icon fa fa-user"></i>
 														</span>
 													</label>
 													<label class="block clearfix">
 														<span class="block input-icon input-icon-right">
 															<input type="password"  name="password" id="password"  class="form-control" placeholder="Password" />
 															<i class="ace-icon fa fa-lock"></i>
 														</span>
 													</label>
  													<div class="space"></div>
  													<div class="clearfix">
  														<input type="submit" class="width-35 pull-right btn btn-sm btn-primary" name="submit" id="submitbtn" value="submit">
                                                           <div id="displayAfter" style="display:none;" class="pull-right"><div class="btn btn-sm btn-primary" name="submit" id="submitbtn" value="submit" type="submit">Submit</div><span class="btn btn-sm btn-primary" style="margin-left:-10px"> <i class="fa fa-spinner fa-spin"></i></span>
  													</div>
  													<div class="space-4"></div>
 												</fieldset>
 											</form>
 										</div><!-- /.widget-main -->
 										<!--
										<div class="toolbar clearfix">
 											<div>
 												<a href="#" data-target="#forgot-box" class="forgot-password-link">
 													<i class="ace-icon fa fa-arrow-left"></i>
 													I forgot my password
 												</a>
 											</div>
											<div>
 												<a href="#" data-target="#signup-box" class="user-signup-link">
 													Click here to register
 													<i class="ace-icon fa fa-arrow-right"></i>
 												</a>
 											</div>
 										</div>
										-->
 									</div><!-- /.widget-body -->
 								</div><!-- /.login-box -->
 								<div id="forgot-box" class="forgot-box widget-box no-border">

									<div class="widget-body">

										<div class="widget-main">

											<h4 class="header red lighter bigger">

												<i class="ace-icon fa fa-key"></i>

												Retrieve Password

											</h4>



											<div class="space-6"></div>

											<p>

												Enter your email and to receive instructions

											</p>

                                            

                                             <?php

												echo "<div class='error_msg' style='color:red;'>";

												if (isset($error_message)) {

												echo $error_message;

												}

												echo validation_errors();

												echo "</div>";

											?>

											<span class="space-6" id="eror_msg_forgot" style="display:none;"></span>

											<form name="spidey_forgot_pass" id="spidey_forgot_pass" action="<?php echo base_url().'index.php/myspidey_login/spidey_forgot_pass';?>" method="post" onSubmit="return validateForgotPass();">

												<fieldset>

													<label class="block clearfix">

														<span class="block input-icon input-icon-right">

															<input type="text" id="email" name="email" class="form-control" placeholder="Email" />

															<i class="ace-icon fa fa-envelope"></i>

														</span>

													</label>



													<div class="clearfix">

                                                    

                                                    <input type="submit" class="width-35 pull-right btn btn-sm btn-primary" name="submit" id="submitbtnForgot" value="Send Me">

                                                          <div id="displayAfterForgot" style="display:none;" class="pull-right"><div class="btn btn-sm btn-primary" name="submit" id="submitbtn" value="submit" type="submit">Submit</div><span class="btn btn-sm btn-primary" style="margin-left:-10px"> <i class="fa fa-spinner fa-spin"></i></span>

                                                          

                                                          

														<!--<button type="button" class="width-35 pull-right btn btn-sm btn-danger">

															<i class="ace-icon fa fa-lightbulb-o"></i>

															<span class="bigger-110">Send Me!</span>

														</button>-->

                                                      



</div>

													</div>

												</fieldset>

											</form>

										</div><!-- /.widget-main -->



										<div class="toolbar center">

											<a href="#" data-target="#login-box" class="back-to-login-link">

												Back to login

												<i class="ace-icon fa fa-arrow-right"></i>

											</a>

										</div>

									</div><!-- /.widget-body -->

								</div><!-- /.forgot-box -->



								<div id="signup-box" class="signup-box widget-box no-border">

									<div class="widget-body">

										<div class="widget-main">

											<h4 class="header green lighter bigger">

												<i class="ace-icon fa fa-users blue"></i>

												New User Registration

											</h4>



											<div class="space-6"></div>

											<span class="space-6 eror_msg"><p> Enter your details to begin: </p></span>


											<?php
 												echo "<div class='error_msg' style='color:red;'>";
 												if (isset($error_message)) {
 													echo $error_message;
 												}
 												echo validation_errors();
 												echo "</div>";
 											?>
											<form name="registration" id="registration" action="<?php echo base_url().'backend/user_registration';?>" method="post" >

												<fieldset>

													<label class="block clearfix">

														<span class="block input-icon input-icon-right">

															<input type="email" name="user_email" id="user_email" class="form-control" placeholder="Email" />

															<i class="ace-icon fa fa-envelope"></i>
															<div id="user_email_error" class="error"></div>
														</span>

													</label>



													<label class="block clearfix">

														<span class="block input-icon input-icon-right">

															<input type="text" name="register_username" id="register_username" class="form-control" placeholder="Username" />

															<i class="ace-icon fa fa-user"></i>

														</span>

													</label>



													<label class="block clearfix">

														<span class="block input-icon input-icon-right">

															<input type="password" name="register_password" id="register_password" class="form-control" placeholder="Password" />

															<i class="ace-icon fa fa-lock"></i>

														</span>

													</label>



													<label class="block clearfix">

														<span class="block input-icon input-icon-right">

															<input type="password"  name="register_cpassword" id="register_cpassword" class="form-control" placeholder="Repeat password" />

															<i class="ace-icon fa fa-retweet"></i>

														</span>

													</label>
													
													<label class="block clearfix">

														<span class="block input-icon input-icon-right">

															<select name="parent" id="parent" class="form-control">
															<option value="0">-Select Parent-</option>
															<?php $parents = getParentUsers('','1');
															if(count($parents)>0){
																foreach($parents as $val){?>
																	<option value="<?php echo $val['user_id'];?>"><?php echo $val['user_name'];?></option>
															<?php }
																}?>
															</select>
															 

														</span>

													</label>



													<!--<label class="block">

														<input type="checkbox" class="ace" name="agreement" />

														<span class="lbl">

															I accept the

															<a href="#">User Agreement</a>

														</span>

													</label>
-->


													<div class="space-24"></div>



													<div class="clearfix">

														<button type="reset" class="width-30 pull-left btn btn-sm">

															<i class="ace-icon fa fa-refresh"></i>

															<span class="bigger-110">Reset</span>

														</button>



														<input type="submit" class="width-35 pull-right btn btn-sm btn-primary" name="submit" id="submitbtn" value="submit">

                                                          <div id="displayAfter" style="display:none;" class="pull-right"><div class="btn btn-sm btn-primary" name="submit" id="submitbtn" value="submit" type="submit">Submit</div><span class="btn btn-sm btn-primary" style="margin-left:-10px"> <i class="fa fa-spinner fa-spin"></i></span>

 													</div>

 													<div class="space-4"></div>

													</div>

												</fieldset>

											</form>

										</div>



										<div class="toolbar center">

											<a href="#" data-target="#login-box" class="back-to-login-link">

												<i class="ace-icon fa fa-arrow-left"></i>

												Back to login

											</a>

										</div>

									</div><!-- /.widget-body -->

								</div><!-- /.signup-box -->

							</div><!-- /.position-relative -->

 						</div>

					</div><!-- /.col -->

				</div><!-- /.row -->

			</div><!-- /.main-content -->

		</div><!-- /.main-container -->



		<!-- basic scripts -->



		<!--[if !IE]> -->

		 



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
						if($.trim(msg)=='status-verification-both' || $.trim(msg)=='verification'){
 							$('#eror_msg').html('Email-Verification is not completed!').css('color', 'red').show().delay(5000).fadeOut('slow');
 						}
						else if($.trim(msg)=='status'){
 							$('#eror_msg').html('Your registration is waiting for admin approval!').css('color', 'red').show().delay(5000).fadeOut('slow');
 						}else if($.trim(msg)=='wrong-pass'){
 							$('#eror_msg').html('User Not Exists!').css('color', 'red').show().delay(5000).fadeOut('slow');;
 							$("#displayAfter").hide();
 							$("#submitbtn").show();
 						}else{					
							window.location.href="<?php echo base_url();?>backend/dashboard";
						}
 					}					
 				})
 				 return false;
 			}
			
			<!---- Signup ----->
		$(document).ready(function(){	
 			jQuery.validator.addMethod("noSpace", function(value, element) { 

	return value.indexOf(" ") < 0 && value != ""; 

	}, "No space please");
 
 			$("form#registration").validate({
 		rules: {
   			register_username:{
 						  required: true,
						  noSpace: true,
						  remote: {
                        	 	url: "<?php echo base_url().'user_master/';?>checkUserName",
                          		type: "post" ,
								data: {  user_name: $( "#register_username" ).val() }
                     	 }
 					  },

		 user_email: {
						required: true,
            			 email: true,

						 remote: {

                       	 	url: "<?php echo base_url().'user_master/';?>checkUnameEmail",
                          	type: "post",
 							//data: {  userid: $( "#user_id" ).val() }

                    	 }

       		} ,
  			 register_password: {
			 	 required: true,
				 equalTo: "#register_cpassword"
			},	 
				
  		},

		messages: {
 				register_username: {
 					required: "Please enter User Name" ,
					noSpace:"Space not alloweded in user name",
					remote:"User name alraedy Exists"
 				} ,
				user_email:{
					required: "Email Id Required",
					email: "Invalid Email Id",
					remote: "Email Id Alraedy Exists",
				},
				register_password:{
					required:"Password Required",
					equalTo:"Password not matched"
				}
		},

		submitHandler: function(form) {
  			$.ajax({
 					'url':"<?php echo base_url().'backend/user_registration';?>",
 					data: $("#registration").serialize(),
 					beforeSend: function() {
 						 
 					},
 					type:"POST",
 					success:function(msg){
 						if( $.trim(msg)==1 ){ 
  							 window.location.href="<?php echo base_url();?>backend/user_registration";
 						}else if( $.trim(msg)=='2' ){ 
  							$('.eror_msg').html('Email Already exists!').css('color', 'red').show().delay(5000).fadeOut('slow');;
 							$("#displayAfter").hide();
 							$("#submitbtn").show();
 						}else{
 							$('.eror_msg').html('Error in saving!').css('color', 'red').show().delay(5000).fadeOut('slow');;
 							$("#displayAfter").hide();
 							$("#submitbtn").show();
 						}
 					}					
 				})
			 return false;
 		}
	});
 		});			
			 
			<!---- Signup ----->
		</script>
 	</body>
 </html>

