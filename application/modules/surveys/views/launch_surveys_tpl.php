<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                    try{ace.settings.loadState('main-container')}catch(e){}
            </script>
            <?php $label = 'Surveys';?>

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
                                 Manage <?php echo $label;?> <?php //echo date("Y-m-d H:i:s",time()); ?>
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
                                                <h5 class="widget-title bigger lighter">List <?php echo $label;?></h5>
                                                <div class="widget-toolbar">
                                                   <?php if($this->session->userdata('admin_user_id')>1){  ?>
                                                    <a href="javascript:void(0);" class="btn btn-xs btn-warning" title="Request to Push Survey" data-toggle="modal" data-target="#myModal">Request to Push Survey</a>
												   <?php }  ?>
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
                                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Request No., Product Name OR Type of Survey">
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
																<th>Request No</th>
																<th>Date Time</th>
                                                                <th>Product Name</th>
																<th>Survey Title</th>
                                                                <th>Type of Survey</th>
                                                                <th>Number of Consumers</th>
                                                                <th>Status</th>
																<th>Review Survey</th>
																<th>Consumer Data</th>
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
                                                $essentialAttributeArr = getEssentialAttributes($listData['promotion_id']);
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
												  <tr id="show<?php echo $listData['promotion_id']; ?>">
                                                   <td><?php  echo $sno;$sno++; ?></td>
												    <td><?php  echo $listData['promotion_request_id']; ?></td>
												    <td><?php echo date('j M Y H:i:s D',strtotime($listData['request_date_time'])); ?></td>
													
                                                        <td><?php echo $listData['product_name'];  ?></td>
														 <td><?php echo $listData['promotion_title'];  ?></td>
                                                        <td><?php echo $listData['promotion_media_type']; ?></td>
														<td><?php echo $listData['number_of_consumers']; ?></td>
                                                       
                                                        <?php if($this->session->userdata('admin_user_id')==1){
                                                               

                                                                ?>

                                                         <td>
														 
														 
														 <input <?php 
	$answerQuery = $this->db->get_where('push_surveys',"promotion_id='".$listData['promotion_id']."'");
	if($answerQuery->num_rows() > 0){ ?>checked="checked"<?php } else {} ?> id="product_<?php echo $listData['product_id'];?>"name="addquestion" class="ace" onclick="return add_question_to_product('<?php echo $listData['user_id'];?>','<?php echo $listData['product_id'];?>','<?php echo $listData['promotion_id'];?>','<?php echo $listData['promotion_title'];?>');" type="checkbox"   <?php if($listData['request_status']==2){ echo "disabled"; }   ?> >
	<span class="lbl"></span> <?php echo promotion_status($listData['request_status']); ?>
	
	
         <?php //if($essentialAttributeArr['delivery_method']==4){?>
               <!-- <select name="change_order_status" id="change_order_status" onchange="return change_order_status('<?php echo $listData['promotion_id'];?>',this.value,'<?php echo $print_opt;?>'); add_question_to_product('<?php echo $listData['user_id'];?>','<?php echo $listData['product_id'];?>');">
                <option value="0" <?php if($listData['request_status']=='0'){echo 'selected';}?>>Pending</option>
                <option value="1" <?php if($listData['request_status']=='1'){echo 'selected';}?>>Survey Pushed</option>
                <option value="2" <?php if($listData['request_status']=='2'){echo 'selected';}?>>Request Rejected</option>
                </select> -->
        <?php //}else{
                                                                //echo 'Hard Print';
                                                        //}?>
                                                        </td> 
                                                        <?php }else{?>
                                                         <td><?php echo promotion_status($listData['request_status']); ?></td>
                                                        <?php }?>
														
														
			<td>
             <div class="hidden-sm hidden-xs action-buttons">
			 
			
			 
			 
                 <a href="<?php  echo base_url().'surveys/review_survey/'.$listData['product_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"><i class="fa fa-eye"></i></a>
			
              
            </div>

        </td>
		
		
                                                        
          <td>
             <div class="hidden-sm hidden-xs action-buttons">
			  <?php if($listData['request_status']==0){ echo "Waiting to Launched"; } else {   ?>
                 <a href="<?php  echo base_url().'surveys/view_survey_details/'.$listData['promotion_id'];?>" class="btn btn-xs btn-success" target="_blank" title="View"><i class="fa fa-eye"></i></a>
				<?php }   ?>

                 <?php 
				 if((order_status($listData['request_status']))=="ssPending") {
				 echo anchor("surveys/edit_product/" . $listData['promotion_id'], '<i class="ace-icon fa fa-pencil"></i>', array('class' => 'btn btn-xs btn-info','title'=>'Edit')); }
	

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
                  <h4 class="modal-title">Request to Push Survey</h4>
            </div>
            <div class="modal-body">
<?php 
//$datecodedno = date('YmdHis');
//$date = date('Y-m-d H:i:s');
//echo $datecodedno;

