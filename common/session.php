<?php
	include 'config.php';

	$uinf = null;

	ini_set('session.name', 'DiscipleSession');
	ini_set('session.hash_function', 'sha512');

	if (session_status() == PHP_SESSION_NONE)
	{
    	session_start();
	}

	if(!function_exists("isAuthed"))
	{
		function isAuthed()
		{
			return isset($_SESSION['user']);
		}
	}

	if(!function_exists("is_authed"))
	{
		function is_authed()
		{
			return isset($_SESSION['user']);
		}
	}

	if (is_authed())
	{
		$uinfq = getsql()->query("SELECT * FROM `users` WHERE `id`=" . $_SESSION['id']);

		// Make sure to destroy our session if this user doesn't exist anymore.
		if ($uinfq->num_rows == 0)
		{
			Header("Location: /logout");
		}

		$uinf = $uinfq->fetch_object();
	}
?>
