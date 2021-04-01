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

                        <a href="#">Master Data</a>

                    </li>

                    <li class="active">Send Request Purchase Points</li>

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
 <h4 class="widget-title">Send Request Purchase Points</h4>
      <form name="user_frm" id="user_frm" action="#" method="POST">
	  <?php $customer_id 	= $this->session->userdata('admin_user_id'); ?>
		<!----<input type="hidden" value="<?php //echo NumberOfAllConsumersOfACustomer($customer_id); ?>" name="quantity" id="quantity" />-->
        <div class="widget-main">
		 <div class="col-sm-6">
			
			<!--<label for="form-field-8">This Message will be delivered to <b><?php //$customer_id 	= $this->session->userdata('admin_user_id'); echo NumberOfAllConsumersOfACustomer($customer_id); ?> Consumers</b>, who are already aware about your Products</label>-->
			
			
			 
			  
			  
		<div class="form-group row">
		  <div class="col-sm-6">
			  <label for="form-field-8">Enter Points(Number Only)</label>
             <input name="purchasing_points" id="purchasing_points" type="number" class="form-control" placeholder="Enter Points(Number Only)" maxlength="12" required>
		  </div>
			
		</div>
		
		<div class="form-group row">
		  
			<div class="col-sm-12">
			   <textarea  class="form-control" name="text_comments" placeholder="Write your text message..." maxlength="500" required ></textarea>
			</div>
		</div>
		
			<br /><input class="btn btn-info" type="submit" name="submit" value="Purchase" id="savemenu" /> 
			<a href="<?php echo base_url('/textmessages/approve_purchase_points_requests') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">List Purchase Points <?php echo $label; ?> </a>
			<a href="<?php echo base_url('/backend/dashboard') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to Home <?php echo $label; ?> </a>
			</div>
		
		     <div style="height:210px">    
				</div>
        
      </form>
	  
		
		
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

function add_question_to_product(text_comments,purchasing_points){
	var r = confirm("Please confirm to Send this Request to Purchase Points");
	if (r == true) {
		
	
		$.ajax({
			dataType:'html',
			type:'POST',
			url:'<?php echo base_url().'textmessages/purchase_points/';?>',
			data:{text_comments:text_comments,purchasing_points:purchasing_points},
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



     

