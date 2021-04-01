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
				<?php  $constant = "Assign Functionalities to Role" ;?>
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

                    <div style="clear:both;height:40px;"><a href="<?php echo base_url()?>role_master/list_assigned_functionalities_to_role/<?php echo $this->uri->segment(3); ?>" class="btn btn-primary pull-right" title="List Assigned Functionalities to Role">List Assigned Functionalities to Role</a></div>

                    <div class="col-xs-12">

                      <div class="tab-pane fade active in">

                        <?php //$this->load->view('add_menu_form_tpl');?>

                        <div class="row">

                          <div class="col-xs-12">

                            <div class="row" id="add_edit_div">

                             <div class="col-xs-12">

  <div class="widget-box">

    <div class="widget-header">

      <h4 class="widget-title">KKAssign Functionalities to Role <?php //echo $this->uri->segment(3); ?></h4>

      <div class="widget-toolbar"> <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a> <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a> <a href="#" class="show_loader"  data-action="reload" style="display:none;"><i class="ace-icon fa fa-refresh"></i></a> </div>

    </div>

    <div class="widget-body">

    <div id="ajax_msg"></div>

      </div>
<?php 

$user_id 	= $this->session->userdata('admin_user_id');//echo '<pre>';print_r($this->session->userdata('admin_user_id'));

if( $this->uri->segment(4)!=''){
	$user_id=	$this->uri->segment(4);
	$UserData = get_parent_user($user_id,'1'); 
	$SelectDD='';
}else{
	$SelectDD='1';
	$UserData = get_active_users($user_id,'1');
}
   //echo '<pre>';print_r($UserData) ;
$ActiveRoles = get_active_roles($user_id,'1');
//echo '<pre>';print_r($UserData);?>
      <form name="user_frm" id="user_frm" action="#" method="POST" onsubmit="return saved_assigned_data();">
<input type="hidden" name="is_edit" value="<?php echo ($this->uri->segment(4))?1:0;?>" />
<input type="hidden" name="customer_idF" value="<?php echo $this->uri->segment(3); ?>" />
        <div class="widget-main">
		 
		<div class="form-group row">
			<div class="col-sm-6">
			<label for="form-field-8">Select Role from the list</label>
            <select class="form-control" name="role" id="role" onchange="return created_users_for_the_role(this.value), get_functionalities(this.value);">
			<?php if($SelectDD!=''){?><option value="">-Select a Role-</option>
            <?php }
 			//$plant_data = get_all_plants($user_id);
 			foreach($ActiveRoles as $res){?>
            <option value="<?php echo $res['id'];?>" <?php if($this->uri->segment(4)==$res['id']){echo 'selected';}?>><?php echo ucfirst($res['role_name_value']);?></option>
 			<?php }?>
            </select>
			<!--
			<br /><br />
			<label for="form-field-8">How many users you need of this Role?</label><br />
			
			<div id="role_quantity"></div>
			-->
			</div>
			
			<div class="col-sm-6">
			  <label for="form-field-8">Select Functionality(Press Ctrl to Select Multiple Functionalities)</label>
            <select class="form-control" name="functionalities[]" id="functionalities" multiple="multiple" size="11">
             
             </select>
			</div>
		</div>
		 
		 <script>
		 function get_functionalities(id){
		 	if(id!=''){
				$.ajax({
				type:'POST',
				url:'<?php echo base_url().'role_master/getActiveFunctionalitiestList'?>',
				data:{id:id, customer_id:<?php echo $this->uri->segment(3); ?>},
				success:function(msg){
					$("#functionalities").html(msg);
				}
				})
		 	}
		 }
		 
		 function created_users_for_the_role(id){
		 	if(id!=''){
				$.ajax({
				type:'POST',
				url:'<?php echo base_url().'role_master/get_created_users_for_the_rolejs'?>',
				data:{id:id},
				success:function(msg){
					$("#role_quantity").html(msg);
				}
				})
		 	}
		 }
		 
		 </script>
		 <?php if(!empty($this->uri->segment(4))){?>
		 <script>get_functionalities(<?php echo $this->uri->segment(4);?>);</script>
		  <script>created_users_for_the_role(<?php echo $this->uri->segment(4);?>);</script>
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
		url: "<?php echo base_url(); ?>role_master/save_assigned_functionalities_to_role/",
		data: dataSend,
		success: function (msg) { 
			if(parseInt(msg)==1){
				$('#ajax_msg').text("Functionalities Assigned Successfully!").css("color","green").show();
				$('#blah').attr('src', '').hide();
				$('#user_frm')[0].reset(); 
				 window.location.href="<?php echo base_url(); ?>role_master/list_assigned_functionalities_to_role/<?php echo $this->uri->segment(3); ?>";						
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

