<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); //echo $this->session->userdata('user_name');?>
 <script src="<?php echo base_url().'assets/jquery-alert/';?>dist/sweetalert-dev.js"></script>
 <link rel="stylesheet" href="<?php echo base_url().'assets/jquery-alert/';?>dist/sweetalert.css">
 
 <!-- Popup start -->

 <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/stylish_popup/';?>css/component.css" />
 
<?php 
$allow_permission_arr   = array();
$allow_permission     = array();
$allow_permission_arr   = menu_permissions_login($this->session->userdata('user_id'),$this->session->userdata('usergroup_id'));

//echo '<pre>';print_r($allow_permission_arr['show_hide_chks']);exit;
$assign_permission      = explode(',',$allow_permission_arr['show_hide_chks']);
?>
 
<script src="<?php echo base_url().'assets/stylish_popup/';?>js/modernizr.custom.js"></script>
 <!-- Popup start - -->
<div class="main-container ace-save-state" id="main-container">
<script type="text/javascript">
        try {
            ace.settings.loadState('main-container')
        } catch (e) {
        }
    </script>
    
    
<?php $this->load->view('../includes/admin_sidebar'); 
  if(count($srchData)>0){
    $srchData = $srchData;
  }
?>
<div class="main-content">
<div class="main-content-inner">
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
  <ul class="breadcrumb">
    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo base_url('buzzadmn'); ?>">Home </a> </li>
    <li> <a href="<?php echo base_url('buzzadmn'); ?>">Editorial</a> </li>
    <li class="active">Pitching Story Idea</li>
  </ul>
  <!-- /.breadcrumb -->
  
  <div class="nav-search" id="nav-search"> </div>
  <!-- /.nav-search --> 
</div>
<div class="page-content">
<div class="row">
  <div class="col-xs-12">
    <div class="row">
      <div class="col-xs-12">
      <a href="<?php echo base_url().'buzzadmn/editorial/manage'; ?>" class="btn btn-info btn btn-primary pull-right btn-sm">Reporters Story List</a>
        <h3 class="header smaller lighter blue">Pitching Story Idea</h3>
        
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-block alert-success">
          <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>
          <i class="ace-icon fa fa-check green"></i> <span id="msgSucc"></span><?php echo $this->session->flashdata('success'); ?> </div>
        <?php endif; ?>

        <div style="display:none;" class="alert alert-block alert-success" id="ajax_msg"></div>
        <div class="row">
        
          <div class="col-xs-6">&nbsp;</div>
          <div class="col-xs-6">
            <div class="input-group input-group-sm top-right-gap pull-right" >
              <form class="form-search" method="post" name="frm_search" id="frm_search" action="">
                <div class="pull-left"> <span class="input-icon">
                  <input type="text" placeholder="Search ..." class="nav-search-input srch" id="search" name="search" autocomplete="off" value="<?php echo $this->input->post('search'); ?>"  />
                  <span id="dateCalculate" style="display:none;">
                  <input type="text" placeholder="From Date" class="nav-search-input srch date-picker"  data-date-format="dd/mm/yyyy" id="fromdate" name="fromdate" autocomplete="off" value="<?php echo $this->input->post('search'); ?>"  />
                  <input type="text" placeholder="To Date"  class="nav-search-input srch date-picker" id="todate" name="todate" autocomplete="off" value="<?php echo $this->input->post('search'); ?>"  />
                  </span> </span> </div>
                <div class="pull-left" style="margin:0 3px;">
                  <select class="form-search form-control" name="srchDD" id="srchDD" onchange="return changeSrchOpt(this.value);">
                    <option value="1">By Keyword</option>
                    <option value="2">By Date</option>
                  </select>
                </div>
                <div class="pull-left">
                  <button type="submit" class="btn btn-success btn-sm"> <i class="ace-icon fa fa-search nav-search-icon" ></i> </button>
                </div>
              </form>
            </div> 
            
          </div>
        </div>
        <div class="space-4"></div>
        <div class="row"> 
           <div class="col-xs-12">
          <!-- div.table-responsive --> 
          <!-- div.dataTables_borderWrap -->
          <table class="table table-striped table-bordered table-hover display">
            <thead>
              <tr>
                <th>Sr.no</th>
                <th>Pitching Story Idea</th>
                <th>Submited By</th>
                <th>Created Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php //print_r($listData);exit;
        if(count($listData)>0){
          $i=0;
          //print_r($listData);
          foreach($listData as $k=>$val){
            $i++;
                 $idea_details = get_story_idea_detail($val['buzz_story_id']);
          ?>
              <tr>
                <td><?php echo $i;?></td>
                <td width="70%"><?php echo $val['title'];?> - <b>Eta:</b> <?php echo $val['eta'];?></td>
                <td><?php echo $val['user_name'];?></td>
                <td><?php echo date('d M, Y',strtotime($val['created_on']));?></td>
                <td width="15%">
                  <div class="hidden-sm hidden-xs btn-group"> 
                    <button id="approve_<?php echo $val['buzz_story_id']; ?>" class="btn-xs btn btn-success md-trigger" data-toggle="tooltip" title="<?php echo ($val['editor_action'] == 1) ? 'Approved' : 'Approve'; ?>" onclick="approveBuzzStory('<?php echo $val['buzz_story_id'];?>');" <?php echo ($val['editor_action'] == 1) ? "disabled" : ""; ?>><?php echo ($val['editor_action'] == 1) ? 'Approved' : 'Approve'; ?></button>
                    <button id="reject_<?php echo $val['buzz_story_id']; ?>" class="btn-xs btn btn-danger md-trigger" data-toggle="tooltip" title="<?php echo ($val['editor_action'] == 2) ? 'Rejected' : 'Reject'; ?>" onclick="rejectBuzzStory('<?php echo $val['buzz_story_id'];?>');" <?php echo ($val['editor_action'] == 2) ? 'disabled' : ""; ?>><?php echo ($val['editor_action'] == 2) ? 'Rejected' : 'Reject'; ?></button>
                    <!-- <a href="<?php echo base_url();?>buzzadmn/editorial/editBuzzStoryDetail/<?php echo $val['id'];?>"  data-toggle="tooltip" title="Edit Buzz Story" class="btn btn-xs btn-warning" ><i class="ace-icon fa fa-pencil bigger-120 tooltip-success" data-rel="tooltip" ></i> </a> -->
                  </div>
                </td>
              </tr>
              <?php       }
            }else{?>
              <tr>
                <td>1</td>
                <td width="100%" colspan="5"><span style="color:red;">No Record Found</span></td>
              </tr>
              <?php }?>
            </tbody>
          </table> <div class="space-10"></div><div class="space-10"></div>
           <form class="form-search" method="post" name="frm_search_pagination" id="frm_search_pagination" action="">
           <input type="hidden" name="hid_DD" value="<?php echo $this->input->post('srchDD');?>" />
           <input type="hidden" name="search" value="<?php echo $this->input->post('search');?>"/>
           <input type="hidden" name="fromdate" value="<?php echo $this->input->post('fromdate');?>" />
           <input type="hidden" name="todate" value="<?php echo $this->input->post('todate');?>"/>
           <p><?php echo $links; ?></p>
          </form>
          <?php //echo $this->pagination->create_links(); ?>
          <!-- PAGE CONTENT ENDS --> 
          
          <div class="space-10"></div>
          
        </div>
        <!-- /.col --> 
      </div>
      </div>
      <!-- /.row --> 
    </div>
    <!-- /.page-content --> 
  </div>
  <?php $this->load->view('../includes/admin_footer_top');?>
