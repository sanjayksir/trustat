<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); ?>
<?php
$medisUrl = $this->config->item('media_location');
?>
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
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1>Add Product Media</h1>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-box hidden">
                            <button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <div class="widget-box">
                    <div class="widget-header widget-header-flat">
                        <h4 class="widget-title smaller">Product Name : <?php echo get_products_name_by_id($this->uri->segment(4)); ?></h4>
                        <div class="widget-toolbar no-border">
                            <a href="#description-modal" class="btn btn-success btn-sm" data-toggle="modal">Add Product Loyalty Points, Feedback Question Quantity & Product Description</a>
                            <a href="<?php echo base_url();?>product/list_product" class="btn btn-info btn-sm">List Product SKUs</a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    <div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Thum Image</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_thumb_images"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									</div>
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Ad Images</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_images"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									</div>
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    <div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Code Print BG Image</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_code_print_bg_images"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									</div>
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Audio</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_audio"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									</div>
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Video</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_video"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									</div>
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Advertisement Video</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_push_ad_video"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									 </div>

									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Advertisement Audio</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_push_ad_audio"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									 </div>

									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Advertisement PDF</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_push_ad_pdf"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									 </div>


								<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Advertisement Image</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_push_ad_image"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									 </div>									 
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Survey Video</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_survey_video"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
									 </div> 
									 
									 <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Survey Audio</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_survey_audio"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
									 </div> 
									 
									 <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Survey PDF</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_survey_pdf"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
									 </div> 
									 
									 <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Survey Image</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_survey_image"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
									 </div> 
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									 <div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Demo Video</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_demo_video"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									 </div> 
									
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Demo Audio</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_demo_audio"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									 </div> 
								
								<div class="col-xs-12 col-sm-4 widget-box transparent text-center">								
								<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Brochure</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_pdf"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
									 </div> 
									
									<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
									<div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product User Manual</h6>
                                    </div>
                                    <div class="widget-body">                                        
                                        <div class="widget-main">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <span id="product_user_manual"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>	
                                </div> 
								
								
								<!--
								<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    
                                </div>
                                <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    
                                </div>
								<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                   
                                </div>
								<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    
                                </div>
								<div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    
                                </div>
                                <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    
                                </div>
								 <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    
                                </div>
								-->
                            </div>
                            <div class="row">
                               
                            </div>    
							
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="description-modal" class="modal" tabindex="-1" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="blue bigger">Add Product Loyalty Points, Feedback Question Quantity(FbQQ) & Product Description</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="alert alert-media-box hidden">
                            <button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                        </div>
                        <div class="col-xs-12 col-sm-12" align="right">
                            <div class="form-group">
							
							 
							  <label for="form-field-description">Product Image Response Loyalty Points : <input type="text" name="product_image_response_lps" id="product_image_response_lps" value="<?php echo $product_image_response_lps; ?>" style="width:80px" /></label>
							  <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_image_response_fbqq" id="product_image_response_fbqq" value="<?php echo $product_image_response_fbqq; ?>" style="width:40px" /> </label><br />
							  
							   <label for="form-field-description">Product Audio Response Loyalty Points : <input type="text" name="product_audio_response_lps" id="product_audio_response_lps" value="<?php echo $product_audio_response_lps; ?>" style="width:80px" /></label>
							   <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_audio_response_fbqq" id="product_audio_response_fbqq" value="<?php echo $product_audio_response_fbqq; ?>" style="width:40px" /> </label><br />
							   
							    <label for="form-field-description">Product Video Response Loyalty Points : <input type="text" name="product_video_response_lps" id="product_video_response_lps" value="<?php echo $product_video_response_lps; ?>" style="width:80px" /></label>
								<label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_video_response_fbqq" id="product_video_response_fbqq" value="<?php echo $product_video_response_fbqq; ?>" style="width:40px" /> </label><br />
								
								
								<label for="form-field-description">Product Brochure Response Loyalty Points : <input type="text" name="product_pdf_response_lps" id="product_pdf_response_lps" value="<?php echo $product_pdf_response_lps; ?>" style="width:80px" /></label>
								  <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_pdf_response_fbqq" id="product_pdf_response_fbqq" value="<?php echo $product_pdf_response_fbqq; ?>" style="width:40px" /> </label><br />
								
								
								 <label for="form-field-description">Product Ad Video Response Loyalty Points : <input type="text" name="product_ad_video_response_lps" id="product_ad_video_response_lps" value="<?php echo $product_ad_video_response_lps; ?>" style="width:80px" /></label>
								 <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_ad_video_response_fbqq" id="product_ad_video_response_fbqq" value="<?php echo $product_ad_video_response_fbqq; ?>" style="width:40px" /> </label><br />
								 
								 
								 <label for="form-field-description">Product Ad Audio Response Loyalty Points : <input type="text" name="product_ad_audio_response_lps" id="product_ad_audio_response_lps" value="<?php echo $product_ad_audio_response_lps; ?>" style="width:80px" /></label>
								 <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_ad_audio_response_fbqq" id="product_ad_audio_response_fbqq" value="<?php echo $product_ad_audio_response_fbqq; ?>" style="width:40px" /> </label><br />
								 
								 
								 <label for="form-field-description">Product Ad PDF Response Loyalty Points : <input type="text" name="product_ad_pdf_response_lps" id="product_ad_pdf_response_lps" value="<?php echo $product_ad_pdf_response_lps; ?>" style="width:80px" /></label>
								 <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_ad_pdf_response_fbqq" id="product_ad_pdf_response_fbqq" value="<?php echo $product_ad_pdf_response_fbqq; ?>" style="width:40px" /> </label><br />
								 
								 <label for="form-field-description">Product Ad Image Response Loyalty Points : <input type="text" name="product_ad_image_response_lps" id="product_ad_image_response_lps" value="<?php echo $product_ad_image_response_lps; ?>" style="width:80px" /></label>
								 <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_ad_image_response_fbqq" id="product_ad_image_response_fbqq" value="<?php echo $product_ad_image_response_fbqq; ?>" style="width:40px" /> </label><br />
								 
								 
								  <label for="form-field-description">Product Survey Video Response Loyalty Points : <input type="text" name="product_survey_video_response_lps" id="product_survey_video_response_lps" value="<?php echo $product_survey_video_response_lps; ?>" style="width:80px" /></label>
								  <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_survey_video_response_fbqq" id="product_survey_video_response_fbqq" value="<?php echo $product_survey_video_response_fbqq; ?>" style="width:40px" /> </label><br />
								  
								   <label for="form-field-description">Product Survey Audio Response Loyalty Points : <input type="text" name="product_survey_audio_response_lps" id="product_survey_audio_response_lps" value="<?php echo $product_survey_audio_response_lps; ?>" style="width:80px" /></label>
								  <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_survey_audio_response_fbqq" id="product_survey_audio_response_fbqq" value="<?php echo $product_survey_audio_response_fbqq; ?>" style="width:40px" /> </label><br />
								  
								  
								   <label for="form-field-description">Product Survey PDF Response Loyalty Points : <input type="text" name="product_survey_pdf_response_lps" id="product_survey_pdf_response_lps" value="<?php echo $product_survey_pdf_response_lps; ?>" style="width:80px" /></label>
								  <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_survey_pdf_response_fbqq" id="product_survey_pdf_response_fbqq" value="<?php echo $product_survey_pdf_response_fbqq; ?>" style="width:40px" /> </label><br />
								  
								  
								   <label for="form-field-description">Product Survey Image Response Loyalty Points : <input type="text" name="product_survey_image_response_lps" id="product_survey_image_response_lps" value="<?php echo $product_survey_image_response_lps; ?>" style="width:80px" /></label>
								  <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_survey_image_response_fbqq" id="product_survey_image_response_fbqq" value="<?php echo $product_survey_image_response_fbqq; ?>" style="width:40px" /> </label><br />
								  
								  
								  <label for="form-field-description">Product Demo Video Response Loyalty Points : <input type="text" name="product_demo_video_response_lps" id="product_demo_video_response_lps" value="<?php echo $product_demo_video_response_lps; ?>" style="width:80px" /></label>
								  <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_demo_video_response_fbqq" id="product_demo_video_response_fbqq" value="<?php echo $product_demo_video_response_fbqq; ?>" style="width:40px" /> </label><br />
								  
								  
								  <label for="form-field-description">Product Demo Audio Response Loyalty Points : <input type="text" name="product_demo_audio_response_lps" id="product_demo_audio_response_lps" value="<?php echo $product_demo_audio_response_lps; ?>" style="width:80px" /></label>
								  <label for="form-field-description" style="margin-left: 25px;"> FbQQ : <input type="text" name="product_demo_audio_response_fbqq" id="product_demo_audio_response_fbqq" value="<?php echo $product_demo_audio_response_fbqq; ?>" style="width:40px" /> </label><br />
								  
								 
                            </div>
                        </div>
						<div>
						 <label for="form-field-description" style="margin-left: 11px;">Product Registration Loyalty Points : <input type="text" name="product_registration_lps" id="product_registration_lps" value="<?php echo $product_registration_lps; ?>" style="width:80px" /> </label> 
							 <br />
							 <label for="form-field-description" style="margin-left: 11px;">Product Feedback Loyalty Points : <input type="text" name="feedback_on_product_lps" id="feedback_on_product_lps" value="<?php echo $feedback_on_product_lps; ?>" style="width:80px" /> </label> 
							 <br />
						
								<label for="form-field-description" style="margin-left: 11px;"> Add Product Description : </label><br />
                                    <textarea class="form-control" name="product_description" id="product-description" placeholder="Product description" rows="4"><?php echo $product_description; ?></textarea>
                                </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>Cancel
                    </button>
                    <button class="btn btn-sm btn-primary" id="media-description">
                        <i class="ace-icon fa fa-check"></i>Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('../includes/admin_footer'); ?>
    <link href="<?php echo site_url('assets');?>/css/uploadfile.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo site_url('assets');?>/js/jquery.uploadfile.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#product_thumb_images").uploadFile({
                uploadStr:"Select Image",
                url:site_url+"backend/product_attrribute/media_attribute/product_thumb_images/<?php echo base64_encode($id); ?>",
                fileName:"product_thumb_images",
                showDelete: true,
                sequential:true,
                sequentialCount:1,
                acceptFiles:"image/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_thumb_images/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_thumb_images/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // upload product thumb images 
			$("#product_images").uploadFile({
                uploadStr:"Select Image",
                url:site_url+"backend/product_attrribute/media_attribute/product_images/<?php echo base64_encode($id); ?>",
                fileName:"product_images",
                showDelete: true,
                sequential:true,
                sequentialCount:1,
                acceptFiles:"image/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_images/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_images/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // upload ad images
			$("#product_code_print_bg_images").uploadFile({
                uploadStr:"Select Image",
                url:site_url+"backend/product_attrribute/media_attribute/product_code_print_bg_images/<?php echo base64_encode($id); ?>",
                fileName:"product_code_print_bg_images",
                showDelete: true,
                sequential:true,
                sequentialCount:1,
                acceptFiles:"image/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_code_print_bg_images/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_code_print_bg_images/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // upload product code print images 
            $("#product_video").uploadFile({
                uploadStr:"Product Video",
                url:site_url+"backend/product_attrribute/media_attribute/product_video/<?php echo base64_encode($id); ?>",
                fileName:"product_video",
                showDelete: true,
                acceptFiles:"video/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_video/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_video/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // upload product video
			$("#product_demo_video").uploadFile({
                uploadStr:"Product Demo Video",
                url:site_url+"backend/product_attrribute/media_attribute/product_demo_video/<?php echo base64_encode($id); ?>",
                fileName:"product_demo_video",
                showDelete: true,
                acceptFiles:"video/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_demo_video/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_demo_video/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // upload product video
			$("#product_demo_audio").uploadFile({
                uploadStr:"Product Demo Audio",
                url:site_url+"backend/product_attrribute/media_attribute/product_demo_audio/<?php echo base64_encode($id); ?>",
                fileName:"product_demo_audio",
                showDelete: true,
                sequentialCount:1,
                acceptFiles:"audio/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_demo_audio/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_demo_audio/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); 
			$("#product_push_ad_video").uploadFile({
                uploadStr:"Product Push Ad Video",
                url:site_url+"backend/product_attrribute/media_attribute/product_push_ad_video/<?php echo base64_encode($id); ?>",
                fileName:"product_push_ad_video",
                showDelete: true,
                acceptFiles:"video/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_push_ad_video/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_push_ad_video/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            });  // product_push_ad_video
			$("#product_push_ad_audio").uploadFile({
                uploadStr:"Product Push Ad Audio",
                url:site_url+"backend/product_attrribute/media_attribute/product_push_ad_audio/<?php echo base64_encode($id); ?>",
                fileName:"product_push_ad_audio",
                showDelete: true,
                acceptFiles:"audio/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_push_ad_audio/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_push_ad_audio/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            });  // product_push_ad_audio
			$("#product_push_ad_pdf").uploadFile({
                uploadStr:"Product Push Ad PDF",
                url:site_url+"backend/product_attrribute/media_attribute/product_push_ad_pdf/<?php echo base64_encode($id); ?>",
                fileName:"product_push_ad_pdf",
                showDelete: true,
                acceptFiles:"pdf/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_push_ad_pdf/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_push_ad_pdf/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            });  // product_push_ad_pdf
			$("#product_push_ad_image").uploadFile({
                uploadStr:"Product Push Ad Image",
                url:site_url+"backend/product_attrribute/media_attribute/product_push_ad_image/<?php echo base64_encode($id); ?>",
                fileName:"product_push_ad_image",
                showDelete: true,
                acceptFiles:"image/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_push_ad_image/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_push_ad_image/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            });  // product_push_ad_image
			$("#product_survey_video").uploadFile({
                uploadStr:"Product Survey Video",
                url:site_url+"backend/product_attrribute/media_attribute/product_survey_video/<?php echo base64_encode($id); ?>",
                fileName:"product_survey_video",
                showDelete: true,
                acceptFiles:"video/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_survey_video/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_survey_video/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // product_survey_video
			$("#product_survey_audio").uploadFile({
                uploadStr:"Product Survey Audio",
                url:site_url+"backend/product_attrribute/media_attribute/product_survey_audio/<?php echo base64_encode($id); ?>",
                fileName:"product_survey_audio",
                showDelete: true,
                acceptFiles:"audio/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_survey_audio/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_survey_audio/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // product_survey_audio
			$("#product_survey_pdf").uploadFile({
                uploadStr:"Product Survey PDF",
                url:site_url+"backend/product_attrribute/media_attribute/product_survey_pdf/<?php echo base64_encode($id); ?>",
                fileName:"product_survey_pdf",
                showDelete: true,
                acceptFiles:"pdf/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_survey_pdf/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_survey_pdf/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // product_survey_pdf
			$("#product_survey_image").uploadFile({
                uploadStr:"Product Survey Image",
                url:site_url+"backend/product_attrribute/media_attribute/product_survey_image/<?php echo base64_encode($id); ?>",
                fileName:"product_survey_image",
                showDelete: true,
                acceptFiles:"image/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_survey_image/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_survey_image/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); // product_survey_image
            $("#product_audio").uploadFile({
                uploadStr:"Product Audio",
                url:site_url+"backend/product_attrribute/media_attribute/product_audio/<?php echo base64_encode($id); ?>",
                fileName:"product_audio",
                showDelete: true,
                sequentialCount:1,
                acceptFiles:"audio/*",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_audio/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_audio/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            }); 
            $("#product_pdf").uploadFile({
                uploadStr:"Product Brochure",
                url:site_url+"backend/product_attrribute/media_attribute/product_pdf/<?php echo base64_encode($id); ?>",
                fileName:"product_pdf",
                showDelete: true,
                sequentialCount:1,
                acceptFiles:".pdf",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_pdf/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_pdf/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            });
			$("#product_user_manual").uploadFile({
                uploadStr:"User Manual",
                url:site_url+"backend/product_attrribute/media_attribute/product_user_manual/<?php echo base64_encode($id); ?>",
                fileName:"product_user_manual",
                showDelete: true,
                sequentialCount:1,
                acceptFiles:".pdf",
                showPreview:true,
                previewHeight: "100px",
                previewWidth: "100px",
                onLoad:function(obj){
                    $.ajax({
                        cache: false,
                        url:site_url+"backend/product_attrribute/view_media_file/product_user_manual/<?php echo base64_encode($id); ?>",
                        dataType: "json",
                        success: function(data){
                            for(var i=0;i<data.length;i++){
                                obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"]);
                            }
                        } 
                    });
                },
                deleteCallback: function (data, pd) {
                    $(".alert-box").removeClass('alert-success').removeClass('alert-danger');
                    for (var i = 0; i < data.length; i++) {
                        $.post(site_url+"backend/product_attrribute/delete_media_file/product_user_manual/<?php echo base64_encode($id); ?>", {
                            file: data[i]
                        },function (resp,textStatus, jqXHR) {
                            if(resp.status){
                                $(".alert-box").addClass('alert-success').html('<p>'+resp.message+'</p>');
                            }else{
                                $(".alert-box").addClass('alert-danger').html('<p>'+resp.message+'</p>');
                            }
                            
                        });
                    }
                    pd.statusbar.hide(); //You choice.
                }
            });
            $(document).on('click','#media-description',function(e){
                e.preventDefault();
                $("#media-description").addClass('disabled');
                $(".alert-media-box").removeClass('alert-success').removeClass('alert-danger');
                $.ajax({
                    url:site_url+"backend/product_attrribute/media_description/<?php echo base64_encode($id); ?>",
                    type: "POST",
                    data: {"product_description":$("#product-description").val(),"product_registration_lps":$("#product_registration_lps").val(),"product_image_response_lps":$("#product_image_response_lps").val(),"product_audio_response_lps":$("#product_audio_response_lps").val(),"product_video_response_lps":$("#product_video_response_lps").val(),"product_ad_video_response_lps":$("#product_ad_video_response_lps").val(),"product_ad_audio_response_lps":$("#product_ad_audio_response_lps").val(),"product_ad_pdf_response_lps":$("#product_ad_pdf_response_lps").val(),"product_ad_image_response_lps":$("#product_ad_image_response_lps").val(),"product_survey_video_response_lps":$("#product_survey_video_response_lps").val(),"product_survey_audio_response_lps":$("#product_survey_audio_response_lps").val(),"product_survey_pdf_response_lps":$("#product_survey_pdf_response_lps").val(),"product_survey_image_response_lps":$("#product_survey_image_response_lps").val(),"product_pdf_response_lps":$("#product_pdf_response_lps").val(),"product_demo_video_response_lps":$("#product_demo_video_response_lps").val(),"product_demo_audio_response_lps":$("#product_demo_audio_response_lps").val(),"product_image_response_fbqq":$("#product_image_response_fbqq").val(),"product_audio_response_fbqq":$("#product_audio_response_fbqq").val(),"product_video_response_fbqq":$("#product_video_response_fbqq").val(),"product_pdf_response_fbqq":$("#product_pdf_response_fbqq").val(),"product_ad_video_response_fbqq":$("#product_ad_video_response_fbqq").val(),"product_ad_audio_response_fbqq":$("#product_ad_audio_response_fbqq").val(),"product_ad_pdf_response_fbqq":$("#product_ad_pdf_response_fbqq").val(),"product_ad_image_response_fbqq":$("#product_ad_image_response_fbqq").val(),"product_survey_video_response_fbqq":$("#product_survey_video_response_fbqq").val(),"product_survey_audio_response_fbqq":$("#product_survey_audio_response_fbqq").val(),"product_survey_pdf_response_fbqq":$("#product_survey_pdf_response_fbqq").val(),"product_survey_image_response_fbqq":$("#product_survey_image_response_fbqq").val(),"product_demo_video_response_fbqq":$("#product_demo_video_response_fbqq").val(),"product_demo_audio_response_fbqq":$("#product_demo_audio_response_fbqq").val(),"feedback_on_product_lps":$("#feedback_on_product_lps").val()},
                    dataType:"json"
                }).done(function( data ) {
                    $("#media-description").removeClass('disabled');
                    if(data.status){ 
                        $(".alert-media-box").removeClass('hidden').addClass('alert-success').html('<p>'+data.message+'</p>');
                    }else{
                        $(".alert-media-box").removeClass('hidden').addClass('alert-danger').html('<p>'+data.message+'</p>');
                    }
                    setTimeout(function() { 
                        $('#description-modal').modal('toggle');
                        $(".alert-media-box").addClass('hidden')
                    }, 3000);
                  
                  //Perform ANy action after successfuly post data

                });
            });
        });
    </script>
    
   