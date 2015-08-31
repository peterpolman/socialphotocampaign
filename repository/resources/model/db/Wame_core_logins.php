<?php
class Wame_core_logins_db extends WE_Db_Record
{
	protected $table 			= 'wame_core_logins';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'ip' => null,								
						'failed_login_attempts' => null,								
						'last_failed_login_attempt' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => null,	
						'ip' => null,	
						'failed_login_attempts' => null,	
						'last_failed_login_attempt' => null	
	);
	
	protected $OABuffer	= array(
						'id' => null,
						'ip' => null,
						'failed_login_attempts' => null,
						'last_failed_login_attempt' => null
	);
					
	protected $validation_model	= array(
						'id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'ip' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>50
										),										
						'failed_login_attempts' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'last_failed_login_attempt' => array(
										'null'=>false,
										'type'=>'datetime'
										)										
	);

	//Start of Setters
	//----------------
	
	public function setId ($value)
	{
		$this->tableFields['id'] = $value;
	}

	public function setIp ($value)
	{
		$this->tableFields['ip'] = $value;
	}

	public function setFailed_login_attempts ($value)
	{
		$this->tableFields['failed_login_attempts'] = $value;
	}

	public function setLast_failed_login_attempt ($value)
	{
		$this->tableFields['last_failed_login_attempt'] = $value;
	}

	//Start of Getters
	//----------------
	
	public function getId()
	{
		return $this->tableFields['id'];
	}

	public function getIp()
	{
		return $this->tableFields['ip'];
	}

	public function getFailed_login_attempts()
	{
		return $this->tableFields['failed_login_attempts'];
	}

	public function getLast_failed_login_attempt()
	{
		return $this->tableFields['last_failed_login_attempt'];
	}

}
?>