<div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Add Group</h4>
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> 	
      <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a></div>
    </div>
    <div class="widget-body">
 
      <form name="frm" id="frm" action="#" method="POST">
        <div class="widget-main">
          <div>
            <label for="form-field-8">Group Name</label>
            <input name="name" id="name" type="text" class="form-control" placeholder="Group Name">
          </div>
          <hr>
          <div>
            <label for="form-field-9">OwnerShip</label>
            <select class="form-control" placeholder="OwnerShip" id="ownershipId" name="ownership">
           <?php 
		
		   $removeSubmit=0;
		   foreach($ownership as $val){
			   $depth=0;
			  	 $depth =  getDepth($val['usergroup_id'],$cnt1);
					if($depth<2){?>
						<option value="<?php echo $val['usergroup_id'];?>"><?php echo $val['usergroup_name'];?></option>       
					<?php }else{
							$removeSubmit=1;?>
                    <option value="">No Group</option>       
					<?php } 
		  			 }	
			   ?>
              </select>
          </div>
           <hr>
          <div>
            <label for="form-field-9">Description</label>
            <input name="description" id="description" type="text" class="form-control"  placeholder="Description">
          </div>
          <hr>
          
          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
           <?php 	if($removeSubmit==0){?>
            <input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
            <?php }else{?>
             <input class="btn btn-info" type="button" name="" value="No further Group" readonly="readonly"/>
             <?php }?>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
