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
			<input type="hidden" name="code_id" id="code_id" value="<?php echo $get_registered_products_by_consumers_details[0]['id'];?>" /><?php echo $get_registered_products_by_consumers_details[0]['id']?>
        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-6" style="">
			<label for="form-field-8"><b>Consumer Name</b> : <?php echo getConsumerNameById($get_registered_products_by_consumers_details[0]['consumer_id']); ?></label>
			</div>
			
			<div class="col-sm-6">
			 
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Product Code</b> : <?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Product Name</b> : <?php echo get_products_name_by_id($get_registered_products_by_consumers_details[0]['product_id']);?></label>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Product Image</b> : <a href="<?php echo base_url().$get_registered_products_by_consumers_details[0]['invoice_image'];?>" onclick="window.open (this.href, 'child', 'height=800,width=900'); return false"><img alt="Invoice Image not available" src="<?php echo base_url(). $get_registered_products_by_consumers_details[0]['invoice_image'];?>" height="50" width="50"></a></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Date of Product Registration</b> : <?php echo $get_registered_products_by_consumers_details[0]['modified'];?></label>
			</div>
		</div>
				
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Invoice Number</label>
			<input name="invoice_number" id="invoice_number" type="text" class="form-control" placeholder="Invoice Number" value="<?php echo $get_registered_products_by_consumers_details[0]['invoice'];?>">
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8">Date of Purchase</label>
             <input name="purchase_date" id="purchase_date" type="text" class="form-control" placeholder="Date of Purchase" value="<?php echo $get_registered_products_by_consumers_details[0]['purchase_date'];?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Warranty Start Date</label>
			<input name="warranty_start_date" id="warranty_start_date" type="text" class="form-control" placeholder="Warranty Start Date" value="<?php echo $get_registered_products_by_consumers_details[0]['warranty_start_date'];?>">
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8">Warranty End Date</label>
             <input name="warranty_end_date" id="warranty_end_date" type="text" class="form-control" placeholder="Warranty End Date" value="<?php echo $get_registered_products_by_consumers_details[0]['warranty_end_date'];?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Expiry Date</label>
			<input name="expiry_date" id="expiry_date" type="text" class="form-control" placeholder="Expiry Date" value="<?php echo $get_registered_products_by_consumers_details[0]['expiry_date'];?>">
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8">Verification Status</label>
			  
             <input name="status" id="status" type="text" class="form-control" placeholder="Consumer Name" value="<?php echo $get_registered_products_by_consumers_details[0]['status'];?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Name of Seller</label>
			<input name="seller_name" id="seller_name" type="text" class="form-control" placeholder="Name of Seller" value="<?php echo $get_registered_products_by_consumers_details[0]['seller_name'];?>">
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8">GST Number of Seller</label>
             <input name="seller_gst" id="seller_gst" type="text" class="form-control" placeholder="GST Number of Seller" value="<?php echo $get_registered_products_by_consumers_details[0]['seller_gst'];?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Selling Price</label>
			<input name="selling_price" id="selling_price" type="text" class="form-control" placeholder="Selling Price" value="<?php echo $get_registered_products_by_consumers_details[0]['selling_price'];?>">
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8">Discount</label>
             <input name="discount" id="discount" type="text" class="form-control" placeholder="Discount" value="<?php echo $get_registered_products_by_consumers_details[0]['discount'];?>">
			</div>
		</div>
		
		 

           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />

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
