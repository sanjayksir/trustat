<?php $this->load->view('../includes/admin_header');?>

<?php $this->load->view('../includes/admin_top_navigation');?>

 <div class="main-container ace-save-state" id="main-container"> 

  <script type="text/javascript">

				try{ace.settings.loadState('main-container')}catch(e){}

			</script>

  <?php $this->load->view('../includes/admin_sidebar');?>

  

  <div class="main-content">

    <div class="main-content-inner">

      <div class="breadcrumbs ace-save-state" id="breadcrumbs">

        <ul class="breadcrumb">

          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo site_url(); ?>">Home</a> </li>
			
		 				<?php $constant = "Activate Codes " ; ?>	
          <li class="active">Administration</li><li class="active"><?php echo $constant;?></li>

        </ul>

        <!-- /.breadcrumb -->

        

        

        <!-- /.nav-search --> 

      </div>

      <div class="page-content">

        <div class="row">

          <div class="col-xs-12">

            <div class="row">

              <div class="col-xs-12">

               <!--  <h3 class="header smaller lighter blue"><?php echo $constant;?></h3>-->

                 <?php if($this->session->flashdata('success')): ?>

                <div class="alert alert-block alert-success">

                  <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>

                  <i class="ace-icon fa fa-check green"></i> <span id="msgSucc"></span><?php echo $this->session->flashdata('success'); ?> </div>

                <?php endif; ?>

                

                <!--<div class="table-header">

											Results for "Locations"

										</div>--><br>

                <div class="row">

                  <div class="col-xs-12">

                    

                    <!--left end---->

                    

                    <div class="col-xs-12">

                      <div class="tab-pane fade active in">

                        <?php //$this->load->view('add_menu_form_tpl');?>

                        <div class="row">

                          <div class="col-xs-12">

                            <div class="row" id="add_edit_div">

                              <?php  $this->load->view('details_activate_twin_codes_right_tpl'); ?>

                            </div>

                          </div>

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

                

                <!-- div.table-responsive --> 

                <!-- div.dataTables_borderWrap --> 

              </div>

            </div>

            <!-- PAGE CONTENT ENDS --> 

          </div>

          <!-- /.col --> 

        </div>

        <!-- /.row --> 

      </div>

      <!-- /.page-content --> 

    </div>

  </div><div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						 


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

  <!-- /.main-content --> 

  

</div>

<!-- /.main-container -->



<div class="modal fade" id="myModal" role="dialog">

  <div class="modal-dialog"> <span id="edit_popup_model"> </span> 

    

    <!-- Modal content-->

    <div class="modal-content"></div>

  </div>

</div>

<div class="modal fade" id="addModal" role="dialog">

  <div class="modal-dialog"> <span id="add_modal_popup"> </span> 

    

    <!-- Modal content-->

    <div class="modal-content"></div>

  </div>

</div>

<script>

	

 	<!------------------------ Validate Fom Add Menu Data----------------------------->



 $(document).ready(function(){	

 	jQuery.validator.addMethod("noSpace", function(value, element) { 

	return value.indexOf(" ") < 0 && value != ""; 

	}, "No space please");

 

 

	$("form#user_frm").validate({

		rules: {
  			/*
			 coupon_number: {
			 	 required: true,
                 minlength: 2,
 				maxlength: 25 
				},
				*/	
  		},

		messages: {
			/*
 				coupon_number: {
					required: "Please enter Coupon Number.",
					minlength: "Please enter a valid Coupon Number." ,
					maxlength : "Please enter a valid Coupon Number." 
				}, 
				
				*/

		},

		
		submitHandler: function(form) {
    		var formData;
			var dataSend 	= $("#user_frm").serialize();
			// formData 		= new FormData();
  			// var formData = new FormData(form); 
   			$.ajax({
				type: "POST",
				beforeSend: function(){
					//$("#overlay").show();
 				},
				url: "<?php echo base_url(); ?>order_master/update_activate_twin_codes/",
				data: dataSend,
  				success: function (msg) {
					setTimeout(function() {
 						  window.location.href="<?php echo base_url().'order_master/list_printed_batches';?>";
					  }, 2000); 
				}
			});
  		}
		
		
	});

});

 </script>

<?php $this->load->view('../includes/admin_footer');?>

