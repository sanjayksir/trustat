<?php $this->load->view('../includes/admin_header'); ?>

<?php //echo '<pre>';print_r($product_list);exit;
$this->load->view('../includes/admin_top_navigation'); ?>

<div class="main-container ace-save-state" id="main-container">

    <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
    </script>

    <?php $this->load->view('../includes/admin_sidebar'); ?>
	
	 
	

     <div class="main-content">

        <div class="main-content-inner">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">

                <ul class="breadcrumb">

                    <li>

                        <i class="ace-icon fa fa-home home-icon"></i>

                       <a href="<?php echo DASH_B;?>">Home</a>

                    </li>



                    <li>

                        <a href="#">Master</a>

                    </li>

                    <li class="active">All Consumers</li>

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
                            <!--<div class="widget-header widget-header-flat">
                                <h5 class="widget-title bigger lighter">MANAGE PRODUCTS</h5>
                                <div class="widget-toolbar">
                                    <a href="<?php //echo base_url('product/add_product') ?>" class="btn btn-xs btn-warning" title="Add Product">Add <?php echo $label; ?> </a>
                                </div>
                            </div>
							-->
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
                                                <input type="text" name="search" id="search" value="<?= $this->input->get('search',null); ?>" class="form-control search-query" placeholder="Consumer Name,Consumer Phone">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-inverse btn-white"><span class="ace-icon fa fa-search icon-on-right bigger-110"></span>Search</button>
                                                    <button type="button" class="btn btn-inverse btn-white" onclick="redirect()"><span class="ace-icon fa fa-times bigger-110"></span>Reset</button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                      <!--------------- Search Tab start----------------->
					  <div style="overflow-x:auto;">
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S No.</th>
                                    <th class="hidden-480">Consumer Name</th>
                                    <th class="hidden-480">Consumer Phone</th>
                                    <th class="hidden-480">Consumer Email</th>
                                    <th>Consumer Photo</th>
                                    <th>Date of Registration</th>
                                    <th>Consumer Aadhaar Number </th>
									<?php 
									$user_id = $this->session->userdata('admin_user_id');
									if($user_id==1){
													   ?>
													     <th class="hidden-480">Consumer Gender</th>
														 <th class="hidden-480">Consumer dob</th>
														 <th class="hidden-480">Consumer Registration Address</th> 
														 <th class="hidden-480">Consumer Alternate Mobile Number</th>
														 <th class="hidden-480">Consumer Street Address</th>
														 <th class="hidden-480">Consumer City</th>
														 <th class="hidden-480">Consumer State</th>
														 <th class="hidden-480">Consumer Pin Code</th>
														 <th class="hidden-480">Consumer Monthly Earnings</th>
														 <th class="hidden-480">Consumer Job Profile</th> 
														 <th class="hidden-480">Consumer Education Qualification</th>
														 <th class="hidden-480">Consumer Type Vehicle</th>
														 <th class="hidden-480">Consumer Profession</th>
														 <th class="hidden-480">Consumer Marital Mtatus</th>
														 <th class="hidden-480">Number of Family Members</th>
														 <th class="hidden-480">Consumer Loan Car Housing</th>
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
														 <th class="hidden-480">Spouse Gender</th>
														 <th class="hidden-480">Spouse Phone</th>
														 <th class="hidden-480">Spouse dob</th>
														 <th class="hidden-480">Marriage Anniversary</th>
														 <th class="hidden-480">Spouse Work Status</th>
														 <th class="hidden-480">Spouse Work Status</th>
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
										
                        if(count($list_all_consumers)>0){
                           // $page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
						   
						   if(($user_id==1) && ($customer_id!="")){
				$page = !empty($this->uri->segment(4))?$this->uri->segment(4):0;
			}else{
			
			$page = !empty($this->uri->segment(3))?$this->uri->segment(3):0;
			}
			
                            $sno =  $page + 1;
                        $i=0;
                        foreach ($list_all_consumers as $attr){
                        $i++;
                         ?>
                                <tr id="show<?php echo $attr['id'];?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $attr['user_name']; ?></td>
                                <td><?php echo $attr['mobile_no']; ?></td>
                                <td><?php echo $attr['email']; ?></td>
                                <td><img src="<?php echo base_url(); ?><?php echo $attr['avatar_url']; ?>" alt="Consumer Photo Not found" height="42" width="42"></td>
                                <td><?php echo $attr['created_at']; ?></td>
                                <td><?php echo $attr['aadhaar_number']; ?></td>
                                                  <?php if($user_id==1){
													   ?>
													    <td><?php echo $attr['gender']; ?></td>
														<td><?php echo $attr['dob']; ?></td>
														<td><?php echo $attr['registration_address']; ?></td>
														<td><?php echo $attr['alternate_mobile_no']; ?></td>
														<td><?php echo $attr['street_address']; ?></td>
														<td><?php echo $attr['city']; ?></td>
														<td><?php echo $attr['state']; ?></td>
														<td><?php echo $attr['pin_code']; ?></td>
														<td><?php echo $attr['monthly_earnings']; ?></td>
														<td><?php echo $attr['job_profile']; ?></td>
														<td><?php echo $attr['education_qualification']; ?></td>
														<td><?php echo $attr['type_vehicle']; ?></td>
														<td><?php echo $attr['profession']; ?></td>
														<td><?php echo $attr['marital_status']; ?></td>
														<td><?php echo $attr['no_of_family_members']; ?></td>
														<td><?php echo $attr['loan_car_housing']; ?></td>
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
										}else{?>
											<tr><td align="center" colspan="8" class="color error">No Records Founds</td></tr>
										<?php }?>
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

                            <span class="blue bolder">Tracking Portal</span>

                            <?=date('Y');?>

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
function assignProduct(){
	 $('#save_value').click(function(){
    var arr = $('.ads_Checkbox:checked').map(function(){
        return this.value;
    }).get();
}); 
}


function delete_attr(id){  if (confirm("Sure to Delete SKU") == true) {
       window.location.href="<?php echo base_url();?>product/delete_attribute/"+id;
    } else {
        return false;
    }
}
</script>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

            </a>

        </div><!-- /.main-container -->



     

