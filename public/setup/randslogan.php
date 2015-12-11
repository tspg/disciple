<?php
	$slogans = array(
		'Zandronum servers for everyone',
		'It\'s like BestBot but better',
		'No more IRC!'
	);

	echo sprintf('"%s"', $slogans[array_rand($slogans)]);
?>
