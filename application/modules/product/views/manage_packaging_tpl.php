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
          <li class="active">Manage Packaging </li>
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
                  <h3 class="header smaller lighter blue"><?php echo get_products_name_by_id($this->uri->segment(3)); ?>, Please insert the number of childern at each level </h3>
					
                    <form name="user_frm" id="user_frm" action="#" method="post">
					
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
		  <input type="hidden" name="id" value="<?php echo $dt['id'];?>" id="id" />
		  <input value="<?php echo $this->uri->segment(3); ?>" type="hidden" name="product_id" id="product_id" class="form-control" >
         <div class="form-group row">
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 1</label>
                 <input value="<?php echo $dt['pack_level1']; ?>" placeholder="Number of Packaging childern at Level 1 not specified" type="text" name="pack_level1" id="pack_level1" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 2<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level2']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level2'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level2']=='')||($dt['pack_level2']=='0'))
				  {
				  ?>  
				   placeholder="Number of Packaging childern at Level 2 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level2'];
				  }
				  ?> type="text" name="pack_level2" id="pack_level2" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 3<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level3']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level3'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level3']=='')||($dt['pack_level3']=='0'))
				  {
				  ?>  
				   placeholder="Number of Packaging childern at Level 3 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level3'];
				  }
				  ?> type="text" name="pack_level3" id="pack_level3" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 4<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level4']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level4'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level4']=='')||($dt['pack_level4']=='0'))
				  {
				  ?>   
				   placeholder="Number of Packaging childern at Level 4 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level4'];
				  }
				  ?> type="text" name="pack_level4" id="pack_level4" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 5<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level5']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level5'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level5']=='')||($dt['pack_level5']=='0'))
				  {
				  ?>    
				   placeholder="Number of Packaging childern at Level 5 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level5'];
				  }
				  ?> type="text" name="pack_level5" id="pack_level5" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 6<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level6']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level6'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level6']=='')||($dt['pack_level6']=='0'))
				  {
				  ?>    
				   placeholder="Number of Packaging childern at Level 6 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level6'];
				  }
				  ?> type="text" name="pack_level6" id="pack_level6" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 7<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level7']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level7'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level7']=='')||($dt['pack_level7']=='0'))
				  {
				  ?>  
				   placeholder="Number of Packaging childern at Level 7 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level7'];
				  }
				  ?> type="text" name="pack_level7" id="pack_level7" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 8<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level8']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level8'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level8']=='')||($dt['pack_level8']=='0'))
				  {
				  ?>  
				   placeholder="Number of Packaging childern at Level 8 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level8'];
				  }
				  ?> type="text" name="pack_level8" id="pack_level8" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 9<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level9']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level9'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level9']=='')||($dt['pack_level9']=='0'))
				  {
				  ?>  
				   placeholder="Number of Packaging childern at Level 9 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level9'];
				  }
				  ?> type="text" name="pack_level9" id="pack_level9" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 10<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level10']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level10'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level10']=='')||($dt['pack_level10']=='0'))
				  {
				  ?>    
				   placeholder="Number of Packaging childern at Level 10 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level10'];
				  }
				  ?> type="text" name="pack_level10" id="pack_level10" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 11<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level11']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level11'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level11']=='')||($dt['pack_level11']=='0'))
				  {
				  ?>    
				   placeholder="Number of Packaging childern at Level 11 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level11'];
				  }
				  ?> type="text" name="pack_level11" id="pack_level11" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 12<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level12']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level12'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level12']=='')||($dt['pack_level12']=='0'))
				  {
				  ?>    
				   placeholder="Number of Packaging childern at Level 12 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level12'];
				  }
				  ?> type="text" name="pack_level12" id="pack_level12" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 13<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level13']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level13'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level13']=='')||($dt['pack_level13']=='0'))
				  {
				  ?>    
				   placeholder="Number of Packaging childern at Level 13 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level13'];
				  }
				  ?> type="text" name="pack_level13" id="pack_level13" class="form-control" > 
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 14<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level14']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level14'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level14']=='')||($dt['pack_level14']=='0'))
				  {
				  ?>    
				   placeholder="Number of Packaging childern at Level 14 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level14'];
				  }
				  ?> type="text" name="pack_level14" id="pack_level14" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 15<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level15']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level15'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level15']=='')||($dt['pack_level15']=='0'))
				  {
				  ?>     
				   placeholder="Number of Packaging childern at Level 15 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level15'];
				  }
				  ?> type="text" name="pack_level15" id="pack_level15" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 16<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level16']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level16'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level16']=='')||($dt['pack_level16']=='0'))
				  {
				  ?>  
				   placeholder="Number of Packaging childern at Level 16 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level16'];
				  }
				  ?> type="text" name="pack_level16" id="pack_level16" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 17<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level17']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level17'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level17']=='')||($dt['pack_level17']=='0'))
				  {
				  ?>   
				   placeholder="Number of Packaging childern at Level 17 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level17'];
				  }
				  ?> type="text" name="pack_level17" id="pack_level17" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 18<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level18']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level18'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level18']=='')||($dt['pack_level18']=='0'))
				  {
				  ?>   
				   placeholder="Number of Packaging childern at Level 18 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level18'];
				  }
				  ?> type="text" name="pack_level18" id="pack_level18" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 19<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level19']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level19'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level19']=='')||($dt['pack_level19']=='0'))
				  {
				  ?>   
				   placeholder="Number of Packaging childern at Level 19 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level19'];
				  }
				  ?> type="text" name="pack_level19" id="pack_level19" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 20<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level20']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level20'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level20']=='')||($dt['pack_level20']=='0'))
				  {
				  ?>   
				   placeholder="Number of Packaging childern at Level 20 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level20'];
				  }
				  ?> type="text" name="pack_level20" id="pack_level20" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 21<?php //echo $ParentName;?></label>
                  <input value="<?php 
				  if($dt['pack_level21']=='')
				  {
				   echo '0'; 
				  } else { 
				  echo $dt['pack_level21'];
				  }
				  ?>" <?php 
				  if(($dt['pack_level21']=='')||($dt['pack_level21']=='0'))
				  {
				  ?>   
				   placeholder="Number of Packaging childern at Level 21 not specified."
				   <?php
				  } else { 
				  echo $dt['pack_level21'];
				  }
				  ?> type="text" name="pack_level21" id="pack_level21" class="form-control" >
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



