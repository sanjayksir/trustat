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
		     <div class="col-sm-6"> -->
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
                 <input value="<?php echo $dt['pack_level1']; ?>" type="text" name="pack_level1" id="pack_level1" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 2<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level2']; ?>" type="text" name="pack_level2" id="pack_level2" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 3<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level3'];?>" type="text" name="pack_level3" id="pack_level3" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 4<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level4'];?>" type="text" name="pack_level4" id="pack_level4" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 5<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level5'];?>" type="text" name="pack_level5" id="pack_level5" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 6<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level6'];?>" type="text" name="pack_level6" id="pack_level6" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 7<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level7'];?>" type="text" name="pack_level7" id="pack_level7" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 8<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level8'];?>" type="text" name="pack_level8" id="pack_level8" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 9<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level9'];?>" type="text" name="pack_level9" id="pack_level9" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 10<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level10'];?>" type="text" name="pack_level10" id="pack_level10" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 11<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level11'];?>" type="text" name="pack_level11" id="pack_level11" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 12<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level12'];?>" type="text" name="pack_level12" id="pack_level12" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 13<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level13'];?>" type="text" name="pack_level13" id="pack_level13" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 14<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level14'];?>" type="text" name="pack_level14" id="pack_level14" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 15<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level15'];?>" type="text" name="pack_level15" id="pack_level15" class="form-control" >
				</div>
				
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 16<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level16'];?>" type="text" name="pack_level16" id="pack_level16" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 17<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level17'];?>" type="text" name="pack_level17" id="pack_level17" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 18<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level18'];?>" type="text" name="pack_level18" id="pack_level18" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 19<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level19'];?>" type="text" name="pack_level19" id="pack_level19" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 20<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level20'];?>" type="text" name="pack_level20" id="pack_level20" class="form-control" >
				</div>
				
				<div class="col-sm-4">
				  <label for="form-field-8">Packaging Level 21<?php //echo $ParentName;?></label>
                  <input value="<?php echo $dt['pack_level21'];?>" type="text" name="pack_level21" id="pack_level21" class="form-control" >
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
						required: true
        			 },
				pack_level2: {
						required: true
        			 }
				},
		
		messages: {
				
				pack_level1:    {
					required: "Please select Packaging Level 1"
					},
				pack_level2:    {
					required: "Please select Packaging Level 2"
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
