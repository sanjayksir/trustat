<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                    try{ace.settings.loadState('main-container')}catch(e){}
            </script>
            <?php $label = 'Tracek Reports';?>

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
                                 Manage <?php echo $label; ?>
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
							 <div class="alert alert-block alert-success2" style='display:none;'>
                                                    <button type="button" class="close" data-dismiss="alert">
                                                            <i class="ace-icon fa fa-times"></i>
                                                    </button>
                                                    <i class="ace-icon fa fa-check green"></i>Report Created Successfully!2
                             </div>
                            <div class="row">
                                    <div class="col-xs-12">
                                        <div class="widget-box widget-color-blue">
                                            <div class="widget-header widget-header-flat">
                                                <h5 class="widget-title bigger lighter">List Tracek Reports</h5>
                                                <div class="widget-toolbar">
                                                   <!--<a href="<?php echo base_url('order_master/list_orders_plant_controlllers_CC') ?>" class="btn btn-xs btn-warning" title="List Plant Controllers Orders">List Plant Controllers Orders </a>-->
												<?php   $user_id 	= $this->session->userdata('admin_user_id');

												  if($user_id==1){  ?>
                                                   <!-- <a href="javascript:void(0);" class="btn btn-xs btn-warning" title="Make Order" data-toggle="modal" data-target="#myModal">Make Order</a>-->
													<a href="javascript:void(0);" class="btn btn-xs btn-warning" title="Add a Tracek Report for <?php echo getUserFullNameById($this->uri->segment(3)); ?>" data-toggle="modal" data-target="#myUploadModal">Add a Tracek Report for <?php echo getUserFullNameById($this->uri->segment(3)); ?></a>
												  <?php   }  ?>
                                                </div>
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
                                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Customer Code or Product Name">
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
                                                                <th>#<?php //echo $this->uri->segment(3); ?></th>
                                                                <th>Report Name<?php //echo date("Y-m-d H:i:s A"); ?></th>			
																<!--<th>Auto Email</th>		-->								
																<th>View Report</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                        <?php 
                                        $i = 0; 

                                        if(count($orderListing)>0){
											if($this->session->userdata('admin_user_id')==1){
												$page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
											}else{
												$page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
											}
                                            $sno =  $page + 1;
                                            foreach ($orderListing as $listData){
                                                $essentialAttributeArr = array();
                                                $essentialAttributeArr = getEssentialAttributes($listData['product_id']);
                                                // echo '***<pre>';print_r($essentialAttributeArr);
                                                $i++;
                                                $status = $listData['active_status'];
												if($status ==1){
                                                $status ='Active';
                                                        $colorStyle="style='color:white;border-radius:10px;background-color:green;border:none;'";
                                                }else{
                                                $status ='Inactive';
                                                        $colorStyle="style='color:black;border-radius:10px;background-color:red;border:none;'";
                                                }?>
												<tr>
                                                   <td><?php  echo $sno;$sno++; ?></td>
                                                   <td><?php  echo $listData['report_name']; ?></td>
												  <!-- <td><?php  $user_id 	= $this->session->userdata('admin_user_id');
													if($user_id==1){
														$print_opt = 1;
												   ?>
												   <select name="report_auto_email_status" id="report_auto_email_status" onchange="return change_report_auto_email_status('<?php echo $listData['ltrc_id'];?>',this.value,'<?php echo $print_opt;?>');">
                                              <option value="Continue" <?php if($listData['report_auto_email_status']=='Continue'){echo 'selected';}?>>Continue</option>
                                               <option value="Stop" <?php if($listData['report_auto_email_status']=='Stop'){echo 'selected';}?>>Stop</option>
                                          </select> 
												   
														<?php   }else{ echo $listData['report_auto_email_status']; } ?>
												   </td>-->
												   <td><?php // echo $listData['report_auto_email_status']; ?>
												   
												   <?php
													if($user_id==1){
												   ?>
								  <select name="report_view_status" id="report_view_status" onchange="return change_report_view_status('<?php echo $listData['ltrc_id'];?>',this.value,'<?php echo $print_opt;?>');">
                                                                <option value="Continue" <?php if($listData['report_view_status']=='Continue'){echo 'selected';}?>>Continue</option>
                                                                <option value="Stop" <?php if($listData['report_view_status']=='Stop'){echo 'selected';}?>>Stop</option>
                                                          </select> 
														 <?php   }else{  
														 if($listData['report_view_status']=='Continue'){
									echo anchor($listData['report_site_url'], ' <i class="ace-icon fa fa-eye bigger-130"> View Report</i> ', array('class' => 'btn btn-xs btn-info','title'=>'View Report')); //echo $listData['report_site_url'];
								
														 }else{
															 echo "Stop";
															 
														 }

														 } ?>
												   </td>
                                                 
                                                       

        </td>
          
     </tr>
    <?php 
    }
 }else{
    ?>
    <tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
<?php         
 }
 ?>

                </tbody>
            </table>
           <div class="row paging-box">
            <?php echo $links ?>
            </div>                                                      
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
</div>
<!-- /.main-container -->
<!-- myModal Div -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Make Order</h4>
            </div>
            <div class="modal-body">
