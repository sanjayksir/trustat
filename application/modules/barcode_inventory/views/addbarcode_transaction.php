<div class="row">
    <div class="col-sm-12">
        <form name="frm" id="frm" action="#" method="POST">
            <div class="form-group">
                <label>Plant Controller Name</label>
                <select class="form-control" name="plant_id" id="plant_id" onchange="barcode.getOrder(this,'order_id')">
                    <?php echo Utils::selectOptions('plant_id',['options'=>$plantcontroller,'empty'=>'Select plant controller']) ?>
                </select>
            </div>
            <div class="form-group">
                <label>Order</label>
                <select class="form-control" name="order_id" id="order_id" onchange="barcode.orderHistory(this,'order_history')">                    
                </select>
            </div>
            <div class="form-group">
                <label>Order History</label>
                <select class="form-control" name="order_history" id="order_history">                    
                </select>
            </div>
           

            <div class="form-group">
                    <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
                        <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />
                    </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var barcode = {};
    barcode.getOrder = function(obj,targetElem){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('barcode_inventory/get_order') ?>",
            data:'plant_id='+obj.value,
            success: function(data){
		$("#"+targetElem).html(data);
            }
	});
    };
    barcode.orderHistory = function(obj,targetElem){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('barcode_inventory/get_order_history') ?>",
            data:'order_id='+obj.value,
            success: function(data){
		$("#"+targetElem).html(data);
            }
	});
    };
</script>