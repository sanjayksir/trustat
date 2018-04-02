<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('../includes/sb_header');?>
<?php $this->load->view('../includes/sb_top_navigation');?>

<div class="wide-container">
  <div class="container padding-top-30 padding-bottom-3">
    <div class="left-container flt">
      <h1 class="heading flt">Edit Profile</h1>
    </div>
  </div>
</div>
<div class="wide-container">
<div class="container padding-bottom-30">
<div class="around-story-container">
<form name="addform" id="addform" action="<?php echo base_url('register');?>" method="post" >
<div class="form-group row">
  <div class="col-sm-12">
    <div class="alert alert-success">
      Thanks for submitting the form.
    </div>
  </div>
</div>
</div>
</div>
</div>


<?php echo $this->load->view('../includes/sb_footer');?> 