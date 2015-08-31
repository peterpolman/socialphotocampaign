<?php /* Smarty version 2.6.26, created on 2013-05-07 12:41:11
         compiled from beheer/entry/add.tpl */ ?>
<h1>Entry toevoegen</h1>

<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/entry">Entries overzicht</a></p>

<p>Vul de onderstaande gegevens in om een nieuwe entry aan te maken. Wanneer u op de verzenden-knop drukt wordt de entry aangemaakt.</p>

<form method="post" action="">
	<table>
		<tr>
			<td>Status</td>
			<td>
				<input class="input" type="text" name="entry[status]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getStatus(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr class="odd">
			<td>Filename</td>
			<td>
				<input class="input" type="text" name="entry[filename]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr>
			<td>First name</td>
			<td>
				<input class="input" type="text" name="entry[first_name]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr class="odd">
			<td>Last name</td>
			<td>
				<input class="input" type="text" name="entry[last_name]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<input class="input" type="text" name="entry[description]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getDescription(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr class="odd">
			<td>E-mail</td>
			<td>
				<input class="input" type="text" name="entry[email]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getEmail(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr>
			<td>IP</td>
			<td>
				<input class="input" type="text" name="entry[ip]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getIp(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr class="odd">
			<td>Newsletter</td>
			<td>
				<input class="input" type="text" name="entry[newsletter]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getNewsletter(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr>
			<td>Street name</td>
			<td>
				<input class="input" type="text" name="entry[street_name]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getStreet_name(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr class="odd">
			<td>Street number</td>
			<td>
				<input class="input" type="text" name="entry[street_number]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getStreet_number(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr>
			<td>Postal code</td>
			<td>
				<input class="input" type="text" name="entry[postal_code]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getPostal_code(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr class="odd">
			<td>Place</td>
			<td>
				<input class="input" type="text" name="entry[place]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getPlace(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>
				<input class="input" type="text" name="entry[date]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getDate(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr class="odd">
			<td>Published</td>
			<td>
				<input class="input" type="text" name="entry[published]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getPublished(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		<tr>
			<td>Actiecode</td>
			<td>
				<input class="input" type="text" name="entry[actiecode]"<?php if (isset ( $this->_tpl_vars['entry'] )): ?> value="<?php echo $this->_tpl_vars['entry']->getActiecode(); ?>
"<?php endif; ?> />
			</td>
		</tr>
		
		<tr class="odd">
			<td colspan="2">
				<input type="submit" name="submit" value="Verzenden" />
			</td>
		</tr>
	</table>
</form>