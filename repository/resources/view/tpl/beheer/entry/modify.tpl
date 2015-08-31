
<h1>Entry bewerken</h1>

<p><a href="{$secure_root}{$system}/entry">Entries overzicht</a></p>

<p>Vul de onderstaande gegevens in om de entry te bewerken. Wanneer u op de verzenden-knop drukt worden de veranderingen opgeslagen.</p>

<form method="post" action="">
	<table>
		<tr>
			<td>Status</td>
			<td>
				<input class="input" type="text" name="entry[status]" value="{$entry->getStatus()}" />
			</td>
		</tr>
		<tr class="odd">
			<td>Filename</td>
			<td>
				<input class="input" type="text" name="entry[filename]" value="{$entry->getFilename()}" />
			</td>
		</tr>
		<tr>
			<td>First name</td>
			<td>
				<input class="input" type="text" name="entry[first_name]" value="{$entry->getFirst_name()}" />
			</td>
		</tr>
		<tr class="odd">
			<td>Last name</td>
			<td>
				<input class="input" type="text" name="entry[last_name]" value="{$entry->getLast_name()}" />
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<input class="input" type="text" name="entry[description]" value="{$entry->getDescription()}" />
			</td>
		</tr>
		<tr class="odd">
			<td>E-mail</td>
			<td>
				<input class="input" type="text" name="entry[email]" value="{$entry->getEmail()}" />
			</td>
		</tr>
		<tr>
			<td>IP</td>
			<td>
				<input class="input" type="text" name="entry[ip]" value="{$entry->getIp()}" />
			</td>
		</tr>
		<tr class="odd">
			<td>Newsletter</td>
			<td>
				<input class="input" type="text" name="entry[newsletter]" value="{$entry->getNewsletter()}" />
			</td>
		</tr>
		<tr>
			<td>Street name</td>
			<td>
				<input class="input" type="text" name="entry[street_name]" value="{$entry->getStreet_name()}" />
			</td>
		</tr>
		<tr class="odd">
			<td>Street number</td>
			<td>
				<input class="input" type="text" name="entry[street_number]" value="{$entry->getStreet_number()}" />
			</td>
		</tr>
		<tr>
			<td>Postal code</td>
			<td>
				<input class="input" type="text" name="entry[postal_code]" value="{$entry->getPostal_code()}" />
			</td>
		</tr>
		<tr class="odd">
			<td>Place</td>
			<td>
				<input class="input" type="text" name="entry[place]" value="{$entry->getPlace()}" />
			</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>
				<input class="input" type="text" name="entry[date]" value="{$entry->getDate()}" />
			</td>
		</tr>
		<tr class="odd">
			<td>Published</td>
			<td>
				<input class="input" type="text" name="entry[published]" value="{$entry->getPublished()}" />
			</td>
		</tr>
		<tr>
			<td>Actiecode</td>
			<td>
				<input class="input" type="text" name="entry[actiecode]" value="{$entry->getActiecode()}" />
			</td>
		</tr>
		
		<tr class="odd">
			<td colspan="2">
				<input class="button" type="submit" src="{$secure_root}cji/img/btn-verzenden.png" name="submit" value="Verzenden" />
			</td>
		</tr>
	</table>
</form>

