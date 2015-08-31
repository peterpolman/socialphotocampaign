<?php
WE::include_model('db/Wame_core_user');
class Wame_core_user extends Wame_core_user_db {
	
public function getRole()
	{
		$role = Db::getModel(Config::get('install','userroledb'))->findColumnData(array('user'=>$this->getId()));
		return Db::getModel(Config::get('install','roledb'))->find(array($role->getRole()));
	}
	
	public function getRoleByUserId($id)
	{
		$role = Db::getModel(Config::get('install','userroledb'))->findColumnData(array('user'=>$id));
		return Db::getModel(Config::get('install','roledb'))->find(array('id'=>$role->getRole()));
	}
	
	public function setRole($role, $id=null) {
		$id = (($id==null) ? $this->getId() : $id);
		$userrole = Db::getModel(Config::get('install','userroledb'));
		$userrole->findColumnData(array('user'=>$id));
		if( !$userrole->exists() ) {
			$userrole = Db::getModel(Config::get('install','userroledb'));
			$userrole->setUser($this->getId());
		}
		$userrole->setRole($role);
		$userrole->save();
	}
	
	public function login($username,$password) {
		$data = array('username'=>$username,'password'=>$password);
		$this->findColumnData($data);
		return $this;
		//...
	}

}
?>