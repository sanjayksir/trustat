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
			<input type="hidden" name="bar_code" id="bar_code" value="<?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?>" />
			<input type="hidden" name="product_brand_name" id="product_brand_name" value="<?php echo get_products_brand_name_by_id($get_registered_products_by_consumers_details[0]['product_id']);?>" />
			<input type="hidden" name="product_name" id="product_name" value="<?php echo get_products_name_by_id($get_registered_products_by_consumers_details[0]['product_id']);?>" />
			<input type="hidden" name="product_id" id="product_id" value="<?php echo $get_registered_products_by_consumers_details[0]['product_id'];?>" />
        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-6" style="">
			<label for="form-field-8"><b>Consumer Name</b> : <?php echo getConsumerNameById($get_registered_products_by_consumers_details[0]['consumer_id']); ?></label><br />
			<label for="form-field-8"><b>Consumer Phone</b> : <?php echo getConsumerMobileNumberById($get_registered_products_by_consumers_details[0]['consumer_id']); ?></label><br />
			<label for="form-field-8"><b>Product Name</b> : <?php echo get_products_name_by_id($get_registered_products_by_consumers_details[0]['product_id']);?></label><br />
			<label for="form-field-8"><b>Product Code</b> : <?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?></label><br />
			<b>Warranty</b> : <?php if($get_registered_products_by_consumers_details[0]['invoice_image']!=""){ echo "Yes"; }else{ echo "No";}?>; <?php echo getProductWarrantyInDaysByProductId($get_registered_products_by_consumers_details[0]['product_id']); ?> Days<br />
			<label for="form-field-8"><b>Date of uploading Invoice</b> : <?php echo $get_registered_products_by_consumers_details[0]['create_date'];?></label><br />
			<label for="form-field-8"><b>Date of Product Verification</b> : <?php echo $get_registered_products_by_consumers_details[0]['modified'];?></label><br />
			<label for="form-field-8"><b>Address of Product Registration</b> : <?php echo $get_registered_products_by_consumers_details[0]['registration_address'];?>, <?php echo $get_registered_products_by_consumers_details[0]['scan_city'];?>, <?php echo $get_registered_products_by_consumers_details[0]['pin_code'];?> <?php
			
			/*
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
		*/
?>
<br />
			 <div class="1 box">
			
			<label for="form-field-8">Invoice Number : </label>
			<input name="invoice_number" id="invoice_number" type="text" class="" style="float:right;" placeholder="Invoice Number" value="<?php echo $get_registered_products_by_consumers_details[0]['invoice'];?>">
			
			<br /><br />
			<?php $Datetoday = date('m/d/Y'); ?>
			<div class="input-group date" data-provide="datepicker">
                              <label for="form-field-8">Invoice Date : </label>     <input type="text" name="purchase_date" style="width:150px; float:right;" id="purchase_date" readonly="readonly" value="<?php echo $Datetoday; ?>" onchange="change();" class="form-control">
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                                  </div>
           <!--  <input name="purchase_date" id="purchase_date" type="text" class="" style="float: right;" placeholder="yyyy-mm-dd" value="<?php echo $get_registered_products_by_consumers_details[0]['purchase_date'];?>">-->
			 <br />
			<script>
				function change(){
								var src= document.getElementById("purchase_date");
								var dest= document.getElementById("warranty_start_date");
								dest.value=src.value;
							}
			</script>
			
			<div class="input-group date" data-provide="datepicker">
            <label for="form-field-8">Warranty Start Date : </label>           
			<input type="text" name="warranty_start_date" id="warranty_start_date" value="<?php //echo $Datetoday; ?>" style="width:150px; float:right;" readonly="readonly" class="form-control">
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                                  </div>
			<!--<input name="warranty_start_date" id="warranty_start_date" type="text" class="" style="float: right;" placeholder="yyyy-mm-dd" value="<?php echo $get_registered_products_by_consumers_details[0]['warranty_start_date'];?>">-->
			
			<br />
			 
			 <div class="input-group date" data-provide="datepicker">
            <label for="form-field-8">Warranty End Date : </label>  
			<?php 
			$datediff = $get_registered_products_by_consumers_details[0]['create_date'] - date('Y-m-d H:i:s');
			//echo $datediff;
			$WDays = getProductWarrantyInDaysByProductId($get_registered_products_by_consumers_details[0]['product_id']) + $datediff;
			$DateWW = date( "m/d/Y", strtotime( "$Datetoday +$WDays day" ) );
			?>
	<input type="text" name="warranty_end_date" id="warranty_end_date" readonly="readonly" style="width:150px; float:right;" value="<?php echo $DateWW; ?>" class="form-control" >
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                                  </div>
            <!-- <input name="warranty_end_date" id="warranty_end_date" type="text" class="" style="float: right;" placeholder="yyyy-mm-dd" value="<?php echo $get_registered_products_by_consumers_details[0]['warranty_end_date'];?>">-->
			<br />
		<label for="form-field-8">Name of Retailer : </label> 
			<input name="seller_name" id="seller_name" type="text" class="" style="float: right;" placeholder="Name of Retailer" value="<?php echo $get_registered_products_by_consumers_details[0]['seller_name'];?>">	
			<br /><br />
			<label for="form-field-8">GST Number of Retailer : </label> 
             <input name="seller_gst" id="seller_gst" type="text" class="" style="float: right;" placeholder="GST Number of Retailer" value="<?php echo $get_registered_products_by_consumers_details[0]['seller_gst'];?>">
			<br /><br />
	<label for="form-field-8">Selling Price :  </label> 
			<input name="selling_price" id="selling_price" type="text" class="" style="float: right;" placeholder="Selling Price" value="<?php echo $get_registered_products_by_consumers_details[0]['selling_price'];?>">		
			<br /><br />
		<label for="form-field-8">Discount : </label> 
             <input name="discount" id="discount" type="text" class="" style="float: right;" placeholder="Discount" value="<?php echo $get_registered_products_by_consumers_details[0]['discount'];?>">	
			<br /><br />
	 
	<div class="input-group date" data-provide="datepicker">
     <label for="form-field-8">Product Expiry Date : &nbsp;&nbsp;</label>                        
	 <input type="text" name="expiry_date" id="expiry_date" readonly="readonly" style="width:150px; float:right;" class="form-control">
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                                  </div>
		<!--	<input name="expiry_date" id="expiry_date" type="text" class="" style="float: right;" placeholder="yyyy-mm-dd" value="<?php echo $get_registered_products_by_consumers_details[0]['expiry_date'];?>">	-->	
			<br />
			
	</div><br />
    <div class="2 box"> 
	 <font color="orange"> Details available in the image are not sufficient to fill in the form. </font> <br /><br />
	</div>
	
			<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
