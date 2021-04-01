<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>

<div class="main-container ace-save-state" id="main-container"> 
  <script type="text/javascript">

				try{ace.settings.loadState('main-container')}catch(e){}

			</script>
  <?php $this->load->view('../includes/admin_sidebar');?>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo site_url(); ?>">Home</a> </li>
          <?php if($this->uri->segment(2)=='edit_user'){

								  	$constant = "Edit Admin" ;

                              }else{ // $this->load->view('add_member_right_tpl'); 
							  $constant = "Edit Order" ;

					 			}?>
          <li class="active"><?php echo $constant;?></li>
        </ul>
        
     <?php //echo '<pre>';print_r($product_data);exit;?>
      </div>
      <div class="page-content">
        <div class="row">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <h3 class="header smaller lighter blue"><?php echo $constant;?></h3>
                <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-block alert-success">
                  <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>
                  <i class="ace-icon fa fa-check green"></i> <span id="msgSucc"></span><?php echo $this->session->flashdata('success'); ?> </div>
                <?php endif; ?>
                
                <!--<div class="table-header">

											Results for "Locations"

										</div>--><br>
                <div class="row">
                  <div class="col-xs-12"> 
                    
                    <!--left end---->
                    
                    <div class="col-xs-12">
					<div class="alert alert-block alert-success" style='display:none;'>
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
 									<i class="ace-icon fa fa-check green"></i>Order Placed Successfully!!
						 </div>
                      <div class="tab-pane fade active in">
                        <?php //$this->load->view('add_menu_form_tpl');?>
						<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>order_master/list_orders" class="btn btn-primary pull-right" title="Back to List Orders">Back to List Orders</a></div>
                        <div class="row">
                          <div class="col-xs-12">
                            <div class="row" id="add_edit_div">
                              <div class="col-xs-12">
                                <div class="widget-box">
                                  <div class="widget-header">
                                    <h4 class="widget-title">Edit Order </h4>
                                    <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
                                  </div>
                                  <div class="widget-body">
                                    <div id="ajax_msg"></div>
                                  </div>
                                  <div>
                                    <div > 
                                      <!-- Modal content-->
                                      <div>
                                        <div class="modal-body">
                                          <form name="frm" id="frm" action="#" method="POST">
                                             <input name="order_id" id="order_id" type="hidden" value="<?php echo $product_data['order_id'];?>">
                                            <div class="form-group row">
                                              <div class="col-sm-12">
                                                <label for="form-field-8">Product Name/SKU <font color="orange"> - The product Name/SKU cannot be changed.</font><?php //echo $product_data['order_id'];?></label>
                                                <?php 
															$user_id 		= $this->session->userdata('admin_user_id');
															$parentId 		= getParentIdFromUserId();
															if($parentId==0 || $parentId==1){
																$product_list = get_all_products_sku($user_id);
																//echo '-1111-';
																//echo '<pre>';print_r($product_list);
															}else{
																$plant_list 	= list_assigned_plants_of_plant_ctrl($user_id);
																$product_list = get_all_products_sku_plant_ctrl($user_id); //echo '<pre>';print_r($product_list);
																//$product_list 	= get_products_name_by_id(explode(',',$product_list));
																//echo '-222-';
																
															}
															?>
                                                <select name="product[]" id="product" class="form-control" Multiple>
                                                  <?php if(count($product_list)>0){
																		foreach($product_list as $product){?>
                                                  <option value="<?php echo $product['id'];?>" <?php if($product['id']==$product_data['product_id']){echo 'selected';}?>><?php echo $product['product_name'];?></option>
                                                  <?php 		}
																	}else{?>
                                                  <option value="0">-No Product-</option>
                                                  <?php }?>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="form-group row">
                                              <div class="col-sm-12">
                                                <label for="form-field-8">Quantity</label>
												<select name="quantity" id="quantity" class="form-control">
												<option value="<?php echo $product_data['quantity'];?>"><?php echo $product_data['quantity'];?></option>
													<option value="10">10</option>	
													<option value="20">20</option>
													<option value="50">50</option>
													<option value="100">100</option>
													<option value="1000">1,000</option>
													<option value="10000">10,000</option>
													<option value="100000">1,00,000</option>
													<option value="1000000">10,00,000</option>
												</select>
												
												
                                                <!--<input name="quantity" id="quantity" type="text" value="<?php echo $product_data['quantity'];?>" class="form-control" placeholder="Quantity" >-->
                                              </div>
                                            </div>
                                            <div class="form-group row">
                                              <div class="col-sm-12">
                                                <label for="form-field-8">Expected Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                  <input type="text" name="deliverydate" id="deliverrydate" value="<?php echo date('d/m/Y',strtotime($product_data['delivery_date']));?>" readonly="readonly" class="form-control">
                                                  <div class="input-group-addon"> <span class="glyphicon glyphicon-th"></span> </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group row">
                                              <div class="col-sm-12">
                                                <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
                                                  <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />
                                                </div>
                                              </div>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- div.table-responsive --> 
                
                <!-- div.dataTables_borderWrap --> 
                
              </div>
            </div>
            
            <!-- PAGE CONTENT ENDS --> 
            
          </div>
          
          <!-- /.col --> 
          
        </div>
        
        <!-- /.row --> 
        
      </div>
      
      <!-- /.page-content --> 
      
    </div>
  </div>
  <div class="footer">
    <div class="footer-inner">
      <div class="footer-content"> &nbsp; &nbsp; <span class="action-buttons"> <a href="#"> <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i> </a> <a href="#"> <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i> </a> <a href="#"> <i class="ace-icon fa fa-rss-square orange bigger-150"></i> </a> </span> </div>
    </div>
  </div>
  
  <!-- /.main-content --> 
  
</div>

<!-- /.main-container -->

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog"> <span id="edit_popup_model"> </span> 
    
    <!-- Modal content-->
    
    <div class="modal-content"></div>
  </div>
</div>
<div class="modal fade" id="addModal" role="dialog">
  <div class="modal-dialog"> <span id="add_modal_popup"> </span> 
    
    <!-- Modal content-->
    
    <div class="modal-content"></div>
  </div>
</div>
<script>
 	$(document).ready(function() {

		// Data table options setting

	    $('table.display').DataTable(

	    	{

	    		'bPaginate' : false, 

	    		'paging'    : false,

	    		'sDom'		: "lfrti",

	    		'info'		: false,

	    	}

	    );



	    // Fix data-table width 100%

	    $('table').css('width', '100%');



	    $("#submit_country").click(function(event) { });



		$("#submit_state").click(function(event) { });



		// Add City Data

		$("#submit_city").click(function(event) { });



		// Add Area Data

		$("#submit_area").click(function(event) { });



	});
 	$(function () {
		var nowDate = new Date();
		var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
		//initializing datepicker
		$('.datepicker').datepicker({format:'yyyy-mm-dd', startDate: today,minDate: new Date()  });
	});
	
   	$(document).ready(function() {
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
						//$('.alert-success').hide();
							//$(".show_loader").show();
							//$(".show_loader").click();
					},
					url: "<?php echo base_url(); ?>order_master/save_order/",
					data: dataSend,
					success: function (msg) {
						if(parseInt(msg)==1){ 
						$('.alert-success').show();
							setTimeout(function() { window.location="<?php echo base_url(); ?>order_master/list_orders/";},2000);
						}
 					}
 			});
 			 return false;
  		}
 	});
	});
  </script>

 </script>
<?php $this->load->view('../includes/admin_footer');?>
