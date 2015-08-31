{if $controller != 'login'}
	{include file='layout/header.tpl'}
{/if}
{if $controller == 'login'}
	{include file='layout/header-login.tpl'}
{/if}

{$header}
{include file='layout/flash.tpl'}
{$body}
{include file='layout/footer.tpl'}