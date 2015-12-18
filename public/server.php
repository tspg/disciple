<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/common/config.php';

	if (!isset($_GET['sid']) || !is_authed())
	{
		//Header("Location: /");
		exit();
	}

	if (empty($_GET['sid']))
	{
		//Header("Location: /");
		exit();
	}

	$s = $_GET['sid'];

	$db = getsql();

	$q = $db->query(sprintf("SELECT * FROM `servers` WHERE `sid`='%s'",
							$s));
?>

<?php sn_page_header('Manage Server'); ?>
	<?php sn_page_start_container(); ?>
		<h1>Manage Server</h1>
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
