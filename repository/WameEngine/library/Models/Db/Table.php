<?php
WE::include_library('Models/Table');
abstract class WE_Db_Table extends WE_Table implements Countable
{
	
	protected $table;
	protected $primary;
	protected $gotresults = 0;
	protected $numresults = 0;
	
	protected $result;
	
	
	protected $db = null;

	public function __construct($db = null) {
		if ($db == null) {
			$db = Db::getInstance();
		}
		$this->db 	= $db;
	}
	
	function __clone() {
		$this->db = 'Not visible in clone';
	}
	
	//THIS USED TO BE PROTECTED 
	public function setResultset($query,$vars)
	{
		$modelName = ucfirst($this->table);
		WE::include_library('Models/Db/Record');

		if (Config::get('install','debug') == true && (!file_exists(Config::get('install','resourcedir').'model/'.$modelName.'.php') || !file_exists(Config::get('install','resourcedir').'model/db/'.$modelName.'.php'))) {
			$this->db->getModel($modelName);
		}
		
		WE::include_model($modelName);
		$this->result = $this->db->query($query,$vars);
		$this->numresults = $this->result->rowCount();
		$this->result->setFetchMode(PDO::FETCH_INTO, new $modelName($this->db));
		return $this;
	} 
	
	/**
	 * Return the resultset
	 * Usage in foreach:
	 * foreach($table->getResult() as $record)
	 * {
	 * 		$record->doRecordStuff();
	 * }
	 *
	 * @return result
	 */
    public function getResult()
    {
    	if ($this->gotresults == 1) {
    		$this->reExecute();
    	}
    	$this->gotresults = 1;
        return $this->result;
    }
    
	/**
	 * Return the resultset as one array
	 * Note that this is memory inefficient compared to getResult()
	 *
	 * @return result
	 */
    public function getResultArray($array = false,$primary = 'id')
    {
    	$return = array();
    	$modelName = ucfirst($this->table);
    	if ($this->gotresults == 1) {
    		$this->reExecute();
    	}
    	$this->gotresults = 1;
			
        $tmp = $this->result->fetchAll(PDO::FETCH_ASSOC);

        if ($array == true) {
        	foreach($tmp as $row) {
        		if (key_exists($primary, $row)) {
        			$return[$row[$primary]] = $row;
        		} else {
        			$return = $tmp;
        			break;
        		}
        	}
		} else {
	        foreach($tmp as $row)
	        {
	        	$dummy = $this->db->getModel($modelName);
	        	$dummy->populate($row);
	        	if (key_exists($primary, $row)) {
	        		$return[$dummy->$primary] = $dummy;
	        	} else {
	        		$return[] = $dummy;
	        	}
	        }
		}
        return $return;
    }
    
    /**
     * @see WE_Table::findColumnData()
     */
	public function findColumnData ($data, $parameters = array(), $limit = null)
	{
		$db = $this->db;
		$sqlentry 	= array();
		$values		= array();

		$sql = "SELECT * FROM `".$this->table."` ";
		
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
		
		// Walk through each column name in $data and add the constraint
		foreach($data as $column=>$value)
		{
		if (in_array($column,$use_like)) {
				// Using a wildcard here
				$sqlentry[] = '`'.$column."` LIKE :".$column;
				$values[$column] =  $value;
			} elseif ( in_array($column,$use_less) ) {
				// Using less than here
				$sqlentry[] = '`'.$column."` < ".$column;
				$values[$column] =  $value;
			} elseif ( in_array($column,$use_more) ) {
				// Using more than here
				$sqlentry[] = '`'.$column."` > ".$column;
				$values[$column] =  $value;
			} else {
				// Normal compare
				$sqlentry[] = '`'.$column."` = :".$column;
				$values[$column] =  $value;
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
				$order_asc_fields[] = $order." ASC";
			}
			$sql .= " ORDER BY ".implode(', ',$order_asc_fields);
		}
		
		// Order by descending fields
		if ( array_key_exists(WE_Record::ORDER_DESC_BY_COLUMN, $parameters)) {
			$order_desc_fields = array();
			$order_desc = $parameters[WE_Record::ORDER_DESC_BY_COLUMN];
			if ( !is_array($order_desc) )
				$order_desc = array($order_desc);
			foreach ( $order_desc as $order ) {
				$order_desc_fields[] = $order." DESC";
			}
			$sql .= " ORDER BY ".implode(', ',$order_desc_fields);
		}
		
		if ( is_numeric($limit) )
			$sql .= " LIMIT $limit";
		elseif ( is_array($limit) )
			$sql .= " LIMIT ".$limit[0].", ".$limit[1];
		
		return $this->setResultset($sql,$values);
	}
    
	/**
	 * Implementation of count. To use as $var->count() or count($var)
	 *
	 * @return$this->numresults
	 */
    public function count()
    {
    	return $this->numresults;
    }
    
	/**
	 * Option to re-execute the query. This needs to be done in certain situations.
	 * It is not usual to do and should be avoided as much as possible
	 *
	 * @return result
	 */
    private function reExecute()
    {
    	$this->result->execute();
    }
	
	public function sqlArray($sql)
	{
		$r = $this->db->query($sql);
		
		$aArray = array();
		if ($r->rowCount() > 0) {
			$aArray = $r->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $aArray;
	}
	
	public function getAll()
	{
		$query = "SELECT * FROM `".$this->table."`";
		$vars = array();
		return $this->setResultset($query,$vars);
	}
	
	public function getAllToArray()
	{
		$query = "SELECT * FROM `".$this->table."`";
		$vars = array();
		return $this->setResultset($query,$vars,true);
	}
}
?>