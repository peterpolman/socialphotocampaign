<?php
class Wame_core_roleTable extends WE_Db_Table
{
	protected $table 		= 'wame_core_role';
	protected $primary 		= array('id');
	
	public function getRoles() {
		$query = "SELECT * FROM ".$this->table;
		return $this->setResultset($query,array());
	}
	
}
?>