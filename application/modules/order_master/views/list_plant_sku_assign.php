<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');//echo '<pre>';print_r($plant_data);exit;?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Assign Plants';?>

			<?php $this->load->view('../includes/admin_sidebar');?>
			
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo DASH_B;?>">Home</a>
							</li>

							<li>
							 Manage <?php echo $label;?>
							</li>
  						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							
						</div><!-- /.nav-search -->
					</div>
 					<div class="page-content">
						<?php if($this->session->flashdata('success')!=''){ ?> <div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
 									<i class="ace-icon fa fa-check green"></i>
 									<?php echo $this->session->flashdata('success'); ?>
								</div>
                        <?php } ?>
   						<div class="row">
							<div class="col-xs-12">
 								<div class="row">
									<div class="col-xs-12">
										<h3 class="header smaller lighter blue">List <?php echo $label;?></h3>
 										<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>plant_master/assign_plants" class="btn btn-primary pull-right" title="Add Plant">Assign Products</a></div>
										<!-- div.table-responsive -->
 										<!-- div.dataTables_borderWrap -->
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>#</th>
 														<th>Plant Code</th>
 														<th>Plant Name</th>
														<th>Email ID</th>
														<th>Phone</th>
                                                        <th>Products</th>
  														<th>Created on</th>
 														<th>Action</th>
 													</tr>
												</thead>
												<tbody>

                                        <?php $i = 0;
										if(count($plant_data)>0){
                                        foreach ($plant_data as $listData){
										$i++;
											$status = $listData['status'];
                                            if($status =='1'){
											$status ='Active';
 												$colorStyle="style='color:white;border-radius:10px;background-color:green;border:none;'";
											}else{
											$status ='Inactive';
												$colorStyle="style='color:black;border-radius:10px;background-color:red;border:none;'";
											}?>
                                               <tr id="show<?php echo $listData['plant_id']; ?>">
											   <td><?php echo $i; ?></td>
												<td><?php echo $listData['plant_code'];?></td>
												<td><?php echo $listData['plant_name']; ?></td>
												<td><?php echo $listData['email_id']; ?></td>
												<td><?php echo $listData['phone']; ?></td>
												<td><?php $products = get_assigned_products_list($listData['plant_id']) ;
												
												
												echo get_products_name_by_id($products);?></td>
                                       
												<td><?php echo date('j M Y H:i:s D',strtotime($listData['created_date'])); ?></td>
                                                 <td>
                                                     <div class="hidden-sm hidden-xs action-buttons">
                                                         <!--<a href="<?php  echo base_url().'plant_master/view_plant/'.$listData['plant_id'];?>" class="blue" target="_blank" title="View"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>-->
                                                         <?php echo anchor("plant_master/assign_plants/" . $listData['plant_id'], '<i class="ace-icon fa fa-pencil bigger-130"></i>', array('class' => 'green','title'=>'Edit')); ?>
                                                         <input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $listData['plant_id'];?>" value="<?php echo $status ;?>" onclick="return change_status('<?php echo $listData['plant_id'];?>',this.value);" />

                                                    </div>

                                                </td>
                                             </tr>
                                         <?php }
										} ?>

                                    </tbody>
											</table>
  								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div><div class="footer">
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
			</div>
			</div><!-- /.main-content -->

			 

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
<?php $this->load->view('../includes/admin_footer');?>
<script>
		
function change_status(id,val){
	 if(confirm("Are you sure want to change the plant status?")){
  	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>plant_master/change_assign_product_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(parseInt(result)==1){
						$('#status_'+id).val('Active').css("background-color","green");
					}else{
						$('#status_'+id).val('Inactive').css("background-color","red");
					}
 				}
			});
  }else{
    return false;  
  }
	
}
var table;
 
$(document).ready(function() {/*
 
    //datatables
    table = $('#missing_people').DataTable({ 
 
        "bProcessing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		//"searching":false,
         "language": {          
				"processing": "<img src='<?php echo ASSETS_PATH;?>images/loading-image.gif' />",
			},
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url()?>user_master/list_users",
            "type": "POST",
			"data": function ( data ) {
	               //alert(data);
	            }
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [5,6], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
*/});

function likestatus($id){	

$(document).ready(function() { $.post("<?php echo base_url();?>spideybuzz_missing_people/status/"+$id, function( response ) { 
if(response==0){
$("#"+$id).css("background-color", "#DD5A43");
$("#"+$id).html('Inactive');
}else{
$("#"+$id).css("background-color", "#82AF6F");
$("#"+$id).html('Active');
} 
});
}); 
} 


	function editfunc(id){
		$(document).ready(function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>spideybuzz_missing_people/editdata/"+id,
				data: {id:id},
				success: function (result) {
					$('#edit_popup_model').html(result);
				}
			});
		});
	}
	
 
function deletefunction(id)
{

  if(confirm("Are you sure want to delete?")){
  }else{
    return false;  
  }

           
$(document).ready(function () {
		
    $.ajax({
	type: "POST",
	url: "<?php echo base_url();?>spideybuzz_missing_people/remove/"+id,
	data: {id:id},
	success: function (result) {
                                 if(result ==1){
	                             $("#show"+id).hide();
	                             $('.alert-success').remove();
	                             $('.page-content').prepend('<div class="alert-success"><div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check green"></i>Data has been deleted</div>');
	                                                   }
					
				             }
	    });
		                     });
	
}
</script>
<?php $this->load->view('../includes/admin_footer');?>