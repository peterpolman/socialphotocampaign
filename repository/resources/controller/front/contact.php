<?php 

class contactController extends WE_Controller_Crud
{
	protected $public = true;
	
	// WARNING: THIS CONTROLLER IS PUBLIC!
	// Security is explicitly enforced in the actions
	
	public function	indexAction () {
		if ( $this->getRequest()->isPost() ) {
			$voornaam = $this->getRequest()->getPost('firstname');
			$achternaam = $this->getRequest()->getPost('lastname');
			$email = $this->getRequest()->getPost('email');
			$bericht = $this->getRequest()->getPost('message');
			
			// Is the input complete?
			if ( !$voornaam || !$achternaam || !$email || !$bericht ) {
				WE_Engine_Session::setFlash('Alle velden zijn verplichte invoer', 'error');
				$this->view->assign('firstname',$voornaam);
				$this->view->assign('lastname',$achternaam);
				$this->view->assign('email',$email);
				$this->view->assign('message',$bericht);
				return $this->view->render();
			}
			
			// It is, send mail
			WE::include_adapter('WE_Mail');
			$mail = new WE_Mail();
			$mail->setFrom(Config::get('contact','mailfrom'));
			$mail->setTo(Config::get('contact','mailto'));
			$mail->setSubject(Config::get('contact','subject'));
			$mail->setTemplate($this->getRequest()->getSystemKey().'/contact/mail.tpl');
			$mail->view->assign('voornaam',$voornaam);
			$mail->view->assign('achternaam',$achternaam);
			$mail->view->assign('email',$email);
			$mail->view->assign('bericht',$bericht);
			$mail->send();
			
			// Thank user
			return $this->view->render($this->getRequest()->getSystemKey().'/contact/bedankt.tpl');
		}
		return $this->view->render();
	}
	
}
?>