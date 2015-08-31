<?php
set_time_limit(600); 
$time_start = microtime(true);

// Determine root of project, start with my location, subtract /index.php
$wwwroot = substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/'));
// Subtract /r
$wwwroot = substr($wwwroot,0,strrpos($wwwroot,'/'));
// Remove leading / if present
if ( substr($wwwroot,0,1) == '/' )
	$wwwroot = substr($wwwroot, 1,strlen($wwwroot)-1);

// Construct new include path to WameEngine
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'].$wwwroot.'/repository/WameEngine/');

// Initialize configuration
require_once('library/Config.php');
Config::init($_SERVER['DOCUMENT_ROOT'].$wwwroot.'/repository/resources/',$wwwroot);

// Fire up the engine
require_once 'WameEngine.php';
$engine = WE::getInstance();
$engine->load();

// Fire up helpers
$engine->include_adapter('ErrorHandler');
//$engine->include_adapter('Common_functions');
$engine->include_adapter('Helper');
$engine->include_language('default');

$engine->include_library('Db');
$engine->database 	= Db::getInstance();
$engine->ignite();

$engine->include_library('Auth');

// Handle the request
try {	
	
	$engine->controller_front->init();
	
} catch (Exception $e) {
	// Catch and show exceptions if something goes wrong
	$mtime 				= microtime(true) - $time_start;
	$engine->include_library('ExceptionHandler');
	WE_ExceptionHandler::showReport($e,Config::get('install','debug'));
}

// Commit changes to database if all went well
Db::getInstance()->finishTransaction();

// Show debug output if required
if (Config::get('install','debug') == true)
{
	$mtime = microtime(true) - $time_start;
	WE_ErrorHandler::getInstance()->setMtime($mtime);
	if ( !WE_ErrorHandler::getInstance()->getShown() )
		WE_ErrorHandler::getInstance()->showErrorMenu();
}
?>