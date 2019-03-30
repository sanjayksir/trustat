<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">
		<?php $type = "Consumer Selection Criteria";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='add_plant_controller'){
									$type = "Consumer Selection Criteria";
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
			<label for="form-field-8">Promotion Type</label>
		<select  name="promotion_type" id="promotion_type" class="form-control" required>
			<option value="">-Select Promotion Type-</option>		   
            <option value="Advertisement-Video">Advertisement Video</option>
			<option value="Survey-Video">Survey Video</option>
			<option value="Communication-Text">Consumer Communication Text</option>			 
         </select>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Consumer Gender</label>
             <select  name="consumer_gender" id="consumer_gender" class="form-control">
			<option value="all">All</option>
            <option value="male">Male</option>
			<option value="female">Female</option>
			 
			</select>
			</div>
			
			
			<div class="col-sm-4">
			  <label for="form-field-8">City of Consumer</label>
			<input name="consumer_city" id="consumer_city" type="text" class="form-control" placeholder="City of Consumer"  maxlength="30">
			</div>
			
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">Minimum Age in Years</label>
             <input name="consumer_min_age"  id="consumer_min_age" type="text" class="form-control" placeholder="Minimum Age in Years">
			</div>
			 
			
			<div class="col-sm-4">
			  <label for="form-field-8">Maximum Age in Years</label>

            <input name="consumer_max_age" id="consumer_max_age" type="text" class="form-control" placeholder="Maximum Age in Years"  maxlength="50">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Pin Code of Consumer</label>
			 <input name="consumer_pin" id="consumer_pin" type="text" class="form-control" placeholder="Pin Code of Consumer"  maxlength="30">
			</div>
			
		</div>
		 

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />
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