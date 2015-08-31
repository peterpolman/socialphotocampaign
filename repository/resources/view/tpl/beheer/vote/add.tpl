<h1>Vote toevoegen</h1>

<p><a href="{$secure_root}{$system}/vote">Votes overzicht</a></p>

<p>Vul de onderstaande gegevens in om een nieuwe vote aan te maken. Wanneer u op de verzenden-knop drukt wordt de vote aangemaakt.</p>

<form method="post" action="">
	<table>
		<tr>
			<td>Entry</td>
			<td>
				<input class="input" type="text" name="vote[entry]"{if isset($vote)} value="{$vote->getEntry()}"{/if} />
			</td>
		</tr>
		<tr class="odd">
			<td>IP</td>
			<td>
				<input class="input" type="text" name="vote[ip]"{if isset($vote)} value="{$vote->getIp()}"{/if} />
			</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>
				<input class="input" type="text" name="vote[date]"{if isset($vote)} value="{$vote->getDate()}"{/if} />
			</td>
		</tr>
		
		<tr class="odd">
			<td colspan="2">
				<input type="submit" name="submit" value="Verzenden" />
			</td>
		</tr>
	</table>
</form>
