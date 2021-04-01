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

                    <li class="active">Referral MIS Report</li>

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
                                <h5 class="widget-title bigger lighter">Referral MIS Report <?php if($this->session->userdata('admin_user_id')==1){ echo "for " . getUserFullNameById($this->uri->segment(3)); }?> <?php //echo $this->uri->segment(3); ?>
								<div class="widget-toolbar">
                                     <?php echo anchor('product/referral_mis_download/'.$this->uri->segment(3), 'Go to download report',array('class' => 'btn btn-xs btn-warning')); ?>
								</div>
								
								</h5>
								
                            </div>
							
                            <div class="widget-body">
                                <div class="row filter-box">
                                    <form id="form-filter" action="" method="get" class="form-horizontal" >
                                        <div class="col-sm-5">
                                            <label>Display
                                                <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
                                                <?php echo Utils::selectOptions('pagelimit',['options'=>$this->config->item('pageOption'),'value'=>$this->config->item('pageLimit')]) ?>
                                                </select>
                                            Records
                                            </label>
							<?php $Datetoday = date("m/d/Y"); ?>
							<?php $dateoneMAgo = date("m/d/Y",strtotime("-1 month")); ?>	
                                        </div>
										<div class="col-sm-2">  From Date(mm/dd/yyyy) : <br /><br />To Date(mm/dd/yyyy) :<br /><br />  </div>
                                        <div class="col-sm-5">
                                            <div class="input-group">
											<div class="input-group date" data-provide="datepicker">
                              <input type="text" name="from_date_data" id="from_date_data" readonly="readonly" value="<?php //echo $dateoneMAgo; ?>" class="form-control" />
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                        </div>
								  
								  <div class="input-group date" data-provide="datepicker">
                               <input type="text" name="to_date_data" id="to_date_data" readonly="readonly" value="<?php //echo $Datetoday; ?>" class="form-control" />
							      <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                                  </div>
								  <input type="hidden" name="c_date_data" id="c_date_data" value="<?php echo date('m/d/Y'); ?>" class="form-control" />	
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Referral Id, Product Name">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-inverse btn-white" onclick="DateCheck();"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                    <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
					<script type="text/javascript">											
								function DateCheck()
											{
											  var StartDate= document.getElementById('from_date_data').value;
											  var EndDate= document.getElementById('to_date_data').value;
											  var CurrentDate= document.getElementById('c_date_data').value;
											  var eDate = new Date(EndDate);
											  var sDate = new Date(StartDate);
											  var cDate = new Date(CurrentDate);
											  if(sDate> eDate || eDate> cDate)
												{
												alert("Please ensure that the End Date is greater than or equal to the Start Date. End Date is not greater than Current Date");
												return false;
												}
											}
											</script>				

                      <!--------------- Search Tab start----------------->
					  <div style="overflow-x:auto;">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="hidden-480">Referral Id</th>
                                    <th class="hidden-480">Date & time of Referral by Sender</th>
									<th class="hidden-480">Customer Name</th>
									<th class="hidden-480">Customer ID</th>
									<th class="hidden-480">Product Name</th>									
									<th class="hidden-480">Product ID</th>
									<th class="hidden-480">Sender Consumer Id</th>
                                    <th class="hidden-480">Sender Mobile Number</th>
                                    <th class="hidden-480">City of referral Sender</th>
                                    <th class="hidden-480">Pin Code of referral Sender</th>
                                    <th class="hidden-480">Latitude of referral Sender</th>
                                    <th class="hidden-480">Longitude of referral Sender</th>
                                    <th class="hidden-480">Loyalty Points given to Sender</th>
                                    <th class="hidden-480">Receiver Mobile Number </th>
									<!--<th class="hidden-480">Registration Address of Recevier Consumer of Referral</th>-->
									<th class="hidden-480">Registration City of Recevier Consumer of Referral</th>
									<th class="hidden-480">Registration Pin Code of Recevier Consumer of Referral</th>
                                    <th class="hidden-480">Registration Status of Recevier at the time of Referral </th>
                                    <th class="hidden-480">Receiver Consumer Id</th>
                                    <th class="hidden-480">Promotion Details</th>
                                    <th class="hidden-480">Product Code / Promotion Id</th>
                                    <th class="hidden-480">Link With Customer at the time of Referral</th>
                                    <th class="hidden-480">Referral Consumed</th>
                                    <th class="hidden-480">Recevier date of referral consumption</th>
                                    <th class="hidden-480">Loyalty points given to Recevier</th>
                                    <th class="hidden-480">Customer Loyalty Type</th>
                                    <th class="hidden-480">Watched Full Referral</th>
                                    <th class="hidden-480">Feedback Question 1</th>
									<th class="hidden-480">Response to Feedback Question 1</th>
                                    <th class="hidden-480">Feedback Question 2</th>
                                    <th class="hidden-480">Response to Feedback Question 2</th>
                                    <th class="hidden-480">Feedback Question 3</th>
                                    <th class="hidden-480">Response to Feedback Question 3</th>
                                    <th class="hidden-480">Feedback Question 4</th>
                                    <th class="hidden-480">Response to Feedback Question 4</th>
									
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
                                <td><div style="word-wrap:break-word; width:150px;"><?php echo $attr['referral_reference_id']; ?></div></td>
