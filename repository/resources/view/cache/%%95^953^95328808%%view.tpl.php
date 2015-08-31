<?php /* Smarty version 2.6.26, created on 2013-04-23 09:33:52
         compiled from beheer/entry/view.tpl */ ?>
<h1>Entry gegevens</h1>

<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/entry">Entries overzicht</a></p>

<table>
	<tr>
		<td>Status</td>
		<td><?php echo $this->_tpl_vars['entry']->getStatus(); ?>
</td>
	</tr>
	<tr class="odd">
		<td>Filename</td>
		<td><?php echo $this->_tpl_vars['entry']->getFilename(); ?>
</td>
	</tr>
	<tr>
		<td>First name</td>
		<td><?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
</td>
	</tr>
	<tr class="odd">
		<td>Last name</td>
		<td><?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
</td>
	</tr>
	<tr>
		<td>Description</td>
		<td><?php echo $this->_tpl_vars['entry']->getDescription(); ?>
</td>
	</tr>
	<tr class="odd">
		<td>E-mail</td>
		<td><?php echo $this->_tpl_vars['entry']->getEmail(); ?>
</td>
	</tr>
	<tr>
		<td>IP</td>
		<td><?php echo $this->_tpl_vars['entry']->getIp(); ?>
</td>
	</tr>
	<tr class="odd">
		<td>Newsletter</td>
		<td><?php echo $this->_tpl_vars['entry']->getNewsletter(); ?>
</td>
	</tr>
	<tr>
		<td>Street name</td>
		<td><?php echo $this->_tpl_vars['entry']->getStreet_name(); ?>
</td>
	</tr>
	<tr class="odd">
		<td>Street number</td>
		<td><?php echo $this->_tpl_vars['entry']->getStreet_number(); ?>
</td>
	</tr>
	<tr>
		<td>Postal code</td>
		<td><?php echo $this->_tpl_vars['entry']->getPostal_code(); ?>
</td>
	</tr>
	<tr class="odd">
		<td>Place</td>
		<td><?php echo $this->_tpl_vars['entry']->getPlace(); ?>
</td>
	</tr>
	<tr>
		<td>Date</td>
		<td><?php echo $this->_tpl_vars['entry']->getDate(); ?>
</td>
	</tr>
	<tr>
		<td>Published</td>
		<td><?php echo $this->_tpl_vars['entry']->getPublished(); ?>
</td>
	</tr>
	<tr>
		<td>Actiecode</td>
		<td><?php echo $this->_tpl_vars['entry']->getActiecode(); ?>
</td>
	</tr>
</table>