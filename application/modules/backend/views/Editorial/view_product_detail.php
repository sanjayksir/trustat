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
                                <h3 class="header smaller lighter blue">View Product Details</h3>
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
																			 <label><strong>Company Name :</strong></label></div>
																			 <div class="col-xs-3 col-sm-3">
														<?php echo getUserFullNameById($details['created_by'])?></div>
																		</div>
																</div>
																<br />
															<div class="row">
																		<div class="col-xs-12"> 
																			<div class="col-xs-3 col-sm-3">
																			 <label><strong>Brand Name :</strong></label></div>
																			 <div class="col-xs-3 col-sm-3"><?php echo $details['brand_name'];?></div>
																		</div>
																</div>
																<br />
															<div class="row">
																		<div class="col-xs-12"> 
																			<div class="col-xs-3 col-sm-3">
																			 <label><strong>Product Name :</strong></label></div>
																			 <div class="col-xs-3 col-sm-3"><?php echo $details['product_name'];?></div>
																		</div>
																</div>
																<br />
															<div class="row">
																		<div class="col-xs-12"> 
																			<div class="col-xs-3 col-sm-3">
																			 <label><strong>Customer ERP Product ID :</strong></label></div>
																			 <div class="col-xs-3 col-sm-3"><?php echo $details['customer_erp_product_id'];?></div>
																		</div>
																</div>
																<br />	
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
															<br />
															
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
									echo "<br />";
																				}
																		}	
																		?>
																	</div>
  																</div>
															</div>
															
															
													<br />		
															
															
															
															
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
											<fieldset>
												<legend>Product Thumb Image</legend>
															<?php }?>
															<?php if($details['product_thumb_images']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Thumb Image</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrImg = explode(',',$details['product_thumb_images']);
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
														</fieldset>	
									<fieldset>
										<legend>For Level 1: Video/Audio/PDF/Image Management</legend>
										<?php if($details['product_image']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Image</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrImg = explode(',',$details['product_image']);
 																	if(count($arrImg)>0){
																		foreach($arrImg as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		<img style="border:1px solid grey;"  src="<?php echo base_url().'/uploads/'.$recs;?>" width="100px" height="100px;" />
																		  <?php }
																			}
																		}?>
																	 &nbsp &nbsp The Consumer will get <b><?php echo $details['product_image_response_lps']; ?></b> Loyalty Points on Product Image Feedback. </div> 
  																</div>
															</div>
															
															<br /><br />
															<?php }?>
									 
															
															
															
															<!-- Product Video -->
									<?php if($details['product_video']!=''){?>
										<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Video</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
																	   <video width="320" height="240" controls>
																		  <source src="<?php echo base_url().'uploads/'.$details['product_video'];?>" type="video/mp4">
																		  
																		  Your browser does not support the video tag.
																		</video> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_video_response_lps']; ?></b> Loyalty Points on Product Video Feedback.
																	
																		 
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
																	
																		 
																		 <audio width="320" height="240" controls>
  <source src="<?php echo base_url().'uploads/'.$details['product_audio'];?>" type="audio/mpeg">
Your browser does not support audio in video tag.
</audio> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_audio_response_lps']; ?></b> Loyalty Points on Product Audio Feedback.
																		  
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
																	 	<label><strong>Product Brochure</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
																	
					<a href="<?php echo base_url().'uploads/'.$details['product_pdf'];?>" target="_blank" /><?php //echo $i;?> <img src="<?php echo base_url();?>/assets/images/pdf-preview.png" alt="<?php echo $recs;?>" width = "200"><br /><?php //echo $recs;?>Please click here to Open the File</a> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_pdf_response_lps']; ?></b> Loyalty Points on Product PDF Feedback.
																		  
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															 </fieldset>
															<!-- /Product PDF -->
															<!-- Product Demo Items  -->
															<br />
															
							<fieldset>
							<legend>For Level 0: Demo Video/Demo Audio/User Manual Management</legend>
															<!-- Product Demo Video -->
															<?php if($details['product_demo_video']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Demo Video</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
										<video width="320" height="240" controls>
								<source src="<?php echo base_url().'uploads/'.$details['product_demo_video'];?>" type="video/mp4">
																		  
																		  Your browser does not support the video tag.
																		</video> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_demo_video_response_lps']; ?></b> Loyalty Points on Product Demo Video Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_video'];?>
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
																	 <audio width="320" height="240" controls>
  <source src="<?php echo base_url().'uploads/'.$details['product_demo_audio'];?>" type="audio/mpeg">
Your browser does not support audio in video tag.
</audio>&nbsp &nbsp The Consumer will get <b><?php echo $details['product_demo_audio_response_lps']; ?></b> Loyalty Points on Product Demo Audio Feedback.
																		  
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
																	
		<a href="<?php echo base_url().'uploads/'.$details['product_user_manual'];?>" target="_blank" /><?php //echo $i;?> <img src="<?php echo base_url();?>/assets/images/pdf-preview.png" alt="<?php echo $recs;?>" width = "200"><br /><?php //echo $recs;?></a>
																		  
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															</fieldset>
															<!-- /Product User Manual -->
							<fieldset>
								<legend>Image on Code Sticker Management</legend>
														<br />
															<?php if($details['product_code_print_bg_images']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Code BG Image</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrImg = explode(',',$details['product_code_print_bg_images']);
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
							</fieldset>
															<!-- /Product Demo Items  -->
														<!-- Product Advertisement video -->
										<fieldset>
											<legend>Push Advertisement Management</legend>	
															<?php if($details['product_push_ad_video']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement video</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
										<video width="320" height="240" controls>
								<source src="<?php echo base_url().'uploads/'.$details['product_push_ad_video'];?>" type="video/mp4">
																		  
																		  Your browser does not support the video tag.
																		</video> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_ad_video_response_lps']; ?></b> Loyalty Points on Product Advertisement Video Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_video'];?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product Advertisement Video -->
															
<br />
															<!-- Product Advertisement Audio -->
															<?php if($details['product_push_ad_audio']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement Audio</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
										<audio width="320" height="240" controls>
								<source src="<?php echo base_url().'uploads/'.$details['product_push_ad_audio'];?>" type="audio/mp4">
																		  
																		  Your browser does not support the audio tag.
																		</audio> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_ad_audio_response_lps']; ?></b> Loyalty Points on Product Advertisement Audio Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_audio'];?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product Advertisement Audio -->
															
															<!-- Product Advertisement PDF -->
															<?php if($details['product_push_ad_pdf']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement PDF</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
										
																	<a href="<?php echo base_url().'uploads/'.$details['product_push_ad_pdf'];?>" target="_blank" /><?php //echo $i;?> <img src="<?php echo base_url();?>/assets/images/pdf-preview.png" alt="<?php echo $recs;?>" width = "200"><br /><?php //echo $recs;?>Please click here to Open the File</a>	  
																		  Your browser does not support the pdf tag.
																		</pdf> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_ad_pdf_response_lps']; ?></b> Loyalty Points on Product Advertisement PDF Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_pdf'];?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product Advertisement PDF -->
															
															<!-- Product Advertisement Image -->
															<?php if($details['product_push_ad_image']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement image</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	<?php $arrImg = explode(',',$details['product_push_ad_image']);
 																	if(count($arrImg)>0){
																		foreach($arrImg as $recs){	
																			if(file_exists('./uploads/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		<img style="border:1px solid grey;"  src="<?php echo base_url().'/uploads/'.$recs;?>" width="100px" height="100px;" />
																		  <?php }
																			}
																		}?>
																	 &nbsp &nbsp The Consumer will get <b><?php echo $details['product_ad_image_response_lps']; ?></b> Loyalty Points on Product Advertisement Image Feedback. </div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product Advertisement image -->
														</fieldset>	
															
												<br />
															<!-- Product Survey Video -->
								<fieldset>
									<legend>Push Survey Management</legend>
															<?php if($details['product_survey_video']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Survey Video</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
										<video width="320" height="240" controls>
								<source src="<?php echo base_url().'uploads/'.$details['product_survey_video'];?>" type="video/mp4">
																		  
																		  Your browser does not support the video tag.
																		</video> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_survey_video_response_lps']; ?></b> Loyalty Points on Product Survey Video Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_video'];?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product Survey Video -->	

															<!-- Product Survey audio -->
															<?php if($details['product_survey_audio']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Survey Audio</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
										<audio width="320" height="240" controls>
								<source src="<?php echo base_url().'uploads/'.$details['product_survey_audio'];?>" type="audio/mp4">
																		  
																		  Your browser does not support the audio tag.
																		</audio> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_survey_audio_response_lps']; ?></b> Loyalty Points on Product Survey Audio Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_audio'];?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product Survey audio -->	
																
																<!-- Product Survey pdf -->
															<?php if($details['product_survey_pdf']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Survey PDF</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
													<a href="<?php echo base_url().'uploads/'.$details['product_survey_pdf'];?>" target="_blank" /><?php //echo $i;?> <img src="<?php echo base_url();?>/assets/images/pdf-preview.png" alt="<?php echo $recs;?>" width = "200"><br /><?php //echo $recs;?>Please click here to Open the File</a>	

																		&nbsp &nbsp The Consumer will get <b><?php echo $details['product_survey_pdf_response_lps']; ?></b> Loyalty Points on Product Survey PDF Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_pdf'];?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product Survey pdf -->	
															
															<!-- Product Survey image -->
															<?php if($details['product_survey_image']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Survey Image</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
										
						<img style="border:1px solid grey;"  src="<?php echo base_url().'uploads/'.$details['product_survey_image'];?>" width="100px" height="100px;" />
																		&nbsp &nbsp The Consumer will get <b><?php echo $details['product_survey_image_response_lps']; ?></b> Loyalty Points on Product Survey Image Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_image'];?>
																	</div>
  																</div>
															</div>
															<br /><br />
															<?php }?>
															<!-- /Product Survey Image -->	
																</fieldset>	

														
														</div>
                                                         <br />
														 <hr />
                                                   
                           <!-------------- Essential attributes-------------------->
		
		
		
  
		<fieldset>
			<legend>Bar Code Management</legend>
			<div class="form-group row">
			<div class="col-sm-4">
				<label for="form-field-8"><b>Barcode Type – Line Barcode or QR</b> : </label>
				<?php echo $details['code_type'];?>
  			</div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Code Activation Type – Pre or Post : </label> 
				<?php if($details['code_activation_type']==0){ echo "Post-Activated";}else{echo "Pre-Activated";} ?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b> Method of Delivery – Printing by Super/CCC Admin</b> : </label>
				<?php if($details['delivery_method']==1){ echo "Physical Printing by Super Admin";}elseif($details['delivery_method']==2){echo "Physical Printing by CCC Admin";}else{echo "Physical Printing by Designated Plant Controller";} ?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b> Code Key Type – Serial or Random</b> :  </label>
				<?php if($details['code_key_type']=='serial'){ echo "Serial Unique";}else{echo "Random Unique";} ?>				
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b> Code Unity Type – Single or Twin</b>  : </label>
				<?php echo $details['code_unity_type'];?>				
 		    </div>
			<div class="col-sm-4">
				<label for="form-field-8"><b>Show Code Below Printed Bar/QR Code</b> : </label>
				<?php echo $details['show_code_below_printed_bar_qr_code'];?>				
 		    </div>
			</div>
		</fieldset>
          
		
		  <fieldset>
			<legend>Packaging Level Management</legend>
          <div class="form-group row"> 			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Print codes in Batches?</b> : </label>
				<?php echo $details['print_codes_in_batches'];?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Registration Pack</b> : </label>
				<?php echo $details['registration_pack'];?>	
 		    </div>

		<div class="col-sm-4">
				<label for="form-field-8"><b>Retailer Pack</b> : </label>
				<?php echo $details['retailer_pack'];?>	
 		    </div>

		<div class="col-sm-4">
				<label for="form-field-8"><b>Min Shipper Pack Level </b> : </label>
				<?php echo $details['min_shipper_pack_level'];?>	
 		    </div>

			<div class="col-sm-4">
				<label for="form-field-8"><b>Max Shipper Pack Level</b>  : </label>
				<?php echo $details['max_packaging_level_product'];?>	
 		    </div> 
  		</div> 
		</fieldset>
		
		 <fieldset>
			<legend>Code Size and Message Printing Management</legend>
				<div class="form-group row"> 
			<div class="col-sm-4">
				<label for="form-field-8"><b>Text Font Size</b> : </label>
				<?php echo $details['TextFontSize'];?>
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Height of Barcode(mm) </b> : </label>
				<?php echo $details['height_of_the_bar_code'];?>
 		    </div> 
			<div class="col-sm-4">
				<label for="form-field-8"><b>Size of the Code (mm)</b> : </label>
				<?php echo $details['code_size'];?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Space for Message above the Code(mm)</b> : </label>
				<?php echo $details['space_for_message_above_code'];?>
 		    </div>
			
           <div class="col-sm-4">
				<label for="form-field-8"><b>Message print above the Code</b> : </label>
				<?php echo $details['message_above_code'];?>
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Space for Message below the Code(mm)</b> : </label>
				<?php echo $details['space_for_message_below_code'];?>
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Message print below the Code</b> : </label>
				<?php echo $details['message_below_code'];?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Space for Code below BatchID(mm)</b> : </label>
				<?php echo $details['space_for_code_below_batchid'];?>
 		    </div>
			
  		</div>
		</fieldset>
		
		<div <?php if($details['code_unity_type']=='Single'){ ?> style="display:none;" <?php } ?>>
		<fieldset>
			<legend>Twin Codes Management</legend>
		<div class="form-group row">  
			<div class="col-sm-4">
				<label for="form-field-8"><b>Space between Code Rows</b> : </label>
				<?php echo $details['space_between_code_rows'];?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Message above Secondary Code of twin</b> : </label>
				<?php echo $details['message_above_secondry_code'];?>
 		    </div> 
			<div class="col-sm-4">
				<label for="form-field-8"><b>Message Below Secondary Code of twin</b> : </label>
				<?php echo $details['message_below_secondry_code'];?>
 		    </div>
			<div class="col-sm-4">
				<label for="form-field-8"><b>Space for Message above Sec. Code of twin(mm)</b> : </label>
				<?php echo $details['space_for_message_above_secondry_code'];?>
 		    </div>
			<div class="col-sm-4">
				<label for="form-field-8"><b>Space for Message Below Sec.  Code of twin(mm)</b> : </label>
				<?php echo $details['space_for_message_below_secondry_code'];?>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Space between QR Code and Barcode(mm) </b> : </label>
			<?php echo $details['space_between_twin_code'];?>
 		    </div>
			 
  		</div>		
		</fieldset>
		</div>	
		
		<fieldset>
			<legend>Super Loyalty Management</legend>
		<div class="form-group row"> 

			<div class="col-sm-4">
				<label for="form-field-8"><b>Include the Product in Super Loyalty </b> : </label>
				<?php echo $details['include_the_product_in_super_loyalty'];?>				
 		    </div> 
			<div <?php if($details['include_the_product_in_super_loyalty']=='No'){ ?> style="display:none;" <?php } ?>>
			<div class="col-sm-4">
				<label for="form-field-8"><b>Super Loyalty trigger every... times Scan </b> : </label>
				<?php echo $details['number_of_scans_for_super_loyalty'];?>				
 		    </div> 			
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>APP Passbook On Screen Display Message </b> : </label>
				<?php echo $details['app_passbook_on_screen_display_message_sl'];?>			
 		    </div>
			
			<div class="col-sm-8">
				<label for="form-field-8"><b> APP Notification Message for Super Loyalty  </b> : </label>
				<?php echo $details['app_notification_message_for_super_loyalty'];?>			
 		    </div> 
			
			
			</div>
  		</div>
		</fieldset>
		
		<fieldset>
			<legend>Referral Program Management</legend>
		<div class="form-group row">            
			<div class="col-sm-4">
				<label for="form-field-8"><b>Include the Product in Referral Program </b> : </label>
				<?php echo $details['include_the_product_in_referral_program'];?>				
 		    </div> 
			<div <?php if($details['include_the_product_in_referral_program']=='No'){ ?> style="display:none;" <?php } ?>>
			<div class="col-sm-4">
				<label for="form-field-8"><b> Gap Period(Days) for last activity of Receiver </b> : </label>
				<?php echo $details['gap_period_for_last_activity_of_existing_consumer'];?>			
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b> Loyalty rewards to sender consumer under Referral </b> : </label>
				<?php echo $details['loyalty_rewards_to_sender_consumer_under_referral'];?>			
 		    </div>
			</div>
  		</div>
		<div <?php if($details['include_the_product_in_referral_program']=='No'){ ?> style="display:none;" <?php } ?>>
		<div class="form-group row">            
			<div class="col-sm-4">
				<label for="form-field-8"><b> Media Type for Sending Reference</b> : </label>
				<?php echo $details['media_type_for_sending_reference'];?>			
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Max Referrals for the product</b> : </label>
				<?php echo count_referrals_product($details['id']); ?>/<?php echo $details['max_referrals_for_product'];?>				
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Number of Referrals allowed by a Consumer</b> : </label>
				<?php echo $details['number_of_referrals_allowed_to_consumer'];?>				
 		    </div> 
			
  		</div>
		
		<div class="form-group row">            
			<div class="col-sm-4">
				<label for="form-field-8"><b>Referral Program Auto Off Date(mm/dd/yyyy)</b> : </label>
				<?php echo date('m/d/yy',strtotime($details['referral_program_auto_off_date']));?>				
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Msg. Displayed To Sender upon Sending Ref. </b> :  </label>
				<?php echo $details['custom_message_for_sending_reference'];?>			
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8"><b>Message for receiver of Reference </b> : </label>
				<?php echo $details['message_for_receiver_of_reference'];?>			
 		    </div> 
  		</div>
		
		<div class="form-group row">            
			<div class="col-sm-4">
				<label for="form-field-8"><b>Send Referral message from server</b> : </label>
				<?php echo $details['send_ref_message_frm_server'];?>				
 		    </div> 
			
			<div class="col-sm-8">
				<label for="form-field-8"><b>Message for receiver of Reference from Server</b> : </label>
				<?php echo $details['message_receiver_ref_frm_server'];?>				
 		    </div> 
			
			
			
  		</div>
		
		</div>
		</fieldset>
           <br />

<fieldset>
			<legend>Product Warranty Management</legend>
		
		<div class="form-group row">            
			<div class="col-sm-8">
				<label for="form-field-8"><b> Product Warranty in Days(0 Stands Without Warranty)</b> : </label>
				<?php echo $details['warranty_in_days'];?>				
 		    </div> 
			
			<!--
			<div class="col-sm-4">
				<label for="form-field-8">Max Referrals for the product</label><br />
				<b><?php echo $details['max_referrals_for_product'];?></b>				
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Number of Referrals allowed by a Consumer</label><br />
				<b><?php echo $details['number_of_referrals_allowed_to_consumer'];?></b>				
 		    </div> -->			
  		</div>
		</fieldset>		   
                                                         
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
 
  
   