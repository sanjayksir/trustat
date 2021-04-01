<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>

	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Advertisement';?>

			<?php $this->load->view('../includes/admin_sidebar');?>
			
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo DASH_B;?>">Home</a>
							</li>

							<li>
							 Manage <?php echo $label;?>
							</li>
  						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							
						</div><!-- /.nav-search -->
					</div>
 					<div class="page-content">
						<div class="alert alert-block alert-success" style='display:none;'>
                                                    <button type="button" class="close" data-dismiss="alert">
                                                            <i class="ace-icon fa fa-times"></i>
                                                    </button>
                                                    <i class="ace-icon fa fa-check green"></i>Successfully!!
						 </div>
                      
                      
   						<div class="row">
							<div class="col-xs-12">
 								<div class="widget-box widget-color-blue">
                                                                    <div class="widget-header widget-header-flat">
                                                                        <h5 class="widget-title bigger lighter"><?php echo $label;?> Closure Report<?php //echo $this->uri->segment(3);?>
																		<div class="widget-toolbar">
                                                    <?php //echo anchor('reports/barcode/basic_customer_report_level0_download', 'Go to download report',array('class' => 'btn btn-xs btn-warning')); ?>
					<a href="<?php echo base_url();?>advertisement/view_advertisement_response_by_question_answer_download/<?php echo $this->uri->segment(3);?>" class="btn btn-xs btn-warning"> Go to download report </a>								
																	</div>	
																		</h5>
                                                                    </div>
									<div class="widget-body">
                                                                            <div class="row filter-box">
                                                                                <form id="form-filter" action="" method="get" class="form-horizontal" >
                                                                                    <div class="col-sm-5">
                                                                                        <label>Display
                                                                                            <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
                                                                                            <?php echo Utils::selectOptions('pagelimit',['options'=>$this->config->item('pageOption'),'value'=>$this->config->item('pageLimit')]) ?>
                                                                                            </select>
                                                                                        Records
                                                                                        </label>
                                                                                    </div>
								<?php $Datetoday = date("m/d/Y"); ?>
								<?php $dateoneMAgo = date("m/d/Y",strtotime("-1 month")); ?>	
																					<div class="col-sm-2">  Start Date(mm/dd/yyyy) : <br /><br />End Date(mm/dd/yyyy) :<br /><br />  </div>
                                                                                    <div class="col-sm-5">
                                                                                        <div class="input-group">
						<div class="input-group date" data-provide="datepicker">
                              <input type="text" name="from_date_data" id="from_date_data" readonly="readonly" value="<?php //echo $dateoneMAgo; ?>" class="form-control" />
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                        </div>
								  
						<div class="input-group date" data-provide="datepicker">
                               <input type="text" name="to_date_data" id="to_date_data" readonly="readonly" value="<?php //echo $Datetoday; ?>" class="form-control" />
							      <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                        </div>
								  <input type="hidden" name="c_date_data" id="c_date_data" value="<?php echo date('m/d/Y'); ?>" class="form-control" />	
                                                                                            <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Consumer Name, Product Name, Media Type or 	Advertisement Feedback Response">
                                                                                            <span class="input-group-btn">
                                 <button type="submit" class="btn btn-inverse btn-white" onclick="DateCheck();"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                                                                <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
										<script type="text/javascript">											
								function DateCheck()
											{
											  var StartDate= document.getElementById('from_date_data').value;
											  var EndDate= document.getElementById('to_date_data').value;
											  var CurrentDate= document.getElementById('c_date_data').value;
											  var eDate = new Date(EndDate);
											  var sDate = new Date(StartDate);
											  var cDate = new Date(CurrentDate);
											  if(sDate> eDate || eDate> cDate)
												{
												alert("Please ensure that the End Date is greater than or equal to the Start Date. End Date is not greater than Current Date");
												return false;
												}
											}
											</script>
	<div class="widget-main">																		
		<div class="form-group row">			
			<div class="col-sm-12">
			<label for="form-field-8"><b>Promotion report date</b></label> : <?php echo date('Y-m-d h:i:s');?>	 <br />
			<label for="form-field-8"><b>Name of Company</b></label> : <?php echo getUserFullNameById(get_customer_id_by_product_id($product_id));?> <br />
			<label for="form-field-8"><b>Product Name</b></label> : <?php echo get_products_name_by_id($product_id);?> <br />
			<label for="form-field-8"><b>Product ID</b></label> : <?php echo get_product_sku_by_id($product_id);?> <br />
			<label for="form-field-8"><b>Promotion Category</b></label> : <?php echo $promotion_type;?> <br />
			<label for="form-field-8"><b>Media of Promotion</b></label> : <?php echo $promotion_media_type;?>	 <br />
			<label for="form-field-8"><b>Name of Promotion</b></label> : <?php echo $promotion_title;?>	 <br />
			<label for="form-field-8"><b>Promotion Number</b></label> : <?php echo $promotion_request_id;?> <br />
			<label for="form-field-8"><b>Promotion Launch Date Time</b></label> : <?php echo $promotion_launch_date_time;?> <br />
			<label for="form-field-8"><b>Promotion Closure Date Time</b></label> : <?php if($promotion_closure_date_time == ""){ echo "Promotion not Closed yet."; }else{ echo $promotion_closure_date_time; } ?>	 <br />
			<label for="form-field-8"><b>Unique System Selection CriteriaID</b></label> : <?php if($unique_system_selection_criteria_id=="all"){ echo "No Selection Criteria was chosen, the Advertisement was sent to all the Consumers."; } else { echo $unique_system_selection_criteria_id; } ?>	 <br />
			<label for="form-field-8"><b>Total Number of Consumers of Company</b></label> : <?php echo NumberOfAllConsumersOfACustomer(get_customer_id_by_product_id($product_id)) . " Consumers";?><br />
			<label for="form-field-8"><b>Number of consumers selected</b></label> : <?php echo $number_of_consumers . " Consumers";?><br />
			<label for="form-field-8"><b>Number of responses from consumers till Date</b></label> : <?php echo $Number_of_responses_from_consumers;?> 
			<a href="<?php echo base_url();?>advertisement/view_advertisement_response_by_question_answer_download/<?php echo $this->uri->segment(3);?>"> Go to download report </a><?php //echo anchor('product/in_store_redemption_mis_download', 'Go to download report',array('class' => 'btn btn-primary pull-center')); ?>
			<!--<label><a href="#" onclick="$('#List_Consumer').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:10px"> Click here to Download</a></label>--><!--<a href=""> Click here to Download </a>--><br />
			
										<?php if($promotion_media_type=='Video'){?>
									<?php if($product_push_ad_video!=''){?>
										<div class="row">	
											<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement Video : </strong</label>
																	</div>
																	<div class="col-xs-9 col-sm-9">																	
																	   <video width="200" height="150" controls>
																		  <source src="<?php echo base_url().'uploads/'.$product_push_ad_video;?>" type="video/mp4">
																		  Your browser does not support the video tag.
																		</video> 
																	</div>
  																</div>
															</div>
									<?php } } ?>
									
									<?php if($promotion_media_type=='Audio'){?>
									<?php if($product_push_ad_audio!=''){?>
										<div class="row">	
											<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement Audio : </strong</label>
																	</div>
																	<div class="col-xs-9 col-sm-9">																	
																	   <audio width="200" height="150" controls>
																		  <source src="<?php echo base_url().'uploads/'.$product_push_ad_audio;?>" type="audio/mp4">
																		  Your browser does not support the audio tag.
																		</audio> 
																	</div>
  																</div>
															</div>
									<?php } } ?>
									
									<?php if($promotion_media_type=='PDF'){?>
									<?php if($product_push_ad_pdf!=''){?>
										<div class="row">	
											<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement PDF : </strong</label>
																	</div>
																	<div class="col-xs-9 col-sm-9">	
																		<a href="<?php echo base_url().'uploads/'.$product_push_ad_pdf;?>" target="_blank" /><?php //echo $i;?> <img src="<?php echo base_url();?>/assets/images/pdf-preview.png" alt="<?php echo $recs;?>" width = "200"><br /><?php //echo $recs;?>Please click here to Open the File</a>
																	</div>
  																</div>
															</div>
									<?php } } ?>
									
									<?php if($promotion_media_type=='Image'){?>
									<?php if($product_push_ad_image!=''){?>
										<div class="row">	
											<div class="col-xs-12"> 
																	<div class="col-xs-3 col-sm-3">
																	 	<label><strong>Product Advertisement Image : </strong</label>
																	</div>
																	<div class="col-xs-9 col-sm-9">	
																		<img style="border:1px solid grey;"  src="<?php echo base_url().'/uploads/'.$product_push_ad_image;?>" width="100px" height="100px;" />
																	</div>
  																</div>
															</div>
									<?php } } ?>
										
										
			
			</div>			
		</div>
		
	</div>	

							<!--<label for="form-field-8">Questions</label> : Basic Tea to be replaced by<br />
							<label for="form-field-8">Response a–– Icecream Number of consumers </label> : 
							<label for="form-field-8">Number of consumers who have Responded a</label><br />							
							<label for="form-field-8">Response b–– Icecream Number of consumers </label> : 
							<label for="form-field-8">Number of consumers who have Responded b</label><br />							
							<label for="form-field-8">Response c–– Icecream Number of consumers </label> : 
							<label for="form-field-8">Number of consumers who have Responded c</label><br />							
							<label for="form-field-8">Response d–– Icecream Number of consumers </label> : 
							<label for="form-field-8">Number of consumers who have Responded d</label><br />  -->
							
				
		</div>								
										
 											<div style="overflow-x:auto;">
			<table id="List_Consumer"  class="table table-striped table-bordered table-hover">
			
 												<thead>
													<tr>
														<th>#</th>
														<th>Promotion Number </th>
														<th><div style="word-wrap:break-word; width:200px;">Name of Promotion</div></th>
														<th><div style="word-wrap:break-word; width:200px;">Response Date time</div></th>
														<th>Consumer Name</th>
														<!--<th>Product Name</th>
 														<th>Media Type</th> 
														<th>Push Date Time</th> -->
														<!--<th>Advertisement Feedback Question, Response, Date Time</th>
														<th>Q1.</th> <th>Q1.</th> <th>Q1.</th> -->
                                                       
													   <?php 
											$survey_promotion_media_type = $promotion_type . " " . $promotion_media_type;
													   $promotion_id = $this->uri->segment(3);
														foreach ($ScanedCodeListing as $key=>$listData){
								$qproduct_data 	= getquestionFeedbackDetailsBygetquestionID($listData['product_id'], $listData['consumer_id'], $promotion_id); 
											$i = 1;
											foreach($qproduct_data as $res){ 
											
														?>
														<th><div style="word-wrap:break-word; width:400px;">
														<?php 
											echo  "Q. " . $i . " - " . get_question_desc_by_id($res['question_id']);	
												$options = get_question_desc_by_id_options($res['question_id']);
												echo "</br> 1. " . $options->row()->answer1 . "</br>";
												echo "2. " . $options->row()->answer2 . "</br>";
												echo "3. " . $options->row()->answer3 . "</br>";
												echo "4. " . $options->row()->answer4 . "</br>";
												$correct_answer = "answer" . $options->row()->correct_answer;
												
												echo "Correct Answer - " . $options->row()->$correct_answer;
														?>
													</div></th>
													<?php
													$i++;
													//if($i==1) break;
														}
													break;														
														}
										 ?>
											<th>Consumer Phone</th>
											<th>Consumer Email</th>
											<th>Consumer Photo</th>
											<?php
											$user_id = $this->session->userdata('admin_user_id');
											if($user_id=="1"){												
											?>
											<th>Date of Registration</th>
											<th>Consumer Aadhaar Number</th>
											<th>Consumer Gender</th>
											<th>Consumer DOB</th>
											<th>Consumer Registration Address</th>
											<th>Consumer Alternate Mobile Number</th>
											<th>Consumer Street Address</th>
											<th>Consumer City</th>
											<th>Consumer State</th>
											<th>Consumer PinCode</th>
											<th>Consumer Monthly Earnings</th>
											<th>Consumer Job Profile</th>
											<th>Consumer Education Qualification</th>
											<th>Consumer Type Vehicle</th>
											<th>Consumer Profession</th>
											<th>Consumer Marital Status</th>
											<th>Number of Family Members</th>
											<th>Consumer Loan Car</th>
											<th>Consumer Loan Housing</th>
											<th>Consumer Personal Loan</th>
											<th>Consumer Credit Card Loan</th>
											<th>Consumer Owna Car</th>
											<th>Consumer House Type</th>
											<th>Consumer Last Location</th>
											<th>Consumer Life Insurance</th>
											<th>Consumer Medical Insurance</th>
											<th>Consumer Height in inches</th>
											<th>Consumer Weight in Kg</th>
											<th>Consumer Hobbies</th>
											<th>Consumer Sports</th>
											<th>Consumer Entertainment</th>
											<th>Spouse Gender</th>
											<th>Spouse Phone</th>
											<th>Spouse dob</th>
											<th>Marriage Anniversary</th>
											<th>Spouse Work Status</th>
											<th>Spouse Education Qualification</th>
											<th>Spouse Monthly Income</th>
											<th>Spouse Loan</th>
											<th>Spouse Personal Loan</th>
											<th>Spouse Credit Card Loan</th>
											<th>Spouse OwnaCar</th>
											<th>Spouse House Type</th>
											<th>Spouse Height Inches</th>
											<th>Spouse Weight Kg</th>
											<th>Spouse Hobbies</th>
											<th>Spouse Sports</th>
											<th>Spouse Entertainment</th>
											<th>Last Modified at</th>
											<?php if(Check_Selection_Criteria_Exists('field_1')==true){?><th><?php echo getConsumerFieldName('field_1'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_2')==true){?><th><?php echo getConsumerFieldName('field_2'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_3')==true){?><th><?php echo getConsumerFieldName('field_3'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_4')==true){?><th><?php echo getConsumerFieldName('field_4'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_5')==true){?><th><?php echo getConsumerFieldName('field_5'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_6')==true){?><th><?php echo getConsumerFieldName('field_6'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_7')==true){?><th><?php echo getConsumerFieldName('field_7'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_8')==true){?><th><?php echo getConsumerFieldName('field_8'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_9')==true){?><th><?php echo getConsumerFieldName('field_9'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_10')==true){?><th><?php echo getConsumerFieldName('field_10'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_11')==true){?><th><?php echo getConsumerFieldName('field_11'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_12')==true){?><th><?php echo getConsumerFieldName('field_12'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_13')==true){?><th><?php echo getConsumerFieldName('field_13'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_14')==true){?><th><?php echo getConsumerFieldName('field_14'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_15')==true){?><th><?php echo getConsumerFieldName('field_15'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_16')==true){?><th><?php echo getConsumerFieldName('field_16'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_17')==true){?><th><?php echo getConsumerFieldName('field_17'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_18')==true){?><th><?php echo getConsumerFieldName('field_18'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_19')==true){?><th><?php echo getConsumerFieldName('field_19'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_20')==true){?><th><?php echo getConsumerFieldName('field_20'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_21')==true){?><th><?php echo getConsumerFieldName('field_21'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_22')==true){?><th><?php echo getConsumerFieldName('field_22'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_23')==true){?><th><?php echo getConsumerFieldName('field_23'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_24')==true){?><th><?php echo getConsumerFieldName('field_24'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_25')==true){?><th><?php echo getConsumerFieldName('field_25'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_26')==true){?><th><?php echo getConsumerFieldName('field_26'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_27')==true){?><th><?php echo getConsumerFieldName('field_27'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_28')==true){?><th><?php echo getConsumerFieldName('field_28'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_29')==true){?><th><?php echo getConsumerFieldName('field_29'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_30')==true){?><th><?php echo getConsumerFieldName('field_30'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_31')==true){?><th><?php echo getConsumerFieldName('field_31'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_32')==true){?><th><?php echo getConsumerFieldName('field_32'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_33')==true){?><th><?php echo getConsumerFieldName('field_33'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_34')==true){?><th><?php echo getConsumerFieldName('field_34'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_35')==true){?><th><?php echo getConsumerFieldName('field_35'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_36')==true){?><th><?php echo getConsumerFieldName('field_36'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_37')==true){?><th><?php echo getConsumerFieldName('field_37'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_38')==true){?><th><?php echo getConsumerFieldName('field_38'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_39')==true){?><th><?php echo getConsumerFieldName('field_39'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_40')==true){?><th><?php echo getConsumerFieldName('field_40'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_41')==true){?><th><?php echo getConsumerFieldName('field_41'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_42')==true){?><th><?php echo getConsumerFieldName('field_42'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_43')==true){?><th><?php echo getConsumerFieldName('field_43'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_44')==true){?><th><?php echo getConsumerFieldName('field_44'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_45')==true){?><th><?php echo getConsumerFieldName('field_45'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_46')==true){?><th><?php echo getConsumerFieldName('field_46'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_47')==true){?><th><?php echo getConsumerFieldName('field_47'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_48')==true){?><th><?php echo getConsumerFieldName('field_48'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_49')==true){?><th><?php echo getConsumerFieldName('field_49'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_50')==true){?><th><?php echo getConsumerFieldName('field_50'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_51')==true){?><th><?php echo getConsumerFieldName('field_51'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_52')==true){?><th><?php echo getConsumerFieldName('field_52'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_53')==true){?><th><?php echo getConsumerFieldName('field_53'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_54')==true){?><th><?php echo getConsumerFieldName('field_54'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_55')==true){?><th><?php echo getConsumerFieldName('field_55'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_56')==true){?><th><?php echo getConsumerFieldName('field_56'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_57')==true){?><th><?php echo getConsumerFieldName('field_57'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_58')==true){?><th><?php echo getConsumerFieldName('field_58'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_59')==true){?><th><?php echo getConsumerFieldName('field_59'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_60')==true){?><th><?php echo getConsumerFieldName('field_60'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_61')==true){?><th><?php echo getConsumerFieldName('field_61'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_62')==true){?><th><?php echo getConsumerFieldName('field_62'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_63')==true){?><th><?php echo getConsumerFieldName('field_63'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_64')==true){?><th><?php echo getConsumerFieldName('field_64'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_65')==true){?><th><?php echo getConsumerFieldName('field_65'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_66')==true){?><th><?php echo getConsumerFieldName('field_66'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_67')==true){?><th><?php echo getConsumerFieldName('field_67'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_68')==true){?><th><?php echo getConsumerFieldName('field_68'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_69')==true){?><th><?php echo getConsumerFieldName('field_69'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_70')==true){?><th><?php echo getConsumerFieldName('field_70'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_71')==true){?><th><?php echo getConsumerFieldName('field_71'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_72')==true){?><th><?php echo getConsumerFieldName('field_72'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_73')==true){?><th><?php echo getConsumerFieldName('field_73'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_74')==true){?><th><?php echo getConsumerFieldName('field_74'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_75')==true){?><th><?php echo getConsumerFieldName('field_75'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_76')==true){?><th><?php echo getConsumerFieldName('field_76'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_77')==true){?><th><?php echo getConsumerFieldName('field_77'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_78')==true){?><th><?php echo getConsumerFieldName('field_78'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_79')==true){?><th><?php echo getConsumerFieldName('field_79'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_80')==true){?><th><?php echo getConsumerFieldName('field_80'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_81')==true){?><th><?php echo getConsumerFieldName('field_81'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_82')==true){?><th><?php echo getConsumerFieldName('field_82'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_83')==true){?><th><?php echo getConsumerFieldName('field_83'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_84')==true){?><th><?php echo getConsumerFieldName('field_84'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_85')==true){?><th><?php echo getConsumerFieldName('field_85'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_86')==true){?><th><?php echo getConsumerFieldName('field_86'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_87')==true){?><th><?php echo getConsumerFieldName('field_87'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_88')==true){?><th><?php echo getConsumerFieldName('field_88'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_89')==true){?><th><?php echo getConsumerFieldName('field_89'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_90')==true){?><th><?php echo getConsumerFieldName('field_90'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_91')==true){?><th><?php echo getConsumerFieldName('field_91'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_92')==true){?><th><?php echo getConsumerFieldName('field_92'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_93')==true){?><th><?php echo getConsumerFieldName('field_93'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_94')==true){?><th><?php echo getConsumerFieldName('field_94'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_95')==true){?><th><?php echo getConsumerFieldName('field_95'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_96')==true){?><th><?php echo getConsumerFieldName('field_96'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_97')==true){?><th><?php echo getConsumerFieldName('field_97'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_98')==true){?><th><?php echo getConsumerFieldName('field_98'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_99')==true){?><th><?php echo getConsumerFieldName('field_99'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_100')==true){?><th><?php echo getConsumerFieldName('field_100'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_101')==true){?><th><?php echo getConsumerFieldName('field_101'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_102')==true){?><th><?php echo getConsumerFieldName('field_102'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_103')==true){?><th><?php echo getConsumerFieldName('field_103'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_104')==true){?><th><?php echo getConsumerFieldName('field_104'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_105')==true){?><th><?php echo getConsumerFieldName('field_105'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_106')==true){?><th><?php echo getConsumerFieldName('field_106'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_107')==true){?><th><?php echo getConsumerFieldName('field_107'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_108')==true){?><th><?php echo getConsumerFieldName('field_108'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_109')==true){?><th><?php echo getConsumerFieldName('field_109'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_110')==true){?><th><?php echo getConsumerFieldName('field_110'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_111')==true){?><th><?php echo getConsumerFieldName('field_111'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_112')==true){?><th><?php echo getConsumerFieldName('field_112'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_113')==true){?><th><?php echo getConsumerFieldName('field_113'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_114')==true){?><th><?php echo getConsumerFieldName('field_114'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_115')==true){?><th><?php echo getConsumerFieldName('field_115'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_116')==true){?><th><?php echo getConsumerFieldName('field_116'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_117')==true){?><th><?php echo getConsumerFieldName('field_117'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_118')==true){?><th><?php echo getConsumerFieldName('field_118'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_119')==true){?><th><?php echo getConsumerFieldName('field_119'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_120')==true){?><th><?php echo getConsumerFieldName('field_120'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_121')==true){?><th><?php echo getConsumerFieldName('field_121'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_122')==true){?><th><?php echo getConsumerFieldName('field_122'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_123')==true){?><th><?php echo getConsumerFieldName('field_123'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_124')==true){?><th><?php echo getConsumerFieldName('field_124'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_125')==true){?><th><?php echo getConsumerFieldName('field_125'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_126')==true){?><th><?php echo getConsumerFieldName('field_126'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_127')==true){?><th><?php echo getConsumerFieldName('field_127'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_128')==true){?><th><?php echo getConsumerFieldName('field_128'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_129')==true){?><th><?php echo getConsumerFieldName('field_129'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_130')==true){?><th><?php echo getConsumerFieldName('field_130'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_131')==true){?><th><?php echo getConsumerFieldName('field_131'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_132')==true){?><th><?php echo getConsumerFieldName('field_132'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_133')==true){?><th><?php echo getConsumerFieldName('field_133'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_134')==true){?><th><?php echo getConsumerFieldName('field_134'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_135')==true){?><th><?php echo getConsumerFieldName('field_135'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_136')==true){?><th><?php echo getConsumerFieldName('field_136'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_137')==true){?><th><?php echo getConsumerFieldName('field_137'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_138')==true){?><th><?php echo getConsumerFieldName('field_138'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_139')==true){?><th><?php echo getConsumerFieldName('field_139'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_140')==true){?><th><?php echo getConsumerFieldName('field_140'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_141')==true){?><th><?php echo getConsumerFieldName('field_141'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_142')==true){?><th><?php echo getConsumerFieldName('field_142'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_143')==true){?><th><?php echo getConsumerFieldName('field_143'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_144')==true){?><th><?php echo getConsumerFieldName('field_144'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_145')==true){?><th><?php echo getConsumerFieldName('field_145'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_146')==true){?><th><?php echo getConsumerFieldName('field_146'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_147')==true){?><th><?php echo getConsumerFieldName('field_147'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_148')==true){?><th><?php echo getConsumerFieldName('field_148'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_149')==true){?><th><?php echo getConsumerFieldName('field_149'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_150')==true){?><th><?php echo getConsumerFieldName('field_150'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_151')==true){?><th><?php echo getConsumerFieldName('field_151'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_152')==true){?><th><?php echo getConsumerFieldName('field_152'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_153')==true){?><th><?php echo getConsumerFieldName('field_153'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_154')==true){?><th><?php echo getConsumerFieldName('field_154'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_155')==true){?><th><?php echo getConsumerFieldName('field_155'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_156')==true){?><th><?php echo getConsumerFieldName('field_156'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_157')==true){?><th><?php echo getConsumerFieldName('field_157'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_158')==true){?><th><?php echo getConsumerFieldName('field_158'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_159')==true){?><th><?php echo getConsumerFieldName('field_159'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_160')==true){?><th><?php echo getConsumerFieldName('field_160'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_161')==true){?><th><?php echo getConsumerFieldName('field_161'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_162')==true){?><th><?php echo getConsumerFieldName('field_162'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_163')==true){?><th><?php echo getConsumerFieldName('field_163'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_164')==true){?><th><?php echo getConsumerFieldName('field_164'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_165')==true){?><th><?php echo getConsumerFieldName('field_165'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_166')==true){?><th><?php echo getConsumerFieldName('field_166'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_167')==true){?><th><?php echo getConsumerFieldName('field_167'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_168')==true){?><th><?php echo getConsumerFieldName('field_168'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_169')==true){?><th><?php echo getConsumerFieldName('field_169'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_170')==true){?><th><?php echo getConsumerFieldName('field_170'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_171')==true){?><th><?php echo getConsumerFieldName('field_171'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_172')==true){?><th><?php echo getConsumerFieldName('field_172'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_173')==true){?><th><?php echo getConsumerFieldName('field_173'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_174')==true){?><th><?php echo getConsumerFieldName('field_174'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_175')==true){?><th><?php echo getConsumerFieldName('field_175'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_176')==true){?><th><?php echo getConsumerFieldName('field_176'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_177')==true){?><th><?php echo getConsumerFieldName('field_177'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_178')==true){?><th><?php echo getConsumerFieldName('field_178'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_179')==true){?><th><?php echo getConsumerFieldName('field_179'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_180')==true){?><th><?php echo getConsumerFieldName('field_180'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_181')==true){?><th><?php echo getConsumerFieldName('field_181'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_182')==true){?><th><?php echo getConsumerFieldName('field_182'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_183')==true){?><th><?php echo getConsumerFieldName('field_183'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_184')==true){?><th><?php echo getConsumerFieldName('field_184'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_185')==true){?><th><?php echo getConsumerFieldName('field_185'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_186')==true){?><th><?php echo getConsumerFieldName('field_186'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_187')==true){?><th><?php echo getConsumerFieldName('field_187'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_188')==true){?><th><?php echo getConsumerFieldName('field_188'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_189')==true){?><th><?php echo getConsumerFieldName('field_189'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_190')==true){?><th><?php echo getConsumerFieldName('field_190'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_191')==true){?><th><?php echo getConsumerFieldName('field_191'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_192')==true){?><th><?php echo getConsumerFieldName('field_192'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_193')==true){?><th><?php echo getConsumerFieldName('field_193'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_194')==true){?><th><?php echo getConsumerFieldName('field_194'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_195')==true){?><th><?php echo getConsumerFieldName('field_195'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_196')==true){?><th><?php echo getConsumerFieldName('field_196'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_197')==true){?><th><?php echo getConsumerFieldName('field_197'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_198')==true){?><th><?php echo getConsumerFieldName('field_198'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_199')==true){?><th><?php echo getConsumerFieldName('field_199'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_200')==true){?><th><?php echo getConsumerFieldName('field_200'); ?></th><?php } ?>
											<?php if(Check_Selection_Criteria_Exists('field_201')==true){?><th><?php echo getConsumerFieldName('field_201'); ?></th><?php } ?>

											<?php
											}											
											?>
  													</tr>
												</thead>
												
												<tbody>

                                        <?php $i = 0;  //  echo '***<pre>';print_r($orderListing);
										if(count($ScanedCodeListing)>0){
											$i=0;
                                            $page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
										$sno =  $page + 1;
                                        foreach ($ScanedCodeListing as $key=>$listData){
											$i++;
											?>
                                               <tr id="show<?php echo $key; ?>">
											   <td><?php echo $sno;$sno++; ?></td>
											   <td><?php echo $promotion_request_id;?></td>
											   <td><?php echo $promotion_title;?></td>	
											   <td><?php 
								$qproduct_data 	= getquestionFeedbackDetails($listData['product_id'], $listData['consumer_id'], $promotion_id);
										 $i = 0;
										 foreach($qproduct_data as $res){ 
										$i++;
										echo (date('j M Y H:i:s D', strtotime($res['updated_date'])));
										 if($i==1) break;
										 }
										 ?>	
										 </td>
											   <td><?php echo $listData['user_name']; ?></td>
											  <!-- <td><?php //echo $listData['product_name']; ?></td>
												<td><?php //echo $listData['media_type']; ?></td>
												<td><?php //echo (date('j M Y H:i:s D', strtotime($listData['advertisement_push_date']))); ?></td>  -->
												
												<?php 													
								$qproduct_data 	= getquestionFeedbackDetailsBygetquestionID($listData['product_id'], $listData['consumer_id'], $promotion_id); 
											foreach($qproduct_data as $res){ 
														?>
														<td>
														<?php 
											//echo "<br>" . $res['question_id'];	
											
											 //foreach($qproduct_data as $res){ 										 
											//echo "<b>[</b>" . get_question_desc_by_id($res['question_id']) . "<b>]</b>, ";
											echo $res['selected_answer'];
											//echo $res['updated_date'];
										//echo "<b>[</b>" . (date('j M Y H:i:s D', strtotime($res['updated_date']))) . "<b>]</b>";
											//echo "<br>";
												//}
														?>
													</td>
													<?php
												}
												//break;
												
										 /*
										 foreach($qproduct_data as $res){ 										 
											echo "<b>[</b>" . get_question_desc_by_id($res['question_id']) . "<b>]</b>, ";
											echo "<b>[</b>" . $res['selected_answer'] . "<b>]</b>, ";
											//echo $res['updated_date'];
										echo "<b>[</b>" . (date('j M Y H:i:s D', strtotime($res['updated_date']))) . "<b>]</b>";
											echo "<br>";
												} */ ?>
												
												
												<td><?php echo $listData['mobile_no']; ?></td>
												<td><?php echo $listData['email']; ?></td>
												<td><img src="<?php echo base_url()?><?php echo $listData['avatar_url']; ?>" height="40"></td>
												<?php
											$user_id = $this->session->userdata('admin_user_id');
											if($user_id==1){												
											?>
												<td><?php echo $listData['created_at']; ?></td>
												<td><?php echo $listData['aadhaar_number']; ?></td>
												<td><?php echo $listData['gender']; ?></td>
												<td><?php echo $listData['dob']; ?></td>
												<td><?php echo $listData['registration_address']; ?></td>
												<td><?php echo $listData['alternate_mobile_no']; ?></td>
												<td><?php echo $listData['street_address']; ?></td>
												<td><?php echo $listData['city']; ?></td>
												<td><?php echo $listData['state']; ?></td>
												<td><?php echo $listData['pin_code']; ?></td>
												<td><?php echo $listData['monthly_earnings']; ?></td>
												<td><?php echo $listData['job_profile']; ?></td>
												<td><?php echo $listData['education_qualification']; ?></td>
												<td><?php echo $listData['type_vehicle']; ?></td>
												<td><?php echo $listData['profession']; ?></td>
												<td><?php echo $listData['marital_status']; ?></td>
												<td><?php echo $listData['no_of_family_members']; ?></td>
												<td><?php echo $listData['loan_car']; ?></td>
												<td><?php echo $listData['loan_housing']; ?></td>
												<td><?php echo $listData['personal_loan']; ?></td>
												<td><?php echo $listData['credit_card_loan']; ?></td>
												<td><?php echo $listData['own_a_car']; ?></td>
												<td><?php echo $listData['house_type']; ?></td>
												<td><?php echo $listData['last_location']; ?></td>
												<td><?php echo $listData['life_insurance']; ?></td>
												<td><?php echo $listData['medical_insurance']; ?></td>
												<td><?php echo $listData['height_in_inches']; ?></td>
												<td><?php echo $listData['weight_in_kg']; ?></td>
												<td><?php echo $listData['hobbies']; ?></td>
												<td><?php echo $listData['sports']; ?></td>
												<td><?php echo $listData['entertainment']; ?></td>
												<td><?php echo $listData['spouse_gender']; ?></td>
												<td><?php echo $listData['spouse_phone']; ?></td>
												<td><?php echo $listData['spouse_dob']; ?></td>
												<td><?php echo $listData['marriage_anniversary']; ?></td>
												<td><?php echo $listData['spouse_work_status']; ?></td>
												<td><?php echo $listData['spouse_edu_qualification']; ?></td>
												<td><?php echo $listData['spouse_monthly_income']; ?></td>
												<td><?php echo $listData['spouse_loan']; ?></td>
												<td><?php echo $listData['spouse_personal_loan']; ?></td>
												<td><?php echo $listData['spouse_credit_card_loan']; ?></td>
												<td><?php echo $listData['spouse_own_a_car']; ?></td>
												<td><?php echo $listData['spouse_house_type']; ?></td>
												<td><?php echo $listData['spouse_height_inches']; ?></td>
												<td><?php echo $listData['spouse_weight_kg']; ?></td>
												<td><?php echo $listData['spouse_hobbies']; ?></td>
												<td><?php echo $listData['spouse_sports']; ?></td>
												<td><?php echo $listData['spouse_entertainment']; ?></td>
												<td><?php echo $listData['modified_at']; ?></td>
					<?php if(Check_Selection_Criteria_Exists('field_1')==true){?><th><td><?php echo $listData['field_1']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_2')==true){?><th><td><?php echo $listData['field_2']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_3')==true){?><th><td><?php echo $listData['field_3']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_4')==true){?><th><td><?php echo $listData['field_4']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_5')==true){?><th><td><?php echo $listData['field_5']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_6')==true){?><th><td><?php echo $listData['field_6']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_7')==true){?><th><td><?php echo $listData['field_7']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_8')==true){?><th><td><?php echo $listData['field_8']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_9')==true){?><th><td><?php echo $listData['field_9']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_10')==true){?><th><td><?php echo $listData['field_10']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_11')==true){?><th><td><?php echo $listData['field_11']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_12')==true){?><th><td><?php echo $listData['field_12']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_13')==true){?><th><td><?php echo $listData['field_13']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_14')==true){?><th><td><?php echo $listData['field_14']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_15')==true){?><th><td><?php echo $listData['field_15']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_16')==true){?><th><td><?php echo $listData['field_16']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_17')==true){?><th><td><?php echo $listData['field_17']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_18')==true){?><th><td><?php echo $listData['field_18']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_19')==true){?><th><td><?php echo $listData['field_19']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_20')==true){?><th><td><?php echo $listData['field_20']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_21')==true){?><th><td><?php echo $listData['field_21']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_22')==true){?><th><td><?php echo $listData['field_22']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_23')==true){?><th><td><?php echo $listData['field_23']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_24')==true){?><th><td><?php echo $listData['field_24']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_25')==true){?><th><td><?php echo $listData['field_25']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_26')==true){?><th><td><?php echo $listData['field_26']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_27')==true){?><th><td><?php echo $listData['field_27']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_28')==true){?><th><td><?php echo $listData['field_28']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_29')==true){?><th><td><?php echo $listData['field_29']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_30')==true){?><th><td><?php echo $listData['field_30']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_31')==true){?><th><td><?php echo $listData['field_31']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_32')==true){?><th><td><?php echo $listData['field_32']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_33')==true){?><th><td><?php echo $listData['field_33']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_34')==true){?><th><td><?php echo $listData['field_34']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_35')==true){?><th><td><?php echo $listData['field_35']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_36')==true){?><th><td><?php echo $listData['field_36']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_37')==true){?><th><td><?php echo $listData['field_37']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_38')==true){?><th><td><?php echo $listData['field_38']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_39')==true){?><th><td><?php echo $listData['field_39']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_40')==true){?><th><td><?php echo $listData['field_40']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_41')==true){?><th><td><?php echo $listData['field_41']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_42')==true){?><th><td><?php echo $listData['field_42']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_43')==true){?><th><td><?php echo $listData['field_43']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_44')==true){?><th><td><?php echo $listData['field_44']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_45')==true){?><th><td><?php echo $listData['field_45']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_46')==true){?><th><td><?php echo $listData['field_46']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_47')==true){?><th><td><?php echo $listData['field_47']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_48')==true){?><th><td><?php echo $listData['field_48']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_49')==true){?><th><td><?php echo $listData['field_49']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_50')==true){?><th><td><?php echo $listData['field_50']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_51')==true){?><th><td><?php echo $listData['field_51']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_52')==true){?><th><td><?php echo $listData['field_52']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_53')==true){?><th><td><?php echo $listData['field_53']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_54')==true){?><th><td><?php echo $listData['field_54']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_55')==true){?><th><td><?php echo $listData['field_55']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_56')==true){?><th><td><?php echo $listData['field_56']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_57')==true){?><th><td><?php echo $listData['field_57']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_58')==true){?><th><td><?php echo $listData['field_58']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_59')==true){?><th><td><?php echo $listData['field_59']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_60')==true){?><th><td><?php echo $listData['field_60']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_61')==true){?><th><td><?php echo $listData['field_61']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_62')==true){?><th><td><?php echo $listData['field_62']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_63')==true){?><th><td><?php echo $listData['field_63']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_64')==true){?><th><td><?php echo $listData['field_64']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_65')==true){?><th><td><?php echo $listData['field_65']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_66')==true){?><th><td><?php echo $listData['field_66']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_67')==true){?><th><td><?php echo $listData['field_67']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_68')==true){?><th><td><?php echo $listData['field_68']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_69')==true){?><th><td><?php echo $listData['field_69']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_70')==true){?><th><td><?php echo $listData['field_70']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_71')==true){?><th><td><?php echo $listData['field_71']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_72')==true){?><th><td><?php echo $listData['field_72']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_73')==true){?><th><td><?php echo $listData['field_73']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_74')==true){?><th><td><?php echo $listData['field_74']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_75')==true){?><th><td><?php echo $listData['field_75']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_76')==true){?><th><td><?php echo $listData['field_76']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_77')==true){?><th><td><?php echo $listData['field_77']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_78')==true){?><th><td><?php echo $listData['field_78']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_79')==true){?><th><td><?php echo $listData['field_79']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_80')==true){?><th><td><?php echo $listData['field_80']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_81')==true){?><th><td><?php echo $listData['field_81']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_82')==true){?><th><td><?php echo $listData['field_82']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_83')==true){?><th><td><?php echo $listData['field_83']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_84')==true){?><th><td><?php echo $listData['field_84']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_85')==true){?><th><td><?php echo $listData['field_85']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_86')==true){?><th><td><?php echo $listData['field_86']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_87')==true){?><th><td><?php echo $listData['field_87']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_88')==true){?><th><td><?php echo $listData['field_88']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_89')==true){?><th><td><?php echo $listData['field_89']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_90')==true){?><th><td><?php echo $listData['field_90']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_91')==true){?><th><td><?php echo $listData['field_91']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_92')==true){?><th><td><?php echo $listData['field_92']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_93')==true){?><th><td><?php echo $listData['field_93']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_94')==true){?><th><td><?php echo $listData['field_94']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_95')==true){?><th><td><?php echo $listData['field_95']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_96')==true){?><th><td><?php echo $listData['field_96']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_97')==true){?><th><td><?php echo $listData['field_97']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_98')==true){?><th><td><?php echo $listData['field_98']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_99')==true){?><th><td><?php echo $listData['field_99']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_100')==true){?><th><td><?php echo $listData['field_100']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_101')==true){?><th><td><?php echo $listData['field_101']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_102')==true){?><th><td><?php echo $listData['field_102']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_103')==true){?><th><td><?php echo $listData['field_103']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_104')==true){?><th><td><?php echo $listData['field_104']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_105')==true){?><th><td><?php echo $listData['field_105']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_106')==true){?><th><td><?php echo $listData['field_106']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_107')==true){?><th><td><?php echo $listData['field_107']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_108')==true){?><th><td><?php echo $listData['field_108']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_109')==true){?><th><td><?php echo $listData['field_109']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_110')==true){?><th><td><?php echo $listData['field_110']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_111')==true){?><th><td><?php echo $listData['field_111']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_112')==true){?><th><td><?php echo $listData['field_112']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_113')==true){?><th><td><?php echo $listData['field_113']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_114')==true){?><th><td><?php echo $listData['field_114']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_115')==true){?><th><td><?php echo $listData['field_115']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_116')==true){?><th><td><?php echo $listData['field_116']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_117')==true){?><th><td><?php echo $listData['field_117']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_118')==true){?><th><td><?php echo $listData['field_118']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_119')==true){?><th><td><?php echo $listData['field_119']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_120')==true){?><th><td><?php echo $listData['field_120']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_121')==true){?><th><td><?php echo $listData['field_121']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_122')==true){?><th><td><?php echo $listData['field_122']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_123')==true){?><th><td><?php echo $listData['field_123']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_124')==true){?><th><td><?php echo $listData['field_124']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_125')==true){?><th><td><?php echo $listData['field_125']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_126')==true){?><th><td><?php echo $listData['field_126']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_127')==true){?><th><td><?php echo $listData['field_127']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_128')==true){?><th><td><?php echo $listData['field_128']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_129')==true){?><th><td><?php echo $listData['field_129']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_130')==true){?><th><td><?php echo $listData['field_130']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_131')==true){?><th><td><?php echo $listData['field_131']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_132')==true){?><th><td><?php echo $listData['field_132']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_133')==true){?><th><td><?php echo $listData['field_133']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_134')==true){?><th><td><?php echo $listData['field_134']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_135')==true){?><th><td><?php echo $listData['field_135']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_136')==true){?><th><td><?php echo $listData['field_136']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_137')==true){?><th><td><?php echo $listData['field_137']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_138')==true){?><th><td><?php echo $listData['field_138']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_139')==true){?><th><td><?php echo $listData['field_139']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_140')==true){?><th><td><?php echo $listData['field_140']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_141')==true){?><th><td><?php echo $listData['field_141']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_142')==true){?><th><td><?php echo $listData['field_142']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_143')==true){?><th><td><?php echo $listData['field_143']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_144')==true){?><th><td><?php echo $listData['field_144']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_145')==true){?><th><td><?php echo $listData['field_145']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_146')==true){?><th><td><?php echo $listData['field_146']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_147')==true){?><th><td><?php echo $listData['field_147']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_148')==true){?><th><td><?php echo $listData['field_148']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_149')==true){?><th><td><?php echo $listData['field_149']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_150')==true){?><th><td><?php echo $listData['field_150']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_151')==true){?><th><td><?php echo $listData['field_151']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_152')==true){?><th><td><?php echo $listData['field_152']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_153')==true){?><th><td><?php echo $listData['field_153']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_154')==true){?><th><td><?php echo $listData['field_154']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_155')==true){?><th><td><?php echo $listData['field_155']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_156')==true){?><th><td><?php echo $listData['field_156']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_157')==true){?><th><td><?php echo $listData['field_157']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_158')==true){?><th><td><?php echo $listData['field_158']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_159')==true){?><th><td><?php echo $listData['field_159']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_160')==true){?><th><td><?php echo $listData['field_160']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_161')==true){?><th><td><?php echo $listData['field_161']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_162')==true){?><th><td><?php echo $listData['field_162']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_163')==true){?><th><td><?php echo $listData['field_163']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_164')==true){?><th><td><?php echo $listData['field_164']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_165')==true){?><th><td><?php echo $listData['field_165']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_166')==true){?><th><td><?php echo $listData['field_166']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_167')==true){?><th><td><?php echo $listData['field_167']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_168')==true){?><th><td><?php echo $listData['field_168']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_169')==true){?><th><td><?php echo $listData['field_169']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_170')==true){?><th><td><?php echo $listData['field_170']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_171')==true){?><th><td><?php echo $listData['field_171']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_172')==true){?><th><td><?php echo $listData['field_172']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_173')==true){?><th><td><?php echo $listData['field_173']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_174')==true){?><th><td><?php echo $listData['field_174']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_175')==true){?><th><td><?php echo $listData['field_175']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_176')==true){?><th><td><?php echo $listData['field_176']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_177')==true){?><th><td><?php echo $listData['field_177']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_178')==true){?><th><td><?php echo $listData['field_178']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_179')==true){?><th><td><?php echo $listData['field_179']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_180')==true){?><th><td><?php echo $listData['field_180']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_181')==true){?><th><td><?php echo $listData['field_181']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_182')==true){?><th><td><?php echo $listData['field_182']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_183')==true){?><th><td><?php echo $listData['field_183']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_184')==true){?><th><td><?php echo $listData['field_184']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_185')==true){?><th><td><?php echo $listData['field_185']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_186')==true){?><th><td><?php echo $listData['field_186']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_187')==true){?><th><td><?php echo $listData['field_187']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_188')==true){?><th><td><?php echo $listData['field_188']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_189')==true){?><th><td><?php echo $listData['field_189']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_190')==true){?><th><td><?php echo $listData['field_190']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_191')==true){?><th><td><?php echo $listData['field_191']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_192')==true){?><th><td><?php echo $listData['field_192']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_193')==true){?><th><td><?php echo $listData['field_193']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_194')==true){?><th><td><?php echo $listData['field_194']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_195')==true){?><th><td><?php echo $listData['field_195']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_196')==true){?><th><td><?php echo $listData['field_196']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_197')==true){?><th><td><?php echo $listData['field_197']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_198')==true){?><th><td><?php echo $listData['field_198']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_199')==true){?><th><td><?php echo $listData['field_199']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_200')==true){?><th><td><?php echo $listData['field_200']; ?></th><?php } ?>
					<?php if(Check_Selection_Criteria_Exists('field_201')==true){?><th><td><?php echo $listData['field_201']; ?></th><?php } ?>

					<?php	} else {}			?>
	

												
 												<!--<td><?php if($listData['media_play_date']!='0000-00-00 00:00:00') {echo (date('j M Y H:i:s D', strtotime($listData['media_play_date']))); } ?></td>-->
                                              </tr>
                                         <?php }
										}else{ ?>
										<tr>
										
										<td align="center" colspan="8" class="color error">There is no feedback given by any consumer!</td></tr>
										<?php }?>
                                       
                                    </tbody>
                                        </table>
										
                                        <div class="row paging-box">
                                        <?php echo $links ?>
                                        </div>  
												</div> 
  								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
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
			</div><!-- /.main-content -->

			 <div class="modal-container"></div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
		
