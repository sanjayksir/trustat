<?php  // echo '<pre>';print_r($get_user_details);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">View Assign Loyalty to Functionality / Role</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
	<input type="hidden" name="assign_id" id="assign_id" value="<?php echo  $get_user_details[0]['assign_id']?>" />
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Role ID</b></label> : <?php echo  $get_user_details[0]['role_id']?>
			<!--<input name="role_id" readonly="" id="role_id" type="text" class="form-control" value="<?php echo  $get_user_details[0]['role_id']?>" >-->
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Product Management</b></label> : <?php echo  $get_user_details[0]['product_management']?>
             <!--<input name="product_management" id="product_management" type="text" class="form-control" value="<?php echo  $get_user_details[0]['product_management']?>" placeholder="0">-->
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Bar Code Ordering</b></label> : <?php echo  $get_user_details[0]['bar_code_ordering']?>
            <!-- <input name="bar_code_ordering" id="bar_code_ordering" type="text" class="form-control" value="<?php echo  $get_user_details[0]['bar_code_ordering']?>" placeholder="0">-->
			</div>
			
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Bar code delivery online</b></label> : <?php echo  $get_user_details[0]['bar_code_delivery_online']?>
			<!--<input name="bar_code_delivery_online" id="bar_code_delivery_online" type="text" class="form-control" value="<?php echo  $get_user_details[0]['bar_code_delivery_online']?>" placeholder="0">-->
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Bar code printing online</b></label> : <?php echo  $get_user_details[0]['bar_code_printing_online']?>
           <!--  <input name="bar_code_printing_online" id="bar_code_printing_online" type="text" class="form-control" value="<?php echo  $get_user_details[0]['bar_code_printing_online']?>" placeholder="0">-->
			</div>
			
			<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Bar code printing offline</b></label> : <?php echo  $get_user_details[0]['bar_code_printing_offline']?>
			<!--<input name="bar_code_printing_offline" id="bar_code_printing_offline" type="text" class="form-control" value="<?php echo  $get_user_details[0]['bar_code_printing_offline']?>" placeholder="0">-->
			</div>		
			</div>
		
			</div>
			
			<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Barcode Activation</b></label> : <?php echo  $get_user_details[0]['bar_code_activation_for_all_levels']?>
             <!--<input name="bar_code_activation_for_all_levels" id="bar_code_activation_for_all_levels" type="text" class="form-control" value="<?php echo  $get_user_details[0]['bar_code_activation_for_all_levels']?>" placeholder="0">-->
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Dispatch from plant/Warehouse(Transfer-Out) </b></label> : <?php echo  $get_user_details[0]['dispatch_from_plant_or_warehouse_to_warehouse']?>
             <!--<input name="dispatch_from_plant_or_warehouse_to_warehouse" id="dispatch_from_plant_or_warehouse_to_warehouse" type="text" class="form-control" value="<?php echo  $get_user_details[0]['dispatch_from_plant_or_warehouse_to_warehouse']?>" placeholder="0">-->
			</div>	

			<div class="col-sm-4">
			<label for="form-field-8"><b>Receipt at Warehouse/Plant(Stock Transfer-In)</b></label> : <?php echo  $get_user_details[0]['receipt_at_warehouse_or_plant']?>
			<!--<input name="receipt_at_warehouse_or_plant" id="receipt_at_warehouse_or_plant" type="text" class="form-control" value="<?php echo  $get_user_details[0]['receipt_at_warehouse_or_plant']?>" placeholder="0">-->
			</div>
			
			</div>
		
		<div class="form-group row">
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Dispatch from plant/Warehouse(Customer Sale)</b></label> : <?php echo  $get_user_details[0]['dispatch_from_plant_or_warehouse_to_customers']?>
            <!-- <input name="dispatch_from_plant_or_warehouse_to_customers" id="dispatch_from_plant_or_warehouse_to_customers" type="text" class="form-control" value="<?php echo  $get_user_details[0]['dispatch_from_plant_or_warehouse_to_customers']?>" placeholder="0-->
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Product Return from Customer</b></label> : <?php echo  $get_user_details[0]['product_return_from_customer']?>
         <!--    <input name="product_return_from_customer" id="product_return_from_customer" type="text" class="form-control" value="<?php echo  $get_user_details[0]['product_return_from_customer']?>" placeholder="0">-->
			</div>	

			<div class="col-sm-4">
			<label for="form-field-8"><b>Physical inventory check</b></label> : <?php echo  $get_user_details[0]['physical_inventory_check']?>
		<!--	<input name="physical_inventory_check" id="physical_inventory_check" type="text" class="form-control" value="<?php echo  $get_user_details[0]['physical_inventory_check']?>" placeholder="0">-->
			</div>
		</div>
		
		
		
		<div class="form-group row">
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Packaging</b></label> : <?php echo  $get_user_details[0]['packaging']?>
             <!--<input name="packaging" id="packaging" type="text" class="form-control" value="<?php echo  $get_user_details[0]['packaging']?>" placeholder="0">-->
			</div>
			
			<div class="col-sm-4">
			<label for="form-field-8"><b>Unpackaging</b></label> : <?php echo  $get_user_details[0]['unpackaging']?>
			<!--<input name="unpackaging" id="unpackaging" type="text" class="form-control" value="<?php echo  $get_user_details[0]['unpackaging']?>" placeholder="0">-->
			</div>	

			<div class="col-sm-4">
			  <label for="form-field-8"><b>Physical Inventory On Hand</b></label> : <?php echo  $get_user_details[0]['physical_inventory_on_hand']?>
            <!-- <input name="physical_inventory_on_hand" id="physical_inventory_on_hand" type="text" class="form-control" value="<?php echo  $get_user_details[0]['physical_inventory_on_hand']?>" placeholder="0">-->
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Link Barcode with Production Batch Id</b></label> : <?php echo  $get_user_details[0]['link_barcode_with_production_batch_id']?>
           <!--  <input name="link_barcode_with_production_batch_id" id="link_barcode_with_production_batch_id" type="text" class="form-control" value="<?php echo  $get_user_details[0]['link_barcode_with_production_batch_id']?>" placeholder="0">-->
			</div>	

			<div class="col-sm-4">
			<label for="form-field-8"><b>Shipper Box Barcode Activation</b></label> : <?php echo  $get_user_details[0]['shipper_box_barcode_activation']?>
		<!--	<input name="shipper_box_barcode_activation" id="shipper_box_barcode_activation" type="text" class="form-control" value="<?php echo  $get_user_details[0]['shipper_box_barcode_activation']?>" placeholder="0">-->
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Ship Out Order</b></label> : <?php echo  $get_user_details[0]['ship_out_order']?>
           <!--  <input name="ship_out_order" id="ship_out_order" type="text" class="form-control" value="<?php echo  $get_user_details[0]['ship_out_order']?>" placeholder="0">-->
			</div>	
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Activate Printed Batched of Codes</b></label> : <?php echo  $get_user_details[0]['activate_printed_batched_of_codes']?></div>
			<div class="col-sm-4">
			<label for="form-field-8"><b>Loyalty Redemption while Consumer shopping</b></label> : <?php echo  $get_user_details[0]['loyalty_redemption_while_consumer_shopping']?></div>
			<div class="col-sm-4">
			<label for="form-field-8"><b>Scan for List following Codes</b></label> : <?php echo  $get_user_details[0]['scan_for_list_following_codes']?></div>
		</div>
		
		
		  <?php $userId 	=$this->session->userdata('admin_user_id');
			if($userId==1){?>
		 <div class="form-group row">
		     <div class="col-sm-6">
            <?php //echo '<pre>';print_r($get_user_details);?>
			  <label for="form-field-9">CCC Admin</label>
			 <?php $ccadmin = getParentUsers('','1');?>
             <select class="form-control" placeholder="Select Admin" id="ccadmin" name="ccadmin">
			 <option value="">-Select CCC Admin-</option>
  		  		<?php foreach($ccadmin as $val){?>
				<option <?php if($val['user_id']==$get_user_details[0]['created_by']){echo 'selected';}?> value="<?php echo $val['user_id'];?>"><?php  echo $val['user_name'];?></option> 
			 	<?php }?>
			 </select>  
 			</div> 
		</div>
		<?php }?>


           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
		   <div class="widget-toolbar">
                                    <a href="<?php echo base_url('plant_master/list_assigned_activity_role') ?>" class="btn btn-xs btn-warning" title="Assign Plant to Plant Controller">Back to List / Assign Activity to Role  </a>
                                </div>

         <!--   <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />-->

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
