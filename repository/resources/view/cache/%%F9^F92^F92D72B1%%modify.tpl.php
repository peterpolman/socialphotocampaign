<?php /* Smarty version 2.6.26, created on 2013-07-30 10:26:10
         compiled from devtools/role/modify.tpl */ ?>
<p>Vul de onderstaande gegevens in om de role te bewerken. Wanneer u op de verzenden-knop drukt worden de veranderingen opgeslagen.</p>
<div class="separator"></div>
<div class="add-user">
	<form method="post" action="">
		<table width="300" cellspacing="0" cellpadding="5">
										  <tr><td width="25%">Role</td><td><input class="input" type="text" name="role[role]"  value="<?php echo $this->_tpl_vars['role']['role']; ?>
"></td></tr>
		 		
			<tr class="odd"><td colspan="2"><input class="button" type="submit" src="<?php echo $this->_tpl_vars['secure_root']; ?>
images/btn-verzenden.png" name="submit" value="Verzenden" ></td></tr>
		</table>
	</form>
</div>
<div class="separator"></div>