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
                 <form name="frm" id="print_form" action="" method="post" onsubmit="">
                 <?php //echo $this->uri->segment(3);
				 $printEssentialAttributes = printEssentialAttributes($this->uri->segment(3)); 
				 ?>
                <input type="hidden" name="order_id" value="<?php echo base64_encode($this->uri->segment(3));?>" />
				  <div class="form-group">
 				  <label for="message-text">Print Code Unity Type:</label>
					<select name="print_order_unity" class="form-control" id="print_order_unity" disabled="disabled">
                        <option <?php if($printEssentialAttributes['code_unity_type']=='Single'){echo 'selected';}?> value="generate_order_barcode">Single</option>
                        <option <?php if($printEssentialAttributes['code_unity_type']=='Twin'){echo 'selected';}?> value="generate_order">Twin</option>
                    </select>
				  </div>
				  
				  <div class="form-group">
 				  <label for="message-text">Print Bar Code Type:</label>
					<select name="print_order" class="form-control" id="print_order" disabled="disabled">
                        <option <?php if($printEssentialAttributes['code_type']=='barcode'){echo 'selected';}?> value="generate_order_barcode">Bar Code</option>
                        <option <?php if($printEssentialAttributes['code_type']=='qrcode'){echo 'selected';}?> value="generate_order">Q.R Code</option>
                    </select>
				  </div>
				  
				  <div class="form-group">
 				  <label for="message-text">Batch ID:</label>
				  
				  <?php 
				  $customer_id 	= $printEssentialAttributes['created_by'];
				  //echo $customer_id."-";
				  $BatchID = last_printed_batch_id($customer_id ); 
				  //echo $BatchID."-";
				  $BatchIDNext = $BatchID+1;
				  
				  ?>
					<input type="text" name="print_batch_id" value="<?php echo $BatchIDNext;?>" class="form-control" id="print_batch_id" readonly />
				  </div>
				  
				   <div class="form-group">
					<label for="message-text">Print Size (mm):</label>
					<div class="form-control"><?php /*if( strtolower($printEssentialAttributes['code_size'])=='s'){
													$size = 15;
													echo 'Small';
													}else if(strtolower($printEssentialAttributes['code_size'])=='m'){
													$size = 30;
													echo 'Medium';}else{
													$size = 35;
													echo 'Large';
													}; */
													
													$sizemm = $printEssentialAttributes['code_size'];
													echo $sizemm;
													
													$size = $sizemm;
													?></div>
				  </div>
				  <input type="hidden" name="barcodesize" value="<?php echo $size;?>" />
				  
				  <div class="form-group">
					<label for="message-text">Print Quantity:</label>
					<select name="qty" id="qty" class="form-control">
 						<option value="10">10</option>
						<option value="20">20</option>
						<option value="50">50</option>		
						<option value="100">100</option>
						<option value="1000">1,000</option>
						<option value="10000">10,000</option>
						<option value="100000">1,00,000</option>
						<option value="1000000">10,00,000</option>
					</select>
					<!--<input type="text" class="form-control" name="qty" id="qty" value="1"> -->
				  </div>
                  
                  <div class="form-group">
					<label for="message-text">Last printed No:</label>
					<div class="form-control"><?php echo $print_data['last_printed_rows'];?></div>
				  </div>
				  
				  <div class="form-group">
                  <?php $restQty = $print_data['OrderQty']-$print_data['last_printed_rows'];?>
					<label for="message-text">Rest printed Qty:</label>
					<div class="form-control"><?php echo $restQty;?></div>
				  </div>
                  
                  <div class="form-group">
					<label for="message-text">Total Ordered Quantity:</label>
					<div class="form-control"><?php echo $print_data['OrderQty'];?></div>
				  </div>
                  <input type="hidden" name="rest_qty" id="rest_qty" value="<?php echo $restQty;?>" />
				</form>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-primary" onclick="return print_option();">Print Barcode/QR Code</button>
            </div>
        </div>
    </div>
</div>
<script>
function print_option(){
	$("#msgError").html('').removeClass('error').fadeOut();;
	var barcodeType	= $("#print_order").val();
	var codeunityType	= $("#print_order_unity").val();
	var url 		= barcodeType;
	var restQty = $("#rest_qty").val();
	var qty = parseInt($("#qty").val());
	if(qty==0 || qty>parseInt(restQty)){
		$("#msgError").html('Wrong Quantity Entered, Please check.').addClass('error').fadeIn('slow');
		return false;
	}else{
		$('#print_form').attr('action', url).submit();
	}
  }

</script>