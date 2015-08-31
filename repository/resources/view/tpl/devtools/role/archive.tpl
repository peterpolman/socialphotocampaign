
<h1>Gearchiveerde Roles</h1>
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
	        {foreach from=$roles item=o key=k name=fieldthing}
	            <tr class="gradeA" onclick="window.location.href='{$secure_root}role/view/{$o.id}'">
	            
													<td>{$o.id}</td>
			 														<td>{$o.role}</td>
			 							
						<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;"><a href="{$secure_root}wame_core_role/unarchive/{$o.id}"><img src="{$secure_root}images/btn-backlink.png"></a></td>
	            </tr>
	            {/foreach}
	        </tbody>
	    </table>
	</div>
</div>
