<?php
	include dirname(dirname(__FILE__)) . '/common/session.php';

	$_SESSION = array();

	session_destroy();
	Header("Location: /");
?>
