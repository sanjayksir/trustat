<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
	<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<?php $label = 'Manage Surveys';?>

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
                                                                        <h5 class="widget-title bigger lighter">List <?php echo $label;?>, Survey Number - <?php echo $this->uri->segment(3);?></h5>
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
                                                                                    </div>
                                                                                    <div class="col-sm-6">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Consumer Name, Product Name, Media Type or 	Survey Feedback Response">
                                                                                            <span class="input-group-btn">
                                                                                                <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                                                                <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
																			
			<!-- <div class="form-group row">
			Closer Report for Ad/Survey/Messages<br /> Name of Promotion
Promotion Category ??? Ad/Survey <br />
Promotion Number ??? sssss<br />
 Promotion Launch Date ??? ddd<br />
Promotion Closer date ??? sss <br />
Promotion report date ??? sss <br />
Selection Criteria number ??? nnn <br />
 Number of consumers selected ???<br />
Number of responses from consumers : 111 Download <br />

			  <label for="form-field-8">Media </label> : (Video, Audio???.) <br />
			   <label for="form-field-8">Questions</label> : Basic Tea to be replaced by<br />
			    <label for="form-field-8">Response a?????? Icecream Number of consumers </label> : 
							<label for="form-field-8">Number of consumers who have Responded a</label><br />
							
							<label for="form-field-8">Response b?????? Icecream Number of consumers </label> : 
							<label for="form-field-8">Number of consumers who have Responded b</label><br />
							
							<label for="form-field-8">Response c?????? Icecream Number of consumers </label> : 
							<label for="form-field-8">Number of consumers who have Responded c</label><br />
							
							<label for="form-field-8">Response d?????? Icecream Number of consumers </label> : 
							<label for="form-field-8">Number of consumers who have Responded d</label><br />
							
				
		</div>	-->							
										
 											<table id="missing_people" class="table table-striped table-bordered table-hover">
 												<thead>
													<tr>
														<th>#</th>
														<th>Consumer Name</th>
														<th>Product Name</th>
 														<th>Media Type</th>
														<th>Push Date Time</th> 
														<th>Survey Feedback Question, Response, Date Time</th>
                                                       
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
											   <td><?php echo $listData['user_name']; ?></td>
											   <td><?php echo $listData['product_name']; ?></td>
												<td><?php echo $listData['media_type']; ?></td>
												<td><?php echo (date('j M Y H:i:s D', strtotime($listData['survey_push_date']))); ?></td>
												<td>
												<?php 
								$promotion_media_type = $listData['promotion_type'] . " " .	$listData['media_type'];			//echo $promotion_media_type;	
								$qproduct_data 	= getquestionFeedbackDetails($listData['product_id'], $listData['consumer_id'], $listData['promotion_id'], $promotion_media_type);
								
								//getquestionFeedbackDetails($product_id, $user_id, $promotion_id, $product_qr_code)
								
										 foreach($qproduct_data as $res){ 
										 
											echo "<b>[</b>" . get_question_desc_by_id($res['question_id']) . "<b>]</b>, ";
											echo "<b>[</b>" . $res['selected_answer'] . "<b>]</b>, ";
											//echo $res['updated_date'];
										echo "<b>[</b>" . (date('j M Y H:i:s D', strtotime($res['updated_date']))) . "<b>]</b>";
											echo "<br>";
												} ?>
												</td>
												
 												<!--<td><?php if($listData['media_play_date']!='0000-00-00 00:00:00') {echo (date('j M Y H:i:s D', strtotime($listData['media_play_date']))); } ?></td>-->
                                              </tr>
                                         <?php }
										}else{ ?>
										<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
                                       
                                    </tbody>
                                        </table>
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