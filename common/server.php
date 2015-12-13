<?php
	include 'config.php';

	class Server
	{
		protected $binary			=	disciple_json()->main_binary;
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
		protected $id;

		protected $stdinfile;
		protected $stdoutfile;
		protected $stderrfile;

		protected $running			= 	false;

		protected $process;

		function __construct(
								$binary, $wads, $optwads, $iwad, $hostname,
								$protected, $owner, $gamemode, $config,
								$skill, $stdata, $instagib, $buckshot,
								$dmflags, $dmflags2, $zadmflags, $compatflags,
								$zacompatflags,

								// Optional stuff
								$id 			= null
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

			if ($id == null)
			{
				$this->id 				= sha256(time() + $owner + $skill + ($stdata ? 1 : 0) + ($instagib ? 1 : 0) + ($buckshot ? 1 : 0)  + $dmflags + $dmflags2 + $zadmflags + $compatflags + $zacompatflags + mt_rand());
			}
			else
			{
				$this->id 			=  $id;
			}

			$this->stdinfile 		= sprintf("%s/%s-stdin", disciple_json()->serverdata, $this->id);
			$this->stdoutfile 		= sprintf("%s/%s-stdout.log", disciple_json()->serverdata, $this->id);
			$this->stderrfile 		= sprintf("%s/%s-stderr.log", disciple_json()->serverdata, $this->id);
		}

		public static function fromJSON($json)
		{
			$d = json_decode($json);

			return new Server(
				$d->binary,
				$d->wads,
				$d->optwads,
				$d->iwad,
				$d->hostname,
				$d->protected,
				$d->owner,
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
				$d->id
			);
		}

		public function toJSON()
		{
			$a = array(
				'binary'			=>  $this->binary,
				'wads'				=>	$this->wads,
				'optwads'			=>	$this->optwads,
				'iwad'				=>	$this->iwad,
				'hostname'			=> 	$this->hostname,
				'protected'			=> 	$this->protected,
				'owner'				=>	$this->owner,
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
				'id'				=>	$this->id,

				// We export the stdXfiles for ease of access.
				// We don't import them as they're generated with the ID.
				'stdoutfile'		=> 	$this->stdoutfile,
				'stderrfile'		=>	$this->stderrfile,
				'stdinfile'			=>	$this->stdinfile
			);

			return json_encode($a);
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
			$dsp = array(
				0 => array('file', $this->stdinfile, 'a'),
				1 => array('file', $this->stdoutfile, 'a'),
				2 => array('file', $this->stderrfile, 'a'),
			);

			$this->process = proc_open($this->generate_command_line(), $dsp, $pipes);
		}
	}
?>
