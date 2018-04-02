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

        <!-- /.breadcrumb -->

        

        <div class="nav-search" id="nav-search">

        
        </div>

        <!-- /.nav-search --> 

      </div>

      <div class="page-content">

        <div class="row">

          <div class="col-xs-12">

            <div class="row">

              <div class="col-xs-12">

                <h3 class="header smaller lighter blue">Manage Password</h3>

 					<!--<div class="clearfix" style="background-color:white;border-top: none;padding:0px;">

                                    <input class="btn btn-info" name="edit_pro" value="Edit Profile" id="edit_pro" type="button" onclick="javascrit:window.location.href='<?php echo base_url();?>user_master/edit_user/'">

                     </div>-->
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

                          <?php //echo '<pre>';print_r($userData);?>

                            <div class="widget-header">

                              <h4 class="widget-title">Profile View</h4>

                              <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

                            </div>

                            <div class="widget-body">

                              <form name="frm" id="frm" action="#" method="POST">

                                <div class="widget-main">

                                  <div>

                                    <label for="form-field-8"><b>User Name:</b></label>

                                    <span><?php echo $userData[0]['user_name']; ?></span>

                                  </div>

                                  <hr>

                                  <div>

                                    <label for="form-field-9"><b>Mobile No:</b></label>

                                    <span><?php echo $userData[0]['mobile_no']; ?></span>

                                  </div>

                                <hr>

                                   <div>

                                    <label for="form-field-9"><b>Email Id:</b></label>

                                    <span><?php echo $userData[0]['email_id']; ?></span>

                                  </div>

                                  <hr>

                                  

                                  <!--<div>

                                    <label for="form-field-9"><b>profile Pic:</b></label>

                                    <span>

									<?php if(file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$userData[0]['profile_photo'])){?>

									<img src="<?php echo base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$userData[0]['profile_photo'];?>" width="200px" />

									<?php }else{?>

										<img src="<?php echo base_url().'uploads/noimage/300x169.png';?>" width="200px" />

									<?php }?>

									

									<?php //echo $userData[0]['profile_photo']; ?></span>

                                  </div>-->

                                  

                                  

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

			password: "required",

				cpassword: {

					required: true,

					equalTo: "#password"

				}

			},

			messages: {

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

				url: "<?php echo base_url(); ?>myspidey_login/reset_password/",

				data: {form_data:dataSend},

				//async: true,				

				success: function (msg) {

					$("#ajax_msg").html("Password has been updated successfully!").show();

					 

				},

				complete: function(){

					$(".show_loader").hide();

				}

			});

 		}

	});

});

<!------------------------ Validate Fom----------------------------->

</script>

<?php $this->load->view('../includes/admin_footer');?>

