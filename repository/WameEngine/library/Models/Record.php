<?php
/**
 * Abstract Record Handler
 * @author Wame
 *
 */
abstract class WE_Record
{	
	
	const ORDER_ASC_BY_COLUMN		= 'OABC';
	const ORDER_DESC_BY_COLUMN		= 'ODBC';
	const USE_WILDCARD_ON_COLUMN	= 'UWOC';
	const USE_LESS_THAN_ON_COLUMN	= 'ULTOC';
	const USE_MORE_THAN_ON_COLUMN	= 'UMTOC';
	const USE_DATE_ONLY_ON_COLUMN	= 'UDOOC';
	
	protected $table 		= null;				// The table of wich the model is a representation
	protected $primary 		= array('id');		// Array with the primaries
	protected $autoIncrement= null;				// Is there an autoIncrement field? If so, this is the field
	protected $forceAdd 	= null; 			// Should the update part of save be ignored?
	protected $softDelete 	= false;			// Flag the model as deleted instead of physically deleting it
	protected $errors 		= array();			// Array of the errors (both custom and from validation)
	protected $tableFields 	= array();			// List of the fields + values of the model representation
	protected $validation_model = array();		// The validation model for the save functions
	protected $objectAwareness	= array();		// Object aware array. If there is a link you can get an object trough Object Awareness
	protected $OABuffer	= array();		// Object aware array. If there is a link you can get an object trough Object Awareness
	
	/**
	 * If a field represents a link that is object aware you can get the specific object.
	 * Searches are buffered so you can repetitively use the object awareness without wasting resources
	 *
	 * @param $field string
	 * @return WE_Record
	 */
	public function getObjectAware($field) {
		if (isset($this->objectAwareness[$field]) && !is_null($this->objectAwareness[$field])) {
			try {
				if (isset($this->OABuffer[$field]) && !is_null($this->OABuffer[$field]) ) {
					return $this->OABuffer[$field];
				} else {
					$return = Db::getModel($this->objectAwareness[$field])->find($this->tableFields[$field]);
					if ($return != false) {
						$this->OABuffer[$field] = $return;
						return $return;
					} else {
						return $this->tableFields[$field];
					}
				}
			} catch (Exception $e) {
				return $this->tableFields[$field];
			}
		} else {
			return $this->tableFields[$field];
		}
	}
	
	protected function validate()
	{
		if (!empty($this->validation_model))
		{
			WE::include_library('Models/Record/RecordValidator');
			$validator =  new RecordValidator();
			$validator->validate($this->table,$this->validation_model, $this->tableFields,$this->primary);
			if ($validator->getChanged() == true ) {
				$this->tableFields = $validator->getTableFields();
			}
			
			$this->errors = $validator->getErrors();
		} else {
			WE::include_library('Models/Record/Exception/Exception');
			throw new WE_Db_Record_Exception('No validation rules have been set. Old model is in use. Please use the generate function for the model: '.ucfirst($this->table));
		}
	}
	
	protected function CCMMadd()
	{
		/*$user = WE::getInstance()->roma->session->user->user_id;
		
		if (key_exists('entered_by_user_id', $this->tableFields))
		{
			if (empty($this->tableFields['entered_by_user_id']))
			{
				$this->tableFields['entered_by_user_id'] = $user;
			}
		}*/
		
		if (key_exists('create_date', $this->tableFields))
		{
			if (empty($this->tableFields['create_date']))
			{
				$this->tableFields['create_date'] = date("Y-m-d H:i:s");
			}
		}
		
		/*if (key_exists('changed_by_user_id', $this->tableFields))
		{
			$this->tableFields['changed_by_user_id'] = $user;
		}*/
		
		if (key_exists('modified_date', $this->tableFields))
		{
			$this->tableFields['modified_date'] = date("Y-m-d H:i:s");
		}
	}
	

	/**
	 * Placeholder for the construct
	 *
	 * @return void
	 */
	function __construct() {
	}
	
	/**
	 * Filter a record for visual representation like details
	 *
	 * @return void
	 */
	public function __clone() {
		$this->validation_model = 'Hidden for detail purpose.';
		$this->OABuffer = 'Hidden for detail purpose';
	}
	
	/**
	 * Setter overwrite to insert into tableFields
	 *
	 * @return void
	 */
	function __set($name, $value) {
		$name = preg_replace('/[- ]/', '_', $name);
		 
		if (method_exists($this, 'set'.ucfirst($name))) {
			$this->tableFields[$name] = $value;
		} else {
			WE::include_library('Db/Record/Exception/Exception');
			throw new WE_Db_Record_Exception('Mismatch in model and data: unable to assign a value of a key that does not exist: '.$name);
		}
	}
	 
	/**
	 * Getter overwrite to retrieve from tableFields
	 *
	 * @return void
	 */
	function __get($name) {
		if (method_exists($this, 'get'.ucfirst($name))) {
			return $this->tableFields[$name];
		} else {
			WE::include_library('Db/Record/Exception/Exception');
			throw new WE_Db_Record_Exception('Mismatch in model and data: unable to return a value of a key that does not exist: '.$name);
		}
	}
	
