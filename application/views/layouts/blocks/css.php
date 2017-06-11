<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
		<link rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.css"); ?>" />
                <link rel="stylesheet" href="<?php echo base_url("assets/css/ace-skins.css"); ?>" />
<!-- page specific plugin styles -->

<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url("assets/css/ace-fonts.css"); ?>" />

<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url("assets/css/ace.css"); ?>" class="ace-main-stylesheet" id="main-ace-style" />

<!--[if lte IE 9]>
			<link rel="stylesheet" href="../assets/css/ace-part2.css" class="ace-main-stylesheet" />
<![endif]-->

<!--[if lte IE 9]>
		  <link rel="stylesheet" href="../assets/css/ace-ie.css" />
<![endif]-->


<!--for sweet alert-->
<link rel="stylesheet" href="<?php echo base_url("assets/css/sweetalert.css"); ?>" />

<!-- inline styles related to this page -->
<style>
/*----- Notifications----- */

.notification {
	
    border: 1px solid;
    z-index: 5000;
    font-size: 150%;
    padding: 10px;
    border-radius: 15px;
    display: block;
}
.notification > div {
    margin: 0;
    padding: 0;
    line-height: 1.5;
    text-align: center;
    text-shadow: 0px 1px 1px #fff;
}
.notification.attention {
    background: #fffbcc;
    border-color: #e6db55;
    color: #666452;
    background-repeat: no-repeat;
    background-position: 10px center;
    background-image: url('../img/warning_icon.png');
}
.notification.information {
    background: #dbe3ff;
    border-color: #a2b4ee;
    color: #585b66;
    background-repeat: no-repeat;
    background-position: 10px center;
    background-image: url('../img/info_icon.png');
}
.notification.success {
    background: #d5ffce;
    border-color: #9adf8f;
    color: #556652;
    background-repeat: no-repeat;
    background-position: 10px center;
    background-image: url('../img/valid_icon.png');
}
.notification.error {
    background-color: #ffcece;
    border-color: #df8f8f;
    color: #665252;
    background-repeat: no-repeat;
    background-position: 10px center;
    background-image: url('../img/error_icon.png');
}
</style>


<!--page related css files-->
<?php $this->load->view('includes/css/menu_css');?>	
<?php $this->load->view('includes/css/sub_menu_css');?>	
<?php $this->load->view('includes/css/user_roles_css');?>
<?php $this->load->view('includes/css/user_rights_css');?>
<?php $this->load->view('includes/css/sub_menu_functions_css');?>
<?php $this->load->view('includes/css/functional_rights_css');?>
<?php $this->load->view('includes/css/manage_cost_centers_css');?>
<?php $this->load->view('includes/css/manage_designations_css');?>
<?php $this->load->view('includes/css/manage_user_css');?>
<?php $this->load->view('includes/css/manage_departments_css');?>
<?php $this->load->view('includes/css/manage_module_css');?>
<?php $this->load->view('includes/css/manage_module_rights_css');?>

 <?php $this->load->view('includes/css/manage_test_css');?>