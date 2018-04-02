<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('../includes/sb_header');?>
<?php $this->load->view('../includes/sb_top_navigation');?>

<div class="wide-container">
  <div class="container padding-top-30 padding-bottom-3">
    <div class="left-container flt">
      <h1 class="heading flt">Don't want the Buzz in your inbox any more? <span style="color:#fab400;">&#9785;<span></h1>
      <h3>Please let us know why so we can improve our service.</h3>
    </div>
  </div>
</div>
<div class="wide-container">
  <div class="container padding-bottom-30">
    <div class="around-story-container">
      <div class="row">
        <div class="col-md-12">
		      <div class="terms-condition">
            <form name="unsubscribe_form" id="unsubscribe_form" action="<?php echo base_url('receive_alert/unsubscribe_alert');?>" method="post">
              <div class="row">
                <div class="col-md-8">
                  
                  <div class="row green" id="success_msg" style="display: none;"></div>

                  <div class="row">
                    <div class="col-sm-10 form-group">
                      <label>Email</label>
                      <input type="email" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>"> 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-10 form-group">
                      <input type="radio" name="reason" id="reason_1" value="Do not like the content"> 
                      <label>Do not like the content</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-10 form-group">
                      <input type="radio" name="reason" id="reason_2" value="It is spamming in my inbox"> 
                      <label>It is spamming in my inbox</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-10 form-group">
                      <input type="radio" name="reason" id="reason_3" value="I subscribed by mistake"> 
                      <label>I subscribed by mistake</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-10 form-group">
                      <input type="radio" name="reason" id="reason_4" value="Any other reason"> 
                      <label>Any other reason</label>
                    </div>
                  </div>

                  <label id="reason-error" class="error" for="reason"></label>

                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-3 center submit-sec-btn">
                  <input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id[0]; ?>">
                  <input type="submit" name="unsubscribe" id="unsubscribe" value="Submit" />
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view('../includes/sb_footer');?>
<script type="text/javascript">
$(document).ready(function(){
  $.validator.addMethod("validateEmail", function(value, element) {
    return this.optional(element) || /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/.test(value) || /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/.test(value);
  }, "Invalid email");

  $("#unsubscribe_form").validate({
      rules: {
          reason: {
            required: true,
          },
          email: {
            required: true,
            validateEmail: true
          },
      },
      messages: {
          reason: {
            required: "Please choose a reason.",
          },
          email: {
            required: "Please enter a valid email address",
            email: "Invalid email!",
          },
      },
      
      submitHandler: function(form) {
          $.ajax({
              type: "POST",
              url: "<?php echo base_url('receive_alert/unsubscribe_alert'); ?>",
              data: $("#unsubscribe_form").serialize(),
              success: function ( result ) {
                $("#success_msg").text(result);
                $("#success_msg").css('display', 'block');
              },
              complete: function(){
                  $('#unsubscribe_form')[0].reset();
                  location.href = "<?php echo base_url('receive_alert/thankyou'); ?>";
              }
          });
          return false;
      }
  });
});
</script>