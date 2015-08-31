<?php
abstract class WE_Db_Table implements Countable
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
		WE::include_library('Model/Db/Record');

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
     * Find records and make record representations with the object by a column and a value
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param array $values
     * @return $this
     * @throws {@link WE_Db_Record_NoRecordFoundException}		In case of NO or MULTIPLE records found
     */
	public function findColumn($where='',$order='',$limit='',$values = array())
	{
		$sql = "SELECT * FROM `".$this->table."`";

		if ($where!='') {
			$sql.= ' WHERE '.$where;
		}
		if ($order!='') {
			$sql.= ' ORDER BY '.$order;
		}
		if ($limit!='') {
			$sql.= ' LIMIT '.$limit;
		}
		
		return $this->setResultset($sql,$values);
	}
	
    /**
     * Find records and make record representations with the object by a column and a value
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param array $values
     * @return $this
     * @throws {@link WE_Db_Record_NoRecordFoundException}		In case of NO or MULTIPLE records found
     */
	public function findByColumn($column,$value)
	{
		$sql = "SELECT * FROM `".$this->table."`
				WHERE `".$column."` = :value";

		return $this->setResultset($sql,array('value'=>$value));
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