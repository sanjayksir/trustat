<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('../includes/sb_header');?>
<?php $this->load->view('../includes/sb_top_navigation');?>


<div class="wide-container">
  <div class="container padding-top-30 padding-bottom-3">
    <div class="left-container flt">
      <h1 class="heading flt">Forgot password</h1>
    </div>
  </div>
</div>
<div class="wide-container">
  <div class="container padding-bottom-30 minheight">
    <div class="around-story-container">
        <form name="frm" id="frm" action="#" method="POST">
        <div id="ajax_msg" class="alert alert-block alert-success" style="display:none;"><i class="ace-icon fa fa-check green"></i></div>
        <div class="row">
          <div class="col-md-8">
		  
		  <div class="row email_f">
              <div class="col-sm-10 form-group">
                <label>Email/Phone</label>
               <input name="email" id="email" type="text" class="form-control" placeholder="Email/Phone">
              </div>
            </div>
            <div class="row pass_f" style="display:none;">
              <div class="col-sm-10 form-group">
                <label>New Password</label>
               <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
              </div>
            </div>
          
            <div class="row otp_f" style="display:none;">
              <div class="col-sm-10 form-group">
                <label>OTP</label>
               <input name="otp" id="otp" type="text" class="form-control" placeholder="Enter OTP">
              </div>
            </div>
          </div>
          
        </div>
        <div class="form-group row">
          <div class="col-sm-3 center submit-sec-btn"> <br>
		 <hr>
         <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
         <input class="btn btn-info" type="submit" name="submit" value="Submit" id="submit" />
          </div>
        </div>
      </form>
	  

    </div>
  </div>
</div>
</div>
<?php echo $this->load->view('../includes/sb_footer');?> 
<script>
<!------------------------ Validate Fom Add Menu Data----------------------------->
 $(document).ready(function(){	
	$("form#frm").validate({
		 errorClass: 'redvalidate',
        rules: {
            email: {
                        required: true,
						
                      },
            password:{
                         required: true,
                      },
		    otp:{
                         required: true,
                      },
               
           
        },
        messages: {
                userID: {
                    required: "",
                },
                password: {
                    required: "" 
                } ,

                otp: {
                    required: "" 
                } ,				
               
        },
		submitHandler: function(form) {
		  var dataSend = $("#frm").serialize();
		  $.ajax({
				type: "POST",
				beforeSend: function(){
						$(".show_loader").show();
						$(".show_loader").click();
				},
				url: "<?php echo base_url(); ?>register/reset_password/",
				data:dataSend,
				//async: true,				
				success: function (msg) {
					//alert(msg);
					
					if(msg==0){
					$("#ajax_msg").html("User does not exist!").show();
					setTimeout(alertFunc, 3000);
					}
					if(msg==1||msg==2){
						
					$('.email_f').fadeOut('slow');
					$('.pass_f').fadeOut('slow');
					$('.otp_f').fadeIn('slow');
					$("#ajax_msg").html("Please enter your otp").show();
					$("#submit").val("Submit OTP");	
						
					}
					
					if(msg==3){
						
					$('.email_f').fadeOut('slow');
					$('.pass_f').fadeIn('slow');
					$('.otp_f').fadeOut('slow');
					$("#ajax_msg").html("Please enter your new password").show();
					$("#submit").val("Save Password");	
						
						
					}
					if(msg==4){
					$("#ajax_msg").html("Invalid otp!").show();
					setTimeout(alertFunc, 3000);
					} 
					if(msg==5){
					$("#ajax_msg").html("Password has been updated successfully.you can login to proceed").show();
					setTimeout(alertFunc, 3000);
					}
					
					
				},
				complete: function(){
					$(".show_loader").hide();
				}
			});
 		}
	});
});

function alertFunc(){
	
	return window.location.replace("<?php echo base_url();?>");
	
}
<!------------------------ Validate Fom----------------------------->
</script>