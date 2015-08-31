<?php

/**
 * Send mailings to all participants
 */
class MailingController extends WE_Controller_Crud
{
	
	public function	indexAction () {
		if ( $this->getRequest()->isPost() ) {
			// Welke entry is de winnaar?
			$entry = $this->getRequest()->getPost('winnaar');
			if ( !is_numeric($entry) ) {
				WE_Engine_Session::setFlash('Geen geldige winnaar geselecteerd', 'error');
				$this->redirect('beheer/mailing');
			}
			$entry = Db::getModel('Entry')->find($entry);
			
			if ( $this->getRequest()->getPost('bevestig') ) {
				// Stuur de mails, bereid mailer voor
				WE::include_adapter('WE_Mail');
				$mail = WE_Mail::getInstance();
				$mail->setTemplate('beheer/mailing/mail.tpl');
				$mail->assignToTemplate(array(
					array(	'key'=>'entry',
							'value'=>$entry
					),
					array(	'key'=>'text',
							'value'=>$this->getRequest()->getPost('text')
					)
				));
				$mail->setFrom('noreply@ikook.nl');
				$mail->setFromName('IKOOK');
				$mail->setSubject('IKOOK opknappertje uitslag');
				
				foreach ( Db::getTable('Entry')->findColumnData(array('status'=>1,'published'=>'1'))->getResult() as $inzender ) {
					if ( $mail->valid_email($inzender->getEmail()) ) {
						$mail->assignToTemplate(array(array('key'=>'ontvanger','value'=>$inzender)));
						$mail->setTo($inzender->getEmail());
						$mail->send();
					}
				}
				
				WE_Engine_Session::setFlash('Mailing is verstuurd!', 'success');
				$this->redirect('beheer/mailing');
			} else {
				// Vraag bevestiging
				$this->view->assign('entry',$entry);
				$this->view->assign('text',$this->getRequest()->getPost('text'));
				$mail = $this->view->render('beheer/mailing/mail.tpl');
				$this->view->assign('mail',$mail);
				return $this->view->render('beheer/mailing/zekerweten.tpl');
			}
		} else {
			// Geef initiële inputscherm
			$entries = Db::getTable('Entry')->findColumnData(
				array('status'=>'1','published'=>'1'),
				array(WE_Record::ORDER_DESC_BY_COLUMN => 'date')
			);
			$votes = array();
			foreach ( $entries->getResult() as $entry ) {
				$votes[$entry->getId()] = Db::getTable('Vote')->findColumnData(array('entry'=>$entry->getId()))->count();	// Here is some room for speed improvement if needed :)
			}
			arsort($votes);
			$this->view->assign('entries',$entries->getResultArray(true));
			$this->view->assign('votes',$votes);
			return $this->view->render();
		}
	}
	
}

?>