<?php

class AddSalvageRemarksField extends Ruckusing_BaseMigration {

	public function up() {
		$this->execute("ALTER TABLE `item_inventory` ADD COLUMN `salvage_remarks` text NULL AFTER `is_salvage`");
	}//up()

	public function down() {
		$this->remove_column("item_inventory", "salvage_remarks");
	}//down()
}
?>