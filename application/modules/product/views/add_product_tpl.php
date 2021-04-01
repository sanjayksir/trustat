<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
 
 
<div class="main-container ace-save-state" id="main-container"> 
  <script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
  <?php $this->load->view('../includes/admin_sidebar');?>
  
  <div class="main-content">
 
    <div class="main-content-inner">
      <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo base_url(); ?>dashboard">Home</a> </li>
          <li class="active">Add Product SKU</li>
        </ul>
        <!-- /.breadcrumb --> <?php //echo $this->uri->segment(3); ?>
      </div>
      <div class="page-content">
        <div class="row">
          <div class="col-xs-12">
            <div class="row"><div style="clear:both;"><?php echo anchor('product/list_product/'.$this->uri->segment(3), 'List Product SKUs',array('class' => 'btn btn-primary pull-right')); ?></div>
              <div class="col-xs-12">
                <div class="accordion-style1 panel-group" id="accordion">
                  <div class="">
                   <!-- <h3 class="header smaller lighter blue">Add Product SKU</h3>-->
					
                    <form name="user_frm" id="user_frm" action="#" method="post">

        <div class="widget-main">
		<?php //$random_no = random_num(9);?>
        
        <div class="form-group row">
		     <div class="col-sm-6">
            <?php $userId 	=$this->session->userdata('admin_user_id');
			if($userId==1){?>
			<label for="form-field-9">You are Making the Product for <?php  echo getUserFullNameById($this->uri->segment(3)); ?></label>
				  <input name="ccadmin" id="ccadmin" type="hidden" value="<?php echo $this->uri->segment(3); ?>" class="form-control" >
				  <!--
			 <?php $ccadmin = getParentUsers('','1');?>
             <select class="form-control" placeholder="Select Admin" id="ccadmin" name="ccadmin">
			 <option value="">-Select CCC Admin-</option>
  		  		<?php foreach($ccadmin as $val){?>
				<option <?php if($val['user_id']==$get_user_details[0]['is_parent']){echo 'selected';}?> value="<?php echo $val['user_id'];?>"><?php  echo $val['user_name'];?></option>
			 	<?php }?>
			 </select> 
				-->
             <?php }?>
 			</div> 
		</div>
        
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Brand Name</label>
			<input name="brand_name" id="brand_name" type="text" placeholder="Please enter Brand Name" class="form-control" >
 			</div>
			
			
			<div class="col-sm-4">
			<label for="form-field-8">Customer ERP Product ID</label>
			<input name="customer_erp_product_id" id="customer_erp_product_id" type="text" placeholder="Please enter Product Name" class="form-control" >
 			</div>
			
  		</div>
		
        
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Product SKU Name</label>
			<input name="product_name" id="product_name" type="text" placeholder="Please enter Product Name" class="form-control" >
 			</div>
             
            <div class="col-sm-4">
            <label for="form-field-8">Generate Product SKU</label>
         		<input name="product_sku" id="product_sku" readonly="readonly" placeholder="Please click the following button to Create SKU" class="form-control" type="text">
			</div>
           <div class="col-sm-1 center"> <br>
             <input  value="Create SKU" id="GenerateSKU" class="btn btn-info" name="GenerateSKU" type="button" onclick="return genrateSku();">
          </div>
  		</div>
		
		
		<div class="form-group row">
			<div class="col-sm-3 ind_1">
			<label for="form-field-8">Product Industry</label>
			<select  name="industry[]" id="industry" class="form-control" onchange="get_sub_industry(this.value,'2');" required>
           <option value="">-Select Industry-</option>
            <?php foreach(getAllCategory('0') as $val){?>
				<option value="<?php echo $val['category_Id'];?>"><?php  echo $val['categoryName'];?></option> 
			<?php }?>
            <option value="other">Other</option>
            </select>
			</div>
            
            <div class="col-sm-3 ind_2" style="display:none;">
			<label for="form-field-8">Industry (Level-1)</label>
			<select  name="industry[]" id="industry_2" class="form-control" onchange="get_sub_industry(this.value,'3');">
            <option value="">-Select Industry (Level-1)-</option>
             </select>
			</div>
			
			<div class="col-sm-3 ind_3" style="display:none;">
			  <label for="form-field-8">Industry (Level-2)</label>
             <select name="industry[]" id="industry_3" class="form-control" onchange="get_sub_industry(this.value,'4');">
            <option value="">-Select Industry(Level-2)-</option>
             </select>
			</div>
			
			<div class="col-sm-3 ind_4" style="display:none;">
			<label for="form-field-8">Industry (Level-3)</label>
			<select  name="industry[]" id="industry_4" class="form-control" onchange="get_sub_industry(this.value,'5');">
            <option value="">-Select Industry (Level-3)-</option>
            
            </select>
			</div>
		</div>
		
		<div class="form-group" >
			<div class="col-sm-3  row ind_5" style="display:none;">
			<label for="form-field-8">Industry (Level-4)</label>
			<select  name="industry[]" id="industry_5" class="form-control" onchange="get_sub_industry(this.value,'6');">
            <option value="">-Select Industry (Level-4)-</option>
            
            </select>
			</div>
            
            <div class="col-sm-3 ind_6" style="display:none;">
			<label for="form-field-8">Industry (Level-5)</label>
			<select  name="industry[]" id="industry_6" class="form-control" onchange="get_sub_industry(this.value,'7');">
            <option value="">-Select Industry (Level-5)-</option>
             </select>
			</div>
			
			<div class="col-sm-3 ind_7" style="display:none;" >
		
			  <label for="form-field-8">Industry (Level-6)</label>
             <select name="industry[]" id="industry_7" class="form-control" onchange="get_sub_industry(this.value,'8');">
            <option value="">-Select Industry(Level-6)-</option>
             </select>
			</div>
			
			<div class="col-sm-3 ind_8" style="display:none;">
			<label for="form-field-8">Industry (Level-7)</label>
			<select  name="industry[]" id="industry_8" class="form-control" onchange="get_sub_industry(this.value,'9');">
            <option value="">-Select Industry (Level-7)-</option>
             
            </select>
			</div>
			
 		</div>
		
		
		
		<div class="form-group row" >
			<div class="col-sm-3 ind_9" style="display:none;">
			<label for="form-field-8">Industry (Level-8)</label>
			<select  name="industry[]" id="industry_9" class="form-control" onchange="get_sub_industry(this.value,'10');">
            <option value="">-Select Industry (Level-8)-</option>
            
            </select>
			</div>
		
			<div class="col-sm-3 ind_10" style="display:none;">
			<label for="form-field-8">Industry (Level-9)</label>
			<select  name="industry[]" id="industry_10" class="form-control" onchange="get_sub_industry(this.value,'11');">
            <option value="">-Select Industry (Level-9)-</option>
            
            </select>
			</div>
            
            <div class="col-sm-3 ind_11" style="display:none;">
			<label for="form-field-8">Industry (Level-10)</label>
			<select  name="industry[]" id="industry_11" class="form-control" onchange="get_sub_industry(this.value,'12');">
            <option value="">-Select Industry (Level-10)-</option>
             </select>
			</div>
			
			<div class="col-sm-3 ind_12" style="display:none;" >
			  <label for="form-field-8">Industry (Level-11)</label>
             <select name="industry[]" id="industry_12" class="form-control" onchange="get_sub_industry(this.value,'13');">
            <option value="">-Select Industry(Level-11)-</option>
             </select>
			</div>
  		</div>
		
		
		
		<div class="form-group row">
			<div class="col-sm-3 ind_13" style="display:none;">
			<label for="form-field-8">Industry (Level-12)</label>
			<select  name="industry[]" id="industry_13" class="form-control" onchange="get_sub_industry(this.value,'14');">
            <option value="">-Select Industry (Level-12)-</option>
             
            </select>
			</div>
			
			<div class="col-sm-3 ind_14" style="display:none;">
			<label for="form-field-8">Industry (Level-13)</label>
			<select  name="industry[]" id="industry_14" class="form-control" onchange="get_sub_industry(this.value,'15');">
            <option value="">-Select Industry (Level-13)-</option>
            
            </select>
			</div>
		
			<div class="col-sm-3 ind_15" style="display:none;">
			<label for="form-field-8">Industry (Level-14)</label>
			<select  name="industry[]" id="industry_15" class="form-control" onchange="get_sub_industry(this.value,'16');">
            <option value="">-Select Industry (Level-14)-</option>
            
            </select>
			</div>
            
            <div class="col-sm-3 ind_16" style="display:none;">
			<label for="form-field-8">Industry (Level-15)</label>
			<select  name="industry[]" id="industry_16" class="form-control" onchange="get_sub_industry(this.value,'17');">
            <option value="">-Select Industry (Level-15)-</option>
             </select>
			</div>
			
		
			 
 		</div>
		
		
		<div class="form-group row">
			<div class="col-sm-3 ind_17" style="display:none;" >
			  <label for="form-field-8">Industry (Level-16)</label>
             <select name="industry[]" id="industry_17" class="form-control" onchange="get_sub_industry(this.value,'18');">
            <option value="">-Select Industry(Level-16)-</option>
             </select>
			</div>
			
			<div class="col-sm-3 ind_18" style="display:none;" >
			  <label for="form-field-8">Industry (Level-17)</label>
             <select name="industry[]" id="industry_18" class="form-control" onchange="get_sub_industry(this.value,'19');">
            <option value="">-Select Industry(Level-17)-</option>
             </select>
			</div>
			
			<div class="col-sm-3  ind_19" style="display:none;" >
			<label for="form-field-8">Industry (Level-18)</label>
			<select  name="industry[]" id="industry_19" class="form-control" onchange="get_sub_industry(this.value,'20');">
            <option value="">-Select Industry (Level-18)-</option>
            
            </select>
			</div>
            
            <div class="col-sm-3 ind_20" style="display:none;" onchange="get_sub_industry(this.value,'21');">
			<label for="form-field-8">Industry (Level-19)</label>
			<select  name="industry[]" id="industry_20" class="form-control" >
            <option value="">-Select Industry (Level-19)-</option>
             </select>
			</div>
 		</div>
		
		 <?php 
            $listOpt = getAllProductName('');
            $listALLOpt = json_decode($listOpt,true);
          ?>
			<!-- <div class="form-group row" >
				<div class="col-sm-4">
				  <label for="form-field-8">Product Attributes (Press Ctrl key for multi-selection )<?php //echo $ParentName;?></label>
                  <select class="form-control" name="attr_level_1" id="attr_level_1" multiple="multiple" onClick="getChildAttr();">
				  <option value="">-Select Product-</option> 
				  	<?php //foreach($listALLOpt as $val){?>
					  		<option value="<?php //echo $val['product_id'];?>"><?php echo $val['name'];?></option> 
					<?php //}?>
                  </select>
				</div>
			
            
            <div class="col-sm-4" id="child_div" style="display:none;">
				  <label for="form-field-8">Attribute Level-2<?php //echo $ParentName;?></label>
                  <span id="child_attr"></span>
				</div>
			</div>	 				
      
         </div>-->
		 
		<!--------------------------------- Essential attributes-----------------------------------> 
		
		
  
		<fieldset>
			<legend>Bar Code Management</legend>
			<div class="form-group row">
			<div class="col-sm-4">
				<label for="form-field-8">Barcode Type – Line Barcode or QR</label>
				<select name="code_type" id="code_type" class="form-control" onchange="showDiv4(this)">
				 <option value="barcode">Barcode</option>
				 <option value="qrcode" selected>Qrcode</option>
				</select>
				<script type="text/javascript">
				function showDiv4(select){
				   if(select.value=="barcode"){
					document.getElementById('hidden_div4').style.display = "block";
				   } else{
					document.getElementById('hidden_div4').style.display = "none";
				   }
				} 
			</script>
  			</div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Code Activation Type – Pre or Post</label>
				<select name="code_activation_type" id="code_activation_type" class="form-control">
					<!--<option value="1">Pre-Activated</option>	-->
					<option value="0">Post-Activated</option>	
								 
				</select>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8"> Method of Delivery – Printing by Super/CCC Admin</label>
				<select name="delivery_method" id="delivery_method" class="form-control">
				 <option value="1">Physical Printing by Super Admin</option>
				 <option value="2">Physical Printing by CCC Admin</option>
				<!-- <option value="3">Physical Printing by Designated Plant Controller</option>
				 <option value="4">E-Mode Deliver</option>-->
				</select>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Code Key Type – Serial or Random</label>
				<select name="code_key_type" id="code_key_type" class="form-control">
				 <option value="serial"> Serial Unique</option>
				 <option value="random">Random Unique</option> 
				</select>
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Code Unity Type – Single or Twin</label>
				<select name="code_unity_type" id="code_unity_type" class="form-control" onchange="showDiv6(this)">
				 <option value="Single">Single</option>
				 <option value="Twin">Twin</option>
				</select>
				<script type="text/javascript">
				function showDiv6(select){
				   if(select.value=="Twin"){
					document.getElementById('hidden_div6').style.display = "block";
				   } else{
					document.getElementById('hidden_div6').style.display = "none";
				   }
				} 
			</script>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Show Code Below Printed Bar/QR Code</label>
				<select name="show_code_below_printed_bar_qr_code" id="show_code_below_printed_bar_qr_code" class="form-control">
				 <option value="Yes">Yes</option>
				 <option value="No">No</option>
				</select>
 		    </div>
			</div>
		</fieldset>
          
		
		  <fieldset>
			<legend>Packaging Level Management</legend>
          <div class="form-group row"> 			
			<div class="col-sm-4">
				<label for="form-field-8">Print codes in Batches?</label>
			<select name="print_codes_in_batches" id="print_codes_in_batches" class="form-control" onchange="showDiv5(this)">
				<option value="Yes">Yes</option>
				<option value="No"selected>No</option>
			</select>
			<script type="text/javascript">
				function showDiv5(select){
				   if(select.value=="Yes"){
					document.getElementById('hidden_div5').style.display = "block";
				   } else{
					document.getElementById('hidden_div5').style.display = "none";
				   }
				} 
			</script>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Registration Pack</label>
				<select name="registration_pack" id="registration_pack" class="form-control">
				 <option value="Yes">Yes</option>
				 <option value="No">No</option> 
				</select>
 		    </div>

		<div class="col-sm-4">
				<label for="form-field-8">Retailer Pack</label>
				<select name="retailer_pack" id="retailer_pack" class="form-control">
				 <option value="Yes">Yes</option>
				 <option value="No">No</option> 
				</select>
 		    </div>

		<div class="col-sm-4">
				<label for="form-field-8">Min Shipper Pack Level </label>
				<input type="number" name="min_shipper_pack_level" min="2" step="1" id="min_shipper_pack_level" class="form-control" value="2" />
				<!--
				<select name="min_shipper_pack_level" id="min_shipper_pack_level" class="form-control">
				 <option value="Single">Single</option>
				 <option value="Twin">Twin</option>
				 -->
				</select>
 		    </div>

			<div class="col-sm-4">
				<label for="form-field-8">Max Shipper Pack Level </label>
				<input type="number" name="max_shipper_pack_level" min="2" step="1" id="max_shipper_pack_level" class="form-control" value="2" />
				<!--
				<select name="max_shipper_pack_level" id="max_shipper_pack_level" class="form-control">
				 <option value="serial"> Serial Unique</option>
				 <option value="random">Random Unique</option> 
				</select>-->
 		    </div>

			<div class="col-sm-4">
				<label for="form-field-8">Max Packaging Level Product Pack</label>
				<input type="number" name="max_packaging_level_product" min="2" step="1" id="max_packaging_level_product" class="form-control" value="2" />
 		    </div>
			
  		</div> 
		</fieldset>
		
		 <fieldset>
			<legend>Code Size and Message Printing Management</legend>
				<div class="form-group row"> 
			<div class="col-sm-4">
				<label for="form-field-8">Text Font Size</label>
				<input type="number" name="TextFontSize" id="TextFontSize"  min="3" step=".01" max="50" value="7" placeholder="in mm" class="form-control" />
 		    </div> 
			
			
			<div class="col-sm-4">
				<label for="form-field-8">Size of the Code (mm)</label>				
				<input type="number" name="code_size" min="3" max="300" step="0.01" value="15" id="code_size" class="form-control" />
 		    </div>
			
			<div class="col-sm-4" id="hidden_div4" style="display:none;">
				<label for="form-field-8">Height of Barcode(mm) </label>
				<input type="text" name="height_of_the_bar_code" id="height_of_the_bar_code" value="10" placeholder="How much Space do you need between twin Codes(mm)" class="form-control" />
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Space for Message above the Code(mm)</label>
				<input type="number" name="space_for_message_above_code" id="space_for_message_above_code"  min="1" step=".01" max="50" value="2" placeholder="in mm" class="form-control" />
 		    </div>
			
           <div class="col-sm-4">
				<label for="form-field-8">Message print above the Code</label>
				<input type="text" name="message_above_code" id="message_above_code" placeholder="Please enter the message to be print above the Code" class="form-control" />
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Space for Message below the Code(mm)</label>
				<input type="number" name="space_for_message_below_code" id="space_for_message_below_code"  min="1" step=".01" max="50" value="6" placeholder="in mm" class="form-control" />
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Message print below the Code</label>
				<input type="text" name="message_below_code" id="message_below_code" placeholder="Please enter the message to be print below the Code" class="form-control" />
 		    </div>
			
			<div class="col-sm-4" id="hidden_div5" style="display:none;">
				<label for="form-field-8">Space for Code below BatchID(mm)</label>
				<input type="number" name="space_for_code_below_batchid" id="space_for_code_below_batchid"  min="1" step=".01" max="5000" value="6" placeholder="in mm" class="form-control" />
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Space between Code Rows</label>
				<input type="number" name="space_between_code_rows" id="space_between_code_rows"  min="1" step=".01" max="50" value="20" placeholder="in mm" class="form-control" />
 		    </div>
			
  		</div>
		</fieldset>
		
		<div id="hidden_div6" style="display:none;">
		<fieldset>
			<legend>Twin Codes Management</legend>
		<div class="form-group row">  
			
			<div class="col-sm-4">
				<label for="form-field-8">Message above Secondary Code of twin</label>
				<input type="text" name="message_above_secondry_code" id="message_above_secondry_code" value="" placeholder="Please enter the Message above Secondary Code of twin" class="form-control" />
 		    </div> 
			<div class="col-sm-4">
				<label for="form-field-8">Message Below Secondary Code of twin</label>
			<input type="text" name="message_below_secondry_code" id="message_below_secondry_code" value="" placeholder="Please enter the Message above Secondary Code of twin" class="form-control" />
 		    </div>
			<div class="col-sm-4">
				<label for="form-field-8">Space for Message above Sec. Code of twin(mm)</label>
			<input type="number" name="space_for_message_above_secondry_code" id="space_for_message_above_secondry_code"  min="-10" step=".01" max="50" value="1" placeholder="in mm" class="form-control" />
 		    </div>
			<div class="col-sm-4">
				<label for="form-field-8">Space for Message Below Sec.  Code of twin(mm)</label>
			<input type="number" name="space_for_message_below_secondry_code" id="space_for_message_below_secondry_code"  min="1" step=".01" max="50" value="35" placeholder="in mm" class="form-control" />
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Space between QR Code and Barcode(mm) </label>
				<input type="text" name="space_between_twin_code" id="space_between_twin_code" placeholder="How much Space do you need between twin Codes(mm)" value="50" class="form-control" />
 		    </div>
			 
  		</div>		
		</fieldset>
		</div>
		<fieldset>
			<legend>Super Loyalty Management</legend>
		<div class="form-group row"> 

			<div class="col-sm-4">
				<label for="form-field-8">Include the Product in Super Loyalty</label>
			<select name="include_the_product_in_super_loyalty" id="include_the_product_in_super_loyalty" class="form-control" onchange="showDiv(this)">
				<option value="Yes">Yes</option>
				<option value="No" selected>No</option>
				</select>
			</div>	
			<script type="text/javascript">
				function showDiv(select){
				   if(select.value=="Yes"){
					document.getElementById('hidden_div').style.display = "block";
				   } else{
					document.getElementById('hidden_div').style.display = "none";
				   }
				} 
			</script>
			<div id="hidden_div" style="display:none;">			
			<div class="col-sm-4">
				<label for="form-field-8">Super Loyalty trigger every... times Scan</label>
				<input type="number" name="number_of_scans_for_super_loyalty" min="0" step="1" value="0" id="number_of_scans_for_super_loyalty" class="form-control" required />				
 		    </div> 
			<div class="col-sm-4">
				<label for="form-field-8">Number of Loyalty Points for Super Loyalty</label>
				<input type="number" name="number_of_loyalty_points_for_super_loyalty" min="0" step="1" value="0" id="number_of_loyalty_points_for_super_loyalty" class="form-control" required />				
 		    </div> 
			
			<div class="form-group row"> 
			<div class="col-sm-8">
				<label for="form-field-8">APP Notification Message for Super Loyalty</label>
			<input type="text" name="app_notification_message_for_super_loyalty" id="app_notification_message_for_super_loyalty" value="." placeholder="Please Enter APP Notification Message for Super Loyalty" class="form-control" />
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">APP Passbook On Screen Display Message</label>
			<input type="text" name="app_passbook_on_screen_display_message _sl" id="app_passbook_on_screen_display_message _sl" value="." placeholder="APP Passbook On Screen Display Message for Super Loyalty" class="form-control" />			
 		    </div> 
			</div>
			
			 </div>
			
  		</div>
		
		</fieldset>
		
		<fieldset>
		<legend>Referral Program Management</legend>
		
		<div class="col-sm-4">
				<label for="form-field-8">Include the Product in Referral Program</label>
			<select name="include_the_product_in_referral_program" id="include_the_product_in_referral_program" class="form-control" onchange="showDiv2(this)">
				<option value="Yes">Yes</option>
				<option value="No" selected>No</option>
				</select>
			</div>
			<script type="text/javascript">
				function showDiv2(select){
				   if(select.value=="Yes"){
					document.getElementById('hidden_div2').style.display = "block";
				   } else{
					document.getElementById('hidden_div2').style.display = "none";
				   }
				} 
			</script>
			<div id="hidden_div2" style="display:none;">
			<div class="col-sm-4">
				<label for="form-field-8">Gap Period(Days) for last activity of Receiver</label>
				<input type="number" name="gap_period_for_last_activity_of_existing_consumer" min="0" step="1" id="gap_period_for_last_activity_of_existing_consumer" class="form-control" value="0" required />
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Loyalty rewards to sender under Referral</label>
				<input type="number" name="loyalty_rewards_to_sender_consumer_under_referral" min="0" step="1" id="loyalty_rewards_to_sender_consumer_under_referral" class="form-control" value="0" required />
 		    </div>
  		
		<div class="form-group row">            
			<div class="col-sm-4">
				<label for="form-field-8">Media Type for Sending Reference</label>
			<select name="media_type_for_sending_reference" id="media_type_for_sending_reference" class="form-control">
				<option value="Video">Video</option>
				<option value="Audio">Audio</option>
				<option value="Image">Image</option>
				<option value="PDF">PDF</option>
				<option value="CustomMessage">Custom Message</option>
				</select>
			
			</div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Max Referrals for the product</label>
				<input type="number" name="max_referrals_for_product" min="0" step="1" value="0" id="max_referrals_for_product" class="form-control" required />				
 		    </div> 
			
			<div class="col-sm-4">
				<label for="form-field-8">Number of Referrals allowed by a Consumer</label>
				<input type="number" name="number_of_referrals_allowed_to_consumer" min="0" step="1" value="0" id="number_of_referrals_allowed_to_consumer" class="form-control" required />				
 		    </div> 
			
			
			
			
  		</div>
		
		<div class="form-group row">            
			<div class="col-sm-4">
				<label for="form-field-8">Referral Program Auto Off Date(mm/dd/yyyy)<?php 
					//$date = "04/15/2013";
					//$date1 = str_replace('-', '/', $date);
					//$tomorrow = date('m-d-Y',strtotime($date1 . "+1 days"));
					//$TodayDate = date("d/m/Y");
					//$TmorrowDate = 
					$datetime = new DateTime('tomorrow');
					$tomorrow = $datetime->format('d/m/Y');
				?></label>
			<div class="input-group date" data-provide="datepicker">
                <input type="text" name="referral_program_auto_off_date" id="referral_program_auto_off_date" value="<?php echo $tomorrow; ?>" class="form-control">
                      <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                                  </div>
                           </div>
			</div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Msg. Displayed To Sender upon Sending Ref. </label>
				<input type="text" name="custom_message_for_sending_reference" id="custom_message_for_sending_reference" value="." placeholder="Message Displayed To Sender upon Sending Reference" class="form-control" />
				</div>
				
			<div class="col-sm-4">
				<label for="form-field-8">Message for receiver of Reference</label>
				<input type="text" name="message_for_receiver_of_reference" id="message_for_receiver_of_reference" value="." placeholder="Message for receiver of Reference" class="form-control" />
				</div>
				
				
				<div class="col-sm-4">
				<label for="form-field-8">Send Referral message from server</label>
			<select name="send_ref_message_frm_server" id="send_ref_message_frm_server" class="form-control" onchange="showDiv7(this)">
				<option value="Yes">Yes</option>
				<option value="No">No</option>
				</select>			
			</div>
			<script type="text/javascript">
				function showDiv7(select){
				   if(select.value=="Yes"){
					document.getElementById('hidden_div7').style.display = "block";
				   } else{
					document.getElementById('hidden_div7').style.display = "none";
				   }
				} 
			</script>
			<div id="hidden_div7">
			<div class="col-sm-8">
				<label for="form-field-8">Message for receiver of Reference from Server</label>
				<input type="text" name="include_the_product_in_referral_program" placeholder="Please provide the Message for receiver of Reference from Server" id="include_the_product_in_referral_program" class="form-control" />
 		    </div>
			</div>
  		</div>
		</div>		
	</fieldset>	
	<br /><br />
	<fieldset>
		<legend>Product Warranty Management</legend>
		
		<div class="form-group row">  
		<!--		
			<div class="col-sm-4">
				<label for="form-field-8">Media Type for Sending Reference</label>
			<select name="media_type_for_sending_reference" id="media_type_for_sending_reference" class="form-control">
				<option value="Video">Video</option>
				<option value="Audio">Audio</option>
				<option value="Image">Image</option>
				<option value="PDF">PDF</option>
				<option value="CustomMessage">Custom Message</option>
				</select>			
			</div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Max Referrals for the product</label>
				<input type="number" name="max_referrals_for_product" min="0" step="1" value="0" id="max_referrals_for_product" class="form-control" required />				
 		    </div> 
			-->
			<div class="col-sm-4">
				<label for="form-field-8">Product Warranty in Days(0 Stands Without Warranty)</label>
				<input type="number" name="warranty_in_days" min="0" step="1" value="0" id="warranty_in_days" class="form-control" required />				
 		    </div> 
  		</div>
	</fieldset>		
		
		<div style="color:red">Note*- You must must need to add at least 1 attribute for this product to make it working.</div> 
		<!--------------------------------- Essential attributes-----------------------------------> 
		 <hr>
		  <div class="form-group row">
			<div class="col-sm-4">
			
			<!--<input type=submit value="Print All" onClick="getChildAttr()">-->
           <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
            <input class="btn btn-info" type="submit" name="submit" value="Save Product" id="savemenu" />
           </div>
		   </div>
		   </div>
         </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row --> 
      </div>
      <!-- /.page-content --> 
    </div>
  </div><div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						 


						&nbsp; &nbsp;
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
					</div>
				</div>
			</div>
  <!-- /.main-content -->
 </div>
