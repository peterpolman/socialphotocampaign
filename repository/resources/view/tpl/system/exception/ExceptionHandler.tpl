{$header}
<div style="background-color:#DDD;border: 1px solid #000; margin:5px; padding:5px;">
<h2>DEBUG MODUS: {$message}</h2>
<hr>
<pre style="white-space:pre-wrap">
{$error|nl2br}
</pre>
</div>
{include file="$system/layout/footer.tpl"}