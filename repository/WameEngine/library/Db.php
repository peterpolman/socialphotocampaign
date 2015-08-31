<?php
/**
 * Database Handler
 * @author Wame
 *
 */
class Db implements Serializable {

	/**
	 * Instance of Db
	 */
	private static $_instance;
	/**
	 * @var PDO|null $_pdo
	 */
	private $_pdo = null;
	private $_pdo_statement = null;
	private $_active_transaction = false;
	private $dbname = null;
	
	
    public function serialize() {
        return serialize($this->dbname);
    }
    
    /* 2012-08-08 GJ: TODO: Als er meer databases geintroduceerd worden, dient er gebruik gemaakt te worden van een databasearray.
     * De Serialize en Unserialize functies dienen dan herschreven worden omwille van de sessie.
     * Dit gaat minder een probleem vormen wanneer de oude code van roma zal verdwijnen.
     * Het is belangrijk om te kijken naar de veranderingen voor models en tables.
     */
    
    public function unserialize($data) {
        $this->dbname = unserialize($data);
    }
	
	public function getDbName() {
		return $this->dbname;
	}

    /**
     * Enforce singleton; disallow cloning
     *
     * @return void
     */
    public function __clone()
    {
    }
	
    /**
     * Enforce singleton; disallow cloning
     *
     * @return Db
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
		
        return self::$_instance;
    }
    
	public function __construct() {
		$this->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), Config::get('db','database'));
	}
    
    
    /**
     * Connects to database using PDO layer
     *
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $dbname
     * @return void
     * @throws {@link Db_Exception}
     */
	public function connect($host, $user, $pass, $dbname)
	{
		// Check if the PHP PDO extension is loaded
	    if (!extension_loaded('pdo')) {
            WE::include_library('Db/Exception');
            throw new WE_Db_Exception('The PDO extension is required for this adapter but the extension is not loaded');
        }

        // Check if PDO mysql driver exists
        if (!in_array('mysql', PDO::getAvailableDrivers())) {
           	WE::include_library('Db/Exception');
            throw new WE_Db_Exception('The mysql driver for PDO is not currently installed');
        }
        
        // Try to connect to the databse using PDO
		try 
		{
			$this->_pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
			$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		} 
		catch (PDOException $e)
		{
			WE::include_library('Db/Exception');
			throw new WE_Db_Exception($e->getMessage());
		}
		$this->dbname = $dbname;
		$this->startTransaction();
	}
	
	public function disableBuffer() {
		if ($this->hasActiveTransaction()) {
			$this->commitTransaction();
		}
		$this->_pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
		
	}
	
	public function enableBuffer() {
		if ($this->hasActiveTransaction()) {
           	WE::include_library('Db/Exception');
            throw new WE_Db_Exception('You can\'t enable the buffer if there is an active transaction!');
		}
		
		$this->_pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		$this->startTransaction();
	}

    /**
     * Disconnect the PDO layer
     *
     * @return void
     */
	public function disconnect()
	{
		$this->_pdo = null;
	}

	/**
     * Get the last inserted Id from PDO layer
     *
     * @return PDO::lastInsertId
     */
	public function lastInsertId()
	{
		return $this->_pdo->lastInsertId();
	}
	
