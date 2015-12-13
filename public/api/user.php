<?php
	include dirname(dirname(dirname(__FILE__))) . '/common/config.php';
	include 'apishared.php';

	$db = getsql();

	define('USERNAME_MAX_LENGTH', 20);
	define('PASSWORD_MAX_LENGTH', 70);

	$call = api_checkarg_post('fn');

	if ($call == 'register')
	{
		$username = $db->real_escape_string(api_checkarg_post_required('username', 'Username'));
		$password = api_checkarg_post_required('password', 'Password');
		$email = $db->real_escape_string(api_checkarg_post_required('email', 'E-mail'));

		if (strlen($username) > USERNAME_MAX_LENGTH)
		{
			api_error(SN_USERNAME_TOO_LONG, sprintf('Username "%s" is too long. The maximum length is %d characters. Pick a new name or trim your current one by %d characters.', $username, USERNAME_MAX_LENGTH, strlen($username) - USERNAME_MAX_LENGTH));
		}

		if (strlen($password) > PASSWORD_MAX_LENGTH)
		{
			api_error(SN_PASSWORD_TOO_LONG, sprintf('Your password is too long. The maximum length is %d characters.', PASSWORD_MAX_LENGTH));
		}

		$password_hashed = password_hash($password, PASSWORD_BCRYPT, array('cost' => 14));

		$db->query(sprintf("INSERT INTO users (username, password, email, serverlimit) VALUES ('%s', '%s', '%s', %d)",
							$username, $password, $email, disciple_json()->serverlimit));

		echo 1;
	}
?>
