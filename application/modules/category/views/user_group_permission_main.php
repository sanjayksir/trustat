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

          <li class="active">Administration</li><li class="active">Manage Industry</li>

        </ul>

        <!-- /.breadcrumb -->

        

         

        <!-- /.nav-search --> 

      </div>

      <div class="page-content">
			<!--------------- Search Tab start----------------->
                            <div class="row"><div class="col-xs-12"><form id="form-filter" action="" method="post" class="form-horizontal" onsubmit="return validateSrch();">
                                <table id="search">
                                    
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
                           </div> </div>
                      <!--------------- Search Tab start----------------->
        <div class="row">

          <div class="col-xs-12">
			
            <div class="row">
			
              <div class="col-xs-12">

                <h3 class="header smaller lighter blue">Manage Industry</h3>
				
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

						if($this->uri->segment(2)=='get_edit_section'){

                      	 $this->load->view('edit_section');

                      }else{

						  	 $this->load->view('add_section');

					  }?>

                      </div>

                      <?php if($this->uri->segment(2)!='get_edit_section'){?>

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
function validateSrch(){
	$("#searchStr").removeClass('error');
	var val = $("#searchStr").val();
 	if(val.trim()==''){
		$("#searchStr").addClass('error');
		return false;
	}
}	
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

			category: {

					required: true

				} 

		},

		messages: {

			category: {

					required: "Please enter category"

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

				url: "<?php echo base_url(); ?>category/saveData/",

				data: {form_data:dataSend},

				async: true,				

				success: function (msg) {
					if(msg==0){
 							alert("Record Already Exists!");
							return false;
					}else{
						window.location.href="<?php echo base_url(); ?>category/listing/";	
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

