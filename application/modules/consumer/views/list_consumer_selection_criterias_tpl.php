<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php 
			if($this->session->userdata('admin_user_id')==1){
				$label = 'Customer';
			}else{
				$label = 'Consumer Selection Criteria';
			}
			?>

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
						
						<?php //echo '<pre>';print_r($userListing);?>
 						<div class="row">
							<div class="col-xs-12">
 								<div class="widget-box widget-color-blue">
                                                                    <div class="widget-header widget-header-flat">
                                                                    <h5 class="widget-title bigger lighter">List <?php echo $label;?>s</h5>
                                                                    <div class="widget-toolbar">
																	<?php 
																	$customer_id = $this->session->userdata('admin_user_id');
																	$unique_system_selection_criteria_id  = $customer_id . "" .date("YmdHis"); 
																	//echo $next_criteria_id;
																	?>
                                                            <a href="<?php echo base_url('consumer/add_consumer_selection_criteria') ."/".  $unique_system_selection_criteria_id; ?>" class="btn btn-xs btn-warning" title="Add User">Add New <?php echo $label; ?> </a>
                                                                    </div>
                                                                </div>
									<div class="widget-body">
										
										
										<?php 
										$label = 'Assigned'; 
										if($this->session->userdata('admin_user_id')==1){
											$label = 'Created';
										}?>
										<!--------------- Search Tab start----------------->
                           <div class="row filter-box">
            <form id="form-filter" action="" method="get" class="form-horizontal" >
                <div class="col-sm-6">
                    <label>Display
                        <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
                        <?php echo Utils::selectOptions('pagelimit',['options'=>$this->config->item('pageOption'),'value'=>$this->config->item('pageLimit')]) ?>
                        </select>
                    Records
                    </label>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Unique System Selection Criteria ID OR Name of Selection Criteria">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                            <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
					  
					  
					  
                        <table id="missing_people" class="table table-striped table-bordered table-hover">
                            <thead>
                                    <tr>
                                            <th>#</th>
                                            <th>Unique System Selection Criteria ID</th>
											<th>Last Modified</th>
                                            <th>Name of Selection Criteria</th>
                                            <th>Selected Consumers</th>
                                            <th>Action on Selection Criteria</th>
                                    </tr>
                            </thead>
                            <tbody>

                                        <?php $i = 0;
                                        $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
										$sno =  $page + 1;
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
										<tr id="show<?php echo $listData['criteria_id']; ?>">
                                           <td><?php echo $sno;$sno++; ?></td>
                                           <td><?php echo $listData['unique_system_selection_criteria_id']; ?></td>
										   <td><?php echo $listData['update_date']; ?></td>
                                           <td><?php echo $listData['name_of_selection_criteria']; ?></td>
                                           <td><?php //echo NumberOfSelectedConsumersByACustomer($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_pin, $csc_consumer_min_dob, $csc_consumer_max_dob); ?>
			<?php /*
			$earned_loyalty_points_clubbed = $listData['earned_loyalty_points'];
			$arr = explode(' ',trim($earned_loyalty_points_clubbed));
			$ELP_from = $arr[0];
			$ELP_to = $arr[2];
			//echo  $ELP_from . "-" . $ELP_to . "<br>"; 
			$job_profile = $listData['job_profile'];
			//echo  $job_profile . "<br>"; 
			?>

				
				<?php
				$consumer_min_age = $listData['consumer_min_age'];
				$consumer_max_age = $listData['consumer_max_age'];
				$earned_loyalty_points = $listData['earned_loyalty_points'];
				//echo $consumer_min_age . "<br>";
				//echo $consumer_max_age . "<br>";
				//echo $earned_loyalty_points . "<br>";
$endmindob = date('Y-m-d', strtotime('-' . $consumer_min_age . ' years'));
$endmaxdob = date('Y-m-d', strtotime('-' . $consumer_max_age . ' years'));
//echo $endmindob . "<br>";
//echo $endmaxdob . "<br>";
*/
?><?php echo $listData['number_of_consumers_selected']; ?> Consumers
											<a href="<?php  echo base_url().'product/list_consumers_as_per_selection_criterias/'.$listData['unique_system_selection_criteria_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"> <i class="fa fa-eye"> View List</i></a>
											
											</td>
                                       <!--    <td><?php if($this->session->userdata('admin_user_id')==1){
				
												//$location_name = get_all_active_locations($listData['user_id']);
															//echo $location_name['location_name'];
															//print_r($array['location_name']);
															
															/*
															foreach ($location_name as $key => $value) {
																echo $value['location_name'] . ' [' .  $value['location_type']. ']' . '<br/>';
															}
															*/
															?>
															<a href="<?php  echo base_url().'user_master/view_user/'.$listData['user_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"><i class="fa fa-eye"> Select </i></a>
															<?php
															}else{
																//echo assigned_locations($listData['user_id']);
															}

												?>
												
												
												</td>-->
                                                 <td>

                                                    <div class="hidden-sm hidden-xs action-buttons">
                                                        <a href="<?php  echo base_url().'consumer/view_consumer_selection_criteria/'.$listData['unique_system_selection_criteria_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"><i class="fa fa-eye"></i></a>
                                                         <?php echo anchor("consumer/edit_consumer_selection_criteria/" . $listData['unique_system_selection_criteria_id'], '<i class="ace-icon fa fa-pencil bigger-130"></i>', array('class' => 'btn btn-xs btn-info','title'=>'Edit')); ?>                                                      
                                                    </div>

                                                </td>
                                             </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
									
                                    </tbody>
											</table>
                                                                                <div class="row paging-box">
<?php echo $links ?>
</div>
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

function validateSrch(){
	$("#searchStr").removeClass('error');
	var val = $("#searchStr").val();
 	if(val.trim()==''){
		$("#searchStr").addClass('error');
		return false;
	}
}
	
	
function confirmDelete(val='')
{
	if(val!=''){
		var x = confirm("Are you sure you want to delete?");
		 if (x){
		 		window.location.href="<?php echo base_url().'user_master/del/';?>"+val;
 			  //return true;
		 }
		 else{
			return false;
		 }
	}
}
	
function change_status(id,val){

	if (confirm('Sure to change the status?')) { 
		 // do things if OK
		$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>user_master/change_status/",
					data: {id:id, value:val},
					success: function (result) {
						if(parseInt(result)==1){
							$('#status_'+id).val('Active').css("background-color","green");
						}else{
							$('#status_'+id).val('Inactive').css("background-color","red");
						}
						
					}
				});
	}
	return false;
	
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