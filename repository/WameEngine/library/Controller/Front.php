<?php
class WE_Controller_Front
{
	/**
	 * Instance of WE_Controller_Front
	 */
	protected static $_instance = null;
	protected 	$request = null;		// Contains WE_Controller_Request object
	/**
	 * @var WE_Controller_Request|null $request
	 */
	protected 	$response = null;		// Contains WE_Controller_Response object
	private 	$layout = null;
	protected 	$useLayout = true;
	protected 	$layoutTemplate = 'layout.tpl';

	private $controllerClassSuffix 	= 'Controller';
	private $headerClassSuffix 		= 'Header';
	private $actionFunctionSuffix 	= 'Action';					
	private $controllerDirectory 	= null;			// Controllerdirectory relative to this class
	private $headerDirectory 		= null;	// Headerdirectory relative to this class
	
	private $forceController 		= null;
	private $forceAction			= null;
	
    private function __clone()
    {
    }

    /**
     * Enforce singleton; disallow cloning
     *
     * @return WE_Controller_Front
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    public function setFooter($footer) {
    	$this->footer = $footer;
    }
    
    public function useLayout ($bool)
    {
    	$this->useLayout = $bool;
    }
    
    public function hasLayout ()
    {
    	return $this->useLayout;
    }
	
	public function getControllerDirectory()
	{
		return $this->controllerDirectory;
	}
	
	public function getHeaderDirectory()
	{
		return $this->headerDirectory;
	}
	
	public function getControllerName($controllerKey = null)
	{
		if (is_null($controllerKey))
		{
			return $this->getRequest()->getControllerKey().$this->controllerClassSuffix;
		}
		else
		{
			return $controllerKey.$this->controllerClassSuffix;
		}
	}
	
	public function getHeaderName($headerKey = null)
	{
		if (is_null($headerKey)) {
			throw new WE_Controller_Front_Exception('No header has been set!');
		} else {
			return $headerKey.$this->headerClassSuffix;
		}
	}
	
	public function getActionName($actionKey = null)
	{
		if (is_null($actionKey))
		{
			return $this->getRequest()->getActionKey().$this->actionFunctionSuffix;
		}
		else
		{
			return $actionKey.$this->actionFunctionSuffix;
		}	
	}
	
	/**
	 * @return WE_Controller_Request
	 */
	public function getRequest()
	{
		if (is_null($this->request)) {
			WE::include_library('Controller/Request');
			$this->request = new WE_Controller_Request();
		}
		
		return $this->request;
	}

	public function getResponse()
	{
		if (is_null($this->response)) {
			WE::include_library('Controller/Response');
			$this->response = new WE_Controller_Response();
		}
		
		return $this->response;
	}
	

	public function dispatch ($systemKey = null, $controllerKey = null, $actionKey = null)
	{
		
		$currentControllerPath = $this->getControllerDirectory().$systemKey.'/'.$controllerKey.'.php';
		if (!is_readable($currentControllerPath)) {

			
			$system = Config::get('install','defaultsystem');
			$currentControllerPath = $this->getControllerDirectory().$system.'/'.$controllerKey.'.php';
			
			if (!is_readable($currentControllerPath) && $controllerKey == 'login') {
				//$loginpage = ;
				$currentControllerPath = $this->getControllerDirectory().Config::get('install','loginpage').'.php';
			}
		}
		
		if (is_readable($currentControllerPath)) {
		
			WE::include_library('Controller');
			require_once $currentControllerPath;
			
			if (class_exists($this->getControllerName($controllerKey))) {
				
				// Controller class is correct	
				$className = $this->getControllerName($controllerKey);
				$controller = new $className();	
				
				if (!($controller instanceof WE_Controller)) {
					WE::include_library('Controller/Front/Exception');
					throw new WE_Controller_Front_Exception('Controller "'.$this->getControllerName($controllerKey).'" is not an instance of WE_Controller');
				}
				
				if (is_callable(array($controller, $this->getActionName($actionKey)))) {
					
					//TODO: Guido-> Controller exists but not an action. Load defaultcontroller + action
					
					// Action exists
					$actionName = $this->getActionName($actionKey);
					

					if (WE_Access::getInstance()->hasAccess($systemKey, $controllerKey, $actionKey) == false && !$controller->getPublic()) {
						WE::include_library('Controller/Front/Exception');
						throw new WE_Controller_Front_Exception('U heeft geen rechten voor de opgegeven pagina!');
					}
					
					$actionOutput = $controller->{$actionName}($this->getRequest());					
					WE::include_library('View');
					
					if ($actionOutput == WE_View::NONE) {
						$this->getResponse()->send();
						Db::getInstance()->finishTransaction();
						exit();
					}
					else {
						return $actionOutput;
					}
				}
				else {
					WE::include_library('Controller/Front/Exception');
					throw new WE_Controller_Front_Exception('Action \'<i>'.$this->getActionName($actionKey).'</i>\' does not exist in class \''.$this->getControllerName($controllerKey).'\' (path = '.$currentControllerPath.').');
				}
				
			}
			else {
				WE::include_library('Controller/Front/Exception');
				throw new WE_Controller_Front_Exception('Requested controller file has a wrong classname.');
			}
		}
		else {
			WE::include_library('Controller/Front/Exception');
			throw new WE_Controller_Front_Exception('Controller \'<i>'.$this->getControllerName((isset($controller) ? $controller : null)).'</i>\' (path = '.$currentControllerPath.') does not exist.');
		}
	}
	
