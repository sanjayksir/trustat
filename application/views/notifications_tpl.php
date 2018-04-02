<?php //echo '<pre>';print_r($this->session->all_userdata());exit;
$getNotificationCount=notification_count();
$notification_cnt = 0;
if(!empty($getNotificationCount)){
	$notification_cnt =$getNotificationCount; 
}

## Notification Listing:
$listNotification = notifications_list();
 //echo '<pre>';print_r($listNotification);exit;
?>
<li class="purple dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important"><?php echo $notification_cnt;?></span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									<?php echo $notification_cnt;?> Notifications
								</li>
								<?php if(!empty( $notification_cnt )){?>
								<li class="dropdown-content ace-scroll" style="position: relative;"><div class="scroll-track" style="display: none;"><div class="scroll-bar"></div></div><div class="scroll-content" style="max-height: 200px;">
									<ul class="dropdown-menu dropdown-navbar navbar-pink">
										
                                       <?php if(count($listNotification)>0){
										   foreach($listNotification as $key=>$val){?>
                                                <li>
                                                        <div class="clearfix">
                                                            <span class="pull-left">
                                                                <i class="btn btn-xs btn-primary fa fa-user"></i>
                                                                <a href="<?php echo base_url().'Buzzadmn/Editorial/view_idea_listing/'.$val['created_by'];?>"><?php echo limitstr($val['title'], 20);?></a>
                                                            </span>
                                                            <a href="<?php echo base_url().'Buzzadmn/Editorial/listing_user_wise/'.$val['created_by'];?>"><span class="pull-right badge badge-info"><?php echo $val['total'];?></span></a>
                                                        </div>
                                                    
                                                </li>
                                       <?php }
									   }else{?> 
                                       <li>No Notification</li>
                                       <?php }?> 
 
									</ul>
								</div></li>

								<li class="dropdown-footer">
									<a href="<?php echo base_url().'Buzzadmn/notifications/';?>">
										See all notifications
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
                                <?php }else{?>
                                <li class="dropdown-footer">
									 
										No Notifications
									 
								</li>
                                <?php }?>
							</ul>
						</li>