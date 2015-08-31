{literal}
<h1>Gearchiveerde {/literal}{$meervoud|ucfirst}{literal}</h1>
<div class="highlight">
	<div class="demo_jui">
	    <table cellpadding="0" cellspacing="0" border="0" id="datatable1" class="display" >
	        <thead>
	            <tr>{/literal}
				{foreach from=$fields key=myId item=i name=foo}
					{if $myId != 'deleted' }
					  <th>{$i}</th>
				 	{/if}
				{/foreach}{literal}
				 <th>&nbsp;</th>
	            </tr>
	        </thead>
	
	        <tbody>
	        {foreach from=${/literal}{$meervoud}{literal} item=o key=k name=fieldthing}
	            <tr class="gradeA" onclick="window.location.href='{$secure_root}{/literal}{$enkelvoud}{literal}/view/{$o.id}'">
	            {/literal}
			{foreach from=$fields key=myId item=i name=foo}
				{if $myId != 'deleted'}
						{literal}<td>{$o.{/literal}{$myId}{literal}}</td>{/literal}
			 	{/if}
			{/foreach}
			{literal}
						<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;"><a href="{$secure_root}{/literal}{$controllerfilename}{literal}/unarchive/{$o.id}"><img src="{$secure_root}images/btn-backlink.png"></a></td>
	            </tr>
	            {/foreach}
	        </tbody>
	    </table>
	</div>
</div>
{/literal}
