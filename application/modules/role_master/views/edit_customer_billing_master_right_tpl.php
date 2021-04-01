<?php 
// echo '<pre>';print_r($get_user_details);exit;
?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<?php $type = "Customer Billing Master";
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
		<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $get_user_details[0]['customer_id']?>" />
		<input type="hidden" name="cbpm_id" id="cbpm_id" value="<?php echo $get_user_details[0]['cbpm_id']?>" />
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Billing Master Slug</b> : </label> <?php echo $get_user_details[0]['billin_particular_slug']?>
			
			</div>
			
			
			
		</div>
		
		<div class="form-group row">
		
			<div class="col-sm-8">
	  <label for="form-field-8">Billing Master Name</label>	
<textarea class="form-control" name="billin_particular_name" placeholder="Please Enter Billing Master Name"  maxlength="100" required><?php echo $get_user_details[0]['billin_particular_name'];?></textarea>			  		
			</div>
		</div>
		
			
		
		<div align="center">
		<div class="col-sm-12">			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
			</div>


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
			<a href="<?php echo base_url('role_master/list_all_customer_billing_masters'); ?>" class="btn btn-info" title="Back to List Customer Billing Master">Back to List Customer Billing Master<?php echo $label; ?> </a>
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
