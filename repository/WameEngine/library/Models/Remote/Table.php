<?php
/**
 * Database Record Handler
 * @author Wame
 *
 */
WE::include_library('Models/Table');
WE::include_adapter('JSONrequest');
WE::include_library('Models/Remote/TableIterator');

/**
 * This class implements the remote table. This table actually resides on the server
 * but can be accessed using the same interface as local tables.
 * 
 * @author Tim
 */
abstract class WE_Remote_Table extends WE_Table
{	
	/**
	 * TableIterator object that contains the result
	 * @var TableIterator
	 */
	private $myModels;
	
	/**
	 * @see WE_Table::getResult()
	 */
	public function getResult() {
		return $this->myModels;
	}
	
	/**
	 * @see WE_Table::getResultArray()
	 */
	public function getResultArray($array = false,$primary = 'id') {
		$jro = new JSONrequestObject();
		$jro->requesttype = "table";
		$jro->name = $this->table;
		$jro->function = "getResultArray";
		$jro->parameters = array('array'=>$array,'primary'=>$id);
		
		$data = JSONrequest::handleRequest($jro);

		if ($data->responsetype == "success") {
			if (empty($data->result)) {
				return false;
			} else {
				$this->myModels = new TableIterator($this->table,$data->result);
				return $this;
			}
		} else {
			if ($data->responsetype == "error" && is_string($data->result)) {
				throw new Exception($data->result);
			}
		}
	}
	
	/**
	 * @see WE_Table::findColumnData()
	 */
	public function findColumnData ($data, $parameters = array(), $limit = null)
	{
		$jro = new JSONrequestObject();
		$jro->requesttype = "table";
		$jro->name = $this->table;
		$jro->function = "findColumnData";
		$jro->parameters = array('data'=>$data,'parameters'=>$parameters,'limit'=>$limit);
		
		$data = JSONrequest::handleRequest($jro);

		if ($data->responsetype == "success") {
			if (empty($data->result)) {
				return false;
			} else {
				$this->myModels = new TableIterator($this->table,$data->result);
				return $this;
			}
		} else {
			if ($data->responsetype == "error" && is_string($data->result)) {
				throw new Exception($data->result);
			}
		}
	}
	
	/**
	 * @see Countable::count()
	 */
	public function count() {
		if ( is_object($this->myModels) )
			return $this->myModels->count();
		else
			return 0;
	}
	
	/**
	 * @see WE_Table::getAll()
	 */
	public function getAll() {
		$jro = new JSONrequestObject();
		$jro->requesttype = "table";
		$jro->name = $this->table;
		$jro->function = "getAll";
		
		$data = JSONrequest::handleRequest($jro);

		if ($data->responsetype == "success") {
			if (empty($data->result)) {
				return false;
			} else {
				$this->myModels = new TableIterator($this->table,$data->result);
				return $this;
			}
		} else {
			if ($data->responsetype == "error" && is_string($data->result)) {
				throw new Exception($data->result);
			}
		}
	}
	
	
	/**
	 * @param $function string
	 * @param $arguments array
	 * @return mixed
	 */
	protected function doRemoteCall($function,$arguments) {
		$jro = new JSONrequestObject();
		$jro->requesttype = "table";
		$jro->name = $this->table;
		$jro->function = $function;
		$jro->parameters = $arguments;
	
		$data = JSONrequest::handleRequest($jro);

		if ($data->responsetype == "success") {
			if (empty($data->result)) {
				return false;
			} else {
				$this->myModels = new TableIterator($this->table,$data->result);
				return $this;
			}
		} else {
			if ($data->responsetype == "error" && is_string($data->result)) {
				throw new Exception($data->result);
			}
		}
	}
	
	/**
	 * This is a remote table, represented by a proxy stub. This function refreshes
	 * the stub by fetching it from the server again.
	 * @throws WE_Db_Exception
	 */
	protected function refreshStub() {
		if ( Config::get('communication','connect') ) {
			// Table not found on client system, perhaps on central system?
			WE::include_adapter('JSONrequest');
			$table = $this->table;
			
			$jro = new JSONrequestObject();
			$jro->requesttype = "getTableDb";
			$jro->name = $table;
			$data = JSONrequest::handleRequest($jro);
			

			if ($data->responsetype == "success") {
				if (empty($data->result)) {
					WE::include_library('Db/Exception');
					throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$table` remote. Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
				} else {
					// Table is on central system, store the stub here!
					$target = Config::get('install','resourcedir').'table/db/'.ucfirst($table).'Table.php';
					$fh = fopen($target,'w');
					chmod($target, 0777);
					fwrite($fh,base64_decode($data->result));
					fclose($fh);
				}
			} else {
				if ($data->responsetype == "error" && is_string($data->result)) {
					WE::include_library('Db/Exception');
					throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$table` remote (error: '".$data->result."'). Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
				}
			}
		}
	}
	
}
?>
