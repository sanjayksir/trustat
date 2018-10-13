<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); ?>
<?php
$medisUrl = $this->config->item('media_location');
?>
<div class="main-container ace-save-state" id="main-container">
    <style type="text/css">
        .media-info {width: auto;font-weight: 600;font-size: 14px;}
    </style>
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
                                            <form name="media-form" class="form-horizontal" id ="media-form" action="" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="product_id" value="<?php echo $id ?>" />
                                            <div class="row media-addon">
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_thumb_images)? site_url($medisUrl.'/'.$product_thumb_images):"#"; ?>" id="thumb-image" data-toggle="image" class="img-thumbnail" mime-type="image">
       <img src="<?php echo !empty($product_thumb_images)? site_url($medisUrl.'/'.$product_thumb_images):site_url('assets/images/upload_img.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/upload_img.png'); ?>" />
                                                    <span class="media-info">Product Thumb Image</span>
                                                </a>
                                                <input type="hidden" name="product_thumb_images" value="<?php echo $product_thumb_images; ?>" id="input-image" />
                                                </div>
                                            </div>
											<div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_images)? site_url($medisUrl.'/'.$product_images):"#"; ?>" id="thumb-image" data-toggle="image" class="img-thumbnail" mime-type="image">
       <img src="<?php echo !empty($product_images)? site_url($medisUrl.'/'.$product_images):site_url('assets/images/upload_img.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/upload_img.png'); ?>" />
                                                    <span class="media-info">Product Ad Image</span>
                                                </a>
                                                <input type="hidden" name="product_images" value="<?php echo $product_images; ?>" id="input-image" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_video)? site_url($medisUrl.'/'.$product_video):"#"; ?>" id="thumb-video" data-toggle="image" class="img-thumbnail" mime-type="video">
                                                    <img src="<?php echo !empty($product_video)? site_url('assets/images/mp4.jpg'):site_url('assets/images/mp4-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp4-upload.png'); ?>" />
                                                    <span class="media-info">Product Video</span>
                                                </a>
                                                    <input type="hidden" name="product_video" value="<?php echo $product_video; ?>" id="input-video" />
                                                </div>
                                            </div>
											<div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_demo_video)? site_url($medisUrl.'/'.$product_demo_video):"#"; ?>" id="thumb-video" data-toggle="image" class="img-thumbnail" mime-type="video">
                                                    <img src="<?php echo !empty($product_demo_video)? site_url('assets/images/mp4.jpg'):site_url('assets/images/mp4-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp4-upload.png'); ?>" />
                                                    <span class="media-info">Product Demo Video</span>
                                                </a>
                                                    <input type="hidden" name="product_demo_video" value="<?php echo $product_demo_video; ?>" id="input-video" />
                                                </div>
                                            </div>
											<div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_push_ad_video)? site_url($medisUrl.'/'.$product_push_ad_video):"#"; ?>" id="thumb-video" data-toggle="image" class="img-thumbnail" mime-type="video">
                                                    <img src="<?php echo !empty($product_push_ad_video)? site_url('assets/images/mp4.jpg'):site_url('assets/images/mp4-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp4-upload.png'); ?>" />
                                                    <span class="media-info">Product Push Ad Video</span>
                                                </a>
                                                    <input type="hidden" name="product_push_ad_video" value="<?php echo $product_push_ad_video; ?>" id="input-video" />
                                                </div>
                                            </div>
											<div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_survey_video)? site_url($medisUrl.'/'.$product_survey_video):"#"; ?>" id="thumb-video" data-toggle="image" class="img-thumbnail" mime-type="video">
                                                    <img src="<?php echo !empty($product_survey_video)? site_url('assets/images/mp4.jpg'):site_url('assets/images/mp4-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp4-upload.png'); ?>" />
                                                    <span class="media-info">Product Survey Video</span>
                                                </a>
                                                    <input type="hidden" name="product_survey_video" value="<?php echo $product_survey_video; ?>" id="input-video" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_audio)? site_url($medisUrl.'/'.$product_audio):"#"; ?>" id="thumb-audio" data-toggle="image" class="img-thumbnail" mime-type="audio">
                                                    <img src="<?php echo !empty($product_audio)? site_url('assets/images/mp3.jpg'):site_url('assets/images/mp3-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp3-upload.png'); ?>" />
                                                    <span class="media-info">Product Audio</span>
                                                </a>
                                                    <input type="hidden" name="product_audio" value="<?php echo $product_audio; ?>" id="input-audio" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_pdf)? site_url($medisUrl.'/'.$product_pdf):"#"; ?>" id="thumb-pdf" data-toggle="image" class="img-thumbnail" mime-type="document">
                                                    <img src="<?php echo !empty($product_pdf)? site_url('assets/images/pdf.jpg'):site_url('assets/images/pdf-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/pdf-upload.png'); ?>" />
                                                    <span class="media-info">Product PDF</span>
                                                </a>
                                                    <input type="hidden" name="product_pdf" value="<?php echo $product_pdf; ?>" id="input-pdf" />
                                                </div>
                                            </div>
											<!-- Product Demo Video -->
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                    <a href="<?php echo !empty($product_demo_video)?site_url($medisUrl.'/'.$product_demo_video):"#"; ?>" id="thumb-demo-video" data-toggle="image" class="img-thumbnail" mime-type="video">
                                                    <img src="<?php echo !empty($product_demo_video)? site_url('assets/images/mp4.jpg'):site_url('assets/images/mp4-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp4-upload.png'); ?>" />
                                                    <span class="media-info">Product Demo Video</span>
                                                </a>
                                                    <input type="hidden" name="product_demo_video" value="<?php echo $product_demo_video; ?>" id="input-demo-video" />
                                                </div>
                                            </div>
											<!-- /Product Demo Video -->
											<!-- Product Push Ad Video -->
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                    <a href="<?php echo !empty($product_push_ad_video)?site_url($medisUrl.'/'.$product_push_ad_video):"#"; ?>" id="thumb-pushad-video" data-toggle="image" class="img-thumbnail" mime-type="video">
                                                    <img src="<?php echo !empty($product_push_ad_video)? site_url('assets/images/mp4.jpg'):site_url('assets/images/mp4-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp4-upload.png'); ?>" />
                                                    <span class="media-info">Product Push Ad Video</span>
                                                </a>
                                                    <input type="hidden" name="product_push_ad_video" value="<?php echo $product_push_ad_video; ?>" id="input-pushad-video" />
                                                </div>
                                            </div>
											<!-- /Product Push Ad Video -->
											<!-- Product Survey Video -->
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                    <a href="<?php echo !empty($product_survey_video)?site_url($medisUrl.'/'.$product_survey_video):"#"; ?>" id="thumb-survey-video" data-toggle="image" class="img-thumbnail" mime-type="video">
                                                    <img src="<?php echo !empty($product_survey_video)? site_url('assets/images/mp4.jpg'):site_url('assets/images/mp4-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp4-upload.png'); ?>" />
                                                    <span class="media-info">Product Survey Video</span>
                                                </a>
                                                    <input type="hidden" name="product_survey_video" value="<?php echo $product_survey_video; ?>" id="input-survey-video" />
                                                </div>
                                            </div>
											<!-- /Product Survey Video -->
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_demo_audio)? site_url($medisUrl.'/'.$product_demo_audio):"#"; ?>" id="thumb-demo-audio" data-toggle="image" class="img-thumbnail" mime-type="audio">
                                                    <img src="<?php echo !empty($product_demo_audio)? site_url('assets/images/mp3.jpg'):site_url('assets/images/mp3-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/mp3-upload.png'); ?>" />
                                                    <span class="media-info">Product Demo Audio</span>
                                                </a>
                                                    <input type="hidden" name="product_demo_audio" value="<?php echo $product_demo_audio; ?>" id="input-demo-audio" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="thumbnail">
                                                <a href="<?php echo !empty($product_user_manual)? site_url($medisUrl.'/'.$product_user_manual):"#"; ?>" id="thumb-user-manual" data-toggle="image" class="img-thumbnail">
                                                    <img src="<?php echo !empty($product_user_manual)? site_url("assets/images/pdf.jpg"):site_url('assets/images/pdf-upload.png'); ?>" alt="" title="" data-placeholder="<?php echo site_url('assets/images/pdf-upload.png'); ?>" />
                                                    <span class="media-info">Product User Manual</span>
                                                </a>
                                                    <input type="hidden" name="product_user_manual" value="<?php echo $product_user_manual; ?>" id="input-user-manual" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="form-field-description">Product Registration Loyalty Points : <input type="text" name="product_registration_lps" id="product_registration_lps" value="<?php echo $product_registration_lps; ?>" /> </label><br />
							  <label for="form-field-description">Product Image Response Loyalty Points : <input type="text" name="product_image_response_lps" id="product_image_response_lps" value="<?php echo $product_image_response_lps; ?>" /></label>
							  <label for="form-field-description"> FbQQ  : <input type="text" name="product_image_response_fbqq" id="product_image_response_fbqq" value="<?php echo $product_image_response_fbqq; ?>" /></label>
							  <br />
							   <label for="form-field-description">Product Audio Response Loyalty Points : <input type="text" name="product_audio_response_lps" id="product_audio_response_lps" value="<?php echo $product_audio_response_lps; ?>" /></label>
							   <label for="form-field-description"> FbQQ  : <input type="text" name="product_audio_response_fbqq" id="product_audio_response_fbqq" value="<?php echo $product_audio_response_fbqq; ?>" /></label>
							   <br />
							    <label for="form-field-description">Product Video Response Loyalty Points : <input type="text" name="product_video_response_lps" id="product_video_response_lps" value="<?php echo $product_video_response_lps; ?>" /></label>
								<label for="form-field-description"> FbQQ  : <input type="text" name="product_video_response_fbqq" id="product_video_response_fbqq" value="<?php echo $product_video_response_fbqq; ?>" /></label>
								<br />
								 <label for="form-field-description">Product Ad Response Loyalty Points : <input type="text" name="product_ad_response_lps" id="product_ad_response_lps" value="<?php echo $product_ad_response_lps; ?>" /></label>
								 <label for="form-field-description"> FbQQ  : <input type="text" name="product_ad_response_fbqq" id="product_ad_response_fbqq" value="<?php echo $product_ad_response_fbqq; ?>" /></label>
								 <br />
								  <label for="form-field-description">Product Survey Response Loyalty Points : <input type="text" name="product_survey_response_lps" id="product_survey_response_lps" value="<?php echo $product_survey_response_lps; ?>" /></label>
								  <label for="form-field-description"> FbQQ  : <input type="text" name="product_survey_response_fbqq" id="product_survey_response_fbqq" value="<?php echo $product_survey_response_fbqq; ?>" /></label>
								  <br />
								  
								   <label for="form-field-description">Product Survey Response Loyalty Points : <input type="text" name="product_pdf_response_lps" id="product_pdf_response_lps" value="<?php echo $product_pdf_response_lps; ?>" /></label>
								   <label for="form-field-description"> FbQQ  : <input type="text" name="product_image_response_lps" id="product_image_response_lps" value="<?php echo $product_image_response_lps; ?>" /></label>
								   <br />
								   
								    <label for="form-field-description">Product Survey Response Loyalty Points : <input type="text" name="product_demo_video_response_lps" id="product_demo_video_response_lps" value="<?php echo $product_demo_video_response_lps; ?>" /></label>
									<label for="form-field-description"> FbQQ  : <input type="text" name="product_demo_video_response_fbqq" id="product_demo_video_response_fbqq" value="<?php echo $product_demo_video_response_fbqq; ?>" /></label>
									<br />
									
									 <label for="form-field-description">Product Survey Response Loyalty Points : <input type="text" name="product_demo_audio_response_lps" id="product_demo_audio_response_lps" value="<?php echo $product_demo_audio_response_lps; ?>" /></label>
									 <label for="form-field-description"> FbQQ  : <input type="text" name="product_image_response_lps" id="product_image_response_lps" value="<?php echo $product_image_response_lps; ?>" /></label>
									 <br />
									<label for="form-field-description">Add Product Description :</label><br />
                                                    <textarea class="form-control" name="product_description" id="product-description" placeholder="Product description" rows="6"><?php echo $product_description; ?></textarea>
                                                </div>
                                            </div>    
                                            </div>
                                            <div class="form-actions center">
                                                <button type="submit" class="btn btn-sm btn-success" id="media-btn">Submit<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i></button>
                                            </div>
                                            </form>
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
    <script type="text/javascript" src="<?php echo site_url('assets');?>/js/media.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click','#media-btn',function(e){
                e.preventDefault();
                $("#media-btn").addClass('disabled');
                $.ajax({
                    url: site_url+"backend/product_attrribute/media_attribute",
                    type: "POST",
                    data: $("#media-form").serialize(),
                    dataType:"json"
                }).done(function( data ) {
                    $("#media-btn").removeClass('disabled');
                    if(data.status){
                        $("#ajax_msg").removeClass('alert-danger').addClass('alert-success').show().html(data.message);
                    }else{
                        $("#ajax_msg").removeClass('alert-success').addClass('alert-danger').show().html(data.message);
                    }
                  console.log(data);
                  //Perform ANy action after successfuly post data

                });
            });
        });
    </script>
    
   