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

          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo DASH_B;?>">Home</a> </li>

          <li class="active">Manage Password</li>

        </ul>
 

      </div>

      <div class="page-content">

        <div class="row">

          <div class="col-xs-12">

            <div class="row">

              <div class="col-xs-12">

                <h3 class="header smaller lighter blue">Manage Password</h3>

                <div id="ajax_msg" class="alert alert-block alert-success" style="display:none;"><i class="ace-icon fa fa-check green"></i></div>

                <?php if($this->session->flashdata('success')): ?>

                <div class="alert alert-block alert-success"> <i class="ace-icon fa fa-check green"></i> <?php echo $this->session->flashdata('success'); ?> </div>

                <?php endif; ?>

                

                <!--<div class="table-header">

											Results for "Locations"

										</div>--><br>

                <div class="tab-pane fade active in">

                  <div class="row">

                    <div class="col-xs-12">

                      <div class="row" id="add_edit_div">

                        <div class="col-xs-12">

                          <div class="widget-box">

                            <div class="widget-header">

                              <h4 class="widget-title">Change Password</h4>

                              <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

                            </div>

                            <div class="widget-body">

                              <form name="frm" id="frm" action="#" method="POST">

                                <div class="widget-main">
								<div>

                                    <label for="form-field-8">Old Password</label>

                                    <input name="oldpassword" id="oldpassword" type="password" class="form-control" placeholder="Old Password">

                                  </div>

                                  <div>

                                    <label for="form-field-8">New Password</label>

                                    <input name="password" id="password" type="password" class="form-control" placeholder="New Password">

                                  </div>

                                  <hr>

                                  <div>

                                    <label for="form-field-9">Confirm Password</label>

                                    <input name="cpassword" id="cpassword" type="password" class="form-control"  placeholder="Confirm Password">

                                  </div>

                                  <hr>

                                  <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

                                    <input class="btn btn-info" type="submit" name="submit" value="Save Password" id="savepassword" />

                                  </div>

                                </div>

                              </form>

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

<script>

<!------------------------ Validate Fom Add Menu Data----------------------------->

 $(document).ready(function(){	

	$("form#frm").validate({

		rules: {
			oldpassword:{required:true,
							remote: {
									url: "<?php echo base_url().'backend/';?>checkUserPassword",
										type: "post",
										data: {  pass: $( "#oldpassword" ).val() }
							}
			},
			password: "required",
 				cpassword: {
 					required: true,
 					equalTo: "#password"
 				}

			},

			messages: {
				oldpassword:{ required:" Enter Old Password",
								remote:" Enter Correct Password",},
				password: " Enter Password",

				cpassword: { 

                 	required:"Confirm  password is required",

					equalTo:"Confirm Password Same as Password"

               }

			},

		submitHandler: function(form) {

		  var dataSend = $("#frm").serialize();

		  $.ajax({

				type: "POST",

				//contentType: "application/json; charset=utf-8",

     			// dataType: "text",

				beforeSend: function(){

						$(".show_loader").show();

						$(".show_loader").click();

				},

				url: "<?php echo base_url(); ?>backend/reset_password/",

				data: {form_data:dataSend},

				//async: true,				

				success: function (msg) {

					$("#ajax_msg").html("Password has been updated successfully!").show();

					 

				},

				complete: function(){

					$('#frm')[0].reset(); 

					$(".show_loader").hide();

				}

			});

 		}

	});

});

<!------------------------ Validate Fom----------------------------->

</script>

<?php $this->load->view('../includes/admin_footer');?>

