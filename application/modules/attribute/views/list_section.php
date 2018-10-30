<?php   //echo '<pre>';print_r($listingData);exit; ?>

  <script src="<?php echo base_url().'assets/jquery-alert/';?>dist/sweetalert-dev.js"></script>

  <link rel="stylesheet" href="<?php echo base_url().'assets/jquery-alert/';?>dist/sweetalert.css">

 <div class="col-xs-12">

 

 

      <table id="" class="table-striped table-bordered table-hover">

        <thead>

          <tr>

                <th>#</th>

                <th>Attribute Name</th>
				<th>Assigned Industries </th>

             	<th style="text-align:center;" >Action</th>

           </tr>

        </thead>

        <tbody id="table_data_div" class="tree_menu">

          <?php $i=0;foreach($listingData as $val){$i++; ?>

          <tr id="show<?php echo $i;?>">

          <td><?php echo $i;?></td>

            <td><strong><?php echo $val['name']; ?></strong>

            	<div style="margin-top:10px;"><?php 

				##============== get Child level1====================##

				$child_arr = getChildFromParent_ATTR($val['product_id']);

				if($child_arr>0){

					foreach($child_arr as $chids){

						echo '<div class="tree_menu_child"><i class="fa fa-angle-double-right" aria-hidden="true"></i> '.$chids['name'].'&nbsp;&nbsp;&nbsp;

						&nbsp;<div style="float:right;"><a title="Edit Child" href="'.base_url().'attribute/get_edit_section/'.$chids['product_id'].'"><i class="ace-icon fa fa-pencil"></i></a> </div>&nbsp;&nbsp;<div style="float:right;">&nbsp;&nbsp;<a title="Delete Child" onclick="return deleteAlert('.$chids['product_id'].','.$chids['product_id'].');" href="javascript:void(0);"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>&nbsp;&nbsp; </div>'.'</div>';

					

					##----------------------Level 2--------------------------##?>

					

					<?php echo create_sub_category_level_ATTR($chids['product_id']);?>

					

				<?php	##----------------------Level 2--------------------------##

					

					}

				}

				##============== get Child level1 end====================##

				?>

                </div>

                

             </td>
				<td> <?php //echo $val['industry_id']; 
				$character = json_decode($val['industry_id']);	
				
				//echo $character;
				
				//$industry_ids=implode(",<br>",$character);
				//echo " " . $industry_ids;
				foreach ($character as $topping) {
						echo " &nbsp;&nbsp; " . get_industry_name_by_id($topping) . "<br>";
					}
				

				//echo get_industry_name_by_id($string);
				
				?></td>
                <td align="center"><a class="green" href="#" onClick="edit_menu(<?php echo $val['product_id'];?>);" title="Edit Menu"><i class="ace-icon fa fa-pencil bigger-130"></i> </a> &nbsp; <a class="green del_atert" href="javascript:void(0);"  onclick="return deleteAlert('<?php echo $val['product_id'];?>');"  title="Delete Attribute"><i class="ace-icon fa fa-trash-o bigger-120"></i></a> </td>

          </tr>

          <?php } ?>
			<tr><td colspan="4"><div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
					&nbsp; &nbsp;
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
					</div>
				</div>
			</div></td></tr>
        </tbody>

      </table>

    

</div>

<script>

function edit_menu(id){

 	window.location.href="<?php echo base_url(); ?>attribute/get_edit_section/"+id;

 }



  

 function deleteAlert(pId,cId=''){

	 

 		swal({

			title: "Are you sure?",

			text: "You are going to delete the Attribute from list",

			type: "warning",

			showCancelButton: true,

			confirmButtonColor: '#DD6B55',

			confirmButtonText: 'Yes, delete it!',

			closeOnConfirm: false

		},

		function(){

			deleteRecord(pId,cId);

 			swal("Deleted!", "Your Attribute has been deleted!", "success");

			setTimeout( function(){ 

			     window.location.href="<?php echo base_url();?>attribute/listing";

			  }  ,1000 );

		});

	 

 }

 

 function deleteRecord(pId,cId=''){

 $.ajax({

			type: "POST",

			dataType:"json",

			url: "<?php echo base_url(); ?>attribute/delete_menu",

			data: {"parent_id":pId,"child_id":cId },

			success: function (msg) {

				if(parseInt(msg)==1){

					$('#ajax_msg').text("Attribute Deleted Successfully!").css("color","green").show();

				}

			} 

		});

 }

	 

</script>

