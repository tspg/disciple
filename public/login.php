<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';
?>

<?php sn_page_header(); ?>
	<?php sn_page_start_container(); ?>
		<h1>Log in to <?=disciple_json()->site_name;?></h1>
		<div style='text-align: center;'>
			<div class='card'>
				<h3>Welcome to <?=disciple_json()->site_name;?></h1>
				<?php
					// Handle errors that may have been sent back from api/login.php

					if (isset($_GET['nouser']))
					{
						echo "<div class='submit-err'>User '" . $_GET['nouser'] . "' was not found.</div>";
					}
					elseif (isset($_GET['fromreg']))
					{
						echo "<div class='submit-err' style='color:#FFF;'>Welcome, " . $_GET['fromreg'] . "! You may log in below.</div>";
					}
				?>
				<form action='/api/login.php' method='post'>
					<input type='text' placeholder='Username' name='user' />
					<br />
					<input type='password' placeholder='Password' name='pass' />
					<br />
					<input type='submit' value='Log in' />
					<br />
				</form>
			</div>
		</div>
		<br />
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
