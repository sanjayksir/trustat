<?php $this->load->view('../includes/admin_header'); ?>
<?php $this->load->view('../includes/admin_top_navigation'); //echo $this->session->userdata('user_name');?>

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
    <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home </a> </li>
    <li> <a href="#">Editorial</a> </li>
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
        <h3 class="header smaller lighter blue">Pitching Story Idea</h3>
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-block alert-success">
          <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>
          <i class="ace-icon fa fa-check green"></i> <span id="msgSucc"></span><?php echo $this->session->flashdata('success'); ?> </div>
        <?php endif; ?>
        <div class="row">
          <div class="col-xs-6"> <div class="pull-left"><a href="<?php echo base_url().'Buzzadmn/Editorial/addStoryIdea';?>" class="btn btn-primary pull-right btn-sm">ADD STORY IDEA</a> </div> </div>
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
					foreach($listData as $k=>$val){
						$i++;
				?>
              <tr>
                <td><?php echo $i;?></td>
                <td width="70%"><?php echo $val['title'];?> - <b>Eta:</b> <?php echo $val['eta'];?></td>
                <td><?php echo $val['user_name'];?></td>
                <td><?php echo date('d M, Y',strtotime($val['created_on']));?></td>
                <td><div class="hidden-sm hidden-xs btn-group"> <a href="<?php echo base_url();?>Buzzadmn/Editorial/editStoryIdea/<?php echo $val['id'];?>" title="Edit Idea" class="btn btn-xs btn-warning" ><i class="ace-icon fa fa-pencil bigger-120 tooltip-success" data-rel="tooltip" ></i> </a> <a onclick="return deleteConfirm();" href="<?php echo base_url();?>Buzzadmn/Editorial/deleteStoryIdea/<?php echo $val['id'];?>" title="Delete Idea" class="btn btn-xs btn-danger" ><i class="ace-icon fa fa-times red2 bigger-120 tooltip-success" data-rel="tooltip"></i></a>
                    <button class="btn btn-xs btn-warning" title="Send Details"><i class="ace-icon fa fa-envelope bigger-120 tooltip-success" data-rel="tooltip"></i> </button>
                  </div></td>
              </tr>
              <?php 			}
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
function deleteConfirm() {
    if (confirm("Are you sure?")) {
        return true;// your deletion code
    }
    return false;
}


$('.date-picker').datepicker({
		autoclose: true,
		todayHighlight: true,
		format: 'yyyy/mm/dd'
	})
</script>