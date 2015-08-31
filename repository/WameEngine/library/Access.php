<?php
class WE_Access
{	
	protected static 	$_instance = null;
	
	private 			$userSession;
	protected			$aRoles = null;
	private 			$aList = array();
	private 			$aAccess = array();
	private				$rAccess = array();
	private				$role = null;
	
	private $options = array('NONE','READ','CREATE','UPDATE','DELETE','ADMIN');
	
	private static $NONE 	= 0;
	private static $READ 	= 1;
	private static $CREATE 	= 2;
	private static $UPDATE 	= 4;
	private static $DELETE 	= 8;
	private static $ADMIN 	= 16;
	
    /**
     * Enforce singleton; disallow cloning
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Enforce singleton; disallow cloning
     *
	 * @return WE_Access
     */
    public static function getInstance($role = null)
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        	if (!empty($role)) {
				self::$_instance->setRole($role);
			}
			self::$_instance->init();
        }

        return self::$_instance;
    }
    
    public function setRole($role) {
    	if (!empty($role)) {
    		$this->role = $role;
    	} else {
			WE::include_library('Exception');
			throw new WE_Exception('Illegal role');
    	}
    }
    
    function init() {

       	$this->userSession = WE_Engine_Session::getNamespace('Auth');
       	if ( !is_object($this->role) ) {
       		if ( isset($this->userSession->user_id) ) {
	       		$this->setRole(Db::getModel(Config::get('install','userdb'))->getRoleByUserId($this->userSession->user_id));
       		} else {
       			return false;
       		}
       	}
   		$roleright = Db::getTable(Config::get('install','rolerightdb'))->getRightsByRole($this->role->getId());
   		
   		$totalRole = array();
   		foreach($roleright->getResult() as $right)
   		{
 			$totalRole[$right->getController()] = (isset($totalRole[$right->getController()]) ? ($totalRole[$right->getController()] | $right->getRights()) : $right->getRights());
   		}

		$this->setReadableAccess($totalRole);
		$this->userSession->rights = $totalRole;
		
		$this->rAccess = array();
		
		//$core_rolerights = Db::getTable(Config::get('install','rolerightdb'));
		//$core_rolerights->getRightsByRole($this->role->getId());
		foreach($roleright->getResultArray(true) as $right) {
			if (!empty($right['action'])) {
				$this->rAccess[$right['system']][$right['controller']][$right['action']] = $right['rights'];
			}
		}
    }
    
    /**
     * Constructor of WE_Access
     * 
     * @return void
     */
    function __construct()
    {
    	
    }
	
    /**
     * Part of the Constructor of WE_Access
     *
     * @param array $totalRole
     */
	private function setReadableAccess($totalRole)
	{
		$accessarray = array();
		
		foreach($totalRole as $page=>$num)
		{
			foreach($this->options as $option)
			{
				if ($num & WE_Access::$$option)
				{
					$accessarray[$page][$option] = true;
				} else {
					$accessarray[$page][$option] = false;
				}
			}
		}

		$this->aAccess = $accessarray;
	}
	
    /**
     * Gets the current accessdata
     *
     * @return array $aAccess
     */
    public function toArray () {
    	return $this->aAccess;
    }
    
    /**
     * Checks if the current user has the right to access $system / $controller / $action
     * 
     * @param String $system
     * @param String $controller
     * @param String $action
     */
    public function hasAccess($system,$controller,$action) {
    	
    	if (!empty($this->rAccess) &&
    		array_key_exists($system, $this->rAccess) &&
    		array_key_exists($controller, $this->rAccess[$system]) &&
    		array_key_exists($action, $this->rAccess[$system][$controller]) ) {
    		if (intval($this->rAccess[$system][$controller][$action]) === 1) {
    			return true;
    		} else {
    			return false;
    		}
    	} else {
    		return false;
    	}
    }

	
    /**
     * Redirects the current user if it hasn't got the $right on $page
     *
     * @param string $page
     * @param string $right
     * @return $right|redirect to secure root
     */
	public function allowAccess($page, $right)
	{	
		details('allowAccess function is no longer used! Please remove!');
		return $right;
	}
}

?>