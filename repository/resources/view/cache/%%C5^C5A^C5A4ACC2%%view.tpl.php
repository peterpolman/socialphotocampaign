<?php /* Smarty version 2.6.26, created on 2013-06-12 19:48:34
         compiled from beheer/vote/view.tpl */ ?>
<h1>Vote gegevens</h1>

<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/vote">Votes overzicht</a></p>

<table>
	<tr>
		<td>Entry</td>
		<td><?php echo $this->_tpl_vars['vote']->getEntry(); ?>
</td>
	</tr>
	<tr class="odd">
		<td>IP</td>
		<td><?php echo $this->_tpl_vars['vote']->getIp(); ?>
</td>
	</tr>
	<tr>
		<td>Date</td>
		<td><?php echo $this->_tpl_vars['vote']->getDate(); ?>
</td>
	</tr>
</table>