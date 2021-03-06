<?php $this->load->view('../includes/admin_header'); ?>

<!-- Export to Excel -->
<script src="<?php echo base_url(); ?>assets/export_to_excel/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/tableExport.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/jquery.base64.js"></script>
<!-- /Export to Excel -->

<?php //echo '<pre>';print_r($product_list);exit;
$this->load->view('../includes/admin_top_navigation'); ?> 

<div class="main-container ace-save-state" id="main-container">

	<script type="text/javascript">
		try {
			ace.settings.loadState('main-container')
		} catch (e) {}
	</script>

	<?php $this->load->view('../includes/admin_sidebar'); ?>

	<div class="main-content">

		<div class="main-content-inner">

			<div class="breadcrumbs ace-save-state" id="breadcrumbs">

				<ul class="breadcrumb">

					<li>

						<i class="ace-icon fa fa-home home-icon"></i>

						<a href="<?php echo DASH_B; ?>">Home></a>

					</li>



					<li>

						<a href="#">Master</a>

					</li>

					<!--<li class="active">All Consumers - [Export all consumers to excel (<a href="<?php echo base_url(''); ?>exportallconsumerstoexcel.php">Click Here</a>)]</li>-->
					
					<label><a href="#" onclick="$('#dynamic-table').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label>

				</ul><!-- /.breadcrumb -->



			</div>



			<div class="page-content">

				<?php if ($this->session->flashdata('success') != '') { ?> <div class="alert alert-block alert-success">

						<button type="button" class="close" data-dismiss="alert">

							<i class="ace-icon fa fa-times"></i>

						</button>



						<i class="ace-icon fa fa-check green"></i>



						<?php echo $this->session->flashdata('success'); ?>

					</div>

				<?php } ?>


			
				<div class="row">

					<div class="col-xs-12">

						<div class="widget-box widget-color-blue">
							<div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">List all Consumers</h5>
                                <div class="widget-toolbar">
                                   <!-- <a href="" class="btn btn-xs btn-warning" title="Add Product">Add <?php echo $label; ?></a>-->
                                </div>
                            </div>
							
							<div class="widget-body">
								<!-- <div class="row filter-box">
									<form id="form-filter" action="" method="get" class="form-horizontal">
										<div class="col-sm-6">
											<label>Display
												<select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
													<?php echo Utils::selectOptions('pagelimit', ['options' => $this->config->item('pageOption'), 'value' => $this->config->item('pageLimit')]) ?>
												</select>
												Records
											</label>
										</div>
										<div class="col-sm-6">
											<div class="input-group">
												<input type="text" name="search" id="search" value="<?= $this->input->get('search', null); ?>" class="form-control search-query" placeholder="Consumer Name,Consumer Phone">
												<span class="input-group-btn">
													<button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
													<button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
												</span>
											</div>
										</div>
									</form>
								</div> -->						
								<!--------------- Search Tab start----------------->
								<div style="overflow-x:auto;">
									<table id="dynamic-table" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th class="skip-col">S No.</th>
												<th class="hidden-480">Consumer Name</th>
												<th class="con-gender-c hidden-480">Consumer Gender</th>
												<th class="hidden-480">Consumer Phone</th>
												<th class="hidden-480">Consumer Email</th>
												<th>Consumer Photo</th>
												<th>Date of Registration</th>
												<th class="loyalty-points-c">Earned Loyalty Points</th>
												<th>City Of Last Scan</th>
												<th class="hidden-480">Consumer Registration City</th>
												<?php
												$user_id = $this->session->userdata('admin_user_id');
												if ($user_id == 1) {
													?>
													<th class="consumer-dob hidden-480">Consumer dob</th>
													<th class="hidden-480">Consumer Registration Address</th>
													<th class="hidden-480">Consumer Alternate Mobile Number</th>
													<th class="hidden-480">Consumer Street Address</th>													
													<th class="hidden-480">Consumer State</th>
													<th class="hidden-480">Consumer Pin Code</th>
													<th class="monthly-earnings-c hidden-480">Consumer Monthly Earnings</th>
													<th class="hidden-480">Consumer Job Profile</th>
													<th class="hidden-480">Consumer Education Qualification</th>
													<th class="hidden-480">Consumer Type Vehicle</th>
													<th class="hidden-480">Consumer Profession</th>
													<th class="hidden-480">Consumer Marital Status</th>
													<th class="fmember hidden-480">Number of Family Members</th>
													<th class="hidden-480">Consumer Loan Car</th>
													<th class="hidden-480">Consumer Loan Housing</th>
													<th class="hidden-480">Consumer Personal Loan</th>
													<th class="hidden-480">Consumer Credit Card Loan</th>
													<th class="hidden-480">Consumer Own a Car</th>
													<th class="hidden-480">Consumer House Type</th>
													<th class="hidden-480">Consumer Last Location</th>
													<th class="hidden-480">Consumer Life Insurance</th>
													<th class="hidden-480">Consumer Medical Insurance</th>
													<th class="hidden-480">Consumer Height in inches</th>
													<th class="hidden-480">Consumer Weight in Kg</th>
													<th class="hidden-480">Consumer Hobbies</th>
													<th class="hidden-480">Consumer Sports</th>
													<th class="hidden-480">Consumer Entertainment</th>
													<th class="spo-gender-c hidden-480">Spouse Gender</th>
													<th class="hidden-480">Spouse Phone</th>
													<th class="hidden-480">Spouse dob</th>
													<th class="hidden-480">Marriage Anniversary</th>
													<th class="hidden-480">Spouse Work Status</th>
													<th class="hidden-480">Spouse Education Qualification</th>
													<th class="hidden-480">Spouse Monthly Income</th>
													<th class="hidden-480">Spouse Loan</th>
													<th class="hidden-480">Spouse Personal Loan</th>
													<th class="hidden-480">Spouse Credit Card Loan</th>
													<th class="hidden-480">Spouse Own a Car</th>
													<th class="hidden-480">Spouse House Type</th>
													<th class="hidden-480">Spouse Height Inches</th>
													<th class="hidden-480">Spouse Weight Kg</th>
													<th class="hidden-480">Spouse Hobbies</th>
													<th class="hidden-480">Spouse Sports</th>
													<th class="hidden-480">Spouse Entertainment</th>
													<th class="hidden-480">Last Modified at</th>

												<?php }  ?>
											</tr>
										</thead>
										<tbody>

											<?php

											$user_id = $this->session->userdata('admin_user_id');
											$customer_id = $this->uri->segment(3);

											if (count($list_all_consumers) > 0) {
												// $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;

												if (($user_id == 1) && ($customer_id != "")) {
													$page = !empty($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
												} else {

													$page = !empty($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
												}

												$sno =  $page + 1;
												$i = 0;
												foreach ($list_all_consumers as $attr) {
													$i++;
													?>
													<tr id="show<?php echo $attr['id']; ?>">
														<td><?php echo $sno; ?></td>
														<td><?php echo $attr['user_name']; ?></td>
														<td><?php echo $attr['gender']; ?></td>
														<td><?php echo $attr['mobile_no']; ?></td>
														<td><?php echo $attr['email']; ?></td>
														<td><img src="<?php echo base_url(); ?><?php echo $attr['avatar_url']; ?>" alt="Consumer Photo Not found" height="42" width="42"></td>
														<td><?php echo $attr['created_at']; ?></td>
														<td><?php if ($user_id == 1) {
																echo get_total_consumer_loyalty_points_all($attr['id']);
															} else {
																echo get_total_consumer_loyalty_points_customerwise($attr['id'], $user_id). ' : '. anchor("product/view_consumer_passbook_at_customer/" . $attr['id'], '<i class="ace-icon fa fa-eye bigger-130"> Passbook</i>', array('class' => 'btn btn-xs btn-info','title'=>'Passbook'));
															}
															?>
														</td>
														<td><?php echo $attr['city_last_scan']; ?></td>
														<td><?php echo $attr['registration_city']; ?></td>
														<?php if ($user_id == 1) {
															?>
															<td><?php echo $attr['dob']; ?></td>
															<td><?php echo $attr['registration_address']; ?></td>
															<td><?php echo $attr['alternate_mobile_no']; ?></td>
															<td><?php echo $attr['street_address']; ?></td>
															
															<td><?php echo $attr['state']; ?></td>
															<td><?php echo $attr['pin_code']; ?></td>
															<td><?php echo $attr['monthly_earnings']; ?></td>
															<td><?php echo $attr['job_profile']; ?></td>
															<td><?php echo $attr['education_qualification']; ?></td>
															<td><?php echo $attr['type_vehicle']; ?></td>
															<td><?php echo $attr['profession']; ?></td>
															<td><?php echo $attr['marital_status']; ?></td>
															<td><?php echo $attr['no_of_family_members']; ?></td>
															<td><?php echo $attr['loan_car']; ?></td>
															<td><?php echo $attr['loan_housing']; ?></td>
															<td><?php echo $attr['personal_loan']; ?></td>
															<td><?php echo $attr['credit_card_loan']; ?></td>
															<td><?php echo $attr['own_a_car']; ?></td>
															<td><?php echo $attr['house_type']; ?></td>
															<td><?php echo $attr['last_location']; ?></td>
															<td><?php echo $attr['life_insurance']; ?></td>
															<td><?php echo $attr['medical_insurance']; ?></td>
															<td><?php echo $attr['height_in_inches']; ?></td>
															<td><?php echo $attr['weight_in_kg']; ?></td>
															<td><?php echo $attr['hobbies']; ?></td>
															<td><?php echo $attr['sports']; ?></td>
															<td><?php echo $attr['entertainment']; ?></td>
															<td><?php echo $attr['spouse_gender']; ?></td>
															<td><?php echo $attr['spouse_phone']; ?></td>
															<td><?php echo $attr['spouse_dob']; ?></td>
															<td><?php echo $attr['marriage_anniversary']; ?></td>
															<td><?php echo $attr['spouse_work_status']; ?></td>
															<td><?php echo $attr['spouse_edu_qualification']; ?></td>
															<td><?php echo $attr['spouse_monthly_income']; ?></td>
															<td><?php echo $attr['spouse_loan']; ?></td>
															<td><?php echo $attr['spouse_personal_loan']; ?></td>
															<td><?php echo $attr['spouse_credit_card_loan']; ?></td>
															<td><?php echo $attr['spouse_own_a_car']; ?></td>
															<td><?php echo $attr['spouse_house_type']; ?></td>
															<td><?php echo $attr['spouse_height_inches']; ?></td>
															<td><?php echo $attr['spouse_weight_kg']; ?></td>
															<td><?php echo $attr['spouse_hobbies']; ?></td>
															<td><?php echo $attr['spouse_sports']; ?></td>
															<td><?php echo $attr['spouse_entertainment']; ?></td>
															<td><?php echo $attr['modified_at'];
																?></td>
														<?php }  ?>
														<!--<td><input type="checkbox" name="assignConsumer[]" class="assignConsumer" /></td>-->
													</tr>
													<?php
													$sno++;
												}
											} else { ?>
												<tr>
													<td align="center" colspan="8" class="color error">No Records Founds</td>
												</tr>
											<?php } ?>
											<!--<tr id="show<?php echo $attr['id']; ?>"><td colspan="8"><input class="btn btn-primary pull-right" type="button" id="assign" name="assign" value="Assign Product" /></td></tr>-->

										</tbody>
									</table>
								</div>
								<div class="row paging-box">
									<?php echo $links ?>
								</div>
							</div><!-- /.col -->

						</div><!-- /.col -->

					</div><!-- /.row -->

				</div><!-- /.page-content -->
				<div class="footer">

					<div class="footer-inner">

						<div class="footer-content">

							<span class="bigger-120">
						<span class="blue bolder">Copyright ??</span>
						<?php //echo date('Y');?> <a href="https://innovigent.in/" target="_blank"> Innovigent Solutions Private Limited </a>
					   </span>

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
			</div>

		</div><!-- /.main-content -->
		<?php $this->load->view('../includes/admin_footer'); ?>
		<script>
			function validateSrch() {
				$("#searchStr").removeClass('error');
				var val = $("#searchStr").val();
				if (val.trim() == '') {
					$("#searchStr").addClass('error');
					return false;
				}
			}

			function assignProduct() {
				$('#save_value').click(function() {
					var arr = $('.ads_Checkbox:checked').map(function() {
						return this.value;
					}).get();
				});
			}


			function delete_attr(id) {
				if (confirm("Sure to Delete SKU") == true) {
					window.location.href = "<?php echo base_url(); ?>product/delete_attribute/" + id;
				} else {
					return false;
				}
			}
		</script>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

		</a>

	</div><!-- /.main-container -->
	<script type="text/javascript">
	var age_range = {
		"15_20":"15 to 20",
		"21_25":"21 to 25",
		"26_30":"26 to 30",
		"31_35":"31 to 35",
		"36_40":"36 to 40",
		"41_45":"41 to 45",
		"46_50":"46 to 50",
		"51_55":"51 to 55",
		"56_60":"56 to 60",
		"60+":"Above 60",
	};
	var loyalty_points_range = {
		"0_100":"0 to 100",
		"101_200":"101 to 200",
		"201_500":"201 to 500",
		"501_1000":"501 to 1000",
		"1001_5000":"1001 to 5000",
		"5001_10000":"5001 to 10000",
		"10000+":"More than 10000",
	};
	var monthly_earnings_range = {
		"0_1000":"0 to 1000",
		"1001_5000":"1001 to 5000",
		"5001_10000":"5001 to 10000",
		"10001_50000":"10001 to 50000",
		"50001_100000":"50001 to 100000",
		"100000+":"More than 100000",
	};
	var family_members_range = {
		"1":"1",
		"2":"2",
		"3":"3",
		"4":"4",
		"5":"5",
		"6":"6",
		"7+":"More than 7"
	};
	var gender_range = {
		"male":"Male",
		"female":"Female",
		"other":"Other"
	};
	function select_option(options,title,name){
		var select = $('<select class="select-input" name="'+name+'" id="'+name+'"><option value="">Select '+title+'</option></select>');
		$.each(options, function(index, value) {
			select.append( '<option value="'+index+'">'+value+'</option>' )
		});
		return select.get(0).outerHTML;
	}
	function getrange(value){
		var from=null,to=null;
		//console.log(value);
		if(/^\d+$/.test(value)){
			from = parseInt(value);
			to = null;
		}else if (value.indexOf("+") >= 0) {
			from = parseInt(value.slice(0, -1));
			to = null;
    	} else if (value.indexOf("_") >= 0) {
			var range = value.split("_");
			from = parseInt(range[0]);
			to = parseInt(range[1]);
    	}
		return [from,to]
	}
	function getColDate(val){
		if(val.length > 3){
			if(isNaN(Date.parse(val))){
				return "";
			}else{
				return moment().diff(new Date(val).toISOString(), 'years',false);
			}			
		}else{
			return "";
		}
		
	}
	
	$(document).ready(function(){
		var table = $('#dynamic-table').DataTable({
			"language": {                
				"infoFiltered": ""
			},
			"ordering": false			
		});
		$('#dynamic-table thead th').each(function () {
			if($(this).hasClass("skip-col")){
				return;
			}
			var title = $(this).text();
			var field_id = title.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
			if($(this).hasClass("fmember")){
				$(this).html(title + select_option(family_members_range,title,field_id));					
			}else if($(this).hasClass("loyalty-points-c")){
				$(this).html(title + select_option(loyalty_points_range,title,field_id));
			}else if($(this).hasClass("monthly-earnings-c")){
				$(this).html(title + select_option(monthly_earnings_range,title,field_id));
			}else if($(this).hasClass("spo-gender-c")){
				$(this).html(title + select_option(gender_range,title,field_id));		
			}else if($(this).hasClass("con-gender-c")){
				$(this).html(title + select_option(gender_range,title,field_id));			
			}else if(field_id == 'consumer-dob' || field_id == 'spouse-dob'){
				$(this).html(title + select_option(age_range,title,field_id));				
			}else{
				$(this).html(title+' <input type="text" id="'+field_id+'" name="'+field_id+'" class="text-input" placeholder="Search ' + title + '" />');
			}
		});
		
		$.fn.dataTable.ext.search.push(function( settings, data, dataIndex ) {
			var memFamily = parseInt(data[22]);	
			var fmember = getrange($('#number-of-family-members').val());
			
			familyMember = (fmember[0] != null)?(fmember[0] == parseInt(7) && memFamily >= fmember[0]) || (memFamily == fmember[0]):true;
			
			var lps = parseInt(data[6]);			
			var lPoints = getrange($('#earned-loyalty-points').val());
			loyaltyPoints = (lPoints[1] != null && lPoints.length > 0) ? (lps >= lPoints[0] && lps <= lPoints[1]) : (lPoints[1] == null && lPoints.length > 0)? lps >= lPoints[0]:true;
			
			var m_earningCol = parseInt(data[16]);			
			var m_earnings = getrange($('#consumer-monthly-earnings').val());
			monthlyEarnings = (m_earnings[1] != null && m_earnings[0] != null) ? (m_earningCol >= m_earnings[0] && m_earningCol <= m_earnings[1]) : (m_earnings[1] == null && m_earnings[0] != null)? m_earningCol >= m_earnings[0]:true;
 
			var conGenderCol = data[8];			
			var con_gender_val = $('#consumer-gender').val();
			ConGender = (con_gender_val.length > 0)? (con_gender_val == conGenderCol):true;

			var spGenderCol = data[36];			
			var sp_gender_val = $('#spouse-gender').val();	
			SpGender = (sp_gender_val.length > 0)? (sp_gender_val == spGenderCol):true;
		
			var consDobCol = getColDate(data[$("#consumer-dob").closest("th").index()]);
			var cons_dob_val = getrange($('#consumer-dob').val());
			consumerAge = (cons_dob_val[1] != null && cons_dob_val[0] != null) ? (consDobCol >= cons_dob_val[0] && consDobCol <= cons_dob_val[1]) : (cons_dob_val[1] == null && cons_dob_val[0] != null)? consDobCol >= cons_dob_val[0]:true;

			var spouseDobCol = getColDate(data[$("#spouse-dob").closest("th").index()]);
			var spouse_dob_val = getrange($('#spouse-dob').val());
			spouseAge = (spouse_dob_val[1] != null && spouse_dob_val[0] != null) ? (spouseDobCol >= spouse_dob_val[0] && spouseDobCol <= spouse_dob_val[1]) : (spouse_dob_val[1] == null && spouse_dob_val[0] != null)? spouseDobCol >= spouse_dob_val[0]:true;

			return familyMember && loyaltyPoints && ConGender && SpGender && monthlyEarnings && consumerAge && spouseAge;
		});		
		$(document).on("change",".select-input",function(){
			table.draw();
		});	
		var btnClear = $('<button class="btn btn-xs btn-primary clear-all">Clear All</button>');
		btnClear.appendTo($('#dynamic-table').parents('.dataTables_wrapper').find('.dataTables_filter'));	
		$(document).on("click",".clear-all",function(){
			$(".text-input").val('');
			$(".select-input").val('');
			table.search( '' ).columns().search( '' ).draw();
		});
		// $('.select-input').on('change', table.draw);
		table.columns().every(function () {
			var table = this;
			$('.text-input', this.header()).on('keyup change', function () {
				if (table.search() !== this.value) { 
					table.search(this.value).draw();
				}
			});			
		});
		table.on( 'order.dt search.dt', function () {
			table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();
	});
	</script>