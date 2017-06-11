<?php

class DBUpdate20110913 extends Ruckusing_BaseMigration {

	public function up() {
		$this->execute("INSERT INTO `asset_classes` VALUES ('5', 'Office Equipment ', 'Z1060')");

		$this->execute("ALTER TABLE `item_types` ADD COLUMN `notifications` tinyint NULL DEFAULT 0 AFTER `service_level_hours`");
		
		//$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `ordered_division` text NULL AFTER `cost_center_id`");

		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `capex_type` varchar(2) NULL AFTER `installed_capex`");

	}//up()

	public function down() {
		$this->execute("DELETE FROM `asset_classes` WHERE (`id`='5')");
		$this->execute("ALTER TABLE `asset_classes` AUTO_INCREMENT=5");

		$this->remove_column("item_types", "notifications");
		//$this->remove_column("item_inventory", "ordered_division");
		$this->remove_column("item_inventory", "capex_type");
	}//down()
}
?>