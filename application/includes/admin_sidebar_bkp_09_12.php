<div id="sidebar" class="sidebar responsive ace-save-state">

				<script type="text/javascript">

					try{ace.settings.loadState('sidebar')}catch(e){}

				</script>

 



				<ul class="nav nav-list">

                    <li class="">

						<a href="<?php echo base_url(); ?>backend/dashboard">

							<i class="menu-icon fa fa-tachometer"></i>

							<span class="menu-text"> Dashboard </span>

						</a>

 						<b class="arrow"></b>

					</li> 

               

					<?php

					$getMenu=array();
					//if($this->session->userdata('admin_user_id')==1){
					$getMenuList = json_encode(getMenuIDByGroup());

					//echo '<pre>';print_r($getMenuList);exit;

					$getMenu = getMenuList('',$getMenuList); //exit;
					//}

						if(count($getMenu)>0){

							foreach($getMenu as $key=>$val){

								$getChild = getMenuList($val['id'],$getMenuList); 

								$child_cnt = count($getChild);?> 

                    <li class="">

						<a href="#" class="dropdown-toggle" title="<?php echo $val['menu'];?>">

							<i class="menu-icon fa fa-pencil-square-o"></i>

							<span class="menu-text"><?php echo $val['menu'];?></span>

							<?php $child_cnt;if($child_cnt>1){?>

							<b class="arrow fa fa-angle-down"></b><?php }?>

						</a>

 						<b class="arrow"></b>

						<?php 

 							if($child_cnt>0){?>

								<ul class="submenu">

                        	<?php foreach($getChild as $key2=>$val2){?> 

							<li class="">

								<a href="<?php echo base_url().$val2['url']; ?>" title="<?php echo $val2['menu'];?>">

									<i class="menu-icon fa fa-caret-right"></i>

									<?php echo $val2['menu'];?>

								</a>

 								<b class="arrow"></b>

							</li>

							<?php }?> 

						</ul>

                      <?php }?>

					</li>

                  <?php }

						}else{?>  

                    <li class="">

						<a href="#" class="dropdown-toggle" title="No Menu">

							<i class="menu-icon fa fa-pencil-square-o"></i>

							<span class="menu-text">No Menu</span>



							<b class="arrow fa fa-angle-down"></b>

						</a>



						 

					</li>

                    <?php }?>

 				</ul><!-- /.nav-list -->



				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">

					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>

				</div>

			</div>