<?php $this->load->view('../includes/admin_header'); ?>

<?php //echo '<pre>';print_r($product_list);exit;
$this->load->view('../includes/admin_top_navigation'); ?>
<!-- Export to Excel -->
<script src="<?php echo base_url(); ?>assets/export_to_excel/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/tableExport.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/jquery.base64.js"></script>
<!-- /Export to Excel -->
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

                        <a href="#">Loyalty Management</a>

                    </li>

                    <li class="active">Consumer Loyalty Management</li>

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
 			 <table class="table table-striped table-bordered table-hover">
                    <thead>
                           <tr>
								<th><span class="blue bolder">Total Numer of Customers</span></th>
								<th><span class="blue bolder">Total Earned Points</span></th>
								<th><span class="blue bolder">Total Points Redeemed</span></th>
								<th><span class="blue bolder">Total Balance points</span></th>
								<th><span class="blue bolder">Total Points to Redeem</span></th>
							</tr>
                     </thead>
                            <tbody>
								<tr>
									<td><?php echo $total_records; ?></td>
									<td><?php echo $Total_Earned_Points; ?></td>
									<td><?php echo $Total_Points_Redeemed; ?></td>
									<td><?php echo $Total_Earned_Points - $Total_Points_Redeemed; ?></td>
									<td><?php echo ($Total_Earned_Points - $Total_Points_Redeemed)- $minimum_locking_balance*$total_records; ?></td>
								</tr>
							</tbody>
			 </table>
							




                        <div class="widget-box widget-color-blue">
						
						
							
							
							
                            <!--<div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">MANAGE PRODUCTS</h5>
                                <div class="widget-toolbar">
                                    <a href="<?php //echo base_url('product/add_product') ?>" class="btn btn-xs btn-warning" title="Add Product">Add <?php echo $label; ?> </a>
                                </div>
                            </div>
							-->
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
		<label><a href="#" onclick="$('#dynamic-table').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label>
                                                                                   
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Consumer Name,Consumer Phone">
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
													    <th>Consumer Name</th>
														<th>Consumer ID</th>
														<th>Phone Number</th>
														<th>Total TLP Earned</th>
														<th>Total TLP Redeemed</th>
														<th>Total TLP Expired</th>
														<th>Total TLP O/S</th>
														<th>TLP Consumer Passbook</th>
														<th>Total BLP Earned</th>
														<th>Total BLP Redeemed</th>
														<th>Total BLP Expired</th>
														<th>Total BLP O/S</th>
														<th>BLP Consumer Passbook</th>

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
                                <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $attr['user_name']; ?></td>
								<td><?php echo $attr['id']; ?></td>
                                <td><?php echo $attr['mobile_no']; ?></td>
                                <td><?php //echo base_url(); 
								//echo "<br>"; 
								include('url_base_con_db2.php');
												
							//$character = json_decode($attr['params']);
							//$searchdata = $character->customer_loyalty_type;
							//echo $searchdata;
		$some_q = "SELECT SUM(points) AS `points` FROM loylty_points where user_id = '".$attr['id']."' AND customer_loyalty_type = 'TRUSTAT' AND loyalty_points_status = 'Earned'";
								$results = mysql_query($some_q) or die(mysql_error());
								while($row = mysql_fetch_array($results)){
								$TE_Points = $row['points'];							
								echo $TE_Points;
								//echo $query_getShows;								
								} ?>
								</td>
								<td><?php $some_q1 = "SELECT SUM(points) AS `points` FROM loylty_points where user_id = '".$attr['id']."'  AND customer_loyalty_type = 'TRUSTAT' AND loyalty_points_status = 'Redeemed'";
								$results1 = mysql_query($some_q1) or die(mysql_error());
								while($row1 = mysql_fetch_array($results1)){
								$TR_Points1 = $row1['points'];
								echo $TR_Points1;			
								} ?>
								</td>
								<td><?php $some_q2 = "SELECT SUM(points) AS `points` FROM loylty_points where user_id = '".$attr['id']."'  AND customer_loyalty_type = 'TRUSTAT' AND loyalty_points_status = 'Expired'";
								$results2 = mysql_query($some_q2) or die(mysql_error());
								while($row2 = mysql_fetch_array($results2)){
								$TR_Points2 = $row2['points'];
								echo $TR_Points2;			
								} ?>
								</td>
								<td><?php $TBalance_Points = $TE_Points - ($TR_Points1 + $TR_Points2);												 
												 echo $TBalance_Points; ?>
								</td>
								<td><?php echo anchor("product/list_view_consumer_passbook/".$attr['id'], '<i class="ace-icon fa fa-eye bigger-130"> View Passbook</i>', array('class' => 'btn btn-xs btn-info','title'=>' View Passbook')); ?>  
										<?php //echo anchor("product/list_view_consumer_feedback_details/".$attr['id'], '<i class="ace-icon fa fa-eye bigger-130"> Feedback Report data</i>', array('class' => 'btn btn-xs btn-info','title'=>' Feedback Report data')); ?>
										</td>
								 <td><?php //echo base_url(); 
								
								// MySQL connect info
															
								$some_q3 = "SELECT SUM(points) AS `points` FROM consumer_passbook where consumer_id = '".$attr['id']."' AND customer_loyalty_type = 'Brand' AND transaction_lr_type = 'Loyalty'";
								$results3 = mysql_query($some_q3) or die(mysql_error());
								while($row3 = mysql_fetch_array($results3)){
								$TE_PointsBLP3  = $row3['points'];							
								echo $TE_PointsBLP3 ;							
								} ?>
								</td>
								<td><?php $some_q4 = "SELECT SUM(points) AS `points` FROM consumer_passbook where consumer_id = '".$attr['id']."' AND customer_loyalty_type = 'Brand' AND transaction_lr_type = 'Redemption'";
								$results4 = mysql_query($some_q4) or die(mysql_error());
								while($row4 = mysql_fetch_array($results4)){
								$TR_PointsBLP4 = $row4['points'];
								echo $TR_PointsBLP4 ;			
								} ?>
								</td>
								<td><?php $some_q5 = "SELECT SUM(points) AS `points` FROM loylty_points where user_id = '".$attr['id']."' AND customer_loyalty_type = 'Brand' AND loyalty_points_status = 'Expired'";
								$results5 = mysql_query($some_q5) or die(mysql_error());
								while($row5 = mysql_fetch_array($results5)){
								$TR_PointsBLP5 = $row5['points'];
								echo $TR_PointsBLP5 ;			
								} ?>
								</td>
								<td><?php $TBalance_PointsBLP  = $TE_PointsBLP3  - ($TR_PointsBLP4 + $TR_PointsBLP5);											echo $TBalance_PointsBLP ; // Sanjay ?>
								</td> 
									
										<td><?php echo anchor("product/list_view_blp_consumer_passbook/".$attr['id'], '<i class="ace-icon fa fa-eye bigger-130"> View Passbook</i>', array('class' => 'btn btn-xs btn-info','title'=>' View Passbook')); ?>  
										<?php //echo anchor("product/list_view_consumer_feedback_details/".$attr['id'], '<i class="ace-icon fa fa-eye bigger-130"> Feedback Report data</i>', array('class' => 'btn btn-xs btn-info','title'=>' Feedback Report data')); ?>
										</td>
                                             </tr>

                                        <?php
                                        $sno++;
                                        } 
										}else{?>
											<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
										  <!--<tr id="show<?php //echo $attr['id']; ?>"><td colspan="8"><input class="btn btn-primary pull-right" type="button" id="assign" name="assign" value="Assign Product" /></td></tr>-->

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



     

