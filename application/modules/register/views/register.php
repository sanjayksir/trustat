<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('../includes/sb_header');?>
<?php $this->load->view('../includes/sb_top_navigation');?>
<style>
.btn-file {
	position: relative;
	overflow: hidden;
}
.btn-file input[type=file] {
	position: absolute;
	top: 0;
	right: 0;
	min-width: 100%;
	min-height: 100%;
	font-size: 100px;
	text-align: right;
	filter: alpha(opacity=0);
	opacity: 0;
	outline: none;
	background: white;
	cursor: inherit;
	display: block;
}
#img-upload {
	width: 70%;
	border-radius: 10px;
	margin-top: 10px;
}
</style>
<script>
$(document).ready( function() {
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
		    
		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;
		    
		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }
	    
		});
		
	});
</script>

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
      <form name="addform" id="addform" action="<?php echo base_url('register/edit');?>" method="post" enctype="multipart/form-data" >
      
        <div class="row">
          <div class="col-md-8">
		  <?php $msg=''; $msg= $this->session->flashdata('msg');if($msg){?>
		   <div class="row">
              <div class="col-sm-10 form-group">
                <div class="alert alert-success">
		  <?php echo $msg;?>
          </div>
              </div>
		  </div><?php }?>
            <div class="row">
              <div class="col-sm-10 form-group">
                <label>First name</label>
                <input type="text" name="first_name" id="first_name" maxlength="50" class="form-control" value="<?php echo $reg[0]['first_name']; ?>" >
              </div>
            </div>
			<div class="row">
              <div class="col-sm-10 form-group">
                <label>Last name</label>
                <input type="text" name="last_name" id="last_name" maxlength="50" class="form-control" value="<?php echo $reg[0]['last_name']; ?>" >
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10 form-group">
                <label>Email</label>
                <input type="text" name="email" id="email" maxlength="50" class="form-control" value="<?php if($reg[0]['login_from']=='email')echo $reg[0]['user_email_phone']; ?>" <?php if($reg[0]['login_from']=='email')echo"readonly";?> >
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10 form-group">
                <label>Phone</label>
                <input type="text" name="phone" id="phone" maxlength="10" class="form-control" value="<?php if($reg[0]['login_from']=='phone'){ echo $reg[0]['user_email_phone']; }else{ echo $reg[0]['contact'];} ?>" <?php if($reg[0]['login_from']=='phone')echo"readonly";?> >
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10 form-group">
                <label>Country</label>
                <select name="country_id"  id="state_id" class="form-control">
                  <option value=""> Select </option>
                  <option value="1" <?php if($reg[0]['country']==1)echo'selected';?>>India</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10 form-group">
                <label>State</label>
                <select name="state_id"  id="state_id" class="form-control"  onchange="javascript:getcity(this.value);">
				 <option value=""> Select </option>
                  <?php $get_states = get_states();foreach($get_states as $state){?>
                  <option value="<?php echo $state['state_id'];?>" <?php if($reg[0]['state']==$state['state_id'])echo'selected';?>><?php echo $state['state_name'];?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10 form-group">
                <label>City</label>
                <select name="city_id" id="city_id"  class="form-control"  onchange="javascript:getarea(this.value);">
				<?php if($reg[0]['city']){?>
				<option value="<?php echo $reg[0]['city'];?>" selected><?php $city=get_cities($reg[0]['city']);echo $city['city_name'];?> </option>
				<?php }else{?>
                  <option value=""> Select </option>
				<?php }?>
                  <?php foreach($cites as $city){?>
                  <option value="<?php echo $city['city_id'];?>" ><?php echo $city['city_name'];?></option>
                  <?php }?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="form-group">
                <label>Upload Image</label>
                <div class="input-group"> <span class="input-group-btn"> <span class="btn btn-default btn-file"> Browse…
                  <input type="file" id="imgInp" name="picture" id="picture">
                  </span> </span>
                  <input type="text" class="form-control" readonly>
                </div>
                <img id='img-upload' src="<?php if($reg[0]['profile_pick']){ echo $reg[0]['profile_pick'];}else{ echo base_url().'/uploads/no-image-big.png';}?>"/>
                <input type="hidden" name="profile_pick" value="<?php echo $reg[0]['profile_pick'];?>">				</div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-3 center submit-sec-btn"> <br>
		    <input type="hidden" name="user_id" value="<?php echo $reg[0]['user_id']; ?>">
			 <input type="hidden" name="from" value="<?php echo $reg[0]['login_from']; ?>">
            <input type="submit" name="add" id="add"  value="Submit" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php echo $this->load->view('../includes/sb_footer');?> 
<script>

 $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\ \n]+$/i.test(value);
    }, "Username must contain only letters, numbers, or dashes.");					
$("form#addform").validate({
 
			rules: {
				uname: {required:true
				},
				email: {email:true,
				},
				phone: {number:true,minlength:10,maxlength:10,
				},
				
				
			},
			messages: {
				//uname: "",
				//email:"",
				//phone:"",
				
			}
		});
function getcity(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>register/city/"+id,
            data: 'state_id=' + id,
            success: function (result) {
				
                $("#city_id").html(result);
            }
        });
    }
	
</script>