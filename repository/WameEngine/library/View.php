<?php
class WE_View 
{
	private static $_instance;
	const NONE = 1;
	
	/**
	 * Instance of WE_Smarty()
	 */
	private $engine = null;
	
    /**
     * Build the view
     * 
     */
	function __construct()
	{

		// Load Smarty
		WE::include_library('Smarty');
		$this->engine = new WE_Smarty();

		// Configure Smarty
		$this->engine->template_dir = Config::get('install','resourcedir').'view/tpl';
		$this->engine->compile_dir  = Config::get('install','resourcedir').'view/cache';
		$this->engine->cache_dir    = Config::get('install','resourcedir').'view/cSmarty';

		$this->engine->caching		= 0;
		$this->engine->debugging 	= false;
		
		$this->engine->compile_check = true; 
		$this->engine->force_compile = false;
		
		WE::include_library('Smarty/Helpers');
		$this->engine->register_function('Access', 'WE_has_access');
		$this->engine->register_function('Encrypt', 'Smarty_Encrypt');
		$this->engine->register_function('Decrypt', 'Smarty_Decrypt');
		$this->engine->assign('absolute_root',Config::get('install','absolute_root'));
		$this->engine->assign('secure_root',Config::get('install','secure_root'));
		$this->engine->assign('app_name',Config::get('install','naam'));
		$this->engine->assign('app_version',Config::get('install','version'));
		$this->engine->assign('WE_date','%d-%m-%Y');
		$this->engine->assign('WE_time','%H:%M:%S');
		$this->engine->assign('WE',WE::getInstance());
		
		
		$request = WE_Controller_Front::getInstance()->getRequest();
		$this->engine->assign('action',$request->getActionKey());
		$this->engine->assign('controller',$request->getControllerKey());
		$this->engine->assign('system',$request->getSystemKey());
		$this->engine->assign('64url',$this->base64link($request));
		
		unset($request);
	}
	
	private function base64link($request)
	{
		$c = $request->getControllerKey();
		$a = $request->getActionKey();
		$id1 = $request->getGet('id');
		$id2 = $request->getGet('id2');
		$id3 = $request->getGet('id3');
		
		$link = $c."/".$a."/";
		if ($id1 !== null) {$link .= $id1.'/';}
		if ($id2 !== null) {$link .= $id2.'/';}
		if ($id3 !== null) {$link .= $id3.'/';}
		
		return base64_encode($link);
	}
	
    /**
     * Enforce singleton; disallow cloning
     *
     * @return WE_View
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
		
        return self::$_instance;
    }
	
    /**
     * Returns the Smarty engine
     *
     * @return WE_Smarty
     */
	public function getEngine()
	{
		return $this->engine;
	}
	
    /**
     * Assign a variable to the smarty engine
     * @param string $key
     * @param string $value
     *
     * @return void
     */
	public function assign ($key, $value = null)
	{
		if (is_array($key))
		{
			foreach ($key as $var => $value)
			{
				$this->engine->assign($var, $value);
			}
		}
		else
		{
			$this->engine->assign($key, $value);
		}
	}

    /**
     * Let the smarty engine render a template
     * @param string $template
     *
     * @return template
     */
	public function render($template = null)
	{
		$request = WE_Controller_Front::getInstance()->getRequest();
		if (empty($template)) {
			$template = $request->getTPLpath();
		}
		
		if (!file_exists(Config::get('install','resourcedir').'view/tpl/'.$template)) {
			$tempPieces = explode('/',$template);
			$template = Config::get('install','resourcedir').'view/tpl/';
			
			// 11-2-2013: Uitgecomment door Tim. Waarom zou het voor login anders moeten werken? We willen ook op login kunnen differentiëren op systeem
			/*if ($request->getControllerKey() == 'login') {
				$template .= Config::get('install','systemtitle').'/';
			} else {*/
				$template .= Config::get('install','defaultsystem').'/';
			//}
			
			unset($tempPieces[0]);
			$template .= implode("/",$tempPieces);

			if (!file_exists($template)) {
				WE::include_library("Controller/Front/Exception");
				throw new WE_Controller_Front_Exception("Standaardview bestaat niet: ".end($tempPieces));
			}
		}
		return $this->engine->fetch($template);
	}
	
    /**
     * Let the smarty engine display a template
     * @param string $template
     *
     * @return template
     */
	public function display($template)
	{
		return $this->engine->display($template);
	}
	
    /**
     * Return of an template is cached
     * @param string $template
     * @param string $cache_id
     * @param string $compile_id
     *
     * @return boolean true|false
     */
	public function isCached ($template, $cache_id = null, $compile_id = null)
	{
		return $this->engine->is_cached($template, $cache_id, $compile_id);
	}
	
    /**
     * Clear the Cashe (or a part of it)
     * @param string $tpl_file
     * @param string $cache_id
     * @param string $compile_id
     * @param string $exp_time
     *
     * @return boolean true|false
     */
	public function clearCache ($tpl_file = null, $cache_id = null, $compile_id = null, $exp_time = null)
	{
		return $this->engine->clear_cache($tpl_file = null, $cache_id = null, $compile_id = null, $exp_time = null);
	}
	
    /**
     * Clear the complete Cashe (or a part of it)
     * @param string $exp_time
     *
     * @return boolean true|false
     */
	public function clearAllCache ($exp_time = null)
	{
		return $this->engine->clear_all_cache($exp_time);
	}
}
?>