</div>
<!-- /.main-container -->

<?php $this->load->view('../includes/admin_footer');?>

<script>
  
function searchFrm(){
  if($("#search").val()!=''){
    $('#frm_search').submit();return false; 
  }else{ 
    return false;
  }
}

function changeSrchOpt(val){
  if(val==2){
    $('#search').hide();
    $('#dateCalculate').show();   
  }else{
    $('#search').show();
    $('#dateCalculate').hide(); 
  }
}

$('.date-picker').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'yyyy/mm/dd'
});
 
 // Arrove Buzz Story action
 function approveBuzzStory(story_id) {
    $.ajax({
      type: "POST",
      dataType:"json",
      url: "<?php echo base_url();?>buzzadmn/editorial/approve_buzz_story",
      beforeSend: function(){
        $('#approve_'+story_id).attr('disabled', true);
      },
      data: {"story_id":story_id },
      success: function (msg) {
        if(parseInt(msg)==1){
          $('#ajax_msg').text("The story has been approved successfully!").css("color","green").show();
        }
      },
      complete: function(){
        $('#approve_'+story_id).attr('disabled', true);
        $('#approve_'+story_id).attr('value', 'Approved').attr('title', 'Approved').text('Approved');
        $('#reject_'+story_id).attr('value', 'Reject').attr('title', 'Reject').text('Reject');
        $('#reject_'+story_id).attr('disabled', false);
      } 
    });
 }

 // Reject Buzz Story action
 function rejectBuzzStory( story_id ) {
    $.ajax({
      type: "POST",
      dataType:"json",
      beforeSend: function(){
        $('#reject_'+story_id).attr('disabled', true);
      },
      url: "<?php echo base_url();?>buzzadmn/editorial/reject_buzz_story",
      data: {"story_id":story_id },
      success: function (msg) {
        if(parseInt(msg)==2){
          $('#ajax_msg').text("The story has been rejected successfully!").css("color","green").show();
        }
      },
      complete: function(){
        $('#reject_'+story_id).attr('disabled', true);
        $('#reject_'+story_id).attr('value', 'Rejected').attr('title', 'Rejected').text('Rejected');
        $('#approve_'+story_id).attr('value', 'Approve').attr('title', 'Approve').text('Approve');
        $('#approve_'+story_id).attr('disabled', false);
      }
    });
 }
 
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<!-- pop up start -->
<script src="<?php echo base_url().'assets/stylish_popup/';?>js/classie.js"></script>
<script src="<?php echo base_url().'assets/stylish_popup/';?>js/modalEffects.js"></script>
<!-- pop up End -->