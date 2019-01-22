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

          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo DASH_B; ?>">Home</a> </li>

          <li class="active">Dashboard</li>

        </ul>

      </div>

      <?php 

	  $login_type = $this->session->userdata('login_type');

	  if($login_type=='reporter'){

		  $url_list = "listing";

	  }elseif($login_type=='input'){

		  $url_list = "manage";

	  }

	  elseif($login_type=='output1'){

		  $url_list = "manage";

	  }

	//  editorial_logIn_By_Designation($user_id);

	  

	  ?>

      <div class="page-content">

        <div class="row">

							<div class="col-xs-12">

								<!-- PAGE CONTENT BEGINS -->

								<div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>									
									</button>

									<i class="ace-icon fa fa-check green"></i>				 
									Welcome to
									<strong class="green">
										Dashboard
									</strong> 
								</div>
								
								<div class="row">
								<div class="col-sm-7">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Barcodes Status
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-4">
												<table class="table table-bordered table-striped" style="display: block; height: 300px; overflow-y: auto">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Barcode																</th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Product Name</th>

																
															    <th class="hidden-480"><i class="ace-icon fa fa-caret-right blue"></i>Status</th>
															    
																<th class="hidden-480"><i class="ace-icon fa fa-caret-right blue"></i>Purhased</th>
															</tr>
														</thead>
						
										<tbody>

    <?php $i = 0;  //  echo '***<pre>';print_r($orderListing); 
                                            if(count($PrintedCodeListing)>0){
                                                    $i=0;
                                                    $page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
                                                    $sno =  $page + 1;
    foreach ($PrintedCodeListing as $key=>$listData){
                                                    $i++;
                                                    ?>
           <tr id="show<?php echo $key; ?>">
															<td class="hidden-480"><?php echo $listData['barcode_qr_code_no']; ?></td>
                                                            <td class="hidden-480"><?php echo $listData['product_name']; ?></td>
                                                            <td>

                                                            <?php 												

                                                             $activeinactive = $listData['active_status'];
                                                             if ($activeinactive == 1)
                                                                     { echo "Active";
                                                                     } else { 
                                                                     echo "Inactive";
                                                                     }

                                                              ?>
                                                            </td>
                                                             <td><?php //echo isProductCodeRegistered($listData['barcode_qr_code_no']); ?>
															 <?php 												

                                                             $isProductCodeRegistered = isProductCodeRegistered($listData['barcode_qr_code_no']);
                                                             if ($isProductCodeRegistered == true)
                                                                     { echo "Yes";
                                                                     } else { 
                                                                     echo "No";
                                                                     }

                                                              ?>
															 </td>
															  
															 
          </tr>
     <?php 
     $sno++;
     }
                                            }else{ ?>
                                            <tr><td align="center" colspan="9" class="color error">No Records Founds</td></tr>
                                            <?php }?>
                                        </tbody>
													</table>
													<div id="sales-charts"></div>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>
								
								
								
								
								<div class="col-sm-5">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Order Status
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped" style="display: block; height: 300px; overflow-y: auto">
														<thead class="thin-border-bottom">
															<tr>
																<th><i class="ace-icon fa fa-caret-right blue"></i>Order Number</th>
																<th><i class="ace-icon fa fa-caret-right blue"></i>Product Name </th>
																<th><i class="ace-icon fa fa-caret-right blue"></i>Order Status</th>
															</tr>
														</thead>
														<tbody>

                                        <?php 
                                        $i = 0; 

                                        if(count($orderListing)>0){
                                            $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
                                            $sno =  $page + 1;
                                            foreach ($orderListing as $listData){
                                                $essentialAttributeArr = array();
                                                $essentialAttributeArr = getEssentialAttributes($listData['product_id']);
                                                // echo '***<pre>';print_r($essentialAttributeArr);
                                                $i++;
                                                $status = $listData['status'];
    if($status ==1){
                                                $status ='Active';
                                                        $colorStyle="style='color:white;border-radius:10px;background-color:green;border:none;'";
                                                }else{
                                                $status ='Inactive';
                                                        $colorStyle="style='color:black;border-radius:10px;background-color:red;border:none;'";
                                                }?>
												  <tr id="show<?php echo $listData['order_id']; ?>">
                                                   <td><?php  echo $listData['order_no']; ?></td>
												   <td><?php echo $listData['product_name']; ?></td>
          
                                                        <?php if($this->session->userdata('admin_user_id')==1){
                                                                //echo $listData['user_id'].'**'.$this->session->userdata('admin_user_id');		

                                                                                if($this->session->userdata('admin_user_id')!=$listData['user_id']){
                                                                                        $print_opt = 0;
                                                                                }else{
                                                                                        $print_opt = 1;
                                                                                }

                                                                ?>

                                                         <td>
         <?php //if($essentialAttributeArr['delivery_method']==4){?>
                <select name="change_order_status" id="change_order_status" onchange="return change_order_status('<?php echo $listData['order_id'];?>',this.value,'<?php echo $print_opt;?>');">
                                                                <option value="0" <?php if($listData['order_status']=='0'){echo 'selected';}?>>Pending</option>
                                                                <option value="1" <?php if($listData['order_status']=='1'){echo 'selected';}?>>Accepted</option>
                                                                <option value="2" <?php if($listData['order_status']=='2'){echo 'selected';}?>>Rejected</option>
                                                                </select>
        <?php //}else{
                                                                //echo 'Hard Print';
                                                        //}?>
                                                        </td> 
                                                        <?php }else{?>
                                                         <td><?php echo order_status($listData['order_status']); ?></td>
                                                        <?php }?>
                                                        
         
     </tr>
    <?php 
    }
 }else{
    ?>
    <tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
<?php         
 }
 ?>

                </tbody>
														
														<!--
														<tbody>
															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>
														</tbody>
														-->
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>
									
									
									
									</div>
								
					<!--================================		-->	
								
								
						<div class="row">
						
						<div class="col-sm-7">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Report 1
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-4">
												<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 1 </th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 2 </th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 3 </th>
															    <th class="hidden-480">Field 4 </th>
															    <th class="hidden-480">Field 5 </th>
															    <th class="hidden-480">Field 6 </th>
															</tr>
														</thead>

														<tbody>
															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>
														</tbody>
													</table>
													<div id="sales-charts"></div>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>
									
									
								<div class="col-sm-5">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Report 2
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																		<i class="ace-icon fa fa-caret-right blue"></i>Field 1  																</th>

																<th><i class="ace-icon fa fa-caret-right blue"></i>Field 2 </th>
																<th><i class="ace-icon fa fa-caret-right blue"></i>Field 3 </th>
															</tr>
														</thead>

														<tbody>
															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>
									
									<div class="col-sm-7">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Report 3
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-4">
												<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 1  </th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 2  </th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 3  </th>
															    <th class="hidden-480">Field 4 </th>
															    <th class="hidden-480">Field 5 </th>
															    <th class="hidden-480">Field 6 </th>
															</tr>
														</thead>

														<tbody>
															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>
														</tbody>
													</table>
													<div id="sales-charts"></div>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>
									
									
									<div class="col-sm-5">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Report 4
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 1  </th>

																<th><i class="ace-icon fa fa-caret-right blue"></i>Field 2 </th>
																<th><i class="ace-icon fa fa-caret-right blue"></i>Field 3 </th>
															</tr>
														</thead>

														<tbody>
															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>
									
									
									</div>
									<!--================================		-->	
									<div class="row">
									
									
									
								
									
									<div class="col-sm-7">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Report 5
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-4">
												<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 1  </th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 2  </th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 3  </th>
															    <th class="hidden-480">Field 4 </th>
															    <th class="hidden-480">Field 5 </th>
															    <th class="hidden-480">Field 6 </th>
															</tr>
														</thead>

														<tbody>
															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>

																<td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															    <td class="hidden-480">&nbsp;</td>
															</tr>
														</tbody>
													</table>
													<div id="sales-charts"></div>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>
									
									<div class="col-sm-5">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Report 6
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Field 1  </th>

																<th><i class="ace-icon fa fa-caret-right blue"></i>Field 2 </th>
																<th><i class="ace-icon fa fa-caret-right blue"></i>Field 3 </th>
															</tr>
														</thead>

														<tbody>
															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>

															<tr>
																<td>&nbsp;</td>

																<td>&nbsp;</td>
																<td>&nbsp;</td>
															</tr>
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div>
									
									</div>


								
						</div>
		
		

        <!-- /.row --> 

      </div>

      <!-- /.page-content --> 

    </div>

  </div>
  
  

  <!-- /.main-content --> 

  <!-- Admin Footer Content -->

  <?php $this->load->view('../includes/admin_footer_content');?>

  <!-- Ends - Admin Footer Content --> 

