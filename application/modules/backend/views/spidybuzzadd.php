<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); ?>
<?php  //echo '<pre>';print_r($buzz[0]['zone_id']);exit;
//echo '****'.$this->uri->segment(3);exit;
//echo '*****'. CI_VERSION;
?>

<div class="main-container ace-save-state" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.loadState('main-container')
        } catch (e) {
        }
    </script>
    <?php $this->load->view('../includes/admin_sidebar'); ?>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo DASH_B;?>">Home</a> </li>
                    <li> Editorial Section </li>
                    <li class="active">Add/Edit Story Detail</li>
                </ul>
                <!-- /.breadcrumb -->

                <div class="nav-search" id="nav-search">
                    <form class="form-search">
                        <span class="input-icon">
                            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off">
                            <i class="ace-icon fa fa-search nav-search-icon"></i> </span>
                    </form>
                </div>
                <!-- /.nav-search -->
            </div>
            <div class="page-content">
                <!--<div class="page-header">
                    <h1>
                        Master
                        <small>
                            <i class="ace-icon fa fa-angle-double-right"></i>
                            Edit RWA profile setting
                        </small>
                    </h1>
                </div> /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                    
                                <h3 class="header smaller lighter blue">Add Spideypicks</h3>
                                <?php if ($feedback = $this->session->flashdata('feedback')) { ?>
                                    <div class="alert alert-dismissible <?php echo $this->session->flashdata('feedback_class') ?>">
                                        <strong><?php echo $feedback; ?></strong>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="widget-box">
                                            <div class="widget-header">
                                                <span class="widget-toolbar"><a href="<?php echo base_url().'buzzadmn/'; ?>">Back</a></span>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">

                                                    <?php echo form_open_multipart(($buzz[0]['spidypickId']) ? 'buzzadmn/updateSpidyBuzz/' . $buzz[0]['spidypickId'] : 'buzzadmn/saveSpidyBuzz', array('onsubmit' => 'return form_validate();'   )); ?>
                                    <div class="form-group">
                                                        <div class="add-spidey">
                                                            <label><strong>Spidey Title</strong><span class="strick"><sup>*</sup>
                                                            <font size="1" id="max_limit">(Maximum characters:80)<br>You have <input readonly type="text" name="countdown3" size="3" value="80" style="width: 28px;height: 28px;text-align: center;border-radius: 100% !important;"> characters left.</font></label><span id="story_url_err"></span>
                                                            <input type="text" name="title" value="<?php echo $buzz[0]['spidyName']; ?>" class="form-control" id="title"  onKeyDown="limitText(this.form.title,this.form.countdown3,80);"  onKeyUp="return make_Url(this.value);"type="text" name="countdown3" size="3" value="80" maxlength="80" >
                                                        </div>
                                                        
                                                        <div class="add-spidey">
                                                            <label><strong>Story Url</strong><span class="strick"><sup>*</sup>
                                                             </label>
                                                            <input type="text" name="url" value="<?php echo $buzz[0]['story_url']; ?>" readonly="readonly" class="form-control" id="url" type="text"  >
                                                        </div>
                                                        
                                                        <div class="add-spidey">
                                                            <label><strong>Short Description </strong>
                                                             </label> 
                                                           
                                                            <textarea  name="headline" cols="40" maxlength="100" rows="10" class="form-control" id="headline"><?php echo $buzz[0]['headline']; ?></textarea>
                                                        </div>

                                                        <div class="add-spidey">
                                                            <label><strong>Full Description</strong></label>
                                                            <textarea name="pickDesc" cols="40" rows="50" class="form-control" id="pickDesc"><?php echo $buzz[0]['pickDesc']; ?></textarea>
                                                        </div>

                                                        <div class="add-spidey" id="show_tags" style="display:none;">
                                                          <label><strong>Tags Suggestion</strong></label>
                                                          <p class="tags" style="width: 100%;"></p>
                                                        </div>

                                                        <div class="add-spidey">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12"><label>TAGS*</label> <br>
                                                                    <textarea name="videoLink" cols="40" rows="10" class="form-control" id="videoLink" row="2"><?php echo $buzz[0]['tags']; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                       <!----------- Is Breaking------------------>  
                                                         <div class="add-spidey">
                                                            <label><strong>Making breaking news:</strong></label>
															<!--	<small class="muted smaller-90">Is Breaking:</small>-->
 																<input name="is_breaking" id="id-button-borders" <?php if($buzz[0]['is_breaking_news']==1){?>checked <?php }?> class="ace ace-switch ace-switch-5 is_breaking" type="checkbox" onchange="return showHide_fld('is_breaking', 'breakingFld','max_limit');">
																<span class="lbl middle"></span>
                                                             <textarea onKeyDown="limitText(this.form.breakingFld,this.form.countdown,50);" 
onKeyUp="limitText(this.form.breakingFld,this.form.countdown,50);" style="display:<?php if($buzz[0]['is_breaking_news']==1){echo 'block';}else{echo 'none';}?>;margin:10px 10px 20px 0px;" name="breakingFld" cols="40" rows="4" class="form-control" id="breakingFld"><?php echo $buzz[0]['breaking_news_title']; ?></textarea>
<font size="1" id="max_limit" style="display:<?php if($buzz[0]['is_breaking_news']==1){echo 'block';}else{echo 'none';}?>;">(Maximum characters: 50)<br>
You have <input readonly type="text" name="countdown" size="3" value="50"> characters left.</font>
 
                                                          </div>
                                                        
                                                         <!----------- Is Breaking------------------>
                                                         
                                                         
                                                         <!----------- Tricky Title------------------>  
                                                         <div class="add-spidey">
                                                             <label><strong>They said it!</strong></label>
															<!--	<small class="muted smaller-90">Is Breaking:</small>-->
 																<input  name="is_tricky"  <?php if($buzz[0]['is_tricky_title']==1){?>checked <?php }?> id="id-button-borders2" class="ace ace-switch ace-switch-5 is_tricky" type="checkbox" onchange="return showHide_fld('is_tricky', 'trickyFld','max_limit2');">
																<span class="lbl middle"></span>
                                                             <textarea onKeyDown="limitText(this.form.trickyFld,this.form.countdown2,70);" 
onKeyUp="limitText(this.form.trickyFld,this.form.countdown2,70);" style="display:<?php if($buzz[0]['is_tricky_title']==1){echo 'block';}else{echo 'none';}?>;margin-top:10px;" name="trickyFld" cols="40" rows="4" class="form-control" id="trickyFld"><?php echo $buzz[0]['tricky_title_name']; ?></textarea>
<font size="1" id="max_limit2" style="display:<?php if($buzz[0]['is_tricky_title']==1){echo 'block';}else{echo 'none';}?>;">(Maximum characters: 70)<br>
You have <input readonly type="text" name="countdown2" size="3" value="60" style="width: 28px;height: 28px;text-align: center;border-radius: 100% !important;"> characters left.</font>
                                                           </div>
                                                          <!----------- Tricky Title ------------------>
                                                         
                                                         
                                                         
                                                        <div class="add-spidey">
                                                            
                                                            <div class="row">
                                                                <div class="col-xs-6 col-sm-6"> 
                                                                  <label>Spidey Main Story Image<b> ( 1024 x 580 )px </b>  </label><br>
                                                                  <style>
																		.file {
																			visibility: hidden;
																			position: absolute;
																		}

																  </style>
                                                                  
                                                                <div class="form-group">
                                                                    <input type="file" name="spideyImage" id="spideyImage" class="file" onchange="readURL(this); return validateImage2(this.files,'1024', '580','largeImageBx');">
                                                                   
                     
                   
                                                                    
                                                                    
                                                                    
                                                                    <div class="input-group col-xs-12">
                                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                      <input id="largeImageBx" type="text" class="form-control input-lg" disabled placeholder="Upload Image">
                                                                      <span class="input-group-btn">
                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                      </span>
                                                                      
                                                                    </div>  <img style="display:none;" width="100px" id="blah" src="#" alt="Image Preview" />
                                                                </div>
                                                             
                                                                    <br>
                                                                </div>
                                                                <div class="col-xs-6 col-sm-6"> 
                                                                  <label>Video media <b> (Url/embed Code) </b>  </label><br>
                                                                  <style>
																		.file {
																			visibility: hidden;
																			position: absolute;
																		}

																  </style>
                                                                  
                                                                <div class="form-group">
                                                                    <textarea name="video_media" class="form-control" id="video_media" rows="1" placeholder="Upload Url"></textarea>
                                                                 </div>
                                                                     <br>
                                                                </div>
                                                                 
                                                            </div>
                                                        </div>
														<!------------- UPLOAD BANNER IMAGES ------------------------>
                                                        
                                                        <!------------- UPLOAD BANNER IMAGES ------------------------>
                                                        <div class="add-spidey">
                                                            <div class="row">
                                                                <div class="col-xs-6 col-sm-6"><label>Photo Credit 
                                                                 
                                                           
                                                                </label> <br>
                                                                    <input type="text" name="photocredit" value="<?php echo $buzz[0]['photocredit']; ?>" class="form-control" id="photocredit">
                                                                </div>
                                                                <div class="col-xs-6 col-sm-6"> <label>Photo Caption 
                                                                <font size="1" id="max_limit">(Max. Chars:70)&nbsp;[You have <input readonly type="text" name="countdown5" size="3" value="70" style="width: 28px;height: 24px;text-align: center;border-radius: 100% !important;"> characters left.]</font>
                                                                
                                                                </label> 
                                                                    <input maxlength="70" onKeyDown="limitText(this.form.photocaption,this.form.countdown5,70);" onKeyUp="limitText(this.form.photocaption,this.form.countdown5,70);" type="text" name="photocaption" value="<?php echo $buzz[0]['photocaption']; ?>" class="form-control" id="photocaption">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="add-spidey">
                                                       <div class="row">
                                                       <div class="col-xs-6 col-sm-6"><label>Source / By / Line <span class="strick">*</span></label> <br>
													   <?php 
		                                              $source= get_source(17,15);//print_r($source);?>
                                                <select name="subHeadLine" class="form-control" id="subHeadLine">
												<option value=""> --Select--</option>
													<?php
                                                                               foreach($source as $source1){ if($source1['f_name']!=''){?>
                                                 <option value="<?php echo $source1['f_name'].' '.$source1['l_name'];?>" <?php if($buzz[0]['subHeadLine']==($source1['f_name'].' '.$source1['l_name'])){
                                                  echo 'selected';}?> ><?php  echo ucfirst($source1['f_name']);echo' ';echo ($source1['l_name']);?></option>       
																			   <?php } } ?>

                                               </select>
													  
                                                       </div>
                                                                <?php //echo '<pre>';print_r($buzz[0]['category_id']);exit;?>
                                                                <div class="col-xs-3 col-sm-3"> <label style="width: 100%;"><span class="strick" style="float:left;">Category *</span><span style="float:right;"><a href="javascript:void(0);"  title="Add New Category" id="addCat">Add New</a></span></label>
                                                                <div id='addCatBlock' style='display:none;'><input type='text' id='new_category' name='new_category'>&nbsp;<button class='btn btn-sm btn-success' onclick="addCategory()">Add</button>&nbsp;<button class='btn btn-sm btn-danger' type='button' id="removeCat">Close</button>
                                                                <label id="category_error"></label></div>
                                                                <br>
                                                                    <select name="category_id" id="category_id" class="form-control" onchange="return getSubcategory(this.value);">
                                                                    	<option value=""> - Select Category -</option>
                                                                        <?php foreach ($categories as $cat) { ?>
                                                                            <option value="<?php echo $cat['category_Id']; ?>" <?php echo ($buzz[0]['category_id'] == $cat['category_Id']) ? 'selected' : ''; ?> ><?php echo $cat['categoryName']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <label id="category_err" class="error"></label>
                                                                </div>
                                                                <div class="col-xs-3 col-sm-3"> <label style="width: 100%;"><span class="strick" style="float:left;">Sub Category *</span><span style="float:right;"><a href="javascript:void(0);"  title="Add New Sub Category" id="addSubCat">Add New</a></span></label>
                                                                <div id='addSubCatBlock' style='display:none;'><input type='text' id='new_subcategory' name='new_subcategory'>&nbsp;<button class='btn btn-sm btn-success' onclick="addSubCategory()">Add</button>&nbsp;<button class='btn btn-sm btn-danger' type='button' id="removeSubCat">Close</button>
                                                                <label id="subcategory_error"></label></div> <br>
                                                                    <select name="sub_category_id" id="sub_category_id" class="form-control">
                                                                    	<option value="">-Select Sub Category-</option>
                                                                        <?php echo get_sub_categories($buzz[0]['category_id'],$buzz[0]['sub_category_id']);?>
                                                                     </select>
                                                                </div>
                                                            </div>
                                                         </div>
                                                        <div class="add-spidey">
                                                            <div class="row">
                                                                <div class="col-xs-6 col-sm-6"><label>Publish</label> <br>
                                                                    <select name="status" class="form-control" id="status" >
                                                                        <option  value="1" <?php echo ($buzz[0]['status'] == 1) ? 'selected' : ''; ?>>PUBLISH</option>
                                                                        <option value="0" <?php echo ($buzz[0]['status'] == 0) ? 'selected' : ''; ?>>UN PUBLISH</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-6 col-sm-6"> <label>Related Stories</label> <br>
                                                                    <input type="text" name="related_storyTxt" value="<?php echo $buzz[0]['related_storyTxt']; ?>" class="form-control" id="related_storyTxt" onkeyup="get_stories();">
                                                                    <input type="hidden" name="related_stories" id="related_stories"  class="form-control" value="<?php echo $buzz[0]['related_storyId']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                             <div class="col-xs-6 col-sm-6"></div>
                                                             <div class="col-xs-6 col-sm-6">
                                                                <div class="col-xs-12">
                                                                    <div class="related_story_toggle_chk" style="display:none;">
                                                                        <?php
                                                                        $data = array(
                                                                            'name' => 'toggle_all',
                                                                            'class' => 'toggle_all',
                                                                            'value' => '',
                                                                            'checked' => FALSE
                                                                        );

                                                                        echo form_checkbox($data) . ' Select All';
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12"  id="relatedId">
                                                                    <?php
                                                                    if (!empty($buzz[0]['spidypickId']) || !empty($buzz[0]['related_storyTxt'])) {
                                                                        echo $related_story;
                                                                    }
                                                                    ?>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <!--------------- Area of the story-------------------->
                                                       
                                                        <div class="col-xs-12 col-sm-12" style="border: 1px dotted #d4d4d4;background: #f3f3f3;">
                                                        <span><h4 class="header lighter black">Select Story Area:</h4></span>
														<div class="add-spidey">
                                                             
                                                            <div class="row">
                                                                <div class="col-xs-4 col-sm-4"> <label><strong>State</strong></label> <br>
                                                                  <div class="form-group">
                                                                     <div class="input-group col-xs-12">
                                                          <span class="form-group" id="state_div"> 
															<?php $list= get_region($buzz[0]['area_id']);
																foreach ($list as $stateid){
                                                                  $stateid1[] = $stateid['state_id'];
																  $cityid1[] = $stateid['city_id'];
																  
                                                           }
														   $stateid2 = array_unique($stateid1);
																  //print_r($stateid2);
														  $state_edit = implode(',', $stateid2);
														  $cityid2 = array_unique($cityid1);
																  //print_r($cityid1);
														  $city_edit = implode(',', $cityid2);
														  
														  ?> 
                                                                       <?php 
																	   ## Fetch Story
																	   $zone_id_arr =array();
																	   if(!empty($buzz[0]['area_id'])){
																	   		$zone_id_arr =  explode(',',$buzz[0]['area_id']); 
																			 $city_arr = getCityFromArea($zone_id_arr);
																			 // print_r($city_arr);
																			if($this->uri->segment(3)){
																			$state_arrIds=$stateid2;	
																			}else{
																			$state_arrIds = array();
																			}
																			//print_r($state_arrIds);
																			 foreach($city_arr as $k=>$v){ //echo '<pre>';print_r($v);
																				 $state_arr = array_unique(getStateFromCity($v));
																			 	 $state_arrIds[] = array_unique($state_arr);
																			 }
																			//echo '<pre>';print_r($state_arrIds); 
																	   }
																	   $selected = "";
																	   foreach ($states as $s) {
																		   if(count($state_arrIds)>0 && in_array($s['state_id'],$state_arrIds )){
																			   $selected = "selected";
																			  
																		   }
																		   
																		   ?>                                                                        
                                                                       <div style="width:70%;float:left;">
                                                                       <label for="<?php echo $s['state_name']; ?>"><?php echo $s['state_name']; ?></label></div>
                                                                       <div style="width:30%;float:right;"> 
                                                                       <input <?php echo $selected;?> id="state_<?php echo $s['state_id']; ?>" type="checkbox" class="state_chk_cl" name="state[]" value="<?php echo $s['state_id']; ?>" onclick="return display_city(this.value);"
																	    <?php echo (in_array($s['state_id'],$state_arrIds))?"checked":"";?>></div>
                                                                     	<?php }
																		
																	   ?>
                                                                        
                                                                        
                                                                      </span>
                                                                     </div>
                                                                   </div>
                                                                     <br>
                                                                </div>
                                                                <div class="col-xs-4 col-sm-4"> <label><strong>City</strong></label> <br>
                                                                  <div class="form-group">
                                                                     <div class="input-group col-xs-12" >
                                                                     <span class="form-group" id="city_div"> 
                                                                        <?php $list= get_region($buzz[0]['area_id']);//print_r($list);?>
																	  <?php foreach($list as $data){
																		  $c['id'][]= $data['city_id'];
																		  $c['cn'][]= $data['city_name'];
																		  
																		  
																	  }
																	   $result=array_unique(array_combine($c['id'],$c['cn']));
																	 //  print_r($result);
																	  foreach ($result as $key=>$val){?>
																	  <div style="width:70%;float:left;"> <label for="<?php echo $val;?>"><?php echo $val;?></label></div>
																	  <div style="width:30%;float:right;"> <input id="city_<?php echo $key;?>" type="checkbox"  name="city[]" value="<?php echo $key;?>" onclick="javascript: display_area(this.id);" class="state_chk" checked></div>
																	  <?php }?>
                                                                       </span>
                                                                     </div>
                                                                </div>
                                                                     <br>
                                                                </div>
                                                                <div class="col-xs-4 col-sm-4"> <label><strong>Area</strong></label> <br>
                                                                  <div class="form-group">
                                                                     <div class="input-group col-xs-12">
                                                                      <span class="form-group" id="area_div"> <?php 
																	  $list= get_region($buzz[0]['area_id']);?>
																	  <?php foreach($list as $data){?>
																	  <div style="width:70%;float:left;"> <label for="Faridabad"><?php echo $data['area_name'];?></label></div>
																	  <div style="width:30%;float:right;"> <input id="area_<?php echo $data['area_id'];?>" type="checkbox"  name="area[]" value="<?php echo $data['area_id'];?>" class="state_chk" onclick="javascript: display_area(this.id);" checked></div>
																	  <?php }?>
                                                                       </span>
                                                                     </div>
                                                                </div>
                                                                     <br>
                                                                </div>
                                                            </div>
                                                        </div>
														 	
                                                        <input type="hidden" id="all_selected_city" name="all_selected_city" value="<?php echo  $state_edit;?>"/><input type="hidden" id="all_selected_area" name="all_selected_area" value="<?php echo  $city_edit;?>" />
                                                        </div>
                                                        
                                                         <!--------------- Area of the story-------------------->
                                                          <div class="add-spidey">
                                                            <label>Push to be send to:</label>
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <?php
                                                                    foreach ($states as $s) {
                                                                        ?>
                                                                        <div>
                                                                            <label for="<?php echo $s['state_name']; ?>"><?php echo $s['state_name']; ?></label>
                                                                            <input id="<?php echo $s['state_name']; ?>" checked type="checkbox" class="state_chk" name="state[]" value="<?php echo $s['state_id']; ?>">
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!----------------- Rockey code------------------->
                                                        <div class="add-spidey">
                                                            <label>Story For:</label>
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    
                                                                        <div class="push-to-checkbox">
                                                                            <label for="Tracek Portal">Tracek Portal</label>
                                                                            <input id="Tracek Portal" type="checkbox" class="story_for_chk" value="2" <?php if($buzz[0]['story_for']==2 || $buzz[0]['story_for']==3)echo 'checked';?> >
                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                <div class="push-to-checkboxd">                                                                                            
                                                                                                                                                                                                                                                                                                                <label for="Cityspidey">Cityspidey</label>
                                                                            <input id="Cityspidey"  type="checkbox" class="story_for_chk" value="1" <?php if($buzz[0]['story_for']==1 || $buzz[0]['story_for']==3)echo 'checked';?>>
                                                                                                                                                                                                                                                                                                </div>                                                                                                                                                                                                                                                                                               <!--div>             
                                                                                                                                                                                                                                                                                                                <label for="bothsbcs">Both Tracek Portal/Cityspidey</label>
                                                                            <input id="bothsbcs"  type="radio" class="state_chk" name="story_for" value="3">
                                                                        </div-->
                                                                                                                                                                                                                                                               <input type="hidden" name="story_for" id="story_for" value="<?php echo $buzz[0]['story_for'];?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                         <!----------------- Rockey code------------------->
  														<!--div class="add-spidey">
        <label>Meta Title<span class="strick"><sup>*</sup> 80</span> characters left</label>
        <input type="text" name="meta_title" value="" class="form-control" id="meta_title">
    </div>
    <div class="add-spidey">
        <label>Meta Keywords<span class="strick"><sup>*</sup> 80</span> characters left</label>
        <input type="text" name="meta_keyword" value="" class="form-control" id="meta_keyword">
    </div>
    <div class="add-spidey">
        <label>Meta Description<span class="strick"><sup>*</sup></span><br /> Min: 60, Max: 250, Characters <span class="strick"><sup>0</sup></span> </label>
        <textarea name="meta_description" id="meta_description" class="form-control"></textarea>
    </div-->
                                                        <div class="add-spidey">
                                                            <input type="hidden" name="spidypickId" id="spidypickId" value="<?php echo $buzz[0]['spidypickId']; ?>" />
                                                            <?php

                                                            //echo form_hidden('spidypickId', $buzz[0]['spidypickId']);
                                                            echo form_hidden('currstatus', $buzz[0]['status']);
                                                            echo form_submit(array('name' => 'save_course', 'class' => 'btn btn-default', 'value' => 'Save'));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php echo form_close(); ?>
                                                    <!--</form>-->
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            <!-- PAGE CONTENT ENDS -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.page-content -->
                </div>
            </div>
            <!-- /.main-content -->
            <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
			 <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
			<script>
				CKEDITOR.replace( 'pickDesc', {
					extraPlugins: 'uploadimage',
					height: 500,
					// Upload images to a CKFinder connector (note that the response type is set to JSON).
					uploadUrl: '<?php echo base_url();?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
					// Configure your file manager integration. This example uses CKFinder 3 for PHP.
					filebrowserBrowseUrl: '<?php echo base_url();?>assets/ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl: '<?php echo base_url();?>assets/ckfinder/ckfinder.html?type=Images',
					filebrowserUploadUrl: '<?php echo base_url();?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl: '<?php echo base_url();?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				} );
			</script>
<script>
 //Get City
 <?php  if($this->uri->segment(3)){?>
 var selected_state = [<?php echo '"'.implode('","', $stateid2).'"' ?>];
 <!---[<?php echo($stateid2)? implode('","', $stateid2):"";?>];--->
 <?php }else{?>
 var selected_state = [];
 <?php }?>
 function display_city(val){ 
 		value='';
		if($('#state_'+val).is(':checked')) {
			selected_state.push(val);
			value = selected_state;
			var unique = value.filter(function(elem, index, self) {
   			 return index == self.indexOf(elem);
			})
			value = unique;// get unique value of selected  
		}else{
			//alert($('#state_'+val).val());
			var remv_item = $('#state_'+val).val();
			//alert(remv_item);
 			var index = selected_state.indexOf(remv_item);
 			if (index > -1) {
    			selected_state.splice(index, 1);
			}
			value =selected_state;
		}
		// alert(selected_state);
		$.ajax({
			type: "POST",
			beforeSend: function(){
				//alert(value);
				$("#all_selected_city").val(value)
				$('#city_div').val('Loading Cities..');
			},
			url: "<?php echo base_url(); ?>buzzadmn/getCities/",
			dataType:"json",
			data: {id:value,all_selected_city:$("#all_selected_area").val()},																 		
			success: function (msg) {
					
				//alert(msg['citys']);
				htmlData = msg['citys'];
				if(typeof msg['citys']=='undefined'){
					htmlData ='';
				}
 				$('#city_div').html(htmlData);
				
				if($('#state_'+val).is(':checked')){
					//alert('ssssss');display_area('',msg['areas']);
				}else{
					if(msg['areas']!=''){	
						var selected_cities_Id = [];
						var not_selected_cities_Id = [];
						$(msg['areas']).each(function (i,obj) {
							selected_cities_Id.push(obj);
							//alert('i='+i+'obj='+obj);
							if($('#city_'+obj).is(':checked')) {
							  //alert("elced"+selected_cities_Id);
								display_area('',selected_cities_Id);
							}else{
								
								not_selected_cities_Id.push(obj);
								display_area('',0);
							}
 						});
					}else{
						display_area('',0);
					}
				}
				//$("#all_selected_city").val(value)
 			} 
		});
		 
			 //alert($('.state_chk').is(':checked'));
			 if(!$(".state_chk_cl").is(":checked")){
				display_area('',0);
			 } 
	}
 //Get Area
 var selected_city= [];
 function display_area(val2='',directIds=''){
		value='';
		
		if($('#'+val2).is(':checked')) {
 			value2 = val2.replace("city_","");	
			selected_city.push(value2);
			value2 = selected_city;
 			 
		}else{
			var remv_item = $('#'+val2).val();//	alert(remv_item);
 			var index = selected_city.indexOf(remv_item);
 			if (index > -1) {
    			selected_city.splice(index, 1);
			}
			value2 =selected_city;
		}
		 if(val2=='' && directIds!=''){
			 value2 = directIds;
		 }
		
		  //alert('====='+value2);
			var unique2 = value2.filter(function(elem2, index2, self2) {// get unique value of selected City
   			 return index2 == self2.indexOf(elem2);
			})
			value2 = unique2;
			 if(val2=='' && directIds==''){
			 value2 = 0;
		 	}
		$.ajax({
			type: "POST",
			beforeSend: function(){
				$("#all_selected_area").val(value2)
				 $('#area_div').val('Loading Areas..');
			},
			url: "<?php echo base_url(); ?>buzzadmn/getArea/",
			dataType:"json",
			data: {id:value2},																 		
			success: function (msg) {																	
				$('#area_div').html(msg);
 			} 
		});
	}
 // Creating Url
 function make_Url(val){ 
 var st_id = '';
 
 st_id = '<?php echo $this->uri->segment(3);?>';
		$.ajax({
			 
			type: "POST",
			beforeSend: function(){
					 $('#url').val('generating url..');
					$('#url').prop('readonly', true);
					//$(".show_loader2").show();
			},
			url: "<?php echo base_url(); ?>buzzadmn/getURL/",
			dataType:"text",
			data: {urlName:val,id:st_id},
			async: true,				
			success: function (msg) {
				if(parseInt(msg)==1){
				 	$("#url").val('');
					$("#story_url_err").html('Title Already Exists').addClass('error');
					$("#title").addClass('error');
					$("#url").val('');
					$("#subHeadLine").addClass('error');
					$("input[type=submit]").attr('disabled','disabled');
				}else{
					$("input[type=submit]").removeAttr('disabled');	
					$("#url").val(msg);
					$("#title").removeClass('error');
					$("#subHeadLine").removeClass('error');
					$("#story_url_err").html('').removeClass('error');
				}
			} 
		});
	}
  //Wordcloud
  var editor = CKEDITOR.instances['pickDesc'];
  if (editor) {
    editor.on('blur', function(event) {
      var full_desc = CKEDITOR.instances['pickDesc'].getData();
      $.ajax({
        type: "POST",
        beforeSend: function(){
          $("#show_tags .tags").val("Getting most used words");
        },
        url: "<?php echo base_url(); ?>wordcloud/show_most_used_words/",
        dataType: "text",
        data: {full_desc:full_desc},
        async: true,
        success: function(res){
            $("#show_tags").fadeIn('slow');
            $("#show_tags .tags").html(res);
        }
      });
    });
  }

  var allVals = new Array();

  function get_tag( name ) {
  if( $("#" + name).is(':checked') == true ) {
    allVals.push(name);
  } else {
    allVals.splice( allVals.indexOf(name), 1 );
  }

  if ($( "#" + name ).prop( "checked" ) == true ) {
      $( '#' + name ).val( name );
      var chk_value = '1';
  } else {
      $( '#' + name ).val( '0' );
      var chk_value = '0';
  }
  
  $('#videoLink').val(allVals);}

$("#videoLink").change(function(){
  var tags = $(this).val();
  var tags_array = tags.split(',');
  var txt = capitalizeFirstLetter("veerendra");
  $('#videoLink').val($.unique(tags_array));
});

// Capitalize first letter of the string
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

$(document).ready(function(){
  var full_desc = CKEDITOR.instances['pickDesc'].getData();
      $.ajax({
        type: "POST",
        beforeSend: function(){
          $("#show_tags").fadeIn('slow');
          $("#show_tags .tags").val("Getting most used words");
        },
        url: "<?php echo base_url(); ?>wordcloud/show_most_used_words/",
        dataType: "text",
        data: {full_desc:full_desc},
        async: true,
        success: function(res){
          if(res) {
            $("#show_tags").fadeIn('slow');
            $("#show_tags .tags").html(res);
          }
        }
      });

    // Show Add Category field
    $('#addCat').click(function() {
        $('#addCatBlock').css('display', 'block');
    });

    // Hide Add Category field
    $('#removeCat').click(function() {
        $('#addCatBlock').css('display', 'none');
    });

    // Show Add Category field
    $('#addSubCat').click(function() {
        $('#addSubCatBlock').css('display', 'block');
    });

    // Hide Add Category field
    $('#removeSubCat').click(function() {
        $('#addSubCatBlock').css('display', 'none');
    });
	
	<!-----rockey-->
	$('.story_for_chk').click(function(){
                                var _chk1 = document.getElementById('Tracek Portal');
                                var _chk2 = document.getElementById('Cityspidey');
                                var _story_for = document.getElementById('story_for');
                                _story_for.value='';
                                if(_chk1.checked){
                                                _story_for.value='1';
                                }
                                if(_chk2.checked){
                                                _story_for.value='2';
                                }
                                if(_chk1.checked && _chk2.checked){
                                                _story_for.value='3';
                                }
                });

	
	});

// Add New Category
function addCategory() {
    var new_cat = $('#new_category').val();
    if(new_cat == ""){
        $('label#category_error').text("Please enter category name");
        $('#new_category').focus();
    }
    else{
        $('label#category_error').text("");

        // Ajax call function
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Tracek Portal_category/add_category_name",
            dataType: 'JSON',
            data: {new_cat:new_cat},
            async: true,
            success: function(res){
                console.log(res);
              if(res[0] == 1) {
                $("#category_error").text("Category exists! Please another");
                $("#category_error").addClass("error");
                $("#category_error").css('color','#FF0000');
              }
              else if(res[0] == 2) {
                $("#category_error").text("Category added successfully");
                $('select#category_id').append('<option value="' + res[1] + '">' + new_cat + '</option>');
                $("label#category_error").removeClass("error");
                $("label#category_error").css('color','#00FF00');
              }
            }
        });
    }}

// Add New Subcategory
function addSubCategory() {
    var new_subcat = $('#new_subcategory').val();
    var category_id = $('#category_id').val();

    if(category_id == ""){
        $('label#category_err').text("Please select category");
    }
    else{
        $('label#category_err').text("");
    }

    if(new_subcat == ""){
        $('label#subcategory_error').text("Please enter subcategory name");
        $( "#new_subcategory" ).focus();
    }
    else{
        $('label#subcategory_error').text("");
    }

    if((new_subcat != "") && (category_id != "")) {
        // Ajax call function
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Tracek Portal_category/add_subcategory_name",
            dataType: 'JSON',
            data: {new_subcat:new_subcat,parent_id:category_id},
            async: true,
            success: function(res){
              if(res[0] == 1) {
                $("label#subcategory_error").text("Sub Category exists! Please another");
                $("label#category_error").addClass("error");
                $("label#subcategory_error").css('color','#FF0000');
              }
              else if(res[0] == 2) {
                $("label#subcategory_error").text("Sub Category added successfully");
                $('select#sub_category_id').append('<option value="' + res[1] + '">' + new_subcat + '</option>');
                $("label#subcategory_error").removeClass("error");
                $("label#subcategory_error").css('color','#00FF00');
              }
            }
        });
    }}
</script>
 
<script type="text/javascript">
	function readURL(input) {
		
		 
	}



 </script>
<script src="<?php echo base_url().'assets/sb-js/spidey.js';?>"></script>
<?php $this->load->view('../includes/admin_footer'); ?>
<?php $this->load->view('../includes/spidey_buzz_js')?>