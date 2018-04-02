<?php $this->load->view('../includes/admin_header');?>
 <?php $this->load->view('../includes/admin_top_navigation');?>
  <div class="main-container ace-save-state" id="main-container"> 
 	<script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
    </script>
   <?php $this->load->view('../includes/admin_sidebar');?>
    <div class="main-content">
     <div class="main-content-inner">
       <div class="breadcrumbs ace-save-state" id="breadcrumbs">
         <ul class="breadcrumb">
           <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo site_url(); ?>">Home</a> </li>
 		 				<?php $constant = "View Profile" ; ?>	
          <li class="active">Administration</li><li class="active"><?php echo $constant;?></li>

        </ul>
       </div>
       <div class="page-content">
         <div class="row">
           <div class="col-xs-12">
             <div class="row">
               <div class="col-xs-12">
                 <h3 class="header smaller lighter blue"><?php echo $constant;?></h3>
                   
                  <!--<div class="table-header">
 											Results for "Locations"
 										</div>--><br>
                 <div class="row">

                  <div class="col-xs-12">
                     <!--left end---->
                     <div class="col-xs-12">

                      <div class="tab-pane fade active in">

                        <?php //echo '<pre>';print_r($get_user_details);exit;//$this->load->view('add_menu_form_tpl');?>
							<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>user_master/list_user/" class="btn btn-primary pull-right" title="List Plant Controller">List Plant Controller </a></div>
                        <div class="row">

                          <div class="col-xs-12">

                            <div class="row" id="add_edit_div">

                               <div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">View Profile</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				 
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Customer Code</label>
			<div class="form-control"><?php echo $get_user_details[0]['customer_code'];?></div>
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Phone#</label>
             <div class="form-control"><?php echo $get_user_details[0]['mobile_no'];?></div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">User Name</label>
             <div class="form-control"><?php echo $get_user_details[0]['user_name'];?></div>
			</div>
			 
			
			<div class="col-sm-6">
			  <label for="form-field-8">Email ID</label>

            <div class="form-control"><?php echo $get_user_details[0]['email_id'];?></div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">First Name</label>
			<div class="form-control"><?php echo $get_user_details[0]['f_name'];?></div>
			</div>
 			<div class="col-sm-6">
			  <label for="form-field-8">Last Name</label>
			 <div class="form-control"><?php echo $get_user_details[0]['l_name'];?></div>
			</div>
		</div>
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Industry</label>
			<div class="form-control"><?php echo $get_user_details[0]['industry'];?></div>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Pan</label>
             <div class="form-control"><?php echo $get_user_details[0]['pan'];?></div>
			</div>
		</div>
  		<div class="form-group row">
			<div class="col-sm-6">
			 <label for="form-field-9">State</label>
			 <?php $states = get_state_name(31);?>
   		  		<?php foreach($states as $val){
					if($val['state_id']==$get_user_details[0]['state']){?>
					<div class="form-control"><?php  echo $val['state_name'];?></div>
				<?php }}?>
 			</div>
			 
			
			<div class="col-sm-6"><?php //print_r($show_city_name);?>
			 <label for="form-field-9">City</label>
              <div class="form-control"><?php  echo $show_city_name[0]['ci_name'];?></div>
 			</div>
		</div>
		
		<?php }?>
		 
		
		<div class="form-group row">
			<div class="col-sm-6">
			<?php if(empty($get_user_details[0]['profile_photo']) || !file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'])){?>
			<?php }else{?>
			  <label for="form-field-8">Profile Image</label>

                <div class="widget-body">
 					
					
					 <img src="<?php echo base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'];?>" width="150px" height="120px;" />
					

                </div>
				<?php }?>
			</div>
			<div class="col-sm-6">
			  <label for="form-field-8">Remark</label>
             <div class="form-control" style=" height: 100px;overflow: scroll;"><?php echo $get_user_details[0]['remark'];?></div>
			</div> 
			 
		</div>
		 
		     

           <hr>
 

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

                

                <!-- div.table-responsive --> 

                <!-- div.dataTables_borderWrap --> 

              </div>

            </div>

            <!-- PAGE CONTENT ENDS --> 

          </div>

          <!-- /.col --> 

        </div>

        <!-- /.row --> 

      </div>

      <!-- /.page-content --> 

    </div><div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						 


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

  </div>

  <!-- /.main-content --> 

  

</div>

<!-- /.main-container -->



<div class="modal fade" id="myModal" role="dialog">

  <div class="modal-dialog"> <span id="edit_popup_model"> </span> 

    

    <!-- Modal content-->

    <div class="modal-content"></div>

  </div>

</div>

<div class="modal fade" id="addModal" role="dialog">

  <div class="modal-dialog"> <span id="add_modal_popup"> </span> 

    

    <!-- Modal content-->

    <div class="modal-content"></div>

  </div>

</div>
 

<?php $this->load->view('../includes/admin_footer');?>
