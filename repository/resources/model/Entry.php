<?php
WE::include_model('db/Entry');
class Entry extends Entry_db {
	
	public function getVotes($id)
	{
		$votes =  Db::getTable('Vote')->findColumnData(array('entry'=>$id,'verified'=>1))->count();
		return $votes;
	}
}
?>