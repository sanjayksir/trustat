<?php $this->load->view('../includes/admin_header'); ?>

<?php //echo '<pre>';print_r($product_list);exit;
$this->load->view('../includes/admin_top_navigation'); ?>

<div class="main-container ace-save-state" id="main-container">

    <script type="text/javascript">

        try {

            ace.settings.loadState('main-container')

        } catch (e) {

        }

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
                        <a href="#">Manage</a>
                    </li>
                    <li class="active">Product Audio Feedback Questions</li>
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

                         <div class="row">

                            <div class="col-xs-12">

                                <h3 class="header smaller lighter blue">Product Name - <?php echo get_products_name_by_id($this->uri->segment(3)); ?></h3>

                               
 								<!--<div style="clear:both;">
								
								<div class="form-group row">
                                    <div class="col-sm-10">&nbsp;</div>
                                     <div class="col-sm-2"><?php //echo anchor('product/add_product', 'Add A Product',array('class' => 'btn btn-primary pull-right')); ?></div> 
									
								</div>
								
								</div>-->
								 <div class="table-header">
                                    Product Audio Feedback Question Listing
                                 </div>
								<!--------------- Search Tab start----------------->
                            <div class="form-group row">
                            <div class="col-sm-10">
                            	<form id="form-filter" action="" method="post" class="form-horizontal" onsubmit="return validateSrch();">
                                <input type="hidden" name="product_id" id="product_id" value="<?php echo $this->uri->segment(3);?>" />
                                <table id="search" class="table table-hover display">
                                    
                                        <tbody>
                                        	<tr>
                                            	<td><input name="search" value="<?php if(!empty($this->input->post('search'))){echo $this->input->post('search');}?>" id="searchStr" placeholder="Search Records" class="form-control" type="text"></td>
                                            	<td>
                                                	<input type="submit" id="btn-filter" value="Search" name="Search" class="btn btn-primary btn-search">&nbsp;
                                                	<button type="button" id="btn-reset" class="btn btn-default btn-search">Reset</button>
                                            	</td>
                                         	</tr>
                                 		 </tbody>
                                   	
                                 </table></form>
								 <?php $product_id = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); ?>
                                 </div> <div class="col-sm-2 pull-right"><?php echo anchor('product/add_audio_feedback/'.$product_id.'/', 'Add New Question',array('class' => 'btn btn-primary pull-right')); ?><?php //echo $product_id;?></div>
                                
                            </div> 
                      <!--------------- Search Tab start----------------->
                                  <table id="dynamic-table" class="table table-striped table-bordered table-hover">  
                                      <thead>
                                         <tr>
                                             <th>S No.</th>
                                             <th class="hidden-480">Select</th>
                                             <th class="hidden-480">Question</th>
											 <th class="hidden-480">Option 1</th>
											 <th class="hidden-480">Option 2</th>
                                             <th class="hidden-480">Option 3</th>
                                             <th class="hidden-480">Option 4</th>
                                             <th class="hidden-480">Answer</th>
											 <th class="hidden-480">Edit/Delete</th>
                                            <!-- <th>Status</th>-->
                                          </tr>
                                     </thead>
                                      <tbody>
                                         <?php 	$i=0;
 												foreach ($product_list as $attr){
 												$i++;
										$get_qst_arr = question_id_by_product($this->uri->segment(3));
												
												//echo $attr['question_id'].'==='.'<pre>';print_r(explode(',',$get_qst_arr));exit;
												$checked = '';
												$x=explode(',',$get_qst_arr);//echo $x[0];
                                            ?>
                                             <tr id="show<?php echo $attr['question_id'];?>">
                                                <td><?php echo $i; ?></td>
                                                
                                                
                                                <td class="center"><input <?PHP if(in_array($attr['question_id'],$x)){?>checked="checked"<?php }?> id="quest_<?php echo $attr['question_id'];?>"name="addquestion" class="ace" onclick="return add_question_to_product('<?php echo $this->uri->segment(3);?>','<?php echo $attr['question_id'];?>');" type="checkbox">
                                                <span class="lbl"></span> </td>
                                                
                                                <td><?php echo $attr['question']; ?></td>
                                                <td><?php echo $attr['answer1']; ?></td>
                                                <td><?php echo $attr['answer2']; ?></td>
                                                <td><?php echo $attr['answer3']; ?></td>
                                                <td><?php echo $attr['answer4']; ?></td>
                                                <td><?php if(!empty($attr['correct_answer'])){echo 'Option-'.$attr['correct_answer'];}; ?></td>
												<td>
                                               <form name="frm_<?php echo $attr['question_id'];?>" id="frm_<?php echo $attr['question_id'];?>" method="post" action="">
 														<div class="hidden-sm hidden-xs btn-group">
   															<a href="<?php echo base_url();?>product/edit_audio_feedback/<?php echo $attr['product_id'];?>/<?php echo $attr['question_id'];?>" class="btn btn-xs btn-info">
 																<i class="ace-icon fa fa-pencil bigger-120"></i>
 															</a>
  															<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="delete_feedback_question('<?php echo $attr['question_id'];?>');">
 																<i class="ace-icon fa fa-trash-o bigger-120"></i>
 															</a>
                                                            <input type="hidden" name="del_submit" value="<?php echo $attr['question_id'];?>" />
														</div>
														</form>
												 </td>
                                              </tr>
                                         <?php } ?>
                                     </tbody>
<tr><td align="right" colspan="10" class="color"><?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?></td></tr>
                                </table>
 								 </div> 
                            </div><!-- /.col -->

                        </div><!-- /.row -->

                    </div><!-- /.page-content -->
                 </div>
             </div><!-- /.main-content -->
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

function add_question_to_product(product_id, quest_id){
	//var r = confirm("Sure to add this question as product feedback?");
	var r = true;
	if (r == true) {
		if ($("#quest_"+quest_id).prop('checked')==true){ 
			var Chk =1; 
		}else{
			var Chk =0;
		}
	
		$.ajax({
			dataType:'html',
			type:'POST',
			url:'<?php echo base_url().'product/save_product_question/';?>',
			data:{p_id:product_id,q_id:quest_id,Chk :Chk},
			success:function (msg){
			}
		
		});
	} else{
		return false;
	} 
}

function delete_feedback_question(question_id){  if (confirm("Sure to Delete this feedback question?") == true) {
       window.location.href="<?php echo base_url();?>product/delete_feedback_question/"+question_id;
    } else {
        return false;
    }
}

 
</script>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

            </a>

        </div><!-- /.main-container -->



     

