<?php /* Smarty version 2.6.26, created on 2013-03-25 07:18:51
         compiled from beheer/vote/index.tpl */ ?>
<h1>Votes</h1>

<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/vote/add">Voeg vote toe</a></p>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Entry</th>
			<th>IP</th>
			<th>Date</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	
	<tbody>
		<?php $_from = $this->_tpl_vars['votes']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fieldthing'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fieldthing']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['o']):
        $this->_foreach['fieldthing']['iteration']++;
?>
			<tr onclick="window.location.href='<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/vote/view/<?php echo $this->_tpl_vars['o']->getId(); ?>
'">
            	<td><?php echo $this->_tpl_vars['o']->getId(); ?>
</td>
            	<td><?php echo $this->_tpl_vars['o']->getEntry(); ?>
</td>
            	<td><?php echo $this->_tpl_vars['o']->getIp(); ?>
</td>
            	<td><?php echo $this->_tpl_vars['o']->getDate(); ?>
</td>
				<td onclick="if (event.stopPropagation) { event.stopPropagation;} event.cancelBubble = true; return true;">
					<a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/vote/modify/<?php echo $this->_tpl_vars['o']->getId(); ?>
">
						<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/system/img/ui-row-edit.png">
					</a>
					<a onclick="return confirm('Weet u zeker dat u deze vote wilt verwijderen?')" href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/vote/delete/<?php echo $this->_tpl_vars['o']->getId(); ?>
">
						<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/system/img/ui-row-delete.png">
					</a>
				</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
