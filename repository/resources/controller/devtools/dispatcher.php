<?php
class devtoolsHeader extends WE_Controller
{
	public function	header ()
	{
		// TODO: get all controllers that I have the rights to index instead of just all files
		$files = scandir(dirname(__FILE__));
		$goodfiles = array();
		foreach( $files as $file ) {
			if ( !in_array($file,array(".","..","dispatcher.php")) ) {
				$goodfiles[] = pathinfo($file, PATHINFO_FILENAME);
			}
		}
		$request = $this->getRequest();
		if ( $request->getActionKey() != null ) {
			$controller  = ($request->getControllerKey()==WE_Controller_Request::$DEFAULT_CONTROLLERKEY)?null:$request->getControllerKey();
			if ($controller == "") { $controller = 'dashboard'; }
			$action = ($request->getActionKey()==WE_Controller_Request::$DEFAULT_ACTIONKEY)?null:$request->getActionKey();
		}
		$lang = $this->getLanguageFile('nl');
		/* Gedisabled omdat het stom was
		$module_menu = Config::get('modules',$controller);
		$this->view->assign('module_menu',$module_menu); */
		$this->view->assign('lang',$lang);
		$this->view->assign('controller',$controller);
		$this->view->assign('action',$action);
		$this->view->assign('menu',$goodfiles);
		return $this->view->render($this->getRequest()->getSystemKey().'/layout/header.tpl');
	}
	
	private function getLanguageFile($language)
	{
		$lang = array();
		if ($language == '') {
			$language = 'default';
		}
		$system = $this->getRequest()->getSystemKey();
		$base = Config::get('install','resourcedir').'lang/';
		$file = $system."_".$language.".php";
		if (file_exists($base.$file)) {
			include ($base.$file);
		} else {
			include ($base.$system.'_default.php');
		}
		return $lang;
		
	}
}
?>