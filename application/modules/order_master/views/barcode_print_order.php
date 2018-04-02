<div id="printMyModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            
            <?php //echo '<pre>';print_r( $print_data);exit;?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Print Order</h4>
            </div>
			<span class="form-group" style="text-align:center"><h3 id="msgError"></h3></span>
            <div class="modal-body"><?php //echo base_url().'order_master/';?>
                 
                 <?php // echo $this->uri->segment(4);
				 	$printEssentialAttributes = printEssentialAttributes($this->uri->segment(4)); 
					//echo '<pre>';print_r($printEssentialAttributes);
				 ?>
                 <div class="form-group row">
					<div class="col-sm-6">
						<label for="form-field-8">Product Name</label>
						<div class="form-control"> <?php echo $order_detail['product_name'];?></div>
					</div>
					
					<div class="col-sm-6">
						<label for="form-field-8">Product SKU</label>
						<div class="form-control"> <?php echo $order_detail['product_sku'];?></div>
					</div>
				  </div>
				  
				    
				  
				  <div class="form-group row">
						<div class="col-sm-6">
							<label for="message-text">Tracking No:</label>
							<div class="form-control"> <?php echo $order_detail['order_tracking_number'];?></div>
						</div>
						<div class="col-sm-6">
							<label for="message-text">Bar Code/Qr Code:</label>
							<div class="form-control"> <?php echo $order_detail['barcode_qr_code_no'];?></div>
						</div>
				  </div>
                  
                   <div class="form-group row">
						<div class="col-sm-6">
							<label for="message-text">Quantity Ordered:</label>
							<div class="form-control"> <?php echo $order_detail['quantity'];?></div>
						</div>
						<div class="col-sm-6">
							<label for="message-text">Delivery Date:</label>
							<div class="form-control"> <?php echo $order_detail['delivery_date'];?></div>
						</div>
				  </div> 
				   <div class="form-group row">
						 
						<div class="col-sm-6">
							<label for="message-text">User Name:</label>
							<div class="form-control"> <?php echo getUserNameById($order_detail['user_id']);?></div>
						</div>
				  </div>
				 
            </div>
            
        </div>
    </div>
</div>
<script>
function print_option(){
	$("#msgError").html('').removeClass('error').fadeOut();;
	var barcodeType	= $("#print_order").val();
	var url 		= barcodeType;
	var restQty = $("#rest_qty").val();
	var qty = parseInt($("#qty").val());
	if(qty==0 || qty>parseInt(restQty)){
		$("#msgError").html('Wrond Quantity Entered').addClass('error').fadeIn('slow');
		return false;
	}else{
		$('#print_form').attr('action', url).submit();
	}
  }

</script>