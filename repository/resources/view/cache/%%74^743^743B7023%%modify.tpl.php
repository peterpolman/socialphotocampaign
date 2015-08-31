<?php /* Smarty version 2.6.26, created on 2013-04-22 14:53:04
         compiled from beheer/entry/modify.tpl */ ?>

<h1>Entry bewerken</h1>

<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/entry">Entries overzicht</a></p>

<p>Vul de onderstaande gegevens in om de entry te bewerken. Wanneer u op de verzenden-knop drukt worden de veranderingen opgeslagen.</p>

<form method="post" action="">
	<table>
		<tr>
			<td>Status</td>
			<td>
				<input class="input" type="text" name="entry[status]" value="<?php echo $this->_tpl_vars['entry']->getStatus(); ?>
" />
			</td>
		</tr>
		<tr class="odd">
			<td>Filename</td>
			<td>
				<input class="input" type="text" name="entry[filename]" value="<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
" />
			</td>
		</tr>
		<tr>
			<td>First name</td>
			<td>
				<input class="input" type="text" name="entry[first_name]" value="<?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
" />
			</td>
		</tr>
		<tr class="odd">
			<td>Last name</td>
			<td>
				<input class="input" type="text" name="entry[last_name]" value="<?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
" />
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<input class="input" type="text" name="entry[description]" value="<?php echo $this->_tpl_vars['entry']->getDescription(); ?>
" />
			</td>
		</tr>
		<tr class="odd">
			<td>E-mail</td>
			<td>
				<input class="input" type="text" name="entry[email]" value="<?php echo $this->_tpl_vars['entry']->getEmail(); ?>
" />
			</td>
		</tr>
		<tr>
			<td>IP</td>
			<td>
				<input class="input" type="text" name="entry[ip]" value="<?php echo $this->_tpl_vars['entry']->getIp(); ?>
" />
			</td>
		</tr>
		<tr class="odd">
			<td>Newsletter</td>
			<td>
				<input class="input" type="text" name="entry[newsletter]" value="<?php echo $this->_tpl_vars['entry']->getNewsletter(); ?>
" />
			</td>
		</tr>
		<tr>
			<td>Street name</td>
			<td>
				<input class="input" type="text" name="entry[street_name]" value="<?php echo $this->_tpl_vars['entry']->getStreet_name(); ?>
" />
			</td>
		</tr>
		<tr class="odd">
			<td>Street number</td>
			<td>
				<input class="input" type="text" name="entry[street_number]" value="<?php echo $this->_tpl_vars['entry']->getStreet_number(); ?>
" />
			</td>
		</tr>
		<tr>
			<td>Postal code</td>
			<td>
				<input class="input" type="text" name="entry[postal_code]" value="<?php echo $this->_tpl_vars['entry']->getPostal_code(); ?>
" />
			</td>
		</tr>
		<tr class="odd">
			<td>Place</td>
			<td>
				<input class="input" type="text" name="entry[place]" value="<?php echo $this->_tpl_vars['entry']->getPlace(); ?>
" />
			</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>
				<input class="input" type="text" name="entry[date]" value="<?php echo $this->_tpl_vars['entry']->getDate(); ?>
" />
			</td>
		</tr>
		<tr class="odd">
			<td>Published</td>
			<td>
				<input class="input" type="text" name="entry[published]" value="<?php echo $this->_tpl_vars['entry']->getPublished(); ?>
" />
			</td>
		</tr>
		<tr>
			<td>Actiecode</td>
			<td>
				<input class="input" type="text" name="entry[actiecode]" value="<?php echo $this->_tpl_vars['entry']->getActiecode(); ?>
" />
			</td>
		</tr>
		
		<tr class="odd">
			<td colspan="2">
				<input class="button" type="submit" src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/btn-verzenden.png" name="submit" value="Verzenden" />
			</td>
		</tr>
	</table>
</form>
