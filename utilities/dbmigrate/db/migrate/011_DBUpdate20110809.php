<?php

class DBUpdate20110809 extends Ruckusing_BaseMigration {

	public function up() {
		
		//create company codes table
		$this->execute("CREATE TABLE `company_codes` ( `id` int(11) NOT NULL AUTO_INCREMENT, `company_code` varchar(50) DEFAULT NULL, `company_key` varchar(5) DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1");
		$this->execute("INSERT INTO `company_codes` VALUES ('1', 'Life', 'CL')");
		$this->execute("INSERT INTO `company_codes` VALUES ('2', 'General', 'CG')");
		$this->execute("INSERT INTO `company_codes` VALUES ('3', 'Common', 'CC')");

		//create asset classes table
		$this->execute("CREATE TABLE `asset_classes` ( `id` int(11) NOT NULL AUTO_INCREMENT, `asset_class` varchar(50) DEFAULT NULL, `sap_code` varchar(10) DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1");
		$this->execute("INSERT INTO `asset_classes` VALUES ('1', 'Computer Hardware - Computer', 'Z1090')");
		$this->execute("INSERT INTO `asset_classes` VALUES ('2', 'Computer Hardware - Server', 'Z1080')");
		$this->execute("INSERT INTO `asset_classes` VALUES ('3', 'Computer Software - Computer', 'Z1110')");
		$this->execute("INSERT INTO `asset_classes` VALUES ('4', 'Computer Software - Server ', 'Z1100')");

		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `asset_class`  int NULL AFTER `additional_information`");
		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `company_code`  int NULL AFTER `asset_class`");
		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `cost_center_id`  int NULL AFTER `company_code`");

		$this->execute("ALTER TABLE `vendors` ADD COLUMN `vendor_code` varchar(20) NULL AFTER `vendor_id`");
		
		$this->execute("INSERT INTO `application_modules` (`module_description`, `module_security_level`, `module_owner`, `created_by`) VALUES ('Text File Generation', '1', '001357', '001357')");
		$this->execute("INSERT INTO `user_roles` (`role_id`, `role_description`, `role_access_level`, `created_by`) VALUES ('usr_fin', 'User Finance', '1', '001357')");
		$this->execute("INSERT INTO `access_control` (`module_id`, `role_id`, `created_by`) VALUES ('1', 'usr_fin', '001357')");
		$this->execute("INSERT INTO `access_control` (`module_id`, `role_id`, `created_by`) VALUES ('14', 'usr_fin', '001357')");
		
	}//up()

	public function down() {

		$this->execute("DROP TABLE `company_codes`");
		$this->execute("DROP TABLE `asset_classes`");
		
		$this->remove_column("item_inventory", "asset_class");
		$this->remove_column("item_inventory", "company_code");
		$this->remove_column("item_inventory", "cost_center_id");

		$this->remove_column("vendors", "vendor_code");
		
		$this->execute("DELETE FROM `access_control` WHERE (`control_id`='39')");
		$this->execute("DELETE FROM `access_control` WHERE (`control_id`='40')");
		$this->execute("ALTER TABLE `access_control` AUTO_INCREMENT=39");

		$this->execute("DELETE FROM `application_modules` WHERE (`module_id`='14')");
		$this->execute("ALTER TABLE `application_modules` AUTO_INCREMENT=14");

		$this->execute("DELETE FROM `user_roles` WHERE (`role_id`='usr_fin')");
		
	}//down()
}
?>