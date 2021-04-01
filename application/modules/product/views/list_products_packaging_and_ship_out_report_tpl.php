<?php $this->load->view('../includes/admin_header'); ?>
<!-- Export to Excel -->
<script src="<?php echo base_url(); ?>assets/export_to_excel/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/tableExport.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/jquery.base64.js"></script>
<!-- /Export to Excel -->

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

                    <li class="active">Packaging Report</li>

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
                <h5 class="widget-title bigger lighter">Packaging Report <label><a href="#" onclick="$('#dynamic-table').tableExport({type:'excel',escape:'false'});" style="color:white"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label></h5>
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
														<th>Packaging ID</th>
														<th>Packaging DateTime</th>
														<th>Packaging Order ID</th>
														<th>Packaging Order DateTime</th>
														<th>Unique Token ID</th>
														<th>Delivery Chalan Number</th>
													    <th>Company ID</th>
														<th>Packaging Supervisor ID</th>
														<th>Packaging Supervisor Name</th>
														<th>Packer ID</th>
														<th>Packer Name</th>														
														<th>Assigned by</th>
														<th>Assign Date Time</th>
														<th>Product Origin Type</th>
														<th>Product ID</th>
														<th>Product Name</th>
														<th>Token ID</th>
														<th>Product Code</th>
														<th>Bin Number</th>
														<th>Microsite URL</th>
														<th>Microsite User IP Address</th>
														<th>Microsite User Latitude</th>
														<th>Microsite User Longitude</th>
														<th>Microsite User City</th>
														<th>Microsite User Pin Code</th>

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
								<td><?php echo $attr['poso_id']; ?></td>
								<td><?php echo $attr['poso_date_time']; ?></td>
								<td><?php echo $attr['psoo_id']; ?></td>
								<td><?php echo $attr['poso_date_time']; ?></td>
								<td><?php echo $attr['poso_token_id']; ?></td>
								<td><?php echo $attr['poso_invoice_number']; ?></td>
							    <td><?php echo $attr['customer_id']; ?></td>
								<td><?php echo $attr['tracek_user_id']; ?></td>
								<td><?php echo $attr['tracek_user_name']; ?></td>
								<td><?php echo $attr['tracek_packer_id']; ?></td>
							    <td><?php echo $attr['tracek_packer_name']; ?></td>
								<td><?php echo $attr['tracek_packer_assigned_byid']; ?></td>
								<td><?php echo $attr['tracek_packer_assigned_datetime']; ?></td>
								<td><?php echo $attr['poso_product_origin_type']; ?></td>
								<td><?php echo $attr['product_id']; ?></td>
								<td><?php echo $attr['product_name']; ?></td>
								<td><?php echo $attr['poso_token_id']; ?></td>
								<td><?php echo $attr['poso_product_code']; ?></td>
							    <td><?php echo $attr['poso_bin_number']; ?></td>
								<td><?php echo $attr['poso_microsite_url']; ?></td>
							    <td><?php echo $attr['poso_ip_address']; ?></td>
								<td><?php echo $attr['poso_latitude']; ?></td>
								<td><?php echo $attr['poso_longitude']; ?></td>
								<td><?php echo $attr['poso_city']; ?></td>
							    <td><?php echo $attr['poso_pin_code']; ?></td>
                               
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



     

