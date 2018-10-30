<?php // echo '<pre>';print_r($edited_data);
$menu 			= '';
$id 			= !empty($edited_data['product_id'])?$edited_data['product_id']:'';
$menu 			= !empty($edited_data['name'])?$edited_data['name']:'';
$parent  		= getCategoryParentName_ATTR($edited_data['parent']);
 
?><div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Edit Attribute</h4>   <h4 class="widget-title">Add Attribute</h4>   
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a></div>
    </div>
    <div class="widget-body">
       
      <form name="frm" id="frm" action="#" method="POST">
      <input name="id" id="id" type="hidden" value="<?php echo $this->uri->segment(3);?>">
        <div class="widget-main">
          <div>
            <label for="form-field-8">Attribute Name</label>
            <input name="attribute" id="attribute" type="text" class="form-control" value="<?php echo $menu;?>" placeholder="Attribute Name">
          </div>
          <hr>
          
		  <?php if($parent=='')
		  {?>
			 <div>
					<br />
            <label for="form-field-9">Select Parent Industries from the list below (Press Ctrl key for multi-selection)</label>
		
			<select class="form-control" name="industry_id[]" id="industry_id[]" multiple="multiple">
				 <!-- <option value="">-Select Parent Industries-</option> -->
				  	<?php foreach(getAllParentIndustries() as $val){?>
					  		<option value="<?php echo $val['category_Id'];?>"><?php //echo $val['category_Id'];?><?php echo $val['categoryName'];?></option> 
					<?php }?>
                  </select>

          </div>
		  <?php 
		  } else {
		  ?>
		  
		  <div>
            <label for="form-field-9">Parent Attribute</label>
            <input type="text" class="form-control" value="<?php echo $parent;?>" readonly="readonly">
          </div>
		  <?php 
		  } 
		  ?>
		  
          <hr>
           <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
