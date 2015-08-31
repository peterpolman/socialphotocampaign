<?php
class Wame_core_passwordtoken_db extends WE_Db_Record
{
	protected $table 			= 'wame_core_passwordtoken';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'user_id' => null,								
						'hash' => null,								
						'expire' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => null,	
						'user_id' => null,	
						'hash' => null,	
						'expire' => null	
	);
	
	protected $OABuffer	= array(
						'id' => null,
						'user_id' => null,
						'hash' => null,
						'expire' => null
	);
					
	protected $validation_model	= array(
						'id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'user_id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'hash' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>63
										),										
						'expire' => array(
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

	public function setUser_id ($value)
	{
		$this->tableFields['user_id'] = $value;
	}

	public function setHash ($value)
	{
		$this->tableFields['hash'] = $value;
	}

	public function setExpire ($value)
	{
		$this->tableFields['expire'] = $value;
	}

	//Start of Getters
	//----------------
	
	public function getId()
	{
		return $this->tableFields['id'];
	}

	public function getUser_id()
	{
		return $this->tableFields['user_id'];
	}

	public function getHash()
	{
		return $this->tableFields['hash'];
	}

	public function getExpire()
	{
		return $this->tableFields['expire'];
	}

}
?>