<?php
	include 'postcfglock.php';
	include dirname(dirname(__FILE__)) . '/api/apishared.php';
	include dirname(dirname(__DIR__)) . '/config/config.php';

	$site_name = api_checkarg_post_required('site_name', 'Site name');
	$site_shortname = api_checkarg_post_required('site_shortname', 'Site short name');
	$main_version_binary = api_checkarg_post_required('binary', 'Zandronum server binary location');
	$serverlimit = intval(api_checkarg_post_required('serverlimit', 'Server limit'));
	$serverdata = intval(api_checkarg_post_required('serverdata', 'Server data location'));
	$rootuser = api_checkarg_post_required('rootuser', 'Root username');
	$rootpass = api_checkarg_post_required('rootpass', 'Root password');

	$out = array(
		'site_name'			=>	$site_name,
		'site_shortname' 	=>  $site_shortname,
		'main_binary'		=>	$main_version_binary,
		'serverlimit'		=> 	$serverlimit,
		'serverdata'		=> 	$serverdata
	);

	$file = dirname(dirname(dirname(__FILE__))) . '/config/config.json';
	$r = file_put_contents($file, json_encode($out));

	if ($r === FALSE)
	{
		api_error(SN_FAILED_FILE_WRITE, sprintf("Failed to write to file %s.", $file));
		exit();
	}

	$db = new mysqli($disciple_config['mysql_hostname'], $disciple_config['mysql_user'], $disciple_config['mysql_pass'], $disciple_config['mysql_database']);
	$db->query(sprintf("INSERT INTO `users` (username, password, serverlimit, activated, imported) VALUES ('%s', '%s', 65565, 1, 0)",
						$db->real_escape_string($rootuser),
						// We use a cost of 14 for the password hash to be compatible with BestBot.
						password_hash($rootpass, PASSWORD_BCRYPT, array('cost' => 14))));

	Header("Content-Type: text/plain");
	echo 1;
?>
