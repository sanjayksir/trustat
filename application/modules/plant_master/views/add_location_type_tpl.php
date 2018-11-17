<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>plant_master/list_location_types" class="btn btn-primary pull-right" title="Back to List Location Typ names">Back to List Location Type names</a></div>
<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Location Type</h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>
		
	  
      <form name="user_frm" id="user_frm" action="#" method="POST">

        <div class="widget-main">
		<div class="form-group row">
			
			
			<div class="col-sm-6">
			  <label for="form-field-8">Location Type Name</label>
             <input name="location_type_name" id="location_type_name" type="text" class="form-control" placeholder="Location Type Name">
			</div>
		</div>
		
		
            <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Submit" id="savemenu" />

          </div>

        </div>

      </form>

    </div>

  </div>

</div>
 