<?php  // echo '<pre>';print_r($get_user_details);exit;?>
<!---------- Edit Link------------>
<div class="col-xs-12" id="show_country_form">
	<a href="<?php echo base_url('/backend/dashboard') ?>" class="btn btn-info  pull-right" title="Back to List Loyalty Matrix"> | Back to Home <?php echo $label; ?> </a> <a class="btn btn-info pull-right" href="<?php echo base_url().'user_master/edit_profile_user';?>" data-toggle="modal"> Edit Profile</a>
	
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
  <div class="form-group row">
    <div class="col-sm-6">
      <label for="form-field-8">User ID</label>
      <div class="form-control"><?php echo $get_user_details[0]['customer_code'];?></div>
    </div>
    <div class="col-sm-6">
      <label for="form-field-8">Phone#</label>
      <div class="form-control"><?php echo $get_user_details[0]['mobile_no'];?></div>
    </div>
  </div>
  
  <div class="form-group row">
    <div class="col-sm-6">
      <label for="form-field-8">User Name</label>
      <div class="form-control"><?php echo $get_user_details[0]['user_name'];?></div>
    </div>
    <div class="col-sm-6">
      <label for="form-field-8">Email ID</label>
      <div class="form-control"><?php echo $get_user_details[0]['email_id'];?></div>
    </div>
  </div>
  
  <div class="form-group row">
    <div class="col-sm-6">
      <label for="form-field-8">First Name</label>
      <div class="form-control"><?php echo $get_user_details[0]['f_name'];?></div>
    </div>
    <div class="col-sm-6">
      <label for="form-field-8">Last Name</label>
      <div class="form-control"><?php echo $get_user_details[0]['l_name'];?></div>
    </div>
  </div>
   <div class="form-group row">
    <div class="col-sm-4">
      <label for="form-field-8">Customer Microsite URL</label>
      <div class="form-control"><?php echo $get_user_details[0]['customer_microsite_url'];?></div>
    </div>
    <div class="col-sm-4">
      <label for="form-field-8">State</label>
      <div class="form-control"><?php $states = get_state_name(31);?>
   		  		<?php foreach($states as $val){
					if($val['state_id']==$get_user_details[0]['state']){?>
					<div class=""><?php  echo $val['state_name'];?></div>
				<?php }}?></div>
    </div>
	<div class="col-sm-4">
      <label for="form-field-8">City</label>
      <div class="form-control"><?php  echo $get_user_details[0]['city_name'];?></div>
    </div>
  </div>
    <div class="form-group row">
    
    <div class="col-sm-6">
      <label for="form-field-8">Days for expiry from the date of Loyalty Point Credited </label>
      <div class="form-control"><?php echo $get_user_details[0]['days_for_expiry_of_point_credited'];?></div>
    </div>
	 <div class="col-sm-6">
      <label for="form-field-8">Days for Notification Before Expiry of Loyalty Point</label>
      <div class="form-control"><?php echo $get_user_details[0]['days_for_notification_before_expiry_of_lps'];?></div>
    </div>
  </div>
 <?php if($this->session->userdata('admin_user_id')==1){ ?>
  
  <div class="form-group row">
    <div class="col-sm-6">
      <label for="form-field-8">Industry</label>
      <div class="form-control"><?php echo $get_user_details[0]['industry'];?></div>
    </div>
    <div class="col-sm-6">
      <label for="form-field-8">Pan</label>
      <div class="form-control"><?php echo $get_user_details[0]['pan'];?></div>
    </div>
  </div>
  
  <div class="form-group row">
    <div class="col-sm-6">
      <label for="form-field-9">State</label>
      <?php $states = get_state_name(31);?>
      <?php foreach($states as $val){?>
      <?php if($val['state_id']==$get_user_details[0]['state']){  echo '<div class="form-control">'. $val['state_name'].'</div>'; }?>
      <?php }?>
    </div>
    <div class="col-sm-6">
      <label for="form-field-9">City</label>
      <div class="form-control"><?php echo get_city_name($get_user_details[0]['city']);?></div>
    </div>
  </div>
  <?php }?>
  <div class="form-group row">
    <div class="col-sm-6">
	<?php if(file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'])){?>
      <label for="form-field-8">Profile Image</label>
	  <?php }?>
      <div class="widget-body">
        <label class="ace-file-input">
          
          
          <?php 
					 $image='';
					 $display='none';
					 if(file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'])){
					 		$display='block';
					 		$image = base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'];
					 }?>
          <a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label>
        <img style="display:<?php echo $display;?>;" width="100px" id="blah" src="<?php echo $image;?>" alt="Image Preview" /> </div>
    </div>
	
	<div class="col-sm-6">
			  <label for="form-field-8">Remark</label>
             <div class="form-control" style=" height: 100px;overflow: scroll;"><?php echo $get_user_details[0]['remark'];?></div>
			</div> 
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
