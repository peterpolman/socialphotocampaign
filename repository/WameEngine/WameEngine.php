<?php
/**
 * WE Engine
 *
 */
class WE {

	private static 		$_instance;
	
	/**
	 * Instance of Db
	 */
	public $database;

	/**
	 * Instance of WE_Controller_Front
	 */
	public $controller_front;
	
	public $default_lang;
	
	protected $system = 'default';
	
	protected $engineRoot;


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
     * @return WE
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
            ob_start();
        }
		
        return self::$_instance;
    }

	/**
	 * Destructor
	 */
	public function __destruct() {
		// write sessions before database connection is closed
		session_write_close();
	}
	
	public function getRoot() {
		return $this->engineRoot;
	}
	
	public function load() {
		$this->engineRoot = Config::get('install','engineroot');
		$this->include_library('ErrorHandler');
		$this->include_library('Log');
		$this->include_library('Models/Db/Record');
		$this->include_library('Models/Remote/Record');
	}
    
    public function ignite()
    {
		$this->include_library('Session');
		WE_Engine_Session::start();

		$this->include_library('Controller/Front');
		$this->controller_front = WE_Controller_Front::getInstance();
		$this->include_library('Access');
    }
	
	/**
	 * Wame
	 * Includes PHP file for specified library class
	 *
	 * @param string $classname
	 */
	public static function include_library($classname) {
		if ($classname != 'Config' && file_exists(Config::get('install','resourcedir').'adapter/WE_Overrides/'.$classname.'.php')) {
			require_once(Config::get('install','resourcedir').'adapter/WE_Overrides/'.$classname.'.php');
		} else {
			if (file_exists(WE::getInstance()->getRoot().'library/'.$classname.'.php')) {
				require_once(WE::getInstance()->getRoot().'library/'.$classname.'.php');
			} else {
				//WE::include_library('Config/Exception');
				//throw new Config_Exception('The library does not exist.');
				if ( Config::get('install','debug') ) {
					echo '<pre>';
					print_r(debug_backtrace());
					echo '</pre>';
					die("The library $classname does not exist.");
				} else {
					die();
				}
			}
		}
	}
	
	/**
	 * Wame
	 * Includes PHP file for specified library class
	 *
	 * @param string $classname
	 */
	public static function include_adapter($classname) {
		if (file_exists(Config::get('install','resourcedir').'adapter/'.$classname.'.php')) {
			require_once(Config::get('install','resourcedir').'adapter/'.$classname.'.php');
		} else {
			WE::include_library('Config/Exception');
			throw new Config_Exception('The adapter does not exist.');
		}
	}
	
	/**
	 * Wame
	 * Includes PHP file for specified supercontroller class
	 *
	 * @param string $controller
	 */
	public static function include_supercontroller($controller) {
			if (file_exists(Config::get('install','resourcedir').'controller/'.self::$_instance->system.'/supercontroller/'.$controller.'.php')) {
			require_once(Config::get('install','resourcedir').'controller/'.self::$_instance->system.'/supercontroller/'.$controller.'.php');
		} else {
			WE::include_library('Config/Exception');
			throw new Config_Exception('The supercontroller does not exist.');
		}
	}
	
	/**
	 * Wame
	 * Includes PHP file for specified table class
	 *
	 * @param string $table
	 */
	public static function include_table($table) {
		if (file_exists(Config::get('install','resourcedir').'table/'.$table.'Table.php')) {
			require_once(Config::get('install','resourcedir').'table/'.$table.'Table.php');
		} else {
			WE::include_library('Config/Exception');
			throw new Config_Exception('The table does not exist.');
		}
	}
	
	/**
	 * Wame
	 * Includes PHP file for specified model class
	 *
	 * @param string $model
	 */
	public static function include_model($model) {
		WE::include_library('Models/Db/Record');		// Local records
		//WE::include_library('Db/Record'); 		// Remote records		
		if (file_exists(Config::get('install','resourcedir').'model/'.$model.'.php')) {
			require_once(Config::get('install','resourcedir').'model/'.$model.'.php');
		} else {
			if (Config::get('install','debug') == false) {
				WE::include_library('Config/Exception');
				throw new Config_Exception('The model ('.$model.') does not exist.');
			} else {
				WE::include_library('Db/Creator');
				//$creator = new WE_Db_Creator(self::getInstance()->database);
				$creator = new WE_Db_Creator(Db::getInstance());
				$creator->createModel($model);
				require_once(Config::get('install','resourcedir').'model/'.$model.'.php');
			}
		}
	}
	
	/**
	 * Wame
	 * Includes PHP file for specified model class
	 *
	 * @param string $model
	 */
	public function include_language($language) {
		if (file_exists(Config::get('install','resourcedir').'lang/'.$language.'.php')) {
			include_once(Config::get('install','resourcedir').'lang/'.$language.'.php');
			$this->default_lang = $lang;
		} else {
			WE::include_library('Config/Exception');
			throw new Config_Exception('The language file ('.$language.') does not exist.');
		}
	}
	
	/**
	 * Wame
	 * Includes PHP file for specified dependency class
	 *
	 * @param string $classname
	 */
	public static function include_dependency($classname) {
		if (file_exists(WE::getInstance()->getRoot().'dependency/'.$classname.'.php')) {
			require_once('dependency/'.$classname.'.php');
		} else {
			WE::include_library('Config/Exception');
			throw new Config_Exception('The dependency `'.$classname.'` does not exist.');
		}
	}
	
	/**
	 * Monito
	 * Redirects user to specified URL (and exits)
	 *
	 * @param string $url
	 */
	public static function redirect($url) {
		if ((WE_ErrorHandler::getInstance()->allowRedirect() && Config::get('install','debug') == true) || Config::get('install','debug') == false) {
			
			if (Db::getInstance()->hasActiveTransaction())
			{
				Db::getInstance()->commitTransaction();
			}
			
			if (class_exists("WE_Engine_Session")) {
				WE_Engine_Session::save();
			} else {
				session_write_close();
			}
			
			header('Location: '.(string) $url);
			exit;
		} else {
			WE_ErrorHandler::getInstance()->triedRedirect(true);
		}
	}
}

?>