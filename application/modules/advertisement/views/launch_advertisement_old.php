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

                    <li class="active">Manage Advertisements</li>

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
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Product Name Or Product SKU">
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
                                    <th class="hidden-480">Product Name</th>
                                    <th class="hidden-480">Product SKU</th>
                                    <th class="hidden-480">View Product Media</th>
                                   <!-- <th>Advertisement on Product Description <a title="Product Description Feedback" href="#" class="btn btn-xs btn-info"><i class="fa 	fa-barcode" aria-hidden="true"></i></a></th>
                                    <th>Advertisement on Product Image <a title="Product Image Feedback" href="#" class="btn btn-xs btn-info"><i class="glyphicon-picture" aria-hidden="true"></i></a></th>-->
                                    <th>Advertisement on Product Video <a title="Product Video Feedback" href="#" class="btn btn-xs btn-info"><i class="fa fa-video-camera" aria-hidden="true"></i> </a></th>
                                   <!-- <th>Advertisement on Product Audio <a title="Product Audio Feedback" href="#" class="btn btn-xs btn-info"><i class="fa fa-bullhorn" aria-hidden="true"></i> </a></th>
                                    <th>Advertisement on Product PDF <a title="Advertisement on Product PDF" href="#" class="btn btn-xs btn-info"><i class="fa fa-book" aria-hidden="true"></i> </a>  </th>-->
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
										$push_ad_req_status = $attr['push_ad_req'];
                                            if($push_ad_req_status=='0'){
											$push_ad_req_status ='Waiting for Ad pushed approval';
 												$colorStyle="style='color:white;border-radius:10px;background-color:yellow;border:none;pointer-events: none;'";
											} elseif($push_ad_req_status ==1){
											$push_ad_req_status ='Ad pushed successfully';
												$colorStyle="style='color:black;border-radius:10px;background-color:green;border:none;pointer-events: none;'";
												} else{
											$push_ad_req_status ='Request to Push Ad';
												$colorStyle="style='color:black;border-radius:10px;background-color:gray;border:none;'";
												}
												?>
                            <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $attr['product_name']; ?></td>
                                                                                <td><?php echo $attr['product_sku']; ?></td>
												                                <td>&nbsp;&nbsp; <a title="View" href="<?php echo base_url();?>backend/product_attrribute/view/<?php echo $attr['id'];?>" class="btn btn-xs btn-info">
 																<i class="fa fa-eye" aria-hidden="true"></i>

 															</a> </td>
												                               <!-- <td><input type="checkbox" name="vehicle" value="Bike"></td>
                                                 <td><input type="checkbox" name="vehicle" value="Bike"></td>-->
                                       <td>	<?php 
	$user_id 	= $this->session->userdata('admin_user_id');
	
	if($user_id=='1') {

		if($attr['push_ad_req']!=''){
	?>
	<input <?php 
	$answerQuery = $this->db->get_where('push_advertisements',"product_id='".$attr['id']."'");
	if($answerQuery->num_rows() > 0){
	?>checked="checked"<?php } ?> id="product_<?php echo $attr['id'];?>"name="addquestion" class="ace" onclick="return add_question_to_product('<?php echo $attr['created_by'];?>','<?php echo $attr['id'];?>');" type="checkbox">
	<span class="lbl"></span>
	<?php } else { echo "No Ad Push Request"; } ?>
	
	<?php } else { ?>
	<input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $attr['id'];?>" value="<?php echo $push_ad_req_status ;?>"  onclick="return change_status('<?php echo $attr['id'];?>',this.value);" />
                    	<?php } ?>		
							  </td>
                                                  <!--<td> 
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
										  <!--<tr id="show<?php //echo $attr['id']; ?>"><td colspan="8"><input class="btn btn-primary pull-right" type="button" id="assign" name="assign" value="Assign Product" /></td></tr>-->
                          </tbody>
                              </table>
                            <div class="row paging-box">
                            <?php echo $links ?>
                            </div>    
                        </div><!-- /.col -->

                    </div><!-- /.col -->

                    </div><!-- /.row -->

                </div><!-- /.page-content -->
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
	var r = confirm("Are Sure to Push the ad for this product?");
	if (r == true) {
		if ($("#product_"+id).prop('checked')==true){ 
			var Chk =1; 
		}else{
			var Chk =0;
		}
	
		$.ajax({
			dataType:'html',
			type:'POST',
			url:'<?php echo base_url().'advertisement/save_push_advertisement/';?>',
			data:{c_id:created_by,p_id:id,Chk:Chk},
			success:function (msg){
			}
		
		});
	} else{
		return false;
	} 
}

function change_status(id,val){
	if(confirm("You have selected to Push this advertisement to your () consumer(s). Once the request is processed at your end, it cannot be cancelled. The approval for pushing the advertisement is subject to adequate monetory balance in your account with Innovigent Solutions Private Limited. Please press OK to move ahead else press cancel.")){
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>advertisement/change_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(parseInt(result)==1){
						$('#status_'+id).val('1').css("background-color","green");
					}else{
						$('#status_'+id).val('Waiting for Ad pushed approval').css("background-color","yellow");
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



     

