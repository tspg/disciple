<?php
	include realpath(dirname(__FILE__)) . '/../../common/errors.php';
	include 'apishared.php';

	define('USERNAME_MAX_LENGTH', 20);
	define('PASSWORD_MAX_LENGTH', 70);

	$call = api_checkarg('fn');

	if ($call == 'register')
	{
		$username = api_checkarg_post('username');
		$password = api_checkarg_post('password');
		$email = api_checkarg_post('email');

		if (strlen($username) > USERNAME_MAX_LENGTH)
		{
			api_error(SN_USERNAME_TOO_LONG, sprintf('Username "%s" is too long. The maximum length is %d characters. Pick a new name or trim your current one by %d characters.', $username, USERNAME_MAX_LENGTH, strlen($username) - USERNAME_MAX_LENGTH));
		}

		if (strlen($password) > PASSWORD_MAX_LENGTH)
		{
			api_error(SN_PASSWORD_TOO_LONG, sprintf('Your password is too long. The maximum length is %d characters.', PASSWORD_MAX_LENGTH));
		}

		$password_hashed = password_hash($password);
	}
?>
