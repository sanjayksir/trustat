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
                    
                    <li class="active">Review Advertisement Details</li>
                </ul>
                 
            </div>
            <div class="page-content">
                 
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 class="header smaller lighter blue">Review Advertisement Details</h3>
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
                                                <h4 class="widget-title pull-right padding-right" style="padding-right:10px;"><a href="<?php echo base_url().'advertisement/launch_advertisement'; ?>">Back</a></h4>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                               
                                           
                                                    <div class="space"></div>
                                                    <div class="form-group">
														<div class="add-spidey">
														<!-- Product Survey Video -->
															<?php if($details['product_survey_video']!=''){?>
															<div class="row">
																<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement Video</strong></label>
																	</div>
																	<div class="col-xs-9 col-sm-9">
																	
										<video width="320" height="240" controls>
								<source src="<?php echo base_url().'uploads/'.$details['product_push_ad_video'];?>" type="video/mp4">
																		  
																		  Your browser does not support the video tag.
																		</video> &nbsp &nbsp The Consumer will get <b><?php echo $details['product_ad_response_lps']; ?></b> Loyalty Points on Product  Feedback.
																	<?php //echo base_url().'uploads/'.$details['product_demo_video'];?>
																	</div>
  																</div>
															</div>
															<?php }?>
															<!-- /Product Survey Video -->	
														</div>
                                                        
														 <hr />
                                                        <h3> List of Questions</h3>
                                                         <hr />
                                                         
                           <!-------------- Essential attributes-------------------->
            <div class="row">
              <div class="col-xs-12" style="margin-left:25px"> 
					<h4 class="widget-title pull-left padding-left" style="padding-right:10px;"><a href="<?php echo base_url().'product/ask_pushed_ad_feedback/' . $this->uri->segment(3); ?>">Click here to see the list for the questions</a></h4>
					
            
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
 
  
   