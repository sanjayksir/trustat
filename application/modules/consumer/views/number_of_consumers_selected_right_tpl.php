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
      <h4 class="widget-title">Number of Selected Consumers <?php //echo $type;?></h4>
		<div class="widget-toolbar"> <a href="<?php echo base_url('consumer/list_consumer_selection_criterias/') ?>" > <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="<?php echo base_url('consumer/list_consumer_selection_criterias/') ?>" > <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>
				</div>
				<div class="widget-body">
						<div id="ajax_msg"></div>
				</div>
				<?php $customer_id = $this->session->userdata('admin_user_id');
			  $unique_system_selection_criteria_id = $this->uri->segment(3);
			  //echo $customer_id;
			   //echo ", ";
			    //echo $unique_system_selection_criteria_id;
			  $number_of_consumers_selected = NumberOfSelectedConsumersByACustomer2($customer_id, $unique_system_selection_criteria_id);
			  
			  
			  ?>
				<form name="user_frm" id="user_frm" action="#" method="POST">
		<input type="hidden" name="unique_system_selection_criteria_id" id="unique_system_selection_criteria_id" value="<?php echo  $unique_system_selection_criteria_id; ?>" />
		<input type="hidden" name="number_of_consumers_selected" id="number_of_consumers_selected" value="<?php echo  $number_of_consumers_selected; ?>" />
        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-12">
				<label for="form-field-8"><b>Total Consumers</b></label> - <?php echo NumberOfAllConsumersOfACustomer($customer_id); ?><br />
				<label for="form-field-8"><b>Number of Selected Consumers</b></label> - <?php echo $number_of_consumers_selected; ?><br />
				<label for="form-field-8"><b>Modified at</b></label> - <?php echo $get_user_details[0]['update_date']; ?><br />
			</div>			
		</div>
		
		
		
		<div class="form-group row">
		
			<div class="col-sm-12">
			<label for="form-field-8"><b>Name of Selection Criteria</b></label> : 
			<?php echo $get_user_details[0]['name_of_selection_criteria'];?>		 		
			</div>
			
			

		</div>
		
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8"><b>Unique Sys S Criteria ID</b></label> : 
			<?php echo $get_user_details[0]['unique_system_selection_criteria_id'];?>
		 		
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Minimum Age of the consumer in Years</b></label> :
             <?php echo $get_user_details[0]['consumer_min_age'];?>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Maximum Age of the consumer in Years</b></label> :
             <?php echo $get_user_details[0]['consumer_max_age'];?>
			</div>

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
		
		

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Save" id="savemenu" />
			<a href="<?php echo base_url('consumer/edit_consumer_selection_criteria/')."/".$unique_system_selection_criteria_id; ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Modify the Consumer Selection Criteria <?php echo $label; ?> </a>
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
