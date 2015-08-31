<?php

function details($data)
{
	WE_ErrorHandler::getInstance()->addDetails($data);
}

function WE_error_shutdown() {
	if(Config::get('install','debug') == true) {
		$error = error_get_last();
		if (WE_ErrorHandler::getInstance()->getShown() == false && !empty($error)) {
		    WE_ErrorHandler::getInstance()->addError($error['type'], $error['message'], $error['file'], $error['line']);
		    WE_ErrorHandler::getInstance()->showErrorMenu(true);
		}
	}
} 
	
function WE_error_handler($errno, $errstr, $errfile='', $errline=0, $errcontext=array()) {
	WE_ErrorHandler::getInstance()->addError($errno, $errstr, $errfile, $errline);
}

function WE_exception_handler($e)
{
	WE::getInstance()->include_library('ExceptionHandler');
	WE_ExceptionHandler::showReport($e,Config::get('install','debug'));
}

error_reporting(null);
register_shutdown_function("WE_error_shutdown");
set_exception_handler("WE_exception_handler");
set_error_handler("WE_error_handler");
?>