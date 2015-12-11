<?php
	include 'postcfglock.php';
	error_reporting(E_ERROR);

	include dirname(dirname(__DIR__)) . '/config/config.php';
	$db = new mysqli($disciple_config['mysql_hostname'], $disciple_config['mysql_user'], $disciple_config['mysql_pass'], $disciple_config['mysql_database']);

	if ($db->connect_errno) {
	    printf("Failed to connect to the MySQL database.<br/>%d %s\n", $db->connect_errno, $db->connect_error);
	    exit();
	}

	$db->query(file_get_contents(dirname(dirname(__DIR__)) . '/common/schema.sql'));

	echo 1;
?>
