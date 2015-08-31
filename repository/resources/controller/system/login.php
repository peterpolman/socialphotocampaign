<?php
class loginController extends WE_Controller_Crud
{
	protected $public = true;
	
	/**
	 * Log user in
	 */
	public function	indexAction ()
	{
		$request = $this->getRequest();
		
		// Are we logged in already?

		$userSession = WE_Engine_Session::getNamespace('Auth');
		if (isset($userSession->user_id)) 
		{
			$this->redirect("");
		}

		// Are we logging in?
		elseif ($request->isPost())
		{
			$Auth = new WE_Auth();
			$output = $Auth->login($request->getPost('username'),md5($request->getPost('password')));
			
			if ( !is_object($output) ) {
				if ( $output == "Double login required" ) {
					$doublelogin = WE_Engine_Session::getNamespace('doublelogin');
					$doublelogin->user = $request->getPost('username');
					$doublelogin->pass = $request->getPost('password');
					$this->redirect('system/login/double');
				}
				WE_Engine_Session::setFlash($output, 'error');
				$this->redirect("system/login");
			} else {
				$this->redirect("beheer");
			}
		}
		
		// Show login screen
		else
		{
			$this->view->assign('output',null);
			return $this->view->render();
		}
	}
	
	/**
	 * Require a double login
	 */
	public function doubleAction() {
		if ( $this->getRequest()->isPost() ) {
			$doublelogin = WE_Engine_Session::getNamespace('doublelogin');
			details($doublelogin->user);
			details($doublelogin->pass);
			
			// TEMP FIX:
			$doublelogin->user = $this->getRequest()->getPost('username1');
			$doublelogin->pass = $this->getRequest()->getPost('password1');
			
			$Auth = new WE_Auth();
			$output = $Auth->doubleLogin($doublelogin->user,$doublelogin->pass,$this->getRequest()->getPost('username2'),$this->getRequest()->getPost('password2'));
			if ( !is_object($output) ) {
				WE_Engine_Session::setFlash($output, 'error');
				$this->view->assign('output',null);
				return $this->view->render();
			} else {
				// TODO: Set user as logged in..?
				/*Tih_Session::getInstance()->setUser($output);
				$center = Db::getModel('Tih_centers')->getDefaultCenterByUserId($output->getId());
				Tih_Session::getInstance()->setCenter($center);*/
				$this->redirect($request->getSystemKey());
			}
		} else {
			// TODO: Do IP check here
			WE_Engine_Session::setFlash("Administrator login succesvol", 'success');
			return $this->view->render();
		}
	}
	
	/**
	 * Create hash for password recovery
	 */
	private function createHash() {
		$salt = '3v{e%W)+:j>S.Vn;S_=<fVQrDr3QffW>';
		return sha1($salt.mt_rand(838724, 183618947));
	}
	
	/**
	 * Allow user to recover password
	 * @param WE_Controller_Request $request
	 * @throws WE_Db_Record_NoRecordFoundException
	 */
	public function lostpasswordAction (WE_Controller_Request $request)
	{
		$db = Db::getInstance();
		
		if ($request->isPost())
		{
			try	{
				$user 	= $db->getModel('Wame_core_user')->findColumn('`username` = :username','','',array('username'=>$request->getPost('username')));
				if (empty($user)) {
					sleep(1);
					WE::include_library('Db/Record/NoRecordFoundException');
					throw new WE_Db_Record_NoRecordFoundException();
				}
				$pwt 	= $db->getModel('Wame_core_passwordtoken')->findColumnData(array('user_id'=>$user->getId()));
				//$ud 	= $db->getModel('Userdata')->find($user->getId());

				$hash = $this->createHash();
				$exp = 60*60*24*7;
				$bye = date("Y-m-d H:i:s",(time()+$exp));
				
				if ($pwt == false)
				{
					$pwt = $db->getModel('Wame_core_passwordtoken');
					$pwt->setUser_id($user->getId());
				}

				$pwt->setHash($hash);
				$pwt->setExpire($bye);
				$pwt->save();
				
				/* START send mail part */
				$engine = WE::getInstance();
				$engine->include_adapter('WE_Mail');
				
				$mail = WE_Mail::getInstance();
				$inviteDir = Config::get('install', 'secure_root').$this->getRequest()->getSystemKey()."/login/invite";
				
				$mail->view->assign('inviteDir',$inviteDir);
				$mail->view->assign('userId',$user->getId());
				$mail->view->assign('hash',$hash);
				$mail->setTemplate($this->getRequest()->getSystemKey().'/mail/sendhash.tpl');
				$mail->setTo($user->getUsername());
				$mail->setSubject('Aanvraag nieuw wachtwoord');
				
				if ($mail->send()) {
					WE_Engine_Session::setFlash("Uw aanvraag voor een nieuw wachtwoord is ingediend", "success");
					$this->redirect($this->getRequest()->getSystemKey()."/login");
				}
				else {
					WE_Engine_Session::setFlash("Het verzenden van de mail is mislukt", "error");
					$this->redirect($this->getRequest()->getSystemKey()."/login");
				}
				/* END send mail part */	
			} 
			catch (WE_Db_Record_NoRecordFoundException $e)
			{
				sleep(1);
				$output = "Gebruikersnaam '".$request->getPost('username')."' is niet bekend in het systeem!";
				WE_Engine_Session::setFlash($output, 'error');
				$this->redirect($this->getRequest()->getSystemKey()."/login/lostpassword");
				//return $this->view->render($this->getRequest()->getSystemKey().'/login/lostpassword.tpl');
			}
		}
		else
		{
			return $this->view->render($this->getRequest()->getSystemKey().'/login/lostpassword.tpl');
		}
	}
	
