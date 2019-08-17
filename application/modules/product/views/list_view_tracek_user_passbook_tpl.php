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

                    <li class="active">List View Tracek User Passbook </li>

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
	
                Tracek User Name : <?php echo getUserFullNameById($this->uri->segment(3));?>

                 <div class="row">

                    <div class="col-xs-12">

                        <div class="widget-box widget-color-blue">
                            <!--<div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">MANAGE PRODUCTS</h5>
                                <div class="widget-toolbar">
                                    <a href="<?php //echo base_url('product/add_product') ?>" class="btn btn-xs btn-warning" title="Add Product">Add <?php echo $label; ?> </a>
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
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Event Name, Transaction Type">
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
                                    <th class="hidden-480">Transuction Date</th>
                                    <th class="hidden-480">Event Name</th>
                                    <th class="hidden-480">Event Detail</th>
                                    <th>Points </th>
									<th>Loyalty Source</th>
                                    <th>Transaction Type (Earned/Redeemed) </th>
									<td>Total accumulated points</td>
								   <td>Total redeemed points</td>
								    <td>Current balance</td>
									 <td>Points redeemable</td>
									 <td>Points short of redemption</td>
                                   <!-- <th>Balance Available for Redemption</th>
									Points req. for next Redemption-->
                                </tr>
                            </thead>
                            <tbody>
									  
                        <?php
						//echo $list_all_consumers; 
                        if(count($list_view_consumer_passbook)>0){
                            $page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
                            $sno =  $page + 1;
                        $i=0;
                        foreach ($list_view_consumer_passbook as $attr){
                        $i++;
                         ?>
                                <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $attr['transaction_date']; ?></td>
                                <td><?php echo $attr['transaction_type_name']; ?></td>
                                <td><?php //echo $attr['params'];
						//echo json_decode($attr['params']);
							$character = json_decode($attr['params']);		
							//if($character->transaction_date!=''){echo $character->transaction_date . ".";}	
							if($character->passbook_title!=''){echo  $character->passbook_title . ", ";}	
							if($character->consumer_phone!=''){echo  $character->consumer_phone;}
	if(getConsumerNameById($character->consumer_id)!='') {echo ", " . getConsumerNameById($character->consumer_id);}
	
							//if($character->brand_name!=''){echo  $character->brand_name;}
							//if($character->product_name!=''){echo ", " . $character->product_name;}
							
							if($character->product_id!=''){echo  get_products_brand_name_by_id($character->product_id);}
							if($character->product_id!=''){echo ", " . get_products_name_by_id($character->product_id);}
							
							if($character->points_redeemed!=''){echo $character->points_redeemed;}
							if($character->coupon_number!=''){echo ", " . $character->coupon_number;}
							
							
								?></td>
                                 <td><?php echo $attr['points']; ?></td>
								 <td><?php echo getUserFullNameById($attr['customer_id']); ?></td>
                                   <td><?php echo $attr['transaction_lr_type']; ?>-<?php echo $attr['customer_loyalty_type']; ?></td>
								   <td><?php echo $attr['total_accumulated_points']; ?></td>
								   <td><?php echo $attr['total_redeemed_points']; ?></td>
								    <td><?php echo $attr['current_balance']; ?></td>
									 <td><?php echo $attr['points_redeemable']; ?></td>
									 <td><?php echo $attr['points_short_of_redumption']; ?></td>
                                                 
													<!--<td><input type="checkbox" name="assignConsumer[]" class="assignConsumer" /></td>-->

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
								<?php   echo anchor("product/list_consumers_loyalty_summary/", '<i class="ace-icon fa fa-list bigger-130"> Back to List</i>', array('class' => 'btn btn-xs btn-info','title'=>'Back'));  ?>
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



     