	/**
	 * This will look up if a record with given information exists.
	 * If not, then we should populate an empty model
	 *
	 * You can provide "search" arguments in the form of an array with the following arguments as options:
	 * 		- "" (empty/default) 	=> MYSQL equivalent of LIKE "data"
	 * 		- "%X" Wild Left 		=> MYSQL equivalent of LIKE "%data"
	 * 		- "X%" Wild Right 		=> MYSQL equivalent of LIKE "data%"
	 *  	- "%%" Wild Both 		=> MYSQL equivalent of LIKE "%data%"
	 *
	 * @return WE_Record
	 */
	public function createIfNotExist($data, $search = array())
	{
		$exists = $this->findColumnData($data,$search);
	
		if ($exists == false)
		{
			$this->populate($data);
			return $this;
		}
		else
		{
			return $exists;
		}
	}
	
	
	
	/**
	 * Assisting function: get the errors of the record
	 *
	 * @return $errors
	 */
	public function getErrors ()
	{
		return $this->errors;
	}
	
	/**
	 * Assisting function: get the record's table name
	 *
	 * @return $table
	 * @throws {@link Db_Exception}
	 */
	public function getTableName() {
		if (!is_null($this->table))	{
			return $this->table;
		} else {
			WE::include_library('Models/Record/Exception/Exception');
			throw new WE_Db_Exception('A model should have a $table set.');
		}
	}
	
	public function getValidationModel()
	{
		return $this->validation_model;
	}
	
	/**
	 * Assisting function: get the tableFields as array
	 *
	 * @return $tableFields
	 */
	public function getValuesAsArray ()
	{
		return $this->tableFields;
	}
	
	/**
	 * Assisting function: check if the record is empty (primaries)
	 *
	 * @return boolean true|false
	 */
	public function isEmpty() {
		foreach($this->primary as $primary) {
			if (empty($this->tableFields[$primary])) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Assisting function: validate the record
	 *
	 * @return boolean true|false
	 */
	public function isValid () {
		$this->validate();
		if (count($this->errors) == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Assisting function: poluplate the tableFields array with recorddata
	 * Safe mode is default true. Can't set fields that the record does not have
	 *
	 * @return void
	 */
	public function populate($aColumns, $safe = true)
	{
		if (is_array($aColumns))
		{
			foreach ($aColumns as $column => $value)
			{
				if (array_key_exists($column, $this->tableFields))
				{
					if ($safe)
					{
						$function = "set" . ucfirst($column);
						$this->{$function}($value);
					}
					else
					{
						$this->tableFields[$column] = $value;
					}
				}
			}
		}
	}
	
	/**
	 * Set the status of the current record to deleted
	 *
	 * @return void
	 */
	public function softDelete()
	{
		if (method_exists($this,"setDeleted")) {
			$this->setDeleted(1);
			return $this->save();
		} else {
			return false;
		}
	}

	/**
	 * Assisting function: set an error to the record
	 *
	 * @param string $msg
	 * @return void
	 */
	public function setError ($msg)
	{
		$this->errors[] = $msg;
	}
	
    /**
     * Force insertion of an record instead of updating. Useful for cloning records.
     *
     * @return void
     */
	public function setForceAdd($forceAdd)
	{
		$this->forceAdd = $forceAdd;
	}
	
	/**
	 * Remove the current record from the database or set the status to deleted
	 *
	 * Try to run the query for the deletion of this record (by primaries)
	 * Default is "hard" delete
	 *
	 * @return boolean true|false
	 */
	abstract public function delete();
	
	/**
	 * This function tests if a prepopulated model allready exists in the database. This check will only be done on the primary fields!
	 *
	 * @set	this WE_Db_Record
	 * @return bool: true|false
	 */
	abstract public function exists();
	
	/**
	 * Find a record by (mixed) primaries
	 *
	 * @param $primary array (assoc) 
	 * @return mixed null|WE_Record
	 * @throws {@link Db_Exception}
	 */
	abstract public function find ($primary);
	
	/**
	 * Find a single record and make an object representation of it.
	 *
	 * Usage examples:
	 *   // Find one model with `name` = 'John'
	 *   $myModel = Db::getModel('myModel')->findColumnData(array('name'=>'John'));
	 *   // Find oldest model with `name` = 'John' (ORDER BY `birth_date` LIMIT 1)
	 *   $myModel = Db::getModel('myModel')->findColumnData(
	 *        array('name'=>'John'),
	 *        array(WE_Record::ORDER_ASC_BY_COLUMN=>'birth_date')
	 *   );
	 *   // Find one model with `name` LIKE 'John%'
	 *   $myModel = Db::getModel('myModel')->findColumnData(
	 *        array('name'=>'John%'),
	 *        array(WE_Record::USE_WILDCARD_ON_COLUMN=>'name')
	 *   );
	 *
	 * @param array $data Associative array with all the columns you wish to
	 *     search on and their values.
	 * @param array $parameters Associative array with search and order options.
	 *     Valid keys: WE_Record::ORDER_ASC_BY_COLUMN, WE_Record::ORDER_DESC_BY_COLUMN,
	 *     WE_Record::USE_MORE_THAN_ON_COLUMN, WE_Record::USE_LESS_THAN_ON_COLUMN  
	 *     and WE_Record::USE_WILDCARD_ON_COLUMN. Values should be column names or an
	 *     array of column names.
	 * @return WE_Record|false
	 * @throws {@link Db_Exception}
	*/
	abstract public function findColumnData ($data, $parameters = array());
	
	/**
	 * Save or update the currect record object representation
	 * A validation check in this function mandatory
	 * Upon save: set the primary to match the stored record id('s)
	 *
     * @return object $this|false
	 * @throws {@link Db_Exception}
	*/
	abstract public function save ($foceAdd = false, $useCCMMadd = true);
	
}
?>
