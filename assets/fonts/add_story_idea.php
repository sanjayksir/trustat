<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); 
 	 //echo '<pre>';print_r($resData);exit;
	// echo '<pre>';print_r($this->session->userdata('user_id'));exit;
?>

<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.loadState('main-container')
        } catch (e) {
        }
    </script>
    <?php $this->load->view('../includes/admin_sidebar'); ?>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
                    <li> <a href="#">Editorial</a> </li>
                    <li class="active">Add Pitching Story Idea</li>
                </ul>
                <!-- /.breadcrumb -->
                <div class="nav-search" id="nav-search">
                    <form class="form-search">
                        <span class="input-icon">
                            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off">
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
                                <h3 class="header smaller lighter blue">Add Pitching Story Idea</h3>
                                     
                                     
                                      <div style="display:none;" class="alert alert-block alert-success" id="ajax_msg"></div>
                                     
                                     
                                     
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                    
                                    <div class="widget-box ui-sortable-handle" id="widget-box-1">
												<div class="widget-header">
													<h5 class="widget-title">Add Story Idea</h5>

													<div class="widget-toolbar">
														<div class="widget-menu">
															<a href="<?php echo base_url().'buzzadmn/Editorial/listing'; ?>">
																  Back
															</a>

															
														</div>

													</div>
												</div>

												<div class="widget-body">
													<div class="widget-main">
														
														
<form name="add_story_idea" id="add_story_idea" class="form-horizontal" action="#" method="POST">
                                                  
                                                         <div class="add-spidey">
                                                            <label>Story Title</label>
                                                            <textarea name="story_idea" cols="40" rows="10" class="form-control" placeholder="Story Title" id="story_idea"><?php echo $resData[0]['title']; ?></textarea>
                                                        </div>
                                                         <div class="space-2"></div>
                                                        <div class="add-spidey">
                                                            <div class="row">
                                                                <div class="col-xs-2 col-sm-2"><label>Estimated Time of Arrival </label> <br>
                                                                    <input type="text" value="<?php echo $resData[0]['eta']; ?>" name="eta" value="" class="form-control" id="eta" placeholder="Time in Hrs">
                                                                </div>
                                                                <div class="col-xs-6 col-sm-6">
                                                                &nbsp;
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="space-6"></div>
                                                        
                                                        <div class="add-spidey">
                                                         	<input type="hidden" name="storyId" id="storyId" value="<?php if($this->uri->segment(4)!=''){echo $this->uri->segment(4);} ?>" />
                                                            <input type="hidden" name="hiddenval" id="hiddenval" value="1" />
                                                             <input class="btn btn-default my_button" type="submit" name="saveBtn" value="Save" id="saveBtn" />
                                                             <input class="btn btn-default my_button" type="submit" name="submitBtn" value="Submit" id="submitBtn" />
                                                             <input type="hidden" name="clickedBtn" id="clickedBtn" />
                                                        </div>
                                                  
                                                   </form>
                                                    <!--</form>-->
                                                        
                                                        
                                                        
                                                        
													</div>
												</div>
											</div>
                                    
                                    
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- PAGE CONTENT ENDS -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.page-content -->
                </div>
            </div>
            <!-- /.main-content -->
            <?php $this->load->view('../includes/admin_footer'); ?>            
<script>
<!------------------------ Validate Fom Add Idea----------------------------->
$('.my_button').click(function() {
           var  clickedButton = $(this).val();
		   $("#clickedBtn").val(clickedButton);
		   
        });
 
 $(document).ready(function(){	
 	
	var clickedButton = '';
	var url='addStoryIdea';
	if($("#storyId").val()!=''){
		url='editStoryIdea';
	}
	
	 	$("form#add_story_idea").validate({
		rules: {
			story_idea: {
						 required: true
					  },
			eta:{
						 required: true
					  } 
		},
		messages: {
				story_idea: {
					required: "Please Enter Story Idea"
				}, 
				eta: {
					required: "Please Enter Estimated Time" 
				} , 
				 
		},
		submitHandler: function(form) { 
			var Idea;
			var art ='<i class="ace-icon fa fa-check green"></i>';
			var dataSend 	= $("#add_story_idea").serialize();
   			$.ajax({
				type: "POST",
				dataType:"json",
				beforeSend: function(){
						//$(".show_loader").show();
 						//$(".show_loader").click();
				},
				url: "<?php echo base_url(); ?>buzzadmn/editorial/"+url,
				data: dataSend,					
				success: function (msg) {
					if(parseInt(msg)!=2){
						if(parseInt(msg)==1){
							Idea = "Submitted";	
						}
						else{
							Idea = "Saved";	
						}
						
						 $('#ajax_msg').html(art+ "  Idea  "+Idea+" Successfully!").css("color","green").show();
 						 if($('#storyId').val()==''){
							 $('#add_story_idea')[0].reset(); 
						 }
						 
						// window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/myspidey_user_master/add_user/";						
					}else{
						 $('#ajax_msg').html(" Error in Save Data!").css("color","red").show();
					}
 				},
				complete: function(){
					//$(".show_loader").hide();
  				}
			});
			 return false;
 		}
	});
});
 </script>