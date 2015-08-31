<?php
$config = array();

// Your WameFrame settings
$config['install']['naam']				= 'I-KOOK Keukens';
$config['install']['version']			= '1.0';
$config['install']['debug']				= false;
$config['install']['systems']			= array('system','devtools','beheer','front');
$config['install']['defaultsystem'] 	= 'front';
$config['install']['defaultcontroller'] = 'dashboard';
$config['install']['defaultaction'] 	= 'index';
$config['install']['systemtitle']		= 'system';
$config['install']['loginpage']			= 'system/login';
$config['install']['file_upload_dir']	= '../files/';
$config['install']['datetimeformat']	= 'Y-m-d H:i:s';

// Database settings
// $config['db']['host'] 					= 'localhost';									// Host URL of IP van de mysql server.
// $config['db']['username'] 				= 'ikookdisru_gbkr4';										// Gebruikersnaam voor de database.
// $config['db']['password'] 				= 'yK65BZsX';									// Wachtwoord voor de database.
// $config['db']['database'] 				= 'ikookdisru_dtb3';										// Database.
$config['db']['host'] 					= 'localhost';									// Host URL of IP van de mysql server.
$config['db']['username'] 				= 'opk';										// Gebruikersnaam voor de database.
$config['db']['password'] 				= 'opk';									// Wachtwoord voor de database.
$config['db']['database'] 				= 'opk';										// Database.

// Security settings
$config['auth']['maxloginattempts']		= 300000000000;

// Languages
$config['language'][0]					= 'NL';
$config['language'][1]					= 'DE';
$config['language'][2]					= 'EN';
$config['language'][3]					= 'FR';
$config['language_default']				= 0;

$config['communication']['connect']		= false;

// Contact form settings
$config['contact']['mailto']			= "info@dekeukenvooriedereen.nl";
$config['contact']['mailfrom']			= "no-reply@opknappertjenodig.nl";
$config['contact']['subject']			= "Formulier ingevuld op opknappertjenodig.nl";

// Actiecode form settings
$config['actiecode']['mailto']			= "info@dekeukenvooriedereen.nl";
$config['actiecode']['mailfrom']		= "no-reply@opknappertjenodig.nl";
$config['actiecode']['subject']			= "Actiecode ingevuld op opknappertjenodig.nl";

/** Usually no need to touch these **/

if (isset($_SERVER['HTTPS'])) {
	$config['install']['secure_root'] 	= "https://".$_SERVER['SERVER_NAME']."/%WWWROOT%";		// Veilige root voor alle URLs intern.
} else {
	$config['install']['secure_root'] 	= "http://".$_SERVER['SERVER_NAME']."/%WWWROOT%";		// Veilige root voor alle URLs intern.
}
$config['install']['absolute_root']		= $_SERVER['DOCUMENT_ROOT'];				// Absolute root voor alle URLs backend.
$config['install']['resourcedir']		= $_SERVER['DOCUMENT_ROOT'].'%WWWROOT%/repository/resources/';
$config['install']['filesdir']			= $_SERVER['DOCUMENT_ROOT'].'%WWWROOT%/repository/resources/files/';
$config['install']['engineroot']		= $_SERVER['DOCUMENT_ROOT'].'%WWWROOT%/repository/WameEngine/';
$config['install']['loginsdb']			= 'wame_core_logins';
$config['install']['roledb']			= 'wame_core_role';
$config['install']['rolerightdb']		= 'wame_core_roleright';
$config['install']['userdb']			= 'wame_core_user';
$config['install']['userroledb']		= 'wame_core_userrole';
$config['session']['name']				= sha1($config['install']['naam'].$config['install']['secure_root']);

?>