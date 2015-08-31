<?php
class beheerHeader extends WE_Controller
{
	public function	header()
	{
		$Auth = new WE_Auth();
		if ($Auth->isLoggedIn())
			return $this->view->render($this->getRequest()->getSystemKey().'/layout/header.tpl');
		else
			$this->redirect('system/login');
	}
}
?>