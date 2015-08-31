{literal}<h1>{/literal}{$enkelvoud|ucfirst}{literal} toevoegen</h1>

<p><a href="{$secure_root}{$system}{/literal}/{$controllerfilename}{literal}">{/literal}{$meervoud|ucfirst}{literal} overzicht</a></p>

<p>Vul de onderstaande gegevens in om een nieuwe {/literal}{$enkelvoud}{literal} aan te maken. Wanneer u op de verzenden-knop drukt wordt de {/literal}{$enkelvoud}{literal} aangemaakt.</p>

<form method="post" action="">
	<table>
		{/literal}{foreach from=$fields key=myId item=i name=foo}{if $myId != 'id' && $myId != 'deleted'}<tr{if $smarty.foreach.foo.index % 2 == 0} class="odd"{/if}>
			<td>{$i}</td>
			<td>
				<input class="input" type="text" name="{$enkelvoud}[{$myId}]"{literal}{if isset(${/literal}{$enkelvoud}{literal})} value="{${/literal}{$enkelvoud}->get{$myId|ucfirst}(){literal}}"{/if}{/literal} />
			</td>
		</tr>
		{/if}
{/foreach}
{literal}
		<tr class="odd">
			<td colspan="2">
				<input type="submit" name="submit" value="Verzenden" />
			</td>
		</tr>
	</table>
</form>
{/literal}