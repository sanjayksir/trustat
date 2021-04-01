<?php 
// echo '<pre>';print_r($get_user_details);exit;
?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<?php $type = "Admin";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='edit_plant_controller'){
									$type = "Consumer Selection Criteria";
								}?>
      <h4 class="widget-title">View <?php echo $type;?></h4>
		<div class="widget-toolbar"> <a href="<?php echo base_url('consumer/list_consumer_selection_criterias/') ?>" > <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="<?php echo base_url('consumer/list_consumer_selection_criterias/') ?>" > <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
		<input type="hidden" name="criteria_id" id="criteria_id" value="<?php echo  $get_user_details[0]['criteria_id']?>" />
        <div class="widget-main">
		
		<div class="form-group row">
		
			<div class="col-sm-8">
			<label for="form-field-8"><b>Name of Selection Criteria</b></label> : 
			<?php echo $get_user_details[0]['name_of_selection_criteria'];?>		 		
			</div>
			
			<div class="col-sm-4">
			<label for="form-field-8"><b>Selected Consumers</b></label> : 
			<?php echo $get_user_details[0]['number_of_consumers_selected'];?>		 		
			</div>

		</div>
		
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Unique Sys S Criteria ID</b></label> : 
			<?php echo $get_user_details[0]['unique_system_selection_criteria_id'];?>		 		
			</div>
			<?php if($get_user_details[0]['consumer_age_option']=="SpecifyAge"){ ?>
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Minimum Age of the consumer in Years</b></label> :
             <?php echo $get_user_details[0]['consumer_min_age'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Maximum Age of the consumer in Years</b></label> :
             <?php echo $get_user_details[0]['consumer_max_age'];?>
			</div>
			<?php }else{ ?>			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Age</b></label> :
			  Age filter is not applied. 
			</div>
			<?php } ?>

		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Consumer Gender</b></label>  : 
			<?php echo $get_user_details[0]['consumer_gender'];?>
			</div>			
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Consumer City of Last Scan</b></label> :
			<?php echo $get_user_details[0]['consumer_city'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Consumer City of Registration</b></label> : 
			<?php echo $get_user_details[0]['city_registration'];?>
			</div>
		</div>
		
			<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Earned Loyalty Points</label> : <?php echo $get_user_details[0]['earned_loyalty_points'];?>		
				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Monthly Earnings</label> : <?php echo $get_user_details[0]['monthly_earnings'];?>		
							
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Job Profile</label> : <?php echo $get_user_details[0]['job_profile'];?>			
			 				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Education Qualification </label> : <?php echo $get_user_details[0]['education_qualification'];?>			
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Type Vehicle </label>	: <?php echo $get_user_details[0]['type_vehicle'];?>		
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Profession</label>	: <?php echo $val['profession'];?>		
			 				
			</div>			
		</div>
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Marital Status</label>	: <?php echo $get_user_details[0]['marital_status'];?>		
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Number of Family Members </label> : <?php echo $get_user_details[0]['no_of_family_members'];?>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Loan Car</label> : <?php echo $get_user_details[0]['loan_car'];?>	 		
			 				
			</div>			
		</div>
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Loan Housing </label>	: <?php echo $get_user_details[0]['loan_housing'];?>		
							
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Personal Loan</label>	: <?php echo $get_user_details[0]['personal_loan'];?>		
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Credit Card Loan </label>	: <?php echo $get_user_details[0]['credit_card_loan'];?>		
							
			</div>			
		</div>
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Own a Car </label>	: <?php echo $get_user_details[0]['own_a_car'];?>		
							
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer House Type</label>	: <?php echo $get_user_details[0]['house_type'];?>		
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Last Location</label>	: <?php echo $get_user_details[0]['last_location'];?>		
			 				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Life Insurance  </label> : <?php echo $get_user_details[0]['life_insurance'];?>			
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Medical Insurance </label>	: <?php echo $get_user_details[0]['medical_insurance'];?>		
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Height in inches </label>	: <?php echo $get_user_details[0]['height_in_inches'];?>			
							
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Weight in Kg  </label>	: <?php echo $get_user_details[0]['weight_in_kg'];?>			
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Hobbies </label>	: <?php echo $get_user_details[0]['hobbies'];?>			
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Sports </label>	: <?php echo $get_user_details[0]['sports'];?>			
							
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Entertainment  </label>	: <?php echo $get_user_details[0]['entertainment'];?>			
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Gender</label>	: <?php echo $get_user_details[0]['spouse_gender'];?>			
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Phone </label>	: <?php echo $get_user_details[0]['spouse_phone'];?>			
			 				
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse dob </label>	: <?php echo $get_user_details[0]['spouse_dob'];?>			
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Marriage Anniversary</label>	: <?php echo $get_user_details[0]['marriage_anniversary'];?>			
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Work Status </label>	: <?php echo $get_user_details[0]['spouse_work_status'];?>			
			 				
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Education Qualification </label>	: <?php echo $get_user_details[0]['spouse_edu_qualification'];?>			
							
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Monthly Income </label>	: <?php echo $get_user_details[0]['spouse_monthly_income'];?>			
			 			
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Loan</label>	: <?php echo $get_user_details[0]['spouse_loan'];?>			
							
			</div>			
		</div>
		
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Personal Loan</label>	: <?php echo $get_user_details[0]['spouse_personal_loan'];?>			
							
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Credit Card Loan </label>	: <?php echo $get_user_details[0]['spouse_credit_card_loan'];?>					
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Own a Car </label>	: <?php echo $get_user_details[0]['spouse_own_a_car'];?>			
			 				
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse House Type </label>	: <?php echo $get_user_details[0]['spouse_house_type'];?>			
			 				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Height Inches </label>	: <?php echo $get_user_details[0]['spouse_height_inches'];?>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Weight Kg</label>	: <?php echo $get_user_details[0]['spouse_weight_kg'];?>			
							
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Hobbies </label>	: <?php echo $get_user_details[0]['spouse_hobbies'];?>			
							
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Sports</label>	: <?php echo $get_user_details[0]['spouse_sports'];?>			
						
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Entertainment</label>	: <?php echo $get_user_details[0]['spouse_entertainment'];?>				
			</div>			
		</div>
		
		<?php if((Check_Selection_Criteria_Exists('field_1')==true)||(Check_Selection_Criteria_Exists('field_2')==true)||(Check_Selection_Criteria_Exists('field_3')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_1')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_1'); ?></label>	: <?php echo $get_user_details[0]['field_1'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_2')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_2'); ?></label>	: <?php echo $get_user_details[0]['field_2'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_3')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_3'); ?></label>	: <?php echo $get_user_details[0]['field_3'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		<?php if((Check_Selection_Criteria_Exists('field_4')==true)||(Check_Selection_Criteria_Exists('field_5')==true)||(Check_Selection_Criteria_Exists('field_6')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_4')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_4'); ?> </label>	: <?php echo $get_user_details[0]['field_4'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_5')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_5'); ?></label>	: <?php echo $get_user_details[0]['field_5'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_6')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_6'); ?></label>	: <?php echo $get_user_details[0]['field_6'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_7')==true)||(Check_Selection_Criteria_Exists('field_8')==true)||(Check_Selection_Criteria_Exists('field_9')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_7')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_7'); ?> </label>	: <?php echo $get_user_details[0]['field_7'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_8')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_8'); ?></label>	: <?php echo $get_user_details[0]['field_8'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_9')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_9'); ?></label>	: <?php echo $get_user_details[0]['field_9'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_10')==true)||(Check_Selection_Criteria_Exists('field_11')==true)||(Check_Selection_Criteria_Exists('field_12')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_10')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_10'); ?> </label>	: <?php echo $get_user_details[0]['field_10'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_11')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_11'); ?></label>	: <?php echo $get_user_details[0]['field_11'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_12')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_12'); ?></label>	: <?php echo $get_user_details[0]['field_12'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_13')==true)||(Check_Selection_Criteria_Exists('field_14')==true)||(Check_Selection_Criteria_Exists('field_15')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_13')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_13'); ?> </label>	: <?php echo $get_user_details[0]['field_13'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_14')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_14'); ?></label>	: <?php echo $get_user_details[0]['field_14'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_15')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_15'); ?></label>	: <?php echo $get_user_details[0]['field_15'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_16')==true)||(Check_Selection_Criteria_Exists('field_17')==true)||(Check_Selection_Criteria_Exists('field_18')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_16')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_16'); ?> </label>	: <?php echo $get_user_details[0]['field_16'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_17')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_17'); ?></label>	: <?php echo $get_user_details[0]['field_17'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_18')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_18'); ?></label>	: <?php echo $get_user_details[0]['field_18'];?>			
			 			
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_19')==true)||(Check_Selection_Criteria_Exists('field_20')==true)||(Check_Selection_Criteria_Exists('field_21')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_19')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_19'); ?> </label>	: <?php echo $get_user_details[0]['field_19'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_20')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_20'); ?></label>	: <?php echo $get_user_details[0]['field_20'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_21')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_21'); ?></label>	: <?php echo $get_user_details[0]['field_21'];?>			
			 			
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_22')==true)||(Check_Selection_Criteria_Exists('field_23')==true)||(Check_Selection_Criteria_Exists('field_24')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_22')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_22'); ?> </label>	: <?php echo $get_user_details[0]['field_22'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_23')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_23'); ?></label>	: <?php echo $get_user_details[0]['field_23'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_24')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_24'); ?></label>	: <?php echo $get_user_details[0]['field_24'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_25')==true)||(Check_Selection_Criteria_Exists('field_26')==true)||(Check_Selection_Criteria_Exists('field_27')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_25')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_25'); ?> </label>	: <?php echo $get_user_details[0]['field_25'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_26')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_26'); ?></label>	: <?php echo $get_user_details[0]['field_26'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_1')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_27'); ?></label>	: <?php echo $get_user_details[0]['field_27'];?>			
					
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_28')==true)||(Check_Selection_Criteria_Exists('field_29')==true)||(Check_Selection_Criteria_Exists('field_30')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_28')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_28'); ?> </label>	: <?php echo $get_user_details[0]['field_28'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_29')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_29'); ?></label>	: <?php echo $get_user_details[0]['field_29'];?>			
					
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_30')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_30'); ?></label>	: <?php echo $get_user_details[0]['field_30'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_31')==true)||(Check_Selection_Criteria_Exists('field_32')==true)||(Check_Selection_Criteria_Exists('field_33')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_31')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_31'); ?> </label>	: <?php echo $get_user_details[0]['field_31'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_32')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_32'); ?></label>	: <?php echo $get_user_details[0]['field_32'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_33')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_33'); ?></label>	: <?php echo $get_user_details[0]['field_33'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_34')==true)||(Check_Selection_Criteria_Exists('field_35')==true)||(Check_Selection_Criteria_Exists('field_36')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_34')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_34'); ?> </label>	: <?php echo $get_user_details[0]['field_34'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_35')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_35'); ?></label>	: <?php echo $get_user_details[0]['field_35'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_36')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_36'); ?></label>	: <?php echo $get_user_details[0]['field_36'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_37')==true)||(Check_Selection_Criteria_Exists('field_38')==true)||(Check_Selection_Criteria_Exists('field_39')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_37')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_37'); ?> </label>	: <?php echo $get_user_details[0]['field_37'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_38')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_38'); ?></label>	: <?php echo $get_user_details[0]['field_38'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_39')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_39'); ?></label>	: <?php echo $get_user_details[0]['field_39'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_40')==true)||(Check_Selection_Criteria_Exists('field_41')==true)||(Check_Selection_Criteria_Exists('field_42')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_40')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_40'); ?> </label>	: <?php echo $get_user_details[0]['field_40'];?>			
					
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_41')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_41'); ?></label>	: <?php echo $get_user_details[0]['field_41'];?>			
					
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_42')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_42'); ?></label>	: <?php echo $get_user_details[0]['field_42'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_43')==true)||(Check_Selection_Criteria_Exists('field_44')==true)||(Check_Selection_Criteria_Exists('field_45')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_43')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_43'); ?> </label>	: <?php echo $get_user_details[0]['field_43'];?>			
					
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_44')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_44'); ?></label>	: <?php echo $get_user_details[0]['field_44'];?>			
					
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_45')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_45'); ?></label>	: <?php echo $get_user_details[0]['field_45'];?>			
					
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_46')==true)||(Check_Selection_Criteria_Exists('field_47')==true)||(Check_Selection_Criteria_Exists('field_48')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_46')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_46'); ?> </label>	: <?php echo $get_user_details[0]['field_46'];?>			
					
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_47')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_47'); ?></label>	: <?php echo $get_user_details[0]['field_47'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_48')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_48'); ?></label>	: <?php echo $get_user_details[0]['field_48'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_49')==true)||(Check_Selection_Criteria_Exists('field_50')==true)||(Check_Selection_Criteria_Exists('field_51')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_49')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_49'); ?> </label>	: <?php echo $get_user_details[0]['field_49'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_50')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_50'); ?></label>	: <?php echo $get_user_details[0]['field_50'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_51')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_51'); ?></label>	: <?php echo $get_user_details[0]['field_51'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_52')==true)||(Check_Selection_Criteria_Exists('field_53')==true)||(Check_Selection_Criteria_Exists('field_54')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_52')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_52'); ?> </label>	: <?php echo $get_user_details[0]['field_52'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_53')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_53'); ?></label>	: <?php echo $get_user_details[0]['field_53'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_54')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_54'); ?></label>	: <?php echo $get_user_details[0]['field_54'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_55')==true)||(Check_Selection_Criteria_Exists('field_56')==true)||(Check_Selection_Criteria_Exists('field_57')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_55')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_55'); ?> </label>	: <?php echo $get_user_details[0]['field_55'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_56')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_56'); ?></label>	: <?php echo $get_user_details[0]['field_56'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_57')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_57'); ?></label>	: <?php echo $get_user_details[0]['field_57'];?>			
					
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_58')==true)||(Check_Selection_Criteria_Exists('field_59')==true)||(Check_Selection_Criteria_Exists('field_60')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_58')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_58'); ?> </label>	: <?php echo $get_user_details[0]['field_58'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_59')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_59'); ?></label>	: <?php echo $get_user_details[0]['field_59'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_60')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_60'); ?></label>	: <?php echo $get_user_details[0]['field_60'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_61')==true)||(Check_Selection_Criteria_Exists('field_62')==true)||(Check_Selection_Criteria_Exists('field_63')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_61')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_61'); ?> </label>	: <?php echo $get_user_details[0]['field_61'];?>			
					
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_62')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_62'); ?></label>	: <?php echo $get_user_details[0]['field_62'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_63')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_63'); ?></label>	: <?php echo $get_user_details[0]['field_63'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_64')==true)||(Check_Selection_Criteria_Exists('field_65')==true)||(Check_Selection_Criteria_Exists('field_66')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_64')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_64'); ?> </label>	: <?php echo $get_user_details[0]['field_64'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_65')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_65'); ?></label>	: <?php echo $get_user_details[0]['field_65'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_66')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_66'); ?></label>	: <?php echo $get_user_details[0]['field_66'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_67')==true)||(Check_Selection_Criteria_Exists('field_68')==true)||(Check_Selection_Criteria_Exists('field_69')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_67')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_67'); ?> </label>	: <?php echo $get_user_details[0]['field_67'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_68')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_68'); ?></label>	: <?php echo $get_user_details[0]['field_68'];?>			
					
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_69')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_69'); ?></label>	: <?php echo $get_user_details[0]['field_69'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_70')==true)||(Check_Selection_Criteria_Exists('field_71')==true)||(Check_Selection_Criteria_Exists('field_72')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_70')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_70'); ?> </label>	: <?php echo $get_user_details[0]['field_70'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_71')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_71'); ?></label>	: <?php echo $get_user_details[0]['field_71'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_72')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_72'); ?></label>	: <?php echo $get_user_details[0]['field_72'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_73')==true)||(Check_Selection_Criteria_Exists('field_74')==true)||(Check_Selection_Criteria_Exists('field_75')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_73')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_73'); ?> </label>	: <?php echo $get_user_details[0]['field_73'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_74')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_74'); ?></label>	: <?php echo $get_user_details[0]['field_74'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_75')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_75'); ?></label>	: <?php echo $get_user_details[0]['field_75'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_76')==true)||(Check_Selection_Criteria_Exists('field_77')==true)||(Check_Selection_Criteria_Exists('field_78')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_76')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_76'); ?> </label>	: <?php echo $get_user_details[0]['field_76'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_77')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_77'); ?></label>	: <?php echo $get_user_details[0]['field_77'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_78')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_78'); ?></label>	: <?php echo $get_user_details[0]['field_78'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_79')==true)||(Check_Selection_Criteria_Exists('field_80')==true)||(Check_Selection_Criteria_Exists('field_81')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_79')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_79'); ?> </label>	: <?php echo $get_user_details[0]['field_79'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_80')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_80'); ?></label>	: <?php echo $get_user_details[0]['field_80'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_81')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_81'); ?></label>	: <?php echo $get_user_details[0]['field_81'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_82')==true)||(Check_Selection_Criteria_Exists('field_83')==true)||(Check_Selection_Criteria_Exists('field_84')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_82')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_82'); ?> </label>	: <?php echo $get_user_details[0]['field_82'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_83')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_83'); ?></label>	: <?php echo $get_user_details[0]['field_83'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_84')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_84'); ?></label>	: <?php echo $get_user_details[0]['field_84'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_85')==true)||(Check_Selection_Criteria_Exists('field_86')==true)||(Check_Selection_Criteria_Exists('field_87')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_1')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_85'); ?> </label>	: <?php echo $get_user_details[0]['field_85'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_86')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_86'); ?></label>	: <?php echo $get_user_details[0]['field_86'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_87')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_87'); ?></label>	: <?php echo $get_user_details[0]['field_87'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_88')==true)||(Check_Selection_Criteria_Exists('field_89')==true)||(Check_Selection_Criteria_Exists('field_90')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_88')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_88'); ?> </label>	: <?php echo $get_user_details[0]['field_88'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_89')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_89'); ?></label>	: <?php echo $get_user_details[0]['field_89'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_90')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_90'); ?></label>	: <?php echo $get_user_details[0]['field_90'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_91')==true)||(Check_Selection_Criteria_Exists('field_92')==true)||(Check_Selection_Criteria_Exists('field_93')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_91')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_91'); ?> </label>	: <?php echo $get_user_details[0]['field_91'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_92')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_92'); ?></label>	: <?php echo $get_user_details[0]['field_92'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_93')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_93'); ?></label>	: <?php echo $get_user_details[0]['field_93'];?>			
			 			
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_94')==true)||(Check_Selection_Criteria_Exists('field_95')==true)||(Check_Selection_Criteria_Exists('field_96')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_94')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_94'); ?> </label>	: <?php echo $get_user_details[0]['field_94'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_95')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_95'); ?></label>	: <?php echo $get_user_details[0]['field_95'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_96')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_96'); ?></label>	: <?php echo $get_user_details[0]['field_96'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_97')==true)||(Check_Selection_Criteria_Exists('field_98')==true)||(Check_Selection_Criteria_Exists('field_99')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_97')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_97'); ?> </label>	: <?php echo $get_user_details[0]['field_97'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_98')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_98'); ?></label>	: <?php echo $get_user_details[0]['field_98'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_99')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_99'); ?></label>	: <?php echo $get_user_details[0]['field_99'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_100')==true)||(Check_Selection_Criteria_Exists('field_101')==true)||(Check_Selection_Criteria_Exists('field_102')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_100')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_100'); ?> </label>	: <?php echo $get_user_details[0]['field_100'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_101')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_101'); ?></label>	: <?php echo $get_user_details[0]['field_101'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_102')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_102'); ?></label>	: <?php echo $get_user_details[0]['field_102'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_103')==true)||(Check_Selection_Criteria_Exists('field_104')==true)||(Check_Selection_Criteria_Exists('field_105')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_103')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_103'); ?> </label>	: <?php echo $get_user_details[0]['field_103'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_104')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_104'); ?></label>	: <?php echo $get_user_details[0]['field_104'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_105')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_105'); ?></label>	: <?php echo $get_user_details[0]['field_105'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_106')==true)||(Check_Selection_Criteria_Exists('field_107')==true)||(Check_Selection_Criteria_Exists('field_108')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_106')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_106'); ?> </label>	: <?php echo $get_user_details[0]['field_106'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_107')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_107'); ?></label>	: <?php echo $get_user_details[0]['field_107'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_108')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_108'); ?></label>	: <?php echo $get_user_details[0]['field_108'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_109')==true)||(Check_Selection_Criteria_Exists('field_110')==true)||(Check_Selection_Criteria_Exists('field_111')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_109')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_109'); ?> </label>	: <?php echo $get_user_details[0]['field_109'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_110')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_110'); ?></label>	: <?php echo $get_user_details[0]['field_110'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_111')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_111'); ?></label>	: <?php echo $get_user_details[0]['field_111'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		
		<?php if((Check_Selection_Criteria_Exists('field_112')==true)||(Check_Selection_Criteria_Exists('field_113')==true)||(Check_Selection_Criteria_Exists('field_114')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_112')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_112'); ?> </label>	: <?php echo $get_user_details[0]['field_112'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_113')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_113'); ?></label>	: <?php echo $get_user_details[0]['field_113'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_114')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_114'); ?></label>	: <?php echo $get_user_details[0]['field_114'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_115')==true)||(Check_Selection_Criteria_Exists('field_116')==true)||(Check_Selection_Criteria_Exists('field_117')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_115')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_115'); ?> </label>	: <?php echo $get_user_details[0]['field_115'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_116')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_116'); ?></label>	: <?php echo $get_user_details[0]['field_116'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_117')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_117'); ?></label>	: <?php echo $get_user_details[0]['field_117'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_118')==true)||(Check_Selection_Criteria_Exists('field_119')==true)||(Check_Selection_Criteria_Exists('field_120')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_118')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_118'); ?> </label>	: <?php echo $get_user_details[0]['field_118'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_119')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_119'); ?></label>	: <?php echo $get_user_details[0]['field_119'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_120')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_120'); ?></label>	: <?php echo $get_user_details[0]['field_120'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_121')==true)||(Check_Selection_Criteria_Exists('field_122')==true)||(Check_Selection_Criteria_Exists('field_123')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_121')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_121'); ?> </label>	: <?php echo $get_user_details[0]['field_121'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_122')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_122'); ?></label>	: <?php echo $get_user_details[0]['field_122'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_123')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_123'); ?></label>	: <?php echo $get_user_details[0]['field_123'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_124')==true)||(Check_Selection_Criteria_Exists('field_125')==true)||(Check_Selection_Criteria_Exists('field_126')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_124')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_124'); ?> </label>	: <?php echo $get_user_details[0]['field_124'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_125')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_125'); ?></label>	: <?php echo $get_user_details[0]['field_125'];?>			
			 			
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_126')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_126'); ?></label>	: <?php echo $get_user_details[0]['field_126'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_127')==true)||(Check_Selection_Criteria_Exists('field_128')==true)||(Check_Selection_Criteria_Exists('field_129')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_127')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_127'); ?> </label>	: <?php echo $get_user_details[0]['field_127'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_128')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_128'); ?></label>	: <?php echo $get_user_details[0]['field_128'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_129')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_129'); ?></label>	: <?php echo $get_user_details[0]['field_129'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_130')==true)||(Check_Selection_Criteria_Exists('field_131')==true)||(Check_Selection_Criteria_Exists('field_132')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_130')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_130'); ?> </label>	: <?php echo $get_user_details[0]['field_130'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_131')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_131'); ?></label>	: <?php echo $get_user_details[0]['field_131'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_132')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_132'); ?></label>	: <?php echo $get_user_details[0]['field_132'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_133')==true)||(Check_Selection_Criteria_Exists('field_134')==true)||(Check_Selection_Criteria_Exists('field_135')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_133')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_133'); ?> </label>	: <?php echo $get_user_details[0]['field_133'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_134')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_134'); ?></label>	: <?php echo $get_user_details[0]['field_134'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_135')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_135'); ?></label>	: <?php echo $get_user_details[0]['field_135'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_136')==true)||(Check_Selection_Criteria_Exists('field_137')==true)||(Check_Selection_Criteria_Exists('field_138')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_136')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_136'); ?> </label>	: <?php echo $get_user_details[0]['field_136'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_137')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_137'); ?></label>	: <?php echo $get_user_details[0]['field_137'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_138')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_138'); ?></label>	: <?php echo $get_user_details[0]['field_138'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_139')==true)||(Check_Selection_Criteria_Exists('field_140')==true)||(Check_Selection_Criteria_Exists('field_141')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_139')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_139'); ?> </label>	: <?php echo $get_user_details[0]['field_139'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_140')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_140'); ?></label>	: <?php echo $get_user_details[0]['field_140'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_141')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_141'); ?></label>	: <?php echo $get_user_details[0]['field_141'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_142')==true)||(Check_Selection_Criteria_Exists('field_143')==true)||(Check_Selection_Criteria_Exists('field_144')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_142')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_142'); ?> </label>	: <?php echo $get_user_details[0]['field_142'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_143')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_143'); ?></label>	: <?php echo $get_user_details[0]['field_143'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_144')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_144'); ?></label>	: <?php echo $get_user_details[0]['field_144'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_145')==true)||(Check_Selection_Criteria_Exists('field_146')==true)||(Check_Selection_Criteria_Exists('field_147')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_145')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_145'); ?> </label>	: <?php echo $get_user_details[0]['field_145'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_146')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_146'); ?></label>	: <?php echo $get_user_details[0]['field_146'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_147')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_147'); ?></label>	: <?php echo $get_user_details[0]['field_147'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_148')==true)||(Check_Selection_Criteria_Exists('field_149')==true)||(Check_Selection_Criteria_Exists('field_150')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_148')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_148'); ?> </label>	: <?php echo $get_user_details[0]['field_148'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_149')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_149'); ?></label>	: <?php echo $get_user_details[0]['field_149'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_150')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_150'); ?></label>	: <?php echo $get_user_details[0]['field_150'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_151')==true)||(Check_Selection_Criteria_Exists('field_152')==true)||(Check_Selection_Criteria_Exists('field_153')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_151')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_151'); ?> </label>	: <?php echo $get_user_details[0]['field_151'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_152')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_152'); ?></label>	: <?php echo $get_user_details[0]['field_152'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_153')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_153'); ?></label>	: <?php echo $get_user_details[0]['field_153'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_154')==true)||(Check_Selection_Criteria_Exists('field_155')==true)||(Check_Selection_Criteria_Exists('field_156')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_154')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_154'); ?> </label>	: <?php echo $get_user_details[0]['field_154'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_155')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_155'); ?></label>	: <?php echo $get_user_details[0]['field_155'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_156')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_156'); ?></label>	: <?php echo $get_user_details[0]['field_156'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_157')==true)||(Check_Selection_Criteria_Exists('field_158')==true)||(Check_Selection_Criteria_Exists('field_159')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_157')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_157'); ?> </label>	: <?php echo $get_user_details[0]['field_157'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_158')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_158'); ?></label>	: <?php echo $get_user_details[0]['field_158'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_159')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_159'); ?></label>	: <?php echo $get_user_details[0]['field_159'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_160')==true)||(Check_Selection_Criteria_Exists('field_161')==true)||(Check_Selection_Criteria_Exists('field_162')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_160')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_160'); ?> </label>	: <?php echo $get_user_details[0]['field_160'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_161')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_161'); ?></label>	: <?php echo $get_user_details[0]['field_161'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_162')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_162'); ?></label>	: <?php echo $get_user_details[0]['field_162'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_163')==true)||(Check_Selection_Criteria_Exists('field_164')==true)||(Check_Selection_Criteria_Exists('field_165')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_163')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_163'); ?> </label>	: <?php echo $get_user_details[0]['field_163'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_164')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_164'); ?></label>	: <?php echo $get_user_details[0]['field_164'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_165')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_165'); ?></label>	: <?php echo $get_user_details[0]['field_165'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_166')==true)||(Check_Selection_Criteria_Exists('field_167')==true)||(Check_Selection_Criteria_Exists('field_168')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_166')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_166'); ?> </label>	: <?php echo $get_user_details[0]['field_166'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_167')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_167'); ?></label>	: <?php echo $get_user_details[0]['field_167'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_168')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_168'); ?></label>	: <?php echo $get_user_details[0]['field_168'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_169')==true)||(Check_Selection_Criteria_Exists('field_170')==true)||(Check_Selection_Criteria_Exists('field_171')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_169')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_169'); ?> </label>	: <?php echo $get_user_details[0]['field_169'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_170')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_170'); ?></label>	: <?php echo $get_user_details[0]['field_170'];?>			
			 			
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_171')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_171'); ?></label>	: <?php echo $get_user_details[0]['field_171'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_172')==true)||(Check_Selection_Criteria_Exists('field_173')==true)||(Check_Selection_Criteria_Exists('field_174')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_172')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_172'); ?> </label>	: <?php echo $get_user_details[0]['field_172'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_173')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_173'); ?></label>	: <?php echo $get_user_details[0]['field_173'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_174')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_174'); ?></label>	: <?php echo $get_user_details[0]['field_174'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_175')==true)||(Check_Selection_Criteria_Exists('field_176')==true)||(Check_Selection_Criteria_Exists('field_177')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_175')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_175'); ?> </label>	: <?php echo $get_user_details[0]['field_175'];?>			
			 			
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_176')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_176'); ?></label>	: <?php echo $get_user_details[0]['field_176'];?>			
			 			
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_177')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_177'); ?></label>	: <?php echo $get_user_details[0]['field_177'];?>			
						
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_178')==true)||(Check_Selection_Criteria_Exists('field_179')==true)||(Check_Selection_Criteria_Exists('field_180')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_178')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_178'); ?> </label>	: <?php echo $get_user_details[0]['field_178'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_179')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_179'); ?></label>	: <?php echo $get_user_details[0]['field_179'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_180')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_180'); ?></label>	: <?php echo $get_user_details[0]['field_180'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_181')==true)||(Check_Selection_Criteria_Exists('field_182')==true)||(Check_Selection_Criteria_Exists('field_183')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_181')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_181'); ?> </label>	: <?php echo $get_user_details[0]['field_181'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_182')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_182'); ?></label>	: <?php echo $get_user_details[0]['field_182'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_183')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_183'); ?></label>	: <?php echo $get_user_details[0]['field_183'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_184')==true)||(Check_Selection_Criteria_Exists('field_185')==true)||(Check_Selection_Criteria_Exists('field_186')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_184')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_184'); ?> </label>	: <?php echo $get_user_details[0]['field_184'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_185')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_185'); ?></label>	: <?php echo $get_user_details[0]['field_185'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_186')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_186'); ?></label>	: <?php echo $get_user_details[0]['field_186'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_187')==true)||(Check_Selection_Criteria_Exists('field_188')==true)||(Check_Selection_Criteria_Exists('field_189')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_187')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_187'); ?> </label>	: <?php echo $get_user_details[0]['field_187'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_188')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_188'); ?></label>	: <?php echo $get_user_details[0]['field_188'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_189')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_189'); ?></label>	: <?php echo $get_user_details[0]['field_189'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_190')==true)||(Check_Selection_Criteria_Exists('field_191')==true)||(Check_Selection_Criteria_Exists('field_192')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_190')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_190'); ?> </label>	: <?php echo $get_user_details[0]['field_190'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_191')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_191'); ?></label>	: <?php echo $get_user_details[0]['field_191'];?>			
			 			
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_192')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_192'); ?></label>	: <?php echo $get_user_details[0]['field_192'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_193')==true)||(Check_Selection_Criteria_Exists('field_194')==true)||(Check_Selection_Criteria_Exists('field_195')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_193')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_193'); ?> </label>	: <?php echo $get_user_details[0]['field_193'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_194')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_194'); ?></label>	: <?php echo $get_user_details[0]['field_194'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_195')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_195'); ?></label>	: <?php echo $get_user_details[0]['field_195'];?>			
							
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_196')==true)||(Check_Selection_Criteria_Exists('field_197')==true)||(Check_Selection_Criteria_Exists('field_198')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_196')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_196'); ?> </label>	: <?php echo $get_user_details[0]['field_196'];?>			
						
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_197')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_197'); ?></label>	: <?php echo $get_user_details[0]['field_197'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_198')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_198'); ?></label>	: <?php echo $get_user_details[0]['field_198'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		<?php if((Check_Selection_Criteria_Exists('field_199')==true)||(Check_Selection_Criteria_Exists('field_200')==true)||(Check_Selection_Criteria_Exists('field_201')==true)){ ?> <div class="form-group row">			
			<?php if(Check_Selection_Criteria_Exists('field_199')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_199'); ?> </label>	: <?php echo $get_user_details[0]['field_199'];?>			
			 				
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_200')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_200'); ?></label>	: <?php echo $get_user_details[0]['field_200'];?>			
							
			</div> <?php } ?>	
			<?php if(Check_Selection_Criteria_Exists('field_201')==true){?> <div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_201'); ?></label>	: <?php echo $get_user_details[0]['field_201'];?>			
			 				
			</div> <?php } ?>			
		</div> <?php } ?>
		
		
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Your Industry</label>
			<!--<input name="industry" id="industry" type="text" class="form-control" placeholder="Industry Name" value="<?php //echo $get_user_details[0]['industry'];?>"  maxlength="100">-->
			
			
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Pan</label>
             <input name="pan" id="pan" type="text" value="<?php echo $get_user_details[0]['pan'];?>" class="form-control" placeholder="Pan No." maxlength="12">
			</div>
		</div>
		
		
		
		
		
		
		<div class="form-group row">
			<div class="col-sm-6">
			 <label for="form-field-9">State</label>
			 <?php $states = get_state_name(31);?>
               
			</div>
			 
			
			<div class="col-sm-6">
			 <label for="form-field-9">City</label>
			  <select class="form-control" id="city_name" name="city_name">
 		  		<option value="">select City</option>       
             </select>
			</div>
		</div>
		<?php }?>
		
		
          <!--  <div class="form-group row">
                <div class="col-sm-6">
                    <label for="form-field-8">Select Plant</label>
                    <select name="plant_id" id="plant_id" class="form-control" required="required">
                        <?php echo Utils::selectOptions('plant_id', ['options' => $plants, 'empty' => 'Select Plant', 'value' => Utils::elemValue('plant_id', $get_user_details[0])]) ?>
                    </select>
                </div> 
            </div>-->
		 <?php if($this->uri->segment(2)=='edit_plant_controller'){?>
		 <div class="form-group row">
		     <div class="col-sm-6">
            <?php //echo '<pre>';print_r($get_user_details);?>
			  <label for="form-field-9">CCC Admin</label>
			 <?php $ccadmin = getParentUsers('','1');?>
             <select class="form-control" placeholder="Select Admin" id="ccadmin" name="ccadmin" onchange="get_related_city_list(this.value);">
			 <option value="">-Select CCC Admin-</option>
  		  		<?php foreach($ccadmin as $val){?>
				<option <?php if($val['user_id']==$get_user_details[0]['is_parent']){echo 'selected';}?> value="<?php echo $val['user_id'];?>"><?php  echo $val['user_name'];?></option> 
			 	<?php }?>
			 </select>  
 			</div> 
                
		</div>
		<?php }else{?>
         <select  id="ccadmin" name="ccadmin" style="display:none;">
  				<option value="1"></option> 
 			 </select>  
		<?php }?>
            
		     

           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

           <a href="<?php echo base_url('consumer/list_consumer_selection_criterias/') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to List Consumer Selection Criteria <?php echo $label; ?> </a>
          </div>

        </div>

      </form>
		</div>
</div>
</div>
<script type="text/javascript">
 	function readURL(input) {
 		 if (input.files && input.files[0]) {
 			var reader = new FileReader();
 			 reader.onload = function (e) {
 				$('#blah').attr('src', e.target.result).show();
 			}
 			 reader.readAsDataURL(input.files[0]);
 		}
 	}
  </script>
