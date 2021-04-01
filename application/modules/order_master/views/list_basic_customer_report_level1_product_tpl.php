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
			<?php $label = 'Pre Purchase Scan Report';?>

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
                                                                                            <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Customer Name OR Bar-QR Code OR Product Name or Consumer ID">
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
									<th style="text-align:center">	<div style="word-wrap:break-word; width:40px;">		1	</div>	</th>
									<th style="text-align:center">	<div style="word-wrap:break-word; width:200px;">	2	</div>	</th>
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
									
  													</tr>
													
													<tr>
									<th style="text-align:center">	S. No.	</th>
									<th style="text-align:center">	Date and time of scan	</th>
									<th style="text-align:center">	First Scan (Yes/No)	</th>
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
									<th style="text-align:center">	If Consumer bought the product scanned with same Product ID	</th>
									<th style="text-align:center">	If Consumer bought any product of Brand earlier (Yes/No)	</th>
									<th style="text-align:center">	Date and Time of Last Buying	</th>
									<th style="text-align:center">	Product ID bought & registered	</th>
									<th style="text-align:center">	Video Played after Scan (Yes/No)	</th>
									<th style="text-align:center">	Video played from Scan/History	</th>
									<th style="text-align:center">	Video played Complete(Yes/No)	</th>
									<th style="text-align:center">	Responded to feedback questions (Yes/No)	</th>
									<th style="text-align:center">	Level 1 Video Question 1	</th>
									<th style="text-align:center">	Response to Question 1	</th>
									<th style="text-align:center">	Level 1 Video Question 2	</th>
									<th style="text-align:center">	Response to Question 2	</th>
									<th style="text-align:center">	Level 1 Video Question 3	</th>
									<th style="text-align:center">	Response to Question 3	</th>
									<th style="text-align:center">	Level 1 Video Question 4	</th>
									<th style="text-align:center">	Response to Question 4	</th>
									<th style="text-align:center">	Loyalty Points Awarded	</th>
									<th style="text-align:center">	Audio Played after Scan (Yes/No)	</th>
									<th style="text-align:center">	Audio played from Scan/History	</th>
									<th style="text-align:center">	Audio played Complete(Yes/No)	</th>
									<th style="text-align:center">	Responded to feedback questions (Yes/No)	</th>
									<th style="text-align:center">	Level 1 Audio Question 1	</th>
									<th style="text-align:center">	Response to Question 1	</th>
									<th style="text-align:center">	Level 1 Audio Question 2	</th>
									<th style="text-align:center">	Response to Question 2	</th>
									<th style="text-align:center">	Level 1 Audio Question 3	</th>
									<th style="text-align:center">	Response to Question 3	</th>
									<th style="text-align:center">	Level 1 Audio Question 4	</th>
									<th style="text-align:center">	Response to Question 4	</th>
									<th style="text-align:center">	Loyalty Points Awarded	</th>
									<th style="text-align:center">	PDF Played after Scan (Yes/No)	</th>
									<th style="text-align:center">	PDF played from Scan/History	</th>
									<th style="text-align:center">	PDF played Complete(Yes/No)	</th>
									<th style="text-align:center">	Responded to feedback questions (Yes/No)	</th>
									<th style="text-align:center">	Level 1 PDF Question 1	</th>
									<th style="text-align:center">	Response to Question 1	</th>
									<th style="text-align:center">	Level 1 PDF Question 2	</th>
									<th style="text-align:center">	Response to Question 2	</th>
									<th style="text-align:center">	Level 1 PDF Question 3	</th>
									<th style="text-align:center">	Response to Question 3	</th>
									<th style="text-align:center">	Level 1 PDF Question 4	</th>
									<th style="text-align:center">	Response to Question 4	</th>
									<th style="text-align:center">	Loyalty Points Awarded	</th>
														
  													</tr>
													<!--<tr>
													  <th>Latitude/Longitude</th>
													  <th>City</th>
													  <th>PIN</th>
													  <th>Yes/No</th>
												      <th>Date and Time of Last Buying</th>
												      <th>Product ID bought &amp; registered</th>
												      <th>Yes/No</th>
												      <th>Video played from Scan/History</th>
												      <th>Complete/Incomplete</th>
												      <th>Responded/Not Responded</th>
												      <th>Response to Question No. 1</th>
												      <th>Response to Question No. 2 </th>
												      <th>Response to Question No. 3 </th>
												      <th>Response to Question No. 4 </th>
												      <th>Loyalty Points Awarded</th>
												      <th>Yes/No</th>
												      <th>Audio played from Scan/History</th>
												      <th>Complete/Incomplete</th>
												      <th>Responded/Not Responded</th>
												      <th>Response to Question No. 1</th>
												      <th>Response to Question No. 2 </th>
												      <th>Response to Question No. 3 </th>
												      <th>Response to Question No. 4 </th>
												      <th>Loyalty Points Awarded</th>
												      <th>Yes/No</th>
												      <th>PDF played from Scan/History</th>
												      <th>Complete/Incomplete</th>
												      <th>Responded/Not Responded</th>
												      <th>Response to Question No. 1</th>
												      <th>Response to Question No. 2 </th>
												      <th>Response to Question No. 3 </th>
												      <th>Response to Question No. 4 </th>
												      <th>Loyalty Points Awarded</th>
												  </tr>-->
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
											<td style="text-align:center"><?php echo (date('j M Y H:i:s D', strtotime($listData['code_scan_date']))); ?></td>
											
											<?php 
											
								include('url_base_con_db.php');
								
								$sql02 = "select scan_id FROM scanned_products where bar_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' ORDER BY scan_id ASC";
											
								$result02 = mysql_query($sql02, $link) or die(mysql_error());
								$number_of_answers02=mysql_num_rows($result02);
								//$req_number_of_answers = 4-$number_of_answers;
								//$row02 = mysql_fetch_assoc($result02);
								if($number_of_answers02 > 1){
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php															
								}else{
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php									
								}
								?>
											<td style="text-align:center"><?php echo $listData['f_name']; ?> <?php echo $listData['l_name']; ?></td>
											<td style="text-align:center"><?php echo $listData['created_by']; ?></td>
											<td style="text-align:center"><?php echo $listData['product_name']; ?></td>											
											<td style="text-align:center"><?php echo $listData['bar_code']; ?></td>
											<td style="text-align:center"><?php echo $listData['latitude'] . "/ " . $listData['longitude']; ?></td>
											<td style="text-align:center"><?php echo $listData['scan_city']; ?></td>
											<td style="text-align:center"><?php echo $listData['pin_code']; ?></td>
											<td style="text-align:center"><?php echo get_consumer_name_by_consumer_id($listData['consumer_id']); ?></td>
											<td style="text-align:center"><?php echo $listData['consumer_id']; ?></td>
											<td style="text-align:center"><?php echo $listData['issue_location']; ?></td>
											<td style="text-align:center"><?php echo $listData['print_batch_id']; ?></td>
											<td style="text-align:center"><?php  								
								
								$sql = "select purchased_product_id FROM purchased_product where product_id = '".$listData['product_id']."' AND consumer_id = '".$listData['consumer_id']."' ORDER BY purchased_product_id DESC";
													
								$result = mysql_query($sql, $link) or die(mysql_error());
								$row = mysql_fetch_assoc($result);
								if($row['purchased_product_id']!=''){
									echo "Yes";
								}else{
									echo "No";
								}
								?></td>
								<?php 
								
								//$sql1 = "select purchased_product_id, create_date, product_id FROM purchased_product where product_id != '".$listData['product_id']."' AND consumer_id = '".$listData['consumer_id']."'  AND customer_id = '".$listData['created_by']."' ORDER BY purchased_product_id DESC";
								
								$sql1 = "select purchased_product_id, create_date, product_id FROM purchased_product where consumer_id = '".$listData['consumer_id']."'  AND customer_id = '".$listData['created_by']."' ORDER BY purchased_product_id DESC";
													
								$result1 = mysql_query($sql1, $link) or die(mysql_error());
								$row1 = mysql_fetch_assoc($result1);
								if($row1['purchased_product_id']!=''){
									?> <td style="text-align:center"><?php echo "Yes"; ?></td> <?php
									?> <td style="text-align:center"><?php echo $row1['create_date']; ?></td> <?php
									?> <td style="text-align:center"><?php echo $row1['product_id']; ?></td> <?php
									
								}else{
									?> <td style="text-align:center"><?php echo "No"; ?></td> <?php
									?> <td style="text-align:center"><?php echo "No"; ?></td> <?php
									?> <td style="text-align:center"><?php echo "No"; ?></td> <?php
								}
								?>
								
								<?php 
								$sql2 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product Video' ORDER BY id ASC";
											
								$result2 = mysql_query($sql2, $link) or die(mysql_error());
								//$number_of_answers=mysql_num_rows($result2);
								//$req_number_of_answers = 4-$number_of_answers;
								$row2 = mysql_fetch_assoc($result2);
								if($row2['id']!=''){
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row2['media_play_location']; ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row2['watched_complete']; ?></td> <?php								
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								
								}
								?>
								
								<?php 
								$sql3 = "select id, question_id, selected_answer FROM consumer_feedback where product_qr_code = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."' AND media_type = 'Product Video' ORDER BY id ASC";
											
								$result3 = mysql_query($sql3, $link) or die(mysql_error());
								$number_of_answers3 = mysql_num_rows($result3);
								$req_number_of_answers3 = 4-$number_of_answers3;
								$row3 = mysql_fetch_assoc($result3);
								if($row3['id']!=''){	
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo get_question_by_id($row3['question_id']); ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row3['selected_answer']; ?></td> <?php
								while($row3s = mysql_fetch_array($result3))
								{
								?> <td style="text-align:center">	<?php echo get_question_by_id($row3s['question_id']); ?></td> <?php	
								?> <td style="text-align:center"><?php echo $row3s['selected_answer']; ?></td> <?php
								}
								
								for($x = 0; $x <= $req_number_of_answers3-1; $x++) {
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									}									
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								}
								?>
								
								<td style="text-align:center"><?php 
								$sql4 = "select id, points FROM loylty_points where promotion_id = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."'";
													
								$result4 = mysql_query($sql4, $link) or die(mysql_error());
								$row4 = mysql_fetch_assoc($result4);
								if($row4['id']!=''){
									echo $row4['points'];
								}else{
									echo "-";
								}
								?></td>
								
								<?php 
								$sql5 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product Audio' ORDER BY id ASC";
											
								$result5 = mysql_query($sql5, $link) or die(mysql_error());
								$row5 = mysql_fetch_assoc($result5);
								if($row5['id']!=''){
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row5['media_play_location']; ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row5['watched_complete']; ?></td> <?php								
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								
								}
								?>
								
								<?php 
								$sql6 = "select id, question_id, selected_answer FROM consumer_feedback where product_qr_code = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."' AND media_type = 'Product Audio' ORDER BY id ASC";
											
								$result6 = mysql_query($sql6, $link) or die(mysql_error());
								$number_of_answers6 = mysql_num_rows($result6);
								$req_number_of_answers6 = 4-$number_of_answers6;
								$row6 = mysql_fetch_assoc($result6);
								if($row6['id']!=''){	
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo get_question_by_id($row6['question_id']); ?></td> <?php	
								?> <td style="text-align:center">	<?php echo $row6['selected_answer']; ?></td> <?php
								while($row6s = mysql_fetch_array($result6))
								{
								?> <td style="text-align:center">	<?php echo get_question_by_id($row6s['question_id']); ?></td> <?php	
								?> <td style="text-align:center">	<?php echo $row6s['selected_answer']; ?></td> <?php
								}								
								for($x = 0; $x <= $req_number_of_answers6-1; $x++) {
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									}
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								}
								?>
								
								<td style="text-align:center"><?php 
								$sql7 = "select id, points FROM loylty_points where promotion_id = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."'";
													
								$result7 = mysql_query($sql7, $link) or die(mysql_error());
								$row7 = mysql_fetch_assoc($result7);
								if($row7['id']!=''){
									echo $row7['points'];
								}else{
									echo "-";
								}
								?></td>
								
								<?php 
								$sql8 = "select id, watched_complete, media_play_location FROM consumer_media_view_details where product_qr_code = '".$listData['bar_code']."' AND consumer_id = '".$listData['consumer_id']."' AND media_type = 'Product PDF' ORDER BY id ASC";
											
								$result8 = mysql_query($sql8, $link) or die(mysql_error());
								//$number_of_answers=mysql_num_rows($result2);
								//$req_number_of_answers = 4-$number_of_answers;
								$row8 = mysql_fetch_assoc($result8);
								if($row8['id']!=''){
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row8['media_play_location']; ?></td> <?php
								?> <td style="text-align:center">	<?php echo $row8['watched_complete']; ?></td> <?php								
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								
								}
								?>
								
								<?php 
								$sql9 = "select id, question_id, selected_answer FROM consumer_feedback where product_qr_code = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."' AND media_type = 'Product PDF' ORDER BY id ASC";
											
								$result9 = mysql_query($sql9, $link) or die(mysql_error());
								$number_of_answers9 = mysql_num_rows($result9);
								$req_number_of_answers9 = 4-$number_of_answers9;
								$row9 = mysql_fetch_assoc($result9);
								if($row9['id']!=''){	
								?> <td style="text-align:center">	<?php echo "Yes"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo get_question_by_id($row9['question_id']); ?></td> <?php	
								?> <td style="text-align:center">	<?php echo $row9['selected_answer']; ?></td> <?php
								while($row9s = mysql_fetch_array($result9))
								{
								?> <td style="text-align:center">	<?php echo get_question_by_id($row9s['question_id']); ?></td> <?php	
								?> <td style="text-align:center">	<?php echo $row9s['selected_answer']; ?></td> <?php
								}
								
								for($x = 0; $x <= $req_number_of_answers9-1; $x++) {
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									?> <td style="text-align:center">	<?php echo "-"; ?></td> <?php
									}
								}else{
								?> <td style="text-align:center">	<?php echo "No"; ?></td> <?php	
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								?> <td style="text-align:center">	<?php echo ""; ?></td> <?php
								}
								?>
								
								<td style="text-align:center"><?php 
								$sql10 = "select id, points FROM loylty_points where promotion_id = '".$listData['bar_code']."' AND user_id = '".$listData['consumer_id']."'";
													
								$result10 = mysql_query($sql10, $link) or die(mysql_error());
								$row10 = mysql_fetch_assoc($result10);
								if($row10['id']!=''){
									echo $row10['points'];
								}else{
									echo "-";
								}
								?></td>
                                              </tr>	
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="11" class="color error">No Records Founds</td></tr>
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