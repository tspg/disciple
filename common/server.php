<?php
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
}
?>
