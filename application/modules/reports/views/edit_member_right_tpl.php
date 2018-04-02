<?php  // echo '<pre>';print_r($get_user_details);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">Edit Profile</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
<input type="hidden" name="plant_id" id="plant_id" value="<?php echo  $get_user_details[0]['plant_id']?>" />
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Plant Code</label>
			<input name="customer_code" readonly="" id="customer_code" type="text" class="form-control" value="<?php echo $get_user_details[0]['plant_code'];?>" >
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Plant Name</label>
             <input name="plant_name" id="plant_name" type="text" class="form-control" placeholder="Plant Name" value="<?php echo $get_user_details[0]['plant_name'];?>">
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
		
		
		
		
		
		
		 
		     

           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />

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
