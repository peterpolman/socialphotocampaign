{literal}
<h1>{/literal}{$enkelvoud|ucfirst}{literal} bewerken</h1>

<p><a href="{$secure_root}{/literal}{$system}/{$controllerfilename}{literal}">{/literal}{$meervoud|ucfirst}{literal} overzicht</a></p>

<p>Vul de onderstaande gegevens in om de {/literal}{$enkelvoud}{literal} te bewerken. Wanneer u op de verzenden-knop drukt worden de veranderingen opgeslagen.</p>

<form method="post" action="">
	<table>{/literal}
		{foreach from=$fields key=myId item=i name=foo}{if $myId != 'id' && $myId != 'deleted'}<tr{if $smarty.foreach.foo.index % 2 == 0} class="odd"{/if}>
			<td>{$i}</td>
			<td>
				<input class="input" type="text" name="{$enkelvoud}[{$myId}]" value="{literal}{${/literal}{$enkelvoud}->get{$myId|ucfirst}(){literal}}{/literal}" />
			</td>
		</tr>
		{/if}{/foreach}{literal}
		<tr class="odd">
			<td colspan="2">
				<input class="button" type="submit" src="{$secure_root}cji/img/btn-verzenden.png" name="submit" value="Verzenden" />
			</td>
		</tr>
	</table>
</form>

{/literal}