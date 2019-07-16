<?php 
// echo '<pre>';print_r($get_user_details);exit;
?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<?php $type = "Consumer Profile Attribute Types";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='edit_plant_controller'){
									$type = "User";
								}?>
      <h4 class="widget-title">Edit <?php echo $type;?></h4>
		<div class="widget-toolbar"> <a href="<?php echo base_url('consumer/list_consumer_profile_attributes/') ?>" > <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="<?php echo base_url('consumer/list_consumer_profile_attributes/') ?>" > <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
		<form name="user_frm" id="user_frm" action="#" method="POST">
		<input type="hidden" name="cpatm_id" id="cpatm_id" value="<?php echo $get_user_details[0]['cpatm_id']?>" />
        <div class="widget-main">
		
		
				<div class="form-group row">
			
			
			<div class="col-sm-4">
			  <label for="form-field-8">QUERY Type Name</label>
			  <input type="text" placeholder="Please Enter QUERY Name" value="<?php echo $get_user_details[0]['cpatm_name'];?>" name="cpatm_name" id="cpatm_name" class="form-control">			  
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Profile Bucket</label>			 
			<select  name="profile_bucket" id="profile_bucket" class="form-control" required>
				<option value="<?php echo $get_user_details[0]['profile_bucket'];?>" selected><?php echo $get_user_details[0]['profile_bucket'];?></option>
				<option value="Basic Profile">Basic Profile</option>
				<option value="Personal Profile">Personal Profile</option>
				<option value="Family Profile">Family Profile</option>
				<option value="Lifestyle Profile">Lifestyle Profile</option>
				<option value="Others">Others</option>				
            </select>
			
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">QUERY Type Slug</label>
			  <input type="text" placeholder="Please Enter QUERY Type Name" name="cpatm_name_slug" value="<?php echo $get_user_details[0]['cpatm_name_slug'];?>" id="cpatm_name_slug" class="form-control" readonly>			  
			</div>
			
			
			<div class="col-sm-4">
			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
		</div>
		


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
			<a href="<?php echo base_url('consumer/list_consumer_profile_attribute_types/') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to Consumer Profile Attribute Types <?php echo $label; ?> </a>
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
