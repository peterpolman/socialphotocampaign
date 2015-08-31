<?php /* Smarty version 2.6.26, created on 2013-07-30 10:25:39
         compiled from devtools/right/index.tpl */ ?>
<ul>
<?php $_from = $this->_tpl_vars['systems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['system']):
?>
	<li><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
devtools/right/modify/<?php echo $this->_tpl_vars['system']; ?>
">Beheer rechten voor: <?php echo $this->_tpl_vars['system']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>