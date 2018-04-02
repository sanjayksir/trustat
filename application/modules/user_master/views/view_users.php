<?php //echo '<pre>kam==';print_r($users);exit;?>
<div>
<h4>User Listing</h4>
<ul>
<?php if(count($users)>0){
    		foreach($users as $val){
?>
    		<li><span><?php echo ucfirst($val['user_name']);?></span>&nbsp;&nbsp;<a href="<?php echo base_url().'myspidey_user_group_permissions/myspidey_user_master/edit_user/'.$val['user_id'];?>"><i class="fa fa-pencil-square-o" style="cursor:pointer; color:#fab400; font-size:20px;" title="Edit User"></i></a></li>
<?php 			}
      }else{
	  ?>
      <li>No User</li>
 <?php }?>
</ul>
</div>