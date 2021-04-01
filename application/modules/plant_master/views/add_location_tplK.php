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
		<fieldset>
	<legend>Organization Profile</legend>
<?php $random_no = random_num(9);?>
		<div class="form-group row">
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<div class="col-sm-4">
			  <label for="form-field-8">Organization Name</label>
			<input name="f_name" id="f_name" type="text" class="form-control" placeholder="First Name"  maxlength="30">
			</div>
			<?php }?>
			<div class="col-sm-4">
			<label for="form-field-8">Unique User/Customer Code</label>
			<input name="customer_code" readonly="" id="customer_code" type="text" class="form-control" value="<?php echo $random_no;?>" >
			 
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Phone#</label>
             <input name="user_mobile" id="user_mobile" type="text" class="form-control" placeholder="User Mobile">
			</div>
			
			<?php if($this->session->userdata('admin_user_id')==1){?>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Pan</label>
             <input name="pan" id="pan" type="text" class="form-control" placeholder="Pan No." maxlength="12">
			</div>
			
			
			<?php }?>
			
			<div class="col-sm-4">
			 <label for="form-field-8">State</label>
			 <?php $states = get_state_name(31);?>
             <select class="form-control" placeholder="Select State" id="state_name" name="state_name" onchange="get_related_city_list(this.value);">
  		  		<?php foreach($states as $val){?>
				<option value="<?php echo $val['state_id'];?>"><?php  echo $val['state_name'];?></option> 
			 	<?php }?>
			 </select>  
			</div>
			 
			
			<div class="col-sm-4">
			 <label for="form-field-8">City</label>
			  <select class="form-control" id="city_name" name="city_name">
 		  		<option value="">select City</option>       
             </select>
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Profile Imagess</label>

                <div class="widget-body">

                     <label class="ace-file-input"><input id="file" onchange="readURL(this);" name="file"  type="file"><span class="ace-file-container" data-title="Choose">

                     <span class="ace-file-name" data-title="No File ..."><i class=" ace-icon fa fa-upload"></i></span></span>

                     <a class="remove" href="#"><i class=" ace-icon fa fa-times"></i></a></label> <img style="display:none;" width="100px" id="blah" src="#" alt="Image Preview" />

                </div>

			</div>
			 <div class="col-sm-4">
			 <label for="form-field-8">Remark</label>
			  <textarea  class="form-control" name="remark" placeholder="Write your remark..."  maxlength="500"></textarea>
			</div>
			<?php if($this->session->userdata('admin_user_id')==1){?>
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
			<?php }?>
		</div>
