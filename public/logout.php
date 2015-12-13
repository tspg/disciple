<?php
	include dirname(dirname(__FILE__)) . '/common/session.php';

	$_SESSION = array();

	session_destroy();
	if(isset($_GET['accdel']))
		Header("Location: /?accdel");
	else
		Header("Location: /");
?>
