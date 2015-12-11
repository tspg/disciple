<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'/>
		<title>Sentinel :: Error</title>

		<link href='//fonts.googleapis.com/css?family=Roboto|Roboto+Mono' rel='stylesheet' type='text/css' />
		<link href='../assets/setup.css' rel='stylesheet' type='text/css' />
	</head>
	<body>
		<div class='centre'>
			<div class='card'>
				<h3><code>config.php</code> missing</h3>

				Looks like you haven't set up your <code>config.php</code> yet.
				<br />
				You should do that now, before we can set up Sentinel.
				<br />
				You should find it in <code><?php echo dirname(dirname(dirname(__FILE__))); ?>/config/config.example.php</code>.
				<br />
				Don't forget to rename the example file to <code>config.php</code>.

				<br /><br />

				<input type='button' value='Try again' onclick='document.location="../setup"' />
			</div>
		</div>
	</body>
</html>
