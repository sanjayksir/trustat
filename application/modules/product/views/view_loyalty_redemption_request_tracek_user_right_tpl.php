<?php  // echo '<pre>';print_r($edit_customer_code_tpl);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">Loyalty Redemption Request Tracek User</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
			<input type="hidden" name="tr_lr_id" id="tr_lr_id" value="<?php echo $get_loyalty_redemption_requests_details[0]['tr_lr_id'];?>" /><?php //echo $get_loyalty_redemption_requests_details[0]['tr_lr_id']?>
			<input type="hidden" name="tr_user_id" id="tr_user_id" value="<?php echo $get_loyalty_redemption_requests_details[0]['tr_user_id'];?>" /><?php //echo $get_loyalty_redemption_requests_details[0]['tr_user_id']?>
			<input type="hidden" name="points_redeemed" id="points_redeemed" value="<?php echo $get_loyalty_redemption_requests_details[0]['tr_lr_points_redeemed'];?>" />
			<!--<input type="hidden" name="consumer_address" id="consumer_address" value="<?php echo $get_loyalty_redemption_requests_details[0]['street_address'].", ".$get_loyalty_redemption_requests_details[0]['city'].", ".$get_loyalty_redemption_requests_details[0]['state'].", ".$get_loyalty_redemption_requests_details[0]['pin_code'];?>" />-->
        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-6" style="">
			<label for="form-field-8"><b>Tracek User Name</b> : <?php echo $get_loyalty_redemption_requests_details[0]['l_name']; ?></label>
			</div>
			
			<div class="col-sm-6">
			<label for="form-field-8"><b>Tracek User Phone</b> : <?php echo $get_loyalty_redemption_requests_details[0]['mobile_no'];?></label>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Points Redeemed</b> : <?php echo $get_loyalty_redemption_requests_details[0]['tr_lr_points_redeemed'];?></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Redemption Request Number</b> : <?php echo $get_loyalty_redemption_requests_details[0]['tr_lr_redemption_id'];?></label>
			</div>
		</div>
		<div class="form-group row">
			
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Date of Redemption</b> : <?php echo $get_loyalty_redemption_requests_details[0]['l_created_at'];?></label>
			</div>
			
			<div class="col-sm-6">
			 <label for="form-field-8"><b>Email ID</b> : <?php echo $get_loyalty_redemption_requests_details[0]['email_id'];?></label>
			</div>			
		</div>
		
								
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Approval Number</b> : <?php echo $get_loyalty_redemption_requests_details[0]['coupon_number'];?></label>
			
			
			</div>
			<div class="col-sm-6">
			<label for="form-field-8"><b>Payment Type/Mode</b> : <?php echo $get_loyalty_redemption_requests_details[0]['coupon_type'];?></label>
			
			
			</div>
		</div>
		<!--<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Coupon Vendor</label>
			<input name="coupon_vendor" id="coupon_vendor" type="text" class="form-control" placeholder="Coupon Vendor" value="<?php echo $get_loyalty_redemption_requests_details[0]['coupon_vendor'];?>">
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8">Courier Number</label>
             <input name="courier_details" id="courier_details" type="text" class="form-control" placeholder="Courier Details" value="<?php echo $get_loyalty_redemption_requests_details[0]['courier_details'];?>">
			</div>
		</div>
		-->
		<div class="form-group row">
			<div class="col-sm-6">			
			<label for="form-field-8"><b>Approval Number</b> : <?php $l_status = $get_loyalty_redemption_requests_details[0]['l_status'];
			if($l_status==1) {
				echo "Approval Successful";
				} else {
				echo "Approval Pending";	
				}
			?></label>
			 
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8"></label>
			  
			</div>
		</div>
		
           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

			<a href="<?php echo base_url('product/tracek_loyalty_redemption') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to List Loyalty Redemption Requests <?php echo $label; ?> </a>
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