<?php $this->load->view('../includes/admin_footer');?>
<!---------- modal popup dynaimic---------->
<script type="text/javascript">
	//$(document).ready(function(){
		function print_order(val){
		var url = "<?php echo base_url().'order_master/barcode/view_detail/';?>"+val;
		//jQuery('#modellink').click(function(e) {
		    $('.modal-container').load(url,function(result){
				$('#printMyModal').modal({show:true});
			});
		//});
		}
	//});
</script>
<!---------- modal popup dynaimic---------->
<script>

function validateSrch(){
	$("#searchStr").removeClass('error');
	var val = $("#searchStr").val();
 	if(val.trim()==''){
		$("#searchStr").addClass('error');
		return false;
	}
}

/*function print_option(id){
	var qrrystr;
	qrrystr='generate_order/';
	if($("#print_order_"+id).val()==1){
		qrrystr='generate_order_barcode/';
	}
	var url = qrrystr+btoa(id);
	window.location.href=url;
}
*/
function change_order_status(id,val){
$("#order_status_"+id).hide();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>order_master/change_order_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(result!=''){
						alert('Status Changed Successfully');
						if(parseInt(val)==1){ 
							$("#order_status_"+id).show();
						}
					} 
					
				}
			});
}		
function change_status(id,val){order_status_
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>order_master/change_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(parseInt(result)==1){
						$('#status_'+id).val('Active').css("background-color","green");
					}else{
						$('#status_'+id).val('Inactive').css("background-color","red");
					}
					
				}
			});
}
var table;
 
 
       
 
</script>

