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
                        <h4 class="widget-title smaller">Media Type</h4>
                        <div class="widget-toolbar no-border">
                            <a href="#description-modal" class="btn btn-success btn-sm" data-toggle="modal">Add Description</a>
                            <a href="<?php echo base_url();?>product/list_product" class="btn btn-info btn-sm">List Product SKUs</a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    <div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product Images</h6>
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
                                        <h6 class="widget-title smaller lighter">Product Video</h6>
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
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 widget-box transparent text-center">
                                    <div class="widget-header widget-header-small">
                                        <h6 class="widget-title smaller lighter">Product PDF</h6>
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
                    <h4 class="blue bigger">Product Media Description</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="alert alert-media-box hidden">
                            <button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
                        </div>
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="form-field-description">Add Description</label>
                                <div>
                                    <textarea class="form-control" name="product_description" id="product-description" placeholder="Product description" rows="6"><?php echo $product_description; ?></textarea>
                                </div>
                            </div>
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
            $("#product_images").uploadFile({
                uploadStr:"Select Images",
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
            }); 
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
            }); 
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
                uploadStr:"Product Pdf",
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
            $(document).on('click','#media-description',function(e){
                e.preventDefault();
                $("#media-description").addClass('disabled');
                $(".alert-media-box").removeClass('alert-success').removeClass('alert-danger');
                $.ajax({
                    url:site_url+"backend/product_attrribute/media_description/<?php echo base64_encode($id); ?>",
                    type: "POST",
                    data: {"product_description":$("#product-description").val()},
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
    
   