<h1>Vote gegevens</h1>

<p><a href="{$secure_root}{$system}/vote">Votes overzicht</a></p>

<table>
	<tr>
		<td>Entry</td>
		<td>{$vote->getEntry()}</td>
	</tr>
	<tr class="odd">
		<td>IP</td>
		<td>{$vote->getIp()}</td>
	</tr>
	<tr>
		<td>Date</td>
		<td>{$vote->getDate()}</td>
	</tr>
</table>
