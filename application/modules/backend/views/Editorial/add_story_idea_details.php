<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); ?>
<div class="main-container ace-save-state" id="main-container">
 <?php $this->load->view('../includes/admin_sidebar');// echo '***<pre>';print_r($storyIdea);?>
 
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
                    
                    <li class="active">Add Product Media</li>
                </ul>
                <!-- /.breadcrumb -->

                
                <!-- /.nav-search -->
            </div>
            <div class="page-content">
                 
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 class="header smaller lighter blue">Add Product Media</h3>
                                <?php if ($feedback = $this->session->flashdata('feedback')) { ?>
                                    <div class="alert alert-dismissible <?php echo $this->session->flashdata('feedback_class') ?>">
                                        <strong><?php echo $feedback; ?></strong>
                                    </div>
                                <?php } ?>
                                
                                <div style="display:none;" class="alert alert-block alert-success" id="ajax_msg"></div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="widget-box">
                                            <div class="widget-header">
                                               <a href="<?php echo base_url();?>product/list_product" class="btn btn-primary pull-right">List Product SKUs</a>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                <form name="add_story_detail" id="add_story_detail" enctype="multipart/form-data"  action="#" method="POST">
                                                    <input type="hidden" name="all_Images_list[]" id="all_Images_list" value="" />
                                                    <input type="hidden" name="all_videos_list[]" id="all_videos_list" value="" />
                                                    <input type="hidden" name="all_audios_list[]" id="all_audios_list" value="" />
                                                    <input type="hidden" name="all_attachments_list[]" id="all_attachments_list" value="" />
                                                    <div class="space"></div>
                                                    <div class="form-group">
                                                         
                                                          
                                                        
                                                        <style>
														.video-container{border: 1px dashed #aaa;border-radius: 4px;position: relative;text-align: center;width:300px; height:152px;background:url(<?php echo base_url();?>assets/images/drop-video.png);  z-index:9;}	
 														.video-container input{position:absolute; opacity: 0; cursor:pointer;	overflow: hidden;z-index:99; height:150px; background: #fff;}
 														</style>
                                                        <div class="add-spidey">
                                                            <label><strong>Images Product Media &nbsp;(<span style="color:grey;font-size:10px;">Jpg/Png only</span>):-</strong></label>
                                                             <div class="row">
                                                                <div class="col-xs-12">  
                                                                    <div class="col-xs-3 col-sm-3">
                                                                        <div class="dropzoneImg"></div>                                                                   
                                                                    </div>
                                                                </div>
																</div>
																<br /><br />
		 <!-------------Product Media Video Container Start --------------->
		 <div class="row">
          <div class="col-xs-12"> 
             <div class="col-xs-3 col-sm-3">
			<label><strong>Video Product Media&nbsp;(<span style="color:grey;font-size:10px;">Mp4 Only</span>):-</strong></label>
                 <div class="video-container ace-file-container">
                     
                 <input type="file" name="videoFile"class="form-control input_hiden" id="videoFile" onChange="return ajaxuploadFile('mp4');" />
                            <span></span>
                          <div class="left"><span class="play"></span><span id="filename"></span></div>
                                       <input type="hidden" name="token" id="token" value="12">
                                     <input type="hidden" name="savetoken" id="savetoken" value="">
                       <input type="hidden" name="videonewfile" id="videonewfile" value="">
                              <input type="hidden" name="videosupload" id="videosupload" value="">
                                     <input type="hidden" name="offStart" id="offStart" value="0">
                                     
                                     <div class="right"  style="margin-top:172px;">
                                       <div class="progress" id="progressHide" style="display:none;">
                                          <p id="ugc_video_size"></p>
                            <div class="bar " style="float:left;width:100%;position:absolute;top:0px;">
    <span id="video_progBar" style="margin-top:172px;" class="progress-bar progress-bar-info progress-bar-striped active" > </span>
    					   </div>
                                          </div>
                                     <div class="uploaded" id="videoupload" style="display:none;"></div>
                                           </div>  
										   </div> 
                                           <div id="progress-div"><div id="progress-bar"></div></div>
                             
							 <div style="display:none;" id="extra-progress-wrapperID" class="extra-progress-wrapper">
							   <div class="progress error-progress-2" style="width: 300px; margin: 20px 0px 0px;">
							   <div id="videoFile_err" class="progress-bar progress-bar-danger progress-bar-striped" style="width:100%"></div>
							   </div> 
							   </div> 
							   <div id="targetLayer"></div>
                                                                    
								</div>
                                 </div>
																	 
																	 
								</div>
								 <!-------------/ Product Media Video Container end --------------->
								<br /><br />
				 <!-------------Product Media Brochure Container Start  --------------->				
					<div class="row">
                      <div class="col-xs-12"> 
                        <div class="col-xs-3 col-sm-3">
						<label><strong>PDF Brochure for Product description &nbsp;(<span style="color:grey;font-size:10px;">PDF Only</span>):-</strong></label>
                      <div class="dropzoneAttachment">
					  </div>
					  </div>
					  </div>
					  </div>
					<!-------------/Product Media Brochure Container end  ---------------> 
					  <br /><br />
				<!-------------Product Media Audio Container Start  --------------->			
							<div class="row">
                                                                <div class="col-xs-12"> 
                                                                    <div class="col-xs-3 col-sm-3">
																	<label><strong>Audio for Product Media&nbsp;(<span style="color:grey;font-size:10px;">Mp3 Only</span>):-</strong></label>
                                                                    	<div class="dropzoneAudio">
                                                                    	<br></div>  
                                                                    </div> 
                                                                </div>
                                                            </div>
						<!-------------/Product Media Audio Container end  --------------->

<br /><br /><br />
	<!-------------Product Demo Video Container Start --------------->
		 <div class="row">
          <div class="col-xs-12"> 
             <div class="col-xs-3 col-sm-3">
			<label><strong> Product Demo Video&nbsp;(<span style="color:grey;font-size:10px;">Mp4 Only</span>):-</strong></label>
                 <div class="video-container ace-file-container">
                     
                 <input type="file" name="videoFile"class="form-control input_hiden" id="videoFile" onChange="return ajaxuploadFile('mp4');" />
                            <span></span>
                          <div class="left"><span class="play"></span><span id="filename"></span></div>
                                       <input type="hidden" name="token" id="token" value="12">
                                     <input type="hidden" name="savetoken" id="savetoken" value="">
                       <input type="hidden" name="videonewfile" id="videonewfile" value="">
                              <input type="hidden" name="videosupload" id="videosupload" value="">
                                     <input type="hidden" name="offStart" id="offStart" value="0">
                                     
                                     <div class="right"  style="margin-top:172px;">
                                       <div class="progress" id="progressHide" style="display:none;">
                                          <p id="ugc_video_size"></p>
                            <div class="bar " style="float:left;width:100%;position:absolute;top:0px;">
    <span id="video_progBar" style="margin-top:172px;" class="progress-bar progress-bar-info progress-bar-striped active" > </span>
    					   </div>
                                          </div>
                                     <div class="uploaded" id="videoupload" style="display:none;"></div>
                                           </div>  
										   </div> 
                                           <div id="progress-div"><div id="progress-bar"></div></div>
                             
							 <div style="display:none;" id="extra-progress-wrapperID" class="extra-progress-wrapper">
							   <div class="progress error-progress-2" style="width: 300px; margin: 20px 0px 0px;">
							   <div id="videoFile_err" class="progress-bar progress-bar-danger progress-bar-striped" style="width:100%"></div>
							   </div> 
							   </div> 
							   <div id="targetLayer"></div>
                                                                    
								</div>
                                 </div>
																	 
																	 
								</div>
								 <!-------------/ Product Demo Video Container end --------------->
								<br /><br />
				 <!-------------Product User Manual Container Start  --------------->				
					<div class="row">
                      <div class="col-xs-12"> 
                        <div class="col-xs-3 col-sm-3">
						<label><strong>PDF User Manual of Product &nbsp;(<span style="color:grey;font-size:10px;">PDF Only</span>):-</strong></label>
                      <div class="dropzoneAttachment">
					  </div>
					  </div>
					  </div>
					  </div>
					<!-------------/Product User Manual Container end  ---------------> 
					  <br /><br />
				<!-------------Product Demo Audio Container Start  --------------->			
							<div class="row">
                                                                <div class="col-xs-12"> 
                                                                    <div class="col-xs-3 col-sm-3">
																	<label><strong>Product  Audio for Demo&nbsp;(<span style="color:grey;font-size:10px;">Mp3 Only</span>):-</strong></label>
                                                                    	<div class="dropzoneAudio">
                                                                    	<br></div>  
                                                                    </div> 
                                                                </div>
                                                            </div>
						<!-------------/Product Demo Audio Container end  --------------->


						
									<br />					
					<!-------------/Product Demo Containers end  --------------->					
															
															<br /><br />
															<div class="form-group">
                                                         
                                                         <div class="add-spidey">
                                                            <label><strong>Product Description</strong></label>
                                                            <textarea name="pickDesc" id="pickDesc" cols="40" rows="10" class="form-control"><?php echo $buzz[0]['pickDesc']; ?></textarea>  
                                                        </div>
                                                        </div>
                                                            <br />
                                                         <div class="add-spidey">
                                                            <input type="hidden" name="submit_action" value="" id="submit_action" />
                                                            <input type="hidden" name="product_id" id="product_id" value="<?php $pid = $this->uri->segment(4);if(empty($pid)){
															echo '';}else{
															echo $pid;}?>" />
                                                            <input type="hidden" name="hiddenval" id="hiddenval" value="1" /> 
                                                            
                                                            <input class="btn btn-default my_button" type="submit" style="font-family: 'Open Sans' !important;font-size: 13px;
color: #393939  !important;
line-height: 1.5  !important;" name="submitBtn" value="Submit" id="submitBtn" />
                                                            <input type="hidden" name="clickedBtn" id="clickedBtn" />
                                                        </div>
                                                     </div>
                                                      
                                                   </form>
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
           $("#submit_action").val('1');
         });
 
 $(document).ready(function(){	
 	var clickedButton = '';
	var url='addStoryDetails';
	if($("#storyId").val()!=''){
		url='addStoryDetails';
	}
 	$("form#add_story_detail").validate({
		rules: {
			pickDesc: {
						 required: true
					  } 
		},
		messages: {
				pickDesc: {
					required: "Please Enter Product Description"
				}				 
		},
		submitHandler: function(form) {
 			var Idea;
			var art ='<i class="ace-icon fa fa-check green"></i>';
			var dataSend 	= $("#add_story_detail").serialize();
   			$.ajax({
				type: "POST",
				dataType:"json",
				beforeSend: function(){
				},
				url: "<?php echo base_url(); ?>backend/product_attrribute/"+url,
				data: dataSend,					
				success: function (msg) {
 					$('#add_story_detail')[0].reset();
					if(msg==1){
						$('#ajax_msg').html("Information Saved! ").css("color","green").show();
					}else if(msg==3){
						$('#ajax_msg').html(" Error in Save Data! ").css("color","red").show();
					}else if(msg==2){
						$('#ajax_msg').html(" Media Updated Successfully!").css("color","green").show();
					}
					
 				},
				complete: function(){ 
					    $('html, body').animate({
								scrollTop: $("#ajax_msg").offset().top
							}, 2000);
  						}
						});
 			 		return false;
 				}
	});
});
  </script>
        <?php include_once APPPATH .'../assets/chunk_upload/chunk_upload_js.php';?>     
    <!-- Latest Drop n Upload  JavaScript --> 
    <script type="text/javascript" src="<?php echo base_url().'assets/drag-drop/';?>js/dropzone.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/drag-drop/';?>js/main.js"></script>
 	<script src="<?php echo base_url();?>assets/drag-drop/drag-drop-script.js"></script>
  
   