<?php 
//$datecodedno = date('YmdHis');
//$date = date('Y-m-d H:i:s');
//echo $datecodedno;

?>
<form name="frm" id="frm" action="#" method="POST">
<!--<input name="menu_id" id="menu_id" type="hidden" value="">-->
<input name="order_no" id="order_no" type="hidden" value="<?php $datecodedno; ?>">
<div class="form-group row">
<div class="col-sm-12">
<label for="form-field-8">Plant Name</label>
<select class="form-control" name="plant_id" id="plant_id" onchange="return get_products(this.value);">
<option value="">-Select Plant-</option>
<?php 
$user_id 	= $this->session->userdata('admin_user_id');
$plant_data = get_all_active_plants($user_id);
foreach($plant_data as $res){?>
<option value="<?php echo $res['plant_id'];?>" <?php if($this->uri->segment(3)==$res['plant_id']){echo 'selected';}?>><?php echo $res['plant_name'];?></option>
<?php }?>
</select>
<br />
<label for="form-field-8">SKU/Product Name</label>
<select class="form-control" name="product[]" id="product" >

</select>			
<?php if(!empty($this->uri->segment(3))){?>
<script>get_products(<?php echo $this->uri->segment(3);?>);</script>
<?php }?>						


<script>
function get_products(id){
if(id!=''){
$.ajax({
type:'POST',
url:'<?php echo base_url().'plant_master/getAssignedProductList'?>',
data:{id:id, customer_id:<?php echo $this->uri->segment(3); ?>},
success:function(msg){
$("#product").html(msg);
}
})
}
}
</script>


                                  </div>
                                  </div>


                                  <div class="form-group row">
                                  <div class="col-sm-12">
                                  <label for="form-field-8">Quantity</label>
								  <select name="quantity" id="quantity" class="form-control">
										<option value="10">10</option>	
										<option value="20">20</option>
										<option value="50">50</option>
										<option value="100">100</option>
										<option value="1000">1,000</option>
										<option value="10000">10,000</option>
										<option value="100000">1,00,000</option>
										<option value="1000000">10,00,000</option>
									</select>
					
                                  <!--<input name="quantity" id="quantity" type="text" class="form-control" placeholder="Quantity" >-->
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
                                  <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />
                                  </div></div></div>

                          </form>
            </div>
          </div>
    </div>
  </div>
<!--/ myModal Div -->  
  

<!-- myUploadModal Div -->
<div id="myUploadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Add a Tracek Report for <?php echo getUserFullNameById($this->uri->segment(3)); ?></h4>
            </div>
            <div class="modal-body">
<?php 
//$datecodedno = date('YmdHis');
//$date = date('Y-m-d H:i:s');
//echo $datecodedno;

?>
<?php $customer_id 	= $this->uri->segment(3); ?>
<?php //$isTracekReportAddedForCustomer = ; ?>
<form name="frmup" id="frmup" action="#" method="POST">

