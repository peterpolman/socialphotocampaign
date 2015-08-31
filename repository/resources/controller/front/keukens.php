<?php

class keukensController extends WE_Controller_Crud
{
	protected $public = true;
	protected $entryId = null;

	// WARNING: THIS CONTROLLER IS PUBLIC!
	// Security is explicitly enforced in the actions

	/**
	 * Browse through entries
	 */
	public function cronAction() {

		$entries = Db::getTable('Entry')->getAll();

		foreach ( $entries->getResult() as $entry ) {

      // First visit the page before processing it.
      $ch = curl_init();
      $link = 'http://opknappertjenodig.nl/keukens/opknapper/' . $entry->getId();
      $url = 'https://developers.facebook.com/tools/debug/og/object?q=http%3A%2F%2Fwww.opknappertjenodig.nl%2Fkeukens%2Fopknapper%2F' . $link;

      // Set the URL.
      curl_setopt($ch, CURLOPT_URL, $url);
      // Do not return anything.
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // Timeout after 3 seconds.
      curl_setopt($ch, CURLOPT_TIMEOUT, '3');
      $result = trim(curl_exec($ch));

			//$topVotes[$entry->getId()] = Db::getTable('Vote')->findColumnData(array('entry'=>$entry->getId()))->count();	// Here is some room for speed improvement if needed :)
			//$old_url = "http://api.facebook.com/method/fql.query?query=select%20like_count%20from%20link_stat%20where%20url=\'http://www.opknappertjenodig.nl/keukens/opknapper/107\' ";
			//$access_token = 193048140809145;
			$fql_url = 'http://graph.facebook.com/fql?q=SELECT%20url,%20normalized_url,%20share_count,%20like_count,%20comment_count,%20total_count,%20commentsbox_count,%20comments_fbid,%20click_count%20FROM%20link_stat%20WHERE%20url=\'http://opknappertjenodig.nl/keukens/opknapper/'.$entry->getId().'\'' . $access_token;
			$fql_result = file_get_contents($fql_url);
			$fql_obj = json_decode($fql_result, true);

			if( array_key_exists('data',$fql_obj) ){
				/*if($fql_obj['data'][0]['comments_fbid'] == null ){
					$entry->setTotal_vote_count('0');
					$entry->save();
				} else {
					$entry->setTotal_vote_count($fql_obj['data'][0]['total_count']);
					$entry->save();
				}*/
				$entry->setTotal_vote_count($fql_obj['data'][0]['total_count']);
				$entry->save();
			}
		}
		return WE_View::NONE;
	}

	public function	indexAction () {
		// $entries = Db::getTable('Entry')->findColumnData(
		// 	array('status'=>'1','published'=>'1'),
		// 	array(WE_Record::ORDER_DESC_BY_COLUMN => 'date'),
		// 	30	// Limit 30 entries at first
		// );

		$entries = Db::getTable('Entry');
		$entries = $entries->mostVotes(0,30);

		$totalcount = Db::getTable('Entry')->findColumnData(array('status'=>1,'published'=>'1'))->count();	// Here is some room for speed improvement if needed :)
		$this->view->assign('entries',$entries);
		$this->view->assign('totalcount',$totalcount);
		return $this->view->render();
	}

	/**
	 * Do a query to the backend from Javascript to allow sorting and dynamically adding entries
	 * Usage: inzendingen/fetch/namedown/13/12  =>  order by name, descending, limit to second batch of 12
	 */
	public function fetchAction() {
		$orderBy = $this->getRequest()->getGet('id','datedown');
		$from = $this->getRequest()->getGet('id2',0);
		$to = $this->getRequest()->getGet('id3',30);
		$order = array();
		switch( $orderBy ) {
			case "votesdown":
				$entries = Db::getTable('Entry')->mostVotes($from,$to);
				break;
			case "votesup":
				$entries = Db::getTable('Entry')->leastVotes($from,$to);
				break;
			case "namedown":
				$order = array(WE_Record::ORDER_DESC_BY_COLUMN => array('first_name','last_name'));
				break;
			case "nameup":
				$order = array(WE_Record::ORDER_ASC_BY_COLUMN => array('first_name','last_name'));
				break;
			case "datedown":
				$order = array(WE_Record::ORDER_DESC_BY_COLUMN => 'date');
				break;
			case "dateup":
				$order = array(WE_Record::ORDER_ASC_BY_COLUMN => 'date');
				break;
		}
		if ( in_array($orderBy,array('namedown','nameup','datedown','dateup')) ) {
			$entries = Db::getTable('Entry')->findColumnData(
				array('status'=>'1','published'=>'1'),
				$order,
				array($from,$to)
			);
		}
		$this->view->assign('entries',$entries);
		echo $this->view->render();
		return WE_View::NONE;
	}

