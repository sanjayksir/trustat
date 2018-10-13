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
 		 				<?php $constant = "View Order Detail" ; ?>	
          <li class="active">Administration</li><li class="active"><?php echo $constant;?></li>

        </ul>
       </div>
        <?php $get_detail = json_decode($detailData,true);
		$attribute_ids = json_decode($get_detail['attribute_list'],true);
		//echo '<pre>';print_r($attribute_ids);
		 $array_attribute = array();
		 $parent_attribute = array();
		 foreach($attribute_ids as $val){//echo '**'.$val;
			$attr = findParentIdFromChild($val);
			$parent_attribute[] =$attr;  
			//echo  '=<pre>==';print_r($parent_attribute); //print_r($parent_attribute); ;
			if(!in_array($attr, array_unique($parent_attribute))){
				$array_attribute[$attr]=$val;
			}else{
				
				$array_attribute[$attr]=$array_attribute[$attr].','.$val;
				 
			}
			
		 }
 
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
						<h4 class="widget-title">View Detail</h4>
						<div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				 
        <div class="widget-main">
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Product Name</label>
			<div class="form-control"><?php echo $get_detail['product_name'];?></div>
			 
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Product Code</label>
             <div class="form-control"><?php echo $get_detail['product_sku'];?></div>
			</div>
            <div class="col-sm-4">
			  <label for="form-field-8">Product Description</label>
             <div class="form-control"><?php echo $get_detail['product_description'];?></div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">Tracking No.</label>
             <div class="form-control"><?php echo $get_detail['order_tracking_number'];?></div>
			</div>
			 
			
			<div class="col-sm-4">
			  <label for="form-field-8">BR/QR Code</label>
             <div class="form-control"><?php echo $get_detail['barcode_qr_code_no'];?></div>
			</div>
            
            <div class="col-sm-4">
			  <label for="form-field-8">Quantity</label>
             <div class="form-control"><?php echo $get_detail['quantity'];?></div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">Delivery Date</label>
             <div class="form-control"><?php echo $get_detail['delivery_date'];?></div>
			</div>
  			<div class="col-sm-4">
			  <label for="form-field-8">User Name</label>
             <div class="form-control"><?php echo getUserNameById($get_detail['user_id']);?></div>
			</div>
 		</div>
		 
		<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Industry:-</strong></label>
																	</div>
																	<div class="col-xs-3 col-sm-3"> 
																		<?php $industryList =  get_industry_by_id(implode(',',json_decode($get_detail['industry_data'],true)));
																		$indus='';
																		$i=0;
																		foreach($industryList as $rec){
																			if($i>0){
 																				$indus.='<br>&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>';
																			}
																			$indus.=$rec['categoryName'];
																			$i++;
																		}
																		echo $indus;
																		?>
																		<hr />
																	</div>
  																</div>
															</div> 
		
		<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Attributes</strong></label>
																	</div>
																	<div class="col-xs-3 col-sm-3">
																	<?php foreach($array_attribute as $parent=>$child_arr){
																	 
																			 echo getAttrNameFromID($parent);
																				$res = explode(',',$child_arr);
																				$i=0;
																				foreach(array_filter($res) as $rec){$i++;
																				if($i>0){
																				echo '<br>&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>';
																				}
																					echo getAttrNameFromID($rec);
																				}
																		}	
																		?>
																	</div>
  																</div>
															</div> 
															<br />
        
															<?php if($details['product_thumb_images']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Images</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrImg = explode(',',$get_detail['product_thumb_images']);
 																	if(count($arrImg)>0){
																		foreach($arrImg as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		<img style="border:1px solid grey;"  src="<?php echo base_url().'/uploads/'.$recs;?>" width="100px" height="100px;" />
																		  <?php }
																			}
																		}?>
																	</div>
  																</div>
															</div>
															<?php }?>
															<br />
															<?php if($details['product_images']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Images</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrImg = explode(',',$get_detail['product_images']);
 																	if(count($arrImg)>0){
																		foreach($arrImg as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		<img style="border:1px solid grey;"  src="<?php echo base_url().'/uploads/'.$recs;?>" width="100px" height="100px;" />
																		  <?php }
																			}
																		}?>
																	</div>
  																</div>
															</div>
															<?php }?>
															<br />
															
															<?php if($get_detail['product_video']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Video</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrVid= explode(',',$get_detail['product_video']);
 																	if(count($arrVid)>0){
																		foreach($arrVid as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
																	   <video width="320" height="240" controls>
																		  <source src="<?php echo base_url().'/uploads/'.$recs;?>" type="video/mp4">
																		  
																		  Your browser does not support the video tag.
																		</video> 
																	
																		 
																		  <?php }
																			}
																		}?>
																	</div>
  																</div>
															</div>
															<?php }?>
															
															<br />
															<?php if($get_detail['product_audio']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Audio</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arAud = explode(',',$get_detail['product_audio']);
																	
																	//echo '***'.count($arAud);
 																	if(count($arAud)>0){
																		foreach($arAud as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		 
																		 <audio width="320" height="240" controls>
  <source src="<?php echo base_url().'/uploads/'.$recs;?>" type="audio/mpeg">
Your browser does not support audio in video tag.
</audio>
																		  <?php }
																			}
																		}?>
																	</div>
  																</div>
															</div>
															<?php }?>
															<br />
															<?php if($get_detail['product_pdf']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product User Manual</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrPDF = array_filter(explode(',',$get_detail['product_pdf']));
 																	if(count($arrPDF)>0){
																	$i=1;
																		foreach($arrPDF as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		<a href="<?php echo base_url().'/uploads/'.$recs;?>" target="_blank" /><?php echo $i;?> PDF</a>
																		  <?php }
																			$i++;}
																		}?>
																	</div>
  																</div>
															</div>
															<?php }?>    

           <hr>
           
           
           <h3> Essential Attribute</h3>
                                                         <hr />
                                                         
                                                         <!-------------- Essential attributes-------------------->
                                                         <div class="form-group row">
                                                            
                                                                <div class="col-sm-4"><label for="form-field-8"><strong>Code Type:-</strong></label> 
                                                                	<div class="form-control"><?php echo $get_detail['code_type'];?></div>
                                                                </div>
                                                                
                                                                <div class="col-sm-4"><label for="form-field-8"><strong>Code Activation Type:-</strong></label> 
                                                                	<div class="form-control"><?php echo $get_detail['code_activation_type'];?></div>
                                                                </div>
                                                                 <div class="col-sm-4"><label for="form-field-8"><strong>Delivery Method:-</strong></label> 
                                                                	<div class="form-control"><?php if($get_detail['delivery_method']==1){
																	echo 'Physically Printing By Super Admin';}
																	if($get_detail['delivery_method']==2){
																	echo 'Physically Printing By CCC Admin';}
																	if($get_detail['delivery_method']==3){
																	echo 'Physically Printing By PLant Controller';}
																	if($get_detail['delivery_method']==4){
																	echo 'Deliver By E-Mode';}?></div>
                                                                </div>
                                                              
                                                         </div>
                                                         
                                                         <div class="form-group row">
                                                            
                                                                <div class="col-sm-4"><label for="form-field-8"><strong>Code Key Type:-</strong></label> 
                                                                	<div class="form-control"><?php echo $get_detail['code_key_type'];?></div>
                                                                </div>
                                                                
                                                                <div class="col-sm-4"><label for="form-field-8"><strong>Code Size:-</strong></label> 
                                                                	<div class="form-control"><?php echo getProductSize($get_detail['code_size']);?></div>
                                                                </div>
                                                                  
                                                         </div>
                                                            
                                                         
                                                       <!-------------- Essential attributes-------------------->
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