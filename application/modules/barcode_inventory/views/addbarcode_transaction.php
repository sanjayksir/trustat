<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-msg"></div>
        <form name="frm" id="order-form" action="#" method="POST">
            <div class="form-group">
                <label>Plant Name</label>
                <select class="form-control" name="plant_id" id="plant_id" onchange="barcode.getOrder(this,'order_id')">
                    <?php echo Utils::selectOptions('plant_id',['options'=>$plantcontroller,'empty'=>'Select plant']) ?>
                </select>
            </div>
            <div class="form-group">
                <label>Order</label>
                <select class="form-control" name="order_id" id="order_id" onchange="barcode.printedOrder(this,'printed-order')">                    
                </select>
            </div>
            <div class="form-group">
                <label>Printed Order</label>
                <select class="form-control" name="printed_order" id="printed-order" onchange="barcode.printedCode(this,'printed-code')">                    
                </select>
            </div>
            <div class="form-group">
                <label>Printed Code <a href="javascript:void(0);" id="checkall" class="hide checked" onclick="barcode.checkAll(this)">|&nbsp;Toggle Selection</a></label>
                <div class="col-sm-12" id="printed-code"></div>
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
            data:$("#order-form").serialize()+'&status_type=<?php echo $this->uri->segment(3) ?>',
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
    barcode.printedOrder = function(obj,targetElem){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('barcode_inventory/get_printed_order') ?>",
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
    barcode.printedCode = function(obj,targetElem){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('barcode_inventory/get_printed_code') ?>",
            data:'print_id='+obj.value,
            success: function(data){
                if(data.status){
                    $("#checkall").removeClass('hide');
                    $("#"+targetElem).html(data.data);
                }else{
                    $("#checkall").addClass('hide');
                    $('.alert-msg').addClass('alert-danger').html(data.message).fadeIn('slow');
                }
		setTimeout(function(){
                    $(".alert").fadeOut('slow');
                },2000);
            }
	});
    };
    barcode.checkAll = function(obj){
        if($(obj).hasClass('checked')){
            $(obj).removeClass('checked');
            $('.printedcode').prop('checked', false);
        }else{
            $(obj).addClass('checked');
            $('.printedcode').prop('checked', true);
        }
        
         
    };
</script>