<body>
<?php $user_id = $this->session->userdata('user_id');
if(empty($user_id)&& !$this->input->post("add"))$fdata=facebook_data();$tdata=twitter_data();$gdata=google_data();

if(!empty($user_id)){
           $this->load->helper('common_functions_helper');
		   $user_data =array();
           $user_data  =  get_user($user_id);
		  
}
// print_r($_SESSION);
?>

<div class="wide-container gray-bg">
    <div class="container">
        <header>
            <div class="logo flt"><a href="<?php echo base_url(); ?>"  title="Tracek Portal" ><img src="<?php echo ASSETS_PATH;?>sb-images/spidey-buzz.png" alt="Tracek Portal" title="Tracek Portal" /></a></div>
            <div class="top-ads flt">
                <span>Advertisement</span>
                <img src="<?php echo ASSETS_PATH;?>sb-images/top-ads.png" width="728" height="90" title="Advertisement" alt="Advertisement"/>
            </div>
            <div class="flr top-profile-sec">
             
            <!--before end login-->
              
              
             
             <!--after login-->
             
             <div class="flt">
               <?php  if(!empty($user_id)){?> <div class="user-name"><?php echo $user_data[0]['first_name'].' '. $user_data[0]['last_name'];?> </div><?php }?>
                <div class="top-icon">
                <?php if(empty($user_id)){?>
                <div class="login-profile-pic"><img src="<?php echo base_url();?>assets/sb-images/profile-image.png" width="41" height="41" alt="Profile" title="Profile" /></div>
                <?php }?>
                    <ul <?php if(empty($user_id)){echo 'style="margin-top:0px;font-size:16px;"';}?>>
                        <?php 
                                
                                
                                if(empty($user_id)){
									
                        ?>  
                        <li class="dropdown">
                        
                        <a href="javascript:void(0);" title="Login" dropdown-toggle=""  id="menu1" data-toggle="dropdown" style="font-size: 14px;margin-left: -21px;">
                       SIGN IN</a>
                                                      
                            <!--Login Via: section -->
                            <ul class="dropdown-menu login-list login-listbox" role="menu" aria-labelledby="menu1" >
                                <span class="fa fa-caret-up top-arrow" aria-hidden="true"></span>
                                 <div class="msg"></div>
                                <li>
                                    <div class="login-form">
                                        <div class="login-with-social-media">
                                        <a href="" style="font-size: 18px;float: left;margin-top: 7px;color: #fea800;">Login via :</a>
                                        <a href="javascript:void(0);" 
										title="Facebook" onclick='goclicky("<?php echo $fdata['authUrl'];?>","facebook");' ><img src="<?php echo base_url()?>assets/sb-images/facebook_login.png" width="36" height="36" alt="Login With Facebook" title="Login With Facebook"  /></a>
                                        <a href="javascript:void(0);" onclick='goclicky("<?php echo $tdata['oauthURL'];?>","twitter");' title="Login With Twitter" ><img src="<?php echo base_url()?>assets/sb-images/twitter_login.png" width="36" height="36" alt="Login With Twitter" title="Login With Twitter" /></a>
										<a href="javascript:void(0);" onclick='goclicky("<?php echo $gdata['loginURL']; ?>","google");' title="Login With Google plus" ><img src="<?php echo base_url()?>assets/sb-images/google_login.png" width="36" height="36" alt="Login With Google plus" title="Login With Google plus" /></a>
                                        <div class="clearfix"></div>
                                        </div>
										
                                        <div class="or">OR</div>
                                        <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                                            <input type="text"  name="userID" id="userID" placeholder="Email/Phone" />
                                            <input type="password" id="password2" name="password2" placeholder="Password" />
                                         <div class="forgotpassword"><a href="<?php echo base_url().'forgot-password';?>" title="Forgot the password">Forgot the Password</a></div>
                                         <button type="submit" class="signinbtn">Sign in</button>
                                        <div class="keepmelogedin"><input type="checkbox" style="display:inline-block; width:10%;" /> <span>Keeped Me logged-in</span></div>
                                        
                                        </form>
                                        
                                        <div class="newjoin">New here? <span><a href="javascript:void(0);" title="Join Us" onClick="return toggle_panel('2');">Join Us</a></span></div>
                                         <div class="newjoin"><span><a href="javascript:void(0);" title="Verify Yourself?" onClick="return toggle_panel('3');">Verify Yourself?</a></span></div>
                                        
                                    </div>
                                </li>
                            </ul>
                            <!-- //Login Via: section end //-->
                            
                            <!--Sign-UP: section-->
                            <ul class="dropdown-menu login-list signup-listbox" role="menu" aria-labelledby="menu1" style="display:none;">
                                <span class="fa fa-caret-up top-arrow" aria-hidden="true"></span>
                                <li class="msg"><a href="javascript:void(0);" title="Sign up"><p>Sign-UP:</p></a></li>
                                <li>
                                    <div class="login-form">
                                         
                                         <form class="form" name="signup-nav" method="post" action="#" id="signup-nav" >
                                            <input type="text"  name="userID" id="userID" placeholder="Email/Phone" />
                                            <input type="Password" name="Password" id="password" placeholder="Password" />
                                            <input type="Password" name="con_password" id="con_password" placeholder="Confirm Password" />
                                         <div class="forgotpassword"><a href="<?php echo base_url().'forgot-password';?>" title="Forgot the Password">Forgot the Password</a></div>
                                         <button type="submit" class="signinbtn">Register</button>
                                        
                                        <div class="keepmelogedin"><input type="checkbox" style="display:inline-block; width:10%;" /> <span>Keeped Me logged-in</span></div>
                                        
                                        </form>
                                        
                                        <div class="newjoin"><span><a href="javascript:void(0);" onClick="return toggle_panel('1');" title="LogIn">LogIn</a>
                                        </span></div>
                                        </div>                                 
                                    
                                </li>
                            </ul>
                            <!-- //Sign-Up Via: section end //-->
                            
                             <!--Sign-UP: section-->
                            <ul class="dropdown-menu login-list verify-listbox" role="menu" aria-labelledby="menu1" style="display:none;">
                                <span class="fa fa-caret-up top-arrow" aria-hidden="true"></span>
                                <li class="msg"><a href="javascript:void(0);" title="Verify Your Login Detail"><p> Verify Your Login Detail: </p></a></li>
                                <li>
                                    <div class="login-form">
                                         
                                         <form class="form" name="verify-nav" method="post" action="#" id="verify-nav" >
                                            <input type="text"  name="phone" id="phone" placeholder="Email/Phone" />
                                            <input type="text" name="otp" id="otp" placeholder="OTP(Send to your phone/Email)" />
                                           <button type="submit" class="signinbtn">Verify Yourself</button>
                                         </form>
                                        
                                        <div class="newjoin"><span><a href="javascript:void(0);" onClick="return toggle_panel('1');" title="LogIn">LogIn</a>
                                        &nbsp; 
                                        <a href="javascript:void(0);" onClick="return sentotp();" title="LogIn">Resent otp</a>
                                        </span></div>
                                        
                                    </div>
                                </li>
                            </ul>
                            <!-- //Sign-Up Via: section end //-->

                            <!--Reset Password: section-->
                            <ul class="dropdown-menu login-list" role="menu" aria-labelledby="menu1" style="display:none;">
                                <span class="fa fa-caret-up top-arrow" aria-hidden="true"></span>
                                <li><a href="javascript:void(0);" title="Reset Password"><p>Reset Password:</p></a></li>
                                <li>
                                    <div class="login-form">
                                        <form>
                                            <input type="Password" name="Password" placeholder="Password" />
                                            <input type="Password" name="confirm-Password" placeholder="Confirm Password" />
                                        
                                        
                                        <button class="signinbtn">Reset Password</button>
                                        
                                        <div class="keepmelogedin"><input type="checkbox" style="display:inline-block; width:10%;" /> <span>Keeped Me logged-in</span></div>
                                        
                                        </form>
                                        
                                        <div class="newjoin"><span><a href="" title="LogIn">LogIn</a></span></div>
                                        
                                    </div>
                                </li>
                            </ul>
                            <!-- //Reset Password: section end //-->
                           
                        </li>
                        <?php } if(!empty($user_id)){
							$listing = user_notifications_list($user_id);
							?>
                        <li><a href="javascript:void(0);"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                        <li class="dropdown"><a href="" class="" dropdown-toggle=""  id="menu1" data-toggle="dropdown" ><i class="fa fa-bell" aria-hidden="true"><?php echo $listing['count'];?></i> </a>
                            <ul class="dropdown-menu notification-list" role="menu" aria-labelledby="menu1">
                                <span class="fa fa-caret-up top-arrow" aria-hidden="true"></span>
                                <div class="notification-heading">NOTIFICATIONS</div>
                                <div id="content-2" class="content scroll-notification">
								 <?php 
									  //echo'<pre>';print_r($listing);echo'<br><br><br><br><br>';
								
								foreach($listing['reply_posts'] as $reply_posts){
									
									//print_r($reply_posts);echo'<br><br><br><br><br>';
									
														
								$story_url =  getstoryurl($reply_posts['spidypickId']);
								
									
								?>
							<li id="n_<?php echo $reply_posts['nid']?>"><a href="<?php echo $story_url['url'];?>#comment_wrapper" onClick="getConfirmation(<?php echo $reply_posts['nid']?>,1);" title="Comment"><img src="<?php if($reply_posts['profile_pick']){ echo $reply_posts['profile_pick'];}else{ echo base_url().'/uploads/no-image-small.png';}?>" width="45px" height="45px"/><span> <?php echo $reply_posts['first_name'];?> has reply on your comment.</span></a></li>
						<?php } foreach($listing['reply'] as $reply){
									
									//print_r($reply);echo'<br><br><br><br><br>';
								$story_url =  getstoryurl($reply['spidypickId']);
								?>
							<li id="n_<?php echo $reply['nid']?>"><a href="<?php echo $story_url['url'];?>#comment_wrapper" onClick="getConfirmation(<?php echo $reply['nid']?>,1);" title="Comment"><img src="<?php if($reply['profile_pick']){ echo $reply['profile_pick'];}else{ echo base_url().'/uploads/no-image-small.png';}?>" width="45px" height="45px"/><span> <?php echo $reply['first_name'];?> has also replied to a comment on same story.</span></a></li>
						<?php }  
								foreach($listing['post'] as $post){
									
									//print_r($post['user_id']);echo'<br><br><br><br><br>';
									
									
								$story_url =  getstoryurl($post['spidypickId']);
								
									
								?>
							<li id="n_<?php echo $post['nid']?>"><a href="<?php echo $story_url['url'];?>#comment_wrapper" onClick="getConfirmation(<?php echo $post['nid']?>,2);" title="Comment"><img src="<?php if($post['profile_pick']){ echo base_url().'/uploads/registration/'.$post['profile_pick'];}else{ echo base_url().'/uploads/no-image-small.png';}?>" width="45px" height="45px"/><span> <?php echo $post['first_name'];?> has also commented on same story.</span></a></li>
						<?php }?>  	 
							<?php
							if(count($post)==0&&count($reply)==0){
							        echo'<li>No message to display </li>';
									//continue;
							       } 
							
							
							
							
							
							?>		
                            </div> 
                         
                            </ul>
                        </li>
                        <?php }?>
                    </ul>
                </div>
             </div>
              <?php if(!empty($user_id)){?> 
             
              <div class="profile-login-pic  flr dropdown">
                
                <a href="" class="" dropdown-toggle=""  id="menu2" data-toggle="dropdown" >
                    <ul  class="top-setting" >
                        <li class="dropdown">
						
						<a href="javascript:void(0);" id="menu1" data-toggle="dropdown" title="Profile"><img src="<?php if($user_data[0]['profile_pick']){ echo $user_data[0]['profile_pick'];}else{ 
                        echo base_url().'uploads/no-image-small.png';}?>" alt="No Image" title="Profile Image" width="72px" height="72px"/></a>
						
                        <ul class="dropdown-menu top-setting" role="menu" aria-labelledby="menu2">
                        <span class="fa fa-caret-up top-setting-arrow" aria-hidden="true"></span>
                        <li><a href="javascript:void(0);" title="Settings"><p>SETTINGS</p></a></li>
						 <li><a href="<?php echo base_url()?>register" title="Edit Profile">Edit Profile</a></li> 
						 <li><a href="<?php echo base_url()?>change-password" title="Change Password">Change Password</a></li>  
                        <li><a href="<?php echo base_url().'home/logout/'?>" title="Log Out">Log Out</a></li>
                        
						
                       					
                       
                        					 
                        <li>&nbsp;</li>                            
                        <li>&nbsp;</li>                            
                        <li>&nbsp;</li>                            
                    </ul>
                        </li>
                    </ul>
              
             </div>
             
                
           <?php }?>
             
             
              <!--after login end-->
            
           </div>   
        </header>
    </div>
