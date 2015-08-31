<?php
class godcomplexController extends WE_Controller_Crud
{
	protected $public = true;
	
	/**
	 * Generate model for some database table
	 * Usage: http://192.168.1.100/terSteege/godcomplex/index/server (for table server)
	 * @param WE_Controller_Request $request
	 */
	public function	indexAction (WE_Controller_Request $request)
	{
		$table = $request->getGet('id');
		
		$db = Db::getInstance();
		$r = $db->query('SHOW COLUMNS FROM `' . $table .'`');
        
		$aFields = array();
		$aFormResults = $r->fetchAll(PDO::FETCH_ASSOC);
		foreach($aFormResults as $result)
		{
			$aFields[$result['Field']] = ucfirst($result['Field']);
		}
		
		$this->view->assign('table',$table);
		$this->view->assign('fields',$aFields);
		$this->view->assign('Classname',ucfirst($table));
	
		if ($request->isPost())
		{
			$this->view->assign('primary',$request->getPost('primaryfield'));
			$this->view->assign('pClassName',$request->getPost('classname'));
			return $this->view->render($this->getRequest()->getSystemKey().'/creator/output.tpl');
		}
		else
		{
			
			return $this->view->render($this->getRequest()->getSystemKey().'/creator/generate.tpl');
		}
	}
	
	public function divineeyeAction (WE_Controller_Request $request)
	{
		$controllers = $this->getControllers();
		$tables = $this->getTables();
		
		foreach($tables as $tkey=>$table)
		{
			foreach($table as $fkey=>$function)
			{
				foreach($controllers as $file)
				{
					if(strstr($file,$function))
					{
						unset($tables[$tkey][$fkey]);
						break;
					}
				}
			}
			if (empty($tables[$tkey]))
			{
				unset($tables[$tkey]);
			}
		}
		
		details($tables);
	}
	
	private function getControllers()
	{
		//$basic = get_class_methods('WE_Controller_Crud');
		
		$controllers = array();
		$tmp = array();
		if ($handle = opendir('./controller')) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && $file != ".htaccess") {
					
					$filename = substr($file, 0, strrpos($file, '.'));  
					//require_once('./controller/'.$file);
					//$methodes = get_class_methods($filename."Controller");
					//$controllers[$file] = (array_diff($methodes, $basic));
					$controllers[$file] = file_get_contents('./controller/'.$file);
				}
			}
			closedir($handle);
		}
		
		return $controllers;
	}
	
	private function getTables()
	{
		$basic = get_class_methods('WE_Db_Table');
		
		$controllers = array();
		$tmp = array();
		if ($handle = opendir('./model')) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && $file != ".htaccess") {
					
					$filename = substr($file, 0, strrpos($file, '.'));  
					require_once('./model/'.$file);
					$methodes = get_class_methods($filename."Table");
					if (!empty($methodes))
					{
						$controllers[$file] = (array_diff($methodes, $basic));
					}
				}
			}
			closedir($handle);
		}
		
		return $controllers;
	}
	
	/**
	 * Generate controllers & views for some database table
	 * Usage: http://192.168.1.100/terSteege/godcomplex/hack/server (for server table)
	 * @param WE_Controller_Request $request
	 */
	public function	hackAction (WE_Controller_Request $request)
	{

		$controllerfilename = $request->getGet('id');
		$this->view->assign('controllerfilename',$controllerfilename);
		
		$r = Db::getInstance()->query('SHOW COLUMNS FROM `' . $controllerfilename .'`');
		$aFields = array();
		$aFormResults = $r->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($aFormResults as $result)
		{
			$aFields[$result['Field']] = ucfirst($result['Field']);
		}
		
		if ($request->isPost())
		{
			foreach($request->getPost('velden') as $vid=>$veld)
			{
				$aFields[$vid] = $veld;
			}
			
			$controllerinfo = $request->getPost('controller');
			
			$this->view->assign('controllername',$controllerinfo['controllername']);
			$this->view->assign('meervoud',$controllerinfo['meervoud']);
			$this->view->assign('meervoudtext',$controllerinfo['meervoudtext']);
			$this->view->assign('enkelvoud',$controllerinfo['enkelvoud']);
			$this->view->assign('enkelvoudtext',$controllerinfo['enkelvoudtext']);
			$this->view->assign('fields',$aFields);
			
		if($request->getPost('output') == true)
		{
				
				
			$dir = Config::get('install','resourcedir')."/view/tpl/".$this->getRequest()->getSystemKey()."/".$controllerfilename;
			details(Config::get('install','resourcedir'));
			details($dir);
			if(file_exists($dir)) {
				$error[] = "Directory bestaat al: $dir";
			}
			else
			{
				mkdir($dir);
				chmod($dir, 0777);
				$success[] = "Directory is aangemaakt: $dir";
			}
			
			$tpls = array('index','add','modify','view','archive');
			foreach($tpls as $tpl)
			{
				$path = $dir."/".$tpl.".tpl";
				if(file_exists($path)) {
					$error[] = "Bestand bestaat al: $path";
				}
				else
				{
					$tpldata = $this->view->render($this->getRequest()->getSystemKey().'/creator/'.$tpl.'.tpl.tpl');
					$fh = fopen($path,'a');
					chmod($path, 0777);
					fwrite($fh,$tpldata);
					fclose($fh);
					$success[] = "Bestand is aangemaakt: $path";
				}
			}

			$path = Config::get('install','resourcedir')."/controller/".$this->getRequest()->getSystemKey()."/".$controllerfilename.".php";
			if(file_exists($path)) {
				$error[] = "Bestand bestaat al: $path";
			}
			else
			{
				$tpldata = $this->view->render($this->getRequest()->getSystemKey().'/creator/controller.tpl');
				$fh = fopen($path,'a');
				chmod($path, 0777);
				fwrite($fh,$tpldata);
				fclose($fh);
				$success[] = "Bestand is aangemaakt: $path";
			}

			$this->view->assign('errors', $error);
			$this->view->assign('success', $success);
			

				return $this->view->render($this->getRequest()->getSystemKey().'/creator/god.tpl');
				
			}
			else
			{
				return $this->view->render($this->getRequest()->getSystemKey().'/creator/onlyoutput.tpl');
			}
			
		}
		else
		{
			$this->view->assign('fields',$aFields);
			return $this->view->render($this->getRequest()->getSystemKey().'/creator/config.tpl');
		}
	}
	
	private function theHandOfGod($tpl,$path)
	{
		
			//$db = Db::getInstance();
			//$r = $db->query('SHOW COLUMNS FROM `' . strtolower($table) .'`');
	

			
			//$this->view->assign('table',strtolower($table));
			//$this->view->assign('Table',ucfirst($table));
			
			//$tabledata = $this->view->render('creator/table.tpl');
			

		
		
	}
}	
?>