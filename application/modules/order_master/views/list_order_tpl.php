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
							 <div class="alert alert-block alert-success2" style='display:none;'>
                                                    <button type="button" class="close" data-dismiss="alert">
                                                            <i class="ace-icon fa fa-times"></i>
                                                    </button>
                                                    <i class="ace-icon fa fa-check green"></i>Codes Upoaded Successfully!2
                             </div>
                            <div class="row">
                                    <div class="col-xs-12">
                                        <div class="widget-box widget-color-blue">
                                            <div class="widget-header widget-header-flat">
                                                <h5 class="widget-title bigger lighter">List Order</h5>
                                                <div class="widget-toolbar">
                                                   <a href="<?php echo base_url('order_master/list_orders_plant_controlllers_CC') ?>" class="btn btn-xs btn-warning" title="List Plant Controllers Orders">List Plant Controllers Orders </a>
                                                    <a href="javascript:void(0);" class="btn btn-xs btn-warning" title="Make Order" data-toggle="modal" data-target="#myModal">Make Order</a>
													<a href="javascript:void(0);" class="btn btn-xs btn-warning" title="Upload Customer Codes" data-toggle="modal" data-target="#myUploadModal">Upload Customer Codes</a>
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
                                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Order Number or Product Name">
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
                                                                <th>#</th> 
																<th>Order Number</th>
																<th>Order Date</th>
                                                                <th>Order By</th>
                                                                <!--
                                                                <th>Tracking Number</th>
                                                                <th>Product SKU</th>-->
                                                                <th>Product Name</th>
                                                                <th>Ordered Qty</th>
                                                                <th>Delivery Date</th>
                                                                <th>Status</th>
                                                                <th>Print</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                        <?php 
                                        $i = 0; 

                                        if(count($orderListing)>0){
                                            $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
                                            $sno =  $page + 1;
                                            foreach ($orderListing as $listData){
                                                $essentialAttributeArr = array();
                                                $essentialAttributeArr = getEssentialAttributes($listData['product_id']);
                                                // echo '***<pre>';print_r($essentialAttributeArr);
                                                $i++;
                                                $status = $listData['status'];
    if($status ==1){
                                                $status ='Active';
                                                        $colorStyle="style='color:white;border-radius:10px;background-color:green;border:none;'";
                                                }else{
                                                $status ='Inactive';
                                                        $colorStyle="style='color:black;border-radius:10px;background-color:red;border:none;'";
                                                }?>
												  <tr id="show<?php echo $listData['order_id']; ?>">
                                                   <td><?php  echo $sno;$sno++; ?></td>
												    <td><?php  echo $listData['order_no']; ?></td>
												    <td><?php  if($listData['created_date']!='0000-00-00'){echo date('j M Y H:i:s D',strtotime($listData['created_date']));}else{echo '';}; ?></td>
													 <td><?php echo getUserFullNameById($listData['user_id']); ?></td>
                                                   <!--<td><?php  echo $listData['order_no']; ?>
                                                   <td><?php  echo $listData['order_tracking_number']; ?></td>
                                                        <td><?php echo $listData['product_sku']; ?></td>-->
                                                        <td><?php echo $listData['product_name']; ?></td>
                                                        <td><?php echo $listData['quantity']; ?></td>
                                                        <td><?php  if($listData['delivery_date']!='0000-00-00'){echo date('j M Y H:i:s D',strtotime($listData['delivery_date']));}else{echo '';}; ?></td>
                                                       
                                                        <?php if($this->session->userdata('admin_user_id')==1){
                                                                //echo $listData['user_id'].'**'.$this->session->userdata('admin_user_id');		

                                                                                if($this->session->userdata('admin_user_id')!=$listData['user_id']){
                                                                                        $print_opt = 0;
                                                                                }else{
                                                                                        $print_opt = 1;
                                                                                }

                                                                ?>

                                                         <td>
         <?php //if($essentialAttributeArr['delivery_method']==4){?>
                <select name="change_order_status" id="change_order_status" onchange="return change_order_status('<?php echo $listData['order_id'];?>',this.value,'<?php echo $print_opt;?>');">
                                                                <option value="0" <?php if($listData['order_status']=='0'){echo 'selected';}?>>Pending</option>
                                                                <option value="1" <?php if($listData['order_status']=='1'){echo 'selected';}?>>Accepted</option>
                                                                <option value="2" <?php if($listData['order_status']=='2'){echo 'selected';}?>>Rejected</option>
                                                                </select>
        <?php //}else{
                                                                //echo 'Hard Print';
                                                        //}?>
                                                        </td> 
                                                        <?php }else{?>
                                                         <td><?php echo order_status($listData['order_status']); ?></td>
                                                        <?php }?>
                                                        <td>
        <!--<a class="btn btn-primary pull-right modellink" data-toggle="modal" href="#printMyModal" id="" onclick="return print_order('<?php echo $listData['order_id'];?>');">Print</a>-->
                                                        <?php
                                                        $get_parent_id	= get_parent_id($user_id);
                                                        $lable='';
                                                        $lable1='';
                                                        $lable2='';
                                                        $display		= "none;";

                                                        //echo '***--'.$user_id.'***--'.$listData['user_id'].'***--'.$listData['order_status'].'***--'.$essentialAttributeArr['delivery_method'];
                                                        if($listData['order_status']==1){
                                                         if($user_id==1 && $essentialAttributeArr['delivery_method']==1){
                                                                $display	= "block;";
                                                         }else if($user_id>1 && $get_parent_id==1 && $essentialAttributeArr['delivery_method']==2){
                                                                $display	= "block;";
                                                         }else if($user_id>1 && $get_parent_id>1 && $essentialAttributeArr['delivery_method']==3){
                                                                $display	= "block;";
                                                         }
                                                        }else{
                                                                $display	= "none;";
                                                        }
                                                        /*if($listData['order_status']!=1 ){
                                                                $display	= "none;";
                                                        }
                                                        if($listData['order_status']==1){
                                                                $display	= "block;";
                                                        }*/

                                                        ###---------- show print option ------------------##


                                                        if( $essentialAttributeArr['delivery_method']==4){
                                                                $display	= "none;";
                                                        }
                                                        ###---------- show print option ------------------##

                                                        ##-----------------------------------##
                                                        if($user_id==1 && $essentialAttributeArr['delivery_method']==2 ){
                                                                $lable = 'Print By CCC Admin';
                                                        }
                                                        if($user_id==1 && $essentialAttributeArr['delivery_method']==3 ){
                                                                $lable = 'Print By CCC Admin';
                                                        }

                                                        if($user_id>1 && $get_parent_id==1  && $essentialAttributeArr['delivery_method']==1){
                                                                $lable='Print By Super Admin';
                                                        }
                                                        if($user_id>1 && $get_parent_id==1  && $essentialAttributeArr['delivery_method']==3){
                                                                $lable='Print By Plant Controller';
                                                        } 

                                                        if($user_id>1 && $get_parent_id>1 && $essentialAttributeArr['delivery_method']==1){
                                                                $lable='Print By Super Admin';
                                                        }
                                                        if($user_id>1 && $get_parent_id>1 && $essentialAttributeArr['delivery_method']==2){
                                                                $lable='Print By CCC Admin';
                                                        }

                                                        if($essentialAttributeArr['delivery_method']==4){
                                                                $lable='E-Mode Print';
                                                        }
                                                        ##-----------------------------------##

                                                        //echo '**'.$listData['order_status'].'@@@'.$essentialAttributeArr['delivery_method'];
                                                        ?>
                 <span id="order_status_<?php echo $listData['order_id'];?>" style="display:<?php echo $display;?>"> 


                                                        <a class="btn btn-primary pull-right modellink" data-toggle="modal" href="#printMyModal" id="" onclick="return print_order('<?php echo $listData['order_id'];?>');"><i style="cursor:pointer" title="print Order" class="fa fa-print icon-2x"></i></a>
                                                        </span>
         <?php if($display	!= "block;"){echo $lable;}?>

        </td>
          <td>
             <div class="hidden-sm hidden-xs action-buttons">
                 <a href="<?php  echo base_url().'order_master/view_order/'.$listData['order_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"><i class="fa fa-eye"></i></a>


                 <?php 
				 if((order_status($listData['order_status']))=="Pending") {
				 echo anchor("order_master/edit_product/" . $listData['order_id'], '<i class="ace-icon fa fa-pencil"></i>', array('class' => 'btn btn-xs btn-info','title'=>'Edit')); }
	

				 ?>
				 
				 
                <!-- <input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $listData['order_id'];?>" value="<?php echo $status ;?>" onclick="return change_status('<?php echo $listData['order_id'];?>',this.value);" />-->

            </div>

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
$plant_data = get_all_active_locations_plant($user_id);
foreach($plant_data as $res){?>
<option value="<?php echo $res['location_id'];?>" <?php if($this->uri->segment(3)==$res['location_id']){echo 'selected';}?>><?php echo $res['location_name'];?><?php if($user_id=='1'){ echo " - [" .getUserFullNameById($res['created_by']) . "]"; } ?>-<?php echo $res['location_id'];?></option>
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
data:{id:id},
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
                  <h4 class="modal-title">Upload Customer Codes</h4>
            </div>
            <div class="modal-body">
<?php 
//$datecodedno = date('YmdHis');
//$date = date('Y-m-d H:i:s');
//echo $datecodedno;

?>
<form name="frmup" id="frmup" action="#" method="POST">
<!--<input name="menu_id" id="menu_id" type="hidden" value="">-->
<input name="order_no" id="order_no" type="hidden" value="<?php $datecodedno; ?>">
<div class="form-group row">
<div class="col-sm-12">
<label for="form-field-8">Plant Name</label>
<select class="form-control" name="plant_id2" id="plant_id2" onchange="return get_products2(this.value);">
<option value="">-Select Plant-</option>
<?php 
$user_id 	= $this->session->userdata('admin_user_id');
$plant_data = get_all_active_locations_plant($user_id);
foreach($plant_data as $res){?>
<option value="<?php echo $res['location_id'];?>" <?php if($this->uri->segment(3)==$res['location_id']){echo 'selected';}?>><?php echo $res['location_name'];?></option>
<?php }?>
</select>
<br />
<label for="form-field-8">SKU/Product Name</label>
<select class="form-control" name="product2[]" id="product2" >

</select>			
<?php if(!empty($this->uri->segment(3))){?>
<script>get_products2(<?php echo $this->uri->segment(3);?>);</script>
<?php }?>						


<script>
function get_products2(id){
if(id!=''){
$.ajax({
type:'POST',
url:'<?php echo base_url().'plant_master/getAssignedProductList'?>',
data:{id:id},
success:function(msg2){
$("#product2").html(msg2);
}
})
}
}
</script>


                                  </div>
                                  </div>
								<div class="form-group row">
                                  <div class="col-sm-12">
                                  <label for="form-field-8">Upload Code</label>
								  				
                                  <input name="upload_code" id="upload_code" type="text" class="form-control" placeholder="Upload Code" >
                                  </div>
                                  </div>

                                  <div class="form-group row">
                                  <div class="col-sm-12">
                                  <label for="form-field-8">Quantity</label>
								  				
                                  <input name="quantity2" id="quantity2" type="text" class="form-control" placeholder="Quantity" value="1" readonly>
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
    function change_order_status(id,val,print_opt){
    $("#order_status_"+id).hide();
    $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>order_master/change_order_status/",
                    data: {id:id, value:val},
                    success: function (result) {
                            if(result!=''){
                                    alert('Status Changed Successfully');
                                    if(parseInt(val)==1 && parseInt(print_opt)==1){ 
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
			plant_id: {required: true},
            "product[]":{required: true},
        quantity: {required: true, number: true}
            } ,

    messages: {
			plant_id: {	required: "Please Select a Plant"} ,
            "product[]": {required: "Please Select Product Name/SKU Code" } , 
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
                                    window.location="<?php echo base_url(); ?>order_master/list_orders";

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


    <script>$(function () {
		
		var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    //initializing datepicker
    $('.datepicker').datepicker({format:'yyyy-mm-dd', startDate: today,minDate: new Date()  });
    });
    
    $("form#frmup").validate({
    rules: {
			plant_id2: {required: true},
            "product2[]":{required: true},
			upload_code: {required: true},
			quantity2: {required: true, number: true}
            } ,

    messages: {
			plant_id2: {	required: "Please Select a Plant"} ,
           "product2[]": {required: "Please Select Product Name/SKU Code" } , 
			upload_code: {	required: "Please provide the upload code"} ,
            quantity2: {	required: "Please enter quantity"} 
    },
    submitHandler: function(form) {
            var dataSend;
            var dataSend 	= $("#frmup").serialize();
            $.ajax({
                    type: "POST",
                    dataType:"json",
                    beforeSend: function(){
                    $('.alert-success').hide();
                                    //$(".show_loader").show();
                                    //$(".show_loader").click();
                    },
         url: "<?php echo base_url(); ?>order_master/save_upload_bulk_codes/",
         data: dataSend,
         success: function (msg) {
			
			if(parseInt(msg)==1){
                    $('#myUploadModal').modal('hide');
                  //$('#ajax_msg').text("Codes Upoaded Successfully!").css("color","green").show();
                    $('.alert-success').show();
                    $('#frmup')[0].reset(); 
                    window.location="<?php echo base_url(); ?>order_master/list_orders/";
					
                            }
                    }

            });
			
				alert("Codes Upoaded!");
				window.location.href = "<?php echo base_url(); ?>order_master/list_orders/";
             return false; 
    }
    });




    </script>

<?php if($this->uri->segment(3)=='upload_codes'){?>
    <script type="text/javascript">
    $(window).on('load',function(){
    $('#myUploadModal').modal('show');
    });
    </script>
<?php }?>

 
<?php $this->load->view('../includes/admin_footer');?>