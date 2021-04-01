<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">
		<?php $type = "Auto Email MIS Master";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='add_plant_controller'){
									$type = "Auto Email MIS Master";
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
			  var mis_report_name = document.getElementById('mis_report_name');
			  //new_text = text.replace(' ', '_');
			  var mis_report_slug = document.getElementById('mis_report_slug');
			  mis_report_slug.value = mis_report_name.value.split(' ').join('_').toLowerCase();
			}
			</script>
			<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Master Name</label>
			  <input type="text" placeholder="Please Enter Auto Email MIS Name" name="mis_report_name" id="mis_report_name"  onkeyup="sync()" class="form-control" required>			  
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Auto Email MIS Master Slug</label>
			  <input type="text" placeholder="Please Enter Auto Email MIS Master Slug" name="mis_report_slug" id="mis_report_slug" class="form-control" readonly>			  
			</div>
			
			
		</div>
		
		<div class="form-group row" align="center">
			
			<div class="col-sm-12" align="center">
			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
		</div>


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            
			<a href="<?php echo base_url('role_master/list_all_auto_email_mis_masters') ?>" class="btn btn-info" title="Back to List Auto Email MIS Master">Back to List Auto Email MIS Master<?php echo $label; ?> </a>	
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