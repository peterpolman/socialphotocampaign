<?php

function WE_Smarty_load_action ($params, &$smarty)
{
	$fc = WE_Controller_Front::getInstance();
	
	if (!isset($params['controller']))
	{
		WE::include_library('Smarty/Helpers/Exception');
		throw new WE_Smarty_Helpers_Exception('WE_Smarty_load_action error: no controller name given');
	}
	
	if (!isset($params['action']))
	{
		WE::include_library('Smarty/Helpers/Exception');
		throw new WE_Smarty_Helpers_Exception('WE_Smarty_load_action error: no action name given');
	}
	
	try 
	{
		echo $fc->dispatch($params['controller'],$params['action']);
	}
	catch (WE_Controller_Front_Exception $e)
	{
		WE::include_library('Smarty/Helpers/Exception');
		throw new WE_Smarty_Helpers_Exception('WE_Smarty_load_action error: '.$e->getMessage());
	}	
}

function WE_Smarty_url ($params, &$smarty)
{
	if (!isset($params['href']))
	{
		WE::include_library('Smarty/Helpers/Exception');
		throw new WE_Smarty_Helpers_Exception('WE_Smarty_url error: no href given');
	}
	
	echo str_replace('&', '&amp;', $params['href']);
}

function WE_has_access ($params, WE_Smarty &$smarty)
{	

	if (isset($params['s']) && isset($params['c']) && isset($params['a'])) {
		if (isset($params['assign'])) {
			$smarty->assign($params['assign'], WE_Access::getInstance()->hasAccess($params['s'],$params['c'], $params['a']));
			return null;
		} else {
			return WE_Access::getInstance()->hasAccess($params['s'],$params['c'], $params['a']);
		}
	} else {
		if (isset($params['assign'])) {
			$smarty->assign($params['assign'], null);
		} else {
			return null;
		}
	}
}

function Smarty_Encrypt ($params, WE_Smarty &$smarty) {
	if(!empty($params['value']) || $params['value'] == 0) {
		return Helper::encrypt($params['value']);
	} else {
		return false;
	}
}

function Smarty_Decrypt ($params, WE_Smarty &$smarty) {
	if(!empty($params['value'])) {
		return Helper::decrypt($params['value']);
	} else {
		return false;
	}
}
?>