<?php

class WE_Engine_Session_Namespace 
{
	protected $_namespace = null;
	protected $_locked = false;
	
	private static $_namespaces = array();
	
	public function __construct($namespace)
	{
		if (!in_array($namespace, self::$_namespaces))
		{
			self::$_namespaces[] = $namespace;
		}
		else
		{
			//WE::include_library('Session/Exception');
			//throw new WE_Engine_Session_Exception('A session namespace called "'.$namespace.'" has already been instantiated.');
		}
		
		$this->_namespace = $namespace;
	}
	
	public function __toString ()
	{
		return $this->_namespace;
	}
	
	public function __set($name, $value) 
	{
		if (!$this->_locked)
		{
			$name = (string) $name;
			$_SESSION[$this->_namespace][$name] = $value;
		}
	}
	
	public function __get($name) 
	{
		$name = (string) $name;
		return (isset($_SESSION[$this->_namespace][$name]) ? $_SESSION[$this->_namespace][$name] : null);
	}
	
	public function __isset($name)
	{
		return isset($_SESSION[$this->_namespace][$name]);
	}	
	
	public function __unset($name)
	{
		if (!$this->_locked)
		{
			unset($_SESSION[$this->_namespace][$name]);
		}
	}	
		
	public function lock ()
	{
		$this->_locked = true;
	}
	
	public function unlock ()
	{
		$this->_locked = false;
	}
}

?>