<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); 
  $record_num = end($this->uri->segment_array());
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
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                       <a href="<?php echo DASH_B;?>">Home</a>
                    </li>

                    <li> Editorial Section </li>
                    <li class="active">Story listing</li>
                </ul><!-- /.breadcrumb -->

                <div class="nav-search" id="nav-search">
                    <form class="form-search" method="post" name="frm_search" id="frm_search">
                        <span class="input-icon">
                            <input type="text" placeholder="Search ..." class="nav-search-input" id="search" name="search" autocomplete="off" value="<?php echo $this->input->post('search'); ?>"  />
                            <i class="ace-icon fa fa-search nav-search-icon" onclick="$('#frm_search').submit();" ></i>
                        </span>
                    </form>
                </div><!-- /.nav-search -->
            </div>

            <div class="page-content">
                <?php if ($feedback = $this->session->flashdata('feedback')) { ?>
                    <div class="alert alert-dismissible <?php echo $this->session->flashdata('feedback_class') ?>">
                        <strong><?php echo $feedback; ?></strong>
                    </div>
                <?php } ?>
                <div id="ajax_msg"></div>
                <div class="row">
                    <div class="col-xs-12">
                      <div class="row">
                            <div class="col-xs-12">
                                <h3 class="header smaller lighter blue">SPIDEY BUZZ DIRECTORY</h3>
								 <div>
                                <a href="<?php echo base_url();?>buzzadmn/slider_settings" class="btn btn-primary pull-left" title="Set slider stories">Slider Setting</a>
                                </div>
                                <div style="clear:both;"><?php echo anchor('buzzadmn/addSpidyBuzz', 'ADD SPIDEY BUZZ', array('class' => 'btn btn-primary pull-right','title'=>'ADD SPIDEY BUZZ')); ?></div>
                                <!-- div.table-responsive -->
                                 <!-- div.dataTables_borderWrap -->
                                 <table class="table table-striped table-bordered table-hover display">
                                     <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>spidey Title</th>
                                            <th>CreatedDate</th>
                                            <th>CreatedBy</th>
                                            <th>ModifiedDate</th>
                                            <th>ModifiedBy</th>
                                            <th>View</th>
                                            <th>Like</th>
                                            <th>Comments</th> 
											<th>Is breaking</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php $cnt_i=0;
										 if(intval($record_num)==true){
											 $cnt_i = $record_num;
										 }
                                        foreach ($spideypiclist as $buzz):
 										$cnt_i++;;
                                            ?>
                                            <tr id="show<?php echo $buzz['spidypickId']; ?>">
                                                <td><?php echo $cnt_i; ?></td>
                                                <td><?php echo anchor("buzzadmn/addSpidyBuzz/" . $buzz['spidypickId'], $buzz['spidyName'], array('class' => 'green', 'title' => 'Clk to edit')); ?></td>
                                                <td><?php echo $buzz['createdDate']; ?></td>
                                                <td><?php echo getSpideyUserDetail($buzz['createdby']); ?></td>
                                                <td><?php echo $buzz['updatedOn']; ?></td>
                                                <td><?php echo ($buzz['updatedby']) ? getSpideyUserDetail($buzz['updatedby']) : ''; ?></td>
                                                <td><?php echo getSpidypickViewCount($buzz['spidypickId']); ?></td>
                                                <td><?php echo $buzz['likes']; ?></td>
                                                <td><?php //echo getSpidypickCommentsCount($buzz['spidypickId']); ?></td>
												<td><label class="middle">
												 <input type="hidden" name="user_select[]" id="hid_<?php echo $buzz['spidypickId']; ?>;" value="<?php
                                                                                    if ($buzz['is_breaking_news']) {
                                                                                        $buzz['spidypickId'];
                                                                                    } else {
                                                                                        echo '0';
                                                                                    }
                                                                                    ?>" />
												<input class="ace story_select" id="<?php echo $buzz['spidypickId']; ?>" <?php if ($buzz['is_breaking_news']) echo "checked='checked'"; ?>value="<?php echo $buzz['spidypickId']; ?>" type="checkbox">
												<span class="lbl"></span>
												</label>
												</td>
                                                <td>
                                                    <div class="hidden-sm hidden-xs action-buttons">
													<?php $storyUrl =  getstoryurl($buzz['spidypickId']);
													?>
                                                        <a href="<?php  echo $storyUrl['url'];?>" class="blue" target="_blank" title="View Story"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>
													   <?php echo anchor("buzzadmn/addSpidyBuzz/" . $buzz['spidypickId'], '<i class="ace-icon fa fa-pencil bigger-130"></i>', array('class' => 'green', 'title' => 'Edit Story')); ?>
                                                        <?php
															$color = ($buzz['status']) ? " title='Active' style='color:green;'" : "title='Inactive' style='color:red;'";
															$title = ($buzz['status']) ? " title='Active'" : "title='Inactive'";
															$action_anchor = anchor("buzzadmn/spideyStatus/" . $buzz['spidypickId'] . "/" . $buzz['status'] . "", '<i class="ace-icon fa fa-circle bigger-130" ' . $color . '></i>', $title);
                                                         echo $action_anchor;
                                                        ?>
                                                    </div>
                                                </td>
                                             </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php echo $this->pagination->create_links(); ?>
                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->
             <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder">Cityspidey</span>
                            2017
                        </span>
                         &nbsp; &nbsp;
                        <span class="action-buttons">
                            <a href="#"><i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i></a>
                            <a href="#"><i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i></a>
                            <a href="#"><i class="ace-icon fa fa-rss-square orange bigger-150"></i></a>
                        </span>
                    </div>
                </div>
            </div>
             <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
		<script type="text/javascript">
		$('.story_select').click(function () {
			var url = "<?php echo base_url().'buzzadmn/togglebreakingnews';?>";
			var this_id = $(this).attr('id');
            var chk_val = 0;
			 if ($(this).prop("checked") == true) {
				var box= confirm("Are you sure you want to make this story breaking?");
                if (box==true){alert('dffs');
				$('#hid_' + this_id).val(this_id);
                chk_val=1;
				 }else{
					 return false;
				 }
            } else {
				var box= confirm("Are you sure you want to remove this story as breaking?");
                if (box==true){
				$('#hid_' + this_id).val('0');
				 }else{
					 return false;
				 }
                }		
			$.ajax({
					'url': url,
					data:{"save_chk":true, "story_id":this_id, "chk_val":chk_val},
					type:"POST",
					success:function(msg){
						 if(msg == 2)
						 alert("Maximum breaking news reached");
						 if(msg == 3){
						 alert("Please enter breaking news title from detail page");	
						 $(this).removeAttr('checked');
						 }						
					}					
				})
				 
			});
	</script>
    <?php $this->load->view('../includes/admin_footer'); ?>
