<?php /* Smarty version 2.6.26, created on 2014-01-16 08:56:57
         compiled from beheer/vote/modify.tpl */ ?>

<h1>Vote bewerken</h1>

<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/vote">Votes overzicht</a></p>

<p>Vul de onderstaande gegevens in om de vote te bewerken. Wanneer u op de verzenden-knop drukt worden de veranderingen opgeslagen.</p>

<form method="post" action="">
	<table>
		<tr>
			<td>Entry</td>
			<td>
				<input class="input" type="text" name="vote[entry]" value="<?php echo $this->_tpl_vars['vote']->getEntry(); ?>
" />
			</td>
		</tr>
		<tr class="odd">
			<td>IP</td>
			<td>
				<input class="input" type="text" name="vote[ip]" value="<?php echo $this->_tpl_vars['vote']->getIp(); ?>
" />
			</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>
				<input class="input" type="text" name="vote[date]" value="<?php echo $this->_tpl_vars['vote']->getDate(); ?>
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
