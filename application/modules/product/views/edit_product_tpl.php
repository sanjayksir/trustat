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
          <li class="active">Manage Product</li>
        </ul>
        <!-- /.breadcrumb --> 
      </div>
      <div class="page-content">
        <div class="row">
          <div class="col-xs-12">
            <div class="row"><div style="clear:both;"><?php echo anchor('product/list_product', 'List Product',array('class' => 'btn btn-primary pull-right')); ?></dv>
              <div class="col-xs-12">
                <div class="accordion-style1 panel-group" id="accordion">
                  <div class="">
                    <h3 class="header smaller lighter blue">Edit Product</h3>
					
                    <form name="user_frm" id="user_frm" action="#" method="post">
					<input type="hidden" name="id" value="<?php echo $this->uri->segment(3)?>" id="id" />
                    <div class="widget-main">
                  <?php $industry_arr = json_decode($dt['industry_data'],true);// echo '<pre>';  print_r($industry_arr);exit;
					
					?>
        
         <div class="form-group row">
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

 			</div> 
		</div>
		
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Brand Name</label>
			<input value="<?php echo $dt['brand_name'];?>" type="text" name="brand_name" id="brand_name" class="form-control" >
 			</div>
             <!--
            <div class="col-sm-4">
            <label for="form-field-8">Product SKU</label>
         		<input value="<?php //echo $dt['product_sku'];?>" readonly="readonly" class="form-control" maxlength="100" type="text">
			</div>
           -->
     
 		</div>
		
		<div class="form-group row">
			<div class="col-sm-3">
			<label for="form-field-8">Industry</label>
			<select  name="industry[]" id="industry" class="form-control" onchange="get_sub_industry(this.value,'2');" required>
            <option value="">-Select Industry-</option>
            <?php foreach(getAllCategory('0') as $val){?>
				<option <?php if($industry_arr[0]==$val['category_Id']){echo 'selected';}?> value="<?php echo $val['category_Id'];?>"><?php  echo $val['categoryName'];?></option> 
			<?php }?>
            </select>
           <?php  if($dropDown_position_str==2){?>
            	<input type="text" name="textbox_2" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_2" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
            
			</div>
            
            <div class="col-sm-3 ind_2">
			<label for="form-field-8">Industry (Level-1)</label>
			<select  name="industry[]" id="industry_2" class="form-control" onchange="get_sub_industry(this.value,'3');">
            <option value="">-Select Industry-</option>
			<option selected="selected" value="<?php echo $industry_arr[1];?>"><?php $result = get_industry_by_id($industry_arr[1]); echo $result[0]['categoryName'];?></option> 
              </select>
               <?php  if($dropDown_position_str==3){?>
            	<input type="text" name="textbox_3" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_3" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			
			<div class="col-sm-3 ind_3">
			  <label for="form-field-8">Industry (Level-2)</label>
             <select name="industry[]" id="industry_3" class="form-control" onchange="get_sub_industry(this.value,'4');">
            <option value="">-Select Industry-</option>
			<option selected="selected" value="<?php echo $industry_arr[2];?>"><?php $result = get_industry_by_id($industry_arr[2]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==4){?>
            	<input type="text" name="textbox_4" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_4" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
            
            <div class="col-sm-3 ind_4" >
			<label for="form-field-8">Industry (Level-3)</label>
			<select  name="industry[]" id="industry_4" class="form-control" onchange="get_sub_industry(this.value,'5');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[3];?>"><?php $result = get_industry_by_id($industry_arr[3]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==5){?>
            	<input type="text" name="textbox_5" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_5" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
 		</div>
        
        <!--------------------------------- Category Listing------------------------------ -->
         
		
		<div class="form-group  row" >
			<div class="col-sm-3 ind_5">
			<label for="form-field-8">Industry (Level-4)</label>
			<select  name="industry[]" id="industry_5" class="form-control" onchange="get_sub_industry(this.value,'6');">
            <option value="">-Select Industry</option>
            <option selected="selected" value="<?php echo $industry_arr[4];?>"><?php $result = get_industry_by_id($industry_arr[4]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==6){?>
            	<input type="text" name="textbox_6" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_6" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
            
            <div class="col-sm-3 ind_6">
			<label for="form-field-8">Industry (Level-5)</label>
			<select  name="industry[]" id="industry_6" class="form-control" onchange="get_sub_industry(this.value,'7');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[5];?>"><?php $result = get_industry_by_id($industry_arr[5]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==7){?>
            	<input type="text" name="textbox_7" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_7" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
				
          	<?php }?>
			</div>
			
			<div class="col-sm-3 ind_7" >
		
			  <label for="form-field-8">Industry (Level-6)</label>
             <select name="industry[]" id="industry_7" class="form-control" onchange="get_sub_industry(this.value,'8');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[6];?>"><?php $result = get_industry_by_id($industry_arr[6]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==8){?>
            	<input type="text" name="textbox_8" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_8" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			
			<div class="col-sm-3 ind_8">
			<label for="form-field-8">Industry (Level-7)</label>
			<select  name="industry[]" id="industry_8" class="form-control" onchange="get_sub_industry(this.value,'9');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[7];?>"><?php $result = get_industry_by_id($industry_arr[7]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==9){?>
            	<input type="text" name="textbox_9" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_9" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			
 		</div>
 		
		<div class="form-group row" >
			<div class="col-sm-3 ind_9">
			<label for="form-field-8">Industry (Level-8)</label>
			<select  name="industry[]" id="industry_9" class="form-control" onchange="get_sub_industry(this.value,'10');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[8];?>"><?php $result = get_industry_by_id($industry_arr[8]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==10){?>
            	<input type="text" name="textbox_10" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_10" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
		
			<div class="col-sm-3 ind_10">
			<label for="form-field-8">Industry (Level-9)</label>
			<select  name="industry[]" id="industry_10" class="form-control" onchange="get_sub_industry(this.value,'11');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[9];?>"><?php $result = get_industry_by_id($industry_arr[9]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==11){?>
            	<input type="text" name="textbox_11" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_11" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
            
            <div class="col-sm-3 ind_11">
			<label for="form-field-8">Industry (Level-10)</label>
			<select  name="industry[]" id="industry_11" class="form-control" onchange="get_sub_industry(this.value,'12');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[10];?>"><?php $result = get_industry_by_id($industry_arr[10]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==12){?>
            	<input type="text" name="textbox_12" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_12" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			
			<div class="col-sm-3 ind_12">
			  <label for="form-field-8">Industry (Level-11)</label>
             <select name="industry[]" id="industry_12" class="form-control" onchange="get_sub_industry(this.value,'13');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[11];?>"><?php $result = get_industry_by_id($industry_arr[11]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==13){?>
            	<input type="text" name="textbox_13" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_13" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
  		</div>
 		
		<div class="form-group row">
			<div class="col-sm-3 ind_13">
			<label for="form-field-8">Industry (Level-12)</label>
			<select  name="industry[]" id="industry_13" class="form-control" onchange="get_sub_industry(this.value,'14');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[12];?>"><?php $result = get_industry_by_id($industry_arr[12]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==14){?>
            	<input type="text" name="textbox_14" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_14" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			
			<div class="col-sm-3 ind_14">
			<label for="form-field-8">Industry (Level-13)</label>
			<select  name="industry[]" id="industry_14" class="form-control" onchange="get_sub_industry(this.value,'15');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[13];?>"><?php $result = get_industry_by_id($industry_arr[13]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==15){?>
            	<input type="text" name="textbox_15" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_15" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
		
			<div class="col-sm-3 ind_15">
			<label for="form-field-8">Industry (Level-14)</label>
			<select  name="industry[]" id="industry_15" class="form-control" onchange="get_sub_industry(this.value,'16');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[14];?>"><?php $result = get_industry_by_id($industry_arr[14]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==16){?>
            	<input type="text" name="textbox_16" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_16" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
            
            <div class="col-sm-3 ind_16">
			<label for="form-field-8">Industry (Level-15)</label>
			<select  name="industry[]" id="industry_16" class="form-control" onchange="get_sub_industry(this.value,'17');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[15];?>"><?php $result = get_industry_by_id($industry_arr[15]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==17){?>
            	<input type="text" name="textbox_17" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_17" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			
		
			 
 		</div>
 		
		<div class="form-group row">
			<div class="col-sm-3 ind_17">
			  <label for="form-field-8">Industry (Level-16)</label>
             <select name="industry[]" id="industry_17" class="form-control" onchange="get_sub_industry(this.value,'18');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[16];?>"><?php $result = get_industry_by_id($industry_arr[16]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==18){?>
            	<input type="text" name="textbox_18" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_18" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			
			<div class="col-sm-3 ind_18">
			  <label for="form-field-8">Industry (Level-17)</label>
             <select name="industry[]" id="industry_18" class="form-control" onchange="get_sub_industry(this.value,'19');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[17];?>"><?php $result = get_industry_by_id($industry_arr[17]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==19){?>
            	<input type="text" name="textbox_19" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_19" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			
			<div class="col-sm-3  ind_19">
			<label for="form-field-8">Industry (Level-18)</label>
			<select  name="industry[]" id="industry_19" class="form-control" onchange="get_sub_industry(this.value,'20');">
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[18];?>"><?php $result = get_industry_by_id($industry_arr[18]);echo $result[0]['categoryName'];?></option> 
            
            </select> 
			<?php  if($dropDown_position_str==20){?>
            	<input type="text" name="textbox_20" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_20" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
            
            <div class="col-sm-3 ind_20">
			<label for="form-field-8">Industry (Level-19)</label>
			<select  name="industry[]" id="industry_20" class="form-control" >
            <option value="">-Select Industry-</option>
            <option selected="selected" value="<?php echo $industry_arr[19];?>"><?php $result = get_industry_by_id($industry_arr[19]);echo $result[0]['categoryName'];?></option> 
             </select>
              <?php  if($dropDown_position_str==21){?>
            	<input type="text" name="textbox_21" class="industryTxt form-control" value="<?php echo $testbox_value;?>" style="margin-top:3px;">
				<input type="text" name="remarkbox_21" value="<?php echo $remarkbox;?>"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">
          	<?php }?>
			</div>
			 
			 
 		</div>
        <!--------------------------------- Category Listing------------------------------ -->
        
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Product Name</label>
			<input readonly="readonly" value="<?php echo $dt['product_name'];?>" type="text" class="form-control" >
 			</div>
             
            <div class="col-sm-4">
            <label for="form-field-8">Product SKU</label>
         		<input value="<?php echo $dt['product_sku'];?>" readonly="readonly" class="form-control" maxlength="100" type="text">
			</div>
           
     
 		</div>
		 
        <?php 
            $listOpt = getAllProductName('');
            $listALLOpt = json_decode($listOpt,true);
          ?> <!--
         <div class="form-group row">
				<div class="col-sm-4">
				  <label for="form-field-8">Product Level-1<?php //echo $ParentName;?></label>
                  <select class="form-control" name="attr_level_1" multiple="multiple" onClick="getChildAttr();">
				  <option value="">-Select Product-</option> 
				  	<?php //foreach($listALLOpt as $val){?>
					  		<option <?php //if(in_array($val['product_id'],$id_parents)){echo 'selected="selected"';}?> value="<?php //echo $val['product_id'];?>"><?php //echo $val['name'];?></option> 
					<?php //}?>
                  </select>
				</div>
			
            
            <div class="col-sm-4" id="child_div" style="display:none;">
				  <label for="form-field-8">Product Level-1<?php //echo $ParentName;?></label>
                  <span id="child_attr"></span>
				</div>
			</div>		
          
             -->
         </div>
         
         <!--------------------------------- Essential attributes-----------------------------------> 
		  <div class="form-group row">
          <div class="col-sm-4">
				<label for="form-field-8">Code type in printing</label>
				<select name="code_type" id="code_type" class="form-control">
				 <option value="barcode" <?php echo ($dt['code_type']=='barcode')?'selected':'';?>>Barcode</option>
				 <option value="qrcode"  <?php echo ($dt['code_type']=='qrcode')?'selected':'';?>>Qrcode</option>
				</select>
  			</div>
			<div class="col-sm-4">
				<label for="form-field-8">Code Activation Type</label>
				<?php //echo $dt['code_activation_type'];
				$one='1';
				$zero='0';
				
				?>
				<select name="code_activation_type" id="code_activation_type" class="form-control">
				 
				<!-- <option value="1" <?php //echo ($dt['code_activation_type']=='1')?'selected':'';?>> Pre-Activated</option>-->
				 
				  <option value="0" <?php echo ($dt['code_activation_type']=='0')?'selected':'';?>> Post-Activated</option>
				 
				</select>
 		    </div>
            <div class="col-sm-4">
				<label for="form-field-8">Methods of Delivery</label>
				<select name="delivery_method" id="delivery_method" class="form-control">
				 <option value="1"  <?php echo ($dt['delivery_method']=='1')?'selected':'';?>>Physical Printing by Super Admin</option>
				 <option value="2"  <?php echo ($dt['delivery_method']=='2')?'selected':'';?>>Physical Printing by CCC Admin</option>
				 <option value="3"  <?php echo ($dt['delivery_method']=='3')?'selected':'';?>>Physical Printing by Designated Plant Controller</option>
				<!-- <option value="4"  <?php //echo ($dt['delivery_method']=='4')?'selected':'';?>> Deliver By E-Mode  </option> -->
				</select>
 		    </div> 
          </div>   
          <div class="form-group row"> 
           <div class="col-sm-4">
				<label for="form-field-8">Code Key Type</label>
				<select name="code_key_type" id="code_key_type" class="form-control">
				 <option value="serial"  <?php echo ($dt['code_key_type']=='serial')?'selected':'';?>> Serial Unique</option>
				 <option value="random"  <?php echo ($dt['code_key_type']=='random')?'selected':'';?>>Random Unique</option> 
				</select>
 		    </div> 
            
            <div class="col-sm-4">
				<label for="form-field-8">Size of the Code</label>
				<select name="code_size" id="code_size" class="form-control">
				 <option value="S"  <?php echo ($dt['code_size']=='S')?'selected':'';?>>Small</option>
				 <option value="M"  <?php echo ($dt['code_size']=='M')?'selected':'';?>>Medium</option>
				 <option value="L"  <?php echo ($dt['code_size']=='L')?'selected':'';?>>Large</option>
				</select>
 		    </div>
			<div class="col-sm-4">
				<label for="form-field-8">Code Unity Type</label>
				<select name="code_unity_type" id="code_unity_type" class="form-control">
				 <option value="Single"  <?php echo ($dt['code_unity_type']=='Single')?'selected':'';?>>Single</option>
				 <option value="Twin"  <?php echo ($dt['code_unity_type']=='Twin')?'selected':'';?>>Twin</option>
				</select>
 		    </div>
			
  		</div> 
		<div class="form-group row"> 
           <div class="col-sm-4">
				<label for="form-field-8">Registration Pack</label>
				<select name="registration_pack" id="registration_pack" class="form-control">
				
				<option value="Yes"  <?php echo ($dt['registration_pack']=='Yes')?'selected':'';?>>Yes</option>
				<option value="No"  <?php echo ($dt['registration_pack']=='No')?'selected':'';?>>No</option>
				 
				</select>
 		    </div> 
            
            <div class="col-sm-4">
				<label for="form-field-8">Retailer Pack</label>
				<select name="retailer_pack" id="retailer_pack" class="form-control">
				 <option value="Yes"  <?php echo ($dt['retailer_pack']=='Yes')?'selected':'';?>>Yes</option>
				<option value="No"  <?php echo ($dt['retailer_pack']=='No')?'selected':'';?>>No</option>
				</select>
 		    </div>
			
			<div class="col-sm-4">
				<label for="form-field-8">Min Shipper Pack Level </label>
				<input type="number" name="min_shipper_pack_level" min="2" step="1" id="min_shipper_pack_level" class="form-control" value="<?php echo $dt['min_shipper_pack_level'];?>" />
				
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
				<input type="number" name="max_shipper_pack_level" min="2" step="1" id="max_shipper_pack_level" class="form-control" value="<?php echo $dt['max_shipper_pack_level'];?>" />				
				
				<!--
				<select name="max_shipper_pack_level" id="max_shipper_pack_level" class="form-control">
				 <option value="serial"> Serial Unique</option>
				 <option value="random">Random Unique</option> 
				</select>-->
 		    </div> 
  		</div>
		<!--------------------------------- Essential attributes ends-----------------------------------> 
         
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

//getChildAttr('<?php echo implode(',',$id_parents); ?>',$("#childs_selected").val());

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
		   industry: {
						required: true
        			 },
			brand_name: {
			 	 required: true
						},
							
						
  			messages: {
				
 			industry:    {
					required: "Please select Industry"
					} 
			},

 		},
		submitHandler: function(form) {
 			var formData;
			var dataSend 	= $("#user_frm").serialize();
			formData 		= new FormData();
 			var formData = new FormData(form); 
  			$.ajax({
				type: "POST",
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
				}
			});
  		}
	});
});
  
 function get_sub_industry(cid,level){
	 if(level==2){
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
		$(labelId).after('<input type="text" name="textbox_'+level+'" placeholder="Add Industry" class="industryTxt form-control" style="margin-top:3px;"><input type="text" name="remarkbox"  placeholder="Remark" class="industryTxt form-control" style="margin-top:3px;">');
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
<!----- ADD Service Code ----> 

<!------ ADD Service Code-----------> 