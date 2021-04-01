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

                        <a href="#">Loyalty Mgmt</a>

                    </li>

                    <li class="active">Consumer Loyalty Mgmt</li>

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

                   
				
			 <table class="table table-striped table-bordered table-hover">
                    <thead>
                           <tr>
								<th><span class="blue bolder">Total Loyalties</span></th>
								<th><span class="blue bolder">Loyalties Details</span></th>
								
							</tr>
                     </thead>
                            <tbody>
								<tr>
									<td><?php echo $Total_Earned_Points; ?></td>
									<td><?php 
									$user_id = $this->session->userdata('admin_user_id');									
									echo anchor("product/list_customerwise_consumer_loyalty_details/".$user_id, '<i class="ace-icon fa fa-eye bigger-130"> Loyalties Details</i>', array('class' => 'btn btn-xs btn-info','title'=>' Loyalty Details')); ?></td>
								</tr>
							</tbody>
			 </table>
			 
			 			 <table class="table table-striped table-bordered table-hover">
                    <thead>
                           <tr>
								<th><span class="blue bolder">Total Loyalties Redemption Through Microsite Loyalties</span></th>
								<th><span class="blue bolder">Redemption Through Microsite Loyalties Details</span></th>
								
							</tr>
                     </thead>
                            <tbody>
								<tr>
									<td><?php echo $Total_Points_Redeemed_ms; ?></td>
									<td><?php 
									$user_id = $this->session->userdata('admin_user_id');									
									echo anchor("product/mis_redemption_microsite/", '<i class="ace-icon fa fa-eye bigger-130"> Redemption Through Microsite Loyalties Details</i>', array('class' => 'btn btn-xs btn-info','title'=>' Loyalty Details')); ?></td>
								</tr>
							</tbody>
			 </table>
							




                        <div class="widget-box widget-color-blue">
						
						
							
							
							
                            <!--<div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">MANAGE PRODUCTS</h5>
                                <div class="widget-toolbar">
                                    <a href="<?php //echo base_url('product/add_product') ?>" class="btn btn-xs btn-warning" title="Add Product">Add <?php echo $label; ?> </a>
                                </div>
                            </div>
							-->
                            
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



     

