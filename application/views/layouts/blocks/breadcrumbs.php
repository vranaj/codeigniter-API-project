					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#"><?php echo ucwords(str_replace('_', ' ', $this->session->userdata('controller')));?></a>
							</li>
							
							<?php $ci =&get_instance(); if($this->session->userdata('function') == $ci->router->method){ ?>
								
								<li class="active"><?php echo ucwords(str_replace('_', ' ', $this->session->userdata('function')));?></li>
							
							<?php } else{ ?>
							
								<li>
									<a href="#"><?php echo ucwords(str_replace('_', ' ', $this->session->userdata('function')));?></a>
								</li>

								<li class="active"><?php echo ucwords(str_replace('_', ' ', $ci->router->method));?></li>
								
							<?php } ?>
							
							
						</ul><!-- /.breadcrumb -->

						<!-- 
						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div>-->

						<!-- /section:basics/content.searchbox -->
					</div>
					<!-- /section:basics/content.breadcrumbs -->
					<div class="page-content">
					<div><h4>
						<?php if(validation_errors()): ?>
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">
									<i class="icon-remove"></i>
								</button>
								<?php echo validation_errors(); ?>
								<br>
							</div>
						<?php endif; ?>
							
					</h4></div>
						<!-- #section:settings.box -->
						<div class="ace-settings-container" id="ace-settings-container">
							<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
								<i class="ace-icon fa fa-cog bigger-130"></i>
							</div>
							
							<div class="ace-settings-box clearfix" id="ace-settings-box">
								<div class="pull-left width-50">
									<!-- #section:settings.skins -->
									<div class="ace-settings-item">
										<div class="pull-left">
											<select id="skin-colorpicker" class="hide">
												<option data-skin="no-skin" value="#438EB9" <?php /*for skin*/ $skin=''; $skin = $this->session->userdata('skin'); if($skin == 'no-skin'){echo 'selected';}?>>#438EB9</option>
												<option data-skin="skin-1" value="#222A2D" <?php /*for skin*/ $skin=''; $skin = $this->session->userdata('skin'); if($skin == 'skin-1'){echo 'selected';}?>>#222A2D</option>
												<option data-skin="skin-2" value="#C6487E" <?php /*for skin*/ $skin='';  $skin = $this->session->userdata('skin'); if($skin == 'skin-2'){echo 'selected';}?>>#C6487E</option>
												<option data-skin="skin-3" value="#D0D0D0" <?php /*for skin*/ $skin='';  $skin = $this->session->userdata('skin'); if($skin == 'skin-3'){echo 'selected';}?>>#D0D0D0</option>
											</select>
										</div>
										<span>&nbsp; Choose Skin</span>
									</div>

									<!-- /section:settings.skins -->

									<!-- #section:settings.navbar -->
									<!--<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
										<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
									</div>-->

									<!-- /section:settings.navbar -->

									<!-- #section:settings.sidebar -->
									<!--<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
										<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
									</div>-->

									<!-- /section:settings.sidebar -->

									<!-- #section:settings.breadcrumbs -->
									<!--<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
										<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
									</div>-->

									<!-- /section:settings.breadcrumbs -->

									<!-- #section:settings.rtl -->
									<!-- <div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
										<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
									</div>-->

									<!-- /section:settings.rtl -->

									<!-- #section:settings.container -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 inside_container" id="ace-settings-add-container" <?php $ic=''; $ic=$this->session->userdata('ic'); if($ic == 'y'){echo 'checked';}else{echo '';}?>/>
										<label class="lbl" for="ace-settings-add-container">
											Inside
											<b>.container</b>
										</label>
									</div>

									<!-- /section:settings.container -->
								</div><!-- /.pull-left -->

								<div class="pull-left width-50">
									<!-- #section:basics/sidebar.options -->
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 li_hover" id="ace-settings-hover" <?php $li_hover=''; $li_hover=$this->session->userdata('li_hover'); if($li_hover == 'y'){echo 'checked';}else{echo '';}?>/>
										<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 sb_compact" id="ace-settings-compact" <?php $sb_compact=''; $sb_compact=$this->session->userdata('sb_compact'); if($sb_compact == 'y'){echo 'checked';}else{echo '';}?>/>
										<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
									</div>

									<!--<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
										<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
									</div>-->

									<!-- /section:basics/sidebar.options -->
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->

						</div><!-- /.ace-settings-container -->
			
						<!-- /section:settings.box -->
						<div class="page-header">
							<h1><?php $ci =& get_instance(); 
							if(($this->session->userdata('controller') == 'users') && ($ci->router->method == 'index')){
									echo "Dashboard";
									
							}else if(($this->session->userdata('controller') != 'users') && ($ci->router->method != 'index')){
									echo ucwords(str_replace('_', ' ', $ci->router->method));
							
							}?> </h1>
							<!--Showing backend validation errors -->
							
						</div><!-- /.page-header -->
						
						
				
				
				
				
				
				
				
				
				
				
				
				
				