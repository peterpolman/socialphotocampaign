<?php
class WE_ErrorHandler
{
	private static $_instance;
	private $errorlist 	= array();
	private $noticelist = array();
	private $details 	= array();
	private $query 		= array();
	private $jsonRequest = array();
	private $mtime		= null;
	private $shown		= false;
	private $allowQuery = true;
	private $triedRedirect 	= false;
	private $redirUri 	= null;
	
	private $regQuery = true;
	
	
    /**
     * Enforce singleton; disallow cloning
     *
     * @return void
     */
    private function __clone()
    {
    }
    
    /**
     * Enforce singleton; disallow cloning
     *
     * @return WE_ErrorHandler
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
		
        return self::$_instance;
    }
    
    public function setRegQuery($queryreg)
    {
    	$this->regQuery = $queryreg;
    }
    
    public function getRegQuery()
    {
    	return $this->regQuery;
    }
    
    public function setAllowQuery($queryallow)
    {
    	$this->allowQuery = $queryallow;
    }
    
	
	public function triedRedirect($redirect,$uri = null)
	{
		$trace = debug_backtrace(false);
		foreach($trace as $track) {
			if ($track['class'] == 'WE_Controller') {
				details("REDIRECT BY: ".substr($track['file'],strlen(Config::get('install','absolute_root'))).' ('.$track['line'].') URI: '.$uri);
				break;
			}
		}
		
		if (!is_null($uri))
		{
			$this->redirUri = $uri;
		}
		$this->triedRedirect = $redirect;
	}
    
    public function getAllowQuery()
    {
    	return $this->allowQuery;
    }
	
	public function addError($errno, $errstr, $errfile, $errline)
	{
		switch( $errno )
		{
			case E_ERROR:				$error_type = "E_ERROR";				break;
			case E_WARNING:				$error_type = "E_WARNING";				break;
			case E_PARSE:				$error_type = "E_PARSE";				break;
			case E_NOTICE:				$error_type = "E_NOTICE";				break;
			case E_CORE_ERROR:			$error_type = "E_CORE_ERROR";			break;
			case E_CORE_WARNING:		$error_type = "E_CORE_WARNING";			break;
			case E_COMPILE_ERROR:		$error_type = "E_COMPILE_ERROR";		break;
			case E_COMPILE_WARNING:		$error_type = "E_COMPILE_WARNING";		break;
			case E_USER_ERROR:			$error_type = "E_USER_ERROR";			break;
			case E_USER_WARNING:		$error_type = "E_USER_WARNING";			break;
			case E_USER_NOTICE:			$error_type = "E_USER_NOTICE";			break;
			case E_STRICT:				$error_type = "E_STRICT";				break;
			case E_RECOVERABLE_ERROR: 	$error_type = "E_RECOVERABLE_ERROR";	break;
			case "E_DEPRECATED":		$error_type = "E_DEPRECATED";			break;
			case "E_USER_DEPRECATED":	$error_type = "E_USER_DEPRECATED";		break;
			case "E_EXCEPTION":			$error_type = "E_EXCEPTION";			break;
			default:					$error_type = "E_UNKNOWN";				break;
		} 
		
		$errfile = substr($errfile,strlen(Config::get('install','absolute_root')));
		
		$error = array(
		'type' 		=> $error_type,
		'message' 	=> $errstr,
		'file'		=> $errfile,
		'line'		=> $errline,
		'trace'		=> debug_backtrace(false)
		);
		
		if ($error_type == "E_NOTICE")
		{
			$this->noticelist[] = $error;
		} else {
			$this->errorlist[] = $error;
		}
	}
	
	public function allowRedirect()
	{
		if (count($this->errorlist) > 0 || count($this->noticelist) > 0 || count($this->details) > 0) {
			return false;
		} else {
			return true;
		}
	}
	
	public function allowCommit()
	{
		if (count($this->errorlist) > 0)
		{
			return false;
		} else {
			return true;
		}
	}
	
	public function addQuery($sql,$aInputParameters = null)
	{
		if ($this->regQuery == true) {
			if (!empty($aInputParameters)) {
				$tmp = array();
				foreach($aInputParameters as $field=>$value)
				{
					$tmp[] = "$field => $value";
				}
				$param = implode(', ',$tmp);
			} else {
				$param = '';
			}
			
			$q['sql'] = $sql;
			//$q['var'] = $param;
			$q['var'] = $aInputParameters;
			$q['trace'] = $this->sanitezeTrace(debug_backtrace(false));
			$this->query[] = $q;
		}
	}
	
	public function addJSONRequest(JSONrequestObject $request, JSONresponseObject $response) {
		$return = array();
		
		$return['request'] = clone $request;
		$responseData = clone $response;
		$responseData->unsetDebug();
		$responseDebug = $response->getDebug();
		$return['header'] = $request->requesttype." ".$request->name." ".$request->function;
		$return['responseDebug'] = $responseDebug;
		$return['response'] =  $responseData;
		$return['trace'] = $this->sanitezeTrace(debug_backtrace(false));
		$this->jsonRequest[] = $return;
	}

	public function addDetails($detail)
	{
		// PRE PHP 5.3.6 stack trace
		$trace = debug_backtrace(false);
		$string = '('.count($this->details).') '.substr($trace[1]['file'],strlen(Config::get('install','absolute_root'))).' ('.$trace[1]['line'].')';
		$memUsage = round(((memory_get_peak_usage()/1024)/1024),3);
		$string .= ' '.$memUsage.'Mb';
		
		try {
			if (is_object($detail)) {
				$clone = clone $detail;
			}
		} catch (Exception $e) {
			$clone = null;
		}		
		
		if (!empty($clone)) {
			$this->details[$string]['data'] = $clone;
		} else {
			$this->details[$string]['data'] = $detail;
		}
		unset($trace[0]);
		$this->details[$string]['trace'] = $this->sanitezeTrace($trace);
		
	}
	
	private function sanitezeTrace($aTrace) {
		$return = array();
		foreach($aTrace as $line=>$trace) {
			$return[$line]['file'] = $line.': '.substr($trace['file'],strlen(Config::get('install','absolute_root'))).' ('.$trace['line'].')';
			
			if (isset($trace['class'])) {
				$handle = $trace['class'].$trace['type'].$trace['function'];
			} else {
				$handle = $trace['function'];
			}
			
			$return[$line]['file'] .= ' '.$handle;
			
			$return[$line]['args'] = $trace['args'];
		}
		
		//$return['file'] = substr($trace['file'],strlen(Config::get('install','absolute_root'))).' ('.$trace['line'].')';
		//return $return;
		return $return;
	}
	
	public function setMtime($mtime)
	{
		$this->mtime = $mtime;
	}
	
	public function arrayErrorMenu($showTrace = false) {
		$this->shown = true;
		
		global $time_start;
		$mtime = microtime(true) - $time_start;
		WE_ErrorHandler::getInstance()->setMtime($mtime);
		$result							= array();
		$result['exectime']	= round($this->mtime,3);
		$result['details']		= array();
		$result['notices']		= array();
		$result['errors']		= array();
		$result['queries']		= array();
		
		foreach($this->details as $dkey=>$detail)
			$result['details'][] = print_r($detail['data'],true);
		foreach($this->errorlist as $ekey=>$error) {
			if ( !$showTrace )
				unset($error['trace']);
			$result['errors'][] = $error;
		}
		foreach($this->noticelist as $ekey=>$error) {
			if ( !$showTrace )
				unset($error['trace']);
			$result['notices'][] = $error;
		}
		foreach($this->query as $ekey=>$query) {
			if ( !$showTrace )
				unset($query['trace']);
			$result['queries'][] = $query;
		}
			
		return $result;
	}
	
	public function showErrorMenu($fatal = false)
	{
		$this->shown = true;

		if (count($this->details) > 0 || count($this->errorlist) > 0 || count($this->noticelist) > 0)
		{
			$this->query = array_reverse($this->query,true);
			$this->jsonRequest =  array_reverse($this->jsonRequest,true);
			if ($fatal == true)
			{
				$sec_root = Config::get('install','secure_root');
				echo '
				<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
				<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<title>WAMEFRAME DEBUG</title>
					<link rel="stylesheet" type="text/css" href="'.$sec_root.'cji/css/default.css" >
					<link rel="stylesheet" type="text/css" href="'.$sec_root.'cji/css/print.css" media="print" />
					<script src="'.$sec_root.'cji/js/jquery-1.8.2.min.js" type="text/javascript"></script>
					<script src="'.$sec_root.'cji/js/jquery-ui-1.9.0.custom.min.js" type="text/javascript"></script>
					<!--  Saad, saaaaad panda  -->
					<script type="text/javascript" src="'.$sec_root.'cji/js/sadpanda.js"></script>
					</head>
					<body>
				';
			}
			?>
				<script type="text/javascript" language="javascript">
					if (typeof jQuery == 'undefined') {
						   var script = document.createElement('script');
						   script.type = "text/javascript";
						   script.src = "<?php echo Config::get('install','secure_root').'cji/js/jquery-1.8.2.min.js'; ?>";
						   document.getElementsByTagName('head')[0].appendChild(script);
						   var script2 = document.createElement('script');
						   script2.type = "text/javascript";
						   script2.src = "<?php echo Config::get('install','secure_root').'cji/js/jquery-ui-1.9.0.custom.min.js'; ?>";
						   document.getElementsByTagName('head')[0].appendChild(script2);
						
						
					}
				
					$(document).ready(function()
					{
						$('#close_message').click(function() { 
							$('#message_box').animate({ top:"+=15px",opacity:0 }, "slow");
						});
				
						$("#info_head").click(function(){
						<?php
							if ((count($this->errorlist) + count($this->noticelist) + count($this->details) + count($this->query) + count($this->jsonRequest)) >= 100) {
								echo '$(this).next(".msg_body").toggle();';
							} else {
								echo '$(this).next(".msg_body").slideToggle(250);';
							}
						?>
						});
						$("#error_head").click(function(){
						<?php
							if (count($this->errorlist) >= 100) {
								echo '$(this).next(".msg_body").toggle();';
							} else {
								echo '$(this).next(".msg_body").slideToggle(250);';
							}
						?>
						});
						$("#error_head2").click(function(){
						<?php
							if (count($this->noticelist) >= 100) {
								echo '$(this).next(".msg_body").toggle();';
							} else {
								echo '$(this).next(".msg_body").slideToggle(250);';
							}
						?>
						});
						$("#details_head").click(function(){
						<?php
							if (count($this->details) >= 100) {
								echo '$(this).next(".msg_body").toggle();';
							} else {
								echo '$(this).next(".msg_body").slideToggle(250);';
							}
						?>
						});
						$("#query_head").click(function(){
						<?php
							if (count($this->query) >= 100) {
								echo '$(this).next(".msg_body").toggle();';
							} else {
								echo '$(this).next(".msg_body").slideToggle(250);';
							}
						?>
						});
						$("#json_head").click(function(){
							<?php
								if (count($this->jsonRequest) >= 100) {
									echo '$(this).next(".msg_body").toggle();';
								} else {
									echo '$(this).next(".msg_body").slideToggle(250);';
								}
							?>
							});
						<?php if ($fatal == false) {
							echo '$(".msg_body").hide();';
						}
						?>

						$('.tracemaster').each(function() {
						    $(this).click(function() {
						        var nummer = $(this).attr('volg');
						        $('.trace[volg="'+nummer+'"]').toggle();
						    });
						});
					});
				</script>
				<style media="all" type="text/css">
					<?php /* 20120704, BE: Nou is het wel leuk geweest ..
					if (rand(0,1) == 1 && !empty($this->errorlist)) { ?>
					body {
					    -webkit-transform: rotate(1deg);
						-moz-transform: rotate(1deg);
						margin-top:50px;
					}
					<?php } */ ?>
					#message_box { 
						position: absolute; 
						top: 0; right: 0; 
						z-index: 10; 
						background:#fff;
						padding:0px;
						border:1px solid #CCCCCC;
						text-align:left; 
						font-weight:bold; 
						font-size:10px;
						<?php //if ($fatal == false) {
							//echo 'width:924px;';
						//} else {
							echo 'width:100%;';
						//}
						?>
					}
					#info_head {
						cursor:pointer;
						padding: 5px;
						margin: 0px;
						<?php 
						if (count($this->errorlist) != 0) {
						echo 'background:#daa;';
						} else if (count($this->noticelist) != 0) {
						echo 'background:#dbb;';
						} else {
						echo 'background:#bdb;';
						}
						?>
						border-bottom: 1px solid #CCCCCC;
					}
					
					#tracetable {
						margin: 0px;
						padding: 5px;
						width:100%;
					}
					
					#details_head {
						cursor:pointer;
						padding: 5px;
						margin: 0px;
						background:#bbd;
					}
					#error_head {
						cursor:pointer;
						padding: 5px;
						margin: 0px;
						background:#daa;
					}
					
					#error_head2 {
						cursor:pointer;
						padding: 5px;
						margin: 0px;
						background:#dbb;
					}
					
					#query_head {
						cursor:pointer;
						padding: 5px;
						margin: 0px;
						background:#bbb;
					}
					
					#json_head {
						cursor:pointer;
						padding: 5px;
						margin: 0px;
						background:#bb0;
					}
					
					.odd {
						background:#eee;
					}
					.fat {
						text-decoration:none;
						font-size:24px;
						color:#666666;
					}
					.tracemaster {
						text-decoration:none;
					}
					
					.trace {
						display: none;
					}
				</style>
				
				<div id="message_box"><p id="info_head">
				<?php 
				$peak = round(((memory_get_peak_usage()/1024)/1024),3);
				if ($this->triedRedirect === true)
				{
					if (!is_null($this->redirUri)) {
						echo '<a href="'.Config::get('install','secure_root').$this->redirUri.'" class="fat"><b>HALTED!</b></a> | ';
					} else {
						echo '<b>HALTED!</b> | ';
					}
				}
				
				
				echo 'Exec Time:'.round($this->mtime,3).'s | Error:'.count($this->errorlist).' | Notice:'.count($this->noticelist).' | Query:'.count($this->query).' | Details:'.count($this->details).' | JSON:'.count($this->jsonRequest).' | Peak: '.$peak.'Mb';
				
				$counter = 0;
				?>
				</p>
					<div class="msg_body">
						
						<?php if (count($this->details) != '') { ?>
						<p id="details_head">Details:<?php echo count($this->details); ?></p>
						<div class="msg_body" style="display: none;">
							<table width="100%" border="0" cellspacing="0" cellpadding="1">
							<?php
							$i = 0;
							 foreach($this->details as $dkey=>$detail) {
								if ($i % 2 == 0) {
									echo '<tr>';
								} else {
									echo '<tr class="odd">';	
								}
								echo "<td>".($i+1)."</td>";
								echo "<td>";
								echo '<b><a class="tracemaster" volg="'.$counter.'"/>'.$dkey.'</a></b><br/><pre>'.print_r($detail['data'],true)."</pre>";
								
								echo '<div class="trace" volg="'.$counter.'">';
								$counter++;
								
								echo '<table class="tracetable">';

								if (is_array($detail['trace'])) {
									foreach($detail['trace'] as $trace) {
										
										echo '<tr><td>';
										echo '<b>'.$trace['file'].'</b><br><ul>';
										foreach($trace['args'] as $arg) {
											echo '<pre><li>'.print_r($arg,true).'</pre></li>';
										}
										echo '</ul></td></tr>';
									}
								} else {
									echo '<tr><td><pre>';
									print_r($detail['trace']);
									echo '</pre></td></tr>';
								}

								echo '</table>';
								
								echo '</div>';
								
								echo "</td>";
								echo "</tr>";
								$i++;
							 }
						  	?>
							</table>
						</div>
						<?php } ?>
					
						<?php if (count($this->errorlist) != '') { ?>
						<p id="error_head">Errors:<?php echo count($this->errorlist); ?></p>
						<div class="msg_body" style="display: none;">
							<table width="100%" border="0" cellspacing="0" cellpadding="1">
							<?php
							$i = 0;
							 foreach($this->errorlist as $ekey=>$error) {
								if ($i % 2 == 0) {
									echo '<tr>';
								} else {
									echo '<tr class="odd">';	
								}
								echo "<td>$ekey</td>";
								echo '<td>'.$error['type'].'</td>';
								echo '<td>'.$error['line'].'</td>';
								echo '<td><a class="tracemaster" volg="'.$counter.'"/>'.$error['file'].'</a></td>';
								echo '<td><pre>'.$error['message'].'</pre></td>';
								echo "</tr>";
								
							 	echo '<tr class="trace" volg="'.$counter.'"><td colspan="4">';
								$counter++;
								
								echo '<table class="tracetable">';

								if (is_array($error['trace'])) {
									foreach($error['trace'] as $trace) {
										
										echo '<tr><td>';
										echo '<b>'.(isset($trace['file']) ? $trace['file'] : "WE " ).'</b><br><ul>';
										foreach($trace['args'] as $arg) {
											echo '<pre><li>'.print_r($arg,true).'</pre></li>';
										}
										echo '</ul></td></tr>';
									}
								} else {
									echo '<tr><td><pre>';
									print_r($error['trace']);
									echo '</pre></td></tr>';
								}

								echo '</table>';
								echo '</td></tr>';

								$i++;
							 }
						  	?>
							</table>
						</div>
						<?php } ?>
						
						<?php if (count($this->noticelist) != '') { ?>
						<p id="error_head2">Notices:<?php echo count($this->noticelist); ?></p>
						<div class="msg_body" style="display: none;">
							<table width="100%" border="0" cellspacing="0" cellpadding="1">
							<?php
							$i = 0;
							 foreach($this->noticelist as $ekey=>$error) {
								if ($i % 2 == 0) {
									echo '<tr>';
								} else {
									echo '<tr class="odd">';	
								}
								echo "<td>$ekey</td>";
								echo '<td>'.$error['type'].'</td>';
								echo '<td>'.$error['line'].'</td>';
								echo '<td><a class="tracemaster" volg="'.$counter.'"/>'.$error['file'].'</a></td>';
								echo '<td>'.$error['message'].'</td>';
								echo "</tr>";
								
								/*echo '<tr class="trace" volg="'.$counter.'"><td colspan="4"><pre>';
								$counter++;
								
								if (is_array($error['trace'])) {
									foreach($error['trace'] as $trace) {
										print_r($trace);
									}
								} else {
									print_r($error['trace']);
								}*/
								
							 	echo '<tr class="trace" volg="'.$counter.'"><td colspan="4">';
								$counter++;
								
								echo '<table class="tracetable">';

								if (is_array($detail['trace'])) {
									foreach($detail['trace'] as $trace) {
										
										echo '<tr><td>';
										echo '<b>'.$trace['file'].'</b><br><ul>';
										foreach($trace['args'] as $arg) {
											echo '<pre><li>'.print_r($arg,true).'</pre></li>';
										}
										echo '</ul></td></tr>';
									}
								} else {
									echo '<tr><td><pre>';
									print_r($detail['trace']);
									echo '</pre></td></tr>';
								}

								echo '</table>';
	
								echo '</td></tr>';
								
								$i++;
							 }
						  	?>
							</table>
						</div>
						<?php } ?>
						
						
						<?php if (count($this->jsonRequest) != '') { ?>
						<p id="json_head">Json:<?php echo count($this->jsonRequest); ?></p>
						<div class="msg_body" style="display: none;">
							<table width="100%" border="0" cellspacing="0" cellpadding="1">
							<?php
							$i = 0;
							 foreach($this->jsonRequest as $dkey=>$json) {
								if ($i % 2 == 0) {
									echo '<tr>';
								} else {
									echo '<tr class="odd">';	
								}
								echo "<td>".($i+1)."</td>";
								echo "<td>";
								echo '<b><a class="tracemaster" volg="'.$counter.'"/>'.$json['trace'][2]['file'].'</a></b><br/><pre>Request: '.print_r($json['request'],true)."</pre><br/><pre>Response: ".print_r($json['response'],true)."</pre>";
								
								echo '<div class="trace" volg="'.$counter.'">';
								$counter++;
								
								echo '<table class="tracetable">';
								
								if (!empty($json['responseDebug'])) {
									echo '<tr><td><pre>';
									print_r($json['responseDebug']);
									echo '</pre></td></tr>';
								}

								if (is_array($json['trace'])) {
									foreach($json['trace'] as $trace) {
										
										echo '<tr><td>';
										echo '<b>'.$trace['file'].'</b><br><ul>';
										foreach($trace['args'] as $arg) {
											echo '<pre><li>'.print_r($arg,true).'</pre></li>';
										}
										echo '</ul></td></tr>';
									}
								} else {
									echo '<tr><td><pre>';
									print_r($json['trace']);
									echo '</pre></td></tr>';
								}

								echo '</table>';
								
								echo '</div>';
								
								echo "</td>";
								echo "</tr>";
								$i++;
							 }
						  	?>
							</table>
						</div>
						<?php } ?>
						
						
						
						
						<?php if (count($this->query) != '') { ?>
						<p id="query_head">Queries:<?php echo count($this->query); ?></p>
						<div class="msg_body" style="display: none;">
							<table width="100%" border="0" cellspacing="0" cellpadding="1">
							<?php
							$i = 0;
							 foreach($this->query as $ekey=>$query) {
							 	if (!empty($query['var'])) {
									$tmp = array();
									foreach($query['var'] as $field=>$value)
									{
										$tmp[] = "$field => $value";
									}
									$param = implode(', ',$tmp);
								} else {
									$param = '';
								}
							 	
							 	
							 	
							 	
							 	
							 	
								if ($i % 2 == 0) {
									echo '<tr>';
								} else {
									echo '<tr class="odd">';	
								}
								echo "<td>$ekey</td>";
								echo '<td><a class="tracemaster" volg="'.$counter.'"/>'.$query['sql'].'</a></td>';
								echo '<td valign="top">'.$param.'</td>';
								echo "</tr>";
								
								
								echo '<tr class="trace" volg="'.$counter.'"><td>&nbsp;</td><td colspan="2">';
								echo '<div class="trace" volg="'.$counter.'">';
								
								$newQuery = $query['sql'];
								foreach($query['var'] as $key=>$var) {
									$escaped = Db::getInstance()->escape($var);
									$newQuery = str_replace(":".$key, $escaped, $newQuery);
								}
								echo '<pre>PHPMYADMIN: ';
								print_r($newQuery);
								echo '</pre>';
								echo "\n\r";
								
								$counter++;
								
								echo '<table class="tracetable">';

								if (is_array($query['trace'])) {
									foreach($query['trace'] as $trace) {
										
										echo '<tr><td>';
										echo '<b>'.$trace['file'].'</b><br><ul>';
										foreach($trace['args'] as $arg) {
											echo '<pre><li>'.print_r($arg,true).'</pre></li>';
										}
										echo '</ul></td></tr>';
									}
								} else {
									echo '<tr><td><pre>';
									print_r($query['trace']);
									echo '</pre></td></tr>';
								}

								echo '</table>';
								echo '</td>';
								echo "</tr>";
								$i++;
							 }
						  	?>
							
	
							</table>
						</div>
						<?php } ?>
					</div>
				</div>
			<?php 
		}
	}
	
	public function getShown()
	{
		return $this->shown;
	}
	
	public function setShown($shown) {
		$this->shown = $shown;
	}
}
?>