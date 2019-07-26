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
			<label for="form-field-8">Packaging Level</label>
			<select class="form-control" placeholder="Select Packaging Level" id="PackagingLevel" name="PackagingLevel" >
			<option value="0" selected> 0 </option>
			<option value="1"> 1 </option> 
			<!--<option value="2"> 2 </option>
			<option value="3"> 3 </option>
			<option value="4"> 4 </option>
			<option value="5"> 5 </option>
			<option value="6"> 6 </option>
			<option value="7"> 7 </option>
			<option value="8"> 8 </option>
			<option value="9"> 9 </option>
			<option value="10"> 10 </option>
			<option value="11"> 11 </option>
			<option value="12"> 12 </option>
			<option value="13"> 13 </option>
			<option value="14"> 14 </option>
			<option value="15"> 15 </option>
			<option value="16"> 16 </option>
			<option value="17"> 17 </option>
			<option value="18"> 18 </option>
			<option value="19"> 19 </option>
			<option value="20"> 20 </option>
			<option value="21"> 21 </option>-->
			 </select>  
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8"></label>
			  
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
