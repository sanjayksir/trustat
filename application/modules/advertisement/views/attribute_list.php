<?php $this->load->view('../includes/admin_header'); ?>

<?php $this->load->view('../includes/admin_top_navigation'); ?>

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

                        <a href="#">Home</a>

                    </li>



                    <li>

                        <a href="#">Master</a>

                    </li>

                    <li class="active">MANAGE ATTRIBUTES</li>

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

                                <h3 class="header smaller lighter blue">MANAGE ATTRIBUTES</h3>

                                <div class="table-header">
                                    Attributes Listing
                                 </div>
 								<!--<div style="clear:both;"><?php echo anchor('product/addProduct', 'Add Property',array('class' => 'btn btn-primary pull-right')); ?></di-->
                                  <table id="dynamic-table" class="table table-striped table-bordered table-hover">  
                                      <thead>
                                         <tr>
                                             <th>S No.</th>
                                             <th class="hidden-480">Category Name</th>
                                             <th>CreatedDate</th>
                                             <th>Action</th>
                                         </tr>
                                     </thead>
                                      <tbody>
                                         <?php 	$i=0;
 												foreach ($get_attr as $attr){
 												$i++;
                                          ?>
                                             <tr id="show<?php echo $attr['product_id']; ?>">
                                                 <td><?php echo $i; ?></td>
                                                 <td><?php echo $attr['name']; ?></td>
                                                 <td><?php echo $attr['created_date']; ?></td>
                                                  <td>
 														<div class="hidden-sm hidden-xs btn-group">
 															<!--<a href="asas" class="btn btn-xs btn-success">
 																<i class="fa fa-plus" aria-hidden="true" ></i>
  															</a>-->
  															<a href="<?php echo base_url();?>product/update_attributes/<?php echo $attr['product_id'];?>" class="btn btn-xs btn-info">
 																<i class="ace-icon fa fa-pencil bigger-120"></i>
 															</a>
  															<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="delete_attr('<?php echo $attr['product_id'];?>');">

																<i class="ace-icon fa fa-trash-o bigger-120"></i>

															</a>

 															<!--<button class="btn btn-xs btn-warning">

																<i class="ace-icon fa fa-flag bigger-120"></i>

															</button>-->

														</div>

 													</td>

                                             </tr>

                                        <?php } ?>

                                    </tbody>

                                </table>

								 </div><!-- /.col -->

                                <?php echo $this->pagination->create_links(); ?>

                                <!-- PAGE CONTENT ENDS -->

                            </div><!-- /.col -->

                        </div><!-- /.row -->

                    </div><!-- /.page-content -->

                </div>

            </div><!-- /.main-content -->

             <div class="footer">

                <div class="footer-inner">

                    <div class="footer-content">

                        <span class="bigger-120">

				<span class="blue bolder">Copyright ©</span>

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

<script>
function delete_attr(id){  if (confirm("Sure to update Status") == true) {
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



        <?php $this->load->view('../includes/admin_footer'); ?>

