<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">
		<?php $type = "Consumer Profile Attribute";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='add_plant_controller'){
									$type = "Consumer Profile Attribute";
								}?>
      <h4 class="widget-title">Add <?php echo $type;?></h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>

      <form name="user_frm" id="user_frm" action="#" method="POST">

        <div class="widget-main">
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Attribute Type</label>
		<select  name="attribute_type" id="attribute_type" class="form-control" required>
			<option value="">-Select Attributes Type-</option>	
			<option value="Gender">Gender</option>
			<option value="City">City</option>
			<option value="State">State</option>
			<option value="Pin Code">Pin Code</option>
			<option value="Monthly Earnings">Monthly Earnings</option>
			<option value="Job Profile">Job Profile</option>
			<option value="Education Qualification">Education Qualification</option>
			<option value="Type Vehicle">Type Vehicle</option>
			<option value="Profession">Profession</option>
			<option value="Marital Status">Marital Status</option>
			<option value="No of Family Members">No of Family Members</option>
			<option value="Loan Car Housing">Loan Car Housing</option>
			<option value="Personal Loan">Personal Loan</option>
			<option value="Credit Card Loan">Credit Card Loan</option>
			<option value="Own a Car">Own a Car</option>
			<option value="House Type">House Type</option>
			<option value="Last Location">Last Location</option>
			<option value="Life Insurance">Life Insurance</option>
			<option value="Medical Insurance">Medical Insurance</option>
			<option value="Height in Inches">Height in Inches</option>
			<option value="Weight in Kg">Weight in Kg</option>
			<option value="Hobbies">Hobbies</option>
			<option value="Sports">Sports</option>
			<option value="Entertainment">Entertainment</option>
			<option value="Spouse Gender">Spouse Gender</option>
			<option value="Spouse Work Status">Spouse Work Status</option>
			<option value="Spouse Education Qualification">Spouse Education Qualification</option>
			<option value="Spouse Monthly Income">Spouse Monthly Income</option>
			<option value="Spouse Loan">Spouse Loan</option>
			<option value="Spouse Personal Loan">Spouse Personal Loan</option>
			<option value="Spouse Credit Card Loan">Spouse Credit Card Loan</option>
			<option value="Spouse Own a Car">Spouse Own a Car</option>
			<option value="Spouse House Type">Spouse House Type</option>
			<option value="Spouse Height Inches">Spouse Height Inches</option>
			<option value="Spouse Weight Kg">Spouse Weight Kg</option>
			<option value="Spouse Hobbies">Spouse Hobbies</option>
			<option value="Spouse Sports">Spouse Sports</option>
			<option value="Spouse Entertainment">Spouse Entertainment</option>		 
         </select>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Attributes Name</label>
			  <input type="text" placeholder="Please Enter Attributes Name" name="attribute_name" id="attribute_name" class="form-control" required>			  
			</div>
			
			<div class="col-sm-4">
			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
		</div>
		
		


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            
			<a href="<?php echo base_url('consumer/list_consumer_profile_attributes/') ?>" class="btn btn-info" title="Back to List Consumer Profile Attributes">Back to List Consumer Profile Attributes<?php echo $label; ?> </a>	
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