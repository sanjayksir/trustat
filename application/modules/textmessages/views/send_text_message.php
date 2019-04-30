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

                        <a href="#">Text Message</a>

                    </li>

                    <li class="active">Send Text Message</li>

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

                

                 <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>
 <h4 class="widget-title">Send Text Message</h4>
      <form name="user_frm" id="user_frm" action="#" method="POST">
	  <?php $customer_id 	= $this->session->userdata('admin_user_id'); ?>
		<!--
		<input type="hidden" value="<?php //echo NumberOfAllConsumersOfACustomer($customer_id); ?>" name="quantity" id="quantity" />
        <div class="widget-main">
		 <div class="col-sm-6">
			 <label for="form-field-8">This Message will be delivered to <b><?php //$customer_id 	= $this->session->userdata('admin_user_id');
			//echo NumberOfAllConsumersOfACustomer($customer_id); ?> Consumers</b>, who are already aware about your Products</label>
			  -->
			  <div class="form-group row">
                                  <div class="col-sm-12">
                                  <label for="form-field-8">Select Consumers</label><?php 
						  // echo $csc_consumer_min_age . "<br>";
						    //echo $csc_consumer_max_age . "<br>";
							 //echo $csc_consumer_gender . "<br>";
							  //echo $csc_consumer_city . "<br>";
							  //echo $csc_consumer_pin . "<br>";
							 function reverse_birthday( $years ){
								return date('Y-m-d', strtotime($years . ' years ago'));
								}
								if($csc_consumer_min_age=='0') {
								$csc_consumer_min_dob = '';
									} else {
								$csc_consumer_min_dob = reverse_birthday( $csc_consumer_min_age );
									}
								if($csc_consumer_max_age=='0') {
								$csc_consumer_max_dob = '';
									} else {
								$csc_consumer_max_dob = reverse_birthday( $csc_consumer_max_age );
									}
									 ?>
                                  <select name="quantity" id="quantity" class="form-control">
										<option value="All <?php echo NumberOfAllConsumersOfACustomer($customer_id); ?> Consumers">All Consumers (<?php echo NumberOfAllConsumersOfACustomer($customer_id); ?>)</option>
										<option value="Filtered <?php echo NumberOfSelectedConsumersByACustomer($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_min_dob, $csc_consumer_max_dob); ?> Consumers">Filtered Consumers (<?php echo NumberOfSelectedConsumersByACustomer($customer_id, $csc_consumer_gender, $csc_consumer_city, $csc_consumer_min_dob, $csc_consumer_max_dob); ?>)</option>	
								  </select>
								  
                                  </div>
                                  </div>				 
			  
			  <textarea  class="form-control" name="text_message" placeholder="Write your text message..." maxlength="500" required ></textarea>
			<br /><input class="btn btn-info" type="submit" name="submit" value="Send" id="savemenu" />
			</div>
		
		     <div style="height:210px">    
				</div>
        
      </form>
	  
		
		
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

function add_question_to_product(text_message,quantity){
	var r = confirm("Please confirm to Send this Text Message");
	if (r == true) {
		
	
		$.ajax({
			dataType:'html',
			type:'POST',
			url:'<?php echo base_url().'textmessages/push_text_message_request/';?>',
			data:{text_message:text_message,quantity:quantity},
			success:function (msg){
			}
		
		});
	} else{
		return false;
	} 
}
 
</script>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

            </a>

        </div><!-- /.main-container -->



     

