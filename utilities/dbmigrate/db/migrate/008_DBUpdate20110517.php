<?php

class DBUpdate20110517 extends Ruckusing_BaseMigration {

	public function up() {
		$this->execute("CREATE TABLE `service_payments` ( `service_id` int(11) NOT NULL AUTO_INCREMENT, `item_id` int(11) DEFAULT NULL, `vendor_id` int(11) DEFAULT NULL, `payment_date` date DEFAULT NULL, `amount` double DEFAULT NULL, `remarks` varchar(255) DEFAULT NULL, `status` tinyint(4) DEFAULT '1', PRIMARY KEY (`service_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1");
	}//up()

	public function down() {
		$this->execute("DROP TABLE `service_payments`");
	}//down()
}
?>