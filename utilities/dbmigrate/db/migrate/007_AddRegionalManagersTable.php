<?php

class AddRegionalManagersTable extends Ruckusing_BaseMigration {

	public function up() {
		$this->execute("CREATE TABLE `regional_managers` ( `id` int(11) NOT NULL AUTO_INCREMENT, `department_id` int(11) DEFAULT NULL, `manager_name` varchar(255) DEFAULT NULL, `user_id` varchar(10) DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1");
	}//up()

	public function down() {
		$this->execute("DROP TABLE `regional_managers`");
	}//down()
}
?>