	/**
     * Execute a PDO query
     *
     * @param string $sql
     * @param string $aInputParameters
     * 
     * @return PDOStatement
     */
	public function query($sql, $aInputParameters = null, $validate = true) {
		//This validation could be expanded.
		if ($validate == true) {
			while (strpos($sql,'  ') !== false) {																//Remove any double spaces in the query;
	     		$sql = str_replace('  ',' ',$sql);
			}

			$search  = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
			$replace = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
			
			$tInputParameters = array();
			if ($aInputParameters != null) {
				foreach($aInputParameters as $field=>$value) {
					if (preg_match("/[0-9]/", $field) !== 0) {
						$tfield = str_replace($search, $replace, $field);
						
						$sqlfix = $sql;
						$sqlfix = str_replace(':'.$field.' ', ':'.$tfield.' ', $sql);	//Most common spacing
						if ($sqlfix == $sql) {
							$sqlfix = str_replace(':'.$field.',', ':'.$tfield.',', $sql);	//Less common spacing
						}
						if ($sqlfix == $sql) {
							$sqlfix = str_replace(':'.$field, ':'.$tfield, $sql);			//Rare spacing 
						}
						
						$sql = $sqlfix;
						
						$tInputParameters[$tfield] = $value;
					} else {
						$tInputParameters[$field] = $value;
					}
				}
			}
			
			$aInputParameters = $tInputParameters;
			
			if (strpos($sql,"'") !== false || strpos($sql,'"') !== false) {										//Check if there is some unauthorised escaping;
				if (strpos($sql,"'") !== false) {
					$escape = "'";
				}
				if (strpos($sql,'"') !== false) {
					$escape = '"';
				}
				
				$startpos = strpos($sql,$escape);
				
				$unsafe = substr($sql,strpos($sql,$escape));
				$unsafe = substr($unsafe,0,strpos(substr($unsafe,1),$escape)+2);
				$unsafe = htmlspecialchars($unsafe);
				
				if (WE_ErrorHandler::getInstance()->getAllowQuery()) {
					WE_ErrorHandler::getInstance()->addQuery("FAILED: ".$sql,$aInputParameters);
				}
				WE::include_library('Db/Exception');
				throw new WE_Db_Exception("There are predifined variables and thus potentially unsafe: ".$unsafe);
			}

			if (preg_match("/[0-9]/", $sql) !== 0) {															//Check if there is a numeric value in the raw SQL query
				$checksql = (preg_replace('/`[^`]*`/s','', $sql));
				
				foreach($aInputParameters as $parameter=>$value)
				{
					$checksql = str_replace(':'.$parameter, '', $checksql);
				}
				
				if (strpos($checksql,'LIMIT') != false) {
					$limitpos = strpos($checksql,'LIMIT');
				} else {
					$limitpos = strlen($checksql);
				}

				if (preg_match("/[0-9]/", substr($checksql,0,$limitpos)) !== 0) {
					if (WE_ErrorHandler::getInstance()->getAllowQuery()) {
						WE_ErrorHandler::getInstance()->addQuery("FAILED: ".$sql,$aInputParameters);
					}
					WE::include_library('Db/Exception');
					throw new WE_Db_Exception("Unescaped numeric variables found and thus potentially unsafe. Use `field` escaping for fields.");
				}
			}
		}
		
		if (WE_ErrorHandler::getInstance()->getAllowQuery()) {
			WE_ErrorHandler::getInstance()->addQuery($sql,$aInputParameters);
		}
		
		if (is_null($aInputParameters)) {
			// Execute sql statement on active connection
			$this->_pdo_statement = $this->_pdo->query((string) $sql);
		} else {
			$this->_pdo_statement = $this->prepare($sql);
			$this->execute($aInputParameters);
		}
		
		if ($this->_pdo_statement === false) {
			WE::include_library('Db/Exception');
			throw new WE_Db_Exception("The query could not be executed.");
		}
		
		return $this->_pdo_statement;
	}

	/**
     * PDO prepare
     *
     * @param string $statement
     * 
     * @return PDO->prepare
     */
	public function prepare ($statement)
	{
		return $this->_pdo->prepare((string) $statement);
	}

	/**
     * PDO execute
     *
     * @param string $input_parameters
     * 
     * @return PDOStatement->execute
     */
	public function execute ($input_parameters)
	{
		return $this->_pdo_statement->execute($input_parameters);
	}

	/**
     * PDO escape
     *
     * @param string $string
     * 
     * @return PDO->quote
     */
	public function escape ($string)
	{
		return $this->_pdo->quote((string) $string);
	}
	
