{literal}<h1>{/literal}{$enkelvoud|ucfirst}{literal} gegevens</h1>

<p><a href="{$secure_root}{$system}{/literal}/{$controllerfilename}{literal}">{/literal}{$meervoud|ucfirst}{literal} overzicht</a></p>

<table>{/literal}
{foreach from=$fields key=myId item=i name=foo}{if $myId != 'id' && $myId != 'deleted'}
	<tr{if $smarty.foreach.foo.index % 2 == 0} class="odd"{/if}>
		<td>{$i}</td>
		<td>{literal}{${/literal}{$enkelvoud}->get{$myId|ucfirst}(){literal}}{/literal}</td>
	</tr>
{/if}{/foreach}{literal}</table>
{/literal}