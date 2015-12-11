<?php
	include 'postcfglock.php';
	include dirname(dirname(__FILE__)) . '/api/apishared.php';
	include dirname(dirname(__DIR__)) . '/config/config.php';
	$db = new mysqli($disciple_config['mysql_hostname'], $disciple_config['mysql_user'], $disciple_config['mysql_pass'], $disciple_config['mysql_database']);

	$db_host = api_checkarg_post_required('db_host', 'Database hostname');
	$db_port = api_checkarg_post_required('db_port', 'Database port');
	$db_name = api_checkarg_post_required('db_name', 'Database name');
	$db_user = api_checkarg_post_required('db_user', 'Database username');
	$db_pass = api_checkarg_post_required('db_pass', 'Database password');

	$bb = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

	$q = $bb->query("SELECT username, password, activated, serverlimit FROM login");
	while ($i = $q->fetch_object())
	{
		$db->query(sprintf("INSERT INTO users (username, password, serverlimit, activated, imported) VALUES ('%s', '%s', '%d', '%d', '1')",
					$i->username, $i->password, $i->serverlimit, $i->activated));
	}

	echo 1;
?>
