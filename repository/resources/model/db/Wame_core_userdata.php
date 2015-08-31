<?php
class Wame_core_userdata_db extends WE_Db_Record
{
	protected $table 			= 'wame_core_userdata';
	protected $primary 			= array('id');
	protected $autoIncrement	= 'id';	
	protected $tableFields		= array(
						'id' => null,								
						'voornaam' => null,								
						'tussenvoegsel' => null,								
						'achternaam' => null								
	);
					
	protected $objectAwareness	= array(
						'id' => 'wame_core_user',	
						'voornaam' => null,	
						'tussenvoegsel' => null,	
						'achternaam' => null	
	);
	
	protected $OABuffer	= array(
						'id' => null,
						'voornaam' => null,
						'tussenvoegsel' => null,
						'achternaam' => null
	);
					
	protected $validation_model	= array(
						'id' => array(
										'null'=>false,
										'type'=>'int',
										'min'=>-2147483648,
										'max'=>2147483647,
										'maxchar'=>11
										),										
						'voornaam' => array(
										'null'=>false,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'tussenvoegsel' => array(
										'null'=>true,
										'type'=>'varchar',
										'maxchar'=>255
										),										
						'achternaam' => array(
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

	public function setVoornaam ($value)
	{
		$this->tableFields['voornaam'] = $value;
	}

	public function setTussenvoegsel ($value)
	{
		$this->tableFields['tussenvoegsel'] = $value;
	}

	public function setAchternaam ($value)
	{
		$this->tableFields['achternaam'] = $value;
	}

	//Start of Getters
	//----------------
	
	public function getId($model = false)
	{
		if ($model == true) {
			return $this->getObjectAware('id');
		}
		return $this->tableFields['id'];
	}

	public function getVoornaam()
	{
		return $this->tableFields['voornaam'];
	}

	public function getTussenvoegsel()
	{
		return $this->tableFields['tussenvoegsel'];
	}

	public function getAchternaam()
	{
		return $this->tableFields['achternaam'];
	}

}
?>