</div>
<!--container end-->


<section id="pmenu" class="info pmenu menu-smooth-scroll">
<div class="wide-container yellow-bg">
    <div class="container" >
    <nav>
        <ul style="display:block;">
            <li class="fixed-logo"><a href="<?php echo base_url();?>" title="Tracek Portal"><img src="<?php echo ASSETS_PATH;?>sb-images/fixed-logo.png" alt="Tracek Portal" title="Tracek Portal" style="margin-top:5px;" /></a></li>
            <li <?php echo (uri_string()=='')?'class="active"':'';?>><a href="<?php echo base_url();?>" title="Home">Home</a></li>
            <li class="newstab <?php echo (uri_string()=='trending/today') ? 'active' : ''; ?>">
                <a href="<?php echo base_url();?>trending/today" title="News">News</a>
            </li>
            <li class="features"><a href="javascript:void(0);" title="Features">Features</a></li>
            <li class="opinion"><a href="javascript:void(0);" title="Opinion">Opinion</a></li>
            <li <?php echo (uri_string()=='inbrief')?'class="active"':'';?>><a href="<?php echo base_url();?>inbrief" title="In-Brief">In-Brief</a></li>
            <li class="storytab"><a href="javascript:void(0);" title="Submit Story">Submit Story</a></li>
            <li id="ulclose" ><a href="javascript:void(0);" id="searchtoggl" title="Search"><i class="fa fa-search fa-lg"></i></a></li>
        </ul>
        
        <div class="app-store">
            <a href="javascript:void(0);" title="Google Play" ><img src="<?php echo ASSETS_PATH;?>sb-images/google-play.png" alt="Google Play" title="Google Play" /></a>
            <a href="javascript:void(0);" title="App Store" ><img src="<?php echo ASSETS_PATH;?>sb-images/apple-store.png" alt="App Store" title="App Store" /></a>
        </div>
        
    </nav>
    
    </div>
    
    <?php if((uri_string()=='trending/today') || (uri_string()=='trending/this-week') || (uri_string()=='trending/this-month') || (uri_string()=='trending/this-year'))
	{
		
		$display_style = 'display:block';
	}
	if(uri_string()=='trending/this-week'){
		$sort_by = 'THE BUZZ THIS WEEK';
		$link = 'trending/this-week';
	}else if(uri_string()=='trending/this-month'){
		$sort_by = 'THE BUZZ THIS MONTH';
		$link = 'trending/this-month';
	}else if(uri_string()=='trending/this-year'){
		$sort_by = 'THE BUZZ THIS YEAR';
		$link = 'trending/this-year';
	}else if(uri_string()=='trending/today'){
		$sort_by = 'THE BUZZ TODAY';
		$link = 'trending/today';
	}else{
		$sort_by = 'FILTER BY';
		$link = '';
	}
	?>
    <div class="wide-container yellow-bg-dark" id="news-tab-box" style="<?php echo $display_style;?>">
    <div class="container" style="position:relative;">
    <nav>
    <ul  style="display:block;-webkit-transition: height .3s ease;">
            
    <li style="position:relative;" <?php echo($link == uri_string())?'class="active"':'';?>><a href="javascript:void(0);"><?php echo $sort_by;?></a><i id="filtered-by"  class="icon-circle-arrow-up drop-arrow-nav filteredby" aria-hidden="true"></i>
    <!----------------------- Filter category------------------------>
   
        
        <div id="show-filter" class="display-filter-container-left">
            <ul class="filtered-list">
				<li <?php echo(uri_string()=='trending/today')?'class="active"':'';?>><a href="<?php echo base_url();?>trending/today" title="THE BUZZ TODAY">THE BUZZ TODAY </a></li>
                <li <?php echo(uri_string()=='trending/this-week')?'class="active"':'';?>><a href="<?php echo base_url();?>trending/this-week" title="THE BUZZ THIS WEEK">THE BUZZ THIS WEEK </a></li>
                <li <?php echo(uri_string()=='trending/this-month')?'class="active"':'';?>><a href="<?php echo base_url();?>trending/this-month" title="THE BUZZ THIS MONTH">THE BUZZ THIS MONTH</a></li>
				<li <?php echo(uri_string()=='trending/this-year')?'class="active"':'';?>><a href="<?php echo base_url();?>trending/this-year" title="THE BUZZ THIS YEAR">THE BUZZ THIS YEAR</a></li>
                </li>
            </ul>
        </div>
    
    <!----------------------- Filter category------------------------>
    
    </li>
            
    <li <?php echo(uri_string()=='mcd-election-special')?'class="active"':'';?>><a href="<?php echo base_url()?>mcd-election-special" title="MCD Election Special"><?php echo get_subCategoryName(40);?> </a></li>
            
    <li <?php echo(uri_string()=='crime')?'class="active"':'';?>><a href="<?php echo base_url()?>crime" title="Crime"><?php echo get_subCategoryName(39);?> </a></li>
            
    <li <?php echo(uri_string()=='health-sanitation')?'class="active"':'';?>><a href="<?php echo base_url()?>health-sanitation" title="Health & Sanitation"><?php echo get_subCategoryName(38);?> </a></li>
            
    <li <?php echo(uri_string()=='water')?'class="active"':'';?>><a href="<?php echo base_url()?>water"title="Water" ><?php echo get_subCategoryName(37);?> </a></li>
            
    <li <?php echo(uri_string()=='power')?'class="active"':'';?>><a href="<?php echo base_url()?>power" title="Power"><?php echo get_subCategoryName(36);?> </a></li>
            
    <li <?php echo(uri_string()=='trafic-transportation')?'class="active"':'';?>><a href="<?php echo base_url()?>trafic-transportation" title="Trafic & Transportation"><?php echo get_subCategoryName(35);?> </a></li>
        </ul></nav>
    </div>
