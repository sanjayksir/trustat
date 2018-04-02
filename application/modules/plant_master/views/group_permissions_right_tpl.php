<div class="row">
  <div class="col-xs-12"> 
    <!-- PAGE CONTENT BEGINS --> 
    <!-- /.row -->
    
    <div class="hr hr-18 dotted hr-double"></div>
    <h4 class="pink"> <i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i> <a href="#modal-table" role="button" class="green" data-toggle="modal"><?php echo (!empty(displayGroupNameByUrl()))?' Group Name: '.ucfirst(displayGroupNameByUrl()):'No Group Selected';?></a> </h4>
    <div class="hr hr-18 dotted hr-double"></div>
    <div class="row">
      <div class="col-xs-12">
        <div class="clearfix">
          <div class="pull-right tableTools-container"></div>
        </div>
        
        <!-- div.table-responsive --> 
        
        <!-- div.dataTables_borderWrap -->
        <div>
        <form name="permit_frm" id="permit_frm" action="<?php echo base_url();?>myspidey_user_group_permissions/save_permissions" method="post">
        <input type="hidden" name="group_id" value="<?php echo $this->uri->segment(3);?>" />
          <input type="hidden" name="rwa_id" value="<?php echo '0';?>" />
          <table id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="center"> <span class="htop">All</span><label class="pos-rel">
                  &nbsp;&nbsp;&nbsp;<input type="checkbox" id="selectall" class="ace selectall " />
                    <span class="lbl"></span> </label>
                </th>
                <th>
                <span class="htop">Show/Hide Menu</span><label class="pos-rel">
                  &nbsp;&nbsp;&nbsp;<input type="checkbox"  class="ace select_column selectone" id="0"/>
                    <span class="lbl"></span> </label>
                 </th>
                 <th>
                 <span class="htop">Read</span><label class="pos-rel">
                  &nbsp;&nbsp;&nbsp;<input type="checkbox"  class="ace select_column selectone" id="1"/>
                    <span class="lbl"></span> </label>
                 </th>
                <th><span class="htop"> Write</span><label class="pos-rel">
                  &nbsp;&nbsp;&nbsp;<input type="checkbox" class="ace select_column selectone" id="2" />
                    <span class="lbl"></span> </label></th>
                    
                <th class="hidden-480"><span class="htop">Delete</span><label class="pos-rel">
                  &nbsp;&nbsp;&nbsp;<input type="checkbox" class="ace select_column selectone" id="3" />
                    <span class="lbl"></span> </label></th>
                
                <th>  <span class="htop">Publish</span>&nbsp;<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> <label class="pos-rel"  >
                  &nbsp;&nbsp;&nbsp;<input type="checkbox"  class="ace select_column selectone" id="4" />
                    <span class="lbl"></span> </label> </th>
                    
                <th class="hidden-480"><span class="htop">Assign</span> <label class="pos-rel">
                  &nbsp;&nbsp;&nbsp;<input type="checkbox" class="ace select_column selectone" id="5" />
                    <span class="lbl"></span> </label></th>
               </tr>
            </thead>
            <tbody>
              <?php 
			  $getMenuList = json_encode(getMenuIDByGroup());
			  $getMenu = getMenuList('',$getMenuList); //exit;
			  //$getMenu = getMenuList(); ?>
              <?php if(count($getMenu)>0){?>
              <?php foreach($getMenu as $key=>$val){
				  		$getChild = getMenuList($val['id'],$getMenuList); 
						//$getChild = getMenuList($val['id']); 
						$child_cnt = count($getChild);?> 
                          <tr>
                            <td class=""><label class="pos-rel"  style="font-weight:bold;">
                               <?php echo $val['menu'];?></td>
                               
                          <td class="center"><input type="checkbox" name="menu[show_hide][]" value="<?php echo $val['id'];?>" class="ace selectone select_td_<?php echo $k;?> select_col_0" />
                                <span class="lbl"></span> </label></td>
                            <td class="center"><input type="checkbox" name="menu[read][]" value="<?php echo $val['id'];?>" class="ace selectone select_td_<?php echo $k;?> select_col_1" />
                                <span class="lbl"></span> </label></td>
                            <td class="center"><label class="pos-rel">
                                <input type="checkbox" name="menu[write][]" value="<?php echo $val['id'];?>" class="ace selectone select_td_<?php echo $k;?> select_col_2" />
                                <span class="lbl"></span> </label></td>
                            <td class="center"><label class="pos-rel">
                                <input type="checkbox" name="menu[delete][]" value="<?php echo $val['id'];?>" class="ace selectone select_td_<?php echo $k;?> select_col_3" />
                                <span class="lbl"></span> </label></td>
                            <td class="center"><label class="pos-rel">
                                <input type="checkbox" name="menu[print][]" value="<?php echo $val['id'];?>" class="ace selectone select_td_<?php echo $k;?> select_col_4" />
                                <span class="lbl"></span> </label></td>
                            <td class="center"><label class="pos-rel">
                                <input type="checkbox" name="menu[export][]" value="<?php echo $val['id'];?>" class="ace selectone select_td_<?php echo $k;?> select_col_5" />
                                <span class="lbl"></span> </label></td>
                            
                            </tr>
                            <?php if(count($child_cnt)>0){
									foreach($getChild as $key2=>$val2){
										//echo '<pre>';print_r($getChild);exit;
										?>
                                    	 <tr>
                                            <td><label class="pos-rel" style="margin-left:20px;">
                                               <?php echo $val2['menu'];?></td>
                                          
                                            <td class="center"><input type="checkbox" name="menu[show_hide][]" value="<?php echo $val2['id'];?>"  class="ace selectone select_td_0 select_col_0" />
                                                <span class="lbl"></span> </label></td>
                                                 <td class="center"><input type="checkbox" name="menu[read][]" value="<?php echo $val2['id'];?>"  class="ace selectone select_td_1 select_col_1" />
                                                <span class="lbl"></span> </label></td>
                                            <td class="center"><label class="pos-rel">
                                                <input type="checkbox" name="menu[write][]" value="<?php echo $val2['id'];?>"  class="ace selectone select_td_<?php echo $k;?> select_col_2" />
                                                <span class="lbl"></span> </label></td>
                                            <td class="center"><label class="pos-rel">
                                                <input type="checkbox" name="menu[delete][]" value="<?php echo $val2['id'];?>" 
                                                class="ace selectone select_td_<?php echo $k;?> select_col_3" />
                                                <span class="lbl"></span> </label></td>
                                            <td class="center"><label class="pos-rel">
                                                <input type="checkbox" name="menu[print][]" value="<?php echo $val2['id'];?>" class="ace selectone select_td_<?php echo $k;?> select_col_4" />
                                                <span class="lbl"></span> </label></td>
                                            <td class="center"><label class="pos-rel">
                                                <input type="checkbox" name="menu[export][]" value="<?php echo $val2['id'];?>" class="ace selectone select_td_<?php echo $k;?> select_col_5" />
                                                <span class="lbl"></span> </label></td>
                                             
                                         </tr>
                            
                            <?php }
							}?>
              <?php }
			  }else{?>
               <tr><td class="center" colspan="7">No Data </td></tr>
              <?php }?>
               <tr><td class="center" colspan="7">
               <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
            <input class="btn btn-info" type="submit" name="submit" value="submit" id="submit" />
          </div>
               
               
              </td></tr>
              <!-- <tr>
                <td class="center"><label class="pos-rel">
                    <input type="checkbox" class="ace selectone select_row_2" />
                    <span class="lbl"></span> </label></td>
                <td class="center"><label class="pos-rel">
                    <input type="checkbox" class="ace selectone select_td_2 select_col_1" />
                    <span class="lbl"></span> </label></td>
                <td class="center"><label class="pos-rel">
                    <input type="checkbox" class="ace selectone select_td_2" />
                    <span class="lbl"></span> </label></td>
                <td class="center"><label class="pos-rel">
                    <input type="checkbox" class="ace selectone select_td_2" />
                    <span class="lbl"></span> </label></td>
                <td class="center"><label class="pos-rel">
                    <input type="checkbox" class="ace selectone select_td_2" />
                    <span class="lbl"></span> </label></td>
                <td class="center"><label class="pos-rel">
                    <input type="checkbox" class="ace selectone select_td_2" />
                    <span class="lbl"></span> </label></td>
                <td class="center"><label class="pos-rel">
                    <input type="checkbox" class="ace selectone select_td_2" />
                    <span class="lbl"></span> </label></td>
              </tr>-->
            </tbody>
          </table>
          </form>
        </div>
      </div>
    </div>
    
    <!-- PAGE CONTENT ENDS --> 
  </div>
  <!-- /.col --> 
</div>

<script type="text/javascript">
$(function() {	  
	// Select deselect all
	$('.selectall').click(function() {
      if ($(this).is(':checked')) {
          $('.selectone').prop('checked', true);
      } else {
          $('.selectone').prop('checked', false);
      }
  });  

  // Update select all based on individual checkbox 
  $('.selectone').click(function() {
      if ($(this).is(':checked')) {
      	if ($('.selectone:checked').length == $('.selectone').length) {
       		$('.selectall').prop('checked', true);
    		} else {
        	$('.selectall').prop('checked', false);
        }          
      } else {
          $('.selectall').prop('checked', false);
      }
  }); 
  $('.select_row').click(function() {
	  var id = $(this).attr('id');
      if ($(this).is(':checked')) {
          $('.select_td_'+id).prop('checked', true);
      } else {
          $('.select_td_'+id).prop('checked', false);
      }
  });  
  
   $('.select_column').click(function() { 
   	  var id = $(this).attr('id');
      if ($(this).is(':checked')) {
          $('.select_col_'+id).prop('checked', true);
      } else {
          $('.select_col_'+id).prop('checked', false);
      }
  });  
  
});
</script>