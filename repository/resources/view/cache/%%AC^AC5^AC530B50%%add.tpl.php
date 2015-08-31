<?php /* Smarty version 2.6.26, created on 2013-03-25 07:17:30
         compiled from devtools/user/add.tpl */ ?>
<p>Vul de onderstaande gegevens in om een nieuwe user aan te maken. Wanneer u op de verzenden-knop drukt wordt de user aangemaakt.</p>
<div class="separator"></div>
<div class="add-user">
	<form method="post" action="">
		<table width="300" cellspacing="0" cellpadding="5">
			<tr class="odd">
				<th width="25%" colspan="2">Systeem informatie</th>
			</tr>
			<tr>
				<td>E-mail:</td>
				<td><input class="input" type="text" name="user[username]"></td>
			</tr>
			<tr class="odd">
				<td>Password</td>
				<td><input class="input" type="text" name="user[password]"></td>
			</tr>
			<tr>
				<td width="25%">Role</td>
				<td><select name="user[role]">
					<?php $_from = $this->_tpl_vars['roles']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['thisrole']):
?>
						<option value="<?php echo $this->_tpl_vars['thisrole']->id; ?>
"><?php echo $this->_tpl_vars['thisrole']->role; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select></td>
			</tr>
			<tr class="odd">
				<th width="25%" colspan="2">Gebruiker informatie</th>
			</tr>
			<tr>
				<td>Voornaam</td>
				<td><input class="input" type="text" name="userdata[voornaam]"></td>
			</tr>
			<tr class="odd">
				<td>Tussenvoegsel</td>
				<td><input class="input" type="text" name="userdata[tussenvoegsel]"></td>
			</tr>
			<tr>
				<td>Achternaam</td>
				<td><input class="input" type="text" name="userdata[achternaam]"></td>
			</tr>
			<tr>
				<td>iPad Id</td>
				<td><input class="input" type="text" name="userdata[ipad_id]"></td>
			</tr>
			<tr class="odd">
				<td colspan="2"><input class="button" type="submit" src="<?php echo $this->_tpl_vars['secure_root']; ?>
images/btn-verzenden.png" name="submit" value="Verzenden"></td>
			</tr>
		</table>
	</form>
</div>
<div class="separator"></div>