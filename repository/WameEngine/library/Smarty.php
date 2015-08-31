<?php
WE::include_dependency('Smarty/Smarty.class');

class WE_Smarty extends Smarty 
{
    public function trigger_error($error_msg, $error_type = E_USER_WARNING)
    {
        WE::include_library('Smarty/Exception');
        throw new WE_Smarty_Exception('Smarty error: '.$error_msg.' (Error type: '.$error_type.')');
    }
}

?>