</div>

<!-- /.main-container -->



<div class="modal fade" id="addTabModal" role="dialog">

  <div class="modal-dialog"> <span id="add_modal_popup"> </span> 

    

    <!-- Modal content-->

    <div class="modal-content"></div>

  </div>

</div>

<script src="<?php echo ASSETS_PATH;?>js/jquery.bootstrap-duallistbox.min.js"></script> 

<script src="<?php echo ASSETS_PATH;?>js/jquery.raty.min.js"></script> 

<script src="<?php echo ASSETS_PATH;?>js/bootstrap-multiselect.min.js"></script> 

<script src="<?php echo ASSETS_PATH;?>js/select2.min.js"></script> 

<script src="<?php echo ASSETS_PATH;?>js/jquery-typeahead.js"></script> 

<script>

	// Tabs Script

	$(document).ready(function(){

		$('.nav-tabs li:first').addClass('active');

		$('.tab-content div:first').addClass('in active') 

	})



	// Submit questions using Ajax

	$("input[name='rwa_submit']").click(function(event) {

        event.preventDefault();



        var rwa_type = $(this).closest("form").attr('id');



		$.ajax({

			url: "<?php echo base_url(); ?>Myspidey_rwasetup/add_ajax_data",

			data: $("#"+rwa_type).serialize(),

			type: "POST",

			success: function(res) {

				if (res == 1)

				{ 

					$('#ajax_msg').html('<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><i class="ace-icon fa fa-check green"></i>Data has been stored sucessfully.</div>');

				}

			},

		});

	});



	jQuery(function($){

	    var demo1 = $('select[name="rwa_columns[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});

		var container1 = demo1.bootstrapDualListbox('getContainer');

		container1.find('.btn').addClass('btn-white btn-info btn-bold');

	

		/**var setRatingColors = function() {

			$(this).find('.star-on-png,.star-half-png').addClass('orange2').removeClass('grey');

			$(this).find('.star-off-png').removeClass('orange2').addClass('grey');

		}*/

		$('.rating').raty({

			'cancel' : true,

			'half': true,

			'starType' : 'i'

			/**,

			

			'click': function() {

				setRatingColors.call(this);

			},

			'mouseover': function() {

				setRatingColors.call(this);

			},

			'mouseout': function() {

				setRatingColors.call(this);

			}*/

		})//.find('i:not(.star-raty)').addClass('grey');

		

		

 		//////////////////

		//select2

		$('.select2').css('width','200px').select2({allowClear:true})

		$('#select2-multiple-style .btn').on('click', function(e){

			var target = $(this).find('input[type=radio]');

			var which = parseInt(target.val());

			if(which == 2) $('.select2').addClass('tag-input-style');

			 else $('.select2').removeClass('tag-input-style');

		});

		

		//////////////////

		$('.multiselect').multiselect({

		 enableFiltering: true,

		 enableHTML: true,

		 buttonClass: 'btn btn-white btn-primary',

		 templates: {

			button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> &nbsp;<b class="fa fa-caret-down"></b></button>',

			ul: '<ul class="multiselect-container dropdown-menu"></ul>',

			filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',

			filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',

			li: '<li><a tabindex="0"><label></label></a></li>',

	        divider: '<li class="multiselect-item divider"></li>',

	        liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'

		 }

		});

	

		

		///////////////////

			

		//typeahead.js

		//example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/

		var substringMatcher = function(strs) {

			return function findMatches(q, cb) {

				var matches, substringRegex;

			 

				// an array that will be populated with substring matches

				matches = [];

			 

				// regex used to determine if a string contains the substring `q`

				substrRegex = new RegExp(q, 'i');

			 

				// iterate through the pool of strings and for any string that

				// contains the substring `q`, add it to the `matches` array

				$.each(strs, function(i, str) {

					if (substrRegex.test(str)) {

						// the typeahead jQuery plugin expects suggestions to a

						// JavaScript object, refer to typeahead docs for more info

						matches.push({ value: str });

					}

				});

	

				cb(matches);

			}

		 }

	

		 $('input.typeahead').typeahead({

			hint: true,

			highlight: true,

			minLength: 1

		 }, {

			name: 'states',

			displayKey: 'value',

			source: substringMatcher(ace.vars['US_STATES']),

			limit: 10

		 });

  		///////////////

 		

		//in ajax mode, remove remaining elements before leaving page

		$(document).one('ajaxloadstart.page', function(e) {

			$('[class*=select2]').remove();

			$('select[name="rwa_columns[]"]').bootstrapDualListbox('destroy');

			$('.rating').raty('destroy');

			$('.multiselect').multiselect('destroy');

		});

 	});

	

</script>
<div style="height:70px"> </div>
<?php $this->load->view('../includes/admin_footer');?>

