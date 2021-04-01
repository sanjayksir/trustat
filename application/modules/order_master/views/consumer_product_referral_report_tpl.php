<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>

	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Consumer Product Referral Report';?>

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
						<div class="alert alert-block alert-success" style='display:none;'>
                                                    <button type="button" class="close" data-dismiss="alert">
                                                            <i class="ace-icon fa fa-times"></i>
                                                    </button>
                                                    <i class="ace-icon fa fa-check green"></i>Successfully!!
						 </div>
                      
                      
   						<div class="row">
							<div class="col-xs-12">
 								<div class="widget-box widget-color-blue">
                                                                    <div class="widget-header widget-header-flat">
                                                                        <h5 class="widget-title bigger lighter">List <?php echo $label;?></h5> <?php //echo get_customer_id_by_promotion_id(1); ?>
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
																						<label><a href="#" onclick="$('#missing_people').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label>
                                                                                    
                                                                                    </div>
                                                                                    <div class="col-sm-6">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Referal Reference ID, Referal Intiated by Consumer ID, Referal Intiated by Consumer Mobile Number">
                                                                                            <span class="input-group-btn">
                                                                                                <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                                                                <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
										<div style="overflow-x:auto;">
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th style="text-align:center">#</th>
														<th style="text-align:center">Date of Referal Initiation</th>
														<th style="text-align:center">Referal Reference ID</th>
														<th style="text-align:center">Referal Intiated by Consumer ID</th>
														<th style="text-align:center">Referal Intiated by Consumer Name</th>
 														<th style="text-align:center">Referal Intiated by Consumer Mobile Number</th>
														<th style="text-align:center">Mobile Numbers of Consumer referred</th>
														<th style="text-align:center">Registration status of the referred Consumer with TRUSTAT when referred</th>
														<th style="text-align:center">Registration status of the referred Consumer with Customer when referred</th>
														<th style="text-align:center">Current status of the referred Consumer with TRUSTAT</th>
														<th style="text-align:center">Current status of the referred Consumer with Customer</th>
														<th style="text-align:center">Gap Period(Days) finalised by Brand from last activity of existing consumer for the product</th>
														<th style="text-align:center">Actual Gap Period(Days) of referred consumer</th>
														<th style="text-align:center">Existing Consumer entitled to Loyalty rewards for the reference of the product</th>
														<th style="text-align:center">Loyalty rewards given to consumer (Receiver) under refferal</th>
														<th style="text-align:center">Loyalty rewards given to consumer (sender) under refferal</th>
														<th style="text-align:center">Promotion details</th>
														<th style="text-align:center">Media Type</th>
														<th style="text-align:center">Feedback response</th>
														<th style="text-align:center">Customer Name</th>
														<th style="text-align:center">Customer ID</th>														
														<th style="text-align:center">Product Name</th>
														<th style="text-align:center">Product ID</th>
														<th style="text-align:center">Product SKU</th>
														<th style="text-align:center">Product Code</th>
 														<th style="text-align:center">Location-latitude/longitude</th>
														<th style="text-align:center">Location-City</th>
														<th style="text-align:center">Location-PIN</th>
  													</tr>
												</thead>
												<tbody>

                                        <?php $i = 0;  //  echo '***<pre>';print_r($orderListing);
										if(count($ScanedCodeListing)>0){
											$i=0;
                                        $page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
									$sno =  $page + 1;
                                        foreach ($ScanedCodeListing as $key=>$listData){
											$i++;
											?>
                                               <tr id="show<?php echo $key; ?>">
						<td style="text-align:center"><div style="word-wrap:break-word; width:20px;"><?php echo $sno;$sno++; ?></td>
			<td style="text-align:center"><div style="word-wrap:break-word; width:200px;"><?php echo (date('j M Y H:i:s D', strtotime($listData['referring_datetime']))); ?></div>	</th>
												<td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo $listData['referral_reference_id']; ?></div>	</th>
												<td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo $listData['referrer_consumer_id']; ?></div>	</th>
												<td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo get_consumer_name_by_consumer_id($listData['referrer_consumer_id']); ?></div>	</th>
												<td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo getConsumerMobileNumberById($listData['referrer_consumer_id']); ?></div>	</th>
												<td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo $listData['referred_mobile_no']; ?></div>	</th>
 												  <td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php echo $listData['rs_referred_consumer_TRUSTAT']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php echo $listData['rs_referred_consumer_customer']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php if($listData['referred_consumer_id']==0){ echo "Not Registered With TRUSTAT"; }else{ echo "Already Registered With TRUSTAT"; } ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php $Consumer_Linked_Customer = Check_If_Consumer_Linked_Customer($listData['referred_consumer_id'], get_customer_id_by_product_id($listData['product_id'])); if($Consumer_Linked_Customer==true){ echo "Consumer Linked Customer"; }else{ echo "Consumer Not Linked Customer"; } ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:300px;"><?php echo getGapPeriodfinalisedbyBrandByProductId($listData['product_id']); ?></div>	</th>
												<td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php $LastActivityDate = getLastActivityDateByConsumerID($listData['referrer_consumer_id']); $Days = new DateTime($LastActivityDate); echo $Days->format('d'); ?></div>	</th>
											<td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php echo getProductinReferralProgramAssignedbyBrandByProductId($listData['product_id']); ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:220px;"><?php echo $listData['referred_consumer_id']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:220px;"><?php echo getLoyaltyrewardstosenderconsumerunderReferralAssignedbyBrandByProductId($listData['product_id']); ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php echo $listData['promotion_details']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php echo $listData['media_type']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo Check_If_referred_Promotion_Feedback_Given_byConsumer($listData['referred_consumer_id'], $listData['product_id']); ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo getUserFullNameById(get_customer_id_by_product_id($listData['product_id'])); ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo get_customer_id_by_product_id($listData['product_id']); ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo get_products_name_by_id($listData['product_id']); ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php echo $listData['product_id']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo get_product_sku_by_id($listData['product_id']); ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo $listData['product_code_or_promotion_id']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:250px;"><?php echo $listData['geol_latitude']; ?>, <?php echo $listData['geol_longitude']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo $listData['geol_city']; ?></div>	</th>
												 <td style="text-align:center"><div style="word-wrap:break-word; width:150px;"><?php echo $listData['geol_pin_code']; ?></div>	</th>
                                              </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
                                       
                                    </tbody>
                                        </table>
										 </div>
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

			 <div class="modal-container"></div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
		
<?php $this->load->view('../includes/admin_footer');?>
<!---------- modal popup dynaimic---------->
<script type="text/javascript">
	//$(document).ready(function(){
		function print_order(val){
		var url = "<?php echo base_url().'order_master/barcode/view_detail/';?>"+val;
		//jQuery('#modellink').click(function(e) {
		    $('.modal-container').load(url,function(result){
				$('#printMyModal').modal({show:true});
			});
		//});
		}
	//});
</script>
<!---------- modal popup dynaimic---------->
<script>

function validateSrch(){
	$("#searchStr").removeClass('error');
	var val = $("#searchStr").val();
 	if(val.trim()==''){
		$("#searchStr").addClass('error');
		return false;
	}
}

/*function print_option(id){
	var qrrystr;
	qrrystr='generate_order/';
	if($("#print_order_"+id).val()==1){
		qrrystr='generate_order_barcode/';
	}
	var url = qrrystr+btoa(id);
	window.location.href=url;
}
*/
function change_order_status(id,val){
$("#order_status_"+id).hide();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>order_master/change_order_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(result!=''){
						alert('Status Changed Successfully');
						if(parseInt(val)==1){ 
							$("#order_status_"+id).show();
						}
					} 
					
				}
			});
}		
function change_status(id,val){order_status_
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>order_master/change_status/",
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
 
 
       
 
</script>

<script>$(function () {
     var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
//initializing datepicker
$('.datepicker').datepicker({format:'yyyy-mm-dd', startDate: today,minDate: new Date()  });
 });
 
  

 $("form#frm").validate({
 		rules: {
  			"product[]":{required: true},
 		    quantity: {required: true,number: true}
        		} ,
  		 
 		messages: {
			"product[]": {required: "Please enter Product Name/SKU Code" } , 
			quantity: {	required: "Please enter quantity"} 
		},
 		submitHandler: function(form) {
  			var dataSend;
 			var dataSend 	= $("#frm").serialize();
  			$.ajax({
 				type: "POST",
 				dataType:"json",
 				beforeSend: function(){
				$('.alert-success').hide();
 						//$(".show_loader").show();
  						//$(".show_loader").click();
 				},
 				url: "<?php echo base_url(); ?>order_master/save_order/",
 				data: dataSend,
 				success: function (msg) {
					
 					if(parseInt(msg)==1){
					$('#myModal').modal('hide');
 						//$('#ajax_msg').text("User Added Successfully!").css("color","green").show();
 						$('.alert-success').show();
 						$('#frm')[0].reset(); 
						window.location="<?php echo base_url(); ?>order_master/list_orders/";
 						 					
 					}
 				}

			});

			 return false;

 		}

	});
 
 
 
 
 </script>
 <?php if($this->uri->segment(3)=='open'){?>
 <script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
<?php }?>
 
<?php $this->load->view('../includes/admin_footer');?>