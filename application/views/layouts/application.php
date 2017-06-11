
		<?php echo $this->template->block('header', 'layouts/blocks/header'); ?>
 	
        <body class="<?php /*for skin*/ $skin=''; $skin = $this->session->userdata('skin'); if($skin == ''){echo 'no-skin'; }else{ echo $this->session->userdata('skin');}?>">
            
            <script>
                //for skin
                $(document).ready(function(){
                    $('#skin-colorpicker').change(function(){
                        var skin_val = $('#skin-colorpicker :selected').attr('data-skin');
                        $.ajax({
                            url:'<?php echo site_url('users/set_skin_by_ajax');?>',
                            type:'post',
                            data:{skin_val:skin_val},
                            success:function(data){}
                        });
                           
                    });
                    
                    $('.inside_container').change(function(){
                        var inside_container = 'n';
                        if($('.inside_container').is(':checked') == true){
                            inside_container = 'y';
                        }
                        $.ajax({
                            url:'<?php echo site_url('users/set_inside_container_ajax');?>',
                            type:'post',
                            data:{ic:inside_container},
                            success:function(data){}
                        });
                           
                    });
                    
                    $('.li_hover').change(function(){
                        var li_hover = 'n';
                        if($('.li_hover').is(':checked') == true){
                            li_hover = 'y';
                        }
                        $.ajax({
                            url:'<?php echo site_url('users/set_li_hover_ajax');?>',
                            type:'post',
                            data:{li_hover:li_hover},
                            success:function(data){}
                        });
                           
                    });
                    
                    $('.sb_compact').change(function(){
                        var sb_compact = 'n';
                        if($('.sb_compact').is(':checked') == true){
                            sb_compact = 'y';
                        }
                        $.ajax({
                            url:'<?php echo site_url('users/set_sb_compact_ajax');?>',
                            type:'post',
                            data:{sb_compact:sb_compact},
                            success:function(data){}
                        });
                           
                    });
                });
                
            </script>
	<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
				<?php echo $this->template->block('header', 'layouts/blocks/top_menu'); ?>
		</div>
		
		<!-- /section:basics/navbar.layout -->
                <div class="main-container <?php $ic=''; $ic=$this->session->userdata('ic'); if($ic == 'y'){echo 'container';}else{echo '';}?>" id="main-container">
			<script type="text/javascript">
				//try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<a href="#" class="menu-toggler invisible" id="menu-toggler" data-target="#sidebar"></a>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar responsive-min <?php $sb_compact=''; $sb_compact=$this->session->userdata('sb_compact'); if($sb_compact == 'y'){echo 'compact';}else{echo '';}?>">
				<script type="text/javascript">
					//try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<!-- #section:basics/sidebar.layout.shortcuts -->
						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>

						<!-- /section:basics/sidebar.layout.shortcuts -->
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->
				
				<?php echo $this->template->block('header', 'layouts/blocks/main_menu'); ?>
				
				<!-- #section:basics/sidebar.layout.minimize -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<div class="sidebar-toggle sidebar-expand" id="sidebar-expand">
					<i class="ace-icon fa fa-angle-double-right" data-icon1="ace-icon fa fa-angle-double-right" data-icon2="ace-icon fa fa-angle-double-left"></i>
				</div>

				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>
			
                        <!-- /section:basics/sidebar -->
                        <div class="main-content">
                            <div class="main-content-inner">
                                    <!-- #section:basics/content.breadcrumbs -->
                                    <?php echo $this->template->block('header', 'layouts/blocks/breadcrumbs'); ?>

                                    <div class="col-md-6 col-md-offset-3"><?php echo $this->template->message(); ?></div>
                                    <div style="min-height: 500px">

                                            <?php echo $this->template->yield_content(); ?>
                                    </div>
                                    <br><br>

                            </div><!-- /.page-content -->
                        </div><!-- /.main-content-inner -->
                        <?php echo $this->template->block('footer', 'layouts/blocks/footer'); ?>        
                    </div><!-- /.main-content -->
			