</div>

	<div class="wide-container yellow-bg-dark" id="story-tab-box" style="<?php echo $display_style;?>">
        <div class="container" style="position:relative;">
        <nav>
        <ul  style="display:block;-webkit-transition: height .3s ease;">
                
        <li <?php echo(uri_string()=='home/buzzpeople')?'class="active"':'';?>>
		<?php if(empty($user_id )){?>		
	                        <a href="javascript:void(0);" onClick="return gotologin();" title="New">New</a>		
	                   <?php }else{?>		
	                   <a href="<?php echo base_url();?>home/buzzpeople" title="New">New</a>		
	                   <?php }?>
		</li>
                
        <li  <?php echo(uri_string()=='home/buzzpeople/saved_stories')?'class="active"':'';?>>
		<?php if(empty($user_id )){?>		
	                        <a href="javascript:void(0)" onClick="return gotologin();" title="Saved">Saved</a>		
	                   <?php }else{?>		
	                   <a href="<?php echo base_url();?>home/buzzpeople/saved_stories" title="Saved">Saved</a>		
	                   <?php }?>
		</li>
                
        <li <?php echo(uri_string()=='home/buzzpeople/submitted_stories')?'class="active"':'';?>>
		<?php if(empty($user_id )){?>		
	                        <a href="javascript:void(0)" onClick="return gotologin();" title="Submit Story">Submit Story</a>		
	                   <?php }else{?>		
	                   <a href="<?php echo base_url();?>home/buzzpeople/submitted_stories" title="Submit Story">Submit Story</a>		
	                   <?php }?>
		</li>
                
            </ul></nav>
        </div>
	</div>   

