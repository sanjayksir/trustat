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
 		 				<?php $constant = "View Code Details" ; ?>	
          <li class="active">Administration</li><li class="active"><?php echo $constant;?></li>

        </ul>
       </div>
        <?php 
 
		?>
       <div class="page-content">
         <div class="row">
           <div class="col-xs-12">
             <div class="row">
               <div class="col-xs-12">
                 <h3 class="header smaller lighter blue"><?php echo $constant;?></h3><br>
                 <div class="row">
                   <div class="col-xs-12">
                     <!--left end---->
                     <div class="col-xs-12">
                       <div class="tab-pane fade active in">
                        
                         <div class="row">
                           <div class="col-xs-12">
                             <div class="row" id="add_edit_div">
                                <div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<h4 class="widget-title"><?php echo get_products_name_by_id($detailData['product_id']);?></h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				 
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Product Code </b></label> : <?php echo $detailData['barcode_qr_code_no'];?>
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Current Location</b></label> : <?php 
							$activeinactive = $detailData['active_status'];
                                            if ($activeinactive == 1)
                                                { 
											echo get_plants_name_by_id($detailData['plant_id']);
                                                   } else { 
                                                       echo "";
                                                }
																	 
			  
									//echo $detailData['plant_id'];
			  
			  
			  ?>
			</div>
            
		</div>
		
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Activation Status </b></label> : <?php if($detailData['active_status']==1) { echo "Active"; } else{ echo "In-Active"; } ?>
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Activation Level</b></label> : <?php echo $detailData['pack_level'];?>
			</div>
            
		</div>
		
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Current Child(ren)</b> </label> : <?php //echo $ChildernData['bar_code'];
			
			foreach ($ChildernData as $new_house_items)
						{
						  //example to point data.
						  echo $new_house_items['bar_code'] . ",<br>";//example code to understand.
						}
			
			?>
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Current Parent</b> </label> : <?php 
															if(!empty($detailData['parent_bar_code'])){ 
															echo "No Parent Assigned"; 
															}else{ 
															echo $ParentData['parent_bar_code']; 
															} 
															?>
			  
			 
			
			
			</div>
            
		</div>
		<h3 class="header smaller lighter blue">History</h3>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Order Number</b></label> : <?php echo $order_no;?>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Date of Order</b> </label> : <?php echo $created_date;?>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Print ID</b></label> : <?php echo $detailData['print_id'];?>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Print Date</b> </label> : <?php echo $detailData['modified_at'];?>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Activated By</b></label> : <?php echo getUserFullNameById($detailData['customer_id']);?>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Activation Date</b> </label> : <?php echo $detailData['activation_date'];?>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Packed By</b></label> : <?php echo getUserFullNameById($customer_user_id);?>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Packaging Date</b> </label> : <?php echo $create_date;?>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8"><b>Order Number</b></label> : <?php echo $order_no;?>
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8"><b>Print ID</b></label> : <?php echo $detailData['print_id'];?>
			</div>
		</div>
		 <hr />
           <div style="clear:both;height:40px;"><a href="<?php echo base_url()?>reports/barcode_printed_reports" class="btn btn-primary pull-right" title="Back to List Orders">Back to List Printed Bar/OR Codes</a></div>
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
             </div>
             <!-- PAGE CONTENT ENDS --> 
           </div>
         </div>
       </div>
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
 </div>
 <div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog"> <span id="edit_popup_model"> </span> 
     <div class="modal-content"></div>
   </div>
 </div>
 <div class="modal fade" id="addModal" role="dialog">
   <div class="modal-dialog"> <span id="add_modal_popup"> </span> 
     <div class="modal-content"></div>
   </div>
 </div>
 <?php $this->load->view('../includes/admin_footer');?>