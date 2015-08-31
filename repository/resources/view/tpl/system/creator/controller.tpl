{literal}<?php

/**
 * Autogenerated CRUD controller
 * Template version March 12th 2013
 */
class {/literal}{$controllername}{literal}Controller extends WE_Controller_Crud
{
	
	public function	indexAction () {
		${/literal}{$meervoud}{literal} = Db::getTable('{/literal}{$controllername}{literal}')->getAll(true,false);
		$this->view->assign('{/literal}{$meervoud}{literal}',${/literal}{$meervoud}{literal});
		return $this->view->render();
	}
	
	public function	viewAction () {
		${/literal}{$enkelvoud}{literal}Id = $this->getRequest()->getGet('id');
		${/literal}{$enkelvoud}{literal} = Db::getModel('{/literal}{$controllername}{literal}')->find(${/literal}{$enkelvoud}{literal}Id);
		
		if ( !is_object(${/literal}{$enkelvoud}{literal}) ) {
			WE_Engine_Session::setFlash('De opgegeven {/literal}{$enkelvoudtext}{literal} bestaat niet.', 'error');
			$this->redirect($this->getRequest()->getSystemKey()."/{/literal}{$controllerfilename}{literal}");
		} else {
			$this->view->assign('{/literal}{$enkelvoud}{literal}',${/literal}{$enkelvoud}{literal});	
			return $this->view->render();
		}
	}

	public function	addAction () {
		if ($this->getRequest()->isPost()) {
			${/literal}{$enkelvoud}{literal} = Db::getModel('{/literal}{$controllername}{literal}');
			$postdata = $this->getRequest()->getPost('{/literal}{$enkelvoud}{literal}');
			{/literal}{foreach from=$fields key=myId item=i name=foo}{if $myId != 'id' && $myId != 'deleted'}{literal}
			${/literal}{$enkelvoud}{literal}->set{/literal}{$myId|ucfirst}($postdata['{$myId}']);{/if}{/foreach}{literal}
			${/literal}{$enkelvoud}{literal}->save();
			
			$id = ${/literal}{$enkelvoud}{literal}->getId();
			WE_Engine_Session::setFlash('De {/literal}{$enkelvoudtext}{literal} succesvol toegevoegd.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/{/literal}{$controllerfilename}{literal}/view/$id");
		} else {
			return $this->view->render();
		}
	}
	
	public function	modifyAction () {
		if ($this->getRequest()->isPost()) {
			${/literal}{$enkelvoud}{literal} = Db::getModel('{/literal}{$controllername}{literal}')->find($this->getRequest()->getGet('id'));
			$postdata = $this->getRequest()->getPost('{/literal}{$enkelvoud}{literal}');
			{/literal}{foreach from=$fields key=myId item=i name=foo}{if $myId != 'id' && $myId != 'deleted'}{literal}
			${/literal}{$enkelvoud}{literal}->set{/literal}{$myId|ucfirst}($postdata['{$myId}']);{/if}{/foreach}{literal}
			${/literal}{$enkelvoud}{literal}->save();
			
			WE_Engine_Session::setFlash('De {/literal}{$enkelvoudtext}{literal} succesvol bewerkt.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/{/literal}{$controllerfilename}{literal}/view/".${/literal}{$enkelvoud}{literal}->getId());
		} else {
			${/literal}{$enkelvoud}{literal} = Db::getModel('{/literal}{$controllername}{literal}')->find($this->getRequest()->getGet('id'));
			$this->view->assign('{/literal}{$enkelvoud}{literal}',${/literal}{$enkelvoud}{literal});
			return $this->view->render();
		}
	}
	
	public function	deleteAction () {
		${/literal}{$enkelvoud}{literal} = Db::getModel('{/literal}{$controllername}{literal}')->find($this->getRequest()->getGet('id'));
		if ( !is_object(${/literal}{$enkelvoud}{literal}) ) {
			WE_Engine_Session::setFlash('Er is geen {/literal}{$enkelvoudtext}{literal} gevonden met het betreffende Id', 'error');
			$this->redirect($this->getRequest()->getSystemKey()."/{/literal}{$controllerfilename}{literal}");
		} else {
			${/literal}{$enkelvoud}{literal}->delete();
			WE_Engine_Session::setFlash('De {/literal}{$enkelvoudtext}{literal} succesvol verwijderd.', 'success');
			$this->redirect($this->getRequest()->getSystemKey()."/{/literal}{$controllerfilename}{literal}");
		}
	}
	
}	
?>{/literal}