<div style="clear:both;height:40px;"><a href="<?php echo base_url()?>plant_master/list_plants" class="btn btn-primary pull-right" title="Back to List Plants">Back to List Plants</a></div>
<div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Add Plant</h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>
		<?php
		// MySQL connect info
			mysql_connect("localhost", "root", "");
			mysql_select_db("trackingportaldb");
			
			//mysql_connect("localhost", "root", "");
			//mysql_select_db("trackingprortaldb20");
			
			
			//$query = mysql_query("SELECT MAX( plant_id ) FROM plant_master;");
			 $highest_id = mysql_result(mysql_query("SELECT MAX(plant_id) FROM plant_master"), 0);
			 $plant_code = $highest_id + 1;

?>
	  
      <form name="user_frm" id="user_frm" action="#" method="POST">

        <div class="widget-main">
		<?php $random_no = random_num(4);?>
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Plant Code</label>
			<input name="customer_code" readonly="" id="customer_code" type="text" class="form-control" value="<?php echo 'P00'.$plant_code;?>" >
			 
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Plant Name</label>
             <input name="plant_name" id="plant_name" type="text" class="form-control" placeholder="Plant Name">
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Email ID</label>
             <input name="user_email" id="user_email" type="text" class="form-control" placeholder="Email ID"  maxlength="50">
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
            <textarea  class="form-control" name="address" id="address" placeholder="Full address"></textarea>
			</div>
 			<div class="col-sm-6">
			  <label for="form-field-8">Remark</label>
            <textarea  class="form-control" name="remark" id="remark" placeholder="Your view/ Remark"></textarea>
			</div>
		</div>
        
        <div class="form-group row">
		     <div class="col-sm-6">
            <?php $userId 	=$this->session->userdata('admin_user_id');
			if($userId==1){?>
				  <label for="form-field-9">Assined to CCC Admin</label>
			 <?php $ccadmin = getParentUsers('','1');?>
             <select class="form-control" placeholder="Select Admin" id="ccadmin" name="ccadmin">
			 <option value="">-Select CCC Admin-</option>
  		  		<?php foreach($ccadmin as $val){?>
				<option <?php if($val['user_id']==$get_user_details[0]['is_parent']){echo 'selected';}?> value="<?php echo $val['user_id'];?>"><?php  echo $val['user_name'];?></option>
			 	<?php }?>
			 </select>  
             <?php }?>

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
 