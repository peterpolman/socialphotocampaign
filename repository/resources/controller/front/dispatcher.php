<?php 

class frontHeader extends WE_Controller
{
	public function	header () {
		$controller = $this->getRequest()->getControllerKey();
		$action = $this->getRequest()->getActionKey();
		if ($controller == 'keukens' && $action == 'opknapper' ) {
			$entry = Db::getModel('Entry')->find($this->getRequest()->getGet('id'));
		
			if ( !is_object($entry) || $entry->getStatus() != 1 ) {
				$this->redirect('');
			}
			$this->view->assign('entry',$entry);
		}
		
		$this->view->assign('controller',$controller);
		$this->view->assign('action',$action);
		return $this->view->render($this->getRequest()->getSystemKey().'/layout/header.tpl');
	}
	
}

?>