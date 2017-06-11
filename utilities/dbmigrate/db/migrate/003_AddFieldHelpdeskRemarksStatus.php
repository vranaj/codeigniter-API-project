<?php

class AddFieldHelpdeskRemarksStatus extends Ruckusing_BaseMigration {

	public function up() {
		$this->execute("ALTER TABLE `helpdesk_remarks` ADD COLUMN `status` tinyint NULL DEFAULT 0 AFTER `remark_datestamp`");
	}//up()

	public function down() {
		$this->remove_column("helpdesk_remarks", "status");
	}//down()
}
?>
