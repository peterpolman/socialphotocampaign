{*
	{if $wcms3_access.assignuser.ADMIN == '1'}
	<div class="icon">
		<a href="{$secure_root}{$system}/assignuser/assign/wame_core_role/{$role.id}" class="content">
			<img src="{$secure_root}images/icons/ui-control-access.png" alt="Toegang beheren" />
			<br />Toegang<br />beheren
		</a>
	</div>
	{/if}
	{if $wcms3_access.wame_core_role.UPDATE == '1'}
	<div class="icon">
		<a href="{$secure_root}{$system}/wame_core_role/modify/{$role.id}" class="content">
			<img height="48" src="{$secure_root}images/icons/ui-row-edit_big.png" alt="Role bewerken" />
			<br />Role<br />bewerken
		</a>
	</div>
	{/if} *}

<br clear="all">
<div class="separator"></div>
<div class="add-user">
		<table width="300" cellspacing="0" cellpadding="5">
													  <tr><td width="25%">Role</td><td>{$role.role}</td></tr>
		 			
		</table>
</div>
<div class="separator"></div>