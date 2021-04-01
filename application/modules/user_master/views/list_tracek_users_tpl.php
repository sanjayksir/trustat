<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php 
			 
				$label = 'Tracek Users';
			 
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
                                <h5 class="widget-title bigger lighter">Manage <?php echo $label; ?><?php //echo $this->uri->segment(3); ?></h5>
                                <div class="widget-toolbar">
                                    <a href="<?php echo base_url('user_master/add_plant_controller/') ?>/<?php echo $this->uri->segment(3); ?>" class="btn btn-xs btn-warning" title="Add Users"> Add <?php echo $label; ?> </a> | <a href="<?php echo base_url('user_master/list_user/') ?>" class="btn btn-xs btn-warning" title="Add Users"> List Customer <?php //echo $label; ?> </a> | <a href="<?php echo base_url('reports/tracek_user_activity_log') ?>" class="btn btn-xs btn-warning" title="Add Users"> List Tracek Users Activity Log <?php //echo $label; ?> </a>
                                </div>
                            </div>
                        <div class="widget-body">
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
                                            <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="First Name, Last Name, User Name, Email ID or Phone Number">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
              <!--------------- Search Tab start----------------->
                            <table id="missing_people" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>SNo.</th>
										<!---<th><?php //echo $label; ?> Customer</th>-->
                                        <!--<th>First Name</th>-->
										<th>Person Name</th>
                                        <th>User Name</th>
										<th>User Type</th>
										<th>Assigned Locations</th>
                                        <th>Email ID</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            <tbody>
							
							
						 
						 
						 <?php
						//echo $list_all_consumers; 
                        if(count($userListing)>0){
                            $page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
                            $sno =  $page + 1;
							$i=0;
                        foreach ($userListing as $listData){
                        $i++;
                         ?>
						 
                            <?php
                            //$page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
                           
                            //$sno =  $page + 1;
                           
                                    $status = $listData['status'];
                                    if ($status == 1) {
                                        $status = 'Active';
                                        $colorStyle = "style='color:white;border-radius:10px;background-color:green;border:none;'";
                                    } else {
                                        $status = 'Inactive';
                                        $colorStyle = "style='color:black;border-radius:10px;background-color:red;border:none;'";
                                    }
                                    ?>
                                    <tr id="show<?php echo $listData['user_id']; ?>">
                                    <td><?php echo $sno; ?></td>
									<!---<td><?php echo getUserNameById($listData['is_parent']); ?></td>-->
                                   <!-- <td><?php echo $listData['f_name']; ?></td>-->
									<td><?php echo $listData['l_name']; ?></td>
                                    <td><?php echo $listData['user_name']; ?></td>
									<td><?php echo get_role_name_by_designation_id($listData['designation_id']); ?></td>
									<td><?php echo assigned_locations($listData['user_id']); ?></td>
                                    <td><?php echo $listData['email_id']; ?></td>
                                    <td><?php echo $listData['mobile_no']; ?></td>
                                    
                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons" style="width:177px">
                                            <a href="<?php echo base_url() . 'user_master/view_user/' . $listData['user_id']; ?>" class="btn btn-xs btn-success"  target="_blank" title="View"><i class="fa fa-eye"></i></a>
                                            <?php echo anchor("user_master/edit_plant_controller/" . $listData['user_id'], '<i class="ace-icon fa fa-pencil bigger-130"></i>', array('class' => 'btn btn-xs btn-info', 'title' => 'Edit')); ?>
                                    <?php if ($listData['is_verified'] == 1) { ?>
                                            <a title="Delete User" href="javascript:void(0);" onclick="return confirmDelete('<?php echo base64_encode($listData['user_id']); ?>');" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-120"></i></a>  
                                            <input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $listData['user_id']; ?>" value="<?php echo $status; ?>" onclick="return change_status('<?php echo $listData['user_id']; ?>', this.value);" />
                                                    <?php } else { ?>
                                                                                                   <span><a href="#" class="btn btn-xs btn-warning" title="Email Not Verified">X</a></span>
<?php } ?>
                                             </div>
                                         </td>
                                     </tr>
                                <?php
                                $sno++;
                                    }
                                } else {
                                    ?>
                                                                        <tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
                                        <?php } ?>

                            </tbody>
                        </table>
                        <div class="row paging-box">
                            <?php echo $links ?>
                            </div> 
                    </div>
                </div>
                                                        <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
                   
                <div class="footer">
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
		 		window.location.href="<?php echo base_url().'user_master/delplant/';?>"+val;
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