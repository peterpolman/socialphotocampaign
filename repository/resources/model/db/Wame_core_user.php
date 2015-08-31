<?php
class Wame_core_user_db extends WE_Db_Record
{
	protected $table 			= 'wame_core_user';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'username' => null,								
						'password' => null,								
						'deleted' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => null,	
						'username' => null,	
						'password' => null,	
						'deleted' => null	
	);
	
	protected $OABuffer	= array(
						'id' => null,
						'username' => null,
						'password' => null,
						'deleted' => null
	);
					
	protected $validation_model	= array(
						'id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'username' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'password' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>63
										),										
						'deleted' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-128,
										'max'=>127,
										'maxchar'=>1
										)										
	);

	//Start of Setters
	//----------------
	
	public function setId ($value)
	{
		$this->tableFields['id'] = $value;
	}

	public function setUsername ($value)
	{
		$this->tableFields['username'] = $value;
	}

	public function setPassword ($value)
	{
		$this->tableFields['password'] = $value;
	}

	public function setDeleted ($value)
	{
		$this->tableFields['deleted'] = $value;
	}

	//Start of Getters
	//----------------
	
	public function getId()
	{
		return $this->tableFields['id'];
	}

	public function getUsername()
	{
		return $this->tableFields['username'];
	}

	public function getPassword()
	{
		return $this->tableFields['password'];
	}

	public function getDeleted()
	{
		return $this->tableFields['deleted'];
	}

}
?>