<!-- /.main-container --> 
  <script>
  function getChildAttr(){ 
	//var data = $("#all_childs").val(); //add = 34332;
 	var obj = user_frm.attr_level_1,
	options = obj.options, 
	selected = [], i, str;
     for (i = 0; i < options.length; i++) {
        options[i].selected && selected.push(obj[i].value);
    }
     str = selected.join();
     //alert("Options selected are " + str);
 	$.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>product/getChildsDD/",
		data: {id :str},
 		success: function (msg) {
			$("#child_div").show(); 
			$("#child_attr").html(msg);
		} 
	});	
}
 
 
 function genrateSku(){
	var skuFld = $("#product_sku").val();
	var productname =  $("#product_name").val();
	$.ajax({
 				type: "POST",
 				beforeSend: function(){
 						 $("#product_sku").val('generating sku..');
 				},
 				url: "<?php echo base_url(); ?>product/genate_sku/",
				data: {"name":productname},	
 				success: function (msg) {
					$("#product_sku").val(msg);
				} 
 			}); 
 }
<!------------------------ Validate Fom Add Menu Data----------------------------->
 $(document).ready(function(){	
 	 $.validator.addMethod("specialChrs", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Product must contain only letters, numbers, or dashes.");
	$("form#user_frm").validate({
		rules: {
			ccadmin: {
			 	 required: true
						},
			brand_name: {
			 	 required: true
						},
			max_packaging_level_product: {
			 	 required: true
						},			
			
   			product_name:{
 						 required: true,
 						 remote: {
                        	url: "<?php echo base_url().'product/';?>checkProductExists",
                          	type: "post",
 							data: {  name: $("#product_name").val()}
                     	 },
						 specialChrs: true,
 					  },
			customer_erp_product_id:{
 						 required: true,
 						 remote: {
                        	url: "<?php echo base_url().'product/';?>checkCustomerERPProductID",
                          	type: "post",
 							data: {  name: $("#customer_erp_product_id").val()}
                     	 },
						 specialChrs: true,
 					  },		  
			referral_program_auto_off_date:{
 						 required: true,
 						 remote: {
                        	url: "<?php echo base_url().'product/';?>checkDateMoreThanToday",
                          	type: "post",
 							data: {  name: $("#referral_program_auto_off_date").val()}
                     	 },
 					  },		  
			 product_sku: {
						required: true
        			 },
					 
			attr_level_1: {
			 	 required: true
						}						
				},
 			messages: {
					ccadmin: {
						required: "Please select ccc-admin." 
					},
 					industry:    {
						required: "Please select Industry"
					},
					
					product_name: {
						required: "Please enter Product Name",
						remote: "Product Name Aready exists!"						
					},
					
					customer_erp_product_id: {
						required: "Please enter Customer ERP Product ID",
						remote: "Customer ERP Product ID Aready exists!"						
					},
					
					referral_program_auto_off_date:{
						required: "Please enter Referral Program Auto Off Date",
						remote: "Auto Off Date date can not be today or past date!"						
					},
					product_sku: {
						required: "Product SKU Required"
        			 }
   		},
		submitHandler: function(form) {
		
		if (confirm("Are you sure save Product SKU!"))
        {
        }else{
      		return false;
        }
		
		
 			var formData;
			var dataSend 	= $("#user_frm").serialize();
			formData 		= new FormData();
 			var formData = new FormData(form); 
  			$.ajax({
				type: "POST",
				//dataType:"json",
				//mimeType: "multipart/form-data",
				beforeSend: function(){
				
						//$(".show_loader").show();
 						//$(".show_loader").click();
				},
				url: "<?php echo base_url(); ?>product/save_product/",
				data: formData,
				async: false,
				cache: false,	
				contentType: false,  // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
				processData: false, // NEEDED, DON'T OMIT THIS	
 				success: function (msg) { 
					if(parseInt(msg)==1){
						window.location.href="<?php if($this->session->userdata('admin_user_id')==1){ echo base_url().'product/list_product/'.$this->uri->segment(3); }else { echo base_url().'product/list_product'; }?>";
					}
				},
				complete: function(){
					//$(".show_loader").hide();
				}
			});
  		}
	});
});
  
 function get_sub_industry(cid,level){
 	 if(level==2){
	 	 $(".ind_2").show();
 		 $("#industry_3").html('<option value="0">-Select Industry-</option>');
	 }
	 if(level){
	 	 $(".ind_"+level).show();
	 }
	
	if(cid=='other'){
		 $(".ind_"+level).hide();
		 if(level==2){
			 var labelId = "#industry";
		 }else{
			 var labelId = "#industry_"+(level-1);
		 }
		$(labelId).after('<input placeholder="Add Industry" type="text" name="textbox_'+level+'" class="industryTxt form-control" style="margin-top:3px;"><input type="text" name="remarkbox"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">');
		return false;
	}else{
	$(".industryTxt").remove();
	 $.ajax({
				type: "POST",
				beforeSend: function(){
					var opt = '<option value="0">-Loading Industry...-</option>';
					$("#industry_"+level).html(opt);
				},
				url: "<?php echo base_url(); ?>product/getSubCategory/",
				data: {id:cid,lev:level},	
  				success: function (msg) { 
					$("#industry_"+level).html(msg);
				} 
			});
	}
 }
  </script>
<?php $this->load->view('../includes/admin_footer');?>
 