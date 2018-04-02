<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('../includes/sb_header');?>
<?php $this->load->view('../includes/sb_top_navigation');?>


<div class="wide-container">
  <div class="container padding-top-30 padding-bottom-3">
    <div class="left-container flt">
      <h1 class="heading flt">Change password</h1>
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
		  
		  <div class="row old_p">
              <div class="col-sm-10 form-group">
                <label>Old Password</label>
               <input name="opassword" id="opassword" type="password" class="form-control" placeholder="Old Password">
              </div>
            </div>
            <div class="row new_p" >
              <div class="col-sm-10 form-group">
                <label>New Password</label>
               <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
              </div>
			   <div class="col-sm-10 form-group">
                <label>Confirm Password</label>
               <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="New Password">
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
$.validator.addMethod("notEqualTo", function(value, element, param) {
       return this.optional(element) || value != $(param).val();
 }, 'This two elements are the same, please change it.');
<!------------------------ Validate Fom Add Menu Data----------------------------->
 $(document).ready(function(){	
	$("form#frm").validate({
		 errorClass: 'redvalidate',
        rules: {
            opassword: {
                        required: false,
					   },
            password:{
                         required: true,
						 notEqualTo: '#opassword'
                      },
		   cpassword: {
					required: true,
					equalTo: "#password"
					
				}
        },
        messages: {
                opassword: {
                    required: "",
                },
                password: {
                    required: "",
                    notEqualTo:  "New Password should be different from Old Password."					
                },
               cpassword: { 
                 	required:"",
					equalTo:"Confirm Password and New Password doesn't match."
               }
				

               
        },
		submitHandler: function(form) {
		  var dataSend = $("#frm").serialize();
		  $.ajax({
				type: "POST",
				beforeSend: function(){
						$(".show_loader").show();
						$(".show_loader").click();
				},
				url: "<?php echo base_url(); ?>register/update_password/",
				data:dataSend,
				//async: true,				
				success: function (msg) {
					//alert(msg);
					
					if(msg==0){
					$("#ajax_msg").html("Old password is wrong!").show();
					
					}
					if(msg==2){
						
					
					$("#ajax_msg").html("Something is wrong!").show();
					
						
					}
					
					if(msg==1){
						
					
					$("#ajax_msg").html("Password has been changed").show();
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