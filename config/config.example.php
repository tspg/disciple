<?php $disciple_config = array(
 	/*
		This is an example configuration file.
		Fill it in and rename it to config.php.
	*/

	/////////////////////////////////////////////////////////////
	//   BACKEND   //////////////////////////////////////////////
	/////////////////////////////////////////////////////////////

	// MySQL username.
	'mysql_user' 			=> 'user',

	// MySQL user password.
	'mysql_pass' 			=> '',

	// MySQL database.
	'mysql_database' 		=> 'disciple',

	// MySQL hostname (usually localhost)
	'mysql_hostname' 		=> 'localhost',

	// MySQL port (usually 3306)
	'mysql_port'			=> 3306,

	/////////////////////////////////////////////////////////////
	//   USERS     //////////////////////////////////////////////
	/////////////////////////////////////////////////////////////

	// Encrypt user passwords
	// I really recommend your keep this 'true'
	'encrypt_passwords'		=> true,

	// Enable use of user 0 (root)
	// This user can do anything. It MUST be password protected (see 'root_user_password' below)
	// I recommend you only use this when setting up Disciple and when in emergency mode.
	'enable_root_user'		=> false,

	// You MUST change this if you have 'enable_root_user' set to 'true'.
	'root_user_password' 	=> 'root',

	/////////////////////////////////////////////////////////////
	//   SITE      //////////////////////////////////////////////
	/////////////////////////////////////////////////////////////

	// Set this to true, it proves you modified this file :)
	'cfgcheck1'				=> false
); ?>
