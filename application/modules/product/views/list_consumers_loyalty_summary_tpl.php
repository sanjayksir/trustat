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

                        <a href="#">Loyalty Mgmt</a>

                    </li>

                    <li class="active">Consumer Loyalty Mgmt</li>

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
								<th><span class="blue bolder">Total Numer of consumers</span></th>
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
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
														<th>S No.</th>
													   <th>Consumer Name</th>
														<th>Phone Number</th>
														<th>Total Earned Points</th>
														<th>Total Redeemed Points</th>
														<th>Balance Points</th>
														
                                                       <th>Consumer Passbook & Feedback Report data </th>

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
                                <td><?php echo $attr['mobile_no']; ?></td>
                                <td><?php //echo base_url(); 
								
								if(base_url()=='http://localhost/trackingportal/') {
								mysql_connect("localhost", "root", "");
								mysql_select_db("trackingportaldb");
								} else {
									mysql_connect("localhost", "tpdbuser", "india@123");
								mysql_select_db("trackingprortaldb");
								}
								
								$some_q = "SELECT SUM(points) AS `points` FROM consumer_passbook where consumer_id = '".$attr['id']."' AND transaction_lr_type = 'Loyalty'";

					$results = mysql_query($some_q) or die(mysql_error());

					while($row = mysql_fetch_array($results)){
			$TE_Points = $row['points'];
							
							echo $TE_Points;
							
							}


								?></td>
                           <td><?php $some_q = "SELECT SUM(points) AS `points` FROM consumer_passbook where consumer_id = '".$attr['id']."' AND transaction_lr_type = 'Redemption'";

					$results = mysql_query($some_q) or die(mysql_error());

					while($row = mysql_fetch_array($results)){
			$TR_Points = $row['points'];
			echo $TR_Points;
			
							} ?></td>
                                                 <td><?php 
												$TBalance_Points = $TE_Points - $TR_Points;
												 
												 echo $TBalance_Points; ?></td>
                                                 
                                                 
													<td><?php echo anchor("product/list_view_consumer_passbook/".$attr['id'], '<i class="ace-icon fa fa-eye bigger-130"> View Passbook</i>', array('class' => 'btn btn-xs btn-info','title'=>' View Passbook')); ?>  
													<?php echo anchor("product/list_view_consumer_feedback_details/".$attr['id'], '<i class="ace-icon fa fa-eye bigger-130"> Feedback Report data</i>', array('class' => 'btn btn-xs btn-info','title'=>' Feedback Report data')); ?>
													<br />
												
												
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

                            <span class="blue bolder">Tracking Portal</span>

                            <?=date('Y');?>

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



     

