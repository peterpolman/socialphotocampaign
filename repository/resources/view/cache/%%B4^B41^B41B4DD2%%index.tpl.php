<?php /* Smarty version 2.6.26, created on 2013-03-25 07:17:28
         compiled from devtools/user/index.tpl */ ?>
<div class="highlight">
	<div class="demo_jui">
		<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/user/add"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
/cji/system/img/button_add.png" align="absmiddle" height="24px" /> Gebruiker toevoegen</a></p><br/>
	    <table cellpadding="0" cellspacing="0" border="0" id="datatable1" class="display" >
	        <thead>
	            <tr>
					<th>Username</th>
					<th>Role</th>
					<th> </th>
	            </tr>
	        </thead>
	
	        <tbody>
	        <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fieldthing'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fieldthing']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['o']):
        $this->_foreach['fieldthing']['iteration']++;
?>
	            <tr class="gradeA" onclick="window.location.href='<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/user/view/<?php echo $this->_tpl_vars['o']['id']; ?>
'">
			 		<td><?php echo $this->_tpl_vars['o']['username']; ?>
</td>
			 		<td><?php echo $this->_tpl_vars['o']['role']; ?>
</td>
					<td onclick="if (event.stopPropagation) { event.stopPropagation;} event.cancelBubble = true; return true;"><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/user/modify/<?php echo $this->_tpl_vars['o']['id']; ?>
"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/ui-row-edit.png"></a> <a onclick="show_confirm('<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/user/delete/<?php echo $this->_tpl_vars['o']['id']; ?>
', '<?php echo $this->_tpl_vars['o']['username']; ?>
')" href="#"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/ui-row-delete.png"></a></td>
	            </tr>
	            <?php endforeach; endif; unset($_from); ?>
	        </tbody>
	    </table>
	</div>
</div>