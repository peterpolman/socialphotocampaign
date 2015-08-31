<?php
class datamergeController extends WE_Controller_Crud
{
	protected $public = true;
	
	protected $errors = array();
	protected $notices = array();
	
	public function pollAction() {
		WE::include_adapter('Db2');
		WE::include_adapter('Db3');
		$sDb = Db3::getInstance();
		$tDb = Db2::getInstance();
		
		$tDb->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), 'roma__mergetest');
		$sDb->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), 'roma_datamerge');
		
		$targetTable = 'roma_patients';
		$sourceTable = 'demografie_leefstijl';
		
		/*$aTable = array('braf','BSE_CRP','demografie_leefstijl','dmard_vg','Euroquol','gewrichtsscore','HAQ','HAQconsensus','medicatie','medische_vg','MIC','patient_tevr_huidig','patient_tevr_stop','poet_us','SF36v2','Vassen','Vas_arts');
		
		foreach($aTable as $tablename) {
			$sTable = $sDb->getTable($tablename);
			$query = 'SELECT * FROM `'.$tablename.'` WHERE CHAR_LENGTH(ziekenhuisnummer) =:eight && ziekenhuisnummer >= :huge';
			$vars = array('huge'=>90000000,'eight'=>8);
			$sTable->setResultset($query,$vars);
			//$sModel = $sDb->getModel($tablename);
			//details($sModel);
			details($sTable);
		}*/
		
		
		$sTable = $sDb->getModel('medicatie');
		$query = "SELECT `medicatie`, count(`medicatie`) as num FROM `medicatie` GROUP BY `medicatie`";
		$result = $sDb->query($query,array());
		$numresults = $result->rowCount();
		$res = $result->fetchAll(PDO::FETCH_ASSOC);
		
		$return = array();
		foreach($res as $med) {
			$return[trim($med['medicatie'])] = $med['num'];
		}
		
		foreach($return as $med=>$occur) {
			//Db::getModel('');
		}
		
		details($return);

	}
	
	public function indexAction ()
	{
		WE::include_adapter('Db2');
		WE::include_adapter('Db3');
		$sDb = Db3::getInstance(); /* @var $sDb Db */
		$tDb = Db2::getInstance(); /* @var $tDb Db */
		$tDb->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), 'roma_test_securtiy');
		$sDb->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), 'velda_db2');
		
		$targetTable = 'roma_patient_das28';
		$sourceTable = 'userdata';
		
		$tResult = array();
		foreach($tTables as $table) {
			$result = $this->getForeinKeys($tDb, $table);
			if (empty($result)) {
				$tResult['autonomous'][] = $table;
			} else {
				$tResult['linked'][$table] = $result;
			}
		}
		
		$sResult = array();
		foreach($sTables as $table) {
			$result = $this->getForeinKeys($sDb, $table);
			if (empty($result)) {
				$sResult['autonomous'][] = $table;
			} else {
				$sResult['linked'][$table] = $result;
			}
		}
		
		details($sResult);
		details($tResult);
	}
	
	public function prepareAction ()
	{
		WE::include_adapter('Db2');
		WE::include_adapter('Db3');
		$sDb = Db3::getInstance();
		$tDb = Db2::getInstance();
		
		$tDb->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), 'roma__mergetest');
		$sDb->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), 'roma_datamerge');
		
		$targetTable = 'roma_patient_lab';
		$sourceTable = 'BSE_CRP';
		
		$tModel = $tDb->getModel($targetTable);
		$sModel = $sDb->getModel($sourceTable);
		
		
		if ($this->getRequest()->isPost()) {
			details($_POST);
		}
		
		
		$this->view->assign('tModel',$tModel);
		$this->view->assign('sModel',$sModel);
		
		//$this->view->assign('aCenters',$tDb->getTable('Roma_centers')->getAll());
		
		return $this->view->render();
	}
	
	public function	mergeAction (WE_Controller_Request $request)
	{
		WE::include_adapter('Db2');
		WE::include_adapter('Db3');
		$sDb = Db3::getInstance();
		$tDb = Db2::getInstance();
		
		$tDb->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), 'roma__mergetest');
		$sDb->connect(Config::get('db','host'), Config::get('db','username'), Config::get('db','password'), 'roma_datamerge');
		
		$return = $this->lol();
		
		$targetTable = $return['target'];
		$sourceTable = $return['source'];
		
		//sTable = $sDb->getTable($sourceTable)->getAll();
		
		$sTable = $sDb->getTable($sourceTable)->setResultset('SELECT * FROM `'.$sourceTable.'` '.(isset($return['where']) ? $return['where'] : ''), (isset($return['wherevars']) ? $return['wherevars'] : array()));
		//$sTable = $sDb->getTable($sourceTable)->setResultset('SELECT * FROM `'.$sourceTable.'` ', array());

		details($sTable);
		
		$fail = array();
		
		$aInvalid = array();
		foreach($sTable->getResult() as $sModel) { /* @var $sModel WE_Db_Record */
			$tModel = $tDb->getModel($targetTable);
			$valModel = $tModel->getValidationModel();
			foreach($return['fields'] as $field=> $options) {						// Loop trough the array of conversion actions
				$set = "set". ucfirst($field);										// Construct setter for Db
				if (key_exists('link',$options)) {									// Is there a link for this field
					if (!is_array($options['link'])) { 								// There is a single linked field
						
						// Detect primary
						// Add primary reference.			SUB
						
						// Detect reference			
						// Find correct primary.			SUB
						
						$get = "get".ucfirst(trim($options['link']));					// Get the source value
						$mGet = $options['link'];									// Register for the dbref
						$type = $valModel[$field]['type'];							// Determine format
						$result = trim($sModel->{$get}());								// Get the result
						if (method_exists($this, 'format'.ucfirst($type))) {		// Is there a format style
							$result = $this->{'format'.ucfirst($type)}($result);	// Format the result
						}
						
						if (key_exists('options', $options)) {								// IF there are options
							if (key_exists('convert', $options['options'])) {				// IF there is a convert option
								if (key_exists($result, $options['options']['convert'])) { 	// IF the found value has a convertion rule
									$result = $options['options']['convert'][$result];		// Convert that value
								}
							}
						}
						
						$tModel->{$set}($result);									// Set the value
				} else {															// Multiple source values form a single target value
						$seperator = ' ';											// Determine seperator for multiple vales
						$aAwnser = array();											// Placeholder for value array
						$mGet = array();											// Register for the dbref
						foreach($options['link'] as $getField) {					// Loop trough the sources
							$get = "get". ucfirst($getField);						// Construct getter for Db
							$aAwnser[] = $sModel->{$get}();							// Add the placeholder field
							$mGet[] = $getField;									// Register for the dbref
						}
						$mGet = implode(';',$mGet);									// Imploded Register for the dbref
						
						if (key_exists('options', $options)) {						// Check for options
							if (key_exists('seperator', $options['options'])) {		// Is there a custom seperator
								$seperator = $options['options']['seperator'];		// Use that seperator
							}
						}
						
						$awnser = trim(implode($seperator,$aAwnser));				// Implode the value
						while (strpos($awnser,'  ') !== false) {					// Remove any double spaces in the query;
							$awnser = str_replace('  ',' ',$awnser);
						}
						$tModel->{$set}($awnser);									// Set the value
					}
				} elseif (key_exists('value',$options)) {							// Insert a static value
					$tModel->{$set}($options['value']);
				}
			}

			$list = $sModel->getValuesAsArray();
			$id = trim($sModel->getZiekenhuisnummer()).'_'.(key_exists('geboortedatum', $list) ? trim($sModel->getGeboortedatum()).'_' : '').(key_exists('gebdat', $list) ? trim($sModel->getGebdat()).'_' : '').(key_exists('onderzoeksdatum', $list) ? trim($sModel->getOnderzoeksdatum()) : '');
			
			$pat = Db2::getModel('Roma_patients'); /* @var $pat Roma_patients */
			$nummer = trim($sModel->getZiekenhuisnummer(),' ');
			$len = strlen($nummer);
			
			$data = array();
			$search = array();

			switch($len) {
				case 5:													//Dreamnumber
					$nummer = ltrim($nummer,'0');
					$data['dreamnumber'] = $nummer;
					break;
				case 7:													//UMCRN
					//if (substr($nummer,0,1) == '9') {
						//$data['center_id'] = '9';
						//$data['patientnumber'] = $nummer;
						//$search['patientnumber'] = 'X%';
					//} else {
						$data['center_id'] = '7';
						$data['patientnumber'] = $nummer;
						$search['patientnumber'] = '%X';
					//}

					break;
				case 8:													//SMK
					$data['patientnumber'] = $nummer;
					$search['patientnumber'] = '%X';
					if (substr($nummer,0,1) == '9') {
						$data['center_id'] = '9';
						$search['patientnumber'] = '%%';
					}
					break;
				default:
					break;
			}
			
			if (!empty($data)) {
				if (key_exists('geboortedatum', $list) || key_exists('gebdat', $list)) {
					if (key_exists('geboortedatum', $list)) {
						$bdate = $sModel->getGeboortedatum();
					} elseif (key_exists('gebdat', $list)) {
						$bdate = $sModel->getGebdat();
					}
					
					if (!empty($bdate)) {
						$bdate = $this->formatDate($bdate);
						if (!empty($bdate)) {
							$date['birthdate'] = $bdate;
						} else {
							$this->errors[$id][] = 'Gebroortedatum is niet in het juiste formaat.';
						}
					} else {
						$this->notices[$id][] = 'Gebroortedatum is niet opgegegeven.';
					}
				} else {
					$this->notices[$id][] = 'Gebroortedatum is niet beschikbaar.';
				}
				
				try {
					$pat->findColumnData($data,$search);
				} catch (WE_Db_Record_Exception $e) {
					$this->errors[$id][] = 'Meerdere ziekenhuisnummers of dreamnummers gevonden.';
				}
				if ($pat->isEmpty()) {
					if (isset($data['dreamnumber'])) {
						$this->errors[$id][] = 'Dreamnummer kon niet gevonden worden.';
					} else {
						$this->errors[$id][] = 'Ziekenhuisnummer kon niet gevonden worden.';
					}
				} else {
					$tModel->setPatient_id($pat->getPatient_id());
				}
			} else {
				$this->errors[$id][] = 'Ziekenhuisnummer is niet opgegegeven of voldoet niet aan de formatting.';
			}
			
			if (method_exists($this, 'filter'.ucfirst($targetTable))) {
				$tModel = $this->{'filter'.ucfirst($targetTable)}($sModel,$tModel);
			}
			
			
			if (!isset($this->errors[$id])) {
				if (!$tModel->isValid()) {
					$smallerrors = $tModel->getErrors();
					foreach($smallerrors as $id1=>$erlist) {
						foreach($erlist as $id2=>$er) {
							$this->errors[$id][] = $id1.'__'.$id2.': '.$er;
						}
					}
				} else {
					if ($tModel->exists()) {
						$this->errors[$id][] = 'Er bestaat al een entry.';
					} else {
						//details($tModel);
					}
				}
			}
			

			
			// Detect Insert/Update
			
			// Kies nodige handeling hierbij
			/*if (!$tModel->exists()) { // CONTROLEER OF UNIQUE WAARDES GEVULD ZIJN OF NIET EDIT IN RECORD.PHP EN CREATOR.PHP
				if ($tModel->save()) {													// If the safe is succesfull insert a reference
					$tGet = "get". ucfirst($field);
					
					$referenceModel = Db::getModel('Wametools_dbref'); 
					$referenceModel->setSource_db($sDb->getDbName());
					$referenceModel->setSource_table($sourceTable);
					$referenceModel->setSource_field($mGet);
					$referenceModel->setSource_value($sModel->{$get}());
					
					$referenceModel->setTarget_db($tDb->getDbName());
					$referenceModel->setTarget_table($targetTable);
					$referenceModel->setTarget_field($field);
					$referenceModel->setTarget_value($tModel->{$tGet}());
					
					//details($referenceModel);
				} else {
					$aInvalid[] = $tModel;
				}
			}*/
		}
		
		//$tmpErrors = $this->errors;
		$allErrors = array();
		foreach($this->errors as $key=>$uni) {
			$unique = array_unique($uni);
			$this->errors[$key] = $unique;
			$allErrors = array_merge($allErrors,$unique);
		}
		
		$tempErrors = array_count_values($allErrors);
		
		$allErrors =array_unique($allErrors);
		arsort($tempErrors);
		
		
		
		details($allErrors);
		details($tempErrors);
		
