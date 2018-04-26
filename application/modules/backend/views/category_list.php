<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); ?>
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
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                       <a href="<?php echo DASH_B;?>">Home</a>
                    </li>

                    <li>
                        <a href="#">Master</a>
                    </li>
                    <li class="active">MANAGE CATEGORY</li>
                </ul><!-- /.breadcrumb -->

                <div class="nav-search" id="nav-search">
                    <!--form class="form-search"-->
                    <?php
   
   echo form_open("Buzzadmn/Managecategory/",'id="form"');
	  ?>
                        <span class="input-icon">
                            <input type="hidden" name="stchstatussrch" value="1">
                            <input type="text" placeholder="Search ..." class="nav-search-input" id="keyword" autocomplete="off" name="keyword" value="<?php echo $this->input->post('keyword');?>" />
                            <i  onclick="$('#form').submit();" class="ace-icon fa fa-search nav-search-icon"></i>
                        </span>
                    <?php echo form_close(); ?>
                    <!--/form-->
                </div><!-- /.nav-search -->
            </div>

            <div class="page-content">
                <?php if ($this->session->flashdata('msg') != '') { ?> <div class="alert alert-block alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>

                        <i class="ace-icon fa fa-check green"></i>

                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                <?php } ?>
                <!--div class="page-header">
                    <h1>
                        Master
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            MANAGE CATEGORY
                        </small>
                    </h1>
                </div--><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">



                        <div class="row">
                            <div class="col-xs-12">
                                <h3 class="header smaller lighter blue">MANAGE CATEGORY</h3>
                                <div class="table-header">
                                    Results for "CATEGORY"
                                </div>
								<div style="clear:both;"><?php echo anchor('Buzzadmn/Managecategory/addCategory', 'ADD CATEGORY', ['class' => 'btn btn-primary pull-right']); ?></div>
                                
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover">  

                                    <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th class="hidden-480">Category Name</th>
                                            <th>CreatedDate</th>
                                            <th>CreatedBy</th>
                                            <th>ModifiedDate</th>
                                            <th>ModifiedBy</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($categorylist as $categoryData):
                                            ?>
                                            <tr id="show<?php echo $categoryData['category_Id']; ?>">
                                               
                                                <td><?php echo $categoryData['categoryName']; ?></td>
                                                <td><?php echo $categoryData['categoryName']; ?></td>
                                                <td><?php echo $categoryData['createdDate']; ?></td>
                                                <td><?php echo $categoryData['createdBy']; ?></td>
                                                <td><?php echo $categoryData['updatedDate']; ?></td>
                                                <td><?php echo $categoryData['updatedBy']; ?></td>                             
                                                <td>
														<div class="hidden-sm hidden-xs btn-group">
															<button class="btn btn-xs btn-success">
																<i class="ace-icon fa fa-check bigger-120"></i>
															</button>

															<button class="btn btn-xs btn-info">
																<i class="ace-icon fa fa-pencil bigger-120"></i>
															</button>

															<button class="btn btn-xs btn-danger">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>
															</button>

															<button class="btn btn-xs btn-warning">
																<i class="ace-icon fa fa-flag bigger-120"></i>
															</button>
														</div>

														
													</td>
                                                
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
								 </div><!-- /.col -->
                                <?php echo $this->pagination->create_links(); ?>
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
                            <span class="blue bolder">Spidey Buzz</span>
                            <?=date('Y');?>
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

        <?php $this->load->view('../includes/admin_footer'); ?>
