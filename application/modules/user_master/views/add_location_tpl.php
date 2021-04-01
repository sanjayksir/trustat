<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>plant_master/list_locations/<?php echo $this->uri->segment(3); ?>" class="btn btn-primary pull-right" title="Back to List Locations">Back to List Locations</a></div>
<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Location</h4>  
<?php //echo GoogleAPKAuthenticationCode(); ?>
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>
		<?php
		// MySQL connect info
							include('url_base_con_db2.php');
			
			//$query = mysql_query("SELECT MAX( plant_id ) FROM plant_master;");
			 $highest_id = mysql_result(mysql_query("SELECT MAX(location_id) FROM location_master"), 0);
			 $location_code = $highest_id + 1;

?>
	  
      <form name="user_frm" id="user_frm" action="#" method="POST">
<input type="hidden" name="ccadmin" id="ccadmin" value="<?php echo $this->uri->segment(3); ?>" >    
        <div class="widget-main">
		<label for="form-field-8">You are adding Location for <b><?php echo getUserFullNameById($this->uri->segment(3)); ?></b> </label>
		<?php $random_no = random_num(4);?>
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Location Code</label>
			<input name="location_code" readonly="" id="location_code" type="text" class="form-control" value="<?php echo 'L00'.$location_code;?>" >
			 
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Location Name</label>
             <input name="location_name" id="location_name" type="text" class="form-control" placeholder="Location Name">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Location Type</label>
			  <select class="form-control" placeholder="Location Type" id="location_type" name="location_type" onchange="">
			  <option value="" selected>-Please Select Location Type-</option> 
  		  		<?php foreach(getAllLocationTypes('0') as $val){?>
				<option value="<?php echo $val['location_type_name'];?>"><?php  echo $val['location_type_name'];?></option> 
				<?php }?>
			 </select>  
			</div>
			
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Email ID</label>
             <input name="user_email" id="user_email" type="text" class="form-control" placeholder="Email ID"  maxlength="50">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Phone</label>
             <input name="user_mobile" id="user_mobile" type="text" class="form-control" placeholder="Phone No." maxlength="12">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">GST No.</label>
			<input name="gst" id="gst" type="text" class="form-control" placeholder="GST No."  maxlength="30">
			</div>
		</div>
		 
		
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">Street Address</label>
			<input name="street_address" id="street_address" type="text" class="form-control" placeholder="Street Address"  maxlength="30">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Locality</label>
			<input name="locality" id="locality" type="text" class="form-control" placeholder="Locality"  maxlength="30">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">City</label>
			<input name="city" id="city" type="text" class="form-control" placeholder="City"  maxlength="30">
			</div>
		</div>
		
		
 		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">District</label>
			<input name="district" id="district" type="text" class="form-control" placeholder="District"  maxlength="30">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">PIN Code</label>
			<input name="pin_code" id="pin_code" type="text" class="form-control" placeholder="PIN Code"  maxlength="30">
			</div>
		
		<div class="col-sm-4">
			 <label for="form-field-9">State</label>
			 <?php $states = get_state_name(31);?>
             <select class="form-control" placeholder="Select State" id="state_name" name="state_name" onchange="get_related_city_list(this.value);">
  		  		<?php foreach($states as $val){?>
				<option value="<?php echo $val['state_id'];?>"><?php  echo $val['state_name'];?></option> 
			 	<?php }?>
			 </select>  
			</div>
		
			
		</div>
		
			<div class="form-group row">		
		<div class="col-sm-4">
			  <label for="form-field-8">Location Longitude</label>
			<input name="location_longitude" id="location_longitude" type="text" value="<?php echo $get_user_details[0]['location_longitude'];?>" class="form-control" placeholder="Location Longitude"  maxlength="30">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Location Latitude</label>
			<input name="location_latitude" id="location_latitude" type="text" value="<?php echo $get_user_details[0]['location_latitude'];?>" class="form-control" placeholder="Location Latitude"  maxlength="30">
			</div>
			 
			 <div class="col-sm-4">
			  <label for="form-field-8">Landmark or Near by</label>
			  <input name="landmark" id="landmark" type="text" value="" class="form-control" placeholder="Landmark or Near by">
			  
			</div>
			
		</div>
		
		 <div class="form-group row">
		 
		 <div class="col-sm-4">
			  <label for="form-field-8">Store Timings</label>
			  <input name="store_timings" id="store_timings" type="text" value="" class="form-control" placeholder="Store Timings">
			</div>
			
			
			<div class="col-sm-4">
			  <label for="form-field-8">Profile Image</label>

                <div class="widget-body">

                     <label class="ace-file-input"><input id="file" onchange="readURL(this);" name="file"  type="file"><span class="ace-file-container" data-title="Choose">

                     <span class="ace-file-name" data-title="No File ..."><i class=" ace-icon fa fa-upload"></i></span></span>

                     <a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label> <img style="display:none;" width="100px" id="blah" src="#" alt="Image Preview" />

                </div>

			</div>
			
 			<div class="col-sm-4">
			  <label for="form-field-8">Remark</label>
            <textarea  class="form-control" name="remark" id="remark" placeholder="Your view / Remark"></textarea>
			</div>
		</div>
        <!--
        <div class="form-group row">
		     <div class="col-sm-6">
            <?php $userId 	=$this->session->userdata('admin_user_id');
			if($userId==1){?>
				  <label for="form-field-9">Assigned to CCC Admin</label>
			 <?php $ccadmin = getParentUsers('','1');?>
             <select class="form-control" placeholder="Select Admin" id="ccadmin" name="ccadmin">
			 <option value="">-Select CCC Admin-</option>
  		  		<?php foreach($ccadmin as $val){?>
				<option <?php if($val['user_id']==$get_user_details[0]['is_parent']){echo 'selected';}?> value="<?php echo $val['user_id'];?>"><?php  echo $val['user_name'];?></option>
			 	<?php }?>
			 </select>  
             <?php }?>

 			</div> 
		</div>-->
            <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />

          </div>

        </div>

      </form>

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
 