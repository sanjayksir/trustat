<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">
		<?php $type = "FAQ";
								if($this->session->userdata('admin_user_id')>1 || $this->uri->segment(2)=='add_plant_controller'){
									$type = "FAQ";
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
			<label for="form-field-8">FAQ Type</label><?php //echo getAttributeSlugByName("Laptop"); ?>
		<select  name="faq_type" id="faq_type" class="form-control" required>
			<option value="">-Select FAQ Type-</option>
			<option value="Terms and Condition">Terms and Condition</option>
			<option value="FAQ">FAQ</option>
         </select>
			</div>
			
			<div class="col-sm-12">
			  <label for="form-field-8">FAQ Question</label>
	<textarea  class="form-control" name="faq_question" placeholder="FAQ Question....."  maxlength="500" required></textarea>		  
			</div>
			
			<div class="col-sm-12">
			  <label for="form-field-8">FAQ Answer</label>
	<textarea  class="form-control" name="faq_answer" placeholder="FAQ Answer....."  maxlength="10000" rows="5" required></textarea>		  
			</div>
			
			
		</div>
		
		<div class="form-group row" align="center">
			
			<div class="col-sm-12" align="center">
			
			  <input class="btn btn-info" style="margin-top:20px" type="submit" name="submit" value="Submit" id="savemenu" />		  
			</div>
		</div>


          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            
			<a href="<?php echo base_url('consumer/list_faqs_master/') ?>" class="btn btn-info" title="Back to List FAQs">Back to List FAQs<?php echo $label; ?> </a>	
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