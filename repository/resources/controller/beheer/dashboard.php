<?php
class dashboardController extends WE_Controller_Crud
{
	
	public function	indexAction (WE_Controller_Request $request)
	{
		return $this->view->render();
	}
	
}
?>