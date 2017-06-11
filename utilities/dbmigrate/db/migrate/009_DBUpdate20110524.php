<?php

class DBUpdate20110524 extends Ruckusing_BaseMigration {

	public function up() {
		$this->execute("ALTER TABLE `gatepass_header` ADD COLUMN `person_removing`  varchar(100) NULL AFTER `items_array`");
		$this->execute("ALTER TABLE `gatepass_header` ADD COLUMN `date_of_removal`  date NULL AFTER `person_removing`");
	}//up()

	public function down() {
		$this->remove_column("gatepass_header", "person_removing");
		$this->remove_column("gatepass_header", "date_of_removal");
	}//down()
}
?>