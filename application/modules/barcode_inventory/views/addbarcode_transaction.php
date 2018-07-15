<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-msg"></div>
        <form name="frm" id="order-form" action="#" method="POST">
            <div class="form-group">
                <label>Plant Controller Name</label>
                <select class="form-control" name="plant_id" id="plant_id" onchange="barcode.getOrder(this,'order_id')">
                    <?php echo Utils::selectOptions('plant_id',['options'=>$plantcontroller,'empty'=>'Select plant controller']) ?>
                </select>
            </div>
            <div class="form-group">
                <label>Order</label>
                <select class="form-control" name="order_id" id="order_id" onchange="barcode.orderHistory(this,'print-history')">                    
                </select>
            </div>
            <div class="form-group">
                <label>Order History</label>
                <div class="col-sm-12" id="print-history"></div>
            </div>
           

            <div class="form-group">
                    <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
                        <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savebtn" onclick="event.preventDefault();barcode.saveForm(this.event)" />
                    </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var barcode = {};
    $('.alert').hide();
    barcode.saveForm = function(obj){
        console.log($("#order-form").serialize());
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('barcode_inventory/save_transaction') ?>",
            data:$("#order-form").serialize()+'&status_type=Received',
            success: function(data){
                console.log(data.status);
                if(data.status){
                    $('.alert-msg').removeClass('alert-danger').addClass('alert-success').html(data.message).fadeIn('slow');
                    setTimeout(function(){
                        $(".alert").fadeOut('slow');
                        $('#modalbox').modal('toggle');
                        location.reload(true);
                    },2000);
                    
                }else{
                    $('.alert-msg').addClass('alert-danger').html(data.message).fadeIn('slow');
                }
                setTimeout(function(){
                    $(".alert").fadeOut('slow');
                },2000);
            }
	});
    };
    barcode.getOrder = function(obj,targetElem){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('barcode_inventory/get_order') ?>",
            data:'plant_id='+obj.value,
            success: function(data){
                if(data.status){
                    $("#"+targetElem).html(data.data);
                }else{
                    $('.alert-msg').addClass('alert-danger').html(data.message).fadeIn('slow');
                }
                setTimeout(function(){
                    $(".alert").fadeOut('slow');
                },2000);
            }
	});
    };
    barcode.orderHistory = function(obj,targetElem){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('barcode_inventory/get_order_history') ?>",
            data:'order_id='+obj.value,
            success: function(data){
                if(data.status){
                    $("#"+targetElem).html(data.data);
                }else{
                    $('.alert-msg').addClass('alert-danger').html(data.message).fadeIn('slow');
                }
		setTimeout(function(){
                    $(".alert").fadeOut('slow');
                },2000);
            }
	});
    };
</script>