<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');
//echo '<pre>';print_r($product_data);exit;
$dt = $product_data[0];
$attr_list = implode(',',json_decode($dt['attribute_list'],true));
$id_parents = getParent_fromChilds($attr_list);
//echo '<pre>';print_r($id_parents);exit;

## get Other Industry Value
$isOtherIndustry = '';
$isOtherIndustry = $dt['other_industry'];
if(!empty($isOtherIndustry)){
	$otherIndustry 			= explode('-||-',$isOtherIndustry);
	$textBox_name 			=  $otherIndustry[0];
	$dropDown_position_str 	= str_replace('textbox_','',$textBox_name); 
	$value		 			=  getOtherIndustryData($otherIndustry[1]);
	$testbox_value			= $value['industry_name'];
	$remarkbox				= $value['remark'];
}
?>
 
 
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
          <li class="active">Manage Product Attributes</li>
        </ul>
        <!-- /.breadcrumb --> 
      </div>
      <div class="page-content">
        <div class="row">
          <div class="col-xs-12">
            <div class="row"><div style="clear:both;"><?php echo anchor('product/list_product', 'List Product',array('class' => 'btn btn-primary pull-right')); ?></div>
              <div class="col-xs-12">
                <div class="accordion-style1 panel-group" id="accordion">
                  <div class="">
                  <!--  <h3 class="header smaller lighter blue">Select Product Attributes </h3>-->
					
                    <form name="user_frm" id="user_frm" action="#" method="post">
					<input type="hidden" name="id" value="<?php echo $this->uri->segment(3)?>" id="id" />
                    <div class="widget-main">
                  <?php $industry_arr = json_decode($dt['industry_data'],true);// echo '<pre>';  print_r($industry_arr);exit; 	
					?>
        
        <!-- <div class="form-group row">
		     <div class="col-sm-6"> 
            <?php $userId 	=$this->session->userdata('admin_user_id');
			if($userId==1){?>
				  <label for="form-field-9">Assined to CCC Admin</label>
			 <?php $ccadmin = getParentUsers('','1');?>
             <select class="form-control" placeholder="Select Admin" id="ccadmin" name="ccadmin">
			 <option value="">-Select CCC Admin-</option>
  		  		<?php foreach($ccadmin as $val){?>
				<option <?php if($val['user_id']==$dt['created_by']){echo 'selected';}?> value="<?php echo $val['user_id'];?>"><?php  echo $val['user_name'];?></option>
			 	<?php }?>
			 </select>  
             <?php }?>

 			<!--</div> 
		</div>-->
		
        
        <!--------------------------------- Category Listing------------------------------ -->
       
        <?php 
            //$listOpt = getAllProductName('');
			
			$json = $dt['industry_data'];
			$jset = json_decode($json, true);
			//echo $jset[0];
			
			$listOpt = getAllAttributeNamesAssignedIndustryWise($jset[0]);
            $listALLOpt = json_decode($listOpt,true);
          ?> 
         <div class="form-group row">
				<div class="col-sm-4">
				  <label for="form-field-8">Parent Attributes (Press Ctrl for multi-selection)<?php //echo $ParentName;?></label>
                  <select class="form-control" name="attr_level_1" multiple="multiple" onClick="getChildAttr();" size="10" style="height: 100%;">
				  <!--<option value=""><b>-Select Parent Attribute-</b></option> -->
				  	<?php foreach($listALLOpt as $val){?>
					  		<option <?php if(in_array($val['product_id'],$id_parents)){echo 'selected="selected"';}?> value="<?php echo $val['product_id'];?>"><?php echo $val['name'];?></option> 
					<?php }?>
                  </select>
				</div>
			
            
            <div class="col-sm-4" id="child_div" style="display:none;">
				  <label for="form-field-8">Child Attributes (Press Ctrl select 1 Child for 1 Parent)<?php //echo $ParentName;?></label>
                  <span id="child_attr"></span>
				</div>
			</div>		
          
             
         </div>
         
         <!--------------------------------- Essential attributes-----------------------------------> 
		  
		<!--------------------------------- Essential attributes-----------------------------------> 
         
         <hr>
		<div class="form-group row">
			<div class="col-sm-4">
          		<div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">
            		<input class="btn btn-info" type="submit" name="submit" value="Save Menu" id="savemenu" />
           		</div>
            </div>
        </div>
       </form>
       <input type="hidden" name="childs_selected" id="childs_selected" value="<?php echo $attr_list;?>" />
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
function getChildAttr(parent='', childs=''){ 
	//var data = $("#all_childs").val(); //add = 34332;
	var child_id='';
 	var obj = user_frm.attr_level_1,
	options = obj.options, 
	selected = [], i, str;
     for (i = 0; i < options.length; i++) {
        options[i].selected && selected.push(obj[i].value);
    }
     str = selected.join();
	 if(parent!=''){
		 str = parent
	 }
	 if(childs!=''){
		 child_id = childs;
	 }else{
		 child_id = $("#childs_selected").val()
	 }
	 
     //alert("Options selected are " + str);
 	$.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>product/getChildsDD/",
		data: {id :str,child:child_id},
 		success: function (msg) {
			$("#child_div").show(); 
			$("#child_attr").html(msg);
		} 
	});	
}

getChildAttr('<?php echo implode(',',$id_parents); ?>',$("#childs_selected").val());

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
		   
			attr_level_1: {
			 	 required: true
						},				
						

 		},
		submitHandler: function(form) {
 			var formData;
			var dataSend 	= $("#user_frm").serialize();
			formData 		= new FormData();
 			var formData = new FormData(form); 
  			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>product/save_product_attributes/",
				data: formData,
				async: false,
				cache: false,	
				contentType: false,  // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
				processData: false, // NEEDED, DON'T OMIT THIS	
 				success: function (msg) { 
					if(parseInt(msg)==1){
						window.location.href="<?php echo base_url().'product/list_product';?>";
					}
				}
			});
  		}
	});
});
  

 
 </script>
<?php $this->load->view('../includes/admin_footer');?>
<!----- ADD Service Code ----> 

<!------ ADD Service Code-----------> 