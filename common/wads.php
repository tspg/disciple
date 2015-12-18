<?php
	include 'defines.php';

	if (!function_exists('human_filesize'))
	{
		function human_filesize($bytes, $decimals = 2)
		{
			$sz = ' KMGTP';
			$factor = floor((strlen($bytes) - 1) / 3);
			return sprintf("%.{$decimals}f %sB", $bytes / pow(1024, $factor), @$sz[$factor]);
		}
	}

	if (!function_exists('display_wad_table'))
	{
		function display_wad_table($limit = 0)
		{
			echo "
<table>
	<tr>
		<th></th>
		<th>File</th>
		<th>Size</th>
		<th>Uploaded by</th>
		<th>Date and time</th>
		<th>MD5</th>
	</tr>
";
				$db = getsql();
				$limitstring = '';
				if ($limit > 0)
				{
					$limitstring = " LIMIT $limit";
				}

				$q = $db->query("SELECT * FROM `wads` ORDER BY `time` DESC $limitstring");

				if ($q->num_rows < 1)
				{
					echo "
<div id='serversbox'>
	<div style='width: 100%; text-align: center'>
		There are no WADs uploaded yet.
		";
		if (is_authed())
		{
			echo "
		<br />
		Feel free to upload one from the main WADs page.
		";
		}
		echo "
	</div>
</div>
					";
				}
				elseif ($q->num_rows > 0)
				{
					while ($o = $q->fetch_object())
					{
						$id = $o->id;
						$size = human_filesize(filesize(disciple_json()->serverdata . '/wads/' . $o->filename));
						$filename = $o->filename;
						$uploader = $o->uploader;
						$uploader_name = user_info($uploader)->username;
						$time = date('Y-m-d \a\t H:i:s', $o->time);

						echo "
<tr id='wadrow-$id'>
	<td>
";
						if (is_authed())
						{
							if (user_info()->userlevel >= UL_ADMINISTRATOR || $uploader == $_SESSION['id'])
							{
								echo "<a href='javascript:deleteWad($id);' title='Delete'><i class='material-icons'>delete</i></a>";
							}

							if (user_info()->userlevel >= UL_ADMINISTRATOR)
							{
								if ($db->query("SELECT * FROM `wadbans` WHERE `md5`='" . $o->md5 . "'")->num_rows == 0)
								{
									echo "<a href='javascript:banWad($id);' title='Ban'><i class='material-icons'>not_interested</i></a>";
								}
								else
								{
									echo "<a href='javascript:unbanWad($id);' title='Unban'><i class='material-icons'>done</i></a>";
								}
							}
						}

						echo "
</td>
<td><a href='/wads/$filename'>$filename</a></td>
<td>$size</td>
<td>$uploader_name</td>
<td>$time</td>
<td id='wadmd5-$id'><a href='javascript:wadMd5($id);'>Show</a></td>
</tr>
";
				}
				echo "</table>";
			}
		}
	}
?>
