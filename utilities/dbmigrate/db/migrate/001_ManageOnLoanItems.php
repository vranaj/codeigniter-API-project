<?php

class ManageOnLoanItems extends Ruckusing_BaseMigration {

	public function up() {

		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `onloan` tinyint NULL DEFAULT 0 AFTER `insured_timestamp`");
		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `onloan_timestamp` datetime NULL AFTER `onloan`");
		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `onloan_by` varchar(20) NULL AFTER `onloan_timestamp`");
		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `onloan_returned`  tinyint NULL DEFAULT 0 AFTER `onloan_by`");
		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `onloan_returned_timestamp` datetime NULL AFTER `onloan_returned`");
		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `onloan_returned_by` varchar(20) NULL AFTER `onloan_returned_timestamp`");

	}//up()

	public function down() {
		$this->remove_column("item_inventory", "onloan");
		$this->remove_column("item_inventory", "onloan_timestamp");
		$this->remove_column("item_inventory", "onloan_by");
		$this->remove_column("item_inventory", "onloan_returned");
		$this->remove_column("item_inventory", "onloan_returned_timestamp");
		$this->remove_column("item_inventory", "onloan_returned_by");
	}//down()
}
?>
