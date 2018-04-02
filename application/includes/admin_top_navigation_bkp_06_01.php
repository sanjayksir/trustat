<style>

.no-skin .nav-list > li > a {height:auto;}

.text-info{ float:left; margin:10px}

#notifications-box{border: 1px solid #ccc;bottom: 100px;margin-left:100px;height: 100px;position: fixed; bottom:10px; right: 10px;width: 280px; background:#FFF; z-index:99;}

#notifications-box .widget-toolbar:before{content:none;}

.foottext-name{position: absolute;bottom: 5px;left: 13px;}

</style>





<body class="no-skin">

<!---------- Notoification Div------------------>

<div id="notifications-box"  style="display:none;">



<div class="widget-header">

<h5 class="widget-title">Story Notification</h5>

 <div class="widget-toolbar">

   <!-- <a href="#" data-action="settings">

    <i class="ace-icon fa fa-cog"></i>

    </a>-->

    <a href="javacript:void(0);" title="Close Notification" data-action="close">

    <i class="ace-icon fa fa-times" onClick="return close_notification();"></i>

    </a>

</div>



</div>



<div class="text-info">

    <p id="story_title"></p> 

</div>

 <div class="foottext-name">

    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<span id="reported_by"></span>

</div>

    

												

</div>

<!---------- Notoification Div------------------>

		<div id="navbar" class="navbar navbar-default ace-save-state">

			<div class="navbar-container ace-save-state" id="navbar-container">

				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">

					<span class="sr-only">Toggle sidebar</span>

 					<span class="icon-bar"></span>

 					<span class="icon-bar"></span>

 					<span class="icon-bar"></span>

				</button>



            

				<div class="navbar-header pull-left">

					<a href="<?php echo base_url()?>backend/dashboard" class="navbar-brand" title="Admin">

						Tracking Portal

					</a>

				</div>



				<div class="navbar-buttons navbar-header pull-right" role="navigation">

                

					<ul class="nav ace-nav">

                    	<?php //$this->load->view('notifications_tpl');?>

 						<li class="light-blue dropdown-modal">

							<a data-toggle="dropdown" href="#" class="dropdown-toggle"  title="<?php echo $this->session->userdata('user_name');?>">

								<img class="nav-user-photo" src="<?php echo ASSETS_PATH;?>images/avatars/user.jpg" alt="<?php echo $this->session->userdata('user_name');?>"  title="<?php echo $this->session->userdata('user_name');?>"/>

								<span class="user-info">

									<small>Welcome,</small>

									<?php echo $user_data = $this->session->userdata('user_name');?>

								</span>



								<i class="ace-icon fa fa-caret-down"></i>

							</a>



							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

								<li>

									<a href="<?php echo base_url().'backend/change_password/'; ?>" title="Change Password">

										<i class="ace-icon fa fa-cog"></i>

										Change Password

									</a>

								</li>



								<li>

									<a href="<?php echo base_url().'user_master/profile_user'; ?>" title="Profile">

										<i class="ace-icon fa fa-user"></i>

										Profile

									</a>

								</li>



								<li class="divider"></li>



								<li>

									<a href="<?php echo base_url().'backend/logout/'; ?>" title="Logout">

										<i class="ace-icon fa fa-power-off"></i>

										Logout

									</a>

								</li>

							</ul>

						</li>

					</ul>

				</div>

			</div><!-- /.navbar-container -->

		</div>