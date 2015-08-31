<?php
/**
 * Database Record Validator
 * @author Wame
 *
 */
class RecordValidator
{	
	protected $validation_model	= null;
	protected $tableFields 		= null;
	protected $primary 			= null;
	protected $errors 			= array();
	protected $changedFields 	= false;
	
	public function getErrors() {
		return $this->errors;
	}
	
	public function getTableFields() {
		return $this->tableFields;
	}
	
	public function getChanged() {
		return $this->changedFields;
	}
	
	private function registerError($field,$type,$text) {
			$this->errors[$field][$type] = $text;
	}
	
	private function registerNotice($field,$type,$text) {
			$this->notice[$field][$type] = $text;
	}
	
	public function validate($model,$validation_model,$tableFields,$primary) {
		$this->validation_model = $validation_model;
		$this->tableFields 		= $tableFields;
		$this->primary 			= $primary;
	
		foreach($tableFields as $field=>$value) { 	//Loop trough the data for the record
			if ($this->checkNull($field))			//Make sure it is/isn't null when it should
			{
				$this->checkType($field);			//Check each type for the field
			}
		}
		
		foreach($this->errors as $type=>$error) {
			foreach($error as $errorkey=>$defaultmessage)
			{
				if (isset(WE::getInstance()->default_lang['model'][ucfirst($model)][$type]['validate'][$errorkey])) {
					$this->errors[$type][$errorkey] = WE::getInstance()->default_lang['model'][ucfirst($model)][$type]['validate'][$errorkey];
				} elseif (isset(WE::getInstance()->default_lang['model'][ucfirst($model)][$type]['title'])) {
					$this->errors[$type][$errorkey] = ucfirst(WE::getInstance()->default_lang['model'][ucfirst($model)][$type]['title']).$this->errors[$type][$errorkey];
				} else {
					$this->errors[$type][$errorkey] = ucfirst($type).$this->errors[$type][$errorkey];
				}
			}
		}
	}
	
	private function checkNull($field) {
		if (isset($this->validation_model[$field]['null'])) {//If null rule is set
			$value = ($this->tableFields[$field]);
			if ($this->validation_model[$field]['null'] == 1) {  // if can be null 
				if (is_null($value) || $value === '' || $value === false) {		//if it is null no further checks
					return false;
				} else {
					return true;
				}
			} else {	// IT MAY NOT BE NULL
				if (count($this->primary) == 1 && $field == $this->primary[0]) { //Exception that if a solitary primary key is null it is still allowed
					return false;
				}
				
				if (is_null($value) || $value === '' || $value === false) {	// actual null '' or false checking (note that 0 is allowed!)
					$this->registerError($field,'null_not',' mag niet leeg zijn.');
					return false;
				} else {			//It is validly not null and contains data
					return true;
				}
			}
		} else {
			return true;
		}
	}
	
	private function checkType($field) { //Check each type for the field
		if (isset($this->validation_model[$field]['type'])) { // Make sure a type is set to check
			$method = 'checkType'.ucfirst($this->validation_model[$field]['type']);
			if(method_exists($this, $method)) {	//Check if there is a method to check that type
				$this->$method($field);
			} else { // If not, create an exception since that is a function that should be implemented
				WE::include_library('Db/Record/Exception/Exception');
				throw new WE_Db_Record_Exception('No validation mode for the type: '.$this->validation_model[$field]['type']);
			}
		}
	}
	
	private function checkTypeInt($field) {	//Check the int type
		$value = $this->tableFields[$field];
		$validation = $this->validation_model[$field];

		if (is_numeric($value) && $value == intval($this->tableFields[$field])) { //Make sure it is an int
			if(isset($validation['min']) && $value < $validation['min']) { //Check if it is above the minimal value if set
				$this->registerError($field,'min',' is lager dan de toegestane waarde.');
			}
			if(isset($validation['max']) && $value > $validation['max']) { //Check if it is below the maximum value if set
				$this->registerError($field,'max',' is hoger dan de toegestane waarde.');
			}
			if(isset($validation['maxchar']) && strlen($value) > $validation['maxchar']) { //Check if max characters do not conflict
				$this->registerError($field,'maxchar',' bevat te veel karakters.');
			}
		} else {
			$this->registerError($field,'int_not',' is geen geheel getal.');
		}
	}
	
	private function checkTypeDecimal($field) {	//Check the decimal/float/double type
		$value = $this->tableFields[$field];
		$validation = $this->validation_model[$field];
		
		if (is_numeric($value))	{
			//Should be some more checks with decimal (and persicion perhaps)
		} else {
			$this->registerError($field,'decimal_not',' is geen nummer.');
		}
	}
	
	private function checkTypeVarchar($field) {	//Check the varchar type
		$value = $this->tableFields[$field];
		$validation = $this->validation_model[$field];
		
		if(isset($validation['maxchar']) && strlen($value) > $validation['maxchar']) { //Check if max characters do not conflict
			$this->registerError($field,'maxchar',' bevat te veel karakters.');
		}
	}
	
	private function checkTypeText($field) {	//Check the text type
		//$value = $this->tableFields[$field];
		//$validation = $this->validation_model[$field];
	}
	
	private function checkTypeYear($field) {
		$value = $this->tableFields[$field];
    	if (!preg_match("/^([0-9]{4})$/", $value)) {
    		$this->registerError($field,'year_not',' is niet in het juiste jaar formaat.');
    	}
	}
	
	private function checkTypeDate($field) {
		$value = $this->tableFields[$field];
    	if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $value)) {
    		if (date('Y-m-d',strtotime($value)) != $value && $value != '0000-00-00') {
    			$this->registerError($field,'date_invalid',' bevat een datum die niet bestaat of te ver in het verleden ligt.');
    		}
    	} else {
    		if ($this->checkTypeDatetime($field, true) == false) {
    			$this->registerError($field,'date_not',' is niet in het juiste datum formaat.');
    		} else {
    			$this->changedFields = true;
    			$this->tableFields[$field] =  substr($value,0,10);
    		}
    	}
	}
	
	private function checkTypeDatetime($field,$return = false) {
		$value = $this->tableFields[$field];
    	if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/", $value)) {
    		if (date('Y-m-d H:i:s',strtotime($value)) != $value && $value != '0000-00-00 00:00:00') {
    			if ($return == true) {
    				return false;
    			} else {
    				$this->registerError($field,'datetime_invalid',' bevat een datum/tijd combinatie die niet bestaat of te ver in het verleden ligt.');
    			}
    		}
    	} else {
        	if ($return == true) {
    			return false;
    		} else {
    			$this->registerError($field,'datetime_not',' is niet in het juiste datum/tijd formaat.');
    		}
    	}
    	if ($return == true) {
    		return true;
    	}
	}
	
	private function checkTypeEnum($field) {
		$value = $this->tableFields[$field];
		$validation = $this->validation_model[$field]['options'];
		if (!in_array($value,$validation))
		{
			$this->registerError($field,'enum_notfound',' heeft een waarde die niet binnen de opties valt.');
		}
	}
}
?>