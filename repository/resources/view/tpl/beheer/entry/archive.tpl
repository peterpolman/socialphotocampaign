
<h1>Gearchiveerde Entries</h1>
<div class="highlight">
	<div class="demo_jui">
	    <table cellpadding="0" cellspacing="0" border="0" id="datatable1" class="display" >
	        <thead>
	            <tr>
														  <th>Id</th>
				 															  <th>Status</th>
				 															  <th>Filename</th>
				 															  <th>First name</th>
				 															  <th>Last name</th>
				 															  <th>Description</th>
				 															  <th>E-mail</th>
				 															  <th>IP</th>
				 															  <th>Newsletter</th>
				 															  <th>Street name</th>
				 															  <th>Street number</th>
				 															  <th>Postal code</th>
				 															  <th>Place</th>
				 															  <th>Date</th>
				 					
				 <th>&nbsp;</th>
	            </tr>
	        </thead>
	
	        <tbody>
	        {foreach from=$entries item=o key=k name=fieldthing}
	            <tr class="gradeA" onclick="window.location.href='{$secure_root}entry/view/{$o.id}'">
	            
													<td>{$o.id}</td>
			 														<td>{$o.status}</td>
			 														<td>{$o.filename}</td>
			 														<td>{$o.first_name}</td>
			 														<td>{$o.last_name}</td>
			 														<td>{$o.description}</td>
			 														<td>{$o.email}</td>
			 														<td>{$o.ip}</td>
			 														<td>{$o.newsletter}</td>
			 														<td>{$o.street_name}</td>
			 														<td>{$o.street_number}</td>
			 														<td>{$o.postal_code}</td>
			 														<td>{$o.place}</td>
			 														<td>{$o.date}</td>
			 							
						<td onclick="if (event.stopPropagation) {ldelim} event.stopPropagation;{rdelim} event.cancelBubble = true; return true;"><a href="{$secure_root}entry/unarchive/{$o.id}"><img src="{$secure_root}images/btn-backlink.png"></a></td>
	            </tr>
	            {/foreach}
	        </tbody>
	    </table>
	</div>
</div>
