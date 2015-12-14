<?php
	include dirname(dirname(dirname(__FILE__))) . '/common/config.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/session.php';
	include 'apishared.php';

	$iwadmd5 = array(
		// Doom (beta)
		'740901119ba2953e3c7f3764eca6e128', // 0.2
		'b6afa12a8b22e2726a8ff5bd249223de', // 0.4
		'9c877480b8ef33b7074f1f0c07ed6487', // 0.5
		'049e32f18d9c9529630366cfc72726ea', // Press Release beta

		// Doom (registered)
		'981b03e6d1dc033301aa3095acc437ce', // 1.1
		'792fd1fea023d61210857089a7c1e351', // 1.2
		'54978d12de87f162b9bcc011676cb3c0', // 1.666
		'11e1cd216801ea2657723abc86ecb01f', // 1.8
		'1cd63c5ddff1bf8ce844237f580e9cf3', // 1.9

		// Ultimate Doom
		'c4fe9fd920207691a9f493668e0a2083', // 1.9
		'0c8758f102ccafe26a3040bee8ba5021', // 1.9 Xbox1
		'72286ddc680d47b9138053dd944b2a3d', // 1.9 XBLA
		'fb35c4a5a9fd49ec29ab6e900572c524', // 1.9 BFG Edition

		// Doom 2
		'30e3c2d0350b67bfbf47271970b74b2f', // 1.666
		'd9153ced9fd5b898b36cc5844e35b520', // 1.666 German
		'ea74a47a791fdef2e9f2ea8b8a9da13b', // 1.7
		'd7a07e5d3f4625074312bc299d7ed33f', // 1.7a
		'c236745bb01d89bbb866c8fed81b6f8c', // 1.8
		'25e1459ca71d321525f84628f45ca8cd', // 1.9
		'a793ebcdd790afad4a1f39cc39a893bd', // 1.9 Xbox1
		'43c2df32dc6c740cb11f34dc5ab693fa', // 1.9 XBLA
		'c3bea40570c23e511a7ed3ebcd9865f7', // 1.9 BFG Edition

		// Final Doom (Plutonia)
		'75c8cf89566741fa9d22447604053bd7', // 1.9
		'3493be7e1e2588bc9c8b31eab2587a04', // 1.9 (id Anthology Edition)

		// Final Doom (TNT)
		'4e158d9953c79ccf97bd0663244cc6b6', // 1.9
		'1d39e405bf6ee3df69a8d2646c8d5c49', // 1.9 (id Anthology Edition)

		// Heretic
		'3117e399cdb4298eaa3941625f4b2923', // 1.0

		// Heretic: Shadow of the Serpent Riders
		'66d686b1ed6d35ff103f15dbd30e0341', // 1.3

		// Hexen
		'b2543a03521365261d0a0f74d5dd90f0'  // 1.0
	);

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
			$tmploc = $_FILES['file']['tmp_name'];

			if (in_array(md5_file($tmploc), $iwadmd5))
			{
				Header("Location: /wads?iwad");
				exit();
			}

			if (file_exists($target_file))
			{
				Header("Location: /wads?exists=" . $fn);
				exit();
			}

			if (move_uploaded_file($tmploc, $target_file) === FALSE)
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
