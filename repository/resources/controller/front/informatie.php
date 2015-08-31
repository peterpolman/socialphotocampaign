<?php 

class informatieController extends WE_Controller_Crud
{
	protected $public = true;
	
	// WARNING: THIS CONTROLLER IS PUBLIC!
	// Security is explicitly enforced in the actions
	
	public function	indexAction () {
		/* hacks van peter */
		// MW 2013-12-12: dit is dubbelop, wordt over 3 regels weer overschreven.
		$from = $this->getRequest()->getGet('id2',0);
		$to = $this->getRequest()->getGet('id3',5);
		$topEntries = Db::getTable('Entry')->mostVotes($from,$to);
		details($topEntries);

		$topVotes = array();
		foreach ( $topEntries->getResult() as $entry ) {
			$topVotes[$entry->getId()] = Db::getTable('Vote')->findColumnData(array('entry'=>$entry->getId(),'verified'=>1))->count();	// Here is some room for speed improvement if needed :)
		}
		$this->view->assign('topEntries',$topEntries);
		$this->view->assign('topVotes',$topVotes);

		/*end hacks van peter*/	

		return $this->view->render();
	}
	
}
?>