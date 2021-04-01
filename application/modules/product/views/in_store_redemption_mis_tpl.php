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

                        <a href="#">Master</a>

                    </li>

                    <li class="active">In-Store Redemption MIS Report</li>

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

                    <div class="col-xs-12">

                        <div class="widget-box widget-color-blue">
                            <div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">In-Store Redemption MIS Report <?php if($this->session->userdata('admin_user_id')==1){ echo "for " . getUserFullNameById($this->uri->segment(3)); }?> 
								<div class="widget-toolbar">
								<?php if($this->session->userdata('admin_user_id')==1){
					echo anchor('product/in_store_redemption_mis_download/'.$this->uri->segment(3), 'Go to download report',array('class' => 'btn btn-xs btn-warning')); 
								}else{
								echo anchor('product/in_store_redemption_mis_download', 'Go to download report',array('class' => 'btn btn-xs btn-warning')); } ?>
													
																	</div>
								
								</h5>
								
                            </div>
							
                            <div class="widget-body">
                                <div class="row filter-box">
                                    <form id="form-filter" action="" method="get" class="form-horizontal" >
                                        <div class="col-sm-5">
                                            <label>Display
                                                <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
                                                <?php echo Utils::selectOptions('pagelimit',['options'=>$this->config->item('pageOption'),'value'=>$this->config->item('pageLimit')]) ?>
                                                </select>
                                            Records
                                            </label>
											<!--<label><a href="#" onclick="$('#List_Consumer').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label>-->
                                        <?php $Datetoday = date("m/d/Y"); ?>
					<?php $dateoneMAgo = date("m/d/Y",strtotime("-1 month")); ?>	
					
										
										</div>
										<div class="col-sm-2">  Start Date(mm/dd/yyyy) : <br /><br />End Date(mm/dd/yyyy) :<br /><br />  </div>  
                                        <div class="col-sm-5">										
                                            <div class="input-group">
											<div class="input-group date" data-provide="datepicker">
                              <input type="text" name="from_date_data" id="from_date_data" readonly="readonly" value="<?php //echo $dateoneMAgo; ?>" class="form-control" />
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                        </div>
								  
								  <div class="input-group date" data-provide="datepicker">
                               <input type="text" name="to_date_data" id="to_date_data" readonly="readonly" value="<?php //echo $Datetoday; ?>" class="form-control" />
							      <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                                  </div>
								  <input type="hidden" name="c_date_data" id="c_date_data" value="<?php echo date('m/d/Y'); ?>" class="form-control" />	
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Customer Name, Customer ID">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-inverse btn-white" onclick="DateCheck();"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                    <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								<script type="text/javascript">											
								function DateCheck()
											{
											  var StartDate= document.getElementById('from_date_data').value;
											  var EndDate= document.getElementById('to_date_data').value;
											  var CurrentDate= document.getElementById('c_date_data').value;
											  var eDate = new Date(EndDate);
											  var sDate = new Date(StartDate);
											  var cDate = new Date(CurrentDate);
											  if(sDate> eDate || eDate> cDate)
												{
												alert("Please ensure that the End Date is greater than or equal to the Start Date. End Date is not greater than Current Date");
												return false;
												}
											}
											</script>

                      <!--------------- Search Tab start----------------->
					  <div style="overflow-x:auto;">
                        <table id="List_Consumer" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="hidden-480">Date & time</th>
									<th class="hidden-480">Customer Name</th>
									<th class="hidden-480">Customer ID</th>
									<th class="hidden-480">Tracek User Name</th>									
									<th class="hidden-480">Tracek User ID</th>
									<th class="hidden-480">Invoice Number</th>
                                    <th class="hidden-480">Invoice Amount</th>
                                    <th class="hidden-480">Consumer Name</th>
                                    <th class="hidden-480">Consumer ID</th>
                                    <th class="hidden-480">Opening Loyalty Balance</th>
                                    <th class="hidden-480">Loyalty Redemption Amount</th>
                                    <th class="hidden-480">Closing Loyalty Balance</th>
                                </tr>
                            </thead>
                            <tbody>
									  
                        <?php
                        if(count($product_list)>0){
						$user_id = $this->session->userdata('admin_user_id');
						$customer_id = $this->uri->segment(3);
					if($user_id>1){
					$page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
						}else{
					$page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
					}
							
                            
							
                            $sno =  $page + 1;
							$i=0;
                        foreach ($product_list as $attr){
                        $i++;
                         ?>
                                <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
<td><div style="word-wrap:break-word; width:220px;"><?php echo(date('j M Y H:i:s D', strtotime($attr['request_date'])));  ?></div></td>
<td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['f_name']; ?></div></td>
<td><div style="word-wrap:break-word; width:90px;"><?php echo $attr['brand_customer_id']; ?></div></td>
<td><div style="word-wrap:break-word; width:200px;"><?php echo getTracekUserFullNameById($attr['cashier_tracek_user_id']); ?></div></td>
<td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['cashier_tracek_user_id']; ?></div></td>
<td><div style="word-wrap:break-word; width:150px;"><?php echo $attr['invoice_number']; ?></div></td>
<td><div style="word-wrap:break-word; width:150px;"><?php echo $attr['invoice_value']; ?></div></td>						
<td><div style="word-wrap:break-word; width:150px;"><?php echo getConsumerNameById($attr['consumer_id']); ?></div></td>
<td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['consumer_id']; ?></div></td>
<td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['opening_loyalty_balance']; ?></div></td>
<td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['points_redeemed']; ?></div></td>
<td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['closing_loyalty_balance']; ?></div></td>
                                
                                             </tr>

                                        <?php
                                        $sno++;
                                        } 
										}else{?>
											<tr><td align="center" colspan="13" class="color error">
											<?php
											$user_id = $this->session->userdata('admin_user_id'); 
											$BrandLoyaltyRedemptionType = getBrandLoyaltyRedemptionTypeById($user_id);
											//echo $user_id;
                                       if($BrandLoyaltyRedemptionType=="Company Website"){
										   echo "No Records Founds";
										}else{
										 echo "In-Store Redemption Option not subscribed.";	
										}
										?>
											
											
											
											
											
											</td></tr>
										<?php }?>
										  <!--<tr id="show<?php echo $attr['id']; ?>"><td colspan="8"><input class="btn btn-primary pull-right" type="button" id="assign" name="assign" value="Assign Product" /></td></tr>-->

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



     