	public function dispatchHeader ($headerKey = null)
	{
		
		$currentHeaderPath = $this->getHeaderDirectory().$headerKey.'/dispatcher.php';
		if (!is_readable($currentHeaderPath)) {
			$currentHeaderPath = $this->getHeaderDirectory().'default/dispatcher.php';
			$headerKey = 'default';
			$request = $this->getRequest(); /* @var $request WE_Controller_Request */
			$request->setControllerKey('error');
			$request->setActionKey('systemNotFound');
		}

		if (is_readable($currentHeaderPath)) {
			WE::include_library('Controller');
			require_once $currentHeaderPath;
			
			
			if (class_exists($this->getHeaderName($headerKey))) {
				// Controller class is correct	
				$className = $this->getHeaderName($headerKey);
				
				$header = new $className();	
				
				if (!($header instanceof WE_Controller)) {
					WE::include_library('Controller/Front/Exception');
					throw new WE_Controller_Front_Exception('Controller "'.$this->getHeaderName($headerKey).'" is not an instance of WE_Controller');
				}
				
				if (is_callable(array($header, 'header'))) {
					// Header exists
					WE::include_library('View');
					$actionOutput = $header->header();

					if ($actionOutput == WE_View::NONE) {
						$this->getResponse()->send();
						exit();
					}
	
					return $actionOutput;
				}
				else {
					WE::include_library('Controller/Front/Exception');
					throw new WE_Controller_Front_Exception('Header does not exist in class \''.$this->getHeaderName($headerKey).'\' (path = '.$currentHeaderPath.').');
				}
				
			}
			else {
				WE::include_library('Controller/Front/Exception');
				throw new WE_Controller_Front_Exception('Requested header file has a wrong classname.');
			}
		}
		else {
			WE::include_library('Controller/Front/Exception');
			throw new WE_Controller_Front_Exception('Controller \'<i>'.$this->getHeaderName((isset($header) ? $header : null)).'</i>\' (path = '.$currentHeaderPath.') does not exist.');
		}
	}
	

	public function getLayoutView ()
	{
		if (is_null($this->layout))
		{
			WE::include_library('View');
			$this->layout = new WE_View();
		}
		
		return $this->layout;
	}
	
	public function setLayout ($template)
	{
		$this->layoutTemplate = $template;
		return $this;
	}
	
	public function getLayout ()
	{
		return $this->layoutTemplate;
	}
	
	public function setForceController($controller)
	{
		$this->forceController = $controller;
	}

	public function setForceAction($action)
	{
		$this->forceAction = $action;
	}
	
	public function init ()
	{	
	    $this->controllerDirectory 	= Config::get('install','resourcedir').'controller/';
	    $this->headerDirectory 		= Config::get('install','resourcedir').'controller/';

		$request = $this->getRequest();

		$layout = $this->getLayoutView();

		$layout->assign('header',$this->dispatchHeader($request->getSystemKey()));

		$layout->assign('body',	$this->dispatch($request->getSystemKey(),$request->getControllerKey(), $request->getActionKey()));
		$layout->assign('flash', WE_Engine_Session::getFlash());
		
		$response = $this->getResponse()->appendBody($layout->render($request->getSystemKey()."/layout/layout.tpl"));
		$response->send();

		return $this;
	}
}
?>