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
          <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo HOME_PAGE;?>">Home</a> </li>
          <li class="active">Administration</li><li class="active">Manage Attribute</li>
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
                <h3 class="header smaller lighter blue">Manage Attribute</h3>
                <div id="ajax_msg"></div>
                <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-block alert-success">
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
                      
                        <?php  //echo '**'.$this->uri->segment(3); 
						if($this->uri->segment(3)!=''){
                      	 $this->load->view('edit_section');
                      }else{
						  	 $this->load->view('add_section');
					  }?>
                      </div>
                      <?php if($this->uri->segment(3)==''){?>
                      <div class="row">
                      	 <?php $this->load->view('list_section');?>
                      </div>
                      <?php }?>
                      
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
			attribute: {
					required: true/*,
					remote: {

                       	 	url: "<?php echo base_url().'attribute/';?>checkAttribute",
                          	type: "post",
 							data: {  product_id: $( "#product_id" ).val() }

                    	 } */
				} 
		},
		messages: {
			attribute: {
					required: "Please enter attribute"/*,
					remote: "This attribute already exists!" */
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
						$(".show_loader").click();
				},
				url: "<?php echo base_url(); ?>attribute/saveData/",
				data: {form_data:dataSend},
				async: true,				
				success: function (msg) {
					if(typeof $("#menu_id")!==''){
						window.location.href="<?php echo base_url(); ?>attribute/listing/";						
					}
				},
				complete: function(){
					$(".show_loader").hide();
				}
			});
 		}
	});
});
<!------------------------ Validate Fom----------------------------->
	// Creating Url
	 function Url(val){}
	
	function load_listing_data(){
		$.ajax({
			type: "POST",
			beforeSend: function(){
					$('#listingData').val('generating url..');
 			},
			url: "<?php echo base_url(); ?>myspidey_user_group_permissions/getListingData/",
			dataType:"text",
			data: {urlName:val},
			async: true,				
			success: function (msg) {  
				$("#listingData").val(msg);

			} 
		});
	}
                        
                        </script>
<?php $this->load->view('../includes/admin_footer');?>
