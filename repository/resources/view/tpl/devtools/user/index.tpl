<div class="highlight">
	<div class="demo_jui">
		<p><a href="{$secure_root}{$system}/user/add"><img src="{$secure_root}/cji/system/img/button_add.png" align="absmiddle" height="24px" /> Gebruiker toevoegen</a></p><br/>
	    <table cellpadding="0" cellspacing="0" border="0" id="datatable1" class="display" >
	        <thead>
	            <tr>
					<th>Username</th>
					<th>Role</th>
					<th> </th>
	            </tr>
	        </thead>
	
	        <tbody>
	        {foreach from=$users item=o key=k name=fieldthing}
	            <tr class="gradeA" onclick="window.location.href='{$secure_root}{$system}/user/view/{$o.id}'">
			 		<td>{$o.username}</td>
			 		<td>{$o.role}</td>
					<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;"><a href="{$secure_root}{$system}/user/modify/{$o.id}"><img src="{$secure_root}cji/img/ui-row-edit.png"></a> <a onclick="show_confirm('{$secure_root}{$system}/user/delete/{$o.id}', '{$o.username}')" href="#"><img src="{$secure_root}cji/img/ui-row-delete.png"></a></td>
	            </tr>
	            {/foreach}
	        </tbody>
	    </table>
	</div>
</div>