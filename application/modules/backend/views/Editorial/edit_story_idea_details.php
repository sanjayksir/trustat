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
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo DASH_B;?>">Home</a> </li>
                    <li> <a href="#">Editorial</a> </li>
                    <li class="active">Story idea Details</li>
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
                                <h3 class="header smaller lighter blue">Story idea Details</h3>
                                <?php if ($feedback = $this->session->flashdata('feedback')){ ?>
                                    <div class="alert alert-dismissible <?php echo $this->session->flashdata('feedback_class');?>">
                                        <strong><?php echo $feedback; ?></strong>
                                    </div>
                                <?php } ?>

                                <div id="ajax_msg"></div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="widget-box">
                                            <div class="widget-header">
                                                <h4 class="widget-title pull-right padding-right"><a href="<?php echo base_url().'buzzadmn/editorial/listing';?>">Back</a></h4>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                <form name="add_story_detail" id="add_story_detail" enctype="multipart/form-data" class="form-horizontal" action="#" method="POST">
                                                    <input type="hidden" name="all_Images_list[]" id="all_Images_list" value="" />
                                                    <input type="hidden" name="all_videos_list[]" id="all_videos_list" value="" />
                                                    <input type="hidden" name="all_audios_list[]" id="all_audios_list" value="" />
                                                    <input type="hidden" name="all_attachments_list[]" id="all_attachments_list" value="" />
                                                     <div class="form-group">
                                                        <div class="add-spidey">
                                                            <label>Story Title</label>
                                                            <p><?php echo $storyIdea[0]['title']; ?></p>
                                                        </div>
                                                         <div class="add-spidey">
                                                            <label>Story Idea Details</label>
                                                            <textarea name="pickDesc" id="pickDesc" cols="40" rows="10" class="form-control"><?php echo $resData[0]['reporter_content']; ?></textarea>  
                                                        </div>
                                                        
                                                            <br />
                                                         <div class="add-spidey">
                                                            <input type="hidden" name="storyId" id="storyId" value="<?php if($this->uri->segment(4)!=''){echo $this->uri->segment(4);};?>" />
                                                            <input type="hidden" name="hiddenval" id="hiddenval" value="1" /> 
                                                            <input class="btn btn-default my_button" type="submit" name="saveBtn" value="Save" id="saveBtn" />
                                                            <input class="btn btn-default my_button" type="submit" name="submitBtn" value="Submit" id="submitBtn" />
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
					if(parseInt(msg) != 2){
						if(parseInt(msg)==1){
							Idea = "Updated";	
						}else{
							Idea = "Saved";	
						}

                        $('#ajax_msg').html('<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button> <i class="ace-icon fa fa-check green"></i> Idea  '+Idea+' Successfully!</div>');
                        $(".alert-success").delay(2000).fadeOut();

 						 
 						if($('#storyId').val()==''){
							$('#add_story_detail')[0].reset(); 
						}
 						// window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/myspidey_user_master/add_user/";						
					}else{
                        $('#ajax_msg').html('<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button> <i class="ace-icon fa fa-check red"></i> Error in Save Data!</div>');
                        $(".alert-danger").delay(2000).fadeOut();
					}
 				},
				complete: function(){
  					if($("#submitBtn").val()!=''){
					<!-------------Reset Form------------ -->
						CKEDITOR.instances['pickDesc'].setData('');
  					<!-------------Reset Form------------ -->
					}
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
         var oEditor= CKEDITOR.instances.IdOfTextArea;
    //]]>
	</script>
       <?php include_once APPPATH .'../assets/chunk_upload/chunk_upload_js.php';?>     
    <!-- Latest Drop n Upload  JavaScript --> 
    <script type="text/javascript" src="<?php echo base_url().'assets/drag-drop/';?>js/dropzone.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/drag-drop/';?>js/main.js"></script>
 	<script src="<?php echo base_url();?>assets/drag-drop/drag-drop-script.js"></script>
  
    