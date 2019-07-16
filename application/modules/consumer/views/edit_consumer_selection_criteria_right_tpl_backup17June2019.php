<?php 
// echo '<pre>';print_r($get_user_details);exit;
?>

<div class="col-xs-12">
		<div class="widget-box">
				<div class="widget-header">
						<?php $type = "Admin";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='edit_plant_controller'){
									$type = "User";
								}?>
      <h4 class="widget-title">Edit <?php echo $type;?></h4>
		<div class="widget-toolbar"> <a href="<?php echo base_url('consumer/list_consumer_selection_criterias/') ?>" > <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="<?php echo base_url('consumer/list_consumer_selection_criterias/') ?>" > <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<form name="user_frm" id="user_frm" action="#" method="POST">
		<input type="hidden" name="criteria_id" id="criteria_id" value="<?php echo  $get_user_details[0]['criteria_id']?>" />
        <div class="widget-main">
		
		<div class="form-group row">
			
			
			<div class="col-sm-12">
			  <label for="form-field-8">Name of Selection Criteria</label>
			  <input type="text" placeholder="Please enter Name of Selection Criteria" name="name_of_selection_criteria" id="name_of_selection_criteria" value="<?php echo $get_user_details[0]['name_of_selection_criteria'];?>" class="form-control" required>			  
			</div>
				
		</div>
		
		
		<div class="form-group row">
		
			<div class="col-sm-4">
			  <label for="form-field-8">Unique System Selection Criteria ID</label>
			  <input type="text" placeholder="Unique System Selection Criteria ID" name="unique_system_selection_criteria_id" id="unique_system_selection_criteria_id" class="form-control" value="<?php echo $get_user_details[0]['unique_system_selection_criteria_id'];?>" readonly>			  
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Minimum Age of the consumer in Years</label>
             <!--<input name="consumer_min_age"  id="consumer_min_age" type="text" class="form-control" value="<?php echo $get_user_details[0]['consumer_min_age'];?>" placeholder="Minimum Age in Years">-->
			 
			  <input type="number" placeholder="Minimum Age of the consumer in Years" value="<?php echo $get_user_details[0]['consumer_min_age'];?>" min="5" max="99" name="consumer_min_age" id="consumer_min_age" class="form-control" required>	
			</div>
			 
			
			<div class="col-sm-4">
			  <label for="form-field-8">Maximum Age of the consumer in Years</label>

            <!--<input name="consumer_max_age" id="consumer_max_age" type="text" class="form-control" value="<?php echo $get_user_details[0]['consumer_max_age'];?>" placeholder="Maximum Age in Years"  maxlength="50">-->
			
			<input type="number" placeholder="Maximum Age of the consumer in Years"  value="<?php echo $get_user_details[0]['consumer_max_age'];?>" min="6" max="100" name="consumer_max_age" onblur="compare();" id="consumer_max_age" class="form-control" required>
			
			</div>
		</div>
				<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Gender</label>
			  <select  name="consumer_gender" id="consumer_gender" class="form-control" required>
           <option value="">-Consumer Gender-</option>	
