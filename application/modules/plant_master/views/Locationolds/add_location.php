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
			
		 				<?php if($this->uri->segment(2)=='edit_location'){

								  	$constant = "Edit location" ;

                              }else{ // $this->load->view('add_member_right_tpl'); 
							  $constant = "Add location" ;

					 			}?>	
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

               <!-- <h3 class="header smaller lighter blue"><?php echo $constant;?></h3> -->

                 <?php if($this->session->flashdata('success')): ?>

                <div class="alert alert-block alert-success">

                  <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>

                  <i class="ace-icon fa fa-check green"></i> <span id="msgSucc"></span><?php echo $this->session->flashdata('success'); ?> </div>

                <?php endif; ?>

                

                <!--<div class="table-header">

											Results for "Locations"

										</div>-->

                <div class="row">

                  <div class="col-xs-12">

                    

                    <!--left end---->

                    

                    <div class="col-xs-12">

                      <div class="tab-pane fade active in">

                        <?php //$this->load->view('add_menu_form_tpl');?>

                        <div class="row">

                          <div class="col-xs-12">

                            <div class="row" id="add_edit_div">

                              <?php if($this->uri->segment(2)=='edit_location'){

								  	$this->load->view('edit_location_tpl'); 

                              }else{  $this->load->view('add_location_tpl'); 

					 			}?>

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

	$(document).ready(function() {

		// Data table options setting

	    $('table.display').DataTable(

	    	{

	    		'bPaginate' : false, 

	    		'paging'    : false,

	    		'sDom'		: "lfrti",

	    		'info'		: false,

	    	}

	    );



	    // Fix data-table width 100%

	    $('table').css('width', '100%');



	    $("#submit_country").click(function(event) { });



		$("#submit_state").click(function(event) { });



		// Add City Data

		$("#submit_city").click(function(event) { });



		// Add Area Data

		$("#submit_area").click(function(event) { });



	});

 	<!------------------------ Validate Fom Add Menu Data----------------------------->
function get_related_city_list(val){
		$.ajax({
 				type: "POST",
 				dataType:"html",
 				beforeSend: function(){
 				},
				url: "<?php echo base_url(); ?>user_master/get_city_list/",
 				data: {state_id :val},
				success: function (msg) {
				$("#city_name").html(msg);
					}
				});

}

get_related_city_list('<?php echo $get_user_details[0]['state'];?>')
 $(document).ready(function(){	

 	

	jQuery.validator.addMethod("noSpace", function(value, element) { 

	return value.indexOf(" ") < 0 && value != ""; 

	}, "No space please");

 

 

	$("form#user_frm").validate({
 		rules: {
   			location_name:{
 						 required: true,
						 remote: {
                        	 	url: "<?php echo base_url().'plant_master/';?>checkLocationName",
                          	type: "post",
 							data: {  location_id: $( "#location_id" ).val() }
                     	 }
 					  },
			location_type: {
			 	 required: true
			 },		  
 			location_email: {
						required: true,
            			 email: true/*,
 						 remote: {
                        	 	url: "<?php echo base_url().'plant_master/';?>checkUnameEmail",
                          	type: "post",
 							data: {  userid: $( "#user_id" ).val() }
                     	 }*/

       		},
  			user_mobile: {
			 	 required: true,
				 digits: true, 
                 minlength: 10,
 				 maxlength:12
			 },
 			gst: {
			 	 required: true,
				 minlength:14,
 				 maxlength:14
				 //digits: true
			},
			address: {
			 	 required: true
 			}	
  		},
 		messages: {
 				location_name: {
 					required: "Please enter Location Name",
					remote: "Location Already Exists!!" 
				}, 
				location_type: {
 					required: "Please Select Location Type" 
				}, 
  				location_email: {
 					required: "Please enter Email",
					email: "Please enter valid Email"
 					//remote: "Email already exists!" 
 				},
				user_mobile: {
					required: "Please enter Mobile No.",
					digits:"Only Numeric value accepted",
 					minlength: "Please enter valid Number",
					maxlength: "This is not a phone no." 
 				},
				gst: {
 					required: "Please enter GST",
					//digits: "Only numeric value allowed",
					minlength: "GST Number can not be less than 14 digits",
					maxlength: "GST Number can not be more than 14 digits"
  				}, 
				address: {
 					required: "Please enter address"
   				}
 		},

		submitHandler: function(form) {
  			var formData;
 			var dataSend 	= $("#user_frm").serialize();
 		/*	formData 		= new FormData();
 			formData.append('file', $('#file')[0].files[0]);
  			formData.append("newdata",dataSend);*/
 
 			$.ajax({
 				type: "POST",
 				dataType:"json",
 				beforeSend: function(){
 						$(".show_loader").show();
  						$(".show_loader").click();
 				},
 				url: "<?php echo base_url(); ?>plant_master/save_location/",
 				data: dataSend,
				success: function (msg) {
					if(parseInt(msg)==1){
						$('#ajax_msg').text("Location Added Successfully!").css("color","green").show();
						$('#blah').attr('src', '').hide();
						$('#user_frm')[0].reset(); 
						  window.location.href="<?php echo base_url(); ?>plant_master/list_locations/";						
					}
					else if(parseInt(msg)==2){
						$('#ajax_msg').text("Location Aalready Exists!").css("color","red").show();
  					      window.location.href="<?php echo base_url(); ?>plant_master/list_locations/";						
					}
					else{
						$('#ajax_msg').text("Error in saving data!").css("color","red").show();
						$('#blah').attr('src', '').hide();
						$('#user_frm')[0].reset(); 
						 window.location.href="<?php echo base_url(); ?>plant_master/list_locations/";						
					}
				},
				complete: function(){
					$(".show_loader").hide();
				}
			});
			 return false;
 		}
	});

});

 </script>

<?php $this->load->view('../includes/admin_footer');?>

