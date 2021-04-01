<?php 
// echo '<pre>';print_r($get_user_details);exit;
?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<?php $type = "Auto Email MIS Master";
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
		<input type="hidden" name="r_id" id="r_id" value="<?php echo $get_user_details[0]['r_id']?>" />
        <div class="widget-main">
		
		
				<div class="form-group row">
			
			
			<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Master Name</label>
			  <input type="text" placeholder="Please Enter Auto Email MIS Master Name" value="<?php echo $get_user_details[0]['mis_report_name'];?>" name="mis_report_name" id="mis_report_name" class="form-control">			  
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Master Slug</label>
			  <input type="text" placeholder="Auto Email MIS Master Slug" value="<?php echo $get_user_details[0]['mis_report_slug'];?>" name="functionality_name_slug" id="mis_report_slug" class="form-control" readonly>			  
			</div>
		</div>
		<div align="center">
		<div class="col-sm-12">			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
			</div>


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
			<a href="<?php echo base_url('role_master/list_all_auto_email_mis_masters') ?>" class="btn btn-info" title="Back to List Auto Email MIS Master">Back to List Auto Email MIS Master<?php echo $label; ?> </a>
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
