<?php

WE::include_library('Controller/Crud');
define('NONE','NONE', false);
define('CREATE','CREATE', false);
define('READ','READ', false);
define('UPDATE','UPDATE', false);
define('DELETE','DELETE', false);
define('ADMIN','ADMIN', false);

class WE_Controller
{
	/**
	 * Instance of WE_View
	 */
	protected $view;
	
	protected $layout = null;
	protected $access = -1;
	protected $public = false;
	
	function __construct()
	{
		WE::include_library('View');
		$this->view = new WE_View();
		
		WE::include_library('Controller/Front');
		$this->layout = WE_Controller_Front::getInstance()->getLayoutView();
	}
	
    /**
     * Instance of WE_Controller_Front
     *
	 * @return WE_Controller_Front
     */
	public function getFrontController ()
	{
		return WE_Controller_Front::getInstance();
	}
	
	/**
	 * Instance of Tih_Session
	 *
	 * @return Tih_Session
	 */
	public function getSession ()
	{
		if (class_exists('Tih_Session')) {
			return Tih_Session::getInstance();
		} else {
			return null;	
		}
	}
	
    /**
     * Instance of WE_Controller_Request
     *
	 * @return WE_Controller_Request
     */
	public function getRequest ()
	{
		return WE_Controller_Front::getInstance()->getRequest();
	}
	
    /**
     * Returns an instance of WE_Controller_Response
     *
	 * @return WE_Controller_Response
     */
	public function getResponse ()
	{
		return WE_Controller_Front::getInstance()->getResponse();
	}
	
    /**
     * Sets the access value, needed to make sure every Action has a security check
     *
     * @param string $access
     * @return void (header redirect)
     */
	
	protected function setAccess($access)
	{
		$this->access = $access;
	}
	
    /**
     * Gets the access value, needed to make sure every Action has a security check
     * 
     * @return int $access
     */
	
	public function getAccess()
	{
		return $this->access;
	}
	
	public function getPublic() {
		return $this->public;
	}
	
    /**
     * Redirect to an uri, if $system = true an internal link is used
     *
     * @param string $uri
     * @param string $system
     * 
     * @return void (header redirect)
     */
	
	public function redirect ($uri, $system = true)
	{
		if ($system == true) {
			$result = explode('/',$uri);
			if (isset($result[0]) && isset ($result[1]) && $result[0] != 'system') {
				$action = ((isset($result[2]) && !empty($result[2])) ? $result[2] : 'index');
				// 11-2-2013: Uitgecomment door Tim en Michel omdat het errors oplevert bij inloggen :(
				/*if (!WE_Access::getInstance()->hasAccess($result[0],$result[1], $action)) {
					WE::include_library('Controller/Exception');
					throw new WE_Controller_Exception('Trying to redirect to a page that you are not allowed to view: '.$uri);
				}*/
			}
		}
		WE_Controller_Front::getInstance()->getResponse()->redirect($uri, $system);
	}
	
	public function useLayout ($bool)
	{
		WE_Controller_Front::getInstance()->useLayout($bool);
	}
	
	public static function getPublicStatic() {
		$vars = get_class_vars(get_called_class());
		if ( array_key_exists('public', $vars) )
			return $vars['public'];
		else
			return false;
	}
	
}

?>