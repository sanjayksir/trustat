<?php  // echo '<pre>';print_r($get_user_details);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">View/Edit Messages Notification</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
		<input type="hidden" name="id" id="id" value="<?php echo  $get_user_details[0]['id']?>" /><?php //echo  $get_user_details[0]['id']?>

        <div class="widget-main">
		
		
		
		 <?php if($this->session->userdata('admin_user_id')==1){ ?>
		
		<div class="form-group row">
			<div class="col-sm-12">
			  <label for="form-field-12"><?php echo $get_user_details[0]['module_submodule_location_details'];?></label>
			  
			<textarea  class="form-control" name="message_notification_value" placeholder="Write your message..."  maxlength="500"><?php echo $get_user_details[0]['message_notification_value'];?></textarea>
			
			<?php 
			  if(($get_user_details[0]['id']==1)||($get_user_details[0]['id']==5))
			  {
				  //echo $user_registration_points;
			  ?>
			  [....]
			<textarea  class="form-control" name="message_notification_value_part2" placeholder="Write your message..."  maxlength="500"><?php echo $get_user_details[0]['message_notification_value_part2'];?></textarea>
			  <?php 
			  }
			  ?>
			  
			  <?php 
			  if($get_user_details[0]['id']==6)
			  {
				  echo $user_registration_points;
			  ?>
			  
			<textarea  class="form-control" name="message_notification_value_part2" placeholder="Write your message..."  maxlength="500"><?php echo $get_user_details[0]['message_notification_value_part2'];?></textarea>
			  <?php 
			  }
			  ?>
			  
			  <?php 
			  if(($get_user_details[0]['id']==38)||($get_user_details[0]['id']==44))
			  {
				  echo "X";
			  ?>
			  
			<textarea  class="form-control" name="message_notification_value_part2" placeholder="Write your message..."  maxlength="500"><?php echo $get_user_details[0]['message_notification_value_part2'];?></textarea>
			  <?php 
			  }
			  ?>
			
			</div>
			 
			<!--
			<div class="col-sm-6">
			  <label for="form-field-8">Loyalty Points Redeemed in Multiple of</label>
			 <input name="points_redeem_in_multiples_of" id="points_redeem_in_multiples_of" type="text" value="<?php //echo $get_user_details[0]['points_redeem_in_multiples_of'];?>" class="form-control" placeholder="Last Name"  maxlength="30">
			</div>
			-->
		</div>
		
		<?php }?>
		
		
		 
		     

           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
			<a href="<?php echo base_url('user_master/list_message_notification_master') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to List Messages Notification <?php echo $label; ?> </a>
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
