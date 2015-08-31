<?php
class VoteTable extends WE_Db_Table
{
	protected $table 		= 'vote';
	protected $primary 		= array('id');

	/**
	 * Returns true if user email/ip has not yet voted+verified on given entry
	 * 
	 * @param int $entryId
	 * @param string $email
	 * @param string|null $ip If set also check for user IP
	 * @return boolean
	 */
	public function allowedToVote($entryId, $email, $ip = null)
	{
		// WE_Db_Table::findColumnData does not support OR condition, so use custom query + setResultSet
		$sql = "SELECT `id` FROM `{$this->table}` WHERE `entry` = :entryId AND `verified` = :verified ";
		$queryParams = array(
			'entryId' => $entryId,
			'verified' => true,
			'email' => $email,
		);
		if ($ip !== null) {
			$queryParams['ip'] = $ip;
			$sql .= " AND (`email` = :email OR `ip` = :ip)";
		} else {
			$sql .= " AND `email` = :email";
		}
		
		$result = $this->setResultSet($sql, $queryParams);

		return ($result->count() == 0); 
	}
}
?>