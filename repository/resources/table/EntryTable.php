<?php
class EntryTable extends WE_Db_Table
{
	protected $table 		= 'entry';
	protected $primary 		= array('id');

	/**
	 * @todo  override mostVotes and leastVotes to display votes from vote table
	 */
	
	// public function mostVotes($from,$to) {
	// 	$sql = "SELECT `entry`.*
	// 			FROM `entry`
	// 			WHERE `status` = :status
	// 			AND `published` = :published
	// 			ORDER BY `total_vote_count` DESC
	// 			LIMIT $from, $to";
	// 	$values = array('status'=>1,'published'=>'1');
	// 	return $this->setResultset($sql,$values);
	// }

	public function mostVotes($from,$to)
	{
		//if(!is_int($from) || !is_int($to))
		//	throw new Exception("Limit mag alleen numeriek zijn");

		$sql = 'SELECT e.*, count(v.id) as total_vote_count FROM entry e 
				LEFT JOIN vote v on v.entry = e.id AND v.verified = :verified
				WHERE e.status = :status
				AND e.published = :published
				GROUP BY e.id
				ORDER BY total_vote_count DESC
				LIMIT '.$from.','.$to;

		$values = array('status' => 1, 'published' => 1,'verified' =>1);
		return $this->setResultset($sql,$values);
	}
	
	// public function leastVotes($from,$to) {
	// 	$sql = "SELECT `entry`.*
	// 			FROM `entry`
	// 			WHERE `status` = :status
	// 			AND `published` = :published
	// 			ORDER BY `total_vote_count` ASC
	// 			LIMIT $from, $to";
	// 	$values = array('status'=>1,'published'=>'1');
	// 	return $this->setResultset($sql,$values);
	// }
	// 
	
	public function leastVotes($from,$to)
	{
		//if(!is_int($from) || !is_int($to))
		//	throw new Exception("Limit mag alleen numeriek zijn");

		$sql = 'SELECT e.*, count(v.id) as total_vote_count FROM entry e 
				LEFT JOIN vote v on v.entry = e.id AND v.verified = :verified
				WHERE e.status = :status
				AND e.published = :published
				GROUP BY e.id
				ORDER BY total_vote_count ASC
				LIMIT '.$from.','.$to;

		$values = array('status' => 1, 'published' => 1,'verified' =>1);
		return $this->setResultset($sql,$values);
	}
	
}
?>