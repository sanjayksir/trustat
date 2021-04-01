<?php 
//log_message('debug',print_r($array_or_object_you_want_to_print,TRUE));
$this->load->view('../includes/admin_header');?>

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
													<th>Purchase Loyalty</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $NumberofPendingCodePrintOrders;?></td>
													<td><?php echo $NumberofPendingAdvertisementOrders;?></td>
													<td><?php echo $NumberofPendingSurveyOrders;?></td>
													<td><?php echo $NumberofPendingMessagesOrders;?></td>
													<td><?php echo $NumberofPendingLoyaltyRedemptionsRequests;?></td>
													<td><?php echo $NumberofPendingPurchaseLoyaltyRequests;?></td>
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
													<th>No. of times Post Purchase Scan Report</th>
													<th>No. of times Pre Purchase Scan Report</th>
													<th>Watched pushed Advertisement</th>
													<th>Feedback Given pushed Advertisement</th>
													<th>Watched pushed Surveys</th>
													<th>Feedback Given pushed Surveys</th>
												</tr>
											</thead>
											<tbody>
								<tr>
									<td>1</td>
									<td>Consumers</td>
									<td><?php echo $TotalNumberofRegisteredConsumers;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel0;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel1;?></td>
									<td><?php echo $TotalNumberofWatchedPushedAdvertisment;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment;?></td>
									<td><?php echo $TotalNumberofWatchedPushedSurveys;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedSurveys;?></td>
								</tr>
								<tr>
									<td>2</td>
									<td>Regsitered Consumers who scanned today for all Brands</td>
									<td><?php echo $TotalNumberofRegisteredConsumersToday;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel0Today;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel1Today;?></td>
									<td><?php echo $TotalNumberofWatchedPushedAdvertismentToday;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedAdvertismentToday;?></td>
									<td><?php echo $TotalNumberofWatchedPushedSurveysToday;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedSurveysToday;?></td>
								</tr>
												<tr>
													<td>3</td>
													<td>Regsitered Consumers who scanned in last 7 days for all Brands</td>
									<td><?php echo $TotalNumberofRegisteredConsumers7Days;?></td>
									<td><?php echo $TotalNumberofRegisteredConsumers7Days;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel17Days;?></td>
									<td><?php echo $TotalNumberofWatchedPushedAdvertisment7Days;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment7Days;?></td>
									<td><?php echo $TotalNumberofWatchedPushedSurveys7Days;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedSurveys7Days;?></td>
												</tr>
												<tr>
													<td>4</td>
													<td>Regsitered Consumers who scanned in last 30 days for all Brands</td>
									<td><?php echo $TotalNumberofRegisteredConsumers30Days; ?></td>
									<td><?php echo $TotalNumberofRegisteredConsumers30Days;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel130Days;?></td>
									<td><?php echo $TotalNumberofWatchedPushedAdvertisment30Days;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment30Days;?></td>
									<td><?php echo $TotalNumberofWatchedPushedSurveys30Days;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedSurveys30Days;?></td>
												</tr>
												<tr>
													<td>5</td>
													<td>Brandwise and TRUSTAT tolal loyalty points with Consumers</td>
													<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?></td>
													<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel0;?></td>
													<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel1;?></td>
													<td><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?>NA</td>
													<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></td>
													<td><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</td>
											<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></td>
												</tr>
												<tr>
													<td>6</td>
													<td>TRUSTAT</td>
													<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?></td>
													<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel0;?></td>
													<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel1;?></td>
													<td><?php //echo $TRUSTATTotalEarnedLoyaltyPointsWatchedPushedAdvertisment;?>NA</td>
													<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></td>
													<td><?php //echo $TRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</td>
											<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></td>
												</tr>
												<tr>
													<td>7</td>
													<td><a href="<?php echo base_url('product/consumer_brand_loyalty_dashboard') ?>">Brand <font color="red"> Click here for Details</font></td>
													<td><?php //echo $BrandTotalEarnedLoyaltyPointsConsumerRegistration;?>0</td>
													<td><?php echo $BrandTotalEarnedLoyaltyPointsScannedCodesLevel0;?></td>
													<td><?php echo $BrandTotalEarnedLoyaltyPointsScannedCodesLevel1;?></td>
													<td><?php //echo $BrandTotalEarnedLoyaltyPointsWatchedPushedAdvertisment;?>NA</td>
													<td><?php echo $BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></td>
													<td><?php //echo $BrandTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</td>
											<td><?php echo $BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></td>
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
													<th>No. of times Post Purchase Scan Report</th>
													<th>No. of times Pre Purchase Scan Report</th>
													<th>Watched pushed Advertisement</th>
													<th>Feedback Given pushed Advertisement</th>
													<th>Watched pushed Surveys</th>
													<th>Feedback Given pushed Surveys</th>
												</tr>
											</thead>
											<tbody>
								<tr>
									<td>1</td>
									<!--<td><a href="<?php  echo base_url().'product/list_all_consumers';?>">Consumers</a></td>  -->
									<td>Consumers</td>
									<td><?php echo $TotalNumberofRegisteredConsumers;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel0;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel1;?></td>
									<td><?php echo $TotalNumberofWatchedPushedAdvertisment;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment;?></td>
									<td><?php echo $TotalNumberofWatchedPushedSurveys;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedSurveys;?></td>
								</tr>
								<tr>
									<td>2</td>
									<td>Regsitered Consumers who scanned today</td>
									<td><?php echo $TotalNumberofRegisteredConsumersToday;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel0Today;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel1Today;?></td>
									<td><?php echo $TotalNumberofWatchedPushedAdvertismentToday;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedAdvertismentToday;?></td>
									<td><?php echo $TotalNumberofWatchedPushedSurveysToday;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedSurveysToday;?></td>
								</tr>
												<tr>
													<td>3</td>
													<td>Regsitered Consumers who scanned in last 7 days</td>
									<td><?php echo $TotalNumberofRegisteredConsumers7Days;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel07Days;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel17Days;?></td>
									<td><?php echo $TotalNumberofWatchedPushedAdvertisment7Days;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment7Days;?></td>
									<td><?php echo $TotalNumberofWatchedPushedSurveys7Days;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedSurveys7Days;?></td>
												</tr>
												<tr>
													<td>4</td>
													<td>Regsitered Consumers who scanned in last 30 days</td>
									<td><?php echo $TotalNumberofRegisteredConsumers30Days; ?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel030Days;?></td>
									<td><?php echo $TotalNumberofScannedCodesLevel130Days;?></td>
									<td><?php echo $TotalNumberofWatchedPushedAdvertisment30Days;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedAdvertisment30Days;?></td>
									<td><?php echo $TotalNumberofWatchedPushedSurveys30Days;?></td>
									<td><?php echo $TotalNumberofFeedbackGivenPushedSurveys30Days;?></td>
												</tr>
												<!--<tr>
													<td>5</td>
													<td>Brand + TRUSTAT tolal loyalty points with Consumers</td>
													<td><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>0</td>
													<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel0;?></td>
													<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel1;?></td>
													<td><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?>NA</td>
													<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></td>
													<td><?php //echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</td>
											<td><?php echo $BrandwiseTRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></td>
												</tr>
												<tr>
													<td>6</td>
													<td>TRUSTAT</td>
													<td><?php //echo $TRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>0</td>
													<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel0;?></td>
													<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsScannedCodesLevel1;?></td>
													<td><?php //echo $TRUSTATTotalEarnedLoyaltyPointsWatchedPushedAdvertisment;?>NA</td>
													<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment;?></td>
													<td><?php //echo $TRUSTATTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</td>
											<td><?php echo $TRUSTATTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys;?></td>
												</tr>-->
												<tr>
													<td>5</td>
													<td>Brand Loyalty</td>
													<td><?php //echo $BrandTotalEarnedLoyaltyPointsConsumerRegistration;?>0</td>
													<td><?php if($BrandTotalEarnedLoyaltyPointsScannedCodesLevel0==""){ echo "0";}else{ echo $BrandTotalEarnedLoyaltyPointsScannedCodesLevel0;} ?></td>
													<td><?php if($BrandTotalEarnedLoyaltyPointsScannedCodesLevel1==""){ echo "0";}else{ echo $BrandTotalEarnedLoyaltyPointsScannedCodesLevel1;}?></td>
													<td><?php //echo $BrandTotalEarnedLoyaltyPointsWatchedPushedAdvertisment;?>NA</td>
													<td><?php if($BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment==""){ echo "0";}else{ echo $BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedAdvertisment; } ?></td>
													<td><?php //echo $BrandTotalEarnedLoyaltyPointsConsumerRegistration;?>NA</td>
											<td><?php if($BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys==""){ echo "0";}else{ echo $BrandTotalEarnedLoyaltyPointsFeedbackGivenPushedSurveys; }?></td>
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

