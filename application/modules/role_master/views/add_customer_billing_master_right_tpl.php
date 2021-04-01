<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">
		<?php $type = "Billing Master";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='add_plant_controller'){
									$type = "Billing Master";
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
			<!--<div class="col-sm-4">
			<label for="form-field-8">QUERY Type</label><?php //echo getAttributeSlugByName("Laptop"); ?>
		<select  name="attribute_type_slug" id="attribute_type_slug" class="form-control" required>
			<option value="">-Select QUERY Type-</option>	
			<?php foreach(get_all_consumer_profile_attribute_types('0') as $val){?>
				<option value="<?php echo $val['cpatm_name_slug'];?>-<?php echo $val['profile_bucket'];?>"><?php  echo $val['cpatm_name'];?></option> 
			<?php }?>
			
         </select>
			</div>-->
			<script>
			function sync()
			{
			  var billin_particular_name = document.getElementById('billin_particular_name');
			  //new_text = text.replace(' ', '_');
			  var billin_particular_slug = document.getElementById('billin_particular_slug');
			  billin_particular_slug.value = billin_particular_name.value.split(' ').join('_').toLowerCase();
			}
			</script>
			<div class="col-sm-4">
			  <label for="form-field-8">Billing Master Name</label>
			  <input type="text" placeholder="Please Enter Billing Name" name="billin_particular_name" id="billin_particular_name"  onkeyup="sync()" class="form-control" required>			  
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Billing Master Slug</label>
			  <input type="text" placeholder="Please Enter Billing Master Slug" name="billin_particular_slug" id="billin_particular_slug" class="form-control" readonly>			  
			</div>
			
			
		</div>
		
		<div class="form-group row" align="center">
			
			<div class="col-sm-12" align="center">
			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
		</div>


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            
			<a href="<?php echo base_url('role_master/list_all_customer_billing_masters') ?>" class="btn btn-info" title="Back to List Billing Master">Back to List Billing Master<?php echo $label; ?> </a>	
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