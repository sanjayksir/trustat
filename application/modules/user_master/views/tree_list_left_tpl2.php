<link rel="stylesheet" href="<?php echo base_url();?>assets/tree/css/easyTree.css">
<script src="<?php echo base_url();?>assets/tree/src/easyTree.js"></script>
<div class="col-xs-12">
  <div class="widget-box">
    <div class="widget-header">
      <h4 class="widget-title">Add Group</h4>
      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> </div>
    </div>
    <div class="widget-body">
      <div class="show_loader" style="display:block;">Loading............... </div>
      <!------------------------------- Tree start ------------------------------->
      <div class="col-md-12" id="tree">
       <div class="easy-tree">
       
       	<ul>
        	<li>Administrator
             <ul>
               
                <li class="parent_li">Test Group 1
                	<ul>
                    	<li class="parent_li">Amlesh
                        	<ul>
                            	<li>Ramesh</li>
                            	<li>Puneet</li>
                            </ul>
                        
                        </li>
                        <li>Samresh</li>
                    </ul>
                
                </li>
                <li>Test Group 2
                
                	<ul>
                    	<li>Sandeep
                        	<ul>
                    			<li>Sandeep</li>
                    			<li>Rocky</li>
                    		</ul>
                        
                        </li>
                    	 
                    </ul>
                
                </li>
                <li>Test Group 3</li>
                
                
                </li>
                <li>Test Group 1</li>
                <li>Test Group 2</li>
                <li>Test Group 3</li>
             </ul>
            </li>
        </ul>
      
      
        <?php $user_id=$this->session->userdata('user_id');
			if($user_id=='1'){//echo 'kamal';exit;?>
            <ul><?php 
 				$res = getGroupList_AD();
				if(@$_GET['kam']){
					echo '<pre>';print_r($res);exit;
				}
				if(count($res)>0){
				//foreach($res as $k=>$val){
				echo '<li>'	;
					?>
                	 <?php echo $res['usergroup_name'];?>
                     <ul>
                     	<?php 
						$chlGrp = getGroupList_GRPS();
					 // echo '<pre>';print_r($chlGrp);exit;
						foreach( $chlGrp as $k=>$v){?>
                        <li class="licl" id="<?php echo 'li_'.$k;?>"> <?php echo $v['usergroup_name'];?><input type="hidden" id="<?php echo $v['usergroup_id'];?>" value="View User" />
                        	<?php foreach(getGroupList_GRPS($v['usergroup_id']) as $key=>$child){?>
                            	<ul> <!-- <label>User under gp 1</label>-->
                                    <li><?php echo $child['usergroup_name'];?><input type="hidden" id="<?php echo $child['usergroup_id'];?>" value="View User" />
                                    <?php foreach(getGroupList_GRPS($child['usergroup_id']) as $key=>$child2){?>
                            	<ul> <!-- <label>User under gp 1</label>-->
                                    <li><?php echo $child2['usergroup_name'];?></li><input type="hidden" id="<?php echo $child2['usergroup_id'];?>" value="View User" />
                                  </ul>
                            <?php }?>
                                    
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
              <?php echo '</li>'	;?>
                <?php // }
				}else{?>
                No Group Available
                <?php }?>
            </ul>
            <?php }else{?>
                	<ul>
                     	<?php $chlGrp = getGroupList_GRPS(2);
					 		  if(($chlGrp)>0){
								foreach( $chlGrp as $k=>$v){?>
                        <li class="licl" id="<?php echo 'li_'.$k;?>"> <?php echo $v['usergroup_name'];?><input type="hidden" id="<?php echo $v['usergroup_id'];?>" value="View User" />
                        	<?php foreach(getGroupList_GRPS($v['usergroup_id']) as $key=>$child){?>
                            	<ul> <!-- <label>User under gp 1</label>-->
                                    <li><?php echo $child['usergroup_name'];?><input type="hidden" id="<?php echo $child['usergroup_id'];?>" value="View User" />
                                    <?php foreach(getGroupList_GRPS($child['usergroup_id']) as $key=>$child2){?>
                            	<ul> <!-- <label>User under gp 1</label>-->
                                    <li><?php echo $child2['usergroup_name'];?></li><input type="hidden" id="<?php echo $child2['usergroup_id'];?>" value="View User" />
                                  </ul>
                            <?php }?>
                                    
                                    </li>
                                  </ul>
                            <?php }?>
                               <!-- <li>Example 2</li>
                                <li>Example 3</li>
                                <li>Example 4</li>-->
                            
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
 		 window.location.href="<?php echo base_url();?>myspidey_user_group_permissions/set_permissions/"+id;
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

<a id="fetchUsers" class="demo-2"></a>
 
 <!--- VIew USer POpup --->
<a id="fetchUsers" class="demo-2"></a>
<div id="popup1"><h2>View Users</h2></div>
<!--- VIew USer POpup ---> 



            <div id="popup1">
            	<a id="fetchUsers" class="demo-2 btn btn-primary">HTML Block</a>
                <h2>View Users</h2>
                
            </div>
</div>
 


            <div id="popup1">
                <h2>View Users</h2>
                
            </div>
</div>

<script src="<?php echo base_url();?>assets/popup/dist/jquery.simple-popup.min.js"></script>
<script>
$(document).ready(function() {
  $("a.demo-1").simplePopup();
  $("a.demo-2").simplePopup({ type: "html", htmlSelector: "#popup1" });
});
</script>
