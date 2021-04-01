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
      <h4 class="widget-title">Edit <?php echo $type;?></h4>
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
			<!--
		<select  name="mis_report_slug" id="mis_report_slug" class="form-control" readonly required>
			<option value="">-Select Auto Email MIS Master Name-</option>	
			<?php foreach(get_all_auto_email_mis_masters('0') as $val){?>
				<option value="<?php echo $val['mis_report_slug'];?>" <?php echo ($get_user_details[0]['mis_report_slug']==$val['mis_report_slug'])?'selected':'';?>><?php  echo $val['mis_report_name'];?></option> 
			<?php }?>
         </select>-->
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Frequency</label>
			 <select  name="auto_email_frequency" id="auto_email_frequency" class="form-control" required>
			<option value="">-Select Auto Email MIS Frequency-</option>
				<option value="Daily" <?php echo ($get_user_details[0]['auto_email_frequency']=='Daily')?'selected':'';?>>Daily</option>	
				<option value="Weekly" <?php echo ($get_user_details[0]['auto_email_frequency']=='Weekly')?'selected':'';?>>Weekly</option>
				<option value="Monthly" <?php echo ($get_user_details[0]['auto_email_frequency']=='Monthly')?'selected':'';?>>Monthly</option>
				<option value="Yearly" <?php echo ($get_user_details[0]['auto_email_frequency']=='Yearly')?'selected':'';?>>Yearly</option>	
			</select>			  
			</div>
		
			<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Data Duration</label>
			 <select  name="mis_data_duration" id="mis_data_duration" class="form-control" required>
			<option value="">-Select Auto Email MIS Data Duration-</option>
				<option value="Day" <?php echo ($get_user_details[0]['mis_data_duration']=='Day')?'selected':'';?>>Last 1 Day</option>	
				<option value="Week" <?php echo ($get_user_details[0]['mis_data_duration']=='Week')?'selected':'';?>>Last 1 Week</option>
				<option value="Month" <?php echo ($get_user_details[0]['mis_data_duration']=='Month')?'selected':'';?>>Last 1 Month</option>
				<option value="Year" <?php echo ($get_user_details[0]['mis_data_duration']=='Year')?'selected':'';?>>Last 1 Year</option>	
			</select>			  
			</div>
			
		</div>
		
		<div class="form-group row">
		<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Status</label>
			 <select  name="active_status" id="active_status" class="form-control" required>
					<option value="">-Select Auto Email MIS Status-</option>
						<option value="Continue" <?php echo ($get_user_details[0]['active_status']=='Continue')?'selected':'';?>>Continue</option>	
						<option value="Stop" <?php echo ($get_user_details[0]['active_status']=='Stop')?'selected':'';?>>Stop</option>
				 </select>		  
			</div>
		
			<div class="col-sm-8">
	  <label for="form-field-8">Auto Email MIS to Email IDs (You can insert more than 1 Email IDs, Comma delimated.)</label>	
<textarea class="form-control" name="to_email_ids" placeholder="Please Enter customer email ids to receive Auto Email MIS. You can insert more than 1 Email IDs, Comma delimated"  maxlength="500" required><?php echo $get_user_details[0]['to_email_ids'];?></textarea>			  		
			</div>
		</div>
		
			<div class="form-group row">
		<div class="col-sm-4">
	  <label for="form-field-8">Auto Email MIS Email Subject</label>	
<textarea class="form-control" name="email_subject" placeholder="Please Enter Auto Email MIS Subject."  maxlength="500" required><?php echo $get_user_details[0]['email_subject'];?></textarea>			  		
			</div>
		
			<div class="col-sm-8">
	  <label for="form-field-8">Auto Email MIS to Email Body</label>	
<textarea class="form-control" name="email_body" placeholder="Please Enter Auto Email MIS Body"  maxlength="500" required><?php echo $get_user_details[0]['email_body'];?></textarea>			  		
			</div>
		</div>
		
		
		<div align="center">
		<div class="col-sm-12">			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
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
