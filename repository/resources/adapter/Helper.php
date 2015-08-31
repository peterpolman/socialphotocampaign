<?php
 class Helper {
 	
 	/**
 	 * Instance of Helper
 	 */
 	private static $_instance;
 	
 	/**
 	 * Enforce singleton; disallow cloning
 	 *
 	 * @return void
 	 */
 	public function __clone()
 	{
 	}
 	
 	/**
 	 * Enforce singleton; disallow cloning
 	 *
 	 * @return Helper
 	 */
 	public static function getInstance()
 	{
 		if (null === self::$_instance) {
 			self::$_instance = new self();
 		}
 	
 		return self::$_instance;
 	}
 	
 	/**
 	 * Db assister. Convert all the int values to alpha values.
 	 * 
 	 * @param string $string
 	 * @return string
 	 */
 	
 	public static function intToAlpha($string) {
 		$ints = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
 		$alphas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J");
 		
 		return str_replace($ints, $alphas, $string);
 	}
 	
	/**
	 * Tries to parse date string into unix timestamp
	 * Can handle all strings that can be handled by strtotime()
	 * Plus dates without hyphens and dates without year
	 */
	public static function date2timestamp($string,$database = false,$dateonly = false) {
		if (!empty($string) && $string !== '0' && $string !==0)
		{
			$parts = explode('-',$string);
			if (count($parts)==3) {
				// full date
				$time = strtotime($string);
				if ($time === false) {
					return false;
				}
	
				if ($database == false) {
					return $time;
				} else {
					if ($dateonly == true) {
						return date('Y-m-d',$time);
					} else {
						return date('Y-m-d H:i:s',$time);
					}
				}
			} elseif (count($parts)==2) {
				// add year
				$time = strtotime($string.'-'.date('Y'));
				if ($time === false) {
					return false;
				}
					
				if ($database == false) {
					return $time;
				} else {
					if ($dateonly == true) {
						return date('Y-m-d',$time);
					} else {
						return date('Y-m-d H:i:s',$time);
					}
				}
			} else {
				// no hyphens
				if (is_numeric($string)) {
					if (strlen($string)==4) {
						return strtotime(date('Y').'-'.substr($string,2,2).'-'.substr($string,0,2));
					} elseif (strlen($string)==6) {
						return strtotime('20'.substr($string,4,2).'-'.substr($string,2,2).'-'.substr($string,0,2));
					} elseif (strlen($string)==8) {
						return strtotime(substr($string,4,4).'-'.substr($string,2,2).'-'.substr($string,0,2));
					}
				} else { //Must be a string representing time (e.g. + 15 DAYS, next monday, now, ect)
					$time = strtotime($string);
					if ($time === false) {
						return false;
					}
						
					if ($database == false) {
						return $time;
					} else {
						if ($dateonly == true) {
							return date('Y-m-d',$time);
						} else {
							return date('Y-m-d H:i:s',$time);
						}
					}
				}
			}
		}
		if ($database == false) {
			return false;
		} else {
			return null;
		}
	}
	
	/**
	 * @param string $date (yyyy-mm-dd)
	 * @return string nicely formatted date
	 */
	public static function format_date($date) {
		if (empty($date) || ($date=='0000-00-00')) {
			return '';
		}
		return date('d-m-Y',strtotime($date));
	}
	
	/**
	 * @param string $date (yyyy-mm-dd hh:mm:ss)
	 * @return string nicely formatted date and time
	 */
	public static function format_datetime($datetime) {
		if (empty($datetime)) {
			return '';
		}
		return Roma::format_date($datetime).substr($datetime,10,6);
	}
	
	/* Reversible AES 256 encryption
	 * 
	 * 
	 */
	
	public static function encrypt($string,$key = null) {
		// Encryption Algorithm

		if ($key == null) {
			$key = Tih_Session::getSessionId();
		}
		
		$iv = Tih_Session::getInstance()->getCryptKey();
		return bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv));
	}
	
	
	/* Reversible AES 256 encryption
	 * 
	 * 
	 */
	public static function decrypt($encrypted_string,$key = null) {
		
		if ($key == null) {
			$key = Tih_Session::getSessionId();
		}
		//$encrypted_string = hex2bin($encrypted_string); 		// >= 	PHP 5.4
		$encrypted_string = self::hextobin($encrypted_string);		// < 	PHP 5.4

		$iv = Tih_Session::getInstance()->getCryptKey();
		return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encrypted_string, MCRYPT_MODE_CBC, $iv);
	}
	
	private static function hextobin($hexstr)
    {
        $n = strlen($hexstr);
        $sbin="";  
        $i=0;
        while($i<$n)
        {      
            $a =substr($hexstr,$i,2);          
            $c = pack("H*",$a);
            if ($i==0){$sbin=$c;}
            else {$sbin.=$c;}
            $i+=2;
        }
        return $sbin;
    }
}
?>