<td><div style="word-wrap:break-word; width:220px;"><?php echo(date('j M Y H:i:s D', strtotime($attr['referring_datetime'])));  ?></div></td>
				 <td><div style="word-wrap:break-word; width:200px;"><?php echo getUserFullNameById($attr['created_by']); ?></div></td>
				<td><div style="word-wrap:break-word; width:90px;"><?php echo $attr['created_by']; ?></div></td>
                                <td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['product_name']; ?></div></td>
					<td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['product_sku']; ?></div></td>
						<td><div style="word-wrap:break-word; width:150px;"><?php echo $attr['referrer_consumer_id']; ?></div></td>
						<td><div style="word-wrap:break-word; width:150px;"><?php echo getConsumerMobileNumberById($attr['referrer_consumer_id']); ?></div></td>
						
						<td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['geol_city']; ?></div></td>
                                <td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['geol_pin_code']; ?></div></td>
                                <td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['geol_latitude']; ?></div></td>
                                <td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['geol_longitude']; ?></div></td>
            <td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['loyalty_points_referral']; ?></div></td>
    <td><div style="word-wrap:break-word; width:100px;"><?php echo $attr['referred_mobile_no']; ?></div></td>
	<!--<td><div style="word-wrap:break-word; width:150px;"><?php if(getConsumerRegistrationAddressById($attr['referred_consumer_id'])==""){ echo "NA"; }else{ echo getConsumerRegistrationAddressById($attr['referred_consumer_id']); } ?></div></td>-->
	<td><div style="word-wrap:break-word; width:150px;"><?php if(getConsumerRegistrationCityById($attr['referred_consumer_id'])==""){ echo "NA"; }else{ echo getConsumerRegistrationCityById($attr['referred_consumer_id']); } ?></div></td>
	<td><div style="word-wrap:break-word; width:150px;"><?php if(getConsumerRegistrationPinCodeById($attr['referred_consumer_id'])==""){ echo "NA"; }else{ echo getConsumerRegistrationPinCodeById($attr['referred_consumer_id']); } ?></div></td>
	 <td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['rs_referred_consumer_TRUSTAT']; ?></div></td>
	<td><div style="word-wrap:break-word; width:200px;"><?php if($attr['referred_consumer_id']==0) { echo "This Mobile Number is not registered yet.";}else{ echo $attr['referred_consumer_id'];} ?></div></td>
	<td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['promotion_details']; ?></div></td>
    <td><div style="word-wrap:break-word; width:200px;"><?php if($attr['product_code_or_promotion_id']==0){ echo $attr['referral_reference_id']; }else{ echo $attr['product_code_or_promotion_id']; } ?></div></td>
