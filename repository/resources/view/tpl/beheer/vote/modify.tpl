
<h1>Vote bewerken</h1>

<p><a href="{$secure_root}{$system}/vote">Votes overzicht</a></p>

<p>Vul de onderstaande gegevens in om de vote te bewerken. Wanneer u op de verzenden-knop drukt worden de veranderingen opgeslagen.</p>

<form method="post" action="">
	<table>
		<tr>
			<td>Entry</td>
			<td>
				<input class="input" type="text" name="vote[entry]" value="{$vote->getEntry()}" />
			</td>
		</tr>
		<tr class="odd">
			<td>IP</td>
			<td>
				<input class="input" type="text" name="vote[ip]" value="{$vote->getIp()}" />
			</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>
				<input class="input" type="text" name="vote[date]" value="{$vote->getDate()}" />
			</td>
		</tr>
		
		<tr class="odd">
			<td colspan="2">
				<input class="button" type="submit" src="{$secure_root}cji/img/btn-verzenden.png" name="submit" value="Verzenden" />
			</td>
		</tr>
	</table>
</form>

