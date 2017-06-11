<?php


//----------------------------
// DATABASE CONFIGURATION
//----------------------------
$ruckusing_db_config = array(
	
  'development' => array(
     'type'      => 'mysql',
     'host'      => 'localhost',
     'database'  => 'uahelpdesk',
     'user'      => 'root',
     'password'  => 'ace101'
  ),

	'test' 					=> array(
			'type' 			=> 'mysql',
			'host' 			=> 'localhost',
			'port'			=> 8889,
			'database' 	=> 'uahelpdesk',
			'user' 			=> 'root',
			'password' 	=> 'ace101'
	),
	'production' 		=> array(
			'type' 			=> 'mysql',
			'host' 			=> 'localhost',
			'port'			=> 0,
			'database' 	=> 'uahelpdesk',
			'user' 			=> 'root',
			'password' 	=> 'ace101'
	)
	
);


?>
