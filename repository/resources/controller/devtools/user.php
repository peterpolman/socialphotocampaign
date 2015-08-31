<?php
class userController extends WE_Controller_Crud
{
	protected $table 		= 'Wame_core_user';
	
	public function	indexAction (WE_Controller_Request $request)
	{
		$users = Db::getInstance()->getTable($this->table)->getUsersAndRoles();
		$this->view->assign('users',$users);
		return $this->view->render($this->getRequest()->getSystemKey().'/user/index.tpl');
	}
	
	public function	viewAction (WE_Controller_Request $request)
	{
		$userId = $request->getGet('id');
		$user = Db::getInstance()->getModel('Wame_core_user')->find($userId);
		
		if ($user == false)
		{
			WE_Engine_Session::setFlash('De opgegeven user bestaat niet.', 'error');
			$this->redirect($this->getRequest()->getSystemKey()."/user");
		}
		else
		{
			$role = $user->getRole()->getRole();
			$user = $user->getValuesAsArray();
			$this->view->assign('user',$user);
			$this->view->assign('role',$role);
			return $this->view->render($this->getRequest()->getSystemKey().'/user/view.tpl');
		}
	}

	public function	addAction (WE_Controller_Request $request)
	{
		$db = Db::getInstance();

		if ($request->isPost())
		{
			details($_POST);
			$user = $db->getModel('Wame_core_user');
			$user->populate($request->getPost('user', array()));
			$user->setDeleted(0);
			$user->setPassword(md5($user->getPassword()));
			
			try {
				$user->save();
			} catch (PDOException $e) {
				WE_Engine_Session::setFlash('Gebruikersnaam is al in gebruik!', 'error');
				$this->redirect($this->getRequest()->getSystemKey()."/user/add");
			}
			$id = $db->lastInsertId();
			$data = $request->getPost('user', array());
			$user->setRole($data['role'],$id);

			$udata = $request->getPost('userdata', array());
			$userdata = Db::getModel('wame_core_userdata');
			$userdata->setId($user->getId());
			$userdata->setForceAdd(true);
			$userdata->populate($udata);
			$userdata->save();

			
			WE_Engine_Session::setFlash('De user succesvol toegevoegd.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/user/view/$id");
		}
		else
		{
			$this->view->assign('roles',Db::getInstance()->getTable('wame_core_role')->getAll());
			return $this->view->render($this->getRequest()->getSystemKey().'/user/add.tpl');
		}
	}
	
	public function	modifyAction (WE_Controller_Request $request)
	{
		$userId = $request->getGet('id');
		if ($request->isPost())
		{
			$user = Db::getInstance()->getModel('Wame_core_user')->find($userId);
			$data = $request->getPost('user', array());
			$udata = $request->getPost('userdata', array());
			$user->setUsername($data['username']);
			if( $data['password'] != "" )
				$user->setPassword(md5($data['password']));
			$user->setRole($data['role']);
			$user->save();
			
			$userdata = Db::getModel('wame_core_userdata')->find($user->getId()); /* @var $userdat Wame_core_userdata */
			if (empty($userdata)) {
				$userdata = Db::getModel('wame_core_userdata');
			}
			$userdata->setId($user->getId());
			$userdata->setForceAdd(true);
			$userdata->populate($udata);
			$userdata->save();
			
			WE_Engine_Session::setFlash('De user succesvol bewerkt.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/user/view/$userId");
		}
		else
		{
			$user = Db::getInstance()->getModel('Wame_core_user')->find($userId);
			$role = $user->getRole()->getId();
			$user = $user->getValuesAsArray();
			
			$userdata = Db::getModel('wame_core_userdata')->find($user['id']);
			if (empty($userdata)) {
				$userdata = Db::getModel('wame_core_userdata');
			}
			
			$this->view->assign('userdata',$userdata->getValuesAsArray());
			$this->view->assign('user',$user);
			$this->view->assign('role',$role);
			$this->view->assign('roles',Db::getInstance()->getTable('wame_core_role')->getAll());

			return $this->view->render($this->getRequest()->getSystemKey().'/user/modify.tpl');
		}
	}
	

	
	public function	deleteAction (WE_Controller_Request $request)
	{
		$userId = $request->getGet('id');
		$user = Db::getInstance()->getModel('Wame_core_user')->find($userId);
		

		if ($user == false)
		{
			WE_Engine_Session::setFlash('Er is geen user gevonden met het betreffende Id', 'error');
			$this->redirect($this->getRequest()->getSystemKey()."/user");
		}
		else
		{
			
			$user->softDelete();
			WE_Engine_Session::setFlash('De user succesvol verwijderd.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/user");
		}

	}
	
	
	public function	archiveAction (WE_Controller_Request $request)
	{
		$users = Db::getInstance()->getTable($this->table)->getAllDeleted(true);

		if (!empty($users))
		{
			$this->view->assign('users',$users);
			return $this->view->render($this->getRequest()->getSystemKey().'/wame_core_user/archive.tpl');
		}
		else
		{
			WE_Engine_Session::setFlash('Er zijn geen gearchiveerde users meer.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/wame_core_user");
		}
	}
	
	public function	unarchiveAction (WE_Controller_Request $request)
	{
		$userId = $request->getGet('id');
		$user = Db::getInstance()->getModel('Wame_core_user')->find($userId);


		if (empty($user))
		{
			$this->redirect($this->getRequest()->getSystemKey()."/wame_core_user");
		}
		else
		{
			$user->setDeleted(0);
			$user->save();
			WE_Engine_Session::setFlash('De user succesvol teruggeplaatst.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/wame_core_user/archive");
		}

	}
}	
?>