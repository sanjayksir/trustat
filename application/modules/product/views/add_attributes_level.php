<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Sub attributes</h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

      

      <form name="frm" id="frm" action="#" method="POST">
		<input type="hidden" name="hidden_field" value="1" />
        <div class="widget-main">

          <div>

            <label for="form-field-8">Sub Name</label>

            <input name="attr_name" id="attr_name" type="text" class="form-control" placeholder="Create Attribute Level">

          </div>

          <hr>

          <div>
<?php $ci = & get_instance();$ci->load->helper('common_functions_helper');?>
            <label for="form-field-9">Parent Attributes</label>

             <select name="parent" id="parent" class="form-control">

             <option value="0">-Select Parent-</option>

             	<?php foreach(getAllattributes() as $val){?>
				<?php $getLevel = getAttrDepth($val['product_id'],1);
					if($getLevel<=3){?>
            			<option value="<?php echo $val['product_id'];?>"><?php echo $val['name'];?></option>
				<?php }?>
            <?php }?>

            </select>

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
<script>
 $(document).ready(function(){	

 	 
	$("form#frm").validate({

		rules: {
 			attr_name: {
 						 required: true
 					  } 
 		},

		messages: {

				attr_name: {
 					required: "Please enter Attribute Name"
 				}  
 		},
 		submitHandler: function(form) {
  			var formData;
 			var formData 	= $("#frm").serialize();
  			$.ajax({
 				type: "POST",
 				dataType:"json",
 				beforeSend: function(){
 						$(".show_loader").show();
  						$(".show_loader").click();
 				},
 				url: "<?php echo base_url(); ?>product/set_attributes/",
 				data: formData, 				 
 				success: function (msg) {			
					window.location.href="<?php echo base_url().'product/set_attributes';?>";				
 				}
 			});
   		}
 	});

});
</script>