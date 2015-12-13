<?php
	include dirname(dirname(dirname(__FILE__))) . '/common/config.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/session.php';
	include 'apishared.php';

	if (is_authed())
	{
		if (intval($_SERVER['CONTENT_LENGTH'])>0 && count($_POST)===0){
			Header("Location: /wads?toobig=" . $fn);
			exit();
		}

		if (isset($_POST['doup']))
		{
			$target_dir = data_dir('/wads/');
			$fn = basename($_FILES['file']['name']);
			$target_file = $target_dir . basename($_FILES['file']['name']);
			$uploadOk = 1;

			if (file_exists($target_file))
			{
				Header("Location: /wads?exists=" . $fn);
				exit();
			}

			if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file) === FALSE)
			{
				Header("Location: /wads?unknownerror=" . $fn);
				exit();
			}
			else
			{
				$db = getsql();
				$db->query(sprintf("INSERT INTO wads (filename, uploader, time) VALUES ('%s', %d, %d)",
							$fn, $_SESSION['id'], time()));
				echo $db->error;
				Header("Location: /wads?ok=" . $fn);
				exit();
			}
		}
		else
		{
			Header("Location: /wads" . $fn);
			exit();
		}
	}
	else
	{
		Header("Location: /wads?unauthed");
		exit();
	}
?>
