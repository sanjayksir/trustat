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

                        <a href="#">Dashboard</a>

                    </li>

                    <li class="active">Consumer Brand Loyalty Dashboard</li>

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
                        <div class="widget-box widget-color-blue">
                            <div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">Consumer Brand Loyalty Dashboard</h5>
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
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Customer Name">
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
													   <th>Brand Name<?php echo $list_all_consumers->customer_id; ?></th>
													   <th>No. of times Post Purchase Scan Report</th>
														<th>No. of times Pre Purchase Scan Report</th>
														<th>Feedback Given pushed Advertisement</th>
														<th>Feedback Given pushed Surveys</th>
                                                       

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
						
						$user_id = $this->session->userdata('admin_user_id');
						$customer_id = $this->uri->segment(3);
							
                         ?>
                                <tr id="show<?php echo $attr['id'];?>" <?php if (!empty($customer_id)) { if($attr['customer_id']!=$customer_id) {  ?> style="display:none;" <?php } } ?>>
                                <td><?php echo $sno; ?></td>
                                <td><?php echo getUserFullNameById($attr['customer_id']); ?></td>
								<td><?php //echo base_url(); 								
								include('url_base_con_db2.php');
								
					$some_q = "SELECT SUM(points) AS `points` FROM consumer_passbook where customer_id = '".$attr['customer_id']."' AND transaction_type_slug = 'product_registration_lps'";

							$results = mysql_query($some_q) or die(mysql_error());

							while($row = mysql_fetch_array($results)){
							$TE_Points = $row['points'];
							
							echo $TE_Points;							
							}
								?></td>
								<td><?php 
					$some_q2 = "SELECT SUM(points) AS `points` FROM consumer_passbook where customer_id = '".$attr['customer_id']."' AND transaction_type_slug = 'product_video_response_lps' OR transaction_type_slug = 'product_audio_response_lps' OR transaction_type_slug = 'product_image_response_lps' OR transaction_type_slug = 'product_pdf_response_lps'";

							$results2 = mysql_query($some_q2) or die(mysql_error());

							while($row2 = mysql_fetch_array($results2)){
							$TE_Points2 = $row2['points'];
							
							echo $TE_Points2;							
							}
								?></td>
								
								<td><?php 
					$some_q3 = "SELECT SUM(points) AS `points` FROM consumer_passbook where customer_id = '".$attr['customer_id']."' AND transaction_type_slug = 'product_ad_video_response_lps' OR transaction_type_slug = 'product_ad_audio_response_lps' OR transaction_type_slug = 'product_ad_image_response_lps' OR transaction_type_slug = 'product_ad_pdf_response_lps'";

							$results3 = mysql_query($some_q3) or die(mysql_error());

							while($row3 = mysql_fetch_array($results3)){
							$TE_Points3 = $row3['points'];
							
							echo $TE_Points3;							
							}
								?></td>
								<td><?php 
				$some_q4 = "SELECT SUM(points) AS `points` FROM consumer_passbook where customer_id = '".$attr['customer_id']."' AND transaction_type_slug = 'product_survey_video_response_lps' OR transaction_type_slug = 'product_survey_audio_response_lps' OR transaction_type_slug = 'product_survey_image_response_lps' OR transaction_type_slug = 'product_survey_pdf_response_lps'";

							$results4 = mysql_query($some_q4) or die(mysql_error());

							while($row4 = mysql_fetch_array($results4)){
							$TE_Points4 = $row4['points'];
							
							echo $TE_Points4;							
							}
								?></td>
                           
													
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
						<span class="blue bolder">Copyright ??</span>
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



     

