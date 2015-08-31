<?php

class WE_Log
{	
	protected static 	$_instance = null;
	private $request 	= null;

	private $level 		= 'auto';
	private $message 	= null;
	private $execTime	= null;

	private $preFix 	= 'log';
	private $logDir		= 'log';
	private $maxSize	= 2097151;	// 2 megabyte - 1 byte
	private $current	= 1;
	private $logFiles	= array();
	
	private $ignore 	= array('.','..','.DS_Store');
    
    /**
     * Construct WE_Log
     *
     * @return void
     */
    function __construct ()
    {
    	$this->logDir = Config::get('install','filesdir').'log/';
    	WE::getInstance()->include_library('Controller/Request');
		$this->request = new WE_Controller_Request();
		$this->setLogFiles();
    }
	
    /**
     * Enforce singleton; disallow cloning
     *
     * @return WE_Log
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    /**
     * Sets the exectime
     *
	 * @param string $mtime
     * @return void
     */
    public function setExectime($mtime)
    {
    	$this->execTime = $mtime;
    }
	
    /**
     * Stores a log entry
     *
	 * @param string $level
	 * @param string $message
     * @return void
     */
	public function store($level = null, $message = null)
	{
		$date 			= date("Y-m-d H:i:s");
		$ip 			= $this->request->getServer('REMOTE_ADDR');
		$controller 	= $this->request->getControllerKey();
		$action 		= $this->request->getActionKey();
		$id 			= $this->request->getGet('id');
		$execTime		= round($this->execTime,3);
		
		$userSession 	= WE_Engine_Session::getNamespace('Auth');
		$username 		= isset($userSession->username);
		
		if (empty($level))
		{
			$level = $this->level;
		}
		
		$new = false;
		
		$string = "[$date][$level][$ip][$controller][$action] | ";
		
		if (!empty($username))
		{
			$string .= "[($username)]";
		}
		
		if (!empty($id))
		{
			$string .= "[$id]";
		}
		
		if (!empty($message))
		{
			$string .= "($message)";
		}

		if (!empty($execTime))
		{
			$string .= " | $execTime";
		}
		
		$string = $string . "\r\n";
		
		if (!empty($this->logFiles))
		{
			if ((filesize($this->logDir.$this->preFix.$this->current.'.txt') + strlen($string)) > $this->maxSize)
			{
				$this->current = $this->current + 1;
				$new = true;
			}
		}
		else
		{
			$new = true;
		}
		
		$filename = $this->logDir.'/'.$this->preFix.$this->current.'.txt';
		
		$fd = fopen($filename, "a");
		
		if ($new == true)
		{
			$info =  "[date][level][ip][controller][action] | [(username)] [id] (message)\r\n";
			$info .= "======================================================================\r\n";
			
			fwrite($fd, $info);
		}
		
		fwrite($fd, $string);
		fclose($fd);
	}
	
    /**
     * Sets the logfiles list to the object
     *
     * @return void
     */
	private function setLogfiles()
	{
		$logFiles = array();
		if ($handle = opendir($this->logDir)) {
			while (false !== ($file = readdir($handle))) {
				if (!in_array($file,$this->ignore) && substr($file,0,strlen($this->preFix)) && substr($file, (strrpos($file, '.')+1)))
				{
					$filename 	= substr($file, 0, strrpos($file, '.')); 
					$num = substr($filename, (strrpos($file, $this->preFix)+strlen($this->preFix)));
					
					if ($num > $this->current)
					{
						$this->current = $num;
					}
					
					$logFiles[] = $num;
				}
			}
			closedir($handle);
		}
		$this->logFiles = $logFiles;
	}
}
?>