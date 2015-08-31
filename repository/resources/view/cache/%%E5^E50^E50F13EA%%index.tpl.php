<?php /* Smarty version 2.6.26, created on 2013-07-30 10:25:43
         compiled from devtools/role/index.tpl */ ?>
	<?php if (isset ( $this->_tpl_vars['archive'] ) && $this->_tpl_vars['archive'] == true): ?>
	<div class="icon">
		<a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/role/archive" class="content">
			<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
images/icons/ui-archive-client.png" alt="Roles Archief" />
			<br />Roles Archief
		</a>
	</div><?php endif; ?>

<div class="highlight">
	<div class="demo_jui">
	    <table cellpadding="0" cellspacing="0" border="0" id="datatable1" class="display" >
	        <thead>
	            <tr>
					<th>Id</th>
				 	<th>Role</th>							
					<th>&nbsp;</th>
	            </tr>
	        </thead>
	
	        <tbody>
	        <?php $_from = $this->_tpl_vars['roles']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fieldthing'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fieldthing']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['o']):
        $this->_foreach['fieldthing']['iteration']++;
?>
	            <tr class="gradeA" onclick="window.location.href='<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/role/view/<?php echo $this->_tpl_vars['o']->id; ?>
'">
					<td><?php echo $this->_tpl_vars['o']->id; ?>
</td>
 					<td><?php echo $this->_tpl_vars['o']->role; ?>
</td>	
					<td onclick="if (event.stopPropagation) { event.stopPropagation;} event.cancelBubble = true; return true;"><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/role/modify/<?php echo $this->_tpl_vars['o']->id; ?>
"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/ui-row-edit.png"></a> <a onclick="show_confirm('<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/role/delete/<?php echo $this->_tpl_vars['o']->id; ?>
', '<?php echo $this->_tpl_vars['o']->role; ?>
')" href="#"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/ui-row-delete.png"></a></td>
	            </tr>
	            <?php endforeach; endif; unset($_from); ?>
	        </tbody>
	    </table>
	</div>
</div>