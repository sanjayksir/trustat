<div class="wide-container gray-bg">
    <div class="container padding-top-20 padding-bottom-30">
        <footer>
            <div class="left-footer flt">
            
                <ul class="social-icons">
                    <li><a href="<?php echo FACEBOOK_PAGE; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo INSTAGRAM_PAGE; ?>" title="Instagram" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo TWITTER_PAGE; ?>" title="Twitter" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo YOUTUBE_CHANNEL; ?>" title="Youtube" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                </ul>
                
                <div class="clearfix"></div>
                
                <ul class="footer-left-quick-link">
                    <li><a href="<?php echo base_url();?>city-news/delhi" title="Delhi News">Delhi News</a></li>
                    <li><a href="<?php echo base_url();?>city-news/faridabad" title="Faridabad News">Faridabad News</a></li>
                    <li><a href="<?php echo base_url();?>city-news/ghaziabad" title="Ghaziabad">Ghaziabad News</a></li>
                    <li><a href="<?php echo base_url();?>city-news/gurugram" title="Gurugram News">Gurugram News</a></li>
                    <li><a href="<?php echo base_url();?>city-news/noida" title="Noida News"></a></li>
                </ul>

                <div class="clearfix"></div>
                
                <div class="subscribe">
                    <p>Get news deliverd to your inbox:</p>
                    
                    <?php echo form_open( base_url('subscription/subscribe_newsletter'), array('id' => 'newsletter_form', 'role' => 'form' ) ); ?>
                        <div class="sub-sec">
                            <input type="email" name="subscriber_email" placeholder="Your Email" />
                            <input type="submit" name="submit" value="Submit">
                        </div>
                        <label id="subscriber_email-error" class="error"></label>
                    </form>
                </div>
                
            </div>
            
            <div class="right-footer flr">
            
                <div class="bottom-ads">
                    <img src="<?php echo ASSETS_PATH;?>sb-images/top-ads.png"  alt="Advertisment" title="Advertisement" />
                </div>
                <div class="clearfix"></div>
                <ul class="footer-right-quick-link">
                    <li><a href="<?php echo base_url();?>cms/about-spidey-buzz" title="About Spidey Buzz">About Spidey Buzz</a></li>
                    <li><a href="<?php echo base_url();?>cms/career" title="Career">Career</a></li>
                    <li><a href="<?php echo base_url();?>cms/become-citizen-journalist" title="Become a Citizen Journalist">Become a Citizen Journalist</a></li>
                    <li><a href="<?php echo base_url();?>cms/advertise-with-us" title="Advertise with us">Advertise with us</a></li>
                </ul>
                <div class="clearfix"></div>
                <ul class="footer-bottom-quick-link">
                    <li><a href="<?php echo base_url();?>cms/privacy-policy" title="Privacy">Privacy</a>/</li>
                    <li><a href="<?php echo base_url();?>cms/terms-conditions" title="Terms & Conditions">Terms & Conditions</a>/</li>
                    <li><a href="<?php echo base_url();?>cms/feedback" title="Feedback">Feedback</a>/</li>
                    <li><a href="<?php echo base_url();?>cms/contact" title="Contact">Contact</a></li>
                </ul>
                
            </div>
        
        </footer>
    </div>
</div>


<div class="goToTop">
    <span class="goToTopIcon">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </span>
</div>

<?php $this->load->view("../includes/sb_footer_scripts");?>

<script type="text/javascript">
$(document).ready(function(){
    $.validator.addMethod("validateEmail", function(value, element) {
      return this.optional(element) || /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/.test(value) || /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/.test(value);
    }, "Invalid email");

    $("#newsletter_form").validate({
        rules: {
            subscriber_email: {
                required: true,
                validateEmail: true
            },
        },
        messages: {
            subscriber_email: {
                required: "Please enter a valid email address",
                email: "Invalid email",
            },
        },
        
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('subscription/subscribe_newsletter'); ?>",
                data: $("#newsletter_form").serialize(),
                success: function ( result ) { 
                    if( result ) {
                        $("#subscriber_email-error").text(result);
                        $("#subscriber_email-error").css('display','block');
                    }
                },
                complete: function(){
                    $('#newsletter_form')[0].reset();
                }
            });
            return false;
        }
    });
});
</script>

</body>
</html>