<?php echo $this->template->block('header', 'layouts/blocks/header'); ?>
   
<body >

<?php echo $this->template->message(); ?>

<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>
	<?php echo $this->template->yield_content(); ?>
</div>
</body>
</html>

