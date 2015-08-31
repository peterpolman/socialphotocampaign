<?php
class Vote_db extends WE_Db_Record
{
	protected $table 			= 'vote';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'entry' => null,								
						'ip' => null,								
						'email' => null,								
						'verifystring' => null,								
						'date' => null,								
						'verified' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => null,	
						'entry' => 'entry',	
						'ip' => null,	
						'email' => null,	
						'verifystring' => null,	
						'date' => null,	
						'verified' => null	
	);
	
	protected $OABuffer	= array(
						'id' => null,
						'entry' => null,
						'ip' => null,
						'email' => null,
						'verifystring' => null,
						'date' => null,
						'verified' => null
	);
					
	protected $validation_model	= array(
						'id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'entry' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'ip' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>15
										),										
						'email' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'verifystring' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>40
										),										
						'date' => array(
										'null'=>false,
										'type'=>'datetime'
										),										
						'verified' => array(
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

	public function setEntry ($value)
	{
		$this->tableFields['entry'] = $value;
	}

	public function setIp ($value)
	{
		$this->tableFields['ip'] = $value;
	}

	public function setEmail ($value)
	{
		$this->tableFields['email'] = $value;
	}

	public function setVerifystring ($value)
	{
		$this->tableFields['verifystring'] = $value;
	}

	public function setDate ($value)
	{
		$this->tableFields['date'] = $value;
	}

	public function setVerified ($value)
	{
		$this->tableFields['verified'] = $value;
	}

	//Start of Getters
	//----------------
	
	public function getId()
	{
		return $this->tableFields['id'];
	}

	public function getEntry($model = false)
	{
		if ($model == true) {
			return $this->getObjectAware('entry');
		}
		return $this->tableFields['entry'];
	}

	public function getIp()
	{
		return $this->tableFields['ip'];
	}

	public function getEmail()
	{
		return $this->tableFields['email'];
	}

	public function getVerifystring()
	{
		return $this->tableFields['verifystring'];
	}

	public function getDate()
	{
		return $this->tableFields['date'];
	}

	public function getVerified()
	{
		return $this->tableFields['verified'];
	}

}
?>