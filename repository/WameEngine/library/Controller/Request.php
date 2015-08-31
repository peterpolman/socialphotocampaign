<?php

class WE_Controller_Request
{
	protected $actionKey 		= null;
	protected $controllerKey 	= null;
	protected $systemKey 		= null;
	protected $requestMethod 	= null;
	protected $page				= null;
	protected $id				= null;
	protected $id2				= null;
	
	public static $DEFAULT_SYSTEMKEY		= "default";
	public static $DEFAULT_CONTROLLERKEY	= "dashboard";
	public static $DEFAULT_ACTIONKEY		= "index";
	
	function __construct()
	{	
		try {
			$this->setSystemKey($this->getGet('s',Config::get('install','defaultsystem')));
		} catch (Config_Exception $e) {
			$this->setSystemKey($this->getGet('s',self::$DEFAULT_SYSTEMKEY));
		}
		try {
			$this->setControllerKey($this->getGet('c', Config::get('install','defaultcontroller')));
		} catch (Config_Exception $e) {
			$this->setControllerKey($this->getGet('c', self::$DEFAULT_CONTROLLERKEY));
		}
		try {
			$this->setActionKey($this->getGet('a', Config::get('install','defaultaction')));
		} catch (Config_Exception $e) {
			$this->setActionKey($this->getGet('a', self::$DEFAULT_ACTIONKEY));
		}
		
		// Allow skipping the default system
		// Have we requested a system that doesn't exist?
		if ( !in_array($this->getSystemKey(),Config::get('install','systems')) ) {
			// Then shift all the fields one to the right
			try {
				$this->setSystemKey(Config::get('install','defaultsystem'));
			} catch ( Config_Exception $e ) {
				$this->setSystemKey(self::$DEFAULT_SYSTEMKEY);
			}
			try {
				$this->setControllerKey($this->getGet('s', Config::get('install','defaultcontroller')));
			} catch (Config_Exception $e) {
				$this->setControllerKey($this->getGet('s', self::$DEFAULT_CONTROLLERKEY));
			}
			try {
				$this->setActionKey($this->getGet('c', Config::get('install','defaultaction')));
			} catch (Config_Exception $e) {
				$this->setActionKey($this->getGet('c', self::$DEFAULT_ACTIONKEY));
			}
			$_GET['id3'] = $_GET['id2'];
			$_GET['id2'] = $_GET['id'];
			$_GET['id'] = $_GET['a'];
		}
		
	}
	
	function setMethod ($method = null)
	{
		$method = $this->getPost('_method', $method);
		
		if ($method == null)
		{
			$this->requestMethod  = $_SERVER['REQUEST_METHOD'];
		}
		else
		{
			$this->requestMethod  = $method;
		}
		
		return $this;
	}
	
	function getMethod ()
	{
		if ($this->requestMethod == null)
		{
			$this->setMethod();
		}
		
		return $this->requestMethod;
	}
	
	public function getRequestUri ()
	{
		echo $this->getServer('REQUEST_URI');
	}
	
	public function getTPLpath() {
		return $this->getSystemKey().'/'.$this->getControllerKey().'/'.$this->getActionKey().'.tpl';
	}
	
	public function getQueryString ()
	{
		echo $this->getServer('QUERY_STRING');
	}
	
	public function getParameter($key = null, $default = null)
	{
		if (!is_null($this->getGet($key)))
		{
			return $this->getGet($key);
		}
		elseif (!is_null($this->getPost($key)))
		{
			return $this->getPost($key);
		}
		elseif (!is_null($this->getSession($key)))
		{
			return $this->getSession($key);
		}
		elseif (!is_null($this->getCookie($key)))
		{
			return $this->getCookie($key);
		}
		else
		{
			return $default;
		}
	}
	
	function getFile($key = null)
	{
		if (isset($_FILES[$key]) && is_array($_FILES[$key]))
		{
			return $_FILES[$key];
		} else {
			return null;
		}
	}
	
	function getPost($key = null, $default = null, $html = false)
	{
		if ($key == null)
		{
			$res = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			return (empty($res)) ? $default : $res; 
		}

		if ($html == false)
		{
			$filter = FILTER_SANITIZE_STRING;
		} else	{
			$filter = FILTER_UNSAFE_RAW;
		}
		
		if (isset($_POST[$key]) && is_array($_POST[$key]))
		{
			return (is_null($_POST[$key])) ? $default : filter_var_array($_POST[$key], $filter) ;
		}
		elseif (isset($_POST[$key]))
		{
			return (is_null($_POST[$key])) ? $default : filter_var($_POST[$key], $filter);
		} else {
			return (empty($_POST[$key])) ? $default : filter_var($_POST[$key], $filter);
		}
	}
	
