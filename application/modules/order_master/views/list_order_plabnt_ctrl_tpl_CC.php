<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Order';?>

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
 									<i class="ace-icon fa fa-check green"></i>Order Placed Successfully!!
						 </div>
                      
                      
   						<div class="row">
							<div class="col-xs-12">
 								<div class="row">
									<div class="col-xs-12">
										<h3 class="header smaller lighter blue">List <?php echo $label;?></h3>
 										<!------------------------- Add Order model popup Start--------------------------->
										<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Make Order</button>
 											<!-- Modal -->
											<div id="myModal" class="modal fade" role="dialog">
											  <div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
												  <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Make Order</h4>
												  </div>
												  <div class="modal-body">
														<form name="frm" id="frm" action="#" method="POST">
															<!--<input name="menu_id" id="menu_id" type="hidden" value="">-->
 															<div class="form-group row">
															<div class="col-sm-12">
															<label for="form-field-8">Product Name/SKU</label>
															<?php 
															$user_id 		= $this->session->userdata('admin_user_id');
															$parentId 		= getParentIdFromUserId();
															if($parentId==0 || $parentId==1){
																$product_list = get_all_products_sku($user_id);
																//echo '-1111-';
																//echo '<pre>';print_r($product_list);
															}else{
																$product_list 	= get_all_products_sku_plant_ctrl($user_id);
																//$product_list 	= get_products_name_by_id(explode(',',$plant_list));
																//echo '-222-';
																//echo '<pre>';print_r($product_list);
															}
															?>
															<select name="product[]" id="product" class="form-control" Multiple>
 															<?php if(count($product_list)>0){
																		foreach($product_list as $product){?>
																		<option  value="<?php echo $product['id'];?>"><?php echo $product['product_name'];?></option>
															
															<?php 		}
																	}else{?><option value="0">-No Product-</option>
															<?php }?>
															</select>
															</div>
															</div>
															
															
															<div class="form-group row">
															<div class="col-sm-12">
															<label for="form-field-8">Quantity</label>
															<input name="quantity" id="quantity" type="text" class="form-control" placeholder="Quantity" >
															</div>
															</div>
															
															
															<div class="form-group row">
															<div class="col-sm-12">
															<label for="form-field-8">Expected Date</label>
															<div class="input-group date" data-provide="datepicker">
															<input type="text" name="deliverydate" id="deliverrydate" readonly="readonly" class="form-control">
															<div class="input-group-addon">
															<span class="glyphicon glyphicon-th"></span>
															</div>
															</div>
															</div>
															</div>
															
															<div class="form-group row">
															<div class="col-sm-12">
															<div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
															<input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
															</div></div></div>
															
														</form>
 												  </div>
												</div>
											  </div>
											</div>
 										<!------------------------- Add Order model popup end--------------------------->
										<!--------------- Search Tab start----------------->
                            <div class="row"><form id="form-filter" action="" method="post" class="form-horizontal" onsubmit="return validateSrch();">
                                <table id="search" class="table table-hover display">
                                    
                                        <tbody>
                                        	<tr>
                                            	<td><input name="search" value="<?php if(!empty($this->input->post('search'))){echo $this->input->post('search');}?>" id="searchStr" placeholder="Search Records" class="form-control" type="text"></td>
                                            	<td>
                                                	<input type="submit" id="btn-filter" value="Search" name="Search" class="btn btn-primary btn-search">&nbsp;
                                                	<button type="button" id="btn-reset" class="btn btn-default btn-search">Reset</button>
                                            	</td>
                                         	</tr>
                                 		 </tbody>
                                   	
                                 </table></form>
                            </div>
                      <!--------------- Search Tab start----------------->
										<!-- div.table-responsive -->
 										<!-- div.dataTables_borderWrap -->
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>#</th>
														
														<th>Tracking Number</th>
 														<th>Product Code</th>
 														<th>Product Name</th>
														<th>Qty</th>
														<th>Delivery Date</th>
                                                        <th>Order Date</th>
                                                        <th>Status</th>
														<th>Print</th>
  														<th>Action</th>
  													</tr>
												</thead>
												<tbody>

                                        <?php $i = 0; // echo '***';print_r($orderListing);
										if(count($orderListing)>0){
                                        foreach ($orderListing as $listData){
										$i++;
											$essentialAttributeArr = array();
											$essentialAttributeArr = getEssentialAttributes($listData['product_id']);// echo '***<pre>';print_r($essentialAttributeArr);
											$status = $listData['status'];
                                            if($status ==1){
											$status ='Active';
 												$colorStyle="style='color:white;border-radius:10px;background-color:green;border:none;'";
											}else{
											$status ='Inactive';
												$colorStyle="style='color:black;border-radius:10px;background-color:red;border:none;'";
											}?>
                                               <tr id="show<?php echo $listData['order_id']; ?>">
											   <td><?php echo $i; ?></td>
											   <td><?php echo $listData['order_tracking_number']; ?></td>
												<td><?php echo $listData['product_sku']; ?></td>
												<td><?php echo $listData['product_name']; ?></td>
												<td><?php echo $listData['quantity']; ?></td>
												<td><?php  if($listData['delivery_date']!='0000-00-00'){echo date('d/M/Y',strtotime($listData['delivery_date']));}else{echo '';}; ?></td>
												<td><?php  if($listData['created_date']!='0000-00-00'){echo date('d/M/Y',strtotime($listData['created_date']));}else{echo '';}; ?></td>
												<?php if($this->session->userdata('admin_user_id')==1){?>
                                               
												 <td><select name="change_order_status" id="change_order_status" onchange="return change_order_status('<?php echo $listData['order_id'];?>',this.value);">
 													<option value="0" <?php if($listData['order_status']==0){echo 'selected';}?>>Pending</option>
													<option value="1" <?php if($listData['order_status']==1){echo 'selected';}?>>Success</option>
													<option value="2" <?php if($listData['order_status']==2){echo 'selected';}?>>Rejected</option>
													</select>
												</td> 
												<?php }else{?>
												 <td><?php echo order_status($listData['order_status']); ?></td>
												<?php }?>
												<td>
                                                <!--<a class="btn btn-primary pull-right modellink" data-toggle="modal" href="#printMyModal" id="" onclick="return print_order('<?php echo $listData['order_id'];?>');">Print</a>-->
												<?php
												$get_parent_id 	= get_parent_id($user_id);
												$lable='';
												$lable1='';
												$lable2='';
												$display		= "none;";
												 if($essentialAttributeArr['delivery_method']==3 && $listData['order_status']=='1'){
												 	$display	= "block;";
												 }
												// echo var_dump($listData['order_status']);
												 
												if($essentialAttributeArr['delivery_method']==2 ){
													$lable = 'Print By CCC-Admin';
												}
												if($essentialAttributeArr['delivery_method']==1){
													$lable='Print By Admin';
												} 
												
												if($essentialAttributeArr['delivery_method']==3){
													$lable='Print By Plant Cont.';
												}
												if($essentialAttributeArr['delivery_method']==4){
													$lable='E-Mode Print';
												}
												//echo '**'.$listData['order_status'].'@@@'.$essentialAttributeArr['delivery_method'];
												?>
                                                <span id="order_status_<?php echo $listData['order_id'];?>" style="display:<?php echo $display;?>"> 
												
												<a class="btn btn-primary pull-right modellink" data-toggle="modal" href="#printMyModal" id="" onclick="return print_order('<?php echo $listData['order_id'];?>');"><i style="cursor:pointer" title="print Order" class="fa fa-print icon-2x"></i></a>
												
												</span>
                                                 <?php echo $lable;?>
                                                
                                                </td>
                                                  <td>
                                                     <div class="hidden-sm hidden-xs action-buttons">
                                                         <a href="<?php  echo base_url().'order_master/view_order/'.$listData['order_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"><i class="fa fa-eye"></i></a>
														
												 
                                                         <?php echo anchor("order_master/edit_product/" . $listData['order_id'], '<i class="ace-icon fa fa-pencil"></i>', array('class' => 'btn btn-xs btn-info','title'=>'Edit')); ?>
                                                        <!-- <input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $listData['order_id'];?>" value="<?php echo $status ;?>" onclick="return change_status('<?php echo $listData['order_id'];?>',this.value);" />-->

                                                    </div>

                                                </td>
                                             </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
                                        <tr><td align="right" colspan="10" class="color"><?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?></td></tr>
                                    </tbody>
											</table>
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
		var url = "<?php echo base_url().'order_master/print_box/';?>"+val;
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
						window.location="<?php echo base_url(); ?>order_master/list_orders_plant_controlllers/";
 						 					
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