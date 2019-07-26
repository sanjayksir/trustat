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
        <!-- /.breadcrumb --> 
      </div>
      <div class="page-content">
        <div class="row">
          <div class="col-xs-12">
            <div class="row"><div style="clear:both;"><?php echo anchor('product/list_product', 'List Product SKUs',array('class' => 'btn btn-primary pull-right')); ?></div>
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
        
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Brand Name</label>
			<input name="brand_name" id="brand_name" type="text" class="form-control" >
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
		
		
		
      
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Product SKU Name</label>
			<input name="product_name" id="product_name" type="text" class="form-control" >
 			</div>
             
            <div class="col-sm-4">
            <label for="form-field-8">Generate Product SKU</label>
         		<input name="product_sku" id="product_sku" readonly="readonly" class="form-control" maxlength="100" type="text">
			</div>
           <div class="col-sm-1 center"> <br>
             <input  value="Create SKU" id="GenerateSKU" class="btn btn-info" name="GenerateSKU" type="button" onclick="return genrateSku();">
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
			</div>	 -->				
      
         </div>
		 
		<!--------------------------------- Essential attributes-----------------------------------> 
		  <div class="form-group row">
          <div class="col-sm-4">
				<label for="form-field-8">Code type in printing</label>
				<select name="code_type" id="code_type" class="form-control">
				 <option value="barcode">Barcode</option>
				 <option value="qrcode">Qrcode</option>
				</select>
  			</div>
			<div class="col-sm-4">
				<label for="form-field-8">Code Activation Type</label>
				<select name="code_activation_type" id="code_activation_type" class="form-control">
					<!--<option value="1">Pre-Activated</option>	-->
					<option value="0">Post-Activated</option>	
								 
				</select>
 		    </div>
            <div class="col-sm-4">
				<label for="form-field-8">Methods of Delivery</label>
				<select name="delivery_method" id="delivery_method" class="form-control">
				 <option value="1">Physical Printing by Super Admin</option>
				 <option value="2">Physical Printing by CCC Admin</option>
				 <option value="3">Physical Printing by Designated Plant Controller</option>
				 <!--<option value="4">E-Mode Deliver</option>-->
				</select>
 		    </div> 
          </div>   
          <div class="form-group row"> 
           <div class="col-sm-4">
				<label for="form-field-8">Code Key Type</label>
				<select name="code_key_type" id="code_key_type" class="form-control">
				 <option value="serial"> Serial Unique</option>
				 <option value="random">Random Unique</option> 
				</select>
 		    </div> 
            
            <div class="col-sm-4">
				<label for="form-field-8">Size of the Code</label>
				<select name="code_size" id="code_size" class="form-control">
				 <option value="S">Small</option>
				 <option value="M">Medium</option>
				 <option value="L">Large</option>
				</select>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Code Unity Type</label>
				<select name="code_unity_type" id="code_unity_type" class="form-control">
				 <option value="Single">Single</option>
				 <option value="Twin">Twin</option>
				</select>
 		    </div>
  		</div> 
		<div class="form-group row"> 
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
  		</div>
		<div class="form-group row"> 
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
				<label for="form-field-8">Number of Scans for Super Loyalty</label>
				
				<select name="number_of_scans_for_super_loyalty" id="number_of_scans_for_super_loyalty" class="form-control">
				 <option value="5"> 5 </option>
				 <option value="100"> 100 </option>
				 <option value="500"> 500 </option>
				 <option value="1000"> 1000 </option>
				 <option value="2000"> 1000 </option>
				 <option value="5000"> 5000 </option>
				 <option value="10000"> 10,000 </option> 
				</select>
 		    </div> 
			<div class="col-sm-4">
				<label for="form-field-8">Number of Loyalty Points for Super Loyalty</label>
				<input type="number" name="number_of_loyalty_points_for_super_loyalty" min="2" step="1" id="number_of_loyalty_points_for_super_loyalty" class="form-control" required />
				<!--
				<select name="max_shipper_pack_level" id="max_shipper_pack_level" class="form-control">
				 <option value="serial"> Serial Unique</option>
				 <option value="random">Random Unique</option> 
				</select>-->
 		    </div> 
  		</div>
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
								
		   	 
			
   			product_name:{
 						 required: true,
 						 remote: {
                        	url: "<?php echo base_url().'product/';?>checkProductExists",
                          	type: "post",
 							data: {  name: $("#product_name").val()}
                     	 } ,
						 specialChrs: true,
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
						required: "Please enter Product Name"
						
					} ,
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
						window.location.href="<?php echo base_url().'product/list_product';?>";
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
 