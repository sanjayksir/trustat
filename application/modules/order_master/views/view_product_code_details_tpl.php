<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'View Barcode History Details';?>

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
                                                                        <h5 class="widget-title bigger lighter">Grid <?php echo $label;?>, for the Barcode  - <b><?php echo $this->uri->segment(4);?></b>, Product Name - <b><?php echo get_products_name_by_id($detailData['product_id']);?></b></h5>
                                                                    </div>
									<div class="widget-body">
									
									
									
									<div class="form-group row" style="margin-top:10px; margin-left:2px;">
										<div class="col-sm-4">
										<label for="form-field-8"><b>Product SKU</b></label> : <?php echo get_product_sku_by_id($detailData['product_id']);?>
										</div>
										<div class="col-sm-4">
										  <label for="form-field-8"><b>Barcode</b> </label> : <?php echo $detailData['barcode_qr_code_no'];?>
										</div>
										<div class="col-sm-4">
										  <label for="form-field-8"><b>Level</b> </label> : <?php echo $detailData['pack_level'];?>
										</div>
										<div class="col-sm-12">
										<label for="form-field-8"><b>Product Description</b></label> : <?php echo get_product_product_description_by_id($detailData['product_id']);?>
										</div>
									</div>
									<div class="form-group row">
										
										
									</div>
									
									
									
																			<!--
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
                                                                                            <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Transaction Type, Location Type, Location Name, Date and Time, User Name">
                                                                                            <span class="input-group-btn">
                                                                                                <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                                                                <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
																			-->
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>S.No.</th>
														<th>Date and Time</th>
                                                        <th>Activity</th>
														<th>Location Type</th>
														<th>Location Name</th>
														<th>User Name</th> 
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
											   <td><?php echo $sno;$sno++; ?></td>
												<td><?php 
												
												//$Tdate = "STR_TO_DATE(".$listData['transaction_datetime'].", '%d/%m/%Y %H:%i:%s')";
												//echo date_format($date, 'g:ia \o\n l jS F Y');
												#output: 5:45pm on Saturday 24th March 2012
												//https://code.tutsplus.com/tutorials/working-with-date-and-time-in-php--cms-31768
												
												echo(date('j M Y H:i:s D', strtotime($listData['transaction_datetime'])));
									           //echo(date('d-m-Y H:i:s', strtotime($listData['transaction_datetime'])));
												?></td>
												<td><?php echo $listData['trax_name']; ?></td>
												<td><?php echo get_locations_type_by_id($listData['location_id']); ?></td>
												<td><?php echo get_locations_name_by_id($listData['location_id']); ?></td>
												
												<td><?php echo getUserFullNameById($listData['agent_customer_id']); ?></td>
                                              </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
                                       
                                    </tbody>
                                        </table>
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