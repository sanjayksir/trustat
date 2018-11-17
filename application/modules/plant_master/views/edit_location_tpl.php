<?php  // echo '<pre>';print_r($get_user_details);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">Edit Location</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
<input type="hidden" name="location_id" id="location_id" value="<?php echo  $get_user_details[0]['location_id']?>" />
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Location Code</label>
			<input name="location_code" readonly="" id="location_code" type="text" class="form-control" value="<?php echo $get_user_details[0]['location_code'];?>" >
			 
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Location Name</label>
             <input name="location_name" id="location_name" type="text" class="form-control" placeholder="Location Name" value="<?php echo $get_user_details[0]['location_name'];?>">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Location Type</label>
			  
			  <select class="form-control" placeholder="Location Type" id="location_type" name="location_type" onchange="">
			  <option value="<?php echo  $get_user_details[0]['location_type']?>" selected>-<?php echo  $get_user_details[0]['location_type']?>-</option> 
  		  		<?php foreach(getAllLocationTypes('0') as $val){?>
				<option value="<?php echo $val['location_type_name'];?>"><?php  echo $val['location_type_name'];?></option> 
				<?php }?>
			 </select>  
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Email</label>
			<input name="user_email" id="user_email" type="text" class="form-control" placeholder="Email Id" value="<?php echo $get_user_details[0]['email_id'];?>"  maxlength="100">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Phone</label>
             <input name="user_mobile" id="user_mobile" type="text" value="<?php echo $get_user_details[0]['phone'];?>" class="form-control" placeholder="Phone No." maxlength="12">
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">GST</label>
			<input name="gst" id="gst" type="text" value="<?php echo $get_user_details[0]['gst'];?>" class="form-control" placeholder="GST"  maxlength="30">
			</div>
			 
			
			<div class="col-sm-6">
			  <label for="form-field-8">Address</label>
			 <input name="address" id="address" type="text" value="<?php echo $get_user_details[0]['address'];?>" class="form-control" placeholder="Address">
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">Remark</label>
             <input name="remark" id="remark" type="text" value="<?php echo $get_user_details[0]['remark'];?>" class="form-control" placeholder="Remark">
			</div>
			 
			
			<div class="col-sm-6">
			 <label for="form-field-9">State</label>
			 <?php $states = get_state_name(31);?>
             <select class="form-control" placeholder="Select State" id="state_name" name="state_name" onchange="get_related_city_list(this.value);">
  		  		<?php foreach($states as $val){?>
				<option value="<?php echo $val['state_id'];?>" <?php if($val['state_id']==$get_user_details[0]['state']){echo 'selected';}?>><?php  echo $val['state_name'];?></option> 
			 	<?php }?>
			 </select>  
			</div>
		</div>
		  <?php $userId 	=$this->session->userdata('admin_user_id');
			if($userId==1){?>
		 <div class="form-group row">
		     <div class="col-sm-6">
            <?php //echo '<pre>';print_r($get_user_details);?>
			  <label for="form-field-9">CCC Admin</label>
			 <?php $ccadmin = getParentUsers('','1');?>
             <select class="form-control" placeholder="Select Admin" id="ccadmin" name="ccadmin">
			 <option value="">-Select CCC Admin-</option>
  		  		<?php foreach($ccadmin as $val){?>
				<option <?php if($val['user_id']==$get_user_details[0]['created_by']){echo 'selected';}?> value="<?php echo $val['user_id'];?>"><?php  echo $val['user_name'];?></option> 
			 	<?php }?>
			 </select>  
 			</div> 
		</div>
		<?php }?>


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
