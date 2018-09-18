<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); ?>
<div class="main-container ace-save-state" id="main-container">
 <?php $this->load->view('../includes/admin_sidebar'); //echo '***'.$this->uri->segment(4);
 //echo '<pre>';print_r($resData);
 ?>
 

    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
                    <li> <a href="#">Editorial</a> </li>
                    <li class="active">Story idea Details</li>
                </ul>
                <!-- /.breadcrumb -->
               
                <!-- /.nav-search -->
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 class="header smaller lighter blue">Story idea Details</h3>
                                <div style="clear:both;"><a href="<?php echo base_url();?>buzzadmn/addSpidyBuzz/" class="btn btn-primary pull-right">ADD SPIDEY BUZZ</a></div>
                                <?php if ($feedback = $this->session->flashdata('feedback')){ ?>
                                    <div class="alert alert-dismissible <?php echo $this->session->flashdata('feedback_class');?>">
                                        <strong><?php echo $feedback; ?></strong>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="widget-box">
                                            <div class="widget-header">
                                                <h4 class="widget-title pull-right padding-right"><a href="<?php echo base_url().'buzzadmn/editorial/suboutput';?>">Back</a></h4>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                <form name="dwl_frm" id="dwl_frm" class="form-horizontal" action="<?php echo base_url();?>buzzadmn/editorial/download/<?php echo $this->uri->segment(4);?>" method="POST">
                                                    <input type="hidden" name="all_PTImages_list[]" id="all_PTImages_list" value="" />
                                                    <input type="hidden" name="all_Images_list[]" id="all_Images_list" value="" />
                                                    <input type="hidden" name="all_videos_list[]" id="all_videos_list" value="" />
                                                    <input type="hidden" name="all_audios_list[]" id="all_audios_list" value="" />
                                                    <input type="hidden" name="all_attachments_list[]" id="all_attachments_list" value="" />																										<input type="hidden" name="all_product_demo_video_list[]" id="all_product_demo_video_list" value="" />																										<input type="hidden" name="all_product_push_ad_video_list[]" id="all_product_push_ad_video_list" value="" />																										<input type="hidden" name="all_product_survey_video_list[]" id="all_product_survey_video_list" value="" />                                                    <input type="hidden" name="all_product_demo_audio_list[]" id="all_product_demo_audio_list" value="" />                                                    <input type="hidden" name="all_product_user_manual_list[]" id="all_product_user_manual_list" value="" />
                                                     <div class="form-group">
                                                        <div class="add-spidey">
                                                            <label>Story Title: </label>
                                                            <span style="font-size:16px; font-weight:bold;"><?php echo $storyIdea[0]['title']; ?></span>
                                                        </div>
                                                          <div class="add-spidey">
                                                            <label>Story Idea Details(<b>Reporter</b>)</label>
                                                            <textarea class="pickDesc" name="pickDesc" id="pickDesc" cols="40" rows="10" class="form-control"><?php echo $resData[0]['reporter_content']; ?></textarea>  
                                                        </div>
                                                        
                                                        <div class="add-spidey">
                                                            <label>Story Idea Details(<b>Editorial</b>)</label>
                                                            <textarea class="pickDesc" name="pickDesc2" id="pickDesc2" cols="40" rows="10" class="form-control"><?php echo $resData[0]['editorial_content']; ?></textarea>  
                                                        </div>
                                                             <br />
                                                         <div class="add-spidey">
                                                         <?php 
														 $type= "button";
														 $getMediaData = getMediaData($this->uri->segment(4));
														// echo '<pre>';print_r($getMediaData);
														 if(count($getMediaData)>0){
															 $type = "submit";
														 }
														?>
                                                         	<input class="btn btn-default my_button" type="<?php echo $type;?>" name="saveBtn" value="All File Download" id="saveBtn" />
                                                         </div>
                                                     </div>
                                                    </form>
                                                    <hr />
                                                  <h3> Download Files</h3><br />
                                                   <table>
                                                   <?php if(!empty($getMediaData['images'])){ 
													      echo '<tr><td></td><td>';
																foreach(explode(',',$getMediaData['images']) as $k1=>$v){
																 ?>
                                                     <div class="col-md-2 media-box" >
                                                    	<a href="<?php echo base_url();?>uploads/<?php echo trim($v);?>" class="flipLightBox">
                                                      	<img src="<?php echo base_url();?>uploads/<?php echo trim($v);?>" width="100%" height="125" alt="<?php echo $v;?>" />
                                                        <span class="media-span"><?php echo $v; ?></span>
                                                      	</a>
													  <?php echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'"><span class="dwnld-cls">&nbsp;&nbsp;<i class="fa fa-download pull-right icon-dwnld" aria-hidden="true" ></i>
</span></a>';?>
                                                      </div>
													  <?php } echo '</td></tr><tr><td><hr></td></tr>';
												    }?>
                                                     <?php if(!empty($getMediaData['videos'])){ 
													  echo '<tr><td></td><td>';
												   			foreach(explode(',',$getMediaData['videos']) as $k2=>$v){
 																//echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.$v.'">'.$v.'</a>';?>
														<div class="col-md-2 media-box" >
                                                      	<img src="<?php echo base_url();?>assets/images/video-play.png" width="100%" height="125" alt="<?php echo $v;?>" />
													  <?php echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'"><span class="dwnld-cls">&nbsp;&nbsp;<i class="fa fa-download pull-right icon-dwnld" aria-hidden="true" ></i>
</span></a>';?>
                                                      </div>	
                                                      <?php         }
													echo '</td></tr><tr><td><hr></td></tr>';
												    }?>
                                                  
                                                      <?php if(!empty($getMediaData['audios'])){ 
													   echo '<tr><td></td><td>';
												   			foreach(explode(',',$getMediaData['audios']) as $k3=>$v){
 																//echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'">'.$v.'</a>'.$comm3;
																?>
 																 <div class="col-md-2 media-box" >
                                                       	<img src="<?php echo base_url();?>assets/images/images-def.jpg" width="100%" height="125" alt="<?php echo $v;?>" />
 													  <?php echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'"><span class="dwnld-cls">&nbsp;&nbsp;<i class="fa fa-download pull-right icon-dwnld" aria-hidden="true" ></i>
</span></a>';?>
                                                      </div>
													<?php
													    }echo '</td></tr><tr><td><hr></td></tr>';
												    }?>
                                                  
                                                      <?php if(!empty($getMediaData['attachments'])){ 
													     echo '<tr><td></td><td>';
												   			foreach(explode(',',$getMediaData['attachments']) as $k4=>$v){
 																//echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'">'.$v.'</a>'.$comm4;?>
                                                             <div class="col-md-2 media-box" >
                                                       	<img src="<?php echo base_url();?>assets/images/pdf.png" width="100%" height="125" alt="<?php echo $v;?>" />
 													  <?php echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'"><span class="dwnld-cls">&nbsp;&nbsp;<i class="fa fa-download pull-right icon-dwnld" aria-hidden="true" ></i>
</span></a>';?>
                                                      </div>   
                                                                
                                                             <?php }
														echo '</td></tr><tr><td><hr></td></tr>';
												    }?>																										 <?php if(!empty($getMediaData['demovideos'])){ 													  echo '<tr><td></td><td>';												   			foreach(explode(',',$getMediaData['demovideos']) as $k2=>$v){ 																//echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.$v.'">'.$v.'</a>';?>														<div class="col-md-2 media-box" >                                                      	<img src="<?php echo base_url();?>assets/images/video-play.png" width="100%" height="125" alt="<?php echo $v;?>" />													  <?php echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'"><span class="dwnld-cls">&nbsp;&nbsp;<i class="fa fa-download pull-right icon-dwnld" aria-hidden="true" ></i></span></a>';?>                                                      </div>	                                                      <?php         }													echo '</td></tr><tr><td><hr></td></tr>';												    }?>                                                                                                        <?php if(!empty($getMediaData['demoaudios'])){ 													   echo '<tr><td></td><td>';												   			foreach(explode(',',$getMediaData['demoaudios']) as $k3=>$v){ 																//echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'">'.$v.'</a>'.$comm3;																?> 																 <div class="col-md-2 media-box" >                                                       	<img src="<?php echo base_url();?>assets/images/images-def.jpg" width="100%" height="125" alt="<?php echo $v;?>" /> 													  <?php echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'"><span class="dwnld-cls">&nbsp;&nbsp;<i class="fa fa-download pull-right icon-dwnld" aria-hidden="true" ></i></span></a>';?>                                                      </div>													<?php													    }echo '</td></tr><tr><td><hr></td></tr>';												    }?>                                                                                                        <?php if(!empty($getMediaData['demoattachments'])){ 													     echo '<tr><td></td><td>';												   			foreach(explode(',',$getMediaData['demoattachments']) as $k4=>$v){ 																//echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'">'.$v.'</a>'.$comm4;?>                                                             <div class="col-md-2 media-box" >                                                       	<img src="<?php echo base_url();?>assets/images/pdf.png" width="100%" height="125" alt="<?php echo $v;?>" /> 													  <?php echo '&nbsp;<a href="'.base_url().'buzzadmn/editorial/single_file_dwld/'.trim($v).'"><span class="dwnld-cls">&nbsp;&nbsp;<i class="fa fa-download pull-right icon-dwnld" aria-hidden="true" ></i></span></a>';?>                                                      </div>                                                                                                                                <?php }														echo '</td></tr><tr><td><hr></td></tr>';												    }?> 
                                                    </table>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
							function getDownload(){
                             	window.location.href = "<?php echo base_url().'buzzadmn/editorial/download';?>";
								return false;
							}
                            </script>
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
	var url='editStoryDetail';
	if($("#storyId").val()!=''){
		url='editStoryDetail';
	}
 	$("form#add_story_detail").validate({
		rules: {
			pickDesc: {
						 required: true
					  } 
		},
		messages: {
				pickDesc: {
					required: "Please Enter Story Detail"
				}				 
		},
		submitHandler: function(form) { 
			var content = CKEDITOR.instances['pickDesc'].getData()
		 
			var Idea;
			var art ='<i class="ace-icon fa fa-check green"></i>';
			var dataSend 	= $("#add_story_detail").serialize();
			dataSend += "&pickDescEdit=" + encodeURIComponent(content);
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
							Idea = "Updated";	
						}else{
							Idea = "Saved";	
						}
 						 $('#ajax_msg').html(art+ "  Idea  "+Idea+" Successfully!").css("color","green").show();
 						 if($('#storyId').val()==''){
							 $('#add_story_detail')[0].reset(); 
						 }
 						// window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/myspidey_user_master/add_user/";						
					}else{
						 $('#ajax_msg').html(" Error in Save Data! ").css("color","red").show();
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
 <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
 <script>
 <!----------- Standard Ck editor code--->
  var toolbar = [
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Scayt' ] },
	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
 	{ name: 'tools', items: [ 'Maximize' ] },
 	{ name: 'others', items: [ '-' ] },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
	{ name: 'styles', items: [ 'Styles', 'Format' ] }
];           
    // This is the declaration of CKeditor
    //<![CDATA[
         CKEDITOR.replace( "pickDesc", {toolbar:toolbar, width:'95%' } );
		  CKEDITOR.replace( "pickDesc2", {toolbar:toolbar, width:'95%' } )
         var oEditor= CKEDITOR.instances.IdOfTextArea;
    //]]>
	</script>
       <?php include_once APPPATH .'../assets/chunk_upload/chunk_upload_js.php';?>     
    <!-- Latest Drop n Upload  JavaScript --> 
    <script type="text/javascript" src="<?php echo base_url().'assets/drag-drop/';?>js/dropzone.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/drag-drop/';?>js/main.js"></script>
 	<script src="<?php echo base_url();?>assets/drag-drop/drag-drop-script.js"></script>
   
<script type="text/javascript" src="<?php echo base_url().'assets/fancybox';?>/fliplightbox.min.js"></script>
<script type="text/javascript">
 $('body').flipLightBox()
 </script>