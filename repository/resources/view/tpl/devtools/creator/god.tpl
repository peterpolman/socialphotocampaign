<h1>God Complex</h1>
<h2>Controller: {$controllername}</h2>
<h3>Success:</h3>
<ul>
{foreach from=$success key=myId item=i name=foo}
<li>{$i}</li>
{/foreach}
</ul>
<h3>Errors:</h3>
<ul>
{foreach from=$errors key=myId item=i name=foo}
<li>{$i}</li>
{/foreach}
</ul>