	/**
	 * Submit a new entry, step one: upload file and set description
	 */
	public function doemeeAction() {
		// IP check
		$existingEntries = Db::getTable('Entry')->findColumnData(array('ip'=>$_SERVER['REMOTE_ADDR'],'published'=>'1'));
		if ( !Config::get('install','debug') && $existingEntries->count() > 0 ) {
		//if ( $existingEntries->count() > 0 ) {
			$this->redirect('keukens/magniet');
		}

		if ( $this->getRequest()->isPost() ) {
			// Do we have a description?
			$description	= $this->getRequest()->getPost('description');
			if ( !$description ) {
				WE_Engine_Session::setFlash('Omschrijving is een verplicht veld', 'error');
				return $this->view->render();
			}

			// Handle file uploads
			$uploaddir = Config::get('install','file_upload_dir');
			if ( !array_key_exists('picture', $_FILES) || is_numeric( $file = $this->handleFileUploads($_FILES['picture'], $uploaddir) ) ) {
				if( isset($file) )
					WE_Engine_Session::setFlash(($file == -1)?"Ongeldig bestandstype":"Kon bestand niet opslaan", 'error');
				else
					WE_Engine_Session::setFlash('Bestand is een verplicht veld','error');
				$this->view->assign('description',$description);
				return $this->view->render();
			}

			// Create entry in database
			$entry = Db::getModel('Entry');
			$entry->setStatus(0);
			$entry->setFilename($file);
			$entry->setDescription($description);
			$entry->setIp($_SERVER['REMOTE_ADDR']);
			$entry->setDate(date(Config::get('install','datetimeformat')));
			$entry->setPublished(1);
			$entry->setTotal_vote_count(0);

			if ( $entry->save() ) {
				// Forward to step 2
				$this->redirect('keukens/stap2/'.$entry->getId());
			} else {
				WE_Engine_Session::setFlash('Kon inzending niet wegschrijven naar de database','error');
				return $this->view->render();
			}
		} else {
			return $this->view->render();
		}
	}

