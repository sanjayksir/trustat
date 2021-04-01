<?php 
// echo '<pre>';print_r($get_user_details);exit;
?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<?php $type = "Auto Email MIS Customer";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='edit_plant_controller'){
									$type = "User";
								}?>
      <h4 class="widget-title">View <?php echo $type;?></h4>
		<div class="widget-toolbar"> <a href="<?php echo base_url('consumer/list_consumer_profile_attributes/') ?>" > <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="<?php echo base_url('consumer/list_consumer_profile_attributes/') ?>" > <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
		<form name="user_frm" id="user_frm" action="#" method="POST">
		<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $get_user_details[0]['customer_id']?>" />
		<input type="hidden" name="rc_id" id="rc_id" value="<?php echo $get_user_details[0]['rc_id']?>" />
        <div class="widget-main">
		
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Auto Email MIS Master Name</b><?php //echo $this->uri->segment(3); ?></label><?php //echo getAttributeSlugByName("Laptop"); ?>
			<br />
			<?php echo $get_user_details[0]['mis_report_name'];?>			
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Auto Email MIS Frequency</b></label><br />
			<?php echo $get_user_details[0]['auto_email_frequency'];?>  
			</div>
		
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Auto Email MIS Data Duration</b></label><br />
			<?php echo $get_user_details[0]['mis_data_duration'];?>
			</div>
			
		</div>
		
		<div class="form-group row">
		<div class="col-sm-4">
			  <label for="form-field-8"><b>Auto Email MIS Status</b></label><br />
			<?php echo $get_user_details[0]['active_status'];?>
			</div>
		
			<div class="col-sm-8">
	  <label for="form-field-8"><b>Auto Email MIS to Email IDs </b></label>
<br />
			<?php echo $get_user_details[0]['to_email_ids'];?>		  		
			</div>
		</div>
		
			<div class="form-group row">
		<div class="col-sm-4">
	  <label for="form-field-8"><b>Auto Email MIS Email Subject</b></label>	<br />
			<?php echo $get_user_details[0]['email_subject'];?>	  		
			</div>
		
			<div class="col-sm-8">
	  <label for="form-field-8"><b>Auto Email MIS to Email Body</b></label>
	  <br />
			<?php echo $get_user_details[0]['email_body'];?>		  		
			</div>
		</div>
		
          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
			<a href="<?php echo base_url('role_master/list_all_auto_email_mis_customer'); ?>/<?php echo $get_user_details[0]['customer_id'];?>" class="btn btn-info" title="Back to List Auto Email MIS Customer">Back to List Auto Email MIS Customer<?php echo $label; ?> </a>
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
