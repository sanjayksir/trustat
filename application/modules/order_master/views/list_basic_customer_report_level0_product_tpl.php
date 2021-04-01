<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>

	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Post Purchase Scan Report';?>

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
                                                                        <h5 class="widget-title bigger lighter">List <?php echo $label;?>, Product Name - <?php echo get_products_name_by_id($this->uri->segment(4));?></h5>
                                                                    </div>
									<div class="widget-body">
                                                                            <div class="row filter-box">
                                                                                <form id="form-filter" action="" method="get" class="form-horizontal" >
                                                                                    <div class="col-sm-6">
                                                                                        <label>Display
                                                                                            <select name="page_limit" id="page_limit" class="form-control" onchange="this.form.submit()">
                                                                                            <?php echo Utils::selectOptions('pagelimit',['options'=>$this->config->item('pageOption'),'value'=>$this->config->item('pageLimit')]) ?>
                                                                                            </select>
                                                                                        Records
                                                                                        </label>
																						<label><a href="#" onclick="$('#List_Consumer').tableExport({type:'excel',escape:'false'});"> <img src="<?php echo base_url();?>assets/images/excel_xls.png" width="24px" style="margin-left:100px"> Export to Excel</a></label>
                                                                                    </div>
                                                                                    <div class="col-sm-6">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Product Name or Bar-QR Code or Consumer ID or Invoice Date">
                                                                                            <span class="input-group-btn">
                                                                                                <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                                                                <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
																								
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
							<div style="overflow-x:auto;">
 								<table id="List_Consumer" class="table table-striped table-bordered table-hover">
 												
												<thead>
												<tr>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:20px;">		1	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	2	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	3	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	4	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	5	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	6	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	7	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	8	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	9	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	10	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	11	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	12	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	13	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	14	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	15	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	16	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	17	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	18	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	19	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	20	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	21	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	22	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	23	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	24	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	25	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	26	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	27	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	28	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	29	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	30	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	31	</div>	</th>
								    <th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	32	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	33	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	34	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	35	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	36	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	37	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	38	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	39	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	40	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	41	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	42	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	43	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	44	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	45	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	46	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	47	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	48	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	49	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	50	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	51	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	52	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	53	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	54	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	55	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	56	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	57	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	58	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	59	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:150px;">	60	</div>	</th>

  													</tr>
													
													<tr>
												<th style="text-align:center">	S. No.	</th>
												<th style="text-align:center">	Date and time of scan	</th>
												<th style="text-align:center">	Customer Name	</th>
												<th style="text-align:center">	Customer ID	</th>
												<th style="text-align:center">	Product Name	</th>
												<th style="text-align:center">	Unique Product Code	</th>
												<th style="text-align:center">	Geolocation Latitude/Longitude	</th>
												<th style="text-align:center">	Geolocation City	</th>
												<th style="text-align:center">	Geolocation PIN Code	</th>
												<th style="text-align:center">	Consumer name	</th>
												<th style="text-align:center">	Consumer ID	</th>
												<th style="text-align:center">	Last Retail Store Stock under TRACEK	</th>
												<th style="text-align:center">	Scanned Product Batch Details	</th>
												<th style="text-align:center">	Product Warranty (Yes/No)	</th>
												<th style="text-align:center">	Invoice Uploading Date & Time	</th>
												<th style="text-align:center">	Date of Verification of Invoice	</th>
												<th style="text-align:center">	Invoice Date	</th>
												<th style="text-align:center">	Retailer Name on Invoice	</th>
												<th style="text-align:center">	Price on Invoice	</th>
												<th style="text-align:center">	Product scanned earlier (Yes/No)	</th>
												<th style="text-align:center">	Product scanned (Level 0/ Level 1)	</th>
												<th style="text-align:center">	Date of Product Scan	</th>
												<th style="text-align:center">	Product Feedback	</th>
												<th style="text-align:center">	Consumer Complaint Registered	</th>
												<th style="text-align:center">	Demo Video Played (Yes/No)	</th>
												<th style="text-align:center">	Video played from Scan/History	</th>
												<th style="text-align:center">	Complete/Incomplete	</th>
												<th style="text-align:center">	Responded to Feedback questions	</th>
												<th style="text-align:center">	Demo Video Question 1	</th>
												<th style="text-align:center">	Response to Question 1	</th>
												<th style="text-align:center">	Demo Video Question 2	</th>
												<th style="text-align:center">	Response to Question 2	</th>
												<th style="text-align:center">	Demo Video Question 3	</th>
												<th style="text-align:center">	Response to Question 3	</th>
												<th style="text-align:center">	Demo Video Question 4	</th>
												<th style="text-align:center">	Response to Question 4	</th>
												<th style="text-align:center">	Loyalty Points Awarded	</th>
												<th style="text-align:center">	Demo Audio Played (Yes/No)	</th>
												<th style="text-align:center">	Audio played from Scan/History	</th>
												<th style="text-align:center">	Complete/Incomplete	</th>
												<th style="text-align:center">	Responded to Feedback questions	</th>
												<th style="text-align:center">	Demo Audio Question 1	</th>
												<th style="text-align:center">	Response to Question 1	</th>
												<th style="text-align:center">	Demo Audio Question 2	</th>
												<th style="text-align:center">	Response to Question 2	</th>
												<th style="text-align:center">	Demo Audio Question 3	</th>
												<th style="text-align:center">	Response to Question 3	</th>
												<th style="text-align:center">	Demo Audio Question 4	</th>
												<th style="text-align:center">	Response to Question 4	</th>
												<th style="text-align:center">	Loyalty Points Awarded	</th>
												<th style="text-align:center">	Product Cetalogue Watched (yes/No)	</th>
												<th style="text-align:center">	Product Cetalogue PDF played from Scan/History	</th>
												<th style="text-align:center">	Video Played after Product Registration (Yes/No)	</th>
												<th style="text-align:center">	Video played from Scan/History	</th>
												<th style="text-align:center">	Video Played Complete(Yes/No)	</th>
												<th style="text-align:center">	Audio Played after Product Registration (Yes/No)	</th>
												<th style="text-align:center">	Audio played from Scan/History	</th>
												<th style="text-align:center">	Audio Played Complete(Yes/No)	</th>
												<th style="text-align:center">	PDF Played after Product Registration (Yes/No)	</th>
												<th style="text-align:center">	PDF played from Scan/History	</th>
	
													
													</tr>
													<!--
													<tr>
														<th rowspan="3">	S. No.		</th>
														<th rowspan="3">	Date and time of scan		</th>
														<th rowspan="3">	Customer Name 		</th>
														<th rowspan="3">	Customer ID		</th>
														<th rowspan="3">	Product Name		</th>
														<th rowspan="3">	Unique Product Code		</th>
														<th colspan="3" rowspan="2" style="text-align:center">	Geolocation of Scan of Level 0		</th>
														<th rowspan="3">	Consumer ID		</th>
														<th rowspan="3">	Last Retail Store Stock under TRACEK		</th>
														<th rowspan="3">	Scanned Product Batch Details		</th>
														<th colspan="6" style="text-align:center">Product Covered Under Warranty</th>
														<th colspan="3" rowspan="2"> If Consumer who bought the product scanned the product earlier </th>
														<th rowspan="3">Product Feedback </th>
														<th rowspan="3">	Consumer Complaint Registered	</th>
														<th colspan="9" rowspan="2" style="text-align:center"> If Demo Video Played after Product Registration </th>
														<th colspan="9" rowspan="2" style="text-align:center">If Demo Audio Played after Product Registration</th>
														<th colspan="3" rowspan="2" style="text-align:center">If Product Cetalogue Watched after Product Registration</th>
														<th colspan="3" rowspan="2" style="text-align:center">If Video Played after Product Registration</th>
														<th colspan="3" rowspan="2" style="text-align:center">If Audio Played after Product Registration</th>
														<th colspan="3" rowspan="2" style="text-align:center"> PDF Played </th>
													</tr>
													<tr>
													  <th rowspan="2">Yes/No</th>
												      <th rowspan="2">Invoice Uploading Date &amp; Time</th>
												      <th colspan="4" style="text-align:center">Invoice Verification Details</th>
											      </tr>
													<tr>
													  <th>Latitude/Longitude</th>
													  <th>City</th>
													  <th>PIN</th>
													  <th>Date of Verification</th>
												      <th>Invoice Date</th>
												      <th>Retailer Name</th>
												      <th>Net Selling Price</th>
												      <th>Yes/No</th>
												      <th>Level 0/ Level 1</th>
												      <th>Date of Scan </th>
												      <th>Yes/No</th>
												      <th>Video played from Scan/History</th>
												      <th>Complete/Incomplete</th>
												      <th>Responded/Not Responded</th>
												      <th>Response to Question No. 1</th>
												      <th>Response to Question No. 2</th>
												      <th>Response to Question No. 3</th>
												      <th>Response to Question No. 4</th>
												      <th>Loyalty Points Awarded</th>
												      <th>Yes/No</th>
												      <th>Audio played from Scan/History</th>
												      <th>Complete/Incomplete</th>
												      <th>Responded/Not Responded</th>
												      <th>Response to Question No. 1</th>
												      <th>Response to Question No. 2</th>
												      <th>Response to Question No. 3</th>
												      <th>Response to Question No. 4</th>
												      <th>Loyalty Points Awarded</th>
												      <th>Yes/No</th>
												      <th>PDF played from Scan/History</th>
												      <th>Complete/Incomplete</th>												     
												      <th>Yes/No</th>
												      <th>Video played from Scan/History</th>
												      <th>Complete/Incomplete</th>												     
												      <th>Yes/No</th>
												      <th>Audio played from Scan/History</th>
												      <th>Complete/Incomplete</th>
												      <th>Yes/No</th>
												      <th>PDF played from Scan/History</th>
												      <th>Complete/Incomplete</th>
												  </tr>	
														-->												  
												</thead>
												<tbody>

                                        <?php $i = 0;  //  echo '***<pre>';print_r($orderListing);
										if(count($ScanedCodeListing)>0){
											$i=0;
                                        $page = !empty($this->uri->segment(5))?$this->uri->segment(5):0;
									$sno =  $page + 1;
                                        foreach ($ScanedCodeListing as $key=>$listData){
											$i++;
											?>
                                               <tr id="show<?php echo $key; ?>">
											   <td style="text-align:center"><?php echo $sno;$sno++; ?></td>
											   <td style="text-align:center"><?php echo $listData['create_date']; ?></td>
											   <td style="text-align:center"><?php echo getUserNameById($listData['created_by']); ?></td>
											   <td style="text-align:center"><?php echo $listData['created_by']; ?></td>
											   <td style="text-align:center"><?php echo $listData['product_name']; ?></td>
											   <td style="text-align:center"><?php echo $listData['bar_code']; ?></td>
											   <td style="text-align:center"><?php echo $listData['latitude'] . "/ " . $listData['longitude']; ?></td>
											   <td style="text-align:center"><?php echo $listData['scan_city']; ?></td>
											   <td style="text-align:center"><?php echo $listData['pr_pin_code']; ?></td>
											   <td style="text-align:center"><?php echo $listData['user_name']; ?></td>
											    <td style="text-align:center"><?php echo $listData['consumer_id']; ?></td>
												<td style="text-align:center"><?php echo $listData['issue_location']; ?></td>
												<td style="text-align:center"> <?php echo $listData['print_batch_id']; ?></td>
												<td style="text-align:center"><?php  if($listData['invoice_image']=="")
												{ echo"No"; } else {echo"Yes";} ?></td>
											<td style="text-align:center"> <?php  if($listData['invoice_image']=="")
												{ echo ""; } else {echo $listData['create_date'];} ?></td>
											<td style="text-align:center"> <?php  if($listData['invoice_image']=="")
												{ echo ""; } else {echo $listData['purchase_date'];} ?></td>
											<td style="text-align:center"> <?php echo $listData['purchase_date']; ?></td>
											<td style="text-align:center"> <?php echo $listData['seller_name']; ?></td>
											<td style="text-align:center"> <?php echo $listData['selling_price']; ?></td>
											
											<?php //echo base_url(); 								
								include('url_base_con_db.php');
								
								$sql = "select scan_id, bar_code, code_scan_date FROM scanned_products where product_id = '".$listData['product_id']."' AND consumer_id = '".$listData['consumer_id']."' ORDER BY scan_id DESC";
													
								$result = mysql_query($sql, $link) or die(mysql_error());
								$row = mysql_fetch_assoc($result);
								
								$rowc = mysql_num_rows($result);
								//echo $rowc;
								if($rowc > 1){
									?> <td style="text-align:center"><?php echo "Yes"; ?> </td><?php
									?> <td style="text-align:center"><?php echo $row['bar_code']; ?> </td><?php
									 ?> <td style="text-align:center"><?php echo $row['code_scan_date']; ?> </td><?php
								}else{
									?> <td style="text-align:center"><?php echo "No"; ?> </td><?php
									?> <td style="text-align:center"><?php echo "-"; ?> </td><?php
									?> <td style="text-align:center"><?php echo "-"; ?> </td><?php
								}
								
								?>
								
								<td style="text-align:center"><?php 
								$sql2 = "select fop_id, rating, bar_code FROM feedback_on_product where bar_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' ORDER BY fop_id DESC";
													
								$result2 = mysql_query($sql2, $link) or die(mysql_error());
								$row2 = mysql_fetch_assoc($result2);
								if($row2['fop_id']!=''){
									echo "Yes " . $row2['rating'] . " Star rating given.";
								}else{
									echo "No";
								}
								?></td>
								
								<td style="text-align:center"><?php 
								$sql4 = "select id, complain_code, bar_code FROM consumer_complaint where bar_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' ORDER BY id DESC";
													
								$result4 = mysql_query($sql4, $link) or die(mysql_error());
								$row4 = mysql_fetch_assoc($result4);
								if($row4['id']!=''){
									echo "Yes";
								}else{
									echo "No";
								}
								?></td>
								<td style="text-align:center"><?php 
								$sql5 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product Demo Video' ORDER BY id DESC";
													
								$result5 = mysql_query($sql5, $link) or die(mysql_error());
								$row5 = mysql_fetch_assoc($result5);
								if($row5['id']!=''){
									echo "Yes";
								}else{
									echo "No";
								}
								?></td>
								<td style="text-align:center"><?php echo $row5['media_play_location']; ?></td>
								<td style="text-align:center"> <?php echo $row5['watched_complete']; ?></td>
								
								
								<?php 
								$sql7 = "select id, question_id, selected_answer FROM consumer_feedback where product_qr_code = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."' AND media_type = 'Product Demo Video' ORDER BY id ASC";
											
								$result7 = mysql_query($sql7, $link) or die(mysql_error());
								$number_of_answers7=mysql_num_rows($result7);
								$req_number_of_answers7 = 4-$number_of_answers7;
								$row7 = mysql_fetch_assoc($result7);
								if($row7['id']!=''){
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php	
								?> <td style="text-align:center">	<?php //echo $row7['question_id']; ?><?php echo get_question_by_id($row7['question_id']); ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row7['selected_answer']; ?></td> <?php
								while($row7 = mysql_fetch_array($result7))
								{
								?> <td style="text-align:center">	<?php //echo $row7['question_id']; ?><?php echo get_question_by_id($row7['question_id']); ?></td> <?php	
								?> <td style="text-align:center">	<?php echo $row7['selected_answer']; ?></td> <?php
								}
								
								for($x = 0; $x <= $req_number_of_answers7-1; $x++) {
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									}
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								}
								?>
								
								<td style="text-align:center"><?php 
								$sql8 = "select id, points FROM loylty_points where promotion_id = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."' AND transaction_type = 'product_demo_video_response_lps' ORDER BY id DESC";
													
								$result8 = mysql_query($sql8, $link) or die(mysql_error());
								$row8 = mysql_fetch_assoc($result8);
								if($row8['id']!=''){
									echo $row8['points'];
								}else{
									echo "0";
								}
								?></td>
								
								<td style="text-align:center"><?php 
								$sql9 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product Demo Video' ORDER BY id DESC";
													
								$result9 = mysql_query($sql9, $link) or die(mysql_error());
								$row9 = mysql_fetch_assoc($result9);
								if($row9['id']!=''){
									echo "Yes";
								}else{
									echo "No";
								}
								?></td>
								<td style="text-align:center"><?php echo $row9['media_play_location']; ?></td>
								<td style="text-align:center"> <?php echo $row9['watched_complete']; ?></td>
								
								
								<?php 
								$sql11 = "select id, question_id, selected_answer FROM consumer_feedback where product_qr_code = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."' AND media_type = 'Product Demo Audio' ORDER BY id ASC";
											
								$result11 = mysql_query($sql11, $link) or die(mysql_error());
								$number_of_answers11 = mysql_num_rows($result11);
								$req_number_of_answers11 = 4-$number_of_answers11;
								$row11 = mysql_fetch_assoc($result11);
								if($row11['id']!=''){
								?> <td style="text-align:center"><?php echo "Yes"; ?></td> <?php
								?> <td style="text-align:center"><?php echo get_question_by_id($row11['question_id']); ?></td> <?php								
								?> <td style="text-align:center">	<?php echo $row11['selected_answer']; ?></td> <?php
								while($row11s = mysql_fetch_array($result11))
								{
								?> <td style="text-align:center"><?php echo get_question_by_id($row11s['question_id']); ?></td> <?php	
								?> <td style="text-align:center">	<?php echo $row11s['selected_answer']; ?></td> <?php
								}
								
								for($x = 0; $x <= $req_number_of_answers11-1; $x++) {
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									}
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
								}
								?>
								
								<td style="text-align:center"><?php 
								$sql12 = "select id, points FROM loylty_points where promotion_id = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."' AND transaction_type = 'product_demo_audio_response_lps' ORDER BY id DESC";
													
								$result12 = mysql_query($sql12, $link) or die(mysql_error());
								$row12 = mysql_fetch_assoc($result12);
								if($row12['id']!=''){
									echo $row12['points'];
								}else{
									echo "0";
								}
								?></td>
								
								<td style="text-align:center"><?php 
								$sql13 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product PDF' ORDER BY id DESC";
													
								$result13 = mysql_query($sql13, $link) or die(mysql_error());
								$row13 = mysql_fetch_assoc($result13);
								if($row13['id']!=''){
									echo "Yes";
								}else{
									echo "No";
								}
								?></td>
								<td style="text-align:center"><?php echo $row13['media_play_location']; ?></td>
								
								<td style="text-align:center"><?php 
								$sql17 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product Video' ORDER BY id DESC";
													
								$result17 = mysql_query($sql17, $link) or die(mysql_error());
								$row17 = mysql_fetch_assoc($result17);
								if($row17['id']!=''){
									echo "Yes";
								}else{
									echo "No";
								}
								?></td>
								<td style="text-align:center"><?php echo $row17['media_play_location']; ?></td>
								<td style="text-align:center"> <?php echo $row17['watched_complete']; ?></td>
								
								
								
								<td style="text-align:center"><?php 
								$sql21 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product Audio' ORDER BY id DESC";
													
								$result21 = mysql_query($sql21, $link) or die(mysql_error());
								$row21 = mysql_fetch_assoc($result21);
								if($row21['id']!=''){
									echo "Yes";
								}else{
									echo "No";
								}
								?></td>
								<td style="text-align:center"><?php echo $row21['media_play_location']; ?></td>
								<td style="text-align:center"> <?php echo $row21['watched_complete']; ?></td>
								
								
								
								<td style="text-align:center"><?php 
								$sql25 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product PDF' ORDER BY id DESC";
													
								$result25 = mysql_query($sql25, $link) or die(mysql_error());
								$row25 = mysql_fetch_assoc($result25);
								if($row25['id']!=''){
									echo "Yes";
								}else{
									echo "No";
								}
								?></td>
								<td style="text-align:center"><?php echo $row25['media_play_location']; ?></td>
                              </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="10" class="color error">No Records Founds</td></tr>
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