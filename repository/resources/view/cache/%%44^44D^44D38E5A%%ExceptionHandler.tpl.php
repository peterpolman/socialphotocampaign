<?php /* Smarty version 2.6.26, created on 2013-03-25 07:17:10
         compiled from system/exception/ExceptionHandler.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'system/exception/ExceptionHandler.tpl', 6, false),)), $this); ?>
<?php echo $this->_tpl_vars['header']; ?>

<div style="background-color:#DDD;border: 1px solid #000; margin:5px; padding:5px;">
<h2>DEBUG MODUS: <?php echo $this->_tpl_vars['message']; ?>
</h2>
<hr>
<pre style="white-space:pre-wrap">
<?php echo ((is_array($_tmp=$this->_tpl_vars['error'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

</pre>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['system'])."/layout/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>