//		array_unique($this->errors);
			
		details(count($this->errors));
		details(count($this->notices));
		


		//return $this->view->render();
	}
	
	private function filterRoma_patient_lab(BSE_CRP $source,Roma_patient_lab $target) {
		
		// If BSE or CRP is a comma value, set to null: \\192.168.2.101\docs\Documenten\ROMA\Overzetten_tabellen.docx.

		/*$labDate = $target->getLab_date();
		if (empty($labDate)) {
			$target->setLab_date($target->getDate());
		}*/
		
		if (!is_numeric($target->getBse())) {
			$target->setBse(null);
		} else {
			if (intval($target->getBse()) != $target->getBse()) {
				$target->setBse(null);
			}
		}
		
		if (!is_numeric($target->getCrp())) {
			$target->setCrp(null);
		} else {
			if (intval($target->getCrp()) != $target->getCrp()) {
				$target->setCrp(null);
			}
		}
		
		return $target;
	}
	
	
	private function filterRoma_questionnaire_haq_duco10(HAQconsensus $source,Roma_questionnaire_haq_duco10 $target) {
		
		$list = $source->getValuesAsArray();
		$id = trim($source->getZiekenhuisnummer()).'_'.(key_exists('geboortedatum', $list) ? trim($source->getGeboortedatum()).'_' : '').(key_exists('gebdat', $list) ? trim($source->getGebdat()).'_' : '').(key_exists('onderzoeksdatum', $list) ? trim($source->getOnderzoeksdatum()) : '');
		
		$lower = array('dressing','hairwash','chair','bed','cutmeat','drinking','openmilk','walking','stairs','bodywash','bath','toilet','weight','pickup','cardoor','potlid','faucet','shopping','inoutcar','vacuumgardening');
		foreach($lower as $field) {
			$methodeG = 'get'.ucfirst($field);
			$methodeS = 'set'.ucfirst($field);
			$target->{$methodeS}($target->{$methodeG}() +1);
		}
		
		//HELP
		$oneselected = false;
		for ($i=1;$i<=4;$i++) {
			$methodeG = 'getHelp_'.$i;
			$methodeS = 'setHelp_'.$i;
			$val = $target->{$methodeG}();
			if (!empty($val)) {
				$oneselected = true;
			} else {
				$target->{$methodeS}(0);
			}
		}
		
		if ($oneselected == false) {
			$target->setHelp_5(1);
		} else {
			$target->setHelp_5(0);
		}
		
		//HELP2
		$oneselected = false;
		for ($i=1;$i<=4;$i++) {
			$methodeG = 'getHelp2_'.$i;
			$methodeS = 'setHelp2_'.$i;
			$val = $target->{$methodeG}();
			if (!empty($val)) {
				$oneselected = true;
			} else {
				$target->{$methodeS}(0);
			}
		}
		
		if ($oneselected == false) {
			$target->setHelp2_5(1);
		} else {
			$target->setHelp2_5(0);
		}
		
		return $target;
	}
	
	private function filterRoma_questionnaire_haq(HAQ $source,Roma_questionnaire_haq $target) {
		
		$list = $source->getValuesAsArray();
		$id = trim($source->getZiekenhuisnummer()).'_'.(key_exists('geboortedatum', $list) ? trim($source->getGeboortedatum()).'_' : '').(key_exists('gebdat', $list) ? trim($source->getGebdat()).'_' : '').(key_exists('onderzoeksdatum', $list) ? trim($source->getOnderzoeksdatum()) : '');
		
		$lower = array('dressing','hairwash','chair','bed','cutmeat','drinking','openmilk','walking','stairs','bodywash','bath','toilet','weight','pickup','cardoor','potlid','faucet','shopping','inoutcar','vacuumgardening');
		foreach($lower as $field) {
			$methodeG = 'get'.ucfirst($field);
			$methodeS = 'set'.ucfirst($field);
			$target->{$methodeS}($target->{$methodeG}() +1);
		}
		
		//AID
		$oneselected = false;
		for ($i=1;$i<=8;$i++) {
			$methodeG = 'getAid_'.$i;
			$methodeS = 'setAid_'.$i;
			$val = $target->{$methodeG}();
			if (!empty($val)) {
				$oneselected = true;
			} else {
				$target->{$methodeS}(0);
			}
		}
		
		if ($oneselected == false) {
			$target->setAid_9(1);
		} else {
			$target->setAid_9(0);
		}
		
		//AID2
		$oneselected = false;
		for ($i=1;$i<=7;$i++) {
			$methodeG = 'getAid2_'.$i;
			$methodeS = 'setAid2_'.$i;
			$val = $target->{$methodeG}();
			if (!empty($val)) {
				$oneselected = true;
			} else {
				$target->{$methodeS}(0);
			}
		}
		
		if ($oneselected == false) {
			$target->setAid2_8(1);
		} else {
			$target->setAid2_8(0);
		}
		
		//HELP
		$oneselected = false;
		for ($i=1;$i<=4;$i++) {
			$methodeG = 'getHelp_'.$i;
			$methodeS = 'setHelp_'.$i;
			$val = $target->{$methodeG}();
			if (!empty($val)) {
				$oneselected = true;
			} else {
				$target->{$methodeS}(0);
			}
		}
		
		if ($oneselected == false) {
			$target->setHelp_5(1);
		} else {
			$target->setHelp_5(0);
		}
		
		//HELP2
		$oneselected = false;
		for ($i=1;$i<=4;$i++) {
			$methodeG = 'getHelp2_'.$i;
			$methodeS = 'setHelp2_'.$i;
			$val = $target->{$methodeG}();
			if (!empty($val)) {
				$oneselected = true;
			} else {
				$target->{$methodeS}(0);
			}
		}
		
		if ($oneselected == false) {
			$target->setHelp2_5(1);
		} else {
			$target->setHelp2_5(0);
		}
		
		return $target;
	}
	
	private function filterRoma_questionnaire_mic(MIC $source,Roma_questionnaire_mic $target) {
		

		
		if (is_numeric($target->getReuma_expect())) {
			$val = $source->getExpTransZA();
			$val = ($val-4)*-1;
			$target->setReuma_expect($val);
		}
		if (is_numeric($target->getReuma_compare())) {
			$val = $source->getTransZA();
			$val = ($val-4)*-1;
			$target->setReuma_compare($val);
		}
		
		if (is_numeric($target->getReuma_content())) {
			$val = $source->getPASS();
			$val = ($val-3)*-1;
			$target->setReuma_content($val);
		}
		
		
		//
		
		
		return $target;
	}
	
	private function filterRoma_questionnaire_euroqol(Euroquol $source,Roma_questionnaire_euroqol $target) {
		
		$list = $source->getValuesAsArray();
		$id = trim($source->getZiekenhuisnummer()).'_'.(key_exists('geboortedatum', $list) ? trim($source->getGeboortedatum()).'_' : '').(key_exists('gebdat', $list) ? trim($source->getGebdat()).'_' : '').(key_exists('onderzoeksdatum', $list) ? trim($source->getOnderzoeksdatum()) : '');
		
		$bList = array('mobility','selfcare','activities','pain','mood','health_lastyear');
		
		foreach($bList as $item) {
			$methodeS = 'set'.ucfirst($item);
			$methodeG = 'get'.ucfirst($item);
			if ($target->{$methodeG}() > 3 || $target->{$methodeG}() < 1) {
				$target->{$methodeS}(null);
				$this->errors[$id][] = 'De waarde voor '.$item.' valt niet tussen 1 en 3.';
			}
		}
		
		if ($target->getVas_health() > 100 || $target->getVas_health() < 0) {
			$this->errors[$id][] = 'De waarde voor vas_health valt niet tussen 0 en 100.';
		}
		
		return $target;
	}
	
	private function filterRoma_patient_dreammedication(Medicatie $source,Roma_patient_dreammedication $target) {
		$uid = trim($source->getZiekenhuisnummer()).'_'.trim($source->getStartdatum()).'_'.trim($source->getStopdatum());//.'_'.(key_exists('geboortedatum', $list) ? trim($source->getGeboortedatum()).'_' : '').(key_exists('gebdat', $list) ? trim($source->getGebdat()).'_' : '').(key_exists('onderzoeksdatum', $list) ? trim($source->getOnderzoeksdatum()) : '');
		
		// $this->dm_freq;
		// $this->dm_med;
		// $this->dm_route;
		// $this->dm_stop;
		// $this->dm_unit;
		
		$target->setEntered_by_user_id(2034);
		$target->setEntered_on(date('Y-m-d H:i:s'));
		
		$medicine = array_search(strtolower($target->getMedicine()),$this->dm_med);
		$unit = array_search(strtolower($target->getUnit()),$this->dm_unit);
		$frequency = array_search(strtolower($target->getFrequency()),$this->dm_freq);
		$route = array_search(strtolower($target->getRoute()),$this->dm_route);
		
		if ($medicine == false) {
			$found = false;
			foreach($this->medlist as $id=>$medlist) {
				$medicine = array_search($target->getMedicine(), $medlist);
				if ($medicine != false) {
					$target->setOthermedicine($target->getMedicine());
					$target->setMedicine($id);
					$found = true;
					break;
				}
			}
			
			if ($found == false) {
				$this->notices[$uid][] = 'NOT FOUND: '.$target->getMedicine();
				//details('NOT FOUND: '.$target->getMedicine());
				$target->setOthermedicine($target->getMedicine());
				$target->setMedicine(0);
			}
		} else {
			$target->setMedicine($medicine);
		}
		
		if ($unit == false) {
			$target->setUnit(null);
		} else {
			$target->setUnit($unit);
		}
		
		if ($frequency == false) {
			$target->setFrequency(null);
		} else {
			$target->setFrequency($unit);
		}
		
		if ($route == false) {
			$target->setRoute(null);
		} else {
			$target->setRoute($unit);
		}
		
		
		
		$stop1 = array_search(strtolower($source->getReden_1()), $this->dm_stop);
		if ($stop1 == false) {
			$stop2 = array_search(strtolower($source->getReden_2()), $this->dm_stop);
			if ($stop2 == false) {
				$stop3 = array_search(strtolower($source->getReden_3()), $this->dm_stop);
				if ($stop3 == false) {
					$stoptext = trim($target->getStop_text());
					if (!empty($stoptext)) {
						$target->setStopreason(6); //Overig
					}
				} else {
					$target->setStopreason($stop3);
				}
			} else {
				$target->setStopreason($stop2);
			}
		} else {
			$target->setStopreason($stop1);
		}
		
		$target->setDose(trim($target->getDose()));
		
		return $target;
	}
	
	private function filterRoma_patient_comorbidity_history(Medische_vg $source,Roma_patient_comorbidity_history $target) {
		$target->setEntered_by_user_id(2034);
		$target->setEntered_on(date('Y-m-d H:i:s'));
		
		if (key_exists($target->getComorbidity(), $this->arr)) {
			$list =$this->arr[$target->getComorbidity()];
			if (key_exists('v1', $list)) {
				$target->setComorbidity($list['v1']);
			}
			if (key_exists('v2', $list)) {
				$target->setComorbidity_option($list['v2']);
			}
		}

		
		return $target;
	}
	
	private function filterRoma_patient_medication_history(Dmard_vg $source,Roma_patient_medication_history $target) {
		
		if (!is_numeric($target->getMedication())) {
			$target->setMedication(null);
		} else {
			$target->setMedication(intval($target->getMedication()));
		}
		
		$target->setEntered_by_user_id(2034);
		$target->setEntered_on(date('Y-m-d H:i:s'));
		
		$stop =$target->getStop_date();
		
		if (empty($stop)) {
			$target->setStop_date('0000-00-00');
			$target->setOngoing(1);
		}
		
		return $target;
	}
	
	
	
	private function filterRoma_patient_bmi(BSE_CRP $source,Roma_patient_bmi $target) {
		
		if (!is_numeric($target->getLength())) {
			$target->setLength(null);
		} else {
			$target->setLength(round($target->getLength()));
		}
		
		if (!is_numeric($target->getWeight())) {
			$target->setWeight(0);
		} else {
			$target->setWeight(round($target->getWeight()));
		}
		
		$weight = $target->getWeight();
		$length = $target->getLength();
		
		if (!empty($weight) && !empty($length)) {
			$bmi_value = round($weight/(($length/100)*($length/100)));
			$target->setBmi($bmi_value);
		} else {
			$target->setBmi(0);
		}
		
		return $target;
	}
	
	private function filterRoma_questionnaire_sociodemo(Demografie_leefstijl $source,Roma_questionnaire_sociodemo $target) {
		
		//Filter werk
		$id = trim($source->getZiekenhuisnummer()).'_'.(key_exists('geboortedatum', $list) ? trim($source->getGeboortedatum()).'_' : '').(key_exists('gebdat', $list) ? trim($source->getGebdat()).'_' : '').(key_exists('onderzoeksdatum', $list) ? trim($source->getOnderzoeksdatum()) : '');
		
		$werk = $source->getDeeltijdwerk_reden();
		while (strpos($werk,'  ') !== false) { $werk = str_replace('  ',' ',$werk); }
		$werk = trim($werk);
		if (!empty($werk)) {
			$aWerk = explode(' ', $werk);
			$aRWerk = array();
			
			foreach($aWerk as $werk) {
				if ($werk == 2) {
					$reden = $source->getDeeltijd_uren();
					if (!empty($reden)) {
						$aRWerk[] = 1+$reden;
					} else {
						$this->errors[$id][] = 'Deeltijd is opgegeven zonder tijdsaanduiding.';
					}
				} else {
					if ($werk > 2) {
						$aRWerk[] = $werk + 2;
					} else {
						$aRWerk[] = $werk;
					}
				}
			}
			
			if (empty($aRWerk) && empty($aWerk)) {
				$this->errors[$id][] = 'Er is geen leefsituatie opgegeven.';
			}
		
			foreach($aRWerk as $living) {
				$target->{'setCurrent_living_situation_'.$living}(1);
			}
		}
		
		$alcohol = $target->getAlcohol();
		$alcoholW = $target->getAlcohol_amount_week();
		$alcoholE = $target->getAlcohol_amount_weekend();
		if (empty($alcohol)) {
			$this->errors[$id][] = 'Alcholvraag is 0 of null: 1=nee, 2=ja.';
		} elseif ($alcohol == 2) {
			if (empty($alcoholW) || $alcoholW > 5) {
				$this->errors[$id][] = 'Alcohol-> Ja. Alcholvraag week valt niet tussen 1 en 5.';
			}
			if (empty($alcoholE) || $alcoholE > 5) {
				$this->errors[$id][] = 'Alcohol-> Ja. Alcholvraag weekend valt niet tussen 1 en 5.';
			}
		}
		
		$smoking = $target->getSmoking();
		$smokingA = $target->getSmoking_amount();
		$smokingP = $target->getSmoking_period();
		if (empty($smoking)) {
			$this->errors[$id][] = 'Rookvraag is 0 of null: moet 1,2 of 3 zijn.';
		} elseif ($smoking == 3) {
			if (empty($smokingA)) {
				$this->errors[$id][] = 'Rookvraag-> Ja. Geen rookhoeveelheid.';
			}
			if (empty($smokingP)) {
				$this->errors[$id][] = 'Rookvraag-> Ja. Geen rookperiode.';
			}
		}
		
		return $target;
	}

	private function filterRoma_patient_das28(gewrichtsscore $source,Roma_patient_das28 $target) {
		
		foreach($target->getValuesAsArray() as $field=>$value) {
			$fieldSet = "set".ucfirst($field);
			if (substr($field, 0,4) == 'rai_') {
				if ($value == 9) {
					$target->{$fieldSet}(3);
				} elseif ($value != 9 && $value =! 0 && $value != 1) {
					$target->{$fieldSet}(null);
				}
			} elseif (substr($field, 0,4) == 'sji_') {
				if ($value == 1 || $value == 2 || $value == 3) {
					$target->{$fieldSet}(1);
				} elseif ($value == 9) {
					$target->{$fieldSet}(2);
				} else {
					$target->{$fieldSet}(null);
				}
			}
		}
		
		$tjc28 = 0;
		$sjc28 = 0;
		$joints = array();
		foreach($target->getValuesAsArray() as $field=>$value) {
			if (substr($field,0,3) == 'rai' && $value == 1) {
				$tjc28 ++;
			} elseif (substr($field,0,3) == 'sji' && $value == 1) {
				$sjc28 ++;
			}
		}

		$target->setTjc28($tjc28);
		$target->setSjc28($sjc28);

		return $target;
	}
	
	private function timestamp2date($timestamp) {
		if (is_int($timestamp)) {
			$return = date('Y-m-d',$timestamp);	
		} else {
			$return = null;
		}
		return $return;
	}
	
	private function timestamp2datetime($timestamp) {
		if (is_int($timestamp)) {
			$return = date('Y-m-d H:i:s',$timestamp);	
		} else {
			$return = null;
		}
		return $return;
	}	
	
	private function formatDecimal($decimal) {
		$decimal = str_replace(',','.',$decimal);
		if (!is_numeric($decimal)) {
			$decimal = null;
		}
		return $decimal;
	}
	
	private function formatDate($date) {
		$fDate = strtotime($date);
		if ($fDate != false) {
			$return = $this->timestamp2date($fDate);
		} else {
			$return = false;
		}
		
		return $return;
	}
	
	private function formatDatetime($datetime) {
		$fDatetime = strtotime($datetime);
		if ($fDatetime != false) {
			$return = $this->timestamp2datetime($fDatetime);
		} else {
			$return = false;
		}
		
		return $return;
	}
	
	private function getForeinKeys($db, $table) {
		
		$sql = 'SELECT
		    `column_name`, 
		    `referenced_table_schema` AS foreign_db, 
		    `referenced_table_name` AS foreign_table, 
		    `referenced_column_name`  AS foreign_column 
		FROM
		    `information_schema`.`KEY_COLUMN_USAGE`
		WHERE
		    `constraint_schema` = SCHEMA()
		AND
		    `table_name` = :table
		AND
		    `referenced_column_name` IS NOT NULL
		ORDER BY
		    `column_name`';

		$values = array('table'=>$table);
		
		$r = $db->query($sql,$values);
		$aFormResults = $r->fetchAll(PDO::FETCH_ASSOC);
		$returnArray = array();
		foreach($aFormResults as $result)
		{
			$returnArray[$result['column_name']] = $result;
		}
		
		return $returnArray;
	}
	
	private function getAllTables($db) {
		$sql = 'SHOW TABLES	FROM `'.$db->getDbName().'`';
		
		$r = $db->query($sql,array());
		$aFormResults = $r->fetchAll(PDO::FETCH_ASSOC);
		$returnArray = array();
		foreach($aFormResults as $result)
		{
			foreach($result as $table) {
				$returnArray[] = $table;
			}
		}
		
		return $returnArray;
	}
	
	private function lol () {
		/*
		 //sociodemo
		$return = array();
		$return['source'] = 'demografie_leefstijl';
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['target'] = 'roma_questionnaire_sociodemo';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['smoking']['link'] = 'roken';
		$return['fields']['smoking_amount']['link'] = 'aantal_roken';
		$return['fields']['smoking_period']['link'] = 'jaren_roken';
		$return['fields']['alcohol']['link'] = 'alcohol';
		$return['fields']['alcohol_amount_week']['link'] = 'alcohol_week';
		$return['fields']['alcohol_amount_weekend']['link'] = 'alcohol_weekend';
		*/

		/*
		$return = array();
		$return['source'] = 'BSE_CRP';
		$return['where'] = "WHERE (`CRP` IS NOT NULL OR `BSE` IS NOT NULL) AND onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['target'] = 'roma_patient_lab';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['lab_date']['link'] = 'onderzoeksdatum';
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['crp']['link'] = 'CRP';
		$return['fields']['crp']['options']['convert']['999'] = null;
		$return['fields']['bse']['link'] = 'BSE';
		$return['fields']['bse']['options']['convert']['999'] = null;
		*/
		
		/*
		$return = array();
		$return['source'] = 'BSE_CRP';
		$return['where'] = "WHERE (`Lengte` IS NOT NULL OR `Gewicht` IS NOT NULL) AND onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['target'] = 'roma_patient_bmi';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['length']['link'] = 'Lengte';
		$return['fields']['weight']['link'] = 'Gewicht'; */
		
		/*
		$return = array();
		$return['where'] = "WHERE (`Reumafactor` IS NOT NULL OR `IgM-RF` IS NOT NULL) AND onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'BSE_CRP';
		$return['target'] = 'roma_patient_rheumatismfactor';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['reumafactor']['link'] = 'Reumafactor';
		$return['fields']['reumafactor']['options']['convert']['0'] = '2';
		$return['fields']['reumafactor']['options']['convert']['999'] = null;
		$return['fields']['reumafactor_amount']['link'] = 'IgM_RF';
		$return['fields']['reumafactor_date']['link'] = 'lab';*/
		
		/*
		$return = array();
		$return['where'] = "WHERE (`AntiCCP` IS NOT NULL OR `datum_antiCCP` IS NOT NULL) AND onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'BSE_CRP';
		$return['target'] = 'roma_patient_anticcp';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['anticcp']['link'] = 'AntiCCP';
		$return['fields']['anticcp']['options']['convert']['0'] = '2';
		$return['fields']['anticcp']['options']['convert']['999'] = null;
		$return['fields']['anticcp_date']['link'] = 'datum_antiCCP';*/
		
		
		/*
		$return = array();
		$return['where'] = "WHERE (`Erosief` IS NOT NULL OR `Datum_Xray` IS NOT NULL) AND onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'BSE_CRP';
		$return['target'] = 'roma_patient_rontgen';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['erosions']['link'] = 'Erosief';
		$return['fields']['erosions']['options']['convert']['999'] = null;
		$return['fields']['rontgen_date']['link'] = 'Datum_Xray';
		*/
		
		/*
		$return = array();
		//$return['where'] = 'LIMIT 500';
		$return['source'] = 'HAQ';
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['target'] = 'roma_questionnaire_haq';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['dressing']['link'] = 'HAQ_1';
		$return['fields']['hairwash']['link'] = 'HAQ_2';
		$return['fields']['chair']['link'] = 'HAQ_3';
		$return['fields']['bed']['link'] = 'HAQ_4';
		$return['fields']['cutmeat']['link'] = 'HAQ_5';
		$return['fields']['drinking']['link'] = 'HAQ_6';
		$return['fields']['openmilk']['link'] = 'HAQ_7';
		$return['fields']['walking']['link'] = 'HAQ_8';
		$return['fields']['stairs']['link'] = 'HAQ_9';
		$return['fields']['bodywash']['link'] = 'HAQ_10';
		$return['fields']['bath']['link'] = 'HAQ_11';
		$return['fields']['toilet']['link'] = 'HAQ_12';
		$return['fields']['weight']['link'] = 'HAQ_13';
		$return['fields']['pickup']['link'] = 'HAQ_14';
		$return['fields']['cardoor']['link'] = 'HAQ_15';
		$return['fields']['potlid']['link'] = 'HAQ_16';
		$return['fields']['faucet']['link'] = 'HAQ_17';
		$return['fields']['shopping']['link'] = 'HAQ_18';
		$return['fields']['inoutcar']['link'] = 'HAQ_19';
		$return['fields']['vacuumgardening']['link'] = 'HAQ_20';
		
		$return['fields']['aid_1']['link'] = 'HAQ_hm1';
		$return['fields']['aid_2']['link'] = 'HAQ_hm2';
		$return['fields']['aid_3']['link'] = 'HAQ_hm3';
		$return['fields']['aid_4']['link'] = 'HAQ_hm4';
		$return['fields']['aid_5']['link'] = 'HAQ_hm5';
		$return['fields']['aid_6']['link'] = 'HAQ_hm6';
		$return['fields']['aid_7']['link'] = 'HAQ_hm7';
		$return['fields']['aid_8']['link'] = 'HAQ_hm8';
		$return['fields']['aid2_1']['link'] = 'HAQ_hm9';
		$return['fields']['aid2_2']['link'] = 'HAQ_hm10';
		$return['fields']['aid2_3']['link'] = 'HAQ_hm11';
		$return['fields']['aid2_4']['link'] = 'HAQ_hm12';
		$return['fields']['aid2_5']['link'] = 'HAQ_hm13';
		$return['fields']['aid2_6']['link'] = 'HAQ_hm14';
		$return['fields']['aid2_7']['link'] = 'HAQ_hm15';
		
		$return['fields']['help_1']['link'] = 'HAQ_cat1';
		$return['fields']['help_2']['link'] = 'HAQ_cat2';
		$return['fields']['help_3']['link'] = 'HAQ_cat3';
		$return['fields']['help_4']['link'] = 'HAQ_cat4';
		$return['fields']['help2_1']['link'] = 'HAQ_cat5';
		$return['fields']['help2_2']['link'] = 'HAQ_cat6';
		$return['fields']['help2_3']['link'] = 'HAQ_cat7';
		$return['fields']['help2_4']['link'] = 'HAQ_cat8';
		*/
		
		
		/*
		$return = array();
		//$return['where'] = 'LIMIT 500';
		$return['source'] = 'HAQconsensus';
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['target'] = 'roma_questionnaire_haq_duco10';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['dressing']['link'] = 'HAQ_1';
		$return['fields']['hairwash']['link'] = 'HAQ_2';
		$return['fields']['chair']['link'] = 'HAQ_3';
		$return['fields']['bed']['link'] = 'HAQ_4';
		$return['fields']['cutmeat']['link'] = 'HAQ_5';
		$return['fields']['drinking']['link'] = 'HAQ_6';
		$return['fields']['openmilk']['link'] = 'HAQ_7';
		$return['fields']['walking']['link'] = 'HAQ_8';
		$return['fields']['stairs']['link'] = 'HAQ_9';
		$return['fields']['bodywash']['link'] = 'HAQ_10';
		$return['fields']['bath']['link'] = 'HAQ_11';
		$return['fields']['toilet']['link'] = 'HAQ_12';
		$return['fields']['weight']['link'] = 'HAQ_13';
		$return['fields']['pickup']['link'] = 'HAQ_14';
		$return['fields']['cardoor']['link'] = 'HAQ_15';
		$return['fields']['potlid']['link'] = 'HAQ_16';
		$return['fields']['faucet']['link'] = 'HAQ_17';
		$return['fields']['shopping']['link'] = 'HAQ_18';
		$return['fields']['inoutcar']['link'] = 'HAQ_19';
		$return['fields']['vacuumgardening']['link'] = 'HAQ_20';
		$return['fields']['help_1']['link'] = 'HAQ_cat1';
		$return['fields']['help_2']['link'] = 'HAQ_cat2';
		$return['fields']['help_3']['link'] = 'HAQ_cat3';
		$return['fields']['help_4']['link'] = 'HAQ_cat4';
		$return['fields']['help2_1']['link'] = 'HAQ_cat5';
		$return['fields']['help2_2']['link'] = 'HAQ_cat6';
		$return['fields']['help2_3']['link'] = 'HAQ_cat7';
		$return['fields']['help2_4']['link'] = 'HAQ_cat8';
		*/
		
		/*
		$return = array();
		$return['where'] = "WHERE (`DMARD_vg` IS NOT NULL AND `DMARD_vg` < :eighteen) AND `startdat_DMARD_vg` IS NOT NULL";
		$return['wherevars'] = array('eighteen'=>18);
		$return['source'] = 'dmard_vg';
		$return['target'] = 'roma_patient_medication_history';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['medication']['link'] = 'DMARD_vg';
		$return['fields']['start_date']['link'] = 'Startdat_DMARD_vg';
		$return['fields']['stop_date']['link'] = 'stopdat_DMARD_vg';
		*/
		
		/*
		$return = array();
		//$return['where'] = "WHERE (`DMARD_vg` IS NOT NULL AND `DMARD_vg` < :eighteen)";
		//$return['wherevars'] = array('eighteen'=>18);
		$return['source'] = 'Euroquol';
		$return['target'] = 'roma_questionnaire_euroqol';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['mobility']['link'] = 'euroqolvr1';
		$return['fields']['selfcare']['link'] = 'euroqolvr2';
		$return['fields']['activities']['link'] = 'euroqolvr3';
		$return['fields']['pain']['link'] = 'euroqolvr4';
		$return['fields']['mood']['link'] = 'euroqolvr5';
		$return['fields']['health_lastyear']['link'] = 'euroqolvr6';
		$return['fields']['vas_health']['link'] = 'euroqolvr7';
		
		$return['fields']['mobility']['options']['convert']['999'] = null;
		$return['fields']['selfcare']['options']['convert']['999'] = null;
		$return['fields']['activities']['options']['convert']['999'] = null;
		$return['fields']['pain']['options']['convert']['999'] = null;
		$return['fields']['mood']['options']['convert']['999'] = null;
		$return['fields']['health_lastyear']['options']['convert']['999'] = null;
		$return['fields']['vas_health']['options']['convert']['999'] = null;
		*/
		
		/*
		$return = array();
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'gewrichtsscore';
		$return['target'] = 'roma_patient_das28';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'Onderzoeksdatum';

		$return['fields']['rai_cwk']['link'] = 'CWK';
		$return['fields']['rai_sc_right']['link'] = 'R_Pijn_1';
		$return['fields']['sji_sc_right']['link'] = 'R_Zwelling_1';
		$return['fields']['rai_sc_left']['link'] = 'L_Pijn_1';
		$return['fields']['sji_sc_left']['link'] = 'L_Zwelling_1';
		$return['fields']['rai_ac_right']['link'] = 'R_Pijn_2';
		$return['fields']['sji_ac_right']['link'] = 'R_Zwelling_2';
		$return['fields']['rai_ac_left']['link'] = 'L_Pijn_2';
		$return['fields']['sji_ac_left']['link'] = 'L_Zwelling_2';
		$return['fields']['rai_tmp_right']['link'] = 'R_Pijn_3';
		$return['fields']['rai_tmp_left']['link'] = 'L_Pijn_3';
		$return['fields']['rai_shoulder_right']['link'] = 'R_Pijn_4';
		$return['fields']['sji_shoulder_right']['link'] = 'R_Zwelling_4';
		$return['fields']['rai_shoulder_left']['link'] = 'L_Pijn_4';
		$return['fields']['sji_shoulder_left']['link'] = 'L_Zwelling_4';
		$return['fields']['rai_elbow_right']['link'] = 'R_Pijn_5';
		$return['fields']['sji_elbow_right']['link'] = 'R_Zwelling_5';
		$return['fields']['rai_elbow_left']['link'] = 'L_Pijn_5';
		$return['fields']['sji_elbow_left']['link'] = 'L_Zwelling_5';
		$return['fields']['rai_wrist_right']['link'] = 'R_Pijn_6';
		$return['fields']['sji_wrist_right']['link'] = 'R_Zwelling_6';
		$return['fields']['rai_wrist_left']['link'] = 'L_Pijn_6';
		$return['fields']['sji_wrist_left']['link'] = 'L_Zwelling_6';
		$return['fields']['rai_mcp1_right']['link'] = 'R_Pijn_7';
		$return['fields']['sji_mcp1_right']['link'] = 'R_Zwelling_7';
		$return['fields']['rai_mcp1_left']['link'] = 'L_Pijn_7';
		$return['fields']['sji_mcp1_left']['link'] = 'L_Zwelling_7';
		$return['fields']['rai_mcp2_right']['link'] = 'R_Pijn_8';
		$return['fields']['sji_mcp2_right']['link'] = 'R_Zwelling_8';
		$return['fields']['rai_mcp2_left']['link'] = 'L_Pijn_8';
		$return['fields']['sji_mcp2_left']['link'] = 'L_Zwelling_8';
		$return['fields']['rai_mcp3_right']['link'] = 'R_Pijn_9';
		$return['fields']['sji_mcp3_right']['link'] = 'R_Zwelling_9';
		$return['fields']['rai_mcp3_left']['link'] = 'L_Pijn_9';
		$return['fields']['sji_mcp3_left']['link'] = 'L_Zwelling_9';
		$return['fields']['rai_mcp4_right']['link'] = 'R_Pijn_10';
		$return['fields']['sji_mcp4_right']['link'] = 'R_Zwelling_10';
		$return['fields']['rai_mcp4_left']['link'] = 'L_Pijn_10';
		$return['fields']['sji_mcp4_left']['link'] = 'L_Zwelling_10';
		$return['fields']['rai_mcp5_right']['link'] = 'R_Pijn_11';
		$return['fields']['sji_mcp5_right']['link'] = 'R_Zwelling_11';
		$return['fields']['rai_mcp5_left']['link'] = 'L_Pijn_11';
		$return['fields']['sji_mcp5_left']['link'] = 'L_Zwelling_11';
		$return['fields']['rai_pip1_right']['link'] = 'R_Pijn_12';
		$return['fields']['sji_pip1_right']['link'] = 'R_Zwelling_12';
		$return['fields']['rai_pip1_left']['link'] = 'L_Pijn_12';
		$return['fields']['sji_pip1_left']['link'] = 'L_Zwelling_12';
		$return['fields']['rai_pip2_right']['link'] = 'R_Pijn_13';
		$return['fields']['sji_pip2_right']['link'] = 'R_Zwelling_13';
		$return['fields']['rai_pip2_left']['link'] = 'L_Pijn_13';
		$return['fields']['sji_pip2_left']['link'] = 'L_Zwelling_13';
		$return['fields']['rai_pip3_right']['link'] = 'R_Pijn_14';
		$return['fields']['sji_pip3_right']['link'] = 'R_Zwelling_14';
		$return['fields']['rai_pip3_left']['link'] = 'L_Pijn_14';
		$return['fields']['sji_pip3_left']['link'] = 'L_Zwelling_14';
		$return['fields']['rai_pip4_right']['link'] = 'R_Pijn_15';
		$return['fields']['sji_pip4_right']['link'] = 'R_Zwelling_15';
		$return['fields']['rai_pip4_left']['link'] = 'L_Pijn_15';
		$return['fields']['sji_pip4_left']['link'] = 'L_Zwelling_15';
		$return['fields']['rai_pip5_right']['link'] = 'R_Pijn_16';
		$return['fields']['sji_pip5_right']['link'] = 'R_Zwelling_16';
		$return['fields']['rai_pip5_left']['link'] = 'L_Pijn_16';
		$return['fields']['sji_pip5_left']['link'] = 'L_Zwelling_16';
		$return['fields']['rai_hip_right']['link'] = 'R_Pijn_17';
		$return['fields']['rai_hip_left']['link'] = 'L_Pijn_17';
		$return['fields']['rai_knee_right']['link'] = 'R_Pijn_18';
		$return['fields']['sji_knee_right']['link'] = 'R_Zwelling_18';
		$return['fields']['rai_knee_left']['link'] = 'L_Pijn_18';
		$return['fields']['sji_knee_left']['link'] = 'L_Zwelling_18';
		$return['fields']['rai_ankle_right']['link'] = 'R_Pijn_19';
		$return['fields']['sji_ankle_right']['link'] = 'R_Zwelling_19';
		$return['fields']['rai_ankle_left']['link'] = 'L_Pijn_19';
		$return['fields']['sji_ankle_left']['link'] = 'L_Zwelling_19';
		$return['fields']['rai_subtalair_right']['link'] = 'R_Pijn_20';
		$return['fields']['rai_subtalair_left']['link'] = 'L_Pijn_20';
		$return['fields']['rai_midtarsaal_right']['link'] = 'R_Pijn_21';
		$return['fields']['rai_midtarsaal_left']['link'] = 'L_Pijn_21';
		$return['fields']['rai_mtp1_right']['link'] = 'R_Pijn_22';
		$return['fields']['sji_mtp1_right']['link'] = 'R_Zwelling_22';
		$return['fields']['rai_mtp1_left']['link'] = 'L_Pijn_22';
		$return['fields']['sji_mtp1_left']['link'] = 'L_Zwelling_22';
		$return['fields']['rai_mtp2_right']['link'] = 'R_Pijn_23';
		$return['fields']['sji_mtp2_right']['link'] = 'R_Zwelling_23';
		$return['fields']['rai_mtp2_left']['link'] = 'L_Pijn_23';
		$return['fields']['sji_mtp2_left']['link'] = 'L_Zwelling_23';
		$return['fields']['rai_mtp3_right']['link'] = 'R_Pijn_24';
		$return['fields']['sji_mtp3_right']['link'] = 'R_Zwelling_24';
		$return['fields']['rai_mtp3_left']['link'] = 'L_Pijn_24';
		$return['fields']['sji_mtp3_left']['link'] = 'L_Zwelling_24';
		$return['fields']['rai_mtp4_right']['link'] = 'R_Pijn_25';
		$return['fields']['sji_mtp4_right']['link'] = 'R_Zwelling_25';
		$return['fields']['rai_mtp4_left']['link'] = 'L_Pijn_25';
		$return['fields']['sji_mtp4_left']['link'] = 'L_Zwelling_25';
		$return['fields']['rai_mtp5_right']['link'] = 'R_Pijn_26';
		$return['fields']['sji_mtp5_right']['link'] = 'R_Zwelling_26';
		$return['fields']['rai_mtp5_left']['link'] = 'L_Pijn_26';
		$return['fields']['sji_mtpt_left']['link'] = 'L_Zwelling_26';
		*/
		
/*
		 $return = array();
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'MIC';
		$return['target'] = 'roma_questionnaire_mic';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';

		$return['fields']['reuma_compare']['link'] = 'TransZA';
		$return['fields']['reason_1']['link'] = 'det1';
		$return['fields']['reason_2']['link'] = 'det2';
		$return['fields']['reason_3']['link'] = 'det3';
		$return['fields']['poly_months']['link'] = 'Polibezoek';
		$return['fields']['reuma_expect']['link'] = 'ExpTransZA';
		$return['fields']['reuma_content']['link'] = 'PASS';
		$return['fields']['reuma_medication']['link'] = 'PATATT';
		
		$return['fields']['reuma_medication']['options']['convert']['0'] = '2';
		$return['fields']['reuma_medication']['options']['convert']['-1'] = '3';
		$return['fields']['reuma_medication']['options']['convert']['9'] = '4';
*/
		
/*
		 $return = array();
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'Vassen';
		$return['target'] = 'roma_patient_diseaseactivity';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		
		$return['fields']['pain']['link'] = 'Vas_1';
		$return['fields']['wellbeing']['link'] = 'Vas_2';
		$return['fields']['diseaseactivity']['link'] = 'Vas_3';
*/
		
		/*
		$return = array();
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'Vas_arts';
		$return['target'] = 'roma_patient_comorbidity_history';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		$return['fields']['assessor']['link'] = 'Vas_arts';
		*/
		
		/*
		$return = array();
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'Vas_arts';
		$return['target'] = 'roma_patient_diseaseactivity';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';
		
		$return['fields']['assessor']['link'] = 'Vas_arts';
*/
	
/*
		 $return = array();
		$return['where'] = "WHERE onderzoeksdatum > :earlydate";
		$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'MIC';
		$return['target'] = 'roma_questionnaire_mic';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['date']['link'] = 'onderzoeksdatum';

		$return['fields']['reuma_compare']['link'] = 'TransZA';
		$return['fields']['reason_1']['link'] = 'det1';
		$return['fields']['reason_2']['link'] = 'det2';
		$return['fields']['reason_3']['link'] = 'det3';
		$return['fields']['poly_months']['link'] = 'Polibezoek';
		$return['fields']['reuma_expect']['link'] = 'ExpTransZA';
		$return['fields']['reuma_content']['link'] = 'PASS';
		$return['fields']['reuma_medication']['link'] = 'PATATT';
		
		$return['fields']['reuma_medication']['options']['convert']['0'] = '2';
		$return['fields']['reuma_medication']['options']['convert']['-1'] = '3';
		$return['fields']['reuma_medication']['options']['convert']['9'] = '4';
*/
		
		
		$return = array();
		//$return['where'] = "LIMIT 20000";
		//$return['wherevars'] = array('earlydate'=>'1980-01-01 00:00:00');
		$return['source'] = 'medicatie';
		$return['target'] = 'roma_patient_dreammedication';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly

		$return['fields']['medicine']['link'] = 'Medicatie';
		$return['fields']['dose']['link'] = 'Dosis';
		$return['fields']['unit']['link'] = 'Eenheid';
		$return['fields']['frequency']['link'] = 'Frequentie';
		$return['fields']['route']['link'] = 'Route';
		$return['fields']['start_date']['link'] = 'Startdatum';
		$return['fields']['stop_date']['link'] = 'Stopdatum';
		$return['fields']['stop_text']['link'][0] = 'Reden_1';
		$return['fields']['stop_text']['link'][1] = 'Reden_2';
		$return['fields']['stop_text']['link'][2] = 'Reden_3';
		$return['fields']['stop_text']['options']['seperator'] = ' ';
		
		$return['fields']['route']['options']['convert']['oraal'] = 'po';
		$return['fields']['route']['options']['convert']['rectaal'] = 'pr';
		$return['fields']['route']['options']['convert']['subcutaan'] = 'sc';
		$return['fields']['route']['options']['convert']['sublinguaal'] = 'sl';
		$return['fields']['route']['options']['convert']['parenteraal'] = 'sc';
		
		$return['fields']['frequency']['options']['convert']['1d1t'] = '1x/d';
		$return['fields']['frequency']['options']['convert']['2d1t'] = '2x/d';
		$return['fields']['frequency']['options']['convert']['1w1ij'] = '1X/w';
		$return['fields']['frequency']['options']['convert']['2w1t'] = '2x/w';
		$return['fields']['frequency']['options']['convert']['1d1c'] = '1x/d';
		$return['fields']['frequency']['options']['convert']['1w1i'] = '1x/w';
		$return['fields']['frequency']['options']['convert']['odw1inj'] = '1x/2w';
		$return['fields']['frequency']['options']['convert']['1d2t'] = '1x/d';
		$return['fields']['frequency']['options']['convert']['3d2t'] = '3x/d';
		$return['fields']['frequency']['options']['convert']['3d1t'] = '3x/d';
		$return['fields']['frequency']['options']['convert']['1w1t'] = '1x/w';
		$return['fields']['frequency']['options']['convert']['2d1c'] = '2x/d';
		$return['fields']['frequency']['options']['convert']['1-2d1t'] = '2x/d';
		$return['fields']['frequency']['options']['convert']['4d2t'] = '4x/d';
		$return['fields']['frequency']['options']['convert']['2d2t'] = '2x/d';
		$return['fields']['frequency']['options']['convert']['1d1'] = '1x/d';
		$return['fields']['frequency']['options']['convert']['1d3t'] = '1x/d';
		$return['fields']['frequency']['options']['convert']['4d1t'] = '4x/d';
		$return['fields']['frequency']['options']['convert']['1d0'] = '1x/d';
		$return['fields']['frequency']['options']['convert']['3d1c'] = '3x/d';
		$return['fields']['frequency']['options']['convert']['1-3d1t'] = '3x/d';
		$return['fields']['frequency']['options']['convert']['2-3d1t'] = '3x/d';
		$return['fields']['frequency']['options']['convert']['1-2d1c'] = '2x/d';
		$return['fields']['frequency']['options']['convert']['2w1i'] = '2x/w';
		$return['fields']['frequency']['options']['convert']['1-3d1c'] = '3x/d';
		$return['fields']['frequency']['options']['convert']['1-3d2t'] = '3x/d';
		
		$dmfreq = Db2::getTable('Roma_dreammedication_frequency')->getAll()->getResultArray(true);
		foreach($dmfreq as $item) {
			$this->dm_freq[$item['id']] = strtolower($item['frequency']); 
		}
		$dmmed = Db2::getTable('roma_dreammedication_medicine')->getAll()->getResultArray(true);
		foreach($dmmed as $item) {
			$this->dm_med[$item['id']] = strtolower($item['medicine']); 
		}
		$dmroute = Db2::getTable('roma_dreammedication_route')->getAll()->getResultArray(true);
		foreach($dmroute as $item) {
			$this->dm_route[$item['id']] = strtolower($item['abbreviation']); 
		}
		$dmstop = Db2::getTable('roma_dreammedication_stopreason')->getAll()->getResultArray(true);
		foreach($dmstop as $item) {
			$this->dm_stop[$item['id']] = strtolower($item['stopreason']); 
		}
		$dmunit = Db2::getTable('roma_dreammedication_unit')->getAll()->getResultArray(true);
		foreach($dmunit as $item) {
			$this->dm_unit[$item['id']] = strtolower($item['abbreviation']); 
		}
		
		$medlist['101'] = array('Aceclofenac','Acetylsalicylzuur','Celecoxib','Dexibuprofen','Dexketoprofen','Diclofenac','diclofenac/misoprostol','diflunisal','etoricoxib','fenylbutazon','Flurbiprofen','Ibuprofen','Indometacine','Ketoprofen','Meloxicam','Metamizol','Nabumeton','Naproxen','Piroxicam','Rofecoxib','Sulindac','Tenoxicam','Tiaprofeenzuur','Tolfenaminezuur','Valdecoxib');
		$medlist['102'] = array('codeïne','codeine','buprenorfine','Dextropropoxyfeen','fentanyl','morfine','oxycodon','pentazocine','tramadol','Paracetamol','Paracetamol/codeine','Paracetamol/codeïne');
		$medlist['104'] = array('cimetidine','esomeprazol','famotidine','lansomeprazol','misoprostol','nizatidine','omeprazol','pantoprazol','rabeprazol','ranitidine','sucralfaat');
		$medlist['105'] = array('calciumcarbonaat','calciumcarbonaat/lactogluconaat','colecalciferol','alendronaat','risedronaat','etidronaat/calciumcarbonaat');
		$medlist['24'] = array('Benazepril','Captopril','Cilazapril','Enalapril','Enalaprilaat','Fosinopril','Lisinopril','Perindopril','Quinapril','Quinaprilaat','Ramipril','Trandolapril','Zofenopril');
		$medlist['25'] = array('Candesartan','cilexetil','Eprosartan','Irbesartan','Losartan','Olmesartan medoxomil','Telmisartan','Valsartan');
		$medlist['26'] = array('Mannitol','Sorbiol','Bumetanide','Furosemide','Hydrochloorthiazide','Chloortalidon','Indapamide','Amiloride','Triamtereen','eplerenon','spironolacton');
		$medlist['27'] = array('atorvastatine','fluvastatine','pravastatine','rosuvastatine','simvastatine');
		$this->medlist = unserialize(strtolower(serialize($medlist))); 
		
		
		/*
		$return = array();
		$return['where'] = "WHERE startdat_med_vg IS NOT NULL AND medisch_vg IS NOT NULL AND ziekenhuisnummer IS NOT NULL";
		$return['wherevars'] = array();
		$return['source'] = 'medische_vg';
		$return['target'] = 'roma_patient_comorbidity_history';
		$return['options'] = array();
		$return['options']['existing'] = 'update'; // skip/update/replace/emptyonly
		$return['fields']['comorbidity']['link'] = 'medisch_vg';
		$return['fields']['start_date']['link'] = 'startdat_med_vg';
		$return['fields']['stop_date']['link'] = 'stopdat_med_vg';

		$arr['101']['v1'] = 1;	
		$arr['102']['v1'] = 2;
		$arr['103']['v1'] = 3;
		$arr['104']['v1'] = 4;
		$arr['105']['v1'] = 11;
		$arr['106']['v1'] = 13;
		$arr['107']['v1'] = 7;
		$arr['108']['v1'] = 8;
		$arr['109']['v1'] = 9;
		$arr['110']['v1'] = 5;
		$arr['111']['v1'] = 6;
		$arr['201']['v1'] = 10; $arr['201']['v2'] = 1;
		$arr['202']['v1'] = 10; $arr['202']['v2'] = 2;
		$arr['203']['v1'] = 10; $arr['203']['v2'] = 3;
		$arr['204']['v1'] = 10; $arr['204']['v2'] = 4;
		$arr['205']['v1'] = 10; $arr['205']['v2'] = 5;
		$arr['206']['v1'] = 10; $arr['206']['v2'] = 6;
		$arr['207']['v1'] = 10; $arr['207']['v2'] = 7;
		$arr['208']['v1'] = 10; $arr['208']['v2'] = 21;
		$arr['209']['v1'] = 10; $arr['209']['v2'] = 8;
		$arr['210']['v1'] = 10; $arr['210']['v2'] = 9;
		$arr['211']['v1'] = 10; $arr['211']['v2'] = 10;
		$arr['212']['v1'] = 10; $arr['212']['v2'] = 11;
		$arr['213']['v1'] = 10; $arr['213']['v2'] = 12;
		$arr['214']['v1'] = 10; $arr['214']['v2'] = 13;
		$arr['215']['v1'] = 10; $arr['215']['v2'] = 14;
		$arr['216']['v1'] = 10; $arr['216']['v2'] = 15;
		$arr['217']['v1'] = 10; $arr['217']['v2'] = 16;
		$arr['218']['v1'] = 10; $arr['218']['v2'] = 17;
		$arr['219']['v1'] = 10; $arr['219']['v2'] = 18;
		$arr['220']['v1'] = 10; $arr['220']['v2'] = 19;
		$arr['221']['v1'] = 10; $arr['221']['v2'] = 20;
		$arr['222']['v1'] = 10; $arr['222']['v2'] = 22;
		$arr['301']['v1'] = 14; $arr['301']['v2'] = 1;
		$arr['302']['v1'] = 14; $arr['302']['v2'] = 2;
		$arr['303']['v1'] = 14; $arr['303']['v2'] = 3;
		$arr['304']['v1'] = 14; $arr['304']['v2'] = 4;
		$arr['401']['v1'] = 15; $arr['4xx']['v2'] = 1;
		$arr['402']['v1'] = 15; $arr['4xx']['v2'] = 2;
		$arr['403']['v1'] = 15; $arr['4xx']['v2'] = 3;
		$arr['404']['v1'] = 15; $arr['4xx']['v2'] = 4;
		$arr['405']['v1'] = 15; $arr['4xx']['v2'] = 5;
		$arr['406']['v1'] = 15; $arr['4xx']['v2'] = 6;
		$arr['407']['v1'] = 15; $arr['4xx']['v2'] = 7;
		$this->arr = $arr;
		*/

	/*		
		$return['fields']['patientnumber']['link'] = 'Ziekenhuisnummer';
		$return['fields']['birthdate']['link'] = 'Geboortedatum';
		$return['fields']['last_name']['link'] = 'EigenNaam';
		$return['fields']['last_name_partner']['link'] = '	MansNaam';
		$return['fields']['center_id']['value'] = '1';
		$return['fields']['gender']['link'] = 'Geslacht';
		$return['fields']['gender']['options']['convert']['1'] = 'male';
		$return['fields']['gender']['options']['convert']['2'] = 'male';
		$return['fields']['date_added']['value'] = date('Y-m-d');
		$return['fields']['added_by_user_id']['value'] = 113;
		
	$return['fields']['name']['link'][0] = 'voornaam';
		$return['fields']['name']['link'][1] = 'tussenvoegsel';
		$return['fields']['name']['link'][2] = 'achternaam';
		$return['fields']['name']['options']['seperator'] = ' ';
		$return['fields']['username']['link'] = 'e_mailadres';
		$return['fields']['email']['link'] = 'e_mailadres';
		
		$return['fields']['type']['value'] = 'patient';
		$return['fields']['password']['value'] = sha1('test123');
		$return['fields']['Wrong_password_count']['value'] = '0';
		$return['fields']['Must_change_password']['value'] = 'no';
		$return['fields']['status']['value'] = 'active'; */
		
		return $return;
	}
	
}	
?>