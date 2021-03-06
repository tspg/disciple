<?php
	include 'config.php';

	class server
	{
		protected $binary;
		protected $wads 			= 	array();
		protected $optwads			= 	array();
		protected $iwad 			= 	'';
		protected $hostname 		= 	'';
		protected $protected 		= 	false;
		protected $owner			= 	-1;
		protected $gamemode			=	'cooperative';
		protected $config			=	'';
		protected $skill			= 	1;
		protected $stdata 			= 	false;
		protected $instagib			= 	false;
		protected $buckshot			= 	false;
		protected $dmflags 			=	0;
		protected $dmflags2 		=	0;
		protected $zadmflags 		=	0;
		protected $compatflags 		=	0;
		protected $zacompatflags 	=	0;

		// Server ID. This is defined in __construct.
		public	  $id;

		protected $pipes;
		protected $stdoutfile;
		protected $stderrfile;

		protected $running			= 	false;

		protected $process;

		protected $db;


		function __construct(
								$binary, $wads, $optwads, $iwad, $hostname,
								$protected, $gamemode, $config, $skill,
								$stdata, $instagib, $buckshot, $dmflags,
								$dmflags2, $zadmflags, $compatflags,
								$zacompatflags,

								// Optional stuff
								$id 			= null,
								$owner			= -1,
								$pipes			= array()
							)
		{
			$this->binary			= $binary;
			$this->wads				= $wads;
			$this->optwads			= $optwads;
			$this->iwad				= $iwad;
			$this->hostname			= $hostname;
			$this->protected 		= $protected;
			$this->owner			= $owner;
			$this->gamemode			= $gamemode;
			$this->config			= $config;
			$this->skill			= $skill;
			$this->stdata			= $stdata;
			$this->instagib			= $instagib;
			$this->buckshot			= $buckshot;
			$this->dmflags			= $dmflags;
			$this->dmflags2			= $dmflags2;
			$this->zadmflags		= $zadmflags;
			$this->compatflags 		= $compatflags;
			$this->zacompatflags	= $zacompatflags;
			$this->pipes			= $pipes;

			if ($id == null)
			{
				$this->id 				= hash('sha256', time() + $owner + $skill + ($stdata ? 1 : 0) + ($instagib ? 1 : 0) + ($buckshot ? 1 : 0)  + $dmflags + $dmflags2 + $zadmflags + $compatflags + $zacompatflags + mt_rand());
			}
			else
			{
				$this->id 			=  $id;
			}

			$this->stdinfile 		= sprintf("%s/%s-stdin", disciple_json()->serverdata, $this->id);
			$this->stdoutfile 		= sprintf("%s/%s-stdout.log", disciple_json()->serverdata, $this->id);
			$this->stderrfile 		= sprintf("%s/%s-stderr.log", disciple_json()->serverdata, $this->id);

			$this->db				= getsql();
		}

		public static function from_json($json)
		{
			$d = json_decode($json);

			$id = null;
			$owner = -1;
			$pipes = array();

			if (!$d->save)
			{
				$id = $d->id;
				$owner = $d->owner;
				$pipes = $d->pipes;
			}

			return new Server(
				$d->binary,
				$d->wads,
				$d->optwads,
				$d->iwad,
				$d->hostname,
				$d->protected,
				$d->gamemode,
				$d->config,
				$d->skill,
				$d->stdata,
				$d->instagib,
				$d->buckshot,
				$d->dmflags,
				$d->dmflags2,
				$d->zadmflags,
				$d->compatflags,
				$d->zacompatflags,
				$id,
				$owner,
				$pipes
			);
		}

		public function to_json($save = false)
		{
			$a = array(
				'save'				=> 	$save,
				'binary'			=>  $this->binary,
				'wads'				=>	$this->wads,
				'optwads'			=>	$this->optwads,
				'iwad'				=>	$this->iwad,
				'hostname'			=> 	$this->hostname,
				'protected'			=> 	$this->protected,
				'gamemode'			=>	$this->gamemode,
				'config'			=>	$this->config,
				'skill'				=>	$this->skill,
				'stdata'			=>	$this->stdata,
				'instagib'			=>	$this->instagib,
				'buckshot'			=>	$this->buckshot,
				'dmflags'			=>	$this->dmflags,
				'dmflags2'			=>	$this->dmflags2,
				'zadmflags'			=>	$this->zadmflags,
				'compatflags'		=>	$this->compatflags,
				'zacompatflags'		=>	$this->zacompatflags,
				'owner'				=>	$this->owner
			);

			if (!$save)
			{
				$a['id']				=	$this->id;

				// We export the stdXfiles for ease of access.
				// We don't import them as they're generated with the ID.
				$a['stdoutfile']		= 	$this->stdoutfile;
				$a['stderrfile']		=	$this->stderrfile;
			}

			$s = json_encode($a);
			if ($s === FALSE)
			{
				echo json_last_error();
				echo json_last_error_msg();
				exit();
			}
			else
			{
				return $s;
			}
		}

		protected function generate_command_line()
		{
			$out = $this->binary;
			$out .= sprintf(' +set _sid %s ', $this->id);
			$out .= '-host ';

			foreach ($this->wads as $w)
			{
				$out .= sprintf('-file "%s" ', $w);
			}

			foreach ($this->optwads as $w)
			{
				$out .= sprintf('-optfile "%s" ', $w);
			}

			$out .= sprintf('-iwad "%s" ', $this->iwad);
			$out .= sprintf('+sv_hostname "%s %s" ', disciple_json()->hostname_prefix, $this->hostname);

			$gamemode = 'cooperative';

			// Gamemode name to CVar
			switch ($this->gamemode)
			{
				case 'deathmatch':
				case 'terminator':
				case 'possession':
				case 'teampossession':
				case 'skulltag':
				case 'duel':
				case 'teamgame':
				case 'domination':
				case 'survival':
				case 'invasion':
				case 'cooperative':
				case 'ctf':
					$gamemode = $this->gamemode;
					break;

				case 'teamdm':
					$gamemode = 'teamplay';
					break;

				case 'lms':
					$gamemode = 'lastmanstanding';
					break;

				case 'teamlms':
					$gamemode = 'teamlastmanstanding';
					break;

				case 'oneflag':
					$gamemode = 'oneflagctf';
					break;

				default:
					$gamemode = 'cooperative';
					break;
			}

			$out .= sprintf("+%s true ", $gamemode);
			$out .= sprintf("+skill %d ", $this->skill);

			$out .= sprintf("+instagib %d ", ($this->instagib ? 1 : 0));
			$out .= sprintf("+buckshot %d ", ($this->buckshot ? 1 : 0));

			$out .= sprintf("+dmflags %d ", $this->dmflags);
			$out .= sprintf("+dmflags2 %d ", $this->dmflags2);
			$out .= sprintf("+zadmflags %d ", $this->zadmflags);
			$out .= sprintf("+compatflags %d ", $this->compatflags);
			$out .= sprintf("+zacompatflags %d ", $this->zacompatflags);

			$out .= sprintf('+exec "%s" ', $this->config);

			return $out;
		}

		public function start()
		{
			$this->owner = $_SESSION['id'];

			if (!file_exists($this->stdinfile))
			{
				touch($this->stdinfile);
			}

			$dsp = array(
				0 => array('file', $this->stdinfile, 'r'),
				1 => array('file', $this->stdoutfile, 'a'),
				2 => array('file', $this->stderrfile, 'a'),
			);

			$this->process = proc_open($this->generate_command_line(), $dsp, $this->pipes);
			$this->add_to_database();
		}

		protected function add_to_database()
		{
			$this->db->query(sprintf("INSERT INTO servers (sid, owner, json) VALUES('%s', %d, '%s')",
								$this->id, $this->owner, $this->db->real_escape_string($this->to_json())));
		}

		public function save()
		{
			$this->db->query(sprintf("INSERT INTO savedservers (owner, json) VALUES(%d, '%s')",
								$this->owner, $this->db->real_escape_string($this->to_json(true))));
		}

		public function send($command)
		{
			$f = fopen($this->pipes[0], 'w');
			fwrite($f, $command . '\n');
			fclose($f);
		}

		public function kill($reason = "Stopped by server owner")
		{
			$this->send(sprintf('kickall "%s"', $reason));
			$this->send('exit');
			$db->query("DELETE FROM `servers` WHERE `sid`='$this->id'");
		}

		public static function get_by_id($sid)
		{
			$db = getsql();
			$q = $db->query(sprintf("SELECT * FROM `servers` WHERE sid='%s'",
									$db->real_escape_string($sid)));

			$o = $q->fetch_object();

			return json_decode($o->json);
		}

		public static function get_user_servers($uid)
		{
			$db = getsql();
			$q = $db->query(sprintf("SELECT * FROM `servers` WHERE owner='%d'",
									$db->real_escape_string($uid)));

			$r = array();

			while ($o = $q->fetch_object())
			{
				array_push($r, json_decode($o->json));
			}

			return $r;
		}

		public static function get_user_saves($uid)
		{
			$db = getsql();
			$q = $db->query(sprintf("SELECT * FROM `savedservers` WHERE owner='%d'",
									$db->real_escape_string($uid)));

			$r = array();

			while ($o = $q->fetch_object())
			{
				array_push($r, json_decode($o->json));
			}

			return $r;
		}
	}
?>
