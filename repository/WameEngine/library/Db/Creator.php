<?php 
class WE_Db_Creator
{
	/**
	 * Instance of WE_View
	 */
	public $view;
	
	
	public $root		= null;
	private $db			= null;
	
	function __construct($db)
	{
		WE::include_library('View');
		WE::include_library('Controller/Front');
		$this->view = new WE_View();
		$this->root = Config::get('install','secure_root');
		$this->db 	= $db;
	}

	public function createLanguageModel($modelname)
	{
		$model = Db::getModel($modelname);
		$lines = array();
		
		$validation = $model->getValidationModel();

		foreach($validation as $field=>$rules)
		{
			$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['title'] = '".ucfirst($field)."';";
			
			foreach($rules as $rule=>$option)
			{
				switch ($rule) {
				    case 'null':
				    	if ($option != 1) {
				    		$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['null_not'] = '".ucfirst($field)." mag niet leeg zijn.';";
				    	}
				    	break;
					case 'type':
						if ($option == 'int') {
							$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['int_not'] = '".ucfirst($field)." is geen geheel getal.';";
						}
						if ($option == 'date') {
							$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['date_invalid'] = '".ucfirst($field)." bevat een ongeldige datum.';";
							$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['date_not'] = '".ucfirst($field)." heeft niet de juiste notering.';";
						}
						if ($option == 'datetime') {
							$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['datetime_invalid'] = '".ucfirst($field)." bevat een ongeldige datum/tijd.';";
							$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['datetime_not'] = '".ucfirst($field)." heeft niet de juiste notering.';";
						}
						if ($option == 'enum') {
							$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['enum_notfound'] = '".ucfirst($field)." heeft geen geldige optie.';";
						}
						break;
				    case 'min':
				    	$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['min'] = '".ucfirst($field)." is lager dan de toegestane waarde.';";
				    	break;
				    case 'max':
				    	$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['max'] = '".ucfirst($field)." is hoger dan de toegestane waarde.';";
				    	break;
				    case 'maxchar':
				    	$lines[] = '$'."lang['model']['".ucfirst($modelname)."']['".$field."']['validate']['maxchar'] = '".ucfirst($field)." is langer dan het toegestane aantal tekens.';";
				    	break;
				}
			}
		}
	}
	
