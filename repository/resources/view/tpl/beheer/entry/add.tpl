<h1>Entry toevoegen</h1>

<p><a href="{$secure_root}{$system}/entry">Entries overzicht</a></p>

<p>Vul de onderstaande gegevens in om een nieuwe entry aan te maken. Wanneer u op de verzenden-knop drukt wordt de entry aangemaakt.</p>

<form method="post" action="">
	<table>
		<tr>
			<td>Status</td>
			<td>
				<input class="input" type="text" name="entry[status]"{if isset($entry)} value="{$entry->getStatus()}"{/if} />
			</td>
		</tr>
		<tr class="odd">
			<td>Filename</td>
			<td>
				<input class="input" type="text" name="entry[filename]"{if isset($entry)} value="{$entry->getFilename()}"{/if} />
			</td>
		</tr>
		<tr>
			<td>First name</td>
			<td>
				<input class="input" type="text" name="entry[first_name]"{if isset($entry)} value="{$entry->getFirst_name()}"{/if} />
			</td>
		</tr>
		<tr class="odd">
			<td>Last name</td>
			<td>
				<input class="input" type="text" name="entry[last_name]"{if isset($entry)} value="{$entry->getLast_name()}"{/if} />
			</td>
		</tr>
		<tr>
			<td>Description</td>
			<td>
				<input class="input" type="text" name="entry[description]"{if isset($entry)} value="{$entry->getDescription()}"{/if} />
			</td>
		</tr>
		<tr class="odd">
			<td>E-mail</td>
			<td>
				<input class="input" type="text" name="entry[email]"{if isset($entry)} value="{$entry->getEmail()}"{/if} />
			</td>
		</tr>
		<tr>
			<td>IP</td>
			<td>
				<input class="input" type="text" name="entry[ip]"{if isset($entry)} value="{$entry->getIp()}"{/if} />
			</td>
		</tr>
		<tr class="odd">
			<td>Newsletter</td>
			<td>
				<input class="input" type="text" name="entry[newsletter]"{if isset($entry)} value="{$entry->getNewsletter()}"{/if} />
			</td>
		</tr>
		<tr>
			<td>Street name</td>
			<td>
				<input class="input" type="text" name="entry[street_name]"{if isset($entry)} value="{$entry->getStreet_name()}"{/if} />
			</td>
		</tr>
		<tr class="odd">
			<td>Street number</td>
			<td>
				<input class="input" type="text" name="entry[street_number]"{if isset($entry)} value="{$entry->getStreet_number()}"{/if} />
			</td>
		</tr>
		<tr>
			<td>Postal code</td>
			<td>
				<input class="input" type="text" name="entry[postal_code]"{if isset($entry)} value="{$entry->getPostal_code()}"{/if} />
			</td>
		</tr>
		<tr class="odd">
			<td>Place</td>
			<td>
				<input class="input" type="text" name="entry[place]"{if isset($entry)} value="{$entry->getPlace()}"{/if} />
			</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>
				<input class="input" type="text" name="entry[date]"{if isset($entry)} value="{$entry->getDate()}"{/if} />
			</td>
		</tr>
		<tr class="odd">
			<td>Published</td>
			<td>
				<input class="input" type="text" name="entry[published]"{if isset($entry)} value="{$entry->getPublished()}"{/if} />
			</td>
		</tr>
		<tr>
			<td>Actiecode</td>
			<td>
				<input class="input" type="text" name="entry[actiecode]"{if isset($entry)} value="{$entry->getActiecode()}"{/if} />
			</td>
		</tr>
		
		<tr class="odd">
			<td colspan="2">
				<input type="submit" name="submit" value="Verzenden" />
			</td>
		</tr>
	</table>
</form>
