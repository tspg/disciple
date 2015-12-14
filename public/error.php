<?php
	if(!isset($_GET['c']))
	{
		Header("Location: /");
	}

	include dirname(dirname(__FILE__)) . '/common/pages.php';

	$head = '';
	$body = '';

	switch (intval($_GET['c']))
	{
		case 403:
			$head = 'Forbidden';
			$body = 'Looks like you don\'t have access to <code>' . $_SERVER['REQUEST_URI'] . '</code>.';

			break;

		case 404:
			$head = 'File Not Found';
			$body = 'I can\'t find <code>' . $_SERVER['REQUEST_URI'] . '</code>.';

			break;

		case 413:
			$head = 'Entity Too Large';
			$body = 'Looks like that file is too big for our server.';

			break;

		case 500:
			$head = 'Internal Server Error';
			$body = 'Something\'s gone wrong on our end, please bare with us.';

			break;

		default:
			$head = 'Error';
			$body = 'An error occured.';

			break;
	}
?>

<?php sn_page_header($head); ?>
	<?php sn_page_start_container(); ?>
		<div style='text-align: center; width: 100%; font-size:128pt'><?=$_GET['c'];?></div>
		<div style='text-align: center; width: 100%; font-size:36pt'><?=$head;?></div>
		<div style='text-align: center; width: 100%; font-size:16pt'><?=$body;?></div>
		<br />
		<div style='text-align: center; width: 100%;'>
			<input type='button' value='Reload' onclick='location.reload()' />
			<input type='button' value='Back' onclick='history.back()' />
			<input type='button' value='Home' onclick='location="/"' />
		</div>
		<br />
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