</div>


    <div id="searchbar" class="clearfix">
        <form  method="get" action="<?php echo base_url();?>search">
        <div class="search-container" >
         <button  id="searchsubmit" class="fa fa-search fa-4x" onClick="document.forms[0].submit();" ></button>
          <input type="text" name="s" id="s" placeholder="Keywords..." autocomplete="off" autofocus />
         
          </div>
        </form>
    </div>


</section>

<!--Mobile Menu Js code is Include in Main.js File-->
<section id="mobile_menu" class="mobile_menu menu-smooth-scroll" style="display:none;"> 
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">&times;</a>
  <a href="<?php echo base_url();?>" title="Home">Home</a>
  <a href="javascript:void(0);"  onclick="myFunctionone()" title="News">News <span class="flr"> &#x25BC;</span></a>
  	<ul id="myNews" class="sub-menu-second" style="display:none;">
    	<li><a href="javascript:void(0)"  onclick="myFunctiontwo()" title="FILTER BY">FILTER BY <span class="flr"> &#x25BC;</span></a>
            <ul id="filterBy" style="display:none;">
				<li <?php echo(uri_string()=='trending/today')?'class="active"':'';?>><a href="<?php echo base_url();?>trending/today" title="">THE BUZZ TODAY </a></li>
                <li <?php echo(uri_string()=='trending/this-week')?'class="active"':'';?>><a href="<?php echo base_url();?>trending/this-week" title="">THE BUZZ THIS WEEK </a></li>
                <li <?php echo(uri_string()=='trending/this-month')?'class="active"':'';?>><a href="<?php echo base_url();?>trending/this-month" title="">THE BUZZ THIS MONTH</a></li>
				<li <?php echo(uri_string()=='trending/this-year')?'class="active"':'';?>><a href="<?php echo base_url();?>trending/this-year" title="">THE BUZZ THIS YEAR</a></li>
            </ul>
        </li>
        <li <?php echo(uri_string()=='mcd-election-special')?'class="active"':'';?>><a href="<?php echo base_url()?>mcd-election-special" title="MCD Election Special"><?php echo get_subCategoryName(40);?> </a></li>
        <li <?php echo(uri_string()=='crime')?'class="active"':'';?>><a href="<?php echo base_url()?>crime" title="Crime"><?php echo get_subCategoryName(39);?> </a></li>
        <li <?php echo(uri_string()=='health-sanitation')?'class="active"':'';?>><a href="<?php echo base_url()?>health-sanitation" title="Health & Sanitation"><?php echo get_subCategoryName(38);?> </a></li>
        <li <?php echo(uri_string()=='water')?'class="active"':'';?>><a href="<?php echo base_url()?>water" title="Water"><?php echo get_subCategoryName(37);?> </a></li>
        <li <?php echo(uri_string()=='power')?'class="active"':'';?>><a href="<?php echo base_url()?>power" title="Power"><?php echo get_subCategoryName(36);?> </a></li>
        <li <?php echo(uri_string()=='trafic-transportation')?'class="active"':'';?>><a href="<?php echo base_url()?>trafic-transportation" title="Trafic & Transportation"><?php echo get_subCategoryName(35);?> </a></li>
    </ul>
 
  <a href="javascript:void(0);" title="Features">Features</a>
  <a href="javascript:void(0);" title="Opinion">Opinion</a>
  <a href="<?php echo base_url();?>inbrief" title="In-Brief">In-Brief</a>
  <a href="javascript:void(0);"  onclick="myFunctionthree()" title="Submit Story">Submit Story <span class="flr"> &#x25BC;</span></a>
    <ul id="submitBy" style="display:none;">
        <li <?php echo(uri_string()=='home/buzzpeople')?'class="active"':'';?>>
        <?php if(empty($user_id )){?>		
                        <a href="javascript:void(0);" onClick="return gotologin();" title="New">New</a>		
                   <?php }else{?>		
                   <a href="<?php echo base_url();?>home/buzzpeople" title="New">New</a>		
                   <?php }?>
        </li>
            
        <li  <?php echo(uri_string()=='home/buzzpeople/saved_stories')?'class="active"':'';?>>
        <?php if(empty($user_id )){?>		
                        <a href="javascript:void(0);" onClick="return gotologin();" title="Saved">Saved</a>		
                   <?php }else{?>		
                   <a href="<?php echo base_url();?>home/buzzpeople/saved_stories" title="Saved">Saved</a>		
                   <?php }?>
        </li>
            
        <li <?php echo(uri_string()=='home/buzzpeople/submitted_stories')?'class="active"':'';?>>
        <?php if(empty($user_id )){?>		
                        <a href="javascript:void(0);" onClick="return gotologin();" title="Submit Story">Submit Story</a>		
                   <?php }else{?>		
                   <a href="<?php echo base_url();?>home/buzzpeople/submitted_stories" title="Submit Story">Submit Story</a>		
                   <?php }?>
        </li>    
    </ul>
