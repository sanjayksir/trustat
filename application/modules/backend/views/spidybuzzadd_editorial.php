<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); ?>
<?php  //echo '<pre>';print_r($buzz[0]['zone_id']);exit;?>

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
                    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
                    <li> <a href="#">Master</a> </li>
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

                                                    <?php echo form_open_multipart(($buzz[0]['spidypickId']) ? 'buzzadmn/saveSpidyBuzz_editorial' : 'buzzadmn/saveSpidyBuzz_editorial', array('onsubmit' => 'return form_validate();'   )); ?>
                                                    <input type="text" name="post_id" value="<?php echo $this->uri->segment(3);?>"
                                    <div class="form-group">
                                                        <div class="add-spidey">
                                                            <label><strong>Spidey Title</strong><span class="strick"><sup>*</sup>
                                                            <font size="1" id="max_limit">(Maximum characters:80)<br>You have <input readonly type="text" name="countdown3" size="3" value="80" style="width: 28px;height: 28px;text-align: center;border-radius: 100% !important;"> characters left.</font></label><span id="story_url_err"></span>
                                                            <input type="text" name="title" value="<?php echo $buzz[0]['spidyName']; ?>" class="form-control" id="title"  onKeyDown="limitText(this.form.title,this.form.countdown3,80);" onblur="return make_Url(this.value);" onKeyUp="limitText(this.form.title,this.form.countdown3,80);" style="<input readonly="" type="text" name="countdown3" size="3" value="80"  >
                                                        </div>
                                                        
                                                        <div class="add-spidey">
                                                            <label><strong>Story Url</strong><span class="strick"><sup>*</sup>
                                                             </label>
                                                            <input type="text" name="url" value="<?php echo $buzz[0]['story_url']; ?>" readonly="readonly" class="form-control" id="url" type="text"  >
                                                        </div>
                                                        
                                                        <div class="add-spidey">
                                                            <label><strong>Short Description </strong></label>
                                                            <textarea onKeyDown="limitText(this.form.headline,this.form.countdown4,250);" onKeyUp="limitText(this.form.headline,this.form.countdown4,250);" name="headline" cols="40" rows="10" class="form-control" id="headline"><?php echo $buzz[0]['headline']; ?></textarea>
                                                        </div>

                                                        <div class="add-spidey">
                                                            <label><strong>Full Description</strong></label>
                                                            <textarea name="pickDesc" cols="40" rows="50" class="form-control" id="pickDesc"><?php echo $buzz[0]['pickDesc']; ?></textarea>
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
                                                             <label><strong>Making Tricky news:</strong></label>
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
                                                                  <label>Spidey Large Image<b> (1024X580)px </b>  </label><br>
                                                                  <style>
																		.file {
																			visibility: hidden;
																			position: absolute;
																		}

																  </style>
                                                                  
                                                                <div class="form-group">
                                                                    <input type="file" name="spideyImage" id="spideyImage" class="file" onchange="return validateImage2(this.files,'1024', '580');">
                                                                    <div class="input-group col-xs-12">
                                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                      <input id="largeImageBx" type="text" class="form-control input-lg" disabled placeholder="Upload Image">
                                                                      <span class="input-group-btn">
                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                      </span>
                                                                    </div>
                                                                </div>
                                                             
                                                                    <br>
                                                                </div>
                                                                 
                                                            </div>
                                                        </div>
														<!------------- UPLOAD BANNER IMAGES ------------------------>
                                                        <div  class="col-xs-12 col-sm-12" style="border: 1px dotted #d4d4d4;background: #f3f3f3;">
                                                        <span><h4 class="header lighter black">Banner Images:</h4></span>
														<div class="add-spidey">
                                                             
                                                            <div class="row">
                                                                <div class="col-xs-6 col-sm-6"> <label><strong>Spidey Large Image1</strong><b> (400X195)px </b></label> <br>
                                                                
                                                                
                                                                <div class="form-group">
                                                                    <input type="file" name="spideyImage1" id="spideyImage1" class="file" onchange="return validateImage(this.files,'400', '195','largeImageBx1');">
                                                                    <div class="input-group col-xs-12">
                                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                      <input id="largeImageBx1" type="text" class="form-control input-lg" disabled placeholder="Upload Image">
                                                                      <span class="input-group-btn">
                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                      </span>
                                                                    </div>
                                                                </div>
                                                                
                                                                    <br>
                                                                </div>
                                                                <div class="col-xs-6 col-sm-6"> <label><strong>Spidey Small Image1</strong><b>(195X400)px</b></label><br>
                                                                     <div class="form-group">
                                                                    <input type="file" name="spideyImageSmall1" id="spideyImageSmall1" class="file" onchange="return validateImage(this.files,'195', '400','largeImageBx2');">
                                                                    <div class="input-group col-xs-12">
                                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                      <input id="largeImageBx2" type="text" class="form-control input-lg" disabled placeholder="Upload Image">
                                                                      <span class="input-group-btn">
                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                      </span>
                                                                    </div>
                                                                </div>
                                                                     
                                                                     
                                                                     
                                                                      
                                                                    <br>
                                                                </div>
                                                            </div>
                                                        </div>
														<div class="add-spidey">
                                                             
                                                            <div class="row">
                                                                <div class="col-xs-6 col-sm-6"> <label><strong>Spidey Large Image2</strong><b> (195X195)px </b></label> <br>
                                                                     
                                                                     <div class="form-group">
                                                                    <input type="file" name="spideyImage2" id="spideyImage2" class="file" onchange="return validateImage(this.files,'195', '195','largeImageBx3');">
                                                                    <div class="input-group col-xs-12">
                                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                      <input id="largeImageBx3" type="text" class="form-control input-lg" disabled placeholder="Upload Image">
                                                                      <span class="input-group-btn">
                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                      </span>
                                                                    </div>
                                                                </div>
                                                                      <br>
                                                                </div>
                                                                <div class="col-xs-6 col-sm-6"> <label><strong>Spidey Small Image2</strong><b>(400X400)px</b></label><br>
                                                                   
                                                                     
                                                                <div class="form-group">
                                                                    <input type="file" name="spideyImageSmall2" id="spideyImageSmall2" class="file" onchange="return validateImage(this.files,'400', '400','largeImageBx4');">
                                                                    <div class="input-group col-xs-12">
                                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                      <input id="largeImageBx4" type="text" class="form-control input-lg" disabled placeholder="Upload Image">
                                                                      <span class="input-group-btn">
                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                      </span>
                                                                    </div>
                                                                </div>
                                                               
                                                                    <br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <!------------- UPLOAD BANNER IMAGES ------------------------>
                                                        
                                                        <div class="add-spidey">

                                                            <div class="row">
                                                                <div class="col-xs-6 col-sm-6"><label>Photo Credit </label> <br>
                                                                    <input type="text" name="photocredit" value="<?php echo $buzz[0]['photocredit']; ?>" class="form-control" id="photocredit">
                                                                </div>
                                                                <div class="col-xs-6 col-sm-6"> <label>Photo Caption </label> <br>
                                                                    <input type="text" name="photocaption" value="<?php echo $buzz[0]['photocaption']; ?>" class="form-control" id="photocaption">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="add-spidey">
                                                            <div class="row">
                                                                <div class="col-xs-6 col-sm-6"><label>Source / By / Line <span class="strick">*</span></label> <br>
                                                                    <input type="text" name="subHeadLine" value="<?php echo $buzz[0]['subHeadLine']; ?>" class="form-control" id="subHeadLine">
                                                                </div>
                                                                <?php //echo '<pre>';print_r($buzz[0]['category_id']);exit;?>
                                                                <div class="col-xs-3 col-sm-3"> <label>Category <span class="strick">*</span></label> <br>
                                                                    <select name="category_id" id="category_id" class="form-control" onchange="return getSubcategory(this.value);">
                                                                    	<option value=""> - Select Category -</option>
                                                                        <?php foreach ($categories as $cat) { ?>
                                                                            <option value="<?php echo $cat['category_Id']; ?>" <?php echo ($buzz[0]['category_id'] == $cat['category_Id']) ? 'selected' : ''; ?> ><?php echo $cat['categoryName']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xs-3 col-sm-3"> <label>Sub Category <span class="strick">*</span></label> <br>
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
                                                                    <input type="text" name="related_storyTxt" value="<?php echo $buzz[0]['related_storyTxt']; ?>" class="form-control" id="related_storyTxt" onblur="get_stories();">
                                                                    <input type="hidden" name="related_stories" id="related_stories"  class="form-control" value="<?php echo $buzz[0]['related_storyId']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <div class="related_story_toggle_chk">
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
                                                                <div id="relatedId" class="col-xs-12">
                                                                    <?php
                                                                    if (!empty($buzz[0]['spidypickId']) || !empty($buzz[0]['related_storyTxt'])) {
                                                                        echo $related_story;
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="add-spidey">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12"><label>TAGS*</label> <br>
                                                                    <textarea name="videoLink" cols="40" rows="10" class="form-control" id="videoLink" row="2"><?php echo $buzz[0]['tags']; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <!--------------- Area of the story-------------------->
                                                        
                                                        <input type="hidden" id="all_selected_city" name="all_selected_city" /><input type="hidden" id="all_selected_area" name="all_selected_area" />
                                                        <div class="col-xs-12 col-sm-12" style="border: 1px dotted #d4d4d4;background: #f3f3f3;">
                                                        <span><h4 class="header lighter black">Select Story Area:</h4></span>
														<div class="add-spidey">
                                                             
                                                            <div class="row">
                                                                <div class="col-xs-4 col-sm-4"> <label><strong>State</strong></label> <br>
                                                                  <div class="form-group">
                                                                     <div class="input-group col-xs-12">
                                                                      <span class="form-group" id="state_div"> 
                                                                       <?php 
																	   ## Fetch Story
																	   $zone_id_arr =array();
																	   if(!empty($buzz[0]['area_id'])){
																	   		$zone_id_arr =  explode(',',$buzz[0]['area_id']); 
																			 $city_arr = getCityFromArea($zone_id_arr);
																			 // print_r($city_arr);
																			$state_arrIds = array();
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
                                                                              <input <?php echo $selected;?> id="state_<?php echo $s['state_id']; ?>" type="checkbox" class="state_chk_cl" name="state[]" value="<?php echo $s['state_id']; ?>" onclick="return display_city(this.value);"></div>
                                                                     	<?php }?>
                                                                        
                                                                        
                                                                      </span>
                                                                     </div>
                                                                   </div>
                                                                     <br>
                                                                </div>
                                                                <div class="col-xs-4 col-sm-4"> <label><strong>City</strong></label> <br>
                                                                  <div class="form-group">
                                                                     <div class="input-group col-xs-12" >
                                                                     <span class="form-group" id="city_div"> 
                                                                        
                                                                       </span>
                                                                     </div>
                                                                </div>
                                                                     <br>
                                                                </div>
                                                                <div class="col-xs-4 col-sm-4"> <label><strong>Area</strong></label> <br>
                                                                  <div class="form-group">
                                                                     <div class="input-group col-xs-12">
                                                                      <span class="form-group" id="area_div"> 
                                                                       </span>
                                                                     </div>
                                                                </div>
                                                                     <br>
                                                                </div>
                                                            </div>
                                                        </div>
														 	
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
			 <script>
			 CKEDITOR.replace( 'pickDesc', {
								filebrowserBrowseUrl :'<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
			                    filebrowserImageBrowseUrl : '<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
			                    filebrowserFlashBrowseUrl :'<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
								filebrowserUploadUrl  :'<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
								filebrowserImageUploadUrl : '<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
								filebrowserFlashUploadUrl : '<?php echo base_url('assets/ckeditor/plugins');?>/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
								
							} );
				</script>
<script>
 //Get City
 var selected_state = [];
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
			var remv_item = $('#state_'+val).val();
 			var index = selected_state.indexOf(remv_item);
 			if (index > -1) {
    			selected_state.splice(index, 1);
			}
			value =selected_state;
		}
		 //alert(selected_state);
		$.ajax({
			type: "POST",
			beforeSend: function(){
				$("#all_selected_city").val(value)
				$('#city_div').val('Loading Cities..');
			},
			url: "<?php echo base_url(); ?>buzzadmn/getCities/",
			dataType:"json",
			data: {id:value,all_selected_city:$("#all_selected_area").val()},																 		
			success: function (msg) {//alert(msg['citys']);	
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
		$.ajax({
			type: "POST",
			beforeSend: function(){
					 $('#url').val('generating url..');
					$('#url').prop('readonly', true);
					//$(".show_loader2").show();
			},
			url: "<?php echo base_url(); ?>buzzadmn/getURL/",
			dataType:"text",
			data: {urlName:val},
			async: true,				
			success: function (msg) {
				if(parseInt(msg)==1){
				 	$("#url").val('');
					$("#story_url_err").html('Title Already Exists').addClass('error');
					$("#title").addClass('error');
					$("#url").val('');
					$("input[type=submit]").attr('disabled','disabled');
				}else{
					$("input[type=submit]").removeAttr('disabled');	
					$("#url").val(msg);
					$("#title").removeClass('error');
					$("#story_url_err").html('').removeClass('error');
				}
			} 
		});
	}
</script>
<script src="<?php echo base_url().'assets/sb-js/spidey.js';?>"></script>
<?php $this->load->view('../includes/admin_footer'); ?>
<?php $this->load->view('../includes/spidey_buzz_js')?>