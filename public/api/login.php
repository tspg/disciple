<?php
	include 'apishared.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/config.php';

	$db = new mysqli($disciple_config['mysql_hostname'], $disciple_config['mysql_user'], $disciple_config['mysql_pass'], $disciple_config['mysql_database']);

	$username = $db->real_escape_string(api_checkarg_post_required('user', 'username'));
	$password = $db->real_escape_string(api_checkarg_post_required('pass', 'username'));

	$qForUser = $db->query("SELECT * FROM `users` WHERE `username`='" . $username . "'");
	if ($qForUser->num_rows < 1)
	{
		Header("Location: /login?nouser=" . $username);
	}
?>
