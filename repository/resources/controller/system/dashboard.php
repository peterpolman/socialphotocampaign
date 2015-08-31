<?php
class dashboardController extends WE_Controller_Crud
{
	protected $public = true;
	
	// WARNING: THIS CONTROLLER IS PUBLIC!
	// Security is explicitly enforced in the index action
	
	public function	indexAction (WE_Controller_Request $request)
	{
		$roles = Db::getTable('Wame_core_roleright')->getDisctinctRoles(); /* @var $roles WE_Db_Table */
		$this->view->assign('roles',$roles);
		
		$Auth = new WE_Auth();
		if ( !$Auth->isLoggedIn() )
			$this->redirect("system/login");
		
		return $this->view->render();
	}
	
}
?>