<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>plant_master/list_locations" class="btn btn-primary pull-right" title="Back to List locations">Back to List locations</a></div>
<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Location</h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>
		<?php
		// MySQL connect info
			//mysql_connect("localhost", "tpdbuser", "india@123");
			//mysql_select_db("trackingprortaldb");
			
			mysql_connect("localhost", "root", "");
			mysql_select_db("trackingportaldb");
			
			
			//$query = mysql_query("SELECT MAX( plant_id ) FROM plant_master;");
			 $highest_id = mysql_result(mysql_query("SELECT MAX(location_id) FROM location_master"), 0);
			 $location_code = $highest_id + 1;

?>
	  
      <form name="user_frm" id="user_frm" action="#" method="POST">

        <div class="widget-main">
		<?php $random_no = random_num(4);?>
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Location Code</label>
			<input name="location_code" readonly="" id="location_code" type="text" class="form-control" value="<?php echo 'L00'.$location_code;?>" >
			 
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Location Name</label>
             <input name="location_name" id="location_name" type="text" class="form-control" placeholder="location Name">
			</div>
			
			<div class="col-sm-4">
			  <label for="form-field-8">Location Type</label>
			  
			  <select class="form-control" placeholder="Location Type" id="location_type" name="location_type" onchange="">
			  <option value="" selected>-Please Select Location Type-</option> 
  		  		<?php foreach(getAllLocationTypes('0') as $val){?>
				<option value="<?php echo $val['location_type_name'];?>"><?php  echo $val['location_type_name'];?></option> 
				<?php }?>
			 </select>  
			 
            <!-- <input name="location_name" id="location_name" type="text" class="form-control" placeholder="location Name">-->
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Email ID</label>
             <input name="location_email" id="location_email" type="text" class="form-control" placeholder="Email ID"  maxlength="50">
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Phone</label>
             <input name="user_mobile" id="user_mobile" type="text" class="form-control" placeholder="Phone No." maxlength="12">
			</div>
		</div>
		 
		
		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">GST</label>
			<input name="gst" id="gst" type="text" class="form-control" placeholder="GST"  maxlength="30">
			</div>
			 
			<div class="col-sm-6">
			 <label for="form-field-9">State</label>
			 <?php $states = get_state_name(31);?>
             <select class="form-control" placeholder="Select State" id="state_name" name="state_name" onchange="get_related_city_list(this.value);">
  		  		<?php foreach($states as $val){?>
				<option value="<?php echo $val['state_id'];?>"><?php  echo $val['state_name'];?></option> 
			 	<?php }?>
			 </select>  
			</div>
			 
		 
		 
		 
			
		</div>
 		<div class="form-group row">
			<div class="col-sm-6">
			  <label for="form-field-8">Address</label>
            <textarea  class="form-control" name="address" id="address" placeholder="Fill address"></textarea>
			</div>
 			<div class="col-sm-6">
			  <label for="form-field-8">Remark</label>
            <textarea  class="form-control" name="remark" id="remark" placeholder="Your view/ Remark"></textarea>
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
 