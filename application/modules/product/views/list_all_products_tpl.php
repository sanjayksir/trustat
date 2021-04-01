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

                    <li class="active">List of All products</li>

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
                                <h5 class="widget-title bigger lighter">List of All products</h5>
								<?php if($this->session->userdata('admin_user_id')==1){ ?>
								<!--<div class="widget-toolbar">
                                    <a href="<?php echo base_url('product/add_product/'.$this->uri->segment(3)); ?>" class="btn btn-xs btn-warning" title="Add Product">Add New Product<?php //echo $label; ?> </a>
                                </div>-->
								<?php }else{ ?>
                                <div class="widget-toolbar">
                                    <a href="<?php echo base_url('product/add_product'); ?>" class="btn btn-xs btn-warning" title="Add Product">Add New Product<?php //echo $label; ?> </a>
                                </div>
								<?php } ?>
                            </div>
							
                            <div class="widget-body">
                                <div class="row filter-box">
                                    <form id="formfilter" name="formfilter" action="" method="get" class="form-horizontal" >
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
											<input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="showDescription" style="width:369px !important;" placeholder="Product Name,Product Code, Brand Name">
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
                                    <th>S. No.</th>
									<th class="hidden-480">Date of Creation of Product</th>
                                    <th class="hidden-480">Product Name</th>
                                    <th class="hidden-480">Product Code</th>
									<th class="hidden-480">Customer Name
									
									<select name="v" class="Product">
									<option value=""> - Please Select Customer Name -  </option>
								<?php foreach ($list_all_customers_products as $attr12){                        
                                // echo $attr1['customer_id'];  ?>
						
						<option value="<?php echo $attr12['created_by']; ?>"> <?php echo getUserFullNameById($attr12['created_by']); ?></option>
									<?php }  ?>
						</select>
						<!--<script src="http://innovigents.com/assets/export_to_excel/jquery.min21.js"></script>-->
						<script>
							$(function(){
								  $('.Product').change(function(){
										 var Product = $('.Product').val();
										 $(".showDescription").val(Product);
										 formfilter.submit();
								  });
							});
						</script>
									
									</th>
									<th class="hidden-480">Customer Code</th>
									<th class="hidden-480">Brand Name</th>
                                    <th class="hidden-480">Sector	Sub Sector 1/Sub Sector 2/Sub Sector 3/Sub Sector 4/.../..</th>
                                    <th class="hidden-480">Loyalty Type</th>	
									<th class="hidden-480">Number of Consumers scanned level 1	</th>
									<th class="hidden-480">No. of Consumers scanned level 0</th>	
									<th class="hidden-480">Number of  Product advertisement viewed</th>
									<th class="hidden-480">Under Referral or not</th>									
									<th class="hidden-480">Number of  Product referral sent by sender	</th>
									<th class="hidden-480">Number of  Product referral seen by receiver</th>
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
								<td><div style="word-wrap:break-word; width:200px;"><div style="word-wrap:break-word; width:170px;"><?php echo(date('j M Y H:i:s D', strtotime($attr['created_date'])));  ?></div></div></td>
                                <td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['product_name']; ?></div></td>
                                <td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['product_sku']; ?></div></td>
			<td><div style="word-wrap:break-word; width:250px;"><?php echo getUserFullNameById($attr['created_by']);?></div></td>
            <td><div style="word-wrap:break-word; width:100px;"><?php echo getCustomerCodeById($attr['created_by']); ?></div></td>
                                <td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['brand_name']; ?></div></td>
								<td><div style="word-wrap:break-word; width:400px;"> 
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
                                 <td><div style="word-wrap:break-word; width:100px;"><?php echo getCustomerLoyaltyTypeById($attr['created_by']); ?></div></td>
               <td><div style="word-wrap:break-word; width:200px;"><?php $TotalNumberofScannedCodesLevel1 = $this->db->where(array('pack_level'=>1, 'printed_barcode_qrcode.product_id'=>$attr['id']))
								->from("scanned_products")
						->join('printed_barcode_qrcode', 'printed_barcode_qrcode.barcode_qr_code_no = scanned_products.bar_code', 'left')
						->count_all_results(); 
						echo $TotalNumberofScannedCodesLevel1; 
						?></div></td>
                <td><div style="word-wrap:break-word; width:200px;"><?php $TotalNumberofScannedCodesLevel0 = $this->db->where(array('pack_level'=>0, 'printed_barcode_qrcode.product_id'=>$attr['id']))
								->from("scanned_products")
						->join('printed_barcode_qrcode', 'printed_barcode_qrcode.barcode_qr_code_no = scanned_products.bar_code', 'left')
						->count_all_results(); 
						echo $TotalNumberofScannedCodesLevel0; 
						?></div></td>                
						<td><div style="word-wrap:break-word; width:200px;"><?php $TotalNumberofWatchedPushedAdvertismentViewed = $this->db->where(array('media_play_date !='=>"0000-00-00 00:00:00", 'product_id'=>$attr['id']))->count_all_results('push_advertisements'); echo $TotalNumberofWatchedPushedAdvertismentViewed; ?></div></td>
                      <td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['include_the_product_in_referral_program']; ?></div></td>
                   <td><div style="word-wrap:break-word; width:200px;"><?php $TotalNumberofProductreferralsentbysender = $this->db->where(array('product_id'=>$attr['id']))
								->from("consumer_referral_table")->count_all_results(); 
						echo $TotalNumberofProductreferralsentbysender; 
						?></div></td>
			<td><div style="word-wrap:break-word; width:200px;"><?php $TotalNumberofProductreferralsentbysender = $this->db->where(array('product_id'=>$attr['id'], 'referral_consumed'=>1))
								->from("consumer_referral_table")->count_all_results(); 
						echo $TotalNumberofProductreferralsentbysender; 
						?></div></td>
													
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



     

