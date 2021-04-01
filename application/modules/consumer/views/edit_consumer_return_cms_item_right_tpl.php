<?php 
// echo '<pre>';print_r($get_user_details);exit;
?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<?php $type = "Product Returned From Consumer CMS Item";
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
		<input type="hidden" name="prfcci_id" id="prfcci_id" value="<?php echo $get_user_details[0]['prfcci_id']?>" />
        <div class="widget-main">
		
		
				<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Return CMS Type</label><?php //echo $get_user_details[0]['prfcci_id']?>
			<select name="return_cms_type" id="return_cms_type" class="form-control">
			<option value="Return Type" <?php if($get_user_details[0]['return_cms_type']=="Return Type"){echo "selected"; } ?>>Return Type</option> 
			<option value="Returning Condition of Product Condition" <?php if($get_user_details[0]['return_cms_type']=="Returning Condition of Product Condition"){echo "selected"; } ?>>Returning Condition of Product Condition</option>
         </select>
		</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Return CMS Type Name Value</label>
			  <input type="text" placeholder="Please Return CMS Type Name Value" name="return_cms_type_name_value" id="return_cms_type_name_value" class="form-control" value="<?php echo $get_user_details[0]['return_cms_type_name_value']; ?>" required>			  
			
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Return CMS Type Name Slug</label>
			  <input type="text" placeholder="Please Enter Return CMS Type Name Slug" name="return_cms_type_name_slug" id="return_cms_type_name_slug" value="<?php echo $get_user_details[0]['return_cms_type_name_slug']?>" class="form-control" readonly>			  
			</div>
			
			<div class="col-sm-4">
			<label for="form-field-8">Active Status</label><?php //echo getAttributeSlugByName("Laptop"); ?>
		<select  name="active_status" id="active_status" class="form-control" required>
			<option value="">-Select Status-</option>
			<option value="Active" <?php if($get_user_details[0]['active_status']=="Active"){echo "selected"; } ?>>Active</option>
			<option value="In-Active" <?php if($get_user_details[0]['active_status']=="In-Active"){echo "selected"; } ?>>In-Active</option>
         </select>
			</div>
		</div>
		<div align="center">
		<div class="col-sm-12">			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
			</div>


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
			<a href="<?php echo base_url('consumer/list_consumer_return_cms_items/') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to Product Returned From Consumer CMS Items
			<?php echo $label; ?> </a>
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