<td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['rs_referred_consumer_customer']; ?></div></td>
<td><div style="word-wrap:break-word; width:100px;"><?php if($attr['referral_consumed']==1){ echo "Yes"; }else{ echo "No"; } ?></div></td>	
<td><div style="word-wrap:break-word; width:170px;"><?php if($attr['referral_consume_datetime']!=""){ echo(date('j M Y H:i:s D', strtotime($attr['referral_consume_datetime']))); }else{ echo "Not Applicable"; }  ?></div></td>
								
            <td><div style="word-wrap:break-word; width:200px;"><?php echo $attr['referral_consume_loyalty_points']; ?></div></td>
        <td><div style="word-wrap:break-word; width:100px;"><?php echo getCustomerLoyaltyTypeById($attr['created_by']); ?></div></td>
			<?php 
								include('url_base_con_db.php');
								?>
			<?php 
			$sqlRef1 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where promotion_id = '".$attr['referral_reference_id']."' ORDER BY id DESC";
											
								$resultRef1 = mysql_query($sqlRef1, $link) or die(mysql_error());
								//$number_of_answers=mysql_num_rows($result2);
								//$req_number_of_answers = 4-$number_of_answers;
								$row1 = mysql_fetch_assoc($resultRef1);
								if($row1['id']!=''){
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php								
								}
								?>
		
		
							<?php 
								$sqlRef2 = "select id, question_id, selected_answer FROM consumer_feedback where promotion_id = '".$attr['referral_reference_id']."' AND user_id = '".$attr['referred_consumer_id']."' ORDER BY id ASC";
											
								$resultRef2 = mysql_query($sqlRef2, $link) or die(mysql_error());
								$number_of_answers6 = mysql_num_rows($resultRef2);
								$req_number_of_answers6 = 4-$number_of_answers6;
								$row6 = mysql_fetch_assoc($resultRef2);
								if($row6['id']!=''){	
								?> <td style="text-align:center">	<?php echo get_question_by_id($row6['question_id']); ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row6['selected_answer']; ?></td> <?php
								while($row6s = mysql_fetch_array($resultRef2))
								{
								?> <td style="text-align:center">	<?php echo get_question_by_id($row6s['question_id']); ?></td> <?php	
								?> <td style="text-align:center">	<?php echo $row6s['selected_answer']; ?></td> <?php
								}								
								for($x = 0; $x <= $req_number_of_answers6-1; $x++) {
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									}
								}else{
								?> <td style="word-wrap:break-word; width:200px;">	<?php echo ""; ?></td> <?php
								?> <td style="word-wrap:break-word; width:200px;">	<?php echo ""; ?></td> <?php
								?> <td style="word-wrap:break-word; width:200px;">	<?php echo ""; ?></td> <?php
								?> <td style="word-wrap:break-word; width:200px;">	<?php echo ""; ?></td> <?php
								?> <td style="word-wrap:break-word; width:200px;">	<?php echo ""; ?></td> <?php
								?> <td style="word-wrap:break-word; width:200px;">	<?php echo ""; ?></td> <?php
								?> <td style="word-wrap:break-word; width:200px;">	<?php echo ""; ?></td> <?php
								?> <td style="word-wrap:break-word; width:200px;">	<?php echo ""; ?></td> <?php
								}
								?>
								
		
                               
                                
                           	<!--<td><input type="checkbox" name="assignProduct[]" class="assignProduct" /></td>-->

                                             </tr>

                                        <?php
                                        $sno++;
                                        } 
										}else{?>
											<tr><td align="center" colspan="35" class="color error">No Records Founds</td></tr>
										<?php }?>
										  <!--<tr id="show<?php //echo $attr['id']; ?>"><td colspan="8"><input class="btn btn-primary pull-right" type="button" id="assign" name="assign" value="Assign Product" /></td></tr>-->

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



     