?>
<form name="frm" id="frm" action="#" method="POST">
<!--<input name="menu_id" id="menu_id" type="hidden" value="">-->
<input name="promotion_type" id="promotion_type" type="hidden" value="Survey">
<div class="form-group row">
<div class="col-sm-12">
<label for="form-field-8">Plant Name</label>
<select class="form-control" name="plant_id" id="plant_id" onchange="return get_products(this.value);">
<option value="">-Select Plant-</option>
<?php 
$user_id 	= $this->session->userdata('admin_user_id');
$plant_data = get_all_active_locations_plant($user_id);
foreach($plant_data as $res){?>
<option value="<?php echo $res['location_id'];?>" <?php if($this->uri->segment(3)==$res['location_id']){echo 'selected';}?>><?php echo $res['location_name'];?><?php if($user_id=='1'){ echo " - [" .getUserFullNameById($res['created_by']) . "]"; } ?></option>
<?php }?>
</select>
<br />
<label for="form-field-8">Product Name</label>
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
                                  <label for="form-field-8">Survey Subject/Title</label>
								  <input name="promotion_title" id="promotion_title" type="text" value="" placeholder="Please enter Survey Subject/Title" class="form-control">
                                  </div>
                                  </div>
								  
                                  <div class="form-group row">
                                  <div class="col-sm-12">
                                  <label for="form-field-8">Promotion Media Type</label>
								  <select name="promotion_media_type" id="promotion_media_type" class="form-control">
										<option value="">- Please Select Promotion Media Type -</option>
										<option value="Survey on Product Video">Survey on Product Video</option>	
										<!--<option value="Survey on Product Audio">Survey on Product Audio</option>
										<option value="Survey on Product PDF">Survey on Product PDF</option>
										<option value="Survey on Product Image">Survey on Product Image</option>
										<option value="Survey on Product Description">Survey on Product Description</option>-->
									</select>
                                  </div>
                                  </div>
								<?php $customer_id = $this->session->userdata('admin_user_id'); ?>
								  <div class="form-group row">
                                  <div class="col-sm-12">
                           <label for="form-field-8">Select Consumers</label><?php 
						   
						   function reverse_birthday( $years ){
								return date('Y-m-d', strtotime($years . ' years ago'));
								}
								if($csc_consumer_min_age=='0') {
								$csc_consumer_min_dob = '';
									} else {
								$csc_consumer_min_dob = reverse_birthday( $csc_consumer_min_age );
									}
								if($csc_consumer_max_age=='0') {
								$csc_consumer_max_dob = '';
									} else {
								$csc_consumer_max_dob = reverse_birthday( $csc_consumer_max_age );
									}
								

								
									
						   $AllSelectedConsumersByACustomer = AllSelectedConsumersByACustomer($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_pin, $csc_consumer_min_dob, $csc_consumer_max_dob);
				
				foreach ($AllSelectedConsumersByACustomer as $consumer_id)  
				{  				
					//echo $consumer_id . ", ";
				  
				} 
				
				
						  // echo $csc_consumer_min_age . "<br>";
							 
									
								
								//echo $bd;
						    
	
						   //echo $csc_consumer_min_age . "<br>";
						    //echo $csc_consumer_max_age . "<br>";
							 //echo $csc_consumer_max_age . "<br>";
							 // echo $csc_consumer_city . "<br>";
							  // echo $csc_consumer_pin . "<br>";
						   
						   //$gender = "female";
						   
						  // echo NumberOfSelectedConsumersByACustomer($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_pin, $csc_consumer_min_age, $csc_consumer_max_age); ?>
                                  <select name="number_of_consumers" id="number_of_consumers" class="form-control">
										<option value="<?php echo NumberOfAllConsumersOfACustomer($customer_id); ?>">All Consumers (<?php echo NumberOfAllConsumersOfACustomer($customer_id); ?>)</option>	
										<option value="<?php echo NumberOfSelectedConsumersByACustomer($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_pin, $csc_consumer_min_dob, $csc_consumer_max_dob); ?>">Filtered Consumers (<?php echo NumberOfSelectedConsumersByACustomer($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_pin, $csc_consumer_min_dob, $csc_consumer_max_dob); ?>)</option>
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
<!--/ myModal Div -->  
  


  
  
    <?php $this->load->view('../includes/admin_footer');?>
    <!---------- modal popup dynaimic---------->
    <script type="text/javascript">
    //$(document).ready(function(){
    function print_order(val){
    var url = "<?php echo base_url().'surveys/print_box/';?>"+val;
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
                    url: "<?php echo base_url();?>surveys/change_order_status/",
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
                    url: "<?php echo base_url();?>surveys/change_status/",
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


	function add_question_to_product(created_by, id, promotion_id, promotion_title){
	var r = confirm("Are Sure to process your action?");
	if (r == true) {
		if ($("#product_"+id).prop('checked')==true){ 
			var Chk =1; 
		}else{
			var Chk =2;
		}
	
		$.ajax({
			dataType:'html',
			type:'POST',
			url:'<?php echo base_url().'surveys/save_push_survey/';?>',
			data:{c_id:created_by,p_id:id,promotion_id:promotion_id,promotion_title:promotion_title,Chk:Chk},
			success:function (msg){
			}
		
		});
		 window.location.href="<?php echo base_url().'surveys/launch_survey/';?>";
	} else{
		return false;
	} 
}
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
			 promotion_title: {required: true},
			 promotion_media_type: {required: true}
			 
            } ,

    messages: {
			plant_id: {	required: "Please Select a Plant"} ,
            "product[]": {required: "Please Select Product" } , 
			 promotion_title: {	required: "Please Enter Promotion Title"} ,
            promotion_media_type: {	required: "Please Select Media Type"} 
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
                    url: "<?php echo base_url(); ?>surveys/save_promotion_request/",
                    data: dataSend,
                    success: function (msg) {

                            if(parseInt(msg)==1){
                            $('#myModal').modal('hide');
                                    //$('#ajax_msg').text("User Added Successfully!").css("color","green").show();
                                    $('.alert-success').show();
                                    $('#frm')[0].reset(); 
                                    window.location="<?php echo base_url(); ?>surveys/launch_survey";

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