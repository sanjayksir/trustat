<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>role_master/list_assigned_functionalities_to_role/<?php echo $this->uri->segment(4); ?>" class="btn btn-primary pull-right" title="Back to List">Back to List</a></div>
<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Assign Loyalty to the Role for all Functionalities for  <?php echo getRoleNameById($this->uri->segment(3));?></h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>
		
	  
      <form name="user_frm" id="user_frm" action="#" method="POST">
	<input type="hidden" name="ccadmin" id="ccadmin" value="<?php echo $this->uri->segment(4); ?>" />
			
        <div class="widget-main">
		Customer Name : <?php echo  getUserFullNameById($this->uri->segment(4)); ?>
		<div class="form-group row">		
			<div class="col-sm-4">
			<label for="form-field-8">Role ID</label>
			<input name="role_id" readonly="" id="role_id" type="text" class="form-control" value="<?php echo $this->uri->segment(3);?>" >
			</div>
			
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(1, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(1); ?></label>
             <input name="product_management" id="product_management" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(2, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(2); ?></label>
             <input name="bar_code_ordering" id="bar_code_ordering" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
 		<div class="form-group row">
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(3, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(3); ?></label>
			<input name="bar_code_delivery_online" id="bar_code_delivery_online" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(4, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(4); ?></label>
             <input name="bar_code_printing_online" id="bar_code_printing_online" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(5, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(5); ?></label>
			<input name="bar_code_printing_offline" id="bar_code_printing_offline" type="text" class="form-control" placeholder="0">
			</div>		
			<?php } ?>
			</div>
			
			<div class="form-group row">
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(6, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(6); ?></label>
             <input name="bar_code_activation_for_all_levels" id="bar_code_activation_for_all_levels" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(7, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(7); ?></label>
             <input name="dispatch_from_plant_or_warehouse_to_warehouse" id="dispatch_from_plant_or_warehouse_to_warehouse" type="text" class="form-control" placeholder="0">
			</div>	
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(8, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(8); ?></label>
			<input name="receipt_at_warehouse_or_plant" id="receipt_at_warehouse_or_plant" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			</div>
		
		<div class="form-group row">			
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(9, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(9); ?></label>
             <input name="dispatch_from_plant_or_warehouse_to_customers" id="dispatch_from_plant_or_warehouse_to_customers" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(10, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(10); ?></label>
             <input name="product_return_from_customer" id="product_return_from_customer" type="text" class="form-control" placeholder="0">
			</div>	
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(11, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(11); ?></label>
			<input name="physical_inventory_check" id="physical_inventory_check" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
		<div class="form-group row">			
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(12, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(12); ?></label>
             <input name="packaging" id="packaging" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(13, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(13); ?></label>
			<input name="unpackaging" id="unpackaging" type="text" class="form-control" placeholder="0">
			</div>	
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(14, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(14); ?></label>
             <input name="physical_inventory_on_hand" id="physical_inventory_on_hand" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>	
		</div>
		
		<div class="form-group row">
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(15, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(15); ?></label>
             <input name="link_barcode_with_production_batch_id" id="link_barcode_with_production_batch_id" type="text" class="form-control" placeholder="0">
			</div>	
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(16, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(16); ?></label>
			<input name="shipper_box_barcode_activation" id="shipper_box_barcode_activation" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(17, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(17); ?></label>
             <input name="ship_out_order" id="ship_out_order" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>			
		</div>
		
		<div class="form-group row">
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(18, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(18); ?></label>
			<input name="activate_printed_batched_of_codes" id="activate_printed_batched_of_codes" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(19, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(19); ?></label>
			<input name="loyalty_redemption_while_consumer_shopping" id="loyalty_redemption_while_consumer_shopping" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(20, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(20); ?></label>
			<input name="scan_for_list_following_codes" id="scan_for_list_following_codes" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		       
        <div class="form-group row"><?php //echo  $this->uri->segment(3); ?><?php //echo  $this->uri->segment(4); ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(21, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(21); ?></label>
			<input name="functionality_1" id="functionality_1" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(22, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(22); ?></label>
			<input name="functionality_2" id="functionality_2" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(23, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(23); ?></label>
			<input name="functionality_3" id="functionality_3" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
		 <div class="form-group row"><?php //echo  $this->uri->segment(3); ?><?php //echo  $this->uri->segment(4); ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(24, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(24); ?></label>
			<input name="functionality_4" id="functionality_4" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(25, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(25); ?></label>
			<input name="functionality_5" id="functionality_5" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(26, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(26); ?></label>
			<input name="functionality_6" id="functionality_6" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
		 <div class="form-group row"><?php //echo  $this->uri->segment(3); ?><?php //echo  $this->uri->segment(4); ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(27, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(27); ?></label>
			<input name="functionality_7" id="functionality_7" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(28, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(28); ?></label>
			<input name="functionality_8" id="functionality_8" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(29, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(29); ?></label>
			<input name="functionality_9" id="functionality_9" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
		 <div class="form-group row"><?php //echo  $this->uri->segment(3); ?><?php //echo  $this->uri->segment(4); ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(30, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(30); ?></label>
			<input name="functionality_10" id="functionality_10" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(31, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(31); ?></label>
			<input name="functionality_11" id="functionality_11" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(32, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(32); ?></label>
			<input name="functionality_12" id="functionality_12" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
		
		 <div class="form-group row"><?php //echo  $this->uri->segment(3); ?><?php //echo  $this->uri->segment(4); ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(33, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(33); ?></label>
			<input name="functionality_13" id="functionality_13" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(34, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(34); ?></label>
			<input name="functionality_14" id="functionality_14" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(35, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(35); ?></label>
			<input name="functionality_15" id="functionality_15" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
		 <div class="form-group row"><?php //echo  $this->uri->segment(3); ?><?php //echo  $this->uri->segment(4); ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(36, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(36); ?></label>
			<input name="functionality_16" id="functionality_16" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(37, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(37); ?></label>
			<input name="functionality_17" id="functionality_17" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(38, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(38); ?></label>
			<input name="functionality_18" id="functionality_18" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
		 <div class="form-group row"><?php //echo  $this->uri->segment(3); ?><?php //echo  $this->uri->segment(4); ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(39, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(39); ?></label>
			<input name="functionality_19" id="functionality_19" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(40, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(40); ?></label>
			<input name="functionality_20" id="functionality_20" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
			<?php if(getFunctionalityAssignStatusByRoleByCustomerID(41, $this->uri->segment(3), $this->uri->segment(4))==true){ ?>
			<div class="col-sm-4">
			<label for="form-field-8"><?php echo FunctionalityNameByFunctionalityID(41); ?></label>
			<input name="functionality_21" id="functionality_21" type="text" class="form-control" placeholder="0">
			</div>
			<?php } ?>
		</div>
		
		
		
            <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />

          </div>

        </div>

      </form>

    </div>

  </div>

</div>
 