	/**
	 * Submit a new entry, step two: enter your information and agree to terms of service
	 */
	public function stap2Action() {
		$entry = Db::getModel('Entry')->find($this->getRequest()->getGet('id'));
		if ( !is_object($entry) || $entry->getStatus() != 0 ) {
			$this->redirect('');
		}

		if ( $this->getRequest()->isPost() ) {
			// Check input fields
			$firstname		= $this->getRequest()->getPost('firstname');
			$lastname		= $this->getRequest()->getPost('lastname');
			$email			= $this->getRequest()->getPost('email');
			$newsletter		= $this->getRequest()->getPost('newsletter');
			//$streetname		= $this->getRequest()->getPost('streetname');
			$streetnumber	= $this->getRequest()->getPost('streetnumber');
			//$postalcode		= $this->getRequest()->getPost('postalcode');
			$place			= $this->getRequest()->getPost('place');
			$terms			= $this->getRequest()->getPost('terms');

			// Is any of the required fields empty?
			if ( !$firstname || !$lastname || !$email || /*!$streetname ||*/ !$streetnumber || /*!$postalcode || */!$place || !$terms ) {
				WE_Engine_Session::setFlash('Alle velden zijn verplichte input','error');
				$this->view->assign('firstname',$firstname);
				$this->view->assign('lastname',$lastname);
				$this->view->assign('email',$email);
				$this->view->assign('newsletter',$newsletter);
				//$this->view->assign('streetname',$streetname);
				$this->view->assign('streetnumber',$streetnumber);
				//$this->view->assign('postalcode',$postalcode);
				$this->view->assign('place',$place);
				$this->view->assign('terms',$terms);
				return $this->view->render();
			}

			// Update entry in database
			$entry->setStatus(1);
			$entry->setFirst_name($firstname);
			$entry->setLast_name($lastname);
			$entry->setEmail($email);
			$entry->setNewsletter($newsletter?1:0);
			//$entry->setStreet_name($streetname);
			$entry->setStreet_number($streetnumber);
			//$entry->setPostal_code($postalcode);
			$entry->setPlace($place);
			$entry->setDate(date(Config::get('install','datetimeformat')));

			// Generate unique actiecode for entry
			do {
				$actiecode = $this->generateRandomString();
			} while ( Db::getTable('Entry')->findColumnData(array('actiecode'=>$actiecode))->count() > 0 );
			$entry->setActiecode($actiecode);

			if ( $entry->save() ) {
				// Send mail to keuken owner
				WE::include_adapter('WE_Mail');
				$mail = WE_Mail::getInstance();
				$mail->setTemplate('front/keukens/mail.tpl');
				$mail->assignToTemplate(array(
					array(	'key'=>'entry',
							'value'=>$entry
					),
					array(	'key'=>'ontvanger',
							'value'=>$entry
					)
				));
				$mail->setFrom('no-reply@opknappertjenodig.nl');
				$mail->setFromName('I-KOOK Keukens');
				$mail->setSubject('Bedankt voor je deelname!');
				$mail->setTo($entry->getEmail().',info@dekeukenvooriedereen.nl');
				$mail->send();

				// Forward to step 3
				$this->redirect('keukens/stap3/'.$entry->getId());
			} else {
				WE_Engine_Session::setFlash('Kon inzending niet wegschrijven naar de database','error');
				details($entry);
				$this->redirect('');
			}
		}

		return $this->view->render();
	}

	/**
	 * Submit a new entry, step three: spread the word about your entry
	 */
	public function stap3Action() {
		$entry = Db::getModel('Entry')->find($this->getRequest()->getGet('id'));
		if ( !is_object($entry) || $entry->getStatus() != 1 ) {
			$this->redirect('');
		}
		$this->view->assign('entry',$entry);
		return $this->view->render();
	}

	// /**
	//  * View an entry (also allows users to vote)
	//  */
	// public function opknapperAction() {

	// 	/* hacks van peter */
	// 	$topEntries = db::getTable('Entry')->findColumnData(array('status'=>'1','published'=>'1'),array(WE_Record::ORDER_DESC_BY_COLUMN=>'date'),3);
	// 	$from = $this->getRequest()->getGet('id2',0);
	// 	$to = $this->getRequest()->getGet('id3',5);
	// 	$topEntries = Db::getTable('Entry')->mostVotes($from,$to);

	// 	$this->view->assign('topEntries',$topEntries);

	// 	/*end hacks van peter*/

	// 	$entry = Db::getModel('Entry')->find($this->getRequest()->getGet('id'));
	// 	if ( !is_object($entry) || $entry->getStatus() != 1 || $entry->getPublished() != 1 ) {
	// 		$this->redirect('');
	// 	}
	// 	// Vote for this entry
	// 	if ( $this->getRequest()->isPost() ) {
	// 		if ( $this->getRequest()->getPost('vote') ) {
	// 			// Have we already voted for this entry with this IP?
	// 			$existingVotes = Db::getTable('Vote')->findColumnData(array('entry'=>$entry->getId(),'ip'=>$_SERVER['REMOTE_ADDR']));
	// 			if ( !Config::get('install','debug') && $existingVotes->count() > 0 ) {
	// 			//if ( $existingVotes->count() > 0 ) {
	// 				//$this->redirect('keukens/magnietstemmen');
	// 				WE_Engine_Session::setFlash('Helaas! Je mag slechts 1 keer stemmen per inzending.', 'fail');
	// 			} else {
	// 				// No, so store this vote
	// 				$vote = Db::getModel('Vote');
	// 				$vote->setEntry($entry->getId());
	// 				$vote->setIp($_SERVER['REMOTE_ADDR']);
	// 				$vote->setDate(date(Config::get('install','datetimeformat')));
	// 				$vote->save();
	// 				WE_Engine_Session::setFlash('Bedankt voor je stem!', 'success');

