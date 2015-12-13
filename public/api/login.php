<?php
	include 'apishared.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/config.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/session.php';

	$db = getsql();

	$username = $db->real_escape_string(api_checkarg_post_required('user', 'username'));
	$password = api_checkarg_post_required('pass', 'password');

	$qForUser = $db->query("SELECT * FROM `users` WHERE `username`='" . $username . "'");
	if ($qForUser->num_rows < 1)
	{
		Header("Location: /login?nouser=" . $username);
	}

	$o = $qForUser->fetch_object();
	if (!password_verify($password, $o->password))
	{
		Header("Location: /login?badpass");
	}

	$_SESSION['user'] = $o->username;
	$_SESSION['id'] = $o->id;

	Header("Location: /");
?>
