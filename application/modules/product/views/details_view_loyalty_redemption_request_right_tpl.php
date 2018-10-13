<?php  // echo '<pre>';print_r($edit_customer_code_tpl);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">Loyalty Redemption Request Details</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
			<input type="hidden" name="lr_id" id="lr_id" value="<?php echo $get_loyalty_redemption_requests_details[0]['lr_id'];?>" /><?php //echo $get_loyalty_redemption_requests_details[0]['lr_id']?>
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $get_loyalty_redemption_requests_details[0]['user_id'];?>" /><?php //echo $get_loyalty_redemption_requests_details[0]['user_id']?>
			<input type="hidden" name="points_redeemed" id="points_redeemed" value="<?php echo $get_loyalty_redemption_requests_details[0]['points_redeemed'];?>" />
			<input type="hidden" name="consumer_address" id="consumer_address" value="<?php echo $get_loyalty_redemption_requests_details[0]['street_address'].", ".$get_loyalty_redemption_requests_details[0]['city'].", ".$get_loyalty_redemption_requests_details[0]['state'].", ".$get_loyalty_redemption_requests_details[0]['pin_code'];?>" />
        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-6" style="">
			<label for="form-field-8"><b>Consumer Name</b> : <?php echo getConsumerNameById($get_loyalty_redemption_requests_details[0]['user_id']); ?></label>
			</div>
			
			<div class="col-sm-6">
			<label for="form-field-8"><b>Consumer Phone</b> : <?php echo getConsumerMobileNumberById($get_loyalty_redemption_requests_details[0]['user_id']);?></label>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Points Redeemed</b> : <?php echo $get_loyalty_redemption_requests_details[0]['points_redeemed'];?></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Redemption Request Number</b> : <?php echo $get_loyalty_redemption_requests_details[0]['redemption_id'];?></label>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Consumer Alt. Phone</b> : <?php echo $get_loyalty_redemption_requests_details[0]['alternate_mobile_no'];?></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Date of Redemption</b> : <?php echo $get_loyalty_redemption_requests_details[0]['l_created_at'];?></label>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Address </b> : <?php echo $get_loyalty_redemption_requests_details[0]['street_address'].", ".$get_loyalty_redemption_requests_details[0]['city'].", ".$get_loyalty_redemption_requests_details[0]['state'].", ".$get_loyalty_redemption_requests_details[0]['pin_code'];?></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Consumer Aadhaar Number</b> : <?php echo $get_loyalty_redemption_requests_details[0]['aadhaar_number'];?></label>
			</div>
		</div>
								
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Coupon Number</b> : <?php echo $get_loyalty_redemption_requests_details[0]['coupon_number'];?></label>
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Coupon Type</b> : <?php echo $get_loyalty_redemption_requests_details[0]['coupon_type'];?></label>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Coupon Vendor </b>: <?php echo $get_loyalty_redemption_requests_details[0]['coupon_vendor'];?> </label>
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Courier Number</b> : <?php echo $get_loyalty_redemption_requests_details[0]['courier_details'];?></label>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"> <b>Approval Status</b> : <?php 
			
			$l_status = $get_loyalty_redemption_requests_details[0]['l_status'];
			if($l_status==1) {?>			
			Approval Successful			
			<?php } else {?>
			<Approval Pending
			<?php } ?></label>
			  
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8"></label>
			  
			</div>
		</div>
		
           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
			<?php echo anchor("product/list_loyalty_redemption_requests/" . $listData['lr_id'], '<i class="ace-icon fa fa-back-arrow bigger-130">Back to List</i>', array('class' => 'btn btn-xs btn-info','title'=>'Back to List')); ?>
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