					// Send stem mail to keuken owner
					// WE::include_adapter('WE_Mail');
					// $mail = WE_Mail::getInstance();
					// $mail->setTemplate('front/keukens/stem_mail.tpl');
					// $mail->assignToTemplate(array(
					// 	array(	'key'=>'entry',
					// 			'value'=>$entry
					// 	),
					// 	array(	'key'=>'ontvanger',
					// 			'value'=>$entry
					// 	)
					// ));
					// $mail->setFrom('no-reply@opknappertjenodig.nl');
					// $mail->setFromName('I-KOOK Keukens');
					// $mail->setSubject('U heeft een nieuwe stem!');
					// $mail->setTo($entry->getEmail());
					// $mail->send();
	// 			}
	// 		}
	// 	}
		// Show entry and number of votes
		//$votes = Db::getTable('Vote')->findColumnData(array('entry'=>$entry->getId()));

		/* hacks van peter */



	// 	$this->view->assign('entry',$entry);
	// 	return $this->view->render();
	// }

	public function opknapperAction()
	{
		$topEntries = db::getTable('Entry')->findColumnData(array('status'=>'1','published'=>'1'),array(WE_Record::ORDER_DESC_BY_COLUMN=>'date'),3);
		$from = $this->getRequest()->getGet('id2',0);
		$to = $this->getRequest()->getGet('id3',5);
		$topEntries = Db::getTable('Entry')->mostVotes($from,$to);

		$this->view->assign('topEntries',$topEntries);

		$entryId = $this->entryId;

		if($entryId == null)
		{
			$entryId = $this->getRequest()->getGet('id');
		}

		//Bit weird to do it this way but if there is no entryid then load default
		if($entryId != null)
		{
			$entry = Db::getModel('Entry')->find($entryId);
			if ( !is_object($entry) || $entry->getStatus() != 1 || $entry->getPublished() != 1 ) {
				$this->redirect('');
			}
			$votes = Db::getTable('Vote')->findColumnData(array('entry'=>$entry->getId(),'verified' => 1))->count();

			$this->view->assign('entry',$entry);
			$this->view->assign('votes',$votes);
			return $this->view->render('front/keukens/opknapper.tpl');
		}
		else
		{
			$this->redirect('');
		}
	}

	public function stemAction()
	{
		if($this->getRequest()->isPost())
		{
			$voteData = $this->getRequest()->getPost('vote');

			if($voteData)
			{
				$this->entryId = $voteData['entryId'];
				$allowedToVote = Db::getTable('Vote')->allowedToVote($voteData['entryId'], $voteData['email'], $_SERVER['REMOTE_ADDR']);

				if($allowedToVote)
				{
					$verifyString = str_shuffle(md5($voteData['email']).rand(0,100));
					$vote = Db::getModel('Vote');
					$vote->setEntry($voteData['entryId']);
					$vote->setIp($_SERVER['REMOTE_ADDR']);
					$vote->setEmail($voteData['email']);
					$vote->setVerified(0);
					$vote->setVerifystring($verifyString);
					$vote->setDate(date(Config::get('install','datetimeformat')));

					if($vote->save())
					{
						// Send confirmation mail to voter
						WE::include_adapter('WE_Mail');
						$mail = WE_Mail::getInstance();
						$mail->setTemplate('front/keukens/bevestig_mail.tpl');
						$mail->assignToTemplate(array(
							array(	'key'=>'verifyString',
									'value'=>$verifyString
							)
						));
						$mail->setFrom('no-reply@opknappertjenodig.nl');
						$mail->setFromName('I-KOOK Keukens');
						$mail->setSubject('Bevestig je stem op opknappertjenodig.nl');
						$mail->setTo($voteData['email']);
						$mail->send();

						WE_Engine_Session::setFlash('Let op: Je bent nog niet klaar. We hebben een link gestuurd naar '
							.htmlspecialchars($voteData['email']).'. Klik op deze link om je stem te bevestigen.','success');
					}
					else
					{
						details($vote->getErrors());
						WE_Engine_Session::setFlash('Sorry, er is iets fout gegaan met het verwerken van je stem.', 'fail');
					}
				}
				else
				{
					WE_Engine_Session::setFlash('Helaas! Je mag slechts 1 keer stemmen per inzending.', 'fail');
				}
			}
		}

		return $this->opknapperAction();
	}

