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

                    <li class="active">MANAGE PRODUCTS</li>

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
                            <div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">MANAGE PRODUCTS <?php if($this->session->userdata('admin_user_id')==1){ echo "for " . getUserFullNameById($this->uri->segment(3)); }?> <?php //echo $loyalty_points_referral; ?></h5>
								<?php if($this->session->userdata('admin_user_id')==1){ ?>
								<div class="widget-toolbar">
                                    <a href="<?php echo base_url('product/add_product/'.$this->uri->segment(3)); ?>" class="btn btn-xs btn-warning" title="Add Product">Add New Product<?php //echo $label; ?> </a>
                                </div>
								<?php }else{ ?>
                                <div class="widget-toolbar">
                                    <a href="<?php echo base_url('product/add_product'); ?>" class="btn btn-xs btn-warning" title="Add Product">Add New Product<?php //echo $label; ?> </a>
                                </div>
								<?php } ?>
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
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Product Name,Product SKU">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                    <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                      <!--------------- Search Tab start----------------->
					  <div style="overflow-x:auto;">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="hidden-480">Product Name</th>
                                    <th class="hidden-480">Product SKU</th>
                                    <th class="hidden-480">Product Industry</th>
                                    <!-- <th>Created By</th>-->
                                    <th>Creation Date</th>
									<?php if($this->session->userdata('admin_user_id')==1){ ?>
                                    <th>Edit/Delete Product </th>   
                                    <th>Feedback Questions (View/Edit/Add)</th>
									<?php } ?>
									<th>View Product</th>
                                </tr>
                            </thead>
                            <tbody>
									  
                        <?php
                        if(count($product_list)>0){
						$user_id = $this->session->userdata('admin_user_id');
						$customer_id = $this->uri->segment(3);
					if($user_id>1){
					$page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
						}else{
					$page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
					}
							
                            
							
                            $sno =  $page + 1;
							$i=0;
                        foreach ($product_list as $attr){
                        $i++;
                         ?>
                                <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
                                <td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['product_name']; ?></div></td>
                                <td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['product_sku']; ?></div></td>
                                <td><div style="word-wrap:break-word; width:300px;"> 
                                <?php $industryList =  get_industry_by_id(implode(',',json_decode($attr['industry_data'],true)));
                                   $indus='';
                                   $i=0;
                                   foreach($industryList as $rec){
                                        if($i>0){
                                                $indus.="/&nbsp;";
                                        }
                                        $indus.=$rec['categoryName'];
                                        $i++;
                                   }
                                   echo $indus;
                                   ?></div>
                                </td>
                                              <!--<td><?php echo getUserFullNameById($attr['created_by']);?></td>-->
                                                 <td><div style="word-wrap:break-word; width:170px;"><?php echo(date('j M Y H:i:s D', strtotime($attr['created_date'])));  ?></div></td>
												 <?php if($this->session->userdata('admin_user_id')==1){ ?>
                                                  <td><div style="word-wrap:break-word; width:200px;">
												  <form name="frm_<?php echo $attr['id'];?>" id="frm_<?php echo $attr['id'];?>" method="post" action="">
 														<div class="hidden-sm hidden-xs btn-group">
															<a href="<?php echo base_url();?>product/update_product/<?php echo $attr['id'];?>" title="Edit Product"  class="btn btn-xs btn-info">
 																<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
 															</a>
															
															<a href="<?php echo base_url();?>product/add_product_attributes/<?php echo $attr['id'];?>" title="Manage Product Attributes"  class="btn btn-xs btn-info">
 																<i class="ace-icon fa fa-plus-square bigger-120"></i>
 															</a>
															<a href="<?php echo base_url();?>backend/product_attrribute/att_detail/<?php echo $attr['id'];?>" title="Product Loyalty Points and Feedback Question Quantity"  class="btn btn-xs btn-info">
 																<i class="ace-icon fa fa-briefcase bigger-120"></i>
 															</a>
															
															 <a title="Product Media Management" href="<?php echo base_url();?>backend/product_attrribute/att_detail/<?php echo $attr['id'];?>" class="btn btn-xs btn-info">
 																<i class="ace-icon fa fa-cloud-upload"></i>
 															</a>
															
															<a href="<?php echo base_url();?>product/manage_packaging/<?php echo $attr['id'];?>" title="Manage Packaging"  class="btn btn-xs btn-info">
 																<i class="fa fa-sort-numeric-asc bigger-120"></i>
 															</a>
															
															<!--<a href="<?php echo base_url();?>product/ask_product_referral_response_message_options/<?php echo $attr['id'];?>" title="Referral response message Options"  class="btn btn-xs btn-info">
 																<i class="ace-icon glyphicon glyphicon-share"></i>
 															</a>-->
															
  															<a href="javascript:void(0);" title="Delete Product" class="btn btn-xs btn-danger" onclick="delete_attr('<?php echo $attr['id'];?>');">
 																<i class="ace-icon fa fa-trash-o bigger-120"></i>
 															</a>
                                                            <input type="hidden" name="del_submit" value="<?php echo $attr['id'];?>" />
															
 
														</div>
														</form>
														</div>
 													</td> 
                                                    
                                                    <td> 
 														<div style="word-wrap:break-word; width:250px;">
														<!--
   															<a title="Product Description Feedback" href="<?php //echo base_url();?>product/ask_feedback/<?php //echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa 	fa-barcode" aria-hidden="true"></i></a> -->
															<a title="Product Image Feedback" href="<?php echo base_url();?>product/ask_image_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa 	fa-file-image-o" aria-hidden="true"></i></a>
															<a title="Product Video Feedback" href="<?php echo base_url();?>product/ask_video_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>
															<a title="Product Audio Feedback" href="<?php echo base_url();?>product/ask_audio_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-bullhorn" aria-hidden="true"></i> </a>
															
															<a title="Product PDF Feedback" href="<?php echo base_url();?>product/ask_pdf_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-book" aria-hidden="true"></i> </a>
															
															<a title="Product Advertisement Feedback" href="<?php echo base_url();?>product/ask_pushed_ad_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-globe " aria-hidden="true"></i> </a>
															<a title="Product Survey Feedback" href="<?php echo base_url();?>product/ask_survey_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-laptop" aria-hidden="true"></i> </a>
															
															<!--
															<a title="Product Image Survey Feedback" href="<?php echo base_url();?>product/ask_survey_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-laptop" aria-hidden="true"></i> </a>
															
															<a title="Product Image Survey Feedback" href="<?php echo base_url();?>product/ask_survey_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-laptop" aria-hidden="true"></i> </a>
															
															<a title="Product PDF Survey Feedback" href="<?php echo base_url();?>product/ask_survey_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-laptop" aria-hidden="true"></i> </a>
															-->
															<a title="Product Demo Video Feedback" href="<?php echo base_url();?>product/ask_demo_video_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>
															<a title="Product Demo Audio Feedback" href="<?php echo base_url();?>product/ask_demo_audio_feedback/<?php echo $attr['id'];?>" class="btn btn-xs btn-info"><i class="fa fa-bullhorn" aria-hidden="true"></i> </a>
															
 														</div>
  													</td>
												 <?php } ?>
													<td> 
 														<div style="word-wrap:break-word; width:140px;">
															<a title="View Product Details" href="<?php echo base_url();?>backend/product_attrribute/view/<?php echo $attr['id'];?>" class="btn btn-xs btn-info">
 																<i class="fa fa-eye" aria-hidden="true"></i>
 															</a>
															<a title="View Report Level 0" href="<?php echo base_url();?>reports/barcode/basic_customer_report_level0_product/<?php echo $attr['id'];?>" class="btn btn-xs btn-info">
 																L0 <i class="fa fa-print" aria-hidden="true"></i>
 															</a>
															<a title="View Report Level 1" href="<?php echo base_url();?>reports/barcode/basic_customer_report_level1_product/<?php echo $attr['id'];?>" class="btn btn-xs btn-info">
 																L1 <i class="fa fa-print" aria-hidden="true"></i>
 															</a>
 														</div>														
  													</td>
													
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
								</div> 
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
function assignProduct(){
	 $('#save_value').click(function(){
    var arr = $('.ads_Checkbox:checked').map(function(){
        return this.value;
    }).get();
}); 
}


function delete_attr(id){  if (confirm("Sure to Delete SKU") == true) {
       window.location.href="<?php echo base_url();?>product/delete_attribute/"+id;
    } else {
        return false;
    }
}
</script>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

            </a>

        </div><!-- /.main-container -->



     

