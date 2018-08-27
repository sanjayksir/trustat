<?php  // echo '<pre>';print_r($edit_customer_code_tpl);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">Edit Customer Code</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
			<input type="hidden" name="code_id" id="code_id" value="<?php echo $get_registered_products_by_consumers_details[0]['id'];?>" /><?php echo $get_registered_products_by_consumers_details[0]['id']?>
        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Printed Code</b> : <?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Product Name</b> : <?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></label>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Product Image</b> : <?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Date of Product Registration</b> : <?php echo date("d/m/y"); ?></label>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Printed Code</b> : <?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></label>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Date of Product Registration</b> : <?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></label>
			</div>
		</div>
		
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Printed Code<?php //echo $get_registered_products_by_consumers_details[0]['id'];?></label>
			<div class="form-control"><?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></div>
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Customer Code</label>
             <input name="barcode_qr_code_no" id="barcode_qr_code_no" type="text" class="form-control" placeholder="Customer Code" value="<?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Printed Code<?php //echo $get_registered_products_by_consumers_details[0]['id'];?></label>
			<div class="form-control"><?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></div>
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Customer Code</label>
             <input name="barcode_qr_code_no" id="barcode_qr_code_no" type="text" class="form-control" placeholder="Customer Code" value="<?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?>">
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
