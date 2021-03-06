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

                        <a href="#">Master</a>

                    </li>

                    <li class="active">Consumer Passbook for <?php echo getOrganizationNameById($this->session->userdata('admin_user_id')); ?></li>

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
	
               <b> Consumer Photo : </b><a href="<?php echo base_url().lcfirst(getConsumerProfileImageById($this->uri->segment(3))); ?>" onclick="window.open (this.href, 'child', 'height=800,width=900'); return false"><img alt="" src="<?php echo base_url(). lcfirst(getConsumerProfileImageById($this->uri->segment(3))); ?>" height="50" width="50"></a>
			   <br />
				<b> Consumer Name : </b><?php echo getConsumerNameById($this->uri->segment(3));?><?php //echo lcfirst(getConsumerProfileImageById($this->uri->segment(3))); ?><br />
				  <b>Consumer Phone : </b><?php echo getConsumerMobileNumberById($this->uri->segment(3));?>

                 <div class="row">

                    <div class="col-xs-12">

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
                                            </label><label><a href="#" onclick="$('#List_Consumer_Passbook').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="showDescription" style="width:369px !important;" placeholder="Event Name, Transaction Type">
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
                        <table id="List_Consumer_Passbook" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S No.</th>
                                    <th class="hidden-480">Transaction Date</th>
                                    <th class="hidden-480">Event Name</th>
                                    <th class="hidden-480">Event Detail</th>
									<th class="hidden-480">Customer Loyalty Type</th>
                                    
									<th>Company Name</th>
                                    <th>Transaction</th>
									<th>Redemption Thru</th>
									<th>Redemption - Order/Invoice ID</th>
									<th>Redemption - Gross Cart/Invoice Value</th>									
									<th>Opening Balance</th>
									<th>Points </th>
									<th>Closing Balance</th>
									
									
									<!--<th>Total accumulated points</th>
								    <th>Total redeemed points</th>
								    <th>Current balance</th>
									<th>Points redeemable</th>
									<th>Points short of redemption</th>
                                    <th>Balance Available for Redemption</th>
									Points req. for next Redemption-->
                                </tr>
                            </thead>
                            <tbody>
									  
                        <?php
						//echo $list_all_consumers; 
                        if(count($list_view_consumer_passbook)>0){
                            $page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
                            $sno =  $page + 1;
                        $i=0;
                        foreach ($list_view_consumer_passbook as $attr){
                        $i++;
                         ?>
                                <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $attr['transaction_date']; ?></td>
                                <td><?php echo $attr['transaction_type_name']; ?></td>
                                <td><?php //echo $attr['params'];
						//echo json_decode($attr['params']);
							$character = json_decode($attr['params']);		
							//if($character->transaction_date!=''){echo $character->transaction_date . ".";}	
							if($character->passbook_title!=''){echo  $character->passbook_title . ", ";}	
							if($character->consumer_phone!=''){echo  $character->consumer_phone;}
	if(getConsumerNameById($character->consumer_id)!='') {echo ", " . getConsumerNameById($character->consumer_id);}
	
							//if($character->brand_name!=''){echo  $character->brand_name;}
							//if($character->product_name!=''){echo ", " . $character->product_name;}
							
							if($character->product_id!=''){echo  get_products_brand_name_by_id($character->product_id);}
							if($character->product_id!=''){echo ", " . get_products_name_by_id($character->product_id);}
							
							if($character->points_redeemed!=''){echo $character->points_redeemed;}
							if($character->coupon_number!=''){echo ", " . $character->coupon_number;}
							
							
								?></td>
								<td><?php echo $attr['customer_loyalty_type']; ?></td>
                                
								 <td><?php echo getUserFullNameById($attr['customer_id']); ?></td>
                                  <td><?php echo $attr['transaction_lr_type']; ?></td>
								  <td><?php $transaction_type_slug = $attr['transaction_type_slug'];
											if($transaction_type_slug=='loyalty_redemption_microsite'){
												echo "Online through microtime ".$character->Microsite_URL;
											}

								  ?></td>
								   <td><?php echo $attr['order_id']; ?><?php echo $attr['invoice_number']; ?></td>
								  <td><?php echo $attr['subtotals']; ?></td>								 
								 
								    <td><?php echo $attr['current_balance']-$attr['points']; ?></td>
									 <td><?php if($attr['transaction_lr_type']=="Loyalty"){ echo "+"; }else{ echo "-"; } ?><?php echo $attr['points']; ?></td>
									 <td><?php echo $attr['current_balance']; ?></td>
									 
									 <!--<td><?php echo $attr['points_short_of_redumption']; ?></td>
									  <td>--<?php //echo $attr['total_accumulated_points']; ?></td>
								   <td>--<?php //echo $attr['total_redeemed_points']; ?></td>-->
                                                 
													<!--<td><input type="checkbox" name="assignConsumer[]" class="assignConsumer" /></td>-->

                                             </tr>

                                        <?php
                                        $sno++;
                                        } 
										}else{?>
											<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
										  <!--<tr id="show<?php echo $attr['id']; ?>"><td colspan="8"><input class="btn btn-primary pull-right" type="button" id="assign" name="assign" value="Assign Product" /></td></tr>-->

                                    </tbody>
                                </table>
								</div> 
								<?php   echo anchor("product/list_consumers_loyalty_summary/", '<i class="ace-icon fa fa-list bigger-130"> Back to List</i>', array('class' => 'btn btn-xs btn-info','title'=>'Back'));  ?>
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



     

