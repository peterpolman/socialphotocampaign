<?php
class Wame_core_userrole_db extends WE_Db_Record
{
	protected $table 			= 'wame_core_userrole';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'user' => null,								
						'role' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => null,	
						'user' => 'wame_core_user',	
						'role' => 'wame_core_role'	
	);
	
	protected $OABuffer	= array(
						'id' => null,
						'user' => null,
						'role' => null
	);
					
	protected $validation_model	= array(
						'id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'user' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'role' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										)										
	);

	//Start of Setters
	//----------------
	
	public function setId ($value)
	{
		$this->tableFields['id'] = $value;
	}

	public function setUser ($value)
	{
		$this->tableFields['user'] = $value;
	}

	public function setRole ($value)
	{
		$this->tableFields['role'] = $value;
	}

	//Start of Getters
	//----------------
	
	public function getId()
	{
		return $this->tableFields['id'];
	}

	public function getUser($model = false)
	{
		if ($model == true) {
			return $this->getObjectAware('user');
		}
		return $this->tableFields['user'];
	}

	public function getRole($model = false)
	{
		if ($model == true) {
			return $this->getObjectAware('role');
		}
		return $this->tableFields['role'];
	}

}
?>