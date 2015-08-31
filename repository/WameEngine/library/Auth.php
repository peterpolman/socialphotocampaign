<?php
define("MAX_LOGIN_ATTEMPTS", Config::get('auth','maxloginattempts'));

//require_once 'WCMS3/Auth/Exception.php';

class WE_Auth
{
    /**
     * Checks of the user is logged in.
	 *
     * @return boolean true|false
     */
	public static function isLoggedIn()
	{
		$userSession = WE_Engine_Session::getNamespace('Auth');

		if (isset($userSession->user_id) && !empty($userSession->user_id)) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * Attempts to log in the user
	 *
     * @param string $password
     * @param string $username
     * @return boolean true|false
     * @return header
     */
	public function login($username, $password)
	{
		$myuser = $this->logOneIn($username,$password);
		
		if ( is_object($myuser) ) {
			$role = Db::getTable('Wame_core_userrole')->findColumnData(array('user'=>$myuser->getId()));
			// Double login disabled for now
			/*foreach ( $role->getResult() as $role ) {
				if ( $role->getRole(true)->getRole() == "Systemadmin (Wame)" )
					return "Double login required";
			}*/
			
			// We're logged in! Store us in session
			
			$userSession = WE_Engine_Session::getNamespace('Auth');
			$userSession->username = $username;
			$userSession->user_id = $myuser->getId();
			
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
			
			WE_Log::getInstance()->store("Succes", "Gebruiker '$username' is ingelogd. | Gegevens: IP: $ip, USER_AGENT: $user_agent");
		}
		
		return $myuser;
	}
	
	private function logOneIn($username,$password) {
		$output = "";
		$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		$now = date("Y-m-d H:i:s");

		$db = Db::getInstance();
		try {

			$login_attempts = $db->getModel(Config::get('install','loginsdb'))->findColumnData(array('ip'=>$ip));

			//kijken of ip al in db staat
			if ($login_attempts) {
				$last_attempt = $login_attempts->getLast_failed_login_attempt();
				$attempts_left = MAX_LOGIN_ATTEMPTS - $login_attempts->getFailed_login_attempts() - 1;
			} else {
				$attempts_left = MAX_LOGIN_ATTEMPTS - 1;
			}

			// login attempts niet overschreven of meer dan een uur geleden
			if(empty($login_attempts) || ($login_attempts->getFailed_login_attempts() < MAX_LOGIN_ATTEMPTS  ||
			date("Y-m-d H:i:s", strtotime($last_attempt."+1 hour")) < $now)) {

				$sArray = array('username'=>$username, 'password'=>$password, 'deleted'=>0);
				$user = $db->getModel(Config::get('install','userdb'))->findColumnData($sArray);
					
				if ($user == null) {
						
					WE_Log::getInstance()->store("Fail", "Geen gebruiker '$username' in de database.");
					details("Geen gebruiker '$username' in de database of ongeldig wachtwoord.");

					$aLoginAttempts = $db->getModel(Config::get('install','loginsdb'))->findColumnData(array('ip'=>$ip));
					// nieuw ip: set attempts = 1
					if (empty($aLoginAttempts)) {
						$LoginAttempts = $db->getInstance()->getModel(Config::get('install','loginsdb'));
						$LoginAttempts->setIp($ip);
						$LoginAttempts->setFailed_login_attempts(1);
						$LoginAttempts->setLast_failed_login_attempt($now);
						$LoginAttempts->save();
						$attempts_left = MAX_LOGIN_ATTEMPTS - 1;
						// bestaand ip en 1 uur is voorbij: set attempts = 1
					} else if (date("Y-m-d H:i:s", strtotime($last_attempt."+1 hour")) < $now) {
						$aLoginAttempts->setFailed_login_attempts(1);
						$aLoginAttempts->setLast_failed_login_attempt($now);
						$aLoginAttempts->save();
						$attempts_left = MAX_LOGIN_ATTEMPTS - 1;
						// bestaand ip: set attempts++
					} else {
						$failed_attempts = $aLoginAttempts->getFailed_login_attempts() + 1;
						$aLoginAttempts->setFailed_login_attempts($failed_attempts);
						$aLoginAttempts->setLast_failed_login_attempt($now);
						$aLoginAttempts->save();
						$attempts_left = MAX_LOGIN_ATTEMPTS - $failed_attempts;
					}
						
					$output = "Login gegevens incorrect. U heeft nog ".$attempts_left." pogingen over";

					if (isset($failed_attempts) && $failed_attempts >= MAX_LOGIN_ATTEMPTS) {
						$output = "U heeft ".$aLoginAttempts->getFailed_login_attempts()." keer geprobeerd in te loggen. U bent voor 1 uur geblokeerd";
						WE_Log::getInstance()->store("Fail", "Gebruiker met ip adres $ip heeft $failed_attempts keer geprobeerd in te loggen.");
					}
				} else {
					//login_attempts reset
					if (!empty($login_attempts)) {
						$login_attempts->delete();
					}

					return $user;
				}
			} else {
				WE_Log::getInstance()->store("Fail", "Gebruiker met ip $ip is voor een uur geblokeerd.");
				details("Gebruiker met ip $ip is voor een uur geblokeerd.");
				/*
				//mail admin
				require_once('WCMS3/Modules/Mail.php');
				$mail = new WCMS3_Mail();
				$mail->setTo(WCMS3_Config::get('mail','mailerrorsto'));
				$mail->setSubject('FAIL: Max_login_attempts overschreven');
				$mail->setTemplate('mailerror.tpl');
				$mail->view->assign('message',"Gebruiker heeft ".$login_attempts->getFailed_login_attempts()." keer geprobeerd in te loggen. ");
				$mail->view->assign('error',"Datum: ".$now."<br>IP: ".$ip);
				$mail->send();
				unset($mail);	*/			
				
				$output = "U heeft ".$login_attempts->getFailed_login_attempts()." keer geprobeerd in te loggen. U bent voor 1 uur geblokeerd";
			}
		} catch (WE_Db_Record_NoRecordFoundException $e) {
			WE_Log::getInstance()->store("Fail", "Geen gebruiker '$username' in de database.");
			details("Geen gebruiker '$username' in de database.");
		}
		details("Done");
		return $output;
	}
	
	/**
	 * Do a double login with two admins.
	 * 
	 * @param string $user1
	 * @param string $pass1
	 * @param string $user2
	 * @param string $pass2
	 * @author Tim
	 */
	public function doubleLogin($user1,$pass1,$user2,$pass2) {
		
	}
	
    /**
     * Logs out the user
	 *
     * @return void
     */
	public function logout()
	{
		$userSession = WE_Engine_Session::getNamespace('Auth');
		$username = $userSession->username;
		details("Gebruiker '$username' is uitgelogd.");
		WE_Log::getInstance()->store("Succes", "Gebruiker '$username' is uitgelogd.");
		WE_Engine_Session::unsetNamespace('Auth');
	}
}

?>