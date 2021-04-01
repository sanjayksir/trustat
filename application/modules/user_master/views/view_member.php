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
							<?php if($get_user_details[0]['designation_id']==2){ ?>	
									<a href="<?php echo base_url()?>product/ispl_billing_list_items/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="ISPL Billing" style="margin-right:1px; margin-bottom:4px">ISPL Billing</a>
							
							<a href="<?php echo base_url()?>customer/payment_list/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Payments" style="margin-right:1px; margin-bottom:4px">Payments</a>
							
							<a href="<?php echo base_url()?>product/list_customer_loyalty_summary/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Customer Passbook" style="margin-right:1px; margin-bottom:4px">Customer Passbook</a>
							
							<a href="<?php echo base_url()?>product/referral_mis/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Referral MIS" style="margin-right:1px; margin-bottom:4px">Referral MIS</a>
							
							<a href="<?php echo base_url()?>product/in_store_redemption_mis/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="In-Store Redemption MIS" style="margin-right:1px; margin-bottom:4px">In-Store Redemption MIS</a>
							
							<a href="<?php echo base_url()?>product/mis_redemption_microsite/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="MIS Redemption Through Microsite" style="margin-right:1px; margin-bottom:4px">MIS Redemption Microsite</a>
							
							<a href="<?php echo base_url()?>plant_master/list_locations/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Location Master" style="margin-right:1px; margin-bottom:4px">Location Master</a>
							
							<a href="<?php echo base_url()?>product/list_all_consumers/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Consumer Profile" style="margin-right:1px; margin-bottom:4px">Consumer Profile</a>
							
							<a href="<?php echo base_url()?>order_master/list_orders/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Order Mgt" style="margin-right:1px; margin-bottom:4px">Order Mgt</a>
							
							<a href="<?php echo base_url()?>product/list_product/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Product Mgt" style="margin-right:1px; margin-bottom:4px">Product Mgt</a>
							
							<a href="<?php echo base_url()?>user_master/list_tracek_users/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Tracek User Mgt" style="margin-right:1px; margin-bottom:4px">Tracek User Mgt</a>
							
							<a href="<?php echo base_url()?>product/tracek_loyalty_redemption/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Tracek Loyalty Redemption" style="margin-right:1px; margin-bottom:4px">Tracek Loyalty Redemption</a>
							
							<a href="<?php echo base_url()?>role_master/list_all_auto_email_mis_customer/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Auto Email MIS Configuration" style="margin-right:1px; margin-bottom:4px">Auto Email MIS Configuration</a>
							
							<a href="<?php echo base_url()?>plant_master/list_assigned_locations_sku/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Assign Product to Plant" style="margin-right:1px; margin-bottom:4px">Assign Product to Plant</a>
							
							<a href="<?php echo base_url()?>role_master/list_assigned_functionalities_to_role/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Assign Activity to Role" style="margin-right:1px; margin-bottom:4px">Assign Activity to Role</a>
							
							<a href="<?php echo base_url()?>order_master/list_customer_codes/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Customer Code Management" style="margin-right:1px; margin-bottom:4px">Customer Code Mgt</a>
							
							<a href="<?php echo base_url()?>order_master/list_tracek_reports/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="Customer Code Management" style="margin-right:1px; margin-bottom:4px">Tracek Reports</a>
							
							<!--
							<a href="<?php echo base_url()?>user_master/add_plant_controller/<?php echo $get_user_details[0]['user_id'];?>" class="btn btn-primary pull-left" title="List Users">Add Tracek User</a>
							-->
							
							
							<?php } ?>
							<?php } ?>
							</div>
                        <div class="row">

                          <div class="col-xs-12">

                            <div class="row" id="add_edit_div">

                               <div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title"><?php if($this->session->userdata('admin_user_id')==1){ echo "Customer Master"; }else{ echo "View Profile"; } ?></h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				 
        <div class="widget-main">
	<fieldset>
	<legend><?php if($this->session->userdata('admin_user_id')==1){ echo "Organization"; }else{ echo "User"; } ?> Profile</legend>
		<div class="form-group row">
		<?php if($this->session->userdata('admin_user_id')==1){ ?>
		<div class="col-sm-4">
			  <label for="form-field-8"><b>Organization Name</b></label>
			<div class=""><?php echo $get_user_details[0]['f_name'];?></div>
			</div>
			<?php } ?>
			
			<div class="col-sm-4">
			<label for="form-field-8"><b>Unique User/Customer Code<?php //echo $get_user_details[0]['designation_id'];?></b></label>
			: <?php echo $get_user_details[0]['customer_code'];?>		 
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Phone#</b></label>
             : <?php echo $get_user_details[0]['mobile_no'];?>
			</div>
			<?php if($this->session->userdata('admin_user_id')==1){?>
			<?php if($get_user_details[0]['designation_id']==2){ ?>	
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Pan</b></label>
             <div class=""><?php echo $get_user_details[0]['pan'];?></div>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Customer Microsite URL</b></label>
			 <div class=""><?php echo $get_user_details[0]['customer_microsite_url'];?></div>
			</div>
			
			<div class="col-sm-4">
			 <label for="form-field-9"><b>State</b></label>
			 <?php $states = get_state_name(31);?>
   		  		<?php foreach($states as $val){
					if($val['state_id']==$get_user_details[0]['state']){?>
					<div class=""><?php  echo $val['state_name'];?></div>
				<?php }}?>
 			</div>
			
			<div class="col-sm-4"><?php //print_r($show_city_name);?>
			 <label for="form-field-9"><b>City</b></label>
              <div class=""><?php  echo $show_city_name[0]['city_name'];?></div>
 			</div>
			<?php } ?>
			<?php } ?>
			
			<div class="col-sm-4">
			<?php if(empty($get_user_details[0]['profile_photo']) || !file_exists('./uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'])){?>
			<?php }else{?>
			  <label for="form-field-8"><b>Profile Image</b></label> : 
               	
				<!--	 <img src="<?php echo base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'];?>" width="150px" height="120px;" />-->
					 <a href="<?php echo base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'];?>" onclick="window.open (this.href, 'child', 'height=800,width=900'); return false"><img alt="Non Warranty Product, Invoice Not Required" src="<?php echo base_url().'uploads/rwaprofilesettings/thumb/thumb_'.$get_user_details[0]['profile_photo'];?>" height="90" width="90"></a>
               
				<?php }?>
			</div>
			
			<div class="col-sm-12">
			  <label for="form-field-8"><b>Remark</b></label>
             <div class="" style="height: 100px;overflow: scroll;"><?php echo $get_user_details[0]['remark'];?></div>
			</div> 
			
			<?php if($this->session->userdata('admin_user_id')==1){?>
			<?php if($get_user_details[0]['designation_id']==2){ ?>	
			<div class="col-sm-4">
			<label for="form-field-8"><b>Industry</b></label>
			<div class=""><?php echo $get_user_details[0]['industry'];?></div>
			</div>
		<?php }?>
			<?php }?>
			<?php if($this->session->userdata('admin_user_id')==1){?>
			<?php if($get_user_details[0]['designation_id']==2){ ?>	
			<div class="col-sm-4">
			  <label for="form-field-8">Complaint Email ID</label>
             <div class="form-control"><?php echo $get_user_details[0]['complaint_email_id'];?></div>
			</div> 
		<div class="col-sm-4">
      <label for="form-field-8">Feedback Email ID</label>
      <div class="form-control"><?php echo $get_user_details[0]['feedback_email_id'];?></div>
		</div>
		<?php }?>
		<?php }?>
		</div>		
		</fieldset>
		<hr />
	<fieldset>
	<legend>User Details</legend>
		<div class="form-group row">
		<div class="col-sm-4">
			  <label for="form-field-8"><b>Login User Name</b></label>
             : <?php echo $get_user_details[0]['user_name'];?>
			</div>
			
 			<div class="col-sm-4">
			  <label for="form-field-8"><b>Person Name</b></label>
			 : <?php echo $get_user_details[0]['l_name'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Email ID</b></label>
            : <?php echo $get_user_details[0]['email_id'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Role of user</b></label> :
			 <?php echo getRoleNameById($get_user_details[0]['designation_id']);?>
			</div>
			
			<?php if($this->session->userdata('admin_user_id')>1){?>	
			<?php if($get_user_details[0]['designation_id']>2){ ?>	
			<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Assigned Locations</b></label> :
			 <?php echo get_locations_name_by_id(get_assigned_location_user_list($get_user_details[0]['user_id'])); ?>
			</div>			
		</div>
		<?php }?>
		<?php }?>
		
		</div>
		
		</fieldset>
		
		
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<?php if($get_user_details[0]['designation_id']==2){ ?>	
		 <hr />
	<fieldset>
		<legend>Customer Loyalty Type</legend>
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Customer Loyalty Type</b></label>
             <div class=""><?php echo $get_user_details[0]['customer_loyalty_type'];?></div>
			 
			 <script type="text/javascript">
				function showDiv2(select){
				   if(select.value=="Brand"){
					document.getElementById('hidden_div2').style.display = "block";
				   } else{
					document.getElementById('hidden_div2').style.display = "none";
				   }
				} 
			</script>
			<script type="text/javascript">
				function showDiv2(select){
				   if(select.value=="Brand"){
					document.getElementById('hidden_div4').style.display = "block";
				   } else{
					document.getElementById('hidden_div4').style.display = "none";
				   }
				} 
			</script>
			<script type="text/javascript">
				function showDiv2(select){
				   if(select.value=="Brand"){
					document.getElementById('hidden_div5').style.display = "block";
				   } else{
					document.getElementById('hidden_div5').style.display = "none";
				   }
				} 
			</script>
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
			<div class="col-sm-4"><?php //print_r($show_city_name);?>
			 <label for="form-field-9"><b>Loyalty Points for consumer on view Notification</b></label>
              <div class=""><?php  echo $get_user_details[0]['loyalty_points_consumer_view_notification_lps'];?></div>
 			</div>
			
			<div class="col-sm-4"><?php //print_r($show_city_name);?>
			 <label for="form-field-9"><b>Loyalty Point weightage with compare to currency in %</b></label>
              <div class=""><?php  echo $get_user_details[0]['loyalty_point_weightage'];?></div>
 			</div>
		</div>
		
		<div id="hidden_div2" <?php if($get_user_details[0]['customer_loyalty_type']=='TRUSTAT'){ ?> style="display:none;" <?php } ?>>
		<div class="form-group row">
		
		<div class="col-sm-4">
			 <label for="form-field-9"><b>Brand Loyalty Redemption Type</b></label>
              <div class=""><?php  echo $get_user_details[0]['brand_loyalty_redemption_type'];?></div>
 			</div>
			
			<div id="hidden_div4" <?php if($get_user_details[0]['brand_loyalty_redemption_type']!='CompanyWebsite'){ ?> style="display:none;" <?php } ?>>
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Customer Microsite URL</b></label>
			 <div class=""><?php echo $get_user_details[0]['customer_microsite_url'];?></div>
			</div>
			</div>
			
			<div id="hidden_div5" <?php if($get_user_details[0]['brand_loyalty_redemption_type']!='CompanyStores'){ ?> style="display:none;" <?php } ?>>
			<div class="col-sm-4">
			 <label for="form-field-9"><b>Brand Loyalty/Store Redemption/Message</b></label>
              <div class=""><?php  echo $get_user_details[0]['brand_loyalty_store_redemption_message'];?></div>
 			</div>
			
			
			</div>	
			<div class="col-sm-4">
			 <label for="form-field-9"><b>% of Loyalty Points redeemed in a single Order</b></label>
              <div class=""><?php  echo $get_user_details[0]['percent_lty_pts_consumer_red_cashier'];?></div>
 			</div>
			
			<!--
			<div class="col-sm-4">
			 <label for="form-field-9"><b>TRUSTAT Coupon Type/Name/Number</b></label>
              <div class=""><?php  echo $get_user_details[0]['trustat_coupon_type_name_number'];?></div>
 			</div>-->
		</div>
		</div>
		
		</fieldset>
		<?php }?>
		<?php }?>
			
		     

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
