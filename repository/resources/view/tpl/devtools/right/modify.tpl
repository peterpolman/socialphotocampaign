<script type="text/javascript">
{literal}
$(function() {
$('input[type="checkbox"]').each(function() {
    if ($(this).is(':checked')) {
        $(this).parent().css('background', '#00dd00');
    }
    else {
        $(this).parent().css('background', '#ffffff');
    }
    $(this).click(function() {
        if ($(this).is(':checked')) {
            $(this).parent().css('background', '#00dd00');
        }
        else {
            $(this).parent().css('background', '#ffffff');
        }
    });
});
});
{/literal}
</script>
<form method="post" action="">
<table>

{foreach from=$controllers key=ckey item=controller}
<tr style="background-color:#aaa;">
	<th align="left">{$ckey}</th>
	{foreach from=$roles->getResult() item=role}
		<th>{$role->role}</th>
	{/foreach}
</tr>
	{foreach from=$controller key=k item=control}
	{if is_numeric($k)}
		<tr height="36px">
			<td>{$control}</td>
			{foreach from=$roles->getResult() item=role}
				{if $controller.public }
					<td align="center" style="background-color:#00dd00">Public</td>
				{else}
					{assign var="roleid" value=$role->id}
					<td align="center"><input type="checkbox" name="right[{$ckey}][{$control}][{$role->id}]" value="1" {if isset($rights.$ckey.$control.$roleid) && $rights.$ckey.$control.$roleid == 1}checked="checked" {/if}/></td>
				{/if}
			{/foreach}
		</tr>
	{/if}
	{/foreach}
{/foreach}

</table>

<input name="submit" value="Opslaan" type="submit">
</form>