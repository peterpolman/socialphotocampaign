<?php
class Wame_core_userTable extends WE_Db_Table
{
	protected $table 		= 'wame_core_user';
	protected $primary 		= array('id');
	
	public function getUsersAndRoles() {
		$r = Db::getInstance()->query("	SELECT user.id, username, password, deleted, role.role
					FROM `".$this->table."`
					AS user
					LEFT JOIN (
						SELECT * FROM ".Config::get('install','userroledb')."
					) AS userrole
					ON user.id = userrole.user 
					LEFT JOIN (
						SELECT * FROM ".Config::get('install','roledb')."
					) AS role
					ON userrole.role = role.id",array());
		return $r->fetchAll();
	}
	
}
?>