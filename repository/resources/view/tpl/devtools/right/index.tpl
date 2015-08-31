<ul>
{foreach from=$systems item=system}
	<li><a href="{$secure_root}devtools/right/modify/{$system}">Beheer rechten voor: {$system}</a></li>
{/foreach}
</ul>