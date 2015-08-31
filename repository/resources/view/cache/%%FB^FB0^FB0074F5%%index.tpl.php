<?php /* Smarty version 2.6.26, created on 2013-04-22 14:53:01
         compiled from beheer/entry/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'beheer/entry/index.tpl', 28, false),)), $this); ?>
<h1>Entries</h1>

<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/entry/add">Voeg entry toe</a></p>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Status</th>
			<th>Published</th>
			<th>Image</th>
			<th>Name</th>
			<th>Description</th>
			<th>IP</th>
			<th>Date</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	
	<tbody>
		<?php $_from = $this->_tpl_vars['entries']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fieldthing'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fieldthing']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['o']):
        $this->_foreach['fieldthing']['iteration']++;
?>
			<tr onclick="window.location.href='<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/entry/view/<?php echo $this->_tpl_vars['o']->getId(); ?>
'">
            	<td><?php echo $this->_tpl_vars['o']->getId(); ?>
</td>
            	<td><?php echo $this->_tpl_vars['o']->getStatus(); ?>
</td>
            	<td><?php if ($this->_tpl_vars['o']->getPublished() == 1): ?>Yes<?php else: ?>No<?php endif; ?></td>
            	<td><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
files/small/<?php echo $this->_tpl_vars['o']->getFilename(); ?>
"/></td>
            	<td><?php echo $this->_tpl_vars['o']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['o']->getLast_name(); ?>
</td>
            	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['o']->getDescription())) ? $this->_run_mod_handler('truncate', true, $_tmp, 200) : smarty_modifier_truncate($_tmp, 200)); ?>
</td>
            	<td><?php echo $this->_tpl_vars['o']->getIp(); ?>
</td>
            	<td><?php echo $this->_tpl_vars['o']->getDate(); ?>
</td>
				<td onclick="if (event.stopPropagation) { event.stopPropagation;} event.cancelBubble = true; return true;">
					<a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/entry/modify/<?php echo $this->_tpl_vars['o']->getId(); ?>
">
						<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/system/img/ui-row-edit.png">
					</a>
					<a onclick="return confirm('Weet u zeker dat u deze entry wilt verwijderen?')" href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/entry/delete/<?php echo $this->_tpl_vars['o']->getId(); ?>
">
						<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/system/img/ui-row-delete.png">
					</a>
				</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
