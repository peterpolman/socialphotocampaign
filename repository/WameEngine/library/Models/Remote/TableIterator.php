<?php

/**
 * Container for model data that has been returned from the central server.
 * It uses lazy loading of objects to be more memory efficient (just one at a time)
 * 
 * Because this class implements Iterator, it can be used in foreach:
 * 
 * foreach(<TableIteratorInstance> as $record)
 * {
 * 		$record->doRecordStuff();
 * }
 * 
 * @author Tim
 *
 */
class TableIterator implements Iterator {
	
	private $myModels = array();
	private $modelName = "";
	
	/**
	 * Build a TableIterator
	 * @param string $name Model name
	 * @param array $models Array of model data to populate several models
	 */
	public function __construct($name,$models) {
		$this->modelName = $name;
		if ( is_array($models) ) {
			$this->myModels = $models;
		}
	}
	
	// Implement Iterator interface
	public function rewind()
    {
        reset($this->myModels);
    }
  
    public function current()
    {
    	WE::include_model(ucfirst($this->modelName));
    	$object = new $this->modelName();
    	$object->populate(current($this->myModels));
        return $object;
    }
  
    public function key() 
    {
        $var = key($this->myModels);
        return $var;
    }
  
    public function next() 
    {
        $var = next($this->myModels);
        return $var;
    }
  
    public function valid()
    {
        $key = key($this->myModels);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }
    // End of Iterator interface implementation
	
    public function count() {
    	return count($this->myModels);
    }
	
}