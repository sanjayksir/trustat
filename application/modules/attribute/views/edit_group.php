<?php $this->load->view('../includes/admin_header');?>
<?php $this->load->view('../includes/admin_top_navigation');?>
<!--<script src="<?php echo ASSETS_PATH;?>js/jquery-2.1.4.min.js"></script>
<script src="<?php echo ASSETS_PATH;?>js/bootstrap.min.js"></script>-->
<?php //$res = getGroupList();
//foreach($res as $k->$val){
	
	//$val[$i]['lev1'];
//}
//echo '<pre>';print_r($this->session->userdata());exit;
?>

<div class="main-container ace-save-state" id="main-container"> 
  <script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
  <?php $this->load->view('../includes/admin_sidebar');?>
  <div class="main-content">
    <div class="main-content-inner">
      <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo HOME_PAGE ?>">Home</a> </li>
          <li class="active">Administration</li><li class="active">Group Listing</li>
        </ul>
        <!-- /.breadcrumb -->
        
        <div class="nav-search" id="nav-search">
          <form class="form-search">
            <span class="input-icon">
            <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
            <i class="ace-icon fa fa-search nav-search-icon"></i> </span>
          </form>
        </div>
        <!-- /.nav-search --> 
      </div>
      <div class="page-content">
        <div class="row">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <h3 class="header smaller lighter blue">Group Listing Tree</h3>
                <div id="ajax_msg"></div>
                <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-block alert-success">
                  <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>
                  <i class="ace-icon fa fa-check green"></i> <?php echo $this->session->flashdata('success'); ?> </div>
                <?php endif; ?>
                <br>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="col-xs-6">
                      <?php //if($this->uri->segment(3)==''){?>
                      <div class="row">
                        <?php $this->load->view('tree_list_left_tpl');?>
                      </div>
                      <?php //}?>
                    </div>
                    <!--left end---->
                    
                    <div class="col-xs-6">
                      <div class="tab-pane fade active in">
                        <?php //$this->load->view('add_menu_form_tpl');?>
                        <div class="row">
                          <div class="col-xs-12">
                            <div class="row" id="add_edit_div">
                              <?php $this->load->view('edit_group_right_tpl');?>
                             </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- div.table-responsive --> 
                <!-- div.dataTables_borderWrap --> 
              </div>
            </div>
            <!-- PAGE CONTENT ENDS --> 
          </div>
          <!-- /.col --> 
        </div>
        <!-- /.row --> 
      </div>
      <!-- /.page-content --> 
    </div>
  </div>
  <!-- /.main-content --> 
</div>
<!-- /.main-container -->

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog"> <span id="edit_popup_model"> </span> 
    
    <!-- Modal content-->
    <div class="modal-content"></div>
  </div>
</div>
<div class="modal fade" id="addModal" role="dialog">
  <div class="modal-dialog"> <span id="add_modal_popup"> </span> 
    
    <!-- Modal content-->
    <div class="modal-content"></div>
  </div>
</div>
<script>
	$(document).ready(function() {
		// Data table options setting
	    $('table.display').DataTable(
	    	{
	    		'bPaginate' : false, 
	    		'paging'    : false,
	    		'sDom'		: "lfrti",
	    		'info'		: false,
	    	}
	    );

	    // Fix data-table width 100%
	    $('table').css('width', '100%');

	    $("#submit_country").click(function(event) { });

		$("#submit_state").click(function(event) { });

		// Add City Data
		$("#submit_city").click(function(event) { });

		// Add Area Data
		$("#submit_area").click(function(event) { });

	});
 	<!------------------------ Validate Fom Add Menu Data----------------------------->
 $(document).ready(function(){	
	$("form#frm").validate({
		rules: {
			name: {
					required: true
				},
				description: {
					required: true
				}  
		},
		messages: {
			name: {
					required: "Please Enter Group Name!"
				}, 
				description: {
					required: "Please Enter Description!" 
				} 
		},
		submitHandler: function(form) {
		  var dataSend = $("#frm").serialize();
		  $.ajax({
				type: "POST",
 				beforeSend: function(){
						$(".show_loader").show();
 						$(".show_loader").click();
				},
				url: "<?php echo base_url(); ?>myspidey_user_group_permissions/save_group/",
				data: {form_data:dataSend},
				async: true,				
				success: function (msg) {
					if(typeof $("#menu_id")!==''){
						window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/add_group/";						
					}
				},
				complete: function(){
					$(".show_loader").hide();
				}
			});
 		}
	});
});
 </script>
<?php $this->load->view('../includes/admin_footer');?>
