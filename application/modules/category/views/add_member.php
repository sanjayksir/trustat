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
          <li class="active">Administration</li><li class="active">Add Members</li>
        </ul>
        <!-- /.breadcrumb -->
        
        <div class="nav-search" id="nav-search">
          <form class="form-search">
            <span class="input-icon">
            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
            <i class="ace-icon fa fa-search nav-search-icon"></i> </span>
          </form>
        </div>
        <!-- /.nav-search --> 
      </div>
      <div class="page-content">
        <div class="row">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <h3 class="header smaller lighter blue">Add Members</h3>
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
                    <div class="col-xs-6">
                      <?php //if($this->uri->segment(3)==''){?>
                      <div class="row">
                        <?php  $this->load->view('tree_list_left_tpl');?>
                      </div>
                      <?php //}?>
                    </div>
                    <!--left end---->
                    
                    <div class="col-xs-6">
                      <div class="tab-pane fade active in">
                        <?php //$this->load->view('add_menu_form_tpl');?>
                        <div class="row">
                          <div class="col-xs-12">
                            <div class="row" id="add_edit_div">
                              <?php if($this->uri->segment(3)=='edit_user'){
								  	$this->load->view('edit_member_right_tpl'); 
                              }else{  $this->load->view('add_member_right_tpl'); 
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
 $(document).ready(function(){	
 	
	jQuery.validator.addMethod("noSpace", function(value, element) { 
	return value.indexOf(" ") < 0 && value != ""; 
	}, "No space please");
 
 
	$("form#user_frm").validate({
		rules: {
			rwa_name: {
						 required: true
					  },
			user_name:{
						 required: true,
						 noSpace: true
					  },
			user_group:{
					required: true
				},
		    user_email: {
            			 email: true,
						 remote: {
                       	 	url: "<?php echo base_url().'myspidey_user_group_permissions/myspidey_user_master/';?>checkUnameEmail",
                         	type: "post",
							data: {  userid: $( "#user_id" ).val() }
                    	 }
       		} ,
			 user_mobile: {digits: true, 
                minlength: 10,
				maxlength:12},
				
		},
		messages: {
				rwa_name: {
					required: "Please enter RWA Name"
				}, 
				user_name: {
					required: "Please enter User Name" 
				} , 
				user_group: {
					required: "Please enter Group Name" 
				} , 
				user_email: {
					required: "Please enter valid Email",
					remote: "Email already exists!" 
				},
				user_mobile: {
					digits:"Only Numeric value accepted",
					minlength: "Please enter valid Number" 
				}  
		},
		submitHandler: function(form) {
 			var formData;
			var dataSend 	= $("#user_frm").serialize();
			formData 		= new FormData();
			formData.append('file', $('#file')[0].files[0]);
 			formData.append("newdata",dataSend);
			 
 			$.ajax({
				type: "POST",
				dataType:"json",
				beforeSend: function(){
						$(".show_loader").show();
 						$(".show_loader").click();
				},
				url: "<?php echo base_url(); ?>myspidey_user_group_permissions/myspidey_user_master/save_user/",
				data: formData,
				async: false,
				cache: false,	
				contentType: false,  // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
				processData: false, // NEEDED, DON'T OMIT THIS	
						
				success: function (msg) {
					if(parseInt(msg)==1){
						$('#ajax_msg').text("User Added Successfully!").css("color","green").show();
						$('#blah').attr('src', '').hide();
						$('#user_frm')[0].reset(); 
						 window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/myspidey_user_master/add_user/";						
					}
					else if(parseInt(msg)==2){
						$('#ajax_msg').text("User Aalready Exists!").css("color","red").show();
  					     window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/myspidey_user_master/add_user/";						
					}
					else{
						$('#ajax_msg').text("Error in saving data!").css("color","red").show();
						$('#blah').attr('src', '').hide();
						$('#user_frm')[0].reset(); 
						window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/myspidey_user_master/add_user/";						
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
