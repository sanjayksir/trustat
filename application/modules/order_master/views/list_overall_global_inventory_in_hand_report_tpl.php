<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
<!-- Export to Excel -->
<script src="<?php echo base_url(); ?>assets/export_to_excel/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/tableExport.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/export_to_excel/jquery.base64.js"></script>
<!-- /Export to Excel -->

	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Overall Global Inventory in Hand';?>

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
						<div class="alert alert-block alert-success" style='display:none;'>
                                                    <button type="button" class="close" data-dismiss="alert">
                                                            <i class="ace-icon fa fa-times"></i>
                                                    </button>
                                                    <i class="ace-icon fa fa-check green"></i>Successfully!!
						 </div>
                      
                      
   						<div class="row">
							<div class="col-xs-12">
 								<div class="widget-box widget-color-blue">
                                                                    <div class="widget-header widget-header-flat">
                                                                        <h5 class="widget-title bigger lighter">List <?php echo $label;?>
																		<?php if($this->uri->segment(2)=='overall_global_inventory_in_hand_all_records'){ 
													echo " Archived"; } ?> </h5>
																		 <div class="widget-toolbar">
                                                    <?php if($this->uri->segment(2)=='overall_global_inventory_in_hand'){ 
													echo anchor('reports/overall_global_inventory_in_hand_all_records', 'Go to Archived Report',array('class' => 'btn btn-xs btn-warning')); } ?> |  <?php 
													if($this->uri->segment(2)=='overall_global_inventory_in_hand'){ 
													echo anchor('reports/overall_global_inventory_in_hand_download', 'Go to download report',array('class' => 'btn btn-xs btn-warning')); }else{ echo anchor('reports/overall_global_inventory_in_hand_all_records_download', 'Go to download report',array('class' => 'btn btn-xs btn-warning')); } ?>
																	</div>
                                                                    </div>
									<div class="widget-body">
									 <div class="row filter-box">
                                                                                <form id="form-filter" action="" method="get" class="form-horizontal" >
                                                                                    <div class="col-sm-5">
                                                                                        <label>Display
                                                                                            <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
                                                                                            <?php echo Utils::selectOptions('pagelimit',['options'=>$this->config->item('pageOption'),'value'=>$this->config->item('pageLimit')]) ?>
                                                                                            </select>
                                                                                        Records
                                                                                        </label>
																						
					<?php $Datetoday = date("m/d/Y"); ?>
					<?php $dateoneMAgo = date("m/d/Y",strtotime("-1 year")); ?>	
													
												<!--<label><a href="#" onclick="$('#List_Consumer').tableExport({type:'excel',escape:'false'});"> <img src="<?php //echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label>-->
                                                                                    </div>
                                <div class="col-sm-2">  From Date(mm/dd/yyyy) : <br /><br />To Date(mm/dd/yyyy) :<br /><br />  </div>
								<div class="col-sm-5">
								                              <div class="input-group">
							<div class="input-group date" data-provide="datepicker">
                              <input type="text" name="from_date_data" id="from_date_data" readonly="readonly" value="<?php //echo $dateoneMAgo; ?>" class="form-control" />
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                        </div>
								  
								  <div class="input-group date" data-provide="datepicker">
                               <input type="text" name="to_date_data" id="to_date_data" readonly="readonly" value="<?php //echo $Datetoday; ?>" class="form-control" />
							   
                                  <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                  </div>
                                  </div>															
									<input type="hidden" name="c_date_data" id="c_date_data" value="<?php echo date('m/d/Y'); ?>" class="form-control" />					                                     
									<input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Customer Name OR Bar-QR Code OR Product Name or Consumer ID">
                                                   <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-inverse btn-white" onclick="DateCheck();"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                                                                <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
										<script type="text/javascript">											
								function DateCheck()
											{
											  var StartDate= document.getElementById('from_date_data').value;
											  var EndDate= document.getElementById('to_date_data').value;
											  var CurrentDate= document.getElementById('c_date_data').value;
											  var eDate = new Date(EndDate);
											  var sDate = new Date(StartDate);
											  var cDate = new Date(CurrentDate);
											  if(sDate> eDate || eDate> cDate)
												{
												alert("Please ensure that the End Date is greater than or equal to the Start Date. End Date is not greater than Current Date");
												return false;
												}
											}
											</script>						
										<div style="overflow-x:auto;">
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>#</th>
														<th>Last Updated</th>
														<th>Location Name</th>
														<th>Product Name</th>
														<th>Product SKU</th>
														<th>Tracek User Name</th>
														<th>Tracek User ID</th>														
														<th>Packaging Level</th>
														<th>Opening Quantity for the Period Start Date</th> 														
                                                        <th>Stock Transfer-In Quantity</th> 
														<th>Stock Transfer-Out Quantity</th> 
														<th>Sales to Customers</th>
														<th>Sales return from customer</th>
														<th>Closing inventory for period end date</th>
														<th>Balance for Level 0 Inventory</th>
														<!--<th>QR code wise details of Closing inventory </th>-->
  													</tr>
												</thead>
												<tbody>

                                        <?php $i = 0;  //  echo '***<pre>';print_r($orderListing);
										if(count($ScanedCodeListing)>0){
											$i=0;
                                                                                         $page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
        $sno =  $page + 1;
                                        foreach ($ScanedCodeListing as $key=>$listData){
											$i++;
											?>
                                               <tr id="show<?php echo $key; ?>">
											   <td><?php echo $sno;$sno++; ?></td>
											   <td><?php echo $listData['update_date']; ?></td>
											   <td><?php echo get_locations_name_by_id($listData['location_id']); ?></td>
											   <td><?php echo $listData['product_name']; ?></td>
											   <td><?php echo $listData['product_sku']; ?></td>
											   <td><?php echo getUserNameById($listData['created_by_id']); ?></td>
											   <td><?php echo $listData['created_by_id']; ?></td>											   
											   <td><?php echo $listData['code_packaging_level']; ?></td>
											   <td><a href="<?php echo "overall_global_inventory_opening_details/".$listData['prev_tr_ref_id']; ?>" /><?php echo $listData['opening_inventory_quantity']; ?></a></td>
												<td><a href="<?php echo "overall_global_inventory_product_stock_transfer_in_details/".$listData['tr_ref_id']; ?>" /><?php echo $listData['stock_transfer_in_qty']; ?></a></td>
 												<td><a href="<?php echo "overall_global_inventory_product_stock_transfer_out_details/".$listData['tr_ref_id']; ?>" /><?php echo $listData['stock_transfer_out_qty']; ?></a><?php //echo anchor("reports/product_physical_packaging_reports", '<i class="ace-icon fa fa-eye bigger-130"> View Report</i>', array('class' => 'btn btn-xs btn-info','title'=>'View Report'));  ?></td>
												<td><a href="<?php echo "overall_global_inventory_product_sale_details/".$listData['tr_ref_id']; ?>" /><?php echo $listData['direct_customer_sale_qty']; ?></a></td>
												<td><a href="<?php echo "overall_global_inventory_product_returned_details/".$listData['tr_ref_id']; ?>" /><?php echo $listData['product_returned_from_customer_qty']; ?></a></td>
												
												<td><?php 
												$balance_qty =  $listData['closing_inventory_quantity'];
												 ?><a href="<?php echo "overall_global_inventory_closing_details/".$listData['tr_ref_id']; ?>" /><?php echo $balance_qty; ?></a></td>
												
												<td>
												<?php //echo $listData['product_id'];
												
											$CodeCurrentActicationLevel = $listData['code_packaging_level'];
											//$CodeCurrentActicationLevel = 1;
						//echo $CodeCurrentActicationLevel . "<br>";
						
						switch($CodeCurrentActicationLevel) {
							case 1:
								//echo "the value is either 1";
								
			$Cild1cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			echo $NumberofchildernatLevel1 * $balance_qty;
			
								break;
								
							case 2:
								//echo "the value is either 2";
								
								
			$Cild2cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;
			
			
								break;
								
							case 3:
								//echo "the value is either 3";
								
								
			$Cild3cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;
			
								break;
								
							case 4:
								//echo "the value is either 4";
								
								//$MastercartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']);
			$Cild4cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;
			
								break;
								
							case 5:
								//echo "the value is either 5";
							

			$Cild5cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
			
								
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;

			
								break;
								
							case 6:
								//echo "the value is either 6";
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
			
								
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;
								
								break;
								
							case 7:
								//echo "the value is either 7";
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
			
								
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;
								
							case 8:
								//echo "the value is either 8";
			$Cild8cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
			
								
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;
								
							case 9:
								//echo "the value is either 9";
			$Cild9cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
			
								
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;
								
							case 10:
								//echo "the value is either 10";
			$Cild10cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;	
			
								break;		
								
							case 11:
								//echo "the value is either 11";
								
			$Cild11cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;
			
								break;	
								
							case 12:
								//echo "the value is either 12";
			$Cild12cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;
								
								break;	
								
							case 13:
								//echo "the value is either 13";
			$Cild13cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;	
								
							case 14:
								//echo "the value is either 14";
			$Cild14cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results14 = $this->db->select($Cild14cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel14 = $results14->$Cild14cartonPackagingLevelNumber;
			
			$Cild13cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-13);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel14 * $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;				
								
								break;	
								
							case 15:
								//echo "the value is either 15";
			$Cild15cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results15 = $this->db->select($Cild15cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel15 = $results15->$Cild15cartonPackagingLevelNumber;
			
			$Cild14cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results14 = $this->db->select($Cild14cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel14 = $results14->$Cild14cartonPackagingLevelNumber;
			
			$Cild13cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-13);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-14);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel15 * $NumberofchildernatLevel14 * $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;
								
							case 16:
								//echo "the value is either 16";
			$Cild16cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results16 = $this->db->select($Cild16cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel16 = $results16->$Cild16cartonPackagingLevelNumber;
			
			$Cild15cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results15 = $this->db->select($Cild15cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel15 = $results15->$Cild15cartonPackagingLevelNumber;
			
			$Cild14cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results14 = $this->db->select($Cild14cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel14 = $results14->$Cild14cartonPackagingLevelNumber;
			
			$Cild13cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-13);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-14);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-15);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel16 * $NumberofchildernatLevel15 * $NumberofchildernatLevel14 * $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;
								
							case 17:
								//echo "the value is either 17";
			$Cild17cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results17 = $this->db->select($Cild17cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel17 = $results17->$Cild17cartonPackagingLevelNumber;
			
			$Cild16cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results16 = $this->db->select($Cild16cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel16 = $results16->$Cild16cartonPackagingLevelNumber;
			
			$Cild15cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results15 = $this->db->select($Cild15cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel15 = $results15->$Cild15cartonPackagingLevelNumber;
			
			$Cild14cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results14 = $this->db->select($Cild14cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel14 = $results14->$Cild14cartonPackagingLevelNumber;
			
			$Cild13cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-13);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-14);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-15);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-16);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel16 * $NumberofchildernatLevel15 * $NumberofchildernatLevel14 * $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;
								
							case 18:
								//echo "the value is either 18";
			$Cild18cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results18 = $this->db->select($Cild18cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel18 = $results18->$Cild18cartonPackagingLevelNumber;
			
			$Cild17cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results17 = $this->db->select($Cild17cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel17 = $results17->$Cild17cartonPackagingLevelNumber;
			
			$Cild16cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results16 = $this->db->select($Cild16cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel16 = $results16->$Cild16cartonPackagingLevelNumber;
			
			$Cild15cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results15 = $this->db->select($Cild15cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel15 = $results15->$Cild15cartonPackagingLevelNumber;
			
			$Cild14cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results14 = $this->db->select($Cild14cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel14 = $results14->$Cild14cartonPackagingLevelNumber;
			
			$Cild13cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-13);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-14);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-15);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-16);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-17);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel18 *$NumberofchildernatLevel17 *$NumberofchildernatLevel16 * $NumberofchildernatLevel15 * $NumberofchildernatLevel14 * $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;
								
							case 19:
								//echo "the value is either 19";
			$Cild19cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results19 = $this->db->select($Cild19cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel19 = $results19->$Cild19cartonPackagingLevelNumber;
			
			$Cild18cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results18 = $this->db->select($Cild18cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel18 = $results18->$Cild18cartonPackagingLevelNumber;
			
			$Cild17cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results17 = $this->db->select($Cild17cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel17 = $results17->$Cild17cartonPackagingLevelNumber;
			
			$Cild16cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results16 = $this->db->select($Cild16cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel16 = $results16->$Cild16cartonPackagingLevelNumber;
			
			$Cild15cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results15 = $this->db->select($Cild15cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel15 = $results15->$Cild15cartonPackagingLevelNumber;
			
			$Cild14cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results14 = $this->db->select($Cild14cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel14 = $results14->$Cild14cartonPackagingLevelNumber;
			
			$Cild13cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-13);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-14);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-15);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-16);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-17);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-18);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel19 * $NumberofchildernatLevel18 *$NumberofchildernatLevel17 *$NumberofchildernatLevel16 * $NumberofchildernatLevel15 * $NumberofchildernatLevel14 * $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;		
								break;
								
							case 20:
								//echo "the value is either 20";
			$Cild20cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results20 = $this->db->select($Cild20cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel20 = $results19->$Cild20cartonPackagingLevelNumber;
			
			$Cild19cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results19 = $this->db->select($Cild19cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel19 = $results19->$Cild19cartonPackagingLevelNumber;
			
			$Cild18cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results18 = $this->db->select($Cild18cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel18 = $results18->$Cild18cartonPackagingLevelNumber;
			
			$Cild17cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results17 = $this->db->select($Cild17cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel17 = $results17->$Cild17cartonPackagingLevelNumber;
			
			$Cild16cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results16 = $this->db->select($Cild16cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel16 = $results16->$Cild16cartonPackagingLevelNumber;
			
			$Cild15cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results15 = $this->db->select($Cild15cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel15 = $results15->$Cild15cartonPackagingLevelNumber;
			
			$Cild14cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results14 = $this->db->select($Cild14cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel14 = $results14->$Cild14cartonPackagingLevelNumber;
			
			$Cild13cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-13);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-14);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-15);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-16);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-17);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-18);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-19);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel20 * $NumberofchildernatLevel19 * $NumberofchildernatLevel18 *$NumberofchildernatLevel17 *$NumberofchildernatLevel16 * $NumberofchildernatLevel15 * $NumberofchildernatLevel14 * $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;
			
								break;
								
							case 21:
								//echo "the value is either 21";
			$Cild21cartonPackagingLevelNumber = "pack_level" . $listData['code_packaging_level'];
			$results21 = $this->db->select($Cild21cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel21 = $results21->$Cild21cartonPackagingLevelNumber;
			
			$Cild20cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-1);
			$results20 = $this->db->select($Cild20cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel20 = $results19->$Cild20cartonPackagingLevelNumber;
			
			$Cild19cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-2);
			$results19 = $this->db->select($Cild19cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel19 = $results19->$Cild19cartonPackagingLevelNumber;
			
			$Cild18cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-3);
			$results18 = $this->db->select($Cild18cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel18 = $results18->$Cild18cartonPackagingLevelNumber;
			
			$Cild17cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-4);
			$results17 = $this->db->select($Cild17cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel17 = $results17->$Cild17cartonPackagingLevelNumber;
			
			$Cild16cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-5);
			$results16 = $this->db->select($Cild16cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel16 = $results16->$Cild16cartonPackagingLevelNumber;
			
			$Cild15cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-6);
			$results15 = $this->db->select($Cild15cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel15 = $results15->$Cild15cartonPackagingLevelNumber;
			
			$Cild14cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-7);
			$results14 = $this->db->select($Cild14cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel14 = $results14->$Cild14cartonPackagingLevelNumber;
			
			$Cild13cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-8);
			$results13 = $this->db->select($Cild13cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel13 = $results13->$Cild13cartonPackagingLevelNumber;
			
			$Cild12cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-9);
			$results12 = $this->db->select($Cild12cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel12 = $results12->$Cild12cartonPackagingLevelNumber;
			
			$Cild11cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-10);
			$results11 = $this->db->select($Cild11cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel11 = $results11->$Cild11cartonPackagingLevelNumber;
			
			$Cild10cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-11);
			$results10 = $this->db->select($Cild10cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel10 = $results10->$Cild10cartonPackagingLevelNumber;
			
			$Cild9cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-12);
			$results9 = $this->db->select($Cild9cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel9 = $results9->$Cild9cartonPackagingLevelNumber;
			
			$Cild8cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-13);
			$results8 = $this->db->select($Cild8cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel8 = $results8->$Cild8cartonPackagingLevelNumber;	
			
			$Cild7cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-14);
			$results7 = $this->db->select($Cild7cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel7 = $results7->$Cild7cartonPackagingLevelNumber;	
								
			$Cild6cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-15);
			$results6 = $this->db->select($Cild6cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel6 = $results6->$Cild6cartonPackagingLevelNumber;
			
			$Cild5cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-16);
			$results5 = $this->db->select($Cild5cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel5 = $results5->$Cild5cartonPackagingLevelNumber;
					
			$Cild4cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-17);
			$results4 = $this->db->select($Cild4cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel4 = $results4->$Cild4cartonPackagingLevelNumber;
			
			$Cild3cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-18);
			$results3 = $this->db->select($Cild3cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel3 = $results3->$Cild3cartonPackagingLevelNumber;
			
			$Cild2cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-19);
			$results2 = $this->db->select($Cild2cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel2 = $results2->$Cild2cartonPackagingLevelNumber;
			
			$Cild1cartonPackagingLevelNumber = "pack_level" . ($listData['code_packaging_level']-20);
			$results1 = $this->db->select($Cild1cartonPackagingLevelNumber)->from('product_packaging_qty_levels')->where('product_id', $listData['product_id'])->get()->row();
			$NumberofchildernatLevel1 = $results1->$Cild1cartonPackagingLevelNumber;
			
			$TotalChildren = $NumberofchildernatLevel21 * $NumberofchildernatLevel20 * $NumberofchildernatLevel19 * $NumberofchildernatLevel18 *$NumberofchildernatLevel17 *$NumberofchildernatLevel16 * $NumberofchildernatLevel15 * $NumberofchildernatLevel14 * $NumberofchildernatLevel13 * $NumberofchildernatLevel12 * $NumberofchildernatLevel11 * $NumberofchildernatLevel10 * $NumberofchildernatLevel9 * $NumberofchildernatLevel8 * $NumberofchildernatLevel7 * $NumberofchildernatLevel6 * $NumberofchildernatLevel5 * $NumberofchildernatLevel4 * $NumberofchildernatLevel3 * $NumberofchildernatLevel2 * $NumberofchildernatLevel1;
			
			echo $TotalChildren * $balance_qty;					
								break;
						}
						?></td>
						<!--<td><?php //echo anchor("reports/product_physical_packaging_reports", '<i class="ace-icon fa fa-eye bigger-130"> View Report</i>', array('class' => 'btn btn-xs btn-info','title'=>'View Report'));  ?></td>-->
                                              </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="15" class="color error">No Records Founds</td></tr>
										<?php }?>
                                       
                                    </tbody>
                                        </table>
										</div> 
                                        <div class="row paging-box">
                                        <?php echo $links ?>
                                        </div>                                    
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

			 <div class="modal-container"></div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
		
<?php $this->load->view('../includes/admin_footer');?>
<!---------- modal popup dynaimic---------->
<script type="text/javascript">
	//$(document).ready(function(){
		function print_order(val){
		var url = "<?php echo base_url().'order_master/barcode/view_detail/';?>"+val;
		//jQuery('#modellink').click(function(e) {
		    $('.modal-container').load(url,function(result){
				$('#printMyModal').modal({show:true});
			});
		//});
		}
	//});
</script>
<!---------- modal popup dynaimic---------->
<script>

function validateSrch(){
	$("#searchStr").removeClass('error');
	var val = $("#searchStr").val();
 	if(val.trim()==''){
		$("#searchStr").addClass('error');
		return false;
	}
}

/*function print_option(id){
	var qrrystr;
	qrrystr='generate_order/';
	if($("#print_order_"+id).val()==1){
		qrrystr='generate_order_barcode/';
	}
	var url = qrrystr+btoa(id);
	window.location.href=url;
}
*/
function change_order_status(id,val){
$("#order_status_"+id).hide();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>order_master/change_order_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(result!=''){
						alert('Status Changed Successfully');
						if(parseInt(val)==1){ 
							$("#order_status_"+id).show();
						}
					} 
					
				}
			});
}		
function change_status(id,val){order_status_
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>order_master/change_status/",
				data: {id:id, value:val},
				success: function (result) {
					if(parseInt(result)==1){
						$('#status_'+id).val('Active').css("background-color","green");
					}else{
						$('#status_'+id).val('Inactive').css("background-color","red");
					}
					
				}
			});
}
var table;
 
 
       
 
</script>

