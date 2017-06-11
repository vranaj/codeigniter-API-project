<?php

class AddTableIndexes extends Ruckusing_BaseMigration {

	public function up() {
		$this->execute("ALTER TABLE `audit_logs` ADD INDEX `log_type` (`log_type`)");
		$this->execute("ALTER TABLE `audit_logs` ADD INDEX `log_id` (`log_id`)");

		$this->execute("ALTER TABLE `audit_tickets` ADD INDEX `ticket_id` (`ticket_id`)");

		$this->execute("ALTER TABLE `departments` ADD INDEX `department_id` (`department_id`)");
		$this->execute("ALTER TABLE `departments` ADD INDEX `division_id` (`division_id`)");

		$this->execute("ALTER TABLE `gatepass_details` ADD INDEX `gate_pass_id` (`gate_pass_id`)");
		$this->execute("ALTER TABLE `gatepass_details` ADD INDEX `item_id` (`item_id`)");

		$this->execute("ALTER TABLE `helpdesk_remarks` ADD INDEX `ticket_id` (`ticket_id`)");

		$this->execute("ALTER TABLE `hr_employee` ADD INDEX `emp_number` (`EMP_NUMBER`)");

		$this->execute("ALTER TABLE `log_remarks` ADD INDEX `log_type` (`log_type`)");
		$this->execute("ALTER TABLE `log_remarks` ADD INDEX `log_id` (`log_id`)");
	}//up()

	public function down() {
		$this->execute("ALTER TABLE `audit_logs` DROP INDEX `log_type`");
		$this->execute("ALTER TABLE `audit_logs` DROP INDEX `log_id`");

		$this->execute("ALTER TABLE `audit_tickets` DROP INDEX `ticket_id`");

		$this->execute("ALTER TABLE `departments` DROP INDEX `department_id`");
		$this->execute("ALTER TABLE `departments` DROP INDEX `division_id`");

		$this->execute("ALTER TABLE `gatepass_details` DROP INDEX `gate_pass_id`");
		$this->execute("ALTER TABLE `gatepass_details` DROP INDEX `item_id`");

		$this->execute("ALTER TABLE `helpdesk_remarks` DROP INDEX `ticket_id`");

		$this->execute("ALTER TABLE `hr_employee` DROP INDEX `emp_number`");

		$this->execute("ALTER TABLE `log_remarks` DROP INDEX `log_type`");
		$this->execute("ALTER TABLE `log_remarks` DROP INDEX `log_id`");
	}//down()
}
?>
