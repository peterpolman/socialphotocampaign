<?php
class roleController extends WE_Controller_Crud
{
	protected $table 		= 'wame_core_role';
	
	public function	indexAction (WE_Controller_Request $request)
	{
		$roles = Db::getInstance()->getTable($this->table)->getAll();

		$this->view->assign('roles',$roles);
		return $this->view->render($this->getRequest()->getSystemKey().'/role/index.tpl');
	}
	
	public function	viewAction (WE_Controller_Request $request)
	{

		$roleId = $request->getGet('id');
		$role = Db::getInstance()->getModel('wame_core_role')->find($roleId);
		

		if ($role == false)
		{
			WE_Engine_Session::setFlash('De opgegeven role bestaat niet.', 'error');
			$this->redirect($this->getRequest()->getSystemKey()."/role");
		}
		else
		{
			$role = $role->getValuesAsArray();
			$this->view->assign('role',$role);	
			return $this->view->render($this->getRequest()->getSystemKey().'/role/view.tpl');
		}

	}

	public function	addAction (WE_Controller_Request $request)
	{

		$db = Db::getInstance();

		if ($request->isPost())
		{
			$role = $db->getModel('wame_core_role');
			$role->populate($request->getPost('role', array()));
			$role->save();
			$id = $db->lastInsertId();
			
			WE_Engine_Session::setFlash('De role succesvol toegevoegd.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/role/view/$id");
		}
		else
		{
			return $this->view->render($this->getRequest()->getSystemKey().'/role/add.tpl');
		}
	}
	
	public function	modifyAction (WE_Controller_Request $request)
	{
		$roleId = $request->getGet('id');

		if ($request->isPost())
		{
			$role = Db::getInstance()->getModel('wame_core_role')->find($roleId);
			$role->populate($request->getPost('role', array()));
			$role->save();
			
			WE_Engine_Session::setFlash('De role succesvol bewerkt.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/role/view/$roleId");
		}
		else
		{
			$role = Db::getInstance()->getModel('wame_core_role')->find($roleId);
			$role = $role->getValuesAsArray();
			$this->view->assign('role',$role);

			return $this->view->render($this->getRequest()->getSystemKey().'/role/modify.tpl');
		}
	}
	

	
	public function	deleteAction (WE_Controller_Request $request)
	{
		$roleId = $request->getGet('id');
		$role = Db::getInstance()->getModel('wame_core_role')->find($roleId);

		if ($role == false)
		{
			WE_Engine_Session::setFlash('Er is geen role gevonden met het betreffende Id', 'error');
			$this->redirect($this->getRequest()->getSystemKey()."/role");
		}
		else
		{
			
			$role->softDelete();
			WE_Engine_Session::setFlash('De role succesvol verwijderd.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/role");
		}

	}
	
	
	public function	archiveAction (WE_Controller_Request $request)
	{
	
		$roles = Db::getInstance()->getTable($this->table)->getAllDeleted(true);

		if (!empty($roles))
		{
			$this->view->assign('roles',$roles);
			return $this->view->render($this->getRequest()->getSystemKey().'/role/archive.tpl');
		}
		else
		{
			WE_Engine_Session::setFlash('Er zijn geen gearchiveerde roles meer.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/role");
		}
	}
	
	public function	unarchiveAction (WE_Controller_Request $request)
	{

		$roleId = $request->getGet('id');
		$role = Db::getInstance()->getModel('role')->find($roleId);

		if (empty($role))
		{
			$this->redirect($this->getRequest()->getSystemKey()."/role");
		}
		else
		{
			$role->setDeleted(0);
			$role->save();
			WE_Engine_Session::setFlash('De role succesvol teruggeplaatst.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/role/archive");
		}

	}
}	
?>