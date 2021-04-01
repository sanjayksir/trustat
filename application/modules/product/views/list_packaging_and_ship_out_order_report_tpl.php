<?php $this->load->view('../includes/admin_header'); ?>

<?php //echo '<pre>';print_r($product_list);exit;
$this->load->view('../includes/admin_top_navigation'); ?>

<div class="main-container ace-save-state" id="main-container">

    <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
    </script>

    <?php $this->load->view('../includes/admin_sidebar'); ?>
	
	 
	

     <div class="main-content">

        <div class="main-content-inner">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">

                <ul class="breadcrumb">

                    <li>

                        <i class="ace-icon fa fa-home home-icon"></i>

                       <a href="<?php echo DASH_B;?>">Home</a>

                    </li>



                    <li>

                        <a href="#">Tracek MIS</a>

                    </li>

                    <li class="active">Picking & Packing Status Report</li>

                </ul><!-- /.breadcrumb -->

              

            </div>



            <div class="page-content">

                <?php if ($this->session->flashdata('success') != '') { ?> <div class="alert alert-block alert-success">

                        <button type="button" class="close" data-dismiss="alert">

                            <i class="ace-icon fa fa-times"></i>

                        </button>



                        <i class="ace-icon fa fa-check green"></i>



                        <?php echo $this->session->flashdata('success'); ?>

                    </div>

                <?php } ?>

                

                 <div class="row">
				 
	 
<?php
$user_id 	= $this->session->userdata('admin_user_id'); ?>
                        <div class="widget-box widget-color-blue">
                           <div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">Picking & Packing Status Report</h5>
                                <!--<div class="widget-toolbar">
                                    <a href="<?php //echo base_url('product/add_product') ?>" class="btn btn-xs btn-warning" title="Add Product">Add <?php echo $label; ?> </a>
                                </div>-->
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
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Tracek Users Name, Phone">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                    <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                      <!--------------- Search Tab start----------------->
					  <div style="overflow-x:auto;">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
														<th>S No.</th>
														<th>Picklist DateTime</th>
														<th>Picklist Number</th>
														<th>Order ID</th>
														<th>Packaging Supervisor ID</th>
														<th>Packaging Supervisor Name</th>
														<th>Assign Supervisor DateTime</th>
														<th>Packer ID</th>
														<th>Packer Name</th>														
														<th>Assign to Packer Date Time</th>
														<th>Start time of Picking & Packing</th>
														<th>Closing time for Picking and Packing</th>
														<th>If any Shortage in Packing</th>
														<th>Details of Shortage</th>
														<th>Assigned/Pending Assignment</th>
														<th>View Picklist</th>
														<th>Edit Supervisor Assignment</th>
														<th>Edit Packer Assignment</th>
														<!--<th>Picklist Packaging Status</th>	
														<th>Packaging Order ID</th>
														<th>Packaging Order DateTime</th>
														<th>Unique Token ID</th>
														<th>Delivery Chalan Number</th>
													    <th>Company ID</th>
														<th>Assigned by</th>
														<th>Product Origin Type</th>
														<th>Product ID</th>
														<th>Product Name</th>
														<th>Product Item Quantity</th>
														<th>Bin Number</th>
														<th>Microsite URL</th>
														<th>Microsite User IP Address</th>
														<th>Microsite User Latitude</th>
														<th>Microsite User Longitude</th>
														<th>Microsite User City</th>
														<th>Microsite User Pin Code</th> -->
                                </tr>
                            </thead>
                            <tbody>
									  
                        <?php
                        if(count($list_all_consumers)>0){
                            $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
                            $sno =  $page + 1;
                        $i=0;
                        foreach ($list_all_consumers as $attr){
                        $i++;
                         ?>
                                <tr id="show<?php echo $attr['user_id'];?>">
                                <td><?php echo $sno; ?></td>
								<td><?php echo $attr['psoo_date_time']; ?></td>
								<td><?php echo $attr['pick_list_number']; ?></td>
								<td><?php echo $attr['psoo_invoice_number']; ?></td>								
								<td><?php echo $attr['tracek_user_id']; ?></td>
								<td><?php echo $attr['tracek_user_name']; ?></td>
								<td><?php echo $attr['assigned_to_psupervisor_datetime']; ?></td>
								<td><?php echo $attr['tracek_packer_id']; ?></td>
							    <td><?php echo $attr['tracek_packer_name']; ?></td>
								<td><?php echo $attr['tracek_packer_assigned_datetime']; ?></td>
								<td><?php //echo $attr['psoo_product_origin_type']; ?></td>
								<td><?php //echo $attr['product_id']; ?></td>
								<td><?php //echo $attr['product_name']; ?></td>
								<td><?php //echo $attr['short_closure']; ?></td>
							    <td><?php //echo $attr['psoo_bin_number']; ?></td>
								<td><?php														 
									echo anchor("reports/packaging_and_ship_out_order_report_details/".$attr['psoo_token_id'], ' <i class="ace-icon fa fa-eye bigger-130"> View </i> ', array('class' => 'btn btn-xs btn-info','title'=>'View Report'));	
										 ?></td>
							    <td> <?php $print_opt = 1; ?>
											<select name="report_auto_email_status" id="report_auto_email_status" onchange="return change_assigned_packaging_supervisor('<?php echo $attr['psoo_token_id'];?>',this.value,'<?php echo $print_opt;?>');">
                                               <option value="<?php echo $val['tracek_user_id'];?>" <?php if($attr['tracek_user_id']!='0'){echo 'selected';} ?>><?php echo $attr['tracek_user_name']; ?></option>
                                              <?php foreach(getAllPackagingSupervisorUser($attr['customer_id']) as $val){ ?>
												<option value="<?php echo $val['user_id'];?>"><?php echo $val['l_name'];?></option> 												
											<?php } ?>
											<option value="0">Unassign Picklist</option> 
                                          </select> 
										 </td>  
									<td> <?php $print_opt = 1; ?>
											<select name="report_auto_email_status" id="report_auto_email_status" onchange="return change_assigned_packer('<?php echo $attr['psoo_token_id'];?>',this.value,'<?php echo $print_opt;?>');">
                                               <option value="<?php echo $val['tracek_packer_id'];?>" <?php if($attr['tracek_packer_id']!='0'){echo 'selected';} ?>><?php echo $attr['tracek_packer_name']; ?></option>
                                              <?php foreach(getAllPackerUser($attr['customer_id']) as $val){ ?>
												<option value="<?php echo $val['user_id'];?>"><?php echo $val['l_name'];?></option> 												
											<?php } ?>
											<option value="0">Unassign Picklist</option> 
                                          </select> 
										 </td> 	
										 <!--<td><?php if($attr['psoo_packing_start_date_time']=="0000-00-00 00:00:00"){ echo "Not Yet Started"; } ?><?php if($attr['psoo_packing_end_date_time']=="0000-00-00 00:00:00"){ echo "Not Completed"; } ?></td>-->
                                             </tr>

                                        <?php
                                        $sno++;
                                        } 
										}else{?>
											<tr><td align="center" colspan="23" class="color error">No Records Founds</td></tr>
										<?php }?>
										  <!--<tr id="show<?php //echo $attr['user_id']; ?>"><td colspan="8"><input class="btn btn-primary pull-right" type="button" id="assign" name="assign" value="Assign Product" /></td></tr>-->

                                    </tbody>
                                </table>
								</div>
                            <div class="row paging-box">
                            <?php echo $links ?>
                            </div>    
                        </div><!-- /.col -->

                    </div><!-- /.col -->

                    </div><!-- /.row -->

                </div><!-- /.page-content -->
            <div class="footer">

                <div class="footer-inner">

                    <div class="footer-content">

                        <span class="bigger-120">
						<span class="blue bolder">Copyright ©</span>
						<?php //echo date('Y');?> <a href="https://innovigent.in/" target="_blank"> Innovigent Solutions Private Limited </a>
					   </span>

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
         </div>

        </div><!-- /.main-content -->
  <?php $this->load->view('../includes/admin_footer');?>