</script>
	 <label for="form-field-8">Verification Status : </label> 
			 <select class="" style="float: right;" placeholder="Select Verification Status" id="status" name="status" >
			<option value="" selected> Please Verification Status</option>						
			<option value="1">Verification Passed</option>
			<option value="2">Verification Failed</option> 			
			
			
			 </select>  		
			<br /><br />
		 <label for="form-field-8">Reason : </label>
			 <select class="" style="float: right; width:300px;" placeholder="Query" id="vquery" name="vquery" required>
			<option value="" selected>Please Select the verification status</option>
			<option value="Congratulations! Your invoice validation is successful. Warranty, if applicable shall be now effective. Please check the details in “my purchase list” in TRUSTAT App.">The Invoice is uploaded . All particulars are correct</option> 		
			<option value="Invoice is not readable and clear. Please re-scan the product for registration and upload readable and clear invoice.">Invoice is not readable and clear</option> 
			<option value="Description of the product registered does not match with the product(s) stated in invoice uploaded. Please re-scan the product for registration and upload the invoice with product details.">Description of the product registered does not match with the product(s) stated in invoice uploaded.</option>
			 </select>  	
						
			</div>
			
			<div class="col-sm-6">
			 <label for="form-field-8"><a href="<?php echo base_url().$get_registered_products_by_consumers_details[0]['invoice_image'];?>" onclick="window.open (this.href, 'child', 'height=800,width=900'); return false"><img alt="Invoice Image not available" src="<?php echo base_url(). $get_registered_products_by_consumers_details[0]['invoice_image'];?>" height="100%" width="100%"></a></label>
			</div>						
		</div>
		
          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save Verification Status" id="savemenu" onclick="this.style.display='none'" />
			<a href="<?php echo base_url('/product/verity_registered_products_by_consumers').'/'.$this->uri->segment(3); ?>" class="btn btn-info" title="Reset">Reset </a>
		<script type="text/javascript">	/*
			    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    //initializing datepicker
    $('.datepicker').datepicker({format:'yyyy-mm-dd', startDate: today, minDate: new Date()  });
    }); */
	</script>
	
	<script type="text/javascript"> /*
    $('input[type=submit], input[type=submit]').click(function(){
    var btn = $(this);
    var textd = btn.attr("value");
    btn.prop('disabled', true);
    btn.attr('value', 'Please wait...');
    setTimeout(function(){
    btn.prop('disabled', false);
    btn.attr('value', textd);
    }, fewSeconds*10000);
    }); */
	</script>
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
