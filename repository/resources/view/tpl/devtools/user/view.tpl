{*
	{if $wcms3_access.assignuser.ADMIN == '1'}
	<div class="icon">
		<a href="{$secure_root}{$system}/assignuser/assign/user/{$user.id}" class="content">
			<img src="{$secure_root}images/icons/ui-control-access.png" alt="Toegang beheren" />
			<br />Toegang<br />beheren
		</a>
	</div>
	{/if}
	<div class="icon">
		<a href="{$secure_root}{$system}/user/modify/{$user.id}" class="content">
			<img height="48" src="{$secure_root}cji/img/btn-edit.png" alt="User bewerken" />
			<br />User<br />bewerken
		</a>
	</div>
*}
<br clear="all">
<div class="separator"></div>
<div class="add-user">
		<table width="300" cellspacing="0" cellpadding="5">
													  <tr><td width="25%">Username</td><td>{$user.username}</td></tr>
													  <tr><td width="25%">Role</td><td>{$role}</td></tr>
		 								
		</table>
</div>
<div class="separator"></div>