	/**
     * PDO escape
     *
     * @param string $string
     * 
     * @return PDO->quote
     */
	public function escape_string ($string)
	{
		//mysqli::real_escape_string($string);
		//return $this->_pdo->quote((string) $string);
		return $string;
	}

	/**
     * Get a Model
     *
     * @param string $model
     * 
     * @return WE_Db_Record
     * @throws WE_Db_Exception
     */
	static public function getModel ($model)
	{
		$model = ucfirst($model);
		WE::include_library('Models/Db/Record');
		try {
			WE::include_model($model);
			return new $model(self::getInstance());
		} catch (Config_Exception $e) {
			if (Config::get('install','debug') == true)						//Als de model niet bestaat, probeer deze dan aan te maken indien in debug modus. Geef anders een fout.
			{
				WE::include_library('Db/Creator');								//Het aanmaak deel.
				$Creator = new WE_Db_Creator(self::getInstance());
				$Creator->createModel($model);
				
				require_once(Config::get('install','resourcedir').'model/'.$model.'.php');								//Indien geen error komen we hier en wordt deze gebruikt alsof er niets aan de hand is.
				return new $model;
			}
			else 
			{
				WE::include_library('Db/Exception');
				throw new WE_Db_Exception("Er bestaat geen table `$table`.");
			}
		}
	}
	
	static public function createModel($model)
	{
		if (Config::get('install','debug') == true)						//Als de model niet bestaat, probeer deze dan aan te maken indien in debug modus. Geef anders een fout.
		{
			WE::include_library('Db/Creator');								//Het aanmaak deel.
			$Creator = new WE_Db_Creator(self::getInstance());
			$Creator->createModel($model);
		}
	}
	
	/**
     * Get a Table
     *
     * @param string $table
     * 
     * @return WE_Db_Table
     * @throws WE_Db_Exception
     */
	static public function getTable ($table)
	{
		$table = ucfirst($table);
		WE::include_library('Models/Table');
		WE::include_library('Models/Remote/Table');
		WE::include_library('Models/Db/Table');
		
		try {
			WE::include_table($table);
			$className = $table.'Table';
			return new $className(self::getInstance());
		} catch (Config_Exception $e) {
			if (Config::get('install','debug') == true)
			{
				WE::include_library('Db/Creator');								//Het aanmaak deel.
				$Creator = new WE_Db_Creator(self::getInstance());
				$Creator->createTable($table);
				
				require_once(Config::get('install','resourcedir').'table/'.$table.'Table.php');						//Indien geen error komen we hier en wordt deze gebruikt alsof er niets aan de hand is.
				//details (Config::get('install','resourcedir').'table/'.$table.'Table.php');
				$className = $table.'Table';
				
				return new $className;
			}
			else 
			{
				WE::include_library('Db/Exception');
				throw new WE_Db_Exception("Er bestaat geen table `$table`.");
			}
		}
	}

    /**
     * PDO startTransaction
     *
     * @return void
     */
	public function startTransaction ()
	{
		$this->_pdo->beginTransaction();
		$this->_active_transaction = true;
	}
	
    /**
     * PDO commitTransaction
     *
     * @return void
     */
	public function commitTransaction ()
	{
		$this->_pdo->commit();
		$this->_active_transaction = false;
	}
	
    /**
     * PDO rollbackTransaction
     *
     * @return void
     */
	public function rollbackTransaction () 
	{
		$this->_pdo->rollBack();
		$this->_active_transaction = false;
	}
	
    /**
     * PDO hasActiveTransaction
     *
     * @return void
     */
	public function hasActiveTransaction () {
		return $this->_active_transaction;
	}

	 /**
     * PDO finishTransaction
     *
     * @return void
     */
	public function finishTransaction() {
		if ($this->hasActiveTransaction()) {
			if (WE_ErrorHandler::getInstance()->allowCommit() == true) {
				$this->commitTransaction();
			} else {
				details('ROLLBACK');
				$this->rollbackTransaction();
			}
		}
	}
}
?>