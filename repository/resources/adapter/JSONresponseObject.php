<?php 
/**
 * JSON Response Object
 * @author Guido
 */

class JSONresponseObject {
	public $requesttype;								// The request type (can be model,table,getModelDb,getTableDb)
	public $name;										// Model/Table name
	public $function;									// Function of Model/Table
	public $responsetype;								// success or error
	public $resulttype;									// Resulttype (Model/Table name or null)
	public $result = array();							// Data result of the response
	private $debug = false;								// Debug value
	
	/**
	 * Get the response array and populate this object with it
	 * @param $arraywithdata array
	 */
	public function __construct($arraywithdata) {
		$this->debug = Config::get('install','debug');

		foreach($arraywithdata as $key=>$value) {
			$key = str_replace("-", "", $key);

			if (property_exists($this,$key)) {
				$this->{$key} = $value;
			}
		}
	}
	
	/**
	 * Convert this object to a JSON correct string
	 * @return string
	 */
	public function getJsonArray() {
		$return = array();
		$return['request-type'] = $this->requesttype;
		$return['response-type'] = $this->responsetype;
		$return['name'] = $this->name;
		$return['function'] = $this->function;
		$return['parameters'] = $this->parameters;
		$return['debug'] = $this->debug;
		
		return json_encode($return,true);
	}
}


?>