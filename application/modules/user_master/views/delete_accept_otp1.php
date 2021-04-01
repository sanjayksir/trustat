<div id="DeleteUserOTPModal" class="modal fade">
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
				 //$printEssentialAttributes = printEssentialAttributes($this->uri->segment(3)); 
				 ?>
                <input type="hidden" name="order_id" value="<?php //echo base64_encode($this->uri->segment(3));?>" />
				 
				  
				  
				  
				  
				  <input type="hidden" name="barcodesize" value="<?php //echo $size;?>" />
				  
                  
				  
                  <input type="hidden" name="rest_qty" id="rest_qty" value="<?php //echo $restQty;?>" />
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