<?php  // echo '<pre>';print_r($get_user_details);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">View/Edit Loyalty Matrix</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
<input type="hidden" name="id" id="id" value="<?php echo  $get_user_details[0]['id']?>" /><?php //echo  $get_user_details[0]['id']?>
<input type="hidden" name="transaction_type" id="transaction_type" value="<?php echo  $get_user_details[0]['transaction_type']?>" />
<input type="hidden" name="transaction_type_slug" id="transaction_type_slug" value="<?php echo  $get_user_details[0]['transaction_type_slug']?>" />
<input type="hidden" name="created_at" id="created_at" value="<?php echo  $get_user_details[0]['created_at']?>" />
        <div class="widget-main">
		
		
		
		 <?php if($this->session->userdata('admin_user_id')==1){ ?>
		
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8"><?php echo $get_user_details[0]['transaction_type'];?></label>
			<input name="loyalty_points" id="loyalty_points" type="text" value="<?php echo $get_user_details[0]['loyalty_points'];?>" class="form-control" placeholder="Loyalty Points"  maxlength="30">
			</div>
			 
			
			<div class="col-sm-6">
			  <label for="form-field-8">Expiry Days</label>
	<input name="expiry_days" id="expiry_days" type="text" value="<?php echo $get_user_details[0]['expiry_days'];?>" class="form-control" placeholder="Last Name"  maxlength="30">
			</div>	

			<div class="col-sm-6">
			  <label for="form-field-8">Active Status</label>
			<select name="active_status" id="active_status" class="form-control">
			<option value="Active" <?php echo ($get_user_details['active_status']=='Active')?'selected':'';?>>Active</option>
			<option value="InActive"<?php echo ($get_user_details['active_status']=='InActive')?'selected':'';?>>InActive</option>
			</select>
			</div>				
		</div>
		
		<?php }?>
		
		
		 
		     

           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
			<a href="<?php echo base_url('user_master/list_common_points_loyalty') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to List Loyalty Matrix <?php echo $label; ?> </a>
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
