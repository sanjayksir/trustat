
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?php echo !empty($title)?$title:"Tracking Portal"; ?></title>

        <meta name="description" content="Static &amp; Dynamic Tables" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/fonts.googleapis.com.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/common.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="<?php echo site_url(); ?>assets/js/ace-extra.min.js"></script>

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="<?php echo site_url(); ?>assets/js/html5shiv.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo site_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
        <style>
        .no-skin .nav-list > li > a {height:auto;}
        .text-info{ float:left; margin:10px}
        #notifications-box{border: 1px solid #ccc;bottom: 100px;margin-left:100px;height: 100px;position: fixed; bottom:10px; right: 10px;width: 280px; background:#FFF; z-index:99;}
        #notifications-box .widget-toolbar:before{content:none;}
        .foottext-name{position: absolute;bottom: 5px;left: 13px;}
        </style>
    </head>

    <body class="no-skin">
        <div id="navbar" class="navbar navbar-default          ace-save-state">
            <div class="navbar-container ace-save-state" id="navbar-container">
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
                </button>

                <div class="navbar-header pull-left">
                    <a href="<?php echo base_url()?>backend/dashboard" title="howzzt"><img src="<?php echo base_url()?>/assets/images/finallogow.png" height="70"></a>
                </div>

                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="light-blue dropdown-modal">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle"  title="<?php echo $this->session->userdata('user_name');?>">
                                <?php 
                                $image = '';
                                $image = getUserProfileById($this->session->userdata('admin_user_id'));
                                if($image!=''){ ?>
                                <img class="nav-user-photo" src="<?php echo $image;?>" alt="<?php echo $this->session->userdata('user_name');?>"  title="<?php echo $this->session->userdata('user_name');?>"/>
                                <?php } ?>
                                <span class="user-info" style="font-size:20px">
                                    <?php
                                    $user_name = getUserFullNameById($this->session->userdata('admin_user_id'));
                                    if(empty($user_name)){
                                        $user_name_arr =  get_rwa_username($this->session->userdata('admin_user_id'));
                                        $user_name=$user_name_arr[0]['user_name'];
                                    }
                                    echo $user_name;
                                    ?>
                                </span>
                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>
                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href="<?php echo base_url().'backend/change_password/'; ?>" title="Change Password"><i class="ace-icon fa fa-cog"></i>Change Password</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url().'user_master/profile_user'; ?>" title="Profile"><i class="ace-icon fa fa-user"></i>Profile</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo base_url().'backend/logout/'; ?>" title="Logout"><i class="ace-icon fa fa-power-off"></i>Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- /.navbar-container -->
        </div>

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.loadState('main-container')
                } catch (e) {
                }
            </script>

            <?php $this->load->view('../includes/admin_sidebar');?>

            <div class="main-content">
                <div class="main-content-inner">
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <?php
                        if(empty($breadcrumb)){
                           $breadcrumb = [] ;
                        }
                        echo Utils::renderBreadCrumb($breadcrumb);                         
                        ?>
                    </div>

                    <div class="page-content">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <?php $this->load->view($view); ?>

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder"><?=$this->config->item('site_name') ?> </span>&copy; 2017-<?=date('Y') ?>
                        </span>

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

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->


        <!-- <![endif]-->

        <!--[if IE]>
<script src="<?php echo site_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='<?php echo site_url(); ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="<?php echo site_url(); ?>assets/js/bootstrap.min.js"></script>

        <!-- page specific plugin scripts -->
        <script src="<?php echo site_url(); ?>assets/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/buttons.flash.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/buttons.html5.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/buttons.print.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/buttons.colVis.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/dataTables.select.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/bootbox.js"></script>

        <!-- ace scripts -->
        <script src="<?php echo site_url(); ?>assets/js/ace-elements.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/js/ace.min.js"></script>

    </body>
</html>
