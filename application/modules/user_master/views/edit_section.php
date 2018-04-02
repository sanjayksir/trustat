<?php // echo '<pre>';print_r($edited_data);
$menu 			= '';
$id 			= !empty($edited_data['id'])?$edited_data['id']:'';
$menu 			= !empty($edited_data['menu'])?$edited_data['menu']:'';
$url  			= !empty($edited_data['url'])?$edited_data['url']:'';
$order_by   	= !empty($edited_data['order_by'])?$edited_data['order_by']:'';
$created_by   	= !empty($edited_data['created_by'])?$edited_data['created_by']:'';
$created_on   	= !empty($edited_data['created_on'])?$edited_data['created_on']:'';
?><div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Edit Menu</h4>   <h4 class="widget-title">Add Menu</h4>   
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a></div>
    </div>
    <div class="widget-body">
       
      <form name="frm" id="frm" action="#" method="POST">
      <input name="menu_id" id="menu_id" type="hidden" value="<?php echo $this->uri->segment(3);?>">
        <div class="widget-main">
          <div>
            <label for="form-field-8">Menu Title</label>
            <input name="title" id="title" type="text" class="form-control" value="<?php echo $menu;?>" placeholder="Default Text">
          </div>
          <hr>
          <div>
            <label for="form-field-9">Menu Url</label>
            <input name="url" id="url" type="text" class="form-control" value="<?php echo $url;?>" placeholder="Default Text" readonly="readonly">
          </div>
          <hr>
          <div>
            <label for="form-field-11">Menu Order in list </label>
            <input name="order" id="order" type="text" value="<?php echo $order_by;?>" class="form-control" placeholder="Default Text">
          </div>
          <div>
            <label for="form-field-9">Created By:</label>
            <label for="form-field-9"><span class="form-control" ><?php echo getUserNameById($created_by);?></span></label>
          </div>
           <div>
            <label for="form-field-9"><span>Created On:</span></label>
            <label for="form-field-9"><span class="form-control" >
				<?php	$date = new DateTime($created_on);
						echo $date->format('F, l Y');?></span></label>
          </div>
          
          
          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
