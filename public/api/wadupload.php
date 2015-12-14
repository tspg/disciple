<?php
	include dirname(dirname(dirname(__FILE__))) . '/common/config.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/session.php';
	include 'apishared.php';

	// A list of MD5s for all known commercial
	// IWADs.
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
		'e4f120eab6fb410a5b6e11c947832357', // PSN
		'0c8758f102ccafe26a3040bee8ba5021', // 1.9 Xbox1
		'72286ddc680d47b9138053dd944b2a3d', // 1.9 XBLA
		'fb35c4a5a9fd49ec29ab6e900572c524', // 1.9 BFG Edition
		'7912931e44c7d56e021084a256659800', // 1.9 BFG Edition Xbox 360
		'3e410ecd27f61437d53fa5c279536e88', // Pocket PC

		// Doom 2
		'30e3c2d0350b67bfbf47271970b74b2f', // 1.666
		'd9153ced9fd5b898b36cc5844e35b520', // 1.666 German
		'ea74a47a791fdef2e9f2ea8b8a9da13b', // 1.7
		'd7a07e5d3f4625074312bc299d7ed33f', // 1.7a
		'c236745bb01d89bbb866c8fed81b6f8c', // 1.8
		'3cb02349b3df649c86290907eed64e7b', // 1.8 French
		'25e1459ca71d321525f84628f45ca8cd', // 1.9
		'a793ebcdd790afad4a1f39cc39a893bd', // 1.9 Xbox1
		'43c2df32dc6c740cb11f34dc5ab693fa', // 1.9 XBLA
		'c3bea40570c23e511a7ed3ebcd9865f7', // 1.9 BFG Edition
		'f617591a6c5d07037eb716dc4863e26b', // BFG Edition Xbox 360
		'43c2df32dc6c740cb11f34dc5ab693fa', // XBLA
		'a793ebcdd790afad4a1f39cc39a893bd', // Xbox RoE
		'4c3db5f23b145fccd24c9b84aba3b7dd', // PSN
		'9640fc4b2c8447bbd28f2080725d5c51', // Zodiac

		// Final Doom (Plutonia)
		'75c8cf89566741fa9d22447604053bd7', // 1.9
		'3493be7e1e2588bc9c8b31eab2587a04', // 1.9 (id Anthology Edition)
		'b77ca6a809c4fae086162dad8e7a1335', // PSN

		// Final Doom (TNT)
		'4e158d9953c79ccf97bd0663244cc6b6', // 1.9
		'1d39e405bf6ee3df69a8d2646c8d5c49', // 1.9 (id Anthology Edition)
		'be626c12b7c9d94b1dfb9c327566b4ff', // PSN

		// Heretic
		'3117e399cdb4298eaa3941625f4b2923', // 1.0
		'1e4cb4ef075ad344dd63971637307e04', // 1.2
		'66d686b1ed6d35ff103f15dbd30e0341', // 1.3

		// Heretic: Shadow of the Serpent Riders
		'66d686b1ed6d35ff103f15dbd30e0341', // 1.3

		// Hexen
		'c88a2bb3d783e2ad7b599a8e301e099e', // Beta
		'b2543a03521365261d0a0f74d5dd90f0', // 1.0
		'abb033caf81e26f12a2103e1fa25453f', // 1.1
		'b68140a796f6fd7f3a5d3226a32b93be', // Mac

		// Hexen: Deathkings of the Dark Citadel
		'1077432e2690d390c256ac908b5f4efa', // 1.0
		'78d5898e99e220e4de64edaa0e479593', // 1.1

		// Strife
		'8f2d3a6a289f5d2f2f9c1eec02b47299', // 1.0
		'2fed2031a5b03892106e0f117f17901f'  // 1.2
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
			$ext = pathinfo($fn, PATHINFO_EXTENSION);
			$fn = preg_replace('/[^a-zA-Z0-9_\-]+/', '', pathinfo($fn, PATHINFO_FILENAME)) . '.' . $ext;
			$target_file = $target_dir . $fn;
			$uploadOk = 1;
			$tmploc = $_FILES['file']['tmp_name'];

			$lext = strtolower($ext);
			if (!($lext == 'wad' || $lext == 'pk3' || $lext == 'pk7'))
			{
				Header("Location: /wads?badext");
				exit();
			}

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
