<?php  //echo '<pre>';print_r($listingData);exit; ?>

  <script src="<?php echo base_url().'assets/jquery-alert/';?>dist/sweetalert-dev.js"></script>

  <link rel="stylesheet" href="<?php echo base_url().'assets/jquery-alert/';?>dist/sweetalert.css">

 <div class="col-xs-12">

 

 

      <table id="" class="table-striped table-bordered table-hover">

        <thead>

          <tr>

                <th>#</th>

                <th>Industry Name</th>

             	<th style="text-align:center;" >Action</th>

           </tr>

        </thead>

        <tbody id="table_data_div" class="tree_menu">

          <?php $i=0;foreach($listingData as $val){$i++; ?>

          <tr id="show<?php echo $i;?>">

          <td><?php echo $i;?></td>

            <td><strong><?php echo $val['categoryName']; ?></strong>

            	<div style="margin-top:10px;"><?php 

				##============== get Child level1====================##

				$child_arr = getChildFromParent($val['category_Id']);

				if($child_arr>0){

					foreach($child_arr as $chids){

						echo '<div class="tree_menu_child"><i class="fa fa-angle-double-right" aria-hidden="true"></i> '.$chids['categoryName'].'&nbsp;&nbsp;&nbsp;

						&nbsp;<div style="float:right;"><a title="Edit Child" href="'.base_url().'category/get_edit_section/'.$chids['category_Id'].'"><i class="ace-icon fa fa-pencil"></i></a> </div>&nbsp;&nbsp;<div style="float:right;">&nbsp;&nbsp;<a title="Delete Child" onclick="return deleteAlert('.$chids['category_Id'].','.$chids['category_id'].');" href="javascript:void(0);"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>&nbsp;&nbsp; </div>'.'</div>';

					

					##----------------------Level 2--------------------------##?>

					

					<?php echo create_sub_category_level($chids['category_Id']);?>

					

				<?php	##----------------------Level 2--------------------------##

					

					}

				}

				##============== get Child level1 end====================##

				?>

                </div>

                

             </td>

                <td align="center"><a class="green" href="#" onClick="edit_menu(<?php echo $val['category_Id'];?>);" title="Edit Menu"><i class="ace-icon fa fa-pencil bigger-130"></i> </a> &nbsp; <a class="green del_atert" href="javascript:void(0);"  onclick="return deleteAlert('<?php echo $val['category_Id'];?>');"  title="Delete Category"><i class="ace-icon fa fa-trash-o bigger-120"></i></a> </td>

          </tr>

          <?php } ?>

        </tbody>

      </table>

    

</div>

<script>

function edit_menu(id){

 	window.location.href="<?php echo base_url(); ?>category/get_edit_section/"+id;

 }



  

 function deleteAlert(pId,cId=''){

	 

 		swal({

			title: "Are you sure?",

			text: "You are going to delete the Industry from list",

			type: "warning",

			showCancelButton: true,

			confirmButtonColor: '#DD6B55',

			confirmButtonText: 'Yes, delete it!',

			closeOnConfirm: false

		},

		function(){

			deleteRecord(pId,cId);

 			swal("Deleted!", "Your Industry has been deleted!", "success");

			setTimeout( function(){ 

			     window.location.href="<?php echo base_url();?>category/listing";

			  }  ,1000 );

		});

	 

 }

 

 function deleteRecord(pId,cId=''){

 $.ajax({

			type: "POST",

			dataType:"json",

			url: "<?php echo base_url(); ?>category/delete_menu",

			data: {"parent_id":pId,"child_id":cId },

			success: function (msg) {

				if(parseInt(msg)==1){

					$('#ajax_msg').text("Industry Deleted Successfully!").css("color","green").show();

				}

			} 

		});

 }

	 

</script>

