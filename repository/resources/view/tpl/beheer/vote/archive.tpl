
<h1>Gearchiveerde Votes</h1>
<div class="highlight">
	<div class="demo_jui">
	    <table cellpadding="0" cellspacing="0" border="0" id="datatable1" class="display" >
	        <thead>
	            <tr>
														  <th>Id</th>
				 															  <th>Entry</th>
				 															  <th>IP</th>
				 															  <th>Date</th>
				 					
				 <th>&nbsp;</th>
	            </tr>
	        </thead>
	
	        <tbody>
	        {foreach from=$votes item=o key=k name=fieldthing}
	            <tr class="gradeA" onclick="window.location.href='{$secure_root}vote/view/{$o.id}'">
	            
													<td>{$o.id}</td>
			 														<td>{$o.entry}</td>
			 														<td>{$o.ip}</td>
			 														<td>{$o.date}</td>
			 							
						<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;"><a href="{$secure_root}vote/unarchive/{$o.id}"><img src="{$secure_root}images/btn-backlink.png"></a></td>
	            </tr>
	            {/foreach}
	        </tbody>
	    </table>
	</div>
</div>
