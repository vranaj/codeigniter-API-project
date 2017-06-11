<?php echo $this->template->block('header', 'layouts/blocks/header'); ?>
   
<body>

<?php echo $this->template->message(); ?>

<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>

	<div class="main-container-inner">
		<div class="page-content">
			<div style="min-height: 500px">
				<?php echo $this->template->yield_content(); ?>
			</div>
		</div>
	</div>
</div>

<?php echo $this->template->block('footer', 'layouts/blocks/footer'); ?>
