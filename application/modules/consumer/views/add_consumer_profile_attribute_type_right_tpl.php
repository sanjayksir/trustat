<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">
		<?php $type = "Consumer Profile Attribute Types";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='add_plant_controller'){
									$type = "Consumer Profile Attribute Types";
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
<script>
function sync()
{
  var cpatm_name = document.getElementById('cpatm_name');
  //new_text = text.replace(' ', '_');
  var cpatm_name_slug = document.getElementById('cpatm_name_slug');
  cpatm_name_slug.value = cpatm_name.value.split(' ').join('_').toLowerCase();
}
</script>
			<div class="col-sm-4">
			  <label for="form-field-8">Attribute Type Name</label>
			  <input type="text" placeholder="Please Enter Attributes Type Name" name="cpatm_name" id="cpatm_name" onkeyup="sync()" class="form-control" required>			  
			</div>
			<div class="col-sm-4">
			  <label for="form-field-8">Attribute Type Slug</label>
			  <input type="text" placeholder="Please Enter Attributes Type Name" name="cpatm_name_slug" id="cpatm_name_slug" class="form-control" readonly>			  
			</div>
			
			
			<div class="col-sm-4">
			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
		</div>
		
		


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            
			<a href="<?php echo base_url('consumer/list_consumer_profile_attribute_types/') ?>" class="btn btn-info" title="Back to List Consumer Profile Attribute Types">Back to List Consumer Profile Attribute Types<?php echo $label; ?> </a>	
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