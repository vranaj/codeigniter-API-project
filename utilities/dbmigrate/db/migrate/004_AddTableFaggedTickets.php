<?php

class AddTableFaggedTickets extends Ruckusing_BaseMigration {

	public function up() {

		$this->execute("CREATE TABLE `flagged_tickets` (`id` int(11) NOT NULL AUTO_INCREMENT, `flaged_by` varchar(11) DEFAULT NULL, `ticket_id` int(11) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

		$this->execute("ALTER TABLE `helpdesk_tickets` ADD UNIQUE INDEX `ticket_id` (`ticket_id`)");

		$this->execute("ALTER TABLE `flagged_tickets` ADD INDEX `flaged_by` (`flaged_by`)");
		$this->execute("ALTER TABLE `flagged_tickets` ADD INDEX `ticket_id` (`ticket_id`)");

	}//up()

	public function down() {

		//$this->execute("ALTER TABLE `flagged_tickets` DROP INDEX `flaged_by`");
		//$this->execute("ALTER TABLE `flagged_tickets` DROP INDEX `ticket_id`");

		$this->execute("DROP TABLE `flagged_tickets`");

		$this->execute("ALTER TABLE `helpdesk_tickets` DROP INDEX `ticket_id`");

	}//down()
}
?>