<option value="<?php echo $get_user_details[0]['consumer_gender'];?>" selected><?php echo $get_user_details[0]['consumer_gender'];?></option>
			<option value="all">All</option> 
            <?php foreach(getConsumerData('gender') as $val){?>
				<option value="<?php echo $val['gender'];?>"><?php  echo $val['gender'];?></option> 
			<?php } ?>				
            </select>
			  <!--
             <select  name="consumer_gender" id="consumer_gender" class="form-control">
			 <option value="">-Consumer Gender-</option>
			<option value="all" selected>All Gender</option>
            <option value="male">Male Only</option>
			<option value="female">Female Only</option>
			<option value="transgender">Transgender Only</option>
			</select>
			-->
			</div>		
			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer City of Last Scan</label>
			<!--<input name="consumer_city" id="consumer_city" type="text" class="form-control" placeholder="City of Consumer"  maxlength="30">-->
			<select  name="consumer_city" id="consumer_city" class="form-control" required>
           <option value="">-Consumer City of Last Scan-</option>	
		   <option value="<?php echo $get_user_details[0]['consumer_city'];?>" selected><?php echo $get_user_details[0]['consumer_city'];?></option>	 
			<option value="all">All</option>		   
            <?php foreach(getConsumerCitiesofLastScan('0') as $val){?>
				<option value="<?php echo $val['scan_city'];?>"><?php  echo $val['scan_city'];?></option> 
			<?php } ?>				
            </select>	
			
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer City of Registration</label>
			<!--<input name="consumer_city" id="consumer_city" type="text" class="form-control" placeholder="City of Consumer"  maxlength="30">-->
			 <select  name="city_registration" id="city_registration" class="form-control" required>
           <option value="">-Consumer City of Registration-</option>	
			<option value="<?php echo $get_user_details[0]['city_registration'];?>" selected><?php echo $get_user_details[0]['city_registration'];?></option>	
				<option value="all">All</option>
            <?php foreach(getConsumerData('city') as $val){?>
				<option value="<?php echo $val['city'];?>"><?php  echo $val['city'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
	<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Earned Loyalty Points</label>			
			 <select  name="earned_loyalty_points" id="earned_loyalty_points" class="form-control" required>
				<option value="">-Earned Loyalty Points-</option>
				<option value="<?php echo $get_user_details[0]['earned_loyalty_points'];?>" selected><?php echo $get_user_details[0]['earned_loyalty_points'];?></option>
            	<option value="all">Any</option> 
            	<option value="0 to 100">0 to 100</option> 
				<option value="101 to 200">101 to 200</option>
				<option value="201 to 500">201 to 500</option>
				<option value="501 to 1,000">501 to 1,000</option>
				<option value="1001 to 5000">1,001 to 5,000</option>
				<option value="5001 to 10000">5,001 to 10,000</option>
				<option value="10000 to 100000000000">More Than 10,000</option>
			</select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Monthly Earnings</label>			
			 <select  name="monthly_earnings" id="monthly_earnings" class="form-control" required>
				<option value="">-Consumer Monthly Earnings-</option>	   
				<option value="<?php echo $get_user_details[0]['monthly_earnings'];?>" selected><?php echo $get_user_details[0]['monthly_earnings'];?></option>
				<option value="all">All</option>	
            	<option value="1000">0 to 1000</option> 
				<option value="2000">1001 to 2000</option>
				<option value="5000">2001 to 5000</option>
				<option value="10000">5001 to 10,000</option>
				<option value="50000">10,001 to 50,000</option>
				<option value="100000">50,001 to 100,000</option>
				<option value="100000">100,001 to 1000,000</option>
				<option value="100000+">More Than 1000,000</option>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Job Profile</label>			
			 <select  name="job_profile" id="job_profile" class="form-control" required>
           <option value="">-Consumer Job Profile-</option>	
		   <option value="<?php echo $get_user_details[0]['job_profile'];?>" selected><?php echo $get_user_details[0]['job_profile'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('job_profile') as $val){?>
				<option value="<?php echo $val['job_profile'];?>"><?php  echo $val['job_profile'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Education Qualification </label>			
			 <select  name="education_qualification" id="education_qualification" class="form-control" required>
           <option value="">-Consumer Education Qualification-</option>	 
			<option value="<?php echo $get_user_details[0]['education_qualification'];?>" selected><?php echo $get_user_details[0]['education_qualification'];?></option>
				<option value="all">All</option>
            <?php foreach(getConsumerData('education_qualification') as $val){?>
				<option value="<?php echo $val['education_qualification'];?>"><?php  echo $val['education_qualification'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Type Vehicle </label>			
			 <select  name="type_vehicle" id="type_vehicle" class="form-control" required>
           <option value="">-Consumer Type Vehicle-</option>
			<option value="<?php echo $get_user_details[0]['type_vehicle'];?>" selected><?php echo $get_user_details[0]['type_vehicle'];?></option>	
				<option value="all">All</option>
            <?php foreach(getConsumerData('type_vehicle') as $val){?>
				<option value="<?php echo $val['type_vehicle'];?>"><?php  echo $val['type_vehicle'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Profession</label>			
			 <select  name="profession" id="profession" class="form-control" required>
           <option value="">-Consumer Profession-</option>	
			<option value="<?php echo $get_user_details[0]['profession'];?>" selected><?php echo $get_user_details[0]['profession'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('profession') as $val){?>
				<option value="<?php echo $val['profession'];?>"><?php  echo $val['profession'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Marital Status</label>			
			 <select  name="marital_status" id="marital_status" class="form-control" required>
           <option value="">-Consumer Marital Status-</option>	
			<option value="<?php echo $get_user_details[0]['marital_status'];?>" selected><?php echo $get_user_details[0]['marital_status'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('marital_status') as $val){?>
				<option value="<?php echo $val['marital_status'];?>"><?php  echo $val['marital_status'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Number of Family Members </label>			
			 <select  name="no_of_family_members" id="no_of_family_members" class="form-control" required>
           <option value="">-Number of Family Members-</option>	
			<option value="<?php echo $get_user_details[0]['no_of_family_members'];?>" selected><?php echo $get_user_details[0]['no_of_family_members'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('no_of_family_members') as $val){?>
				<option value="<?php echo $val['no_of_family_members'];?>"><?php  echo $val['no_of_family_members'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Loan Car</label>			
			 <select  name="loan_car" id="loan_car" class="form-control" required>
           <option value="">-Consumer Loan Car-</option>	
			<option value="<?php echo $get_user_details[0]['loan_car'];?>" selected><?php echo $get_user_details[0]['loan_car'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('loan_car') as $val){?>
				<option value="<?php echo $val['loan_car'];?>"><?php  echo $val['loan_car'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Loan Housing </label>			
			 <select  name="loan_housing" id="loan_housing" class="form-control" required>
           <option value="">-Consumer Loan Housing-</option>	
			<option value="<?php echo $get_user_details[0]['loan_housing'];?>" selected><?php echo $get_user_details[0]['loan_housing'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('loan_housing') as $val){?>
				<option value="<?php echo $val['loan_housing'];?>"><?php  echo $val['loan_housing'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Personal Loan</label>			
			 <select  name="personal_loan" id="personal_loan" class="form-control" required>
           <option value="">-Consumer Personal Loan-</option>	
			<option value="<?php echo $get_user_details[0]['personal_loan'];?>" selected><?php echo $get_user_details[0]['personal_loan'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('personal_loan') as $val){?>
				<option value="<?php echo $val['personal_loan'];?>"><?php  echo $val['personal_loan'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Credit Card Loan </label>			
			 <select  name="credit_card_loan" id="credit_card_loan" class="form-control" required>
           <option value="">-Consumer Credit Card Loan -</option>	
			<option value="<?php echo $get_user_details[0]['credit_card_loan'];?>" selected><?php echo $get_user_details[0]['credit_card_loan'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('credit_card_loan') as $val){?>
				<option value="<?php echo $val['credit_card_loan'];?>"><?php  echo $val['credit_card_loan'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Own a Car </label>			
			 <select  name="own_a_car" id="own_a_car" class="form-control" required>
           <option value="">-Consumer Own a Car-</option>
			<option value="<?php echo $get_user_details[0]['own_a_car'];?>" selected><?php echo $get_user_details[0]['own_a_car'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('own_a_car') as $val){?>
				<option value="<?php echo $val['own_a_car'];?>"><?php  echo $val['own_a_car'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer House Type</label>			
			 <select  name="house_type" id="house_type" class="form-control" required>
           <option value="">-Consumer House Type-</option>	
			<option value="<?php echo $get_user_details[0]['house_type'];?>" selected><?php echo $get_user_details[0]['house_type'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('house_type') as $val){?>
				<option value="<?php echo $val['house_type'];?>"><?php  echo $val['house_type'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Last Location</label>			
			 <select  name="last_location" id="last_location" class="form-control" required>
           <option value="">-Consumer Last Location-</option>	
			<option value="<?php echo $get_user_details[0]['last_location'];?>" selected><?php echo $get_user_details[0]['last_location'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('last_location') as $val){?>
				<option value="<?php echo $val['last_location'];?>"><?php  echo $val['last_location'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Life Insurance  </label>			
			 <select  name="life_insurance" id="life_insurance" class="form-control" required>
           <option value="">-Consumer Life Insurance-</option>	
			<option value="<?php echo $get_user_details[0]['life_insurance'];?>" selected><?php echo $get_user_details[0]['life_insurance'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('life_insurance') as $val){?>
				<option value="<?php echo $val['life_insurance'];?>"><?php  echo $val['life_insurance'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Medical Insurance </label>			
			 <select  name="medical_insurance" id="medical_insurance" class="form-control" required>
           <option value="">-Consumer Medical Insurance-</option>	
			<option value="<?php echo $get_user_details[0]['medical_insurance'];?>" selected><?php echo $get_user_details[0]['medical_insurance'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('medical_insurance') as $val){?>
				<option value="<?php echo $val['medical_insurance'];?>"><?php  echo $val['medical_insurance'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Height in inches </label>			
			 <select  name="height_in_inches" id="height_in_inches" class="form-control" required>
           <option value="">-Consumer Height in inches-</option>
			<option value="<?php echo $get_user_details[0]['height_in_inches'];?>" selected><?php echo $get_user_details[0]['height_in_inches'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('height_in_inches') as $val){?>
				<option value="<?php echo $val['height_in_inches'];?>"><?php  echo $val['height_in_inches'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Weight in Kg  </label>			
			 <select  name="weight_in_kg" id="weight_in_kg" class="form-control" required>
           <option value="">-Consumer Weight in Kg -</option>	
			<option value="<?php echo $get_user_details[0]['weight_in_kg'];?>" selected><?php echo $get_user_details[0]['weight_in_kg'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('weight_in_kg') as $val){?>
				<option value="<?php echo $val['weight_in_kg'];?>"><?php  echo $val['weight_in_kg'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Hobbies </label>			
			 <select  name="hobbies" id="hobbies" class="form-control" required>
           <option value="">-Consumer Hobbies-</option>	 
			<option value="<?php echo $get_user_details[0]['hobbies'];?>" selected><?php echo $get_user_details[0]['hobbies'];?></option>
			<option value="all">All</option>
		   <?php foreach(getConsumerData('hobbies') as $val){?>
				<option value="<?php echo $val['hobbies'];?>"><?php  echo $val['hobbies'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Sports </label>			
			 <select  name="sports" id="sports" class="form-control" required>
           <option value="">-Consumer Sports-</option>	  
			<option value="<?php echo $get_user_details[0]['sports'];?>" selected><?php echo $get_user_details[0]['sports'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('sports') as $val){?>
				<option value="<?php echo $val['sports'];?>"><?php  echo $val['sports'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Entertainment  </label>			
			 <select  name="entertainment" id="entertainment" class="form-control" required>
           <option value="">-Consumer Entertainment-</option>	
			<option value="<?php echo $get_user_details[0]['entertainment'];?>" selected><?php echo $get_user_details[0]['entertainment'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('entertainment') as $val){?>
				<option value="<?php echo $val['entertainment'];?>"><?php  echo $val['entertainment'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Gender</label>			
			 <select  name="spouse_gender" id="spouse_gender" class="form-control" required>
           <option value="">-Spouse Gender-</option>	
			<option value="<?php echo $get_user_details[0]['spouse_gender'];?>" selected><?php echo $get_user_details[0]['spouse_gender'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_gender') as $val){?>
				<option value="<?php echo $val['spouse_gender'];?>"><?php  echo $val['spouse_gender'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Phone </label>			
			 <select  name="spouse_phone" id="spouse_phone" class="form-control" required>
           <option value="">-Spouse Phone-</option>	 
			<option value="<?php echo $get_user_details[0]['spouse_phone'];?>" selected><?php echo $get_user_details[0]['spouse_phone'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_phone') as $val){?>
				<option value="<?php echo $val['spouse_phone'];?>"><?php  echo $val['spouse_phone'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse dob </label>			
			 <select  name="spouse_dob" id="spouse_dob" class="form-control" required>
           <option value="">-Spouse dob-</option>	 
			<option value="<?php echo $get_user_details[0]['spouse_dob'];?>" selected><?php echo $get_user_details[0]['spouse_dob'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_dob') as $val){?>
				<option value="<?php echo $val['spouse_dob'];?>"><?php  echo $val['spouse_dob'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Marriage Anniversary</label>			
			 <select  name="marriage_anniversary" id="marriage_anniversary" class="form-control" required>
           <option value="">-Marriage Anniversary-</option>	  
			<option value="<?php echo $get_user_details[0]['marriage_anniversary'];?>" selected><?php echo $get_user_details[0]['marriage_anniversary'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('marriage_anniversary') as $val){?>
				<option value="<?php echo $val['marriage_anniversary'];?>"><?php  echo $val['marriage_anniversary'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Work Status </label>			
			 <select  name="spouse_work_status" id="spouse_work_status" class="form-control" required>
           <option value="">-Spouse Work Status-</option>	
			<option value="<?php echo $get_user_details[0]['spouse_work_status'];?>" selected><?php echo $get_user_details[0]['spouse_work_status'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_work_status') as $val){?>
				<option value="<?php echo $val['spouse_work_status'];?>"><?php  echo $val['spouse_work_status'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Education Qualification </label>			
			 <select  name="spouse_edu_qualification" id="spouse_edu_qualification" class="form-control" required>
           <option value="">-Spouse Education Qualification-</option>	
			<option value="<?php echo $get_user_details[0]['spouse_edu_qualification'];?>" selected><?php echo $get_user_details[0]['spouse_edu_qualification'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_edu_qualification') as $val){?>
				<option value="<?php echo $val['spouse_edu_qualification'];?>"><?php  echo $val['spouse_edu_qualification'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Monthly Income </label>			
			 <select  name="spouse_monthly_income" id="spouse_monthly_income" class="form-control" required>
           <option value="">-Spouse Monthly Income-</option>
			<option value="<?php echo $get_user_details[0]['spouse_monthly_income'];?>" selected><?php echo $get_user_details[0]['spouse_monthly_income'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_monthly_income') as $val){?>
				<option value="<?php echo $val['spouse_monthly_income'];?>"><?php  echo $val['spouse_monthly_income'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Loan</label>			
			 <select  name="spouse_loan" id="spouse_loan" class="form-control" required>
           <option value="">-Spouse Loan-</option>
			<option value="<?php echo $get_user_details[0]['spouse_loan'];?>" selected><?php echo $get_user_details[0]['spouse_loan'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_loan') as $val){?>
				<option value="<?php echo $val['spouse_loan'];?>"><?php  echo $val['spouse_loan'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Personal Loan</label>			
			 <select  name="spouse_personal_loan" id="spouse_personal_loan" class="form-control" required>
           <option value="">-Spouse Personal Loan-</option>	 
			<option value="<?php echo $get_user_details[0]['spouse_personal_loan'];?>" selected><?php echo $get_user_details[0]['spouse_personal_loan'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_personal_loan') as $val){?>
				<option value="<?php echo $val['spouse_personal_loan'];?>"><?php  echo $val['spouse_personal_loan'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Credit Card Loan </label>			
			 <select  name="spouse_credit_card_loan" id="spouse_credit_card_loan" class="form-control" required>
           <option value="">-Spouse Credit Card Loan-</option>	 
			<option value="<?php echo $get_user_details[0]['spouse_credit_card_loan'];?>" selected><?php echo $get_user_details[0]['spouse_credit_card_loan'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_credit_card_loan') as $val){?>
				<option value="<?php echo $val['spouse_credit_card_loan'];?>"><?php  echo $val['spouse_credit_card_loan'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Own a Car </label>			
			 <select  name="spouse_own_a_car" id="spouse_own_a_car" class="form-control" required>
           <option value="">-Spouse Own a Car-</option>	   
			<option value="<?php echo $get_user_details[0]['spouse_own_a_car'];?>" selected><?php echo $get_user_details[0]['spouse_own_a_car'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_own_a_car') as $val){?>
				<option value="<?php echo $val['spouse_own_a_car'];?>"><?php  echo $val['spouse_own_a_car'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
				<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse House Type </label>			
			 <select  name="spouse_house_type" id="spouse_house_type" class="form-control" required>
           <option value="">-Spouse House Type-</option>	
			<option value="<?php echo $get_user_details[0]['spouse_house_type'];?>" selected><?php echo $get_user_details[0]['spouse_house_type'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_house_type') as $val){?>
				<option value="<?php echo $val['spouse_house_type'];?>"><?php  echo $val['spouse_house_type'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Height Inches </label>			
			 <select  name="spouse_height_inches" id="spouse_height_inches" class="form-control" required>
           <option value="">-Spouse Height Inches-</option>	  
			<option value="<?php echo $get_user_details[0]['spouse_height_inches'];?>" selected><?php echo $get_user_details[0]['spouse_height_inches'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_height_inches') as $val){?>
				<option value="<?php echo $val['spouse_height_inches'];?>"><?php  echo $val['spouse_height_inches'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Weight Kg</label>			
			 <select  name="spouse_weight_kg" id="spouse_weight_kg" class="form-control" required>
           <option value="">-Spouse Weight Kg-</option>	  
			<option value="<?php echo $get_user_details[0]['spouse_weight_kg'];?>" selected><?php echo $get_user_details[0]['spouse_weight_kg'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_weight_kg') as $val){?>
				<option value="<?php echo $val['spouse_weight_kg'];?>"><?php  echo $val['spouse_weight_kg'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Hobbies </label>			
			 <select  name="spouse_hobbies" id="spouse_hobbies" class="form-control" required>
           <option value="">-Spouse Hobbies-</option>	  
			<option value="<?php echo $get_user_details[0]['spouse_hobbies'];?>" selected><?php echo $get_user_details[0]['spouse_hobbies'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_hobbies') as $val){?>
				<option value="<?php echo $val['spouse_hobbies'];?>"><?php  echo $val['spouse_hobbies'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Sports</label>			
			 <select  name="spouse_sports" id="spouse_sports" class="form-control" required>
           <option value="">-Spouse Sports-</option>	
			<option value="<?php echo $get_user_details[0]['spouse_sports'];?>" selected><?php echo $get_user_details[0]['spouse_sports'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_sports') as $val){?>
				<option value="<?php echo $val['spouse_sports'];?>"><?php  echo $val['spouse_sports'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8">Spouse Entertainment</label>			
			 <select  name="spouse_entertainment" id="spouse_entertainment" class="form-control" required>
           <option value="">-Spouse Entertainment-</option>	  
			<option value="<?php echo $get_user_details[0]['spouse_entertainment'];?>" selected><?php echo $get_user_details[0]['spouse_entertainment'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('spouse_entertainment') as $val){?>
				<option value="<?php echo $val['spouse_entertainment'];?>"><?php  echo $val['spouse_entertainment'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_1'); ?></label>			
			 <select  name="field_1" id="field_1" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_1'); ?>-</option>	  
			<option value="<?php echo $get_user_details[0]['field_1'];?>" selected><?php echo $get_user_details[0]['field_1'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_1') as $val){?>
				<option value="<?php echo $val['field_1'];?>"><?php  echo $val['field_1'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_2'); ?></label>			
			 <select  name="field_2" id="field_2" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_2'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_2'];?>" selected><?php echo $get_user_details[0]['field_2'];?></option><option value="all">All</option>		   
            <?php foreach(getConsumerData('field_2') as $val){?>
				<option value="<?php echo $val['field_2'];?>"><?php  echo $val['field_2'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_3'); ?></label>			
			 <select  name="field_3" id="field_3" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_3'); ?>-</option>	   
			<option value="<?php echo $get_user_details[0]['field_3'];?>" selected><?php echo $get_user_details[0]['field_3'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_3') as $val){?>
				<option value="<?php echo $val['field_3'];?>"><?php  echo $val['field_3'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_4'); ?> </label>			
			 <select  name="field_4" id="field_4" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_4'); ?>-</option>	   
			<option value="<?php echo $get_user_details[0]['field_4'];?>" selected><?php echo $get_user_details[0]['field_4'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_4') as $val){?>
				<option value="<?php echo $val['field_4'];?>"><?php  echo $val['field_4'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_5'); ?></label>			
			 <select  name="field_5" id="field_5" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_5'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_5'];?>" selected><?php echo $get_user_details[0]['field_5'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_5') as $val){?>
				<option value="<?php echo $val['field_5'];?>"><?php  echo $val['field_5'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_6'); ?></label>			
			 <select  name="field_6" id="field_6" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_6'); ?>-</option>	   
			<option value="<?php echo $get_user_details[0]['field_6'];?>" selected><?php echo $get_user_details[0]['field_6'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_6') as $val){?>
				<option value="<?php echo $val['field_6'];?>"><?php  echo $val['field_6'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_7'); ?> </label>			
			 <select  name="field_7" id="field_7" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_7'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_7'];?>" selected><?php echo $get_user_details[0]['field_7'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_7') as $val){?>
				<option value="<?php echo $val['field_7'];?>"><?php  echo $val['field_7'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_8'); ?></label>			
			 <select  name="field_8" id="field_8" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_8'); ?>-</option>	  
			<option value="<?php echo $get_user_details[0]['field_8'];?>" selected><?php echo $get_user_details[0]['field_8'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_8') as $val){?>
				<option value="<?php echo $val['field_8'];?>"><?php  echo $val['field_8'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_9'); ?></label>			
			 <select  name="field_9" id="field_9" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_9'); ?>-</option>	   
			<option value="<?php echo $get_user_details[0]['field_9'];?>" selected><?php echo $get_user_details[0]['field_9'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_9') as $val){?>
				<option value="<?php echo $val['field_9'];?>"><?php  echo $val['field_9'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_10'); ?> </label>			
			 <select  name="field_10" id="field_10" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_10'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_10'];?>" selected><?php echo $get_user_details[0]['field_10'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_10') as $val){?>
				<option value="<?php echo $val['field_10'];?>"><?php  echo $val['field_10'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_11'); ?></label>			
			 <select  name="field_11" id="field_11" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_11'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_11'];?>" selected><?php echo $get_user_details[0]['field_11'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_11') as $val){?>
				<option value="<?php echo $val['field_11'];?>"><?php  echo $val['field_11'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_12'); ?></label>			
			 <select  name="field_12" id="field_12" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_12'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_12'];?>" selected><?php echo $get_user_details[0]['field_12'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_12') as $val){?>
				<option value="<?php echo $val['field_12'];?>"><?php  echo $val['field_12'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_13'); ?> </label>			
			 <select  name="field_13" id="field_13" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_13'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_13'];?>" selected><?php echo $get_user_details[0]['field_13'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_13') as $val){?>
				<option value="<?php echo $val['field_13'];?>"><?php  echo $val['field_13'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_14'); ?></label>			
			 <select  name="field_14" id="field_14" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_14'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_14'];?>" selected><?php echo $get_user_details[0]['field_14'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_14') as $val){?>
				<option value="<?php echo $val['field_14'];?>"><?php  echo $val['field_14'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_15'); ?></label>			
			 <select  name="field_15" id="field_15" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_15'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_15'];?>" selected><?php echo $get_user_details[0]['field_15'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_15') as $val){?>
				<option value="<?php echo $val['field_15'];?>"><?php  echo $val['field_15'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_16'); ?> </label>			
			 <select  name="field_16" id="field_16" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_16'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_16'];?>" selected><?php echo $get_user_details[0]['field_16'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_16') as $val){?>
				<option value="<?php echo $val['field_16'];?>"><?php  echo $val['field_16'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_17'); ?></label>			
			 <select  name="field_17" id="field_17" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_17'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_17'];?>" selected><?php echo $get_user_details[0]['field_17'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_17') as $val){?>
				<option value="<?php echo $val['field_17'];?>"><?php  echo $val['field_17'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_18'); ?></label>			
			 <select  name="field_18" id="field_18" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_18'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_18'];?>" selected><?php echo $get_user_details[0]['field_18'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_18') as $val){?>
				<option value="<?php echo $val['field_18'];?>"><?php  echo $val['field_18'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_19'); ?> </label>			
			 <select  name="field_19" id="field_19" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_19'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_19'];?>" selected><?php echo $get_user_details[0]['field_19'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_19') as $val){?>
				<option value="<?php echo $val['field_19'];?>"><?php  echo $val['field_19'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_20'); ?></label>			
			 <select  name="field_20" id="field_20" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_20'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_20'];?>" selected><?php echo $get_user_details[0]['field_20'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_20') as $val){?>
				<option value="<?php echo $val['field_20'];?>"><?php  echo $val['field_20'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_21'); ?></label>			
			 <select  name="field_21" id="field_21" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_21'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_21'];?>" selected><?php echo $get_user_details[0]['field_21'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_21') as $val){?>
				<option value="<?php echo $val['field_21'];?>"><?php  echo $val['field_21'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_22'); ?> </label>			
			 <select  name="field_22" id="field_22" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_22'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_22'];?>" selected><?php echo $get_user_details[0]['field_22'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_22') as $val){?>
				<option value="<?php echo $val['field_22'];?>"><?php  echo $val['field_22'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_23'); ?></label>			
			 <select  name="field_23" id="field_23" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_23'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_23'];?>" selected><?php echo $get_user_details[0]['field_23'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_23') as $val){?>
				<option value="<?php echo $val['field_23'];?>"><?php  echo $val['field_23'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_24'); ?></label>			
			 <select  name="field_24" id="field_24" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_24'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_24'];?>" selected><?php echo $get_user_details[0]['field_24'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_24') as $val){?>
				<option value="<?php echo $val['field_24'];?>"><?php  echo $val['field_24'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_25'); ?> </label>			
			 <select  name="field_25" id="field_25" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_25'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_25'];?>" selected><?php echo $get_user_details[0]['field_25'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_25') as $val){?>
				<option value="<?php echo $val['field_25'];?>"><?php  echo $val['field_25'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_26'); ?></label>			
			 <select  name="field_26" id="field_26" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_26'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_26'];?>" selected><?php echo $get_user_details[0]['field_26'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_26') as $val){?>
				<option value="<?php echo $val['field_26'];?>"><?php  echo $val['field_26'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_27'); ?></label>			
			 <select  name="field_27" id="field_27" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_27'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_27'];?>" selected><?php echo $get_user_details[0]['field_27'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_27') as $val){?>
				<option value="<?php echo $val['field_27'];?>"><?php  echo $val['field_27'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_28'); ?> </label>			
			 <select  name="field_28" id="field_28" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_28'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_28'];?>" selected><?php echo $get_user_details[0]['field_28'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_28') as $val){?>
				<option value="<?php echo $val['field_28'];?>"><?php  echo $val['field_28'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_29'); ?></label>			
			 <select  name="field_29" id="field_29" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_29'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_29'];?>" selected><?php echo $get_user_details[0]['field_29'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_29') as $val){?>
				<option value="<?php echo $val['field_29'];?>"><?php  echo $val['field_29'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_30'); ?></label>			
			 <select  name="field_30" id="field_30" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_30'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_30'];?>" selected><?php echo $get_user_details[0]['field_30'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_30') as $val){?>
				<option value="<?php echo $val['field_30'];?>"><?php  echo $val['field_30'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_31'); ?> </label>			
			 <select  name="field_31" id="field_31" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_31'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_31'];?>" selected><?php echo $get_user_details[0]['field_31'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_31') as $val){?>
				<option value="<?php echo $val['field_31'];?>"><?php  echo $val['field_31'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_32'); ?></label>			
			 <select  name="field_32" id="field_32" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_32'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_32'];?>" selected><?php echo $get_user_details[0]['field_32'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_32') as $val){?>
				<option value="<?php echo $val['field_32'];?>"><?php  echo $val['field_32'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_33'); ?></label>			
			 <select  name="field_33" id="field_33" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_33'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_33'];?>" selected><?php echo $get_user_details[0]['field_33'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_33') as $val){?>
				<option value="<?php echo $val['field_33'];?>"><?php  echo $val['field_33'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_34'); ?> </label>			
			 <select  name="field_34" id="field_34" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_34'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_34'];?>" selected><?php echo $get_user_details[0]['field_34'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_34') as $val){?>
				<option value="<?php echo $val['field_34'];?>"><?php  echo $val['field_34'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_35'); ?></label>			
			 <select  name="field_35" id="field_35" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_35'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_35'];?>" selected><?php echo $get_user_details[0]['field_35'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_35') as $val){?>
				<option value="<?php echo $val['field_35'];?>"><?php  echo $val['field_35'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_36'); ?></label>			
			 <select  name="field_36" id="field_36" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_36'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_36'];?>" selected><?php echo $get_user_details[0]['field_36'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_36') as $val){?>
				<option value="<?php echo $val['field_36'];?>"><?php  echo $val['field_36'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_37'); ?> </label>			
			 <select  name="field_37" id="field_37" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_37'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_37'];?>" selected><?php echo $get_user_details[0]['field_37'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_37') as $val){?>
				<option value="<?php echo $val['field_37'];?>"><?php  echo $val['field_37'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_38'); ?></label>			
			 <select  name="field_38" id="field_38" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_38'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_38'];?>" selected><?php echo $get_user_details[0]['field_38'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_38') as $val){?>
				<option value="<?php echo $val['field_38'];?>"><?php  echo $val['field_38'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_39'); ?></label>			
			 <select  name="field_39" id="field_39" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_39'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_39'];?>" selected><?php echo $get_user_details[0]['field_39'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_39') as $val){?>
				<option value="<?php echo $val['field_39'];?>"><?php  echo $val['field_39'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_40'); ?> </label>			
			 <select  name="field_40" id="field_40" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_40'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_40'];?>" selected><?php echo $get_user_details[0]['field_40'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_40') as $val){?>
				<option value="<?php echo $val['field_40'];?>"><?php  echo $val['field_40'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_41'); ?></label>			
			 <select  name="field_41" id="field_41" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_41'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_41'];?>" selected><?php echo $get_user_details[0]['field_41'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_41') as $val){?>
				<option value="<?php echo $val['field_41'];?>"><?php  echo $val['field_41'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_42'); ?></label>			
			 <select  name="field_42" id="field_42" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_42'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_42'];?>" selected><?php echo $get_user_details[0]['field_42'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_42') as $val){?>
				<option value="<?php echo $val['field_42'];?>"><?php  echo $val['field_42'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_43'); ?> </label>			
			 <select  name="field_43" id="field_43" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_43'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_43'];?>" selected><?php echo $get_user_details[0]['field_43'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_43') as $val){?>
				<option value="<?php echo $val['field_43'];?>"><?php  echo $val['field_43'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_44'); ?></label>			
			 <select  name="field_44" id="field_44" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_44'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_44'];?>" selected><?php echo $get_user_details[0]['field_44'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_44') as $val){?>
				<option value="<?php echo $val['field_44'];?>"><?php  echo $val['field_44'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_45'); ?></label>			
			 <select  name="field_45" id="field_45" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_45'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_45'];?>" selected><?php echo $get_user_details[0]['field_45'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_45') as $val){?>
				<option value="<?php echo $val['field_45'];?>"><?php  echo $val['field_45'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_46'); ?> </label>			
			 <select  name="field_46" id="field_46" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_46'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_46'];?>" selected><?php echo $get_user_details[0]['field_46'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_46') as $val){?>
				<option value="<?php echo $val['field_46'];?>"><?php  echo $val['field_46'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_47'); ?></label>			
			 <select  name="field_47" id="field_47" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_47'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_47'];?>" selected><?php echo $get_user_details[0]['field_47'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_47') as $val){?>
				<option value="<?php echo $val['field_47'];?>"><?php  echo $val['field_47'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_48'); ?></label>			
			 <select  name="field_48" id="field_48" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_48'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_48'];?>" selected><?php echo $get_user_details[0]['field_48'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_48') as $val){?>
				<option value="<?php echo $val['field_48'];?>"><?php  echo $val['field_48'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_49'); ?> </label>			
			 <select  name="field_49" id="field_49" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_49'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_49'];?>" selected><?php echo $get_user_details[0]['field_49'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_49') as $val){?>
				<option value="<?php echo $val['field_49'];?>"><?php  echo $val['field_49'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_50'); ?></label>			
			 <select  name="field_50" id="field_50" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_50'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_50'];?>" selected><?php echo $get_user_details[0]['field_50'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_50') as $val){?>
				<option value="<?php echo $val['field_50'];?>"><?php  echo $val['field_50'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_51'); ?></label>			
			 <select  name="field_51" id="field_51" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_51'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_51'];?>" selected><?php echo $get_user_details[0]['field_51'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_51') as $val){?>
				<option value="<?php echo $val['field_51'];?>"><?php  echo $val['field_51'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_52'); ?> </label>			
			 <select  name="field_52" id="field_52" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_52'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_52'];?>" selected><?php echo $get_user_details[0]['field_52'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_52') as $val){?>
				<option value="<?php echo $val['field_52'];?>"><?php  echo $val['field_52'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_53'); ?></label>			
			 <select  name="field_53" id="field_53" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_53'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_53'];?>" selected><?php echo $get_user_details[0]['field_53'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_53') as $val){?>
				<option value="<?php echo $val['field_53'];?>"><?php  echo $val['field_53'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_54'); ?></label>			
			 <select  name="field_54" id="field_54" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_54'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_54'];?>" selected><?php echo $get_user_details[0]['field_54'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_54') as $val){?>
				<option value="<?php echo $val['field_54'];?>"><?php  echo $val['field_54'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_55'); ?> </label>			
			 <select  name="field_55" id="field_55" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_55'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_55'];?>" selected><?php echo $get_user_details[0]['field_55'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_55') as $val){?>
				<option value="<?php echo $val['field_55'];?>"><?php  echo $val['field_55'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_56'); ?></label>			
			 <select  name="field_56" id="field_56" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_56'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_56'];?>" selected><?php echo $get_user_details[0]['field_56'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_56') as $val){?>
				<option value="<?php echo $val['field_56'];?>"><?php  echo $val['field_56'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_57'); ?></label>			
			 <select  name="field_57" id="field_57" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_57'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_57'];?>" selected><?php echo $get_user_details[0]['field_57'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_57') as $val){?>
				<option value="<?php echo $val['field_57'];?>"><?php  echo $val['field_57'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_58'); ?> </label>			
			 <select  name="field_58" id="field_58" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_58'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_58'];?>" selected><?php echo $get_user_details[0]['field_58'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_58') as $val){?>
				<option value="<?php echo $val['field_58'];?>"><?php  echo $val['field_58'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_59'); ?></label>			
			 <select  name="field_59" id="field_59" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_59'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_59'];?>" selected><?php echo $get_user_details[0]['field_59'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_59') as $val){?>
				<option value="<?php echo $val['field_59'];?>"><?php  echo $val['field_59'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_60'); ?></label>			
			 <select  name="field_60" id="field_60" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_60'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_60'];?>" selected><?php echo $get_user_details[0]['field_60'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_60') as $val){?>
				<option value="<?php echo $val['field_60'];?>"><?php  echo $val['field_60'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_61'); ?> </label>			
			 <select  name="field_61" id="field_61" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_61'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_61'];?>" selected><?php echo $get_user_details[0]['field_61'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_61') as $val){?>
				<option value="<?php echo $val['field_61'];?>"><?php  echo $val['field_61'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_62'); ?></label>			
			 <select  name="field_62" id="field_62" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_62'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_62'];?>" selected><?php echo $get_user_details[0]['field_62'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_62') as $val){?>
				<option value="<?php echo $val['field_62'];?>"><?php  echo $val['field_62'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_63'); ?></label>			
			 <select  name="field_63" id="field_63" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_63'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_63'];?>" selected><?php echo $get_user_details[0]['field_63'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_63') as $val){?>
				<option value="<?php echo $val['field_63'];?>"><?php  echo $val['field_63'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_64'); ?> </label>			
			 <select  name="field_64" id="field_64" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_64'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_64'];?>" selected><?php echo $get_user_details[0]['field_64'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_64') as $val){?>
				<option value="<?php echo $val['field_64'];?>"><?php  echo $val['field_64'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_65'); ?></label>			
			 <select  name="field_65" id="field_65" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_65'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_65'];?>" selected><?php echo $get_user_details[0]['field_65'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_65') as $val){?>
				<option value="<?php echo $val['field_65'];?>"><?php  echo $val['field_65'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_66'); ?></label>			
			 <select  name="field_66" id="field_66" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_66'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_66'];?>" selected><?php echo $get_user_details[0]['field_66'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_66') as $val){?>
				<option value="<?php echo $val['field_66'];?>"><?php  echo $val['field_66'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_67'); ?> </label>			
			 <select  name="field_67" id="field_67" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_67'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_67'];?>" selected><?php echo $get_user_details[0]['field_67'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_67') as $val){?>
				<option value="<?php echo $val['field_67'];?>"><?php  echo $val['field_67'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_68'); ?></label>			
			 <select  name="field_68" id="field_68" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_68'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_68'];?>" selected><?php echo $get_user_details[0]['field_68'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_68') as $val){?>
				<option value="<?php echo $val['field_68'];?>"><?php  echo $val['field_68'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_69'); ?></label>			
			 <select  name="field_69" id="field_69" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_69'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_69'];?>" selected><?php echo $get_user_details[0]['field_69'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_69') as $val){?>
				<option value="<?php echo $val['field_69'];?>"><?php  echo $val['field_69'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_70'); ?> </label>			
			 <select  name="field_70" id="field_70" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_70'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_70'];?>" selected><?php echo $get_user_details[0]['field_70'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_70') as $val){?>
				<option value="<?php echo $val['field_70'];?>"><?php  echo $val['field_70'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_71'); ?></label>			
			 <select  name="field_71" id="field_71" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_71'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_71'];?>" selected><?php echo $get_user_details[0]['field_71'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_71') as $val){?>
				<option value="<?php echo $val['field_71'];?>"><?php  echo $val['field_71'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_72'); ?></label>			
			 <select  name="field_72" id="field_72" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_72'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_72'];?>" selected><?php echo $get_user_details[0]['field_72'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_72') as $val){?>
				<option value="<?php echo $val['field_72'];?>"><?php  echo $val['field_72'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_73'); ?> </label>			
			 <select  name="field_73" id="field_73" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_73'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_73'];?>" selected><?php echo $get_user_details[0]['field_73'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_73') as $val){?>
				<option value="<?php echo $val['field_73'];?>"><?php  echo $val['field_73'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_74'); ?></label>			
			 <select  name="field_74" id="field_74" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_74'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_74'];?>" selected><?php echo $get_user_details[0]['field_74'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_74') as $val){?>
				<option value="<?php echo $val['field_74'];?>"><?php  echo $val['field_74'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_75'); ?></label>			
			 <select  name="field_75" id="field_75" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_75'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_75'];?>" selected><?php echo $get_user_details[0]['field_75'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_75') as $val){?>
				<option value="<?php echo $val['field_75'];?>"><?php  echo $val['field_75'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_76'); ?> </label>			
			 <select  name="field_76" id="field_76" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_76'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_76'];?>" selected><?php echo $get_user_details[0]['field_76'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_76') as $val){?>
				<option value="<?php echo $val['field_76'];?>"><?php  echo $val['field_76'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_77'); ?></label>			
			 <select  name="field_77" id="field_77" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_77'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_77'];?>" selected><?php echo $get_user_details[0]['field_77'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_77') as $val){?>
				<option value="<?php echo $val['field_77'];?>"><?php  echo $val['field_77'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_78'); ?></label>			
			 <select  name="field_78" id="field_78" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_78'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_78'];?>" selected><?php echo $get_user_details[0]['field_78'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_78') as $val){?>
				<option value="<?php echo $val['field_78'];?>"><?php  echo $val['field_78'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_79'); ?> </label>			
			 <select  name="field_79" id="field_79" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_79'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_79'];?>" selected><?php echo $get_user_details[0]['field_79'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_79') as $val){?>
				<option value="<?php echo $val['field_79'];?>"><?php  echo $val['field_79'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_80'); ?></label>			
			 <select  name="field_80" id="field_80" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_80'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_80'];?>" selected><?php echo $get_user_details[0]['field_80'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_80') as $val){?>
				<option value="<?php echo $val['field_80'];?>"><?php  echo $val['field_80'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_81'); ?></label>			
			 <select  name="field_81" id="field_81" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_81'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_81'];?>" selected><?php echo $get_user_details[0]['field_81'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_81') as $val){?>
				<option value="<?php echo $val['field_81'];?>"><?php  echo $val['field_81'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_82'); ?> </label>			
			 <select  name="field_82" id="field_82" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_82'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_82'];?>" selected><?php echo $get_user_details[0]['field_82'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_82') as $val){?>
				<option value="<?php echo $val['field_82'];?>"><?php  echo $val['field_82'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_83'); ?></label>			
			 <select  name="field_83" id="field_83" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_83'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_83'];?>" selected><?php echo $get_user_details[0]['field_83'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_83') as $val){?>
				<option value="<?php echo $val['field_83'];?>"><?php  echo $val['field_83'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_84'); ?></label>			
			 <select  name="field_84" id="field_84" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_84'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_84'];?>" selected><?php echo $get_user_details[0]['field_84'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_84') as $val){?>
				<option value="<?php echo $val['field_84'];?>"><?php  echo $val['field_84'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_85'); ?> </label>			
			 <select  name="field_85" id="field_85" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_85'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_85'];?>" selected><?php echo $get_user_details[0]['field_85'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_85') as $val){?>
				<option value="<?php echo $val['field_85'];?>"><?php  echo $val['field_85'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_86'); ?></label>			
			 <select  name="field_86" id="field_86" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_86'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_86'];?>" selected><?php echo $get_user_details[0]['field_86'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_86') as $val){?>
				<option value="<?php echo $val['field_86'];?>"><?php  echo $val['field_86'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_87'); ?></label>			
			 <select  name="field_87" id="field_87" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_87'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_87'];?>" selected><?php echo $get_user_details[0]['field_87'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_87') as $val){?>
				<option value="<?php echo $val['field_87'];?>"><?php  echo $val['field_87'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_88'); ?> </label>			
			 <select  name="field_88" id="field_88" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_88'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_88'];?>" selected><?php echo $get_user_details[0]['field_88'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_88') as $val){?>
				<option value="<?php echo $val['field_88'];?>"><?php  echo $val['field_88'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_89'); ?></label>			
			 <select  name="field_89" id="field_89" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_89'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_89'];?>" selected><?php echo $get_user_details[0]['field_89'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_89') as $val){?>
				<option value="<?php echo $val['field_89'];?>"><?php  echo $val['field_89'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_90'); ?></label>			
			 <select  name="field_90" id="field_90" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_90'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_90'];?>" selected><?php echo $get_user_details[0]['field_90'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_90') as $val){?>
				<option value="<?php echo $val['field_90'];?>"><?php  echo $val['field_90'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_91'); ?> </label>			
			 <select  name="field_91" id="field_91" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_91'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_91'];?>" selected><?php echo $get_user_details[0]['field_91'];?></option>
			<option value="all">All</option>
            <?php foreach(getConsumerData('field_91') as $val){?>
				<option value="<?php echo $val['field_91'];?>"><?php  echo $val['field_91'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_92'); ?></label>			
			 <select  name="field_92" id="field_92" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_92'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_92'];?>" selected><?php echo $get_user_details[0]['field_92'];?></option> <option value="all">All</option>		   
            <?php foreach(getConsumerData('field_92') as $val){?>
				<option value="<?php echo $val['field_92'];?>"><?php  echo $val['field_92'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_93'); ?></label>			
			 <select  name="field_93" id="field_93" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_93'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_93'];?>" selected><?php echo $get_user_details[0]['field_93'];?></option>
			 <option value="all">All</option>
            <?php foreach(getConsumerData('field_93') as $val){?>
				<option value="<?php echo $val['field_93'];?>"><?php  echo $val['field_93'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_94'); ?> </label>			
			 <select  name="field_94" id="field_94" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_94'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_94'];?>" selected><?php echo $get_user_details[0]['field_94'];?></option>
            <?php foreach(getConsumerData('field_94') as $val){?>
				<option value="<?php echo $val['field_94'];?>"><?php  echo $val['field_94'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_95'); ?></label>			
			 <select  name="field_95" id="field_95" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_95'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_95'];?>" selected><?php echo $get_user_details[0]['field_95'];?></option>
             <option value="all">All</option>
			 <?php foreach(getConsumerData('field_95') as $val){?>
				<option value="<?php echo $val['field_95'];?>"><?php  echo $val['field_95'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_96'); ?></label>			
			 <select  name="field_96" id="field_96" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_96'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_96'];?>" selected><?php echo $get_user_details[0]['field_96'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_96') as $val){?>
				<option value="<?php echo $val['field_96'];?>"><?php  echo $val['field_96'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_97'); ?> </label>			
			 <select  name="field_97" id="field_97" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_97'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_97'];?>" selected><?php echo $get_user_details[0]['field_97'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_97') as $val){?>
				<option value="<?php echo $val['field_97'];?>"><?php  echo $val['field_97'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_98'); ?></label>			
			 <select  name="field_98" id="field_98" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_98'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_98'];?>" selected><?php echo $get_user_details[0]['field_98'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_98') as $val){?>
				<option value="<?php echo $val['field_98'];?>"><?php  echo $val['field_98'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_99'); ?></label>			
			 <select  name="field_99" id="field_99" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_99'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_99'];?>" selected><?php echo $get_user_details[0]['field_99'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_99') as $val){?>
				<option value="<?php echo $val['field_99'];?>"><?php  echo $val['field_99'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_100'); ?> </label>			
			 <select  name="field_100" id="field_100" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_100'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_100'];?>" selected><?php echo $get_user_details[0]['field_100'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_100') as $val){?>
				<option value="<?php echo $val['field_100'];?>"><?php  echo $val['field_100'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_101'); ?></label>			
			 <select  name="field_101" id="field_101" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_101'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_101'];?>" selected><?php echo $get_user_details[0]['field_101'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_101') as $val){?>
				<option value="<?php echo $val['field_101'];?>"><?php  echo $val['field_101'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_102'); ?></label>			
			 <select  name="field_102" id="field_102" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_102'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_102'];?>" selected><?php echo $get_user_details[0]['field_102'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_102') as $val){?>
				<option value="<?php echo $val['field_102'];?>"><?php  echo $val['field_102'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_103'); ?> </label>			
			 <select  name="field_103" id="field_103" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_103'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_103'];?>" selected><?php echo $get_user_details[0]['field_103'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_103') as $val){?>
				<option value="<?php echo $val['field_103'];?>"><?php  echo $val['field_103'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_104'); ?></label>			
			 <select  name="field_104" id="field_104" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_104'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_104'];?>" selected><?php echo $get_user_details[0]['field_104'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_104') as $val){?>
				<option value="<?php echo $val['field_104'];?>"><?php  echo $val['field_104'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_105'); ?></label>			
			 <select  name="field_105" id="field_105" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_105'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_105'];?>" selected><?php echo $get_user_details[0]['field_105'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_105') as $val){?>
				<option value="<?php echo $val['field_105'];?>"><?php  echo $val['field_105'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_106'); ?> </label>			
			 <select  name="field_106" id="field_106" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_106'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_106'];?>" selected><?php echo $get_user_details[0]['field_106'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_106') as $val){?>
				<option value="<?php echo $val['field_106'];?>"><?php  echo $val['field_106'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_107'); ?></label>			
			 <select  name="field_107" id="field_107" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_107'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_107'];?>" selected><?php echo $get_user_details[0]['field_107'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_107') as $val){?>
				<option value="<?php echo $val['field_107'];?>"><?php  echo $val['field_107'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_108'); ?></label>			
			 <select  name="field_108" id="consumer_city" class="form-field_108" required>
           <option value="">-<?php echo getConsumerFieldName('field_108'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_108'];?>" selected><?php echo $get_user_details[0]['field_108'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_108') as $val){?>
				<option value="<?php echo $val['field_108'];?>"><?php  echo $val['field_108'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_109'); ?> </label>			
			 <select  name="field_109" id="field_109" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_109'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_109'];?>" selected><?php echo $get_user_details[0]['field_109'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_109') as $val){?>
				<option value="<?php echo $val['field_109'];?>"><?php  echo $val['field_109'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_110'); ?></label>			
			 <select  name="field_110" id="field_110" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_110'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_110'];?>" selected><?php echo $get_user_details[0]['field_110'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_110') as $val){?>
				<option value="<?php echo $val['field_110'];?>"><?php  echo $val['field_110'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_111'); ?></label>			
			 <select  name="field_111" id="field_111" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_111'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_111'];?>" selected><?php echo $get_user_details[0]['field_111'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_111') as $val){?>
				<option value="<?php echo $val['field_111'];?>"><?php  echo $val['field_111'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_112'); ?> </label>			
			 <select  name="field_112" id="field_112" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_112'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_112'];?>" selected><?php echo $get_user_details[0]['field_112'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_112') as $val){?>
				<option value="<?php echo $val['field_112'];?>"><?php  echo $val['field_112'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_113'); ?></label>			
			 <select  name="field_113" id="field_113" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_113'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_113'];?>" selected><?php echo $get_user_details[0]['field_113'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_113') as $val){?>
				<option value="<?php echo $val['field_113'];?>"><?php  echo $val['field_113'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_114'); ?></label>			
			 <select  name="field_114" id="field_114" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_114'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_114'];?>" selected><?php echo $get_user_details[0]['field_114'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_114') as $val){?>
				<option value="<?php echo $val['field_114'];?>"><?php  echo $val['field_114'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_115'); ?> </label>			
			 <select  name="field_115" id="field_115" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_115'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_115'];?>" selected><?php echo $get_user_details[0]['field_115'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_115') as $val){?>
				<option value="<?php echo $val['field_115'];?>"><?php  echo $val['field_115'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_116'); ?></label>			
			 <select  name="field_116" id="field_116" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_116'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_116'];?>" selected><?php echo $get_user_details[0]['field_116'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_116') as $val){?>
				<option value="<?php echo $val['field_116'];?>"><?php  echo $val['field_116'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_117'); ?></label>			
			 <select  name="field_117" id="field_117" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_117'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_117'];?>" selected><?php echo $get_user_details[0]['field_117'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_117') as $val){?>
				<option value="<?php echo $val['field_117'];?>"><?php  echo $val['field_117'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_118'); ?> </label>			
			 <select  name="field_118" id="field_118" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_118'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_118'];?>" selected><?php echo $get_user_details[0]['field_118'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_118') as $val){?>
				<option value="<?php echo $val['field_118'];?>"><?php  echo $val['field_118'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_119'); ?></label>			
			 <select  name="field_119" id="field_119" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_119'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_119'];?>" selected><?php echo $get_user_details[0]['field_119'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_119') as $val){?>
				<option value="<?php echo $val['field_119'];?>"><?php  echo $val['field_119'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_120'); ?></label>			
			 <select  name="field_120" id="field_120" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_120'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_120'];?>" selected><?php echo $get_user_details[0]['field_120'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_120') as $val){?>
				<option value="<?php echo $val['field_120'];?>"><?php  echo $val['field_120'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_121'); ?> </label>			
			 <select  name="field_121" id="field_121" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_121'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_121'];?>" selected><?php echo $get_user_details[0]['field_121'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_121') as $val){?>
				<option value="<?php echo $val['field_121'];?>"><?php  echo $val['field_121'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_122'); ?></label>			
			 <select  name="field_122" id="field_122" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_122'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_122'];?>" selected><?php echo $get_user_details[0]['field_122'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_122') as $val){?>
				<option value="<?php echo $val['field_122'];?>"><?php  echo $val['field_122'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_123'); ?></label>			
			 <select  name="field_123" id="field_123" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_123'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_123'];?>" selected><?php echo $get_user_details[0]['field_123'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_123') as $val){?>
				<option value="<?php echo $val['field_123'];?>"><?php  echo $val['field_123'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_124'); ?> </label>			
			 <select  name="field_124" id="field_124" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_124'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_124'];?>" selected><?php echo $get_user_details[0]['field_124'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_124') as $val){?>
				<option value="<?php echo $val['field_124'];?>"><?php  echo $val['field_124'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_125'); ?></label>			
			 <select  name="field_125" id="field_125" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_125'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_125'];?>" selected><?php echo $get_user_details[0]['field_125'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_125') as $val){?>
				<option value="<?php echo $val['field_125'];?>"><?php  echo $val['field_125'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_126'); ?></label>			
			 <select  name="field_126" id="field_126" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_126'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_126'];?>" selected><?php echo $get_user_details[0]['field_126'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_126') as $val){?>
				<option value="<?php echo $val['field_126'];?>"><?php  echo $val['field_126'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_127'); ?> </label>			
			 <select  name="field_127" id="field_127" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_127'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_127'];?>" selected><?php echo $get_user_details[0]['field_127'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_127') as $val){?>
				<option value="<?php echo $val['field_127'];?>"><?php  echo $val['field_127'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_128'); ?></label>			
			 <select  name="field_128" id="field_128" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_128'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_128'];?>" selected><?php echo $get_user_details[0]['field_128'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_128') as $val){?>
				<option value="<?php echo $val['field_128'];?>"><?php  echo $val['field_128'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_129'); ?></label>			
			 <select  name="field_129" id="field_129" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_129'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_129'];?>" selected><?php echo $get_user_details[0]['field_129'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_129') as $val){?>
				<option value="<?php echo $val['field_129'];?>"><?php  echo $val['field_129'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_130'); ?> </label>			
			 <select  name="field_130" id="field_130" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_130'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_130'];?>" selected><?php echo $get_user_details[0]['field_130'];?></option>		   
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_130') as $val){?>
				<option value="<?php echo $val['field_130'];?>"><?php  echo $val['field_130'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_131'); ?></label>			
			 <select  name="field_131" id="field_131" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_131'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_131'];?>" selected><?php echo $get_user_details[0]['field_131'];?></option>		   
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_131') as $val){?>
				<option value="<?php echo $val['field_131'];?>"><?php  echo $val['field_131'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_132'); ?></label>			
			 <select  name="field_132" id="field_132" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_132'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_132'];?>" selected><?php echo $get_user_details[0]['field_132'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_132') as $val){?>
				<option value="<?php echo $val['field_132'];?>"><?php  echo $val['field_132'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_133'); ?> </label>			
			 <select  name="field_133" id="field_133" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_133'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_133'];?>" selected><?php echo $get_user_details[0]['field_133'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_133') as $val){?>
				<option value="<?php echo $val['field_133'];?>"><?php  echo $val['field_133'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_134'); ?></label>			
			 <select  name="field_134" id="field_134" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_134'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_134'];?>" selected><?php echo $get_user_details[0]['field_134'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_134') as $val){?>
				<option value="<?php echo $val['field_134'];?>"><?php  echo $val['field_134'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_135'); ?></label>			
			 <select  name="field_135" id="field_135" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_135'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_135'];?>" selected><?php echo $get_user_details[0]['field_135'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_135') as $val){?>
				<option value="<?php echo $val['field_135'];?>"><?php  echo $val['field_135'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_136'); ?> </label>			
			 <select  name="field_136" id="field_136" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_136'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_136'];?>" selected><?php echo $get_user_details[0]['field_136'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_136') as $val){?>
				<option value="<?php echo $val['field_136'];?>"><?php  echo $val['field_136'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_137'); ?></label>			
			 <select  name="field_137" id="field_137" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_137'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_137'];?>" selected><?php echo $get_user_details[0]['field_137'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_137') as $val){?>
				<option value="<?php echo $val['field_137'];?>"><?php  echo $val['field_137'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_138'); ?></label>			
			 <select  name="field_138" id="field_138" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_138'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_138'];?>" selected><?php echo $get_user_details[0]['field_138'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_138') as $val){?>
				<option value="<?php echo $val['field_138'];?>"><?php  echo $val['field_138'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_139'); ?> </label>			
			 <select  name="field_139" id="field_139" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_139'); ?>-</option>	  
			<option value="<?php echo $get_user_details[0]['field_139'];?>" selected><?php echo $get_user_details[0]['field_139'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_139') as $val){?>
				<option value="<?php echo $val['field_139'];?>"><?php  echo $val['field_139'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_140'); ?></label>			
			 <select  name="field_140" id="field_140" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_140'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_140'];?>" selected><?php echo $get_user_details[0]['field_140'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_140') as $val){?>
				<option value="<?php echo $val['field_140'];?>"><?php  echo $val['field_140'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_141'); ?></label>			
			 <select  name="field_141" id="field_141" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_141'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_141'];?>" selected><?php echo $get_user_details[0]['field_141'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_141') as $val){?>
				<option value="<?php echo $val['field_141'];?>"><?php  echo $val['field_141'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_142'); ?> </label>			
			 <select  name="field_142" id="field_142" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_142'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_142'];?>" selected><?php echo $get_user_details[0]['field_142'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_142') as $val){?>
				<option value="<?php echo $val['field_142'];?>"><?php  echo $val['field_142'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_143'); ?></label>			
			 <select  name="field_143" id="field_143" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_143'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_143'];?>" selected><?php echo $get_user_details[0]['field_143'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_143') as $val){?>
				<option value="<?php echo $val['field_143'];?>"><?php  echo $val['field_143'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_144'); ?></label>			
			 <select  name="field_144" id="field_144" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_144'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_144'];?>" selected><?php echo $get_user_details[0]['field_144'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_144') as $val){?>
				<option value="<?php echo $val['field_144'];?>"><?php  echo $val['field_144'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_145'); ?> </label>			
			 <select  name="field_145" id="field_145" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_145'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_145'];?>" selected><?php echo $get_user_details[0]['field_145'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_145') as $val){?>
				<option value="<?php echo $val['field_145'];?>"><?php  echo $val['field_145'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_146'); ?></label>			
			 <select  name="field_146" id="field_146" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_146'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_146'];?>" selected><?php echo $get_user_details[0]['field_146'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_146') as $val){?>
				<option value="<?php echo $val['field_146'];?>"><?php  echo $val['field_146'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_147'); ?></label>			
			 <select  name="field_147" id="field_147" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_147'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_147'];?>" selected><?php echo $get_user_details[0]['field_147'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_147') as $val){?>
				<option value="<?php echo $val['field_147'];?>"><?php  echo $val['field_147'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_148'); ?> </label>			
			 <select  name="field_148" id="field_148" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_148'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_148'];?>" selected><?php echo $get_user_details[0]['field_148'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_148') as $val){?>
				<option value="<?php echo $val['field_148'];?>"><?php  echo $val['field_148'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_149'); ?></label>			
			 <select  name="field_149" id="field_149" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_149'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_149'];?>" selected><?php echo $get_user_details[0]['field_149'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_149') as $val){?>
				<option value="<?php echo $val['field_149'];?>"><?php  echo $val['field_149'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_150'); ?></label>			
			 <select  name="field_150" id="field_150" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_150'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_150'];?>" selected><?php echo $get_user_details[0]['field_150'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_150') as $val){?>
				<option value="<?php echo $val['field_150'];?>"><?php  echo $val['field_150'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_151'); ?> </label>			
			 <select  name="field_151" id="field_151" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_151'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_151'];?>" selected><?php echo $get_user_details[0]['field_151'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_151') as $val){?>
				<option value="<?php echo $val['field_151'];?>"><?php  echo $val['field_151'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_152'); ?></label>			
			 <select  name="field_152" id="field_152" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_152'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_152'];?>" selected><?php echo $get_user_details[0]['field_152'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_152') as $val){?>
				<option value="<?php echo $val['field_152'];?>"><?php  echo $val['field_152'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_153'); ?></label>			
			 <select  name="field_153" id="field_153" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_153'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_153'];?>" selected><?php echo $get_user_details[0]['field_153'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_153') as $val){?>
				<option value="<?php echo $val['field_153'];?>"><?php  echo $val['field_153'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_154'); ?> </label>			
			 <select  name="field_154" id="field_154" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_154'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_154'];?>" selected><?php echo $get_user_details[0]['field_154'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_154') as $val){?>
				<option value="<?php echo $val['field_154'];?>"><?php  echo $val['field_154'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_155'); ?></label>			
			 <select  name="field_155" id="field_155" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_155'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_155'];?>" selected><?php echo $get_user_details[0]['field_155'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_155') as $val){?>
				<option value="<?php echo $val['field_155'];?>"><?php  echo $val['field_155'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_156'); ?></label>			
			 <select  name="field_156" id="field_156" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_156'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_156'];?>" selected><?php echo $get_user_details[0]['field_156'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_156') as $val){?>
				<option value="<?php echo $val['field_156'];?>"><?php  echo $val['field_156'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_157'); ?> </label>			
			 <select  name="field_157" id="field_157" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_157'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_157'];?>" selected><?php echo $get_user_details[0]['field_157'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_157') as $val){?>
				<option value="<?php echo $val['field_157'];?>"><?php  echo $val['field_157'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_158'); ?></label>			
			 <select  name="field_158" id="field_158" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_158'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_158'];?>" selected><?php echo $get_user_details[0]['field_158'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_158') as $val){?>
				<option value="<?php echo $val['field_158'];?>"><?php  echo $val['field_158'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_159'); ?></label>			
			 <select  name="field_159" id="field_159" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_159'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_159'];?>" selected><?php echo $get_user_details[0]['field_159'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_159') as $val){?>
				<option value="<?php echo $val['field_159'];?>"><?php  echo $val['field_159'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_160'); ?> </label>			
			 <select  name="field_160" id="field_160" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_160'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_160'];?>" selected><?php echo $get_user_details[0]['field_160'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_160') as $val){?>
				<option value="<?php echo $val['field_160'];?>"><?php  echo $val['field_160'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_161'); ?></label>			
			 <select  name="field_161" id="field_161" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_161'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_161'];?>" selected><?php echo $get_user_details[0]['field_161'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_161') as $val){?>
				<option value="<?php echo $val['field_161'];?>"><?php  echo $val['field_161'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_162'); ?></label>			
			 <select  name="field_162" id="field_162" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_162'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_162'];?>" selected><?php echo $get_user_details[0]['field_162'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_162') as $val){?>
				<option value="<?php echo $val['field_162'];?>"><?php  echo $val['field_162'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_163'); ?> </label>			
			 <select  name="field_163" id="field_163" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_163'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_163'];?>" selected><?php echo $get_user_details[0]['field_163'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_163') as $val){?>
				<option value="<?php echo $val['field_163'];?>"><?php  echo $val['field_163'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_164'); ?></label>			
			 <select  name="field_164" id="field_164" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_164'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_164'];?>" selected><?php echo $get_user_details[0]['field_164'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_164') as $val){?>
				<option value="<?php echo $val['field_164'];?>"><?php  echo $val['field_164'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_165'); ?></label>			
			 <select  name="field_165" id="field_165" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_165'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_165'];?>" selected><?php echo $get_user_details[0]['field_165'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_165') as $val){?>
				<option value="<?php echo $val['field_165'];?>"><?php  echo $val['field_165'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_166'); ?> </label>			
			 <select  name="field_166" id="field_166" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_166'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_166'];?>" selected><?php echo $get_user_details[0]['field_166'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_166') as $val){?>
				<option value="<?php echo $val['field_166'];?>"><?php  echo $val['field_166'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_167'); ?></label>			
			 <select  name="field_167" id="field_167" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_167'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_167'];?>" selected><?php echo $get_user_details[0]['field_167'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_167') as $val){?>
				<option value="<?php echo $val['field_167'];?>"><?php  echo $val['field_167'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_168'); ?></label>			
			 <select  name="field_168" id="field_168" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_168'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_168'];?>" selected><?php echo $get_user_details[0]['field_168'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_168') as $val){?>
				<option value="<?php echo $val['field_168'];?>"><?php  echo $val['field_168'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_169'); ?> </label>			
			 <select  name="field_169" id="field_169" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_169'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_169'];?>" selected><?php echo $get_user_details[0]['field_169'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_169') as $val){?>
				<option value="<?php echo $val['field_169'];?>"><?php  echo $val['field_169'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_170'); ?></label>			
			 <select  name="field_170" id="field_170" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_170'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_170'];?>" selected><?php echo $get_user_details[0]['field_170'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_170') as $val){?>
				<option value="<?php echo $val['field_170'];?>"><?php  echo $val['field_170'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_171'); ?></label>			
			 <select  name="field_171" id="field_171" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_171'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_171'];?>" selected><?php echo $get_user_details[0]['field_171'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_171') as $val){?>
				<option value="<?php echo $val['field_171'];?>"><?php  echo $val['field_171'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_172'); ?> </label>			
			 <select  name="field_172" id="field_172" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_172'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_172'];?>" selected><?php echo $get_user_details[0]['field_172'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_172') as $val){?>
				<option value="<?php echo $val['field_172'];?>"><?php  echo $val['field_172'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_173'); ?></label>			
			 <select  name="field_173" id="field_173" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_173'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_173'];?>" selected><?php echo $get_user_details[0]['field_173'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_173') as $val){?>
				<option value="<?php echo $val['field_173'];?>"><?php  echo $val['field_173'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_174'); ?></label>			
			 <select  name="field_174" id="field_174" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_174'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_174'];?>" selected><?php echo $get_user_details[0]['field_174'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_174') as $val){?>
				<option value="<?php echo $val['field_174'];?>"><?php  echo $val['field_174'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_175'); ?> </label>			
			 <select  name="field_175" id="field_175" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_175'); ?>-</option>	  
			<option value="<?php echo $get_user_details[0]['field_175'];?>" selected><?php echo $get_user_details[0]['field_175'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_175') as $val){?>
				<option value="<?php echo $val['field_175'];?>"><?php  echo $val['field_175'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_176'); ?></label>			
			 <select  name="field_176" id="field_176" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_176'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_176'];?>" selected><?php echo $get_user_details[0]['field_176'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_176') as $val){?>
				<option value="<?php echo $val['field_176'];?>"><?php  echo $val['field_176'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_177'); ?></label>			
			 <select  name="field_177" id="field_177" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_177'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_177'];?>" selected><?php echo $get_user_details[0]['field_177'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_177') as $val){?>
				<option value="<?php echo $val['field_177'];?>"><?php  echo $val['field_177'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_178'); ?> </label>			
			 <select  name="field_178" id="field_178" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_178'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_178'];?>" selected><?php echo $get_user_details[0]['field_178'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_178') as $val){?>
				<option value="<?php echo $val['field_178'];?>"><?php  echo $val['field_178'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_179'); ?></label>			
			 <select  name="field_179" id="field_179" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_179'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_179'];?>" selected><?php echo $get_user_details[0]['field_179'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_179') as $val){?>
				<option value="<?php echo $val['field_179'];?>"><?php  echo $val['field_179'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_180'); ?></label>			
			 <select  name="field_180" id="field_180" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_180'); ?>-</option>		
			<option value="<?php echo $get_user_details[0]['field_180'];?>" selected><?php echo $get_user_details[0]['field_180'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_180') as $val){?>
				<option value="<?php echo $val['field_180'];?>"><?php  echo $val['field_180'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_181'); ?> </label>			
			 <select  name="field_181" id="field_181" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_181'); ?>-</option>	  
			<option value="<?php echo $get_user_details[0]['field_181'];?>" selected><?php echo $get_user_details[0]['field_181'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_181') as $val){?>
				<option value="<?php echo $val['field_181'];?>"><?php  echo $val['field_181'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_182'); ?></label>			
			 <select  name="field_182" id="field_182" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_182'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_182'];?>" selected><?php echo $get_user_details[0]['field_182'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_182') as $val){?>
				<option value="<?php echo $val['field_182'];?>"><?php  echo $val['field_182'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_183'); ?></label>			
			 <select  name="field_183" id="field_183" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_183'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_183'];?>" selected><?php echo $get_user_details[0]['field_183'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_183') as $val){?>
				<option value="<?php echo $val['field_183'];?>"><?php  echo $val['field_183'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_184'); ?> </label>			
			 <select  name="field_184" id="field_184" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_184'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_184'];?>" selected><?php echo $get_user_details[0]['field_184'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_184') as $val){?>
				<option value="<?php echo $val['field_184'];?>"><?php  echo $val['field_184'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_185'); ?></label>			
			 <select  name="field_185" id="field_185" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_185'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_185'];?>" selected><?php echo $get_user_details[0]['field_185'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_185') as $val){?>
				<option value="<?php echo $val['field_185'];?>"><?php  echo $val['field_185'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_186'); ?></label>			
			 <select  name="field_186" id="field_186" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_186'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_186'];?>" selected><?php echo $get_user_details[0]['field_186'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_186') as $val){?>
				<option value="<?php echo $val['field_186'];?>"><?php  echo $val['field_186'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_187'); ?> </label>			
			 <select  name="field_187" id="field_187" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_187'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_187'];?>" selected><?php echo $get_user_details[0]['field_187'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_187') as $val){?>
				<option value="<?php echo $val['field_187'];?>"><?php  echo $val['field_187'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_188'); ?></label>			
			 <select  name="field_188" id="field_188" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_188'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_188'];?>" selected><?php echo $get_user_details[0]['field_188'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_188') as $val){?>
				<option value="<?php echo $val['field_188'];?>"><?php  echo $val['field_188'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_189'); ?></label>			
			 <select  name="field_189" id="field_189" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_189'); ?>field_189-</option>	
			<option value="<?php echo $get_user_details[0]['field_189'];?>" selected><?php echo $get_user_details[0]['field_189'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_189') as $val){?>
				<option value="<?php echo $val['field_189'];?>"><?php  echo $val['field_189'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_190'); ?> </label>			
			 <select  name="field_190" id="field_190" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_190'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_190'];?>" selected><?php echo $get_user_details[0]['field_190'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_190') as $val){?>
				<option value="<?php echo $val['field_190'];?>"><?php  echo $val['field_190'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_191'); ?></label>			
			 <select  name="field_191" id="field_191" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_191'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_191'];?>" selected><?php echo $get_user_details[0]['field_191'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_191') as $val){?>
				<option value="<?php echo $val['field_191'];?>"><?php  echo $val['field_191'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_192'); ?></label>			
			 <select  name="field_192" id="field_192" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_192'); ?>-</option>	 
			<option value="<?php echo $get_user_details[0]['field_192'];?>" selected><?php echo $get_user_details[0]['field_192'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_192') as $val){?>
				<option value="<?php echo $val['field_192'];?>"><?php  echo $val['field_192'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_193'); ?> </label>			
			 <select  name="field_193" id="field_193" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_193'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_193'];?>" selected><?php echo $get_user_details[0]['field_193'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_193') as $val){?>
				<option value="<?php echo $val['field_193'];?>"><?php  echo $val['field_193'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_194'); ?></label>			
			 <select  name="field_194" id="field_194" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_194'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_194'];?>" selected><?php echo $get_user_details[0]['field_194'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_194') as $val){?>
				<option value="<?php echo $val['field_194'];?>"><?php  echo $val['field_194'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_195'); ?></label>			
			 <select  name="field_195" id="field_195" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_195'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_195'];?>" selected><?php echo $get_user_details[0]['field_195'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_195') as $val){?>
				<option value="<?php echo $val['field_195'];?>"><?php  echo $val['field_195'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_196'); ?> </label>			
			 <select  name="field_196" id="field_196" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_196'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_196'];?>" selected><?php echo $get_user_details[0]['field_196'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_196') as $val){?>
				<option value="<?php echo $val['field_196'];?>"><?php  echo $val['field_196'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_197'); ?></label>			
			 <select  name="field_197" id="field_197" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_197'); ?>-</option>
			<option value="<?php echo $get_user_details[0]['field_197'];?>" selected><?php echo $get_user_details[0]['field_197'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_197') as $val){?>
				<option value="<?php echo $val['field_197'];?>"><?php  echo $val['field_197'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_198'); ?></label>			
			 <select  name="field_198" id="field_198" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_198'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_198'];?>" selected><?php echo $get_user_details[0]['field_198'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_198') as $val){?>
				<option value="<?php echo $val['field_198'];?>"><?php  echo $val['field_198'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		<div class="form-group row">			
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_199'); ?> </label>			
			 <select  name="field_199" id="field_199" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_199'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_199'];?>" selected><?php echo $get_user_details[0]['field_199'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_199') as $val){?>
				<option value="<?php echo $val['field_199'];?>"><?php  echo $val['field_199'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_200'); ?></label>			
			 <select  name="field_200" id="field_200" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_200'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_200'];?>" selected><?php echo $get_user_details[0]['field_200'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_200') as $val){?>
				<option value="<?php echo $val['field_200'];?>"><?php  echo $val['field_200'];?></option> 
			<?php } ?>				
            </select>				
			</div>	
			<div class="col-sm-4">
			  <label for="form-field-8"><?php echo getConsumerFieldName('field_201'); ?></label>			
			 <select  name="field_201" id="field_201" class="form-control" required>
           <option value="">-<?php echo getConsumerFieldName('field_201'); ?>-</option>	
			<option value="<?php echo $get_user_details[0]['field_201'];?>" selected><?php echo $get_user_details[0]['field_201'];?></option>
            <option value="all">All</option>
			<?php foreach(getConsumerData('field_201') as $val){?>
				<option value="<?php echo $val['field_201'];?>"><?php  echo $val['field_201'];?></option> 
			<?php } ?>				
            </select>				
			</div>			
		</div>
		
		
		
		
		<script>
function compare()
{
 var consumer_min_age1 = document.getElementById("consumer_min_age").value;
 var consumer_max_age1 = document.getElementById("consumer_max_age").value;
 if(consumer_min_age1 == consumer_max_age1)
 {
  alert("Minimum Age can not be equal to Maximum Age.");
  document.getElementById(consumer_max_age1).focus();
	document.getElementById(consumer_max_age1).focus();
 }
 else if(consumer_min_age1 > consumer_max_age1)
 {
  alert("Minimum Age can not be larger than Maximum Age.");
	document.getElementById(consumer_max_age1).focus();
 } 
}
</script>
		
           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" onclick="compare();" />
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
