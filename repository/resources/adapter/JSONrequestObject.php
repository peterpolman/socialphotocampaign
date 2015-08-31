<?php 
/**
 * JSON Request Object
 * @author Guido
 */

class JSONrequestObject {
	public $requesttype;								// The request type (can be model,table,getModelDb,getTableDb)
	public $name;										// Model/Table name
	public $function;									// Function of Model/Table
	public $parameters = array();						// Parameters for the function
	public $object = array();							// Context object array to send
	private $debug = false;								// Debug value
	
	/**
	 * Constructor to set debug
	 */
	public function __construct() {						// Constructor
		$this->debug = Config::get('install','debug');	// Set the debug value (system determined)
	}
	
	/**
	 * Convert this object to a JSON correct string
	 * @return string
	 */
	public function getJsonArray() {					// Convert this object to a json type array and return it as a string
		$return = array();
		$return['request-type'] = $this->requesttype;
		$return['name'] = $this->name;
		$return['function'] = $this->function;
		$return['parameters'] = $this->parameters;
		$return['object'] = $this->object;
		$return['debug'] = $this->debug;
		
		return json_encode($return,true);				// Return the encoded json type array as string
	}
}


?>