	public function createTable($table)
	{
		try {
			$target = Config::get('install','resourcedir').'table/'.ucfirst($table).'Table.php';
			
			$db = $this->db;
			
			$tTitle = $table;
			//if (!ctype_upper(substr($tTitle,0,1))) { 
				$tTitle = strtolower($tTitle);
			//}
			
			$r = $db->query('SHOW COLUMNS FROM `' . $tTitle .'`');
		
			$aFormResults = $r->fetchAll(PDO::FETCH_ASSOC);
			$aAutoIncrement = '';
			
			foreach($aFormResults as $result)
			{
				$aFields[$result['Field']] = ucfirst($result['Field']);
				if ($result['Key'] == 'PRI')
				{
					$result['Field'] = str_replace(array('-',' '),array('_','_'), $result['Field']);
					$aPrimary[] = $result['Field'];
				}
			}
			
			if (count($aPrimary) > 1)
			{
				foreach($aPrimary as $pkey=>$primary) {
					$aPrimary[$pkey] = "'".$primary."'";
				}
				$primarykey = 'array('.implode(',', $aPrimary).')';
			} else {
				$primarykey = "array('".$aPrimary[0]."')";
			}
			
			if (!file_exists($target))
			{
				$fh = fopen($target,'a');
				chmod($target, 0777);
				
				
				$this->view->assign('table',strtolower($table));
				$this->view->assign('Table',ucfirst($table));
				$this->view->assign('primary',$primarykey);
				
				$tabledata = $this->view->render('system/creator/table.tpl');
				
				fwrite($fh,$tabledata);
				fclose($fh);
			} else {
				WE::include_library('Db/Exception');
				throw new WE_Db_Exception("Kan niet de tabelfile overschrijven.");
			}
		
		}
		catch (PDOException $e)
		{
			if ( Config::get('communication','connect') ) {
				// Table not found on client system, perhaps on central system?
				WE::include_adapter('JSONrequest');
				
				$jro = new JSONrequestObject();
				$jro->requesttype = "getTableDb";
				$jro->name = $table;
				$data = JSONrequest::handleRequest($jro);
				

				if ($data->responsetype == "success") {
					if (empty($data->result)) {
						WE::include_library('Db/Exception');
						throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$table`, zowel lokaal als remote. Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
					} else {
						// Table is on central system, store the stub here!
						$target = Config::get('install','resourcedir').'table/db/'.ucfirst($table).'Table.php';
						
						if (!file_exists($target)) {
							$fh = fopen($target,'a');
							chmod($target, 0777);
							fwrite($fh,base64_decode($data->result));
							fclose($fh);
						}
						
						$target = Config::get('install','resourcedir').'table/'.ucfirst($table).'Table.php';
						if (!file_exists($target)) {
							$this->view->assign('table',strtolower($table));
							$this->view->assign('Table',ucfirst($table));
							$tabledata = $this->view->render('system/creator/tableRemote.tpl');
							$fh = fopen($target,'a');
							chmod($target, 0777);
							fwrite($fh,$tabledata);
							fclose($fh);
						}
					}
				} else {
					if ($data->responsetype == "error" && is_string($data->result)) {
						WE::include_library('Db/Exception');
						throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$table`, zowel lokaal als remote (error: '".$data->result."'). Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
					}
				}
			} else {
				WE::include_library('Db/Exception');
				throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$table`. Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
			}
		}
	}
	
	public function createModel($model)
	{
		try {
			if (strstr($model,'db/') !== false) {
				$aModel = explode('/', $model);
				$model = $aModel[1];
			}
			
			$target = Config::get('install','resourcedir').'model/db/'.ucfirst($model).'.php';
			if (!file_exists($target))
			{
				$db = $this->db;
				
				$sqlConstraint = "select
									`TABLE_NAME`,
									`COLUMN_NAME`,
									`CONSTRAINT_NAME`,
									`REFERENCED_TABLE_NAME`,
									`REFERENCED_COLUMN_NAME`
								from 
									`INFORMATION_SCHEMA`.`KEY_COLUMN_USAGE`
								where
									`TABLE_SCHEMA` = :dbname
										AND
									`REFERENCED_TABLE_NAME` IS NOT NULL
										AND
									`TABLE_NAME` = :tablename";
				$aConstraintValues = array('dbname'=>$db->getDbName(),'tablename'=>strtolower($model));
				
				$rConstraint = $db->query($sqlConstraint,$aConstraintValues);
				$aConstraintResults = $rConstraint->fetchAll(PDO::FETCH_ASSOC);
				
				$aConstraints = array();
				foreach($aConstraintResults as $result)
				{
					$aConstraints[$result['COLUMN_NAME']] = $result['REFERENCED_TABLE_NAME'];
				}
				
				$r = $db->query('SHOW COLUMNS FROM `' . strtolower($model) .'`');
	
		       	$fh = fopen($target,'a');
				chmod($target, 0777);
		
				$aFields 	= array();
				$aPrimary 	= array();
				$aFormResults = $r->fetchAll(PDO::FETCH_ASSOC);

				$aVerification = array();
				foreach($aFormResults as $result)
				{
					$result['Field'] = str_replace(array('-',' '),array('_','_'), $result['Field']);
					if ($result['Null'] == 'NO' && $result['Field'] != 'ref_id') {
						$aVerification[$result['Field']]['null'] = 'false';
					} else {
						$aVerification[$result['Field']]['null'] = 'true';
					}					
					
					$type = explode(' ',$result['Type']);
					
					$search = preg_replace('/\s*\([^)]*\)/', '', $type[0]);
					switch ($search) {
					    case 'tinyint':
				    		$aVerification[$result['Field']]['type'] = "'int'";
							if (isset($type[1]) && $type[1] =='unsigned') {
								$aVerification[$result['Field']]['min'] = 0;
								$aVerification[$result['Field']]['max'] = 255;
							} else {
								$aVerification[$result['Field']]['min'] = -128;
								$aVerification[$result['Field']]['max'] = 127;
							}
							$matches = array();
							preg_match_all('/\((.*)\)/U', $type[0], $matches);
							$aVerification[$result['Field']]['maxchar'] = $matches[1][0];
							break;
						case 'smallint':
							$aVerification[$result['Field']]['type'] = "'int'";
							if (isset($type[1]) && $type[1] =='unsigned') {
								$aVerification[$result['Field']]['min'] = 0;
								$aVerification[$result['Field']]['max'] = 65535;
							} else {
								$aVerification[$result['Field']]['min'] = -32768;
								$aVerification[$result['Field']]['max'] = 32767;
							}
							$matches = array();
							preg_match_all('/\((.*)\)/U', $type[0], $matches);
							$aVerification[$result['Field']]['maxchar'] = $matches[1][0];
								break;
						case 'mediumint':
							$aVerification[$result['Field']]['type'] = "'int'";
							if (isset($type[1]) && $type[1] =='unsigned') {
								$aVerification[$result['Field']]['min'] = 0;
								$aVerification[$result['Field']]['max'] = 16777215;
							} else {
								$aVerification[$result['Field']]['min'] = -8388608;
								$aVerification[$result['Field']]['max'] = 8388607;
							}
							$matches = array();
							preg_match_all('/\((.*)\)/U', $type[0], $matches);
							$aVerification[$result['Field']]['maxchar'] = $matches[1][0];
							break;
						case 'int':
							$aVerification[$result['Field']]['type'] = "'int'";
							if (isset($type[1]) && $type[1] =='unsigned') {
								$aVerification[$result['Field']]['min'] = 0;
								$aVerification[$result['Field']]['max'] = 4294967295;
							} else {
								$aVerification[$result['Field']]['min'] = -2147483648;
								$aVerification[$result['Field']]['max'] = 2147483647;
							}
							$matches = array();
							preg_match_all('/\((.*)\)/U', $type[0], $matches);
							$aVerification[$result['Field']]['maxchar'] = $matches[1][0];
							break;
						case 'bigint':
							$aVerification[$result['Field']]['type'] = "'int'";
							if (isset($type[1]) && $type[1] =='unsigned') {
								$aVerification[$result['Field']]['min'] = 0;
								$aVerification[$result['Field']]['max'] = 18446744073709551615;
							} else {
								$aVerification[$result['Field']]['min'] = -9223372036854775808;
								$aVerification[$result['Field']]['max'] = 9223372036854775807;
							}
							$matches = array();
							preg_match_all('/\((.*)\)/U', $type[0], $matches);
							$aVerification[$result['Field']]['maxchar'] = $matches[1][0];
							break;
						case 'varchar':
							$aVerification[$result['Field']]['type'] = "'varchar'";
							$matches = array();
							preg_match_all('/\((.*)\)/U', $type[0], $matches);
							$aVerification[$result['Field']]['maxchar'] = $matches[1][0];
							break;
						case 'enum':
							$aVerification[$result['Field']]['type'] = "'enum'";
							$matches = array();
							preg_match_all('/\((.*)\)/U', $type[0], $matches);
							$options = str_replace("'",'', explode(',',$matches[1][0]));
							foreach($options as $koption=>$option)
							{
								$options[$koption] = $db->escape($option);
							}
							$aVerification[$result['Field']]['options'] = $options;
							break;
						case 'decimal':	//Inhert to floast
						case 'float':	//Inhert to double
						case 'double':	
							$aVerification[$result['Field']]['type'] = "'decimal'";
							preg_match_all('/\((.*)\)/U', $type[0], $matches);
							if (isset($matches[1][0]))
							{
								$options = str_replace("'",'', explode(',',$matches[1][0]));
								if (isset($options[0]) && $options[0] != '' && $options[0] != null && $options[0] != false) {
									$aVerification[$result['Field']]['decimal'] = $options[0];
								}
								if (isset($options[1]) && $options[1] != '' && $options[1] != null && $options[1] != false) {
									$aVerification[$result['Field']]['percicion'] = $options[1];
								}
							}
							if (isset($type[1]) && $type[1] =='unsigned') {
								$aVerification[$result['Field']]['min'] = 0;
							}
							break;
						default:
							$aVerification[$result['Field']]['type'] = "'".$search."'";
							break;
					}
					
					$aFields[$result['Field']] = ucfirst($result['Field']);
					if ($result['Key'] == 'PRI')
					{
						$aPrimary[] = $result['Field'];
					}
					
					if ($result['Extra'] == 'auto_increment') {
						$this->view->assign('autoIncrement',$result['Field']);
					}
				}
				
				$orgPrimary = array();
				$loadPrimary = array();
				foreach($aPrimary as $primary) {
					$orgPrimary[$primary] = '$'.$primary;
					$loadPrimary[] = "'".$primary."'=>$".$primary;
				}
				
				$iPrimary = implode(',', $orgPrimary);
				$lPrimary = implode(',',$loadPrimary);
				
				if (count($aPrimary) > 1)
				{
					foreach($aPrimary as $pkey=>$primary) {
						$aPrimary[$pkey] = "'".$primary."'";
					}
					$primarykey = 'array('.implode(',', $aPrimary).')';
				} else {
					$this->view->assign('autoIncrement',$aPrimary[0]);
					$primarykey = "array('".$aPrimary[0]."')";
				}
				
				$this->view->assign('aConstraints',$aConstraints);
				$this->view->assign('validate',$aVerification);
				$this->view->assign('table',strtolower($model));
				$this->view->assign('fields',$aFields);
				$this->view->assign('Classname',ucfirst($model));
				$this->view->assign('primary',$primarykey);
				$this->view->assign('oPrimary',$orgPrimary);
				$this->view->assign('iPrimary',$iPrimary);
				$this->view->assign('lPrimary',$lPrimary);
				
				$modeldata = $this->view->render('system/creator/model.tpl');
				fwrite($fh,$modeldata);
				fclose($fh);
				
				$target = Config::get('install','resourcedir').'model/'.ucfirst($model).'.php';
				if (!file_exists($target))
				{
			       	$fh = fopen($target,'a');
					chmod($target, 0777);
			
					$this->view->assign('Classname',ucfirst($model));
					
					$modeldata = $this->view->render('system/creator/complexmodel.tpl');
					fwrite($fh,$modeldata);
					fclose($fh);
				}
			} else {
				WE::include_library('Db/Exception');
				throw new WE_Db_Exception("Kan niet de modelfile overschrijven.");
			}

		}
		catch (PDOException $e)
		{
			if ( Config::get('communication','connect') ) {
				// Table not found on client system, perhaps on central system?
				WE::include_adapter('JSONrequest');
				
				$jro = new JSONrequestObject();
				$jro->requesttype = "getModelDb";
				$jro->name = $model;
				$data = JSONrequest::handleRequest($jro);
				
				if ($data->responsetype == "success") {
					if (empty($data->result)) {
						WE::include_library('Db/Exception');
						throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$model`, zowel lokaal als remote. Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
					} else {
						// Table is on central system, store the stub here!
						$target = Config::get('install','resourcedir').'model/db/'.ucfirst($model).'.php';
						if (!file_exists($target)) {
							$fh = fopen($target,'a');
							chmod($target, 0777);
							fwrite($fh,base64_decode($data->result));
							fclose($fh);
						}
						$target = Config::get('install','resourcedir').'model/'.ucfirst($model).'.php';
						if (!file_exists($target))
						{
					       	$fh = fopen($target,'a');
							chmod($target, 0777);
							$this->view->assign('Classname',ucfirst($model));
							$modeldata = $this->view->render('system/creator/complexmodel.tpl');
							fwrite($fh,$modeldata);
							fclose($fh);
						}
					}
				} else {
					if ($data->responsetype == "error" && is_string($data->result)) {
						WE::include_library('Db/Exception');
						throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$model`, zowel lokaal als remote (error: '".$data->result."'). Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
					}
				}
			} else {
				WE::include_library('Db/Exception');
				throw new WE_Db_Exception("Er bestaat echt serieus geen tabel met de titel `$model`. Ben je vergeten een hoofdletter te gebruiken? Het is zeker na 4 uur geweest en vermoedelijk ook nog eens vrijdag (wat dit script natuurlijk wel had kunnen controleren maar niet heeft gedaan). Of het is mogelijk maandagochtend en de koffie is niet sterk genoeg. Pak in ieder geval een bak sterke koffie en ga er nog even tegen aan.<br><img src=\"".$this->root."images/creator/koffie_kopje.jpg\">");
			}
			
		}
		
	}
}
?>