</fieldset>
		<hr />
		<fieldset>
			<legend>User Profile</legend>
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">Login User Name</label>
             <input name="user_name" id="user_name" type="text" class="form-control" placeholder="User Name"  maxlength="20">
			</div>
			 
			 <div class="col-sm-4">
			  <label for="form-field-8">Person Name</label>
			 <input name="l_name" id="l_name" type="text" class="form-control" placeholder="Last Name"  maxlength="30">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Email ID</label>

            <input name="user_email" id="user_email" type="text" class="form-control" placeholder="Email ID"  maxlength="50">
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
		
		</fieldset>
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<hr />
		<fieldset>
			<legend>Customer Loyalty Type</legend>
		<div class="form-group row">
			<div class="col-sm-4">
			  <label for="form-field-8">Customer Loyalty Type</label>
			  <select  name="Customer_Loyalty_Type" id="Customer_Loyalty_Type" class="form-control" onchange="showDiv2(this)" required>
			<option value="">-Select Customer Loyalty Type-</option>
			<option value="TRUSTAT">TRUSTAT</option>
            <option value="Brand">Brand</option>
            </select>
			<script type="text/javascript">
				function showDiv2(select){
				   if(select.value=="Brand"){
					document.getElementById('hidden_div2').style.display = "block";
				   } else{
					document.getElementById('hidden_div2').style.display = "none";
				   }
				} 
			</script>
			</div>
			
			
			<div class="col-sm-4">
			  <label for="form-field-8">Days for expiry from the date of Loyalty Point Credited </label>
			<input name="days_for_expiry_of_point_credited" id="days_for_expiry_of_point_credited" type="number" value="<?php echo $get_user_details[0]['days_for_expiry_of_point_credited'];?>" class="form-control" placeholder="Please enter number of days" max="10000" min="1">
			</div>
			 
			
			<div class="col-sm-4">
			  <label for="form-field-8">Days for Notification Before Expiry of Loyalty Point</label>
			 <input name="days_for_notification_before_expiry_of_lps" id="days_for_notification_before_expiry_of_lps" type="number" value="<?php echo $get_user_details[0]['days_for_notification_before_expiry_of_lps'];?>" class="form-control" placeholder="Please enter number of days" max="10000" min="1">
			</div>
			
		</div>
		
		<div class="form-group row">
		<?php if($this->session->userdata('admin_user_id')==1){?>
			<div class="col-sm-4">
			  <label for="form-field-8">Loyalty Points for consumer on view Notification</label>
			<input name="loyalty_points_consumer_view_notification_lps" id="loyalty_points_consumer_view_notification_lps" type="number" value="0" class="form-control" placeholder="Loyalty Points for consumer on view Notification" max="10000" min="0">
			</div>	
			
		<?php }?>
		</div>
		
		<div class="form-group row">
		<?php if($this->session->userdata('admin_user_id')==1){?>
		<div id="hidden_div2" style="display:none;">		
			<div class="col-sm-4">
			  <label for="form-field-8">Brand Loyalty Redemption Type</label>
			  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
				<script>
				$(document).ready(function(){
					$("select").change(function(){
						$(this).find("option:selected").each(function(){
							var optionValue = $(this).attr("value");
							if(optionValue){
								$(".box").not("." + optionValue).hide();
								$("." + optionValue).show();
							} else{
								$(".box").hide();
							}
						});
					}).change();
				});
				</script>
			<select  name="brand_loyalty_redemption_type" id="brand_loyalty_redemption_type" class="form-control" required>
			 <option value="">-Select Brand Loyalty Redemption Type-</option>
			<!--<option value="Physical Coupons">Physical Coupons</option>-->
            <option value="CompanyWebsite">Company Website</option>
			<option value="CompanyStores">Company Stores</option>
            </select> 
			</div>
			<div class="CompanyWebsite box">
			<div class="col-sm-4">
			   <label for="form-field-8">Customer Microsite URL</label>
               <input name="customer_microsite_url" id="customer_microsite_url" type="text" class="form-control" placeholder="Customer Microsite URL" maxlength="200">
			</div>
			</div>
			<div class="CompanyStores box">
			
			<div class="col-sm-4">
			  <label for="form-field-8">Brand Loyalty/Store Redemption/Message</label>
			   <input name="brand_loyalty_store_redemption_message" id="brand_loyalty_store_redemption_message" type="text" class="form-control" placeholder="Brand Loyalty/Store Redemption/Message" maxlength="200">			  
			</div>	
			
			<div class="col-sm-4">
			  <label for="form-field-8">% of Loyalty Points for consumer to be redeemed by Cashier at Retail Store</label>
			<input name="percent_lty_pts_consumer_red_cashier" id="percent_lty_pts_consumer_red_cashier" type="number" value="0" class="form-control" placeholder="% of Loyalty Points for consumer to be redeemed by Cashier at Retail Store" max="100" min="0">
			</div>
			
			</div>
			<!--
			<div class="col-sm-4">
			  <label for="form-field-8">TRUSTAT Coupon Type/Name/Number</label>
			   <input name="trustat_coupon_type_name_number" id="trustat_coupon_type_name_number" type="text" class="form-control" placeholder="TRUSTAT Coupon Type/Name/Number" maxlength="200">			  
			</div>
			-->			
			</div>
		<?php }?>
		</div>
		</fieldset>
		 
		<?php }?>
		
		
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