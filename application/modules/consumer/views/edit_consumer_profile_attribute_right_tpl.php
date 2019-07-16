<?php 
// echo '<pre>';print_r($get_user_details);exit;
?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<?php $type = "Consumer Profile Attributes";
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
		<input type="hidden" name="cpm_id" id="cpm_id" value="<?php echo $get_user_details[0]['cpm_id']?>" />
        <div class="widget-main">
		
		
				<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Attribute Type</label><?php //echo $get_user_details[0]['cpm_id']?>
			<select name="attribute_type_slug" id="attribute_type_slug" class="form-control">
			<option value="<?php echo $get_user_details[0]['cpm_type_slug'];?>-<?php echo $val['profile_bucket'];?>" selected><?php echo $get_user_details[0]['cpm_type_name'];?></option> 
			
			<?php foreach(get_all_consumer_profile_attribute_types('0') as $val){?>
				<option value="<?php echo $val['cpatm_name_slug'];?>-<?php echo $val['profile_bucket'];?>"><?php  echo $val['cpatm_name'];?></option> 
			<?php }?>
			
         </select>
		</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Attributes Name</label>
			  <input type="text" placeholder="Please Enter Attributes Name" value="<?php echo $get_user_details[0]['cpm_name'];?>" name="attribute_name" id="attribute_name" class="form-control">			  
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Attribute Slug</label>
			  <input type="text" placeholder="Attribute Slug" value="<?php echo $get_user_details[0]['cpm_slug'];?>" name="cpm_slug" id="cpm_slug" class="form-control" readonly>			  
			</div>
		</div>
		<div align="center">
		<div class="col-sm-12">			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
			</div>


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
			<a href="<?php echo base_url('consumer/list_consumer_profile_attributes/') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to Consumer Profile Attributes <?php echo $label; ?> </a>
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
