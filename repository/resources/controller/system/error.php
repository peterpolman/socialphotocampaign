<?php
class errorController extends WE_Controller
{
	protected $public = true;
	
	public function pageNotFoundAction (WE_Controller_Request $request)
	{
		return $this->view->render('system/error/404.tpl');	
	}
	
	public function systemNotFoundAction (WE_Controller_Request $request)
	{
		return $this->view->render('system/error/404.tpl');
	}
	
	public function pageNotAllowedAction (WE_Controller_Request $request)
	{
		return $this->view->render('system/error/404.tpl');	
	}
	
}
?>