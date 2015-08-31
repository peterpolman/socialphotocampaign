<?php
class WE_Mail
{
	private $from 		= null;
	private $from_name	= null;
	private $to			= null;
	private $subject 	= null;
	private $template 	= null;
	public $view 		= null;
	
	private $filename	= null;
	private $filecontents= null;

	private static $_instance;
	
	function __construct()
	{
		//$this->from 		= Config::get('mail','from');
		//$this->from_name 	= Config::get('mail','fromname');
		require_once 'library/View.php';
		$this->view = new WE_View();
	}

	
	public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
		
        return self::$_instance;
    }
    
	public function setFrom($from)
	{
		$this->from = $from;
	}
	
	public function setFromName($name) {
		$this->from_name = $name;
	}
	
	public function setTemplate($template)
	{
		$this->template = $template;
	}
	
	public function setTo($to)
	{
		$this->to = $to;
	}
	
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}
	
	public function attachFile($filename,$content)
	{
		$this->filename = $filename;
		$this->filecontents = $content;
	}
	
	public function assignToTemplate($assignments) {
		foreach ($assignments as $assign) {
			$this->view->assign($assign['key'],$assign['value']);
		}
	}
	
	public function send()
	{

		if (!empty($this->to) && !empty($this->from) && !empty($this->subject) && !empty($this->template))
		{
			$this->view->assign('To',$this->to);
			$this->view->assign('From',$this->from);
			$this->view->assign('Subject',$this->subject);
			
			$message = $this->view->render($this->template);
			
			if (empty($this->filename) || empty($this->filecontents))
			{
				$uid = $uid = md5(uniqid(time()));
				$headers  = "From: ".$this->from_name." <".$this->from.">\n";
				$headers .= "Reply-To: ".$this->from."\r\n";
				$headers .=	"MIME-Version: 1.0\n" .
					"Content-type: text/html; charset=iso-8859-1";
					 $headers .= "--".$uid."\r\n";
			} else
			{
				$uid = $uid = md5(uniqid(time()));
			    $headers = "From: ".$this->from_name." <".$this->from.">\r\n";
			    $headers .= "Reply-To: ".$this->from."\r\n";
			    $headers .= "MIME-Version: 1.0\r\n";
			    $headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
			    $headers .= "This is a multi-part message in MIME format.\r\n";
			    $headers .= "--".$uid."\r\n";
			    $headers .= "Content-type:text/plain; charset=iso-8859-1\r\n";
			    $headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
			    $headers .= $message."\r\n\r\n";
			    $headers .= "--".$uid."\r\n";
			    $headers .= "Content-Type: application/octet-stream; name=\"".$this->filename."\"\r\n"; // use different content types here
			    $headers .= "Content-Transfer-Encoding: base64\r\n";
			    $headers .= "Content-Disposition: attachment; filename=\"".$this->filename."\"\r\n\r\n";
			    $headers .= $this->filecontents."\r\n\r\n";
			    $headers .= "--".$uid."--";
			    $message = "";
			} 
			
			if (Config::get('install','debug') == true)
			{
				details($this->to);
				details($this->subject);
				details($message);
				details($headers);
			}
			else
			{
				return mail($this->to,$this->subject,$message,$headers);
			}
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	public function valid_email($email) { 
	  // First, we check that there's one @ symbol, and that the lengths are right 
	  if (preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email) == 0) { 
	    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols. 
	    return false; 
	  } 
	  // Split it into sections to make life easier 
	  $email_array = explode("@", $email); 
	  $local_array = explode(".", $email_array[0]); 
	  for ($i = 0; $i < sizeof($local_array); $i++) { 
	     if (preg_match("/^(([A-Za-z0-9!#$%&#038;'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i]) == 0) { 
	      return false; 
	    } 
	  }   
	  if (preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1]) == 0) { // Check if domain is IP. If not, it should be valid domain name 
	    $domain_array = explode(".", $email_array[1]); 
	    if (sizeof($domain_array) < 2) { 
	        return false; // Not enough parts to domain 
	    } 
	    for ($i = 0; $i < sizeof($domain_array); $i++) { 
	      if (preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i]) == 0) { 
	        return false; 
	      } 
	    } 
	  } 
	  return true; 
	}
	
}
?>