<?php
	include dirname(dirname(dirname(__FILE__))) . '/common/errors.php';

	if (!function_exists('api_error')) {
		function api_error($code, $error) {
			Header("HTTP/1.1 400 Bad Request");
			Header("Content-Type: text/plain");
			echo $code . ' ' . $error;
			exit();
		}
	}

	if (!function_exists('api_checkarg')) {
		function api_checkarg($arg) {
			if(!isset($_GET[$arg]))
			{
				if ($arg == 'fn')
					api_error(SN_NO_API_CALL, 'No call was specified in the request.');
				else
					api_error(SN_API_CALL_BAD_PARAMETER, 'Missing GET argument "' . $arg . '"');

				exit();
			}

			return $_GET[$arg];
		}
	}

	if (!function_exists('api_checkarg_required')) {
		function api_checkarg_required($arg, $friendly) {
			$arg = api_checkarg($arg);
			if (empty($arg))
				api_error(SN_API_CALL_EMPTY_PARAMETER, sprintf("Field '%s' is required.", $friendly));
			return $arg;
		}
	}

	if (!function_exists('api_checkarg_post')) {
		function api_checkarg_post($arg, $default = '_____default') {
			if(!isset($_POST[$arg]))
			{
				if ($default == '_____default')
				{
					if ($arg == 'fn')
						api_error(SN_NO_API_CALL, 'No call was specified in the request.');
					else
						api_error(SN_API_CALL_BAD_PARAMETER, 'Missing POST argument "' . $arg . '"');

					exit();
				}
				else
				{
					return $default;
				}
			}

			return $_POST[$arg];
		}
	}

	if (!function_exists('api_checkarg_post_required')) {
		function api_checkarg_post_required($arg, $friendly) {
			$arg = api_checkarg_post($arg);
			if (empty($arg))
				api_error(SN_API_CALL_EMPTY_PARAMETER, sprintf("Field '%s' is required.", $friendly));
			return $arg;
		}
	}
?>
