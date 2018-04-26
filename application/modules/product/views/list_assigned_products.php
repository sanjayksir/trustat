<?php $this->load->view('../includes/admin_header'); ?>

<?php //echo '<pre>';print_r($product_list);exit;
$this->load->view('../includes/admin_top_navigation'); ?>

<div class="main-container ace-save-state" id="main-container">

    <script type="text/javascript">

        try {

            ace.settings.loadState('main-container')

        } catch (e) {

        }

    </script>

    <?php $this->load->view('../includes/admin_sidebar'); ?>
	
	 
	

     <div class="main-content">

        <div class="main-content-inner">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">

                <ul class="breadcrumb">

                    <li>

                        <i class="ace-icon fa fa-home home-icon"></i>

                        <a href="#">Home</a>

                    </li>



                    <li>

                        <a href="#">Master</a>

                    </li>

                    <li class="active">Assigned Products</li>

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

                         <div class="row">

                            <div class="col-xs-12">

                                <h3 class="header smaller lighter blue">Assigned Products</h3>

                               
 								
								<!--------------- Search Tab start----------------->
                         <!--   <div class="form-group row">
                            <div class="col-sm-10">
                            	<form id="form-filter" action="" method="post" class="form-horizontal" onsubmit="return validateSrch();">
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
                                
                            </div>-->
                      <!--------------- /Search Tab start----------------->
					  
					
															
															
                                  <table id="dynamic-table" class="table table-striped table-bordered table-hover">  
                                      <thead>
                                         <tr>
                                             <th>S No.</th>
                                             <th class="hidden-480">Product Name</th>
											 
											<!-- <th>Assign Product</th>-->
                                         </tr>
                                     </thead>
                                      <tbody>
									  
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
															
 															<?php if(count($product_list)>0){
															$i=0;
																		foreach($product_list as $product){
																		 
																		 $i++;
																		
																		?>
																		
																		
																		<tr id="show<?php echo $product['id'];?>">
																					<td><?php echo $i; ?></td>
																					<td><?php echo $product['product_name'];?></td>
																		 </tr>
															
															<?php 		}
																	}else{?><tr><td align="center" colspan="2" class="color error">No Records Founds</td></tr>
															<?php }?>
															
															
                                            
										  <!--<tr id="show<?php echo $attr['id']; ?>"><td colspan="8"><input class="btn btn-primary pull-right" type="button" id="assign" name="assign" value="Assign Product" /></td></tr>-->
                                    </tbody>

                                </table>

						   </div><!-- /.col -->

                                <?php //echo $this->pagination->create_links(); ?>

                                <!-- PAGE CONTENT ENDS -->

                            </div><!-- /.col -->

                        </div><!-- /.row -->

                    </div><!-- /.page-content -->

                </div>

            </div><!-- /.main-content -->

             <div class="footer">

                <div class="footer-inner">

                    <div class="footer-content">

                        <span class="bigger-120">

                            <span class="blue bolder">Tracking Portal</span>

                            <?=date('Y');?>

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



     

