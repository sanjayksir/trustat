<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Locations'; ?>

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
										<?php if($this->session->userdata('admin_user_id')==1){?>
 	<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>user_master/add_location/<?php echo $this->uri->segment(3); ?>" class="btn btn-primary pull-right" title="Add New Location">Add New Location</a>
		<a href="<?php echo base_url()?>plant_master/list_assigned_locations_user/<?php echo $this->uri->segment(3); ?>" class="btn btn-primary pull-right" title="List Assigned Locations to User">List Assigned Locations to User</a>
										</div>
										<?php }else{ ?>
										<a href="<?php echo base_url()?>plant_master/list_assigned_locations_user" class="btn btn-primary pull-right" title="List Assigned Locations to User">List Assigned Locations to User</a>
										<?php } ?>
										</div>
										<!--------------- Search Tab start----------------->
                            <div class="row"><form id="form-filter" action="" method="post" class="form-horizontal" onsubmit="return validateSrch();">
                                <table id="search" class="table table-hover display">
                                    
                                        <tbody>
                                        	<tr>
                                            	<td><input name="search" value="<?php if(!empty($this->input->post('search'))){echo $this->input->post('search');}?>" id="searchStr" placeholder="Search Records" class="form-control" type="text"></td>
                                            	<td>
                                                	<input type="submit" id="btn-filter" value="Search" name="Search" class="btn btn-primary btn-search">&nbsp;
                                                	<a href="<?php echo base_url(); ?>plant_master/list_locations/<?php echo $this->uri->segment(3); ?>"><button type="button" id="btn-reset" class="btn btn-default btn-search">Reset</button></a>
                                            	</td>
                                         	</tr>
                                 		 </tbody>
                                   	
                                 </table></form>
                            </div>
                      <!--------------- Search Tab start----------------->
 										<!-- div.dataTables_borderWrap -->
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>#</th>
 														<th>Location Code</th>
 														<th>Location Name</th>
														<th>Location Type</th>
														<th>Email ID</th>
														<th>Phone</th>
														<?php if($this->session->userdata('admin_user_id')==0){?>
                                                        <th>GST</th>
 														<th>State</th>
                                                        <th>Address</th>
                                                        <th>Remark</th>
 														<th>Customer Name</th>
														<?php }else{?>
														
 														<th>Assigned To</th>
														<th>Assigned Product</th>
														<?php }?>
														<th>Created on</th>
 														<th><?php if($this->session->userdata('admin_user_id')==1){?>
														<div style="width:140px">View and Action  </div>
														<?php }else{?>
														<div style="width:100px"> Details & Status</div>
														<?php }?>
														</th>
 													</tr>
												</thead>
												<tbody>

                                        <?php $i = 0;
										
										//echo '<pre>';print_r($userListing);exit;
										if(count($userListing)>0){
                                        foreach ($userListing as $listData){
										$i++;
											$status = $listData['status'];
                                            if($status ==1){
											$status ='Active';
 												$colorStyle="style='color:white;border-radius:10px;background-color:green;border:none;'";
											}else{
											$status ='Inactive';
												$colorStyle="style='color:black;border-radius:10px;background-color:red;border:none;'";
											}?>
                                               <tr id="show<?php echo $listData['location_id']; ?>">
											   <td><?php echo $i; ?></td>
											   <td><?php echo $listData['location_code']; ?></td>
											   <td><?php echo $listData['location_name']; ?></td>
												<td><?php echo $listData['location_type']; ?></td>
												<td><?php echo $listData['email_id']; ?></td>
												<td><?php echo $listData['phone']; ?></td>
												<?php if($this->session->userdata('admin_user_id')==0){?>
												<td><?php echo $listData['gst']; ?></td>
                                                <td><?php echo $listData['state']; ?></td>
                                                <td><?php echo $listData['address']; ?></td>
                                                <td><?php echo $listData['remark']; ?></td>
												<td><?php echo getUserNameById($listData['created_by']); ?></td>
												<?php }else{?>
												
                                                <td><?php 	$plntCtl =  assigned_users_of_the_location($listData['created_by'],$listData['location_id']); 
															$explod_arr = explode(',',$plntCtl);
															echo implode('<br><hr>',$explod_arr );
															 
												?></td>
												 <td><?php $product_name= productNameByAssignedLocations($listData['location_id']); 
												 			$explod_arr2 = explode(',',$product_name);
															echo implode('<br><hr>',$explod_arr2 );
												 ?></td>
												<?php }?>
												<td><?php echo date('j M Y H:i:s D',strtotime($listData['created_date'])); ?></td>
                                                 <td>
                                                     <div class="hidden-sm hidden-xs action-buttons">
													 
													 <?php if($this->session->userdata('admin_user_id')==1){?>
												
                                                         <a href="<?php  echo base_url().'plant_master/view_location/'.$listData['location_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"><i class="fa fa-eye"></i></a>
                                                         <?php echo anchor("user_master/edit_location/" . $listData['location_id'], '<i class="ace-icon fa fa-pencil bigger-130"></i>', array('class' => 'btn btn-xs btn-info','title'=>'Edit')); ?>
                                                         <!--<a title="Delete Plant" href="javascript:void(0);" onclick="return confirmDelete('<?php //echo base64_encode($listData['plant_id']);?>');" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>-->
                                                         
                                                         <input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $listData['location_id'];?>" value="<?php echo $status ;?>" onclick="return change_status('<?php echo $listData['location_id'];?>',this.value);" />
													 <?php }else{ ?>
												<a href="<?php  echo base_url().'plant_master/view_location/'.$listData['location_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"><i class="fa fa-eye"></i></a>
												<input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $listData['location_id'];?>" value="<?php echo $status ;?>" />		 
														 <?php } ?>

                                                    </div>

                                                </td>
                                             </tr>
                                         <?php }
										}else{ ?>
										
										<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>

                                    </tbody><tr><td align="right" colspan="10" class="color"><?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?></td></tr>
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

function confirmDelete(val='')
{
	if(val!=''){
		var x = confirm("Are you sure you want to delete?");
		 if (x){
		 		window.location.href="<?php echo base_url().'plant_master/del/';?>"+val;
 			  //return true;
		 }
		 else{
			return false;
		 }
	}
}

function validateSrch(){
	$("#searchStr").removeClass('error');
	var val = $("#searchStr").val();
 	if(val.trim()==''){
		$("#searchStr").addClass('error');
		return false;
	}
}			
function change_status(id,val){
	if(confirm("The status of the location will be changed, press OK to confirm or Cancel it.")){
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>plant_master/change_location_status/",
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