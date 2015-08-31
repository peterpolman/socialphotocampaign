<?php
class rightController extends WE_Controller_Crud
{
	private $tmpright = array();
	
	public function	indexAction (WE_Controller_Request $request)
	{
		$roles = Db::getTable('Wame_core_roleright')->getDisctinctRoles(); /* @var $roles WE_Db_Table */
		$roles = array('administrator');
		$this->view->assign('roles',$roles);
		$this->view->assign('systems',Config::get('install','systems'));
		return $this->view->render();
	}
	
	public function modifyAction ()
	{
		$request = $this->getRequest();
		$controllers = $this->getControllers($request);
		$aRoles		 = Db::getTable(Config::get('install','roledb'))->getRoles();
		$wame_core_rolerights = Db::getTable(Config::get('install','rolerightdb'));

		
		if ($request->isPost())	{
			$system = $this->getRequest()->getGet('id',$request->getSystemKey());

			$wame_core_rolerights->getAll();
			foreach($wame_core_rolerights->getResult() as $right) {
				if (!key_exists($right->getController(), $controllers) && $right->getSystem() == $system)	{
					$right->Delete();
				}
			}
			
			foreach($controllers as $controller=>$actions) {
				foreach($actions as $action) {
					foreach($aRoles->getResult() as $role) {
						$data = array('role'=>$role->getId(),'system'=>$system,'controller'=>$controller,'action'=>$action);
						$core_roleright = Db::getModel(Config::get('install','rolerightdb')); /* @var $core_roleright Wame_core_roleright */
						$core_roleright->createIfNotExist($data);
						$core_roleright->setRights(0);
						$core_roleright->save();
					}
				}
			}
			
			$rights = $request->getPost('right',array());
			foreach($rights as $controller=>$actions) {
				foreach ($actions as $action=>$roles) {
					foreach ($roles as $role=>$right) {
						$data = array('role'=>$role,'system'=>$system,'controller'=>$controller,'action'=>$action);
						$core_roleright = Db::getModel(Config::get('install','rolerightdb')); /* @var $core_roleright Wame_core_roleright */
						$core_roleright->createIfNotExist($data);
						$core_roleright->setRights($right);
						$core_roleright->save();
					}
				}
			}
			
			$this->redirect($request->getSystemkey().'/right');
		}
		

		
		$theArray = array();
		$wame_core_rolerights->getAll();
		foreach($wame_core_rolerights->getResultArray(true) as $rcr) { /* @var $rcr Wame_core_roleright */
			if (!empty($rcr['controller']) && !empty($rcr['role']) && !empty($rcr['action'])) {
				$theArray[$rcr['controller']][$rcr['action']][$rcr['role']] = $rcr['rights'];
			} 
		}
		
		$this->view->assign('rights',$theArray);
		$this->view->assign('controllers',$controllers);
		$this->view->assign('roles',$aRoles);
		return $this->view->render();
	}
	
	private function getControllers($request)
	{
		$basic = get_class_methods('WE_Controller');
		$controllerStructure = array();
		$tmp = array();
		
		
		$systemFolder = $this->getRequest()->getGet('id',$request->getSystemKey());
		
		$ignore = array('.','..','.DS_Store','.htaccess','header','supercontroller','.svn','dispatcher.php');
		if ($handle = opendir(Config::get('install','resourcedir').'controller/'.$systemFolder)) {
			while (false !== ($file = readdir($handle))) {
				if (!in_array($file,$ignore) && strrchr($file,'.') == '.php') {
					$filename = substr($file, 0, strrpos($file, '.'));
					require_once(Config::get('install','resourcedir').'controller/'.$systemFolder.'/'.$file);
					$class_methodes = get_class_methods($filename.'Controller');
					if (is_array($class_methodes)) {
						$methodes = array_diff($class_methodes, $basic);
						foreach ($methodes as $id=>$methode) {
							if (substr($methode,-6) != 'Action') {
								unset($methodes[$id]);
							} else {
								$methodes[$id] = substr($methode, 0, strrpos($methode, 'Action'));
							}
						}
						$controllerStructure[$filename] = $methodes;
					}
					$classname = $filename.'Controller';
					if ( $classname::getPublicStatic() ) {
						$controllerStructure[$filename]['public'] = true;
					} else {
						$controllerStructure[$filename]['public'] = false;
					}
				}
			}
			closedir($handle);
		}
		ksort($controllerStructure);
		
		return $controllerStructure;
	}
}	
?>