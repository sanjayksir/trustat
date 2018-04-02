<?php // echo '<pre>';print_r($edited_data);
$menu 			= '';
$id 			= !empty($edited_data['category_Id'])?$edited_data['category_Id']:'';
$menu 			= !empty($edited_data['categoryName'])?$edited_data['categoryName']:'';
$parent  		= getCategoryParentName($edited_data['parent']);
 
?><div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Edit Industry</h4>   <h4 class="widget-title">Add Industry</h4>   
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a></div>
    </div>
    <div class="widget-body">
       
      <form name="frm" id="frm" action="#" method="POST">
      <input name="id" id="id" type="hidden" value="<?php echo $this->uri->segment(3);?>">
        <div class="widget-main">
          <div>
            <label for="form-field-8">Industry Name</label>
            <input name="category" id="category" type="text" class="form-control" value="<?php echo $menu;?>" placeholder="category Name">
          </div>
          <hr>
          <div>
            <label for="form-field-9">Parent Industry</label>
            <input type="text" class="form-control" value="<?php echo $parent;?>" readonly="readonly">
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
