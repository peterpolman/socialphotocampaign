<?php
class Wame_core_rolerightTable extends WE_Db_Table
{
	protected $table 		= 'wame_core_roleright';
	protected $primary 		= array('id');

	public function getRightsByRole($role)
	{
		$query = "SELECT * FROM ".$this->table." WHERE role = :role";
		$vars = array('role'=>$role);
		return $this->setResultset($query,$vars);
	}
	
	public function getDisctinctRoles()
	{
		$query = "SELECT DISTINCT * FROM ".$this->table." GROUP BY role";
		$vars = array();
		return $this->setResultset($query, $vars);
	}
}
?>