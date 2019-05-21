<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">
		<?php $type = "User";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='add_plant_controller'){
									$type = "User";
								}?>
      <h4 class="widget-title">Add <?php echo $type;?></h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>

      <form name="user_frm" id="user_frm" action="#" method="POST">

        <div class="widget-main">
		<?php $random_no = random_num(9);?>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">User ID</label>
			<input name="customer_code" readonly="" id="customer_code" type="text" class="form-control" value="<?php echo $random_no;?>" >
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Phone#</label>
             <input name="user_mobile" id="user_mobile" type="text" class="form-control" placeholder="User Mobile">
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">User Name</label>
             <input name="user_name" id="user_name" type="text" class="form-control" placeholder="User Name"  maxlength="20">
			</div>
			 
			
			<div class="col-sm-6">
			  <label for="form-field-8">Email ID</label>

            <input name="user_email" id="user_email" type="text" class="form-control" placeholder="Email ID"  maxlength="50">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">First Name</label>
			<input name="f_name" id="f_name" type="text" class="form-control" placeholder="First Name"  maxlength="30">
			</div>
			 
			
			<div class="col-sm-4">
			  <label for="form-field-8">Last Name</label>
			 <input name="l_name" id="l_name" type="text" class="form-control" placeholder="Last Name"  maxlength="30">
			</div>
			<div class="col-sm-4">
			<label for="form-field-8">Select Role of user-</label>
		   <select  name="role" id="role" class="form-control" required>
           <option value="">-Select Role-</option>
		   <?php if($this->session->userdata('admin_user_id')==1){?>
		   <option value="2">CCC Admin</option>
		   <?php } ?>
            <?php foreach(getAllRoles('0') as $val){?>
				<option value="<?php echo $val['id'];?>"><?php  echo $val['role_name_value'];?></option> 
			<?php }?>
            <option value="other">Other</option>
			 
            </select>
			</div>
		</div>
		
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Select the Industry of user</label>
			<!--<input name="industry" id="industry" type="text" class="form-control" placeholder="Industry Name"  maxlength="100">-->
		   <select  name="industry" id="industry" class="form-control" required>
           <option value="">-Select Industry-</option>
            <?php foreach(getAllCategory('0') as $val){?>
				<option value="<?php echo $val['categoryName'];?>"><?php  echo $val['categoryName'];?></option> 
			<?php }?>
            <option value="other">Other</option>
            </select>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Customer Loyalty Type</label>
			  <select  name="Customer_Loyalty_Type" id="Customer_Loyalty_Type" class="form-control" required>
			<option value="">-Select Customer Loyalty Type-</option>
			<option value="General">General</option>
            <option value="Brand">Brand</option>
            </select>
			</div>
			
			
			<div class="col-sm-4">
			  <label for="form-field-8">Pan</label>
             <input name="pan" id="pan" type="text" class="form-control" placeholder="Pan No." maxlength="12">
			</div>
		</div>
		 
		<div class="form-group row">
			<div class="col-sm-6">
			 <label for="form-field-9">State</label>
			 <?php $states = get_state_name(31);?>
             <select class="form-control" placeholder="Select State" id="state_name" name="state_name" onchange="get_related_city_list(this.value);">
  		  		<?php foreach($states as $val){?>
				<option value="<?php echo $val['state_id'];?>"><?php  echo $val['state_name'];?></option> 
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
		
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">Profile Image</label>

                <div class="widget-body">

                     <label class="ace-file-input"><input id="file" onchange="readURL(this);" name="file"  type="file"><span class="ace-file-container" data-title="Choose">

                     <span class="ace-file-name" data-title="No File ..."><i class=" ace-icon fa fa-upload"></i></span></span>

                     <a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label> <img style="display:none;" width="100px" id="blah" src="#" alt="Image Preview" />

                </div>

			</div>
			 <div class="col-sm-6">
			 <label for="form-field-8">Remark</label>
			  <textarea  class="form-control" name="remark" placeholder="Write your remark..."  maxlength="500"></textarea>
			</div>
			
		</div>
         <?php if($this->uri->segment(2)=='add_plant_controller'){?>
		 <div class="form-group row">
		     <div class="col-sm-6">
            
			  <label for="form-field-9">CCC Admin</label>
			 <?php $ccadmin = getParentUsers('','1');?>
             <select class="form-control" placeholder="Select Admin" id="ccadmin" name="ccadmin" onchange="get_related_city_list(this.value);">
			 <option value="">-Select CCC Admin-</option>
  		  		<?php foreach($ccadmin as $val){?>
				<option value="<?php echo $val['user_id'];?>"><?php  echo $val['user_name'];?></option> 
			 	<?php }?>
			 </select>  
 			</div> 
		</div>
		<?php }?>
           <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />
			<a href="<?php echo base_url('user_master/list_user/') ?>" class="btn btn-info" title="Back to List Loyalty Matrix">Back to List Users <?php echo $label; ?> </a>	
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