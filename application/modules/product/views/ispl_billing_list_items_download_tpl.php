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

                    <li class="active">ISPL Billing Report</li>

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
                                <h5 class="widget-title bigger lighter">Download ISPL Billing Report <?php if($this->session->userdata('admin_user_id')==1){ echo "for " . getUserFullNameById($this->uri->segment(3)); }?> <?php //echo getLastActivityDateByConsumerID(11, 6); ?>
								<div class="widget-toolbar">
                                        <?php echo anchor('product/ispl_billing_list_items/'.$this->uri->segment(3), ' Back ',array('class' => 'btn btn-xs btn-warning')); ?>
								</div>
								</h5>
                            </div>
                            <div class="widget-body">
                                <div class="row filter-box">
                                    <form id="form-filter" action="" method="get" class="form-horizontal" >
                                        <div class="col-sm-5">
                                            <label style="display:none">
			 <?php $mnv58_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 58)->get()->row();
		$mnvtext58 = $mnv58_result->message_notification_value; ?>Display
                                                <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
					<option value="<?php echo $mnvtext58; ?>"><?php echo $mnvtext58; ?></option>           
											   <?php //echo Utils::selectOptions('pagelimit',['options'=>$this->config->item('pageOption'),'value'=>$this->config->item('pageLimit')]) ?>
                                                </select>
                                            Records
                                            </label>
                                        </div>
							<?php $Datetoday = date("m/d/Y"); ?>
					<?php $dateoneMAgo = date("m/d/Y",strtotime("-1 year")); ?>
<label style="margin:10px">Select ???From Date??? and ???To Date??? to download data relating to the selected period and press ???Select dates & Press Here??? button. Please note that maximum number of line items in any one excel sheet is limited to [<?php echo $mnvtext58; ?>] records and if line items for data exceed [<?php echo $mnvtext58; ?>], it is automatically split between two or more files.</label><br /><br />						
				<div class="col-sm-2" style="margin-left:20px" align="center">  From Date(mm/dd/yyyy) : <br /><br />To Date(mm/dd/yyyy) :<br /><br />  </div>
                                        <div class="col-sm-8" align="center">
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
								<!--  <input type="hidden" name="c_date_data" id="c_date_data" value="<?php echo date('m/d/Y'); ?>" class="form-control" />	
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Product Name,Product SKU">-->
                                                <span class="input-group-btn">
                        <button type="submit" class="btn btn-inverse btn-white" onclick="DateCheck();" style="background-color: rgb(48, 126, 204) !important; color: white !important; margin:10px"><span class="ace-icon icon-on-right bigger-110"></span>Select Dates & Press Here</button>
                                                    <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                </span>
                                            </div>
											
                                        </div>
                                    </form>
                                
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
		<div class="col-sm-12">														
						<div class="row paging-box">
                                        <?php 
										if($total_records2==0){ ?>
										<div class="col-sm-4"><span class="counter">
										<?php echo " No Records found</span></div>";  
										}else{
										if($links2==''){ ?>
										<div class="col-sm-4"><span class="counter">
										<?php echo "  Total ".$total_records2 . " records ready to download</span></div>";  }else{ echo $links2; }} ?>
                                        </div> <br />	
					<div align="center">
					<div font="40px">Select from the page above and click on Excel icon below to download that page file.</div>
					<br />																
																						<div align="center">
																						<label><a href="#" onclick="$('#List_Consumer').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/download_excel.png" width="100px" style="margin-left:40px"></a></label>
																						</div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
										
									</div>
							
                      <!--------------- Search Tab start----------------->
					  <div style="height: 1px; overflow: hidden;">
                        <table id="List_Consumer" class="table table-striped table-bordered table-hover" style="display: block;">
                           <thead>
                                <tr>
                                    <th>#</th>
									<th class="hidden-480">Transaction Date & Time</th>
                                    <th class="hidden-480">Customer ID</th>
                                    <th class="hidden-480">Billing Particular Name</th>
									<th class="hidden-480">Quantity</th>
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
                                <tr id="show<?php echo $attr['cbb_id'];?>">
                                <td><?php echo $sno; ?></td>
								<td><?php echo(date('j M Y H:i:s D', strtotime($attr['trans_date_time'])));  ?></td>
                                <td><?php echo $attr['customer_id']; ?></td>
				<td><?php echo $attr['billing_particular_name']; ?></td>
                 <td><div style="width:10px;"><?php echo $attr['trans_quantity']; ?></td>
		
					
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
                           <!-- <div class="row paging-box">
                            <?php //echo $links ?>
                            </div>   --> 
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



     

