{if $controller == 'login'}
	{include file='system/layout/header-login.tpl'}
{else}
	{$header}
{/if}
{include file="system/layout/flash.tpl"}
{$body}
{include file="system/layout/footer.tpl"}