	function getGet($key = null, $default = null)
	{
		if ($key == null)
		{
			$res = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
			return (empty($res)) ? $default : $res; 
		}
		
		if (is_array($_GET[$key]))
		{
			return (empty($_GET[$key])) ? $default : filter_var_array($_GET[$key], FILTER_SANITIZE_STRING);
		}
		else
		{
			return (empty($_GET[$key])) ? $default : filter_var($_GET[$key], FILTER_SANITIZE_STRING);
		}
	}
	
	public function getServer($key = null, $default = null)
	{
		if ($key == null)
		{
			$res = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
			return (empty($res)) ? $default : $res; 
		}
		
		if (is_array($_SERVER[$key]))
		{
			return (empty($_SERVER[$key])) ? $default : filter_var_array($_SERVER[$key], FILTER_SANITIZE_STRING);
		}
		else
		{
			return (empty($_SERVER[$key])) ? $default : filter_var($_SERVER[$key], FILTER_SANITIZE_STRING);
		}
	}
	
	public function getCookie($key = null, $default = null)
	{
		if ($key == null)
		{
			$res = filter_input_array(INPUT_COOKIE, FILTER_SANITIZE_STRING);
			return (empty($res)) ? $default : $res; 
		}
		
		if (is_array($_COOKIE[$key]))
		{
			return (empty($_COOKIE[$key])) ? $default : filter_var_array($_COOKIE[$key], FILTER_SANITIZE_STRING);
		}
		else
		{
			return (empty($_COOKIE[$key])) ? $default : filter_var($_COOKIE[$key], FILTER_SANITIZE_STRING);
		}
	}
	
	public function getSession($key = null, $default = null)
	{
		if ($key == null)
		{
			$res = filter_input_array(INPUT_SESSION, FILTER_SANITIZE_STRING);
			return (empty($res)) ? $default : $res; 
		}
		
		if (isset($_SESSION[$key])) {
			if (is_array($_SESSION[$key]))
			{
				return (empty($_SESSION[$key])) ? $default : filter_var_array($_SESSION[$key], FILTER_SANITIZE_STRING);
			}
			else
			{
				return (empty($_SESSION[$key])) ? $default : filter_var($_SESSION[$key], FILTER_SANITIZE_STRING);
			}
		}
	}	
	
	public function getActionKey()
	{
		return $this->actionKey;
	}

	public function setActionKey($actionKey)
	{
		$this->actionKey = $actionKey;
		return $this;
	}
	
	public function setControllerKey($controllerKey)
	{
		$this->controllerKey = $controllerKey;
		return $this;
	}

	public function getControllerKey()
	{
		return $this->controllerKey;
	}
	
	public function setSystemKey($systemKey)
	{
		$this->systemKey = $systemKey;
		return $this;
	}

	public function getSystemKey()
	{
		return $this->systemKey;
	}
	
	/**
	 *  Hack for Wame CMS 3: Use the Request object to store a few more things
	 */
	
	// The page is the first parameter in the URL of the form
	// root/PageName
	public function setPage($page) {
		$this->page = $page;
	}
	public function getPage() {
		return $this->page;
	}
	
	// Page Parameters are parameters in the URL of the form
	// root/PageName/PageParameter1/PageParameter2
	public function setPageParameters($id,$id2) {
		$this->id = $id;
		$this->id2 = $id2;
	}
	public function getPageParameter1() {
		return $this->id;
	}
	public function getPageParameter2() {
		return $this->id2;
	}
	
	// Tag Parameters are parameters in the {module} tag of the form
	// {module::controller:action:TagParameter1=TagParameter2}
	public function setTagParameters($id,$id2) {
		$this->tagid1 = $id;
		$this->tagid2 = $id2;
	}
	public function getTagParameter1() {
		return $this->tagid1;
	}
	public function getTagParameter2() {
		return $this->tagid2;
	}
	
	// End of Wame CMS 3 hacks
	
	public function isPost($key = null)
	{
		if ($this->getMethod() == 'POST') {
			if ($key != null) {
				if (isset($_POST[$key])) {
					return true;	
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
		
		return false;
	}	

	public function isGet()
	{
		if ($this->getMethod() == 'GET') {
			return true;
		}
		
		return false;
	}	
	
	public function isPut()
	{
		if ($this->getMethod() == 'PUT') {
			return true;
		}
		
		return false;
	}	
	
	public function isDelete()
	{
		if ($this->getMethod() == 'DELETE') {
			return true;
		}
		
		return false;
	}

	public function isXMLHttpRequest()
	{
		if ($this->getServer('HTTP_X_REQUESTED_WITH', null) == 'XMLHttpRequest' || $this->getGet('json', false)) {
			return true;
		}
		
		return false;
	}	
}

?>