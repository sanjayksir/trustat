<div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Add Member</h4>
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
    </div>
    <div class="widget-body">
    <div id="ajax_msg"></div>
      </div>
      <form name="user_frm" id="user_frm" action="#" method="POST">
        <div class="widget-main">
         <div><?php  $get_all_rwa = getRWA_DD(); //echo '<pre>';print_r($ownership);exit;?>
            <label for="form-field-9">RWA Name</label>
            <select class="form-control" placeholder="RWA Name" id="rwa_name" name="rwa_name">
            <option value="">--Select RWA--</option>     
			   <?php 
                    foreach($get_all_rwa as $val){?>
                    <option value="<?php echo $val['rwa_id'];?>"><?php echo $val['rwa_name'];?></option>       
               <?php }?>     
            </select>
          </div>
           <div>
            <label for="form-field-8">First Name</label>
            <input name="f_name" id="f_name" type="text" class="form-control" placeholder="First Name">
          </div>
		  
		   <div>
            <label for="form-field-8">Last Name</label>
            <input name="l_name" id="l_name" type="text" class="form-control" placeholder="Last Name">
          </div>
          <div>
            <label for="form-field-8">User Name</label>
            <input name="user_name" id="user_name" type="text" class="form-control" placeholder="User Name">
          </div>
           <div>
            <label for="form-field-8">Mobile</label>
            <input name="user_mobile" id="user_mobile" type="text" class="form-control" placeholder="User Mobile">
          </div>
           <div>
            <label for="form-field-8">Email ID</label>
            <input name="user_email" id="user_email" type="text" class="form-control" placeholder="Email ID">
          </div>
                      
          <div><?php  //$get_all_groups_DD = get_all_groups_DD(); //echo '<pre>';print_r($get_all_rwa);exit;?>
            <label for="form-field-9">User Group</label>
            <select class="form-control" placeholder="User Group" id="user_group" name="user_group">
           <?php 		  
		   foreach($ownership as $val){
			   $depth=0;
			  	 $depth =  getDepth($val['usergroup_id'],$cnt1);
				 if($depth<3){ 
			   ?>
            	<option value="<?php echo $val['usergroup_id'];?>"><?php  echo $val['usergroup_name'];?></option>       
           <?php }  }?>     
            </select>
          </div>
          
          <div>
                <label for="form-field-8">Profile Image</label>
                <div class="widget-body">
                     <label class="ace-file-input"><input id="file" onchange="readURL(this);" name="file"  type="file"><span class="ace-file-container" data-title="Choose">
                     <span class="ace-file-name" data-title="No File ..."><i class=" ace-icon fa fa-upload"></i></span></span>
                     <a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label> <img style="display:none;" width="100px" id="blah" src="#" alt="Image Preview" />
                </div>
             </div>
              <div><?php  //$get_all_groups_DD = get_all_groups_DD(); //echo '<pre>';print_r($get_all_rwa);exit;?>
            <label for="form-field-9">Department </label>
            <select class="form-control"  id="department" name="department">
			<!--- <option value="">--Select Department--</option>   -->
			   <?php 
               $department = get_department();
               foreach($department as $dept){
               ?>
                    <option value="<?php echo $dept['dept_id'];?>"><?php  echo $dept['dept_name'];?></option>       
               <?php } ?>     
            </select>
          </div>
		    <div><?php  //$get_all_groups_DD = get_all_groups_DD(); //echo '<pre>';print_r($get_all_rwa);exit;?>
            <label for="form-field-9">Designation</label>
            <select class="form-control"  id="designation" name="designation">
			<!---<option value="">--Select Designation--</option>   -->
           <?php 
		   $designation= get_designation();
		   foreach($designation as $desig){ ?>
           <option value="<?php echo $desig['desi_id'];?>"><?php  echo $desig['desi_name'];?></option>       
           <?php } ?>     
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
 
<script type="text/javascript">
	function readURL(input) {
		 if (input.files && input.files[0]) {
			var reader = new FileReader();
			 reader.onload = function (e) {
				$('#blah').attr('src', e.target.result).show();
			}
			 reader.readAsDataURL(input.files[0]);
		}
	}
</script>