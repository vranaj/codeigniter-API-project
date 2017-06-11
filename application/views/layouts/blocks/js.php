		<script src="<?php echo base_url("assets/js/bootstrap.js");?>"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script src="<?php echo base_url("assets/js/ace/elements.scroller.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/elements.colorpicker.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/elements.fileinput.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/elements.typeahead.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/elements.wysiwyg.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/elements.spinner.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/elements.treeview.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/elements.wizard.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/elements.aside.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.ajax-content.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.touch-drag.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.sidebar.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.sidebar-scroll-1.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.submenu-hover.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.widget-box.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.settings.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.settings-rtl.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.settings-skin.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.widget-on-reload.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.searchbox-autocomplete.js");?>"></script>

		<!-- inline scripts related to this page -->

		<!-- the following scripts are used in demo only for onpage help and you don't need them -->
		<link rel="stylesheet" href="<?php echo base_url("assets/css/ace.onpage-help.css");?>" />
		<link rel="stylesheet" href="<?php echo base_url("docs/assets/js/themes/sunburst.css");?>" />

		<script type="text/javascript"> ace.vars['base'] = '<?php echo base_url("");?>'; </script>
		<script src="<?php echo base_url("assets/js/ace/elements.onpage-help.js");?>"></script>
		<script src="<?php echo base_url("assets/js/ace/ace.onpage-help.js");?>"></script>
		<script src="<?php echo base_url("docs/assets/js/rainbow.js");?>"></script>
		<script src="<?php echo base_url("docs/assets/js/language/generic.js");?>"></script>
		<script src="<?php echo base_url("docs/assets/js/language/html.js");?>"></script>
		<script src="<?php echo base_url("docs/assets/js/language/css.js");?>"></script>
		<script src="<?php echo base_url("docs/assets/js/language/javascript.js");?>"></script>
		
<!--for sweet alert-->
		<script src="<?php echo base_url("assets/js/sweetalert.min.js");?>"></script>

<!--page related js files-->
<?php $this->load->view('includes/js/menu_js');?>	
<?php $this->load->view('includes/js/sub_menu_js');?>
<?php $this->load->view('includes/js/user_roles_js');?>
<?php $this->load->view('includes/js/user_rights_js');?>
<?php $this->load->view('includes/js/sub_menu_functions_js');?>
<?php $this->load->view('includes/js/functional_rights_js');?>
<?php $this->load->view('includes/js/manage_cost_centers_js');?>
<?php $this->load->view('includes/js/manage_designations_js');?>
<?php $this->load->view('includes/js/manage_user_js');?>
<?php $this->load->view('includes/js/manage_departments_js');?>
<?php $this->load->view('includes/js/manage_module_js');?>
<?php $this->load->view('includes/js/manage_module_rights_js');?>

 <?php $this->load->view('includes/js/manage_test_js');?>