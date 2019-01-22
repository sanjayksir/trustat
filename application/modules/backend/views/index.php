<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>

<script src="<?php echo ASSETS_PATH;?>js/jquery-2.1.4.min.js"></script>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<?php $this->load->view('../includes/admin_sidebar');?>
			
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo site_url(); ?>">Home</a>
							</li>

							<li class="active">Locations</li>
						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.nav-search -->
					</div>

					<div class="page-content">
						 

						<div class="page-header">
							<h1>
								Locations
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									List
								</small>
							</h1>
						</div><!-- /.page-header -->
						<!--
						<div class="row">
							<div class="col-xs-12">	
								<div class="row">
									<div class="col-xs-12">
										<h3 class="header smaller lighter blue">Welcome to dashboard!</h3>
									 
										
									</div>
								</div>
								-->
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
							<span class="blue bolder">Cityspidey</span>
							2017
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

		<div class="modal fade" id="myModal" role="dialog">
        	<div class="modal-dialog">
            	<span id="edit_popup_model"> </span>

          		<!-- Modal content-->
          		<div class="modal-content"></div>
        	</div>
      	</div>
		
		<div class="modal fade" id="addModal" role="dialog">
        	<div class="modal-dialog">
            	<span id="add_modal_popup"> </span>

          		<!-- Modal content-->
          		<div class="modal-content"></div>
        	</div>
      	</div>
 

<?php $this->load->view('../includes/admin_footer');?>