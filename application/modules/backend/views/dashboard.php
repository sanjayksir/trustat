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
												<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Product Name																</th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Type</th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Ordered</th>
															    <th class="hidden-480"><i class="ace-icon fa fa-caret-right blue"></i>Printed</th>
															    <th class="hidden-480"><i class="ace-icon fa fa-caret-right blue"></i>Activated</th>
															    <th class="hidden-480"><i class="ace-icon fa fa-caret-right blue"></i>Scanned</th>
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
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Product Name																</th>

																<th><i class="ace-icon fa fa-caret-right blue"></i>Order Status </th>
																<th><i class="ace-icon fa fa-caret-right blue"></i>Quantity </th>
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

