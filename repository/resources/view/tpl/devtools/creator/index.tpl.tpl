{literal}<h1>{/literal}{$meervoud|ucfirst}{literal}</h1>

<p><a href="{$secure_root}{$system}{/literal}/{$controllerfilename}{literal}/add">Voeg {/literal}{$enkelvoud}{literal} toe</a></p>

<table>
	<thead>
		<tr>{/literal}{foreach from=$fields key=myId item=i name=foo}{if $myId != 'deleted' }{literal}
			<th>{/literal}{$i}</th>{/if}{/foreach}{literal}
			<th>&nbsp;</th>
		</tr>
	</thead>
	
	<tbody>
		{foreach from=${/literal}{$meervoud}{literal}->getResult() item=o key=k name=fieldthing}
			<tr onclick="window.location.href='{$secure_root}{$system}{/literal}/{$enkelvoud}{literal}/view/{$o->getId()}'">{/literal}{foreach from=$fields key=myId item=i name=foo}{if $myId != 'deleted'}{literal}
            	<td>{$o->get{/literal}{$myId|ucfirst}{literal}()}</td>{/literal}{/if}{/foreach}{literal}
				<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;">
					<a href="{$secure_root}{$system}{/literal}/{$controllerfilename}{literal}/modify/{$o->getId()}">
						<img src="{$secure_root}cji/img/ui-row-edit.png">
					</a>
					<a onclick="return confirm('Weet u zeker dat u deze {/literal}{$enkelvoud}{literal} wilt verwijderen?')" href="{$secure_root}{$system}{/literal}/{$controllerfilename}{literal}/delete/{$o->getId()}">
						<img src="{$secure_root}cji/img/ui-row-delete.png">
					</a>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>

{/literal}