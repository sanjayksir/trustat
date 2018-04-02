<?php $this->load->view('../includes/admin_header');?>
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
          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo site_url(); ?>">Home</a> </li>
          <li class="active">Add Child Menu</li>
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
                <h3 class="header smaller lighter blue">Add Child Menu</h3>
                <div id="ajax_msg"></div>
                <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-block alert-success">
                  <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>
                  <i class="ace-icon fa fa-check green"></i> <?php echo $this->session->flashdata('success'); ?> </div>
                <?php endif; ?>
                
                <!--<div class="table-header">
											Results for "Locations"
										</div>--><br>
                <div class="tab-pane fade active in">
                  <?php //$this->load->view('add_menu_form_tpl');?>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="row" id="add_edit_div">
                       
                      <?php 
					  
					// echo '<pre>=='; print_r($this->uri->segment(2));
					  
					  if($this->uri->segment(2)=='get_child_menu'){
                      	 $this->load->view('child_menu_tpl');
                      }else{
						  	 $this->load->view('edit_child_menu_tpl');
					  }?>
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
    <script>
    <!-- Modal content-->
     $(document).ready(function(){	
	$("form#frm").validate({
		rules: {
			title: {
					required: true
				},
				url: {
					required: true
				}  
		},
		messages: {
			title: {
					required: "Please enter first"
				}, 
				url: {
					required: "Please enter url",
					lettersonly: "Only Letters" 
				} 
		},
		submitHandler: function(form) {
		  var dataSend = $("#frm").serialize();
		  $.ajax({
				type: "POST",
				//contentType: "application/json; charset=utf-8",
     			// dataType: "text",
				beforeSend: function(){
						$(".show_loader").show();
				},
				url: "<?php echo base_url(); ?>myspidey_user_group_permissions/saveChildData/",
				data: {form_data:dataSend},
				async: true,				
				success: function (msg) {
					 window.location.href="<?php echo base_url(); ?>myspidey_user_group_permissions/listing/";						
					 
				},
				complete: function(){
					$(".show_loader").hide();
				}
			});
 		}
	});
});


 function Url(val){
		$.ajax({
			type: "POST",
			beforeSend: function(){
					$('#url').val('generating url..');
					$('#url').prop('readonly', true);
					$(".show_loader2").show();
			},
			url: "<?php echo base_url(); ?>myspidey_user_group_permissions/getURL/",
			dataType:"text",
			data: {urlName:val},
			async: true,				
			success: function (msg) {  
				$("#url").val(msg);
			} 
		});
	}
 </script>
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

	  
	});
 	<!------------------------ Validate Fom Add Menu Data----------------------------->

<?php $this->load->view('../includes/admin_footer');?>
