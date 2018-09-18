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
                                    <th class="hidden-480">Customer Name</th>
                                    <th class="hidden-480">Text Message</th>
                                    <th class="hidden-480">Send/Un-push</th>
                                    <th>Date Time of request</th>
									<th>Sent Status</th>
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
										$push_message_req_status = $attr['send_status'];
                                            if($push_message_req_status=='0'){
											$push_message_req_status ='Waiting for Message pushed approval';
 												$colorStyle="style='color:white;border-radius:10px;background-color:yellow;border:none;pointer-events: none;'";
											} elseif($push_message_req_status ==1){
											$push_message_req_status ='Message pushed successfully';
												$colorStyle="style='color:black;border-radius:10px;background-color:green;border:none;pointer-events: none;'";
												} else{
											$push_message_req_status ='Request to Push Message';
												$colorStyle="style='color:black;border-radius:10px;background-color:gray;border:none;'";
												}
												?>
                            <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $attr['customer_id']; ?></td>
                                <td><?php echo $attr['text_message']; ?></td>
												                                
												                                
                                       <td>	<?php 
	$user_id 	= $this->session->userdata('admin_user_id');
	
	if($user_id=='1') {

		//if($attr['push_ad_req']!=''){
	?>
	<input <?php 
	
	if($attr['send_status']==1){ ?>checked="checked"<?php } ?> id="product_<?php echo $attr['id'];?>"name="addquestion" class="ace" onclick="return add_question_to_product('<?php echo $attr['customer_id'];?>','<?php echo $attr['id'];?>','<?php echo $attr['text_message']; ?>');" type="checkbox">
	<span class="lbl"></span>
	<?php //} else { echo "No Ad Push Request"; } ?>
	
	<?php } else { } ?>	  </td>
								<td> <?php echo $attr['request_date']; ?> </td>
                                <td> <span <?php echo $colorStyle; ?>> &nbsp&nbsp  <?php echo $push_message_req_status ;?> &nbsp&nbsp </span>

								</td>                     
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

function add_question_to_product(customer_id, id, text_message){
	var r = confirm("Are Sure to do this?");
	if (r == true) {
		if ($("#product_"+id).prop('checked')==true){ 
			var Chk =1; 
		}else{
			var Chk =0;
		}
	
		$.ajax({
			dataType:'html',
			type:'POST',
			url:'<?php echo base_url().'textmessages/send_text_message/';?>',
			data:{c_id:customer_id,m_id:id,text_message:text_message,Chk:Chk},
			success:function (msg){
			}
		
		});
	} else{
		return false;
	} 
}

function change_status(id,val){
	if(confirm("Hey, this is final submission of Push Ad Request, you can not cancel it, press OK to confirm or Cancel it.")){
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



     

