<?php

class DBUpdate20110702 extends Ruckusing_BaseMigration {

	public function up() {

		$this->execute("CREATE TABLE `flagged_items` (`id` int(11) NOT NULL AUTO_INCREMENT, `flaged_by` varchar(11) DEFAULT NULL, `item_id` int(11) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

		$this->execute("ALTER TABLE `flagged_items` ADD INDEX `flaged_by` (`flaged_by`)");
		$this->execute("ALTER TABLE `flagged_items` ADD INDEX `item_id` (`item_id`)");

	}//up()

	public function down() {

		$this->execute("DROP TABLE `flagged_items`");

	}//down()
}
?>