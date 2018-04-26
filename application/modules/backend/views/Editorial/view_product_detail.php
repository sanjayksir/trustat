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
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo DASH_B;?>">Home</a> </li>
                    
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
																			 <label><strong>Product Name:-</strong></label></div>
																			 <div class="col-xs-3 col-sm-3"><?php echo $details['product_name'];?></div>
																	
																		</div>
																		</div>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Industry:-</strong></label>
																	</div>
																	<div class="col-xs-3 col-sm-3"> 
																		<?php $industryList =  get_industry_by_id(implode(',',json_decode($details['industry_data'],true)));
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
																	 	<label><strong>Product SKU</strong></label>
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
																	 	<label><strong>Product Attributes</strong></label>
																	</div>
																	<div class="col-xs-3 col-sm-3">
																	<?php foreach($array_attribute as $parent=>$child_arr){
																	 
																			 echo '<br><u>'.getAttrNameFromID($parent).'</u>';
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
																			if(file_exists('./uploads/temp/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		<img style="border:1px solid grey;"  src="<?php echo base_url().'/uploads/temp/'.$recs;?>" width="100px" height="100px;" />
																		  <?php }
																			}
																		}?>
																	</div>
  																</div>
															</div>
															<?php }?>
															<br />
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
																			if(file_exists('./uploads/temp/'.$recs)){//echo '***'.$recs;exit;
																	?>
																	   <video width="320" height="240" controls>
																		  <source src="<?php echo base_url().'/uploads/temp/'.$recs;?>" type="video/mp4">
																		  
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
																			if(file_exists('./uploads/temp/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		 
																		 <audio width="320" height="240" controls>
  <source src="<?php echo base_url().'/uploads/temp/'.$recs;?>" type="audio/mpeg">
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
																			if(file_exists('./uploads/temp/'.$recs)){//echo '***'.$recs;exit;
																	?>
																		<a href="<?php echo base_url().'/uploads/temp/'.$recs;?>" target="_blank" /><?php echo $i;?> PDF</a>
																		  <?php }
																			$i++;}
																		}?>
																	</div>
  																</div>
															</div>
															<?php }?>
														</div>
                                                         <br />
                                                        <h3> Essential Attribute</h3>
                                                         <hr />
                                                         
                                                         <!-------------- Essential attributes-------------------->
                                                         <div class="row">
                                                            <div class="col-xs-12"> 
                                                                <div class="col-xs-3 col-sm-3"><label><strong>Code Type:-</strong></label></div>
                                                                <div class="col-xs-3 col-sm-3 form-control"><?php echo $details['code_type'];?></div>
                                                                
                                                                <div class="col-xs-3 col-sm-3"><label><strong>Code Activation Type:-</strong></label></div>
                                                                <div class="col-xs-3 col-sm-3 form-control"><?php echo $details['code_activation_type'];?></div>
                                                                
                                                                <div class="col-xs-3 col-sm-3"><label><strong>Delivery Method:-</strong></label></div>
                                                                <div class="col-xs-3 col-sm-3 form-control"><?php echo product_delivery_method($details['delivery_method']);?></div>
                                                            </div>
                                                         </div>
                                                            
                                                         <div class="row">
                                                            <div class="col-xs-12"> 
                                                                <div class="col-xs-3 col-sm-3"><label><strong>Code Key Type:-</strong></label></div>
                                                                <div class="col-xs-3 col-sm-3 form-control"><?php echo $details['code_key_type'];?></div>
                                                                
                                                                <div class="col-xs-3 col-sm-3 form-control"><label><strong>Code Size:-</strong></label></div>
                                                                <div class="col-xs-3 col-sm-3 form-control"><?php echo getProductSize($details['code_size']);?></div>
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
 
  
   