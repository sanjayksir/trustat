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
			
		 				<?php $constant = "Registered Product - Verify invoice" ; ?>	
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

                <h3 class="header smaller lighter blue"><?php echo $constant;?></h3>

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

                              <?php  $this->load->view('details_loyalty_redemption_requests_right_tpl'); ?>

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
  			
			 invoice_number: {
			 	 required: true,
                 minlength: 2,
 				maxlength: 25 },
				
			purchase_date: {
			 	 required: true
				 },
				
			warranty_start_date: {
			 	 required: true
				 },	
			
			warranty_end_date: {
			 	 required: true
				 },

			expiry_date: {
			 	 required: true
				 },

			status: {
			 	 required: true
				 },

			seller_name: {
			 	 required: true,
                 minlength: 2,
 				maxlength: 100 },

			seller_gst: {
			 	 required: true,
                 minlength: 4,
 				maxlength: 15 },

			selling_price: {
			 	 required: true,
                 minlength: 1,
 				maxlength: 7 },

			discount: {
			 	 required: true,
                 minlength: 1,
 				maxlength: 7 }	
  		},

		messages: {
 				invoice_number: {
					required: "Please enter Invoice Number.",
					minlength: "Please enter a Invoice Number" ,
					maxlength : "Please enter a Invoice Number" 
				}, 
				
				purchase_date: {
					required: "Please enter Purchase Date.",
					minlength: "Please enter a Purchase Date" ,
					maxlength : "Please enter a Purchase Date" 
				},
				
				warranty_start_date: {
					required: "Please enter warranty start date.",
					minlength: "Please enter a warranty start date" ,
					maxlength : "Please enter a warranty start date" 
				},
				
				warranty_end_date: {
					required: "Please enter warranty end date. ",
					minlength: "Please enter a warranty end date" ,
					maxlength : "Please enter a warranty end date" 
				},
				
				expiry_date: {
					required: "Please enter expiry date.",
					minlength: "Please enter a expiry date." ,
					maxlength : "Please enter a expiry date." 
				},
				
				status: {
					required: "Please enter status.",
					minlength: "Please enter a status." ,
					maxlength : "Please enter a status." 
				},
				
				seller_name: {
					required: "Please enter seller name.",
					minlength: "Please enter a seller name." ,
					maxlength : "Please enter a seller name." 
				},
				
				seller_gst: {
					required: "Please enter seller GST.",
					minlength: "Please enter a seller GST." ,
					maxlength : "Please enter a seller GST." 
				},
				
				selling_price: {
					required: "Please enter selling price.",
					minlength: "Please enter a selling price." ,
					maxlength : "Please enter a selling price." 
				},
				
				discount: {
					required: "Please enter discount.",
					minlength: "Please enter a discount" ,
					maxlength : "Please enter a discount" 
				}

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
				url: "<?php echo base_url(); ?>product/update_registered_products_by_consumers/",
				data: dataSend,
  				success: function (msg) {
					setTimeout(function() {
 						  window.location.href="<?php echo base_url().'product/list_registered_products_by_consumers';?>";
					  }, 2000); 
				}
			});
  		}
		
		
	});

});

 </script>

<?php $this->load->view('../includes/admin_footer');?>

