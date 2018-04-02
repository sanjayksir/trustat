<link rel="stylesheet" href="<?php echo base_url();?>assets/tree/css/easyTree.css">
<script src="<?php echo base_url();?>assets/tree/src/easyTree.js"></script>
<div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Group Listing Tree</h4>
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> </div>
    </div>
    <div class="widget-body">
     <!-- <div class="show_loader" style="display:block;">Loading............... </div>-->
      <!------------------------------- Tree start ------------------------------->
      <div class="col-md-12" id="tree">
        <div class="easy-tree">
        <?php $user_id=$this->session->userdata('admin_user_id');
		//print_r($user_id);exit;
			if($user_id=='1'){//echo 'kamal';exit;?>
             <?php //echo 'kamal====>'.getGroupList_AD();exit;
 				$res = getGroupList_AD();   
 				if(count($res)>0){?>
					<div class="grup_name_css"><?php if(!empty($res['usergroup_name'])){echo $res['usergroup_name'];}?></div>
                     <ul>
                     	<?php 
						$chlGrp = getGroupList_GRPS();
					  //echo '<pre>';print_r($chlGrp);exit;
						foreach( $chlGrp as $k=>$v){?>
                        <li class="parent_li" id="<?php echo 'li_'.$k;?>"> <?php echo $v['usergroup_name'];?><input type="hidden" class="userIDs" id="<?php echo $v['usergroup_id'];?>" value="View User" />
                        	<?php foreach(getGroupList_GRPS($v['usergroup_id']) as $key=>$child){?>
                            	<ul> <!-- <label>User under gp 1</label>-->
                                    <li><?php echo $child['usergroup_name'];?><input type="hidden" id="<?php echo $child['usergroup_id'];?>" value="View User" />
                                    <!--<?php //foreach(getGroupList_GRPS($child['usergroup_id']) as $key=>$child2){?>
                            	<ul>  
                                    <li><?php echo $child2['usergroup_name'];?></li><input type="hidden" id="<?php echo $child2['usergroup_id'];?>" value="View User" />
                                  </ul>-->
                            <?php // }?>
                                     </li>
                                  </ul>
                            <?php }?>
                               <!-- <li>Example 2</li>
                                <li>Example 3</li>
                                <li>Example 4</li>-->
                            
                        </li>
                        <?php }?>
                        <!--<li>Example 3</li>
                        <li>Example 4</li>-->
                     </ul> 
              <?php //echo '</li>'	;?>
                <?php // }
				}else{?>
                No Group Available
                <?php }?>
          
            <?php }else{?>
           <div class="grup_name_css"><?php if(!empty(displayGroupName())){echo ucfirst(displayGroupName());}?></div>
                	<ul>
                     	<?php $chlGrp = getGroupList_GRPS();
						//echo '===<pre>';print_r($chlGrp); 
					 		  if(($chlGrp)>0){
								foreach( $chlGrp as $k=>$v){?>
                        <li class="licl" id="<?php echo 'li_'.$k;?>"> <?php echo $v['usergroup_name'];?><input type="hidden" id="<?php echo $v['usergroup_id'];?>" value="View User" />
                        	<?php //foreach(getGroupList_GRPS($v['usergroup_id']) as $key=>$child){?>
                            	<!--<ul>
                               		<li><?php echo $child['usergroup_name'];?><input type="hidden" id="<?php echo $child['usergroup_id'];?>" value="View User" /></li>
                                </ul>-->
                            <?php //}?>
                         </li>
                        <?php }?>
                		<?php }else{?>
                    		 No Group Available
                    	<?php }?>
                     </ul>
  			<?php }?>
         </div>
      </div>
      
      <script>
	  function editgroup(id)
	  {
 		 window.location.href="<?php echo base_url();?>myspidey_user_group_permissions/edit_group/"+id;
 	  }
      function showUsers(id)
	  {
 		$.ajax({
				type: "POST",
				url: "<?php echo base_url().'myspidey_user_group_permissions/view_users'?>",
				data: {id: id},
				success:function(result){
					$("#popup1").html(result);
					$("#fetchUsers").click();
				}
		});
 	  }
	  
	  function load_permissions(id)
	  {
		 	$.ajax({
					type: "POST",
					url: "<?php echo base_url().'myspidey_user_group_permissions/isPermissionExists'?>",
					data: {id: id},
					success:function(result){
						if(result>0){
							 window.location.href="<?php echo base_url();?>myspidey_user_group_permissions/edit_permissions/"+id;
						}else{
							 window.location.href="<?php echo base_url();?>myspidey_user_group_permissions/set_permissions/"+id;
						}
 					}
			}); 
  	  }
      </script>
       <!------------------------------- Tree start ------------------------------->
      
      <div style="clear:both;"></div>
    </div>
  </div>
</div>
<script>
    (function ($) {
        function init() {
            $('.easy-tree').EasyTree({});
        }

        window.onload = init();
    })(jQuery)
</script> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
<link href="<?php echo base_url();?>assets/popup/dist/jquery.simple-popup.min.css" rel="stylesheet" type="text/css">
<style>
body { font-family:'Roboto'; line-height:1.58;}
.container { margin:70px auto;}
#popup1 { display:none; }
</style>

 
 <!--- VIew USer POpup --->
<a id="fetchUsers" class="demo-2"></a>
<div id="popup1"><h2>View Users</h2></div>
<!--- VIew USer POpup ---> 
 
<script src="<?php echo base_url();?>assets/popup/dist/jquery.simple-popup.min.js"></script>
<script>
$(document).ready(function() {
  $("a.demo-1").simplePopup();
  $("a.demo-2").simplePopup({ type: "html", htmlSelector: "#popup1" });
});
</script>
