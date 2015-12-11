<?php
	include 'postcfglock.php';

	if (!function_exists('setup_header')) {
		function setup_header($title = 'Setup') {
			echo "<!DOCTYPE html>
			<html>
				<head>
					<meta charset='utf-8' />
					<title>Disciple :: $title</title>

					<link href='//fonts.googleapis.com/css?family=Roboto|Roboto+Mono' rel='stylesheet' type='text/css' />
					<link href='../assets/shared.css' rel='stylesheet' type='text/css' />
					<link href='../assets/setup.css' rel='stylesheet' type='text/css' />

					<script src='../assets/jquery.js'></script>
					<script src='../assets/setup.js'></script>
				</head>
				<body>
					";
		}
	}

	if (!function_exists('setup_footer')) {
		function setup_footer() {
			echo "</body></html>";
		}
	}
?>