<!--<input name="menu_id" id="menu_id" type="hidden" value="">-->
<input name="customer_id" id="customer_id" type="hidden" value="<?php echo $customer_id; ?>">
<div class="form-group row">
<div class="col-sm-12">
<label for="form-field-8">Select a Report</label>
<select class="form-control" name="trm_id" id="trm_id">
<option value="">-Report Name-</option>
<option value="" hidden>- Hide This -</option>
<?php 
//$user_id 	= $this->uri->segment(3);
$all_tracek_reports = get_all_tracek_report_master($customer_id);
foreach($all_tracek_reports as $atrs){?>
<option value="<?php echo $atrs['trm_id'];?>" <?php if(isTracekReportAddedForCustomer($atrs['trm_id'], $customer_id)==true){ echo "hidden"; } ?>><?php echo $atrs['report_name']; ?></option>
<!--
<input name="trm_id" id="trm_id" type="hidden" value="<?php echo $atrs['trm_id'];?>">
<input name="tracek_report_slug" id="tracek_report_slug" type="hidden" value="<?php echo $atrs['tracek_report_slug'];?>">
<input name="report_site_url" id="report_site_url" type="hidden" value="<?php echo $atrs['report_site_url'];?>">-->

<?php }?>
</select>
<br />
<label for="form-field-8">Auto Email</label>
	<select name="report_auto_email_status" id="report_auto_email_status" class="form-control" >
                                                  <option value="Stop">Stop</option>
                                                  <option value="Continue">Continue</option>
                                        </select>			



                                  </div>
                                  </div>
								<div class="form-group row">
                                  <div class="col-sm-12">
                                  <label for="form-field-8">Customer Viewing</label> 
										<select name="report_view_status" id="report_view_status" class="form-control" >
                                                  <option value="Stop">Stop</option>
                                                  <option value="Continue">Continue</option>
                                           </select>
                                  </div>
                                  </div>

                                 
                                  <div class="form-group row">
                                  <div class="col-sm-12">
                                  <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
                                  <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />
                                  </div></div></div>

                          </form>
            </div>
          </div>
    </div>
  </div>
<!--/ myUploadModal Div --> 

  
  
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
    function change_report_view_status(id,val){
    $("#order_status_"+id).hide();
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>order_master/change_report_view_status/",
                    data: {id:id, value:val},
                    success: function (result) {
                            if(result!=''){
                                    alert('Status Changed Successfully');
                                   
                            } 

                    }
            });
    }	
	
    function change_report_auto_email_status(id,val){
    $("#order_status_"+id).hide();
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>order_master/change_report_auto_email_status/",
                    data: {id:id, value:val},
                    success: function (result) {
                            if(result!=''){
                                    alert('Status Changed Successfully');
                                   
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

    <?php if($this->uri->segment(3)=='open'){?>
    <script type="text/javascript">
    $(window).on('load',function(){
    $('#myModal').modal('show');
    });
    </script>
<?php }?>


    <script>$(function () {
		
		var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    //initializing datepicker
    $('.datepicker').datepicker({format:'yyyy-mm-dd', startDate: today,minDate: new Date()  });
    });
    
    $("form#frmup").validate({
    rules: {
			trm_id: {required: true},
			customer_id: {required: true},			
			report_view_status: {required: true},
			report_auto_email_status: {required: true}
            },

    messages: {
			trm_id: {	required: "Please Select a Report"},  
			customer_id: {	required: "Please Select a Report"},  			
			report_view_status: {	required: "Please provide the upload code"},
			report_auto_email_status: {	required: "Please provide the upload code"}
    },
	
    submitHandler: function(form) {
            var dataSend;
            var dataSend 	= $("#frmup").serialize();
            $.ajax({
                    type: "POST",
                    dataType:"json",
                    beforeSend: function(){
                    $('.alert-success').hide();
                                    $(".show_loader").show();
                                    $(".show_loader").click();
                    },
         url: "<?php echo base_url(); ?>order_master/save_tracek_report_customer/",
         data: dataSend,
         success: function (msg) {			
			if(parseInt(msg)==true){
                    $('#myUploadModal').modal('hide');
                  $('#ajax_msg').text("Report created Successfully!").css("color","green").show();
                    $('.alert-success').show();
                    $('#frmup')[0].reset(); 
                    window.location="<?php echo base_url(); ?>order_master/list_tracek_reports/<?php echo $this->uri->segment(3); ?>";        }
                    }
            });
			
				alert("Report Created!!.");
				window.location.href = "<?php echo base_url(); ?>order_master/list_tracek_reports/<?php echo $this->uri->segment(3); ?>";
            // return false; 
    }
    });


function confirmDelete(val='')
{
	if(val!=''){
		var x = confirm("Are you sure you want to delete?");
		 if (x){
		 		window.location.href="<?php echo base_url().'order_master/delete_customer_code/';?>"+val;
 			  //return true;
		 }
		 else{
			return false;
		 }
	}
}

function change_customer_code_status(id,val){

	if (confirm('Sure to change the status?')) { 
		 // do things if OK
		$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>order_master/change_customer_code_status/",
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
	return false;
	
}


    </script>

<?php if($this->uri->segment(3)=='upload_codes'){?>
    <script type="text/javascript">
    $(window).on('load',function(){
    $('#myUploadModal').modal('show');
    });
    </script>
<?php }?>

 
<?php $this->load->view('../includes/admin_footer');?>