<?php  // echo '<pre>';print_r($edit_customer_code_tpl);exit;?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">Reply Consumer Complaint</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
		<form name="user_frm" id="user_frm" action="#" method="POST">
			<input type="hidden" name="complaint_id" id="complaint_id" value="<?php echo $get_registered_products_by_consumers_details[0]['id'];?>" /><?php //echo $get_registered_products_by_consumers_details[0]['id']?>
			<input type="hidden" name="complain_code" id="complain_code" value="<?php echo $get_registered_products_by_consumers_details[0]['complain_code'];?>" />
			<input type="hidden" name="bar_code" id="bar_code" value="<?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?>" />
			<input type="hidden" name="consumer_id" id="consumer_id" value="<?php echo $get_registered_products_by_consumers_details[0]['consumer_id'];?>" />
			<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $get_registered_products_by_consumers_details[0]['customer_id'];?>" />
			<input type="hidden" name="product_id" id="product_id" value="<?php echo $get_registered_products_by_consumers_details[0]['product_id'];?>" />
			<input type="hidden" name="reply_by" id="reply_by" value="Customer" />
        <div class="widget-main">
		
		<div class="form-group row"> 
           <div class="col-sm-4">
				<label for="form-field-8"><b>Consumer Name</b> : </label>
				<?php echo getConsumerNameById($get_registered_products_by_consumers_details[0]['consumer_id']); ?>
 		    </div> 
            
            <div class="col-sm-4">
				<label for="form-field-8"><b>Consumer Phone</b> : </label>
				<?php echo getConsumerMobileNumberById($get_registered_products_by_consumers_details[0]['consumer_id']); ?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Product Code</b> : </label>
				<?php echo $get_registered_products_by_consumers_details[0]['bar_code'];?>
 		    </div>
  		</div>
		
		<div class="form-group row"> 
           <div class="col-sm-4">
				<label for="form-field-8"><b>Product Name</b> : </label>
				<?php echo get_products_name_by_id($get_registered_products_by_consumers_details[0]['product_id']);?>
 		    </div> 
            
            <div class="col-sm-4">
				<label for="form-field-8"><b>Complaint Code</b> : </label>
				<?php echo $get_registered_products_by_consumers_details[0]['complain_code'];?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Complaint Type</b> : </label>
				<?php echo $get_registered_products_by_consumers_details[0]['type'];?>
 		    </div>
			<div class="col-sm-12">
				<label for="form-field-8"><b>Complaint description</b> : </label>
				<?php echo $get_registered_products_by_consumers_details[0]['description'];?>
 		    </div>
			
  		</div>
		
		<div class="form-group row"  style="height:250px; overflow:scroll">
		
			<div class="col-sm-12">
				<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>#</th>
														<th>Response By</th>
														<th>Comments</th>
														<th>Date Time</th>
  													</tr>
												</thead>
												<tbody>

                                        <?php $i = 0;  //  echo '***<pre>';print_r($orderListing);
										if(count($get_responses_consumer_complaint)>0){
											$i=0;
                                        $page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
									$sno =  $page + 1;
                                        foreach ($get_responses_consumer_complaint as $key=>$listData){
											$i++;
											?>
                                               <tr id="show<?php echo $key; ?>">
											   <td><?php echo $sno;$sno++; ?></td>
											   <td><?php if($listData['reply_by']=='Customer') { echo getUserFullNameById($listData['customer_id']); } 
											    else { echo getConsumerNameById($listData['consumer_id']); }
											   
											    ?></td>
											   <td><?php echo $listData['comments']; ?></td>
												<td><?php echo $listData['date_time']; ?></td>
												 
                                              </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
                                       
                                    </tbody>
											</table>
		

 		    </div>
		</div>
		
		<div class="form-group row">
		<div class="col-sm-4">
				<!--<label for="form-field-8"><b>Complaint Status</b> : </label>-->
				<select  name="status" id="status" class="form-control" required>
							<option value=""> - Please Select The Complaint Status - </option>
							<option value="Open">Open</option>
						    <option value="Closed">Closed</option>
				</select>

 		 </div>
			<div class="col-sm-12">
				<!--<label for="form-field-8"><b>Your Reply </b>: </label>-->
		<textarea  class="form-control" name="comments" placeholder="Write your comments and press Send to Reply."  maxlength="5000"></textarea>	

 		    </div>
		</div>
		
          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

           <input class="btn btn-info" type="submit" name="submit" value="Send" id="savemenu"  onClick="this.disabled; this.value='Saving…';" /> 
		   
		   <a href="<?php echo base_url('reports/list_complaint_log') ?>" class="btn btn-info" title="Back to List Location Types">Back to List Complaints <?php echo $label; ?> </a>
		   
		  

          </div>

        </div>

      </form>
		</div>
</div>
</div>
<script type="text/javascript">
 	function readURL(input) {
 		 if (input.files && input.files[0]) {
 			var reader = new FileReader();
 			 reader.onload = function (e) {
 				$('#blah').attr('src', e.target.result).show();
 			}
 			 reader.readAsDataURL(input.files[0]);
 		}
 	}
  </script>
