
<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">
		<?php $type = "Auto Email MIS Customer";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='add_plant_controller'){
									$type = "Auto Email MIS Customer";
								}?>
      <h4 class="widget-title">Add <?php echo $type;?></h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>

      <form name="user_frm" id="user_frm" action="#" method="POST">
	<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $this->uri->segment(3); ?>" />
        <div class="widget-main">		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Auto Email MIS Master Name<?php //echo $this->uri->segment(3); ?></label><?php //echo getAttributeSlugByName("Laptop"); ?>
		<select  name="mis_report_slug" id="mis_report_slug" class="form-control" required>
			<option value="">-Select Auto Email MIS Master Name-</option>	
			<?php foreach(get_all_auto_email_mis_masters('0') as $val){?>
				<option value="<?php echo $val['mis_report_slug'];?>"><?php  echo $val['mis_report_name'];?></option> 
			<?php }?>
         </select>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Frequency</label>
			 <select  name="auto_email_frequency" id="auto_email_frequency" class="form-control" required>
			<option value="">-Select Auto Email MIS Frequency-</option>
				<option value="Daily">Daily</option>	
				<option value="Weekly">Weekly</option>
				<option value="Monthly">Monthly</option>
				<option value="Yearly">Yearly</option>	
			</select>			  
			</div>
		
			<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Data Duration</label>
			 <select  name="mis_data_duration" id="mis_data_duration" class="form-control" required>
			<option value="">-Select Auto Email MIS Data Duration-</option>
				<option value="Day">Last 1 Day</option>	
				<option value="Week">Last 1 Week</option>
				<option value="Month">Last 1 Month</option>
				<option value="Year">Last 1 Year</option>	
			</select>			  
			</div>
			
		</div>
		
		<div class="form-group row">
		<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Status</label>
			 <select  name="active_status" id="active_status" class="form-control" required>
					<option value="">-Select Auto Email MIS Status-</option>
						<option value="Continue">Continue</option>	
						<option value="Stop">Stop</option>
				 </select>		  
			</div>
		
			<div class="col-sm-8">
	  <label for="form-field-8">Auto Email MIS to Email IDs (You can insert more than 1 Email IDs, Comma delimated.)</label>	
<textarea class="form-control" name="to_email_ids" placeholder="Please Enter customer email ids to receive Auto Email MIS. You can insert more than 1 Email IDs, Comma delimated"  maxlength="500" required></textarea>			  		
			</div>
		</div>
		
			<div class="form-group row">
		<div class="col-sm-4">
	  <label for="form-field-8">Auto Email MIS Email Subject</label>	
<textarea class="form-control" name="email_subject" placeholder="Please Enter Auto Email MIS Subject."  maxlength="500" required></textarea>			  		
			</div>
		
			<div class="col-sm-8">
	  <label for="form-field-8">Auto Email MIS to Email Body</label>	
<textarea class="form-control" name="email_body" placeholder="Please Enter Auto Email MIS Body"  maxlength="500" required></textarea>			  		
			</div>
		</div>
		
		<div class="form-group row" align="center">
			
			<div class="col-sm-12" align="center">
			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
		</div>


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            
			<a href="<?php echo base_url('role_master/list_all_auto_email_mis_customer'); ?>/<?php echo $this->uri->segment(3); ?>" class="btn btn-info" title="Back to List Auto Email MIS Customer">Back to List Auto Email MIS Customer<?php echo $label; ?> </a>	
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