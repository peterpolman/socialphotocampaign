<?php
class dashboardController extends WE_Controller_Crud
{
	protected $public = true;
	
	public function	indexAction (WE_Controller_Request $request)
	{
		$roles = Db::getTable('Wame_core_roleright')->getDisctinctRoles(); /* @var $roles WE_Db_Table */
		$this->view->assign('roles',$roles);
		
		$Auth = new WE_Auth();
		if ( !$Auth->isLoggedIn() )
			$this->redirect("devtools/login");
		
		return $this->view->render();
	}
	
	public function errorAction() {
		if (file_exists('var/log/apache2/error.log')) {
			details('YEP');
		} else {
			details('a');
		}
		
		details(error_get_last());
	}
	
	public function	indexOLDAction ()
	{
		
		$parsedblist = array('edb_artikelen','edb_betalingscondities','edb_collecties','edb_contactpersonen','edb_facturen','edb_orderregels','edb_orders','edb_prijslijsten','edb_relaties','edb_voorraad_leveren','edb_voorraad_plank');
		details('start');
		
		WE::include_adapter('DbLite');
		$dblite = DbLite::getInstance();
		$dblite->connect('esschert.sqlite');
		WE_ErrorHandler::getInstance()->setAllowQuery(false);
		
		$referencetable = $this->getRefTable($dblite);
		details($referencetable);
		
		foreach($parsedblist as $table) {
			
			set_time_limit(1800);

			$litedbname = "Z".strtoupper($table);
			/*$dblite->query("DELETE FROM ".$litedbname,array());
			
			$result = Db::getTable($table)->getAll();
			details($table.": ".$result->count());*/
			
			$sql = "BEGIN IMMEDIATE TRANSACTION;";
			$dblite->query($sql,array(),false);
			
			
			$first = true;
			$litelist = array();
			$result = Db::getTable($table)->getAll();
			foreach($result->getResult() as $model) {
				if ($first == true) {
					$val = $model->getValidationModel();
					$first = false;
					
				}
				
				$combi = array();
				foreach($model->getValuesAsArray() as $field=>$value) {
					if (strlen($value) == 0) {
						$value = "NULL";
					} else {
						switch ($val[$field]['type']) {
							case "varchar":
							case "text":
								$value = "'".sqlite_escape_string($value)."'";
								break;
							case "date":
								$value = strtotime($value) - 978307200;
								break;
							case "enum":
							case "decimal":
								$value = "'".$value."'";
								break;
						}
					}
					$field = "Z".strtoupper($field);
					
					$combi[$field] = $value;
					$combi["Z_ENT"] = $referencetable[$table];
					$combi["Z_OPT"] = 1;
				}
				
				$litesql = "INSERT INTO ".$litedbname." (".implode(', ',array_keys($combi)).") VALUES (".implode(', ',array_values($combi)).")";
				$dblite->query($litesql,array(),false);
			}
			
			
			
			$maxSQL = "SELECT MAX(Z_PK) as NUM FROM ".$litedbname;
			$maxRes = $dblite->query($maxSQL,array(),false);
			$data = $maxRes->fetch(PDO::FETCH_ASSOC);
			
			$updatePrimary = "UPDATE Z_PRIMARYKEY SET Z_MAX = ".$data['NUM']." WHERE Z_NAME = '".ucfirst($table)."'";
			$dblite->query($updatePrimary,array(),false);
			
			$sql = ";COMMIT TRANSACTION;";
			$dblite->query($sql,array(),false);
		}
		
		
		
		
	}
	
	public function updatebeeldmateriaalAction() {
		
		if ($this->getRequest()->getPost()) {
			$targetFile = Config::get('install','resourcedir').'/files/updates/beeldmateriaal.zip';
			$filePost = $this->getRequest()->getFile('uploaded');
			if (file_exists($targetFile)) {
				unlink($targetFile);
			}
			copy($filePost['tmp_name'],$targetFile);
			details($filePost);
			
			$ipad_beeldmateriaal = Db::getModel('Ipad_beeldmateriaal');
			$ipad_beeldmateriaal->setDate(date('Y-m-d H:i:s'));
			$ipad_beeldmateriaal->setFilesize($filePost['size']);
			$ipad_beeldmateriaal->save();
			
			unlink($filePost['tmp_name']);
			unset($filePost);
			
		}
		
		return $this->view->render();
	}
	
	private function getRefTable($db) {
		$result = $db->query("SELECT * FROM Z_PRIMARYKEY",array());
		$res = $result->fetchAll(PDO::FETCH_ASSOC);
		$referencetable = array();
		foreach($res as $entry) {
			$referencetable[strtolower($entry['Z_NAME'])] = $entry['Z_ENT'];
		}
		
		return $referencetable;
	}

	
	
	public function zipmergeAction() {
		$zip = new ZipArchive();

		$sourcedir = Config::get('install','resourcedir').'/files/updates/';
		$sqlsourcedir = Config::get('install','resourcedir').'/files/sqlite/';
		$source = $sourcedir.'beeldmateriaal.zip';
		$target = $sourcedir.'beeldmateriaal.clone.zip';
		if (file_exists($target)) {
			unlink($target);
		}
		copy($source,$target);
		$zip->open($target);
		$zip->addFile($sqlsourcedir.'esschert.sqlite','esschert.sqlite');
		$zip->close();

	}
}	
?>