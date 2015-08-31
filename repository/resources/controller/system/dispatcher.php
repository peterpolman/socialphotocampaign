<?php
class systemHeader extends WE_Controller
{
	public function	header ()
	{
		$request = $this->getRequest(); /* @var $request WE_Controller_Request */
		if ($request->getControllerKey() == 'login') {
			return $this->view->render($this->getRequest()->getSystemKey().'/layout/header-login.tpl');
		} else {
			return $this->view->render($this->getRequest()->getSystemKey().'/layout/header.tpl');
		}
	}
}
?>