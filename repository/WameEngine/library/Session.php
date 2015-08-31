<?php
WE::include_library('Session/Namespace');

class WE_Engine_Session 
{
	private static $_sessionStarted = false;
	private static $_sessionDestroyed = false;
	
	public static function start ()
	{
		// Check if session already started
		if (self::$_sessionStarted) {
			return true;
		}
		
		session_name(Config::get('session','name'));
		session_start();
		self::$_sessionStarted = true;	
	}
	
	public static function unsetNamespace ($namespace)
	{
		unset($_SESSION[$namespace]);
	}
	
	public static function getNamespace($namespace) {
		return new WE_Engine_Session_Namespace($namespace);
	}
	
	public static function stop ()
	{
	}
	
	public static function destroy ()
	{
		session_destroy();
	}
	
	public static function save() {
		session_write_close();
	}
	
	public static function setFlash($msg, $type)
	{
		$flash = self::getNamespace("_flashMessage");
		$flash->message = $msg;
		$flash->type = $type;
	}
	
	public static function getFlash ()
	{
		$flash = self::getNamespace("_flashMessage");
		if (isset($flash->message) && isset($flash->type)) {
			$return = array('message' => $flash->message, 'type' => $flash->type);
			self::unsetNamespace('_flashMessage');
		} else
			$return = null;
		return $return;
	}
}

?>