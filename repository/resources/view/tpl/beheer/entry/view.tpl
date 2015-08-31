<h1>Entry gegevens</h1>

<p><a href="{$secure_root}{$system}/entry">Entries overzicht</a></p>

<table>
	<tr>
		<td>Status</td>
		<td>{$entry->getStatus()}</td>
	</tr>
	<tr class="odd">
		<td>Filename</td>
		<td>{$entry->getFilename()}</td>
	</tr>
	<tr>
		<td>First name</td>
		<td>{$entry->getFirst_name()}</td>
	</tr>
	<tr class="odd">
		<td>Last name</td>
		<td>{$entry->getLast_name()}</td>
	</tr>
	<tr>
		<td>Description</td>
		<td>{$entry->getDescription()}</td>
	</tr>
	<tr class="odd">
		<td>E-mail</td>
		<td>{$entry->getEmail()}</td>
	</tr>
	<tr>
		<td>IP</td>
		<td>{$entry->getIp()}</td>
	</tr>
	<tr class="odd">
		<td>Newsletter</td>
		<td>{$entry->getNewsletter()}</td>
	</tr>
	<tr>
		<td>Street name</td>
		<td>{$entry->getStreet_name()}</td>
	</tr>
	<tr class="odd">
		<td>Street number</td>
		<td>{$entry->getStreet_number()}</td>
	</tr>
	<tr>
		<td>Postal code</td>
		<td>{$entry->getPostal_code()}</td>
	</tr>
	<tr class="odd">
		<td>Place</td>
		<td>{$entry->getPlace()}</td>
	</tr>
	<tr>
		<td>Date</td>
		<td>{$entry->getDate()}</td>
	</tr>
	<tr>
		<td>Published</td>
		<td>{$entry->getPublished()}</td>
	</tr>
	<tr>
		<td>Actiecode</td>
		<td>{$entry->getActiecode()}</td>
	</tr>
</table>
