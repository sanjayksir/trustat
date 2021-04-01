<?php $this->load->view('../includes/admin_header'); ?>

<?php //echo '<pre>';print_r($product_list);exit;
$this->load->view('../includes/admin_top_navigation'); ?>

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

                    <li class="active">Manage Survey</li>

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
                            <!--<div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">MANAGE PRODUCTS</h5>
                                <div class="widget-toolbar">
                                    <a href="<?php //echo base_url('product/add_product') ?>" class="btn btn-xs btn-warning" title="Add Product">Add <?php //echo $label; ?> </a>
                                </div>
                            </div>
							-->
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
                                            <span style="margin-left:90px"></span>  <a href="javascript:void(0);" class="btn btn-xs btn-warning" title="Request to Push Survey" data-toggle="modal" data-target="#myModal" align="center">Request to Push Survey</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Type your query">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                    <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                </span> 
                                            </div>
                                        </div>
                                    </form>
                                </div>

                      <!--------------- Search Tab start----------------->
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S No.</th>
									<th class="hidden-480">Request No</th>
									<th class="hidden-480">Date Time</th>
                                    <th class="hidden-480">Product Name</th>
                                    <th class="hidden-480">Type of Survey</th>
                                    <th class="hidden-480">Number of Consumers</th>
                                    <th class="hidden-480">Status</th>
                                </tr>
                            </thead>
                            <tbody>
									  
                        <?php
                        if(count($product_list)>0){
                            $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
                            $sno =  $page + 1;
                        $i=0;
                        foreach ($product_list as $attr){
									$i++;
										$push_survey_req_status = $attr['push_survey_req'];
                                            if($push_survey_req_status=='0'){
											$push_survey_req_status ='Waiting for Survey pushed approval';
 												$colorStyle="style='color:white;border-radius:10px;background-color:yellow;border:none;pointer-events: none;'";
											} elseif($push_survey_req_status ==1){
											$push_survey_req_status ='Survey pushed successfully';
												$colorStyle="style='color:black;border-radius:10px;background-color:green;border:none;pointer-events: none;'";
												} else{
											$push_survey_req_status ='Request to Push Survey';
												$colorStyle="style='color:black;border-radius:10px;background-color:gray;border:none;'";
												}
												?>
                            <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $attr['product_name']; ?></td>
								<td><?php echo $attr['product_name']; ?></td>
								<td><?php echo $attr['product_name']; ?></td>
                                <td><?php echo $attr['product_sku']; ?></td>
								<td>&nbsp;&nbsp; <a title="View" href="<?php echo base_url();?>backend/product_attrribute/view/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"> <i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                       
												  <td>	<?php  
	$user_id 	= $this->session->userdata('admin_user_id');
	
	if($user_id=='1') {

		if($attr['push_survey_req']!=''){
	?>
	<input <?php 
	$answerQuery = $this->db->get_where('push_surveys',"product_id='".$attr['id']."'");
	if($answerQuery->num_rows() > 0){ ?>checked="checked"<?php } else {} ?> id="product_<?php echo $attr['id'];?>"name="addquestion" class="ace" onclick="return add_question_to_product('<?php echo $attr['created_by'];?>','<?php echo $attr['id'];?>');" type="checkbox">
	<span class="lbl"></span>
	<?php } else { echo "No Survey Push Request"; } ?>
	
	<?php } else { ?>
	<input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $attr['id'];?>" value="<?php echo $push_survey_req_status ;?>"  onclick="return change_status('<?php echo $attr['id'];?>',this.value);" />
                    	<?php } ?>		
							 View Response </td>
												  
												  
												  
                                                 <!-- <td> 
 														<input type="checkbox" name="vehicle" value="Bike">						  </td>
                                                    <td> 
 														<input type="checkbox" name="vehicle" value="Bike"></td>-->
													<!--<td><input type="checkbox" name="assignProduct[]" class="assignProduct" /></td>-->
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
                            <div class="row paging-box">
                            <?php echo $links ?>
                            </div>    
                        </div><!-- /.col -->

                    </div><!-- /.col -->

                    </div><!-- /.row -->

                </div><!-- /.page-content -->
				
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
                                  <label for="form-field-8">Survey Type</label>
								  <select name="quantity" id="quantity" class="form-control">
										<option value="survey_on_product_video">Survey on Product Video</option>	
										<option value="survey_on_product_audio">Survey on Product Audio</option>
										<option value="survey_on_product_pdf">Survey on Product PDF</option>
										<option value="survey_on_product_image">Survey on Product Image</option>
										<option value="survey_on_product_description">Survey on Product Description</option>
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
 
				
				
            <div class="footer">

                <div class="footer-inner">

                    <div class="footer-content">

                        <span class="bigger-120">
						<span class="blue bolder">Copyright ©</span>
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

function add_question_to_product(created_by, id){
	var r = confirm("Are Sure to Push the Survey for this product?");
	if (r == true) {
		if ($("#product_"+id).prop('checked')==true){ 
			var Chk =1; 
		}else{
			var Chk =0;
		}
	
		$.ajax({
			dataType:'html',
			type:'POST',
			url:'<?php echo base_url().'surveys/save_push_survey/';?>',
			data:{c_id:created_by,p_id:id,Chk:Chk},
			success:function (msg){
			}
		
		});
	} else{
		return false;
	} 
}

function change_status(id,val){
	if(confirm("Hey, this is final submission of Push survey Request, you can not cancel it, press OK to confirm or Cancel it.")){
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>surveys/change_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(parseInt(result)==1){
						$('#status_'+id).val('1').css("background-color","green");
					}else{
						$('#status_'+id).val('Waiting for survey pushed approval').css("background-color","yellow");
					}
					
				}
			});
}else{
    return false;  
}
}
 
</script>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

            </a>

        </div><!-- /.main-container -->



     

