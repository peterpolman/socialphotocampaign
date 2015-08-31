<h1>God Complex</h1>
<h2>Tabel: {$controllerfilename}</h2>
<div class="separator"></div>
<form method="post" action="">
	
<div class="add-user">

		<table width="300" cellspacing="0" cellpadding="5">
			<tr><td width="25%">Controllername (default):</td>		<td><input class="input" type="text" name="controller[controllername]" value="{$controllerfilename|ucfirst}"></td></tr>
			<tr class="odd"><td>Meervoud (tpl, controller):</td>	<td><input class="input" type="text" name="controller[meervoud]" value="{$controllerfilename}en"></td></tr>
			<tr><td>Meervoud in teksten:</td>						<td><input class="input" type="text" name="controller[meervoudtext]" value="{$controllerfilename}en"></td></tr>
			<tr class="odd"><td>Meervoud (tpl, controller):</td>	<td><input class="input" type="text" name="controller[enkelvoud]" value="{$controllerfilename}"></td></tr>
			<tr><td>Meervoud in teksten:</td>						<td><input class="input" type="text" name="controller[enkelvoudtext]" value="{$controllerfilename}"></td></tr>
			
			
			{foreach from=$fields key=myId item=i name=foo}
				{if $myId != 'deleted' && $myId != 'id'}
				  <tr><td><b>{$myId}</b></td><td><input class="input" type="text" name="velden[{$myId}]" value="{$i}"></td></th>
			 	{/if}
			{/foreach}
			
			<tr><td>Wegschrijven indien mogelijk:</td>				<td><input class="checkbox" type="checkbox" name="output" value="true"></td></tr>
			<tr class="odd"><td colspan="2"><input class="button" type="submit" src="{$secure_root}images/btn-verzenden.png" name="submit" value="Verzenden" ></td></tr>
		</table>

</div>


</form>
<div class="separator"></div>
<input class="button" type="submit" value="Opslaan">