</div>

<div class="wide-container yellow-bg">
    <div class="container">
        <div class="mobile-menu-icon flt" onClick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></div>
        <div class="app-store">
            <span id="ulmobileclose"><a href="javascript:void(0);" id="searchtogglmobile" title="Search"><i class="fa fa-lg fa-search"></i></a></span>
            <a href="" title="Google play"><img src="<?php echo ASSETS_PATH;?>sb-images/google-play.png" alt="Google play" title="Google play" /></a>
            <a href="" title="Apple store"><img src="<?php echo ASSETS_PATH;?>sb-images/apple-store.png" alt="Apple store" title="Apple store" /></a>
        </div>
    </div>
    <div id="mobile-searchbar" class="clearfix">
        <form  method="get" action="<?php echo base_url();?>search">
        <div class="search-container" >
         <button  id="searchsubmit" class="fa fa-search fa-4x" onClick="document.forms[0].submit();" ></button>
          <input type="text" name="s" id="s" placeholder="Keywords..." autocomplete="off" autofocus />
         
          </div>
        </form>
    </div>

</div>



</section>
  
  
  
<script>
function gotologin(){
	//window.location = '#menu1';
	 
        $('html, body').animate({scrollTop:$('#menu1').position().top}, 'slow');
    	toggle_panel('1');
	}
    function toggle_panel(val){ 
        if(val=='1'){
                  $('.signup-listbox').fadeOut('slow', function(){
					$('.verify-listbox').fadeOut('slow');
					$('.login-listbox').fadeIn('slow');
				   
                });
        }else if(val=='2'){
                 $('.login-listbox').fadeOut('slow', function(){
 					$('.verify-listbox').fadeOut('slow');
					$('.signup-listbox').fadeIn('slow');
                });
        }
		
		else{
                 $('.login-listbox').fadeOut('slow', function(){
                 	$('.signup-listbox').fadeOut('slow');
				 	$('.verify-listbox').fadeIn('slow');
                });
        }
    }
    
    $(document).ready(function(){   
 
 <!--------------- Sign up form ---------------->
    $("#signup-nav").validate({
        errorClass: 'redvalidate',
        rules: {
            userID: {
                        required: true,
                      },
            password:{
                         required: true,
                      },
               
            con_password: {
                required: true,
                equalTo: "#password"
            } 
        },
        messages: {
                userID: {
                    required: "",
                },
                password: {
                    required: "" 
                } ,  
                con_password: {
                    required: "",
                    equalTo: "password"
                } 
        },
        submitHandler: function(form) {
            var dataSend    = $("#signup-nav").serializeArray();
                $.ajax({
                type: "POST",
                //  dataType:"text",
                beforeSend: function(){
                    $(".msg").html("Loading..").css('color', 'grey');
                    //$(".show_loader").click();
                },
                url: "<?php echo base_url(); ?>home/signup/",
                data: dataSend,
                success: function (msg) {
					
                    if(msg=='0' || msg==0){
						
                        //$(".msg").html("Invalid UserID/Password").css('color', 'red');
                        $(".msg").html("Invalid UserID/Password").css({'color': 'red',"margin-top":"10px"})
                        //$('.msg').fadeIn('slow').delay(1000).fadeOut('slow');;
                        
                        $('.msg').fadeIn('slow').delay(1000).fadeOut('slow',function(){
                            $(".msg").html("Signup").css('color', 'black');
                        })
                        
                    }
                    else if(msg=='1' || msg==1){
                        $(".msg").html("User Signup Successfull!").css({'color': 'green',"margin-top":"10px"});
                        //$('.msg').fadeIn('slow').delay(1000).fadeOut('slow');;
                        $('.msg').fadeIn('slow').delay(1000).fadeOut('slow',function(){
                            $(".msg").fadeIn('slow').html("Please verify to login!").css({'color': 'green',"margin-top":"10px"});
							toggle_panel('3');
                        })
                    }
                    else if(msg=='2' || msg==2){
                        $(".msg").html("User Exists!").css({'color': 'red',"margin-top":"10px"});
                        //$('.msg').fadeIn('slow').delay(1000).fadeOut('slow');;
                        $('.msg').fadeIn('slow').delay(1000).fadeOut('slow',function(){
                            $(".msg").html("Please Input Correct Detail!").css('color', 'black');
                        })
                    }
                },
                complete: function(){
                     // $(".msg").html("Signup").css('color', 'black');
                      $('#signup-nav')[0].reset();
                }
            });
             return false;
         }
    });
    //return false;
 <!--------------- Sign up form ---------------->
 
 
  
 <!--------------- Login form ---------------->
    $("#login-nav").validate({
        errorClass: 'redvalidate',
        rules: {
            userID: {
                        required: true,
                    },
            password2:{
                         required: true,
                      } 
        },
        messages: {
                userID: {
                    required: "",
                },
                password2: {
                    required: "" 
                } 
        },
        submitHandler: function(form) { 
            var dataSend    = $("#login-nav").serializeArray();
             
            $.ajax({
                type: "POST",
                //  dataType:"text",
                beforeSend: function(){
                         $(".msg").html("Loading..").css('color', 'grey');
                        //$(".show_loader").click();
                },
                url: "<?php echo base_url(); ?>home/login/",
                data: dataSend,
                success: function (msg) {
					
                    if(msg=='0' || msg==0){
                        $(".msg").html("");
                        $(".msg").html("Invalid UserID/Password").css({'color': 'red',"margin-top":"10px"})
                        //$('.msg').fadeIn('slow').delay(1000).fadeOut('slow');;
                        $('.msg').fadeIn('slow').delay(1000).fadeOut('slow',function(){
                            $(".msg").fadeIn('slow').html("Login").css('color', 'black');
                        });
                    }
                    else if(msg=='1' || msg== 1 ){
                        $(".msg").html("Login Successfully!").css('color', 'green');
                        $('.msg').fadeIn('slow').delay(1000).fadeOut('slow',function(){
                           // window.location.href="<?php echo base_url().'home';?>";
						    window.location.href=window.location
                        });
                    }
                },
                complete: function(){
                     // $(".msg").html("Signup").css('color', 'black');
                     // $('#signup-nav')[0].reset();
                }
            });
             return false;
         }
    });
    //return false;
 <!--------------- Login form ---------------->   
   <!--------------- Login form ---------------->
    $("#verify-nav").validate({
        errorClass: 'redvalidate',
        rules: {
            phone: {
                        required: true,
                    },
            otp:{
                         required: true,
                      } 
        },
        messages: {
                phone: {
                    required: "",
                },
                otp: {
                    required: "" 
                } 
        },
        submitHandler: function(form) { 
            var dataSend    = $("#verify-nav").serializeArray();
            $.ajax({
                type: "POST",
                beforeSend: function(){
                         $(".msg").html("Loading..").css('color', 'grey');
                },
                url: "<?php echo base_url(); ?>home/verify/",
                data: dataSend,
                success: function (msg) {
					//alert(msg);
                    if(msg=='0' || msg==0){
                        $(".msg").html("");
                        $(".msg").html("Invalid UserID/OTP").css({'color': 'red',"margin-top":"10px"})
                        //$('.msg').fadeIn('slow').delay(1000).fadeOut('slow');;
                        $('.msg').fadeIn('slow').delay(1000).fadeOut('slow',function(){
                            $(".msg").fadeIn('slow').html("Verify Login").css('color', 'black');
                        });
                    }
                    else if(msg=='1' || msg== 1 ){
                        $(".msg").html("Verify Successfully!").css('color', 'green');
                        $('.msg').fadeIn('slow').delay(1000).fadeOut('slow',function(){
                          //  window.location.href="<?php echo base_url().'home';?>";
						   window.location.href=window.location
                        });
                    }
                },
                complete: function(){
                     // $(".msg").html("Signup").css('color', 'black');
                     // $('#signup-nav')[0].reset();
                }
            });
             return false;
         }
    });
    //return false;
 <!--------------- Login form ---------------->   
     });
 
  function sentotp(){ 
	 $("#phone").css('border-color', '');
	   var emailID_phone = $("#phone").val(); 
	  // ValidateEmail(emailID_phone);
	   if(validatePhone(emailID_phone)==false && ValidateEmail(emailID_phone)==false){
		  $("#phone").css('border-color', 'red');
		  return false;
	   } 
	   else{
			$.ajax({
					type: "POST",
					beforeSend: function(){
						$(".msg").html("Loading..").css('color', 'grey');
						//$(".show_loader").click();
					},
					url: "<?php echo base_url(); ?>home/resentOtp/",
					data: {id:$("#phone").val()},
					success: function (msg) {
						if(msg==1){
							$(".msg").html("Otp Sent!").css('color', 'grey');
						}else if(msg==2){
							$(".msg").html("Max. Limit reached!").css('color', 'grey');
						}else if(msg==0){
							$(".msg").html("Already Approved!").css('color', 'red');
						}
					}
					});
	   }
  }
   
  function ValidateEmail(mail)   
  {  
	 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))  
	  {  
		return (true)  
	  }  
		return (false)  
	}  
	 
  function validatePhone(phone) { //Validates the phone number
	var phoneRegex = /^(\+91-|\+91|0)?\d{10}$/; // Change this regex based on requirement
	return phoneRegex.test(phone);
	}
 
	function goclicky(meh,name)
      {
        var x = screen.width/2 - 600/2;
        var y = screen.height/2 - 520/2;
		var myWindow= window.open(meh, myWindow,'height=400,width=600,left='+x+',top='+y);
        myWindow.document.title='Popup Box';
      }
</script>