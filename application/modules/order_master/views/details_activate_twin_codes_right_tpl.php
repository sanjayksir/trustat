<?php  // echo '<pre>';print_r($edit_customer_code_tpl);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">Activate Codes</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
			<input type="hidden" name="print_batch_id" id="print_batch_id" value="<?php echo $get_activate_codes_details[0]['print_batch_id'];?>" /><?php //echo get_assigned_locations_product($get_activate_codes_details[0]['product_id']);?>
			<input type="hidden" name="location_id" id="location_id" value="<?php echo get_assigned_locations_product($get_activate_codes_details[0]['product_id']);?>" />
        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-6" style="">
			<label for="form-field-8"><b>Order ID</b> : <?php echo $get_activate_codes_details[0]['order_id']; ?></label>
			</div>
			
			<div class="col-sm-6">
			<label for="form-field-8"><b>Batch ID</b> : <?php echo $get_activate_codes_details[0]['print_batch_id'];?></label>
			</div>
		</div>
		
			
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Packaging Level:</b></label> 
			
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8">In Twin codes; QR code is always Level 1 and Bar code is Level 0</label>
			  
			</div>
		</div>
		
           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Activate" id="savemenu" />
			<a href="<?php echo base_url('order_master/list_orders') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to Order Management <?php //echo $label; ?> </a>
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
