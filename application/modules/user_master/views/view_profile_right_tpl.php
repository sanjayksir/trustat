<?php  // echo '<pre>';print_r($get_user_details);exit;?>
<!---------- Edit Link------------>
<div class="col-xs-12" id="show_country_form">
	<a href="<?php echo base_url('/backend/dashboard') ?>" class="btn btn-info  pull-right" title="Back to List Loyalty Matrix"> Back to Home <?php echo $label; ?> </a><!--<a class="btn btn-info pull-right" href="<?php echo base_url().'user_master/edit_profile_user';?>" data-toggle="modal"> Edit Profile</a>-->
	
</div>
<!---------- Edit Link------------>
<div class="col-xs-12">



<div class="widget-box">
<div class="widget-header">
  <h4 class="widget-title">View Profile</h4>
  <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
</div>
<div class="widget-body">
  <div id="ajax_msg"></div>
</div>
 <?php //echo '<pre>';print_r($get_user_details[0]['city']);exit;?>
<input type="hidden" name="user_id" id="user_id" value="<?php echo  $get_user_details[0]['user_id']?>" />
<div class="widget-main">
<fieldset>
	<legend>Organization Profile</legend>
  <div class="form-group row">
  <div class="col-sm-4">
      <label for="form-field-8"><b>Organization Name</b></label>
      : <?php echo $get_user_details[0]['f_name'];?>
    </div>
	
    <div class="col-sm-4">
      <label for="form-field-8"><b>Unique User/Customer Code</b></label>
      : <?php echo $get_user_details[0]['customer_code'];?>
    </div>
	
    <div class="col-sm-4">
      <label for="form-field-8"><b>Phone#</b></label>
      : <?php echo $get_user_details[0]['mobile_no'];?>
    </div>
	
	<div class="col-sm-4">
      <label for="form-field-8"><b>Pan</b></label>
      : <?php echo $get_user_details[0]['pan'];?>
    </div>
	
	<div class="col-sm-4">
      <label for="form-field-8"><b>Customer Microsite URL</b></label>
      <?php echo $get_user_details[0]['customer_microsite_url'];?>
    </div>
	
	<div class="col-sm-4">
      <label for="form-field-8"><b>State</b></label>
      : <?php $states = get_state_name(31);?>
   		  		<?php foreach($states as $val){
					if($val['state_id']==$get_user_details[0]['state']){?>
					<?php  echo $val['state_name'];?>
				<?php }}?>
    </div>
	
	<div class="col-sm-4">
      <label for="form-field-8"><b>City</b></label>
      : <?php  echo get_city_name($get_user_details[0]['city']);?>
    </div>
	
	
		
		<div class="col-sm-4">
			  <label for="form-field-8"><b>Complaint Email ID</b></label>
             : <?php echo $get_user_details[0]['complaint_email_id'];?>
			</div> 
		<div class="col-sm-4">
      <label for="form-field-8"><b>Feedback Email ID</b></label>
      : <?php echo $get_user_details[0]['feedback_email_id'];?>
		</div>	
	
	
    </div>
	
	<div class="col-sm-4">
      <label for="form-field-8"><b>Industry</b></label>
      : <?php echo $get_user_details[0]['industry'];?>
		</div>	
		
	<div class="col-sm-4">
	<?php if(file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'])){?>
      <label for="form-field-8"><b>Profile Image</b></label> : 
	  <?php }?>
          <?php 	 $image='';
					 $display='none';
					 if(file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'])){
					 		$display='block';
					 		$image = base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'];
					 }?>
        <!--<img style="display:<?php echo $display;?>;" width="100px" id="blah" src="<?php echo $image;?>" alt="Image Preview" /> -->
		
		<a href="<?php echo $image;?>" onclick="window.open (this.href, 'child', 'height=800,width=900'); return false"><img alt="Profile Image" src="<?php echo $image;?>" height="120" width="120"></a>
		
		</div>
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Remark</b></label>
             <div class="" style="height: 100px;overflow: scroll;"><?php echo $get_user_details[0]['remark'];?></div>
			</div> 
		
			
  
  </fieldset>
  <hr />
  <fieldset>
	<legend>User Profile</legend>
  <div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Login User Name</b></label>
			  : <?php echo $get_user_details[0]['user_name'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Person Name</b></label>
			  : <?php echo $get_user_details[0]['l_name'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Email ID</b></label>
			  : <?php echo $get_user_details[0]['email_id'];?> 
			</div>
  </div>
  
  </fieldset>
  
  <hr />
	<fieldset>
		<legend>Customer Loyalty Type</legend>
    <div class="form-group row"> 

	<div class="col-sm-4">
      <label for="form-field-8"><b>Customer Loyalty Type</b></label>
     : <?php echo $get_user_details[0]['customer_loyalty_type'];?>
	  <script type="text/javascript">
				function showDiv2(select){
				   if(select.value=="Brand"){
					document.getElementById('hidden_div2').style.display = "block";
				   } else{
					document.getElementById('hidden_div2').style.display = "none";
				   }
				} 
			</script>
    </div>	
	
    <div class="col-sm-4">
      <label for="form-field-8"><b>Days for expiry from the date of Loyalty Point Credited </b></label>
      : <?php echo $get_user_details[0]['days_for_expiry_of_point_credited'];?>
    </div>
	
	 <div class="col-sm-4">
      <label for="form-field-8"><b>Days for Notification Before Expiry of Loyalty Point</b></label>
      : <?php echo $get_user_details[0]['days_for_notification_before_expiry_of_lps'];?>
    </div>
	
  </div>
  
  <div class="form-group row"> 
	<div class="col-sm-4">
      <label for="form-field-8"><b>Loyalty Points for consumer on view Notification</b></label>
      : <?php echo $get_user_details[0]['loyalty_points_consumer_view_notification_lps'];?>
    </div>
	
	<div class="col-sm-4">
      <label for="form-field-8"><b>Loyalty Point weightage with compare to currency in %</b></label>
      : <?php echo $get_user_details[0]['loyalty_point_weightage'];?>
    </div>
	
	
	<div id="hidden_div2" <?php if($get_user_details[0]['customer_loyalty_type']=='TRUSTAT'){ ?> style="display:none;" <?php } ?>>
	 <div class="form-group row"> 
	 
	 <div class="col-sm-4">
			 <label for="form-field-9"><b>Brand Loyalty Redemption Type</b></label>
             : <?php  echo $get_user_details[0]['brand_loyalty_redemption_type'];?>
 			</div>
	</div>
	
	<div class="col-sm-4">
			  <label for="form-field-8"><b>Customer Microsite URL</b></label>
			: <?php echo $get_user_details[0]['customer_microsite_url'];?>
		</div>
	
	<div class="col-sm-4">
			 <label for="form-field-9"><b>Brand Loyalty/Store Redemption/Message</b></label>
              : <?php  echo $get_user_details[0]['brand_loyalty_store_redemption_message'];?>
 			</div>
	
	<!--
	<div class="col-sm-4">
			 <label for="form-field-9"><b>TRUSTAT Coupon Type/Name/Number</b></label>
              <div class=""><?php  echo $get_user_details[0]['trustat_coupon_type_name_number'];?></div>
 			</div>-->
	</div>
	
	<div class="col-sm-4">
      <label for="form-field-8"><b>% of Loyalty Points redeemed in a single Order</b></label>
     : <?php echo $get_user_details[0]['percent_lty_pts_consumer_red_cashier'];?>
    </div>
	
  </div>
  
 <?php if($this->session->userdata('admin_user_id')==1){ ?>
  
  
  <?php }?>
  <div class="form-group row">
    
  </div>
  <hr>
  <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;"> </div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
 	function readURL(input) {
 		 if (input.files && input.files[0]) {
 			var reader = new FileReader();
 			 reader.onload = function (e) {
 				$('#blah').attr('src', e.target.result).show();
 			}
 			 reader.readAsDataURL(input.files[0]);
 		}
 	}
  </script> 
