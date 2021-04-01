<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
<!-- Export to Excel -->
<script src="<?php echo base_url(); ?>assets/export_to_excel/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/tableExport.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/jquery.base64.js"></script>
<!-- /Export to Excel -->

	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Unpacked Inventory in hand Download';?>

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
                                                                        <h5 class="widget-title bigger lighter">List <?php echo $label;?></h5>
																		 <div class="widget-toolbar">
                                                    <?php echo anchor('reports/unpacked_inventory_in_hand', ' Back ',array('class' => 'btn btn-xs btn-warning')); ?>
																	</div>
                                                                    </div>
									<div class="widget-body"><div class="row filter-box">
                                    <form id="form-filter" action="" method="get" class="form-horizontal" >
                                        <div class="col-sm-2">
                                            <label style='display:none;'>
			<?php $mnv58_result = $this->db->select('message_notification_value')->from('message_notification_master')->where('id', 58)->get()->row();
								$mnvtext58 = $mnv58_result->message_notification_value; ?>								
											Display
                                                <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
				<option value="<?php echo $mnvtext58; ?>"><?php echo $mnvtext58; ?></option>								
                                                <?php //echo Utils::selectOptions('pagelimit2',['options'=>$this->config->item('pageOption2'),'value'=>$this->config->item('pageLimit2')]) ?>
                                                </select>
                                            Records
                                            </label>
						
					<!--<label><a href="#" onclick="$('#List_Consumer').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label>-->
                                        </div>
								<?php $Datetoday = date("m/d/Y"); ?>
								<?php $dateoneMAgo = date("m/d/Y",strtotime("-1 month")); ?>	
			<label style="margin:10px">Select “From Date” and “To Date” to download data relating to the selected period and press “Select dates & Press Here” button. Please note that maximum number of line items in any one excel sheet is limited to [<?php echo $mnvtext58; ?>] records and if line items for data exceed [<?php echo $mnvtext58; ?>], it is automatically split between two or more files.</label><br /><br />					
								<div class="col-sm-2" style="margin-left:20px">  From Date(mm/dd/yyyy) : <br /><br /> To Date(mm/dd/yyyy) :<br /><br />  </div>					
                                        <div class="col-sm-6">
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
                                               <!-- <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Customer Name, Customer ID">-->
                                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-inverse btn-white" onclick="DateCheck();" style="background-color: rgb(48, 126, 204) !important; color: white !important; margin:10px"><span class="ace-icon icon-on-right bigger-110"></span>Select Dates & Press Here</button>
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
					  <div class="row paging-box">
                                        <?php 
										if($total_records2==0){ ?>
										<div class="col-sm-4"><span class="counter">
										<?php echo " No Records found</span></div>";  
										}else{
										if($links2==''){ ?>
										<div class="col-sm-4"><span class="counter">
										<?php echo "  Total ".$total_records2 . " records ready to download</span></div>";  }else{ echo $links2; }} ?>
                                   </div> 
								   
				
											<div align="center"><br />
											<div font="40px">Select from the page above and click on Excel icon below to download that page file.</div>
					<br />
											<label><a href="#" onclick="$('#List_Consumer').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/download_excel.png" width="100px" style="margin-left:40px"></a></label>
											</div>				   
					  <div style="height: 1px; overflow: hidden;">
                        <table id="List_Consumer" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>#</th>
														
														<th>Location Name</th>
														<th>Product Name</th>
														<th>Product SKU</th>												
														<th>Packaging Level</th>
														<th>Quantity</th> 														
                                                        <th>List details</th> 
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
											  
											   <td><?php echo get_locations_name_by_id($listData['plant_id']); ?></td>
											   <td><?php echo $listData['product_name']; ?></td>
											   <td><?php echo $listData['product_sku']; ?></td>	
																								   
											   <td>Level <?php echo $listData['pack_level']; ?></td>
											   <!--<td><a href="<?php //echo "overall_global_inventory_opening_details/".$listData['product_id']."/".$listData['pack_level']; ?>" /><?php //echo $listData['pack_level']; ?></a></td>-->
												
												<td><?php echo count_product_unpacked_inventory($listData['product_id'], $listData['pack_level']); ?></td>
												
						<td><?php echo anchor("reports/unpacked_inventory_in_hand_list_codes/".$listData['product_id']."/".$listData['pack_level'], '<i class="ace-icon fa fa-eye bigger-130"> View Codes List</i>', array('class' => 'btn btn-xs btn-info','title'=>'View Codes List'));  ?></td>
                                              </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="15" class="color error">No Records Founds</td></tr>
										<?php }?>
                                       
                                    </tbody>
                                        </table>
										</div> 
                                     <!--   <div class="row paging-box">
                                        <?php //echo $links ?>
                                        </div>  -->                                  
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