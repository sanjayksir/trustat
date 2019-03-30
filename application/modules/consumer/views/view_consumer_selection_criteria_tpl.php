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
			<label for="form-field-8"><b>Promotion Type</b></label> : 
			<?php echo $get_user_details[0]['promotion_type'];?>
		 		
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Consumer Gender</b></label>  : 
			<?php echo $get_user_details[0]['consumer_gender'];?>
			</div>			
			
			<div class="col-sm-4">
			  <label for="form-field-8"><b>City of Consumer</b></label> :
			<?php echo $get_user_details[0]['consumer_city'];?>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Consumer Age</b></label> :
             <?php echo $get_user_details[0]['consumer_min_age'];?> to <?php echo $get_user_details[0]['consumer_max_age'];?>
			</div>
			 
			<!--
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Maximum Age in Years</b></label> :
			  
			</div>
			-->
			<div class="col-sm-4">
			  <label for="form-field-8"><b>Pin Code of Consumer</b></label>:
			<?php echo $get_user_details[0]['consumer_pin'];?>
			</div>
		</div>
		
		
		
		
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Your Industry</label>
			<!--<input name="industry" id="industry" type="text" class="form-control" placeholder="Industry Name" value="<?php //echo $get_user_details[0]['industry'];?>"  maxlength="100">-->
			
			<select  name="industry" id="industry" class="form-control" required>
			<option value="<?php echo $get_user_details[0]['industry'];?>" selected><?php echo $get_user_details[0]['industry'];?></option>
            <?php foreach(getAllCategory('0') as $val){?>
				<option value="<?php echo $val['categoryName'];?>"><?php  echo $val['categoryName'];?></option> 
			<?php }?>
            <option value="Other">Other</option>
            </select>
			
			
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
             <select class="form-control" placeholder="Select State" id="state_name" name="state_name" onchange="get_related_city_list(this.value);">
  		  		<?php foreach($states as $val){?>
				<option value="<?php echo $val['state_id'];?>" <?php if($val['state_id']==$get_user_details[0]['state']){echo 'selected';}?>><?php  echo $val['state_name'];?></option> 
			 	<?php }?>
			 </select>  
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
