<?php
class Wame_core_role_db extends WE_Db_Record
{
	protected $table 			= 'wame_core_role';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'role' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => null,	
						'role' => null	
	);
	
	protected $OABuffer	= array(
						'id' => null,
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
						'role' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>255
										)										
	);

	//Start of Setters
	//----------------
	
	public function setId ($value)
	{
		$this->tableFields['id'] = $value;
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

	public function getRole()
	{
		return $this->tableFields['role'];
	}

}
?>