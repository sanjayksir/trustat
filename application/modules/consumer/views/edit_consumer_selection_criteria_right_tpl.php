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
			<div class="col-sm-4">
			<label for="form-field-8">Promotion Type</label>
			<input name="promotion_type" id="promotion_type" type="text" readonly="" value="<?php echo $get_user_details[0]['promotion_type'];?>" class="form-control" placeholder="Promotion Type">
			<!--
		  <select  name="promotion_type" id="promotion_type" class="form-control">
           <option value="<?php echo $get_user_details[0]['promotion_type'];?>" selected><?php echo $get_user_details[0]['promotion_type'];?></option>
            <option value="Advertisement-Video">Advertisement Video</option>
			<option value="Survey-Video">Survey Video</option>
			<option value="Communication-Text">Consumer Communication Text</option>	
            </select>	
				-->	
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
             <select  name="consumer_gender" id="consumer_gender" class="form-control">
			 <option value="<?php echo $get_user_details[0]['consumer_gender'];?>" selected><?php echo $get_user_details[0]['consumer_gender'];?></option>
			<option value="All">All Gender</option>
            <option value="male">Male Only</option>
			<option value="female">Female Only</option>
			<option value="Other Gender">Other Gender Only</option>
			</select>
			</div>			
			
			<div class="col-sm-4">
			  <label for="form-field-8">City</label>
			<!--<input name="consumer_city" id="consumer_city" type="text" class="form-control" value="<?php echo $get_user_details[0]['consumer_city'];?>" placeholder="City of Consumer"  maxlength="30">-->
			<select  name="consumer_city" id="consumer_city" class="form-control" required>
           <option value="<?php echo $get_user_details[0]['consumer_city'];?>" selected><?php echo $get_user_details[0]['consumer_city'];?></option>		   
            <?php foreach(getAllCities('0') as $val){?>
				<option value="<?php echo $val['scan_city'];?>"><?php  echo $val['scan_city'];?></option> 
			<?php } ?>				
            </select>
			</div>
			
			
			<div class="col-sm-4">
			 <!-- <label for="form-field-8">Pin Code of Consumer</label>-->
			 <input name="consumer_pin" id="consumer_pin" type="hidden" class="form-control" value="<?php echo $get_user_details[0]['consumer_pin'];?>" placeholder="Pin Code of Consumer"  maxlength="30">
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
