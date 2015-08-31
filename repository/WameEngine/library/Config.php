<?php
class Config
{
	private static $config = array();
	
	public static function init ($resourcedir, $wwwroot)
	{
		if (empty($resourcedir)) {
			self::throwException('No resourcedir specified.');
		}

		require_once($resourcedir.'config/config.php'); 
		foreach( $config as $group=>$configgroup ) {
			if ( is_array($configgroup) ) {
				foreach ( $configgroup as $line=>$configline ) {
					$config[$group][$line] = str_replace('%WWWROOT%',$wwwroot,$configline);
				}
			} else {
				$config[$group] = str_replace('%WWWROOT%',$wwwroot,$configgroup);
			}
		}
		self::$config = $config;
		unset($config);
	}
	
	public static function get($group,$key = null)
	{
		$return = null;
		if ($key == null)
		{
			if (isset(self::$config[$group]))
			{
				$return = self::$config[$group];
			} else {
				self::throwException('The config group "'.$group.'" does not exist.');
			}
		}
		else
		{
			if (isset(self::$config[$group][$key]))
			{
				$return = self::$config[$group][$key];
			} else {
				self::throwException('The config group -> key ("'.$group.'"->"'.$key.'") combination does not exist.');
			}
		}
		
		return($return);
	}
	
	private static function throwException($message) {
		if ( class_exists('WE') && method_exists( 'WE', 'include_library' ) ) {
			WE::include_library('Config/Exception');
			throw new Config_Exception($message);
		} else {
			die($message);
		}
	}
}

?>