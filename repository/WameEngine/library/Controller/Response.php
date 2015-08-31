<?php

class WE_Controller_Response
{
	protected $headers 			= array();
	protected $body 			= array();
	protected $headersSent		= false;
	
	public function send()
	{
		$this->sendHeaders();
		$this->sendBody();
		return $this;
	}
	
	public function redirect ($uri = null,$system = true)
	{
		if ((WE_ErrorHandler::getInstance()->allowRedirect() && Config::get('install','debug') == true) || Config::get('install','debug') == false) {
			
			if ($system == true)
			{
				$uri = Config::get('install','secure_root').$uri;
			}
			
			if (Db::getInstance()->hasActiveTransaction())
			{
				Db::getInstance()->commitTransaction();
			}
			
			WE_Engine_Session::save();
			
			header('Location: '.(string) $uri);
			exit;
		} else {
			WE_ErrorHandler::getInstance()->triedRedirect(true,$uri);
		}
	}
	
	private function normalizeHeader ($name)
	{
		$normalized = trim($name);
		$normalized = str_replace(array('-', '_'), ' ', (string) $normalized);
		$normalized = ucwords(strtolower($normalized));
		$normalized = str_replace(' ', '-', $normalized);
		
		return $normalized;
	}
	
	public function canSendHeaders ()
	{
		return $this->headersSent;
	}
	
	public function setHeader($name, $value, $replace = false)
	{
		$this->headers[] = array(
			'name' 		=> $this->normalizeHeader($name),
			'value' 	=> (string) $value, 
			'replace'	=> (boolean) $replace
		);
							  
		return $this;
	}
	
	public function appendBody ($content)
	{
		$this->body[] = (string) $content;
		
		return $this;
	}
	
	public function sendBody ()
	{
		foreach ($this->body as $body) {
			echo $body;
		}
		
		return $this;
	}
	
	public function sendHeaders ()
	{
			$this->headersSent = true;
			
			foreach ($this->headers as $header) {
				header($header['name'] . ': '. $header['value'], $header['replace']);
			}
			
		return $this;
	}
}
