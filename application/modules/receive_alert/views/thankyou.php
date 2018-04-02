<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('../includes/sb_header');?>
<?php $this->load->view('../includes/sb_top_navigation');?>

<div class="wide-container">
  <div class="container padding-top-30 padding-bottom-3">
    <div class="left-container flt">
      <h1 class="heading flt">Thank you!</h1>
    </div>
  </div>
</div>
<div class="wide-container">
  <div class="container padding-bottom-30">
    <div class="around-story-container">
      <div class="row">
        <div class="col-md-12">
		      <div class="terms-condition">
            <h3><?php echo $success; ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view('../includes/sb_footer');?>