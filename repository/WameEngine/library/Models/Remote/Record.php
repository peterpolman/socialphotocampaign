<?php
/**
 * Database Record Handler
 * @author Wame
 *
 */
WE::include_library('Models/Record');
WE::include_adapter('JSONrequest');

abstract class WE_Remote_Record extends WE_Record
{	
	
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
		if ($this->softDelete == true) {
			$this->softDelete();
		} else {
			$primaries = array();
			foreach($this->primary as $primary) {
				$primaries[$primary] = $this->tableFields[$primary];
			}
			
			$jro = new JSONrequestObject();
			$jro->requesttype = "model";
			$jro->name = $this->table;
			$jro->function = "delete";
			$jro->parameters = array($primaries);
			$jro->object = $this->getValuesAsArray();
			
			$data = JSONrequest::handleRequest($jro);

			if ($data->responsetype == "success") {
				return true;
			} else {
				if ($data->responsetype == "error" && is_string($data->result)) {
					throw new Exception($data->result);
				}
			}
		}
	}

	/**
	 * This function tests if a prepopulated model allready exists in the database. This check will only be done on the primary fields!
	 * The model will be populated if it does exits!
	 *
	 * @param $function string
	 * @param $arguments array
	 * @return mixed
	 */
	protected function doRemoteCall($function,$arguments) {
		$jro = new JSONrequestObject();
		$jro->requesttype = "model";
		$jro->name = $this->table;
		$jro->function = $function;
		$jro->object = $this->getValuesAsArray();
		
		if (!is_array($arguments)) {
			$jro->parameters = array($arguments);
		} else {
			$jro->parameters = $arguments;
		}
		
		$data = JSONrequest::handleRequest($jro);

		if ($data->responsetype == "success") {
			if (empty($data->resulttype)) {
				return $data->result;
			} else {
				if (strtolower($data->resulttype) == strtolower($this->table)) {
					$this->populate($data->result);
					return $this;
				} else {
					try {
						$return = Db::getModel(ucfirst(strtolower($data->resulttype)));
						$return->populate($data->result);
						return $return;
					} catch (Exception $e) {
						throw new Exception("Could not create model of type: ".$data->resulttype);
					}
				}
			}
		} else {
			if ($data->responsetype == "error" && is_string($data->result)) {
				throw new Exception($data->result);
			}
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
		if ($useCCMMadd == true) {
			$this->CCMMadd();
		}
		
		if ($this->isValid()) {
			$table = $this->table;
			$jro = new JSONrequestObject();
			$jro->requesttype = "model";
			$jro->name = $this->table;
			$jro->function = "save";
			$jro->parameters = array('forceAdd' => intval($foceAdd), 'useCCMMadd'=>intval((!$useCCMMadd)));
			$jro->object = $this->getValuesAsArray();
			$data = JSONrequest::handleRequest($jro);

			if ($data->responsetype == "success") {
				$this->populate($data->result);
				return $this;
			} else {
				if ($data->responsetype == "error" && is_string($data->result)) {
					$this->errors[] = $data->result;
					return false;
				}
			}
		} else {
			return false;
		}
	}

	/**
	 * Find a record by primaries
	 *
	 * @param $primary mixed
	 * @return mixed null|WE_Record
	 * @throws {@link Db_Exception}
	 */
	public function find ($primary)
	{
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
		
		$jro = new JSONrequestObject();
		$jro->requesttype = "model";
		$jro->name = $this->table;
		$jro->function = "find";
		$jro->parameters = array($primary);
		
		$data = JSONrequest::handleRequest($jro);
		
		if ($data->responsetype == "success") {
			$this->populate($data->result);
			return $this;
		} else {
			if ($data->responsetype == "error" && is_string($data->result)) {
				throw new Exception($data->result);
			}
		}
	}
	
	/**
	 * @see WE_Record::findColumnData()
	 */
	public function findColumnData ($data, $parameters = array())
	{
		$jro = new JSONrequestObject();
		$jro->requesttype = "model";
		$jro->name = $this->table;
		$jro->function = "findColumnData";
		$jro->parameters = array('data'=>$data,'parameters'=>$parameters);
		
		$data = JSONrequest::handleRequest($jro);

		if ($data->responsetype == "success") {
			if (empty($data->result)) {
				return false;
			} else {
				$this->populate($data->result);
				return $this;
			}
		} else {
			if ($data->responsetype == "error" && is_string($data->result)) {
				throw new Exception($data->result);
			}
		}
	}
	
	/**
	 * This is a remote record, represented by a proxy stub. This function refreshes
	 * the stub by fetching it from the server again.
	 * @throws WE_Db_Exception
	 */
	protected function refreshStub() {
		if ( Config::get('communication','connect') ) {
			// Reload this table from the central server
			WE::include_adapter('JSONrequest');
			$model = $this->table;
			
			$jro = new JSONrequestObject();
			$jro->requesttype = "getModelDb";
			$jro->name = $model;
			$data = JSONrequest::handleRequest($jro);
			
			if ($data->responsetype == "success") {
				if (empty($data->result)) {
					WE::include_library('Db/Exception');
					throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$model` remote. Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
				} else {
					// Table is on central system, store the stub here!
					$target = Config::get('install','resourcedir').'model/db/'.ucfirst($model).'.php';
					$fh = fopen($target,'w');
					chmod($target, 0777);
					fwrite($fh,base64_decode($data->result));
					fclose($fh);
				}
			} else {
				if ($data->responsetype == "error" && is_string($data->result)) {
					WE::include_library('Db/Exception');
					throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$model` remote (error: '".$data->result."'). Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
				}
			}
		}
	}
	
}
?>
