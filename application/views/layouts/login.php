<?php echo $this->template->block('header', 'layouts/blocks/header'); ?>
   	
<body class="login-layout">

<?php echo $this->template->message(); ?>

<div class="main-container">
	<div class="main-content">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="login-container">
				<?php echo $this->template->yield_content(); ?>
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div>
</div><!-- /.main-container -->

<?php echo $this->template->block('footer', 'layouts/blocks/footer'); ?>