<script>$(function () {
     var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
//initializing datepicker
$('.datepicker').datepicker({format:'yyyy-mm-dd', startDate: today,minDate: new Date()  });
 });
 
  

 $("form#frm").validate({
 		rules: {
  			"product[]":{required: true},
 		    quantity: {required: true,number: true}
        		} ,
  		 
 		messages: {
			"product[]": {required: "Please enter Product Name/SKU Code" } , 
			quantity: {	required: "Please enter quantity"} 
		},
 		submitHandler: function(form) {
  			var dataSend;
 			var dataSend 	= $("#frm").serialize();
  			$.ajax({
 				type: "POST",
 				dataType:"json",
 				beforeSend: function(){
				$('.alert-success').hide();
 						//$(".show_loader").show();
  						//$(".show_loader").click();
 				},
 				url: "<?php echo base_url(); ?>order_master/save_order/",
 				data: dataSend,
 				success: function (msg) {
					
 					if(parseInt(msg)==1){
					$('#myModal').modal('hide');
 						//$('#ajax_msg').text("User Added Successfully!").css("color","green").show();
 						$('.alert-success').show();
 						$('#frm')[0].reset(); 
						window.location="<?php echo base_url(); ?>order_master/list_orders/";
 						 					
 					}
 				}

			});

			 return false;

 		}

	});
 
 
 
 
 </script>
 <?php if($this->uri->segment(3)=='open'){?>
 <script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
<?php }?>
 
<?php $this->load->view('../includes/admin_footer');?>