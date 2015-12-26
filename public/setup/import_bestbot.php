<?php
	include 'postcfglock.php';
	include dirname(dirname(__FILE__)) . '/api/apishared.php';
	include dirname(dirname(__DIR__)) . '/common/config.php';

    Header("Content-Type: text/plain");
    function db_errcheck(&$db)
    {
        if ($db->errno)
        {
            echo "MySQL Error Occured.\n";
            echo $db->errno . "\n" . $db->error;
            exit();
        }
    }

	$db = getsql();

	$db_host = api_checkarg_post_required('db_host', 'Database hostname');
	$db_port = api_checkarg_post_required('db_port', 'Database port');
	$db_name = api_checkarg_post_required('db_name', 'Database name');
	$db_user = api_checkarg_post_required('db_user', 'Database username');
	$db_pass = api_checkarg_post_required('db_pass', 'Database password');

	$bb = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

	$q = $bb->query("SELECT username, password, activated, level, `server_limit` FROM login");
    db_errcheck($bb);
    $c = 0;
    $db->query("TRUNCATE TABLE `users`");
    db_errcheck($db);
	while ($i = $q->fetch_object())
	{
        //echo $c . "\n";
        $c++;
        $oul = intval($i->level);
        $equivalent = UL_REGISTERED;
        if ($oul == 2 || $oul == 4 || $oul == 15)
        {
            $equivalent = UL_ADMINISTRATOR;
        }
        elseif ($oul == 5 || $oul == 16)
        {
            $equivalent = UL_OPERATOR;
        }

		$db->query(sprintf("INSERT INTO users (username, password, serverlimit, activated, imported, userlevel) VALUES ('%s', '%s', '%d', '%d', '1', %d)",
					$i->username, $i->password, $i->server_limit, $i->activated, $equivalent));
        db_errcheck($db);
	}

	$q = $bb->query("SELECT * FROM banlist");
    db_errcheck($bb);
    $c = 0;
    $db->query("TRUNCATE TABLE `bans`");
    db_errcheck($db);
	while ($i = $q->fetch_object())
	{
        //echo $c . "\n";
        $c++;
		$db->query(sprintf("INSERT INTO bans (ip, reason, banner, time) VALUES ('%s', '%s', 0, 0)",
					$i->ip, $i->reason));
        db_errcheck($db);
	}

	$q = $bb->query("SELECT * FROM blacklist");
    db_errcheck($bb);
    $c = 0;
    $db->query("TRUNCATE TABLE `wadbans`");
    db_errcheck($db);
	while ($i = $q->fetch_object())
	{
        //echo $c . "\n";
        $c++;
		$db->query(sprintf("INSERT INTO wadbans (md5, banner, time) VALUES ('%s', 0, 0)",
					$i->md5));
        db_errcheck($db);
	}

	$q = $bb->query("SELECT * FROM save");
    db_errcheck($bb);
    $c = 0;
    $db->query("TRUNCATE TABLE `savedservers`");
    db_errcheck($db);
	while ($i = $q->fetch_object())
	{
        printf("%s\n", $i->serverstring);

        //echo $c . "\n";
        $c++;

        preg_match_all('/((?:"[^"]*"|[^=\s])*)=((?:"[^"]*"|[^=\s])*)/', $i->serverstring, $matches);

        $result = array();
        foreach ($matches[1] as $i => $key) {
           $result[$key] = $matches[2][$i];
        }

        $hostname = null;
        $iwad = null;
        $gamemode = null;

        foreach ($result as $key => $value)
        {
            switch ($key)
            {
                case 'hostname':
                    $hostname = trim($value, '"');
                    break;
            }
        }

        print_r($result);
		//$db->query(sprintf("INSERT INTO savedservers (md5, banner, time) VALUES ('%s', 0, 0)",
		//			$i->md5));
        db_errcheck($db);
	}
?>
