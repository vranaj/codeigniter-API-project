
				

				<ul class="nav nav-list">
					<li class="<?php if($this->session->userdata('function') == 'index'){echo "active";}else{echo "";} ?> <?php $li_hover=''; $li_hover=$this->session->userdata('li_hover'); if($li_hover == 'y'){echo 'hover';}else{echo '';}?>">
						<a href="<?php echo site_url('users/index');?>">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<?php
						$menu = $this->session->userdata['menu'];
						
						foreach($menu as $row){ ?>
							<li class="<?php if($this->session->userdata('controller') == $row['menu_path']){echo "open";}else{echo "";} ?> <?php $li_hover=''; $li_hover=$this->session->userdata('li_hover'); if($li_hover == 'y'){echo 'hover';}else{echo '';}?>" >
								<a href="#" class="dropdown-toggle">
									<i class="<?php echo $row['menu_icon']?>"></i>
									<span class="menu-text"> <?php echo $row['menu_name'] ?> <span class="badge badge-info"><?php echo count($row['sub_menus']);?></span></span>
									<b class="arrow fa fa-angle-down"></b>
								</a>
								<b class="arrow"></b>
								
								<ul class="submenu">
									<?php $submenus = $row['sub_menus'];
								
										foreach($submenus as $val){ $submenu_fun = explode('/', $val['submenu_path']);?>
											<li class="<?php if(($this->session->userdata('controller') == $row['menu_path']) && ($this->session->userdata('function') == $submenu_fun[1])){echo "active"; } ?>">
												<a href="<?php echo site_url($val['submenu_path']); ?>">
													<i class="menu-icon fa fa-caret-right"></i> <?php echo $val['submenu_name']; ?>
												</a>
												<b class="arrow"></b>
											</li>
									<?php	} ?>
								</ul>
								
							</li>
					<?php	} ?>
					
					
				</ul><!-- /.nav-list -->

				


