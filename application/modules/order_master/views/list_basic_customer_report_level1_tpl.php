<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Basic Customer Report Level 1';?>

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
                                                                                            <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Bar-QR Code,Product Name or Consumer Name">
                                                                                            <span class="input-group-btn">
                                                                                                <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                                                                <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
										
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
												<tr>
														<th>	1	</th>
														<th>	2	</th>
														<th>	3	</th>
														<th>	4	</th>
														<th>	5	</th>
														<th>	6	</th>
														<th>	7	</th>
														<th>	8	</th>
														<th>	9	</th>
														<th>	10	</th>
														<th>	11	</th>
														<th>	12	</th>
														<th>	13	</th>
														<th>	14	</th>
														<th>	15	</th>
														<th>	16	</th>
														<th>	17	</th>
														<th>	18	</th>
														<th>	19	</th>
														<th>	20	</th>
														<th>	21	</th>
														<th>	22	</th>
														<th>	23	</th>
														<th>	24	</th>
														<th>	25	</th>
														<th>	26	</th>
														<th>	27	</th>
														<th>	28	</th>
														<th>	29	</th>
														<th>	30	</th>
														<th>	31	</th>
														<th>	32	</th>
														<th>	33	</th>
														<th>	34	</th>
														<th>	35	</th>
														<th>	36	</th>
														<th>	37	</th>
														<th>	38	</th>
														<th>	39	</th>
														<th>	40	</th>
														<th>	41	</th>
														<th>	42	</th>
														<th>	43	</th>
														<th>	44	</th>
														<th>	45	</th>
														<th>	46	</th>
														<th>	47	</th>
														<th>	48	</th>
														<th>	49	</th>
														<th>	50	</th>
														<th>	51	</th>
														<th>	52	</th>
														<th>	53	</th>
														<th>	54	</th>
														<th>	55	</th>
														<th>	56	</th>
														<th>	57	</th>
														<th>	58	</th>
														<th>	59	</th>
														<th>	60	</th>
														<th>	61	</th>
														<th>	62	</th>
														<th>	63	</th>
														<th>	64	</th>
														<th>	65	</th>
														<th>	66	</th>
														<th>	67	</th>
														<th>	68	</th>
														<th>	69	</th>
														<th>	70	</th>
														<th>	71	</th>
														<th>	72	</th>
														<th>	73	</th>
														<th>	74	</th>
														<th>	75	</th>
														<th>	76	</th>
  													</tr>
													<tr>
														<th>	S. No.	</th>
														<th>	Date and time of scan	</th>
														<th>	Customer Name 	</th>
														<th>	Customer ID	</th>
														<th>	Product Name	</th>
														<th>	Unique Product Code	</th>
														<th>	Geolocation of Scan of Level 1	</th>
														<th>	Consumer ID	</th>
														<th>	Last Retail Store Stock under TRACEK	</th>
														<th>	Scanned Product Batch Details	</th>
														<th>If Consumer bought the product scanned with same Product ID	</th>
														<th>	12	</th>
														<th>	13	</th>
														<th>	14	</th>
														<th>	15	</th>
														<th>	16	</th>
														<th>	17	</th>
														<th>	18	</th>
														<th>	19	</th>
														<th>	20	</th>
														<th>	21	</th>
														<th>	22	</th>
														<th>	23	</th>
														<th>	24	</th>
														<th>	25	</th>
														<th>	26	</th>
														<th>	27	</th>
														<th>	28	</th>
														<th>	29	</th>
														<th>	30	</th>
														<th>	31	</th>
														<th>	32	</th>
														<th>	33	</th>
														<th>	34	</th>
														<th>	35	</th>
														<th>	36	</th>
														<th>	37	</th>
														<th>	38	</th>
														<th>	39	</th>
														<th>	40	</th>
														<th>	41	</th>
														<th>	42	</th>
														<th>	43	</th>
														<th>	44	</th>
														<th>	45	</th>
														<th>	46	</th>
														<th>	47	</th>
														<th>	48	</th>
														<th>	49	</th>
														<th>	50	</th>
														<th>	51	</th>
														<th>	52	</th>
														<th>	53	</th>
														<th>	54	</th>
														<th>	55	</th>
														<th>	56	</th>
														<th>	57	</th>
														<th>	58	</th>
														<th>	59	</th>
														<th>	60	</th>
														<th>	61	</th>
														<th>	62	</th>
														<th>	63	</th>
														<th>	64	</th>
														<th>	65	</th>
														<th>	66	</th>
														<th>	67	</th>
														<th>	68	</th>
														<th>	69	</th>
														<th>	70	</th>
														<th>	71	</th>
														<th>	72	</th>
														<th>	73	</th>
														<th>	74	</th>
														<th>	75	</th>
														<th>	76	</th>
  													</tr>
													<tr>
													<th>	1	</th>
													<th>	2	</th>
													<th>	3	</th>
													<th>	4	</th>
													<th>	5	</th>
													<th>	6	</th>
													<th>	7	</th>
													<th>	8	</th>
													<th>	9	</th>
													<th>	10	</th>
													<th>	Yes/No	</th>
													<th>	Yes/No	</th>
													<th>	Date and Time of Buying	</th>
													<th>	Product ID bought & registered	</th>
													<th>	Yes/No	</th>
													<th>	Video played from Scan/History	</th>
													<th>	Complete/Incomplete	</th>
													<th>	Responded/Not Responded	</th>
													<th>	Response to Question No. 1	</th>
													<th>	Response to Question No. 2	</th>
													<th>	Response to Question No. 3	</th>
													<th>	Response to Question No. 4	</th>
													<th>	Loyalty Points Awarded	</th>
													<th>	Yes/No	</th>
													<th>	Audio played from Scan/History	</th>
													<th>	Complete/Incomplete	</th>
													<th>	Responded/Not Responded	</th>
													<th>	Response to Question No. 1	</th>
													<th>	Response to Question No. 2	</th>
													<th>	Response to Question No. 3	</th>
													<th>	Response to Question No. 4	</th>
													<th>	Loyalty Points Awarded	</th>
													<th>	Yes/No	</th>
													<th>	PDF played from Scan/History	</th>
													<th>	Complete/Incomplete	</th>
													<th>	Responded/Not Responded	</th>
													<th>	Response to Question No. 1	</th>
													<th>	Response to Question No. 2	</th>
													<th>	Response to Question No. 3	</th>
													<th>	Response to Question No. 4	</th>
													<th>	Loyalty Points Awarded	</th>

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
											   <td><?php echo $listData['bar_code']; ?></td>
												<td><?php echo $listData['product_name']; ?></td>
												<td><?php echo $listData['user_name']; ?></td>
												<td>
																								
												<?php echo $listData['latitude']. " / "; ?><?php echo $listData['longitude']; ?>
												</td>
												<td><?php echo (date('j M Y H:i:s D', strtotime($listData['created_at']))); ?></td>
 												 
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