<script>$(function () {
     var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
//initializing datepicker
$('.datepicker').datepicker({format:'yyyy-mm-dd', startDate: today,minDate: new Date()  });
 });
 
  

 $("form#frm").validate({
 		rules: {
  			"product[]":{required: true},
 		    quantity: {required: true,number: true}
        		} ,
  		 
 		messages: {
			"product[]": {required: "Please enter Product Name/SKU Code" } , 
			quantity: {	required: "Please enter quantity"} 
		},
 		submitHandler: function(form) {
  			var dataSend;
 			var dataSend 	= $("#frm").serialize();
  			$.ajax({
 				type: "POST",
 				dataType:"json",
 				beforeSend: function(){
				$('.alert-success').hide();
 						//$(".show_loader").show();
  						//$(".show_loader").click();
 				},
 				url: "<?php echo base_url(); ?>order_master/save_order/",
 				data: dataSend,
 				success: function (msg) {
					
 					if(parseInt(msg)==1){
					$('#myModal').modal('hide');
 						//$('#ajax_msg').text("User Added Successfully!").css("color","green").show();
 						$('.alert-success').show();
 						$('#frm')[0].reset(); 
						window.location="<?php echo base_url(); ?>order_master/list_orders/";
 						 					
 					}
 				}

			});

			 return false;

 		}

	});
 
 
 
 
 </script>
 <?php if($this->uri->segment(3)=='open'){?>
 <script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
<?php }?>
 
<?php $this->load->view('../includes/admin_footer');?>