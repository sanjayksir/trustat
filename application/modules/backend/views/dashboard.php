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
							<!--
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
								-->
								 <?php if($this->session->userdata('admin_user_id')==1) { ?>
								
											
								<div class="col-xs-12">
								<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Pending Approvals
												</h4>
											</div>
										<table id="simple-table" class="table  table-bordered table-hover">
											<thead>
												<tr>
													
													<th>Issuing QR codes</th>
													<th>Advertisements</th>
													<th>Survey</th>
													<th>Messages</th>
													<th> Loyalty Redemptions</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><a href="#"><?php echo $NumberofPendingCodePrintOrders;?></a></td>
													<td><a href="#"><?php echo $NumberofPendingAdvertisementOrders;?></a></td>
													<td><a href="#"><?php echo $NumberofPendingSurveyOrders;?></a></td>
													<td><a href="#"><?php echo $NumberofPendingMessagesOrders;?></a></td>
													<td><a href="#"><?php echo $NumberofPendingLoyaltyRedemptionsRequests;?></a></td>
												</tr>
											</tbody>
										</table>
									</div>	
								<br />
								
								<div class="col-xs-12">
								<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Consumer Dashboard
												</h4>
											</div>
										<table class="table table-bordered table-striped" style="display: block; height: 450px; overflow-y: auto">
											<thead>
												<tr>
													<th>S. No.</th> 
													<th>Consumer Dashboard</th>
													<th>Number of Registered Consumers</th>
													<th>No. of times scanned products for level 0</th>
													<th>No. of times scanned products for level 1</th>
													<th>Watched pushed Advertisement</th>
													<th>Feedback Given pushed Advertisement</th>
													<th>Watched pushed Surveys</th>
													<th>Feedback Given pushed Surveys</th>
												</tr>
											</thead>
											<tbody>
								<tr>
									<td><a href="#">1</a></td>
									<td><a href="#">Consumers</a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumers;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel0;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel1;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedAdvertisment;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedSurveys;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedSurveys;?></a></td>
								</tr>
								<tr>
									<td><a href="#">2</a></td>
									<td><a href="#">Regsitered Consumers who scanned today for all Brands</a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumersToday;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel0Today;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel1Today;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedAdvertismentToday;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedAdvertismentToday;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedSurveysToday;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedSurveysToday;?></a></td>
								</tr>
												<tr>
													<td><a href="#">3</a></td>
													<td><a href="#">Regsitered Consumers who scanned in last 7 days for all Brands</a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumers7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumers7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel17Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedAdvertisment7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedSurveys7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedSurveys7Days;?></a></td>
												</tr>
												<tr>
													<td><a href="#">4</a></td>
													<td><a href="#">Regsitered Consumers who scanned in last 30 days for all Brands</a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumers30Days; ?></a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumers30Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel130Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedAdvertisment30Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment30Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedSurveys30Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedSurveys30Days;?></a></td>
												</tr>
												<tr>
													<td><a href="#">5</a></td>
													<td><a href="#">Brandwise and TRUSTAT tolal loyalty points with Consumers</a></td>
													<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?></a></td>
													<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel0;?></a></td>
													<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel1;?></a></td>
													<td><a href="#"><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?>NA</a></td>
													<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></a></td>
													<td><a href="#"><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</a></td>
											<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></a></td>
												</tr>
												<tr>
													<td><a href="#">6</a></td>
													<td><a href="#">TRUSTAT</a></td>
													<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?></a></td>
													<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel0;?></a></td>
													<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel1;?></a></td>
													<td><a href="#"><?php //echo $TRUSTATTotalEarnedLoyaltyPointsWatchedPushedAdvertisment;?>NA</a></td>
													<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></a></td>
													<td><a href="#"><?php //echo $TRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</a></td>
											<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></a></td>
												</tr>
												<tr>
													<td><a href="#">7</a></td>
													<td><a href="<?php echo base_url('product/consumer_brand_loyalty_dashboard') ?>">Brand <font color="red"> Click here for Details</font></a></td>
													<td><a href="#"><?php //echo $BrandTotalEarnedLoyaltyPointsConsumerRegistration;?>0</a></td>
													<td><a href="#"><?php echo $BrandTotalEarnedLoyaltyPointsScannedCodesLevel0;?></a></td>
													<td><a href="#"><?php echo $BrandTotalEarnedLoyaltyPointsScannedCodesLevel1;?></a></td>
													<td><a href="#"><?php //echo $BrandTotalEarnedLoyaltyPointsWatchedPushedAdvertisment;?>NA</a></td>
													<td><a href="#"><?php echo $BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></a></td>
													<td><a href="#"><?php //echo $BrandTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</a></td>
											<td><a href="#"><?php echo $BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></a></td>
												</tr>
											</tbody>
										</table>
									</div>
								 <?php }else{ ?>
								
								<div class="col-xs-12">
								<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Consumer Dashboard
												</h4>
											</div>
										<table class="table table-bordered table-striped" style="display: block; height: 520px; overflow-y: auto">
											<thead>
												<tr>
													<th>S. No.</th> 
													<th>Consumer Dashboard</th>
													<th>Number of Registered Consumers</th>
													<th>No. of times scanned products for level 0</th>
													<th>No. of times scanned products for level 1</th>
													<th>Watched pushed Advertisement</th>
													<th>Feedback Given pushed Advertisement</th>
													<th>Watched pushed Surveys</th>
													<th>Feedback Given pushed Surveys</th>
												</tr>
											</thead>
											<tbody>
								<tr>
									<td><a href="#">1</a></td>
									<td><a href="#">Consumers</a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumers;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel0;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel1;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedAdvertisment;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedSurveys;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedSurveys;?></a></td>
								</tr>
								<tr>
									<td><a href="#">2</a></td>
									<td><a href="#">Regsitered Consumers who scanned today</a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumersToday;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel0Today;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel1Today;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedAdvertismentToday;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedAdvertismentToday;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedSurveysToday;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedSurveysToday;?></a></td>
								</tr>
												<tr>
													<td><a href="#">3</a></td>
													<td><a href="#">Regsitered Consumers who scanned in last 7 days</a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumers7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel07Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel17Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedAdvertisment7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedSurveys7Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedSurveys7Days;?></a></td>
												</tr>
												<tr>
													<td><a href="#">4</a></td>
													<td><a href="#">Regsitered Consumers who scanned in last 30 days</a></td>
									<td><a href="#"><?php echo $TotalNumberofRegisteredConsumers30Days; ?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel030Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofScannedCodesLevel130Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedAdvertisment30Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment30Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofWatchedPushedSurveys30Days;?></a></td>
									<td><a href="#"><?php echo $TotalNumberofFeedbackGivenPushedSurveys30Days;?></a></td>
												</tr>
												<tr>
													<td><a href="#">5</a></td>
													<td><a href="#">Brand + TRUSTAT tolal loyalty points with Consumers</a></td>
													<td><a href="#"><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>0</a></td>
													<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel0;?></a></td>
													<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel1;?></a></td>
													<td><a href="#"><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?>NA</a></td>
													<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></a></td>
													<td><a href="#"><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</a></td>
											<td><a href="#"><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></a></td>
												</tr>
												<tr>
													<td><a href="#">6</a></td>
													<td><a href="#">TRUSTAT</a></td>
													<td><a href="#"><?php //echo $TRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>0</a></td>
													<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel0;?></a></td>
													<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel1;?></a></td>
													<td><a href="#"><?php //echo $TRUSTATTotalEarnedLoyaltyPointsWatchedPushedAdvertisment;?>NA</a></td>
													<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></a></td>
													<td><a href="#"><?php //echo $TRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</a></td>
											<td><a href="#"><?php echo $TRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></a></td>
												</tr>
												<tr>
													<td><a href="#">7</a></td>
													<td><a href="#">Brand</a></td>
													<td><a href="#"><?php //echo $BrandTotalEarnedLoyaltyPointsConsumerRegistration;?>0</a></td>
													<td><a href="#"><?php echo $BrandTotalEarnedLoyaltyPointsScannedCodesLevel0;?></a></td>
													<td><a href="#"><?php echo $BrandTotalEarnedLoyaltyPointsScannedCodesLevel1;?></a></td>
													<td><a href="#"><?php //echo $BrandTotalEarnedLoyaltyPointsWatchedPushedAdvertisment;?>NA</a></td>
													<td><a href="#"><?php echo $BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></a></td>
													<td><a href="#"><?php //echo $BrandTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</a></td>
											<td><a href="#"><?php echo $BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></a></td>
												</tr>
											</tbody>
										</table>
									</div>
								<?php } ?>
					<!--================================		-->	
								
									
								
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

