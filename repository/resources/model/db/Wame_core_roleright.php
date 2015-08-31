<?php
class Wame_core_roleright_db extends WE_Db_Record
{
	protected $table 			= 'wame_core_roleright';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'role' => null,								
						'system' => null,								
						'controller' => null,								
						'action' => null,								
						'rights' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => null,	
						'role' => 'wame_core_role',	
						'system' => null,	
						'controller' => null,	
						'action' => null,	
						'rights' => null	
	);
	
	protected $OABuffer	= array(
						'id' => null,
						'role' => null,
						'system' => null,
						'controller' => null,
						'action' => null,
						'rights' => null
	);
					
	protected $validation_model	= array(
						'id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>0,
										'max'=>4294967295,
										'maxchar'=>10
										),										
						'role' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'system' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'controller' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'action' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'rights' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>0,
										'max'=>255,
										'maxchar'=>3
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

	public function setSystem ($value)
	{
		$this->tableFields['system'] = $value;
	}

	public function setController ($value)
	{
		$this->tableFields['controller'] = $value;
	}

	public function setAction ($value)
	{
		$this->tableFields['action'] = $value;
	}

	public function setRights ($value)
	{
		$this->tableFields['rights'] = $value;
	}

	//Start of Getters
	//----------------
	
	public function getId()
	{
		return $this->tableFields['id'];
	}

	public function getRole($model = false)
	{
		if ($model == true) {
			return $this->getObjectAware('role');
		}
		return $this->tableFields['role'];
	}

	public function getSystem()
	{
		return $this->tableFields['system'];
	}

	public function getController()
	{
		return $this->tableFields['controller'];
	}

	public function getAction()
	{
		return $this->tableFields['action'];
	}

	public function getRights()
	{
		return $this->tableFields['rights'];
	}

}
?>