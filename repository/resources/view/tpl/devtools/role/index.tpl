	{if isset($archive) && $archive == true}
	<div class="icon">
		<a href="{$secure_root}{$system}/role/archive" class="content">
			<img src="{$secure_root}images/icons/ui-archive-client.png" alt="Roles Archief" />
			<br />Roles Archief
		</a>
	</div>{/if}

<div class="highlight">
	<div class="demo_jui">
	    <table cellpadding="0" cellspacing="0" border="0" id="datatable1" class="display" >
	        <thead>
	            <tr>
					<th>Id</th>
				 	<th>Role</th>							
					<th>&nbsp;</th>
	            </tr>
	        </thead>
	
	        <tbody>
	        {foreach from=$roles->getResult() item=o key=k name=fieldthing}
	            <tr class="gradeA" onclick="window.location.href='{$secure_root}{$system}/role/view/{$o->id}'">
					<td>{$o->id}</td>
 					<td>{$o->role}</td>	
					<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;"><a href="{$secure_root}{$system}/role/modify/{$o->id}"><img src="{$secure_root}cji/img/ui-row-edit.png"></a> <a onclick="show_confirm('{$secure_root}{$system}/role/delete/{$o->id}', '{$o->role}')" href="#"><img src="{$secure_root}cji/img/ui-row-delete.png"></a></td>
	            </tr>
	            {/foreach}
	        </tbody>
	    </table>
	</div>
</div>
