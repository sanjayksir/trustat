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
<input type="hidden" name="user_id" id="user_id" value="<?php echo  $get_user_details[0]['user_id']?>" />
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">User ID</label>
			<div class="form-control"><?php echo $get_user_details[0]['customer_code'];?></div>
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Phone#</label>
             <input name="user_mobile" id="user_mobile" type="text" class="form-control" placeholder="User Mobile" value="<?php echo $get_user_details[0]['mobile_no'];?>">
			</div>
		</div>
		 
		
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">User Name</label>
             <input name="user_name" id="user_name" type="text" readonly="" value="<?php echo $get_user_details[0]['user_name'];?>" class="form-control" placeholder="User Name"  maxlength="20">
			</div>
			 
			
			<div class="col-sm-6">
			  <label for="form-field-8">Email ID</label>

            <input name="user_email" id="user_email" value="<?php echo $get_user_details[0]['email_id'];?>" type="text" class="form-control" placeholder="Email ID"  maxlength="50">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">First Name</label>
			<input name="f_name" id="f_name" type="text" value="<?php echo $get_user_details[0]['f_name'];?>" class="form-control" placeholder="First Name"  maxlength="30">
			</div>
			 
			
			<div class="col-sm-6">
			  <label for="form-field-8">Last Name</label>
			 <input name="l_name" id="l_name" type="text" value="<?php echo $get_user_details[0]['l_name'];?>" class="form-control" placeholder="Last Name"  maxlength="30">
			</div>
		</div>
		
		 <?php if($this->session->userdata('admin_user_id')==1){ ?>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Industry</label>
			<input name="industry" id="industry" type="text" class="form-control" placeholder="Industry Name" value="<?php echo $get_user_details[0]['industry'];?>"  maxlength="100">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Pan</label>
             <input name="pan" id="pan" type="text" value="<?php echo $get_user_details[0]['pan'];?>" class="form-control" placeholder="Pan No." maxlength="12">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			 <label for="form-field-9">State</label>
			 <?php $states = get_state_name(31);?>
             <select class="form-control" placeholder="Select State" id="state_name" name="state_name" onchange="get_related_city_list(this.value);">
  		  		<?php foreach($states as $val){?>
				<option value="<?php echo $val['state_id'];?>" <?php if($val['state_id']==$get_user_details[0]['state']){echo 'selected';}?>><?php  echo $val['state_name'];?></option> 
			 	<?php }?>
			 </select>  
			</div>
			 
			
			<div class="col-sm-6">
			 <label for="form-field-9">City</label>
			  <select class="form-control" id="city_name" name="city_name">
 		  		<option value="">select City</option>       
             </select>
			</div>
		</div>
		<?php }?>
		
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">Profile Image</label>

                <div class="widget-body">

                     <label class="ace-file-input"><input id="file" onchange="readURL(this);" name="file"  type="file"><span class="ace-file-container" data-title="Choose">

                     <span class="ace-file-name" data-title="No File ..."><i class=" ace-icon fa fa-upload"></i></span></span>
					 
					 
					 <?php 
					 $image='';
					 $display='none';
					 if(file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'])){
					 		$display='block';
					 		$image = base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'];
					 }?>
                     <a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label> <img style="display:<?php echo $display;?>;" width="100px" id="blah" src="<?php echo $image;?>" alt="Image Preview" />
					 
                </div>

			</div>
			 
			  
			<div class="col-sm-6">
			  <label for="form-field-8">Remark</label>
			  <textarea  class="form-control" name="remark" placeholder="Write your remark..."  maxlength="500"><?php echo $get_user_details[0]['remark'];?></textarea>
 			</div>  
		</div>
		 
		     

           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
			<a href="<?php echo base_url('/backend/dashboard') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to Home <?php echo $label; ?> </a>
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