<script>

    function change_assigned_packaging_supervisor(id,val){
    $("#order_status_"+id).hide();
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>product/change_assigned_packaging_supervisor/",
                    data: {id:id, value:val},
                    success: function (result) {
                            if(result!=''){
                                    alert('Packaging Supervisor Changed Successfully');
                              window.location.href="<?php echo base_url().'reports/packaging_and_ship_out_order_report'; ?>";     
                            } 

                    }
            });
    }	
	
    function change_assigned_packer(id,val){
    $("#order_status_"+id).hide();
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>product/change_assigned_packer/",
                    data: {id:id, value:val},
                    success: function (result) {
                            if(result!=''){
                                    alert('Packer Changed Successfully'); 
                              window.location.href="<?php echo base_url().'reports/packaging_and_ship_out_order_report'; ?>";     
                            } 

                    }
            });
    }

function validateSrch(){
	$("#searchStr").removeClass('error');
	var val = $("#searchStr").val();
 	if(val.trim()==''){
		$("#searchStr").addClass('error');
		return false;
	}
}	
function assignProduct(){
	 $('#save_value').click(function(){
    var arr = $('.ads_Checkbox:checked').map(function(){
        return this.value;
    }).get();
}); 
}


function delete_attr(id){  if (confirm("Sure to Delete SKU") == true) {
       window.location.href="<?php echo base_url();?>product/delete_attribute/"+id;
    } else {
        return false;
    }
}
</script>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

            </a>

        </div><!-- /.main-container -->



     

