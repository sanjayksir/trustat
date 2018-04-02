<?php //echo '<pre>';print_r($getGroupData);exit;?>
<div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Edit Group</h4>
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> 	
      <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a></div>
    </div>
    <div class="widget-body">
       <form name="frm" id="frm" action="#" method="POST"><input type="hidden" name="group_id" value="<?php if(!empty($this->uri->segment('3'))){echo $this->uri->segment('3');}?>" />
        <div class="widget-main">
          <div>
            <label for="form-field-8">Group Name</label>
            <input name="name" id="name" type="text" class="form-control" placeholder="Group Name" value="<?php if(!empty($getGroupData['usergroup_name'])){echo $getGroupData['usergroup_name'];}?>">
          </div>
          <hr>
          <div>
            <label for="form-field-9">OwnerShip</label>
            <select class="form-control" placeholder="OwnerShip" id="ownershipId" name="ownership">
           <?php 
		
		   
		   foreach($ownership as $val){?>
            	<option <?php if(!empty($getGroupData['usergroup_id]'])){echo "selected";}?> value="<?php echo $val['usergroup_id'];?>"><?php echo $val['usergroup_name'];?></option>       
           <?php }?>     
            </select>
          </div>
           <hr>
          <div>
            <label for="form-field-9">Description</label>
            <input value="<?php if(!empty($getGroupData['usergroup_desc'])){echo $getGroupData['usergroup_desc'];}?>" name="description" id="description" type="text" class="form-control"  placeholder="Description">
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
