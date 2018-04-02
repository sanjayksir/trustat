<?php  //echo '<pre>';print_r($listingData);exit; ?>
  <script src="<?php echo base_url().'assets/jquery-alert/';?>dist/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="<?php echo base_url().'assets/jquery-alert/';?>dist/sweetalert.css">
 <div class="col-xs-12">
 
      <table id="" class="table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>Menu Name</th>
             <th style="text-align:center;" >Action</th>
           </tr>
        </thead>
        <tbody id="table_data_div" class="tree_menu">
          <?php foreach($listingData as $val): ?>
          <tr id="show<?php echo $val['id'];?>">
            <td><strong><?php echo $val['menu']; ?></strong>
            	<div style="margin-top:10px;"><?php 
				##============== get Child ====================##
				$child_arr = getChildFromParent($val['id']);
				if($child_arr>0){
					foreach($child_arr as $chids){
						echo '<div class="tree_menu_child"><i class="fa fa-angle-double-right" aria-hidden="true"></i> '.$chids['menu'].'&nbsp;&nbsp;&nbsp;
						&nbsp;<div style="float:right;"><a title="Edit Child" href="'.base_url().'myspidey_user_group_permissions/edit_child_menu/'.$chids['id'].'"><i class="ace-icon fa fa-pencil"></i></a> </div>&nbsp;&nbsp;<div style="float:right;">&nbsp;&nbsp;<a title="Delete Child" onclick="return deleteAlert('.$val['id'].','.$chids['id'].');" href="javascript:void(0);"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>&nbsp;&nbsp; </div>'.'</div>';
					}
				}
				##============== get Child ====================##
				?>
                </div>
             </td>
                <td align="center"><a class="green" href="#" onClick="edit_menu(<?php echo $val['id'];?>);" title="Edit Menu"><i class="ace-icon fa fa-pencil bigger-130"></i> </a> &nbsp; <a class="green del_atert" href="javascript:void(0);"  onclick="return deleteAlert('<?php echo $val['id'];?>');"  title="Delete Menu"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>&nbsp; <a href="<?php echo base_url(); ?>myspidey_user_group_permissions/get_child_menu/<?php echo $val['id'];?>" class="tooltip-success" data-rel="tooltip" title="Add Child Menu"><i class="fa fa-plus-square bigger-120" aria-hidden="true"></i></a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    
</div>
<script>
function edit_menu(id){
 	window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/get_edit_section/"+id;
 }

  
 function deleteAlert(pId,cId=''){
	 
 		swal({
			title: "Are you sure?",
			text: "You are going to delete the menu from list",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Yes, delete it!',
			closeOnConfirm: false
		},
		function(){
			deleteRecord(pId,cId);
 			swal("Deleted!", "Your menu has been deleted!", "success");
			setTimeout( function(){ 
			     window.location.href="<?php echo base_url();?>myspidey_user_group_permissions/listing";
			  }  ,1000 );
		});
	 
 }
 
 function deleteRecord(pId,cId=''){
 $.ajax({
			type: "POST",
			dataType:"json",
			url: "<?php echo base_url(); ?>myspidey_user_group_permissions/delete_menu",
			data: {"parent_id":pId,"child_id":cId },
			success: function (msg) {
				if(parseInt(msg)==1){
					$('#ajax_msg').text("User Added Successfully!").css("color","green").show();
				}
			} 
		});
 }
	 
</script>
