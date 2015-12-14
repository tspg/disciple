<?php
	define('SN_BAD_API_CALL', 1);
	define('SN_NO_API_CALL', 2);
	define('SN_API_CALL_BAD_PARAMETER', 3);
	define('SN_USERNAME_TOO_LONG', 4);
	define('SN_PASSWORD_TOO_LONG', 5);
	define('SN_FAILED_FILE_WRITE', 6);
	define('SN_API_CALL_EMPTY_PARAMETER', 7);
	define('SN_USER_ALREADY_EXISTS', 8);
	define('SN_FILE_EXISTS', 9);

	define('UL_UNREGISTERED', 0);
	define('UL_REGISTERED', 100);
	define('UL_ADMINISTRATOR', 200);
	define('UL_OPERATOR', 300);

	$UL_NAMES = array(
		'Unregistered', 'Registered',
		'Administrator', 'Operator'
	);
?>