	public function bevestigAction() {
		$verifyString = $this->getRequest()->getGet('id');

		if($verifyString)
		{
			$vote = Db::getModel('Vote');
			$vote = $vote->findColumnData(array('verifyString' => $verifyString));

			if($vote != null)
			{
				$this->entryId = $vote->getEntry();
				if(!$vote->getVerified())
				{
					$vote->setVerified(1);

					if($vote->save())
					{
						$entry = Db::getmodel('Entry');
						$entry = $entry->find($vote->getEntry());

						WE::include_adapter('WE_Mail');
						$mail = WE_Mail::getInstance();
						$mail->setTemplate('front/keukens/stem_mail.tpl');
						$mail->assignToTemplate(array(
							array(	'key'=>'entry',
									'value'=>$entry
							),
							array(	'key'=>'ontvanger',
									'value'=>$entry
							)
						));
						$mail->setFrom('no-reply@opknappertjenodig.nl');
						$mail->setFromName('I-KOOK Keukens');
						$mail->setSubject('Gefeliciteerd! Je hebt een nieuwe stem!');
						$mail->setTo($entry->getEmail());
						$mail->send();

						WE_Engine_Session::setFlash('Bedankt voor je stem!', 'succes');
					}
					else
					{
						details($vote->getErrors());
						WE_Engine_Session::setFlash('Sorry, er is iets fout gegaan met het verwerken van je stem.', 'fail');
					}
				}
				else
				{
					WE_Engine_Session::setFlash('Helaas! Deze stem is al bevestigd.', 'fail');
				}
			}
			else
			{
				WE_Engine_Session::setFlash('Sorry, de door jou opgevraagde stem bestaat niet.', 'fail');
			}
		}

		return $this->opknapperAction();
	}

	/**
	 * Show a warning that only one entry is allowed per IP adddress
	 */
	public function magnietAction() {
		return $this->view->render();
	}

	/**
	 * Show a warning that only one vote is allowed per IP adddress
	 */
	public function magnietstemmenAction() {
		return $this->view->render();
	}

	/**
	 * Handle file uploads, copied and adapted from open space company project
	 * @param array $from $_FILES['yourfile'] array
	 * @param string $to Directory to store file
	 * @return File name on success or negative integer on error (-1 = Invalid file type, -2 = Could not store file)
	 */
	private function handleFileUploads($from,$to) {
		foreach( $from['error'] as $key=>$error ) {
			if ( $error == UPLOAD_ERR_OK ) {
				// There is some file type checking here
				if (strpos($from['type'][$key], 'image') != 0) {
					return -1;
				}
				$filename = basename($from['tmp_name'][$key]).'_'.basename($from['name'][$key]);
				if ( move_uploaded_file($from['tmp_name'][$key], $to.$filename) ) {
					return $filename;
				} else {
					return -2;
				}
			}
		}
	}

	/**
	 * Generate hash voor actiecode
	 * @param int $length
	 * @see http://stackoverflow.com/questions/4356289/php-random-string-generator
	 */
	private function generateRandomString($length = 10) {
    	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

}
?>
