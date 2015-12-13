<?php
	include 'config.php';

	class Server
	{
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

		function __construct(
								$wads, $optwads, $iwad, $hostname,
								$protected, $owner, $gamemode, $config,
								$skill, $stdata, $instagib, $buckshot,
								$dmflags, $dmflags2, $zadmflags, $compatflags,
								$zacompatflags
							)
		{
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

			$this->id 				= sha256(time() + $owner + $skill + ($stdata ? 1 : 0) + ($instagib ? 1 : 0) + ($buckshot ? 1 : 0)  + $dmflags + $dmflags2 + $zadmflags + $compatflags + $zacompatflags);

			$this->stdinfile 		= sprintf("%s/%s-stdin", disciple_json()->serverdata, $this->id);
			$this->stdoutfile 		= sprintf("%s/%s-stdout.log", disciple_json()->serverdata, $this->id);
			$this->stderrfile 		= sprintf("%s/%s-stderr.log", disciple_json()->serverdata, $this->id);
		}

		public static function fromJSON($json)
		{
			$d = json_decode($json);

			return new Server(
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
				$d->zacompatflags
			);
		}

		public function toJSON()
		{
			$a = array(
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
				'zacompatflags'		=>	$this->zacompatflags
			);

			return json_encode($a);
		}
	}
?>
