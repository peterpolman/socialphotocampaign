<h1>Entries</h1>

<p><a href="{$secure_root}{$system}/entry/add">Voeg entry toe</a></p>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Status</th>
			<th>Published</th>
			<th>Image</th>
			<th>Name</th>
			<th>Description</th>
			<th>IP</th>
			<th>Date</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	
	<tbody>
		{foreach from=$entries->getResult() item=o key=k name=fieldthing}
			<tr onclick="window.location.href='{$secure_root}{$system}/entry/view/{$o->getId()}'">
            	<td>{$o->getId()}</td>
            	<td>{$o->getStatus()}</td>
            	<td>{if $o->getPublished()==1}Yes{else}No{/if}</td>
            	<td><img src="{$secure_root}files/small/{$o->getFilename()}"/></td>
            	<td>{$o->getFirst_name()} {$o->getLast_name()}</td>
            	<td>{$o->getDescription()|truncate:200}</td>
            	<td>{$o->getIp()}</td>
            	<td>{$o->getDate()}</td>
				<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;">
					<a href="{$secure_root}{$system}/entry/modify/{$o->getId()}">
						<img src="{$secure_root}cji/system/img/ui-row-edit.png">
					</a>
					<a onclick="return confirm('Weet u zeker dat u deze entry wilt verwijderen?')" href="{$secure_root}{$system}/entry/delete/{$o->getId()}">
						<img src="{$secure_root}cji/system/img/ui-row-delete.png">
					</a>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>

