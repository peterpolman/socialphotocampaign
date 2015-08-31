<p>Vul de onderstaande gegevens in om de user te bewerken. Wanneer u op
	de verzenden-knop drukt worden de veranderingen opgeslagen.</p>
<div class="separator"></div>
<div class="add-user">
	<form method="post" action="">
		<table width="300" cellspacing="0" cellpadding="5">
			<tr class="odd">
				<th width="25%" colspan="2">Systeem informatie</th>
			</tr>
			<tr>
				<td>Username</td>
				<td><input class="input" type="text" name="user[username]" value="{$user.username}"></td>
			</tr>
			<tr class="odd">
				<td valign="top">Password</td>
				<td><input class="input" type="text" name="user[password]"><br/>(Leeg laten om niet te wijzigen)</td>
			</tr>
			<tr>
				<td width="25%">Role</td>
				<td><select name="user[role]">
					{foreach from=$roles->getResult() item=thisrole}
						<option value="{$thisrole->id}" {if $thisrole->id == $role.id}selected="selected"{/if}>{$thisrole->role}</option>
					{/foreach}
				</select></td>
			</tr>
			<tr class="odd">
				<th width="25%" colspan="2">Gebruiker informatie</th>
			</tr>
			<tr>
				<td>Voornaam</td>
				<td><input class="input" type="text" name="userdata[voornaam]" value="{$userdata.voornaam}"></td>
			</tr>
			<tr class="odd">
				<td>Tussenvoegsel</td>
				<td><input class="input" type="text" name="userdata[tussenvoegsel]" value="{$userdata.tussenvoegsel}"></td>
			</tr>
			<tr>
				<td>Achternaam</td>
				<td><input class="input" type="text" name="userdata[achternaam]" value="{$userdata.achternaam}"></td>
			</tr>
			<tr>
				<td>iPad Id</td>
				<td><input class="input" type="text" name="userdata[ipad_id]"></td>
			</tr>
			<tr class="odd">
				<td colspan="2"><input class="button" type="submit" src="{$secure_root}images/btn-verzenden.png" name="submit" value="Verzenden"></td>
			</tr>
		</table>
	</form>
</div>
<div class="separator"></div>
