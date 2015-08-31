<?php
abstract class WE_Table implements Countable
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
    abstract public function getResult();
    
	/**
	 * Return the resultset as one array
	 * Note that this is memory inefficient compared to getResult()
	 *
	 * @return result
	 */
    abstract public function getResultArray($array = false,$primary = 'id');
    
	/**
	 * Find multiple records and make an object representation of them.
 	 *
	 * Usage examples:
	 *   // Find models with `name` = 'John'
	 *   $myTable = Db::getTable('myModel')->findColumnData(array('name'=>'John'));
	 *   // Find only one model with `name` = 'John'
	 *   $myTable = Db::getTable('myModel')->findColumnData(
	 *        array('name'=>'John'),
	 *        array(),
	 *        1
	 *   );
	 *   // Find models with `name` = 'John', ordered by column `birth_date`
	 *   $myTable = Db::getTable('myModel')->findColumnData(
	 *        array('name'=>'John'),
	 *        array(WE_Record::ORDER_ASC_BY_COLUMN=>'birth_date')
	 *   );
	 *   // Find models with `name` LIKE 'John%'
	 *   $myTable = Db::getTable('myModel')->findColumnData(
	 *        array('name'=>'John%'),
	 *        array(WE_Record::USE_WILDCARD_ON_COLUMN=>'name')
	 *   );
	 *   // Find a maximum of five models with a name starting with 'J' from
	 *   // Misouri, ordered by date of birth (youngest first) and then name
	 *   // in reverse alphabetical order.
	 *   $myTable = Db::getTable('myModel')->findColumnData(
	 *        array(
	 *            'name'=>'J%',
	 *            'state'=>'Misouri'
	 *        ),
	 *        array(
	 *            WE_Record::USE_WILDCARD_ON_COLUMN=>'name',
	 *            WE_Record::ORDER_DESC_BY_COLUMN=>array('birth_date','name')
	 *        ),
	 *        5
	 *   );
	 *
	 * @param array $data Associative array with all the columns you wish to
	 *     search on and their values.
	 * @param array $parameters Associative array with search and order options.
	 *     Valid keys: WE_Record::ORDER_ASC_BY_COLUMN, WE_Record::ORDER_DESC_BY_COLUMN,
	 *     WE_Record::USE_MORE_THAN_ON_COLUMN, WE_Record::USE_LESS_THAN_ON_COLUMN  
	 *     and WE_Record::USE_WILDCARD_ON_COLUMN. Values should be column names or an
	 *     array of column names.
	 * @param int $limit Maximum number of records to be found
	 * @return WE_Table|false
	 * @throws {@link Db_Exception}
	*/
	abstract public function findColumnData ($data, $parameters = array(), $limit = null);
    
	abstract public function getAll();
	
}
?>