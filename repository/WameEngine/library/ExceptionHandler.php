<?php
class WE_ExceptionHandler
{

    /**
     * Santize an exception wich prevents shortening of valuable arguments
     *
     * @param Exception $e
     * @return string
     */
	public static function sanitizeException($e) {
		return $e;
		$fullexception = explode("\n", $e->__toString());
		$exceptionlist = $e->getTrace();
		foreach($exceptionlist as $line=>$ed) {
			$replace = true;
			$aList = array();
			foreach($ed['args'] as $ak=>$arg) {
				if (!is_object($arg)) {
					$ed['args'][$ak] = "'".str_replace($_SERVER['DOCUMENT_ROOT'], '',$arg)."'";
				} else {
					$replace = false;
				}
			}
			
			if ($replace == true) {
				$return = '#'.$line.' ';
				$return .= str_replace($_SERVER['DOCUMENT_ROOT'], '', $ed['file']);
				$return .= '('.$ed['line'].'): ';
				$return .= $ed['class'].$ed['type'].$ed['function'];
				$return .= '(';
				$return .= implode(', ',$ed['args']);
				$return .= ')';
				$fullexception[$line+2] = $return;
			} else {
				$fullexception[$line+2] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $fullexception[$line+2]);
			}
		}
	
		$returnException = array();
		$returnException[0] = 'WF: '.str_replace($_SERVER['DOCUMENT_ROOT'], '',$fullexception[0]);
		$returnException[1] = 'Stack trace root: '.str_replace($_SERVER['DOCUMENT_ROOT'], '', $e->getFile()).':'.$e->getLine();
		
		for ($i=count($fullexception)-1;$i>1;$i--) {
			$returnException[$i+1] = $fullexception[$i];
		}
		
		/*$max = 0;
		foreach($returnException as $line) {
			if (strlen($line) > $max) { $max = strlen($line); }
		}*/
		
		$max = strlen($returnException[0]);
		
		$returnException[2] = '';
		for($i=0;$i<$max;$i++) {
			$returnException[2] .= '=';
		}
		
		ksort($returnException);
		return  implode("\n",$returnException);
	}
	
	public static function showReport($e,$debug = false)
	{
		if (isset($e))
		{
			$fullexception = self::sanitizeException($e);
			WE_error_handler('E_EXCEPTION', $fullexception, $e->getFile(), $e->getLine());

			WE::include_library('View');
			if (Config::get('install','debug') == false)
			{
				$db = Db::getInstance();
				$Exception 		= Db::getInstance()->getModel('ExceptionModel');
				$ExceptionTable = Db::getInstance()->getModel('ExceptionModelTable');
				$ExceptionTable->purgeErrors();
				$exists = $ExceptionTable->findSameMainError($e->getFile().";".$e->getLine());
				
				$Exception->setip($_SERVER['REMOTE_ADDR']);
				$Exception->setdate(date("Y-m-d H:i:s"));
				$Exception->seterror_main($e->getFile().";".$e->getLine());
				$Exception->seterror_full($fullexception);
				$Exception->save();
				
				$safeIP = Config::get('security','mcaffeerange');
				$compareIP = substr($_SERVER['REMOTE_ADDR'],0,strlen($safeIP));
				
			}
		}
		
		if (Config::get('install','debug') == true) {
			$view = WE_View::getInstance();

			$view->assign('message',$e->getMessage());
			$view->assign('error',$fullexception);
			
			if (Config::get('install','debug') == true)	//Meer info
			{
				$view->display('system/exception/ExceptionHandler.tpl');
			}
			else
			{
				$view->display('system/exception/ExceptionFriendlyHandler.tpl');
			}
		}
		else
		{
			header("Location: ".Config::get('install','secure_root'), TRUE, 303);
			exit;
		}
	}
}
?>