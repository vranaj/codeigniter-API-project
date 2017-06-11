
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $site_name ?></title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		
        
        <meta name="description" content="UA Procurement System" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo base_url("favicon.ico"); ?>" >
		<?php
		//Load Javascripts
		echo $this->template->block('css', 'layouts/blocks/css');
		?>
		<?php
		//Load Javascripts
		echo $this->template->block('css', 'layouts/blocks/js_header');
		?>
		
		<!-- ace settings handler -->
		<script src="<?php echo base_url("assets/js/ace-extra.js"); ?>"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
				<script src="../assets/js/html5shiv.js"></script>
				<script src="../assets/js/respond.js"></script>
		<![endif]-->

		
	</head>

	

	
	
	
	
	

