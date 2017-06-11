<?php

class AddTableItemConfiguration extends Ruckusing_BaseMigration {

	public function up() {

		$this->execute("CREATE TABLE `item_configuration` ( `id` int(11) NOT NULL AUTO_INCREMENT, `item_id` int(11) DEFAULT NULL, `total_physical_ram` varchar(15) DEFAULT NULL, `user_name` varchar(50) DEFAULT NULL, `computer_name` varchar(50) DEFAULT NULL, `host_name` varchar(50) DEFAULT NULL, `ip_address` varchar(15) DEFAULT NULL, `mac_address` varchar(255) DEFAULT NULL, `os_name` varchar(25) DEFAULT NULL, `os_version` varchar(25) DEFAULT NULL, `processor_count` varchar(5) DEFAULT NULL, PRIMARY KEY (`id`), KEY `item_id` (`item_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1");

	}//up()

	public function down() {

		$this->execute("DROP TABLE `item_configuration`");

	}//down()
}
?>