<!------------------------ Validate Fom Add Menu Data----------------------------->
 $(document).ready(function(){	
 	 $.validator.addMethod("specialChrs", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Product must contain only letters, numbers, or dashes.");
	$("form#user_frm").validate({
		rules: {
				pack_level1: {
						digits: true,
						min: 1,
						required: true
        			 },
				pack_level2: {
						digits: true,
						required: true
        			 },
				pack_level3: {
						digits: true,
						required: true
        			 },
				pack_level4: {
						digits: true,
						required: true
        			 },
				pack_level5: {
						digits: true,
						required: true
        			 },
				pack_level6: {
						digits: true,
						required: true
        			 },
				pack_level7: {
						digits: true,
						required: true
        			 },	
				pack_level8: {
						digits: true,
						required: true
        			 },	
				pack_level9: {
						digits: true,
						required: true
        			 },
				pack_level10: {
						digits: true,
						required: true
        			 },	
				pack_level11: {
						digits: true,
						required: true
        			 },
				pack_level12: {
						digits: true,
						required: true
        			 },
				pack_level13: {
						digits: true,
						required: true
        			 },
				pack_level14: {
						digits: true,
						required: true
        			 },
				pack_level15: {
						digits: true,
						required: true
        			 },
				pack_level16: {
						digits: true,
						required: true
        			 },
				pack_level17: {
						digits: true,
						required: true
        			 },
				pack_level18: {
						digits: true,
						required: true
        			 },
				pack_level19: {
						digits: true,
						required: true
        			 },
				pack_level20: {
						digits: true,
						required: true
        			 },	 
				pack_level21: {
						digits: true,
						required: true
        			 }	 
				},
		
		messages: {
				
				pack_level1:    {
					digits:"Only Numeric value accepted!",
					min:"You Can not pack an empty box!",
					required: "Please Specify the number of childern at Packaging Level 1."
					},
				pack_level2:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 2."
					},
				pack_level3:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 3."
					},
				pack_level4:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 4."
					},
				pack_level5:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 5."
					},
				pack_level6:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 6."
					},
				pack_level7:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 7."
					},
				pack_level8:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 8."
					},
				pack_level9:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 9."
					},
				pack_level10:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 10."
					},
				pack_level11:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 11."
					},
				pack_level12:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 12."
					},
				pack_level13:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 13"
					},
				pack_level14:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 14."
					},
				pack_level15:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 15."
					},
				pack_level16:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 16."
					},
				pack_level17:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 17."
					},
				pack_level18:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 18."
					},
				pack_level19:    {
					digits:"Only Numeric value accepted",
					required: "Please Specify the number of childern at Packaging Level 19."
					},
				pack_level20:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 20."
					},
				pack_level21:    {
					digits:"Only Numeric value accepted!",
					required: "Please Specify the number of childern at Packaging Level 21."
					}		
				},
			
		submitHandler: function(form) {
 			var formData;
			var dataSend 	= $("#user_frm").serialize();
			formData 		= new FormData();
 			var formData = new FormData(form); 
  			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>product/save_product_pack_level/",
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
