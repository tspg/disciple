<?php
$o = '$2y$14$RiJ.ccGDwtD4eF4Jax3NHeB52E7EwTWY3WaSWsqOVYUw1cohvJ5DK';
//$o = password_hash('test', PASSWORD_BCRYPT, array('cost' => 14));
$v = password_verify($_GET['p'], $o);

echo ($v ? "" : "in") . "valid";
echo "<br />";
echo "<code>$o</code>";
?>
