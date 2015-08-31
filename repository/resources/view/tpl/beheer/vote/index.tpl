<h1>Votes</h1>

<p><a href="{$secure_root}{$system}/vote/add">Voeg vote toe</a></p>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Entry</th>
			<th>IP</th>
			<th>Date</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	
	<tbody>
		{foreach from=$votes->getResult() item=o key=k name=fieldthing}
			<tr onclick="window.location.href='{$secure_root}{$system}/vote/view/{$o->getId()}'">
            	<td>{$o->getId()}</td>
            	<td>{$o->getEntry()}</td>
            	<td>{$o->getIp()}</td>
            	<td>{$o->getDate()}</td>
				<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;">
					<a href="{$secure_root}{$system}/vote/modify/{$o->getId()}">
						<img src="{$secure_root}cji/system/img/ui-row-edit.png">
					</a>
					<a onclick="return confirm('Weet u zeker dat u deze vote wilt verwijderen?')" href="{$secure_root}{$system}/vote/delete/{$o->getId()}">
						<img src="{$secure_root}cji/system/img/ui-row-delete.png">
					</a>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>

