<?php
/**
 * Database Record Handler
 * @author Wame
 *
 */
WE::include_library('Models/Record');

abstract class WE_Db_Record extends WE_Record
{	
	protected $db 		= null;						// An instance of the database
	
	public function __construct($db = null) {
		parent::__construct();
		if ($db == null) {
			$this->db = Db::getInstance();
		} else {
			$this->db 	= $db;
		}
	}
	
	function __clone() {
		parent::__clone();
		$this->db = 'Not visible in clone';
	}
	
	/**
	 * Remove the current record from the database or set the status to deleted
	 *
	 * Try to run the query for the deletion of this record (by primaries)
	 * Default is "hard" delete
	 *
	 * @return boolean true|false
	 */
	public function delete ()
	{
		if (is_array($this->primary)) {
			$rules 	= array();
			$values = array();
			foreach($this->primary as $field) {
				$rules[] = $field." = :".$field;
				$values[':'.$field] = $this->tableFields[$field];
			}
			$where = implode(' AND ',$rules);
		} else {
			WE::include_library('Models/Record/Exception/Exception');
			throw new WE_Db_Record_Exception('Old model type used. Please update with new model.');
		}

		$sql = "DELETE FROM ".$this->table." WHERE ".$where;
		try {
			$r = $this->db->query($sql,$values);
			return true;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	/**
	 * This function tests if a prepopulated model allready exists in the database. This check will only be done on the primary fields!
	 * The model will be populated if it does exits!
	 *
	 * @set	this WE_Db_Record
	 * @return bool: true|false
	 */
	public function exists()
	{
		$search = array();
		foreach($this->primary as $primary) {
			$search[$primary] = $this->tableFields[$primary];
		}

		try {
			return $this->findColumnData($search);
		} catch (Exception $e) {
			return false;
		}
	}
	
    /**
     * Save or update the currect record object representation
     *
     * @return object $this|false
     * @throws {@link Db_Exception}
     */
	public function save ($foceAdd = false, $useCCMMadd = true) 
	{
		$db = $this->db;
		
		// The remote requests should have this as false since they have been filled
		if ($useCCMMadd == true) {
			$this->CCMMadd();
		}
		
		if ($this->forceAdd == null) {
			$this->forceAdd = $foceAdd;
		}
		
		if ($this->isValid()) {
			$table = $this->table;
			
			$add = true;
			foreach($this->primary as $primary)
			{
				if ($this->tableFields[$primary] != null)
				{
					$add = false;
					break;
				}
			}
			$primary = implode(', ', $this->primary);
			
			// Check wheter we need to insert the record or update an existing one
			if ($add == true || $this->forceAdd == true || count($this->primary) > 1) {
				
				// Check for preSave events
				if (method_exists($this, 'preInsert')) {
					$this->preInsert();
				}
			
				// New record
				if (count($this->primary) > 1) {
					$sql = 'REPLACE INTO `'.$this->getTableName().'` ';
				} else {
					$sql = 'INSERT INTO `'.$this->getTableName().'` ';
				}
			
				$aColumns = array();
				$aValues = array();
				$aInput = array();
			
				foreach ($this->tableFields as $column => $value) {
					if ($column != $this->primary || $this->forceAdd == true)
					{
						if (!is_null($value))
						{
							$aColumns[] = '`'.$column.'`';
							$aValues[] = ":".$column;
							$aInput[$column] = $value;
						} else {
							if ($this->validation_model[$column]['null'] == true) {
								$aColumns[] = '`'.$column.'`';
								$aValues[] = "NULL";
							}
						}	
					}
				}
				
				$sql .= '('.implode(',', $aColumns).') VALUES ('.implode(',', $aValues).')';
				
				$db->query($sql,$aInput);
				

				if (array_key_exists($this->autoIncrement, $this->tableFields)) {
					
					$this->tableFields[$this->autoIncrement] = $db->lastInsertId();
				}

				// Check for preSave events
				if (method_exists($this, 'postInsert')) {
					$this->postInsert();
				}
			} else {
				// Existing record
				$sql = 'UPDATE `'.$this->table.'` SET ';
			
				$aFields = array();
				$aEscape = array();
			
				foreach ($this->tableFields as $column => $value)
				{
					if (!in_array($column, $this->primary)) {
						if (!is_null(($value)))
						{
							$aFields[] = '`'.$column.'`=:'.$column;
							$aEscape[$column] = $value;
						}
						else
						{
							if ($this->validation_model[$column]['null'] == true) {
								$aFields[] = '`'.$column.'`= NULL';
							}
						}
					} else {
						$aEscape[$column] = $value;
					}
				}
			
				$sql .= implode(',', $aFields);
			
				
				$sqlp = array();
				foreach($this->primary as $primary) {
					$sqlp[] = $primary.'=:'.$primary;
				}
				
				$sql .= ' WHERE '.implode(' AND ', $sqlp);
				
				$db->query($sql, $aEscape);
			}
			
			return $this;
		} else {
			return false;
		}
	}

	/**
	 * Find a record by primaries
	 *
	 * @param $primary mixed (assoc) 
	 * @return mixed null|WE_Record
	 * @throws {@link Db_Exception}
	 */
	public function find ($primary)
	{
		$db = $this->db;
		if (!empty($primary)) {
			if (!is_array($primary)) {
				$primary = array($this->primary[0]=>$primary);
			}

			if (count($this->primary) == count($primary)) {
				foreach($primary as $field=>$value) {
					if (!in_array($field,$this->primary)) {
						WE::include_library('Models/Record/Exception/Exception');
						throw new WE_Db_Record_Exception('Invalid fields for primary given.');
					}
				}
				$rules = array();
				foreach($this->primary as $field) {
					$rules[] = $field." = :".$field;
				}
				$search = implode(' AND ',$rules);
			} else {
				WE::include_library('Models/Record/Exception/Exception');
				throw new WE_Db_Record_Exception('The number of primary key fields do not match with the given fields.');
			}

		} else {
			WE::include_library('Models/Record/Exception/Exception');
			throw new WE_Db_Record_Exception('No values given to load the record.');
		}
		
		
		$sql = "SELECT * FROM `".$this->getTableName()."` WHERE ".$search;
		
		$r = $db->query($sql,$primary);
		
		if ($r->rowCount() == 1) {
			$this->populate($r->fetch(PDO::FETCH_ASSOC));
			return $this;
		} elseif ($r->rowCount() > 1) {
			WE::include_library('Models/Record/Exception/Exception');
			throw new WE_Db_Record_Exception('Multiple records have been returned.');
		} else {
			return null;
		}
	}
	
	/**
	 * @see WE_Record::findColumnData()
	 */
	public function findColumnData ($data, $parameters = array())
	{
		$db = $this->db;
		$sqlentry 	= array();
		$values		= array();

		$sql = "SELECT * FROM `".$this->getTableName()."` ";
		
		// Are we using one or more wildcards?
		if ( array_key_exists(WE_Record::USE_WILDCARD_ON_COLUMN, $parameters)) {
			$use_like = $parameters[WE_Record::USE_WILDCARD_ON_COLUMN];
			if ( !is_array($use_like) ) 
				$use_like = array($use_like);
		} else {
			$use_like = array();
		}
		
		// Are we using one or more less thans?
		if ( array_key_exists(WE_Record::USE_LESS_THAN_ON_COLUMN, $parameters)) {
			$use_less = $parameters[WE_Record::USE_LESS_THAN_ON_COLUMN];
			if ( !is_array($use_less) ) 
				$use_less = array($use_less);
		} else {
			$use_less = array();
		}
		
		// Are we using one or more more thans?
		if ( array_key_exists(WE_Record::USE_MORE_THAN_ON_COLUMN, $parameters)) {
			$use_more = $parameters[WE_Record::USE_MORE_THAN_ON_COLUMN];
			if ( !is_array($use_more) ) 
				$use_more = array($use_more);
		} else {
			$use_more = array();
		}
		
		// Are we using one or more date only compares?
		if ( array_key_exists(WE_Record::USE_DATE_ONLY_ON_COLUMN, $parameters)) {
			$use_date = $parameters[WE_Record::USE_DATE_ONLY_ON_COLUMN];
			if ( !is_array($use_date) ) 
				$use_date = array($use_date);
		} else {
			$use_date = array();
		}
		
		// Walk through each column name in $data and add the constraint
		foreach($data as $column=>$value)
		{
			if (in_array($column,$use_like)) {
				// Using a wildcard here
				$sqlentry[] = '`'.$column."` LIKE :".$column;
				$values[$column] = $value;
			} elseif ( in_array($column,$use_less) ) {
				// Using less than here
				$sqlentry[] = '`'.$column."` < :".$column;
				$values[$column] = $value;
			} elseif ( in_array($column,$use_more) ) {
				// Using more than here
				$sqlentry[] = '`'.$column."` > :".$column;
				$values[$column] = $value;
			} elseif ( in_array($column,$use_date) ) {
				// Using date only compare here
				$sqlentry[] = 'DATE_FORMAT(`'.$column.'`, :'.$column.'_date_format) = :'.$column;
				$values[$column] = $value;
				$values[$column.'_date_format'] = "%Y-%m-%d";
			} else {
				// Normal compare
				if ( $value === null ) {
					$sqlentry[] = '`'.$column."` IS NULL";
				} else {
					$sqlentry[] = '`'.$column."` = :".$column;
					$values[$column] = $value;
				}
			}
		}
		
		// Do we have a WHERE clause?
		if ( count($sqlentry) > 0 ) {
			$sql .= "WHERE ";
			$sql .= implode(' AND ',$sqlentry);
		}
		
		// Order by ascending fields
		if ( array_key_exists(WE_Record::ORDER_ASC_BY_COLUMN, $parameters)) {
			$order_asc_fields = array();
			$order_asc = $parameters[WE_Record::ORDER_ASC_BY_COLUMN];
			if ( !is_array($order_asc) )
				$order_asc = array($order_asc);
			foreach ( $order_asc as $order ) {
				$order_asc_fields[] = $order;
			}
			$sql .= " ORDER BY `".implode(', ',$order_asc_fields)."` ASC ";
		}
		
		// Order by descending fields
		if ( array_key_exists(WE_Record::ORDER_DESC_BY_COLUMN, $parameters)) {
			$order_desc_fields = array();
			$order_desc = $parameters[WE_Record::ORDER_DESC_BY_COLUMN];
			if ( !is_array($order_desc) )
				$order_desc = array($order_desc);
			foreach ( $order_desc as $order ) {
				$order_desc_fields[] = $order;
			}
			$sql .= " ORDER BY `".implode(', ',$order_desc_fields)."` DESC ";
		}
		
		$sql .= " LIMIT 1";
		
		$r = $db->query($sql,$values);

		switch ($r->rowCount())
		{
			case 0:
				return false;
			case 1:
				$this->populate($r->fetch(PDO::FETCH_ASSOC));
				return $this;
			default:
				WE::include_library('Models/Record/Exception/Exception');
				throw new WE_Db_Record_Exception('Multiple records have been returned.');
		}
	}
}
?>
