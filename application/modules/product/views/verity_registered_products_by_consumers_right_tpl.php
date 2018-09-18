<?php  // echo '<pre>';print_r($edit_customer_code_tpl);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">Registered Product - Verify invoice</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
			<input type="hidden" name="code_id" id="code_id" value="<?php echo $get_registered_products_by_consumers_details[0]['purchased_product_id'];?>" /><?php //echo $get_registered_products_by_consumers_details[0]['purchased_product_id']?>
			<input type="hidden" name="consumer_id" id="consumer_id" value="<?php echo $get_registered_products_by_consumers_details[0]['consumer_id'];?>" />
        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-6" style="">
			<label for="form-field-8"><b>Consumer Name</b> : <?php echo getConsumerNameById($get_registered_products_by_consumers_details[0]['consumer_id']); ?></label><br />
			<label for="form-field-8"><b>Consumer Phone</b> : <?php echo getConsumerMobileNumberById($get_registered_products_by_consumers_details[0]['consumer_id']); ?></label><br />
			<label for="form-field-8"><b>Product Code</b> : <?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></label><br />
			
			<label for="form-field-8"><b>Product Name</b> : <?php echo get_products_name_by_id($get_registered_products_by_consumers_details[0]['product_id']);?></label><br />
			
			
			
			<b>Warranty</b> : Yes/No<br />
			<label for="form-field-8"><b>Date of Product Registration</b> : <?php echo $get_registered_products_by_consumers_details[0]['create_date'];?></label><br />
			<label for="form-field-8"><b>Location of Product Registration</b> : <?
			
			
			function getAddress($latitude,$longitude){
    if(!empty($latitude) && !empty($longitude)){
        //Send request and receive json data by address
        $geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false'); 
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        //Get address from json data
        $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        //Return address of the given latitude and longitude
        if(!empty($address)){
            return $address;
        }else{
            return false;
        }
    }else{
        return false;   
    }
}

			$latitude = $get_registered_products_by_consumers_details[0]['latitude'];
			$longitude = $get_registered_products_by_consumers_details[0]['longitude'];
			
			
			
			$key = "AIzaSyDLW5R1_Sh09FFPQRD29Ol81L0APNKB3AM";

			echo $latitude . ", " . $longitude;
			
		

//$latitude = '28.477960';
//$longitude = '77.052450';
$address = getAddress($latitude,$longitude);
$address = $address?$address:'Not found';

$geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=true_or_false&key=AIzaSyDLW5R1_Sh09FFPQRD29Ol81L0APNKB3AM');

		//echo $geocodeFromLatLong;
?>





<br />
			 
			
			<!--<label for="form-field-8">Invoice Number</label> -->
			<input name="invoice_number" id="invoice_number" type="text" class="form-control" placeholder="Invoice Number" value="<?php echo $get_registered_products_by_consumers_details[0]['invoice'];?>">
			
			<!--<br />
			<label for="form-field-8">Invoice Date (yyyy-mm-dd)</label> -->
             <input name="purchase_date" id="purchase_date" type="text" class="form-control" placeholder="Invoice Date (yyyy-mm-dd)" value="<?php echo $get_registered_products_by_consumers_details[0]['purchase_date'];?>"><!--<br />
			<label for="form-field-8">Warranty Start Date (yyyy-mm-dd)</label> -->
			<input name="warranty_start_date" id="warranty_start_date" type="text" class="form-control" placeholder="Warranty Start Date (yyyy-mm-dd)" value="<?php echo $get_registered_products_by_consumers_details[0]['warranty_start_date'];?>">
			
			<!--<br />
			 <label for="form-field-8">Warranty End Date (yyyy-mm-dd)</label> -->
             <input name="warranty_end_date" id="warranty_end_date" type="text" class="form-control" placeholder="Warranty End Date (yyyy-mm-dd)" value="<?php echo $get_registered_products_by_consumers_details[0]['warranty_end_date'];?>">
			<!--<br />
		<label for="form-field-8">Name of Retailer</label> -->
			<input name="seller_name" id="seller_name" type="text" class="form-control" placeholder="Name of Seller" value="<?php echo $get_registered_products_by_consumers_details[0]['seller_name'];?>">	
			<!--<br />
			<label for="form-field-8">GST Number of Retailer</label> -->
             <input name="seller_gst" id="seller_gst" type="text" class="form-control" placeholder="GST Number of Seller" value="<?php echo $get_registered_products_by_consumers_details[0]['seller_gst'];?>">
			<!--<br />
	<label for="form-field-8">Selling Price</label> -->
			<input name="selling_price" id="selling_price" type="text" class="form-control" placeholder="Selling Price" value="<?php echo $get_registered_products_by_consumers_details[0]['selling_price'];?>">		
			<!--<br />
		<label for="form-field-8">Discount</label> -->
             <input name="discount" id="discount" type="text" class="form-control" placeholder="Discount" value="<?php echo $get_registered_products_by_consumers_details[0]['discount'];?>">	
			<!--<br />
	<label for="form-field-8">Product Expiry Date (yyyy-mm-dd)</label> -->
			<input name="expiry_date" id="expiry_date" type="text" class="form-control" placeholder="Product Expiry Date (yyyy-mm-dd)" value="<?php echo $get_registered_products_by_consumers_details[0]['expiry_date'];?>">		
			<!--<br />
	 <label for="form-field-8">Verification Status</label> -->
			 <select class="form-control" placeholder="Select Verification Status" id="status" name="status" >
			<?php 
			
			$Vstatus = $get_registered_products_by_consumers_details[0]['status'];
			if($Vstatus==1) {?>			
			<option value="1" selected>Verification Passed</option>
			<option value="0">Verification Failed</option> 			
			<?php } else {?>
			<option value="0" selected>Verification Failed</option> 
			<option value="1">Verification Passed</option>
			<?php } ?>
			
			 </select>  		
			
		 <label for="form-field-8">Please Select if Verification Failed</label>
			 <select class="form-control" placeholder="Query" id="vquery" name="vquery" >
			 <!--<option value=""></option>
			<option value="<?php //$get_registered_products_by_consumers_details[0]['vquery']; ?>" selected> <?php // $get_registered_products_by_consumers_details[0]['vquery']; ?></option>	
			<option value="Congratulations! Your invoice validation is successful. Warranty, if applicable shall be now effective. Please check the details in “my purchase list” in Howzzt App.">The Invoice is uploaded . All particulars are correct</option> -->			
			<option value="Your Invoice validation is not successful on account of 'Invoice not legible'. Please upload invoice again.">The Invoice is Uploaded properly as the Image Is FAINT </option> 
			<option value="Your Invoice validation is not successful on account of 'Product not clearly mentioned/not appearing on Invoice'. Please upload invoice again.">The Purchase Says Product “X” but the Invoice uploaded is of Product “ Y”</option>
			 </select>  	
			<br />
			
			
			</div>
			
			<div class="col-sm-6">
			 <label for="form-field-8"><a href="<?php echo base_url().$get_registered_products_by_consumers_details[0]['invoice_image'];?>" onclick="window.open (this.href, 'child', 'height=800,width=900'); return false"><img alt="Invoice Image not available" src="<?php echo base_url(). $get_registered_products_by_consumers_details[0]['invoice_image'];?>" height="100%" width="100%"></a></label>
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
