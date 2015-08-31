<?php /* Smarty version 2.6.26, created on 2013-03-18 10:44:50
         compiled from devtools/right/modify.tpl */ ?>
<script type="text/javascript">
<?php echo '
$(function() {
$(\'input[type="checkbox"]\').each(function() {
    if ($(this).is(\':checked\')) {
        $(this).parent().css(\'background\', \'#00dd00\');
    }
    else {
        $(this).parent().css(\'background\', \'#ffffff\');
    }
    $(this).click(function() {
        if ($(this).is(\':checked\')) {
            $(this).parent().css(\'background\', \'#00dd00\');
        }
        else {
            $(this).parent().css(\'background\', \'#ffffff\');
        }
    });
});
});
'; ?>

</script>
<form method="post" action="">
<table>

<?php $_from = $this->_tpl_vars['controllers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ckey'] => $this->_tpl_vars['controller']):
?>
<tr style="background-color:#aaa;">
	<th align="left"><?php echo $this->_tpl_vars['ckey']; ?>
</th>
	<?php $_from = $this->_tpl_vars['roles']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['role']):
?>
		<th><?php echo $this->_tpl_vars['role']->role; ?>
</th>
	<?php endforeach; endif; unset($_from); ?>
</tr>
	<?php $_from = $this->_tpl_vars['controller']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['control']):
?>
	<?php if (is_numeric ( $this->_tpl_vars['k'] )): ?>
		<tr height="36px">
			<td><?php echo $this->_tpl_vars['control']; ?>
</td>
			<?php $_from = $this->_tpl_vars['roles']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['role']):
?>
				<?php if ($this->_tpl_vars['controller']['public']): ?>
					<td align="center" style="background-color:#00dd00">Public</td>
				<?php else: ?>
					<?php $this->assign('roleid', $this->_tpl_vars['role']->id); ?>
					<td align="center"><input type="checkbox" name="right[<?php echo $this->_tpl_vars['ckey']; ?>
][<?php echo $this->_tpl_vars['control']; ?>
][<?php echo $this->_tpl_vars['role']->id; ?>
]" value="1" <?php if (isset ( $this->_tpl_vars['rights'][$this->_tpl_vars['ckey']][$this->_tpl_vars['control']][$this->_tpl_vars['roleid']] ) && $this->_tpl_vars['rights'][$this->_tpl_vars['ckey']][$this->_tpl_vars['control']][$this->_tpl_vars['roleid']] == 1): ?>checked="checked" <?php endif; ?>/></td>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>

</table>

<input name="submit" value="Opslaan" type="submit">
</form>