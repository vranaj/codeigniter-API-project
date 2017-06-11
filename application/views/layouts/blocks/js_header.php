
<!-- basic scripts -->

<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url("assets/js/jquery.js");?>'>"+"<"+"/script>");
		</script>

<!-- <![endif]-->

<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
		</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url("assets/js/jquery.mobile.custom.js");?>'>"+"<"+"/script>");
		</script>