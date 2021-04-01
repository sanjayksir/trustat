<?php 
//echo '<pre>';print_r($get_user_details);exit;

$this->load->view('../includes/admin_header');?>
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
 		 				<?php $constant = "View Location Detail" ; ?>	
          <li class="active">Administration</li><li class="active"><?php echo $constant;?></li>

        </ul>
       </div>
       <div class="page-content">
         <div class="row">
           <div class="col-xs-12">
             <div class="row">
               <div class="col-xs-12">
                 <h3 class="header smaller lighter blue"><?php echo $constant;?></h3>
				 <?php if($this->session->userdata('admin_user_id')==1){ ?>
           <div style="clear:both;height:40px;"><a href="<?php echo base_url()?>plant_master/list_locations/<?php echo $get_user_details[0]['created_by'];?>" class="btn btn-primary pull-right" title="Add Location">Back to List Locations</a></div>
			<?php	 }else{ ?>
		<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>plant_master/list_locations" class="btn btn-primary pull-right" title="Add Location">Back to List Locations</a></div>			 
				<?php } ?>
                  <!--<div class="table-header">
 											Results for "Locations"
 										</div>--><br>
                 <div class="row">

                  <div class="col-xs-12">
                     <!--left end---->
                     <div class="col-xs-12">

                      <div class="tab-pane fade active in">

                        <?php //echo '<pre>';print_r($get_user_details);exit;//$this->load->view('add_menu_form_tpl');?>

                        <div class="row">

                          <div class="col-xs-12">

                            <div class="row" id="add_edit_div">

                               <div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title">View Location Detail</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
<input type="hidden" name="location_id" id="location_id" value="<?php echo  $get_user_details[0]['location_id']?>" />
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Location Code</b></label> :
			<?php echo $get_user_details[0]['location_code'];?>			 
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Location Name</b></label> : 
             <?php echo $get_user_details[0]['location_name'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Location Type</b></label> : 
             <?php echo $get_user_details[0]['location_type'];?>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Email</b></label> : 
			<?php echo $get_user_details[0]['email_id'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Phone</b></label> : 
             <?php echo $get_user_details[0]['phone'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>GST</b></label> : 
			<?php echo $get_user_details[0]['gst'];?>
			</div>
		</div>
		
				
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Street Address</b></label> : 
			<?php echo $get_user_details[0]['street_address'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Locality</b></label> : 
			 <?php echo $get_user_details[0]['locality'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>City</b></label> : 
			<?php echo $get_user_details[0]['city'];?>
			</div>
		</div>
		
		
		
		<div class="form-group row">
		
		<div class="col-sm-4">
			  <label for="form-field-8"><b>District</b></label> : 
			 <?php echo $get_user_details[0]['district'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Pin Code</b></label> : 
			 <?php echo $get_user_details[0]['pin_code'];?>
			</div>
			 
			<div class="col-sm-4">
			 <label for="form-field-9"><b>State</b></label> : 
			 <?php $states = get_state_name(31);?>
             
  		  		<?php foreach($states as $val){
					if($val['state_id']==$get_user_details[0]['state']){?>
					 <?php  echo $val['state_name'];?>
			 	<?php }}?>
			
			</div>
		</div>
		
				<div class="form-group row">		
		<div class="col-sm-4">
			  <label for="form-field-8"><b>Location Longitude</b></label> : 
			  <?php echo $get_user_details[0]['location_longitude'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Location Latitude</b></label> : 
			  <?php echo $get_user_details[0]['location_latitude'];?>
			</div>
			 
			 <div class="col-sm-4">
			  <label for="form-field-8"><b>Landmark or Near by</b></label> : 
			  <?php echo $get_user_details[0]['landmark'];?>
			  
            <!--<textarea  class="form-control" name="landmark" id="landmark" placeholder="Landmark or Near by..."><?php echo $get_user_details[0]['landmark'];?></textarea> -->
			</div>
			
		</div>
		
		
				<div class="form-group row">
			
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Store Timings</b></label> : 
			  <?php echo $get_user_details[0]['store_timings'];?>
			</div>
			
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Location Image</b></label> : 
 <a href="<?php echo $get_user_details[0]['location_image'];?>" onclick="window.open (this.href, 'child', 'height=800,width=900'); return false"><img alt="Image Not Available" src="<?php echo $get_user_details[0]['location_image'];?>" height="50" width="50"></a>
 <!--<img src="<?php echo $get_user_details[0]['location_image'];?>" width="150px" height="120px;" title="<?php echo $get_user_details[0]['location_image'];?>" />-->
	
	
			</div>
			
 			<div class="col-sm-4">
			  <label for="form-field-8"><b>Remark</b></label> : 
			  <?php echo $get_user_details[0]['remark'];?>
			</div>
		</div>
		
		
		<!--
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Created By</label>
			 <div class="form-control"> <?php //echo getUserNameById($get_user_details[0]['created_by']);?></div>
			</div>
		</div>
		-->
		
		
		 
		 
		     

           <hr>
 

        </div>

      </form>
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

