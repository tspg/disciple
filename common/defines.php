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

	$UL_UNREGISTERED = array('id' => 0, 'name' => 'Unregistered');
	$UL_NORMAL = array('id' => 1, 'name' => 'Normal');
	$UL_ADMIN = array('id' => 2, 'name' => 'Administrator');
	$UL_OPERATOR = array('id' => 3, 'name' => 'System Operator');
?>
