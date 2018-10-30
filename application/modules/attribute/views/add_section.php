<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Attributes</h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

      

      <form name="frm" id="frm" action="#" method="POST">

        <div class="widget-main">

          <div>

            <label for="form-field-8">Attribute Name</label>

            <input name="attribute" id="attribute" type="text" class="form-control" placeholder="Default Text">

          </div>

          <div>
		<br />
		<SCRIPT> 	
			function show(select_item) {
				if (select_item == "0") {
					hiddenDiv.style.visibility='visible';
					hiddenDiv.style.display='block';
					Form.fileURL.focus();
				} 
				else{
					hiddenDiv.style.visibility='hidden';
					hiddenDiv.style.display='none';
				}
			}	
		</SCRIPT>  
            <label for="form-field-9">Select Parent Attribute (No need to change if you are making this as Parent Attribute). </label>

             <select name="parent" id="parent" class="form-control" onchange="java_script_:show(this.options[this.selectedIndex].value)">

             <option value="0">-Select Parent Attribute-</option>

             <?php foreach(getAllParentAttribute() as $val){?>

            	<option value="<?php echo $val['product_id'];?>"><?php echo $val['name'];?></option>

            <?php }?>

            </select>

          </div>
		           <div id='hiddenDiv'>
					<br />
            <label for="form-field-9">Select Parent Industries from the list below (Press Ctrl key for multi-selection )</label>
		
			<select class="form-control" name="industry_id[]" id="industry_id[]" multiple="multiple">
				 <!-- <option value="">-Select Parent Industries-</option> -->
				  	<?php foreach(getAllParentIndustries() as $val){?>
					  		<option value="<?php echo $val['category_Id'];?>"><?php //echo $val['category_Id'];?><?php echo $val['categoryName'];?></option> 
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