	/**
	 * Log user out
	 * @param WE_Controller_Request $request
	 */
	public function	logoutAction (WE_Controller_Request $request)
	{
		$Auth = new WE_Auth();
		$Auth->logout();
		$this->redirect('');
	}
	
	/**
	 * Internally used function for getting the invite for new pass request
	 * @param unknown_type $id
	 * @param unknown_type $hash
	 */
	protected function getInviteAccess($id,$hash)
	{
		$data = array('user_id'=>$id,'hash'=>$hash);
		$invite = Db::getInstance()->getModel('Wame_core_passwordtoken')->findColumnData($data);

		if (empty($invite))
		{
			return false;
		}
		else
		{
			if (strtotime($invite->getExpire()) > time())
			{
				return $invite;
			}
			else
			{
				$invite->delete();
				return false;
			}
		}
	}
	
	/**
	 * Generate password
	 */
	private function easyPassword($length)
	{
		if( $length & 1 )
		{
			$length++;
		}
		
		$conso=		array("b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
		$vocal=		array("a","e","i","o","u");
		$numbers = 	array(0,1,2,3,4,5,6,7,8,9);
		
		$password="";
		
		srand ((double)microtime()*1000000);
		$max = $length/2;
		for($i=1; $i<=$max; $i++)
		{
			if (rand(0,1) == 1)
			{
				$password.=strtoupper($conso[rand(0,19)]);
			}
			else
			{
				$password.=$conso[rand(0,19)];
			}
			if (rand(0,1) == 1)
			{
				$password.=strtoupper($vocal[rand(0,4)]);
			}
			else
			{
				$password.=$vocal[rand(0,4)];
			}
		}
		$password .= rand(10,99);
		
		return $password;
	}
	
	public function inviteAction (WE_Controller_Request $request)
	{
		$invite = $this->getInviteAccess($request->getGet('id'),$request->getGet('id2'));
		if ($invite == false)
		{
			//WCMS3_Log::getInstance()->store("FOUT", "Password attempt: (".$request->getGet('id').")");
			return $this->view->render($this->getRequest()->getSystemKey().'/login/invfalse.tpl');
		} else {
			$uid 		= $invite->getUser_id();
			$user 		= Db::getInstance()->getModel('Wame_core_user')->findColumn('`id` = :uid','','',array('uid'=>$uid));
			//$ud		 	= Db::getInstance()->getModel('Userdata')->find($uid);

			$p1 = $this->easyPassword(8);
			$md5p = md5($p1);
			$user->setPassword($md5p);
			$user->save();
			$invite->delete();
			
			/* START send mail part */
			$engine = WE::getInstance();
			$engine->include_adapter('WE_Mail');
			
			$mail = WE_Mail::getInstance();
			
			$mail->view->assign('username',$user->getUsername());
			$mail->view->assign('password',$p1);
			$mail->setTemplate($this->getRequest()->getSystemKey().'/mail/sendpass.tpl');
			$mail->setTo($user->getUsername());
			$mail->setSubject('Nieuw wachtwoord');
			
			if ($mail->send()) {
				return $this->view->render($this->getRequest()->getSystemKey().'/login/invite.tpl');
			}
			else {
				WE_Engine_Session::setFlash("Het verzenden van de mail is mislukt", "error");
				$this->redirect($this->getRequest()->getSystemKey()."/login");
			}
			/* END send mail part */
		}
	}
}	
?>