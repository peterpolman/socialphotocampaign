<?php
class Entry_db extends WE_Db_Record
{
	protected $table 			= 'entry';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'status' => null,								
						'filename' => null,								
						'first_name' => null,								
						'last_name' => null,								
						'description' => null,								
						'email' => null,								
						'ip' => null,								
						'newsletter' => null,								
						'street_name' => null,								
						'street_number' => null,								
						'postal_code' => null,								
						'place' => null,								
						'date' => null,								
						'actiecode' => null,								
						'published' => null,
						'total_vote_count' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => null,	
						'status' => null,	
						'filename' => null,	
						'first_name' => null,	
						'last_name' => null,	
						'description' => null,	
						'email' => null,	
						'ip' => null,	
						'newsletter' => null,	
						'street_name' => null,	
						'street_number' => null,	
						'postal_code' => null,	
						'place' => null,	
						'date' => null,	
						'actiecode' => null,	
						'published' => null,
						'total_vote_count' => null
	);
	
	protected $OABuffer	= array(
						'id' => null,
						'status' => null,
						'filename' => null,
						'first_name' => null,
						'last_name' => null,
						'description' => null,
						'email' => null,
						'ip' => null,
						'newsletter' => null,
						'street_name' => null,
						'street_number' => null,
						'postal_code' => null,
						'place' => null,
						'date' => null,
						'actiecode' => null,
						'published' => null,
						'total_vote_count' => null
	);
					
	protected $validation_model	= array(
						'id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'status' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'filename' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'first_name' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'last_name' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'description' => array(
										'null'=>false,
										'type'=>'text'
										),										
						'email' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'ip' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>15
										),										
						'newsletter' => array(
										'null'=>true,
										'type'=>'int',
										'min'=>-128,
										'max'=>127,
										'maxchar'=>1
										),										
						'street_name' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'street_number' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'postal_code' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'place' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'date' => array(
										'null'=>false,
										'type'=>'datetime'
										),										
						'actiecode' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'published' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-128,
										'max'=>127,
										'maxchar'=>1
										),
						'total_vote_count' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
	);

	//Start of Setters
	//----------------
	
	public function setId ($value)
	{
		$this->tableFields['id'] = $value;
	}

	public function setStatus ($value)
	{
		$this->tableFields['status'] = $value;
	}

	public function setFilename ($value)
	{
		$this->tableFields['filename'] = $value;
	}

	public function setFirst_name ($value)
	{
		$this->tableFields['first_name'] = $value;
	}

	public function setLast_name ($value)
	{
		$this->tableFields['last_name'] = $value;
	}

	public function setDescription ($value)
	{
		$this->tableFields['description'] = $value;
	}

	public function setEmail ($value)
	{
		$this->tableFields['email'] = $value;
	}

	public function setIp ($value)
	{
		$this->tableFields['ip'] = $value;
	}

	public function setNewsletter ($value)
	{
		$this->tableFields['newsletter'] = $value;
	}

	public function setStreet_name ($value)
	{
		$this->tableFields['street_name'] = $value;
	}

	public function setStreet_number ($value)
	{
		$this->tableFields['street_number'] = $value;
	}

	public function setPostal_code ($value)
	{
		$this->tableFields['postal_code'] = $value;
	}

	public function setPlace ($value)
	{
		$this->tableFields['place'] = $value;
	}

	public function setDate ($value)
	{
		$this->tableFields['date'] = $value;
	}

	public function setActiecode ($value)
	{
		$this->tableFields['actiecode'] = $value;
	}

	public function setPublished ($value)
	{
		$this->tableFields['published'] = $value;
	}
	public function setTotal_vote_count ($value)
	{
		$this->tableFields['total_vote_count'] = $value;
	}

	//Start of Getters
	//----------------
	
	public function getId()
	{
		return $this->tableFields['id'];
	}

	public function getStatus()
	{
		return $this->tableFields['status'];
	}

	public function getFilename()
	{
		return $this->tableFields['filename'];
	}

	public function getFirst_name()
	{
		return $this->tableFields['first_name'];
	}

	public function getLast_name()
	{
		return $this->tableFields['last_name'];
	}

	public function getDescription()
	{
		return $this->tableFields['description'];
	}

	public function getEmail()
	{
		return $this->tableFields['email'];
	}

	public function getIp()
	{
		return $this->tableFields['ip'];
	}

	public function getNewsletter()
	{
		return $this->tableFields['newsletter'];
	}

	public function getStreet_name()
	{
		return $this->tableFields['street_name'];
	}

	public function getStreet_number()
	{
		return $this->tableFields['street_number'];
	}

	public function getPostal_code()
	{
		return $this->tableFields['postal_code'];
	}

	public function getPlace()
	{
		return $this->tableFields['place'];
	}

	public function getDate()
	{
		return $this->tableFields['date'];
	}

	public function getActiecode()
	{
		return $this->tableFields['actiecode'];
	}

	public function getPublished()
	{
		return $this->tableFields['published'];
	}
	public function getTotal_vote_count ()
	{
		return $this->tableFields['total_vote_count'];
	}
}
?>