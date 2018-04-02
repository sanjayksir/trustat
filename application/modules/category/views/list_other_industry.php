<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Other Industry';?>

			<?php $this->load->view('../includes/admin_sidebar');?>
			
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo DASH_B;?>">Home</a>
							</li>

							<li>
							 Manage <?php echo $label;?>
							</li>
  						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							
						</div><!-- /.nav-search -->
					</div>
 					<div class="page-content">
						<?php if($this->session->flashdata('success')!=''){ ?> <div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
 									<i class="ace-icon fa fa-check green"></i>
 									<?php echo $this->session->flashdata('success'); ?>
								</div>
                        <?php } ?>
   						<div class="row">
							<div class="col-xs-12">
 								<div class="row">
									<div class="col-xs-12">
										<h3 class="header smaller lighter blue">List <?php echo $label;?></h3>
 										 
										<!--------------- Search Tab start----------------->
                            <div class="row"><form id="form-filter" action="" method="post" class="form-horizontal" onsubmit="return validateSrch();">
                                <table id="search" class="table table-hover display">
                                    
                                        <tbody>
                                        	<tr>
                                            	<td><input name="search" value="<?php if(!empty($this->input->post('search'))){echo $this->input->post('search');}?>" id="searchStr" placeholder="Search Records" class="form-control" type="text"></td>
                                            	<td>
                                                	<input type="submit" id="btn-filter" value="Search" name="Search" class="btn btn-primary btn-search">&nbsp;
                                                	<button type="button" id="btn-reset" class="btn btn-default btn-search">Reset</button>
                                            	</td>
                                         	</tr>
                                 		 </tbody>
                                   	
                                 </table></form>
                            </div>
                      <!--------------- Search Tab start----------------->
 										<!-- div.dataTables_borderWrap -->
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>#</th>
 														<th>Industry Name</th>  
 														<?php //if($this->session->userdata('admin_user_id')==0){?>
														<th>Remark</th>
 														<th>Created on</th>
 														<th>Action</th>
 													</tr>
												</thead>
												<tbody>

                                        <?php $i = 0;
 										//echo '<pre>';print_r($userListing);exit;
										if(count($userListing)>0){
                                        foreach ($userListing as $listData){
										$i++;
											$status = $listData['status'];
                                            if($status ==1){
											$status ='Active';
 												$colorStyle="style='color:white;border-radius:10px;background-color:green;border:none;'";
											}else{
											$status ='Inactive';
												$colorStyle="style='color:black;border-radius:10px;background-color:red;border:none;'";
											}?>
                                               <tr id="show<?php echo $listData['id']; ?>">
											   <td><?php echo $i; ?></td>
 												<td>
												<?php echo $cats = show_industry_by_level_wise($listData['id']);?>
												<?php if($cats!=''){echo '<br />&nbsp;&nbsp;-->';}echo '<b>'.$listData['industry_name'] .'</b>'; ?></td>
												<th><?php echo $listData['remark'];?></th>
 												<td><?php echo date('d/M/Y',strtotime($listData['created_date'])); ?></td>
                                                 <td>
                                                     <div class="hidden-sm hidden-xs action-buttons">
                                                          <?php echo anchor("category/edit_other_industry/" . $listData['id'], '<i class="ace-icon fa fa-pencil bigger-130"></i>', array('class' => 'green','title'=>'Edit')); ?>
                                                         <input <?php echo $colorStyle; ?>type="button" name="status" id="status_<?php echo $listData['id'];?>" value="<?php echo $status ;?>" onclick="return change_status('<?php echo $listData['id'];?>',this.value);" />
                                                     </div>
                                                 </td>
                                             </tr>
                                         <?php }
										} ?>

                                    </tbody><tr><td align="right" colspan="10" class="color"><?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?></td></tr>
											</table>
  								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
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
			</div><!-- /.main-content -->

			 

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
<?php $this->load->view('../includes/admin_footer');?>
<script>
function validateSrch(){
	$("#searchStr").removeClass('error');
	var val = $("#searchStr").val();
 	if(val.trim()==''){
		$("#searchStr").addClass('error');
		return false;
	}
}			
function change_status(id,val){
	if (confirm("Are you sure want to  change Status!"))
	{
		$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>category/change_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(parseInt(result)==1){
						$('#status_'+id).val('Active').css("background-color","green");
					}else{
						$('#status_'+id).val('Inactive').css("background-color","red");
					}
 				}
			});
	}else{
		return false;
	}
 }
 
 

 
</script>
<?php $this->load->view('../includes/admin_footer');?>