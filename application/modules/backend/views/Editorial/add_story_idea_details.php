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
                                            <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail ace-icon fa-file-image-o"></a>
                                            <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                                            </div>

                                            <div>
                                                <a href="" id="profile-image" data-toggle="image" class="img-thumbnail">
                                                    <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                                                </a>
                                                <input type="hidden" name="profile" value="<?php echo $image; ?>" id="input-image" />
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
    <script type="text/javascript" src="<?php echo site_url('asssets');?>/js/media.js"></script>
    
   