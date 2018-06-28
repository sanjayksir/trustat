<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); ?>
<div class="main-container ace-save-state" id="main-container">
 <?php $this->load->view('../includes/admin_sidebar');  
 $details = json_decode($detailData, true);
// echo '***<pre>';print_r($details);
 $attribute_ids = json_decode($details['attribute_list'],true);
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
 
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
                    
                    <li class="active">Product Details</li>
                </ul>
                 
            </div>
            <div class="page-content">
                 
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 class="header smaller lighter blue">Product Details</h3>
                                <?php if ($feedback = $this->session->flashdata('feedback')) { ?>
                                    <div class="alert alert-dismissible <?php echo $this->session->flashdata('feedback_class') ?>">
                                        <strong><?php echo $feedback; ?></strong>
                                    </div>
                                <?php } ?>
                                
                                <div style="display:none;" class="alert alert-block alert-success" id="ajax_msg"></div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="widget-box">
                                            <div class="widget-header">
                                                <h4 class="widget-title pull-right padding-right" style="padding-right:10px;"><a href="<?php echo base_url().'product/list_product'; ?>">Back</a></h4>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                               
                                           
                                                    <div class="space"></div>
                                                    <div class="form-group">
														<div class="add-spidey">
															<div class="row">
																		<div class="col-xs-12"> 
																			<div class="col-xs-3 col-sm-3">
																			 <label><strong>Brand Name :</strong></label></div>
																			 <div class="col-xs-3 col-sm-3"><?php echo $details['brand_name'];?></div>
																		</div>
																</div>
																<br /><br />
															<div class="row">
																		<div class="col-xs-12"> 
																			<div class="col-xs-3 col-sm-3">
																			 <label><strong>Product Name :</strong></label></div>
																			 <div class="col-xs-3 col-sm-3"><?php echo $details['product_name'];?></div>
																		</div>
																</div>
																<br /><br />
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Industry :</strong></label>
																	</div>
									<div class="col-xs-3 col-sm-3"> 
									<?php $industryList =  get_industry_by_id(implode(',',json_decode($details['industry_data'],true)));
												$indus='';
												$i=0;
										foreach($industryList as $rec){
											
										if($i>0){
											//$spaced = 
											$space == 1;
											$space++;
 											$indus.=' <br /><i class="fa fa-long-arrow-right" aria-hidden="true" style="margin-left:'.$space.'em"> </i> ';
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
															<br /><br />
															
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product SKU :</strong></label>
																	</div>
																	<div class="col-xs-3 col-sm-3">
																	<?php echo $details['product_sku'];
																		?>
																	</div>
  																</div>
															</div>
															<br />
															
							<div class="row">
								<div class="col-xs-12"> 
									<div class="col-xs-3 col-sm-3">
								 	<label><strong><br />Product Attributes :</strong></label>
									</div>
								<div class="col-xs-3 col-sm-3">
								<?php foreach($array_attribute as $parent=>$child_arr){
																	 
									echo '<br /><u>'.getAttrNameFromID($parent).'</u>';
									$res = explode(',',$child_arr);
									$i=0;
									foreach(array_filter($res) as $rec){$i++;
										if($i>0){
			echo '&nbsp;&nbsp;<i class="fa fa-long-arrow-right" aria-hidden="true"> </i> ';
										        }
									echo getAttrNameFromID($rec);
																				}
																		}	
																		?>
																	</div>
  																</div>
															</div>
															
															
													<br /><br />		
															
															
															
															
						<?php if($details['product_description']!=''){?>
								<div class="row">
									<div class="col-xs-12"> 
										<div class="col-xs-3 col-sm-3">
											<label><strong>Product Description</strong></label>
																	</div>
																	<div class="col-xs-3 col-sm-3">
																	<?php echo $details['product_description'];
																		?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<?php if($details['product_images']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Images</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrImg = explode(',',$details['product_images']);
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
															<br /><br />
															<?php }?>
															<br />
															<!-- Product Video -->
															<?php if($details['product_video']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Video</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrVid= explode(',',$details['product_video']);
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
															<br /><br />
															<?php }?>
															<!-- /Product Video -->
															<br />
															<!-- Product Audio -->
															<?php if($details['product_audio']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Audio</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arAud = explode(',',$details['product_audio']);
																	
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
															<br /><br />
															<?php }?>
															<!-- /Product Audio -->
															<br />
															<!-- Product PDF -->
															<?php if($details['product_pdf']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product PDF</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrPDF = array_filter(explode(',',$details['product_pdf']));
 																	if(count($arrPDF)>0){
																	$i=1;
																		foreach($arrPDF as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
																	
					<a href="<?php echo base_url().'/uploads/'.$recs;?>" target="_blank" /><?php //echo $i;?> <img src="<?php echo base_url();?>/assets/images/pdf-preview.png" alt="<?php echo $recs;?>" width = "200"><br /><?php //echo $recs;?>Please click here to Open the File</a>
																		  <?php }
																			$i++;}
																		}?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product PDF -->
															<!-- Product Demo Items  -->
															<br />
															<!-- Product Demo Video -->
															<?php if($details['product_demo_video']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Demo Video</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrVid= explode(',',$details['product_demo_video']);
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
															<br /><br />
															<?php }?>
															<!-- /Product Demo Video -->
															<br />
															<!-- Product Demo Audio -->
															<?php if($details['product_demo_audio']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Demo Audio</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arAud = explode(',',$details['product_demo_audio']);
																	
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
															<br /><br />
															<?php }?>
															<!-- /Product Audio -->
															<br />
															<!-- Product User Manual -->
															<?php if($details['product_user_manual']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product User Manual</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrPDF = array_filter(explode(',',$details['product_user_manual']));
 																	if(count($arrPDF)>0){
																	$i=1;
																		foreach($arrPDF as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
		<a href="<?php echo base_url().'/uploads/'.$recs;?>" target="_blank" /><?php //echo $i;?> <img src="<?php echo base_url();?>/assets/images/pdf-preview.png" alt="<?php echo $recs;?>" width = "200"><br /><?php //echo $recs;?>Please click here to Open the file</a>
																		  <?php }
																			$i++;}
																		}?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product User Manual -->
															
															<!-- /Product Demo Items  -->
															
														</div>
                                                         <br />
														 <hr />
                                                        <h3> Essential Attributes</h3>
                                                         <hr />
                                                         
                           <!-------------- Essential attributes-------------------->
            <div class="row">
              <div class="col-xs-12" style="margin-left:25px"> 
                
					<label><strong>Code Type : </strong> <?php echo $details['code_type'];?></label><br />
					<label><strong>Code Activation Type : </strong> <?php if($details['code_activation_type']==1) { echo "Pre-Activated";} else echo "Post-Activated"; ?>
										   </label><br />
					<label><strong>Delivery Method : </strong> <?php echo product_delivery_method($details['delivery_method']);?></label><br />
					<label><strong>Code Key Type : </strong><?php echo $details['code_key_type'];?></label><br />
					<label><strong>Code Size : </strong><?php echo getProductSize($details['code_size']);?></label>
					
				<br /><br /><br /><br />
            
                                                            </div>
                                                         </div>
                                                            
                                                         
                                                       <!-------------- ASsential attributes-------------------->
                                                    
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- PAGE CONTENT ENDS -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.page-content -->
                </div>
            </div>
           
            <!-- /.main-content -->

            <?php $this->load->view('../includes/admin_footer'); ?>
             <script>
<!------------------------ Validate Fom Add Idea----------------------------->
 
  
   