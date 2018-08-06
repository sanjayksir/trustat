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
				<?php  $constant = "Assign Plant to Plant Controller" ;?>
          <li class="active">Administration</li><li class="active"><?php echo $constant;?></li>

        </ul>

        <!-- /.breadcrumb -->

        

        

        <!-- /.nav-search --> 

      </div>

      <div class="page-content">

        <div class="row">

          <div class="col-xs-12">

            <div class="row">

              <div class="col-xs-12">

                <h3 class="header smaller lighter blue"><?php echo $constant;?></h3>

                 <?php if($this->session->flashdata('success')): ?>

                <div class="alert alert-block alert-success">

                  <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>

                  <i class="ace-icon fa fa-check green"></i> <span id="msgSucc"></span><?php echo $this->session->flashdata('success'); ?> </div>

                <?php endif; ?>

                

                <!--<div class="table-header">

											Results for "Locations"

										</div>--><br>

                <div class="row">

                  <div class="col-xs-12">

                    

                    <!--left end---->

                    <div style="clear:both;height:40px;"><a href="<?php echo base_url()?>plant_master/list_assigned_plants_user" class="btn btn-primary pull-right" title="List Assign Plant to Plant Controllers">List Assign Plant to Plant Controllers</a></div>

                    <div class="col-xs-12">

                      <div class="tab-pane fade active in">

                        <?php //$this->load->view('add_menu_form_tpl');?>

                        <div class="row">

                          <div class="col-xs-12">

                            <div class="row" id="add_edit_div">

                             <div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">Assign Plant to Plant Controller</h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>
<?php 
$user_id 	= $this->session->userdata('admin_user_id');//echo '<pre>';print_r($this->session->userdata('admin_user_id'));

if( $this->uri->segment(3)!=''){
	$user_id=	$this->uri->segment(3);
	$UserData = get_parent_user($user_id,'1'); 
	$SelectDD='';
}else{
	$SelectDD='1';
	$UserData = get_active_users($user_id,'1');
}
   //echo '<pre>';print_r($UserData) ;

//echo '<pre>';print_r($UserData);?>
      <form name="user_frm" id="user_frm" action="#" method="POST" onsubmit="return saved_assigned_data();">
<input type="hidden" name="is_edit" value="<?php echo ($this->uri->segment(3))?1:0;?>" />
        <div class="widget-main">
		 
		<div class="form-group row">
			<div class="col-sm-4">
			<label for="form-field-8">Select CCC admin User</label>
            <select class="form-control" name="user" id="user" onchange="return get_plants_controller(this.value),get_plants(this.value);">
			<?php if($SelectDD!=''){?><option value="">-Select Plant Controller-</option>
            <?php }
 			//$plant_data = get_all_plants($user_id);
 			foreach($UserData as $res){?>
            <option value="<?php echo $res['user_id'];?>" <?php if($this->uri->segment(3)==$res['user_id']){echo 'selected';}?>><?php echo ucfirst($res['user_name']);?></option>
 			<?php }?>
            </select> 
			</div>
			
			<!--------------------------------- Plant Controller DD ------------------------ -->
			<div class="col-sm-4">
                <label for="form-field-8">Select Plant Controller User</label>
                <select class="form-control" name="plant_controller_val" id="plant_controller_val">
                    <option value="">Select Plant Controller</option>
                </select> 
			</div>
			<!--------------------------------- Plant Controller DD ------------------------ -->
			
			
			
			
			
			<div class="col-sm-4">
			  <label for="form-field-8">Select Plant(Press Ctrl to Select Multiple plants)</label>
             <select class="form-control" name="plants[]" id="plants" multiple="multiple" >
             
             </select>
			</div>
		</div>
		 
		 <script>
		 function get_plants(id){
		 	if(id!=''){
				$.ajax({
				type:'POST',
				url:'<?php echo base_url().'plant_master/getActivePlantList'?>',
				data:{id:id,  ccadminId: $('#user').val()},
				success:function(msg){
					$("#plants").html(msg);
				}
				})
		 	}
		 }
             
             
        
        function get_plants_controller(id){
            $('#plants').find('option').remove().end().append('<option value="0"></option>');
		 	if(id!=''){
				$.ajax({
				type:'POST',
				url:'<?php echo base_url().'plant_master/getActivePlantControllerList'?>',
				data:{id:id},
				success:function(msg){
					$("#plant_controller_val").html(msg);
				}
				})
		 	}
		 }     
             
             
		 </script>
		 <?php if(!empty($this->uri->segment(3))){?>
		 <script>get_plants(<?php echo $this->uri->segment(3);?>);</script>
		 <?php }?>
 		 
            <hr>

          <div class="clearfix form-actions" style="background-color:white;border-top: none;padding:0px;">

            <input class="btn btn-info" type="submit" name="submit" value="Assign" id="savemenu" />

          </div>
          

        </div>

      </form>

    </div>

  </div>

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
function saved_assigned_data(){ 
var formData;
var dataSend 	= $("#user_frm").serialize();
$.ajax({
		type: "POST",
		dataType:"json",
		beforeSend: function(){
				$(".show_loader").show();
				$(".show_loader").click();
		},
		url: "<?php echo base_url(); ?>plant_master/save_assign_user_to_pant/",
		data: dataSend,
		success: function (msg) { 
			if(parseInt(msg)==1){
				$('#ajax_msg').text("Plant Assigned Successfully!").css("color","green").show();
				$('#blah').attr('src', '').hide();
				$('#user_frm')[0].reset(); 
				  window.location.href="<?php echo base_url(); ?>plant_master//list_assigned_plants_user";						
			}
			 
		},
		complete: function(){
			$(".show_loader").hide();
		}
	});
	return false;
}

 
 

 </script>

<?php $this->load->view('../includes/admin_footer');?>

