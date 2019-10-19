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
                 <!--<h3 class="header smaller lighter blue"><?php echo $constant;?></h3>
                   
                  <div class="table-header">
 											Results for "Locations"
 										</div>-->
                 <div class="row">

                  <div class="col-xs-12">
                     <!--left end---->
                     <div class="col-xs-12">

                      <div class="tab-pane fade active in">

                        <?php //echo '<pre>';print_r($get_user_details);exit;//$this->load->view('add_menu_form_tpl');?>
							<div style="clear:both;height:40px;">
							
							<?php if($this->session->userdata('admin_user_id')==1){?>
									<a href="<?php echo base_url()?>customer/bill_list/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">ISPL Billing</a>
							
							<a href="<?php echo base_url()?>customer/payment_list/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">Payments</a>
							
							<a href="<?php echo base_url()?>product/list_customer_loyalty_summary/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">Customer Passbook</a>
							
							<a href="<?php echo base_url()?>plant_master/list_locations/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">Locations</a>
							
							<a href="<?php echo base_url()?>product/list_all_consumers/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">Consumer Profile</a>
							
							<a href="<?php echo base_url()?>order_master/list_orders/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">Order Mgt</a>
							
							<a href="<?php echo base_url()?>product/list_product/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">Product Mgt</a>
							
							<a href="<?php echo base_url()?>user_master/list_tracek_users/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">Tracek User Mgt</a>
							
							
							
							<a href="<?php echo base_url()?>user_master/add_plant_controller/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-right" title="List Users">Add Tracek User</a>
							
							
							
							
							<?php } ?>
							</div>
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
			<div class="col-sm-4">
			<label for="form-field-8"><b>Customer Code</b></label>
			<div class=""><?php echo $get_user_details[0]['customer_code'];?></div>
			 
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Phone#</b></label>
             <div class=""><?php echo $get_user_details[0]['mobile_no'];?></div>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>User Name</b></label>
             <div class=""><?php echo $get_user_details[0]['user_name'];?></div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8"><b>First Name</b></label>
			<div class=""><?php echo $get_user_details[0]['f_name'];?></div>
			</div>
 			<div class="col-sm-4">
			  <label for="form-field-8"><b>Last Name</b></label>
			 <div class=""><?php echo $get_user_details[0]['l_name'];?></div>
			</div>
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Email ID</b></label>

            <div class=""><?php echo $get_user_details[0]['email_id'];?></div>
			</div>
		</div>
		<div class="form-group row">
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Role of user</b></label>
			 <div class=""><?php echo getRoleNameById($get_user_details[0]['designation_id']);?></div>
			</div>
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Assigned Locations</b></label>
			 <div class=""><?php echo get_locations_name_by_id(get_assigned_location_user_list($get_user_details[0]['user_id'])); ?></div>
			</div>
			<div class="col-sm-4"><?php //print_r($show_city_name);?>
			 <label for="form-field-9"><b>City</b></label>
              <div class=""><?php  echo $show_city_name[0]['ci_name'];?></div>
 			</div>
		</div>
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Industry</b></label>
			<div class=""><?php echo $get_user_details[0]['industry'];?></div>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Pan</b></label>
             <div class=""><?php echo $get_user_details[0]['pan'];?></div>
			</div>
			
			<div class="col-sm-4">
			 <label for="form-field-9"><b>State</b></label>
			 <?php $states = get_state_name(31);?>
   		  		<?php foreach($states as $val){
					if($val['state_id']==$get_user_details[0]['state']){?>
					<div class=""><?php  echo $val['state_name'];?></div>
				<?php }}?>
 			</div>
			
		</div>
  		<div class="form-group row">
			
			 
			
			
		</div>
		
		<?php }?>
		 
		<div class="form-group row">
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Customer Microsite URL</b></label>
			 <div class=""><?php echo $get_user_details[0]['customer_microsite_url'];?></div>
			</div>
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Days for expiry from the date of Loyalty Point Credited</b></label>
			 <div class=""><?php echo $get_user_details[0]['days_for_expiry_of_point_credited']; ?></div>
			</div>
			<div class="col-sm-4"><?php //print_r($show_city_name);?>
			 <label for="form-field-9"><b>Days for Notification Before Expiry of Loyalty Point</b></label>
              <div class=""><?php  echo $get_user_details[0]['days_for_notification_before_expiry_of_lps'];?></div>
 			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4">
			<?php if(empty($get_user_details[0]['profile_photo']) || !file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'])){?>
			<?php }else{?>
			  <label for="form-field-8">Profile Image</label>

                <div class="widget-body">
 					
					
					 <img src="<?php echo base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'];?>" width="150px" height="120px;" />
					

                </div>
				<?php }?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Customer Loyalty Type</b></label>
             <div class=""><?php echo $get_user_details[0]['customer_loyalty_type'];?></div>
			</div> 
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Remark</b></label>
             <div class="" style="height: 100px;overflow: scroll;"><?php echo $get_user_details[0]['remark'];?></div>
			</div> 
			 
		</div>
		 
		<div class="form-group row">

			<!--
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Customer Microsite URL</b></label>
             <div class=""><?php //echo $get_user_details[0]['customer_microsite_url'];?></div>
			</div> 
			-->
			
			 
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
